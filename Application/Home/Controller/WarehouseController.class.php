<?php
namespace Home\Controller;

//
//注释: Warehouse - 仓库信息
//
use Home\Controller\BasicController;
use Think\Log;
class WarehouseController extends BasicController {

    public function _init() {
        $funcs = $this->getUserRoleList($this->user,array( 'Warehouse', '/Home/Warehouse', ));
        if ($funcs)
            $this->assign("rights",  $funcs);
        else{
            $funcs = array(
                         array("key"=>"refresh","func"=>"Warehouse","Action"=>"refresh") ,
                         array("key"=>"status_off","func"=>"/Home/Warehouse","Action"=>"status_off") ,
                         array("key"=>"import","func"=>"/Home/Warehouse","Action"=>"import") ,
                         array("key"=>"save","func"=>"/Home/Warehouse","Action"=>"save") ,
                         array("key"=>"search","func"=>"/Home/Warehouse","Action"=>"view") ,
                         array("key"=>"detail_import","func"=>"/Home/Warehouse","Action"=>"detail_import") ,
                         array("key"=>"detail_select","func"=>"/Home/Warehouse","Action"=>"select_product") ,
                         array("key"=>"tabcunchuka","func"=>"/Home/Warehouse","Action"=>"tabcunchuka") ,
                         array("key"=>"tabcunchukamadan","func"=>"/Home/Warehouse","Action"=>"tabcunchukamadan") ,
                         array("key"=>"tabcunchukaduohao","func"=>"/Home/Warehouse","Action"=>"tabcunchukaduohao") ,
                         array("key"=>"tabcunchukataizhang","func"=>"/Home/Warehouse","Action"=>"tabcunchukataizhang") ,
                         array("key"=>"tabcunchukajiasuo","func"=>"/Home/Warehouse","Action"=>"tabcunchukajiasuo") ,
                         array("key"=>"tabcaozuorizhi","func"=>"/Home/Warehouse","Action"=>"tabcaozuorizhi") ,
                         array("key"=>"edit_base","func"=>"/Home/Warehouse","Action"=>"edit_base") ,
                         array("key"=>"order_edit","func"=>"/Home/Warehouse","Action"=>"edit_base") ,
                         array("key"=>"order_delete","func"=>"/Home/Warehouse","Action"=>"delete") ,
                         array("key"=>"status_on","func"=>"/Home/Warehouse","Action"=>"status_on") ,
                         array("key"=>"status_off","func"=>"/Home/Warehouse","Action"=>"status_off")
             );
            $this->assign("rights",  $this->GetUserRights($this->user["id"],$funcs ));
        }
        $this->assign("colshow", $this->GetUserColumnDefine($this->user["id"],"Warehouse"));
    }

    public function index() {
      $data["pfuncid"] = I("request.pfuncid");
      $data["funcid"] = I("request.funcid");
      $data["zindex"] = I("request.zindex/d");
      if(empty($data["funcid"])) $data["funcid"] = "Warehouse";
      $this->GetLastUrl($data["funcid"]);

      $func = I("request.func");
      if($func != "saveSelectProduct" && $func != "save") {
        $this->GetLastUrl($data["funcid"]);
      }

      switch ($func) {

//// case for add ////
        case "edit":
        case "edit_base":
        case "add":
          $this->add($data);
          break;
        case "save":
          $this->save($data);
          break;
//// case for import ////
        case "import":
          $this->import($data);
          break;
        case "import_save":
          $this->import_save($data);
          break;
//// case for status_on ////
        case "status_on":
          $this->status_on($data);
          break;
        case "status_on_save":
          $this->status_on_save($data);
          break;
//// case for status_off ////
        case "status_off":
          $this->status_off($data);
          break;
        case "status_off_save":
          $this->status_off_save($data);
          break;
//##combine_for_add_switch_case##

//// case for view ////
        case "view":
          $this->view($data);
          break;
        case "delete":
          $this->order_delete($data);
          break;
        case "detail_delete":
          $this->detail_delete($data);
          break;
        case "detail_add":
          $this->selectProduct($data);
          break;
        case "saveSelectProduct":
          $this->saveSelectProduct($data);
          break;
        default :
          $this->ajax_refresh($data ['funcid']);
          break;

      }
    }

//// source for add - begin ////
    private function add($data) {
       $id = I("request.id/d");
       if(!$id){
          //读接入参数
          $code = I("request.code");
          $name = I("request.name");
          $phone = I("request.phone");
          $org_id = I("request.org_id/d",0);
          $contacts = I("request.contacts");
          $address = I("request.address");
          //赋初值
          $search["code"] = $code?$code:"";
          $search["name"] = $name?$name:"";
          $search["phone"] = $phone?$phone:"";
          $search["org_id"] = $org_id?$org_id:"";
          $search["contacts"] = $contacts?$contacts:"";
          $search["address"] = $address?$address:"";
       } else {
          $search = M('warehouse')->find($id);
          if(!$search){
              $this->ajaxResult("仓库信息数据不存在" );
          }
          $data["id"] = $search["id"];
       }
       $data["search"] = $search;
       foreach($data as $key=>$val) {
           $this->assign($key, $val);
       }
       $html = $this->fetch("Warehouse:add");
       echo $html;
    }
    private function save($data) {
       $id=I("request.id/d" );
       //读取页面输入数据
       $code = I("request.code");
       $name = I("request.name");
       $phone = I("request.phone");
       $org_id = I("request.org_id/d",0);
       $contacts = I("request.contacts");
       $address = I("request.address");
       $status = I("request.status");
       //非页面输入字段
       $input = array();
       //数据有效性校验，非空/数值负数，范围/日期与今日比较
       //数据校验 - 必输项不能为空
       if(!verify_value($code,"empty","","")) $this->ajaxError("仓库编码 不能为空");
       if(!verify_value($name,"empty","","")) $this->ajaxError("仓库名称 不能为空");
       $model = M("warehouse");
       //判断 code 是否重复建立
       $orig = $model->where("code='$code'".($id?" and id!=$id":""))->find();
       if ($orig) $this->ajaxError("仓库编码 $code 已存在");
       //页面输入字段
       $input["code"] = $code;
       $input["name"] = $name;
       $input["phone"] = $phone;
       $input["org_id"] = $org_id;
       $input["contacts"] = $contacts;
       $input["address"] = $address;
       $input["modify_user"] = session(C("USER_AUTH_KEY"));
       $input["modify_time"] =  date('Y-m-d H:i:s.n');
       $input["status"] = $status;
       $model->startTrans();
       $result=false;
       //需要存入日志的字段
       $needSave=array(
            'code'=>'仓库编码',
            'name'=>'仓库名称',
            'org_id'=>'库链',
            'phone'=>'联系电话',
            'contacts'=>'联系人员',
            'address'=>'联系地址',
       );
       if(!$id) {
          //新增  建号操作
          $input["create_user"] = session(C("USER_AUTH_KEY"));
          $input["create_time"] = date('Y-m-d H:i:s.n');
          //新增数据 保存数据库
          $result = $id = $model->add($input);
          //建立操作日志
          $result = $result && createLogCommon('warehouse',$id,'新增仓库信息','',"*",'code');
       } else {
          //id存在时判断数据库内数据是否存在
          $orig=$model->where("id='%d'",array($id))->find();
          if(empty($orig)) {
               $this->ajaxError("仓库信息数据不存在");
          }
          //按主键更新数据
          $result = $model->where("id = $id")->save($input);
          $isSaveLog=false;
          foreach ($needSave as $key=>$v) {
              if($orig[$key]!=$input[$key]) {
                  $isSaveLog=true;
                  break;
              }
          }
          if($isSaveLog){
            //建立操作日志
            $result = $result && createLogCommon('warehouse',$id,'变更仓库信息',$orig,'','','code',$needSave);
          }
       }
       if($result){
           $model->commit();
       }else{
           $model->rollback();
           echo json_encode(array("msg"=>message("仓库信息保存发生错误")));
           die;
       }
       //完成后跳转
       $this->ajaxReturn($data ['pfuncid'],$data ['funcid'],"refresh", "","closepopup", 1 );
       //转到view页面
       $this->ajaxReturn("","",U("Warehouse/index?func=view&id=$id&pfuncid=".$data ['pfuncid']), tabtitle('仓库',$input["code"] ) );
       die;
    }
//// source for add - end ////
//// source for import - begin ////
    private function import($data){
      $data['orderid'] = I("get.id");
      foreach($data as $key=>$val) {
        $this->assign($key, $val);
      }
      $html = $this->fetch("Warehouse:import");
      echo $html;
    }
    private function cattext($string, $txt)
    {
        if($string)$string.=",";
        return $string.$txt;
    }
    private function import_save($data)
    {
        $orderid = I("request.orderid/d");
        $file = $_FILES;
        /* ========================================== */
        /* 上传文件 - 判断文件类型csv读取内容         */
        /* ========================================== */
        if (empty($file)) {
            $this->ajaxResult("导入失败:请上传csv文件");
        }
        if (isset($file["import"]) && $file["import"]["error"] == 0) {
            if (is_uploaded_file($file['import']['tmp_name'])) {
                if (substr($file['import']['name'], -4) != ".csv") {
                    $this->ajaxResult("导入失败:请上传csv文件");
                }
            }
        }
        /* ==================================================== */
        /* 上传文件 - 标题行列内容、列数、标题行、数据起始行    */
        /* ==================================================== */
        $header = array(
            "code" => "仓库编码",
            "name" => "仓库名称",
            "phone" => "联系电话",
            "org_id" => "库链",
            "contacts" => "联系人员",
            "address" => "联系地址",
                       );
        $row_header = 1;
        $row_data = 2;
        $field = array_keys($header);
        $field_count = count($field);
        /* =========================== */
        /* 上传文件 - 读取内容         */
        /* =========================== */
        $h = fopen($file['import']['tmp_name'], 'r');
        $importdatas = array();
        $n = 1;
        while ($row = fgetcsv($h)) {
            if ($n < $row_header) {
                $n++;
                continue;
            }
            $num = count($row);
            if ($n == $row_header) {
                if ($field_count != $num) $this->ajaxResult("导入失败:标题列数与模板不一致");
            } else if ($num > $field_count) {
                $num = $field_count;
            }
            for ($i = 0; $i < $num; $i++) {
                if ($n == 1) continue;
                $importdatas[$n][$field[$i]] = mb_convert_encoding($row[$i], 'utf-8', 'gbk');
            }
            $n++;
        }
        fclose($h);
        if ($n < $row_data) $this->ajaxResult("导入失败:文件内没有数据");
        /* =========================== */
        /* 上传文件 - 标题校验         */
        /* =========================== */
        $err = "";
        foreach ($importdatas[$row_header] as $key => $value) {
            if ($header[$key] != $value) $err = $this->cattext($err, $value);
        }
        if ($err) $this->ajaxResult("导入失败:标题列[$err]与模板定义不一致");
        /* =========================== */
        /* 上传文件 - 数据校验         */
        /* =========================== */
        $i = 0;
        foreach ($importdatas as $k => $row) {
            if ($k >= $row_data) {
               $err_type = "";
               $err_empty = "";
               $err_exist = "";
               if(!verify_value($row["code"],"empty","","")) $err_empty=$this->cattext($err_empty, $header["code"]);
               if(!verify_value($row["name"],"empty","","")) $err_empty=$this->cattext($err_empty, $header["name"]);
               if (strlen($row["org_id"])>0) {
               //数值类型校验
                  if (!verify_value($row["org_id"], "num"))
                      $err_type = $this->cattext($err_type, $header["org_id"]);
                  else
                      if ($row["org_id"] < 0) $err_exist = $this->cattext($err_exist, $header["org_id"] . "是负数");
               }
               if ($err_empty || $err_exist || $err_type) {
                   $err .= "第 " . ($i + $row_data) . " 行校验失败\n";
                   if ($err_empty) $err .= "    数据为空: " . $err_empty . "\n";
                   if ($err_exist) $err .= "    数据非法：" . $err_exist . "\n";
                   if ($err_type) $err .= "    类型非法: " . $err_type . "\n";
               }
           }
           $i++;
       }
       //判断 code 是否重复建立
       $i = 0;
       foreach ($importdatas as $k => $row) {
           if ($k >= $row_data){
               $j=0;
               foreach ($importdatas as $k1 => $row1) {
                  if ($k1 >= $row_data and $k1>$k ){
                     if($row["code"]==$row1["code"]){
                         $err .= "第 " . ($i + $row_data). " 与 " . ($j + $row_data). " 行 ".$header["code"] ."\n";
                     }
                  }
                  $j++;
               }
           }
           $i++;
       }
       if ($err) {
           $this->ajaxResult("数据重复:\n" . $err);
       }
       $model = M("warehouse");
       //关键字重复导入覆盖方式
       $overwrite=true;
       if(!$overwrite){ //非覆盖方式检查是否重复
          //判断 code 是否重复建立
          $i = 0;
          foreach ($importdatas as $k => $row) {
             if ($k >= $row_data){
                $m = $model->where("code='".$row["code"]."'")->find();
                if ($m) $err .= "第 " . ($i + $row_data). " 行 ".$header["code"]."\n";
             }
             $i++;
          }
          if ($err) {
              $this->ajaxResult("数据存在:\n" . $err);
          }
       }
       /* =========================== */
       /* 上传文件 - 数据存储         */
       /* =========================== */
        $model->startTrans();
        $total=0;
        $new=0;
        $edit=0;
        foreach ($importdatas as $row) {
            $input = array();
            $id = 0;
            $m = array();
            //非导入字段-赋初值
            //导入字段
            $input["code"] = $row["code"];
            $input["name"] = $row["name"];
            $input["phone"] = $row["phone"];
            $input["org_id"] = $row["org_id"];
            $input["contacts"] = $row["contacts"];
            $input["address"] = $row["address"];
            //modify_user/time字段
            $input["modify_user"] = session(C("USER_AUTH_KEY"));
            $input["modify_time"] =  date('Y-m-d H:i:s.n');
            //检查是否存在
            //样例 $m = $model->where("code='".$row["code"]."'")->find();
            $orig = $model->where("code='".$row["code"]."'")->find();
            if (!$orig) {
                  //新增
                $input["create_user"] = session(C("USER_AUTH_KEY"));
                $input["create_time"] =  date('Y-m-d H:i:s.n');
                $result = $id = $model->add($input);
                $new++;
                //建立操作日志
                    $result = $result && createLogCommon('warehouse', $id, '数据导入(新增)',$orig,'','','code',$header);
            } else {
                  //覆盖
                $id = $orig['id'];
                $result = $model->where("id=$id")->save($input);
                $edit++;
                //建立操作日志
                $result = $result && createLogCommon('warehouse',$id,'数据导入(覆盖)',$orig,'','','code',$header);
            }
            if (!$result) {
                break;
            }
            $total++;
        }
        if ($result) {
            $model->commit();
        } else {
            $model->rollback();
        }
        $this->ajax_hideConfirm();
        $this->ajax_closePopup($data ['funcid']);
        $this->ajax_refresh($data ['pfuncid']);
        $this->ajaxResult("本次导入 $total 条, 新增 $new 条, 覆盖 $edit 条");
        die;
        //$this->ajaxReturn($data ['pfuncid'], $data ['funcid'], "refresh", "", "closepopup");
    }
//// source for import - end ////
//// source for status_on - begin ////
    private function status_on($data) {
        $id = I("request.id/d");
        if(!$id) {
             $this->ajaxResult("仓库信息参数不存在");
        }
        $search = M('warehouse')->find($id);
        if(!$search)
            $this->ajaxResult("仓库信息不存在");
        if($search['status']=='7'){
            $this->ajaxResult("仓库信息已取消");
        }
        if($search['status']!='0'){
            $this->ajaxResult("仓库信息状态已变化，请重新处理");
        }
        $data["search"] = $search;
        $data["id"] = $data["search"]["id"];
        foreach($data as $key=>$val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("Warehouse:status_on");
        echo $html;
    }
    private function status_on_save($data) {
       $id=I("request.id/d" );
       if(!$id) {
           $this->ajaxResult("仓库信息参数不存在");
       }
       //id存在时判断数据库内数据是否存在
       $orig=M("warehouse")->where("id='%d'",array($id))->find();
       if(empty($orig)) {
           $this->ajaxError("仓库信息数据不存在");
       }
       if($orig['status']=='7'){
           $this->ajaxResult("仓库信息已取消");
       }
       if($orig['status']!='0'){
           $this->ajaxResult("仓库信息状态已变化，请重新处理");
       }
       $reason_tag=I("request.reason_tag" );
       $reason=I("request.reason" );
       $statusdesc="状态[有效], ";
       $input["status"] = "1";  // "文本类型"
       $content=$statusdesc."备注: ";
       if($reason_tag){
            $content.=$reason_tag;
            if ($reason)$content.=", ".$reason;
       }else{
             $content.=$reason;
       }
       $input["modify_user"] = session(C("USER_AUTH_KEY"));
       $input["modify_time"] = date('Y-m-d H:i:s.n');
       $model = M("warehouse");
       $model->startTrans();
       //按主键更新数据
       $result = $model->where("id = $id")->save($input);
       //建立操作日志
          $result = $result && createLogCommon('warehouse',$id,'状态调整',$content);
       if($result){
           $model->commit();
       }else{
           $model->rollback();
           echo json_encode(array("msg"=>message("仓库信息保存发生错误")));
           die;
       }
       //完成后关闭并刷新父窗口
       $this->ajaxReturn($data ['pfuncid'],$data ['funcid'],"refresh", "","closepopup");
       die;
    }
//// source for status_on - end ////
//// source for status_off - begin ////
    private function status_off($data) {
        $id = I("request.id/d");
        if(!$id) {
             $this->ajaxResult("仓库信息参数不存在");
        }
        $search = M('warehouse')->find($id);
        if(!$search)
            $this->ajaxResult("仓库信息不存在");
        if($search['status']=='7'){
            $this->ajaxResult("仓库信息已取消");
        }
        if($search['status']!='1'){
            $this->ajaxResult("仓库信息状态已变化，请重新处理");
        }
        $data["search"] = $search;
        $data["id"] = $data["search"]["id"];
        foreach($data as $key=>$val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("Warehouse:status_off");
        echo $html;
    }
    private function status_off_save($data) {
       $id=I("request.id/d" );
       if(!$id) {
           $this->ajaxResult("仓库信息参数不存在");
       }
       //id存在时判断数据库内数据是否存在
       $orig=M("warehouse")->where("id='%d'",array($id))->find();
       if(empty($orig)) {
           $this->ajaxError("仓库信息数据不存在");
       }
       if($orig['status']=='7'){
           $this->ajaxResult("仓库信息已取消");
       }
       if($orig['status']!='1'){
           $this->ajaxResult("仓库信息状态已变化，请重新处理");
       }
       $reason_tag=I("request.reason_tag" );
       $reason=I("request.reason" );
       if(!($reason_tag.$reason)){
           $this->ajaxResult("仓库信息状态回退，需注明原因");
       }
       $statusdesc="退回状态[无效], ";
       $input["status"] = "0";  // "文本类型"
       $content=$statusdesc."备注: ";
       if($reason_tag){
            $content.=$reason_tag;
            if ($reason)$content.=", ".$reason;
       }else{
             $content.=$reason;
       }
       $input["modify_user"] = session(C("USER_AUTH_KEY"));
       $input["modify_time"] = date('Y-m-d H:i:s.n');
       $model = M("warehouse");
       $model->startTrans();
       //按主键更新数据
       $result = $model->where("id = $id")->save($input);
       //建立操作日志
          $result = $result && createLogCommon('warehouse',$id,'状态调整',$content);
       if($result){
           $model->commit();
       }else{
           $model->rollback();
           echo json_encode(array("msg"=>message("仓库信息保存发生错误")));
           die;
       }
       //完成后关闭并刷新父窗口
       $this->ajaxReturn($data ['pfuncid'],$data ['funcid'],"refresh", "","closepopup");
       die;
    }
//// source for status_off - end ////
//##combine_for_add_source##

//// source for status confirm ////

//// source for status view ////
    private function view($data) {
        $data["p"] = I("request.p/d");
        $data["pagesize"] = I("request.pagesize/d");

        $data["id"] = I("request.id/d");
        $data["no"] = I("request.no");
        if(!$data["id"] && !$data["no"]) {
           $this->ajaxError("仓库信息查询参数非法");
        }

        //condition
        $condition="";
        $joinsql="";
        //select search fields
        $selectmasterfields="@warehouse.*";



        $sql = table("select #selectfields# from @warehouse  #join# Where #viewkey# #condition# #orderby#");
        if($data["id"])
           $viewkey=table("@warehouse.id=$data[id]");
        else
           $viewkey=table("@warehouse.code='$data[no]'");
        $sql = str_replace("#selectfields#",table($selectmasterfields),$sql);
        $sql = str_replace("#join#",$joinsql,$sql);
        $sql = str_replace("#viewkey#",$viewkey,$sql);
        $sql = str_replace("#condition#",$condition,$sql);
        $sql = str_replace("#orderby#","",$sql);
        $search = M()->query($sql);
        if(!$search){
           $this->ajaxError("仓库信息信息不存在");
        }
        $data["search"] = current($search);


        //按tabsheet - 开始
        $data["id"] = $data["search"]["id"];
        $data["search"]["_tab"] = $this->tabsheet_check(I("request._tab"));
        $page_size=$data["pagesize"] ;//session("Warehouse-".$data["search"]["_tab"]."-PageSize");
        switch($data["search"]["_tab"])
        {

          case "kucunxinxi":
               $data = $this->tab_kucunxinxi_stock($page_size,$data);
               break;
          case "cunchuka":
               $data = $this->tab_cunchuka_storecard($page_size,$data);
               break;
          case "cunchukamadan":
               $data = $this->tab_cunchukamadan_storecard_package($page_size,$data);
               break;
          case "cunchukaduohao":
               $data = $this->tab_cunchukaduohao_storecard_buttress($page_size,$data);
               break;
          case "cunchukataizhang":
               $data = $this->tab_cunchukataizhang_storecard_movement($page_size,$data);
               break;
          case "cunchukajiasuo":
               $data = $this->tab_cunchukajiasuo_storecard_lock($page_size,$data);
               break;
          case "caozuorizhi":
               $data = $this->tab_caozuorizhi_log_common($page_size,$data);
               break;

        }
        $data["search"]["_tab_".$data["search"]["_tab"]."_p"]=$data["p"];
        $data["search"]["_tab_".$data["search"]["_tab"]."_psize"]=$data["page_size"];
        //session("Warehouse-".$data["search"]["_tab"]."-PageSize", $data["page_size"]);
        //按tabsheet - 结束

        foreach($data as $key=>$val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("Warehouse:view");
        echo $html;
    }

    //按tabsheet子程序 - 开始

    private function tab_kucunxinxi_stock($tab_pagesize,$data)
    {
        $orderby="";
        $joinsql="";


        $condition = "" ;


        //select detail fields
        $selectfields="@stock.id ";
        $selectfields.=",@stock.org_id ";
        $selectfields.=",@stock.customer_id ";
        $selectfields.=",@stock.warehouse_code ";
        $selectfields.=",@stock.style_code ";
        $selectfields.=",@stock.weight ";
        $selectfields.=",@stock.qty ";
        $selectfields.=",@stock.bulkcargo ";
        $selectfields.=",@stock.lock_weight ";
        $selectfields.=",@stock.lock_qty ";
        $selectfields.=",@stock.lock_bulkcargo ";
        $selectfields.=",@stock.create_time ";
        $selectfields.=",@stock.modify_time ";

        $viewkey="@stock.warehouse_code='".$data["search"]["code"]."'";
     if(!$viewkey)
           $this->ajaxError("查询参数非法");
     //      die;

        $page_size = $tab_pagesize;
        if (!$page_size) {
            $page_size = 10;
        }

        $count_sql = table("select count(*) as cnt from @stock  #join# where #viewkey# #condition#");
        $search_sql = table("select #selectfields# from @stock  #join# Where #viewkey# #condition# #orderby#");

        $viewkey = table($viewkey);
        $condition = table($condition);
        $orderby= table($orderby);
        $selectfields= table($selectfields);

        $count_sql = str_replace("#condition#",$condition,$count_sql);
        $count_sql = str_replace("#viewkey#",$viewkey,$count_sql);
        $count_sql = str_replace("#join#",$joinsql,$count_sql);

        $count = M()->query($count_sql);
        $count = $count[0]["cnt"];

        if($count < $page_size)
            $tmp = 1;
        else {
            $tmp = intval($count / $page_size);
            if($count % $page_size != 0) {
                $tmp++;
            }
        }
        if(!$data["p"]) {
            $data["p"] = 1;
        }
        if($data["p"] > $tmp) {
            $data["p"] = $tmp;
        }

        $sql = str_replace("#selectfields#",$selectfields,$search_sql);
        $sql = str_replace("#join#",$joinsql,$sql);
        $sql = str_replace("#viewkey#",$viewkey,$sql);
        $sql = str_replace("#condition#",$condition,$sql);
        $sql = str_replace("#orderby#",$orderby,$sql);
        $sql .= " LIMIT ". (($data["p"] - 1) * $page_size). ", $page_size";
        $data["list"] = M()->query($sql);
        $pageClass = new \Think\Page($count,$page_size);
        $pageClass->rollPage = 8;
        $data["page"] = $pageClass->show_drp($data["funcid"],"");
        $data["page_size"] = $page_size;

        return $data;
    }

    private function tab_cunchuka_storecard($tab_pagesize,$data)
    {
        $orderby="";
        $joinsql="";


        $condition = "" ;


        //select detail fields
        $selectfields="@storecard.status ";
        $selectfields.=",@storecard.id ";
        $selectfields.=",@storecard.org_id ";
        $selectfields.=",@storecard.customer_id ";
        $selectfields.=",@storecard.storecard_no ";
        $selectfields.=",@storecard.warehouse_code ";
        $selectfields.=",@storecard.customer_name ";
        $selectfields.=",@storecard.goods_id ";
        $selectfields.=",@storecard.goods_no ";
        $selectfields.=",@storecard.goods_name ";
        $selectfields.=",@storecard.style_info ";
        $selectfields.=",@storecard.brand ";
        $selectfields.=",@storecard.producing_area ";
        $selectfields.=",@storecard.style_code ";
        $selectfields.=",@storecard.weight ";
        $selectfields.=",@storecard.qty ";
        $selectfields.=",@storecard.bulkcargo ";
        $selectfields.=",@storecard.lock_weight ";
        $selectfields.=",@storecard.lock_qty ";
        $selectfields.=",@storecard.lock_bulkcargo ";
        $selectfields.=",@storecard.uom_qty ";
        $selectfields.=",@storecard.uom_weight ";
        $selectfields.=",@storecard.uom_bulkcargo ";
        $selectfields.=",@storecard.contact_id ";
        $selectfields.=",@storecard.contact_no ";
        $selectfields.=",@storecard.create_time ";
        $selectfields.=",@storecard.modify_time ";

        $viewkey="@storecard.warehouse_code='".$data["search"]["code"]."'";
     if(!$viewkey)
           $this->ajaxError("查询参数非法");
     //      die;

        $page_size = $tab_pagesize;
        if (!$page_size) {
            $page_size = 10;
        }

        $count_sql = table("select count(*) as cnt from @storecard  #join# where #viewkey# #condition#");
        $search_sql = table("select #selectfields# from @storecard  #join# Where #viewkey# #condition# #orderby#");

        $viewkey = table($viewkey);
        $condition = table($condition);
        $orderby= table($orderby);
        $selectfields= table($selectfields);

        $count_sql = str_replace("#condition#",$condition,$count_sql);
        $count_sql = str_replace("#viewkey#",$viewkey,$count_sql);
        $count_sql = str_replace("#join#",$joinsql,$count_sql);

        $count = M()->query($count_sql);
        $count = $count[0]["cnt"];

        if($count < $page_size)
            $tmp = 1;
        else {
            $tmp = intval($count / $page_size);
            if($count % $page_size != 0) {
                $tmp++;
            }
        }
        if(!$data["p"]) {
            $data["p"] = 1;
        }
        if($data["p"] > $tmp) {
            $data["p"] = $tmp;
        }

        $sql = str_replace("#selectfields#",$selectfields,$search_sql);
        $sql = str_replace("#join#",$joinsql,$sql);
        $sql = str_replace("#viewkey#",$viewkey,$sql);
        $sql = str_replace("#condition#",$condition,$sql);
        $sql = str_replace("#orderby#",$orderby,$sql);
        $sql .= " LIMIT ". (($data["p"] - 1) * $page_size). ", $page_size";
        $data["list"] = M()->query($sql);
        $pageClass = new \Think\Page($count,$page_size);
        $pageClass->rollPage = 8;
        $data["page"] = $pageClass->show_drp($data["funcid"],"");
        $data["page_size"] = $page_size;

        return $data;
    }

    private function tab_cunchukamadan_storecard_package($tab_pagesize,$data)
    {
        $orderby="";
        $joinsql="";


        $condition = "" ;


        //select detail fields
        $selectfields="@storecard_package.status ";
        $selectfields.=",@storecard_package.id ";
        $selectfields.=",@storecard_package.org_id ";
        $selectfields.=",@storecard_package.customer_id ";
        $selectfields.=",@storecard_package.storecard_id ";
        $selectfields.=",@storecard_package.storecard_no ";
        $selectfields.=",@storecard_package.package_no ";
        $selectfields.=",@storecard_package.customer_name ";
        $selectfields.=",@storecard_package.package_from ";
        $selectfields.=",@storecard_package.package_orig ";
        $selectfields.=",@storecard_package.warehouse_code ";
        $selectfields.=",@storecard_package.location_code ";
        $selectfields.=",@storecard_package.location_futures ";
        $selectfields.=",@storecard_package.stock_date ";
        $selectfields.=",@storecard_package.stock_order ";
        $selectfields.=",@storecard_package.arrival_type ";
        $selectfields.=",@storecard_package.stock_type ";
        $selectfields.=",@storecard_package.carno ";
        $selectfields.=",@storecard_package.weight_in ";
        $selectfields.=",@storecard_package.qty_in ";
        $selectfields.=",@storecard_package.bulkcargo_in ";
        $selectfields.=",@storecard_package.weight_out ";
        $selectfields.=",@storecard_package.qty_out ";
        $selectfields.=",@storecard_package.bulkcargo_out ";
        $selectfields.=",@storecard_package.weight ";
        $selectfields.=",@storecard_package.qty ";
        $selectfields.=",@storecard_package.bulkcargo ";
        $selectfields.=",@storecard_package.create_time ";
        $selectfields.=",@storecard_package.modify_time ";
        $selectfields.=",@storecard_package.is_lock ";
        $selectfields.=",@storecard_package.lock_time ";

        $viewkey="@storecard_package.warehouse_code='".$data["search"]["code"]."'";
     if(!$viewkey)
           $this->ajaxError("查询参数非法");
     //      die;

        $page_size = $tab_pagesize;
        if (!$page_size) {
            $page_size = 10;
        }

        $count_sql = table("select count(*) as cnt from @storecard_package  #join# where #viewkey# #condition#");
        $search_sql = table("select #selectfields# from @storecard_package  #join# Where #viewkey# #condition# #orderby#");

        $viewkey = table($viewkey);
        $condition = table($condition);
        $orderby= table($orderby);
        $selectfields= table($selectfields);

        $count_sql = str_replace("#condition#",$condition,$count_sql);
        $count_sql = str_replace("#viewkey#",$viewkey,$count_sql);
        $count_sql = str_replace("#join#",$joinsql,$count_sql);

        $count = M()->query($count_sql);
        $count = $count[0]["cnt"];

        if($count < $page_size)
            $tmp = 1;
        else {
            $tmp = intval($count / $page_size);
            if($count % $page_size != 0) {
                $tmp++;
            }
        }
        if(!$data["p"]) {
            $data["p"] = 1;
        }
        if($data["p"] > $tmp) {
            $data["p"] = $tmp;
        }

        $sql = str_replace("#selectfields#",$selectfields,$search_sql);
        $sql = str_replace("#join#",$joinsql,$sql);
        $sql = str_replace("#viewkey#",$viewkey,$sql);
        $sql = str_replace("#condition#",$condition,$sql);
        $sql = str_replace("#orderby#",$orderby,$sql);
        $sql .= " LIMIT ". (($data["p"] - 1) * $page_size). ", $page_size";
        $data["list"] = M()->query($sql);
        $pageClass = new \Think\Page($count,$page_size);
        $pageClass->rollPage = 8;
        $data["page"] = $pageClass->show_drp($data["funcid"],"");
        $data["page_size"] = $page_size;

        return $data;
    }

    private function tab_cunchukaduohao_storecard_buttress($tab_pagesize,$data)
    {
        $orderby="";
        $joinsql="";


        $condition = "" ;


        //select detail fields
        $selectfields="@storecard_buttress.id ";
        $selectfields.=",@storecard_buttress.org_id ";
        $selectfields.=",@storecard_buttress.customer_id ";
        $selectfields.=",@storecard_buttress.package_id ";
        $selectfields.=",@storecard_buttress.package_no ";
        $selectfields.=",@storecard_buttress.buttress_no ";
        $selectfields.=",@storecard_buttress.batchno ";
        $selectfields.=",@storecard_buttress.warehouse_code ";
        $selectfields.=",@storecard_buttress.location_code ";
        $selectfields.=",@storecard_buttress.weight_in ";
        $selectfields.=",@storecard_buttress.qty_in ";
        $selectfields.=",@storecard_buttress.bulkcargo_in ";
        $selectfields.=",@storecard_buttress.weight_out ";
        $selectfields.=",@storecard_buttress.qty_out ";
        $selectfields.=",@storecard_buttress.bulkcargo_out ";
        $selectfields.=",@storecard_buttress.weight ";
        $selectfields.=",@storecard_buttress.qty ";
        $selectfields.=",@storecard_buttress.bulkcargo ";
        $selectfields.=",@storecard_buttress.is_lock ";
        $selectfields.=",@storecard_buttress.lock_time ";

        $viewkey="@storecard_buttress.warehouse_code='".$data["search"]["code"]."'";
     if(!$viewkey)
           $this->ajaxError("查询参数非法");
     //      die;

        $page_size = $tab_pagesize;
        if (!$page_size) {
            $page_size = 10;
        }

        $count_sql = table("select count(*) as cnt from @storecard_buttress  #join# where #viewkey# #condition#");
        $search_sql = table("select #selectfields# from @storecard_buttress  #join# Where #viewkey# #condition# #orderby#");

        $viewkey = table($viewkey);
        $condition = table($condition);
        $orderby= table($orderby);
        $selectfields= table($selectfields);

        $count_sql = str_replace("#condition#",$condition,$count_sql);
        $count_sql = str_replace("#viewkey#",$viewkey,$count_sql);
        $count_sql = str_replace("#join#",$joinsql,$count_sql);

        $count = M()->query($count_sql);
        $count = $count[0]["cnt"];

        if($count < $page_size)
            $tmp = 1;
        else {
            $tmp = intval($count / $page_size);
            if($count % $page_size != 0) {
                $tmp++;
            }
        }
        if(!$data["p"]) {
            $data["p"] = 1;
        }
        if($data["p"] > $tmp) {
            $data["p"] = $tmp;
        }

        $sql = str_replace("#selectfields#",$selectfields,$search_sql);
        $sql = str_replace("#join#",$joinsql,$sql);
        $sql = str_replace("#viewkey#",$viewkey,$sql);
        $sql = str_replace("#condition#",$condition,$sql);
        $sql = str_replace("#orderby#",$orderby,$sql);
        $sql .= " LIMIT ". (($data["p"] - 1) * $page_size). ", $page_size";
        $data["list"] = M()->query($sql);
        $pageClass = new \Think\Page($count,$page_size);
        $pageClass->rollPage = 8;
        $data["page"] = $pageClass->show_drp($data["funcid"],"");
        $data["page_size"] = $page_size;

        return $data;
    }

    private function tab_cunchukataizhang_storecard_movement($tab_pagesize,$data)
    {
        $orderby="";
        $joinsql="";


        $condition = "" ;


        //select detail fields
        $selectfields="@storecard_movement.id ";
        $selectfields.=",@storecard_movement.org_id ";
        $selectfields.=",@storecard_movement.customer_id ";
        $selectfields.=",@storecard_movement.customer_name ";
        $selectfields.=",@storecard_movement.storecard_id ";
        $selectfields.=",@storecard_movement.storecard_no ";
        $selectfields.=",@storecard_movement.warehouse_code ";
        $selectfields.=",@storecard_movement.order_id ";
        $selectfields.=",@storecard_movement.order_no ";
        $selectfields.=",@storecard_movement.order_type ";
        $selectfields.=",@storecard_movement.order_date ";
        $selectfields.=",@storecard_movement.goods_id ";
        $selectfields.=",@storecard_movement.goods_no ";
        $selectfields.=",@storecard_movement.goods_name ";
        $selectfields.=",@storecard_movement.style_info ";
        $selectfields.=",@storecard_movement.brand ";
        $selectfields.=",@storecard_movement.producing_area ";
        $selectfields.=",@storecard_movement.batchno ";
        $selectfields.=",@storecard_movement.style_code ";
        $selectfields.=",@storecard_movement.to_customer_id ";
        $selectfields.=",@storecard_movement.to_customer_name ";
        $selectfields.=",@storecard_movement.weight ";
        $selectfields.=",@storecard_movement.qty ";
        $selectfields.=",@storecard_movement.bulkcargo ";
        $selectfields.=",@storecard_movement.store_weight ";
        $selectfields.=",@storecard_movement.store_qty ";
        $selectfields.=",@storecard_movement.store_bulkcargo ";
        $selectfields.=",@storecard_movement.storelock_weight ";
        $selectfields.=",@storecard_movement.storelock_qty ";
        $selectfields.=",@storecard_movement.storelock_bulkcargo ";
        $selectfields.=",@storecard_movement.create_time ";

        $viewkey="@storecard_movement.warehouse_code='".$data["search"]["code"]."'";
     if(!$viewkey)
           $this->ajaxError("查询参数非法");
     //      die;

        $page_size = $tab_pagesize;
        if (!$page_size) {
            $page_size = 10;
        }

        $count_sql = table("select count(*) as cnt from @storecard_movement  #join# where #viewkey# #condition#");
        $search_sql = table("select #selectfields# from @storecard_movement  #join# Where #viewkey# #condition# #orderby#");

        $viewkey = table($viewkey);
        $condition = table($condition);
        $orderby= table($orderby);
        $selectfields= table($selectfields);

        $count_sql = str_replace("#condition#",$condition,$count_sql);
        $count_sql = str_replace("#viewkey#",$viewkey,$count_sql);
        $count_sql = str_replace("#join#",$joinsql,$count_sql);

        $count = M()->query($count_sql);
        $count = $count[0]["cnt"];

        if($count < $page_size)
            $tmp = 1;
        else {
            $tmp = intval($count / $page_size);
            if($count % $page_size != 0) {
                $tmp++;
            }
        }
        if(!$data["p"]) {
            $data["p"] = 1;
        }
        if($data["p"] > $tmp) {
            $data["p"] = $tmp;
        }

        $sql = str_replace("#selectfields#",$selectfields,$search_sql);
        $sql = str_replace("#join#",$joinsql,$sql);
        $sql = str_replace("#viewkey#",$viewkey,$sql);
        $sql = str_replace("#condition#",$condition,$sql);
        $sql = str_replace("#orderby#",$orderby,$sql);
        $sql .= " LIMIT ". (($data["p"] - 1) * $page_size). ", $page_size";
        $data["list"] = M()->query($sql);
        $pageClass = new \Think\Page($count,$page_size);
        $pageClass->rollPage = 8;
        $data["page"] = $pageClass->show_drp($data["funcid"],"");
        $data["page_size"] = $page_size;

        return $data;
    }

    private function tab_cunchukajiasuo_storecard_lock($tab_pagesize,$data)
    {
        $orderby="";
        $joinsql="";


        $condition = "" ;


        //select detail fields
        $selectfields="@storecard_lock.id ";
        $selectfields.=",@storecard_lock.org_id ";
        $selectfields.=",@storecard_lock.customer_id ";
        $selectfields.=",@storecard_lock.customer_name ";
        $selectfields.=",@storecard_lock.storecard_id ";
        $selectfields.=",@storecard_lock.package_id ";
        $selectfields.=",@storecard_lock.buttress_id ";
        $selectfields.=",@storecard_lock.warehouse_code ";
        $selectfields.=",@storecard_lock.order_id ";
        $selectfields.=",@storecard_lock.order_no ";
        $selectfields.=",@storecard_lock.order_type ";
        $selectfields.=",@storecard_lock.order_date ";
        $selectfields.=",@storecard_lock.to_customer_id ";
        $selectfields.=",@storecard_lock.to_customer_name ";
        $selectfields.=",@storecard_lock.lock_weight ";
        $selectfields.=",@storecard_lock.lock_qty ";
        $selectfields.=",@storecard_lock.lock_bulkcargo ";
        $selectfields.=",@storecard_lock.storelock_weight ";
        $selectfields.=",@storecard_lock.storelock_qty ";
        $selectfields.=",@storecard_lock.storelock_bulkcargo ";
        $selectfields.=",@storecard_lock.store_weight ";
        $selectfields.=",@storecard_lock.store_qty ";
        $selectfields.=",@storecard_lock.store_bulkcargo ";
        $selectfields.=",@storecard_lock.release_user ";
        $selectfields.=",@storecard_lock.release_time ";
        $selectfields.=",@storecard_lock.create_time ";

        $viewkey="@storecard_lock.warehouse_code='".$data["search"]["code"]."'";
     if(!$viewkey)
           $this->ajaxError("查询参数非法");
     //      die;

        $page_size = $tab_pagesize;
        if (!$page_size) {
            $page_size = 10;
        }

        $count_sql = table("select count(*) as cnt from @storecard_lock  #join# where #viewkey# #condition#");
        $search_sql = table("select #selectfields# from @storecard_lock  #join# Where #viewkey# #condition# #orderby#");

        $viewkey = table($viewkey);
        $condition = table($condition);
        $orderby= table($orderby);
        $selectfields= table($selectfields);

        $count_sql = str_replace("#condition#",$condition,$count_sql);
        $count_sql = str_replace("#viewkey#",$viewkey,$count_sql);
        $count_sql = str_replace("#join#",$joinsql,$count_sql);

        $count = M()->query($count_sql);
        $count = $count[0]["cnt"];

        if($count < $page_size)
            $tmp = 1;
        else {
            $tmp = intval($count / $page_size);
            if($count % $page_size != 0) {
                $tmp++;
            }
        }
        if(!$data["p"]) {
            $data["p"] = 1;
        }
        if($data["p"] > $tmp) {
            $data["p"] = $tmp;
        }

        $sql = str_replace("#selectfields#",$selectfields,$search_sql);
        $sql = str_replace("#join#",$joinsql,$sql);
        $sql = str_replace("#viewkey#",$viewkey,$sql);
        $sql = str_replace("#condition#",$condition,$sql);
        $sql = str_replace("#orderby#",$orderby,$sql);
        $sql .= " LIMIT ". (($data["p"] - 1) * $page_size). ", $page_size";
        $data["list"] = M()->query($sql);
        $pageClass = new \Think\Page($count,$page_size);
        $pageClass->rollPage = 8;
        $data["page"] = $pageClass->show_drp($data["funcid"],"");
        $data["page_size"] = $page_size;

        return $data;
    }

    private function tab_caozuorizhi_log_common($tab_pagesize,$data)
    {
        $orderby="";
        $joinsql="";


        $condition = "" ;


        //select detail fields
        $selectfields="@log_common.status ";
        $selectfields.=",@log_common.id ";
        $selectfields.=",@log_common.create_time ";
        $selectfields.=",@log_common.data_id ";
        $selectfields.=",@log_common.data_code ";
        $selectfields.=",@log_common.subject ";
        $selectfields.=",@log_common.content ";

        $viewkey="@log_common.data_id='".$data["search"]["id"]."'";
        $viewkey.=" and @log_common.type='warehouse'";
     if(!$viewkey)
           $this->ajaxError("查询参数非法");
     //      die;

        $page_size = $tab_pagesize;
        if (!$page_size) {
            $page_size = 10;
        }

        $count_sql = table("select count(*) as cnt from @log_common  #join# where #viewkey# #condition#");
        $search_sql = table("select #selectfields# from @log_common  #join# Where #viewkey# #condition# #orderby#");
        $orderby="order by @log_common.id desc";

        $viewkey = table($viewkey);
        $condition = table($condition);
        $orderby= table($orderby);
        $selectfields= table($selectfields);

        $count_sql = str_replace("#condition#",$condition,$count_sql);
        $count_sql = str_replace("#viewkey#",$viewkey,$count_sql);
        $count_sql = str_replace("#join#",$joinsql,$count_sql);

        $count = M()->query($count_sql);
        $count = $count[0]["cnt"];

        if($count < $page_size)
            $tmp = 1;
        else {
            $tmp = intval($count / $page_size);
            if($count % $page_size != 0) {
                $tmp++;
            }
        }
        if(!$data["p"]) {
            $data["p"] = 1;
        }
        if($data["p"] > $tmp) {
            $data["p"] = $tmp;
        }

        $sql = str_replace("#selectfields#",$selectfields,$search_sql);
        $sql = str_replace("#join#",$joinsql,$sql);
        $sql = str_replace("#viewkey#",$viewkey,$sql);
        $sql = str_replace("#condition#",$condition,$sql);
        $sql = str_replace("#orderby#",$orderby,$sql);
        $sql .= " LIMIT ". (($data["p"] - 1) * $page_size). ", $page_size";
        $data["list"] = M()->query($sql);
        $pageClass = new \Think\Page($count,$page_size);
        $pageClass->rollPage = 8;
        $data["page"] = $pageClass->show_drp($data["funcid"],"");
        $data["page_size"] = $page_size;

        return $data;
    }



    private function tabsheet_check($itab)
    {
        $idefault="kucunxinxi";
        switch($itab)
        {

          case "kucunxinxi":
          case "cunchuka":
          case "cunchukamadan":
          case "cunchukaduohao":
          case "cunchukataizhang":
          case "cunchukajiasuo":
          case "caozuorizhi":

              break;
          default:
              $itab=$idefault;
              break;
         }
        return $itab;
    }
    //按tabsheet子程序 - 结束

    private function deleteProcess($id) {
        $type=1;
        $smo=M('warehouse')->where("id='%d'",array($id))->find();
        if(empty($smo)) {
            $this->ajaxResult("仓库信息数据不存在");
        }
        if($smo['status']!=0){
            $this->ajaxResult("仓库信息状态不能删除");
        }

        $result=true;
        $result = $result && createLogCommon('warehouse',$id,($smo['status']?'取消信息':'删除记录'),'');
        if($smo['status']!=0){
            $result = $result && M('warehouse')->where("id='%d'",array($id))->save(array('status'=>8,'cancel_time'=>date('Y-m-d H:i:s'),'cancel_status'=>1));
        }else{
            $result = $result && M('warehouse')->where("id='%d'",array($id))->delete();
        }
        return $result;
    }

    private function order_delete($data) {

        $id=I("request.id/d" );
        $type=I("request.type/d" );
        if(!$id) {
             $this->ajaxResult("仓库信息参数不存在");
        }

        $m=M();
        $m->startTrans();
        $r=$this->deleteProcess($id);
        if($r){
            $m->commit();
        }else{
            $m->rollback();
        }

        $this->ajax_hideConfirm();
        if(!$type){
            $this->ajax_closeTab($data ['funcid']);
        }
        $this->ajax_refresh($data ['pfuncid']);
        $this->ajaxResult();
        die;
    }


}
