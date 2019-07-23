<?php  namespace Home\Controller;


class NodeController extends BasicController {

    public function _init() {
        $funcs = $this->getUserRoleList($this->user,array( 'NodeSummary', '/Home/Node', ));
        if ($funcs)
            $this->assign("rights",  $funcs);
        else{
            $funcs = array(
                array("key"=>"refresh","func"=>"NodeSummary","Action"=>"refresh") ,
                array("key"=>"search","func"=>"NodeSummary","Action"=>"search") ,
                array("key"=>"export","func"=>"NodeSummary","Action"=>"export") ,
                array("key"=>"status_on","func"=>"/Home/Node","Action"=>"status_on") ,
                array("key"=>"status_off","func"=>"/Home/Node","Action"=>"status_off")
            );
            $this->assign("rights",  $this->GetUserRights($this->user["id"],$funcs ));
        }
        $this->assign("colshow", $this->GetUserColumnDefine($this->user["id"],"NodeSummary"));
    }

    public function index()
    {
        $data["pfuncid"] = I("request.pfuncid");
        $data["funcid"] = I("request.funcid");
        $data["zindex"] = I("request.zindex/d");
        if (empty($data["funcid"])) $data["funcid"] = "Department";
        $this->GetLastUrl($data["funcid"]);

        $func = I("request.func");
        if ($func != "saveSelectProduct" && $func != "save") {
            $this->GetLastUrl($data["funcid"]);
        }

        switch ($func) {
////// case for add /////////////////
            case "import":
                $this->import($data);
                break;
            case "edit":
            case "edit_base":
            case "add":
                $this->add($data);
                break;
            case "save":
                $this->save($data);
                break;
//// case for add /////////////////
            case "view":
                $this->view($data);
                break;
            case "import":
                $this->import($data);
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

        }
    }



    public  function status_on($data){

        $id = I("request.id/d");
        if (!$id) {
            $this->ajaxResult("商品分类分类不存在");
        }
        $search = M('node')->find($id);
        if (!$search)
            $this->ajaxResult("商品分类不存在");
        if ($search['status'] == '7') {
            $this->ajaxResult("商品分类已取消");
        }
        if ($search['status'] != '0') {
            $this->ajaxResult("商品分类状态已变化，请重新处理");
        }
        $data["search"] = $search;
        $data["id"] = $data["search"]["id"];
        foreach ($data as $key => $val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("Node:status_on");
        echo $html;
    }



    public  function  status_on_save($data){

        $id = I("request.id/d");
        if (!$id) {
            $this->ajaxResult("商品分类不存在");
        }
        //id存在时判断数据库内数据是否存在
        $orig = M("node")->where("id='%d'", array($id))->find();
        if (empty($orig)) {
            $this->ajaxError("商品分类不存在");
        }
        if ($orig['status'] == '7') {
            $this->ajaxResult("商品分类已取消");
        }
        if ($orig['status'] != '0') {
            $this->ajaxResult("商品分类状态已变化，请重新处理");
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
        $model = M("node");
        $model->startTrans();
        //按主键更新数据
        $result = $model->where("id = $id")->save($input);
        //建立操作日志
        $result = $result && createLogCommon('node', $id, '状态调整', $content);
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
            $this->ajaxResult("商品分类参数不存在");
        }
        $search = M('node')->find($id);
        if (!$search)
            $this->ajaxResult("商品分类不存在");
        if ($search['status'] == '7') {
            $this->ajaxResult("商品分类已取消");
        }
        if ($search['status'] != '1') {
            $this->ajaxResult("商品分类状态已变化，请重新处理");
        }
        $data["search"] = $search;
        $data["id"] = $data["search"]["id"];
        foreach ($data as $key => $val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("Node:status_off");
        echo $html;
    }

    private function status_off_save($data)
    {
        $id = I("request.id/d");
        if (!$id) {
            $this->ajaxResult("商品分类参数不存在");
        }
        //id存在时判断数据库内数据是否存在
        $orig = M("node")->where("id='%d'", array($id))->find();
        if (empty($orig)) {
            $this->ajaxError("商品分类数据不存在");
        }
        if ($orig['status'] == '7') {
            $this->ajaxResult("商品分类已取消");
        }
        if ($orig['status'] != '1') {
            $this->ajaxResult("商品分类状态已变化，请重新处理");
        }
        $reason_tag = I("request.reason_tag");
        $reason = I("request.reason");
        if (!($reason_tag . $reason)) {
            $this->ajaxResult("商品分类状态回退，需注明原因");
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
        $model = M("node");
        $model->startTrans();
        //按主键更新数据
        $result = $model->where("id = $id")->save($input);
        //建立操作日志
        $result = $result && createLogCommon('node', $id, '状态调整', $content);
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






}

?>