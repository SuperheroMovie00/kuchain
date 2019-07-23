<?php
header("Content-Type:text/html;charset=utf-8");

$apikey = "52e1c4d5378d9fea78b7acb68ead5d3b"; //修改为您的apikey(https://www.yunpian.com)登录官网后获取

$mobile =$_POST['mobile']; //获取传入的手机号

// $mobile = "xxxxxxxxxxx"; //请用自己的手机号代替

$num = rand(1000,9999);   //随机产生四位数字的验证码

setcookie('shopCode',$num);

$text="【蒙羊羊】您的验证码是".$num."。";

$ch = curl_init();

/* 设置验证方式 */

curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept:text/plain;charset=utf-8', 'Content-Type:application/x-www-form-urlencoded', 'charset=utf-8'));

/* 设置返回结果为流 */

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

/* 设置超时时间*/

curl_setopt($ch, CURLOPT_TIMEOUT, 10);

/* 设置通信方式 */

curl_setopt($ch, CURLOPT_POST, 1);

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);



// 取得用户信息

$json_data = get_user($ch,$apikey);

$array = json_decode($json_data,true);

// echo '<pre>';print_r($array);



// 发送短信

$data=array('text'=>$text,'apikey'=>$apikey,'mobile'=>$mobile);

$json_data = send($ch,$data);

$array = json_decode($json_data,true);

// echo '<pre>';print_r($array);



// 发送模板短信

// 需要对value进行编码

$data = array('tpl_id' => '1', 'tpl_value' => ('#code#').

    '='.urlencode($num).

    '&'.urlencode('#company#').

    '='.urlencode('蒙羊羊'), 'apikey' => $apikey, 'mobile' => $mobile);

// print_r ($data);

$json_data = tpl_send($ch,$data);

$array = json_decode($json_data,true);





echo $num;





// 发送语音验证码

// $data=array('code'=>$num,'apikey'=>$apikey,'mobile'=>$mobile);

// $json_data =voice_send($ch,$data);

// $array = json_decode($json_data,true);

// echo $num;



// 发送语音通知，务必要报备好模板

/*

模板： 课程#name#在#time#开始。 最终发送结果： 课程深度学习在14:00开始

 */



$tpl_id = 'xxxxxxx'; //修改为你自己后台报备的模板id

$tpl_value = urlencode('#time#').'='.urlencode($num).'&'.urlencode('#name#').'='.urlencode('蒙羊羊');

$data=array('tpl_id'=>$tpl_id,'tpl_value'=>$tpl_value,'apikey'=>$apikey,'mobile'=>$mobile);

$json_data = notify_send($ch,$data);

$array = json_decode($json_data,true);

// echo $num;

curl_close($ch);



/************************************************************************************/

//获得账户

function get_user($ch,$apikey){

    curl_setopt ($ch, CURLOPT_URL, 'https://sms.yunpian.com/v2/user/get.json');

    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('apikey' => $apikey)));

    $result = curl_exec($ch);

    $error = curl_error($ch);

    checkErr($result,$error);

    return $result;

}

function send($ch,$data){

    curl_setopt ($ch, CURLOPT_URL, 'https://sms.yunpian.com/v2/sms/single_send.json');

    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

    $result = curl_exec($ch);

    $error = curl_error($ch);

    checkErr($result,$error);

    return $result;

}

function tpl_send($ch,$data){

    curl_setopt ($ch, CURLOPT_URL, 'https://sms.yunpian.com/v2/sms/tpl_single_send.json');

    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

    $result = curl_exec($ch);

    $error = curl_error($ch);

    checkErr($result,$error);

    return $result;

}

function voice_send($ch,$data){

    curl_setopt ($ch, CURLOPT_URL, 'http://voice.yunpian.com/v2/voice/send.json');

    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

    $result = curl_exec($ch);

    $error = curl_error($ch);

    checkErr($result,$error);

    return $result;

}

function notify_send($ch,$data){

    curl_setopt ($ch, CURLOPT_URL, 'https://voice.yunpian.com/v2/voice/tpl_notify.json');

    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

    $result = curl_exec($ch);

    $error = curl_error($ch);

    checkErr($result,$error);

    return $result;

}



function checkErr($result,$error) {

    if($result === false)

    {

        echo 'Curl error: ' . $error;

    }

    else

    {

//echo '操作完成没有任何错误';

    }

}

?>