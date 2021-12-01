<!--{template meta}-->
    <style>
        body{
            background: #f1f5f8;
        }
    </style>

<div class="ws_header">
    <i onclick="window.history.go(-1)" class="fa fa-angle-left"></i>
    <div class="ws_h_title">邮箱找回密码</div>
    <span class="ws_ab_reg" onclick="window.location.href='{url user/register}'"><i class="fa fa-registered"></i>注册</span>
</div>
  <div class="au_login_panelform sign">
     <form id="new_session" class="am-form" name="getpassform"  action="{url user/getpass}" method="post">
        <input type="hidden"  id="forward" name="return_url" value="{$forward}">
      

        

             <div class="input-prepend ">
                <input placeholder="你的邮箱" type="text" value="" id="email" name="email" >
                <i class="fa fa-envelope"></i>
            </div>

                  
            <div class="input-prepend  no-radius js-normal ">
                    <img src="{url user/code}" onclick="javascript:updatecode();" id="verifycode">

                    <input autocomplete="off" type="text" class="form-control" id="code" name="code"  placeholder="输入图片验证码在点击发送按钮">
              <i class="fa fa fa-get-pocket"></i>
                  </div>
                         <div class="input-prepend  no-radius security-up-code js-security-number ">
                <input type="text" id="seccode_verify" name="seccode_verify" placeholder="邮箱验证码" >
                <i class="fa fa-get-pocket"></i>
                <a id="testbtn" onclick="getemailcode()" class="btn-up-resend js-send-code-button" href="javascript:;">发送验证码</a>

            </div>
               <div class="input-prepend ">
                <input placeholder="设置密码" type="password" id="password" name="password" autocomplete="OFF"  maxlength="20">
                <i class="fa fa-lock"></i>
            </div>
               <div class="input-prepend">
                <input placeholder="确认密码" type="password" id="repassword" name="repassword" autocomplete="OFF"   maxlength="20">
                <i class="fa fa-lock"></i>
            </div>
            <button type="submit" name="submit"  class="sign-in-button">提交</button>
        </form>
        <div style="height:20px;"></div>
         <div class="forget-btn">
                <a class="" href="{url user/getphonepass}">忘记邮箱试试手机号找回密码?</a>

            </div>
    </div>


 <script src="{SITE_URL}static/css/fronze/js/main.js?v1.1"></script>
<script>

      //验证码
        function updatecode() {
            var img = g_site_url + "index.php" + query + "user/code/" + Math.random();
            $('#verifycode').attr("src", img);
        }
        </script>

