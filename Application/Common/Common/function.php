<?php
	
function is_admin_user(){
  	 return ($_SESSION[C('ADMIN_AUTH_KEY')]==true );
}

function dateModifyByStamp($time,$modify='+0 seconds',$retFormat="")
	{
		$ret=false;
		$ret=strtotime($modify,$time);

		if ($ret && trim($retFormat)!='') {
			return date($retFormat,$ret);
		}

		return $ret;

	}

	function dateModifyByString($date,$modify='+0 seconds',$retFormat="")
	{

		return dateModifyByStamp(strtotime($date),$modify,$retFormat);

	}

	function timeFormatisSame($time1,$time2,$format='Y-m-d'){
		$ret = false;

		if (dateModifyByStamp($time1, '+0 seconds', $format) === dateModifyByStamp($time2, '+0 seconds', $format))
			$ret = true;

		return $ret;
	}

	//秒转换成时间 年 天 小时 分钟 秒
	function Sec2Time($time,$type){
		if(is_numeric($time)){
			$value = array(
					"years" => 0, "days" => 0, "hours" => 0,
					"minutes" => 0, "seconds" => 0,
			);
			$set_arr=array("years" => 31556926, "days" =>86400, "hours" =>3600,
					"minutes" => 60,
			);
	
			$is_find=false;
			foreach ($set_arr as $k=>$val)
			{
				if ($type==$k)
				{
					$is_find=true;
				}
				if($is_find)
				{
					if($time >= $set_arr[$k]){
						$value[$k] = floor($time/$set_arr[$k]);
						$time = ($time%$set_arr[$k]);
					}
				}
			}
			$value["seconds"] = floor($time);
			if($value["years"]>0)
			{
				$t.=$value["years"] ."年";
			}
			if($value["days"]>0)
			{
				$t.=$value["days"] ."天";
			}
			if($value["hours"]>0)
			{
				$t.=$value["hours"] ."小时";
			}
			if($value["minutes"]>0)
			{
				$t.=$value["minutes"] ."分钟";
			}
			if($value["seconds"]>0)
			{
				$t.=$value["seconds"] ."秒";
			}
			Return $t;
	
		}else{
			return (bool) FALSE;
		}
	}
	
	
	if(!function_exists("array_column")){
		function array_column($input, $columnKey, $indexKey = NULL){
			$columnKeyIsNumber = (is_numeric($columnKey)) ? TRUE : FALSE;
			$indexKeyIsNull = (is_null($indexKey)) ? TRUE : FALSE;
			$indexKeyIsNumber = (is_numeric($indexKey)) ? TRUE : FALSE;
			$result = array();
	
			foreach ((array)$input AS $key => $row){
				if ($columnKeyIsNumber){
					$tmp = array_slice($row, $columnKey, 1);
					$tmp = (is_array($tmp) && !empty($tmp)) ? current($tmp) : NULL;
				}else{
					$tmp = isset($row[$columnKey]) ? $row[$columnKey] : NULL;
				}
				if (!$indexKeyIsNull){
					if ($indexKeyIsNumber){
						$key = array_slice($row, $indexKey, 1);
						$key = (is_array($key) && ! empty($key)) ? current($key) : NULL;
						$key = is_null($key) ? 0 : $key;
					}else{
						$key = isset($row[$indexKey]) ? $row[$indexKey] : 0;
					}
				}
				$result[$key] = $tmp;
			}
			return $result;
		}
	}
	
	
	/** 格式化时间戳，精确到毫秒，x代表毫秒 */
	function microtime_format($tag, $time)
	{
		list($usec, $sec) = explode(".", $time);
		$date = date($tag,$usec);
		return trim(str_replace('x', $sec, $date),'.');
			
	}
	
	function mydateformat($value,$format="Y-m-d H:i:s")
	{
		$sresult="";
		if(isset($value))
		{
			if(!empty($value))
			{
				if(strtotime($value)>strtotime('1900-01-01 00:00:00'))
				{
		   			$sresult=date($format,strtotime($value));
				}
			}
		}
		return $sresult;
	}
	
	function verify_value($value,$type,$condition = 0, $regulx = "")
	{
		//empty#nagitive#max#min#rangeboth#mobile#email#url#ip4#ip6#reglux
		switch($type)
		{
			case "empty":
				return rtrim(ltrim($value)) != "";
				break;
			case "negitive":
				return floatval($value) >= 0;
				break;
            case "positive":
				return intval($value) > 0;
				break;
			case "max":
				return floatval($value) <= $condition;
			case "min":
				return floatval($value) >= $condition;
			case "rangeboth":
				return true;
			case "mobile":
				$regulx = "/^(1[3,5,7,8][0-9])[0-9]{8}$/isU";
				break;
			case "url":
				$regulx = "/^http([s]?):\/\/.&/iU";
				break;
			case "ip4":
				$regulx="/^((2[0-4]\d|25[0-5]|[01]?\d\d?)\.){3}(2[0-4]\d|25[0-5]|[01]?\d\d?)$/isU";
				break;
			case "ip6":
				return true;
				break;
			case "email":
				$regulx="/^\w+@\w+.\w+$/isU";
				break;
			case "num":
				return is_numeric($value);
				break;
			case "date":
				$unixTime = strtotime($value);
				if (!$unixTime) { //strtotime转换不对，日期格式显然不对。
					return false;
				}else
				{
					return  true;
				}
				break;
			case "datetime":
				$unixTime = strtotime($value);
				if (!$unixTime) { //strtotime转换不对，日期格式显然不对。
					return false;
				}else
				{
					return  true;
				}
				break;
			default:
				return true;
		}
	
		if ($regulx!='')
		{
			$v = preg_match($regulx, $value, $match);
			return $v != 0;
		}
	}
	
	function message($msg) {
		$count = func_num_args();
		$args = func_get_args();
		for($i = 1; $i<$count; $i++) {
			$msg = str_replace("%".$i,$args[$i], $msg);
		}
		return $msg;
	}
	
	function join_condition($condition, $field, $value,$type="char",$opt="=",$skipcheck=0, $join=" AND ")  //opt = > < >= <= like likeleft likeright
	{
		$value=trim($value);
		$value=str_replace("'","", $value);
		$value=str_replace('"',"", $value);
		if (!$skipcheck)
		{
			if($value === "") return $condition ;
		}
		$condition.=" $join ";

		if(!$opt)$opt="=";
	
		$field = table($field); // erp_
		
		if (strtolower($opt)=="in")
		{
			 if(strstr($value, "|")){
			     $opt="in";
			 } else {
			     $opt="=";
			 }
		}else {
		  if(substr($value, 0, 1) == "!") {
			  $opt = "!=";
			  $value = substr($value, 1);
		  }
		}
		switch($type)
		{
			case "int":
			case "decimal":
			case "float":
			case "bool":
				$value = (float)$value;
				if($opt=="both" || $opt=="left" || $opt=="right") $opt="=";
				if($opt=="in") 
				   $condition.=$field." in (".str_replace("|",",", $value).")";
				else
				   $condition.=$field.$opt.$value;
				break;
			case "date":
			case "datetime":
				if(!$value)
					$tmp ="0000/00/00" ;
				else {
					$tmp = strtotime($value);
					$tmp = date("Y-m-d", $tmp);
				}
				$tmp .= " 00:00:00";
				$condition.=$field.$opt."'$tmp'";
				break;
			case "time":
				if(!$value)
				  $tmp ="0000/00/00 00:00:00" ;
				else {
					$tmp = strtotime($value);
					$tmp = "0000/00/00 ".date("H:i:s", $tmp);
				}
				$condition.=$field.$opt."'$tmp'";
				break;
			case "timestamp":
				if(!$value)
					$tmp ="0000/00/00" ;
				else {
					$tmp = strtotime($value);
					$tmp = date("Y-m-d", $tmp);
				}
				$tmp1 = strtotime($tmp ." 00:00:00");
				$tmp2 = strtotime($tmp ." 23:59:59");
				$condition .= "$field >= '$tmp1' AND $field <= '$tmp2'";
				break;
			default:  //char
                $value=str_replace('@',"·mailchar·", $value);
                if($value=="{空}" || $value=="[空]") {
                    $value="";
                    $opt="=";
                }
				//if(!$value) $value="";
				switch($opt)
				{
					case "in":
						$condition .= $field." in ('".str_replace("|","','", $value)."')";
						break;
					case "both":
						$condition .= $field." like '%$value%'";
						break;
					case "left":
						$condition .= $field." like '$value%'";
						break;
					case "right":
						$condition .= $field." like '%$value'";
						break;
					default:
				     if(strstr($value,'%'))
					      $condition .= $field." like '$value'";
				     else{
				         if(strlen($value)>0)
                             $condition .= $field.$opt."'$value'";
				         else{
                             if($opt=="=")
                                 $condition .= "($field $opt '$value' or $field is null)";
                             else
                                 $condition .= "$field $opt '$value'";
                         }
                     }
						break;
				}
				break;
		}
		return  $condition ;
	}
	
	function join_condition2($condition, $field, $value1, $value2,$type="Char") //$istype:Char/NumFloat 2=Date 3
	{
		if($value1 === "" && $value2 === "") return $condition;
		 
		if($value1 !== "" && $value2 === "")
		{
			$condition=join_condition($condition, $field, $value1,$type,"=");
		}
		else if($value1 === "" && $value2 !== "")
		{
			$condition=join_condition($condition, $field, $value2,$type,"=");
		}
		else
		{
			$field = table($field); // erp_
			$condition.=" AND ";
	
			if ($value1>$value2)
			{
				$value=$value1;
				$value1=$value2;
				$value2=$value;
			}
			switch($type)
			{
				case "int":
				case "decimal":
				case "float":
				case "bool":
					$value1 = (float)$value1;
					$value2 = (float)$value2;
					$condition .= $field." between $value1 and $value2";
					break;
				case "date":
				case "datetime":
					$tmp1 = strtotime($value1);
					$tmp1 = date("Y-m-d", $tmp1)." 00:00:00";
					$tmp2 = strtotime($value2);
					$tmp2 = date("Y-m-d", $tmp2)." 23:59:59";
					$condition .= $field." between '$tmp1' and '$tmp2'";
					break;
				case "time":
					$tmp1 = strtotime($value1);
					$tmp1 = "0000/00/00 ".date("H:i:s", $tmp1);
					$tmp2 = strtotime($value2);
					$tmp2 = "0000/00/00 ".date("H:i:s", $tmp2);
					$condition .= $field." between '$tmp1' and '$tmp2'";
					break;
				case "timestamp":
					$tmp1 = strtotime($value1);
					$tmp1 = strtotime(date("Y-m-d", $tmp1)." 00:00:00");
					$tmp2 = strtotime($value2);
					$tmp2 = strtotime(date("Y-m-d", $tmp2)." 23:59:59");
					$condition .= $field." between '$tmp1' and '$tmp2'";
					break;
				default:
		      $value1=str_replace('@',"·mailchar·", $value1);
		      $value2=str_replace('@',"·mailchar·", $value2);

					$condition .= $field." between '$value1' and '$value2'";
					break;
			}
		}

		//echo "condition=$condition ";
		return  $condition ;
	}

    function join_condition_auth($condition, $auth, $auth_extend) {
        if($auth_extend )
            $condition .= " AND $auth_extend ";

        if($auth )
            $condition .= " AND $auth ";

        return $condition;
    }

	function join_condition_shop($condition, $field, $login_auth_id, $search_auth_id, $auth_condition) {
        if($auth_condition ){
            $customer_tree="(select customer_id from @customer_tree where parent_id=$login_auth_id)";
            $auth_condition = str_replace("#login_customer_id#", $login_auth_id,$auth_condition );
            $auth_condition = str_replace("#customer_tree#", $customer_tree,$auth_condition );
        }
        if($login_auth_id){
            if($auth_condition )
                $condition .= " AND $auth_condition ";
            else
                $condition .= " AND $field=$login_auth_id";
        }
        if($search_auth_id){
            $condition .= " AND $field=$search_auth_id";
        }

		return $condition;

		if(!is_array($search_auth_id)) $search_auth_id = array();
		
		if($_SESSION[C('ADMIN_AUTH_KEY')]!=true)
		{
			$s = explode(",", $login_auth_id);
			foreach($s as $v) {
				if(!in_array($v, $search_auth_id)) {
					$search_auth_id[] = $v;
				}
			}
		}
		if(empty($search_auth_id))
			return $condition;
		
		$shop = table_Shop();
		
		if(count($search_auth_id) != count($shop)) {
			if(count($search_auth_id) == 1) {
				$condition .= " AND $field = ".$search_auth_id[0];
			} else {
				$condition .= " AND $field IN (" . join(",", $search_auth_id) .")";
			}
		}
		return $condition;
	}
	
	function table($sql)
	{
		$pre = C("DB_PREFIX");
		return str_replace("@",$pre, $sql);
	}
	
	function joinfield($fields,$field)
	{
		if($field)
		{
			if($fields) $fields.=",";
			$fields.=$field;
		}
		return $fields;
	}
	
	function get_array_value($key, $name = "") {
		$data= table_shop();
		if(is_array($data)) {
			if(!empty($data)) {
				if(isset($data[$key])) {
					if($name != "" && isset($data[$key][$name]))
						return $data[$key][$name];
					else
						return $data[$key];
				} else {
					foreach($data as $k=>$v) {
						if($v["id"] == $key) {
							if($name != "" && isset($v[$name]))
								return $v[$name];
							else
								return $v;
						}
					}
				}
			}
		} else {
			return $data;
		}
		
		return "你调用错了";
	}
	
	function OverView($str,$len,$prefix) {
		if(mb_strlen($str) > $len) {
			$str = mb_substr($str, 0, $len, "utf-8");
			$str .= $prefix;
		}
		return $str;
	}

	function filterFuncId($str, $funcid="") {

        $str=strtolower($str);
        $funcid=strtolower($funcid);

		$f = array();
		$data = explode("&", $funcid);
		foreach($data as $d) {
			list($key,$val) = explode("=", $d);
			$f[$key] = $val;
		}
	
		ksort($f);

        $k = "";
		foreach ($f as $c) {
			$o = trim($c);
			if($o == "") {
				continue;
			}
			if(!empty($k)) $k .= "_";
			$k .= $c;
		}
		return "f_".(md5($str.$k));
	}
	
function nonEmpty($value,&$msg){	
    $msg=(trim($value)==''?'不能为空':true);   
    return $msg;
}

function isMobile($value,&$msg){
    $msg=(!preg_match("/^(13[0-9]|14[0-9]|15[0-9]|18[0-9])\d{8}$/", $value))?"不正确":true;
    return $msg;
}

function maxLength($value,$length,&$msg){
    $msg=mb_strlen($value)>$length?('字符不能超过'.$length):true;
    return $msg;
}


function check_code($table,$code,&$msg){	
    $r=M($table)->where("code='%s'",array($code))->find();
    $msg=(empty($r)?true:"已存在");
    return $msg;
}

function check_customize($table,$code,$field,&$msg){
    $r=M($table)->where("$field='%s'",array($code))->find();
    $msg=(empty($r)?true:"已存在");
    return $msg;
}

function check_customize_id($table,$code,$field,$id,&$msg){
	$r=M($table)->where("$field='%s' AND id<>'%d'",array($code,$id))->find();
	$msg=(empty($r)?true:"已存在");
	return $msg;
}

function check_name($table,$name,$id,&$msg){
    $r=M($table)->where("name='%s' AND id<>'%d'",array($name,$id))->select();
    $msg=(count($r)<1?true:"已存在");
    return $msg;
}
function check_short_name($table,$name,$id,&$msg){
	$r=M($table)->where("short_name='%s' AND id<>'%d'",array($name,$id))->select();
	$msg=(count($r)<1?true:"已存在");
	return $msg;
}
function check_full_name($table,$name,$id,&$msg){
	$r=M($table)->where("full_name='%s' AND id<>'%d'",array($name,$id))->select();
	$msg=(count($r)<1?true:"已存在");
	return $msg;
}
function check_cc_code($table,$name,$pid,&$msg){
	$bl=true;
    if(intval($pid)==0){
        return "";
    }

    if(intval($pid)<=0){
		$msg= "上一级必填";
		$bl=false;
	}
	$cate=M($table)->where("id='%s'",array($pid))->find();
	$level=$cate['level']+1;
	if($bl){
		if(preg_match('/[\x{4e00}-\x{9fa5}]+/u',$name)){
			$msg= "不能输入中文";
			$bl=false;
		}
	}
	if($bl){
		$strlength=$level*2;
		if(strlen($name)!= $strlength){
			$msg= "不符合规范,长度应为".$strlength."位";
			$bl=false;
		}
	}
	if($bl){
		if(substr($name,0,-2)!= $cate['code']){
			$msg= "3不符合规范,前缀必须是".$cate['code'];
			$bl=false;
		}
	}
	return $msg;
}

function isNumber($value,&$msg){
    $msg=is_numeric($value)?true:'不是数字';
    return $msg;
}

function check_modify($table,$value,$id,$field,&$msg){
    $r=M($table)->where("id='%d'",array($id))->find();
    $msg=($r[$field]==$value?true:"已被修改");
    return $msg;
}

function check_code_list($code,$name,$table){
    $msg='';
    foreach ($name as $k=>$v) {
        $r= M($table)->where("name='%s'",array($v))->find();
        if(!empty($r) && trim($r['code'])!=trim($code[$k]))
            $msg.='名称['.$v.']与代码['.$code[$k].']不匹配';
    }

    return trim($msg)==''?true:$msg;
}

function notSelf($table,$value,$id,&$msg){
    $msg=($value==$id?'不能与自己相同':true);
    return $msg;
}


function checkPassword($pwd,$id,&$msg){
    $msg=true;

    if(strlen($pwd)<6)
        $msg='长度不能小于6位';

//    if(strtolower($pwd)==$pwd || strtoupper($pwd)==$pwd)
//        $msg='密码必须有大小写混合';

//    if(!preg_match('!([a-zA-Z]+\d+)+|(\d+[a-zA-Z]+)+!',$pwd))
//        $msg='必须有英文和数字混合';

//    if(!preg_match("![-=@#$%^&*()_+~,.?;:<>'\"/\\\[\]\|]+!",$pwd,$match))
//        $msg='必须要有特殊字符';

    $keyboardList=array(
        'qwertyuiop',
        "asdfghjkl;'",
        'zxcvbnm,./',
        '1qaz2wsx3edc4rfv5tgb6yhn7ujm8ik,9ol.0p;/',
    );

    foreach ($keyboardList as $v) {
        $keyboardList[]=strrev($v);
    }

    foreach ($keyboardList as $v) {
        if(!getMaxLengthSubString($v,$pwd)){
            $msg='不能使用键盘上的连续字符';
            break;
        }
    }

    $u=M('user')->where("id='%d'",array($id))->find();

    if(!getMaxLengthSubString($u['code'],$pwd,strlen($u['code']))){
        $msg='请不要使用和用户名相关的信息';
    }
//    var_dump(getMaxLengthSubString($u['code'],$pwd,4));exit;

    return $msg;
}

function getMaxLengthSubString($str1,$str2,$max=3,$case=true){

    $len1=strlen($str1);
    $len2=strlen($str2);

    if(!$case){
        $str1=strtolower($str1);
        $str2=strtolower($str2);
    }

    $list=array();
    for($i=0;$i<$len1;$i++){
        for($j=0;$j<$len2;$j++){
            if($str1[$i]==$str2[$j]){
                $list[]=$i;
            }
        }
    }

    $result=true;
    $count=0;
    $last=intval($list[0])-1;

    foreach ($list as $v) {
        if($last+1==$v){
            $last=$v;
            $count++;
        }else{
            $last=$v;
            $count=1;
        }

        if($count>=$max){
            $result=false;
            break;
        }


    }

    return $result;

}

function comparison__date($table,$date1,$date2,$date2_label,$symbol,&$msg){
    $msg=true;
    switch($symbol){
        case 'g':
            $msg=(($date1>$date2)?true:'应大于'.$date2_label);
            break;
        case 'l':
            $msg=(($date1<$date2)?true:'应小于'.$date2_label);
            break;
        case 'ge':
            $msg=(($date1>=$date2)?true:'应不小于'.$date2_label);
            break;
        case 'le':
            $msg=(($date1<=$date2)?true:'应不大于'.$date2_label);
            break;
        case 'e':
            $msg=(($date1==$date2)?true:'与'.$date2_label.'不相等');
            break;
    }

    return $msg;
}

	function system_format($key, $val, $ez = 0) {
		if($ez) {
			$tmp = $val;
			switch ($key) {
				case "D":
				case "DT":
				case "T":
				case "DM":
				case "DTM":
				case "TM":
				case "DX":
				case "DTX":
				case "TX":
					if(strpos($tmp, '-') !== false || strpos($tmp, '/') !== false) {
						if(strpos($tmp, '1900') !== false) return "";
						$year = substr($tmp, 0, 4);
						$year = intval($year);
						if($year <= 1900) return "";
					}
					break;
				case "N":
				case "N0":
				case "N30":
				case "N3":
				case "F1":
				case "F2":
				case "F3":
				case "F4":
				case "F5":
				case "F6":
				case "F7":
				case "F31":
				case "F32":
				case "F33":
				case "F34":
				case "F35":
				case "F36":
				case "F37":
				case "F%":
				case "F%1":
				case "F%2":
					  if(strpos($tmp, ",") !== false) {
						   $tmp = str_replace(",", "", $tmp);
					  }
						if(is_numeric($tmp)) {
							$tmp = floatval($tmp);
						}else{
							return $tmp;
							$tmp = 0;
						}
					
					if((is_numeric($tmp) &&  floatval($tmp) == 0) || $tmp == "0") {
						return "";
					}
					break;
					
			}
		}
		
		switch ($key) {
			case "N":
			case "N0":
				return intval($val);
			case "N30":
			case "N3":
				$v = intval($val);
				$f = $v < 0;
                $v = abs($v);
				$len = strlen($v);
				$k = "";
				for($i = $len - 3;$i > 0;$i -= 3) {
					$k = "," . substr($v, $i, 3). $k;
					if($i - 3 <= 0) {
						$k = substr($v, 0, $i) . $k;
					}
				}
				if($k == "") {
					$k = $v;
				}
				if($f) $k = "-".$k;
				return $k;
			case "F1":
			case "F2":
			case "F3":
			case "F4":
			case "F5":
			case "F6":
			case "F7":
				if($key == "F1") $precision = 1;
				if($key == "F2") $precision = 2;
				if($key == "F3") $precision = 3;
				if($key == "F4") $precision = 4;
				if($key == "F5") $precision = 5;
				if($key == "F6") $precision = 6;
				if($key == "F7") $precision = 7;
				$k = round($val, $precision, PHP_ROUND_HALF_UP);
				return $k;
			case "F31":
			case "F32":
			case "F33":
			case "F34":
			case "F35":
			case "F36":
			case "F37":
				if($key == "F31") $precision = 1;
				if($key == "F32") $precision = 2;
				if($key == "F33") $precision = 3;
				if($key == "F34") $precision = 4;
				if($key == "F35") $precision = 5;
				if($key == "F36") $precision = 6;
				if($key == "F37") $precision = 7;
				$k = round($val, $precision, PHP_ROUND_HALF_UP);
				
				$pos = strpos($k, ".");
				if($pos === false) {
					$v1 = $k;
					$v2 = "";
				} else {
					$v1 = substr($k, 0, $pos);
					$v2 = substr($k, $pos + 1);
				}
				
				if(strlen($v2) != $precision) {
					$v2 = str_pad($v2, $precision, "0", STR_PAD_RIGHT);
				}
				if($v1 != 0)
					$v1 = system_format("N3", $v1);
				
				$k = $v1 ."." .$v2;
				return $k;
			case "F%":
				return intval($val * 100) . "%";
			case "F%1":
				$k = round(floatval($val * 100), 1, PHP_ROUND_HALF_UP);
				return $k . "%";
			case "F%2":
				$k = round(floatval($val * 100), 2, PHP_ROUND_HALF_UP);
				return $k . "%";
			case "D":
			case "DT":
			case "T":
			case "DM":
			case "DTM":
			case "TM":
			case "DX":
			case "DTX":
			case "TX":
				if($key == "D") $format = "Y/m/d";
				if($key == "DT") $format = "Y/m/d H:i:s";
				if($key == "T") $format = "H:i:s";
				if($key == "DM") $format = "Y/m";
				if($key == "DTM") $format = "Y/m/d H:i";
				if($key == "TM") $format = "H:i";
				if($key == "DX") $format = "Ymd";
				if($key == "DTX") $format = "YmdHis";
				if($key == "TX") $format = "His";
				
				if(is_numeric($val)) return date($format, $val);
				$v = strtotime($val);
				if($v == false || $v == -1) return "";
				return date($format, $v);
		}
		
		return $val;
	}
	


    function step_add(&$step,$desc,$time,$condition){
        $step[]=array(
            'desc'=>$desc,
            'condition'=>$condition,
            'time'=>$time,
        );
    }

    function getOrderStep($step,$step1=array()){
        $s=array();
        $p=0;

        $break_flag=false;
        $cancel=$step1[0];
        $tagup=$step1[1];
        //if($step1[0]['type']=="") $step1[0]['type']="cancel";
        //if($step1[1]['type']=="") $step1[1]['type']="hangup";

        foreach ($step1 as $j=>$v) {
            $break_flag=$v['condition'] || $break_flag;
        }

        foreach ($step as $k=>$v) {
            $cls='';
            if($v['condition']){
                $cls='current';
                $p=$k;
            }else{
                if($break_flag){
						        foreach ($step1 as $j=>$x) {
						        	if($x['condition']){
			                    $s[]=array(
			                        'type'=>'cancel',
			                        'no'=>'&#xe62d;',
			                        'desc'=>$x['desc'],
			                        'time'=>mb_substr(system_format("DT", $x['time']),2,-3),
			                    );
			                    $k++;
						        	}
						        }
/*                	
                    $s[]=array(
                        'type'=>$cancel['condition']?'cancel':'hangup',
                        'no'=>'&#xe62d;',
                        'desc'=>$cancel['condition']?$cancel['desc']:$tagup['desc'],
                        'time'=>$cancel['condition']?mb_substr(system_format("DT", $cancel['time']),2,-3):mb_substr(system_format("DT", $tagup['time']),2,-3),
                    );
*/
                    $p=$k;
                    break;
                }

            }
            $s[]=array(
                'type'=>$cls,
                'no'=>$k+1,
                'desc'=>$v['desc'],
                'time'=>mb_substr(system_format("DT", $v['time']),2,-3),
            );

        }


        for($i=0;$i<$p;$i++){
            $s[$i]['type']='after';
        }



        return $s;

    }


function change_to_quotes($str) {
	return sprintf("'%s'", $str);
}

function sql_condition($condition, $field, $value,$type="char",$opt="=",$skipcheck=0)  //opt = > < >= <= like likeleft likeright
{
	//if (!$skipcheck)
	//{
	//	if(!$value) return $condition ;
	//}
	$condition.=" AND ";
	if(!$opt)$opt="=";

	$field = table($field); // erp_

	switch($type)
	{
		case "int":
		case "num":
		case "bool":
			if(!$value) $value=0 ;
			if($opt=="both" || $opt=="left" || $opt=="right") $opt="=";
			$condition.=$field.$opt.$value;
			break;
		case "date":
		case "datetime":
			if(!$value)
				$tmp ="0000/00/00" ;
				else {
					$tmp = strtotime($value);
					$tmp = date("Y-m-d", $tmp);
				}
				$tmp .= " 00:00:00";
				$condition.=$field.$opt."'$tmp'";
				break;
		case "time":
			if(!$value)
				$tmp ="0000/00/00 00:00:00" ;
				else {
					$tmp = strtotime($value);
					$tmp = "0000/00/00 ".date("H:i:s", $tmp);
				}
				$condition.=$field.$opt."'$tmp'";
				break;
		case "timestamp":
			if(!$value)
				$tmp ="0000/00/00" ;
				else {
					$tmp = strtotime($value);
					$tmp = date("Y-m-d", $tmp);
				}
				$tmp1 = strtotime($tmp ." 00:00:00");
				$tmp2 = strtotime($tmp ." 23:59:59");
				$condition .= "$field >= '$tmp1' AND $field <= '$tmp2'";
				break;
		default:  //char
			if(!$value) $value="";
			switch($opt)
			{
				case "both":
					$condition .= $field." like '%$value%'";
					break;
				case "left":
					$condition .= $field." like '$value%'";
					break;
				case "right":
					$condition .= $field." like '%$value'";
					break;
				default:
					$condition .= $field.$opt."'$value'";
					break;
			}
			break;
	}
	return  $condition ;
}


function arr_compare($array1, $array2){
	$keys=array_keys($array1);
	$before=array();
	$after=array();
	$diff=array();
	foreach ($keys as $val)
	{
		if(isset($array2[$val]))
		{
			if($array1[$val]!=$array2[$val])
			{
				$before[$val]=$array1[$val];
				$after[$val]=$array2[$val];
			}
		}
	}
	if($before || $after)
	{
		$diff[1]=$before;
		$diff[2]=$after;
	}
	return  $diff;
}


function getRoleShopChoose($id){
    $ss=M('role_shop')->where("role_id='%d'",array($id))->select();
    $scs=array();
    foreach ($ss as $sv) {
        $scs[]=$sv['shop_id'];
    }

    return join(",",$scs);
}

function getRoleUserChoose($id){
    $ss=M('role_user')->where("role_id='%d'",array($id))->select();
    $scs=array();
    foreach ($ss as $sv) {
        $scs[]=$sv['user_id'];
    }

    return join(",",$scs);
}



function getCategoryTree($items){
    foreach($items as $item)
        $items[$item['parent_id']]['son'][$item['id']] = &$items[$item['id']];
    return isset($items[0]['son']) ? $items[0]['son'] : array();
}

function getTreeData($tree,$selecttype){
    $html='';
    foreach($tree as $t){
        $html.= '<li><input j="'.json_encode($t).'" type="'.(strtolower($selecttype)== 'multi'?'checkbox':'radio').'" name="code[]" value="'.$t[code].'" show="'.$t[name].'">'.$t['name'].'</li>';
        if(isset($t['son'])){
            $html.= '<li><ul>'.getTreeData($t['son'],$selecttype).'</ul></li>';
        }
    }
    return $html;
}


function instr($source, $check) {
	$s = explode(",", $source);
	return in_array($check, $s);
}

function replace_address($address) {
	$address = str_replace("{", "", $address);
	$address = str_replace("}", "", $address);
	$address = str_replace("｛", "", $address);
	$address = str_replace("｝", "", $address);
	return $address;
}


function getSystemParameter($code, $value=true,$default="") {
	if($value){
		$para = M("system_parameter")->where("code = '$code' AND status = 1")->getField("value");
		if (trim($para)=="" && trim($default)!=""){
			  $para=$default;
		}
	}
	else
		$para = M("system_parameter")->where("code = '$code'")->getField("status");
  return $para;
}

function setSystemParameter($code, $value) {
    $result = M("system_parameter")->where("code = '$code' AND status = 1")->save(array("value"=>"$value"));
    if(!$result )
        throw new Exception("更新系统参数($code)失败-不存在或参数已失效");
    return true;
}

/**
 * 获取当前页面完整URL地址
 */
function get_url() {
	$sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
	$php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
	$path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
	$relate_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : $path_info);
	return $sys_protocal.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '').$relate_url;
}

function charlevel($level, $char="-"){
    $char=$char.$char;
	  if($level==2) return $char;
	  if($level==3) return $char.$char;
      if($level==4) return $char.$char.$char;
	  return "";
}

function tabTitle($title,$str="",$right="R", $len=0){
    if($str=="")
        return $title;
    $right=strtoupper($right);
    $strlen = strlen($str);
    $title=mb_substr($title,0,2,'utf-8');
    $char="-";
    $last=substr($title,strlen($title)-1,1);
    if($last==":" || $last=="-" || $last=="#"){
        $char="";
    }

    if ($len<=0 || $strlen <= $len)
        return $title.$char.$str;
    if( $right=="R" || $right=="RIGHT" )
        return $title.$char.substr($str,$strlen -$len,$len);
    else
        return $title.$char.substr($str,0,$len-1);
}

function mb_str_split($str){
    return preg_split('/(?<!^)(?!$)/u', $str );
}

function xfloatval($value){
    return round(floatval($value),3);
}

function enums($type,$start,$end,$templet="")
{
    $data = array();
    $start = trim(strtolower($start));
    $end = trim(strtolower($end));
    $type = trim(strtolower($type));
    switch ($type) {
        case "num":
            $start = intval($start);
            $end = intval($end);
            if ($start < 0) $start = 0;
            if ($end < 0) $end = $start + 10;
            if ($start <= $end) {
                if ($end - $start > 100) $end = $start + 100;
                for ($i = $start; $i <= $end; $i++) {
                    $data[$i] = array("id" => $i, "name" => $i);
                }
            } else {
                if ($start - $end > 100) $start = $end - 100;
                for ($i = $end; $i >= $start; $i--) {
                    $data[$i] = array("id" => $i, "name" => $i);
                }
            }
            break;
        case "year":
            switch ($start) {
                case "cur":
                case "now":
                    $start = date("Y");
                    break;
                case "min":
                    $start = 2016;
                    break;
                default:
                    $start = intval(substr($start, 0, 4));
                    if ($start < 1970) $start = 1970;
                    if ($start > 2020) $start = 2020;
                    break;
            }
            switch ($end) {
                case "cur":
                case "now":
                    $end = date("Y");
                    break;
                case "min":
                    $end = 2016;
                    break;
                default:
                    $end = intval(substr($end, 0, 4));
                    if ($end < 1970) $end = 1970;
                    if ($end > 2020) $end = 2020;
                    break;
            }

            if ($start <= $end) {
                if ($end - $start > 100) $end = $start + 100;
                for ($i = $start; $i <= $end; $i++) {
                    $data[$i] = array("id" => $i, "name" => $i);
                }
            } else {
                if ($start - $end > 100) $start = $end - 100;
                for ($i = $start; $i >= $end; $i--) {
                    $data[$i] = array("id" => $i, "name" => $i);
                }
            }
            break;
        case "month":

            switch ($start) {
                case "cur":
                case "now":
                    $start_year = date("Y");
                    $start_month = date("m");
                    break;
                case "end":
                    $start_year = date("Y");
                    $start_month = 12;
                    break;
                default:
                    $start_year = intval(substr($start, 0, 4));
                    $start_month = intval(substr($start, 5, 2));
                    break;
            }
            switch ($end) {
                case "cur":
                case "now":
                    $end_year = date("Y");
                    $end_month = date("m");
                    break;
                case "end":
                    $end_year = date("Y");
                    $end_month = 12;
                    break;
                default:
                    $end_year = intval(substr($end, 0, 4));
                    $end_month = intval(substr($end, 5, 2));
                    break;
            }
            if ($end_month < 1) $end_month = 1;
            if ($end_month > 12) $end_month = 12;
            if ($start_month < 1) $start_month = 1;
            if ($start_month > 12) $start_month = 12;
            //echo "start|$start_year|$start_month <br/>";
            //echo "end|$end_year|$end_month <br/>";

            $bless = $start_year >= $end_year;
            $last = "$end_year-" . str_pad($end_month, 2, "0", STR_PAD_LEFT);
            $i = 0;
            while (1) {
                $m = "$start_year-" . str_pad($start_month, 2, "0", STR_PAD_LEFT);

                //echo "nnnnn|$m| <br/>";
                $data[$i] = array("id" => $m, "name" => $m);
                if ($m == $last) break;

                if ($bless) {
                    $start_month--;
                    if ($start_month < 1) {
                        $start_month = 12;
                        $start_year--;
                    }
                    if ($start_year < $end_year) break;
                } else {
                    $start_month++;
                    if ($start_month > 12) {
                        $start_month = 1;
                        $start_year++;
                    }
                    if ($start_year > $end_year) break;
                }
                $i++;
            }
            break;
        default:
            break;
    }
    if($templet){
    	  foreach($data as $k=>$v){
    	  	  $data[$k]["name"]=str_replace("%", $data[$k]["name"], $templet); 
    	  }
    }
    return $data;
}

function years($first_year=2010,$next_after_now=5,$templet=""){

    $year = date("Y");
    if($first_year=="NOW" || $first_year=="CUR")
        $first_year= $year ;
    else{
        $first_year= intval($first_year);
        if($first_year<999 || $first_year>2100) $first_year=2010;
    }
    $next_after_now= intval($next_after_now);
    if($next_after_now<0 || $next_after_now>50) $next_after_now=5;

    $years=array();

    for($i=$first_year;$i<=($year+$next_after_now);$i++){
        $years[$i]= array("id"=>$i,"name"=>$i);
    }
    
    
    if($templet){
    	  foreach($data as $k=>$v){
    	  	  $years[$k]["name"]=str_replace("%", $years[$k]["name"], $templet); 
    	  }
    }

    return $years;
}

function subcode($type){
    $ret=M('subcode')->field('id,code,name')->where("status=1 and type='$type'")->order('sort')->select();

    $subcodes=array();
    foreach ($ret as $s){
        $subcodes[$s['id']]= array("id"=>$s['id'],"code"=>$s['code'],"name"=>$s['name']);
    }
    return $subcodes;
}

function subcode_view($type,$code){
    $ret=M('subcode')->field('name')->where("type='$type' and code='$code'" )->find();
    return $ret['name'];
}

function spaces($count){
//    echo  "spaces=$count";
    if($count>0 && $count<100){
        return str_repeat("&nbsp;", $count);
    } else
    {
        if($count<0) return "";
        if($count>100) return str_repeat("&nbsp;", 100);
    }
}
function strings($char,$count){
    if($count>0 && $count<100){
        return str_repeat($char, $count);
    } else
    {
        if($count<0) return "";
        if($count>100) return str_repeat($char, 100);
    }
}

function Gen_Number($type,$mainkey,$subkey)
{
    if (!$type ) {
        throw new Exception("gen number failed - type/mainkey is empty");
    }

    $model = M("system_gen");
    $save = array();
    $save["modify_time"]=date("Y-m-d H:i:s");

    $m = $model->field("id,seqno,lastchanged")->where("type='$type' and mainkey='$mainkey' and subkey='$subkey'")->find();
    if ($m) {
        $id = $m['id'];
        $save["seqno"] = $m['seqno'] + 1;
        $result = $model->where("id=$id and lastchanged='" . $m['lastchanged'] . "'")->save($save);
    } else {
        $save["type"] = $type;
        $save["mainkey"] = $mainkey;
        $save["subkey"] = $subkey;
        $save["seqno"] = 1;
        $save["create_time"]=date("Y-m-d H:i:s");
        $result = $id = $model->add($save);
    }
    if (!$result) throw new Exception("gen number failed");

    return $save['seqno'];
}


function unsetArray($a, $i) {
    if(empty($a)) return $a;
    if(!isset($a[$i])) return $a;
    unset($a[$i]);
    $c = array();
    foreach($a as $b) {
        $c[] = $b;
    }
    return $c;
}

function sys_date_format($format,$date){
    if(empty($date))
    {
        return "无";
    }else
    {
        return date($format,strtotime($date));
    }
}



function num2upper ($num)
{
    $c1 = "零壹贰叁肆伍陆柒捌玖";
    $c2 = "分角元拾佰仟万拾佰仟亿";
    $num = round($num, 2);
    $num = $num * 100;
    if (strlen($num) > 10) {
        return "oh,sorry,the number is too long!";
    }
    $i = 0;
    $c = "";
    while (1) {
        if ($i == 0) {
            $n = substr($num, strlen($num) - 1, 1);
        } else {
            $n = $num % 10;
        }
        $p1 = substr($c1, 3 * $n, 3);
        $p2 = substr($c2, 3 * $i, 3);
        if ($n != '0' || ($n == '0' && ($p2 == '亿' || $p2 == '万' || $p2 == '元'))) {
            $c = $p1 . $p2 . $c;
        } else {
            $c = $p1 . $c;
        }
        $i = $i + 1;
        $num = $num / 10;
        $num = (int)$num;
        if ($num == 0) {
            break;
        }
    }
    $j = 0;
    $slen = strlen($c);
    while ($j < $slen) {
        $m = substr($c, $j, 6);
        if ($m == '零元' || $m == '零万' || $m == '零亿' || $m == '零零') {
            $left = substr($c, 0, $j);
            $right = substr($c, $j + 3);
            $c = $left . $right;
            $j = $j - 3;
            $slen = $slen - 3;
        }
        $j = $j + 3;
    }
    if (substr($c, strlen($c) - 3, 3) == '零') {
        $c = substr($c, 0, strlen($c) - 3);
    } // if there is a '0' on the end , chop it out
    return $c . "整";
}

function num2upper_weight($num)
{
//    if(strpos($num,".")>0)
//    {
        $nums_arr=explode(".",$num);
//    }

    $upper=str_replace("元整","",num2upper($nums_arr[0]));
    if(isset($nums_arr[1]))
    {
        if($nums_arr[1]>0)
        {
            $upper.="点";
            $c1 = "零壹贰叁肆伍陆柒捌玖";
            $j = 0;
            $slen = strlen($nums_arr[1]);
            while ($j < $slen) {
                $m =mb_substr($nums_arr[1], $j, 1);
                $upper.=mb_substr($c1,$m,1);
                $j ++;
            }
        }

    }
    $upper=rtrim($upper,"零");
    return $upper;
}

function getNow() {
    return date("Y-m-d H:i:s");
}

function send($url, $post) {
    $curl = curl_init();
    curl_setopt ($curl, CURLOPT_URL, $url);
    curl_setopt ($curl, CURLOPT_HEADER,0);
    curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($curl, CURLOPT_POST,1);
    curl_setopt ($curl, CURLOPT_POSTFIELDS, $post);
    curl_setopt ($curl, CURLOPT_TIMEOUT, 10);
    $get_content = curl_exec($curl);
    curl_close ($curl);

    return $get_content;
}

function json_encode_pre($d, $depth=128, $level=0){
    if($level>$depth) return $d;
    if(is_array($d)){
        foreach ($d as $i => $v) { $d[$i] = json_encode_pre($v, $depth, $level+1); }
        return $d;
    }
    if(is_float($d)){
        $p = 16 - strlen($d);
        $f = number_format($d, $p);
        if($p>1){ $f = preg_replace('/0+$/','', $d); }
        return $f;
    }
    return $d;
}