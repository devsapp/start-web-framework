<!--{template header}-->
<SCRIPT src="{SITE_URL}static/js/admin.js" type="text/javascript"></SCRIPT>
<SCRIPT src="{SITE_URL}static/js/calendar.js" type="text/javascript"></SCRIPT>
<div id="append">
</div>
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
  <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;编辑用户信息</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<table class="table">
	<tr>
		<td class="{$type}">{$message}</td>
	</tr>
</table>
<!--{/if}-->
<form action="index.php?admin_user/edit{$setting['seo_suffix']}" method="post">
<input type="hidden" name="uid" value="{$member['uid']}" />
			<table class="table">
				<tr class="header">
					<td colspan="2">用户信息</td>
				</tr>
				<tr>
					<td class="altbg1" width="45%"><b>用户名:</b><br><span class="smalltxt">用户的注册名称，可以修改</span></td>
					<td class="altbg2"><input class="text" value="{$member['username']}" name="username"></td>
				</tr>
					<tr>
					<td class="altbg1" width="45%"><b>真实姓名:</b><br><span class="smalltxt">填写自己真实姓名</span></td>
					<td class="altbg2"><input class="text" name="truename" id="truename"  value="{$member['truename']}"></td>
				</tr>
					<tr>
					<td class="altbg1" width="45%"><b>工作单位:</b><br><span class="smalltxt">在职公司名称</span></td>
					<td class="altbg2"><input class="text"  name="conpanyname" id="conpanyname"  value="{$member['conpanyname']}"></td>
				</tr>
				<tr>
					<td class="altbg1" width="45%"><b>密码:</b><br><span class="smalltxt">用户密码，可以修改</span></td>
					<td class="altbg2"><input class="text" type="password" name="password" value=""></td>
				</tr>
				<tr>
					<td class="altbg1" width="45%"><b>密码确认:</b><br><span class="smalltxt">跟上面密码输入一直</span></td>
					<td class="altbg2"><input class="text" type="password"  name="confirmpw" value=""></td>
				</tr>
				<tr>
					<td class="altbg1" width="45%"><b>邮箱:</b><br><span class="smalltxt">用户电子邮件地址，可以修改</span></td>
					<td class="altbg2"><input class="text"  name="email" value="{$member['email']}" /></td>
				</tr>
				<tr>
					<td class="altbg1" width="45%"><b>用户组:</b><br><span class="smalltxt">用户所在用户组</span></td>
					<td class="altbg2">
						<select name="groupid" onchange="getcredit1()" id="groupid">
							<optgroup label="会员用户组">
							<!--{loop $usergrouplist $group}-->
							<option {if $member['groupid'] == $group['groupid']}selected{/if} value="{$group['groupid']}">{$group['grouptitle']}</option>
							<!--{/loop}-->
							</optgroup>
							<optgroup label="系统用户组">
							<!--{loop $sysgrouplist $group}-->
							<option {if $member['groupid'] == $group['groupid']}selected{/if} value="{$group['groupid']}">{$group['grouptitle']}</option>
							<!--{/loop}-->
							</optgroup>
						</select>
					</td>
				</tr>
				<tr style="display: none">
					<td class="altbg1" width="45%"><b>总积分:</b><br><span class="smalltxt">用户总积分，可以修改</span></td>
					<td class="altbg2"><input class="text"  name="credits" value="{$member['credits']}"></td>
				</tr>
				<tr>
					<td class="altbg1" width="45%"><b>经验值:</b><br><span class="smalltxt">用户经验值，可以修改</span></td>
					<td class="altbg2"><input class="text"  name="credit1" id="credit1" value="{$member['credit1']}" /></td>
				</tr>
				<tr>
					<td class="altbg1" width="45%"><b>财富值:</b><br><span class="smalltxt">用户经财富值,可以修改</span></td>
					<td class="altbg2"><input class="text"  name="credit2" value="{$member['credit2']}" /></td>
				</tr>
					
				<tr>
					<td class="altbg1" width="45%"><b>性别:</b><br><span class="smalltxt">用户性别设置</span></td>
					<td class="altbg2">
						<input class="radio" id="pmcenteryes"  type="radio"  {if $member['gender']}checked{/if} value="1" name="gender"><label for="pmcenteryes">帅哥</label>&nbsp;&nbsp;&nbsp;
						<input class="radio" id="pmcenterno"   type="radio" {if !$member['gender']}checked{/if} value="0" name="gender"><label for="pmcenterno">美女</label>
					</td>
				</tr>
				<tr>
					<td class="altbg1" width="45%"><b>黑名单:</b><br><span class="smalltxt">列入很名单将无法登录网站</span></td>
					<td class="altbg2">
						<input class="radio" id="blackyes"  type="radio"  {if $member['isblack']}checked{/if} value="1" name="isblack"><label for="blackyes">是</label>&nbsp;&nbsp;&nbsp;
						<input class="radio" id="blackno"   type="radio" {if !$member['isblack']}checked{/if} value="0" name="isblack"><label for="blackno">否</label>
					</td>
				</tr>
				<tr>
					<td class="altbg1" width="45%"><b>生日:</b><br><span class="smalltxt">用户出生日期</span></td>
					<td class="altbg2"><input class="text"  name="bday" value="{$member['bday']}" id="timestart"/></td>
				</tr>

				<tr>
					<td class="altbg1" width="45%"><b>联系电话:</b><br><span class="smalltxt">手机、固话都可以</span></td>
					<td class="altbg2"><input class="text"  name="phone" value="{$member['phone']}" /></td>
				</tr>
				<tr>
					<td class="altbg1" width="45%"><b>QQ:</b><br><span class="smalltxt">QQ号码</span></td>
					<td class="altbg2"><input class="text"  name="qq" value="{$member['qq']}" /></td>
				</tr>
				<tr>
					<td class="altbg1" width="45%"><b>MSN:</b><br><span class="smalltxt">MSN账号</span></td>
					<td class="altbg2"><input class="text"  name="msn" value="{$member['msn']}" /></td>
				</tr>
				<tr>
					<td class="altbg1" width="45%"><b>身份介绍</b><br><span class="smalltxt">身份介绍</span></td>
					<td class="altbg2"><textarea class="textarea" cols="50" rows="2" name="introduction">{$member['introduction']}</textarea></td>
				</tr>
				<tr>
					<td class="altbg1" width="45%"><b>个性签名:</b><br><span class="smalltxt">设置个性签名</span></td>
					<td class="altbg2"><textarea class="textarea" cols="50" rows="2" name="signature">{$member['signature']}</textarea></td>
				</tr>
			</table>
			<br />
			<center><input type="submit" class="button" name="submit" value="提 交"></center><br>
		</form>
<br />
<script type="text/javascript">
    function getcredit1(){
        var groupid = $("#groupid").val();
        $.get("{SITE_URL}index.php?admin_user/ajaxgetcredit1/"+groupid,function(credit){
         $("#credit1").val(credit);
        });

    }
</script>
<!--{template footer}-->