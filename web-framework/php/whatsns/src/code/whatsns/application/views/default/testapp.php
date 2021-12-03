<!--{template header}-->
<link rel="stylesheet" media="all" href="{SITE_URL}static/css/bianping/css/login.css" />
<!--内容部分--->
<div class="sign">

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
  <input type="hidden" id="tokenkey" name="tokenkey" value='{$_SESSION["tokenid"]}'/>  
    <!-- 正常登录登录名输入框 -->
      <div class="input-prepend restyle js-normal">
        <input placeholder="手机号或邮箱/用户名" type="text" id="xm-login-user-name" >
        <i class="fa fa-user"></i>
      </div>

    <!-- 海外登录登录名输入框 -->

    <div class="input-prepend">
      <input placeholder="密码" type="password" id="xm-login-user-password">
      <i class="fa fa-lock"></i>
    </div>
   
 
    <input type="button" id="login_submit" value="登录" class="sign-in-button">
</form>

</div>

    </div>
  </div>
  <script>
$("#login_submit").click(function(){
    var _uname=$("#xm-login-user-name").val();
    var _upwd=$("#xm-login-user-password").val();
    function success(result){
    	localStorage.setItem('accesstoken',result.val);
    	console.log(result);
    	if(result.code==207){
    		window.location.href='{url about/ajaxuser}';
    	}else{
    		alert(result.msg)
    	}
    }
    ajaxpost("{SITE_URL}/app/?user/login",{"uname":_uname,"upwd":_upwd},success);
});


</script>
<!--{template footer}-->