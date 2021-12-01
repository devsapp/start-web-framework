<!--{template header}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
  <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;批量添加词语过滤</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<table cellspacing="1" cellpadding="4" width="100%" align="center" class="tableborder">
	<tr>
		<td class="{$type}">{$message}</td>
	</tr>
</table>
<!--{/if}-->
<form name="askform" action="index.php?admin_keywords/muladd{$setting['seo_suffix']}" method="post">
<table class="table">
	<tr class="header">
		<td colspan="2">参数设置</td>
	</tr>
	<tr>
		<td class="altbg1" width="45%"><b>键值对:</b><br><span class="smalltxt">每行一组关键词，关键词和超链接之间使用“=”进行分割,例如:百度=http://www.baidu.com</span></td>
		<td class="altbg2"><textarea class="area" id="badwords" name="badwords"  style="height:300px;width:580px;" ></textarea></td>
	</tr>
</table>
<br />
<center><input type="submit" class="button" name="submit" value="提 交"></center><br>
</form>
<br />
<!--{template footer}-->