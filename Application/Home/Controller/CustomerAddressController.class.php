<?php

namespace Home\Controller;

class CustomerAddressController extends BasicController{


    public function _init()
    {
        $funcs = $this->getUserRoleList($this->user, array('CustomerAddress', '/Home/CustomerAddress',));
        if ($funcs)
            $this->assign("rights", $funcs);
        else {
            $funcs = array(
                array("key" => "refresh", "func" => "User", "Action" => "refresh"),
                array("key" => "edit_base", "func" => "/Home/GoodsCategory", "Action" => "edit_base"),
                array("key" => "edit", "func" => "/Home/GoodsCategory", "Action" => "edit"),
            );
            $this->assign("rights", $this->GetUserRights($this->user["id"], $funcs));
        }
        $this->assign("colshow", $this->GetUserColumnDefine($this->user["id"], "User"));
    }


    public function index()
    {
        $data["pfuncid"] = I("request.pfuncid");
        $data["funcid"] = I("request.funcid");
        $data["zindex"] = I("request.zindex/d");
        if (empty($data["funcid"])) $data["funcid"] = "GoodsCategory";
        $this->GetLastUrl($data["funcid"]);

        $func = I("request.func");
        if ($func != "saveSelectProduct" && $func != "save") {
            $this->GetLastUrl($data["funcid"]);
        }

        switch ($func) {
////// case for add /////////////////
            case "edit":
            case "edit_base":
            case "add":
                $this->add($data);
                break;
            case "save":
                $this->save($data);
                break;
            case "status_off":
                $this->status_off($data);
                break;
            case "status_on":
                $this->status_on($data);
                break;
            case "status_on_save":
                $this->status_on_save($data);
                break;
            case "status_off":
                $this->status_off($data);
                break;
            case "status_off_save":
                $this->status_off_save($data);
                break;
            case "view":
                $this->view($data);
                break;
            case "delete":
                $this->order_delete($data);
                break;

        }
    }



    private function add($data)
    {
        $id = I("request.id/d");
        if (!$id) {
            //读接入参数

            $address = I("request.address");
            $postcode = I("request.postcode");
            $phone = I("request.phone");
            $linkman = I("request.linkman");
            $status=I("request.status",0);

            //赋初值
            $search["address"] = $address ? $address : "";
            $search["postcode"] = $postcode ? $postcode : "";
            $search["phone"] = $phone ? $phone : "";
            $search["linkman"] = $linkman ? $linkman : "";
            $search["status"] = $status ? $status : "";

        } else {
            $search = M("customer_address")->find($id);

            if (!$search) {
                $this->ajaxResult("知识点分类数据不存在");
            }
            $parentcustomer=M("customer")->field("name")->where(" id = '".$search["customer_id"]."'")->find();
            $parentname=$parentcustomer["name"];

            $search["parent_id_name"]=$parentname;
            $data["id"] = $search["id"];

        }
        $data["search"] = $search;
        //检查popup返回name
        if ($data['search']['parent_id']) {
            $ret = M("customer_address")
                ->field("name")
                ->where("id='" . $data['search']['parent_id'] . "'")
                ->find();
            if ($ret) {
                $data["search"]["parent_id_name"] = $ret["name"];
            }
        }
        foreach ($data as $key => $val) {
            $this->assign($key, $val);
        }

        $html = $this->fetch("CustomerAddress:add");    /*跳转到QuestionCategory 目录下的add*/
        echo $html;
    }


    public function save($data)
    {
        $id = I("request.id/d");

        //读取页面输入数据
        $address = I("request.address");
        $postcode = I("request.postcode");
        $phone = I("request.phone");
        $linkman = I("request.linkman");
        $status=I("request.status",0);
        $parent_id=I("request.parent_id");
        $parentaddress=M("customer")->field("id")->where(" code = '".$parent_id."'")->find();
        $parent_id=$parentaddress["id"];

        if (false) {    //date:2019-6-12
            $pccc = M("customer_address");
            $cc = $pccc->where("code= '" . $code . "'")->select();
        }
        if (false) {   //date :2019-6-12
            $parent_id = M("customer_address")->where("code = " . $parent_id)->select();
        }

        //非页面输入字段
        $input = array();

        //数据有效性校验，非空/数值负数，范围/日期与今日比较

        //数据校验 - 必输项不能为空
        if (!verify_value($address, "empty", "", "")) $this->ajaxError("地址不能为空");

        // "备注" 长度超200位，没有生成非空检测

        $model = M("customer_address");

        //判断 code 是否重复建立
        if(false){        //date:2019-6-12
        $orig = $model->where("code='$code'" . ($id ? " and id!=$id" : ""))->find();
        if ($orig) $this->ajaxError("用户 $code 已存在");
        }
        //页面输入字段
        $input["address"] = $address;
        $input["postcode"] = $postcode;
        $input["phone"] = $phone;
        $input["linkman"] = $linkman;
        $input["status"] = $status;
        $input["customer_id"] =  $parent_id;

        $input["modify_user"] = $this->user["id"];
        $input["modify_time"] = date('Y-m-d H:i:s.n');

        $model->startTrans();
        $result = false;

        //需要存入日志的字段
        $needSave = array(
            'address' => '地址',
            'name' => '姓名',
        );

        if (!$id) {
            //新增  建号操作

            $input["create_user"] = $this->user["id"];
            $input["create_time"] = date('Y-m-d H:i:s.n');

            if(false){  //date : 2019-6-12  一个用户允许有多个地址

            $idss=array();
            $ids = $model->field("customer_id")->select();

            for ($c=0;$c<count($ids);$c++){
                $idss[$c]=$ids[$c]["customer_id"];
            }

            if(in_array($parent_id,$idss)){
                $this->ajaxError("此客户已经设置过地址");
            }
            }

            //新增数据 保存数据库
            $result = $id = $model->add($input);
            //建立操作日志
            $result = $result && createLogCommon('customer_address', $id, '新增客户地址信息', '', "*", 'code');
        } else {
            //id存在时判断数据库内数据是否存在
            $old = $model->where("id='%d'", array($id))->find();
            if (empty($old)) {
                $this->ajaxError("用户信息数据不存在");
            }


            if(false) {  //date : 2019-6-12  一个用户允许有多个地址
                $idss = array();
                $ids = $model->field("customer_id")->select();

                for ($c = 0; $c < count($ids); $c++) {
                    $idss[$c] = $ids[$c]["customer_id"];
                }

                if (in_array($parent_id, $idss)) {
                    $this->ajaxError("此客户已经设置过地址");
                }
            }


            //按主键更新数据
            $result = $model->where("id ='%d'", array($id))->save($input);

            $isSaveLog = false;
            foreach ($needSave as $key => $v) {
                if ($old[$key] != $input[$key]) {
                    $isSaveLog = true;
                    break;
                }
            }

            if ($isSaveLog) {
                //建立操作日志
                $result = $result && createLogCommon('customer_address', $id, '变更客户地址信息', $old, '', '', 'code', $needSave);
            }
        }
        if ($result) {
            $model->commit();
        } else {
            $model->rollback();
            echo json_encode(array("msg" => message("用户信息保存发生错误")));
            die;
        }

        //完成后跳转
        $this->ajaxReturn($data ['pfuncid'], $data ['funcid'], "refresh", "", "closepopup", 1);
        //转到view页面
        $this->ajaxReturn("", "", U("Home/CustomerAddress/index?func=view&id=$id"), tabtitle('用户', $input["code"]));
        die;
    }


    public function status_on($data)
    {

        $id = I("request.id/d");
        if (!$id) {
            $this->ajaxResult("会员地址不存在");
        }
        $search = M('customer_address')->find($id);
        if (!$search)
            $this->ajaxResult("会员地址不存在");
        if ($search['status'] == '7') {
            $this->ajaxResult("会员地址已取消");
        }
        if ($search['status'] != '0') {
            $this->ajaxResult("会员地址状态已变化，请重新处理");
        }
        $data["search"] = $search;
        $data["id"] = $data["search"]["id"];
        foreach ($data as $key => $val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("CustomerAddress:status_on");
        echo $html;
    }


    public function status_on_save($data)
    {

        $id = I("request.id/d");
        if (!$id) {
            $this->ajaxResult("会员地址不存在");
        }
        //id存在时判断数据库内数据是否存在
        $orig = M("customer_address")->where("id='%d'", array($id))->find();
        if (empty($orig)) {
            $this->ajaxError("会员地址不存在");
        }
        if ($orig['status'] == '7') {
            $this->ajaxResult("会员地址已取消");
        }
        if ($orig['status'] != '0') {
            $this->ajaxResult("会员地址状态已变化，请重新处理");
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
        $model = M("customer_address");
        $model->startTrans();
        //按主键更新数据
        $result = $model->where("id = $id")->save($input);
        //建立操作日志
        $result = $result && createLogCommon('customer_address', $id, '状态调整', $content);
        if ($result) {
            $model->commit();
        } else {
            $model->rollback();
            echo json_encode(array("msg" => message("题库保存发生错误")));
            die;
        }
        //完成后关闭并刷新父窗口
        $this->ajaxReturn($data ['pfuncid'], $data ['funcid'], "refresh", "", "closepopup");
        die;
    }


    private function status_off($data)
    {
        $id = I("request.id/d");
        if (!$id) {
            $this->ajaxResult("会员地址参数不存在");
        }
        $search = M('customer_address')->find($id);
        if (!$search)
            $this->ajaxResult("会员地址不存在");
        if ($search['status'] == '7') {
            $this->ajaxResult("会员地址已取消");
        }
        if ($search['status'] != '1') {
            $this->ajaxResult("会员地址状态已变化，请重新处理");
        }
        $data["search"] = $search;
        $data["id"] = $data["search"]["id"];
        foreach ($data as $key => $val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("CustomerAddress:status_off");
        echo $html;
    }

    private function status_off_save($data)
    {
        $id = I("request.id/d");
        if (!$id) {
            $this->ajaxResult("会员地址参数不存在");
        }
        //id存在时判断数据库内数据是否存在
        $orig = M("customer_address")->where("id='%d'", array($id))->find();
        if (empty($orig)) {
            $this->ajaxError("会员地址数据不存在");
        }
        if ($orig['status'] == '7') {
            $this->ajaxResult("会员地址已取消");
        }
        if ($orig['status'] != '1') {
            $this->ajaxResult("会员地址状态已变化，请重新处理");
        }
        $reason_tag = I("request.reason_tag");
        $reason = I("request.reason");
        if (!($reason_tag . $reason)) {
            $this->ajaxResult("会员地址状态回退，需注明原因");
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
        $model = M("customer_address");
        $model->startTrans();
        //按主键更新数据
        $result = $model->where("id = $id")->save($input);
        //建立操作日志
        $result = $result && createLogCommon('customer_address', $id, '状态调整', $content);
        if ($result) {
            $model->commit();
        } else {
            $model->rollback();
            echo json_encode(array("msg" => message("题库保存发生错误")));
            die;
        }
        //完成后关闭并刷新父窗口
        $this->ajaxReturn($data ['pfuncid'], $data ['funcid'], "refresh", "", "closepopup");
        die;
    }


    private function tabsheet_check($itab)
    {
        $idefault = "caozuorizhi";
        switch ($itab) {

            case "caozuorizhi":

                break;
            default:
                $itab = $idefault;
                break;
        }
        return $itab;
    }


    private function tab_caozuorizhi_log_common($tab_pagesize, $data)
    {
        $orderby = "";
        $joinsql = "";

        $data["search"]["tab_caozuorizhi_content"] = I("get.tab_caozuorizhi_content");

        $condition = "";

        $condition = join_condition($condition, "@log_common.content", $data["search"]["tab_caozuorizhi_content"], "char", "both");

        //select detail fields
        $selectfields = "@log_common.status ";
        $selectfields .= ",@log_common.id ";
        $selectfields .= ",@log_common.create_time ";
        $selectfields .= ",@log_common.type ";
        $selectfields .= ",@log_common.data_id ";
        $selectfields .= ",@log_common.data_code ";
        $selectfields .= ",@log_common.subject ";
        $selectfields .= ",@log_common.content ";

        $viewkey = "data_id='" . $data["search"]["id"] . "'";
        $viewkey .= " and type='department'";
        //   if(!$viewkey)
        //      die;

        $page_size = $tab_pagesize;
        if (!$page_size) {
            $page_size = 10;
        }

        $count_sql = table("select count(*) as cnt from @log_common  #join# where #viewkey# #condition#");
        $search_sql = table("select #selectfields# from @log_common  #join# Where #viewkey# #condition# #orderby#");

        $viewkey = table($viewkey);
        $condition = table($condition);
        $orderby = table($orderby);
        $selectfields = table($selectfields);

        $count_sql = str_replace("#condition#", $condition, $count_sql);
        $count_sql = str_replace("#viewkey#", $viewkey, $count_sql);
        $count_sql = str_replace("#join#", $joinsql, $count_sql);

        $count = M()->query($count_sql);
        $count = $count[0]["cnt"];

        if ($count < $page_size)
            $tmp = 1;
        else {
            $tmp = intval($count / $page_size);
            if ($count % $page_size != 0) {
                $tmp++;
            }
        }
        if (!$data["p"]) {
            $data["p"] = 1;
        }
        if ($data["p"] > $tmp) {
            $data["p"] = $tmp;
        }

        $sql = str_replace("#selectfields#", $selectfields, $search_sql);
        $sql = str_replace("#join#", $joinsql, $sql);
        $sql = str_replace("#viewkey#", $viewkey, $sql);
        $sql = str_replace("#condition#", $condition, $sql);
        $sql = str_replace("#orderby#", $orderby, $sql);
        $sql .= " LIMIT " . (($data["p"] - 1) * $page_size) . ", $page_size";
        $data["list"] = M()->query($sql);
        $pageClass = new \Think\Page($count, $page_size);
        $pageClass->rollPage = 8;
        //$data["page"] = $pageClass->show_drp($data["funcid"]);
        $data["page_size"] = $page_size;

        return $data;
    }



//// source for add /////////////////

    private function view($data)
    {
        $data["p"] = I("request.p/d");
        $data["pagesize"] = I("request.pagesize/d");

        $data["id"] = I("request.id/d");
        $data["no"] = I("request.no");
        if (!$data["id"] && !$data["no"]) {
            $this->ajaxError("部门信息查询参数非法");
        }
        //condition
        $condition = "";
        $joinsql = "";
        //select search fields
        $selectmasterfields = "@customer_address.*";

        $sql = table("select #selectfields# from @customer_address  #join# Where #viewkey# #condition# #orderby#");
        if ($data["id"])
            $viewkey = table("@customer_address.id=$data[id]");
        else
            $viewkey = table("@customer_address.code='$data[no]'");
        $sql = str_replace("#selectfields#", table($selectmasterfields), $sql);
        $sql = str_replace("#join#", $joinsql, $sql);
        $sql = str_replace("#viewkey#", $viewkey, $sql);
        $sql = str_replace("#condition#", $condition, $sql);
        $sql = str_replace("#orderby#", "", $sql);
        $search = M()->query($sql);
        if (!$search) {
            $this->ajaxError("部门信息信息不存在");
        }

        /**
         * 根据客户地址表中的customer——id从客户 表中插入客户名字
         */
        if($search[0]["customer_id"]!=null){
        $address = M("customer")->field("name")->where(" id = ".$search[0]["customer_id"])->find();
        $customername=$address["name"];
        $search[0]["parent_id_name"]=$customername;
        }
        $data["search"] = current($search);

        //step 步骤样例 - 开始
        $step = array();
        $step1 = array();
        step_add($step, '创建时间', $data["search"]['create_time'], true);
        step_add($step, '已确认', $data["search"]['confirm_time'], $data["search"]['status'] >= 1 && $data["search"]['confirm_status'] == 1);
        step_add($step, '已通知', $data["search"]['notice_time'], $data["search"]['status'] >= 1 && $data["search"]['notice_status'] == 1);
        if ($data["search"]['status'] >= 1 && $data["search"]['stock_status'] == 1) {
            step_add($step, '处理中', $data["search"]['stock_time'], $data["search"]['status'] >= 1 && $data["search"]['stock_status'] == 1);
        }
        step_add($step, '已完成', $data["search"]['complete_time'], $data["search"]['status'] == 2);
        // 取消/挂起步骤
        step_add($step1, '取消时间', $data["search"]['cancel_time'], $data["search"]['cancel_status'] == 1);
        step_add($step1, '挂起时间', $data["search"]['hangup_time'], $data["search"]['hangup_status'] == 1);
        $step = getOrderStep($step, $step1);
        $data["step"] = $step;
        //step 步骤样例 - 结束

        //按tabsheet - 开始
        $data["id"] = $data["search"]["id"];
        $data["search"]["_tab"] = $this->tabsheet_check(I("request._tab"));
        $page_size = $data["pagesize"];//session("Department-".$data["search"]["_tab"]."-PageSize");
        switch ($data["search"]["_tab"]) {

            case "caozuorizhi":
                $data = $this->tab_caozuorizhi_log_common($page_size, $data);
                break;

        }
        $data["search"]["_tab_" . $data["search"]["_tab"] . "_p"] = $data["p"];
        $data["search"]["_tab_" . $data["search"]["_tab"] . "_psize"] = $data["page_size"];
        //session("Department-".$data["search"]["_tab"]."-PageSize", $data["page_size"]);
        //按tabsheet - 结束

        foreach ($data as $key => $val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("CustomerAddress:view2");
        echo $html;
    }


    //按tabsheet子程序 - 结束

    //按tabsheet子程序 - 结束

    private function deleteProcess($id, &$type)
    {
        $smo = M('customer_address')->where("id='%d'", array($id))->find();
        if (empty($smo)) {
            $this->ajaxResult("部门信息数据不存在");
        }
        if ($smo['status'] != 0) {
            $this->ajaxResult("部门信息状态不能删除");
        }

        $result = true;
        if ($smo['status'] != 0) {
            $result = M('customer_address')->where("id='%d'", array($id))->save(array('status' => 8, 'cancel_time' => date('Y-m-d H:i:s'), 'cancel_status' => 1));
            $result = $result && createLogCommon('customer_address', $id, '取消部门信息', '');
        } else {
            $type = 2;
            $result = $result && createLogCommon('customer_address', $id, '删除部门信息', '');
            $result = $result && M('customer_address')->where("id='%d'", array($id))->delete();
        }
        return $result;
    }

    private function order_delete($data)
    {

        $id = I("request.id/d");
        if (!$id) {
            $this->ajaxResult("部门信息参数不存在");
        }

        $m = M();
        $m->startTrans();
        $type = 1;
        $r = $this->deleteProcess($id, $type);

        if ($r) {
            $m->commit();
        } else {
            $m->rollback();
        }

        if ($type == 1) {
            $this->ajaxResult("", "", array("_asr.closeTab", "_asr.closePopup", "_asr.openLink", "_asr.hideConfirm"), array("$('#" . $data["funcid"] . "-Tab').find('a'), '" . $data["funcid"] . "'", "'" . $data["funcid"] . "'", "'" . U("/Home/CustomerAddress/index?func=view&id=" . $id) . "','" . filterFuncId("CustomerAddress_View", "id=$data[id]") . "','部门信息查看', 0", "''"));
        } else {
            $this->ajaxResult("", "", array("_asr.closeTab", "_asr.closePopup", "_asr.openLink", "_asr.hideConfirm"), array("$('#" . $data["funcid"] . "-Tab').find('a'), '" . $data["funcid"] . "'", "'" . $data["funcid"] . "'", "'" . U("/Summary/CustomerAddressSummary/index?func=search&id=" . $id) . "','" . filterFuncId("CustomerAddressSummary_View", "id=$data[id]") . "','部门信息列表', 0", "''"));
        }
        die;
    }






}





?>