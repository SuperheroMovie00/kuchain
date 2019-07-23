<?php if (!defined('THINK_PATH')) exit();?>
<div toplayer="1" class="wrap-box wrap-nmd wrap-style00 " id="<?php echo $funcid;?>" summaryid="TransferSummary" baseurl="<?php echo U('TransferSummary/index'); ?>">
  <div class="wrap-box-info ">

    <div class="wrap-title abe-ofl">
      <div class="tit abe-fl" style="width: 450px;">过户列表</div>
      <div class="abe-fl">
        <div class="textbox" >
          <div  id="<?php echo "$funcid"; ?>-keyword-info" class="abe-fl"<?php if($search["_showsearch"]=="show"):?>style="display:none;"<?php endif; ?>>
             <input type="text" class="pbtxt txt0" id="<?php echo $funcid;?>-keyword-input" value="<?php echo $search['_keyword']; ?>"  onKeyDown="<?php echo ($funcid); ?>_keyword_keydown(this);" placeholder=" 输入关键词进行搜索 ">
             <input type="button" value="搜索" class="btn btn-org  mrg_10 " id="<?php echo $funcid;?>-keyword-search"  default-status="1"  onclick="<?php echo ($funcid); ?>_keyword_set(); return _asr.submit('<?php echo "$funcid"; ?>', '<?php echo "$funcid"; ?>-Search', '<?php echo U("TransferSummary/index?func=search&") ; ?>',''); " />
             <input id="<?php echo $funcid;?>-search-buttc" type="button" value="导出" class="btn btn-blue mrg_10 " default-status="1" onclick="return _asr.showExport('<?php echo "$funcid"; ?>', '<?php echo "$funcid"; ?>-Search', '<?php echo U("TransferSummary/index?func=export&") ; ?>',<?php echo $p ?>); " />
          </div>
          <a href="javascript:void(0);" class="mrg_15 vi-blue search-show" <?php if($search["_showsearch"]=="show"):?>style="display:none;"<?php endif; ?>><i class="iconfont">&#xe673;</i>搜索扩展</a>
        </div>
      </div>
      <div class="abe-fr">
        <a href="javascript:void(0);" class="mrg_15 vi-blue search-hide" <?php if($search["_showsearch"]=="hide"):?>style="display:none;"<?php endif; ?>><i class="iconfont">&#xe673;</i>收起搜索</a>


               <a href="javascript:void(0);"  class=" vi-blue " onclick="return _asr.openLink('','<?php echo "$funcid"; ?>','刷新',1); "><i class="iconfont ">&#xe611;</i> 刷新</a>

      </div>
    </div>


    <div class="screening"  >
      <form action="<?php echo U('TransferSummary/index?func=search'); ?>" id="<?php echo "$funcid"; ?>-Search" method="get">
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
 $keyvalue = table_Transfer_status(); if(is_array($keyvalue)){ $i = 0; $__LIST__ = $keyvalue; ?>
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
                      <div class="unit-left"> 选择库链</div>
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
                      <div class="unit-left"> 选择客户</div>
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
                      <div class="unit-left"> 客户名称</div>
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
                      <div class="unit-left"> 过户单号</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="transfer_no"  value="<?php echo $search['transfer_no']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 过户日期</div>
                      <div class="unit-mid">
                          <div class="calendar">
                              <input type="text" class="pbtxt calendar1" name="transfer_date"  value= "<?php echo system_format("D", $search["transfer_date"],0); ?>"  >
                              <em class="space-line">-</em>
                              <input type="text" class="pbtxt calendar1" name="transfer_date2" value="<?php echo $search['transfer_date2']; ?>"  >
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 过入客户</div>
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
                      <div class="unit-left"> 过入客户</div>
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
                      <div class="unit-left"> 仓库编码</div>
                      <div class="unit-mid">
                          <div class="popup">
                              <input  type="text" class="pbtxt txt0" name="warehouse_code_name" readonly="readonly" value="<?php echo $search['warehouse_code_name']; ?>">
                              <button type="submit" class="txt-search" onclick="return _asr.popup('Warehouse','<?php echo "$funcid"; ?>','<?php echo "$funcid"; ?>-Search','Single','warehouse_code','warehouse_code_name'); " <?php if($search["warehouse_code_name"]!=""): ?> style="display:none"<?php endif; ?> ><i class="iconfont">&#xe60e;</i></button>
                              <button type="submit" class="txt-clear" onclick="_asr.setvaluebyname('<?php echo "$funcid"; ?>-Search','warehouse_code','');_asr.setvaluebyname('<?php echo "$funcid"; ?>-Search','warehouse_code_name','');return false;" <?php if($search["warehouse_code_name"]===""): ?> style="display:none"<?php endif; ?> ><i class="iconfont">&#xe616;</i></button>
                          </div>
                            <input type="hidden" name="warehouse_code" value="<?php echo $search['warehouse_code']; ?>">
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
                </ul>
                <ul class="form form-mod-new split" style="<?php if($search["_searchexpand"]!="1"): echo "display:none"; endif; ?>">
                  <li>
                      <div class="unit-left"> 货品基础码</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="style_code"  value="<?php echo $search['style_code']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 重量</div>
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
                      <div class="unit-left"> 数量/件</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt1" name="qty"  value="<?php echo $search['qty']; ?>"  >
                              <em class="space-line">-</em>
                              <input type="text" class="pbtxt txt1" name="qty2" value="<?php echo $search['qty2']; ?>"  >
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 散件</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt1" name="bulkcargo"  value="<?php echo $search['bulkcargo']; ?>"  >
                              <em class="space-line">-</em>
                              <input type="text" class="pbtxt txt1" name="bulkcargo2" value="<?php echo $search['bulkcargo2']; ?>"  >
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
                      <div class="unit-left"> 散件单位</div>
                      <div class="unit-mid">
                          <div class="dropdown" id="<?php echo ($funcid); ?>_uom_bulkcargo">
                             <select class="pbsele dropdown0" name="uom_bulkcargo">
                                <option value="" <?php if($search['uom_bulkcargo'] == ''): ?> selected="selected" <?php endif;?> ></option>
                               <?php
 $keyvalue = subcode('UOM_BULKCARGO'); if(is_array($keyvalue)){ $i = 0; $__LIST__ = $keyvalue; ?>
                                      <?php foreach($__LIST__ as $key=>$item): ++$i; ?>
                                   <option value="<?php echo $item['code']; ?>" <?php if($item['code'] == $search['uom_bulkcargo']): ?> selected="selected" <?php endif;?>><?php echo charlevel($item['level']).$item['name']; ?></option>
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
                      <div class="unit-left"> 付款客户</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="payment_customer_id"  value="<?php echo $search['payment_customer_id']; ?>"  >
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 付款客户</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="payment_customer"  value="<?php echo $search['payment_customer']; ?>"   placeholder=" 直接进行模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 付款图像</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="payment_path"  value="<?php echo $search['payment_path']; ?>"   placeholder=" 直接进行模糊搜索 ">
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
                      <div class="unit-left"> 过给自己</div>
                      <div class="unit-mid">
                          <div class="dropdown" id="<?php echo ($funcid); ?>_isself">
                             <div class="selebtn">
                                <input type="hidden"  name="isself" value="<?php echo $search['isself']; ?>">
                                <a href="javascript:void(0);" onclick="_asr.selebtn_click(this,'');" class="<?php  echo $search['isself']!=""?"":"active"; ?>">全部</a>
                           <?php $keyvalue = table_Transfer_isself(); if(is_array($keyvalue)){ $i = 0; $__LIST__ = $keyvalue; ?>
                               <?php foreach($__LIST__ as $key=>$item): ++$i; ?>
                                 <a href="javascript:void(0);" onclick="_asr.selebtn_click(this,'<?php echo $item['id'];?>');" class="<?php  echo $search['isself']!=$item['id']?"":"active"; ?>"><?php echo $item['name']; ?></a>
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
                      <div class="unit-left"> 创建时间</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt1" name="checktime"  value="<?php echo $search['checktime']; ?>"  >
                              <em class="space-line">-</em>
                              <input type="text" class="pbtxt txt1" name="checktime2" value="<?php echo $search['checktime2']; ?>"  >
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
                      <a href="#" onclick="return _asr.tabsheet('<?php echo $funcid;?>', '<?php echo "$funcid"; ?>-Search', 'caogao');" <?php if($search['_tab'] == 'caogao'): ?> class="current"<?php endif;?>>草稿</a>
                      <a href="#" onclick="return _asr.tabsheet('<?php echo $funcid;?>', '<?php echo "$funcid"; ?>-Search', 'youxiao');" <?php if($search['_tab'] == 'youxiao'): ?> class="current"<?php endif;?>>有效</a>
                      <a href="#" onclick="return _asr.tabsheet('<?php echo $funcid;?>', '<?php echo "$funcid"; ?>-Search', 'jieshu');" <?php if($search['_tab'] == 'jieshu'): ?> class="current"<?php endif;?>>结束</a>
                      <a href="#" onclick="return _asr.tabsheet('<?php echo $funcid;?>', '<?php echo "$funcid"; ?>-Search', 'quxiao');" <?php if($search['_tab'] == 'quxiao'): ?> class="current"<?php endif;?>>取消</a>
                      <a href="#" onclick="return _asr.tabsheet('<?php echo $funcid;?>', '<?php echo "$funcid"; ?>-Search', 'shixiao');" <?php if($search['_tab'] == 'shixiao'): ?> class="current"<?php endif;?>>失效</a>
                    </div>
                    <p class="annotation vi-red"></p>
                    <div class="sub-box-in abe-fr"  id="<?php echo $funcid;?>-search-butt">


          <?php if (isset($rights['search']) && $rights['search']): ?>
               <input type="button" value="搜索" class="btn btn-org  mrg_10 " onclick="return _asr.submit('<?php echo "$funcid"; ?>', '<?php echo "$funcid"; ?>-Search', '<?php echo U("TransferSummary/index?func=search&") ; ?>',''); " />
          <?php endif; ?>



               <input type="button" value="清除" class="btn btn-blue mrg_10 " onclick="return <?php echo "$funcid"; ?>_clearsearch('<?php echo "$funcid"; ?>-Search');" />



          <?php if (isset($rights['export']) && $rights['export']): ?>
               <input type="button" value="导出" class="btn btn-blue mrg_10 " onclick="return _asr.showExport('<?php echo "$funcid"; ?>', '<?php echo "$funcid"; ?>-Search', '<?php echo U("TransferSummary/index?func=export&") ; ?>',<?php echo $p ?>); " />
          <?php endif; ?>

                    <em class="pdr_20"></em>
                    <button class="btn btn-xs hid-btn" type="button" onclick="return _asr.showSearch(this);">展开选项<i class="iconfont">&#xe612;</i></button>
                    <a href="javascript:void(0);" class="table-set <?php echo count($colshow)>0?"vi-blue":"abe-gray3"; ?>"  onclick="return _asr.popupFun('<?php echo U("/Summary/TransferSummary/index?func=columnsetting&") ; ?>','<?php echo filterFuncId("/TransferSummary/column","");?>');  " ><em class="iconfont abe-ft14 mrg_5">&#xe60a;</em>设置</a>
                    </div>
                  </div>
      </form>
    </div>



  <div class="wrap-nmd-box">
    <div class="wrap-master ">

      <div class="list-scroll">
        <div class="table-box">
          <div class="table-in">
            <form id="<?php echo "$funcid"; ?>-Result"  action="<?php U('TransferSummary/op'); ?>" method="post">
              <table border="0" cellspacing="0" cellpadding="0" class="pub-table ta-tr-hover">
                <colgroup>
                           <col style="width: 40px ;">   <!--  -->
          <!-- 序号        <col style="width: 40px ;">   -->
                           <col style="width: 60px ; <?php if(isset($colshow[""]) && $colshow[""]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 操作 -->
                           <col style="width: 80px ; <?php if(isset($colshow["status"]) && $colshow["status"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 状态 -->
                           <col style="width: 80px ; <?php if(isset($colshow["org_id"]) && $colshow["org_id"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 库链 -->
                           <col style="width: 100px ; <?php if(isset($colshow["customer_name"]) && $colshow["customer_name"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 客户名称 -->
                           <col style="width: 80px ; <?php if(isset($colshow["tx_date"]) && $colshow["tx_date"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 开单日期 -->
                           <col style="width: 80px ; <?php if(isset($colshow["transfer_no"]) && $colshow["transfer_no"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 过户单号 -->
                           <col style="width: 80px ; <?php if(isset($colshow["transfer_date"]) && $colshow["transfer_date"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 过户日期 -->
                           <col style="width: 80px ; <?php if(isset($colshow["buyer_id"]) && $colshow["buyer_id"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 过入客户 -->
                           <col style="width: 100px ; <?php if(isset($colshow["buyer_name"]) && $colshow["buyer_name"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 过入客户 -->
                           <col style="width: 80px ; <?php if(isset($colshow["warehouse_code"]) && $colshow["warehouse_code"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 仓库编码 -->
                           <col style="width: 80px ; <?php if(isset($colshow["goods_no"]) && $colshow["goods_no"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 货品编码 -->
                           <col style="width: 100px ; <?php if(isset($colshow["goods_name"]) && $colshow["goods_name"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 货品名称 -->
                           <col style="width: 100px ; <?php if(isset($colshow["style_info"]) && $colshow["style_info"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 规格 -->
                           <col style="width: 80px ; <?php if(isset($colshow["materials"]) && $colshow["materials"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 材质 -->
                           <col style="width: 80px ; <?php if(isset($colshow["brand"]) && $colshow["brand"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 商标 -->
                           <col style="width: 80px ; <?php if(isset($colshow["producing_area"]) && $colshow["producing_area"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 产地 -->
                           <col style="width: 80px ; <?php if(isset($colshow["style_code"]) && $colshow["style_code"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 货品基础码 -->
                           <col style="width: 80px ; <?php if(isset($colshow["weight"]) && $colshow["weight"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 重量 -->
                           <col style="width: 80px ; <?php if(isset($colshow["qty"]) && $colshow["qty"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 数量 -->
                           <col style="width: 80px ; <?php if(isset($colshow["bulkcargo"]) && $colshow["bulkcargo"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 散件 -->
                           <col style="width: 80px ; <?php if(isset($colshow["uom_qty"]) && $colshow["uom_qty"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 数量单位 -->
                           <col style="width: 80px ; <?php if(isset($colshow["uom_weight"]) && $colshow["uom_weight"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 重量单位 -->
                           <col style="width: 80px ; <?php if(isset($colshow["uom_bulkcargo"]) && $colshow["uom_bulkcargo"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 散件单位 -->
                           <col style="width: 80px ; <?php if(isset($colshow["payment_customer_id"]) && $colshow["payment_customer_id"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 付款客户 -->
                           <col style="width: 100px ; <?php if(isset($colshow["payment_customer"]) && $colshow["payment_customer"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 付款客户 -->
                           <col style="width: 100px ; <?php if(isset($colshow["payment_path"]) && $colshow["payment_path"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 付款图像 -->
                           <col style="width: 80px ; <?php if(isset($colshow["buyer_storecard_id"]) && $colshow["buyer_storecard_id"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 收货卡 -->
                           <col style="width: 80px ; <?php if(isset($colshow["buyer_storecard_no"]) && $colshow["buyer_storecard_no"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 收货卡号 -->
                           <col style="width: 80px ; <?php if(isset($colshow["isself"]) && $colshow["isself"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 过给自己 -->
                           <col style="width: 80px ; <?php if(isset($colshow["checktime"]) && $colshow["checktime"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 创建时间 -->
                           <col style="width:auto" >
                </colgroup>
                <tbody>
                  <tr>
                          <th><input type="checkbox"  onclick="_asr.selectAll(this);"> &nbsp;#</th>
          <!-- 序号       <th>序号</th>   -->
                          <th class="abe-txtl">操作</th>
                          <th <?php if(isset($colshow["status"]) && $colshow["status"]=="0"): ?> style="display:none" <?php endif; ?>>状态</th>
                          <th <?php if(isset($colshow["org_id"]) && $colshow["org_id"]=="0"): ?> style="display:none" <?php endif; ?>>库链</th>
                          <th <?php if(isset($colshow["customer_name"]) && $colshow["customer_name"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">客户名称</th>
                          <th <?php if(isset($colshow["tx_date"]) && $colshow["tx_date"]=="0"): ?> style="display:none" <?php endif; ?>>开单日期</th>
                          <th <?php if(isset($colshow["transfer_no"]) && $colshow["transfer_no"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">过户单号</th>
                          <th <?php if(isset($colshow["transfer_date"]) && $colshow["transfer_date"]=="0"): ?> style="display:none" <?php endif; ?>>过户日期</th>
                          <th <?php if(isset($colshow["buyer_id"]) && $colshow["buyer_id"]=="0"): ?> style="display:none" <?php endif; ?>>过入客户</th>
                          <th <?php if(isset($colshow["buyer_name"]) && $colshow["buyer_name"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">过入客户</th>
                          <th <?php if(isset($colshow["warehouse_code"]) && $colshow["warehouse_code"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">仓库编码</th>
                          <th <?php if(isset($colshow["goods_no"]) && $colshow["goods_no"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">货品编码</th>
                          <th <?php if(isset($colshow["goods_name"]) && $colshow["goods_name"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">货品名称</th>
                          <th <?php if(isset($colshow["style_info"]) && $colshow["style_info"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">规格</th>
                          <th <?php if(isset($colshow["materials"]) && $colshow["materials"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">材质</th>
                          <th <?php if(isset($colshow["brand"]) && $colshow["brand"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">商标</th>
                          <th <?php if(isset($colshow["producing_area"]) && $colshow["producing_area"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">产地</th>
                          <th <?php if(isset($colshow["style_code"]) && $colshow["style_code"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">货品基础码</th>
                          <th <?php if(isset($colshow["weight"]) && $colshow["weight"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtr">重量</th>
                          <th <?php if(isset($colshow["qty"]) && $colshow["qty"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtr">数量</th>
                          <th <?php if(isset($colshow["bulkcargo"]) && $colshow["bulkcargo"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtr">散件</th>
                          <th <?php if(isset($colshow["uom_qty"]) && $colshow["uom_qty"]=="0"): ?> style="display:none" <?php endif; ?>>数量单位</th>
                          <th <?php if(isset($colshow["uom_weight"]) && $colshow["uom_weight"]=="0"): ?> style="display:none" <?php endif; ?>>重量单位</th>
                          <th <?php if(isset($colshow["uom_bulkcargo"]) && $colshow["uom_bulkcargo"]=="0"): ?> style="display:none" <?php endif; ?>>散件单位</th>
                          <th <?php if(isset($colshow["payment_customer_id"]) && $colshow["payment_customer_id"]=="0"): ?> style="display:none" <?php endif; ?>>付款客户</th>
                          <th <?php if(isset($colshow["payment_customer"]) && $colshow["payment_customer"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">付款客户</th>
                          <th <?php if(isset($colshow["payment_path"]) && $colshow["payment_path"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">付款图像</th>
                          <th <?php if(isset($colshow["buyer_storecard_id"]) && $colshow["buyer_storecard_id"]=="0"): ?> style="display:none" <?php endif; ?>>收货卡</th>
                          <th <?php if(isset($colshow["buyer_storecard_no"]) && $colshow["buyer_storecard_no"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">收货卡号</th>
                          <th <?php if(isset($colshow["isself"]) && $colshow["isself"]=="0"): ?> style="display:none" <?php endif; ?>>过给自己</th>
                          <th <?php if(isset($colshow["checktime"]) && $colshow["checktime"]=="0"): ?> style="display:none" <?php endif; ?>>创建时间</th>
                           <th></th >
                        </tr>
                        <?php $parent_trNo=""; $group=""; $groupId="";?>
                        <?php if(is_array($list)): $i = 0; $__LIST__ = $list; if( count($__LIST__) == 0) : echo ""; else: foreach($__LIST__ as $key=>$master): $mod = ($i % 2 );++$i; ?>
                                  <?php $seqNo = $i + ($page_size * ($p - 1)); ?>

                                  <?php $trColor = $mod=="1"?"even":"odd"; ?>
                                  <?php if ($master[status]=='0'): $trColor.=" green-tdbg"; endif; ?>
                                  <?php $trNo=($parent_trNo?$parent_trNo.".":"").$seqNo; ?>
                                  <tr class="<?php echo $trColor; ?>" group="<?php echo $group; ?>" group-id="<?php echo $groupId; ?>">
                                  <!-- 选择 -->
                                  <td class="abe-txtl"><input type="checkbox" name="Key[]" data-type="select" onclick="_asr.selectMulit(this);" value="<?php echo $master['id'] ;?>">&nbsp;<?php echo $trNo; ?></td>
                                  <!-- 序号 -->
                                  <td  class=" abe-txtl ">



          <?php if (isset($rights['master_view']) && $rights['master_view']): ?>
               <a href="javascript:void(0);"  class=" vi-blue vi-blue " onclick="return _asr.openLink('<?php echo U("/Home/Transfer/index?func=view&id=$master[id]") ; ?>', '<?php echo filterFuncId(U("/Home/Transfer/index?func=view&id=$master[id]"),"");?>' , '<?php echo tabTitle("过户","$master[transfer_no]") ; ?>' ,0); "><i class="iconfont abe-ft18">&#xe62e;</i></a>
          <?php endif; ?></td>


                                  <td style=" <?php if(isset($colshow["status"]) && $colshow["status"]=="0"): ?>display:none<?php endif; ?> " ><?php echo get_table_Transfer_status("$master[status]","name","") ; ?></td>
                                  <td style=" <?php if(isset($colshow["org_id"]) && $colshow["org_id"]=="0"): ?>display:none<?php endif; ?> " ><?php echo get_table_Org_byID("$master[org_id]","name","") ; ?></td>
                                  <td style=" <?php if(isset($colshow["customer_name"]) && $colshow["customer_name"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["customer_name"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["tx_date"]) && $colshow["tx_date"]=="0"): ?>display:none<?php endif; ?> " ><?php echo system_format("D", $master["tx_date"],1) ; ?></td>
                                  <td style=" <?php if(isset($colshow["transfer_no"]) && $colshow["transfer_no"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><a href="javascript:void(0);" class="vi-blue"  onclick="return _asr.openLink('<?php echo U("/Home/Transfer/index?func=view&id=$master[id]"); ?>','<?php echo filterFuncId( U("/Home/Transfer/index?func=view&id=$master[id]") ,"");?>', '过户详情' ,0); " ><?php echo $master["transfer_no"] ; ?></a></td>
                                  <td style=" <?php if(isset($colshow["transfer_date"]) && $colshow["transfer_date"]=="0"): ?>display:none<?php endif; ?> " ><?php echo system_format("D", $master["transfer_date"],1) ; ?></td>
                                  <td style=" <?php if(isset($colshow["buyer_id"]) && $colshow["buyer_id"]=="0"): ?>display:none<?php endif; ?> " ><?php echo $master["buyer_id"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["buyer_name"]) && $colshow["buyer_name"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["buyer_name"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["warehouse_code"]) && $colshow["warehouse_code"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo get_table_Warehouse("$master[warehouse_code]","name","") ; ?></td>
                                  <td style=" <?php if(isset($colshow["goods_no"]) && $colshow["goods_no"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["goods_no"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["goods_name"]) && $colshow["goods_name"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["goods_name"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["style_info"]) && $colshow["style_info"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["style_info"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["materials"]) && $colshow["materials"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["materials"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["brand"]) && $colshow["brand"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["brand"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["producing_area"]) && $colshow["producing_area"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["producing_area"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["style_code"]) && $colshow["style_code"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["style_code"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["weight"]) && $colshow["weight"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtr <?php if ($master['weight']<0): ?> abe-red <?php endif; ?> "><?php echo system_format("F33", $master["weight"],1) ; ?></td>
                                  <td style=" <?php if(isset($colshow["qty"]) && $colshow["qty"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtr <?php if ($master['qty']<0): ?> abe-red <?php endif; ?> "><?php echo system_format("N3", $master["qty"],1) ; ?></td>
                                  <td style=" <?php if(isset($colshow["bulkcargo"]) && $colshow["bulkcargo"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtr <?php if ($master['bulkcargo']<0): ?> abe-red <?php endif; ?> "><?php echo system_format("N3", $master["bulkcargo"],1) ; ?></td>
                                  <td style=" <?php if(isset($colshow["uom_qty"]) && $colshow["uom_qty"]=="0"): ?>display:none<?php endif; ?> " ><?php echo $master["uom_qty"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["uom_weight"]) && $colshow["uom_weight"]=="0"): ?>display:none<?php endif; ?> " ><?php echo $master["uom_weight"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["uom_bulkcargo"]) && $colshow["uom_bulkcargo"]=="0"): ?>display:none<?php endif; ?> " ><?php echo $master["uom_bulkcargo"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["payment_customer_id"]) && $colshow["payment_customer_id"]=="0"): ?>display:none<?php endif; ?> " ><?php echo $master["payment_customer_id"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["payment_customer"]) && $colshow["payment_customer"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["payment_customer"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["payment_path"]) && $colshow["payment_path"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><div class="newline newline-l"><?php echo OverView($master["payment_path"],100,"...") ; ?></div></td>
                                  <td style=" <?php if(isset($colshow["buyer_storecard_id"]) && $colshow["buyer_storecard_id"]=="0"): ?>display:none<?php endif; ?> " ><?php echo $master["buyer_storecard_id"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["buyer_storecard_no"]) && $colshow["buyer_storecard_no"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["buyer_storecard_no"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["isself"]) && $colshow["isself"]=="0"): ?>display:none<?php endif; ?> " ><?php echo get_table_Transfer_isself("$master[isself]","name","") ; ?></td>
                                  <td style=" <?php if(isset($colshow["checktime"]) && $colshow["checktime"]=="0"): ?>display:none<?php endif; ?> " class=" <?php if ($master['checktime']<0): ?> abe-red <?php endif; ?> "><?php echo system_format("N3", $master["checktime"],1) ; ?></td>
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
            _asr.setvaluebyname(_frm,"customer_id_name","");
            _asr.setvaluebyname(_frm,"customer_id","");
            _asr.setvaluebyname(_frm,"customer_name","");
            _asr.setvaluebyname(_frm,"tx_date","");
            _asr.setvaluebyname(_frm,"tx_date2","");
            _asr.setvaluebyname(_frm,"transfer_no","");
            _asr.setvaluebyname(_frm,"transfer_date","");
            _asr.setvaluebyname(_frm,"transfer_date2","");
            _asr.setvaluebyname(_frm,"buyer_id","");
            _asr.setvaluebyname(_frm,"buyer_name","");
            _asr.setvaluebyname(_frm,"warehouse_code_name","");
            _asr.setvaluebyname(_frm,"warehouse_code","");
            _asr.setvaluebyname(_frm,"goods_no","");
            _asr.setvaluebyname(_frm,"goods_name","");
            _asr.setvaluebyname(_frm,"style_info","");
            _asr.setvaluebyname(_frm,"materials","");
            _asr.setvaluebyname(_frm,"brand","");
            _asr.setvaluebyname(_frm,"producing_area","");
            _asr.setvaluebyname(_frm,"style_code","");
            _asr.setvaluebyname(_frm,"weight","");
            _asr.setvaluebyname(_frm,"weight2","");
            _asr.setvaluebyname(_frm,"qty","");
            _asr.setvaluebyname(_frm,"qty2","");
            _asr.setvaluebyname(_frm,"bulkcargo","");
            _asr.setvaluebyname(_frm,"bulkcargo2","");
            _asr.setvaluebyname(_frm,"uom_qty","");
            _asr.setvaluebyname(_frm,"uom_weight","");
            _asr.setvaluebyname(_frm,"uom_bulkcargo","");
            _asr.setvaluebyname(_frm,"payment_customer_id","");
            _asr.setvaluebyname(_frm,"payment_customer","");
            _asr.setvaluebyname(_frm,"payment_path","");
            _asr.setvaluebyname(_frm,"buyer_storecard_id","");
            _asr.setvaluebyname(_frm,"buyer_storecard_no","");
            _asr.setvaluebyname(_frm,"isself","");
            _asr.setvaluebyname(_frm,"checktime","");
            _asr.setvaluebyname(_frm,"checktime2","");

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


    <?php echo W('Summary/javascript',array('TransferSummary'));?>


    </script>