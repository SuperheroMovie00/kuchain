<?php namespace Summary\Controller;
//
//注释: FeeSummary - 客户账单列表
//
use Home\Controller\BasicController;
use Think\Log;
class FeeSummaryController extends BasicController {

    public function _init() {
        $funcs = $this->getUserRoleList($this->user,array( 'FeeSummary', '/Home/Fee', ));
        if ($funcs)
            $this->assign("rights",  $funcs);
        else{
            $funcs = array(
                         array("key"=>"refresh","func"=>"FeeSummary","Action"=>"refresh") ,
                         array("key"=>"search","func"=>"FeeSummary","Action"=>"search") ,
                         array("key"=>"export","func"=>"FeeSummary","Action"=>"export") ,
                         array("key"=>"master_view","func"=>"/Home/Fee","Action"=>"view") ,
                         array("key"=>"detail","func"=>"FeeSummary","Action"=>"detail")
             );
            $this->assign("rights",  $this->GetUserRights($this->user["id"],$funcs ));
        }
        $this->assign("colshow", $this->GetUserColumnDefine($this->user["id"],"FeeSummary"));
    }

    public function index() {
         try {
        $data["pfuncid"] = I("request.pfuncid");
        $data["funcid"] = I("request.funcid");
        $data["zindex"] = I("request.zindex/d");
        if(empty($data["funcid"])) $data["funcid"] = "FeeSummary";
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
          case "detail":
               $this->detail($data);
               break;
          case "columnsetting":
               $this->columnsetting($data);
               break;
          case "columnsettingsave":
               $this->columnsetting_save($data);
               break;
       }
          } catch(\Exception $e) {
          //$this->ajaxResult("客户账单列表后台错误");
          $this->ajaxResult($e->getMessage());
      }
    }


    private function columnsetting_define(){
        return array(
            'status'=>'状态',
            'fee_no'=>'费用账单',
            'org_id'=>'库联',
            'customer_name'=>'客户名称',
            'tx_month'=>'费用月份',
            'warehouse_code'=>'仓库编码',
            'fee_total'=>'费用合计(元)',
            'fee_transfer'=>'过户费用(元)',
            'fee_store'=>'仓储费用(元)',
            'fee_stockin'=>'进库费用(元)',
            'fee_stockout'=>'出库费用(元)',
            'fee_other'=>'其他费用(元)',
            'create_time'=>'创建时间',
        );
    }

    private function columnsetting($data){
        $data['user_code']=session(C("USER_AUTH_KEY"));
        $data['summary']='FeeSummary';
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

        $this->ajaxResult("", "",  array("_asr.closeTab","_asr.closePopup", "_asr.openLink","_asr.hideMask()"), array("$('#".$data["funcid"]."-Tab').find('a'), '".$data["funcid"]."'","'".$data["funcid"]."'", "'". U("/Summary/FeeSummary/index?func=search&").  "','".filterFuncId("FeeSummary_Search","id=0")."','客户账单列表', 1",""));


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
       $search["fee_no"] = I("request.fee_no");
       $search["org_id"] = I("request.org_id");
       $search["customer_id_name"] = I("request.customer_id_name");
       $search["customer_id"] = I("request.customer_id");
       $search["customer_name"] = I("request.customer_name");
       $search["tx_month"] = I("request.tx_month");
       $search["warehouse_code_name"] = I("request.warehouse_code_name");
       $search["warehouse_code"] = I("request.warehouse_code");
       $search["fee_total"] = I("request.fee_total");
       $search["fee_total2"] = I("request.fee_total2");
       $search["fee_transfer"] = I("request.fee_transfer");
       $search["fee_transfer2"] = I("request.fee_transfer2");
       $search["fee_store"] = I("request.fee_store");
       $search["fee_store2"] = I("request.fee_store2");
       $search["fee_stockin"] = I("request.fee_stockin");
       $search["fee_stockin2"] = I("request.fee_stockin2");
       $search["fee_stockout"] = I("request.fee_stockout");
       $search["fee_stockout2"] = I("request.fee_stockout2");
       $search["fee_other"] = I("request.fee_other");
       $search["fee_other2"] = I("request.fee_other2");
       $search["create_time"] = I("request.create_time");
       $search["create_time2"] = I("request.create_time2");

       //判断首次装载是否要赋予缺省值
       if($firstloading){
       }



       $condition="";
       $condition_fee="";
       if($bsearch) {
           //关键字条件
           if($search["_showsearch"]=="hide"  ){
               if($search["_keyword"]){
                   $condition_keyword = "";
                   $condition_keyword = join_condition($condition_keyword,"@fee.fee_no",$search["_keyword"],"char", "both" , 0, "" );
                   $condition_fee = " AND ( ". $condition_keyword .")";
               }
           }else{
               //高级搜索condition
               $condition_fee = join_condition($condition_fee,"@fee.status",$search["status"],"int");
               $condition_fee = join_condition($condition_fee,"@fee.fee_no",$search["fee_no"],"char","both");
               $condition_fee = join_condition($condition_fee,"@fee.org_id",$search["org_id"],"int");
               $condition_fee = join_condition($condition_fee,"@fee.customer_id",$search["customer_id"],"int");
               $condition_fee = join_condition($condition_fee,"@fee.customer_name",$search["customer_name"],"char","both");
               $condition_fee = join_condition($condition_fee,"@fee.tx_month",$search["tx_month"],"char");
               $condition_fee = join_condition($condition_fee,"@fee.warehouse_code",$search["warehouse_code"],"char");
               $condition_fee = join_condition2($condition_fee,"@fee.fee_total",$search["fee_total"],$search["fee_total2"],"decimal");
               $condition_fee = join_condition2($condition_fee,"@fee.fee_transfer",$search["fee_transfer"],$search["fee_transfer2"],"decimal");
               $condition_fee = join_condition2($condition_fee,"@fee.fee_store",$search["fee_store"],$search["fee_store2"],"decimal");
               $condition_fee = join_condition2($condition_fee,"@fee.fee_stockin",$search["fee_stockin"],$search["fee_stockin2"],"decimal");
               $condition_fee = join_condition2($condition_fee,"@fee.fee_stockout",$search["fee_stockout"],$search["fee_stockout2"],"decimal");
               $condition_fee = join_condition2($condition_fee,"@fee.fee_other",$search["fee_other"],$search["fee_other2"],"decimal");
               $condition_fee = join_condition2($condition_fee,"@fee.create_time",$search["create_time"],$search["create_time2"],"datetime");
           }

           //增加 tab 条件
           $condition_fee = $this->tabsheet_condition($condition_fee ,$search["_tab"]);
           //增加数据权限
       $auth_condition=$this->get_auth_condition();
       $condition_fee = join_condition_auth($condition_fee,$auth_condition,"");
           //select fields
           $selectfields=" @fee.status ";
           $selectfields.=", @fee.id ";
           $selectfields.=", @fee.fee_no ";
           $selectfields.=", @fee.org_id ";
           $selectfields.=", @fee.customer_name ";
           $selectfields.=", @fee.tx_month ";
           $selectfields.=", @fee.warehouse_code ";
           $selectfields.=", @fee.fee_total ";
           $selectfields.=", @fee.fee_transfer ";
           $selectfields.=", @fee.fee_store ";
           $selectfields.=", @fee.fee_stockin ";
           $selectfields.=", @fee.fee_stockout ";
           $selectfields.=", @fee.fee_other ";
           $selectfields.=", @fee.create_time ";


           $page_size = I("request.pagesize/d");
           if ($page_size<=0){
               $page_size = session("FeeSummary-PageSize");
               if (!$page_size) {
                    $page_size = 10;
               }
           }
           session("FeeSummary-PageSize", $page_size);


           $join="";
           $count_sql = "select count(*) as cnt from @fee  #join#  where 1=1 #condition#";  // ' for skip replace $condition
           $count_sql = str_replace("#join#",$join,$count_sql);
           $count_sql = str_replace("#condition#",$condition_fee,$count_sql);
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
           $sql = "select #selectfields# from @fee  #join# Where 1=1 #condition# #orderby#";
           $sql = str_replace("#selectfields#",$selectfields,$sql);
           $sql = str_replace("#join#",$join,$sql);
           $sql = str_replace("#condition#",$condition_fee,$sql);
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
        $html = $this->fetch("FeeSummary:index");
        echo $html;
    }

    public function detail($data) {
        $condition="";
        $masterkey="";
        $join="";
        $data["p"] = I("request.p/d");

        $data["tab"] = I("request.tab");
        $search["id"] = I("request.id/d");
        $condition.=" and @fee_detail.fee_id=".$search["id"];
        $masterkey.=" id=".$search["id"];
        $data["search"] = M("fee")->where($masterkey)->find();


        if(!$search)   // no param
           $this->ajaxError("查询参数非法");

        $selectfields="@fee_detail.id ";
        $selectfields.=",@fee_detail.fee_no ";
        $selectfields.=",@fee_detail.org_id ";
        $selectfields.=",@fee_detail.customer_id ";
        $selectfields.=",@customer.name customer_id_name ";
        $selectfields.=",@fee_detail.customer_name ";
        $selectfields.=",@fee_detail.tx_month ";
        $selectfields.=",@fee_detail.warehouse_code ";
        $selectfields.=",@warehouse.name warehouse_code_name ";
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

        $page_size = 50;

        $condition= $condition;
        $count_sql = "select count(*) as cnt from @fee_detail LEFT JOIN @customer ON @customer.id=@fee_detail.customer_id LEFT JOIN @warehouse ON @warehouse.code=@fee_detail.warehouse_code  #join# where 1=1 #condition#";
        $count_sql = str_replace("#condition#",$condition,$count_sql);
        $count_sql = str_replace("#join#",$join,$count_sql);

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

        $orderby="";
        $sql = "select #selectfields# from @fee_detail LEFT JOIN @customer ON @customer.id=@fee_detail.customer_id LEFT JOIN @warehouse ON @warehouse.code=@fee_detail.warehouse_code  #join# Where 1=1 #condition# #orderby#";
        $sql = str_replace("#selectfields#",$selectfields,$sql);
        $sql = str_replace("#join#",$join,$sql);
        $sql = str_replace("#condition#",$condition,$sql);
        $sql = str_replace("#orderby#",$orderby,$sql);
        $sql .= " LIMIT ". (($data["p"] - 1) * $page_size). ", $page_size";

        $sql = table($sql);
        $sql = str_replace("·mailchar·","@",$sql);

        $data["list"] = M()->query($sql);

        $pageClass = new \Think\Page($count,$page_size);
        $pageClass->rollPage = 8;
        $data["page"] = $pageClass->show_drp($data["funcid"],"");
        $data["page_size"] = $page_size;

        $data["master"] = M("fee")->where($masterkey)->find();

        foreach($data as $key=>$val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("FeeSummary:detailindex");
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

        if(empty($data["funcid"])) $data["funcid"] = "FeeSummary";
        if(!$p){
           $p = 1;
           $export_all = 1;
        }

        $show_list = array();

        $data['summary']='FeeSummary';
        $usc = M('user_summary_column')->field("column")->where("user_code='%s' AND summary='%s' AND `show`='1'",array(session(C("USER_AUTH_KEY")),$data['summary']))->select();
        if($usc){
           foreach ($usc as $v) {
              $show_list[$v['column']]=1;
           }
        }

        $search["_tab"] = $this->tabsheet_check(I("request._tab"));
        $tab = $search["_tab"];

        $search["status"] = I("request.status");
        $search["fee_no"] = I("request.fee_no");
        $search["org_id"] = I("request.org_id");
        $search["customer_id_name"] = I("request.customer_id_name");
        $search["customer_id"] = I("request.customer_id");
        $search["customer_name"] = I("request.customer_name");
        $search["tx_month"] = I("request.tx_month");
        $search["warehouse_code_name"] = I("request.warehouse_code_name");
        $search["warehouse_code"] = I("request.warehouse_code");
        $search["fee_total"] = I("request.fee_total");
        $search["fee_total2"] = I("request.fee_total2");
        $search["fee_transfer"] = I("request.fee_transfer");
        $search["fee_transfer2"] = I("request.fee_transfer2");
        $search["fee_store"] = I("request.fee_store");
        $search["fee_store2"] = I("request.fee_store2");
        $search["fee_stockin"] = I("request.fee_stockin");
        $search["fee_stockin2"] = I("request.fee_stockin2");
        $search["fee_stockout"] = I("request.fee_stockout");
        $search["fee_stockout2"] = I("request.fee_stockout2");
        $search["fee_other"] = I("request.fee_other");
        $search["fee_other2"] = I("request.fee_other2");
        $search["create_time"] = I("request.create_time");
        $search["create_time2"] = I("request.create_time2");


        //condition
        $condition="";
        $condition_fee="";

        //读取关键字搜索内容
        $search["_keyword"] = I("request._keyword");
        if($search["_showsearch"]=="hide"  ){
            if($search["_keyword"]){
                $condition_keyword = "";
                $condition_keyword = join_condition($condition_keyword,"@fee.fee_no",$search["_keyword"],"char", "both" , 0, "" );
                $condition_fee = " AND ( ". $condition_keyword . ")";
            }
        }else{
        //高级搜索condition
           $condition_fee = join_condition($condition_fee,"@fee.status",$search["status"],"int");
           $condition_fee = join_condition($condition_fee,"@fee.fee_no",$search["fee_no"],"char","both");

           $search_auth_codes = $search["org_id"];
           $condition_fee = join_condition($condition_fee,"@fee.customer_id",$search["customer_id"],"int");
           $condition_fee = join_condition($condition_fee,"@fee.customer_name",$search["customer_name"],"char","both");
           $condition_fee = join_condition($condition_fee,"@fee.tx_month",$search["tx_month"],"char");
           $condition_fee = join_condition($condition_fee,"@fee.warehouse_code",$search["warehouse_code"],"char");
           $condition_fee = join_condition2($condition_fee,"@fee.fee_total",$search["fee_total"],$search["fee_total2"],"decimal");
           $condition_fee = join_condition2($condition_fee,"@fee.fee_transfer",$search["fee_transfer"],$search["fee_transfer2"],"decimal");
           $condition_fee = join_condition2($condition_fee,"@fee.fee_store",$search["fee_store"],$search["fee_store2"],"decimal");
           $condition_fee = join_condition2($condition_fee,"@fee.fee_stockin",$search["fee_stockin"],$search["fee_stockin2"],"decimal");
           $condition_fee = join_condition2($condition_fee,"@fee.fee_stockout",$search["fee_stockout"],$search["fee_stockout2"],"decimal");
           $condition_fee = join_condition2($condition_fee,"@fee.fee_other",$search["fee_other"],$search["fee_other2"],"decimal");
           $condition_fee = join_condition2($condition_fee,"@fee.create_time",$search["create_time"],$search["create_time2"],"datetime");
        }
        $condition_fee = $this->tabsheet_condition($condition_fee ,$search["_tab"]);
          $condition_fee = join_condition_shop($condition_fee,"2;@fee.org_id;org_id#3;@fee.customer_id;customer_id",$this->user_shop_id,$search_auth_codes);

        //select fields
        $selectfields="@fee.status ";
        $selectfields.=",@fee.id ";
        $selectfields.=",@fee.fee_no ";
        $selectfields.=",@fee.org_id ";
        $selectfields.=",@fee.customer_name ";
        $selectfields.=",@fee.tx_month ";
        $selectfields.=",@fee.warehouse_code ";
        $selectfields.=",@fee.fee_total ";
        $selectfields.=",@fee.fee_transfer ";
        $selectfields.=",@fee.fee_store ";
        $selectfields.=",@fee.fee_stockin ";
        $selectfields.=",@fee.fee_stockout ";
        $selectfields.=",@fee.fee_other ";
        $selectfields.=",@fee.create_time ";


        $str_header = "";
        if ($show_list['status']==1 || empty($show_list)){
            $str_header .= "状态,";
        }
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
        if ($show_list['fee_total']==1 || empty($show_list)){
            $str_header .= "费用合计(元),";
        }
        if ($show_list['fee_transfer']==1 || empty($show_list)){
            $str_header .= "过户费用(元),";
        }
        if ($show_list['fee_store']==1 || empty($show_list)){
            $str_header .= "仓储费用(元),";
        }
        if ($show_list['fee_stockin']==1 || empty($show_list)){
            $str_header .= "进库费用(元),";
        }
        if ($show_list['fee_stockout']==1 || empty($show_list)){
            $str_header .= "出库费用(元),";
        }
        if ($show_list['fee_other']==1 || empty($show_list)){
            $str_header .= "其他费用(元),";
        }
        if ($show_list['create_time']==1 || empty($show_list)){
            $str_header .= "创建时间,";
        }
        $str_header .= "\r\n";

        $join="";

       $count_sql = "select count(*) as cnt from @fee  #join#  where 1=1 #condition#";  // ' for skip replace $condition
       $count_sql = str_replace("#join#",$join,$count_sql);
       $count_sql = str_replace("#condition#",$condition_fee,$count_sql);

       $count_sql = table($count_sql);
       $count_sql = str_replace("·mailchar·","@",$count_sql);
       $count = M()->query($count_sql);
       $count = $count[0]["cnt"];

           $total_page=0;

        if(!$export_all) {
           $page_size = I("request.pagesize/d");
           $page_size = $page_size <= 0 ? session("FeeSummary-PageSize") : $page_size;
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

        $sql = "select #selectfields# from @fee  #join# Where 1=1 #condition# #orderby#";   // ' for skip replace $selectfields,$condition,$orderby
        $sql = str_replace("#selectfields#",$selectfields,$sql);
        $sql = str_replace("#join#",$join,$sql);
        $sql = str_replace("#condition#",$condition_fee,$sql);
        $sql = str_replace("#orderby#",$orderby,$sql);
        $sql .= " LIMIT ". (($p - 1) * $page_size). ", ".$page_size;

        $sql = table($sql);
        $sql = str_replace("·mailchar·","@",$sql);
        $list = M()->query($sql);

        foreach($list as $master) {
            $str_line="";
            if ($show_list['status']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Fee_status("$master[status]","name"))."\t,";
            }
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
            if ($show_list['fee_total']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("F32", $master["fee_total"]))."\t,";
            }
            if ($show_list['fee_transfer']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("F32", $master["fee_transfer"]))."\t,";
            }
            if ($show_list['fee_store']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("F32", $master["fee_store"]))."\t,";
            }
            if ($show_list['fee_stockin']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("F32", $master["fee_stockin"]))."\t,";
            }
            if ($show_list['fee_stockout']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("F32", $master["fee_stockout"]))."\t,";
            }
            if ($show_list['fee_other']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("F32", $master["fee_other"]))."\t,";
            }
            if ($show_list['create_time']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("DT", $master["create_time"]))."\t,";
            }
            $str_content .= $str_line . "\r\n";
        }
    }
        header('Content-Type: text/xls');
        header ("Content-type:application/vnd.ms-excel;charset=gbk" );
        $str = mb_convert_encoding("FeeSummary", 'gbk', 'utf-8');
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
          case 'daikehufukuan':
          case 'daicangkuqueren':
          case 'cangkuyiqueren':
              break;
          default:
              $itab='all';
              break;
              $itab='daikehufukuan';
              break;
              $itab='daicangkuqueren';
              break;
              $itab='cangkuyiqueren';
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
            case 'daikehufukuan':  //待客户付款
                 $scond="@fee.status='0'";
                 break;
            case 'daicangkuqueren':  //待仓库确认
                 $scond="@fee.status='1'";
                 break;
            case 'cangkuyiqueren':  //仓库已确认
                 $scond="@fee.status='2'";
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
            case 'daikehufukuan':  //待客户付款
                 break;
            case 'daicangkuqueren':  //待仓库确认
                 break;
            case 'cangkuyiqueren':  //仓库已确认
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
            $condition.=" @fee.org_id='".$this->user["org_id"]."' ";
            break;
        case "3":
            $condition.=" @fee.customer_id='".$this->user["customer_id"]."' ";
            break;
        }
        return $condition ;
    }
}
