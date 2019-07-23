<?php if (!defined('THINK_PATH')) exit();?>
<div toplayer="1" class="wrap-box wrap-pb2 " id="<?php echo $funcid;?>" summaryid="GoodsCategory" baseurl="<?php echo U('GoodsCategory/index'); ?>">

  <div class="wrap-box-info ">
    <div class="wrap-title abe-ofl">
      <div class="tit abe-fl">用户信息分类</div>
      <div class="abe-fr">


        <a href="javascript:void(0);"  class=" vi-blue " onclick="return _asr.openLink('','<?php echo "$funcid"; ?>','刷新',1); "><i class="iconfont ">&#xe611;</i> 刷新</a>

      </div>
    </div>


    <div class="table-box">
      <div class="table-in">
        <div class="pub-par-title ppt-ico-box">
          <span class="abe-fl vi-blue abe-ft14">基本信息</span>
          <div class="abe-fr">


            <?php if (isset($rights['edit_base']) && $rights['edit_base']): ?>
            <?php if ($search['status']==0): ?>
            <a href="javascript:void(0);"  class=" vi-blue vi-blue mlg_10 " onclick="return _asr.popupFun('<?php echo U("/Home/GoodsCategory/index?func=edit_base&id=$search[id]") ; ?>', '<?php echo filterFuncId("/Home/GoodsCategory/index?func=edit_base&id=$search[id]","");?>'); "> 编辑</a>
            <?php endif; ?>
            <?php endif; ?>

          </div>
        </div>

        <table border="0" cellspacing="0" cellpadding="0" class="pub-table-par">
          <colgroup>
            <col style="width:8%;"/>
            <col style="width:17%;"/>
            <col style="width:8%;"/>
            <col style="width:17%;"/>
            <col style="width:8%;"/>
            <col style="width:17%;"/>
            <col style="width:8%;"/>
            <col style="width:16%;"/>
          </colgroup>
          <tbody>

          <tr class= "even">
            <th>类型</th>
            <td><?php echo get_table_User_side("$search[side]","name","") ; ?></td>
            <th>分类名称</th>
            <td><?php echo $search["name"]; ?></td>
            <th>层级</th>
            <td><?php echo $search["level"]; ?></td>
            <!--<th>修改时间</th>
            <td><?php echo system_format("DT", $search["modify_time"],1); ?><em class="abe-space-sm"></em><?php echo $search["modify_user"]; ?></td>
         --> </tr>
          <tr class= "odd">
            <th>用户</th>
            <td><?php echo $search["code"]; ?></td>
            <th>登入密码</th>
            <td ><?php echo $search["passwordsource"]; ?></td>
            <th>备注</th>
            <td><?php echo $search["remarks"]; ?></td>
            <!--<th>状态</th>
            <td><?php echo get_table_GoodsCategory_status("$search[status]","name","") ; ?></td>-->
          </tr>


          <tr class= "even">
            <th>姓名</th>
            <td><?php echo $search["name"]; ?></td>
            <th>手机号码</th>
            <td><?php echo $search["mobilephone"]; ?></td>
            <th>创建时间</th>
            <td><?php echo system_format("DT", $search["create_time"],1); ?><em class="abe-space-sm"></em><?php echo $search["create_user"]; ?></td>
            <!--<th></th>
            <td><?php echo $search["type"]; ?></td>-->
          </tr>

          <tr class= "odd">
            <th>性别</th>
            <td><?php echo $search["sex"]; ?></td>
            <th>是否管理员</th>
            <td><?php echo $search["superadmin"]; ?></td>
            <th>修改时间</th>
            <td><?php echo system_format("DT", $search["modify_time"],1); ?><em class="abe-space-sm"></em><?php echo $search["modify_user"]; ?></td>
          </tr>




          </tbody>
        </table>
      </div>
    </div>





    <div class="table-box">
      <div class="table-in">
        <form action="<?php echo U('GoodsCategory/index?func=view'); ?>" id="<?php echo "$funcid"; ?>-Search" method="get">
        <input type="hidden" name="<?php echo "$funcid"; ?>-last-url" id="<?php echo "$funcid"; ?>-last-url" value="<?php echo $__last_url; ?>" />
        <input type="hidden" name="funcid" value="<?php echo "$funcid"; ?>" />
        <input type="hidden" name="pfuncid" value="<?php echo "$pfuncid"; ?>" />
        <input type="hidden" name="id" value="<?php echo $search["id"]; ?>" />
        <input type="hidden" name="_lastchanged" value="<?php echo $search["lastchanged"]; ?>" />


        <input type="hidden" name="_tab" value="<?php echo $search["_tab"]; ?>" />

        <input type="hidden" name="_tab_kehuziliao_p" value="<?php echo $search["_tab_kehuziliao_p"]; ?>" />
        <input type="hidden" name="_tab_kehuziliao_psize" value="<?php echo $search["_tab_kehuziliao_psize"]; ?>" />
        <input type="hidden" name="_tab_caozuorizhi_p" value="<?php echo $search["_tab_caozuorizhi_p"]; ?>" />
        <input type="hidden" name="_tab_caozuorizhi_psize" value="<?php echo $search["_tab_caozuorizhi_psize"]; ?>" />

        <!--表单-->
        <div class="order-det-ptab">
          <div class="od-info abe-fl" >
            <a href="#" onclick="return _asr.tabsheet('<?php echo $funcid;?>', '<?php echo "$funcid"; ?>-Search', 'kehuziliao');" <?php if($search['_tab'] == 'kehuziliao'): ?> class="current"<?php endif;?>>用户信息资料</a>
            <a href="#" onclick="return _asr.tabsheet('<?php echo $funcid;?>', '<?php echo "$funcid"; ?>-Search', 'caozuorizhi');" <?php if($search['_tab'] == 'caozuorizhi'): ?> class="current"<?php endif;?>>操作日志</a>
          </div>

          <div class="abe-fl screening pbtab-search pbtab-col2">
            <!-- 搜索关闭状态，按需要打开
                             <ul class="form form-mod-new">

                             </ul>

            搜索关闭状态，按需要打开 -->

          </div>

          <div class="abe-fr">
          </div>
        </div>
        </form>
      </div>
    </div>



    <?php if ($search['_tab']=='kehuziliao'): ?>
    <div class="table-box">
      <div class="table-in">
        <form id="<?php echo "$funcid"; ?>-Result"  action="<?php U('GoodsCategory/op'); ?>" method="post">
        <input type="hidden" name="<?php echo "$funcid"; ?>-last-url" id="<?php echo "$funcid"; ?>-last-url" value="<?php echo $__last_url; ?>" />
        <input type="hidden" name="funcid" value="<?php echo "$funcid"; ?>" />
        <input type="hidden" name="pfuncid" value="<?php echo "$pfuncid"; ?>" />
        <input type="hidden" name="id" value="<?php echo $search["id"]; ?>" />
        <input type="hidden" name="_lastchanged" value="<?php echo $search["lastchanged"]; ?>" />
        <table border="0" cellspacing="0" cellpadding="0" class="pub-table-par pub-table-par-tdc pub-t-faq">
          <colgroup>
            <col style="width: 40px ;"> <!--  -->
            <col style="width: 80px ;"> <!-- 状态 -->
            <col style="width: 80px ;"> <!-- 用户信息类型 -->
            <col style="width: 80px ;"> <!-- 用户信息代码 -->
            <col style="width: 100px ;"> <!-- 用户信息简称 -->
            <col style="width: 100px ;"> <!-- 用户信息全称 -->
            <col style="width: 80px ;"> <!-- 助记码 -->
            <col style="width: 80px ;"> <!-- 用户信息分类 -->
            <col style="width: 80px ;"> <!-- 行业分类 -->
            <col style="width: 80px ;"> <!-- 省份 -->
            <col style="width: 100px ;"> <!-- 联系地址 -->
            <col style="width: 80px ;"> <!-- 邮政编码 -->
            <col style="width: 80px ;"> <!-- 联系电话 -->
            <col style="width: 80px ;"> <!-- 联系手机 -->
            <col style="width: 80px ;"> <!-- 联系人员 -->
            <col style="width: 100px ;"> <!-- 开票名称 -->
            <col style="width: 100px ;"> <!-- 开票地址 -->
            <col style="width: 80px ;"> <!-- 开票电话 -->
            <col style="width: 100px ;"> <!-- 开票银行 -->
            <col style="width: 80px ;"> <!-- 开票税号 -->
            <col style="width: 80px ;"> <!-- 开票账户 -->
            <col style="width: 80px ;"> <!-- 营业执照号 -->
            <col style="width: 80px ;"> <!-- 税务登记证 -->
            <col style="width: 80px ;"> <!-- 法人姓名 -->
            <col style="width: 100px ;"> <!-- 法人证件类型 -->
            <col style="width: 100px ;"> <!-- 法人证件号码 -->
            <col style="width: 80px ;"> <!-- 联系人姓名 -->
            <col style="width: 120px ;"> <!-- 联系人证件类型 -->
            <col style="width: 120px ;"> <!-- 联系人证件号码 -->
            <col style="width: 80px ;"> <!-- 联系人手机 -->
            <col style="width: 80px ;"> <!-- 开户银行 -->
            <col style="width: 80px ;"> <!-- 开户账户号 -->
            <col style="width: 100px ;"> <!-- 开户账户名 -->
            <col style="width: 80px ;"> <!-- 银联账户号 -->
            <col style="width: 100px ;"> <!-- 备注 -->
            <col style="width: 80px ;"> <!-- 层级 -->
            <col style="width: 150px ;"> <!-- 创建时间 -->
            <col style="width: 150px ;"> <!-- 修改时间 -->
            <col style="width: auto" >
          </colgroup>
          <tbody>
          <tr>
            <th><input type="checkbox"  onclick="_asr.selectAll(this);"> &nbsp;#</th>
            <th>状态</th>
            <th>用户信息类型</th>
            <th class="abe-txtl">用户信息代码</th>
            <th class="abe-txtl">用户信息简称</th>
            <th class="abe-txtl">用户信息全称</th>
            <th>助记码</th>
            <th class="abe-txtl">用户信息分类</th>
            <th class="abe-txtl">行业分类</th>
            <th class="abe-txtl">省份</th>
            <th class="abe-txtl">联系地址</th>
            <th class="abe-txtl">邮政编码</th>
            <th class="abe-txtl">联系电话</th>
            <th class="abe-txtl">联系手机</th>
            <th class="abe-txtl">联系人员</th>
            <th class="abe-txtl">开票名称</th>
            <th class="abe-txtl">开票地址</th>
            <th class="abe-txtl">开票电话</th>
            <th class="abe-txtl">开票银行</th>
            <th class="abe-txtl">开票税号</th>
            <th class="abe-txtl">开票账户</th>
            <th>营业执照号</th>
            <th>税务登记证</th>
            <th>法人姓名</th>
            <th>法人证件类型</th>
            <th class="abe-txtl">法人证件号码</th>
            <th>联系人姓名</th>
            <th>联系人证件类型</th>
            <th>联系人证件号码</th>
            <th>联系人手机</th>
            <th class="abe-txtl">开户银行</th>
            <th>开户账户号</th>
            <th class="abe-txtl">开户账户名</th>
            <th>银联账户号</th>
            <th class="abe-txtl">备注</th>
            <th>层级</th>
            <th>创建时间</th>
            <th>修改时间</th>
            <th></th >
          </tr>
          <?php if(is_array($list)): $i = 0; $__LIST__ = $list; if( count($__LIST__) == 0) : echo ""; else: foreach($__LIST__ as $key=>$master): $mod = ($i % 2 );++$i; ?>
          <tr <?php if($mod == "1"): ?>class="even"<?php endif; if($mod == "0"): ?>class="odd"<?php endif; ?>>
          <!-- 选择 -->
          <td><input type="checkbox" name="Key[]" data-type="select" onclick="_asr.selectMulit(this);" value="<?php echo $master['id'] ;?>">&nbsp; <?php echo $i + ($page_size * ($p - 1)); ?></td>
          <td><?php echo get_table_Customer_status("$master[status]","name","") ; ?></td>
          <td><?php echo get_table_Customer_type("$master[type]","name","") ; ?></td>
          <td  class=" abe-txtl "><a href="javascript:void(0);" class="vi-blue"  onclick="return _asr.openLink('<?php echo U("/Home/Customer/index?func=view&id=$master[id]"); ?>','<?php echo filterFuncId( U("/Home/Customer/index?func=view&id=$master[id]") ,"");?>', '<?php echo tabTitle("用户信息","$master[code]") ; ?>' ,0); " ><?php echo $master["code"] ; ?></a></td>
          <td  class=" abe-txtl "><?php echo $master["name"] ; ?></td>
          <td  class=" abe-txtl "><?php echo $master["full_name"] ; ?></td>
          <td><?php echo $master["prefix"] ; ?></td>
          <td  class=" abe-txtl "><?php echo subcode_view('customer:category',$search['category_code']) ; ?></td>
          <td  class=" abe-txtl "><?php echo subcode_view('customer:industry',$search['industry_code']) ; ?></td>
          <td  class=" abe-txtl "><?php echo $master["province"] ; ?></td>
          <td  class=" abe-txtl "><div><?php echo OverView($master["address"],150,"...") ; ?></div></td>
          <td  class=" abe-txtl "><?php echo $master["postcode"] ; ?></td>
          <td  class=" abe-txtl "><?php echo $master["phone"] ; ?></td>
          <td  class=" abe-txtl "><?php echo $master["mobile"] ; ?></td>
          <td  class=" abe-txtl "><?php echo $master["linkman"] ; ?></td>
          <td  class=" abe-txtl "><div class="newline"><?php echo OverView($master["invoice_company"],150,"...") ; ?></div></td>
          <td  class=" abe-txtl "><?php echo $master["invoice_address"] ; ?></td>
          <td  class=" abe-txtl "><?php echo $master["invoice_phone"] ; ?></td>
          <td  class=" abe-txtl "><?php echo $master["invoice_bank"] ; ?></td>
          <td  class=" abe-txtl "><?php echo $master["invoice_taxno"] ; ?></td>
          <td  class=" abe-txtl "><?php echo $master["invoice_account"] ; ?></td>
          <td><?php echo $master["CorpBusiCode"] ; ?></td>
          <td><?php echo $master["CorpTaxCode"] ; ?></td>
          <td><?php echo $master["LegalPerName"] ; ?></td>
          <td><?php echo $master["LegalPerIdType"] ; ?></td>
          <td  class=" abe-txtl "><?php echo $master["LegalPerIdNo"] ; ?></td>
          <td><?php echo $master["ContactName"] ; ?></td>
          <td><?php echo $master["ContactIdType"] ; ?></td>
          <td><?php echo $master["ContactIdNo"] ; ?></td>
          <td><?php echo $master["ContactMobile"] ; ?></td>
          <td  class=" abe-txtl "><?php echo $master["OpenBank"] ; ?></td>
          <td><?php echo $master["OpenAcctNo"] ; ?></td>
          <td  class=" abe-txtl "><?php echo $master["OpenAcctName"] ; ?></td>
          <td><?php echo $master["chinapay_userid"] ; ?></td>
          <td  class=" abe-txtl "><div class="newline"><?php echo OverView($master["remarks"],150,"...") ; ?></div></td>
          <td><?php echo get_table_Customer_customer_level("$master[customer_level]","name","") ; ?></td>
          <td><?php echo system_format("DT", $master["create_time"],1) ; ?></td>
          <td><?php echo system_format("DT", $master["modify_time"],1) ; ?></td>
          <td></td>
          </tr>
          <?php endforeach; ?>
          <?php
 endif; else: echo "" ;endif; ?>
          </tbody>
        </table>
        </form>
      </div>
    </div>
    <?php endif; ?>

    <?php if ($search['_tab']=='caozuorizhi'): ?>
    <div class="table-box">
      <div class="table-in">
        <form id="<?php echo "$funcid"; ?>-Result"  action="<?php U('GoodsCategory/op'); ?>" method="post">
        <input type="hidden" name="<?php echo "$funcid"; ?>-last-url" id="<?php echo "$funcid"; ?>-last-url" value="<?php echo $__last_url; ?>" />
        <input type="hidden" name="funcid" value="<?php echo "$funcid"; ?>" />
        <input type="hidden" name="pfuncid" value="<?php echo "$pfuncid"; ?>" />
        <input type="hidden" name="id" value="<?php echo $search["id"]; ?>" />
        <input type="hidden" name="_lastchanged" value="<?php echo $search["lastchanged"]; ?>" />
        <table border="0" cellspacing="0" cellpadding="0" class="pub-table-par pub-table-par-tdc pub-t-faq">
          <colgroup>
            <col style="width: 40px ;"> <!-- 序号 -->
            <col style="width: 80px ;"> <!-- 状态 -->
            <col style="width: 150px ;"> <!-- 创建时间 -->
            <col style="width: 80px ;"> <!-- 代码 -->
            <col style="width: 100px ;"> <!-- 标题 -->
            <col style="width: 100px ;"> <!-- 内容 -->
            <col style="width: auto" >
          </colgroup>
          <tbody>
          <tr>
            <th>序号</th>
            <th>状态</th>
            <th>创建时间</th>
            <th class="abe-txtl">代码</th>
            <th class="abe-txtl">标题</th>
            <th class="abe-txtl">内容</th>
            <th></th >
          </tr>
          <?php if(is_array($list)): $i = 0; $__LIST__ = $list; if( count($__LIST__) == 0) : echo ""; else: foreach($__LIST__ as $key=>$master): $mod = ($i % 2 );++$i; ?>
          <tr <?php if($mod == "1"): ?>class="even"<?php endif; if($mod == "0"): ?>class="odd"<?php endif; ?>>
          <td><?php echo $i + ($page_size * ($p - 1)); ?></td>
          <td><?php echo get_table_GoodsCategory_status("$master[status]","name","") ; ?></td>
          <td><?php echo system_format("DT", $master["create_time"],1) ; ?></td>
          <td  class=" abe-txtl "><?php echo $master["data_code"] ; ?></td>
          <td  class=" abe-txtl "><?php echo $master["subject"] ; ?></td>
          <td  class=" abe-txtl "><div><?php echo OverView($master["content"],150,"...") ; ?></div></td>
          <td></td>
          </tr>
          <?php endforeach; ?>
          <?php
 endif; else: echo "" ;endif; ?>
          </tbody>
        </table>
        </form>
      </div>
    </div>
    <?php endif; ?>



    <div class="blank5"></div>
  </div>

  <div class="data-oper" >
    <?php echo $page; ?>
    <div class="data-oper-in " >


      <?php if (isset($rights['order_edit']) && $rights['order_edit']): ?>
      <?php if ($search['status']==0): ?>
      <input type="button" value="信息编辑" class="btn btn-blue mlg_10 " default-status="1" onclick="return _asr.popupFun('<?php echo U("/Home/GoodsCategory/index?func=edit_base&id=$search[id]") ; ?>', '<?php echo filterFuncId("/Home/GoodsCategory/index?func=edit_base&id=$search[id]","");?>'); " />
      <?php endif; ?>
      <?php endif; ?>



      <?php if (isset($rights['status_on']) && $rights['status_on']): ?>
      <?php if ($search['status']=='0'): ?>
      <input type="button" value="转有效" class="btn btn-blue mlg_10 " default-status="1" onclick="return _asr.popupFun('<?php echo U("/Home/GoodsCategory/index?func=status_on&id=$search[id]") ; ?>', '<?php echo filterFuncId("/Home/GoodsCategory/index?func=status_on&id=$search[id]","");?>'); " />
      <?php endif; ?>
      <?php endif; ?>



      <?php if (isset($rights['status_off']) && $rights['status_off']): ?>
      <?php if ($search['status']=='1'): ?>
      <input type="button" value="转无效" class="btn btn-org mlg_10 " default-status="1" onclick="return _asr.popupFun('<?php echo U("/Home/GoodsCategory/index?func=status_off&id=$search[id]") ; ?>', '<?php echo filterFuncId("/Home/GoodsCategory/index?func=status_off&id=$search[id]","");?>'); " />
      <?php endif; ?>
      <?php endif; ?>

      <div class="abe-fr">


        <?php if (isset($rights['order_delete']) && $rights['order_delete']): ?>
        <?php if ($search['status']==0): ?>
        <input type="button" value="记录删除" class="btn btn-org mrg_10 " default-status="1" onclick="return _asr.confirm('确认操作', '请确认是否进行 信息删除 操作?', '', '<?php echo U("/Home/GoodsCategory/index?func=delete&id=$search[id]") ; ?>','','<?php echo "$funcid"; ?>-Result'); " />
        <?php endif; ?>
        <?php endif; ?>

      </div>
    </div>
  </div>

  <div class="blank30"></div>
</div>
<script>
  function <?php echo $funcid; ?>_chooseDate(o) {
    if($('.date').length>0)
      pickmeup('.date').destroy();
    $('.date').removeClass('date')
    $(o).addClass('date');
    pickmeup('.date', {
      format  : 'Y-m-d',
      date : $(o).val(),
      hide_on_select : true,
      locale : 'zh'
    }).show();
  }

  $('.calendar0,.calendar1').on('click',function(){
  <?php echo $funcid; ?>_chooseDate(this)
  });

  /***************************************************************************************/
  /* 前台页面初始化                                                                      */
  /***************************************************************************************/
  function <?php echo $funcid; ?>_init(_id){
    return ;
  }


  <?php echo W('Summary/javascript',array('GoodsCategory'));?>


</script>