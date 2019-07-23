<?php namespace Summary\Controller;
//
//注释: ServiceSummary - 系统服务设置列表
//
use Home\Controller\BasicController;
use Think\Log;
class ServiceSummaryController extends BasicController {

    public function _init() {
        $funcs = $this->getUserRoleList($this->user,array( '/Home/Service', 'ServiceSummary', ));
        if ($funcs)
            $this->assign("rights",  $funcs);
        else{
            $funcs = array(
                         array("key"=>"add","func"=>"/Home/Service","Action"=>"add") ,
                         array("key"=>"refresh","func"=>"ServiceSummary","Action"=>"refresh") ,
                         array("key"=>"search","func"=>"ServiceSummary","Action"=>"search") ,
                         array("key"=>"export","func"=>"ServiceSummary","Action"=>"export") ,
                         array("key"=>"master_view","func"=>"/Home/Service","Action"=>"view") ,
                         array("key"=>"master_edit","func"=>"/Home/Service","Action"=>"edit") ,
                         array("key"=>"master_delete","func"=>"/Home/Service","Action"=>"delete") ,
                         array("key"=>"status_on","func"=>"/Home/Service","Action"=>"status_on") ,
                         array("key"=>"status_off","func"=>"/Home/Service","Action"=>"status_off")
             );
            $this->assign("rights",  $this->GetUserRights($this->user["id"],$funcs ));
        }
        $this->assign("colshow", $this->GetUserColumnDefine($this->user["id"],"ServiceSummary"));
    }

    public function index() {
         try {
        $data["pfuncid"] = I("request.pfuncid");
        $data["funcid"] = I("request.funcid");
        $data["zindex"] = I("request.zindex/d");
        if(empty($data["funcid"])) $data["funcid"] = "ServiceSummary";
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
          //$this->ajaxResult("系统服务设置列表后台错误");
          $this->ajaxResult($e->getMessage());
      }
    }


    private function columnsetting_define(){
        return array(
            'status'=>'状态',
            'service_group'=>'分组',
            'service_code'=>'代码',
            'service_name'=>'名称',
            'service_description'=>'描述',
            'run_period'=>'间隔时间(分钟)',
            'allow_start_time'=>'开始时间',
            'allow_end_time'=>'结束时间',
            'sort'=>'排序',
            'next_run_time'=>'下次运行时间',
            'last_run_time'=>'最近运行时间',
            'create_time'=>'创建时间',
        );
    }

    private function columnsetting($data){
        $data['user_code']=session(C("USER_AUTH_KEY"));
        $data['summary']='ServiceSummary';
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

        $this->ajaxResult("", "",  array("_asr.closeTab","_asr.closePopup", "_asr.openLink","_asr.hideMask()"), array("$('#".$data["funcid"]."-Tab').find('a'), '".$data["funcid"]."'","'".$data["funcid"]."'", "'". U("/Summary/ServiceSummary/index?func=search&").  "','".filterFuncId("ServiceSummary_Search","id=0")."','系统服务设置列表', 1",""));


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
       $search["service_group"] = I("request.service_group");
       $search["service_code"] = I("request.service_code");
       $search["service_name"] = I("request.service_name");
       $search["service_description"] = I("request.service_description");
       $search["run_period"] = I("request.run_period");
       $search["run_period2"] = I("request.run_period2");
       $search["allow_start_time"] = I("request.allow_start_time");
       $search["allow_start_time2"] = I("request.allow_start_time2");
       $search["allow_end_time"] = I("request.allow_end_time");
       $search["allow_end_time2"] = I("request.allow_end_time2");
       $search["next_run_time"] = I("request.next_run_time");
       $search["next_run_time2"] = I("request.next_run_time2");
       $search["last_run_time"] = I("request.last_run_time");
       $search["last_run_time2"] = I("request.last_run_time2");

       //判断首次装载是否要赋予缺省值
       if($firstloading){
       }



       $condition="";
       $condition_service="";
       if($bsearch) {
           //关键字条件
           if($search["_showsearch"]=="hide"  ){
               if($search["_keyword"]){
                   $condition_keyword = "";
                   $condition_service = " AND ( ". $condition_keyword .")";
               }
           }else{
               //高级搜索condition
               $condition_service = join_condition($condition_service,"@service.status",$search["status"],"int");
               $condition_service = join_condition($condition_service,"@service.service_group",$search["service_group"],"char");
               $condition_service = join_condition($condition_service,"@service.service_code",$search["service_code"],"char");
               $condition_service = join_condition($condition_service,"@service.service_name",$search["service_name"],"char","both");
               $condition_service = join_condition($condition_service,"@service.service_description",$search["service_description"],"char","both");
               $condition_service = join_condition2($condition_service,"@service.run_period",$search["run_period"],$search["run_period2"],"int");
               $condition_service = join_condition2($condition_service,"@service.allow_start_time",$search["allow_start_time"],$search["allow_start_time2"],"datetime");
               $condition_service = join_condition2($condition_service,"@service.allow_end_time",$search["allow_end_time"],$search["allow_end_time2"],"datetime");
               $condition_service = join_condition2($condition_service,"@service.next_run_time",$search["next_run_time"],$search["next_run_time2"],"datetime");
               $condition_service = join_condition2($condition_service,"@service.last_run_time",$search["last_run_time"],$search["last_run_time2"],"datetime");
           }

           //增加 tab 条件
           $condition_service = $this->tabsheet_condition($condition_service ,$search["_tab"]);
           //select fields
           $selectfields=" @service.status ";
           $selectfields.=", @service.id ";
           $selectfields.=", @service.service_group ";
           $selectfields.=", @service.service_code ";
           $selectfields.=", @service.service_name ";
           $selectfields.=", @service.service_description ";
           $selectfields.=", @service.run_period ";
           $selectfields.=", @service.allow_start_time ";
           $selectfields.=", @service.allow_end_time ";
           $selectfields.=", @service.sort ";
           $selectfields.=", @service.next_run_time ";
           $selectfields.=", @service.last_run_time ";
           $selectfields.=", @service.create_time ";


           $page_size = I("request.pagesize/d");
           if ($page_size<=0){
               $page_size = session("ServiceSummary-PageSize");
               if (!$page_size) {
                    $page_size = 10;
               }
           }
           session("ServiceSummary-PageSize", $page_size);


           $join="";
           $count_sql = "select count(*) as cnt from @service  #join#  where 1=1 #condition#";  // ' for skip replace $condition
           $count_sql = str_replace("#join#",$join,$count_sql);
           $count_sql = str_replace("#condition#",$condition_service,$count_sql);
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

           $orderby = $this->get_orderby("@service.sort",$search["_tab"]);
           $sql = "select #selectfields# from @service  #join# Where 1=1 #condition# #orderby#";
           $sql = str_replace("#selectfields#",$selectfields,$sql);
           $sql = str_replace("#join#",$join,$sql);
           $sql = str_replace("#condition#",$condition_service,$sql);
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
        $html = $this->fetch("ServiceSummary:index");
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

        if(empty($data["funcid"])) $data["funcid"] = "ServiceSummary";
        if(!$p){
           $p = 1;
           $export_all = 1;
        }

        $show_list = array();

        $data['summary']='ServiceSummary';
        $usc = M('user_summary_column')->field("column")->where("user_code='%s' AND summary='%s' AND `show`='1'",array(session(C("USER_AUTH_KEY")),$data['summary']))->select();
        if($usc){
           foreach ($usc as $v) {
              $show_list[$v['column']]=1;
           }
        }

        $search["_tab"] = $this->tabsheet_check(I("request._tab"));
        $tab = $search["_tab"];

        $search["status"] = I("request.status");
        $search["service_group"] = I("request.service_group");
        $search["service_code"] = I("request.service_code");
        $search["service_name"] = I("request.service_name");
        $search["service_description"] = I("request.service_description");
        $search["run_period"] = I("request.run_period");
        $search["run_period2"] = I("request.run_period2");
        $search["allow_start_time"] = I("request.allow_start_time");
        $search["allow_start_time2"] = I("request.allow_start_time2");
        $search["allow_end_time"] = I("request.allow_end_time");
        $search["allow_end_time2"] = I("request.allow_end_time2");
        $search["next_run_time"] = I("request.next_run_time");
        $search["next_run_time2"] = I("request.next_run_time2");
        $search["last_run_time"] = I("request.last_run_time");
        $search["last_run_time2"] = I("request.last_run_time2");


        //condition
        $condition="";
        $condition_service="";

        //读取关键字搜索内容
        $search["_keyword"] = I("request._keyword");
        if($search["_showsearch"]=="hide"  ){
            if($search["_keyword"]){
                $condition_keyword = "";
                $condition_service = " AND ( ". $condition_keyword . ")";
            }
        }else{
        //高级搜索condition
           $condition_service = join_condition($condition_service,"@service.status",$search["status"],"int");
           $condition_service = join_condition($condition_service,"@service.service_group",$search["service_group"],"char");
           $condition_service = join_condition($condition_service,"@service.service_code",$search["service_code"],"char");
           $condition_service = join_condition($condition_service,"@service.service_name",$search["service_name"],"char","both");
           $condition_service = join_condition($condition_service,"@service.service_description",$search["service_description"],"char","both");
           $condition_service = join_condition2($condition_service,"@service.run_period",$search["run_period"],$search["run_period2"],"int");
           $condition_service = join_condition2($condition_service,"@service.allow_start_time",$search["allow_start_time"],$search["allow_start_time2"],"datetime");
           $condition_service = join_condition2($condition_service,"@service.allow_end_time",$search["allow_end_time"],$search["allow_end_time2"],"datetime");
           $condition_service = join_condition2($condition_service,"@service.next_run_time",$search["next_run_time"],$search["next_run_time2"],"datetime");
           $condition_service = join_condition2($condition_service,"@service.last_run_time",$search["last_run_time"],$search["last_run_time2"],"datetime");
        }
        $condition_service = $this->tabsheet_condition($condition_service ,$search["_tab"]);

        //select fields
        $selectfields="@service.status ";
        $selectfields.=",@service.id ";
        $selectfields.=",@service.service_group ";
        $selectfields.=",@service.service_code ";
        $selectfields.=",@service.service_name ";
        $selectfields.=",@service.service_description ";
        $selectfields.=",@service.run_period ";
        $selectfields.=",@service.allow_start_time ";
        $selectfields.=",@service.allow_end_time ";
        $selectfields.=",@service.sort ";
        $selectfields.=",@service.next_run_time ";
        $selectfields.=",@service.last_run_time ";
        $selectfields.=",@service.create_time ";


        $str_header = "";
        if ($show_list['status']==1 || empty($show_list)){
            $str_header .= "状态,";
        }
        if ($show_list['service_group']==1 || empty($show_list)){
            $str_header .= "分组,";
        }
        if ($show_list['service_code']==1 || empty($show_list)){
            $str_header .= "代码,";
        }
        if ($show_list['service_name']==1 || empty($show_list)){
            $str_header .= "名称,";
        }
        if ($show_list['service_description']==1 || empty($show_list)){
            $str_header .= "描述,";
        }
        if ($show_list['run_period']==1 || empty($show_list)){
            $str_header .= "间隔时间(分钟),";
        }
        if ($show_list['allow_start_time']==1 || empty($show_list)){
            $str_header .= "开始时间,";
        }
        if ($show_list['allow_end_time']==1 || empty($show_list)){
            $str_header .= "结束时间,";
        }
        if ($show_list['sort']==1 || empty($show_list)){
            $str_header .= "排序,";
        }
        if ($show_list['next_run_time']==1 || empty($show_list)){
            $str_header .= "下次运行时间,";
        }
        if ($show_list['last_run_time']==1 || empty($show_list)){
            $str_header .= "最近运行时间,";
        }
        if ($show_list['create_time']==1 || empty($show_list)){
            $str_header .= "创建时间,";
        }
        $str_header .= "\r\n";

        $join="";

       $count_sql = "select count(*) as cnt from @service  #join#  where 1=1 #condition#";  // ' for skip replace $condition
       $count_sql = str_replace("#join#",$join,$count_sql);
       $count_sql = str_replace("#condition#",$condition_service,$count_sql);

       $count_sql = table($count_sql);
       $count_sql = str_replace("·mailchar·","@",$count_sql);
       $count = M()->query($count_sql);
       $count = $count[0]["cnt"];

           $total_page=0;

        if(!$export_all) {
           $page_size = I("request.pagesize/d");
           $page_size = $page_size <= 0 ? session("ServiceSummary-PageSize") : $page_size;
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

        $orderby="order by @service.sort";
        //$orderby="";

    for ($p;$p<=$total_page;$p++)
    {

        $sql = "select #selectfields# from @service  #join# Where 1=1 #condition# #orderby#";   // ' for skip replace $selectfields,$condition,$orderby
        $sql = str_replace("#selectfields#",$selectfields,$sql);
        $sql = str_replace("#join#",$join,$sql);
        $sql = str_replace("#condition#",$condition_service,$sql);
        $sql = str_replace("#orderby#",$orderby,$sql);
        $sql .= " LIMIT ". (($p - 1) * $page_size). ", ".$page_size;

        $sql = table($sql);
        $sql = str_replace("·mailchar·","@",$sql);
        $list = M()->query($sql);

        foreach($list as $master) {
            $str_line="";
            if ($show_list['status']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Service_status("$master[status]","name"))."\t,";
            }
            if ($show_list['service_group']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["service_group"])."\t,";
            }
            if ($show_list['service_code']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["service_code"])."\t,";
            }
            if ($show_list['service_name']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["service_name"])."\t,";
            }
            if ($show_list['service_description']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["service_description"])."\t,";
            }
            if ($show_list['run_period']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("N3", $master["run_period"]))."\t,";
            }
            if ($show_list['allow_start_time']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("DT", $master["allow_start_time"]))."\t,";
            }
            if ($show_list['allow_end_time']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("DT", $master["allow_end_time"]))."\t,";
            }
            if ($show_list['sort']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("N", $master["sort"]))."\t,";
            }
            if ($show_list['next_run_time']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("DT", $master["next_run_time"]))."\t,";
            }
            if ($show_list['last_run_time']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("DT", $master["last_run_time"]))."\t,";
            }
            if ($show_list['create_time']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("DT", $master["create_time"]))."\t,";
            }
            $str_content .= $str_line . "\r\n";
        }
    }
        header('Content-Type: text/xls');
        header ("Content-type:application/vnd.ms-excel;charset=gbk" );
        $str = mb_convert_encoding("ServiceSummary", 'gbk', 'utf-8');
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
          case 'quxiao':
              break;
          default:
              $itab='all';
              break;
              $itab='wuxiao';
              break;
              $itab='youxiao';
              break;
              $itab='quxiao';
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
                 $scond="@service.status='0'";
                 break;
            case 'youxiao':  //有效
                 $scond="@service.status='1'";
                 break;
            case 'quxiao':  //取消
                 $scond="@service.status='8'";
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
            case 'quxiao':  //取消
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
        }
        return $condition ;
    }
}
