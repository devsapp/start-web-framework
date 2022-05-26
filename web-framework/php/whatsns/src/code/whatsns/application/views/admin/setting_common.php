<!--{template header}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
  <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;短信设置</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<div class="alert  alert-warning">{$message}</div>
<!--{/if}-->
<div class="alert  alert-success"><a href="https://www.juhe.cn/docs/api/id/54">点击申请聚合短信应用</a>,50元起，3.7分一条，低门槛，实时到。</div>
		<form action="index.php?admin_setting/commonbase{$setting['seo_suffix']}" method="post">
			<table class="table">
				<tr class="header">
					<td colspan="2">常用配置</td>
				</tr>
				<tr>
					<td class="altbg1" width="45%"><b>开启标签自动识别:</b><br><span class="smalltxt">开启后采集功能，提问和发布文章都会自动识别关键词，默认不开启</span></td>

					<td class="altbg2"><input type="checkbox" class=" " {if $setting['c_autotag']} checked {/if} name="c_autotag">开启自动识别</td>

				</tr>

		         <tr>
					<td class="altbg1" width="45%"><b>启用微信语音:</b><br><span class="smalltxt">开启后需要认证的服务号才能生效</span></td>

					<td class="altbg2"><input type="checkbox" class=" " {if $setting['c_wxvoice']} checked {/if} name="c_wxvoice">开启自动识别</td>

				</tr>



			</table>
			<br />
			<center><input type="submit" class="btn btn-success" name="submit" value="提 交"></center><br>
		</form>
<br />

<style>

html,body{
	overflow:scroll;
}
</style>
<!--{template footer}-->