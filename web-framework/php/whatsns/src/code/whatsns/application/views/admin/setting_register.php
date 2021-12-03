<!--{template header}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;注册设置</div>
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
        <tr class="altbg1"><td>允许/禁止的 Email 地址只需填写 Email 的域名部分，每行一个域名，例如 @hotmail.com</td></tr>
    </tbody></table>
<br />
<form action="index.php?admin_setting/register{$setting['seo_suffix']}" method="post">
    <a name="基本设置"></a>
    <table class="table">
        <tr class="header">
            <td colspan="2">参数设置</td>
        </tr>
        <tr>
            <td class="altbg1" width="45%"><b>允许新用户注册:</b><br><span class="smalltxt">若不需要新用户注册，可以到用户管理里面手动添加用户</span></td>
            <td class="altbg2">
                <input class="radio inline"  type="radio"  {if 1==$setting['allow_register'] }checked{/if}  value="1" name="allow_register"><label for="yes">是</label>&nbsp;&nbsp;&nbsp;&nbsp;
                <input class="radio inline"  type="radio"  {if 0==$setting['allow_register'] }checked{/if} value="0" name="allow_register"><label for="no">否</label></td>
        </tr>
              <tr>
					<td class="altbg1" width="45%"><b>注册免邮箱:</b></td>
					<td class="altbg2">
					<input class="" type="checkbox" {if $setting['register_email_on']==1}checked{/if} name="register_email_on" />勾选后前端网页注册会隐藏邮箱字段
					</td>
				</tr>
         <tr>
            <td class="altbg1" width="45%"><b>注册用户必须邮箱验证:</b><br><span class="smalltxt">开启后没有邮箱验证的用户除了管理员外都不能进行一切操作</span></td>
            <td class="altbg2">
                <input class="radio inline"  type="radio"  {if 1==$setting['register_on'] }checked{/if}  value="1" name="register_on"><label for="yes">是</label>&nbsp;&nbsp;&nbsp;&nbsp;
                <input class="radio inline"  type="radio"  {if 0==$setting['register_on'] }checked{/if} value="0" name="register_on"><label for="no">否</label></td>
        </tr>
        <tr>
            <td class="altbg1" width="45%"><b>24小时内同一IP的最大注册用户数目:</b><br><span class="smalltxt">限制ip灌水注册</span></td>
            <td class="altbg2"><input class="form-control shortinput" name="max_register_num" type="text"  value="{$setting['max_register_num']}"/></td>
        </tr>
        <tr>
            <td class="altbg1" width="45%"><b>允许的 Email 地址:</b><br><span class="smalltxt">只允许使用这些域名结尾的 Email 地址注册</span></td>
            <td class="altbg2"><textarea row="5" class=" form-control shortinput" name="access_email">{$setting['access_email']}</textarea></td>
        </tr>
        <tr>
            <td class="altbg1" width="45%"><b>禁止的用户名:</b><br><span class="smalltxt">可以设置通配符，每个关键字一行，可使用通配符 "*" 如 "*版主*"(不含引号)</span></td>
            <td class="altbg2"><textarea row="5" class=" form-control shortinput" name="censor_username">{$setting['censor_username']}</textarea></td>
        </tr>
    </table>
    <br>
    <center><input type="submit" class="btn btn-info" name="submit" value="提 交"></center><br>
</form>
<br>
<!--{template footer}-->