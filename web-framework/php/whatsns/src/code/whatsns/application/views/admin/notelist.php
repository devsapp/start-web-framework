<!--{template header}-->
<script src="{SITE_URL}static/js/admin.js" type="text/javascript"></script>
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;公告管理</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<div class="alert  alert-warning">{$message}</div>
<!--{/if}-->
<form onsubmit="return confirm('该操作不可恢复，您确认要删除这些公告吗？');"  action="index.php?admin_note/remove{$setting['seo_suffix']}"  method=post>
    <table class="table" >
        <tr class="header"><td colspan="5">公告列表&nbsp;&nbsp;&nbsp;<input type="button" style="cursor:pointer" onclick="document.location.href = 'index.php?admin_note/add{$setting['seo_suffix']}'" value="添加公告" /></td></tr>
        <tr class="header" align="center">
            <td width="5%"><input class="checkbox" value="chkall" id="chkall" onclick="checkall('delete[]')" type="checkbox" name="chkall"><label for="chkall">&nbsp;删除</label></td>
            <td  width="25%">公告标题</td>
            <td  width="30%">发布人</td>
            <td  width="15%">发布时间</td>
            <td  width="10%">编辑</td>
        </tr>
        <!--{loop $notelist $note}-->
        <tr align="center" class="smalltxt">
            <td class="altbg2">&nbsp;<input class="checkbox" type="checkbox" value="{$note['id']}" name="delete[]"></td>
            <td  class="altbg2"><strong>{$note['title']}</strong></td>
            <td  class="altbg2">{$note['author']}</td>
            <td class="altbg2">{$note['format_time']}</td>
            <td class="altbg2"><a href="index.php?admin_note/edit/$note['id']{$setting['seo_suffix']}">编辑</a></td>
        </tr>
        <!--{/loop}-->
        <!--{if $departstr}-->
        <tr class="smalltxt">
            <td class="altbg2" colspan="5" align="right"><div class="scott">{$departstr}</div></td>
        </tr>
        <!--{/if}-->
        <tr><td colspan="5" class="altbg1"><input type="submit" class="button" value="提交" /></td></td>
    </table>
</form>
<!--{template footer}-->
