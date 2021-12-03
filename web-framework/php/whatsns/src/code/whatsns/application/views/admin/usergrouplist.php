<!--{template header}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;用户管理</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<table class="table">
    <tr>
        <td class="{$type}">{$message}</td>
    </tr>
</table>
<!--{/if}-->
<form action="index.php?admin_usergroup/add{$setting['seo_suffix']}" method="post">
    <table class="table">
        <tbody>
            <tr class="header" ><td>用户列表</td></tr>
            <tr class="altbg1"><td>添加会员组:&nbsp;<input class="txt" name="grouptitle" >&nbsp;&nbsp;&nbsp;<input class="btn" type="submit" value="提 交"></td></tr>
        </tbody>
    </table>
</form>
<form name="userForm" action="index.php?admin_usergroup/edit{$setting['seo_suffix']}" method="post">
    <table class="table">
        <tr class="header">
            <td>用户组ID</td>
            <td>用户组</td>
            <td>经验值下限</td>
            <td>组权限</td>
            <td>删除</td>
        </tr>
        <!--{loop $usergrouplist $usergroup}-->
        <tr>
            <td class="altbg1" width="60"><strong>{$usergroup['groupid']}</strong></td>
            <td class="altbg1" width="200"><input name="groupid[]" type="hidden" value="$usergroup['groupid']"><input name="grouptitle[]" value="$usergroup['grouptitle']" ></td>
            <td class="altbg1" width="200"><input name="scorelower[]" value="$usergroup['creditslower']" ></td>
            <td class="altbg1" width="100"><a href="index.php?admin_usergroup/regular/$usergroup['groupid']{$setting['seo_suffix']}">设置</a></td>
            <td class="altbg1">
                <!--{if $usergroup['groupid']>26 }-->
                <a href="javascript:if(window.confirm('确认删除?'))window.location='index.php?admin_usergroup/remove/$usergroup['groupid']{$setting['seo_suffix']}'">删除</a>
                <!--{else}-->
                不能删除
                <!--{/if}-->
            </td>
        </tr>
        <!--{/loop}-->
        <tr><td class="altbg1" colspan="5" align="left"><input type="submit" value="提交" class="btn btn-success" /></td></tr>
    </table>
</form>
<br>
<!--{template footer}-->
