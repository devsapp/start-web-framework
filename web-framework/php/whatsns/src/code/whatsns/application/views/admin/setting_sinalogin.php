<!--{template header}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;sina微博互联设置</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<table class="table">
    <tr>
        <td class="{$type}">{$message}</td>
    </tr>
</table>
<!--{/if}-->
<form action="index.php?admin_setting/sinalogin{$setting['seo_suffix']}" method="post">
    <table class="table">
        <tr class="header">
            <td colspan="2">参数设置</td>
        </tr>
        <tr>
            <td colspan="2">配置sina微博互联参数前请先到<a href="http://open.weibo.com/">微博开发平台</a>申请微博互联,申请通过后可获取配置参数</td>
        </tr>
        <tr>
            <td width="45%"><b>是否开启sina微博互联：</b><br><span class="smalltxt">开启后才能显示登陆图标</span></td>
            <td>
                <input type="radio" value="1" name="sinalogin_open" {if $setting['sinalogin_open']}checked{/if}/>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" value="0" name="sinalogin_open" {if !$setting['sinalogin_open']}checked{/if}/>否
            </td>
        </tr>
        <tr>
            <td width="45%"><b>App Key：</b><br><span class="smalltxt">sina微博互联平台管理中心的App Key</span></td>
            <td><input type="text" size="60" value="{$setting['sinalogin_appid']}" name="sinalogin_appid" /></td>
        </tr>
        <tr>
            <td width="45%"><b>App Secret:</b><br><span class="smalltxt">sina微博互联平台管理中心的App Secret</span></td>
            <td><input type="text" size="60" value="{$setting['sinalogin_key']}" name="sinalogin_key"></td>
        </tr>


    </table>
    <br>
    <center><input type="submit" class="btn btn-success" name="submit" value="提 交"></center><br>
</form>
<br>
<!--{template footer}-->