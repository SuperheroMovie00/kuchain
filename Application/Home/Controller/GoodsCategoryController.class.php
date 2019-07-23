<?php

namespace Home\Controller;

class GoodsCategoryController extends BasicController
{

    private $code_level_length=2;

    public function _init()
    {
        $funcs = $this->getUserRoleList($this->user, array('GoodsCategory', '/Home/GoodsCategory',));
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
            case "create":
                $this->create($data);
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


    /*private function add($data)
    {
        $id = I("request.id/d");
        if (!$id) {
            //读接入参数
            $code = I("request.code");
            $name = I("request.name");
            $description = I("request.description");
            $level = I("request.level");
            $sort = I("request.sort", 0);
            $parent_id = I("request.parent_id");
            //赋初值
            $search["parent_id"] = $parent_id ? $parent_id : "";
            $search["code"] = $code ? $code : "";
            $search["name"] = $name ? $name : "";
            $search["level"] = $level ? $level : "";
            $search["sort"] = $sort ? $sort : "";
            $search["description"] = $description ? $description : "";  //第一个选项
        } else {

            $search = M("goods_category")->find($id);

            if (!$search) {
                $this->ajaxResult("知识点分类数据不存在");
            }
            $data["id"] = $search["id"];
        }
        $data["search"] = $search;
        //检查popup返回name
        if ($data['search']['parent_id']) {
            $ret = M("goods_category")
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


        $html = $this->fetch("GoodsCategory:add");
        echo $html;
    }*/


    private function add($data) {
        $id = I("request.id/d");

        if(!$id){
            //读接入参数
            $parent_id = I("request.parent_id/d",0);
            $code = I("request.code");
            $name = I("request.name");
            $full_path = I("request.full_path");
            $level = I("request.level/d",0);
            $approval_require = I("request.approval_require");
            $alarm_days = I("request.alarm_days/d",0);
            $onlyone = I("request.onlyone");
            $sort = I("request.sort/d",0);
            //赋初值
            $search["parent_id"] = $parent_id?$parent_id:"";
            $search["code"] = $code?$code:"";
            $search["name"] = $name?$name:"";
            $search["full_path"] = $full_path?$full_path:"";
            $search["level"] = $level?$level:"";
            $search["approval_require"] = $approval_require?$approval_require:"0";  //第一个选项
            $search["alarm_days"] = $alarm_days?$alarm_days:"";
            $search["onlyone"] = $onlyone?$onlyone:"0";  //第一个选项
            $search["sort"] = $sort?$sort:"";
        } else {
            $search = M(goods_category)->find($id);
            if(!$search){
                $this->ajaxResult("货品分类数据不存在" );
            }
            $data["id"] = $search["id"];
        }

        $data["search"] = $search;
        //检查popup返回name
        if($data['search']['parent_id']){
            $ret=M("goods_category" )
                ->field("full_path,code")
                ->where("id='".$data['search']['parent_id']."'")
                ->find();
            if($ret){
                $data["search"]["parent_id_name"] = $ret["full_path"];
                $data["search"]["parent_id_code"] = $ret["code"];
            }
        }

        /*$data["search"]["parent_id_name"] =str_replace("/".$data["search"]["name"],'', $search["full_path"]);
        $data["search"]["parent_id_code"] = $search["code"];*/
        foreach($data as $key=>$val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("GoodsCategory:add");
        echo $html;
    }



    private function create($data) {
        $id = I("request.id/d");

        if(!$id){
            //读接入参数
            $parent_id = I("request.parent_id/d",0);
            $code = I("request.code");
            $name = I("request.name");
            $full_path = I("request.full_path");
            $level = I("request.level/d",0);
            $approval_require = I("request.approval_require");
            $alarm_days = I("request.alarm_days/d",0);
            $onlyone = I("request.onlyone");
            $sort = I("request.sort/d",0);
            //赋初值
            $search["parent_id"] = $parent_id?$parent_id:"";
            $search["code"] = $code?$code:"";
            $search["name"] = $name?$name:"";
            $search["full_path"] = $full_path?$full_path:"";
            $search["level"] = $level?$level:"";
            $search["approval_require"] = $approval_require?$approval_require:"0";  //第一个选项
            $search["alarm_days"] = $alarm_days?$alarm_days:"";
            $search["onlyone"] = $onlyone?$onlyone:"0";  //第一个选项
            $search["sort"] = $sort?$sort:"";
        } else {
            $search = M(goods_category)->find($id);
            if(!$search){
                $this->ajaxResult("货品分类数据不存在" );
            }
            $data["id"] = $search["id"];
        }

        $data["search"] = $search;
        //检查popup返回name
        /*if($data['search']['parent_id']){
            $ret=M("goods_category" )
                ->field("full_path,code")
                ->where("id='".$data['search']['parent_id']."'")
                ->find();
            if($ret){
                $data["search"]["parent_id_name"] = $ret["full_path"];
                $data["search"]["parent_id_code"] = $ret["code"];
            }
        }*/

        $data["search"]["parent_id_name"] = $search["full_path"];
        $data["search"]["parent_id_code"] = $search["code"];
        foreach($data as $key=>$val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("GoodsCategory:speedyadd");
        echo $html;
    }





    private function save($data) {

        $id=I("request.id/d" );
        //读取页面输入数据
        $parent_id_name = I("request.parent_id_name");

        $parent_id_code =I("request.parent_id_code");


        $code = I("request.code");
        $name =trim( I("request.name"));
        $full_path = I("request.full_path");

        $description=I("request.description");

        $level = I("request.level/d",0);
        $approval_require = I("request.approval_require");
        $alarm_days = I("request.alarm_days/d",0);
        $onlyone = I("request.onlyone");
        $sort = I("request.sort/d",0);
        //非页面输入字段
        $input = array();
        //数据有效性校验，非空/数值负数，范围/日期与今日比较
        //数据校验 - 必输项不能为空

        if(!verify_value($name,"empty","","")) $this->ajaxError("名称 不能为空");
        //if(!verify_value($level,"nagitive","","")) $this->ajaxError("层级 不能为负数");
        //if ($level < 100 || $level > 105) $this->ajaxError("校验样例 层级值在100-105之间");
        //if(!verify_value($alarm_days,"nagitive","","")) $this->ajaxError("提前报警 不能为负数");
        //if ($alarm_days < 100 || $alarm_days > 105) $this->ajaxError("校验样例 提前报警值在100-105之间");
        //if(!verify_value($sort,"nagitive","","")) $this->ajaxError("排序 不能为负数");
        //if($sort<=0) $sort=99999;
        $orig = array();
        $pcode ="";
        $level=1;
        $parent_id=0;
        $model = M("goods_category");
        if($parent_id_code){
            $parent = $model->where("code='$parent_id_code'")->find();
            if(empty($parent )) $this->ajaxError("父知识点不存在");
            $parent_id= $parent['id'];
            $pcode = $parent['code'];
            $level=$parent['level']+1;  //层级加1
         }
        //判断 知识点名称 是否重复建立
        $result = $model->where(($id?"id!=$id and ":"")."name='$name'")->find();
        if($result )$this->ajaxError("知识点名称 $name 已经存在");

        if($id){
            $orig = $model->find($id);
            if (!$orig) $this->ajaxError("当前知识点不存在");
        } else {
            $result = $model->field("max(code) as code")->where("parent_id=".($parent_id?$parent_id:"0"))->find();
            if($result &&  $result!=null){
                $start=($level-1)*$this->code_level_length;
                $seq=intval(substr($result['code'],$start))+1;
                if($seq>=pow(10,$this->code_level_length)){
                    $this->ajaxError("知识点编码本层已分配完");
                }
            }else{
                $seq=1;
            }
            $code=$pcode.str_pad($seq ,$this->code_level_length,"0", STR_PAD_LEFT);
            $input["parent_id"] = $parent_id;
            $input["code"] = $code;
            $input["status"] = 1;
            $input["sort"] = $seq*10;
        }
        //页面输入字段
        $input["name"] = $name;
        $input["full_path"] =($parent_id?$parent["full_path"]."/":"/").$name;
        $input["level"] = $level;

        $input["description"] = $description;

        $input["modify_user"] = session(C("USER_AUTH_KEY"));
        $input["modify_time"] =  date('Y-m-d H:i:s.n');
        $model->startTrans();

        if($id && $orig['name']!=$name){
            $sql="update @goods_category set full_path=replace(full_path,'".$orig["full_path"]."/','".$input["full_path"]."/') where code!='$code' and code like '$code%'";
            $model->execute(table($sql));
        }

        $result=false;
        //需要存入日志的字段
        $needSave=array(
            'parent_id'=>'上级',
            'code'=>'代码',
            'name'=>'名称',
            'level'=>'层级',
        );

//        'full_path'=>'路径',
//            'approval_require'=>'审批要求',
//            'alarm_days'=>'提前报警',
//            'onlyone'=>'单一题目',

        if(!$id) {
            //新增  建号操作
            $input["create_user"] = session(C("USER_AUTH_KEY"));
            $input["create_time"] = date('Y-m-d H:i:s.n');
            //新增数据 保存数据库
            $result = $id = $model->add($input);
            //建立操作日志
            $result = $result && createLogCommon('goods_category',$id,'新增知识点分类','',"*",'code');
        } else {
            //id存在时判断数据库内数据是否存在
            $orig=$model->where("id='%d'",array($id))->find();
            if(empty($orig)) {
                $this->ajaxError("知识点分类数据不存在");
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
                $result = $result && createLogCommon('goods_category',$id,'变更货品分类',$orig,'','','code',$needSave);
            }
        }
        if($result){
            $model->commit();
        }else{
            $model->rollback();
            echo json_encode(array("msg"=>message("货品分类保存发生错误")));
            die;
        }
        //完成后跳转
        $this->ajaxReturn($data ['pfuncid'],$data ['funcid'],"refresh", "","closepopup" );
        //转到view页面
        //$this->ajaxReturn("","",U("QuestionCategory/index?func=view&id=$id&pfuncid=".$data ['pfuncid']), tabtitle('知识点分类',$input["code"] ) );
        die;
    }


    public function status_on($data)
    {

        $id = I("request.id/d");
        if (!$id) {
            $this->ajaxResult("商品分类分类不存在");
        }
        $search = M('goods_category')->find($id);
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
        $html = $this->fetch("GoodsCategory:status_on");
        echo $html;
    }


    public function status_on_save($data)
    {

        $id = I("request.id/d");
        if (!$id) {
            $this->ajaxResult("商品分类不存在");
        }
        //id存在时判断数据库内数据是否存在
        $orig = M("goods_category")->where("id='%d'", array($id))->find();
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
        $model = M("goods_category");
        $model->startTrans();
        //按主键更新数据
        $result = $model->where("id = $id")->save($input);
        //建立操作日志
        $result = $result && createLogCommon('customer_category', $id, '状态调整', $content);
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
        $search = M('goods_category')->find($id);
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
        $html = $this->fetch("GoodsCategory:status_off");
        echo $html;
    }

    private function status_off_save($data)
    {
        $id = I("request.id/d");
        if (!$id) {
            $this->ajaxResult("商品分类参数不存在");
        }
        //id存在时判断数据库内数据是否存在
        $orig = M("goods_category")->where("id='%d'", array($id))->find();
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
        $model = M("goods_category");
        $model->startTrans();
        //按主键更新数据
        $result = $model->where("id = $id")->save($input);
        //建立操作日志
        $result = $result && createLogCommon('customer_category', $id, '状态调整', $content);
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






    private function view($data)
    {
        $data["p"] = I("request.p/d");
        $data["pagesize"] = I("request.pagesize/d");

        $data["id"] = I("request.id/d");
        $data["no"] = I("request.no");
        if (!$data["id"] && !$data["no"]) {
            $this->ajaxError("知识点分类信息查询参数非法");
        }
        //condition
        $condition = "";
        $joinsql = "";
        //select search fields
        $selectmasterfields = "@goods_category.*";

        //2019-6-10      $selectmasterfields .= ",a.name goods_category_name ";


        $sql = table("select #selectfields# from @goods_category  #join# Where #viewkey# #condition# #orderby#");
        $joinsql .= table(" LEFT JOIN @customer_category a ON a.id=@customer_category.parent_id ");
        if ($data["id"])
            $viewkey = table("@goods_category.id=$data[id]");
        else
            $viewkey = table("@goods_category.code='$data[no]'");
        $sql = str_replace("#selectfields#", table($selectmasterfields), $sql);
        $sql = str_replace("#viewkey#", $viewkey, $sql);
        $sql = str_replace("#condition#", $condition, $sql);
        $sql = str_replace("#orderby#", "", $sql);
        //2019-6-10     $sql = str_replace("#join#", $joinsql, $sql);
        $sql = str_replace("#join#", "", $sql);
        $search = M()->query($sql);

        if (!$search) {
            $this->ajaxError("知识点分类信息信息不存在");
        }
        $data["search"] = current($search);


        //按tabsheet - 开始
        $data["id"] = $data["search"]["id"];
        $data["search"]["_tab"] = $this->tabsheet_check(I("request._tab"));
        $page_size = $data["pagesize"];//session("QuestionCategory-".$data["search"]["_tab"]."-PageSize");
        switch ($data["search"]["_tab"]) {

            case "shijuanmingxi":
                $data = $this->tab_shijuanmingxi_exam_detail($page_size, $data);
                break;
            case "caozuorizhi":
                $data = $this->tab_caozuorizhi_log_common($page_size, $data);
                break;

        }
        $data["search"]["_tab_" . $data["search"]["_tab"] . "_p"] = $data["p"];
        $data["search"]["_tab_" . $data["search"]["_tab"] . "_psize"] = $data["page_size"];
        //session("QuestionCategory-".$data["search"]["_tab"]."-PageSize", $data["page_size"]);
        //按tabsheet - 结束

        foreach ($data as $key => $val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("GoodsCategory:view");
        echo $html;
    }


    //按tabsheet子程序 - 结束

    //按tabsheet子程序 - 结束

    private function deleteProcess($id, &$type)
    {
        $smo = M('goods_category')->where("id='%d'", array($id))->find();
        if (empty($smo)) {
            $this->ajaxResult("部门信息数据不存在");
        }
        if ($smo['status'] != 0) {
            $this->ajaxResult("部门信息状态不能删除");
        }

        $result = true;
        if ($smo['status'] != 0) {
            $result = M('goods_category')->where("id='%d'", array($id))->save(array('status' => 8, 'cancel_time' => date('Y-m-d H:i:s'), 'cancel_status' => 1));
            $result = $result && createLogCommon('goods_category', $id, '取消部门信息', '');
        } else {
            $type = 2;
            $result = $result && createLogCommon('goods_category', $id, '删除部门信息', '');
            $result = $result && M('goods_category')->where("id='%d'", array($id))->delete();
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
            $this->ajaxResult("", "", array("_asr.closeTab", "_asr.closePopup", "_asr.openLink", "_asr.hideConfirm"), array("$('#" . $data["funcid"] . "-Tab').find('a'), '" . $data["funcid"] . "'", "'" . $data["funcid"] . "'", "'" . U("/Home/GoodsCategory/index?func=view&id=" . $id) . "','" . filterFuncId("GoodsCategory_View", "id=$data[id]") . "','部门信息查看', 0", "''"));
        } else {
            $this->ajaxResult("", "", array("_asr.closeTab", "_asr.closePopup", "_asr.openLink", "_asr.hideConfirm"), array("$('#" . $data["funcid"] . "-Tab').find('a'), '" . $data["funcid"] . "'", "'" . $data["funcid"] . "'", "'" . U("/Summary/GoodsCategorySummary/index?func=search&id=" . $id) . "','" . filterFuncId("GoodsCategorySummary_View", "id=$data[id]") . "','部门信息列表', 0", "''"));
        }
        die;
    }

}

?>