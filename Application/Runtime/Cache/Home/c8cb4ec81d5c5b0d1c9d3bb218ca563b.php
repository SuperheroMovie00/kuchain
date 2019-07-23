<?php if (!defined('THINK_PATH')) exit();?>
<div id="bigdiv">
<div toplayer="1" class="prompt-pop pop-style3" style="z-index:<?php echo ($zindex); ?>;width:200px; margin-left: 0px;display:block;" id="<?php echo $funcid;?>" summaryid="RoleNode" baseurl="<?php echo U('RoleNode/index'); ?>">
    <div class="title">
        <span class="pop-name">维护角色组成员</span>
        <a href="javascript:void(0);" onclick="$(this).parents('.prompt-pop').remove();_asr.closePopup('<?php echo ($funcid); ?>');" class="close iconfont">&#xe60d;</a>
    </div>

    <div class="pop-scroll" >
        <div class="abe-ft14 pdb_5">角色 - <?php echo $role['name']; ?></div>
        <div class="screening" style="height: 440px;overflow-y: scroll">
            <form action="<?php echo U('RoleNode/index?func=saveSelectUser'); ?>" id="<?php echo "$funcid"; ?>-Search" method="get">
            <input type="hidden" name="<?php echo "$funcid"; ?>-last-url" id="<?php echo "$funcid"; ?>-last-url" value="<?php echo $__last_url; ?>" />
            <input type="hidden" name="funcid" value="<?php echo "$funcid"; ?>" />
            <input type="hidden" name="pfuncid" value="<?php echo "$pfuncid"; ?>" />
            <input type="hidden" name="role_id" value="<?php echo $id; ?>" />
            <table border="0" cellspacing="0" cellpadding="0" class="pub-table-set">
                <thead>
                <tr>
                    <th>选择</th><th>部门</th><th>用户</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($user as $k=>$v){ ?>
                <tr class="odd">
                    <td>
                        <input type="checkbox" name="user_id[]" <?php if(in_array($v['id'],$role_user_list)){ ?> checked <?php } ?> value="<?php echo ($v['id']); ?>" />
                    </td>
                    <td><?php echo get_table_Department("$v[department_code]","name"); ?></td>
                    <td><?php echo ($v['name']); ?></td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
            </form>
            <div class="blank10"></div>
        </div></div>

        <div class="blank10"></div>
            <div class="pop-sub abe-txtc" >
            <!-- 按钮权限检测 保存 --->
            <?php if (isset($rights['selectUser']) && $rights['selectUser']): ?>
            <input type="button" value="保存" class="btn btn-blue mrg_10" default-status="1" onclick="return _asr.submit('<?php echo "$funcid"; ?>', '<?php echo "$funcid"; ?>-Search', '<?php echo U("/Home/RoleNode/index?func=saveSelectUser&") ?>',''); " />
            <?php endif; ?>
            <em class="abe-space-sm"></em>
            <!--<input type="button" value="清除" class="btn btn-org mrg_10"  onclick="return clear('<?php echo "$funcid"; ?>-Search');" default-status="1" />-->
            <input type="button" value="清除" class="btn btn-org mrg_10"  onclick="unchechall()" default-status="1" />
            <input type="button" value="全选" class="btn btn-org mrg_10" onclick="chechall()"  default-status="1"/>
        </div>

    </div>
</div>


<script>


    //取消掉选择的复选框
    function unchechall() {
        //点击
        $("#bigdiv input[type='checkbox']:checked").attr("checked",false);
    }
    //选择所有的复选框
    function chechall() {
        //点击
        $("#bigdiv input[type='checkbox']").attr("checked",true);
    }
</script>