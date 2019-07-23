<?php namespace Summary\Controller;
//
//注释: FeeDetailSummary - 账单明细列表
//
use Home\Controller\BasicController;
use Think\Log;
class FeeDetailSummaryController extends BasicController {

    public function _init() {
        $funcs = $this->getUserRoleList($this->user,array( 'FeeDetailSummary', '/Home/%table%', ));
        if ($funcs)
            $this->assign("rights",  $funcs);
        else{
            $funcs = array(
                         array("key"=>"refresh","func"=>"FeeDetailSummary","Action"=>"refresh") ,
                         array("key"=>"search","func"=>"FeeDetailSummary","Action"=>"search") ,
                         array("key"=>"export","func"=>"FeeDetailSummary","Action"=>"export") ,
                         array("key"=>"status","func"=>"/Home/%table%","Action"=>"%action%")
             );
            $this->assign("rights",  $this->GetUserRights($this->user["id"],$funcs ));
        }
        $this->assign("colshow", $this->GetUserColumnDefine($this->user["id"],"FeeDetailSummary"));
    }

    public function index() {
         try {
        $data["pfuncid"] = I("request.pfuncid");
        $data["funcid"] = I("request.funcid");
        $data["zindex"] = I("request.zindex/d");
        if(empty($data["funcid"])) $data["funcid"] = "FeeDetailSummary";
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
          //$this->ajaxResult("账单明细列表后台错误");
          $this->ajaxResult($e->getMessage());
      }
    }


    private function columnsetting_define(){
        return array(
            'fee_no'=>'费用账单',
            'org_id'=>'库联',
            'customer_name'=>'客户名称',
            'tx_month'=>'费用月份',
            'warehouse_code'=>'仓库编码',
            'tx_date'=>'费用日期',
            'fee_type'=>'费用类型',
            'subject'=>'费用摘要',
            'storecard_id'=>'存储卡',
            'storecard_no'=>'存储卡号',
            'order_no'=>'交易单据',
            'goods_no'=>'货品编码',
            'goods_name'=>'货品名称',
            'weight'=>'重量',
            'price'=>'价格(元)',
            'amount'=>'金额(元)',
        );
    }

    private function columnsetting($data){
        $data['user_code']=session(C("USER_AUTH_KEY"));
        $data['summary']='FeeDetailSummary';
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

        $this->ajaxResult("", "",  array("_asr.closeTab","_asr.closePopup", "_asr.openLink","_asr.hideMask()"), array("$('#".$data["funcid"]."-Tab').find('a'), '".$data["funcid"]."'","'".$data["funcid"]."'", "'". U("/Summary/FeeDetailSummary/index?func=search&").  "','".filterFuncId("FeeDetailSummary_Search","id=0")."','账单明细列表', 1",""));


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
       $search["fee_no"] = I("request.fee_no");
       $search["org_id"] = I("request.org_id");
       $search["customer_id_name"] = I("request.customer_id_name");
       $search["customer_id"] = I("request.customer_id");
       $search["customer_name"] = I("request.customer_name");
       $search["tx_month"] = I("request.tx_month");
       $search["warehouse_code_name"] = I("request.warehouse_code_name");
       $search["warehouse_code"] = I("request.warehouse_code");
       $search["tx_date"] = I("request.tx_date");
       $search["tx_date2"] = I("request.tx_date2");
       $search["fee_type"] = I("request.fee_type");
       $search["subject"] = I("request.subject");
       $search["storecard_id"] = I("request.storecard_id");
       $search["storecard_no"] = I("request.storecard_no");
       $search["order_no"] = I("request.order_no");
       $search["goods_no"] = I("request.goods_no");
       $search["goods_name"] = I("request.goods_name");
       $search["weight"] = I("request.weight");
       $search["weight2"] = I("request.weight2");
       $search["price"] = I("request.price");
       $search["price2"] = I("request.price2");
       $search["amount"] = I("request.amount");
       $search["amount2"] = I("request.amount2");

       //判断首次装载是否要赋予缺省值
       if($firstloading){
       }



       $condition="";
       $condition_fee_detail="";
       if($bsearch) {
           //关键字条件
           if($search["_showsearch"]=="hide"  ){
               if($search["_keyword"]){
                   $condition_keyword = "";
                   $condition_keyword = join_condition($condition_keyword,"@fee_detail.fee_no",$search["_keyword"],"char", "both" , 0, "" );
                   $condition_fee_detail = " AND ( ". $condition_keyword .")";
               }
           }else{
               //高级搜索condition
               $condition_fee_detail = join_condition($condition_fee_detail,"@fee_detail.fee_no",$search["fee_no"],"char","both");
               $condition_fee_detail = join_condition($condition_fee_detail,"@fee_detail.org_id",$search["org_id"],"int");
               $condition_fee_detail = join_condition($condition_fee_detail,"@fee_detail.customer_id",$search["customer_id"],"int");
               $condition_fee_detail = join_condition($condition_fee_detail,"@fee_detail.customer_name",$search["customer_name"],"char","both");
               $condition_fee_detail = join_condition($condition_fee_detail,"@fee_detail.tx_month",$search["tx_month"],"char");
               $condition_fee_detail = join_condition($condition_fee_detail,"@fee_detail.warehouse_code",$search["warehouse_code"],"char");
               $condition_fee_detail = join_condition2($condition_fee_detail,"@fee_detail.tx_date",$search["tx_date"],$search["tx_date2"],"date");
               $condition_fee_detail = join_condition($condition_fee_detail,"@fee_detail.fee_type",$search["fee_type"],"char");
               $condition_fee_detail = join_condition($condition_fee_detail,"@fee_detail.subject",$search["subject"],"char","both");
               $condition_fee_detail = join_condition($condition_fee_detail,"@fee_detail.storecard_id",$search["storecard_id"],"int");
               $condition_fee_detail = join_condition($condition_fee_detail,"@fee_detail.storecard_no",$search["storecard_no"],"char");
               $condition_fee_detail = join_condition($condition_fee_detail,"@fee_detail.order_no",$search["order_no"],"char");
               $condition_fee_detail = join_condition($condition_fee_detail,"@fee_detail.goods_no",$search["goods_no"],"char");
               $condition_fee_detail = join_condition($condition_fee_detail,"@fee_detail.goods_name",$search["goods_name"],"char","both");
               $condition_fee_detail = join_condition2($condition_fee_detail,"@fee_detail.weight",$search["weight"],$search["weight2"],"decimal");
               $condition_fee_detail = join_condition2($condition_fee_detail,"@fee_detail.price",$search["price"],$search["price2"],"decimal");
               $condition_fee_detail = join_condition2($condition_fee_detail,"@fee_detail.amount",$search["amount"],$search["amount2"],"decimal");
           }

           //增加 tab 条件
           $condition_fee_detail = $this->tabsheet_condition($condition_fee_detail ,$search["_tab"]);
           //增加数据权限
       $auth_condition=$this->get_auth_condition();
       $condition_fee_detail = join_condition_auth($condition_fee_detail,$auth_condition,"");
           //select fields
           $selectfields=" @fee_detail.id ";
           $selectfields.=", @fee_detail.fee_no ";
           $selectfields.=", @fee_detail.org_id ";
           $selectfields.=", @fee_detail.customer_name ";
           $selectfields.=", @fee_detail.tx_month ";
           $selectfields.=", @fee_detail.warehouse_code ";
           $selectfields.=", @fee_detail.tx_date ";
           $selectfields.=", @fee_detail.fee_type ";
           $selectfields.=", @fee_detail.subject ";
           $selectfields.=", @fee_detail.storecard_id ";
           $selectfields.=", @fee_detail.storecard_no ";
           $selectfields.=", @fee_detail.order_no ";
           $selectfields.=", @fee_detail.goods_no ";
           $selectfields.=", @fee_detail.goods_name ";
           $selectfields.=", @fee_detail.weight ";
           $selectfields.=", @fee_detail.price ";
           $selectfields.=", @fee_detail.amount ";


           $page_size = I("request.pagesize/d");
           if ($page_size<=0){
               $page_size = session("FeeDetailSummary-PageSize");
               if (!$page_size) {
                    $page_size = 10;
               }
           }
           session("FeeDetailSummary-PageSize", $page_size);


           $join="";
           $count_sql = "select count(*) as cnt from @fee_detail  #join#  where 1=1 #condition#";  // ' for skip replace $condition
           $count_sql = str_replace("#join#",$join,$count_sql);
           $count_sql = str_replace("#condition#",$condition_fee_detail,$count_sql);
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
           $sql = "select #selectfields# from @fee_detail  #join# Where 1=1 #condition# #orderby#";
           $sql = str_replace("#selectfields#",$selectfields,$sql);
           $sql = str_replace("#join#",$join,$sql);
           $sql = str_replace("#condition#",$condition_fee_detail,$sql);
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
        $html = $this->fetch("FeeDetailSummary:index");
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

        if(empty($data["funcid"])) $data["funcid"] = "FeeDetailSummary";
        if(!$p){
           $p = 1;
           $export_all = 1;
        }

        $show_list = array();

        $data['summary']='FeeDetailSummary';
        $usc = M('user_summary_column')->field("column")->where("user_code='%s' AND summary='%s' AND `show`='1'",array(session(C("USER_AUTH_KEY")),$data['summary']))->select();
        if($usc){
           foreach ($usc as $v) {
              $show_list[$v['column']]=1;
           }
        }

        $search["_tab"] = $this->tabsheet_check(I("request._tab"));
        $tab = $search["_tab"];

        $search["fee_no"] = I("request.fee_no");
        $search["org_id"] = I("request.org_id");
        $search["customer_id_name"] = I("request.customer_id_name");
        $search["customer_id"] = I("request.customer_id");
        $search["customer_name"] = I("request.customer_name");
        $search["tx_month"] = I("request.tx_month");
        $search["warehouse_code_name"] = I("request.warehouse_code_name");
        $search["warehouse_code"] = I("request.warehouse_code");
        $search["tx_date"] = I("request.tx_date");
        $search["tx_date2"] = I("request.tx_date2");
        $search["fee_type"] = I("request.fee_type");
        $search["subject"] = I("request.subject");
        $search["storecard_id"] = I("request.storecard_id");
        $search["storecard_no"] = I("request.storecard_no");
        $search["order_no"] = I("request.order_no");
        $search["goods_no"] = I("request.goods_no");
        $search["goods_name"] = I("request.goods_name");
        $search["weight"] = I("request.weight");
        $search["weight2"] = I("request.weight2");
        $search["price"] = I("request.price");
        $search["price2"] = I("request.price2");
        $search["amount"] = I("request.amount");
        $search["amount2"] = I("request.amount2");


        //condition
        $condition="";
        $condition_fee_detail="";

        //读取关键字搜索内容
        $search["_keyword"] = I("request._keyword");
        if($search["_showsearch"]=="hide"  ){
            if($search["_keyword"]){
                $condition_keyword = "";
                $condition_keyword = join_condition($condition_keyword,"@fee_detail.fee_no",$search["_keyword"],"char", "both" , 0, "" );
                $condition_fee_detail = " AND ( ". $condition_keyword . ")";
            }
        }else{
        //高级搜索condition
           $condition_fee_detail = join_condition($condition_fee_detail,"@fee_detail.fee_no",$search["fee_no"],"char","both");

           $search_auth_codes = $search["org_id"];
           $condition_fee_detail = join_condition($condition_fee_detail,"@fee_detail.customer_id",$search["customer_id"],"int");
           $condition_fee_detail = join_condition($condition_fee_detail,"@fee_detail.customer_name",$search["customer_name"],"char","both");
           $condition_fee_detail = join_condition($condition_fee_detail,"@fee_detail.tx_month",$search["tx_month"],"char");
           $condition_fee_detail = join_condition($condition_fee_detail,"@fee_detail.warehouse_code",$search["warehouse_code"],"char");
           $condition_fee_detail = join_condition2($condition_fee_detail,"@fee_detail.tx_date",$search["tx_date"],$search["tx_date2"],"date");
           $condition_fee_detail = join_condition($condition_fee_detail,"@fee_detail.fee_type",$search["fee_type"],"char");
           $condition_fee_detail = join_condition($condition_fee_detail,"@fee_detail.subject",$search["subject"],"char","both");
           $condition_fee_detail = join_condition($condition_fee_detail,"@fee_detail.storecard_id",$search["storecard_id"],"int");
           $condition_fee_detail = join_condition($condition_fee_detail,"@fee_detail.storecard_no",$search["storecard_no"],"char");
           $condition_fee_detail = join_condition($condition_fee_detail,"@fee_detail.order_no",$search["order_no"],"char");
           $condition_fee_detail = join_condition($condition_fee_detail,"@fee_detail.goods_no",$search["goods_no"],"char");
           $condition_fee_detail = join_condition($condition_fee_detail,"@fee_detail.goods_name",$search["goods_name"],"char","both");
           $condition_fee_detail = join_condition2($condition_fee_detail,"@fee_detail.weight",$search["weight"],$search["weight2"],"decimal");
           $condition_fee_detail = join_condition2($condition_fee_detail,"@fee_detail.price",$search["price"],$search["price2"],"decimal");
           $condition_fee_detail = join_condition2($condition_fee_detail,"@fee_detail.amount",$search["amount"],$search["amount2"],"decimal");
        }
        $condition_fee_detail = $this->tabsheet_condition($condition_fee_detail ,$search["_tab"]);
          $condition_fee_detail = join_condition_shop($condition_fee_detail,"2;@fee_detail.org_id;org_id#3;@fee_detail.customer_id;customer_id",$this->user_shop_id,$search_auth_codes);

        //select fields
        $selectfields="@fee_detail.id ";
        $selectfields.=",@fee_detail.fee_no ";
        $selectfields.=",@fee_detail.org_id ";
        $selectfields.=",@fee_detail.customer_name ";
        $selectfields.=",@fee_detail.tx_month ";
        $selectfields.=",@fee_detail.warehouse_code ";
        $selectfields.=",@fee_detail.tx_date ";
        $selectfields.=",@fee_detail.fee_type ";
        $selectfields.=",@fee_detail.subject ";
        $selectfields.=",@fee_detail.storecard_id ";
        $selectfields.=",@fee_detail.storecard_no ";
        $selectfields.=",@fee_detail.order_no ";
        $selectfields.=",@fee_detail.goods_no ";
        $selectfields.=",@fee_detail.goods_name ";
        $selectfields.=",@fee_detail.weight ";
        $selectfields.=",@fee_detail.price ";
        $selectfields.=",@fee_detail.amount ";


        $str_header = "";
        if ($show_list['fee_no']==1 || empty($show_list)){
            $str_header .= "费用账单,";
        }
        if ($show_list['org_id']==1 || empty($show_list)){
            $str_header .= "库联,";
        }
        if ($show_list['customer_name']==1 || empty($show_list)){
            $str_header .= "客户名称,";
        }
        if ($show_list['tx_month']==1 || empty($show_list)){
            $str_header .= "费用月份,";
        }
        if ($show_list['warehouse_code']==1 || empty($show_list)){
            $str_header .= "仓库编码,";
        }
        if ($show_list['tx_date']==1 || empty($show_list)){
            $str_header .= "费用日期,";
        }
        if ($show_list['fee_type']==1 || empty($show_list)){
            $str_header .= "费用类型,";
        }
        if ($show_list['subject']==1 || empty($show_list)){
            $str_header .= "费用摘要,";
        }
        if ($show_list['storecard_id']==1 || empty($show_list)){
            $str_header .= "存储卡,";
        }
        if ($show_list['storecard_no']==1 || empty($show_list)){
            $str_header .= "存储卡号,";
        }
        if ($show_list['order_no']==1 || empty($show_list)){
            $str_header .= "交易单据,";
        }
        if ($show_list['goods_no']==1 || empty($show_list)){
            $str_header .= "货品编码,";
        }
        if ($show_list['goods_name']==1 || empty($show_list)){
            $str_header .= "货品名称,";
        }
        if ($show_list['weight']==1 || empty($show_list)){
            $str_header .= "重量,";
        }
        if ($show_list['price']==1 || empty($show_list)){
            $str_header .= "价格(元),";
        }
        if ($show_list['amount']==1 || empty($show_list)){
            $str_header .= "金额(元),";
        }
        $str_header .= "\r\n";

        $join="";

       $count_sql = "select count(*) as cnt from @fee_detail  #join#  where 1=1 #condition#";  // ' for skip replace $condition
       $count_sql = str_replace("#join#",$join,$count_sql);
       $count_sql = str_replace("#condition#",$condition_fee_detail,$count_sql);

       $count_sql = table($count_sql);
       $count_sql = str_replace("·mailchar·","@",$count_sql);
       $count = M()->query($count_sql);
       $count = $count[0]["cnt"];

           $total_page=0;

        if(!$export_all) {
           $page_size = I("request.pagesize/d");
           $page_size = $page_size <= 0 ? session("FeeDetailSummary-PageSize") : $page_size;
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

        $sql = "select #selectfields# from @fee_detail  #join# Where 1=1 #condition# #orderby#";   // ' for skip replace $selectfields,$condition,$orderby
        $sql = str_replace("#selectfields#",$selectfields,$sql);
        $sql = str_replace("#join#",$join,$sql);
        $sql = str_replace("#condition#",$condition_fee_detail,$sql);
        $sql = str_replace("#orderby#",$orderby,$sql);
        $sql .= " LIMIT ". (($p - 1) * $page_size). ", ".$page_size;

        $sql = table($sql);
        $sql = str_replace("·mailchar·","@",$sql);
        $list = M()->query($sql);

        foreach($list as $master) {
            $str_line="";
            if ($show_list['fee_no']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["fee_no"])."\t,";
            }
            if ($show_list['org_id']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Org_byID("$master[org_id]","name"))."\t,";
            }
            if ($show_list['customer_name']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["customer_name"])."\t,";
            }
            if ($show_list['tx_month']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["tx_month"])."\t,";
            }
            if ($show_list['warehouse_code']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Warehouse("$master[warehouse_code]","name"))."\t,";
            }
            if ($show_list['tx_date']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("D", $master["tx_date"]))."\t,";
            }
            if ($show_list['fee_type']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["fee_type"])."\t,";
            }
            if ($show_list['subject']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["subject"])."\t,";
            }
            if ($show_list['storecard_id']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["storecard_id"])."\t,";
            }
            if ($show_list['storecard_no']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["storecard_no"])."\t,";
            }
            if ($show_list['order_no']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["order_no"])."\t,";
            }
            if ($show_list['goods_no']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["goods_no"])."\t,";
            }
            if ($show_list['goods_name']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["goods_name"])."\t,";
            }
            if ($show_list['weight']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("F33", $master["weight"]))."\t,";
            }
            if ($show_list['price']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("F33", $master["price"]))."\t,";
            }
            if ($show_list['amount']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("F32", $master["amount"]))."\t,";
            }
            $str_content .= $str_line . "\r\n";
        }
    }
        header('Content-Type: text/xls');
        header ("Content-type:application/vnd.ms-excel;charset=gbk" );
        $str = mb_convert_encoding("FeeDetailSummary", 'gbk', 'utf-8');
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
              break;
          default:
              $itab='all';
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
            $condition.=" @fee_detail.org_id='".$this->user["org_id"]."' ";
            break;
        case "3":
            $condition.=" @fee_detail.customer_id='".$this->user["customer_id"]."' ";
            break;
        }
        return $condition ;
    }
}
