<?php
/**
 * Created by PhpStorm.
 * User: Super
 * Date: 2019-07-17
 * Time: 18:04
 */



namespace Home\Controller;


class GoodsPriceController extends BasicController
{


    public function _init() {
        $funcs = $this->getUserRoleList($this->user,array( ));
        if ($funcs)
            $this->assign("rights",  $funcs);
        else{
            $funcs = array(
            );
            $this->assign("rights",  $this->GetUserRights($this->user["id"],$funcs ));
        }
        $this->assign("colshow", $this->GetUserColumnDefine($this->user["id"],"DayPrice"));
    }

    public function index() {
        $data["pfuncid"] = I("request.pfuncid");
        $data["funcid"] = I("request.funcid");
        $data["zindex"] = I("request.zindex/d");
        if(empty($data["funcid"])) $data["funcid"] = "DayPrice";
        $this->GetLastUrl($data["funcid"]);

        $func = I("request.func");
        if($func != "saveSelectProduct" && $func != "save") {
            $this->GetLastUrl($data["funcid"]);
        }

        switch ($func) {

//// case for add ////
            case "import":
                $this->import($data);
                break;
            case "import_save":
                $this->import_save($data);
                break;
            case "edit":
            case "edit_base":
            case "add":
                $this->add($data);
                break;
            case "save":
                $this->save($data);
                break;
//##combine_for_add_switch_case##

//// case for view ////
            case "view":
                $this->view($data);
                break;
            case "delete":
                $this->order_delete($data);
                break;
            case "confirm":
                $this->order_confirm($data);
                break;
            case "rollback":
                $this->order_rollback($data);
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

        }
    }

    private function import($data){
        //$data['orderid'] = I("get.id");
        foreach($data as $key=>$val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("GoodsPrice:import");
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
            "tx_date" => "交易日期",
            "mat_name" => "货品名称",
            "min_price" => "最小价格",
            "max_price" => "最大价格",
            "uom_weight" => "单位");
        $row_header = 1;
        $row_data = 2;
        $field = array_keys($header);
        $field_count = count($field);

        /* =========================== */
        /* 上传文件 - 读取内容         */
        /* =========================== */
        $h = fopen($file['import']['tmp_name'], 'r');
        $importdatas = array();
        $n = 0;
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
        $lastimportdate = getSystemParameter("goodsprice_lastimportdate");
        $maximmportdate = "";
        $curcount=0;
        foreach ($importdatas as $k => $row) {
            if ($k < $row_data) continue;
            $err_type = "";
            $err_empty = "";
            $err_exist = "";

            if ($row["tx_date"]) {
                if (!verify_value($row["tx_date"], "date")) $err_type = $this->cattext($err_type, $header["tx_date"]);
            } else
                $err_empty = $this->cattext($err_empty, $header["tx_date"]);

            $tx_date =system_format('D',$row["tx_date"]);
            if ($tx_date <=$lastimportdate)
                continue;
            if($maximmportdate < $tx_date )
                $maximmportdate = $tx_date ;

            if (!$row["mat_name"]) $err_empty = $this->cattext($err_empty, $header["mat_name"]);

            if ($row["mat_name"]){

                $namearr=null;
                $goods_style_namelist=M("goods_style")->field("style_name,uom_weight")->select();
                for ($c=0;$c<count($goods_style_namelist);$c++){
                    $namearr[$c]=$goods_style_namelist[$c]["style_name"];

                    /*判断单位与style表中的单位是否一致*/
                    if(!$goods_style_namelist[$c]["uom_weight"]==$row["uom_weight"]){
                        $err_type = $this->cattext($err_type, $header["uom_weight"]);
                    }
                }
                    /*判断名字与style表中的是否一致*/
                if(!in_array($row["mat_name"],$namearr)){
                    $err_type = $this->cattext($err_type, $header["mat_name"]);
                }

            }

            //数值类型校验
            if ($row["min_price"]) {
                if (!verify_value($row["min_price"], "num"))
                    $err_type = $this->cattext($err_type, $header["min_price"]);
                else
                    if ($row["min_price"] <= 0) $err_type = $this->cattext($err_type, $header["min_price"] . "零或负数");
            } else $err_empty = $this->cattext($err_empty, $header["min_price"]);

            //数值类型校验
            if ($row["max_price"]) {
                if (!verify_value($row["max_price"], "num"))
                    $err_type = $this->cattext($err_type, $header["max_price"]);
                else
                    if ($row["max_price"] <= 0) $err_type = $this->cattext($err_type, $header["max_price"] . "零或负数");
            } else $err_empty = $this->cattext($err_empty, $header["max_price"]);

            if ($row["max_price"] && $row["min_price"] && $row["max_price"] < $row["min_price"]) $err_type = $this->cattext($err_type, $header["max_price"] . "小于" . $header["min_price"]);

            if ($err_empty || $err_exist || $err_type) {
                $err .= "第 " . ($i + 1) . " 行校验失败\n";
                if ($err_empty) $err .= "    数据为空: " . $err_empty . "\n";
                if ($err_exist) $err .= "    数据非法：" . $err_exist . "\n";
                if ($err_type) $err .= "    类型非法: " . $err_type . "\n";
            }
            $curcount++;
        }
        if ($err) {
            $this->ajaxResult("导入失败:数据错误\n" . $err);
        }
        if ($curcount==0){
            $this->ajaxResult("导入失败:没有 $lastimportdate 之后的数据\n" . $err);
        }

        /* =========================== */
        /* 上传文件 - 数据导入         */
        /* =========================== */
        $model = M("goods_price");
        $model->startTrans();

        foreach ($importdatas as $row) {
            $save = array();
            $id = 0;
            $g = $model->where("tx_date='%s' and style_code='%s'", array($row['tx_date'], $row['mat_name']))->find();
            if (!$g) {
                $save['tx_date'] = $row['tx_date'];
                //$save['mat_name'] = $row['mat_name'];
                $goods_style=M("goods_style")->field("style_code")->where("style_name='". $row['mat_name']."' and uom_weight='".$row['uom_weight']."'")->find();
                if(empty($goods_style)){
                    $this->ajaxError("货品不存在");
                }

                $save['uom_weight'] = $row['uom_weight'];


                $save["style_code"] = $goods_style["style_code"];
                $save["create_time"] = date('Y-m-d H:i:s');
                $save["create_user"] = session(C("USER_AUTH_KEY"));
            } else {
                $id = $g['id'];
            }
            $save['min_price'] = $row['min_price'];
            $save['max_price'] = $row['max_price'];
            $save["modify_time"] = date('Y-m-d H:i:s');
            $save["modify_user"] = session(C("USER_AUTH_KEY"));

            if (!$g)
                $result = $id = $model->add($save);
            else
                $result = $model->where("id=$id")->save($save);

            if (!$result) {
                break;
            }
        }
        $result = $result && createLogCommon('goods_price', 0, '导入货品价格', $importdatas[0]['tx_date']);

        $result = $result && setsystemparameter("goodsprice_lastimportdate", $maximmportdate);

        if ($result) {
            $model->commit();
        } else {
            $model->rollback();
        }
        $this->ajaxReturn($data ['pfuncid'], $data ['funcid'], "refresh", "", "closepopup");
        die;

    }



//// source for add - begin ////
    private function add($data) {






        //赋初值
        $search["tx_date"] = date('Y-m-d');
        $id = I("request.id/d");
        $style_code=I("request.style_code");
        if($id){
            $sql = table("select * from @goods_price where id=$id");
            $search = M()->query($sql);
            if(!$search)
                die;
            $data["search"] = current($search);
            $data["id"] = $data["search"]["id"];
        }else{
            $goods_style=M("goods_style")->field("style_name")->where("style_code='".$style_code."'")->find();
            $data["parent_id_name"]=$goods_style["style_name"];

            $data["search"] = $search;
        }
        foreach($data as $key=>$val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("GoodsPrice:add");
        echo $html;
    }
    private function save($data) {
        $id=I("request.id/d" );
        //读取页面输入数据
        $tx_date = I("request.tx_date");
        $mat_name = I("request.mat_name");
        $min_price = I("request.min_price/f",0);
        $max_price = I("request.max_price/f",0);
        $goods_code=I("request.parent_id");


        //非页面输入字段
        $input = array();
        //数据有效性校验，非空/数值负数，范围/日期与今日比较
        //数据校验 - 必输项不能为空
        if(!verify_value($tx_date,"empty","","")) $this->ajaxError("日期 不能为空");
        if(!verify_value($min_price,"nagitive","","")) $this->ajaxError("最低价 不能为负数");
        //if ($min_price < 100 || $min_price > 105) $this->ajaxError("校验样例 最低价值在100-105之间");
        if(!verify_value($max_price,"nagitive","","")) $this->ajaxError("最高价 不能为负数");
        //if ($max_price < 100 || $max_price > 105) $this->ajaxError("校验样例 最高价值在100-105之间");
        $model = M("goods_price");

        //页面输入字段
        $input["style_code"]=$goods_code;
        $input["tx_date"] = $tx_date;
        $input["mat_name"] = $mat_name;
        $input["min_price"] = $min_price;
        $input["max_price"] = $max_price;
        $input["modify_user"] = $this->user["id"];
        $input["modify_time"] =  date('Y-m-d H:i:s.n');
        $model->startTrans();
        $result=false;
        //需要存入日志的字段
        $needSave=array(
            'tx_date'=>'日期',
            'mat_name'=>'货品',
            'min_price'=>'最低价',
            'max_price'=>'最高价',
        );
        if(!$id) {
            //新增  建号操作
            $input["create_user"] = $this->user["id"];
            $input["create_time"] = date('Y-m-d H:i:s.n');
            //新增数据 保存数据库
            $result = $id = $model->add($input);
            //建立操作日志
            $result = $result && createLogCommon('goods_price',$id,'新增每日价格区间','',"*",'');
        } else {
            //id存在时判断数据库内数据是否存在
            $orig=$model->where("id='%d'",array($id))->find();
            if(empty($orig)) {
                $this->ajaxError("每日价格区间数据不存在");
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
                $result = $result && createLogCommon('goods_price',$id,'变更每日价格区间',$orig,'','','',$needSave);
            }
        }
        if($result){
            $model->commit();
        }else{
            $model->rollback();
            echo json_encode(array("msg"=>message("每日价格区间保存发生错误")));
            die;
        }
        //完成后跳转
        //转到summary页面
        $this->ajaxReturn($data ['pfuncid'],$data ['funcid'],"refresh", "","closepopup");
        die;
    }
//// source for add - end ////
//##combine_for_add_source##

//// source for status confirm ////

//// source for status changed ////

//// source for status view ////
    private function view($data) {
        $data["p"] = I("request.p/d");
        $data["pagesize"] = I("request.pagesize/d");

        $data["id"] = I("request.id/d");
        $data["no"] = I("request.no");
        if(!$data["id"] && !$data["no"]) {
            $this->ajaxError("每日价格区间信息查询参数非法");
        }

        //condition
        $condition="";
        $joinsql="";
        //select search fields
        $selectmasterfields="@day_price.*";



        $sql = table("select #selectfields# from @day_price  #join# Where #viewkey# #condition# #orderby#");
        if($data["id"])
            $viewkey=table("@day_price.id=$data[id]");
        else
            $viewkey=table("@day_price.id='$data[no]'");
        $sql = str_replace("#selectfields#",table($selectmasterfields),$sql);
        $sql = str_replace("#join#",$joinsql,$sql);
        $sql = str_replace("#viewkey#",$viewkey,$sql);
        $sql = str_replace("#condition#",$condition,$sql);
        $sql = str_replace("#orderby#","",$sql);
        $search = M()->query($sql);
        if(!$search){
            $this->ajaxError("每日价格区间信息信息不存在");
        }
        $data["search"] = current($search);

        //step 步骤样例 - 开始
        $step=array();
        $step1=array();
        step_add( $step, '创建时间',$data["search"]['create_time']  ,true);
        step_add( $step, '已确认'  ,$data["search"]['confirm_time'] ,$data["search"]['status']>=1 && $data["search"]['confirm_status']==1);
        step_add( $step, '已通知'  ,$data["search"]['notice_time']  ,$data["search"]['status']>=1 && $data["search"]['notice_status']==1);
        if($data["search"]['status']>=1 && $data["search"]['stock_status']==1){
            step_add( $step, '处理中'  ,$data["search"]['stock_time'],$data["search"]['status']>=1 && $data["search"]['stock_status']==1);
        }
        step_add( $step, '已完成'  ,$data["search"]['complete_time']   ,$data["search"]['status']==2);
        // 取消/挂起步骤
        step_add( $step1, '取消时间'  ,$data["search"]['cancel_time'] ,$data["search"]['cancel_status']==1);
        step_add( $step1, '挂起时间'  ,$data["search"]['hangup_time'] ,$data["search"]['hangup_status']==1);
        $step=getOrderStep($step,$step1);
        $data["step"]=$step;
        //step 步骤样例 - 结束

        //按tabsheet - 开始
        $data["id"] = $data["search"]["id"];
        //按tabsheet - 结束

        foreach($data as $key=>$val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("GoodsPrice:view");
        echo $html;
    }

    //按tabsheet子程序 - 开始
    //按tabsheet子程序 - 结束

    private function deleteProcess($id,&$type) {

        $smo=M('day_price')->where("id='%d'",array($id))->find();
        if(empty($smo)) {
            $this->ajaxResult("每日价格区间信息数据不存在");
        }
        if($smo['status']!=0){
            $this->ajaxResult("每日价格区间信息状态不能删除");
        }

        $result=true;
        if($smo['status']!=0){
            $result=M('day_price')->where("id='%d'",array($id))->save(array('status'=>8,'cancel_time'=>date('Y-m-d H:i:s'),'cancel_status'=>1));
            $result = $result && createLogCommon('day_price',$id,'取消每日价格区间信息','');
        }else{
            $type=2;
            $result = $result && createLogCommon('day_price',$id,'删除每日价格区间信息','');
            $result = $result && M('day_price')->where("id='%d'",array($id))->delete();
        }
        return $result;
    }

    private function order_delete($data) {

        $id=I("request.id/d" );
        if(!$id) {
            $this->ajaxResult("每日价格区间信息参数不存在");
        }

        $m=M();
        $m->startTrans();
        $type=1;
        $r=$this->deleteProcess($id,$type);

        if($r){
            $m->commit();
        }else{
            $m->rollback();
        }

        if($type==1){
            $this->ajaxResult("", "",  array("_asr.closeTab","_asr.closePopup", "_asr.openLink","_asr.hideConfirm"), array("$('#".$data["funcid"]."-Tab').find('a'), '".$data["funcid"]."'","'".$data["funcid"]."'", "'". U("/Home/DayPrice/index?func=view&id=".$id).  "','".filterFuncId("DayPrice_View","id=$data[id]")."','每日价格区间信息查看', 0","''"));
        }else{
            $this->ajaxResult("", "",  array("_asr.closeTab","_asr.closePopup", "_asr.openLink","_asr.hideConfirm"), array("$('#".$data["funcid"]."-Tab').find('a'), '".$data["funcid"]."'","'".$data["funcid"]."'", "'". U("/Summary/DayPriceSummary/index?func=search&id=".$id).  "','".filterFuncId("DayPriceSummary_View","id=$data[id]")."','每日价格区间信息列表', 0","''"));
        }
        die;
    }


    private function order_rollback($data) {

        $id=I("request.id/d" );
        if(!$id) {
            $this->ajaxResult("每日价格区间信息参数不存在");
        }

        $smo=M('day_price')->where("id='%d'",$id)->find();
        if(empty($smo)) {
            $this->ajaxResult("每日价格区间信息数据不存在");
        }
        if($smo['status']!=1){
            $this->ajaxResult("每日价格区间信息非确认状态，不能反审");
        }

        $model=M('day_price');
        $model->startTrans();
        $result1=$model->where("id='%d'",$id)->save(array(
            'status'=>0,
            'notice_status'=>0,
            'confirm_status'=>0,
        ));

        $result2 = createLogOrder('day_price',$id,'每日价格区间信息反审','');
        if($result1 && $result2){
            $model->commit();
        }else{
            $model->rollback();
        }

        $this->ajaxResult("", "",  array("_asr.hideConfirm","_asr.openLink"), array("''","'','".$data["funcid"]."','刷新', 1"));

    }

    private function order_confirm($data) {

        $id=I("request.id/d" );
        if(!$id) {
            $this->ajaxResult("每日价格区间信息参数不存在");
        }

        $smo=M('day_price')->where("id='%d'",$id)->find();
        if(empty($smo)) {
            $this->ajaxResult("每日价格区间信息数据不存在");
        }
        if($smo['status']!=0 ){
            $this->ajaxResult("每日价格区间信息非待确认状态，不能确认");
        }


        $model=M('day_price');
        $model->startTrans();
        $result1=$model->where("id='%d'",$id)->save(array(
            'status'=>1,
            'notice_time'=>date('Y-m-d H:i:s'),
            'notice_status'=>1,
            'confirm_status'=>1,
            'confirm_time'=>date('Y-m-d H:i:s'),
        ));

        $result2 = createLogOrder('day_price',$id,'每日价格区间信息确认','');
        if($result1 && $result2){
            $model->commit();
        }else{
            $model->rollback();
        }
        $this->ajaxResult("", "",  array("_asr.hideConfirm","_asr.openLink"), array("''","'','".$data["funcid"]."','刷新', 1"));
    }


    private function add1($data) {
        $id = I("request.id/d");
        if(!$id){
            //读接入参数
            $category_code = I("request.category_code");
            $style_code = I("request.style_code");
            $style_name = I("request.style_name");
            $prefix = I("request.prefix");
            $uom_qty = I("request.uom_qty");
            $uom_weight = I("request.uom_weight",0);
            $uom_bulkcargo = I("request.uom_bulkcargo");
            $tax_rate = I("request.tax_rate");
            $assign_threshold = I("request.assign_threshold");


            //赋初值
            $search["category_code"] = $category_code?$category_code:"";
            $search["style_code"] = $style_code?$style_code:"";
            $search["style_name"] = $style_name?$style_name:"";
            $search["uom_qty"] = $uom_qty?$uom_qty:"";
            $search["prefix"] = $prefix?$prefix:"";
            $search["uom_weight"] = $uom_weight?$uom_weight:"";
            $search["uom_bulkcargo"] = $uom_bulkcargo?$uom_bulkcargo:"";  //第一个选项
            $search["tax_rate"] = $tax_rate?$tax_rate:"";
            $search["assign_threshold"] = $assign_threshold?$assign_threshold:"";
        } else {

            $search = M("goods_price")->find($id);

            $goods_style=M("goods_style")->field("style_name")->where("style_code='".$search['style_code']."'")->find();
            $data["parent_id_name"]=$goods_style["style_name"];
            $data["id"] = $search["id"];
        }
        $data["search"] = $search;
        //检查popup返回name
        if($data['search']['parent_id']){
            $ret=M( "goods_price" )
                ->field("name")
                ->where("id='".$data['search']['parent_id']."'")
                ->find();
            if($ret){
                $data["search"]["parent_id_name"] = $ret["name"];
            }
        }
        foreach($data as $key=>$val) {
            $this->assign($key, $val);
        }

        $html = $this->fetch("GoodsPrice:add");    /*跳转到QuestionCategory 目录下的add*/
        echo $html;
    }


    private function save1($data) {

        $id = I("request.id/d");
        $style_code=I("request.parent_id");
        $min_price=I("request.min_price");
        $max_price=I("request.max_price");

        if(empty($min_price)){
            $this->ajaxError("最低价格不能为空");
        }
        if(empty($max_price)){
            $this->ajaxError("最高价格不能为空");
        }

        $input["style_code"]=$style_code;
        $input["min_price"]=$min_price;
        $input["max_price"]=$max_price;

        if($id){
            $model=M("goods_price");
            $old=$model->where("id='%d'",array($id))->find();
            if(empty($old)) {
                $this->ajaxError("用户信息数据不存在");
            }
            $input["modify_user"] = $this->user["id"];
            $input["modify_time"] =  date('Y-m-d H:i:s.n');
            $result = $model->where("id = $id")->save($input);

            $result = $result && createLogCommon('goods_price',$id,'变更货品价格区间',$old,'','','code');
        }else{




        }



        $input["create_user"] = $this->user["id"];
        $input["create_time"] = date('Y-m-d H:i:s.n');










    }






}

