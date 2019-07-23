<?php if (!defined('THINK_PATH')) exit();?>
<div toplayer="1" class="prompt-pop pop-style3" style="z-index:<?php echo ($zindex); ?>;width:800px;" id="<?php echo $funcid;?>" url="<?php echo U('Customer/index'); ?>">

   <div class="title">
       <span class="pop-name"><?php echo $search[id]?'编辑':'新增'; ?>客户资料信息</span>
       <a href="javascript:void(0);" onclick="$(this).parents('.prompt-pop').remove();_asr.closePopup('<?php echo ($funcid); ?>');" class="close iconfont">&#xe60d;</a>
   </div>


<div class="pop-scroll">
   <div class="screening ">
      <form enctype="multipart/form-data" action="<?php echo U('Customer/index?func=save'); ?>" id="<?php echo "$funcid"; ?>-Search" method="post">
          <input type="hidden" name="<?php echo "$funcid"; ?>-last-url" id="<?php echo "$funcid"; ?>-last-url" value="<?php echo $__last_url; ?>" />
          <input type="hidden" name="funcid" value="<?php echo "$funcid"; ?>" />
          <input type="hidden" name="pfuncid" value="<?php echo "$pfuncid"; ?>" />
          <input type="hidden" name="id" value="<?php echo $search["id"]; ?>" />
          <input type="hidden" name="_lastchanged" value="<?php echo $search["lastchanged"]; ?>" />
          <ul class="form form-mod-new form-column2">

             <li>
                  <div class="unit-left"><span class="tit"> 客户类型<em class="abe-red mrg_5">*</em></span></div>
                  <div class="unit-mid">
                       <div class="dropdown" id="<?php echo ($funcid); ?>_type">
                           <select class="pbsele dropdown0" name="type">
                              <option value="" <?php if($search['type'] == ''): ?> selected="selected" <?php endif;?> ></option>
                             <?php
 $keyvalue = table_Customer_type(); if(is_array($keyvalue)){ $i = 0; $__LIST__ = $keyvalue; ?>
                                    <?php foreach($__LIST__ as $key=>$item): ++$i; ?>
                                 <option value="<?php echo $item['id']; ?>" <?php if($item['id'] == $search['type']): ?> selected="selected" <?php endif;?>><?php echo $item['name']; ?></option>
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
                 <div class="unit-left"><span class="tit"> 客户分类</span></div>

                 <!--  date:2019-6-17 原因:将原有的下拉框改为弹出框

                  <div class="unit-mid">
                       <div class="dropdown" id="<?php echo ($funcid); ?>_category_code">
                           <select class="pbsele dropdown0" name="category_code">
                              <option value="" <?php if($search['category_code'] == ''): ?> selected="selected" <?php endif;?> ></option>
                             <?php
 $keyvalue = subcode('customer:category'); if(is_array($keyvalue)){ $i = 0; $__LIST__ = $keyvalue; ?>
                                    <?php foreach($__LIST__ as $key=>$item): ++$i; ?>
                                 <option value="<?php echo $item['code']; ?>" <?php if($item['code'] == $search['category_code']): ?> selected="selected" <?php endif;?>><?php echo $item['name']; ?></option>
                                    <?php endforeach; ?>
                             <?php } ?>
                           </select>
                       </div>
                      <div class="prompt" style="display:none">
                          <div class="error"><i class="iconfont">&#xe616;</i></div>
                      </div>
                  </div>-->

                 <div class="unit-mid">
                     <div class="popup">
                         <input  type="text" class="pbtxt txt0" name="parent_id_name" readonly="readonly" value="<?php echo $search['parent_id_name']; ?>">
                         <button type="submit" class="txt-search" onclick="return _asr.popup('CustomerCategory','<?php echo "$funcid"; ?>','<?php echo "$funcid"; ?>-Search','Single','parent_id','parent_id_name'); " <?php if($search["parent_id_name"]): ?> style="display:none"<?php endif; ?> ><i class="iconfont">&#xe60e;</i></button>
                         <button type="submit" class="txt-clear" onclick="_asr.setvaluebyname('<?php echo "$funcid"; ?>-Search','parent_id','');_asr.setvaluebyname('<?php echo "$funcid"; ?>-Search','parent_id_name','');return false;" <?php if(!$search["parent_id_name"]): ?> style="display:none"<?php endif; ?> ><i class="iconfont">&#xe616;</i></button>
                     </div>
                     <input type="hidden" name="parent_id" value="<?php echo $search['parent_id']; ?>">
                     <div class="prompt" style="display:none">
                         <div class="error"><i class="iconfont">&#xe616;</i></div>
                     </div>
                 </div>

             </li>
             <li>
                  <div class="unit-left"><span class="tit"> 客户代码<em class="abe-red mrg_5">*</em></span></div>
                  <div class="unit-mid">
                       <div class="textbox">
                            <input type="text" class="pbtxt txt0" name="code"  value="<?php echo $search['code']; ?>"  >
                       </div>
                      <div class="prompt" style="display:none">
                          <div class="error"><i class="iconfont">&#xe616;</i></div>
                      </div>
                  </div>
             </li>
             <li>
                  <div class="unit-left"><span class="tit"> 客户简称<em class="abe-red mrg_5">*</em></span></div>
                  <div class="unit-mid">
                       <div class="textbox">
                            <input type="text" class="pbtxt txt0" name="name"  value="<?php echo $search['name']; ?>"  >
                       </div>
                      <div class="prompt" style="display:none">
                          <div class="error"><i class="iconfont">&#xe616;</i></div>
                      </div>
                  </div>
             </li>
             <li class="per100">
                  <div class="unit-left"><span class="tit"> 客户全称</span></div>
                  <div class="unit-mid">
                       <div class="textbox">
                            <input type="text" class="pbtxt txt0" name="full_name"  value="<?php echo $search['full_name']; ?>"   onblur="_asr.getPinyin(this, $('#<?php echo $funcid;?>').find('input[name=prefix]'));">
                       </div>
                      <div class="prompt" style="display:none">
                          <div class="error"><i class="iconfont">&#xe616;</i></div>
                      </div>
                  </div>
             </li>
             <li>
                  <div class="unit-left"><span class="tit"> 助记码</span></div>
                  <div class="unit-mid">
                       <div class="textbox">
                            <input type="text" class="pbtxt txt0" name="prefix"  value="<?php echo $search['prefix']; ?>"  >
                       </div>
                      <div class="prompt" style="display:none">
                          <div class="error"><i class="iconfont">&#xe616;</i></div>
                      </div>
                  </div>
             </li>
             <li>
                  <div class="unit-left"><span class="tit"> 行业分类</span></div>
                  <div class="unit-mid">
                       <div class="dropdown" id="<?php echo ($funcid); ?>_industry_code">
                           <select class="pbsele dropdown0" name="industry_code">
                              <option value="" <?php if($search['industry_code'] == ''): ?> selected="selected" <?php endif;?> ></option>
                             <?php
 $keyvalue = subcode('customer:industry'); if(is_array($keyvalue)){ $i = 0; $__LIST__ = $keyvalue; ?>
                                    <?php foreach($__LIST__ as $key=>$item): ++$i; ?>
                                 <option value="<?php echo $item['code']; ?>" <?php if($item['code'] == $search['industry_code']): ?> selected="selected" <?php endif;?>><?php echo $item['name']; ?></option>
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
                  <div class="unit-left"><span class="tit"> 省份</span></div>
                  <div class="unit-mid">
                       <div class="textbox">
                            <input type="text" class="pbtxt txt0" name="province"  value="<?php echo $search['province']; ?>"  >
                       </div>
                      <div class="prompt" style="display:none">
                          <div class="error"><i class="iconfont">&#xe616;</i></div>
                      </div>
                  </div>
             </li>
             <li class="per100">
                  <div class="unit-left"><span class="tit"> 联系地址</span></div>
                  <div class="unit-mid">
                       <div class="textbox">
                            <input type="text" class="pbtxt txt0" name="address"  value="<?php echo $search['address']; ?>"  >
                       </div>
                      <div class="prompt" style="display:none">
                          <div class="error"><i class="iconfont">&#xe616;</i></div>
                      </div>
                  </div>
             </li>
             <li>
                  <div class="unit-left"><span class="tit"> 邮政编码</span></div>
                  <div class="unit-mid">
                       <div class="textbox">
                            <input type="text" class="pbtxt txt0" name="postcode"  value="<?php echo $search['postcode']; ?>"  >
                       </div>
                      <div class="prompt" style="display:none">
                          <div class="error"><i class="iconfont">&#xe616;</i></div>
                      </div>
                  </div>
             </li>
             <li>
                  <div class="unit-left"><span class="tit"> 联系电话</span></div>
                  <div class="unit-mid">
                       <div class="textbox">
                            <input type="text" class="pbtxt txt0" name="phone"  value="<?php echo $search['phone']; ?>"  >
                       </div>
                      <div class="prompt" style="display:none">
                          <div class="error"><i class="iconfont">&#xe616;</i></div>
                      </div>
                  </div>
             </li>
             <li>
                  <div class="unit-left"><span class="tit"> 联系手机</span></div>
                  <div class="unit-mid">
                       <div class="textbox">
                            <input type="text" class="pbtxt txt0" name="mobile"  value="<?php echo $search['mobile']; ?>"  >
                       </div>
                      <div class="prompt" style="display:none">
                          <div class="error"><i class="iconfont">&#xe616;</i></div>
                      </div>
                  </div>
             </li>
             <li>
                  <div class="unit-left"><span class="tit"> 联系人员</span></div>
                  <div class="unit-mid">
                       <div class="textbox">
                            <input type="text" class="pbtxt txt0" name="linkman"  value="<?php echo $search['linkman']; ?>"  >
                       </div>
                      <div class="prompt" style="display:none">
                          <div class="error"><i class="iconfont">&#xe616;</i></div>
                      </div>
                  </div>
             </li>
             <li class="per100">
                  <div class="unit-left"><span class="tit"> 开票名称</span></div>
                  <div class="unit-mid">
                       <div class="textbox">
                            <input type="text" class="pbtxt txt0" name="invoice_company"  value="<?php echo $search['invoice_company']; ?>"  >
                       </div>
                      <div class="prompt" style="display:none">
                          <div class="error"><i class="iconfont">&#xe616;</i></div>
                      </div>
                  </div>
             </li>
             <li class="per100">
                  <div class="unit-left"><span class="tit"> 开票地址</span></div>
                  <div class="unit-mid">
                       <div class="textbox">
                            <input type="text" class="pbtxt txt0" name="invoice_address"  value="<?php echo $search['invoice_address']; ?>"  >
                       </div>
                      <div class="prompt" style="display:none">
                          <div class="error"><i class="iconfont">&#xe616;</i></div>
                      </div>
                  </div>
             </li>
             <li>
                  <div class="unit-left"><span class="tit"> 开票电话</span></div>
                  <div class="unit-mid">
                       <div class="textbox">
                            <input type="text" class="pbtxt txt0" name="invoice_phone"  value="<?php echo $search['invoice_phone']; ?>"  >
                       </div>
                      <div class="prompt" style="display:none">
                          <div class="error"><i class="iconfont">&#xe616;</i></div>
                      </div>
                  </div>
             </li>
             <li>
                  <div class="unit-left"><span class="tit"> 开票银行</span></div>
                  <div class="unit-mid">
                       <div class="textbox">
                            <input type="text" class="pbtxt txt0" name="invoice_bank"  value="<?php echo $search['invoice_bank']; ?>"  >
                       </div>
                      <div class="prompt" style="display:none">
                          <div class="error"><i class="iconfont">&#xe616;</i></div>
                      </div>
                  </div>
             </li>
             <li>
                  <div class="unit-left"><span class="tit"> 开票税号</span></div>
                  <div class="unit-mid">
                       <div class="textbox">
                            <input type="text" class="pbtxt txt0" name="invoice_taxno"  value="<?php echo $search['invoice_taxno']; ?>"  >
                       </div>
                      <div class="prompt" style="display:none">
                          <div class="error"><i class="iconfont">&#xe616;</i></div>
                      </div>
                  </div>
             </li>
             <li>
                  <div class="unit-left"><span class="tit"> 开票账户</span></div>
                  <div class="unit-mid">
                       <div class="textbox">
                            <input type="text" class="pbtxt txt0" name="invoice_account"  value="<?php echo $search['invoice_account']; ?>"  >
                       </div>
                      <div class="prompt" style="display:none">
                          <div class="error"><i class="iconfont">&#xe616;</i></div>
                      </div>
                  </div>
             </li>
             <li>
                  <div class="unit-left"><span class="tit"> 营业执照号</span></div>
                  <div class="unit-mid">
                       <div class="textbox">
                            <input type="text" class="pbtxt txt0" name="CorpBusiCode"  value="<?php echo $search['CorpBusiCode']; ?>"  >
                       </div>
                      <div class="prompt" style="display:none">
                          <div class="error"><i class="iconfont">&#xe616;</i></div>
                      </div>
                  </div>
             </li>
             <li>
                  <div class="unit-left"><span class="tit"> 税务登记证</span></div>
                  <div class="unit-mid">
                       <div class="textbox">
                            <input type="text" class="pbtxt txt0" name="CorpTaxCode"  value="<?php echo $search['CorpTaxCode']; ?>"  >
                       </div>
                      <div class="prompt" style="display:none">
                          <div class="error"><i class="iconfont">&#xe616;</i></div>
                      </div>
                  </div>
             </li>
             <li>
                  <div class="unit-left"><span class="tit"> 法人姓名</span></div>
                  <div class="unit-mid">
                       <div class="textbox">
                            <input type="text" class="pbtxt txt0" name="LegalPerName"  value="<?php echo $search['LegalPerName']; ?>"  >
                       </div>
                      <div class="prompt" style="display:none">
                          <div class="error"><i class="iconfont">&#xe616;</i></div>
                      </div>
                  </div>
             </li>
             <li>
                  <div class="unit-left"><span class="tit"> 法人证件类型</span></div>
                  <div class="unit-mid">
                       <div class="textbox">
                            <input type="text" class="pbtxt txt0" name="LegalPerIdType"  value="<?php echo $search['LegalPerIdType']; ?>"  >
                       </div>
                      <div class="prompt" style="display:none">
                          <div class="error"><i class="iconfont">&#xe616;</i></div>
                      </div>
                  </div>
             </li>
             <li>
                  <div class="unit-left"><span class="tit"> 法人证件号码</span></div>
                  <div class="unit-mid">
                       <div class="textbox">
                            <input type="text" class="pbtxt txt0" name="LegalPerIdNo"  value="<?php echo $search['LegalPerIdNo']; ?>"  >
                       </div>
                      <div class="prompt" style="display:none">
                          <div class="error"><i class="iconfont">&#xe616;</i></div>
                      </div>
                  </div>
             </li>
             <li>
                  <div class="unit-left"><span class="tit"> 联系人姓名</span></div>
                  <div class="unit-mid">
                       <div class="textbox">
                            <input type="text" class="pbtxt txt0" name="ContactName"  value="<?php echo $search['ContactName']; ?>"  >
                       </div>
                      <div class="prompt" style="display:none">
                          <div class="error"><i class="iconfont">&#xe616;</i></div>
                      </div>
                  </div>
             </li>
             <li>
                  <div class="unit-left"><span class="tit"> 联系人证件类型</span></div>
                  <div class="unit-mid">
                       <div class="textbox">
                            <input type="text" class="pbtxt txt0" name="ContactIdType"  value="<?php echo $search['ContactIdType']; ?>"  >
                       </div>
                      <div class="prompt" style="display:none">
                          <div class="error"><i class="iconfont">&#xe616;</i></div>
                      </div>
                  </div>
             </li>
             <li>
                  <div class="unit-left"><span class="tit"> 联系人证件号码</span></div>
                  <div class="unit-mid">
                       <div class="textbox">
                            <input type="text" class="pbtxt txt0" name="ContactIdNo"  value="<?php echo $search['ContactIdNo']; ?>"  >
                       </div>
                      <div class="prompt" style="display:none">
                          <div class="error"><i class="iconfont">&#xe616;</i></div>
                      </div>
                  </div>
             </li>
             <li>
                  <div class="unit-left"><span class="tit"> 联系人手机</span></div>
                  <div class="unit-mid">
                       <div class="textbox">
                            <input type="text" class="pbtxt txt0" name="ContactMobile"  value="<?php echo $search['ContactMobile']; ?>"  >
                       </div>
                      <div class="prompt" style="display:none">
                          <div class="error"><i class="iconfont">&#xe616;</i></div>
                      </div>
                  </div>
             </li>
             <li>
                  <div class="unit-left"><span class="tit"> 开户银行</span></div>
                  <div class="unit-mid">
                       <div class="textbox">
                            <input type="text" class="pbtxt txt0" name="OpenBank"  value="<?php echo $search['OpenBank']; ?>"  >
                       </div>
                      <div class="prompt" style="display:none">
                          <div class="error"><i class="iconfont">&#xe616;</i></div>
                      </div>
                  </div>
             </li>
             <li>
                  <div class="unit-left"><span class="tit"> 开户账户号</span></div>
                  <div class="unit-mid">
                       <div class="textbox">
                            <input type="text" class="pbtxt txt0" name="OpenAcctNo"  value="<?php echo $search['OpenAcctNo']; ?>"  >
                       </div>
                      <div class="prompt" style="display:none">
                          <div class="error"><i class="iconfont">&#xe616;</i></div>
                      </div>
                  </div>
             </li>
             <li>
                  <div class="unit-left"><span class="tit"> 开户账户名</span></div>
                  <div class="unit-mid">
                       <div class="textbox">
                            <input type="text" class="pbtxt txt0" name="OpenAcctName"  value="<?php echo $search['OpenAcctName']; ?>"  >
                       </div>
                      <div class="prompt" style="display:none">
                          <div class="error"><i class="iconfont">&#xe616;</i></div>
                      </div>
                  </div>
             </li>
             <li>
                  <div class="unit-left"><span class="tit"> 银联账户号</span></div>
                  <div class="unit-mid">
                       <div class="textbox">
                            <input type="text" class="pbtxt txt0" name="chinapay_userid"  value="<?php echo $search['chinapay_userid']; ?>"  >
                       </div>
                      <div class="prompt" style="display:none">
                          <div class="error"><i class="iconfont">&#xe616;</i></div>
                      </div>
                  </div>
             </li>
             <li>
                  <div class="unit-left"><span class="tit"> 选择层级</span></div>
                  <div class="unit-mid">
                       <div class="dropdown" id="<?php echo ($funcid); ?>_customer_level">
                           <select class="pbsele dropdown0" name="customer_level">
                             <?php
 $keyvalue = table_Customer_customer_level(); if(is_array($keyvalue)){ $i = 0; $__LIST__ = $keyvalue; ?>
                                    <?php foreach($__LIST__ as $key=>$item): ++$i; ?>
                                 <option value="<?php echo $item['id']; ?>" <?php if($item['id'] == $search['customer_level']): ?> selected="selected" <?php endif;?>><?php echo $item['name']; ?></option>
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
                  <div class="unit-left">状态 <em class="abe-red">*</em></div>
                  <div class="unit-mid">
                      <div class="dropdown">
                          <select class="pbsele dropdown0" name="status"  >
                              <option value="0" <?php if($search['status'] == 0) { ?>selected="selected"<?php } ?>>无效</option>
                              <option value="1" <?php if($search['status'] == 1) { ?>selected="selected"<?php } ?>>有效</option>
                          </select>
                      </div>
                      <div class="prompt" style="display:none">
                          <div class="error"><i class="iconfont">&#xe616;</i></div>
                      </div>
                  </div>
             </li>
             <li class="per100">
                  <div class="unit-left"><span class="tit"> 备注</span></div>
                  <div class="unit-mid">
                       <textarea class="textarea0" name="remarks"   ><?php echo $search['remarks']; ?></textarea>
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


               <input type="button" value="提交" class="btn btn-blue mrg_10 " onclick="return _asr.submit('<?php echo "$funcid"; ?>', '<?php echo "$funcid"; ?>-Search', '<?php echo U("/Home/Customer/index?func=save&id=$search[id]") ; ?>',''); " />

               <input type="button" value="取消" class="btn btn-org mrg_10 " onclick="$(this).parents('.prompt-pop').remove();_asr.closePopup('<?php echo ($funcid); ?>');" />
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


        /***************************************************************************************/
        /* 前台页面初始化                                                                      */
        /***************************************************************************************/
        function <?php echo $funcid; ?>_init(_id){
            return ;
        }

        /***************************************************************************************/
        /* 前台页面清除                                                                      */
        /***************************************************************************************/
        function <?php echo $funcid; ?>_clearsearch(_frm){

            _asr.setvaluebyname(_frm,"type", "" );
            _asr.setvaluebyname(_frm,"category_code", "" );
            _asr.setvaluebyname(_frm,"code", "" );
            _asr.setvaluebyname(_frm,"name", "" );
            _asr.setvaluebyname(_frm,"full_name", "" );
            _asr.setvaluebyname(_frm,"prefix", "" );
            _asr.setvaluebyname(_frm,"industry_code", "" );
            _asr.setvaluebyname(_frm,"province", "" );
            _asr.setvaluebyname(_frm,"address", "" );
            _asr.setvaluebyname(_frm,"postcode", "" );
            _asr.setvaluebyname(_frm,"phone", "" );
            _asr.setvaluebyname(_frm,"mobile", "" );
            _asr.setvaluebyname(_frm,"linkman", "" );
            _asr.setvaluebyname(_frm,"invoice_company", "" );
            _asr.setvaluebyname(_frm,"invoice_address", "" );
            _asr.setvaluebyname(_frm,"invoice_phone", "" );
            _asr.setvaluebyname(_frm,"invoice_bank", "" );
            _asr.setvaluebyname(_frm,"invoice_taxno", "" );
            _asr.setvaluebyname(_frm,"invoice_account", "" );
            _asr.setvaluebyname(_frm,"CorpBusiCode", "" );
            _asr.setvaluebyname(_frm,"CorpTaxCode", "" );
            _asr.setvaluebyname(_frm,"LegalPerName", "" );
            _asr.setvaluebyname(_frm,"LegalPerIdType", "" );
            _asr.setvaluebyname(_frm,"LegalPerIdNo", "" );
            _asr.setvaluebyname(_frm,"ContactName", "" );
            _asr.setvaluebyname(_frm,"ContactIdType", "" );
            _asr.setvaluebyname(_frm,"ContactIdNo", "" );
            _asr.setvaluebyname(_frm,"ContactMobile", "" );
            _asr.setvaluebyname(_frm,"OpenBank", "" );
            _asr.setvaluebyname(_frm,"OpenAcctNo", "" );
            _asr.setvaluebyname(_frm,"OpenAcctName", "" );
            _asr.setvaluebyname(_frm,"chinapay_userid", "" );
            _asr.setvaluebyname(_frm,"customer_level", "" );
            _asr.setvaluebyname(_frm,"remarks", "" );


          $("#<?php echo ($funcid); ?>").find(".selebtn").each(function(){
              $(this).find("a:eq(0)").click();
            });

          $("#<?php echo ($funcid); ?> .city-tags-new .sele-remove").click();
        }

   function <?php echo $funcid;?>_callback(param){
        _asr.closePopup('<?php echo ($funcid); ?>');
   }



    <?php echo W('Summary/javascript',array('Customer'));?>

</script>