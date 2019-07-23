<?php namespace Summary\Controller;
//
//注释: StorecardLockSummary - 存储卡加锁列表
//
use Home\Controller\BasicController;
use Think\Log;
class StorecardLockSummaryController extends BasicController {

    public function _init() {
        $funcs = $this->getUserRoleList($this->user,array( 'StorecardLockSummary', '/Home/StorecardLock', '/Home/%table%', ));
        if ($funcs)
            $this->assign("rights",  $funcs);
        else{
            $funcs = array(
                         array("key"=>"refresh","func"=>"StorecardLockSummary","Action"=>"refresh") ,
                         array("key"=>"search","func"=>"StorecardLockSummary","Action"=>"search") ,
                         array("key"=>"export","func"=>"StorecardLockSummary","Action"=>"export") ,
                         array("key"=>"master_view","func"=>"/Home/StorecardLock","Action"=>"view") ,
                         array("key"=>"status","func"=>"/Home/%table%","Action"=>"%action%")
             );
            $this->assign("rights",  $this->GetUserRights($this->user["id"],$funcs ));
        }
        $this->assign("colshow", $this->GetUserColumnDefine($this->user["id"],"StorecardLockSummary"));
    }

    public function index() {
         try {
        $data["pfuncid"] = I("request.pfuncid");
        $data["funcid"] = I("request.funcid");
        $data["zindex"] = I("request.zindex/d");
        if(empty($data["funcid"])) $data["funcid"] = "StorecardLockSummary";
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
          //$this->ajaxResult("存储卡加锁列表后台错误");
          $this->ajaxResult($e->getMessage());
      }
    }


    private function columnsetting_define(){
        return array(
            'org_id'=>'库联',
            'customer_name'=>'客户名称',
            'warehouse_code'=>'仓库编码',
            'storecard_id'=>'存储卡',
            'storecard_no'=>'存储卡号',
            'storecard_type'=>'存储卡类型',
            'package_id'=>'码单',
            'buttress_id'=>'垛号',
            'order_no'=>'加锁号码',
            'order_type'=>'加锁类型',
            'order_date'=>'加锁日期',
            'buyer_id'=>'接收方',
            'buyer_name'=>'接收方',
            'lock_weight'=>'锁重量',
            'lock_qty'=>'锁数量',
            'lock_bulkcargo'=>'锁散件',
            'storelock_weight'=>'合计锁重量',
            'storelock_qty'=>'合计锁数量',
            'storelock_bulkcargo'=>'合计锁散件',
            'store_weight'=>'库存重量',
            'store_qty'=>'库存数量',
            'store_bulkcargo'=>'库存散件',
            'release_user'=>'释放人员',
            'release_time'=>'释放时间',
            'create_time'=>'创建时间',
        );
    }

    private function columnsetting($data){
        $data['user_code']=session(C("USER_AUTH_KEY"));
        $data['summary']='StorecardLockSummary';
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

        $this->ajaxResult("", "",  array("_asr.closeTab","_asr.closePopup", "_asr.openLink","_asr.hideMask()"), array("$('#".$data["funcid"]."-Tab').find('a'), '".$data["funcid"]."'","'".$data["funcid"]."'", "'". U("/Summary/StorecardLockSummary/index?func=search&").  "','".filterFuncId("StorecardLockSummary_Search","id=0")."','存储卡加锁列表', 1",""));


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
       $search["org_id"] = I("request.org_id");
       $search["customer_id_name"] = I("request.customer_id_name");
       $search["customer_id"] = I("request.customer_id");
       $search["customer_name"] = I("request.customer_name");
       $search["warehouse_code_name"] = I("request.warehouse_code_name");
       $search["warehouse_code"] = I("request.warehouse_code");
       $search["storecard_id"] = I("request.storecard_id");
       $search["storecard_no"] = I("request.storecard_no");
       $search["storecard_type"] = I("request.storecard_type");
       $search["package_id"] = I("request.package_id");
       $search["buttress_id"] = I("request.buttress_id");
       $search["order_no"] = I("request.order_no");
       $search["order_type"] = I("request.order_type");
       $search["order_date"] = I("request.order_date");
       $search["order_date2"] = I("request.order_date2");
       $search["buyer_id"] = I("request.buyer_id");
       $search["buyer_name"] = I("request.buyer_name");
       $search["lock_weight"] = I("request.lock_weight");
       $search["lock_weight2"] = I("request.lock_weight2");
       $search["lock_qty"] = I("request.lock_qty");
       $search["lock_qty2"] = I("request.lock_qty2");
       $search["lock_bulkcargo"] = I("request.lock_bulkcargo");
       $search["lock_bulkcargo2"] = I("request.lock_bulkcargo2");
       $search["storelock_weight"] = I("request.storelock_weight");
       $search["storelock_weight2"] = I("request.storelock_weight2");
       $search["storelock_qty"] = I("request.storelock_qty");
       $search["storelock_qty2"] = I("request.storelock_qty2");
       $search["storelock_bulkcargo"] = I("request.storelock_bulkcargo");
       $search["storelock_bulkcargo2"] = I("request.storelock_bulkcargo2");
       $search["store_weight"] = I("request.store_weight");
       $search["store_weight2"] = I("request.store_weight2");
       $search["store_qty"] = I("request.store_qty");
       $search["store_qty2"] = I("request.store_qty2");
       $search["store_bulkcargo"] = I("request.store_bulkcargo");
       $search["store_bulkcargo2"] = I("request.store_bulkcargo2");
       $search["release_user"] = I("request.release_user");
       $search["release_time"] = I("request.release_time");
       $search["release_time2"] = I("request.release_time2");
       $search["create_time"] = I("request.create_time");
       $search["create_time2"] = I("request.create_time2");

       //判断首次装载是否要赋予缺省值
       if($firstloading){
       }



       $condition="";
       $condition_storecard_lock="";
       if($bsearch) {
           //关键字条件
           if($search["_showsearch"]=="hide"  ){
               if($search["_keyword"]){
                   $condition_keyword = "";
                   $condition_keyword = join_condition($condition_keyword,"@storecard_lock.storecard_no",$search["_keyword"],"char", "both" , 0, "" );
                   $condition_storecard_lock = " AND ( ". $condition_keyword .")";
               }
           }else{
               //高级搜索condition
               $condition_storecard_lock = join_condition($condition_storecard_lock,"@storecard_lock.org_id",$search["org_id"],"int");
               $condition_storecard_lock = join_condition($condition_storecard_lock,"@storecard_lock.customer_id",$search["customer_id"],"int");
               $condition_storecard_lock = join_condition($condition_storecard_lock,"@storecard_lock.customer_name",$search["customer_name"],"char","both");
               $condition_storecard_lock = join_condition($condition_storecard_lock,"@storecard_lock.warehouse_code",$search["warehouse_code"],"char");
               $condition_storecard_lock = join_condition($condition_storecard_lock,"@storecard_lock.storecard_id",$search["storecard_id"],"int");
               $condition_storecard_lock = join_condition($condition_storecard_lock,"@storecard_lock.storecard_no",$search["storecard_no"],"char");
               $condition_storecard_lock = join_condition($condition_storecard_lock,"@storecard_lock.storecard_type",$search["storecard_type"],"int");
               $condition_storecard_lock = join_condition($condition_storecard_lock,"@storecard_lock.package_id",$search["package_id"],"int");
               $condition_storecard_lock = join_condition($condition_storecard_lock,"@storecard_lock.buttress_id",$search["buttress_id"],"int");
               $condition_storecard_lock = join_condition($condition_storecard_lock,"@storecard_lock.order_no",$search["order_no"],"char");
               $condition_storecard_lock = join_condition($condition_storecard_lock,"@storecard_lock.order_type",$search["order_type"],"char");
               $condition_storecard_lock = join_condition2($condition_storecard_lock,"@storecard_lock.order_date",$search["order_date"],$search["order_date2"],"date");
               $condition_storecard_lock = join_condition($condition_storecard_lock,"@storecard_lock.buyer_id",$search["buyer_id"],"int");
               $condition_storecard_lock = join_condition($condition_storecard_lock,"@storecard_lock.buyer_name",$search["buyer_name"],"char","both");
               $condition_storecard_lock = join_condition2($condition_storecard_lock,"@storecard_lock.lock_weight",$search["lock_weight"],$search["lock_weight2"],"decimal");
               $condition_storecard_lock = join_condition2($condition_storecard_lock,"@storecard_lock.lock_qty",$search["lock_qty"],$search["lock_qty2"],"decimal");
               $condition_storecard_lock = join_condition2($condition_storecard_lock,"@storecard_lock.lock_bulkcargo",$search["lock_bulkcargo"],$search["lock_bulkcargo2"],"decimal");
               $condition_storecard_lock = join_condition2($condition_storecard_lock,"@storecard_lock.storelock_weight",$search["storelock_weight"],$search["storelock_weight2"],"decimal");
               $condition_storecard_lock = join_condition2($condition_storecard_lock,"@storecard_lock.storelock_qty",$search["storelock_qty"],$search["storelock_qty2"],"decimal");
               $condition_storecard_lock = join_condition2($condition_storecard_lock,"@storecard_lock.storelock_bulkcargo",$search["storelock_bulkcargo"],$search["storelock_bulkcargo2"],"decimal");
               $condition_storecard_lock = join_condition2($condition_storecard_lock,"@storecard_lock.store_weight",$search["store_weight"],$search["store_weight2"],"decimal");
               $condition_storecard_lock = join_condition2($condition_storecard_lock,"@storecard_lock.store_qty",$search["store_qty"],$search["store_qty2"],"decimal");
               $condition_storecard_lock = join_condition2($condition_storecard_lock,"@storecard_lock.store_bulkcargo",$search["store_bulkcargo"],$search["store_bulkcargo2"],"decimal");
               $condition_storecard_lock = join_condition($condition_storecard_lock,"@storecard_lock.release_user",$search["release_user"],"char");
               $condition_storecard_lock = join_condition2($condition_storecard_lock,"@storecard_lock.release_time",$search["release_time"],$search["release_time2"],"datetime");
               $condition_storecard_lock = join_condition2($condition_storecard_lock,"@storecard_lock.create_time",$search["create_time"],$search["create_time2"],"datetime");
           }

           //增加 tab 条件
           $condition_storecard_lock = $this->tabsheet_condition($condition_storecard_lock ,$search["_tab"]);
           //增加数据权限
       $auth_condition=$this->get_auth_condition();
       $condition_storecard_lock = join_condition_auth($condition_storecard_lock,$auth_condition,"");
           //select fields
           $selectfields=" @storecard_lock.id ";
           $selectfields.=", @storecard_lock.org_id ";
           $selectfields.=", @storecard_lock.customer_name ";
           $selectfields.=", @storecard_lock.warehouse_code ";
           $selectfields.=", @storecard_lock.storecard_id ";
           $selectfields.=", @storecard_lock.storecard_no ";
           $selectfields.=", @storecard_lock.storecard_type ";
           $selectfields.=", @storecard_lock.package_id ";
           $selectfields.=", @storecard_lock.buttress_id ";
           $selectfields.=", @storecard_lock.order_no ";
           $selectfields.=", @storecard_lock.order_type ";
           $selectfields.=", @storecard_lock.order_date ";
           $selectfields.=", @storecard_lock.buyer_id ";
           $selectfields.=", @storecard_lock.buyer_name ";
           $selectfields.=", @storecard_lock.lock_weight ";
           $selectfields.=", @storecard_lock.lock_qty ";
           $selectfields.=", @storecard_lock.lock_bulkcargo ";
           $selectfields.=", @storecard_lock.storelock_weight ";
           $selectfields.=", @storecard_lock.storelock_qty ";
           $selectfields.=", @storecard_lock.storelock_bulkcargo ";
           $selectfields.=", @storecard_lock.store_weight ";
           $selectfields.=", @storecard_lock.store_qty ";
           $selectfields.=", @storecard_lock.store_bulkcargo ";
           $selectfields.=", @storecard_lock.release_user ";
           $selectfields.=", @storecard_lock.release_time ";
           $selectfields.=", @storecard_lock.create_time ";


           $page_size = I("request.pagesize/d");
           if ($page_size<=0){
               $page_size = session("StorecardLockSummary-PageSize");
               if (!$page_size) {
                    $page_size = 10;
               }
           }
           session("StorecardLockSummary-PageSize", $page_size);


           $join="";
           $count_sql = "select count(*) as cnt from @storecard_lock  #join#  where 1=1 #condition#";  // ' for skip replace $condition
           $count_sql = str_replace("#join#",$join,$count_sql);
           $count_sql = str_replace("#condition#",$condition_storecard_lock,$count_sql);
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
           $sql = "select #selectfields# from @storecard_lock  #join# Where 1=1 #condition# #orderby#";
           $sql = str_replace("#selectfields#",$selectfields,$sql);
           $sql = str_replace("#join#",$join,$sql);
           $sql = str_replace("#condition#",$condition_storecard_lock,$sql);
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
        $html = $this->fetch("StorecardLockSummary:index");
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

        if(empty($data["funcid"])) $data["funcid"] = "StorecardLockSummary";
        if(!$p){
           $p = 1;
           $export_all = 1;
        }

        $show_list = array();

        $data['summary']='StorecardLockSummary';
        $usc = M('user_summary_column')->field("column")->where("user_code='%s' AND summary='%s' AND `show`='1'",array(session(C("USER_AUTH_KEY")),$data['summary']))->select();
        if($usc){
           foreach ($usc as $v) {
              $show_list[$v['column']]=1;
           }
        }

        $search["_tab"] = $this->tabsheet_check(I("request._tab"));
        $tab = $search["_tab"];

        $search["org_id"] = I("request.org_id");
        $search["customer_id_name"] = I("request.customer_id_name");
        $search["customer_id"] = I("request.customer_id");
        $search["customer_name"] = I("request.customer_name");
        $search["warehouse_code_name"] = I("request.warehouse_code_name");
        $search["warehouse_code"] = I("request.warehouse_code");
        $search["storecard_id"] = I("request.storecard_id");
        $search["storecard_no"] = I("request.storecard_no");
        $search["storecard_type"] = I("request.storecard_type");
        $search["package_id"] = I("request.package_id");
        $search["buttress_id"] = I("request.buttress_id");
        $search["order_no"] = I("request.order_no");
        $search["order_type"] = I("request.order_type");
        $search["order_date"] = I("request.order_date");
        $search["order_date2"] = I("request.order_date2");
        $search["buyer_id"] = I("request.buyer_id");
        $search["buyer_name"] = I("request.buyer_name");
        $search["lock_weight"] = I("request.lock_weight");
        $search["lock_weight2"] = I("request.lock_weight2");
        $search["lock_qty"] = I("request.lock_qty");
        $search["lock_qty2"] = I("request.lock_qty2");
        $search["lock_bulkcargo"] = I("request.lock_bulkcargo");
        $search["lock_bulkcargo2"] = I("request.lock_bulkcargo2");
        $search["storelock_weight"] = I("request.storelock_weight");
        $search["storelock_weight2"] = I("request.storelock_weight2");
        $search["storelock_qty"] = I("request.storelock_qty");
        $search["storelock_qty2"] = I("request.storelock_qty2");
        $search["storelock_bulkcargo"] = I("request.storelock_bulkcargo");
        $search["storelock_bulkcargo2"] = I("request.storelock_bulkcargo2");
        $search["store_weight"] = I("request.store_weight");
        $search["store_weight2"] = I("request.store_weight2");
        $search["store_qty"] = I("request.store_qty");
        $search["store_qty2"] = I("request.store_qty2");
        $search["store_bulkcargo"] = I("request.store_bulkcargo");
        $search["store_bulkcargo2"] = I("request.store_bulkcargo2");
        $search["release_user"] = I("request.release_user");
        $search["release_time"] = I("request.release_time");
        $search["release_time2"] = I("request.release_time2");
        $search["create_time"] = I("request.create_time");
        $search["create_time2"] = I("request.create_time2");


        //condition
        $condition="";
        $condition_storecard_lock="";

        //读取关键字搜索内容
        $search["_keyword"] = I("request._keyword");
        if($search["_showsearch"]=="hide"  ){
            if($search["_keyword"]){
                $condition_keyword = "";
                $condition_keyword = join_condition($condition_keyword,"@storecard_lock.storecard_no",$search["_keyword"],"char", "both" , 0, "" );
                $condition_storecard_lock = " AND ( ". $condition_keyword . ")";
            }
        }else{
        //高级搜索condition

           $search_auth_codes = $search["org_id"];
           $condition_storecard_lock = join_condition($condition_storecard_lock,"@storecard_lock.customer_id",$search["customer_id"],"int");
           $condition_storecard_lock = join_condition($condition_storecard_lock,"@storecard_lock.customer_name",$search["customer_name"],"char","both");
           $condition_storecard_lock = join_condition($condition_storecard_lock,"@storecard_lock.warehouse_code",$search["warehouse_code"],"char");
           $condition_storecard_lock = join_condition($condition_storecard_lock,"@storecard_lock.storecard_id",$search["storecard_id"],"int");
           $condition_storecard_lock = join_condition($condition_storecard_lock,"@storecard_lock.storecard_no",$search["storecard_no"],"char");
           $condition_storecard_lock = join_condition($condition_storecard_lock,"@storecard_lock.storecard_type",$search["storecard_type"],"int");
           $condition_storecard_lock = join_condition($condition_storecard_lock,"@storecard_lock.package_id",$search["package_id"],"int");
           $condition_storecard_lock = join_condition($condition_storecard_lock,"@storecard_lock.buttress_id",$search["buttress_id"],"int");
           $condition_storecard_lock = join_condition($condition_storecard_lock,"@storecard_lock.order_no",$search["order_no"],"char");
           $condition_storecard_lock = join_condition($condition_storecard_lock,"@storecard_lock.order_type",$search["order_type"],"char");
           $condition_storecard_lock = join_condition2($condition_storecard_lock,"@storecard_lock.order_date",$search["order_date"],$search["order_date2"],"date");
           $condition_storecard_lock = join_condition($condition_storecard_lock,"@storecard_lock.buyer_id",$search["buyer_id"],"int");
           $condition_storecard_lock = join_condition($condition_storecard_lock,"@storecard_lock.buyer_name",$search["buyer_name"],"char","both");
           $condition_storecard_lock = join_condition2($condition_storecard_lock,"@storecard_lock.lock_weight",$search["lock_weight"],$search["lock_weight2"],"decimal");
           $condition_storecard_lock = join_condition2($condition_storecard_lock,"@storecard_lock.lock_qty",$search["lock_qty"],$search["lock_qty2"],"decimal");
           $condition_storecard_lock = join_condition2($condition_storecard_lock,"@storecard_lock.lock_bulkcargo",$search["lock_bulkcargo"],$search["lock_bulkcargo2"],"decimal");
           $condition_storecard_lock = join_condition2($condition_storecard_lock,"@storecard_lock.storelock_weight",$search["storelock_weight"],$search["storelock_weight2"],"decimal");
           $condition_storecard_lock = join_condition2($condition_storecard_lock,"@storecard_lock.storelock_qty",$search["storelock_qty"],$search["storelock_qty2"],"decimal");
           $condition_storecard_lock = join_condition2($condition_storecard_lock,"@storecard_lock.storelock_bulkcargo",$search["storelock_bulkcargo"],$search["storelock_bulkcargo2"],"decimal");
           $condition_storecard_lock = join_condition2($condition_storecard_lock,"@storecard_lock.store_weight",$search["store_weight"],$search["store_weight2"],"decimal");
           $condition_storecard_lock = join_condition2($condition_storecard_lock,"@storecard_lock.store_qty",$search["store_qty"],$search["store_qty2"],"decimal");
           $condition_storecard_lock = join_condition2($condition_storecard_lock,"@storecard_lock.store_bulkcargo",$search["store_bulkcargo"],$search["store_bulkcargo2"],"decimal");
           $condition_storecard_lock = join_condition($condition_storecard_lock,"@storecard_lock.release_user",$search["release_user"],"char");
           $condition_storecard_lock = join_condition2($condition_storecard_lock,"@storecard_lock.release_time",$search["release_time"],$search["release_time2"],"datetime");
           $condition_storecard_lock = join_condition2($condition_storecard_lock,"@storecard_lock.create_time",$search["create_time"],$search["create_time2"],"datetime");
        }
        $condition_storecard_lock = $this->tabsheet_condition($condition_storecard_lock ,$search["_tab"]);
          $condition_storecard_lock = join_condition_shop($condition_storecard_lock,"2;@storecard_lock.org_id;org_id#3;@storecard_lock.customer_id;customer_id",$this->user_shop_id,$search_auth_codes);

        //select fields
        $selectfields="@storecard_lock.id ";
        $selectfields.=",@storecard_lock.org_id ";
        $selectfields.=",@storecard_lock.customer_name ";
        $selectfields.=",@storecard_lock.warehouse_code ";
        $selectfields.=",@storecard_lock.storecard_id ";
        $selectfields.=",@storecard_lock.storecard_no ";
        $selectfields.=",@storecard_lock.storecard_type ";
        $selectfields.=",@storecard_lock.package_id ";
        $selectfields.=",@storecard_lock.buttress_id ";
        $selectfields.=",@storecard_lock.order_no ";
        $selectfields.=",@storecard_lock.order_type ";
        $selectfields.=",@storecard_lock.order_date ";
        $selectfields.=",@storecard_lock.buyer_id ";
        $selectfields.=",@storecard_lock.buyer_name ";
        $selectfields.=",@storecard_lock.lock_weight ";
        $selectfields.=",@storecard_lock.lock_qty ";
        $selectfields.=",@storecard_lock.lock_bulkcargo ";
        $selectfields.=",@storecard_lock.storelock_weight ";
        $selectfields.=",@storecard_lock.storelock_qty ";
        $selectfields.=",@storecard_lock.storelock_bulkcargo ";
        $selectfields.=",@storecard_lock.store_weight ";
        $selectfields.=",@storecard_lock.store_qty ";
        $selectfields.=",@storecard_lock.store_bulkcargo ";
        $selectfields.=",@storecard_lock.release_user ";
        $selectfields.=",@storecard_lock.release_time ";
        $selectfields.=",@storecard_lock.create_time ";


        $str_header = "";
        if ($show_list['org_id']==1 || empty($show_list)){
            $str_header .= "库联,";
        }
        if ($show_list['customer_name']==1 || empty($show_list)){
            $str_header .= "客户名称,";
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
        if ($show_list['storecard_type']==1 || empty($show_list)){
            $str_header .= "存储卡类型,";
        }
        if ($show_list['package_id']==1 || empty($show_list)){
            $str_header .= "码单,";
        }
        if ($show_list['buttress_id']==1 || empty($show_list)){
            $str_header .= "垛号,";
        }
        if ($show_list['order_no']==1 || empty($show_list)){
            $str_header .= "加锁号码,";
        }
        if ($show_list['order_type']==1 || empty($show_list)){
            $str_header .= "加锁类型,";
        }
        if ($show_list['order_date']==1 || empty($show_list)){
            $str_header .= "加锁日期,";
        }
        if ($show_list['buyer_id']==1 || empty($show_list)){
            $str_header .= "接收方,";
        }
        if ($show_list['buyer_name']==1 || empty($show_list)){
            $str_header .= "接收方,";
        }
        if ($show_list['lock_weight']==1 || empty($show_list)){
            $str_header .= "锁重量,";
        }
        if ($show_list['lock_qty']==1 || empty($show_list)){
            $str_header .= "锁数量,";
        }
        if ($show_list['lock_bulkcargo']==1 || empty($show_list)){
            $str_header .= "锁散件,";
        }
        if ($show_list['storelock_weight']==1 || empty($show_list)){
            $str_header .= "合计锁重量,";
        }
        if ($show_list['storelock_qty']==1 || empty($show_list)){
            $str_header .= "合计锁数量,";
        }
        if ($show_list['storelock_bulkcargo']==1 || empty($show_list)){
            $str_header .= "合计锁散件,";
        }
        if ($show_list['store_weight']==1 || empty($show_list)){
            $str_header .= "库存重量,";
        }
        if ($show_list['store_qty']==1 || empty($show_list)){
            $str_header .= "库存数量,";
        }
        if ($show_list['store_bulkcargo']==1 || empty($show_list)){
            $str_header .= "库存散件,";
        }
        if ($show_list['release_user']==1 || empty($show_list)){
            $str_header .= "释放人员,";
        }
        if ($show_list['release_time']==1 || empty($show_list)){
            $str_header .= "释放时间,";
        }
        if ($show_list['create_time']==1 || empty($show_list)){
            $str_header .= "创建时间,";
        }
        $str_header .= "\r\n";

        $join="";

       $count_sql = "select count(*) as cnt from @storecard_lock  #join#  where 1=1 #condition#";  // ' for skip replace $condition
       $count_sql = str_replace("#join#",$join,$count_sql);
       $count_sql = str_replace("#condition#",$condition_storecard_lock,$count_sql);

       $count_sql = table($count_sql);
       $count_sql = str_replace("·mailchar·","@",$count_sql);
       $count = M()->query($count_sql);
       $count = $count[0]["cnt"];

           $total_page=0;

        if(!$export_all) {
           $page_size = I("request.pagesize/d");
           $page_size = $page_size <= 0 ? session("StorecardLockSummary-PageSize") : $page_size;
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

        $sql = "select #selectfields# from @storecard_lock  #join# Where 1=1 #condition# #orderby#";   // ' for skip replace $selectfields,$condition,$orderby
        $sql = str_replace("#selectfields#",$selectfields,$sql);
        $sql = str_replace("#join#",$join,$sql);
        $sql = str_replace("#condition#",$condition_storecard_lock,$sql);
        $sql = str_replace("#orderby#",$orderby,$sql);
        $sql .= " LIMIT ". (($p - 1) * $page_size). ", ".$page_size;

        $sql = table($sql);
        $sql = str_replace("·mailchar·","@",$sql);
        $list = M()->query($sql);

        foreach($list as $master) {
            $str_line="";
            if ($show_list['org_id']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Org_byID("$master[org_id]","name"))."\t,";
            }
            if ($show_list['customer_name']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["customer_name"])."\t,";
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
            if ($show_list['storecard_type']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_StorecardLock_storecard_type("$master[storecard_type]","name"))."\t,";
            }
            if ($show_list['package_id']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["package_id"])."\t,";
            }
            if ($show_list['buttress_id']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["buttress_id"])."\t,";
            }
            if ($show_list['order_no']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["order_no"])."\t,";
            }
            if ($show_list['order_type']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["order_type"])."\t,";
            }
            if ($show_list['order_date']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("D", $master["order_date"]))."\t,";
            }
            if ($show_list['buyer_id']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["buyer_id"])."\t,";
            }
            if ($show_list['buyer_name']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["buyer_name"])."\t,";
            }
            if ($show_list['lock_weight']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("F33", $master["lock_weight"]))."\t,";
            }
            if ($show_list['lock_qty']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("N3", $master["lock_qty"]))."\t,";
            }
            if ($show_list['lock_bulkcargo']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("N3", $master["lock_bulkcargo"]))."\t,";
            }
            if ($show_list['storelock_weight']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("F33", $master["storelock_weight"]))."\t,";
            }
            if ($show_list['storelock_qty']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("N3", $master["storelock_qty"]))."\t,";
            }
            if ($show_list['storelock_bulkcargo']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("N3", $master["storelock_bulkcargo"]))."\t,";
            }
            if ($show_list['store_weight']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("F33", $master["store_weight"]))."\t,";
            }
            if ($show_list['store_qty']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("N3", $master["store_qty"]))."\t,";
            }
            if ($show_list['store_bulkcargo']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("N3", $master["store_bulkcargo"]))."\t,";
            }
            if ($show_list['release_user']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["release_user"])."\t,";
            }
            if ($show_list['release_time']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("DT", $master["release_time"]))."\t,";
            }
            if ($show_list['create_time']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("DT", $master["create_time"]))."\t,";
            }
            $str_content .= $str_line . "\r\n";
        }
    }
        header('Content-Type: text/xls');
        header ("Content-type:application/vnd.ms-excel;charset=gbk" );
        $str = mb_convert_encoding("StorecardLockSummary", 'gbk', 'utf-8');
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
            $condition.=" @storecard_lock.org_id='".$this->user["org_id"]."' ";
            break;
        case "3":
            $condition.=" @storecard_lock.customer_id='".$this->user["customer_id"]."' ";
            break;
        }
        return $condition ;
    }
}
