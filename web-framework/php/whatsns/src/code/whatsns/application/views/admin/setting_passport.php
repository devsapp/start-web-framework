<!--{template header}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
  <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;通行证整合</div>
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
	<tr class="altbg1"><td>通行证是为解决多个系统之间用户整合问题而开发的,是一套跨服务器，跨域名，跨语言的会员共享系统，实现了不同系统之间用户整合，支持不同域名下同步登录，同步退出功能。</td></tr>
</tbody></table>
<br />
<form action="index.php?admin_setting/passport{$setting['seo_suffix']}" method="post">
	<a name="基本设置"></a>
	<table class="table">
		<tr class="header">
			<td colspan="2">参数设置</td>
		</tr>
		<tr>
			<td class="altbg1" width="45%"><b>通行证:</b><br><span class="smalltxt">关闭状态则通行证则不和其它系统整合，但是设置还会保留。</span></td>
			<td class="altbg2">
					<input class="radio"  type="radio"  {if 1==$setting['passport_open'] }checked{/if}  value="1" name="passport_open" ><label for="yes">开启</label>
					<input class="radio"  type="radio"  {if 0==$setting['passport_open'] }checked{/if} value="0" name="passport_open" ><label for="no">关闭</label>
			</td>
		</tr>
		<tr>
			<td class="altbg1" width="45%"><b>通行证私有密钥:</b><br><span class="smalltxt">私有密钥请注意保密，这个整合后是用来加密的key。</span></td>
			<td class="altbg2"><input type="text" value="{$setting['passport_key']}" name="passport_key" style="width:332px;"></td>
		</tr>
		<tr>
			<td class="altbg1" width="45%"><b>将本系统作为:</b><br><span class="smalltxt">服务器端则整合是以本系统为主。客户端是以其它系统为主。</span></td>
			<td class="altbg2">
					<input class="radio"  type="radio"  {if 1==$setting['passport_type'] }checked{/if}  value="1" name="passport_type" onclick="javascript:$('#hidden1').style.display = '';$('#hidden2').style.display = 'none';"><label for="yes">服务器端</label>&nbsp;
					<input class="radio"  type="radio"  {if 0==$setting['passport_type'] }checked{/if} value="0" name="passport_type" onclick="javascript:$('#hidden1').style.display = 'none';$('#hidden2').style.display = '';"><label for="no">客户端</label>
			</td>
		</tr>
		<tbody id="hidden1" {if 0==$setting['passport_type'] } style="DISPLAY: none" {/if} >
		<tr>
			<td class="altbg1" width="45%"><b>客户端地址:</b><br><span class="smalltxt">客户端系统的url地址</span></td>
			<td class="altbg2"><input type="text" value="{$setting['passport_client']}" name="passport_client" style="width:332px;"></td>
		</tr>
		</tbody>
		<tbody id="hidden2" {if 1==$setting['passport_type'] } style="DISPLAY: none" {/if} >
		<tr>
			<td class="altbg1" width="45%"><b>服务器地址:</b><br><span class="smalltxt">通行证的服务器地址.</span></td>
			<td class="altbg2"><input type="text" value="{$setting['passport_server']}" name="passport_server" style="width:332px;"></td>
		</tr>
		<tr>
			<td class="altbg1" width="45%"><b>登录地址:</b><br><span class="smalltxt">通行证的登录地址</span></td>
			<td class="altbg2"><input type="text" value="{$setting['passport_login']}" name="passport_login" style="width:332px;"></td>
		</tr>
        <tr>
            <td class="altbg1" width="45%"><b>退出地址:</b><br><span class="smalltxt">通行证的退出地址</span></td>
            <td class="altbg2"><input type="text" value="{$setting['passport_logout']}" name="passport_logout" style="width:332px;"></td>
        </tr>
		<tr>
			<td class="altbg1" width="45%"><b>注册地址:</b><br><span class="smalltxt">通行证的注册地址</span></td>
			<td class="altbg2"><input type="text" value="{$setting['passport_register']}" name="passport_register" style="width:332px;"></td>
		</tr>
		<tr>
			<td class="altbg1" width="45%"><b>验证字串有效期(秒):</b><br><span class="smalltxt">建议设置为 3600，既可保证安全又可避免因不同服务器间时间差而产生无法登录的问题。</span></td>
			<td class="altbg2"><input type="text" value="{$setting['passport_expire']}" name="passport_expire" style="width:332px;"></td>
		</tr>
		<tr>
			<td class="altbg1" width="45%"><b>积分同步:</b><br><span class="smalltxt">其选择需要同步的积分。</span></td>
			<td class="altbg2">
				<input name="passport_credit1" value="1" {if 1==$setting['passport_credit1'] }checked{/if}  type="checkbox">经验值&nbsp;
				<input name="passport_credit2" value="1" {if 1==$setting['passport_credit2'] }checked{/if}  type="checkbox">财富值
			</td>
		</tr>
		</tbody>
	</table>
	<br>
	<center><input type="submit" class="btn btn-success" name="submit" value="提 交"></center><br>
</form>
<br>
<!--{template footer}-->