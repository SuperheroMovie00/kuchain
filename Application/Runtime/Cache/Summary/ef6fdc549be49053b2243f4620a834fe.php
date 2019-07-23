<?php if (!defined('THINK_PATH')) exit();?>
<div toplayer="1" class="wrap-box wrap-nmd wrap-style00 " id="<?php echo $funcid;?>" summaryid="GoodsPriceSummary" baseurl="<?php echo U('GoodsPriceSummary/index'); ?>">
  <div class="wrap-box-info ">

    <div class="wrap-title abe-ofl">
      <div class="tit abe-fl" style="width: 450px;">货品价格区间列表</div>
      <div class="abe-fl">
        <div class="textbox" >
          <div  id="<?php echo "$funcid"; ?>-keyword-info" class="abe-fl"<?php if($search["_showsearch"]=="show"):?>style="display:none;"<?php endif; ?>>
             <input type="text" class="pbtxt txt0" id="<?php echo $funcid;?>-keyword-input" value="<?php echo $search['_keyword']; ?>"  onKeyDown="<?php echo ($funcid); ?>_keyword_keydown(this);" placeholder=" 输入关键词进行搜索 ">
             <input type="button" value="搜索" class="btn btn-org  mrg_10 " id="<?php echo $funcid;?>-keyword-search"  default-status="1"  onclick="<?php echo ($funcid); ?>_keyword_set(); return _asr.submit('<?php echo "$funcid"; ?>', '<?php echo "$funcid"; ?>-Search', '<?php echo U("GoodsPriceSummary/index?func=search&") ; ?>',''); " />
             <input id="<?php echo $funcid;?>-search-buttc" type="button" value="导出" class="btn btn-blue mrg_10 " default-status="1" onclick="return _asr.showExport('<?php echo "$funcid"; ?>', '<?php echo "$funcid"; ?>-Search', '<?php echo U("GoodsPriceSummary/index?func=export&") ; ?>',<?php echo $p ?>); " />
          </div>
          <a href="javascript:void(0);" class="mrg_15 vi-blue search-show" <?php if($search["_showsearch"]=="show"):?>style="display:none;"<?php endif; ?>><i class="iconfont">&#xe673;</i>搜索扩展</a>
        </div>
      </div>
      <div class="abe-fr">
        <a href="javascript:void(0);" class="mrg_15 vi-blue search-hide" <?php if($search["_showsearch"]=="hide"):?>style="display:none;"<?php endif; ?>><i class="iconfont">&#xe673;</i>收起搜索</a>


          <?php if (isset($rights['add']) && $rights['add']): ?>
               <input type="button" value="新增货品价格区间" class="btn btn-blue mrg_10 " onclick="return _asr.popupFun('<?php echo U("/Home/GoodsPrice/index?func=add&%addlink%") ; ?>', '<?php echo filterFuncId("/Home/GoodsPrice/index?func=add&%addlink%","");?>'); " />
          <?php endif; ?>



          <?php if (isset($rights['import']) && $rights['import']): ?>
               <input type="button" value="数据导入" class="btn btn-blue mrg_10 " onclick="return _asr.popupFun('<?php echo U("/Home/GoodsPrice/index?func=import&") ; ?>', '<?php echo filterFuncId("/Home/GoodsPrice/index?func=import&","");?>'); " />
          <?php endif; ?>



               <a href="javascript:void(0);"  class=" vi-blue " onclick="return _asr.openLink('','<?php echo "$funcid"; ?>','刷新',1); "><i class="iconfont ">&#xe611;</i> 刷新</a>

      </div>
    </div>


    <div class="screening"  >
      <form action="<?php echo U('GoodsPriceSummary/index?func=search'); ?>" id="<?php echo "$funcid"; ?>-Search" method="get">
                <input type="hidden" name="<?php echo "$funcid"; ?>-last-url" id="<?php echo "$funcid"; ?>-last-url" value="<?php echo $__last_url; ?>" />
                <input type="hidden" name="funcid" value="<?php echo "$funcid"; ?>" />
                <input type="hidden" name="pfuncid" value="<?php echo "$pfuncid"; ?>" />
                <input type="hidden" name="_searchexpand" value="<?php echo $search["_searchexpand"]; ?>" />
                <input type="hidden" name="_showsearch"   value="<?php echo $search["_showsearch"]; ?>" />
                <input type="hidden" name="_issearch" value="<?php echo $search["_issearch"]; ?>" />
                <input type="hidden" name="_keyword" value="<?php echo $search["_keyword"]; ?>" />

                <input type="hidden" name="_tab" value="<?php echo $search["_tab"]; ?>" />
                <ul class="form form-mod-new" id="<?php echo $funcid;?>-search-Info">
                  <li>
                      <div class="unit-left"> 价格日期</div>
                      <div class="unit-mid">
                          <div class="calendar">
                              <input type="text" class="pbtxt calendar1" name="tx_date"  value= "<?php echo system_format("D", $search["tx_date"],0); ?>"  >
                              <em class="space-line">-</em>
                              <input type="text" class="pbtxt calendar1" name="tx_date2" value="<?php echo $search['tx_date2']; ?>"  >
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 货品码</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="style_code"  value="<?php echo $search['style_code']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 货品名称</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="style_name"  value="<?php echo $search['style_name']; ?>"   placeholder=" 直接进行模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 货品材质</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="materials"  value="<?php echo $search['materials']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 最低价/元</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt1" name="min_price"  value="<?php echo $search['min_price']; ?>"  >
                              <em class="space-line">-</em>
                              <input type="text" class="pbtxt txt1" name="min_price2" value="<?php echo $search['min_price2']; ?>"  >
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 最高价/元</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt1" name="max_price"  value="<?php echo $search['max_price']; ?>"  >
                              <em class="space-line">-</em>
                              <input type="text" class="pbtxt txt1" name="max_price2" value="<?php echo $search['max_price2']; ?>"  >
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 单位</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="uom_weight"  value="<?php echo $search['uom_weight']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                </ul>
                  <!--表单-->
                  <div class="sub-box sub-box3">
                    <div class="pbtab abe-fl" >
                      <a href="#" onclick="return _asr.tabsheet('<?php echo $funcid;?>', '<?php echo "$funcid"; ?>-Search', 'all');" <?php if($search['_tab'] == 'all'): ?> class="current"<?php endif;?>>全部</a>
                    </div>
                    <p class="annotation vi-red"></p>
                    <div class="sub-box-in abe-fr"  id="<?php echo $funcid;?>-search-butt">


          <?php if (isset($rights['search']) && $rights['search']): ?>
               <input type="button" value="搜索" class="btn btn-org  mrg_10 " onclick="return _asr.submit('<?php echo "$funcid"; ?>', '<?php echo "$funcid"; ?>-Search', '<?php echo U("GoodsPriceSummary/index?func=search&") ; ?>',''); " />
          <?php endif; ?>



               <input type="button" value="清除" class="btn btn-blue mrg_10 " onclick="return <?php echo "$funcid"; ?>_clearsearch('<?php echo "$funcid"; ?>-Search');" />



          <?php if (isset($rights['export']) && $rights['export']): ?>
               <input type="button" value="导出" class="btn btn-blue mrg_10 " onclick="return _asr.showExport('<?php echo "$funcid"; ?>', '<?php echo "$funcid"; ?>-Search', '<?php echo U("GoodsPriceSummary/index?func=export&") ; ?>',<?php echo $p ?>); " />
          <?php endif; ?>

                    <em class="pdr_20"></em>
                    <a href="javascript:void(0);" class="table-set <?php echo count($colshow)>0?"vi-blue":"abe-gray3"; ?>"  onclick="return _asr.popupFun('<?php echo U("/Summary/GoodsPriceSummary/index?func=columnsetting&") ; ?>','<?php echo filterFuncId("/GoodsPriceSummary/column","");?>');  " ><em class="iconfont abe-ft14 mrg_5">&#xe60a;</em>设置</a>
                    </div>
                  </div>
      </form>
    </div>



  <div class="wrap-nmd-box">
    <div class="wrap-master ">

      <div class="list-scroll">
        <div class="table-box">
          <div class="table-in">
            <form id="<?php echo "$funcid"; ?>-Result"  action="<?php U('GoodsPriceSummary/op'); ?>" method="post">
              <table border="0" cellspacing="0" cellpadding="0" class="pub-table ta-tr-hover">
                <colgroup>
                           <col style="width: 40px ;">   <!--  -->
          <!-- 序号        <col style="width: 40px ;">   -->
                           <col style="width: 60px ; <?php if(isset($colshow[""]) && $colshow[""]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 操作 -->
                           <col style="width: 80px ; <?php if(isset($colshow["tx_date"]) && $colshow["tx_date"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 价格日期 -->
                           <col style="width: 80px ; <?php if(isset($colshow["style_code"]) && $colshow["style_code"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 货品码 -->
                           <col style="width: 100px ; <?php if(isset($colshow["style_name"]) && $colshow["style_name"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 货品名称 -->
                           <col style="width: 80px ; <?php if(isset($colshow["materials"]) && $colshow["materials"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 货品材质 -->
                           <col style="width: 80px ; <?php if(isset($colshow["min_price"]) && $colshow["min_price"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 最低价(元) -->
                           <col style="width: 80px ; <?php if(isset($colshow["max_price"]) && $colshow["max_price"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 最高价(元) -->
                           <col style="width: 80px ; <?php if(isset($colshow["uom_weight"]) && $colshow["uom_weight"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 单位 -->
                           <col style="width: 150px ; <?php if(isset($colshow["create_time"]) && $colshow["create_time"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 创建时间 -->
                           <col style="width:auto" >
                </colgroup>
                <tbody>
                  <tr>
                          <th><input type="checkbox"  onclick="_asr.selectAll(this);"> &nbsp;#</th>
          <!-- 序号       <th>序号</th>   -->
                          <th class="abe-txtl">操作</th>
                          <th <?php if(isset($colshow["tx_date"]) && $colshow["tx_date"]=="0"): ?> style="display:none" <?php endif; ?>>价格日期</th>
                          <th <?php if(isset($colshow["style_code"]) && $colshow["style_code"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">货品码</th>
                          <th <?php if(isset($colshow["style_name"]) && $colshow["style_name"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">货品名称</th>
                          <th <?php if(isset($colshow["materials"]) && $colshow["materials"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">货品材质</th>
                          <th <?php if(isset($colshow["min_price"]) && $colshow["min_price"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtr">最低价(元)</th>
                          <th <?php if(isset($colshow["max_price"]) && $colshow["max_price"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtr">最高价(元)</th>
                          <th <?php if(isset($colshow["uom_weight"]) && $colshow["uom_weight"]=="0"): ?> style="display:none" <?php endif; ?>>单位</th>
                          <th <?php if(isset($colshow["create_time"]) && $colshow["create_time"]=="0"): ?> style="display:none" <?php endif; ?>>创建时间</th>
                           <th></th >
                        </tr>
                        <?php $parent_trNo=""; $group=""; $groupId="";?>
                        <?php if(is_array($list)): $i = 0; $__LIST__ = $list; if( count($__LIST__) == 0) : echo ""; else: foreach($__LIST__ as $key=>$master): $mod = ($i % 2 );++$i; ?>
                                  <?php $seqNo = $i + ($page_size * ($p - 1)); ?>

                                  <?php $trColor = $mod=="1"?"even":"odd"; ?>
                                  <?php $trNo=($parent_trNo?$parent_trNo.".":"").$seqNo; ?>
                                  <tr class="<?php echo $trColor; ?>" group="<?php echo $group; ?>" group-id="<?php echo $groupId; ?>">
                                  <!-- 选择 -->
                                  <td class="abe-txtl"><input type="checkbox" name="Key[]" data-type="select" onclick="_asr.selectMulit(this);" value="<?php echo $master['id'] ;?>">&nbsp;<?php echo $trNo; ?></td>
                                  <!-- 序号 -->
                                  <td  class=" abe-txtl ">



          <?php if (isset($rights['master_view']) && $rights['master_view']): ?>
               <a href="javascript:void(0);"  class=" vi-blue vi-blue " onclick="return _asr.popupFun('<?php echo U("/Home/GoodsPrice/index?func=view&id=$master[id]") ; ?>', '<?php echo filterFuncId("/Home/GoodsPrice/index?func=view&id=$master[id]","");?>'); "><i class="iconfont abe-ft18">&#xe62e;</i></a>
          <?php endif; ?>





          <?php if (isset($rights['master_edit']) && $rights['master_edit']): ?>
               <a href="javascript:void(0);"  class=" vi-blue vi-blue " onclick="return _asr.popupFun('<?php echo U("/Home/GoodsPrice/index?func=edit&id=$master[id]") ; ?>', '<?php echo filterFuncId("/Home/GoodsPrice/index?func=edit&id=$master[id]","");?>'); "><i class="iconfont abe-ft15">&#xe63f;</i></a>
          <?php endif; ?>





          <?php if (isset($rights['master_delete']) && $rights['master_delete']): ?>
          <?php if ($master['status']==0): ?>
               <a href="javascript:void(0);"  class=" vi-blue vi-blue " onclick="return _asr.confirm('确认操作', '请确认是否删除货品价格区间?', '<?php echo "货品价格区间 : $master[id]"; ?>', '<?php echo U("/Home/GoodsPrice/index?func=delete&type=1&id=$master[id]") ; ?>','',''); "><i class="iconfont vi-red">&#xe61d;</i></a>
          <?php endif; ?>
          <?php endif; ?></td>


                                  <td style=" <?php if(isset($colshow["tx_date"]) && $colshow["tx_date"]=="0"): ?>display:none<?php endif; ?> " ><?php echo system_format("D", $master["tx_date"],1) ; ?></td>
                                  <td style=" <?php if(isset($colshow["style_code"]) && $colshow["style_code"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["style_code"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["style_name"]) && $colshow["style_name"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["style_name"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["materials"]) && $colshow["materials"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["materials"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["min_price"]) && $colshow["min_price"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtr "><?php echo system_format("F33", $master["min_price"],1) ; ?></td>
                                  <td style=" <?php if(isset($colshow["max_price"]) && $colshow["max_price"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtr "><?php echo system_format("F33", $master["max_price"],1) ; ?></td>
                                  <td style=" <?php if(isset($colshow["uom_weight"]) && $colshow["uom_weight"]=="0"): ?>display:none<?php endif; ?> " ><?php echo $master["uom_weight"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["create_time"]) && $colshow["create_time"]=="0"): ?>display:none<?php endif; ?> " ><?php echo system_format("DT", $master["create_time"],1) ; ?></td>
                                 <td></td>
                              </tr>
                              <?php endforeach; ?>
                              <?php
 endif; else: echo "" ;endif; ?>
                </tbody>
              </table>
            </form>
          </div>
        <?php if($search["_execsearch"] == "0"): ?>
          <div style="background: #f2f2f3; color: #999; text-align: center; font-size: 14px; padding: 20px 0; margin-top:10px;">搜索后显示数据</div>
        <?php endif; ?>
        </div>



        <div class="data-oper" >
          <?php echo $page; ?>
        </div>

      </div>


   </div>


  </div>

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


        function <?php echo $funcid; ?>_keyword_set(){
            _frm = "<?php echo $funcid;?>-Search";
            var _this = $("#<?php echo $funcid;?>-keyword-input");
            _asr.setvaluebyname(_frm,"_keyword",_this.val());
            return true;
        }

        function <?php echo ($funcid); ?>_keyword_keydown(obj){
            var e = window.event || arguments.callee.caller.arguments[0];
            if (e && e.keyCode == 13 ) {
                  <?php echo $funcid; ?>_keyword_set();
                $("#<?php echo ($funcid); ?>-keyword-search").click();
            }
        }
        /***************************************************************************************/
        /* 前台页面初始化                                                                      */
        /***************************************************************************************/
        function <?php echo $funcid; ?>_init(_id){
            var _searchInfo, searchbutt, _searchshow,_searchhide,_searchkeyword;
            _searchhide = $("#<?php echo $funcid;?> .search-hide");
            _searchshow = $("#<?php echo $funcid;?> .search-show");
            _searchInfo = $("#<?php echo $funcid;?>-search-Info");
            _searchbutt = $("#<?php echo $funcid;?>-search-butt");
            _searchkeyword = $("#<?php echo $funcid;?>-keyword-info");
            _frm = "<?php echo $funcid;?>-Search";
            _searchshow.bind("click", function() {
                _searchInfo.show();
                _searchbutt.show();
                _searchshow.hide();
                _searchhide.show();
                _searchkeyword.hide();
                _asr.setvaluebyname(_frm,"_showsearch","show");
            });
            _searchhide.bind("click", function() {
                _searchInfo.hide();
                _searchbutt.hide();
                _searchshow.show();
                _searchhide.hide();
                _searchkeyword.show();
                _asr.setvaluebyname(_frm,"_showsearch","hide");
            });

        <?php if($search["_showsearch"]=="show"):?>
            _searchshow.click();
        <?php else: ?>
            _searchhide.click();
        <?php endif; ?>

            return false;
        }


        /***************************************************************************************/
        /* 前台页面清除                                                                      */
        /***************************************************************************************/
        function <?php echo $funcid; ?>_clearsearch(_frm){
            _asr.setvaluebyname(_frm,"tx_date","");
            _asr.setvaluebyname(_frm,"tx_date2","");
            _asr.setvaluebyname(_frm,"style_code","");
            _asr.setvaluebyname(_frm,"style_name","");
            _asr.setvaluebyname(_frm,"materials","");
            _asr.setvaluebyname(_frm,"min_price","");
            _asr.setvaluebyname(_frm,"min_price2","");
            _asr.setvaluebyname(_frm,"max_price","");
            _asr.setvaluebyname(_frm,"max_price2","");
            _asr.setvaluebyname(_frm,"uom_weight","");

          $("#<?php echo ($funcid); ?>").find(".selebtn").each(function(){
              $(this).find("a:eq(0)").click();
            });

          $("#<?php echo ($funcid); ?> .city-tags-new .sele-remove").click();
        }

        /***************************************************************************************/
        /* 后台返回 callback                                                                 */
        /***************************************************************************************/
        function <?php echo $funcid; ?>_callback(_json){
        // 返回类型 _json.action
        // 返回数据 _json.data
            switch(_json.action){
            default:
                alert("no code for callback action '" + _json.action + "'");
                break;
            }
            return ;
        }

        /***************************************************************************************/
        /* 后台返回 dealAlert                                                            */
        /***************************************************************************************/
        function <?php echo "$funcid"; ?>_dealAlert(l){
            var node=$('#'+l.getAlertId());

            var funcid="<?php echo "$funcid"; ?>";
            $('#'+funcid+"-Search input[type='button']").eq(0).click();

            node.on('click','input[type="button"]',function(){
                $('#'+l.getFormId()).parent().show();
                l.close(2);
            });

            node.on('click','input[type="submit"]',function(){
                $('#'+l.getFormId()).parent().show();
                l.close(2);
                if(!l.isErr){
                    $('#'+l.getFormId()).parent().find('a.close').click()
                }
            });

            node.on('click','a.close ',function(){
                $('#'+l.getFormId()).parent().show();
                l.close(2);
            });
        }


    <?php echo W('Summary/javascript',array('GoodsPriceSummary'));?>


    </script>