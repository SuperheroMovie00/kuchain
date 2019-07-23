<?php if (!defined('THINK_PATH')) exit();?>
<div class="prompt-pop pop-style2" id="<?php echo ($funcid); ?>" style="z-index:<?php echo ($zindex); ?>">
	<input type="hidden" name="selecttype" value="<?php echo ($selecttype); ?>" />
  <div class="title"><span class="pop-name">选择客户分类信息</span><a href="javascript:void(0);" class="close iconfont" onclick="_asr.closePopup('<?php echo ($funcid); ?>');">&#xe60d;</a> </div>
   <div class="pop-scroll"> 

        <div class="trees-nav trees-nav-pop abe-posclear" style="width: 100%; background:#fff;">
            <ul>
                <?php echo ($popupdata); ?>
            </ul>
    </div></div>
  <div class="pop-sub abe-txtc">
    <input type="submit" value="选择" class="btn btn-org mrg_10" onclick="_asr.returnPopup('<?php echo ($funcid); ?>');">
    <input type="submit" value="取消" class="btn" onclick="_asr.closePopup('<?php echo ($funcid); ?>');">
  </div>
  <script>
  		$("#<?php echo ($funcid); ?> .trees-nav ul li input").click(function(){
  			$("#<?php echo ($funcid); ?> .trees-nav ul li").removeClass("active");
  			$(this).parent().addClass("active");
  		});
  </script>
</div>