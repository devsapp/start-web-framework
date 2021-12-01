 <!-- 公共头部--> 
{template header}

<div class="layui-container fly-marginTop">
  <div class="fly-panel fly-panel-user" pad20>
    <div class="layui-tab layui-tab-brief" lay-filter="user">
      <ul class="layui-tab-title">
        <li><a href="{url user/login}">登入</a></li>
        <li class="layui-this">注册</li>
      </ul>
      <div class="layui-form layui-tab-content" id="LAY_ucm" style="padding: 20px 0;">
        <div class="layui-tab-item layui-show">
          <div class="layui-form layui-form-pane">
            <form method="post">
                <input type="hidden" id="tokenkey" name="tokenkey" value='{$_SESSION["registrtokenid"]}'/>
                 {if $setting['needinvatereg']==1}
        <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">邀请码</label>
                <div class="layui-input-inline">
                  <input type="text" id="frominvatecode"  name="frominvatecode"  {if $invatecode}readonly{/if} value="{if $invatecode}$invatecode{/if}" required lay-verify="frominvatecode" autocomplete="off" class="layui-input">
                </div>
        {/if}
         
            <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">注册用户名</label>
                <div class="layui-input-inline">
                  <input type="text" id="username" name="user_name" required lay-verify="user_name" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">将会成为您唯一的登入名</div>
              </div>
                   {if !$setting['register_email_on']}
              <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">邮箱</label>
                <div class="layui-input-inline">
                  <input type="text" id="email" name="email" required lay-verify="email" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">将会成为您唯一的登入名</div>
              </div>
               {/if}
                 {if $setting['smscanuse']==1}
              <div class="layui-form-item">
                <label for="L_username" class="layui-form-label">手机号码</label>
                <div class="layui-input-inline">
                  <input type="tel" id="userphone" name="userphone"  required lay-verify="userphone" autocomplete="off" class="layui-input">
                </div>
              </div>
                  <div class="layui-form-item">
                <label for="L_vercode" class="layui-form-label">手机验证码</label>
                <div class="layui-input-inline">
                  <input type="text" id="seccode_verify" name="seccode_verify"  placeholder="手机验证码" required lay-verify="required"  autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid">
                  <span style="color: #c00;"><div id="testregphonebtn" class="layui-btn layui-btn-xs">发送验证码</div></span>
                </div>
              </div>
                {else}
                   <div class="layui-form-item">
                <label for="L_vercode" class="layui-form-label">图片验证码</label>
                <div class="layui-input-inline">
                  <input type="text" id="seccode_verify" name="seccode_verify" required lay-verify="required" placeholder="图片验证码" autocomplete="off" class="layui-input ">
                </div>
                <div class="layui-form-mid">
                  <span style="color: #c00;"><img  src=""  id="verifycode" class="hide hand">
</span>
                </div>
              </div>
                {/if}
              <div class="layui-form-item">
                <label for="L_pass" class="layui-form-label">密码</label>
                <div class="layui-input-inline">
                  <input type="password" id="password" name="password" maxlength="20" required lay-verify="required" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">6到20个字符</div>
              </div>
              <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">确认密码</label>
                <div class="layui-input-inline">
                  <input type="password" id="repassword" name="repassword" maxlength="20" required lay-verify="required" autocomplete="off" class="layui-input">
                </div>
              </div>
           
            {if !$setting['needinvatereg']}
   <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">邀请码</label>
                <div class="layui-input-inline">
                  <input type="text" id="frominvatecode"  name="frominvatecode"  {if $invatecode}readonly{/if} value="{if $invatecode}$invatecode{/if}"  autocomplete="off" class="layui-input">
                </div>
                 <div class="layui-form-mid layui-word-aux">非必填</div>
                  </div>
        {/if}
        
          {if $_SESSION['authinfo'] }
          <div class="layui-form-item mar-t10">
                <div class="layui-btn" id="regsubmit"   lay-submit>注册并绑定账号</div>
              </div>
            
    {else}
     <div class="layui-form-item mar-t10">
                <div class="layui-btn" id="regsubmit"    lay-submit>立即注册</div>
              </div>
              
     
    {/if}
    
             
                  {if $_GET['oauth_provider']==null}
             <!--{template openlogin}-->
                  {/if}

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
<script>
layui.use(['jquery', 'layer'], function(){
	  var usernameok = 1;
	    var password = 1;
	    var repasswdok = 1;
	    var emailok = 1;
	    var codeok = 1;
	  var $ = layui.$ //重点处
	  ,layer = layui.layer;
	  function updatecode() {
		  var img = "{url user/code}";
		  $('#verifycode').attr("src", img);
		}
	  setTimeout(function(){updatecode();$("#verifycode").removeClass("hide");},500);
	  $("#verifycode").click(function(){
		  updatecode();
	  })
	  function check_phone(_phone){

			 if(!(/^1(1|2|3|4|5|6|7|8|9)\d{9}$/.test(_phone))){ 
			       
			        return false; 
			    }else{
			    	return true;
			    }
		}
	  function cheklogin(){

	       
	        var _uname=$("#username").val();
	        var _upwd=$("#password").val();
	        var _rupwd=$("#repassword").val();
	        var _code=$("#seccode_verify").val();
	        var _email=$("#email").val();
	        var _frominvatecode=$.trim($("#frominvatecode").val());

	        {if $setting['needinvatereg']==1}
	          if(_frominvatecode==''){
	        	  $("#frominvatecode").val("")
	        	  layer.msg("邀请码不能为空");
	       		 return false;
	          }
	        {/if}
	        var _apikey=$("#tokenkey").val();

	        {if $setting['smscanuse']==1}
	        var _phone=$("#userphone").val();

	      	  var _rs=check_phone(_phone);
	      	if(!_rs){
	      		layer.msg("手机号码有误");
	      		 return false;
	      	}
	        var _data={phone:_phone,uname:_uname,upwd:_upwd,rupwd:_rupwd,email:_email,frominvatecode:_frominvatecode,apikey:_apikey,seccode_verify:_code};
	        {else}
	        var _data={uname:_uname,upwd:_upwd,rupwd:_rupwd,email:_email,frominvatecode:_frominvatecode,apikey:_apikey,seccode_verify:_code};
	        {/if}

	        $.ajax({
	            //提交数据的类型 POST GET
	            type:"POST",
	            //提交的网址
	            url:"{url api_user/registerapi}",
	            //提交的数据
	            data:_data,
	            //返回数据的格式
	            datatype: "text",//"xml", "html", "script", "json", "jsonp", "text".
	            beforeSend: function () {
	             },
	            //成功返回之后调用的函数
	            success:function(data){
		        	
	            	data=$.trim(data);
	            
	                if(data=='reguser_ok'){

	                  window.location.href="{url user/default}";



	                }else if(data=='reguser_ok1'){

	                	layer.msg("注册成功，系统已发送注册邮件，24小时之内请进行邮箱验证，在您没激活邮件之前你不能发布问题和文章等操作！");
	                	setTimeout(function(){
	                   	  window.location.href="{url user/login}";
	                     },3000)

	                }else{
						
	                	switch(data){


	                	case 'reguser_cant_null':


	                		layer.msg("用户名或者密码不能为空");
	                		break;
	                	case 'regemail_Illegal':

	                		layer.msg("注册邮箱不合法");
	                		break;
	                	case 'regemail_has_exits':

	                		layer.msg("邮箱已注册");
	                		break;
	                	case 'regemail_cant_use':

	                		layer.msg("此邮箱不能注册使用");
	                		break;
	                	case 'reguser_has_exits':

	                		alert("注册用户名已经存在");
	                		break;
	                	case 'Illegal':

	                		layer.msg("用户名或者密码包含特殊字符");
	                		break;
	                	default:
	                       
	                		layer.msg(data);
	                		break;
	                	}
	                }
	                return false;
	            }   ,
	            complete: function () {
	            	 return false;
	             },
	            //调用出错执行的函数
	            error: function(){
	                //请求出错处理
	            	 return false;
	            }
	        });
	        return false;
	    }
	   $("#regsubmit").click(function(){
		   cheklogin();
		   return false;
	  })
	  
	});

</script>
<!-- 公共底部 --> 
{template footer}