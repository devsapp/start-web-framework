<!--{template header}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
  <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;收入分成规则</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<div class="alert  alert-warning">{$message}</div>
<!--{/if}-->

		<form action="{SITE_URL}index.php?admin_weixin/ticheng{$setting['seo_suffix']}" method="post">
			<table class="table">
				<tr class="header">
					<td colspan="2">分成参数设置</td>
				</tr>
						<tr>
					<td class="altbg1" width="45%"><b>分享文章和问题到朋友圈分成:</b><br><span class="smalltxt">单位元，网友分享后可获得设置的分成金额，鼓励用户分享。</span></td>
					<td class="altbg2"><input class="form-control shortinput" type="text" value="{$setting['weixin_share_fencheng']}" name="weixin_share_fencheng" /></td>
				</tr>
					<tr>
					<td class="altbg1" width="45%"><b>最佳答案平台分成:</b><br><span class="smalltxt">输入0.01-1之间数字，0.01表示一个点手续费。如果提问者选择最佳（满意）解答的，提问者支付的赏金向平台支付一定比例费用后全部归解答者所有；若提问者没有选最佳解答的，则赏金归平台所有。</span></td>
					<td class="altbg2"><input class="form-control shortinput" type="text" value="{$setting['weixin_fenceng_zuijia']}" name="weixin_fenceng_zuijia" /></td>
				</tr>
					<tr>
					<td class="altbg1" width="45%"><b>行家解答分成:</b><br><span class="smalltxt">输入0.01-1之间数字，0.01表示一个点手续费，提问者支付的赏金向平台支付一定比例费用后全部归解答者所有。</span></td>
					<td class="altbg2"><input class="form-control shortinput" type="text" value="{$setting['weixin_fenceng_hangjia']}" name="weixin_fenceng_hangjia" /></td>
				</tr>
					<tr>
					<td class="altbg1" width="45%"><b>收费偷听平台分成:</b><br><span class="smalltxt">输入0.01-1之间数字，0.01表示提问者会收到1%的收入，<strong>保证偷听赏金=平台分成+提问者分成+回答者分成=1</strong>，收听者支付的费用向平台支付一定比例费用后由提问者和解答者按比例分成。</span></td>
					<td class="altbg2"><input class="form-control shortinput" type="text" value="{$setting['weixin_fenceng_toutingpingtai']}" name="weixin_fenceng_toutingpingtai" /></td>
				</tr>
					<tr>
					<td class="altbg1" width="45%"><b>收费偷听提问者分成:</b><br><span class="smalltxt">输入0.01-1之间数字，0.01表示提问者会收到1%的收入，<strong>保证偷听赏金=平台分成+提问者分成+回答者分成=1</strong></span></td>
					<td class="altbg2"><input class="form-control shortinput" type="text" value="{$setting['weixin_fenceng_toutingtiwen']}" name="weixin_fenceng_toutingtiwen" /></td>
				</tr>
					<tr>
					<td class="altbg1" width="45%"><b>收费偷听回答者分成:</b><br><span class="smalltxt">输入0.01-1之间数字，0.01表示提问者会收到1%的收入，<strong>保证偷听赏金=平台分成+提问者分成+回答者分成=1</strong></span></td>
					<td class="altbg2"><input class="form-control shortinput" type="text" value="{$setting['weixin_fenceng_toutinghuida']}" name="weixin_fenceng_toutinghuida" /></td>
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