<?php if (!defined('THINK_PATH')) exit();?>
<div toplayer="1" class="prompt-pop pop-style3" style="z-index:<?php echo ($zindex); ?>;width:800px;" id="<?php echo $funcid;?>" url="<?php echo U('DayPrice/index'); ?>">

   <div class="title">
       <span class="pop-name"><?php echo $search[id]?'编辑':'新增'; ?>每日价格区间信息</span>
       <a href="javascript:void(0);" onclick="$(this).parents('.prompt-pop').remove();_asr.closePopup('<?php echo ($funcid); ?>');" class="close iconfont">&#xe60d;</a>
   </div>


<div class="pop-scroll">
   <div class="screening ">
      <form action="<?php echo U('DayPrice/index?func=save'); ?>" id="<?php echo "$funcid"; ?>-Search" method="get">
          <input type="hidden" name="<?php echo "$funcid"; ?>-last-url" id="<?php echo "$funcid"; ?>-last-url" value="<?php echo $__last_url; ?>" />
          <input type="hidden" name="funcid" value="<?php echo "$funcid"; ?>" />
          <input type="hidden" name="pfuncid" value="<?php echo "$pfuncid"; ?>" />
          <input type="hidden" name="id" value="<?php echo $search["id"]; ?>" />
          <input type="hidden" name="_lastchanged" value="<?php echo $search["lastchanged"]; ?>" />
          <ul class="form form-mod-new form-column2">



             <li>
                  <div class="unit-left"><span class="tit"> 日期<em class="abe-red mrg_5">*</em></span></div>
                  <div class="unit-mid">
                       <div class="calendar">
                            <input type="text" class="pbtxt calendar0" name="tx_date" value="<?php echo system_format("D", $search["tx_date"],0) ; ?>"   >
                       </div>
                      <div class="prompt" style="display:none">
                          <div class="error"><i class="iconfont">&#xe616;</i></div>
                      </div>
                  </div>
             </li>


             <li>
                  <!--<div class="unit-left"><span class="tit"> 货品</span></div>
                  <div class="unit-mid">
                       <div class="textbox">
                            <input type="text" class="pbtxt txt0" name="mat_name"  value="<?php echo $search['mat_name']; ?>"  >
                       </div>
                      <div class="prompt" style="display:none">
                          <div class="error"><i class="iconfont">&#xe616;</i></div>
                      </div>
                  </div>-->
                 <div class="unit-left"><span class="tit"> 货品</span></div>
                 <div class="unit-mid">
                     <div class="popup">
                         <input  type="text" class="pbtxt txt0" name="parent_id_name" readonly="readonly" value="<?php echo $search['parent_id_name']; ?>">
                         <button type="submit" class="txt-search" onclick="return _asr.popup('GoodsStyle','<?php echo "$funcid"; ?>','<?php echo "$funcid"; ?>-Search','Single','parent_id','parent_id_name'); " <?php if($search["parent_id_name"]): ?> style="display:none"<?php endif; ?> ><i class="iconfont">&#xe60e;</i></button>
                         <button type="submit" class="txt-clear" onclick="_asr.setvaluebyname('<?php echo "$funcid"; ?>-Search','parent_id','');_asr.setvaluebyname('<?php echo "$funcid"; ?>-Search','parent_id_name','');return false;" <?php if(!$search["parent_id_name"]): ?> style="display:none"<?php endif; ?> ><i class="iconfont">&#xe616;</i></button>
                     </div>
                     <input type="hidden" name="parent_id" value="<?php echo $search['parent_id']; ?>">
                     <input type="hidden" name="style_code" value="<?php echo $search['style_code']; ?>">
                     <div class="prompt" style="display:none">
                         <div class="error"><i class="iconfont">&#xe616;</i></div>
                     </div>
                 </div>

             </li>


             <li>
                  <div class="unit-left"><span class="tit"> 最低价/元</span></div>
                  <div class="unit-mid">
                       <div class="textbox">
                            <input type="text" class="pbtxt txt0" name="min_price"  value="<?php echo $search['min_price']; ?>"  >
                       </div>
                      <div class="prompt" style="display:none">
                          <div class="error"><i class="iconfont">&#xe616;</i></div>
                      </div>
                  </div>
             </li>


             <li>
                  <div class="unit-left"><span class="tit"> 最高价/元</span></div>
                  <div class="unit-mid">
                       <div class="textbox">
                            <input type="text" class="pbtxt txt0" name="max_price"  value="<?php echo $search['max_price']; ?>"  >
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
               <input type="button" value="提交" class="btn btn-blue mrg_10 " onclick="return _asr.submit('<?php echo "$funcid"; ?>', '<?php echo "$funcid"; ?>-Search', '<?php echo U("/Home/GoodsPrice/index?func=save&id=$search[id]") ; ?>',''); " />
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

            _asr.setvaluebyname(_frm,"tx_date", "" );
            _asr.setvaluebyname(_frm,"mat_name", "" );
            _asr.setvaluebyname(_frm,"min_price", "" );
            _asr.setvaluebyname(_frm,"max_price", "" );


          $("#<?php echo ($funcid); ?>").find(".selebtn").each(function(){
              $(this).find("a:eq(0)").click();
            });

          $("#<?php echo ($funcid); ?> .city-tags-new .sele-remove").click();
        }

   function <?php echo $funcid;?>_callback(param){
        _asr.closePopup('<?php echo ($funcid); ?>');
   }



    <?php echo W('Summary/javascript',array('DayPrice'));?>



    </script>