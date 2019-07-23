<?php
namespace Home\Controller;

//
//注释: Chain - 交易链信息
//
use Home\Controller\BasicController;
use Think\Log;
class ChainController extends BasicController {

    public function _init() {
        $funcs = $this->getUserRoleList($this->user,array( 'Chain', '/Home/Chain', ));
        if ($funcs)
            $this->assign("rights",  $funcs);
        else{
            $funcs = array(
                         array("key"=>"refresh","func"=>"Chain","Action"=>"refresh") ,
                         array("key"=>"search","func"=>"/Home/Chain","Action"=>"view") ,
                         array("key"=>"detail_import","func"=>"/Home/Chain","Action"=>"detail_import") ,
                         array("key"=>"detail_select","func"=>"/Home/Chain","Action"=>"select_product") ,
                         array("key"=>"tabjiaoyikaidan","func"=>"/Home/Chain","Action"=>"tabjiaoyikaidan") ,
                         array("key"=>"tabjiaoyilianrizhi","func"=>"/Home/Chain","Action"=>"tabjiaoyilianrizhi") ,
                         array("key"=>"edit_base","func"=>"/Home/Chain","Action"=>"edit_base") ,
                         array("key"=>"order_edit","func"=>"/Home/Chain","Action"=>"edit_base") ,
                         array("key"=>"order_detail","func"=>"/Home/Chain","Action"=>"detail_edit") ,
                         array("key"=>"order_delete","func"=>"/Home/Chain","Action"=>"delete") ,
                         array("key"=>"cancel","func"=>"/Home/Chain","Action"=>"cancel") ,
                         array("key"=>"toprocess","func"=>"/Home/Chain","Action"=>"toprocess") ,
                         array("key"=>"todummy","func"=>"/Home/Chain","Action"=>"todummy") ,
                         array("key"=>"close","func"=>"/Home/Chain","Action"=>"close") ,
                         array("key"=>"closeback","func"=>"/Home/Chain","Action"=>"closeback") ,
                         array("key"=>"grid","func"=>"/Home/Chain","Action"=>"grid") ,
                         array("key"=>"master_view","func"=>"/Home/Chain","Action"=>"view") ,
                         array("key"=>"master_edit","func"=>"/Home/Chain","Action"=>"edit") ,
                         array("key"=>"master_delete","func"=>"/Home/Chain","Action"=>"delete")
             );
            $this->assign("rights",  $this->GetUserRights($this->user["id"],$funcs ));
        }
        $this->assign("colshow", $this->GetUserColumnDefine($this->user["id"],"Chain"));
    }

    public function index() {
      $data["pfuncid"] = I("request.pfuncid");
      $data["funcid"] = I("request.funcid");
      $data["zindex"] = I("request.zindex/d");
      if(empty($data["funcid"])) $data["funcid"] = "Chain";
      $this->GetLastUrl($data["funcid"]);

      $func = I("request.func");
      if($func != "saveSelectProduct" && $func != "save") {
        $this->GetLastUrl($data["funcid"]);
      }

      switch ($func) {

//##combine_for_add_switch_case##

//// case for view ////
        case "view":
          $this->view($data);
          break;
        case "delete":
          $this->order_delete($data);
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
        default :
          $this->ajax_refresh($data ['funcid']);
          break;

      }
    }

//##combine_for_add_source##

//// source for status confirm ////

//// source for status view ////
    private function view($data) {
        $data["p"] = I("request.p/d");
        $data["pagesize"] = I("request.pagesize/d");

        $data["id"] = I("request.id/d");
        $data["no"] = I("request.no");
        if(!$data["id"] && !$data["no"]) {
           $this->ajaxError("交易链信息查询参数非法");
        }

        //condition
        $condition="";
        $joinsql="";
        //select search fields
        $selectmasterfields="@chain.*";



        $sql = table("select #selectfields# from @chain  #join# Where #viewkey# #condition# #orderby#");
        if($data["id"])
           $viewkey=table("@chain.id=$data[id]");
        else
           $viewkey=table("@chain.chain_no='$data[no]'");
        $sql = str_replace("#selectfields#",table($selectmasterfields),$sql);
        $sql = str_replace("#join#",$joinsql,$sql);
        $sql = str_replace("#viewkey#",$viewkey,$sql);
        $sql = str_replace("#condition#",$condition,$sql);
        $sql = str_replace("#orderby#","",$sql);
        $search = M()->query($sql);
        if(!$search){
           $this->ajaxError("交易链信息信息不存在");
        }
        $data["search"] = current($search);

        //step 步骤样例 - 开始
        $step=array();
        $step1=array();
        step_add( $step, '创建时间',$data["search"]['create_time']  ,true);
        step_add( $step, '已确认'  ,$data["search"]['confirm_time'] ,$data["search"]['status']>=1 && $data["search"]['confirm_status']==1);
        step_add( $step, '已通知'  ,$data["search"]['notice_time']  ,$data["search"]['status']>=1 && $data["search"]['notice_status']==1);
        //if($data["search"]['status']>=1 && $data["search"]['stock_status']==1){
            step_add( $step, '处理中'  ,$data["search"]['stock_time'],$data["search"]['status']>=1 && $data["search"]['stock_status']==1);
        //}
        step_add( $step, '已完成'  ,$data["search"]['complete_time']   ,$data["search"]['status']==2);
        // 取消/挂起步骤
        step_add( $step1, '取消时间'  ,$data["search"]['cancel_time'] ,$data["search"]['cancel_status']==1);
        step_add( $step1, '挂起时间'  ,$data["search"]['hangup_time'] ,$data["search"]['hangup_status']==1);
        $step=getOrderStep($step,$step1);
        $data["step"]=$step;
        //step 步骤样例 - 结束

        //按tabsheet - 开始
        $data["id"] = $data["search"]["id"];
        $data["search"]["_tab"] = $this->tabsheet_check(I("request._tab"));
        $page_size=$data["pagesize"] ;//session("Chain-".$data["search"]["_tab"]."-PageSize");
        switch($data["search"]["_tab"])
        {

          case "mingxi":
               $data = $this->tab_mingxi_chain_detail($page_size,$data);
               break;
          case "jiaoyikaidan":
               $data = $this->tab_jiaoyikaidan_trade($page_size,$data);
               break;
          case "jiaoyilianrizhi":
               $data = $this->tab_jiaoyilianrizhi_log_chain($page_size,$data);
               break;

        }
        $data["search"]["_tab_".$data["search"]["_tab"]."_p"]=$data["p"];
        $data["search"]["_tab_".$data["search"]["_tab"]."_psize"]=$data["page_size"];
        //session("Chain-".$data["search"]["_tab"]."-PageSize", $data["page_size"]);
        //按tabsheet - 结束

        foreach($data as $key=>$val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("Chain:view");
        echo $html;
    }

    //按tabsheet子程序 - 开始

    private function tab_mingxi_chain_detail($tab_pagesize,$data)
    {
        $orderby="";
        $joinsql="";


        $condition = "" ;


        //select detail fields
        $selectfields="@chain_detail.id ";
        $selectfields.=",@chain_detail.org_id ";
        $selectfields.=",@chain_detail.trade_id ";
        $selectfields.=",@trade.customer_name ";
        $selectfields.=",@trade.buyer_name ";
        $selectfields.=",@chain_detail.interface_process ";
        $selectfields.=",@chain_detail.interface_time ";
        $selectfields.=",@chain_detail.interface_result ";

        $viewkey="@chain_detail.chain_id='".$data["search"]["id"]."'";
     if(!$viewkey)
           $this->ajaxError("查询参数非法");
     //      die;

        $page_size = $tab_pagesize;
        if (!$page_size) {
            $page_size = 10;
        }

        $count_sql = table("select count(*) as cnt from @chain_detail LEFT JOIN @trade ON @trade.id=@chain_detail.trade_id  #join# where #viewkey# #condition#");
        $search_sql = table("select #selectfields# from @chain_detail LEFT JOIN @trade ON @trade.id=@chain_detail.trade_id  #join# Where #viewkey# #condition# #orderby#");

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
        $data["page"] = $pageClass->show_drp($data["funcid"],"");
        $data["page_size"] = $page_size;

        return $data;
    }

    private function tab_jiaoyikaidan_trade($tab_pagesize,$data)
    {
        $orderby="";
        $joinsql="";


        $condition = "" ;


        //select detail fields
        $selectfields="@trade.status ";
        $selectfields.=",@trade.id ";
        $selectfields.=",@trade.org_id ";
        $selectfields.=",@trade.warehouse_code ";
        $selectfields.=",@trade.customer_name ";
        $selectfields.=",@trade.buyer_id ";
        $selectfields.=",@trade.buyer_name ";
        $selectfields.=",@trade.trade_no ";
        $selectfields.=",@trade.tx_type ";
        $selectfields.=",@trade.tx_date ";
        $selectfields.=",@trade.contract_no ";
        $selectfields.=",@trade.contract_date ";
        $selectfields.=",@trade.is_real ";
        $selectfields.=",@trade.chain_id ";
        $selectfields.=",@trade.goods_id ";
        $selectfields.=",@trade.goods_name ";
        $selectfields.=",@trade.style_info ";
        $selectfields.=",@trade.materials ";
        $selectfields.=",@trade.brand ";
        $selectfields.=",@trade.producing_area ";
        $selectfields.=",@trade.weight ";
        $selectfields.=",@trade.price ";
        $selectfields.=",@trade.amount ";
        $selectfields.=",@trade.uom_weight ";
        $selectfields.=",@trade.uom_qty ";
        $selectfields.=",@trade.cust_confirm_status ";
        $selectfields.=",@trade.cust_confirm_time ";
        $selectfields.=",@trade.cust_confirm_user ";
        $selectfields.=",@trade.buyer_confirm_status ";
        $selectfields.=",@trade.buyer_confirm_time ";
        $selectfields.=",@trade.buyer_confirm_user ";
        $selectfields.=",@trade.cust_send_type ";
        $selectfields.=",@trade.cust_send_time ";
        $selectfields.=",@trade.cust_send_user ";
        $selectfields.=",@trade.storefee_bears ";
        $selectfields.=",@trade.storefee_require ";
        $selectfields.=",@trade.storefee_start ";
        $selectfields.=",@trade.payment_require ";
        $selectfields.=",@trade.payment_expire ";
        $selectfields.=",@trade.confirm_status ";
        $selectfields.=",@trade.confirm_payment ";
        $selectfields.=",@trade.confirm_receive ";
        $selectfields.=",@trade.delivery_no ";
        $selectfields.=",@trade.delivery_date ";
        $selectfields.=",@trade.delivery_expired ";
        $selectfields.=",@trade.delivery_company ";
        $selectfields.=",@trade.delivery_carinfo ";
        $selectfields.=",@trade.delivery_type ";
        $selectfields.=",@trade.delivery_require ";
        $selectfields.=",@trade.assign_status ";
        $selectfields.=",@trade.assign_time ";
        $selectfields.=",@trade.assign_user ";
        $selectfields.=",@trade.assign_weight ";
        $selectfields.=",@trade.assign_qty ";
        $selectfields.=",@trade.buyer_storecard_id ";
        $selectfields.=",@trade.buyer_storecard_no ";
        $selectfields.=",@trade.buyer_storecard_allow ";
        $selectfields.=",@trade.act_weight ";
        $selectfields.=",@trade.act_qty ";
        $selectfields.=",@trade.act_time ";
        $selectfields.=",@trade.act_order ";
        $selectfields.=",@trade.diff_weight ";
        $selectfields.=",@trade.diff_amount ";
        $selectfields.=",@trade.interface_status ";
        $selectfields.=",@trade.interface_send_status ";
        $selectfields.=",@trade.interface_send_time ";
        $selectfields.=",@trade.interface_send_count ";
        $selectfields.=",@trade.interface_receive ";
        $selectfields.=",@trade.interface_result ";
        $selectfields.=",@trade.customer_msg ";
        $selectfields.=",@trade.buyer_msg ";
        $selectfields.=",@trade.remarks ";
        $selectfields.=",@trade.create_time ";
        $selectfields.=",@trade.modify_time ";

        $viewkey="@trade.chain_id='".$data["search"]["id"]."'";
     if(!$viewkey)
           $this->ajaxError("查询参数非法");
     //      die;

        $page_size = $tab_pagesize;
        if (!$page_size) {
            $page_size = 10;
        }

        $count_sql = table("select count(*) as cnt from @trade  #join# where #viewkey# #condition#");
        $search_sql = table("select #selectfields# from @trade  #join# Where #viewkey# #condition# #orderby#");

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
        $data["page"] = $pageClass->show_drp($data["funcid"],"");
        $data["page_size"] = $page_size;

        return $data;
    }

    private function tab_jiaoyilianrizhi_log_chain($tab_pagesize,$data)
    {
        $orderby="";
        $joinsql="";


        $condition = "" ;


        //select detail fields
        $selectfields="@log_chain.status ";
        $selectfields.=",@log_chain.id ";
        $selectfields.=",@log_chain.create_time ";
        $selectfields.=",@log_chain.chain_id ";
        $selectfields.=",@log_chain.subject ";
        $selectfields.=",@log_chain.weight ";
        $selectfields.=",@log_chain.qty ";
        $selectfields.=",@log_chain.amount ";
        $selectfields.=",@log_chain.content ";

        $viewkey="@log_chain.chain_id='".$data["search"]["id"]."'";
     if(!$viewkey)
           $this->ajaxError("查询参数非法");
     //      die;

        $page_size = $tab_pagesize;
        if (!$page_size) {
            $page_size = 10;
        }

        $count_sql = table("select count(*) as cnt from @log_chain  #join# where #viewkey# #condition#");
        $search_sql = table("select #selectfields# from @log_chain  #join# Where #viewkey# #condition# #orderby#");
        $orderby="order by @log_chain.id desc";

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
        $data["page"] = $pageClass->show_drp($data["funcid"],"");
        $data["page_size"] = $page_size;

        return $data;
    }



    private function tabsheet_check($itab)
    {
        $idefault="mingxi";
        switch($itab)
        {

          case "mingxi":
          case "jiaoyikaidan":
          case "jiaoyilianrizhi":

              break;
          default:
              $itab=$idefault;
              break;
         }
        return $itab;
    }
    //按tabsheet子程序 - 结束

    private function deleteProcess($id) {
        $type=1;
        $smo=M('chain')->where("id='%d'",array($id))->find();
        if(empty($smo)) {
            $this->ajaxResult("交易链信息数据不存在");
        }
        if($smo['status']!=0){
            $this->ajaxResult("交易链信息状态不能删除");
        }

        $result=true;
        $result = $result && createLogChain('chain',$id,($smo['status']?'取消信息':'删除记录'),'');
        if($smo['status']!=0){
            $result = $result && M('chain')->where("id='%d'",array($id))->save(array('status'=>8,'cancel_time'=>date('Y-m-d H:i:s'),'cancel_status'=>1));
        }else{
            $result = $result && M('chain')->where("id='%d'",array($id))->delete();
        }
        return $result;
    }

    private function order_delete($data) {

        $id=I("request.id/d" );
        $type=I("request.type/d" );
        if(!$id) {
             $this->ajaxResult("交易链信息参数不存在");
        }

        $m=M();
        $m->startTrans();
        $r=$this->deleteProcess($id);
        if($r){
            $m->commit();
        }else{
            $m->rollback();
        }

        $this->ajax_hideConfirm();
        if(!$type){
            $this->ajax_closeTab($data ['funcid']);
        }
        $this->ajax_refresh($data ['pfuncid']);
        $this->ajaxResult();
        die;
    }

    private function detail_delete($data) {
        $data["id"] = I("request.id");

        if(!is_array($data["id"])){
            $data["id"]=array($data["id"]);
        }

        $model=M('chain_detail');
        $model->startTrans();
        $result1=true;
        $orderid=0;
        $content='';
        foreach ($data["id"] as $v) {
            $pd_delete=$model->where("id='%d'",array($v))->find();
            if($orderid==0){
                $orderid=$pd_delete['chain_id'];
            }
            $result1 = $model->where("id='%d'",array($v))->delete();

            //写日志
            $content.=getOrderChange(array(),array(),'chain','删除商品['.$pd_delete['goods_no'].$pd_delete['goods_name'].']');

            if(!$result1){
                break;
            }
        }

        //重新汇总 数量/金额，具体程序具体调整
        $rpd=$model->where("chain_id='%d'",array($orderid))->field('qty,price')->select();
        $amount=0;
        $qty_total=0;
        foreach ($rpd as $k=>$v) {
            $qty_total+=$v['qty'];
            $amount+=$v['price']*$v['qty'];
        }

        $result2=M('chain')->where("id='%d'",array($orderid))->save(array('qty'=>$qty_total,'amount'=>$amount));

        $smo=M('chain')->where("id='%d'",array($orderid))->find();
        if($smo['status']!=0){
            $result2=false;
        }

        $result1 = $result1 && createLogOrder('chain',$orderid,'删除交易链信息商品',$content);

        if($result1 && $result2){
            $model->commit();
        }else{
            $model->rollback();
        }
        $this->ajaxResult("", "",  array("_asr.openLink"), array("'','".$data["funcid"]."','刷新', 1"));
    }

    private function selectProduct($data) {

        $data["search"]["category_id"] = I("get.category_id/a");
        $data["search"]["name"] = I("get.name");
        $data["search"]["goods_no"] = I("get.goods_no");
        $data["search"]["namelike"] = I("get.namelike/d");
        $data["orderid"] = I("request.id");
        $data["p"] = I("get.p/d");

        $where = "where 1=1";
        if(!empty($data["search"]["category_id"])) {
            $where .= " AND category_id IN (" . join(",", $data["search"]["category_id"]) . ")";
        }

        if(!empty($data["search"]["name"])) {
            if($data["search"]["namelike"]) {
                $where .= " AND like '%" . $data["search"]["name"] . "%'";
            } else {
                $where .= " AND name = '" . $data["search"]["name"] . "'";
            }
        }

        if(!empty($data["search"]["goods_no"])) {
            $where .= " AND goods_no = '". $data["search"]["goods_no"] . "'";
        }

        $data["page_size"] = I("get.pagesize/d");
        $data["page_size"] = $data["page_size"] <= 0 ? session("selectProduct-PageSize") : $data["page_size"];
        if(!$data["page_size"]) {
            $data["page_size"] = 10;
        }
        //$data["page_size"] = 2;
        session("selectProduct-PageSize", $data["page_size"]);

        $pre = C("DB_PREFIX");
        $count_sql = "SELECT count(*) AS cnt FROM " .$pre ."goods $where";
        $count = M()->query($count_sql);
        $count = $count[0]["cnt"];

        if($count < $data["page_size"])
            $tmp = 1;
        else {
            $tmp = intval($count / $data["page_size"]);
            if($count % $data["page_size"] != 0) {
                $tmp++;
            }
        }
        if(!$data["p"]) {
            $data["p"] = 1;
        }

        if($data["p"] > $tmp) {
            $data["p"] = $tmp;
        }

        $sql = "SELECT g.* FROM " .$pre."goods as g $where";
        $sql .= " LIMIT ". (($data["p"] - 1) * $data["page_size"]). ", ".$data["page_size"];

        $data["list"] = M()->query($sql);

        $smo=M('chain')->where("id='%d'",array( $data["orderid"]))->find();
        $model=M("chain_detail");
        $sm=M('stock2');
        $storage=M('storage')->where("code='%s'",array($smo['storage_code']))->find();


        foreach ($data["list"] as $k=>$v) {
            $stock=$sm->where("storage_id='%d' AND goods_id='%d' ",array($storage['id'],$v['id']))->find();
            $data['list'][$k]['sctok']=floatval($stock['qty']);
            $smd=$model->where("chain_id='%d' AND goods_id='%d' ",array($data["orderid"],$v['id']))->find();
            $data['list'][$k]['qty']=floatval($smd['qty']);
        }

        $pageClass = new \Think\Page($count,$data["page_size"]);
        $pageClass->rollPage = 8;
        $data["page"] = $pageClass->show_drp($data["funcid"], "编辑商品信息");

        $categroy_list = M("category")->where("parent_id = 0")->select();
        $clist = array();
        foreach($categroy_list as $category) {
            $clist[$category["id"]]["main"] = $category;
            $clist[$category["id"]]["detail"] = M("category")->where("parent_id = ".$category["id"])->select();
        }

        $data["categorys"] = $clist;

        foreach($data as $key=>$val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("Chain:selectProduct");
        echo $html;
    }

    private function saveSelectProduct($data) {
        $orderid = I("request.orderid");
        $close = I("request.close");

        $id= I("id");
        $model=M("chain_detail");
        $smo=M('chain')->where("id='%d'",array($orderid))->find();
        if(empty($smo)) {
            $this->ajaxResult("交易链信息不存在");
        }
        $sm=M('stock2');
        $gm=M('goods');

        $model->startTrans();
        $result=false;
        foreach ($id  as $k=>$v)
        {
            $g=$gm->where("id='%d'",$v)->find();

            $qty=floatval(I("qty_".$v));
            $storage_location = I("storage_location_".$v);

            $smd=$model->where("chain_id='%d' AND goods_id='%d' ",array($orderid,$v))->find();

            $cur_data=array();
            $cur_data['goods_id']=$v;
            $cur_data['chain_id']=$orderid;
            $cur_data['order_no']=$smo['order_no'];
            $cur_data['qty']=$qty;
            $cur_data['order_qty']=$qty;
            $cur_data['price']=I("price_".$v);
            $cur_data['amount']=$cur_data['price']*abs($qty);
            $cur_data['goods_no']=$g['goods_no'];
            $cur_data['goods_name']=$g['name'];
            $cur_data['brand_code']=$g['brand_code'];
            $cur_data['style_info']=$g['style_info'];
            $cur_data['barcode']=$g['barcode'];
            $cur_data['location_code']=$storage_location;
            $cur_data['storage_code']=$smo["storage_code"];

            if(!empty($smd)){
                $result =  $model->where("chain_id='%d' AND goods_id='%d'",array($orderid,$v))->save($cur_data);
            }else{
                $result =  $model->add($cur_data);

            }

            if(!$result){
                break;
            }

        }

        $qty_total=$model->where("chain_id='%d'",array($orderid))->field("SUM(qty) qty_total,SUM(amount) amount_total")->find();

        $result2=M('chain')->where("id='%d'",array($orderid))->save(array('qty'=>$qty_total['qty_total'],'amount'=>$qty_total['amount_total'],'modify_time'=>date('Y-m-d H:i:s'),'modify_user'=>session(C("USER_AUTH_KEY"))));

        $sa=M('chain')->where("id='%d'",array($orderid))->find();

        if($sa['status']!=0){
            $result2=false;
        }

        if($result && $result2){
            $model->commit();
        }else{
            $model->rollback();
        }

        if($close == "1") {
            $this->ajaxResult("", "",  array("_asr.closePopup", "_asr.openLink"), array("'".$data["funcid"]."'", "'','".$data["pfuncid"]."','刷新', 1"));
        } else {
            $this->ajaxResult("", "",  array("_asr.openLink"), array("'','".$data["pfuncid"]."','刷新', 1"));
        }

        die;
    }

}
