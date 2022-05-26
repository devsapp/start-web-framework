<!--{eval global $starttime,$querynum;$mtime = explode(' ', microtime());$runtime=number_format($mtime[1] + $mtime[0] - $starttime,6); $setting=$this->setting;$user=$this->user;$headernavlist=$this->nav;$regular=$this->regular;}-->
<div class="poploginform sign ">

 <div id="user_error" class="alert alert-danger hide">

 </div>
    <form  class="form-horizontal poploginform" name="loginform"   method="post"    >

<div class="input-prepend mar-t-1">
        <input placeholder="注册用户名/邮箱号/手机号码" autocomplete="off" type="text" value="" id="popusername" name="username">
      <i class="fa fa-user"></i>
    </div>

    <div class="input-prepend ">
      <input placeholder="用户密码" type="password" autocomplete="off" id="poppassword" name="password" autocomplete="off" maxlength="20">
      <i class="fa fa-lock"></i>
    </div>







         <div class="form-group hide">
          <label class="col-md-4 control-label"></label>
          <div class="col-md-10">
             <input type="checkbox" id="cookietime" name="cookietime" value="2592000" />下次自动登录
          </div>
        </div>


         <div class="form-group">


             <input type="button"  id="submit"  onclick="checkform()" value="登录" class="sign-up-button">
          <input type="hidden" id="tokenkey" name="tokenkey" value='{$_SESSION["logintokenid"]}'/>
            <input type="hidden" id="popforward" name="forward" value="{$forward}"/>

            <div class="clearfix mar-t-1">
                     <a href="{url user/register}" class="text-danger mar-l-1 ">注册新账号</a>
            <a href="{url user/getpass}" class="text-danger mar-lr-1 ">忘记密码?</a>

            </div>



        </div>


        <div class="thirdpart_login mar-lr-1">
<!--{template openlogin}-->
        </div>
    </form>

    <script type="text/javascript">
        function checkform() {
            var username = $("#popusername").val();
            var password = $("#poppassword").val();
            var _logincode = $("#login_code").val();


            var _forward=$("#popforward").val();
            var _apikey=$("#tokenkey").val();


            if ($.trim(username) === '') {
            	 new $.zui.Messager("请输入您的账号", {
            		  
            		   close: true,
            		   time:"1000",
               	    placement: 'center' // 定义显示位置
               	}).show();

                $("#username").focus();
                return false;
            }
            if (password === '') {

            	 new $.zui.Messager("请输入您的密码", {
          		   
          		 time:"1000",
          		   close: true,
             	    placement: 'center' // 定义显示位置
             	}).show();

                $("#password").focus();
                return false;
            }
            $("#user_error").html("").addClass("hide");

            <!--{if $setting['code_login']}-->
            check_login_code();
            if (!$('#logincodetip').hasClass("hide")) {
                $("#code").focus();
                return false;
            }
            <!--{/if}-->

            $.ajax({
                type: "POST",
                async: false,
                cache: false,

                //提交的网址
                url:"{SITE_URL}/?api_user/loginapi",
                //提交的数据
                data:{uname:$.trim(username),upwd:password,apikey:_apikey,seccode_verify:_logincode},
                //返回数据的格式
                datatype: "text",//"xml", "html", "script", "json", "jsonp", "text".
                beforeSend: function () {

                    ajaxloading("提交中...");
                 },
                success: function(data) {
                	data=$.trim(data);
		if(data.indexOf('ok|')>=0){
				var datastrs=data.split('|');
				$("body").append(datastrs);
				data='login_ok';
			}
                    if(data=='login_ok'){





                      window.location.href=_forward;




                    }else{
                    	  switch(data){
                    	  case 'login_null':

                    	alert("用户名或者密码为空");
                    		   return false;
                    		  break;
         case 'login_user_or_pwd_error':
        	 alert("用户名或者密码错误");
        	   return false;
                    		  break;
                    		  default:
                    			alert(data);
                    		  return false;
                    		  break;

                    	  }
                    }

                },
                complete: function () {
                    removeajaxloading();
                 }
            });
            return false;
            if (!$("#user_error").hasClass("hide")) {
                return false;
            } else {
                return true;
            }

        }
          //验证码
            function popupdatecode() {
              var img = g_site_url + "index.php" + query + "user/code/" + Math.random();
              $('#popverifycode').attr("src", img);
            }

        function refresh_code() {
            var img = g_site_url + "index.php" + query + "user/code/" + Math.random();
            $('#verifylogincode').attr("src", img);
        }
        function check_login_code() {

            var code = $.trim($('#login_code').val());


            if ($.trim(code) == '') {

            	   new $.zui.Messager("验证码错误", {
            		   type: 'danger',
            		   close: true,
            		   time:"1000",
               	    placement: 'center' // 定义显示位置
               	}).show();

                return false;
            }

            $.ajax({
                type: "POST",
                async: false,
                cache: false,
                url: "{SITE_URL}index.php?user/ajaxcode/"+code,
                success: function(flag) {
                    if (1 == flag) {
                       // $('#logincodetip').html("验证码正确").removeClass("hide");

                        return true;
                    } else {
                    	 new $.zui.Messager("验证码错误", {
                    		 type: 'danger',
                  		   close: true,
                  		   time:"1000",
                     	    placement: 'center' // 定义显示位置
                     	}).show();


                        return false;
                    }

                }
            });
        }
    </script>

</div>