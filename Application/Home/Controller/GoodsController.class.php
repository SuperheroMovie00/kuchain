<?php namespace Home\Controller;
//
//注释: Goods - 货品信息列表
//
use Home\Controller\BasicController;
use Think\Log;
class GoodsController extends BasicController {

    public function _init() {
        $funcs = $this->getUserRoleList($this->user,array( 'Goods', '/Home/Goods', ));
        if ($funcs)
            $this->assign("rights",  $funcs);
        else{
            $funcs = array(
                array("key"=>"add","func"=>"/Home/Goods","Action"=>"add") ,
                array("key"=>"refresh","func"=>"GoodsSummary","Action"=>"refresh") ,
                array("key"=>"search","func"=>"GoodsSummary","Action"=>"search") ,
                array("key"=>"save","func"=>"/Home/Goods","Action"=>"save") ,
                array("key"=>"view","func"=>"/Home/Goods","Action"=>"view") ,
                array("key"=>"order_delete","func"=>"/Home/Goods","Action"=>"delete") ,
                array("key"=>"export","func"=>"GoodsSummary","Action"=>"export") ,
                array("key"=>"master_view","func"=>"/Home/Goods","Action"=>"view") ,
                array("key"=>"master_edit","func"=>"/Home/Goods","Action"=>"edit") ,
                array("key"=>"master_delete","func"=>"/Home/Goods","Action"=>"delete") ,
                array("key"=>"status_on","func"=>"/Home/Goods","Action"=>"status_on") ,
                array("key"=>"tabcaozuorizhi","func"=>"/Home/Goods","Action"=>"tabcaozuorizhi") ,
                array("key"=>"tabhuopinbieming","func"=>"/Home/Goods","Action"=>"tabhuopinbieming") ,
                array("key"=>"rela_add","func"=>"/Home/Goods","Action"=>"rela_add") ,
                array("key"=>"edit_rela","func"=>"/Home/Goods","Action"=>"edit_rela") ,
                array("key"=>"rela_save","func"=>"/Home/Goods","Action"=>"rela_save") ,
                array("key"=>"delete_rela","func"=>"/Home/Goods","Action"=>"delete_rela") ,
                array("key"=>"status_off","func"=>"/Home/Goods","Action"=>"status_off")
            );
            $this->assign("rights",  $this->GetUserRights($this->user["id"],$funcs ));
        }


        $this->assign("colshow", $this->GetUserColumnDefine($this->user["id"],"GoodsSummary"));
    }

    public function index() {
        try {
            $data["pfuncid"] = I("request.pfuncid");
            $data["funcid"] = I("request.funcid");
            $data["zindex"] = I("request.zindex/d");
            if(empty($data["funcid"])) $data["funcid"] = "GoodsSummary";
            $this->GetLastUrl($data["funcid"]);

            $func = I("request.func");
            switch ($func)
            {
                case "edit":
                case "add":

                    $this->add($data);
                    break;
                case "createsave":
                    $this->createsave($data);
                    break;
                case "refresh":
                    $this->refresh($data);
                    break;
                case "search":
                    $this->search($data);
                    break;
                case "save":
                    $this->save($data);
                    break;
                case "rela_save":
                    $this->rela_save($data);
                    break;
                case "view":
                    $this->view($data);
                    break;
                case "rela_add":
                case "edit_rela":
                    $this->rela_add($data);
                    break;
                case "delete":
                    $this->order_delete($data);
                    break;
                case "delete_rela":
                    $this->delete_rela($data);
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
                case "export":
                    $this->export($data);
                    break;
                case "columnsetting":
                    $this->columnsetting($data);
                    break;
                case "columnsettingsave":
                    $this->columnsetting_save($data);
                    break;
            }
        } catch(\Exception $e) {
            //$this->ajaxResult("货品信息列表后台错误");
            $this->ajaxResult($e->getMessage());
        }
    }

    private function add($data) {
        //赋初值
        $search["code"] = "";
        $search["name"] = "";
        $search["status"] = "1";  //第一个选项
        $org_id=$this->user["org_id"];

        $id = I("request.id/d");
        if($id){
            $sql = table("select * from @goods where id=$id");
            $search = M()->query($sql);
            if(!$search)
                die;

            if(AuthCheck($this->user,$search[0]["org_id"],0)===false){
                $this->ajaxResult("你没有权限操作此商品");
            }

            if($search[0]['category_code']){
                $where['id'] = $search[0]['category_code'];
                $name = M('goods_category')->field('name')->where($where)->find();
                $customer_parent_name = $name['name'];
                $search[0]['customer_parent_name'] = $customer_parent_name;
            }
            $data["search"] = current($search);
            $data["id"] = $data["search"]["id"];

        }else{
            $data["search"] = $search;
        }

        foreach($data as $key=>$val) {
            $this->assign($key, $val);
        }
         $html = $this->fetch("Goods:add");
//        $html = $this->fetch("Sample:col1");
        echo $html;
    }


//// source for add - begin ////

    /**
     * @param $data
     * @author super
     * 货物新增与修改 （与GoodsStyle中的create相对应）
     */
    private function createsave($data){
        $org_id=$this->user["org_id"];
        $style_info=I("post.style_info_value");
        $style_name=I("post.style_name_value");
        $assign_mode=I("post.assign_mode");     //配送方式
        $active=I("post.active");               //活跃等级
        $org_goods_no=I("post.org_goods_no");  //机构原始码
        //$style_name=I("post.style_name_value");  //货品名称
        $style_code=I("post.style_code_value");
        $full_path=I("post.full_path_value");    //货品分类
        $materials=I("post.materials");          //货品材质
        $prefix=I("post.prefix_value");       //助记码
        $uom_qty=I("post.uom_qty_value");      //数量单位
        $uom_weight=I("post.uom_weight_value");   //重量单位
        $uom_bulkcargo=I("post.uom_bulkcargo_value");//散件单位
        $assign_threshold=I("post.assign_threshold");

        if($assign_threshold<0){
            $this->ajaxResult("配货阈值不能小于0");
        }
        if($assign_threshold>100){
            $this->ajaxResult("配货阈值不能大于100");
        }

        $model = M("goods");
        $goods=$model->where("style_code='".$style_code."'")->find();  //根据code获取货品
        if(!empty($goods)){     //判空
            if($goods["status"]=='1'){           //判状态
                $this->ajaxResult("货物状态不能");
            }

                if(AuthCheck($this->user,$goods["org_id"],0)===false){
                $this->ajaxResult("你没有权限操作此货物");
            }
        }

        $goods_for_org_id=$model->field("org_goods_no")->where("org_id='$org_id'")->select();

        for ($c=0;$c<count($goods_for_org_id);$c++){
            $goods_for_org_id[$c]["org_goods_no"];

            if($org_goods_no==$goods_for_org_id[$c]["org_goods_no"]){
                $this->ajaxResult("同一个联盟的机构原始码不能重复");
            }
        }




        $input["name"] = $style_name;
        $input["materials"] = $materials;
        $input["prefix"] = $prefix;
        $input["org_id"]=$org_id;

        $input["style_code"] = $style_code;
        if(empty($org_goods_no)){
            $this->ajaxResult("机构原始码不能为空！！！");
        }
        $input["org_goods_no"] = $org_goods_no;

        $input["style_info"]=$style_info;

        $input["category_code"] = $full_path;
        $input["uom_qty"] = $uom_qty;
        $input["uom_weight"] = $uom_weight;
        $input["uom_bulkcargo"] = $uom_bulkcargo;
        $input["active"] = $active;
        $input["assign_mode"] = $assign_mode;

        $input["modify_time"] = date('Y-m-d H:i:s.n');
        $input["modify_user"] = session(C("USER_AUTH_KEY"));
        $input["goods_no"] = $style_code;
        $input["assign_threshold"] = $assign_threshold;


        if(empty($goods)){
            $result = $id = $model->add($input);
            $result = $result && createLogCommon('goods',$id,'新增货品','',"*",'code');
        }else{
            $result =  $model->where("id='%d'",$goods['id'])->save($input);
            $id=$goods['id'];
            $result = $result && createLogCommon('goods',$id,'修改货品','',"*",'code');
        }

        $this->ajax_openLink(filterFuncId("/Home/Goods_view", "id=".$id), U("/Home/Goods/index?func=view&id=".$id));
        $this->ajax_closePopup($data["funcid"]);
        $this->ajaxResult();

    }


    private function save($data)
    {
        $id=I("post.id");
        $code_id = I("post.customer_parent_name");
        $user_id = session('USER_ID');
        $org_goods_no = I("post.org_goods_no");
        $goods_no= I("post.goods_no");
        $name = I("post.name");
        $prefix = I("post.prefix");
        $style_info = I("post.style_info");
        $producing_area = I("post.producing_area");
        $materials = I("post.materials");
        $brand = I("post.brand");
        $style_code = I("post.style_code");
        $uom_qty = I("post.uom_qty");
        $uom_weight = I("post.uom_weight");
        $uom_bulkcargo = I("post.uom_bulkcargo");
        $active = I("post.active/d");
        $status = I("post.status/d");
        $goods_categorycode = M('goods_category')->field('id')->where("code='$code_id'")->find();
        if(!$goods_categorycode){
            $this->ajaxResult("goods_categorycodesql异常！！！");
        }
        $category_code = $goods_categorycode['id'];
        $org_id = $this->user["org_id"];

        if(empty($id)) {
            $goods_no = str_replace(" ","",$goods_no);
            if(!verify_value($goods_no,"empty","","")) {
                echo json_encode(array("msg"=>message("%1 必须输入","货品编码","")));
                die;
            }
        }

        /*
        if(!verify_value($category_code,"empty","","")) {
            echo json_encode(array("msg"=>message("%1 必须输入","货品分类","")));
            die;
        }


        $cate=M('goods_category')->where("code='%s'",array($category_code))->find();
        if(empty($cate)){
            echo json_encode(array("msg"=>message("%1 不存在","货品分类","")));
            die;
        }
        */


        if(!verify_value($name,"empty","","")) {
            echo json_encode(array("msg"=>message("%1 必须输入","货品名称","")));
            die;
        }

        if(!verify_value($prefix,"empty","","")) {
            echo json_encode(array("msg"=>message("%1 必须输入","助记码","")));
            die;
        }

        if(!verify_value($style_info,"empty","","")) {
            echo json_encode(array("msg"=>message("%1 必须输入","规格材质","")));
            die;
        }

        if(!verify_value($producing_area,"empty","","")) {
            echo json_encode(array("msg"=>message("%1 必须输入","货品产地","")));
            die;
        }


        $ret = M("goods")->where("goods_no='$goods_no'".($id>0?" and id!=$id":""))->find();
        if($ret){
            echo json_encode(array("msg"=>message("%1[%2] 发生重复","货品编码",$goods_no)));
            die;
        }

        if($_FILES['img'] && $_FILES['img']['error']==0){
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   =     3145728 ;// 设置附件上传大小
            $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
            $upload->savePath  =     ''; // 设置附件上传（子）目录
            // 上传文件
            $info   =   $upload->upload();
            $img=trim($upload->rootPath,'.').$info['img']['savepath'].$info['img']['savename'];
        }else{
            $img=I("post.img_path");
        }

        $model = M("goods");
        //页面输入字段
        $input["category_code"] = $category_code;
        $input["name"] = $name;
        $input["org_id"] = $org_id;
        $input["prefix"] = $prefix;
        $input["style_info"] = $style_info;
        $input["producing_area"] = $producing_area;
        $input["materials"] = $materials;
        $input["brand"] = $brand;
        $input["style_code"] = $style_code;
        $input["uom_qty"] = $uom_qty;
        $input["uom_weight"] = $uom_weight;
        $input["uom_bulkcargo"] = $uom_bulkcargo;
        $input["active"] = $active;
        if($img!=false) {
            $input["img"] = $img;
        }
        $input["status"] = $status;
        $input["modify_time"] = date('Y-m-d H:i:s.n');
        $input["modify_user"] = session(C("USER_AUTH_KEY"));
        $input["goods_no"] = $goods_no;
        $input["org_goods_no"] = $org_goods_no;


        $model->startTrans();
        $result=false;

        $needSave=array(
            'goods_no'=>'货品编码',
            'name'=>'货品名称',
            'prefix'=>'助记码',
            'style_info'=>'规格',
            'materials'=>'材质',
            'category_code'=>'货品分类',
            'producing_area'=>'货品产地',
            'unit'=>'单位',
            'style_code'=>'规格编码',
            'active'=>'活跃等级',
            'status'=>'状态',
        );

        if($id>0){
            $input["modify_time"] = date('Y-m-d H:i:s.n');
            $input["modify_user"] = session(C("USER_AUTH_KEY"));
            $go=$model->where("id='%d'",array($id))->find();

            $result = $model->where("id='%d'",$id)->save($input);
            $isSaveLog=false;
            foreach ($needSave as $key=>$v) {
                if($go[$key]!=$input[$key]) {
                    $isSaveLog=true;
                    break;
                }
            }
            if($isSaveLog)
                $result = $result && createLogCommon('goods',$id,'修改商品',$go,'','','goods_no',$needSave);
        }else{
            $input["create_time"] = date('Y-m-d H:i:s.n');
            $input["create_user"] = session(C("USER_AUTH_KEY"));
            $result = $id = $model->add($input);
            $result = $result && createLogCommon('goods',$id,'新增货品','',"*,goods_no as code");
        }

//        $g=$model->where("id='%d'",$id)->find();

        if($result){
            $model->commit();
        }else{
            $model->rollback();
            echo json_encode(array("msg"=>message("货品信息保存发生错误")));
            die;
        }

        $this->ajax_openLink(filterFuncId("/Home/Goods_view", "id=".$id), U("/Home/Goods/index?func=view&id=".$id),tabtitle('货品',$goods_no));
        $this->ajax_closePopup($data["funcid"]);
        $this->ajaxResult();

//        $this->ajaxResult("", "",  array("_asr.closePopup", "_asr.openLink"), array("'". $data["funcid"]. "'", "'','". $data["pfuncid"]. "','刷新',1"));
    }




    private function status_on($data) {
        $id = I("request.id/d");
        if(!$id) {
            $this->ajaxResult("货品信息参数不存在");
        }
        $search = M('goods')->find($id);
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
        $html = $this->fetch("Goods:status_on");
        echo $html;
    }
    private function status_on_save($data) {
        $id=I("request.id/d" );
        if(!$id) {
            $this->ajaxResult("货品信息参数不存在");
        }
        //id存在时判断数据库内数据是否存在
        $orig=M("goods")->where("id='%d'",array($id))->find();
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
        $model = M("goods");
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
//// source for status_on - end ////
//// source for status_off - begin ////
    private function status_off($data) {
        $id = I("request.id/d");
        if(!$id) {
            $this->ajaxResult("货品信息参数不存在");
        }
        $search = M('goods')->find($id);
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
        $html = $this->fetch("Goods:status_off");
        echo $html;
    }
    private function status_off_save($data) {
        $id=I("request.id/d" );
        if(!$id) {
            $this->ajaxResult("货品信息参数不存在");
        }
        //id存在时判断数据库内数据是否存在
        $orig=M("goods")->where("id='%d'",array($id))->find();
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
        $model = M("goods");
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
//// source for status_off - end ////
//##combine_for_add_source##

//// source for status view ////
    private function view($data) {
        $data["p"] = I("request.p/d");
        $data["pagesize"] = I("request.pagesize/d");

        $data["id"] = I("request.id/d");
        $data["no"] = I("request.no");
        if(!$data["id"] && !$data["no"]) {
            $this->ajaxError("货品信息查询参数非法");
        }

        //condition
        $condition="";
        $joinsql="";
        //select search fields
        $selectmasterfields="@goods.*";



        $sql = table("select #selectfields# from @goods  #join# Where #viewkey# #condition# #orderby#");
        if($data["id"])
            $viewkey=table("@goods.id=$data[id]");
        else
            $viewkey="goods_no='$data[no]'";
        $sql = str_replace("#selectfields#",table($selectmasterfields),$sql);
        $sql = str_replace("#join#",$joinsql,$sql);
        $sql = str_replace("#viewkey#",$viewkey,$sql);
        $sql = str_replace("#condition#",$condition,$sql);
        $sql = str_replace("#orderby#","",$sql);
        $search = M()->query($sql);
        if(!$search){
            $this->ajaxError("货品信息不存在");
        }
        $data["search"] = current($search);

        if($data["search"] && $data["search"]['org_id']){
            $parent=M('org')->where("id='%d'",array($data["search"]['org_id']))->find();
            if($parent){
                $data["search"]['org_id_name']=$parent['name'];
            }
        }

        //按tabsheet - 开始
        $data["id"] = $data["search"]["id"];
        $data["search"]["_tab"] = $this->tabsheet_check(I("request._tab"));
        $page_size=$data["pagesize"] ;//session("Warehouse-".$data["search"]["_tab"]."-PageSize");
        switch($data["search"]["_tab"])
        {
            case "huopinbieming":
                $data = $this->tab_huopinbieming_goods_rela($page_size,$data);
                break;
            case "cunchuka":

                break;
            case "cunchukamadan":

                break;
            case "cunchukaduohao":

                break;
            case "cunchukataizhang":

                break;
            case "cunchukajiasuo":

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
        $html = $this->fetch("Goods:view");
        echo $html;
    }

    private function tabsheet_check($itab)
    {
        $idefault="huopinbieming";
        switch($itab)
        {

            case "huopinbieming":
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

    //按tabsheet子程序 - 开始

    private function tab_caozuorizhi_log_common($tab_pagesize,$data)
    {
        $orderby="order by create_time desc";
        $joinsql="";


        $condition = "" ;


        //select detail fields
        $selectfields ="@log_common.id ";
        $selectfields.=",@log_common.create_time ";
        $selectfields.=",@log_common.type ";
        $selectfields.=",@log_common.data_id ";
        $selectfields.=",@log_common.data_code ";
        $selectfields.=",@log_common.status ";
        $selectfields.=",@log_common.subject ";
        $selectfields.=",@log_common.content ";

        $viewkey="@log_common.data_id='".$data["search"]["id"]."'";
        $viewkey.=" and @log_common.type='goods'";
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
        $data["page"] = $pageClass->show_drp($data["funcid"]);
        $data["page_size"] = $page_size;

        return $data;
    }

    private function tab_huopinbieming_goods_rela($tab_pagesize,$data)
    {
        $orderby="order by create_time desc";
        $joinsql="";

        $condition="";

        //获取当前登陆者的库链ID
        $user_id = session('USER_ID');
        $rg_id = M('user')->field('org_id')->where("id='$user_id'")->find();


        //select detail fields
        $selectfields ="@goods_rela.id ";
        $selectfields.=",@goods_rela.org_id ";
        $selectfields.=",@goods_rela.goods_id ";
        $selectfields.=",@goods_rela.style_info ";
        $selectfields.=",@goods_rela.materials ";
        $selectfields.=",@goods_rela.brand ";
        $selectfields.=",@goods_rela.create_time ";
        $selectfields.=",@goods_rela.create_user ";

        $viewkey="@goods_rela.goods_id='".$data["search"]["id"]."' and @goods_rela.org_id='".$rg_id["org_id"]."'";
        //   if(!$viewkey)
        //      die;

        $page_size = $tab_pagesize;
        if (!$page_size) {
            $page_size = 10;
        }

        $count_sql = table("select count(*) as cnt from @goods_rela  #join# where #viewkey# #condition#");
        $search_sql = table("select #selectfields# from @goods_rela  #join# Where #viewkey# #condition# #orderby#");

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

        // date: 2019-7-3 原因：查看商品详细信息报错，注释掉之后正常  $data["page"] = $pageClass->show_drp($data["funcid"]);
        $data["page_size"] = $page_size;

        return $data;
    }


    private function order_delete($data) {

        $id=I("request.id/d" );
        $type=I("request.type/d" );
        if(!$id) {
            $this->ajaxResult("货品信息参数不存在");
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

    private function deleteProcess($id) {
        $type=1;
        $smo=M('goods')->where("id='%d'",array($id))->find();
        if(empty($smo)) {
            $this->ajaxResult("货品信息数据不存在");
        }
        if($smo['status']!=0){
            $this->ajaxResult("货品信息状态不能删除");
        }

        $result=true;
        $result = $result && createLogCommon('goods',$id,($smo['status']?'取消信息':'删除记录'),'');
        if($smo['status']!=0){
            $result = $result && M('goods')->where("id='%d'",array($id))->save(array('lastchanged'=>date('Y-m-d H:i:s')));
        }else{
            $result = $result && M('goods')->where("id='%d'",array($id))->delete();
        }
        return $result;
    }

    public function rela_add($data){
        //赋初值
//        $user_id = session('USER_ID');
//        $rg_id = M('user')->field('org_id')->where("id='$user_id'")->find();
//        $org_id = $rg_id['org_id'];

        $id = I("request.id/d");
        $where['id'] = $id;
        $name = M('goods')->where($where)->field('name,style_info,materials,brand')->find();
        $act = I("request.act");

        if ($act == 'edit') {
            $sql = table("select * from @goods_rela where id=$id");
            $rela = M()->query($sql);
            if (!$rela)
                die;
            if ($rela[0]['goods_id']) {
                $where['id'] = $rela[0]['goods_id'];
                $name = M('goods')->field('name,style_info,materials,brand')->where($where)->find();
                $rela[0]['goods_name'] = $name['name'];
                $rela[0]['old_style_info'] = $name['style_info'];
                $rela[0]['old_materials'] = $name['materials'];
                $rela[0]['old_brand'] = $name['brand'];
            }
            $data["search"] = current($rela);
            $data["id"] = $data["search"]["id"];
        } else {
            $search['goods_id'] = $id;
            $search['goods_name'] = $name['name'];
            $search['old_style_info'] = $name['style_info'];
            $search['old_materials'] = $name['materials'];
            $search['old_brand'] = $name['brand'];
            $data["search"] = $search;
        }

        foreach ($data as $key => $val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("Goods:rela_add");
        echo $html;
    }




    private function rela_save($data)
    {
        $id=I("post.id");
        $code_id = I("post.goods_id");
        $code = M('goods')->field('id,style_info,brand,materials')->where("name='$code_id'")->find();
        $goods_id = $code['id'];
        $style_info = trim(I("post.style_info"));
        $materials= trim(I("post.materials"));
        $brand = trim(I("post.brand"));
        //获取当前登陆者的库链ID
        $user_id = session('USER_ID');
        $rg_id = M('user')->field('org_id')->where("id='$user_id'")->find();

        //如果字段内容经过转化为大写之后相同则为空
        if(strtoupper($code['style_info']) == strtoupper($style_info)){
            $style_info = '';
        }
        if(strtoupper($code['materials']) == strtoupper($materials)){
            $materials = '';
        }
        if(strtoupper($code['brand']) == strtoupper($brand)){
            $brand = '';
        }

        if($style_info == '' && $materials == '' && $brand == ''){
            echo json_encode(array("msg"=>message("%1 不能都为空或与原商品属性都相同","规格、材质、商标","")));
            die;
        }

        //判断输入内容与已存在信息是否重复
        $where['style_info'] = $style_info;
        $where['materials'] = $materials;
        $where['brand'] = $brand;
        $where["org_id"] = $rg_id['org_id'];
        $where["goods_id"] = $goods_id;
        $existed = M('goods_rela')->where($where)->find();

        if($existed){
            echo json_encode(array("msg"=>message("%1 信息已存在","规格、材质、商标")));
            die;
        }

        $model = M("goods_rela");
        //页面输入字段

        $input["goods_id"] = $goods_id;
        $input["style_info"] = $style_info;
        $input["materials"] = $materials;
        $input["brand"] = $brand;
        $model->startTrans();
        $result=false;

        $needSave=array(
            'goods_id'=>'货品id',
            'style_info'=>'规格',
            'materials'=>'材质',
            'brand'=>'商标',
        );

        if($id>0){

            $go=$model->where("id='%d'",array($id))->find();
            $result = $model->where("id='%d'",$id)->save($input);
            $isSaveLog=false;
            foreach ($needSave as $key=>$v) {
                if($go[$key]!=$input[$key]) {
                    $isSaveLog=true;
                    break;
                }
            }
            if($isSaveLog)
                $result = $result && createLogCommon('goods_rela'   ,$id,'修改商品别名',$go,'','','goods_no',$needSave);
        }else{

            $user_id = session('USER_ID');
            $rg_id = M('user')->field('org_id')->where("id='$user_id'")->find();
            $input["org_id"] = $rg_id['org_id'];
            $input["create_time"] = date('Y-m-d H:i:s.n');
            $input["create_user"] = session(C("USER_AUTH_KEY"));
            $result = $id = $model->add($input);
            $result = $result && createLogCommon('goods_rela',$id,'新增货品别名','',"");
        }

//        $g=$model->where("id='%d'",$id)->find();

        if($result){
            $model->commit();
        }else{
            $model->rollback();
            echo json_encode(array("msg"=>message("货品信息保存发生错误")));
            die;
        }

        $this->ajax_refresh($data ['pfuncid']);
        $this->ajax_closePopup($data["funcid"]);
        $this->ajaxResult();

//        $this->ajaxResult("", "",  array("_asr.closePopup", "_asr.openLink"), array("'". $data["funcid"]. "'", "'','". $data["pfuncid"]. "','刷新',1"));
    }

    private function delete_rela($data) {

        $id=I("request.id/d" );
        $type=I("request.type/d" );
        if(!$id) {
            $this->ajaxResult("货品别名信息参数不存在");
        }

        $m=M();
        $m->startTrans();
        $r=$this->deleteProcess_rela($id);
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

    private function deleteProcess_rela($id) {
        $type=1;
        $smo=M('goods_rela')->where("id='%d'",array($id))->find();
        if(empty($smo)) {
            $this->ajaxResult("货品别名信息数据不存在");
        }
        if($smo['status']!=0){
            $this->ajaxResult("货品别名信息状态不能删除");
        }

        $result=true;
        $result = $result && createLogCommon('goods_rela',$id,($smo['status']?'取消别名信息':'删除记录'),'');

        $result = $result && M('goods_rela')->where("id='%d'",array($id))->delete();

        return $result;
    }


}