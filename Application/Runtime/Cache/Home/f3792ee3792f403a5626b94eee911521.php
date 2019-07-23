<?php if (!defined('THINK_PATH')) exit();?>
<div class="prompt-pop" data-type="detail_add" id="<?php echo $funcid ?>" style="z-index: <?php echo ($zindex); ?>" funcid="<?php echo ($funcid); ?>" >
    <div class="title">
        <span class="pop-name">选择客户</span>
        <a href="javascript:void(0);" onclick="_asr.closePopup('<?php echo ($funcid); ?>');" class="close iconfont">&#xe60d;</a>
    </div>
    <div class="trees-box">
        <div> <!-- class="trees-info" -->
            <div class="screening treesorder">
                <form id="<?php echo "$funcid"; ?>-selectCustomer-Search" action="<?php echo U('/Home/Trade/index?func=selectCustomer');?>" method="get">
                <input type="hidden" name="funcid" value="<?php echo ($funcid); ?>" />
                <input type="hidden" name="zindex" value="<?php echo ($zindex); ?>" />
                <input type="hidden" name="p" value="<?php echo ($p); ?>" />
                <ul class="form form-style1">
                    <li> <span class="tit">客户名称</span>
                        <div class="item">
                            <div class="txt-box">
                                <input type="text" name="keyword" value="<?php echo ($search['keyword']); ?>" class="txt">
                            </div>
                        </div>
                    </li>
                    <li> <span class="tit">在全部客户中搜索</span>
                        <div class="item">
                            <div class="txt-box">
                                <input type="checkbox" name="search_all" value="1" <?php if($search['search_all'] == 1) { ?>checked="checked"<?php } ?>>
                            </div>
                        </div>
                    </li>
                </ul>
                <!--筛选表单-->
                <div class="tress-sub abe-txtc">
                    <input type="submit" value="搜索" class="btn btn-org btn-sm mrg_10" onclick="return _asr.submit('<?php echo $funcid;?>', this, '')">
                    <input type="button" value="清除"  class="btn btn-blue btn-sm mrg_10" onclick="return <?php echo "$funcid"; ?>_clearsearch('<?php echo "$funcid"; ?>-selectCustomer-Search');">
                </div>
                </form>
            </div>
            <div class="table-box">
                <div class="table-in" style="height: 300px;">
                    <table border="0" cellspacing="0" cellpadding="0" class="pub-table">
                        <colgroup>
                            <col style="width:10px;">
                            <col style="width:80px;">
                            <col style="width:100px;">
                            <col style="width:100px;">
                            <col style="width:80px;">
                        </colgroup>
                        <tbody>
                        <tr>
                            <th>#</th>
                            <th>客户名称</th>
                            <th>联系人</th>
                            <th>联系电话</th>
                            <th>地址</th>
                        </tr>
                        <?php if(is_array($customer)): $i = 0; $__LIST__ = $customer;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><tr class="<?php if(($mod) == "1"): ?>even<?php else: ?>odd<?php endif; ?>">
                            <td><input j='<?php echo json_encode($item); ?>' type="<?php if(strtolower($selecttype) == 'multi'): ?>checkbox<?php else: ?>radio<?php endif; ?>" name="id[]" value="<?php echo ($item['id']); ?>" show="<?php echo ($item['name']); ?>" /></td>
                            <td><?php echo ($item["name"]); ?></td>
                            <td><?php echo ($item["linkman"]); ?></td>
                            <td><?php echo ($item["mobile"]); ?></td>
                            <td><?php echo ($item['address']); ?></td>
                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="blank15"></div>
                <?php echo $page; ?>
                <div class="blank15"></div>
            </div>
        </div>
    </div>
    <div class="pop-sub abe-txtc">
        <input type="submit" value="选择" class="btn btn-org mrg_10" onclick="_asr.returnPopup('<?php echo ($funcid); ?>');">
        <input type="submit" value="取消" class="btn" onclick="_asr.closePopup('<?php echo ($funcid); ?>');">
    </div>
</div>
<script>
    function <?php echo $funcid ?>_init() {
        var _this = $("#<?php echo $funcid ?>");
        var ppw = _this.width()/2;
        _this.css({'margin-left':-ppw});
    }
    function <?php echo $funcid; ?>_clearsearch(_frm){
        _asr.setvaluebyname(_frm,"keyword", "" );
    }
    function <?php echo $funcid ?>_refresh() {
        _asr.submit('<?php echo $funcid;?>', $("#<?php echo $funcid ?>").find("form").eq(1), '');
    }
</script>