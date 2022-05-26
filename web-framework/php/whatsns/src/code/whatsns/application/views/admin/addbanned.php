<!--{template header}-->

<script src="{SITE_URL}static/js/jquery.js" type="text/javascript"></script>
<script src="{SITE_URL}static/js/admin.js" type="text/javascript"></script>
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;禁止IP</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<div class="alert  alert-warning">{$message}</div>
<!--{/if}-->
<form action="index.php?admin_banned/add{$setting['seo_suffix']}" method="post">
    <table  class="table table-striped">
        <tr class="header">
            <td colspan="2">配置说明</td>
        </tr>
        <tr>
            <td colspan="2">
                1、直接添加需要禁止访问IP地址，如需启用某IP地址，直接从下面的IP列表中删除即可。<br />
                2、IP地址格式为xxx.xxx.xxx.xxx  其中x为0-9的整数.例如：192.168.1.55<br />
                3、可以使用“*”作为通配符禁止某段地址
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="text" size="3" maxlength="3" name="ip[]" />&nbsp;.&nbsp;<input type="text" size="3" maxlength="3" name="ip[]" />&nbsp;.&nbsp;<input type="text" size="3" maxlength="3" name="ip[]" />&nbsp;.&nbsp;<input type="text" size="3" maxlength="3" name="ip[]" />&nbsp;&nbsp;&nbsp;&nbsp;有效期:<input type="text" class="txt" size="4" value="30" name="expiration" />天&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" class="button" name="submit" value="添 加" /></td>
        </tr>
    </table>
</form>
<form method="post" action="index.php?admin_banned/remove.html" name="userForm">
    <table  class="table table-striped">
        <tbody><tr class="header">
                <td width="5%"><input class="checkbox" value="chkall" id="chkall" onclick="checkall('id[]')" type="checkbox" name="chkall" /><label for="chkall">全选</label></td>
                <td width="20%">IP地址</td>
                <td width="20%">操作人</td>
                <td width="20%">起始时间</td>
                <td width="20%">终止时间</td>
            </tr>
            <!--{loop $iplist $ip}-->
            <tr>
                <td><input class="checkbox" type="checkbox" value="{$ip['id']}" name="id[]" /></td>
                <td>{$ip['ip']}</td>
                <td>{$ip['admin']}</td>
                <td>{$ip['starttime']}</td>
                <td>{$ip['endtime']}</td>
            </tr>
            <!--{/loop}-->
        </tbody></table>
    <input type="submit" class="button" value="删除" />
</form>
<br />
<!--{template footer}-->