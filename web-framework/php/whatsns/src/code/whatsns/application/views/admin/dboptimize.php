<!--{template header}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
  <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;数据库优化</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->

<table class="table">
	<tr>
		<td class="{$type}">{$message}</td>
	</tr>
</table>
<!--{/if}-->
<a class="btn btn-success" href="{url admin_db/databaseoptimize}">数据库优化</a>
	<table class="table">
		<tr class="header">
			<td colspan="7">数据库优化</td>
		</tr>
		<tr class="smalltxt">
			<td width="10%" class="altbg1">数据表</td>
			<td width="10%" class="altbg1">数据表类型</td>
			<td width="10%" class="altbg1">记录数</td>
			<td width="20%" class="altbg1">数据</td>
			<td width="20%" class="altbg1">碎片</td>
			<td width="20%" class="altbg1">字符集</td>
			<td width="10%" class="altbg1">状态</td>
		</tr>
		<!--{loop $tablelist $key $value}-->
		<tr>
			<td class="altbg2">{$value['table']}</td>
			<td class="altbg2">{$value['type']}</td>
			<td class="altbg2">{$value['rec_num']}</td>
			<td class="altbg2">{$value['rec_index']}</td>
			<td class="altbg2">{$value['rec_chip']}</td>
			<td class="altbg2">{$value['chartset']}</td>
			<td class="altbg2">{$value['status']}</td>
		</tr>
		<!--{/loop}-->
		<tr><td class="altbg1" align="left" colspan="7">
			<input type="button" class="btn" value="开始进行数据表优化" name="opsubmit" onclick="javascript:window.location='index.php?admin_db/optimize'" />&nbsp;&nbsp;&nbsp;
			<input type="button" class="btn" value="开始进行数据表修复" name="resubmit" onclick="javascript:window.location='index.php?admin_db/repair'" />
		</td></tr>
	</table>
<br>
<!--{template footer}-->
