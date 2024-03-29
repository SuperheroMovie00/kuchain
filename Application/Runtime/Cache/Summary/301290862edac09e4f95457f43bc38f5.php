<?php if (!defined('THINK_PATH')) exit();?>
<div class="prompt-pop pop-style2" data-type="column" id="<?php echo $funcid ?>" style="z-index: <?php echo ($zindex); ?>;" funcid="<?php echo ($funcid); ?>" last-url="<?php echo ($__last_url); ?>">
    <div class="title">
        <span class="pop-name">编辑显示列</span>
        <a href="javascript:void(0);" onclick="$(this).parents('.prompt-pop').remove();_asr.closePopup('<?php echo ($funcid); ?>');" class="close iconfont">&#xe60d;</a>
    </div>
 <div class="pop-scroll"> 
    <div class="blank10"></div>
    <div class="table-box pdl_10">
        <div class="table-in">
            <form action="<?php echo U('$summary/index?func=columnsettingsave'); ?>" id="<?php echo "$funcid"; ?>-Search" method="get">
            <input type="hidden" name="<?php echo "$funcid"; ?>-last-url" id="<?php echo "$funcid"; ?>-last-url" value="<?php echo $__last_url; ?>" />
            <input type="hidden" name="funcid" value="<?php echo "$funcid"; ?>" />
            <input type="hidden" name="pfuncid" value="<?php echo "$pfuncid"; ?>" />
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>" />
            <input type="hidden" name="summary" value="<?php echo $summary; ?>" />
            <table border="0" cellspacing="0" cellpadding="0" class="pub-table">
                <colgroup>
                    <col style="width:40px;">
                    <col />
                </colgroup>
                <tbody>
                <tr style="text-align: left;" class="odd"><th><input type="checkbox" onclick="<?php echo "$funcid"; ?>_checkAll(this);" />&nbsp;&nbsp;全选&nbsp;&nbsp;列名</th></tr>
                <?php $n=0; ?>
                <?php foreach($column as $k=>$master){ ?>
                <tr class="<?php if($n%2==0){ ?> even <?php }else{ ?> odd <?php } ?>" >
                <td style="text-align: left">
                    <input type="checkbox" name="column_check[<?php echo ($k); ?>]" <?php if($column_check[$k]==1){ ?> checked <?php } ?> onclick="<?php echo "$funcid"; ?>_check();" value="1">
                    <input type="hidden" name="column[<?php echo ($k); ?>]" value="0">
                    &nbsp;&nbsp;
                    <?php echo ($master); ?>
                </td>
                </tr>
                <?php $n++; ?>
                <?php } ?>
                </tbody>
            </table>
            </form>
        </div>
    </div>
    <div class="blank10"></div>
</div>        
    <div class="pop-sub abe-txtc" >
        <!-- 按钮权限检测 保存 --->
        <?php if (isset($rights['column']) && $rights['column'] || true): ?>
        <input style="display: none;" id="<?php echo "$funcid"; ?>_save_btn" type="button" value="保存" class="btn btn-org mrg_10" default-status="1" onclick="return _asr.submit('<?php echo "$funcid"; ?>', '<?php echo "$funcid"; ?>-Search', '<?php echo U("$summary/index?func=columnsettingsave&") ?>',''); " />
        <?php endif; ?>
        <em class="abe-space-sm"></em>
        <input type="button" value="重置" class="btn btn-blue mrg_10"  onclick="return <?php echo "$funcid"; ?>_clear();" default-status="1" />
    </div>
    <div class="blank50"></div>
</div>

<script>
    //@ sourceURL=dynamicScript.js

    $(document).ready(function(){
        if($('#<?php echo "$funcid"; ?>-Search input[type="checkbox"]:checked').length<=0){
            $('#<?php echo "$funcid"; ?>-Search input[type="checkbox"]').click()
        }
        <?php echo "$funcid"; ?>_check();
    })

    function <?php echo "$funcid"; ?>_check(){
        if($('#<?php echo "$funcid"; ?>-Search input[type="checkbox"]:checked').length>0){
            $('#<?php echo "$funcid"; ?>_save_btn').show();
        }else{
            $('#<?php echo "$funcid"; ?>_save_btn').hide();
        }

    }

    function <?php echo "$funcid"; ?>_checkAll(o){
        if($(o).is(':checked')){
            $('#<?php echo "$funcid"; ?>-Search input[type="checkbox"][name*="column_check"]').attr('checked',true);
        }else{
            $('#<?php echo "$funcid"; ?>-Search input[type="checkbox"][name*="column_check"]').attr('checked',false);
        }
        <?php echo "$funcid"; ?>_check();
    }

    function <?php echo "$funcid"; ?>_clear(){
        $('#<?php echo "$funcid"; ?>-Search input[type="checkbox"]').attr('checked',true);
        <?php echo "$funcid"; ?>_check();
    }

</script>