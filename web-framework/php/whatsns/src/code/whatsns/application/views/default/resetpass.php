<!--{template meta}-->
<link rel="stylesheet" media="all" href="{SITE_URL}static/css/widescreen/css/login.css" />
<body class="no-padding reader-black-font">
<div class="sign">
    <div class="logo"><a href="/"><img src="{$setting['site_logo']}" alt="Logo"></a></div>
    <div class="main">



<h4 class="title">
找回密码
</h4>
<div class="js-sign-up-container">
  <form class="new_user" name="getpassform"  action="" method="post">
         <input type="hidden" class=""  name="authcode"  value="{$authcode}" />





       <div class="input-prepend ">
      <input placeholder="设置密码" type="password" id="password" name="password" autocomplete="off" maxlength="20">
      <i class="fa fa-lock"></i>
    </div>
      <div class="input-prepend">
      <input placeholder="确认密码" type="password" id="repassword" name="repassword" autocomplete="off" maxlength="20">
      <i class="fa fa-lock"></i>
    </div>
      <div class="input-prepend">
         <img class="pull-right" src="{url user/code}" onclick="javascript:updatecode();" id="verifycode">


             <input type="text" class="form-control" id="code" name="code" placeholder="输入验证码" onblur="check_code();"/>
				 <i class="fa fa fa-get-pocket"></i>
				 </div>
    <input type="submit" name="submit" id="regsubmit"  value="提交" class="sign-up-button">

</form>
<!--{template openlogin}-->
</div>

    </div>
  </div>



<!--{template footer}-->


