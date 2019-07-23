<?php if (!defined('THINK_PATH')) exit();?>
<div toplayer="1" class="wrap-box wrap-nmd wrap-style00 " id="<?php echo $funcid;?>" summaryid="NodeSummary" baseurl="<?php echo U('NodeSummary/index'); ?>">
  <div class="wrap-box-info ">

    <div class="wrap-title abe-ofl">
      <div class="tit abe-fl" style="width: 450px;">模块功能列表</div>
      <div class="abe-fl">
        <div class="textbox" >
          <div  id="<?php echo "$funcid"; ?>-keyword-info" class="abe-fl"<?php if($search["_showsearch"]=="show"):?>style="display:none;"<?php endif; ?>>
             <input type="text" class="pbtxt txt0" id="<?php echo $funcid;?>-keyword-input" value="<?php echo $search['_keyword']; ?>"  onKeyDown="<?php echo ($funcid); ?>_keyword_keydown(this);" placeholder=" 输入关键词进行搜索 ">
             <input type="button" value="搜索" class="btn btn-org  mrg_10 " id="<?php echo $funcid;?>-keyword-search"  default-status="1"  onclick="<?php echo ($funcid); ?>_keyword_set(); return _asr.submit('<?php echo "$funcid"; ?>', '<?php echo "$funcid"; ?>-Search', '<?php echo U("NodeSummary/index?func=search&") ; ?>',''); " />
             <input id="<?php echo $funcid;?>-search-buttc" type="button" value="导出" class="btn btn-blue mrg_10 " default-status="1" onclick="return _asr.showExport('<?php echo "$funcid"; ?>', '<?php echo "$funcid"; ?>-Search', '<?php echo U("NodeSummary/index?func=export&") ; ?>',<?php echo $p ?>); " />
          </div>
          <a href="javascript:void(0);" class="mrg_15 vi-blue search-show" <?php if($search["_showsearch"]=="show"):?>style="display:none;"<?php endif; ?>><i class="iconfont">&#xe673;</i>搜索扩展</a>
        </div>
      </div>
      <div class="abe-fr">
        <a href="javascript:void(0);" class="mrg_15 vi-blue search-hide" <?php if($search["_showsearch"]=="hide"):?>style="display:none;"<?php endif; ?>><i class="iconfont">&#xe673;</i>收起搜索</a>


               <a href="javascript:void(0);"  class=" vi-blue " onclick="return _asr.openLink('','<?php echo "$funcid"; ?>','刷新',1); "><i class="iconfont ">&#xe611;</i> 刷新</a>

      </div>
    </div>


    <div class="screening"  >
      <form action="<?php echo U('NodeSummary/index?func=search'); ?>" id="<?php echo "$funcid"; ?>-Search" method="get">
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
                      <div class="unit-left"> 选择状态</div>
                      <div class="unit-mid">
                          <div class="dropdown" id="<?php echo ($funcid); ?>_status">
                             <div class="selebtn">
                                <input type="hidden"  name="status" value="<?php echo $search['status']; ?>">
                                <a href="javascript:void(0);" onclick="_asr.selebtn_click(this,'');" class="<?php  echo $search['status']!=""?"":"active"; ?>">全部</a>
                           <?php $keyvalue = table_Node_status(); if(is_array($keyvalue)){ $i = 0; $__LIST__ = $keyvalue; ?>
                               <?php foreach($__LIST__ as $key=>$item): ++$i; ?>
                                 <a href="javascript:void(0);" onclick="_asr.selebtn_click(this,'<?php echo $item['id'];?>');" class="<?php  echo $search['status']!=$item['id']?"":"active"; ?>"><?php echo $item['name']; ?></a>
                               <?php if($i==2) break; ?>
                               <?php endforeach; ?>
                           <?php } ?>
                             </div>
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 模块名称</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="name"  value="<?php echo $search['name']; ?>"   placeholder=" 直接进行模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 模块描述</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="title"  value="<?php echo $search['title']; ?>"   placeholder=" 直接进行模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 级别</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="level"  value="<?php echo $search['level']; ?>"  >
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 模块说明</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="module"  value="<?php echo $search['module']; ?>"   placeholder=" 直接进行模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 启动方式</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="model"  value="<?php echo $search['model']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 按钮名称</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="btn_name"  value="<?php echo $search['btn_name']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 超级用户</div>
                      <div class="unit-mid">
                          <div class="dropdown" id="<?php echo ($funcid); ?>_is_admin">
                             <div class="selebtn">
                                <input type="hidden"  name="is_admin" value="<?php echo $search['is_admin']; ?>">
                                <a href="javascript:void(0);" onclick="_asr.selebtn_click(this,'');" class="<?php  echo $search['is_admin']!=""?"":"active"; ?>">全部</a>
                           <?php $keyvalue = table_Node_is_admin(); if(is_array($keyvalue)){ $i = 0; $__LIST__ = $keyvalue; ?>
                               <?php foreach($__LIST__ as $key=>$item): ++$i; ?>
                                 <a href="javascript:void(0);" onclick="_asr.selebtn_click(this,'<?php echo $item['id'];?>');" class="<?php  echo $search['is_admin']!=$item['id']?"":"active"; ?>"><?php echo $item['name']; ?></a>
                               <?php if($i==2) break; ?>
                               <?php endforeach; ?>
                           <?php } ?>
                             </div>
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 图标</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt0" name="ico"  value="<?php echo $search['ico']; ?>"   placeholder=" 输入%可进行匹配模糊搜索 ">
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 缺省展开</div>
                      <div class="unit-mid">
                          <div class="dropdown" id="<?php echo ($funcid); ?>_default_open">
                             <div class="selebtn">
                                <input type="hidden"  name="default_open" value="<?php echo $search['default_open']; ?>">
                                <a href="javascript:void(0);" onclick="_asr.selebtn_click(this,'');" class="<?php  echo $search['default_open']!=""?"":"active"; ?>">全部</a>
                           <?php $keyvalue = table_Node_default_open(); if(is_array($keyvalue)){ $i = 0; $__LIST__ = $keyvalue; ?>
                               <?php foreach($__LIST__ as $key=>$item): ++$i; ?>
                                 <a href="javascript:void(0);" onclick="_asr.selebtn_click(this,'<?php echo $item['id'];?>');" class="<?php  echo $search['default_open']!=$item['id']?"":"active"; ?>"><?php echo $item['name']; ?></a>
                               <?php if($i==2) break; ?>
                               <?php endforeach; ?>
                           <?php } ?>
                             </div>
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 交易方</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt1" name="side"  value="<?php echo $search['side']; ?>"  >
                              <em class="space-line">-</em>
                              <input type="text" class="pbtxt txt1" name="side2" value="<?php echo $search['side2']; ?>"  >
                          </div>
                          <div class="prompt" style="display:none">
                              <div class="error"><i class="iconfont">&#xe616;</i></div>
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="unit-left"> 菜单</div>
                      <div class="unit-mid">
                          <div class="textbox">
                              <input type="text" class="pbtxt txt1" name="menu"  value="<?php echo $search['menu']; ?>"  >
                              <em class="space-line">-</em>
                              <input type="text" class="pbtxt txt1" name="menu2" value="<?php echo $search['menu2']; ?>"  >
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
                      <a href="#" onclick="return _asr.tabsheet('<?php echo $funcid;?>', '<?php echo "$funcid"; ?>-Search', 'youxiao');" <?php if($search['_tab'] == 'youxiao'): ?> class="current"<?php endif;?>>有效</a>
                      <a href="#" onclick="return _asr.tabsheet('<?php echo $funcid;?>', '<?php echo "$funcid"; ?>-Search', 'wuxiao');" <?php if($search['_tab'] == 'wuxiao'): ?> class="current"<?php endif;?>>无效</a>
                    </div>
                    <p class="annotation vi-red"></p>
                    <div class="sub-box-in abe-fr"  id="<?php echo $funcid;?>-search-butt">


          <?php if (isset($rights['search']) && $rights['search']): ?>
               <input type="button" value="搜索" class="btn btn-org  mrg_10 " onclick="return _asr.submit('<?php echo "$funcid"; ?>', '<?php echo "$funcid"; ?>-Search', '<?php echo U("NodeSummary/index?func=search&") ; ?>',''); " />
          <?php endif; ?>



               <input type="button" value="清除" class="btn btn-blue mrg_10 " onclick="return <?php echo "$funcid"; ?>_clearsearch('<?php echo "$funcid"; ?>-Search');" />



          <?php if (isset($rights['export']) && $rights['export']): ?>
               <input type="button" value="导出" class="btn btn-blue mrg_10 " onclick="return _asr.showExport('<?php echo "$funcid"; ?>', '<?php echo "$funcid"; ?>-Search', '<?php echo U("NodeSummary/index?func=export&") ; ?>',<?php echo $p ?>); " />
          <?php endif; ?>

                    <em class="pdr_20"></em>
                    <a href="javascript:void(0);" class="table-set <?php echo count($colshow)>0?"vi-blue":"abe-gray3"; ?>"  onclick="return _asr.popupFun('<?php echo U("/Summary/NodeSummary/index?func=columnsetting&") ; ?>','<?php echo filterFuncId("/NodeSummary/column","");?>');  " ><em class="iconfont abe-ft14 mrg_5">&#xe60a;</em>设置</a>
                    </div>
                  </div>
      </form>
    </div>



  <div class="wrap-nmd-box">
    <div class="wrap-master ">

      <div class="list-scroll">
        <div class="table-box">
          <div class="table-in">
            <form id="<?php echo "$funcid"; ?>-Result"  action="<?php U('NodeSummary/op'); ?>" method="post">
              <table border="0" cellspacing="0" cellpadding="0" class="pub-table ta-tr-hover">
                <colgroup>
                           <col style="width: 40px ;">   <!--  -->
          <!-- 序号        <col style="width: 40px ;">   -->
                           <col style="width: 80px ; <?php if(isset($colshow["status"]) && $colshow["status"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 状态 -->
                           <col style="width: 100px ; <?php if(isset($colshow["name"]) && $colshow["name"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 模块名称 -->
                           <col style="width: 100px ; <?php if(isset($colshow["title"]) && $colshow["title"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 模块描述 -->
                           <col style="width: 80px ; <?php if(isset($colshow["sort"]) && $colshow["sort"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 排序 -->
                           <col style="width: 80px ; <?php if(isset($colshow["pid"]) && $colshow["pid"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 父层 -->
                           <col style="width: 80px ; <?php if(isset($colshow["level"]) && $colshow["level"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 级别 -->
                           <col style="width: 100px ; <?php if(isset($colshow["module"]) && $colshow["module"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 模块说明 -->
                           <col style="width: 80px ; <?php if(isset($colshow["model"]) && $colshow["model"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 启动方式 -->
                           <col style="width: 80px ; <?php if(isset($colshow["btn_name"]) && $colshow["btn_name"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 按钮名称 -->
                           <col style="width: 80px ; <?php if(isset($colshow["is_admin"]) && $colshow["is_admin"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 超级用户 -->
                           <col style="width: 80px ; <?php if(isset($colshow["ico"]) && $colshow["ico"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 图标 -->
                           <col style="width: 80px ; <?php if(isset($colshow["default_open"]) && $colshow["default_open"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 缺省展开 -->
                           <col style="width: 80px ; <?php if(isset($colshow["side"]) && $colshow["side"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 交易方 -->
                           <col style="width: 80px ; <?php if(isset($colshow["menu"]) && $colshow["menu"]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 菜单 -->
                           <col style="width: 80px ; <?php if(isset($colshow[""]) && $colshow[""]=="0"): ?>display:none;<?php endif; ?> ">  <!-- 状态调整 -->
                           <col style="width:auto" >
                </colgroup>
                <tbody>
                  <tr>
                          <th><input type="checkbox"  onclick="_asr.selectAll(this);"> &nbsp;#</th>
          <!-- 序号       <th>序号</th>   -->
                          <th <?php if(isset($colshow["status"]) && $colshow["status"]=="0"): ?> style="display:none" <?php endif; ?>>状态</th>
                          <th <?php if(isset($colshow["name"]) && $colshow["name"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">模块名称</th>
                          <th <?php if(isset($colshow["title"]) && $colshow["title"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">模块描述</th>
                          <th <?php if(isset($colshow["sort"]) && $colshow["sort"]=="0"): ?> style="display:none" <?php endif; ?>>排序</th>
                          <th <?php if(isset($colshow["pid"]) && $colshow["pid"]=="0"): ?> style="display:none" <?php endif; ?>>父层</th>
                          <th <?php if(isset($colshow["level"]) && $colshow["level"]=="0"): ?> style="display:none" <?php endif; ?>>级别</th>
                          <th <?php if(isset($colshow["module"]) && $colshow["module"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">模块说明</th>
                          <th <?php if(isset($colshow["model"]) && $colshow["model"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">启动方式</th>
                          <th <?php if(isset($colshow["btn_name"]) && $colshow["btn_name"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">按钮名称</th>
                          <th <?php if(isset($colshow["is_admin"]) && $colshow["is_admin"]=="0"): ?> style="display:none" <?php endif; ?>>超级用户</th>
                          <th <?php if(isset($colshow["ico"]) && $colshow["ico"]=="0"): ?> style="display:none" <?php endif; ?> class="abe-txtl">图标</th>
                          <th <?php if(isset($colshow["default_open"]) && $colshow["default_open"]=="0"): ?> style="display:none" <?php endif; ?>>缺省展开</th>
                          <th <?php if(isset($colshow["side"]) && $colshow["side"]=="0"): ?> style="display:none" <?php endif; ?>>交易方</th>
                          <th <?php if(isset($colshow["menu"]) && $colshow["menu"]=="0"): ?> style="display:none" <?php endif; ?>>菜单</th>
                          <th>状态调整</th>
                           <th></th >
                        </tr>
                        <?php $parent_trNo=""; $group=""; $groupId="";?>
                        <?php if(is_array($list)): $i = 0; $__LIST__ = $list; if( count($__LIST__) == 0) : echo ""; else: foreach($__LIST__ as $key=>$master): $mod = ($i % 2 );++$i; ?>
                                  <?php $seqNo = $i + ($page_size * ($p - 1)); ?>

                                  <?php $trColor = $mod=="1"?"even":"odd"; ?>
                                  <?php if ($master[status]=='0'): $trColor.=" gray-tdbg"; endif; ?>
                                  <?php $trNo=($parent_trNo?$parent_trNo.".":"").$seqNo; ?>
                                  <tr class="<?php echo $trColor; ?>" group="<?php echo $group; ?>" group-id="<?php echo $groupId; ?>">
                                  <!-- 选择 -->
                                  <td class="abe-txtl"><input type="checkbox" name="Key[]" data-type="select" onclick="_asr.selectMulit(this);" value="<?php echo $master['id'] ;?>">&nbsp;<?php echo $trNo; ?></td>
                                  <!-- 序号 -->
                                  <td style=" <?php if(isset($colshow["status"]) && $colshow["status"]=="0"): ?>display:none<?php endif; ?> " ><?php echo get_table_Node_status("$master[status]","name","") ; ?></td>
                                  <td style=" <?php if(isset($colshow["name"]) && $colshow["name"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["name"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["title"]) && $colshow["title"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><div class="newline newline-l"><?php echo OverView($master["title"],100,"...") ; ?></div></td>
                                  <td style=" <?php if(isset($colshow["sort"]) && $colshow["sort"]=="0"): ?>display:none<?php endif; ?> " ><?php echo system_format("N", $master["sort"],1) ; ?></td>
                                  <td style=" <?php if(isset($colshow["pid"]) && $colshow["pid"]=="0"): ?>display:none<?php endif; ?> " class=" <?php if ($master['pid']<0): ?> abe-red <?php endif; ?> "><?php echo system_format("N3", $master["pid"],1) ; ?></td>
                                  <td style=" <?php if(isset($colshow["level"]) && $colshow["level"]=="0"): ?>display:none<?php endif; ?> " ><?php echo $master["level"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["module"]) && $colshow["module"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><div class="newline newline-l"><?php echo OverView($master["module"],100,"...") ; ?></div></td>
                                  <td style=" <?php if(isset($colshow["model"]) && $colshow["model"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["model"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["btn_name"]) && $colshow["btn_name"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["btn_name"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["is_admin"]) && $colshow["is_admin"]=="0"): ?>display:none<?php endif; ?> " ><?php echo get_table_Node_is_admin("$master[is_admin]","name","") ; ?></td>
                                  <td style=" <?php if(isset($colshow["ico"]) && $colshow["ico"]=="0"): ?>display:none<?php endif; ?> " class=" abe-txtl "><?php echo $master["ico"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["default_open"]) && $colshow["default_open"]=="0"): ?>display:none<?php endif; ?> " ><?php echo get_table_Node_default_open("$master[default_open]","name","") ; ?></td>
                                  <td style=" <?php if(isset($colshow["side"]) && $colshow["side"]=="0"): ?>display:none<?php endif; ?> " ><?php echo $master["side"] ; ?></td>
                                  <td style=" <?php if(isset($colshow["menu"]) && $colshow["menu"]=="0"): ?>display:none<?php endif; ?> " ><?php echo $master["menu"] ; ?></td>
                                  <td>


          <?php if (isset($rights['status_on']) && $rights['status_on']): ?>
          <?php if (!$master['status']): ?>
               <input type="button" value="有效" class="btn btn-sm btn-blue mlg_10 " onclick="return _asr.popupFun('<?php echo U("/Home/Node/index?func=status_on&id=$master[id]") ; ?>', '<?php echo filterFuncId("/Home/Node/index?func=status_on&id=$master[id]","");?>'); " />
          <?php endif; ?>
          <?php endif; ?>



          <?php if (isset($rights['status_off']) && $rights['status_off']): ?>
          <?php if ($master['status']=='1'): ?>
               <input type="button" value="无效" class="btn btn-sm btn-org mlg_10 " onclick="return _asr.popupFun('<?php echo U("/Home/Node/index?func=status_off&id=$master[id]") ; ?>', '<?php echo filterFuncId("/Home/Node/index?func=status_off&id=$master[id]","");?>'); " />
          <?php endif; ?>
          <?php endif; ?></td>

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
            _asr.setvaluebyname(_frm,"status","");
            _asr.setvaluebyname(_frm,"name","");
            _asr.setvaluebyname(_frm,"title","");
            _asr.setvaluebyname(_frm,"level","");
            _asr.setvaluebyname(_frm,"module","");
            _asr.setvaluebyname(_frm,"model","");
            _asr.setvaluebyname(_frm,"btn_name","");
            _asr.setvaluebyname(_frm,"is_admin","");
            _asr.setvaluebyname(_frm,"ico","");
            _asr.setvaluebyname(_frm,"default_open","");
            _asr.setvaluebyname(_frm,"side","");
            _asr.setvaluebyname(_frm,"side2","");
            _asr.setvaluebyname(_frm,"menu","");
            _asr.setvaluebyname(_frm,"menu2","");

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


    <?php echo W('Summary/javascript',array('NodeSummary'));?>


    </script>