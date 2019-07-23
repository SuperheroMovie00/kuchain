<?php namespace Summary\Controller;
//
//注释: ChainSummary - 交易链列表
//
use Home\Controller\BasicController;
use Think\Log;
class ChainSummaryController extends BasicController {

    public function _init() {
        $funcs = $this->getUserRoleList($this->user,array( 'ChainSummary', '/Home/Chain', ));
        if ($funcs)
            $this->assign("rights",  $funcs);
        else{
            $funcs = array(
                         array("key"=>"refresh","func"=>"ChainSummary","Action"=>"refresh") ,
                         array("key"=>"search","func"=>"ChainSummary","Action"=>"search") ,
                         array("key"=>"export","func"=>"ChainSummary","Action"=>"export") ,
                         array("key"=>"master_view","func"=>"/Home/Chain","Action"=>"view") ,
                         array("key"=>"detail","func"=>"ChainSummary","Action"=>"detail")
             );
            $this->assign("rights",  $this->GetUserRights($this->user["id"],$funcs ));
        }
        $this->assign("colshow", $this->GetUserColumnDefine($this->user["id"],"ChainSummary"));
    }

    public function index() {
         try {
        $data["pfuncid"] = I("request.pfuncid");
        $data["funcid"] = I("request.funcid");
        $data["zindex"] = I("request.zindex/d");
        if(empty($data["funcid"])) $data["funcid"] = "ChainSummary";
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
          //$this->ajaxResult("交易链列表后台错误");
          $this->ajaxResult($e->getMessage());
      }
    }


    private function columnsetting_define(){
        return array(
            'status'=>'状态',
            'org_id'=>'库联',
            'chain_no'=>'交易链号',
            'subject'=>'交易标题',
            'goods_no'=>'货品编码',
            'goods_name'=>'货品名称',
            'materials'=>'材质',
            'weight'=>'重量',
            'uom_weight'=>'重量单位',
            'detail'=>'明细',
            'interface_status'=>'仓库接口',
            'interface_process'=>'接口处理',
            'interface_time'=>'接口时间',
        );
    }

    private function columnsetting($data){
        $data['user_code']=session(C("USER_AUTH_KEY"));
        $data['summary']='ChainSummary';
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

        $this->ajaxResult("", "",  array("_asr.closeTab","_asr.closePopup", "_asr.openLink","_asr.hideMask()"), array("$('#".$data["funcid"]."-Tab').find('a'), '".$data["funcid"]."'","'".$data["funcid"]."'", "'". U("/Summary/ChainSummary/index?func=search&").  "','".filterFuncId("ChainSummary_Search","id=0")."','交易链列表', 1",""));


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
       $search["chain_no"] = I("request.chain_no");
       $search["subject"] = I("request.subject");
       $search["goods_no"] = I("request.goods_no");
       $search["goods_name"] = I("request.goods_name");
       $search["materials"] = I("request.materials");
       $search["weight"] = I("request.weight");
       $search["weight2"] = I("request.weight2");
       $search["uom_weight"] = I("request.uom_weight");
       $search["interface_status"] = I("request.interface_status");
       $search["interface_process"] = I("request.interface_process");
       $search["interface_time"] = I("request.interface_time");
       $search["interface_time2"] = I("request.interface_time2");

       //判断首次装载是否要赋予缺省值
       if($firstloading){
       }



       $condition="";
       $condition_chain="";
       if($bsearch) {
           //关键字条件
           if($search["_showsearch"]=="hide"  ){
               if($search["_keyword"]){
                   $condition_keyword = "";
                   $condition_keyword = join_condition($condition_keyword,"@chain.chain_no",$search["_keyword"],"char", "both" , 0, "" );
                   $condition_chain = " AND ( ". $condition_keyword .")";
               }
           }else{
               //高级搜索condition
               $condition_chain = join_condition($condition_chain,"@chain.status",$search["status"],"int");
               $condition_chain = join_condition($condition_chain,"@chain.org_id",$search["org_id"],"int");
               $condition_chain = join_condition($condition_chain,"@chain.chain_no",$search["chain_no"],"char");
               $condition_chain = join_condition($condition_chain,"@chain.subject",$search["subject"],"char","both");
               $condition_chain = join_condition($condition_chain,"@chain.goods_no",$search["goods_no"],"char");
               $condition_chain = join_condition($condition_chain,"@chain.goods_name",$search["goods_name"],"char","both");
               $condition_chain = join_condition($condition_chain,"@chain.materials",$search["materials"],"char");
               $condition_chain = join_condition2($condition_chain,"@chain.weight",$search["weight"],$search["weight2"],"decimal");
               $condition_chain = join_condition($condition_chain,"@chain.uom_weight",$search["uom_weight"],"char");
               $condition_chain = join_condition($condition_chain,"@chain.interface_status",$search["interface_status"],"int");
               $condition_chain = join_condition($condition_chain,"@chain.interface_process",$search["interface_process"],"int");
               $condition_chain = join_condition2($condition_chain,"@chain.interface_time",$search["interface_time"],$search["interface_time2"],"datetime");
           }

           //增加 tab 条件
           $condition_chain = $this->tabsheet_condition($condition_chain ,$search["_tab"]);
           //增加数据权限
       $auth_condition=$this->get_auth_condition();
       $condition_chain = join_condition_auth($condition_chain,$auth_condition,"");
           //select fields
           $selectfields=" @chain.status ";
           $selectfields.=", @chain.id ";
           $selectfields.=", @chain.org_id ";
           $selectfields.=", @chain.chain_no ";
           $selectfields.=", @chain.subject ";
           $selectfields.=", @chain.goods_no ";
           $selectfields.=", @chain.goods_name ";
           $selectfields.=", @chain.materials ";
           $selectfields.=", @chain.weight ";
           $selectfields.=", @chain.uom_weight ";
           $selectfields.=", @chain.detail ";
           $selectfields.=", @chain.interface_status ";
           $selectfields.=", @chain.interface_process ";
           $selectfields.=", @chain.interface_time ";


           $page_size = I("request.pagesize/d");
           if ($page_size<=0){
               $page_size = session("ChainSummary-PageSize");
               if (!$page_size) {
                    $page_size = 10;
               }
           }
           session("ChainSummary-PageSize", $page_size);


           $join="";
           $count_sql = "select count(*) as cnt from @chain  #join#  where 1=1 #condition#";  // ' for skip replace $condition
           $count_sql = str_replace("#join#",$join,$count_sql);
           $count_sql = str_replace("#condition#",$condition_chain,$count_sql);
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
           $sql = "select #selectfields# from @chain  #join# Where 1=1 #condition# #orderby#";
           $sql = str_replace("#selectfields#",$selectfields,$sql);
           $sql = str_replace("#join#",$join,$sql);
           $sql = str_replace("#condition#",$condition_chain,$sql);
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
        $html = $this->fetch("ChainSummary:index");
        echo $html;
    }

    public function detail($data) {
        $condition="";
        $masterkey="";
        $join="";
        $data["p"] = I("request.p/d");

        $data["tab"] = I("request.tab");
        $search["id"] = I("request.id/d");
        $condition.=" and @chain_detail.chain_id=".$search["id"];
        $masterkey.=" id=".$search["id"];
        $data["search"] = M("chain")->where($masterkey)->find();


        if(!$search)   // no param
           $this->ajaxError("查询参数非法");

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

        $page_size = 50;

        $condition= $condition;
        $count_sql = "select count(*) as cnt from @chain_detail LEFT JOIN @trade ON @trade.id=@chain_detail.trade_id left join @chain  on @chain.id=@chain_detail.chain_id  #join# where 1=1 #condition#";
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
        $sql = "select #selectfields# from @chain_detail LEFT JOIN @trade ON @trade.id=@chain_detail.trade_id left join @chain  on @chain.id=@chain_detail.chain_id  #join# Where 1=1 #condition# #orderby#";
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

        $data["master"] = M("chain")->where($masterkey)->find();

        foreach($data as $key=>$val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("ChainSummary:detailindex");
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

        if(empty($data["funcid"])) $data["funcid"] = "ChainSummary";
        if(!$p){
           $p = 1;
           $export_all = 1;
        }

        $show_list = array();

        $data['summary']='ChainSummary';
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
        $search["subject"] = I("request.subject");
        $search["goods_no"] = I("request.goods_no");
        $search["goods_name"] = I("request.goods_name");
        $search["materials"] = I("request.materials");
        $search["weight"] = I("request.weight");
        $search["weight2"] = I("request.weight2");
        $search["uom_weight"] = I("request.uom_weight");
        $search["interface_status"] = I("request.interface_status");
        $search["interface_process"] = I("request.interface_process");
        $search["interface_time"] = I("request.interface_time");
        $search["interface_time2"] = I("request.interface_time2");


        //condition
        $condition="";
        $condition_chain="";

        //读取关键字搜索内容
        $search["_keyword"] = I("request._keyword");
        if($search["_showsearch"]=="hide"  ){
            if($search["_keyword"]){
                $condition_keyword = "";
                $condition_keyword = join_condition($condition_keyword,"@chain.chain_no",$search["_keyword"],"char", "both" , 0, "" );
                $condition_chain = " AND ( ". $condition_keyword . ")";
            }
        }else{
        //高级搜索condition
           $condition_chain = join_condition($condition_chain,"@chain.status",$search["status"],"int");

           $search_auth_codes = $search["org_id"];
           $condition_chain = join_condition($condition_chain,"@chain.chain_no",$search["chain_no"],"char");
           $condition_chain = join_condition($condition_chain,"@chain.subject",$search["subject"],"char","both");
           $condition_chain = join_condition($condition_chain,"@chain.goods_no",$search["goods_no"],"char");
           $condition_chain = join_condition($condition_chain,"@chain.goods_name",$search["goods_name"],"char","both");
           $condition_chain = join_condition($condition_chain,"@chain.materials",$search["materials"],"char");
           $condition_chain = join_condition2($condition_chain,"@chain.weight",$search["weight"],$search["weight2"],"decimal");
           $condition_chain = join_condition($condition_chain,"@chain.uom_weight",$search["uom_weight"],"char");
           $condition_chain = join_condition($condition_chain,"@chain.interface_status",$search["interface_status"],"int");
           $condition_chain = join_condition($condition_chain,"@chain.interface_process",$search["interface_process"],"int");
           $condition_chain = join_condition2($condition_chain,"@chain.interface_time",$search["interface_time"],$search["interface_time2"],"datetime");
        }
        $condition_chain = $this->tabsheet_condition($condition_chain ,$search["_tab"]);
          $condition_chain = join_condition_shop($condition_chain,"2;@chain.org_id;org_id",$this->user_shop_id,$search_auth_codes);

        //select fields
        $selectfields="@chain.status ";
        $selectfields.=",@chain.id ";
        $selectfields.=",@chain.org_id ";
        $selectfields.=",@chain.chain_no ";
        $selectfields.=",@chain.subject ";
        $selectfields.=",@chain.goods_no ";
        $selectfields.=",@chain.goods_name ";
        $selectfields.=",@chain.materials ";
        $selectfields.=",@chain.weight ";
        $selectfields.=",@chain.uom_weight ";
        $selectfields.=",@chain.detail ";
        $selectfields.=",@chain.interface_status ";
        $selectfields.=",@chain.interface_process ";
        $selectfields.=",@chain.interface_time ";


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
        if ($show_list['subject']==1 || empty($show_list)){
            $str_header .= "交易标题,";
        }
        if ($show_list['goods_no']==1 || empty($show_list)){
            $str_header .= "货品编码,";
        }
        if ($show_list['goods_name']==1 || empty($show_list)){
            $str_header .= "货品名称,";
        }
        if ($show_list['materials']==1 || empty($show_list)){
            $str_header .= "材质,";
        }
        if ($show_list['weight']==1 || empty($show_list)){
            $str_header .= "重量,";
        }
        if ($show_list['uom_weight']==1 || empty($show_list)){
            $str_header .= "重量单位,";
        }
        if ($show_list['detail']==1 || empty($show_list)){
            $str_header .= "明细,";
        }
        if ($show_list['interface_status']==1 || empty($show_list)){
            $str_header .= "仓库接口,";
        }
        if ($show_list['interface_process']==1 || empty($show_list)){
            $str_header .= "接口处理,";
        }
        if ($show_list['interface_time']==1 || empty($show_list)){
            $str_header .= "接口时间,";
        }
        $str_header .= "\r\n";

        $join="";

       $count_sql = "select count(*) as cnt from @chain  #join#  where 1=1 #condition#";  // ' for skip replace $condition
       $count_sql = str_replace("#join#",$join,$count_sql);
       $count_sql = str_replace("#condition#",$condition_chain,$count_sql);

       $count_sql = table($count_sql);
       $count_sql = str_replace("·mailchar·","@",$count_sql);
       $count = M()->query($count_sql);
       $count = $count[0]["cnt"];

           $total_page=0;

        if(!$export_all) {
           $page_size = I("request.pagesize/d");
           $page_size = $page_size <= 0 ? session("ChainSummary-PageSize") : $page_size;
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

        $sql = "select #selectfields# from @chain  #join# Where 1=1 #condition# #orderby#";   // ' for skip replace $selectfields,$condition,$orderby
        $sql = str_replace("#selectfields#",$selectfields,$sql);
        $sql = str_replace("#join#",$join,$sql);
        $sql = str_replace("#condition#",$condition_chain,$sql);
        $sql = str_replace("#orderby#",$orderby,$sql);
        $sql .= " LIMIT ". (($p - 1) * $page_size). ", ".$page_size;

        $sql = table($sql);
        $sql = str_replace("·mailchar·","@",$sql);
        $list = M()->query($sql);

        foreach($list as $master) {
            $str_line="";
            if ($show_list['status']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Chain_status("$master[status]","name"))."\t,";
            }
            if ($show_list['org_id']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Org_byID("$master[org_id]","name"))."\t,";
            }
            if ($show_list['chain_no']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["chain_no"])."\t,";
            }
            if ($show_list['subject']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["subject"])."\t,";
            }
            if ($show_list['goods_no']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["goods_no"])."\t,";
            }
            if ($show_list['goods_name']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["goods_name"])."\t,";
            }
            if ($show_list['materials']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["materials"])."\t,";
            }
            if ($show_list['weight']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("F33", $master["weight"]))."\t,";
            }
            if ($show_list['uom_weight']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["uom_weight"])."\t,";
            }
            if ($show_list['detail']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("N3", $master["detail"]))."\t,";
            }
            if ($show_list['interface_status']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Chain_interface_status("$master[interface_status]","name"))."\t,";
            }
            if ($show_list['interface_process']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Chain_interface_process("$master[interface_process]","name"))."\t,";
            }
            if ($show_list['interface_time']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("DT", $master["interface_time"]))."\t,";
            }
            $str_content .= $str_line . "\r\n";
        }
    }
        header('Content-Type: text/xls');
        header ("Content-type:application/vnd.ms-excel;charset=gbk" );
        $str = mb_convert_encoding("ChainSummary", 'gbk', 'utf-8');
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
          case 'daichuli':
          case 'jieshu':
          case 'quxiao':
          case 'shixiao':
              break;
          default:
              $itab='all';
              break;
              $itab='caogao';
              break;
              $itab='daichuli';
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
                 $scond="@chain.status='0'";
                 break;
            case 'daichuli':  //待处理
                 $scond="@chain.status='1'";
                 break;
            case 'jieshu':  //结束
                 $scond="@chain.status='2'";
                 break;
            case 'quxiao':  //取消
                 $scond="@chain.status='7'";
                 break;
            case 'shixiao':  //失效
                 $scond="@chain.status='8'";
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
            case 'daichuli':  //待处理
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
            $condition.=" @chain.org_id='".$this->user["org_id"]."' ";
            break;
        }
        return $condition ;
    }
}
