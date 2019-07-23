<?php namespace Summary\Controller;
//
//注释: CustomerRelaSummary - 客户关联关系列表
//
use Home\Controller\BasicController;
use Think\Log;
class CustomerRelaSummaryController extends BasicController {

    public function _init() {
        $funcs = $this->getUserRoleList($this->user,array( '/Home/CustomerRela', 'CustomerRelaSummary', ));
        if ($funcs)
            $this->assign("rights",  $funcs);
        else{
            $funcs = array(
                         array("key"=>"add","func"=>"/Home/CustomerRela","Action"=>"add") ,
                         array("key"=>"refresh","func"=>"CustomerRelaSummary","Action"=>"refresh") ,
                         array("key"=>"search","func"=>"CustomerRelaSummary","Action"=>"search") ,
                         array("key"=>"export","func"=>"CustomerRelaSummary","Action"=>"export") ,
                         array("key"=>"master_view","func"=>"/Home/CustomerRela","Action"=>"view") ,
                         array("key"=>"master_edit","func"=>"/Home/CustomerRela","Action"=>"edit") ,
                         array("key"=>"master_delete","func"=>"/Home/CustomerRela","Action"=>"delete") ,
                         array("key"=>"status_on","func"=>"/Home/CustomerRela","Action"=>"status_on") ,
                         array("key"=>"status_off","func"=>"/Home/CustomerRela","Action"=>"status_off")
             );
            $this->assign("rights",  $this->GetUserRights($this->user["id"],$funcs ));
        }
        $this->assign("colshow", $this->GetUserColumnDefine($this->user["id"],"CustomerRelaSummary"));
    }

    public function index() {
         try {
        $data["pfuncid"] = I("request.pfuncid");
        $data["funcid"] = I("request.funcid");
        $data["zindex"] = I("request.zindex/d");
        if(empty($data["funcid"])) $data["funcid"] = "CustomerRelaSummary";
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
          //$this->ajaxResult("客户关联关系列表后台错误");
          $this->ajaxResult($e->getMessage());
      }
    }


    private function columnsetting_define(){
        return array(
            'status'=>'状态',
            'code'=>'客户代码',
            'name'=>'客户简称',
            'rela_id'=>'关联',
            'customer_code'=>'客户代码',
            'customer_name'=>'客户简称',
            'type'=>'类型',
            'inner_code'=>'内部编码',
            'address'=>'联系地址',
            'phone'=>'联系电话',
            'linkman'=>'联系人员',
            'mobile'=>'联系手机',
            'create_time'=>'创建时间',
        );
    }

    private function columnsetting($data){
        $data['user_code']=session(C("USER_AUTH_KEY"));
        $data['summary']='CustomerRelaSummary';
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

        $this->ajaxResult("", "",  array("_asr.closeTab","_asr.closePopup", "_asr.openLink","_asr.hideMask()"), array("$('#".$data["funcid"]."-Tab').find('a'), '".$data["funcid"]."'","'".$data["funcid"]."'", "'". U("/Summary/CustomerRelaSummary/index?func=search&").  "','".filterFuncId("CustomerRelaSummary_Search","id=0")."','客户关联关系列表', 1",""));


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
       $search["customer_id_name"] = I("request.customer_id_name");
       $search["customer_id"] = I("request.customer_id");
       $search["code"] = I("request.code");
       $search["name"] = I("request.name");
       $search["rela_id"] = I("request.rela_id");
       $search["customer_code"] = I("request.customer_code");
       $search["customer_name"] = I("request.customer_name");
       $search["type"] = I("request.type");
       $search["inner_code"] = I("request.inner_code");
       $search["address"] = I("request.address");
       $search["phone"] = I("request.phone");
       $search["linkman"] = I("request.linkman");
       $search["mobile"] = I("request.mobile");
       $search["create_time"] = I("request.create_time");
       $search["create_time2"] = I("request.create_time2");

       //判断首次装载是否要赋予缺省值
       if($firstloading){
       }



       $condition="";
       $condition_customer_rela="";
       if($bsearch) {
           //关键字条件
           if($search["_showsearch"]=="hide"  ){
               if($search["_keyword"]){
                   $condition_keyword = "";
                   $condition_keyword = join_condition($condition_keyword,"a.code",$search["_keyword"],"char", "both" , 0, "" );
                   $condition_keyword = join_condition($condition_keyword,"a.name",$search["_keyword"],"char", "both" , 0, "OR" );
                   $condition_keyword = join_condition($condition_keyword,"b.code",$search["_keyword"],"char", "both" , 0, "OR" );
                   $condition_keyword = join_condition($condition_keyword,"b.name",$search["_keyword"],"char", "both" , 0, "OR" );
                   $condition_keyword = join_condition($condition_keyword,"@customer_rela.mobile",$search["_keyword"],"char", "both" , 0, "OR" );
                   $condition_customer_rela = " AND ( ". $condition_keyword .")";
               }
           }else{
               //高级搜索condition
               $condition_customer_rela = join_condition($condition_customer_rela,"@customer_rela.status",$search["status"],"int");
               $condition_customer_rela = join_condition($condition_customer_rela,"@customer_rela.customer_id",$search["customer_id"],"int");
               $condition_a = join_condition($condition_a,"a.code",$search["code"],"char");
               $condition_a = join_condition($condition_a,"a.name",$search["name"],"char","both");
               $condition_customer_rela = join_condition($condition_customer_rela,"@customer_rela.rela_id",$search["rela_id"],"int");
               $condition_b = join_condition($condition_b,"b.code",$search["customer_code"],"char");
               $condition_b = join_condition($condition_b,"b.name",$search["customer_name"],"char","both");
               $condition_customer_rela = join_condition($condition_customer_rela,"@customer_rela.type",$search["type"],"int");
               $condition_customer_rela = join_condition($condition_customer_rela,"@customer_rela.inner_code",$search["inner_code"],"char");
               $condition_customer_rela = join_condition($condition_customer_rela,"@customer_rela.address",$search["address"],"char","both");
               $condition_customer_rela = join_condition($condition_customer_rela,"@customer_rela.phone",$search["phone"],"char");
               $condition_customer_rela = join_condition($condition_customer_rela,"@customer_rela.linkman",$search["linkman"],"char");
               $condition_customer_rela = join_condition($condition_customer_rela,"@customer_rela.mobile",$search["mobile"],"char");
               $condition_customer_rela = join_condition2($condition_customer_rela,"@customer_rela.create_time",$search["create_time"],$search["create_time2"],"datetime");
           }

           //增加 tab 条件
           $condition_customer_rela = $this->tabsheet_condition($condition_customer_rela ,$search["_tab"]);
           //增加数据权限
       $auth_condition=$this->get_auth_condition();
       $condition_customer_rela = join_condition_auth($condition_customer_rela,$auth_condition,"");
           //select fields
           $selectfields=" @customer_rela.status ";
           $selectfields.=", @customer_rela.id ";
           $selectfields.=", @customer_rela.customer_id ";
           $selectfields.=", a.code ";
           $selectfields.=", a.name ";
           $selectfields.=", @customer_rela.rela_id ";
           $selectfields.=", b.code customer_code ";
           $selectfields.=", b.name customer_name ";
           $selectfields.=", @customer_rela.type ";
           $selectfields.=", @customer_rela.inner_code ";
           $selectfields.=", @customer_rela.address ";
           $selectfields.=", @customer_rela.phone ";
           $selectfields.=", @customer_rela.linkman ";
           $selectfields.=", @customer_rela.mobile ";
           $selectfields.=", @customer_rela.create_time ";


           $page_size = I("request.pagesize/d");
           if ($page_size<=0){
               $page_size = session("CustomerRelaSummary-PageSize");
               if (!$page_size) {
                    $page_size = 10;
               }
           }
           session("CustomerRelaSummary-PageSize", $page_size);


           $join="";
           if($condition_customer){
              $condition_customer_rela .= $condition_customer;
           }
           $count_sql = "select count(*) as cnt from @customer_rela LEFT JOIN @customer a ON a.id=@customer_rela.customer_id LEFT JOIN @customer b ON b.id=@customer_rela.rela_id  #join#  where 1=1 #condition#";  // ' for skip replace $condition
           $count_sql = str_replace("#join#",$join,$count_sql);
           $count_sql = str_replace("#condition#",$condition_customer_rela,$count_sql);
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
           $sql = "select #selectfields# from @customer_rela LEFT JOIN @customer a ON a.id=@customer_rela.customer_id LEFT JOIN @customer b ON b.id=@customer_rela.rela_id  #join# Where 1=1 #condition# #orderby#";
           $sql = str_replace("#selectfields#",$selectfields,$sql);
           $sql = str_replace("#join#",$join,$sql);
           $sql = str_replace("#condition#",$condition_customer_rela,$sql);
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
        $html = $this->fetch("CustomerRelaSummary:index");
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

        if(empty($data["funcid"])) $data["funcid"] = "CustomerRelaSummary";
        if(!$p){
           $p = 1;
           $export_all = 1;
        }

        $show_list = array();

        $data['summary']='CustomerRelaSummary';
        $usc = M('user_summary_column')->field("column")->where("user_code='%s' AND summary='%s' AND `show`='1'",array(session(C("USER_AUTH_KEY")),$data['summary']))->select();
        if($usc){
           foreach ($usc as $v) {
              $show_list[$v['column']]=1;
           }
        }

        $search["_tab"] = $this->tabsheet_check(I("request._tab"));
        $tab = $search["_tab"];

        $search["status"] = I("request.status");
        $search["customer_id_name"] = I("request.customer_id_name");
        $search["customer_id"] = I("request.customer_id");
        $search["code"] = I("request.code");
        $search["name"] = I("request.name");
        $search["rela_id"] = I("request.rela_id");
        $search["customer_code"] = I("request.customer_code");
        $search["customer_name"] = I("request.customer_name");
        $search["type"] = I("request.type");
        $search["inner_code"] = I("request.inner_code");
        $search["address"] = I("request.address");
        $search["phone"] = I("request.phone");
        $search["linkman"] = I("request.linkman");
        $search["mobile"] = I("request.mobile");
        $search["create_time"] = I("request.create_time");
        $search["create_time2"] = I("request.create_time2");


        //condition
        $condition="";
        $condition_customer_rela="";

        //读取关键字搜索内容
        $search["_keyword"] = I("request._keyword");
        if($search["_showsearch"]=="hide"  ){
            if($search["_keyword"]){
                $condition_keyword = "";
                $condition_keyword = join_condition($condition_keyword,"a.code",$search["_keyword"],"char", "both" , 0, "" );
                $condition_keyword = join_condition($condition_keyword,"a.name",$search["_keyword"],"char", "both" , 0, "OR" );
                $condition_keyword = join_condition($condition_keyword,"b.code",$search["_keyword"],"char", "both" , 0, "OR" );
                $condition_keyword = join_condition($condition_keyword,"b.name",$search["_keyword"],"char", "both" , 0, "OR" );
                $condition_keyword = join_condition($condition_keyword,"@customer_rela.mobile",$search["_keyword"],"char", "both" , 0, "OR" );
                $condition_customer_rela = " AND ( ". $condition_keyword . ")";
            }
        }else{
        //高级搜索condition
           $condition_customer_rela = join_condition($condition_customer_rela,"@customer_rela.status",$search["status"],"int");
           $condition_customer_rela = join_condition($condition_customer_rela,"@customer_rela.customer_id",$search["customer_id"],"int");
           $condition_a = join_condition($condition_a,"a.code",$search["code"],"char");
           $condition_a = join_condition($condition_a,"a.name",$search["name"],"char","both");
           $condition_customer_rela = join_condition($condition_customer_rela,"@customer_rela.rela_id",$search["rela_id"],"int");
           $condition_b = join_condition($condition_b,"b.code",$search["customer_code"],"char");
           $condition_b = join_condition($condition_b,"b.name",$search["customer_name"],"char","both");
           $condition_customer_rela = join_condition($condition_customer_rela,"@customer_rela.type",$search["type"],"int");
           $condition_customer_rela = join_condition($condition_customer_rela,"@customer_rela.inner_code",$search["inner_code"],"char");
           $condition_customer_rela = join_condition($condition_customer_rela,"@customer_rela.address",$search["address"],"char","both");
           $condition_customer_rela = join_condition($condition_customer_rela,"@customer_rela.phone",$search["phone"],"char");
           $condition_customer_rela = join_condition($condition_customer_rela,"@customer_rela.linkman",$search["linkman"],"char");
           $condition_customer_rela = join_condition($condition_customer_rela,"@customer_rela.mobile",$search["mobile"],"char");
           $condition_customer_rela = join_condition2($condition_customer_rela,"@customer_rela.create_time",$search["create_time"],$search["create_time2"],"datetime");
        }
        $condition_customer_rela = $this->tabsheet_condition($condition_customer_rela ,$search["_tab"]);
          $condition_customer_rela = join_condition_shop($condition_customer_rela,"3;@customer_rela.customer_id;customer_id",$this->user_shop_id,$search_auth_codes);

        //select fields
        $selectfields="@customer_rela.status ";
        $selectfields.=",@customer_rela.id ";
        $selectfields.=",@customer_rela.customer_id ";
        $selectfields.=",a.code ";
        $selectfields.=",a.name ";
        $selectfields.=",@customer_rela.rela_id ";
        $selectfields.=",b.code customer_code ";
        $selectfields.=",b.name customer_name ";
        $selectfields.=",@customer_rela.type ";
        $selectfields.=",@customer_rela.inner_code ";
        $selectfields.=",@customer_rela.address ";
        $selectfields.=",@customer_rela.phone ";
        $selectfields.=",@customer_rela.linkman ";
        $selectfields.=",@customer_rela.mobile ";
        $selectfields.=",@customer_rela.create_time ";


        $str_header = "";
        if ($show_list['status']==1 || empty($show_list)){
            $str_header .= "状态,";
        }
        if ($show_list['code']==1 || empty($show_list)){
            $str_header .= "客户代码,";
        }
        if ($show_list['name']==1 || empty($show_list)){
            $str_header .= "客户简称,";
        }
        if ($show_list['rela_id']==1 || empty($show_list)){
            $str_header .= "关联,";
        }
        if ($show_list['customer_code']==1 || empty($show_list)){
            $str_header .= "客户代码,";
        }
        if ($show_list['customer_name']==1 || empty($show_list)){
            $str_header .= "客户简称,";
        }
        if ($show_list['type']==1 || empty($show_list)){
            $str_header .= "类型,";
        }
        if ($show_list['inner_code']==1 || empty($show_list)){
            $str_header .= "内部编码,";
        }
        if ($show_list['address']==1 || empty($show_list)){
            $str_header .= "联系地址,";
        }
        if ($show_list['phone']==1 || empty($show_list)){
            $str_header .= "联系电话,";
        }
        if ($show_list['linkman']==1 || empty($show_list)){
            $str_header .= "联系人员,";
        }
        if ($show_list['mobile']==1 || empty($show_list)){
            $str_header .= "联系手机,";
        }
        if ($show_list['create_time']==1 || empty($show_list)){
            $str_header .= "创建时间,";
        }
        $str_header .= "\r\n";

        $join="";
        if($condition_customer){
            $condition_customer_rela .= $condition_customer;
        }

       $count_sql = "select count(*) as cnt from @customer_rela LEFT JOIN @customer a ON a.id=@customer_rela.customer_id LEFT JOIN @customer b ON b.id=@customer_rela.rela_id  #join#  where 1=1 #condition#";  // ' for skip replace $condition
       $count_sql = str_replace("#join#",$join,$count_sql);
       $count_sql = str_replace("#condition#",$condition_customer_rela,$count_sql);

       $count_sql = table($count_sql);
       $count_sql = str_replace("·mailchar·","@",$count_sql);
       $count = M()->query($count_sql);
       $count = $count[0]["cnt"];

           $total_page=0;

        if(!$export_all) {
           $page_size = I("request.pagesize/d");
           $page_size = $page_size <= 0 ? session("CustomerRelaSummary-PageSize") : $page_size;
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

        $sql = "select #selectfields# from @customer_rela LEFT JOIN @customer a ON a.id=@customer_rela.customer_id LEFT JOIN @customer b ON b.id=@customer_rela.rela_id  #join# Where 1=1 #condition# #orderby#";   // ' for skip replace $selectfields,$condition,$orderby
        $sql = str_replace("#selectfields#",$selectfields,$sql);
        $sql = str_replace("#join#",$join,$sql);
        $sql = str_replace("#condition#",$condition_customer_rela,$sql);
        $sql = str_replace("#orderby#",$orderby,$sql);
        $sql .= " LIMIT ". (($p - 1) * $page_size). ", ".$page_size;

        $sql = table($sql);
        $sql = str_replace("·mailchar·","@",$sql);
        $list = M()->query($sql);

        foreach($list as $master) {
            $str_line="";
            if ($show_list['status']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_CustomerRela_status("$master[status]","name"))."\t,";
            }
            if ($show_list['code']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["code"])."\t,";
            }
            if ($show_list['name']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["name"])."\t,";
            }
            if ($show_list['rela_id']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["rela_id"])."\t,";
            }
            if ($show_list['customer_code']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["customer_code"])."\t,";
            }
            if ($show_list['customer_name']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["customer_name"])."\t,";
            }
            if ($show_list['type']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_CustomerRela_type("$master[type]","name"))."\t,";
            }
            if ($show_list['inner_code']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["inner_code"])."\t,";
            }
            if ($show_list['address']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["address"])."\t,";
            }
            if ($show_list['phone']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["phone"])."\t,";
            }
            if ($show_list['linkman']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["linkman"])."\t,";
            }
            if ($show_list['mobile']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["mobile"])."\t,";
            }
            if ($show_list['create_time']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("DT", $master["create_time"]))."\t,";
            }
            $str_content .= $str_line . "\r\n";
        }
    }
        header('Content-Type: text/xls');
        header ("Content-type:application/vnd.ms-excel;charset=gbk" );
        $str = mb_convert_encoding("CustomerRelaSummary", 'gbk', 'utf-8');
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
                 $scond="@customer_rela.status='0'";
                 break;
            case 'youxiao':  //有效
                 $scond="@customer_rela.status='1'";
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
        case "3":
            $condition.=" @customer_rela.customer_id='".$this->user["customer_id"]."' ";
            break;
        }
        return $condition ;
    }
}