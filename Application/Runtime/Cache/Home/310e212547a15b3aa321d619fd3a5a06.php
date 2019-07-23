<?php if (!defined('THINK_PATH')) exit();?>
<div toplayer="1" class="wrap-box wrap-pb2 " id="<?php echo $funcid;?>" summaryid="Warehouse" baseurl="<?php echo U('Warehouse/index'); ?>">

   <div class="wrap-box-info ">
      <div class="wrap-title abe-ofl">
         <div class="tit abe-fl">仓库信息</div>
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
               <a href="javascript:void(0);"  class=" vi-blue vi-blue mlg_10 " onclick="return _asr.popupFun('<?php echo U("/Home/Warehouse/index?func=edit_base&id=$search[id]") ; ?>', '<?php echo filterFuncId("/Home/Warehouse/index?func=edit_base&id=$search[id]","");?>'); "> 编辑</a>
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
             <th>仓库编码</th>
             <td><a href="javascript:void(0);" class="vi-blue"  onclick="return _asr.openLink('<?php echo U("/Home/Warehouse/index?func=view&id=$search[id]"); ?>','<?php echo filterFuncId( U("/Home/Warehouse/index?func=view&id=$search[id]") ,"");?>', '<?php echo tabTitle("仓库","$search[code]") ; ?>' ,0); " ><?php echo $search["code"]; ?></a><em class="abe-space-sm"></em></td>
             <th>联系电话</th>
             <td><?php echo $search["phone"]; ?></td>
             <th>联系地址</th>
             <td title="<?php echo $search["address"]; ?>"><?php echo OverView($search["address"],150,"..."); ?></td>
             <th>修改时间</th>
             <td><?php echo system_format("DT", $search["modify_time"],1); ?><em class="abe-space-sm"></em><?php echo $search["modify_user"]; ?></td>
           </tr>
           <tr class= "odd">
             <th>仓库名称</th>
             <td><?php echo $search["name"]; ?></td>
             <th>联系人员</th>
             <td><?php echo $search["contacts"]; ?></td>
             <th>创建时间</th>
             <td><?php echo system_format("DT", $search["create_time"],1); ?><em class="abe-space-sm"></em><?php echo $search["create_user"]; ?></td>
             <th>状态</th>
             <td><?php echo get_table_Warehouse_status("$search[status]","name","") ; ?></td>
           </tr>

        </tbody>
     </table>
         </div>
      </div>





       <div class="table-box">
         <div class="table-in">
            <form action="<?php echo U('Warehouse/index?func=view'); ?>" id="<?php echo "$funcid"; ?>-Search" method="get">
                <input type="hidden" name="<?php echo "$funcid"; ?>-last-url" id="<?php echo "$funcid"; ?>-last-url" value="<?php echo $__last_url; ?>" />
                <input type="hidden" name="funcid" value="<?php echo "$funcid"; ?>" />
                <input type="hidden" name="pfuncid" value="<?php echo "$pfuncid"; ?>" />
                <input type="hidden" name="id" value="<?php echo $search["id"]; ?>" />
                <input type="hidden" name="_lastchanged" value="<?php echo $search["lastchanged"]; ?>" />


                <input type="hidden" name="_tab" value="<?php echo $search["_tab"]; ?>" />

                <input type="hidden" name="_tab_kucunxinxi_p" value="<?php echo $search["_tab_kucunxinxi_p"]; ?>" />
                <input type="hidden" name="_tab_kucunxinxi_psize" value="<?php echo $search["_tab_kucunxinxi_psize"]; ?>" />
                <input type="hidden" name="_tab_cunchuka_p" value="<?php echo $search["_tab_cunchuka_p"]; ?>" />
                <input type="hidden" name="_tab_cunchuka_psize" value="<?php echo $search["_tab_cunchuka_psize"]; ?>" />
                <input type="hidden" name="_tab_cunchukamadan_p" value="<?php echo $search["_tab_cunchukamadan_p"]; ?>" />
                <input type="hidden" name="_tab_cunchukamadan_psize" value="<?php echo $search["_tab_cunchukamadan_psize"]; ?>" />
                <input type="hidden" name="_tab_cunchukaduohao_p" value="<?php echo $search["_tab_cunchukaduohao_p"]; ?>" />
                <input type="hidden" name="_tab_cunchukaduohao_psize" value="<?php echo $search["_tab_cunchukaduohao_psize"]; ?>" />
                <input type="hidden" name="_tab_cunchukataizhang_p" value="<?php echo $search["_tab_cunchukataizhang_p"]; ?>" />
                <input type="hidden" name="_tab_cunchukataizhang_psize" value="<?php echo $search["_tab_cunchukataizhang_psize"]; ?>" />
                <input type="hidden" name="_tab_cunchukajiasuo_p" value="<?php echo $search["_tab_cunchukajiasuo_p"]; ?>" />
                <input type="hidden" name="_tab_cunchukajiasuo_psize" value="<?php echo $search["_tab_cunchukajiasuo_psize"]; ?>" />
                <input type="hidden" name="_tab_caozuorizhi_p" value="<?php echo $search["_tab_caozuorizhi_p"]; ?>" />
                <input type="hidden" name="_tab_caozuorizhi_psize" value="<?php echo $search["_tab_caozuorizhi_psize"]; ?>" />

                  <!--表单-->
                  <div class="order-det-ptab">
                    <div class="od-info abe-fl" >
                      <a href="#" onclick="return _asr.tabsheet('<?php echo $funcid;?>', '<?php echo "$funcid"; ?>-Search', 'kucunxinxi');" <?php if($search['_tab'] == 'kucunxinxi'): ?> class="current"<?php endif;?>>库存信息</a>
                      <a href="#" onclick="return _asr.tabsheet('<?php echo $funcid;?>', '<?php echo "$funcid"; ?>-Search', 'cunchuka');" <?php if($search['_tab'] == 'cunchuka'): ?> class="current"<?php endif;?>>存储卡</a>
                      <a href="#" onclick="return _asr.tabsheet('<?php echo $funcid;?>', '<?php echo "$funcid"; ?>-Search', 'cunchukamadan');" <?php if($search['_tab'] == 'cunchukamadan'): ?> class="current"<?php endif;?>>存储卡码单</a>
                      <a href="#" onclick="return _asr.tabsheet('<?php echo $funcid;?>', '<?php echo "$funcid"; ?>-Search', 'cunchukaduohao');" <?php if($search['_tab'] == 'cunchukaduohao'): ?> class="current"<?php endif;?>>存储卡垛号</a>
                      <a href="#" onclick="return _asr.tabsheet('<?php echo $funcid;?>', '<?php echo "$funcid"; ?>-Search', 'cunchukataizhang');" <?php if($search['_tab'] == 'cunchukataizhang'): ?> class="current"<?php endif;?>>存储卡台账</a>
                      <a href="#" onclick="return _asr.tabsheet('<?php echo $funcid;?>', '<?php echo "$funcid"; ?>-Search', 'cunchukajiasuo');" <?php if($search['_tab'] == 'cunchukajiasuo'): ?> class="current"<?php endif;?>>存储卡加锁</a>
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



              <?php if ($search['_tab']=='kucunxinxi'): ?>
                <div class="table-box">
                  <div class="table-in">
                    <form id="<?php echo "$funcid"; ?>-Result"  action="<?php U('Warehouse/op'); ?>" method="post">
                      <input type="hidden" name="<?php echo "$funcid"; ?>-last-url" id="<?php echo "$funcid"; ?>-last-url" value="<?php echo $__last_url; ?>" />
                      <input type="hidden" name="funcid" value="<?php echo "$funcid"; ?>" />
                      <input type="hidden" name="pfuncid" value="<?php echo "$pfuncid"; ?>" />
                      <input type="hidden" name="id" value="<?php echo $search["id"]; ?>" />
                      <input type="hidden" name="_lastchanged" value="<?php echo $search["lastchanged"]; ?>" />
                      <table border="0" cellspacing="0" cellpadding="0" class="pub-table-par pub-table-par-tdc pub-t-faq">
                        <colgroup>
                          <col style="width: 40px ;"> <!--  -->
                          <col style="width: 80px ;"> <!-- 仓库编码 -->
                          <col style="width: 80px ;"> <!-- 款式编码 -->
                          <col style="width: 80px ;"> <!-- 重量(kg) -->
                          <col style="width: 80px ;"> <!-- 数量(件) -->
                          <col style="width: 80px ;"> <!-- 散件 -->
                          <col style="width: 80px ;"> <!-- 锁重量(kg) -->
                          <col style="width: 80px ;"> <!-- 锁数量(件) -->
                          <col style="width: 80px ;"> <!-- 锁散件 -->
                          <col style="width: 150px ;"> <!-- 创建时间 -->
                          <col style="width: 150px ;"> <!-- 修改时间 -->
                          <col style="width: auto" >
                        </colgroup>
                        <tbody>
                          <tr>
                            <th><input type="checkbox"  onclick="_asr.selectAll(this);"> &nbsp;#</th>
                            <th class="abe-txtl">仓库编码</th>
                            <th class="abe-txtl">款式编码</th>
                            <th class="abe-txtr">重量(kg)</th>
                            <th class="abe-txtr">数量(件)</th>
                            <th class="abe-txtr">散件</th>
                            <th class="abe-txtr">锁重量(kg)</th>
                            <th class="abe-txtr">锁数量(件)</th>
                            <th class="abe-txtr">锁散件</th>
                            <th>创建时间</th>
                            <th>修改时间</th>
                           <th></th >
                          </tr>
                          <?php if(is_array($list)): $i = 0; $__LIST__ = $list; if( count($__LIST__) == 0) : echo ""; else: foreach($__LIST__ as $key=>$master): $mod = ($i % 2 );++$i; ?>
                                  <tr <?php if($mod == "1"): ?>class="even"<?php endif; if($mod == "0"): ?>class="odd"<?php endif; ?>>
                                    <!-- 选择 -->
                                    <td><input type="checkbox" name="Key[]" data-type="select" onclick="_asr.selectMulit(this);" value="<?php echo $master['id'] ;?>">&nbsp; <?php echo $i + ($page_size * ($p - 1)); ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["warehouse_code"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["style_code"] ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("F33", $master["weight"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("N3", $master["qty"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("N3", $master["bulkcargo"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("F33", $master["lock_weight"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("N3", $master["lock_qty"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("N3", $master["lock_bulkcargo"],1) ; ?></td>
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

              <?php if ($search['_tab']=='cunchuka'): ?>
                <div class="table-box">
                  <div class="table-in">
                    <form id="<?php echo "$funcid"; ?>-Result"  action="<?php U('Warehouse/op'); ?>" method="post">
                      <input type="hidden" name="<?php echo "$funcid"; ?>-last-url" id="<?php echo "$funcid"; ?>-last-url" value="<?php echo $__last_url; ?>" />
                      <input type="hidden" name="funcid" value="<?php echo "$funcid"; ?>" />
                      <input type="hidden" name="pfuncid" value="<?php echo "$pfuncid"; ?>" />
                      <input type="hidden" name="id" value="<?php echo $search["id"]; ?>" />
                      <input type="hidden" name="_lastchanged" value="<?php echo $search["lastchanged"]; ?>" />
                      <table border="0" cellspacing="0" cellpadding="0" class="pub-table-par pub-table-par-tdc pub-t-faq">
                        <colgroup>
                          <col style="width: 40px ;"> <!-- 序号 -->
                          <col style="width: 80px ;"> <!-- 状态 -->
                          <col style="width: 80px ;"> <!-- 存储卡号 -->
                          <col style="width: 80px ;"> <!-- 仓库编码 -->
                          <col style="width: 100px ;"> <!-- 客户名称 -->
                          <col style="width: 80px ;"> <!-- 货品编码 -->
                          <col style="width: 100px ;"> <!-- 货品名称 -->
                          <col style="width: 100px ;"> <!-- 规格材质 -->
                          <col style="width: 80px ;"> <!-- 注册商标 -->
                          <col style="width: 80px ;"> <!-- 货品产地 -->
                          <col style="width: 80px ;"> <!-- 规格编码 -->
                          <col style="width: 80px ;"> <!-- 重量(kg) -->
                          <col style="width: 80px ;"> <!-- 数量(件) -->
                          <col style="width: 80px ;"> <!-- 散件 -->
                          <col style="width: 80px ;"> <!-- 锁重量(kg) -->
                          <col style="width: 80px ;"> <!-- 锁数量(件) -->
                          <col style="width: 80px ;"> <!-- 锁散件 -->
                          <col style="width: 80px ;"> <!-- 数量单位 -->
                          <col style="width: 80px ;"> <!-- 重量单位 -->
                          <col style="width: 80px ;"> <!-- 散件单位 -->
                          <col style="width: 80px ;"> <!-- 仓储合同 -->
                          <col style="width: 150px ;"> <!-- 创建时间 -->
                          <col style="width: 150px ;"> <!-- 修改时间 -->
                          <col style="width: auto" >
                        </colgroup>
                        <tbody>
                          <tr>
                            <th>序号</th>
                            <th>状态</th>
                            <th class="abe-txtl">存储卡号</th>
                            <th class="abe-txtl">仓库编码</th>
                            <th class="abe-txtl">客户名称</th>
                            <th class="abe-txtl">货品编码</th>
                            <th class="abe-txtl">货品名称</th>
                            <th class="abe-txtl">规格材质</th>
                            <th class="abe-txtl">注册商标</th>
                            <th class="abe-txtl">货品产地</th>
                            <th class="abe-txtl">规格编码</th>
                            <th class="abe-txtr">重量(kg)</th>
                            <th class="abe-txtr">数量(件)</th>
                            <th class="abe-txtr">散件</th>
                            <th class="abe-txtr">锁重量(kg)</th>
                            <th class="abe-txtr">锁数量(件)</th>
                            <th class="abe-txtr">锁散件</th>
                            <th>数量单位</th>
                            <th>重量单位</th>
                            <th>散件单位</th>
                            <th>仓储合同</th>
                            <th>创建时间</th>
                            <th>修改时间</th>
                           <th></th >
                          </tr>
                          <?php if(is_array($list)): $i = 0; $__LIST__ = $list; if( count($__LIST__) == 0) : echo ""; else: foreach($__LIST__ as $key=>$master): $mod = ($i % 2 );++$i; ?>
                                  <tr <?php if($mod == "1"): ?>class="even"<?php endif; if($mod == "0"): ?>class="odd"<?php endif; ?>>
                                    <td><?php echo $i + ($page_size * ($p - 1)); ?></td>
                                    <td><?php echo $master["status"] ; ?></td>
                                    <td  class=" abe-txtl "><a href="javascript:void(0);" class="vi-blue"  onclick="return _asr.openLink('<?php echo U("/Home/Storecard/index?func=view&id=$master[id]"); ?>','<?php echo filterFuncId( U("/Home/Storecard/index?func=view&id=$master[id]") ,"");?>', '存储卡详情' ,0); " ><?php echo $master["storecard_no"] ; ?></a></td>
                                    <td  class=" abe-txtl "><?php echo $master["warehouse_code"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["customer_name"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["goods_no"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["goods_name"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["style_info"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["brand"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["producing_area"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["style_code"] ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("F33", $master["weight"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("N3", $master["qty"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("N3", $master["bulkcargo"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("F33", $master["lock_weight"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("N3", $master["lock_qty"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("N3", $master["lock_bulkcargo"],1) ; ?></td>
                                    <td><?php echo $master["uom_qty"] ; ?></td>
                                    <td><?php echo $master["uom_weight"] ; ?></td>
                                    <td><?php echo $master["uom_bulkcargo"] ; ?></td>
                                    <td><?php echo $master["contact_no"] ; ?></td>
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

              <?php if ($search['_tab']=='cunchukamadan'): ?>
                <div class="table-box">
                  <div class="table-in">
                    <form id="<?php echo "$funcid"; ?>-Result"  action="<?php U('Warehouse/op'); ?>" method="post">
                      <input type="hidden" name="<?php echo "$funcid"; ?>-last-url" id="<?php echo "$funcid"; ?>-last-url" value="<?php echo $__last_url; ?>" />
                      <input type="hidden" name="funcid" value="<?php echo "$funcid"; ?>" />
                      <input type="hidden" name="pfuncid" value="<?php echo "$pfuncid"; ?>" />
                      <input type="hidden" name="id" value="<?php echo $search["id"]; ?>" />
                      <input type="hidden" name="_lastchanged" value="<?php echo $search["lastchanged"]; ?>" />
                      <table border="0" cellspacing="0" cellpadding="0" class="pub-table-par pub-table-par-tdc pub-t-faq">
                        <colgroup>
                          <col style="width: 40px ;"> <!-- 序号 -->
                          <col style="width: 80px ;"> <!-- 状态 -->
                          <col style="width: 80px ;"> <!-- 存储卡号 -->
                          <col style="width: 80px ;"> <!-- 码单号 -->
                          <col style="width: 100px ;"> <!-- 客户名称 -->
                          <col style="width: 80px ;"> <!-- 来源码单 -->
                          <col style="width: 80px ;"> <!-- 原始码单 -->
                          <col style="width: 80px ;"> <!-- 仓库编码 -->
                          <col style="width: 80px ;"> <!-- 仓库仓位 -->
                          <col style="width: 80px ;"> <!-- 期货仓位 -->
                          <col style="width: 80px ;"> <!-- 入库日期 -->
                          <col style="width: 80px ;"> <!-- 入库单号 -->
                          <col style="width: 80px ;"> <!-- 到货方式 -->
                          <col style="width: 80px ;"> <!-- 存储方式 -->
                          <col style="width: 80px ;"> <!-- 车厢号 -->
                          <col style="width: 100px ;"> <!-- 重量(入)(kg) -->
                          <col style="width: 100px ;"> <!-- 数量(入)(件) -->
                          <col style="width: 80px ;"> <!-- 散件(入) -->
                          <col style="width: 100px ;"> <!-- 重量(出)(kg) -->
                          <col style="width: 100px ;"> <!-- 数量(出)(件) -->
                          <col style="width: 80px ;"> <!-- 散件(出) -->
                          <col style="width: 80px ;"> <!-- 重量(kg) -->
                          <col style="width: 80px ;"> <!-- 数量(件) -->
                          <col style="width: 80px ;"> <!-- 散件 -->
                          <col style="width: 150px ;"> <!-- 创建时间 -->
                          <col style="width: 150px ;"> <!-- 修改时间 -->
                          <col style="width: 80px ;"> <!-- 锁住 -->
                          <col style="width: 150px ;"> <!-- 锁住时间 -->
                          <col style="width: auto" >
                        </colgroup>
                        <tbody>
                          <tr>
                            <th>序号</th>
                            <th>状态</th>
                            <th class="abe-txtl">存储卡号</th>
                            <th class="abe-txtl">码单号</th>
                            <th class="abe-txtl">客户名称</th>
                            <th class="abe-txtl">来源码单</th>
                            <th class="abe-txtl">原始码单</th>
                            <th class="abe-txtl">仓库编码</th>
                            <th class="abe-txtl">仓库仓位</th>
                            <th>期货仓位</th>
                            <th>入库日期</th>
                            <th class="abe-txtl">入库单号</th>
                            <th>到货方式</th>
                            <th>存储方式</th>
                            <th class="abe-txtl">车厢号</th>
                            <th class="abe-txtr">重量(入)(kg)</th>
                            <th class="abe-txtr">数量(入)(件)</th>
                            <th class="abe-txtr">散件(入)</th>
                            <th class="abe-txtr">重量(出)(kg)</th>
                            <th class="abe-txtr">数量(出)(件)</th>
                            <th class="abe-txtr">散件(出)</th>
                            <th class="abe-txtr">重量(kg)</th>
                            <th class="abe-txtr">数量(件)</th>
                            <th class="abe-txtr">散件</th>
                            <th>创建时间</th>
                            <th>修改时间</th>
                            <th>锁住</th>
                            <th>锁住时间</th>
                           <th></th >
                          </tr>
                          <?php if(is_array($list)): $i = 0; $__LIST__ = $list; if( count($__LIST__) == 0) : echo ""; else: foreach($__LIST__ as $key=>$master): $mod = ($i % 2 );++$i; ?>
                                  <tr <?php if($mod == "1"): ?>class="even"<?php endif; if($mod == "0"): ?>class="odd"<?php endif; ?>>
                                    <td><?php echo $i + ($page_size * ($p - 1)); ?></td>
                                    <td><?php echo get_table_StorecardPackage_status("$master[status]","name","") ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["storecard_no"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["package_no"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["customer_name"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["package_from"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["package_orig"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["warehouse_code"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["location_code"] ; ?></td>
                                    <td><?php echo $master["location_futures"] ; ?></td>
                                    <td><?php echo system_format("D", $master["stock_date"],1) ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["stock_order"] ; ?></td>
                                    <td><?php echo subcode_view('packlist:arrival_type',$search['arrival_type']) ; ?></td>
                                    <td><?php echo subcode_view('packlist:stock_type',$search['stock_type']) ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["carno"] ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("F33", $master["weight_in"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("N3", $master["qty_in"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("N3", $master["bulkcargo_in"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("F33", $master["weight_out"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("N3", $master["qty_out"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("N3", $master["bulkcargo_out"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("F33", $master["weight"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("N3", $master["qty"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("N3", $master["bulkcargo"],1) ; ?></td>
                                    <td><?php echo system_format("DT", $master["create_time"],1) ; ?></td>
                                    <td><?php echo system_format("DT", $master["modify_time"],1) ; ?></td>
                                    <td><?php echo get_table_StorecardPackage_is_lock("$master[is_lock]","name","") ; ?></td>
                                    <td><?php echo system_format("DT", $master["lock_time"],1) ; ?></td>
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

              <?php if ($search['_tab']=='cunchukaduohao'): ?>
                <div class="table-box">
                  <div class="table-in">
                    <form id="<?php echo "$funcid"; ?>-Result"  action="<?php U('Warehouse/op'); ?>" method="post">
                      <input type="hidden" name="<?php echo "$funcid"; ?>-last-url" id="<?php echo "$funcid"; ?>-last-url" value="<?php echo $__last_url; ?>" />
                      <input type="hidden" name="funcid" value="<?php echo "$funcid"; ?>" />
                      <input type="hidden" name="pfuncid" value="<?php echo "$pfuncid"; ?>" />
                      <input type="hidden" name="id" value="<?php echo $search["id"]; ?>" />
                      <input type="hidden" name="_lastchanged" value="<?php echo $search["lastchanged"]; ?>" />
                      <table border="0" cellspacing="0" cellpadding="0" class="pub-table-par pub-table-par-tdc pub-t-faq">
                        <colgroup>
                          <col style="width: 40px ;"> <!-- 序号 -->
                          <col style="width: 80px ;"> <!-- 码单号 -->
                          <col style="width: 80px ;"> <!-- 垛号 -->
                          <col style="width: 80px ;"> <!-- 货品批号 -->
                          <col style="width: 80px ;"> <!-- 仓库编码 -->
                          <col style="width: 80px ;"> <!-- 仓库仓位 -->
                          <col style="width: 100px ;"> <!-- 重量(入)(kg) -->
                          <col style="width: 100px ;"> <!-- 数量(入)(件) -->
                          <col style="width: 80px ;"> <!-- 散件(入) -->
                          <col style="width: 100px ;"> <!-- 重量(出)(kg) -->
                          <col style="width: 100px ;"> <!-- 数量(出)(件) -->
                          <col style="width: 80px ;"> <!-- 散件(出) -->
                          <col style="width: 80px ;"> <!-- 重量(kg) -->
                          <col style="width: 80px ;"> <!-- 数量(件) -->
                          <col style="width: 80px ;"> <!-- 散件 -->
                          <col style="width: 80px ;"> <!-- 锁住 -->
                          <col style="width: 150px ;"> <!-- 锁住时间 -->
                          <col style="width: auto" >
                        </colgroup>
                        <tbody>
                          <tr>
                            <th>序号</th>
                            <th class="abe-txtl">码单号</th>
                            <th>垛号</th>
                            <th class="abe-txtl">货品批号</th>
                            <th class="abe-txtl">仓库编码</th>
                            <th class="abe-txtl">仓库仓位</th>
                            <th class="abe-txtr">重量(入)(kg)</th>
                            <th class="abe-txtr">数量(入)(件)</th>
                            <th class="abe-txtr">散件(入)</th>
                            <th class="abe-txtr">重量(出)(kg)</th>
                            <th class="abe-txtr">数量(出)(件)</th>
                            <th class="abe-txtr">散件(出)</th>
                            <th class="abe-txtr">重量(kg)</th>
                            <th class="abe-txtr">数量(件)</th>
                            <th class="abe-txtr">散件</th>
                            <th>锁住</th>
                            <th>锁住时间</th>
                           <th></th >
                          </tr>
                          <?php if(is_array($list)): $i = 0; $__LIST__ = $list; if( count($__LIST__) == 0) : echo ""; else: foreach($__LIST__ as $key=>$master): $mod = ($i % 2 );++$i; ?>
                                  <tr <?php if($mod == "1"): ?>class="even"<?php endif; if($mod == "0"): ?>class="odd"<?php endif; ?>>
                                    <td><?php echo $i + ($page_size * ($p - 1)); ?></td>
                                    <td  class=" abe-txtl "><a href="javascript:void(0);" class="vi-blue"  onclick="return _asr.openLink('<?php echo U("/Home/StorecardPackage/index?func=view&no=$master[package_no]"); ?>','<?php echo filterFuncId( U("/Home/StorecardPackage/index?func=view&no=$master[package_no]") ,"");?>', 'package_id详情' ,0); " ><?php echo $master["package_no"] ; ?></a></td>
                                    <td><?php echo $master["buttress_no"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["batchno"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["warehouse_code"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["location_code"] ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("F33", $master["weight_in"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("N3", $master["qty_in"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("N3", $master["bulkcargo_in"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("F33", $master["weight_out"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("N3", $master["qty_out"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("N3", $master["bulkcargo_out"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("F33", $master["weight"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("N3", $master["qty"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("N3", $master["bulkcargo"],1) ; ?></td>
                                    <td><?php echo get_table_StorecardButtress_is_lock("$master[is_lock]","name","") ; ?></td>
                                    <td><?php echo system_format("DT", $master["lock_time"],1) ; ?></td>
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

              <?php if ($search['_tab']=='cunchukataizhang'): ?>
                <div class="table-box">
                  <div class="table-in">
                    <form id="<?php echo "$funcid"; ?>-Result"  action="<?php U('Warehouse/op'); ?>" method="post">
                      <input type="hidden" name="<?php echo "$funcid"; ?>-last-url" id="<?php echo "$funcid"; ?>-last-url" value="<?php echo $__last_url; ?>" />
                      <input type="hidden" name="funcid" value="<?php echo "$funcid"; ?>" />
                      <input type="hidden" name="pfuncid" value="<?php echo "$pfuncid"; ?>" />
                      <input type="hidden" name="id" value="<?php echo $search["id"]; ?>" />
                      <input type="hidden" name="_lastchanged" value="<?php echo $search["lastchanged"]; ?>" />
                      <table border="0" cellspacing="0" cellpadding="0" class="pub-table-par pub-table-par-tdc pub-t-faq">
                        <colgroup>
                          <col style="width: 40px ;"> <!-- 序号 -->
                          <col style="width: 100px ;"> <!-- 客户名称 -->
                          <col style="width: 80px ;"> <!-- 存储卡号 -->
                          <col style="width: 80px ;"> <!-- 仓库编码 -->
                          <col style="width: 80px ;"> <!-- 单据号码 -->
                          <col style="width: 80px ;"> <!-- 单据类型 -->
                          <col style="width: 80px ;"> <!-- 单据日期 -->
                          <col style="width: 80px ;"> <!-- 货品编码 -->
                          <col style="width: 100px ;"> <!-- 货品名称 -->
                          <col style="width: 100px ;"> <!-- 规格材质 -->
                          <col style="width: 80px ;"> <!-- 注册商标 -->
                          <col style="width: 80px ;"> <!-- 货品产地 -->
                          <col style="width: 80px ;"> <!-- 货品批号 -->
                          <col style="width: 80px ;"> <!-- 规格编码 -->
                          <col style="width: 100px ;"> <!-- 接收方 -->
                          <col style="width: 80px ;"> <!-- 重量(kg) -->
                          <col style="width: 80px ;"> <!-- 数量(件) -->
                          <col style="width: 80px ;"> <!-- 散件 -->
                          <col style="width: 100px ;"> <!-- 库存重量(kg) -->
                          <col style="width: 100px ;"> <!-- 库存数量(件) -->
                          <col style="width: 80px ;"> <!-- 库存散件 -->
                          <col style="width: 120px ;"> <!-- 合计锁重量(kg) -->
                          <col style="width: 120px ;"> <!-- 合计锁数量(件) -->
                          <col style="width: 80px ;"> <!-- 合计锁散件 -->
                          <col style="width: 150px ;"> <!-- 创建时间 -->
                          <col style="width: auto" >
                        </colgroup>
                        <tbody>
                          <tr>
                            <th>序号</th>
                            <th class="abe-txtl">客户名称</th>
                            <th class="abe-txtl">存储卡号</th>
                            <th class="abe-txtl">仓库编码</th>
                            <th class="abe-txtl">单据号码</th>
                            <th>单据类型</th>
                            <th>单据日期</th>
                            <th class="abe-txtl">货品编码</th>
                            <th class="abe-txtl">货品名称</th>
                            <th class="abe-txtl">规格材质</th>
                            <th class="abe-txtl">注册商标</th>
                            <th class="abe-txtl">货品产地</th>
                            <th class="abe-txtl">货品批号</th>
                            <th class="abe-txtl">规格编码</th>
                            <th class="abe-txtl">接收方</th>
                            <th class="abe-txtr">重量(kg)</th>
                            <th class="abe-txtr">数量(件)</th>
                            <th class="abe-txtr">散件</th>
                            <th class="abe-txtr">库存重量(kg)</th>
                            <th class="abe-txtr">库存数量(件)</th>
                            <th class="abe-txtr">库存散件</th>
                            <th class="abe-txtr">合计锁重量(kg)</th>
                            <th class="abe-txtr">合计锁数量(件)</th>
                            <th class="abe-txtr">合计锁散件</th>
                            <th>创建时间</th>
                           <th></th >
                          </tr>
                          <?php if(is_array($list)): $i = 0; $__LIST__ = $list; if( count($__LIST__) == 0) : echo ""; else: foreach($__LIST__ as $key=>$master): $mod = ($i % 2 );++$i; ?>
                                  <tr <?php if($mod == "1"): ?>class="even"<?php endif; if($mod == "0"): ?>class="odd"<?php endif; ?>>
                                    <td><?php echo $i + ($page_size * ($p - 1)); ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["customer_name"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["storecard_no"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["warehouse_code"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["order_no"] ; ?></td>
                                    <td><?php echo $master["order_type"] ; ?></td>
                                    <td><?php echo system_format("D", $master["order_date"],1) ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["goods_no"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["goods_name"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["style_info"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["brand"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["producing_area"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["batchno"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["style_code"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["to_customer_name"] ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("F33", $master["weight"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("N3", $master["qty"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("N3", $master["bulkcargo"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("F33", $master["store_weight"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("N3", $master["store_qty"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("N3", $master["store_bulkcargo"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("F33", $master["storelock_weight"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("N3", $master["storelock_qty"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("N3", $master["storelock_bulkcargo"],1) ; ?></td>
                                    <td><?php echo system_format("DT", $master["create_time"],1) ; ?></td>
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

              <?php if ($search['_tab']=='cunchukajiasuo'): ?>
                <div class="table-box">
                  <div class="table-in">
                    <form id="<?php echo "$funcid"; ?>-Result"  action="<?php U('Warehouse/op'); ?>" method="post">
                      <input type="hidden" name="<?php echo "$funcid"; ?>-last-url" id="<?php echo "$funcid"; ?>-last-url" value="<?php echo $__last_url; ?>" />
                      <input type="hidden" name="funcid" value="<?php echo "$funcid"; ?>" />
                      <input type="hidden" name="pfuncid" value="<?php echo "$pfuncid"; ?>" />
                      <input type="hidden" name="id" value="<?php echo $search["id"]; ?>" />
                      <input type="hidden" name="_lastchanged" value="<?php echo $search["lastchanged"]; ?>" />
                      <table border="0" cellspacing="0" cellpadding="0" class="pub-table-par pub-table-par-tdc pub-t-faq">
                        <colgroup>
                          <col style="width: 40px ;"> <!-- 序号 -->
                          <col style="width: 100px ;"> <!-- 客户名称 -->
                          <col style="width: 80px ;"> <!-- 仓库编码 -->
                          <col style="width: 80px ;"> <!-- 加锁号码 -->
                          <col style="width: 80px ;"> <!-- 加锁类型 -->
                          <col style="width: 80px ;"> <!-- 加锁日期 -->
                          <col style="width: 100px ;"> <!-- 接收方 -->
                          <col style="width: 80px ;"> <!-- 锁重量(kg) -->
                          <col style="width: 80px ;"> <!-- 锁数量(件) -->
                          <col style="width: 80px ;"> <!-- 锁散件 -->
                          <col style="width: 120px ;"> <!-- 合计锁重量(kg) -->
                          <col style="width: 120px ;"> <!-- 合计锁数量(件) -->
                          <col style="width: 80px ;"> <!-- 合计锁散件 -->
                          <col style="width: 100px ;"> <!-- 库存重量(kg) -->
                          <col style="width: 100px ;"> <!-- 库存数量(件) -->
                          <col style="width: 80px ;"> <!-- 库存散件 -->
                          <col style="width: 80px ;"> <!-- 释放人员 -->
                          <col style="width: 150px ;"> <!-- 释放时间 -->
                          <col style="width: 150px ;"> <!-- 创建时间 -->
                          <col style="width: auto" >
                        </colgroup>
                        <tbody>
                          <tr>
                            <th>序号</th>
                            <th class="abe-txtl">客户名称</th>
                            <th class="abe-txtl">仓库编码</th>
                            <th class="abe-txtl">加锁号码</th>
                            <th>加锁类型</th>
                            <th>加锁日期</th>
                            <th class="abe-txtl">接收方</th>
                            <th class="abe-txtr">锁重量(kg)</th>
                            <th class="abe-txtr">锁数量(件)</th>
                            <th class="abe-txtr">锁散件</th>
                            <th class="abe-txtr">合计锁重量(kg)</th>
                            <th class="abe-txtr">合计锁数量(件)</th>
                            <th class="abe-txtr">合计锁散件</th>
                            <th class="abe-txtr">库存重量(kg)</th>
                            <th class="abe-txtr">库存数量(件)</th>
                            <th class="abe-txtr">库存散件</th>
                            <th>释放人员</th>
                            <th>释放时间</th>
                            <th>创建时间</th>
                           <th></th >
                          </tr>
                          <?php if(is_array($list)): $i = 0; $__LIST__ = $list; if( count($__LIST__) == 0) : echo ""; else: foreach($__LIST__ as $key=>$master): $mod = ($i % 2 );++$i; ?>
                                  <tr <?php if($mod == "1"): ?>class="even"<?php endif; if($mod == "0"): ?>class="odd"<?php endif; ?>>
                                    <td><?php echo $i + ($page_size * ($p - 1)); ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["customer_name"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["warehouse_code"] ; ?></td>
                                    <td  class=" abe-txtl "><a href="javascript:void(0);" class="vi-blue"  onclick="return _asr.openLink('<?php echo orderurl("$master[order_no]"); ?>','<?php echo filterFuncId( orderurl("$master[order_no]") ,"");?>', '查看详情' ,0); " ><?php echo $master["order_no"] ; ?></a></td>
                                    <td><?php echo $master["order_type"] ; ?></td>
                                    <td><?php echo system_format("D", $master["order_date"],1) ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["to_customer_name"] ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("F33", $master["lock_weight"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("N3", $master["lock_qty"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("N3", $master["lock_bulkcargo"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("F33", $master["storelock_weight"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("N3", $master["storelock_qty"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("N3", $master["storelock_bulkcargo"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("F33", $master["store_weight"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("N3", $master["store_qty"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("N3", $master["store_bulkcargo"],1) ; ?></td>
                                    <td><?php echo $master["release_user"] ; ?></td>
                                    <td><?php echo system_format("DT", $master["release_time"],1) ; ?></td>
                                    <td><?php echo system_format("DT", $master["create_time"],1) ; ?></td>
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
                    <form id="<?php echo "$funcid"; ?>-Result"  action="<?php U('Warehouse/op'); ?>" method="post">
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
                                    <td><?php echo get_table_Warehouse_status("$master[status]","name","") ; ?></td>
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
               <input type="button" value="信息编辑" class="btn btn-blue mlg_10 " default-status="1" onclick="return _asr.popupFun('<?php echo U("/Home/Warehouse/index?func=edit_base&id=$search[id]") ; ?>', '<?php echo filterFuncId("/Home/Warehouse/index?func=edit_base&id=$search[id]","");?>'); " />
          <?php endif; ?>
          <?php endif; ?>



          <?php if (isset($rights['status_on']) && $rights['status_on']): ?>
          <?php if ($search['status']=='0'): ?>
               <input type="button" value="转有效" class="btn btn-blue mlg_10 " default-status="1" onclick="return _asr.popupFun('<?php echo U("/Home/Warehouse/index?func=status_on&id=$search[id]") ; ?>', '<?php echo filterFuncId("/Home/Warehouse/index?func=status_on&id=$search[id]","");?>'); " />
          <?php endif; ?>
          <?php endif; ?>



          <?php if (isset($rights['status_off']) && $rights['status_off']): ?>
          <?php if ($search['status']=='1'): ?>
               <input type="button" value="转无效" class="btn btn-org mlg_10 " default-status="1" onclick="return _asr.popupFun('<?php echo U("/Home/Warehouse/index?func=status_off&id=$search[id]") ; ?>', '<?php echo filterFuncId("/Home/Warehouse/index?func=status_off&id=$search[id]","");?>'); " />
          <?php endif; ?>
          <?php endif; ?>

          <div class="abe-fr">


          <?php if (isset($rights['order_delete']) && $rights['order_delete']): ?>
          <?php if ($search['status']==0): ?>
               <input type="button" value="记录删除" class="btn btn-org mrg_10 " default-status="1" onclick="return _asr.confirm('确认操作', '请确认是否进行 信息删除 操作?', '', '<?php echo U("/Home/Warehouse/index?func=delete&id=$search[id]") ; ?>','','<?php echo "$funcid"; ?>-Result'); " />
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


    <?php echo W('Summary/javascript',array('Warehouse'));?>


    </script>