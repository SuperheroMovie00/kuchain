<?php if (!defined('THINK_PATH')) exit();?>
<div toplayer="1" class="prompt-pop pop-style3" style="z-index: <?php echo ($zindex); ?>; width: 800px;" id="<?php echo ($funcid); ?>" url="<?php echo U('Trade/index'); ?>">
    <div class="title"> <span class="pop-name"><?php echo $search[id]?'编辑':'新增'; ?>交易开单信息</span> <a href="javascript:void(0);" onclick="_asr.closePopup('<?php echo ($funcid); ?>');" class="close iconfont"></a> </div>
    <div class="pop-scroll">
        <div class="screening ">
            <form enctype="multipart/form-data" action="<?php echo U('Trade/index?func=save'); ?>" id="<?php echo $funcid; ?>-Search" method="post">
                <input type="hidden" name="<?php echo $funcid; ?>-last-url" id="<?php echo $funcid; ?>-last-url" value="<?php echo $__last_url; ?>" />
                <input type="hidden" name="funcid" value="<?php echo $funcid; ?>" />
                <input type="hidden" name="pfuncid" value="<?php echo $pfuncid; ?>" />
                <input type="hidden" name="id" value="<?php echo $search['id']; ?>" />
                <input type="hidden" name="storeCardNo" value="<?php echo $storeCardNo; ?>" />
                <input type="hidden" name="_lastchanged" value="<?php echo $search['lastchanged']; ?>" />
            <ul class="form form-mod-new form-column2" >
                <li>
                    <div class="unit-left"><span class="tit"> 交易类型</span></div>
                    <div class="unit-mid">
                        <span><input title="" type="radio" class="mrg_5 mlg_5" name="tx_type" value="0" selectGroup="1" groupName="tx_type" <?php if($search['tx_type'] == 0) { ?>checked="checked"<?php } ?>>过户转让</span>
                        <span class="pdl_5"><input title="" type="radio" class="mrg_5" name="tx_type" value="1" selectGroup="1" groupName="tx_type" <?php if($search['tx_type'] == 1) { ?>checked="checked"<?php } ?>>直接提货</span>
                    </div>
                </li>
                <li>
                    <div class="unit-left"><span class="tit"> 制单日期</span></div>
                    <div class="unit-mid">
                        <div class="calendar">
                            <?php if(!$id) { ?>
                            <label class="pbtxt calendar0" ><?php echo date('Y/m/d'); ?></label>
                            <?php } else { ?>
                            <label class="pbtxt calendar0" ><?php echo ($search['tx_date']); ?></label>
                            <?php } ?>
                        </div>
                        <div class="prompt" style="display:none">
                            <div class="error"><i class="iconfont">&#xe616;</i></div>
                        </div>
                    </div>
                </li>
                <li class="per100">
                    <div class="unit-left"><span class="tit"> 买方客户</span></div>
                    <div class="unit-mid">
                        <div class="textbox">
                            <div class="popup">
                                <input type="text" title="" class="pbtxt txt0" name="buyer_name"  value="<?php echo $search['buyer_name']; ?>"  >
                                <input type="hidden" name="buyer_id"  value="<?php echo $search['buyer_id']; ?>" />
                                <button type="submit" class="txt-search" data-type="buyer"><i class="iconfont">&#xe60e;</i></button>
                                <button type="submit" class="txt-clear" <?php if(!isset($search['buyer_name']) || $search['buyer_name'] == '') { ?>style="display:none"<?php } ?>><i class="iconfont">&#xe616;</i></button>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="">
                    <div class="unit-left"><span class="tit"> 提单号码</span></div>
                    <div class="unit-mid">
                        <div class="textbox">
                            <input type="text" title="" class="pbtxt txt0" name="delivery_no" value="<?php echo ($search['delivery_no']); ?>">
                        </div>
                    </div>
                </li>
                <li class="">
                    <div class="unit-left"><span class="tit"> 提单日期</span></div>
                    <div class="unit-mid">
                        <div class="textbox">
                            <input type="text" title="" class="pbtxt txt0 calendar0" name="delivery_date" value="<?php echo ($search['delivery_date']); ?>">
                        </div>
                    </div>
                </li>
                <li>
                    <div class="unit-left"><span class="tit"> 合同号码</span></div>
                    <div class="unit-mid">
                        <div class="textbox">
                            <input title="" type="text" class="pbtxt txt0" name="contract_no" value="<?php echo ($search['contract_no']); ?>">
                        </div>
                        <div class="prompt" style="display:none">
                            <div class="error"><i class="iconfont">&#xe616;</i></div>
                        </div>
                    </div>
                </li>
                <li class="">
                    <div class="unit-left"><span class="tit"> 提单截止</span></div>
                    <div class="unit-mid">
                        <div class="textbox">
                            <input type="text" title="" class="pbtxt txt0 calendar0" readonly="" name="delivery_expired" value="<?php echo ($search['delivery_expired']); ?>">
                        </div>
                    </div>
                </li>


                <li class="border-line"></li>
                <li class="">
                    <div class="unit-left"><span class="tit"> 仓库编码</span></div>
                    <div class="unit-mid">
                        <div class="dropdown">
                            <select class="pbsele dropdown0" name="warehouse_code">
                                <option value="" <?php if($search['warehouse_code'] == ''): ?> selected="selected" <?php endif;?> ></option>
                                <?php
 $keyvalue = table_Warehouse(); if(is_array($keyvalue)){ $i = 0; $__LIST__ = $keyvalue; ?>
                                <?php foreach($__LIST__ as $key=>$item): ++$i; ?>
                                <option value="<?php echo $item['code']; ?>" <?php if($item['code'] == $search['warehouse_code']): ?> selected="selected" <?php endif;?>><?php echo $item['name']; ?></option>
                                <?php endforeach; ?>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="prompt" style="display:none">
                            <div class="error"><i class="iconfont">&#xe616;</i></div>
                        </div>
                    </div>
                </li>
                <li class=" "></li>
                <li class="per100">
                    <div class="unit-left"><span class="tit"> 货品名称</span></div>
                    <div class="unit-mid">
                        <div class="textbox">
                            <div class="popup">
                                <input type="text" title="" class="pbtxt txt0" readonly="" name="goods_name" value="<?php echo ($goods['name']); ?>">
                                <input type="hidden" name="goods_no"  value="<?php if(isset($goods) && $goods) { echo ($goods['goods_no']); } ?>" />
                                <button type="submit" data-type="goods" class="txt-search" <?php if(isset($goods) && !empty($goods)) { ?>style="display:none"<?php } ?>><i class="iconfont">&#xe60e;</i></button>
                            </div>
                            <button type="submit" class="txt-clear" <?php if(!isset($goods) || empty($goods)) { ?>style="display:none"<?php } ?>><i class="iconfont">&#xe616;</i></button>
                        </div>
                        <div class="prompt" style="display:none">
                            <div class="error"><i class="iconfont">&#xe616;</i></div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="unit-left"><span class="tit">交易重量</span></div>
                    <div class="unit-mid">
                        <div class="textbox">
                            <input type="text" class="pbtxt txt0" name="weight" value="<?php echo ($search['weight']); ?>">
                            <input type="hidden" class="pbtxt txt0" name="uom_weight" data-type="uom_weight" value="<?php echo ($goods['uom_weight']); ?>">
                        </div>
                        <div class="prompt" style="display:none">
                            <div class="error"><i class="iconfont">&#xe616;</i></div>
                        </div>
                    </div>
                    <div class="unit-right"><span class="vi-blue" data-type="uom_weight"><?php echo ($goods["uom_weight"]); ?></span></div>
                </li>
                <li class="ulpd0"><div class="unit-mid">
                    <div class="textbox">
                        <span class="vi-blue" data-type="uom-weight-capital"></span>
                    </div></div>
                </li>
                <li>
                    <div class="unit-left"><span class="tit">款项登记</span></div>
                    <div class="unit-mid">
                        <select class="pbsele dropdown0" name="confirm_status" selectGroup="1" groupName="confirm_status">
                            <?php
 if(is_array($confirm_status)){ $i = 0; $__LIST__ = $confirm_status; ?>
                            <?php foreach($__LIST__ as $key=>$item): ++$i; ?>
                            <option value="<?php echo $item['code']; ?>" <?php if($item['code'] == $search['confirm_status']): ?> selected="selected" <?php endif;?>><?php echo $item['name']; ?></option>
                            <?php endforeach; ?>
                            <?php } ?>
                        </select>
                        <div class="prompt" style="display:none">
                            <div class="error"><i class="iconfont">&#xe616;</i></div>
                        </div>
                    </div>
                </li>
                <li class="border-line"></li>
                <li selectGroup="1" groupName="confirm_status" groupValue="1,2,3">
                    <div class="unit-left"><span class="tit"> 交易价格</span></div>
                    <div class="unit-mid">
                        <div class="textbox">
                            <input type="text" class="pbtxt txt0" name="price" value="<?php echo ($search['price']); ?>">
                        </div>
                        <div class="prompt" style="display:none">
                            <div class="error"><i class="iconfont">&#xe616;</i></div>
                        </div>
                    </div>
                    <div class="unit-right"><span class="vi-blue" data-type="price-uom">元/<?php echo ($goods["uom_weight"]); ?></span></div>
                </li>
                <li selectGroup="1" groupName="confirm_status" groupValue="1,2,3"><div class="unit-mid"></div> </li>
                <li selectGroup="1" groupName="confirm_status" groupValue="1,2,3">
                    <div class="unit-left"><span class="tit"> 交易金额</span></div>
                    <div class="unit-mid">
                        <div class="textbox">
                            <label class="pbtxt txt0" data-type="amount"><?php echo ($search['amount']); ?></label>
                        </div>
                        <div class="prompt" style="display:none">
                            <div class="error"><i class="iconfont">&#xe616;</i></div>
                        </div>
                    </div>
                    <div class="unit-right"><span class="vi-blue">元</span></div>
                </li>
                <li class="ulpd0"><div class="unit-mid" selectGroup="1" groupName="confirm_status" groupValue="1,2,3">
                    <div class="textbox">
                        <span class="vi-blue" data-type="capital-amount"></span>
                    </div></div>
                </li>
                <li selectGroup="1" groupName="confirm_status" groupValue="1,2,3">
                    <div class="unit-left"><span class="tit">付款截止</span></div>
                    <div class="unit-mid">
                        <select class="pbsele dropdown0" name="payment_require">
                            <option value="0" <?php if($search['payment_require'] == 0): ?> selected="selected" <?php endif;?>>选择时间</option>
                            <?php
 if(is_array($payment_require)){ $i = 0; $__LIST__ = $payment_require; ?>
                            <?php foreach($__LIST__ as $key=>$item): ++$i; ?>
                            <option value="<?php echo $item['code']; ?>" <?php if($item['code'] == $search['payment_require']): ?> selected="selected" <?php endif;?>><?php echo $item['name']; ?></option>
                            <?php endforeach; ?>
                            <?php } ?>
                        </select>
                        <div class="prompt" style="display:none">
                            <div class="error"><i class="iconfont">&#xe616;</i></div>
                        </div>
                    </div>
                </li>
                <li class="ulpd0 urpd0" selectGroup="1" groupName="confirm_status" groupValue="1,2,3"><div class="unit-mid">
                    <div class="textbox">
                        <span class="vi-red abe-ft12">买方收到订单后,请在有效截止时间内完成确认及付款。</span>
                    </div></div>
                </li>
                <li class="border-line" selectGroup="1" groupName="confirm_status" groupValue="1,2,3"></li>

                <li class="">
                    <div class="unit-left"><span class="tit"> 发货方式</span></div>
                    <div class="unit-mid">
                        <div class="dropdown">
                            <select class="pbsele dropdown0" name="delivery_type">
                                <?php
 $keyvalue = table_Trade_delivery_type(); if(is_array($keyvalue)){ $i = 0; $__LIST__ = $keyvalue; ?>
                                <?php foreach($__LIST__ as $key=>$item): ++$i; ?>
                                <option value="<?php echo $item['id']; ?>" <?php if($item['id'] == $search['delivery_type']): ?> selected="selected" <?php endif;?>><?php echo $item['name']; ?></option>
                                <?php endforeach; ?>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="prompt" style="display:none">
                            <div class="error"><i class="iconfont">&#xe616;</i></div>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="unit-left"><span class="tit">仓储费用</span></div>
                    <div class="unit-mid"> <span>
                        <input title="" type="checkbox" class="mrg_5" name="storefee_bears" value="0" <?php if($search['storefee_bears'] == 0) { ?>checked="checked"<?php } ?>>提货方承担</span>
                        <div class="prompt" style="display:none">
                            <div class="error"><i class="iconfont">&#xe616;</i></div>
                        </div>
                    </div>
                </li>
                <li class="">
                    <div class="unit-left"><span class="tit"> 发货说明</span></div>
                    <div class="unit-mid">
                        <input type="text" class="pbtxt txt0" title="" name="delivery_require" value="<?php echo ($search['delivery_require']); ?>">
                        <div class="prompt" style="display:none">
                            <div class="error"><i class="iconfont">&#xe616;</i></div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="unit-left"><span class="tit">仓储起算</span></div>
                    <div class="unit-mid">
                        <div class="calendar">
                            <input type="text" class="pbtxt calendar0" name="storefee_start" value="<?php echo ($search['storefee_start']); ?>">
                        </div>
                        <div class="prompt" style="display:none">
                            <div class="error"><i class="iconfont">&#xe616;</i></div>
                        </div>
                    </div>
                </li>
                <li class="border-line"></li>
                <li class="per100" selectGroup="1" groupName="tx_type" groupValue="1">
                    <div class="unit-left"><span class="tit"> 提货公司</span></div>
                    <div class="unit-mid">
                        <input type="text" class="pbtxt txt0" name="delivery_company" title="" value="<?php echo ($search['delivery_company']); ?>" />
                        <div class="prompt" style="display:none">
                            <div class="error"><i class="iconfont">&#xe616;</i></div>
                        </div>
                    </div>
                </li>
                <li class="per100" selectGroup="1" groupName="tx_type" groupValue="1">
                    <div class="unit-left"><span class="tit"> 提货信息</span></div>
                    <div class="unit-mid">
                        <textarea class="textarea1" name="delivery_carinfo"></textarea>
                        <div class="prompt" style="display:none">
                            <div class="error"><i class="iconfont">&#xe616;</i></div>
                        </div>
                    </div>
                    <div class="unit-right"><a href="#" class="vi-blue abe-ft12" data-type="delivery_carinfo"><u>选择</u></a></div>
                </li>
                <li class="border-line"></li>
                <li class="per100">
                    <div class="unit-left"><span class="tit"> 备注</span></div>
                    <div class="unit-mid">
                        <textarea class="textarea1" name="remarks"><?php echo ($search['remarks']); ?></textarea>
                        <div class="prompt" style="display:none">
                            <div class="error"><i class="iconfont">&#xe616;</i></div>
                        </div>
                    </div>
                </li>
            </ul>
            </form>
        </div>
    </div>
    <div class="pop-sub abe-txtc" >
        <input type="button" value="提交" class="btn btn-blue mrg_10 " onclick="return _asr.submit('<?php echo $funcid; ?>', '<?php echo $funcid; ?>-Search', '<?php echo U("/Home/Trade/index?func=save&id=$search[id]") ; ?>',''); " />
        <input type="button" value="取消" class="btn btn-org mrg_10 " onclick="$(this).parents('.prompt-pop').remove();_asr.closePopup('<?php echo ($funcid); ?>');" />
    </div>
</div>

<script>
    $(function() {
        let _funcId = "<?php echo $funcid; ?>";
        let _this = $("#" + _funcId);
        _asr.addListener(_funcId, $("#" + _funcId + " .txt-clear"), "click", function(_fid, _target) {
            return _asr.clearPopup(_target);
        });
        _asr.addListener(_funcId, _this.find("button.txt-search[data-type=buyer]"), "click", trade_add_search_buyer);
        _asr.addListener(_funcId, _this.find("button.txt-search[data-type=goods]"), "click", trade_add_search_goods);
        _asr.addListener(_funcId, _this.find("select[selectGroup][selectGroup=1]"),"change", _asr.selectGroup);
        _asr.addListener(_funcId, _this.find("input[selectGroup][selectGroup=1]"),"click", _asr.selectGroup);
        _asr.addListener(_funcId, _this.find("input[name=weight]"), "blur", trade_add_convert_capital_weight);
        _asr.addListener(_funcId, _this.find("input[name=price]"), "blur", trade_add_convert_capital_amount);
        _asr.addListener(_funcId, _this.find("input.calendar0,input.calendar1"), "click", _asr.chooseDate);
        _asr.addListener(_funcId, _this.find("a[data-type=delivery_company]"), "click", trade_add_search_company);
        _asr.addListener(_funcId, _this.find("a[data-type=delivery_carinfo]"), "click", trade_add_search_carinfo);
        _asr.selectGroup(_funcId,_this.find("select[name=confirm_status]"));
        _asr.selectGroup(_funcId,_this.find("input[name=tx_type]:checked"));
    });

    <?php echo W('Summary/javascript',array('Trade'));?>
</script>