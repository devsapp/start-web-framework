<!--{template header}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
  <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;添加新用户</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<table  class="table">
	<tr>
		<td class="{$type}">{$message}</td>
	</tr>
</table>
<!--{/if}-->
<div class="alert alert-warning"><p><b>txt文件编码格式ansi,否则中文无法解析</b></p></div>
<form action="index.php?admin_majia{$setting['seo_suffix']}" method="post" enctype="multipart/form-data">
			<table  class="table">
				<tr class="header">
					<td colspan="2">批量导入马甲--txt文件，一行一个用户名</td>
				</tr>
				<tr>
					<td class="altbg1" width="45%"><b>上传txt文件:</b><br><span class="smalltxt">上传txt用户文件，用户名一行一个</span></td>
					<td class="altbg2"><input type="file" name="txtfile" accept="text/plain"></td>
				</tr>
				<tr>
					<td class="altbg1" width="45%"><b>密码方案:</b><br><span class="smalltxt">随机密码(6位数)，还是手动设置</span></td>
					<td class="altbg2">
						<input class="radio"  type="radio" checked value="1" name="autopwd"><label for="majia">随机6位数密码</label>&nbsp;&nbsp;&nbsp;
						<input class="radio"   type="radio"  value="0" name="autopwd"><label for="majia">手动生成</label>
					</td>
				</tr>
				<tr>
					<td class="altbg1" width="45%"><b>自定义密码:</b><br><span class="smalltxt">如果填写此项表示用你设置的密码，密码不低于6位数</span></td>
					<td class="altbg2"><input type="text" name="addpassword" placeholder="默认留空"></td>
				</tr>
			</table>
			<br />
			<p style="text-align:center">导入的用户名长度超过30会被截取，中文最长10个汉字</p>
			<center><input type="submit" class="button" name="submit" value="提 交"></center><br>
		</form>
<br />
<!--{template footer}-->