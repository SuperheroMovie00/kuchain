<?php if (!defined('THINK_PATH')) exit();?>
<div toplayer="1" class="wrap-box wrap-pb2 " id="<?php echo $funcid;?>" summaryid="Org" baseurl="<?php echo U('Org/index'); ?>">

   <div class="wrap-box-info ">
      <div class="wrap-title abe-ofl">
         <div class="tit abe-fl">库链联盟机构</div>
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
               <a href="javascript:void(0);"  class=" vi-blue vi-blue mlg_10 " onclick="return _asr.popupFun('<?php echo U("/Home/Org/index?func=edit_base&id=$search[id]") ; ?>', '<?php echo filterFuncId("/Home/Org/index?func=edit_base&id=$search[id]","");?>'); "> 编辑</a>
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
             <th>机构类型</th>
             <td><?php echo get_table_Org_type("$search[type]","name","") ; ?></td>
             <th>联系电话</th>
             <td><?php echo $search["phone"]; ?></td>
             <th>接口控制</th>
             <td><?php echo get_table_Org_interface_open("$search[interface_open]","name","") ; ?></td>
             <th>创建时间</th>
             <td><?php echo system_format("DT", $search["create_time"],1); ?><em class="abe-space-sm"></em><?php echo $search["create_user"]; ?></td>
           </tr>
           <tr class= "odd">
             <th>机构代码</th>
             <td><a href="javascript:void(0);" class="vi-blue"  onclick="return _asr.openLink('<?php echo U("/Home/Org/index?func=view&id=$search[id]"); ?>','<?php echo filterFuncId( U("/Home/Org/index?func=view&id=$search[id]") ,"");?>', '<?php echo tabTitle("库链","$search[code]") ; ?>' ,0); " ><?php echo $search["code"]; ?></a></td>
             <th>联系人员</th>
             <td><?php echo $search["contacts"]; ?></td>
             <th>接口类型</th>
             <td><?php echo get_table_Org_interface_type("$search[interface_type]","name","") ; ?></td>
             <th>修改时间</th>
             <td><?php echo system_format("DT", $search["modify_time"],1); ?><em class="abe-space-sm"></em><?php echo $search["modify_user"]; ?></td>
           </tr>
           <tr class= "even">
             <th>机构名称</th>
             <td><?php echo $search["name"]; ?></td>
             <th>联系地址</th>
             <td title="<?php echo $search["address"]; ?>"><?php echo OverView($search["address"],150,"..."); ?></td>
             <th>备注</th>
             <td title="<?php echo $search["remarks"]; ?>"><?php echo OverView($search["remarks"],150,"..."); ?></td>
             <th>状态</th>
             <td><?php echo get_table_Org_status("$search[status]","name","") ; ?></td>
           </tr>

        </tbody>
     </table>
         </div>
      </div>





       <div class="table-box">
         <div class="table-in">
            <form action="<?php echo U('Org/index?func=view'); ?>" id="<?php echo "$funcid"; ?>-Search" method="get">
                <input type="hidden" name="<?php echo "$funcid"; ?>-last-url" id="<?php echo "$funcid"; ?>-last-url" value="<?php echo $__last_url; ?>" />
                <input type="hidden" name="funcid" value="<?php echo "$funcid"; ?>" />
                <input type="hidden" name="pfuncid" value="<?php echo "$pfuncid"; ?>" />
                <input type="hidden" name="id" value="<?php echo $search["id"]; ?>" />
                <input type="hidden" name="_lastchanged" value="<?php echo $search["lastchanged"]; ?>" />


                <input type="hidden" name="_tab" value="<?php echo $search["_tab"]; ?>" />

                <input type="hidden" name="_tab_cangkuxinxi_p" value="<?php echo $search["_tab_cangkuxinxi_p"]; ?>" />
                <input type="hidden" name="_tab_cangkuxinxi_psize" value="<?php echo $search["_tab_cangkuxinxi_psize"]; ?>" />
                <input type="hidden" name="_tab_yonghuxinxi_p" value="<?php echo $search["_tab_yonghuxinxi_p"]; ?>" />
                <input type="hidden" name="_tab_yonghuxinxi_psize" value="<?php echo $search["_tab_yonghuxinxi_psize"]; ?>" />
                <input type="hidden" name="_tab_huopinxinxi_p" value="<?php echo $search["_tab_huopinxinxi_p"]; ?>" />
                <input type="hidden" name="_tab_huopinxinxi_psize" value="<?php echo $search["_tab_huopinxinxi_psize"]; ?>" />
                <input type="hidden" name="_tab_caozuorizhi_p" value="<?php echo $search["_tab_caozuorizhi_p"]; ?>" />
                <input type="hidden" name="_tab_caozuorizhi_psize" value="<?php echo $search["_tab_caozuorizhi_psize"]; ?>" />

                  <!--表单-->
                  <div class="order-det-ptab">
                    <div class="od-info abe-fl" >
                      <a href="#" onclick="return _asr.tabsheet('<?php echo $funcid;?>', '<?php echo "$funcid"; ?>-Search', 'cangkuxinxi');" <?php if($search['_tab'] == 'cangkuxinxi'): ?> class="current"<?php endif;?>>仓库信息</a>
                      <a href="#" onclick="return _asr.tabsheet('<?php echo $funcid;?>', '<?php echo "$funcid"; ?>-Search', 'yonghuxinxi');" <?php if($search['_tab'] == 'yonghuxinxi'): ?> class="current"<?php endif;?>>用户信息</a>
                      <a href="#" onclick="return _asr.tabsheet('<?php echo $funcid;?>', '<?php echo "$funcid"; ?>-Search', 'huopinxinxi');" <?php if($search['_tab'] == 'huopinxinxi'): ?> class="current"<?php endif;?>>货品信息</a>
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



              <?php if ($search['_tab']=='cangkuxinxi'): ?>
                <div class="table-box">
                  <div class="table-in">
                    <form id="<?php echo "$funcid"; ?>-Result"  action="<?php U('Org/op'); ?>" method="post">
                      <input type="hidden" name="<?php echo "$funcid"; ?>-last-url" id="<?php echo "$funcid"; ?>-last-url" value="<?php echo $__last_url; ?>" />
                      <input type="hidden" name="funcid" value="<?php echo "$funcid"; ?>" />
                      <input type="hidden" name="pfuncid" value="<?php echo "$pfuncid"; ?>" />
                      <input type="hidden" name="id" value="<?php echo $search["id"]; ?>" />
                      <input type="hidden" name="_lastchanged" value="<?php echo $search["lastchanged"]; ?>" />
                      <table border="0" cellspacing="0" cellpadding="0" class="pub-table-par pub-table-par-tdc pub-t-faq">
                        <colgroup>
                          <col style="width: 40px ;"> <!--  -->
                          <col style="width: 80px ;"> <!-- 状态 -->
                          <col style="width: 80px ;"> <!-- 仓库编码 -->
                          <col style="width: 100px ;"> <!-- 仓库名称 -->
                          <col style="width: 80px ;"> <!-- 联系电话 -->
                          <col style="width: 80px ;"> <!-- 联系人员 -->
                          <col style="width: 100px ;"> <!-- 联系地址 -->
                          <col style="width: 150px ;"> <!-- 创建时间 -->
                          <col style="width: 150px ;"> <!-- 修改时间 -->
                          <col style="width: auto" >
                        </colgroup>
                        <tbody>
                          <tr>
                            <th><input type="checkbox"  onclick="_asr.selectAll(this);"> &nbsp;#</th>
                            <th>状态</th>
                            <th class="abe-txtl">仓库编码</th>
                            <th class="abe-txtl">仓库名称</th>
                            <th class="abe-txtl">联系电话</th>
                            <th class="abe-txtl">联系人员</th>
                            <th class="abe-txtl">联系地址</th>
                            <th>创建时间</th>
                            <th>修改时间</th>
                           <th></th >
                          </tr>
                          <?php if(is_array($list)): $i = 0; $__LIST__ = $list; if( count($__LIST__) == 0) : echo ""; else: foreach($__LIST__ as $key=>$master): $mod = ($i % 2 );++$i; ?>
                                  <tr <?php if($mod == "1"): ?>class="even"<?php endif; if($mod == "0"): ?>class="odd"<?php endif; ?>>
                                    <!-- 选择 -->
                                    <td><input type="checkbox" name="Key[]" data-type="select" onclick="_asr.selectMulit(this);" value="<?php echo $master['id'] ;?>">&nbsp; <?php echo $i + ($page_size * ($p - 1)); ?></td>
                                    <td><?php echo get_table_Warehouse_status("$master[status]","name","") ; ?></td>
                                    <td  class=" abe-txtl "><a href="javascript:void(0);" class="vi-blue"  onclick="return _asr.openLink('<?php echo U("/Home/Warehouse/index?func=view&id=$master[id]"); ?>','<?php echo filterFuncId( U("/Home/Warehouse/index?func=view&id=$master[id]") ,"");?>', '<?php echo tabTitle("仓库","$master[code]") ; ?>' ,0); " ><?php echo $master["code"] ; ?></a></td>
                                    <td  class=" abe-txtl "><?php echo $master["name"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["phone"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["contacts"] ; ?></td>
                                    <td  class=" abe-txtl "><div class="newline"><?php echo OverView($master["address"],150,"...") ; ?></div></td>
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

              <?php if ($search['_tab']=='yonghuxinxi'): ?>
                <div class="table-box">
                  <div class="table-in">
                    <form id="<?php echo "$funcid"; ?>-Result"  action="<?php U('Org/op'); ?>" method="post">
                      <input type="hidden" name="<?php echo "$funcid"; ?>-last-url" id="<?php echo "$funcid"; ?>-last-url" value="<?php echo $__last_url; ?>" />
                      <input type="hidden" name="funcid" value="<?php echo "$funcid"; ?>" />
                      <input type="hidden" name="pfuncid" value="<?php echo "$pfuncid"; ?>" />
                      <input type="hidden" name="id" value="<?php echo $search["id"]; ?>" />
                      <input type="hidden" name="_lastchanged" value="<?php echo $search["lastchanged"]; ?>" />
                      <table border="0" cellspacing="0" cellpadding="0" class="pub-table-par pub-table-par-tdc pub-t-faq">
                        <colgroup>
                          <col style="width: 40px ;"> <!-- 序号 -->
                          <col style="width: 80px ;"> <!-- 状态 -->
                          <col style="width: 80px ;"> <!-- 类型 -->
                          <col style="width: 80px ;"> <!-- 用户 -->
                          <col style="width: 100px ;"> <!-- 姓名 -->
                          <col style="width: 80px ;"> <!-- 性别 -->
                          <col style="width: 80px ;"> <!-- 手机号码 -->
                          <col style="width: 80px ;"> <!-- 管理员 -->
                          <col style="width: 100px ;"> <!-- 密码错误次数 -->
                          <col style="width: 80px ;"> <!-- 排序 -->
                          <col style="width: 100px ;"> <!-- 备注 -->
                          <col style="width: 150px ;"> <!-- 创建时间 -->
                          <col style="width: 150px ;"> <!-- 修改时间 -->
                          <col style="width: auto" >
                        </colgroup>
                        <tbody>
                          <tr>
                            <th>序号</th>
                            <th>状态</th>
                            <th>类型</th>
                            <th class="abe-txtl">用户</th>
                            <th class="abe-txtl">姓名</th>
                            <th>性别</th>
                            <th class="abe-txtl">手机号码</th>
                            <th>管理员</th>
                            <th>密码错误次数</th>
                            <th>排序</th>
                            <th class="abe-txtl">备注</th>
                            <th>创建时间</th>
                            <th>修改时间</th>
                           <th></th >
                          </tr>
                          <?php if(is_array($list)): $i = 0; $__LIST__ = $list; if( count($__LIST__) == 0) : echo ""; else: foreach($__LIST__ as $key=>$master): $mod = ($i % 2 );++$i; ?>
                                  <tr <?php if($mod == "1"): ?>class="even"<?php endif; if($mod == "0"): ?>class="odd"<?php endif; ?>>
                                    <td><?php echo $i + ($page_size * ($p - 1)); ?></td>
                                    <td><?php echo get_table_User_status("$master[status]","name","") ; ?></td>
                                    <td><?php echo get_table_User_side("$master[side]","name","") ; ?></td>
                                    <td  class=" abe-txtl "><a href="javascript:void(0);" class="vi-blue"  onclick="return _asr.openLink('<?php echo U("/Home/User/index?func=view&id=$master[id]"); ?>','<?php echo filterFuncId( U("/Home/User/index?func=view&id=$master[id]") ,"");?>', '<?php echo tabTitle("用户","$master[code]") ; ?>' ,0); " ><?php echo $master["code"] ; ?></a></td>
                                    <td  class=" abe-txtl "><?php echo $master["name"] ; ?></td>
                                    <td><?php echo get_table_User_sex("$master[sex]","name","") ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["mobilephone"] ; ?></td>
                                    <td><?php echo get_table_User_superadmin("$master[superadmin]","name","") ; ?></td>
                                    <td><?php echo system_format("N3", $master["errpwd_count"],1) ; ?></td>
                                    <td><?php echo system_format("N", $master["sort"],1) ; ?></td>
                                    <td  class=" abe-txtl "><div class="newline"><?php echo OverView($master["remarks"],150,"...") ; ?></div></td>
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

              <?php if ($search['_tab']=='huopinxinxi'): ?>
                <div class="table-box">
                  <div class="table-in">
                    <form id="<?php echo "$funcid"; ?>-Result"  action="<?php U('Org/op'); ?>" method="post">
                      <input type="hidden" name="<?php echo "$funcid"; ?>-last-url" id="<?php echo "$funcid"; ?>-last-url" value="<?php echo $__last_url; ?>" />
                      <input type="hidden" name="funcid" value="<?php echo "$funcid"; ?>" />
                      <input type="hidden" name="pfuncid" value="<?php echo "$pfuncid"; ?>" />
                      <input type="hidden" name="id" value="<?php echo $search["id"]; ?>" />
                      <input type="hidden" name="_lastchanged" value="<?php echo $search["lastchanged"]; ?>" />
                      <table border="0" cellspacing="0" cellpadding="0" class="pub-table-par pub-table-par-tdc pub-t-faq">
                        <colgroup>
                          <col style="width: 40px ;"> <!-- 序号 -->
                          <col style="width: 80px ;"> <!-- 状态 -->
                          <col style="width: 80px ;"> <!-- 货品编码 -->
                          <col style="width: 100px ;"> <!-- 货品名称 -->
                          <col style="width: 80px ;"> <!-- 助记码 -->
                          <col style="width: 100px ;"> <!-- 规格材质 -->
                          <col style="width: 80px ;"> <!-- 货品产地 -->
                          <col style="width: 80px ;"> <!-- 注册商标 -->
                          <col style="width: 80px ;"> <!-- 规格编码 -->
                          <col style="width: 80px ;"> <!-- 货品分类 -->
                          <col style="width: 80px ;"> <!-- 数量单位 -->
                          <col style="width: 80px ;"> <!-- 重量单位 -->
                          <col style="width: 80px ;"> <!-- 散件单位 -->
                          <col style="width: 80px ;"> <!-- 活跃等级 -->
                          <col style="width: 100px ;"> <!-- 图像 -->
                          <col style="width: 150px ;"> <!-- 创建时间 -->
                          <col style="width: 150px ;"> <!-- 修改时间 -->
                          <col style="width: auto" >
                        </colgroup>
                        <tbody>
                          <tr>
                            <th>序号</th>
                            <th>状态</th>
                            <th class="abe-txtl">货品编码</th>
                            <th class="abe-txtl">货品名称</th>
                            <th>助记码</th>
                            <th class="abe-txtl">规格材质</th>
                            <th class="abe-txtl">货品产地</th>
                            <th class="abe-txtl">注册商标</th>
                            <th class="abe-txtl">规格编码</th>
                            <th class="abe-txtl">货品分类</th>
                            <th>数量单位</th>
                            <th>重量单位</th>
                            <th>散件单位</th>
                            <th>活跃等级</th>
                            <th class="abe-txtl">图像</th>
                            <th>创建时间</th>
                            <th>修改时间</th>
                           <th></th >
                          </tr>
                          <?php if(is_array($list)): $i = 0; $__LIST__ = $list; if( count($__LIST__) == 0) : echo ""; else: foreach($__LIST__ as $key=>$master): $mod = ($i % 2 );++$i; ?>
                                  <tr <?php if($mod == "1"): ?>class="even"<?php endif; if($mod == "0"): ?>class="odd"<?php endif; ?>>
                                    <td><?php echo $i + ($page_size * ($p - 1)); ?></td>
                                    <td><?php echo get_table_Goods_status("$master[status]","name","") ; ?></td>
                                    <td  class=" abe-txtl "><a href="javascript:void(0);" class="vi-blue"  onclick="return _asr.openLink('<?php echo U("/Home/Goods/index?func=view&no=$master[goods_no]"); ?>','<?php echo filterFuncId( U("/Home/Goods/index?func=view&no=$master[goods_no]") ,"");?>', 'id详情' ,0); " ><?php echo $master["goods_no"] ; ?></a></td>
                                    <td  class=" abe-txtl "><?php echo $master["name"] ; ?></td>
                                    <td><?php echo $master["prefix"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["style_info"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["producing_area"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["brand"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["style_code"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo subcode_view('goods:category',$search['category_code']) ; ?></td>
                                    <td><?php echo $master["uom_qty"] ; ?></td>
                                    <td><?php echo $master["uom_weight"] ; ?></td>
                                    <td><?php echo $master["uom_bulkcargo"] ; ?></td>
                                    <td><?php echo get_table_Goods_active("$master[active]","name","") ; ?></td>
                                    <td  class=" abe-txtl "><?php if($master["img"]): ?><a href="<?php echo $master["img"] ;?>" target="_blank" class="vi-blue"   >图像</a><?php endif; ?></td>
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
                    <form id="<?php echo "$funcid"; ?>-Result"  action="<?php U('Org/op'); ?>" method="post">
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
                                    <td><?php echo get_table_Org_status("$master[status]","name","") ; ?></td>
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
               <input type="button" value="信息编辑" class="btn btn-blue mlg_10 " default-status="1" onclick="return _asr.popupFun('<?php echo U("/Home/Org/index?func=edit_base&id=$search[id]") ; ?>', '<?php echo filterFuncId("/Home/Org/index?func=edit_base&id=$search[id]","");?>'); " />
          <?php endif; ?>
          <?php endif; ?>



          <?php if (isset($rights['status_on']) && $rights['status_on']): ?>
          <?php if ($search['status']=='0'): ?>
               <input type="button" value="转有效" class="btn btn-blue mlg_10 " default-status="1" onclick="return _asr.popupFun('<?php echo U("/Home/Org/index?func=status_on&id=$search[id]") ; ?>', '<?php echo filterFuncId("/Home/Org/index?func=status_on&id=$search[id]","");?>'); " />
          <?php endif; ?>
          <?php endif; ?>



          <?php if (isset($rights['status_off']) && $rights['status_off']): ?>
          <?php if ($search['status']=='1'): ?>
               <input type="button" value="转失效" class="btn btn-org mlg_10 " default-status="1" onclick="return _asr.popupFun('<?php echo U("/Home/Org/index?func=status_off&id=$search[id]") ; ?>', '<?php echo filterFuncId("/Home/Org/index?func=status_off&id=$search[id]","");?>'); " />
          <?php endif; ?>
          <?php endif; ?>

          <div class="abe-fr">


          <?php if (isset($rights['order_delete']) && $rights['order_delete']): ?>
          <?php if ($search['status']==0): ?>
               <input type="button" value="记录删除" class="btn btn-org mrg_10 " default-status="1" onclick="return _asr.confirm('确认操作', '请确认是否进行 信息删除 操作?', '', '<?php echo U("/Home/Org/index?func=delete&id=$search[id]") ; ?>','','<?php echo "$funcid"; ?>-Result'); " />
          <?php endif; ?>
          <?php endif; ?>

              <input type="button" value="测试PDF" class="btn btn-org mrg_10 " default-status="1" onclick="return _asr.confirm('确认操作', '请确认是否进行导出PDF操作?', '', '<?php echo U("/Home/Trades/index?func=createPDF&id=$search[id]") ; ?>','','<?php echo "$funcid"; ?>-Result'); " />


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


    <?php echo W('Summary/javascript',array('Org'));?>


    </script>