<?php
namespace Home\Controller;

//
//注释: CustomerApply - 客户申请信息
//
use Home\Controller\BasicController;
use Think\Log;
class CustomerApplyController extends BasicController {

    public function _init() {
        $funcs = $this->getUserRoleList($this->user,array( 'CustomerApply', '/Home/CustomerApply', ));
        if ($funcs)
            $this->assign("rights",  $funcs);
        else{
            $funcs = array(
                         array("key"=>"refresh","func"=>"CustomerApply","Action"=>"refresh") ,
                         array("key"=>"save","func"=>"CustomerApply","Action"=>"save") ,
                         array("key"=>"search","func"=>"/Home/CustomerApply","Action"=>"view") ,
                         array("key"=>"batch_cancel","func"=>"/Home/CustomerApply","Action"=>"delete") ,
                         array("key"=>"status_on_save","func"=>"/Home/CustomerApply","Action"=>"status_on_save") ,
                         array("key"=>"status_on","func"=>"/Home/CustomerApply","Action"=>"status_on")
             );
            $this->assign("rights",  $this->GetUserRights($this->user["id"],$funcs ));
        }
        $this->assign("colshow", $this->GetUserColumnDefine($this->user["id"],"CustomerApply"));
    }

    public function index() {
      $data["pfuncid"] = I("request.pfuncid");
      $data["funcid"] = I("request.funcid");
      $data["zindex"] = I("request.zindex/d");
      if(empty($data["funcid"])) $data["funcid"] = "CustomerApply";
      $this->GetLastUrl($data["funcid"]);

      $func = I("request.func");
      if($func != "saveSelectUser" && $func != "save") {
        $this->GetLastUrl($data["funcid"]);
      }

      switch ($func) {
        case "status_on":
          $this->status_on($data);
          break;
        case "status_on_save":
          $this->status_on_save($data);
          break;
        case "status_off":
          $this->status_off($data);
          break;
        }
    }

    private function status_on($data) {
        $id = I("request.id/d");
        if(!$id) {
            $this->ajaxResult("客户申请信息参数不存在");
        }
        $search = M('customer_apply')->find($id);
        if(!$search) {
            $this->ajaxResult("客户申请资料不存在");
        }
        if($this->user['side'] != '1'){
            $this->ajaxResult('此功能只能由超级管理员操作');
        }
        if($search['status']!='0'){
            $this->ajaxResult("客户申请资料状态已变化，请重新处理");
        }
        $data["search"] = $search;
        $data["id"] = $data["search"]["id"];
        foreach($data as $key=>$val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("CustomerApply:status_on");
        echo $html;
    }

    private function status_on_save($data) {
        $id=I("request.id/d" );
        if(!$id) {
            $this->ajaxResult("客户申请信息参数不存在");
        }
        //id存在时判断数据库内数据是否存在
        $orig = M('customer_apply')->find($id);
        if(empty($orig)) {
            $this->ajaxError("客户申请资料不存在");
        }
        if($this->user['side'] != '1'){
            $this->ajaxResult('此功能只能由超级管理员操作');
        }
        if($orig['status']!='0'){
            $this->ajaxResult("客户资料状态已变化，请重新处理");
        }
        $input = array();
        $needsave = array();

        $input['reply_status'] = I("request.reply_status" );
        $input['reply_content'] = I("request.reply_content" );

        if($input['reply_status'] == '2') {
            if ($input['reply_content'] == '') {
                $this->ajaxResult('拒绝须填写回复内容');
            }
        }

        if($input['reply_status'] == '2'){
            $subject = '请求拒绝';
        }elseif ($input['reply_status'] == '3'){
            $subject = '请求通过';
            $needsave['lock_status'] = 0;
        }else{
            $this->ajaxResult('审核回复未选择');
        }
        
        $input['reply_time'] = date('Y-m-d H:i:s.n');
        $input['reply_user'] = session(C("USER_AUTH_KEY"));
        $input['status'] = '1';
        $input['modify_user'] = session(C("USER_AUTH_KEY"));
        $input['modify_time'] = date('Y-m-d H:i:s.n');
        $needsave['reply_time'] = date('Y-m-d H:i:s.n');
        $needsave['reply_user'] = session(C("USER_AUTH_KEY"));
        $needsave['reply_content'] = $input['reply_content'];
        $needsave['reply_status'] = $input['reply_status'];
        $model = M("customer_apply");
        $model->startTrans();
        //按主键更新customer数据
        $save = M('customer')->where("id='%d'",array($orig['data_id']))->save($needsave);
        //写入customer_apply表
        $result = $model->where("id='%d'",array($id))->save($input);
        //建立操作日志
        $result = $result && createLogCommon('customer_apply',$result,$subject,$input['reply_content']);
        if($result && $save){
            $model->commit();
        }else{
            $model->rollback();
            echo json_encode(array("msg"=>message("客户申请审核发生错误")));
            die;
        }
        //完成后关闭并刷新父窗口
        $this->ajaxReturn($data ['pfuncid'],$data ['funcid'],"refresh", "","closepopup");
        die;
    }

}
