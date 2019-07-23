<?php namespace Home\Controller;
//
//注释: OrgCustomerSummary - 库链/客户对应列表
//
use Home\Controller\BasicController;
use Think\Log;
class OrgCustomerController extends BasicController {

    public function _init() {
        $funcs = $this->getUserRoleList($this->user,array( 'OrgCustomer', '/Home/OrgCustomer', ));
        if ($funcs)
            $this->assign("rights",  $funcs);
        else{
            $funcs = array(
                array("key"=>"refresh","func"=>"OrgCustomerSummary","Action"=>"refresh") ,
                array("key"=>"search","func"=>"OrgCustomerSummary","Action"=>"search") ,
                array("key"=>"export","func"=>"OrgCustomerSummary","Action"=>"export") ,
                array("key"=>"master_view","func"=>"/Home/OrgCustomer","Action"=>"view") ,
                array("key"=>"status_on","func"=>"/Home/OrgCustomer","Action"=>"status_on") ,
                array("key"=>"status_off","func"=>"/Home/OrgCustomer","Action"=>"status_off"),
                array("key"=>"save","func"=>"/Home/OrgCustomer","Action"=>"save"),
                array("key"=>"add","func"=>"/Home/OrgCustomer","Action"=>"add")
            );
            $this->assign("rights",  $this->GetUserRights($this->user["id"],$funcs ));
        }
        $this->assign("colshow", $this->GetUserColumnDefine($this->user["id"],"OrgCustomer"));
    }

    public function index()
    {
        $data["pfuncid"] = I("request.pfuncid");
        $data["funcid"] = I("request.funcid");
        $data["zindex"] = I("request.zindex/d");
        if (empty($data["funcid"])) $data["funcid"] = "OrgCustomer";
        $this->GetLastUrl($data["funcid"]);
        $func = I("request.func");

        switch ($func) {
            case "add":
                $this->add($data);
                break;
            case "save":
                $this->save($data);
                break;
            default :
                $this->ajax_refresh($data ['funcid']);
                break;
        }
    }


    private function add($data)
    {
        $id = I('request.id/d');

        if(!$id)
        {
            $this->ajaxResult("库链/客户对应信息参数不存在");
        }
        if($this->user['side'] != 2)
        {
            $this->ajaxResult('登入者身份不正确');
        }
        $model=M("org_customer");
        $info=$model->where(array("id"=>$id))->find();
        if(!$info)
        {
            $this->ajaxResult("库链/客户对应信息不存在");
        }
        if($info['org_id']){
            $org_name = M("org")->field('name')->where(array("id"=>$info['org_id']))->find();
            $info['org_name'] = $org_name['name'];
        }
        if($info['customer_id']){
            $customer_name = M("customer")->field('name')->where(array("id"=>$info['org_id']))->find();
            $info['customer_name'] = $customer_name['name'];
        }

        $data["search"] = $info;
        $data["id"] = $data["search"]["id"];
        foreach ($data as $key => $val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("OrgCustomer:add");
        echo $html;

    }

    private function save($data)
    {
        $id = I('request.id/d');

        if(!$id)
        {
            $this->ajaxResult("库链/客户对应信息参数不存在");
        }
        if($this->user['side'] != 2)
        {
            $this->ajaxResult('登入者身份不正确');
        }
        $model=M("org_customer");
        $info=$model->where(array("id"=>$id))->find();
        if(!$info)
        {
            $this->ajaxResult("库链/客户对应信息不存在");
        }

        $input['local_id'] = trim(I('request.local_id'));
        $input['local_name'] = trim(I('request.local_name'));
        $input['status'] = I('request.status/d');
        $input['auth_time'] = date('Y-m-d H:i:s.n');
        $input['auth_user'] = session(C("USER_AUTH_KEY"));
        $input['create_time'] = date('Y-m-d H:i:s.n');
        $input['create_user'] = session(C("USER_AUTH_KEY"));
        if(!$input['local_id']){
            $this->ajaxResult('线下ID不能为空');
        }
        if(!$input['local_name']){
            $this->ajaxResult('线下名称不能为空');
        }

        $result = false;
        //需要存入日志的字段
        $needSave = array(
            'org_id' => '库链id',
            'customer_id' => '客户id',
            'local_id' => '线下ID',
            'local_name' => '线下名称',
            'status' => '状态',
        );
        $org_customer_id['id'] = array('neq',$info['id']);
        $where['org_id'] = $info['org_id'];
        $where['local_id'] = $input['local_id'];
        $where['customer_id'] = $info['customer_id'];
        $list = $model->where($where)->where($org_customer_id)->find();
        if($list){
            $this->ajaxResult('数据已存在，请勿重复');
        }

        $where['local_name'] = $input['local_name'];
        $test = $model->where($where)->where($org_customer_id)->find();
        if($test){
            $this->ajaxResult('数据已存在，请勿重复');
        }

        $model->startTrans();
        $result = $model->where("id='%d'",array($info['id']))->save($input);
        $subject = '登记库链/客户对应信息';
        $content = '登记'.$info['id'].'的信息';
        if($result){
            //建立操作日志
            $result = $result && createLogCommon('org_customer',$id,$subject,$content,"*");
        }
        if($result){
            $model->commit();
        }else{
            $model->rollback();
            echo json_encode(array("msg"=>message("登记库链/客户对应信息操作发生错误")));
            die;
        }
        //完成后跳转
        $this->ajaxReturn($data ['pfuncid'],$data ['funcid'],"refresh", "","closepopup" );
        die;
    }

}
