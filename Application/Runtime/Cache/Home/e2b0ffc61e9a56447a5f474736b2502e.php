<?php if (!defined('THINK_PATH')) exit();?>
<div toplayer="1" class="prompt-pop" style="z-index: <?php echo ($zindex); ?>;" id="<?php echo $funcid;?>"  funcid="<?php echo ($funcid); ?>" last-url="<?php echo ($__last_url); ?>">

   <div class="title">
       <span class="pop-name">客户资料数据导入</span>
       <a href="javascript:void(0);" onclick="$(this).parents('.prompt-pop').remove();_asr.closePopup('<?php echo ($funcid); ?>');" class="close iconfont">&#xe60d;</a>
   </div>




    <form action="<?php echo U('/Home/Customer/index?func=import&close=1');?>" method="post" id="<?php echo $funcid;?>-Customer-import-Form" enctype="multipart/form-data">
        <input type="hidden" name="orderid" value="<?php echo ($orderid); ?>" />
        <input type="hidden" name="funcid" value="<?php echo ($funcid); ?>" />
        <input type="hidden" name="pfuncid" value="<?php echo ($pfuncid); ?>" />
        <input type="file" style="display:none;" id="<?php echo $funcid;?>_import_file"  name="import" onchange="<?php echo $funcid;?>_choose();"  />
    </form>

    <ul class="pbform">
        <li>
            <span class="tit">
            <em class="abe-red mrg_5"></em>客户资料文件
            </span>
            <div class="txt-box">
                <input type="text" id="<?php echo $funcid;?>_import" readonly class="pbtxt" onclick="$('#<?php echo $funcid;?>_import_file').click();" value="" />
                <input type="button" value="选择文件" class="btn btn-blue" onclick="$('#<?php echo $funcid;?>_import_file').click();">
            </div>
        </li>
        <li>
            <span class="tit">
            <em class="abe-red mrg_5"></em>客户资料模板
            </span>
            <div class="txt-box">
                <a href="/Public/importTpl/customer.csv">点击下载</a>
            </div>
        </li>
    </ul>

    <div class="pop-sub abe-txtc">
        <input type="submit" value="提交" class="btn btn-blue mrg_10" onclick="return _asr.submit('<?php echo $funcid;?>', '<?php echo $funcid;?>-Customer-import-Form', '<?php echo U('/Home/Customer/index?func=import_save&close=1');?>',2,'','请确认是否开始数据导入?');">
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