<?php
/**
 * Created by PhpStorm.
 * User: gunduzi8
 * Date: 2019/6/12
 * Time: 14:54
 */
namespace Api\Controller;
use Home\Controller\BasicController;

class StoreCardController extends BasicController {
    public function index() {
        $data["pfuncid"] = I("request.pfuncid");
        $data["funcid"] = I("request.funcid");
        $data["zindex"] = I("request.zindex/d");
        if(empty($data["funcid"])) $data["funcid"] = "Trade";
        $this->GetLastUrl($data["funcid"]);

        $func = I("request.func");
        if($func != "saveSelectProduct" && $func != "save") {
            $this->GetLastUrl($data["funcid"]);
        }

        switch ($func) {
            case "card":
                $this->card($data);
                break;
            case "package":
                $this->package($data);
                break;
            case "buttress":
                $this->buttress($data);
                break;
        }
    }

    private function card($data) {
        $this.layout(false);
        $id = I("get.id/d");
        $ids = I("get.ids");
        $keyword = I("get.keyword");
        $type = I("get.type");
        $storeCardType = I("get.storecard_type");
        $storeCard = array();
        $modelName = $storeCardType == 1 ? "storecard" : "storecard_virtual";
        $typeField = $storeCardType == 1 ? " 1 as storecard_type" : "0 as storecard_type";
        if($id) {
            $storeCard = M($modelName)->field("*,".$typeField)->where("id=".$id." AND status = 1 AND customer_id = ".$this->user["customer_id"])->find();
            if($type == "html") {
                $storeCard = array($storeCard);
            }
        }
        if($ids) {
            $storeCard = M($modelName)->field("*,".$typeField)->where("id IN (".$ids.") AND status = 1 AND customer_id = ".$this->user["customer_id"])->select();
        }
        if($keyword) {
            $storeCard = M($modelName)->field("*,".$typeField)->where("storecard_no like '%".$keyword."%' AND status = 1 AND customer_id = ".$this->user["customer_id"])->select();
        }
        if($type == "html") {
            $this->assign("storeCard", $storeCard);
            $html = $this->fetch("StoreCard:card");
            echo $html;
        } else {
            echo json_encode($storeCard, JSON_UNESCAPED_UNICODE);
        }
    }

    private function package($data) {
        $this.layout(false);
        $id = I("get.id/d");
        if(!$id) {
            $this->ajaxError("非法操作");
        }
        $storCard = M("storecard")->field("id")->where("id=".$id." AND status = 1 AND customer_id = ".$this->user["customer_id"])->find();
        if(empty($storCard)) {
            $this->ajaxError("存储卡不存在");
        }
        $package = M("storecard_package")->where("storecard_id = ". $id." AND status = 1 AND customer_id = ".$this->user["customer_id"])->select();
        $this->assign("storecard_package", $package);
        $html = $this->fetch("StoreCard:package");
        echo $html;
    }

    private function buttress($data) {
        $this.layout(false);
        $id = I("get.id/d");
        if(!$id) {
            $this->ajaxError("非法操作");
        }

        $package = M("storecard_package")->where("id = ". $id." AND status = 1 AND customer_id = ".$this->user["customer_id"])->find();
        if(empty($package)) {
            $this->ajaxError("码单不存在");
        }
        $buttress = M("storecard_buttress")->where("package_id = ".$id." AND customer_id = ".$this->user["customer_id"])->select();
        $this->assign("storecard_buttress", $buttress);
        $this->assign("package", $package);
        $html = $this->fetch("StoreCard:buttress");
        echo $html;
    }
}