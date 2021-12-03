<!--{template header}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;数据调用</div>
</div>

<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<table class="table">
    <tr>
        <td class="{$type}">{$message}</td>
    </tr>
</table>
<!--{/if}-->
<form onsubmit="return confirm('该操作不可恢复，您确认要删除这些调用吗？');"  action="index.php?admin_datacall/remove{$setting['seo_suffix']}"  method=post>
    <table class="table" >
        <tr class="header"><td colspan="5">调用列表 &nbsp;&nbsp;&nbsp;<input type="button" style="cursor:pointer" onclick="document.location.href = 'index.php?admin_datacall/add{$setting['seo_suffix']}'" value="添加调用" /></td></tr>
        <tr class="header" align="center">
            <td width="10%"><input class="checkbox" value="chkall" id="chkall" onclick="checkall('delete[]')" type="checkbox" name="chkall"><label for="chkall">删除</label></td>
            <td  width="25%">调用名称</td>
            <td  width="30%">添加时间</td>
            <td  width="15%">调用代码</td>
            <td  width="10%">编辑</td>
        </tr>
        <!--{loop $datacalllist $datacall}-->
        <tr align="center" class="smalltxt">
            <td class="altbg2"><input class="checkbox" type="checkbox" value="{$datacall['id']}" name="delete[]"></td>
            <td  class="altbg2"><strong>{$datacall['title']}</strong></td>
            <td  class="altbg2">{$datacall['time_format']}</td>
            <td class="altbg2"><a href="javascript:jscode($datacall['id'])">获取代码</a></td>
            <td class="altbg2"><a href="index.php?admin_datacall/edit/$datacall['id']{$setting['seo_suffix']}">编辑</a></td>
        </tr>
        <!--{/loop}-->
        <tr><td colspan="5" class="altbg1"><input type="submit" class="btn btn-success" value="提交" /></td></td>
    </table>
</form>
<div id="dialog_js" title="获取js调用代码" style="display: none">
    <table class="table" width="470px">
        <tr>
            <td><textarea rows="2" style="width: 650px;font-size: 12px;" onfocus="this.select()" id="js_link"></textarea></td>
        </tr>
    </table>
</div>
<link rel="stylesheet" type="text/css" href="{SITE_URL}static/js/jquery-ui/jquery-ui.css" />
<script type="text/javascript" src="{SITE_URL}static/js/jquery-ui/jquery-ui.js"></script>
<!--{template footer}-->
<script type="text/javascript">
function jscode(id){
    $("#js_link").html('&lt;script type="text/javascript" src="{SITE_URL}index.php?js/view/' + id + '{$setting['seo_suffix']}" &gt;&lt;/script&gt;');
    $("#dialog_js").dialog({
        autoOpen: false,
        width: 680,
        modal: true,
        resizable: false
    });
    $("#dialog_js").dialog("open");
}
</script>
