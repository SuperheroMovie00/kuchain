<?php namespace Summary\Controller;
//
//注释: CustomerApplySummary - 客户申请信息列表
//
use Home\Controller\BasicController;
use Think\Log;
class CustomerApplySummaryController extends BasicController {

    public function _init() {
        $funcs = $this->getUserRoleList($this->user,array( 'CustomerApplySummary', '/Home/CustomerApply', ));
        if ($funcs)
            $this->assign("rights",  $funcs);
        else{
            $funcs = array(
                         array("key"=>"refresh","func"=>"CustomerApplySummary","Action"=>"refresh") ,
                         array("key"=>"search","func"=>"CustomerApplySummary","Action"=>"search") ,
                         array("key"=>"export","func"=>"CustomerApplySummary","Action"=>"export") ,
                         array("key"=>"master_view","func"=>"/Home/CustomerApply","Action"=>"view") ,
                         array("key"=>"status_on","func"=>"/Home/CustomerApply","Action"=>"status_on") ,
                         array("key"=>"status_off","func"=>"/Home/CustomerApply","Action"=>"status_off")
             );
            $this->assign("rights",  $this->GetUserRights($this->user["id"],$funcs ));
        }
        $this->assign("colshow", $this->GetUserColumnDefine($this->user["id"],"CustomerApplySummary"));
    }

    public function index() {
         try {
        $data["pfuncid"] = I("request.pfuncid");
        $data["funcid"] = I("request.funcid");
        $data["zindex"] = I("request.zindex/d");
        if(empty($data["funcid"])) $data["funcid"] = "CustomerApplySummary";
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
          //$this->ajaxResult("客户申请信息列表后台错误");
          $this->ajaxResult($e->getMessage());
      }
    }


    private function columnsetting_define(){
        return array(
            'status'=>'状态',
            'type'=>'申请类型',
            'code'=>'客户代码',
            'name'=>'客户简称',
            'subject'=>'申请摘要',
            'apply_time'=>'申请时间',
            'apply_user'=>'申请人员',
            'reply_time'=>'回复时间',
            'reply_user'=>'回复人员',
            'reply_status'=>'回复状态',
            'create_time'=>'创建时间',
        );
    }

    private function columnsetting($data){
        $data['user_code']=session(C("USER_AUTH_KEY"));
        $data['summary']='CustomerApplySummary';
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

        $this->ajaxResult("", "",  array("_asr.closeTab","_asr.closePopup", "_asr.openLink","_asr.hideMask()"), array("$('#".$data["funcid"]."-Tab').find('a'), '".$data["funcid"]."'","'".$data["funcid"]."'", "'". U("/Summary/CustomerApplySummary/index?func=search&").  "','".filterFuncId("CustomerApplySummary_Search","id=0")."','客户申请信息列表', 1",""));


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
       $search["type"] = I("request.type");
       $search["code"] = I("request.code");
       $search["name"] = I("request.name");
       $search["subject"] = I("request.subject");
       $search["apply_time"] = I("request.apply_time");
       $search["apply_time2"] = I("request.apply_time2");
       $search["apply_user"] = I("request.apply_user");
       $search["reply_time"] = I("request.reply_time");
       $search["reply_time2"] = I("request.reply_time2");
       $search["reply_user"] = I("request.reply_user");
       $search["reply_status"] = I("request.reply_status");
       $search["create_time"] = I("request.create_time");
       $search["create_time2"] = I("request.create_time2");

       //判断首次装载是否要赋予缺省值
       if($firstloading){
       }



       $condition="";
       $condition_customer_apply="";
       if($bsearch) {
           //关键字条件
           if($search["_showsearch"]=="hide"  ){
               if($search["_keyword"]){
                   $condition_keyword = "";
                   $condition_keyword = join_condition($condition_keyword,"@customer.code",$search["_keyword"],"char", "both" , 0, "" );
                   $condition_keyword = join_condition($condition_keyword,"@customer.name",$search["_keyword"],"char", "both" , 0, "OR" );
                   $condition_customer_apply = " AND ( ". $condition_keyword .")";
               }
           }else{
               //高级搜索condition
               $condition_customer_apply = join_condition($condition_customer_apply,"@customer_apply.status",$search["status"],"int");
               $condition_customer_apply = join_condition($condition_customer_apply,"@customer_apply.type",$search["type"],"int");
               $condition_customer = join_condition($condition_customer,"@customer.code",$search["code"],"char");
               $condition_customer = join_condition($condition_customer,"@customer.name",$search["name"],"char","both");
               $condition_customer_apply = join_condition($condition_customer_apply,"@customer_apply.subject",$search["subject"],"char","both");
               $condition_customer_apply = join_condition2($condition_customer_apply,"@customer_apply.apply_time",$search["apply_time"],$search["apply_time2"],"datetime");
               $condition_customer_apply = join_condition($condition_customer_apply,"@customer_apply.apply_user",$search["apply_user"],"char");
               $condition_customer_apply = join_condition2($condition_customer_apply,"@customer_apply.reply_time",$search["reply_time"],$search["reply_time2"],"datetime");
               $condition_customer_apply = join_condition($condition_customer_apply,"@customer_apply.reply_user",$search["reply_user"],"char");
               $condition_customer_apply = join_condition($condition_customer_apply,"@customer_apply.reply_status",$search["reply_status"],"int");
               $condition_customer_apply = join_condition2($condition_customer_apply,"@customer_apply.create_time",$search["create_time"],$search["create_time2"],"datetime");
           }

           //增加 tab 条件
           $condition_customer_apply = $this->tabsheet_condition($condition_customer_apply ,$search["_tab"]);
           //增加数据权限
       $auth_condition=$this->get_auth_condition();
       $condition_customer_apply = join_condition_auth($condition_customer_apply,$auth_condition,"");
           //select fields
           $selectfields=" @customer_apply.status ";
           $selectfields.=", @customer_apply.id ";
           $selectfields.=", @customer_apply.type ";
           $selectfields.=", @customer.code ";
           $selectfields.=", @customer.name ";
           $selectfields.=", @customer_apply.subject ";
           $selectfields.=", @customer_apply.apply_time ";
           $selectfields.=", @customer_apply.apply_user ";
           $selectfields.=", @customer_apply.reply_time ";
           $selectfields.=", @customer_apply.reply_user ";
           $selectfields.=", @customer_apply.reply_status ";
           $selectfields.=", @customer_apply.create_time ";


           $page_size = I("request.pagesize/d");
           if ($page_size<=0){
               $page_size = session("CustomerApplySummary-PageSize");
               if (!$page_size) {
                    $page_size = 10;
               }
           }
           session("CustomerApplySummary-PageSize", $page_size);


           $join="";
           if($condition_customer){
              $condition_customer_apply .= $condition_customer;
           }
           $count_sql = "select count(*) as cnt from @customer_apply LEFT JOIN @customer ON @customer.id=@customer_apply.customer_id  #join#  where 1=1 #condition#";  // ' for skip replace $condition
           $count_sql = str_replace("#join#",$join,$count_sql);
           $count_sql = str_replace("#condition#",$condition_customer_apply,$count_sql);
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
           $sql = "select #selectfields# from @customer_apply LEFT JOIN @customer ON @customer.id=@customer_apply.customer_id  #join# Where 1=1 #condition# #orderby#";
           $sql = str_replace("#selectfields#",$selectfields,$sql);
           $sql = str_replace("#join#",$join,$sql);
           $sql = str_replace("#condition#",$condition_customer_apply,$sql);
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
        $html = $this->fetch("CustomerApplySummary:index");
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

        if(empty($data["funcid"])) $data["funcid"] = "CustomerApplySummary";
        if(!$p){
           $p = 1;
           $export_all = 1;
        }

        $show_list = array();

        $data['summary']='CustomerApplySummary';
        $usc = M('user_summary_column')->field("column")->where("user_code='%s' AND summary='%s' AND `show`='1'",array(session(C("USER_AUTH_KEY")),$data['summary']))->select();
        if($usc){
           foreach ($usc as $v) {
              $show_list[$v['column']]=1;
           }
        }

        $search["_tab"] = $this->tabsheet_check(I("request._tab"));
        $tab = $search["_tab"];

        $search["status"] = I("request.status");
        $search["type"] = I("request.type");
        $search["code"] = I("request.code");
        $search["name"] = I("request.name");
        $search["subject"] = I("request.subject");
        $search["apply_time"] = I("request.apply_time");
        $search["apply_time2"] = I("request.apply_time2");
        $search["apply_user"] = I("request.apply_user");
        $search["reply_time"] = I("request.reply_time");
        $search["reply_time2"] = I("request.reply_time2");
        $search["reply_user"] = I("request.reply_user");
        $search["reply_status"] = I("request.reply_status");
        $search["create_time"] = I("request.create_time");
        $search["create_time2"] = I("request.create_time2");


        //condition
        $condition="";
        $condition_customer_apply="";

        //读取关键字搜索内容
        $search["_keyword"] = I("request._keyword");
        if($search["_showsearch"]=="hide"  ){
            if($search["_keyword"]){
                $condition_keyword = "";
                $condition_keyword = join_condition($condition_keyword,"@customer.code",$search["_keyword"],"char", "both" , 0, "" );
                $condition_keyword = join_condition($condition_keyword,"@customer.name",$search["_keyword"],"char", "both" , 0, "OR" );
                $condition_customer_apply = " AND ( ". $condition_keyword . ")";
            }
        }else{
        //高级搜索condition
           $condition_customer_apply = join_condition($condition_customer_apply,"@customer_apply.status",$search["status"],"int");
           $condition_customer_apply = join_condition($condition_customer_apply,"@customer_apply.type",$search["type"],"int");
           $condition_customer = join_condition($condition_customer,"@customer.code",$search["code"],"char");
           $condition_customer = join_condition($condition_customer,"@customer.name",$search["name"],"char","both");
           $condition_customer_apply = join_condition($condition_customer_apply,"@customer_apply.subject",$search["subject"],"char","both");
           $condition_customer_apply = join_condition2($condition_customer_apply,"@customer_apply.apply_time",$search["apply_time"],$search["apply_time2"],"datetime");
           $condition_customer_apply = join_condition($condition_customer_apply,"@customer_apply.apply_user",$search["apply_user"],"char");
           $condition_customer_apply = join_condition2($condition_customer_apply,"@customer_apply.reply_time",$search["reply_time"],$search["reply_time2"],"datetime");
           $condition_customer_apply = join_condition($condition_customer_apply,"@customer_apply.reply_user",$search["reply_user"],"char");
           $condition_customer_apply = join_condition($condition_customer_apply,"@customer_apply.reply_status",$search["reply_status"],"int");
           $condition_customer_apply = join_condition2($condition_customer_apply,"@customer_apply.create_time",$search["create_time"],$search["create_time2"],"datetime");
        }
        $condition_customer_apply = $this->tabsheet_condition($condition_customer_apply ,$search["_tab"]);
          $condition_customer_apply = join_condition_shop($condition_customer_apply,"3;@customer_apply.customer_id;customer_id",$this->user_shop_id,$search_auth_codes);

        //select fields
        $selectfields="@customer_apply.status ";
        $selectfields.=",@customer_apply.id ";
        $selectfields.=",@customer_apply.type ";
        $selectfields.=",@customer.code ";
        $selectfields.=",@customer.name ";
        $selectfields.=",@customer_apply.subject ";
        $selectfields.=",@customer_apply.apply_time ";
        $selectfields.=",@customer_apply.apply_user ";
        $selectfields.=",@customer_apply.reply_time ";
        $selectfields.=",@customer_apply.reply_user ";
        $selectfields.=",@customer_apply.reply_status ";
        $selectfields.=",@customer_apply.create_time ";


        $str_header = "";
        if ($show_list['status']==1 || empty($show_list)){
            $str_header .= "状态,";
        }
        if ($show_list['type']==1 || empty($show_list)){
            $str_header .= "申请类型,";
        }
        if ($show_list['code']==1 || empty($show_list)){
            $str_header .= "客户代码,";
        }
        if ($show_list['name']==1 || empty($show_list)){
            $str_header .= "客户简称,";
        }
        if ($show_list['subject']==1 || empty($show_list)){
            $str_header .= "申请摘要,";
        }
        if ($show_list['apply_time']==1 || empty($show_list)){
            $str_header .= "申请时间,";
        }
        if ($show_list['apply_user']==1 || empty($show_list)){
            $str_header .= "申请人员,";
        }
        if ($show_list['reply_time']==1 || empty($show_list)){
            $str_header .= "回复时间,";
        }
        if ($show_list['reply_user']==1 || empty($show_list)){
            $str_header .= "回复人员,";
        }
        if ($show_list['reply_status']==1 || empty($show_list)){
            $str_header .= "回复状态,";
        }
        if ($show_list['create_time']==1 || empty($show_list)){
            $str_header .= "创建时间,";
        }
        $str_header .= "\r\n";

        $join="";
        if($condition_customer){
            $condition_customer_apply .= $condition_customer;
        }

       $count_sql = "select count(*) as cnt from @customer_apply LEFT JOIN @customer ON @customer.id=@customer_apply.customer_id  #join#  where 1=1 #condition#";  // ' for skip replace $condition
       $count_sql = str_replace("#join#",$join,$count_sql);
       $count_sql = str_replace("#condition#",$condition_customer_apply,$count_sql);

       $count_sql = table($count_sql);
       $count_sql = str_replace("·mailchar·","@",$count_sql);
       $count = M()->query($count_sql);
       $count = $count[0]["cnt"];

           $total_page=0;

        if(!$export_all) {
           $page_size = I("request.pagesize/d");
           $page_size = $page_size <= 0 ? session("CustomerApplySummary-PageSize") : $page_size;
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

        $sql = "select #selectfields# from @customer_apply LEFT JOIN @customer ON @customer.id=@customer_apply.customer_id  #join# Where 1=1 #condition# #orderby#";   // ' for skip replace $selectfields,$condition,$orderby
        $sql = str_replace("#selectfields#",$selectfields,$sql);
        $sql = str_replace("#join#",$join,$sql);
        $sql = str_replace("#condition#",$condition_customer_apply,$sql);
        $sql = str_replace("#orderby#",$orderby,$sql);
        $sql .= " LIMIT ". (($p - 1) * $page_size). ", ".$page_size;

        $sql = table($sql);
        $sql = str_replace("·mailchar·","@",$sql);
        $list = M()->query($sql);

        foreach($list as $master) {
            $str_line="";
            if ($show_list['status']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_CustomerApply_status("$master[status]","name"))."\t,";
            }
            if ($show_list['type']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_CustomerApply_type("$master[type]","name"))."\t,";
            }
            if ($show_list['code']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["code"])."\t,";
            }
            if ($show_list['name']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["name"])."\t,";
            }
            if ($show_list['subject']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["subject"])."\t,";
            }
            if ($show_list['apply_time']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("DT", $master["apply_time"]))."\t,";
            }
            if ($show_list['apply_user']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["apply_user"])."\t,";
            }
            if ($show_list['reply_time']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("DT", $master["reply_time"]))."\t,";
            }
            if ($show_list['reply_user']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["reply_user"])."\t,";
            }
            if ($show_list['reply_status']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_CustomerApply_reply_status("$master[reply_status]","name"))."\t,";
            }
            if ($show_list['create_time']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("DT", $master["create_time"]))."\t,";
            }
            $str_content .= $str_line . "\r\n";
        }
    }
        header('Content-Type: text/xls');
        header ("Content-type:application/vnd.ms-excel;charset=gbk" );
        $str = mb_convert_encoding("CustomerApplySummary", 'gbk', 'utf-8');
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
          case 'daichuli':
          case 'yichuli':
              break;
          default:
              $itab='all';
              break;
              $itab='daichuli';
              break;
              $itab='yichuli';
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
            case 'daichuli':  //待处理
                 $scond="@customer_apply.status='0'";
                 break;
            case 'yichuli':  //已处理
                 $scond="@customer_apply.status='1'";
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
            case 'daichuli':  //待处理
                 break;
            case 'yichuli':  //已处理
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
        case "3":
            $condition.=" @customer_apply.customer_id='".$this->user["customer_id"]."' ";
            break;
        }
        return $condition ;
    }
}
