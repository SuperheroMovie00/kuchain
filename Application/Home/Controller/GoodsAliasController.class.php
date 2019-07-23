<?php
namespace Home\Controller;

//
//注释: GoodsAlias - 货品别名信息
//
use Home\Controller\BasicController;
use Think\Log;
class GoodsAliasController extends BasicController {

    public function _init() {
        $funcs = $this->getUserRoleList($this->user,array( ));
        if ($funcs)
            $this->assign("rights",  $funcs);
        else{
            $funcs = array(
             );
            $this->assign("rights",  $this->GetUserRights($this->user["id"],$funcs ));
        }
        $this->assign("colshow", $this->GetUserColumnDefine($this->user["id"],"GoodsAlias"));
    }

    public function index() {
      $data["pfuncid"] = I("request.pfuncid");
      $data["funcid"] = I("request.funcid");
      $data["zindex"] = I("request.zindex/d");
      if(empty($data["funcid"])) $data["funcid"] = "GoodsAlias";
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
        $side=$this->user["side"];
        if($side!='2'){
            $this->ajaxError("你没有权限操作别名");
        }
       $id = I("request.id/d");
       $pid=I("request.pid/d");


       if(!$id){
          //读接入参数
          $type = I("request.type");
          $alias = I("request.alias");
          $org_id = I("request.org_id");
          $value = I("request.value");
          //赋初值
          $search["type"] = $type?$type:"0";  //第一个选项
          $search["alias"] = $alias?$alias:"";
          $search["org_id"] = $org_id?$org_id:"";  //第一个选项
          $search["value"] = $value?$value:"";
       }
       if($pid){

           $goods=M("goods")->field("style_code")->find($pid);
           $goods_style_name=  M(goods_style)->field("style_name,style_code")->where("style_code='".$goods["style_code"]."'")->find();
           $data["id"] = $search["id"];
       }
       else if ($id) {
          $search = M(goods_alias)->find($id);
          $goods_style_name = M(goods_style)->field("style_name,style_code")->find($search["goods_id"]);
          if(!$search){
              $this->ajaxResult("货品别名数据不存在" );
          }
          $data["id"] = $search["id"];
       }
       $search["parent_id_name"]=$goods_style_name["style_name"];
        $search["parent_id_code"]=$goods_style_name["style_code"];
       $data["search"] = $search;
       foreach($data as $key=>$val) {
           $this->assign($key, $val);
       }
       $html = $this->fetch("GoodsAlias:add");
       echo $html;
    }


    private function save($data) {

        $side=$this->user["side"];

        if($side!='2'){
            $this->ajaxError("你没有权限操作别名");
        }

        $goods_style_code=I("request.parent_id");
        if(empty($goods_style_code)){
            $goods_style_code=I("request.parent_id_code");
        }

        $id=I("request.id/d" );
        //读取页面输入数据
        $type = I("request.type");
        $alias = I("request.alias");
        $org_id = $this->user["org_id"];
        $value = I("request.value");

        //非页面输入字段
        $input = array();
        //数据有效性校验，非空/数值负数，范围/日期与今日比较
        //数据校验 - 必输项不能为空
        if(!verify_value($type,"empty","","")) $this->ajaxError("类型 不能为空");

        $goods_style=M("goods_style")->field("id")->where("style_code= '".$goods_style_code."'")->find();
        if(empty($goods_style)){
            $this->ajaxError("货品详情不存在");
        }else{
            if ($goods_style["status"]=='0'){
                $this->ajaxError("货品详情状态无效");
            }
            $goods_style_id=$goods_style["id"];
        }
        if($org_id){
           $ret = M("org")
                  ->field("id,code,name,status")
                  ->where(" id='$org_id' ")->find();
           if(!$ret)  $this->ajaxError("库链不存在");
           if($ret['status']==0 || $ret['status']==8)   $this->ajaxError("库链非有效状态");
       }
       $model = M("goods_alias");


       //判断 type 是否重复建立
        $orig = $model->where("type='$type' and value='$value' and goods_id= '$goods_style_id'")->find();
        if(!empty($orig)){
                $this->ajaxError("相同货物，别名类型和别名内容不能同时相同");
        }

       //页面输入字段
       $input["goods_id"]=$goods_style_id;
       $input["type"] = $type;
       $input["alias"] = $alias;
       $input["org_id"] = $org_id;
       $input["value"] = $value;
       $input["modify_user"] = session(C("USER_AUTH_KEY"));
       $input["modify_time"] =  date('Y-m-d H:i:s.n');
       $model->startTrans();
       $result=false;
       //需要存入日志的字段
       $needSave=array(
            'type'=>'类型',
            'alias'=>'别名',
            'org_id'=>'库链',
            'value'=>'标准',
       );
       if(!$id) {
          //新增  建号操作
          $input["create_user"] = session(C("USER_AUTH_KEY"));
          $input["create_time"] = date('Y-m-d H:i:s.n');
          //新增数据 保存数据库
          $result = $id = $model->add($input);
          //建立操作日志
          $result = $result && createLogCommon('goods_alias',$id,'新增货品别名','',"*",'');
       } else {
          //id存在时判断数据库内数据是否存在
          $orig=$model->where("id='%d'",array($id))->find();
          if(empty($orig)) {
               $this->ajaxError("货品别名数据不存在");
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
            $result = $result && createLogCommon('goods_alias',$id,'变更货品别名',$orig,'','','',$needSave);
          }
       }
       if($result){
           $model->commit();
       }else{
           $model->rollback();
           echo json_encode(array("msg"=>message("货品别名保存发生错误")));
           die;
       }
       //完成后跳转
       //转到summary页面
       $this->ajaxReturn($data ['pfuncid'],$data ['funcid'],"refresh", "","closepopup");
       die;
    }
//// source for add - end ////
//// source for status_on - begin ////
    private function status_on($data) {
        $id = I("request.id/d");
        if(!$id) {
             $this->ajaxResult("货品别名参数不存在");
        }
        $search = M('goods_alias')->find($id);
        if(!$search)
            $this->ajaxResult("货品别名不存在");
        if($search['status']=='7'){
            $this->ajaxResult("货品别名已取消");
        }
        if($search['status']!='0'){
            $this->ajaxResult("货品别名状态已变化，请重新处理");
        }
        $data["search"] = $search;
        $data["id"] = $data["search"]["id"];
        foreach($data as $key=>$val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("GoodsAlias:status_on");
        echo $html;
    }
    private function status_on_save($data) {
       $id=I("request.id/d" );
       if(!$id) {
           $this->ajaxResult("货品别名参数不存在");
       }
       //id存在时判断数据库内数据是否存在
       $orig=M("goods_alias")->where("id='%d'",array($id))->find();
       if(empty($orig)) {
           $this->ajaxError("货品别名数据不存在");
       }
       if($orig['status']=='7'){
           $this->ajaxResult("货品别名已取消");
       }
       if($orig['status']!='0'){
           $this->ajaxResult("货品别名状态已变化，请重新处理");
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
       $model = M("goods_alias");
       $model->startTrans();
       //按主键更新数据
       $result = $model->where("id = $id")->save($input);
       //建立操作日志
          $result = $result && createLogCommon('goods_alias',$id,'状态调整',$content);
       if($result){
           $model->commit();
       }else{
           $model->rollback();
           echo json_encode(array("msg"=>message("货品别名保存发生错误")));
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
             $this->ajaxResult("货品别名参数不存在");
        }
        $search = M('goods_alias')->find($id);
        if(!$search)
            $this->ajaxResult("货品别名不存在");
        if($search['status']=='7'){
            $this->ajaxResult("货品别名已取消");
        }
        if($search['status']!='1'){
            $this->ajaxResult("货品别名状态已变化，请重新处理");
        }
        $data["search"] = $search;
        $data["id"] = $data["search"]["id"];
        foreach($data as $key=>$val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("GoodsAlias:status_off");
        echo $html;
    }
    private function status_off_save($data) {
       $id=I("request.id/d" );
       if(!$id) {
           $this->ajaxResult("货品别名参数不存在");
       }
       //id存在时判断数据库内数据是否存在
       $orig=M("goods_alias")->where("id='%d'",array($id))->find();
       if(empty($orig)) {
           $this->ajaxError("货品别名数据不存在");
       }
       if($orig['status']=='7'){
           $this->ajaxResult("货品别名已取消");
       }
       if($orig['status']!='1'){
           $this->ajaxResult("货品别名状态已变化，请重新处理");
       }
       $reason_tag=I("request.reason_tag" );
       $reason=I("request.reason" );
       if(!($reason_tag.$reason)){
           $this->ajaxResult("货品别名状态回退，需注明原因");
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
       $model = M("goods_alias");
       $model->startTrans();
       //按主键更新数据
       $result = $model->where("id = $id")->save($input);
       //建立操作日志
          $result = $result && createLogCommon('goods_alias',$id,'状态调整',$content);
       if($result){
           $model->commit();
       }else{
           $model->rollback();
           echo json_encode(array("msg"=>message("货品别名保存发生错误")));
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
           $this->ajaxError("货品别名信息查询参数非法");
        }

        //condition
        $condition="";
        $joinsql="";
        //select search fields
        $selectmasterfields="@goods_alias.*";



        $sql = table("select #selectfields# from @goods_alias  #join# Where #viewkey# #condition# #orderby#");
        if($data["id"])
           $viewkey=table("@goods_alias.id=$data[id]");
        else
           $viewkey=table("@goods_alias.id='$data[no]'");
        $sql = str_replace("#selectfields#",table($selectmasterfields),$sql);
        $sql = str_replace("#join#",$joinsql,$sql);
        $sql = str_replace("#viewkey#",$viewkey,$sql);
        $sql = str_replace("#condition#",$condition,$sql);
        $sql = str_replace("#orderby#","",$sql);
        $search = M()->query($sql);
        if(!$search){
           $this->ajaxError("货品别名信息信息不存在");
        }
        $data["search"] = current($search);

        //step 步骤样例 - 开始
        $step=array();
        $step1=array();
        step_add( $step, '创建时间',$data["search"]['create_time']  ,true);
        step_add( $step, '已确认'  ,$data["search"]['confirm_time'] ,$data["search"]['status']>=1 && $data["search"]['confirm_status']==1);
        step_add( $step, '已通知'  ,$data["search"]['notice_time']  ,$data["search"]['status']>=1 && $data["search"]['notice_status']==1);
        //if($data["search"]['status']>=1 && $data["search"]['stock_status']==1){
            step_add( $step, '处理中'  ,$data["search"]['stock_time'],$data["search"]['status']>=1 && $data["search"]['stock_status']==1);
        //}
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
        $html = $this->fetch("GoodsAlias:view");
        echo $html;
    }

    //按tabsheet子程序 - 开始
    //按tabsheet子程序 - 结束

    private function deleteProcess($id) {
        $type=1;
        $smo=M('goods_alias')->where("id='%d'",array($id))->find();
        if(empty($smo)) {
            $this->ajaxResult("货品别名信息数据不存在");
        }
        if($smo['status']!=0){
            $this->ajaxResult("货品别名信息状态不能删除");
        }

        $result=true;
        $result = $result && createLogCommon('goods_alias',$id,($smo['status']?'取消信息':'删除记录'),'');
        if($smo['status']!=0){
            $result = $result && M('goods_alias')->where("id='%d'",array($id))->save(array('status'=>8,'cancel_time'=>date('Y-m-d H:i:s'),'cancel_status'=>1));
        }else{
            $result = $result && M('goods_alias')->where("id='%d'",array($id))->delete();
        }
        return $result;
    }

    private function order_delete($data) {

        $id=I("request.id/d" );
        $type=I("request.type/d" );
        if(!$id) {
             $this->ajaxResult("货品别名信息参数不存在");
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
