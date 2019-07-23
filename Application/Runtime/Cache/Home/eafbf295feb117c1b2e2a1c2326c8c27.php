<?php if (!defined('THINK_PATH')) exit();?>
<div toplayer="1" class="prompt-pop pop-style3" style="z-index:<?php echo ($zindex); ?>;width:800px;" id="<?php echo $funcid;?>" url="<?php echo U('GoodsStyle/index'); ?>">

    <div class="title">
        <span class="pop-name"><?php echo $search[id]?'编辑':'新增'; ?>货品信息</span>
        <a href="javascript:void(0);" onclick="$(this).parents('.prompt-pop').remove();_asr.closePopup('<?php echo ($funcid); ?>');" class="close iconfont">&#xe60d;</a>
    </div>



    <div class="pop-scroll">
        <div class="screening ">
            <form enctype="multipart/form-data" action="<?php echo U('GoodsStyle/index?func=save'); ?>" id="<?php echo "$funcid"; ?>-Search" method="post">
            <input type="hidden" name="<?php echo "$funcid"; ?>-last-url" id="<?php echo "$funcid"; ?>-last-url" value="<?php echo $__last_url; ?>" />
            <input type="hidden" name="funcid" value="<?php echo "$funcid"; ?>" />
            <input type="hidden" name="pfuncid" value="<?php echo "$pfuncid"; ?>" />
            <input type="hidden" name="id" value="<?php echo $search["id"]; ?>" />
            <input type="hidden" name="_lastchanged" value="<?php echo $search["lastchanged"]; ?>" />
            <ul class="form form-mod-new form-column2">

                <li >
                    <div class="unit-left"><span class="tit"> 货品分类</span></div>
                    <div class="unit-mid">
                        <div class="popup">
                            <input  type="text" class="pbtxt txt0" name="parent_id_name" readonly="readonly" value="<?php echo $search['parent_id_name']; ?>">
                            <button type="submit" class="txt-search" onclick="return _asr.popup('GoodsCategory','<?php echo "$funcid"; ?>','<?php echo "$funcid"; ?>-Search','Single','parent_id','parent_id_name'); " <?php if($search["parent_id_name"]): ?> style="display:none"<?php endif; ?> ><i class="iconfont">&#xe60e;</i></button>
                            <button type="submit" class="txt-clear" onclick="_asr.setvaluebyname('<?php echo "$funcid"; ?>-Search','parent_id','');_asr.setvaluebyname('<?php echo "$funcid"; ?>-Search','parent_id_name','');return false;" <?php if(!$search["parent_id_name"]): ?> style="display:none"<?php endif; ?> ><i class="iconfont">&#xe616;</i></button>
                        </div>
                        <input type="hidden" name="parent_id" value="<?php echo $search['parent_id']; ?>">
                        <input type="hidden" name="category_code" value="<?php echo $search['category_code']; ?>">
                        <div class="prompt" style="display:none">
                            <div class="error"><i class="iconfont">&#xe616;</i></div>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="unit-left"><span class="tit"> 货品代码<em class="abe-red mrg_5">*</em></span></div>
                    <div class="unit-mid">
                        <div class="textbox">
                            <input type="text" class="pbtxt txt0" name="style_code"  value="<?php echo $search['style_code']; ?>"  >
                        </div>
                        <div class="prompt" style="display:none">
                            <div class="error"><i class="iconfont">&#xe616;</i></div>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="unit-left"><span class="tit"> 货品名称<em class="abe-red mrg_5">*</em></span></div>
                    <div class="unit-mid">
                        <div class="textbox">
                            <input type="text" class="pbtxt txt0" name="style_name"  value="<?php echo $search['style_name']; ?>"  onblur="_asr.getPinyin(this, $('#<?php echo $funcid;?>').find('input[name=prefix]'));" >
                        </div>
                        <div class="prompt" style="display:none">
                            <div class="error"><i class="iconfont">&#xe616;</i></div>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="unit-left"><span class="tit"> 材质</span></div>
                    <div class="unit-mid">
                        <div class="textbox">
                            <input type="text" class="pbtxt txt0" name="materials"  value="<?php echo $search['materials']; ?>"  >
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
                <!--<li>
                    <div class="unit-left"><span class="tit"> 数量单位</span></div>
                    <div class="unit-mid">
                        <div class="textbox">
                            <input type="text" class="pbtxt txt0" name="uom_qty"  value="<?php echo $search['uom_qty']; ?>"  >
                        </div>
                        <div class="prompt" style="display:none">
                            <div class="error"><i class="iconfont">&#xe616;</i></div>
                        </div>
                    </div>
                </li>
-->
                <li>
                    <div class="unit-left"><span class="tit"> 数量单位<em class="abe-red mrg_5">*</em></span></span></div>
                    <div class="unit-mid">
                        <div class="dropdown" id="<?php echo ($funcid); ?>_uom_qty">
                            <select class="pbsele dropdown0" name="uom_qty">
                                <option value="" <?php if($search['uom_qty'] == ''): ?> selected="selected" <?php endif;?> ></option>
                                <?php
 $keyvalue = subcode('UOM_QTY'); if(is_array($keyvalue)){ $i = 0; $__LIST__ = $keyvalue; ?>
                                <?php foreach($__LIST__ as $key=>$item): ++$i; ?>
                                <option value="<?php echo $item['code']; ?>" <?php if($item['code'] == $search['uom_qty']): ?> selected="selected" <?php endif;?>><?php echo $item['name']; ?></option>
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
                    <div class="unit-left"><span class="tit"> 重量单位<em class="abe-red mrg_5">*</em></span></span></div>
                    <div class="unit-mid">
                        <div class="dropdown" id="<?php echo ($funcid); ?>_uom_weight">
                            <select class="pbsele dropdown0" name="uom_weight">
                                <option value="" <?php if($search['uom_weight'] == ''): ?> selected="selected" <?php endif;?> ></option>
                                <?php
 $keyvalue = subcode('UOM_WEIGHT'); if(is_array($keyvalue)){ $i = 0; $__LIST__ = $keyvalue; ?>
                                <?php foreach($__LIST__ as $key=>$item): ++$i; ?>
                                <option value="<?php echo $item['code']; ?>" <?php if($item['code'] == $search['uom_weight']): ?> selected="selected" <?php endif;?>><?php echo $item['name']; ?></option>
                                <?php endforeach; ?>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="prompt" style="display:none">
                            <div class="error"><i class="iconfont">&#xe616;</i></div>
                        </div>
                    </div>
                </li>



               <!-- <li>
                    <div class="unit-left"><span class="tit"> 重量单位</span></div>
                    <div class="unit-mid">
                        <div class="textbox">
                            <input type="text" class="pbtxt txt0" name="uom_weight"  value="<?php echo $search['uom_weight']; ?>"  >
                        </div>
                        <div class="prompt" style="display:none">
                            <div class="error"><i class="iconfont">&#xe616;</i></div>
                        </div>
                    </div>
                </li>-->

                <li>
                    <div class="unit-left"><span class="tit"> 散件单位</span></div>
                    <div class="unit-mid">
                        <div class="dropdown" id="<?php echo ($funcid); ?>_uom_bulkcargo">
                            <select class="pbsele dropdown0" name="uom_bulkcargo">
                                <option value="" <?php if($search['uom_bulkcargo'] == ''): ?> selected="selected" <?php endif;?> ></option>
                                <?php
 $keyvalue = subcode('UOM_WEIGHT'); if(is_array($keyvalue)){ $i = 0; $__LIST__ = $keyvalue; ?>
                                <?php foreach($__LIST__ as $key=>$item): ++$i; ?>
                                <option value="<?php echo $item['code']; ?>" <?php if($item['code'] == $search['uom_bulkcargo']): ?> selected="selected" <?php endif;?>><?php echo $item['name']; ?></option>
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
                    <div class="unit-left"><span class="tit"> 配货阈值(%)<em class="abe-red mrg_5">*</em></span></div>
                    <div class="unit-mid">
                        <div class="textbox">
                            <input type="text" class="pbtxt txt0" name="assign_threshold"  value="<?php echo $search['assign_threshold']; ?>"  >
                        </div>
                        <div class="prompt" style="display:none">
                            <div class="error"><i class="iconfont">&#xe616;</i></div>
                        </div>
                    </div>
                </li>


                <!--<li>
                    <div class="unit-left"><span class="tit"> 散件单位</span></div>
                    <div class="unit-mid">
                        <div class="textbox">
                            <input type="text" class="pbtxt txt0" name="uom_bulkcargo"  value="<?php echo $search['uom_bulkcargo']; ?>"  >
                        </div>
                        <div class="prompt" style="display:none">
                            <div class="error"><i class="iconfont">&#xe616;</i></div>
                        </div>
                    </div>
                </li>-->

               <!-- <li>
                    <div class="unit-left"><span class="tit"> 税率</span></div>
                    <div class="unit-mid">
                        <div class="textbox">
                            <input type="text" class="pbtxt txt0" name="tax_rate"  value="<?php echo $search['tax_rate']; ?>"  >
                        </div>
                        <div class="prompt" style="display:none">
                            <div class="error"><i class="iconfont">&#xe616;</i></div>
                        </div>
                    </div>
                </li>-->


            </ul>
            </form>
        </div>
    </div>
    <div class="pop-sub abe-txtc" >


        <input type="button" value="提交" class="btn btn-blue mrg_10 " onclick="return _asr.submit('<?php echo "$funcid"; ?>', '<?php echo "$funcid"; ?>-Search', '<?php echo U("/Home/GoodsStyle/index?func=save&id=$search[id]") ; ?>',''); " />

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

        _asr.setvaluebyname(_frm,"parent_id_name", "" );
        _asr.setvaluebyname(_frm,"parent_id", "" );
        _asr.setvaluebyname(_frm,"code", "" );
        _asr.setvaluebyname(_frm,"name", "" );
        _asr.setvaluebyname(_frm,"description", "" );
        _asr.setvaluebyname(_frm,"level", "" );
        _asr.setvaluebyname(_frm,"sort", "" );


        $("#<?php echo ($funcid); ?>").find(".selebtn").each(function(){
            $(this).find("a:eq(0)").click();
        });

        $("#<?php echo ($funcid); ?> .city-tags-new .sele-remove").click();
    }

    function <?php echo $funcid;?>_callback(param){
        _asr.closePopup('<?php echo ($funcid); ?>');
    }



    <?php echo W('Summary/javascript',array('GoodsStyle'));?>

</script>