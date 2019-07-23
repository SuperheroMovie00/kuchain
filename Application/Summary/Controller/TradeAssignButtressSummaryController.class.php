<?php namespace Summary\Controller;
//
//注释: TradeAssignButtressSummary - 交易配货垛号列表
//
use Home\Controller\BasicController;
use Think\Log;
class TradeAssignButtressSummaryController extends BasicController {

    public function _init() {
        $funcs = $this->getUserRoleList($this->user,array( '/Home/TradeAssignButtress', 'TradeAssignButtressSummary', ));
        if ($funcs)
            $this->assign("rights",  $funcs);
        else{
            $funcs = array(
                         array("key"=>"add","func"=>"/Home/TradeAssignButtress","Action"=>"add") ,
                         array("key"=>"refresh","func"=>"TradeAssignButtressSummary","Action"=>"refresh") ,
                         array("key"=>"search","func"=>"TradeAssignButtressSummary","Action"=>"search") ,
                         array("key"=>"export","func"=>"TradeAssignButtressSummary","Action"=>"export") ,
                         array("key"=>"master_view","func"=>"/Home/TradeAssignButtress","Action"=>"view") ,
                         array("key"=>"master_edit","func"=>"/Home/TradeAssignButtress","Action"=>"edit") ,
                         array("key"=>"master_delete","func"=>"/Home/TradeAssignButtress","Action"=>"delete")
             );
            $this->assign("rights",  $this->GetUserRights($this->user["id"],$funcs ));
        }
        $this->assign("colshow", $this->GetUserColumnDefine($this->user["id"],"TradeAssignButtressSummary"));
    }

    public function index() {
         try {
        $data["pfuncid"] = I("request.pfuncid");
        $data["funcid"] = I("request.funcid");
        $data["zindex"] = I("request.zindex/d");
        if(empty($data["funcid"])) $data["funcid"] = "TradeAssignButtressSummary";
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
          //$this->ajaxResult("交易配货垛号列表后台错误");
          $this->ajaxResult($e->getMessage());
      }
    }


    private function columnsetting_define(){
        return array(
            'status'=>'状态',
            'org_id'=>'库联',
            'trade_id'=>'交易单',
            'trade_no'=>'交易单号',
            'warehouse_code'=>'仓库编码',
            'storecard_id'=>'存储卡',
            'storecard_no'=>'存储卡号',
            'package_id'=>'码单',
            'buttress_id'=>'垛号',
            'package_no'=>'码单号',
            'buttress_no'=>'垛号',
            'batchno'=>'货品批号',
            'location_code'=>'仓库仓位',
            'weight'=>'重量',
            'qty'=>'数量',
            'bulkcargo'=>'散件',
            'release_time'=>'释放时间',
            'act_weight'=>'实发重量',
            'act_qty'=>'实发数量',
            'act_bulkcargo'=>'实发散件',
            'act_time'=>'扣除时间',
            'create_time'=>'创建时间',
        );
    }

    private function columnsetting($data){
        $data['user_code']=session(C("USER_AUTH_KEY"));
        $data['summary']='TradeAssignButtressSummary';
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

        $this->ajaxResult("", "",  array("_asr.closeTab","_asr.closePopup", "_asr.openLink","_asr.hideMask()"), array("$('#".$data["funcid"]."-Tab').find('a'), '".$data["funcid"]."'","'".$data["funcid"]."'", "'". U("/Summary/TradeAssignButtressSummary/index?func=search&").  "','".filterFuncId("TradeAssignButtressSummary_Search","id=0")."','交易配货垛号列表', 1",""));


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
       $search["trade_id"] = I("request.trade_id");
       $search["trade_no"] = I("request.trade_no");
       $search["warehouse_code_name"] = I("request.warehouse_code_name");
       $search["warehouse_code"] = I("request.warehouse_code");
       $search["storecard_id"] = I("request.storecard_id");
       $search["storecard_no"] = I("request.storecard_no");
       $search["package_id"] = I("request.package_id");
       $search["buttress_id"] = I("request.buttress_id");
       $search["package_no"] = I("request.package_no");
       $search["buttress_no"] = I("request.buttress_no");
       $search["batchno"] = I("request.batchno");
       $search["location_code"] = I("request.location_code");
       $search["weight"] = I("request.weight");
       $search["weight2"] = I("request.weight2");
       $search["qty"] = I("request.qty");
       $search["qty2"] = I("request.qty2");
       $search["bulkcargo"] = I("request.bulkcargo");
       $search["bulkcargo2"] = I("request.bulkcargo2");
       $search["release_time"] = I("request.release_time");
       $search["release_time2"] = I("request.release_time2");
       $search["act_weight"] = I("request.act_weight");
       $search["act_weight2"] = I("request.act_weight2");
       $search["act_qty"] = I("request.act_qty");
       $search["act_qty2"] = I("request.act_qty2");
       $search["act_bulkcargo"] = I("request.act_bulkcargo");
       $search["act_bulkcargo2"] = I("request.act_bulkcargo2");
       $search["act_time"] = I("request.act_time");
       $search["act_time2"] = I("request.act_time2");
       $search["create_time"] = I("request.create_time");
       $search["create_time2"] = I("request.create_time2");

       //判断首次装载是否要赋予缺省值
       if($firstloading){
       }



       $condition="";
       $condition_trade_assign_buttress="";
       if($bsearch) {
           //关键字条件
           if($search["_showsearch"]=="hide"  ){
               if($search["_keyword"]){
                   $condition_keyword = "";
                   $condition_keyword = join_condition($condition_keyword,"@trade_assign_buttress.trade_no",$search["_keyword"],"char", "both" , 0, "" );
                   $condition_trade_assign_buttress = " AND ( ". $condition_keyword .")";
               }
           }else{
               //高级搜索condition
               $condition_trade_assign_buttress = join_condition($condition_trade_assign_buttress,"@trade_assign_buttress.status",$search["status"],"int");
               $condition_trade_assign_buttress = join_condition($condition_trade_assign_buttress,"@trade_assign_buttress.org_id",$search["org_id"],"int");
               $condition_trade_assign_buttress = join_condition($condition_trade_assign_buttress,"@trade_assign_buttress.customer_id",$search["customer_id"],"int");
               $condition_trade_assign_buttress = join_condition($condition_trade_assign_buttress,"@trade_assign_buttress.trade_id",$search["trade_id"],"int");
               $condition_trade_assign_buttress = join_condition($condition_trade_assign_buttress,"@trade_assign_buttress.trade_no",$search["trade_no"],"char");
               $condition_trade_assign_buttress = join_condition($condition_trade_assign_buttress,"@trade_assign_buttress.warehouse_code",$search["warehouse_code"],"char");
               $condition_trade_assign_buttress = join_condition($condition_trade_assign_buttress,"@trade_assign_buttress.storecard_id",$search["storecard_id"],"int");
               $condition_trade_assign_buttress = join_condition($condition_trade_assign_buttress,"@trade_assign_buttress.storecard_no",$search["storecard_no"],"char");
               $condition_trade_assign_buttress = join_condition($condition_trade_assign_buttress,"@trade_assign_buttress.package_id",$search["package_id"],"int");
               $condition_trade_assign_buttress = join_condition($condition_trade_assign_buttress,"@trade_assign_buttress.buttress_id",$search["buttress_id"],"int");
               $condition_trade_assign_buttress = join_condition($condition_trade_assign_buttress,"@trade_assign_buttress.package_no",$search["package_no"],"char");
               $condition_trade_assign_buttress = join_condition($condition_trade_assign_buttress,"@trade_assign_buttress.buttress_no",$search["buttress_no"],"char");
               $condition_trade_assign_buttress = join_condition($condition_trade_assign_buttress,"@trade_assign_buttress.batchno",$search["batchno"],"char");
               $condition_trade_assign_buttress = join_condition($condition_trade_assign_buttress,"@trade_assign_buttress.location_code",$search["location_code"],"char");
               $condition_trade_assign_buttress = join_condition2($condition_trade_assign_buttress,"@trade_assign_buttress.weight",$search["weight"],$search["weight2"],"decimal");
               $condition_trade_assign_buttress = join_condition2($condition_trade_assign_buttress,"@trade_assign_buttress.qty",$search["qty"],$search["qty2"],"decimal");
               $condition_trade_assign_buttress = join_condition2($condition_trade_assign_buttress,"@trade_assign_buttress.bulkcargo",$search["bulkcargo"],$search["bulkcargo2"],"decimal");
               $condition_trade_assign_buttress = join_condition2($condition_trade_assign_buttress,"@trade_assign_buttress.release_time",$search["release_time"],$search["release_time2"],"datetime");
               $condition_trade_assign_buttress = join_condition2($condition_trade_assign_buttress,"@trade_assign_buttress.act_weight",$search["act_weight"],$search["act_weight2"],"decimal");
               $condition_trade_assign_buttress = join_condition2($condition_trade_assign_buttress,"@trade_assign_buttress.act_qty",$search["act_qty"],$search["act_qty2"],"decimal");
               $condition_trade_assign_buttress = join_condition2($condition_trade_assign_buttress,"@trade_assign_buttress.act_bulkcargo",$search["act_bulkcargo"],$search["act_bulkcargo2"],"decimal");
               $condition_trade_assign_buttress = join_condition2($condition_trade_assign_buttress,"@trade_assign_buttress.act_time",$search["act_time"],$search["act_time2"],"datetime");
               $condition_trade_assign_buttress = join_condition2($condition_trade_assign_buttress,"@trade_assign_buttress.create_time",$search["create_time"],$search["create_time2"],"datetime");
           }

           //增加 tab 条件
           $condition_trade_assign_buttress = $this->tabsheet_condition($condition_trade_assign_buttress ,$search["_tab"]);
           //增加数据权限
       $auth_condition=$this->get_auth_condition();
       $condition_trade_assign_buttress = join_condition_auth($condition_trade_assign_buttress,$auth_condition,"");
           //select fields
           $selectfields=" @trade_assign_buttress.status ";
           $selectfields.=", @trade_assign_buttress.id ";
           $selectfields.=", @trade_assign_buttress.org_id ";
           $selectfields.=", @trade_assign_buttress.customer_id ";
           $selectfields.=", @trade_assign_buttress.trade_id ";
           $selectfields.=", @trade_assign_buttress.trade_no ";
           $selectfields.=", @trade_assign_buttress.warehouse_code ";
           $selectfields.=", @trade_assign_buttress.storecard_id ";
           $selectfields.=", @trade_assign_buttress.storecard_no ";
           $selectfields.=", @trade_assign_buttress.package_id ";
           $selectfields.=", @trade_assign_buttress.buttress_id ";
           $selectfields.=", @trade_assign_buttress.package_no ";
           $selectfields.=", @trade_assign_buttress.buttress_no ";
           $selectfields.=", @trade_assign_buttress.batchno ";
           $selectfields.=", @trade_assign_buttress.location_code ";
           $selectfields.=", @trade_assign_buttress.weight ";
           $selectfields.=", @trade_assign_buttress.qty ";
           $selectfields.=", @trade_assign_buttress.bulkcargo ";
           $selectfields.=", @trade_assign_buttress.release_time ";
           $selectfields.=", @trade_assign_buttress.act_weight ";
           $selectfields.=", @trade_assign_buttress.act_qty ";
           $selectfields.=", @trade_assign_buttress.act_bulkcargo ";
           $selectfields.=", @trade_assign_buttress.act_time ";
           $selectfields.=", @trade_assign_buttress.create_time ";


           $page_size = I("request.pagesize/d");
           if ($page_size<=0){
               $page_size = session("TradeAssignButtressSummary-PageSize");
               if (!$page_size) {
                    $page_size = 10;
               }
           }
           session("TradeAssignButtressSummary-PageSize", $page_size);


           $join="";
           $count_sql = "select count(*) as cnt from @trade_assign_buttress  #join#  where 1=1 #condition#";  // ' for skip replace $condition
           $count_sql = str_replace("#join#",$join,$count_sql);
           $count_sql = str_replace("#condition#",$condition_trade_assign_buttress,$count_sql);
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
           $sql = "select #selectfields# from @trade_assign_buttress  #join# Where 1=1 #condition# #orderby#";
           $sql = str_replace("#selectfields#",$selectfields,$sql);
           $sql = str_replace("#join#",$join,$sql);
           $sql = str_replace("#condition#",$condition_trade_assign_buttress,$sql);
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
        $html = $this->fetch("TradeAssignButtressSummary:index");
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

        if(empty($data["funcid"])) $data["funcid"] = "TradeAssignButtressSummary";
        if(!$p){
           $p = 1;
           $export_all = 1;
        }

        $show_list = array();

        $data['summary']='TradeAssignButtressSummary';
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
        $search["trade_id"] = I("request.trade_id");
        $search["trade_no"] = I("request.trade_no");
        $search["warehouse_code_name"] = I("request.warehouse_code_name");
        $search["warehouse_code"] = I("request.warehouse_code");
        $search["storecard_id"] = I("request.storecard_id");
        $search["storecard_no"] = I("request.storecard_no");
        $search["package_id"] = I("request.package_id");
        $search["buttress_id"] = I("request.buttress_id");
        $search["package_no"] = I("request.package_no");
        $search["buttress_no"] = I("request.buttress_no");
        $search["batchno"] = I("request.batchno");
        $search["location_code"] = I("request.location_code");
        $search["weight"] = I("request.weight");
        $search["weight2"] = I("request.weight2");
        $search["qty"] = I("request.qty");
        $search["qty2"] = I("request.qty2");
        $search["bulkcargo"] = I("request.bulkcargo");
        $search["bulkcargo2"] = I("request.bulkcargo2");
        $search["release_time"] = I("request.release_time");
        $search["release_time2"] = I("request.release_time2");
        $search["act_weight"] = I("request.act_weight");
        $search["act_weight2"] = I("request.act_weight2");
        $search["act_qty"] = I("request.act_qty");
        $search["act_qty2"] = I("request.act_qty2");
        $search["act_bulkcargo"] = I("request.act_bulkcargo");
        $search["act_bulkcargo2"] = I("request.act_bulkcargo2");
        $search["act_time"] = I("request.act_time");
        $search["act_time2"] = I("request.act_time2");
        $search["create_time"] = I("request.create_time");
        $search["create_time2"] = I("request.create_time2");


        //condition
        $condition="";
        $condition_trade_assign_buttress="";

        //读取关键字搜索内容
        $search["_keyword"] = I("request._keyword");
        if($search["_showsearch"]=="hide"  ){
            if($search["_keyword"]){
                $condition_keyword = "";
                $condition_keyword = join_condition($condition_keyword,"@trade_assign_buttress.trade_no",$search["_keyword"],"char", "both" , 0, "" );
                $condition_trade_assign_buttress = " AND ( ". $condition_keyword . ")";
            }
        }else{
        //高级搜索condition
           $condition_trade_assign_buttress = join_condition($condition_trade_assign_buttress,"@trade_assign_buttress.status",$search["status"],"int");

           $search_auth_codes = $search["org_id"];
           $condition_trade_assign_buttress = join_condition($condition_trade_assign_buttress,"@trade_assign_buttress.customer_id",$search["customer_id"],"int");
           $condition_trade_assign_buttress = join_condition($condition_trade_assign_buttress,"@trade_assign_buttress.trade_id",$search["trade_id"],"int");
           $condition_trade_assign_buttress = join_condition($condition_trade_assign_buttress,"@trade_assign_buttress.trade_no",$search["trade_no"],"char");
           $condition_trade_assign_buttress = join_condition($condition_trade_assign_buttress,"@trade_assign_buttress.warehouse_code",$search["warehouse_code"],"char");
           $condition_trade_assign_buttress = join_condition($condition_trade_assign_buttress,"@trade_assign_buttress.storecard_id",$search["storecard_id"],"int");
           $condition_trade_assign_buttress = join_condition($condition_trade_assign_buttress,"@trade_assign_buttress.storecard_no",$search["storecard_no"],"char");
           $condition_trade_assign_buttress = join_condition($condition_trade_assign_buttress,"@trade_assign_buttress.package_id",$search["package_id"],"int");
           $condition_trade_assign_buttress = join_condition($condition_trade_assign_buttress,"@trade_assign_buttress.buttress_id",$search["buttress_id"],"int");
           $condition_trade_assign_buttress = join_condition($condition_trade_assign_buttress,"@trade_assign_buttress.package_no",$search["package_no"],"char");
           $condition_trade_assign_buttress = join_condition($condition_trade_assign_buttress,"@trade_assign_buttress.buttress_no",$search["buttress_no"],"char");
           $condition_trade_assign_buttress = join_condition($condition_trade_assign_buttress,"@trade_assign_buttress.batchno",$search["batchno"],"char");
           $condition_trade_assign_buttress = join_condition($condition_trade_assign_buttress,"@trade_assign_buttress.location_code",$search["location_code"],"char");
           $condition_trade_assign_buttress = join_condition2($condition_trade_assign_buttress,"@trade_assign_buttress.weight",$search["weight"],$search["weight2"],"decimal");
           $condition_trade_assign_buttress = join_condition2($condition_trade_assign_buttress,"@trade_assign_buttress.qty",$search["qty"],$search["qty2"],"decimal");
           $condition_trade_assign_buttress = join_condition2($condition_trade_assign_buttress,"@trade_assign_buttress.bulkcargo",$search["bulkcargo"],$search["bulkcargo2"],"decimal");
           $condition_trade_assign_buttress = join_condition2($condition_trade_assign_buttress,"@trade_assign_buttress.release_time",$search["release_time"],$search["release_time2"],"datetime");
           $condition_trade_assign_buttress = join_condition2($condition_trade_assign_buttress,"@trade_assign_buttress.act_weight",$search["act_weight"],$search["act_weight2"],"decimal");
           $condition_trade_assign_buttress = join_condition2($condition_trade_assign_buttress,"@trade_assign_buttress.act_qty",$search["act_qty"],$search["act_qty2"],"decimal");
           $condition_trade_assign_buttress = join_condition2($condition_trade_assign_buttress,"@trade_assign_buttress.act_bulkcargo",$search["act_bulkcargo"],$search["act_bulkcargo2"],"decimal");
           $condition_trade_assign_buttress = join_condition2($condition_trade_assign_buttress,"@trade_assign_buttress.act_time",$search["act_time"],$search["act_time2"],"datetime");
           $condition_trade_assign_buttress = join_condition2($condition_trade_assign_buttress,"@trade_assign_buttress.create_time",$search["create_time"],$search["create_time2"],"datetime");
        }
        $condition_trade_assign_buttress = $this->tabsheet_condition($condition_trade_assign_buttress ,$search["_tab"]);
          $condition_trade_assign_buttress = join_condition_shop($condition_trade_assign_buttress,"2;@trade_assign_buttress.org_id;org_id#3;@trade_assign_buttress.customer_id;customer_id",$this->user_shop_id,$search_auth_codes);

        //select fields
        $selectfields="@trade_assign_buttress.status ";
        $selectfields.=",@trade_assign_buttress.id ";
        $selectfields.=",@trade_assign_buttress.org_id ";
        $selectfields.=",@trade_assign_buttress.customer_id ";
        $selectfields.=",@trade_assign_buttress.trade_id ";
        $selectfields.=",@trade_assign_buttress.trade_no ";
        $selectfields.=",@trade_assign_buttress.warehouse_code ";
        $selectfields.=",@trade_assign_buttress.storecard_id ";
        $selectfields.=",@trade_assign_buttress.storecard_no ";
        $selectfields.=",@trade_assign_buttress.package_id ";
        $selectfields.=",@trade_assign_buttress.buttress_id ";
        $selectfields.=",@trade_assign_buttress.package_no ";
        $selectfields.=",@trade_assign_buttress.buttress_no ";
        $selectfields.=",@trade_assign_buttress.batchno ";
        $selectfields.=",@trade_assign_buttress.location_code ";
        $selectfields.=",@trade_assign_buttress.weight ";
        $selectfields.=",@trade_assign_buttress.qty ";
        $selectfields.=",@trade_assign_buttress.bulkcargo ";
        $selectfields.=",@trade_assign_buttress.release_time ";
        $selectfields.=",@trade_assign_buttress.act_weight ";
        $selectfields.=",@trade_assign_buttress.act_qty ";
        $selectfields.=",@trade_assign_buttress.act_bulkcargo ";
        $selectfields.=",@trade_assign_buttress.act_time ";
        $selectfields.=",@trade_assign_buttress.create_time ";


        $str_header = "";
        if ($show_list['status']==1 || empty($show_list)){
            $str_header .= "状态,";
        }
        if ($show_list['org_id']==1 || empty($show_list)){
            $str_header .= "库联,";
        }
        if ($show_list['trade_id']==1 || empty($show_list)){
            $str_header .= "交易单,";
        }
        if ($show_list['trade_no']==1 || empty($show_list)){
            $str_header .= "交易单号,";
        }
        if ($show_list['warehouse_code']==1 || empty($show_list)){
            $str_header .= "仓库编码,";
        }
        if ($show_list['storecard_id']==1 || empty($show_list)){
            $str_header .= "存储卡,";
        }
        if ($show_list['storecard_no']==1 || empty($show_list)){
            $str_header .= "存储卡号,";
        }
        if ($show_list['package_id']==1 || empty($show_list)){
            $str_header .= "码单,";
        }
        if ($show_list['buttress_id']==1 || empty($show_list)){
            $str_header .= "垛号,";
        }
        if ($show_list['package_no']==1 || empty($show_list)){
            $str_header .= "码单号,";
        }
        if ($show_list['buttress_no']==1 || empty($show_list)){
            $str_header .= "垛号,";
        }
        if ($show_list['batchno']==1 || empty($show_list)){
            $str_header .= "货品批号,";
        }
        if ($show_list['location_code']==1 || empty($show_list)){
            $str_header .= "仓库仓位,";
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
        if ($show_list['release_time']==1 || empty($show_list)){
            $str_header .= "释放时间,";
        }
        if ($show_list['act_weight']==1 || empty($show_list)){
            $str_header .= "实发重量,";
        }
        if ($show_list['act_qty']==1 || empty($show_list)){
            $str_header .= "实发数量,";
        }
        if ($show_list['act_bulkcargo']==1 || empty($show_list)){
            $str_header .= "实发散件,";
        }
        if ($show_list['act_time']==1 || empty($show_list)){
            $str_header .= "扣除时间,";
        }
        if ($show_list['create_time']==1 || empty($show_list)){
            $str_header .= "创建时间,";
        }
        $str_header .= "\r\n";

        $join="";

       $count_sql = "select count(*) as cnt from @trade_assign_buttress  #join#  where 1=1 #condition#";  // ' for skip replace $condition
       $count_sql = str_replace("#join#",$join,$count_sql);
       $count_sql = str_replace("#condition#",$condition_trade_assign_buttress,$count_sql);

       $count_sql = table($count_sql);
       $count_sql = str_replace("·mailchar·","@",$count_sql);
       $count = M()->query($count_sql);
       $count = $count[0]["cnt"];

           $total_page=0;

        if(!$export_all) {
           $page_size = I("request.pagesize/d");
           $page_size = $page_size <= 0 ? session("TradeAssignButtressSummary-PageSize") : $page_size;
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

        $sql = "select #selectfields# from @trade_assign_buttress  #join# Where 1=1 #condition# #orderby#";   // ' for skip replace $selectfields,$condition,$orderby
        $sql = str_replace("#selectfields#",$selectfields,$sql);
        $sql = str_replace("#join#",$join,$sql);
        $sql = str_replace("#condition#",$condition_trade_assign_buttress,$sql);
        $sql = str_replace("#orderby#",$orderby,$sql);
        $sql .= " LIMIT ". (($p - 1) * $page_size). ", ".$page_size;

        $sql = table($sql);
        $sql = str_replace("·mailchar·","@",$sql);
        $list = M()->query($sql);

        foreach($list as $master) {
            $str_line="";
            if ($show_list['status']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_TradeAssignButtress_status("$master[status]","name"))."\t,";
            }
            if ($show_list['org_id']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Org_byID("$master[org_id]","name"))."\t,";
            }
            if ($show_list['trade_id']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["trade_id"])."\t,";
            }
            if ($show_list['trade_no']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["trade_no"])."\t,";
            }
            if ($show_list['warehouse_code']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Warehouse("$master[warehouse_code]","name"))."\t,";
            }
            if ($show_list['storecard_id']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["storecard_id"])."\t,";
            }
            if ($show_list['storecard_no']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["storecard_no"])."\t,";
            }
            if ($show_list['package_id']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["package_id"])."\t,";
            }
            if ($show_list['buttress_id']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["buttress_id"])."\t,";
            }
            if ($show_list['package_no']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["package_no"])."\t,";
            }
            if ($show_list['buttress_no']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["buttress_no"])."\t,";
            }
            if ($show_list['batchno']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["batchno"])."\t,";
            }
            if ($show_list['location_code']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["location_code"])."\t,";
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
            if ($show_list['release_time']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("DT", $master["release_time"]))."\t,";
            }
            if ($show_list['act_weight']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("F33", $master["act_weight"]))."\t,";
            }
            if ($show_list['act_qty']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("N3", $master["act_qty"]))."\t,";
            }
            if ($show_list['act_bulkcargo']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("N3", $master["act_bulkcargo"]))."\t,";
            }
            if ($show_list['act_time']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("DT", $master["act_time"]))."\t,";
            }
            if ($show_list['create_time']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("DT", $master["create_time"]))."\t,";
            }
            $str_content .= $str_line . "\r\n";
        }
    }
        header('Content-Type: text/xls');
        header ("Content-type:application/vnd.ms-excel;charset=gbk" );
        $str = mb_convert_encoding("TradeAssignButtressSummary", 'gbk', 'utf-8');
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
          case 'fou':
          case 'kucunsuoding':
          case 'shifangkouchu':
              break;
          default:
              $itab='all';
              break;
              $itab='fou';
              break;
              $itab='kucunsuoding';
              break;
              $itab='shifangkouchu';
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
            case 'fou':  //否
                 $scond="@trade_assign_buttress.status='0'";
                 break;
            case 'kucunsuoding':  //库存锁定
                 $scond="@trade_assign_buttress.status='1'";
                 break;
            case 'shifangkouchu':  //释放扣除
                 $scond="@trade_assign_buttress.status='2'";
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
            case 'fou':  //否
                 break;
            case 'kucunsuoding':  //库存锁定
                 break;
            case 'shifangkouchu':  //释放扣除
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
            $condition.=" @trade_assign_buttress.org_id='".$this->user["org_id"]."' ";
            break;
        case "3":
            $condition.=" @trade_assign_buttress.customer_id='".$this->user["customer_id"]."' ";
            break;
        }
        return $condition ;
    }
}
