<?php
namespace Home\Controller;

//
//注释: CustomerDelivery - 客户提货信息
//
use Home\Controller\BasicController;
use Think\Log;
class CustomerDeliveryController extends BasicController
{

    public function _init()
    {
        $funcs = $this->getUserRoleList($this->user, array());
        if ($funcs)
            $this->assign("rights", $funcs);
        else {
            $funcs = array();
            $this->assign("rights", $this->GetUserRights($this->user["id"], $funcs));
        }
        $this->assign("colshow", $this->GetUserColumnDefine($this->user["id"], "CustomerDelivery"));
    }

    public function index()
    {
        $data["pfuncid"] = I("request.pfuncid");
        $data["funcid"] = I("request.funcid");
        $data["zindex"] = I("request.zindex/d");
        if (empty($data["funcid"])) $data["funcid"] = "CustomerDelivery";
        $this->GetLastUrl($data["funcid"]);

        $func = I("request.func");
        if ($func != "saveSelectProduct" && $func != "save") {
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
            case "new_edit":
                $this->new_edit($data);
                break;
            case "new_add":
                $this->new_add($data);
                break;
            case "add_save":
                $this->add_save($data);
                break;
            case "edit_save":
                $this->edit_save($data);
                break;
            default :
                $this->ajax_refresh($data ['funcid']);
                break;

        }
    }

//// source for add - begin ////
    private function add($data)
    {
        $id = I("request.id/d");
        if (!$id) {
            //读接入参数
            $customer_id = I("request.customer_id/d", 0);
            $carno = I("request.carno");
            $contact = I("request.contact");
            $idcard = I("request.idcard");
            $phone = I("request.phone");
            $company = I("request.company");
            $remarks = I("request.remarks");
            //赋初值
            $search["customer_id"] = $customer_id ? $customer_id : "";
            $search["carno"] = $carno ? $carno : "";
            $search["contact"] = $contact ? $contact : "";
            $search["idcard"] = $idcard ? $idcard : "";
            $search["phone"] = $phone ? $phone : "";
            $search["company"] = $company ? $company : "";
            $search["remarks"] = $remarks ? $remarks : "";
        } else {
            $search = M(customer_delivery)->find($id);
            if (!$search) {
                $this->ajaxResult("客户提货信息数据不存在");
            }
            $data["id"] = $search["id"];
        }
        $data["search"] = $search;
        //检查popup返回name
        if ($data['search']['customer_id']) {
            $ret = M("Customer")
                ->field("name")
                ->where("id='" . $data['search']['customer_id'] . "'")
                ->find();
            if ($ret) {
                $data["search"]["customer_id_name"] = $ret["name"];
            }
        }
        foreach ($data as $key => $val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("CustomerDelivery:add");
        echo $html;
    }

    private function save($data)
    {
        $id = I("request.id/d");
        //读取页面输入数据
        $customer_id_name = I("request.customer_id_name");
        $customer_id = I("request.customer_id/d", 0);
        $carno = I("request.carno");
        $contact = I("request.contact");
        $idcard = I("request.idcard");
        $phone = I("request.phone");
        $company = I("request.company");
        $remarks = I("request.remarks");
        //非页面输入字段
        $input = array();
        //数据有效性校验，非空/数值负数，范围/日期与今日比较
        //数据校验 - 必输项不能为空
        // "备注" 长度超200位，没有生成非空检测
        if ($customer_id) {
            $ret = M("customer")
                ->field("id,code,short_name name,status")
                ->where(" id='$customer_id' ")->find();
            if (!$ret) $this->ajaxError("客户不存在");
            if ($ret['status'] == 0 || $ret['status'] == 8) $this->ajaxError("客户非有效状态");
        }
        $model = M("customer_delivery");
        //页面输入字段
        $input["customer_id_name"] = $customer_id_name;
        $input["customer_id"] = $customer_id;
        $input["carno"] = $carno;
        $input["contact"] = $contact;
        $input["idcard"] = $idcard;
        $input["phone"] = $phone;
        $input["company"] = $company;
        $input["remarks"] = $remarks;
        $input["modify_user"] = session(C("USER_AUTH_KEY"));
        $input["modify_time"] = date('Y-m-d H:i:s.n');
        $model->startTrans();
        $result = false;
        //需要存入日志的字段
        $needSave = array(
            'customer_id' => '客户',
            'carno' => '车牌号',
            'contact' => '驾驶员',
            'idcard' => '身份证',
            'phone' => '联系电话',
            'company' => '承运单位',
        );
        if (!$id) {
            //新增  建号操作
            $input["create_user"] = session(C("USER_AUTH_KEY"));
            $input["create_time"] = date('Y-m-d H:i:s.n');
            //新增数据 保存数据库
            $result = $id = $model->add($input);
            //建立操作日志
            $result = $result && createLog('customer_delivery', $id, '新增客户提货信息', '', "*", '');
        } else {
            //id存在时判断数据库内数据是否存在
            $orig = $model->where("id='%d'", array($id))->find();
            if (empty($orig)) {
                $this->ajaxError("客户提货信息数据不存在");
            }
            //按主键更新数据
            $result = $model->where("id = $id")->save($input);
            $isSaveLog = false;
            foreach ($needSave as $key => $v) {
                if ($orig[$key] != $input[$key]) {
                    $isSaveLog = true;
                    break;
                }
            }
            if ($isSaveLog) {
                //建立操作日志
                $result = $result && createLog('customer_delivery', $id, '变更客户提货信息', $orig, '', '', '', $needSave);
            }
        }
        if ($result) {
            $model->commit();
        } else {
            $model->rollback();
            echo json_encode(array("msg" => message("客户提货信息保存发生错误")));
            die;
        }
        //完成后跳转
        //转到summary页面
        $this->ajaxReturn($data ['pfuncid'], $data ['funcid'], "refresh", "", "closepopup");
        die;
    }
//// source for add - end ////
//// source for status_on - begin ////
    private function status_on($data)
    {
        $id = I("request.id/d");
        if (!$id) {
            $this->ajaxResult("客户提货信息参数不存在");
        }
        $search = M('customer_delivery')->find($id);
        if (!$search)
            $this->ajaxResult("客户提货信息不存在");
        if ($search['status'] == '7') {
            $this->ajaxResult("客户提货信息已取消");
        }
        if ($search['status'] != '0') {
            $this->ajaxResult("客户提货信息状态已变化，请重新处理");
        }
        $data["search"] = $search;
        $data["id"] = $data["search"]["id"];
        foreach ($data as $key => $val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("CustomerDelivery:status_on");
        echo $html;
    }

    private function status_on_save($data)
    {
        $id = I("request.id/d");
        if (!$id) {
            $this->ajaxResult("客户提货信息参数不存在");
        }
        //id存在时判断数据库内数据是否存在
        $orig = M("customer_delivery")->where("id='%d'", array($id))->find();
        if (empty($orig)) {
            $this->ajaxError("客户提货信息数据不存在");
        }
        if ($orig['status'] == '7') {
            $this->ajaxResult("客户提货信息已取消");
        }
        if ($orig['status'] != '0') {
            $this->ajaxResult("客户提货信息状态已变化，请重新处理");
        }
        $reason_tag = I("request.reason_tag");
        $reason = I("request.reason");
        $statusdesc = "状态[有效], ";
        $input["status"] = "1";  // "文本类型"
        $content = $statusdesc . "备注: ";
        if ($reason_tag) {
            $content .= $reason_tag;
            if ($reason) $content .= ", " . $reason;
        } else {
            $content .= $reason;
        }
        $input["modify_user"] = session(C("USER_AUTH_KEY"));
        $input["modify_time"] = date('Y-m-d H:i:s.n');
        $model = M("customer_delivery");
        $model->startTrans();
        //按主键更新数据
        $result = $model->where("id = $id")->save($input);
        if ($result) {
            $model->commit();
        } else {
            $model->rollback();
            echo json_encode(array("msg" => message("客户提货信息保存发生错误")));
            die;
        }
        //完成后关闭并刷新父窗口
        $this->ajaxReturn($data ['pfuncid'], $data ['funcid'], "refresh", "", "closepopup");
        die;
    }
//// source for status_on - end ////
//// source for status_off - begin ////
    private function status_off($data)
    {
        $id = I("request.id/d");
        if (!$id) {
            $this->ajaxResult("客户提货信息参数不存在");
        }
        $search = M('customer_delivery')->find($id);
        if (!$search)
            $this->ajaxResult("客户提货信息不存在");
        if ($search['status'] == '7') {
            $this->ajaxResult("客户提货信息已取消");
        }
        if ($search['status'] != '1') {
            $this->ajaxResult("客户提货信息状态已变化，请重新处理");
        }
        $data["search"] = $search;
        $data["id"] = $data["search"]["id"];
        foreach ($data as $key => $val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("CustomerDelivery:status_off");
        echo $html;
    }

    private function status_off_save($data)
    {
        $id = I("request.id/d");
        if (!$id) {
            $this->ajaxResult("客户提货信息参数不存在");
        }
        //id存在时判断数据库内数据是否存在
        $orig = M("customer_delivery")->where("id='%d'", array($id))->find();
        if (empty($orig)) {
            $this->ajaxError("客户提货信息数据不存在");
        }
        if ($orig['status'] == '7') {
            $this->ajaxResult("客户提货信息已取消");
        }
        if ($orig['status'] != '1') {
            $this->ajaxResult("客户提货信息状态已变化，请重新处理");
        }
        $reason_tag = I("request.reason_tag");
        $reason = I("request.reason");
        if (!($reason_tag . $reason)) {
            $this->ajaxResult("客户提货信息状态回退，需注明原因");
        }
        $statusdesc = "退回状态[无效], ";
        $input["status"] = "0";  // "文本类型"
        $content = $statusdesc . "备注: ";
        if ($reason_tag) {
            $content .= $reason_tag;
            if ($reason) $content .= ", " . $reason;
        } else {
            $content .= $reason;
        }
        $input["modify_user"] = session(C("USER_AUTH_KEY"));
        $input["modify_time"] = date('Y-m-d H:i:s.n');
        $model = M("customer_delivery");
        $model->startTrans();
        //按主键更新数据
        $result = $model->where("id = $id")->save($input);
        if ($result) {
            $model->commit();
        } else {
            $model->rollback();
            echo json_encode(array("msg" => message("客户提货信息保存发生错误")));
            die;
        }
        //完成后关闭并刷新父窗口
        $this->ajaxReturn($data ['pfuncid'], $data ['funcid'], "refresh", "", "closepopup");
        die;
    }
//// source for status_off - end ////
//##combine_for_add_source##

//// source for status confirm ////

//// source for status view ////
    private function view($data)
    {
        $data["p"] = I("request.p/d");
        $data["pagesize"] = I("request.pagesize/d");

        $data["id"] = I("request.id/d");
        $data["no"] = I("request.no");
        if (!$data["id"] && !$data["no"]) {
            $this->ajaxError("客户提货信息查询参数非法");
        }

        //condition
        $condition = "";
        $joinsql = "";
        //select search fields
        $selectmasterfields = "@customer_delivery.*";

        $selectmasterfields .= ",@customer.code ";
        $selectmasterfields .= ",@customer.name ";


        $sql = table("select #selectfields# from @customer_delivery  #join# Where #viewkey# #condition# #orderby#");
        $joinsql .= table(" LEFT JOIN @customer ON @customer.id=@customer_delivery.customer_id ");
        if ($data["id"])
            $viewkey = table("@customer_delivery.id=$data[id]");
        else
            $viewkey = table("@customer_delivery.id='$data[no]'");
        $sql = str_replace("#selectfields#", table($selectmasterfields), $sql);
        $sql = str_replace("#join#", $joinsql, $sql);
        $sql = str_replace("#viewkey#", $viewkey, $sql);
        $sql = str_replace("#condition#", $condition, $sql);
        $sql = str_replace("#orderby#", "", $sql);
        $search = M()->query($sql);
        if (!$search) {
            $this->ajaxError("客户提货信息信息不存在");
        }
        $data["search"] = current($search);

        //step 步骤样例 - 开始
        $step = array();
        $step1 = array();
        step_add($step, '创建时间', $data["search"]['create_time'], true);
        step_add($step, '已确认', $data["search"]['confirm_time'], $data["search"]['status'] >= 1 && $data["search"]['confirm_status'] == 1);
        step_add($step, '已通知', $data["search"]['notice_time'], $data["search"]['status'] >= 1 && $data["search"]['notice_status'] == 1);
        //if($data["search"]['status']>=1 && $data["search"]['stock_status']==1){
        step_add($step, '处理中', $data["search"]['stock_time'], $data["search"]['status'] >= 1 && $data["search"]['stock_status'] == 1);
        //}
        step_add($step, '已完成', $data["search"]['complete_time'], $data["search"]['status'] == 2);
        // 取消/挂起步骤
        step_add($step1, '取消时间', $data["search"]['cancel_time'], $data["search"]['cancel_status'] == 1);
        step_add($step1, '挂起时间', $data["search"]['hangup_time'], $data["search"]['hangup_status'] == 1);
        $step = getOrderStep($step, $step1);
        $data["step"] = $step;
        //step 步骤样例 - 结束

        //按tabsheet - 开始
        $data["id"] = $data["search"]["id"];
        //按tabsheet - 结束

        foreach ($data as $key => $val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("CustomerDelivery:view");
        echo $html;
    }

    //按tabsheet子程序 - 开始
    //按tabsheet子程序 - 结束

    private function deleteProcess($id)
    {
        $type = 1;
        $smo = M('customer_delivery')->where("id='%d'", array($id))->find();
        if (empty($smo)) {
            $this->ajaxResult("客户提货信息数据不存在");
        }
        if ($smo['status'] != 0) {
            $this->ajaxResult("客户提货信息状态不能删除");
        }

        $result = true;
        $result = $result && createLogCommon('customer_delivery', $id, ($smo['status'] ? '取消信息' : '删除记录'), '');
        if ($smo['status'] != 0) {
            $result = $result && M('customer_delivery')->where("id='%d'", array($id))->save(array('status' => 8, 'cancel_time' => date('Y-m-d H:i:s'), 'cancel_status' => 1));
        } else {
            $result = $result && M('customer_delivery')->where("id='%d'", array($id))->delete();
        }
        return $result;
    }

    private function order_delete($data)
    {

        $id = I("request.id/d");
        $type = I("request.type/d");
        if (!$id) {
            $this->ajaxResult("客户提货信息参数不存在");
        }

        $m = M();
        $m->startTrans();
        $r = $this->deleteProcess($id);
        if ($r) {
            $m->commit();
        } else {
            $m->rollback();
        }

        $this->ajax_hideConfirm();
        if (!$type) {
            $this->ajax_closeTab($data ['funcid']);
        }
        $this->ajax_refresh($data ['pfuncid']);
        $this->ajaxResult();
        die;
    }

    private function new_add($data)
    {
        $id = I('request.id/d');
        $customer_id = I('request.customer_id/d');
        if(!$customer_id) {
            $this->ajaxResult("客户信息参数不存在");
        }
        if($this->user['side'] != 3){
            $this->ajaxResult("提货信息只能客户本人添加");
        }
        $customer_name=M('customer')->field('id,name')->where("id='%d'",array($customer_id))->find();
        if(empty($customer_name)) {
            $this->ajaxResult("客户资料数据不存在");
        }
        $data["id"] = $customer_name['id'];
        $data['customer_name'] = $customer_name;

        if($id){
            //id存在时判断数据库内数据是否存在
            $search=M("customer_delivery")->where("id='%d'",array($id))->find();
            if(empty($search)) {
                $this->ajaxError("客户提货信息数据不存在");
            }
            $data['search'] = $search;
        }

        foreach($data as $key=>$val) {
            $this->assign($key, $val);
        }

        $html = $this->fetch("CustomerDelivery:new_add");
        echo $html;
    }

    private function add_save($data)
    {
        $id = I('request.id/d');//提货信息ID
        $customer_id = I('request.customer_id/d');//当前客户ID

        if(!$customer_id) {
            $this->ajaxResult("客户资料参数不存在");
        }
        if($this->user['side'] != 3){
            $this->ajaxResult("提货信息只能客户本人添加");
        }
        //id存在时判断数据库内数据是否存在
        $orig=M("customer")->field('id,name,status')->where("id='%d'",array($customer_id))->find();
        if(empty($orig)) {
            $this->ajaxError("客户资料数据不存在");
        }
        $model = M('customer_delivery');
        $input['carno'] = I("request.carno");
        $input['contact'] = I("request.contact");
        $input['idcard'] = I("request.idcard");
        if($input['carno'] == ''){
            $this->ajaxError("车牌号不能为空");
        }
        if($input['contact'] == ''){
            $this->ajaxError("驾驶员不能为空");
        }
        if($input['idcard'] == ''){
            $this->ajaxError("身份证不能为空");
        }
        if($id){
            $where['id'] = array('neq',$id);
            $list = $model->where($input)->where($where)->find();
        }else{
            $list = $model->where($input)->find();
        }
        //检查数据是否重复
        if(!empty($list)){
            $this->ajaxResult('数据重复，添加失败');
        }
        $input['phone'] = I("request.phone");
        $input['company'] = I("request.company");
        $input['remarks'] = I("request.remarks");
        $input['modify_time'] = date('Y-m-d H:i:s.n');
        $input['modify_user'] = session(C("USER_AUTH_KEY"));
        $result=false;
        //需要存入日志的字段
        $needSave=array(
            'customer_id'=>'客户',
            'carno'=>'车牌号',
            'contact'=>'驾驶员',
            'idcard'=>'身份证',
            'phone'=>'联系电话',
            'company'=>'承运单位',
            'remarks'=>'备注',
            'status'=>'状态',
        );
        $model->startTrans();
        if(!$id){
            $input['status'] = 0;
            $input['customer_id'] = $customer_id;
            $input['create_time'] = date('Y-m-d H:i:s.n');
            $input['create_user'] = session(C("USER_AUTH_KEY"));
            $result = $model->add($input);
            $subject = '新增客户提货信息';
        }else{
            $result = $model->where("id='%d'",array($id))->save($input);
            $subject = '修改客户提货信息';
        }

        $result = $result && createLogCommon('customer_delivery',$id,$subject,'',"*");
        if($result){
            $model->commit();
        }else{
            $model->rollback();
            echo json_encode(array("msg"=>message("提货信息操作发生错误")));
            die;
        }
        //完成后跳转
        $this->ajaxReturn($data ['pfuncid'],$data ['funcid'],"refresh", "","closepopup" );
        die;
    }


}
