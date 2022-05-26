<!--{template header}-->
<script type="text/javascript">
        g_site_url='{SITE_URL}';
</script>
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
  <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;sql调用</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<table class="table">
	<tr>
		<td class="{$type}">{$message}</td>
	</tr>
</table>
<!--{/if}-->
<form action="index.php?admin_db/sqlwindow" method="post" target="sqlfrm">
	<table  class="table">
		<tr class="header">	<td>sql调用</td><span class="smalltxt">在下面窗口中输入sql语句 （数据表前缀为：ask_ ）</span></tr>
		<tr class="altbg2"><td>
		<textarea name="sqlwindow" cols="120" rows="12">{$sql}</textarea><br />
		<input name="sqltype" type="radio" class="radio" value="0" checked="checked"/>单行SQL（支持简单查询）<input name="sqltype" class="radio" type="radio" class="m-l10" value="1"/> 多行SQL

		</td></tr>
		<tr><td class="altbg1" align="left" ><input name="sqlsubmit" type="submit" value="执 行" class="btn" /></td></tr>
	</table>
</form>
<table class="table">
<tr class="header"><td>执行结果显示窗口:</td></tr>
</table>
<p><iframe name="sqlfrm" frameborder="0" id="sqlfrm" width="100%"  height="600" style= "border:1px solid #d3e8fd"></iframe></p>

<!--{template footer}-->