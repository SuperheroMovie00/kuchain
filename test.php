<?php
/**
 * Created by PhpStorm.
 * User: Super
 * Date: 2019-07-02
 * Time: 13:40
 */




$id=1;
$name='';

$comstomer=M("customer")->where($id);

if(empty($comstomer)){


}else{
$name=$comstomer["name"];

}

?>