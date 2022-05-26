<!--{template header}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
  <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;批量添加词语过滤</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<table class="table">
	<tr>
		<td class="{$type}">{$message}</td>
	</tr>
</table>
<!--{/if}-->
<form name="askform" action="index.php?admin_word/muladd{$setting['seo_suffix']}" method="post">
<table class="table">
	<tr class="header">
		<td colspan="2">参数设置</td>
	</tr>
	<tr>
		<td class="altbg1" width="45%"><b>词语过滤:</b><br><span class="smalltxt">每行一组过滤词语，不良词语和替换词语之间使用“=”进行分割,例如:sexword={<?php echo 'BANNED';?>}</span></td>
		<td class="altbg2"><textarea class="area" name="badwords"  style="height:300px;width:280px;" ></textarea></td>
	</tr>
</table>
<br />
<center><input type="submit" class="button" name="submit" value="提 交"></center><br>
</form>
<br />
<!--{template footer}-->