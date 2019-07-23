<?php
namespace Home\Controller;

//
//注释: User - 用户信息
//
use Home\Controller\BasicController;
use Think\Log;
class SampleController extends BasicController {

    public function _init() {
        $funcs = $this->getUserRoleList($this->user,array( 'User', '/Home/User', ));
        if ($funcs)
            $this->assign("rights",  $funcs);
        else{
            $funcs = array(
                         array("key"=>"refresh","func"=>"User","Action"=>"refresh"),
                         array("key"=>"save","func"=>"User","Action"=>"save") ,
                         array("key"=>"search","func"=>"/Home/User","Action"=>"view") ,
                         array("key"=>"detail_import","func"=>"/Home/User","Action"=>"detail_import") ,
                         array("key"=>"detail_select","func"=>"/Home/User","Action"=>"selectproduct") ,
                         array("key"=>"tabwupinyidong","func"=>"/Home/User","Action"=>"tabwupinyidong") ,
                         array("key"=>"tabchujieshenqing","func"=>"/Home/User","Action"=>"tabchujieshenqing") ,
                         array("key"=>"tabyanqishenqing","func"=>"/Home/User","Action"=>"tabyanqishenqing") ,
                         array("key"=>"tabgongsiyonghu","func"=>"/Home/User","Action"=>"tabgongsiyonghu") ,
                         array("key"=>"tabcaozuorizhi","func"=>"/Home/User","Action"=>"tabcaozuorizhi") ,
                         array("key"=>"edit_base","func"=>"/Home/User","Action"=>"edit_base") ,
                         array("key"=>"order_edit","func"=>"/Home/User","Action"=>"order_edit") ,
                         array("key"=>"order_delete","func"=>"/Home/User","Action"=>"delete") ,
                         array("key"=>"batch_opt1","func"=>"/Home/User","Action"=>"batch_opt1") ,
                         array("key"=>"batch_opt2","func"=>"/Home/User","Action"=>"batch_opt2") ,
                         array("key"=>"batch_delete","func"=>"/Home/User","Action"=>"batch_delete")
             );
            $this->assign("rights",  $this->GetUserRights($this->user["id"],$funcs ));
        }
        $this->assign("colshow", $this->GetUserColumnDefine($this->user["id"],"User"));
    }

    public function index() {
      $data["pfuncid"] = I("request.pfuncid");
      $data["funcid"] = I("request.funcid");
      $data["zindex"] = I("request.zindex/d");
      if(empty($data["funcid"])) $data["funcid"] = "User";
      $this->GetLastUrl($data["funcid"]);

      $func = I("request.func");
      if($func != "saveSelectProduct" && $func != "save") {
        $this->GetLastUrl($data["funcid"]);
      }

      switch ($func) {
        case "col1":
          $this->col1($data);
          break;
      }
    }

    private function col1($data) {
        foreach ($data as $key => $val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("Sample:col1");
        echo $html;
    }


}
