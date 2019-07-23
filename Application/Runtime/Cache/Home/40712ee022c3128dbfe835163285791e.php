<?php if (!defined('THINK_PATH')) exit();?>
<div toplayer="1" class="prompt-pop pop-style4" style="z-index:<?php echo ($zindex); ?>;" id="<?php echo $funcid;?>" url="<?php echo U('Sample/index'); ?>">
  <div class="title"> <span class="pop-name">页面标题</span> <a href=" " class="close iconfont confirm-cancel" onclick="$(this).parents('.prompt-pop').remove();_asr.closePopup('<?php echo ($funcid); ?>');"></a> </div>
  <div class="pop-scroll">
    <div class="screening">
      <ul class="form form-mod-new form-column2">
        <li class="per100">
          <div class="unit-left"><span class="tit"> 商品编码 </span></div>
          <div class="unit-mid">
            <div class="textbox">
              <label class="pbtxt txt0" name="goods_no" value="" verify="" tips="" reglux="">abcdefgh</label>
            </div>
          </div>
          <div class="unit-right"> 提示信息 </div>
        </li>
        <li class="per100">
          <div class="unit-left"><span class="tit"> 商品编码 <em class="abe-red mrg_5">*</em> </span></div>
          <div class="unit-mid">
            <div class="textbox">
              <input type="text" class="pbtxt txt0" name="goods_no" value="" verify="" tips="" reglux="">
            </div>
          </div>
          <div class="unit-right"> 提示信息 </div>
        </li>
        <li class="per100">
          <div class="unit-left"><span class="tit"> 商品编码 </span></div>
          <div class="unit-mid">
            <div class="textbox">
              <select name="" id="" class="pbsele txt0">
                <option>请选择</option>
              </select>
            </div>
          </div>
          <div class="unit-right">
            <input type="button" class="btn btn-blue btn-xs abe-ft12" value="确定">
          </div>
        </li>
        <li class="per100">
          <div class="unit-left"><span class="tit"> 商品编码 </span></div>
          <div class="unit-mid">
            <div class="textbox"> <span class="pdr_20">
              <input type="checkbox">
              参数一</span><span class="pdr_20">
              <input type="radio">
              参数一</span> </div>
          </div>
        </li>
        <li class="per100">
          <div class="unit-left"><span class="tit"> 商品编码 </span> </div>
          <div class="unit-mid">
            <div class="textbox">
              <textarea class="textarea0"></textarea>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </div>
  <div class="pop-sub abe-txtc">
    <input type="button" class="btn btn-blue mrg_15" value="确定">
    <input type="button" class="btn" value="取消" onclick="$(this).parents('.prompt-pop').remove();_asr.closePopup('<?php echo ($funcid); ?>');">
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