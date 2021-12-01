<!--{template header}-->


<section class="ui-container mar-t-01">
    <div class="ui-form ui-border-t">
        <form id="login_form">
        <input type="hidden"  id="openid" name="openid" value="{$openid}">
            <div class="ui-form-item ui-form-item-pure ui-border-b">
                <input id="xm-login-user-name" name="user_name" type="text" placeholder="注册时候的账号">
                <a href="#" class="ui-icon-close"></a>
            </div>
            <div class="ui-form-item ui-form-item-pure ui-border-b">
                <input id="xm-login-user-password" type="password" placeholder="密码" name="password">
                <a href="#" class="ui-icon-close"></a>
            </div>


            <div class="ui-btn-wrap">
              <!-- 若按钮不可点击则添加 disabled 类 -->
                <button id="login_submit"  class="ui-btn-lg ui-btn-primary">
                  绑定账号
                </button>
            </div>
        </form>
    </div>

   <ul class="ui-row mar-t-05">
    <li class="ui-col ui-col-67">
    <a class="mar-lr-05" href="{url account/bindregister/$openid}">立即注册</a>
    </li>
    <li class="ui-col ui-col-33">


   </li>
    </ul>


</section>
 <script>

$("#login_submit").bind("click",function(event){

	 var _openid=$("#openid").val();
    var _uname=$("#xm-login-user-name").val();
    var _upwd=$("#xm-login-user-password").val();

    var el='';
    $.ajax({
        //提交数据的类型 POST GET
        type:"POST",
        //提交的网址
        url:"{url api_user/bindloginapi}",
        //提交的数据
        data:{uname:_uname,upwd:_upwd,openid:_openid},
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
        	 el.loading("hide");
            if(data=='login_ok'){


            	 el2=$.tips({
                     content:'绑定成功，即将跳转',
                     stayTime:1000,
                     type:"success"
                 });

             	setTimeout(function(){
             		  window.location.href="{SITE_URL}";
             	},1500);






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
            //请求出错处理
        }
    });
    event.stopPropagation();    //  阻止事件冒泡
    return false;
});


</script>
<!--{template footer}-->