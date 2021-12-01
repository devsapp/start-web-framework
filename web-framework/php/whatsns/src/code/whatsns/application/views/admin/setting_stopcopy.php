<!--{template header}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
  <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;防采集设置</div>
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
	<tbody><tr class="header"><td>设置说明</td></tr>
	<tr class="altbg1"><td>允许/禁止的 UserAgent  只需填写 UserAgent  的关键单词，每行填写一个，例如  Firefox/3.6.3</td></tr>
</tbody></table>
<br />
<form action="index.php?admin_setting/stopcopy{$setting['seo_suffix']}" method="post">
	<a name="基本设置"></a>
	<table cellspacing="1" cellpadding="4" width="100%" align="center" class="tableborder">
		<tr class="header">
			<td colspan="2">参数设置</td>
		</tr>
		<tr>
			<td class="altbg1" width="45%"><b>开启防采集:</b><br><span class="smalltxt">开启后会降低系统性能</span></td>
			<td class="altbg2">
					<input class="radio"  type="radio"  {if 1==$setting['stopcopy_on'] }checked{/if}  value="1" name="stopcopy_on"><label for="yes">是</label>&nbsp;&nbsp;
					<input class="radio"  type="radio"  {if 0==$setting['stopcopy_on'] }checked{/if} value="0" name="stopcopy_on"><label for="no">否</label>
			</td>
		</tr>
		<tr>
			<td class="altbg1" width="45%"><b>允许的 UserAgent 关键词:</b><br><span class="smalltxt">这类访问不会被禁止</span></td>
			<td class="altbg2"><textarea cols="30" rows="10" class="area" name="stopcopy_allowagent">{$setting['stopcopy_allowagent']}</textarea></td>
		</tr>
		<tr>
			<td class="altbg1" width="45%"><b>禁止的 UserAgent 关键词:</b><br><span class="smalltxt">这类访问会被禁止</span></td>
			<td class="altbg2"><textarea cols="30" rows="10" class="area" name="stopcopy_stopagent">{$setting['stopcopy_stopagent']}</textarea></td>
		</tr>
		<tr>
			<td class="altbg1" width="45%"><b>每分钟访问关键页面最大数目（页）:</b><br><span class="smalltxt">超过这个数目，访问会自动被禁止</span></td>
			<td class="altbg2"><input type="text" value="{$setting['stopcopy_maxnum']}" name="stopcopy_maxnum" /></td>
		</tr>
	</table>
	<br>
	<center><input type="submit" class="btn btn-success" name="submit" value="提 交"></center><br>
</form>
<br>
<!--{template footer}-->