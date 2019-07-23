<?php if (!defined('THINK_PATH')) exit();?>
<div class="prompt-pop" data-type="selectProduct" id="<?php echo $funcid ?>" style="z-index: <?php echo ($zindex); ?>" funcid="<?php echo ($funcid); ?>" last-url="<?php echo ($__last_url); ?>">
    <div class="title">
        <span class="pop-name">导入采购通知信息</span>
        <a href="javascript:void(0);" onclick="$(this).parents('.prompt-pop').remove();_asr.closePopup('<?php echo ($funcid); ?>');" class="close iconfont">&#xe60d;</a>
    </div>
    <form action="<?php echo U('/Home/GoodsPrice/index?func=import&close=1');?>" method="post" id="<?php echo $funcid;?>-DayPrice-import-Form" enctype="multipart/form-data">
        <input type="hidden" name="orderid" value="<?php echo ($orderid); ?>" />
        <input type="hidden" name="funcid" value="<?php echo ($funcid); ?>" />
        <input type="hidden" name="pfuncid" value="<?php echo ($pfuncid); ?>" />
        <input type="file" style="display:none;" id="<?php echo $funcid;?>_import_file"  name="import" onchange="<?php echo $funcid;?>_choose();"  />
    </form>

    <ul class="pbform">
        <li>
            <span class="tit">
            <em class="abe-red mrg_5"></em>每日价格文件
            </span>
            <div class="txt-box">
                <input type="text" id="<?php echo $funcid;?>_import" readonly class="pbtxt" onclick="$('#<?php echo $funcid;?>_import_file').click();" value="" />
                <input type="button" value="选择文件" class="btn btn-blue" onclick="$('#<?php echo $funcid;?>_import_file').click();">
            </div>
        </li>
        <li>
            <span class="tit">
            <em class="abe-red mrg_5"></em>价格文件模板
            </span>
            <div class="txt-box">
                <a href="/Public/importTpl/day_price.csv">点击下载</a>
            </div>
        </li>
    </ul>

    <div class="pop-sub abe-txtc">
        <input type="submit" value="保存" class="btn btn-blue mrg_10" onclick="return _asr.submit('<?php echo $funcid;?>', '<?php echo $funcid;?>-DayPrice-import-Form', '<?php echo U('/Home/GoodsPrice/index?func=import_save&close=1');?>',2);">
        <input type="submit" value="取消" class="btn btn-org mrg_10" onclick="$(this).parents('.prompt-pop').remove();_asr.closePopup('<?php echo ($funcid); ?>');" >
    </div>
</div>
<script>
    function <?php echo $funcid ?>_init() {
        var _this = $("#<?php echo $funcid ?>");
        var ppw = _this.width()/2;
        _this.css({'margin-left':-ppw});
    }

    function <?php echo $funcid ?>_refresh() {
        _asr.submit('<?php echo $funcid;?>', $("#<?php echo $funcid ?>").find("form").eq(1), '');
    }

    function <?php echo $funcid;?>_choose(){
        $('#<?php echo $funcid;?>_import').val($('#<?php echo $funcid;?>_import_file').val())
    }

</script>