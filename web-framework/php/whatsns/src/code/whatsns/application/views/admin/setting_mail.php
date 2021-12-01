<!--{template header}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
  <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;邮件设置</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<div class="alert  alert-warning">{$message}</div>
<!--{/if}-->
		<form action="index.php?admin_setting/mail{$setting['seo_suffix']}" method="post">
			<table class="table">
				<tr class="header">
					<td colspan="2">参数设置</td>
				</tr>
				<tr>
					<td class="altbg1" width="45%"><b>邮件来源地址:</b><br><span class="smalltxt">当发送邮件不指定邮件来源时，默认使用此地址作为邮件来源</span></td>
					<td class="altbg2"><input class="form-control shortinput" type="text" value="{$setting['maildefault']}" name="maildefault" /></td>
				</tr>

				<tbody >
				<tr>
					<td class="altbg1" width="45%"><b>SMTP 服务器:</b><br><span class="smalltxt">设置 SMTP 服务器的地址</span></td>
					<td class="altbg2"><input class="form-control shortinput" type="text" value="{$setting['mailserver']}" name="mailserver" /></td>
				</tr>
				<tr>
					<td class="altbg1" width="45%"><b>SMTP 端口:</b><br><span class="smalltxt">设置 SMTP 服务器的端口，默认为 25</span></td>
					<td class="altbg2"><input class="form-control shortinput" value="{$setting['mailport']}" name="mailport"></td>
				</tr>




				<tr>
					<td class="altbg1" width="45%"><b>发信人邮件地址:</b><br><span class="smalltxt"></span></td>
					<td class="altbg2"><input class="form-control shortinput" type="text" value="{$setting['mailfrom']}" name="mailfrom" /></td>
				</tr>
				<tr>
					<td class="altbg1" width="45%"><b>SMTP 身份验证用户名:</b><br><span class="smalltxt">SMTP的身份验证用户名</span></td>
					<td class="altbg2"><input class="form-control shortinput" type="text" value="{$setting['mailauth_username']}" name="mailauth_username"></td>
				</tr>
				<tr>
					<td class="altbg1" width="45%"><b>SMTP 身份验证密码:</b><br><span class="smalltxt">SMTP的身份验证密码</span></td>
					<td class="altbg2"><input class="form-control shortinput" type="password" value="{$setting['mailauth_password']}" name="mailauth_password" /></td>
				</tr>
				</tbody>



			</table>
			<br />
			<center><input type="submit" class="btn btn-success" name="submit" value="提 交"></center><br>
		</form>
<br />
<hr >
<h4>测试邮件发送</h4>
<form class="form-horizontal" role="form" method="post" action="index.php?admin_setting/testmail{$setting['seo_suffix']}">
<div class="form-group">
          <label class="col-md-2 control-label">写给谁</label>
          <div class="col-md-4">
             <input type="text" name="tousername" id="tousername" value="" placeholder="好友昵称或者名字" class="form-control">
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">对方邮件</label>
          <div class="col-md-4">
             <input type="text" name="toemail" id="toemail" value="" placeholder="比如 163,sina,qq,139,gmail邮箱" class="form-control">
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">主题</label>
          <div class="col-md-4">
             <input type="text" name="subject" id="subject" value="" placeholder="对Ta说点什么" class="form-control">
          </div>
        </div>
          <div class="form-group">
          <label class="col-md-2 control-label">正文内容</label>
          <div class="col-md-4">
            <textarea name="message" id="message" rows="2" placeholder="详细说明下你对Ta想说的话"  class="form-control"></textarea>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-offset-2 col-md-10">
             <input type="submit" name="submit" id="submit" class="btn btn-danger" value="保存" data-loading="稍候..."> <input type="hidden" name="type" id="type" value="article">
          </div>
        </div>
</form>
<style>

html,body{
	overflow:scroll;
}
</style>
<!--{template footer}-->