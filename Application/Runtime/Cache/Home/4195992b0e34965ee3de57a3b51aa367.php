<?php if (!defined('THINK_PATH')) exit();?>
<div class="prompt-pop" style="z-index:<?php echo ($zindex); ?>;margin-left: -300px;"   id="<?php echo $funcid;?>" >
<!--
<div class="prompt-pop" style="z-index:<?php echo ($zindex); ?>;margin-left: -300px;"   id="<?php echo $funcid;?>" >
-->
  <div class="title">
  <span class="pop-name">修改密码</span>
  <a href="javascript:void(0);" onclick="_asr.closePopup('<?php echo ($funcid); ?>');" class="close iconfont">&#xe60d;</a>
  </div>
  <form action="<?php echo U('User/index?func=update_password'); ?>" id="<?php echo "$funcid"; ?>-Search" method="post">
   <input type="hidden" name="<?php echo "$funcid"; ?>-last-url" id="<?php echo "$funcid"; ?>-last-url" value="<?php echo $__last_url; ?>" />
   <input type="hidden" name="funcid" value="<?php echo "$funcid"; ?>" />
   <input type="hidden" name="pfuncid" value="<?php echo "$pfuncid"; ?>" />
      	<ul class="pbform">
       
          <li><span class="tit"><em class="abe-red mrg_5">*</em>旧密码</span>
            <div class="txt-box">
              <input type="password" class="pbtxt" name="old" value="<?php echo ($old); ?>">
            </div>
          </li>
          <li><span class="tit"><em class="abe-red mrg_5">*</em>新密码</span>
            <div class="txt-box">
              <input type="password" class="pbtxt" name="new" value="<?php echo ($new); ?>">
            </div>
          </li>
          <li><span class="tit"><em class="abe-red mrg_5">*</em>确认密码</span>
            <div class="txt-box">
              <input type="password" class="pbtxt" name="confirm" value="<?php echo ($confirm); ?>" >
            </div>
          </li>
<!--  	
    <li><span class="tit"><em class="abe-red mrg_5">*</em>选择原因</span>
      <div class="txt-box">
		<?php if(is_array($reason_list)): $i = 0; $__LIST__ = $reason_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div><input type="radio"  value="<?php echo ($vo["name"]); ?>"  name="reason_tag"  class="mrg_10"><?php echo ($vo["name"]); ?></div><?php endforeach; endif; else: echo "" ;endif; ?>
      </div>
    </li>
    <li>
    <span class="tit"><em class="abe-red mrg_5"></em>解挂时间</span>
    <div class="calendar">
        <input type="text" class="pbtxt calendar1" name="hangup_release_time"  value=""  verify="" tips="" reglux="" >
	</div>    
    </li>    
    <li><span class="tit"><em class="abe-red mrg_5"></em>其他原因</span>
      <div class="txt-box">
        <textarea class="pbtextarea"  name="reason"></textarea>
      </div>
    </li>
-->    
  </ul>

	</form>
   <div class="pop-sub abe-txtc">
      <input type="button" value="保存" class="btn btn-blue mrg_10" default-status="1" onclick="return _asr.submit('<?php echo "$funcid"; ?>', '<?php echo "$funcid"; ?>-Search', '<?php echo U("User/index?func=update_password") ?>',''); " />
      <input type="submit" value="取消" class="btn" onclick="return _asr.closePopup('<?php echo $funcid;?>')">
  </div>
</div>
    <script>
        /***************************************************************************************/
        /* 前台页面初始化                                                                      */
        /***************************************************************************************/
        function <?php echo $funcid; ?>_init(){
            return ;
        }
        

	   function <?php echo $funcid;?>_callback(param){
	          _asr.closePopup('<?php echo ($funcid); ?>');
	   }
	   
 

	   	<?php echo $funcid; ?>_init();
		
</script>