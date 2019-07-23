<?php if (!defined('THINK_PATH')) exit();?>
<div toplayer="1" class="wrap-box wrap-pb2" id="<?php echo $funcid;?>" baseurl="<?php echo U('Trade/index'); ?>">
    <div class="wrap-box-info">
        <div class="wrap-title abe-ofl">
            <div class="tit abe-fl"> 订单详情 </div>
            <div class="abe-fr"> <a href="javascript:void(0);" class="vi-blue abe-ft16" onclick="return _asr.openLink('','<?php echo "$funcid"; ?>','刷新',1); "><i class="iconfont">&#xe611;</i>刷新</a> </div>
        </div>
        <div class="order-step order-step-new abe-ofl" style="display:;  ">
            <div class="abe-fl odzt">
                <div class="abe-ft24 vi-red pdt_10"><i class="iconfont abe-ft28 mrg_10">&#xe625;</i><strong><?php echo (get_table_Trade_status($search["status"],"name")); ?></strong></div>
                <div class="abe-ft20"><?php echo ($search["trade_no"]); ?></div>
            </div>
            <dl class="abe-fr" style="margin-right: 20px;">
                <?php if(is_array($step)): $i = 0; $__LIST__ = $step; if( count($__LIST__) == 0) : echo ""; else: foreach($__LIST__ as $key=>$item): if($key>0): ?>
                <dd <?php if($item['type']=='after') echo "class='after'"; elseif ($item['type']=='current') echo "class='current'"; elseif ($item['type']=='cancel') echo "class='cancel-faq'"; ?>><i class="iconfont">&#xe619;</i></dd>
                <?php endif; ?>
                <dt <?php if($item['type']=='after') echo "class='after'"; elseif ($item['type']=='current') echo "class='current'"; elseif ($item['type']=='cancel') echo "class='cancel-faq'"; ?>>
                <div <?php if($item['type']=='cancel') echo "class='iconfont'"; ?> ><?php echo $item['no'];?></div>
        <span><?php echo $item['desc'];?></span>
        <time><?php echo $item['time'];?></time>
        </dt>
        <?php endforeach; endif; endif; ?>
            </dl>
        </div>
        <div class="order-detpage">
            <div class="order-info">
                <div class="abe-gray3 abe-fl"> 交易提示：<?php if(!empty($search[payment_expire])): ?><b class="abe-red">买方必须于<?php echo (date("Y-m-d H:i:s",strtotime($search["payment_expire"]))); ?>之前完成付款，否则卖方有权取消交易。<?php endif; ?></b></div>
                <div class="abe-fr vi-blue"><strong><?php if(!empty($search['chain_no'])): ?>链号：<?php echo ($search["chain_no"]); endif; ?></strong></div>
            </div>
        </div>
        <div class="order-detpage mtg_15">
            <!--          <div class="odtit abe-fb pdb_10 pdt_15"> 交易信息 </div>-->
            <div class="order-info">
                <ul class="order-det-list2" style="display: ">
                    <li style="padding-left: 0"><b>订单信息</b></li>
                    <li><span class="tit">订单编号：</span><?php echo ($search["trade_no"]); ?></li>
                    <li><span class="tit">交易类型：</span><?php echo (get_table_Trade_tx_type($search["tx_type"])); ?></li>
                    <li><span class="tit">卖方单位：</span><?php echo ($search["customer_name"]); ?></li>

                    <li><span class="tit">买方单位：</span><?php echo ($search["buyer_name"]); ?></li>
                    <li><span class="tit">销售合同：</span><?php echo ($search["contract_no"]); ?> <input type="button" value="登记" onclick="return _asr.popupFun('<?php echo U("/Home/Trade/Index/func/contract_edit/id/".$search[id]);?>','<?php echo filterFuncId("other_edit","");?>')" class="btn btn-blue btn-xs abe-ft12 mlg_10"></li>
                </ul>
                <ul class="order-det-list2 odl-h" style="display: ">
                    <li style="padding-left: 0"><b>货品信息</b></li>
                    <li><span class="tit">货品名称：</span><?php echo ($search["goods_name"]); ?>/<?php echo ($search["style_info"]); ?> <br><?php echo ($search["brand"]); ?>/<?php echo ($search["producing_area"]); ?></li>
                    <li><span class="tit">货品重量：</span><?php echo (system_format('F5',$search["weight"],'F5')); ?> <?php echo ($search["uom_weight"]); ?><br>
                        <b class="vi-blue"><?php echo (num2upper_weight($search["weight"])); echo ($search["uom_weight"]); ?></b></li>
                    <li><span class="tit">货品单价：</span>￥<?php echo (system_format('F5',$search["price"],'F5')); ?> 元/<?php echo ($search["uom_weight"]); ?><b class="pdl_10 vi-blue">（人民币）</b></li>
                    <li><span class="tit">货品金额：</span>￥<?php echo (system_format('F5',$search["amount"],'F5')); ?> 元</li>
                </ul>

                <ul class="order-det-list2" style="display: ">
                    <li style="padding-left: 0"><b>提单信息</b></li>
                    <li><span class="tit">提单号码：</span><?php echo ($search["delivery_no"]); ?></li>
                    <li><span class="tit">提单日期：</span><?php echo (sys_date_format("Y-m-d",$search["delivery_date"])); ?> <input type="button" value="变更" onclick="return _asr.popupFun('<?php echo U("/Home/Trade/Index/func/delivery_edit/id/".$search[id]);?>','<?php echo filterFuncId("other_edit","");?>')" class="btn btn-blue btn-xs abe-ft12 mlg_10"></li>
                    <li><span class="tit">提单截止：</span><?php echo (sys_date_format("Y-m-d H:i",$search["delivery_expired"])); ?></li>
                    <li><span class="tit">提货信息：</span><?php echo ($search["delivery_carinfo"]); ?></li>
               </ul>
                <ul class="order-det-list2" style="display: ">
                    <li style="padding-left: 0"><b>仓储要求</b></li>
                    <li><span class="tit">仓储费用</span>
                        <input type="checkbox" disabled <?php if($search["storefee_bears"] == 1): ?>checked<?php endif; ?>>提货方承担</li>
                    <li><span class="tit">仓储起算：</span><?php echo (sys_date_format("Y-m-d H:i",$search["storefee_start"])); ?></li>
                    <li></li>
                    <li><span class="tit">配货仓库：</span><?php echo ($search["warehouse_name"]); ?></li>
                    <li><span class="tit">配货要求：</span><?php echo (get_table_Trade_delivery_type($search["delivery_type"])); ?></li>
                </ul>

            </div>
        </div>
        <div class="order-detpage mtg_15">
            <!--          <div class="odtit abe-fb pdb_10 pdt_15"> 交易确认信息 </div>-->
            <div class="order-info">
                <ul class="order-det-list2 odl-h" style="display: ">
                    <li style="padding-left: 0"><b>卖方确认</b></li>
                    <li><span class="tit">制单时间：</span><?php echo (sys_date_format("Y-m-d H:i",$search["create_time"])); ?> <?php echo ($search["create_user"]); ?></li>
                    <li><span class="tit">确认时间：</span><?php echo (sys_date_format("Y-m-d H:i",$search["cust_confirm_time"])); ?> <?php echo ($search["cust_confirm_user"]); ?></li>
                    <li><span class="tit">发送时间：</span><?php echo (sys_date_format("Y-m-d H:i",$search["cust_send_time"])); ?> <?php echo ($search["cust_send_user"]); ?></li>
                    <li><span class="tit">到款确认：</span>
                        <div><?php echo (sys_date_format("Y-m-d H:i",$customer_payment_info["confirm_time"])); ?>  <?php echo ($customer_payment_info["confirm_user"]); ?></div>
                        <div>￥<?php echo (system_format('F5',$search["confirm_receive"],'F5')); ?> 元 <b class="pdl_10 vi-blue">（<?php echo ($search["confirm_receive"]/$search["amount"])*100 ?>%）</b></div>
                    </li>
                    <li><span class="tit">配货时间：</span>
                        <div><?php echo (sys_date_format("Y-m-d H:i",$search["assign_time"])); ?>  <?php echo ($search["assign_user"]); ?></div>
                    </li>
                </ul>
                <ul class="order-det-list2 odl-h" style="display: ">
                    <li style="padding-left: 0"><b>买方确认</b></li>
                    <li><span class="tit">确认时间：</span><?php echo (sys_date_format("Y-m-d H:i",$search["buyer_confirm_time"])); ?>  <?php echo ($search["buyer_confirm_user"]); ?></li>
                    <li><span class="tit">付款确认：</span>
                        <div><?php echo (sys_date_format("Y-m-d H:i",$buyer_payment_info["confirm_time"])); ?>  <?php echo ($buyer_payment_info["confirm_user"]); ?></div>
                        <div>￥<?php echo (system_format('F5',$search["confirm_payment"],'F5')); ?> 元<b class="pdl_10 vi-blue">（<?php echo ($search["confirm_payment"]/$search["amount"])*100 ?>%）</b></div>
                    </li>
                    <li></li>
                    <?php if($search["tx_type"] == 0): ?><li><span class="tit">存入存储卡：</span><?php echo ($search["buyer_storecard_no"]); ?><input type="button" value="登记" onclick="return _asr.popupFun('<?php echo U("/Home/Trade/Index/func/storecard_edit/id/".$search[id]);?>','<?php echo filterFuncId("other_edit","");?>')"  class="btn btn-blue btn-xs abe-ft12 mlg_10"></li><?php endif; ?>
                </ul>
                <ul class="order-det-list2 odl-h" style="display: ">
                    <li style="padding-left: 0"><b>仓库接口</b></li>
                    <li><span class="tit">接口处理：</span><div><?php echo (get_table_Trade_interface_status($search["interface_status"])); ?></div></li>
                    <li><span class="tit">发送仓库：</span><?php echo (sys_date_format("Y-m-d H:i",$search["interface_send_time"])); ?></li>
                    <li><span class="tit">仓库返回：</span><?php echo (sys_date_format("Y-m-d H:i",$search["interface_receive"])); ?></li>
                    <li><span class="tit">处理结果：</span><em class="abe-red"><?php echo (get_table_Trade_interface_status($search["interface_send_status"])); ?></em><input type="button"  onclick="<?php echo ($funcid); ?>_test();" value="重新处理" class="btn btn-blue btn-xs abe-ft12 mlg_10"></li>

                </ul>
                <?php if($search["tx_type"] == 0): ?><ul class="order-det-list2 odl-h" style="display: ">
                    <li style="padding-left: 0"><b>过户信息</b></li>
                    <li><span class="tit">过户时间：</span><?php echo (sys_date_format("Y-m-d H:i",$search["act_time"])); ?></li>
                    <li><span class="tit">过户重量：</span><?php echo (system_format('F5',$search["act_weight"],'F5')); ?> <?php echo ($search["uom_weight"]); ?> <?php echo (system_format('F5',$search["act_qty"],'F5')); echo ($search["uom_qty"]); ?></li>
                    <?php if($search["diff_weight"] != 0): ?><li><span class="tit">重量差异：</span><?php echo (system_format('F5',$search["diff_weight"],'F5')); ?> <?php echo ($search["uom_weight"]); ?></li><?php endif; ?>
                        <?php if($search["diff_amount"] != 0): ?><li><span class="tit">差异金额：</span><em class="abe-red">￥<?php echo (system_format('F5',$search["diff_amount"],'F5')); ?> 元&nbsp;（卖方应<?php echo ($search["diff_amount"]>0?"收":"退"); ?>）</em></li><?php endif; ?>
                </ul><?php endif; ?>
            </div>
        </div>
        <div class="order-detpage abe-ofl">
            <div class="odtit abe-fb pdb_10 pdt_15 abe-ofl"> <div class="abe-fl">货品信息 </div>
                <div class="abe-fr pdl_20"><span data-type="assign_weight" data-value="<?php echo ($search['assign_weight']); ?>"><?php if($search['assign_weight'] > 0): ?>共：<?php echo (system_format('F5',$search["assign_weight"],'F5')); ?> <?php echo ($search["uom_weight"]); ?> <?php echo (system_format('F5',$search["assign_qty"],'F5')); echo ($search["uom_qty"]); endif; ?></span>
                    <?php if($search['customer_id'] == $user['customer_id'] and $search['status'] == 2 and $search['assign_status'] < 2 ): ?><input type="button" onclick="return _asr.confirm('确认操作', '请确认是否进行 配货处理 操作?', '', '<?php echo U("/Home/Trade/index?func=assign&id=$search[id]") ; ?>','','<?php echo "$funcid"; ?>-Search'); " value="配货处理" class="btn btn-blue btn-sm abe-ft12 mlg_10"><?php endif; ?>
                </div>
            </div>
            <div class="order-info">
                <div class="table-box">
                    <div class="table-in pdn0">
                        <table border="0" cellspacing="0" cellpadding="0" class="pub-table ta-tr-hover" >
                            <tbody>
                                <tr>
                                    <th>#</th><th></th>
                                    <th>转出存储卡</th>
                                    <th>转出码单</th>
                                    <th>商品/规格/材质</th>
                                    <th>品牌/产地</th>
                                    <th>转出重量(<?php echo ($search["uom_weight"]); ?>)</th>
                                    <th>实际出库(<?php echo ($search["uom_weight"]); ?>)</th>
                                    <th>仓储费起始</th>
                                    <th>操作</th>
                                </tr>
                            <?php if(is_array($list)): $k = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><tr class=<?php if(($k%2) == 0): ?>"odd"<?php else: ?>"even"<?php endif; ?> id="<?php echo ($funcid); ?>_assign_<?php echo ($vo["storecard_id"]); ?>">
                                <td><?php echo ($k); ?></td>
                                    <td><a href="javascript:void(0);" onclick="return _asr.loadData('<?php echo "$funcid"; ?>','<?php echo U("/Home/Trade/index?func=get_package_list&id=$vo[id]&sid=$vo[storecard_id]") ; ?>',this, 'detail' ); " class="vi-blue">展开</a></td>
                                <td><?php echo ($vo["storecard_no"]); ?></td>
                                    <td></td>
                                <td><?php echo ($vo["goods_name"]); ?>/<?php echo ($vo["style_info"]); ?></td>
                                <td><?php echo ($vo["brand"]); ?>/<?php echo ($vo["brand"]); ?></td>
                                <td data-value="<?php echo ($vo["weight"]); ?>" data-type="weight"><?php echo (system_format('F5',$vo["weight"],'F5')); ?></td>
                                <td><?php echo (system_format('F5',$vo["act_weight"],'F5')); ?></td>
                                <td></td>
                                <td><a href="javascript:void(0);" onclick="return _asr.confirm('确认操作', '请确认是否进行 存储卡 操作?', '', '<?php echo U("/Home/Trade/index?func=assign_del&assign_id=$vo[id]") ; ?>','','<?php echo "$funcid"; ?>-Search'); " class="abe-red">删除</a>
                                </td>
                                </tr><?php endforeach; endif; else: echo "" ;endif; ?>



                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="blank15"></div>
            <div>
                <?php echo ($page); ?>
            </div>
        </div>
        <div class="order-detpage">
            <div class="odtit abe-fb pdb_10 pdt_15"> 备注信息 </div>
            <div class="order-info">
                <p><?php echo ($search["remark"]); ?></p>
            </div>
        </div>
    </div>
<div class="data-oper" >
    <div class="data-oper-in " >


        <?php if (isset($rights['order_edit']) && $rights['order_edit']): ?>
        <?php if (!$search['status']): ?>
        <input type="button" value="信息编辑" class="btn btn-blue mlg_10 " default-status="1" onclick="return _asr.popupFun('<?php echo U("/Home/Trade/index?func=edit_base&id=$search[id]") ; ?>', '<?php echo filterFuncId("/Home/Trade/index?func=edit_base&id=$search[id]","");?>'); " />
        <?php endif; ?>
        <?php endif; ?>




        <?php if (isset($rights['confirm']) && $rights['confirm']): ?>
        <?php if (($search['status']==0 && $search["customer_id"]==$user["customer_id"]) or ($search['status']==1 && $search["buyer_id"]==$user["customer_id"]) ): ?>
        <input type="button" value="提单确认" class="btn btn-blue mlg_10 " default-status="1" onclick="return _asr.popupFun('<?php echo U("/Home/Trade/index?func=confirm&id=$search[id]") ; ?>', '<?php echo filterFuncId("/Home/Trade/index?func=confirm&id=$search[id]","");?>'); " />
        <?php endif; ?>
        <?php endif; ?>



        <?php if (isset($rights['confirm_rollback']) && $rights['confirm_rollback']): ?>
        <?php if ($search['status']=='1'): ?>
        <input type="button" value="转草稿" class="btn btn-org mlg_10 " default-status="1" onclick="return _asr.popupFun('<?php echo U("/Home/Trade/index?func=confirm_rollback&id=$search[id]") ; ?>', '<?php echo filterFuncId("/Home/Trade/index?func=confirm_rollback&id=$search[id]","");?>'); " />
        <?php endif; ?>
        <?php endif; ?>



        <?php if (isset($rights['toassign']) && $rights['toassign']): ?>
        <?php if ($search['status']=='1' && false): ?>
        <input type="button" value="转待配货" class="btn btn-blue mlg_10 " default-status="1" onclick="return _asr.popupFun('<?php echo U("/Home/Trade/index?func=toassign&id=$search[id]") ; ?>', '<?php echo filterFuncId("/Home/Trade/index?func=toassign&id=$search[id]","");?>'); " />
        <?php endif; ?>
        <?php endif; ?>



        <?php if (isset($rights['assign_rollback']) && $rights['assign_rollback']): ?>
        <?php if ($search['assign_status']=='2'): ?>
        <input type="button" value="配货回退" class="btn btn-org mlg_10 " default-status="1" onclick="return _asr.popupFun('<?php echo U("/Home/Trade/index?func=assign_rollback&id=$search[id]") ; ?>', '<?php echo filterFuncId("/Home/Trade/index?func=assign_rollback&id=$search[id]","");?>'); " />
        <?php endif; ?>
        <?php endif; ?>

        <?php if (isset($rights['manual_assign']) && $rights['manual_assign']): ?>
        <?php if ($search['status']==2 && $search["customer_id"]==$user["customer_id"]): ?>
        <input type="button" value="手动配货" class="btn btn-blue mlg_10 " default-status="1" onclick="return _asr.popupFun('<?php echo U("/Home/Trade/index?func=manual_assign&id=$search[id]") ; ?>', '<?php echo filterFuncId("/Home/Trade/index?func=manual_assign&id=$search[id]","");?>'); " />
        <?php endif; ?>
        <?php endif; ?>


        <?php if (isset($rights['wait_warhouse']) && $rights['wait_warhouse']): ?>
        <?php if ($search['status']=='2'): ?>
        <input type="button" value="转接口等待" class="btn btn-blue mlg_10 " default-status="1" onclick="return _asr.popupFun('<?php echo U("/Home/Trade/index?func=wait_warhouse&id=$search[id]") ; ?>', '<?php echo filterFuncId("/Home/Trade/index?func=wait_warhouse&id=$search[id]","");?>'); " />
        <?php endif; ?>
        <?php endif; ?>



        <?php if (isset($rights['wait_rollback']) && $rights['wait_rollback']): ?>
        <?php if ($search['status']=='3'): ?>
        <input type="button" value="等待回退" class="btn btn-org mlg_10 " default-status="1" onclick="return _asr.popupFun('<?php echo U("/Home/Trade/index?func=wait_rollback&id=$search[id]") ; ?>', '<?php echo filterFuncId("/Home/Trade/index?func=wait_rollback&id=$search[id]","");?>'); " />
        <?php endif; ?>
        <?php endif; ?>



        <?php if (isset($rights['warehouse_process']) && $rights['warehouse_process']): ?>
        <?php if ($search['status']=='3'): ?>
        <input type="button" value="转仓库处理" class="btn btn-blue mlg_10 " default-status="1" onclick="return _asr.popupFun('<?php echo U("/Home/Trade/index?func=warehouse_process&id=$search[id]") ; ?>', '<?php echo filterFuncId("/Home/Trade/index?func=warehouse_process&id=$search[id]","");?>'); " />
        <?php endif; ?>
        <?php endif; ?>



        <?php if (isset($rights['warehouse_rollback']) && $rights['warehouse_rollback']): ?>
        <?php if ($search['status']=='4'): ?>
        <input type="button" value="仓库处理回退" class="btn btn-org mlg_10 " default-status="1" onclick="return _asr.popupFun('<?php echo U("/Home/Trade/index?func=warehouse_rollback&id=$search[id]") ; ?>', '<?php echo filterFuncId("/Home/Trade/index?func=warehouse_rollback&id=$search[id]","");?>'); " />
        <?php endif; ?>
        <?php endif; ?>



        <?php if (isset($rights['difference']) && $rights['difference']): ?>
        <?php if ($search['status']=='4'): ?>
        <input type="button" value="转款项补差" class="btn btn-blue mlg_10 " default-status="1" onclick="return _asr.popupFun('<?php echo U("/Home/Trade/index?func=difference&id=$search[id]") ; ?>', '<?php echo filterFuncId("/Home/Trade/index?func=difference&id=$search[id]","");?>'); " />
        <?php endif; ?>
        <?php endif; ?>



        <?php if (isset($rights['difference_rollback']) && $rights['difference_rollback']): ?>
        <?php if ($search['status']=='5'): ?>
        <input type="button" value="补差回退" class="btn btn-org mlg_10 " default-status="1" onclick="return _asr.popupFun('<?php echo U("/Home/Trade/index?func=difference_rollback&id=$search[id]") ; ?>', '<?php echo filterFuncId("/Home/Trade/index?func=difference_rollback&id=$search[id]","");?>'); " />
        <?php endif; ?>
        <?php endif; ?>



        <?php if (isset($rights['close']) && $rights['close']): ?>
        <?php if ($search['status']=='5'): ?>
        <input type="button" value="交易结束" class="btn btn-blue mlg_10 " default-status="1" onclick="return _asr.popupFun('<?php echo U("/Home/Trade/index?func=close&id=$search[id]") ; ?>', '<?php echo filterFuncId("/Home/Trade/index?func=close&id=$search[id]","");?>'); " />
        <?php endif; ?>
        <?php endif; ?>



        <?php if (isset($rights['close_rollback']) && $rights['close_rollback']): ?>
        <?php if ($search['status']=='6'): ?>
        <input type="button" value="结束回退" class="btn btn-org mlg_10 " default-status="1" onclick="return _asr.popupFun('<?php echo U("/Home/Trade/index?func=close_rollback&id=$search[id]") ; ?>', '<?php echo filterFuncId("/Home/Trade/index?func=close_rollback&id=$search[id]","");?>'); " />
        <?php endif; ?>
        <?php endif; ?>


        <?php if (isset($rights['make_delivery']) && $rights['make_delivery']): ?>
        <input type="button" value="提单信息" class="btn btn-blue mlg_10 " default-status="1" onclick="return _asr.popupFun('<?php echo U("/Home/Trade/index?func=make_delivery&id=$search[id]") ; ?>', '<?php echo filterFuncId("/Home/Trade/index?func=make_delivery&id=$search[id]","");?>'); " />
        <?php endif; ?>


        <?php if (isset($rights['pay_register']) && $rights['pay_register']): ?>
        <?php if (($search['status']=='1') || ($search['status']=='0') || ($search['status']=='5')): ?>
        <input type="button" value="收付款登记" class="btn btn-blue mlg_10 " default-status="1" onclick="return _asr.popupFun('<?php echo U("/Home/Trade/index?func=pay_register&id=$search[id]") ; ?>', '<?php echo filterFuncId("/Home/Trade/index?func=pay_register&id=$search[id]","");?>'); " />
        <?php endif; ?>
        <?php endif; ?>

        <?php if (isset($rights['export_trade_assign']) && $rights['export_trade_assign']): ?>
        <input type="button" value="导出配货信息" class="btn btn-blue mlg_10 " default-status="1" onclick="return _asr.submit('<?php echo $funcid; ?>', '<?php echo $funcid; ?>-Search', '<?php echo U("/Home/Trade/index?func=exportTradeAssign&id=$search[id]") ; ?>', 1); " />
        <?php endif; ?>

        <?php if (isset($rights['manual_deliver']) && $rights['manual_deliver']): ?>
        <?php if ($search['status']=='5'): ?>
        <input type="button" value="手工发货" class="btn btn-blue mlg_10 " default-status="1"  onclick="<?php echo $funcid;?>_manualDeliver();" />
        <?php endif; ?>
        <?php endif; ?>


        <div class="abe-fr">

            <input type="button" value="导出转移入库pdf" class="btn btn-org mlg_10 " default-status="1" onclick="return _asr.popupFun('<?php echo U("/Home/Trade/index?func=createPDFshift&id=$search[id]") ; ?>', '<?php echo filterFuncId("/Home/Trade/index?func=createPDFshift&id=$search[id]","");?>'); " />

            <input type="button" value="导出货物流转pdf" class="btn btn-org mlg_10 " default-status="1" onclick="return _asr.popupFun('<?php echo U("/Home/Trade/index?func=createPDFGoodsshift&id=$search[id]") ; ?>', '<?php echo filterFuncId("/Home/Trade/index?func=createPDFGoodsshift&id=$search[id]","");?>'); " />

            <?php if (isset($rights['order_delete']) && $rights['order_delete']): ?>
            <?php if (!$search['status']): ?>
            <input type="button" value="记录删除" class="btn btn-org mrg_10 " default-status="1" onclick="return _asr.confirm('确认操作', '请确认是否进行 信息删除 操作?', '', '<?php echo U("/Home/Trade/index?func=delete&id=$search[id]") ; ?>','','<?php echo "$funcid"; ?>-Result'); " />
            <?php endif; ?>
            <?php endif; ?>


            <?php if (isset($rights['cancel']) && $rights['cancel']): ?>
            <?php if (($search['status']=='1' || $search['status']=='2' || $search['status']=='3' || $search['status']=='4' || $search['status']=='5' || $search['status']=='6' || $search['status']=='8')): ?>
            <input type="button" value="信息取消" class="btn btn-org mlg_10 " default-status="1" onclick="return _asr.popupFun('<?php echo U("/Home/Trade/index?func=cancel&id=$search[id]") ; ?>', '<?php echo filterFuncId("/Home/Trade/index?func=cancel&id=$search[id]","");?>'); " />
            <?php endif; ?>
            <?php endif; ?>

        </div>
    </div>
</div>
<form action="<?php echo U('Trade/index?func=view'); ?>" id="<?php echo "$funcid"; ?>-Search" method="get" enctype="multipart/form-data">
<input type="hidden" name="funcid" value="<?php echo "$funcid"; ?>" />
<input type="hidden" name="pfuncid" value="<?php echo "$pfuncid"; ?>" />
<input type="hidden" name="<?php echo "$funcid"; ?>-last-url" id="<?php echo "$funcid"; ?>-last-url" value="<?php echo $__last_url; ?>" />
<input type="hidden" name="id" value="<?php echo $search["id"]; ?>" />
<input type="hidden" name="_lastchanged" value="<?php echo $search["lastchanged"]; ?>" />
</form>
<form action="<?php echo U('Trade/index?func=view'); ?>" id="<?php echo $funcid; ?>-POST" method="post" enctype="multipart/form-data">
<input type="hidden" name="funcid" value="<?php echo $funcid; ?>" />
<input type="hidden" name="pfuncid" value="<?php echo $pfuncid; ?>" />
<input type="hidden" name="<?php echo $funcid; ?>-last-url" id="<?php echo $funcid; ?>-last-url" value="<?php echo $__last_url; ?>" />
<input type="hidden" name="id" value="<?php echo $search['id']; ?>" />
<input type="hidden" name="_lastchanged" value="<?php echo $search['lastchanged']; ?>" />
<input type="file" style="display:none;" id="<?php echo $funcid;?>_import_file"  name="upload_file" onchange="<?php echo $funcid;?>_choose();"  />
</form>

</div>

<script>
    $(function(){
        $("#<?php echo ($funcid); ?> .order-info").each(function(){
            var odih = $(this).height();
            $(this).children(".order-det-list2").height(odih)
        });
    });

    function <?php echo ($funcid); ?>_manualDeliver() {
        $('#<?php echo $funcid;?>_import_file').val("");
        _asr.confirm("提示", "请确认要手工发货此交易单吗?", "", "", function() {
            $('#<?php echo $funcid;?>_import_file').click();
        });
    }

    function <?php echo ($funcid); ?>_choose(){
        _asr.submit('<?php echo ($funcid); ?>', '<?php echo $funcid; ?>-POST', '<?php echo U("/Home/Trade/index?func=manualDeliver&id=$search[id]") ; ?>', 2);
    }

    function <?php echo ($funcid); ?>_del_callback(t,v){
        var cur_id="<?php echo ($funcid); ?>_"+t+"_"+v;
        var parent_id=$("#"+cur_id).attr("data-parent-id");
        var cur_weight=$("#"+cur_id).find("td[data-type='weight']").attr("data-value");
        if(parent_id!=undefined && parent_id!="")
        {
            <?php echo ($funcid); ?>_calc_weight(cur_id,parent_id,cur_weight);
        }
        $("#"+cur_id).remove();
        $("#"+cur_id+"_table").remove();
        if($("#"+parent_id+"_table tr").length<=1)
        {
            $("#"+parent_id+"_table").remove();
        }
        var parent_weight=$("#<?php echo ($funcid); ?>").find("span[data-type='assign_weight']").attr("data-value");
        parent_weight-=cur_weight;
        $("#<?php echo ($funcid); ?>").find("span[data-type='assign_weight']").attr("data-value",parent_weight);
        $("#<?php echo ($funcid); ?>").find("span[data-type='assign_weight']").html("共:"+parent_weight+"<?php echo ($search["uom_weight"]); ?>");
    }

    function <?php echo ($funcid); ?>_calc_weight(cur_id,parent_id,cur_weight){
        var parent_weight=$("#"+parent_id).find("td[data-type='weight']").attr("data-value");
        parent_weight-=cur_weight;
        $("#"+parent_id).find("td[data-type='weight']").attr("data-value",parent_weight.toString());
        $("#"+parent_id).find("td[data-type='weight']").html(parent_weight.toString());
        var next_parent_id=$("#"+parent_id).attr("data-parent-id");
        if(next_parent_id!=undefined && next_parent_id!="")
        {
            <?php echo ($funcid); ?>_calc_weight(parent_id,next_parent_id,cur_weight);
        }
    }

    function <?php echo ($funcid); ?>_test(){
        alert(1);
    }
</script>