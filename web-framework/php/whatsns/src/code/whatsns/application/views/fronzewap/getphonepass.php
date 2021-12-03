<!--{template meta}-->
    <style>
        body{
            background: #f1f5f8;
        }
    </style>

<div class="ws_header">
    <i onclick="window.history.go(-1)" class="fa fa-angle-left"></i>
    <div class="ws_h_title">手机号找回密码</div>
    <span class="ws_ab_reg" onclick="window.location.href='{url user/register}'"><i class="fa fa-registered"></i>注册</span>
</div>
  <div class="au_login_panelform sign">
     <form id="new_session" class="am-form" name="getpassform"  action="{url user/getphonepass}" method="post">
        <input type="hidden"  id="forward" name="return_url" value="{$forward}">
              <div class="input-prepend  no-radius js-normal ">

                <input placeholder="手机号" type="tel"  onblur="check_phone();" maxlength="11" id="userphone" name="userphone">
                <i class="fa fa-phone"></i>
            </div>

            <div class="input-prepend  no-radius security-up-code js-security-number ">
                <input type="text" id="seccode_verify" name="seccode_verify" placeholder="手机验证码" onblur="check_phone();">
                <i class="fa fa-get-pocket"></i>
                <a id="testbtn" onclick="gopwdsms()" class="btn-up-resend js-send-code-button" href="javascript:;">发送验证码</a>

            </div>
               <div class="input-prepend ">
                <input placeholder="设置密码" type="password" id="password" name="password" autocomplete="OFF" onblur="check_passwd();" maxlength="20">
                <i class="fa fa-lock"></i>
            </div>
               <div class="input-prepend">
                <input placeholder="确认密码" type="password" id="repassword" name="repassword" autocomplete="OFF"  onblur="check_repasswd();" maxlength="20">
                <i class="fa fa-lock"></i>
            </div>
            <button type="submit" name="submit"  class="sign-in-button">提交</button>
        </form>
        <div style="height:20px;"></div>
         <div class="forget-btn">
                <a class="" href="{url user/getpass}">忘记邮箱试试手机号找回密码?</a>

            </div>
    </div>
<script>
function check_phone(_phone){
	
	 if(!(/^1(3|4|5|7|8)\d{9}$/.test(_phone))){ 
		 el2=$.tips({
             content:'手机号不正确',
             stayTime:2000,
             type:"info"
         });
	    }else{
	    	return true;
	    }
}
function bytes(str) {
    var len = 0;
    for (var i = 0; i < str.length; i++) {
        if (str.charCodeAt(i) > 127) {
            len++;
        }
        len++;
    }
    return len;
}
function check_passwd() {
    var passwd = $('#password').val();
    if (bytes(passwd) < 6 || bytes(passwd) > 16) {




    	 el2=$.tips({
             content:'密码最少6个字符，最长不得超过16个字符',
             stayTime:2000,
             type:"info"
         });
        password = false;
    } else {


        password = 1;
    }
}

function check_repasswd() {
    repasswdok = 1;
    var repassword = $('#repassword').val();
    if (bytes(repassword) < 6 || bytes(repassword) > 16) {
    	 el2=$.tips({
             content:'密码最少6个字符，最长不得超过16个字符',
             stayTime:2000,
             type:"info"
         });

        repasswdok = false;
    } else {
        if ($('#password').val() == $('#repassword').val()) {


            repasswdok = true;
        } else {
        	 el2=$.tips({
                 content:'两次密码输入不一致',
                 stayTime:2000,
                 type:"info"
             });

            repasswdok = false;
        }
    }
}
      //验证码
        function updatecode() {
            var img = g_site_url + "index.php" + query + "user/code/" + Math.random();
            $('#verifycode').attr("src", img);
        }
        </script>
<script src="{SITE_URL}static/css/fronze/js/main.js"></script>