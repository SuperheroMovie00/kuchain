<?php if (!defined('THINK_PATH')) exit();?>
<div toplayer="1" class="wrap-box wrap-pb2 " id="<?php echo $funcid;?>" summaryid="Goods" baseurl="<?php echo U('Goods/index'); ?>">

   <div class="wrap-box-info ">
      <div class="wrap-title abe-ofl">
         <div class="tit abe-fl">货品资料</div>
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
               <a href="javascript:void(0);"  class=" vi-blue vi-blue mlg_10 " onclick="return _asr.popupFun('<?php echo U("/Home/Goods/index?func=edit_base&id=$search[id]") ; ?>', '<?php echo filterFuncId("/Home/Goods/index?func=edit_base&id=$search[id]","");?>'); "> 编辑</a>
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
           <col style="width:17%;"/>
        </colgroup>
        <tbody>

           <tr class= "even">
             <th>库链名称</th>
             <td><?php echo $search["org_id_name"]; ?></td>
             <th>货品编码</th>
             <td><?php echo $search["goods_no"]; ?></td>
             <th>客户货品</th>
             <td><?php echo $search["org_goods_no"]; ?></td>
             <th>货品名称</th>
             <td><?php echo $search["name"]; ?></td>
           </tr>
           <tr class= "odd">
             <th>助记码</th>
             <td><?php echo $search["prefix"]; ?></td>
             <th>规格</th>
             <td><?php echo $search["style_info"]; ?></td>
             <th>材质</th>
             <td><?php echo $search["materials"]; ?></td>
             <th>货品条码</th>
             <td><?php echo $search["barcode"]; ?></td>
            <!-- <th>注册商标</th>
             <td><?php echo $search["brand"]; ?></td>-->
           </tr>
           <tr class= "even">
             <th>货品产地</th>
             <td><?php echo $search["producing_area"]; ?></td>
             <th>规格编码</th>
             <td><?php echo $search["style_code"]; ?></td>
             <th>货品分类</th>
             <td><?php echo $search["category_code"]; ?></td>
             <th>数量单位</th>
             <td><?php echo $search["uom_qty"]; ?></td>
           </tr>
           <tr class= "odd">
             <th>重量单位</th>
             <td><?php echo $search["uom_weight"]; ?></td>
             <th>散件单位</th>
             <td><?php echo $search["uom_bulkcargo"]; ?></td>
             <th>活跃等级</th>
             <td><?php echo $search["active"]; ?></td>
               <th>状态</th>
               <td><?php echo get_table_Goods_status("$search[status]","name","") ; ?></td>
            <!-- <th>所属年份</th>
             <td><?php echo $search["year_code"]; ?></td>-->
           </tr>
           <!--<tr class= "even">
             <th>货品条码</th>
               <td><?php echo $search["barcode"]; ?></td>-->
            <!-- <th>国标编码</th>
             <td><?php echo $search["gb_code"]; ?></td>-->
            <!-- <th>是否实物</th>
             <td><?php echo $search["is_real"]; ?></td>-->
             <!--<th>状态</th>
             <td><?php echo get_table_Goods_status("$search[status]","name","") ; ?></td>
             </tr>-->
           <tr class= "even">
             <th>平台同步</th>
             <td><?php echo get_table_Goods_is_sync("$search[is_sync]","name","") ; ?></td>
             <th>同步时间</th>
             <td><?php echo system_format("DT", $search["sync_time"],1); ?><em class="abe-space-sm"></em><?php echo $search["sync_time"]; ?></td>
             <th>创建时间</th>
             <td><?php echo system_format("DT", $search["create_time"],1); ?><em class="abe-space-sm"></em><?php echo $search["create_user"]; ?></td>
             <th>修改时间</th>
             <td><?php echo system_format("DT", $search["modify_time"],1); ?><em class="abe-space-sm"></em><?php echo $search["modify_user"]; ?></td>
           </tr>

        </tbody>
     </table>
         </div>
      </div>





       <div class="table-box">
         <div class="table-in">
            <form action="<?php echo U('Goods/index?func=view'); ?>" id="<?php echo "$funcid"; ?>-Search" method="get">
                <input type="hidden" name="<?php echo "$funcid"; ?>-last-url" id="<?php echo "$funcid"; ?>-last-url" value="<?php echo $__last_url; ?>" />
                <input type="hidden" name="funcid" value="<?php echo "$funcid"; ?>" />
                <input type="hidden" name="pfuncid" value="<?php echo "$pfuncid"; ?>" />
                <input type="hidden" name="id" value="<?php echo $search["id"]; ?>" />
                <input type="hidden" name="_lastchanged" value="<?php echo $search["lastchanged"]; ?>" />


                <input type="hidden" name="_tab" value="<?php echo $search["_tab"]; ?>" />

                <input type="hidden" name="_tab_huopinbieming_p" value="<?php echo $search["_tab_huopinbieming_p"]; ?>" />
                <input type="hidden" name="_tab_kucunxinxi_psize" value="<?php echo $search["_tab_kucunxinxi_psize"]; ?>" />
                <input type="hidden" name="_tab_cunchuka_p" value="<?php echo $search["_tab_cunchuka_p"]; ?>" />
                <input type="hidden" name="_tab_cunchuka_psize" value="<?php echo $search["_tab_cunchuka_psize"]; ?>" />
                <input type="hidden" name="_tab_jiaoyikaidan_p" value="<?php echo $search["_tab_jiaoyikaidan_p"]; ?>" />
                <input type="hidden" name="_tab_jiaoyikaidan_psize" value="<?php echo $search["_tab_jiaoyikaidan_psize"]; ?>" />
                <input type="hidden" name="_tab_kehuzhangdan_p" value="<?php echo $search["_tab_kehuzhangdan_p"]; ?>" />
                <input type="hidden" name="_tab_kehuzhangdan_psize" value="<?php echo $search["_tab_kehuzhangdan_psize"]; ?>" />
                <input type="hidden" name="_tab_kehucunchuhetong_p" value="<?php echo $search["_tab_kehucunchuhetong_p"]; ?>" />
                <input type="hidden" name="_tab_kehucunchuhetong_psize" value="<?php echo $search["_tab_kehucunchuhetong_psize"]; ?>" />
                <input type="hidden" name="_tab_kehudizhi_p" value="<?php echo $search["_tab_kehudizhi_p"]; ?>" />
                <input type="hidden" name="_tab_kehudizhi_psize" value="<?php echo $search["_tab_kehudizhi_psize"]; ?>" />
                <input type="hidden" name="_tab_yonghuxinxi_p" value="<?php echo $search["_tab_yonghuxinxi_p"]; ?>" />
                <input type="hidden" name="_tab_yonghuxinxi_psize" value="<?php echo $search["_tab_yonghuxinxi_psize"]; ?>" />
                <input type="hidden" name="_tab_caozuorizhi_p" value="<?php echo $search["_tab_caozuorizhi_p"]; ?>" />
                <input type="hidden" name="_tab_caozuorizhi_psize" value="<?php echo $search["_tab_caozuorizhi_psize"]; ?>" />

                  <!--表单-->
                  <div class="order-det-ptab">
                    <div class="od-info abe-fl" >
                      <a href="#" onclick="return _asr.tabsheet('<?php echo $funcid;?>', '<?php echo "$funcid"; ?>-Search', 'huopinbieming');" <?php if($search['_tab'] == 'huopinbieming'): ?> class="current"<?php endif;?>>货品别名</a>
                      <a href="#" onclick="return _asr.tabsheet('<?php echo $funcid;?>', '<?php echo "$funcid"; ?>-Search', 'cunchuka');" <?php if($search['_tab'] == 'cunchuka'): ?> class="current"<?php endif;?>>存储卡</a>
                      <a href="#" onclick="return _asr.tabsheet('<?php echo $funcid;?>', '<?php echo "$funcid"; ?>-Search', 'jiaoyikaidan');" <?php if($search['_tab'] == 'jiaoyikaidan'): ?> class="current"<?php endif;?>>交易开单</a>
                      <a href="#" onclick="return _asr.tabsheet('<?php echo $funcid;?>', '<?php echo "$funcid"; ?>-Search', 'kehuzhangdan');" <?php if($search['_tab'] == 'kehuzhangdan'): ?> class="current"<?php endif;?>>客户账单</a>
                      <a href="#" onclick="return _asr.tabsheet('<?php echo $funcid;?>', '<?php echo "$funcid"; ?>-Search', 'kehucunchuhetong');" <?php if($search['_tab'] == 'kehucunchuhetong'): ?> class="current"<?php endif;?>>客户存储合同</a>
                      <a href="#" onclick="return _asr.tabsheet('<?php echo $funcid;?>', '<?php echo "$funcid"; ?>-Search', 'kehudizhi');" <?php if($search['_tab'] == 'kehudizhi'): ?> class="current"<?php endif;?>>客户地址</a>
                      <a href="#" onclick="return _asr.tabsheet('<?php echo $funcid;?>', '<?php echo "$funcid"; ?>-Search', 'yonghuxinxi');" <?php if($search['_tab'] == 'yonghuxinxi'): ?> class="current"<?php endif;?>>用户信息</a>
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



              <?php if ($search['_tab']=='huopinbieming'): ?>
                <div class="table-box">
                  <div class="table-in">
                    <form id="<?php echo "$funcid"; ?>-Result"  action="<?php U('Goods/op'); ?>" method="post">
                      <input type="hidden" name="<?php echo "$funcid"; ?>-last-url" id="<?php echo "$funcid"; ?>-last-url" value="<?php echo $__last_url; ?>" />
                      <input type="hidden" name="funcid" value="<?php echo "$funcid"; ?>" />
                      <input type="hidden" name="pfuncid" value="<?php echo "$pfuncid"; ?>" />
                      <input type="hidden" name="id" value="<?php echo $search["id"]; ?>" />
                      <input type="hidden" name="_lastchanged" value="<?php echo $search["lastchanged"]; ?>" />
                      <table border="0" cellspacing="0" cellpadding="0" class="pub-table-par pub-table-par-tdc pub-t-faq">
                        <colgroup>
                          <col style="width: 40px ;"> <!--  -->
                          <col style="width: 60px ;"> <!-- 操作 -->
                          <col style="width: 80px ;"> <!-- 库链id -->
                          <col style="width: 80px ;"> <!-- 货品id -->
                          <col style="width: 80px ;"> <!-- 规格 -->
                          <col style="width: 80px ;"> <!-- 材质 -->
                          <col style="width: 80px ;"> <!-- 商标 -->
                          <col style="width: 150px ;"> <!-- 创建时间 -->
                          <col style="width: 150px ;"> <!-- 创建人员 -->
                          <col style="width: auto" >
                        </colgroup>
                        <tbody>
                          <tr>
                            <th><input type="checkbox"  onclick="_asr.selectAll(this);"> &nbsp;#</th>
                            <th>操作</th>
                            <th class="abe-txtr">规格</th>
                            <th class="abe-txtr">材质</th>
                            <th class="abe-txtr">商标</th>
                            <th>创建时间</th>
                            <th>创建人员</th>
                           <th></th >
                          </tr>
                          <?php if(is_array($list)): $i = 0; $__LIST__ = $list; if( count($__LIST__) == 0) : echo ""; else: foreach($__LIST__ as $key=>$master): $mod = ($i % 2 );++$i; ?>
                                  <tr <?php if($mod == "1"): ?>class="even"<?php endif; if($mod == "0"): ?>class="odd"<?php endif; ?>>
                                    <!-- 选择 -->
                                    <td><input type="checkbox" name="Key[]" data-type="select" onclick="_asr.selectMulit(this);" value="<?php echo $master['id'] ;?>">&nbsp; <?php echo $i + ($page_size * ($p - 1)); ?></td>
                                    <td>
                            <div class="faq-icon">

          <?php if (isset($rights['master_view']) && $rights['master_view']): ?>
                <a href="javascript:void(0);"  class=" vi-blue vi-blue " onclick="return _asr.popupFun('<?php echo U("/Home/Goods/index?func=edit_rela&id=$master[id]&act=edit") ; ?>', '<?php echo filterFuncId("/Home/Goods/index?func=edit_rela&id=$master[id]&act=edit","");?>'); "><i class="iconfont abe-ft15">&#xe63f;</i></a>
                <a href="javascript:void(0);"  class=" vi-blue vi-blue " onclick="return _asr.confirm('确认操作', '请确认是否删除货品?', '<?php echo "货品 : $master[goods_no]"; ?>', '<?php echo U("/Home/Goods/index?func=delete_rela&type=1&id=$master[id]") ; ?>','',''); "><i class="iconfont vi-red">&#xe61d;</i></a>
          <?php endif; ?>

                            </div></td>
                                    <td  class=" abe-txtl "><?php echo $master["style_info"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["materials"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["brand"] ; ?></td>
                                    <td><?php echo $master["create_time"] ; ?></td>
                                    <td><?php echo $master["create_user"] ; ?></td>
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
                    <form id="<?php echo "$funcid"; ?>-Result"  action="<?php U('Goods/op'); ?>" method="post">
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

              <?php if ($search['_tab']=='jiaoyikaidan'): ?>
                <div class="table-box">
                  <div class="table-in">
                    <form id="<?php echo "$funcid"; ?>-Result"  action="<?php U('Goods/op'); ?>" method="post">
                      <input type="hidden" name="<?php echo "$funcid"; ?>-last-url" id="<?php echo "$funcid"; ?>-last-url" value="<?php echo $__last_url; ?>" />
                      <input type="hidden" name="funcid" value="<?php echo "$funcid"; ?>" />
                      <input type="hidden" name="pfuncid" value="<?php echo "$pfuncid"; ?>" />
                      <input type="hidden" name="id" value="<?php echo $search["id"]; ?>" />
                      <input type="hidden" name="_lastchanged" value="<?php echo $search["lastchanged"]; ?>" />
                      <table border="0" cellspacing="0" cellpadding="0" class="pub-table-par pub-table-par-tdc pub-t-faq">
                        <colgroup>
                          <col style="width: 40px ;"> <!-- 序号 -->
                          <col style="width: 80px ;"> <!-- 状态 -->
                          <col style="width: 80px ;"> <!-- 仓库编码 -->
                          <col style="width: 100px ;"> <!-- 卖出客户 -->
                          <col style="width: 100px ;"> <!-- 买入客户 -->
                          <col style="width: 80px ;"> <!-- 交易单号 -->
                          <col style="width: 80px ;"> <!-- 交易类型 -->
                          <col style="width: 80px ;"> <!-- 开单日期 -->
                          <col style="width: 150px ;"> <!-- 截至时间 -->
                          <col style="width: 80px ;"> <!-- 合同号码 -->
                          <col style="width: 80px ;"> <!-- 合同日期 -->
                          <col style="width: 80px ;"> <!-- 实物 -->
                          <col style="width: 80px ;"> <!-- 货品编码 -->
                          <col style="width: 100px ;"> <!-- 货品名称 -->
                          <col style="width: 100px ;"> <!-- 规格材质 -->
                          <col style="width: 80px ;"> <!-- 注册商标 -->
                          <col style="width: 80px ;"> <!-- 货品产地 -->
                          <col style="width: 80px ;"> <!-- 规格编码 -->
                          <col style="width: 80px ;"> <!-- 重量(kg) -->
                          <col style="width: 100px ;"> <!-- 含税价格(元) -->
                          <col style="width: 100px ;"> <!-- 交易金额(元) -->
                          <col style="width: 80px ;"> <!-- 交易确认 -->
                          <col style="width: 100px ;"> <!-- 确认付款(元) -->
                          <col style="width: 80px ;"> <!-- 确认收款 -->
                          <col style="width: 80px ;"> <!-- 提货单号 -->
                          <col style="width: 100px ;"> <!-- 提货公司 -->
                          <col style="width: 80px ;"> <!-- 提货车号 -->
                          <col style="width: 80px ;"> <!-- 提货人员 -->
                          <col style="width: 80px ;"> <!-- 提货电话 -->
                          <col style="width: 80px ;"> <!-- 提货身份证 -->
                          <col style="width: 80px ;"> <!-- 发货方式 -->
                          <col style="width: 100px ;"> <!-- 发货说明 -->
                          <col style="width: 80px ;"> <!-- 配货标志 -->
                          <col style="width: 150px ;"> <!-- 配货时间 -->
                          <col style="width: 80px ;"> <!-- 配货人员 -->
                          <col style="width: 100px ;"> <!-- 配货重量(kg) -->
                          <col style="width: 100px ;"> <!-- 配货数量(件) -->
                          <col style="width: 80px ;"> <!-- 配货散件 -->
                          <col style="width: 80px ;"> <!-- 收货卡号 -->
                          <col style="width: 80px ;"> <!-- 收货追加 -->
                          <col style="width: 100px ;"> <!-- 实发重量(kg) -->
                          <col style="width: 100px ;"> <!-- 实发数量(件) -->
                          <col style="width: 80px ;"> <!-- 实发散件 -->
                          <col style="width: 100px ;"> <!-- 重量差异(kg) -->
                          <col style="width: 100px ;"> <!-- 补差金额(元) -->
                          <col style="width: 80px ;"> <!-- 补差确认 -->
                          <col style="width: 100px ;"> <!-- 补差付款(元) -->
                          <col style="width: 80px ;"> <!-- 补差收款 -->
                          <col style="width: 80px ;"> <!-- 仓库接口 -->
                          <col style="width: 80px ;"> <!-- 接口处理 -->
                          <col style="width: 150px ;"> <!-- 接口时间 -->
                          <col style="width: 100px ;"> <!-- 接口信息 -->
                          <col style="width: 80px ;"> <!-- 重量单位 -->
                          <col style="width: 80px ;"> <!-- 数量单位 -->
                          <col style="width: 80px ;"> <!-- 散件单位 -->
                          <col style="width: 100px ;"> <!-- 卖家消息 -->
                          <col style="width: 100px ;"> <!-- 买家消息 -->
                          <col style="width: 100px ;"> <!-- 备注 -->
                          <col style="width: 150px ;"> <!-- 创建时间 -->
                          <col style="width: 150px ;"> <!-- 修改时间 -->
                          <col style="width: auto" >
                        </colgroup>
                        <tbody>
                          <tr>
                            <th>序号</th>
                            <th>状态</th>
                            <th class="abe-txtl">仓库编码</th>
                            <th class="abe-txtl">卖出客户</th>
                            <th class="abe-txtl">买入客户</th>
                            <th class="abe-txtl">交易单号</th>
                            <th>交易类型</th>
                            <th>开单日期</th>
                            <th>截至时间</th>
                            <th class="abe-txtl">合同号码</th>
                            <th>合同日期</th>
                            <th>实物</th>
                            <th class="abe-txtl">货品编码</th>
                            <th class="abe-txtl">货品名称</th>
                            <th class="abe-txtl">规格材质</th>
                            <th class="abe-txtl">注册商标</th>
                            <th class="abe-txtl">货品产地</th>
                            <th class="abe-txtl">规格编码</th>
                            <th class="abe-txtr">重量(kg)</th>
                            <th class="abe-txtr">含税价格(元)</th>
                            <th class="abe-txtr">交易金额(元)</th>
                            <th>交易确认</th>
                            <th class="abe-txtr">确认付款(元)</th>
                            <th class="abe-txtr">确认收款</th>
                            <th class="abe-txtl">提货单号</th>
                            <th class="abe-txtl">提货公司</th>
                            <th class="abe-txtl">提货车号</th>
                            <th class="abe-txtl">提货人员</th>
                            <th class="abe-txtl">提货电话</th>
                            <th class="abe-txtl">提货身份证</th>
                            <th>发货方式</th>
                            <th class="abe-txtl">发货说明</th>
                            <th>配货标志</th>
                            <th>配货时间</th>
                            <th>配货人员</th>
                            <th class="abe-txtr">配货重量(kg)</th>
                            <th class="abe-txtr">配货数量(件)</th>
                            <th class="abe-txtr">配货散件</th>
                            <th class="abe-txtl">收货卡号</th>
                            <th>收货追加</th>
                            <th class="abe-txtr">实发重量(kg)</th>
                            <th class="abe-txtr">实发数量(件)</th>
                            <th class="abe-txtr">实发散件</th>
                            <th class="abe-txtr">重量差异(kg)</th>
                            <th class="abe-txtr">补差金额(元)</th>
                            <th>补差确认</th>
                            <th class="abe-txtr">补差付款(元)</th>
                            <th class="abe-txtr">补差收款</th>
                            <th>仓库接口</th>
                            <th>接口处理</th>
                            <th>接口时间</th>
                            <th class="abe-txtl">接口信息</th>
                            <th>重量单位</th>
                            <th>数量单位</th>
                            <th>散件单位</th>
                            <th class="abe-txtl">卖家消息</th>
                            <th class="abe-txtl">买家消息</th>
                            <th class="abe-txtl">备注</th>
                            <th>创建时间</th>
                            <th>修改时间</th>
                           <th></th >
                          </tr>
                          <?php if(is_array($list)): $i = 0; $__LIST__ = $list; if( count($__LIST__) == 0) : echo ""; else: foreach($__LIST__ as $key=>$master): $mod = ($i % 2 );++$i; ?>
                                  <tr <?php if($mod == "1"): ?>class="even"<?php endif; if($mod == "0"): ?>class="odd"<?php endif; ?>>
                                    <td><?php echo $i + ($page_size * ($p - 1)); ?></td>
                                    <td><?php echo get_table_Trade_status("$master[status]","name","") ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["warehouse_code"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["customer_name"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["buyer_name"] ; ?></td>
                                    <td  class=" abe-txtl "><a href="javascript:void(0);" class="vi-blue"  onclick="return _asr.openLink('<?php echo U("/Home/Trade/index?func=view&id=$master[id]"); ?>','<?php echo filterFuncId( U("/Home/Trade/index?func=view&id=$master[id]") ,"");?>', '<?php echo tabTitle("交易","$master[trade_no]","RIGHT","8") ; ?>' ,0); " ><?php echo $master["trade_no"] ; ?></a></td>
                                    <td><?php echo get_table_Trade_tx_type("$master[tx_type]","name","") ; ?></td>
                                    <td><?php echo system_format("D", $master["tx_date"],1) ; ?></td>
                                    <td><?php echo system_format("DT", $master["expired_time"],1) ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["contract_no"] ; ?></td>
                                    <td><?php echo system_format("D", $master["contract_date"],1) ; ?></td>
                                    <td><?php echo get_table_Trade_is_real("$master[is_real]","name","") ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["goods_no"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["goods_name"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["style_info"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["brand"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["producing_area"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["style_code"] ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("F33", $master["weight"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("F33", $master["price"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("F32", $master["amount"],1) ; ?></td>
                                    <td><?php echo get_table_Trade_confirm_status("$master[confirm_status]","name","") ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("F32", $master["confirm_payment"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("F32", $master["confirm_receive"],1) ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["delivery_no"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["delivery_company"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["delivery_carno"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["delivery_contact"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["delivery_phone"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["delivery_idcard"] ; ?></td>
                                    <td><?php echo get_table_Trade_delivery_type("$master[delivery_type]","name","") ; ?></td>
                                    <td  class=" abe-txtl "><div class="newline"><?php echo OverView($master["delivery_info"],150,"...") ; ?></div></td>
                                    <td><?php echo get_table_Trade_assign_status("$master[assign_status]","name","") ; ?></td>
                                    <td><?php echo system_format("DT", $master["assign_time"],1) ; ?></td>
                                    <td><?php echo $master["assign_user"] ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("F33", $master["assign_weight"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("N3", $master["assign_qty"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("N3", $master["assign_bulkcargo"],1) ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["buyer_storecard_no"] ; ?></td>
                                    <td><?php echo get_table_Trade_buyer_storecard_type("$master[buyer_storecard_type]","name","") ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("F33", $master["act_weight"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("N3", $master["act_qty"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("N3", $master["act_bulkcargo"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("F33", $master["diff_weight"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("F32", $master["diff_amount"],1) ; ?></td>
                                    <td><?php echo get_table_Trade_diff_status("$master[diff_status]","name","") ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("F32", $master["diff_payment"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("F32", $master["diff_receive"],1) ; ?></td>
                                    <td><?php echo get_table_Trade_interface_status("$master[interface_status]","name","") ; ?></td>
                                    <td><?php echo get_table_Trade_interface_process("$master[interface_process]","name","") ; ?></td>
                                    <td><?php echo system_format("DT", $master["interface_time"],1) ; ?></td>
                                    <td  class=" abe-txtl "><div class="newline"><?php echo OverView($master["interface_result"],150,"...") ; ?></div></td>
                                    <td><?php echo $master["uom_weight"] ; ?></td>
                                    <td><?php echo $master["uom_qty"] ; ?></td>
                                    <td><?php echo $master["uom_bulkcargo"] ; ?></td>
                                    <td  class=" abe-txtl "><div class="newline"><?php echo OverView($master["customer_msg"],150,"...") ; ?></div></td>
                                    <td  class=" abe-txtl "><div class="newline"><?php echo OverView($master["buyer_msg"],150,"...") ; ?></div></td>
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

              <?php if ($search['_tab']=='kehuzhangdan'): ?>
                <div class="table-box">
                  <div class="table-in">
                    <form id="<?php echo "$funcid"; ?>-Result"  action="<?php U('Goods/op'); ?>" method="post">
                      <input type="hidden" name="<?php echo "$funcid"; ?>-last-url" id="<?php echo "$funcid"; ?>-last-url" value="<?php echo $__last_url; ?>" />
                      <input type="hidden" name="funcid" value="<?php echo "$funcid"; ?>" />
                      <input type="hidden" name="pfuncid" value="<?php echo "$pfuncid"; ?>" />
                      <input type="hidden" name="id" value="<?php echo $search["id"]; ?>" />
                      <input type="hidden" name="_lastchanged" value="<?php echo $search["lastchanged"]; ?>" />
                      <table border="0" cellspacing="0" cellpadding="0" class="pub-table-par pub-table-par-tdc pub-t-faq">
                        <colgroup>
                          <col style="width: 40px ;"> <!-- 序号 -->
                          <col style="width: 80px ;"> <!-- 状态 -->
                          <col style="width: 100px ;"> <!-- 费用账单 -->
                          <col style="width: 100px ;"> <!-- 客户名称 -->
                          <col style="width: 80px ;"> <!-- 费用月份 -->
                          <col style="width: 80px ;"> <!-- 仓库编码 -->
                          <col style="width: 100px ;"> <!-- 费用合计(元) -->
                          <col style="width: 100px ;"> <!-- 过户费用(元) -->
                          <col style="width: 100px ;"> <!-- 仓储费用(元) -->
                          <col style="width: 100px ;"> <!-- 进库费用(元) -->
                          <col style="width: 100px ;"> <!-- 出库费用(元) -->
                          <col style="width: 100px ;"> <!-- 其他费用(元) -->
                          <col style="width: 100px ;"> <!-- 备注 -->
                          <col style="width: 150px ;"> <!-- 创建时间 -->
                          <col style="width: auto" >
                        </colgroup>
                        <tbody>
                          <tr>
                            <th>序号</th>
                            <th>状态</th>
                            <th class="abe-txtl">费用账单</th>
                            <th class="abe-txtl">客户名称</th>
                            <th>费用月份</th>
                            <th class="abe-txtl">仓库编码</th>
                            <th class="abe-txtr">费用合计(元)</th>
                            <th class="abe-txtr">过户费用(元)</th>
                            <th class="abe-txtr">仓储费用(元)</th>
                            <th class="abe-txtr">进库费用(元)</th>
                            <th class="abe-txtr">出库费用(元)</th>
                            <th class="abe-txtr">其他费用(元)</th>
                            <th class="abe-txtl">备注</th>
                            <th>创建时间</th>
                           <th></th >
                          </tr>
                          <?php if(is_array($list)): $i = 0; $__LIST__ = $list; if( count($__LIST__) == 0) : echo ""; else: foreach($__LIST__ as $key=>$master): $mod = ($i % 2 );++$i; ?>
                                  <tr <?php if($mod == "1"): ?>class="even"<?php endif; if($mod == "0"): ?>class="odd"<?php endif; ?>>
                                    <td><?php echo $i + ($page_size * ($p - 1)); ?></td>
                                    <td><?php echo get_table_Fee_status("$master[status]","name","") ; ?></td>
                                    <td  class=" abe-txtl "><a href="javascript:void(0);" class="vi-blue"  onclick="return _asr.openLink('<?php echo U("/Home/Fee/index?func=view&no=$master[fee_no]"); ?>','<?php echo filterFuncId( U("/Home/Fee/index?func=view&no=$master[fee_no]") ,"");?>', 'id详情' ,0); " ><?php echo $master["fee_no"] ; ?></a></td>
                                    <td  class=" abe-txtl "><a href="javascript:void(0);" class="vi-blue"  onclick="return _asr.openLink('<?php echo U("/Home/Goods/index?func=view&no=$master[customer_name]"); ?>','<?php echo filterFuncId( U("/Home/Goods/index?func=view&no=$master[customer_name]") ,"");?>', 'customer_id详情' ,0); " ><?php echo $master["customer_name"] ; ?></a></td>
                                    <td><?php echo $master["tx_month"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["warehouse_code"] ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("F32", $master["fee_total"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("F32", $master["fee_transfer"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("F32", $master["fee_store"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("F32", $master["fee_stockin"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("F32", $master["fee_stockout"],1) ; ?></td>
                                    <td  class=" abe-txtr "><?php echo system_format("F32", $master["fee_other"],1) ; ?></td>
                                    <td  class=" abe-txtl "><div class="newline"><?php echo OverView($master["remarks"],150,"...") ; ?></div></td>
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

              <?php if ($search['_tab']=='kehucunchuhetong'): ?>
                <div class="table-box">
                  <div class="table-in">
                    <form id="<?php echo "$funcid"; ?>-Result"  action="<?php U('Goods/op'); ?>" method="post">
                      <input type="hidden" name="<?php echo "$funcid"; ?>-last-url" id="<?php echo "$funcid"; ?>-last-url" value="<?php echo $__last_url; ?>" />
                      <input type="hidden" name="funcid" value="<?php echo "$funcid"; ?>" />
                      <input type="hidden" name="pfuncid" value="<?php echo "$pfuncid"; ?>" />
                      <input type="hidden" name="id" value="<?php echo $search["id"]; ?>" />
                      <input type="hidden" name="_lastchanged" value="<?php echo $search["lastchanged"]; ?>" />
                      <table border="0" cellspacing="0" cellpadding="0" class="pub-table-par pub-table-par-tdc pub-t-faq">
                        <colgroup>
                          <col style="width: 40px ;"> <!-- 序号 -->
                          <col style="width: 80px ;"> <!-- 状态 -->
                          <col style="width: 80px ;"> <!-- 合同号码 -->
                          <col style="width: 150px ;"> <!-- 合同到期 -->
                          <col style="width: 100px ;"> <!-- 适用仓库 -->
                          <col style="width: 100px ;"> <!-- 费率说明 -->
                          <col style="width: 150px ;"> <!-- 创建时间 -->
                          <col style="width: 150px ;"> <!-- 修改时间 -->
                          <col style="width: auto" >
                        </colgroup>
                        <tbody>
                          <tr>
                            <th>序号</th>
                            <th>状态</th>
                            <th class="abe-txtl">合同号码</th>
                            <th>合同到期</th>
                            <th class="abe-txtl">适用仓库</th>
                            <th class="abe-txtl">费率说明</th>
                            <th>创建时间</th>
                            <th>修改时间</th>
                           <th></th >
                          </tr>
                          <?php if(is_array($list)): $i = 0; $__LIST__ = $list; if( count($__LIST__) == 0) : echo ""; else: foreach($__LIST__ as $key=>$master): $mod = ($i % 2 );++$i; ?>
                                  <tr <?php if($mod == "1"): ?>class="even"<?php endif; if($mod == "0"): ?>class="odd"<?php endif; ?>>
                                    <td><?php echo $i + ($page_size * ($p - 1)); ?></td>
                                    <td><?php echo get_table_GoodsContact_status("$master[status]","name","") ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["contact_no"] ; ?></td>
                                    <td><?php echo system_format("DT", $master["contact_expire"],1) ; ?></td>
                                    <td  class=" abe-txtl "><div class="newline"><?php echo OverView($master["warehouse_info"],150,"...") ; ?></div></td>
                                    <td  class=" abe-txtl "><div class="newline"><?php echo OverView($master["fee_info"],150,"...") ; ?></div></td>
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

              <?php if ($search['_tab']=='kehudizhi'): ?>
                <div class="table-box">
                  <div class="table-in">
                    <form id="<?php echo "$funcid"; ?>-Result"  action="<?php U('Goods/op'); ?>" method="post">
                      <input type="hidden" name="<?php echo "$funcid"; ?>-last-url" id="<?php echo "$funcid"; ?>-last-url" value="<?php echo $__last_url; ?>" />
                      <input type="hidden" name="funcid" value="<?php echo "$funcid"; ?>" />
                      <input type="hidden" name="pfuncid" value="<?php echo "$pfuncid"; ?>" />
                      <input type="hidden" name="id" value="<?php echo $search["id"]; ?>" />
                      <input type="hidden" name="_lastchanged" value="<?php echo $search["lastchanged"]; ?>" />
                      <table border="0" cellspacing="0" cellpadding="0" class="pub-table-par pub-table-par-tdc pub-t-faq">
                        <colgroup>
                          <col style="width: 40px ;"> <!-- 序号 -->
                          <col style="width: 80px ;"> <!-- 状态 -->
                          <col style="width: 100px ;"> <!-- 联系地址 -->
                          <col style="width: 80px ;"> <!-- 邮政编码 -->
                          <col style="width: 80px ;"> <!-- 联系电话 -->
                          <col style="width: 80px ;"> <!-- 联系手机 -->
                          <col style="width: 80px ;"> <!-- 联系人员 -->
                          <col style="width: auto" >
                        </colgroup>
                        <tbody>
                          <tr>
                            <th>序号</th>
                            <th>状态</th>
                            <th class="abe-txtl">联系地址</th>
                            <th class="abe-txtl">邮政编码</th>
                            <th class="abe-txtl">联系电话</th>
                            <th class="abe-txtl">联系手机</th>
                            <th class="abe-txtl">联系人员</th>
                           <th></th >
                          </tr>
                          <?php if(is_array($list)): $i = 0; $__LIST__ = $list; if( count($__LIST__) == 0) : echo ""; else: foreach($__LIST__ as $key=>$master): $mod = ($i % 2 );++$i; ?>
                                  <tr <?php if($mod == "1"): ?>class="even"<?php endif; if($mod == "0"): ?>class="odd"<?php endif; ?>>
                                    <td><?php echo $i + ($page_size * ($p - 1)); ?></td>
                                    <td><?php echo get_table_GoodsAddress_status("$master[status]","name","") ; ?></td>
                                    <td  class=" abe-txtl "><div><?php echo OverView($master["address"],150,"...") ; ?></div></td>
                                    <td  class=" abe-txtl "><?php echo $master["postcode"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["phone"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["mobile"] ; ?></td>
                                    <td  class=" abe-txtl "><?php echo $master["linkman"] ; ?></td>
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
                    <form id="<?php echo "$funcid"; ?>-Result"  action="<?php U('Goods/op'); ?>" method="post">
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

              <?php if ($search['_tab']=='caozuorizhi'): ?>
                <div class="table-box">
                  <div class="table-in">
                    <form id="<?php echo "$funcid"; ?>-Result"  action="<?php U('Goods/op'); ?>" method="post">
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
                                    <td><?php echo get_table_Goods_status("$master[status]","name","") ; ?></td>
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
          <?php if (!$search['status']): ?>
               <input type="button" value="信息编辑" class="btn btn-blue mlg_10 " default-status="1" onclick="return _asr.popupFun('<?php echo U("/Home/Goods/index?func=edit_base&id=$search[id]") ; ?>', '<?php echo filterFuncId("/Home/Goods/index?func=edit_base&id=$search[id]","");?>'); " />
          <?php endif; ?>
          <?php endif; ?>


          <?php if (isset($rights['rela_add']) && $rights['rela_add']): ?>
          <input type="button" value="新增别名" class="btn btn-blue mlg_10 " default-status="1" onclick="return _asr.popupFun('<?php echo U("/Home/GoodsAlias/index?func=add&pid=$search[id]") ; ?>', '<?php echo filterFuncId("/Home/GoodsAlias/index?func=add&pid=$search[id]","");?>'); " />
          <?php endif; ?>



          <?php if (isset($rights['status_on']) && $rights['status_on']): ?>
          <?php if (!$search['status']): ?>
               <input type="button" value="转有效" class="btn btn-blue mlg_10 " default-status="1" onclick="return _asr.popupFun('<?php echo U("/Home/Goods/index?func=status_on&id=$search[id]") ; ?>', '<?php echo filterFuncId("/Home/Goods/index?func=status_on&id=$search[id]","");?>'); " />
          <?php endif; ?>
          <?php endif; ?>



          <?php if (isset($rights['status_off']) && $rights['status_off']): ?>
          <?php if ($search['status']=='1'): ?>
               <input type="button" value="转无效" class="btn btn-org mlg_10 " default-status="1" onclick="return _asr.popupFun('<?php echo U("/Home/Goods/index?func=status_off&id=$search[id]") ; ?>', '<?php echo filterFuncId("/Home/Goods/index?func=status_off&id=$search[id]","");?>'); " />
          <?php endif; ?>
          <?php endif; ?>

          <div class="abe-fr">


          <?php if (isset($rights['order_delete']) && $rights['order_delete']): ?>
          <?php if (!$search['status']): ?>
               <input type="button" value="记录删除" class="btn btn-org mrg_10 " default-status="1" onclick="return _asr.confirm('确认操作', '请确认是否进行 信息删除 操作?', '', '<?php echo U("/Home/Goods/index?func=delete&id=$search[id]") ; ?>','','<?php echo "$funcid"; ?>-Result'); " />
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


    <?php echo W('Summary/javascript',array('Goods'));?>


    </script>