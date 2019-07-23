<?php
    //Area 国家地区
    function exist_table_Area($code){
         $sql="SELECT * FROM @area WHERE code='$code' LIMIT 1";
         $data = M()->query(table($sql));
         if (empty($data))
             return false;
         return $data[0];
     }


    //Customer 客户资料
    function exist_table_Customer($code){
         $sql="SELECT * FROM @customer WHERE code='$code' LIMIT 1";
         $data = M()->query(table($sql));
         if (empty($data))
             return false;
         return $data[0];
     }


    //CustomerApply 客户申请信息
    function exist_table_CustomerApply($code){
         $sql="SELECT * FROM @customer_apply WHERE code='$code' LIMIT 1";
         $data = M()->query(table($sql));
         if (empty($data))
             return false;
         return $data[0];
     }


    //CustomerCategory 客户分类
    function exist_table_CustomerCategory($code){
         $sql="SELECT * FROM @customer_category WHERE code='$code' LIMIT 1";
         $data = M()->query(table($sql));
         if (empty($data))
             return false;
         return $data[0];
     }


    //CustomerDelivery 客户提货信息
    function exist_table_CustomerDelivery($code){
         $sql="SELECT * FROM @customer_delivery WHERE code='$code' LIMIT 1";
         $data = M()->query(table($sql));
         if (empty($data))
             return false;
         return $data[0];
     }


    //CustomerRela 客户关联关系
    function exist_table_CustomerRela($code){
         $sql="SELECT * FROM @customer_rela WHERE code='$code' LIMIT 1";
         $data = M()->query(table($sql));
         if (empty($data))
             return false;
         return $data[0];
     }


    //Department 部门信息
    function exist_table_Department($code){
         $sql="SELECT * FROM @department WHERE code='$code' LIMIT 1";
         $data = M()->query(table($sql));
         if (empty($data))
             return false;
         return $data[0];
     }


    //Goods 货品信息
    function exist_table_Goods($goods_no){
         $sql="SELECT * FROM @goods WHERE goods_no='$goods_no' LIMIT 1";
         $data = M()->query(table($sql));
         if (empty($data))
             return false;
         return $data[0];
     }


    //GoodsCategory 货品分类
    function exist_table_GoodsCategory($code){
         $sql="SELECT * FROM @goods_category WHERE code='$code' LIMIT 1";
         $data = M()->query(table($sql));
         if (empty($data))
             return false;
         return $data[0];
     }


    //Interface 系统接口参数
    function exist_table_Interface($code){
         $sql="SELECT * FROM @interface WHERE code='$code' LIMIT 1";
         $data = M()->query(table($sql));
         if (empty($data))
             return false;
         return $data[0];
     }


    //MessageTemplet 消息模板
    function exist_table_MessageTemplet($code){
         $sql="SELECT * FROM @message_templet WHERE code='$code' LIMIT 1";
         $data = M()->query(table($sql));
         if (empty($data))
             return false;
         return $data[0];
     }


    //Org 库联联盟机构
    function exist_table_Org($code){
         $sql="SELECT * FROM @org WHERE code='$code' LIMIT 1";
         $data = M()->query(table($sql));
         if (empty($data))
             return false;
         return $data[0];
     }


    //Subcode 数据字典
    function exist_table_Subcode($code){
         $sql="SELECT * FROM @subcode WHERE code='$code' LIMIT 1";
         $data = M()->query(table($sql));
         if (empty($data))
             return false;
         return $data[0];
     }


    //SystemParameter 系统参数
    function exist_table_SystemParameter($code){
         $sql="SELECT * FROM @system_parameter WHERE code='$code' LIMIT 1";
         $data = M()->query(table($sql));
         if (empty($data))
             return false;
         return $data[0];
     }


    //User 用户信息
    function exist_table_User($username){
         $sql="SELECT * FROM @user WHERE username='$username' LIMIT 1";
         $data = M()->query(table($sql));
         if (empty($data))
             return false;
         return $data[0];
     }


    //Warehouse 仓库信息
    function exist_table_Warehouse($code){
         $sql="SELECT * FROM @warehouse WHERE code='$code' LIMIT 1";
         $data = M()->query(table($sql));
         if (empty($data))
             return false;
         return $data[0];
     }



?>