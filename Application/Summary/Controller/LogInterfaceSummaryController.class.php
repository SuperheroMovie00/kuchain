<?php namespace Summary\Controller;
//
//注释: LogInterfaceSummary - 接口日志列表
//
use Home\Controller\BasicController;
use Think\Log;
class LogInterfaceSummaryController extends BasicController {

    public function _init() {
        $funcs = $this->getUserRoleList($this->user,array( 'LogInterfaceSummary', ));
        if ($funcs)
            $this->assign("rights",  $funcs);
        else{
            $funcs = array(
                         array("key"=>"refresh","func"=>"LogInterfaceSummary","Action"=>"refresh") ,
                         array("key"=>"search","func"=>"LogInterfaceSummary","Action"=>"search") ,
                         array("key"=>"export","func"=>"LogInterfaceSummary","Action"=>"export")
             );
            $this->assign("rights",  $this->GetUserRights($this->user["id"],$funcs ));
        }
        $this->assign("colshow", $this->GetUserColumnDefine($this->user["id"],"LogInterfaceSummary"));
    }

    public function index() {
         try {
        $data["pfuncid"] = I("request.pfuncid");
        $data["funcid"] = I("request.funcid");
        $data["zindex"] = I("request.zindex/d");
        if(empty($data["funcid"])) $data["funcid"] = "LogInterfaceSummary";
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
          //$this->ajaxResult("接口日志列表后台错误");
          $this->ajaxResult($e->getMessage());
      }
    }


    private function columnsetting_define(){
        return array(
            'status'=>'处理状态',
            'org_id'=>'库联',
            'type'=>'类型',
            'tx_time'=>'处理时间',
            'data_file'=>'接口文件',
        );
    }

    private function columnsetting($data){
        $data['user_code']=session(C("USER_AUTH_KEY"));
        $data['summary']='LogInterfaceSummary';
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

        $this->ajaxResult("", "",  array("_asr.closeTab","_asr.closePopup", "_asr.openLink","_asr.hideMask()"), array("$('#".$data["funcid"]."-Tab').find('a'), '".$data["funcid"]."'","'".$data["funcid"]."'", "'". U("/Summary/LogInterfaceSummary/index?func=search&").  "','".filterFuncId("LogInterfaceSummary_Search","id=0")."','接口日志列表', 1",""));


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
       $search["type"] = I("request.type");
       $search["tx_time"] = I("request.tx_time");
       $search["tx_time2"] = I("request.tx_time2");
       $search["data_file"] = I("request.data_file");

       //判断首次装载是否要赋予缺省值
       if($firstloading){
       }



       $condition="";
       $condition_log_interface="";
       if($bsearch) {
           //关键字条件
           if($search["_showsearch"]=="hide"  ){
               if($search["_keyword"]){
                   $condition_keyword = "";
                   $condition_log_interface = " AND ( ". $condition_keyword .")";
               }
           }else{
               //高级搜索condition
               $condition_log_interface = join_condition($condition_log_interface,"@log_interface.status",$search["status"],"int");
               $condition_log_interface = join_condition($condition_log_interface,"@log_interface.org_id",$search["org_id"],"int");
               $condition_log_interface = join_condition($condition_log_interface,"@log_interface.type",$search["type"],"char");
               $condition_log_interface = join_condition2($condition_log_interface,"@log_interface.tx_time",$search["tx_time"],$search["tx_time2"],"datetime");
               $condition_log_interface = join_condition($condition_log_interface,"@log_interface.data_file",$search["data_file"],"char","both");
           }

           //增加 tab 条件
           $condition_log_interface = $this->tabsheet_condition($condition_log_interface ,$search["_tab"]);
           //增加数据权限
       $auth_condition=$this->get_auth_condition();
       $condition_log_interface = join_condition_auth($condition_log_interface,$auth_condition,"");
           //select fields
           $selectfields=" @log_interface.status ";
           $selectfields.=", @log_interface.id ";
           $selectfields.=", @log_interface.org_id ";
           $selectfields.=", @log_interface.type ";
           $selectfields.=", @log_interface.tx_time ";
           $selectfields.=", @log_interface.data_file ";


           $page_size = I("request.pagesize/d");
           if ($page_size<=0){
               $page_size = session("LogInterfaceSummary-PageSize");
               if (!$page_size) {
                    $page_size = 10;
               }
           }
           session("LogInterfaceSummary-PageSize", $page_size);


           $join="";
           $count_sql = "select count(*) as cnt from @log_interface  #join#  where 1=1 #condition#";  // ' for skip replace $condition
           $count_sql = str_replace("#join#",$join,$count_sql);
           $count_sql = str_replace("#condition#",$condition_log_interface,$count_sql);
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
           $sql = "select #selectfields# from @log_interface  #join# Where 1=1 #condition# #orderby#";
           $sql = str_replace("#selectfields#",$selectfields,$sql);
           $sql = str_replace("#join#",$join,$sql);
           $sql = str_replace("#condition#",$condition_log_interface,$sql);
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
        $html = $this->fetch("LogInterfaceSummary:index");
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

        if(empty($data["funcid"])) $data["funcid"] = "LogInterfaceSummary";
        if(!$p){
           $p = 1;
           $export_all = 1;
        }

        $show_list = array();

        $data['summary']='LogInterfaceSummary';
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
        $search["type"] = I("request.type");
        $search["tx_time"] = I("request.tx_time");
        $search["tx_time2"] = I("request.tx_time2");
        $search["data_file"] = I("request.data_file");


        //condition
        $condition="";
        $condition_log_interface="";

        //读取关键字搜索内容
        $search["_keyword"] = I("request._keyword");
        if($search["_showsearch"]=="hide"  ){
            if($search["_keyword"]){
                $condition_keyword = "";
                $condition_log_interface = " AND ( ". $condition_keyword . ")";
            }
        }else{
        //高级搜索condition
           $condition_log_interface = join_condition($condition_log_interface,"@log_interface.status",$search["status"],"int");

           $search_auth_codes = $search["org_id"];
           $condition_log_interface = join_condition($condition_log_interface,"@log_interface.type",$search["type"],"char");
           $condition_log_interface = join_condition2($condition_log_interface,"@log_interface.tx_time",$search["tx_time"],$search["tx_time2"],"datetime");
           $condition_log_interface = join_condition($condition_log_interface,"@log_interface.data_file",$search["data_file"],"char","both");
        }
        $condition_log_interface = $this->tabsheet_condition($condition_log_interface ,$search["_tab"]);
          $condition_log_interface = join_condition_shop($condition_log_interface,"2;@log_interface.org_id;org_id",$this->user_shop_id,$search_auth_codes);

        //select fields
        $selectfields="@log_interface.status ";
        $selectfields.=",@log_interface.id ";
        $selectfields.=",@log_interface.org_id ";
        $selectfields.=",@log_interface.type ";
        $selectfields.=",@log_interface.tx_time ";
        $selectfields.=",@log_interface.data_file ";


        $str_header = "";
        if ($show_list['status']==1 || empty($show_list)){
            $str_header .= "处理状态,";
        }
        if ($show_list['org_id']==1 || empty($show_list)){
            $str_header .= "库联,";
        }
        if ($show_list['type']==1 || empty($show_list)){
            $str_header .= "类型,";
        }
        if ($show_list['tx_time']==1 || empty($show_list)){
            $str_header .= "处理时间,";
        }
        if ($show_list['data_file']==1 || empty($show_list)){
            $str_header .= "接口文件,";
        }
        $str_header .= "\r\n";

        $join="";

       $count_sql = "select count(*) as cnt from @log_interface  #join#  where 1=1 #condition#";  // ' for skip replace $condition
       $count_sql = str_replace("#join#",$join,$count_sql);
       $count_sql = str_replace("#condition#",$condition_log_interface,$count_sql);

       $count_sql = table($count_sql);
       $count_sql = str_replace("·mailchar·","@",$count_sql);
       $count = M()->query($count_sql);
       $count = $count[0]["cnt"];

           $total_page=0;

        if(!$export_all) {
           $page_size = I("request.pagesize/d");
           $page_size = $page_size <= 0 ? session("LogInterfaceSummary-PageSize") : $page_size;
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

        $sql = "select #selectfields# from @log_interface  #join# Where 1=1 #condition# #orderby#";   // ' for skip replace $selectfields,$condition,$orderby
        $sql = str_replace("#selectfields#",$selectfields,$sql);
        $sql = str_replace("#join#",$join,$sql);
        $sql = str_replace("#condition#",$condition_log_interface,$sql);
        $sql = str_replace("#orderby#",$orderby,$sql);
        $sql .= " LIMIT ". (($p - 1) * $page_size). ", ".$page_size;

        $sql = table($sql);
        $sql = str_replace("·mailchar·","@",$sql);
        $list = M()->query($sql);

        foreach($list as $master) {
            $str_line="";
            if ($show_list['status']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_LogInterface_status("$master[status]","name"))."\t,";
            }
            if ($show_list['org_id']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Org_byID("$master[org_id]","name"))."\t,";
            }
            if ($show_list['type']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["type"])."\t,";
            }
            if ($show_list['tx_time']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("DT", $master["tx_time"]))."\t,";
            }
            if ($show_list['data_file']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["data_file"])."\t,";
            }
            $str_content .= $str_line . "\r\n";
        }
    }
        header('Content-Type: text/xls');
        header ("Content-type:application/vnd.ms-excel;charset=gbk" );
        $str = mb_convert_encoding("LogInterfaceSummary", 'gbk', 'utf-8');
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
          case 'weichuli':
          case 'chenggong':
          case 'shibai':
              break;
          default:
              $itab='all';
              break;
              $itab='weichuli';
              break;
              $itab='chenggong';
              break;
              $itab='shibai';
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
            case 'weichuli':  //未处理
                 $scond="@log_interface.status='0'";
                 break;
            case 'chenggong':  //成功
                 $scond="@log_interface.status='1'";
                 break;
            case 'shibai':  //失败
                 $scond="@log_interface.status='2'";
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
            case 'weichuli':  //未处理
                 break;
            case 'chenggong':  //成功
                 break;
            case 'shibai':  //失败
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
            $condition.=" @log_interface.org_id='".$this->user["org_id"]."' ";
            break;
        }
        return $condition ;
    }
}
