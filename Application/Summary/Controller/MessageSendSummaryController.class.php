<?php namespace Summary\Controller;
//
//注释: MessageSendSummary - 消息发送列表
//
use Home\Controller\BasicController;
use Think\Log;
class MessageSendSummaryController extends BasicController {

    public function _init() {
        $funcs = $this->getUserRoleList($this->user,array( 'MessageSendSummary', ));
        if ($funcs)
            $this->assign("rights",  $funcs);
        else{
            $funcs = array(
                         array("key"=>"refresh","func"=>"MessageSendSummary","Action"=>"refresh") ,
                         array("key"=>"search","func"=>"MessageSendSummary","Action"=>"search") ,
                         array("key"=>"export","func"=>"MessageSendSummary","Action"=>"export")
             );
            $this->assign("rights",  $this->GetUserRights($this->user["id"],$funcs ));
        }
        $this->assign("colshow", $this->GetUserColumnDefine($this->user["id"],"MessageSendSummary"));
    }

    public function index() {
         try {
        $data["pfuncid"] = I("request.pfuncid");
        $data["funcid"] = I("request.funcid");
        $data["zindex"] = I("request.zindex/d");
        if(empty($data["funcid"])) $data["funcid"] = "MessageSendSummary";
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
          //$this->ajaxResult("消息发送列表后台错误");
          $this->ajaxResult($e->getMessage());
      }
    }


    private function columnsetting_define(){
        return array(
            'status'=>'状态',
            'org_id'=>'库联',
            'user_id'=>'用户',
            'type'=>'信息类型',
            'send'=>'发送途径',
            'message_templet_code'=>'模板代码',
            'email'=>'邮箱',
            'mobile'=>'手机',
            'wechat_openid'=>'微信',
            'create_time'=>'创建时间',
        );
    }

    private function columnsetting($data){
        $data['user_code']=session(C("USER_AUTH_KEY"));
        $data['summary']='MessageSendSummary';
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

        $this->ajaxResult("", "",  array("_asr.closeTab","_asr.closePopup", "_asr.openLink","_asr.hideMask()"), array("$('#".$data["funcid"]."-Tab').find('a'), '".$data["funcid"]."'","'".$data["funcid"]."'", "'". U("/Summary/MessageSendSummary/index?func=search&").  "','".filterFuncId("MessageSendSummary_Search","id=0")."','消息发送列表', 1",""));


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
       $search["user_id"] = I("request.user_id");
       $search["type"] = I("request.type");
       $search["send"] = I("request.send");
       $search["message_templet_code"] = I("request.message_templet_code");
       $search["email"] = I("request.email");
       $search["mobile"] = I("request.mobile");
       $search["wechat_openid"] = I("request.wechat_openid");

       //判断首次装载是否要赋予缺省值
       if($firstloading){
       }



       $condition="";
       $condition_message_send="";
       if($bsearch) {
           //关键字条件
           if($search["_showsearch"]=="hide"  ){
               if($search["_keyword"]){
                   $condition_keyword = "";
                   $condition_keyword = join_condition($condition_keyword,"@message_send.mobile",$search["_keyword"],"char", "both" , 0, "" );
                   $condition_message_send = " AND ( ". $condition_keyword .")";
               }
           }else{
               //高级搜索condition
               $condition_message_send = join_condition($condition_message_send,"@message_send.status",$search["status"],"int");
               $condition_message_send = join_condition($condition_message_send,"@message_send.org_id",$search["org_id"],"int");
               $condition_message_send = join_condition($condition_message_send,"@message_send.user_id",$search["user_id"],"int");
               $condition_message_send = join_condition($condition_message_send,"@message_send.type",$search["type"],"int");
               $condition_message_send = join_condition($condition_message_send,"@message_send.send",$search["send"],"int");
               $condition_message_send = join_condition($condition_message_send,"@message_send.message_templet_code",$search["message_templet_code"],"char");
               $condition_message_send = join_condition($condition_message_send,"@message_send.email",$search["email"],"char");
               $condition_message_send = join_condition($condition_message_send,"@message_send.mobile",$search["mobile"],"char");
               $condition_message_send = join_condition($condition_message_send,"@message_send.wechat_openid",$search["wechat_openid"],"char","both");
           }

           //增加 tab 条件
           $condition_message_send = $this->tabsheet_condition($condition_message_send ,$search["_tab"]);
           //增加数据权限
       $auth_condition=$this->get_auth_condition();
       $condition_message_send = join_condition_auth($condition_message_send,$auth_condition,"");
           //select fields
           $selectfields=" @message_send.status ";
           $selectfields.=", @message_send.id ";
           $selectfields.=", @message_send.org_id ";
           $selectfields.=", @message_send.user_id ";
           $selectfields.=", @message_send.type ";
           $selectfields.=", @message_send.send ";
           $selectfields.=", @message_send.message_templet_code ";
           $selectfields.=", @message_send.email ";
           $selectfields.=", @message_send.mobile ";
           $selectfields.=", @message_send.wechat_openid ";
           $selectfields.=", @message_send.create_time ";


           $page_size = I("request.pagesize/d");
           if ($page_size<=0){
               $page_size = session("MessageSendSummary-PageSize");
               if (!$page_size) {
                    $page_size = 10;
               }
           }
           session("MessageSendSummary-PageSize", $page_size);


           $join="";
           $count_sql = "select count(*) as cnt from @message_send  #join#  where 1=1 #condition#";  // ' for skip replace $condition
           $count_sql = str_replace("#join#",$join,$count_sql);
           $count_sql = str_replace("#condition#",$condition_message_send,$count_sql);
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
           $sql = "select #selectfields# from @message_send  #join# Where 1=1 #condition# #orderby#";
           $sql = str_replace("#selectfields#",$selectfields,$sql);
           $sql = str_replace("#join#",$join,$sql);
           $sql = str_replace("#condition#",$condition_message_send,$sql);
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
        $html = $this->fetch("MessageSendSummary:index");
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

        if(empty($data["funcid"])) $data["funcid"] = "MessageSendSummary";
        if(!$p){
           $p = 1;
           $export_all = 1;
        }

        $show_list = array();

        $data['summary']='MessageSendSummary';
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
        $search["user_id"] = I("request.user_id");
        $search["type"] = I("request.type");
        $search["send"] = I("request.send");
        $search["message_templet_code"] = I("request.message_templet_code");
        $search["email"] = I("request.email");
        $search["mobile"] = I("request.mobile");
        $search["wechat_openid"] = I("request.wechat_openid");


        //condition
        $condition="";
        $condition_message_send="";

        //读取关键字搜索内容
        $search["_keyword"] = I("request._keyword");
        if($search["_showsearch"]=="hide"  ){
            if($search["_keyword"]){
                $condition_keyword = "";
                $condition_keyword = join_condition($condition_keyword,"@message_send.mobile",$search["_keyword"],"char", "both" , 0, "" );
                $condition_message_send = " AND ( ". $condition_keyword . ")";
            }
        }else{
        //高级搜索condition
           $condition_message_send = join_condition($condition_message_send,"@message_send.status",$search["status"],"int");

           $search_auth_codes = $search["org_id"];
           $condition_message_send = join_condition($condition_message_send,"@message_send.user_id",$search["user_id"],"int");
           $condition_message_send = join_condition($condition_message_send,"@message_send.type",$search["type"],"int");
           $condition_message_send = join_condition($condition_message_send,"@message_send.send",$search["send"],"int");
           $condition_message_send = join_condition($condition_message_send,"@message_send.message_templet_code",$search["message_templet_code"],"char");
           $condition_message_send = join_condition($condition_message_send,"@message_send.email",$search["email"],"char");
           $condition_message_send = join_condition($condition_message_send,"@message_send.mobile",$search["mobile"],"char");
           $condition_message_send = join_condition($condition_message_send,"@message_send.wechat_openid",$search["wechat_openid"],"char","both");
        }
        $condition_message_send = $this->tabsheet_condition($condition_message_send ,$search["_tab"]);
          $condition_message_send = join_condition_shop($condition_message_send,"2;@message_send.org_id;org_id",$this->user_shop_id,$search_auth_codes);

        //select fields
        $selectfields="@message_send.status ";
        $selectfields.=",@message_send.id ";
        $selectfields.=",@message_send.org_id ";
        $selectfields.=",@message_send.user_id ";
        $selectfields.=",@message_send.type ";
        $selectfields.=",@message_send.send ";
        $selectfields.=",@message_send.message_templet_code ";
        $selectfields.=",@message_send.email ";
        $selectfields.=",@message_send.mobile ";
        $selectfields.=",@message_send.wechat_openid ";
        $selectfields.=",@message_send.create_time ";


        $str_header = "";
        if ($show_list['status']==1 || empty($show_list)){
            $str_header .= "状态,";
        }
        if ($show_list['org_id']==1 || empty($show_list)){
            $str_header .= "库联,";
        }
        if ($show_list['user_id']==1 || empty($show_list)){
            $str_header .= "用户,";
        }
        if ($show_list['type']==1 || empty($show_list)){
            $str_header .= "信息类型,";
        }
        if ($show_list['send']==1 || empty($show_list)){
            $str_header .= "发送途径,";
        }
        if ($show_list['message_templet_code']==1 || empty($show_list)){
            $str_header .= "模板代码,";
        }
        if ($show_list['email']==1 || empty($show_list)){
            $str_header .= "邮箱,";
        }
        if ($show_list['mobile']==1 || empty($show_list)){
            $str_header .= "手机,";
        }
        if ($show_list['wechat_openid']==1 || empty($show_list)){
            $str_header .= "微信,";
        }
        if ($show_list['create_time']==1 || empty($show_list)){
            $str_header .= "创建时间,";
        }
        $str_header .= "\r\n";

        $join="";

       $count_sql = "select count(*) as cnt from @message_send  #join#  where 1=1 #condition#";  // ' for skip replace $condition
       $count_sql = str_replace("#join#",$join,$count_sql);
       $count_sql = str_replace("#condition#",$condition_message_send,$count_sql);

       $count_sql = table($count_sql);
       $count_sql = str_replace("·mailchar·","@",$count_sql);
       $count = M()->query($count_sql);
       $count = $count[0]["cnt"];

           $total_page=0;

        if(!$export_all) {
           $page_size = I("request.pagesize/d");
           $page_size = $page_size <= 0 ? session("MessageSendSummary-PageSize") : $page_size;
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

        $sql = "select #selectfields# from @message_send  #join# Where 1=1 #condition# #orderby#";   // ' for skip replace $selectfields,$condition,$orderby
        $sql = str_replace("#selectfields#",$selectfields,$sql);
        $sql = str_replace("#join#",$join,$sql);
        $sql = str_replace("#condition#",$condition_message_send,$sql);
        $sql = str_replace("#orderby#",$orderby,$sql);
        $sql .= " LIMIT ". (($p - 1) * $page_size). ", ".$page_size;

        $sql = table($sql);
        $sql = str_replace("·mailchar·","@",$sql);
        $list = M()->query($sql);

        foreach($list as $master) {
            $str_line="";
            if ($show_list['status']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_MessageSend_status("$master[status]","name"))."\t,";
            }
            if ($show_list['org_id']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Org_byID("$master[org_id]","name"))."\t,";
            }
            if ($show_list['user_id']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["user_id"])."\t,";
            }
            if ($show_list['type']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_MessageSend_type("$master[type]","name"))."\t,";
            }
            if ($show_list['send']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_MessageSend_send("$master[send]","name"))."\t,";
            }
            if ($show_list['message_templet_code']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["message_templet_code"])."\t,";
            }
            if ($show_list['email']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["email"])."\t,";
            }
            if ($show_list['mobile']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["mobile"])."\t,";
            }
            if ($show_list['wechat_openid']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["wechat_openid"])."\t,";
            }
            if ($show_list['create_time']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("DT", $master["create_time"]))."\t,";
            }
            $str_content .= $str_line . "\r\n";
        }
    }
        header('Content-Type: text/xls');
        header ("Content-type:application/vnd.ms-excel;charset=gbk" );
        $str = mb_convert_encoding("MessageSendSummary", 'gbk', 'utf-8');
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
          case 'weifasong':
          case 'yifasong':
          case 'yiquxiao':
              break;
          default:
              $itab='all';
              break;
              $itab='weifasong';
              break;
              $itab='yifasong';
              break;
              $itab='yiquxiao';
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
            case 'weifasong':  //未发送
                 $scond="@message_send.status='0'";
                 break;
            case 'yifasong':  //已发送
                 $scond="@message_send.status='1'";
                 break;
            case 'yiquxiao':  //已取消
                 $scond="@message_send.status='7'";
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
            case 'weifasong':  //未发送
                 break;
            case 'yifasong':  //已发送
                 break;
            case 'yiquxiao':  //已取消
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
            $condition.=" @message_send.org_id='".$this->user["org_id"]."' ";
            break;
        }
        return $condition ;
    }
}
