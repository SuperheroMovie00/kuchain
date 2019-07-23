<?php namespace Summary\Controller;
//
//注释: WarehouseSummary - 仓库信息列表
//
use Home\Controller\BasicController;
use Think\Log;
class WarehouseSummaryController extends BasicController {

    public function _init() {
        $funcs = $this->getUserRoleList($this->user,array( '/Home/Warehouse', 'WarehouseSummary', ));
        if ($funcs)
            $this->assign("rights",  $funcs);
        else{
            $funcs = array(
                         array("key"=>"add","func"=>"/Home/Warehouse","Action"=>"add") ,
                         array("key"=>"refresh","func"=>"WarehouseSummary","Action"=>"refresh") ,
                         array("key"=>"search","func"=>"WarehouseSummary","Action"=>"search") ,
                         array("key"=>"export","func"=>"WarehouseSummary","Action"=>"export") ,
                         array("key"=>"master_view","func"=>"/Home/Warehouse","Action"=>"view") ,
                         array("key"=>"master_edit","func"=>"/Home/Warehouse","Action"=>"edit") ,
                         array("key"=>"master_delete","func"=>"/Home/Warehouse","Action"=>"delete") ,
                         array("key"=>"status_on","func"=>"/Home/Warehouse","Action"=>"status_on") ,
                         array("key"=>"status_off","func"=>"/Home/Warehouse","Action"=>"status_off")
             );
            $this->assign("rights",  $this->GetUserRights($this->user["id"],$funcs ));
        }
        $this->assign("colshow", $this->GetUserColumnDefine($this->user["id"],"WarehouseSummary"));
    }

    public function index() {
         try {
        $data["pfuncid"] = I("request.pfuncid");
        $data["funcid"] = I("request.funcid");
        $data["zindex"] = I("request.zindex/d");
        if(empty($data["funcid"])) $data["funcid"] = "WarehouseSummary";
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
          //$this->ajaxResult("仓库信息列表后台错误");
          $this->ajaxResult($e->getMessage());
      }
    }


    private function columnsetting_define(){
        return array(
            'status'=>'状态',
            'org_id'=>'库联',
            'code'=>'仓库编码',
            'name'=>'仓库名称',
            'abbr'=>'缩写',
            'phone'=>'联系电话',
            'contacts'=>'联系人员',
            'address'=>'联系地址',
            'create_time'=>'创建时间',
        );
    }

    private function columnsetting($data){
        $data['user_code']=session(C("USER_AUTH_KEY"));
        $data['summary']='WarehouseSummary';
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

        $this->ajaxResult("", "",  array("_asr.closeTab","_asr.closePopup", "_asr.openLink","_asr.hideMask()"), array("$('#".$data["funcid"]."-Tab').find('a'), '".$data["funcid"]."'","'".$data["funcid"]."'", "'". U("/Summary/WarehouseSummary/index?func=search&").  "','".filterFuncId("WarehouseSummary_Search","id=0")."','仓库信息列表', 1",""));


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
       $search["code"] = I("request.code");
       $search["name"] = I("request.name");
       $search["abbr"] = I("request.abbr");
       $search["phone"] = I("request.phone");
       $search["contacts"] = I("request.contacts");
       $search["address"] = I("request.address");
       $search["create_time"] = I("request.create_time");
       $search["create_time2"] = I("request.create_time2");

       //判断首次装载是否要赋予缺省值
       if($firstloading){
       }



       $condition="";
       $condition_warehouse="";
       if($bsearch) {
           //关键字条件
           if($search["_showsearch"]=="hide"  ){
               if($search["_keyword"]){
                   $condition_keyword = "";
                   $condition_keyword = join_condition($condition_keyword,"@warehouse.code",$search["_keyword"],"char", "both" , 0, "" );
                   $condition_keyword = join_condition($condition_keyword,"@warehouse.name",$search["_keyword"],"char", "both" , 0, "OR" );
                   $condition_warehouse = " AND ( ". $condition_keyword .")";
               }
           }else{
               //高级搜索condition
               $condition_warehouse = join_condition($condition_warehouse,"@warehouse.status",$search["status"],"int");
               $condition_warehouse = join_condition($condition_warehouse,"@warehouse.org_id",$search["org_id"],"int");
               $condition_warehouse = join_condition($condition_warehouse,"@warehouse.code",$search["code"],"char");
               $condition_warehouse = join_condition($condition_warehouse,"@warehouse.name",$search["name"],"char","both");
               $condition_warehouse = join_condition($condition_warehouse,"@warehouse.abbr",$search["abbr"],"char");
               $condition_warehouse = join_condition($condition_warehouse,"@warehouse.phone",$search["phone"],"char");
               $condition_warehouse = join_condition($condition_warehouse,"@warehouse.contacts",$search["contacts"],"char");
               $condition_warehouse = join_condition($condition_warehouse,"@warehouse.address",$search["address"],"char","both");
               $condition_warehouse = join_condition2($condition_warehouse,"@warehouse.create_time",$search["create_time"],$search["create_time2"],"datetime");
           }

           //增加 tab 条件
           $condition_warehouse = $this->tabsheet_condition($condition_warehouse ,$search["_tab"]);
           //增加数据权限
       $auth_condition=$this->get_auth_condition();
       $condition_warehouse = join_condition_auth($condition_warehouse,$auth_condition,"");
           //select fields
           $selectfields=" @warehouse.status ";
           $selectfields.=", @warehouse.id ";
           $selectfields.=", @warehouse.org_id ";
           $selectfields.=", @warehouse.code ";
           $selectfields.=", @warehouse.name ";
           $selectfields.=", @warehouse.abbr ";
           $selectfields.=", @warehouse.phone ";
           $selectfields.=", @warehouse.contacts ";
           $selectfields.=", @warehouse.address ";
           $selectfields.=", @warehouse.create_time ";


           $page_size = I("request.pagesize/d");
           if ($page_size<=0){
               $page_size = session("WarehouseSummary-PageSize");
               if (!$page_size) {
                    $page_size = 10;
               }
           }
           session("WarehouseSummary-PageSize", $page_size);


           $join="";
           $count_sql = "select count(*) as cnt from @warehouse  #join#  where 1=1 #condition#";  // ' for skip replace $condition
           $count_sql = str_replace("#join#",$join,$count_sql);
           $count_sql = str_replace("#condition#",$condition_warehouse,$count_sql);
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
           $sql = "select #selectfields# from @warehouse  #join# Where 1=1 #condition# #orderby#";
           $sql = str_replace("#selectfields#",$selectfields,$sql);
           $sql = str_replace("#join#",$join,$sql);
           $sql = str_replace("#condition#",$condition_warehouse,$sql);
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
        $html = $this->fetch("WarehouseSummary:index");
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

        if(empty($data["funcid"])) $data["funcid"] = "WarehouseSummary";
        if(!$p){
           $p = 1;
           $export_all = 1;
        }

        $show_list = array();

        $data['summary']='WarehouseSummary';
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
        $search["code"] = I("request.code");
        $search["name"] = I("request.name");
        $search["abbr"] = I("request.abbr");
        $search["phone"] = I("request.phone");
        $search["contacts"] = I("request.contacts");
        $search["address"] = I("request.address");
        $search["create_time"] = I("request.create_time");
        $search["create_time2"] = I("request.create_time2");


        //condition
        $condition="";
        $condition_warehouse="";

        //读取关键字搜索内容
        $search["_keyword"] = I("request._keyword");
        if($search["_showsearch"]=="hide"  ){
            if($search["_keyword"]){
                $condition_keyword = "";
                $condition_keyword = join_condition($condition_keyword,"@warehouse.code",$search["_keyword"],"char", "both" , 0, "" );
                $condition_keyword = join_condition($condition_keyword,"@warehouse.name",$search["_keyword"],"char", "both" , 0, "OR" );
                $condition_warehouse = " AND ( ". $condition_keyword . ")";
            }
        }else{
        //高级搜索condition
           $condition_warehouse = join_condition($condition_warehouse,"@warehouse.status",$search["status"],"int");

           $search_auth_codes = $search["org_id"];
           $condition_warehouse = join_condition($condition_warehouse,"@warehouse.code",$search["code"],"char");
           $condition_warehouse = join_condition($condition_warehouse,"@warehouse.name",$search["name"],"char","both");
           $condition_warehouse = join_condition($condition_warehouse,"@warehouse.abbr",$search["abbr"],"char");
           $condition_warehouse = join_condition($condition_warehouse,"@warehouse.phone",$search["phone"],"char");
           $condition_warehouse = join_condition($condition_warehouse,"@warehouse.contacts",$search["contacts"],"char");
           $condition_warehouse = join_condition($condition_warehouse,"@warehouse.address",$search["address"],"char","both");
           $condition_warehouse = join_condition2($condition_warehouse,"@warehouse.create_time",$search["create_time"],$search["create_time2"],"datetime");
        }
        $condition_warehouse = $this->tabsheet_condition($condition_warehouse ,$search["_tab"]);
          $condition_warehouse = join_condition_shop($condition_warehouse,"2;@warehouse.org_id;org_id",$this->user_shop_id,$search_auth_codes);

        //select fields
        $selectfields="@warehouse.status ";
        $selectfields.=",@warehouse.id ";
        $selectfields.=",@warehouse.org_id ";
        $selectfields.=",@warehouse.code ";
        $selectfields.=",@warehouse.name ";
        $selectfields.=",@warehouse.abbr ";
        $selectfields.=",@warehouse.phone ";
        $selectfields.=",@warehouse.contacts ";
        $selectfields.=",@warehouse.address ";
        $selectfields.=",@warehouse.create_time ";


        $str_header = "";
        if ($show_list['status']==1 || empty($show_list)){
            $str_header .= "状态,";
        }
        if ($show_list['org_id']==1 || empty($show_list)){
            $str_header .= "库联,";
        }
        if ($show_list['code']==1 || empty($show_list)){
            $str_header .= "仓库编码,";
        }
        if ($show_list['name']==1 || empty($show_list)){
            $str_header .= "仓库名称,";
        }
        if ($show_list['abbr']==1 || empty($show_list)){
            $str_header .= "缩写,";
        }
        if ($show_list['phone']==1 || empty($show_list)){
            $str_header .= "联系电话,";
        }
        if ($show_list['contacts']==1 || empty($show_list)){
            $str_header .= "联系人员,";
        }
        if ($show_list['address']==1 || empty($show_list)){
            $str_header .= "联系地址,";
        }
        if ($show_list['create_time']==1 || empty($show_list)){
            $str_header .= "创建时间,";
        }
        $str_header .= "\r\n";

        $join="";

       $count_sql = "select count(*) as cnt from @warehouse  #join#  where 1=1 #condition#";  // ' for skip replace $condition
       $count_sql = str_replace("#join#",$join,$count_sql);
       $count_sql = str_replace("#condition#",$condition_warehouse,$count_sql);

       $count_sql = table($count_sql);
       $count_sql = str_replace("·mailchar·","@",$count_sql);
       $count = M()->query($count_sql);
       $count = $count[0]["cnt"];

           $total_page=0;

        if(!$export_all) {
           $page_size = I("request.pagesize/d");
           $page_size = $page_size <= 0 ? session("WarehouseSummary-PageSize") : $page_size;
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

        $sql = "select #selectfields# from @warehouse  #join# Where 1=1 #condition# #orderby#";   // ' for skip replace $selectfields,$condition,$orderby
        $sql = str_replace("#selectfields#",$selectfields,$sql);
        $sql = str_replace("#join#",$join,$sql);
        $sql = str_replace("#condition#",$condition_warehouse,$sql);
        $sql = str_replace("#orderby#",$orderby,$sql);
        $sql .= " LIMIT ". (($p - 1) * $page_size). ", ".$page_size;

        $sql = table($sql);
        $sql = str_replace("·mailchar·","@",$sql);
        $list = M()->query($sql);

        foreach($list as $master) {
            $str_line="";
            if ($show_list['status']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Warehouse_status("$master[status]","name"))."\t,";
            }
            if ($show_list['org_id']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Org_byID("$master[org_id]","name"))."\t,";
            }
            if ($show_list['code']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["code"])."\t,";
            }
            if ($show_list['name']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["name"])."\t,";
            }
            if ($show_list['abbr']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["abbr"])."\t,";
            }
            if ($show_list['phone']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["phone"])."\t,";
            }
            if ($show_list['contacts']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["contacts"])."\t,";
            }
            if ($show_list['address']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["address"])."\t,";
            }
            if ($show_list['create_time']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("DT", $master["create_time"]))."\t,";
            }
            $str_content .= $str_line . "\r\n";
        }
    }
        header('Content-Type: text/xls');
        header ("Content-type:application/vnd.ms-excel;charset=gbk" );
        $str = mb_convert_encoding("WarehouseSummary", 'gbk', 'utf-8');
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
                 $scond="@warehouse.status='0'";
                 break;
            case 'youxiao':  //有效
                 $scond="@warehouse.status='1'";
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
            $condition.=" @warehouse.org_id='".$this->user["org_id"]."' ";
            break;
        }
        return $condition ;
    }
}
