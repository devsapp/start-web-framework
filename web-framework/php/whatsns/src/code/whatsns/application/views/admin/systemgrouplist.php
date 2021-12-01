<!--{template header}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;系统用户组</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<table class="table">
    <tr>
        <td class="{$type}">{$message}</td>
    </tr>
</table>
<!--{/if}-->
<table class="table">
    <tbody>
        <tr class="header" ><td colspan="3">系统用户组</td></tr>
        <tr class="header">
            <td>用户组ID</td>
            <td>用户组</td>
            <td >组权限</td>
        </tr>
        <!--{loop $usergrouplist $usergroup}-->
        <tr>
            <td width="100" class="altbg1"><strong>{$usergroup['groupid']}</strong></td>
            <td width="150" class="altbg1">{$usergroup['grouptitle']}</td>
            <td class="altbg1">{if 1!=$usergroup['groupid']}<a href="index.php?admin_usergroup/regular/$usergroup['groupid']{$setting['seo_suffix']}">设置</a>{/if}</td>
        </tr>
        <!--{/loop}-->
    </tbody>
</table>
<br>
<!--{template footer}-->
