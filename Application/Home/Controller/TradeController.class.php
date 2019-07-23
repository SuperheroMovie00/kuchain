<?php
namespace Home\Controller;

//
//注释: Trade - 交易开单信息
//
use Home\Controller\BasicController;
use Think\Exception;
use Think\Log;
class TradeController extends BasicController
{

    public function _init()
    {
        $funcs = $this->getUserRoleList($this->user, array('Trade', '/Home/Trade',));
        if ($funcs)
            $this->assign("rights", $funcs);
        else {
            $funcs = array(
                array("key" => "refresh", "func" => "Trade", "Action" => "refresh"),
                array("key" => "import", "func" => "/Home/Trade", "Action" => "import"),
                array("key" => "save", "func" => "/Home/Trade", "Action" => "save"),
                array("key" => "search", "func" => "/Home/Trade", "Action" => "view"),
                array("key" => "detail_import", "func" => "/Home/Trade", "Action" => "detail_import"),
                array("key" => "detail_select", "func" => "/Home/Trade", "Action" => "select_product"),
                array("key" => "tabjiaoyipeihuoduohao", "func" => "/Home/Trade", "Action" => "tabjiaoyipeihuoduohao"),
                array("key" => "tabmingxi", "func" => "/Home/Trade", "Action" => "tabmingxi"),
                array("key" => "tabjiaoyirizhi", "func" => "/Home/Trade", "Action" => "tabjiaoyirizhi"),
                array("key" => "edit_base", "func" => "/Home/Trade", "Action" => "edit_base"),
                array("key" => "order_edit", "func" => "/Home/Trade", "Action" => "edit_base"),
                array("key" => "order_delete", "func" => "/Home/Trade", "Action" => "delete"),
                array("key" => "cancel", "func" => "/Home/Trade", "Action" => "cancel"),
                array("key" => "confirm", "func" => "/Home/Trade", "Action" => "confirm"),
                array("key" => "confirm_rollback", "func" => "/Home/Trade", "Action" => "confirm_rollback"),
                array("key" => "toassign", "func" => "/Home/Trade", "Action" => "toassign"),
                array("key" => "assign_rollback", "func" => "/Home/Trade", "Action" => "assign_rollback"),
                array("key" => "wait_warhouse", "func" => "/Home/Trade", "Action" => "wait_warhouse"),
                array("key" => "wait_rollback", "func" => "/Home/Trade", "Action" => "wait_rollback"),
                array("key" => "warehouse_process", "func" => "/Home/Trade", "Action" => "warehouse_process"),
                array("key" => "warehouse_rollback", "func" => "/Home/Trade", "Action" => "warehouse_rollback"),
                array("key" => "difference", "func" => "/Home/Trade", "Action" => "difference"),
                array("key" => "difference_rollback", "func" => "/Home/Trade", "Action" => "difference_rollback"),
                array("key" => "close", "func" => "/Home/Trade", "Action" => "close"),
                array("key" => "close_rollback", "func" => "/Home/Trade", "Action" => "close_rollback"),
                array("key" => "make_delivery", "func" => "/Home/Trade", "Action" => "make_delivery"),
                array("key" => "deli_save", "func" => "/Home/Trade", "Action" => "deli_save"),
                array("key" => "pay_register", "func" => "/Home/Trade", "Action" => "pay_register"),
                array("key" => "receipts_register", "func" => "/Home/Trade", "Action" => "receipts_register"),
                array("key" => "check_verify", "func" => "/Home/Trade", "Action" => "check_verify"),
                array("key" => "check_receive", "func" => "/Home/Trade", "Action" => "check_receive"),
                array("key" => "master_view", "func" => "/Home/Trade", "Action" => "view"),
                array("key" => "master_edit", "func" => "/Home/Trade", "Action" => "edit"),
                array("key" => "master_delete", "func" => "/Home/Trade", "Action" => "delete"),
                array("key" => "manual_assign", "func" => "/Home/Trade", "Action" => "manual_assign"),
                array("key" => "export_trade_assign", "func" => "/Home/Trade", "Action" => "exportTradeAssign"),
                array("key" => "manual_deliver", "func" => "/Home/Trade", "Action" => "manualDeliver")
            );
            $this->assign("rights", $this->GetUserRights($this->user["id"], $funcs));
        }
        $this->assign("colshow", $this->GetUserColumnDefine($this->user["id"], "Trade"));
    }

    public function index()
    {
        $data["pfuncid"] = I("request.pfuncid");
        $data["funcid"] = I("request.funcid");
        $data["zindex"] = I("request.zindex/d");
        if (empty($data["funcid"])) $data["funcid"] = "Trade";
        $this->GetLastUrl($data["funcid"]);
        $func = I("request.func");

        switch ($func) {
//// case for add ////
            case "edit":
        case "edit_base":
        case "add":
          $this->add($data);
          break;
        case "save":
          $this->save($data);
          break;
            case  "createPDFshift":
                $this->createPDFshift($data);
                break;
            case "createPDFGoodsshift":
                $this->createPDFGoodsshift($data);
                break;
            case "selectStoreCard":
                $this->selectStoreCard($data);
                break;
            case "selectCustomer":
                $this->selectCustomer($data);
                break;
            case "manual_assign":
                $this->manualAssign($data);
                break;
            case "exportTradeAssign":
                $this->exportTradeAssign($data);
                break;
            case "manualDeliver":
                $this->manualDeliver($data);
                break;
//// case for cancel ////
            case "cancel":
                $this->cancel($data);
                break;
            case "cancel_save":
                $this->cancel_save($data);
                break;
//// case for confirm ////
            case "confirm":
                $this->confirm($data);
                break;
            case "confirm_save":
                $this->confirm_save($data);
                break;
//// case for confirm_rollback ////
            case "confirm_rollback":
                $this->confirm_rollback($data);
                break;
            case "confirm_rollback_save":
                $this->confirm_rollback_save($data);
                break;
//// case for toassign ////
            case "toassign":
                $this->toassign($data);
                break;
            case "toassign_save":
                $this->toassign_save($data);
                break;
//// case for assign_rollback ////
            case "assign_rollback":
                $this->assign_rollback($data);
                break;
            case "assign_rollback_save":
                $this->assign_rollback_save($data);
                break;
//// case for wait_warhouse ////
            case "wait_warhouse":
                $this->wait_warhouse($data);
                break;
            case "wait_warhouse_save":
                $this->wait_warhouse_save($data);
                break;
//// case for wait_rollback ////
            case "wait_rollback":
                $this->wait_rollback($data);
                break;
            case "wait_rollback_save":
                $this->wait_rollback_save($data);
                break;
//// case for warehouse_process ////
            case "warehouse_process":
                $this->warehouse_process($data);
                break;
            case "warehouse_process_save":
                $this->warehouse_process_save($data);
                break;
//// case for warehouse_rollback ////
            case "warehouse_rollback":
                $this->warehouse_rollback($data);
                break;
            case "warehouse_rollback_save":
                $this->warehouse_rollback_save($data);
                break;
//// case for difference ////
            case "difference":
                $this->difference($data);
                break;
            case "difference_save":
                $this->difference_save($data);
                break;
//// case for difference_rollback ////
            case "difference_rollback":
                $this->difference_rollback($data);
                break;
            case "difference_rollback_save":
                $this->difference_rollback_save($data);
                break;
//// case for close ////
            case "close":
                $this->close($data);
                break;
            case "close_save":
                $this->close_save($data);
                break;
//// case for close_rollback ////
            case "close_rollback":
                $this->close_rollback($data);
                break;
            case "close_rollback_save":
                $this->close_rollback_save($data);
                break;
            case "make_delivery":
                $this->make_delivery($data);
                break;
            case "deli_save":
                $this->deli_save($data);
                break;
//// case for import ////
            case "import":
                $this->import($data);
                break;
            case "import_save":
                $this->import_save($data);
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
            case "pay_register":
                $this->pay_register($data);
                break;
            case "receipts_register":
                $this->receipts_register($data);
                break;
            case "check_verify":
                $this->check_verify();
                break;
            case "check_receive":
                $this->check_receive($data);
                break;
            case "contract_edit":
                $this->contract_edit($data);
                break;
            case "other_edit_save":
                $this->other_edit_save($data);
                break;
            case "storecard_edit_save":
                $this->storecard_edit_save($data);
                break;
            case "storecard_edit":
                $this->storecard_edit($data);
                break;
            case "get_package_list":
                $this->get_package_list($data);
                break;
            case "get_buttress_list":
                $this->get_buttress_list($data);
                break;
            case "delivery_edit":
                $this->delivery_edit($data);
                break;
            case "assign":
                $this->trade_assign($data);
                break;
            case "assign_del":
                $this->trade_assign_del($data);
                break;
            case "package_del":
                $this->trade_assign_package_del($data);
                break;
            case "buttress_del":
                $this->trade_assign_buttress_del($data);
                break;
            default :
                $this->ajax_refresh($data ['funcid']);
                break;
        }
    }
    //试卷PDF下载
    public function createPDFshift($data)
    {

        $data = ($_GET);
        $id = $data['id'];
        $newtime=date("Y-m-d");
        if (empty($id)) {           
            $this->ajaxError("非法操作");
        }
        $trade = M("trade")->find($id);
        if(empty($trade)){
                $this->ajaxError("单据信息不存在");
        }else{
            if($trade["status"]==='0'){
                $this->ajaxError("单据信息状态失效");
            }
        }

        $customer=M("customer")->find($trade["customer_id"]);
        if(empty($customer)){
            $this->ajaxError("单据客户不存在");
        }else{
            if($customer["status"]==='0'){
                $this->ajaxError("单据客户状态为失效状态");
            }

        }

        ///-----------------////
        ///
        ///     PDF 操作
        ///
        /// ----------------////

        set_time_limit(0);

        $dirUrl = "/Uploads/PDF/";
        $dir = $_SERVER['DOCUMENT_ROOT'] . $dirUrl;
        if(!file_exists($dir)){
            @mkdir($dir,0755);
        }
        $fileName = date("Y-m-d").rand(1000,9999);
        $dir .= $fileName;

        $pdf_file = $dir . ".pdf";



        Vendor('tcpdf.tcpdf');
        Vendor('tcpdf.examples.tcpdf_clude');

        //$pdf = new \tcpdf('Landscape', 'pt', 'A4', true, 'UTF-8', false);
        $pdf = new \tcpdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);



// set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            //$pdf->setLanguageArray($l);
        }

// ---------------------------------------------------------

// set font
        $pdf->SetFont('stsongstdlight', 'B', 20);         //完美支持中文


// add a page
        $pdf->AddPage();


        $pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);
        $pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);

        $pdf->Write(0, $customer["invoice_company"], '', 0, 'C', true, 0, false, false, 0);  //公司名字

        $pdf->SetFont('stsongstdlight', '', 10);

        $pdf->Write(0, '地址:'.$customer["invoice_address"]."    ".'邮编:'.$customer["postcode"], '', 0, 'C', true, 0, false, false, 0);

        $pdf->Write(0, '传真:'.$customer["contract_fax"]."    ".'电话:'.$customer["invoice_phone"]."    ".'网址:'.$customer["invoice_email"], '', 0, 'C', true, 0, false, false, 0);


        $pdf->SetFont('stsongstdlight', 'B', 20);         //完美支持中文
        $pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);
        $pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);



        /*$pdf->SetFont('stsongstdlight', '', 8);*/

        $pdf->SetFont('stsongstdlight', '', 20);
        $pdf->Write(0, '货权转移入库凭证', '', 0, 'C', true, 0, false, false, 0);

        $pdf->SetFont('stsongstdlight', '', 10);
        $pdf->Write(0, '(No:'.'5456456656456'.')', '', 0, 'C', true, 0, false, false, 0);

        $pdf->SetFont('stsongstdlight', '', 8);
        $pdf->Write(0, 'Warehouse warrant', '', 0, 'C', true, 0, false, false, 0);

        $pdf->SetFont('stsongstdlight', '', 12);
// -----------------------------------------------------------------------------

        $tbl = <<<EOD
<table cellspacing="0" cellpadding="1" border="1">
    <tr nobr="true" >
        <td>  货权受让方</td>
        <td colspan="3" >{$trade['customer_name']}</td>
    </tr>
    <tr nobr="true">        
        <td>  仓储合同编号</td>
        <td>{$trade['warehouse_code']}</td>
        <td>  货品品名</td>
        <td>{$trade['goods_name']}</td>
    </tr>
    <tr nobr="true">
        <td>  货权出让方单证号码</td>    
        <td>45646546574654655000000</td>
        <td>  数量</td>
        <td>{$trade['assign_qty']}</td>
    </tr>
    <tr nobr="true">
       <td>  货权受让方</td>
       <td colspan="3" >{$trade['buyer_name']}</td>
    </tr>

</table>

EOD;




        $pdf->writeHTML($tbl, true, false, false, false, '');


        $pdf->SetFont('stsongstdlight', '', 10);

        $pdf->Write(0, '注:1.本入库凭证效用依附于货权出让方的货权转让证明。', '', 0, 'L', true, 0, false, false, 0);

        $pdf->Write(0, '    2.仅作货权受让方入库时的凭证', '', 0, 'L', true, 0, false, false, 0);

        $pdf->Write(0, '    3.必须加盖”仓库专用章，方为有效“', '', 0, 'L', true, 0, false, false, 0);


        $pdf->SetFont('stsongstdlight', 'B', 20);         //完美支持中文
        $pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);
        $pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);


        $pdf->SetFont('stsongstdlight', '', 10);

        $pdf->Write(0, '制单(Compiled by):'."      "."制单日期(Date to be compiled):".$newtime."      "."仓库盖章(Sealed by warehouse)", '', 0, 'R', true, 0, false, false, 0);


// -----------------------------------------------------------------------------

//Close and output PDF document
        //$pdf->Output('example_048.pdf', 'I');

        $pdf->Output($pdf_file, 'F');
        return array("msg"=>'200',"url"=>$pdf_file,);
    }




    private function  createPDFGoodsshift($data){

        $data = ($_GET);
        $id = $data['id'];
        $newtime=date("Y-m-d");
        if (empty($id)) {
            $this->ajaxError("非法操作");
        }
        $trade = M("trade")->find($id);
        if(empty($trade)){
            $this->ajaxError("单据信息不存在");
        }else{
            if($trade["status"]==='0'){
                $this->ajaxError("单据信息状态失效");
            }
        }

        $customer=M("customer")->find($trade["customer_id"]);
        $buyer=M("customer")->find($trade["buyer_id"]);

        if(empty($buyer)){
            $this->ajaxError("买入客户不存在");
        }else{
            if($buyer["status"]==='0'){
                $this->ajaxError("买入客户状态为失效状态");
            }

        }


        if(empty($customer)){
            $this->ajaxError("单据客户不存在");
        }else{
            if($customer["status"]==='0'){
                $this->ajaxError("单据客户状态为失效状态");
            }

        }

        ///-----------------////
        ///
        ///     PDF 操作
        ///
        /// ----------------////

        set_time_limit(0);

        $dirUrl = "/Uploads/PDF/";
        $dir = $_SERVER['DOCUMENT_ROOT'] . $dirUrl;
        if(!file_exists($dir)){
            @mkdir($dir,0755);
        }
        $fileName = date("Y-m-d").rand(1000,9999);
        $dir .= $fileName;

        $pdf_file = $dir . ".pdf";



        Vendor('tcpdf.tcpdf');
        Vendor('tcpdf.examples.tcpdf_clude');

        //$pdf = new \tcpdf('Landscape', 'pt', 'A4', true, 'UTF-8', false);
        $pdf = new \tcpdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);



// set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            //$pdf->setLanguageArray($l);
        }

// ---------------------------------------------------------

// set font
        $pdf->SetFont('stsongstdlight', 'B', 24);         //完美支持中文


// add a page
        $pdf->AddPage();


        $pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);

        $pdf->Write(0, $customer["invoice_company"], '', 0, 'C', true, 0, false, false, 0);  //公司名字

        $pdf->SetFont('stsongstdlight', 'B', 20);         //完美支持中文
        $pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);

        $pdf->SetFont('stsongstdlight', '', 12);
// -----------------------------------------------------------------------------

        $tbl = <<<EOD
          
<table cellspacing="0" cellpadding="1" border="1">
    <tr nobr="true" >
        <td colspan="6"  style="height: 60px" > <font size="22" style="font-weight: bold" >链交割货物流转证明 （No:ZM45654564-3432）</font></td>
    </tr> 
    <tr nobr="true" >
        <td style="height: 30px;text-align: center">  货权受让方</td>
        <td colspan="5" style="height: 30px;text-align: center" >{$buyer['customer_name']}</td>
    </tr>   
    <tr nobr="true">        
        <td style="height: 30px;text-align: center">  仓储合同编号</td>
        <td style="height: 30px;text-align: center">{$trade['warehouse_code']}</td>
        <td style="height: 30px;text-align: center">  转让日期</td>
        <td style="height: 30px;text-align: center">$newtime</td>
        <td style="height: 30px;text-align: center">  数量</td>
        <td style="height: 30px;text-align: center">  {$trade['assign_qty']}</td>
        
    </tr>   
    <tr nobr="true" >
        <td style="height: 30px;text-align: center">  货权出让方</td>
        <td colspan="5" style="height: 30px;text-align: center" >{$customer['customer_name']}</td>
    </tr>   
    <tr nobr="true" >
        <td colspan="6" style="height: 30px;text-align: center">注：1.本流转证明的效果依附于{$customer["invoice_company"]}链交割业务。</td>
    </tr> 
    <tr nobr="true" >
        <td colspan="6" style="height: 30px;text-align: center">    2.必须加盖{$customer["invoice_company"]} “业务专用章”（2）与 {$trade["delivery_company"]} “仓库专用章”方可有效。</td>
    </tr> 
</table>
EOD;

        $pdf->writeHTML($tbl, true, false, false, false, '');

        $pdf->SetFont('stsongstdlight', 'B', 20);         //完美支持中文
        $pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);
        $pdf->SetFont('stsongstdlight', '', 12);

        $tbl = <<<EOD
<table cellspacing="0" cellpadding="1" border="1">
    <tr nobr="true" >
        <td style="height: 30px">  {$customer["invoice_company"]}盖章：</td>
        <td style="height: 30px">  {$buyer["invoice_company"]}盖章：</td>
        <td style="height: 30px">  制单日期：$newtime</td>
    </tr>
</table>
EOD;

        $pdf->writeHTML($tbl, true, false, false, false, '');

        $pdf->SetFont('stsongstdlight', 'B', 20);         //完美支持中文
        $pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);
        $pdf->SetFont('stsongstdlight', '', 12);


        $tbl = <<<EOD
<table cellspacing="0" cellpadding="1" border="0">
    <tr nobr="true" >
        <td>  苏交网网站：www.sujiaoint.com</td>
        <td>  长江国际网站：www.cjint.com</td>
    </tr>
    <tr nobr="true">        
        <td>  地址：{$customer["invoice_address"]}</td>
        <td>  地址：{$buyer["invoice_address"]}</td>
    </tr>   
    <tr nobr="true">
        <td>  电话：{$customer["invoice_phone"]}</td>
        <td>  电话：{$buyer["invoice_phone"]}</td>
    </tr>
    <tr nobr="true">
        <td>  传真：{$customer["contract_fax"]}</td>
        <td>  传真：{$buyer["contract_fax"]}</td>
    </tr>
    <tr nobr="true">
        <td>  邮编：{$customer["postcode"]}</td>
        <td>  邮编：{$buyer["postcode"]}</td>
    </tr>

</table>
EOD;



        $pdf->writeHTML($tbl, true, false, false, false, '');

        $pdf->Output($pdf_file, 'F');
        return array("msg"=>'200',"url"=>$pdf_file,);



    }



    private function manualAssign($data) {
        $id = I("request.id/d");
        if(empty($id)) {
            $this->ajaxError("交易单不存在");
        }
        $trade = M("trade")->where("id = ".$id." AND customer_id = ".$this->user["customer_id"]." AND org_id = ".$this->user["org_id"])->find();
        if(empty($trade)) {
            $this->ajaxError("交易单不存在");
        }
        if($trade["status"] > 3) {
            $this->ajaxError("交易单已生效,不能做配货");
        }

        if($_POST) {
            $goods_no = $trade["goods_no"];
            $goods = M("goods")->where("goods_no = '".$goods_no."' AND org_id =".$this->user["org_id"]." AND status = 1")->find();
            if(empty($goods)) {
                $this->ajaxError("商品[".$goods_no."]不存在");
            }
            $warehouse_code = $trade["warehouse_code"];

            $requestStorageCard = I("post.storageCard");
            $requestPackage = I("post.package");
            $requestButtress = I("post.buttress");
            $requestStorageCardWeight = I("post.storageCardWeight");
            $requestPackageWeight = I("post.packageWeight");
            $requestButtressWeight = I("post.buttressWeight");
            $storageCardType = I("post.storageCardType");

            $assignStorageCard = array();
            $assignPackage = array();
            $assignButtress = array();
            $assignData = getAssignData($id);
            if(!empty($requestButtress)) {
                foreach($requestButtress as $ck=>$c) {
                    foreach($c as $pk=>$p) {
                        foreach($p as $b) {
                            $storeCardButtress = M("storecard_buttress")->field("id, buttress_no, package_id, storecard_id, weight, lock_weight")->where("warehouse_code = '$warehouse_code' AND id = $b AND customer_id = ".$this->user["customer_id"])->find();
                            if(empty($storeCardButtress)) {
                                $this->ajaxError("库存不足");
                            }
                            if(isset($assignData["buttress"][$ck][$pk][$b])){
                                $storeCardButtress["lock_weight"] -= $assignData["buttress"][$ck][$pk][$b]["weight"];
                            }
                            if(floatval($storeCardButtress["weight"]) - $storeCardButtress["lock_weight"] < floatval($requestButtressWeight[$b])) {
                                $this->ajaxError("垛号[".$storeCardButtress["buttress_no"]  ."]库存不足");
                            }

                            $assignButtress[$ck][$pk][$b]["weight"] = $requestButtressWeight[$b];
                        }
                    }
                }
            }
            if(!empty($requestPackage)) {
                foreach($requestPackage as $ck=>$c) {
                    foreach($c as $p) {
                        $storeCardPackage = M("storecard_package")->field("id, package_no, storecard_id, weight, lock_weight, status")->where("warehouse_code = '$warehouse_code' AND id = '$p' AND customer_id = ".$this->user["customer_id"])->find();
                        if(empty($storeCardPackage)) {
                            $this->ajaxError("库存不足");
                        }
                        if($storeCardPackage["status"] != 1) {
                            $this->ajaxError("码单[".$storeCardPackage["package_no"]  ."]无效");
                        }
                        if(isset($assignData["package"][$ck][$p])){
                            $storeCardPackage["lock_weight"] -= $assignData["package"][$ck][$p]["weight"];
                        }
                        if(floatval($storeCardPackage["weight"]) - $storeCardPackage["lock_weight"] < floatval($requestPackageWeight[$p])) {
                            $this->ajaxError("码单[".$storeCardPackage["package_no"]  ."]库存不足");
                        }

                        $assignPackage[$ck][$p]["weight"] = $requestPackageWeight[$p];
                    }
                }
            }

            $checkGoods = "";
            if(!empty($requestStorageCard)) {
                foreach($requestStorageCard as $c) {
                    $cardTable = $storageCardType[$c] == 1 ? "storecard" : "storecard_virtual";
                    $storeCard = M($cardTable)->field("id, goods_id, goods_name, materials, storecard_no, weight, lock_weight, status")->where("warehouse_code = '$warehouse_code' AND id = '$c' AND customer_id = ".$this->user["customer_id"])->find();
                    if(empty($storeCard)) {
                        $this->ajaxError("库存不足");
                    }
                    if($storeCard["status"] != 1) {
                        $this->ajaxError("存储卡[".$storeCard["storecard_no"]  ."]无效");
                    }
                    if(isset($assignData["card"][$c])){
                        $storeCard["lock_weight"] -= $assignData["card"][$c]["weight"];
                    }
                    if(floatval($storeCard["weight"]) - $storeCard["lock_weight"] < floatval($requestStorageCardWeight[$c])) {
                        $this->ajaxError("存储卡[".$storeCard["storecard_no"]  ."]库存不足");
                    }

                    if($checkGoods == "") {
                        $checkGoods = $storeCard["goods_name"] . "#" . $storeCard["materials"];
                    }
                    if($checkGoods != $storeCard["goods_name"] . "#" . $storeCard["materials"]) {
                        $this->ajaxError("所选存储卡商品不一致");
                    }
                    $assignStorageCard[$c]["weight"] = $requestStorageCardWeight[$c];
                    $assignStorageCard[$c]["type"] = $storageCardType[$c];
                }
            }

            //判断存储卡码单垛号是否改变,如果改变 解锁原锁定, 重新锁定
            $assignWeight = 0;
            if(empty($assignStorageCard) && empty($assignPackage)) {
                $assignWeight = $trade["weight"];
            }
            $assign = checkAssignDiff($id, $assignStorageCard, $assignPackage, $assignButtress);
            if($assign !== false) {
                $assignStorageCard = $assign["card"];
                $assignPackage = $assign["package"];
                $assignButtress = $assign["buttress"];
            }

            M()->startTrans();
            $result = assign($id, $assignWeight, $assignStorageCard, $assignPackage, $assignButtress, false);
            if(!$result) {
                $save = array();
                $save["assign_user"] = $this->user["code"];
                M("trade")->where("id = ".$id." AND (assign_status = 0 OR assign_status = 1) AND status = 2")->save($save);

                M()->rollback();
                $this->ajaxError("配货处理失败");
            }
            M()->commit();
            //$this->ajax_openLink($data["pfuncid"]);
            $this->ajax_closePopup($data["funcid"]);
            $this->ajax_refresh($data["pfuncid"]);
            $this->ajaxResult("配货成功");
        } else {
            $data["id"] = $id;
            $storeCard = I("get.store_card");
            $storeCardType = I("get.storecard_type");
            if($storeCardType == "") $storeCardType = 1;
            $modelName = $storeCardType == 1 ? "storecard" : "storecard_virtual";
            $tradeAssign = M("trade_assign")->field("storecard_id, weight")->where("trade_id = ". $id)->select();
            $tradeAssignButtress = M("trade_assign_buttress")->field("storecard_id,package_id,buttress_id, weight")->where("trade_id = ". $id)->select();
            $pre = C("DB_PREFIX");
            if($storeCard && empty($tradeAssign)) {
                $data["storeCard"] = M($modelName)->where("storecard_no = '$storeCard'")->find();
            } else {
                $tmp1 = M("storecard")->field("*, 1 as storecard_type")->where(" id IN(SELECT storecard_id FROM ".$pre."trade_assign WHERE trade_id = ".$id." AND storecard_type = 1)")->select();
                $tmp2 = M("storecard_virtual")->field("*, 0 as storecard_type")->where(" id IN(SELECT storecard_id FROM ".$pre."trade_assign WHERE trade_id = ".$id." AND storecard_type = 0)")->select();
                $data["storeCard"] = array_merge($tmp1, $tmp2);
            }
            if($storeCardType == 1) {
                $storeCardPackage = M("storecard_package")->where(" storecard_id IN(SELECT storecard_id FROM ".$pre."trade_assign WHERE trade_id = ".$id.")")->select();
                $storeCardButtress = M("storecard_buttress")->where(" package_id IN(SELECT distinct package_id FROM ".$pre."trade_assign_buttress WHERE trade_id = ".$id.")")->select();
                foreach($tradeAssign as $item) {
                    $data["trade_assign"][$item["storecard_id"]] = $item;
                }
                foreach($tradeAssignButtress as $item) {
                    if(!isset($data["trade_assign_package"][$item["storecard_id"]][$item["package_id"]])) {
                        $data["trade_assign_package"][$item["storecard_id"]][$item["package_id"]] = 0;
                    }
                    $data["trade_assign_package"][$item["storecard_id"]][$item["package_id"]] += $item["weight"];
                    $data["trade_assign_buttress"][$item["storecard_id"]][$item["package_id"]][$item["buttress_id"]] = $item;
                }

                $scp = array();
                $scb = array();
                foreach($storeCardPackage as $item) {
                    $scp[$item["storecard_id"]][] = $item;
                }
                foreach($storeCardButtress as $item) {
                    $scb[$item["storecard_id"]][$item["package_id"]][] = $item;
                }
                $data["storeCardPackage"] = $scp;
                $data["storeCardButtress"] = $scb;
            }
            $data["storeCardType"] = $storeCardType;
            $data["goodsId"] = $trade["goods_id"];
            $data["goods"] = $goods = M("goods")->where("id=".$trade["goods_id"]." AND status = 1")->find();
            $data["trade"] = $trade;
            foreach($data as $key=>$val) {
                $this->assign($key, $val);
            }
            $html = $this->fetch("Trade:manual_assign");
            echo $html;
        }
    }

    private function selectStoreCard($data) {
        $cardNo = I("get.storecard_no");
        $goodsName = I("get.goods_name");
        $goodsNo = I("get.goods_no");
        $materials = I("get.materials");
        $brand = I("get.brand");
        $storeCardType = I("get.storecard_type");
        $data["p"] = I("get.p/d");

        if(empty($goodsNo)) {
            $this->ajax_closePopup($data["funcid"]);
            $this->ajaxError("商品不存在");
        }
        $goods = M("goods")->where("org_id = ".$this->user["org_id"]. " AND goods_no = '".$goodsNo. "'");
        if(empty($goods)) {
            $this->ajax_closePopup($data["funcid"]);
            $this->ajaxError("商品[".$goodsNo."]不存在");
        }

        $page_size = I("get.pagesize/d");
        $page_size = $page_size <= 0 ? session("Trade-SelectStoreCard-PageSize") : $page_size;
        if(!$page_size) {
          $page_size = 20;
        }
        session("Trade-SelectStoreCard-PageSize", $page_size);
        $where = " AND goods_no = '".$goodsNo. "'";
        if($cardNo) {
            $where .= " AND storecard_no like '%".$cardNo."%'";
        }
        if($goodsName) {
            $where .= " AND goods_name like '%".$goodsName."%'";
        }
        if($materials) {
            $where .= " AND materials like '%".$materials."%'";
        }
        if($brand) {
            $brandSearch = getGoodsAlias($this->user["org_id"], $goods["id"], $brand, 0);
            $where .= " AND brand IN (".$brandSearch.")";
        }

        $modelName = $storeCardType == 1 ? "storecard" : "storecard_virtual";
        $typeField = $storeCardType == 1 ? " 1 as storecard_type" : "0 as storecard_type";
        $count = M($modelName)->where("status = 1 ".$where." AND customer_id = ".$this->user["customer_id"])->count();
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

        $pageClass = new \Think\Page($count,$page_size);
        $pageClass->rollPage = 6;

        $data["page"] = $pageClass->show_drp_popup($data["funcid"], "");
        $data["page_size"] = $page_size;

        $data["storeCard"] = M($modelName)->field("id, storecard_no, goods_no, goods_name, materials, weight, lock_weight, uom_weight, ".$typeField)->where("status = 1 ".$where." AND customer_id = ".$this->user["customer_id"])->limit ( ($data ["p"] - 1) * $data ["page_size"], $data ["page_size"] )->select();
        $data["search"]["storecard_no"] = $cardNo;
        $data["search"]["goods_name"] = $goodsName;
        $data["search"]["materials"] = $materials;
        $data["search"]["storecard_type"] = $storeCardType;
        foreach($data as $key=>$val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("Trade:select_store_card");
        echo $html;
    }

    private function selectCustomer($data) {
        $data["p"] = I("get.p/d");
        $keyword = I("get.keyword");
        $search_all = I("get.search_all");

        $page_size = I("get.pagesize/d");
        $page_size = $page_size <= 0 ? session("Trade-SelectCustomer-PageSize") : $page_size;
        if(!$page_size) {
            $page_size = 20;
        }
        session("Trade-SelectCustomer-PageSize", $page_size);
        $where = "";
        if($search_all) {
            if($keyword) {
                $where .= " AND name = '".$keyword."'";
                $count = M("customer")->where("status = 1 ".$where)->count();
            } else {
                $count = 0;
            }
        } else {
            if($keyword) {
                $where .= " AND b.name LIKE '%".$keyword."%'";
            }
            $count = M("customer_rela")->alias("a")->join("__CUSTOMER__ as b ON a.rela_id = b.id","LEFT")->where("a.customer_id = ".$this->user["id"]. " AND b.id IS NOT NULL AND b.status = 1 AND a.status = 1 ".$where)->count();
        }

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

        $pageClass = new \Think\Page($count,$page_size);
        $pageClass->rollPage = 6;

        $data["page"] = $pageClass->show_drp_popup($data["funcid"], "");
        $data["page_size"] = $page_size;

        if($search_all) {
            $data["customer"] = M("customer")->field("id, name, linkman, mobile")->where("status = 1 ".$where)->limit ( ($data ["p"] - 1) * $data ["page_size"], $data ["page_size"] )->select();
        } else {
            $data["customer"] = M("customer_rela")->alias("a")->field("b.id, b.name, a.linkman, a.mobile")->join("__CUSTOMER__ as b ON a.rela_id = b.id","LEFT")->where("a.customer_id = ".$this->user["id"]. " AND b.id IS NOT NULL AND b.status = 1 AND a.status = 1 ".$where)->limit ( ($data ["p"] - 1) * $data ["page_size"], $data ["page_size"] )->select();
        }

        $data["search"]["keyword"] = $keyword;
        $data["search"]["search_all"] = $search_all;
        foreach($data as $key=>$val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("Trade:select_customer");
        echo $html;
    }

    private function exportTradeAssign($data) {
        $id = I("get.id/d");
        if(empty($id)) {
            $this->ajaxError("非法操作");
        }
        $trade = M("trade")->where("id = ".$id." AND customer_id = ".$this->user["customer_id"]." AND org_id = ".$this->user["org_id"]." AND status < 3")->find();
        if(empty($trade)) {
            $this->ajaxError("交易订单不存在");
        }

        $tradeAssignButtress = M("trade_assign_buttress")->field("storecard_no, package_no, buttress_no, weight, qty, bulkcargo")->where("trade_id = ".$trade["id"])->select();

        $assignData = getAssignData($trade["id"]);
        if($assignData == false) {
            $this->ajaxError("交易订单不存在");
        }
        try {
            vendor("PHPExcel181.PHPExcel");
            $phpExcel = new \PHPExcel();
            $phpExcel->setActiveSheetIndex(0);
            $phpSheet = $phpExcel->getActiveSheet();
            $phpSheet->setTitle($trade["trade_no"]);
            $phpSheet->setCellValue("A1", "交易单号");
            $phpSheet->setCellValue("B1", $trade["trade_no"]);
            $phpSheet->setCellValue("A2", "卡号");
            $phpSheet->setCellValue("B2", "码单");
            $phpSheet->setCellValue("C2", "垛号");
            $phpSheet->setCellValue("D2", "重量");
            $phpSheet->setCellValue("E2", "数量");
            $phpSheet->setCellValue("F2", "散件");
            $line = 3;
            foreach($tradeAssignButtress as $val) {
                $phpSheet->setCellValue("A".$line, $val["storecard_no"]);
                $phpSheet->setCellValue("B".$line, $val["package_no"]);
                $phpSheet->setCellValue("C".$line, $val["buttress_no"]);
                $phpSheet->setCellValue("D".$line, $val["weight"]);
                $phpSheet->setCellValue("E".$line, $val["qty"]);
                $phpSheet->setCellValue("F".$line, $val["bulkcargo"]);
                $line++;
            }
            $outputFileName = $trade["trade_no"].".xls";
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment; filename=\"$outputFileName\"");
            header('Cache-Control: max-age=0');

            try {
                $phpWrite = \PHPExcel_IOFactory::createWriter($phpExcel, "Excel2007");
                $phpWrite->save("php://output");
            } catch (\PHPExcel_Reader_Exception $er) {
                $this->ajaxError("生成Excel失败");
            } catch (\PHPExcel_Writer_Exception $ew) {
                $this->ajaxError("生成Excel失败");
            }
        } catch (\PHPExcel_Exception $e) {
            $this->ajaxError("生成Excel失败");
        }

        die();
    }
    private function manualDeliver($data) {
        $file = $this->uploadFile("upload_file", "/Uploads/Trade/Api/manual/".date("Y/m/d"));
        if($file == "") {
            $this->ajaxError("导入失败:上传xls文件失败");
        }
        if(!file_exists($file)) {
            $this->ajaxError("导入失败:上传xls文件失败");
        }
        try {
            vendor("PHPExcel181.PHPExcel");
            $phpExcel = \PHPExcel_IOFactory::load($file);
            $phpSheet = $phpExcel->getSheet(0);
            $rows = $phpSheet->getHighestRow();
            $tradeNo = trim($phpSheet->getCell("B1")->getValue());
            $trade = M("trade")->where("trade_no = '".$tradeNo. "' AND customer_id = ".$this->user["customer_id"]." AND org_id = ".$this->user["org_id"]." AND status = 5")->find();
            if(empty($trade)) {
                $this->ajaxError("交易订单[".$tradeNo."]不存在");
            }
            $now = getNow();
            $auth = M("customer")->where("id = ".$trade["customer_id"] ." AND expire_date >= '$now' AND status = 1")->find();
            if(empty($auth)) {
                $this->ajaxError("交易订单客户不存在或无效");
            }
            $goods = M("goods")->field("assign_threshold, assign_mode")->where("id = ".$trade["goods_id"])->find();
            if(empty($goods)) {
                $this->ajaxError("交易订单[".$tradeNo."]商品不存在");
            }
            $assignButtress = $goods["assign_mode"];

            $apiData = array();
            $apiData["trade"] = array();
            $apiTrade = array("trade_no" => $tradeNo, "weight"=>0, "qty"=>0, "bulkcargo"=>0);
            $apiTrade["package"] = array();

            $c = array();
            $p = array();
            $b = array();

            for($i = 3;$i <= $rows;$i++) {
                $ck = trim($phpSheet->getCell("A".$i)->getValue());
                $pk = trim($phpSheet->getCell("B".$i)->getValue());
                $bk = trim($phpSheet->getCell("C".$i)->getValue());
                $w = floatval(trim($phpSheet->getCell("D".$i)->getValue()));
                $q = floatval(trim($phpSheet->getCell("E".$i)->getValue()));
                $r = floatval(trim($phpSheet->getCell("F".$i)->getValue()));
                if(empty($ck)) {
                    $this->ajaxError("第".$i."行数据错误:请输入存储卡号");
                }
                if(empty($pk)) {
                    $this->ajaxError("第".$i."行数据错误:请输入码单号");
                }
                if($assignButtress) {
                    if(empty($bk)) {
                        $this->ajaxError("第".$i."行数据错误:请输入垛号");
                    }
                }

                if(!isset($c[$ck])) {
                    $c[$ck]["weight"] = 0;
                    $c[$ck]["qty"] = 0;
                    $c[$ck]["bulkcargo"] = 0;
                }
                $c[$ck]["weight"] += $w;
                $c[$ck]["qty"] += $q;
                $c[$ck]["bulkcargo"] += $r;
                if(!isset($p[$ck][$pk])) {
                    $p[$ck][$pk]["weight"] = 0;
                    $p[$ck][$pk]["qty"] = 0;
                    $p[$ck][$pk]["bulkcargo"] = 0;
                }
                $p[$ck][$pk]["weight"] += $w;
                $p[$ck][$pk]["qty"] += $q;
                $p[$ck][$pk]["bulkcargo"] += $r;
                if($assignButtress) {
                    if(!isset($b[$ck][$pk][$bk])) {
                        $b[$ck][$pk][$bk]["weight"] = 0;
                        $b[$ck][$pk][$bk]["qty"] = 0;
                        $b[$ck][$pk][$bk]["bulkcargo"] = 0;
                    }
                    $b[$ck][$pk][$bk]["weight"] += $w;
                    $b[$ck][$pk][$bk]["qty"] += $q;
                    $b[$ck][$pk][$bk]["bulkcargo"] += $r;
                }
                $apiTrade["weight"] += $w;
                $apiTrade["qty"] += $q;
                $apiTrade["bulkcargo"] += $r;
            }
            if(empty($c)) {
                $this->ajaxError("请输入交易存储卡数据");
            }
            if(empty($p)) {
                $this->ajaxError("请输入交易码单数据");
            }
            if($assignButtress) {
                if(empty($b)) {
                    $this->ajaxError("请输入交易垛号数据");
                }
            }

            foreach($c as $ck=>$cv) {
                foreach($p[$ck] as $pk=>$pv) {
                    $package = array(
                        "package_no"=>$pk,
                        "weight"=>$pv["weight"],
                        "qty"=>$pv["qty"],
                        "bulkcargo"=>$pv["bulkcargo"]
                    );
                    if($assignButtress) {
                        $package["buttress"] = array();
                        foreach($b[$ck][$pk] as $bk=>$bv) {
                            $buttress = array(
                                "buttress_no"=>$bk,
                                "weight"=>$bv["weight"],
                                "qty"=>$bv["qty"],
                                "bulkcargo"=>$bv["bulkcargo"]
                            );
                            $package["buttress"][] = $buttress;
                        }
                    }
                    $apiTrade["package"][] = $package;
                }
            }
            $apiData["trade"][] = $apiTrade;
            $apiData = json_encode(json_encode_pre($apiData));
            $timestamp = time();
            $sign = md5($apiData.$auth["secret"].$timestamp);
            $url = $_SERVER['SERVER_NAME'].':'.$_SERVER["SERVER_PORT"] . U("/Api/V1/index?method=trade&key=".$auth["appkey"]."&timestamp=".$timestamp."&sign=".$sign);
            $result = send($url, $apiData);
            if($result == "") {
                $this->ajaxError("请求失败");
            }
            try {
                $result = json_decode($result, true);
            } catch (\Exception $ex) {
                $this->ajaxError("请求失败:数据无法解析");
            }
            if($result["flag"] != "success") {
                if(empty($result)) {
                    $this->ajaxError("处理失败");
                } else {
                    $msg = $result["message"];
                    if(empty($msg)) {
                        foreach($result["data"] as $val) {
                            $msg .= $val["message"] . "\n";
                        }
                    }
                    $this->ajaxError($msg);
                }
            } else {
                $this->ajax_openLink($data["funcid"]);
                $this->ajaxResult("发货成功");
            }
        } catch (\PHPExcel_Exception $e) {
            $this->ajaxError("读取Excel失败");
        }
    }

//// source for add - begin ////
    private function add($data) {
        $id = I("request.id/d");
        $goodsStyle = "";

        if(!$id){
            $storeCardNo = I("request.store_card_no");
            //test
            //$storeCardNo = "0151000034";
            //test
            $goodsId = I("request.goods_id");
            $goods = array();
            if($storeCardNo) {
                $storeCard = M("storecard")->where("storecard_no = '".$storeCardNo."' AND status = 1 AND customer_id = ".$this->user["customer_id"])->find();
                if(empty($storeCard)) {
                    $this->ajax_closePopup($data["funcid"]);
                    $this->ajaxResult("存储卡[".$storeCardNo."]无效或不存在");
                }

                $data["storeCard"] = array($storeCard);
                $goods = M("goods")->where("id=".$storeCard["goods_id"]." AND status = 1 AND org_id = ".$this->user["org_id"])->find();
            } else if($goodsId) {
                $goodsStyle = "readonly='readonly'";
                $goods = M("goods")->where("id=".$goodsId." AND status = 1 AND org_id = ".$this->user["org_id"] )->find();
                if(empty($goods)) {
                    $this->ajax_closePopup($data["funcid"]);
                    $this->ajaxResult("商品无效或不存在");
                }
            }
            $data["storeCardNo"] = $storeCardNo;
            $data["goodsId"] = $goodsId;
            $data["goods"] = $goods;
            $data["search"] = array();
        } else {
            $search = M("trade")->where("org_id = ".$this->user["org_id"]." AND customer_id = ".$this->user["customer_id"]." AND id = ".$id)->find();
            if(!$search){
              $this->ajaxResult("交易开单数据不存在" );
            }
            $data["id"] = $search["id"];

            $data["goodsId"] = $search["goods_id"];
            $data["goods"] = $goods = M("goods")->where("id=".$search["goods_id"]." AND status = 1 AND org_id = ".$this->user["org_id"])->find();;
        }
        $data["payment_require"] = array(
            array("code"=>"30", "name"=>"发送后半小时内"),
            array("code"=>"60", "name"=>"发送后一小时内"),
            array("code"=>"120", "name"=>"发送后两小时内"),
            array("code"=>"180", "name"=>"发送后三小时内"),
            array("code"=>"360", "name"=>"发送后六小时内"),
            array("code"=>"1440", "name"=>"发送后一天内")
        );
        $data["confirm_status"] = array(
            array("code"=>"0" , "name"=>"不需要登记"),
            array("code"=>"1" , "name"=>"买方付款登记"),
            array("code"=>"2" , "name"=>"卖方收款登记"),
            array("code"=>"3" , "name"=>"双方登记")
        );
        $data["search"] = $search;
        $data["goodsStyle"] = $goodsStyle;
        foreach($data as $key=>$val) {
           $this->assign($key, $val);
        }
        $html = $this->fetch("Trade:add");
        echo $html;
    }
    private function save($data) {
        $id=I("request.id/d" );
        //读取页面输入数据

        $trade_no = I("request.trade_no");
        $tx_type = I("request.tx_type");
        $goods_no = I("request.goods_no");
        $buyer_id = I("request.buyer_id/d",0);
        $goods_name = I("request.goods_name");
        $brand = I("request.brand");
        $style_info = I("request.style_info");
        $producing_area = I("request.producing_area");
        $weight = I("request.weight/f",0);
        $price = I("request.price/f",0);
        $amount = I("request.amount/f",0);
        $warehouse_code = I("request.warehouse_code");
        $contract_no = I("request.contract_no");
        $contract_date = I("request.contract_date");
        $delivery_no = I("request.delivery_no");
        $delivery_company = I("request.delivery_company");
        $delivery_carno = I("request.delivery_carno");
        $delivery_contact = I("request.delivery_contact");
        $delivery_phone = I("request.delivery_phone");
        $delivery_idcard = I("request.delivery_idcard");
        $delivery_type = I("request.delivery_type");
        $delivery_info = I("request.delivery_info");
        $customer_msg = I("request.customer_msg");
        $buyer_msg = I("request.buyer_msg");
        $remarks = I("request.remarks");
        $buyer_name = I("request.buyer_name");
        $storeCardNo = I("request.storeCardNo");

        $delivery_expired = I("request.delivery_expired");
        $delivery_date = I("request.delivery_date");
        $confirm_status = I("request.confirm_status");
        $payment_require = I("request.payment_require");
        $delivery_require = I("request.delivery_require");
        $delivery_carinfo = I("request.delivery_carinfo");
        $storefee_start = I("request.storefee_start");

        //非页面输入字段
        $input = array();
        //数据有效性校验，非空/数值负数，范围/日期与今日比较
        //数据校验 - 必输项不能为空
        if(!verify_value($weight,"nagitive","","")) $this->ajaxError("重量 不能为负数");

        if(empty($delivery_no)) {
            $this->ajaxError("请输入提单号码");
        }
        if(empty($delivery_date)) {
            $this->ajaxError("请输入提单日期");
        }
        if(empty($contract_no)) {
            $this->ajaxError("请输入合同号码");
        }
//        if(empty($contract_date)) {
//            $this->ajaxError("请输入合同日期");
//        }
        if(empty($delivery_expired)) {
            $this->ajaxError("请输入提单截至日期");
        }
        if(empty($warehouse_code)) {
            $this->ajaxError("请选择仓库");
        }
        if(empty($goods_no)) {
            $this->ajaxError("请选择货品");
        }
        if($confirm_status) {
            if($price <= 0) {
                $this->ajaxError("请输入正确的交易价格");
            }
            if(empty($payment_require)) {
                $this->ajaxError("请选择付款截止时间");
            }
        }
        if(empty($storefee_start)) {
            $this->ajaxError("请选择仓储起算时间");
        }
        if($tx_type == 1) {
            if(empty($delivery_company)) {
                $this->ajaxError("请输入提货公司");
            }
            if(empty($delivery_carinfo)) {
                $this->ajaxError("请输入提货信息");
            }
        }

        if($warehouse_code){
            $ret = M("warehouse")
                  ->field("id,code,name,status")
                  ->where(" code='$warehouse_code' ")->find();
            if(!$ret)  $this->ajaxError("仓库编码不存在");
            if($ret['status']==0 || $ret['status']==8)   $this->ajaxError("仓库编码非有效状态");
        }

        $goods = M("goods")->where("goods_no = '".$goods_no."' AND org_id =".$this->user["org_id"]." AND status = 1")->find();
        if(empty($goods)) {
            $this->ajaxError("商品[".$goods_no."]不存在");
        }

        $model = M("trade");
        //判断 trade_no 是否重复建立
        $orig = $model->where("trade_no='$trade_no'".($id?" and id!=$id":""))->find();
        if ($orig) $this->ajaxError("交易单号 $trade_no 已存在");
        //页面输入字段
        $input["trade_no"] = $trade_no;
        $input["tx_date"] = date("Y-m-d H:i:s");
        $input["tx_type"] = $tx_type;
        $input["goods_id"] = $goods["id"];
        $input["goods_no"] = $goods_no;
        $input["buyer_id"] = $buyer_id;
        $input["goods_name"] = $goods_name;
        $input["brand"] = $brand;
        $input["style_info"] = $style_info;
        $input["producing_area"] = $producing_area;
        $input["weight"] = $weight;
        $input["price"] = $price;
        $input["amount"] = $weight * $price;//$amount;
        $input["warehouse_code"] = $warehouse_code;
        $input["contract_no"] = $contract_no;
        //$input["contract_date"] = $contract_date;
        $input["delivery_no"] = $delivery_no;
        $input["delivery_company"] = $delivery_company;
        $input["delivery_carno"] = $delivery_carno;
        $input["delivery_contact"] = $delivery_contact;
        $input["delivery_phone"] = $delivery_phone;
        $input["delivery_idcard"] = $delivery_idcard;
        $input["delivery_type"] = $delivery_type;
        $input["delivery_info"] = $delivery_info;
        $input["customer_msg"] = $customer_msg;
        $input["buyer_msg"] = $buyer_msg;
        $input["remarks"] = $remarks;
        $input["buyer_name"] = $buyer_name;
        $input["modify_user"] = session(C("USER_AUTH_KEY"));
        $input["modify_time"] =  date('Y-m-d H:i:s.n');
        $input["status"] = 0;

        $input["assign_user"] = array("exp", "''");// $this->user["code"];

        $input["org_id"] = $this->user["org_id"];
        $input["customer_id"] = $this->user["customer_id"];
        $input["customer_name"] = $this->user["customer_name"];

        $input["delivery_expired"] = $delivery_expired;
        $input["delivery_date"] = $delivery_date;
        $input["confirm_status"] = $confirm_status;
        $input["payment_require"] = $payment_require;
        $input["delivery_require"] = $delivery_require;
        $input["delivery_carinfo"] = $delivery_carinfo;
        $input["storefee_start"] = $storefee_start;

        $model->startTrans();
        $result=false;
        //需要存入日志的字段
        $needSave=array(
            'trade_no'=>'交易单号',
            'tx_date'=>'开单日期',
            'tx_type'=>'交易类型',
            'buyer_id'=>'买入客户',
            'goods_no'=>'货品编码',
            'goods_name'=>'货品名称',
            'brand'=>'注册商标',
            'style_info'=>'规格材质',
            'producing_area'=>'货品产地',
            'weight'=>'重量',
            'price'=>'含税价格',
            'amount'=>'交易金额',
            'warehouse_code'=>'仓库编码',
            'contract_no'=>'合同号码',
            'contract_date'=>'合同日期',
            'delivery_no'=>'提货单号',
            'delivery_company'=>'提货公司',
            'delivery_carno'=>'提货车号',
            'delivery_contact'=>'提货人员',
            'delivery_phone'=>'提货电话',
            'delivery_idcard'=>'提货身份证',
            'delivery_type'=>'发货方式',
            'buyer_name'=>'买入客户',
        );
        if(!$id) {
            //新增  建号操作
            $errorMsg = "";
            $keycode = GenOrderNo("trade", $this->user["org_id"], $errorMsg);
            if($keycode === false) {
                $model->rollback();
                $this->ajaxError($errorMsg);
            }
            $count = $model->where (array("trade_no" => $keycode))->count();
            if ($count > 0) {
                echo json_encode(array ("msg" => message ( "%1 %2 已存在", "交易开单", $keycode )) );
                die ();
            }
            $input["trade_no"] = $keycode;
            $input["create_user"] = session(C("USER_AUTH_KEY"));
            $input["create_time"] = date('Y-m-d H:i:s.n');
            //新增数据 保存数据库
            $result = $id = $model->add($input);
            //建立操作日志
            $result = $result && createLogTrade('trade',$id,'新增交易开单',array("order_no"=>$keycode),"*",'trade_no');
        } else {
            //id存在时判断数据库内数据是否存在
            $orig=$model->where("id='%d'",array($id))->find();
            if(empty($orig)) {
               $this->ajaxError("交易开单数据不存在");
            }
            if($orig["status"]!="0"){
                $this->ajaxError("交易开单非编辑状态");
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
                $result = $result && createLogTrade('trade',$id,'变更交易开单',$orig,'','','trade_no',$needSave);
            }
            $keycode = $orig["trade_no"];
        }

       if($result){
            $count = M("customer_rela")->where("customer_id=".$this->user["customer_id"]." AND rela_id = ".$buyer_id)->count();
            if($count == 0) {
                $buyer = M("customer")->where("id = ".$buyer_id)->find();
                if(!empty($buyer)) {
                    $save = array();
                    $save["customer_id"]=$this->user["customer_id"];
                    $save["rela_id"]=$buyer_id;
                    $save["type"]=0;
                    $save["inner_code"]=$buyer["code"];
                    $save["address"]=$buyer["address"];
                    $save["phone"]=$buyer["phone"];
                    $save["linkman"]=$buyer["linkman"];
                    $save["mobile"]=$buyer["mobile"];
                    $save["remarks"]=array("exp","''");
                    $save["status"]=1;
                    $save["create_time"]=date("Y-m-d H:i:s");
                    $save["create_user"]=$this->user["code"];
                    $save["modify_time"]=date("Y-m-d H:i:s");
                    $save["modify_user"]=$this->user["code"];
                    M("customer_rela")->add($save);
                }
            }
           $model->commit();
       }else{
           $model->rollback();
           echo json_encode(array("msg"=>message("交易开单保存发生错误")));
           die;
       }
       $this->ajax_closePopup($data["funcid"]);
        $this->ajax_openLink($data ['pfuncid']);
       if($storeCardNo) {
           $this->ajax_popupFun(U("Trade/index?func=manual_assign&store_card=".$storeCardNo));
       }
        $this->ajaxResult();
       //完成后跳转
//       $this->ajaxReturn($data ['pfuncid'],$data ['funcid'],"refresh", "","closepopup", 1 );
       //转到view页面
//       $this->ajaxReturn("","",U("Trade/index?func=view&id=$id&pfuncid=".$data ['pfuncid']), tabtitle('交易',$input["trade_no"] ,'RIGHT','8' ) );
//       die;
    }
//// source for add - end ////
//// source for cancel - begin ////
    private function cancel($data)
    {
        $id = I("request.id/d");
        if (!$id) {
            $this->ajaxResult("交易开单参数不存在");
        }
        $search = M('trade')->find($id);
        if (!$search)
            $this->ajaxResult("交易开单不存在");
        if ($search['status'] == '7') {
            $this->ajaxResult("交易开单已取消");
        }
        if (strstr(',1,2,3,4,5,6,8,', ',' . $search['status'] . ',') == false) {
            $this->ajaxResult("交易开单状态已变化，请重新处理");
        }
        $data["search"] = $search;
        $data["id"] = $data["search"]["id"];
        foreach ($data as $key => $val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("Trade:cancel");
        echo $html;
    }

    private function cancel_save($data)
    {
        $id = I("request.id/d");
        if (!$id) {
            $this->ajaxResult("交易开单参数不存在");
        }
        //id存在时判断数据库内数据是否存在
        $orig = M("trade")->where("id='%d'", array($id))->find();
        if (empty($orig)) {
            $this->ajaxError("交易开单数据不存在");
        }
        if ($orig['status'] == '7') {
            $this->ajaxResult("交易开单已取消");
        }
        if (strstr(',1,2,3,4,5,6,8,', ',' . $orig['status'] . ',') == false) {
            $this->ajaxResult("交易开单状态已变化，请重新处理");
        }
        $reason_tag = I("request.reason_tag");
        $reason = I("request.reason");
        if (!($reason_tag . $reason)) {
            $this->ajaxResult("交易开单状态回退，需注明原因");
        }
        $statusdesc = "退回状态[取消], ";
        $input["status"] = "7";  // "文本类型"
        $content = $statusdesc . "备注: ";
        if ($reason_tag) {
            $content .= $reason_tag;
            if ($reason) $content .= ", " . $reason;
        } else {
            $content .= $reason;
        }
        $input["modify_user"] = session(C("USER_AUTH_KEY"));
        $input["modify_time"] = date('Y-m-d H:i:s.n');
        $model = M("trade");
        $model->startTrans();
        //按主键更新数据
        $result = $model->where("id = $id")->save($input);
        //建立操作日志
        $result = $result && createLogTrade('trade', $id, '状态调整', $content);
        if ($result) {
            $model->commit();
        } else {
            $model->rollback();
            echo json_encode(array("msg" => message("交易开单保存发生错误")));
            die;
        }
        //完成后关闭并刷新父窗口
        $this->ajaxReturn($data ['pfuncid'], $data ['funcid'], "refresh", "", "closepopup");
        die;
    }
//// source for cancel - end ////
//// source for confirm - begin ////
    private function confirm($data)
    {
        $id = I("request.id/d");
        if (!$id) {
            $this->ajaxResult("交易开单参数不存在");
        }
        $search = M('trade')->find($id);
        if (!$search)
            $this->ajaxResult("交易开单不存在");
        if ($search['status'] == '7') {
            $this->ajaxResult("交易开单已取消");
        }

        if($search['status'] != '0' && $search['status'] != '1')
        {
            $this->ajaxResult("交易开单状态已变化，请重新处理");
        }

        if($search['status'] == '0')
        {
            if($search["customer_id"]!=$this->user["customer_id"])
            {
                $this->ajaxResult("没有提单确认的权限");
            }
        }
        if($search['status'] == '1')
        {
            if($search["buyer_id"]!=$this->user["customer_id"])
            {
                $this->ajaxResult("没有提单确认的权限");
            }
        }

        $data["search"] = $search;
        $data["id"] = $data["search"]["id"];
        foreach ($data as $key => $val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("Trade:confirm");
        echo $html;
    }

    private function confirm_save($data)
    {
        $id = I("request.id/d");
        if (!$id) {
            $this->ajaxResult("交易开单参数不存在");
        }
        //id存在时判断数据库内数据是否存在
        $orig = M("trade")->where("id='%d'", array($id))->find();
        if (empty($orig)) {
            $this->ajaxError("交易开单数据不存在");
        }
        if ($orig['status'] == '7') {
            $this->ajaxResult("交易开单已取消");
        }
        if($orig['status'] != '0' && $orig['status'] != '1')
        {
            $this->ajaxResult("交易开单状态已变化，请重新处理");
        }

        if($orig['status'] == '0')
        {
            if($orig["customer_id"]!=$this->user["customer_id"])
            {
                $this->ajaxResult("没有提单确认的权限");
            }
        }
        if($orig['status'] == '1')
        {
            if($orig["buyer_id"]!=$this->user["customer_id"])
            {
                $this->ajaxResult("没有提单确认的权限");
            }
        }

        $reason_tag = I("request.reason_tag");
        $reason = I("request.reason");
        //读取页面输入数据
        $confirm_status = I("request.confirm_status");
        $confirm_payment = I("request.confirm_payment/f", 0);
        $confirm_receive = I("request.confirm_receive/f", 0);
        //非页面输入字段
        $input = array();
        //数据有效性校验，非空/数值负数，范围/日期与今日比较
        //数据校验 - 必输项不能为空
        //if (!verify_value($confirm_payment, "nagitive", "", "")) $this->ajaxError("确认付款 不能为负数");
        //if ($confirm_payment < 100 || $confirm_payment > 105) $this->ajaxError("校验样例 确认付款值在100-105之间");
        //if (!verify_value($confirm_receive, "nagitive", "", "")) $this->ajaxError("确认收款 不能为负数");
        //if ($confirm_receive < 100 || $confirm_receive > 105) $this->ajaxError("校验样例 确认收款值在100-105之间");
        //页面输入字段
        $where=array("id"=>$id);
        if($orig["status"]==0)
        {
            $where["status"]=0;
            $where["customer_id"]=$this->login_user["customer_id"];
            if(empty($orig["buyer_id"]) || $orig["buyer_id"]==$orig["cusotmer_id"])
            {
                $input["status"]=3;
            }else
            {
                $input["status"]=1;
            }
            $input["cust_confirm_status"] = 1;
            $input["cust_confirm_time"] = date("Y-m-d H:i:s");
            $input["cust_confirm_user"] = $this->user["code"];
            $input["cust_send_type"] = 1;
            $input["cust_send_time"] = date("Y-m-d H:i:s");
            $input["cust_send_user"] = $this->user["code"];

        }elseif($orig["status"]==1)
        {
            $where["status"]=1;
            $input["status"]=2;
            $input["buyer_confirm_status"] = 1;
            $input["buyer_confirm_time"] = date("Y-m-d H:i:s");
            $input["buyer_confirm_user"] = $this->user["code"];
            $where["buyer_id"]=$this->login_user["customer_id"];
        }else
        {
            $this->ajaxResult("交易开单状态已变化，请重新处理");
        }

        $statusdesc = "状态[提单确认], ";
        $content = $statusdesc . "备注: ";
        if ($reason_tag) {
            $content .= $reason_tag;
            if ($reason) $content .= ", " . $reason;
        } else {
            $content .= $reason;
        }
        $input["modify_user"] = session(C("USER_AUTH_KEY"));
        $input["modify_time"] = date('Y-m-d H:i:s.n');
        $model = M("trade");
        $model->startTrans();
        //按主键更新数据
        $result = $model->where("id = $id")->save($input);
        //建立操作日志
        if (!$content) {
            //需要存入日志的字段
            $needSave = array(
                'status' => '状态',
            );
            //判断字段是否发生变更
            $isSaveLog = false;
            foreach ($needSave as $key => $v) {
                if ($orig[$key] != $input[$key]) {
                    $isSaveLog = true;
                    break;
                }
            }
            if ($isSaveLog)
                $result = $result && createLogTrade('trade', $id, '状态调整', $orig, '', '', 'trade_no', $needSave);
        } else {
            $result = $result && createLogTrade('trade', $id, '状态调整', $content);
        }
        if ($result) {
            $model->commit();
        } else {
            $model->rollback();
            echo json_encode(array("msg" => message("交易开单保存发生错误")));
            die;
        }
        //完成后关闭并刷新父窗口
        $this->ajaxReturn($data ['pfuncid'], $data ['funcid'], "refresh", "", "closepopup");
        die;
    }
//// source for confirm - end ////
//// source for confirm_rollback - begin ////
    private function confirm_rollback($data)
    {
        $id = I("request.id/d");
        if (!$id) {
            $this->ajaxResult("交易开单参数不存在");
        }
        $search = M('trade')->find($id);
        if (!$search)
            $this->ajaxResult("交易开单不存在");
        if ($search['status'] == '7') {
            $this->ajaxResult("交易开单已取消");
        }
        if ($search['status'] != '1') {
            $this->ajaxResult("交易开单状态已变化，请重新处理");
        }
        $data["search"] = $search;
        $data["id"] = $data["search"]["id"];
        foreach ($data as $key => $val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("Trade:confirm_rollback");
        echo $html;
    }

    private function confirm_rollback_save($data)
    {
        $id = I("request.id/d");
        if (!$id) {
            $this->ajaxResult("交易开单参数不存在");
        }
        //id存在时判断数据库内数据是否存在
        $orig = M("trade")->where("id='%d'", array($id))->find();
        if (empty($orig)) {
            $this->ajaxError("交易开单数据不存在");
        }
        if ($orig['status'] == '7') {
            $this->ajaxResult("交易开单已取消");
        }
        if ($orig['status'] != '1') {
            $this->ajaxResult("交易开单状态已变化，请重新处理");
        }
        $reason_tag = I("request.reason_tag");
        $reason = I("request.reason");
        if (!($reason_tag . $reason)) {
            $this->ajaxResult("交易开单状态回退，需注明原因");
        }
        $statusdesc = "退回状态[草稿], ";
        $input["status"] = "0";  // "文本类型"
        $content = $statusdesc . "备注: ";
        if ($reason_tag) {
            $content .= $reason_tag;
            if ($reason) $content .= ", " . $reason;
        } else {
            $content .= $reason;
        }
        $input["modify_user"] = session(C("USER_AUTH_KEY"));
        $input["modify_time"] = date('Y-m-d H:i:s.n');
        $model = M("trade");
        $model->startTrans();
        //按主键更新数据
        $result = $model->where("id = $id")->save($input);
        //建立操作日志
        $result = $result && createLogTrade('trade', $id, '状态调整', $content);
        if ($result) {
            $model->commit();
        } else {
            $model->rollback();
            echo json_encode(array("msg" => message("交易开单保存发生错误")));
            die;
        }
        //完成后关闭并刷新父窗口
        $this->ajaxReturn($data ['pfuncid'], $data ['funcid'], "refresh", "", "closepopup");
        die;
    }
//// source for confirm_rollback - end ////
//// source for toassign - begin ////
    private function toassign($data)
    {
        $id = I("request.id/d");
        if (!$id) {
            $this->ajaxResult("交易开单参数不存在");
        }
        $search = M('trade')->find($id);
        if (!$search)
            $this->ajaxResult("交易开单不存在");
        if ($search['status'] == '7') {
            $this->ajaxResult("交易开单已取消");
        }
        if ($search['status'] != '1') {
            $this->ajaxResult("交易开单状态已变化，请重新处理");
        }
        $data["search"] = $search;
        $data["id"] = $data["search"]["id"];
        foreach ($data as $key => $val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("Trade:toassign");
        echo $html;
    }

    private function toassign_save($data)
    {
        $id = I("request.id/d");
        if (!$id) {
            $this->ajaxResult("交易开单参数不存在");
        }
        //id存在时判断数据库内数据是否存在
        $orig = M("trade")->where("id='%d'", array($id))->find();
        if (empty($orig)) {
            $this->ajaxError("交易开单数据不存在");
        }
        if ($orig['status'] == '7') {
            $this->ajaxResult("交易开单已取消");
        }
        if ($orig['status'] != '1') {
            $this->ajaxResult("交易开单状态已变化，请重新处理");
        }
        $reason_tag = I("request.reason_tag");
        $reason = I("request.reason");
        $statusdesc = "状态[待配货], ";
        $input["status"] = "2";  // "文本类型"
        $content = $statusdesc . "备注: ";
        if ($reason_tag) {
            $content .= $reason_tag;
            if ($reason) $content .= ", " . $reason;
        } else {
            $content .= $reason;
        }
        $input["modify_user"] = session(C("USER_AUTH_KEY"));
        $input["modify_time"] = date('Y-m-d H:i:s.n');
        $model = M("trade");
        $model->startTrans();
        //按主键更新数据
        $result = $model->where("id = $id")->save($input);
        //建立操作日志
        $result = $result && createLogTrade('trade', $id, '状态调整', $content);
        if ($result) {
            $model->commit();
        } else {
            $model->rollback();
            echo json_encode(array("msg" => message("交易开单保存发生错误")));
            die;
        }
        //完成后关闭并刷新父窗口
        $this->ajaxReturn($data ['pfuncid'], $data ['funcid'], "refresh", "", "closepopup");
        die;
    }
//// source for toassign - end ////
//// source for assign_rollback - begin ////
    private function assign_rollback($data)
    {
        $id = I("request.id/d");
        if (!$id) {
            $this->ajaxResult("交易开单参数不存在");
        }
        $search = M('trade')->find($id);
        if (!$search)
            $this->ajaxResult("交易开单不存在");
        if ($search['status'] == '7') {
            $this->ajaxResult("交易开单已取消");
        }
        if ($search['status'] != '2') {
            $this->ajaxResult("交易开单状态已变化，请重新处理");
        }
        $data["search"] = $search;
        $data["id"] = $data["search"]["id"];
        foreach ($data as $key => $val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("Trade:assign_rollback");
        echo $html;
    }

    private function assign_rollback_save($data)
    {
        $id = I("request.id/d");
        if (!$id) {
            $this->ajaxResult("交易开单参数不存在");
        }
        //id存在时判断数据库内数据是否存在
        $orig = M("trade")->where("id='%d'", array($id))->find();
        if (empty($orig)) {
            $this->ajaxError("交易开单数据不存在");
        }
        if ($orig['status'] == '7') {
            $this->ajaxResult("交易开单已取消");
        }
        if ($orig['status'] != '2') {
            $this->ajaxResult("交易开单状态已变化，请重新处理");
        }
        $reason_tag = I("request.reason_tag");
        $reason = I("request.reason");
        if (!($reason_tag . $reason)) {
            $this->ajaxResult("交易开单状态回退，需注明原因");
        }
        $statusdesc = "退回状态[款项确认], ";
        $input["status"] = "1";  // "文本类型"
        $content = $statusdesc . "备注: ";
        if ($reason_tag) {
            $content .= $reason_tag;
            if ($reason) $content .= ", " . $reason;
        } else {
            $content .= $reason;
        }
        $input["modify_user"] = session(C("USER_AUTH_KEY"));
        $input["modify_time"] = date('Y-m-d H:i:s.n');
        $model = M("trade");
        $model->startTrans();
        //按主键更新数据
        $result = $model->where("id = $id")->save($input);
        //建立操作日志
        $result = $result && createLogTrade('trade', $id, '状态调整', $content);
        if ($result) {
            $model->commit();
        } else {
            $model->rollback();
            echo json_encode(array("msg" => message("交易开单保存发生错误")));
            die;
        }
        //完成后关闭并刷新父窗口
        $this->ajaxReturn($data ['pfuncid'], $data ['funcid'], "refresh", "", "closepopup");
        die;
    }
//// source for assign_rollback - end ////
//// source for wait_warhouse - begin ////
    private function wait_warhouse($data)
    {
        $id = I("request.id/d");
        if (!$id) {
            $this->ajaxResult("交易开单参数不存在");
        }
        $search = M('trade')->find($id);
        if (!$search)
            $this->ajaxResult("交易开单不存在");
        if ($search['status'] == '7') {
            $this->ajaxResult("交易开单已取消");
        }
        if ($search['status'] != '2') {
            $this->ajaxResult("交易开单状态已变化，请重新处理");
        }
        $data["search"] = $search;
        $data["id"] = $data["search"]["id"];
        foreach ($data as $key => $val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("Trade:wait_warhouse");
        echo $html;
    }

    private function wait_warhouse_save($data)
    {
        $id = I("request.id/d");
        if (!$id) {
            $this->ajaxResult("交易开单参数不存在");
        }
        //id存在时判断数据库内数据是否存在
        $orig = M("trade")->where("id='%d'", array($id))->find();
        if (empty($orig)) {
            $this->ajaxError("交易开单数据不存在");
        }
        if ($orig['status'] == '7') {
            $this->ajaxResult("交易开单已取消");
        }
        if ($orig['status'] != '2') {
            $this->ajaxResult("交易开单状态已变化，请重新处理");
        }
        $reason_tag = I("request.reason_tag");
        $reason = I("request.reason");
        $statusdesc = "状态[接口等待], ";
        $input["status"] = "3";  // "文本类型"
        $content = $statusdesc . "备注: ";
        if ($reason_tag) {
            $content .= $reason_tag;
            if ($reason) $content .= ", " . $reason;
        } else {
            $content .= $reason;
        }
        $input["modify_user"] = session(C("USER_AUTH_KEY"));
        $input["modify_time"] = date('Y-m-d H:i:s.n');
        $model = M("trade");
        $model->startTrans();
        //按主键更新数据
        $result = $model->where("id = $id")->save($input);
        //建立操作日志
        $result = $result && createLogTrade('trade', $id, '状态调整', $content);
        if ($result) {
            $model->commit();
        } else {
            $model->rollback();
            echo json_encode(array("msg" => message("交易开单保存发生错误")));
            die;
        }
        //完成后关闭并刷新父窗口
        $this->ajaxReturn($data ['pfuncid'], $data ['funcid'], "refresh", "", "closepopup");
        die;
    }
//// source for wait_warhouse - end ////
//// source for wait_rollback - begin ////
    private function wait_rollback($data)
    {
        $id = I("request.id/d");
        if (!$id) {
            $this->ajaxResult("交易开单参数不存在");
        }
        $search = M('trade')->find($id);
        if (!$search)
            $this->ajaxResult("交易开单不存在");
        if ($search['status'] == '7') {
            $this->ajaxResult("交易开单已取消");
        }
        if ($search['status'] != '3') {
            $this->ajaxResult("交易开单状态已变化，请重新处理");
        }
        $data["search"] = $search;
        $data["id"] = $data["search"]["id"];
        foreach ($data as $key => $val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("Trade:wait_rollback");
        echo $html;
    }

    private function wait_rollback_save($data)
    {
        $id = I("request.id/d");
        if (!$id) {
            $this->ajaxResult("交易开单参数不存在");
        }
        //id存在时判断数据库内数据是否存在
        $orig = M("trade")->where("id='%d'", array($id))->find();
        if (empty($orig)) {
            $this->ajaxError("交易开单数据不存在");
        }
        if ($orig['status'] == '7') {
            $this->ajaxResult("交易开单已取消");
        }
        if ($orig['status'] != '3') {
            $this->ajaxResult("交易开单状态已变化，请重新处理");
        }
        $reason_tag = I("request.reason_tag");
        $reason = I("request.reason");
        if (!($reason_tag . $reason)) {
            $this->ajaxResult("交易开单状态回退，需注明原因");
        }
        $statusdesc = "退回状态[待配货], ";
        $input["status"] = "2";  // "文本类型"
        $content = $statusdesc . "备注: ";
        if ($reason_tag) {
            $content .= $reason_tag;
            if ($reason) $content .= ", " . $reason;
        } else {
            $content .= $reason;
        }
        $input["modify_user"] = session(C("USER_AUTH_KEY"));
        $input["modify_time"] = date('Y-m-d H:i:s.n');
        $model = M("trade");
        $model->startTrans();
        //按主键更新数据
        $result = $model->where("id = $id")->save($input);
        //建立操作日志
        $result = $result && createLogTrade('trade', $id, '状态调整', $content);
        if ($result) {
            $model->commit();
        } else {
            $model->rollback();
            echo json_encode(array("msg" => message("交易开单保存发生错误")));
            die;
        }
        //完成后关闭并刷新父窗口
        $this->ajaxReturn($data ['pfuncid'], $data ['funcid'], "refresh", "", "closepopup");
        die;
    }
//// source for wait_rollback - end ////
//// source for warehouse_process - begin ////
    private function warehouse_process($data)
    {
        $id = I("request.id/d");
        if (!$id) {
            $this->ajaxResult("交易开单参数不存在");
        }
        $search = M('trade')->find($id);
        if (!$search)
            $this->ajaxResult("交易开单不存在");
        if ($search['status'] == '7') {
            $this->ajaxResult("交易开单已取消");
        }
        if ($search['status'] != '3') {
            $this->ajaxResult("交易开单状态已变化，请重新处理");
        }
        $data["search"] = $search;
        $data["id"] = $data["search"]["id"];
        foreach ($data as $key => $val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("Trade:warehouse_process");
        echo $html;
    }

    private function warehouse_process_save($data)
    {
        $id = I("request.id/d");
        if (!$id) {
            $this->ajaxResult("交易开单参数不存在");
        }
        //id存在时判断数据库内数据是否存在
        $orig = M("trade")->where("id='%d'", array($id))->find();
        if (empty($orig)) {
            $this->ajaxError("交易开单数据不存在");
        }
        if ($orig['status'] == '7') {
            $this->ajaxResult("交易开单已取消");
        }
        if ($orig['status'] != '3') {
            $this->ajaxResult("交易开单状态已变化，请重新处理");
        }
        $reason_tag = I("request.reason_tag");
        $reason = I("request.reason");
        $statusdesc = "状态[仓库处理], ";
        $input["status"] = "4";  // "文本类型"
        $content = $statusdesc . "备注: ";
        if ($reason_tag) {
            $content .= $reason_tag;
            if ($reason) $content .= ", " . $reason;
        } else {
            $content .= $reason;
        }
        $input["modify_user"] = session(C("USER_AUTH_KEY"));
        $input["modify_time"] = date('Y-m-d H:i:s.n');
        $model = M("trade");
        $model->startTrans();
        //按主键更新数据
        $result = $model->where("id = $id")->save($input);
        //建立操作日志
        $result = $result && createLogTrade('trade', $id, '状态调整', $content);
        if ($result) {
            $model->commit();
        } else {
            $model->rollback();
            echo json_encode(array("msg" => message("交易开单保存发生错误")));
            die;
        }
        //完成后关闭并刷新父窗口
        $this->ajaxReturn($data ['pfuncid'], $data ['funcid'], "refresh", "", "closepopup");
        die;
    }
//// source for warehouse_process - end ////
//// source for warehouse_rollback - begin ////
    private function warehouse_rollback($data)
    {
        $id = I("request.id/d");
        if (!$id) {
            $this->ajaxResult("交易开单参数不存在");
        }
        $search = M('trade')->find($id);
        if (!$search)
            $this->ajaxResult("交易开单不存在");
        if ($search['status'] == '7') {
            $this->ajaxResult("交易开单已取消");
        }
        if ($search['status'] != '4') {
            $this->ajaxResult("交易开单状态已变化，请重新处理");
        }
        $data["search"] = $search;
        $data["id"] = $data["search"]["id"];
        foreach ($data as $key => $val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("Trade:warehouse_rollback");
        echo $html;
    }

    private function warehouse_rollback_save($data)
    {
        $id = I("request.id/d");
        if (!$id) {
            $this->ajaxResult("交易开单参数不存在");
        }
        //id存在时判断数据库内数据是否存在
        $orig = M("trade")->where("id='%d'", array($id))->find();
        if (empty($orig)) {
            $this->ajaxError("交易开单数据不存在");
        }
        if ($orig['status'] == '7') {
            $this->ajaxResult("交易开单已取消");
        }
        if ($orig['status'] != '4') {
            $this->ajaxResult("交易开单状态已变化，请重新处理");
        }
        $reason_tag = I("request.reason_tag");
        $reason = I("request.reason");
        if (!($reason_tag . $reason)) {
            $this->ajaxResult("交易开单状态回退，需注明原因");
        }
        $statusdesc = "退回状态[接口等待], ";
        $input["status"] = "3";  // "文本类型"
        $content = $statusdesc . "备注: ";
        if ($reason_tag) {
            $content .= $reason_tag;
            if ($reason) $content .= ", " . $reason;
        } else {
            $content .= $reason;
        }
        $input["modify_user"] = session(C("USER_AUTH_KEY"));
        $input["modify_time"] = date('Y-m-d H:i:s.n');
        $model = M("trade");
        $model->startTrans();
        //按主键更新数据
        $result = $model->where("id = $id")->save($input);
        //建立操作日志
        $result = $result && createLogTrade('trade', $id, '状态调整', $content);
        if ($result) {
            $model->commit();
        } else {
            $model->rollback();
            echo json_encode(array("msg" => message("交易开单保存发生错误")));
            die;
        }
        //完成后关闭并刷新父窗口
        $this->ajaxReturn($data ['pfuncid'], $data ['funcid'], "refresh", "", "closepopup");
        die;
    }
//// source for warehouse_rollback - end ////
//// source for difference - begin ////
    private function difference($data)
    {
        $id = I("request.id/d");
        if (!$id) {
            $this->ajaxResult("交易开单参数不存在");
        }
        $search = M('trade')->find($id);
        if (!$search)
            $this->ajaxResult("交易开单不存在");
        if ($search['status'] == '7') {
            $this->ajaxResult("交易开单已取消");
        }
        if ($search['status'] != '4') {
            $this->ajaxResult("交易开单状态已变化，请重新处理");
        }
        $data["search"] = $search;
        $data["id"] = $data["search"]["id"];
        foreach ($data as $key => $val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("Trade:difference");
        echo $html;
    }

    private function difference_save($data)
    {
        $id = I("request.id/d");
        if (!$id) {
            $this->ajaxResult("交易开单参数不存在");
        }
        //id存在时判断数据库内数据是否存在
        $orig = M("trade")->where("id='%d'", array($id))->find();
        if (empty($orig)) {
            $this->ajaxError("交易开单数据不存在");
        }
        if ($orig['status'] == '7') {
            $this->ajaxResult("交易开单已取消");
        }
        if ($orig['status'] != '4') {
            $this->ajaxResult("交易开单状态已变化，请重新处理");
        }
        $reason_tag = I("request.reason_tag");
        $reason = I("request.reason");
        $statusdesc = "状态[款项补差], ";
        $input["status"] = "5";  // "文本类型"
        $content = $statusdesc . "备注: ";
        if ($reason_tag) {
            $content .= $reason_tag;
            if ($reason) $content .= ", " . $reason;
        } else {
            $content .= $reason;
        }
        $input["modify_user"] = session(C("USER_AUTH_KEY"));
        $input["modify_time"] = date('Y-m-d H:i:s.n');
        $model = M("trade");
        $model->startTrans();
        //按主键更新数据
        $result = $model->where("id = $id")->save($input);
        //建立操作日志
        $result = $result && createLogTrade('trade', $id, '状态调整', $content);
        if ($result) {
            $model->commit();
        } else {
            $model->rollback();
            echo json_encode(array("msg" => message("交易开单保存发生错误")));
            die;
        }
        //完成后关闭并刷新父窗口
        $this->ajaxReturn($data ['pfuncid'], $data ['funcid'], "refresh", "", "closepopup");
        die;
    }
//// source for difference - end ////
//// source for difference_rollback - begin ////
    private function difference_rollback($data)
    {
        $id = I("request.id/d");
        if (!$id) {
            $this->ajaxResult("交易开单参数不存在");
        }
        $search = M('trade')->find($id);
        if (!$search)
            $this->ajaxResult("交易开单不存在");
        if ($search['status'] == '7') {
            $this->ajaxResult("交易开单已取消");
        }
        if ($search['status'] != '5') {
            $this->ajaxResult("交易开单状态已变化，请重新处理");
        }
        $data["search"] = $search;
        $data["id"] = $data["search"]["id"];
        foreach ($data as $key => $val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("Trade:difference_rollback");
        echo $html;
    }

    private function difference_rollback_save($data)
    {
        $id = I("request.id/d");
        if (!$id) {
            $this->ajaxResult("交易开单参数不存在");
        }
        //id存在时判断数据库内数据是否存在
        $orig = M("trade")->where("id='%d'", array($id))->find();
        if (empty($orig)) {
            $this->ajaxError("交易开单数据不存在");
        }
        if ($orig['status'] == '7') {
            $this->ajaxResult("交易开单已取消");
        }
        if ($orig['status'] != '5') {
            $this->ajaxResult("交易开单状态已变化，请重新处理");
        }
        $reason_tag = I("request.reason_tag");
        $reason = I("request.reason");
        if (!($reason_tag . $reason)) {
            $this->ajaxResult("交易开单状态回退，需注明原因");
        }
        $statusdesc = "退回状态[仓库处理], ";
        $input["status"] = "4";  // "文本类型"
        $content = $statusdesc . "备注: ";
        if ($reason_tag) {
            $content .= $reason_tag;
            if ($reason) $content .= ", " . $reason;
        } else {
            $content .= $reason;
        }
        $input["modify_user"] = session(C("USER_AUTH_KEY"));
        $input["modify_time"] = date('Y-m-d H:i:s.n');
        $model = M("trade");
        $model->startTrans();
        //按主键更新数据
        $result = $model->where("id = $id")->save($input);
        //建立操作日志
        $result = $result && createLogTrade('trade', $id, '状态调整', $content);
        if ($result) {
            $model->commit();
        } else {
            $model->rollback();
            echo json_encode(array("msg" => message("交易开单保存发生错误")));
            die;
        }
        //完成后关闭并刷新父窗口
        $this->ajaxReturn($data ['pfuncid'], $data ['funcid'], "refresh", "", "closepopup");
        die;
    }
//// source for difference_rollback - end ////
//// source for close - begin ////
    private function close($data)
    {
        $id = I("request.id/d");
        if (!$id) {
            $this->ajaxResult("交易开单参数不存在");
        }
        $search = M('trade')->find($id);
        if (!$search)
            $this->ajaxResult("交易开单不存在");
        if ($search['status'] == '7') {
            $this->ajaxResult("交易开单已取消");
        }
        if ($search['status'] != '5') {
            $this->ajaxResult("交易开单状态已变化，请重新处理");
        }
        $data["search"] = $search;
        $data["id"] = $data["search"]["id"];
        foreach ($data as $key => $val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("Trade:close");
        echo $html;
    }

    private function close_save($data)
    {
        $id = I("request.id/d");
        if (!$id) {
            $this->ajaxResult("交易开单参数不存在");
        }
        //id存在时判断数据库内数据是否存在
        $orig = M("trade")->where("id='%d'", array($id))->find();
        if (empty($orig)) {
            $this->ajaxError("交易开单数据不存在");
        }
        if ($orig['status'] == '7') {
            $this->ajaxResult("交易开单已取消");
        }
        if ($orig['status'] != '5') {
            $this->ajaxResult("交易开单状态已变化，请重新处理");
        }
        $reason_tag = I("request.reason_tag");
        $reason = I("request.reason");
        $statusdesc = "状态[交易完成], ";
        $input["status"] = "6";  // "文本类型"
        $content = $statusdesc . "备注: ";
        if ($reason_tag) {
            $content .= $reason_tag;
            if ($reason) $content .= ", " . $reason;
        } else {
            $content .= $reason;
        }
        $input["modify_user"] = session(C("USER_AUTH_KEY"));
        $input["modify_time"] = date('Y-m-d H:i:s.n');
        $model = M("trade");
        $model->startTrans();
        //按主键更新数据
        $result = $model->where("id = $id")->save($input);
        //建立操作日志
        $result = $result && createLogTrade('trade', $id, '状态调整', $content);
        if ($result) {
            $model->commit();
        } else {
            $model->rollback();
            echo json_encode(array("msg" => message("交易开单保存发生错误")));
            die;
        }
        //完成后关闭并刷新父窗口
        $this->ajaxReturn($data ['pfuncid'], $data ['funcid'], "refresh", "", "closepopup");
        die;
    }
//// source for close - end ////
//// source for close_rollback - begin ////
    private function close_rollback($data)
    {
        $id = I("request.id/d");
        if (!$id) {
            $this->ajaxResult("交易开单参数不存在");
        }
        $search = M('trade')->find($id);
        if (!$search)
            $this->ajaxResult("交易开单不存在");
        if ($search['status'] == '7') {
            $this->ajaxResult("交易开单已取消");
        }
        if ($search['status'] != '6') {
            $this->ajaxResult("交易开单状态已变化，请重新处理");
        }
        $data["search"] = $search;
        $data["id"] = $data["search"]["id"];
        foreach ($data as $key => $val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("Trade:close_rollback");
        echo $html;
    }

    private function close_rollback_save($data)
    {
        $id = I("request.id/d");
        if (!$id) {
            $this->ajaxResult("交易开单参数不存在");
        }
        //id存在时判断数据库内数据是否存在
        $orig = M("trade")->where("id='%d'", array($id))->find();
        if (empty($orig)) {
            $this->ajaxError("交易开单数据不存在");
        }
        if ($orig['status'] == '7') {
            $this->ajaxResult("交易开单已取消");
        }
        if ($orig['status'] != '6') {
            $this->ajaxResult("交易开单状态已变化，请重新处理");
        }
        $reason_tag = I("request.reason_tag");
        $reason = I("request.reason");
        if (!($reason_tag . $reason)) {
            $this->ajaxResult("交易开单状态回退，需注明原因");
        }
        $statusdesc = "退回状态[款项补差], ";
        $input["status"] = "5";  // "文本类型"
        $content = $statusdesc . "备注: ";
        if ($reason_tag) {
            $content .= $reason_tag;
            if ($reason) $content .= ", " . $reason;
        } else {
            $content .= $reason;
        }
        $input["modify_user"] = session(C("USER_AUTH_KEY"));
        $input["modify_time"] = date('Y-m-d H:i:s.n');
        $model = M("trade");
        $model->startTrans();
        //按主键更新数据
        $result = $model->where("id = $id")->save($input);
        //建立操作日志
        $result = $result && createLogTrade('trade', $id, '状态调整', $content);
        if ($result) {
            $model->commit();
        } else {
            $model->rollback();
            echo json_encode(array("msg" => message("交易开单保存发生错误")));
            die;
        }
        //完成后关闭并刷新父窗口
        $this->ajaxReturn($data ['pfuncid'], $data ['funcid'], "refresh", "", "closepopup");
        die;
    }
//// source for close_rollback - end ////
//// source for import - begin ////
    private function import($data)
    {
        $data['orderid'] = I("get.id");
        foreach ($data as $key => $val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("Trade:import");
        echo $html;
    }

    private function cattext($string, $txt)
    {
        if ($string) $string .= ",";
        return $string . $txt;
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
            "trade_no" => "交易单号",
            "tx_date" => "开单日期",
            "tx_type" => "交易类型",
            "goods_no" => "货品编码",
            "buyer_id" => "买入客户",
            "goods_name" => "货品名称",
            "brand" => "注册商标",
            "style_info" => "规格材质",
            "producing_area" => "货品产地",
            "weight" => "重量",
            "price" => "含税价格",
            "amount" => "交易金额",
            "warehouse_code" => "仓库编码",
            "contract_no" => "合同号码",
            "contract_date" => "合同日期",
            "delivery_no" => "提货单号",
            "delivery_company" => "提货公司",
            "delivery_carno" => "提货车号",
            "delivery_contact" => "提货人员",
            "delivery_phone" => "提货电话",
            "delivery_idcard" => "提货身份证",
            "delivery_type" => "发货方式",
            "delivery_info" => "发货说明",
            "customer_msg" => "卖家消息",
            "buyer_msg" => "买家消息",
            "remarks" => "备注",
            "buyer_name" => "买入客户",
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
                if (!verify_value($row["trade_no"], "empty", "", "")) $err_empty = $this->cattext($err_empty, $header["trade_no"]);
                if (strlen($row["tx_type"]) > 0) {
                    //数值类型校验
                    if (!verify_value($row["tx_type"], "num"))
                        $err_type = $this->cattext($err_type, $header["tx_type"]);
                    else
                        if ($row["tx_type"] < 0) $err_exist = $this->cattext($err_exist, $header["tx_type"] . "是负数");
                }
                if (strlen($row["buyer_id"]) > 0) {
                    //数值类型校验
                    if (!verify_value($row["buyer_id"], "num"))
                        $err_type = $this->cattext($err_type, $header["buyer_id"]);
                    else
                        if ($row["buyer_id"] < 0) $err_exist = $this->cattext($err_exist, $header["buyer_id"] . "是负数");
                }
                if (strlen($row["weight"]) > 0) {
                    //数值类型校验
                    if (!verify_value($row["weight"], "num"))
                        $err_type = $this->cattext($err_type, $header["weight"]);
                    else
                        if ($row["weight"] < 0) $err_exist = $this->cattext($err_exist, $header["weight"] . "是负数");
                }
                if (strlen($row["price"]) > 0) {
                    //数值类型校验
                    if (!verify_value($row["price"], "num"))
                        $err_type = $this->cattext($err_type, $header["price"]);
                    else
                        if ($row["price"] < 0) $err_exist = $this->cattext($err_exist, $header["price"] . "是负数");
                }
                if (strlen($row["amount"]) > 0) {
                    //数值类型校验
                    if (!verify_value($row["amount"], "num"))
                        $err_type = $this->cattext($err_type, $header["amount"]);
                    else
                        if ($row["amount"] < 0) $err_exist = $this->cattext($err_exist, $header["amount"] . "是负数");
                }
                if (strlen($row["delivery_type"]) > 0) {
                    //数值类型校验
                    if (!verify_value($row["delivery_type"], "num"))
                        $err_type = $this->cattext($err_type, $header["delivery_type"]);
                    else
                        if ($row["delivery_type"] < 0) $err_exist = $this->cattext($err_exist, $header["delivery_type"] . "是负数");
                }
                if (strlen($row["warehouse_code"]) > 0) {
                    $ret = M("warehouse")
                        ->field("id,code,name,status")
                        ->where(" code='" . $row["warehouse_code"] . "' ")->find();
                    if (!$ret) $err_exist = $this->cattext($err_exist, $header["warehouse_code"] . "不存在");
                    if ($ret['status'] == 0 || $ret['status'] >= 7) $this->cattext($err_exist, $header["warehouse_code"] . "非有效状态");
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
        //判断 trade_no 是否重复建立
        $i = 0;
        foreach ($importdatas as $k => $row) {
            if ($k >= $row_data) {
                $j = 0;
                foreach ($importdatas as $k1 => $row1) {
                    if ($k1 >= $row_data and $k1 > $k) {
                        if ($row["trade_no"] == $row1["trade_no"]) {
                            $err .= "第 " . ($i + $row_data) . " 与 " . ($j + $row_data) . " 行 " . $header["trade_no"] . "\n";
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
        $model = M("trade");
        //关键字重复导入覆盖方式
        $overwrite = true;
        if (!$overwrite) { //非覆盖方式检查是否重复
            //判断 trade_no 是否重复建立
            $i = 0;
            foreach ($importdatas as $k => $row) {
                if ($k >= $row_data) {
                    $m = $model->where("trade_no='" . $row["trade_no"] . "'")->find();
                    if ($m) $err .= "第 " . ($i + $row_data) . " 行 " . $header["trade_no"] . "\n";
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
        $total = 0;
        $new = 0;
        $edit = 0;
        foreach ($importdatas as $row) {
            $input = array();
            $id = 0;
            $m = array();
            //非导入字段-赋初值
            //导入字段
            $input["trade_no"] = $row["trade_no"];
            $input["tx_date"] = $row["tx_date"];
            $input["tx_type"] = $row["tx_type"];
            $input["goods_no"] = $row["goods_no"];
            $input["buyer_id"] = $row["buyer_id"];
            $input["goods_name"] = $row["goods_name"];
            $input["brand"] = $row["brand"];
            $input["style_info"] = $row["style_info"];
            $input["producing_area"] = $row["producing_area"];
            $input["weight"] = $row["weight"];
            $input["price"] = $row["price"];
            $input["amount"] = $row["amount"];
            $input["warehouse_code"] = $row["warehouse_code"];
            $input["contract_no"] = $row["contract_no"];
            $input["contract_date"] = $row["contract_date"];
            $input["delivery_no"] = $row["delivery_no"];
            $input["delivery_company"] = $row["delivery_company"];
            $input["delivery_carno"] = $row["delivery_carno"];
            $input["delivery_contact"] = $row["delivery_contact"];
            $input["delivery_phone"] = $row["delivery_phone"];
            $input["delivery_idcard"] = $row["delivery_idcard"];
            $input["delivery_type"] = $row["delivery_type"];
            $input["delivery_info"] = $row["delivery_info"];
            $input["customer_msg"] = $row["customer_msg"];
            $input["buyer_msg"] = $row["buyer_msg"];
            $input["remarks"] = $row["remarks"];
            $input["buyer_name"] = $row["buyer_name"];
            //modify_user/time字段
            $input["modify_user"] = session(C("USER_AUTH_KEY"));
            $input["modify_time"] = date('Y-m-d H:i:s.n');
            //检查是否存在
            //样例 $m = $model->where("code='".$row["code"]."'")->find();
            $orig = $model->where("trade_no='" . $row["trade_no"] . "'")->find();
            if (!$orig) {
                //新增
                $input["create_user"] = session(C("USER_AUTH_KEY"));
                $input["create_time"] = date('Y-m-d H:i:s.n');
                $result = $id = $model->add($input);
                $new++;
                //建立操作日志
                $result = $result && createLogTrade('trade', $id, '数据导入(新增)', $orig, '', '', 'trade_no', $header);
            } else {
                //覆盖
                $id = $orig['id'];
                $result = $model->where("id=$id")->save($input);
                $edit++;
                //建立操作日志
                $result = $result && createLogTrade('trade', $id, '数据导入(覆盖)', $orig, '', '', 'trade_no', $header);
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
//##combine_for_add_source##

//// source for status confirm ////

//// source for status view ////
    private function view($data)
    {
        $data["p"] = I("request.p/d");
        $data["pagesize"] = I("request.pagesize/d");

        $data["id"] = I("request.id/d");
        $data["no"] = I("request.no");
        if (!$data["id"] && !$data["no"]) {
            $this->ajaxError("交易开单信息查询参数非法");
        }

        //condition
        $condition = "";
        $joinsql = "";
        //select search fields
        $selectmasterfields = "@trade.*";


        $sql = table("select #selectfields# from @trade  #join# Where #viewkey# #condition# #orderby#");
        if ($data["id"])
            $viewkey = table("@trade.id=$data[id]");
        else
            $viewkey = table("@trade.trade_no='$data[no]'");
        $sql = str_replace("#selectfields#", table($selectmasterfields), $sql);
        $sql = str_replace("#join#", $joinsql, $sql);
        $sql = str_replace("#viewkey#", $viewkey, $sql);
        $sql = str_replace("#condition#", $condition, $sql);
        $sql = str_replace("#orderby#", "", $sql);
        $search = M()->query($sql);
        if (!$search) {
            $this->ajaxError("交易开单信息信息不存在");
        }
        $data["search"] = current($search);
        $data["search"]["customer_buyid"] = $this->user['customer_id'];

        //step 步骤样例 - 开始
        $step = array();
        $step1 = array();
        step_add($step, '创建时间', $data["search"]['create_time'], true);
        step_add($step, '卖家确认', $data["search"]['cust_confirm_time'], $data["search"]['status'] == 1 && $data["search"]['cust_confirm_status'] == 1);
        if(!empty($data["search"]["buyer_id"]) && $data["search"]["buyer_id"]!=$data["search"]["customer_id"])
        {
            step_add($step, '买家确认', $data["search"]['buyer_confirm_time'], $data["search"]['status'] == 2 && $data["search"]['buyer_confirm_status'] == 1);
        }
        step_add($step, '已配货', $data["search"]['assign_time'], $data["search"]['status'] ==2  && $data["search"]['assign_status'] == 2);
        step_add($step, '已通知', $data["search"]['interface_send_time'], $data["search"]['status'] == 3);
        //if($data["search"]['status']>=1 && $data["search"]['stock_status']==1){
        step_add($step, '处理中', $data["search"]['stock_time'], $data["search"]['status'] == 4);
        //}
        step_add($step, '已完成', $data["search"]['complete_time'], $data["search"]['status'] ==6 );
        // 取消/挂起步骤
        step_add($step1, '取消时间', $data["search"]['cancel_time'], $data["search"]['status'] == 7);
        //step_add($step1, '挂起时间', $data["search"]['hangup_time'], $data["search"]['hangup_status'] == 8);
        $step = getOrderStep($step, $step1);
        $data["step"] = $step;
        //step 步骤样例 - 结束

        //按tabsheet - 开始
        $data["id"] = $data["search"]["id"];
        $data["search"]["_tab"] = $this->tabsheet_check(I("request._tab"));
        $page_size = $data["pagesize"];//session("Trade-".$data["search"]["_tab"]."-PageSize");

        $data=$this->trade_assign_list($page_size,$data);

        $data["search"]["_tab_" . $data["search"]["_tab"] . "_p"] = $data["p"];
        $data["search"]["_tab_" . $data["search"]["_tab"] . "_psize"] = $data["page_size"];
        //session("Trade-".$data["search"]["_tab"]."-PageSize", $data["page_size"]);
        //按tabsheet - 结束

        $model=M("Payment");
        $date["customer_payment_info"]=$model->where(Array(
            "order_id"=>$data["id"],
            "customer_id"=>$data["search"]["customer_id"]
        ))->field("confirm_time,confirm_user")->order("confirm_time desc")->find();

        $date["buyer_payment_info"]=$model->where(Array(
            "order_id"=>$data["id"],
            "customer_id"=>$data["search"]["buyer_id"]
        ))->field("confirm_time,confirm_user")->order("confirm_time desc")->find();


        foreach ($data as $key => $val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("Trade:view");
        echo $html;
    }

    //按tabsheet子程序 - 开始

    private function tab_jiaoyipeihuo_trade_assign($tab_pagesize, $data)
    {
        $orderby = "";
        $joinsql = "";


        $condition = "";


        //select detail fields
        $selectfields = "@trade_assign.status ";
        $selectfields .= ",@trade_assign.id ";
        $selectfields .= ",@trade_assign.org_id ";
        $selectfields .= ",@trade_assign.customer_name ";
        $selectfields .= ",@trade_assign.trade_id ";
        $selectfields .= ",@trade_assign.warehouse_code ";
        $selectfields .= ",@trade_assign.storecard_id ";
        $selectfields .= ",@trade_assign.storecard_no ";
        $selectfields .= ",@trade_assign.weight ";
        $selectfields .= ",@trade_assign.qty ";
        $selectfields .= ",@trade_assign.bulkcargo ";
        $selectfields .= ",@trade_assign.lock_time ";
        $selectfields .= ",@trade_assign.release_time ";
        $selectfields .= ",@trade_assign.act_weight ";
        $selectfields .= ",@trade_assign.act_qty ";
        $selectfields .= ",@trade_assign.act_bulkcargo ";
        $selectfields .= ",@trade_assign.act_time ";
        $selectfields .= ",@trade_assign.buyer_storecard_id ";
        $selectfields .= ",@trade_assign.remarks ";
        $selectfields .= ",@trade_assign.create_time ";

        $viewkey = "@trade_assign.trade_id='" . $data["search"]["id"] . "'";
        if (!$viewkey)
            $this->ajaxError("查询参数非法");
        //      die;

        $page_size = $tab_pagesize;
        if (!$page_size) {
            $page_size = 10;
        }

        $count_sql = table("select count(*) as cnt from @trade_assign  #join# where #viewkey# #condition#");
        $search_sql = table("select #selectfields# from @trade_assign  #join# Where #viewkey# #condition# #orderby#");

        $viewkey = table($viewkey);
        $condition = table($condition);
        $orderby = table($orderby);
        $selectfields = table($selectfields);

        $count_sql = str_replace("#condition#", $condition, $count_sql);
        $count_sql = str_replace("#viewkey#", $viewkey, $count_sql);
        $count_sql = str_replace("#join#", $joinsql, $count_sql);

        $count = M()->query($count_sql);
        $count = $count[0]["cnt"];

        if ($count < $page_size)
            $tmp = 1;
        else {
            $tmp = intval($count / $page_size);
            if ($count % $page_size != 0) {
                $tmp++;
            }
        }
        if (!$data["p"]) {
            $data["p"] = 1;
        }
        if ($data["p"] > $tmp) {
            $data["p"] = $tmp;
        }

        $sql = str_replace("#selectfields#", $selectfields, $search_sql);
        $sql = str_replace("#join#", $joinsql, $sql);
        $sql = str_replace("#viewkey#", $viewkey, $sql);
        $sql = str_replace("#condition#", $condition, $sql);
        $sql = str_replace("#orderby#", $orderby, $sql);
        $sql .= " LIMIT " . (($data["p"] - 1) * $page_size) . ", $page_size";
        $data["list"] = M()->query($sql);
        $pageClass = new \Think\Page($count, $page_size);
        $pageClass->rollPage = 8;
        $data["page"] = $pageClass->show_drp($data["funcid"], "");
        $data["page_size"] = $page_size;

        return $data;
    }

    private function tab_jiaoyipeihuoduohao_trade_assign_buttress($tab_pagesize, $data)
    {
        $orderby = "";
        $joinsql = "";


        $condition = "";


        //select detail fields
        $selectfields = "@trade_assign_buttress.status ";
        $selectfields .= ",@trade_assign_buttress.id ";
        $selectfields .= ",@trade_assign_buttress.org_id ";
        $selectfields .= ",@trade_assign_buttress.customer_id ";
        $selectfields .= ",@trade_assign_buttress.trade_id ";
        $selectfields .= ",@trade_assign_buttress.warehouse_code ";
        $selectfields .= ",@trade_assign_buttress.storecard_id ";
        $selectfields .= ",@trade_assign_buttress.storecard_no ";
        $selectfields .= ",@trade_assign_buttress.package_id ";
        $selectfields .= ",@trade_assign_buttress.buttress_id ";
        $selectfields .= ",@trade_assign_buttress.package_no ";
        $selectfields .= ",@trade_assign_buttress.buttress_no ";
        $selectfields .= ",@trade_assign_buttress.batchno ";
        $selectfields .= ",@trade_assign_buttress.location_code ";
        $selectfields .= ",@trade_assign_buttress.weight ";
        $selectfields .= ",@trade_assign_buttress.qty ";
        $selectfields .= ",@trade_assign_buttress.bulkcargo ";
        $selectfields .= ",@trade_assign_buttress.release_time ";
        $selectfields .= ",@trade_assign_buttress.act_weight ";
        $selectfields .= ",@trade_assign_buttress.act_qty ";
        $selectfields .= ",@trade_assign_buttress.act_bulkcargo ";
        $selectfields .= ",@trade_assign_buttress.act_time ";
        $selectfields .= ",@trade_assign_buttress.create_time ";

        $viewkey = "@trade_assign_buttress.trade_id='" . $data["search"]["id"] . "'";
        if (!$viewkey)
            $this->ajaxError("查询参数非法");
        //      die;

        $page_size = $tab_pagesize;
        if (!$page_size) {
            $page_size = 10;
        }

        $count_sql = table("select count(*) as cnt from @trade_assign_buttress  #join# where #viewkey# #condition#");
        $search_sql = table("select #selectfields# from @trade_assign_buttress  #join# Where #viewkey# #condition# #orderby#");

        $viewkey = table($viewkey);
        $condition = table($condition);
        $orderby = table($orderby);
        $selectfields = table($selectfields);

        $count_sql = str_replace("#condition#", $condition, $count_sql);
        $count_sql = str_replace("#viewkey#", $viewkey, $count_sql);
        $count_sql = str_replace("#join#", $joinsql, $count_sql);

        $count = M()->query($count_sql);
        $count = $count[0]["cnt"];

        if ($count < $page_size)
            $tmp = 1;
        else {
            $tmp = intval($count / $page_size);
            if ($count % $page_size != 0) {
                $tmp++;
            }
        }
        if (!$data["p"]) {
            $data["p"] = 1;
        }
        if ($data["p"] > $tmp) {
            $data["p"] = $tmp;
        }

        $sql = str_replace("#selectfields#", $selectfields, $search_sql);
        $sql = str_replace("#join#", $joinsql, $sql);
        $sql = str_replace("#viewkey#", $viewkey, $sql);
        $sql = str_replace("#condition#", $condition, $sql);
        $sql = str_replace("#orderby#", $orderby, $sql);
        $sql .= " LIMIT " . (($data["p"] - 1) * $page_size) . ", $page_size";
        $data["list"] = M()->query($sql);
        $pageClass = new \Think\Page($count, $page_size);
        $pageClass->rollPage = 8;
        $data["page"] = $pageClass->show_drp($data["funcid"], "");
        $data["page_size"] = $page_size;

        return $data;
    }

    private function tab_mingxi_chain_detail($tab_pagesize, $data)
    {
        $orderby = "";
        $joinsql = "";


        $condition = "";


        //select detail fields
        $selectfields = "@chain_detail.id ";
        $selectfields .= ",@chain_detail.org_id ";
        $selectfields .= ",@chain_detail.trade_id ";
        $selectfields .= ",@chain_detail.interface_process ";
        $selectfields .= ",@chain_detail.interface_time ";
        $selectfields .= ",@chain_detail.interface_result ";

        $viewkey = "@chain_detail.trade_id='" . $data["search"]["id"] . "'";
        if (!$viewkey)
            $this->ajaxError("查询参数非法");
        //      die;

        $page_size = $tab_pagesize;
        if (!$page_size) {
            $page_size = 10;
        }

        $count_sql = table("select count(*) as cnt from @chain_detail  #join# where #viewkey# #condition#");
        $search_sql = table("select #selectfields# from @chain_detail  #join# Where #viewkey# #condition# #orderby#");

        $viewkey = table($viewkey);
        $condition = table($condition);
        $orderby = table($orderby);
        $selectfields = table($selectfields);

        $count_sql = str_replace("#condition#", $condition, $count_sql);
        $count_sql = str_replace("#viewkey#", $viewkey, $count_sql);
        $count_sql = str_replace("#join#", $joinsql, $count_sql);

        $count = M()->query($count_sql);
        $count = $count[0]["cnt"];

        if ($count < $page_size)
            $tmp = 1;
        else {
            $tmp = intval($count / $page_size);
            if ($count % $page_size != 0) {
                $tmp++;
            }
        }
        if (!$data["p"]) {
            $data["p"] = 1;
        }
        if ($data["p"] > $tmp) {
            $data["p"] = $tmp;
        }

        $sql = str_replace("#selectfields#", $selectfields, $search_sql);
        $sql = str_replace("#join#", $joinsql, $sql);
        $sql = str_replace("#viewkey#", $viewkey, $sql);
        $sql = str_replace("#condition#", $condition, $sql);
        $sql = str_replace("#orderby#", $orderby, $sql);
        $sql .= " LIMIT " . (($data["p"] - 1) * $page_size) . ", $page_size";
        $data["list"] = M()->query($sql);
        $pageClass = new \Think\Page($count, $page_size);
        $pageClass->rollPage = 8;
        $data["page"] = $pageClass->show_drp($data["funcid"], "");
        $data["page_size"] = $page_size;

        return $data;
    }

    private function tab_jiaoyirizhi_log_trade($tab_pagesize, $data)
    {
        $orderby = "";
        $joinsql = "";

        $condition = "";

        //select detail fields
        $selectfields = "@log_trade.status ";
        $selectfields .= ",@log_trade.id ";
        $selectfields .= ",@log_trade.create_time ";
        $selectfields .= ",@log_trade.trade_id ";
        $selectfields .= ",@log_trade.subject ";
        $selectfields .= ",@log_trade.weight ";
        $selectfields .= ",@log_trade.qty ";
        $selectfields .= ",@log_trade.amount ";
        $selectfields .= ",@log_trade.content ";

        $viewkey = "@log_trade.trade_id='" . $data["search"]["id"] . "'";
        if (!$viewkey)
            $this->ajaxError("查询参数非法");
        //      die;

        $page_size = $tab_pagesize;
        if (!$page_size) {
            $page_size = 10;
        }

        $count_sql = table("select count(*) as cnt from @log_trade  #join# where #viewkey# #condition#");
        $search_sql = table("select #selectfields# from @log_trade  #join# Where #viewkey# #condition# #orderby#");
        $orderby = "order by @log_trade.id desc";

        $viewkey = table($viewkey);
        $condition = table($condition);
        $orderby = table($orderby);
        $selectfields = table($selectfields);

        $count_sql = str_replace("#condition#", $condition, $count_sql);
        $count_sql = str_replace("#viewkey#", $viewkey, $count_sql);
        $count_sql = str_replace("#join#", $joinsql, $count_sql);

        $count = M()->query($count_sql);
        $count = $count[0]["cnt"];

        if ($count < $page_size)
            $tmp = 1;
        else {
            $tmp = intval($count / $page_size);
            if ($count % $page_size != 0) {
                $tmp++;
            }
        }
        if (!$data["p"]) {
            $data["p"] = 1;
        }
        if ($data["p"] > $tmp) {
            $data["p"] = $tmp;
        }

        $sql = str_replace("#selectfields#", $selectfields, $search_sql);
        $sql = str_replace("#join#", $joinsql, $sql);
        $sql = str_replace("#viewkey#", $viewkey, $sql);
        $sql = str_replace("#condition#", $condition, $sql);
        $sql = str_replace("#orderby#", $orderby, $sql);
        $sql .= " LIMIT " . (($data["p"] - 1) * $page_size) . ", $page_size";
        $data["list"] = M()->query($sql);
        $pageClass = new \Think\Page($count, $page_size);
        $pageClass->rollPage = 8;
        $data["page"] = $pageClass->show_drp($data["funcid"], "");
        $data["page_size"] = $page_size;

        return $data;
    }


    private function tabsheet_check($itab)
    {
        $idefault = "jiaoyipeihuo";
        switch ($itab) {

            case "jiaoyipeihuo":
            case "jiaoyipeihuoduohao":
            case "mingxi":
            case "jiaoyirizhi":

                break;
            default:
                $itab = $idefault;
                break;
        }
        return $itab;
    }

    //按tabsheet子程序 - 结束

    private function deleteProcess($id)
    {
        $type = 1;
        $smo = M('trade')->where("id='%d'", array($id))->find();
        if (empty($smo)) {
            $this->ajaxResult("交易开单信息数据不存在");
        }
        if ($smo['status'] != 0) {
            $this->ajaxResult("交易开单信息状态不能删除");
        }

        $result = true;
        $result = $result && createLogTrade('trade', $id, ($smo['status'] ? '取消信息' : '删除记录'), '');
        if ($smo['status'] != 0) {
            $result = $result && M('trade')->where("id='%d'", array($id))->save(array('status' => 8, 'cancel_time' => date('Y-m-d H:i:s'), 'cancel_status' => 1));
        } else {
            $result = $result && M('trade')->where("id='%d'", array($id))->delete();
        }
        return $result;
    }

    private function order_delete($data)
    {
        $id = I("request.id/d");
        $type = I("request.type/d");
        if (!$id) {
            $this->ajaxResult("交易开单信息参数不存在");
        }

        $m = M();
        $m->startTrans();
        $r = $this->deleteProcess($id);
        if ($r) {
            $m->commit();
        } else {
            $m->rollback();
        }

        $this->ajax_hideConfirm();
        if (!$type) {
            $this->ajax_closeTab($data ['funcid']);
        }
        $this->ajax_refresh($data ['pfuncid']);
        $this->ajaxResult();
        die;
    }

    private function make_delivery($data)
    {
        $id = I("request.id/d");
        if (!$id) {
            $this->ajaxResult("提货参数不存在");
        }
        if($this->user['side'] != 3){
            $this->ajaxResult("提单信息只能由客户登记");
        }
        $search = M('trade')
            ->field('id,status,delivery_date,delivery_expired,delivery_company,delivery_carinfo,delivery_type,delivery_require')
            ->find($id);

        if (!$search)
            $this->ajaxResult("交易订单提货信息不存在");
        if ($search['status'] >= '6') {
            $this->ajaxResult("交易单已完成或已取消");
        }
        if($search['status'] < '2') {
            $this->ajaxResult("请等待交易双方确认");
        }
        $data["search"] = $search;
        $data["id"] = $data["search"]["id"];
        foreach ($data as $key => $val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("Trade:delivery");
        echo $html;

    }

    /*
     * 提单登记
     */
    private function deli_save($data)
    {
        //根据交易单ID查询客户ID
        $id = I("request.id/d");
        if(!$id) {
            $this->ajaxResult("交易信息参数不存在");
        }
        if($this->user['side'] != 3){
            $this->ajaxResult("提单信息只能由客户登记");
        }
        $cid = M('trade')->where("id='%d'", array($id))->find();
        if(!$cid) {
            $this->ajaxResult("交易信息不存在");
        }
        //根据客户ID查询客户姓名信息
        $kid = M('customer')->field('code')->where("id='%d'", array($cid['buyer_id']))->find();
        if($kid){
            $buyer_code = $kid['code'];
        }else{
            $this->ajaxResult('客户信息出现错误');
        }

        //读取页面输入数据

        $delivery_company = I("request.delivery_company");
        $delivery_carinfo = I("request.delivery_carinfo");
        $delivery_require = I("request.delivery_require");
        $delivery_type = I("request.delivery_type");
        $delivery_date = I("request.delivery_date");
        $delivery_expired = I("request.delivery_expired");
        //非页面输入字段
        $input = array();
        $dely = array();

        $model = M('delivery');
        //提单单号
        $errorMsg = "";
        $delivery_no = GenOrderNo("delivery", '', $errorMsg);

        if($delivery_no === false) {
            $model->rollback();
            $this->ajaxError($errorMsg);
        }
        //判断 delivery_no 是否重复建立
        $orig = M('delivery')->where("delivery_no='$delivery_no'")->find();
        if ($orig) $this->ajaxError("提货单号 $delivery_no 已存在");
        $model->startTrans();

        //页面输入字段
        $input["delivery_no"] = $delivery_no;
        $input["delivery_company"] = $delivery_company;
        $input["delivery_carinfo"] = $delivery_carinfo;
        $input["delivery_require"] = $delivery_require;
        $input["delivery_type"] = $delivery_type;
        $input["delivery_date"] = $delivery_date;
        $input["delivery_expired"] = $delivery_expired;
        //根据页面输入字段 更新trade表信息
        $list = M('trade')->where("id='%d'", $id)->save($input);
        if(!$list){
            $model->rollback();
            $this->ajaxResult('数据更新失败');
        }
        $result = false;
        //需要存入日志的字段
        $needSave = array(
            'org_id' => '库链id',
            'customer_id' => '客户id',
            'customer_name' => '客户名称',
            'tx_date' => '开单日期',
            'warehouse_code' => '仓库编码',
            'goods_id' =>'货品ID',
            'goods_no' =>'货品编码',
            'goods_name' =>'货品名称',
            'style_info' =>'规格',
            'materials' =>'材质',
            'brand' =>'商标',
            'producing_area' =>'产地',
            'style_code' =>'货品基础码',
            'weight' =>'重量',
            'uom_qty' =>'数量单位',
            'uom_weight' =>'重量单位',
            'buyer_id' =>'买家id',
            'buyer_name' =>'买家名称',
            'status' => 0,
        );

        //新增数据
        $dely['org_id'] = $cid['org_id'];
        $dely['customer_id'] = $cid['customer_id'];
        $dely['customer_name'] = $cid['customer_name'];
        $dely['tx_date'] = $cid['tx_date'];
        $dely['warehouse_code'] = $cid['warehouse_code'];
        $dely['goods_id'] = $cid['goods_id'];
        $dely['goods_no'] = $cid['goods_no'];
        $dely['goods_name'] = $cid['goods_name'];
        $dely['style_info'] = $cid['style_info'];
        $dely['materials'] = $cid['materials'];
        $dely['brand'] = $cid['brand'];
        $dely['producing_area'] = $cid['producing_area'];
        $dely['style_code'] = $cid['style_code'];
        $dely['weight'] = $cid['weight'];
        $dely['uom_qty'] = $cid['uom_qty'];
        $dely['uom_weight'] = $cid['uom_weight'];
        $dely['buyer_id'] = $cid['buyer_id'];
        $dely['buyer_code'] = $buyer_code;
        $dely['buyer_name'] = $cid['buyer_name'];
        $dely["delivery_no"] = $delivery_no;
        $dely["delivery_carno"] = $delivery_carinfo;
        $dely["expired_time"] = $delivery_require;
        $dely["delivery_date"] = $delivery_date;
        $dely['status'] = 0;
        //新增数据 保存数据库
        $result = $id = $model->add($dely);
        //建立操作日志
        $result = $result && createLogCommon('delivery', $id, '新增提单', '', "*");

        if ($result) {
            $model->commit();
        } else {
            $model->rollback();
            echo json_encode(array("msg" => message("新增提单发生错误")));
            die;
        }
        //完成后跳转
        $this->ajaxReturn($data ['pfuncid'], $data ['funcid'], "refresh", "", "closepopup", 1);
        //转到view页面
        $this->ajaxReturn("", "", U("Delivery/index?func=view&id=$id&pfuncid=" . $data ['pfuncid']), tabtitle('提单', $dely["delivery_no"], 'RIGHT', '8'));
        die;

    }

    private function pay_register($data)
    {
        //点击按钮时身份判断
        $user_id = session('USER_ID');
        $model_user = M("user");
        $user_content = $model_user->field('customer_id,mobilephone,status,lastchanged')->find($user_id);

        if(empty($user_content)){
            $this->ajaxResult("用户信息不存在");
        }

        if($user_content['status'] == 0){
            $this->ajaxResult("用户信息无效");
        }

        //客户表查询
        $model_customer = M("customer");
        $customer_id=$user_content['customer_id'];
        $customer_name = $model_customer->field('name')->find($customer_id);
        if(empty($customer_name)){
            $this->ajaxResult("客户信息不存在");
        }

        //查单子
        $id = I("request.id/d");
        if (!$id) {
            $this->ajaxResult("交易单参数不存在");
        }
        $search = M('trade')->find($id);
        if (!$search)
            $this->ajaxResult("交易单信息不存在");
        if ($search['status'] == '7') {
            $this->ajaxResult("交易单已取消");
        }
        if ($search['status'] == '6') {
            $this->ajaxResult("交易单已完成");
        }

        //判断登入者在交易中的身份
        if($user_content['customer_id'] == $search['customer_id']){
            $search['dignity'] = 1;//卖出者
        }elseif ($user_content['customer_id'] == $search['buyer_id']){
            $search['dignity'] = 0;//买入者
        }else{
            $this->ajaxResult("身份信息有误");
        }

        $data["search"] = $search;

        $data["id"] = $data["search"]["id"];
        foreach ($data as $key => $val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("Trade:pay_register");
        echo $html;
    }

    //获取验证码
    public function check_verify()
    {
        $receive['id'] = session('USER_ID');
        $identity = I('request.trade_id');
        $pay_ment = I('post.pay_ment');
        $money = trim(I('post.money/f'));
        $remarks = trim(I('post.remarks/s'));

        if($money == '' || $money == 0 || $money < 0){
            $this->ajaxResult("300");
        }

        if($remarks == ''){
            $this->ajaxResult("301");
        }

        $model = M("system_verify");
        $model->startTrans();

        //根据登入者ID查询登记手机号码
        $list = $model->table('erp_user')->field('mobilephone')->where($receive)->find();


        $result = false;

        if($pay_ment == 1){
            $sys['action'] = 'trade_receive';
            $code = 'SMS_TRADE_RECEIVE';
        }elseif ($pay_ment == 0){
            $sys['action'] = 'trade_payment';
            $code = 'SMS_TRADE_PAYMENT';
        }

        $sys['user_id'] = session('USER_ID');
        $sys['data_id'] = $identity;
        if($list)
        {
            $time = $model->field('id,verify,expire_time,status')->where($sys)->find();
            $sys['verify'] = rand(111111,999999);
            $sys['status'] = 1;
            $sys['send_phone'] = $list['mobilephone'];
            $sys['create_time'] = date('Y-m-d H:i:s');
            $sys['expire_time'] = date('Y-m-d H:i:s',strtotime("+60 seconds"));
            $sys['failed_count'] = 0;

            $sys['verifystring'] = $money .'-'. $pay_ment;


            //如果当前时间小于失效时间并且状态为发送
            if(date('Y-m-d H:i:s')<$time['expire_time'] && $time['status'] == 1)
            {
                $this->ajaxResult("204");
            }elseif ($time['verify']){//验证码存在说明是重发
                $result = $model->where("id='%d'", $time['id'])->save($sys);
                $result = $result && createLogVerify('system_verify',$time['id'],'');
                $this->send_message($code,$sys);
            }else{//验证码不存在则是新增
                $sys['send_time'] = date('Y-m-d H:i:s');
                $result = $model->add($sys);
                $result = $result && createLogVerify('system_verify',$result,'');
                $this->send_message($code,$sys);
            }
            if($result){
                $model->commit();
                $this->ajaxResult("200");
            }else{
                $model->rollback();
            }
        }else{
            $this->ajaxResult("202");
        }
    }

    private function send_message($code = '',$input=array())
    {
        $message_content = exist_table_MessageTemplet($code);
        $trade_id = $input['data_id'];
        $trade_content = M('trade')->field('id,org_id,trade_no')->find($trade_id);
        $trade_left = substr($trade_content['trade_no'],'0','4');
        $trade_right = substr($trade_content['trade_no'],-4);
        $message_content['content'] = str_replace('%1',$input['create_time'],$message_content['content']);
        $message_content['content'] = str_replace('%2',$input['verify'],$message_content['content']);
        $message_content['content'] = str_replace('%3',$trade_left,$message_content['content']);
        $message_content['content'] = str_replace('%4',$trade_right,$message_content['content']);
        $msg_send['org_id'] = $trade_content['org_id'];
        $msg_send['user_id'] = $input['user_id'];
        if($code == 'SMS_TRADE_RECEIVE'){
            $msg_send['type'] = 4;
        }elseif($code == 'SMS_TRADE_PAYMENT'){
            $msg_send['type'] = 3;
        }
        $msg_send['send'] = 0;
        $msg_send['message_templet_code'] = $code;
        $msg_send['mobile'] = $input['send_phone'];
        $msg_send['content'] = $message_content['content'];
        $msg_send['status'] = 0;
        $msg_send['create_time'] = date('Y-m-d H:i:s');
        $msg_send['create_user'] = session(C("USER_AUTH_KEY"));
        $msg_send['modify_time'] = date('Y-m-d H:i:s');
        $msg_send['modify_user'] = session(C("USER_AUTH_KEY"));
        $list = M('message_send')->add($msg_send);
        $subject = '变更库链/客户对应信息';
        if($list){
            //建立操作日志
            createLogCommon('message_send',$list,$subject,'',"*");
        }
    }


    private function check_receive($data)
    {
        $money = trim(I('request.money/f'));
        $verify = trim(I('request.verify/d'));
        $remarks = trim(I('request.remarks/s'));
        $pay_type = I('request.pay_ment');
        $id = I("request.id/d");

        $model = M("trade");
        $model->startTrans();

        if (!($this->do_check_receive($model,$id,$money,$verify,$remarks,$pay_type,$error,$success))) {
            $model->rollback();
            $this->ajaxResult($error);
        }else{
            $model->commit();
            if($success){
                $this->ajaxResult($success);
            }else{
                $this->ajaxReturn($data ['pfuncid'], $data ['funcid'], "refresh", "", "closepopup");
            }
        }
    }

    //货款登记
    public function do_check_receive($model,$id=0,$money=0,$verify='',$remarks='',$pay_type=0,&$error,&$success)
    {
        $error= "";
        $success="";
        $verifystring = $money.'-'.$pay_type;


        if($pay_type == ''){
            $error = "请选择款项类型";
            return false;
        }

        if(empty($money) || $money < 0){
            $error = "金额不能为空或负数";
            return false;
        }

        if(empty($verify)){
            $error = "验证码不能为空";
            return false;
        }

        if(empty($remarks)){
            $error = "备注信息不能为空";
            return false;
        }

        $user_id = session('USER_ID');
        $model_user = M("user");
        $user_content = $model_user->field('customer_id,mobilephone,status,lastchanged')->find($user_id);

        if(empty($user_content)){
            $error = "用户信息不存在";
            return false;
        }

        if($user_content['status'] == 0){
            $error = "用户信息无效";
            return false;
        }


        $model_customer = M("customer");
        $customer_id=$user_content['customer_id'];
        $customer_name = $model_customer->field('name')->find($customer_id);
        if(empty($customer_name)){
            $error = "客户信息不存在";
            return false;
        }


        //根据ID查询交易单信息s
        $trade_content = $model->where("id='%d'", $id)->find();
        if(empty($trade_content)){
            $error = "交易单信息不存在";
            return false;
        }

        //判断登入者在交易中的身份
        if($user_content['customer_id'] == $trade_content['customer_id']){
            $dignity = true;//卖出者
        }elseif ($user_content['customer_id'] == $trade_content['buyer_id']){
            $dignity = false;//买入者
        }else{
            $error = "用户信息有误";
            return false;
        }

        if($trade_content['status'] ==6){
            $error = "交易状态已完成";
            return false;
        }

        if($trade_content['status'] ==7){
            $error = "交易状态已取消";
            return false;
        }


        //验证码是否正确
        if($pay_type==1){
            $where['action'] = 'trade_receive';
        }elseif($pay_type==0){
            $where['action'] = 'trade_payment';
        }
        $where['user_id'] = session('USER_ID');
        $where['data_id'] = $id;
        $where['send_phone'] = $user_content['mobilephone'];
        $model_system_verify = M("system_verify");
        $verify_content = $model_system_verify->where($where)->find();
        if(empty($verify_content)){
            $error = "验证信息不存在";
            return false;
        }
        if($verifystring !== $verify_content['verifystring']){
            $error = "验证信息有误";
            return false;
        }
        //验证码正确并且错误次数少于10次并且失效时间未过
        if($verify === $verify_content['verify'] && $verify_content['failed_count'] < 10 && $verify_content['expire_time'] > date('Y-m-d H:i:s'))
        {
            //当前验证码信息为发送状态
            if($verify_content['status'] == 1){
                //如果当前操作为付款
                if($pay_type == 0){
                    //如果当前登入者ID等于卖出者ID
                    if($dignity){
                        $money_change = $model->table('erp_trade')->where("id='%d'", $id)->where("status > 0")->setDec('confirm_receive',$money);//收款方登记金额累减
                    }else{
                        //如果当前登入者ID等于买入者ID
                        $money_change = $model->table('erp_trade')->where("id='%d'", $id)->where("status > 1")->setInc('confirm_payment',$money);//付款方登记金额累计
                    }
                //如果当前操作为收款
                }elseif ($pay_type == 1){
                    //如果当前登入者ID等于卖出者ID
                    if($dignity){
                        $money_change = $model->table('erp_trade')->where("id='%d'", $id)->where("status > 0")->setInc('confirm_receive',$money);//收款方登记金额累计
                    }else{
                        $money_change = $model->table('erp_trade')->where("id='%d'", $id)->where("status > 1")->setDec('confirm_payment',$money);//付款方登记金额累减
                    }
                }

                if(empty($money_change)){
                    $error = "款项登记发生错误";
                    return false;
                }

                //更改验证码状态为使用
                $status['status'] = 3;
                $test['id'] = $verify_content['id'];
                $test['status'] = 1;
                $save_status = $model_system_verify->where($test)->save($status);
                //建立验证码日志
                if(!$save_status){
                    $error = "验证码发生错误";
                    return false;
                }

                if(!(createLogVerify('system_verify',$verify_content['id'],''))){
                    $error = "验证码日志发生错误";
                    return false;
                }

                //收款项数据写入payment表
                $list['customer_id'] = $this->user['customer_id'];
                $list['customer_name'] = $customer_name['name'];
                $list['type'] = $pay_type;
                $list['warehouse_code'] = $trade_content['warehouse_code'];
                $list['org_id'] = $trade_content['org_id'];
                $list['order_id'] = $trade_content['id'];
                $list['payment_no'] = GenOrderNo("payment", '');
                $list['order_no'] = $trade_content['contract_no'];
                $list['order_type'] = 0;
                $list['confirm_time'] = date('Y-m-d H:i:s');
                $list['amount'] = $money;
                $list['confirm_user'] = session(C("USER_AUTH_KEY"));
                $list['remarks'] = $remarks;
                $model_payment = M("payment");
                $faker = $model_payment->add($list);

                if($faker){
                    return true;
                }else{
                    $error = "款项登记发生错误";
                    return false;
                }
            }else{
                $error = "请勿重复提交";
                return false;
            }
        }else{
            if($verify_content['failed_count']>=10){
                $status['status'] = 2;
                $faker = $model_system_verify->where("id='%d'", $verify_content['id'])->save($status);
                $faker = $faker && createLogVerify('system_verify',$verify_content['id'],'');
                if($faker){
                    $success = "错误次数过多，请重新发送验证码";
                    return true;
                }else{
                    $error = "错误次数过多，请重新发送验证码";
                    return false;
                }
            }elseif($verify !== $verify_content['verify']){
                //验证不通过则验证失败次数+1
                if($model_system_verify->where("id='%d'", $verify_content['id'])->setInc('failed_count',1)){
                    $success = "验证码错误";
                    return true;
                }
            }elseif($verify_content['expire_time'] < date('Y-m-d H:i:s')){
                $error = "验证码过期,请重新发送验证码";
                return false;
            }
        }
    }

    private function trade_assign_list($page_size,$data)
    {

        $join=" left join __STORECARD__ as s on t.storecard_id=s.id";
        $fields=" t.*,s.goods_name,s.style_info,s.brand,s.producing_area,s.style_code";
        $model=M("TradeAssign as t");

        $where=array(
            "trade_id"=>$data["search"]["id"]
        );


        if (!$page_size) {
            $page_size = 10;
        }

        $count =$model->where($where)->count();


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


        $data["list"] = $model->where($where)->field($fields)->join($join)->limit(($data["p"] - 1) * $page_size,$page_size)->select();
        $pageClass = new \Think\Page($count,$page_size);
        $pageClass->rollPage = 8;
        $data["page"] = $pageClass->show_drp($data["funcid"],"");
        $data["page_size"] = $page_size;
        return $data;
    }

    private function contract_edit($data){
        $id=I("id/d",0);
        if($id<0)
        {
            $this->ajaxResult("交易id不存在");
        }
        $model=M("Trade");
        $info=$model->where(array("id"=>$id))->find();
        if(!$info)
        {
            $this->ajaxResult("交易信息不存在");
        }
        $edit_list=array(
            array("title"=>"销售合同","field"=>"contract_no"),
        );
        $data["trade"]=$info;
        $data["edit_list"]=$edit_list;

        $data["pop_title"]="销售合同登记";

        foreach($data as $key=>$val) {
            $this->assign($key, $val);
        }

        $html = $this->fetch("Trade:other_edit");
        echo $html;
    }

    private function other_edit_save($data){
        $id=I("id/d",0);
        $modify_time=I("_lastchanged");
        if($id<0)
        {
            $this->ajaxResult("交易id不存在");
        }
        $model=D("Trade");
        $info=$model->where(array("id"=>$id))->find();
        if(!$info)
        {
            $this->ajaxResult("交易信息不存在");
        }
        if($info["modify_time"]!=$modify_time)
        {
            $this->ajaxResult("信息已经被修改！");
        }
        $cur_data=$model->create();
        if(count($cur_data)<0)
        {
            $this->ajaxResult("没有输入需要更新的数据");
        }
        $cur_data["modify_time"]=date("Y-m-d H:i:s");
        $cur_data["modify_user"]=$this->login_user["code"];

        $result=$model->where(array(
            "id"=>$id,
            "status"=>array("lt","7")
        ))->save($cur_data);
        if(!$result)
        {
            $this->ajaxResult("没有输入需要更新的数据");
        }

        $this->ajax_closePopup($data["funcid"]);
        $this->ajax_refresh($data["pfuncid"]);
        $this->ajaxResult();
        die;
    }


    private function storecard_edit($data){
        $id=I("id/d",0);
        if($id<0)
        {
            $this->ajaxResult("交易id不存在");
        }
        $model=M("Trade");
        $info=$model->where(array("id"=>$id))->find();
        if(!$info)
        {
            $this->ajaxResult("交易信息不存在");
        }
        $edit_list=array(
            array("title"=>"存储卡","field"=>"buyer_storecard_no"),
        );
        $perfix=array();


        if(empty($info["buyer_storecard_no"]))
        {
            $perfix[]=M("Warehouse")->where(array("code"=>$info["warehouse_code"]))->getField("prefix");
            $perfix[]=M("Customer")->where(array("id"=>$info["customer_id"]))->getField("prefix");
            $data["storecard_prefix"]=join("_",$perfix);
        }else
        {


            $cur_pos=mb_strrpos($info["buyer_storecard_no"],"_");
            $data["storecard_no"]=mb_substr($info["buyer_storecard_no"],$cur_pos+1,mb_strlen($info["buyer_storecard_no"])-$cur_pos);
            $data["storecard_prefix"]=mb_substr($info["buyer_storecard_no"],0,$cur_pos);
        }
        $data["trade"]=$info;
        $data["edit_list"]=$edit_list;

        $data["pop_title"]="存储卡登记";

        foreach($data as $key=>$val) {
            $this->assign($key, $val);
        }

        $html = $this->fetch("Trade:storecard_edit");
        echo $html;
    }

    private function storecard_edit_save($data){
        $id=I("id/d",0);
        $modify_time=I("_lastchanged");
        $storecard_perfix=I("storecard_perfix");
        $storecard_no=I("storecard_no");
        $add_allow=I("add_allow");
        if($id<0)
        {
            $this->ajaxResult("交易id不存在");
        }
        $model=D("Trade");
        $info=$model->where(array("id"=>$id))->find();
        if(!$info)
        {
            $this->ajaxResult("交易信息不存在");
        }
        if($info["modify_time"]!=$modify_time)
        {
            $this->ajaxResult("信息已经被修改！");
        }

        if(empty($storecard_no))
        {
            $this->ajaxResult("存储卡序号不能为空");
        }

        $buyer_storecard_no=$storecard_perfix."_".$storecard_no;
        if($info["buyer_storecard_no"]==$buyer_storecard_no)
        {
            $this->ajaxResult("存储卡号未更改");
        }

        $model_storecard=M("Storecard");
        $storecard_info=$model_storecard->where(array("storecard_no"=>$buyer_storecard_no))->find();
        if($storecard_info){
            $this->ajaxResult("存储卡号已经被使用了");
        }

        $model_virtual=M("StorecardVirtual");
        $virtualinfo=$model_virtual->where(array(
            "storecard_no"=>$buyer_storecard_no,
            "customer_id"=>$info["customer_id"]
            ))->find();
        $virtual_data=array();
        $virtual_data["modify_user"]=$this->login_user["code"];
        $virtual_data["modify_time"]=date("Y-m-d H:i:s");
        $model->startTrans();
        if($virtualinfo)
        {
            if($virtualinfo["add_allow"]!=1)
            {
                $this->ajaxResult("此虚拟存储卡号已经存在,但是不允许追加");
            }
            if($virtualinfo["lock_weight"]>0)
            {
                $this->ajaxResult("虚拟存储卡号已经有锁定库存,不能追加");
            }
            if($virtualinfo["org_id"]!=$info["org_id"])
            {
                $this->ajaxResult("此虚拟存储卡号已经存在,但是联盟id不一致");
            }
            if($virtualinfo["warehouse_code"]!=$info["warehouse_code"])
            {
                $this->ajaxResult("此虚拟存储卡号已经存在,但是仓库与交易不一致");
            }
            if($virtualinfo["customer_id"]!=$info["customer_id"])
            {
                $this->ajaxResult("此虚拟存储卡号已经存在,但是客户id不一致");
            }
            if($virtualinfo["goods_id"]!=$info["goods_id"])
            {
                $this->ajaxResult("此虚拟存储卡号已经存在,但是货品id不一致");
            }
            if($virtualinfo["goods_no"]!=$info["goods_no"])
            {
                $this->ajaxResult("此虚拟存储卡号已经存在,但是货品编码不一致");
            }
            if($virtualinfo["goods_no"]!=$info["goods_no"])
            {
                $this->ajaxResult("此虚拟存储卡号已经存在,但是货品编码不一致");
            }
            if($virtualinfo["goods_name"]!=$info["goods_name"])
            {
                $this->ajaxResult("此虚拟存储卡号已经存在,但是货品名称不一致");
            }
            if($virtualinfo["style_info"]!=$info["style_info"])
            {
                $this->ajaxResult("此虚拟存储卡号已经存在,但是规格不一致");
            }
            if($virtualinfo["materials"]!=$info["materials"])
            {
                $this->ajaxResult("此虚拟存储卡号已经存在,但是材质不一致");
            }
            if($virtualinfo["brand"]!=$info["brand"])
            {
                $this->ajaxResult("此虚拟存储卡号已经存在,但是品牌名称不一致");
            }
            if($virtualinfo["producing_area"]!=$info["producing_area"])
            {
                $this->ajaxResult("此虚拟存储卡号已经存在,但是产地不一致");
            }
            if($virtualinfo["style_code"]!=$info["style_code"])
            {
                $this->ajaxResult("此虚拟存储卡号已经存在,但是商品编码不一致");
            }


            $virtual_data["weight"]=array("exp","weight+".$info["weight"]);
            //$virtual_data["qty"]=array("exp","qty+".$info["qty"]);
            //$virtual_data["bulkcargo"]=array("exp","bulkcargo+".$info["bulkcargo"]);

            $result=$model_virtual->where(array("storecard_no"=>$buyer_storecard_no))->save($virtual_data);
        }else
        {
            $virtual_data["org_id"]=$info["org_id"];
            $virtual_data["customer_id"]=$info["customer_id"];
            $virtual_data["storecard_no"]=$buyer_storecard_no;
            $virtual_data["warehouse_code"]=$info["warehouse_code"];
            $virtual_data["customer_name"]=$info["customer_name"];
            $virtual_data["goods_id"]=$info["goods_id"];
            $virtual_data["goods_no"]=$info["goods_no"];
            $virtual_data["goods_name"]=$info["goods_name"];
            $virtual_data["style_info"]=$info["style_info"];
            $virtual_data["materials"]=$info["materials"];
            $virtual_data["brand"]=$info["brand"];
            $virtual_data["producing_area"]=$info["producing_area"];
            $virtual_data["style_code"]=$info["style_code"];
            $virtual_data["weight"]=$info["weight"];
            $virtual_data["qty"]=$info["qty"];
            $virtual_data["bulkcargo"]=$info["bulkcargo"];
//            $virtual_data["lock_weight"]=$info["lock_weight"];
//            $virtual_data["lock_qty"]=$info["lock_qty"];
//            $virtual_data["lock_bulkcargo"]=$info["lock_bulkcargo"];
            $virtual_data["uom_qty"]=$info["uom_qty"];
            $virtual_data["uom_weight"]=$info["uom_weight"];
            $virtual_data["uom_bulkcargo"]=$info["uom_bulkcargo"];
            $virtual_data["add_allow"]=$add_allow;
            $virtual_data["status"]="1";
            $virtual_data["create_user"]=$this->login_user["code"];
            $virtual_data["create_time"]=date("Y-m-d H:i:s");

            $result=$model_virtual->add($virtual_data);
        }

        if(!$result)
        {
            $this->ajaxResult("更新虚拟存储卡信息失败");
        }

        if(!empty($info["buyer_storecard_no"]))
        {
           $virtualinfo_old=$model_virtual->where(array(
               "storecard_no"=>$info["buyer_storecard_no"],
                "customer_id"=>$info["customer_id"],
           ))->find();
           if(!$virtualinfo_old)
           {
               $this->ajaxResult("旧虚拟存储卡信息不存在！");
           }
            if($virtualinfo_old["lock_weight"]>0)
            {
                $this->ajaxResult("原始虚拟存储卡号已经有锁定库存,请释放后再修改");
            }


           $result=$model_virtual->where(array(
               "storecard_no"=>$info["buyer_storecard_no"],
               "customer_id"=>$info["customer_id"],
               "weight"=>array("egt",$info["weight"]),
           ))->save(array(
               "weight"=>array("exp","weight-".$info["weight"]),
              // "qty"=>array("exp","qty-".$info["qty"]),
           ));
            if(!$result)
            {
                $this->ajaxResult("更新原来存储卡失败！");
            }

            $model_virtual->where(array(
                "storecard_no"=>$info["buyer_storecard_no"],
                "customer_id"=>$info["customer_id"],
                "weight"=>0,
            ))->delete();
        }


        $cur_data["buyer_storecard_no"]=$buyer_storecard_no;
        $cur_data["modify_time"]=date("Y-m-d H:i:s");
        $cur_data["modify_user"]=$this->login_user["code"];

        $result=$model->where(array("id"=>$id))->save($cur_data);
        if(!$result)
        {
            $this->ajaxResult("更新订单存储卡失败！");
        }
        $model->commit();
        $this->ajax_closePopup($data["funcid"]);
        $this->ajax_refresh($data["pfuncid"]);
        $this->ajaxResult();
        die;

    }

    private function get_package_list($data){
        $id=I("id/d",0);
        $storecard_id=I("sid");
        if($id<0)
        {
            $this->ajaxResult("交易id不存在");
        }
        $model=M("TradeAssign");
        $info=$model->where(array("id"=>$id))->find();
        if(!$info)
        {
            $this->ajaxResult("交易明细信息不存在");
        }
        $model=M("Trade");
        $trade_info=$model->where(array("id"=>$info["trade_id"]))->find();
        if(!$trade_info)
        {
            $this->ajaxResult("交易信息不存在");
        }

        $assgin_mode=M("Goods")->where(array("id"=>$trade_info["goods_id"]))->getField("assign_mode");
        $data["assign_mode"]=$assgin_mode;
        $data["trade_id"]=$info["trade_id"];
        $data["storecard_id"]=$storecard_id;
        $model=M("TradeAssignButtress");

        $data["list"]=$model->where(Array(
            "trade_id"=>$info["trade_id"],
            "storecard_id"=>$storecard_id,
        ))->field("storecard_id,package_id,package_no,sum(weight) as weight")->group("storecard_id,package_id,package_no")->select();

        foreach($data as $key=>$val) {
            $this->assign($key, $val);
        }

        $html = $this->fetch("Trade:package_list");
        echo $html;

    }


    private function get_buttress_list($data){
        $id=I("id/d",0);
        $package_id=I("pid/d",0);
        $data["package_id"]=$package_id;
        if($id<0)
        {
            $this->ajaxResult("交易id不存在");
        }
//        $model=M("TradeAssign");
//        $info=$model->where(array("id"=>$id))->find();
//        if(!$info)
//        {
//            $this->ajaxResult("交易明细信息不存在");
//        }
        $model=M("Trade");
        $trade_info=$model->where(array("id"=>$id))->find();
        if(!$trade_info)
        {
            $this->ajaxResult("交易信息不存在");
        }

//        $assgin_mode=M("Goods")->where(array("id"=>$trade_info["goods_id"]))->getField("assign_mode");
//        $data["assign_mode"]=$assgin_mode;

        $model=M("TradeAssignButtress");

        $data["list"]=$model->where(Array(
            "trade_id"=>$id,
            "package_id"=>$package_id,
        ))->select();

        foreach($data as $key=>$val) {
            $this->assign($key, $val);
        }

        $html = $this->fetch("Trade:buttress_list");
        echo $html;

    }

    private function delivery_edit($data){
        $id=I("id/d",0);
        if($id<0)
        {
            $this->ajaxResult("交易id不存在");
        }
        $model=M("Trade");
        $info=$model->where(array("id"=>$id))->find();
        if(!$info)
        {
            $this->ajaxResult("交易信息不存在");
        }
        $edit_list=array(
            array("title"=>"提单号码","field"=>"delivery_no"),
            array("title"=>"提单日期","field"=>"delivery_date","datatype"=>"dt"),
            array("title"=>"截止日期","field"=>"delivery_expired","datatype"=>"dt"),
            array("title"=>"提货信息","field"=>"delivery_carinfo"),

        );
        $data["trade"]=$info;
        $data["edit_list"]=$edit_list;

        $data["pop_title"]="提单修改";

        foreach($data as $key=>$val) {
            $this->assign($key, $val);
        }

        $html = $this->fetch("Trade:other_edit");
        echo $html;
    }

    private function trade_assign($data){
        $id=I("id/d",0);
        $model=M("Trade");
        $trade_info=$model->where(array("id"=>$id))->find();
        if(!$trade_info)
        {
            $this->ajaxResult("交易信息不存在");
        }
        if($trade_info["status"]!=2)
        {
            $this->ajaxResult("交易不是可配货状态");
        }
        if($trade_info["assign_status"]>=2)
        {
            $this->ajaxResult("交易不是可配货状态");
        }
        $assign_weight=$trade_info["weight"]-$trade_info["assign_weight"];
        if($assign_weight<=0)
        {
            $this->ajaxResult("交易可配货重量大于单据重量");
        }
        $model->startTrans();
        if(!assign($id,$assign_weight))
        {
            $this->ajaxResult("单据配货失败！");
        }
        $model->commit();
        $this->ajax_hideConfirm();
        $this->ajax_refresh($data["funcid"]);
        $this->ajaxResult("配货完成");
    }


    private function trade_assign_del($data){
        $id=I("get.assign_id/d",0);
        $model=M("Trade");
        $model_tr=M("TradeAssign");
        $info=$model_tr->where(array("id"=>$id))->find();
        if(!info)
        {
            $this->ajaxResult("配货存储卡信息不存在");
        }
        $trade_id=$info["trade_id"];
        $trade_info=$model->where(array("id"=>$trade_id))->find();
        if(!$trade_info)
        {
            $this->ajaxResult("交易信息不存在");
        }
        if($trade_info["status"]!=2)
        {
            $this->ajaxResult("交易不是可配货状态");
        }
//        if($trade_info["assign_status"]>=2)
//        {
//            $this->ajaxResult("交易不是可配货状态");
//        }

        $model->startTrans();
        if(!removeCard($trade_id,$info["storecard_id"]))
        {
            $this->ajaxResult("删除配货存储卡[".$info["storecard_no"]."]失败！");
        }
        $model->commit();
        $this->ajax_hideConfirm();
        $this->ajax_func($data["funcid"]."_del_callback","'assign','".$info["storecard_id"]."'");
        $this->ajaxResult("删除完成");
    }

    private function trade_assign_package_del($data){
        $package_id=I("request.package_id/d",0);
        $trade_id=I("id/d",0);
        $model=M("Trade");
        $model_tr=M("TradeAssignButtress");
        $list=$model_tr->where(array(
            "trade_id"=>$trade_id,
            "package_id"=>$package_id)
        )->select();
        if(!$list)
        {
            $this->ajaxResult("配货码单配货信息不存在");
        }
        $trade_info=$model->where(array("id"=>$trade_id))->find();
        if(!$trade_info)
        {
            $this->ajaxResult("交易信息不存在");
        }
        if($trade_info["status"]!=2)
        {
            $this->ajaxResult("交易不是可配货状态");
        }
//        if($trade_info["assign_status"]>=2)
//        {
//            $this->ajaxResult("交易不是可配货状态");
//        }

        $model->startTrans();
        if(!removePackage($trade_id,$package_id))
        {
            $this->ajaxResult("删除配货码单失败！");
        }
        $model->commit();
        $this->ajax_hideConfirm();
        $this->ajax_func($data["funcid"]."_del_callback","'package','$package_id'");
        $this->ajaxResult("删除完成");
    }

    private function trade_assign_buttress_del($data){
        $buttress_id=I("get.buttress_id/d",0);
        $trade_id=I("id/d",0);
        $model=M("Trade");
        $model_tr=M("TradeAssignButtress");
        $list=$model_tr->where(array(
                "trade_id"=>$trade_id,
                "package_id"=>$buttress_id)
        )->select();
        if(!$list)
        {
            $this->ajaxResult("配货码单配货信息不存在");
        }
        $trade_info=$model->where(array("id"=>$trade_id))->find();
        if(!$trade_info)
        {
            $this->ajaxResult("交易信息不存在");
        }
        if($trade_info["status"]!=2)
        {
            $this->ajaxResult("交易不是可配货状态");
        }
        if($trade_info["assign_status"]>=2)
        {
            $this->ajaxResult("交易不是可配货状态");
        }

        $model->startTrans();
        if(!removeButtress($trade_id,$buttress_id))
        {
            $this->ajaxResult("删除配货码单失败！");
        }
        $model->commit();
        $this->ajax_hideConfirm();
        $this->ajax_func($data["funcid"]."_del_callback","'buttress','$buttress_id'");
        $this->ajaxResult("删除完成");
    }

    public function create_chain_process(){

           if(create_chain())
           {
               echo "success";
           }
    }


}
