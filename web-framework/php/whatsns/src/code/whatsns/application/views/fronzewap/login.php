<!--{template meta}-->
    <style>
        body{
            background: #f1f5f8;
        }
    </style>

<div class="ws_header">
    <i onclick="window.history.go(-1)" class="fa fa-angle-left"></i>
    <div class="ws_h_title">用户登录</div>
    <span class="ws_ab_reg" onclick="window.location.href='{url user/register}'"><i class="fa fa-registered"></i>注册</span>
</div>
  <div class="au_login_panelform sign">
        <form id="new_session" accept-charset="UTF-8" method="post">
         <input type="hidden"  id="forward" name="return_url" value="{$forward}">
          <input type="hidden" id="tokenkey" name="tokenkey" value='{$_SESSION["logintokenid"]}'/>
            <!-- 正常登录登录名输入框 -->
            <div class="input-prepend restyle js-normal">
                <input placeholder="手机号或邮箱/用户名" type="text" id="xm-login-user-name">
                <i class="fa fa-user"></i>
            </div>

            <!-- 海外登录登录名输入框 -->

            <div class="input-prepend">
                <input placeholder="密码" type="password" id="xm-login-user-password">
                <i class="fa fa-lock"></i>
            </div>

            <div class="remember-btn">
                <input type="checkbox"  value="1" id="keeppwd" name="net_auto_login" checked="checked"><span>记住我</span>
            </div>
            <div class="forget-btn">
                <a class="" href="{url user/getpass}">登录遇到问题?</a>

            </div>
            <button type="button" id="login_submit" class="sign-in-button">登录</button>
        </form>
         <!--{if $setting['sinalogin_open']||$setting['qqlogin_open']}-->
        <!-- 更多登录方式 -->
        <div class="more-sign">

            <h6>第三方登录</h6>
            <ul>
			  
				
                <!--{if $setting['sinalogin_open']}-->
                <li><a class="weibo" href="{SITE_URL}plugin/sinalogin/index.php"><i class="fa fa-weibo"></i></a></li>
                <!--{/if}-->
          
                <!--{if $setting['qqlogin_open']}-->
                <li><a class="qq" href="{SITE_URL}plugin/qqlogin/index.php"><i class="fa fa-qq"></i></a></li>
                <!--{/if}-->



            </ul>

        </div>
         <!--{/if}-->
    </div>

 <script>
 var uname_tmp=window.localStorage.getItem("username");
 var upwd_tmp=window.localStorage.getItem("userpwd");
 if(uname_tmp!=null){
	 $("#xm-login-user-name").val(uname_tmp);
	 $("#xm-login-user-password").val(upwd_tmp);
	 $("#keeppwd").attr("checked",'true');
 }
 function keepuserinfo(){
	 var _pwdkeep=$("#keeppwd").attr("checked");
	 var _uname=$("#xm-login-user-name").val();
	    var _upwd=$("#xm-login-user-password").val();
	if(_pwdkeep){
		window.localStorage.setItem("username",_uname);
		window.localStorage.setItem("userpwd",_upwd);
	}else{

		window.localStorage.removeItem("username");
		window.localStorage.removeItem("userpwd");
	}
 }
 $("#keeppwd").change(function(){
	 keepuserinfo();
 })
$("#login_submit").bind("click",function(event){
	 var _forward=$("#forward").val();
    var _uname=$("#xm-login-user-name").val();
    var _upwd=$("#xm-login-user-password").val();
    var _apikey=$("#tokenkey").val();
    var _code=$("#seccode_verify").val();
    var el='';
    {if $_SESSION ['authinfo']}

    var _auth=1;
    {else}
    var _auth=0;
    {/if}
    $.ajax({
        //提交数据的类型 POST GET
        type:"POST",
        //提交的网址
        url:"{url api_user/loginapi}",
        //提交的数据
        data:{uname:_uname,upwd:_upwd,apikey:_apikey,seccode_verify:_code},
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
		data=$.trim(data);
		
		if(data.indexOf('ok|')>=0){
				
				var datastrs=data.split('|');
			console.log(datastrs[1])
			document.write("<div style='font-size:15px;margin-top:100px;font-weight:900;'><center>登录成功!</center></div>"+datastrs[1]);
				data='login_ok';
			}
		
        	 el.loading("hide");
        
            if(data=='login_ok'){

            	keepuserinfo();

 		var _forward="{$forward}"; //user/logout
          
               setTimeout(function(){
              
             	if(_auth==1||_forward.indexOf('user/getphonepass')>=0||_forward.indexOf('user/getpass')>=0||_forward.indexOf('user/logout')>=0||_forward.indexOf('user/checkemail')>=0){
             		window.location.href="{url index}";
             	}else{
             		window.location.href="{$forward}";
             	}
               },1500)
             






            }else{
            	  switch(data){
            	  case 'login_null':

            		  el2=$.tips({
            	            content:'用户名或者密码为空',
            	            stayTime:1000,
            	            type:"info"
            	        });
            		  break;
 case 'login_user_or_pwd_error':

	  el2=$.tips({
          content:'用户名或者密码错误',
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
        error: function(){
        	console.log("异常")
        	  el.loading("hide");
            //请求出错处理
        }
    });
    event.stopPropagation();    //  阻止事件冒泡
    return false;
});


</script>
