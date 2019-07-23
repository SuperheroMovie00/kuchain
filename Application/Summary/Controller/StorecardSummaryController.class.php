<?php namespace Summary\Controller;
//
//注释: StorecardSummary - 存储卡列表
//
use Home\Controller\BasicController;
use Think\Log;
class StorecardSummaryController extends BasicController {

    public function _init() {
        $funcs = $this->getUserRoleList($this->user,array( '/Home/Storecard', 'StorecardSummary', ));
        if ($funcs)
            $this->assign("rights",  $funcs);
        else{
            $funcs = array(
                         array("key"=>"import","func"=>"/Home/Storecard","Action"=>"import") ,
                         array("key"=>"refresh","func"=>"StorecardSummary","Action"=>"refresh") ,
                         array("key"=>"search","func"=>"StorecardSummary","Action"=>"search") ,
                         array("key"=>"export","func"=>"StorecardSummary","Action"=>"export") ,
                         array("key"=>"master_view","func"=>"/Home/Storecard","Action"=>"view") ,
                         array("key"=>"status_on","func"=>"/Home/Storecard","Action"=>"status_on") ,
                         array("key"=>"status_off","func"=>"/Home/Storecard","Action"=>"status_off")
             );
            $this->assign("rights",  $this->GetUserRights($this->user["id"],$funcs ));
        }
        $this->assign("colshow", $this->GetUserColumnDefine($this->user["id"],"StorecardSummary"));
    }

    public function index() {
         try {
        $data["pfuncid"] = I("request.pfuncid");
        $data["funcid"] = I("request.funcid");
        $data["zindex"] = I("request.zindex/d");
        if(empty($data["funcid"])) $data["funcid"] = "StorecardSummary";
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
          //$this->ajaxResult("存储卡列表后台错误");
          $this->ajaxResult($e->getMessage());
      }
    }


    private function columnsetting_define(){
        return array(
            'status'=>'状态',
            'org_id'=>'库联',
            'storecard_no'=>'存储卡号',
            'warehouse_code'=>'仓库编码',
            'customer_name'=>'客户名称',
            'goods_no'=>'货品编码',
            'goods_name'=>'货品名称',
            'style_info'=>'规格',
            'materials'=>'材质',
            'brand'=>'商标',
            'producing_area'=>'产地',
            'style_code'=>'货品基础码',
            'orig_weight'=>'初始重量',
            'weight'=>'重量',
            'qty'=>'数量',
            'bulkcargo'=>'散件',
            'lock_weight'=>'锁重量',
            'lock_qty'=>'锁数量',
            'lock_bulkcargo'=>'锁散件',
            'uom_qty'=>'数量单位',
            'uom_weight'=>'重量单位',
            'uom_bulkcargo'=>'散件单位',
            'contact_id'=>'合同',
            'contact_no'=>'仓储合同',
            'stockin_date'=>'入库日期',
            'fee_customer_id'=>'仓费支付方',
            'fee_customer_name'=>'仓费支付方',
            'fee_start'=>'仓费起始日',
            'create_time'=>'创建时间',
        );
    }

    private function columnsetting($data){
        $data['user_code']=session(C("USER_AUTH_KEY"));
        $data['summary']='StorecardSummary';
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

        $this->ajaxResult("", "",  array("_asr.closeTab","_asr.closePopup", "_asr.openLink","_asr.hideMask()"), array("$('#".$data["funcid"]."-Tab').find('a'), '".$data["funcid"]."'","'".$data["funcid"]."'", "'". U("/Summary/StorecardSummary/index?func=search&").  "','".filterFuncId("StorecardSummary_Search","id=0")."','存储卡列表', 1",""));


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
       $search["storecard_no"] = I("request.storecard_no");
       $search["warehouse_code_name"] = I("request.warehouse_code_name");
       $search["warehouse_code"] = I("request.warehouse_code");
       $search["customer_name"] = I("request.customer_name");
       $search["goods_no"] = I("request.goods_no");
       $search["goods_name"] = I("request.goods_name");
       $search["style_info"] = I("request.style_info");
       $search["materials"] = I("request.materials");
       $search["brand"] = I("request.brand");
       $search["producing_area"] = I("request.producing_area");
       $search["style_code"] = I("request.style_code");
       $search["orig_weight"] = I("request.orig_weight");
       $search["orig_weight2"] = I("request.orig_weight2");
       $search["weight"] = I("request.weight");
       $search["weight2"] = I("request.weight2");
       $search["qty"] = I("request.qty");
       $search["qty2"] = I("request.qty2");
       $search["bulkcargo"] = I("request.bulkcargo");
       $search["bulkcargo2"] = I("request.bulkcargo2");
       $search["lock_weight"] = I("request.lock_weight");
       $search["lock_weight2"] = I("request.lock_weight2");
       $search["lock_qty"] = I("request.lock_qty");
       $search["lock_qty2"] = I("request.lock_qty2");
       $search["lock_bulkcargo"] = I("request.lock_bulkcargo");
       $search["lock_bulkcargo2"] = I("request.lock_bulkcargo2");
       $search["uom_qty"] = I("request.uom_qty");
       $search["uom_weight"] = I("request.uom_weight");
       $search["uom_bulkcargo"] = I("request.uom_bulkcargo");
       $search["contact_id"] = I("request.contact_id");
       $search["contact_no"] = I("request.contact_no");
       $search["stockin_date"] = I("request.stockin_date");
       $search["stockin_date2"] = I("request.stockin_date2");
       $search["fee_customer_id"] = I("request.fee_customer_id");
       $search["fee_customer_name"] = I("request.fee_customer_name");
       $search["fee_start"] = I("request.fee_start");
       $search["fee_start2"] = I("request.fee_start2");
       $search["create_time"] = I("request.create_time");
       $search["create_time2"] = I("request.create_time2");

       //判断首次装载是否要赋予缺省值
       if($firstloading){
       }



       $condition="";
       $condition_storecard="";
       if($bsearch) {
           //关键字条件
           if($search["_showsearch"]=="hide"  ){
               if($search["_keyword"]){
                   $condition_keyword = "";
                   $condition_keyword = join_condition($condition_keyword,"@storecard.storecard_no",$search["_keyword"],"char", "both" , 0, "" );
                   $condition_storecard = " AND ( ". $condition_keyword .")";
               }
           }else{
               //高级搜索condition
               $condition_storecard = join_condition($condition_storecard,"@storecard.status",$search["status"],"int");
               $condition_storecard = join_condition($condition_storecard,"@storecard.org_id",$search["org_id"],"int");
               $condition_storecard = join_condition($condition_storecard,"@storecard.customer_id",$search["customer_id"],"int");
               $condition_storecard = join_condition($condition_storecard,"@storecard.storecard_no",$search["storecard_no"],"char");
               $condition_storecard = join_condition($condition_storecard,"@storecard.warehouse_code",$search["warehouse_code"],"char");
               $condition_storecard = join_condition($condition_storecard,"@storecard.customer_name",$search["customer_name"],"char","both");
               $condition_storecard = join_condition($condition_storecard,"@storecard.goods_no",$search["goods_no"],"char");
               $condition_storecard = join_condition($condition_storecard,"@storecard.goods_name",$search["goods_name"],"char","both");
               $condition_storecard = join_condition($condition_storecard,"@storecard.style_info",$search["style_info"],"char","both");
               $condition_storecard = join_condition($condition_storecard,"@storecard.materials",$search["materials"],"char");
               $condition_storecard = join_condition($condition_storecard,"@storecard.brand",$search["brand"],"char");
               $condition_storecard = join_condition($condition_storecard,"@storecard.producing_area",$search["producing_area"],"char");
               $condition_storecard = join_condition($condition_storecard,"@storecard.style_code",$search["style_code"],"char");
               $condition_storecard = join_condition2($condition_storecard,"@storecard.orig_weight",$search["orig_weight"],$search["orig_weight2"],"decimal");
               $condition_storecard = join_condition2($condition_storecard,"@storecard.weight",$search["weight"],$search["weight2"],"decimal");
               $condition_storecard = join_condition2($condition_storecard,"@storecard.qty",$search["qty"],$search["qty2"],"decimal");
               $condition_storecard = join_condition2($condition_storecard,"@storecard.bulkcargo",$search["bulkcargo"],$search["bulkcargo2"],"decimal");
               $condition_storecard = join_condition2($condition_storecard,"@storecard.lock_weight",$search["lock_weight"],$search["lock_weight2"],"decimal");
               $condition_storecard = join_condition2($condition_storecard,"@storecard.lock_qty",$search["lock_qty"],$search["lock_qty2"],"decimal");
               $condition_storecard = join_condition2($condition_storecard,"@storecard.lock_bulkcargo",$search["lock_bulkcargo"],$search["lock_bulkcargo2"],"decimal");
               $condition_storecard = join_condition($condition_storecard,"@storecard.uom_qty",$search["uom_qty"],"char");
               $condition_storecard = join_condition($condition_storecard,"@storecard.uom_weight",$search["uom_weight"],"char");
               $condition_storecard = join_condition($condition_storecard,"@storecard.uom_bulkcargo",$search["uom_bulkcargo"],"char");
               $condition_storecard = join_condition($condition_storecard,"@storecard.contact_id",$search["contact_id"],"int");
               $condition_storecard = join_condition($condition_storecard,"@storecard.contact_no",$search["contact_no"],"char");
               $condition_storecard = join_condition2($condition_storecard,"@storecard.stockin_date",$search["stockin_date"],$search["stockin_date2"],"date");
               $condition_storecard = join_condition($condition_storecard,"@storecard.fee_customer_id",$search["fee_customer_id"],"int");
               $condition_storecard = join_condition($condition_storecard,"@storecard.fee_customer_name",$search["fee_customer_name"],"char","both");
               $condition_storecard = join_condition2($condition_storecard,"@storecard.fee_start",$search["fee_start"],$search["fee_start2"],"datetime");
               $condition_storecard = join_condition2($condition_storecard,"@storecard.create_time",$search["create_time"],$search["create_time2"],"datetime");
           }

           //增加 tab 条件
           $condition_storecard = $this->tabsheet_condition($condition_storecard ,$search["_tab"]);
           //增加数据权限
       $auth_condition=$this->get_auth_condition();
       $condition_storecard = join_condition_auth($condition_storecard,$auth_condition,"");
           //select fields
           $selectfields=" @storecard.status ";
           $selectfields.=", @storecard.id ";
           $selectfields.=", @storecard.org_id ";
           $selectfields.=", @storecard.storecard_no ";
           $selectfields.=", @storecard.warehouse_code ";
           $selectfields.=", @storecard.customer_name ";
           $selectfields.=", @storecard.goods_no ";
           $selectfields.=", @storecard.goods_name ";
           $selectfields.=", @storecard.style_info ";
           $selectfields.=", @storecard.materials ";
           $selectfields.=", @storecard.brand ";
           $selectfields.=", @storecard.producing_area ";
           $selectfields.=", @storecard.style_code ";
           $selectfields.=", @storecard.orig_weight ";
           $selectfields.=", @storecard.weight ";
           $selectfields.=", @storecard.qty ";
           $selectfields.=", @storecard.bulkcargo ";
           $selectfields.=", @storecard.lock_weight ";
           $selectfields.=", @storecard.lock_qty ";
           $selectfields.=", @storecard.lock_bulkcargo ";
           $selectfields.=", @storecard.uom_qty ";
           $selectfields.=", @storecard.uom_weight ";
           $selectfields.=", @storecard.uom_bulkcargo ";
           $selectfields.=", @storecard.contact_id ";
           $selectfields.=", @storecard.contact_no ";
           $selectfields.=", @storecard.stockin_date ";
           $selectfields.=", @storecard.fee_customer_id ";
           $selectfields.=", @storecard.fee_customer_name ";
           $selectfields.=", @storecard.fee_start ";
           $selectfields.=", @storecard.create_time ";


           $page_size = I("request.pagesize/d");
           if ($page_size<=0){
               $page_size = session("StorecardSummary-PageSize");
               if (!$page_size) {
                    $page_size = 10;
               }
           }
           session("StorecardSummary-PageSize", $page_size);


           $join="";
           $count_sql = "select count(*) as cnt from @storecard  #join#  where 1=1 #condition#";  // ' for skip replace $condition
           $count_sql = str_replace("#join#",$join,$count_sql);
           $count_sql = str_replace("#condition#",$condition_storecard,$count_sql);
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
           $sql = "select #selectfields# from @storecard  #join# Where 1=1 #condition# #orderby#";
           $sql = str_replace("#selectfields#",$selectfields,$sql);
           $sql = str_replace("#join#",$join,$sql);
           $sql = str_replace("#condition#",$condition_storecard,$sql);
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
        $html = $this->fetch("StorecardSummary:index");
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

        if(empty($data["funcid"])) $data["funcid"] = "StorecardSummary";
        if(!$p){
           $p = 1;
           $export_all = 1;
        }

        $show_list = array();

        $data['summary']='StorecardSummary';
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
        $search["storecard_no"] = I("request.storecard_no");
        $search["warehouse_code_name"] = I("request.warehouse_code_name");
        $search["warehouse_code"] = I("request.warehouse_code");
        $search["customer_name"] = I("request.customer_name");
        $search["goods_no"] = I("request.goods_no");
        $search["goods_name"] = I("request.goods_name");
        $search["style_info"] = I("request.style_info");
        $search["materials"] = I("request.materials");
        $search["brand"] = I("request.brand");
        $search["producing_area"] = I("request.producing_area");
        $search["style_code"] = I("request.style_code");
        $search["orig_weight"] = I("request.orig_weight");
        $search["orig_weight2"] = I("request.orig_weight2");
        $search["weight"] = I("request.weight");
        $search["weight2"] = I("request.weight2");
        $search["qty"] = I("request.qty");
        $search["qty2"] = I("request.qty2");
        $search["bulkcargo"] = I("request.bulkcargo");
        $search["bulkcargo2"] = I("request.bulkcargo2");
        $search["lock_weight"] = I("request.lock_weight");
        $search["lock_weight2"] = I("request.lock_weight2");
        $search["lock_qty"] = I("request.lock_qty");
        $search["lock_qty2"] = I("request.lock_qty2");
        $search["lock_bulkcargo"] = I("request.lock_bulkcargo");
        $search["lock_bulkcargo2"] = I("request.lock_bulkcargo2");
        $search["uom_qty"] = I("request.uom_qty");
        $search["uom_weight"] = I("request.uom_weight");
        $search["uom_bulkcargo"] = I("request.uom_bulkcargo");
        $search["contact_id"] = I("request.contact_id");
        $search["contact_no"] = I("request.contact_no");
        $search["stockin_date"] = I("request.stockin_date");
        $search["stockin_date2"] = I("request.stockin_date2");
        $search["fee_customer_id"] = I("request.fee_customer_id");
        $search["fee_customer_name"] = I("request.fee_customer_name");
        $search["fee_start"] = I("request.fee_start");
        $search["fee_start2"] = I("request.fee_start2");
        $search["create_time"] = I("request.create_time");
        $search["create_time2"] = I("request.create_time2");


        //condition
        $condition="";
        $condition_storecard="";

        //读取关键字搜索内容
        $search["_keyword"] = I("request._keyword");
        if($search["_showsearch"]=="hide"  ){
            if($search["_keyword"]){
                $condition_keyword = "";
                $condition_keyword = join_condition($condition_keyword,"@storecard.storecard_no",$search["_keyword"],"char", "both" , 0, "" );
                $condition_storecard = " AND ( ". $condition_keyword . ")";
            }
        }else{
        //高级搜索condition
           $condition_storecard = join_condition($condition_storecard,"@storecard.status",$search["status"],"int");

           $search_auth_codes = $search["org_id"];
           $condition_storecard = join_condition($condition_storecard,"@storecard.customer_id",$search["customer_id"],"int");
           $condition_storecard = join_condition($condition_storecard,"@storecard.storecard_no",$search["storecard_no"],"char");
           $condition_storecard = join_condition($condition_storecard,"@storecard.warehouse_code",$search["warehouse_code"],"char");
           $condition_storecard = join_condition($condition_storecard,"@storecard.customer_name",$search["customer_name"],"char","both");
           $condition_storecard = join_condition($condition_storecard,"@storecard.goods_no",$search["goods_no"],"char");
           $condition_storecard = join_condition($condition_storecard,"@storecard.goods_name",$search["goods_name"],"char","both");
           $condition_storecard = join_condition($condition_storecard,"@storecard.style_info",$search["style_info"],"char","both");
           $condition_storecard = join_condition($condition_storecard,"@storecard.materials",$search["materials"],"char");
           $condition_storecard = join_condition($condition_storecard,"@storecard.brand",$search["brand"],"char");
           $condition_storecard = join_condition($condition_storecard,"@storecard.producing_area",$search["producing_area"],"char");
           $condition_storecard = join_condition($condition_storecard,"@storecard.style_code",$search["style_code"],"char");
           $condition_storecard = join_condition2($condition_storecard,"@storecard.orig_weight",$search["orig_weight"],$search["orig_weight2"],"decimal");
           $condition_storecard = join_condition2($condition_storecard,"@storecard.weight",$search["weight"],$search["weight2"],"decimal");
           $condition_storecard = join_condition2($condition_storecard,"@storecard.qty",$search["qty"],$search["qty2"],"decimal");
           $condition_storecard = join_condition2($condition_storecard,"@storecard.bulkcargo",$search["bulkcargo"],$search["bulkcargo2"],"decimal");
           $condition_storecard = join_condition2($condition_storecard,"@storecard.lock_weight",$search["lock_weight"],$search["lock_weight2"],"decimal");
           $condition_storecard = join_condition2($condition_storecard,"@storecard.lock_qty",$search["lock_qty"],$search["lock_qty2"],"decimal");
           $condition_storecard = join_condition2($condition_storecard,"@storecard.lock_bulkcargo",$search["lock_bulkcargo"],$search["lock_bulkcargo2"],"decimal");
           $condition_storecard = join_condition($condition_storecard,"@storecard.uom_qty",$search["uom_qty"],"char");
           $condition_storecard = join_condition($condition_storecard,"@storecard.uom_weight",$search["uom_weight"],"char");
           $condition_storecard = join_condition($condition_storecard,"@storecard.uom_bulkcargo",$search["uom_bulkcargo"],"char");
           $condition_storecard = join_condition($condition_storecard,"@storecard.contact_id",$search["contact_id"],"int");
           $condition_storecard = join_condition($condition_storecard,"@storecard.contact_no",$search["contact_no"],"char");
           $condition_storecard = join_condition2($condition_storecard,"@storecard.stockin_date",$search["stockin_date"],$search["stockin_date2"],"date");
           $condition_storecard = join_condition($condition_storecard,"@storecard.fee_customer_id",$search["fee_customer_id"],"int");
           $condition_storecard = join_condition($condition_storecard,"@storecard.fee_customer_name",$search["fee_customer_name"],"char","both");
           $condition_storecard = join_condition2($condition_storecard,"@storecard.fee_start",$search["fee_start"],$search["fee_start2"],"datetime");
           $condition_storecard = join_condition2($condition_storecard,"@storecard.create_time",$search["create_time"],$search["create_time2"],"datetime");
        }
        $condition_storecard = $this->tabsheet_condition($condition_storecard ,$search["_tab"]);
          $condition_storecard = join_condition_shop($condition_storecard,"2;@storecard.org_id;org_id#3;@storecard.customer_id;customer_id",$this->user_shop_id,$search_auth_codes);

        //select fields
        $selectfields="@storecard.status ";
        $selectfields.=",@storecard.id ";
        $selectfields.=",@storecard.org_id ";
        $selectfields.=",@storecard.storecard_no ";
        $selectfields.=",@storecard.warehouse_code ";
        $selectfields.=",@storecard.customer_name ";
        $selectfields.=",@storecard.goods_no ";
        $selectfields.=",@storecard.goods_name ";
        $selectfields.=",@storecard.style_info ";
        $selectfields.=",@storecard.materials ";
        $selectfields.=",@storecard.brand ";
        $selectfields.=",@storecard.producing_area ";
        $selectfields.=",@storecard.style_code ";
        $selectfields.=",@storecard.orig_weight ";
        $selectfields.=",@storecard.weight ";
        $selectfields.=",@storecard.qty ";
        $selectfields.=",@storecard.bulkcargo ";
        $selectfields.=",@storecard.lock_weight ";
        $selectfields.=",@storecard.lock_qty ";
        $selectfields.=",@storecard.lock_bulkcargo ";
        $selectfields.=",@storecard.uom_qty ";
        $selectfields.=",@storecard.uom_weight ";
        $selectfields.=",@storecard.uom_bulkcargo ";
        $selectfields.=",@storecard.contact_id ";
        $selectfields.=",@storecard.contact_no ";
        $selectfields.=",@storecard.stockin_date ";
        $selectfields.=",@storecard.fee_customer_id ";
        $selectfields.=",@storecard.fee_customer_name ";
        $selectfields.=",@storecard.fee_start ";
        $selectfields.=",@storecard.create_time ";


        $str_header = "";
        if ($show_list['status']==1 || empty($show_list)){
            $str_header .= "状态,";
        }
        if ($show_list['org_id']==1 || empty($show_list)){
            $str_header .= "库联,";
        }
        if ($show_list['storecard_no']==1 || empty($show_list)){
            $str_header .= "存储卡号,";
        }
        if ($show_list['warehouse_code']==1 || empty($show_list)){
            $str_header .= "仓库编码,";
        }
        if ($show_list['customer_name']==1 || empty($show_list)){
            $str_header .= "客户名称,";
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
        if ($show_list['orig_weight']==1 || empty($show_list)){
            $str_header .= "初始重量,";
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
        if ($show_list['lock_weight']==1 || empty($show_list)){
            $str_header .= "锁重量,";
        }
        if ($show_list['lock_qty']==1 || empty($show_list)){
            $str_header .= "锁数量,";
        }
        if ($show_list['lock_bulkcargo']==1 || empty($show_list)){
            $str_header .= "锁散件,";
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
        if ($show_list['contact_id']==1 || empty($show_list)){
            $str_header .= "合同,";
        }
        if ($show_list['contact_no']==1 || empty($show_list)){
            $str_header .= "仓储合同,";
        }
        if ($show_list['stockin_date']==1 || empty($show_list)){
            $str_header .= "入库日期,";
        }
        if ($show_list['fee_customer_id']==1 || empty($show_list)){
            $str_header .= "仓费支付方,";
        }
        if ($show_list['fee_customer_name']==1 || empty($show_list)){
            $str_header .= "仓费支付方,";
        }
        if ($show_list['fee_start']==1 || empty($show_list)){
            $str_header .= "仓费起始日,";
        }
        if ($show_list['create_time']==1 || empty($show_list)){
            $str_header .= "创建时间,";
        }
        $str_header .= "\r\n";

        $join="";

       $count_sql = "select count(*) as cnt from @storecard  #join#  where 1=1 #condition#";  // ' for skip replace $condition
       $count_sql = str_replace("#join#",$join,$count_sql);
       $count_sql = str_replace("#condition#",$condition_storecard,$count_sql);

       $count_sql = table($count_sql);
       $count_sql = str_replace("·mailchar·","@",$count_sql);
       $count = M()->query($count_sql);
       $count = $count[0]["cnt"];

           $total_page=0;

        if(!$export_all) {
           $page_size = I("request.pagesize/d");
           $page_size = $page_size <= 0 ? session("StorecardSummary-PageSize") : $page_size;
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

        $sql = "select #selectfields# from @storecard  #join# Where 1=1 #condition# #orderby#";   // ' for skip replace $selectfields,$condition,$orderby
        $sql = str_replace("#selectfields#",$selectfields,$sql);
        $sql = str_replace("#join#",$join,$sql);
        $sql = str_replace("#condition#",$condition_storecard,$sql);
        $sql = str_replace("#orderby#",$orderby,$sql);
        $sql .= " LIMIT ". (($p - 1) * $page_size). ", ".$page_size;

        $sql = table($sql);
        $sql = str_replace("·mailchar·","@",$sql);
        $list = M()->query($sql);

        foreach($list as $master) {
            $str_line="";
            if ($show_list['status']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Storecard_status("$master[status]","name"))."\t,";
            }
            if ($show_list['org_id']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Org_byID("$master[org_id]","name"))."\t,";
            }
            if ($show_list['storecard_no']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["storecard_no"])."\t,";
            }
            if ($show_list['warehouse_code']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Warehouse("$master[warehouse_code]","name"))."\t,";
            }
            if ($show_list['customer_name']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["customer_name"])."\t,";
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
            if ($show_list['orig_weight']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("F33", $master["orig_weight"]))."\t,";
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
            if ($show_list['lock_weight']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("F33", $master["lock_weight"]))."\t,";
            }
            if ($show_list['lock_qty']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("N3", $master["lock_qty"]))."\t,";
            }
            if ($show_list['lock_bulkcargo']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("N3", $master["lock_bulkcargo"]))."\t,";
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
            if ($show_list['contact_id']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["contact_id"])."\t,";
            }
            if ($show_list['contact_no']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["contact_no"])."\t,";
            }
            if ($show_list['stockin_date']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("D", $master["stockin_date"]))."\t,";
            }
            if ($show_list['fee_customer_id']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["fee_customer_id"])."\t,";
            }
            if ($show_list['fee_customer_name']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["fee_customer_name"])."\t,";
            }
            if ($show_list['fee_start']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("DT", $master["fee_start"]))."\t,";
            }
            if ($show_list['create_time']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("DT", $master["create_time"]))."\t,";
            }
            $str_content .= $str_line . "\r\n";
        }
    }
        header('Content-Type: text/xls');
        header ("Content-type:application/vnd.ms-excel;charset=gbk" );
        $str = mb_convert_encoding("StorecardSummary", 'gbk', 'utf-8');
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
          case 'wuxiao':
          case 'youxiao':
              break;
          default:
              $itab='all';
              break;
              $itab='wuxiao';
              break;
              $itab='youxiao';
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
            case 'wuxiao':  //无效
                 $scond="@storecard.status='0'";
                 break;
            case 'youxiao':  //有效
                 $scond="@storecard.status='1'";
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
            case 'wuxiao':  //无效
                 break;
            case 'youxiao':  //有效
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
            $condition.=" @storecard.org_id='".$this->user["org_id"]."' ";
            break;
        case "3":
            $condition.=" @storecard.customer_id='".$this->user["customer_id"]."' ";
            break;
        }
        return $condition ;
    }
}
