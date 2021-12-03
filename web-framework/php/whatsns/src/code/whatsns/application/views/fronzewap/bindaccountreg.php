<!--{template header}-->


<section class="ui-container mar-t-01">
    <div class="ui-form ui-border-t">
        <form method="post" onsubmit="return cheklogin()">
         <input type="hidden"  id="openid" name="openid" value="{$openid}">
            <div class="ui-form-item ui-form-item-pure ui-border-b">
                <input type="text" id="username" name="user_name" placeholder="用户名" onblur="check_username();" >
                <a href="#" class="ui-icon-close"></a>
            </div>
            <div class="ui-form-item ui-form-item-pure ui-border-b">
                <input type="email" id="email" placeholder="邮箱" name="email"  onblur="check_email();">
                <a href="#" class="ui-icon-close"></a>
            </div>
            <div class="ui-form-item ui-form-item-pure ui-border-b">
                <input type="password" id="password" name="password" placeholder="密码" onblur="check_passwd();" maxlength="20">
                <a href="#" class="ui-icon-close"></a>
            </div>
            <div class="ui-form-item ui-form-item-pure ui-border-b">
                <input type="password" id="repassword" name="repassword" placeholder="确认密码"  onblur="check_repasswd();" maxlength="20">
                <a href="#" class="ui-icon-close"></a>
            </div>


            <div class="ui-btn-wrap">
                <button  class="ui-btn-lg ui-btn-primary" id="regsubmit" >
                                          注册并绑定微信账号
                </button>
            </div>
        </form>
    </div>

   <ul class="ui-row mar-t-05">
    <li class="ui-col ui-col-67">
    <a class="mar-lr-05" href="{url account/bind/$openid}">登录并绑定</a>
    </li>
    <li class="ui-col ui-col-33">


   </li>
    </ul>



      <script type="text/javascript">
    var usernameok = 1;
    var password = 1;
    var repasswdok = 1;
    var emailok = 1;

    function check_username() {
        var username = $.trim($('#username').val());
        var length = bytes(username);

        if (length < 3 || length > 15) {

        	el2=$.tips({
                content:'用户名请使用3到15个字符',
                stayTime:1000,
                type:"info"
            });


            usernameok = false;
        } else {
            $.post("{SITE_URL}index.php?user/ajaxusername", {username: username}, function(flag) {
                if (-1 == flag) {


                	 el2=$.tips({
                         content:'此用户名已经存在',
                         stayTime:2000,
                         type:"info"
                     });

                    usernameok = false;
                } else if (-2 == flag) {


                	 el2=$.tips({
                         content:'用户名含有禁用字符',
                         stayTime:2000,
                         type:"info"
                     });
                    usernameok = false;
                } else {

                	 el2=$.tips({
                         content:'用户名可以使用',
                         stayTime:1000,
                         type:"success"
                     });

                    usernameok = true;
                }
            });
        }
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

    function check_email() {
        var email = $.trim($('#email').val());
        if (!email.match(/^[\w\.\-]+@([\w\-]+\.)+[a-z]{2,4}$/ig)) {



        	 el2=$.tips({
                 content:'邮件格式不正确',
                 stayTime:1000,
                 type:"info"
             });

            usernameok = false;
        } else {
            $.post("{SITE_URL}index.php?user/ajaxemail", {email: email}, function(flag) {
                if (-1 == flag) {
                	 el2=$.tips({
                         content:'此邮件地址已经注册',
                         stayTime:1000,
                         type:"info"
                     });

                    emailok = false;
                } else if (-2 == flag) {
                	 el2=$.tips({
                         content:'邮件地址被禁止注册',
                         stayTime:1000,
                         type:"info"
                     });

                    emailok = false;
                } else {
                    emailok = true;

                	 el2=$.tips({
                         content:'邮箱名可以注册',
                         stayTime:1500,
                         type:"success"
                     });
                }
            });
        }
    }




    function cheklogin(){

    	 var _openid=$("#openid").val();
        var _uname=$("#username").val();
        var _upwd=$("#password").val();
        var _rupwd=$("#repassword").val();

        var _email=$("#email").val();


        $.ajax({
            //提交数据的类型 POST GET
            type:"POST",
            //提交的网址
            url:"{url api_user/bindregisterapi}",
            //提交的数据
            data:{uname:_uname,upwd:_upwd,rupwd:_rupwd,email:_email,openid:_openid},
            //返回数据的格式
            datatype: "text",//"xml", "html", "script", "json", "jsonp", "text".
            //在请求之前调用的函数
            beforeSend:function(){
         	    el=$.loading({
         	        content:'加载中...',
         	    })
            },
            //成功返回之后调用的函数
            success:function(data){
            	 el.loading("hide");

                if(data=='reguser_ok'){




               	 el2=$.tips({
                     content:'绑定成功，即将跳转',
                     stayTime:1000,
                     type:"success"
                 });

             	setTimeout(function(){
             		  window.location.href="{SITE_URL}";
             	},1500);

                }else if(data=='reguser_ok1'){
                	 el2=$.tips({
                         content:'绑定成功，系统已发送注册邮件，24小时之内请进行邮箱验证，在您没激活邮件之前你不能发布问题和文章等操作！',
                         stayTime:1500,
                         type:"success"
                     });

                	 	setTimeout(function(){
                   		  window.location.href="{SITE_URL}";
                   	},1500);
                }else{
                	switch(data){


                	case 'reguser_cant_null':

                		 el2=$.tips({
                             content:'用户名或者密码不能为空',
                             stayTime:1000,
                             type:"info"
                         });

                		break;
                	case 'regemail_Illegal':
                		 el2=$.tips({
                             content:'注册邮箱不合法',
                             stayTime:1000,
                             type:"info"
                         });

                		break;
                	case 'regemail_has_exits':
                		 el2=$.tips({
                             content:'邮箱已注册',
                             stayTime:1000,
                             type:"info"
                         });

                		break;
                	case 'regemail_cant_use':
                		 el2=$.tips({
                             content:'此邮箱不能注册使用',
                             stayTime:1000,
                             type:"info"
                         });

                		break;
                	case 'reguser_has_exits':
                		 el2=$.tips({
                             content:'注册用户名已经存在',
                             stayTime:1000,
                             type:"info"
                         });

                		break;
                	case 'Illegal':
                		 el2=$.tips({
                             content:'用户名或者密码包含特殊字符',
                             stayTime:1000,
                             type:"info"
                         });

                		break;
                	default:

                		 el2=$.tips({
                             content:data,
                             stayTime:1000,
                             type:"info"
                         });
                		break;
                	}
                }
            }   ,
            //调用执行后调用的函数
            complete: function(XMLHttpRequest, textStatus){
         	    el.loading("hide");
            },
            //调用出错执行的函数
            error: function(XMLHttpRequest, textStatus, errorThrown) {
           	 alert(XMLHttpRequest.status);
           	 alert(XMLHttpRequest.readyState);
           	 alert(textStatus);
           	   }
        });
        return false;
    }





</script>

   </section>

<script src="{SITE_URL}static/css/fronze/js/main.js"></script>