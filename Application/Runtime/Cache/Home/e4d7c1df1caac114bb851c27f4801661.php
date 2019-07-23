<?php if (!defined('THINK_PATH')) exit();?>
<div toplayer="1" class="prompt-pop pop-style4" style="z-index:<?php echo ($zindex); ?>;" id="<?php echo $funcid;?>"
     url="<?php echo U('Sample/index'); ?>" xmlns="http://www.w3.org/1999/html">
    <div class="title"> <span class="pop-name"><?php echo ($pop_title); ?></span> <a href="javascript:void(0);" class="close iconfont confirm-cancel" onclick="_asr.closePopup('<?php echo ($funcid); ?>');"></a> </div>
    <div class="pop-scroll">
        <div class="screening">
            <form enctype="multipart/form-data" action="<?php echo U('Trade/index?func=other_edit_save'); ?>" id="<?php echo "$funcid"; ?>-Search" method="post" verify="1">
            <input type="hidden" name="<?php echo "$funcid"; ?>-last-url" id="<?php echo "$funcid"; ?>-last-url" value="<?php echo $__last_url; ?>" />
            <input type="hidden" name="funcid" value="<?php echo "$funcid"; ?>" />
            <input type="hidden" name="pfuncid" value="<?php echo "$pfuncid"; ?>" />
            <input type="hidden" name="id" value="<?php echo $trade["id"]; ?>" />
            <input type="hidden" name="_lastchanged" value="<?php echo $trade["modify_time"]; ?>" />

            <ul class="form form-mod-new form-column2">
                <?php if(is_array($edit_list)): $id = 0; $__LIST__ = $edit_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($id % 2 );++$id;?><li class="per100">
                    <div class="unit-left"><span class="tit"> <?php echo ($vo["title"]); ?> <em class="abe-red mrg_5">*</em> </span></div>
                    <div class="unit-mid">
                        <div class="textbox">
                            <?php if($vo["datatype"] == 'dt'): $cur_class="calendar0";$cur_val=sys_date_format("Y-m-d",$trade[$vo["field"]]); ?>
                                <?php else: ?>
                                <?php $cur_class="txt0";$cur_val=$trade[$vo["field"]]; endif; ?>
                            <input type="text" class="pbtxt <?php echo ($cur_class); ?>" name="<?php echo ($vo["field"]); ?>"  value="<?php echo ($cur_val); ?>"  >

                        </div>
                    </div>
                    <div class="unit-right">  </div>
                </li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
            </form>
        </div>
    </div>
    <div class="pop-sub abe-txtc">
        <input type="button" class="btn btn-blue mrg_15" value="确定" onclick="return _asr.submit('<?php echo "$funcid"; ?>', '<?php echo "$funcid"; ?>-Search', '<?php echo U("/Home/Trade/index?func=other_edit_save&id=$search[id]") ; ?>',''); ">
        <input type="button" class="btn" value="取消" onclick="_asr.closePopup('<?php echo ($funcid); ?>');">
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