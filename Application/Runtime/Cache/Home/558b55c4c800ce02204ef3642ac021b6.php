<?php if (!defined('THINK_PATH')) exit();?>
<div toplayer="1" class="prompt-pop pop-style3" style="z-index:<?php echo ($zindex); ?>;width:800px;" id="<?php echo $funcid;?>" url="<?php echo U('Role/index'); ?>">

   <div class="title">
       <span class="pop-name"><?php echo $search[id]?'编辑':'新增'; ?>角色信息</span>
       <a href="javascript:void(0);" onclick="$(this).parents('.prompt-pop').remove();_asr.closePopup('<?php echo ($funcid); ?>');" class="close iconfont">&#xe60d;</a>
   </div>


<div class="pop-scroll">
   <div class="screening ">
      <form enctype="multipart/form-data" action="<?php echo U('Role/index?func=save'); ?>" id="<?php echo "$funcid"; ?>-Search" method="post">
          <input type="hidden" name="<?php echo "$funcid"; ?>-last-url" id="<?php echo "$funcid"; ?>-last-url" value="<?php echo $__last_url; ?>" />
          <input type="hidden" name="funcid" value="<?php echo "$funcid"; ?>" />
          <input type="hidden" name="pfuncid" value="<?php echo "$pfuncid"; ?>" />
          <input type="hidden" name="id" value="<?php echo $search["id"]; ?>" />
          <input type="hidden" name="_lastchanged" value="<?php echo $search["lastchanged"]; ?>" />
          <ul class="form form-mod-new form-column2">

             <li>
                  <div class="unit-left"><span class="tit"> 角色<em class="abe-red mrg_5">*</em></span></div>
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
                  <div class="unit-left"><span class="tit"> 备注</span></div>
                  <div class="unit-mid">
                       <textarea class="textarea0" name="remarks"  ><?php echo $search['remarks']; ?></textarea>
                      <div class="prompt" style="display:none">
                          <div class="error"><i class="iconfont">&#xe616;</i></div>
                      </div>
                  </div>
             </li>
             <li>
                  <div class="unit-left"><span class="tit"> 审批级别</span></div>
                  <div class="unit-mid">
                       <div class="dropdown" id="<?php echo ($funcid); ?>_approval">
                           <select class="pbsele dropdown0" name="approval">
                             <?php
 $keyvalue = table_Role_approval(); if(is_array($keyvalue)){ $i = 0; $__LIST__ = $keyvalue; ?>
                                    <?php foreach($__LIST__ as $key=>$item): ++$i; ?>
                                 <option value="<?php echo $item['id']; ?>" <?php if($item['id'] == $search['approval']): ?> selected="selected" <?php endif;?>><?php echo $item['name']; ?></option>
                                    <?php endforeach; ?>
                             <?php } ?>
                           </select>
                       </div>
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


               <input type="button" value="提交" class="btn btn-blue mrg_10 " onclick="return _asr.submit('<?php echo "$funcid"; ?>', '<?php echo "$funcid"; ?>-Search', '<?php echo U("/Home/Role/index?func=save&id=$search[id]") ; ?>',''); " />

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

            _asr.setvaluebyname(_frm,"name", "" );
            _asr.setvaluebyname(_frm,"remark", "" );
            _asr.setvaluebyname(_frm,"approval", "" );


          $("#<?php echo ($funcid); ?>").find(".selebtn").each(function(){
              $(this).find("a:eq(0)").click();
            });

          $("#<?php echo ($funcid); ?> .city-tags-new .sele-remove").click();
        }

   function <?php echo $funcid;?>_callback(param){
        _asr.closePopup('<?php echo ($funcid); ?>');
   }



    <?php echo W('Summary/javascript',array('Role'));?>

</script>