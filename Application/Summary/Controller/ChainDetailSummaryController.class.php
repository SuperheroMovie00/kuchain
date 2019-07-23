<?php namespace Summary\Controller;
//
//注释: ChainDetailSummary - 交易链明细列表
//
use Home\Controller\BasicController;
use Think\Log;
class ChainDetailSummaryController extends BasicController {

    public function _init() {
        $funcs = $this->getUserRoleList($this->user,array( 'ChainDetailSummary', ));
        if ($funcs)
            $this->assign("rights",  $funcs);
        else{
            $funcs = array(
                         array("key"=>"refresh","func"=>"ChainDetailSummary","Action"=>"refresh") ,
                         array("key"=>"search","func"=>"ChainDetailSummary","Action"=>"search") ,
                         array("key"=>"export","func"=>"ChainDetailSummary","Action"=>"export")
             );
            $this->assign("rights",  $this->GetUserRights($this->user["id"],$funcs ));
        }
        $this->assign("colshow", $this->GetUserColumnDefine($this->user["id"],"ChainDetailSummary"));
    }

    public function index() {
         try {
        $data["pfuncid"] = I("request.pfuncid");
        $data["funcid"] = I("request.funcid");
        $data["zindex"] = I("request.zindex/d");
        if(empty($data["funcid"])) $data["funcid"] = "ChainDetailSummary";
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
          //$this->ajaxResult("交易链明细列表后台错误");
          $this->ajaxResult($e->getMessage());
      }
    }


    private function columnsetting_define(){
        return array(
            'status'=>'状态',
            'org_id'=>'库联',
            'chain_no'=>'交易链号',
            'seq'=>'次序',
            'trade_id'=>'交易',
            'trade_no'=>'交易单号',
            'tx_date'=>'开单日期',
            'customer_name'=>'卖出客户',
            'buyer_name'=>'买入客户',
            'interface_process'=>'接口处理',
            'interface_time'=>'接口时间',
        );
    }

    private function columnsetting($data){
        $data['user_code']=session(C("USER_AUTH_KEY"));
        $data['summary']='ChainDetailSummary';
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

        $this->ajaxResult("", "",  array("_asr.closeTab","_asr.closePopup", "_asr.openLink","_asr.hideMask()"), array("$('#".$data["funcid"]."-Tab').find('a'), '".$data["funcid"]."'","'".$data["funcid"]."'", "'". U("/Summary/ChainDetailSummary/index?func=search&").  "','".filterFuncId("ChainDetailSummary_Search","id=0")."','交易链明细列表', 1",""));


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
       $search["status"] = I("request.status");
       $search["org_id"] = I("request.org_id");
       $search["chain_no"] = I("request.chain_no");
       $search["seq"] = I("request.seq");
       $search["seq2"] = I("request.seq2");
       $search["trade_id"] = I("request.trade_id");
       $search["trade_no"] = I("request.trade_no");
       $search["tx_date"] = I("request.tx_date");
       $search["tx_date2"] = I("request.tx_date2");
       $search["customer_name"] = I("request.customer_name");
       $search["buyer_name"] = I("request.buyer_name");
       $search["interface_process"] = I("request.interface_process");
       $search["interface_time"] = I("request.interface_time");
       $search["interface_time2"] = I("request.interface_time2");

       //判断首次装载是否要赋予缺省值
       if($firstloading){
       }



       $condition="";
       $condition_chain_detail="";
       if($bsearch) {
           //关键字条件
           if($search["_showsearch"]=="hide"  ){
               if($search["_keyword"]){
                   $condition_keyword = "";
                   $condition_keyword = join_condition($condition_keyword,"@chain.chain_no",$search["_keyword"],"char", "both" , 0, "" );
                   $condition_keyword = join_condition($condition_keyword,"@trade.trade_no",$search["_keyword"],"char", "both" , 0, "OR" );
                   $condition_chain_detail = " AND ( ". $condition_keyword .")";
               }
           }else{
               //高级搜索condition
               $condition_trade = join_condition($condition_trade,"@trade.status",$search["status"],"int");
               $condition_chain_detail = join_condition($condition_chain_detail,"@chain_detail.org_id",$search["org_id"],"int");
               $condition_chain = join_condition($condition_chain,"@chain.chain_no",$search["chain_no"],"char");
               $condition_chain_detail = join_condition2($condition_chain_detail,"@chain_detail.seq",$search["seq"],$search["seq2"],"int");
               $condition_chain_detail = join_condition($condition_chain_detail,"@chain_detail.trade_id",$search["trade_id"],"int");
               $condition_trade = join_condition($condition_trade,"@trade.trade_no",$search["trade_no"],"char");
               $condition_trade = join_condition2($condition_trade,"@trade.tx_date",$search["tx_date"],$search["tx_date2"],"date");
               $condition_trade = join_condition($condition_trade,"@trade.customer_name",$search["customer_name"],"char","both");
               $condition_trade = join_condition($condition_trade,"@trade.buyer_name",$search["buyer_name"],"char","both");
               $condition_chain_detail = join_condition($condition_chain_detail,"@chain_detail.interface_process",$search["interface_process"],"int");
               $condition_chain_detail = join_condition2($condition_chain_detail,"@chain_detail.interface_time",$search["interface_time"],$search["interface_time2"],"datetime");
           }

           //增加 tab 条件
           $condition_chain_detail = $this->tabsheet_condition($condition_chain_detail ,$search["_tab"]);
           //增加数据权限
       $auth_condition=$this->get_auth_condition();
       $condition_chain_detail = join_condition_auth($condition_chain_detail,$auth_condition,"");
           //select fields
           $selectfields=" @trade.status ";
           $selectfields.=", @chain_detail.id ";
           $selectfields.=", @chain_detail.org_id ";
           $selectfields.=", @chain.chain_no ";
           $selectfields.=", @chain_detail.seq ";
           $selectfields.=", @chain_detail.trade_id ";
           $selectfields.=", @trade.trade_no ";
           $selectfields.=", @trade.tx_date ";
           $selectfields.=", @trade.customer_name ";
           $selectfields.=", @trade.buyer_name ";
           $selectfields.=", @chain_detail.interface_process ";
           $selectfields.=", @chain_detail.interface_time ";


           $page_size = I("request.pagesize/d");
           if ($page_size<=0){
               $page_size = session("ChainDetailSummary-PageSize");
               if (!$page_size) {
                    $page_size = 10;
               }
           }
           session("ChainDetailSummary-PageSize", $page_size);


           $join="";
           if($condition_trade){
              $condition_chain_detail .= $condition_trade;
           }
           if($condition_chain){
              $condition_chain_detail .= $condition_chain;
           }
           $count_sql = "select count(*) as cnt from @chain_detail LEFT JOIN @trade ON @trade.id=@chain_detail.trade_id left join @chain  on @chain.id=@chain_detail.chain_id  #join#  where 1=1 #condition#";  // ' for skip replace $condition
           $count_sql = str_replace("#join#",$join,$count_sql);
           $count_sql = str_replace("#condition#",$condition_chain_detail,$count_sql);
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
           $sql = "select #selectfields# from @chain_detail LEFT JOIN @trade ON @trade.id=@chain_detail.trade_id left join @chain  on @chain.id=@chain_detail.chain_id  #join# Where 1=1 #condition# #orderby#";
           $sql = str_replace("#selectfields#",$selectfields,$sql);
           $sql = str_replace("#join#",$join,$sql);
           $sql = str_replace("#condition#",$condition_chain_detail,$sql);
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
        $html = $this->fetch("ChainDetailSummary:index");
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

        if(empty($data["funcid"])) $data["funcid"] = "ChainDetailSummary";
        if(!$p){
           $p = 1;
           $export_all = 1;
        }

        $show_list = array();

        $data['summary']='ChainDetailSummary';
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
        $search["chain_no"] = I("request.chain_no");
        $search["seq"] = I("request.seq");
        $search["seq2"] = I("request.seq2");
        $search["trade_id"] = I("request.trade_id");
        $search["trade_no"] = I("request.trade_no");
        $search["tx_date"] = I("request.tx_date");
        $search["tx_date2"] = I("request.tx_date2");
        $search["customer_name"] = I("request.customer_name");
        $search["buyer_name"] = I("request.buyer_name");
        $search["interface_process"] = I("request.interface_process");
        $search["interface_time"] = I("request.interface_time");
        $search["interface_time2"] = I("request.interface_time2");


        //condition
        $condition="";
        $condition_chain_detail="";

        //读取关键字搜索内容
        $search["_keyword"] = I("request._keyword");
        if($search["_showsearch"]=="hide"  ){
            if($search["_keyword"]){
                $condition_keyword = "";
                $condition_keyword = join_condition($condition_keyword,"@chain.chain_no",$search["_keyword"],"char", "both" , 0, "" );
                $condition_keyword = join_condition($condition_keyword,"@trade.trade_no",$search["_keyword"],"char", "both" , 0, "OR" );
                $condition_chain_detail = " AND ( ". $condition_keyword . ")";
            }
        }else{
        //高级搜索condition
           $condition_trade = join_condition($condition_trade,"@trade.status",$search["status"],"int");

           $search_auth_codes = $search["org_id"];
           $condition_chain = join_condition($condition_chain,"@chain.chain_no",$search["chain_no"],"char");
           $condition_chain_detail = join_condition2($condition_chain_detail,"@chain_detail.seq",$search["seq"],$search["seq2"],"int");
           $condition_chain_detail = join_condition($condition_chain_detail,"@chain_detail.trade_id",$search["trade_id"],"int");
           $condition_trade = join_condition($condition_trade,"@trade.trade_no",$search["trade_no"],"char");
           $condition_trade = join_condition2($condition_trade,"@trade.tx_date",$search["tx_date"],$search["tx_date2"],"date");
           $condition_trade = join_condition($condition_trade,"@trade.customer_name",$search["customer_name"],"char","both");
           $condition_trade = join_condition($condition_trade,"@trade.buyer_name",$search["buyer_name"],"char","both");
           $condition_chain_detail = join_condition($condition_chain_detail,"@chain_detail.interface_process",$search["interface_process"],"int");
           $condition_chain_detail = join_condition2($condition_chain_detail,"@chain_detail.interface_time",$search["interface_time"],$search["interface_time2"],"datetime");
        }
        $condition_chain_detail = $this->tabsheet_condition($condition_chain_detail ,$search["_tab"]);
          $condition_chain_detail = join_condition_shop($condition_chain_detail,"2;@chain_detail.org_id;org_id",$this->user_shop_id,$search_auth_codes);

        //select fields
        $selectfields="@trade.status ";
        $selectfields.=",@chain_detail.id ";
        $selectfields.=",@chain_detail.org_id ";
        $selectfields.=",@chain.chain_no ";
        $selectfields.=",@chain_detail.seq ";
        $selectfields.=",@chain_detail.trade_id ";
        $selectfields.=",@trade.trade_no ";
        $selectfields.=",@trade.tx_date ";
        $selectfields.=",@trade.customer_name ";
        $selectfields.=",@trade.buyer_name ";
        $selectfields.=",@chain_detail.interface_process ";
        $selectfields.=",@chain_detail.interface_time ";


        $str_header = "";
        if ($show_list['status']==1 || empty($show_list)){
            $str_header .= "状态,";
        }
        if ($show_list['org_id']==1 || empty($show_list)){
            $str_header .= "库联,";
        }
        if ($show_list['chain_no']==1 || empty($show_list)){
            $str_header .= "交易链号,";
        }
        if ($show_list['seq']==1 || empty($show_list)){
            $str_header .= "次序,";
        }
        if ($show_list['trade_id']==1 || empty($show_list)){
            $str_header .= "交易,";
        }
        if ($show_list['trade_no']==1 || empty($show_list)){
            $str_header .= "交易单号,";
        }
        if ($show_list['tx_date']==1 || empty($show_list)){
            $str_header .= "开单日期,";
        }
        if ($show_list['customer_name']==1 || empty($show_list)){
            $str_header .= "卖出客户,";
        }
        if ($show_list['buyer_name']==1 || empty($show_list)){
            $str_header .= "买入客户,";
        }
        if ($show_list['interface_process']==1 || empty($show_list)){
            $str_header .= "接口处理,";
        }
        if ($show_list['interface_time']==1 || empty($show_list)){
            $str_header .= "接口时间,";
        }
        $str_header .= "\r\n";

        $join="";
        if($condition_trade){
            $condition_chain_detail .= $condition_trade;
        }
        if($condition_chain){
            $condition_chain_detail .= $condition_chain;
        }

       $count_sql = "select count(*) as cnt from @chain_detail LEFT JOIN @trade ON @trade.id=@chain_detail.trade_id left join @chain  on @chain.id=@chain_detail.chain_id  #join#  where 1=1 #condition#";  // ' for skip replace $condition
       $count_sql = str_replace("#join#",$join,$count_sql);
       $count_sql = str_replace("#condition#",$condition_chain_detail,$count_sql);

       $count_sql = table($count_sql);
       $count_sql = str_replace("·mailchar·","@",$count_sql);
       $count = M()->query($count_sql);
       $count = $count[0]["cnt"];

           $total_page=0;

        if(!$export_all) {
           $page_size = I("request.pagesize/d");
           $page_size = $page_size <= 0 ? session("ChainDetailSummary-PageSize") : $page_size;
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

        $sql = "select #selectfields# from @chain_detail LEFT JOIN @trade ON @trade.id=@chain_detail.trade_id left join @chain  on @chain.id=@chain_detail.chain_id  #join# Where 1=1 #condition# #orderby#";   // ' for skip replace $selectfields,$condition,$orderby
        $sql = str_replace("#selectfields#",$selectfields,$sql);
        $sql = str_replace("#join#",$join,$sql);
        $sql = str_replace("#condition#",$condition_chain_detail,$sql);
        $sql = str_replace("#orderby#",$orderby,$sql);
        $sql .= " LIMIT ". (($p - 1) * $page_size). ", ".$page_size;

        $sql = table($sql);
        $sql = str_replace("·mailchar·","@",$sql);
        $list = M()->query($sql);

        foreach($list as $master) {
            $str_line="";
            if ($show_list['status']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Trade_status("$master[status]","name"))."\t,";
            }
            if ($show_list['org_id']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Org_byID("$master[org_id]","name"))."\t,";
            }
            if ($show_list['chain_no']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["chain_no"])."\t,";
            }
            if ($show_list['seq']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("N3", $master["seq"]))."\t,";
            }
            if ($show_list['trade_id']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["trade_id"])."\t,";
            }
            if ($show_list['trade_no']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["trade_no"])."\t,";
            }
            if ($show_list['tx_date']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("D", $master["tx_date"]))."\t,";
            }
            if ($show_list['customer_name']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["customer_name"])."\t,";
            }
            if ($show_list['buyer_name']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["buyer_name"])."\t,";
            }
            if ($show_list['interface_process']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_ChainDetail_interface_process("$master[interface_process]","name"))."\t,";
            }
            if ($show_list['interface_time']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("DT", $master["interface_time"]))."\t,";
            }
            $str_content .= $str_line . "\r\n";
        }
    }
        header('Content-Type: text/xls');
        header ("Content-type:application/vnd.ms-excel;charset=gbk" );
        $str = mb_convert_encoding("ChainDetailSummary", 'gbk', 'utf-8');
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
          case 'daimaijiaqueren':
          case 'daimaijiaqueren_2':
          case 'peihuofukuanzhong':
          case 'daijiekouchuli':
          case 'cangkuchulizhong':
          case 'daikuanxiangbucha':
          case 'jiaoyiwancheng':
          case 'yiquxiao':
          case 'yishixiao':
              break;
          default:
              $itab='all';
              break;
              $itab='daimaijiaqueren';
              break;
              $itab='daimaijiaqueren_2';
              break;
              $itab='peihuofukuanzhong';
              break;
              $itab='daijiekouchuli';
              break;
              $itab='cangkuchulizhong';
              break;
              $itab='daikuanxiangbucha';
              break;
              $itab='jiaoyiwancheng';
              break;
              $itab='yiquxiao';
              break;
              $itab='yishixiao';
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
            case 'daimaijiaqueren':  //待卖家确认
                 $scond="@trade.status='0'";
                 break;
            case 'daimaijiaqueren_2':  //待买家确认
                 $scond="@trade.status='1'";
                 break;
            case 'peihuofukuanzhong':  //配货付款中
                 $scond="@trade.status='2'";
                 break;
            case 'daijiekouchuli':  //待接口处理
                 $scond="@trade.status='3'";
                 break;
            case 'cangkuchulizhong':  //仓库处理中
                 $scond="@trade.status='4'";
                 break;
            case 'daikuanxiangbucha':  //待款项补差
                 $scond="@trade.status='5'";
                 break;
            case 'jiaoyiwancheng':  //交易完成
                 $scond="@trade.status='6'";
                 break;
            case 'yiquxiao':  //已取消
                 $scond="@trade.status='7'";
                 break;
            case 'yishixiao':  //已失效
                 $scond="@trade.status='8'";
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
            case 'daimaijiaqueren':  //待卖家确认
                 break;
            case 'daimaijiaqueren_2':  //待买家确认
                 break;
            case 'peihuofukuanzhong':  //配货付款中
                 break;
            case 'daijiekouchuli':  //待接口处理
                 break;
            case 'cangkuchulizhong':  //仓库处理中
                 break;
            case 'daikuanxiangbucha':  //待款项补差
                 break;
            case 'jiaoyiwancheng':  //交易完成
                 break;
            case 'yiquxiao':  //已取消
                 break;
            case 'yishixiao':  //已失效
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
            $condition.=" @chain_detail.org_id='".$this->user["org_id"]."' ";
            break;
        }
        return $condition ;
    }
}
