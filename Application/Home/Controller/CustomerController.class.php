<?php
namespace Home\Controller;

//
//注释: Customer - 客户资料信息
//
use Home\Controller\BasicController;
use Think\Log;
class CustomerController extends BasicController {

    public function _init() {
        $funcs = $this->getUserRoleList($this->user,array( 'Customer', '/Home/Customer', ));
        if ($funcs)
            $this->assign("rights",  $funcs);
        else{
            $funcs = array(
                         array("key"=>"refresh","func"=>"Customer","Action"=>"refresh") ,
                         array("key"=>"import","func"=>"/Home/Customer","Action"=>"import") ,
                         array("key"=>"save","func"=>"/Home/Customer","Action"=>"save") ,
                         array("key"=>"search","func"=>"/Home/Customer","Action"=>"view") ,
                         array("key"=>"detail_import","func"=>"/Home/Customer","Action"=>"detail_import") ,
                         array("key"=>"detail_select","func"=>"/Home/Customer","Action"=>"select_product") ,
                         array("key"=>"tabcunchuka","func"=>"/Home/Customer","Action"=>"tabcunchuka") ,
                         array("key"=>"tabjiaoyikaidan","func"=>"/Home/Customer","Action"=>"tabjiaoyikaidan") ,
                         array("key"=>"tabkehuzhangdan","func"=>"/Home/Customer","Action"=>"tabkehuzhangdan") ,
                         array("key"=>"tabkehucunchuhetong","func"=>"/Home/Customer","Action"=>"tabkehucunchuhetong") ,
                         array("key"=>"tabkehudizhi","func"=>"/Home/Customer","Action"=>"tabkehudizhi") ,
                         array("key"=>"tabyonghuxinxi","func"=>"/Home/Customer","Action"=>"tabyonghuxinxi") ,
                         array("key"=>"tabcaozuorizhi","func"=>"/Home/Customer","Action"=>"tabcaozuorizhi") ,
                         array("key"=>"edit_base","func"=>"/Home/Customer","Action"=>"edit_base") ,
                         array("key"=>"order_edit","func"=>"/Home/Customer","Action"=>"edit_base") ,
                         array("key"=>"order_delete","func"=>"/Home/Customer","Action"=>"delete") ,
                         array("key"=>"baseinfo_change","func"=>"/Home/Customer","Action"=>"baseinfo_change") ,
                         array("key"=>"baseinfo_save","func"=>"/Home/Customer","Action"=>"baseinfo_save") ,
                         array("key"=>"contactinfo_change","func"=>"/Home/Customer","Action"=>"contactinfo_change") ,
                         array("key"=>"contactinfo_save","func"=>"/Home/Customer","Action"=>"contactinfo_save") ,
                         array("key"=>"registrationinfo_change","func"=>"/Home/Customer","Action"=>"registrationinfo_change") ,
                         array("key"=>"registrationinfo_save","func"=>"/Home/Customer","Action"=>"registrationinfo_save") ,
                         array("key"=>"invoiceinfo_change","func"=>"/Home/Customer","Action"=>"invoiceinfo_change") ,
                         array("key"=>"invoiceinfo_save","func"=>"/Home/Customer","Action"=>"invoiceinfo_save") ,
                         array("key"=>"message_change","func"=>"/Home/Customer","Action"=>"message_change") ,
                         array("key"=>"message_save","func"=>"/Home/Customer","Action"=>"message_save") ,
                         array("key"=>"contract_change","func"=>"/Home/Customer","Action"=>"contract_change") ,
                         array("key"=>"contract_save","func"=>"/Home/Customer","Action"=>"contract_save") ,
                         array("key"=>"remarks_change","func"=>"/Home/Customer","Action"=>"remarks_change") ,
                         array("key"=>"remarks_save","func"=>"/Home/Customer","Action"=>"remarks_save") ,
                         array("key"=>"status_on","func"=>"/Home/Customer","Action"=>"status_on") ,
                         array("key"=>"status_off","func"=>"/Home/Customer","Action"=>"status_off") ,
                         array("key"=>"audit_on","func"=>"/Home/Customer","Action"=>"audit_on") ,
                         array("key"=>"audit_on_save","func"=>"/Home/Customer","Action"=>"audit_on_save") ,
                         array("key"=>"master_view","func"=>"/Home/Customer","Action"=>"view")
             );
            $this->assign("rights",  $this->GetUserRights($this->user["id"],$funcs ));
        }
        $this->assign("colshow", $this->GetUserColumnDefine($this->user["id"],"Customer"));
    }

    public function index() {
      $data["pfuncid"] = I("request.pfuncid");
      $data["funcid"] = I("request.funcid");
      $data["zindex"] = I("request.zindex/d");
      if(empty($data["funcid"])) $data["funcid"] = "Customer";
      $this->GetLastUrl($data["funcid"]);

      $func = I("request.func");
      if($func != "saveSelectProduct" && $func != "save") {
        $this->GetLastUrl($data["funcid"]);
      }

      switch ($func) {

//// case for add ////
        case "edit":
            $this->edit($data);
            break;
        case "edit_base":
        case "add":
          $this->add($data);
          break;
        case "save":
          $this->save($data);
          break;
//// case for import ////
        case "import":
          $this->import($data);
          break;
        case "import_save":
          $this->import_save($data);
          break;
//// case for status_on ////
        case "status_on":
          $this->status_on($data);
          break;
        case "status_on_save":
          $this->status_on_save($data);
          break;
//// case for status_off ////
        case "status_off":
          $this->status_off($data);
          break;
        case "status_off_save":
          $this->status_off_save($data);
          break;
//##combine_for_add_switch_case##

//// case for view ////
        case "view":
          $this->view($data);
          break;
        case "delete":
          $this->order_delete($data);
          break;
        case "detail_delete":
          $this->detail_delete($data);
          break;
        case "detail_add":
          $this->selectProduct($data);
          break;
        case "saveSelectProduct":
          $this->saveSelectProduct($data);
          break;
        case "add_save":
          $this->add_save($data);
          break;
        case "baseinfo_change":
          $this->baseinfo_change($data);
          break;
        case "baseinfo_save":
          $this->baseinfo_save($data);
          break;
        case "contactinfo_change":
          $this->contactinfo_change($data);
          break;
        case "contactinfo_save":
          $this->contactinfo_save($data);
          break;
        case "registrationinfo_change":
          $this->registrationinfo_change($data);
          break;
        case "registrationinfo_save":
          $this->registrationinfo_save($data);
          break;
        case "invoiceinfo_change":
          $this->invoiceinfo_change($data);
          break;
        case "invoiceinfo_save":
          $this->invoiceinfo_save($data);
          break;
        case "message_change":
          $this->message_change($data);
          break;
        case "message_save":
          $this->message_save($data);
          break;
        case "contract_change":
          $this->contract_change($data);
          break;
        case "contract_save":
          $this->contract_save($data);
          break;
        case "remarks_change":
          $this->remarks_change($data);
          break;
        case "remarks_save":
          $this->remarks_save($data);
          break;
        case "audit_on":
          $this->audit_on($data);
          break;
        case "audit_on_save":
            $this->audit_on_save($data);
            break;
        default :
          $this->ajax_refresh($data ['funcid']);
          break;
      }
    }


//// source for add - begin ////
//    private function add($data) {
//       $id = I("request.id/d");
//       if(!$id){
//          //读接入参数
//          $type = I("request.type");
//          $category_code = I("request.category_code");
//          $code = I("request.code");
//          $name = I("request.name");
//          $full_name = I("request.full_name");
//          $prefix = I("request.prefix");
//          $industry_code = I("request.industry_code");
//          $province = I("request.province");
//          $address = I("request.address");
//          $postcode = I("request.postcode");
//          $phone = I("request.phone");
//          $mobile = I("request.mobile");
//          $linkman = I("request.linkman");
//          $invoice_company = I("request.invoice_company");
//          $invoice_address = I("request.invoice_address");
//          $invoice_phone = I("request.invoice_phone");
//          $invoice_bank = I("request.invoice_bank");
//          $invoice_taxno = I("request.invoice_taxno");
//          $invoice_account = I("request.invoice_account");
//          $CorpBusiCode = I("request.CorpBusiCode");
//          $CorpTaxCode = I("request.CorpTaxCode");
//          $LegalPerName = I("request.LegalPerName");
//          $LegalPerIdType = I("request.LegalPerIdType");
//          $LegalPerIdNo = I("request.LegalPerIdNo");
//          $ContactName = I("request.ContactName");
//          $ContactIdType = I("request.ContactIdType");
//          $ContactIdNo = I("request.ContactIdNo");
//          $ContactMobile = I("request.ContactMobile");
//          $OpenBank = I("request.OpenBank");
//          $OpenAcctNo = I("request.OpenAcctNo");
//          $OpenAcctName = I("request.OpenAcctName");
//          $chinapay_userid = I("request.chinapay_userid");
//          $customer_level = I("request.customer_level");
//          $remarks = I("request.remarks");
//          //赋初值
//          $search["type"] = $type?$type:"";  //第一个选项
//          $search["category_code"] = $category_code?$category_code:"1";  //第一个选项
//          $search["code"] = $code?$code:"";
//          $search["name"] = $name?$name:"";
//          $search["full_name"] = $full_name?$full_name:"";
//          $search["prefix"] = $prefix?$prefix:"";
//          $search["industry_code"] = $industry_code?$industry_code:"1";  //第一个选项
//
//          $search["province"] = $province?$province:"";
//          $search["address"] = $address?$address:"";
//          $search["postcode"] = $postcode?$postcode:"";
//          $search["phone"] = $phone?$phone:"";
//          $search["mobile"] = $mobile?$mobile:"";
//          $search["linkman"] = $linkman?$linkman:"";
//          $search["invoice_company"] = $invoice_company?$invoice_company:"";
//          $search["invoice_address"] = $invoice_address?$invoice_address:"";
//          $search["invoice_phone"] = $invoice_phone?$invoice_phone:"";
//          $search["invoice_bank"] = $invoice_bank?$invoice_bank:"";
//          $search["invoice_taxno"] = $invoice_taxno?$invoice_taxno:"";
//          $search["invoice_account"] = $invoice_account?$invoice_account:"";
//          $search["CorpBusiCode"] = $CorpBusiCode?$CorpBusiCode:"";
//          $search["CorpTaxCode"] = $CorpTaxCode?$CorpTaxCode:"";
//          $search["LegalPerName"] = $LegalPerName?$LegalPerName:"";
//          $search["LegalPerIdType"] = $LegalPerIdType?$LegalPerIdType:"";
//          $search["LegalPerIdNo"] = $LegalPerIdNo?$LegalPerIdNo:"";
//          $search["ContactName"] = $ContactName?$ContactName:"";
//          $search["ContactIdType"] = $ContactIdType?$ContactIdType:"";
//          $search["ContactIdNo"] = $ContactIdNo?$ContactIdNo:"";
//          $search["ContactMobile"] = $ContactMobile?$ContactMobile:"";
//          $search["OpenBank"] = $OpenBank?$OpenBank:"";
//          $search["OpenAcctNo"] = $OpenAcctNo?$OpenAcctNo:"";
//          $search["OpenAcctName"] = $OpenAcctName?$OpenAcctName:"";
//          $search["chinapay_userid"] = $chinapay_userid?$chinapay_userid:"";
//          $search["customer_level"] = $customer_level?$customer_level:"0";  //第一个选项
//          $search["remarks"] = $remarks?$remarks:"";
//       } else {
//          $search = M('customer')->find($id);
//          if(!$search){
//              $this->ajaxResult("客户资料数据不存在" );
//          }
//          $data["id"] = $search["id"];
//       }
//       $data["search"] = $search;
//
//        $data["search"]['country']="中国";
//        $data["search"]['province']="";
//       //添加日期：2019-6-13
//        if($data['search']['category_code']){
//            $ret=M( "customer_category" )
//                ->field("name")
//                ->where("id='".$data['search']['category_code']."'")
//                ->find();
//            if($ret){
//                $data["search"]["parent_id_name"] = $ret["name"];
//            }
//        }
//       foreach($data as $key=>$val) {
//           $this->assign($key, $val);
//       }
//       $html = $this->fetch("Customer:add");
//       echo $html;
//    }

    private function edit($data) {
        $id = I("request.id/d");

        $search = M('customer')->find($id);
        if(!$search){
            $this->ajaxResult("客户资料数据不存在" );
        }
        $data["id"] = $search["id"];

        $data["search"] = $search;

        $data["search"]['country']="中国";
        $data["search"]['province']="";

        foreach($data as $key=>$val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("Customer:edit");
        echo $html;
    }

    private function add_save($data)
    {
        //读取页面输入数据
        $type = I("request.type");
        $category_code = I("request.category_code/s");
//        $parent_id = I("request.parent_id");
        $code = I("request.code");
        $name = I("request.name/s");
        $abbr = I("request.abbr/s");
        $full_name = I("request.full_name/s");
        $prefix = I("request.prefix");
        $industry_code = I("request.industry_code");
        $status = I("request.status/d");

        //非页面输入字段
        $input = array();
        //数据有效性校验，非空/数值负数，范围/日期与今日比较
        //数据校验 - 必输项不能为空
        if(!verify_value($type,"empty","","")) $this->ajaxError("客户类型 不能为空");
        if(!verify_value($code,"empty","","")) $this->ajaxError("客户代码 不能为空");
        if(!verify_value($name,"empty","","")) $this->ajaxError("客户简称 不能为空");
        // "备注" 长度超200位，没有生成非空检测
        $model = M("customer");
        //判断 code 是否重复建立
        $orig = $model->where("code='$code'")->find();
        if ($orig) $this->ajaxError("客户代码 $code 已存在");

        $input["type"] = $type;
        $input["category_code"] = $category_code;
        $input["code"] = $code;
//        $input["parent_id"] = $parent_id;
        $input["name"] = $name;
        $input["abbr"] = $abbr;
        $input["full_name"] = $full_name;
        $input["prefix"] = $prefix;
        $input["industry_code"] = $industry_code;
        $input["status"] = $status;
        $input["create_user"] = session(C("USER_AUTH_KEY"));
        $input["create_time"] = date('Y-m-d H:i:s.n');
        $input["modify_user"] = session(C("USER_AUTH_KEY"));
        $input["modify_time"] =  date('Y-m-d H:i:s.n');
        $model->startTrans();
        $result=false;
        //需要存入日志的字段
        $needSave=array(
            'type'=>'客户类型',
            'category_code'=>'客户分类',
            'code'=>'客户代码',
            'name'=>'客户简称',
            'abbr'=>'客户缩写',
            'full_name'=>'客户全称',
            'prefix'=>'助记码',
            'industry_code'=>'行业分类',
            'customer_level'=>'层级',
        );
        //新增数据 保存数据库
        $result = $id = $model->add($input);
        //建立操作日志
        $result = $result && createLogCommon('customer',$id,'新增客户资料','',"*");

        if($result){
            $model->commit();
        }else{
            $model->rollback();
            echo json_encode(array("msg"=>message("客户资料保存发生错误")));
            die;
        }
        //完成后跳转
        $this->ajaxReturn($data ['pfuncid'],$data ['funcid'],"refresh", "","closepopup", 1 );
        //转到view页面
        $this->ajaxReturn("","",U("Customer/index?func=view&id=$id&pfuncid=".$data ['pfuncid']), tabtitle('客户',$input["code"] ) );
        die;

    }


    private function save($data) {
       $id=I("request.id/d" );
       //读取页面输入数据
       $type = I("request.type");
//     date: 2019-6-13
//     $category_code = I("request.category_code");
       $category_code = I("request.parent_id");

       if(!intval( $category_code )) {
            $category_id = M("customer_category")->field("id")->where("code='" . $category_code . "'")->find();
            $category_code = $category_id["id"];
        }

       $province = I("province");
       $city = I("city");
       $area = I("area");
       $code = I("request.code");
       $name = I("request.name");
       $full_name = I("request.full_name");
       $prefix = I("request.prefix");
       $industry_code = I("request.industry_code");
       $address = I("request.address");
       $postcode = I("request.postcode");
       $phone = I("request.phone");
       $mobile = I("request.mobile");
       $linkman = I("request.linkman");
       $invoice_company = I("request.invoice_company");
       $invoice_address = I("request.invoice_address");
       $invoice_phone = I("request.invoice_phone");
       $invoice_bank = I("request.invoice_bank");
       $invoice_taxno = I("request.invoice_taxno");
       $invoice_account = I("request.invoice_account");
       $CorpBusiCode = I("request.CorpBusiCode");
       $CorpTaxCode = I("request.CorpTaxCode");
       $LegalPerName = I("request.LegalPerName");
       $LegalPerIdType = I("request.LegalPerIdType");
       $LegalPerIdNo = I("request.LegalPerIdNo");
       $ContactName = I("request.ContactName");
       $ContactIdType = I("request.ContactIdType");
       $ContactIdNo = I("request.ContactIdNo");
       $ContactMobile = I("request.ContactMobile");
       $OpenBank = I("request.OpenBank");
       $OpenAcctNo = I("request.OpenAcctNo");
       $OpenAcctName = I("request.OpenAcctName");
       $chinapay_userid = I("request.chinapay_userid");
       $customer_level = I("request.customer_level");
       $remarks = I("request.remarks");
       //非页面输入字段
       $input = array();
       //数据有效性校验，非空/数值负数，范围/日期与今日比较
       //数据校验 - 必输项不能为空
       if(!verify_value($type,"empty","","")) $this->ajaxError("客户类型 不能为空");
       if(!verify_value($code,"empty","","")) $this->ajaxError("客户代码 不能为空");
       if(!verify_value($name,"empty","","")) $this->ajaxError("客户简称 不能为空");
       // "备注" 长度超200位，没有生成非空检测
       $model = M("customer");
       //判断 code 是否重复建立
       $orig = $model->where("code='$code'".($id?" and id!=$id":""))->find();
       if ($orig) $this->ajaxError("客户代码 $code 已存在");
       //页面输入字段

        $areas = I ( "areas" );

        if (! empty ( $areas )) {
            $areas_arr = array ();
            $areas_arr = explode ( '/', $areas );
            if (isset ( $areas_arr [0] )) {
                $province = $areas_arr [0];
            }
            if (isset ( $areas_arr [1] )) {
                $city = $areas_arr [1];
            }
            if (isset ( $areas_arr [2] )) {
                $area = $areas_arr [2];
            }
        }

       $input["type"] = $type;
       $input["category_code"] = $category_code;
       $input["code"] = $code;
       $input["name"] = $name;
       $input["full_name"] = $full_name;
       $input["prefix"] = $prefix;
       $input["industry_code"] = $industry_code;
       $input["province"] = $province;
       $input["city"] = $city;
       $input["area"] = $area;
       $input["address"] = $address;
       $input["postcode"] = $postcode;
       $input["phone"] = $phone;
       $input["mobile"] = $mobile;
       $input["linkman"] = $linkman;
       $input["invoice_company"] = $invoice_company;
       $input["invoice_address"] = $invoice_address;
       $input["invoice_phone"] = $invoice_phone;
       $input["invoice_bank"] = $invoice_bank;
       $input["invoice_taxno"] = $invoice_taxno;
       $input["invoice_account"] = $invoice_account;
       $input["CorpBusiCode"] = $CorpBusiCode;
       $input["CorpTaxCode"] = $CorpTaxCode;
       $input["LegalPerName"] = $LegalPerName;
       $input["LegalPerIdType"] = $LegalPerIdType;
       $input["LegalPerIdNo"] = $LegalPerIdNo;
       $input["ContactName"] = $ContactName;
       $input["ContactIdType"] = $ContactIdType;
       $input["ContactIdNo"] = $ContactIdNo;
       $input["ContactMobile"] = $ContactMobile;
       $input["OpenBank"] = $OpenBank;
       $input["OpenAcctNo"] = $OpenAcctNo;
       $input["OpenAcctName"] = $OpenAcctName;
       $input["chinapay_userid"] = $chinapay_userid;
       $input["customer_level"] = $customer_level;
       $input["remarks"] = $remarks;
       $input["modify_user"] = session(C("USER_AUTH_KEY"));
       $input["modify_time"] =  date('Y-m-d H:i:s.n');
       $model->startTrans();
       $result=false;
       //需要存入日志的字段
       $needSave=array(
            'type'=>'客户类型',
            'category_code'=>'客户分类',
            'code'=>'客户代码',
            'name'=>'客户简称',
            'full_name'=>'客户全称',
            'prefix'=>'助记码',
            'industry_code'=>'行业分类',
            'province'=>'省份',
            'city'=>'城市',
            'area'=>'县区',
            'address'=>'联系地址',
            'postcode'=>'邮政编码',
            'phone'=>'联系电话',
            'mobile'=>'联系手机',
            'linkman'=>'联系人员',
            'invoice_company'=>'开票名称',
            'invoice_address'=>'开票地址',
            'invoice_phone'=>'开票电话',
            'invoice_bank'=>'开票银行',
            'invoice_taxno'=>'开票税号',
            'invoice_account'=>'开票账户',
            'CorpBusiCode'=>'营业执照号',
            'CorpTaxCode'=>'税务登记证',
            'LegalPerName'=>'法人姓名',
            'LegalPerIdType'=>'法人证件类型',
            'LegalPerIdNo'=>'法人证件号码',
            'ContactName'=>'联系人姓名',
            'ContactIdType'=>'联系人证件类型',
            'ContactIdNo'=>'联系人证件号码',
            'ContactMobile'=>'联系人手机',
            'OpenBank'=>'开户银行',
            'OpenAcctNo'=>'开户账户号',
            'OpenAcctName'=>'开户账户名',
            'chinapay_userid'=>'银联账户号',
            'customer_level'=>'层级',
       );
       if(!$id) {
          //新增  建号操作
          $input["create_user"] = session(C("USER_AUTH_KEY"));
          $input["create_time"] = date('Y-m-d H:i:s.n');
          //新增数据 保存数据库
          $result = $id = $model->add($input);
          //建立操作日志
          $result = $result && createLogCommon('customer',$id,'新增客户资料','',"*",'code');
       } else {
          //id存在时判断数据库内数据是否存在
          $orig=$model->where("id='%d'",array($id))->find();
          if(empty($orig)) {
               $this->ajaxError("客户资料数据不存在");
          }
          if($orig["status"]!="0"){
             $this->ajaxError("客户资料非编辑状态");
          }
          //按主键更新数据
          $result = $model->where("id = $id")->save($input);
          $isSaveLog=false;
          foreach ($needSave as $key=>$v) {
              if($orig[$key]!=$input[$key]) {
                  $isSaveLog=true;
                  break;
              }
          }
          if($isSaveLog){
            //建立操作日志
            $result = $result && createLogCommon('customer',$id,'变更客户资料',$orig,'','','code',$needSave);
          }
       }
       if($result){
           $model->commit();
       }else{
           $model->rollback();
           echo json_encode(array("msg"=>message("客户资料保存发生错误")));
           die;
       }
       //完成后跳转
       $this->ajaxReturn($data ['pfuncid'],$data ['funcid'],"refresh", "","closepopup", 1 );
       //转到view页面
       $this->ajaxReturn("","",U("Customer/index?func=view&id=$id&pfuncid=".$data ['pfuncid']), tabtitle('客户',$input["code"] ) );
       die;
    }
//// source for add - end ////
//// source for import - begin ////
    private function import($data){
      $data['orderid'] = I("get.id");
      foreach($data as $key=>$val) {
        $this->assign($key, $val);
      }
      $html = $this->fetch("Customer:import");
      echo $html;
    }
    private function cattext($string, $txt)
    {
        if($string)$string.=",";
        return $string.$txt;
    }
    private function import_save($data)
    {
        $orderid = I("request.orderid/d");
        $file = $_FILES;
        /* ========================================== */
        /* 上传文件 - 判断文件类型csv读取内容         */
        /* ========================================== */
        if (empty($file)) {
            $this->ajaxResult("导入失败:请上传csv文件");
        }
        if (isset($file["import"]) && $file["import"]["error"] == 0) {
            if (is_uploaded_file($file['import']['tmp_name'])) {
                if (substr($file['import']['name'], -4) != ".csv") {
                    $this->ajaxResult("导入失败:请上传csv文件");
                }
            }
        }
        /* ==================================================== */
        /* 上传文件 - 标题行列内容、列数、标题行、数据起始行    */
        /* ==================================================== */
        $header = array(
            "type" => "客户类型",
            "category_code" => "客户分类",
            "code" => "客户代码",
            "name" => "客户简称",
            "full_name" => "客户全称",
            "prefix" => "助记码",
            "industry_code" => "行业分类",
            "province" => "省份",
            "address" => "联系地址",
            "postcode" => "邮政编码",
            "phone" => "联系电话",
            "mobile" => "联系手机",
            "linkman" => "联系人员",
            "invoice_company" => "开票名称",
            "invoice_address" => "开票地址",
            "invoice_phone" => "开票电话",
            "invoice_bank" => "开票银行",
            "invoice_taxno" => "开票税号",
            "invoice_account" => "开票账户",
            "CorpBusiCode" => "营业执照号",
            "CorpTaxCode" => "税务登记证",
            "LegalPerName" => "法人姓名",
            "LegalPerIdType" => "法人证件类型",
            "LegalPerIdNo" => "法人证件号码",
            "ContactName" => "联系人姓名",
            "ContactIdType" => "联系人证件类型",
            "ContactIdNo" => "联系人证件号码",
            "ContactMobile" => "联系人手机",
            "OpenBank" => "开户银行",
            "OpenAcctNo" => "开户账户号",
            "OpenAcctName" => "开户账户名",
            "chinapay_userid" => "银联账户号",
            "customer_level" => "层级",
            "remarks" => "备注",
                       );
        $row_header = 1;
        $row_data = 2;
        $field = array_keys($header);
        $field_count = count($field);
        /* =========================== */
        /* 上传文件 - 读取内容         */
        /* =========================== */
        $h = fopen($file['import']['tmp_name'], 'r');
        $importdatas = array();
        $n = 1;
        while ($row = fgetcsv($h)) {
            if ($n < $row_header) {
                $n++;
                continue;
            }
            $num = count($row);
            if ($n == $row_header) {
                if ($field_count != $num) $this->ajaxResult("导入失败:标题列数与模板不一致");
            } else if ($num > $field_count) {
                $num = $field_count;
            }
            for ($i = 0; $i < $num; $i++) {
                if ($n == 1) continue;
                $importdatas[$n][$field[$i]] = mb_convert_encoding($row[$i], 'utf-8', 'gbk');
            }
            $n++;
        }
        fclose($h);
        if ($n < $row_data) $this->ajaxResult("导入失败:文件内没有数据");
        /* =========================== */
        /* 上传文件 - 标题校验         */
        /* =========================== */
        $err = "";
        foreach ($importdatas[$row_header] as $key => $value) {
            if ($header[$key] != $value) $err = $this->cattext($err, $value);
        }
        if ($err) $this->ajaxResult("导入失败:标题列[$err]与模板定义不一致");
        /* =========================== */
        /* 上传文件 - 数据校验         */
        /* =========================== */
        $i = 0;
        foreach ($importdatas as $k => $row) {
            if ($k >= $row_data) {
               $err_type = "";
               $err_empty = "";
               $err_exist = "";
               if(!verify_value($row["type"],"empty","","")) $err_empty=$this->cattext($err_empty, $header["type"]);
               if(!verify_value($row["code"],"empty","","")) $err_empty=$this->cattext($err_empty, $header["code"]);
               if(!verify_value($row["name"],"empty","","")) $err_empty=$this->cattext($err_empty, $header["name"]);
               if (strlen($row["type"])>0) {
               //数值类型校验
                  if (!verify_value($row["type"], "num"))
                      $err_type = $this->cattext($err_type, $header["type"]);
                  else
                      if ($row["type"] < 0) $err_exist = $this->cattext($err_exist, $header["type"] . "是负数");
               }
               if (strlen($row["customer_level"])>0) {
               //数值类型校验
                  if (!verify_value($row["customer_level"], "num"))
                      $err_type = $this->cattext($err_type, $header["customer_level"]);
                  else
                      if ($row["customer_level"] < 0) $err_exist = $this->cattext($err_exist, $header["customer_level"] . "是负数");
               }
               if ($err_empty || $err_exist || $err_type) {
                   $err .= "第 " . ($i + $row_data) . " 行校验失败\n";
                   if ($err_empty) $err .= "    数据为空: " . $err_empty . "\n";
                   if ($err_exist) $err .= "    数据非法：" . $err_exist . "\n";
                   if ($err_type) $err .= "    类型非法: " . $err_type . "\n";
               }
           }
           $i++;
       }
       //判断 code 是否重复建立
       $i = 0;
       foreach ($importdatas as $k => $row) {
           if ($k >= $row_data){
               $j=0;
               foreach ($importdatas as $k1 => $row1) {
                  if ($k1 >= $row_data and $k1>$k ){
                     if($row["code"]==$row1["code"]){
                         $err .= "第 " . ($i + $row_data). " 与 " . ($j + $row_data). " 行 ".$header["code"] ."\n";
                     }
                  }
                  $j++;
               }
           }
           $i++;
       }
       if ($err) {
           $this->ajaxResult("数据重复:\n" . $err);
       }
       $model = M("customer");
       //关键字重复导入覆盖方式
       $overwrite=true;
       if(!$overwrite){ //非覆盖方式检查是否重复
          //判断 code 是否重复建立
          $i = 0;
          foreach ($importdatas as $k => $row) {
             if ($k >= $row_data){
                $m = $model->where("code='".$row["code"]."'")->find();
                if ($m) $err .= "第 " . ($i + $row_data). " 行 ".$header["code"]."\n";
             }
             $i++;
          }
          if ($err) {
              $this->ajaxResult("数据存在:\n" . $err);
          }
       }
       /* =========================== */
       /* 上传文件 - 数据存储         */
       /* =========================== */
        $model->startTrans();
        $total=0;
        $new=0;
        $edit=0;
        foreach ($importdatas as $row) {
            $input = array();
            $id = 0;
            $m = array();
            //非导入字段-赋初值
            //导入字段
            $input["type"] = $row["type"];
            $input["category_code"] = $row["category_code"];
            $input["code"] = $row["code"];
            $input["name"] = $row["name"];
            $input["full_name"] = $row["full_name"];
            $input["prefix"] = $row["prefix"];
            $input["industry_code"] = $row["industry_code"];
            $input["province"] = $row["province"];
            $input["address"] = $row["address"];
            $input["postcode"] = $row["postcode"];
            $input["phone"] = $row["phone"];
            $input["mobile"] = $row["mobile"];
            $input["linkman"] = $row["linkman"];
            $input["invoice_company"] = $row["invoice_company"];
            $input["invoice_address"] = $row["invoice_address"];
            $input["invoice_phone"] = $row["invoice_phone"];
            $input["invoice_bank"] = $row["invoice_bank"];
            $input["invoice_taxno"] = $row["invoice_taxno"];
            $input["invoice_account"] = $row["invoice_account"];
            $input["CorpBusiCode"] = $row["CorpBusiCode"];
            $input["CorpTaxCode"] = $row["CorpTaxCode"];
            $input["LegalPerName"] = $row["LegalPerName"];
            $input["LegalPerIdType"] = $row["LegalPerIdType"];
            $input["LegalPerIdNo"] = $row["LegalPerIdNo"];
            $input["ContactName"] = $row["ContactName"];
            $input["ContactIdType"] = $row["ContactIdType"];
            $input["ContactIdNo"] = $row["ContactIdNo"];
            $input["ContactMobile"] = $row["ContactMobile"];
            $input["OpenBank"] = $row["OpenBank"];
            $input["OpenAcctNo"] = $row["OpenAcctNo"];
            $input["OpenAcctName"] = $row["OpenAcctName"];
            $input["chinapay_userid"] = $row["chinapay_userid"];
            $input["customer_level"] = $row["customer_level"];
            $input["remarks"] = $row["remarks"];
            //modify_user/time字段
            $input["modify_user"] = session(C("USER_AUTH_KEY"));
            $input["modify_time"] =  date('Y-m-d H:i:s.n');
            //检查是否存在
            //样例 $m = $model->where("code='".$row["code"]."'")->find();
            $orig = $model->where("code='".$row["code"]."'")->find();
            if (!$orig) {
                  //新增
                $input["create_user"] = session(C("USER_AUTH_KEY"));
                $input["create_time"] =  date('Y-m-d H:i:s.n');
                $result = $id = $model->add($input);
                $new++;
                //建立操作日志
                    $result = $result && createLogCommon('customer', $id, '数据导入(新增)',$orig,'','','code',$header);
            } else {
                  //覆盖
                $id = $orig['id'];
                $result = $model->where("id=$id")->save($input);
                $edit++;
                //建立操作日志
                $result = $result && createLogCommon('customer',$id,'数据导入(覆盖)',$orig,'','','code',$header);
            }
            if (!$result) {
                break;
            }
            $total++;
        }
        if ($result) {
            $model->commit();
        } else {
            $model->rollback();
        }
        $this->ajax_hideConfirm();
        $this->ajax_closePopup($data ['funcid']);
        $this->ajax_refresh($data ['pfuncid']);
        $this->ajaxResult("本次导入 $total 条, 新增 $new 条, 覆盖 $edit 条");
        die;
        //$this->ajaxReturn($data ['pfuncid'], $data ['funcid'], "refresh", "", "closepopup");
    }
//// source for import - end ////
//// source for status_on - begin ////
    private function status_on($data) {
        $id = I("request.id/d");
        if(!$id) {
             $this->ajaxResult("客户信息参数不存在");
        }
        $search = M('customer')->find($id);
        if(!$search)
            $this->ajaxResult("客户资料不存在");
        if($search['status']=='7'){
            $this->ajaxResult("客户资料已取消");
        }
        if($search['status']!='0'){
            $this->ajaxResult("客户资料状态已变化，请重新处理");
        }
        $data["search"] = $search;
        $data["id"] = $data["search"]["id"];
        foreach($data as $key=>$val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("Customer:status_on");
        echo $html;
    }
    private function status_on_save($data) {
       $id=I("request.id/d" );
       if(!$id) {
           $this->ajaxResult("客户资料参数不存在");
       }
       //id存在时判断数据库内数据是否存在
       $orig=M("customer")->where("id='%d'",array($id))->find();
       if(empty($orig)) {
           $this->ajaxError("客户资料数据不存在");
       }
       if($orig['status']=='7'){
           $this->ajaxResult("客户资料已取消");
       }
       if($orig['status']!='0'){
           $this->ajaxResult("客户资料状态已变化，请重新处理");
       }
       $reason_tag=I("request.reason_tag" );
       $reason=I("request.reason" );
       $statusdesc="状态[有效], ";
       $input["status"] = "1";  // "文本类型"
       $content=$statusdesc."备注: ";
       if($reason_tag){
            $content.=$reason_tag;
            if ($reason)$content.=", ".$reason;
       }else{
             $content.=$reason;
       }
       $input["modify_user"] = session(C("USER_AUTH_KEY"));
       $input["modify_time"] = date('Y-m-d H:i:s.n');
       $model = M("customer");
       $model->startTrans();
       //按主键更新数据
       $result = $model->where("id = $id")->save($input);
       //建立操作日志
          $result = $result && createLogCommon('customer',$id,'状态调整',$content);
       if($result){
           $model->commit();
       }else{
           $model->rollback();
           echo json_encode(array("msg"=>message("客户资料保存发生错误")));
           die;
       }
       //完成后关闭并刷新父窗口
       $this->ajaxReturn($data ['pfuncid'],$data ['funcid'],"refresh", "","closepopup");
       die;
    }
//// source for status_on - end ////
//// source for status_off - begin ////
    private function status_off($data) {
        $id = I("request.id/d");
        if(!$id) {
             $this->ajaxResult("客户资料参数不存在");
        }
        $search = M('customer')->find($id);
        if(!$search)
            $this->ajaxResult("客户资料不存在");
        if($search['status']=='7'){
            $this->ajaxResult("客户资料已取消");
        }
        if($search['status']!='1'){
            $this->ajaxResult("客户资料状态已变化，请重新处理");
        }
        $data["search"] = $search;
        $data["id"] = $data["search"]["id"];
        foreach($data as $key=>$val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("Customer:status_off");
        echo $html;
    }
    private function status_off_save($data) {
       $id=I("request.id/d" );
       if(!$id) {
           $this->ajaxResult("客户资料参数不存在");
       }
       //id存在时判断数据库内数据是否存在
       $orig=M("customer")->where("id='%d'",array($id))->find();
       if(empty($orig)) {
           $this->ajaxError("客户资料数据不存在");
       }
       if($orig['status']=='7'){
           $this->ajaxResult("客户资料已取消");
       }
       if($orig['status']!='1'){
           $this->ajaxResult("客户资料状态已变化，请重新处理");
       }
       $reason_tag=I("request.reason_tag" );
       $reason=I("request.reason" );
       if(!($reason_tag.$reason)){
           $this->ajaxResult("客户资料状态回退，需注明原因");
       }
       $statusdesc="退回状态[无效], ";
       $input["status"] = "0";  // "文本类型"
       $content=$statusdesc."备注: ";
       if($reason_tag){
            $content.=$reason_tag;
            if ($reason)$content.=", ".$reason;
       }else{
             $content.=$reason;
       }
       $input["modify_user"] = session(C("USER_AUTH_KEY"));
       $input["modify_time"] = date('Y-m-d H:i:s.n');
       $model = M("customer");
       $model->startTrans();
       //按主键更新数据
       $result = $model->where("id = $id")->save($input);
       //建立操作日志
          $result = $result && createLogCommon('customer',$id,'状态调整',$content);
       if($result){
           $model->commit();
       }else{
           $model->rollback();
           echo json_encode(array("msg"=>message("客户资料保存发生错误")));
           die;
       }
       //完成后关闭并刷新父窗口
       $this->ajaxReturn($data ['pfuncid'],$data ['funcid'],"refresh", "","closepopup");
       die;
    }
//// source for status_off - end ////
//##combine_for_add_source##

//// source for status confirm ////

//// source for status view ////
    private function view($data) {
        $data["p"] = I("request.p/d");
        $data["pagesize"] = I("request.pagesize/d");

        $data["id"] = I("request.id/d");
        $data["no"] = I("request.no");
        if(!$data["id"] && !$data["no"]) {
           $this->ajaxError("客户资料信息查询参数非法");
        }
        //condition
        $condition="";
        $joinsql="";
        //select search fields
        $selectmasterfields="@customer.*";

        $sql = table("select #selectfields# from @customer  #join# Where #viewkey# #condition# #orderby#");
        if($data["id"])
           $viewkey=table("@customer.id=$data[id]");
        else
           $viewkey=table("@customer.code='$data[no]'");
        $sql = str_replace("#selectfields#",table($selectmasterfields),$sql);
        $sql = str_replace("#join#",$joinsql,$sql);
        $sql = str_replace("#viewkey#",$viewkey,$sql);
        $sql = str_replace("#condition#",$condition,$sql);
        $sql = str_replace("#orderby#","",$sql);
        $search = M()->query($sql);
        if(!$search){
           $this->ajaxError("客户资料信息信息不存在");
        }

        if($search[0]['invoice_flag'] == '0'){
            $search[0]['invoice_flag'] = '';
        }
        if($search[0]['sms_transfer_out'] == '0'){
            $search[0]['sms_transfer_out'] = '';
        }
        if($search[0]['sms_transfer_in'] == '0'){
            $search[0]['sms_transfer_in'] = '';
        }
        if($search[0]['sms_delivery'] == '0'){
            $search[0]['sms_delivery'] = '';
        }

        if($search[0]["category_code"]!=""){
            $where['code'] = $search[0]["category_code"];
            $where['status'] = 1;
            $category = M("customer_category")->field("name")->where($where)->find();
            $search[0]["customer_category_name"]=$category["name"];
        }
        $data["search"] = current($search);

        if($data["search"] && $data["search"]['parent_id']){
            $parent=M('customer')->where("id='%d'",array($data["search"]['parent_id']))->find();
            if($parent){
                $data["search"]['parent_id_name']=$parent['name'];
            }
        }
        //根据Customer_id查询对应提货信息
        $delivery_sql = "select a.*,b.name from erp_customer_delivery as a join erp_customer as b on a.customer_id = ".$search[0]['id']." and b.id = a.customer_id";
        $delivery_content = M()->query($delivery_sql);

        $data['delivery'] = $delivery_content;

        //step 步骤样例 - 开始
        $step = array();
        $step1 = array();
        step_add($step, '创建时间', $data["search"]['create_time'], $data['search']['reply_status'] == 0);
        step_add($step, '待审', $data["search"]['apply_time'], $data["search"]['reply_status'] == 1 && $data["search"]['lock_status'] == 1);
        step_add($step, '拒绝', $data["search"]['reply_time'], $data["search"]['reply_status'] == 2 && $data["search"]['lock_status'] == 1);
        //if($data["search"]['status']>=1 && $data["search"]['stock_status']==1){
        step_add($step, '通过', $data["search"]['reply_time'], $data["search"]['reply_status'] == 3 && $data["search"]['stock_status'] == 0);

        // 取消/挂起步骤
        step_add($step1, '取消时间', $data["search"]['cancel_time'], $data["search"]['cancel_status'] == 1);
        step_add($step1, '挂起时间', $data["search"]['hangup_time'], $data["search"]['hangup_status'] == 1);
        $step = getOrderStep($step, $step1);
        $data["step"] = $step;
        //step 步骤样例 - 结束

        //按tabsheet - 开始
        $data["id"] = $data["search"]["id"];
        $data["search"]["_tab"] = $this->tabsheet_check(I("request._tab"));
        $page_size=$data["pagesize"] ;//session("Customer-".$data["search"]["_tab"]."-PageSize");
        switch($data["search"]["_tab"])
        {

          case "kucunxinxi":
               $data = $this->tab_kucunxinxi_stock($page_size,$data);
               break;
          case "cunchuka":
               $data = $this->tab_cunchuka_storecard($page_size,$data);
               break;
          case "jiaoyikaidan":
               $data = $this->tab_jiaoyikaidan_trade($page_size,$data);
               break;
          case "kehuzhangdan":
               $data = $this->tab_kehuzhangdan_fee($page_size,$data);
               break;
          case "kehucunchuhetong":
               $data = $this->tab_kehucunchuhetong_customer_contact($page_size,$data);
               break;
          case "kehudizhi":
               $data = $this->tab_kehudizhi_customer_address($page_size,$data);
               break;
          case "yonghuxinxi":
               $data = $this->tab_yonghuxinxi_user($page_size,$data);
               break;
          case "caozuorizhi":
               $data = $this->tab_caozuorizhi_log_common($page_size,$data);
               break;

        }
        $data["search"]["_tab_".$data["search"]["_tab"]."_p"]=$data["p"];
        $data["search"]["_tab_".$data["search"]["_tab"]."_psize"]=$data["page_size"];
        //session("Customer-".$data["search"]["_tab"]."-PageSize", $data["page_size"]);
        //按tabsheet - 结束
        foreach($data as $key=>$val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("Customer:view");
        echo $html;
    }


    function getareas() {
        $id = I ( "id" );
        if(!empty($id))
        {
            $model = M ( "area" );
            $info=$model->where(array("id"=>$id))->find();
            $where= array (
                "parent_id" => $id,
                "status" => 1
            );

            $list = $model->where ($where)->select ();
            echo json_encode ( $list );
        }
    }



    //按tabsheet子程序 - 开始

    private function tab_kucunxinxi_stock($tab_pagesize,$data)
    {
        $orderby="";
        $joinsql="";

        $condition = "" ;

        //select detail fields
        $selectfields="@stock.id ";
        $selectfields.=",@stock.org_id ";
        $selectfields.=",@stock.customer_id ";
        $selectfields.=",@stock.warehouse_code ";
        $selectfields.=",@stock.style_code ";
        $selectfields.=",@stock.weight ";
        $selectfields.=",@stock.qty ";
        $selectfields.=",@stock.bulkcargo ";
        $selectfields.=",@stock.lock_weight ";
        $selectfields.=",@stock.lock_qty ";
        $selectfields.=",@stock.lock_bulkcargo ";
        $selectfields.=",@stock.create_time ";
        $selectfields.=",@stock.modify_time ";

        $viewkey="@stock.customer_id='".$data["search"]["id"]."'";
     if(!$viewkey)
           $this->ajaxError("查询参数非法");
     //      die;

        $page_size = $tab_pagesize;
        if (!$page_size) {
            $page_size = 10;
        }

        $count_sql = table("select count(*) as cnt from @stock  #join# where #viewkey# #condition#");
        $search_sql = table("select #selectfields# from @stock  #join# Where #viewkey# #condition# #orderby#");

        $viewkey = table($viewkey);
        $condition = table($condition);
        $orderby= table($orderby);
        $selectfields= table($selectfields);

        $count_sql = str_replace("#condition#",$condition,$count_sql);
        $count_sql = str_replace("#viewkey#",$viewkey,$count_sql);
        $count_sql = str_replace("#join#",$joinsql,$count_sql);

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

        $sql = str_replace("#selectfields#",$selectfields,$search_sql);
        $sql = str_replace("#join#",$joinsql,$sql);
        $sql = str_replace("#viewkey#",$viewkey,$sql);
        $sql = str_replace("#condition#",$condition,$sql);
        $sql = str_replace("#orderby#",$orderby,$sql);
        $sql .= " LIMIT ". (($data["p"] - 1) * $page_size). ", $page_size";
        $data["list"] = M()->query($sql);
        $pageClass = new \Think\Page($count,$page_size);
        $pageClass->rollPage = 8;
        $data["page"] = $pageClass->show_drp($data["funcid"],"");
        $data["page_size"] = $page_size;

        return $data;
    }

    private function tab_cunchuka_storecard($tab_pagesize,$data)
    {
        $orderby="";
        $joinsql="";


        $condition = "" ;

        //select detail fields
        $selectfields="@storecard.status ";
        $selectfields.=",@storecard.id ";
        $selectfields.=",@storecard.org_id ";
        $selectfields.=",@storecard.customer_id ";
        $selectfields.=",@storecard.storecard_no ";
        $selectfields.=",@storecard.warehouse_code ";
        $selectfields.=",@storecard.customer_name ";
        $selectfields.=",@storecard.goods_id ";
        $selectfields.=",@storecard.goods_no ";
        $selectfields.=",@storecard.goods_name ";
        $selectfields.=",@storecard.style_info ";
        $selectfields.=",@storecard.brand ";
        $selectfields.=",@storecard.producing_area ";
        $selectfields.=",@storecard.style_code ";
        $selectfields.=",@storecard.weight ";
        $selectfields.=",@storecard.qty ";
        $selectfields.=",@storecard.bulkcargo ";
        $selectfields.=",@storecard.lock_weight ";
        $selectfields.=",@storecard.lock_qty ";
        $selectfields.=",@storecard.lock_bulkcargo ";
        $selectfields.=",@storecard.uom_qty ";
        $selectfields.=",@storecard.uom_weight ";
        $selectfields.=",@storecard.uom_bulkcargo ";
        $selectfields.=",@storecard.contact_id ";
        $selectfields.=",@storecard.contact_no ";
        $selectfields.=",@storecard.create_time ";
        $selectfields.=",@storecard.modify_time ";

        $viewkey="@storecard.customer_id='".$data["search"]["id"]."'";
     if(!$viewkey)
           $this->ajaxError("查询参数非法");
     //      die;

        $page_size = $tab_pagesize;
        if (!$page_size) {
            $page_size = 10;
        }

        $count_sql = table("select count(*) as cnt from @storecard  #join# where #viewkey# #condition#");
        $search_sql = table("select #selectfields# from @storecard  #join# Where #viewkey# #condition# #orderby#");

        $viewkey = table($viewkey);
        $condition = table($condition);
        $orderby= table($orderby);
        $selectfields= table($selectfields);

        $count_sql = str_replace("#condition#",$condition,$count_sql);
        $count_sql = str_replace("#viewkey#",$viewkey,$count_sql);
        $count_sql = str_replace("#join#",$joinsql,$count_sql);

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

        $sql = str_replace("#selectfields#",$selectfields,$search_sql);
        $sql = str_replace("#join#",$joinsql,$sql);
        $sql = str_replace("#viewkey#",$viewkey,$sql);
        $sql = str_replace("#condition#",$condition,$sql);
        $sql = str_replace("#orderby#",$orderby,$sql);
        $sql .= " LIMIT ". (($data["p"] - 1) * $page_size). ", $page_size";
        $data["list"] = M()->query($sql);
        $pageClass = new \Think\Page($count,$page_size);
        $pageClass->rollPage = 8;
        $data["page"] = $pageClass->show_drp($data["funcid"],"");
        $data["page_size"] = $page_size;

        return $data;
    }

    private function tab_jiaoyikaidan_trade($tab_pagesize,$data)
    {
        $orderby="";
        $joinsql="";


        $condition = "" ;


        //select detail fields
        $selectfields="@trade.status ";
        $selectfields.=",@trade.id ";
        $selectfields.=",@trade.org_id ";
        $selectfields.=",@trade.warehouse_code ";
        $selectfields.=",@trade.customer_id ";
        $selectfields.=",@trade.customer_name ";
        $selectfields.=",@trade.buyer_id ";
        $selectfields.=",@trade.buyer_name ";
        $selectfields.=",@trade.trade_no ";
        $selectfields.=",@trade.tx_type ";
        $selectfields.=",@trade.tx_date ";
        $selectfields.=",@trade.expired_time ";
        $selectfields.=",@trade.contract_no ";
        $selectfields.=",@trade.contract_date ";
        $selectfields.=",@trade.is_real ";
        $selectfields.=",@trade.chain_id ";
        $selectfields.=",@trade.goods_id ";
        $selectfields.=",@trade.goods_no ";
        $selectfields.=",@trade.goods_name ";
        $selectfields.=",@trade.style_info ";
        $selectfields.=",@trade.brand ";
        $selectfields.=",@trade.producing_area ";
        $selectfields.=",@trade.style_code ";
        $selectfields.=",@trade.weight ";
        $selectfields.=",@trade.price ";
        $selectfields.=",@trade.amount ";
        $selectfields.=",@trade.confirm_status ";
        $selectfields.=",@trade.confirm_payment ";
        $selectfields.=",@trade.confirm_receive ";
        $selectfields.=",@trade.delivery_no ";
        $selectfields.=",@trade.delivery_company ";
        $selectfields.=",@trade.delivery_carno ";
        $selectfields.=",@trade.delivery_contact ";
        $selectfields.=",@trade.delivery_phone ";
        $selectfields.=",@trade.delivery_idcard ";
        $selectfields.=",@trade.delivery_type ";
        $selectfields.=",@trade.delivery_info ";
        $selectfields.=",@trade.assign_status ";
        $selectfields.=",@trade.assign_time ";
        $selectfields.=",@trade.assign_user ";
        $selectfields.=",@trade.assign_weight ";
        $selectfields.=",@trade.assign_qty ";
        $selectfields.=",@trade.assign_bulkcargo ";
        $selectfields.=",@trade.buyer_storecard_id ";
        $selectfields.=",@trade.buyer_storecard_no ";
        $selectfields.=",@trade.buyer_storecard_type ";
        $selectfields.=",@trade.act_weight ";
        $selectfields.=",@trade.act_qty ";
        $selectfields.=",@trade.act_bulkcargo ";
        $selectfields.=",@trade.diff_weight ";
        $selectfields.=",@trade.diff_amount ";
        $selectfields.=",@trade.diff_status ";
        $selectfields.=",@trade.diff_payment ";
        $selectfields.=",@trade.diff_receive ";
        $selectfields.=",@trade.interface_status ";
        $selectfields.=",@trade.interface_process ";
        $selectfields.=",@trade.interface_time ";
        $selectfields.=",@trade.interface_result ";
        $selectfields.=",@trade.uom_weight ";
        $selectfields.=",@trade.uom_qty ";
        $selectfields.=",@trade.uom_bulkcargo ";
        $selectfields.=",@trade.customer_msg ";
        $selectfields.=",@trade.buyer_msg ";
        $selectfields.=",@trade.remarks ";
        $selectfields.=",@trade.create_time ";
        $selectfields.=",@trade.modify_time ";

        $viewkey="@trade.customer_id='".$data["search"]["id"]."'";
     if(!$viewkey)
           $this->ajaxError("查询参数非法");
     //      die;

        $page_size = $tab_pagesize;
        if (!$page_size) {
            $page_size = 10;
        }

        $count_sql = table("select count(*) as cnt from @trade  #join# where #viewkey# #condition#");
        $search_sql = table("select #selectfields# from @trade  #join# Where #viewkey# #condition# #orderby#");

        $viewkey = table($viewkey);
        $condition = table($condition);
        $orderby= table($orderby);
        $selectfields= table($selectfields);

        $count_sql = str_replace("#condition#",$condition,$count_sql);
        $count_sql = str_replace("#viewkey#",$viewkey,$count_sql);
        $count_sql = str_replace("#join#",$joinsql,$count_sql);

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

        $sql = str_replace("#selectfields#",$selectfields,$search_sql);
        $sql = str_replace("#join#",$joinsql,$sql);
        $sql = str_replace("#viewkey#",$viewkey,$sql);
        $sql = str_replace("#condition#",$condition,$sql);
        $sql = str_replace("#orderby#",$orderby,$sql);
        $sql .= " LIMIT ". (($data["p"] - 1) * $page_size). ", $page_size";
        $data["list"] = M()->query($sql);
        $pageClass = new \Think\Page($count,$page_size);
        $pageClass->rollPage = 8;
        $data["page"] = $pageClass->show_drp($data["funcid"],"");
        $data["page_size"] = $page_size;

        return $data;
    }

    private function tab_kehuzhangdan_fee($tab_pagesize,$data)
    {
        $orderby="";
        $joinsql="";


        $condition = "" ;


        //select detail fields
        $selectfields="@fee.status ";
        $selectfields.=",@fee.id ";
        $selectfields.=",@fee.fee_no ";
        $selectfields.=",@fee.org_id ";
        $selectfields.=",@fee.customer_id ";
        $selectfields.=",@fee.customer_name ";
        $selectfields.=",@fee.tx_month ";
        $selectfields.=",@fee.warehouse_code ";
        $selectfields.=",@fee.fee_total ";
        $selectfields.=",@fee.fee_transfer ";
        $selectfields.=",@fee.fee_store ";
        $selectfields.=",@fee.fee_stockin ";
        $selectfields.=",@fee.fee_stockout ";
        $selectfields.=",@fee.fee_other ";
        $selectfields.=",@fee.remarks ";
        $selectfields.=",@fee.create_time ";

        $viewkey="@fee.customer_id='".$data["search"]["id"]."'";
     if(!$viewkey)
           $this->ajaxError("查询参数非法");
     //      die;

        $page_size = $tab_pagesize;
        if (!$page_size) {
            $page_size = 10;
        }

        $count_sql = table("select count(*) as cnt from @fee  #join# where #viewkey# #condition#");
        $search_sql = table("select #selectfields# from @fee  #join# Where #viewkey# #condition# #orderby#");

        $viewkey = table($viewkey);
        $condition = table($condition);
        $orderby= table($orderby);
        $selectfields= table($selectfields);

        $count_sql = str_replace("#condition#",$condition,$count_sql);
        $count_sql = str_replace("#viewkey#",$viewkey,$count_sql);
        $count_sql = str_replace("#join#",$joinsql,$count_sql);

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

        $sql = str_replace("#selectfields#",$selectfields,$search_sql);
        $sql = str_replace("#join#",$joinsql,$sql);
        $sql = str_replace("#viewkey#",$viewkey,$sql);
        $sql = str_replace("#condition#",$condition,$sql);
        $sql = str_replace("#orderby#",$orderby,$sql);
        $sql .= " LIMIT ". (($data["p"] - 1) * $page_size). ", $page_size";
        $data["list"] = M()->query($sql);
        $pageClass = new \Think\Page($count,$page_size);
        $pageClass->rollPage = 8;
        $data["page"] = $pageClass->show_drp($data["funcid"],"");
        $data["page_size"] = $page_size;

        return $data;
    }

    private function tab_kehucunchuhetong_customer_contact($tab_pagesize,$data)
    {
        $orderby="";
        $joinsql="";


        $condition = "" ;


        //select detail fields
        $selectfields="@customer_contact.status ";
        $selectfields.=",@customer_contact.id ";
        $selectfields.=",@customer_contact.org_id ";
        $selectfields.=",@customer_contact.customer_id ";
        $selectfields.=",@customer_contact.contact_no ";
        $selectfields.=",@customer_contact.contact_expire ";
        $selectfields.=",@customer_contact.warehouse_info ";
        $selectfields.=",@customer_contact.fee_info ";
        $selectfields.=",@customer_contact.create_time ";
        $selectfields.=",@customer_contact.modify_time ";

        $viewkey="@customer_contact.customer_id='".$data["search"]["id"]."'";
     if(!$viewkey)
           $this->ajaxError("查询参数非法");
     //      die;

        $page_size = $tab_pagesize;
        if (!$page_size) {
            $page_size = 10;
        }

        $count_sql = table("select count(*) as cnt from @customer_contact  #join# where #viewkey# #condition#");
        $search_sql = table("select #selectfields# from @customer_contact  #join# Where #viewkey# #condition# #orderby#");

        $viewkey = table($viewkey);
        $condition = table($condition);
        $orderby= table($orderby);
        $selectfields= table($selectfields);

        $count_sql = str_replace("#condition#",$condition,$count_sql);
        $count_sql = str_replace("#viewkey#",$viewkey,$count_sql);
        $count_sql = str_replace("#join#",$joinsql,$count_sql);

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

        $sql = str_replace("#selectfields#",$selectfields,$search_sql);
        $sql = str_replace("#join#",$joinsql,$sql);
        $sql = str_replace("#viewkey#",$viewkey,$sql);
        $sql = str_replace("#condition#",$condition,$sql);
        $sql = str_replace("#orderby#",$orderby,$sql);
        $sql .= " LIMIT ". (($data["p"] - 1) * $page_size). ", $page_size";
        $data["list"] = M()->query($sql);
        $pageClass = new \Think\Page($count,$page_size);
        $pageClass->rollPage = 8;
        $data["page"] = $pageClass->show_drp($data["funcid"],"");
        $data["page_size"] = $page_size;

        return $data;
    }

    private function tab_kehudizhi_customer_address($tab_pagesize,$data)
    {
        $orderby="";
        $joinsql="";


        $condition = "" ;


        //select detail fields
        $selectfields="@customer_address.status ";
        $selectfields.=",@customer_address.id ";
        $selectfields.=",@customer_address.customer_id ";
        $selectfields.=",@customer_address.address ";
        $selectfields.=",@customer_address.postcode ";
        $selectfields.=",@customer_address.phone ";
        $selectfields.=",@customer_address.mobile ";
        $selectfields.=",@customer_address.linkman ";

        $viewkey="@customer_address.customer_id='".$data["search"]["id"]."'";
     if(!$viewkey)
           $this->ajaxError("查询参数非法");
     //      die;

        $page_size = $tab_pagesize;
        if (!$page_size) {
            $page_size = 10;
        }

        $count_sql = table("select count(*) as cnt from @customer_address  #join# where #viewkey# #condition#");
        $search_sql = table("select #selectfields# from @customer_address  #join# Where #viewkey# #condition# #orderby#");

        $viewkey = table($viewkey);
        $condition = table($condition);
        $orderby= table($orderby);
        $selectfields= table($selectfields);

        $count_sql = str_replace("#condition#",$condition,$count_sql);
        $count_sql = str_replace("#viewkey#",$viewkey,$count_sql);
        $count_sql = str_replace("#join#",$joinsql,$count_sql);

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

        $sql = str_replace("#selectfields#",$selectfields,$search_sql);
        $sql = str_replace("#join#",$joinsql,$sql);
        $sql = str_replace("#viewkey#",$viewkey,$sql);
        $sql = str_replace("#condition#",$condition,$sql);
        $sql = str_replace("#orderby#",$orderby,$sql);
        $sql .= " LIMIT ". (($data["p"] - 1) * $page_size). ", $page_size";
        $data["list"] = M()->query($sql);
        $pageClass = new \Think\Page($count,$page_size);
        $pageClass->rollPage = 8;
        $data["page"] = $pageClass->show_drp($data["funcid"],"");
        $data["page_size"] = $page_size;

        return $data;
    }

    private function tab_yonghuxinxi_user($tab_pagesize,$data)
    {
        $orderby="";
        $joinsql="";


        $condition = "" ;


        //select detail fields
        $selectfields="@user.status ";
        $selectfields.=",@user.id ";
        $selectfields.=",@user.side ";
        $selectfields.=",@user.org_id ";
        $selectfields.=",@user.customer_id ";
        $selectfields.=",@user.code ";
        $selectfields.=",@user.name ";
        $selectfields.=",@user.sex ";
        $selectfields.=",@user.mobilephone ";
        $selectfields.=",@user.superadmin ";
        $selectfields.=",@user.errpwd_count ";
        $selectfields.=",@user.sort ";
        $selectfields.=",@user.remarks ";
        $selectfields.=",@user.create_time ";
        $selectfields.=",@user.modify_time ";

        $viewkey="@user.customer_id='".$data["search"]["id"]."'";
     if(!$viewkey)
           $this->ajaxError("查询参数非法");
     //      die;

        $page_size = $tab_pagesize;
        if (!$page_size) {
            $page_size = 10;
        }

        $count_sql = table("select count(*) as cnt from @user  #join# where #viewkey# #condition#");
        $search_sql = table("select #selectfields# from @user  #join# Where #viewkey# #condition# #orderby#");

        $viewkey = table($viewkey);
        $condition = table($condition);
        $orderby= table($orderby);
        $selectfields= table($selectfields);

        $count_sql = str_replace("#condition#",$condition,$count_sql);
        $count_sql = str_replace("#viewkey#",$viewkey,$count_sql);
        $count_sql = str_replace("#join#",$joinsql,$count_sql);

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

        $sql = str_replace("#selectfields#",$selectfields,$search_sql);
        $sql = str_replace("#join#",$joinsql,$sql);
        $sql = str_replace("#viewkey#",$viewkey,$sql);
        $sql = str_replace("#condition#",$condition,$sql);
        $sql = str_replace("#orderby#",$orderby,$sql);
        $sql .= " LIMIT ". (($data["p"] - 1) * $page_size). ", $page_size";
        $data["list"] = M()->query($sql);
        $pageClass = new \Think\Page($count,$page_size);
        $pageClass->rollPage = 8;
        $data["page"] = $pageClass->show_drp($data["funcid"],"");
        $data["page_size"] = $page_size;

        return $data;
    }

    private function tab_caozuorizhi_log_common($tab_pagesize,$data)
    {
        $orderby="";
        $joinsql="";


        $condition = "" ;


        //select detail fields
        $selectfields="@log_common.status ";
        $selectfields.=",@log_common.id ";
        $selectfields.=",@log_common.create_time ";
        $selectfields.=",@log_common.data_id ";
        $selectfields.=",@log_common.data_code ";
        $selectfields.=",@log_common.subject ";
        $selectfields.=",@log_common.content ";

        $viewkey="@log_common.data_id='".$data["search"]["id"]."'";
        $viewkey.=" and @log_common.type='customer'";
     if(!$viewkey)
           $this->ajaxError("查询参数非法");
     //      die;

        $page_size = $tab_pagesize;
        if (!$page_size) {
            $page_size = 10;
        }

        $count_sql = table("select count(*) as cnt from @log_common  #join# where #viewkey# #condition#");
        $search_sql = table("select #selectfields# from @log_common  #join# Where #viewkey# #condition# #orderby#");
        $orderby="order by @log_common.id desc";

        $viewkey = table($viewkey);
        $condition = table($condition);
        $orderby= table($orderby);
        $selectfields= table($selectfields);

        $count_sql = str_replace("#condition#",$condition,$count_sql);
        $count_sql = str_replace("#viewkey#",$viewkey,$count_sql);
        $count_sql = str_replace("#join#",$joinsql,$count_sql);

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

        $sql = str_replace("#selectfields#",$selectfields,$search_sql);
        $sql = str_replace("#join#",$joinsql,$sql);
        $sql = str_replace("#viewkey#",$viewkey,$sql);
        $sql = str_replace("#condition#",$condition,$sql);
        $sql = str_replace("#orderby#",$orderby,$sql);
        $sql .= " LIMIT ". (($data["p"] - 1) * $page_size). ", $page_size";
        $data["list"] = M()->query($sql);
        $pageClass = new \Think\Page($count,$page_size);
        $pageClass->rollPage = 8;
        $data["page"] = $pageClass->show_drp($data["funcid"],"");
        $data["page_size"] = $page_size;

        return $data;
    }



    private function tabsheet_check($itab)
    {
        $idefault="kucunxinxi";
        switch($itab)
        {

          case "kucunxinxi":
          case "cunchuka":
          case "jiaoyikaidan":
          case "kehuzhangdan":
          case "kehucunchuhetong":
          case "kehudizhi":
          case "yonghuxinxi":
          case "caozuorizhi":

              break;
          default:
              $itab=$idefault;
              break;
         }
        return $itab;
    }
    //按tabsheet子程序 - 结束

    private function deleteProcess($id) {
        $type=1;
        $smo=M('customer')->where("id='%d'",array($id))->find();
        if(empty($smo)) {
            $this->ajaxResult("客户资料信息数据不存在");
        }
        if($smo['status']!=0){
            $this->ajaxResult("客户资料信息状态不能删除");
        }

        $result=true;
        $result = $result && createLogCommon('customer',$id,($smo['status']?'取消信息':'删除记录'),'');
        if($smo['status']!=0){
            $result = $result && M('customer')->where("id='%d'",array($id))->save(array('status'=>8,'cancel_time'=>date('Y-m-d H:i:s'),'cancel_status'=>1));
        }else{
            $result = $result && M('customer')->where("id='%d'",array($id))->delete();
        }
        return $result;
    }

    private function order_delete($data) {

        $id=I("request.id/d" );
        $type=I("request.type/d" );
        if(!$id) {
             $this->ajaxResult("客户资料信息参数不存在");
        }

        $m=M();
        $m->startTrans();
        $r=$this->deleteProcess($id);
        if($r){
            $m->commit();
        }else{
            $m->rollback();
        }

        $this->ajax_hideConfirm();
        if(!$type){
            $this->ajax_closeTab($data ['funcid']);
        }

        /**
         * date 2019-7-3
         * 原因 ：页面不刷新
         */
        /*$this->ajax_refresh($data ['pfuncid']);
        $this->ajaxResult();*/

        $this->ajaxReturn($data ['pfuncid'],$data ['funcid'],"refresh", "","closepopup" );
        die;
    }

    /**
     * @remakers: 客户联系信息修改页
     */
    private function add($data){
        $id = I('request.id/d');
        $search=M('customer')->where("id='%d'",array($id))->find();

        $data["id"] = $search['id'];

        $data["search"] = $search;
        $data["search"]['country']="中国";
        $data["search"]['province']=$search['province'];

        if($search['code'] || $search['code']){
            $data['search']['title'] = '变更';
        }else{
            $data['search']['title'] = '登记';
        }

        if($data['search']['category_code']){
            $ret=M( "customer_category" )
                ->field("name")
                ->where("code='".$data['search']['category_code']."'")
                ->find();
            if($ret){
                $data["search"]["category_code_name"] = $ret["name"];
            }
        }

        foreach($data as $key=>$val) {
            $this->assign($key, $val);
        }

        $html = $this->fetch("Customer:contactinfo_change");

        echo $html;
    }

    /**
     * @remakers: 客户联系信息执行修改
     */
    private function contactinfo_save($data){
        $id = I("request.id/d");

        $search=M('customer')->where("id='%d'",array($id))->find();

        //非页面输入字段
        $input = array();
        //读取页面输入数据
        $areas = I ( "areas" );
        if (! empty ( $areas )) {
            $areas_arr = array ();
            $areas_arr = explode ( '/', $areas );
            if (isset ( $areas_arr [0] )) {
                $input['province'] = $areas_arr [0];
            }
            if (isset ( $areas_arr [1] )) {
                $input["city"] = $areas_arr [1];
            }
            if (isset ( $areas_arr [2] )) {
                $input["area"] = $areas_arr [2];
            }
        }

        $category_code = I("request.category_code_name");
        if(!intval( $category_code )) {
            $category_id = M("customer_category")->field("code")->where("name='" . $category_code . "'")->find();
            $category_code = $category_id["code"];
        }

        $input['type'] = I("request.type");
        $input['code'] = I("request.code");
        $input['category_code'] = $category_code;
        $input['name'] = I("request.name/s");
        $input['full_name'] = I("request.full_name/s");
        $input['prefix'] = I("request.prefix");
        $input['industry_code'] = I("request.industry_code");
        $input["address"] = I("request.address");
        $input["postcode"] = I("request.postcode");
        $input["phone"] = I("request.phone");
        $input["linkman"] = I("request.linkman");
        $input["mobile"] = I("request.mobile");

        if(!verify_value($input['type'],"empty","","")) $this->ajaxError("客户类型 不能为空");
        if(!verify_value($input['name'],"empty","","")) $this->ajaxError("客户简称 不能为空");
        if(!verify_value($input['full_name'],"empty","","")) $this->ajaxError("客户全称 不能为空");
        if(!verify_value($input["linkman"],"empty","","")) $this->ajaxError("联系人员 不能为空");
        if(!verify_value($input["mobile"],"empty","","")) $this->ajaxError("联系手机 不能为空");

        $model = M("customer");
        $where['code'] = $input['code'];
        $test['id'] = array('neq',$search['id']);
        $list = $model->where($where)->where($test)->find();
        if($list){
            $this->ajaxResult('客户代码 $code 已存在');
        }
        $wheres['name'] = $input['name'];
        $list = $model->where($wheres)->where($test)->find();
        if($list){
            $this->ajaxResult('客户简称已存在');
        }
        $whered['full_name'] = $input['full_name'];
        $list = $model->where($whered)->where($test)->find();
        if($list){
            $this->ajaxResult('客户全称已存在');
        }

        $input["modify_user"] = session(C("USER_AUTH_KEY"));
        $input["modify_time"] =  date('Y-m-d H:i:s.n');
        $model->startTrans();
        $result=false;
        //需要存入日志的字段
        $needSave=array(
            'type'=>'客户类型',
            'category_code'=>'客户分类',
            'name'=>'客户简称',
            'abbr'=>'客户缩写',
            'full_name'=>'客户全称',
            'prefix'=>'助记码',
            'customer_level'=>'层级',
            'province'=>'省份',
            'city'=>'城市',
            'area'=>'县区',
            'address'=>'联系地址',
            'postcode'=>'邮政编码',
            'phone'=>'联系电话',
            'linkman'=>'联系人员',
            'mobile'=>'联系手机',
        );
        if($id){
            //变更数据 保存数据库
            $result = $model->where("id='%d'",array($id))->save($input);
            //建立操作日志
            $result = $result && createLogCommon('customer',$id,'变更客户基本信息','',"*");
        }else{
            //登记数据 保存数据库
            $input["create_user"] = session(C("USER_AUTH_KEY"));
            $input["create_time"] =  date('Y-m-d H:i:s.n');

            $result = $id = $model->add($input);
            //建立操作日志
            $result = $result && createLogCommon('customer',$id,'新增客户资料','',"*");
        }

        if($result){
            $model->commit();
        }else{
            $model->rollback();
            echo json_encode(array("msg"=>message("客户资料变更发生错误")));
            die;
        }
        //完成后跳转
        $this->ajaxReturn($data ['pfuncid'],$data ['funcid'],"refresh", "","closepopup" );
        if(!$id) {
            $this->ajaxReturn("","",U("Customer/index?func=view&id=$id&pfuncid=".$data ['pfuncid']), tabtitle('客户',$input["code"] ) );
        }
        die;
    }

    /**
     * @remakers: 客户注册信息修改页
     */
    private function registrationinfo_change($data){
        $id = I('request.id/d');
        if(!$id) {
            $this->ajaxResult("客户信息参数不存在");
        }
        $search=M('customer')->where("id='%d'",array($id))->find();
        if(empty($search)) {
            $this->ajaxResult("客户资料数据不存在");
        }

        $data["id"] = $search['id'];

        $data["search"] = $search;

        if($search['corpbusicode'] || $search['corptaxcode'] || $search['legalpername']){
            $data['search']['title'] = '变更';
        }else{
            $data['search']['title'] = '登记';
        }
        foreach($data as $key=>$val) {
            $this->assign($key, $val);
        }

        $html = $this->fetch("Customer:registrationinfo_change");
        echo $html;
    }

    /**
     * @remakers: 客户注册信息执行修改
     */
    private function registrationinfo_save($data){
        $id = I("request.id/d");

        if(!$id) {
            $this->ajaxResult("客户信息参数不存在");
        }
        $search=M('customer')->where("id='%d'",array($id))->find();
        if(empty($search)) {
            $this->ajaxResult("客户资料数据不存在");
        }

        //非页面输入字段
        $input = array();
        //读取页面输入数据
        $input["corpbusicode"] = I("request.corpbusicode");
        $input["corptaxcode"] = I("request.corptaxcode");
        $input["legalpername"] = I("request.legalpername");
        $input["legalperidtype"] = I("request.legalperidtype");
        $input["legalperidno"] = I("request.legalperidno");
        $input["contactname"] = I("request.contactname");
        $input["contactidtype"] = I("request.contactidtype");
        $input["contactidno"] = I("request.contactidno");
        $input["contactmobile"] = I("request.contactmobile");
        $input["openbank"] = I("request.openbank");
        $input["openacctno"] = I("request.openacctno");
        $input["openacctname"] = I("request.openacctname");
        //验证必输项
        if(!verify_value($input['corpbusicode'],"empty","","")) $this->ajaxError("营业执照号 不能为空");
        if(!verify_value($input['corptaxcode'],"empty","","")) $this->ajaxError("税务登记证 不能为空");

        $model = M("customer");

        $input["modify_user"] = session(C("USER_AUTH_KEY"));
        $input["modify_time"] =  date('Y-m-d H:i:s.n');
        $model->startTrans();
        $result=false;
        //需要存入日志的字段
        $needSave=array(
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
        );
        //新增数据 保存数据库
        $result = $model->where("id='%d'",array($id))->save($input);
        //建立操作日志
        $result = $result && createLogCommon('customer',$id,'修改客户注册信息','',"*");

        if($result){
            $model->commit();
        }else{
            $model->rollback();
            echo json_encode(array("msg"=>message("客户资料修改发生错误")));
            die;
        }
        //完成后跳转
        $this->ajaxReturn($data ['pfuncid'],$data ['funcid'],"refresh", "","closepopup" );
        die;
    }

    /**
     * @remakers: 客户开票信息修改页
     */
    private function invoiceinfo_change($data){
        $id = I('request.id/d');
        if(!$id) {
            $this->ajaxResult("客户信息参数不存在");
        }
        $search=M('customer')->where("id='%d'",array($id))->find();
        if(empty($search)) {
            $this->ajaxResult("客户资料数据不存在");
        }

        $data["id"] = $search['id'];

        $data["search"] = $search;

        if($search['invoice_company'] || $search['invoice_account'] || $search['invoice_bank']){
            $data['search']['title'] = '变更';
        }else{
            $data['search']['title'] = '登记';
        }
        foreach($data as $key=>$val) {
            $this->assign($key, $val);
        }

        $html = $this->fetch("Customer:invoiceinfo_change");
        echo $html;
    }

    /**
     * @remakers: 客户开票信息执行修改
     */
    private function invoiceinfo_save($data){
        $id = I("request.id/d");

        if(!$id) {
            $this->ajaxResult("客户信息参数不存在");
        }
        $search=M('customer')->where("id='%d'",array($id))->find();
        if(empty($search)) {
            $this->ajaxResult("客户资料数据不存在");
        }

        //非页面输入字段
        $input = array();
        //读取页面输入数据
        $input["invoice_flag"] = I("request.invoice_flag");
        $input["invoice_company"] = I("request.invoice_company");
        $input["invoice_address"] = I("request.invoice_address");
        $input["invoice_phone"] = I("request.invoice_phone");
        $input["invoice_bank"] = I("request.invoice_bank");
        $input["invoice_account"] = I("request.invoice_account");
        $input["invoice_taxno"] = I("request.invoice_taxno");
        $input["invoice_email"] = I("request.invoice_email");
        $input["invoice_mobile"] = I("request.invoice_mobile");
        //验证必输项
        if(!verify_value($input['invoice_flag'],"empty","","")) $this->ajaxError("发票要求 不能为空");

        //地址、电话、银行、账号、税号五项若输入则一项都不能为空
        if($input["invoice_address"] || $input["invoice_phone"] || $input["invoice_bank"] || $input["invoice_account"] || $input["invoice_taxno"]){
            if(empty($input["invoice_address"]) || empty($input["invoice_phone"]) || empty($input["invoice_bank"]) || empty($input["invoice_account"]) || empty($input["invoice_taxno"])){
                $this->ajaxResult('开票地址、电话、银行、账户、税号若填写须全部填写');
            }
        }

        $model = M("customer");

        $input["modify_user"] = session(C("USER_AUTH_KEY"));
        $input["modify_time"] =  date('Y-m-d H:i:s.n');
        $model->startTrans();
        $result=false;
        //需要存入日志的字段
        $needSave=array(
            'invoice_flag'=>'发票要求',
            'invoice_company'=>'开票单位',
            'invoice_address'=>'开票地址',
            'invoice_phone'=>'开票电话',
            'invoice_bank'=>'开票银行',
            'invoice_account'=>'开票账户',
            'invoice_taxno'=>'开票税号',
            'invoice_email'=>'电子票邮箱',
            'invoice_mobile'=>'电子票手机',
        );
        //新增数据 保存数据库
        $result = $model->where("id='%d'",array($id))->save($input);
        //建立操作日志
        $result = $result && createLogCommon('customer',$id,'修改客户开票信息','',"*");

        if($result){
            $model->commit();
        }else{
            $model->rollback();
            echo json_encode(array("msg"=>message("客户资料修改发生错误")));
            die;
        }
        //完成后跳转
        $this->ajaxReturn($data ['pfuncid'],$data ['funcid'],"refresh", "","closepopup" );
        die;
    }

    /**
     * @remakers: 客户短信信息修改页
     */
    private function message_change($data){
        $id = I('request.id/d');
        if(!$id) {
            $this->ajaxResult("客户信息参数不存在");
        }
        $search=M('customer')->where("id='%d'",array($id))->find();
        if(empty($search)) {
            $this->ajaxResult("客户资料数据不存在");
        }

        $data["id"] = $search['id'];

        $data["search"] = $search;

        if($search['sms_phone'] || $search['sms_appellation']){
            $data['search']['title'] = '变更';
        }else{
            $data['search']['title'] = '登记';
        }
        foreach($data as $key=>$val) {
            $this->assign($key, $val);
        }

        $html = $this->fetch("Customer:message_change");
        echo $html;
    }

    /**
     * @remakers: 客户短信信息执行修改
     */
    private function message_save($data){
        $id = I("request.id/d");

        if(!$id) {
            $this->ajaxResult("客户信息参数不存在");
        }
        $search=M('customer')->where("id='%d'",array($id))->find();
        if(empty($search)) {
            $this->ajaxResult("客户资料数据不存在");
        }

        //非页面输入字段
        $input = array();
        //读取页面输入数据
        $input["sms_open"] = I("request.sms_open");
        $input["sms_transfer_out"] = I("request.sms_transfer_out");
        $input["sms_transfer_in"] = I("request.sms_transfer_in");
        $input["sms_delivery"] = I("request.sms_delivery");
        $input["sms_phone"] = I("request.sms_phone");
        $input["sms_appellation"] = I("request.sms_appellation");

        $model = M("customer");

        $input["modify_user"] = session(C("USER_AUTH_KEY"));
        $input["modify_time"] =  date('Y-m-d H:i:s.n');
        $model->startTrans();
        $result=false;
        //需要存入日志的字段
        $needSave=array(
            'sms_open'=>'短信服务',
            'sms_transfer_out'=>'货权转出通知',
            'sms_transfer_in'=>'货权转入通知',
            'sms_delivery'=>'提货时通知',
            'sms_phone'=>'接收手机号',
            'sms_appellation'=>'接收者称呼',
        );
        //新增数据 保存数据库
        $result = $model->where("id='%d'",array($id))->save($input);
        //建立操作日志
        $result = $result && createLogCommon('customer',$id,'修改客户短信信息','',"*");

        if($result){
            $model->commit();
        }else{
            $model->rollback();
            echo json_encode(array("msg"=>message("客户资料修改发生错误")));
            die;
        }
        //完成后跳转
        $this->ajaxReturn($data ['pfuncid'],$data ['funcid'],"refresh", "","closepopup" );
        die;
    }

    /**
     * @remakers: 客户合同信息修改页
     */
    private function contract_change($data){
        $id = I('request.id/d');
        if(!$id) {
            $this->ajaxResult("客户信息参数不存在");
        }
        $search=M('customer')->where("id='%d'",array($id))->find();
        if(empty($search)) {
            $this->ajaxResult("客户资料数据不存在");
        }

        $data["id"] = $search['id'];

        $data["search"] = $search;

        if($search['contract_linkman'] || $search['contract_phone'] || $search['contract_address']){
            $data['search']['title'] = '变更';
        }else{
            $data['search']['title'] = '登记';
        }
        foreach($data as $key=>$val) {
            $this->assign($key, $val);
        }

        $html = $this->fetch("Customer:contract_change");
        echo $html;
    }

    /**
     * @remakers: 客户短信信息执行修改
     */
    private function contract_save($data){
        $id = I("request.id/d");

        if(!$id) {
            $this->ajaxResult("客户信息参数不存在");
        }
        $search=M('customer')->where("id='%d'",array($id))->find();
        if(empty($search)) {
            $this->ajaxResult("客户资料数据不存在");
        }

        //非页面输入字段
        $input = array();
        //读取页面输入数据
        $input["contract_linkman"] = I("request.contract_linkman");
        $input["contract_phone"] = I("request.contract_phone");
        $input["contract_fax"] = I("request.contract_fax");
        $input["contract_address"] = I("request.contract_address");
        $input["feesett_linkman"] = I("request.feesett_linkman");
        $input["feesett_phone"] = I("request.feesett_phone");
        $input["feesett_fax"] = I("request.feesett_fax");
        $input["feesett_address"] = I("request.feesett_address");

        $model = M("customer");

        $input["modify_user"] = session(C("USER_AUTH_KEY"));
        $input["modify_time"] =  date('Y-m-d H:i:s.n');
        $model->startTrans();
        $result=false;
        //需要存入日志的字段
        $needSave=array(
            'contract_linkman'=>'合同联系人员',
            'contract_phone'=>'合同联系电话',
            'contract_fax'=>'合同联系传真',
            'contract_address'=>'合同邮寄地址',
            'feesett_linkman'=>'结算联系人员',
            'feesett_phone'=>'结算联系电话',
            'feesett_fax'=>'结算联系传真',
            'feesett_address'=>'结算对账单寄',
        );
        //新增数据 保存数据库
        $result = $model->where("id='%d'",array($id))->save($input);
        //建立操作日志
        $result = $result && createLogCommon('customer',$id,'修改客户合同信息','',"*");

        if($result){
            $model->commit();
        }else{
            $model->rollback();
            echo json_encode(array("msg"=>message("客户资料修改发生错误")));
            die;
        }
        //完成后跳转
        $this->ajaxReturn($data ['pfuncid'],$data ['funcid'],"refresh", "","closepopup" );
        die;
    }

    /**
     * @remakers: 客户备注信息修改页
     */
    private function remarks_change($data){
        $id = I('request.id/d');
        if(!$id) {
            $this->ajaxResult("客户信息参数不存在");
        }
        $search=M('customer')->where("id='%d'",array($id))->find();
        if(empty($search)) {
            $this->ajaxResult("客户资料数据不存在");
        }

        $data["id"] = $search['id'];

        $data["search"] = $search;

        if($search['remarks']){
            $data['search']['title'] = '变更';
        }else{
            $data['search']['title'] = '登记';
        }
        foreach($data as $key=>$val) {
            $this->assign($key, $val);
        }

        $html = $this->fetch("Customer:remarks_change");
        echo $html;
    }

    /**
     * @remakers: 客户备注信息执行修改
     */
    private function remarks_save($data){
        $id = I("request.id/d");

        if(!$id) {
            $this->ajaxResult("客户信息参数不存在");
        }
        $search=M('customer')->where("id='%d'",array($id))->find();
        if(empty($search)) {
            $this->ajaxResult("客户资料数据不存在");
        }

        //非页面输入字段
        $input = array();
        //读取页面输入数据
        $input["remarks"] = I("request.remarks");

        $model = M("customer");

        $input["modify_user"] = session(C("USER_AUTH_KEY"));
        $input["modify_time"] =  date('Y-m-d H:i:s.n');
        $model->startTrans();
        $result=false;
        //需要存入日志的字段
        $needSave=array(
            'remarks'=>'备注',
        );
        //新增数据 保存数据库
        $result = $model->where("id='%d'",array($id))->save($input);
        //建立操作日志
        $result = $result && createLogCommon('customer',$id,'修改客户备注信息','',"*");

        if($result){
            $model->commit();
        }else{
            $model->rollback();
            echo json_encode(array("msg"=>message("客户资料修改发生错误")));
            die;
        }
        //完成后跳转
        $this->ajaxReturn($data ['pfuncid'],$data ['funcid'],"refresh", "","closepopup" );
        die;
    }


    private function audit_on($data)
    {
        $id = I('request.id/d');

        if(!$id) {
            $this->ajaxResult("客户信息参数不存在");
        }
        $search = M('customer')->find($id);
        if(!$search) {
            $this->ajaxResult("客户资料不存在");
        }

        if($this->user['side'] != '3'){
            $this->ajaxResult('此功能只能由客户操作');
        }

        $data["search"] = $search;
        $data["id"] = $data["search"]["id"];
        foreach($data as $key=>$val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("Customer:audit_on");
        echo $html;
    }

    private function audit_on_save($data)
    {
        $id=I("request.id/d" );
        if(!$id) {
            $this->ajaxResult("客户资料参数不存在");
        }
        //id存在时判断数据库内数据是否存在
        $orig=M("customer")->where("id='%d'",array($id))->find();
        if(empty($orig)) {
            $this->ajaxError("客户资料数据不存在");
        }
        if($this->user['side'] != '3'){
            $this->ajaxResult('此功能只能由客户操作');
        }

        $input = array();
        $needsave = array();
        $reason_tag = I("request.reason_tag");
        $input['apply_content']=I("request.apply_content" );
        if($reason_tag == 0){
            $input['type'] = '0';
            $input['subject'] = '客户申请审核';
            $needsave['apply_times'] = 1;
        }elseif ($reason_tag == 1){
            $input['type'] = '1';
            $input['subject'] = '客户变更申请';
            $needsave['apply_times'] = $orig['apply_times'] + 1;
        }
        $input['customer_id'] = $orig['id'];
        $input['data_id'] = $orig['id'];
        $input['data_code'] = $orig['code'];
        $input['apply_time'] = date('Y-m-d H:i:s.n');
        $input['apply_user'] = session(C("USER_AUTH_KEY"));
        $input["reply_status"] = 1;
        $input['status'] = '0';
        $input['create_time'] = date('Y-m-d H:i:s.n');
        $input['create_user'] = session(C("USER_AUTH_KEY"));
        $input['modify_user'] = session(C("USER_AUTH_KEY"));
        $input['modify_time'] = date('Y-m-d H:i:s.n');
        $needsave['apply_time'] = $input['apply_time'];
        $needsave['apply_user'] = $input['apply_user'];
        $needsave['apply_content'] = $input['apply_content'];
        $needsave['reply_status'] = 1;
        $needsave['lock_status'] = 1;

        $model = M("customer_apply");
        $model->startTrans();
        //按主键更新customer数据
        $save = M('customer')->where("id='%d'",array($orig['id']))->save($needsave);
        //写入customer_apply表
        $result = $model->add($input);
        //建立操作日志
        $result = $result && createLogCommon('customer_apply',$result,$input['subject'],$input['apply_content']);
        if(($result) && $save){
            $model->commit();
        }else{
            $model->rollback();
            echo json_encode(array("msg"=>message("客户申请审核发生错误")));
            die;
        }
        //完成后关闭并刷新父窗口
        $this->ajaxReturn($data ['pfuncid'],$data ['funcid'],"refresh", "","closepopup");
        die;
    }

}
