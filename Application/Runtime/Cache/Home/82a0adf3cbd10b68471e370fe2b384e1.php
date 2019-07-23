<?php if (!defined('THINK_PATH')) exit();?>
<div class="prompt-pop pop-style2" id="<?php echo ($funcid); ?>" style="z-index:<?php echo ($zindex); ?>">
	<input type="hidden" name="selecttype" value="<?php echo ($selecttype); ?>" />
  <div class="title"><span class="pop-name">选择部门信息</span><a href="javascript:void(0);" class="close iconfont" onclick="_asr.closePopup('<?php echo ($funcid); ?>');">&#xe60d;</a> </div>
  <div class="pop-scroll">
   <div class="table-box">
    <div class="table-in">
      <table border="0" cellspacing="0" cellpadding="0" class="pub-table">
        <colgroup>
        <col style="width:40px;"/>
        <col style="width:150px;"/>
        </colgroup>
        <tbody>
          <tr class="odd">
            <th>选择</th>
            <th class="abe-txtl">部门代码</th>
            <th class="abe-txtl">部门名称</th>

          </tr>
          <?php if(is_array($popupdata)): $i = 0; $__LIST__ = $popupdata;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><tr class="<?php if($mod == 0): ?>even<?php else: ?>odd<?php endif; ?>">
            <td><input j='<?php echo json_encode($item); ?>' type="<?php if(strtolower($selecttype) == 'multi'): ?>checkbox<?php else: ?>radio<?php endif; ?>" name="code[]" value="<?php echo ($item['code']); ?>" show="<?php echo ($item['name']); ?>"></td>
            <td class="abe-txtl"><?php echo ($item['code']); ?></td>
            <td class="abe-txtl"><?php echo ($item['name']); ?></td>

          </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
      </table>
    </div>
    <div class="blank15"></div>
    <?php echo $page; ?>
    <div class="blank15"></div>
    
  </div>
  </div>
   <div class="pop-sub abe-txtc">
    <input type="submit" value="选择" class="btn btn-org mrg_10" onclick="_asr.returnPopup('<?php echo ($funcid); ?>');">
    <input type="submit" value="取消" class="btn" onclick="_asr.closePopup('<?php echo ($funcid); ?>');">
  </div>
  <script>
  </script>
</div>