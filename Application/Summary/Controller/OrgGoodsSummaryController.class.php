<?php namespace Summary\Controller;
//
//注释: OrgGoodsSummary - 联盟货品列表
//
use Home\Controller\BasicController;
use Think\Log;
class OrgGoodsSummaryController extends BasicController {

    public function _init() {
        $funcs = $this->getUserRoleList($this->user,array( '/Home/Goods', 'OrgGoodsSummary', '/Home/GoodsStyle', ));
        if ($funcs)
            $this->assign("rights",  $funcs);
        else{
            $funcs = array(
                         array("key"=>"add","func"=>"/Home/Goods","Action"=>"add") ,
                         array("key"=>"refresh","func"=>"OrgGoodsSummary","Action"=>"refresh") ,
                         array("key"=>"search","func"=>"OrgGoodsSummary","Action"=>"search") ,
                         array("key"=>"export","func"=>"OrgGoodsSummary","Action"=>"export") ,
                         array("key"=>"master_view","func"=>"/Home/Goods","Action"=>"view") ,
                         array("key"=>"master_delete","func"=>"/Home/Goods","Action"=>"delete") ,
                         array("key"=>"master_maint","func"=>"/Home/GoodsStyle","Action"=>"master_maint") ,
                         array("key"=>"status_on","func"=>"/Home/Goods","Action"=>"status_on") ,
                         array("key"=>"status_off","func"=>"/Home/Goods","Action"=>"status_off")
             );
            $this->assign("rights",  $this->GetUserRights($this->user["id"],$funcs ));
        }
        $this->assign("colshow", $this->GetUserColumnDefine($this->user["id"],"OrgGoodsSummary"));
    }

    public function index() {
         try {
        $data["pfuncid"] = I("request.pfuncid");
        $data["funcid"] = I("request.funcid");
        $data["zindex"] = I("request.zindex/d");
        if(empty($data["funcid"])) $data["funcid"] = "OrgGoodsSummary";
        $this->GetLastUrl($data["funcid"]);

        $func = I("request.func");
        switch ($func)
        {
          case "refresh":
               $this->refresh($data);
               break;
          case "search":
               $this->search($data);
               break;
          case "export":
               $this->export($data);
               break;
          case "columnsetting":
               $this->columnsetting($data);
               break;
          case "columnsettingsave":
               $this->columnsetting_save($data);
               break;
       }
          } catch(\Exception $e) {
          //$this->ajaxResult("联盟货品列表后台错误");
          $this->ajaxResult($e->getMessage());
      }
    }


    private function columnsetting_define(){
        return array(
            'status'=>'状态',
            'goods_no'=>'货品编码',
            'name'=>'货品名称',
            'materials'=>'材质',
            'org_goods_no'=>'机构原始码',
            'uom_weight'=>'重量单位',
            'uom_qty'=>'数量单位',
            'active'=>'活跃等级',
            'assign_mode'=>'配货方式',
        );
    }

    private function columnsetting($data){
        $data['user_code']=session(C("USER_AUTH_KEY"));
        $data['summary']='OrgGoodsSummary';
        $data['column']=$this->columnsetting_define();

        $usc = M('user_summary_column')->where("user_code='%s' AND summary='%s' AND `show`='%d'",array(session(C("USER_AUTH_KEY")),$data['summary'],1))->select();
        $data['column_check']=array();
        foreach ($usc as $k=>$v) {
            $data['column_check'][$v['column']]=1;
        }

        foreach($data as $key=>$val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("Common:columnsetting");
        echo $html;
    }

    private function columnsetting_save($data){
        $data["funcid"] = I("request.funcid");
        $data["column"] = I("request.column");
        $data["column_check"] = I("request.column_check");
        $data["summary"] = I("request.summary");
        $result=true;
        $model=M('user_summary_column');
        $model->startTrans();

        $model->where("user_code='%s' AND summary='%s'",array(session(C("USER_AUTH_KEY")),$data["summary"]))->delete();

        $selectall = count($this->columnsetting_define())==count($data["column_check"]);

        if (!$selectall) {
          foreach ($data["column"] as $k=>$v) {
              $result = $model->add(array(
                  'user_code'=>session(C("USER_AUTH_KEY")),
                  'summary'=>$data['summary'],
                  'column'=>$k,
                  'show'=>isset($data['column_check'][$k])?1:0,
              ));
              if (!$result) break;
          }
        }
        if($result){
            $model->commit();
        }else{
            $model->rollback();
        }

        $this->ajaxResult("", "",  array("_asr.closeTab","_asr.closePopup", "_asr.openLink","_asr.hideMask()"), array("$('#".$data["funcid"]."-Tab').find('a'), '".$data["funcid"]."'","'".$data["funcid"]."'", "'". U("/Summary/OrgGoodsSummary/index?func=search&").  "','".filterFuncId("OrgGoodsSummary_Search","id=0")."','联盟货品列表', 1",""));


    }


    private function refresh(){
      $this->search();
    }

    private function search($data) {
         $today= date('Y-m-d');
         $month= date('Y-m');
         $year= date('Y');
       $yesterday=date('Y-m-d', strtotime( '-1 day'));

       $search_auth_codes = "";
       $data["p"] = I("request.p/d");
       $__refresh = I("request.__refresh/d");
       $search["_searchexpand"] = I("request._searchexpand");
       $search["_showsearch"] = I("request._showsearch");
       if(empty($search["_showsearch"]) || $__refresh=="1"){
           $search["_showsearch"]="hide";
       }
       //读取关键字搜索内容
       $search["_keyword"] = I("request._keyword");

       //首次运行判断及设置
       $firstloading=false;
       $search["_issearch"] = I("request._issearch");
       if($search["_issearch"]!="1" && $search["_issearch"]!="0"){
           $firstloading=true;
           $search["_issearch"] = "1";
       }
       $bsearch = $search["_issearch"] == 1;
       $search["_execsearch"] = $search["_issearch"];
       $search["_issearch"] = 1;  //execsearch必须放在 issearch 前面, 记住前一步状态


       //读取tab参数
       $search["_tab"] = $this->tabsheet_check(I("request._tab"));

       //读取页面参数
       $search["status"] = I("request.status");
       $search["goods_no"] = I("request.goods_no");
       $search["name"] = I("request.name");
       $search["materials"] = I("request.materials");
       $search["org_goods_no"] = I("request.org_goods_no");
       $search["uom_weight"] = I("request.uom_weight");
       $search["uom_qty"] = I("request.uom_qty");
       $search["active"] = I("request.active");
       $search["assign_mode"] = I("request.assign_mode");

       //判断首次装载是否要赋予缺省值
       if($firstloading){
       }



       $condition="";
       $condition_goods="";
       if($bsearch) {
           //关键字条件
           if($search["_showsearch"]=="hide"  ){
               if($search["_keyword"]){
                   $condition_keyword = "";
                   $condition_keyword = join_condition($condition_keyword,"@goods.goods_no",$search["_keyword"],"char", "both" , 0, "" );
                   $condition_keyword = join_condition($condition_keyword,"@goods.name",$search["_keyword"],"char", "both" , 0, "OR" );
                   $condition_goods = " AND ( ". $condition_keyword .")";
               }
           }else{
               //高级搜索condition
               $condition_goods = join_condition($condition_goods,"@goods.status",$search["status"],"int");
               $condition_goods = join_condition($condition_goods,"@goods.goods_no",$search["goods_no"],"char");
               $condition_goods = join_condition($condition_goods,"@goods.name",$search["name"],"char","both");
               $condition_goods = join_condition($condition_goods,"@goods.materials",$search["materials"],"char");
               $condition_goods = join_condition($condition_goods,"@goods.org_goods_no",$search["org_goods_no"],"char");
               $condition_goods = join_condition($condition_goods,"@goods.uom_weight",$search["uom_weight"],"char");
               $condition_goods = join_condition($condition_goods,"@goods.uom_qty",$search["uom_qty"],"char");
               $condition_goods = join_condition($condition_goods,"@goods.active",$search["active"],"int");
               $condition_goods = join_condition($condition_goods,"@goods.assign_mode",$search["assign_mode"],"int");
           }

           //增加 tab 条件
           $condition_goods = $this->tabsheet_condition($condition_goods ,$search["_tab"]);
           //select fields
           $selectfields=" @goods.status ";
           $selectfields.=", @goods.id ";
           $selectfields.=", @goods.goods_no ";
           $selectfields.=", @goods.name ";
           $selectfields.=", @goods.materials ";
           $selectfields.=", @goods.org_goods_no ";
           $selectfields.=", @goods.uom_weight ";
           $selectfields.=", @goods.uom_qty ";
           $selectfields.=", @goods.active ";
           $selectfields.=", @goods.assign_mode ";


           $page_size = I("request.pagesize/d");
           if ($page_size<=0){
               $page_size = session("OrgGoodsSummary-PageSize");
               if (!$page_size) {
                    $page_size = 10;
               }
           }
           session("OrgGoodsSummary-PageSize", $page_size);


           $join="";
           $count_sql = "select count(*) as cnt from @goods  #join#  where 1=1 #condition#";  // ' for skip replace $condition
           $count_sql = str_replace("#join#",$join,$count_sql);
           $count_sql = str_replace("#condition#",$condition_goods,$count_sql);
           $count_sql = table($count_sql);
           $count_sql = str_replace("·mailchar·","@",$count_sql);
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

           $orderby = $this->get_orderby("@goods.sort",$search["_tab"]);
           $sql = "select #selectfields# from @goods  #join# Where 1=1 #condition# #orderby#";
           $sql = str_replace("#selectfields#",$selectfields,$sql);
           $sql = str_replace("#join#",$join,$sql);
           $sql = str_replace("#condition#",$condition_goods,$sql);
           $sql = str_replace("#orderby#",$orderby,$sql);
           $sql .= " LIMIT ". (($data["p"] - 1) * $page_size). ", $page_size";
           $sql = table($sql);
           $sql = str_replace("·mailchar·","@",$sql);
           $data["list"] = M()->query($sql);


           $pageClass = new \Think\Page($count,$page_size);
           $pageClass->rollPage = 8;
           $data["page"] = $pageClass->show_summary($data["funcid"],"");
           $data["page_size"] = $page_size;

        }
        else
        {
           $data["list"] =array();
           $data["page"] ="";
        }

        $data["search"] = $search;
        $data["tab"] = $search["_tab"];

        foreach($data as $key=>$val) {
            $this->assign($key, $val);
        }
        $html = $this->fetch("OrgGoodsSummary:index");
        echo $html;
    }



    private function csvdata($data){
      return '"'.str_replace('"','\"',$data).'"';
    }

    private function export(){
        set_time_limit(0);
        ini_set('memory_limit', '640M');

        $search_auth_codes = "";
        $data["funcid"] = I("request.funcid");
        $p = I("request.p/d");
        $export_all = I("request.export_all/d");
        $search["_showsearch"] = I("request._showsearch");

        if(empty($data["funcid"])) $data["funcid"] = "OrgGoodsSummary";
        if(!$p){
           $p = 1;
           $export_all = 1;
        }

        $show_list = array();

        $data['summary']='OrgGoodsSummary';
        $usc = M('user_summary_column')->field("column")->where("user_code='%s' AND summary='%s' AND `show`='1'",array(session(C("USER_AUTH_KEY")),$data['summary']))->select();
        if($usc){
           foreach ($usc as $v) {
              $show_list[$v['column']]=1;
           }
        }

        $search["_tab"] = $this->tabsheet_check(I("request._tab"));
        $tab = $search["_tab"];

        $search["status"] = I("request.status");
        $search["goods_no"] = I("request.goods_no");
        $search["name"] = I("request.name");
        $search["materials"] = I("request.materials");
        $search["org_goods_no"] = I("request.org_goods_no");
        $search["uom_weight"] = I("request.uom_weight");
        $search["uom_qty"] = I("request.uom_qty");
        $search["active"] = I("request.active");
        $search["assign_mode"] = I("request.assign_mode");


        //condition
        $condition="";
        $condition_goods="";

        //读取关键字搜索内容
        $search["_keyword"] = I("request._keyword");
        if($search["_showsearch"]=="hide"  ){
            if($search["_keyword"]){
                $condition_keyword = "";
                $condition_keyword = join_condition($condition_keyword,"@goods.goods_no",$search["_keyword"],"char", "both" , 0, "" );
                $condition_keyword = join_condition($condition_keyword,"@goods.name",$search["_keyword"],"char", "both" , 0, "OR" );
                $condition_goods = " AND ( ". $condition_keyword . ")";
            }
        }else{
        //高级搜索condition
           $condition_goods = join_condition($condition_goods,"@goods.status",$search["status"],"int");
           $condition_goods = join_condition($condition_goods,"@goods.goods_no",$search["goods_no"],"char");
           $condition_goods = join_condition($condition_goods,"@goods.name",$search["name"],"char","both");
           $condition_goods = join_condition($condition_goods,"@goods.materials",$search["materials"],"char");
           $condition_goods = join_condition($condition_goods,"@goods.org_goods_no",$search["org_goods_no"],"char");
           $condition_goods = join_condition($condition_goods,"@goods.uom_weight",$search["uom_weight"],"char");
           $condition_goods = join_condition($condition_goods,"@goods.uom_qty",$search["uom_qty"],"char");
           $condition_goods = join_condition($condition_goods,"@goods.active",$search["active"],"int");
           $condition_goods = join_condition($condition_goods,"@goods.assign_mode",$search["assign_mode"],"int");
        }
        $condition_goods = $this->tabsheet_condition($condition_goods ,$search["_tab"]);

        //select fields
        $selectfields="@goods.status ";
        $selectfields.=",@goods.id ";
        $selectfields.=",@goods.goods_no ";
        $selectfields.=",@goods.name ";
        $selectfields.=",@goods.materials ";
        $selectfields.=",@goods.org_goods_no ";
        $selectfields.=",@goods.uom_weight ";
        $selectfields.=",@goods.uom_qty ";
        $selectfields.=",@goods.active ";
        $selectfields.=",@goods.assign_mode ";


        $str_header = "";
        if ($show_list['status']==1 || empty($show_list)){
            $str_header .= "状态,";
        }
        if ($show_list['goods_no']==1 || empty($show_list)){
            $str_header .= "货品编码,";
        }
        if ($show_list['name']==1 || empty($show_list)){
            $str_header .= "货品名称,";
        }
        if ($show_list['materials']==1 || empty($show_list)){
            $str_header .= "材质,";
        }
        if ($show_list['org_goods_no']==1 || empty($show_list)){
            $str_header .= "机构原始码,";
        }
        if ($show_list['uom_weight']==1 || empty($show_list)){
            $str_header .= "重量单位,";
        }
        if ($show_list['uom_qty']==1 || empty($show_list)){
            $str_header .= "数量单位,";
        }
        if ($show_list['active']==1 || empty($show_list)){
            $str_header .= "活跃等级,";
        }
        if ($show_list['assign_mode']==1 || empty($show_list)){
            $str_header .= "配货方式,";
        }
        $str_header .= "\r\n";

        $join="";

       $count_sql = "select count(*) as cnt from @goods  #join#  where 1=1 #condition#";  // ' for skip replace $condition
       $count_sql = str_replace("#join#",$join,$count_sql);
       $count_sql = str_replace("#condition#",$condition_goods,$count_sql);

       $count_sql = table($count_sql);
       $count_sql = str_replace("·mailchar·","@",$count_sql);
       $count = M()->query($count_sql);
       $count = $count[0]["cnt"];

           $total_page=0;

        if(!$export_all) {
           $page_size = I("request.pagesize/d");
           $page_size = $page_size <= 0 ? session("OrgGoodsSummary-PageSize") : $page_size;
           if(!$page_size) {
              $page_size = 20;
           }


           if($count < $page_size)
              $tmp = 1;
           else{
              $tmp = intval($count / $page_size);
              if($count % $page_size != 0) {
                 $tmp++;
              }
           }

           if($p > $tmp) {
               $p = $tmp;
           }
           $total_page=$p;
        } else {
          $p = 1;
          $page_size = 2000;
          $total_page=ceil($count/$page_size);
        }


        $str_content = "";

        $orderby="order by @goods.sort";
        //$orderby="";

    for ($p;$p<=$total_page;$p++)
    {

        $sql = "select #selectfields# from @goods  #join# Where 1=1 #condition# #orderby#";   // ' for skip replace $selectfields,$condition,$orderby
        $sql = str_replace("#selectfields#",$selectfields,$sql);
        $sql = str_replace("#join#",$join,$sql);
        $sql = str_replace("#condition#",$condition_goods,$sql);
        $sql = str_replace("#orderby#",$orderby,$sql);
        $sql .= " LIMIT ". (($p - 1) * $page_size). ", ".$page_size;

        $sql = table($sql);
        $sql = str_replace("·mailchar·","@",$sql);
        $list = M()->query($sql);

        foreach($list as $master) {
            $str_line="";
            if ($show_list['status']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Goods_status("$master[status]","name"))."\t,";
            }
            if ($show_list['goods_no']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["goods_no"])."\t,";
            }
            if ($show_list['name']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["name"])."\t,";
            }
            if ($show_list['materials']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["materials"])."\t,";
            }
            if ($show_list['org_goods_no']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["org_goods_no"])."\t,";
            }
            if ($show_list['uom_weight']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["uom_weight"])."\t,";
            }
            if ($show_list['uom_qty']==1  || empty($show_list )) {
                $str_line.=$this->csvdata($master["uom_qty"])."\t,";
            }
            if ($show_list['active']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Goods_active("$master[active]","name"))."\t,";
            }
            if ($show_list['assign_mode']==1  || empty($show_list )) {
                $str_line.=$this->csvdata(get_table_Goods_assign_mode("$master[assign_mode]","name"))."\t,";
            }
            $str_content .= $str_line . "\r\n";
        }
    }
        header('Content-Type: text/xls');
        header ("Content-type:application/vnd.ms-excel;charset=gbk" );
        $str = mb_convert_encoding("OrgGoodsSummary", 'gbk', 'utf-8');
        $str_content = mb_convert_encoding($str_content, 'gbk', 'utf-8');
        $str_header = mb_convert_encoding($str_header, 'gbk', 'utf-8');
        header('Content-Disposition: attachment;filename="' .$str . '.csv"');
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');
        die($str_header.$str_content);
    }



    private function tabsheet_check($itab)
    {
        switch($itab)
        {
          case 'all':
          case 'shiyong':
          case 'tingzhi':
              break;
          default:
              $itab='all';
              break;
              $itab='shiyong';
              break;
              $itab='tingzhi';
              break;
         }
        return $itab;
    }

    private function tabsheet_condition($scondition, $itab)
    {
        $scond="";
        switch($itab)
        {
            case 'all':  //全部
                 $scond="";
                 break;
            case 'shiyong':  //使用
                 $scond="@goods.status='1'";
                 break;
            case 'tingzhi':  //停止
                 $scond="@goods.status='0'";
                 break;
            default :
                 $scond="";
                 break;
        }
        if ($scond)
        {
            $scondition .= " AND (".$scond.")";
        }
        return $scondition;
    }

    private function get_orderby($orderby, $itab)
    {
        switch($itab)
        {
            case 'all':  //全部
                 break;
            case 'shiyong':  //使用
                 break;
            case 'tingzhi':  //停止
                 break;
        }
        if($orderby)
            return " order by $orderby";
        else
            return "";
    }



    private function get_auth_condition(){
        $condition="";
        switch($this->user["side"]){
        }
        return $condition ;
    }
}
