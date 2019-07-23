<?php
namespace Home\Controller;


class GoodsStyleController extends BasicController{




    public function _init() {
        $funcs = $this->getUserRoleList($this->user,array( 'GoodsCategory', '/Home/GoodsCategory', ));
        if ($funcs)
            $this->assign("rights",  $funcs);
        else{
            $funcs = array(
                array("key"=>"refresh","func"=>"User","Action"=>"refresh"),
                array("key"=>"edit_base","func"=>"/Home/GoodsCategory","Action"=>"edit_base") ,
                array("key"=>"edit","func"=>"/Home/GoodsCategory","Action"=>"edit") ,
            );
            $this->assign("rights",  $this->GetUserRights($this->user["id"],$funcs ));
        }
        $this->assign("colshow", $this->GetUserColumnDefine($this->user["id"],"User"));
    }


    public function index() {
        $data["pfuncid"] = I("request.pfuncid");
        $data["funcid"] = I("request.funcid");
        $data["zindex"] = I("request.zindex/d");
        if(empty($data["funcid"])) $data["funcid"] = "GoodsCategory";
        $this->GetLastUrl($data["funcid"]);

        $func = I("request.func");
        if($func != "saveSelectProduct" && $func != "save") {
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


    private function add($data) {
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

            $search = M("goods_style")->find($id);
            /*if(!$search){
                $this->ajaxResult("知识点分类数据不存在" );
            }*/
            if(!empty($search["category_code"])){
                $goodcategory=M("goods_category")->field("full_path")->where(" code='".$search["category_code"]."'")->find();
                if(!empty($goodcategory)){
                    $search["parent_id_name"]=$goodcategory["full_path"];
                }
            }
            $data["id"] = $search["id"];
        }
        $data["search"] = $search;
        //检查popup返回name
        if($data['search']['parent_id']){
            $ret=M( "goods_style" )
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

        $html = $this->fetch("GoodsStyle:add");    /*跳转到QuestionCategory 目录下的add*/
        echo $html;
    }

    /**
     * @param $datad
     * @author super
     * 创建新的货物
     */
    private function create($data){

        $search["code"] = "";
        $search["name"] = "";
        $search["status"] = "1";  //第一个选项
        $id = I("request.id/d");
        $pid = I("request.pid/d");
        $org_id = $this->user['org_id'];
        if(empty($pid) && empty($id)){
            $this->ajaxError("id为空，程序退出");
        }
        if(!empty($pid)){
            $goods_style=M("goods_style")->field("style_code")->find($pid);
        }
        //如果传输的是
        if(!empty($id)){
            $goods_style=M("goods")->field("style_code")->find($id);
        }


        if(empty($goods_style)){
            $this->ajaxError("货品详情不存在");
        }else{
            if($goods_style["status"]=='0'){
                $this->ajaxError("货品详情状态无效");
            }
            $goods=M("goods")->where("style_code= '".$goods_style["style_code"]."' and  org_id='$org_id'")->find();  //根据规格id查询有没有货物

            /*if(!empty($goods)){
                if(AuthCheck($this->user,$goods["org_id"],0)===false){
                    $this->ajaxResult("你没有权限操作此商品");
                }
            }*/

        }

        if($pid){
            $search = M("goods_style")->find($pid);
            if(!$search)
                die;
            if(!empty($search[0]['category_code'])){  //如果货品分类不为空
                $where['id'] = $search[0]['category_code'];
                $name = M('goods_category')->field('name')->where($where)->find();
                $customer_parent_name = $name['name'];
                $search[0]['customer_parent_name'] = $customer_parent_name;
            }
            if(!empty($goods)){ //如果商品存在

                $search["org_goods_no"]=  $goods["org_goods_no"];
                $search["active"]=$goods["active"];
                $search["assign_mode"]=$goods["assign_mode"];
                $search["assign_threshold"]=$goods["assign_threshold"];
            }
            $goodscategory=M("goods_category")->field("full_path")->where("code='".$search["category_code"]."'")->find();
            $search["full_path"]=$goodscategory["full_path"];
            $data["search"] = $search;
            $data["id"] = $data["search"]["id"];

        }else if ($id){
            $search = M("goods_style")->where("style_code='".$goods_style["style_code"]."'")->find();
            if(!$search)
                die;
            if(!empty($search[0]['category_code'])){  //如果货品分类不为空
                $where['id'] = $search[0]['category_code'];
                $name = M('goods_category')->field('name')->where($where)->find();
                $customer_parent_name = $name['name'];
                $search[0]['customer_parent_name'] = $customer_parent_name;
            }
            if(!empty($goods)){ //如果商品存在

                $search["org_goods_no"]=  $goods["org_goods_no"];
                $search["active"]=$goods["active"];
                $search["assign_mode"]=$goods["assign_mode"];
                $search["assign_threshold"]=$goods["assign_threshold"];
            }
            $goodscategory=M("goods_category")->field("full_path")->where("code='".$search["category_code"]."'")->find();
            $search["full_path"]=$goodscategory["full_path"];
            $data["search"] = $search;
            $data["id"] = $data["search"]["id"];

        }else{
            $data["search"] = $search;
        }
        foreach($data as $key=>$val) {
            $this->assign($key, $val);
        }

        if(!empty($pid)){
            $html = $this->fetch("GoodsStyle:addod1");
        }

        if(!empty($id)){
            $html = $this->fetch("GoodsStyle:addod2");
        }
        echo $html;
    }



    public  function  save($data){
        $id=I("request.id/d" );
        //读取页面输入数据
        $category_code = I("request.parent_id");
        if(empty($category_code)){
            $category_code=I("request.category_code");
        }
        $style_code = I("request.style_code");
        $style_name = I("request.style_name");
        $prefix = I("request.prefix");
        $uom_qty = I("request.uom_qty");
        $uom_weight = I("request.uom_weight",0);
        $uom_bulkcargo = I("request.uom_bulkcargo");
        $materials=I("request.materials");
        $tax_rate = I("request.tax_rate");                    //税率先暂时定为死值 0.13
        $assign_threshold=I("request.assign_threshold");

        //非页面输入字段
        $input = array();

        //数据有效性校验，非空/数值负数，范围/日期与今日比较

        //数据校验 - 必输项不能为空
        //if(!verify_value($category_code,"empty","","")) $this->ajaxError("货品分类不能为空");
        if(!verify_value($style_code,"empty","","")) $this->ajaxError("规格编码不能为空");
        if(!verify_value($style_name,"empty","","")) $this->ajaxError("规格名称不能为空");
        if(!verify_value($uom_qty,"empty","","")) $this->ajaxError("数量单位不能为空");
        if(!verify_value($uom_weight,"empty","","")) $this->ajaxError("重量单位不能为空");
        if(!verify_value($assign_threshold,"empty","","")){
            $this->ajaxError("配货阈值不能为空");
        }else{
            if($assign_threshold<0){
                $this->ajaxError("配货阈值必须为正数");
            }
            if($assign_threshold>100){
                $this->ajaxError("配货阈值不能大于100");
            }
        }
        // "备注" 长度超200位，没有生成非空检测
        $model = M("goods_style");


        //判断 code 是否重复建立
        //$orig = $model->where("code='$category_code'".($id?" and id!=$id":""))->find();
        //if ($orig) $this->ajaxError("用户 $category_code 已存在");

        //页面输入字段
        $input["category_code"] = $category_code;
        $input["style_code"] = $style_code;
        $input["style_name"] = $style_name;
        $input["materials"]=$materials;
        $input["prefix"] = $prefix;
        $input["uom_qty"] = $uom_qty;
        $input["uom_weight"] = $uom_weight;
        $input["uom_bulkcargo"] = $uom_bulkcargo;
        $input["tax_rate"] = 0.13;
        $input["assign_threshold"] =  $assign_threshold;


        $input["modify_user"] = $this->user["id"];
        $input["modify_time"] =  date('Y-m-d H:i:s.n');

        $model->startTrans();
        $result=false;

        //需要存入日志的字段
        $needSave=array(
            'code'=>'用户',
            'name'=>'姓名',
        );

        if(!$id) {
            //新增  建号操作

            $input["create_user"] = $this->user["id"];
            $input["create_time"] = date('Y-m-d H:i:s.n');

            //新增数据 保存数据库
            $result = $id = $model->add($input);
            //建立操作日志
            $result = $result && createLogCommon('goods_style',$id,'新增货品详情信息','',"*",'code');

        } else {
            //id存在时判断数据库内数据是否存在
            $old=$model->where("id='%d'",array($id))->find();
            if(empty($old)) {
                $this->ajaxError("用户信息数据不存在");
            }

            //按主键更新数据
            $result = $model->where("id = $id")->save($input);

            $isSaveLog=false;
            foreach ($needSave as $key=>$v) {
                if($old[$key]!=$input[$key]) {
                    $isSaveLog=true;
                    break;
                }
            }
            if($isSaveLog){
                //建立操作日志
                $result = $result && createLogCommon('goods_style',$id,'变更货品信息信息',$old,'','','code',$needSave);
            }
        }
        if($result){
            $model->commit();
        }else{
            $model->rollback();
            echo json_encode(array("msg"=>message("用户信息保存发生错误")));
            die;
        }

        //完成后刷新
        $this->ajaxReturn($data ['pfuncid'],$data ['funcid'],"refresh", "","closepopup", 1 );
        //转到view页面
        $this->ajaxReturn("","",U("Home/GoodsStyle/index?func=view&id=$id"), tabtitle('用户',$input["code"] ) );
        die;
    }





    private function deleteProcess($id, &$type)
    {
        $smo = M('goods_style')->where("id='%d'", array($id))->find();
        if (empty($smo)) {
            $this->ajaxResult("商品规格数据不存在");
        }
        if ($smo['status'] != 0) {
            $this->ajaxResult("商品规格状态不能删除");
        }

        $result = true;
        if ($smo['status'] != 0) {
            $result = M('goods_style')->where("id='%d'", array($id))->save(array('status' => 8, 'cancel_time' => date('Y-m-d H:i:s'), 'cancel_status' => 1));
            $result = $result && createLogCommon('goods_style', $id, '取消商品规格信息', '');
        } else {
            $type = 2;
            $result = $result && createLogCommon('goods_style', $id, '删除商品规格信息', '');
            $result = $result && M('goods_style')->where("id='%d'", array($id))->delete();
        }
        return $result;
    }

    private function order_delete($data)
    {
 //******************首先判断此类型是否在goods表中使用
        $id = I("request.id/d");
        $style_code =  M('goods_style')->field("style_code")->where("id='%d'",$id)->find();

        $smo = M('goods')->where("style_code='%d'",$style_code )->find();
        if($smo){
            $this->ajaxResult("商品表使用中，不能删除");
        }
//******************首先判断此类型是否在goods表中使用

        if (!$id) {
            $this->ajaxResult("商品规格信息参数不存在");
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
            $this->ajaxResult("", "", array("_asr.closeTab", "_asr.closePopup", "_asr.openLink", "_asr.hideConfirm"), array("$('#" . $data["funcid"] . "-Tab').find('a'), '" . $data["funcid"] . "'", "'" . $data["funcid"] . "'", "'" . U("/Home/GoodsStyle/index?func=view&id=" . $id) . "','" . filterFuncId("GoodsStyle_View", "id=$data[id]") . "','部门信息查看', 0", "''"));
        } else {
            $this->ajaxResult("", "", array("_asr.closeTab", "_asr.closePopup", "_asr.openLink", "_asr.hideConfirm"), array("$('#" . $data["funcid"] . "-Tab').find('a'), '" . $data["funcid"] . "'", "'" . $data["funcid"] . "'", "'" . U("/Summary/GoodsStyleSummary/index?func=search&id=" . $id) . "','" . filterFuncId("GoodsStyleSummary_View", "id=$data[id]") . "','部门信息列表', 0", "''"));
        }
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
        $selectmasterfields = "@goods_style.*";
        //2019-6-10      $selectmasterfields .= ",a.name goods_category_name ";

        $sql = table("select #selectfields# from @goods_style  #join# Where #viewkey# #condition# #orderby#");
        $joinsql .= table(" LEFT JOIN @goods_style a ON a.id=@goods_style.parent_id ");
        if ($data["id"])
            $viewkey = table("@goods_style.id=$data[id]");
        else
            $viewkey = table("@goods_style.code='$data[no]'");
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
        $html = $this->fetch("GoodsStyle:view");
        echo $html;
    }



    private function status_on($data) {
        $id = I("request.id/d");
        if(!$id) {
            $this->ajaxResult("货品信息参数不存在");
        }
        $search = M('goods_style')->find($id);
        if(!$search)
            $this->ajaxResult("货品信息不存在");
        if($search['status']=='7'){
            $this->ajaxResult("货品信息已取消");
        }
        if($search['status']!='0'){
            $this->ajaxResult("货品信息状态已变化，请重新处理");
        }
        $data["search"] = $search;
        $data["id"] = $data["search"]["id"];
        foreach($data as $key=>$val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("GoodsStyle:status_on");
        echo $html;
    }

    private function status_on_save($data) {
        $id=I("request.id/d" );
        if(!$id) {
            $this->ajaxResult("货品信息参数不存在");
        }
        //id存在时判断数据库内数据是否存在
        $orig=M("goods_style")->where("id='%d'",array($id))->find();
        if(empty($orig)) {
            $this->ajaxError("货品信息数据不存在");
        }
        if($orig['status']=='7'){
            $this->ajaxResult("货品信息已取消");
        }
        if($orig['status']!='0'){
            $this->ajaxResult("货品信息状态已变化，请重新处理");
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
        $model = M("goods_style");
        $model->startTrans();
        //按主键更新数据
        $result = $model->where("id = $id")->save($input);
        //建立操作日志
        $result = $result && createLogCommon('goods_style',$id,'状态调整',$content);
        if($result){
            $model->commit();
        }else{
            $model->rollback();
            echo json_encode(array("msg"=>message("货品信息保存发生错误")));
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
            $this->ajaxResult("货品信息参数不存在");
        }
        $search = M('goods_style')->find($id);
        if(!$search)
            $this->ajaxResult("货品信息不存在");
        if($search['status']=='7'){
            $this->ajaxResult("货品信息已取消");
        }
        if($search['status']!='1'){
            $this->ajaxResult("货品信息状态已变化，请重新处理");
        }
        $data["search"] = $search;
        $data["id"] = $data["search"]["id"];
        foreach($data as $key=>$val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("GoodsStyle:status_off");
        echo $html;
    }
    private function status_off_save($data) {
        $id=I("request.id/d" );
        if(!$id) {
            $this->ajaxResult("货品信息参数不存在");
        }
        //id存在时判断数据库内数据是否存在
        $orig=M("goods_style")->where("id='%d'",array($id))->find();
        if(empty($orig)) {
            $this->ajaxError("货品信息数据不存在");
        }
        if($orig['status']=='7'){
            $this->ajaxResult("货品信息已取消");
        }
        if($orig['status']!='1'){
            $this->ajaxResult("货品信息状态已变化，请重新处理");
        }
        $reason_tag=I("request.reason_tag" );
        $reason=I("request.reason" );
        if(!($reason_tag.$reason)){
            $this->ajaxResult("货品信息状态回退，需注明原因");
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
        $model = M("goods_style");
        $model->startTrans();
        //按主键更新数据
        $result = $model->where("id = $id")->save($input);
        //建立操作日志
        $result = $result && createLogCommon('goods',$id,'状态调整',$content);
        if($result){
            $model->commit();
        }else{
            $model->rollback();
            echo json_encode(array("msg"=>message("货品信息保存发生错误")));
            die;
        }
        //完成后关闭并刷新父窗口
        $this->ajaxReturn($data ['pfuncid'],$data ['funcid'],"refresh", "","closepopup");
        die;
    }




}


?>