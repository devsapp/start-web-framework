<!--{template header}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;关键词内链建设</div>
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
        <tr class="header" ><td>关键词&nbsp;<input type="button" style="cursor:pointer" onclick="document.location.href = 'index.php?admin_keywords/muladd{$setting['seo_suffix']}'" value="批量添加" /></td></tr>

    </tbody>
</table>
<form action="index.php?admin_keywords/editindexkeyword{$setting['seo_suffix']}" method="post">
<label>每个关键词最多替换次数(0表示无限制)</label>
<input type="number" size="60" value="{$setting['maxindex_keywords']}" name="maxindex_keywords">
<label>每篇文章关键词最多替换次数(0表示无限制)</label>
<input type="number" size="60" value="{$setting['pagemaxindex_keywords']}" name="pagemaxindex_keywords">
<input type="submit" name="submit" class="button"  value="设&nbsp;置" />
</form>
<form action="index.php?admin_keywords/add{$setting['seo_suffix']}" method="post" name="wordform">
    <table class="table">
        <tr class="header">
            <td  width="10%"><input class="checkbox" value="chkall" id="chkall" onclick="checkall('id[]')" type="checkbox" name="chkall"><label for="chkall">删除</label></td>
            <td  width="40%">关键词</td>
            <td  width="40%">url</td>
            <td  width="10%">操作者</td>
        </tr>
        <!--{loop $wordlist $word}-->
      

        <tr>
            <td class="altbg2"><input type="checkbox" name="id[]" value="{$word['id']}"/><input type="hidden" name="wid[]" value="{$word['id']}" /></td>
            <td class="altbg2"><input type="text" name="find[]" class="txt" value="{$word['find']}"/></td>
            <td class="altbg2"><input type="text" name="replacement[]" class="txt" value="{$word['replacement']}" /></td>
            <td class="altbg2">{$word['admin']}</td>
        </tr>
        <!--{/loop}-->
        <tr>
            <td class="altbg2">&nbsp;<input type="hidden" name="wid[]" value="0" /></td>
            <td class="altbg2"> <input type="text" name="find[]" class="txt" /></td>
            <td class="altbg2"><input type="text" name="replacement[]" class="txt"  /></td>
            <td class="altbg2">&nbsp;</td>
        </tr>
        <tr class="altbg1"><td colspan="4" class="altbg1"  align="left"><input type="submit" name="submit" class="button"  value="操作" title="删除，更新，添加" /></td></tr>
        <!--{if $departstr}-->
        <tr class="smalltxt">
            <td class="altbg2" colspan="4" align="right"><div class="pages">{$departstr}</div></td>
        </tr>
        <!--{/if}-->
    </table>
</form>
<br>
<!--{template footer}-->
