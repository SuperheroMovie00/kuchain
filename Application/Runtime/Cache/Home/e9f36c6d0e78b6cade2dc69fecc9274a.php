<?php if (!defined('THINK_PATH')) exit();?>
<div toplayer="1" class="prompt-pop pop-style3" style="z-index:<?php echo ($zindex); ?>;width:800px;" id="<?php echo $funcid;?>" url="<?php echo U('SystemParameter/index'); ?>">

   <div class="title">
       <span class="pop-name">查看系统分类信息</span>
       <a href="javascript:void(0);" onclick="$(this).parents('.prompt-pop').remove();_asr.closePopup('<?php echo ($funcid); ?>');" class="close iconfont">&#xe60d;</a>
   </div>





<div class="pop-scroll">
   <div class="screening ">
      <form action="<?php echo U('SystemParameter/index?func=_save'); ?>" id="<?php echo "$funcid"; ?>-Search" method="get" verify="1">
          <input type="hidden" name="<?php echo "$funcid"; ?>-last-url" id="<?php echo "$funcid"; ?>-last-url" value="<?php echo $__last_url; ?>" />
          <input type="hidden" name="funcid" value="<?php echo "$funcid"; ?>" />
          <input type="hidden" name="pfuncid" value="<?php echo "$pfuncid"; ?>" />
          <input type="hidden" name="id" value="<?php echo $search["id"]; ?>" />
          <input type="hidden" name="_lastchanged" value="<?php echo $search["lastchanged"]; ?>" />
          <ul class="form form-mod-new form-column2">

             <li>
                  <div class="unit-left"><span class="tit"> 类型</span></div>
                  <div class="unit-mid"><label class="pbtxt txt0"  ><?php echo get_table_SystemParameter_type("$search[type]","name",""); ?></label></div>
             </li>
             <li>
                  <div class="unit-left"><span class="tit"> 代码</span></div>
                  <div class="unit-mid"><label class="pbtxt txt0"  ><?php echo $search["code"]; ?></label></div>
             </li>
             <li class="per100">
                  <div class="unit-left"><span class="tit"> 名称</span></div>
                  <div class="unit-mid"><label class="pbtxt txt0"  ><?php echo $search["name"]; ?></label></div>
             </li>
             <li class="per100">
                  <div class="unit-left"><span class="tit"> 数据</span></div>
                  <div class="unit-mid"><label class="pbtxt txt0"  ><?php echo OverView($search["value"],150,"..."); ?></label></div>
             </li>
             <li class="per100">
                  <div class="unit-left"><span class="tit"> 说明</span></div>
                  <div class="unit-mid"><label class="pbtxt txt0"  ><?php echo OverView($search["remarks"],150,"..."); ?></label></div>
             </li>
             <li>
                  <div class="unit-left"><span class="tit"> 状态</span></div>
                  <div class="unit-mid"><label class="pbtxt txt0"  ><?php echo get_table_SystemParameter_status("$search[status]","name",""); ?></label></div>
             </li>

          </ul>
       </form>
    </div>
 </div>
    <div class="pop-sub abe-txtc" >
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



          $("#<?php echo ($funcid); ?>").find(".selebtn").each(function(){
              $(this).find("a:eq(0)").click();
            });

          $("#<?php echo ($funcid); ?> .city-tags-new .sele-remove").click();
        }

   function <?php echo $funcid;?>_callback(param){
        _asr.closePopup('<?php echo ($funcid); ?>');
   }



    <?php echo W('Summary/javascript',array('SystemParameter'));?>

</script>