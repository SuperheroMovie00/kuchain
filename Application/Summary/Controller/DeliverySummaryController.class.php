<?php namespace Summary\Controller;
//
//注释: DeliverySummary - 提单列表
//
use Home\Controller\BasicController;
use Think\Log;
class DeliverySummaryController extends BasicController {

    public function _init() {
        $funcs = $this->getUserRoleList($this->user,array( 'DeliverySummary', '/Home/Delivery', ));
        if ($funcs)
            $this->assign("rights",  $funcs);
        else{
            $funcs = array(
                         array("key"=>"refresh","func"=>"DeliverySummary","Action"=>"refresh") ,
                         array("key"=>"search","func"=>"DeliverySummary","Action"=>"search") ,
                         array("key"=>"export","func"=>"DeliverySummary","Action"=>"export") ,
                         array("key"=>"master_view","func"=>"/Home/Delivery","Action"=>"view")
             );
            $this->assign("rights",  $this->GetUserRights($this->user["id"],$funcs ));
        }
        $this->assign("colshow", $this->GetUserColumnDefine($this->user["id"],"DeliverySummary"));
    }

    public function index() {
         try {
        $data["pfuncid"] = I("request.pfuncid");
        $data["funcid"] = I("request.funcid");
        $data["zindex"] = I("request.zindex/d");
        if(empty($data["funcid"])) $data["funcid"] = "DeliverySummary";
        $this->GetLastUrl($data["funcid"]);

        $func = I("request.func");
        switch ($func)
        {
          case "refresh":
               $this->refresh($data);
               break;
          case "search":
               $this->search($data);
               break;
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
          //$this->ajaxResult("提单列表后台错误");
          $this->ajaxResult($e->getMessage());
      }
    }


    private function columnsetting_define(){
        return array(
            'status'=>'状态',
            'org_id'=>'库联',
            'customer_name'=>'客户名称',
            'tx_date'=>'开单日期',
            'delivery_no'=>'提货单号',
            'delivery_date'=>'提单日期',
            'warehouse_code'=>'仓库编码',
            'goods_no'=>'货品编码',
            'goods_name'=>'货品名称',
            'style_info'=>'规格',
            'materials'=>'材质',
            'brand'=>'商标',
            'producing_area'=>'产地',
            'style_code'=>'货品基础码',
            'batchno'=>'货品批号',
            'storecard_id'=>'存储卡',
            'storecard_no'=>'存储卡号',
            'weight'=>'重量',
            'qty'=>'数量',
            'bulkcargo'=>'散件',
            'uom_qty'=>'数量单位',
            'uom_weight'=>'重量单位',
            'uom_bulkcargo'=>'散件单位',
            'buyer_id'=>'买家',
            'buyer_code'=>'买家编码',
            'buyer_name'=>'买家名称',
            'delivery_carno'=>'提货车号',
            'delivery_contact'=>'提货人员',
            'delivery_phone'=>'提货电话',
            'delivery_idcard'=>'提货身份证',
            'is_whole'=>'整卡',
            'expired_time'=>'截至时间',
            'is_expired'=>'过期',
            'bills_confirm'=>'款项确认',
            'payment_type'=>'付款类型',
            'payment_customer_id'=>'付款客户',
            'payment_customer'=>'付款客户',
            'payment_path'=>'付款图像',
            'vcode'=>'VCODE',
            'transfer_fee'=>'过户费(元)',
            'op'=>'OP',
            'original_status'=>'原始状态',
            'stock_weight'=>'实发重量',
        );
    }

    private function columnsetting($data){
        $data['user_code']=session(C("USER_AUTH_KEY"));
        $data['summary']='DeliverySummary';
        $data['column']=$this->columnsetting_define();

        $usc = M('user_summary_column')->where("user_code='%s' AND summary='%s' AND `show`='%d'",array(session(C("USER_AUTH_KEY")),$data['summary'],1))->select();
        $data['column_check']=array();
        foreach ($usc as $k=>$v) {
            $data['column_check'][$v['column']]=1;
        }

        foreach($data as $key=>$val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("Common:columnsetting");
        echo $html;
    }

    private function columnsetting_save($data){
        $data["funcid"] = I("request.funcid");
        $data["column"] = I("request.column");
        $data["column_check"] = I("request.column_check");
        $data["summary"] = I("request.summary");
        $result=true;
        $model=M('user_summary_column');
        $model->startTrans();

        $model->where("user_code='%s' AND summary='%s'",array(session(C("USER_AUTH_KEY")),$data["summary"]))->delete();

        $selectall = count($this->columnsetting_define())==count($data["column_check"]);

        if (!$selectall) {
          foreach ($data["column"] as $k=>$v) {
              $result = $model->add(array(
                  'user_code'=>session(C("USER_AUTH_KEY")),
                  'summary'=>$data['summary'],
                  'column'=>$k,
                  'show'=>isset($data['column_check'][$k])?1:0,
              ));
              if (!$result) break;
          }
        }
        if($result){
            $model->commit();
        }else{
            $model->rollback();
        }

        $this->ajaxResult("", "",  array("_asr.closeTab","_asr.closePopup", "_asr.openLink","_asr.hideMask()"), array("$('#".$data["funcid"]."-Tab').find('a'), '".$data["funcid"]."'","'".$data["funcid"]."'", "'". U("/Summary/DeliverySummary/index?func=search&").  "','".filterFuncId("DeliverySummary_Search","id=0")."','提单列表', 1",""));


    }


    private function refresh(){
      $this->search();
    }

    private function search($data) {
         $today= date('Y-m-d');
         $month= date('Y-m');
         $year= date('Y');
       $yesterday=date('Y-m-d', strtotime( '-1 day'));

       $search_auth_codes = "";
       $data["p"] = I("request.p/d");
       $__refresh = I("request.__refresh/d");
       $search["_searchexpand"] = I("request._searchexpand");
       $search["_showsearch"] = I("request._showsearch");
       if(empty($search["_showsearch"]) || $__refresh=="1"){
           $search["_showsearch"]="hide";
       }
       //读取关键字搜索内容
       $search["_keyword"] = I("request._keyword");

       //首次运行判断及设置
       $firstloading=false;
       $search["_issearch"] = I("request._issearch");
       if($search["_issearch"]!="1" && $search["_issearch"]!="0"){
           $firstloading=true;
           $search["_issearch"] = "1";
       }
       $bsearch = $search["_issearch"] == 1;
       $search["_execsearch"] = $search["_issearch"];
       $search["_issearch"] = 1;  //execsearch必须放在 issearch 前面, 记住前一步状态


       //读取tab参数
       $search["_tab"] = $this->tabsheet_check(I("request._tab"));

       //读取页面参数
       $search["status"] = I("request.status");
       $search["org_id"] = I("request.org_id");
       $search["customer_id_name"] = I("request.customer_id_name");
       $search["customer_id"] = I("request.customer_id");
       $search["customer_name"] = I("request.customer_name");
       $search["tx_date"] = I("request.tx_date");
       $search["tx_date2"] = I("request.tx_date2");
       $search["delivery_no"] = I("request.delivery_no");
       $search["delivery_date"] = I("request.delivery_date");
       $search["delivery_date2"] = I("request.delivery_date2");
       $search["warehouse_code_name"] = I("request.warehouse_code_name");
       $search["warehouse_code"] = I("request.warehouse_code");
       $search["goods_no"] = I("request.goods_no");
       $search["goods_name"] = I("request.goods_name");
       $search["style_info"] = I("request.style_info");
       $search["materials"] = I("request.materials");
       $search["brand"] = I("request.brand");
       $search["producing_area"] = I("request.producing_area");
       $search["style_code"] = I("request.style_code");
       $search["batchno"] = I("request.batchno");
       $search["storecard_id"] = I("request.storecard_id");
       $search["storecard_no"] = I("request.storecard_no");
       $search["weight"] = I("request.weight");
       $search["weight2"] = I("request.weight2");
       $search["qty"] = I("request.qty");
       $search["qty2"] = I("request.qty2");
       $search["bulkcargo"] = I("request.bulkcargo");
       $search["bulkcargo2"] = I("request.bulkcargo2");
       $search["uom_qty"] = I("request.uom_qty");
       $search["uom_weight"] = I("request.uom_weight");
       $search["uom_bulkcargo"] = I("request.uom_bulkcargo");
       $search["buyer_id"] = I("request.buyer_id");
       $search["buyer_code"] = I("request.buyer_code");
       $search["buyer_name"] = I("request.buyer_name");
       $search["delivery_carno"] = I("request.delivery_carno");
       $search["delivery_contact"] = I("request.delivery_contact");
       $search["delivery_phone"] = I("request.delivery_phone");
       $search["delivery_idcard"] = I("request.delivery_idcard");
       $search["is_whole"] = I("request.is_whole");
       $search["expired_time"] = I("request.expired_time");
       $search["expired_time2"] = I("request.expired_time2");
       $search["is_expired"] = I("request.is_expired");
       $search["bills_confirm"] = I("request.bills_confirm");
       $search["payment_type"] = I("request.payment_type");
       $search["payment_customer_id"] = I("request.payment_customer_id");
       $search["payment_customer"] = I("request.payment_customer");
       $search["payment_path"] = I("request.payment_path");
       $search["vcode"] = I("request.vcode");
       $search["transfer_fee"] = I("request.transfer_fee");
       $search["transfer_fee2"] = I("request.transfer_fee2");
       $search["op"] = I("request.op");
       $search["original_status"] = I("request.original_status");
       $search["original_status2"] = I("request.original_status2");
       $search["stock_weight"] = I("request.stock_weight");
       $search["stock_weight2"] = I("request.stock_weight2");

       //判断首次装载是否要赋予缺省值
       if($firstloading){
       }



       $condition="";
       $condition_delivery="";
       if($bsearch) {
           //关键字条件
           if($search["_showsearch"]=="hide"  ){
               if($search["_keyword"]){
                   $condition_keyword = "";
                   $condition_keyword = join_condition($condition_keyword,"@delivery.delivery_no",$search["_keyword"],"char", "both" , 0, "" );
                   $condition_delivery = " AND ( ". $condition_keyword .")";
               }
           }else{
               //高级搜索condition
               $condition_delivery = join_condition($condition_delivery,"@delivery.status",$search["status"],"int");
               $condition_delivery = join_condition($condition_delivery,"@delivery.org_id",$search["org_id"],"int");
               $condition_delivery = join_condition($condition_delivery,"@delivery.customer_id",$search["customer_id"],"int");
               $condition_delivery = join_condition($condition_delivery,"@delivery.customer_name",$search["customer_name"],"char","both");
               $condition_delivery = join_condition2($condition_delivery,"@delivery.tx_date",$search["tx_date"],$search["tx_date2"],"date");
               $condition_delivery = join_condition($condition_delivery,"@delivery.delivery_no",$search["delivery_no"],"char");
               $condition_delivery = join_condition2($condition_delivery,"@delivery.delivery_date",$search["delivery_date"],$search["delivery_date2"],"date");
               $condition_delivery = join_condition($condition_delivery,"@delivery.warehouse_code",$search["warehouse_code"],"char");
               $condition_delivery = join_condition($condition_delivery,"@delivery.goods_no",$search["goods_no"],"char");
               $condition_delivery = join_condition($condition_delivery,"@delivery.goods_name",$search["goods_name"],"char","both");
               $condition_delivery = join_condition($condition_delivery,"@delivery.style_info",$search["style_info"],"char","both");
               $condition_delivery = join_condition($condition_delivery,"@delivery.materials",$search["materials"],"char");
               $condition_delivery = join_condition($condition_delivery,"@delivery.brand",$search["brand"],"char");
               $condition_delivery = join_condition($condition_delivery,"@delivery.producing_area",$search["producing_area"],"char");
               $condition_delivery = join_condition($condition_delivery,"@delivery.style_code",$search["style_code"],"char");
               $condition_delivery = join_condition($condition_delivery,"@delivery.batchno",$search["batchno"],"char");
               $condition_delivery = join_condition($condition_delivery,"@delivery.storecard_id",$search["storecard_id"],"int");
               $condition_delivery = join_condition($condition_delivery,"@delivery.storecard_no",$search["storecard_no"],"char");
               $condition_delivery = join_condition2($condition_delivery,"@delivery.weight",$search["weight"],$search["weight2"],"decimal");
               $condition_delivery = join_condition2($condition_delivery,"@delivery.qty",$search["qty"],$search["qty2"],"decimal");
               $condition_delivery = join_condition2($condition_delivery,"@delivery.bulkcargo",$search["bulkcargo"],$search["bulkcargo2"],"decimal");
               $condition_delivery = join_condition($condition_delivery,"@delivery.uom_qty",$search["uom_qty"],"char");
               $condition_delivery = join_condition($condition_delivery,"@delivery.uom_weight",$search["uom_weight"],"char");
               $condition_delivery = join_condition($condition_delivery,"@delivery.uom_bulkcargo",$search["uom_bulkcargo"],"char");
               $condition_delivery = join_condition($condition_delivery,"@delivery.buyer_id",$search["buyer_id"],"int");
               $condition_delivery = join_condition($condition_delivery,"@delivery.buyer_code",$search["buyer_code"],"char");
               $condition_delivery = join_condition($condition_delivery,"@delivery.buyer_name",$search["buyer_name"],"char","both");
               $condition_delivery = join_condition($condition_delivery,"@delivery.delivery_carno",$search["delivery_carno"],"char");
               $condition_delivery = join_condition($condition_delivery,"@delivery.delivery_contact",$search["delivery_contact"],"char");
               $condition_delivery = join_condition($condition_delivery,"@delivery.delivery_phone",$search["delivery_phone"],"char");
               $condition_delivery = join_condition($condition_delivery,"@delivery.delivery_idcard",$search["delivery_idcard"],"char");
               $condition_delivery = join_condition($condition_delivery,"@delivery.is_whole",$search["is_whole"],"int");
               $condition_delivery = join_condition2($condition_delivery,"@delivery.expired_time",$search["expired_time"],$search["expired_time2"],"datetime");
               $condition_delivery = join_condition($condition_delivery,"@delivery.is_expired",$search["is_expired"],"int");
               $condition_delivery = join_condition($condition_delivery,"@delivery.bills_confirm",$search["bills_confirm"],"int");
               $condition_delivery = join_condition($condition_delivery,"@delivery.payment_type",$search["payment_type"],"int");
               $condition_delivery = join_condition($condition_delivery,"@delivery.payment_customer_id",$search["payment_customer_id"],"int");
               $condition_delivery = join_condition($condition_delivery,"@delivery.payment_customer",$search["payment_customer"],"char","both");
               $condition_delivery = join_condition($condition_delivery,"@delivery.payment_path",$search["payment_path"],"char","both");
               $condition_delivery = join_condition($condition_delivery,"@delivery.vcode",$search["vcode"],"char");
               $condition_delivery = join_condition2($condition_delivery,"@delivery.transfer_fee",$search["transfer_fee"],$search["transfer_fee2"],"decimal");
               $condition_delivery = join_condition($condition_delivery,"@delivery.op",$search["op"],"char");
               $condition_delivery = join_condition2($condition_delivery,"@delivery.original_status",$search["original_status"],$search["original_status2"],"int");
               $condition_delivery = join_condition2($condition_delivery,"@delivery.stock_weight",$search["stock_weight"],$search["stock_weight2"],"decimal");
           }

           //增加 tab 条件
           $condition_delivery = $this->tabsheet_condition($condition_delivery ,$search["_tab"]);
           //增加数据权限
       $auth_condition=$this->get_auth_condition();
       $condition_delivery = join_condition_auth($condition_delivery,$auth_condition,"");
           //select fields
           $selectfields=" @delivery.status ";
           $selectfields.=", @delivery.id ";
           $selectfields.=", @delivery.org_id ";
           $selectfields.=", @delivery.customer_name ";
           $selectfields.=", @delivery.tx_date ";
           $selectfields.=", @delivery.delivery_no ";
           $selectfields.=", @delivery.delivery_date ";
           $selectfields.=", @delivery.warehouse_code ";
           $selectfields.=", @delivery.goods_no ";
           $selectfields.=", @delivery.goods_name ";
           $selectfields.=", @delivery.style_info ";
           $selectfields.=", @delivery.materials ";
           $selectfields.=", @delivery.brand ";
           $selectfields.=", @delivery.producing_area ";
           $selectfields.=", @delivery.style_code ";
           $selectfields.=", @delivery.batchno ";
           $selectfields.=", @delivery.storecard_id ";
           $selectfields.=", @delivery.storecard_no ";
           $selectfields.=", @delivery.weight ";
           $selectfields.=", @delivery.qty ";
           $selectfields.=", @delivery.bulkcargo ";
           $selectfields.=", @delivery.uom_qty ";
           $selectfields.=", @delivery.uom_weight ";
           $selectfields.=", @delivery.uom_bulkcargo ";
           $selectfields.=", @delivery.buyer_id ";
           $selectfields.=", @delivery.buyer_code ";
           $selectfields.=", @delivery.buyer_name ";
           $selectfields.=", @delivery.delivery_carno ";
           $selectfields.=", @delivery.delivery_contact ";
           $selectfields.=", @delivery.delivery_phone ";
           $selectfields.=", @delivery.delivery_idcard ";
           $selectfields.=", @delivery.is_whole ";
           $selectfields.=", @delivery.expired_time ";
           $selectfields.=", @delivery.is_expired ";
           $selectfields.=", @delivery.bills_confirm ";
           $selectfields.=", @delivery.payment_type ";
           $selectfields.=", @delivery.payment_customer_id ";
           $selectfields.=", @delivery.payment_customer ";
           $selectfields.=", @delivery.payment_path ";
           $selectfields.=", @delivery.vcode ";
           $selectfields.=", @delivery.transfer_fee ";
           $selectfields.=", @delivery.op ";
           $selectfields.=", @delivery.original_status ";
           $selectfields.=", @delivery.stock_weight ";


           $page_size = I("request.pagesize/d");
           if ($page_size<=0){
               $page_size = session("DeliverySummary-PageSize");
               if (!$page_size) {
                    $page_size = 10;
               }
           }
           session("DeliverySummary-PageSize", $page_size);


           $join="";
           $count_sql = "select count(*) as cnt from @delivery  #join#  where 1=1 #condition#";  // ' for skip replace $condition
           $count_sql = str_replace("#join#",$join,$count_sql);
           $count_sql = str_replace("#condition#",$condition_delivery,$count_sql);
           $count_sql = table($count_sql);
           $count_sql = str_replace("·mailchar·","@",$count_sql);
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

           $orderby = $this->get_orderby("",$search["_tab"]);
           $sql = "select #selectfields# from @delivery  #join# Where 1=1 #condition# #orderby#";
           $sql = str_replace("#selectfields#",$selectfields,$sql);
           $sql = str_replace("#join#",$join,$sql);
           $sql = str_replace("#condition#",$condition_delivery,$sql);
           $sql = str_replace("#orderby#",$orderby,$sql);
           $sql .= " LIMIT ". (($data["p"] - 1) * $page_size). ", $page_size";
           $sql = table($sql);
           $sql = str_replace("·mailchar·","@",$sql);
           $data["list"] = M()->query($sql);


           $pageClass = new \Think\Page($count,$page_size);
           $pageClass->rollPage = 8;
           $data["page"] = $pageClass->show_summary($data["funcid"],"");
           $data["page_size"] = $page_size;

        }
        else
        {
           $data["list"] =array();
           $data["page"] ="";
        }

        $data["search"] = $search;
        $data["tab"] = $search["_tab"];

        foreach($data as $key=>$val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("DeliverySummary:index");
        echo $html;
    }



    private function csvdata($data){
      return '"'.str_replace('"','\"',$data).'"';
    }

    private function export(){
        set_time_limit(0);
        ini_set('memory_limit', '640M');

        $search_auth_codes = "";
        $data["funcid"] = I("request.funcid");
        $p = I("request.p/d");
        $export_all = I("request.export_all/d");
        $search["_showsearch"] = I("request._showsearch");

        if(empty($data["funcid"])) $data["funcid"] = "DeliverySummary";
        if(!$p){
           $p = 1;
           $export_all = 1;
        }

        $show_list = array();

        $data['summary']='DeliverySummary';
        $usc = M('user_summary_column')->field("column")->where("user_code='%s' AND summary='%s' AND `show`='1'",array(session(C("USER_AUTH_KEY")),$data['summary']))->select();
        if($usc){
           foreach ($usc as $v) {
              $show_list[$v['column']]=1;
           }
        }

        $search["_tab"] = $this->tabsheet_check(I("request._tab"));
        $tab = $search["_tab"];

        $search["status"] = I("request.status");
        $search["org_id"] = I("request.org_id");
        $search["customer_id_name"] = I("request.customer_id_name");
        $search["customer_id"] = I("request.customer_id");
        $search["customer_name"] = I("request.customer_name");
        $search["tx_date"] = I("request.tx_date");
        $search["tx_date2"] = I("request.tx_date2");
        $search["delivery_no"] = I("request.delivery_no");
        $search["delivery_date"] = I("request.delivery_date");
        $search["delivery_date2"] = I("request.delivery_date2");
        $search["warehouse_code_name"] = I("request.warehouse_code_name");
        $search["warehouse_code"] = I("request.warehouse_code");
        $search["goods_no"] = I("request.goods_no");
        $search["goods_name"] = I("request.goods_name");
        $search["style_info"] = I("request.style_info");
        $search["materials"] = I("request.materials");
        $search["brand"] = I("request.brand");
        $search["producing_area"] = I("request.producing_area");
        $search["style_code"] = I("request.style_code");
        $search["batchno"] = I("request.batchno");
        $search["storecard_id"] = I("request.storecard_id");
        $search["storecard_no"] = I("request.storecard_no");
        $search["weight"] = I("request.weight");
        $search["weight2"] = I("request.weight2");
        $search["qty"] = I("request.qty");
        $search["qty2"] = I("request.qty2");
        $search["bulkcargo"] = I("request.bulkcargo");
        $search["bulkcargo2"] = I("request.bulkcargo2");
        $search["uom_qty"] = I("request.uom_qty");
        $search["uom_weight"] = I("request.uom_weight");
        $search["uom_bulkcargo"] = I("request.uom_bulkcargo");
        $search["buyer_id"] = I("request.buyer_id");
        $search["buyer_code"] = I("request.buyer_code");
        $search["buyer_name"] = I("request.buyer_name");
        $search["delivery_carno"] = I("request.delivery_carno");
        $search["delivery_contact"] = I("request.delivery_contact");
        $search["delivery_phone"] = I("request.delivery_phone");
        $search["delivery_idcard"] = I("request.delivery_idcard");
        $search["is_whole"] = I("request.is_whole");
        $search["expired_time"] = I("request.expired_time");
        $search["expired_time2"] = I("request.expired_time2");
        $search["is_expired"] = I("request.is_expired");
        $search["bills_confirm"] = I("request.bills_confirm");
        $search["payment_type"] = I("request.payment_type");
        $search["payment_customer_id"] = I("request.payment_customer_id");
        $search["payment_customer"] = I("request.payment_customer");
        $search["payment_path"] = I("request.payment_path");
        $search["vcode"] = I("request.vcode");
        $search["transfer_fee"] = I("request.transfer_fee");
        $search["transfer_fee2"] = I("request.transfer_fee2");
        $search["op"] = I("request.op");
        $search["original_status"] = I("request.original_status");
        $search["original_status2"] = I("request.original_status2");
        $search["stock_weight"] = I("request.stock_weight");
        $search["stock_weight2"] = I("request.stock_weight2");


        //condition
        $condition="";
        $condition_delivery="";

        //读取关键字搜索内容
        $search["_keyword"] = I("request._keyword");
        if($search["_showsearch"]=="hide"  ){
            if($search["_keyword"]){
                $condition_keyword = "";
                $condition_keyword = join_condition($condition_keyword,"@delivery.delivery_no",$search["_keyword"],"char", "both" , 0, "" );
                $condition_delivery = " AND ( ". $condition_keyword . ")";
            }
        }else{
        //高级搜索condition
           $condition_delivery = join_condition($condition_delivery,"@delivery.status",$search["status"],"int");

           $search_auth_codes = $search["org_id"];
           $condition_delivery = join_condition($condition_delivery,"@delivery.customer_id",$search["customer_id"],"int");
           $condition_delivery = join_condition($condition_delivery,"@delivery.customer_name",$search["customer_name"],"char","both");
           $condition_delivery = join_condition2($condition_delivery,"@delivery.tx_date",$search["tx_date"],$search["tx_date2"],"date");
           $condition_delivery = join_condition($condition_delivery,"@delivery.delivery_no",$search["delivery_no"],"char");
           $condition_delivery = join_condition2($condition_delivery,"@delivery.delivery_date",$search["delivery_date"],$search["delivery_date2"],"date");
           $condition_delivery = join_condition($condition_delivery,"@delivery.warehouse_code",$search["warehouse_code"],"char");
           $condition_delivery = join_condition($condition_delivery,"@delivery.goods_no",$search["goods_no"],"char");
           $condition_delivery = join_condition($condition_delivery,"@delivery.goods_name",$search["goods_name"],"char","both");
           $condition_delivery = join_condition($condition_delivery,"@delivery.style_info",$search["style_info"],"char","both");
           $condition_delivery = join_condition($condition_delivery,"@delivery.materials",$search["materials"],"char");
           $condition_delivery = join_condition($condition_delivery,"@delivery.brand",$search["brand"],"char");
           $condition_delivery = join_condition($condition_delivery,"@delivery.producing_area",$search["producing_area"],"char");
           $condition_delivery = join_condition($condition_delivery,"@delivery.style_code",$search["style_code"],"char");
           $condition_delivery = join_condition($condition_delivery,"@delivery.batchno",$search["batchno"],"char");
           $condition_delivery = join_condition($condition_delivery,"@delivery.storecard_id",$search["storecard_id"],"int");
           $condition_delivery = join_condition($condition_delivery,"@delivery.storecard_no",$search["storecard_no"],"char");
           $condition_delivery = join_condition2($condition_delivery,"@delivery.weight",$search["weight"],$search["weight2"],"decimal");
           $condition_delivery = join_condition2($condition_delivery,"@delivery.qty",$search["qty"],$search["qty2"],"decimal");
           $condition_delivery = join_condition2($condition_delivery,"@delivery.bulkcargo",$search["bulkcargo"],$search["bulkcargo2"],"decimal");
           $condition_delivery = join_condition($condition_delivery,"@delivery.uom_qty",$search["uom_qty"],"char");
           $condition_delivery = join_condition($condition_delivery,"@delivery.uom_weight",$search["uom_weight"],"char");
           $condition_delivery = join_condition($condition_delivery,"@delivery.uom_bulkcargo",$search["uom_bulkcargo"],"char");
           $condition_delivery = join_condition($condition_delivery,"@delivery.buyer_id",$search["buyer_id"],"int");
           $condition_delivery = join_condition($condition_delivery,"@delivery.buyer_code",$search["buyer_code"],"char");
           $condition_delivery = join_condition($condition_delivery,"@delivery.buyer_name",$search["buyer_name"],"char","both");
           $condition_delivery = join_condition($condition_delivery,"@delivery.delivery_carno",$search["delivery_carno"],"char");
           $condition_delivery = join_condition($condition_delivery,"@delivery.delivery_contact",$search["delivery_contact"],"char");
           $condition_delivery = join_condition($condition_delivery,"@delivery.delivery_phone",$search["delivery_phone"],"char");
           $condition_delivery = join_condition($condition_delivery,"@delivery.delivery_idcard",$search["delivery_idcard"],"char");
           $condition_delivery = join_condition($condition_delivery,"@delivery.is_whole",$search["is_whole"],"int");
           $condition_delivery = join_condition2($condition_delivery,"@delivery.expired_time",$search["expired_time"],$search["expired_time2"],"datetime");
           $condition_delivery = join_condition($condition_delivery,"@delivery.is_expired",$search["is_expired"],"int");
           $condition_delivery = join_condition($condition_delivery,"@delivery.bills_confirm",$search["bills_confirm"],"int");
           $condition_delivery = join_condition($condition_delivery,"@delivery.payment_type",$search["payment_type"],"int");
           $condition_delivery = join_condition($condition_delivery,"@delivery.payment_customer_id",$search["payment_customer_id"],"int");
           $condition_delivery = join_condition($condition_delivery,"@delivery.payment_customer",$search["payment_customer"],"char","both");
           $condition_delivery = join_condition($condition_delivery,"@delivery.payment_path",$search["payment_path"],"char","both");
           $condition_delivery = join_condition($condition_delivery,"@delivery.vcode",$search["vcode"],"char");
           $condition_delivery = join_condition2($condition_delivery,"@delivery.transfer_fee",$search["transfer_fee"],$search["transfer_fee2"],"decimal");
           $condition_delivery = join_condition($condition_delivery,"@delivery.op",$search["op"],"char");
           $condition_delivery = join_condition2($condition_delivery,"@delivery.original_status",$search["original_status"],$search["original_status2"],"int");
           $condition_delivery = join_condition2($condition_delivery,"@delivery.stock_weight",$search["stock_weight"],$search["stock_weight2"],"decimal");
        }
        $condition_delivery = $this->tabsheet_condition($condition_delivery ,$search["_tab"]);
          $condition_delivery = join_condition_shop($condition_delivery,"2;@delivery.org_id;org_id#3;@delivery.customer_id;customer_id",$this->user_shop_id,$search_auth_codes);

        //select fields
        $selectfields="@delivery.status ";
        $selectfields.=",@delivery.id ";
        $selectfields.=",@delivery.org_id ";
        $selectfields.=",@delivery.customer_name ";
        $selectfields.=",@delivery.tx_date ";
        $selectfields.=",@delivery.delivery_no ";
        $selectfields.=",@delivery.delivery_date ";
        $selectfields.=",@delivery.warehouse_code ";
        $selectfields.=",@delivery.goods_no ";
        $selectfields.=",@delivery.goods_name ";
        $selectfields.=",@delivery.style_info ";
        $selectfields.=",@delivery.materials ";
        $selectfields.=",@delivery.brand ";
        $selectfields.=",@delivery.producing_area ";
        $selectfields.=",@delivery.style_code ";
        $selectfields.=",@delivery.batchno ";
        $selectfields.=",@delivery.storecard_id ";
        $selectfields.=",@delivery.storecard_no ";
        $selectfields.=",@delivery.weight ";
        $selectfields.=",@delivery.qty ";
        $selectfields.=",@delivery.bulkcargo ";
        $selectfields.=",@delivery.uom_qty ";
        $selectfields.=",@delivery.uom_weight ";
        $selectfields.=",@delivery.uom_bulkcargo ";
        $selectfields.=",@delivery.buyer_id ";
        $selectfields.=",@delivery.buyer_code ";
        $selectfields.=",@delivery.buyer_name ";
        $selectfields.=",@delivery.delivery_carno ";
        $selectfields.=",@delivery.delivery_contact ";
        $selectfields.=",@delivery.delivery_phone ";
        $selectfields.=",@delivery.delivery_idcard ";
        $selectfields.=",@delivery.is_whole ";
        $selectfields.=",@delivery.expired_time ";
        $selectfields.=",@delivery.is_expired ";
        $selectfields.=",@delivery.bills_confirm ";
        $selectfields.=",@delivery.payment_type ";
        $selectfields.=",@delivery.payment_customer_id ";
        $selectfields.=",@delivery.payment_customer ";
        $selectfields.=",@delivery.payment_path ";
        $selectfields.=",@delivery.vcode ";
        $selectfields.=",@delivery.transfer_fee ";
        $selectfields.=",@delivery.op ";
        $selectfields.=",@delivery.original_status ";
        $selectfields.=",@delivery.stock_weight ";


        $str_header = "";
        if ($show_list['status']==1 || empty($show_list)){
            $str_header .= "状态,";
        }
        if ($show_list['org_id']==1 || empty($show_list)){
            $str_header .= "库联,";
        }
        if ($show_list['customer_name']==1 || empty($show_list)){
            $str_header .= "客户名称,";
        }
        if ($show_list['tx_date']==1 || empty($show_list)){
            $str_header .= "开单日期,";
        }
        if ($show_list['delivery_no']==1 || empty($show_list)){
            $str_header .= "提货单号,";
        }
        if ($show_list['delivery_date']==1 || empty($show_list)){
            $str_header .= "提单日期,";
        }
        if ($show_list['warehouse_code']==1 || empty($show_list)){
            $str_header .= "仓库编码,";
        }
        if ($show_list['goods_no']==1 || empty($show_list)){
            $str_header .= "货品编码,";
        }
        if ($show_list['goods_name']==1 || empty($show_list)){
            $str_header .= "货品名称,";
        }
        if ($show_list['style_info']==1 || empty($show_list)){
            $str_header .= "规格,";
        }
        if ($show_list['materials']==1 || empty($show_list)){
            $str_header .= "材质,";
        }
        if ($show_list['brand']==1 || empty($show_list)){
            $str_header .= "商标,";
        }
        if ($show_list['producing_area']==1 || empty($show_list)){
            $str_header .= "产地,";
        }
        if ($show_list['style_code']==1 || empty($show_list)){
            $str_header .= "货品基础码,";
        }
        if ($show_list['batchno']==1 || empty($show_list)){
            $str_header .= "货品批号,";
        }
        if ($show_list['storecard_id']==1 || empty($show_list)){
            $str_header .= "存储卡,";
        }
        if ($show_list['storecard_no']==1 || empty($show_list)){
            $str_header .= "存储卡号,";
        }
        if ($show_list['weight']==1 || empty($show_list)){
            $str_header .= "重量,";
        }
        if ($show_list['qty']==1 || empty($show_list)){
            $str_header .= "数量,";
        }
        if ($show_list['bulkcargo']==1 || empty($show_list)){
            $str_header .= "散件,";
        }
        if ($show_list['uom_qty']==1 || empty($show_list)){
            $str_header .= "数量单位,";
        }
        if ($show_list['uom_weight']==1 || empty($show_list)){
            $str_header .= "重量单位,";
        }
        if ($show_list['uom_bulkcargo']==1 || empty($show_list)){
            $str_header .= "散件单位,";
        }
        if ($show_list['buyer_id']==1 || empty($show_list)){
            $str_header .= "买家,";
        }
        if ($show_list['buyer_code']==1 || empty($show_list)){
            $str_header .= "买家编码,";
        }
        if ($show_list['buyer_name']==1 || empty($show_list)){
            $str_header .= "买家名称,";
        }
        if ($show_list['delivery_carno']==1 || empty($show_list)){
            $str_header .= "提货车号,";
        }
        if ($show_list['delivery_contact']==1 || empty($show_list)){
            $str_header .= "提货人员,";
        }
        if ($show_list['delivery_phone']==1 || empty($show_list)){
            $str_header .= "提货电话,";
        }
        if ($show_list['delivery_idcard']==1 || empty($show_list)){
            $str_header .= "提货身份证,";
        }
        if ($show_list['is_whole']==1 || empty($show_list)){
            $str_header .= "整卡,";
        }
        if ($show_list['expired_time']==1 || empty($show_list)){
            $str_header .= "截至时间,";
        }
        if ($show_list['is_expired']==1 || empty($show_list)){
            $str_header .= "过期,";
        }
        if ($show_list['bills_confirm']==1 || empty($show_list)){
            $str_header .= "款项确认,";
        }
        if ($show_list['payment_type']==1 || empty($show_list)){
            $str_header .= "付款类型,";
        }
        if ($show_list['payment_customer_id']==1 || empty($show_list)){
            $str_header .= "付款客户,";
        }
        if ($show_list['payment_customer']==1 || empty($show_list)){
            $str_header .= "付款客户,";
        }
        if ($show_list['payment_path']==1 || empty($show_list)){
            $str_header .= "付款图像,";
        }
        if ($show_list['vcode']==1 || empty($show_list)){
            $str_header .= "VCODE,";
        }
        if ($show_list['transfer_fee']==1 || empty($show_list)){
            $str_header .= "过户费(元),";
        }
        if ($show_list['op']==1 || empty($show_list)){
            $str_header .= "OP,";
        }
        if ($show_list['original_status']==1 || empty($show_list)){
            $str_header .= "原始状态,";
        }
        if ($show_list['stock_weight']==1 || empty($show_list)){
            $str_header .= "实发重量,";
        }
        $str_header .= "\r\n";

        $join="";

       $count_sql = "select count(*) as cnt from @delivery  #join#  where 1=1 #condition#";  // ' for skip replace $condition
       $count_sql = str_replace("#join#",$join,$count_sql);
       $count_sql = str_replace("#condition#",$condition_delivery,$count_sql);

       $count_sql = table($count_sql);
       $count_sql = str_replace("·mailchar·","@",$count_sql);
       $count = M()->query($count_sql);
       $count = $count[0]["cnt"];

           $total_page=0;

        if(!$export_all) {
           $page_size = I("request.pagesize/d");
           $page_size = $page_size <= 0 ? session("DeliverySummary-PageSize") : $page_size;
           if(!$page_size) {
              $page_size = 20;
           }


           if($count < $page_size)
              $tmp = 1;
           else{
              $tmp = intval($count / $page_size);
              if($count % $page_size != 0) {
                 $tmp++;
              }
           }

           if($p > $tmp) {
               $p = $tmp;
           }
           $total_page=$p;
        } else {
          $p = 1;
          $page_size = 2000;
          $total_page=ceil($count/$page_size);
        }


        $str_content = "";

        $orderby="";

    for ($p;$p<=$total_page;$p++)
    {

        $sql = "select #selectfields# from @delivery  #join# Where 1=1 #condition# #orderby#";   // ' for skip replace $selectfields,$condition,$orderby
        $sql = str_replace("#selectfields#",$selectfields,$sql);
        $sql = str_replace("#join#",$join,$sql);
        $sql = str_replace("#condition#",$condition_delivery,$sql);
        $sql = str_replace("#orderby#",$orderby,$sql);
        $sql .= " LIMIT ". (($p - 1) * $page_size). ", ".$page_size;

        $sql = table($sql);
        $sql = str_replace("·mailchar·","@",$sql);
        $list = M()->query($sql);

        foreach($list as $master) {
            $str_line="";
            if ($show_list['status']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Delivery_status("$master[status]","name"))."\t,";
            }
            if ($show_list['org_id']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Org_byID("$master[org_id]","name"))."\t,";
            }
            if ($show_list['customer_name']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["customer_name"])."\t,";
            }
            if ($show_list['tx_date']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("D", $master["tx_date"]))."\t,";
            }
            if ($show_list['delivery_no']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["delivery_no"])."\t,";
            }
            if ($show_list['delivery_date']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("D", $master["delivery_date"]))."\t,";
            }
            if ($show_list['warehouse_code']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Warehouse("$master[warehouse_code]","name"))."\t,";
            }
            if ($show_list['goods_no']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["goods_no"])."\t,";
            }
            if ($show_list['goods_name']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["goods_name"])."\t,";
            }
            if ($show_list['style_info']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["style_info"])."\t,";
            }
            if ($show_list['materials']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["materials"])."\t,";
            }
            if ($show_list['brand']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["brand"])."\t,";
            }
            if ($show_list['producing_area']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["producing_area"])."\t,";
            }
            if ($show_list['style_code']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["style_code"])."\t,";
            }
            if ($show_list['batchno']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["batchno"])."\t,";
            }
            if ($show_list['storecard_id']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["storecard_id"])."\t,";
            }
            if ($show_list['storecard_no']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["storecard_no"])."\t,";
            }
            if ($show_list['weight']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("F33", $master["weight"]))."\t,";
            }
            if ($show_list['qty']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("N3", $master["qty"]))."\t,";
            }
            if ($show_list['bulkcargo']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("N3", $master["bulkcargo"]))."\t,";
            }
            if ($show_list['uom_qty']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["uom_qty"])."\t,";
            }
            if ($show_list['uom_weight']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["uom_weight"])."\t,";
            }
            if ($show_list['uom_bulkcargo']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["uom_bulkcargo"])."\t,";
            }
            if ($show_list['buyer_id']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["buyer_id"])."\t,";
            }
            if ($show_list['buyer_code']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["buyer_code"])."\t,";
            }
            if ($show_list['buyer_name']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["buyer_name"])."\t,";
            }
            if ($show_list['delivery_carno']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["delivery_carno"])."\t,";
            }
            if ($show_list['delivery_contact']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["delivery_contact"])."\t,";
            }
            if ($show_list['delivery_phone']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["delivery_phone"])."\t,";
            }
            if ($show_list['delivery_idcard']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["delivery_idcard"])."\t,";
            }
            if ($show_list['is_whole']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Delivery_is_whole("$master[is_whole]","name"))."\t,";
            }
            if ($show_list['expired_time']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("DT", $master["expired_time"]))."\t,";
            }
            if ($show_list['is_expired']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Delivery_is_expired("$master[is_expired]","name"))."\t,";
            }
            if ($show_list['bills_confirm']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Delivery_bills_confirm("$master[bills_confirm]","name"))."\t,";
            }
            if ($show_list['payment_type']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Delivery_payment_type("$master[payment_type]","name"))."\t,";
            }
            if ($show_list['payment_customer_id']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["payment_customer_id"])."\t,";
            }
            if ($show_list['payment_customer']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["payment_customer"])."\t,";
            }
            if ($show_list['payment_path']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["payment_path"])."\t,";
            }
            if ($show_list['vcode']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["vcode"])."\t,";
            }
            if ($show_list['transfer_fee']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("F32", $master["transfer_fee"]))."\t,";
            }
            if ($show_list['op']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["op"])."\t,";
            }
            if ($show_list['original_status']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("N3", $master["original_status"]))."\t,";
            }
            if ($show_list['stock_weight']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("F33", $master["stock_weight"]))."\t,";
            }
            $str_content .= $str_line . "\r\n";
        }
    }
        header('Content-Type: text/xls');
        header ("Content-type:application/vnd.ms-excel;charset=gbk" );
        $str = mb_convert_encoding("DeliverySummary", 'gbk', 'utf-8');
        $str_content = mb_convert_encoding($str_content, 'gbk', 'utf-8');
        $str_header = mb_convert_encoding($str_header, 'gbk', 'utf-8');
        header('Content-Disposition: attachment;filename="' .$str . '.csv"');
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');
        die($str_header.$str_content);
    }



    private function tabsheet_check($itab)
    {
        switch($itab)
        {
          case 'all':
          case 'caogao':
          case 'youxiao':
          case 'jieshu':
          case 'quxiao':
          case 'shixiao':
              break;
          default:
              $itab='all';
              break;
              $itab='caogao';
              break;
              $itab='youxiao';
              break;
              $itab='jieshu';
              break;
              $itab='quxiao';
              break;
              $itab='shixiao';
              break;
         }
        return $itab;
    }

    private function tabsheet_condition($scondition, $itab)
    {
        $scond="";
        switch($itab)
        {
            case 'all':  //全部
                 $scond="";
                 break;
            case 'caogao':  //草稿
                 $scond="@delivery.status='0'";
                 break;
            case 'youxiao':  //有效
                 $scond="@delivery.status='1'";
                 break;
            case 'jieshu':  //结束
                 $scond="@delivery.status='2'";
                 break;
            case 'quxiao':  //取消
                 $scond="@delivery.status='7'";
                 break;
            case 'shixiao':  //失效
                 $scond="@delivery.status='8'";
                 break;
            default :
                 $scond="";
                 break;
        }
        if ($scond)
        {
            $scondition .= " AND (".$scond.")";
        }
        return $scondition;
    }

    private function get_orderby($orderby, $itab)
    {
        switch($itab)
        {
            case 'all':  //全部
                 break;
            case 'caogao':  //草稿
                 break;
            case 'youxiao':  //有效
                 break;
            case 'jieshu':  //结束
                 break;
            case 'quxiao':  //取消
                 break;
            case 'shixiao':  //失效
                 break;
        }
        if($orderby)
            return " order by $orderby";
        else
            return "";
    }



    private function get_auth_condition(){
        $condition="";
        switch($this->user["side"]){
        case "2":
            $condition.=" @delivery.org_id='".$this->user["org_id"]."' ";
            break;
        case "3":
            $condition.=" @delivery.customer_id='".$this->user["customer_id"]."' ";
            break;
        }
        return $condition ;
    }
}
