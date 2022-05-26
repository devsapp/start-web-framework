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
<a class="btn btn-success" target="_blank" href="https://www.ask2.cn/article-14496.html">查看QQ互联配置教程</a>
<form action="index.php?admin_setting/qqlogin{$setting['seo_suffix']}" method="post">
    <table class="table">
        <tr class="header">
            <td colspan="2">参数设置</td>
        </tr>
        <tr>
            <td colspan="2">配置qq互联参数前请先到<a href="http://connect.qq.com/">qq开发平台</a>申请qq互联,申请通过后可获取配置参数</td>
        </tr>
        <tr>
            <td width="45%"><b>是否开启qq互联：</b><br><span class="smalltxt">qq互联平台管理中心的APP ID值</span></td>
            <td>
                <input type="radio" value="1" name="qqlogin_open" {if $setting['qqlogin_open']}checked{/if}/>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" value="0" name="qqlogin_open" {if !$setting['qqlogin_open']}checked{/if}/>否
            </td>
        </tr>
        <tr>
            <td width="45%"><b>APP ID：</b><br><span class="smalltxt">qq互联平台管理中心的APP ID值</span></td>
            <td><input type="text" size="60" value="{$setting['qqlogin_appid']}" name="qqlogin_appid" /></td>
        </tr>
        <tr>
            <td width="45%"><b>KEY:</b><br><span class="smalltxt">qq互联平台管理中心的KEY值</span></td>
            <td><input type="text" size="60" value="{$setting['qqlogin_key']}" name="qqlogin_key"></td>
        </tr>


    </table>
    <br>
    <center><input type="submit" class="btn btn-success" name="submit" value="提 交"></center><br>
</form>
<br>
<!--{template footer}-->