<!--{template header}-->
<script type="text/javascript">g_site_url = '{SITE_URL}';
    g_prefix = '{$setting['seo_prefix']}';
    g_suffix = '{$setting['seo_suffix']}';</script>
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;站点设置</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<div class="alert  alert-warning">{$message}</div>
<!--{/if}-->
<form class="form-horizontal" action="index.php?admin_app/setting{$setting['seo_suffix']}" method="post" enctype="multipart/form-data">
    <a name="基本设置"></a>
    <table class="table">
        <tr class="header">
            <td colspan="2">app设置</td>
        </tr>
        <tr>
            <td class="altbg1" width="45%"><b>app用户代理:</b><br>
                <span class="smalltxt">用于识别来自原生代理</span></td>
            <td class="altbg2"><input type="text" class="form-control shortinput" value="{$setting['app_useragnet']}" name="app_useragnet"></td>
        </tr>
            <tr>
            <td class="altbg1" width="45%"><b>app协议头:</b><br>
                <span class="smalltxt">用户和原生app通信，格式：协议头://协议名称，如果whatsns://webview,baidu://webview</span></td>
            <td class="altbg2"><input type="text" class="form-control shortinput" value="{$setting['app_xieyi']}" name="app_xieyi"></td>
        </tr>
        <tr>
            <td class="altbg1" width="45%"><b>App端默认模板:</b><br>
                <span class="smalltxt">应用APP端默认模板，官方默认提供一套，如果自己有开发可以从下拉列表选择，app端模板格式（英文名称+app,如webapp,xiaomiapp,baiduapp,aliapp),application/views/目录下</span></td>
            <td class="altbg2">
                <select name="app_template">
                    <!--{loop $apptpllist  $value}-->
                    <option class="select" value="{$value}" <!--{if $value==$setting['tpl_dir']}--> selected <!--{/if}--> >{$value}</option>
                    <!--{/loop}-->
                </select>
            </td>
        </tr>
        
    </table>
    <br>
    <center><input type="submit" class="button" name="submit" value="提 交"></center><br>
</form>
<br>
<!--{template footer}-->