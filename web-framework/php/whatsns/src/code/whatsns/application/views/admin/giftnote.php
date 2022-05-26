<!--{template header}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
  <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;礼品公告</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<table class="table">
	<tr>
		<td class="{$type}">{$message}</td>
	</tr>
</table>
<!--{/if}-->
		<form action="index.php?admin_gift/note{$setting['seo_suffix']}" method="post" enctype="multipart/form-data">
			<table class="table">
				<tr class="header"><td colspan="2">参数设置</td></tr>
				<tr>
					<td class="altbg1" width="45%"><b>礼品公告:</b><br><span class="smalltxt">礼品商店模块公告</span></td>
					<td class="altbg2"><textarea class="area" name="note"  style="height:100px;width:300px;">{if isset($setting['gift_note'])}{$setting['gift_note']}{/if}</textarea></td>
				</tr>
			</table>
			<br />
			<center><input type="submit" class="button" name="submit" value="提 交"></center><br>
		</form>
<br />
<!--{template footer}-->