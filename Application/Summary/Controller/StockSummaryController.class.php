<?php namespace Summary\Controller;
//
//注释: StockSummary - 库存信息列表
//
use Home\Controller\BasicController;
use Think\Log;
class StockSummaryController extends BasicController {

    public function _init() {
        $funcs = $this->getUserRoleList($this->user,array( 'StockSummary', '/Home/Stock', '/Home/%table%', ));
        if ($funcs)
            $this->assign("rights",  $funcs);
        else{
            $funcs = array(
                         array("key"=>"refresh","func"=>"StockSummary","Action"=>"refresh") ,
                         array("key"=>"search","func"=>"StockSummary","Action"=>"search") ,
                         array("key"=>"export","func"=>"StockSummary","Action"=>"export") ,
                         array("key"=>"master_view","func"=>"/Home/Stock","Action"=>"view") ,
                         array("key"=>"status","func"=>"/Home/%table%","Action"=>"%action%")
             );
            $this->assign("rights",  $this->GetUserRights($this->user["id"],$funcs ));
        }
        $this->assign("colshow", $this->GetUserColumnDefine($this->user["id"],"StockSummary"));
    }

    public function index() {
         try {
        $data["pfuncid"] = I("request.pfuncid");
        $data["funcid"] = I("request.funcid");
        $data["zindex"] = I("request.zindex/d");
        if(empty($data["funcid"])) $data["funcid"] = "StockSummary";
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
          //$this->ajaxResult("库存信息列表后台错误");
          $this->ajaxResult($e->getMessage());
      }
    }


    private function columnsetting_define(){
        return array(
            'org_id'=>'库联',
            'name'=>'客户',
            'warehouse_code'=>'仓库编码',
            'goods_no'=>'货品编码',
            'goods_name'=>'货品名称',
            'style_code'=>'货品基础码',
            'weight'=>'重量',
            'qty'=>'数量',
            'bulkcargo'=>'散件',
            'lock_weight'=>'锁重量',
            'lock_qty'=>'锁数量',
            'lock_bulkcargo'=>'锁散件',
            'create_time'=>'创建时间',
        );
    }

    private function columnsetting($data){
        $data['user_code']=session(C("USER_AUTH_KEY"));
        $data['summary']='StockSummary';
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

        $this->ajaxResult("", "",  array("_asr.closeTab","_asr.closePopup", "_asr.openLink","_asr.hideMask()"), array("$('#".$data["funcid"]."-Tab').find('a'), '".$data["funcid"]."'","'".$data["funcid"]."'", "'". U("/Summary/StockSummary/index?func=search&").  "','".filterFuncId("StockSummary_Search","id=0")."','库存信息列表', 1",""));


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
           $search["_showsearch"]="show";
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
       $search["name"] = I("request.name");
       $search["warehouse_code_name"] = I("request.warehouse_code_name");
       $search["warehouse_code"] = I("request.warehouse_code");
       $search["goods_no"] = I("request.goods_no");
       $search["goods_name"] = I("request.goods_name");
       $search["style_code"] = I("request.style_code");
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
       $search["create_time"] = I("request.create_time");
       $search["create_time2"] = I("request.create_time2");

       //判断首次装载是否要赋予缺省值
       if($firstloading){
       }



       $condition="";
       $condition_stock="";
       if($bsearch) {
           //关键字条件
           if($search["_showsearch"]=="hide"  ){
               if($search["_keyword"]){
                   $condition_keyword = "";
                   $condition_keyword = join_condition($condition_keyword,"@customer.name",$search["_keyword"],"char", "both" , 0, "" );
                   $condition_stock = " AND ( ". $condition_keyword .")";
               }
           }else{
               //高级搜索condition
               $condition_stock = join_condition($condition_stock,"@stock.org_id",$search["org_id"],"int");
               $condition_stock = join_condition($condition_stock,"@stock.customer_id",$search["customer_id"],"int");
               $condition_customer = join_condition($condition_customer,"@customer.name",$search["name"],"char","both");
               $condition_stock = join_condition($condition_stock,"@stock.warehouse_code",$search["warehouse_code"],"char");
               $condition_stock = join_condition($condition_stock,"@stock.goods_no",$search["goods_no"],"char");
               $condition_stock = join_condition($condition_stock,"@stock.goods_name",$search["goods_name"],"char","both");
               $condition_stock = join_condition($condition_stock,"@stock.style_code",$search["style_code"],"char");
               $condition_stock = join_condition2($condition_stock,"@stock.weight",$search["weight"],$search["weight2"],"decimal");
               $condition_stock = join_condition2($condition_stock,"@stock.qty",$search["qty"],$search["qty2"],"decimal");
               $condition_stock = join_condition2($condition_stock,"@stock.bulkcargo",$search["bulkcargo"],$search["bulkcargo2"],"decimal");
               $condition_stock = join_condition2($condition_stock,"@stock.lock_weight",$search["lock_weight"],$search["lock_weight2"],"decimal");
               $condition_stock = join_condition2($condition_stock,"@stock.lock_qty",$search["lock_qty"],$search["lock_qty2"],"decimal");
               $condition_stock = join_condition2($condition_stock,"@stock.lock_bulkcargo",$search["lock_bulkcargo"],$search["lock_bulkcargo2"],"decimal");
               $condition_stock = join_condition2($condition_stock,"@stock.create_time",$search["create_time"],$search["create_time2"],"datetime");
           }

           //增加 tab 条件
           $condition_stock = $this->tabsheet_condition($condition_stock ,$search["_tab"]);
           //增加数据权限
       $auth_condition=$this->get_auth_condition();
       $condition_stock = join_condition_auth($condition_stock,$auth_condition,"");
           //select fields
           $selectfields=" @stock.id ";
           $selectfields.=", @stock.org_id ";
           $selectfields.=", @stock.customer_id ";
           $selectfields.=", @customer.name ";
           $selectfields.=", @stock.warehouse_code ";
           $selectfields.=", @stock.goods_no ";
           $selectfields.=", @stock.goods_name ";
           $selectfields.=", @stock.style_code ";
           $selectfields.=", @stock.weight ";
           $selectfields.=", @stock.qty ";
           $selectfields.=", @stock.bulkcargo ";
           $selectfields.=", @stock.lock_weight ";
           $selectfields.=", @stock.lock_qty ";
           $selectfields.=", @stock.lock_bulkcargo ";
           $selectfields.=", @stock.create_time ";


           $page_size = I("request.pagesize/d");
           if ($page_size<=0){
               $page_size = session("StockSummary-PageSize");
               if (!$page_size) {
                    $page_size = 10;
               }
           }
           session("StockSummary-PageSize", $page_size);


           $join="";
           if($condition_customer){
              $condition_stock .= $condition_customer;
           }
           $count_sql = "select count(*) as cnt from @stock LEFT JOIN @customer ON @customer.id=@stock.customer_id  #join#  where 1=1 #condition#";  // ' for skip replace $condition
           $count_sql = str_replace("#join#",$join,$count_sql);
           $count_sql = str_replace("#condition#",$condition_stock,$count_sql);
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
           $sql = "select #selectfields# from @stock LEFT JOIN @customer ON @customer.id=@stock.customer_id  #join# Where 1=1 #condition# #orderby#";
           $sql = str_replace("#selectfields#",$selectfields,$sql);
           $sql = str_replace("#join#",$join,$sql);
           $sql = str_replace("#condition#",$condition_stock,$sql);
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
        $html = $this->fetch("StockSummary:index");
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

        if(empty($data["funcid"])) $data["funcid"] = "StockSummary";
        if(!$p){
           $p = 1;
           $export_all = 1;
        }

        $show_list = array();

        $data['summary']='StockSummary';
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
        $search["name"] = I("request.name");
        $search["warehouse_code_name"] = I("request.warehouse_code_name");
        $search["warehouse_code"] = I("request.warehouse_code");
        $search["goods_no"] = I("request.goods_no");
        $search["goods_name"] = I("request.goods_name");
        $search["style_code"] = I("request.style_code");
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
        $search["create_time"] = I("request.create_time");
        $search["create_time2"] = I("request.create_time2");


        //condition
        $condition="";
        $condition_stock="";

        //读取关键字搜索内容
        $search["_keyword"] = I("request._keyword");
        if($search["_showsearch"]=="hide"  ){
            if($search["_keyword"]){
                $condition_keyword = "";
                $condition_keyword = join_condition($condition_keyword,"@customer.name",$search["_keyword"],"char", "both" , 0, "" );
                $condition_stock = " AND ( ". $condition_keyword . ")";
            }
        }else{
        //高级搜索condition

           $search_auth_codes = $search["org_id"];
           $condition_stock = join_condition($condition_stock,"@stock.customer_id",$search["customer_id"],"int");
           $condition_customer = join_condition($condition_customer,"@customer.name",$search["name"],"char","both");
           $condition_stock = join_condition($condition_stock,"@stock.warehouse_code",$search["warehouse_code"],"char");
           $condition_stock = join_condition($condition_stock,"@stock.goods_no",$search["goods_no"],"char");
           $condition_stock = join_condition($condition_stock,"@stock.goods_name",$search["goods_name"],"char","both");
           $condition_stock = join_condition($condition_stock,"@stock.style_code",$search["style_code"],"char");
           $condition_stock = join_condition2($condition_stock,"@stock.weight",$search["weight"],$search["weight2"],"decimal");
           $condition_stock = join_condition2($condition_stock,"@stock.qty",$search["qty"],$search["qty2"],"decimal");
           $condition_stock = join_condition2($condition_stock,"@stock.bulkcargo",$search["bulkcargo"],$search["bulkcargo2"],"decimal");
           $condition_stock = join_condition2($condition_stock,"@stock.lock_weight",$search["lock_weight"],$search["lock_weight2"],"decimal");
           $condition_stock = join_condition2($condition_stock,"@stock.lock_qty",$search["lock_qty"],$search["lock_qty2"],"decimal");
           $condition_stock = join_condition2($condition_stock,"@stock.lock_bulkcargo",$search["lock_bulkcargo"],$search["lock_bulkcargo2"],"decimal");
           $condition_stock = join_condition2($condition_stock,"@stock.create_time",$search["create_time"],$search["create_time2"],"datetime");
        }
        $condition_stock = $this->tabsheet_condition($condition_stock ,$search["_tab"]);
          $condition_stock = join_condition_shop($condition_stock,"2;@stock.org_id;org_id#3;@stock.customer_id;customer_id",$this->user_shop_id,$search_auth_codes);

        //select fields
        $selectfields="@stock.id ";
        $selectfields.=",@stock.org_id ";
        $selectfields.=",@stock.customer_id ";
        $selectfields.=",@customer.name ";
        $selectfields.=",@stock.warehouse_code ";
        $selectfields.=",@stock.goods_no ";
        $selectfields.=",@stock.goods_name ";
        $selectfields.=",@stock.style_code ";
        $selectfields.=",@stock.weight ";
        $selectfields.=",@stock.qty ";
        $selectfields.=",@stock.bulkcargo ";
        $selectfields.=",@stock.lock_weight ";
        $selectfields.=",@stock.lock_qty ";
        $selectfields.=",@stock.lock_bulkcargo ";
        $selectfields.=",@stock.create_time ";


        $str_header = "";
        if ($show_list['org_id']==1 || empty($show_list)){
            $str_header .= "库联,";
        }
        if ($show_list['name']==1 || empty($show_list)){
            $str_header .= "客户,";
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
        if ($show_list['style_code']==1 || empty($show_list)){
            $str_header .= "货品基础码,";
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
        if ($show_list['create_time']==1 || empty($show_list)){
            $str_header .= "创建时间,";
        }
        $str_header .= "\r\n";

        $join="";
        if($condition_customer){
            $condition_stock .= $condition_customer;
        }

       $count_sql = "select count(*) as cnt from @stock LEFT JOIN @customer ON @customer.id=@stock.customer_id  #join#  where 1=1 #condition#";  // ' for skip replace $condition
       $count_sql = str_replace("#join#",$join,$count_sql);
       $count_sql = str_replace("#condition#",$condition_stock,$count_sql);

       $count_sql = table($count_sql);
       $count_sql = str_replace("·mailchar·","@",$count_sql);
       $count = M()->query($count_sql);
       $count = $count[0]["cnt"];

           $total_page=0;

        if(!$export_all) {
           $page_size = I("request.pagesize/d");
           $page_size = $page_size <= 0 ? session("StockSummary-PageSize") : $page_size;
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

        $sql = "select #selectfields# from @stock LEFT JOIN @customer ON @customer.id=@stock.customer_id  #join# Where 1=1 #condition# #orderby#";   // ' for skip replace $selectfields,$condition,$orderby
        $sql = str_replace("#selectfields#",$selectfields,$sql);
        $sql = str_replace("#join#",$join,$sql);
        $sql = str_replace("#condition#",$condition_stock,$sql);
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
            if ($show_list['name']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["name"])."\t,";
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
            if ($show_list['style_code']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["style_code"])."\t,";
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
            if ($show_list['create_time']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("DT", $master["create_time"]))."\t,";
            }
            $str_content .= $str_line . "\r\n";
        }
    }
        header('Content-Type: text/xls');
        header ("Content-type:application/vnd.ms-excel;charset=gbk" );
        $str = mb_convert_encoding("StockSummary", 'gbk', 'utf-8');
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
            $condition.=" @stock.org_id='".$this->user["org_id"]."' ";
            break;
        case "3":
            $condition.=" @stock.customer_id='".$this->user["customer_id"]."' ";
            break;
        }
        return $condition ;
    }
}
