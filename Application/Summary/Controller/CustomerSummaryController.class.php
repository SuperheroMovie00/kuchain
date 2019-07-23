<?php namespace Summary\Controller;
//
//注释: CustomerSummary - 客户信息列表
//
use Home\Controller\BasicController;
use Think\Log;
class CustomerSummaryController extends BasicController {

    public function _init() {
        $funcs = $this->getUserRoleList($this->user,array( '/Home/Customer', 'CustomerSummary', ));
        if ($funcs)
            $this->assign("rights",  $funcs);
        else{
            $funcs = array(
                         array("key"=>"add","func"=>"/Home/Customer","Action"=>"add") ,
                         array("key"=>"import","func"=>"/Home/Customer","Action"=>"import") ,
                         array("key"=>"refresh","func"=>"CustomerSummary","Action"=>"refresh") ,
                         array("key"=>"search","func"=>"CustomerSummary","Action"=>"search") ,
                         array("key"=>"export","func"=>"CustomerSummary","Action"=>"export") ,
                         array("key"=>"master_view","func"=>"/Home/Customer","Action"=>"view") ,
                         array("key"=>"master_edit","func"=>"/Home/Customer","Action"=>"edit") ,
                         array("key"=>"master_delete","func"=>"/Home/Customer","Action"=>"delete") ,
                         array("key"=>"status_on","func"=>"/Home/Customer","Action"=>"status_on") ,
                         array("key"=>"status_off","func"=>"/Home/Customer","Action"=>"status_off")
             );
            $this->assign("rights",  $this->GetUserRights($this->user["id"],$funcs ));
        }
        $this->assign("colshow", $this->GetUserColumnDefine($this->user["id"],"CustomerSummary"));
    }

    public function index() {
         try {
        $data["pfuncid"] = I("request.pfuncid");
        $data["funcid"] = I("request.funcid");
        $data["zindex"] = I("request.zindex/d");
        if(empty($data["funcid"])) $data["funcid"] = "CustomerSummary";
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
          //$this->ajaxResult("客户信息列表后台错误");
          $this->ajaxResult($e->getMessage());
      }
    }


    private function columnsetting_define(){
        return array(
            'status'=>'状态',
            'category_code'=>'客户分类',
            'industry_code'=>'行业分类',
            'code'=>'客户代码',
            'name'=>'客户简称',
            'full_name'=>'客户全称',
            'prefix'=>'助记码',
            'abbr'=>'缩写',
            'customer_name'=>'上级名称',
            'customer_level'=>'层级',
            'province'=>'省份',
            'address'=>'联系地址',
            'postcode'=>'邮政编码',
            'phone'=>'联系电话',
            'linkman'=>'联系人员',
            'mobile'=>'联系手机',
            'corpbusicode'=>'营业执照号',
            'corptaxcode'=>'税务登记证',
            'legalpername'=>'法人姓名',
            'legalperidtype'=>'法人证件类型',
            'legalperidno'=>'法人证件号码',
            'contactname'=>'联系人姓名',
            'contactidtype'=>'联系人证件类型',
            'contactidno'=>'联系人证件号码',
            'contactmobile'=>'联系人手机',
            'openbank'=>'开户银行',
            'openacctno'=>'开户账户号',
            'openacctname'=>'开户账户名',
            'chinapay_userid'=>'银联账户号',
            'invoice_flag'=>'发票要求',
            'invoice_company'=>'开票单位',
            'invoice_address'=>'开票地址',
            'invoice_phone'=>'开票电话',
            'invoice_bank'=>'开票银行',
            'invoice_account'=>'开票账户',
            'invoice_taxno'=>'开票税号',
            'invoice_email'=>'电子票邮箱',
            'invoice_mobile'=>'电子票手机',
            'contract_linkman'=>'合同联系人员',
            'contract_phone'=>'合同联系电话',
            'contract_fax'=>'合同联系传真',
            'contract_address'=>'合同邮寄地址',
            'feesett_linkman'=>'结算联系人员',
            'feesett_phone'=>'结算联系电话',
            'feesett_fax'=>'结算联系传真',
            'feesett_address'=>'结算对账单寄',
            'sms_open'=>'短信服务',
            'sms_transfer_out'=>'货权转出通知',
            'sms_transfer_in'=>'货权转入通知',
            'sms_delivery'=>'提货时通知',
            'sms_phone'=>'接收手机号',
            'sms_appellation'=>'接收者称呼',
            'apply_time'=>'申请时间',
            'apply_user'=>'申请人员',
            'apply_times'=>'申请次数',
            'reply_time'=>'回复时间',
            'reply_user'=>'回复人员',
            'reply_status'=>'回复状态',
            'lock_status'=>'锁定状态',
            'create_time'=>'创建时间',
        );
    }

    private function columnsetting($data){
        $data['user_code']=session(C("USER_AUTH_KEY"));
        $data['summary']='CustomerSummary';
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

        $this->ajaxResult("", "",  array("_asr.closeTab","_asr.closePopup", "_asr.openLink","_asr.hideMask()"), array("$('#".$data["funcid"]."-Tab').find('a'), '".$data["funcid"]."'","'".$data["funcid"]."'", "'". U("/Summary/CustomerSummary/index?func=search&").  "','".filterFuncId("CustomerSummary_Search","id=0")."','客户信息列表', 1",""));


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
       $search["category_code_name"] = I("request.category_code_name");
       $search["category_code"] = I("request.category_code");
       $search["industry_code"] = I("request.industry_code");
       $search["code"] = I("request.code");
       $search["name"] = I("request.name");
       $search["full_name"] = I("request.full_name");
       $search["prefix"] = I("request.prefix");
       $search["abbr"] = I("request.abbr");
       $search["customer_name"] = I("request.customer_name");
       $search["customer_level"] = I("request.customer_level");
       $search["province"] = I("request.province");
       $search["address"] = I("request.address");
       $search["postcode"] = I("request.postcode");
       $search["phone"] = I("request.phone");
       $search["linkman"] = I("request.linkman");
       $search["mobile"] = I("request.mobile");
       $search["corpbusicode"] = I("request.corpbusicode");
       $search["corptaxcode"] = I("request.corptaxcode");
       $search["legalpername"] = I("request.legalpername");
       $search["legalperidtype"] = I("request.legalperidtype");
       $search["legalperidno"] = I("request.legalperidno");
       $search["contactname"] = I("request.contactname");
       $search["contactidtype"] = I("request.contactidtype");
       $search["contactidno"] = I("request.contactidno");
       $search["contactmobile"] = I("request.contactmobile");
       $search["openbank"] = I("request.openbank");
       $search["openacctno"] = I("request.openacctno");
       $search["openacctname"] = I("request.openacctname");
       $search["chinapay_userid"] = I("request.chinapay_userid");
       $search["invoice_flag"] = I("request.invoice_flag");
       $search["invoice_company"] = I("request.invoice_company");
       $search["invoice_address"] = I("request.invoice_address");
       $search["invoice_phone"] = I("request.invoice_phone");
       $search["invoice_bank"] = I("request.invoice_bank");
       $search["invoice_account"] = I("request.invoice_account");
       $search["invoice_taxno"] = I("request.invoice_taxno");
       $search["invoice_email"] = I("request.invoice_email");
       $search["invoice_mobile"] = I("request.invoice_mobile");
       $search["contract_linkman"] = I("request.contract_linkman");
       $search["contract_phone"] = I("request.contract_phone");
       $search["contract_fax"] = I("request.contract_fax");
       $search["contract_address"] = I("request.contract_address");
       $search["feesett_linkman"] = I("request.feesett_linkman");
       $search["feesett_phone"] = I("request.feesett_phone");
       $search["feesett_fax"] = I("request.feesett_fax");
       $search["feesett_address"] = I("request.feesett_address");
       $search["sms_open"] = I("request.sms_open");
       $search["sms_transfer_out"] = I("request.sms_transfer_out");
       $search["sms_transfer_in"] = I("request.sms_transfer_in");
       $search["sms_delivery"] = I("request.sms_delivery");
       $search["sms_phone"] = I("request.sms_phone");
       $search["sms_appellation"] = I("request.sms_appellation");
       $search["apply_time"] = I("request.apply_time");
       $search["apply_time2"] = I("request.apply_time2");
       $search["apply_user"] = I("request.apply_user");
       $search["apply_times"] = I("request.apply_times");
       $search["apply_times2"] = I("request.apply_times2");
       $search["reply_time"] = I("request.reply_time");
       $search["reply_time2"] = I("request.reply_time2");
       $search["reply_user"] = I("request.reply_user");
       $search["reply_status"] = I("request.reply_status");
       $search["lock_status"] = I("request.lock_status");

       //判断首次装载是否要赋予缺省值
       if($firstloading){
       }



       $condition="";
       $condition_customer="";
       if($bsearch) {
           //关键字条件
           if($search["_showsearch"]=="hide"  ){
               if($search["_keyword"]){
                   $condition_keyword = "";
                   $condition_keyword = join_condition($condition_keyword,"@customer.code",$search["_keyword"],"char", "both" , 0, "" );
                   $condition_keyword = join_condition($condition_keyword,"@customer.name",$search["_keyword"],"char", "both" , 0, "OR" );
                   $condition_keyword = join_condition($condition_keyword,"@customer.prefix",$search["_keyword"],"char", "both" , 0, "OR" );
                   $condition_keyword = join_condition($condition_keyword,"a.name",$search["_keyword"],"char", "both" , 0, "OR" );
                   $condition_keyword = join_condition($condition_keyword,"@customer.mobile",$search["_keyword"],"char", "both" , 0, "OR" );
                   $condition_customer = " AND ( ". $condition_keyword .")";
               }
           }else{
               //高级搜索condition
               $condition_customer = join_condition($condition_customer,"@customer.status",$search["status"],"int");
               $condition_customer = join_condition($condition_customer,"@customer.category_code",$search["category_code"],"char");
               $condition_customer = join_condition($condition_customer,"@customer.industry_code",$search["industry_code"],"char");
               $condition_customer = join_condition($condition_customer,"@customer.code",$search["code"],"char");
               $condition_customer = join_condition($condition_customer,"@customer.name",$search["name"],"char","both");
               $condition_customer = join_condition($condition_customer,"@customer.full_name",$search["full_name"],"char","both");
               $condition_customer = join_condition($condition_customer,"@customer.prefix",$search["prefix"],"char");
               $condition_customer = join_condition($condition_customer,"@customer.abbr",$search["abbr"],"char");
               $condition_a = join_condition($condition_a,"a.name",$search["customer_name"],"char","both");
               $condition_customer = join_condition($condition_customer,"@customer.customer_level",$search["customer_level"],"int");
               $condition_customer = join_condition($condition_customer,"@customer.province",$search["province"],"char");
               $condition_customer = join_condition($condition_customer,"@customer.address",$search["address"],"char","both");
               $condition_customer = join_condition($condition_customer,"@customer.postcode",$search["postcode"],"char");
               $condition_customer = join_condition($condition_customer,"@customer.phone",$search["phone"],"char");
               $condition_customer = join_condition($condition_customer,"@customer.linkman",$search["linkman"],"char");
               $condition_customer = join_condition($condition_customer,"@customer.mobile",$search["mobile"],"char");
               $condition_customer = join_condition($condition_customer,"@customer.corpbusicode",$search["corpbusicode"],"char");
               $condition_customer = join_condition($condition_customer,"@customer.corptaxcode",$search["corptaxcode"],"char");
               $condition_customer = join_condition($condition_customer,"@customer.legalpername",$search["legalpername"],"char");
               $condition_customer = join_condition($condition_customer,"@customer.legalperidtype",$search["legalperidtype"],"char");
               $condition_customer = join_condition($condition_customer,"@customer.legalperidno",$search["legalperidno"],"char");
               $condition_customer = join_condition($condition_customer,"@customer.contactname",$search["contactname"],"char");
               $condition_customer = join_condition($condition_customer,"@customer.contactidtype",$search["contactidtype"],"char");
               $condition_customer = join_condition($condition_customer,"@customer.contactidno",$search["contactidno"],"char");
               $condition_customer = join_condition($condition_customer,"@customer.contactmobile",$search["contactmobile"],"char");
               $condition_customer = join_condition($condition_customer,"@customer.openbank",$search["openbank"],"char");
               $condition_customer = join_condition($condition_customer,"@customer.openacctno",$search["openacctno"],"char");
               $condition_customer = join_condition($condition_customer,"@customer.openacctname",$search["openacctname"],"char","both");
               $condition_customer = join_condition($condition_customer,"@customer.chinapay_userid",$search["chinapay_userid"],"char");
               $condition_customer = join_condition($condition_customer,"@customer.invoice_flag",$search["invoice_flag"],"int");
               $condition_customer = join_condition($condition_customer,"@customer.invoice_company",$search["invoice_company"],"char","both");
               $condition_customer = join_condition($condition_customer,"@customer.invoice_address",$search["invoice_address"],"char","both");
               $condition_customer = join_condition($condition_customer,"@customer.invoice_phone",$search["invoice_phone"],"char");
               $condition_customer = join_condition($condition_customer,"@customer.invoice_bank",$search["invoice_bank"],"char");
               $condition_customer = join_condition($condition_customer,"@customer.invoice_account",$search["invoice_account"],"char");
               $condition_customer = join_condition($condition_customer,"@customer.invoice_taxno",$search["invoice_taxno"],"char");
               $condition_customer = join_condition($condition_customer,"@customer.invoice_email",$search["invoice_email"],"char","both");
               $condition_customer = join_condition($condition_customer,"@customer.invoice_mobile",$search["invoice_mobile"],"char");
               $condition_customer = join_condition($condition_customer,"@customer.contract_linkman",$search["contract_linkman"],"char");
               $condition_customer = join_condition($condition_customer,"@customer.contract_phone",$search["contract_phone"],"char");
               $condition_customer = join_condition($condition_customer,"@customer.contract_fax",$search["contract_fax"],"char");
               $condition_customer = join_condition($condition_customer,"@customer.contract_address",$search["contract_address"],"char","both");
               $condition_customer = join_condition($condition_customer,"@customer.feesett_linkman",$search["feesett_linkman"],"char");
               $condition_customer = join_condition($condition_customer,"@customer.feesett_phone",$search["feesett_phone"],"char");
               $condition_customer = join_condition($condition_customer,"@customer.feesett_fax",$search["feesett_fax"],"char");
               $condition_customer = join_condition($condition_customer,"@customer.feesett_address",$search["feesett_address"],"char","both");
               $condition_customer = join_condition($condition_customer,"@customer.sms_open",$search["sms_open"],"int");
               $condition_customer = join_condition($condition_customer,"@customer.sms_transfer_out",$search["sms_transfer_out"],"int");
               $condition_customer = join_condition($condition_customer,"@customer.sms_transfer_in",$search["sms_transfer_in"],"int");
               $condition_customer = join_condition($condition_customer,"@customer.sms_delivery",$search["sms_delivery"],"int");
               $condition_customer = join_condition($condition_customer,"@customer.sms_phone",$search["sms_phone"],"char");
               $condition_customer = join_condition($condition_customer,"@customer.sms_appellation",$search["sms_appellation"],"char");
               $condition_customer = join_condition2($condition_customer,"@customer.apply_time",$search["apply_time"],$search["apply_time2"],"datetime");
               $condition_customer = join_condition($condition_customer,"@customer.apply_user",$search["apply_user"],"char");
               $condition_customer = join_condition2($condition_customer,"@customer.apply_times",$search["apply_times"],$search["apply_times2"],"int");
               $condition_customer = join_condition2($condition_customer,"@customer.reply_time",$search["reply_time"],$search["reply_time2"],"datetime");
               $condition_customer = join_condition($condition_customer,"@customer.reply_user",$search["reply_user"],"char");
               $condition_customer = join_condition($condition_customer,"@customer.reply_status",$search["reply_status"],"int");
               $condition_customer = join_condition($condition_customer,"@customer.lock_status",$search["lock_status"],"int");
           }

           //增加 tab 条件
           $condition_customer = $this->tabsheet_condition($condition_customer ,$search["_tab"]);
           //增加数据权限
       $auth_condition=$this->get_auth_condition();
       $condition_customer = join_condition_auth($condition_customer,$auth_condition,"");
           //select fields
           $selectfields=" @customer.status ";
           $selectfields.=", @customer.id ";
           $selectfields.=", @customer.category_code ";
           $selectfields.=", @customer.industry_code ";
           $selectfields.=", @customer.code ";
           $selectfields.=", @customer.name ";
           $selectfields.=", @customer.full_name ";
           $selectfields.=", @customer.prefix ";
           $selectfields.=", @customer.abbr ";
           $selectfields.=", a.name customer_name ";
           $selectfields.=", @customer.customer_level ";
           $selectfields.=", @customer.province ";
           $selectfields.=", @customer.address ";
           $selectfields.=", @customer.postcode ";
           $selectfields.=", @customer.phone ";
           $selectfields.=", @customer.linkman ";
           $selectfields.=", @customer.mobile ";
           $selectfields.=", @customer.corpbusicode ";
           $selectfields.=", @customer.corptaxcode ";
           $selectfields.=", @customer.legalpername ";
           $selectfields.=", @customer.legalperidtype ";
           $selectfields.=", @customer.legalperidno ";
           $selectfields.=", @customer.contactname ";
           $selectfields.=", @customer.contactidtype ";
           $selectfields.=", @customer.contactidno ";
           $selectfields.=", @customer.contactmobile ";
           $selectfields.=", @customer.openbank ";
           $selectfields.=", @customer.openacctno ";
           $selectfields.=", @customer.openacctname ";
           $selectfields.=", @customer.chinapay_userid ";
           $selectfields.=", @customer.invoice_flag ";
           $selectfields.=", @customer.invoice_company ";
           $selectfields.=", @customer.invoice_address ";
           $selectfields.=", @customer.invoice_phone ";
           $selectfields.=", @customer.invoice_bank ";
           $selectfields.=", @customer.invoice_account ";
           $selectfields.=", @customer.invoice_taxno ";
           $selectfields.=", @customer.invoice_email ";
           $selectfields.=", @customer.invoice_mobile ";
           $selectfields.=", @customer.contract_linkman ";
           $selectfields.=", @customer.contract_phone ";
           $selectfields.=", @customer.contract_fax ";
           $selectfields.=", @customer.contract_address ";
           $selectfields.=", @customer.feesett_linkman ";
           $selectfields.=", @customer.feesett_phone ";
           $selectfields.=", @customer.feesett_fax ";
           $selectfields.=", @customer.feesett_address ";
           $selectfields.=", @customer.sms_open ";
           $selectfields.=", @customer.sms_transfer_out ";
           $selectfields.=", @customer.sms_transfer_in ";
           $selectfields.=", @customer.sms_delivery ";
           $selectfields.=", @customer.sms_phone ";
           $selectfields.=", @customer.sms_appellation ";
           $selectfields.=", @customer.apply_time ";
           $selectfields.=", @customer.apply_user ";
           $selectfields.=", @customer.apply_times ";
           $selectfields.=", @customer.reply_time ";
           $selectfields.=", @customer.reply_user ";
           $selectfields.=", @customer.reply_status ";
           $selectfields.=", @customer.lock_status ";
           $selectfields.=", @customer.create_time ";


           $page_size = I("request.pagesize/d");
           if ($page_size<=0){
               $page_size = session("CustomerSummary-PageSize");
               if (!$page_size) {
                    $page_size = 10;
               }
           }
           session("CustomerSummary-PageSize", $page_size);


           $join="";
           if($condition_a){
              $condition_customer .= $condition_a;
           }
           $count_sql = "select count(*) as cnt from @customer LEFT JOIN @customer a ON a.id=@customer.parent_id  #join#  where 1=1 #condition#";  // ' for skip replace $condition
           $count_sql = str_replace("#join#",$join,$count_sql);
           $count_sql = str_replace("#condition#",$condition_customer,$count_sql);
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

           $orderby = $this->get_orderby("@customer.customer_level,@customer.parent_id,@customer.id",$search["_tab"]);
           $sql = "select #selectfields# from @customer LEFT JOIN @customer a ON a.id=@customer.parent_id  #join# Where 1=1 #condition# #orderby#";
           $sql = str_replace("#selectfields#",$selectfields,$sql);
           $sql = str_replace("#join#",$join,$sql);
           $sql = str_replace("#condition#",$condition_customer,$sql);
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
        $html = $this->fetch("CustomerSummary:index");
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

        if(empty($data["funcid"])) $data["funcid"] = "CustomerSummary";
        if(!$p){
           $p = 1;
           $export_all = 1;
        }

        $show_list = array();

        $data['summary']='CustomerSummary';
        $usc = M('user_summary_column')->field("column")->where("user_code='%s' AND summary='%s' AND `show`='1'",array(session(C("USER_AUTH_KEY")),$data['summary']))->select();
        if($usc){
           foreach ($usc as $v) {
              $show_list[$v['column']]=1;
           }
        }

        $search["_tab"] = $this->tabsheet_check(I("request._tab"));
        $tab = $search["_tab"];

        $search["status"] = I("request.status");
        $search["category_code_name"] = I("request.category_code_name");
        $search["category_code"] = I("request.category_code");
        $search["industry_code"] = I("request.industry_code");
        $search["code"] = I("request.code");
        $search["name"] = I("request.name");
        $search["full_name"] = I("request.full_name");
        $search["prefix"] = I("request.prefix");
        $search["abbr"] = I("request.abbr");
        $search["customer_name"] = I("request.customer_name");
        $search["customer_level"] = I("request.customer_level");
        $search["province"] = I("request.province");
        $search["address"] = I("request.address");
        $search["postcode"] = I("request.postcode");
        $search["phone"] = I("request.phone");
        $search["linkman"] = I("request.linkman");
        $search["mobile"] = I("request.mobile");
        $search["corpbusicode"] = I("request.corpbusicode");
        $search["corptaxcode"] = I("request.corptaxcode");
        $search["legalpername"] = I("request.legalpername");
        $search["legalperidtype"] = I("request.legalperidtype");
        $search["legalperidno"] = I("request.legalperidno");
        $search["contactname"] = I("request.contactname");
        $search["contactidtype"] = I("request.contactidtype");
        $search["contactidno"] = I("request.contactidno");
        $search["contactmobile"] = I("request.contactmobile");
        $search["openbank"] = I("request.openbank");
        $search["openacctno"] = I("request.openacctno");
        $search["openacctname"] = I("request.openacctname");
        $search["chinapay_userid"] = I("request.chinapay_userid");
        $search["invoice_flag"] = I("request.invoice_flag");
        $search["invoice_company"] = I("request.invoice_company");
        $search["invoice_address"] = I("request.invoice_address");
        $search["invoice_phone"] = I("request.invoice_phone");
        $search["invoice_bank"] = I("request.invoice_bank");
        $search["invoice_account"] = I("request.invoice_account");
        $search["invoice_taxno"] = I("request.invoice_taxno");
        $search["invoice_email"] = I("request.invoice_email");
        $search["invoice_mobile"] = I("request.invoice_mobile");
        $search["contract_linkman"] = I("request.contract_linkman");
        $search["contract_phone"] = I("request.contract_phone");
        $search["contract_fax"] = I("request.contract_fax");
        $search["contract_address"] = I("request.contract_address");
        $search["feesett_linkman"] = I("request.feesett_linkman");
        $search["feesett_phone"] = I("request.feesett_phone");
        $search["feesett_fax"] = I("request.feesett_fax");
        $search["feesett_address"] = I("request.feesett_address");
        $search["sms_open"] = I("request.sms_open");
        $search["sms_transfer_out"] = I("request.sms_transfer_out");
        $search["sms_transfer_in"] = I("request.sms_transfer_in");
        $search["sms_delivery"] = I("request.sms_delivery");
        $search["sms_phone"] = I("request.sms_phone");
        $search["sms_appellation"] = I("request.sms_appellation");
        $search["apply_time"] = I("request.apply_time");
        $search["apply_time2"] = I("request.apply_time2");
        $search["apply_user"] = I("request.apply_user");
        $search["apply_times"] = I("request.apply_times");
        $search["apply_times2"] = I("request.apply_times2");
        $search["reply_time"] = I("request.reply_time");
        $search["reply_time2"] = I("request.reply_time2");
        $search["reply_user"] = I("request.reply_user");
        $search["reply_status"] = I("request.reply_status");
        $search["lock_status"] = I("request.lock_status");


        //condition
        $condition="";
        $condition_customer="";

        //读取关键字搜索内容
        $search["_keyword"] = I("request._keyword");
        if($search["_showsearch"]=="hide"  ){
            if($search["_keyword"]){
                $condition_keyword = "";
                $condition_keyword = join_condition($condition_keyword,"@customer.code",$search["_keyword"],"char", "both" , 0, "" );
                $condition_keyword = join_condition($condition_keyword,"@customer.name",$search["_keyword"],"char", "both" , 0, "OR" );
                $condition_keyword = join_condition($condition_keyword,"@customer.prefix",$search["_keyword"],"char", "both" , 0, "OR" );
                $condition_keyword = join_condition($condition_keyword,"a.name",$search["_keyword"],"char", "both" , 0, "OR" );
                $condition_keyword = join_condition($condition_keyword,"@customer.mobile",$search["_keyword"],"char", "both" , 0, "OR" );
                $condition_customer = " AND ( ". $condition_keyword . ")";
            }
        }else{
        //高级搜索condition
           $condition_customer = join_condition($condition_customer,"@customer.status",$search["status"],"int");
           $condition_customer = join_condition($condition_customer,"@customer.category_code",$search["category_code"],"char");
           $condition_customer = join_condition($condition_customer,"@customer.industry_code",$search["industry_code"],"char");
           $condition_customer = join_condition($condition_customer,"@customer.code",$search["code"],"char");
           $condition_customer = join_condition($condition_customer,"@customer.name",$search["name"],"char","both");
           $condition_customer = join_condition($condition_customer,"@customer.full_name",$search["full_name"],"char","both");
           $condition_customer = join_condition($condition_customer,"@customer.prefix",$search["prefix"],"char");
           $condition_customer = join_condition($condition_customer,"@customer.abbr",$search["abbr"],"char");
           $condition_a = join_condition($condition_a,"a.name",$search["customer_name"],"char","both");
           $condition_customer = join_condition($condition_customer,"@customer.customer_level",$search["customer_level"],"int");
           $condition_customer = join_condition($condition_customer,"@customer.province",$search["province"],"char");
           $condition_customer = join_condition($condition_customer,"@customer.address",$search["address"],"char","both");
           $condition_customer = join_condition($condition_customer,"@customer.postcode",$search["postcode"],"char");
           $condition_customer = join_condition($condition_customer,"@customer.phone",$search["phone"],"char");
           $condition_customer = join_condition($condition_customer,"@customer.linkman",$search["linkman"],"char");
           $condition_customer = join_condition($condition_customer,"@customer.mobile",$search["mobile"],"char");
           $condition_customer = join_condition($condition_customer,"@customer.corpbusicode",$search["corpbusicode"],"char");
           $condition_customer = join_condition($condition_customer,"@customer.corptaxcode",$search["corptaxcode"],"char");
           $condition_customer = join_condition($condition_customer,"@customer.legalpername",$search["legalpername"],"char");
           $condition_customer = join_condition($condition_customer,"@customer.legalperidtype",$search["legalperidtype"],"char");
           $condition_customer = join_condition($condition_customer,"@customer.legalperidno",$search["legalperidno"],"char");
           $condition_customer = join_condition($condition_customer,"@customer.contactname",$search["contactname"],"char");
           $condition_customer = join_condition($condition_customer,"@customer.contactidtype",$search["contactidtype"],"char");
           $condition_customer = join_condition($condition_customer,"@customer.contactidno",$search["contactidno"],"char");
           $condition_customer = join_condition($condition_customer,"@customer.contactmobile",$search["contactmobile"],"char");
           $condition_customer = join_condition($condition_customer,"@customer.openbank",$search["openbank"],"char");
           $condition_customer = join_condition($condition_customer,"@customer.openacctno",$search["openacctno"],"char");
           $condition_customer = join_condition($condition_customer,"@customer.openacctname",$search["openacctname"],"char","both");
           $condition_customer = join_condition($condition_customer,"@customer.chinapay_userid",$search["chinapay_userid"],"char");
           $condition_customer = join_condition($condition_customer,"@customer.invoice_flag",$search["invoice_flag"],"int");
           $condition_customer = join_condition($condition_customer,"@customer.invoice_company",$search["invoice_company"],"char","both");
           $condition_customer = join_condition($condition_customer,"@customer.invoice_address",$search["invoice_address"],"char","both");
           $condition_customer = join_condition($condition_customer,"@customer.invoice_phone",$search["invoice_phone"],"char");
           $condition_customer = join_condition($condition_customer,"@customer.invoice_bank",$search["invoice_bank"],"char");
           $condition_customer = join_condition($condition_customer,"@customer.invoice_account",$search["invoice_account"],"char");
           $condition_customer = join_condition($condition_customer,"@customer.invoice_taxno",$search["invoice_taxno"],"char");
           $condition_customer = join_condition($condition_customer,"@customer.invoice_email",$search["invoice_email"],"char","both");
           $condition_customer = join_condition($condition_customer,"@customer.invoice_mobile",$search["invoice_mobile"],"char");
           $condition_customer = join_condition($condition_customer,"@customer.contract_linkman",$search["contract_linkman"],"char");
           $condition_customer = join_condition($condition_customer,"@customer.contract_phone",$search["contract_phone"],"char");
           $condition_customer = join_condition($condition_customer,"@customer.contract_fax",$search["contract_fax"],"char");
           $condition_customer = join_condition($condition_customer,"@customer.contract_address",$search["contract_address"],"char","both");
           $condition_customer = join_condition($condition_customer,"@customer.feesett_linkman",$search["feesett_linkman"],"char");
           $condition_customer = join_condition($condition_customer,"@customer.feesett_phone",$search["feesett_phone"],"char");
           $condition_customer = join_condition($condition_customer,"@customer.feesett_fax",$search["feesett_fax"],"char");
           $condition_customer = join_condition($condition_customer,"@customer.feesett_address",$search["feesett_address"],"char","both");
           $condition_customer = join_condition($condition_customer,"@customer.sms_open",$search["sms_open"],"int");
           $condition_customer = join_condition($condition_customer,"@customer.sms_transfer_out",$search["sms_transfer_out"],"int");
           $condition_customer = join_condition($condition_customer,"@customer.sms_transfer_in",$search["sms_transfer_in"],"int");
           $condition_customer = join_condition($condition_customer,"@customer.sms_delivery",$search["sms_delivery"],"int");
           $condition_customer = join_condition($condition_customer,"@customer.sms_phone",$search["sms_phone"],"char");
           $condition_customer = join_condition($condition_customer,"@customer.sms_appellation",$search["sms_appellation"],"char");
           $condition_customer = join_condition2($condition_customer,"@customer.apply_time",$search["apply_time"],$search["apply_time2"],"datetime");
           $condition_customer = join_condition($condition_customer,"@customer.apply_user",$search["apply_user"],"char");
           $condition_customer = join_condition2($condition_customer,"@customer.apply_times",$search["apply_times"],$search["apply_times2"],"int");
           $condition_customer = join_condition2($condition_customer,"@customer.reply_time",$search["reply_time"],$search["reply_time2"],"datetime");
           $condition_customer = join_condition($condition_customer,"@customer.reply_user",$search["reply_user"],"char");
           $condition_customer = join_condition($condition_customer,"@customer.reply_status",$search["reply_status"],"int");
           $condition_customer = join_condition($condition_customer,"@customer.lock_status",$search["lock_status"],"int");
        }
        $condition_customer = $this->tabsheet_condition($condition_customer ,$search["_tab"]);
          $condition_customer = join_condition_shop($condition_customer,"3;@customer.id;customer_id",$this->user_shop_id,$search_auth_codes);

        //select fields
        $selectfields="@customer.status ";
        $selectfields.=",@customer.id ";
        $selectfields.=",@customer.category_code ";
        $selectfields.=",@customer.industry_code ";
        $selectfields.=",@customer.code ";
        $selectfields.=",@customer.name ";
        $selectfields.=",@customer.full_name ";
        $selectfields.=",@customer.prefix ";
        $selectfields.=",@customer.abbr ";
        $selectfields.=",a.name customer_name ";
        $selectfields.=",@customer.customer_level ";
        $selectfields.=",@customer.province ";
        $selectfields.=",@customer.address ";
        $selectfields.=",@customer.postcode ";
        $selectfields.=",@customer.phone ";
        $selectfields.=",@customer.linkman ";
        $selectfields.=",@customer.mobile ";
        $selectfields.=",@customer.corpbusicode ";
        $selectfields.=",@customer.corptaxcode ";
        $selectfields.=",@customer.legalpername ";
        $selectfields.=",@customer.legalperidtype ";
        $selectfields.=",@customer.legalperidno ";
        $selectfields.=",@customer.contactname ";
        $selectfields.=",@customer.contactidtype ";
        $selectfields.=",@customer.contactidno ";
        $selectfields.=",@customer.contactmobile ";
        $selectfields.=",@customer.openbank ";
        $selectfields.=",@customer.openacctno ";
        $selectfields.=",@customer.openacctname ";
        $selectfields.=",@customer.chinapay_userid ";
        $selectfields.=",@customer.invoice_flag ";
        $selectfields.=",@customer.invoice_company ";
        $selectfields.=",@customer.invoice_address ";
        $selectfields.=",@customer.invoice_phone ";
        $selectfields.=",@customer.invoice_bank ";
        $selectfields.=",@customer.invoice_account ";
        $selectfields.=",@customer.invoice_taxno ";
        $selectfields.=",@customer.invoice_email ";
        $selectfields.=",@customer.invoice_mobile ";
        $selectfields.=",@customer.contract_linkman ";
        $selectfields.=",@customer.contract_phone ";
        $selectfields.=",@customer.contract_fax ";
        $selectfields.=",@customer.contract_address ";
        $selectfields.=",@customer.feesett_linkman ";
        $selectfields.=",@customer.feesett_phone ";
        $selectfields.=",@customer.feesett_fax ";
        $selectfields.=",@customer.feesett_address ";
        $selectfields.=",@customer.sms_open ";
        $selectfields.=",@customer.sms_transfer_out ";
        $selectfields.=",@customer.sms_transfer_in ";
        $selectfields.=",@customer.sms_delivery ";
        $selectfields.=",@customer.sms_phone ";
        $selectfields.=",@customer.sms_appellation ";
        $selectfields.=",@customer.apply_time ";
        $selectfields.=",@customer.apply_user ";
        $selectfields.=",@customer.apply_times ";
        $selectfields.=",@customer.reply_time ";
        $selectfields.=",@customer.reply_user ";
        $selectfields.=",@customer.reply_status ";
        $selectfields.=",@customer.lock_status ";
        $selectfields.=",@customer.create_time ";


        $str_header = "";
        if ($show_list['status']==1 || empty($show_list)){
            $str_header .= "状态,";
        }
        if ($show_list['category_code']==1 || empty($show_list)){
            $str_header .= "客户分类,";
        }
        if ($show_list['industry_code']==1 || empty($show_list)){
            $str_header .= "行业分类,";
        }
        if ($show_list['code']==1 || empty($show_list)){
            $str_header .= "客户代码,";
        }
        if ($show_list['name']==1 || empty($show_list)){
            $str_header .= "客户简称,";
        }
        if ($show_list['full_name']==1 || empty($show_list)){
            $str_header .= "客户全称,";
        }
        if ($show_list['prefix']==1 || empty($show_list)){
            $str_header .= "助记码,";
        }
        if ($show_list['abbr']==1 || empty($show_list)){
            $str_header .= "缩写,";
        }
        if ($show_list['customer_name']==1 || empty($show_list)){
            $str_header .= "上级名称,";
        }
        if ($show_list['customer_level']==1 || empty($show_list)){
            $str_header .= "层级,";
        }
        if ($show_list['province']==1 || empty($show_list)){
            $str_header .= "省份,";
        }
        if ($show_list['address']==1 || empty($show_list)){
            $str_header .= "联系地址,";
        }
        if ($show_list['postcode']==1 || empty($show_list)){
            $str_header .= "邮政编码,";
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
        if ($show_list['corpbusicode']==1 || empty($show_list)){
            $str_header .= "营业执照号,";
        }
        if ($show_list['corptaxcode']==1 || empty($show_list)){
            $str_header .= "税务登记证,";
        }
        if ($show_list['legalpername']==1 || empty($show_list)){
            $str_header .= "法人姓名,";
        }
        if ($show_list['legalperidtype']==1 || empty($show_list)){
            $str_header .= "法人证件类型,";
        }
        if ($show_list['legalperidno']==1 || empty($show_list)){
            $str_header .= "法人证件号码,";
        }
        if ($show_list['contactname']==1 || empty($show_list)){
            $str_header .= "联系人姓名,";
        }
        if ($show_list['contactidtype']==1 || empty($show_list)){
            $str_header .= "联系人证件类型,";
        }
        if ($show_list['contactidno']==1 || empty($show_list)){
            $str_header .= "联系人证件号码,";
        }
        if ($show_list['contactmobile']==1 || empty($show_list)){
            $str_header .= "联系人手机,";
        }
        if ($show_list['openbank']==1 || empty($show_list)){
            $str_header .= "开户银行,";
        }
        if ($show_list['openacctno']==1 || empty($show_list)){
            $str_header .= "开户账户号,";
        }
        if ($show_list['openacctname']==1 || empty($show_list)){
            $str_header .= "开户账户名,";
        }
        if ($show_list['chinapay_userid']==1 || empty($show_list)){
            $str_header .= "银联账户号,";
        }
        if ($show_list['invoice_flag']==1 || empty($show_list)){
            $str_header .= "发票要求,";
        }
        if ($show_list['invoice_company']==1 || empty($show_list)){
            $str_header .= "开票单位,";
        }
        if ($show_list['invoice_address']==1 || empty($show_list)){
            $str_header .= "开票地址,";
        }
        if ($show_list['invoice_phone']==1 || empty($show_list)){
            $str_header .= "开票电话,";
        }
        if ($show_list['invoice_bank']==1 || empty($show_list)){
            $str_header .= "开票银行,";
        }
        if ($show_list['invoice_account']==1 || empty($show_list)){
            $str_header .= "开票账户,";
        }
        if ($show_list['invoice_taxno']==1 || empty($show_list)){
            $str_header .= "开票税号,";
        }
        if ($show_list['invoice_email']==1 || empty($show_list)){
            $str_header .= "电子票邮箱,";
        }
        if ($show_list['invoice_mobile']==1 || empty($show_list)){
            $str_header .= "电子票手机,";
        }
        if ($show_list['contract_linkman']==1 || empty($show_list)){
            $str_header .= "合同联系人员,";
        }
        if ($show_list['contract_phone']==1 || empty($show_list)){
            $str_header .= "合同联系电话,";
        }
        if ($show_list['contract_fax']==1 || empty($show_list)){
            $str_header .= "合同联系传真,";
        }
        if ($show_list['contract_address']==1 || empty($show_list)){
            $str_header .= "合同邮寄地址,";
        }
        if ($show_list['feesett_linkman']==1 || empty($show_list)){
            $str_header .= "结算联系人员,";
        }
        if ($show_list['feesett_phone']==1 || empty($show_list)){
            $str_header .= "结算联系电话,";
        }
        if ($show_list['feesett_fax']==1 || empty($show_list)){
            $str_header .= "结算联系传真,";
        }
        if ($show_list['feesett_address']==1 || empty($show_list)){
            $str_header .= "结算对账单寄,";
        }
        if ($show_list['sms_open']==1 || empty($show_list)){
            $str_header .= "短信服务,";
        }
        if ($show_list['sms_transfer_out']==1 || empty($show_list)){
            $str_header .= "货权转出通知,";
        }
        if ($show_list['sms_transfer_in']==1 || empty($show_list)){
            $str_header .= "货权转入通知,";
        }
        if ($show_list['sms_delivery']==1 || empty($show_list)){
            $str_header .= "提货时通知,";
        }
        if ($show_list['sms_phone']==1 || empty($show_list)){
            $str_header .= "接收手机号,";
        }
        if ($show_list['sms_appellation']==1 || empty($show_list)){
            $str_header .= "接收者称呼,";
        }
        if ($show_list['apply_time']==1 || empty($show_list)){
            $str_header .= "申请时间,";
        }
        if ($show_list['apply_user']==1 || empty($show_list)){
            $str_header .= "申请人员,";
        }
        if ($show_list['apply_times']==1 || empty($show_list)){
            $str_header .= "申请次数,";
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
        if ($show_list['lock_status']==1 || empty($show_list)){
            $str_header .= "锁定状态,";
        }
        if ($show_list['create_time']==1 || empty($show_list)){
            $str_header .= "创建时间,";
        }
        $str_header .= "\r\n";

        $join="";
        if($condition_a){
            $condition_customer .= $condition_a;
        }

       $count_sql = "select count(*) as cnt from @customer LEFT JOIN @customer a ON a.id=@customer.parent_id  #join#  where 1=1 #condition#";  // ' for skip replace $condition
       $count_sql = str_replace("#join#",$join,$count_sql);
       $count_sql = str_replace("#condition#",$condition_customer,$count_sql);

       $count_sql = table($count_sql);
       $count_sql = str_replace("·mailchar·","@",$count_sql);
       $count = M()->query($count_sql);
       $count = $count[0]["cnt"];

           $total_page=0;

        if(!$export_all) {
           $page_size = I("request.pagesize/d");
           $page_size = $page_size <= 0 ? session("CustomerSummary-PageSize") : $page_size;
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

        $orderby="order by @customer.customer_level,@customer.parent_id,@customer.id";
        //$orderby="";

    for ($p;$p<=$total_page;$p++)
    {

        $sql = "select #selectfields# from @customer LEFT JOIN @customer a ON a.id=@customer.parent_id  #join# Where 1=1 #condition# #orderby#";   // ' for skip replace $selectfields,$condition,$orderby
        $sql = str_replace("#selectfields#",$selectfields,$sql);
        $sql = str_replace("#join#",$join,$sql);
        $sql = str_replace("#condition#",$condition_customer,$sql);
        $sql = str_replace("#orderby#",$orderby,$sql);
        $sql .= " LIMIT ". (($p - 1) * $page_size). ", ".$page_size;

        $sql = table($sql);
        $sql = str_replace("·mailchar·","@",$sql);
        $list = M()->query($sql);

        foreach($list as $master) {
            $str_line="";
            if ($show_list['status']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Customer_status("$master[status]","name"))."\t,";
            }
            if ($show_list['category_code']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["category_code"])."\t,";
            }
            if ($show_list['industry_code']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["industry_code"])."\t,";
            }
            if ($show_list['code']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["code"])."\t,";
            }
            if ($show_list['name']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["name"])."\t,";
            }
            if ($show_list['full_name']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["full_name"])."\t,";
            }
            if ($show_list['prefix']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["prefix"])."\t,";
            }
            if ($show_list['abbr']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["abbr"])."\t,";
            }
            if ($show_list['customer_name']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["customer_name"])."\t,";
            }
            if ($show_list['customer_level']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Customer_customer_level("$master[customer_level]","name"))."\t,";
            }
            if ($show_list['province']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["province"])."\t,";
            }
            if ($show_list['address']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["address"])."\t,";
            }
            if ($show_list['postcode']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["postcode"])."\t,";
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
            if ($show_list['corpbusicode']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["corpbusicode"])."\t,";
            }
            if ($show_list['corptaxcode']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["corptaxcode"])."\t,";
            }
            if ($show_list['legalpername']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["legalpername"])."\t,";
            }
            if ($show_list['legalperidtype']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["legalperidtype"])."\t,";
            }
            if ($show_list['legalperidno']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["legalperidno"])."\t,";
            }
            if ($show_list['contactname']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["contactname"])."\t,";
            }
            if ($show_list['contactidtype']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["contactidtype"])."\t,";
            }
            if ($show_list['contactidno']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["contactidno"])."\t,";
            }
            if ($show_list['contactmobile']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["contactmobile"])."\t,";
            }
            if ($show_list['openbank']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["openbank"])."\t,";
            }
            if ($show_list['openacctno']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["openacctno"])."\t,";
            }
            if ($show_list['openacctname']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["openacctname"])."\t,";
            }
            if ($show_list['chinapay_userid']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["chinapay_userid"])."\t,";
            }
            if ($show_list['invoice_flag']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Customer_invoice_flag("$master[invoice_flag]","name"))."\t,";
            }
            if ($show_list['invoice_company']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["invoice_company"])."\t,";
            }
            if ($show_list['invoice_address']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["invoice_address"])."\t,";
            }
            if ($show_list['invoice_phone']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["invoice_phone"])."\t,";
            }
            if ($show_list['invoice_bank']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["invoice_bank"])."\t,";
            }
            if ($show_list['invoice_account']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["invoice_account"])."\t,";
            }
            if ($show_list['invoice_taxno']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["invoice_taxno"])."\t,";
            }
            if ($show_list['invoice_email']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["invoice_email"])."\t,";
            }
            if ($show_list['invoice_mobile']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["invoice_mobile"])."\t,";
            }
            if ($show_list['contract_linkman']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["contract_linkman"])."\t,";
            }
            if ($show_list['contract_phone']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["contract_phone"])."\t,";
            }
            if ($show_list['contract_fax']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["contract_fax"])."\t,";
            }
            if ($show_list['contract_address']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["contract_address"])."\t,";
            }
            if ($show_list['feesett_linkman']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["feesett_linkman"])."\t,";
            }
            if ($show_list['feesett_phone']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["feesett_phone"])."\t,";
            }
            if ($show_list['feesett_fax']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["feesett_fax"])."\t,";
            }
            if ($show_list['feesett_address']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["feesett_address"])."\t,";
            }
            if ($show_list['sms_open']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Customer_sms_open("$master[sms_open]","name"))."\t,";
            }
            if ($show_list['sms_transfer_out']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Customer_sms_transfer_out("$master[sms_transfer_out]","name"))."\t,";
            }
            if ($show_list['sms_transfer_in']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Customer_sms_transfer_in("$master[sms_transfer_in]","name"))."\t,";
            }
            if ($show_list['sms_delivery']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Customer_sms_delivery("$master[sms_delivery]","name"))."\t,";
            }
            if ($show_list['sms_phone']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["sms_phone"])."\t,";
            }
            if ($show_list['sms_appellation']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["sms_appellation"])."\t,";
            }
            if ($show_list['apply_time']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("DT", $master["apply_time"]))."\t,";
            }
            if ($show_list['apply_user']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["apply_user"])."\t,";
            }
            if ($show_list['apply_times']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("N3", $master["apply_times"]))."\t,";
            }
            if ($show_list['reply_time']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("DT", $master["reply_time"]))."\t,";
            }
            if ($show_list['reply_user']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["reply_user"])."\t,";
            }
            if ($show_list['reply_status']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Customer_reply_status("$master[reply_status]","name"))."\t,";
            }
            if ($show_list['lock_status']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Customer_lock_status("$master[lock_status]","name"))."\t,";
            }
            if ($show_list['create_time']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("DT", $master["create_time"]))."\t,";
            }
            $str_content .= $str_line . "\r\n";
        }
    }
        header('Content-Type: text/xls');
        header ("Content-type:application/vnd.ms-excel;charset=gbk" );
        $str = mb_convert_encoding("CustomerSummary", 'gbk', 'utf-8');
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
          case 'quanbu':
          case 'hehuo':
          case 'kehu':
          case 'wuxiao':
              break;
          default:
              $itab='quanbu';
              break;
              if (!session('CUSTOMER_ID')){
              $itab='hehuo';
              break;
              }
              if (!session('CUSTOMER_ID')){
              $itab='kehu';
              break;
              }
              if (!session('CUSTOMER_ID')){
              $itab='wuxiao';
              break;
              }
         }
        return $itab;
    }

    private function tabsheet_condition($scondition, $itab)
    {
        $scond="";
        switch($itab)
        {
            case 'quanbu':  //全部
                 $scond="";
                 break;
            case 'hehuo':  //合伙
                 $scond="@customer.type=0 and @customer.status='1'";
                 break;
            case 'kehu':  //客户
                 $scond="@customer.type=1 and @customer.status='1'";
                 break;
            case 'wuxiao':  //无效
                 $scond="@customer.status!='1'";
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
            case 'quanbu':  //全部
                 break;
            case 'hehuo':  //合伙
                 break;
            case 'kehu':  //客户
                 break;
            case 'wuxiao':  //无效
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
            $condition.=" @customer.id='".$this->user["customer_id"]."' ";
            break;
        }
        return $condition ;
    }
}
