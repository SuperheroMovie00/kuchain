<?php
/**
 * Created by PhpStorm.
 * User: gunduzi8
 * Date: 2019/7/9
 * Time: 15:59
 */

namespace Api\Controller;
use Think\Controller;
include_once COMMON_PATH . "Common/project.php";
class V1Controller extends Controller {
    private $API_ERROR_AUTHENTICATION_FAIL = -999;
    private $API_ERROR_POST_EMPTY = -999;
    private $API_ERROR_POST_ERROR = -998;
    private $API_ERROR_SIGN_FAIL = -997;
    private $API_ERROR = -100;
    private $API_ERROR_RELEASE_ASSIGN = -201;
    private $API_ERROR_RELOCK_STOCK = -201;
    private $API_ERROR_UPDATE_TRADE = -101;
    private $API_ERROR_UPDATE_TRADE_ASSIGN = -102;
    private $API_ERROR_UPDATE_TRADE_BUTTRESS = -103;
    private $API_ERROR_UPDATE_STOCK = -104;
    private $API_SUCCESS = 1;

    private $apiUser = "system";
    private $isTest = false;
    public function index() {
        $data = file_get_contents("php://input");
        if($this->isTest) {
            $data=$_POST["val"];
            $data = urldecode($data);
        }
        $this->log($data);
        $auth = $this->checkSign($data);

        $method = I("get.method");
        try {
            $data = json_decode($data, true);
        } catch (\Exception $e) {
            $this->result(false, $this->API_ERROR_POST_ERROR);
        }

        switch ($method) {
            case "stock":
                $this->stock($auth, $data);
                break;
            case "trade":
                $this->trade($auth, $data);
                break;
            default:
                break;
        }
    }

    private function stock($auth, $data) {
        $now = getNow();
        M()->startTrans();
        foreach($data as $key=>$val) {
            $goods = M("goods")->where("org_id = ".$auth["org_id"]." AND goods_no = '".$val["goods_no"]."'")->find();
            if(empty($goods)) {
                M()->rollback();
                $this->result(false, $this->API_ERROR, "商品".$val["goods_no"]."不存在");
            }
            $card = M("storecard")->where("org_id = ".$auth["org_id"]." AND customer_id = ".$auth["id"]." AND storecard_no = '".$val["card_no"]. "'")->find();
            $cardId = 0;
            $save = array();
            if(empty($card)) {
                $save["org_id"]=$auth["org_id"];
                $save["customer_id"]=$auth["id"];
                $save["storecard_no"]=$val["card_no"];
                $save["warehouse_code"]=$val["warehouse_code"];
                $save["customer_name"]=$auth["name"];
                $save["goods_id"]=$goods["id"];
                $save["goods_no"]=$goods["goods_no"];
                $save["goods_name"]=$goods["name"];
                $save["style_info"]=$goods["style_info"];
                $save["brand"]=$goods["brand"];
                $save["producing_area"]=$goods["producing_area"];
                $save["style_code"]=$goods["style_code"];
                $save["weight"]=$val["weight"];
                $save["qty"]=$val["qty"];
                $save["bulkcargo"]=$val["bulkcargo"];
                $save["lock_weight"]=0;
                $save["lock_qty"]=0;
                $save["lock_bulkcargo"]=0;
                $save["uom_qty"]=$val["uom_qty"];
                $save["uom_weight"]=$val["uom_weight"];
                $save["uom_bulkcargo"]=$val["uom_bulkcargo"];
                $save["contact_id"]="";
                $save["contact_no"]="";
                $save["status"]=1;
                $save["create_user"]=$this->apiUser;
                $save["create_time"]=$now;
                $save["modify_user"]=$this->apiUser;
                $save["modify_time"]=$now;
                $save["stockin_date"]="";
                $save["materials"]=$goods["materials"];
                $save["type"]=1;
                $cardId = M("storecard")->add($save);
            } else {
                $save["weight"]=$val["weight"];
                $save["qty"]=$val["qty"];
                $save["bulkcargo"]=$val["bulkcargo"];
                $save["modify_user"]=$this->apiUser;
                $save["modify_time"]=$now;
                M("storecard")->where("id = ".$card["id"])->save($save);
                $cardId = $card["id"];
            }
            if(!isset($val["package"]) && !empty($val["package"])) {
                foreach($val["package"] as $subVal) {
                    $package = M("storecard_package")->where("org_id = ".$auth["org_id"]." AND customer_id = ".$auth["id"]." AND package_no = '".$subVal["package_no"]."'")->find();
                    $save=array();
                    if(empty($package)) {
                        $save["org_id"]=$auth["org_id"];
                        $save["customer_id"]=$auth["id"];
                        $save["storecard_id"]=$cardId;
                        $save["storecard_no"]=$val["card_no"];
                        $save["package_no"]=$subVal["package_no"];
                        $save["customer_name"]=$auth["name"];
                        $save["package_from"]="";
                        $save["package_orig"]="";
                        $save["warehouse_code"]=$val["warehouse_code"];
                        $save["location_code"]="";
                        $save["location_futures"]="";
                        $save["stock_date"]="";
                        $save["stock_order"]="";
                        $save["batch_no"]="";
                        $save["arrival_type"]="";
                        $save["stock_type"]="";
                        $save["carno"]="";
                        $save["goods_id"]=$goods["id"];
                        $save["goods_no"]=$goods["goods_no"];
                        $save["goods_name"]=$goods["name"];
                        $save["style_info"]=$goods["style_info"];
                        $save["brand"]=$goods["brand"];
                        $save["producing_area"]=$goods["producing_area"];
                        $save["style_code"]=$goods["style_code"];
                        $save["materials"]=$goods["materials"];

                        $save["weight_in"]=$val["weight"];
                        $save["qty_in"]=$val["qty"];
                        $save["bulkcargo_in"] = $val["bulkcargo"];
                        $save["weight_out"]=0;
                        $save["qty_out"]=0;
                        $save["bulkcargo_out"]=0;
                        $save["weight"]=$val["weight"];
                        $save["qty"]=$val["qty"];
                        $save["bulkcargo"]=$val["bulkcargo"];
                        $save["status"]=1;
                        $save["create_user"]=$this->apiUser;
                        $save["create_time"]=$now;
                        $save["modify_user"]=$this->apiUser;
                        $save["modify_time"]=$now;
                        $save["is_lock"]=0;
                        $save["uom_qty"]=$val["uom_qty"];
                        $save["uom_weight"]=$val["uom_weight"];
                        $save["uom_bulkcargo"]=$val["uom_bulkcargo"];
                        $save["lock_weight"]=0;
                        $save["lock_qty"]=0;
                        $save["lock_bulkcargo"]=0;
                        M("storecard_package")->add($save);
                    } else {
                        $save["weight"]=$val["weight"];
                        $save["qty"]=$val["qty"];
                        $save["bulkcargo"]=$val["bulkcargo"];
                        $save["modify_user"]=$this->apiUser;
                        $save["modify_time"]=$now;
                        M("storecard_package")->where("id = ".$package["id"])->save($save);
                    }
                }
            }
        }
        M()->commit();
        $this->result(true);
    }
    private function trade($auth, $data) {
        $errorTrade = array();
        $now = getNow();
        foreach($data["trade"] as $val) {
            $result = $this->getTradeData($auth, $val, 5);
            if($result["flag"] == false) {
                $errorTrade[] = array("trade_no"=>$val["trade_no"], "code"=>$result["code"], "message"=>$result["msg"]);
                continue;
            }
            $trade = $result["trade"];
            $c = $result["card"];
            $p = $result["package"];
            $b = $result["buttress"];
            M()->startTrans();
            $diff = checkAssignDiff($trade["id"], $c, $p, $b);
            if($diff != false) {
                $cd = $diff["card"];
                $pd = $diff["package"];
                $bd = $diff["buttress"];
                $result = assign($trade["id"], 0, $cd, $pd, $bd, false);
                if(!$result) {
                    M()->rollback();
                    $errorTrade[] = array("trade_no"=>$val["trade_no"], "code"=>$this->API_ERROR_RELOCK_STOCK, "message"=>"重新锁定库存失败");
                    continue;
                }
            }

            foreach($c as $k=>$v) {
                $result = M("trade_assign")->where("trade_id=".$trade["id"]." AND storecard_id = ".$k)->save(array(
                    "act_weight"=>$v["weight"],
                    "act_qty"=>$v["qty"],
                    "act_bulkcargo"=>floatval($v["bulkcargo"]),
                    "act_time"=>$now
                ));
                if(!$result) {
                    $errorTrade[] = array("trade_no"=>$val["trade_no"], "code"=>$this->API_ERROR_UPDATE_TRADE_ASSIGN, "message"=>"更新交易单失败");
                    break;
                }
                foreach($p[$k] as $k1=>$v1) {
                    if(!empty($b) && isset($b[$k]) && isset($b[$k][$k1])) {
                        foreach($b[$k][$k1] as $k2=>$v2) {
                            $result = M("trade_assign_buttress")->where("trade_id=".$trade["id"]." AND storecard_id = ".$k." AND package_id =".$k1." AND buttress_id =".$k2)->save(array(
                                "act_weight"=>$v2["weight"],
                                "act_qty"=>$v2["qty"],
                                "act_bulkcargo"=>floatval($v2["bulkcargo"]),
                                "act_time"=>$now
                            ));
                            if(!$result) {
                                $errorTrade[] = array("trade_no"=>$val["trade_no"], "code"=>$this->API_ERROR_UPDATE_TRADE_BUTTRESS, "message"=>"更新交易单失败");
                                break;
                            }
                        }
                        if(!$result) {
                            break;
                        }
                    } else {
                        $result = M("trade_assign_buttress")->where("trade_id=".$trade["id"]." AND storecard_id = ".$k." AND package_id =".$k1)->save(array(
                            "act_weight"=>$v1["weight"],
                            "act_qty"=>$v1["qty"],
                            "act_bulkcargo"=>floatval($v1["bulkcargo"]),
                            "act_time"=>$now
                        ));
                        if(!$result) {
                            $errorTrade[] = array("trade_no"=>$val["trade_no"], "code"=>$this->API_ERROR_UPDATE_TRADE_BUTTRESS, "message"=>"更新交易单失败");
                            break;
                        }
                    }
                }
                if(!$result) {
                    break;
                }
            }

            if(!$result) {
                M()->rollback();
                continue;
            }
            $result = releaseAssign($trade["id"]);
            if(!$result) {
                M()->rollback();
                $errorTrade[] = array("trade_no"=>$val["trade_no"], "code"=>$this->API_ERROR_RELEASE_ASSIGN, "message"=>"更新交易单失败");
                continue;
            }
            $save = array();
            $save["act_weight"] = $data["weight"];
            $save["act_qty"] = $data["qty"];
            $save["act_time"] = $now;
            $save["act_order"] = $data["order"];
            $save["status"] = 6;
            $result = M("trade")->where("id=".$trade["id"]." AND status = 5")->save($save);
            if(!$result) {
                M()->rollback();
                $errorTrade[] = array("trade_no"=>$val["trade_no"], "code"=>$this->API_ERROR_UPDATE_TRADE, "message"=>"更新交易单失败");
                continue;
            }
            $result = stock($trade["id"]);
            if(!$result) {
                M()->rollback();
                $errorTrade[] = array("trade_no"=>$val["trade_no"], "code"=>$this->API_ERROR_UPDATE_STOCK, "message"=>"更新交易单库存失败");
                continue;
            }
        }
        if(count($errorTrade) == count($data)) {
            M()->rollback();
            $this->result(false, $this->API_ERROR, "", $errorTrade);
        } else {
            M()->commit();
            $this->result(true, $this->API_SUCCESS, "", $errorTrade);
        }
    }

    private function getTradeData($auth, $val, $status = 3) {
        $trade = M("trade")->where("customer_id = ".$auth["id"]." AND trade_no = '".$val["trade_no"]."' AND status = ".$status)->find();
        if(empty($trade)) {
            return array("flag"=>false,"code"=>$this->API_ERROR, "msg"=>"交易订单[".$val["trade_no"]."]不存在或无效");
        }
        $goods = M("goods")->where("id = ".$trade["goods_id"])->find();
        if(empty($goods)) {
            return array("flag"=>false,"code"=>$this->API_ERROR, "msg"=>"交易订单[".$val["trade_no"]."]商品不存在或无效");
        }
        $assignButtress = $goods["assign_mode"];

        $c = array();
        $p = array();
        $b = array();
        $packageWeight = 0;
        $packageQty = 0;
        foreach($val["package"] as $subVal) {
            $subVal["weight"] = floatval($subVal["weight"]);
            $subVal["qty"] = floatval($subVal["qty"]);
            $subVal["bulkcargo"] = floatval($subVal["bulkcargo"]);
            if(!isset($subVal["weight"]) || $subVal["weight"] <= 0) {
                return array("flag"=>false,"code"=>$this->API_ERROR, "msg"=>"交易订单[".$val["trade_no"]."]明细:码单[".$subVal["package_no"]."]发货重量不正确");
            }
            if(!isset($subVal["qty"]) || $subVal["qty"] <= 0) {
                return array("flag"=>false,"code"=>$this->API_ERROR, "msg"=>"交易订单[".$val["trade_no"]."]明细:码单[".$subVal["package_no"]."]发货数量不正确");
            }
            $package = M("storecard_package")->where("package_no = '".$subVal["package_no"]."' AND status = 1")->find();
            if(empty($package)) {
                return array("flag"=>false,"code"=>$this->API_ERROR, "msg"=>"交易订单[".$val["trade_no"]."]明细:码单[".$subVal["package_no"]."]不存在或无效");
            }
            if(!isset($c[$package["storecard_id"]])) {
                $c[$package["storecard_id"]]["weight"] = $subVal["weight"];
                $c[$package["storecard_id"]]["qty"] = $subVal["qty"];
                $c[$package["storecard_id"]]["bulkcargo"] = $subVal["bulkcargo"];
            } else {
                $c[$package["storecard_id"]]["weight"] += $subVal["weight"];
                $c[$package["storecard_id"]]["qty"] += $subVal["qty"];
                $c[$package["storecard_id"]]["bulkcargo"] += $subVal["bulkcargo"];
            }

            if(!isset($p[$package["storecard_id"]])) {
                $p[$package["storecard_id"]] = array();
            }
            if(!isset($p[$package["storecard_id"]][$package["id"]])) {
                $p[$package["storecard_id"]][$package["id"]]["weight"] = $subVal["weight"];
                $p[$package["storecard_id"]][$package["id"]]["qty"] = $subVal["qty"];
                $p[$package["storecard_id"]][$package["id"]]["bulkcargo"] = $subVal["bulkcargo"];
            } else {
                $p[$package["storecard_id"]][$package["id"]]["weight"] += $subVal["weight"];
                $p[$package["storecard_id"]][$package["id"]]["qty"] += $subVal["qty"];
                $p[$package["storecard_id"]][$package["id"]]["bulkcargo"] += $subVal["bulkcargo"];
            }
            if($assignButtress) {
                $buttressWeight = 0;
                $buttressQty = 0;
                if(!isset($subVal["buttress"])) {
                    return array("flag"=>false,"code"=>$this->API_ERROR, "msg"=>"交易订单[".$val["trade_no"]."]明细:码单[".$subVal["package_no"]."]无有效明细");
                }
                foreach($subVal["buttress"] as $sb) {
                    $sb["weight"] = floatval($sb["weight"]);
                    $sb["qty"] = floatval($sb["qty"]);
                    if(!isset($sb["weight"]) || $sb["weight"] <= 0) {
                        return array("flag"=>false,"code"=>$this->API_ERROR, "msg"=>"交易订单[".$val["trade_no"]."]明细:码单[".$subVal["package_no"]."]明细:垛号[".$sb["buttress_no"]."]发货重量不正确");
                    }
                    if(!isset($sb["qty"]) || $sb["qty"] <= 0) {
                        return array("flag"=>false,"code"=>$this->API_ERROR, "msg"=>"交易订单[".$val["trade_no"]."]明细:码单[".$subVal["package_no"]."]明细:垛号[".$sb["buttress_no"]."]发货数量不正确");
                    }
                    $buttress = M("storecard_buttress")->where("package_no = '".$subVal["package_no"]."' AND buttress_no = '".$sb["buttress_no"]."'")->find();
                    if(empty($buttress)) {
                        return array("flag"=>false,"code"=>$this->API_ERROR, "msg"=>"交易订单[".$val["trade_no"]."]明细:码单[".$subVal["package_no"]."]明细:垛号[".$sb["buttress_no"]."]不存在");
                    }
                    if(!isset($b[$package["storecard_id"]])) {
                        $b[$package["storecard_id"]] = array();
                    }
                    if(!isset($b[$package["storecard_id"]][$package["id"]])) {
                        $b[$package["storecard_id"]][$package["id"]] = array();
                    }
                    if(!isset($b[$package["storecard_id"]][$package["id"]][$buttress["id"]])) {
                        $b[$package["storecard_id"]][$package["id"]][$buttress["id"]]["weight"] = $sb["weight"];
                        $b[$package["storecard_id"]][$package["id"]][$buttress["id"]]["qty"] = $sb["qty"];
                        $b[$package["storecard_id"]][$package["id"]][$buttress["id"]]["bulkcargo"] = $sb["bulkcargo"];
                    } else {
                        $b[$package["storecard_id"]][$package["id"]][$buttress["id"]]["weight"] += $sb["weight"];
                        $b[$package["storecard_id"]][$package["id"]][$buttress["id"]]["qty"] += $sb["qty"];
                        $b[$package["storecard_id"]][$package["id"]][$buttress["id"]]["bulkcargo"] += $sb["bulkcargo"];
                    }
                    $buttressWeight += $sb["weight"];
                    $buttressQty += $sb["qty"];
                }
                if(bccomp($buttressWeight, $subVal["weight"], 6) != 0 || bccomp($buttressQty, $subVal["qty"], 6) != 0) {
                    return array("flag"=>false,"code"=>$this->API_ERROR, "msg"=>"交易订单[".$val["trade_no"]."]明细:码单[".$subVal["package_no"]."]发货重量数量与明细不一致");
                }
            }
            $packageWeight += $subVal["weight"];
            $packageQty += $subVal["qty"];
        }
        if(bccomp($packageWeight, $val["weight"], 6) != 0 || bccomp($packageQty,$val["qty"], 6) != 0) {
            $msg = floatval($packageWeight) . "|" .floatval($val["weight"]) . "|" . floatval($packageQty) . "|".floatval($val["qty"]);
            return array("flag"=>false,"code"=>$this->API_ERROR, "msg"=>"交易订单[".$val["trade_no"]."]发货重量数量与明细不一致:".$msg);
        }
        return array("flag"=>true, "goods"=>$goods, "trade"=>$trade,"card"=>$c, "package"=>$p, "buttress"=>$b);
    }
    private function checkSign($data) {
        if(empty($data)) {
            $this->result(false, $this->API_ERROR_POST_EMPTY);
        }

        $sign = I("get.sign");
        $key = I("get.key");
        $timestamp = I("get.timestamp");

        $now = date("Y-m-d H:i:s");
        $auth = M("customer")->where("appkey = '".$key ."' AND expire_date >= '$now' AND status = 1")->find();
        if(empty($auth)) {
            $this->result(false, $this->API_ERROR_AUTHENTICATION_FAIL);
        }

        //ksort($data);
        //$result = $this->getParamData($data);
        if(strtolower(md5($data.$auth["secret"].$timestamp)) != strtolower($sign)) {
            $this->result(false, $this->API_ERROR_SIGN_FAIL);
        }
        return $auth;
    }

    private function getParamData($data, $result = "", $in = false, $parentKey = "") {
        foreach($data as $key=>$val) {
            if(is_array($val)) {
                if($in) {
                    $parentKey .= "[".$key."]";
                } else {
                    $parentKey = "&".$key;
                }
                $result = $this->getParamData($val, $result, true, $parentKey);
            } else {
                if($in) {
                    $result .= "&" . $parentKey ."[".$key."]=".$val;
                } else {
                    $result .= "&".$key."=".$val;
                }
            }
        }
        return $result;
    }
    private function result($success, $code = 0, $msg = "", $data = null) {
        $flag = "fail";
        if($success) {
            $flag = "success";
        }
        switch ($code) {
            case $this->API_ERROR_AUTHENTICATION_FAIL:
                $msg = "身份验证失败";
                break;
            case $this->API_ERROR_POST_EMPTY:
                $msg = "传送数据为空";
                break;
            case $this->API_ERROR_POST_ERROR:
                $msg = "传送数据无法解析";
                break;
            case $this->API_ERROR_SIGN_FAIL:
                $msg = "签名验证失败";
                break;
            case 0:
                $code = $this->API_SUCCESS;
                break;
        }
        $result = array("flag"=>$flag, "code"=>$code, "message"=>$msg);
        if($data != null) {
            $result["data"] = $data;
        }
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
        die();
    }
    private function log($data) {
        $url = $_SERVER['SERVER_NAME'].':'.$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
        $ip = get_client_ip();
        M("log_api")->add(array(
            "ip"=>$ip,
            "url"=>$url,
            "data"=>$data,
            "create_time"=>getNow()
        ));
    }
}