<!--{template header}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
  <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;时间设置</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<table class="table">
	<tr>
		<td class="{$type}">{$message}</td>
	</tr>
</table>
<!--{/if}-->
<form action="index.php?admin_setting/time{$setting['seo_suffix']}" method="post">
	<table class="table">
		<tr>
			<td class="altbg1" width="45%"><b>时区设置:</b><br><span class="smalltxt">设置网站的的默认时区</span></td>
			<td class="altbg2">
					<select name="time_offset"  class="form-control shortinput">
					<!--{loop $timeoffset $key $value}-->
						<option value="{$key}" <!--{if $key==$setting['time_offset']}--> selected <!--{/if}--> >{$value}</option>
					<!--{/loop}-->
					</select>
		    </td>
		</tr>
		<tr>
			<td class="altbg1" width="45%"><b>本地时间与服务器的时间差:</b><br><span class="smalltxt">时间差(分钟)，例如本地 8:00 服务器 8:10，则填写-10</span></td>
			<td class="altbg2"><input class="form-control shortinput" value="{$setting['time_diff']}" name="time_diff"></td>
		</tr>

		<tr>
			<td class="altbg1" width="45%"><b>日期格式:</b><br><span class="smalltxt">选择合适的日期格式显示</span></td>
			<td class="altbg2">
                  	<select name="date_format"  class="form-control shortinput">
                  		<option value=""  <!--{if $setting['date_format']==""}--> selected <!--{/if}-->  >{eval  echo date("Y-n-j");}  Y-n-j</option>
                  		<option value="Y/m/d" <!--{if $setting['date_format']=="Y/m/d"}-->selected<!--{/if}-->  >{eval  echo date("Y/m/d");} (Y/M/D)</option>
						<option value="m/d/Y" <!--{if $setting['date_format']=="m/d/Y"}-->selected<!--{/if}-->  >{eval  echo date("m/d/Y");} (M/D/Y)</option>
						<option value="d/m/Y" <!--{if $setting['date_format']=="d/m/Y"}-->selected<!--{/if}-->>{eval  echo date("d/m/Y");} (D/M/Y)</option>
						<option value="m/d" <!--{if $setting['date_format']=="m/d"}-->selected<!--{/if}-->>{eval  echo date("m/d");} (M/D)</option>
						<option value="d/m" <!--{if $setting['date_format']=="d/m"}-->selected<!--{/if}-->>{eval  echo date("d/m");} (D/M)</option>
						<option value="Y.m.d" <!--{if $setting['date_format']=="Y.m.d"}-->selected<!--{/if}-->>{eval  echo date("Y.m.d");} (Y.M.D)</option>
						<option value="m.d.Y" <!--{if $setting['date_format']=="m.d.Y"}-->selected<!--{/if}-->>{eval  echo date("m.d.Y");} (M.D.Y)</option>
						<option value="d.m.Y" <!--{if $setting['date_format']=="d.m.Y"}-->selected<!--{/if}-->>{eval  echo date("d.m.Y");} (D.M.Y)</option>
						<option value="m.d" <!--{if $setting['date_format']=="m.d"}-->selected<!--{/if}-->>{eval  echo date("m.d");} (M.D)</option>
						<option value="d.m" <!--{if $setting['date_format']=="d.m"}-->selected<!--{/if}-->>{eval  echo date("d.m");} (D.M)</option>
						<option value="Y-m-d" <!--{if $setting['date_format']=="Y-m-d"}-->selected<!--{/if}-->>{eval  echo date("Y-m-d");} (Y-M-D)</option>
						<option value="m-d-Y" <!--{if $setting['date_format']=="m-d-Y"}-->selected<!--{/if}-->>{eval  echo date("m-d-Y");} (M-D-Y)</option>
						<option value="d-m-Y" <!--{if $setting['date_format']=="d-m-Y"}-->selected<!--{/if}-->>{eval  echo date("d-m-Y");} (D-M-Y)</option>
						<option value="m-d" <!--{if $setting['date_format']=="m-d"}-->selected<!--{/if}-->>{eval  echo date("m-d");}(M-D)</option>
						<option value="d-m" <!--{if $setting['date_format']=="d-m"}-->selected<!--{/if}-->>{eval  echo date("d-m");} (D-M)</option>
						<option value="M d Y" <!--{if $setting['date_format']=="M d Y"}-->selected<!--{/if}-->>{eval  echo date("M d Y");}</option>
						<option value="d M Y" <!--{if $setting['date_format']=="d M Y"}-->selected<!--{/if}-->>{eval  echo date("d M Y");}</option>
						<option value="M d" <!--{if $setting['date_format']=="M d"}-->selected<!--{/if}-->>{eval  echo date("M d");}</option>
						<option value="d M" <!--{if $setting['date_format']=="d M"}-->selected<!--{/if}-->>{eval  echo date("d M");}</option>
						<option value="jS F, Y" <!--{if $setting['date_format']=="jS F, Y"}-->selected<!--{/if}-->>{eval  echo date("jS F, Y");}</option>
						<option value="l, jS F, Y" <!--{if $setting['date_format']=="l, jS F, Y"}-->selected<!--{/if}-->>{eval  echo date("l, jS F, Y");}</option>
						<option value="jS F" <!--{if $setting['date_format']=="jS F"}-->selected<!--{/if}-->>{eval  echo date("jS F");}</option>
						<option value="l, jS F" <!--{if $setting['date_format']=="l, jS F"}-->selected<!--{/if}-->>{eval  echo date("l, jS F");}</option>
                  	</select>
		    </td>
		</tr>
		<tr>
			<td class="altbg1" width="45%"><b>时间格式:</b><br><span class="smalltxt">选择合适的时间格式显示</span></td>
			<td class="altbg2">
                  	<select name="time_format" class="form-control shortinput" >
                  		<option value="" <!--{if $setting['time_format']==""}-->selected<!--{/if}-->>{eval  echo date("H:i");}  H:i</option>
                  		<option value="H:i" <!--{if $setting['time_format']=="H:i"}-->selected<!--{/if}-->>{eval echo date("H:i");}</option>
						<option value="H:i:s" <!--{if $setting['time_format']=="H:i:s"}-->selected<!--{/if}-->>{eval echo date("H:i:s");}</option>
						<option value="g:i a" <!--{if $setting['time_format']=="g:i a"}-->selected<!--{/if}-->>{eval echo date("g:i a");}</option>
						<option value="g:i A" <!--{if $setting['time_format']=="g:i A"}-->selected<!--{/if}-->>{eval echo date("g:i A");}</option>
                  	</select>
		    </td>
		</tr>
		<tr>
			<td class="altbg1" width="45%"><b>人性化时间格式:</b><br><span class="smalltxt">开启之后，系统中的时间将显示以“n分钟前”、“昨天”、“n天前”等形式显示</span></td>
			<td class="altbg2">
				<input class="radio inline"  type="radio"  {if 1==$setting['time_friendly'] }checked{/if}  value="1" name="time_friendly"><label for="yes">是</label>&nbsp;&nbsp;&nbsp;&nbsp;
				<input class="radio inline"  type="radio"  {if 0==$setting['time_friendly'] }checked{/if} value="0" name="time_friendly"><label for="no">否</label></td>
			</td>
		</tr>
	</table>
	<br>
	<center><input type="submit" class="btn btn-info" name="submit" value="提 交"></center><br>
</form>
<br>
<!--{template footer}-->