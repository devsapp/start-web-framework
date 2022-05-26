<!--{template header}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;qq互联设置</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<table class="table">
    <tr>
        <td class="{$type}">{$message}</td>
    </tr>
</table>
<!--{/if}-->
<form action="index.php?admin_setting/weixinlogin{$setting['seo_suffix']}" method="post">
    <table class="table">
        <tr class="header">
            <td colspan="2">参数设置</td>
        </tr>
        <tr>
            <td colspan="2">如果已经配置好微信认证服务号才能使用电脑端网页扫码登录<strong><a style="text-decoration:underline;color:blue;" target="_blank" href="{SITE_URL}index.php?admin_weixin/setting.html">如果没配置，点击此处去配置</a></strong>如果已配置可在此开启电脑端网页扫码</td>
        </tr>
        <tr>
            <td width="45%"><b>是否开启电脑端微信网页登录：</b><br><span class="smalltxt">启用后可以在PC端登录页面看到微信登录图标</span></td>
            <td>
                <input type="radio" value="1" name="wechat_open" {if $setting['wechat_open']}checked{/if}/>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" value="0" name="wechat_open" {if !$setting['wechat_open']}checked{/if}/>否
            </td>
        </tr>
 


    </table>
    <br>
    <center><input type="submit" class="btn btn-success" name="submit" value="提 交"></center><br>
</form>
<br>
<!--{template footer}-->