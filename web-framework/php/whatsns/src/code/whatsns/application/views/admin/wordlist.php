<!--{template header}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;词语过滤</div>
</div>
<!--{if $message}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<table class="table">
    <tr>
        <td class="{$type}">{$message}</td>
    </tr>
</table>
<!--{/if}-->
<table class="table">
    <tbody>
        <tr class="header" ><td>词语过滤&nbsp;<input type="button" style="cursor:pointer" onclick="document.location.href = 'index.php?admin_word/muladd{$setting['seo_suffix']}'" value="批量添加" /></td></tr>
        <tr class="altbg1"><td>1、替换前的内容可以使用限定符 {<?php echo 'x';?>} 以限定相邻两字符间可忽略的文字，x 是忽略字符的个数。如 "a{1}s{2}s"(不含引号) 可以过滤 "ass" 也可过滤 "axsxs" 和 "axsxxs" 等等。<br />
                2、如需禁止发布包含某个词语的文字，而不是替换过滤，请将其对应的替换内容设置为{<?php echo 'BANNED';?>}即可；<br />3、如需当用户发布包含某个词语的文字时，自动标记为需要人工审核，而不直接显示或替换过滤，请将其对应的替换内容设置为{<?php echo'MOD';?>}即可。</td></tr>
    </tbody>
</table>

<form action="index.php?admin_word/add{$setting['seo_suffix']}" method="post" name="wordform">
    <table class="table">
        <tr class="header">
            <td  width="10%"><input class="checkbox" value="chkall" id="chkall" onclick="checkall('id[]')" type="checkbox" name="chkall"><label for="chkall">删除</label></td>
            <td  width="40%">不良词语</td>
            <td  width="40%">替换为</td>
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
        <tr class="altbg1"><td colspan="4" class="altbg1"  align="left"><input type="submit" name="submit" class="button"  value="操作"  title="删除，更新，添加" /></td></tr>
        <!--{if $departstr}-->
        <tr class="smalltxt">
            <td class="altbg2" colspan="4" align="right"><div class="pages">{$departstr}</div></td>
        </tr>
        <!--{/if}-->
    </table>
</form>
<br>
<!--{template footer}-->
