<!--{template header}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
  <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;短信设置</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<div class="alert  alert-warning">{$message}</div>
<!--{/if}-->
<form action="{SITE_URL}index.php?admin_sms/set{$setting['seo_suffix']}" method="post">
			
   <table class="table">
        <tr class="header">
            <td colspan="2">参数设置</td>
        </tr>
        <tr>
            <td class="altbg1" width="45%"><b>当前短信应用平台:</b><br><span class="smalltxt">必须选择当前应用的短信平台，否则网站无法使用短信服务</span></td>
            <td class="altbg2">
                <input class="radio inline"  type="radio"  {if 'aliyun'==$setting['allow_smsplatform'] }checked{/if}  value="aliyun" name="allow_smsplatform"><label for="yes">阿里云</label>&nbsp;&nbsp;&nbsp;&nbsp;
                <input class="radio inline"  type="radio"  {if 'juhe'==$setting['allow_smsplatform'] }checked{/if} value="juhe" name="allow_smsplatform"><label for="no">聚合</label></td>
        </tr>
        	<tr>
					<td class="altbg1" width="45%"><b>前端启用短信验证码:</b><br><span class="smalltxt">开启后可用于注册和找回密码服务</span></td>
					<td class="altbg2"><input type="checkbox" class=" " {if isset($setting['smscanuse'])&&$setting['smscanuse']==1} checked {/if} name="smscanuse">启用手机验证码</td>
				</tr>
</table>
<br />
			<center><input type="submit" class="btn btn-primary" style="background:#3280fc" name="submit" value="提 交"></center><br>
		</form>
<ul class="nav nav-tabs" id="myTab">
  <li class="active"><a href="#home">阿里云短信配置</a></li>
  <li><a href="#profile">聚合短信配置</a></li>

</ul>

<div class="tab-content">
  <div class="tab-pane active" id="home">
<!-- 阿里云短信配置 -->

<div class="alert  alert-success"><a target="_blank" href="https://www.ask2.cn/article-15599.html">点击查看阿里云短信短信接入方法</a>,价格合适，稳定，个人可以申请。</div>
		<h1>阿里云短信配置{if PHP_VERSION<5.6}--【您当前php版本为{PHP_VERSION}，阿里云SDK短信最低环境要求5.6+{/if}】</h1>
		<form action="{SITE_URL}index.php?admin_sms/index{$setting['seo_suffix']}" method="post">
			
			<table class="table">
				<tr class="header">
					<td colspan="2">短信参数设置</td>
				</tr>
					<tbody >
				<tr>
					<td class="altbg1" width="45%"><b>accessKeyId:</b><br><span class="smalltxt"><a target="_blank" href="https://usercenter.console.aliyun.com/?spm=5176.12207334.0.0.6b6a1cbesyzRaT#/manage/ak">点击去复制AccessKey ID(需登录阿里云)</a></span></td>
					<td class="altbg2"><input {if PHP_VERSION<5.6} disabled{/if} class="form-control shortinput" type="text" value="{if isset($setting['aliyunsmskey'])}$setting['aliyunsmskey']{/if}" name="aliyunsmskey" /></td>
				</tr>

				<tr>
					<td class="altbg1" width="45%"><b>accessSecret:</b><br><span class="smalltxt"><a target="_blank" href="https://usercenter.console.aliyun.com/?spm=5176.12207334.0.0.6b6a1cbesyzRaT#/manage/ak">点击去复制Access Key Secret(需登录阿里云)</a></span></td>
					<td class="altbg2"><input {if PHP_VERSION<5.6} disabled{/if} class="form-control shortinput" type="text" value="{if isset($setting['aliyunsmsaccessSecret'])}$setting['aliyunsmsaccessSecret']{/if}" name="aliyunsmsaccessSecret" /></td>
				</tr>
				<tr>
					<td class="altbg1" width="45%"><b>注册页面短信验证码模板id:</b><br><span class="smalltxt">查看教程去申请注册验证码类型短信模板</span></td>
					<td class="altbg2"><input {if PHP_VERSION<5.6} disabled{/if} class="form-control shortinput" type="text" value="{if isset($setting['aliyunsmsregtmpid'])}$setting['aliyunsmsregtmpid']{/if}" name="aliyunsmsregtmpid" /></td>
				</tr>
				<tr>
					<td class="altbg1" width="45%"><b>找回密码页面短信验证码模板id:</b><br><span class="smalltxt">查看教程去申请找回密码验证码类型短信模板</span></td>
					<td class="altbg2"><input {if PHP_VERSION<5.6} disabled{/if} class="form-control shortinput" type="text" value="{if isset($setting['aliyunsmsfindpwdtmpid'])}$setting['aliyunsmsfindpwdtmpid']{/if}" name="aliyunsmsfindpwdtmpid" /></td>
				</tr>				
	             <tr>
					<td class="altbg1" width="45%"><b>短信签名:</b><br><span class="smalltxt">查看教程去复制签名，签名需要审核通过才能用</span></td>
					<td class="altbg2"><input {if PHP_VERSION<5.6} disabled{/if} class="form-control shortinput" type="text" value="{if isset($setting['aliyunsmssign'])}$setting['aliyunsmssign']{/if}" name="aliyunsmssign" /></td>
				</tr>



				</tbody>



			</table>
			<br />
			{if PHP_VERSION<5.6}
			<center><input disabled class="btn btn-success" value="版本过低(需php5.6+)"></center><br>
		
			{else}
			<center><input type="submit" class="btn btn-success" name="submit" value="提 交"></center><br>
		
			{/if}
			
		</form>
<br />
<hr >
<h4>阿里云短信--注册页面验证码发送测试</h4>
<form class="form-horizontal" role="form" method="post" action="{SITE_URL}index.php?admin_sms/testaliyunsms{$setting['seo_suffix']}">
<div class="form-group">
          <label class="col-md-2 control-label">对方手机号码</label>
          <div class="col-md-4">
             <input type="text" name="userphone" id="userphone" value="" placeholder="测试人手机号码，用于接收短信" class="form-control">
          </div>
        </div>

        <div class="form-group">
          <div class="col-md-offset-2 col-md-10">
             <input type="submit" name="submit" id="submit" class="btn btn-danger" value="发送测试" data-loading="稍候...">
          </div>
        </div>
</form>
<hr>
<h4>阿里云短信--找回密码页面验证码发送测试</h4>
<form class="form-horizontal" role="form" method="post" action="{SITE_URL}index.php?admin_sms/testfindpwdaliyunsms{$setting['seo_suffix']}">
<div class="form-group">
          <label class="col-md-2 control-label">对方手机号码</label>
          <div class="col-md-4">
             <input type="text" name="finduserphone" id="finduserphone" value="" placeholder="测试人手机号码，用于接收短信" class="form-control">
          </div>
        </div>

        <div class="form-group">
          <div class="col-md-offset-2 col-md-10">
             <input type="submit" name="submit" id="submit" class="btn btn-danger" value="找回密码接口发送测试" data-loading="稍候...">
          </div>
        </div>
</form>
<!-- 阿里云短信配置 end -->
</div>
<!-- 聚合短信配置 -->
  <div class="tab-pane" id="profile">


<div class="alert  alert-success"><a href="https://www.ask2.cn/article-14573.html">点击查看聚合短信接入方法</a>,申请简单，充值门槛高，需企业资质，个人慎用。</div>
		<h1>聚合短信配置</h1>
		<form action="{SITE_URL}index.php?admin_sms/sms{$setting['seo_suffix']}" method="post">
			<table class="table">
				<tr class="header">
					<td colspan="2">短信参数设置</td>
				</tr>
				<tr>
					<td class="altbg1" width="45%"><b>短信验证码key:</b><br><span class="smalltxt">你在聚合申请的验证码接口都要唯一Key，复制过来就行</span></td>
					<td class="altbg2"><input class="form-control shortinput" type="text" value="{if isset($setting['smskey'])}$setting['smskey']{/if}" name="smskey" /></td>
				</tr>

				<tbody >
				<tr>
					<td class="altbg1" width="45%"><b>短信验证码模板id:</b><br><span class="smalltxt">你创建短信模板的时候的模板ID</span></td>
					<td class="altbg2"><input class="form-control shortinput" type="text" value="{if isset($setting['smstmpid'])}$setting['smstmpid']{/if}" name="smstmpid" /></td>
				</tr>
				<tr>
					<td class="altbg1" width="45%"><b>短信验证码模板变量:</b><br><span class="smalltxt">您设置的模板变量，根据实际情况修改</span></td>
					<td class="altbg2"><input class="form-control shortinput" value="{if isset($setting['smstmpvalue'])}$setting['smstmpvalue']{/if}" name="smstmpvalue"></td>
				</tr>
			




				</tbody>



			</table>
			<br />
			<center><input type="submit" class="btn btn-success" name="submit" value="提 交"></center><br>
		</form>
<br />
<hr >
<h4>短信验证码发送测试</h4>
<form class="form-horizontal" role="form" method="post" action="{SITE_URL}index.php?admin_sms/testsms{$setting['seo_suffix']}">
<div class="form-group">
          <label class="col-md-2 control-label">对方手机号码</label>
          <div class="col-md-4">
             <input type="text" name="userphone" id="userphone" value="" placeholder="测试人手机号码，用于接收短信" class="form-control">
          </div>
        </div>

        <div class="form-group">
          <div class="col-md-offset-2 col-md-10">
             <input type="submit" name="submit" id="submit" class="btn btn-danger" value="发送测试" data-loading="稍候...">
          </div>
        </div>
</form>
</div>

</div>
<script>

  $('#myTab a').click(function (e) {
  e.preventDefault();
  $(this).tab('show');
})
</script>

<style>

html,body{
	overflow:scroll;
}
</style>
<!--{template footer}-->