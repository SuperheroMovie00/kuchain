<?php if (!defined('THINK_PATH')) exit();?>
<div toplayer="1" class="wrap-box wrap-nmd wrap-style00 " id="<?php echo $funcid;?>" summaryid="CustomerSummary" baseurl="<?php echo U('CustomerSummary/index'); ?>">
  <div class="wrap-box-info ">

    <div class="wrap-title abe-ofl">
      <div class="tit abe-fl" style="width: 450px;">客户信息列表</div>
      <div class="abe-fl">
        <div class="textbox" >
          <div  id="<?php echo "$funcid"; ?>-keyword-info" class="abe-fl"<?php if($search["_showsearch"]=="show"):?>style="display:none;"<?php endif; ?>>
             <input type="text" class="pbtxt txt0" id="<?php echo $funcid;?>-keyword-input" value="<?php echo $search['_keyword']; ?>"  onKeyDown="<?php echo ($funcid); ?>_keyword_keydown(this);" placeholder=" 输入关键词进行搜索 ">
             <input type="button" value="搜索" class="btn btn-org  mrg_10 " id="<?php echo $funcid;?>-keyword-search"  default-status="1"  onclick="<?php echo ($funcid); ?>_keyword_set(); return _asr.submit('<?php echo "$funcid"; ?>', '<?php echo "$funcid"; ?>-Search', '<?php echo U("CustomerSummary/index?func=search&") ; ?>',''); " />
             <input id="<?php echo $funcid;?>-search-buttc" type="button" value="导出" class="btn btn-blue mrg_10 " default-status="1" onclick="return _asr.showExport('<?php echo "$funcid"; ?>', '<?php echo "$funcid"; ?>-Search', '<?php echo U("CustomerSummary/index?func=export&") ; ?>',<?php echo $p ?>); " />
          </div>
          <a href="javascript:void(0);" class="mrg_15 vi-blue search-show" <?php if($search["_showsearch"]=="show"):?>style="display:none;"<?php endif; ?>><i class="iconfont">&#xe673;</i>搜索扩展</a>
        </div>
      </div>
      <div class="abe-fr">
        <a href="javascript:void(0);" class="mrg_15 vi-blue search-hide" <?php if($search["_showsearch"]=="hide"):?>style="display:none;"<?php endif; ?>><i class="iconfont">&#xe673;</i>收起搜索</a>


          <?php if (isset($rights['add']) && $rights['add']): ?>
          <?php if (!session('CUSTOMER_ID')): ?>
               <input type="button" value="新增客户资料" class="btn btn-blue mrg_10 " onclick="return _asr.popupFun('<?php echo U("/Home/Customer/index?func=add&%addlink%") ; ?>', '<?php echo filterFuncId("/Home/Customer/index?func=add&%addlink%","");?>'); " />
          <?php endif; ?>
          <?php endif; ?>



          <?php if (isset($rights['import']) && $rights['import']): ?>
               <input type="button" value="数据导入" class="btn btn-blue mrg_10 " onclick="return _asr.popupFun('<?php echo U("/Home/Customer/index?func=import&") ; ?>', '<?php echo filterFuncId("/Home/Customer/index?func=import&","");?>'); " />
          <?php endif; ?>



               <a href="javascript:void(0);"  class=" vi-blue " onclick="return _asr.openLink('','<?php echo "$funcid"; ?>','刷新',1); "><i class="iconfont ">&#xe611;</i> 刷新</a>

      </div>
    </div>


    <div class="screening"  >
      <form action="<?php echo U('CustomerSummary/index?func=search'); ?>" id="<?php echo "$funcid"; ?>-Search" method="get">
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
 $keyvalue = table_Customer_status(); if(is_array($keyvalue)){ $i = 0; $__LIST__ = $keyvalue; ?>
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
                      <div class="unit-left"> 客户分类</div>
                      <div class="unit-mid">
                          <div class="popup">
                              <input  type="text" class="pbtxt txt0" name="category_code_name" readonly="readonly" value="<?php echo $search['category_code_name']; ?>">
                              <button type="submit" class="txt-search" onclick="return _asr.popup('CustomerCategoryTree','<?php echo "$funcid"; ?>','<?php echo "$funcid"; ?>-Search','Single','category_code','category_code_name'); " <?php if($search["category_code_name"]!=""): ?> style="display:none"<?php endif; ?> ><i class="iconfont">&#xe60e;</i></button>
                              <button type="submit" class="txt-clear" onclick="_asr.setvaluebyname('<?php echo "$funcid"; ?>-Search','category_code','');_asr.setvaluebyname('<?php echo "$funcid"; ?>-Search','category_code_name','');return false;" <?php if($search["category_code_name"]===""): ?> style="display:none"<?php endif; ?> ><i class="iconfont">&#xe616;</i></button>
                          </div>
                            <input type="hidden" name="category_code" value="<?php echo $search['category_code']; ?>">
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 行业分类</div>
                      <div class="unit-mid">
                          <div class="dropdown" id="<?php echo ($funcid); ?>_industry_code">
                             <select class="pbsele dropdown0" name="industry_code">
                                <option value="" <?php if($search['industry_code'] == ''): ?> selected="selected" <?php endif;?> ></option>
                               <?php
 $keyvalue = subcode('customer:industry'); if(is_array($keyvalue)){ $i = 0; $__LIST__ = $keyvalue; ?>
                                      <?php foreach($__LIST__ as $key=>$item): ++$i; ?>
                                   <option value="<?php echo $item['code']; ?>" <?php if($item['code'] == $search['industry_code']): ?> selected="selected" <?php endif;?>><?php echo charlevel($item['level']).$item['name']; ?></option>
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
                      <div class="unit-left"> 客户代码</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="code"  value="<?php echo $search['code']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 客户简称</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="name"  value="<?php echo $search['name']; ?>"   placeholder=" 直接进行模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 客户全称</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="full_name"  value="<?php echo $search['full_name']; ?>"   placeholder=" 直接进行模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 助记码</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="prefix"  value="<?php echo $search['prefix']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 缩写</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="abbr"  value="<?php echo $search['abbr']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 上级名称</div>
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
                      <div class="unit-left"> 选择层级</div>
                      <div class="unit-mid">
                          <div class="dropdown" id="<?php echo ($funcid); ?>_customer_level">
                             <select class="pbsele dropdown0" name="customer_level">
                                <option value="" <?php if($search['customer_level'] == ''): ?> selected="selected" <?php endif;?> ></option>
                               <?php
 $keyvalue = table_Customer_customer_level(); if(is_array($keyvalue)){ $i = 0; $__LIST__ = $keyvalue; ?>
                                      <?php foreach($__LIST__ as $key=>$item): ++$i; ?>
                                   <option value="<?php echo $item['id']; ?>" <?php if($item['id'] == $search['customer_level']): ?> selected="selected" <?php endif;?>><?php echo charlevel($item['level']).$item['name']; ?></option>
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
                      <div class="unit-left"> 省份</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="province"  value="<?php echo $search['province']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 联系地址</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="address"  value="<?php echo $search['address']; ?>"   placeholder=" 直接进行模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 邮政编码</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="postcode"  value="<?php echo $search['postcode']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 联系电话</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="phone"  value="<?php echo $search['phone']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 联系人员</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="linkman"  value="<?php echo $search['linkman']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 联系手机</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="mobile"  value="<?php echo $search['mobile']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                </ul>
                <ul class="form form-mod-new split" style="<?php if($search["_searchexpand"]!="1"): echo "display:none"; endif; ?>">
                  <li>
                      <div class="unit-left"> 营业执照号</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="corpbusicode"  value="<?php echo $search['corpbusicode']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 税务登记证</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="corptaxcode"  value="<?php echo $search['corptaxcode']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 法人姓名</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="legalpername"  value="<?php echo $search['legalpername']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 法人证件类型</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="legalperidtype"  value="<?php echo $search['legalperidtype']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 法人证件号码</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="legalperidno"  value="<?php echo $search['legalperidno']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 联系人姓名</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="contactname"  value="<?php echo $search['contactname']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 联系人证件类型</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="contactidtype"  value="<?php echo $search['contactidtype']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 联系人证件号码</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="contactidno"  value="<?php echo $search['contactidno']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 联系人手机</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="contactmobile"  value="<?php echo $search['contactmobile']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 开户银行</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="openbank"  value="<?php echo $search['openbank']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 开户账户号</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="openacctno"  value="<?php echo $search['openacctno']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 开户账户名</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="openacctname"  value="<?php echo $search['openacctname']; ?>"   placeholder=" 直接进行模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 银联账户号</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="chinapay_userid"  value="<?php echo $search['chinapay_userid']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 发票要求</div>
                      <div class="unit-mid">
                          <div class="dropdown" id="<?php echo ($funcid); ?>_invoice_flag">
                             <div class="selebtn">
                                <input type="hidden"  name="invoice_flag" value="<?php echo $search['invoice_flag']; ?>">
                                <a href="javascript:void(0);" onclick="_asr.selebtn_click(this,'');" class="<?php  echo $search['invoice_flag']!=""?"":"active"; ?>">全部</a>
                           <?php $keyvalue = table_Customer_invoice_flag(); if(is_array($keyvalue)){ $i = 0; $__LIST__ = $keyvalue; ?>
                               <?php foreach($__LIST__ as $key=>$item): ++$i; ?>
                                 <a href="javascript:void(0);" onclick="_asr.selebtn_click(this,'<?php echo $item['id'];?>');" class="<?php  echo $search['invoice_flag']!=$item['id']?"":"active"; ?>"><?php echo $item['name']; ?></a>
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
                      <div class="unit-left"> 开票单位</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="invoice_company"  value="<?php echo $search['invoice_company']; ?>"   placeholder=" 直接进行模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 开票地址</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="invoice_address"  value="<?php echo $search['invoice_address']; ?>"   placeholder=" 直接进行模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 开票电话</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="invoice_phone"  value="<?php echo $search['invoice_phone']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 开票银行</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="invoice_bank"  value="<?php echo $search['invoice_bank']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 开票账户</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="invoice_account"  value="<?php echo $search['invoice_account']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 开票税号</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="invoice_taxno"  value="<?php echo $search['invoice_taxno']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 电子票邮箱</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="invoice_email"  value="<?php echo $search['invoice_email']; ?>"   placeholder=" 直接进行模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 电子票手机</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="invoice_mobile"  value="<?php echo $search['invoice_mobile']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 合同联系人员</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="contract_linkman"  value="<?php echo $search['contract_linkman']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 合同联系电话</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="contract_phone"  value="<?php echo $search['contract_phone']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 合同联系传真</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="contract_fax"  value="<?php echo $search['contract_fax']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 合同邮寄地址</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="contract_address"  value="<?php echo $search['contract_address']; ?>"   placeholder=" 直接进行模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 结算联系人员</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="feesett_linkman"  value="<?php echo $search['feesett_linkman']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 结算联系电话</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="feesett_phone"  value="<?php echo $search['feesett_phone']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 结算联系传真</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="feesett_fax"  value="<?php echo $search['feesett_fax']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 结算对账单寄</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="feesett_address"  value="<?php echo $search['feesett_address']; ?>"   placeholder=" 直接进行模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 短信服务</div>
                      <div class="unit-mid">
                          <div class="dropdown" id="<?php echo ($funcid); ?>_sms_open">
                             <div class="selebtn">
                                <input type="hidden"  name="sms_open" value="<?php echo $search['sms_open']; ?>">
                                <a href="javascript:void(0);" onclick="_asr.selebtn_click(this,'');" class="<?php  echo $search['sms_open']!=""?"":"active"; ?>">全部</a>
                           <?php $keyvalue = table_Customer_sms_open(); if(is_array($keyvalue)){ $i = 0; $__LIST__ = $keyvalue; ?>
                               <?php foreach($__LIST__ as $key=>$item): ++$i; ?>
                                 <a href="javascript:void(0);" onclick="_asr.selebtn_click(this,'<?php echo $item['id'];?>');" class="<?php  echo $search['sms_open']!=$item['id']?"":"active"; ?>"><?php echo $item['name']; ?></a>
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
                      <div class="unit-left"> 货权转出通知</div>
                      <div class="unit-mid">
                          <div class="dropdown" id="<?php echo ($funcid); ?>_sms_transfer_out">
                             <div class="selebtn">
                                <input type="hidden"  name="sms_transfer_out" value="<?php echo $search['sms_transfer_out']; ?>">
                                <a href="javascript:void(0);" onclick="_asr.selebtn_click(this,'');" class="<?php  echo $search['sms_transfer_out']!=""?"":"active"; ?>">全部</a>
                           <?php $keyvalue = table_Customer_sms_transfer_out(); if(is_array($keyvalue)){ $i = 0; $__LIST__ = $keyvalue; ?>
                               <?php foreach($__LIST__ as $key=>$item): ++$i; ?>
                                 <a href="javascript:void(0);" onclick="_asr.selebtn_click(this,'<?php echo $item['id'];?>');" class="<?php  echo $search['sms_transfer_out']!=$item['id']?"":"active"; ?>"><?php echo $item['name']; ?></a>
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
                      <div class="unit-left"> 货权转入通知</div>
                      <div class="unit-mid">
                          <div class="dropdown" id="<?php echo ($funcid); ?>_sms_transfer_in">
                             <div class="selebtn">
                                <input type="hidden"  name="sms_transfer_in" value="<?php echo $search['sms_transfer_in']; ?>">
                                <a href="javascript:void(0);" onclick="_asr.selebtn_click(this,'');" class="<?php  echo $search['sms_transfer_in']!=""?"":"active"; ?>">全部</a>
                           <?php $keyvalue = table_Customer_sms_transfer_in(); if(is_array($keyvalue)){ $i = 0; $__LIST__ = $keyvalue; ?>
                               <?php foreach($__LIST__ as $key=>$item): ++$i; ?>
                                 <a href="javascript:void(0);" onclick="_asr.selebtn_click(this,'<?php echo $item['id'];?>');" class="<?php  echo $search['sms_transfer_in']!=$item['id']?"":"active"; ?>"><?php echo $item['name']; ?></a>
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
                      <div class="unit-left"> 提货时通知</div>
                      <div class="unit-mid">
                          <div class="dropdown" id="<?php echo ($funcid); ?>_sms_delivery">
                             <div class="selebtn">
                                <input type="hidden"  name="sms_delivery" value="<?php echo $search['sms_delivery']; ?>">
                                <a href="javascript:void(0);" onclick="_asr.selebtn_click(this,'');" class="<?php  echo $search['sms_delivery']!=""?"":"active"; ?>">全部</a>
                           <?php $keyvalue = table_Customer_sms_delivery(); if(is_array($keyvalue)){ $i = 0; $__LIST__ = $keyvalue; ?>
                               <?php foreach($__LIST__ as $key=>$item): ++$i; ?>
                                 <a href="javascript:void(0);" onclick="_asr.selebtn_click(this,'<?php echo $item['id'];?>');" class="<?php  echo $search['sms_delivery']!=$item['id']?"":"active"; ?>"><?php echo $item['name']; ?></a>
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
                      <div class="unit-left"> 接收手机号</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="sms_phone"  value="<?php echo $search['sms_phone']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 接收者称呼</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="sms_appellation"  value="<?php echo $search['sms_appellation']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 申请时间</div>
                      <div class="unit-mid">
                          <div class="calendar">
                              <input type="text" class="pbtxt calendar1" name="apply_time"  value= "<?php echo system_format("DT", $search["apply_time"],0); ?>"  >
                              <em class="space-line">-</em>
                              <input type="text" class="pbtxt calendar1" name="apply_time2" value="<?php echo $search['apply_time2']; ?>"  >
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 申请人员</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="apply_user"  value="<?php echo $search['apply_user']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 申请次数</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt1" name="apply_times"  value="<?php echo $search['apply_times']; ?>"  >
                              <em class="space-line">-</em>
                              <input type="text" class="pbtxt txt1" name="apply_times2" value="<?php echo $search['apply_times2']; ?>"  >
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 回复时间</div>
                      <div class="unit-mid">
                          <div class="calendar">
                              <input type="text" class="pbtxt calendar1" name="reply_time"  value= "<?php echo system_format("DT", $search["reply_time"],0); ?>"  >
                              <em class="space-line">-</em>
                              <input type="text" class="pbtxt calendar1" name="reply_time2" value="<?php echo $search['reply_time2']; ?>"  >
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 回复人员</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="reply_user"  value="<?php echo $search['reply_user']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 回复状态</div>
                      <div class="unit-mid">
                          <div class="dropdown" id="<?php echo ($funcid); ?>_reply_status">
                             <select class="pbsele dropdown0" name="reply_status">
                                <option value="" <?php if($search['reply_status'] == ''): ?> selected="selected" <?php endif;?> ></option>
                               <?php
 $keyvalue = table_Customer_reply_status(); if(is_array($keyvalue)){ $i = 0; $__LIST__ = $keyvalue; ?>
                                      <?php foreach($__LIST__ as $key=>$item): ++$i; ?>
                                   <option value="<?php echo $item['id']; ?>" <?php if($item['id'] == $search['reply_status']): ?> selected="selected" <?php endif;?>><?php echo charlevel($item['level']).$item['name']; ?></option>
                                      <?php endforeach; ?>
                               <?php } ?>
                             </select>
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
                      <a href="#" onclick="return _asr.tabsheet('<?php echo $funcid;?>', '<?php echo "$funcid"; ?>-Search', 'quanbu');" <?php if($search['_tab'] == 'quanbu'): ?> class="current"<?php endif;?>>全部</a>
                    <?php if (!session('CUSTOMER_ID')): ?>
                      <a href="#" onclick="return _asr.tabsheet('<?php echo $funcid;?>', '<?php echo "$funcid"; ?>-Search', 'hehuo');" <?php if($search['_tab'] == 'hehuo'): ?> class="current"<?php endif;?>>合伙</a>
                    <?php endif; ?>
                    <?php if (!session('CUSTOMER_ID')): ?>
                      <a href="#" onclick="return _asr.tabsheet('<?php echo $funcid;?>', '<?php echo "$funcid"; ?>-Search', 'kehu');" <?php if($search['_tab'] == 'kehu'): ?> class="current"<?php endif;?>>客户</a>
                    <?php endif; ?>
                    <?php if (!session('CUSTOMER_ID')): ?>
                      <a href="#" onclick="return _asr.tabsheet('<?php echo $funcid;?>', '<?php echo "$funcid"; ?>-Search', 'wuxiao');" <?php if($search['_tab'] == 'wuxiao'): ?> class="current"<?php endif;?>>无效</a>
                    <?php endif; ?>
                    </div>
                    <p class="annotation vi-red"></p>
                    <div class="sub-box-in abe-fr"  id="<?php echo $funcid;?>-search-butt">


          <?php if (isset($rights['search']) && $rights['search']): ?>
               <input type="button" value="搜索" class="btn btn-org  mrg_10 " onclick="return _asr.submit('<?php echo "$funcid"; ?>', '<?php echo "$funcid"; ?>-Search', '<?php echo U("CustomerSummary/index?func=search&") ; ?>',''); " />
          <?php endif; ?>



               <input type="button" value="清除" class="btn btn-blue mrg_10 " onclick="return <?php echo "$funcid"; ?>_clearsearch('<?php echo "$funcid"; ?>-Search');" />



          <?php if (isset($rights['export']) && $rights['export']): ?>
               <input type="button" value="导出" class="btn btn-blue mrg_10 " onclick="return _asr.showExport('<?php echo "$funcid"; ?>', '<?php echo "$funcid"; ?>-Search', '<?php echo U("CustomerSummary/index?func=export&") ; ?>',<?php echo $p ?>); " />
          <?php endif; ?>

                    <em class="pdr_20"></em>
                    <button class="btn btn-xs hid-btn" type="button" onclick="return _asr.showSearch(this);">展开选项<i class="iconfont">&#xe612;</i></button>
                    <a href="javascript:void(0);" class="table-set <?php echo count($colshow)>0?"vi-blue":"abe-gray3"; ?>"  onclick="return _asr.popupFun('<?php echo U("/Summary/CustomerSummary/index?func=columnsetting&") ; ?>','<?php echo filterFuncId("/CustomerSummary/column","");?>');  " ><em class="iconfont abe-ft14 mrg_5">&#xe60a;</em>设置</a>
                    </div>
                  </div>
      </form>
    </div>



  <div class="wrap-nmd-box">
    <div class="wrap-master ">

      <div class="list-scroll">
        <div class="table-box">
          <div class="table-in">
            <form id="<?php echo "$funcid"; ?>-Result"  action="<?php U('CustomerSummary/op'); ?>" method="post">
              <table border="0" cellspacing="0" cellpadding="0" class="pub-table ta-tr-hover">
                <colgroup>
                           <col style="width: 40px ;">   <!--  -->
          <!-- 序号        <col style="width: 40px ;">   -->
                           <col style="width: 60px ; <?php if(isset($colshow[""]) && $colshow[""]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 操作 -->
                           <col style="width: 80px ; <?php if(isset($colshow["status"]) && $colshow["status"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 状态 -->
                           <col style="width: 80px ; <?php if(isset($colshow["category_code"]) && $colshow["category_code"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 客户分类 -->
                           <col style="width: 80px ; <?php if(isset($colshow["industry_code"]) && $colshow["industry_code"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 行业分类 -->
                           <col style="width: 80px ; <?php if(isset($colshow["code"]) && $colshow["code"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 客户代码 -->
                           <col style="width: 100px ; <?php if(isset($colshow["name"]) && $colshow["name"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 客户简称 -->
                           <col style="width: 100px ; <?php if(isset($colshow["full_name"]) && $colshow["full_name"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 客户全称 -->
                           <col style="width: 80px ; <?php if(isset($colshow["prefix"]) && $colshow["prefix"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 助记码 -->
                           <col style="width: 80px ; <?php if(isset($colshow["abbr"]) && $colshow["abbr"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 缩写 -->
                           <col style="width: 100px ; <?php if(isset($colshow["customer_name"]) && $colshow["customer_name"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 上级名称 -->
                           <col style="width: 80px ; <?php if(isset($colshow["customer_level"]) && $colshow["customer_level"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 层级 -->
                           <col style="width: 80px ; <?php if(isset($colshow["province"]) && $colshow["province"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 省份 -->
                           <col style="width: 100px ; <?php if(isset($colshow["address"]) && $colshow["address"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 联系地址 -->
                           <col style="width: 80px ; <?php if(isset($colshow["postcode"]) && $colshow["postcode"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 邮政编码 -->
                           <col style="width: 80px ; <?php if(isset($colshow["phone"]) && $colshow["phone"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 联系电话 -->
                           <col style="width: 80px ; <?php if(isset($colshow["linkman"]) && $colshow["linkman"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 联系人员 -->
                           <col style="width: 80px ; <?php if(isset($colshow["mobile"]) && $colshow["mobile"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 联系手机 -->
                           <col style="width: 80px ; <?php if(isset($colshow["corpbusicode"]) && $colshow["corpbusicode"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 营业执照号 -->
                           <col style="width: 80px ; <?php if(isset($colshow["corptaxcode"]) && $colshow["corptaxcode"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 税务登记证 -->
                           <col style="width: 80px ; <?php if(isset($colshow["legalpername"]) && $colshow["legalpername"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 法人姓名 -->
                           <col style="width: 100px ; <?php if(isset($colshow["legalperidtype"]) && $colshow["legalperidtype"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 法人证件类型 -->
                           <col style="width: 100px ; <?php if(isset($colshow["legalperidno"]) && $colshow["legalperidno"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 法人证件号码 -->
                           <col style="width: 80px ; <?php if(isset($colshow["contactname"]) && $colshow["contactname"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 联系人姓名 -->
                           <col style="width: 120px ; <?php if(isset($colshow["contactidtype"]) && $colshow["contactidtype"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 联系人证件类型 -->
                           <col style="width: 120px ; <?php if(isset($colshow["contactidno"]) && $colshow["contactidno"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 联系人证件号码 -->
                           <col style="width: 80px ; <?php if(isset($colshow["contactmobile"]) && $colshow["contactmobile"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 联系人手机 -->
                           <col style="width: 80px ; <?php if(isset($colshow["openbank"]) && $colshow["openbank"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 开户银行 -->
                           <col style="width: 80px ; <?php if(isset($colshow["openacctno"]) && $colshow["openacctno"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 开户账户号 -->
                           <col style="width: 100px ; <?php if(isset($colshow["openacctname"]) && $colshow["openacctname"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 开户账户名 -->
                           <col style="width: 80px ; <?php if(isset($colshow["chinapay_userid"]) && $colshow["chinapay_userid"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 银联账户号 -->
                           <col style="width: 80px ; <?php if(isset($colshow["invoice_flag"]) && $colshow["invoice_flag"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 发票要求 -->
                           <col style="width: 100px ; <?php if(isset($colshow["invoice_company"]) && $colshow["invoice_company"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 开票单位 -->
                           <col style="width: 100px ; <?php if(isset($colshow["invoice_address"]) && $colshow["invoice_address"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 开票地址 -->
                           <col style="width: 80px ; <?php if(isset($colshow["invoice_phone"]) && $colshow["invoice_phone"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 开票电话 -->
                           <col style="width: 80px ; <?php if(isset($colshow["invoice_bank"]) && $colshow["invoice_bank"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 开票银行 -->
                           <col style="width: 80px ; <?php if(isset($colshow["invoice_account"]) && $colshow["invoice_account"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 开票账户 -->
                           <col style="width: 80px ; <?php if(isset($colshow["invoice_taxno"]) && $colshow["invoice_taxno"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 开票税号 -->
                           <col style="width: 100px ; <?php if(isset($colshow["invoice_email"]) && $colshow["invoice_email"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 电子票邮箱 -->
                           <col style="width: 80px ; <?php if(isset($colshow["invoice_mobile"]) && $colshow["invoice_mobile"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 电子票手机 -->
                           <col style="width: 100px ; <?php if(isset($colshow["contract_linkman"]) && $colshow["contract_linkman"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 合同联系人员 -->
                           <col style="width: 100px ; <?php if(isset($colshow["contract_phone"]) && $colshow["contract_phone"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 合同联系电话 -->
                           <col style="width: 100px ; <?php if(isset($colshow["contract_fax"]) && $colshow["contract_fax"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 合同联系传真 -->
                           <col style="width: 100px ; <?php if(isset($colshow["contract_address"]) && $colshow["contract_address"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 合同邮寄地址 -->
                           <col style="width: 100px ; <?php if(isset($colshow["feesett_linkman"]) && $colshow["feesett_linkman"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 结算联系人员 -->
                           <col style="width: 100px ; <?php if(isset($colshow["feesett_phone"]) && $colshow["feesett_phone"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 结算联系电话 -->
                           <col style="width: 100px ; <?php if(isset($colshow["feesett_fax"]) && $colshow["feesett_fax"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 结算联系传真 -->
                           <col style="width: 100px ; <?php if(isset($colshow["feesett_address"]) && $colshow["feesett_address"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 结算对账单寄 -->
                           <col style="width: 80px ; <?php if(isset($colshow["sms_open"]) && $colshow["sms_open"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 短信服务 -->
                           <col style="width: 100px ; <?php if(isset($colshow["sms_transfer_out"]) && $colshow["sms_transfer_out"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 货权转出通知 -->
                           <col style="width: 100px ; <?php if(isset($colshow["sms_transfer_in"]) && $colshow["sms_transfer_in"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 货权转入通知 -->
                           <col style="width: 80px ; <?php if(isset($colshow["sms_delivery"]) && $colshow["sms_delivery"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 提货时通知 -->
                           <col style="width: 80px ; <?php if(isset($colshow["sms_phone"]) && $colshow["sms_phone"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 接收手机号 -->
                           <col style="width: 80px ; <?php if(isset($colshow["sms_appellation"]) && $colshow["sms_appellation"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 接收者称呼 -->
                           <col style="width: 150px ; <?php if(isset($colshow["apply_time"]) && $colshow["apply_time"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 申请时间 -->
                           <col style="width: 80px ; <?php if(isset($colshow["apply_user"]) && $colshow["apply_user"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 申请人员 -->
                           <col style="width: 80px ; <?php if(isset($colshow["apply_times"]) && $colshow["apply_times"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 申请次数 -->
                           <col style="width: 150px ; <?php if(isset($colshow["reply_time"]) && $colshow["reply_time"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 回复时间 -->
                           <col style="width: 80px ; <?php if(isset($colshow["reply_user"]) && $colshow["reply_user"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 回复人员 -->
                           <col style="width: 80px ; <?php if(isset($colshow["reply_status"]) && $colshow["reply_status"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 回复状态 -->
                           <col style="width: 150px ; <?php if(isset($colshow["create_time"]) && $colshow["create_time"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 创建时间 -->
                           <col style="width: 80px ; <?php if(isset($colshow[""]) && $colshow[""]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 状态调整 -->
                           <col style="width:auto" >
                </colgroup>
                <tbody>
                  <tr>
                          <th><input type="checkbox"  onclick="_asr.selectAll(this);"> &nbsp;#</th>
          <!-- 序号       <th>序号</th>   -->
                          <th class="abe-txtl">操作</th>
                          <th <?php if(isset($colshow["status"]) && $colshow["status"]=="0"): ?> style="display:none" <?php endif; ?>>状态</th>
                          <th <?php if(isset($colshow["category_code"]) && $colshow["category_code"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">客户分类</th>
                          <th <?php if(isset($colshow["industry_code"]) && $colshow["industry_code"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">行业分类</th>
                          <th <?php if(isset($colshow["code"]) && $colshow["code"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">客户代码</th>
                          <th <?php if(isset($colshow["name"]) && $colshow["name"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">客户简称</th>
                          <th <?php if(isset($colshow["full_name"]) && $colshow["full_name"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">客户全称</th>
                          <th <?php if(isset($colshow["prefix"]) && $colshow["prefix"]=="0"): ?> style="display:none" <?php endif; ?>>助记码</th>
                          <th <?php if(isset($colshow["abbr"]) && $colshow["abbr"]=="0"): ?> style="display:none" <?php endif; ?>>缩写</th>
                          <th <?php if(isset($colshow["customer_name"]) && $colshow["customer_name"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">上级名称</th>
                          <th <?php if(isset($colshow["customer_level"]) && $colshow["customer_level"]=="0"): ?> style="display:none" <?php endif; ?>>层级</th>
                          <th <?php if(isset($colshow["province"]) && $colshow["province"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">省份</th>
                          <th <?php if(isset($colshow["address"]) && $colshow["address"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">联系地址</th>
                          <th <?php if(isset($colshow["postcode"]) && $colshow["postcode"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">邮政编码</th>
                          <th <?php if(isset($colshow["phone"]) && $colshow["phone"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">联系电话</th>
                          <th <?php if(isset($colshow["linkman"]) && $colshow["linkman"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">联系人员</th>
                          <th <?php if(isset($colshow["mobile"]) && $colshow["mobile"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">联系手机</th>
                          <th <?php if(isset($colshow["corpbusicode"]) && $colshow["corpbusicode"]=="0"): ?> style="display:none" <?php endif; ?>>营业执照号</th>
                          <th <?php if(isset($colshow["corptaxcode"]) && $colshow["corptaxcode"]=="0"): ?> style="display:none" <?php endif; ?>>税务登记证</th>
                          <th <?php if(isset($colshow["legalpername"]) && $colshow["legalpername"]=="0"): ?> style="display:none" <?php endif; ?>>法人姓名</th>
                          <th <?php if(isset($colshow["legalperidtype"]) && $colshow["legalperidtype"]=="0"): ?> style="display:none" <?php endif; ?>>法人证件类型</th>
                          <th <?php if(isset($colshow["legalperidno"]) && $colshow["legalperidno"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">法人证件号码</th>
                          <th <?php if(isset($colshow["contactname"]) && $colshow["contactname"]=="0"): ?> style="display:none" <?php endif; ?>>联系人姓名</th>
                          <th <?php if(isset($colshow["contactidtype"]) && $colshow["contactidtype"]=="0"): ?> style="display:none" <?php endif; ?>>联系人证件类型</th>
                          <th <?php if(isset($colshow["contactidno"]) && $colshow["contactidno"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">联系人证件号码</th>
                          <th <?php if(isset($colshow["contactmobile"]) && $colshow["contactmobile"]=="0"): ?> style="display:none" <?php endif; ?>>联系人手机</th>
                          <th <?php if(isset($colshow["openbank"]) && $colshow["openbank"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">开户银行</th>
                          <th <?php if(isset($colshow["openacctno"]) && $colshow["openacctno"]=="0"): ?> style="display:none" <?php endif; ?>>开户账户号</th>
                          <th <?php if(isset($colshow["openacctname"]) && $colshow["openacctname"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">开户账户名</th>
                          <th <?php if(isset($colshow["chinapay_userid"]) && $colshow["chinapay_userid"]=="0"): ?> style="display:none" <?php endif; ?>>银联账户号</th>
                          <th <?php if(isset($colshow["invoice_flag"]) && $colshow["invoice_flag"]=="0"): ?> style="display:none" <?php endif; ?>>发票要求</th>
                          <th <?php if(isset($colshow["invoice_company"]) && $colshow["invoice_company"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">开票单位</th>
                          <th <?php if(isset($colshow["invoice_address"]) && $colshow["invoice_address"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">开票地址</th>
                          <th <?php if(isset($colshow["invoice_phone"]) && $colshow["invoice_phone"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">开票电话</th>
                          <th <?php if(isset($colshow["invoice_bank"]) && $colshow["invoice_bank"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">开票银行</th>
                          <th <?php if(isset($colshow["invoice_account"]) && $colshow["invoice_account"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">开票账户</th>
                          <th <?php if(isset($colshow["invoice_taxno"]) && $colshow["invoice_taxno"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">开票税号</th>
                          <th <?php if(isset($colshow["invoice_email"]) && $colshow["invoice_email"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">电子票邮箱</th>
                          <th <?php if(isset($colshow["invoice_mobile"]) && $colshow["invoice_mobile"]=="0"): ?> style="display:none" <?php endif; ?>>电子票手机</th>
                          <th <?php if(isset($colshow["contract_linkman"]) && $colshow["contract_linkman"]=="0"): ?> style="display:none" <?php endif; ?>>合同联系人员</th>
                          <th <?php if(isset($colshow["contract_phone"]) && $colshow["contract_phone"]=="0"): ?> style="display:none" <?php endif; ?>>合同联系电话</th>
                          <th <?php if(isset($colshow["contract_fax"]) && $colshow["contract_fax"]=="0"): ?> style="display:none" <?php endif; ?>>合同联系传真</th>
                          <th <?php if(isset($colshow["contract_address"]) && $colshow["contract_address"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">合同邮寄地址</th>
                          <th <?php if(isset($colshow["feesett_linkman"]) && $colshow["feesett_linkman"]=="0"): ?> style="display:none" <?php endif; ?>>结算联系人员</th>
                          <th <?php if(isset($colshow["feesett_phone"]) && $colshow["feesett_phone"]=="0"): ?> style="display:none" <?php endif; ?>>结算联系电话</th>
                          <th <?php if(isset($colshow["feesett_fax"]) && $colshow["feesett_fax"]=="0"): ?> style="display:none" <?php endif; ?>>结算联系传真</th>
                          <th <?php if(isset($colshow["feesett_address"]) && $colshow["feesett_address"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">结算对账单寄</th>
                          <th <?php if(isset($colshow["sms_open"]) && $colshow["sms_open"]=="0"): ?> style="display:none" <?php endif; ?>>短信服务</th>
                          <th <?php if(isset($colshow["sms_transfer_out"]) && $colshow["sms_transfer_out"]=="0"): ?> style="display:none" <?php endif; ?>>货权转出通知</th>
                          <th <?php if(isset($colshow["sms_transfer_in"]) && $colshow["sms_transfer_in"]=="0"): ?> style="display:none" <?php endif; ?>>货权转入通知</th>
                          <th <?php if(isset($colshow["sms_delivery"]) && $colshow["sms_delivery"]=="0"): ?> style="display:none" <?php endif; ?>>提货时通知</th>
                          <th <?php if(isset($colshow["sms_phone"]) && $colshow["sms_phone"]=="0"): ?> style="display:none" <?php endif; ?>>接收手机号</th>
                          <th <?php if(isset($colshow["sms_appellation"]) && $colshow["sms_appellation"]=="0"): ?> style="display:none" <?php endif; ?>>接收者称呼</th>
                          <th <?php if(isset($colshow["apply_time"]) && $colshow["apply_time"]=="0"): ?> style="display:none" <?php endif; ?>>申请时间</th>
                          <th <?php if(isset($colshow["apply_user"]) && $colshow["apply_user"]=="0"): ?> style="display:none" <?php endif; ?>>申请人员</th>
                          <th <?php if(isset($colshow["apply_times"]) && $colshow["apply_times"]=="0"): ?> style="display:none" <?php endif; ?>>申请次数</th>
                          <th <?php if(isset($colshow["reply_time"]) && $colshow["reply_time"]=="0"): ?> style="display:none" <?php endif; ?>>回复时间</th>
                          <th <?php if(isset($colshow["reply_user"]) && $colshow["reply_user"]=="0"): ?> style="display:none" <?php endif; ?>>回复人员</th>
                          <th <?php if(isset($colshow["reply_status"]) && $colshow["reply_status"]=="0"): ?> style="display:none" <?php endif; ?>>回复状态</th>
                          <th <?php if(isset($colshow["create_time"]) && $colshow["create_time"]=="0"): ?> style="display:none" <?php endif; ?>>创建时间</th>
                          <th>状态调整</th>
                           <th></th >
                        </tr>
                        <?php $parent_trNo=""; $group=""; $groupId="";?>
                        <?php if(is_array($list)): $i = 0; $__LIST__ = $list; if( count($__LIST__) == 0) : echo ""; else: foreach($__LIST__ as $key=>$master): $mod = ($i % 2 );++$i; ?>
                                  <?php $seqNo = $i + ($page_size * ($p - 1)); ?>

                                  <?php $trColor = $mod=="1"?"even":"odd"; ?>
                                  <?php if ($master[status]=='0'): $trColor.=" gray-tdbg"; endif; ?>
                                  <?php $trNo=($parent_trNo?$parent_trNo.".":"").$seqNo; ?>
                                  <tr class="<?php echo $trColor; ?>" group="<?php echo $group; ?>" group-id="<?php echo $groupId; ?>">
                                  <!-- 选择 -->
                                  <td class="abe-txtl"><input type="checkbox" name="Key[]" data-type="select" onclick="_asr.selectMulit(this);" value="<?php echo $master['id'] ;?>">&nbsp;<?php echo $trNo; ?></td>
                                  <!-- 序号 -->
                                  <td  class=" abe-txtl ">



          <?php if (isset($rights['master_view']) && $rights['master_view']): ?>
               <a href="javascript:void(0);"  class=" vi-blue vi-blue " onclick="return _asr.openLink('<?php echo U("/Home/Customer/index?func=view&id=$master[id]") ; ?>', '<?php echo filterFuncId(U("/Home/Customer/index?func=view&id=$master[id]"),"");?>' , '<?php echo tabTitle("客户","$master[code]") ; ?>' ,0); "><i class="iconfont abe-ft18">&#xe62e;</i></a>
          <?php endif; ?>





          <?php if (isset($rights['master_edit']) && $rights['master_edit']): ?>
          <?php if (!session('CUSTOMER_ID') && $master[status]==0): ?>
               <a href="javascript:void(0);"  class=" vi-blue vi-blue " onclick="return _asr.popupFun('<?php echo U("/Home/Customer/index?func=edit&id=$master[id]") ; ?>', '<?php echo filterFuncId("/Home/Customer/index?func=edit&id=$master[id]","");?>'); "><i class="iconfont abe-ft15">&#xe63f;</i></a>
          <?php endif; ?>
          <?php endif; ?>





          <?php if (isset($rights['master_delete']) && $rights['master_delete']): ?>
          <?php if (!session('CUSTOMER_ID') && $master[status]==0): ?>
               <a href="javascript:void(0);"  class=" vi-blue vi-blue " onclick="return _asr.confirm('确认操作', '请确认是否删除客户资料?', '<?php echo "客户资料 : $master[code]"; ?>', '<?php echo U("/Home/Customer/index?func=delete&type=1&id=$master[id]") ; ?>','',''); "><i class="iconfont vi-red">&#xe61d;</i></a>
          <?php endif; ?>
          <?php endif; ?></td>


                                  <td style=" <?php if(isset($colshow["status"]) && $colshow["status"]=="0"): ?>display:none<?php endif; ?> " ><?php echo get_table_Customer_status("$master[status]","name","") ; ?></td>
                                  <td style=" <?php if(isset($colshow["category_code"]) && $colshow["category_code"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["category_code"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["industry_code"]) && $colshow["industry_code"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["industry_code"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["code"]) && $colshow["code"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><a href="javascript:void(0);" class="vi-blue"  onclick="return _asr.openLink('<?php echo U("/Home/Customer/index?func=view&id=$master[id]"); ?>','<?php echo filterFuncId( U("/Home/Customer/index?func=view&id=$master[id]") ,"");?>', '<?php echo tabTitle("客户","$master[code]") ; ?>' ,0); " ><?php echo $master["code"] ; ?></a></td>
                                  <td style=" <?php if(isset($colshow["name"]) && $colshow["name"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["name"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["full_name"]) && $colshow["full_name"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["full_name"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["prefix"]) && $colshow["prefix"]=="0"): ?>display:none<?php endif; ?> " ><?php echo $master["prefix"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["abbr"]) && $colshow["abbr"]=="0"): ?>display:none<?php endif; ?> " ><?php echo $master["abbr"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["customer_name"]) && $colshow["customer_name"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["customer_name"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["customer_level"]) && $colshow["customer_level"]=="0"): ?>display:none<?php endif; ?> " ><?php echo get_table_Customer_customer_level("$master[customer_level]","name","") ; ?></td>
                                  <td style=" <?php if(isset($colshow["province"]) && $colshow["province"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["province"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["address"]) && $colshow["address"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><div><?php echo OverView($master["address"],100,"...") ; ?></div></td>
                                  <td style=" <?php if(isset($colshow["postcode"]) && $colshow["postcode"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["postcode"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["phone"]) && $colshow["phone"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["phone"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["linkman"]) && $colshow["linkman"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["linkman"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["mobile"]) && $colshow["mobile"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["mobile"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["corpbusicode"]) && $colshow["corpbusicode"]=="0"): ?>display:none<?php endif; ?> " ><?php echo $master["corpbusicode"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["corptaxcode"]) && $colshow["corptaxcode"]=="0"): ?>display:none<?php endif; ?> " ><?php echo $master["corptaxcode"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["legalpername"]) && $colshow["legalpername"]=="0"): ?>display:none<?php endif; ?> " ><?php echo $master["legalpername"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["legalperidtype"]) && $colshow["legalperidtype"]=="0"): ?>display:none<?php endif; ?> " ><?php echo $master["legalperidtype"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["legalperidno"]) && $colshow["legalperidno"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["legalperidno"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["contactname"]) && $colshow["contactname"]=="0"): ?>display:none<?php endif; ?> " ><?php echo $master["contactname"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["contactidtype"]) && $colshow["contactidtype"]=="0"): ?>display:none<?php endif; ?> " ><?php echo $master["contactidtype"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["contactidno"]) && $colshow["contactidno"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["contactidno"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["contactmobile"]) && $colshow["contactmobile"]=="0"): ?>display:none<?php endif; ?> " ><?php echo $master["contactmobile"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["openbank"]) && $colshow["openbank"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["openbank"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["openacctno"]) && $colshow["openacctno"]=="0"): ?>display:none<?php endif; ?> " ><?php echo $master["openacctno"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["openacctname"]) && $colshow["openacctname"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["openacctname"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["chinapay_userid"]) && $colshow["chinapay_userid"]=="0"): ?>display:none<?php endif; ?> " ><?php echo $master["chinapay_userid"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["invoice_flag"]) && $colshow["invoice_flag"]=="0"): ?>display:none<?php endif; ?> " ><?php echo get_table_Customer_invoice_flag("$master[invoice_flag]","name","") ; ?></td>
                                  <td style=" <?php if(isset($colshow["invoice_company"]) && $colshow["invoice_company"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["invoice_company"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["invoice_address"]) && $colshow["invoice_address"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["invoice_address"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["invoice_phone"]) && $colshow["invoice_phone"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["invoice_phone"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["invoice_bank"]) && $colshow["invoice_bank"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["invoice_bank"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["invoice_account"]) && $colshow["invoice_account"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["invoice_account"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["invoice_taxno"]) && $colshow["invoice_taxno"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["invoice_taxno"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["invoice_email"]) && $colshow["invoice_email"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["invoice_email"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["invoice_mobile"]) && $colshow["invoice_mobile"]=="0"): ?>display:none<?php endif; ?> " ><?php echo $master["invoice_mobile"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["contract_linkman"]) && $colshow["contract_linkman"]=="0"): ?>display:none<?php endif; ?> " ><?php echo $master["contract_linkman"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["contract_phone"]) && $colshow["contract_phone"]=="0"): ?>display:none<?php endif; ?> " ><?php echo $master["contract_phone"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["contract_fax"]) && $colshow["contract_fax"]=="0"): ?>display:none<?php endif; ?> " ><?php echo $master["contract_fax"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["contract_address"]) && $colshow["contract_address"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["contract_address"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["feesett_linkman"]) && $colshow["feesett_linkman"]=="0"): ?>display:none<?php endif; ?> " ><?php echo $master["feesett_linkman"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["feesett_phone"]) && $colshow["feesett_phone"]=="0"): ?>display:none<?php endif; ?> " ><?php echo $master["feesett_phone"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["feesett_fax"]) && $colshow["feesett_fax"]=="0"): ?>display:none<?php endif; ?> " ><?php echo $master["feesett_fax"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["feesett_address"]) && $colshow["feesett_address"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["feesett_address"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["sms_open"]) && $colshow["sms_open"]=="0"): ?>display:none<?php endif; ?> " ><?php echo get_table_Customer_sms_open("$master[sms_open]","name","") ; ?></td>
                                  <td style=" <?php if(isset($colshow["sms_transfer_out"]) && $colshow["sms_transfer_out"]=="0"): ?>display:none<?php endif; ?> " ><?php echo get_table_Customer_sms_transfer_out("$master[sms_transfer_out]","name","") ; ?></td>
                                  <td style=" <?php if(isset($colshow["sms_transfer_in"]) && $colshow["sms_transfer_in"]=="0"): ?>display:none<?php endif; ?> " ><?php echo get_table_Customer_sms_transfer_in("$master[sms_transfer_in]","name","") ; ?></td>
                                  <td style=" <?php if(isset($colshow["sms_delivery"]) && $colshow["sms_delivery"]=="0"): ?>display:none<?php endif; ?> " ><?php echo get_table_Customer_sms_delivery("$master[sms_delivery]","name","") ; ?></td>
                                  <td style=" <?php if(isset($colshow["sms_phone"]) && $colshow["sms_phone"]=="0"): ?>display:none<?php endif; ?> " ><?php echo $master["sms_phone"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["sms_appellation"]) && $colshow["sms_appellation"]=="0"): ?>display:none<?php endif; ?> " ><?php echo $master["sms_appellation"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["apply_time"]) && $colshow["apply_time"]=="0"): ?>display:none<?php endif; ?> " ><?php echo system_format("DT", $master["apply_time"],1) ; ?></td>
                                  <td style=" <?php if(isset($colshow["apply_user"]) && $colshow["apply_user"]=="0"): ?>display:none<?php endif; ?> " ><?php echo $master["apply_user"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["apply_times"]) && $colshow["apply_times"]=="0"): ?>display:none<?php endif; ?> " class=" <?php if ($master['apply_times']<0): ?> abe-red <?php endif; ?> "><?php echo system_format("N3", $master["apply_times"],1) ; ?></td>
                                  <td style=" <?php if(isset($colshow["reply_time"]) && $colshow["reply_time"]=="0"): ?>display:none<?php endif; ?> " ><?php echo system_format("DT", $master["reply_time"],1) ; ?></td>
                                  <td style=" <?php if(isset($colshow["reply_user"]) && $colshow["reply_user"]=="0"): ?>display:none<?php endif; ?> " ><?php echo $master["reply_user"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["reply_status"]) && $colshow["reply_status"]=="0"): ?>display:none<?php endif; ?> " ><?php echo get_table_Customer_reply_status("$master[reply_status]","name","") ; ?></td>
                                  <td style=" <?php if(isset($colshow["create_time"]) && $colshow["create_time"]=="0"): ?>display:none<?php endif; ?> " ><?php echo system_format("DT", $master["create_time"],1) ; ?></td>
                                  <td>


          <?php if (isset($rights['status_on']) && $rights['status_on']): ?>
          <?php if (!$master['status']): ?>
               <input type="button" value="转有效" class="btn btn-sm btn-blue mlg_10 " onclick="return _asr.popupFun('<?php echo U("/Home/Customer/index?func=status_on&id=$master[id]") ; ?>', '<?php echo filterFuncId("/Home/Customer/index?func=status_on&id=$master[id]","");?>'); " />
          <?php endif; ?>
          <?php endif; ?>



          <?php if (isset($rights['status_off']) && $rights['status_off']): ?>
          <?php if ($master['status']=='1'): ?>
               <input type="button" value="转无效" class="btn btn-sm btn-org mlg_10 " onclick="return _asr.popupFun('<?php echo U("/Home/Customer/index?func=status_off&id=$master[id]") ; ?>', '<?php echo filterFuncId("/Home/Customer/index?func=status_off&id=$master[id]","");?>'); " />
          <?php endif; ?>
          <?php endif; ?></td>

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
            _asr.setvaluebyname(_frm,"category_code_name","");
            _asr.setvaluebyname(_frm,"category_code","");
            _asr.setvaluebyname(_frm,"industry_code","");
            _asr.setvaluebyname(_frm,"code","");
            _asr.setvaluebyname(_frm,"name","");
            _asr.setvaluebyname(_frm,"full_name","");
            _asr.setvaluebyname(_frm,"prefix","");
            _asr.setvaluebyname(_frm,"abbr","");
            _asr.setvaluebyname(_frm,"customer_name","");
            _asr.setvaluebyname(_frm,"customer_level","");
            _asr.setvaluebyname(_frm,"province","");
            _asr.setvaluebyname(_frm,"address","");
            _asr.setvaluebyname(_frm,"postcode","");
            _asr.setvaluebyname(_frm,"phone","");
            _asr.setvaluebyname(_frm,"linkman","");
            _asr.setvaluebyname(_frm,"mobile","");
            _asr.setvaluebyname(_frm,"corpbusicode","");
            _asr.setvaluebyname(_frm,"corptaxcode","");
            _asr.setvaluebyname(_frm,"legalpername","");
            _asr.setvaluebyname(_frm,"legalperidtype","");
            _asr.setvaluebyname(_frm,"legalperidno","");
            _asr.setvaluebyname(_frm,"contactname","");
            _asr.setvaluebyname(_frm,"contactidtype","");
            _asr.setvaluebyname(_frm,"contactidno","");
            _asr.setvaluebyname(_frm,"contactmobile","");
            _asr.setvaluebyname(_frm,"openbank","");
            _asr.setvaluebyname(_frm,"openacctno","");
            _asr.setvaluebyname(_frm,"openacctname","");
            _asr.setvaluebyname(_frm,"chinapay_userid","");
            _asr.setvaluebyname(_frm,"invoice_flag","");
            _asr.setvaluebyname(_frm,"invoice_company","");
            _asr.setvaluebyname(_frm,"invoice_address","");
            _asr.setvaluebyname(_frm,"invoice_phone","");
            _asr.setvaluebyname(_frm,"invoice_bank","");
            _asr.setvaluebyname(_frm,"invoice_account","");
            _asr.setvaluebyname(_frm,"invoice_taxno","");
            _asr.setvaluebyname(_frm,"invoice_email","");
            _asr.setvaluebyname(_frm,"invoice_mobile","");
            _asr.setvaluebyname(_frm,"contract_linkman","");
            _asr.setvaluebyname(_frm,"contract_phone","");
            _asr.setvaluebyname(_frm,"contract_fax","");
            _asr.setvaluebyname(_frm,"contract_address","");
            _asr.setvaluebyname(_frm,"feesett_linkman","");
            _asr.setvaluebyname(_frm,"feesett_phone","");
            _asr.setvaluebyname(_frm,"feesett_fax","");
            _asr.setvaluebyname(_frm,"feesett_address","");
            _asr.setvaluebyname(_frm,"sms_open","");
            _asr.setvaluebyname(_frm,"sms_transfer_out","");
            _asr.setvaluebyname(_frm,"sms_transfer_in","");
            _asr.setvaluebyname(_frm,"sms_delivery","");
            _asr.setvaluebyname(_frm,"sms_phone","");
            _asr.setvaluebyname(_frm,"sms_appellation","");
            _asr.setvaluebyname(_frm,"apply_time","");
            _asr.setvaluebyname(_frm,"apply_time2","");
            _asr.setvaluebyname(_frm,"apply_user","");
            _asr.setvaluebyname(_frm,"apply_times","");
            _asr.setvaluebyname(_frm,"apply_times2","");
            _asr.setvaluebyname(_frm,"reply_time","");
            _asr.setvaluebyname(_frm,"reply_time2","");
            _asr.setvaluebyname(_frm,"reply_user","");
            _asr.setvaluebyname(_frm,"reply_status","");

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


    <?php echo W('Summary/javascript',array('CustomerSummary'));?>


    </script>