<?php
    //Area[type]  国家地区[类型]
    function table_Area_type(){
        return array("0"=>array("id"=>"0","name"=>"国家"),
                     "1"=>array("id"=>"1","name"=>"省市"),
                     "2"=>array("id"=>"2","name"=>"地区"),
                     "3"=>array("id"=>"3","name"=>"县市"),
                     "4"=>array("id"=>"4","name"=>"区域"),
                     "5"=>array("id"=>"5","name"=>"街道"));
    }

    function get_table_Area_type($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Area_type();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Area_type($value){
        if ($value=="") return "";
        $arr=table_Area_type();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Area[status]  国家地区[状态]
    function table_Area_status(){
        return array("1"=>array("id"=>"1","name"=>"有效"),
                     "0"=>array("id"=>"0","name"=>"无效"));
    }

    function get_table_Area_status($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Area_status();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Area_status($value){
        if ($value=="") return "";
        $arr=table_Area_status();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Chain[uom_weight]  交易链[重量单位]
    function table_Chain_uom_weight(){
        return array("subcode('UOM_WEIGHT')"=>array("id"=>"subcode('UOM_WEIGHT')","name"=>""));
    }

    function get_table_Chain_uom_weight($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Chain_uom_weight();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Chain_uom_weight($value){
        if ($value=="") return "";
        $arr=table_Chain_uom_weight();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Chain[interface_status]  交易链[仓库接口]
    function table_Chain_interface_status(){
        return array("0"=>array("id"=>"0","name"=>"无"),
                     "1"=>array("id"=>"1","name"=>"等待发送仓库"),
                     "2"=>array("id"=>"2","name"=>"已发送仓库"),
                     "3"=>array("id"=>"3","name"=>"仓库处理返回"));
    }

    function get_table_Chain_interface_status($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Chain_interface_status();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Chain_interface_status($value){
        if ($value=="") return "";
        $arr=table_Chain_interface_status();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Chain[interface_process]  交易链[接口处理]
    function table_Chain_interface_process(){
        return array("0"=>array("id"=>"0","name"=>"无"),
                     "1"=>array("id"=>"1","name"=>"失败"),
                     "2"=>array("id"=>"2","name"=>"成功"));
    }

    function get_table_Chain_interface_process($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Chain_interface_process();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Chain_interface_process($value){
        if ($value=="") return "";
        $arr=table_Chain_interface_process();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Chain[status]  交易链[状态]
    function table_Chain_status(){
        return array("0"=>array("id"=>"0","name"=>"草稿"),
                     "1"=>array("id"=>"1","name"=>"待处理"),
                     "2"=>array("id"=>"2","name"=>"结束"),
                     "7"=>array("id"=>"7","name"=>"取消"),
                     "8"=>array("id"=>"8","name"=>"失效"));
    }

    function get_table_Chain_status($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Chain_status();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Chain_status($value){
        if ($value=="") return "";
        $arr=table_Chain_status();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //ChainDetail[interface_process]  交易链明细[接口处理]
    function table_ChainDetail_interface_process(){
        return array("0"=>array("id"=>"0","name"=>"无"),
                     "1"=>array("id"=>"1","name"=>"失败"),
                     "2"=>array("id"=>"2","name"=>"成功"));
    }

    function get_table_ChainDetail_interface_process($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_ChainDetail_interface_process();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_ChainDetail_interface_process($value){
        if ($value=="") return "";
        $arr=table_ChainDetail_interface_process();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Customer[type]  客户资料[类型]
    function table_Customer_type(){
        return array("0"=>array("id"=>"0","name"=>"贸易"),
                     "1"=>array("id"=>"1","name"=>"厂商"));
    }

    function get_table_Customer_type($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Customer_type();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Customer_type($value){
        if ($value=="") return "";
        $arr=table_Customer_type();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Customer[industry_code]  客户资料[行业分类]
    function table_Customer_industry_code(){
        return array("subcode('customer:industry')"=>array("id"=>"subcode('customer:industry')","name"=>""));
    }

    function get_table_Customer_industry_code($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Customer_industry_code();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Customer_industry_code($value){
        if ($value=="") return "";
        $arr=table_Customer_industry_code();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Customer[customer_level]  客户资料[层级]
    function table_Customer_customer_level(){
        return array("0"=>array("id"=>"0","name"=>"未分"),
                     "1"=>array("id"=>"1","name"=>"1级"),
                     "2"=>array("id"=>"2","name"=>"2级"),
                     "3"=>array("id"=>"3","name"=>"3级"),
                     "4"=>array("id"=>"4","name"=>"4级"),
                     "5"=>array("id"=>"5","name"=>"5级"),
                     "6"=>array("id"=>"6","name"=>"6级"));
    }

    function get_table_Customer_customer_level($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Customer_customer_level();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Customer_customer_level($value){
        if ($value=="") return "";
        $arr=table_Customer_customer_level();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Customer[invoice_flag]  客户资料[发票要求]
    function table_Customer_invoice_flag(){
        return array("0"=>array("id"=>"0","name"=>"纸张发票"),
                     "1"=>array("id"=>"1","name"=>"电子发票"));
    }

    function get_table_Customer_invoice_flag($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Customer_invoice_flag();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Customer_invoice_flag($value){
        if ($value=="") return "";
        $arr=table_Customer_invoice_flag();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Customer[sms_open]  客户资料[短信服务]
    function table_Customer_sms_open(){
        return array("0"=>array("id"=>"0","name"=>"关闭"),
                     "1"=>array("id"=>"1","name"=>"开启"));
    }

    function get_table_Customer_sms_open($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Customer_sms_open();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Customer_sms_open($value){
        if ($value=="") return "";
        $arr=table_Customer_sms_open();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Customer[sms_transfer_out]  客户资料[货权转出通知]
    function table_Customer_sms_transfer_out(){
        return array("0"=>array("id"=>"0","name"=>"关闭"),
                     "1"=>array("id"=>"1","name"=>"定制"));
    }

    function get_table_Customer_sms_transfer_out($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Customer_sms_transfer_out();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Customer_sms_transfer_out($value){
        if ($value=="") return "";
        $arr=table_Customer_sms_transfer_out();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Customer[sms_transfer_in]  客户资料[货权转入通知]
    function table_Customer_sms_transfer_in(){
        return array("0"=>array("id"=>"0","name"=>"关闭"),
                     "1"=>array("id"=>"1","name"=>"定制"));
    }

    function get_table_Customer_sms_transfer_in($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Customer_sms_transfer_in();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Customer_sms_transfer_in($value){
        if ($value=="") return "";
        $arr=table_Customer_sms_transfer_in();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Customer[sms_delivery]  客户资料[提货时通知]
    function table_Customer_sms_delivery(){
        return array("0"=>array("id"=>"0","name"=>"关闭"),
                     "1"=>array("id"=>"1","name"=>"定制"));
    }

    function get_table_Customer_sms_delivery($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Customer_sms_delivery();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Customer_sms_delivery($value){
        if ($value=="") return "";
        $arr=table_Customer_sms_delivery();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Customer[reply_status]  客户资料[回复状态]
    function table_Customer_reply_status(){
        return array("0"=>array("id"=>"0","name"=>"无"),
                     "1"=>array("id"=>"1","name"=>"待审"),
                     "2"=>array("id"=>"2","name"=>"拒绝"),
                     "3"=>array("id"=>"3","name"=>"通过"));
    }

    function get_table_Customer_reply_status($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Customer_reply_status();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Customer_reply_status($value){
        if ($value=="") return "";
        $arr=table_Customer_reply_status();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Customer[lock_status]  客户资料[锁定状态]
    function table_Customer_lock_status(){
        return array("0"=>array("id"=>"0","name"=>"无"),
                     "1"=>array("id"=>"1","name"=>"锁定"));
    }

    function get_table_Customer_lock_status($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Customer_lock_status();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Customer_lock_status($value){
        if ($value=="") return "";
        $arr=table_Customer_lock_status();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Customer[status]  客户资料[状态]
    function table_Customer_status(){
        return array("0"=>array("id"=>"0","name"=>"无效"),
                     "1"=>array("id"=>"1","name"=>"有效"),
                     "7"=>array("id"=>"7","name"=>"取消"));
    }

    function get_table_Customer_status($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Customer_status();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Customer_status($value){
        if ($value=="") return "";
        $arr=table_Customer_status();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //CustomerAddress[status]  客户地址[状态]
    function table_CustomerAddress_status(){
        return array("0"=>array("id"=>"0","name"=>"无效"),
                     "1"=>array("id"=>"1","name"=>"有效"));
    }

    function get_table_CustomerAddress_status($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_CustomerAddress_status();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_CustomerAddress_status($value){
        if ($value=="") return "";
        $arr=table_CustomerAddress_status();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //CustomerApply[type]  客户申请信息[申请类型]
    function table_CustomerApply_type(){
        return array("0"=>array("id"=>"0","name"=>"客户申请"),
                     "1"=>array("id"=>"1","name"=>"客户变更"),
                     "2"=>array("id"=>"2","name"=>"提单变更"));
    }

    function get_table_CustomerApply_type($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_CustomerApply_type();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_CustomerApply_type($value){
        if ($value=="") return "";
        $arr=table_CustomerApply_type();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //CustomerApply[reply_status]  客户申请信息[回复状态]
    function table_CustomerApply_reply_status(){
        return array("0"=>array("id"=>"0","name"=>"无"),
                     "1"=>array("id"=>"1","name"=>"待审"),
                     "2"=>array("id"=>"2","name"=>"拒绝"),
                     "3"=>array("id"=>"3","name"=>"通过"));
    }

    function get_table_CustomerApply_reply_status($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_CustomerApply_reply_status();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_CustomerApply_reply_status($value){
        if ($value=="") return "";
        $arr=table_CustomerApply_reply_status();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //CustomerApply[status]  客户申请信息[状态]
    function table_CustomerApply_status(){
        return array("0"=>array("id"=>"0","name"=>"待处理"),
                     "1"=>array("id"=>"1","name"=>"已处理"));
    }

    function get_table_CustomerApply_status($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_CustomerApply_status();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_CustomerApply_status($value){
        if ($value=="") return "";
        $arr=table_CustomerApply_status();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //CustomerCategory[status]  客户分类[状态]
    function table_CustomerCategory_status(){
        return array("1"=>array("id"=>"1","name"=>"有效"),
                     "0"=>array("id"=>"0","name"=>"无效"));
    }

    function get_table_CustomerCategory_status($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_CustomerCategory_status();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_CustomerCategory_status($value){
        if ($value=="") return "";
        $arr=table_CustomerCategory_status();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //CustomerContact[status]  客户存储合同[状态]
    function table_CustomerContact_status(){
        return array("0"=>array("id"=>"0","name"=>"无效"),
                     "1"=>array("id"=>"1","name"=>"有效"),
                     "2"=>array("id"=>"2","name"=>"过期"));
    }

    function get_table_CustomerContact_status($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_CustomerContact_status();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_CustomerContact_status($value){
        if ($value=="") return "";
        $arr=table_CustomerContact_status();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //CustomerDelivery[status]  客户提货信息[状态]
    function table_CustomerDelivery_status(){
        return array("0"=>array("id"=>"0","name"=>"无效"),
                     "1"=>array("id"=>"1","name"=>"有效"));
    }

    function get_table_CustomerDelivery_status($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_CustomerDelivery_status();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_CustomerDelivery_status($value){
        if ($value=="") return "";
        $arr=table_CustomerDelivery_status();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //CustomerRela[type]  客户关联关系[类型]
    function table_CustomerRela_type(){
        return array("0"=>array("id"=>"0","name"=>"普通"),
                     "1"=>array("id"=>"1","name"=>"中等"),
                     "2"=>array("id"=>"2","name"=>"重要"));
    }

    function get_table_CustomerRela_type($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_CustomerRela_type();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_CustomerRela_type($value){
        if ($value=="") return "";
        $arr=table_CustomerRela_type();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //CustomerRela[status]  客户关联关系[状态]
    function table_CustomerRela_status(){
        return array("0"=>array("id"=>"0","name"=>"无效"),
                     "1"=>array("id"=>"1","name"=>"有效"));
    }

    function get_table_CustomerRela_status($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_CustomerRela_status();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_CustomerRela_status($value){
        if ($value=="") return "";
        $arr=table_CustomerRela_status();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //CustomerUser[type]  客户/用户对应关系[类型]
    function table_CustomerUser_type(){
        return array("0"=>array("id"=>"0","name"=>"管理"),
                     "1"=>array("id"=>"1","name"=>"业务"));
    }

    function get_table_CustomerUser_type($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_CustomerUser_type();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_CustomerUser_type($value){
        if ($value=="") return "";
        $arr=table_CustomerUser_type();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Delivery[uom_qty]  提单[数量单位]
    function table_Delivery_uom_qty(){
        return array("subcode('UOM_QTY')"=>array("id"=>"subcode('UOM_QTY')","name"=>""));
    }

    function get_table_Delivery_uom_qty($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Delivery_uom_qty();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Delivery_uom_qty($value){
        if ($value=="") return "";
        $arr=table_Delivery_uom_qty();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Delivery[uom_weight]  提单[重量单位]
    function table_Delivery_uom_weight(){
        return array("subcode('UOM_WEIGHT')"=>array("id"=>"subcode('UOM_WEIGHT')","name"=>""));
    }

    function get_table_Delivery_uom_weight($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Delivery_uom_weight();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Delivery_uom_weight($value){
        if ($value=="") return "";
        $arr=table_Delivery_uom_weight();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Delivery[uom_bulkcargo]  提单[散件单位]
    function table_Delivery_uom_bulkcargo(){
        return array("subcode('UOM_BULKCARGO')"=>array("id"=>"subcode('UOM_BULKCARGO')","name"=>""));
    }

    function get_table_Delivery_uom_bulkcargo($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Delivery_uom_bulkcargo();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Delivery_uom_bulkcargo($value){
        if ($value=="") return "";
        $arr=table_Delivery_uom_bulkcargo();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Delivery[is_whole]  提单[是否整卡]
    function table_Delivery_is_whole(){
        return array("1"=>array("id"=>"1","name"=>"是"),
                     "0"=>array("id"=>"0","name"=>"否"));
    }

    function get_table_Delivery_is_whole($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Delivery_is_whole();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Delivery_is_whole($value){
        if ($value=="") return "";
        $arr=table_Delivery_is_whole();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Delivery[is_expired]  提单[是否过期]
    function table_Delivery_is_expired(){
        return array("1"=>array("id"=>"1","name"=>"是"),
                     "0"=>array("id"=>"0","name"=>"否"));
    }

    function get_table_Delivery_is_expired($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Delivery_is_expired();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Delivery_is_expired($value){
        if ($value=="") return "";
        $arr=table_Delivery_is_expired();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Delivery[bills_confirm]  提单[款项确认]
    function table_Delivery_bills_confirm(){
        return array("0"=>array("id"=>"0","name"=>"未"),
                     "1"=>array("id"=>"1","name"=>"付款"),
                     "2"=>array("id"=>"2","name"=>"收款"));
    }

    function get_table_Delivery_bills_confirm($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Delivery_bills_confirm();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Delivery_bills_confirm($value){
        if ($value=="") return "";
        $arr=table_Delivery_bills_confirm();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Delivery[payment_type]  提单[付款类型]
    function table_Delivery_payment_type(){
        return array("0"=>array("id"=>"0","name"=>"现金"),
                     "1"=>array("id"=>"1","name"=>"电子转账"),
                     "2"=>array("id"=>"2","name"=>"支票"),
                     "2"=>array("id"=>"2","name"=>"支票"));
    }

    function get_table_Delivery_payment_type($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Delivery_payment_type();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Delivery_payment_type($value){
        if ($value=="") return "";
        $arr=table_Delivery_payment_type();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Delivery[status]  提单[状态]
    function table_Delivery_status(){
        return array("0"=>array("id"=>"0","name"=>"草稿"),
                     "1"=>array("id"=>"1","name"=>"有效"),
                     "2"=>array("id"=>"2","name"=>"结束"),
                     "7"=>array("id"=>"7","name"=>"取消"),
                     "8"=>array("id"=>"8","name"=>"失效"));
    }

    function get_table_Delivery_status($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Delivery_status();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Delivery_status($value){
        if ($value=="") return "";
        $arr=table_Delivery_status();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Department[type]  部门信息[类型]
    function table_Department_type(){
        return array("0"=>array("id"=>"0","name"=>"管理"),
                     "1"=>array("id"=>"1","name"=>"财务"),
                     "2"=>array("id"=>"2","name"=>"生产"),
                     "3"=>array("id"=>"3","name"=>"仓储"));
    }

    function get_table_Department_type($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Department_type();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Department_type($value){
        if ($value=="") return "";
        $arr=table_Department_type();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Department[status]  部门信息[状态]
    function table_Department_status(){
        return array("1"=>array("id"=>"1","name"=>"有效"),
                     "0"=>array("id"=>"0","name"=>"无效"));
    }

    function get_table_Department_status($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Department_status();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Department_status($value){
        if ($value=="") return "";
        $arr=table_Department_status();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Fee[status]  客户账单[状态]
    function table_Fee_status(){
        return array("0"=>array("id"=>"0","name"=>"待客户付款"),
                     "1"=>array("id"=>"1","name"=>"待仓库确认"),
                     "2"=>array("id"=>"2","name"=>"仓库已确认"));
    }

    function get_table_Fee_status($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Fee_status();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Fee_status($value){
        if ($value=="") return "";
        $arr=table_Fee_status();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Goods[uom_weight]  货品信息[重量单位]
    function table_Goods_uom_weight(){
        return array("subcode('UOM_WEIGHT')"=>array("id"=>"subcode('UOM_WEIGHT')","name"=>""));
    }

    function get_table_Goods_uom_weight($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Goods_uom_weight();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Goods_uom_weight($value){
        if ($value=="") return "";
        $arr=table_Goods_uom_weight();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Goods[uom_qty]  货品信息[数量单位]
    function table_Goods_uom_qty(){
        return array("subcode('UOM_QTY')"=>array("id"=>"subcode('UOM_QTY')","name"=>""));
    }

    function get_table_Goods_uom_qty($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Goods_uom_qty();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Goods_uom_qty($value){
        if ($value=="") return "";
        $arr=table_Goods_uom_qty();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Goods[uom_bulkcargo]  货品信息[散件单位]
    function table_Goods_uom_bulkcargo(){
        return array("subcode('UOM_BULKCARGO')"=>array("id"=>"subcode('UOM_BULKCARGO')","name"=>""));
    }

    function get_table_Goods_uom_bulkcargo($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Goods_uom_bulkcargo();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Goods_uom_bulkcargo($value){
        if ($value=="") return "";
        $arr=table_Goods_uom_bulkcargo();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Goods[active]  货品信息[活跃等级]
    function table_Goods_active(){
        return array("0"=>array("id"=>"0","name"=>"滞销"),
                     "1"=>array("id"=>"1","name"=>"平常"),
                     "2"=>array("id"=>"2","name"=>"活跃"),
                     "3"=>array("id"=>"3","name"=>"畅销"));
    }

    function get_table_Goods_active($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Goods_active();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Goods_active($value){
        if ($value=="") return "";
        $arr=table_Goods_active();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Goods[is_real]  货品信息[是否实物]
    function table_Goods_is_real(){
        return array("1"=>array("id"=>"1","name"=>"是"),
                     "0"=>array("id"=>"0","name"=>"否"));
    }

    function get_table_Goods_is_real($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Goods_is_real();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Goods_is_real($value){
        if ($value=="") return "";
        $arr=table_Goods_is_real();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Goods[assign_mode]  货品信息[配货方式]
    function table_Goods_assign_mode(){
        return array("1"=>array("id"=>"1","name"=>"垛号"),
                     "0"=>array("id"=>"0","name"=>"码单"));
    }

    function get_table_Goods_assign_mode($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Goods_assign_mode();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Goods_assign_mode($value){
        if ($value=="") return "";
        $arr=table_Goods_assign_mode();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Goods[status]  货品信息[状态]
    function table_Goods_status(){
        return array("1"=>array("id"=>"1","name"=>"使用"),
                     "0"=>array("id"=>"0","name"=>"停止"));
    }

    function get_table_Goods_status($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Goods_status();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Goods_status($value){
        if ($value=="") return "";
        $arr=table_Goods_status();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Goods[is_sync]  货品信息[平台同步]
    function table_Goods_is_sync(){
        return array("1"=>array("id"=>"1","name"=>"是"),
                     "0"=>array("id"=>"0","name"=>"否"));
    }

    function get_table_Goods_is_sync($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Goods_is_sync();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Goods_is_sync($value){
        if ($value=="") return "";
        $arr=table_Goods_is_sync();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //GoodsAlias[type]  货品别名[类型]
    function table_GoodsAlias_type(){
        return array("0"=>array("id"=>"0","name"=>"品牌"),
                     "1"=>array("id"=>"1","name"=>"产地"),
                     "2"=>array("id"=>"2","name"=>"规格"));
    }

    function get_table_GoodsAlias_type($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_GoodsAlias_type();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_GoodsAlias_type($value){
        if ($value=="") return "";
        $arr=table_GoodsAlias_type();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //GoodsAlias[status]  货品别名[状态]
    function table_GoodsAlias_status(){
        return array("1"=>array("id"=>"1","name"=>"有效"),
                     "0"=>array("id"=>"0","name"=>"无效"));
    }

    function get_table_GoodsAlias_status($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_GoodsAlias_status();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_GoodsAlias_status($value){
        if ($value=="") return "";
        $arr=table_GoodsAlias_status();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //GoodsCategory[status]  货品分类[状态]
    function table_GoodsCategory_status(){
        return array("1"=>array("id"=>"1","name"=>"有效"),
                     "0"=>array("id"=>"0","name"=>"无效"));
    }

    function get_table_GoodsCategory_status($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_GoodsCategory_status();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_GoodsCategory_status($value){
        if ($value=="") return "";
        $arr=table_GoodsCategory_status();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //GoodsStyle[category_code]  基础货品[货品分类]
    function table_GoodsStyle_category_code(){
        return array("subcode('goods:category')"=>array("id"=>"subcode('goods:category')","name"=>""));
    }

    function get_table_GoodsStyle_category_code($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_GoodsStyle_category_code();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_GoodsStyle_category_code($value){
        if ($value=="") return "";
        $arr=table_GoodsStyle_category_code();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //GoodsStyle[uom_weight]  基础货品[重量单位]
    function table_GoodsStyle_uom_weight(){
        return array("subcode('UOM_WEIGHT')"=>array("id"=>"subcode('UOM_WEIGHT')","name"=>""));
    }

    function get_table_GoodsStyle_uom_weight($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_GoodsStyle_uom_weight();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_GoodsStyle_uom_weight($value){
        if ($value=="") return "";
        $arr=table_GoodsStyle_uom_weight();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //GoodsStyle[uom_qty]  基础货品[数量单位]
    function table_GoodsStyle_uom_qty(){
        return array("subcode('UOM_QTY')"=>array("id"=>"subcode('UOM_QTY')","name"=>""));
    }

    function get_table_GoodsStyle_uom_qty($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_GoodsStyle_uom_qty();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_GoodsStyle_uom_qty($value){
        if ($value=="") return "";
        $arr=table_GoodsStyle_uom_qty();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //GoodsStyle[uom_bulkcargo]  基础货品[散件单位]
    function table_GoodsStyle_uom_bulkcargo(){
        return array("subcode('UOM_BULKCARGO')"=>array("id"=>"subcode('UOM_BULKCARGO')","name"=>""));
    }

    function get_table_GoodsStyle_uom_bulkcargo($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_GoodsStyle_uom_bulkcargo();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_GoodsStyle_uom_bulkcargo($value){
        if ($value=="") return "";
        $arr=table_GoodsStyle_uom_bulkcargo();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //GoodsStyle[tax_rate]  基础货品[税率]
    function table_GoodsStyle_tax_rate(){
        return array("0.000"=>array("id"=>"0.000","name"=>"无"),
                     "0.060"=>array("id"=>"0.060","name"=>"6%"),
                     "0.130"=>array("id"=>"0.130","name"=>"13%"),
                     "0.170"=>array("id"=>"0.170","name"=>"17%"));
    }

    function get_table_GoodsStyle_tax_rate($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_GoodsStyle_tax_rate();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_GoodsStyle_tax_rate($value){
        if ($value=="") return "";
        $arr=table_GoodsStyle_tax_rate();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //GoodsStyle[status]  基础货品[状态]
    function table_GoodsStyle_status(){
        return array("1"=>array("id"=>"1","name"=>"有效"),
                     "0"=>array("id"=>"0","name"=>"无效"));
    }

    function get_table_GoodsStyle_status($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_GoodsStyle_status();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_GoodsStyle_status($value){
        if ($value=="") return "";
        $arr=table_GoodsStyle_status();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //LogCommon[type]  公共日志[类型]
    function table_LogCommon_type(){
        return array("user"=>array("id"=>"user","name"=>"用户"),
                     "style1"=>array("id"=>"style1","name"=>"颜色"),
                     "style2"=>array("id"=>"style2","name"=>"尺码"),
                     "year"=>array("id"=>"year","name"=>"年份"),
                     "shop"=>array("id"=>"shop","name"=>"店铺"),
                     "season"=>array("id"=>"season","name"=>"季节"),
                     "payment"=>array("id"=>"payment","name"=>"支付方式"),
                     "platform"=>array("id"=>"platform","name"=>"平台"),
                     "goods"=>array("id"=>"goods","name"=>"货品"),
                     "group"=>array("id"=>"group","name"=>"分组"),
                     "department"=>array("id"=>"department","name"=>"部门"),
                     "deliver"=>array("id"=>"deliver","name"=>"配送"),
                     "customer"=>array("id"=>"customer","name"=>"供应商"),
                     "category"=>array("id"=>"category","name"=>"分类"),
                     "brand"=>array("id"=>"brand","name"=>"品牌"),
                     "area"=>array("id"=>"area","name"=>"地区"),
                     "activity"=>array("id"=>"activity","name"=>"活动"),
                     "return_reason"=>array("id"=>"return_reason","name"=>"退货理由"),
                     "storage"=>array("id"=>"storage","name"=>"仓库"));
    }

    function get_table_LogCommon_type($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_LogCommon_type();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_LogCommon_type($value){
        if ($value=="") return "";
        $arr=table_LogCommon_type();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //LogInterface[status]  接口日志[处理状态]
    function table_LogInterface_status(){
        return array("0"=>array("id"=>"0","name"=>"未处理"),
                     "1"=>array("id"=>"1","name"=>"成功"),
                     "2"=>array("id"=>"2","name"=>"失败"));
    }

    function get_table_LogInterface_status($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_LogInterface_status();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_LogInterface_status($value){
        if ($value=="") return "";
        $arr=table_LogInterface_status();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //LogOrder[type]  凭据日志[类型]
    function table_LogOrder_type(){
        return array("sales"=>array("id"=>"sales","name"=>"销售订单"),
                     "stockin"=>array("id"=>"stockin","name"=>"仓库入库"),
                     "stockout"=>array("id"=>"stockout","name"=>"仓库出库"),
                     "stockmove"=>array("id"=>"stockmove","name"=>"仓库移仓"),
                     "stockadjust"=>array("id"=>"stockadjust","name"=>"仓库调整"),
                     "stockcheck"=>array("id"=>"stockcheck","name"=>"仓库盘点"));
    }

    function get_table_LogOrder_type($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_LogOrder_type();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_LogOrder_type($value){
        if ($value=="") return "";
        $arr=table_LogOrder_type();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //LogVerify[status]  验证码日志[状态]
    function table_LogVerify_status(){
        return array("0"=>array("id"=>"0","name"=>"待发"),
                     "1"=>array("id"=>"1","name"=>"发送"),
                     "2"=>array("id"=>"2","name"=>"过期"),
                     "3"=>array("id"=>"3","name"=>"使用"));
    }

    function get_table_LogVerify_status($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_LogVerify_status();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_LogVerify_status($value){
        if ($value=="") return "";
        $arr=table_LogVerify_status();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //MessageSend[type]  消息发送[信息类型]
    function table_MessageSend_type(){
        return array("0"=>array("id"=>"0","name"=>"注册"),
                     "1"=>array("id"=>"1","name"=>"过户"),
                     "2"=>array("id"=>"2","name"=>"提货"),
                     "3"=>array("id"=>"3","name"=>"付款"),
                     "4"=>array("id"=>"4","name"=>"收款"));
    }

    function get_table_MessageSend_type($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_MessageSend_type();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_MessageSend_type($value){
        if ($value=="") return "";
        $arr=table_MessageSend_type();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //MessageSend[send]  消息发送[发送途径]
    function table_MessageSend_send(){
        return array("0"=>array("id"=>"0","name"=>"信息"),
                     "1"=>array("id"=>"1","name"=>"微信"),
                     "2"=>array("id"=>"2","name"=>"邮件"));
    }

    function get_table_MessageSend_send($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_MessageSend_send();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_MessageSend_send($value){
        if ($value=="") return "";
        $arr=table_MessageSend_send();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //MessageSend[status]  消息发送[状态]
    function table_MessageSend_status(){
        return array("0"=>array("id"=>"0","name"=>"未发送"),
                     "1"=>array("id"=>"1","name"=>"已发送"),
                     "7"=>array("id"=>"7","name"=>"已取消"));
    }

    function get_table_MessageSend_status($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_MessageSend_status();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_MessageSend_status($value){
        if ($value=="") return "";
        $arr=table_MessageSend_status();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //MessageTemplet[type]  消息模板[信息类型]
    function table_MessageTemplet_type(){
        return array("0"=>array("id"=>"0","name"=>"注册"),
                     "1"=>array("id"=>"1","name"=>"过户"),
                     "2"=>array("id"=>"2","name"=>"提货"),
                     "3"=>array("id"=>"3","name"=>"付款"),
                     "4"=>array("id"=>"4","name"=>"收款"));
    }

    function get_table_MessageTemplet_type($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_MessageTemplet_type();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_MessageTemplet_type($value){
        if ($value=="") return "";
        $arr=table_MessageTemplet_type();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //MessageTemplet[send]  消息模板[发送途径]
    function table_MessageTemplet_send(){
        return array("0"=>array("id"=>"0","name"=>"信息"),
                     "1"=>array("id"=>"1","name"=>"微信"),
                     "2"=>array("id"=>"2","name"=>"邮件"));
    }

    function get_table_MessageTemplet_send($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_MessageTemplet_send();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_MessageTemplet_send($value){
        if ($value=="") return "";
        $arr=table_MessageTemplet_send();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //MessageTemplet[status]  消息模板[状态]
    function table_MessageTemplet_status(){
        return array("1"=>array("id"=>"1","name"=>"有效"),
                     "0"=>array("id"=>"0","name"=>"无效"));
    }

    function get_table_MessageTemplet_status($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_MessageTemplet_status();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_MessageTemplet_status($value){
        if ($value=="") return "";
        $arr=table_MessageTemplet_status();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Node[status]  模块功能[状态]
    function table_Node_status(){
        return array("1"=>array("id"=>"1","name"=>"有效"),
                     "0"=>array("id"=>"0","name"=>"无效"));
    }

    function get_table_Node_status($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Node_status();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Node_status($value){
        if ($value=="") return "";
        $arr=table_Node_status();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Node[is_admin]  模块功能[超级用户]
    function table_Node_is_admin(){
        return array("1"=>array("id"=>"1","name"=>"是"),
                     "0"=>array("id"=>"0","name"=>"否"));
    }

    function get_table_Node_is_admin($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Node_is_admin();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Node_is_admin($value){
        if ($value=="") return "";
        $arr=table_Node_is_admin();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Node[default_open]  模块功能[缺省展开]
    function table_Node_default_open(){
        return array("1"=>array("id"=>"1","name"=>"是"),
                     "0"=>array("id"=>"0","name"=>"否"));
    }

    function get_table_Node_default_open($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Node_default_open();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Node_default_open($value){
        if ($value=="") return "";
        $arr=table_Node_default_open();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Org[type]  库联联盟机构[机构类型]
    function table_Org_type(){
        return array("0"=>array("id"=>"0","name"=>"物流商"),
                     "1"=>array("id"=>"1","name"=>"经销商"),
                     "2"=>array("id"=>"2","name"=>"厂家"));
    }

    function get_table_Org_type($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Org_type();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Org_type($value){
        if ($value=="") return "";
        $arr=table_Org_type();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Org[interface_open]  库联联盟机构[接口控制]
    function table_Org_interface_open(){
        return array("0"=>array("id"=>"0","name"=>"关闭"),
                     "1"=>array("id"=>"1","name"=>"开放"));
    }

    function get_table_Org_interface_open($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Org_interface_open();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Org_interface_open($value){
        if ($value=="") return "";
        $arr=table_Org_interface_open();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Org[interface_type]  库联联盟机构[接口类型]
    function table_Org_interface_type(){
        return array("0"=>array("id"=>"0","name"=>"无"),
                     "1"=>array("id"=>"1","name"=>"线上网站"),
                     "2"=>array("id"=>"2","name"=>"线下仓库"));
    }

    function get_table_Org_interface_type($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Org_interface_type();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Org_interface_type($value){
        if ($value=="") return "";
        $arr=table_Org_interface_type();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Org[status]  库联联盟机构[状态]
    function table_Org_status(){
        return array("1"=>array("id"=>"1","name"=>"有效"),
                     "0"=>array("id"=>"0","name"=>"失效"));
    }

    function get_table_Org_status($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Org_status();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Org_status($value){
        if ($value=="") return "";
        $arr=table_Org_status();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //OrgCustomer[status]  库联/客户对应[状态]
    function table_OrgCustomer_status(){
        return array("0"=>array("id"=>"0","name"=>"申请"),
                     "1"=>array("id"=>"1","name"=>"授权"));
    }

    function get_table_OrgCustomer_status($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_OrgCustomer_status();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_OrgCustomer_status($value){
        if ($value=="") return "";
        $arr=table_OrgCustomer_status();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //OrgUser[type]  库联/用户对应关系[类型]
    function table_OrgUser_type(){
        return array("0"=>array("id"=>"0","name"=>"管理"),
                     "1"=>array("id"=>"1","name"=>"业务"));
    }

    function get_table_OrgUser_type($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_OrgUser_type();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_OrgUser_type($value){
        if ($value=="") return "";
        $arr=table_OrgUser_type();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Payment[order_type]  款项登记[交易类型]
    function table_Payment_order_type(){
        return array("0"=>array("id"=>"0","name"=>"交易"),
                     "1"=>array("id"=>"1","name"=>"补差"),
                     "2"=>array("id"=>"2","name"=>"费用"));
    }

    function get_table_Payment_order_type($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Payment_order_type();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Payment_order_type($value){
        if ($value=="") return "";
        $arr=table_Payment_order_type();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Payment[type]  款项登记[款项类型]
    function table_Payment_type(){
        return array("0"=>array("id"=>"0","name"=>"付款"),
                     "1"=>array("id"=>"1","name"=>"收款"));
    }

    function get_table_Payment_type($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Payment_type();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Payment_type($value){
        if ($value=="") return "";
        $arr=table_Payment_type();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Payment[payment_type]  款项登记[支付方式]
    function table_Payment_payment_type(){
        return array("subcode('payment')"=>array("id"=>"subcode('payment')","name"=>""));
    }

    function get_table_Payment_payment_type($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Payment_payment_type();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Payment_payment_type($value){
        if ($value=="") return "";
        $arr=table_Payment_payment_type();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Role[status]  角色[状态]
    function table_Role_status(){
        return array("1"=>array("id"=>"1","name"=>"有效"),
                     "0"=>array("id"=>"0","name"=>"无效"));
    }

    function get_table_Role_status($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Role_status();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Role_status($value){
        if ($value=="") return "";
        $arr=table_Role_status();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Role[approval]  角色[审批级别]
    function table_Role_approval(){
        return array("0"=>array("id"=>"0","name"=>"无"),
                     "1"=>array("id"=>"1","name"=>"一级"),
                     "2"=>array("id"=>"2","name"=>"二级"),
                     "3"=>array("id"=>"3","name"=>"特权"));
    }

    function get_table_Role_approval($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Role_approval();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Role_approval($value){
        if ($value=="") return "";
        $arr=table_Role_approval();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Service[status]  系统服务设置[状态]
    function table_Service_status(){
        return array("0"=>array("id"=>"0","name"=>"无效"),
                     "1"=>array("id"=>"1","name"=>"有效"),
                     "8"=>array("id"=>"8","name"=>"取消"));
    }

    function get_table_Service_status($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Service_status();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Service_status($value){
        if ($value=="") return "";
        $arr=table_Service_status();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //ServiceTask[status]  系统服务运行[状态]
    function table_ServiceTask_status(){
        return array("0"=>array("id"=>"0","name"=>"未运行"),
                     "1"=>array("id"=>"1","name"=>"已运行"));
    }

    function get_table_ServiceTask_status($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_ServiceTask_status();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_ServiceTask_status($value){
        if ($value=="") return "";
        $arr=table_ServiceTask_status();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Storecard[uom_qty]  存储卡[数量单位]
    function table_Storecard_uom_qty(){
        return array("subcode('UOM_QTY')"=>array("id"=>"subcode('UOM_QTY')","name"=>""));
    }

    function get_table_Storecard_uom_qty($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Storecard_uom_qty();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Storecard_uom_qty($value){
        if ($value=="") return "";
        $arr=table_Storecard_uom_qty();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Storecard[uom_weight]  存储卡[重量单位]
    function table_Storecard_uom_weight(){
        return array("subcode('UOM_WEIGHT')"=>array("id"=>"subcode('UOM_WEIGHT')","name"=>""));
    }

    function get_table_Storecard_uom_weight($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Storecard_uom_weight();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Storecard_uom_weight($value){
        if ($value=="") return "";
        $arr=table_Storecard_uom_weight();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Storecard[uom_bulkcargo]  存储卡[散件单位]
    function table_Storecard_uom_bulkcargo(){
        return array("subcode('UOM_BULKCARGO')"=>array("id"=>"subcode('UOM_BULKCARGO')","name"=>""));
    }

    function get_table_Storecard_uom_bulkcargo($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Storecard_uom_bulkcargo();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Storecard_uom_bulkcargo($value){
        if ($value=="") return "";
        $arr=table_Storecard_uom_bulkcargo();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Storecard[status]  存储卡[状态]
    function table_Storecard_status(){
        return array("0"=>array("id"=>"0","name"=>"无效"),
                     "1"=>array("id"=>"1","name"=>"有效"));
    }

    function get_table_Storecard_status($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Storecard_status();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Storecard_status($value){
        if ($value=="") return "";
        $arr=table_Storecard_status();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //StorecardButtress[is_lock]  存储卡垛号[是否锁住]
    function table_StorecardButtress_is_lock(){
        return array("0"=>array("id"=>"0","name"=>"否"),
                     "1"=>array("id"=>"1","name"=>"是"));
    }

    function get_table_StorecardButtress_is_lock($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_StorecardButtress_is_lock();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_StorecardButtress_is_lock($value){
        if ($value=="") return "";
        $arr=table_StorecardButtress_is_lock();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //StorecardLock[storecard_type]  存储卡加锁[存储卡类型]
    function table_StorecardLock_storecard_type(){
        return array("0"=>array("id"=>"0","name"=>"虚拟卡"),
                     "1"=>array("id"=>"1","name"=>"实物卡"));
    }

    function get_table_StorecardLock_storecard_type($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_StorecardLock_storecard_type();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_StorecardLock_storecard_type($value){
        if ($value=="") return "";
        $arr=table_StorecardLock_storecard_type();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //StorecardPackage[arrival_type]  存储卡码单[到货方式]
    function table_StorecardPackage_arrival_type(){
        return array("subcode('packlist:arrival_type')"=>array("id"=>"subcode('packlist:arrival_type')","name"=>""));
    }

    function get_table_StorecardPackage_arrival_type($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_StorecardPackage_arrival_type();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_StorecardPackage_arrival_type($value){
        if ($value=="") return "";
        $arr=table_StorecardPackage_arrival_type();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //StorecardPackage[stock_type]  存储卡码单[存储方式]
    function table_StorecardPackage_stock_type(){
        return array("subcode('packlist:stock_type')"=>array("id"=>"subcode('packlist:stock_type')","name"=>""));
    }

    function get_table_StorecardPackage_stock_type($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_StorecardPackage_stock_type();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_StorecardPackage_stock_type($value){
        if ($value=="") return "";
        $arr=table_StorecardPackage_stock_type();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //StorecardPackage[uom_qty]  存储卡码单[数量单位]
    function table_StorecardPackage_uom_qty(){
        return array("subcode('UOM_QTY')"=>array("id"=>"subcode('UOM_QTY')","name"=>""));
    }

    function get_table_StorecardPackage_uom_qty($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_StorecardPackage_uom_qty();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_StorecardPackage_uom_qty($value){
        if ($value=="") return "";
        $arr=table_StorecardPackage_uom_qty();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //StorecardPackage[uom_weight]  存储卡码单[重量单位]
    function table_StorecardPackage_uom_weight(){
        return array("subcode('UOM_WEIGHT')"=>array("id"=>"subcode('UOM_WEIGHT')","name"=>""));
    }

    function get_table_StorecardPackage_uom_weight($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_StorecardPackage_uom_weight();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_StorecardPackage_uom_weight($value){
        if ($value=="") return "";
        $arr=table_StorecardPackage_uom_weight();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //StorecardPackage[uom_bulkcargo]  存储卡码单[散件单位]
    function table_StorecardPackage_uom_bulkcargo(){
        return array("subcode('UOM_BULKCARGO')"=>array("id"=>"subcode('UOM_BULKCARGO')","name"=>""));
    }

    function get_table_StorecardPackage_uom_bulkcargo($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_StorecardPackage_uom_bulkcargo();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_StorecardPackage_uom_bulkcargo($value){
        if ($value=="") return "";
        $arr=table_StorecardPackage_uom_bulkcargo();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //StorecardPackage[status]  存储卡码单[状态]
    function table_StorecardPackage_status(){
        return array("0"=>array("id"=>"0","name"=>"待处理"),
                     "1"=>array("id"=>"1","name"=>"有效"),
                     "2"=>array("id"=>"2","name"=>"结束"),
                     "7"=>array("id"=>"7","name"=>"取消"));
    }

    function get_table_StorecardPackage_status($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_StorecardPackage_status();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_StorecardPackage_status($value){
        if ($value=="") return "";
        $arr=table_StorecardPackage_status();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //StorecardPackage[is_lock]  存储卡码单[是否锁住]
    function table_StorecardPackage_is_lock(){
        return array("0"=>array("id"=>"0","name"=>"否"),
                     "1"=>array("id"=>"1","name"=>"是"));
    }

    function get_table_StorecardPackage_is_lock($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_StorecardPackage_is_lock();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_StorecardPackage_is_lock($value){
        if ($value=="") return "";
        $arr=table_StorecardPackage_is_lock();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //StorecardVirtual[uom_qty]  虚拟存储卡[数量单位]
    function table_StorecardVirtual_uom_qty(){
        return array("subcode('UOM_QTY')"=>array("id"=>"subcode('UOM_QTY')","name"=>""));
    }

    function get_table_StorecardVirtual_uom_qty($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_StorecardVirtual_uom_qty();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_StorecardVirtual_uom_qty($value){
        if ($value=="") return "";
        $arr=table_StorecardVirtual_uom_qty();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //StorecardVirtual[uom_weight]  虚拟存储卡[重量单位]
    function table_StorecardVirtual_uom_weight(){
        return array("subcode('UOM_WEIGHT')"=>array("id"=>"subcode('UOM_WEIGHT')","name"=>""));
    }

    function get_table_StorecardVirtual_uom_weight($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_StorecardVirtual_uom_weight();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_StorecardVirtual_uom_weight($value){
        if ($value=="") return "";
        $arr=table_StorecardVirtual_uom_weight();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //StorecardVirtual[uom_bulkcargo]  虚拟存储卡[散件单位]
    function table_StorecardVirtual_uom_bulkcargo(){
        return array("subcode('UOM_BULKCARGO')"=>array("id"=>"subcode('UOM_BULKCARGO')","name"=>""));
    }

    function get_table_StorecardVirtual_uom_bulkcargo($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_StorecardVirtual_uom_bulkcargo();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_StorecardVirtual_uom_bulkcargo($value){
        if ($value=="") return "";
        $arr=table_StorecardVirtual_uom_bulkcargo();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //StorecardVirtual[add_allow]  虚拟存储卡[追加许可]
    function table_StorecardVirtual_add_allow(){
        return array("0"=>array("id"=>"0","name"=>"不允许"),
                     "1"=>array("id"=>"1","name"=>"允许"));
    }

    function get_table_StorecardVirtual_add_allow($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_StorecardVirtual_add_allow();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_StorecardVirtual_add_allow($value){
        if ($value=="") return "";
        $arr=table_StorecardVirtual_add_allow();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //StorecardVirtual[status]  虚拟存储卡[状态]
    function table_StorecardVirtual_status(){
        return array("0"=>array("id"=>"0","name"=>"无效"),
                     "1"=>array("id"=>"1","name"=>"有效"));
    }

    function get_table_StorecardVirtual_status($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_StorecardVirtual_status();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_StorecardVirtual_status($value){
        if ($value=="") return "";
        $arr=table_StorecardVirtual_status();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Subcode[is_system]  数据字典[系统定义]
    function table_Subcode_is_system(){
        return array("1"=>array("id"=>"1","name"=>"是"),
                     "0"=>array("id"=>"0","name"=>"否"));
    }

    function get_table_Subcode_is_system($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Subcode_is_system();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Subcode_is_system($value){
        if ($value=="") return "";
        $arr=table_Subcode_is_system();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Subcode[status]  数据字典[状态]
    function table_Subcode_status(){
        return array("1"=>array("id"=>"1","name"=>"有效"),
                     "0"=>array("id"=>"0","name"=>"无效"));
    }

    function get_table_Subcode_status($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Subcode_status();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Subcode_status($value){
        if ($value=="") return "";
        $arr=table_Subcode_status();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //SystemParameter[type]  系统参数[类型]
    function table_SystemParameter_type(){
        return array("trade"=>array("id"=>"trade","name"=>"交易"),
                     "panel"=>array("id"=>"panel","name"=>"平台"));
    }

    function get_table_SystemParameter_type($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_SystemParameter_type();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_SystemParameter_type($value){
        if ($value=="") return "";
        $arr=table_SystemParameter_type();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //SystemParameter[status]  系统参数[状态]
    function table_SystemParameter_status(){
        return array("1"=>array("id"=>"1","name"=>"有效"),
                     "0"=>array("id"=>"0","name"=>"无效"));
    }

    function get_table_SystemParameter_status($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_SystemParameter_status();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_SystemParameter_status($value){
        if ($value=="") return "";
        $arr=table_SystemParameter_status();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //SystemParameter[allow_edit]  系统参数[允许编辑]
    function table_SystemParameter_allow_edit(){
        return array("1"=>array("id"=>"1","name"=>"允许"),
                     "0"=>array("id"=>"0","name"=>"禁止"));
    }

    function get_table_SystemParameter_allow_edit($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_SystemParameter_allow_edit();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_SystemParameter_allow_edit($value){
        if ($value=="") return "";
        $arr=table_SystemParameter_allow_edit();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //SystemVerify[status]  系统验证码[状态]
    function table_SystemVerify_status(){
        return array("0"=>array("id"=>"0","name"=>"待发"),
                     "1"=>array("id"=>"1","name"=>"发送"),
                     "2"=>array("id"=>"2","name"=>"过期"),
                     "3"=>array("id"=>"3","name"=>"使用"));
    }

    function get_table_SystemVerify_status($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_SystemVerify_status();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_SystemVerify_status($value){
        if ($value=="") return "";
        $arr=table_SystemVerify_status();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Trade[warehouse_code]  交易开单[仓库编码]
    function table_Trade_warehouse_code(){
        return array("warehouse"=>array("id"=>"warehouse","name"=>""));
    }

    function get_table_Trade_warehouse_code($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Trade_warehouse_code();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Trade_warehouse_code($value){
        if ($value=="") return "";
        $arr=table_Trade_warehouse_code();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Trade[tx_type]  交易开单[交易类型]
    function table_Trade_tx_type(){
        return array("0"=>array("id"=>"0","name"=>"过户"),
                     "1"=>array("id"=>"1","name"=>"提货"));
    }

    function get_table_Trade_tx_type($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Trade_tx_type();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Trade_tx_type($value){
        if ($value=="") return "";
        $arr=table_Trade_tx_type();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Trade[is_real]  交易开单[是否实物]
    function table_Trade_is_real(){
        return array("0"=>array("id"=>"0","name"=>"否"),
                     "1"=>array("id"=>"1","name"=>"是"));
    }

    function get_table_Trade_is_real($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Trade_is_real();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Trade_is_real($value){
        if ($value=="") return "";
        $arr=table_Trade_is_real();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Trade[uom_weight]  交易开单[重量单位]
    function table_Trade_uom_weight(){
        return array("subcode('UOM_WEIGHT')"=>array("id"=>"subcode('UOM_WEIGHT')","name"=>""));
    }

    function get_table_Trade_uom_weight($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Trade_uom_weight();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Trade_uom_weight($value){
        if ($value=="") return "";
        $arr=table_Trade_uom_weight();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Trade[uom_qty]  交易开单[数量单位]
    function table_Trade_uom_qty(){
        return array("subcode('UOM_QTY')"=>array("id"=>"subcode('UOM_QTY')","name"=>""));
    }

    function get_table_Trade_uom_qty($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Trade_uom_qty();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Trade_uom_qty($value){
        if ($value=="") return "";
        $arr=table_Trade_uom_qty();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Trade[cust_confirm_status]  交易开单[卖家确认]
    function table_Trade_cust_confirm_status(){
        return array("0"=>array("id"=>"0","name"=>"否"),
                     "1"=>array("id"=>"1","name"=>"是"));
    }

    function get_table_Trade_cust_confirm_status($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Trade_cust_confirm_status();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Trade_cust_confirm_status($value){
        if ($value=="") return "";
        $arr=table_Trade_cust_confirm_status();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Trade[buyer_confirm_status]  交易开单[买家确认]
    function table_Trade_buyer_confirm_status(){
        return array("0"=>array("id"=>"0","name"=>"否"),
                     "1"=>array("id"=>"1","name"=>"是"));
    }

    function get_table_Trade_buyer_confirm_status($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Trade_buyer_confirm_status();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Trade_buyer_confirm_status($value){
        if ($value=="") return "";
        $arr=table_Trade_buyer_confirm_status();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Trade[cust_send_type]  交易开单[卖家发送]
    function table_Trade_cust_send_type(){
        return array("0"=>array("id"=>"0","name"=>"否"),
                     "1"=>array("id"=>"1","name"=>"是"));
    }

    function get_table_Trade_cust_send_type($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Trade_cust_send_type();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Trade_cust_send_type($value){
        if ($value=="") return "";
        $arr=table_Trade_cust_send_type();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Trade[storefee_bears]  交易开单[仓储费承担]
    function table_Trade_storefee_bears(){
        return array("0"=>array("id"=>"0","name"=>"买家"),
                     "1"=>array("id"=>"1","name"=>"卖家"));
    }

    function get_table_Trade_storefee_bears($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Trade_storefee_bears();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Trade_storefee_bears($value){
        if ($value=="") return "";
        $arr=table_Trade_storefee_bears();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Trade[payment_require]  交易开单[付款截至类型]
    function table_Trade_payment_require(){
        return array("30"=>array("id"=>"30","name"=>"半小时"),
                     "60"=>array("id"=>"60","name"=>"一小时"),
                     "120"=>array("id"=>"120","name"=>"二小时"),
                     "180"=>array("id"=>"180","name"=>"三小时"),
                     "360"=>array("id"=>"360","name"=>"六小时"),
                     "1440"=>array("id"=>"1440","name"=>"一天"));
    }

    function get_table_Trade_payment_require($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Trade_payment_require();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Trade_payment_require($value){
        if ($value=="") return "";
        $arr=table_Trade_payment_require();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Trade[confirm_status]  交易开单[收付款登记]
    function table_Trade_confirm_status(){
        return array("0"=>array("id"=>"0","name"=>"不需要"),
                     "1"=>array("id"=>"1","name"=>"买家付款登记"),
                     "2"=>array("id"=>"2","name"=>"卖家收款登记"),
                     "3"=>array("id"=>"3","name"=>"双方登记"));
    }

    function get_table_Trade_confirm_status($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Trade_confirm_status();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Trade_confirm_status($value){
        if ($value=="") return "";
        $arr=table_Trade_confirm_status();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Trade[delivery_type]  交易开单[发货方式]
    function table_Trade_delivery_type(){
        return array("0"=>array("id"=>"0","name"=>"无"),
                     "1"=>array("id"=>"1","name"=>"不超发"),
                     "2"=>array("id"=>"2","name"=>"不少发"),
                     "3"=>array("id"=>"3","name"=>"留一件"),
                     "4"=>array("id"=>"4","name"=>"清卡"),
                     "5"=>array("id"=>"5","name"=>"其他要求"));
    }

    function get_table_Trade_delivery_type($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Trade_delivery_type();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Trade_delivery_type($value){
        if ($value=="") return "";
        $arr=table_Trade_delivery_type();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Trade[assign_status]  交易开单[配货标志]
    function table_Trade_assign_status(){
        return array("0"=>array("id"=>"0","name"=>"否"),
                     "1"=>array("id"=>"1","name"=>"配货中"),
                     "2"=>array("id"=>"2","name"=>"完成"));
    }

    function get_table_Trade_assign_status($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Trade_assign_status();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Trade_assign_status($value){
        if ($value=="") return "";
        $arr=table_Trade_assign_status();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Trade[buyer_storecard_allow]  交易开单[追加许可]
    function table_Trade_buyer_storecard_allow(){
        return array("0"=>array("id"=>"0","name"=>"不允许"),
                     "1"=>array("id"=>"1","name"=>"允许"));
    }

    function get_table_Trade_buyer_storecard_allow($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Trade_buyer_storecard_allow();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Trade_buyer_storecard_allow($value){
        if ($value=="") return "";
        $arr=table_Trade_buyer_storecard_allow();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Trade[interface_status]  交易开单[接口状态]
    function table_Trade_interface_status(){
        return array("0"=>array("id"=>"0","name"=>"无"),
                     "1"=>array("id"=>"1","name"=>"待发送"),
                     "2"=>array("id"=>"2","name"=>"已发送"),
                     "3"=>array("id"=>"3","name"=>"已返回"));
    }

    function get_table_Trade_interface_status($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Trade_interface_status();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Trade_interface_status($value){
        if ($value=="") return "";
        $arr=table_Trade_interface_status();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Trade[interface_send_status]  交易开单[接口处理]
    function table_Trade_interface_send_status(){
        return array("0"=>array("id"=>"0","name"=>"无"),
                     "1"=>array("id"=>"1","name"=>"失败"),
                     "2"=>array("id"=>"2","name"=>"成功"));
    }

    function get_table_Trade_interface_send_status($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Trade_interface_send_status();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Trade_interface_send_status($value){
        if ($value=="") return "";
        $arr=table_Trade_interface_send_status();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Trade[status]  交易开单[状态]
    function table_Trade_status(){
        return array("0"=>array("id"=>"0","name"=>"待卖家确认"),
                     "1"=>array("id"=>"1","name"=>"待买家确认"),
                     "2"=>array("id"=>"2","name"=>"配货付款中"),
                     "3"=>array("id"=>"3","name"=>"待接口处理"),
                     "4"=>array("id"=>"4","name"=>"仓库处理中"),
                     "5"=>array("id"=>"5","name"=>"待款项补差"),
                     "6"=>array("id"=>"6","name"=>"交易完成"),
                     "7"=>array("id"=>"7","name"=>"已取消"),
                     "8"=>array("id"=>"8","name"=>"已失效"));
    }

    function get_table_Trade_status($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Trade_status();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Trade_status($value){
        if ($value=="") return "";
        $arr=table_Trade_status();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //TradeAssign[storecard_type]  交易配货[存储卡类型]
    function table_TradeAssign_storecard_type(){
        return array("0"=>array("id"=>"0","name"=>"虚拟卡"),
                     "1"=>array("id"=>"1","name"=>"实物卡"));
    }

    function get_table_TradeAssign_storecard_type($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_TradeAssign_storecard_type();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_TradeAssign_storecard_type($value){
        if ($value=="") return "";
        $arr=table_TradeAssign_storecard_type();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //TradeAssign[status]  交易配货[状态]
    function table_TradeAssign_status(){
        return array("0"=>array("id"=>"0","name"=>"否"),
                     "1"=>array("id"=>"1","name"=>"库存锁定"),
                     "2"=>array("id"=>"2","name"=>"释放扣除"));
    }

    function get_table_TradeAssign_status($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_TradeAssign_status();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_TradeAssign_status($value){
        if ($value=="") return "";
        $arr=table_TradeAssign_status();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //TradeAssignButtress[status]  交易配货垛号[状态]
    function table_TradeAssignButtress_status(){
        return array("0"=>array("id"=>"0","name"=>"否"),
                     "1"=>array("id"=>"1","name"=>"库存锁定"),
                     "2"=>array("id"=>"2","name"=>"释放扣除"));
    }

    function get_table_TradeAssignButtress_status($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_TradeAssignButtress_status();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_TradeAssignButtress_status($value){
        if ($value=="") return "";
        $arr=table_TradeAssignButtress_status();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Transfer[uom_qty]  过户[数量单位]
    function table_Transfer_uom_qty(){
        return array("subcode('UOM_QTY')"=>array("id"=>"subcode('UOM_QTY')","name"=>""));
    }

    function get_table_Transfer_uom_qty($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Transfer_uom_qty();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Transfer_uom_qty($value){
        if ($value=="") return "";
        $arr=table_Transfer_uom_qty();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Transfer[uom_weight]  过户[重量单位]
    function table_Transfer_uom_weight(){
        return array("subcode('UOM_WEIGHT')"=>array("id"=>"subcode('UOM_WEIGHT')","name"=>""));
    }

    function get_table_Transfer_uom_weight($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Transfer_uom_weight();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Transfer_uom_weight($value){
        if ($value=="") return "";
        $arr=table_Transfer_uom_weight();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Transfer[uom_bulkcargo]  过户[散件单位]
    function table_Transfer_uom_bulkcargo(){
        return array("subcode('UOM_BULKCARGO')"=>array("id"=>"subcode('UOM_BULKCARGO')","name"=>""));
    }

    function get_table_Transfer_uom_bulkcargo($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Transfer_uom_bulkcargo();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Transfer_uom_bulkcargo($value){
        if ($value=="") return "";
        $arr=table_Transfer_uom_bulkcargo();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Transfer[status]  过户[状态]
    function table_Transfer_status(){
        return array("0"=>array("id"=>"0","name"=>"草稿"),
                     "1"=>array("id"=>"1","name"=>"有效"),
                     "2"=>array("id"=>"2","name"=>"结束"),
                     "7"=>array("id"=>"7","name"=>"取消"),
                     "8"=>array("id"=>"8","name"=>"失效"));
    }

    function get_table_Transfer_status($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Transfer_status();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Transfer_status($value){
        if ($value=="") return "";
        $arr=table_Transfer_status();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Transfer[isself]  过户[过给自己]
    function table_Transfer_isself(){
        return array("0"=>array("id"=>"0","name"=>"否"),
                     "1"=>array("id"=>"1","name"=>"是"));
    }

    function get_table_Transfer_isself($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Transfer_isself();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Transfer_isself($value){
        if ($value=="") return "";
        $arr=table_Transfer_isself();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //User[side]  用户信息[类型]
    function table_User_side(){
        return array("1"=>array("id"=>"1","name"=>"平台"),
                     "2"=>array("id"=>"2","name"=>"机构"),
                     "3"=>array("id"=>"3","name"=>"客户"));
    }

    function get_table_User_side($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_User_side();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_User_side($value){
        if ($value=="") return "";
        $arr=table_User_side();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //User[status]  用户信息[状态]
    function table_User_status(){
        return array("1"=>array("id"=>"1","name"=>"有效"),
                     "0"=>array("id"=>"0","name"=>"无效"));
    }

    function get_table_User_status($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_User_status();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_User_status($value){
        if ($value=="") return "";
        $arr=table_User_status();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //User[sex]  用户信息[性别]
    function table_User_sex(){
        return array("1"=>array("id"=>"1","name"=>"男"),
                     "0"=>array("id"=>"0","name"=>"女"),
                     "2"=>array("id"=>"2","name"=>"保密"));
    }

    function get_table_User_sex($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_User_sex();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_User_sex($value){
        if ($value=="") return "";
        $arr=table_User_sex();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //User[level]  用户信息[级别]
    function table_User_level(){
        return array("0"=>array("id"=>"0","name"=>"输入"),
                     "1"=>array("id"=>"1","name"=>"审核"));
    }

    function get_table_User_level($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_User_level();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_User_level($value){
        if ($value=="") return "";
        $arr=table_User_level();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //User[superadmin]  用户信息[是否管理员]
    function table_User_superadmin(){
        return array("0"=>array("id"=>"0","name"=>"否"),
                     "1"=>array("id"=>"1","name"=>"是"));
    }

    function get_table_User_superadmin($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_User_superadmin();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_User_superadmin($value){
        if ($value=="") return "";
        $arr=table_User_superadmin();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }

    //Warehouse[status]  仓库信息[状态]
    function table_Warehouse_status(){
        return array("0"=>array("id"=>"0","name"=>"无效"),
                     "1"=>array("id"=>"1","name"=>"有效"));
    }

    function get_table_Warehouse_status($key, $name="", $emptykey=""){
        if ($key=="" || $key!="" && $key==$emptykey) return "";
        $arr=table_Warehouse_status();
        if(isset($arr[$key])) {
            if($name=="") $name="name";
            if(isset($arr[$key][$name]))
                return $arr[$key][$name];
        }
        return "? $key";
    }

    function code_table_Warehouse_status($value){
        if ($value=="") return "";
        $arr=table_Warehouse_status();
        foreach($arr as $key=>$item){
            if ($value==$item["name"])
                return $key;
        }
        return "";
    }


?>