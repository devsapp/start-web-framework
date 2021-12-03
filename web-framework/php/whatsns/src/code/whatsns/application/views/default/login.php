<!--{template meta}-->
<link rel="stylesheet" media="all" href="{SITE_URL}static/css/widescreen/css/greenlogin.css" />
<body class="no-padding reader-black-font">
<div class="sign">
<div class="logo"><a href="{SITE_URL}" target="_self"><img src="{$setting['site_logo']}" alt="Logo" class="lazy" style="display: inline;"></a></div>
   
    <div class="main">


<h4 class="title">
  <div class="normal-title">
    <a class="active" href="{url user/login}">登录</a>
    <b>·</b>
    <a id="js-sign-up-btn" class="" href="{url user/register}">注册</a>
  </div>
</h4>
<div class="js-sign-in-container">
  <form id="new_session"  accept-charset="UTF-8" method="post"><input name="utf8" type="hidden" value="✓"><input type="hidden" name="authenticity_token" value="fmDZC5B2M/Cj9fddniQd+UZf9QK++PqX3Jt3VhlwLByyM5eNbhuYXUrfQJeyap54s8abx05bTKo6WDqxqrartg==">
<input type="hidden"  id="forward" name="return_url" value="{$forward}">
<input type="hidden"  id="authtype" name="authtype" value="{$_SESSION['authinfo']['type']}">
  <input type="hidden" id="tokenkey" name="tokenkey" value='{$_SESSION["logintokenid"]}'/>
    <!-- 正常登录登录名输入框 -->
      <div class="input-prepend restyle js-normal">
        <input placeholder="手机号或邮箱/用户名" type="text" autocomplete="off" id="xm-login-user-name" >
        <i class="fa fa-user"></i>
      </div>

    <!-- 海外登录登录名输入框 -->

    <div class="input-prepend">
      <input placeholder="密码" type="password" autocomplete="off" id="xm-login-user-password">
      <i class="fa fa-lock"></i>
    </div>

    <div class="remember-btn">
      <input type="checkbox" value="1" name="net_auto_login" checked="checked" ><span>记住我</span>
    </div>
    <div class="forget-btn">
      <a class=""  href="{url user/getpass}">登录遇到问题?</a>

    </div>
    {if $_SESSION['authinfo'] }
     <input type="button" id="login_submit" value="绑定账号" class="sign-in-button">
    {else}
     <input type="button" id="login_submit" value="登录" class="sign-in-button">
    {/if}

</form>
{if $_GET['oauth_provider']==null}
<!--{template openlogin}-->
{/if}
</div>

    </div>
  </div>
   <script>
$("#login_submit").click(function(){
	 var _forward=$("#forward").val();
    var _uname=$("#xm-login-user-name").val();
    var _upwd=$("#xm-login-user-password").val();
    var _apikey=$("#tokenkey").val();
    {if $_SESSION ['authinfo']}

    var _auth=1;
    {else}
    var _auth=0;
    {/if}

    $.ajax({
        //提交数据的类型 POST GET
        type:"POST",
        //提交的网址
        url:"{SITE_URL}/?api_user/loginapi",
        //提交的数据
        data:{uname:_uname,upwd:_upwd,apikey:_apikey},
        //返回数据的格式
        datatype: "text",//"xml", "html", "script", "json", "jsonp", "text".
        beforeSend: function () {

            ajaxloading("提交中...");
         },
        //成功返回之后调用的函数
        success:function(data){
        	data=$.trim(data);
			console.log(data)
		
					if(data.indexOf('ok|')>=0){
				var datastrs=data.split('|');
				$("body").append(datastrs);
				data='login_ok';
			}
            if(data=='login_ok'){





             	var _forward="{$forward}"; //user/logout
            	if(_auth==1||_forward.indexOf('user/getphonepass')>=0||_forward.indexOf('user/getpass')>=0||_forward.indexOf('user/logout')>=0||_forward.indexOf('user/checkemail')>=0){
             		window.location.href="{url index}";
             	}else{
             		window.location.href="{$forward}";
             	}





            }else{
            	  switch(data){
            	  case 'login_null':
            		  alert("用户名或者密码为空");
            		  break;
 case 'login_user_or_pwd_error':
	  alert("用户名或者密码错误");
            		  break;
default:
	alert(data);
	break;
            	  }
            }
        }   ,
        complete: function () {
            removeajaxloading();
         },
        //调用出错执行的函数
        error: function(){
            //请求出错处理
        }
    });
});


</script>
