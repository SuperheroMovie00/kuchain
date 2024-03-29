<?php
namespace Home\Controller;

//
//注释: User - 用户信息
//
use Home\Controller\BasicController;
use Think\Log;
class UserController extends BasicController {

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
////// case for add /////////////////
        case "import":
          $this->import($data);
          break;
        case "edit":
        case "edit_base":
        case "add":
          $this->add($data);
          break;
        case "save":
          $this->save($data);
          break;
//// case for add /////////////////
        case "view":
          $this->view($data);
          break;
        case "import":
          $this->import($data);
          break;
        case "delete":
          $this->order_delete($data);
          break;
        case "confirm":
          $this->order_confirm($data);
          break;
        case "rollback":
          $this->order_rollback($data);
          break;
        case "detail_delete":
          $this->detail_delete($data);
          break;
        case "detail_add":
          $this->selectProduct($data);
          break;
        case "saveSelectProduct":
          $this->saveSelectProduct($data);
          break;
        case "changepassword":
            $this->changepassword($data);
            break;
        case "update_password":
            $this->updatepassword($data);
            break;
      }
    }

////// source for add /////////////////

    private function add($data) {

       //赋初值

        $search["code"] = "";
        $search["name"] = "";
        $search["sex"] = "1";  //第一个选项
        $search["status"] = "1";  //第一个选项

        $id = I("request.id/d");
        if($id){
           $sql = table("select * from @user where id=$id");
           $search = M()->query($sql);
           if(!$search)
               die;
           $data["search"] = current($search);
           $data["id"] = $data["search"]["id"];

        }else{
           $data["search"] = $search;
        }

        foreach($data as $key=>$val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("User:add");
        echo $html;
    }

    private function save($data) {
       $id=I("request.id/d" );

       //读取页面输入数据

       $code = I("request.code");
       $name = I("request.name");
       $sex = I("request.sex");
       $mobilephone = I("request.mobilephone");
       $remarks = I("request.remarks");
       $passwordsource = I("request.passwordsource");
       $superadmin = I("request.superadmin");
       $status = I("request.status");

       //非页面输入字段
       $input = array();

       //数据有效性校验，非空/数值负数，范围/日期与今日比较

       //数据校验 - 必输项不能为空
       if(!verify_value($code,"empty","","")) $this->ajaxError("用户 不能为空");
       if(!verify_value($name,"empty","","")) $this->ajaxError("姓名 不能为空");
       if(!verify_value($sex,"empty","","")) $this->ajaxError("性别 不能为空");
       if(!verify_value($status,"empty","","")) $this->ajaxError("状态 不能为空");

       // "备注" 长度超200位，没有生成非空检测

       $model = M("user");

       //判断 code 是否重复建立
       $orig = $model->where("code='$code'".($id?" and id!=$id":""))->find();
       if ($orig) $this->ajaxError("用户 $code 已存在");

       //页面输入字段

                 $input["code"] = $code;
                 $input["name"] = $name;
                 $input["sex"] = $sex;
                 $input["mobilephone"] = $mobilephone;
                 $input["remarks"] = $remarks;
                 $input["passwordsource"] = $passwordsource;
                 $input["superadmin"] = $superadmin;
                 $input["status"] = $status;

       $input["modify_user"] = $this->user["id"];
       $input["modify_time"] =  date('Y-m-d H:i:s.n');

       $model->startTrans();
       $result=false;

       //需要存入日志的字段
       $needSave=array(
            'code'=>'用户',
            'name'=>'姓名',
            'sex'=>'性别',
            'mobilephone'=>'手机号码',
            'passwordsource'=>'登入密码',
            'superadmin'=>'是否管理员',
            'status'=>'状态',
       );

       if(!$id) {
          //新增  建号操作

          $input["create_user"] = $this->user["id"];
          $input["create_time"] = date('Y-m-d H:i:s.n');

          //新增数据 保存数据库
          $result = $id = $model->add($input);
          //建立操作日志
          $result = $result && createLogCommon('user',$id,'新增用户信息','',"*",'code');
       } else {
          //id存在时判断数据库内数据是否存在
          $old=$model->where("id='%d'",array($id))->find();
          if(empty($old)) {
               $this->ajaxError("用户信息数据不存在");
          }

          //按主键更新数据
          $result = $model->where("id = $id")->save($input);

          $isSaveLog=false;
          foreach ($needSave as $key=>$v) {
              if($old[$key]!=$input[$key]) {
                  $isSaveLog=true;
                  break;
              }
          }
          if($isSaveLog){
          //建立操作日志
               $result = $result && createLogCommon('user',$id,'变更用户信息',$old,'','','code',$needSave);
          }
       }
       if($result){
           $model->commit();
       }else{
           $model->rollback();
           echo json_encode(array("msg"=>message("用户信息保存发生错误")));
           die;
       }

       //完成后跳转
       $this->ajaxReturn($data ['pfuncid'],$data ['funcid'],"refresh", "","closepopup", 1 );
       //转到view页面
       $this->ajaxReturn("","",U("Home/User/index?func=view&id=$id"), tabtitle('用户',$input["code"] ) );
       die;
    }


//// source for add /////////////////

    private function view($data) {
        $data["p"] = I("request.p/d");
        $data["pagesize"] = I("request.pagesize/d");

        $data["id"] = I("request.id/d");
        $data["no"] = I("request.no");
        if(!$data["id"] && !$data["no"]) {
           $this->ajaxError("用户信息查询参数非法");
        }

        //condition
        $condition="";
        $joinsql="";
        //select search fields
        $selectmasterfields="@user.*";



        $sql = table("select #selectfields# from @user  #join# Where #viewkey# #condition# #orderby#");
        if($data["id"])
           $viewkey=table("@user.id=$data[id]");
        else
           $viewkey=table("@user.code='$data[no]'");
        $sql = str_replace("#selectfields#",table($selectmasterfields),$sql);
        $sql = str_replace("#join#",$joinsql,$sql);
        $sql = str_replace("#viewkey#",$viewkey,$sql);
        $sql = str_replace("#condition#",$condition,$sql);
        $sql = str_replace("#orderby#","",$sql);
        $search = M()->query($sql);
        if(!$search){
           $this->ajaxError("用户信息信息不存在");
        }
        $data["search"] = current($search);


        //按tabsheet - 开始
        $data["id"] = $data["search"]["id"];
        $data["search"]["_tab"] = $this->tabsheet_check(I("request._tab"));
        $page_size=$data["pagesize"] ;//session("User-".$data["search"]["_tab"]."-PageSize");
        /*switch($data["search"]["_tab"])
        {

          case "wupinxinxi":
               $data = $this->tab_wupinxinxi_effects($page_size,$data);
               break;
          case "wupinyidong":
               $data = $this->tab_wupinyidong_effects_movement($page_size,$data);
               break;
          case "chujieshenqing":
               $data = $this->tab_chujieshenqing_apply($page_size,$data);
               break;
          case "yanqishenqing":
               $data = $this->tab_yanqishenqing_apply_delay($page_size,$data);
               break;
          case "gongsiyonghu":
               $data = $this->tab_gongsiyonghu_company_user($page_size,$data);
               break;
          case "caozuorizhi":
               $data = $this->tab_caozuorizhi_log_common($page_size,$data);
               break;

        }*/
        $data["search"]["_tab_".$data["search"]["_tab"]."_p"]=$data["p"];
        $data["search"]["_tab_".$data["search"]["_tab"]."_psize"]=$data["page_size"];
        //session("User-".$data["search"]["_tab"]."-PageSize", $data["page_size"]);
        //按tabsheet - 结束

        foreach($data as $key=>$val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("User:view");
        echo $html;
    }

    //按tabsheet子程序 - 开始

    private function tab_wupinxinxi_effects($tab_pagesize,$data)
    {
        $orderby="";
        $joinsql="";

        $condition = "" ;

        //select detail fields
        $selectfields="@effects.status ";
        $selectfields.=",@effects.id ";
        $selectfields.=",@effects.company_id ";
        $selectfields.=",@effects.category_code ";
        $selectfields.=",@effects.code ";
        $selectfields.=",@effects.name ";
        $selectfields.=",@effects.prefix ";
        $selectfields.=",@effects.barcode ";
        $selectfields.=",@effects.content ";
        $selectfields.=",@effects.img ";
        $selectfields.=",@effects.is_kef ";
        $selectfields.=",@effects.is_real ";
        $selectfields.=",@effects.department_id ";
        $selectfields.=",@effects.address ";
        $selectfields.=",@effects.custodian_id ";
        $selectfields.=",@effects.approval_require ";
        $selectfields.=",@effects.allow_borrow ";
        $selectfields.=",@effects.apply_no ";
        $selectfields.=",@effects.create_time ";
        $selectfields.=",@effects.modify_time ";

        $viewkey="@effects.custodian_id='".$data["search"]["id"]."'";
     //   if(!$viewkey)
     //      die;

        $page_size = $tab_pagesize;
        if (!$page_size) {
            $page_size = 10;
        }

        $count_sql = table("select count(*) as cnt from @effects  #join# where #viewkey# #condition#");
        $search_sql = table("select #selectfields# from @effects  #join# Where #viewkey# #condition# #orderby#");

        $viewkey = table($viewkey);
        $condition = table($condition);
        $orderby= table($orderby);
        $selectfields= table($selectfields);

        $count_sql = str_replace("#condition#",$condition,$count_sql);
        $count_sql = str_replace("#viewkey#",$viewkey,$count_sql);
        $count_sql = str_replace("#join#",$joinsql,$count_sql);

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

        $sql = str_replace("#selectfields#",$selectfields,$search_sql);
        $sql = str_replace("#join#",$joinsql,$sql);
        $sql = str_replace("#viewkey#",$viewkey,$sql);
        $sql = str_replace("#condition#",$condition,$sql);
        $sql = str_replace("#orderby#",$orderby,$sql);
        $sql .= " LIMIT ". (($data["p"] - 1) * $page_size). ", $page_size";
        $data["list"] = M()->query($sql);
        $pageClass = new \Think\Page($count,$page_size);
        $pageClass->rollPage = 8;
        $data["page"] = $pageClass->show_drp($data["funcid"]);
        $data["page_size"] = $page_size;

        return $data;
    }

    private function tab_wupinyidong_effects_movement($tab_pagesize,$data)
    {
        $orderby="";
        $joinsql="";


        $condition = "" ;


        //select detail fields
        $selectfields="@effects_movement.id ";
        $selectfields.=",@effects_movement.company_id ";
        $selectfields.=",@effects_movement.department_id ";
        $selectfields.=",@effects_movement.effects_code ";
        $selectfields.=",@effects_movement.effects_name ";
        $selectfields.=",@effects_movement.type ";
        $selectfields.=",@effects_movement.apply_no ";
        $selectfields.=",@effects_movement.user_id ";
        $selectfields.=",@effects_movement.remarks ";
        $selectfields.=",@effects_movement.create_time ";

        $viewkey="@effects_movement.create_user='".$data["search"]["code"]."'";
     //   if(!$viewkey)
     //      die;

        $page_size = $tab_pagesize;
        if (!$page_size) {
            $page_size = 10;
        }

        $count_sql = table("select count(*) as cnt from @effects_movement  #join# where #viewkey# #condition#");
        $search_sql = table("select #selectfields# from @effects_movement  #join# Where #viewkey# #condition# #orderby#");

        $viewkey = table($viewkey);
        $condition = table($condition);
        $orderby= table($orderby);
        $selectfields= table($selectfields);

        $count_sql = str_replace("#condition#",$condition,$count_sql);
        $count_sql = str_replace("#viewkey#",$viewkey,$count_sql);
        $count_sql = str_replace("#join#",$joinsql,$count_sql);

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

        $sql = str_replace("#selectfields#",$selectfields,$search_sql);
        $sql = str_replace("#join#",$joinsql,$sql);
        $sql = str_replace("#viewkey#",$viewkey,$sql);
        $sql = str_replace("#condition#",$condition,$sql);
        $sql = str_replace("#orderby#",$orderby,$sql);
        $sql .= " LIMIT ". (($data["p"] - 1) * $page_size). ", $page_size";
        $data["list"] = M()->query($sql);
        $pageClass = new \Think\Page($count,$page_size);
        $pageClass->rollPage = 8;
        $data["page"] = $pageClass->show_drp($data["funcid"]);
        $data["page_size"] = $page_size;

        return $data;
    }

    private function tab_chujieshenqing_apply($tab_pagesize,$data)
    {
        $orderby="";
        $joinsql="";


        $condition = "" ;


        //select detail fields
        $selectfields="@apply.status ";
        $selectfields.=",@apply.id ";
        $selectfields.=",@apply.company_id ";
        $selectfields.=",@apply.apply_no ";
        $selectfields.=",@apply.department_id ";
        $selectfields.=",@apply.project_name ";
        $selectfields.=",@apply.user_id ";
        $selectfields.=",@apply.plan_start_time ";
        $selectfields.=",@apply.plan_end_time ";
        $selectfields.=",@apply.bollow_reason ";
        $selectfields.=",@apply.plan_take_user ";
        $selectfields.=",@apply.effects_code ";
        $selectfields.=",@apply.effects_name ";
        $selectfields.=",@apply.bollow_time ";
        $selectfields.=",@apply.bollow_remarks ";
        $selectfields.=",@apply.bollow_status ";
        $selectfields.=",@apply.take_user ";
        $selectfields.=",@apply.take_phone ";
        $selectfields.=",@apply.address ";
        $selectfields.=",@apply.express_name ";
        $selectfields.=",@apply.express_no ";
        $selectfields.=",@apply.return_time ";
        $selectfields.=",@apply.return_user ";
        $selectfields.=",@apply.return_status ";
        $selectfields.=",@apply.effects_status ";
        $selectfields.=",@apply.return_remarks ";
        $selectfields.=",@apply.est_days ";
        $selectfields.=",@apply.apply_delay_times ";
        $selectfields.=",@apply.apply_delay_id ";
        $selectfields.=",@apply.apply_delay_no ";
        $selectfields.=",@apply.approval_require ";
        $selectfields.=",@apply.approval_status ";
        $selectfields.=",@apply.refuse_reason ";
        $selectfields.=",@apply.approval1_user1 ";
        $selectfields.=",@apply.approval1_user2 ";
        $selectfields.=",@apply.approval2_user ";
        $selectfields.=",@apply.overdue_status ";
        $selectfields.=",@apply.create_time ";
        $selectfields.=",@apply.modify_time ";

        $viewkey="@apply.user_id='".$data["search"]["id"]."'";
     //   if(!$viewkey)
     //      die;

        $page_size = $tab_pagesize;
        if (!$page_size) {
            $page_size = 10;
        }

        $count_sql = table("select count(*) as cnt from @apply  #join# where #viewkey# #condition#");
        $search_sql = table("select #selectfields# from @apply  #join# Where #viewkey# #condition# #orderby#");

        $viewkey = table($viewkey);
        $condition = table($condition);
        $orderby= table($orderby);
        $selectfields= table($selectfields);

        $count_sql = str_replace("#condition#",$condition,$count_sql);
        $count_sql = str_replace("#viewkey#",$viewkey,$count_sql);
        $count_sql = str_replace("#join#",$joinsql,$count_sql);

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

        $sql = str_replace("#selectfields#",$selectfields,$search_sql);
        $sql = str_replace("#join#",$joinsql,$sql);
        $sql = str_replace("#viewkey#",$viewkey,$sql);
        $sql = str_replace("#condition#",$condition,$sql);
        $sql = str_replace("#orderby#",$orderby,$sql);
        $sql .= " LIMIT ". (($data["p"] - 1) * $page_size). ", $page_size";
        $data["list"] = M()->query($sql);
        $pageClass = new \Think\Page($count,$page_size);
        $pageClass->rollPage = 8;
        $data["page"] = $pageClass->show_drp($data["funcid"]);
        $data["page_size"] = $page_size;

        return $data;
    }

    private function tab_yanqishenqing_apply_delay($tab_pagesize,$data)
    {
        $orderby="";
        $joinsql="";


        $condition = "" ;


        //select detail fields
        $selectfields="@apply_delay.status ";
        $selectfields.=",@apply_delay.id ";
        $selectfields.=",@apply_delay.company_id ";
        $selectfields.=",@apply_delay.apply_no ";
        $selectfields.=",@apply_delay.apply_delay_no ";
        $selectfields.=",@apply_delay.department_id ";
        $selectfields.=",@apply_delay.user_id ";
        $selectfields.=",@apply_delay.user_name ";
        $selectfields.=",@apply_delay.effects_id ";
        $selectfields.=",@apply_delay.effects_code ";
        $selectfields.=",@apply_delay.effects_name ";
        $selectfields.=",@apply_delay.delay_return ";
        $selectfields.=",@apply_delay.delay_subject ";
        $selectfields.=",@apply_delay.delay_reason ";
        $selectfields.=",@apply_delay.approval_require ";
        $selectfields.=",@apply_delay.approval_status ";
        $selectfields.=",@apply_delay.approval1_user1 ";
        $selectfields.=",@apply_delay.approval1_user2 ";
        $selectfields.=",@apply_delay.approval2_user ";
        $selectfields.=",@apply_delay.create_time ";
        $selectfields.=",@apply_delay.modify_time ";

        $viewkey="@apply_delay.user_id='".$data["search"]["id"]."'";
     //   if(!$viewkey)
     //      die;

        $page_size = $tab_pagesize;
        if (!$page_size) {
            $page_size = 10;
        }

        $count_sql = table("select count(*) as cnt from @apply_delay  #join# where #viewkey# #condition#");
        $search_sql = table("select #selectfields# from @apply_delay  #join# Where #viewkey# #condition# #orderby#");

        $viewkey = table($viewkey);
        $condition = table($condition);
        $orderby= table($orderby);
        $selectfields= table($selectfields);

        $count_sql = str_replace("#condition#",$condition,$count_sql);
        $count_sql = str_replace("#viewkey#",$viewkey,$count_sql);
        $count_sql = str_replace("#join#",$joinsql,$count_sql);

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

        $sql = str_replace("#selectfields#",$selectfields,$search_sql);
        $sql = str_replace("#join#",$joinsql,$sql);
        $sql = str_replace("#viewkey#",$viewkey,$sql);
        $sql = str_replace("#condition#",$condition,$sql);
        $sql = str_replace("#orderby#",$orderby,$sql);
        $sql .= " LIMIT ". (($data["p"] - 1) * $page_size). ", $page_size";
        $data["list"] = M()->query($sql);
        $pageClass = new \Think\Page($count,$page_size);
        $pageClass->rollPage = 8;
        $data["page"] = $pageClass->show_drp($data["funcid"]);
        $data["page_size"] = $page_size;

        return $data;
    }

    private function tab_gongsiyonghu_company_user($tab_pagesize,$data)
    {
        $orderby="";
        $joinsql="";


        $condition = "" ;


        //select detail fields
        $selectfields="@company_user.company_id ";
        $selectfields.=",@company_user.department_id ";
        $selectfields.=",@company_user.user_id ";
        $selectfields.=",@company_user.level ";

        $viewkey="@company_user.user_id='".$data["search"]["id"]."'";
     //   if(!$viewkey)
     //      die;

        $page_size = $tab_pagesize;
        if (!$page_size) {
            $page_size = 10;
        }

        $count_sql = table("select count(*) as cnt from @company_user  #join# where #viewkey# #condition#");
        $search_sql = table("select #selectfields# from @company_user  #join# Where #viewkey# #condition# #orderby#");

        $viewkey = table($viewkey);
        $condition = table($condition);
        $orderby= table($orderby);
        $selectfields= table($selectfields);

        $count_sql = str_replace("#condition#",$condition,$count_sql);
        $count_sql = str_replace("#viewkey#",$viewkey,$count_sql);
        $count_sql = str_replace("#join#",$joinsql,$count_sql);

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

        $sql = str_replace("#selectfields#",$selectfields,$search_sql);
        $sql = str_replace("#join#",$joinsql,$sql);
        $sql = str_replace("#viewkey#",$viewkey,$sql);
        $sql = str_replace("#condition#",$condition,$sql);
        $sql = str_replace("#orderby#",$orderby,$sql);
        $sql .= " LIMIT ". (($data["p"] - 1) * $page_size). ", $page_size";
        $data["list"] = M()->query($sql);
        $pageClass = new \Think\Page($count,$page_size);
        $pageClass->rollPage = 8;
        $data["page"] = $pageClass->show_drp($data["funcid"]);
        $data["page_size"] = $page_size;

        return $data;
    }

    private function tab_caozuorizhi_log_common($tab_pagesize,$data)
    {
        $orderby="";
        $joinsql="";


        $condition = "" ;


        //select detail fields
        $selectfields="@log_common.status ";
        $selectfields.=",@log_common.id ";
        $selectfields.=",@log_common.create_time ";
        $selectfields.=",@log_common.type ";
        $selectfields.=",@log_common.data_id ";
        $selectfields.=",@log_common.data_code ";
        $selectfields.=",@log_common.subject ";
        $selectfields.=",@log_common.content ";

        $viewkey="@log_common.data_id='".$data["search"]["id"]."'";
        $viewkey.=" and @log_common.type='user'";
     //   if(!$viewkey)
     //      die;

        $page_size = $tab_pagesize;
        if (!$page_size) {
            $page_size = 10;
        }

        $count_sql = table("select count(*) as cnt from @log_common  #join# where #viewkey# #condition#");
        $search_sql = table("select #selectfields# from @log_common  #join# Where #viewkey# #condition# #orderby#");

        $viewkey = table($viewkey);
        $condition = table($condition);
        $orderby= table($orderby);
        $selectfields= table($selectfields);

        $count_sql = str_replace("#condition#",$condition,$count_sql);
        $count_sql = str_replace("#viewkey#",$viewkey,$count_sql);
        $count_sql = str_replace("#join#",$joinsql,$count_sql);

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

        $sql = str_replace("#selectfields#",$selectfields,$search_sql);
        $sql = str_replace("#join#",$joinsql,$sql);
        $sql = str_replace("#viewkey#",$viewkey,$sql);
        $sql = str_replace("#condition#",$condition,$sql);
        $sql = str_replace("#orderby#",$orderby,$sql);
        $sql .= " LIMIT ". (($data["p"] - 1) * $page_size). ", $page_size";
        $data["list"] = M()->query($sql);
        $pageClass = new \Think\Page($count,$page_size);
        $pageClass->rollPage = 8;
        $data["page"] = $pageClass->show_drp($data["funcid"]);
        $data["page_size"] = $page_size;

        return $data;
    }



    private function tabsheet_check($itab)
    {
        $idefault="wupinxinxi";
        switch($itab)
        {

          case "wupinxinxi":
          case "wupinyidong":
          case "chujieshenqing":
          case "yanqishenqing":
          case "gongsiyonghu":
          case "caozuorizhi":

              break;
          default:
              $itab=$idefault;
              break;
         }
        return $itab;
    }
    //按tabsheet子程序 - 结束

    private function deleteProcess($id,&$type) {

        $smo=M('user')->where("id='%d'",array($id))->find();
        if(empty($smo)) {
            $this->ajaxResult("用户信息数据不存在");
        }
        if($smo['status']!=0){
            $this->ajaxResult("用户信息状态不能删除");
        }

        $result=true;
        if($smo['status']!=0){
            $result=M('user')->where("id='%d'",array($id))->save(array('status'=>8,'cancel_time'=>date('Y-m-d H:i:s'),'cancel_status'=>1));
            $result = $result && createLogCommon('user',$id,'取消用户信息','');
        }else{
            $type=2;
            $result = $result && createLogCommon('user',$id,'删除用户信息','');
            $result = $result && M('user')->where("id='%d'",array($id))->delete();
        }
        return $result;
    }

    private function order_delete($data) {

        $id=I("request.id/d" );
        if(!$id) {
             $this->ajaxResult("用户信息参数不存在");
        }

        $m=M();
        $m->startTrans();
        $type=1;
        $r=$this->deleteProcess($id,$type);

        if($r){
            $m->commit();
        }else{
            $m->rollback();
        }

        if($type==1){
            $this->ajaxResult("", "",  array("_asr.closeTab","_asr.closePopup", "_asr.openLink","_asr.hideConfirm"), array("$('#".$data["funcid"]."-Tab').find('a'), '".$data["funcid"]."'","'".$data["funcid"]."'", "'". U("/Home/User/index?func=view&id=".$id).  "','".filterFuncId("User_View","id=$data[id]")."','用户信息查看', 0","''"));
        }else{
            $this->ajaxResult("", "",  array("_asr.closeTab","_asr.closePopup", "_asr.openLink","_asr.hideConfirm"), array("$('#".$data["funcid"]."-Tab').find('a'), '".$data["funcid"]."'","'".$data["funcid"]."'", "'". U("/Summary/UserSummary/index?func=search&id=".$id).  "','".filterFuncId("UserSummary_View","id=$data[id]")."','用户信息列表', 0","''"));
        }
       die;
    }

    private function order_rollback($data) {

        $id=I("request.id/d" );
        if(!$id) {
             $this->ajaxResult("用户信息参数不存在");
        }

        $smo=M('user')->where("id='%d'",$id)->find();
        if(empty($smo)) {
            $this->ajaxResult("用户信息数据不存在");
        }
        if($smo['status']!=1){
            $this->ajaxResult("用户信息非确认状态，不能反审");
        }

        $model=M('user');
        $model->startTrans();
        $result1=$model->where("id='%d'",$id)->save(array(
            'status'=>0,
            'notice_status'=>0,
            'confirm_status'=>0,
        ));

        $result2 = createLogOrder('user',$id,'用户信息反审','');
        if($result1 && $result2){
            $model->commit();
        }else{
            $model->rollback();
        }

        $this->ajaxResult("", "",  array("_asr.hideConfirm","_asr.openLink"), array("''","'','".$data["funcid"]."','刷新', 1"));

    }

    private function order_confirm($data) {

        $id=I("request.id/d" );
        if(!$id) {
             $this->ajaxResult("用户信息参数不存在");
        }

        $smo=M('user')->where("id='%d'",$id)->find();
        if(empty($smo)) {
            $this->ajaxResult("用户信息数据不存在");
        }
        if($smo['status']!=0 ){
            $this->ajaxResult("用户信息非待确认状态，不能确认");
        }


        $model=M('user');
        $model->startTrans();
        $result1=$model->where("id='%d'",$id)->save(array(
            'status'=>1,
            'notice_time'=>date('Y-m-d H:i:s'),
            'notice_status'=>1,
            'confirm_status'=>1,
            'confirm_time'=>date('Y-m-d H:i:s'),
        ));

        $result2 = createLogOrder('user',$id,'用户信息确认','');
        if($result1 && $result2){
            $model->commit();
        }else{
            $model->rollback();
        }
        $this->ajaxResult("", "",  array("_asr.hideConfirm","_asr.openLink"), array("''","'','".$data["funcid"]."','刷新', 1"));
    }


    private  function changepassword($data){
        foreach($data as $key=>$val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("User:changepassword");
        echo $html;
    }

    private  function updatepassword($data){
        $model=M("User");
        $old=I("old");
        $new=I("new");
        $confirm=I("confirm");
        if(empty($old))
        {
            $this->ajaxError("旧密码不能为空！");
        }
        if(empty($new))
        {
            $this->ajaxError("新密码不能为空！");
        }
        if(empty($confirm))
        {
            $this->ajaxError("确认新密码不能为空！");
        }
        if($new!=$confirm)
        {
            $this->ajaxError("确认新密码与新密码不一致！");
        }

        $userinfo=$model->where(array("id"=>$this->user["id"]))->find();
        if($userinfo["password"]!=md5($old))
        {
            $this->ajaxError("旧密码不正确！");
        }

        $model->where(array("id"=>$this->user["id"]))->save(array("password"=>md5($new)));

        $this->ajax_closePopup($data["funcid"]);
        $this->ajaxResult();
    }

}
