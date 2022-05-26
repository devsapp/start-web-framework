<!--{template header}-->

<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
  <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;打赏记录查询</div>
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
	<tbody><tr class="header"><td>提现审核列表&nbsp;&nbsp;&nbsp;</td></tr>

</tbody></table>
	<table class="table">
		<tr class="header" align="center">
		<td  >申请人uid</td>
			<td>申请人</td>

			<td >申请提现金额(元)</td>
			<td >申请时间</td>
			<td >操作</td>

		</tr>
		<!--{loop $tixianlist $tixian}-->
		<tr align="center" class="smalltxt">

					<td  class="altbg2" align="center">{$tixian['uid']}</td>
					<td  class="altbg2" align="center">{$tixian['username']}</td>
					<td  class="altbg2" align="center" style="font-size:20px;">{$tixian['jine']}</td>
					<td  class="altbg2" align="center">{$tixian['time']}</td>

				<td  class="altbg2" align="center">
				<a class="text-danger" href="{SITE_URL}index.php?admin_tixian/view/{$tixian['uid']}{$setting['seo_suffix']}">核对提现记录真实性</a>


				</td>


				</tr>
				<!--{/loop}-->
				   <!--{if $departstr}-->

        <!--{/if}-->
	</table>
   <div class="pages">{$departstr}</div>

<!--{template footer}-->

