<?php if (!defined('THINK_PATH')) exit();?>
<div toplayer="1" class="wrap-box wrap-nmd wrap-style00 " id="<?php echo $funcid;?>" summaryid="TradeSummary" baseurl="<?php echo U('TradeSummary/index'); ?>">
  <div class="wrap-box-info ">

    <div class="wrap-title abe-ofl">
      <div class="tit abe-fl" style="width: 450px;">交易开单列表</div>
      <div class="abe-fl">
        <div class="textbox" >
          <div  id="<?php echo "$funcid"; ?>-keyword-info" class="abe-fl"<?php if($search["_showsearch"]=="show"):?>style="display:none;"<?php endif; ?>>
             <input type="text" class="pbtxt txt0" id="<?php echo $funcid;?>-keyword-input" value="<?php echo $search['_keyword']; ?>"  onKeyDown="<?php echo ($funcid); ?>_keyword_keydown(this);" placeholder=" 输入关键词进行搜索 ">
             <input type="button" value="搜索" class="btn btn-org  mrg_10 " id="<?php echo $funcid;?>-keyword-search"  default-status="1"  onclick="<?php echo ($funcid); ?>_keyword_set(); return _asr.submit('<?php echo "$funcid"; ?>', '<?php echo "$funcid"; ?>-Search', '<?php echo U("TradeSummary/index?func=search&") ; ?>',''); " />
             <input id="<?php echo $funcid;?>-search-buttc" type="button" value="导出" class="btn btn-blue mrg_10 " default-status="1" onclick="return _asr.showExport('<?php echo "$funcid"; ?>', '<?php echo "$funcid"; ?>-Search', '<?php echo U("TradeSummary/index?func=export&") ; ?>',<?php echo $p ?>); " />
          </div>
          <a href="javascript:void(0);" class="mrg_15 vi-blue search-show" <?php if($search["_showsearch"]=="show"):?>style="display:none;"<?php endif; ?>><i class="iconfont">&#xe673;</i>搜索扩展</a>
        </div>
      </div>
      <div class="abe-fr">
        <a href="javascript:void(0);" class="mrg_15 vi-blue search-hide" <?php if($search["_showsearch"]=="hide"):?>style="display:none;"<?php endif; ?>><i class="iconfont">&#xe673;</i>收起搜索</a>


          <?php if (isset($rights['add']) && $rights['add']): ?>
               <input type="button" value="新增交易开单" class="btn btn-blue mrg_10 " onclick="return _asr.popupFun('<?php echo U("/Home/Trade/index?func=add&%addlink%") ; ?>', '<?php echo filterFuncId("/Home/Trade/index?func=add&%addlink%","");?>'); " />
          <?php endif; ?>



               <a href="javascript:void(0);"  class=" vi-blue " onclick="return _asr.openLink('','<?php echo "$funcid"; ?>','刷新',1); "><i class="iconfont ">&#xe611;</i> 刷新</a>

      </div>
    </div>


    <div class="screening"  >
      <form action="<?php echo U('TradeSummary/index?func=search'); ?>" id="<?php echo "$funcid"; ?>-Search" method="get">
                <input type="hidden" name="<?php echo "$funcid"; ?>-last-url" id="<?php echo "$funcid"; ?>-last-url" value="<?php echo $__last_url; ?>" />
                <input type="hidden" name="funcid" value="<?php echo "$funcid"; ?>" />
                <input type="hidden" name="pfuncid" value="<?php echo "$pfuncid"; ?>" />
                <input type="hidden" name="_searchexpand" value="<?php echo $search["_searchexpand"]; ?>" />
                <input type="hidden" name="_showsearch"   value="<?php echo $search["_showsearch"]; ?>" />
                <input type="hidden" name="_issearch" value="<?php echo $search["_issearch"]; ?>" />
                <input type="hidden" name="_keyword" value="<?php echo $search["_keyword"]; ?>" />

                <input type="hidden" name="_tab" value="<?php echo $search["_tab"]; ?>" />
                <ul class="form form-mod-new" id="<?php echo $funcid;?>-search-Info">
                  <li>
                      <div class="unit-left"> 选择状态</div>
                      <div class="unit-mid">
                          <div class="dropdown" id="<?php echo ($funcid); ?>_status">
                             <select class="pbsele dropdown0" name="status">
                                <option value="" <?php if($search['status'] == ''): ?> selected="selected" <?php endif;?> ></option>
                               <?php
 $keyvalue = table_Trade_status(); if(is_array($keyvalue)){ $i = 0; $__LIST__ = $keyvalue; ?>
                                      <?php foreach($__LIST__ as $key=>$item): ++$i; ?>
                                   <option value="<?php echo $item['id']; ?>" <?php if($item['id'] == $search['status']): ?> selected="selected" <?php endif;?>><?php echo charlevel($item['level']).$item['name']; ?></option>
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
                      <div class="unit-left"> 选择库联</div>
                      <div class="unit-mid">
                          <div class="dropdown" id="<?php echo ($funcid); ?>_org_id">
                             <select class="pbsele dropdown0" name="org_id">
                                <option value="" <?php if($search['org_id'] == ''): ?> selected="selected" <?php endif;?> ></option>
                               <?php
 $keyvalue = table_Org(); if(is_array($keyvalue)){ $i = 0; $__LIST__ = $keyvalue; ?>
                                      <?php foreach($__LIST__ as $key=>$item): ++$i; ?>
                                   <option value="<?php echo $item['id']; ?>" <?php if($item['id'] == $search['org_id']): ?> selected="selected" <?php endif;?>><?php echo charlevel($item['level']).$item['name']; ?></option>
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
                      <div class="unit-left"> 仓库编码</div>
                      <div class="unit-mid">
                          <div class="dropdown" id="<?php echo ($funcid); ?>_warehouse_code">
                             <select class="pbsele dropdown0" name="warehouse_code">
                                <option value="" <?php if($search['warehouse_code'] == ''): ?> selected="selected" <?php endif;?> ></option>
                               <?php
 $keyvalue = table_Warehouse(); if(is_array($keyvalue)){ $i = 0; $__LIST__ = $keyvalue; ?>
                                      <?php foreach($__LIST__ as $key=>$item): ++$i; ?>
                                   <option value="<?php echo $item['code']; ?>" <?php if($item['code'] == $search['warehouse_code']): ?> selected="selected" <?php endif;?>><?php echo charlevel($item['level']).$item['name']; ?></option>
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
                      <div class="unit-left"> 卖出客户</div>
                      <div class="unit-mid">
                          <div class="popup">
                              <input  type="text" class="pbtxt txt0" name="customer_id_name" readonly="readonly" value="<?php echo $search['customer_id_name']; ?>">
                              <button type="submit" class="txt-search" onclick="return _asr.popup('Customer','<?php echo "$funcid"; ?>','<?php echo "$funcid"; ?>-Search','Single','customer_id','customer_id_name'); " <?php if($search["customer_id_name"]!=""): ?> style="display:none"<?php endif; ?> ><i class="iconfont">&#xe60e;</i></button>
                              <button type="submit" class="txt-clear" onclick="_asr.setvaluebyname('<?php echo "$funcid"; ?>-Search','customer_id','');_asr.setvaluebyname('<?php echo "$funcid"; ?>-Search','customer_id_name','');return false;" <?php if($search["customer_id_name"]===""): ?> style="display:none"<?php endif; ?> ><i class="iconfont">&#xe616;</i></button>
                          </div>
                            <input type="hidden" name="customer_id" value="<?php echo $search['customer_id']; ?>">
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 卖出客户</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="customer_name"  value="<?php echo $search['customer_name']; ?>"   placeholder=" 直接进行模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 买入客户</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="buyer_id"  value="<?php echo $search['buyer_id']; ?>"  >
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 买入客户</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="buyer_name"  value="<?php echo $search['buyer_name']; ?>"   placeholder=" 直接进行模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 交易单号</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="trade_no"  value="<?php echo $search['trade_no']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 交易类型</div>
                      <div class="unit-mid">
                          <div class="dropdown" id="<?php echo ($funcid); ?>_tx_type">
                             <div class="selebtn">
                                <input type="hidden"  name="tx_type" value="<?php echo $search['tx_type']; ?>">
                                <a href="javascript:void(0);" onclick="_asr.selebtn_click(this,'');" class="<?php  echo $search['tx_type']!=""?"":"active"; ?>">全部</a>
                           <?php $keyvalue = table_Trade_tx_type(); if(is_array($keyvalue)){ $i = 0; $__LIST__ = $keyvalue; ?>
                               <?php foreach($__LIST__ as $key=>$item): ++$i; ?>
                                 <a href="javascript:void(0);" onclick="_asr.selebtn_click(this,'<?php echo $item['id'];?>');" class="<?php  echo $search['tx_type']!=$item['id']?"":"active"; ?>"><?php echo $item['name']; ?></a>
                               <?php if($i==2) break; ?>
                               <?php endforeach; ?>
                           <?php } ?>
                             </div>
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 开单日期</div>
                      <div class="unit-mid">
                          <div class="calendar">
                              <input type="text" class="pbtxt calendar1" name="tx_date"  value= "<?php echo system_format("D", $search["tx_date"],0); ?>"  >
                              <em class="space-line">-</em>
                              <input type="text" class="pbtxt calendar1" name="tx_date2" value="<?php echo $search['tx_date2']; ?>"  >
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 合同号码</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="contract_no"  value="<?php echo $search['contract_no']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 合同日期</div>
                      <div class="unit-mid">
                          <div class="calendar">
                              <input type="text" class="pbtxt calendar1" name="contract_date"  value= "<?php echo system_format("D", $search["contract_date"],0); ?>"  >
                              <em class="space-line">-</em>
                              <input type="text" class="pbtxt calendar1" name="contract_date2" value="<?php echo $search['contract_date2']; ?>"  >
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 是否实物</div>
                      <div class="unit-mid">
                          <div class="dropdown" id="<?php echo ($funcid); ?>_is_real">
                             <div class="selebtn">
                                <input type="hidden"  name="is_real" value="<?php echo $search['is_real']; ?>">
                                <a href="javascript:void(0);" onclick="_asr.selebtn_click(this,'');" class="<?php  echo $search['is_real']!=""?"":"active"; ?>">全部</a>
                           <?php $keyvalue = table_Trade_is_real(); if(is_array($keyvalue)){ $i = 0; $__LIST__ = $keyvalue; ?>
                               <?php foreach($__LIST__ as $key=>$item): ++$i; ?>
                                 <a href="javascript:void(0);" onclick="_asr.selebtn_click(this,'<?php echo $item['id'];?>');" class="<?php  echo $search['is_real']!=$item['id']?"":"active"; ?>"><?php echo $item['name']; ?></a>
                               <?php if($i==2) break; ?>
                               <?php endforeach; ?>
                           <?php } ?>
                             </div>
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 交易链</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="chain_id"  value="<?php echo $search['chain_id']; ?>"  >
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 货品编码</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="goods_no"  value="<?php echo $search['goods_no']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 货品名称</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="goods_name"  value="<?php echo $search['goods_name']; ?>"   placeholder=" 直接进行模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                </ul>
                <ul class="form form-mod-new split" style="<?php if($search["_searchexpand"]!="1"): echo "display:none"; endif; ?>">
                  <li>
                      <div class="unit-left"> 规格</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="style_info"  value="<?php echo $search['style_info']; ?>"   placeholder=" 直接进行模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 材质</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="materials"  value="<?php echo $search['materials']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 商标</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="brand"  value="<?php echo $search['brand']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 产地</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="producing_area"  value="<?php echo $search['producing_area']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 交易重量</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt1" name="weight"  value="<?php echo $search['weight']; ?>"  >
                              <em class="space-line">-</em>
                              <input type="text" class="pbtxt txt1" name="weight2" value="<?php echo $search['weight2']; ?>"  >
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 交易价格/元</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt1" name="price"  value="<?php echo $search['price']; ?>"  >
                              <em class="space-line">-</em>
                              <input type="text" class="pbtxt txt1" name="price2" value="<?php echo $search['price2']; ?>"  >
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 交易金额/元</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt1" name="amount"  value="<?php echo $search['amount']; ?>"  >
                              <em class="space-line">-</em>
                              <input type="text" class="pbtxt txt1" name="amount2" value="<?php echo $search['amount2']; ?>"  >
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 重量单位</div>
                      <div class="unit-mid">
                          <div class="dropdown" id="<?php echo ($funcid); ?>_uom_weight">
                             <select class="pbsele dropdown0" name="uom_weight">
                                <option value="" <?php if($search['uom_weight'] == ''): ?> selected="selected" <?php endif;?> ></option>
                               <?php
 $keyvalue = subcode('UOM_WEIGHT'); if(is_array($keyvalue)){ $i = 0; $__LIST__ = $keyvalue; ?>
                                      <?php foreach($__LIST__ as $key=>$item): ++$i; ?>
                                   <option value="<?php echo $item['code']; ?>" <?php if($item['code'] == $search['uom_weight']): ?> selected="selected" <?php endif;?>><?php echo charlevel($item['level']).$item['name']; ?></option>
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
                      <div class="unit-left"> 数量单位</div>
                      <div class="unit-mid">
                          <div class="dropdown" id="<?php echo ($funcid); ?>_uom_qty">
                             <select class="pbsele dropdown0" name="uom_qty">
                                <option value="" <?php if($search['uom_qty'] == ''): ?> selected="selected" <?php endif;?> ></option>
                               <?php
 $keyvalue = subcode('UOM_QTY'); if(is_array($keyvalue)){ $i = 0; $__LIST__ = $keyvalue; ?>
                                      <?php foreach($__LIST__ as $key=>$item): ++$i; ?>
                                   <option value="<?php echo $item['code']; ?>" <?php if($item['code'] == $search['uom_qty']): ?> selected="selected" <?php endif;?>><?php echo charlevel($item['level']).$item['name']; ?></option>
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
                      <div class="unit-left"> 卖家确认</div>
                      <div class="unit-mid">
                          <div class="dropdown" id="<?php echo ($funcid); ?>_cust_confirm_status">
                             <div class="selebtn">
                                <input type="hidden"  name="cust_confirm_status" value="<?php echo $search['cust_confirm_status']; ?>">
                                <a href="javascript:void(0);" onclick="_asr.selebtn_click(this,'');" class="<?php  echo $search['cust_confirm_status']!=""?"":"active"; ?>">全部</a>
                           <?php $keyvalue = table_Trade_cust_confirm_status(); if(is_array($keyvalue)){ $i = 0; $__LIST__ = $keyvalue; ?>
                               <?php foreach($__LIST__ as $key=>$item): ++$i; ?>
                                 <a href="javascript:void(0);" onclick="_asr.selebtn_click(this,'<?php echo $item['id'];?>');" class="<?php  echo $search['cust_confirm_status']!=$item['id']?"":"active"; ?>"><?php echo $item['name']; ?></a>
                               <?php if($i==2) break; ?>
                               <?php endforeach; ?>
                           <?php } ?>
                             </div>
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 卖家确认时间</div>
                      <div class="unit-mid">
                          <div class="calendar">
                              <input type="text" class="pbtxt calendar1" name="cust_confirm_time"  value= "<?php echo system_format("DT", $search["cust_confirm_time"],0); ?>"  >
                              <em class="space-line">-</em>
                              <input type="text" class="pbtxt calendar1" name="cust_confirm_time2" value="<?php echo $search['cust_confirm_time2']; ?>"  >
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 卖家确认人员</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="cust_confirm_user"  value="<?php echo $search['cust_confirm_user']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 买家确认</div>
                      <div class="unit-mid">
                          <div class="dropdown" id="<?php echo ($funcid); ?>_buyer_confirm_status">
                             <div class="selebtn">
                                <input type="hidden"  name="buyer_confirm_status" value="<?php echo $search['buyer_confirm_status']; ?>">
                                <a href="javascript:void(0);" onclick="_asr.selebtn_click(this,'');" class="<?php  echo $search['buyer_confirm_status']!=""?"":"active"; ?>">全部</a>
                           <?php $keyvalue = table_Trade_buyer_confirm_status(); if(is_array($keyvalue)){ $i = 0; $__LIST__ = $keyvalue; ?>
                               <?php foreach($__LIST__ as $key=>$item): ++$i; ?>
                                 <a href="javascript:void(0);" onclick="_asr.selebtn_click(this,'<?php echo $item['id'];?>');" class="<?php  echo $search['buyer_confirm_status']!=$item['id']?"":"active"; ?>"><?php echo $item['name']; ?></a>
                               <?php if($i==2) break; ?>
                               <?php endforeach; ?>
                           <?php } ?>
                             </div>
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 买家确认时间</div>
                      <div class="unit-mid">
                          <div class="calendar">
                              <input type="text" class="pbtxt calendar1" name="buyer_confirm_time"  value= "<?php echo system_format("DT", $search["buyer_confirm_time"],0); ?>"  >
                              <em class="space-line">-</em>
                              <input type="text" class="pbtxt calendar1" name="buyer_confirm_time2" value="<?php echo $search['buyer_confirm_time2']; ?>"  >
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 买家确认人员</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="buyer_confirm_user"  value="<?php echo $search['buyer_confirm_user']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 卖家发送</div>
                      <div class="unit-mid">
                          <div class="dropdown" id="<?php echo ($funcid); ?>_cust_send_type">
                             <div class="selebtn">
                                <input type="hidden"  name="cust_send_type" value="<?php echo $search['cust_send_type']; ?>">
                                <a href="javascript:void(0);" onclick="_asr.selebtn_click(this,'');" class="<?php  echo $search['cust_send_type']!=""?"":"active"; ?>">全部</a>
                           <?php $keyvalue = table_Trade_cust_send_type(); if(is_array($keyvalue)){ $i = 0; $__LIST__ = $keyvalue; ?>
                               <?php foreach($__LIST__ as $key=>$item): ++$i; ?>
                                 <a href="javascript:void(0);" onclick="_asr.selebtn_click(this,'<?php echo $item['id'];?>');" class="<?php  echo $search['cust_send_type']!=$item['id']?"":"active"; ?>"><?php echo $item['name']; ?></a>
                               <?php if($i==2) break; ?>
                               <?php endforeach; ?>
                           <?php } ?>
                             </div>
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 卖家发送时间</div>
                      <div class="unit-mid">
                          <div class="calendar">
                              <input type="text" class="pbtxt calendar1" name="cust_send_time"  value= "<?php echo system_format("DT", $search["cust_send_time"],0); ?>"  >
                              <em class="space-line">-</em>
                              <input type="text" class="pbtxt calendar1" name="cust_send_time2" value="<?php echo $search['cust_send_time2']; ?>"  >
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 卖家发送人员</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="cust_send_user"  value="<?php echo $search['cust_send_user']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 仓储费承担</div>
                      <div class="unit-mid">
                          <div class="dropdown" id="<?php echo ($funcid); ?>_storefee_bears">
                             <div class="selebtn">
                                <input type="hidden"  name="storefee_bears" value="<?php echo $search['storefee_bears']; ?>">
                                <a href="javascript:void(0);" onclick="_asr.selebtn_click(this,'');" class="<?php  echo $search['storefee_bears']!=""?"":"active"; ?>">全部</a>
                           <?php $keyvalue = table_Trade_storefee_bears(); if(is_array($keyvalue)){ $i = 0; $__LIST__ = $keyvalue; ?>
                               <?php foreach($__LIST__ as $key=>$item): ++$i; ?>
                                 <a href="javascript:void(0);" onclick="_asr.selebtn_click(this,'<?php echo $item['id'];?>');" class="<?php  echo $search['storefee_bears']!=$item['id']?"":"active"; ?>"><?php echo $item['name']; ?></a>
                               <?php if($i==2) break; ?>
                               <?php endforeach; ?>
                           <?php } ?>
                             </div>
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 仓储费起始/天</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt1" name="storefee_require"  value="<?php echo $search['storefee_require']; ?>"  >
                              <em class="space-line">-</em>
                              <input type="text" class="pbtxt txt1" name="storefee_require2" value="<?php echo $search['storefee_require2']; ?>"  >
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 仓储费起算日</div>
                      <div class="unit-mid">
                          <div class="calendar">
                              <input type="text" class="pbtxt calendar1" name="storefee_start"  value= "<?php echo system_format("DT", $search["storefee_start"],0); ?>"  >
                              <em class="space-line">-</em>
                              <input type="text" class="pbtxt calendar1" name="storefee_start2" value="<?php echo $search['storefee_start2']; ?>"  >
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 付款截至类型</div>
                      <div class="unit-mid">
                          <div class="dropdown" id="<?php echo ($funcid); ?>_payment_require">
                             <select class="pbsele dropdown0" name="payment_require">
                                <option value="" <?php if($search['payment_require'] == ''): ?> selected="selected" <?php endif;?> ></option>
                               <?php
 $keyvalue = table_Trade_payment_require(); if(is_array($keyvalue)){ $i = 0; $__LIST__ = $keyvalue; ?>
                                      <?php foreach($__LIST__ as $key=>$item): ++$i; ?>
                                   <option value="<?php echo $item['id']; ?>" <?php if($item['id'] == $search['payment_require']): ?> selected="selected" <?php endif;?>><?php echo charlevel($item['level']).$item['name']; ?></option>
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
                      <div class="unit-left"> 付款截至时间</div>
                      <div class="unit-mid">
                          <div class="calendar">
                              <input type="text" class="pbtxt calendar1" name="payment_expire"  value= "<?php echo system_format("DT", $search["payment_expire"],0); ?>"  >
                              <em class="space-line">-</em>
                              <input type="text" class="pbtxt calendar1" name="payment_expire2" value="<?php echo $search['payment_expire2']; ?>"  >
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 收付款登记</div>
                      <div class="unit-mid">
                          <div class="dropdown" id="<?php echo ($funcid); ?>_confirm_status">
                             <select class="pbsele dropdown0" name="confirm_status">
                                <option value="" <?php if($search['confirm_status'] == ''): ?> selected="selected" <?php endif;?> ></option>
                               <?php
 $keyvalue = table_Trade_confirm_status(); if(is_array($keyvalue)){ $i = 0; $__LIST__ = $keyvalue; ?>
                                      <?php foreach($__LIST__ as $key=>$item): ++$i; ?>
                                   <option value="<?php echo $item['id']; ?>" <?php if($item['id'] == $search['confirm_status']): ?> selected="selected" <?php endif;?>><?php echo charlevel($item['level']).$item['name']; ?></option>
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
                      <div class="unit-left"> 买家付款/元</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt1" name="confirm_payment"  value="<?php echo $search['confirm_payment']; ?>"  >
                              <em class="space-line">-</em>
                              <input type="text" class="pbtxt txt1" name="confirm_payment2" value="<?php echo $search['confirm_payment2']; ?>"  >
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 卖家收款</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt1" name="confirm_receive"  value="<?php echo $search['confirm_receive']; ?>"  >
                              <em class="space-line">-</em>
                              <input type="text" class="pbtxt txt1" name="confirm_receive2" value="<?php echo $search['confirm_receive2']; ?>"  >
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 提单号码</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="delivery_no"  value="<?php echo $search['delivery_no']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 提单日期</div>
                      <div class="unit-mid">
                          <div class="calendar">
                              <input type="text" class="pbtxt calendar1" name="delivery_date"  value= "<?php echo system_format("D", $search["delivery_date"],0); ?>"  >
                              <em class="space-line">-</em>
                              <input type="text" class="pbtxt calendar1" name="delivery_date2" value="<?php echo $search['delivery_date2']; ?>"  >
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 提单截至</div>
                      <div class="unit-mid">
                          <div class="calendar">
                              <input type="text" class="pbtxt calendar1" name="delivery_expired"  value= "<?php echo system_format("DT", $search["delivery_expired"],0); ?>"  >
                              <em class="space-line">-</em>
                              <input type="text" class="pbtxt calendar1" name="delivery_expired2" value="<?php echo $search['delivery_expired2']; ?>"  >
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 提货公司</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="delivery_company"  value="<?php echo $search['delivery_company']; ?>"   placeholder=" 直接进行模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 发货方式</div>
                      <div class="unit-mid">
                          <div class="dropdown" id="<?php echo ($funcid); ?>_delivery_type">
                             <select class="pbsele dropdown0" name="delivery_type">
                                <option value="" <?php if($search['delivery_type'] == ''): ?> selected="selected" <?php endif;?> ></option>
                               <?php
 $keyvalue = table_Trade_delivery_type(); if(is_array($keyvalue)){ $i = 0; $__LIST__ = $keyvalue; ?>
                                      <?php foreach($__LIST__ as $key=>$item): ++$i; ?>
                                   <option value="<?php echo $item['id']; ?>" <?php if($item['id'] == $search['delivery_type']): ?> selected="selected" <?php endif;?>><?php echo charlevel($item['level']).$item['name']; ?></option>
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
                      <div class="unit-left"> 配货标志</div>
                      <div class="unit-mid">
                          <div class="dropdown" id="<?php echo ($funcid); ?>_assign_status">
                             <select class="pbsele dropdown0" name="assign_status">
                                <option value="" <?php if($search['assign_status'] == ''): ?> selected="selected" <?php endif;?> ></option>
                               <?php
 $keyvalue = table_Trade_assign_status(); if(is_array($keyvalue)){ $i = 0; $__LIST__ = $keyvalue; ?>
                                      <?php foreach($__LIST__ as $key=>$item): ++$i; ?>
                                   <option value="<?php echo $item['id']; ?>" <?php if($item['id'] == $search['assign_status']): ?> selected="selected" <?php endif;?>><?php echo charlevel($item['level']).$item['name']; ?></option>
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
                      <div class="unit-left"> 配货时间</div>
                      <div class="unit-mid">
                          <div class="calendar">
                              <input type="text" class="pbtxt calendar1" name="assign_time"  value= "<?php echo system_format("DT", $search["assign_time"],0); ?>"  >
                              <em class="space-line">-</em>
                              <input type="text" class="pbtxt calendar1" name="assign_time2" value="<?php echo $search['assign_time2']; ?>"  >
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 配货人员</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="assign_user"  value="<?php echo $search['assign_user']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 配货重量</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt1" name="assign_weight"  value="<?php echo $search['assign_weight']; ?>"  >
                              <em class="space-line">-</em>
                              <input type="text" class="pbtxt txt1" name="assign_weight2" value="<?php echo $search['assign_weight2']; ?>"  >
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 配货数量/件</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt1" name="assign_qty"  value="<?php echo $search['assign_qty']; ?>"  >
                              <em class="space-line">-</em>
                              <input type="text" class="pbtxt txt1" name="assign_qty2" value="<?php echo $search['assign_qty2']; ?>"  >
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 收货卡</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="buyer_storecard_id"  value="<?php echo $search['buyer_storecard_id']; ?>"  >
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 收货卡号</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="buyer_storecard_no"  value="<?php echo $search['buyer_storecard_no']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 追加许可</div>
                      <div class="unit-mid">
                          <div class="dropdown" id="<?php echo ($funcid); ?>_buyer_storecard_allow">
                             <div class="selebtn">
                                <input type="hidden"  name="buyer_storecard_allow" value="<?php echo $search['buyer_storecard_allow']; ?>">
                                <a href="javascript:void(0);" onclick="_asr.selebtn_click(this,'');" class="<?php  echo $search['buyer_storecard_allow']!=""?"":"active"; ?>">全部</a>
                           <?php $keyvalue = table_Trade_buyer_storecard_allow(); if(is_array($keyvalue)){ $i = 0; $__LIST__ = $keyvalue; ?>
                               <?php foreach($__LIST__ as $key=>$item): ++$i; ?>
                                 <a href="javascript:void(0);" onclick="_asr.selebtn_click(this,'<?php echo $item['id'];?>');" class="<?php  echo $search['buyer_storecard_allow']!=$item['id']?"":"active"; ?>"><?php echo $item['name']; ?></a>
                               <?php if($i==2) break; ?>
                               <?php endforeach; ?>
                           <?php } ?>
                             </div>
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 实发重量</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt1" name="act_weight"  value="<?php echo $search['act_weight']; ?>"  >
                              <em class="space-line">-</em>
                              <input type="text" class="pbtxt txt1" name="act_weight2" value="<?php echo $search['act_weight2']; ?>"  >
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 实发数量/件</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt1" name="act_qty"  value="<?php echo $search['act_qty']; ?>"  >
                              <em class="space-line">-</em>
                              <input type="text" class="pbtxt txt1" name="act_qty2" value="<?php echo $search['act_qty2']; ?>"  >
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 实发时间</div>
                      <div class="unit-mid">
                          <div class="calendar">
                              <input type="text" class="pbtxt calendar1" name="act_time"  value= "<?php echo system_format("DT", $search["act_time"],0); ?>"  >
                              <em class="space-line">-</em>
                              <input type="text" class="pbtxt calendar1" name="act_time2" value="<?php echo $search['act_time2']; ?>"  >
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 实发单号</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="act_order"  value="<?php echo $search['act_order']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 重量差异</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt1" name="diff_weight"  value="<?php echo $search['diff_weight']; ?>"  >
                              <em class="space-line">-</em>
                              <input type="text" class="pbtxt txt1" name="diff_weight2" value="<?php echo $search['diff_weight2']; ?>"  >
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 差异金额/元</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt1" name="diff_amount"  value="<?php echo $search['diff_amount']; ?>"  >
                              <em class="space-line">-</em>
                              <input type="text" class="pbtxt txt1" name="diff_amount2" value="<?php echo $search['diff_amount2']; ?>"  >
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 接口状态</div>
                      <div class="unit-mid">
                          <div class="dropdown" id="<?php echo ($funcid); ?>_interface_status">
                             <select class="pbsele dropdown0" name="interface_status">
                                <option value="" <?php if($search['interface_status'] == ''): ?> selected="selected" <?php endif;?> ></option>
                               <?php
 $keyvalue = table_Trade_interface_status(); if(is_array($keyvalue)){ $i = 0; $__LIST__ = $keyvalue; ?>
                                      <?php foreach($__LIST__ as $key=>$item): ++$i; ?>
                                   <option value="<?php echo $item['id']; ?>" <?php if($item['id'] == $search['interface_status']): ?> selected="selected" <?php endif;?>><?php echo charlevel($item['level']).$item['name']; ?></option>
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
                      <div class="unit-left"> 接口处理</div>
                      <div class="unit-mid">
                          <div class="dropdown" id="<?php echo ($funcid); ?>_interface_send_status">
                             <select class="pbsele dropdown0" name="interface_send_status">
                                <option value="" <?php if($search['interface_send_status'] == ''): ?> selected="selected" <?php endif;?> ></option>
                               <?php
 $keyvalue = table_Trade_interface_send_status(); if(is_array($keyvalue)){ $i = 0; $__LIST__ = $keyvalue; ?>
                                      <?php foreach($__LIST__ as $key=>$item): ++$i; ?>
                                   <option value="<?php echo $item['id']; ?>" <?php if($item['id'] == $search['interface_send_status']): ?> selected="selected" <?php endif;?>><?php echo charlevel($item['level']).$item['name']; ?></option>
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
                      <div class="unit-left"> 接口发送时间</div>
                      <div class="unit-mid">
                          <div class="calendar">
                              <input type="text" class="pbtxt calendar1" name="interface_send_time"  value= "<?php echo system_format("DT", $search["interface_send_time"],0); ?>"  >
                              <em class="space-line">-</em>
                              <input type="text" class="pbtxt calendar1" name="interface_send_time2" value="<?php echo $search['interface_send_time2']; ?>"  >
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 接口发送次数</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt1" name="interface_send_count"  value="<?php echo $search['interface_send_count']; ?>"  >
                              <em class="space-line">-</em>
                              <input type="text" class="pbtxt txt1" name="interface_send_count2" value="<?php echo $search['interface_send_count2']; ?>"  >
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 接口返回时间</div>
                      <div class="unit-mid">
                          <div class="calendar">
                              <input type="text" class="pbtxt calendar1" name="interface_receive"  value= "<?php echo system_format("DT", $search["interface_receive"],0); ?>"  >
                              <em class="space-line">-</em>
                              <input type="text" class="pbtxt calendar1" name="interface_receive2" value="<?php echo $search['interface_receive2']; ?>"  >
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 创建时间</div>
                      <div class="unit-mid">
                          <div class="calendar">
                              <input type="text" class="pbtxt calendar1" name="create_time"  value= "<?php echo system_format("DT", $search["create_time"],0); ?>"  >
                              <em class="space-line">-</em>
                              <input type="text" class="pbtxt calendar1" name="create_time2" value="<?php echo $search['create_time2']; ?>"  >
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                </ul>
                  <!--表单-->
                  <div class="sub-box sub-box3">
                    <div class="pbtab abe-fl" >
                      <a href="#" onclick="return _asr.tabsheet('<?php echo $funcid;?>', '<?php echo "$funcid"; ?>-Search', 'all');" <?php if($search['_tab'] == 'all'): ?> class="current"<?php endif;?>>全部</a>
                      <a href="#" onclick="return _asr.tabsheet('<?php echo $funcid;?>', '<?php echo "$funcid"; ?>-Search', 'daimaijiaqueren');" <?php if($search['_tab'] == 'daimaijiaqueren'): ?> class="current"<?php endif;?>>待卖家确认</a>
                      <a href="#" onclick="return _asr.tabsheet('<?php echo $funcid;?>', '<?php echo "$funcid"; ?>-Search', 'daimaijiaqueren_2');" <?php if($search['_tab'] == 'daimaijiaqueren_2'): ?> class="current"<?php endif;?>>待买家确认</a>
                      <a href="#" onclick="return _asr.tabsheet('<?php echo $funcid;?>', '<?php echo "$funcid"; ?>-Search', 'peihuofukuanzhong');" <?php if($search['_tab'] == 'peihuofukuanzhong'): ?> class="current"<?php endif;?>>配货付款中</a>
                      <a href="#" onclick="return _asr.tabsheet('<?php echo $funcid;?>', '<?php echo "$funcid"; ?>-Search', 'daijiekouchuli');" <?php if($search['_tab'] == 'daijiekouchuli'): ?> class="current"<?php endif;?>>待接口处理</a>
                      <a href="#" onclick="return _asr.tabsheet('<?php echo $funcid;?>', '<?php echo "$funcid"; ?>-Search', 'cangkuchulizhong');" <?php if($search['_tab'] == 'cangkuchulizhong'): ?> class="current"<?php endif;?>>仓库处理中</a>
                      <a href="#" onclick="return _asr.tabsheet('<?php echo $funcid;?>', '<?php echo "$funcid"; ?>-Search', 'daikuanxiangbucha');" <?php if($search['_tab'] == 'daikuanxiangbucha'): ?> class="current"<?php endif;?>>待款项补差</a>
                      <a href="#" onclick="return _asr.tabsheet('<?php echo $funcid;?>', '<?php echo "$funcid"; ?>-Search', 'jiaoyiwancheng');" <?php if($search['_tab'] == 'jiaoyiwancheng'): ?> class="current"<?php endif;?>>交易完成</a>
                      <a href="#" onclick="return _asr.tabsheet('<?php echo $funcid;?>', '<?php echo "$funcid"; ?>-Search', 'yiquxiao');" <?php if($search['_tab'] == 'yiquxiao'): ?> class="current"<?php endif;?>>已取消</a>
                      <a href="#" onclick="return _asr.tabsheet('<?php echo $funcid;?>', '<?php echo "$funcid"; ?>-Search', 'yishixiao');" <?php if($search['_tab'] == 'yishixiao'): ?> class="current"<?php endif;?>>已失效</a>
                    </div>
                    <p class="annotation vi-red"></p>
                    <div class="sub-box-in abe-fr"  id="<?php echo $funcid;?>-search-butt">


          <?php if (isset($rights['search']) && $rights['search']): ?>
               <input type="button" value="搜索" class="btn btn-org  mrg_10 " onclick="return _asr.submit('<?php echo "$funcid"; ?>', '<?php echo "$funcid"; ?>-Search', '<?php echo U("TradeSummary/index?func=search&") ; ?>',''); " />
          <?php endif; ?>



               <input type="button" value="清除" class="btn btn-blue mrg_10 " onclick="return <?php echo "$funcid"; ?>_clearsearch('<?php echo "$funcid"; ?>-Search');" />



          <?php if (isset($rights['export']) && $rights['export']): ?>
               <input type="button" value="导出" class="btn btn-blue mrg_10 " onclick="return _asr.showExport('<?php echo "$funcid"; ?>', '<?php echo "$funcid"; ?>-Search', '<?php echo U("TradeSummary/index?func=export&") ; ?>',<?php echo $p ?>); " />
          <?php endif; ?>

                    <em class="pdr_20"></em>
                    <button class="btn btn-xs hid-btn" type="button" onclick="return _asr.showSearch(this);">展开选项<i class="iconfont">&#xe612;</i></button>
                    <a href="javascript:void(0);" class="table-set <?php echo count($colshow)>0?"vi-blue":"abe-gray3"; ?>"  onclick="return _asr.popupFun('<?php echo U("/Summary/TradeSummary/index?func=columnsetting&") ; ?>','<?php echo filterFuncId("/TradeSummary/column","");?>');  " ><em class="iconfont abe-ft14 mrg_5">&#xe60a;</em>设置</a>
                    </div>
                  </div>
      </form>
    </div>



  <div class="wrap-nmd-box">
    <div class="wrap-master ">

      <div class="list-scroll">
        <div class="table-box">
          <div class="table-in">
            <form id="<?php echo "$funcid"; ?>-Result"  action="<?php U('TradeSummary/op'); ?>" method="post">
              <table border="0" cellspacing="0" cellpadding="0" class="pub-table ta-tr-hover">
                <colgroup>
                           <col style="width: 40px ;">   <!--  -->
          <!-- 序号        <col style="width: 40px ;">   -->
                           <col style="width: 60px ; <?php if(isset($colshow[""]) && $colshow[""]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 操作 -->
                           <col style="width: 80px ; <?php if(isset($colshow["status"]) && $colshow["status"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 状态 -->
                           <col style="width: 80px ; <?php if(isset($colshow["org_id"]) && $colshow["org_id"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 库联 -->
                           <col style="width: 80px ; <?php if(isset($colshow["warehouse_code"]) && $colshow["warehouse_code"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 仓库编码 -->
                           <col style="width: 100px ; <?php if(isset($colshow["customer_name"]) && $colshow["customer_name"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 卖出客户 -->
                           <col style="width: 80px ; <?php if(isset($colshow["buyer_id"]) && $colshow["buyer_id"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 买入客户 -->
                           <col style="width: 100px ; <?php if(isset($colshow["buyer_name"]) && $colshow["buyer_name"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 买入客户 -->
                           <col style="width: 80px ; <?php if(isset($colshow["trade_no"]) && $colshow["trade_no"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 交易单号 -->
                           <col style="width: 80px ; <?php if(isset($colshow["tx_type"]) && $colshow["tx_type"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 交易类型 -->
                           <col style="width: 80px ; <?php if(isset($colshow["tx_date"]) && $colshow["tx_date"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 开单日期 -->
                           <col style="width: 80px ; <?php if(isset($colshow["contract_no"]) && $colshow["contract_no"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 合同号码 -->
                           <col style="width: 80px ; <?php if(isset($colshow["contract_date"]) && $colshow["contract_date"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 合同日期 -->
                           <col style="width: 80px ; <?php if(isset($colshow["is_real"]) && $colshow["is_real"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 实物 -->
                           <col style="width: 80px ; <?php if(isset($colshow["chain_id"]) && $colshow["chain_id"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 交易链 -->
                           <col style="width: 80px ; <?php if(isset($colshow["goods_no"]) && $colshow["goods_no"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 货品编码 -->
                           <col style="width: 100px ; <?php if(isset($colshow["goods_name"]) && $colshow["goods_name"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 货品名称 -->
                           <col style="width: 100px ; <?php if(isset($colshow["style_info"]) && $colshow["style_info"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 规格 -->
                           <col style="width: 80px ; <?php if(isset($colshow["materials"]) && $colshow["materials"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 材质 -->
                           <col style="width: 80px ; <?php if(isset($colshow["brand"]) && $colshow["brand"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 商标 -->
                           <col style="width: 80px ; <?php if(isset($colshow["producing_area"]) && $colshow["producing_area"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 产地 -->
                           <col style="width: 80px ; <?php if(isset($colshow["weight"]) && $colshow["weight"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 交易重量 -->
                           <col style="width: 100px ; <?php if(isset($colshow["price"]) && $colshow["price"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 交易价格(元) -->
                           <col style="width: 100px ; <?php if(isset($colshow["amount"]) && $colshow["amount"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 交易金额(元) -->
                           <col style="width: 80px ; <?php if(isset($colshow["uom_weight"]) && $colshow["uom_weight"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 重量单位 -->
                           <col style="width: 80px ; <?php if(isset($colshow["uom_qty"]) && $colshow["uom_qty"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 数量单位 -->
                           <col style="width: 80px ; <?php if(isset($colshow["cust_confirm_status"]) && $colshow["cust_confirm_status"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 卖家确认 -->
                           <col style="width: 150px ; <?php if(isset($colshow["cust_confirm_time"]) && $colshow["cust_confirm_time"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 卖家确认时间 -->
                           <col style="width: 100px ; <?php if(isset($colshow["cust_confirm_user"]) && $colshow["cust_confirm_user"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 卖家确认人员 -->
                           <col style="width: 80px ; <?php if(isset($colshow["buyer_confirm_status"]) && $colshow["buyer_confirm_status"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 买家确认 -->
                           <col style="width: 150px ; <?php if(isset($colshow["buyer_confirm_time"]) && $colshow["buyer_confirm_time"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 买家确认时间 -->
                           <col style="width: 100px ; <?php if(isset($colshow["buyer_confirm_user"]) && $colshow["buyer_confirm_user"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 买家确认人员 -->
                           <col style="width: 80px ; <?php if(isset($colshow["cust_send_type"]) && $colshow["cust_send_type"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 卖家发送 -->
                           <col style="width: 150px ; <?php if(isset($colshow["cust_send_time"]) && $colshow["cust_send_time"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 卖家发送时间 -->
                           <col style="width: 100px ; <?php if(isset($colshow["cust_send_user"]) && $colshow["cust_send_user"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 卖家发送人员 -->
                           <col style="width: 80px ; <?php if(isset($colshow["storefee_bears"]) && $colshow["storefee_bears"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 仓储费承担 -->
                           <col style="width: 120px ; <?php if(isset($colshow["storefee_require"]) && $colshow["storefee_require"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 仓储费起始(天) -->
                           <col style="width: 150px ; <?php if(isset($colshow["storefee_start"]) && $colshow["storefee_start"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 仓储费起算日 -->
                           <col style="width: 100px ; <?php if(isset($colshow["payment_require"]) && $colshow["payment_require"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 付款截至类型 -->
                           <col style="width: 150px ; <?php if(isset($colshow["payment_expire"]) && $colshow["payment_expire"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 付款截至时间 -->
                           <col style="width: 80px ; <?php if(isset($colshow["confirm_status"]) && $colshow["confirm_status"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 收付款登记 -->
                           <col style="width: 100px ; <?php if(isset($colshow["confirm_payment"]) && $colshow["confirm_payment"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 买家付款(元) -->
                           <col style="width: 80px ; <?php if(isset($colshow["confirm_receive"]) && $colshow["confirm_receive"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 卖家收款 -->
                           <col style="width: 80px ; <?php if(isset($colshow["delivery_no"]) && $colshow["delivery_no"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 提单号码 -->
                           <col style="width: 80px ; <?php if(isset($colshow["delivery_date"]) && $colshow["delivery_date"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 提单日期 -->
                           <col style="width: 150px ; <?php if(isset($colshow["delivery_expired"]) && $colshow["delivery_expired"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 提单截至 -->
                           <col style="width: 100px ; <?php if(isset($colshow["delivery_company"]) && $colshow["delivery_company"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 提货公司 -->
                           <col style="width: 80px ; <?php if(isset($colshow["delivery_type"]) && $colshow["delivery_type"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 发货方式 -->
                           <col style="width: 80px ; <?php if(isset($colshow["assign_status"]) && $colshow["assign_status"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 配货标志 -->
                           <col style="width: 150px ; <?php if(isset($colshow["assign_time"]) && $colshow["assign_time"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 配货时间 -->
                           <col style="width: 80px ; <?php if(isset($colshow["assign_user"]) && $colshow["assign_user"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 配货人员 -->
                           <col style="width: 80px ; <?php if(isset($colshow["assign_weight"]) && $colshow["assign_weight"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 配货重量 -->
                           <col style="width: 80px ; <?php if(isset($colshow["assign_qty"]) && $colshow["assign_qty"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 配货数量 -->
                           <col style="width: 80px ; <?php if(isset($colshow["buyer_storecard_id"]) && $colshow["buyer_storecard_id"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 收货卡 -->
                           <col style="width: 80px ; <?php if(isset($colshow["buyer_storecard_no"]) && $colshow["buyer_storecard_no"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 收货卡号 -->
                           <col style="width: 80px ; <?php if(isset($colshow["buyer_storecard_allow"]) && $colshow["buyer_storecard_allow"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 追加许可 -->
                           <col style="width: 80px ; <?php if(isset($colshow["act_weight"]) && $colshow["act_weight"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 实发重量 -->
                           <col style="width: 80px ; <?php if(isset($colshow["act_qty"]) && $colshow["act_qty"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 实发数量 -->
                           <col style="width: 150px ; <?php if(isset($colshow["act_time"]) && $colshow["act_time"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 实发时间 -->
                           <col style="width: 80px ; <?php if(isset($colshow["act_order"]) && $colshow["act_order"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 实发单号 -->
                           <col style="width: 80px ; <?php if(isset($colshow["diff_weight"]) && $colshow["diff_weight"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 重量差异 -->
                           <col style="width: 100px ; <?php if(isset($colshow["diff_amount"]) && $colshow["diff_amount"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 差异金额(元) -->
                           <col style="width: 80px ; <?php if(isset($colshow["interface_status"]) && $colshow["interface_status"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 接口状态 -->
                           <col style="width: 80px ; <?php if(isset($colshow["interface_send_status"]) && $colshow["interface_send_status"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 接口处理 -->
                           <col style="width: 150px ; <?php if(isset($colshow["interface_send_time"]) && $colshow["interface_send_time"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 接口发送时间 -->
                           <col style="width: 100px ; <?php if(isset($colshow["interface_send_count"]) && $colshow["interface_send_count"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 接口发送次数 -->
                           <col style="width: 150px ; <?php if(isset($colshow["interface_receive"]) && $colshow["interface_receive"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 接口返回时间 -->
                           <col style="width: 150px ; <?php if(isset($colshow["create_time"]) && $colshow["create_time"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 创建时间 -->
                           <col style="width:auto" >
                </colgroup>
                <tbody>
                  <tr>
                          <th><input type="checkbox"  onclick="_asr.selectAll(this);"> &nbsp;#</th>
          <!-- 序号       <th>序号</th>   -->
                          <th class="abe-txtl">操作</th>
                          <th <?php if(isset($colshow["status"]) && $colshow["status"]=="0"): ?> style="display:none" <?php endif; ?>>状态</th>
                          <th <?php if(isset($colshow["org_id"]) && $colshow["org_id"]=="0"): ?> style="display:none" <?php endif; ?>>库联</th>
                          <th <?php if(isset($colshow["warehouse_code"]) && $colshow["warehouse_code"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">仓库编码</th>
                          <th <?php if(isset($colshow["customer_name"]) && $colshow["customer_name"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">卖出客户</th>
                          <th <?php if(isset($colshow["buyer_id"]) && $colshow["buyer_id"]=="0"): ?> style="display:none" <?php endif; ?>>买入客户</th>
                          <th <?php if(isset($colshow["buyer_name"]) && $colshow["buyer_name"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">买入客户</th>
                          <th <?php if(isset($colshow["trade_no"]) && $colshow["trade_no"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">交易单号</th>
                          <th <?php if(isset($colshow["tx_type"]) && $colshow["tx_type"]=="0"): ?> style="display:none" <?php endif; ?>>交易类型</th>
                          <th <?php if(isset($colshow["tx_date"]) && $colshow["tx_date"]=="0"): ?> style="display:none" <?php endif; ?>>开单日期</th>
                          <th <?php if(isset($colshow["contract_no"]) && $colshow["contract_no"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">合同号码</th>
                          <th <?php if(isset($colshow["contract_date"]) && $colshow["contract_date"]=="0"): ?> style="display:none" <?php endif; ?>>合同日期</th>
                          <th <?php if(isset($colshow["is_real"]) && $colshow["is_real"]=="0"): ?> style="display:none" <?php endif; ?>>实物</th>
                          <th <?php if(isset($colshow["chain_id"]) && $colshow["chain_id"]=="0"): ?> style="display:none" <?php endif; ?>>交易链</th>
                          <th <?php if(isset($colshow["goods_no"]) && $colshow["goods_no"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">货品编码</th>
                          <th <?php if(isset($colshow["goods_name"]) && $colshow["goods_name"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">货品名称</th>
                          <th <?php if(isset($colshow["style_info"]) && $colshow["style_info"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">规格</th>
                          <th <?php if(isset($colshow["materials"]) && $colshow["materials"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">材质</th>
                          <th <?php if(isset($colshow["brand"]) && $colshow["brand"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">商标</th>
                          <th <?php if(isset($colshow["producing_area"]) && $colshow["producing_area"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">产地</th>
                          <th <?php if(isset($colshow["weight"]) && $colshow["weight"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtr">交易重量</th>
                          <th <?php if(isset($colshow["price"]) && $colshow["price"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtr">交易价格(元)</th>
                          <th <?php if(isset($colshow["amount"]) && $colshow["amount"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtr">交易金额(元)</th>
                          <th <?php if(isset($colshow["uom_weight"]) && $colshow["uom_weight"]=="0"): ?> style="display:none" <?php endif; ?>>重量单位</th>
                          <th <?php if(isset($colshow["uom_qty"]) && $colshow["uom_qty"]=="0"): ?> style="display:none" <?php endif; ?>>数量单位</th>
                          <th <?php if(isset($colshow["cust_confirm_status"]) && $colshow["cust_confirm_status"]=="0"): ?> style="display:none" <?php endif; ?>>卖家确认</th>
                          <th <?php if(isset($colshow["cust_confirm_time"]) && $colshow["cust_confirm_time"]=="0"): ?> style="display:none" <?php endif; ?>>卖家确认时间</th>
                          <th <?php if(isset($colshow["cust_confirm_user"]) && $colshow["cust_confirm_user"]=="0"): ?> style="display:none" <?php endif; ?>>卖家确认人员</th>
                          <th <?php if(isset($colshow["buyer_confirm_status"]) && $colshow["buyer_confirm_status"]=="0"): ?> style="display:none" <?php endif; ?>>买家确认</th>
                          <th <?php if(isset($colshow["buyer_confirm_time"]) && $colshow["buyer_confirm_time"]=="0"): ?> style="display:none" <?php endif; ?>>买家确认时间</th>
                          <th <?php if(isset($colshow["buyer_confirm_user"]) && $colshow["buyer_confirm_user"]=="0"): ?> style="display:none" <?php endif; ?>>买家确认人员</th>
                          <th <?php if(isset($colshow["cust_send_type"]) && $colshow["cust_send_type"]=="0"): ?> style="display:none" <?php endif; ?>>卖家发送</th>
                          <th <?php if(isset($colshow["cust_send_time"]) && $colshow["cust_send_time"]=="0"): ?> style="display:none" <?php endif; ?>>卖家发送时间</th>
                          <th <?php if(isset($colshow["cust_send_user"]) && $colshow["cust_send_user"]=="0"): ?> style="display:none" <?php endif; ?>>卖家发送人员</th>
                          <th <?php if(isset($colshow["storefee_bears"]) && $colshow["storefee_bears"]=="0"): ?> style="display:none" <?php endif; ?>>仓储费承担</th>
                          <th <?php if(isset($colshow["storefee_require"]) && $colshow["storefee_require"]=="0"): ?> style="display:none" <?php endif; ?>>仓储费起始(天)</th>
                          <th <?php if(isset($colshow["storefee_start"]) && $colshow["storefee_start"]=="0"): ?> style="display:none" <?php endif; ?>>仓储费起算日</th>
                          <th <?php if(isset($colshow["payment_require"]) && $colshow["payment_require"]=="0"): ?> style="display:none" <?php endif; ?>>付款截至类型</th>
                          <th <?php if(isset($colshow["payment_expire"]) && $colshow["payment_expire"]=="0"): ?> style="display:none" <?php endif; ?>>付款截至时间</th>
                          <th <?php if(isset($colshow["confirm_status"]) && $colshow["confirm_status"]=="0"): ?> style="display:none" <?php endif; ?>>收付款登记</th>
                          <th <?php if(isset($colshow["confirm_payment"]) && $colshow["confirm_payment"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtr">买家付款(元)</th>
                          <th <?php if(isset($colshow["confirm_receive"]) && $colshow["confirm_receive"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtr">卖家收款</th>
                          <th <?php if(isset($colshow["delivery_no"]) && $colshow["delivery_no"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">提单号码</th>
                          <th <?php if(isset($colshow["delivery_date"]) && $colshow["delivery_date"]=="0"): ?> style="display:none" <?php endif; ?>>提单日期</th>
                          <th <?php if(isset($colshow["delivery_expired"]) && $colshow["delivery_expired"]=="0"): ?> style="display:none" <?php endif; ?>>提单截至</th>
                          <th <?php if(isset($colshow["delivery_company"]) && $colshow["delivery_company"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">提货公司</th>
                          <th <?php if(isset($colshow["delivery_type"]) && $colshow["delivery_type"]=="0"): ?> style="display:none" <?php endif; ?>>发货方式</th>
                          <th <?php if(isset($colshow["assign_status"]) && $colshow["assign_status"]=="0"): ?> style="display:none" <?php endif; ?>>配货标志</th>
                          <th <?php if(isset($colshow["assign_time"]) && $colshow["assign_time"]=="0"): ?> style="display:none" <?php endif; ?>>配货时间</th>
                          <th <?php if(isset($colshow["assign_user"]) && $colshow["assign_user"]=="0"): ?> style="display:none" <?php endif; ?>>配货人员</th>
                          <th <?php if(isset($colshow["assign_weight"]) && $colshow["assign_weight"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtr">配货重量</th>
                          <th <?php if(isset($colshow["assign_qty"]) && $colshow["assign_qty"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtr">配货数量</th>
                          <th <?php if(isset($colshow["buyer_storecard_id"]) && $colshow["buyer_storecard_id"]=="0"): ?> style="display:none" <?php endif; ?>>收货卡</th>
                          <th <?php if(isset($colshow["buyer_storecard_no"]) && $colshow["buyer_storecard_no"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">收货卡号</th>
                          <th <?php if(isset($colshow["buyer_storecard_allow"]) && $colshow["buyer_storecard_allow"]=="0"): ?> style="display:none" <?php endif; ?>>追加许可</th>
                          <th <?php if(isset($colshow["act_weight"]) && $colshow["act_weight"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtr">实发重量</th>
                          <th <?php if(isset($colshow["act_qty"]) && $colshow["act_qty"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtr">实发数量</th>
                          <th <?php if(isset($colshow["act_time"]) && $colshow["act_time"]=="0"): ?> style="display:none" <?php endif; ?>>实发时间</th>
                          <th <?php if(isset($colshow["act_order"]) && $colshow["act_order"]=="0"): ?> style="display:none" <?php endif; ?>>实发单号</th>
                          <th <?php if(isset($colshow["diff_weight"]) && $colshow["diff_weight"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtr">重量差异</th>
                          <th <?php if(isset($colshow["diff_amount"]) && $colshow["diff_amount"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtr">差异金额(元)</th>
                          <th <?php if(isset($colshow["interface_status"]) && $colshow["interface_status"]=="0"): ?> style="display:none" <?php endif; ?>>接口状态</th>
                          <th <?php if(isset($colshow["interface_send_status"]) && $colshow["interface_send_status"]=="0"): ?> style="display:none" <?php endif; ?>>接口处理</th>
                          <th <?php if(isset($colshow["interface_send_time"]) && $colshow["interface_send_time"]=="0"): ?> style="display:none" <?php endif; ?>>接口发送时间</th>
                          <th <?php if(isset($colshow["interface_send_count"]) && $colshow["interface_send_count"]=="0"): ?> style="display:none" <?php endif; ?>>接口发送次数</th>
                          <th <?php if(isset($colshow["interface_receive"]) && $colshow["interface_receive"]=="0"): ?> style="display:none" <?php endif; ?>>接口返回时间</th>
                          <th <?php if(isset($colshow["create_time"]) && $colshow["create_time"]=="0"): ?> style="display:none" <?php endif; ?>>创建时间</th>
                           <th></th >
                        </tr>
                        <?php $parent_trNo=""; $group=""; $groupId="";?>
                        <?php if(is_array($list)): $i = 0; $__LIST__ = $list; if( count($__LIST__) == 0) : echo ""; else: foreach($__LIST__ as $key=>$master): $mod = ($i % 2 );++$i; ?>
                                  <?php $seqNo = $i + ($page_size * ($p - 1)); ?>

                                  <?php $trColor = $mod=="1"?"even":"odd"; ?>
                                  <?php $trNo=($parent_trNo?$parent_trNo.".":"").$seqNo; ?>
                                  <tr class="<?php echo $trColor; ?>" group="<?php echo $group; ?>" group-id="<?php echo $groupId; ?>">
                                  <!-- 选择 -->
                                  <td class="abe-txtl"><input type="checkbox" name="Key[]" data-type="select" onclick="_asr.selectMulit(this);" value="<?php echo $master['id'] ;?>">&nbsp;<?php echo $trNo; ?></td>
                                  <!-- 序号 -->
                                  <td  class=" abe-txtl ">



          <?php if (isset($rights['master_view']) && $rights['master_view']): ?>
               <a href="javascript:void(0);"  class=" vi-blue vi-blue " onclick="return _asr.openLink('<?php echo U("/Home/Trade/index?func=view&id=$master[id]") ; ?>', '<?php echo filterFuncId(U("/Home/Trade/index?func=view&id=$master[id]"),"");?>' , '<?php echo tabTitle("交易","$master[trade_no]","RIGHT","8") ; ?>' ,0); "><i class="iconfont abe-ft18">&#xe62e;</i></a>
          <?php endif; ?>





          <?php if (isset($rights['master_edit']) && $rights['master_edit']): ?>
          <?php if ($master['status']==0): ?>
               <a href="javascript:void(0);"  class=" vi-blue vi-blue " onclick="return _asr.popupFun('<?php echo U("/Home/Trade/index?func=edit&id=$master[id]") ; ?>', '<?php echo filterFuncId("/Home/Trade/index?func=edit&id=$master[id]","");?>'); "><i class="iconfont abe-ft15">&#xe63f;</i></a>
          <?php endif; ?>
          <?php endif; ?>





          <?php if (isset($rights['master_delete']) && $rights['master_delete']): ?>
          <?php if ($master['status']==0): ?>
               <a href="javascript:void(0);"  class=" vi-blue vi-blue " onclick="return _asr.confirm('确认操作', '请确认是否删除交易开单?', '<?php echo "交易开单 : $master[trade_no]"; ?>', '<?php echo U("/Home/Trade/index?func=delete&type=1&id=$master[id]") ; ?>','',''); "><i class="iconfont vi-red">&#xe61d;</i></a>
          <?php endif; ?>
          <?php endif; ?></td>


                                  <td style=" <?php if(isset($colshow["status"]) && $colshow["status"]=="0"): ?>display:none<?php endif; ?> " ><?php echo get_table_Trade_status("$master[status]","name","") ; ?></td>
                                  <td style=" <?php if(isset($colshow["org_id"]) && $colshow["org_id"]=="0"): ?>display:none<?php endif; ?> " ><?php echo get_table_Org_byID("$master[org_id]","name","") ; ?></td>
                                  <td style=" <?php if(isset($colshow["warehouse_code"]) && $colshow["warehouse_code"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo get_table_Warehouse("$master[warehouse_code]","name","") ; ?></td>
                                  <td style=" <?php if(isset($colshow["customer_name"]) && $colshow["customer_name"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["customer_name"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["buyer_id"]) && $colshow["buyer_id"]=="0"): ?>display:none<?php endif; ?> " ><?php echo $master["buyer_id"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["buyer_name"]) && $colshow["buyer_name"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["buyer_name"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["trade_no"]) && $colshow["trade_no"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><a href="javascript:void(0);" class="vi-blue"  onclick="return _asr.openLink('<?php echo U("/Home/Trade/index?func=view&id=$master[id]"); ?>','<?php echo filterFuncId( U("/Home/Trade/index?func=view&id=$master[id]") ,"");?>', '<?php echo tabTitle("交易","$master[trade_no]","RIGHT","8") ; ?>' ,0); " ><?php echo $master["trade_no"] ; ?></a></td>
                                  <td style=" <?php if(isset($colshow["tx_type"]) && $colshow["tx_type"]=="0"): ?>display:none<?php endif; ?> " ><?php echo get_table_Trade_tx_type("$master[tx_type]","name","") ; ?></td>
                                  <td style=" <?php if(isset($colshow["tx_date"]) && $colshow["tx_date"]=="0"): ?>display:none<?php endif; ?> " ><?php echo system_format("D", $master["tx_date"],1) ; ?></td>
                                  <td style=" <?php if(isset($colshow["contract_no"]) && $colshow["contract_no"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["contract_no"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["contract_date"]) && $colshow["contract_date"]=="0"): ?>display:none<?php endif; ?> " ><?php echo system_format("D", $master["contract_date"],1) ; ?></td>
                                  <td style=" <?php if(isset($colshow["is_real"]) && $colshow["is_real"]=="0"): ?>display:none<?php endif; ?> " ><?php echo get_table_Trade_is_real("$master[is_real]","name","") ; ?></td>
                                  <td style=" <?php if(isset($colshow["chain_id"]) && $colshow["chain_id"]=="0"): ?>display:none<?php endif; ?> " ><?php echo $master["chain_id"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["goods_no"]) && $colshow["goods_no"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["goods_no"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["goods_name"]) && $colshow["goods_name"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["goods_name"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["style_info"]) && $colshow["style_info"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["style_info"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["materials"]) && $colshow["materials"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["materials"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["brand"]) && $colshow["brand"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["brand"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["producing_area"]) && $colshow["producing_area"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["producing_area"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["weight"]) && $colshow["weight"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtr <?php if ($master['weight']<0): ?> abe-red <?php endif; ?> "><?php echo system_format("F33", $master["weight"],1) ; ?></td>
                                  <td style=" <?php if(isset($colshow["price"]) && $colshow["price"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtr "><?php echo system_format("F33", $master["price"],1) ; ?></td>
                                  <td style=" <?php if(isset($colshow["amount"]) && $colshow["amount"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtr <?php if ($master['amount']<0): ?> abe-red <?php endif; ?> "><?php echo system_format("F32", $master["amount"],1) ; ?></td>
                                  <td style=" <?php if(isset($colshow["uom_weight"]) && $colshow["uom_weight"]=="0"): ?>display:none<?php endif; ?> " ><?php echo $master["uom_weight"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["uom_qty"]) && $colshow["uom_qty"]=="0"): ?>display:none<?php endif; ?> " ><?php echo $master["uom_qty"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["cust_confirm_status"]) && $colshow["cust_confirm_status"]=="0"): ?>display:none<?php endif; ?> " ><?php echo get_table_Trade_cust_confirm_status("$master[cust_confirm_status]","name","") ; ?></td>
                                  <td style=" <?php if(isset($colshow["cust_confirm_time"]) && $colshow["cust_confirm_time"]=="0"): ?>display:none<?php endif; ?> " ><?php echo system_format("DT", $master["cust_confirm_time"],1) ; ?></td>
                                  <td style=" <?php if(isset($colshow["cust_confirm_user"]) && $colshow["cust_confirm_user"]=="0"): ?>display:none<?php endif; ?> " ><?php echo $master["cust_confirm_user"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["buyer_confirm_status"]) && $colshow["buyer_confirm_status"]=="0"): ?>display:none<?php endif; ?> " ><?php echo get_table_Trade_buyer_confirm_status("$master[buyer_confirm_status]","name","") ; ?></td>
                                  <td style=" <?php if(isset($colshow["buyer_confirm_time"]) && $colshow["buyer_confirm_time"]=="0"): ?>display:none<?php endif; ?> " ><?php echo system_format("DT", $master["buyer_confirm_time"],1) ; ?></td>
                                  <td style=" <?php if(isset($colshow["buyer_confirm_user"]) && $colshow["buyer_confirm_user"]=="0"): ?>display:none<?php endif; ?> " ><?php echo $master["buyer_confirm_user"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["cust_send_type"]) && $colshow["cust_send_type"]=="0"): ?>display:none<?php endif; ?> " ><?php echo get_table_Trade_cust_send_type("$master[cust_send_type]","name","") ; ?></td>
                                  <td style=" <?php if(isset($colshow["cust_send_time"]) && $colshow["cust_send_time"]=="0"): ?>display:none<?php endif; ?> " ><?php echo system_format("DT", $master["cust_send_time"],1) ; ?></td>
                                  <td style=" <?php if(isset($colshow["cust_send_user"]) && $colshow["cust_send_user"]=="0"): ?>display:none<?php endif; ?> " ><?php echo $master["cust_send_user"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["storefee_bears"]) && $colshow["storefee_bears"]=="0"): ?>display:none<?php endif; ?> " ><?php echo get_table_Trade_storefee_bears("$master[storefee_bears]","name","") ; ?></td>
                                  <td style=" <?php if(isset($colshow["storefee_require"]) && $colshow["storefee_require"]=="0"): ?>display:none<?php endif; ?> " class=" <?php if ($master['storefee_require']<0): ?> abe-red <?php endif; ?> "><?php echo system_format("N3", $master["storefee_require"],1) ; ?></td>
                                  <td style=" <?php if(isset($colshow["storefee_start"]) && $colshow["storefee_start"]=="0"): ?>display:none<?php endif; ?> " ><?php echo system_format("DT", $master["storefee_start"],1) ; ?></td>
                                  <td style=" <?php if(isset($colshow["payment_require"]) && $colshow["payment_require"]=="0"): ?>display:none<?php endif; ?> " class=" <?php if ($master['payment_require']<0): ?> abe-red <?php endif; ?> "><?php echo system_format("N3", $master["payment_require"],1) ; ?></td>
                                  <td style=" <?php if(isset($colshow["payment_expire"]) && $colshow["payment_expire"]=="0"): ?>display:none<?php endif; ?> " ><?php echo system_format("DT", $master["payment_expire"],1) ; ?></td>
                                  <td style=" <?php if(isset($colshow["confirm_status"]) && $colshow["confirm_status"]=="0"): ?>display:none<?php endif; ?> " ><?php echo get_table_Trade_confirm_status("$master[confirm_status]","name","") ; ?></td>
                                  <td style=" <?php if(isset($colshow["confirm_payment"]) && $colshow["confirm_payment"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtr <?php if ($master['confirm_payment']<0): ?> abe-red <?php endif; ?> "><?php echo system_format("F32", $master["confirm_payment"],1) ; ?></td>
                                  <td style=" <?php if(isset($colshow["confirm_receive"]) && $colshow["confirm_receive"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtr <?php if ($master['confirm_receive']<0): ?> abe-red <?php endif; ?> "><?php echo system_format("F32", $master["confirm_receive"],1) ; ?></td>
                                  <td style=" <?php if(isset($colshow["delivery_no"]) && $colshow["delivery_no"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["delivery_no"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["delivery_date"]) && $colshow["delivery_date"]=="0"): ?>display:none<?php endif; ?> " ><?php echo system_format("D", $master["delivery_date"],1) ; ?></td>
                                  <td style=" <?php if(isset($colshow["delivery_expired"]) && $colshow["delivery_expired"]=="0"): ?>display:none<?php endif; ?> " ><?php echo system_format("DT", $master["delivery_expired"],1) ; ?></td>
                                  <td style=" <?php if(isset($colshow["delivery_company"]) && $colshow["delivery_company"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["delivery_company"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["delivery_type"]) && $colshow["delivery_type"]=="0"): ?>display:none<?php endif; ?> " ><?php echo get_table_Trade_delivery_type("$master[delivery_type]","name","") ; ?></td>
                                  <td style=" <?php if(isset($colshow["assign_status"]) && $colshow["assign_status"]=="0"): ?>display:none<?php endif; ?> " ><?php echo get_table_Trade_assign_status("$master[assign_status]","name","") ; ?></td>
                                  <td style=" <?php if(isset($colshow["assign_time"]) && $colshow["assign_time"]=="0"): ?>display:none<?php endif; ?> " ><?php echo system_format("DT", $master["assign_time"],1) ; ?></td>
                                  <td style=" <?php if(isset($colshow["assign_user"]) && $colshow["assign_user"]=="0"): ?>display:none<?php endif; ?> " ><?php echo $master["assign_user"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["assign_weight"]) && $colshow["assign_weight"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtr <?php if ($master['assign_weight']<0): ?> abe-red <?php endif; ?> "><?php echo system_format("F33", $master["assign_weight"],1) ; ?></td>
                                  <td style=" <?php if(isset($colshow["assign_qty"]) && $colshow["assign_qty"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtr <?php if ($master['assign_qty']<0): ?> abe-red <?php endif; ?> "><?php echo system_format("N3", $master["assign_qty"],1) ; ?></td>
                                  <td style=" <?php if(isset($colshow["buyer_storecard_id"]) && $colshow["buyer_storecard_id"]=="0"): ?>display:none<?php endif; ?> " ><?php echo $master["buyer_storecard_id"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["buyer_storecard_no"]) && $colshow["buyer_storecard_no"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["buyer_storecard_no"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["buyer_storecard_allow"]) && $colshow["buyer_storecard_allow"]=="0"): ?>display:none<?php endif; ?> " ><?php echo get_table_Trade_buyer_storecard_allow("$master[buyer_storecard_allow]","name","") ; ?></td>
                                  <td style=" <?php if(isset($colshow["act_weight"]) && $colshow["act_weight"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtr <?php if ($master['act_weight']<0): ?> abe-red <?php endif; ?> "><?php echo system_format("F33", $master["act_weight"],1) ; ?></td>
                                  <td style=" <?php if(isset($colshow["act_qty"]) && $colshow["act_qty"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtr <?php if ($master['act_qty']<0): ?> abe-red <?php endif; ?> "><?php echo system_format("N3", $master["act_qty"],1) ; ?></td>
                                  <td style=" <?php if(isset($colshow["act_time"]) && $colshow["act_time"]=="0"): ?>display:none<?php endif; ?> " ><?php echo system_format("DT", $master["act_time"],1) ; ?></td>
                                  <td style=" <?php if(isset($colshow["act_order"]) && $colshow["act_order"]=="0"): ?>display:none<?php endif; ?> " ><?php echo $master["act_order"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["diff_weight"]) && $colshow["diff_weight"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtr <?php if ($master['diff_weight']<0): ?> abe-red <?php endif; ?> "><?php echo system_format("F33", $master["diff_weight"],1) ; ?></td>
                                  <td style=" <?php if(isset($colshow["diff_amount"]) && $colshow["diff_amount"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtr <?php if ($master['diff_amount']<0): ?> abe-red <?php endif; ?> "><?php echo system_format("F32", $master["diff_amount"],1) ; ?></td>
                                  <td style=" <?php if(isset($colshow["interface_status"]) && $colshow["interface_status"]=="0"): ?>display:none<?php endif; ?> " ><?php echo get_table_Trade_interface_status("$master[interface_status]","name","") ; ?></td>
                                  <td style=" <?php if(isset($colshow["interface_send_status"]) && $colshow["interface_send_status"]=="0"): ?>display:none<?php endif; ?> " ><?php echo get_table_Trade_interface_send_status("$master[interface_send_status]","name","") ; ?></td>
                                  <td style=" <?php if(isset($colshow["interface_send_time"]) && $colshow["interface_send_time"]=="0"): ?>display:none<?php endif; ?> " ><?php echo system_format("DT", $master["interface_send_time"],1) ; ?></td>
                                  <td style=" <?php if(isset($colshow["interface_send_count"]) && $colshow["interface_send_count"]=="0"): ?>display:none<?php endif; ?> " class=" <?php if ($master['interface_send_count']<0): ?> abe-red <?php endif; ?> "><?php echo system_format("N3", $master["interface_send_count"],1) ; ?></td>
                                  <td style=" <?php if(isset($colshow["interface_receive"]) && $colshow["interface_receive"]=="0"): ?>display:none<?php endif; ?> " ><?php echo system_format("DT", $master["interface_receive"],1) ; ?></td>
                                  <td style=" <?php if(isset($colshow["create_time"]) && $colshow["create_time"]=="0"): ?>display:none<?php endif; ?> " ><?php echo system_format("DT", $master["create_time"],1) ; ?></td>
                                 <td></td>
                              </tr>
                              <?php endforeach; ?>
                              <?php
 endif; else: echo "" ;endif; ?>
                </tbody>
              </table>
            </form>
          </div>
        <?php if($search["_execsearch"] == "0"): ?>
          <div style="background: #f2f2f3; color: #999; text-align: center; font-size: 14px; padding: 20px 0; margin-top:10px;">搜索后显示数据</div>
        <?php endif; ?>
        </div>



        <div class="data-oper" >
          <?php echo $page; ?>
        </div>

      </div>


   </div>


  </div>

  </div>
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


        function <?php echo $funcid; ?>_keyword_set(){
            _frm = "<?php echo $funcid;?>-Search";
            var _this = $("#<?php echo $funcid;?>-keyword-input");
            _asr.setvaluebyname(_frm,"_keyword",_this.val());
            return true;
        }

        function <?php echo ($funcid); ?>_keyword_keydown(obj){
            var e = window.event || arguments.callee.caller.arguments[0];
            if (e && e.keyCode == 13 ) {
                  <?php echo $funcid; ?>_keyword_set();
                $("#<?php echo ($funcid); ?>-keyword-search").click();
            }
        }
        /***************************************************************************************/
        /* 前台页面初始化                                                                      */
        /***************************************************************************************/
        function <?php echo $funcid; ?>_init(_id){
            var _searchInfo, searchbutt, _searchshow,_searchhide,_searchkeyword;
            _searchhide = $("#<?php echo $funcid;?> .search-hide");
            _searchshow = $("#<?php echo $funcid;?> .search-show");
            _searchInfo = $("#<?php echo $funcid;?>-search-Info");
            _searchbutt = $("#<?php echo $funcid;?>-search-butt");
            _searchkeyword = $("#<?php echo $funcid;?>-keyword-info");
            _frm = "<?php echo $funcid;?>-Search";
            _searchshow.bind("click", function() {
                _searchInfo.show();
                _searchbutt.show();
                _searchshow.hide();
                _searchhide.show();
                _searchkeyword.hide();
                _asr.setvaluebyname(_frm,"_showsearch","show");
            });
            _searchhide.bind("click", function() {
                _searchInfo.hide();
                _searchbutt.hide();
                _searchshow.show();
                _searchhide.hide();
                _searchkeyword.show();
                _asr.setvaluebyname(_frm,"_showsearch","hide");
            });

        <?php if($search["_showsearch"]=="show"):?>
            _searchshow.click();
        <?php else: ?>
            _searchhide.click();
        <?php endif; ?>

            return false;
        }


        /***************************************************************************************/
        /* 前台页面清除                                                                      */
        /***************************************************************************************/
        function <?php echo $funcid; ?>_clearsearch(_frm){
            _asr.setvaluebyname(_frm,"status","");
            _asr.setvaluebyname(_frm,"org_id","");
            _asr.setvaluebyname(_frm,"warehouse_code","");
            _asr.setvaluebyname(_frm,"customer_id_name","");
            _asr.setvaluebyname(_frm,"customer_id","");
            _asr.setvaluebyname(_frm,"customer_name","");
            _asr.setvaluebyname(_frm,"buyer_id","");
            _asr.setvaluebyname(_frm,"buyer_name","");
            _asr.setvaluebyname(_frm,"trade_no","");
            _asr.setvaluebyname(_frm,"tx_type","");
            _asr.setvaluebyname(_frm,"tx_date","");
            _asr.setvaluebyname(_frm,"tx_date2","");
            _asr.setvaluebyname(_frm,"contract_no","");
            _asr.setvaluebyname(_frm,"contract_date","");
            _asr.setvaluebyname(_frm,"contract_date2","");
            _asr.setvaluebyname(_frm,"is_real","");
            _asr.setvaluebyname(_frm,"chain_id","");
            _asr.setvaluebyname(_frm,"goods_no","");
            _asr.setvaluebyname(_frm,"goods_name","");
            _asr.setvaluebyname(_frm,"style_info","");
            _asr.setvaluebyname(_frm,"materials","");
            _asr.setvaluebyname(_frm,"brand","");
            _asr.setvaluebyname(_frm,"producing_area","");
            _asr.setvaluebyname(_frm,"weight","");
            _asr.setvaluebyname(_frm,"weight2","");
            _asr.setvaluebyname(_frm,"price","");
            _asr.setvaluebyname(_frm,"price2","");
            _asr.setvaluebyname(_frm,"amount","");
            _asr.setvaluebyname(_frm,"amount2","");
            _asr.setvaluebyname(_frm,"uom_weight","");
            _asr.setvaluebyname(_frm,"uom_qty","");
            _asr.setvaluebyname(_frm,"cust_confirm_status","");
            _asr.setvaluebyname(_frm,"cust_confirm_time","");
            _asr.setvaluebyname(_frm,"cust_confirm_time2","");
            _asr.setvaluebyname(_frm,"cust_confirm_user","");
            _asr.setvaluebyname(_frm,"buyer_confirm_status","");
            _asr.setvaluebyname(_frm,"buyer_confirm_time","");
            _asr.setvaluebyname(_frm,"buyer_confirm_time2","");
            _asr.setvaluebyname(_frm,"buyer_confirm_user","");
            _asr.setvaluebyname(_frm,"cust_send_type","");
            _asr.setvaluebyname(_frm,"cust_send_time","");
            _asr.setvaluebyname(_frm,"cust_send_time2","");
            _asr.setvaluebyname(_frm,"cust_send_user","");
            _asr.setvaluebyname(_frm,"storefee_bears","");
            _asr.setvaluebyname(_frm,"storefee_require","");
            _asr.setvaluebyname(_frm,"storefee_require2","");
            _asr.setvaluebyname(_frm,"storefee_start","");
            _asr.setvaluebyname(_frm,"storefee_start2","");
            _asr.setvaluebyname(_frm,"payment_require","");
            _asr.setvaluebyname(_frm,"payment_expire","");
            _asr.setvaluebyname(_frm,"payment_expire2","");
            _asr.setvaluebyname(_frm,"confirm_status","");
            _asr.setvaluebyname(_frm,"confirm_payment","");
            _asr.setvaluebyname(_frm,"confirm_payment2","");
            _asr.setvaluebyname(_frm,"confirm_receive","");
            _asr.setvaluebyname(_frm,"confirm_receive2","");
            _asr.setvaluebyname(_frm,"delivery_no","");
            _asr.setvaluebyname(_frm,"delivery_date","");
            _asr.setvaluebyname(_frm,"delivery_date2","");
            _asr.setvaluebyname(_frm,"delivery_expired","");
            _asr.setvaluebyname(_frm,"delivery_expired2","");
            _asr.setvaluebyname(_frm,"delivery_company","");
            _asr.setvaluebyname(_frm,"delivery_type","");
            _asr.setvaluebyname(_frm,"assign_status","");
            _asr.setvaluebyname(_frm,"assign_time","");
            _asr.setvaluebyname(_frm,"assign_time2","");
            _asr.setvaluebyname(_frm,"assign_user","");
            _asr.setvaluebyname(_frm,"assign_weight","");
            _asr.setvaluebyname(_frm,"assign_weight2","");
            _asr.setvaluebyname(_frm,"assign_qty","");
            _asr.setvaluebyname(_frm,"assign_qty2","");
            _asr.setvaluebyname(_frm,"buyer_storecard_id","");
            _asr.setvaluebyname(_frm,"buyer_storecard_no","");
            _asr.setvaluebyname(_frm,"buyer_storecard_allow","");
            _asr.setvaluebyname(_frm,"act_weight","");
            _asr.setvaluebyname(_frm,"act_weight2","");
            _asr.setvaluebyname(_frm,"act_qty","");
            _asr.setvaluebyname(_frm,"act_qty2","");
            _asr.setvaluebyname(_frm,"act_time","");
            _asr.setvaluebyname(_frm,"act_time2","");
            _asr.setvaluebyname(_frm,"act_order","");
            _asr.setvaluebyname(_frm,"diff_weight","");
            _asr.setvaluebyname(_frm,"diff_weight2","");
            _asr.setvaluebyname(_frm,"diff_amount","");
            _asr.setvaluebyname(_frm,"diff_amount2","");
            _asr.setvaluebyname(_frm,"interface_status","");
            _asr.setvaluebyname(_frm,"interface_send_status","");
            _asr.setvaluebyname(_frm,"interface_send_time","");
            _asr.setvaluebyname(_frm,"interface_send_time2","");
            _asr.setvaluebyname(_frm,"interface_send_count","");
            _asr.setvaluebyname(_frm,"interface_send_count2","");
            _asr.setvaluebyname(_frm,"interface_receive","");
            _asr.setvaluebyname(_frm,"interface_receive2","");
            _asr.setvaluebyname(_frm,"create_time","");
            _asr.setvaluebyname(_frm,"create_time2","");

          $("#<?php echo ($funcid); ?>").find(".selebtn").each(function(){
              $(this).find("a:eq(0)").click();
            });

          $("#<?php echo ($funcid); ?> .city-tags-new .sele-remove").click();
        }

        /***************************************************************************************/
        /* 后台返回 callback                                                                 */
        /***************************************************************************************/
        function <?php echo $funcid; ?>_callback(_json){
        // 返回类型 _json.action
        // 返回数据 _json.data
            switch(_json.action){
            default:
                alert("no code for callback action '" + _json.action + "'");
                break;
            }
            return ;
        }

        /***************************************************************************************/
        /* 后台返回 dealAlert                                                            */
        /***************************************************************************************/
        function <?php echo "$funcid"; ?>_dealAlert(l){
            var node=$('#'+l.getAlertId());

            var funcid="<?php echo "$funcid"; ?>";
            $('#'+funcid+"-Search input[type='button']").eq(0).click();

            node.on('click','input[type="button"]',function(){
                $('#'+l.getFormId()).parent().show();
                l.close(2);
            });

            node.on('click','input[type="submit"]',function(){
                $('#'+l.getFormId()).parent().show();
                l.close(2);
                if(!l.isErr){
                    $('#'+l.getFormId()).parent().find('a.close').click()
                }
            });

            node.on('click','a.close ',function(){
                $('#'+l.getFormId()).parent().show();
                l.close(2);
            });
        }


    <?php echo W('Summary/javascript',array('TradeSummary'));?>


    </script>