<?php
	
	//获取设备状态信息
	function  getDeviceStatus($status)
	{
		$device=D('Home/Device');
		$status_arr=$device->getStatus();
		$arr=array();
		$arr=array_reduce($status_arr, create_function('$v,$w', '$v[$w["id"]]=$w["title"];return $v;'));
	
		//0空闲/1在用/2维护/3失效
		//$arr = array (0 => '空闲',1=>'在用', 2 => '维护', 3 => '失效' );
		return isset ( $arr [$status] ) ? $arr [$status] : '未知状态';
	}

function getTitleName($name){

    $title=array(
        'Activity'=>"活动",
        'Area'=>"地区",
        'Brand'=>"品牌",
        'Category'=>"分类",
        'Customer'=>"供应商",
        'Deliver'=>"快递",
        'Department'=>"部门",
        'HangupTag'=>"挂起",
        'OrderSwitch'=>"转单",
        'OrderTag'=>"订单标签",
        'Payment'=>"支付方式",
        'Platform'=>"销售平台",
        'ReturnReason'=>"退货原因",
        'Season'=>"季节",
        'Shop'=>"店铺",
        'Storage'=>"仓库",
        'Style1'=>"颜色",
        'Style2'=>"尺码",
        'User'=>"用户",
        'Year'=>"年份",


    );

    return $title[$name];
}

	class PlatformType {
		public static $TB = "taobao";
		public static $JD = "jingdong";
		public static $TM = "TM";
		public static $QT = "QT";
	}
	
	class OrderType {
		public static $web = 1;
		public static $sales = 2;
		public static $purchase = 3;
		public static $stockIn = 4;
		public static $stockOut = 5;
		public static $move = 6;
		public static $adjustment = 7;
		public static $check = 8;
		public static $apiupdate = 9;
	}
	
	class ConfirmType {
		public static $message_buyer = 1;
		public static $message_seller = 2;
		public static $buyer_blacklist = 3;
		public static $invoiced = 4;
		public static $area_foreign = 5;
		public static $area_gangaotai = 6;
		public static $change_makeup_pay = 7;
		public static $change_jingdong = 8;
		public static $problem_address = 9;
		public static $goods_forpost = 10;
		public static $refund_all = 11;
		public static $refund_partial = 12;
		public static $manual_order = 13;
	}
	
	function getConfirmTypeInfo() {
		return $ConfirmTypeInfo = array(
				ConfirmType::$message_buyer =>array("control"=>false, "msg"=>"存在买家留言"),
				ConfirmType::$message_seller => array("control"=>false, "msg"=>"存在卖家留言"),
				ConfirmType::$buyer_blacklist => array("control"=>false, "msg"=>"买家在黑名单中"),
				ConfirmType::$invoiced => array("control"=>false, "msg"=>"需要开发票"),
				ConfirmType::$area_foreign => array("control"=>false, "msg"=>"外国订单"),
				ConfirmType::$area_gangaotai => array("control"=>false, "msg"=>"港澳台订单"),
				ConfirmType::$change_makeup_pay => array("control"=>false, "msg"=>"换货补款"),
				ConfirmType::$change_jingdong => array("control"=>false, "msg"=>"京东换货"),
				ConfirmType::$problem_address => array("control"=>false, "msg"=>"地址问题"),
				ConfirmType::$goods_forpost => array("control"=>false, "msg"=>"存在补邮商品"),
				ConfirmType::$refund_all => array("control"=>false, "msg"=>"申请退款(整单)"),
				ConfirmType::$refund_partial => array("control"=>false, "msg"=>"申请退款(部分)")
		);
	}

	function gettradeno($order_id, $ordertype) {
		switch ($ordertype) {
			case OrderType::$web = 1;
				return M("web_trade")->where("id = $order_id")->getField("trade_no");
			case OrderType::$sales = 2;
				return M("sales")->where("id = $order_id")->getField("trade_no");
			case OrderType::$purchase = 3;
				return "";
			case OrderType::$stockIn = 4;
				return "";
			case OrderType::$stockOut = 5;
				return "";
			case OrderType::$move = 6;
				return "";
			case OrderType::$adjustment = 7;
				return "";
			case OrderType::$check = 8;
				return "";
			case OrderType::$apiupdate = 9;
				return "";
			break;
		}
	}

    function GenOrderNo_Setting($table="") {
        $prefix="WMS-";
        $prefix="";
/*

   key - 表单名称，也可以是特定的动作名称
       pre : 单号前缀缩写
       random : 0系统格式、1随机时间号码
       style : 按month月份/按year年份/按无时间all/none无
       length : 非random=0下有效，次序码长度，不足前补0
       url : 调用地址
 */


        $arr = array("sales"=>array('pre'=> $prefix.'XS','random'=>'0','style'=>'month','length'=>6 , 'url'=>U('/Home/Sales/index/func/view')),
            "sales_refund"=>array('pre'=> $prefix."XT",'random'=>'0','style'=>'month','length'=>6 , 'url'=>U('/Home/SalesRefund/index/func/view')),
            "purchase"=>array('pre'=> $prefix."JH",'random'=>'0','style'=>'month','length'=>6 , 'url'=>U('/Home/Purchase/index/func/view')),
            "purchase_return"=>array('pre'=> $prefix."JT",'random'=>'0','style'=>'month','length'=>6 , 'url'=>U('/Home/PurchaseReturn/index/func/view')),
            "production"=>array('pre'=> $prefix."PP",'random'=>'0','style'=>'month','length'=>6 , 'url'=>U('/Home/Production/index/func/view')),
            "production_assign"=>array('pre'=> $prefix."PA",'random'=>'0','style'=>'month','length'=>6 , 'url'=>U('/Home/ProductionAssign/index/func/view')),
            "production_qc"=>array('pre'=> $prefix."PQ",'random'=>'0','style'=>'month','length'=>6 , 'url'=>U('/Home/ProductionQc/index/func/view')),
            "production_hour"=>array('pre'=> $prefix."PH",'random'=>'0','style'=>'month','length'=>6 , 'url'=>U('/Home/ProductionHour/index/func/view')),
            "production_stock"=>array('pre'=> $prefix."PS",'random'=>'0','style'=>'month','length'=>6 , 'url'=>U('/Home/ProductionStock/index/func/view')),
            "production_reg"=>array('pre'=> $prefix."PR",'random'=>'0','style'=>'month','length'=>6 , 'url'=>U('/Home/ProductionReg/index/func/view')),
            "stock_in"=>array('pre'=> $prefix."SI",'random'=>'0','style'=>'month','length'=>6 , 'url'=>U('/Home/StockIn/index/func/view')),
            "stock_out"=>array('pre'=> $prefix."SO",'random'=>'0','style'=>'month','length'=>6 , 'url'=>U('/Home/StockOut/index/func/view')),
            "stock_move"=>array('pre'=> $prefix."SM",'random'=>'0','style'=>'month','length'=>6 , 'url'=>U('/Home/StockMove/index/func/view')),
            "stock_adjust"=>array('pre'=> $prefix."SA",'random'=>'0','style'=>'month','length'=>6 , 'url'=>U('/Home/StockAdjust/index/func/view')),
            "stock_check"=>array('pre'=> $prefix."SC",'random'=>'0','style'=>'month','length'=>6 , 'url'=>U('/Home/StockCheck/index/func/view')),
            "logistic"=>array('pre'=> $prefix."LG",'random'=>'0','style'=>'month','length'=>6 , 'url'=>U('/Home/Logistic/index/func/view')),
            "fund"=>array('pre'=> $prefix."FD",'random'=>'0','style'=>'month','length'=>6 , 'url'=>U('/Home/Fund/index/func/view')),
            "retail"=>array('pre'=> $prefix."RT",'random'=>'0','style'=>'month','length'=>6 , 'url'=>U('/Home/Retail/index/func/view')),
            "trade"=>array('pre'=> $prefix."TD",'random'=>'0','style'=>'month','length'=>6 , 'url'=>U('/Home/Trade/index/func/view')),
            "payment"=>array('pre'=> $prefix."PN",'random'=>'0','style'=>'month','length'=>6 , 'url'=>U('/Home/Payment/index/func/view')),
            "delivery"=>array('pre'=> $prefix."DV",'random'=>'0','style'=>'month','length'=>6 , 'url'=>U('/Home/Payment/index/func/view')),
            "exam"=>array('pre'=> $prefix."EX",'random'=>'0','style'=>'month','length'=>6 , 'url'=>U('/Home/Exam/index/func/view')),
            "chain"=>array('pre'=> $prefix."CH",'random'=>'0','style'=>'month','length'=>6 , 'url'=>U('/Home/Exam/index/func/view'))
            );


        $table=trim(strtolower($table));
        if(strlen($table)>0){
            if (isset($arr[$table])){
                return $arr[$table];
            }else{
                return false;
            }
        }else{
            return $arr;
        }
    }

    function GenOrderNo_GetPrefix($table)
    {
        $setting=GenOrderNo_Setting($table);
        if($setting){
            return $setting["pre"];
        }else{
            return "";
        }
    }

    function GenOrderNo_ByExist($table,$exist_table,  $exist_order_no, $org_id=0)
    {
        $table_pre = GenOrderNo_GetPrefix($table);
        $exist_pre = GenOrderNo_GetPrefix($exist_table);

        if (substr($exist_order_no, 0, strlen($exist_pre)) == $exist_pre) {
            return $table_pre . substr($exist_order_no, strlen($exist_pre));
        } else {
            return GenOrderNo($table,$org_id);
        }
    }

	function GenOrderNo($table, $org_id=0, &$err="")
	{
	    //原来利用参数 $gettype 读取数组，及返回$prefix ，请直接使用 GenOrderNo_Setting($table)
        $err="";
        $org_abbr="";
        if($org_id){
            $ret=M("org")->field("code,status")->find($org_id);//查询库链联盟机构表中的代码机构（code）和状态值 根据org的id查询
            if(!$ret){
                $err="联盟不存在";
                return false;
            }
            if($ret["status"]!=1){
                $err="联盟状态非法";
                return false;
            }
            $org_abbr=$ret["code"];
        }

        $setting= GenOrderNo_Setting($table);
        if(!$setting){
            return false;
        }
        $time = "";   //日期字符串
        if($setting["style"]=="year") {
            $time = date("Y");
        }else if($setting["style"]=="month") {
            $time = date("Ym");
        }
        $pre= $setting["pre"];
        $len = $setting["length"];
        if($setting["random"]){
            list($a1,$a2) = explode(" ", microtime());
            $a = (float)((float)$a1+(float)$a2);
            $a = str_replace(".", "", $a);
            $seq=$a.rand(100, 999);
        }else{
            $seq = Gen_Number($table,$time,$org_abbr);
            if($seq<pow(10,$len))
                $seq =str_pad($seq,$len,"0",STR_PAD_LEFT);
        }

        if($setting["style"]!="none" && $setting["style"]){
            if($time){
                $seq="-".substr($time,2)."-".$seq ;
            }else{
                $seq="-".$seq;
            }
        }
		return  $pre.$org_abbr.$seq;
	}

	function GenPrintNo()
	{
		list($a1,$a2) = explode(" ", microtime());
		$a = (float)((float)$a1+(float)$a2);
		$a = str_replace(".", "", $a);
		$orderno=$a.rand(100, 999);
		return  $orderno;
	}

    function getOrderType($type){
        return OrderType::$$type;
    }

    function getError($err){

        $err=explode("_",$err);
        $err_type=$err[0];
        $err_detail=$err[1];


        $global_err_list=array(
            'SUCCESS'=>array('1'=>'处理成功',),
            'CHECKERR'=>array('0'=>'校验错误',),
            'SAVEERR'=>array('-1'=>'数据存储时错误',),
            'FIELDERR'=>array('-10001'=>'字段错误',),
            'RECORDERR'=>array('-10002'=>'记录错误',),
            'FARMATERR'=>array('-10003'=>'接口格式错误',),
            'PERMISSERR'=>array('-10004'=>'权限错误',),
            'UNKNOWERR'=>array('-999999'=>'未知错误',),
        );

        if(trim($err_type)=='' || !isset($global_err_list[$err_type]))
            $err_type='UNKNOWERR';
        if(trim($err_detail)=='')
            $err_detail='UNKNOWERR';

        $status=key($global_err_list[$err_type]);
        $msg=$global_err_list[$err_type][$status];
        $direct=array('SUCCESS','CHECKERR','SAVEERR','UNKNOWERR');
        if(in_array($err_type,$direct)){
            return array('status'=>$status,'message'=>$msg);
        }




        $field_err_list=array(
            'EMPTY'=>array('01'=>'必填字段为空'),
            'TYPE'=>array('02'=>'类型不正确'),
            'INFO'=>array('03'=>'信息不匹配'),
            'NEGATIVE'=>array('04'=>'数量必须非负'),
            'QTYMOREPURCHASE'=>array('05'=>'数量大于采购数量'),
            'MODEINVALID'=>array('06'=>'模式不正确'),
            'QTYNEQPURCHASE'=>array('07'=>'数量不等于采购数量'),
            'QTYNEQDETAILQTY'=>array('08'=>'数量不等于详细数量'),
            'PURCHASEDETAILINFO'=>array('09'=>'采购单商品与API商品信息不匹配'),
            'QTYNEQORDERQTY'=>array('10'=>'数量与通知数量不一致'),
            'UNKNOWERR'=>array('99'=>'未知错误',),
        );

        $record_err_list=array(
            'EMPTY'=>array('01'=>'记录不存在'),
            'NONEMPTY'=>array('02'=>'记录已存在'),
            'INVALID'=>array('03'=>'单据非有效状态'),
            'UNKNOWERR'=>array('99'=>'未知错误',),
        );

        $permiss_err_list=array(
            'EMPTY'=>array('01'=>'没有接口操作权限'),
            'NONRANGE'=>array('02'=>'不在接口范围'),
            'UNKNOWERR'=>array('99'=>'未知错误',),
        );

        $farmat_err_list=array(
            'INVALID'=>array('01'=>'非有效JSON格式'),
            'UNKNOWERR'=>array('99'=>'未知错误',),
        );


        switch($err_type){
            case 'FIELDERR':
                $err_detail=isset($field_err_list[$err_detail])?$field_err_list[$err_detail]:$field_err_list['UNKNOWERR'];
                break;
            case 'RECORDERR':
                $err_detail=isset($record_err_list[$err_detail])?$record_err_list[$err_detail]:$record_err_list['UNKNOWERR'];
                break;
            case 'FARMATERR':
                $err_detail=isset($farmat_err_list[$err_detail])?$farmat_err_list[$err_detail]:$farmat_err_list['UNKNOWERR'];
                break;
            case 'PERMISSERR':
                $err_detail=isset($permiss_err_list[$err_detail])?$permiss_err_list[$err_detail]:$permiss_err_list['UNKNOWERR'];
                break;
        }


        $status.=".".key($err_detail);
        $msg.=".".$err_detail[key($err_detail)];

        return array('status'=>$status,'message'=>$msg);
    }


	function orderurl($source_no,$folder="") {
		
		$arr = GenOrderNo("", true);
		
		foreach($arr as $k=>$v) {
			if($v["pre"] == substr($source_no, 0, strlen($v["pre"]))) {
				$url = $v["url"];
				if(strpos($url, "?") === false) {
					$url .= "?no=".$source_no;
				} else {
					$url .= "&no=".$source_no;
				}
				if($folder!="" && $folder!="/Home/"){
          $url = str_replace("/Home/",$folder,$url);					
				}
				return $url;
			}
		}
		
		//临时使用，解决测试中单据问题
		$arr = GenOrderNo("", true, $prefix);
		
		foreach($arr as $k=>$v) {
			 $v["pre"] = str_replace($prefix,"",$v["pre"]);
			if($v["pre"] == substr($source_no, 0, strlen($v["pre"]))) {
				$url = $v["url"];
				if(strpos($url, "?") === false) {
					$url .= "?no=".$source_no;
				} else {
					$url .= "&no=".$source_no;
				}
				if($folder!="" && $folder!="/Home/"){
          $url = str_replace("/Home/",$folder,$url);					
				}
				return $url;
			}
		}
		
		return "1";
	}

	function updateservcie($service_code) {
		$service = M("service")->where("service_code = '$service_code'")->find();
		if(!empty($service)) {
			$now = strtotime(date("Y-m-d H:i:s"));
			$next = strtotime("+".$service["run_period"]." minutes");
			M("service")->where("service_code = '$service_code'")->save(array("last_run_time"=>date("Y-m-d H:i:s"), "next_run_time"=>date("Y-m-d H:i:s", $next)));
		}
	}
	

	function clean_data() {
		$SERVICE_CODE = "clean_data";
		$pre = C("DB_PREFIX");
		$sql[] = "truncate table ".$pre."log_webtrade";
		

		foreach($sql as $s) {
			M()->execute($s);
		}
		
		updateservcie($SERVICE_CODE);
	}
	
	function log_webtrade($web_trade_id, $type, $subject, $reason, $on_batch, $content_before, $content_after) {
		$weborder = M("web_trade")->where("id=$web_trade_id")->find();
		if(empty($weborder)) {
			return false;
		}
		
		$platform = M("platform")->where("code = '".$weborder["platform_code"]."'")->find();
		if(empty($platform)) {
			return false;
		}
		
		$data["web_trade_id"] = $web_trade_id;
		$data["trade_no"] = $weborder["trade_no"];
		$data["platform_code"] = $platform["code"];
		$data["type"] = $type;
		$data["subject"] = $subject;
		$data["reason"] = $reason;
		$data["on_batch"] = $on_batch;
		$data["content_before"] = $content_before;
		$data["content_after"] = $content_after;
		$data["create_time"] = date("Y-m-d H:i:s");
		$data["create_user"] = $on_batch == 1 ? "system" : session('usercode');
		
		M("log_webtrade")->add($data);
		return true;
	}

	function table_Country(){
		$d=S('Country');
		if (!$d){
			$page_size = 1000;
			$sql = table("select id,code,name from @area where status=1 and parent_id=0  ORDER BY sort");
			$sql .= " LIMIT 0, $page_size";
			$data = M()->query($sql);
			$d = array();
			foreach($data as $val) {
				$d[$val["id"]] = $val;}
				S('Country',$d,array('expire'=> 3600000));
		}
		return $d;
	}
	
    function view_log_order($tab_pagesize,$data,$type,$order_no,$id=0)
    {
        if($id>0)
        $viewkey="@log_order.order_id=$id and @log_order.type='$type'";
        else
        $viewkey="@log_order.order_no='$order_no' and @log_order.type='$type'";

        $page_size = $tab_pagesize;
        if (!$page_size) {
            $page_size = 10;
        }

        $count_sql = table("select count(*) as cnt from @log_order where $viewkey ");
        $search_sql = table("select @log_order.*,@user.name from @log_order left join @user on @user.code=@log_order.create_user Where $viewkey order by @log_order.id desc");

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

        $sql = $search_sql;
        $sql .= " LIMIT ". (($data["p"] - 1) * $page_size). ", $page_size";
        $data["list"] = M()->query($sql);
        $pageClass = new \Think\Page($count,$page_size);
        $pageClass->rollPage = 8;
        $data["page"] = $pageClass->show_drp($data["funcid"], "");
        $data["page_size"] = $page_size;

        return $data;
    }


    function createLogApply($type,$order_id,$subject,$content=array(),$details=0,$error=""){
      $res=false;         
      $qty=0;
      $amount=0;
      $status=0;
      $company_id=0;
      $info="";
      $Apply_no="";
      if(!is_array($content)){
         $info=$content;
      }
      if(!is_array($content) || is_array($content) && count($content)==0) {
          if ($type) {
              $content = M($type)->find($order_id);
          }
      }
      if (is_array($content)){
          $qty=floatval($content['qty']);
          $amount=floatval($content['amount']);
          $status=intval($content['status']);
          $Apply_no=$content['ayyly_no'];
//          if(isset($content['customer_name'])){
//              $info.=($info?"|":"").$content['customer_name'];
//          }
//          if(isset($content['contract_no'])){
//              $info.=($info?"|":"")."合同[".$content['contract_no']."]";
//          }
      } else {
          $info=$content;
      }

      if($error!="")
         $info=$error;
      else {   
		      if($details<=0 && $order_id){
		         $stable="";
		         $key="";
		      	 switch($type){
		      	 	case "goods":
		      	 	    break;
		      	 	default:
		      	 	    $stable=$type."_detail";
		      	 	    $key=$type."_id";
		      	 	    break;
		      	}
		      	if($stable){
		      	//	 $where="$key=$order_id";
		      	//	 $details=M($stable)->where($where)->count();
		      	}
		      }
      }
      
        $data=array(
            'type'=>$type,
            'company_id'=>$company_id,
            'data_id'=>$order_id,
            'Apply_no'=>$Apply_no,
            'qty'=>$qty,
            'amount'=>$amount,
            'status'=>$status,
            'create_time'=>date('Y-m-d H:i:s'),
            'create_user'=>session(C("USER_AUTH_KEY")),
            'subject'=>$subject,
            'content'=>$info,
            'details'=>$details,
        );

        $res=M('log_apply')->add($data);
        return $res;
    }

function createLogOrder($type,$order_id,$subject,$content=array(),$details=0,$error=""){
    $res=false;
    $qty=0;
    $amount=0;
    $status=0;
    $info="";
    $order_no="";
    if(!is_array($content)){
        $info=$content;
    }
    if(!is_array($content) || is_array($content) && count($content)==0) {
        if ($type) {
            $content = M($type)->find($order_id);
        }
    }
    if (is_array($content)){
        $qty=floatval($content['qty']);
        $amount=floatval($content['amount']);
        $status=intval($content['status']);
        $order_no=$content['order_no'];
//          if(isset($content['customer_name'])){
//              $info.=($info?"|":"").$content['customer_name'];
//          }
//          if(isset($content['contract_no'])){
//              $info.=($info?"|":"")."合同[".$content['contract_no']."]";
//          }
    } else {
        $info=$content;
    }

    if($error!="")
        $info=$error;
    else {
        if($details<=0 && $order_id){
            $stable="";
            $key="";
            switch($type){
                case "goods":
                    break;
                default:
                    $stable=$type."_detail";
                    $key=$type."_id";
                    break;
            }
            if($stable){
                $where="$key=$order_id";
                $details=M($stable)->where($where)->count();
            }
        }
    }


    $data=array(
        'type'=>$type,
        'order_id'=>$order_id,
        'order_no'=>$order_no,
        'qty'=>$qty,
        'amount'=>$amount,
        'status'=>$status,
        'create_time'=>date('Y-m-d H:i:s'),
        'create_user'=>session(C("USER_AUTH_KEY")),
        'subject'=>$subject,
        'content'=>$info,
        'details'=>$details,
    );

    $res=M('log_order')->add($data);
    return $res;
}



function createLogTrade($type,$order_id,$subject,$content=array(),$details=0,$error=""){
    $res=false;
    $qty=0;
    $amount=0;
    $status=0;
    $info="";
    $order_no="";
    if(!is_array($content)){
        $info=$content;
    }
    if(!is_array($content) || is_array($content) && count($content)==0) {
        if ($type) {
            $content = M($type)->find($order_id);
        }
    }
    if (is_array($content)){
        $qty=floatval($content['qty']);
        $amount=floatval($content['amount']);
        $status=intval($content['status']);
        $order_no=$content['order_no'];
//          if(isset($content['customer_name'])){
//              $info.=($info?"|":"").$content['customer_name'];
//          }
//          if(isset($content['contract_no'])){
//              $info.=($info?"|":"")."合同[".$content['contract_no']."]";
//          }
    } else {
        $info=$content;
    }

    if($error!="")
        $info=$error;
    else {
        if($details<=0 && $order_id){
            $stable="";
            $key="";
            switch($type){
                case "trade":
                    break;
                default:
                    $stable=$type."_trade";
                    $key=$type."_id";
                    break;
            }
            if($stable){
                $where="$key=$order_id";
                $details=M($stable)->where($where)->count();
            }
        }
    }

    $data=array(
        'type'=>$type,
        'order_id'=>$order_id,
        'order_no'=>$order_no,
        'qty'=>$qty,
        'amount'=>$amount,
        'status'=>$status,
        'create_time'=>date('Y-m-d H:i:s'),
        'create_user'=>session(C("USER_AUTH_KEY")),
        'subject'=>$subject,
        'content'=>$info,
        'details'=>$details,
    );

    $res=M('log_trade')->add($data);
    return $res;
}


function createLogVerify($type,$order_id,$content=array()){
    $res=false;
    if(!is_array($content) || is_array($content) && count($content)==0) {
        if ($type) {
            $content = M($type)->find($order_id);
        }
    }
    if (is_array($content)){
        $action = $content['action'];
        $user_id = $content['user_id'];
        $data_id = $content['data_id'];
        $verify = $content['verify'];
        $status = $content['status'];
    }

    $data=array(
        'verify_id'=>$order_id,
        'action'=>$action,
        'user_id'=>$user_id,
        'data_id'=>$data_id,
        'verify'=>$verify,
        'status'=>$status,
        'create_time'=>date('Y-m-d H:i:s'),
    );
    $res=M('log_verify')->add($data);

    return $res;
}







function createLogCommon($type,$data_id,$subject,$content=array(),$fields='*',$data_save=array(),$key='code',$needsave=array()){
    $res=false;
    if(!empty($data_save)){
        $res=M('log_common')->add($data_save);
    }else{
        if(trim($type)!=''){
            $m=M($type);
            $r=$m->where("id='%d'",array(intval($data_id)))->field($fields)->find();

            if(is_array($content)){
                $change="";
                if($needsave){
                    foreach ($needsave as $k=>$v) {
                        if($r[$k]!=$content[$k]){
                            if($change)$change.=",";
                            $change.="[".$v.":".$r[$k]."]";
                        }
                    }
                    if($change)
                       $content = $change.";";
                    else
                       $content = "无修改;";
                }else
                    $content=getOrderChange($content,$r,$type);
            }
            if(!empty($r) && $content!="无修改;"){
                $data=array(
                    'type'=>$type,
                    'data_id'=>$data_id,
                    'data_code'=>$r["$key"],
                    'status'=>intval($r['status']),
                    'create_time'=>date('Y-m-d H:i:s'),
                    'create_user'=>session(C("USER_AUTH_KEY")),
                    'subject'=>$subject,
                    'content'=>$content,
                );
                $res=M('log_common')->add($data);
            }else{
                return true;
            }
        }
    }
    return $res;
}















    function getOrderChange($prev,$now,$table,$title=''){

        $skip=array(
            'id',
            'lastchanged',
            'modify_user',
            'modify_time',
            'create_user',
            'create_time'
        );

        $diff=array_diff_assoc($now,$prev);
        if(empty($now)){
            $diff=array_diff_assoc($prev,$now);
        }

        $change='';
        foreach ($diff as $k=>$v) {
            if(in_array($k,$skip))
                continue;
            //$change.="[".getTableComment($table,$k)."]:".((trim($prev[$k])=='')?'无':$prev[$k])."=>".((trim($now[$k])=='')?'无':$now[$k]).",";
            $fieldname=getTableComment($table,$k);
            if($fieldname){
            	  $arr = explode(":",$fieldname.":");
            	  $fieldname=$arr[0]; 
            }
            if($fieldname && (trim($now[$k])!='')){
                $change.="[$fieldname:".$now[$k]."],";
            }
        }
        $change=$title.(trim($change,',')==''?'无修改':trim($change,','));
        return trim($change)==''?'':$change.';';

    }


    function getTableComment($table,$field,$pix='erp_'){
        $r=M()->query("SHOW FULL FIELDS FROM $pix{$table}");
        $comment=$field;
        foreach ($r as $v) {
            if($v['Field']==$field)
                $comment=$v['Comment'];
        }
        return $comment;
    }


function getOrderChangeByJson($json,$saveConditions=array()){

    $skip=array(
        'id',
        'lastchanged',
        'modify_user',
        'modify_time'
    );

    if(empty($saveConditions))
        $saveConditions=array(
            'name',
            'status',
        );


    $change='';

    $needSave=false;

    foreach ($json as $k=>$v) {
        if(in_array($k,$saveConditions)){
            if($v->value!=$v->input->default_value){
                $needSave=true;
            }
        }
    }

    if(!$needSave)
        return false;

    foreach ($json as $k=>$v){
        if(in_array($k,$skip))
            continue;
        if($v->value!=$v->input->default_value)
            $change.="[".$v->label."]:".((trim($v->input->default_value)=='')?'无':$v->input->default_value)."=>".((trim($v->value)=='')?'无':$v->value).",";

    }

    return trim($change)==''?'':$change.';';

}


function getSkuStock($product_id){
   $r = M('stock1')->where("product_id='%d'",array($product_id))->find();
   return $r['qty'];
}




function check_user_shop($shop_arr,$shop_code){
	if($shop_arr)
	{
		if(strstr($shop_arr,"'".$shop_code."'")<0)
		{
			return  false;
		}else 
		{
			return  true;
		}
	}
	return  false;
}

function getShopStorageChoose($code){
    $ss=M('shop_storage')->where("shop_code='%s'",array($code))->select();
    $scs=array();
    foreach ($ss as $sv) {
        $scs[]=$sv['storage_code'];
    }

    return join(",",$scs);
}


function  order_notice($order_id){
	set_time_limit(0);
	$where = "";
	if($order_id != "") {
		$where = " AND a.id = $order_id";
		$usercode = session ( C ( 'USER_AUTH_KEY' ));
		if($usercode) {
			$where .= " AND ((a.lock_status = 1 AND a.lock_user = '$usercode') OR a.lock_status = 0)";
		} else {
			$where .= " AND a.lock_status = 0";
		}
	} 
	
	$sales = M("sales")->alias("a")->field("a.id, b.interface, a.trade_no")
	->join("__STORAGE__ as b ON a.storage_code = b.code", "LEFT")
	->where("a.status = 3 AND a.notice_status = 0 AND a.assign_status = 2 AND a.assign_result = 1 AND a.hangup_status = 0 AND b.interface = 2 AND TIMESTAMPDIFF(HOUR, a.assign_time, NOW()) >= 2 $where")
	->order("a.modify_time asc")
	->select();
	
	if(empty($sales)) return true;
	
	foreach ($sales as $s) {
		$tmp = splitorder($s["id"], 2, 0, 0, true);
			
		if($order_id != "") {
			if(is_array($tmp)) {
				foreach($tmp as $t) {
					M("sales")->where("id = $t AND trade_no = '".$s["trade_no"]."' status = 3 AND notice_status = 0 AND assign_status = 2 AND assign_result = 1 AND hangup_status = 0 AND TIMESTAMPDIFF(HOUR, assign_time, NOW()) >= 2")->save(array("lock_status"=>0, "notice_status"=>1, "notice_time"=>date("Y-m-d H:i:s"), "modify_time"=>date("Y-m-d H:i:s")));
				}
			}
			return $tmp;
		}
	}
	
	M("sales")->where("status = 3 AND qty = 1 AND notice_status = 0 AND assign_status = 2 AND assign_result = 1 AND hangup_status = 0 AND lock_status = 0 AND TIMESTAMPDIFF(HOUR, assign_time, NOW()) >= 2")->save(array("notice_status"=>1, "notice_time"=>date("Y-m-d H:i:s"), "modify_time"=>date("Y-m-d H:i:s")));
	return true;
	
}

function picking($product_id, &$data) {
	$gm = M("goods_bom")->where("parent_id = 0 AND product_id = $product_id")->find();
	if(empty($gm)) {
		return false;
	} else {
		$gs = M("goods_bom")->field("id, product_id")->where("parent_id = ".$gm["id"])->select();
		if(empty($gs)) {
			if(isset($data[$gm["product_id"]])) {
				$data[$gm["product_id"]]["qty"] += $gm["qty"];
			} else {
				$data[$gm["product_id"]] = $gm;
			}
		} else {
			foreach($gm as $v) {
				picking($v["product_id"], $data);
			}
		}
	}
}

function checkStorageLocation($storage_code,$location_code){
    $sl=M('storage_location')->where("storage_code='%s' AND code='%s'",array($storage_code,$location_code))->find();
    return empty($sl);

}
function checkStock3qty($storage_code,$location_code,$good_no,$qty){
	$sl=M('stock3')->where("storage_code='%s' AND location_code='%s' and goods_no='%s' and qty>='%s'",array($storage_code,$location_code,$good_no,$qty))->find();
	return empty($sl);
}
function getStock3goodsqty($storage_code,$location_code,$good_no){
	$sl=M('stock3')->where("storage_code='%s' AND location_code='%s' and goods_no='%s' ",array($storage_code,$location_code,$good_no))->find();
	if(empty($sl)){
		return 0;
	}else{
		return $sl['qty'];
	}
}

//Customer 客户档案
function exist_table_Customer_id($code,$id){
	$sql="SELECT * FROM @customer WHERE code='$code' AND ID <>'$id' LIMIT 1";
	$data = M()->query(table($sql));
	if (empty($data))
		return false;
	return $data[0];
}

//CustomerCategory 客户分类
function exist_table_CustomerCategory_id($code,$id){
	$sql="SELECT * FROM @customer_category WHERE code='$code' AND ID <>'$id' LIMIT 1";
	$data = M()->query(table($sql));
	if (empty($data))
		return false;
	return $data[0];
}

function set_stat_day($stat_date)
{
    $stat_date = strtotime($stat_date);
    $txdate = date("Y-m-d", $stat_date);
    //$txweek = self::getweek($txdate);
    $txmonth = date("Y-m", $stat_date);
    //$txseason= date ( "Y", $stat_date ) . "." . ceil ( (date ( 'n', $stat_date  )) / 3 );
    $txyear = date("Y", $stat_date);

    $day = M("stat_day")->where("txdate= '" . $txdate . "'")->find();
    if (empty($day)) {
        $data ["txdate"] = $txdate;
        $data ["txmonth"] = $txmonth;
        $data ["txyear"] = $txyear;
        $data ["wait_stat"] = 1;
        $data ["status"] = 0;
        $data ["message"] = "";
        $data ["lastchanged"] = date("Y-m-d H:i:s");
        M("stat_day")->add($data);
    } else {
        if (!$day['wait_stat']) {
            $sql = "UPDATE @stat_day set wait_stat = 1, message ='', start_time = null , end_time = null where txdate = '" . $txdate . "'";
            M()->execute(table($sql));
        }
    }
}

    function removeCard($tid, $cardIds = array()) {
        if(empty($tid)) return false;
        if(empty($cardIds)) {
            $data = getAssignData($tid, -1);
        } else {
            if(!is_array($cardIds))
            {
                $cardIds=array($cardIds);
            }
            $data = getAssignData($tid);
            foreach($data["card"] as $ck=>$c) {
                if(in_array($ck, $cardIds)) {
                    $data["card"][$ck]["weight"] = 0;
                    $data["card"][$ck]["qty"] = 0;
                    foreach($data["package"][$ck] as $pk=>$p) {
                        $data["package"][$ck][$pk]["weight"] = 0;
                        $data["package"][$ck][$pk]["qty"] = 0;
                        foreach($data["buttress"][$ck][$pk] as $bk=>$b) {
                            $data["buttress"][$ck][$pk][$bk]["weight"] = 0;
                            $data["buttress"][$ck][$pk][$bk]["qty"] = 0;
                        }
                    }
                }
            }
        }


        return removeAssign($tid, $data["card"], $data["package"], $data["buttress"]);
    }
    function removePackage($tid, $packageIds) {
        if(empty($tid)) return false;
        if(empty($packageIds)) {
            return false;
        } else {
            if(!is_array($packageIds))
            {
                $packageIds=array($packageIds);
            }

            $data = getAssignData($tid);

            foreach($data["card"] as $ck=>$c) {
                foreach($data["package"][$ck] as $pk=>$p) {
                    if(in_array($pk, $packageIds)) {
                        $data["package"][$ck][$pk]["weight"] = 0;
                        $data["package"][$ck][$pk]["qty"] = 0;
                        $data["card"][$ck]["weight"] -= $p["weight"];
                        $data["card"][$ck]["qty"] -= $p["qty"];
                        foreach($data["buttress"][$ck][$pk] as $bk=>$b) {
                            $data["buttress"][$ck][$pk][$bk]["weight"] = 0;
                            $data["buttress"][$ck][$pk][$bk]["qty"] = 0;
                        }
                    }
                }
            }
        }

        return removeAssign($tid, $data["card"], $data["package"], $data["buttress"]);
    }
    function removeButtress($tid, $buttressIds) {
        if(empty($tid)) return false;
        if(empty($buttressIds)) {
            return false;
        } else {
            $data = getAssignData($tid);
            foreach($data["card"] as $ck=>$c) {
                foreach($data["package"][$ck] as $pk=>$p) {
                    foreach($data["buttress"][$ck][$pk] as $bk=>$b) {
                        if(in_array($bk, $buttressIds)) {
                            $data["buttress"][$ck][$pk][$bk]["weight"] = 0;
                            $data["buttress"][$ck][$pk][$bk]["qty"] = 0;
                            $data["package"][$ck][$pk]["weight"] -= $b["weight"];
                            $data["package"][$ck][$pk]["qty"] -= $b["qty"];
                            $data["card"][$ck]["weight"] -= $b["weight"];
                            $data["card"][$ck]["qty"] -= $b["qty"];
                        }
                    }
                }
            }
        }

        return removeAssign($tid, $data["card"], $data["package"], $data["buttress"]);
    }
    function removeAssign($tid, $card, $package, $buttress) {
        $result = checkAssignDiff($tid, $card, $package, $buttress);
        if($result !== false) {
            $card = $result["card"];
            $package = $result["package"];
            $buttress = $result["buttress"];
            return assign($tid, 0, $card, $package, $buttress, false);
        } else {
            return true;
        }
    }

    function checkAssignDiff($tid, $card = array(), $package = array(), $buttress = array()) {
        if(empty($tid)) return false;
        $trade = M("trade")->where("id = ".$tid." AND status = 2")->find();
        if(empty($trade)) {
            return false;
        }
        $goods = M("goods")->where("id = ".$trade["goods_id"])->find();
        if(empty($goods)) {
            return false;
        }
        $assignButtress = $goods["assign_mode"];

        $changed = false;
        if($assignButtress) {
            if(empty($buttress)) {
                $tradeAssignButtress = M("trade_assign_buttress")->field("storecard_id, package_id, buttress_id, weight, qty")->where("trade_id = ".$tid)->select();
                if(!empty($tradeAssignButtress)) {
                    foreach($tradeAssignButtress as $item) {
                        $buttress[$item["storecard_id"]][$item["package_id"]][$item["buttress_id"]]["weight"] = $item["weight"] * -1;
                        $buttress[$item["storecard_id"]][$item["package_id"]][$item["buttress_id"]]["qty"] = $item["qty"] * -1;
                    }
                    $changed = true;
                }
            } else {
                foreach($buttress as $ck=>$p) {
                    foreach($p as $pk=>$b) {
                        $tradeAssignButtress = M("trade_assign_buttress")->field("buttress_id, weight, qty")->where("trade_id = ".$tid." AND storecard_id = ".$ck." AND package_id = ".$pk)->select();
                        if(empty($tradeAssignButtress) && !empty($b)) {
                            $changed = true;
                        }
                        if(!empty($tradeAssignButtress)) {
                            foreach($b as $bk=>$w) {
                                $keys = array_keys($tradeAssignButtress);
                                for($i = count($keys) - 1; $i>=0;$i--) {
                                    if($bk == $tradeAssignButtress[$keys[$i]]["buttress_id"]) {
                                        if($w["weight"] != $tradeAssignButtress[$keys[$i]]["weight"]) {
                                            $buttress[$ck][$pk][$bk]["weight"] = $w["weight"] - $tradeAssignButtress[$keys[$i]]["weight"];
                                            if(isset($buttress[$ck][$pk][$bk]["qty"])) {
                                                $buttress[$ck][$pk][$bk]["qty"] = $w["qty"] - $tradeAssignButtress[$keys[$i]]["qty"];
                                            } else {
                                                $buttress[$ck][$pk][$bk]["qty"] = 0;
                                            }
                                        } else {
                                            unset($buttress[$ck][$pk][$bk]);
                                            if(empty($buttress[$ck][$pk])) {
                                                unset($buttress[$ck][$pk]);
                                            }
                                            if(empty($buttress[$ck])) {
                                                unset($buttress[$ck]);
                                            }
                                        }
                                        $changed = true;
                                        unset($tradeAssignButtress[$keys[$i]]);
                                        break;
                                    }
                                }
                            }
                        } else {
                            $changed = true;
                        }
                        if(!empty($tradeAssignButtress)) {
                            foreach($tradeAssignButtress as $item) {
                                $buttress[$ck][$pk][$item["buttress_id"]]["weight"] = $item["weight"] * -1;
                                $buttress[$ck][$pk][$item["buttress_id"]]["qty"] = $item["qty"] * -1;
                            }
                            $changed = true;
                        }
                    }
                }
            }
        }
        if(empty($package)) {
            $tradeAssignButtress = M("trade_assign_buttress")->field("storecard_id, package_id, SUM(weight) as weight, SUM(qty) as qty")->where("trade_id = ".$tid)->group("package_id")->select();
            if(!empty($tradeAssignButtress)) {
                foreach($tradeAssignButtress as $item) {
                    $buttress[$item["storecard_id"]][$item["package_id"]]["weight"] = $item["weight"] * -1;
                    $buttress[$item["storecard_id"]][$item["package_id"]]["qty"] = $item["qty"] * -1;
                }
                $changed = true;
            }
        } else {
            foreach($package as $ck=>$p) {
                $tradeAssignButtress = M("trade_assign_buttress")->field("package_id, SUM(weight) as weight, SUM(qty) as qty")->where("trade_id = ".$tid." AND storecard_id = ".$ck)->group("package_id")->select();
                if(empty($tradeAssignButtress) && !empty($p)) {
                    $changed = true;
                }
                if(!empty($tradeAssignButtress)) {
                    foreach($p as $pk=>$w) {
                        $keys = array_keys($tradeAssignButtress);
                        for($i = count($keys) - 1; $i>=0;$i--) {
                            if($pk == $tradeAssignButtress[$keys[$i]]["package_id"]) {
                                if($w["weight"] != $tradeAssignButtress[$keys[$i]]["weight"]) {
                                    $package[$ck][$pk]["weight"] = $w["weight"] - $tradeAssignButtress[$keys[$i]]["weight"];
                                    if(isset($package[$ck][$pk]["qty"])) {
                                        $package[$ck][$pk]["qty"] = $w["qty"] - $tradeAssignButtress[$keys[$i]]["qty"];
                                    } else {
                                        $package[$ck][$pk]["qty"] = 0;
                                    }
                                } else {
                                    $package[$ck][$pk]["weight"] = 0;
                                    $package[$ck][$pk]["qty"] = 0;
//                                    unset($package[$ck][$pk]);
//                                    if(empty($package[$ck])){
//                                        unset($package[$ck]);
//                                    }
                                }
                                $changed = true;
                                unset($tradeAssignButtress[$keys[$i]]);
                                break;
                            }
                        }
                    }
                } else {
                    $changed = true;
                }
                if(!empty($tradeAssignButtress)) {
                    foreach($tradeAssignButtress as $item) {
                        $package[$ck][$item["package_id"]]["weight"] = $item["weight"] * -1;
                        $package[$ck][$item["package_id"]]["qty"] = $item["qty"] * -1;
                    }
                    $changed = true;
                }
            }
        }
        if(empty($card)) {
            $tradeAssign = M("trade_assign")->field("storecard_id, weight, qty")->where("trade_id = ".$tid)->select();
            if(!empty($tradeAssign)) {
                foreach($tradeAssign as $item) {
                    $card[$item["storecard_id"]]["weight"] = $item["weight"] * -1;
                    $card[$item["storecard_id"]]["qty"] = $item["qty"] * -1;
                }
                $changed = true;
            }
        } else {
            foreach($card as $ck=>$w) {
                $tradeAssign = M("trade_assign")->field("storecard_id, weight, qty")->where("trade_id = ".$tid." AND storecard_id = ".$ck)->select();
                if(!empty($tradeAssign)) {
                    $keys = array_keys($tradeAssign);
                    for($i = count($keys) - 1; $i>=0;$i--) {
                        if($ck == $tradeAssign[$keys[$i]]["storecard_id"]) {
                            if($w["weight"] != $tradeAssign[$keys[$i]]["weight"]) {
                                $card[$ck]["weight"] = $w["weight"] - $tradeAssign[$keys[$i]]["weight"];
                                if(isset($card[$ck]["qty"])) {
                                    $card[$ck]["qty"] = $w["qty"] - $tradeAssign[$keys[$i]]["qty"];
                                } else {
                                    $card[$ck]["qty"] = 0;
                                }
                            } else {
                                $card[$ck]["weight"] = 0;
                                $card[$ck]["qty"] = 0;
//                                unset($card[$ck]);
                            }
                            $changed = true;
                            unset($tradeAssign[$keys[$i]]);
                            break;
                        }
                    }
                }

                if(!empty($tradeAssign)) {
                    foreach($tradeAssign as $item) {
                        $card[$ck]["weight"] = $item["weight"] * -1;
                        $card[$ck]["qty"] = $item["qty"] * -1;
                    }
                    $changed = true;
                }
            }
        }
        if($changed) {
            return array("card"=>$card, "package"=>$package, "buttress"=>$buttress);
        } else {
            return false;
        }
    }
    function getAssignData($tid, $coefficient = 1) {
        if(empty($tid)) return false;
        $trade = M("trade")->where("id = ".$tid)->find();//AND (assign_status = 0 OR assign_status = 1)
        if(empty($trade)) return false;
        $card = $package = $buttress = array();
        $tradeAssign = M("trade_assign")->field("storecard_id, weight, qty")->where("trade_id = ".$tid)->select();
        foreach($tradeAssign as $item) {
            if($item["weight"] == 0) continue;
            $card[$item["storecard_id"]] = array("weight"=>$item["weight"] * $coefficient, "qty"=>$item["qty"] * $coefficient);
        }
        $tradeAssignButtress = M("trade_assign_buttress")->field("storecard_id, package_id, buttress_id, weight, qty")->where("trade_id = ".$tid)->select();
        foreach($tradeAssignButtress as $item) {
            if($item["weight"] == 0) continue;
            if(!isset($package[$item["storecard_id"]])) {
                $package[$item["storecard_id"]] = array();
            }
            if(!isset($package[$item["storecard_id"]][$item["package_id"]])) {
                $package[$item["storecard_id"]][$item["package_id"]] = array("weight"=>floatval($item["weight"]) * $coefficient, "qty"=>floatval($item["qty"]) * $coefficient);
            } else {
                $package[$item["storecard_id"]][$item["package_id"]]["weight"] += floatval($item["weight"]) * $coefficient;
                $package[$item["storecard_id"]][$item["package_id"]]["qty"] += floatval($item["qty"]) * $coefficient;
            }
            if($item["buttress_id"]) {
                if(!isset($buttress[$item["storecard_id"]])) {
                    $buttress[$item["storecard_id"]] = array();
                }
                if(!isset($buttress[$item["storecard_id"]][$item["package_id"]])) {
                    $buttress[$item["storecard_id"]][$item["package_id"]] = array();
                }
                if(!isset($buttress[$item["storecard_id"]][$item["package_id"]][$item["buttress_id"]])) {
                    $buttress[$item["storecard_id"]][$item["package_id"]][$item["buttress_id"]] = array("weight"=>floatval($item["weight"]) * $coefficient, "qty"=>floatval($item["qty"]) * $coefficient);
                } else {
                    $buttress[$item["storecard_id"]][$item["package_id"]][$item["buttress_id"]]["weight"] += floatval($item["weight"]) * $coefficient;
                    $buttress[$item["storecard_id"]][$item["package_id"]][$item["buttress_id"]]["qty"] += floatval($item["qty"]) * $coefficient;
                }
            }
        }
        return array("trade"=>$trade, "card"=>$card, "package"=>$package, "buttress"=>$buttress);
    }

/**
 * 配货函数
 * @param string $tid 交易单ID
 * @param float $weight 配货重量,如果$card, $package, $buttress为空,则按照这个重量自动选择配货
 * @param array $card 配货存储卡, 如果传入次参数, $weight参数则无效,
 * 结构为array(4=>array("weight"=>50.000, "qty"=>5), 5=>array("weight"=>100.000, "qty"=>10)) key=存储卡ID, value={weight=>配货重量, qty=>配货数量}
 * qty如果不传,会自动计算
 * @param array $package 配货码单, 如果传入次参数, $weight参数则无效,
 * 结构为array(4=>array(1=>array("weight"=>20.000, "qty"=>2), 2=>array("weight"=>30.000, "qty"=>3))) key=存储卡ID, value=数组(结构为 key=码单ID, value=weight=>配货重量, qty=>配货数量})
 * qty如果不传,会自动计算
 * @param array $buttress 配货垛号, 如果传入次参数, $weight参数则无效,
 * 结构为array(4=>array(1=>array(1=>array("weight"=>10.000, "qty"=>1), 2=>array("weight"=>10.000, "qty"=>1)))) key=存储卡ID, value=数组(结构为 key=码单ID, value=数组(结构为 key=垛号ID, value={weight=>配货重量, qty=>配货数量}))
 * qty如果不传,会自动计算
 * @param boolean $trans 是否开启事务
 * @return mixed
 */
    function assign($tid, $weight, $card = array(), $package = array(), $buttress = array(), $trans = false) {
        if(empty($tid)) return false;
        $trade = M("trade")->where("id = ".$tid)->find(); //AND (assign_status = 0 OR assign_status = 1)
        if(empty($trade)) return false;
        //if(empty($card) && floatval($weight) == 0) return false;
        $goods = M("goods")->field("assign_threshold, assign_mode")->where("id = ".$trade["goods_id"])->find();
        if(empty($goods)) {
            return false;
        }
        $weight = floatval($weight);
        $standardWhere = "org_id = ".$trade["org_id"]." AND customer_id = ".$trade["customer_id"]." AND status = 1 AND trade_id = ".$trade["id"];
        if(empty($card) && $weight > 0) {
            $card = assignCard($trade, $weight);
            if(empty($card)) {
                return false;
            }
        }
        if(empty($package)) {
            $package = assignPackage($trade,$card);
            if(empty($package)) {
                foreach($card as $c) {
                    if(!isset($c["type"]) || (isset($c["type"]) && $c["type"] == 1)) {
                        return false;
                    }
                }
            }
        }
        $assignButtress = $goods["assign_mode"];
        if($assignButtress && empty($buttress)) {
            $buttress = assignButtress($trade,$package);
            if(empty($buttress)) {
                foreach($card as $c) {
                    if(!isset($c["type"]) || (isset($c["type"]) && $c["type"] == 1)) {
                        return false;
                    }
                }
            }
        }

        $totalWeight = 0;
        $totalQty = 0;
        if($trans)
            M()->startTrans();

        $now = date("Y-m-d H:i:s");
        foreach($card as $ck=>$c) {
            $realCard = !isset($c["type"]) || (isset($c["type"]) && $c["type"] == 1);
            if($realCard) {
                $tradeAssign = M("trade_assign")->where($standardWhere." AND storecard_id = ".$ck." AND storecard_type = 1")->find();
            } else {
                $tradeAssign = M("trade_assign")->where($standardWhere." AND storecard_id = ".$ck." AND storecard_type = 0")->find();
            }

            if(empty($tradeAssign) && $c["weight"] < 0) {
                if($trans)
                    M()->rollback();
                return false;
            }
            $cardTable = $realCard ? "storecard" : "storecard_virtual";
            $storeCard = M($cardTable)->where("id=$ck")->find();

            if(empty($storeCard) || ($storeCard["weight"] <= 0 && $c["weight"] > 0)) {
                if($trans)
                    M()->rollback();
                return false;
            }
            if($storeCard["weight"] - $storeCard["lock_weight"] < $c["weight"]) {
                if($trans)
                    M()->rollback();
                return false;
            }
            if(!isset($c["qty"]) || $c["qty"] == 0) {
                if($storeCard["qty"] <= 0) {
                    if($storeCard["weight"] > 0) {
                        $storeCard["qty"] = 1;
                    } else if($storeCard["qty"] < 0) {
                        $storeCard["qty"] = 0;
                    }
                }
                $c["qty"] = ($storeCard["qty"] == 0 || $c["weight"] == 0) ? 0 : round(floatval($c["weight"] / ($storeCard["weight"] / $storeCard["qty"])), 3);
                if($c["qty"] < 0) {
                    if(abs($c["qty"]) > $storeCard["qty"]) {
                        $c["qty"] = $storeCard["qty"] * -1;
                    }
                } else {
                    if($c["qty"] > $storeCard["qty"]) {
                        $c["qty"] = $storeCard["qty"];
                    }
                }
            }
            $storeCardNo = $storeCard["storecard_no"];
            if($c["weight"] != 0) {
                if(empty($tradeAssign)) {
                    $data["org_id"]=$trade["org_id"];
                    $data["customer_id"]=$trade["customer_id"];
                    $data["customer_name"]=$trade["customer_name"];
                    $data["trade_id"]=$trade["id"];
                    $data["trade_no"]=$trade["trade_no"];
                    $data["warehouse_code"]=$trade["warehouse_code"];
                    $data["storecard_id"]=$ck;
                    $data["storecard_no"]=$storeCardNo;
                    $data["storecard_type"]=$realCard ? 1 : 0;
                    $data["weight"]=$c["weight"];
                    $data["qty"]=$c["qty"];
                    $data["bulkcargo"]=0;
                    $data["lock_time"]=$now;
                    $data["remarks"]="";
                    $data["create_time"]=$now;
                    $data["status"]=1;
                    M("trade_assign")->add($data);
                } else {
                    $data["weight"] = array("exp", "weight +".$c["weight"]);
                    $data["qty"] = array("exp", "qty +".$c["qty"]);
                    $data["lock_time"]=$now;
                    M("trade_assign")->where("id = ".$tradeAssign["id"])->save($data);
                }
            }

            $data = array();
            foreach($package[$ck] as $pk=>$p) {
                $sp = M("storecard_package")->where("id=$pk")->find();
                if(empty($sp) || ($sp["weight"] <= 0 && $p["weight"] > 0)) {
                    if($trans)
                        M()->rollback();
                    return false;
                }
                if($sp["weight"] - $sp["lock_weight"] < $p["weight"]) {
                    if($trans)
                        M()->rollback();
                    return false;
                }

                if(!isset($p["qty"]) || $p["qty"] == 0) {
                    if($sp["qty"] <= 0) {
                        if($sp["weight"] > 0) {
                            $sp["qty"] = 1;
                        } else if($sp["qty"] < 0) {
                            $sp["qty"] = 0;
                        }
                    }
                    $p["qty"] = ($sp["qty"] == 0 || $p["weight"] == 0) ? 0 : round(floatval( $p["weight"] / ($sp["weight"] / $sp["qty"])), 3);
                    if($p["qty"] < 0) {
                        if(abs($p["qty"]) > $sp["qty"]) {
                            $p["qty"] = $sp["qty"] * -1;
                        }
                    } else {
                        if($p["qty"] > $sp["qty"]) {
                            $p["qty"] = $sp["qty"];
                        }
                    }
                }

                $where = "";
                if($assignButtress) {
                    foreach($buttress[$pk] as $bk=>$b) {
                        $where .= " AND buttress_id = ".$bk;
                        $tradeAssignButtress = M("trade_assign_buttress")->where($standardWhere." AND package_id = ".$pk.$where)->find();
                        if(empty($tradeAssignButtress) && $weight < 0) {
                            if($trans)
                                M()->rollback();
                            return false;
                        }

                        $data = array();
                        $sb = M("storecard_buttress")->where("id=$bk")->find();
                        if(empty($sb) || ($sb["weight"] <= 0 && $b["weight"] > 0)) {
                            if($trans)
                                M()->rollback();
                            return false;
                        }
                        if($sb["weight"] - $sb["lock_weight"] < $b["weight"]) {
                            if($trans)
                                M()->rollback();
                            return false;
                        }
                        if(!isset($b["qty"]) || $b["qty"] = 0) {
                            if($sb["qty"] <= 0) {
                                if($sb["weight"] > 0) {
                                    $sb["qty"] = 1;
                                } else if($sb["qty"] < 0) {
                                    $sb["qty"] = 0;
                                }
                            }
                            $b["qty"] = ($sb["qty"] == 0 || $b["weight"] == 0) ? 0 : round(floatval($b["weight"] / ($sb["weight"] / $sb["qty"])), 3);
                            if($b["qty"] < 0) {
                                if(abs($b["qty"]) > $sb["qty"]) {
                                    $b["qty"] = $sb["qty"] * -1;
                                }
                            } else {
                                if($b["qty"] > $sb["qty"]) {
                                    $b["qty"] = $sb["qty"];
                                }
                            }
                        }
                        if($b["weight"] != 0) {
                            if(empty($tradeAssignButtress)) {
                                $data["org_id"]=$trade["org_id"];
                                $data["customer_id"]=$trade["customer_id"];
                                $data["trade_id"]=$trade["id"];
                                $data["trade_no"]=$trade["trade_no"];
                                $data["storecard_id"]=$ck;
                                $data["storecard_no"]=$storeCardNo;
                                $data["package_id"]=$pk;
                                $data["buttress_id"]=$bk;
                                $data["package_no"]=M("storecard_package")->where("id=$pk")->getField("package_no");
                                $data["buttress_no"]=$sb["buttress_no"];
                                $data["batchno"]=$sb["batchno"];
                                $data["location_code"]=$sb["location_code"];
                                $data["weight"]=$b["weight"];
                                $data["qty"]=$b["qty"];
                                $data["bulkcargo"]=0;
                                $data["create_time"]=$now;
                                $data["status"]=1;
                                M("trade_assign_buttress")->add($data);
                            } else {
                                $data["weight"] = array("exp", "weight +".$b["weight"]);
                                $data["qty"] = array("exp", "qty +".$b["qty"]);
                                M("trade_assign_buttress")->where("id = ".$tradeAssignButtress["id"])->save($data);
                            }

                            $data = array();
                            $sl = M("storecard_lock")->where("order_id = ".$tid)->find();
                            if($sl) {
                                $data["lock_weight"] = array("exp", "lock_weight +".$b["weight"]);
                                $data["lock_qty"] = array("exp", "lock_qty +".$b["qty"]);
                                M("storecard_lock")->where("order_id = ".$tid)->save($data);
                            } else {
                                $data["org_id"]=$trade["org_id"];
                                $data["customer_id"]=$trade["customer_id"];
                                $data["customer_name"]=$trade["customer_name"];
                                $data["storecard_id"]=$ck;
                                $data["package_id"]=$pk;
                                $data["buttress_id"]=$bk;
                                $data["warehouse_code"]=$trade["warehouse_code"];
                                $data["order_id"]=$trade["id"];
                                $data["order_no"]=$trade["trade_no"];
                                $data["order_type"]="";
                                $data["order_date"]=$now;
                                $data["buyer_id"]=$trade["buyer_id"];
                                $data["buyer_name"]=$trade["buyer_name"];
                                $data["lock_weight"]=$b["weight"];
                                $data["lock_qty"]=$b["qty"];
                                $data["lock_bulkcargo"]=0;
                                $sumSl = M("storecard_lock")->field("SUM(lock_weight) as lock_weight, SUM(lock_qty) as lock_qty, SUM(lock_bulkcargo) as lock_bulkcargo")->where("org_id = ".$trade["org_id"]." AND customer_id = ".$trade["customer_id"]." AND storecard_id = ".$ck)->find();
                                $data["storelock_weight"]=$sumSl["lock_weight"] + $b["weight"];
                                $data["storelock_qty"]=$sumSl["lock_qty"] + $b["qty"];
                                $data["storelock_bulkcargo"]=$sumSl["lock_bulkcargo"] + 0;
                                $sumS = M("storecard")->field("SUM(weight) as weight, SUM(qty) as qty, SUM(bulkcargo) as bulkcargo")->where("org_id = ".$trade["org_id"]." AND customer_id = ".$trade["customer_id"]." AND id = ".$ck)->find();
                                $data["store_weight"]=$sumS["weight"];
                                $data["store_qty"]=$sumS["qty"];
                                $data["store_bulkcargo"]=$sumS["bulkcargo"];
                                $data["create_user"]="";
                                $data["create_time"]=$now;
                                M("storecard_lock")->add($data);
                            }

                            $result = M("storecard_buttress")->where("id = ".$bk." AND lock_weight + ".$b["weight"] ." <= weight")->save(array(
                                "lock_weight"=> array("exp", "lock_weight + ".$b["weight"]),
                                "lock_qty"=> array("exp", "lock_qty + ".$b["qty"])
                            ));
                            if(!$result) {
                                if($trans) {
                                    M()->rollback();
                                }
                                return false;
                            }
                        }
                    }
                } else {
                    $tradeAssignButtress = M("trade_assign_buttress")->where($standardWhere." AND package_id = ".$pk.$where)->find();
                    if(empty($tradeAssignButtress) && $weight < 0) {
                        if($trans)
                            M()->rollback();
                        return false;
                    }
                    if($p["weight"] != 0) {
                        $data = array();
                        if(empty($tradeAssignButtress)) {
                            $data["org_id"]=$trade["org_id"];
                            $data["customer_id"]=$trade["customer_id"];
                            $data["trade_id"]=$trade["id"];
                            $data["trade_no"]=$trade["trade_no"];
                            $data["storecard_id"]=$ck;
                            $data["storecard_no"]=$storeCardNo;
                            $data["package_id"]=$pk;
                            $data["buttress_id"]=0;
                            $data["package_no"]=$sp["package_no"];
                            $data["buttress_no"]=array("exp", "''");
                            $data["batchno"]=$sp["batchno"];
                            $data["location_code"]=$sp["location_code"];
                            $data["weight"]=$p["weight"];
                            $data["qty"]=$p["qty"];
                            $data["bulkcargo"]=0;
                            $data["create_time"]=$now;
                            $data["status"]=1;
                            M("trade_assign_buttress")->add($data);
                        } else {
                            $data["weight"] = array("exp", "weight +".$p["weight"]);
                            $data["qty"] = array("exp", "qty +".$p["qty"]);
                            M("trade_assign_buttress")->where("id = ".$tradeAssignButtress["id"])->save($data);
                        }

                        $data = array();
                        $sl = M("storecard_lock")->where("order_id = ".$tid)->find();
                        if($sl) {
                            $data["lock_weight"] = array("exp", "lock_weight +".$p["weight"]);
                            $data["lock_qty"] = array("exp", "lock_qty +".$p["qty"]);
                            M("storecard_lock")->where("order_id = ".$tid)->save($data);
                        } else {
                            $data["org_id"]=$trade["org_id"];
                            $data["customer_id"]=$trade["customer_id"];
                            $data["customer_name"]=$trade["customer_name"];
                            $data["storecard_id"]=$ck;
                            $data["package_id"]=$pk;
                            $data["buttress_id"]=0;
                            $data["warehouse_code"]=$trade["warehouse_code"];
                            $data["order_id"]=$trade["id"];
                            $data["order_no"]=$trade["trade_no"];
                            $data["order_type"]="";
                            $data["order_date"]=$now;
                            $data["buyer_id"]=$trade["buyer_id"];
                            $data["buyer_name"]=$trade["buyer_name"];
                            $data["lock_weight"]=$p["weight"];
                            $data["lock_qty"]=$p["qty"];
                            $data["lock_bulkcargo"]=0;
                            $sumSl = M("storecard_lock")->field("SUM(lock_weight) as lock_weight, SUM(lock_qty) as lock_qty, SUM(lock_bulkcargo) as lock_bulkcargo")->where("org_id = ".$trade["org_id"]." AND customer_id = ".$trade["customer_id"]." AND storecard_id = ".$ck)->find();
                            $data["storelock_weight"]=$sumSl["lock_weight"] + $p["weight"];
                            $data["storelock_qty"]=$sumSl["lock_qty"] + $p["qty"];
                            $data["storelock_bulkcargo"]=$sumSl["lock_bulkcargo"] + 0;
                            $sumS = M("storecard")->field("SUM(weight) as weight, SUM(qty) as qty, SUM(bulkcargo) as bulkcargo")->where("org_id = ".$trade["org_id"]." AND customer_id = ".$trade["customer_id"]." AND id = ".$ck)->find();
                            $data["store_weight"]=$sumS["weight"];
                            $data["store_qty"]=$sumS["qty"];
                            $data["store_bulkcargo"]=$sumS["bulkcargo"];
                            $data["create_user"]="";
                            $data["create_time"]=$now;
                            M("storecard_lock")->add($data);
                        }
                    }
                }
                if($p["weight"] != 0) {
                    $result = M("storecard_package")->where("id = ".$pk." AND lock_weight + ".$p["weight"] ." <= weight")->save(array(
                        "lock_weight"=> array("exp", "lock_weight + ".$p["weight"]),
                        "lock_qty"=> array("exp", "lock_qty + ".$p["qty"])
                    ));
                    if(!$result) {
                        if($trans) {
                            M()->rollback();
                        }
                        return false;
                    }
                }
            }
            if($c["weight"] != 0) {
                $result = M($cardTable)->where("id = ".$ck." AND lock_weight + ".$c["weight"] ." <= weight")->save(array(
                    "lock_weight"=> array("exp", "lock_weight + ".$c["weight"]),
                    "lock_qty"=> array("exp", "lock_qty + ".$c["qty"])
                ));
                if(!$result) {
                    if($trans) {
                        M()->rollback();
                    }
                    return false;
                }
            }

            $totalWeight += $c["weight"];
            $totalQty += $c["qty"];
        }

        $save = array(
            "assign_status" => 1,
            "assign_time" => $now,
            "assign_weight" => array("exp", "assign_weight + ".$totalWeight),
            "assign_qty" => array("exp", "assign_qty + ".$totalQty)
        );

        $assignWeight = $trade["assign_weight"] + $totalWeight;
        if($assignWeight != $trade["weight"]) {
            if(abs($trade["weight"] - $assignWeight) <= $trade["weight"] * (floatval($goods["assign_threshold"]) / 100)) {
                $save["assign_status"] = 2;
            }
        } else if($assignWeight == 0) {
            $save["assign_status"] = 0;
        } else {
            $save["assign_status"] = 2;
        }

        $result = M("trade")->where("id = ".$tid)->save($save);//AND (assign_status = 0 OR assign_status = 1)
        if($trade["status"] < 3) {
            M("trade_assign")->where("trade_id = ".$tid." AND weight = 0")->delete();
            M("trade_assign_buttress")->where("trade_id = ".$tid." AND weight = 0")->delete();
        } else {
            M("trade_assign")->where("trade_id = ".$tid." AND weight = 0")->save(array("release_time"=>$now));
            M("trade_assign_buttress")->where("trade_id = ".$tid." AND weight = 0")->save(array("release_time"=>$now));
        }
        if(!$result) {
            if($trans) {
                M()->rollback();
            }
            return false;
        }

        if($trans)
            M()->commit();
        return true;
    }
    function assignCard($trade, $weight) {
        $standardWhere = "org_id = ".$trade["org_id"]." AND customer_id = ".$trade["customer_id"]." AND status = 1 AND warehouse_code = '". $trade["warehouse_code"]."'";
        $card = array();
        if($weight > 0) {
            $sd = M("storecard")->field("id, weight - lock_weight as w, qty - lock_qty as q")->where($standardWhere." AND goods_id = ".$trade["goods_id"]." AND weight - lock_weight >= ".$weight)->order("weight - lock_weight")->find();
            if(empty($sd)) {
                $sd = M("storecard")->field("id, weight - lock_weight as w, qty - lock_qty as q")->where($standardWhere." AND goods_id = ".$trade["goods_id"])->order("weight - lock_weight")->select();
                $w = 0;
                foreach($sd as $s) {
                    if($w >= $weight) {
                        break;
                    }
                    if($weight - $w >= $s["w"]) {
                        $card[$s["id"]]["weight"] = $s["w"];
                        $card[$s["id"]]["qty"] = $s["q"] == 0 ? 1 : $s["q"];
                        $w += floatval($s["w"]);
                    } else {
                        $card[$s["id"]]["weight"] = $weight - $w;
                        $qty = floor(($s["w"] / $s["q"]) * ($weight - $w));
                        $card[$s["id"]]["qty"] = $qty == 0 ? 1 : $qty;
                        $w = $weight;
                    }
                }
                if(empty($card)) return false;
            } else {
                $card[$sd["id"]]["weight"] = $weight;
                $card[$sd["id"]]["qty"] = 0;
            }
        } else {
            $tr = M("trade_assign")->field("id, storecard_id, weight, qty")->where($standardWhere." AND trade_id = ".$trade["id"])->order("weight")->select();
            if(empty($tr)) return false;
            $w = 0;
            $absWeight = abs($weight);
            foreach($tr as $t) {
                if(floatval($t["weight"]) > $absWeight) {
                    $card[$t["storecard_id"]] = $weight;
                    break;
                }
            }
            if(empty($card)) {
                foreach($tr as $t) {
                    if($w >= $absWeight) {
                        break;
                    }
                    if($w + $t["weigth"] > $absWeight) {
                        $card[$t["storecard_id"]]["weight"] = ($absWeight - $w) * -1;
                        $qty = floor(($t["weigth"] / $t["qty"]) * ($absWeight - $w));
                        $card[$t["storecard_id"]]["qty"] = $qty == 0 ? -1 : $qty * -1;
                        $w = $absWeight;
                    } else {
                        $card[$t["storecard_id"]]["weight"] = $t["weigth"] * -1;
                        $card[$t["storecard_id"]]["qty"] = $t["qty"] * -1;
                        $w += $t["weigth"];
                    }
                }
            }
        }
        return $card;
    }
    function assignPackage($trade, $card) {
        $package = array();
        $standardWhere = "org_id = ".$trade["org_id"]." AND customer_id = ".$trade["customer_id"]." AND status = 1 AND warehouse_code = '".$trade["warehouse_code"]."'";

        foreach($card as $k=>$c) {
            $allAssign = false;
            if($c["weight"] > 0) {
                $p = M("storecard_package")->field("id, weight - lock_weight as weight, qty - lock_qty as qty")->where($standardWhere." AND storecard_id = ".$k)->order("weight")->select();
                foreach($p as $item) {
                    if($item["weight"] > $c["weight"]) {
                        $package[$k][$item["id"]]["weight"] = $c["weight"];
                        $qty = $item["qty"] == 0 ? 0 : floor(($item["weight"] / $item["qty"]) * $c["weight"]);
                        $package[$k][$item["id"]]["qty"] = $qty;
                        $allAssign = true;
                        break;
                    }
                }
            } else {
                $p = M("trade_assign_buttress")->field("package_id, sum(weight) as weight, sum(qty) as qty")->where($standardWhere." AND trade_id = ".$trade["id"]." AND storecard_id = ".$k)->order("weight")->group("package_id")->select();
                $absWeight = abs($c["weight"]);
                foreach($p as $item) {
                    if($item["weight"] > $absWeight) {
                        $package[$k][$item["id"]]["weight"] = $c["weight"];
                        $qty = $item["qty"] == 0 ? 0 : floor(($item["weight"] / $item["qty"]) * $c["weight"]);
                        $package[$k][$item["id"]]["qty"] = $qty;
                        $allAssign = true;
                        break;
                    }
                }
            }

            if(empty($p)) return array();
            if($allAssign)
                continue;

            foreach($p as $item) {
                if($c["weight"] == 0) break;
                $item["weight"] = floatval($item["weight"]);
                if($item["weight"] >= ($c["weight"] > 0 ? $c["weight"]: abs($c["weight"]))) {
                    if($c["weight"] > 0) {
                        $qty = $item["qty"] == 0 ? 1 : floor(($item["weight"] / $item["qty"]) * $c["weight"]);
                        $package[$k][$item["id"]]["weight"] = $c["weight"];
                        $package[$k][$item["id"]]["qty"] = $qty;
                    } else {
                        $qty = $item["qty"] == 0 ? 0 : floor(($item["weight"] / $item["qty"]) * $c["weight"]);
                        $package[$k][$item["package_id"]]["weight"] = $c["weight"];
                        $package[$k][$item["package_id"]]["qty"] = $qty;
                    }
                    $c["weight"] = 0;
                } else {
                    if($c["weight"] > 0) {
                        $package[$k][$item["id"]]["weight"] = $item["weight"];
                        $package[$k][$item["id"]]["qty"] = $item["qty"];
                        $c["weight"] -= $item["weight"];
                    } else {
                        $package[$k][$item["package_id"]]["weight"] = $item["weight"] * -1;
                        $package[$k][$item["package_id"]]["qty"] = $item["qty"] * -1;
                        $c["weight"] += $item["weight"];
                    }
                }
            }
        }

        return $package;
    }
    function assignButtress($trade, $package) {
        $buttress = array();
        $standardWhere = "org_id = ".$trade["org_id"]." AND customer_id = ".$trade["customer_id"]." AND warehouse_code = '".$trade["warehouse_code"]."'";
        foreach($package as $k=>$p) {
            foreach($p as $pk=>$pi) {
                $allAssign = false;
                if($pi["weight"] > 0) {
                    $b = M("storecard_buttress")->field("id, weight - lock_weight as weight, qty - lock_qty as qty")->where($standardWhere." AND storecard_id = ".$k." AND package_id = ".$pk)->order("weight")->select();
                    foreach($b as $item) {
                        if($item["weight"] > $pi["weight"]) {
                            $buttress[$k][$pk][$item["id"]]["weight"] = $pi["weight"];
                            $qty = $item["qty"] == 0 ? 0 : floor(($item["weight"] / $item["qty"]) * $pi["weight"]);
                            $buttress[$k][$pk][$item["id"]]["qty"] = $qty;
                            $allAssign = true;
                            break;
                        }
                    }
                } else {
                    $b = M("trade_assign_buttress")->field("buttress_id, weight, qty")->where($standardWhere." AND trade_id = ".$trade["id"]." AND storecard_id = ".$k." AND package_id = ".$pk)->order("weight")->select();
                    $absWeight = abs($pi["weight"]);
                    foreach($b as $item) {
                        if($item["weight"] > $absWeight) {
                            $buttress[$k][$pk][$item["id"]]["weight"] = $pi["weight"];
                            $qty = $item["qty"] == 0 ? 0 : floor(($item["weight"] / $item["qty"]) * $pi["weight"]);
                            $buttress[$k][$pk][$item["id"]]["qty"] = $qty;
                            $allAssign = true;
                            break;
                        }
                    }
                }
                if(empty($b)) return array();
                if($allAssign)
                    continue;

                foreach($b as $item) {
                    if($pi == 0) break;
                    $item["weight"] = floatval($item["weight"]);
                    if($item["weight"] >= ($pi["weight"] > 0 ? $pi["weight"]: abs($pi["weight"]))) {
                        if($pi["weight"] > 0) {
                            $qty = $item["qty"] == 0 ? 1 : floor(($item["weight"] / $item["qty"]) * $pi["weight"]);
                            $buttress[$k][$pk][$item["id"]]["weight"] = $pi["weight"];
                            $buttress[$k][$pk][$item["id"]]["qty"] = $qty;
                        } else {
                            $qty = $item["qty"] == 0 ? 0 : floor(($item["weight"] / $item["qty"]) * $pi["weight"]);
                            $buttress[$k][$pk][$item["buttress_id"]]["weight"] = $pi["weight"];
                            $buttress[$k][$pk][$item["buttress_id"]]["qty"] = $qty;
                        }
                        $pi["weight"] = 0;
                    } else {
                        if($pi["weight"] > 0) {
                            $buttress[$k][$pk][$item["id"]]["weight"] = $item["weight"];
                            $buttress[$k][$pk][$item["id"]]["qty"] = $item["qty"];
                            $pi["weight"] -= $item["weight"];
                        } else {
                            $package[$k][$pk][$item["package_id"]]["weight"] = $item["weight"] * -1;
                            $package[$k][$pk][$item["package_id"]]["qty"] = $item["qty"] * -1;
                            $pi["weight"] += $item["weight"];
                        }
                    }
                }
            }
        }
        return $buttress;
    }
    function assignVirtual($tid, $weight, $card = array(), $trans = false) {
        if(empty($tid)) return false;
        $trade = M("trade")->where("id = ".$tid."  AND status = 2")->find(); //AND (assign_status = 0 OR assign_status = 1)
        if(empty($trade)) return false;
        if(empty($card) && floatval($weight) == 0) return false;
        $goods = M("goods")->where("id = ".$trade["goods_id"])->find();
        if(empty($goods)) {
            return false;
        }
        $weight = floatval($weight);
        $totalWeight = 0;
        $totalQty = 0;
        $standardWhere = "org_id = ".$trade["org_id"]." AND customer_id = ".$trade["customer_id"]." AND status = 1 AND trade_id = ".$trade["id"];
        $now = date("Y-m-d H:i:s");
        foreach($card as $ck=>$c) {
            $tradeAssign = M("trade_assign")->where($standardWhere . " AND storecard_id = " . $ck." AND storecard_type = 0")->find();
            if (empty($tradeAssign) && $c["weight"] < 0) {
                if ($trans)
                    M()->rollback();
                return false;
            }
            $storeCard = M("storecard_virtual")->where("id=$ck")->find();
            if(empty($storeCard) || ($storeCard["weight"] <= 0 && $c["weight"] > 0)) {
                if($trans)
                    M()->rollback();
                return false;
            }
            if(!isset($c["qty"]) || $c["qty"] == 0) {
                $c["qty"] = ($storeCard["qty"] == 0 || $c["weight"] == 0) ? 0 : round(floatval($c["weight"] / $storeCard["weight"] / $storeCard["qty"]), 3);
            }

            $storeCardNo = $storeCard["storecard_no"];
            if(empty($tradeAssign)) {
                $data["org_id"]=$trade["org_id"];
                $data["customer_id"]=$trade["customer_id"];
                $data["customer_name"]=$trade["customer_name"];
                $data["trade_id"]=$trade["id"];
                $data["trade_no"]=$trade["trade_no"];
                $data["warehouse_code"]=$trade["warehouse_code"];
                $data["storecard_id"]=$ck;
                $data["storecard_no"]=$storeCardNo;
                $data["weight"]=$c["weight"];
                $data["qty"]=$c["qty"];
                $data["bulkcargo"]=0;
                $data["lock_time"]=$now;
                $data["remarks"]="";
                $data["create_time"]=$now;
                $data["status"]=1;

                M("trade_assign")->add($data);
            } else {
                $data["weight"] = array("exp", "weight +".$c["weight"]);
                $data["qty"] = array("exp", "qty +".$c["qty"]);
                $data["lock_time"]=$now;
                M("trade_assign")->where("id = ".$tradeAssign["id"])->save($data);
            }

            $data = array();
            $sl = M("storecard_lock")->where("order_id = ".$tid)->find();
            if($sl) {
                $data["lock_weight"] = array("exp", "lock_weight +".$c["weight"]);
                $data["lock_qty"] = array("exp", "lock_qty +".$c["qty"]);
                M("storecard_lock")->where("order_id = ".$tid)->save($data);
            } else {
                $data["org_id"]=$trade["org_id"];
                $data["customer_id"]=$trade["customer_id"];
                $data["customer_name"]=$trade["customer_name"];
                $data["storecard_id"]=$ck;
                $data["package_id"]=0;
                $data["buttress_id"]=0;
                $data["warehouse_code"]=$trade["warehouse_code"];
                $data["order_id"]=$trade["id"];
                $data["order_no"]=$trade["trade_no"];
                $data["order_type"]="";
                $data["order_date"]=$now;
                $data["buyer_id"]=$trade["buyer_id"];
                $data["buyer_name"]=$trade["buyer_name"];
                $data["lock_weight"]=$c["weight"];
                $data["lock_qty"]=$c["qty"];
                $data["lock_bulkcargo"]=0;
                $sumSl = M("storecard_lock")->field("SUM(lock_weight) as lock_weight, SUM(lock_qty) as lock_qty, SUM(lock_bulkcargo) as lock_bulkcargo")->where("org_id = ".$trade["org_id"]." AND customer_id = ".$trade["customer_id"]." AND storecard_id = ".$ck)->find();
                $data["storelock_weight"]=$sumSl["lock_weight"] + $c["weight"];
                $data["storelock_qty"]=$sumSl["lock_qty"] + $c["qty"];
                $data["storelock_bulkcargo"]=$sumSl["lock_bulkcargo"] + 0;
                $sumS = M("storecard_virtual")->field("SUM(weight) as weight, SUM(qty) as qty, SUM(bulkcargo) as bulkcargo")->where("org_id = ".$trade["org_id"]." AND customer_id = ".$trade["customer_id"]." AND id = ".$ck)->find();
                $data["store_weight"]=$sumS["weight"];
                $data["store_qty"]=$sumS["qty"];
                $data["store_bulkcargo"]=$sumS["bulkcargo"];
                $data["create_user"]="";
                $data["create_time"]=$now;
                M("storecard_lock")->add($data);
            }

            $result = M("storecard_virtual")->where("id = ".$ck." AND lock_weight + ".$c["weight"] ." <= weight")->save(array(
                "lock_weight"=> array("exp", "lock_weight + ".$c["weight"]),
                "lock_qty"=> array("exp", "lock_qty + ".$c["qty"])
            ));
            if(!$result) {
                if($trans) {
                    M()->rollback();
                }
                return false;
            }
            $totalWeight += $c["weight"];
            $totalQty += $c["qty"];
        }

        $save = array(
            "assign_status" => 1,
            "assign_time" => $now,
            "assign_weight" => array("exp", "assign_weight + ".$totalWeight),
            "assign_qty" => array("exp", "assign_qty + ".$totalQty)
        );
        if($trade["assign_weight"] + $totalWeight == $trade["weight"]) {
            $save["assign_status"] = 2;
        }

        $result = M("trade")->where("id = ".$tid."  AND status = 2")->save($save);//AND (assign_status = 0 OR assign_status = 1)
        M("trade_assign")->where("trade_id = ".$tid." AND weight = 0")->delete();
        M("trade_assign_buttress")->where("trade_id = ".$tid." AND weight = 0")->delete();
        if(!$result) {
            if($trans) {
                M()->rollback();
            }
            return false;
        }

        if($trans)
            M()->commit();
        return true;
    }
    function releaseAssign($tid) {
        if(empty($tid)) return false;
        $result = getAssignData($tid);
        $c = $result["card"];
        $p = $result["package"];
        $b = $result["buttress"];
        foreach($c as $k=>$v) {
            $c[$k]["weight"] *= -1;
            $c[$k]["qty"] *= -1;
            foreach($p[$k] as $k1=>$v1) {
                $p[$k][$k1]["weight"] *= -1;
                $p[$k][$k1]["qty"] *= -1;
                if(!empty($b)) {
                    foreach($b[$k][$k1] as $k2=>$v2) {
                        $b[$k][$k1][$k2]["weight"] *= -1;
                        $b[$k][$k1][$k2]["qty"] *= -1;
                    }
                }
            }
        }

        return assign($tid, 0, $c, $p, $b, false);
    }

    function stock($tid) {
        if(empty($tid)) return false;
        $trade = M("trade")->field("status, goods_id")->where("id = ".$tid." AND status = 6")->find();
        if(empty($trade)) return false;
        $goods = M("goods")->field("assign_threshold, assign_mode")->where("id = ".$trade["goods_id"])->find();
        if(empty($goods)) {
            return false;
        }

        $assignButtress = $goods["assign_mode"];
        $pre = C("DB_PREFIX");
        if($assignButtress) {
            $sql = "UPDATE ".$pre."storecard_buttress as a ".
                "LEFT JOIN ".$pre."trade_assign_buttress as b ".
                "ON a.id = b.buttress_id ".
                "SET a.weight = a.weight - b.act_weight, ".
                "a.qty = a.qty - b.act_qty, ".
                "a.bulkcargo = a.bulkcargo - b.act_bulkcargo ".
                "WHERE b.trade_id = ".$tid." AND a.id IN (SELECT buttress_id FROM ".$pre."trade_assign_buttress WHERE trade_id = ".$tid.")";
            $result = M()->execute($sql);
            if(!$result) return false;
        }

        $sql = "UPDATE ".$pre."storecard_package as a ".
            "LEFT JOIN (SELECT trade_id,package_id, SUM(act_weight) as act_weight, SUM(act_qty) as act_qty, SUM(act_bulkcargo) as act_bulkcargo FROM ".$pre."trade_assign_buttress WHERE trade_id = ".$tid." GROUP BY package_id) as b ".
            "ON a.id = b.package_id ".
            "SET a.weight = a.weight - b.act_weight, ".
            "a.qty = a.qty - b.act_qty, ".
            "a.bulkcargo = a.bulkcargo - b.act_bulkcargo ".
            "WHERE b.trade_id = ".$tid." AND a.id IN (SELECT distinct package_id FROM ".$pre."trade_assign_buttress WHERE trade_id = ".$tid.")";
        $result = M()->execute($sql);
        if(!$result) return false;

        $sql = "UPDATE ".$pre."storecard as a ".
            "LEFT JOIN ".$pre."trade_assign as b ".
            "ON a.id = b.storecard_id ".
            "SET a.weight = a.weight - b.act_weight, ".
            "a.qty = a.qty - b.act_qty, ".
            "a.bulkcargo = a.bulkcargo - b.act_bulkcargo ".
            "WHERE b.trade_id = ".$tid." AND a.id IN (SELECT storecard_id FROM ".$pre."trade_assign WHERE trade_id = ".$tid.")";
        $result = M()->execute($sql);
        return $result;
    }

    function convertCapital($txt, $sp, $uom, $model) {
        if($txt == "") return $txt;
        $dot = strpos($txt , ".");
		$t1 = "";
        $t2 = "";
        if($dot >= 0) {
            $t1 = substr($txt, 0, $dot);
            $t2 = substr($txt, $dot + 1);
        } else {
            $t1 = $txt;
            $t2 = "";
        }
		$t = array();
        $c = array();
        $k = 0;
        for($i = mb_strlen($t1, "utf-8") -1; $i>=0;$i--) {
            if($k == 4) {
                $k = 0;
                $t[] = $c;
                $c = array();
            }
            $c[] = $t1[$i];
            $k++;
        }
        if(count($c) > 0 && count($t) > 0) {
            $t[] = $c;
            $c = array();
        }
        $returnTxt = "";
        if(count($t) > 0) {
            for($i = 0; $i < count($t); $i++) {
                $st = "";
                for($k = 0; $k < count($t[$i]); $k++) {
                    if($t[$i][$k] == 0) {
                        if($k > 0 && $t[$i][$k - 1] != 0) {
                            $st = convertCapitalChar(0) . $st;
                        }
                    } else {
                        $st = convertCapitalChar($t[$i][$k]) . convertCapitalUnit($k) . $st;
                    }
                }
                if($i > 0) {
                    if($i % 2 == 0) {
                        $st .= "亿";
                    } else {
                        if($st != "") {
                            $st .= "万";
                        }
                    }
                }

                $returnTxt = $st . $returnTxt;
            }
        } else {
            for($k = 0; $k < count($c); $k++) {
                if($c[$k] == 0) {
                    if($k > 0 && $c[$k - 1] != 0) {
                        $returnTxt = convertCapitalChar(0) . $returnTxt;
                    }
                } else {
                    $returnTxt = convertCapitalChar($c[$k]) . convertCapitalUnit($k) . $returnTxt;
                }
            }
        }
        if($model == "rmb") {
            $returnTxt .= $sp;
        } else {
            if($t2 != "") {
                $returnTxt .= $sp;
            }
        }

        if($t2 != "") {
            for($i = 0;$i<mb_strlen($t2, "utf-8");$i++) {
                if($model == "rmb") {
                    if($i >= 2) break;
                }
                if($t2[$i] == 0) {
                    if($i == 0 && mb_strlen($t2, "utf-8") > 1) {
                        $returnTxt .= convertCapitalChar($t2[$i]);
                    }
                } else {
                    $returnTxt .= convertCapitalChar($t2[$i]) . ($model == "rmb" ? ($i == 0 ? "角" : "分") : "");
                }
            }
        }
        $returnTxt .= $uom;
        return $returnTxt;
    }
    function convertCapitalChar($txt) {
        $capitalCharArray = array("零","壹","贰","叁","肆","伍","陆","柒","捌","玖");
		return $capitalCharArray[$txt];
	}
    function convertCapitalUnit($i) {
        $capitalCharArray = array("", "拾","百","千");
        return $capitalCharArray[$i];
    }

    function getGoodsAlias($org_id, $goods_id, $txt, $type) {
        $return = "";
        $alias = M("goods_alias")->field("alias")->where("value = '".$txt."' AND goods_id = ".$goods_id. " AND type = ".$type. " AND org_id = ".$org_id)->select();
        foreach($alias as $item) {
            if($return != "") $return .= "','";
            $return .= $item["alias"];
        }
        $alias = M("goods_alias")->field("value")->where("alias = '".$txt."' AND goods_id = ".$goods_id. " AND type = ".$type. " AND org_id = ".$org_id)->select();
        foreach($alias as $item) {
            if($return != "") $return .= "','";
            $return .= $item["alias"];
        }
        $return .= "','".$txt."'";
        $return = "'" . $return;
        return $return;
    }



/*
      参数一：登入用户，$this->user
      参数二: 联盟id，当前记录联盟id值，不存在给0
      参数三: 客户id，当前记录客户id值，不存在给0
      if(!AuthCheck($this->user, $trade['org_id'], $trade['customer_id'])  $this->AjaxResult("非交易方不能处理当前数据");
    */
function AuthCheck($user, $org_id=0, $customer_id=0){
    switch($user['side']){
        case 1:
            break;
        case 2:
            if(empty($org_id) || empty($user['org_id'])) return false;   //如果org_id不存在。则报错
            if($user['org_id']!=$org_id) return false;                   //如果用户登录的org_id 与用户操作的org)_id不一致.报错
            break;
        case 3:
            if(empty($customer_id) || empty($user['customer_id'])) return false;
            if($user['customer_id']!=$customer_id) return false;
            break;
        default:
            return false;
            break;
    }
    return true;
}

function  create_chain_sign($id)
{
    $model=M("Trade");
    $model_assign=M("TradeAssign");
    $model_chain=M("Chain");
    $model_chain_detail=M("ChainDetail");

    $chain_id=0;
    try
    {
        $model->startTrans();

        $trade_info=$model->where(Array("id"=>$id))->find();
        if($trade_info)
        {
            if($trade_info["status"]!=2)
            {
                throw  new \Exception("交易[".$trade_info["trade_no"]."]不是配货状态");
            }

            $list=$model->where(array(
                "customer_id"=>$trade_info["buyer_id"],
                "org_id"=>$trade_info["org_id"],
                "assign_status"=>2,
                "stauts"=>2,
                "weight"=>$trade_info["weight"],
                "goods_id"=>$trade_info["goods_id"],
            ))->field("id")->select();
            if($list)
            {
                $trade_ids=array_column($list,"id");
                $assign_list=$model_assign->where(array(
                    "storecard_no"=>$trade_info["buyer_storecard_no"],
                    "trade_id"=>array("in",$trade_ids),
                    "weight"=>$trade_info["weight"]
                ))->field("trade_id")->select();
                if($assign_list)
                {
                    if(count($assign_list)==1)
                    {
                        $trade_id=$assign_list[0]["trade_id"];
                        $trade_info_next=$model->where(array("id"=>$trade_id))->find();
                        if($trade_info_next["status"]!=2)
                        {
                            throw new Exception("交易状态不可以进行成链匹配");
                        }
                        if($trade_info_next["assign_status"]!=2)
                        {
                            throw new Exception("交易状态没有完成配货");
                        }

                        if($trade_info["chain_id"]>0)
                        {
                            $chain_id=$trade_info["chain_id"];
                        }
                        if($trade_info_next)
                        {
                            if($chain_id<=0)
                            {
                                if($trade_info_next["chain_id"]>0)
                                {
                                    $chain_id=$trade_info_next["chain_id"];
                                }
                            }
                        }


                        if($chain_id<=0) {
                            $chain_id = $model_chain->add(array(
                                "org_id" => $trade_info_next["org_id"],
                                "customer_id" => $trade_info_next["customer_id"],
                                "customer_name" => $trade_info_next["customer_name"],
                                "chain_no" => GenOrderNo("chain"),
                                "subject" => $trade_info_next["subject"],
                                "goods_id" => $trade_info_next["goods_id"],
                                "goods_no" => $trade_info_next["goods_no"],
                                "goods_name" => $trade_info_next["goods_name"],
                                "style_info" => $trade_info_next["style_info"],
                                "materials" => $trade_info_next["materials"],
                                "brand" => $trade_info_next["brand"],
                                "producing_area" => $trade_info_next["producing_area"],
                                "style_code" => $trade_info_next["style_code"],
                                "weight" => $trade_info_next["weight"],
                                "uom_weight" => $trade_info_next["uom_weight"],
                                //"detail"=>$trade_info_next["detail"],
                                //"remarks"=>$trade_info_next["remarks"],
                                "status" => 0,
                            ));
                        }




                        if($trade_info["chain_id"]>0)
                        {
                            $chain_seq=$model_chain_detail->where(array(
                                    "chain_id"=>$trade_info["chain_id"])
                            )->getField("max(seq) as seq");
                        }else
                        {
                            $chain_seq=1;
                            $model_chain_detail->add(array(
                                "org_id"=>$trade_info["org_id"],
                                "chain_id"=>$chain_id,
                                "trade_id"=>$trade_info["id"],
                                "seq"=>$chain_seq
                            ));
                            $result=$model->where(array(
                                "id"=>$trade_info["id"],
                                "chain_id"=>0
                            ))->save(array(
                                    "chain_id"=>$chain_id
                                )
                            );
                            if(!$result)
                            {
                                throw new Exception("更新交易订单[".$trade_info["id"]."]信息失败！");
                            }

                        }

                        if($trade_info_next["chain_id"]>0)
                        {

                            $where_chain=array(
                                "chain_id"=>$trade_info_next["chain_id"]
                            );
                            $save_chain=array(
                                "seq"=>array("exp","seq+$chain_seq"),

                            );
                            if($chain_id==$trade_info_next["chain_id"])
                            {
                                $where_chain["trade_id"]=array("neq",$trade_info["id"]);
                            }else
                            {
                                $save_chain["chain_id"]=$chain_id;
                            }
                            $model_chain_detail->where($where_chain)->save($save_chain);

                            $model->where(array("chain_id"=>$trade_info_next['chain_id']))->save(
                                array("chain_id"=>$chain_id)
                            );

                            $result=$model_chain->where(array("id"=>$trade_info_next['chain_id'],
                                "status"=>"0"
                            ))->save(array("status"=>"7"));
                            if(!$result)
                            {
                                throw new Exception("更新交易链[".$trade_info_next['chain_id']."]状态失败！");
                            }
                        }else
                        {
                            $chain_seq++;
                            $model_chain_detail->add(array(
                                "org_id"=>$trade_info["org_id"],
                                "chain_id"=>$chain_id,
                                "trade_id"=>$trade_id,
                                "seq"=>$chain_seq
                            ));

                            $result=$model->where(array(
                                "id"=>$trade_id,
                                "chain_id"=>0
                            ))->save(array(
                                    "chain_id"=>$chain_id
                                )
                            );
                            if(!$result)
                            {
                                throw new Exception("更新交易订单[".$trade_id."]信息失败！");
                            }
                        }




                    }
                }
            }
        }
        $model->commit();
        return true;
    }catch (\Exception $ex)
    {
        $model->rollback();
        return false;
    }

}


 function create_chain(){
    $model=M("Trade");
    $ids=$model->where(array("status"=>2,
        "chain_id"=>0,
        "buyer_storecard_no"=>array("neq",'')
    ))->field("id")->select();

    foreach ($ids as $v) {
        create_chain_sign($v["id"]);
    }

    $model=M("Chain");
    $model_d=M("ChainDetail");
    $list=$model->where(Array("status"=>0))->select();
    foreach ($list as $v)
    {
        $detailinfo=$model_d->where(Array("chain_id"=>$v["id"]))->field("trade_id")->order("seq desc")->find();
        if($detailinfo)
        {
            create_chain_sign($detailinfo["trade_id"]);
        }
    }

    return true;

}





