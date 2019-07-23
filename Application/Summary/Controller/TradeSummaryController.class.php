<?php namespace Summary\Controller;
//
//注释: TradeSummary - 交易开单列表
//
use Home\Controller\BasicController;
use Think\Log;
class TradeSummaryController extends BasicController {

    public function _init() {
        $funcs = $this->getUserRoleList($this->user,array( '/Home/Trade', 'TradeSummary', ));
        if ($funcs)
            $this->assign("rights",  $funcs);
        else{
            $funcs = array(
                         array("key"=>"add","func"=>"/Home/Trade","Action"=>"add") ,
                         array("key"=>"refresh","func"=>"TradeSummary","Action"=>"refresh") ,
                         array("key"=>"search","func"=>"TradeSummary","Action"=>"search") ,
                         array("key"=>"export","func"=>"TradeSummary","Action"=>"export") ,
                         array("key"=>"master_view","func"=>"/Home/Trade","Action"=>"view") ,
                         array("key"=>"master_edit","func"=>"/Home/Trade","Action"=>"edit") ,
                         array("key"=>"master_delete","func"=>"/Home/Trade","Action"=>"delete")
             );
            $this->assign("rights",  $this->GetUserRights($this->user["id"],$funcs ));
        }
        $this->assign("colshow", $this->GetUserColumnDefine($this->user["id"],"TradeSummary"));
    }

    public function index() {
         try {
        $data["pfuncid"] = I("request.pfuncid");
        $data["funcid"] = I("request.funcid");
        $data["zindex"] = I("request.zindex/d");
        if(empty($data["funcid"])) $data["funcid"] = "TradeSummary";
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
          //$this->ajaxResult("交易开单列表后台错误");
          $this->ajaxResult($e->getMessage());
      }
    }


    private function columnsetting_define(){
        return array(
            'status'=>'状态',
            'org_id'=>'库联',
            'warehouse_code'=>'仓库编码',
            'customer_name'=>'卖出客户',
            'buyer_id'=>'买入客户',
            'buyer_name'=>'买入客户',
            'trade_no'=>'交易单号',
            'tx_type'=>'交易类型',
            'tx_date'=>'开单日期',
            'contract_no'=>'合同号码',
            'contract_date'=>'合同日期',
            'is_real'=>'实物',
            'chain_id'=>'交易链',
            'goods_no'=>'货品编码',
            'goods_name'=>'货品名称',
            'style_info'=>'规格',
            'materials'=>'材质',
            'brand'=>'商标',
            'producing_area'=>'产地',
            'weight'=>'交易重量',
            'price'=>'交易价格(元)',
            'amount'=>'交易金额(元)',
            'uom_weight'=>'重量单位',
            'uom_qty'=>'数量单位',
            'cust_confirm_status'=>'卖家确认',
            'cust_confirm_time'=>'卖家确认时间',
            'cust_confirm_user'=>'卖家确认人员',
            'buyer_confirm_status'=>'买家确认',
            'buyer_confirm_time'=>'买家确认时间',
            'buyer_confirm_user'=>'买家确认人员',
            'cust_send_type'=>'卖家发送',
            'cust_send_time'=>'卖家发送时间',
            'cust_send_user'=>'卖家发送人员',
            'storefee_bears'=>'仓储费承担',
            'storefee_require'=>'仓储费起始(天)',
            'storefee_start'=>'仓储费起算日',
            'payment_require'=>'付款截至类型',
            'payment_expire'=>'付款截至时间',
            'confirm_status'=>'收付款登记',
            'confirm_payment'=>'买家付款(元)',
            'confirm_receive'=>'卖家收款',
            'delivery_no'=>'提单号码',
            'delivery_date'=>'提单日期',
            'delivery_expired'=>'提单截至',
            'delivery_company'=>'提货公司',
            'delivery_type'=>'发货方式',
            'assign_status'=>'配货标志',
            'assign_time'=>'配货时间',
            'assign_user'=>'配货人员',
            'assign_weight'=>'配货重量',
            'assign_qty'=>'配货数量',
            'buyer_storecard_id'=>'收货卡',
            'buyer_storecard_no'=>'收货卡号',
            'buyer_storecard_allow'=>'追加许可',
            'act_weight'=>'实发重量',
            'act_qty'=>'实发数量',
            'act_time'=>'实发时间',
            'act_order'=>'实发单号',
            'diff_weight'=>'重量差异',
            'diff_amount'=>'差异金额(元)',
            'interface_status'=>'接口状态',
            'interface_send_status'=>'接口处理',
            'interface_send_time'=>'接口发送时间',
            'interface_send_count'=>'接口发送次数',
            'interface_receive'=>'接口返回时间',
            'create_time'=>'创建时间',
        );
    }

    private function columnsetting($data){
        $data['user_code']=session(C("USER_AUTH_KEY"));
        $data['summary']='TradeSummary';
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

        $this->ajaxResult("", "",  array("_asr.closeTab","_asr.closePopup", "_asr.openLink","_asr.hideMask()"), array("$('#".$data["funcid"]."-Tab').find('a'), '".$data["funcid"]."'","'".$data["funcid"]."'", "'". U("/Summary/TradeSummary/index?func=search&").  "','".filterFuncId("TradeSummary_Search","id=0")."','交易开单列表', 1",""));


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
       $search["warehouse_code"] = I("request.warehouse_code");
       $search["customer_id_name"] = I("request.customer_id_name");
       $search["customer_id"] = I("request.customer_id");
       $search["customer_name"] = I("request.customer_name");
       $search["buyer_id"] = I("request.buyer_id");
       $search["buyer_name"] = I("request.buyer_name");
       $search["trade_no"] = I("request.trade_no");
       $search["tx_type"] = I("request.tx_type");
       $search["tx_date"] = I("request.tx_date");
       $search["tx_date2"] = I("request.tx_date2");
       $search["contract_no"] = I("request.contract_no");
       $search["contract_date"] = I("request.contract_date");
       $search["contract_date2"] = I("request.contract_date2");
       $search["is_real"] = I("request.is_real");
       $search["chain_id"] = I("request.chain_id");
       $search["goods_no"] = I("request.goods_no");
       $search["goods_name"] = I("request.goods_name");
       $search["style_info"] = I("request.style_info");
       $search["materials"] = I("request.materials");
       $search["brand"] = I("request.brand");
       $search["producing_area"] = I("request.producing_area");
       $search["weight"] = I("request.weight");
       $search["weight2"] = I("request.weight2");
       $search["price"] = I("request.price");
       $search["price2"] = I("request.price2");
       $search["amount"] = I("request.amount");
       $search["amount2"] = I("request.amount2");
       $search["uom_weight"] = I("request.uom_weight");
       $search["uom_qty"] = I("request.uom_qty");
       $search["cust_confirm_status"] = I("request.cust_confirm_status");
       $search["cust_confirm_time"] = I("request.cust_confirm_time");
       $search["cust_confirm_time2"] = I("request.cust_confirm_time2");
       $search["cust_confirm_user"] = I("request.cust_confirm_user");
       $search["buyer_confirm_status"] = I("request.buyer_confirm_status");
       $search["buyer_confirm_time"] = I("request.buyer_confirm_time");
       $search["buyer_confirm_time2"] = I("request.buyer_confirm_time2");
       $search["buyer_confirm_user"] = I("request.buyer_confirm_user");
       $search["cust_send_type"] = I("request.cust_send_type");
       $search["cust_send_time"] = I("request.cust_send_time");
       $search["cust_send_time2"] = I("request.cust_send_time2");
       $search["cust_send_user"] = I("request.cust_send_user");
       $search["storefee_bears"] = I("request.storefee_bears");
       $search["storefee_require"] = I("request.storefee_require");
       $search["storefee_require2"] = I("request.storefee_require2");
       $search["storefee_start"] = I("request.storefee_start");
       $search["storefee_start2"] = I("request.storefee_start2");
       $search["payment_require"] = I("request.payment_require");
       $search["payment_expire"] = I("request.payment_expire");
       $search["payment_expire2"] = I("request.payment_expire2");
       $search["confirm_status"] = I("request.confirm_status");
       $search["confirm_payment"] = I("request.confirm_payment");
       $search["confirm_payment2"] = I("request.confirm_payment2");
       $search["confirm_receive"] = I("request.confirm_receive");
       $search["confirm_receive2"] = I("request.confirm_receive2");
       $search["delivery_no"] = I("request.delivery_no");
       $search["delivery_date"] = I("request.delivery_date");
       $search["delivery_date2"] = I("request.delivery_date2");
       $search["delivery_expired"] = I("request.delivery_expired");
       $search["delivery_expired2"] = I("request.delivery_expired2");
       $search["delivery_company"] = I("request.delivery_company");
       $search["delivery_type"] = I("request.delivery_type");
       $search["assign_status"] = I("request.assign_status");
       $search["assign_time"] = I("request.assign_time");
       $search["assign_time2"] = I("request.assign_time2");
       $search["assign_user"] = I("request.assign_user");
       $search["assign_weight"] = I("request.assign_weight");
       $search["assign_weight2"] = I("request.assign_weight2");
       $search["assign_qty"] = I("request.assign_qty");
       $search["assign_qty2"] = I("request.assign_qty2");
       $search["buyer_storecard_id"] = I("request.buyer_storecard_id");
       $search["buyer_storecard_no"] = I("request.buyer_storecard_no");
       $search["buyer_storecard_allow"] = I("request.buyer_storecard_allow");
       $search["act_weight"] = I("request.act_weight");
       $search["act_weight2"] = I("request.act_weight2");
       $search["act_qty"] = I("request.act_qty");
       $search["act_qty2"] = I("request.act_qty2");
       $search["act_time"] = I("request.act_time");
       $search["act_time2"] = I("request.act_time2");
       $search["act_order"] = I("request.act_order");
       $search["diff_weight"] = I("request.diff_weight");
       $search["diff_weight2"] = I("request.diff_weight2");
       $search["diff_amount"] = I("request.diff_amount");
       $search["diff_amount2"] = I("request.diff_amount2");
       $search["interface_status"] = I("request.interface_status");
       $search["interface_send_status"] = I("request.interface_send_status");
       $search["interface_send_time"] = I("request.interface_send_time");
       $search["interface_send_time2"] = I("request.interface_send_time2");
       $search["interface_send_count"] = I("request.interface_send_count");
       $search["interface_send_count2"] = I("request.interface_send_count2");
       $search["interface_receive"] = I("request.interface_receive");
       $search["interface_receive2"] = I("request.interface_receive2");
       $search["create_time"] = I("request.create_time");
       $search["create_time2"] = I("request.create_time2");

       //判断首次装载是否要赋予缺省值
       if($firstloading){
       }



       $condition="";
       $condition_trade="";
       if($bsearch) {
           //关键字条件
           if($search["_showsearch"]=="hide"  ){
               if($search["_keyword"]){
                   $condition_keyword = "";
                   $condition_keyword = join_condition($condition_keyword,"@trade.trade_no",$search["_keyword"],"char", "both" , 0, "" );
                   $condition_trade = " AND ( ". $condition_keyword .")";
               }
           }else{
               //高级搜索condition
               $condition_trade = join_condition($condition_trade,"@trade.status",$search["status"],"int");
               $condition_trade = join_condition($condition_trade,"@trade.org_id",$search["org_id"],"int");
               $condition_trade = join_condition($condition_trade,"@trade.warehouse_code",$search["warehouse_code"],"char");
               $condition_trade = join_condition($condition_trade,"@trade.customer_id",$search["customer_id"],"int");
               $condition_trade = join_condition($condition_trade,"@trade.customer_name",$search["customer_name"],"char","both");
               $condition_trade = join_condition($condition_trade,"@trade.buyer_id",$search["buyer_id"],"int");
               $condition_trade = join_condition($condition_trade,"@trade.buyer_name",$search["buyer_name"],"char","both");
               $condition_trade = join_condition($condition_trade,"@trade.trade_no",$search["trade_no"],"char");
               $condition_trade = join_condition($condition_trade,"@trade.tx_type",$search["tx_type"],"int");
               $condition_trade = join_condition2($condition_trade,"@trade.tx_date",$search["tx_date"],$search["tx_date2"],"date");
               $condition_trade = join_condition($condition_trade,"@trade.contract_no",$search["contract_no"],"char");
               $condition_trade = join_condition2($condition_trade,"@trade.contract_date",$search["contract_date"],$search["contract_date2"],"date");
               $condition_trade = join_condition($condition_trade,"@trade.is_real",$search["is_real"],"int");
               $condition_trade = join_condition($condition_trade,"@trade.chain_id",$search["chain_id"],"int");
               $condition_trade = join_condition($condition_trade,"@trade.goods_no",$search["goods_no"],"char");
               $condition_trade = join_condition($condition_trade,"@trade.goods_name",$search["goods_name"],"char","both");
               $condition_trade = join_condition($condition_trade,"@trade.style_info",$search["style_info"],"char","both");
               $condition_trade = join_condition($condition_trade,"@trade.materials",$search["materials"],"char");
               $condition_trade = join_condition($condition_trade,"@trade.brand",$search["brand"],"char");
               $condition_trade = join_condition($condition_trade,"@trade.producing_area",$search["producing_area"],"char");
               $condition_trade = join_condition2($condition_trade,"@trade.weight",$search["weight"],$search["weight2"],"decimal");
               $condition_trade = join_condition2($condition_trade,"@trade.price",$search["price"],$search["price2"],"decimal");
               $condition_trade = join_condition2($condition_trade,"@trade.amount",$search["amount"],$search["amount2"],"decimal");
               $condition_trade = join_condition($condition_trade,"@trade.uom_weight",$search["uom_weight"],"char");
               $condition_trade = join_condition($condition_trade,"@trade.uom_qty",$search["uom_qty"],"char");
               $condition_trade = join_condition($condition_trade,"@trade.cust_confirm_status",$search["cust_confirm_status"],"int");
               $condition_trade = join_condition2($condition_trade,"@trade.cust_confirm_time",$search["cust_confirm_time"],$search["cust_confirm_time2"],"datetime");
               $condition_trade = join_condition($condition_trade,"@trade.cust_confirm_user",$search["cust_confirm_user"],"char");
               $condition_trade = join_condition($condition_trade,"@trade.buyer_confirm_status",$search["buyer_confirm_status"],"int");
               $condition_trade = join_condition2($condition_trade,"@trade.buyer_confirm_time",$search["buyer_confirm_time"],$search["buyer_confirm_time2"],"datetime");
               $condition_trade = join_condition($condition_trade,"@trade.buyer_confirm_user",$search["buyer_confirm_user"],"char");
               $condition_trade = join_condition($condition_trade,"@trade.cust_send_type",$search["cust_send_type"],"int");
               $condition_trade = join_condition2($condition_trade,"@trade.cust_send_time",$search["cust_send_time"],$search["cust_send_time2"],"datetime");
               $condition_trade = join_condition($condition_trade,"@trade.cust_send_user",$search["cust_send_user"],"char");
               $condition_trade = join_condition($condition_trade,"@trade.storefee_bears",$search["storefee_bears"],"int");
               $condition_trade = join_condition2($condition_trade,"@trade.storefee_require",$search["storefee_require"],$search["storefee_require2"],"int");
               $condition_trade = join_condition2($condition_trade,"@trade.storefee_start",$search["storefee_start"],$search["storefee_start2"],"datetime");
               $condition_trade = join_condition($condition_trade,"@trade.payment_require",$search["payment_require"],"int");
               $condition_trade = join_condition2($condition_trade,"@trade.payment_expire",$search["payment_expire"],$search["payment_expire2"],"datetime");
               $condition_trade = join_condition($condition_trade,"@trade.confirm_status",$search["confirm_status"],"int");
               $condition_trade = join_condition2($condition_trade,"@trade.confirm_payment",$search["confirm_payment"],$search["confirm_payment2"],"decimal");
               $condition_trade = join_condition2($condition_trade,"@trade.confirm_receive",$search["confirm_receive"],$search["confirm_receive2"],"decimal");
               $condition_trade = join_condition($condition_trade,"@trade.delivery_no",$search["delivery_no"],"char");
               $condition_trade = join_condition2($condition_trade,"@trade.delivery_date",$search["delivery_date"],$search["delivery_date2"],"date");
               $condition_trade = join_condition2($condition_trade,"@trade.delivery_expired",$search["delivery_expired"],$search["delivery_expired2"],"datetime");
               $condition_trade = join_condition($condition_trade,"@trade.delivery_company",$search["delivery_company"],"char","both");
               $condition_trade = join_condition($condition_trade,"@trade.delivery_type",$search["delivery_type"],"int");
               $condition_trade = join_condition($condition_trade,"@trade.assign_status",$search["assign_status"],"int");
               $condition_trade = join_condition2($condition_trade,"@trade.assign_time",$search["assign_time"],$search["assign_time2"],"datetime");
               $condition_trade = join_condition($condition_trade,"@trade.assign_user",$search["assign_user"],"char");
               $condition_trade = join_condition2($condition_trade,"@trade.assign_weight",$search["assign_weight"],$search["assign_weight2"],"decimal");
               $condition_trade = join_condition2($condition_trade,"@trade.assign_qty",$search["assign_qty"],$search["assign_qty2"],"decimal");
               $condition_trade = join_condition($condition_trade,"@trade.buyer_storecard_id",$search["buyer_storecard_id"],"int");
               $condition_trade = join_condition($condition_trade,"@trade.buyer_storecard_no",$search["buyer_storecard_no"],"char");
               $condition_trade = join_condition($condition_trade,"@trade.buyer_storecard_allow",$search["buyer_storecard_allow"],"int");
               $condition_trade = join_condition2($condition_trade,"@trade.act_weight",$search["act_weight"],$search["act_weight2"],"decimal");
               $condition_trade = join_condition2($condition_trade,"@trade.act_qty",$search["act_qty"],$search["act_qty2"],"decimal");
               $condition_trade = join_condition2($condition_trade,"@trade.act_time",$search["act_time"],$search["act_time2"],"datetime");
               $condition_trade = join_condition($condition_trade,"@trade.act_order",$search["act_order"],"char");
               $condition_trade = join_condition2($condition_trade,"@trade.diff_weight",$search["diff_weight"],$search["diff_weight2"],"decimal");
               $condition_trade = join_condition2($condition_trade,"@trade.diff_amount",$search["diff_amount"],$search["diff_amount2"],"decimal");
               $condition_trade = join_condition($condition_trade,"@trade.interface_status",$search["interface_status"],"int");
               $condition_trade = join_condition($condition_trade,"@trade.interface_send_status",$search["interface_send_status"],"int");
               $condition_trade = join_condition2($condition_trade,"@trade.interface_send_time",$search["interface_send_time"],$search["interface_send_time2"],"datetime");
               $condition_trade = join_condition2($condition_trade,"@trade.interface_send_count",$search["interface_send_count"],$search["interface_send_count2"],"int");
               $condition_trade = join_condition2($condition_trade,"@trade.interface_receive",$search["interface_receive"],$search["interface_receive2"],"datetime");
               $condition_trade = join_condition2($condition_trade,"@trade.create_time",$search["create_time"],$search["create_time2"],"datetime");
           }

           //增加 tab 条件
           $condition_trade = $this->tabsheet_condition($condition_trade ,$search["_tab"]);
           //增加数据权限
       $auth_condition=$this->get_auth_condition();
       $condition_trade = join_condition_auth($condition_trade,$auth_condition,"");
           //select fields
           $selectfields=" @trade.status ";
           $selectfields.=", @trade.id ";
           $selectfields.=", @trade.org_id ";
           $selectfields.=", @trade.warehouse_code ";
           $selectfields.=", @trade.customer_name ";
           $selectfields.=", @trade.buyer_id ";
           $selectfields.=", @trade.buyer_name ";
           $selectfields.=", @trade.trade_no ";
           $selectfields.=", @trade.tx_type ";
           $selectfields.=", @trade.tx_date ";
           $selectfields.=", @trade.contract_no ";
           $selectfields.=", @trade.contract_date ";
           $selectfields.=", @trade.is_real ";
           $selectfields.=", @trade.chain_id ";
           $selectfields.=", @trade.goods_no ";
           $selectfields.=", @trade.goods_name ";
           $selectfields.=", @trade.style_info ";
           $selectfields.=", @trade.materials ";
           $selectfields.=", @trade.brand ";
           $selectfields.=", @trade.producing_area ";
           $selectfields.=", @trade.weight ";
           $selectfields.=", @trade.price ";
           $selectfields.=", @trade.amount ";
           $selectfields.=", @trade.uom_weight ";
           $selectfields.=", @trade.uom_qty ";
           $selectfields.=", @trade.cust_confirm_status ";
           $selectfields.=", @trade.cust_confirm_time ";
           $selectfields.=", @trade.cust_confirm_user ";
           $selectfields.=", @trade.buyer_confirm_status ";
           $selectfields.=", @trade.buyer_confirm_time ";
           $selectfields.=", @trade.buyer_confirm_user ";
           $selectfields.=", @trade.cust_send_type ";
           $selectfields.=", @trade.cust_send_time ";
           $selectfields.=", @trade.cust_send_user ";
           $selectfields.=", @trade.storefee_bears ";
           $selectfields.=", @trade.storefee_require ";
           $selectfields.=", @trade.storefee_start ";
           $selectfields.=", @trade.payment_require ";
           $selectfields.=", @trade.payment_expire ";
           $selectfields.=", @trade.confirm_status ";
           $selectfields.=", @trade.confirm_payment ";
           $selectfields.=", @trade.confirm_receive ";
           $selectfields.=", @trade.delivery_no ";
           $selectfields.=", @trade.delivery_date ";
           $selectfields.=", @trade.delivery_expired ";
           $selectfields.=", @trade.delivery_company ";
           $selectfields.=", @trade.delivery_type ";
           $selectfields.=", @trade.assign_status ";
           $selectfields.=", @trade.assign_time ";
           $selectfields.=", @trade.assign_user ";
           $selectfields.=", @trade.assign_weight ";
           $selectfields.=", @trade.assign_qty ";
           $selectfields.=", @trade.buyer_storecard_id ";
           $selectfields.=", @trade.buyer_storecard_no ";
           $selectfields.=", @trade.buyer_storecard_allow ";
           $selectfields.=", @trade.act_weight ";
           $selectfields.=", @trade.act_qty ";
           $selectfields.=", @trade.act_time ";
           $selectfields.=", @trade.act_order ";
           $selectfields.=", @trade.diff_weight ";
           $selectfields.=", @trade.diff_amount ";
           $selectfields.=", @trade.interface_status ";
           $selectfields.=", @trade.interface_send_status ";
           $selectfields.=", @trade.interface_send_time ";
           $selectfields.=", @trade.interface_send_count ";
           $selectfields.=", @trade.interface_receive ";
           $selectfields.=", @trade.create_time ";


           $page_size = I("request.pagesize/d");
           if ($page_size<=0){
               $page_size = session("TradeSummary-PageSize");
               if (!$page_size) {
                    $page_size = 10;
               }
           }
           session("TradeSummary-PageSize", $page_size);


           $join="";
           $count_sql = "select count(*) as cnt from @trade  #join#  where 1=1 #condition#";  // ' for skip replace $condition
           $count_sql = str_replace("#join#",$join,$count_sql);
           $count_sql = str_replace("#condition#",$condition_trade,$count_sql);
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
           $sql = "select #selectfields# from @trade  #join# Where 1=1 #condition# #orderby#";
           $sql = str_replace("#selectfields#",$selectfields,$sql);
           $sql = str_replace("#join#",$join,$sql);
           $sql = str_replace("#condition#",$condition_trade,$sql);
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
        $html = $this->fetch("TradeSummary:index");
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

        if(empty($data["funcid"])) $data["funcid"] = "TradeSummary";
        if(!$p){
           $p = 1;
           $export_all = 1;
        }

        $show_list = array();

        $data['summary']='TradeSummary';
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
        $search["warehouse_code"] = I("request.warehouse_code");
        $search["customer_id_name"] = I("request.customer_id_name");
        $search["customer_id"] = I("request.customer_id");
        $search["customer_name"] = I("request.customer_name");
        $search["buyer_id"] = I("request.buyer_id");
        $search["buyer_name"] = I("request.buyer_name");
        $search["trade_no"] = I("request.trade_no");
        $search["tx_type"] = I("request.tx_type");
        $search["tx_date"] = I("request.tx_date");
        $search["tx_date2"] = I("request.tx_date2");
        $search["contract_no"] = I("request.contract_no");
        $search["contract_date"] = I("request.contract_date");
        $search["contract_date2"] = I("request.contract_date2");
        $search["is_real"] = I("request.is_real");
        $search["chain_id"] = I("request.chain_id");
        $search["goods_no"] = I("request.goods_no");
        $search["goods_name"] = I("request.goods_name");
        $search["style_info"] = I("request.style_info");
        $search["materials"] = I("request.materials");
        $search["brand"] = I("request.brand");
        $search["producing_area"] = I("request.producing_area");
        $search["weight"] = I("request.weight");
        $search["weight2"] = I("request.weight2");
        $search["price"] = I("request.price");
        $search["price2"] = I("request.price2");
        $search["amount"] = I("request.amount");
        $search["amount2"] = I("request.amount2");
        $search["uom_weight"] = I("request.uom_weight");
        $search["uom_qty"] = I("request.uom_qty");
        $search["cust_confirm_status"] = I("request.cust_confirm_status");
        $search["cust_confirm_time"] = I("request.cust_confirm_time");
        $search["cust_confirm_time2"] = I("request.cust_confirm_time2");
        $search["cust_confirm_user"] = I("request.cust_confirm_user");
        $search["buyer_confirm_status"] = I("request.buyer_confirm_status");
        $search["buyer_confirm_time"] = I("request.buyer_confirm_time");
        $search["buyer_confirm_time2"] = I("request.buyer_confirm_time2");
        $search["buyer_confirm_user"] = I("request.buyer_confirm_user");
        $search["cust_send_type"] = I("request.cust_send_type");
        $search["cust_send_time"] = I("request.cust_send_time");
        $search["cust_send_time2"] = I("request.cust_send_time2");
        $search["cust_send_user"] = I("request.cust_send_user");
        $search["storefee_bears"] = I("request.storefee_bears");
        $search["storefee_require"] = I("request.storefee_require");
        $search["storefee_require2"] = I("request.storefee_require2");
        $search["storefee_start"] = I("request.storefee_start");
        $search["storefee_start2"] = I("request.storefee_start2");
        $search["payment_require"] = I("request.payment_require");
        $search["payment_expire"] = I("request.payment_expire");
        $search["payment_expire2"] = I("request.payment_expire2");
        $search["confirm_status"] = I("request.confirm_status");
        $search["confirm_payment"] = I("request.confirm_payment");
        $search["confirm_payment2"] = I("request.confirm_payment2");
        $search["confirm_receive"] = I("request.confirm_receive");
        $search["confirm_receive2"] = I("request.confirm_receive2");
        $search["delivery_no"] = I("request.delivery_no");
        $search["delivery_date"] = I("request.delivery_date");
        $search["delivery_date2"] = I("request.delivery_date2");
        $search["delivery_expired"] = I("request.delivery_expired");
        $search["delivery_expired2"] = I("request.delivery_expired2");
        $search["delivery_company"] = I("request.delivery_company");
        $search["delivery_type"] = I("request.delivery_type");
        $search["assign_status"] = I("request.assign_status");
        $search["assign_time"] = I("request.assign_time");
        $search["assign_time2"] = I("request.assign_time2");
        $search["assign_user"] = I("request.assign_user");
        $search["assign_weight"] = I("request.assign_weight");
        $search["assign_weight2"] = I("request.assign_weight2");
        $search["assign_qty"] = I("request.assign_qty");
        $search["assign_qty2"] = I("request.assign_qty2");
        $search["buyer_storecard_id"] = I("request.buyer_storecard_id");
        $search["buyer_storecard_no"] = I("request.buyer_storecard_no");
        $search["buyer_storecard_allow"] = I("request.buyer_storecard_allow");
        $search["act_weight"] = I("request.act_weight");
        $search["act_weight2"] = I("request.act_weight2");
        $search["act_qty"] = I("request.act_qty");
        $search["act_qty2"] = I("request.act_qty2");
        $search["act_time"] = I("request.act_time");
        $search["act_time2"] = I("request.act_time2");
        $search["act_order"] = I("request.act_order");
        $search["diff_weight"] = I("request.diff_weight");
        $search["diff_weight2"] = I("request.diff_weight2");
        $search["diff_amount"] = I("request.diff_amount");
        $search["diff_amount2"] = I("request.diff_amount2");
        $search["interface_status"] = I("request.interface_status");
        $search["interface_send_status"] = I("request.interface_send_status");
        $search["interface_send_time"] = I("request.interface_send_time");
        $search["interface_send_time2"] = I("request.interface_send_time2");
        $search["interface_send_count"] = I("request.interface_send_count");
        $search["interface_send_count2"] = I("request.interface_send_count2");
        $search["interface_receive"] = I("request.interface_receive");
        $search["interface_receive2"] = I("request.interface_receive2");
        $search["create_time"] = I("request.create_time");
        $search["create_time2"] = I("request.create_time2");


        //condition
        $condition="";
        $condition_trade="";

        //读取关键字搜索内容
        $search["_keyword"] = I("request._keyword");
        if($search["_showsearch"]=="hide"  ){
            if($search["_keyword"]){
                $condition_keyword = "";
                $condition_keyword = join_condition($condition_keyword,"@trade.trade_no",$search["_keyword"],"char", "both" , 0, "" );
                $condition_trade = " AND ( ". $condition_keyword . ")";
            }
        }else{
        //高级搜索condition
           $condition_trade = join_condition($condition_trade,"@trade.status",$search["status"],"int");

           $search_auth_codes = $search["org_id"];
           $condition_trade = join_condition($condition_trade,"@trade.warehouse_code",$search["warehouse_code"],"char");
           $condition_trade = join_condition($condition_trade,"@trade.customer_id",$search["customer_id"],"int");
           $condition_trade = join_condition($condition_trade,"@trade.customer_name",$search["customer_name"],"char","both");
           $condition_trade = join_condition($condition_trade,"@trade.buyer_id",$search["buyer_id"],"int");
           $condition_trade = join_condition($condition_trade,"@trade.buyer_name",$search["buyer_name"],"char","both");
           $condition_trade = join_condition($condition_trade,"@trade.trade_no",$search["trade_no"],"char");
           $condition_trade = join_condition($condition_trade,"@trade.tx_type",$search["tx_type"],"int");
           $condition_trade = join_condition2($condition_trade,"@trade.tx_date",$search["tx_date"],$search["tx_date2"],"date");
           $condition_trade = join_condition($condition_trade,"@trade.contract_no",$search["contract_no"],"char");
           $condition_trade = join_condition2($condition_trade,"@trade.contract_date",$search["contract_date"],$search["contract_date2"],"date");
           $condition_trade = join_condition($condition_trade,"@trade.is_real",$search["is_real"],"int");
           $condition_trade = join_condition($condition_trade,"@trade.chain_id",$search["chain_id"],"int");
           $condition_trade = join_condition($condition_trade,"@trade.goods_no",$search["goods_no"],"char");
           $condition_trade = join_condition($condition_trade,"@trade.goods_name",$search["goods_name"],"char","both");
           $condition_trade = join_condition($condition_trade,"@trade.style_info",$search["style_info"],"char","both");
           $condition_trade = join_condition($condition_trade,"@trade.materials",$search["materials"],"char");
           $condition_trade = join_condition($condition_trade,"@trade.brand",$search["brand"],"char");
           $condition_trade = join_condition($condition_trade,"@trade.producing_area",$search["producing_area"],"char");
           $condition_trade = join_condition2($condition_trade,"@trade.weight",$search["weight"],$search["weight2"],"decimal");
           $condition_trade = join_condition2($condition_trade,"@trade.price",$search["price"],$search["price2"],"decimal");
           $condition_trade = join_condition2($condition_trade,"@trade.amount",$search["amount"],$search["amount2"],"decimal");
           $condition_trade = join_condition($condition_trade,"@trade.uom_weight",$search["uom_weight"],"char");
           $condition_trade = join_condition($condition_trade,"@trade.uom_qty",$search["uom_qty"],"char");
           $condition_trade = join_condition($condition_trade,"@trade.cust_confirm_status",$search["cust_confirm_status"],"int");
           $condition_trade = join_condition2($condition_trade,"@trade.cust_confirm_time",$search["cust_confirm_time"],$search["cust_confirm_time2"],"datetime");
           $condition_trade = join_condition($condition_trade,"@trade.cust_confirm_user",$search["cust_confirm_user"],"char");
           $condition_trade = join_condition($condition_trade,"@trade.buyer_confirm_status",$search["buyer_confirm_status"],"int");
           $condition_trade = join_condition2($condition_trade,"@trade.buyer_confirm_time",$search["buyer_confirm_time"],$search["buyer_confirm_time2"],"datetime");
           $condition_trade = join_condition($condition_trade,"@trade.buyer_confirm_user",$search["buyer_confirm_user"],"char");
           $condition_trade = join_condition($condition_trade,"@trade.cust_send_type",$search["cust_send_type"],"int");
           $condition_trade = join_condition2($condition_trade,"@trade.cust_send_time",$search["cust_send_time"],$search["cust_send_time2"],"datetime");
           $condition_trade = join_condition($condition_trade,"@trade.cust_send_user",$search["cust_send_user"],"char");
           $condition_trade = join_condition($condition_trade,"@trade.storefee_bears",$search["storefee_bears"],"int");
           $condition_trade = join_condition2($condition_trade,"@trade.storefee_require",$search["storefee_require"],$search["storefee_require2"],"int");
           $condition_trade = join_condition2($condition_trade,"@trade.storefee_start",$search["storefee_start"],$search["storefee_start2"],"datetime");
           $condition_trade = join_condition($condition_trade,"@trade.payment_require",$search["payment_require"],"int");
           $condition_trade = join_condition2($condition_trade,"@trade.payment_expire",$search["payment_expire"],$search["payment_expire2"],"datetime");
           $condition_trade = join_condition($condition_trade,"@trade.confirm_status",$search["confirm_status"],"int");
           $condition_trade = join_condition2($condition_trade,"@trade.confirm_payment",$search["confirm_payment"],$search["confirm_payment2"],"decimal");
           $condition_trade = join_condition2($condition_trade,"@trade.confirm_receive",$search["confirm_receive"],$search["confirm_receive2"],"decimal");
           $condition_trade = join_condition($condition_trade,"@trade.delivery_no",$search["delivery_no"],"char");
           $condition_trade = join_condition2($condition_trade,"@trade.delivery_date",$search["delivery_date"],$search["delivery_date2"],"date");
           $condition_trade = join_condition2($condition_trade,"@trade.delivery_expired",$search["delivery_expired"],$search["delivery_expired2"],"datetime");
           $condition_trade = join_condition($condition_trade,"@trade.delivery_company",$search["delivery_company"],"char","both");
           $condition_trade = join_condition($condition_trade,"@trade.delivery_type",$search["delivery_type"],"int");
           $condition_trade = join_condition($condition_trade,"@trade.assign_status",$search["assign_status"],"int");
           $condition_trade = join_condition2($condition_trade,"@trade.assign_time",$search["assign_time"],$search["assign_time2"],"datetime");
           $condition_trade = join_condition($condition_trade,"@trade.assign_user",$search["assign_user"],"char");
           $condition_trade = join_condition2($condition_trade,"@trade.assign_weight",$search["assign_weight"],$search["assign_weight2"],"decimal");
           $condition_trade = join_condition2($condition_trade,"@trade.assign_qty",$search["assign_qty"],$search["assign_qty2"],"decimal");
           $condition_trade = join_condition($condition_trade,"@trade.buyer_storecard_id",$search["buyer_storecard_id"],"int");
           $condition_trade = join_condition($condition_trade,"@trade.buyer_storecard_no",$search["buyer_storecard_no"],"char");
           $condition_trade = join_condition($condition_trade,"@trade.buyer_storecard_allow",$search["buyer_storecard_allow"],"int");
           $condition_trade = join_condition2($condition_trade,"@trade.act_weight",$search["act_weight"],$search["act_weight2"],"decimal");
           $condition_trade = join_condition2($condition_trade,"@trade.act_qty",$search["act_qty"],$search["act_qty2"],"decimal");
           $condition_trade = join_condition2($condition_trade,"@trade.act_time",$search["act_time"],$search["act_time2"],"datetime");
           $condition_trade = join_condition($condition_trade,"@trade.act_order",$search["act_order"],"char");
           $condition_trade = join_condition2($condition_trade,"@trade.diff_weight",$search["diff_weight"],$search["diff_weight2"],"decimal");
           $condition_trade = join_condition2($condition_trade,"@trade.diff_amount",$search["diff_amount"],$search["diff_amount2"],"decimal");
           $condition_trade = join_condition($condition_trade,"@trade.interface_status",$search["interface_status"],"int");
           $condition_trade = join_condition($condition_trade,"@trade.interface_send_status",$search["interface_send_status"],"int");
           $condition_trade = join_condition2($condition_trade,"@trade.interface_send_time",$search["interface_send_time"],$search["interface_send_time2"],"datetime");
           $condition_trade = join_condition2($condition_trade,"@trade.interface_send_count",$search["interface_send_count"],$search["interface_send_count2"],"int");
           $condition_trade = join_condition2($condition_trade,"@trade.interface_receive",$search["interface_receive"],$search["interface_receive2"],"datetime");
           $condition_trade = join_condition2($condition_trade,"@trade.create_time",$search["create_time"],$search["create_time2"],"datetime");
        }
        $condition_trade = $this->tabsheet_condition($condition_trade ,$search["_tab"]);
          $condition_trade = join_condition_shop($condition_trade,"2;@trade.org_id;org_id#3;@trade.customer_id;customer_id",$this->user_shop_id,$search_auth_codes);

        //select fields
        $selectfields="@trade.status ";
        $selectfields.=",@trade.id ";
        $selectfields.=",@trade.org_id ";
        $selectfields.=",@trade.warehouse_code ";
        $selectfields.=",@trade.customer_name ";
        $selectfields.=",@trade.buyer_id ";
        $selectfields.=",@trade.buyer_name ";
        $selectfields.=",@trade.trade_no ";
        $selectfields.=",@trade.tx_type ";
        $selectfields.=",@trade.tx_date ";
        $selectfields.=",@trade.contract_no ";
        $selectfields.=",@trade.contract_date ";
        $selectfields.=",@trade.is_real ";
        $selectfields.=",@trade.chain_id ";
        $selectfields.=",@trade.goods_no ";
        $selectfields.=",@trade.goods_name ";
        $selectfields.=",@trade.style_info ";
        $selectfields.=",@trade.materials ";
        $selectfields.=",@trade.brand ";
        $selectfields.=",@trade.producing_area ";
        $selectfields.=",@trade.weight ";
        $selectfields.=",@trade.price ";
        $selectfields.=",@trade.amount ";
        $selectfields.=",@trade.uom_weight ";
        $selectfields.=",@trade.uom_qty ";
        $selectfields.=",@trade.cust_confirm_status ";
        $selectfields.=",@trade.cust_confirm_time ";
        $selectfields.=",@trade.cust_confirm_user ";
        $selectfields.=",@trade.buyer_confirm_status ";
        $selectfields.=",@trade.buyer_confirm_time ";
        $selectfields.=",@trade.buyer_confirm_user ";
        $selectfields.=",@trade.cust_send_type ";
        $selectfields.=",@trade.cust_send_time ";
        $selectfields.=",@trade.cust_send_user ";
        $selectfields.=",@trade.storefee_bears ";
        $selectfields.=",@trade.storefee_require ";
        $selectfields.=",@trade.storefee_start ";
        $selectfields.=",@trade.payment_require ";
        $selectfields.=",@trade.payment_expire ";
        $selectfields.=",@trade.confirm_status ";
        $selectfields.=",@trade.confirm_payment ";
        $selectfields.=",@trade.confirm_receive ";
        $selectfields.=",@trade.delivery_no ";
        $selectfields.=",@trade.delivery_date ";
        $selectfields.=",@trade.delivery_expired ";
        $selectfields.=",@trade.delivery_company ";
        $selectfields.=",@trade.delivery_type ";
        $selectfields.=",@trade.assign_status ";
        $selectfields.=",@trade.assign_time ";
        $selectfields.=",@trade.assign_user ";
        $selectfields.=",@trade.assign_weight ";
        $selectfields.=",@trade.assign_qty ";
        $selectfields.=",@trade.buyer_storecard_id ";
        $selectfields.=",@trade.buyer_storecard_no ";
        $selectfields.=",@trade.buyer_storecard_allow ";
        $selectfields.=",@trade.act_weight ";
        $selectfields.=",@trade.act_qty ";
        $selectfields.=",@trade.act_time ";
        $selectfields.=",@trade.act_order ";
        $selectfields.=",@trade.diff_weight ";
        $selectfields.=",@trade.diff_amount ";
        $selectfields.=",@trade.interface_status ";
        $selectfields.=",@trade.interface_send_status ";
        $selectfields.=",@trade.interface_send_time ";
        $selectfields.=",@trade.interface_send_count ";
        $selectfields.=",@trade.interface_receive ";
        $selectfields.=",@trade.create_time ";


        $str_header = "";
        if ($show_list['status']==1 || empty($show_list)){
            $str_header .= "状态,";
        }
        if ($show_list['org_id']==1 || empty($show_list)){
            $str_header .= "库联,";
        }
        if ($show_list['warehouse_code']==1 || empty($show_list)){
            $str_header .= "仓库编码,";
        }
        if ($show_list['customer_name']==1 || empty($show_list)){
            $str_header .= "卖出客户,";
        }
        if ($show_list['buyer_id']==1 || empty($show_list)){
            $str_header .= "买入客户,";
        }
        if ($show_list['buyer_name']==1 || empty($show_list)){
            $str_header .= "买入客户,";
        }
        if ($show_list['trade_no']==1 || empty($show_list)){
            $str_header .= "交易单号,";
        }
        if ($show_list['tx_type']==1 || empty($show_list)){
            $str_header .= "交易类型,";
        }
        if ($show_list['tx_date']==1 || empty($show_list)){
            $str_header .= "开单日期,";
        }
        if ($show_list['contract_no']==1 || empty($show_list)){
            $str_header .= "合同号码,";
        }
        if ($show_list['contract_date']==1 || empty($show_list)){
            $str_header .= "合同日期,";
        }
        if ($show_list['is_real']==1 || empty($show_list)){
            $str_header .= "实物,";
        }
        if ($show_list['chain_id']==1 || empty($show_list)){
            $str_header .= "交易链,";
        }
        if ($show_list['goods_no']==1 || empty($show_list)){
            $str_header .= "货品编码,";
        }
        if ($show_list['goods_name']==1 || empty($show_list)){
            $str_header .= "货品名称,";
        }
        if ($show_list['style_info']==1 || empty($show_list)){
            $str_header .= "规格,";
        }
        if ($show_list['materials']==1 || empty($show_list)){
            $str_header .= "材质,";
        }
        if ($show_list['brand']==1 || empty($show_list)){
            $str_header .= "商标,";
        }
        if ($show_list['producing_area']==1 || empty($show_list)){
            $str_header .= "产地,";
        }
        if ($show_list['weight']==1 || empty($show_list)){
            $str_header .= "交易重量,";
        }
        if ($show_list['price']==1 || empty($show_list)){
            $str_header .= "交易价格(元),";
        }
        if ($show_list['amount']==1 || empty($show_list)){
            $str_header .= "交易金额(元),";
        }
        if ($show_list['uom_weight']==1 || empty($show_list)){
            $str_header .= "重量单位,";
        }
        if ($show_list['uom_qty']==1 || empty($show_list)){
            $str_header .= "数量单位,";
        }
        if ($show_list['cust_confirm_status']==1 || empty($show_list)){
            $str_header .= "卖家确认,";
        }
        if ($show_list['cust_confirm_time']==1 || empty($show_list)){
            $str_header .= "卖家确认时间,";
        }
        if ($show_list['cust_confirm_user']==1 || empty($show_list)){
            $str_header .= "卖家确认人员,";
        }
        if ($show_list['buyer_confirm_status']==1 || empty($show_list)){
            $str_header .= "买家确认,";
        }
        if ($show_list['buyer_confirm_time']==1 || empty($show_list)){
            $str_header .= "买家确认时间,";
        }
        if ($show_list['buyer_confirm_user']==1 || empty($show_list)){
            $str_header .= "买家确认人员,";
        }
        if ($show_list['cust_send_type']==1 || empty($show_list)){
            $str_header .= "卖家发送,";
        }
        if ($show_list['cust_send_time']==1 || empty($show_list)){
            $str_header .= "卖家发送时间,";
        }
        if ($show_list['cust_send_user']==1 || empty($show_list)){
            $str_header .= "卖家发送人员,";
        }
        if ($show_list['storefee_bears']==1 || empty($show_list)){
            $str_header .= "仓储费承担,";
        }
        if ($show_list['storefee_require']==1 || empty($show_list)){
            $str_header .= "仓储费起始(天),";
        }
        if ($show_list['storefee_start']==1 || empty($show_list)){
            $str_header .= "仓储费起算日,";
        }
        if ($show_list['payment_require']==1 || empty($show_list)){
            $str_header .= "付款截至类型,";
        }
        if ($show_list['payment_expire']==1 || empty($show_list)){
            $str_header .= "付款截至时间,";
        }
        if ($show_list['confirm_status']==1 || empty($show_list)){
            $str_header .= "收付款登记,";
        }
        if ($show_list['confirm_payment']==1 || empty($show_list)){
            $str_header .= "买家付款(元),";
        }
        if ($show_list['confirm_receive']==1 || empty($show_list)){
            $str_header .= "卖家收款,";
        }
        if ($show_list['delivery_no']==1 || empty($show_list)){
            $str_header .= "提单号码,";
        }
        if ($show_list['delivery_date']==1 || empty($show_list)){
            $str_header .= "提单日期,";
        }
        if ($show_list['delivery_expired']==1 || empty($show_list)){
            $str_header .= "提单截至,";
        }
        if ($show_list['delivery_company']==1 || empty($show_list)){
            $str_header .= "提货公司,";
        }
        if ($show_list['delivery_type']==1 || empty($show_list)){
            $str_header .= "发货方式,";
        }
        if ($show_list['assign_status']==1 || empty($show_list)){
            $str_header .= "配货标志,";
        }
        if ($show_list['assign_time']==1 || empty($show_list)){
            $str_header .= "配货时间,";
        }
        if ($show_list['assign_user']==1 || empty($show_list)){
            $str_header .= "配货人员,";
        }
        if ($show_list['assign_weight']==1 || empty($show_list)){
            $str_header .= "配货重量,";
        }
        if ($show_list['assign_qty']==1 || empty($show_list)){
            $str_header .= "配货数量,";
        }
        if ($show_list['buyer_storecard_id']==1 || empty($show_list)){
            $str_header .= "收货卡,";
        }
        if ($show_list['buyer_storecard_no']==1 || empty($show_list)){
            $str_header .= "收货卡号,";
        }
        if ($show_list['buyer_storecard_allow']==1 || empty($show_list)){
            $str_header .= "追加许可,";
        }
        if ($show_list['act_weight']==1 || empty($show_list)){
            $str_header .= "实发重量,";
        }
        if ($show_list['act_qty']==1 || empty($show_list)){
            $str_header .= "实发数量,";
        }
        if ($show_list['act_time']==1 || empty($show_list)){
            $str_header .= "实发时间,";
        }
        if ($show_list['act_order']==1 || empty($show_list)){
            $str_header .= "实发单号,";
        }
        if ($show_list['diff_weight']==1 || empty($show_list)){
            $str_header .= "重量差异,";
        }
        if ($show_list['diff_amount']==1 || empty($show_list)){
            $str_header .= "差异金额(元),";
        }
        if ($show_list['interface_status']==1 || empty($show_list)){
            $str_header .= "接口状态,";
        }
        if ($show_list['interface_send_status']==1 || empty($show_list)){
            $str_header .= "接口处理,";
        }
        if ($show_list['interface_send_time']==1 || empty($show_list)){
            $str_header .= "接口发送时间,";
        }
        if ($show_list['interface_send_count']==1 || empty($show_list)){
            $str_header .= "接口发送次数,";
        }
        if ($show_list['interface_receive']==1 || empty($show_list)){
            $str_header .= "接口返回时间,";
        }
        if ($show_list['create_time']==1 || empty($show_list)){
            $str_header .= "创建时间,";
        }
        $str_header .= "\r\n";

        $join="";

       $count_sql = "select count(*) as cnt from @trade  #join#  where 1=1 #condition#";  // ' for skip replace $condition
       $count_sql = str_replace("#join#",$join,$count_sql);
       $count_sql = str_replace("#condition#",$condition_trade,$count_sql);

       $count_sql = table($count_sql);
       $count_sql = str_replace("·mailchar·","@",$count_sql);
       $count = M()->query($count_sql);
       $count = $count[0]["cnt"];

           $total_page=0;

        if(!$export_all) {
           $page_size = I("request.pagesize/d");
           $page_size = $page_size <= 0 ? session("TradeSummary-PageSize") : $page_size;
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

        $sql = "select #selectfields# from @trade  #join# Where 1=1 #condition# #orderby#";   // ' for skip replace $selectfields,$condition,$orderby
        $sql = str_replace("#selectfields#",$selectfields,$sql);
        $sql = str_replace("#join#",$join,$sql);
        $sql = str_replace("#condition#",$condition_trade,$sql);
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
            if ($show_list['warehouse_code']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Warehouse("$master[warehouse_code]","name"))."\t,";
            }
            if ($show_list['customer_name']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["customer_name"])."\t,";
            }
            if ($show_list['buyer_id']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["buyer_id"])."\t,";
            }
            if ($show_list['buyer_name']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["buyer_name"])."\t,";
            }
            if ($show_list['trade_no']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["trade_no"])."\t,";
            }
            if ($show_list['tx_type']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Trade_tx_type("$master[tx_type]","name"))."\t,";
            }
            if ($show_list['tx_date']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("D", $master["tx_date"]))."\t,";
            }
            if ($show_list['contract_no']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["contract_no"])."\t,";
            }
            if ($show_list['contract_date']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("D", $master["contract_date"]))."\t,";
            }
            if ($show_list['is_real']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Trade_is_real("$master[is_real]","name"))."\t,";
            }
            if ($show_list['chain_id']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["chain_id"])."\t,";
            }
            if ($show_list['goods_no']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["goods_no"])."\t,";
            }
            if ($show_list['goods_name']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["goods_name"])."\t,";
            }
            if ($show_list['style_info']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["style_info"])."\t,";
            }
            if ($show_list['materials']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["materials"])."\t,";
            }
            if ($show_list['brand']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["brand"])."\t,";
            }
            if ($show_list['producing_area']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["producing_area"])."\t,";
            }
            if ($show_list['weight']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("F33", $master["weight"]))."\t,";
            }
            if ($show_list['price']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("F33", $master["price"]))."\t,";
            }
            if ($show_list['amount']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("F32", $master["amount"]))."\t,";
            }
            if ($show_list['uom_weight']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["uom_weight"])."\t,";
            }
            if ($show_list['uom_qty']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["uom_qty"])."\t,";
            }
            if ($show_list['cust_confirm_status']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Trade_cust_confirm_status("$master[cust_confirm_status]","name"))."\t,";
            }
            if ($show_list['cust_confirm_time']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("DT", $master["cust_confirm_time"]))."\t,";
            }
            if ($show_list['cust_confirm_user']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["cust_confirm_user"])."\t,";
            }
            if ($show_list['buyer_confirm_status']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Trade_buyer_confirm_status("$master[buyer_confirm_status]","name"))."\t,";
            }
            if ($show_list['buyer_confirm_time']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("DT", $master["buyer_confirm_time"]))."\t,";
            }
            if ($show_list['buyer_confirm_user']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["buyer_confirm_user"])."\t,";
            }
            if ($show_list['cust_send_type']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Trade_cust_send_type("$master[cust_send_type]","name"))."\t,";
            }
            if ($show_list['cust_send_time']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("DT", $master["cust_send_time"]))."\t,";
            }
            if ($show_list['cust_send_user']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["cust_send_user"])."\t,";
            }
            if ($show_list['storefee_bears']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Trade_storefee_bears("$master[storefee_bears]","name"))."\t,";
            }
            if ($show_list['storefee_require']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("N3", $master["storefee_require"]))."\t,";
            }
            if ($show_list['storefee_start']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("DT", $master["storefee_start"]))."\t,";
            }
            if ($show_list['payment_require']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Trade_payment_require("$master[payment_require]","name"))."\t,";
            }
            if ($show_list['payment_expire']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("DT", $master["payment_expire"]))."\t,";
            }
            if ($show_list['confirm_status']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Trade_confirm_status("$master[confirm_status]","name"))."\t,";
            }
            if ($show_list['confirm_payment']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("F32", $master["confirm_payment"]))."\t,";
            }
            if ($show_list['confirm_receive']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("F32", $master["confirm_receive"]))."\t,";
            }
            if ($show_list['delivery_no']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["delivery_no"])."\t,";
            }
            if ($show_list['delivery_date']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("D", $master["delivery_date"]))."\t,";
            }
            if ($show_list['delivery_expired']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("DT", $master["delivery_expired"]))."\t,";
            }
            if ($show_list['delivery_company']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["delivery_company"])."\t,";
            }
            if ($show_list['delivery_type']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Trade_delivery_type("$master[delivery_type]","name"))."\t,";
            }
            if ($show_list['assign_status']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Trade_assign_status("$master[assign_status]","name"))."\t,";
            }
            if ($show_list['assign_time']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("DT", $master["assign_time"]))."\t,";
            }
            if ($show_list['assign_user']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["assign_user"])."\t,";
            }
            if ($show_list['assign_weight']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("F33", $master["assign_weight"]))."\t,";
            }
            if ($show_list['assign_qty']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("N3", $master["assign_qty"]))."\t,";
            }
            if ($show_list['buyer_storecard_id']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["buyer_storecard_id"])."\t,";
            }
            if ($show_list['buyer_storecard_no']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["buyer_storecard_no"])."\t,";
            }
            if ($show_list['buyer_storecard_allow']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Trade_buyer_storecard_allow("$master[buyer_storecard_allow]","name"))."\t,";
            }
            if ($show_list['act_weight']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("F33", $master["act_weight"]))."\t,";
            }
            if ($show_list['act_qty']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("N3", $master["act_qty"]))."\t,";
            }
            if ($show_list['act_time']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("DT", $master["act_time"]))."\t,";
            }
            if ($show_list['act_order']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["act_order"])."\t,";
            }
            if ($show_list['diff_weight']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("F33", $master["diff_weight"]))."\t,";
            }
            if ($show_list['diff_amount']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("F32", $master["diff_amount"]))."\t,";
            }
            if ($show_list['interface_status']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Trade_interface_status("$master[interface_status]","name"))."\t,";
            }
            if ($show_list['interface_send_status']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Trade_interface_send_status("$master[interface_send_status]","name"))."\t,";
            }
            if ($show_list['interface_send_time']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("DT", $master["interface_send_time"]))."\t,";
            }
            if ($show_list['interface_send_count']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("N3", $master["interface_send_count"]))."\t,";
            }
            if ($show_list['interface_receive']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("DT", $master["interface_receive"]))."\t,";
            }
            if ($show_list['create_time']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(system_format("DT", $master["create_time"]))."\t,";
            }
            $str_content .= $str_line . "\r\n";
        }
    }
        header('Content-Type: text/xls');
        header ("Content-type:application/vnd.ms-excel;charset=gbk" );
        $str = mb_convert_encoding("TradeSummary", 'gbk', 'utf-8');
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
            $condition.=" @trade.org_id='".$this->user["org_id"]."' ";
            break;
        case "3":
            $condition.=" @trade.customer_id='".$this->user["customer_id"]."' ";
            break;
        }
        return $condition ;
    }
}
