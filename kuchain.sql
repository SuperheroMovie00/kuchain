/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50719
Source Host           : localhost:3306
Source Database       : kuchain

Target Server Type    : MYSQL
Target Server Version : 50719
File Encoding         : 65001

Date: 2019-06-05 13:51:54
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for erp_area
-- ----------------------------
DROP TABLE IF EXISTS `erp_area`;
CREATE TABLE `erp_area` (
  `id` varchar(20) NOT NULL COMMENT '地区id',
  `parent_id` varchar(20) DEFAULT '''' COMMENT '上一级id',
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '类型:0;国家#1;省市#2;地区#3;县市#4;区域#5;街道',
  `code` varchar(30) DEFAULT NULL COMMENT '地区代码',
  `name` varchar(100) DEFAULT NULL COMMENT '地区名称',
  `sort` int(11) DEFAULT '9999' COMMENT '排序',
  `status` varchar(30) DEFAULT NULL COMMENT '状态:1;有效#0;无效',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `create_user` varchar(30) DEFAULT NULL COMMENT '创建人员',
  `modify_time` datetime DEFAULT NULL COMMENT '修改时间',
  `modify_user` varchar(30) DEFAULT NULL COMMENT '修改人员',
  `lastchanged` timestamp(6) NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6) COMMENT '更改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='国家地区';

-- ----------------------------
-- Records of erp_area
-- ----------------------------

-- ----------------------------
-- Table structure for erp_chain
-- ----------------------------
DROP TABLE IF EXISTS `erp_chain`;
CREATE TABLE `erp_chain` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `org_id` int(11) DEFAULT NULL COMMENT '库链id',
  `customer_id` int(11) DEFAULT NULL COMMENT '客户id',
  `customer_name` varchar(100) DEFAULT NULL COMMENT '客户名称',
  `chain_no` varchar(50) DEFAULT NULL COMMENT '交易链号',
  `subject` varchar(100) DEFAULT NULL COMMENT '交易标题',
  `goods_id` int(11) DEFAULT NULL COMMENT '货品ID',
  `goods_no` varchar(50) DEFAULT NULL COMMENT '货品编码',
  `goods_name` varchar(100) DEFAULT NULL COMMENT '货品名称',
  `style_info` varchar(100) DEFAULT NULL COMMENT '规格材质',
  `brand` varchar(50) DEFAULT NULL COMMENT '注册商标',
  `producing_area` varchar(50) DEFAULT NULL COMMENT '货品产地',
  `style_code` varchar(50) DEFAULT NULL COMMENT '规格编码',
  `weight` decimal(18,6) DEFAULT '0.000000' COMMENT '重量',
  `uom_weight` varchar(30) DEFAULT NULL COMMENT '重量单位',
  `detail` int(11) DEFAULT '0' COMMENT '明细',
  `interface_status` tinyint(11) NOT NULL DEFAULT '0' COMMENT '仓库接口:0;无#1;等待发送仓库#2;已发送仓库#3;仓库处理返回',
  `interface_process` tinyint(11) NOT NULL DEFAULT '0' COMMENT '接口处理:0;无#1;失败#2;成功',
  `interface_time` datetime DEFAULT NULL COMMENT '接口时间',
  `interface_result` text COMMENT '接口信息',
  `remarks` text COMMENT '备注',
  `status` varchar(30) DEFAULT NULL COMMENT '状态:0;草稿#1;待处理#2;结束#7;取消#8;失效',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_chainno` (`chain_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='交易链';

-- ----------------------------
-- Records of erp_chain
-- ----------------------------

-- ----------------------------
-- Table structure for erp_chain_detail
-- ----------------------------
DROP TABLE IF EXISTS `erp_chain_detail`;
CREATE TABLE `erp_chain_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `org_id` int(11) DEFAULT NULL COMMENT '库链id',
  `chain_id` int(11) DEFAULT NULL COMMENT '交易链id',
  `trade_id` int(11) DEFAULT NULL COMMENT '交易id',
  `interface_process` tinyint(11) NOT NULL DEFAULT '0' COMMENT '接口处理:0;无#1;失败#2;成功',
  `interface_time` datetime DEFAULT NULL COMMENT '接口时间',
  `interface_result` text COMMENT '接口信息',
  PRIMARY KEY (`id`),
  KEY `idx_chainid` (`chain_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='交易链明细';

-- ----------------------------
-- Records of erp_chain_detail
-- ----------------------------

-- ----------------------------
-- Table structure for erp_customer
-- ----------------------------
DROP TABLE IF EXISTS `erp_customer`;
CREATE TABLE `erp_customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '客户类型:1;客户#0',
  `parent_id` int(11) DEFAULT '0' COMMENT '上级ID',
  `code` varchar(30) DEFAULT NULL COMMENT '客户代码',
  `name` varchar(100) DEFAULT NULL COMMENT '客户简称',
  `full_name` varchar(100) DEFAULT NULL COMMENT '客户全称',
  `prefix` varchar(30) DEFAULT NULL COMMENT '助记码',
  `category_code` varchar(30) DEFAULT NULL COMMENT '客户分类',
  `industry_code` varchar(30) DEFAULT NULL COMMENT '行业分类',
  `province` varchar(50) DEFAULT NULL COMMENT '省份',
  `city` varchar(50) DEFAULT NULL COMMENT '城市',
  `area` varchar(50) DEFAULT NULL COMMENT '县区',
  `address` varchar(200) DEFAULT NULL COMMENT '联系地址',
  `postcode` varchar(50) DEFAULT NULL COMMENT '邮政编码',
  `phone` varchar(50) DEFAULT NULL COMMENT '联系电话',
  `mobile` varchar(50) DEFAULT NULL COMMENT '联系手机',
  `linkman` varchar(50) DEFAULT NULL COMMENT '联系人员',
  `invoice_company` varchar(200) DEFAULT NULL COMMENT '开票名称',
  `invoice_address` varchar(100) DEFAULT NULL COMMENT '开票地址',
  `invoice_phone` varchar(50) DEFAULT NULL COMMENT '开票电话',
  `invoice_bank` varchar(100) DEFAULT NULL COMMENT '开票银行',
  `invoice_taxno` varchar(50) DEFAULT NULL COMMENT '开票税号',
  `invoice_account` varchar(50) DEFAULT NULL COMMENT '开票账户',
  `CorpBusiCode` varchar(30) DEFAULT NULL COMMENT '营业执照号',
  `CorpTaxCode` varchar(30) DEFAULT NULL COMMENT '税务登记证',
  `LegalPerName` varchar(20) DEFAULT NULL COMMENT '法人姓名',
  `LegalPerIdType` varchar(20) DEFAULT NULL COMMENT '法人证件类型',
  `LegalPerIdNo` varchar(50) DEFAULT NULL COMMENT '法人证件号码',
  `ContactName` varchar(20) DEFAULT NULL COMMENT '联系人姓名',
  `ContactIdType` varchar(20) DEFAULT NULL COMMENT '联系人证件类型',
  `ContactIdNo` varchar(20) DEFAULT NULL COMMENT '联系人证件号码',
  `ContactMobile` varchar(20) DEFAULT NULL COMMENT '联系人手机',
  `OpenBank` varchar(50) DEFAULT NULL COMMENT '开户银行',
  `OpenAcctNo` varchar(30) DEFAULT NULL COMMENT '开户账户号',
  `OpenAcctName` varchar(100) DEFAULT NULL COMMENT '开户账户名',
  `chinapay_userid` varchar(30) DEFAULT NULL COMMENT '银联账户号',
  `remarks` text COMMENT '备注',
  `customer_level` tinyint(4) NOT NULL DEFAULT '0' COMMENT '层级:0;未分#1;1级#2;2级#3;3级#4;4级#5;5级#6;6级',
  `status` varchar(30) DEFAULT NULL COMMENT '状态:0;无效#1;有效',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `create_user` varchar(30) DEFAULT NULL COMMENT '创建人员',
  `modify_time` datetime DEFAULT NULL COMMENT '修改时间',
  `modify_user` varchar(30) DEFAULT NULL COMMENT '修改人员',
  `lastchanged` timestamp(6) NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6) COMMENT '更改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='客户资料';

-- ----------------------------
-- Records of erp_customer
-- ----------------------------
INSERT INTO `erp_customer` VALUES ('1', '0', '0', 'bc', 'bdsds', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '1', null, null, null, null, '2019-06-04 21:39:04.393470');

-- ----------------------------
-- Table structure for erp_customer_address
-- ----------------------------
DROP TABLE IF EXISTS `erp_customer_address`;
CREATE TABLE `erp_customer_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL COMMENT '客户id',
  `address` varchar(200) DEFAULT NULL COMMENT '联系地址',
  `postcode` varchar(50) DEFAULT NULL COMMENT '邮政编码',
  `phone` varchar(50) DEFAULT NULL COMMENT '联系电话',
  `mobile` varchar(50) DEFAULT NULL COMMENT '联系手机',
  `linkman` varchar(50) DEFAULT NULL COMMENT '联系人员',
  `status` varchar(30) DEFAULT NULL COMMENT '状态:0;无效#1;有效',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_customerid` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='客户地址';

-- ----------------------------
-- Records of erp_customer_address
-- ----------------------------

-- ----------------------------
-- Table structure for erp_customer_category
-- ----------------------------
DROP TABLE IF EXISTS `erp_customer_category`;
CREATE TABLE `erp_customer_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '客户类型:1;供应商#0;销售客户',
  `code` varchar(30) DEFAULT NULL COMMENT '分类代码',
  `name` varchar(150) DEFAULT NULL COMMENT '分类名称',
  `description` varchar(255) DEFAULT NULL COMMENT '描述',
  `parent_id` int(11) DEFAULT '0' COMMENT '上级分类id',
  `level` tinyint(4) NOT NULL DEFAULT '0' COMMENT '层级',
  `sort` smallint(8) DEFAULT '0' COMMENT '排序',
  `status` varchar(30) DEFAULT NULL COMMENT '状态:1;有效#0;无效',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `create_user` varchar(30) DEFAULT NULL COMMENT '创建人员',
  `modify_time` datetime DEFAULT NULL COMMENT '修改时间',
  `modify_user` varchar(30) DEFAULT NULL COMMENT '修改人员',
  `lastchanged` timestamp(6) NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6) COMMENT '更改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_code` (`code`),
  KEY `idx_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='客户分类';

-- ----------------------------
-- Records of erp_customer_category
-- ----------------------------

-- ----------------------------
-- Table structure for erp_customer_contact
-- ----------------------------
DROP TABLE IF EXISTS `erp_customer_contact`;
CREATE TABLE `erp_customer_contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `org_id` int(11) DEFAULT NULL COMMENT '库链id',
  `customer_id` int(11) DEFAULT NULL COMMENT '客户id',
  `contact_no` varchar(50) DEFAULT NULL COMMENT '合同号码',
  `contact_expire` datetime DEFAULT NULL COMMENT '合同到期',
  `warehouse_info` text COMMENT '适用仓库',
  `fee_info` text COMMENT '费率说明',
  `status` varchar(30) DEFAULT NULL COMMENT '状态:0;无效#1;有效#2;过期',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `create_user` varchar(30) DEFAULT NULL COMMENT '创建人员',
  `modify_time` datetime DEFAULT NULL COMMENT '修改时间',
  `modify_user` varchar(30) DEFAULT NULL COMMENT '修改人员',
  `lastchanged` timestamp(6) NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6) COMMENT '更改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_orgid_customerid` (`org_id`,`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='客户存储合同';

-- ----------------------------
-- Records of erp_customer_contact
-- ----------------------------

-- ----------------------------
-- Table structure for erp_customer_user
-- ----------------------------
DROP TABLE IF EXISTS `erp_customer_user`;
CREATE TABLE `erp_customer_user` (
  `customer_id` int(11) NOT NULL COMMENT '客户id',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '类型:0;管理#1;业务',
  PRIMARY KEY (`customer_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='客户/用户对应关系';

-- ----------------------------
-- Records of erp_customer_user
-- ----------------------------

-- ----------------------------
-- Table structure for erp_delivery
-- ----------------------------
DROP TABLE IF EXISTS `erp_delivery`;
CREATE TABLE `erp_delivery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `org_id` int(11) DEFAULT NULL COMMENT '库链id',
  `customer_id` int(11) DEFAULT NULL COMMENT '客户id',
  `customer_name` varchar(100) DEFAULT NULL COMMENT '客户名称',
  `tx_date` datetime DEFAULT NULL COMMENT '开单日期',
  `delivery_no` varchar(50) DEFAULT NULL COMMENT '提货单号',
  `delivery_date` datetime DEFAULT NULL COMMENT '提单日期',
  `warehouse_code` varchar(30) DEFAULT NULL COMMENT '仓库编码',
  `goods_id` int(11) DEFAULT NULL COMMENT '货品ID',
  `goods_no` varchar(50) DEFAULT NULL COMMENT '货品编码',
  `goods_name` varchar(100) DEFAULT NULL COMMENT '货品名称',
  `style_info` varchar(100) DEFAULT NULL COMMENT '规格材质',
  `brand` varchar(50) DEFAULT NULL COMMENT '注册商标',
  `producing_area` varchar(50) DEFAULT NULL COMMENT '货品产地',
  `batchno` varchar(50) DEFAULT NULL COMMENT '货品批号',
  `style_code` varchar(50) DEFAULT NULL COMMENT '规格编码',
  `storecard_id` int(11) DEFAULT NULL COMMENT '存储卡id',
  `storecard_no` varchar(50) DEFAULT NULL COMMENT '存储卡号',
  `weight` decimal(18,6) DEFAULT '0.000000' COMMENT '重量',
  `qty` decimal(18,6) DEFAULT '0.000000' COMMENT '数量',
  `bulkcargo` decimal(18,6) DEFAULT '0.000000' COMMENT '散件',
  `uom_qty` varchar(30) DEFAULT NULL COMMENT '数量单位',
  `uom_weight` varchar(30) DEFAULT NULL COMMENT '重量单位',
  `uom_bulkcargo` varchar(30) DEFAULT NULL COMMENT '散件单位',
  `to_customer_id` int(11) DEFAULT NULL COMMENT '客户id',
  `to_customer_code` varchar(30) DEFAULT NULL COMMENT '客户编码',
  `to_customer_name` varchar(100) DEFAULT NULL COMMENT '客户名称',
  `delivery_carno` varchar(50) DEFAULT NULL COMMENT '提货车号',
  `delivery_contact` varchar(50) DEFAULT NULL COMMENT '提货人员',
  `delivery_phone` varchar(50) DEFAULT NULL COMMENT '提货电话',
  `delivery_idcard` varchar(50) DEFAULT NULL COMMENT '提货身份证',
  `remarks` text COMMENT '备注',
  `is_whole` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否整卡:1;是#0;否',
  `expired_time` datetime DEFAULT NULL COMMENT '截至时间',
  `is_expired` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否过期:1;是#0;否',
  `bills_confirm` tinyint(4) NOT NULL DEFAULT '0' COMMENT '款项确认:0;未#1;付款#2;收款',
  `payment_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '付款类型:0;现金#1;电子转账#2;支票#2;支票',
  `payment_customer_id` int(11) DEFAULT NULL COMMENT '付款客户id',
  `payment_customer` varchar(100) DEFAULT NULL COMMENT '付款客户',
  `payment_info` text COMMENT '付款内容',
  `payment_path` varchar(200) DEFAULT NULL COMMENT '付款图像',
  `vcode` varchar(30) DEFAULT NULL COMMENT 'vcode',
  `transfer_fee` decimal(18,2) DEFAULT '0.00' COMMENT '过户费',
  `op` varchar(30) DEFAULT NULL COMMENT 'op',
  `original_status` int(11) DEFAULT '0' COMMENT '原始状态',
  `stock_weight` decimal(18,6) DEFAULT '0.000000' COMMENT '实发重量',
  `status` varchar(30) DEFAULT NULL COMMENT '状态:0;草稿#1;有效#2;结束#7;取消#8;失效',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_deliveryno` (`delivery_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='提单';

-- ----------------------------
-- Records of erp_delivery
-- ----------------------------

-- ----------------------------
-- Table structure for erp_delivery_packbutt
-- ----------------------------
DROP TABLE IF EXISTS `erp_delivery_packbutt`;
CREATE TABLE `erp_delivery_packbutt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `org_id` int(11) DEFAULT NULL COMMENT '库链id',
  `customer_id` int(11) DEFAULT NULL COMMENT '客户id',
  `delivery_id` int(11) DEFAULT NULL COMMENT '提单id',
  `delivery_no` varchar(50) DEFAULT NULL COMMENT '提货单号',
  `storecard_id` int(11) DEFAULT NULL COMMENT '存储卡id',
  `storecard_no` varchar(50) DEFAULT NULL COMMENT '存储卡号',
  `warehouse_code` varchar(30) DEFAULT NULL COMMENT '仓库编码',
  `location_code` varchar(30) DEFAULT NULL COMMENT '仓库仓位',
  `package_id` int(11) DEFAULT NULL COMMENT '码单id',
  `buttress_id` int(11) DEFAULT NULL COMMENT '垛号id',
  `package_no` varchar(50) DEFAULT NULL COMMENT '码单号',
  `buttress_no` varchar(30) DEFAULT NULL COMMENT '垛号',
  `weight` decimal(18,6) DEFAULT '0.000000' COMMENT '重量',
  `qty` decimal(18,6) DEFAULT '0.000000' COMMENT '数量',
  `bulkcargo` decimal(18,6) DEFAULT '0.000000' COMMENT '散件',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='提单码单';

-- ----------------------------
-- Records of erp_delivery_packbutt
-- ----------------------------

-- ----------------------------
-- Table structure for erp_delivery_storecard
-- ----------------------------
DROP TABLE IF EXISTS `erp_delivery_storecard`;
CREATE TABLE `erp_delivery_storecard` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `org_id` int(11) DEFAULT NULL COMMENT '库链id',
  `customer_id` int(11) DEFAULT NULL COMMENT '客户id',
  `delivery_id` int(11) DEFAULT NULL COMMENT '提单id',
  `delivery_no` varchar(50) DEFAULT NULL COMMENT '提货单号',
  `warehouse_code` varchar(30) DEFAULT NULL COMMENT '仓库编码',
  `storecard_id` int(11) DEFAULT NULL COMMENT '存储卡id',
  `storecard_no` varchar(50) DEFAULT NULL COMMENT '存储卡号',
  `weight` decimal(18,6) DEFAULT '0.000000' COMMENT '重量',
  `qty` decimal(18,6) DEFAULT '0.000000' COMMENT '数量',
  `bulkcargo` decimal(18,6) DEFAULT '0.000000' COMMENT '散件',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='提单存储卡';

-- ----------------------------
-- Records of erp_delivery_storecard
-- ----------------------------

-- ----------------------------
-- Table structure for erp_department
-- ----------------------------
DROP TABLE IF EXISTS `erp_department`;
CREATE TABLE `erp_department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(30) DEFAULT NULL COMMENT '代码',
  `name` varchar(100) DEFAULT NULL COMMENT '名称',
  `parent_id` int(11) DEFAULT '0' COMMENT '上级id',
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '类型:0;管理#1;财务#2;生产#3;仓储',
  `level` tinyint(4) NOT NULL DEFAULT '0' COMMENT '层级',
  `sort` int(11) DEFAULT '9999' COMMENT '排序',
  `status` varchar(30) DEFAULT NULL COMMENT '状态:1;有效#0;无效',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `create_user` varchar(30) DEFAULT NULL COMMENT '创建人员',
  `modify_time` datetime DEFAULT NULL COMMENT '修改时间',
  `modify_user` varchar(30) DEFAULT NULL COMMENT '修改人员',
  `lastchanged` timestamp(6) NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6) COMMENT '更改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='部门信息';

-- ----------------------------
-- Records of erp_department
-- ----------------------------

-- ----------------------------
-- Table structure for erp_fee
-- ----------------------------
DROP TABLE IF EXISTS `erp_fee`;
CREATE TABLE `erp_fee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fee_no` varchar(100) DEFAULT NULL COMMENT '费用账单',
  `org_id` int(11) DEFAULT NULL COMMENT '库链id',
  `customer_id` int(11) DEFAULT NULL COMMENT '客户id',
  `customer_name` varchar(100) DEFAULT NULL COMMENT '客户名称',
  `tx_month` varchar(10) DEFAULT NULL COMMENT '费用月份',
  `warehouse_code` varchar(30) DEFAULT NULL COMMENT '仓库编码',
  `fee_total` decimal(18,2) DEFAULT '0.00' COMMENT '费用合计',
  `fee_transfer` decimal(18,2) DEFAULT '0.00' COMMENT '过户费用',
  `fee_store` decimal(18,2) DEFAULT '0.00' COMMENT '仓储费用',
  `fee_stockin` decimal(18,2) DEFAULT '0.00' COMMENT '进库费用',
  `fee_stockout` decimal(18,2) DEFAULT '0.00' COMMENT '出库费用',
  `fee_other` decimal(18,2) DEFAULT '0.00' COMMENT '其他费用',
  `remarks` text COMMENT '备注',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `status` varchar(30) DEFAULT NULL COMMENT '状态:0;待客户付款#1;待仓库确认#2;仓库已确认',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_feeno` (`fee_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='客户账单';

-- ----------------------------
-- Records of erp_fee
-- ----------------------------

-- ----------------------------
-- Table structure for erp_fee_detail
-- ----------------------------
DROP TABLE IF EXISTS `erp_fee_detail`;
CREATE TABLE `erp_fee_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fee_id` int(11) DEFAULT NULL COMMENT '费用id',
  `fee_no` varchar(100) DEFAULT NULL COMMENT '费用账单',
  `org_id` int(11) DEFAULT NULL COMMENT '库链id',
  `customer_id` int(11) DEFAULT NULL COMMENT '客户id',
  `customer_name` varchar(100) DEFAULT NULL COMMENT '客户名称',
  `tx_month` varchar(10) DEFAULT NULL COMMENT '费用月份',
  `warehouse_code` varchar(30) DEFAULT NULL COMMENT '仓库编码',
  `tx_date` datetime DEFAULT NULL COMMENT '费用日期',
  `fee_type` varchar(50) DEFAULT NULL COMMENT '费用类型',
  `subject` varchar(100) DEFAULT NULL COMMENT '费用摘要',
  `storecard_id` int(11) DEFAULT NULL COMMENT '存储卡id',
  `storecard_no` varchar(50) DEFAULT NULL COMMENT '存储卡号',
  `order_no` varchar(50) DEFAULT NULL COMMENT '交易单据',
  `goods_no` varchar(50) DEFAULT NULL COMMENT '货品编码',
  `goods_name` varchar(100) DEFAULT NULL COMMENT '货品名称',
  `style_code` varchar(50) DEFAULT NULL COMMENT '规格编码',
  `weight` decimal(18,6) DEFAULT '0.000000' COMMENT '重量',
  `price` decimal(18,3) DEFAULT '0.000' COMMENT '价格',
  `amount` decimal(18,2) DEFAULT '0.00' COMMENT '金额',
  `remarks` text COMMENT '备注',
  PRIMARY KEY (`id`),
  KEY `idx_feeid` (`fee_id`),
  KEY `idx_feeno` (`fee_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='账单明细';

-- ----------------------------
-- Records of erp_fee_detail
-- ----------------------------

-- ----------------------------
-- Table structure for erp_goods
-- ----------------------------
DROP TABLE IF EXISTS `erp_goods`;
CREATE TABLE `erp_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `org_id` int(11) DEFAULT NULL COMMENT '库链id',
  `goods_no` varchar(50) DEFAULT NULL COMMENT '货品编码',
  `name` varchar(100) DEFAULT NULL COMMENT '货品名称, 注释:必须与平台一致',
  `prefix` varchar(30) DEFAULT NULL COMMENT '助记码, 注释:必须与平台一致',
  `style_info` varchar(100) DEFAULT NULL COMMENT '规格材质',
  `producing_area` varchar(50) DEFAULT NULL COMMENT '货品产地',
  `brand` varchar(50) DEFAULT NULL COMMENT '注册商标',
  `style_code` varchar(50) DEFAULT NULL COMMENT '规格编码, 注释:必须与平台一致',
  `category_code` varchar(30) DEFAULT NULL COMMENT '货品分类',
  `uom_qty` varchar(30) DEFAULT NULL COMMENT '数量单位, 注释:必须与平台一致',
  `uom_weight` varchar(30) DEFAULT NULL COMMENT '重量单位, 注释:必须与平台一致',
  `uom_bulkcargo` varchar(30) DEFAULT NULL COMMENT '散件单位, 注释:必须与平台一致',
  `active` tinyint(4) NOT NULL DEFAULT '0' COMMENT '活跃等级:0;滞销#1;平常#2;活跃#3;畅销',
  `year_code` varchar(30) DEFAULT NULL COMMENT '所属年份',
  `barcode` varchar(50) DEFAULT NULL COMMENT '货品条码',
  `gb_code` varchar(50) DEFAULT NULL COMMENT '国标编码',
  `img` varchar(200) DEFAULT NULL COMMENT '图像',
  `is_real` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否实物:1;是#0;否',
  `status` varchar(30) DEFAULT NULL COMMENT '状态:1;有效#2;缺货#0;无效',
  `sort` int(11) DEFAULT '9999' COMMENT '排序',
  `is_sync` tinyint(4) NOT NULL DEFAULT '0' COMMENT '平台同步:1;是#0;否',
  `sync_time` datetime DEFAULT NULL COMMENT '同步时间',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `create_user` varchar(30) DEFAULT NULL COMMENT '创建人员',
  `modify_time` datetime DEFAULT NULL COMMENT '修改时间',
  `modify_user` varchar(30) DEFAULT NULL COMMENT '修改人员',
  `lastchanged` timestamp(6) NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6) COMMENT '更改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_goodsno` (`goods_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='货品信息';

-- ----------------------------
-- Records of erp_goods
-- ----------------------------

-- ----------------------------
-- Table structure for erp_goods_category
-- ----------------------------
DROP TABLE IF EXISTS `erp_goods_category`;
CREATE TABLE `erp_goods_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT '0' COMMENT '上级分类',
  `code` varchar(30) DEFAULT NULL COMMENT '分类代码',
  `name` varchar(100) DEFAULT NULL COMMENT '分类名称',
  `description` varchar(255) DEFAULT NULL COMMENT '描述',
  `level` tinyint(4) NOT NULL DEFAULT '0' COMMENT '层级',
  `sort` smallint(8) DEFAULT '0' COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态:1;有效#0;无效',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `create_user` varchar(30) DEFAULT NULL COMMENT '创建人员',
  `modify_time` datetime DEFAULT NULL COMMENT '修改时间',
  `modify_user` varchar(30) DEFAULT NULL COMMENT '修改人员',
  `lastchanged` timestamp(6) NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6) COMMENT '更改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='货品分类';

-- ----------------------------
-- Records of erp_goods_category
-- ----------------------------

-- ----------------------------
-- Table structure for erp_goods_style
-- ----------------------------
DROP TABLE IF EXISTS `erp_goods_style`;
CREATE TABLE `erp_goods_style` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_code` varchar(30) DEFAULT NULL COMMENT '货品分类',
  `style_code` varchar(50) DEFAULT NULL COMMENT '规格编码',
  `style_name` varchar(100) DEFAULT NULL COMMENT '规格名称',
  `prefix` varchar(30) DEFAULT NULL COMMENT '助记码',
  `uom_qty` varchar(30) DEFAULT NULL COMMENT '数量单位',
  `uom_weight` varchar(30) DEFAULT NULL COMMENT '重量单位',
  `uom_bulkcargo` varchar(30) DEFAULT NULL COMMENT '散件单位',
  `tax_rate` decimal(18,3) DEFAULT '0.000' COMMENT '税率:0.000;无#0.060;6%#0.130;13%#0.170;17%',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='货品规格';

-- ----------------------------
-- Records of erp_goods_style
-- ----------------------------

-- ----------------------------
-- Table structure for erp_log_common
-- ----------------------------
DROP TABLE IF EXISTS `erp_log_common`;
CREATE TABLE `erp_log_common` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `create_user` varchar(30) DEFAULT NULL COMMENT '创建人员',
  `type` varchar(30) DEFAULT NULL COMMENT '类型:user;用户#style1;颜色#style2;尺码#year;年份#shop;店铺#season;季节#payment;支付方式#platform;平台#goods;货品#group;分组#department;部门#deliver;配送#customer;供应商#category;分类#brand;品牌#area;地区#activity;活动#return_reason;退货理由#storage;仓库',
  `data_id` int(11) DEFAULT NULL COMMENT '信息id',
  `data_code` varchar(50) DEFAULT NULL COMMENT '代码',
  `subject` varchar(100) DEFAULT NULL COMMENT '标题',
  `status` varchar(30) DEFAULT NULL COMMENT '状态',
  `content` text COMMENT '内容',
  `lastchanged` timestamp(6) NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6) COMMENT '更改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='公共日志';

-- ----------------------------
-- Records of erp_log_common
-- ----------------------------

-- ----------------------------
-- Table structure for erp_log_model
-- ----------------------------
DROP TABLE IF EXISTS `erp_log_model`;
CREATE TABLE `erp_log_model` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(30) DEFAULT NULL COMMENT '类型',
  `model` varchar(50) DEFAULT NULL COMMENT '模块',
  `action` varchar(50) DEFAULT NULL COMMENT '动作',
  `ip_address` varchar(50) DEFAULT NULL COMMENT 'IP地址',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `create_user` varchar(30) DEFAULT NULL COMMENT '创建人员',
  `lastchanged` timestamp(6) NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6) COMMENT '更改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='模块日志';

-- ----------------------------
-- Records of erp_log_model
-- ----------------------------

-- ----------------------------
-- Table structure for erp_log_order
-- ----------------------------
DROP TABLE IF EXISTS `erp_log_order`;
CREATE TABLE `erp_log_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `create_user` varchar(30) DEFAULT NULL COMMENT '创建人员',
  `type` varchar(30) DEFAULT NULL COMMENT '类型:sales;销售订单#stockin;仓库入库#stockout;仓库出库#stockmove;仓库移仓#stockadjust;仓库调整#stockcheck;仓库盘点',
  `order_id` int(11) DEFAULT NULL COMMENT '单据id',
  `order_no` varchar(50) DEFAULT NULL COMMENT '单据号码',
  `subject` varchar(100) DEFAULT NULL COMMENT '标题',
  `details` int(4) DEFAULT '0' COMMENT '明细条数',
  `weight` decimal(18,6) DEFAULT '0.000000' COMMENT '重量',
  `qty` decimal(18,6) DEFAULT '0.000000' COMMENT '数量',
  `amount` decimal(18,2) DEFAULT '0.00' COMMENT '金额',
  `status` varchar(30) DEFAULT NULL COMMENT '状态',
  `content` text COMMENT '内容',
  `lastchanged` timestamp(6) NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6) COMMENT '更改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='凭据日志';

-- ----------------------------
-- Records of erp_log_order
-- ----------------------------

-- ----------------------------
-- Table structure for erp_log_trade
-- ----------------------------
DROP TABLE IF EXISTS `erp_log_trade`;
CREATE TABLE `erp_log_trade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `create_user` varchar(30) DEFAULT NULL COMMENT '创建人员',
  `type` varchar(30) DEFAULT NULL COMMENT '类型',
  `order_id` int(11) DEFAULT NULL COMMENT '交易id',
  `order_no` varchar(50) DEFAULT NULL COMMENT '交易号码',
  `subject` varchar(100) DEFAULT NULL COMMENT '日志标题',
  `details` int(4) DEFAULT '0' COMMENT '明细条数',
  `weight` decimal(18,6) DEFAULT '0.000000' COMMENT '重量',
  `qty` decimal(18,6) DEFAULT '0.000000' COMMENT '数量',
  `amount` decimal(18,2) DEFAULT '0.00' COMMENT '金额',
  `status` varchar(30) DEFAULT NULL COMMENT '交易状态',
  `content` text COMMENT '内容',
  `lastchanged` timestamp(6) NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6) COMMENT '更改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='交易日志';

-- ----------------------------
-- Records of erp_log_trade
-- ----------------------------

-- ----------------------------
-- Table structure for erp_message_send
-- ----------------------------
DROP TABLE IF EXISTS `erp_message_send`;
CREATE TABLE `erp_message_send` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL COMMENT '用户ID',
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '信息类型:0;注册#1;过户#2;提货#3;付款#4;收款',
  `send` tinyint(4) NOT NULL DEFAULT '0' COMMENT '发送途径:0;信息#1;微信#2;邮件',
  `message_templet_code` varchar(30) DEFAULT NULL COMMENT '模板代码',
  `email` varchar(100) DEFAULT NULL COMMENT '邮箱',
  `mobile` varchar(50) DEFAULT NULL COMMENT '手机',
  `wechat_openid` varchar(100) DEFAULT NULL COMMENT '微信ID',
  `content` text COMMENT '发送内容',
  `status` varchar(30) DEFAULT NULL COMMENT '状态:0;未发送#1;已发送#7;已取消',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `create_user` varchar(30) DEFAULT NULL COMMENT '创建人员',
  `modify_time` datetime DEFAULT NULL COMMENT '修改时间',
  `modify_user` varchar(30) DEFAULT NULL COMMENT '修改人员',
  `lastchanged` timestamp(6) NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6) COMMENT '更改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='消息发送';

-- ----------------------------
-- Records of erp_message_send
-- ----------------------------

-- ----------------------------
-- Table structure for erp_message_templet
-- ----------------------------
DROP TABLE IF EXISTS `erp_message_templet`;
CREATE TABLE `erp_message_templet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '信息类型:0;注册#1;过户#2;提货#3;付款#4;收款',
  `send` tinyint(4) NOT NULL DEFAULT '0' COMMENT '发送途径:0;信息#1;微信#2;邮件',
  `code` varchar(30) DEFAULT NULL COMMENT '模板代码',
  `name` varchar(100) DEFAULT NULL COMMENT '模板名称',
  `content` text COMMENT '模板内容',
  `sort` int(11) DEFAULT '9999' COMMENT '排序',
  `status` varchar(30) DEFAULT NULL COMMENT '状态:1;有效#0;无效',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `create_user` varchar(30) DEFAULT NULL COMMENT '创建人员',
  `modify_time` datetime DEFAULT NULL COMMENT '修改时间',
  `modify_user` varchar(30) DEFAULT NULL COMMENT '修改人员',
  `lastchanged` timestamp(6) NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6) COMMENT '更改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='消息模板';

-- ----------------------------
-- Records of erp_message_templet
-- ----------------------------

-- ----------------------------
-- Table structure for erp_node
-- ----------------------------
DROP TABLE IF EXISTS `erp_node`;
CREATE TABLE `erp_node` (
  `id` varchar(30) NOT NULL COMMENT '模块id',
  `name` varchar(100) DEFAULT NULL COMMENT '模块名称',
  `title` varchar(200) DEFAULT NULL COMMENT '模块描述',
  `status` varchar(30) DEFAULT NULL COMMENT '状态:1;有效#0;无效',
  `remarks` text COMMENT '备注',
  `sort` int(11) DEFAULT '9999' COMMENT '排序',
  `pid` int(11) DEFAULT '0' COMMENT '父层',
  `level` tinyint(4) NOT NULL DEFAULT '0' COMMENT '级别',
  `module` varchar(200) DEFAULT NULL COMMENT '模块说明',
  `model` varchar(50) DEFAULT NULL COMMENT '启动方式',
  `btn_name` varchar(50) DEFAULT NULL COMMENT '按钮名称',
  `is_admin` tinyint(4) NOT NULL DEFAULT '0' COMMENT '超级用户:1;是#0;否',
  `ico` varchar(50) DEFAULT NULL COMMENT '图标',
  `default_open` tinyint(4) NOT NULL DEFAULT '0' COMMENT '缺省展开:1;是#0;否',
  `side` tinyint(4) NOT NULL DEFAULT '0' COMMENT '交易方',
  `menu` tinyint(4) NOT NULL DEFAULT '0' COMMENT '菜单',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='模块功能';

-- ----------------------------
-- Records of erp_node
-- ----------------------------
INSERT INTO `erp_node` VALUES ('10', 'X10', '平台功能', '1', null, '9999', '0', '1', null, '', null, '0', null, '1', '1', '1');
INSERT INTO `erp_node` VALUES ('1005', 'X1005', '联盟管理', '1', null, '9999', '10', '2', '', '', null, '0', null, '1', '1', '1');
INSERT INTO `erp_node` VALUES ('100505', 'X100505', '联盟机构列表', '1', null, '9999', '1005', '3', '/Summary/OrgSummary/index?func=search', '', null, '0', null, '0', '1', '1');
INSERT INTO `erp_node` VALUES ('100510', 'X100510', '联盟仓库列表', '1', null, '9999', '1005', '3', '/Summary/WarehouseSummary/index?func=search', '', null, '0', null, '0', '1', '1');
INSERT INTO `erp_node` VALUES ('100515', 'X100515', '联盟货品列表', '1', null, '9999', '1005', '3', '/Summary/GoodsSummary/index?func=search', '', null, '0', null, '0', '1', '1');
INSERT INTO `erp_node` VALUES ('100520', 'X100520', '联盟用户列表', '1', null, '9999', '1005', '3', '/Summary/OrgUserSummary/index?func=search', '', null, '0', null, '0', '1', '1');
INSERT INTO `erp_node` VALUES ('1010', 'X1010', '客户管理', '1', null, '9999', '10', '2', '', '', null, '0', null, '1', '1', '1');
INSERT INTO `erp_node` VALUES ('101005', 'X101005', '客户分类列表', '1', null, '9999', '1010', '3', '/Summary/CustomerCategorySummary/index?func=search', '', null, '0', null, '0', '1', '1');
INSERT INTO `erp_node` VALUES ('101010', 'X101010', '客户信息列表', '1', null, '9999', '1010', '3', '/Summary/CustomerSummary/index?func=search', '', null, '0', null, '0', '1', '1');
INSERT INTO `erp_node` VALUES ('101015', 'X101015', '客户地址列表', '1', null, '9999', '1010', '3', '/Summary/CustomerAddressSummary/index?func=search', '', null, '0', null, '0', '1', '1');
INSERT INTO `erp_node` VALUES ('101020', 'X101020', '客户用户列表', '1', null, '9999', '1010', '3', '/Summary/CustomerUserSummary/index?func=search', '', null, '0', null, '0', '1', '1');
INSERT INTO `erp_node` VALUES ('1015', 'X1015', '货品管理', '1', null, '9999', '10', '2', '', '', null, '0', null, '1', '1', '1');
INSERT INTO `erp_node` VALUES ('101505', 'X101505', '货品分类列表', '1', null, '9999', '1015', '3', '/Summary/GoodsCategorySummary/index?func=search', '', null, '0', null, '0', '1', '1');
INSERT INTO `erp_node` VALUES ('101510', 'X101510', '货品规格列表', '1', null, '9999', '1015', '3', '/Summary/GoodsStyleSummary/index?func=search', '', null, '0', null, '0', '1', '1');
INSERT INTO `erp_node` VALUES ('1060', 'X1060', '用户管理', '1', null, '9999', '10', '2', '', '', null, '0', null, '1', '1', '1');
INSERT INTO `erp_node` VALUES ('106005', 'X106005', '部门信息列表', '1', null, '9999', '1060', '3', '/Summary/DepartmentSummary/index?func=search', '', null, '0', null, '0', '1', '1');
INSERT INTO `erp_node` VALUES ('106010', 'X106010', '用户信息列表', '1', null, '9999', '1060', '3', '/Summary/UserSummary/index?func=search', '', null, '0', null, '0', '1', '1');
INSERT INTO `erp_node` VALUES ('1070', 'X1070', '消息管理', '1', null, '9999', '10', '2', '', '', null, '0', null, '1', '1', '1');
INSERT INTO `erp_node` VALUES ('107005', 'X107005', '消息模板列表', '1', null, '9999', '1070', '3', '/Summary/MessageTempletSummary/index?func=search', '', null, '0', null, '0', '1', '1');
INSERT INTO `erp_node` VALUES ('107010', 'X107010', '消息发送列表', '1', null, '9999', '1070', '3', '/Summary/MessageSendSummary/index?func=search', '', null, '0', null, '0', '1', '1');
INSERT INTO `erp_node` VALUES ('1085', 'X1085', '基础数据', '1', null, '9999', '10', '2', null, '', null, '0', null, '1', '1', '1');
INSERT INTO `erp_node` VALUES ('108505', 'X108505', '系统分类列表', '1', null, '9999', '1085', '3', '/Summary/SubcodeSummary/index?func=search', '', null, '0', null, '0', '1', '1');
INSERT INTO `erp_node` VALUES ('108510', 'X108510', '系统序号列表', '1', null, '9999', '1085', '3', '/Summary/SystemGenSummary/index?func=search', '', null, '0', null, '0', '1', '1');
INSERT INTO `erp_node` VALUES ('108515', 'X108515', '系统参数列表', '1', null, '9999', '1085', '3', '/Summary/SystemParameterSummary/index?func=search', '', null, '0', null, '0', '1', '1');
INSERT INTO `erp_node` VALUES ('1090', 'X1090', '安全管理', '1', null, '9999', '10', '2', null, '', null, '0', null, '1', '1', '1');
INSERT INTO `erp_node` VALUES ('109005', 'X109005', '角色列表', '1', null, '9999', '1090', '3', '/Summary/RoleSummary/index?func=search', '', null, '0', null, '0', '1', '1');
INSERT INTO `erp_node` VALUES ('109010', 'X109010', '角色/模块关系列表', '1', null, '9999', '1090', '3', '/Summary/RoleNodeSummary/index?func=search', '', null, '0', null, '0', '1', '1');
INSERT INTO `erp_node` VALUES ('109015', 'X109015', '角色/用户关系列表', '1', null, '9999', '1090', '3', '/Summary/RoleUserSummary/index?func=search', '', null, '0', null, '0', '1', '1');
INSERT INTO `erp_node` VALUES ('109020', 'X109020', '模块功能列表', '1', null, '9999', '1090', '3', '/Summary/NodeSummary/index?func=search', '', null, '0', null, '0', '1', '1');
INSERT INTO `erp_node` VALUES ('1095', 'X1095', '交易日志', '1', null, '9999', '10', '2', null, '', null, '0', null, '1', '1', '1');
INSERT INTO `erp_node` VALUES ('109505', 'X109505', '交易订单日志列表', '1', null, '9999', '1095', '3', '/Summary/LogTradeSummary/index?func=search', '', null, '0', null, '0', '1', '1');
INSERT INTO `erp_node` VALUES ('109510', 'X109510', '交易接口日志列表', '1', null, '9999', '1095', '3', '/Summary/LogOrderSummary/index?func=search', '', null, '0', null, '0', '1', '1');
INSERT INTO `erp_node` VALUES ('109515', 'X109515', '公共数据日志列表', '1', null, '9999', '1095', '3', '/Summary/LogCommonSummary/index?func=search', '', null, '0', null, '0', '1', '1');
INSERT INTO `erp_node` VALUES ('109520', 'X109520', '操作安全日志列表', '1', null, '9999', '1095', '3', '/Summary/LogModelSummary/index?func=search', '', null, '0', null, '0', '1', '1');
INSERT INTO `erp_node` VALUES ('20', 'X20', '联盟功能', '1', null, '9999', '0', '1', null, '', null, '0', null, '1', '2', '1');
INSERT INTO `erp_node` VALUES ('2005', 'X2005', '交易订单', '1', null, '9999', '20', '2', null, '', null, '0', null, '1', '2', '1');
INSERT INTO `erp_node` VALUES ('200505', 'X200505', '客户信息列表', '1', null, '9999', '2005', '3', '/Summary/CustomerSummary/index?func=search', '', null, '0', null, '0', '2', '1');
INSERT INTO `erp_node` VALUES ('200510', 'X200510', '交易订单列表', '1', null, '9999', '2005', '3', '/Summary/TradeSummary/index?func=search', '', null, '0', null, '0', '2', '1');
INSERT INTO `erp_node` VALUES ('200515', 'X200515', '历史订单列表', '1', null, '9999', '2005', '3', '/Summary/TradeSummary/index?func=search', '', null, '0', null, '0', '2', '1');
INSERT INTO `erp_node` VALUES ('200520', 'X200520', '链式交易列表', '1', null, '9999', '2005', '3', '/Summary/TradeSummary/index?func=search', '', null, '0', null, '0', '2', '1');
INSERT INTO `erp_node` VALUES ('2010', 'X2010', '仓库库存', '1', null, '9999', '20', '2', null, '', null, '0', null, '1', '2', '1');
INSERT INTO `erp_node` VALUES ('201005', 'X201005', '仓库库存列表', '1', null, '9999', '2010', '3', '/Summary/StockSummary/index?func=search', '', null, '0', null, '0', '2', '1');
INSERT INTO `erp_node` VALUES ('201010', 'X201010', '仓库存储卡列表', '1', null, '9999', '2010', '3', '/Summary/StorecardSummary/index?func=search', '', null, '0', null, '0', '2', '1');
INSERT INTO `erp_node` VALUES ('201015', 'X201015', '仓库存储卡码单列表', '1', null, '9999', '2010', '3', '/Summary/StorecardPackageSummary/index?func=search', '', null, '0', null, '0', '2', '1');
INSERT INTO `erp_node` VALUES ('201020', 'X201020', '仓库存储卡垛号列表', '1', null, '9999', '2010', '3', '/Summary/StorecardButtressSummary/index?func=search', '', null, '0', null, '0', '2', '1');
INSERT INTO `erp_node` VALUES ('2015', 'X2015', '交易处理', '1', null, '9999', '20', '2', null, '', null, '0', null, '1', '2', '1');
INSERT INTO `erp_node` VALUES ('201505', 'X201505', '提单列表', '1', null, '9999', '2015', '3', '/Summary/DeliverySummary/index?func=search', '', null, '0', null, '0', '2', '1');
INSERT INTO `erp_node` VALUES ('201510', 'X201510', '提单存储卡列表', '1', null, '9999', '2015', '3', '/Summary/DeliveryStorecardSummary/index?func=search', '', null, '0', null, '0', '2', '1');
INSERT INTO `erp_node` VALUES ('201520', 'X201520', '过户列表', '1', null, '9999', '2015', '3', '/Summary/TransferSummary/index?func=search', '', null, '0', null, '0', '2', '1');
INSERT INTO `erp_node` VALUES ('201525', 'X201525', '过户存储卡列表', '1', null, '9999', '2015', '3', '/Summary/TransferStoragecardSummary/index?func=search', '', null, '0', null, '0', '2', '1');
INSERT INTO `erp_node` VALUES ('2020', 'X2020', '库存台账', '1', null, '9999', '20', '2', null, '', null, '0', null, '1', '2', '1');
INSERT INTO `erp_node` VALUES ('202005', 'X202005', '库存台账列表', '1', null, '9999', '2020', '3', '/Summary/StorecardMovementSummary/index?func=search', '', null, '0', null, '0', '2', '1');
INSERT INTO `erp_node` VALUES ('202010', 'X202010', '库存加锁列表', '1', null, '9999', '2020', '3', '/Summary/StorecardLockSummary/index?func=search', '', null, '0', null, '0', '2', '1');
INSERT INTO `erp_node` VALUES ('2025', 'X2025', '货品管理', '1', null, '9999', '20', '2', '', '', null, '0', null, '1', '2', '1');
INSERT INTO `erp_node` VALUES ('202505', 'X202505', '货品分类列表', '1', null, '9999', '2025', '3', '/Summary/GoodsCategorySummary/index?func=search', '', null, '0', null, '0', '2', '1');
INSERT INTO `erp_node` VALUES ('202510', 'X202510', '货品规格列表', '1', null, '9999', '2025', '3', '/Summary/GoodsStyleSummary/index?func=search', '', null, '0', null, '0', '2', '1');
INSERT INTO `erp_node` VALUES ('202515', 'X202515', '仓库货品列表', '1', null, '9999', '2025', '3', '/Summary/GoodsSummary/index?func=search', '', null, '0', null, '0', '2', '1');
INSERT INTO `erp_node` VALUES ('2030', 'X2030', '账单管理', '1', null, '9999', '20', '2', null, '', null, '0', null, '1', '2', '1');
INSERT INTO `erp_node` VALUES ('203010', 'X203010', '客户账单列表', '1', null, '9999', '2030', '3', '/Summary/CustomerSummary/index?func=search', '', null, '0', null, '0', '2', '1');
INSERT INTO `erp_node` VALUES ('203015', 'X203015', '仓储合同列表', '1', null, '9999', '2030', '3', '/Summary/CustomerSummary/index?func=search', '', null, '0', null, '0', '2', '1');
INSERT INTO `erp_node` VALUES ('2035', 'X2035', '仓库接口', '1', null, '9999', '20', '2', null, '', null, '0', null, '1', '2', '1');
INSERT INTO `erp_node` VALUES ('203505', 'X203505', '发送仓库列表', '1', null, '9999', '2035', '3', '/Summary/TradeSummary/index?func=search', '', null, '0', null, '0', '2', '1');
INSERT INTO `erp_node` VALUES ('203510', 'X203510', '仓库返回列表', '1', null, '9999', '2035', '3', '/Summary/TradeSummary/index?func=search', '', null, '0', null, '0', '2', '1');
INSERT INTO `erp_node` VALUES ('2040', 'X2040', '系统管理', '1', null, '9999', '20', '2', '', '', null, '0', null, '1', '2', '1');
INSERT INTO `erp_node` VALUES ('204005', 'X204005', '联盟机构列表', '1', null, '9999', '2040', '3', '/Platform/OrgSummary/index?func=search', '', null, '0', null, '0', '2', '1');
INSERT INTO `erp_node` VALUES ('204010', 'X204010', '用户信息列表', '1', null, '9999', '2040', '3', '/Summary/CustomerUserSummary/index?func=search', '', null, '0', null, '0', '2', '1');
INSERT INTO `erp_node` VALUES ('204015', 'X204015', '仓库信息列表', '1', null, '9999', '2040', '3', '/Summary/WarehouseSummary/index?func=search', '', null, '0', null, '0', '2', '1');
INSERT INTO `erp_node` VALUES ('204020', 'X204020', '客户信息列表', '1', null, '9999', '2040', '3', '/Summary/CustomerSummary/index?func=search', '', null, '0', null, '0', '2', '1');
INSERT INTO `erp_node` VALUES ('2095', 'X2095', '交易日志', '1', null, '9999', '20', '2', null, '', null, '0', null, '1', '2', '1');
INSERT INTO `erp_node` VALUES ('209505', 'X209505', '交易订单日志列表', '1', null, '9999', '2095', '3', '/Summary/LogTradeSummary/index?func=search', '', null, '0', null, '0', '2', '1');
INSERT INTO `erp_node` VALUES ('209510', 'X209510', '交易接口日志列表', '1', null, '9999', '2095', '3', '/Summary/LogOrderSummary/index?func=search', '', null, '0', null, '0', '2', '1');
INSERT INTO `erp_node` VALUES ('209515', 'X209515', '公共数据日志列表', '1', null, '9999', '2095', '3', '/Summary/LogCommonSummary/index?func=search', '', null, '0', null, '0', '2', '1');
INSERT INTO `erp_node` VALUES ('209520', 'X209520', '操作安全日志列表', '1', null, '9999', '2095', '3', '/Summary/LogModelSummary/index?func=search', '', null, '0', null, '0', '2', '1');
INSERT INTO `erp_node` VALUES ('30', 'X30', '客户功能', '1', null, '9999', '0', '1', null, '', null, '0', null, '1', '3', '1');
INSERT INTO `erp_node` VALUES ('3000', 'X3000', '仓库库存', '1', null, '9999', '30', '2', null, '', null, '0', null, '1', '3', '1');
INSERT INTO `erp_node` VALUES ('300005', 'X300005', '仓库库存列表', '1', null, '9999', '3000', '3', '/Summary/StockSummary/index?func=search', '', null, '0', null, '0', '3', '1');
INSERT INTO `erp_node` VALUES ('300010', 'X300010', '仓库存储卡列表', '1', null, '9999', '3000', '3', '/Summary/StorecardSummary/index?func=search', '', null, '0', null, '0', '3', '1');
INSERT INTO `erp_node` VALUES ('300015', 'X300015', '仓库存储卡码单列表', '1', null, '9999', '3000', '3', '/Summary/StorecardPackageSummary/index?func=search', '', null, '0', null, '0', '3', '1');
INSERT INTO `erp_node` VALUES ('300020', 'X300020', '仓库存储卡垛号列表', '1', null, '9999', '3000', '3', '/Summary/StorecardButtressSummary/index?func=search', '', null, '0', null, '0', '3', '1');
INSERT INTO `erp_node` VALUES ('3005', 'X3005', '买入交易', '1', null, '9999', '30', '2', null, '', null, '0', null, '1', '3', '1');
INSERT INTO `erp_node` VALUES ('300505', 'X300505', '买入交易列表', '1', null, '9999', '3005', '3', '/Summary/TradeSummary/index?func=search', '', null, '0', null, '0', '3', '1');
INSERT INTO `erp_node` VALUES ('300510', 'X300510', '买入付款列表', '1', null, '9999', '3005', '3', '/Summary/TradeSummary/index?func=search', '', null, '0', null, '0', '3', '1');
INSERT INTO `erp_node` VALUES ('3010', 'X3010', '卖出交易', '1', null, '9999', '30', '2', null, '', null, '0', null, '1', '3', '1');
INSERT INTO `erp_node` VALUES ('301005', 'X301005', '卖出交易列表', '1', null, '9999', '3010', '3', '/Summary/TradeSummary/index?func=search', '', null, '0', null, '0', '3', '1');
INSERT INTO `erp_node` VALUES ('301010', 'X301010', '卖出配货列表', '1', null, '9999', '3010', '3', '/Summary/TradeSummary/index?func=search', '', null, '0', null, '0', '3', '1');
INSERT INTO `erp_node` VALUES ('301015', 'X301015', '卖出收款列表', '1', null, '9999', '3010', '3', '/Summary/TradeSummary/index?func=search', '', null, '0', null, '0', '3', '1');
INSERT INTO `erp_node` VALUES ('3015', 'X3015', '交易完成', '1', null, '9999', '30', '2', null, '', null, '0', null, '1', '3', '1');
INSERT INTO `erp_node` VALUES ('301505', 'X301505', '提单列表', '1', null, '9999', '3015', '3', '/Summary/DeliverySummary/index?func=search', '', null, '0', null, '0', '3', '1');
INSERT INTO `erp_node` VALUES ('301510', 'X301510', '提单存储卡列表', '1', null, '9999', '3015', '3', '/Summary/DeliveryStorecardSummary/index?func=search', '', null, '0', null, '0', '3', '1');
INSERT INTO `erp_node` VALUES ('301520', 'X301520', '过户列表', '1', null, '9999', '3015', '3', '/Summary/TransferSummary/index?func=search', '', null, '0', null, '0', '3', '1');
INSERT INTO `erp_node` VALUES ('301525', 'X301525', '过户存储卡列表', '1', null, '9999', '3015', '3', '/Summary/TransferStoragecardSummary/index?func=search', '', null, '0', null, '0', '3', '1');
INSERT INTO `erp_node` VALUES ('3020', 'X3020', '库存台账', '1', null, '9999', '30', '2', null, '', null, '0', null, '1', '3', '1');
INSERT INTO `erp_node` VALUES ('302005', 'X302005', '库存台账列表', '1', null, '9999', '3020', '3', '/Summary/StorecardMovementSummary/index?func=search', '', null, '0', null, '0', '3', '1');
INSERT INTO `erp_node` VALUES ('302010', 'X302010', '库存加锁列表', '1', null, '9999', '3020', '3', '/Summary/StorecardLockSummary/index?func=search', '', null, '0', null, '0', '3', '1');
INSERT INTO `erp_node` VALUES ('3025', 'X3025', '客户管理', '1', null, '9999', '30', '2', '', '', null, '0', null, '1', '3', '1');
INSERT INTO `erp_node` VALUES ('302510', 'X302510', '客户信息列表', '1', null, '9999', '3025', '3', '/Summary/CustomerSummary/index?func=search', '', null, '0', null, '0', '3', '1');
INSERT INTO `erp_node` VALUES ('302515', 'X302515', '客户地址列表', '1', null, '9999', '3025', '3', '/Summary/CustomerAddressSummary/index?func=search', '', null, '0', null, '0', '3', '1');
INSERT INTO `erp_node` VALUES ('302520', 'X302520', '客户用户列表', '1', null, '9999', '3025', '3', '/Summary/CustomerUserSummary/index?func=search', '', null, '0', null, '0', '3', '1');

-- ----------------------------
-- Table structure for erp_org
-- ----------------------------
DROP TABLE IF EXISTS `erp_org`;
CREATE TABLE `erp_org` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '机构类型:0;物流商#1;经销商#2;厂家',
  `code` varchar(30) DEFAULT NULL COMMENT '机构代码',
  `name` varchar(100) DEFAULT NULL COMMENT '机构名称',
  `phone` varchar(50) DEFAULT NULL COMMENT '联系电话',
  `contacts` varchar(50) DEFAULT NULL COMMENT '联系人员',
  `address` varchar(200) DEFAULT NULL COMMENT '联系地址',
  `wechat_openid` varchar(100) DEFAULT NULL COMMENT '微信ID',
  `remarks` text COMMENT '备注',
  `interface_open` tinyint(4) NOT NULL DEFAULT '0' COMMENT '接口控制:0;关闭#1;开放',
  `interface_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '接口类型:0;无#1;线上网站#2;线下仓库',
  `interface_para` text COMMENT '接口参数',
  `sort` int(11) DEFAULT '9999' COMMENT '排序',
  `status` varchar(30) DEFAULT NULL COMMENT '状态:1;有效#0;失效#8;已取消',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `create_user` varchar(30) DEFAULT NULL COMMENT '创建人员',
  `modify_time` datetime DEFAULT NULL COMMENT '修改时间',
  `modify_user` varchar(30) DEFAULT NULL COMMENT '修改人员',
  `lastchanged` timestamp(6) NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6) COMMENT '更改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='库链联盟机构';

-- ----------------------------
-- Records of erp_org
-- ----------------------------
INSERT INTO `erp_org` VALUES ('1', '0', '1234', '1111222333', null, null, null, null, null, '0', '0', null, '9999', '1', null, null, null, null, '2019-06-04 21:38:18.038389');

-- ----------------------------
-- Table structure for erp_org_customer
-- ----------------------------
DROP TABLE IF EXISTS `erp_org_customer`;
CREATE TABLE `erp_org_customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `org_id` int(11) DEFAULT NULL COMMENT '库链id',
  `customer_id` int(11) DEFAULT NULL COMMENT '客户id',
  `local_id` varchar(50) DEFAULT NULL COMMENT '线下ID',
  `local_name` varchar(100) DEFAULT NULL COMMENT '线下名称',
  `status` varchar(30) DEFAULT NULL COMMENT '状态:0;申请#1;授权',
  `auth_time` datetime DEFAULT NULL COMMENT '授权时间',
  `auth_user` varchar(30) DEFAULT NULL COMMENT '授权人员',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `create_user` varchar(30) DEFAULT NULL COMMENT '创建人员',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_orgid_customerid_localid` (`org_id`,`customer_id`,`local_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='库链/客户对应';

-- ----------------------------
-- Records of erp_org_customer
-- ----------------------------

-- ----------------------------
-- Table structure for erp_org_user
-- ----------------------------
DROP TABLE IF EXISTS `erp_org_user`;
CREATE TABLE `erp_org_user` (
  `org_id` int(11) NOT NULL COMMENT '库链id',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '类型:0;管理#1;业务',
  PRIMARY KEY (`org_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='库链/用户对应关系';

-- ----------------------------
-- Records of erp_org_user
-- ----------------------------

-- ----------------------------
-- Table structure for erp_payment
-- ----------------------------
DROP TABLE IF EXISTS `erp_payment`;
CREATE TABLE `erp_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `org_id` int(11) DEFAULT NULL COMMENT '库链id',
  `customer_id` int(11) DEFAULT NULL COMMENT '客户id',
  `customer_name` varchar(100) DEFAULT NULL COMMENT '客户名称',
  `warehouse_code` varchar(30) DEFAULT NULL COMMENT '仓库编码',
  `order_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '交易类型:0;交易#1;补差#2;费用',
  `order_id` int(11) DEFAULT NULL COMMENT '交易id',
  `order_no` varchar(50) DEFAULT NULL COMMENT '交易单号',
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '款项类型:0;付款#1;收款',
  `voucher_no` varchar(100) DEFAULT NULL COMMENT '款项凭证',
  `amount` decimal(18,2) DEFAULT '0.00' COMMENT '款项金额',
  `payment_type` varchar(30) DEFAULT NULL COMMENT '支付方式',
  `remarks` text COMMENT '备注',
  `confirm_time` datetime DEFAULT NULL COMMENT '确认时间',
  `confirm_user` varchar(30) DEFAULT NULL COMMENT '确认人员',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='款项登记';

-- ----------------------------
-- Records of erp_payment
-- ----------------------------

-- ----------------------------
-- Table structure for erp_role
-- ----------------------------
DROP TABLE IF EXISTS `erp_role`;
CREATE TABLE `erp_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(30) DEFAULT NULL COMMENT '状态:1;有效#0;无效',
  `name` varchar(100) DEFAULT NULL COMMENT '角色',
  `pid` int(11) DEFAULT '0' COMMENT '父层',
  `remarks` text COMMENT '备注',
  `approval` tinyint(4) NOT NULL DEFAULT '0' COMMENT '审批级别:0;无#1;一级#2;二级#3;特权',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色';

-- ----------------------------
-- Records of erp_role
-- ----------------------------

-- ----------------------------
-- Table structure for erp_role_node
-- ----------------------------
DROP TABLE IF EXISTS `erp_role_node`;
CREATE TABLE `erp_role_node` (
  `role_id` int(11) NOT NULL COMMENT '角色id',
  `node_id` int(11) NOT NULL COMMENT '模块id',
  `node_name` varchar(100) DEFAULT NULL COMMENT '模块名称',
  `level` tinyint(4) NOT NULL DEFAULT '0' COMMENT '层级',
  `module` varchar(200) DEFAULT NULL COMMENT '模块说明',
  PRIMARY KEY (`role_id`,`node_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色/模块关系';

-- ----------------------------
-- Records of erp_role_node
-- ----------------------------

-- ----------------------------
-- Table structure for erp_role_user
-- ----------------------------
DROP TABLE IF EXISTS `erp_role_user`;
CREATE TABLE `erp_role_user` (
  `role_id` int(11) NOT NULL COMMENT '角色id',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  PRIMARY KEY (`role_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色/用户关系';

-- ----------------------------
-- Records of erp_role_user
-- ----------------------------

-- ----------------------------
-- Table structure for erp_stock
-- ----------------------------
DROP TABLE IF EXISTS `erp_stock`;
CREATE TABLE `erp_stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `org_id` int(11) DEFAULT NULL COMMENT '库链id',
  `customer_id` int(11) DEFAULT NULL COMMENT '客户id',
  `warehouse_code` varchar(30) DEFAULT NULL COMMENT '仓库编码',
  `style_code` varchar(30) DEFAULT NULL COMMENT '款式编码',
  `weight` decimal(18,6) DEFAULT '0.000000' COMMENT '重量',
  `qty` decimal(18,6) DEFAULT '0.000000' COMMENT '数量',
  `bulkcargo` decimal(18,6) DEFAULT '0.000000' COMMENT '散件',
  `lock_weight` decimal(18,6) DEFAULT '0.000000' COMMENT '锁重量',
  `lock_qty` decimal(18,6) DEFAULT '0.000000' COMMENT '锁数量',
  `lock_bulkcargo` decimal(18,6) DEFAULT '0.000000' COMMENT '锁散件',
  `create_user` varchar(30) DEFAULT NULL COMMENT '创建人员',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `modify_user` varchar(30) DEFAULT NULL COMMENT '修改人员',
  `modify_time` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_orgid_customerid_warehousecode_stylecode` (`org_id`,`customer_id`,`warehouse_code`,`style_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='库存信息';

-- ----------------------------
-- Records of erp_stock
-- ----------------------------

-- ----------------------------
-- Table structure for erp_storecard
-- ----------------------------
DROP TABLE IF EXISTS `erp_storecard`;
CREATE TABLE `erp_storecard` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `org_id` int(11) DEFAULT NULL COMMENT '库链id',
  `customer_id` int(11) DEFAULT NULL COMMENT '客户id',
  `storecard_no` varchar(50) DEFAULT NULL COMMENT '存储卡号',
  `warehouse_code` varchar(30) DEFAULT NULL COMMENT '仓库编码',
  `customer_name` varchar(100) DEFAULT NULL COMMENT '客户名称',
  `goods_id` int(11) DEFAULT NULL COMMENT '货品ID',
  `goods_no` varchar(50) DEFAULT NULL COMMENT '货品编码',
  `goods_name` varchar(100) DEFAULT NULL COMMENT '货品名称',
  `style_info` varchar(100) DEFAULT NULL COMMENT '规格材质',
  `brand` varchar(50) DEFAULT NULL COMMENT '注册商标',
  `producing_area` varchar(50) DEFAULT NULL COMMENT '货品产地',
  `style_code` varchar(50) DEFAULT NULL COMMENT '规格编码',
  `weight` decimal(18,6) DEFAULT '0.000000' COMMENT '重量',
  `qty` decimal(18,6) DEFAULT '0.000000' COMMENT '数量',
  `bulkcargo` decimal(18,6) DEFAULT '0.000000' COMMENT '散件',
  `lock_weight` decimal(18,6) DEFAULT '0.000000' COMMENT '锁重量',
  `lock_qty` decimal(18,6) DEFAULT '0.000000' COMMENT '锁数量',
  `lock_bulkcargo` decimal(18,6) DEFAULT '0.000000' COMMENT '锁散件',
  `uom_qty` varchar(30) DEFAULT NULL COMMENT '数量单位',
  `uom_weight` varchar(30) DEFAULT NULL COMMENT '重量单位',
  `uom_bulkcargo` varchar(30) DEFAULT NULL COMMENT '散件单位',
  `contact_id` int(11) DEFAULT NULL COMMENT '合同id',
  `contact_no` varchar(30) DEFAULT NULL COMMENT '仓储合同',
  `status` varchar(30) DEFAULT NULL COMMENT '状态',
  `create_user` varchar(30) DEFAULT NULL COMMENT '创建人员',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `modify_user` varchar(30) DEFAULT NULL COMMENT '修改人员',
  `modify_time` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_orgid_customerid_storecardno` (`org_id`,`customer_id`,`storecard_no`),
  UNIQUE KEY `idx_storecardno` (`storecard_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='存储卡';

-- ----------------------------
-- Records of erp_storecard
-- ----------------------------

-- ----------------------------
-- Table structure for erp_storecard_buttress
-- ----------------------------
DROP TABLE IF EXISTS `erp_storecard_buttress`;
CREATE TABLE `erp_storecard_buttress` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `org_id` int(11) DEFAULT NULL COMMENT '库链id',
  `customer_id` int(11) DEFAULT NULL COMMENT '客户id',
  `package_id` int(11) DEFAULT NULL COMMENT '码单id',
  `package_no` varchar(50) DEFAULT NULL COMMENT '码单号',
  `buttress_no` varchar(30) DEFAULT NULL COMMENT '垛号',
  `batchno` varchar(50) DEFAULT NULL COMMENT '货品批号',
  `warehouse_code` varchar(30) DEFAULT NULL COMMENT '仓库编码',
  `location_code` varchar(30) DEFAULT NULL COMMENT '仓库仓位',
  `weight_in` decimal(18,6) DEFAULT '0.000000' COMMENT '重量(入)',
  `qty_in` decimal(18,6) DEFAULT '0.000000' COMMENT '数量(入)',
  `bulkcargo_in` decimal(18,6) DEFAULT '0.000000' COMMENT '散件(入)',
  `weight_out` decimal(18,6) DEFAULT '0.000000' COMMENT '重量(出)',
  `qty_out` decimal(18,6) DEFAULT '0.000000' COMMENT '数量(出)',
  `bulkcargo_out` decimal(18,6) DEFAULT '0.000000' COMMENT '散件(出)',
  `weight` decimal(18,6) DEFAULT '0.000000' COMMENT '重量',
  `qty` decimal(18,6) DEFAULT '0.000000' COMMENT '数量',
  `bulkcargo` decimal(18,6) DEFAULT '0.000000' COMMENT '散件',
  `is_lock` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否锁住:0;否#1;是',
  `lock_time` datetime DEFAULT NULL COMMENT '锁住时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_orgid_packageno_buttressno` (`org_id`,`package_no`,`buttress_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='存储卡垛号';

-- ----------------------------
-- Records of erp_storecard_buttress
-- ----------------------------

-- ----------------------------
-- Table structure for erp_storecard_lock
-- ----------------------------
DROP TABLE IF EXISTS `erp_storecard_lock`;
CREATE TABLE `erp_storecard_lock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `org_id` int(11) DEFAULT NULL COMMENT '库链id',
  `customer_id` int(11) DEFAULT NULL COMMENT '客户id',
  `customer_name` varchar(100) DEFAULT NULL COMMENT '客户名称',
  `storecard_id` int(11) DEFAULT NULL COMMENT '存储卡id',
  `package_id` int(11) DEFAULT NULL COMMENT '码单id',
  `buttress_id` int(11) DEFAULT NULL COMMENT '垛号id',
  `warehouse_code` varchar(30) DEFAULT NULL COMMENT '仓库编码',
  `order_id` int(11) DEFAULT NULL COMMENT '加锁单据id',
  `order_no` varchar(50) DEFAULT NULL COMMENT '加锁号码',
  `order_type` varchar(30) DEFAULT NULL COMMENT '加锁类型',
  `order_date` datetime DEFAULT NULL COMMENT '加锁日期',
  `to_customer_id` int(11) DEFAULT NULL COMMENT '接收方id',
  `to_customer_name` varchar(100) DEFAULT NULL COMMENT '接收方',
  `lock_weight` decimal(18,6) DEFAULT '0.000000' COMMENT '锁重量',
  `lock_qty` decimal(18,6) DEFAULT '0.000000' COMMENT '锁数量',
  `lock_bulkcargo` decimal(18,6) DEFAULT '0.000000' COMMENT '锁散件',
  `storelock_weight` decimal(18,6) DEFAULT '0.000000' COMMENT '合计锁重量',
  `storelock_qty` decimal(18,6) DEFAULT '0.000000' COMMENT '合计锁数量',
  `storelock_bulkcargo` decimal(18,6) DEFAULT '0.000000' COMMENT '合计锁散件',
  `store_weight` decimal(18,6) DEFAULT '0.000000' COMMENT '库存重量',
  `store_qty` decimal(18,6) DEFAULT '0.000000' COMMENT '库存数量',
  `store_bulkcargo` decimal(18,6) DEFAULT '0.000000' COMMENT '库存散件',
  `release_user` varchar(30) DEFAULT NULL COMMENT '释放人员',
  `release_time` datetime DEFAULT NULL COMMENT '释放时间',
  `create_user` varchar(30) DEFAULT NULL COMMENT '创建人员',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_orderno` (`order_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='存储卡加锁';

-- ----------------------------
-- Records of erp_storecard_lock
-- ----------------------------

-- ----------------------------
-- Table structure for erp_storecard_movement
-- ----------------------------
DROP TABLE IF EXISTS `erp_storecard_movement`;
CREATE TABLE `erp_storecard_movement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `org_id` int(11) DEFAULT NULL COMMENT '库链id',
  `customer_id` int(11) DEFAULT NULL COMMENT '客户id',
  `customer_name` varchar(100) DEFAULT NULL COMMENT '客户名称',
  `storecard_id` int(11) DEFAULT NULL COMMENT '存储卡id',
  `storecard_no` varchar(50) DEFAULT NULL COMMENT '存储卡号',
  `warehouse_code` varchar(30) DEFAULT NULL COMMENT '仓库编码',
  `order_id` int(11) DEFAULT NULL COMMENT '单据id',
  `order_no` varchar(50) DEFAULT NULL COMMENT '单据号码',
  `order_type` varchar(30) DEFAULT NULL COMMENT '单据类型',
  `order_date` datetime DEFAULT NULL COMMENT '单据日期',
  `goods_id` int(11) DEFAULT NULL COMMENT '货品ID',
  `goods_no` varchar(50) DEFAULT NULL COMMENT '货品编码',
  `goods_name` varchar(100) DEFAULT NULL COMMENT '货品名称',
  `style_info` varchar(100) DEFAULT NULL COMMENT '规格材质',
  `brand` varchar(50) DEFAULT NULL COMMENT '注册商标',
  `producing_area` varchar(50) DEFAULT NULL COMMENT '货品产地',
  `batchno` varchar(50) DEFAULT NULL COMMENT '货品批号',
  `style_code` varchar(50) DEFAULT NULL COMMENT '规格编码',
  `to_customer_id` int(11) DEFAULT NULL COMMENT '接收方id',
  `to_customer_name` varchar(100) DEFAULT NULL COMMENT '接收方',
  `weight` decimal(18,6) DEFAULT '0.000000' COMMENT '重量',
  `qty` decimal(18,6) DEFAULT '0.000000' COMMENT '数量',
  `bulkcargo` decimal(18,6) DEFAULT '0.000000' COMMENT '散件',
  `store_weight` decimal(18,6) DEFAULT '0.000000' COMMENT '库存重量',
  `store_qty` decimal(18,6) DEFAULT '0.000000' COMMENT '库存数量',
  `store_bulkcargo` decimal(18,6) DEFAULT '0.000000' COMMENT '库存散件',
  `storelock_weight` decimal(18,6) DEFAULT '0.000000' COMMENT '合计锁重量',
  `storelock_qty` decimal(18,6) DEFAULT '0.000000' COMMENT '合计锁数量',
  `storelock_bulkcargo` decimal(18,6) DEFAULT '0.000000' COMMENT '合计锁散件',
  `create_user` varchar(30) DEFAULT NULL COMMENT '创建人员',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `idx_storecardid` (`storecard_id`),
  KEY `idx_storecardno` (`storecard_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='存储卡台账';

-- ----------------------------
-- Records of erp_storecard_movement
-- ----------------------------

-- ----------------------------
-- Table structure for erp_storecard_package
-- ----------------------------
DROP TABLE IF EXISTS `erp_storecard_package`;
CREATE TABLE `erp_storecard_package` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `org_id` int(11) DEFAULT NULL COMMENT '库链id',
  `customer_id` int(11) DEFAULT NULL COMMENT '客户id',
  `storecard_id` int(11) DEFAULT NULL COMMENT '存储卡id',
  `storecard_no` varchar(50) DEFAULT NULL COMMENT '存储卡号',
  `package_no` varchar(50) DEFAULT NULL COMMENT '码单号',
  `customer_name` varchar(100) DEFAULT NULL COMMENT '客户名称',
  `package_from` varchar(50) DEFAULT NULL COMMENT '来源码单',
  `package_orig` varchar(50) DEFAULT NULL COMMENT '原始码单',
  `warehouse_code` varchar(30) DEFAULT NULL COMMENT '仓库编码',
  `location_code` varchar(30) DEFAULT NULL COMMENT '仓库仓位',
  `location_futures` varchar(30) DEFAULT NULL COMMENT '期货仓位',
  `stock_date` datetime DEFAULT NULL COMMENT '入库日期',
  `stock_order` varchar(50) DEFAULT NULL COMMENT '入库单号',
  `arrival_type` varchar(30) DEFAULT NULL COMMENT '到货方式',
  `stock_type` varchar(30) DEFAULT NULL COMMENT '存储方式',
  `carno` varchar(50) DEFAULT NULL COMMENT '车厢号',
  `weight_in` decimal(18,6) DEFAULT '0.000000' COMMENT '重量(入)',
  `qty_in` decimal(18,6) DEFAULT '0.000000' COMMENT '数量(入)',
  `bulkcargo_In` decimal(18,6) DEFAULT '0.000000' COMMENT '散件(入)',
  `weight_out` decimal(18,6) DEFAULT '0.000000' COMMENT '重量(出)',
  `qty_out` decimal(18,6) DEFAULT '0.000000' COMMENT '数量(出)',
  `bulkcargo_out` decimal(18,6) DEFAULT '0.000000' COMMENT '散件(出)',
  `weight` decimal(18,6) DEFAULT '0.000000' COMMENT '重量',
  `qty` decimal(18,6) DEFAULT '0.000000' COMMENT '数量',
  `bulkcargo` decimal(18,6) DEFAULT '0.000000' COMMENT '散件',
  `status` varchar(30) DEFAULT NULL COMMENT '状态:0;无效#1;有效',
  `create_user` varchar(30) DEFAULT NULL COMMENT '创建人员',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `modify_user` varchar(30) DEFAULT NULL COMMENT '修改人员',
  `modify_time` datetime DEFAULT NULL COMMENT '修改时间',
  `is_lock` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否锁住:0;否#1;是',
  `lock_time` datetime DEFAULT NULL COMMENT '锁住时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_orgid_packageno` (`org_id`,`package_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='存储卡码单';

-- ----------------------------
-- Records of erp_storecard_package
-- ----------------------------

-- ----------------------------
-- Table structure for erp_subcode
-- ----------------------------
DROP TABLE IF EXISTS `erp_subcode`;
CREATE TABLE `erp_subcode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(30) DEFAULT NULL COMMENT '分类',
  `parent_id` int(11) DEFAULT '0' COMMENT '父层ID',
  `code` varchar(30) DEFAULT NULL COMMENT '代码',
  `name` varchar(100) DEFAULT NULL COMMENT '名称',
  `value` varchar(200) DEFAULT NULL COMMENT '参数',
  `sort` int(11) DEFAULT '9999' COMMENT '排序',
  `is_system` tinyint(4) NOT NULL DEFAULT '0' COMMENT '系统定义:1;是#0;否',
  `status` varchar(30) DEFAULT NULL COMMENT '状态:1;有效#0;无效',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `create_user` varchar(30) DEFAULT NULL COMMENT '创建人员',
  `modify_time` datetime DEFAULT NULL COMMENT '修改时间',
  `modify_user` varchar(30) DEFAULT NULL COMMENT '修改人员',
  `lastchanged` timestamp(6) NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6) COMMENT '更改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_type_code` (`type`,`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统分类';

-- ----------------------------
-- Records of erp_subcode
-- ----------------------------

-- ----------------------------
-- Table structure for erp_system_gen
-- ----------------------------
DROP TABLE IF EXISTS `erp_system_gen`;
CREATE TABLE `erp_system_gen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(30) DEFAULT NULL COMMENT '类型',
  `mainkey` varchar(50) DEFAULT NULL COMMENT '主键',
  `subkey` varchar(50) DEFAULT NULL COMMENT '子键',
  `seqno` int(11) DEFAULT '0' COMMENT '最后序号',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `modify_time` datetime DEFAULT NULL COMMENT '修改时间',
  `lastchanged` timestamp(6) NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6) COMMENT '更改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_type_mainkey_subkey` (`type`,`mainkey`,`subkey`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统序号';

-- ----------------------------
-- Records of erp_system_gen
-- ----------------------------

-- ----------------------------
-- Table structure for erp_system_parameter
-- ----------------------------
DROP TABLE IF EXISTS `erp_system_parameter`;
CREATE TABLE `erp_system_parameter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(30) DEFAULT NULL COMMENT '类型:trade;交易#panel;平台',
  `code` varchar(30) DEFAULT NULL COMMENT '代码',
  `name` varchar(100) DEFAULT NULL COMMENT '名称',
  `value` varchar(200) DEFAULT NULL COMMENT '数据',
  `status` varchar(30) DEFAULT NULL COMMENT '状态:1;有效#0;无效',
  `remarks` text COMMENT '说明',
  `sort` int(11) DEFAULT '9999' COMMENT '排序',
  `allow_edit` tinyint(4) NOT NULL DEFAULT '0' COMMENT '允许编辑:1;允许#0;禁止',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统参数';

-- ----------------------------
-- Records of erp_system_parameter
-- ----------------------------

-- ----------------------------
-- Table structure for erp_trade
-- ----------------------------
DROP TABLE IF EXISTS `erp_trade`;
CREATE TABLE `erp_trade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `org_id` int(11) DEFAULT NULL COMMENT '库链id',
  `warehouse_code` varchar(30) DEFAULT NULL COMMENT '仓库编码',
  `customer_id` int(11) DEFAULT NULL COMMENT '卖出客户id',
  `customer_name` varchar(100) DEFAULT NULL COMMENT '卖出客户',
  `buyer_id` int(11) DEFAULT NULL COMMENT '买入客户id',
  `buyer_name` varchar(100) DEFAULT NULL COMMENT '买入客户',
  `trade_no` varchar(50) DEFAULT NULL COMMENT '交易单号',
  `tx_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '交易类型:0;过户#1;提货',
  `tx_date` datetime DEFAULT NULL COMMENT '开单日期',
  `expired_time` datetime DEFAULT NULL COMMENT '截至时间',
  `contract_no` varchar(50) DEFAULT NULL COMMENT '合同号码',
  `contract_date` datetime DEFAULT NULL COMMENT '合同日期',
  `is_real` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否实物:0;否#1;是',
  `chain_id` int(11) DEFAULT NULL COMMENT '交易链id',
  `goods_id` int(11) DEFAULT NULL COMMENT '货品ID',
  `goods_no` varchar(50) DEFAULT NULL COMMENT '货品编码',
  `goods_name` varchar(100) DEFAULT NULL COMMENT '货品名称',
  `style_info` varchar(100) DEFAULT NULL COMMENT '规格材质',
  `brand` varchar(50) DEFAULT NULL COMMENT '注册商标',
  `producing_area` varchar(50) DEFAULT NULL COMMENT '货品产地',
  `style_code` varchar(50) DEFAULT NULL COMMENT '规格编码',
  `weight` decimal(18,6) DEFAULT '0.000000' COMMENT '重量',
  `price` decimal(18,3) DEFAULT '0.000' COMMENT '含税价格',
  `amount` decimal(18,2) DEFAULT '0.00' COMMENT '交易金额',
  `confirm_status` tinyint(11) NOT NULL DEFAULT '0' COMMENT '交易确认:0;无#1;等买家付款#2;等卖家收款#3;完成',
  `confirm_payment` decimal(18,2) DEFAULT '0.00' COMMENT '确认付款, 注释:付款方登记金额',
  `confirm_receive` decimal(18,2) DEFAULT '0.00' COMMENT '确认收款, 注释:收款方登记金额',
  `delivery_no` varchar(50) DEFAULT NULL COMMENT '提货单号',
  `delivery_company` varchar(100) DEFAULT NULL COMMENT '提货公司',
  `delivery_carno` varchar(50) DEFAULT NULL COMMENT '提货车号',
  `delivery_contact` varchar(50) DEFAULT NULL COMMENT '提货人员',
  `delivery_phone` varchar(50) DEFAULT NULL COMMENT '提货电话',
  `delivery_idcard` varchar(50) DEFAULT NULL COMMENT '提货身份证',
  `delivery_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '发货方式:0;无#1;不超发#2;不少发#3;留一件#4;清卡#5;其他',
  `delivery_info` text COMMENT '发货说明',
  `assign_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '配货标志:0;否#1;配货中#2;完成',
  `assign_time` datetime DEFAULT NULL COMMENT '配货时间',
  `assign_user` varchar(30) DEFAULT NULL COMMENT '配货人员',
  `assign_weight` decimal(18,6) DEFAULT '0.000000' COMMENT '配货重量',
  `assign_qty` decimal(18,6) DEFAULT '0.000000' COMMENT '配货数量',
  `assign_bulkcargo` decimal(18,6) DEFAULT '0.000000' COMMENT '配货散件',
  `buyer_storecard_id` int(11) DEFAULT NULL COMMENT '收货卡id',
  `buyer_storecard_no` varchar(50) DEFAULT NULL COMMENT '收货卡号',
  `buyer_storecard_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '收货追加:0;不允许#1;允许',
  `act_weight` decimal(18,6) DEFAULT '0.000000' COMMENT '实发重量',
  `act_qty` decimal(18,6) DEFAULT '0.000000' COMMENT '实发数量',
  `act_bulkcargo` decimal(18,6) DEFAULT '0.000000' COMMENT '实发散件',
  `diff_weight` decimal(18,6) DEFAULT '0.000000' COMMENT '重量差异',
  `diff_amount` decimal(18,6) DEFAULT '0.000000' COMMENT '补差金额',
  `diff_status` tinyint(11) NOT NULL DEFAULT '0' COMMENT '补差确认:0;无#1;等待卖家退款#2;等待买家收款#3;等待买家退款#4;等待卖家收款#5;退款完成',
  `diff_payment` decimal(18,2) DEFAULT '0.00' COMMENT '补差付款',
  `diff_receive` decimal(18,2) DEFAULT '0.00' COMMENT '补差收款',
  `interface_status` tinyint(11) NOT NULL DEFAULT '0' COMMENT '仓库接口:0;无#1;等待发送仓库#2;已发送仓库#3;仓库处理返回',
  `interface_process` tinyint(11) NOT NULL DEFAULT '0' COMMENT '接口处理:0;无#1;失败#2;成功',
  `interface_time` datetime DEFAULT NULL COMMENT '接口时间',
  `interface_result` text COMMENT '接口信息',
  `uom_weight` varchar(30) DEFAULT NULL COMMENT '重量单位',
  `uom_qty` varchar(30) DEFAULT NULL COMMENT '数量单位',
  `uom_bulkcargo` varchar(30) DEFAULT NULL COMMENT '散件单位',
  `customer_msg` text COMMENT '卖家消息',
  `buyer_msg` text COMMENT '买家消息',
  `remarks` text COMMENT '备注',
  `status` varchar(30) DEFAULT NULL COMMENT '状态:0;草稿#1;等待款项确认#2;等待配货#3;等待仓库#4;仓库处理中#5;等待补差确认#6;交易完成#7;已取消#8;已失效',
  `create_user` varchar(30) DEFAULT NULL COMMENT '创建人员',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `modify_user` varchar(30) DEFAULT NULL COMMENT '修改人员',
  `modify_time` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_tradeno` (`trade_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='交易开单';

-- ----------------------------
-- Records of erp_trade
-- ----------------------------

-- ----------------------------
-- Table structure for erp_trade_assign
-- ----------------------------
DROP TABLE IF EXISTS `erp_trade_assign`;
CREATE TABLE `erp_trade_assign` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `org_id` int(11) DEFAULT NULL COMMENT '库链id',
  `customer_id` int(11) DEFAULT NULL COMMENT '客户id',
  `customer_name` varchar(100) DEFAULT NULL COMMENT '客户名称',
  `trade_id` int(11) DEFAULT NULL COMMENT '交易单id',
  `trade_no` varchar(50) DEFAULT NULL COMMENT '交易单号',
  `warehouse_code` varchar(30) DEFAULT NULL COMMENT '仓库编码',
  `storecard_id` int(11) DEFAULT NULL COMMENT '存储卡id',
  `storecard_no` varchar(50) DEFAULT NULL COMMENT '存储卡号',
  `weight` decimal(18,6) DEFAULT '0.000000' COMMENT '重量',
  `qty` decimal(18,6) DEFAULT '0.000000' COMMENT '数量',
  `bulkcargo` decimal(18,6) DEFAULT '0.000000' COMMENT '散件',
  `lock_time` datetime DEFAULT NULL COMMENT '锁定时间',
  `release_time` datetime DEFAULT NULL COMMENT '释放时间',
  `act_weight` decimal(18,6) DEFAULT '0.000000' COMMENT '实发重量',
  `act_qty` decimal(18,6) DEFAULT '0.000000' COMMENT '实发数量',
  `act_bulkcargo` decimal(18,6) DEFAULT '0.000000' COMMENT '实发散件',
  `act_time` datetime DEFAULT NULL COMMENT '扣除时间',
  `buyer_storecard_id` int(11) DEFAULT NULL COMMENT '买家存储卡id',
  `buyer_storecard_no` varchar(50) DEFAULT NULL COMMENT '买家存储卡',
  `remarks` text COMMENT '备注, 注释:实发部分，未实发释放',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `status` varchar(30) DEFAULT NULL COMMENT '状态:0;否#1;库存锁定#2;释放扣除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='交易配货';

-- ----------------------------
-- Records of erp_trade_assign
-- ----------------------------

-- ----------------------------
-- Table structure for erp_transfer
-- ----------------------------
DROP TABLE IF EXISTS `erp_transfer`;
CREATE TABLE `erp_transfer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `org_id` int(11) DEFAULT NULL COMMENT '库链id',
  `customer_id` int(11) DEFAULT NULL COMMENT '客户id',
  `customer_name` varchar(100) DEFAULT NULL COMMENT '客户名称',
  `tx_date` datetime DEFAULT NULL COMMENT '开单日期',
  `transfer_no` varchar(50) DEFAULT NULL COMMENT '过户单号',
  `transfer_date` datetime DEFAULT NULL COMMENT '过户日期',
  `to_customer_id` int(11) DEFAULT NULL COMMENT '过入客户id',
  `to_customer_name` varchar(100) DEFAULT NULL COMMENT '过入客户',
  `warehouse_code` varchar(30) DEFAULT NULL COMMENT '仓库编码',
  `goods_id` int(11) DEFAULT NULL COMMENT '货品ID',
  `goods_no` varchar(50) DEFAULT NULL COMMENT '货品编码',
  `goods_name` varchar(100) DEFAULT NULL COMMENT '货品名称',
  `style_info` varchar(100) DEFAULT NULL COMMENT '规格材质',
  `brand` varchar(50) DEFAULT NULL COMMENT '注册商标',
  `producing_area` varchar(50) DEFAULT NULL COMMENT '货品产地',
  `style_code` varchar(50) DEFAULT NULL COMMENT '规格编码',
  `weight` decimal(18,6) DEFAULT '0.000000' COMMENT '重量',
  `qty` decimal(18,6) DEFAULT '0.000000' COMMENT '数量',
  `bulkcargo` decimal(18,6) DEFAULT '0.000000' COMMENT '散件',
  `uom_qty` varchar(30) DEFAULT NULL COMMENT '数量单位',
  `uom_weight` varchar(30) DEFAULT NULL COMMENT '重量单位',
  `uom_bulkcargo` varchar(30) DEFAULT NULL COMMENT '散件单位',
  `remarks` text COMMENT '备注',
  `status` varchar(30) DEFAULT NULL COMMENT '状态:0;草稿#1;有效#2;结束#7;取消#8;失效',
  `payment_customer_id` int(11) DEFAULT NULL COMMENT '付款客户id',
  `payment_customer` varchar(100) DEFAULT NULL COMMENT '付款客户',
  `payment_info` text COMMENT '付款内容',
  `payment_path` varchar(200) DEFAULT NULL COMMENT '付款图像',
  `buyer_storecard_id` int(11) DEFAULT NULL COMMENT '收货卡id',
  `buyer_storecard_no` varchar(50) DEFAULT NULL COMMENT '收货卡号',
  `isself` tinyint(4) NOT NULL DEFAULT '0' COMMENT '过给自己:0;否#1;是',
  `to_path` text COMMENT 'to_path',
  `checkTime` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_transferno` (`transfer_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='过户';

-- ----------------------------
-- Records of erp_transfer
-- ----------------------------

-- ----------------------------
-- Table structure for erp_transfer_storagecard
-- ----------------------------
DROP TABLE IF EXISTS `erp_transfer_storagecard`;
CREATE TABLE `erp_transfer_storagecard` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `org_id` int(11) DEFAULT NULL COMMENT '库链id',
  `customer_id` int(11) DEFAULT NULL COMMENT '客户id',
  `storecard_id` int(11) DEFAULT NULL COMMENT '存储卡id',
  `storecard_no` varchar(50) DEFAULT NULL COMMENT '存储卡号',
  `weight` decimal(18,6) DEFAULT '0.000000' COMMENT '重量',
  `qty` decimal(18,6) DEFAULT '0.000000' COMMENT '数量',
  `bulkcargo` decimal(18,6) DEFAULT '0.000000' COMMENT '散件',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='过户存储卡';

-- ----------------------------
-- Records of erp_transfer_storagecard
-- ----------------------------

-- ----------------------------
-- Table structure for erp_user
-- ----------------------------
DROP TABLE IF EXISTS `erp_user`;
CREATE TABLE `erp_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `side` tinyint(4) NOT NULL DEFAULT '0' COMMENT '类型:0;平台#1;机构#2;客户',
  `org_id` int(11) DEFAULT NULL COMMENT '库链id',
  `customer_id` int(11) DEFAULT NULL COMMENT '客户id',
  `status` varchar(30) DEFAULT NULL COMMENT '状态:1;有效#0;无效',
  `code` varchar(30) DEFAULT NULL COMMENT '用户',
  `name` varchar(100) DEFAULT NULL COMMENT '姓名',
  `sex` tinyint(4) NOT NULL DEFAULT '0' COMMENT '性别:1;男#0;女#2;保密',
  `header_ico` varchar(100) DEFAULT NULL COMMENT '头像',
  `level` tinyint(4) NOT NULL DEFAULT '0' COMMENT '级别:0;输入#1;审核',
  `password` varchar(50) DEFAULT NULL COMMENT '加密密码',
  `passwordsource` varchar(50) DEFAULT NULL COMMENT '登入密码',
  `mobilephone` varchar(50) DEFAULT NULL COMMENT '手机号码',
  `superadmin` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否管理员:0;否#1;是',
  `errpwd_count` int(11) DEFAULT '0' COMMENT '密码错误次数',
  `sort` int(11) DEFAULT '9999' COMMENT '排序',
  `remarks` text COMMENT '备注',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `create_user` varchar(30) DEFAULT NULL COMMENT '创建人员',
  `modify_time` datetime DEFAULT NULL COMMENT '修改时间',
  `modify_user` varchar(30) DEFAULT NULL COMMENT '修改人员',
  `lastchanged` timestamp(6) NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6) COMMENT '更改时间',
  `session_id` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_orgid_customerid_code` (`org_id`,`customer_id`,`code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户信息';

-- ----------------------------
-- Records of erp_user
-- ----------------------------
INSERT INTO `erp_user` VALUES ('1', '1', null, null, '1', 'admin', 'admin', '0', null, '0', 'e10adc3949ba59abbe56e057f20f883e', '111111', null, '1', '0', '9999', null, null, null, null, null, '2019-06-05 12:37:46.047413', 'e4873aab9fb13c7d3a43445f31d98ead');

-- ----------------------------
-- Table structure for erp_user_summary_column
-- ----------------------------
DROP TABLE IF EXISTS `erp_user_summary_column`;
CREATE TABLE `erp_user_summary_column` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_code` varchar(30) DEFAULT NULL COMMENT '用户代码',
  `summary` varchar(50) DEFAULT NULL COMMENT '列表名称',
  `column` varchar(200) DEFAULT NULL COMMENT '数据列',
  `show` tinyint(4) DEFAULT '0' COMMENT '显示:0;隐藏#1;显示',
  `sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户列表显示设置';

-- ----------------------------
-- Records of erp_user_summary_column
-- ----------------------------

-- ----------------------------
-- Table structure for erp_warehouse
-- ----------------------------
DROP TABLE IF EXISTS `erp_warehouse`;
CREATE TABLE `erp_warehouse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `org_id` int(11) DEFAULT NULL COMMENT '库链id',
  `code` varchar(30) DEFAULT NULL COMMENT '仓库编码',
  `name` varchar(100) DEFAULT NULL COMMENT '仓库名称',
  `phone` varchar(50) DEFAULT NULL COMMENT '联系电话',
  `contacts` varchar(50) DEFAULT NULL COMMENT '联系人员',
  `address` varchar(200) DEFAULT NULL COMMENT '联系地址',
  `status` varchar(30) DEFAULT NULL COMMENT '状态:0;无效#1;有效',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `create_user` varchar(30) DEFAULT NULL COMMENT '创建人员',
  `modify_time` datetime DEFAULT NULL COMMENT '修改时间',
  `modify_user` varchar(30) DEFAULT NULL COMMENT '修改人员',
  `lastchanged` timestamp(6) NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6) COMMENT '更改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='仓库信息';

-- ----------------------------
-- Records of erp_warehouse
-- ----------------------------
