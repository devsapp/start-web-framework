
<!--{template meta}-->
<link rel="stylesheet" media="all" href="{SITE_URL}static/css/widescreen/css/greenlogin.css" />
<body class="no-padding reader-black-font">
<div class="sign">
<div class="logo"><a href="{SITE_URL}" target="_self"><img src="{$setting['site_logo']}" alt="Logo" class="lazy" style="display: inline;"></a></div>
    <div class="main">



<h4 class="title">
  <div class="normal-title">
    <a class="" href="{url user/login}">登录</a>
    <b>·</b>
    <a id="js-sign-up-btn" class="active" href="{url user/register}">注册</a>
  </div>
</h4>
<div class="js-sign-up-container">
  <form class="new_user" method="post">
      <input type="hidden" id="tokenkey" name="tokenkey" value='{$_SESSION["registrtokenid"]}'/>
       {if $setting['needinvatereg']==1}
   <div class="input-prepend ">
        <input placeholder="填写推荐人邀请码" type="text" {if $invatecode}readonly{/if} value="{if $invatecode}$invatecode{/if}" id="frominvatecode"  name="frominvatecode"  >
      <i class="fa fa-adn"></i>
    </div>
        {/if}
    <div class="input-prepend ">
        <input placeholder="你的昵称" autocomplete="off" type="text" value="" id="username" name="user_name" >
      <i class="fa fa-user"></i>
    </div>
       {if !$setting['register_email_on']}
    <div class="input-prepend ">
        <input placeholder="你的邮箱" autocomplete="off" type="text" value="" id="email"  name="email"  >
      <i class="fa fa-envelope"></i>
    </div>
          {/if}
   {if $setting['smscanuse']==1}
      <div class="input-prepend  no-radius js-normal ">

          <input placeholder="手机号" type="tel" autocomplete="off" oninput="listerphone()" onpropertychange="listerphone()" id="userphone" name="userphone" >
        <i class="fa fa-phone"></i>
      </div>

    <div class="input-prepend  no-radius security-up-code js-security-number hide">
        <input type="text" id="seccode_verify" name="seccode_verify"  placeholder="手机验证码" onblur="check_phone();">
      <i class="fa fa-get-pocket"></i>
     <a  id="testbtn" onclick="gosms()" class="btn-up-resend js-send-code-button" href="javascript:;">发送验证码</a>
      <div><div class="captcha"><input  name="captcha[validation][challenge]" autocomplete="off" type="hidden" value="a025bd170ffad53e107ed83f4fb7e916"> <input name="captcha[validation][gt]" autocomplete="off" type="hidden" value="a10ea6a23a441db3d956598988dff3c4"> <input name="captcha[validation][validate]" autocomplete="off" type="hidden" value=""> <input name="captcha[validation][seccode]" autocomplete="off" type="hidden" value=""> <input name="captcha[id]" autocomplete="off" type="hidden" value="1ad70a1e-f61a-4665-a1bd-f29a05cabe89"> <div id="geetest-area" class="geetest"><div class="gt_input"><input class="geetest_challenge" type="hidden" name="geetest_challenge"><input class="geetest_validate" type="hidden" name="geetest_validate"><input class="geetest_seccode" type="hidden" name="geetest_seccode"></div></div></div></div>
    </div>
    {else}
     {if !$setting['needinvatereg']}
      <div class="input-prepend  no-radius js-normal ">
                    <img  src="" onclick="javascript:updatecode();" id="verifycode" class="hide">

                    <input type="text" class="" id="seccode_verify" name="seccode_verify" placeholder="验证码">
              <i class="fa fa fa-get-pocket"></i>
                  </div>
                     {/if}
                {/if}
       <div class="input-prepend ">
      <input placeholder="设置密码" type="password" id="password" name="password" autocomplete="off" maxlength="20">
      <i class="fa fa-lock"></i>
    </div>
     {if !$setting['needinvatereg']}
      <div class="input-prepend">
      <input placeholder="确认密码" type="password" id="repassword" name="repassword" autocomplete="off" maxlength="20">
      <i class="fa fa-lock"></i>
    </div>
     {/if}
       {if !$setting['needinvatereg']}
   <div class="input-prepend ">
        <input placeholder="邀请码,非必填" type="text" {if $invatecode}readonly{/if} value="{if $invatecode}$invatecode{/if}" id="frominvatecode"  name="frominvatecode"  >
      <i class="fa fa-adn"></i>
    </div>
        {/if}
    {if $_SESSION['authinfo'] }
    <input type="button" id="regsubmit" onclick="cheklogin()"  value="注册并绑定账号" class="sign-up-button">
    {else}
     <input type="button" id="regsubmit" onclick="cheklogin()"  value="注册" class="sign-up-button">
    {/if}

     <p class="sign-up-msg">点击<a data-toggle="modal" data-target="#myModal">“注册” </a> 即表示您同意并愿意遵守协议 。</p>
     <div class="reg_step1">
     
     </div>
     
     <div class="reg_step2">
     
     </div>

</form>
<!--{template openlogin}-->
</div>

    </div>
  </div>


<div class="modal fade" id="myModal" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
        <h4 class="modal-title">{$setting['site_name']}注册协议</h4>
      </div>

        <div class="modal-body">
                    <div style="height: 450px;overflow:scroll;">
                        <p>&nbsp; &nbsp; &nbsp; &nbsp;当您申请用户时，表示您已经同意遵守本规章。&nbsp;</p><p>欢迎您加入本站点参加交流和讨论，本站点为公共论坛，为维护网上公共秩序和社会稳定，请您自觉遵守以下条款：&nbsp;</p><p><br></p><p>一、不得利用本站危害国家安全、泄露国家秘密，不得侵犯国家社会集体的和公民的合法权益，不得利用本站制作、复制和传播下列信息：</p><p>　 （一）煽动抗拒、破坏宪法和法律、行政法规实施的；</p><p>　（二）煽动颠覆国家政权，推翻社会主义制度的；</p><p>　（三）煽动分裂国家、破坏国家统一的；</p><p>　（四）煽动民族仇恨、民族歧视，破坏民族团结的；</p><p>　（五）捏造或者歪曲事实，散布谣言，扰乱社会秩序的；</p><p>　（六）宣扬封建迷信、淫秽、色情、赌博、暴力、凶杀、恐怖、教唆犯罪的；</p><p>　（七）公然侮辱他人或者捏造事实诽谤他人的，或者进行其他恶意攻击的；</p><p>　（八）损害国家机关信誉的；</p><p>　（九）其他违反宪法和法律行政法规的；</p><p>　（十）进行商业广告行为的。</p><p><br></p><p>二、互相尊重，对自己的言论和行为负责。</p><p>三、禁止在申请用户时使用相关本站的词汇，或是带有侮辱、毁谤、造谣类的或是有其含义的各种语言进行注册用户，否则我们会将其删除。</p><p>四、禁止以任何方式对本站进行各种破坏行为。</p><p>五、如果您有违反国家相关法律法规的行为，本站概不负责，您的登录论坛信息均被记录无疑，必要时，我们会向相关的国家管理部门提供此类信息。</p>
                    </div>
                </div>


    </div>
  </div>
</div>

      <script type="text/javascript">
	  setTimeout(function(){updatecode();$("#verifycode").removeClass("hide");},500);
	  //
    var usernameok = 1;
    var password = 1;
    var repasswdok = 1;
    var emailok = 1;
    var codeok = 1;



	 function listerphone(){
    	 var _phone=$("#userphone").val();
    	 if(_phone.length>0){

    		 $(".js-security-number").removeClass("hide");
    	 }else{
    		 $(".js-security-number").addClass("hide");
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
        	  alert("邀请码不能为空");
       		 return false;
          }
        {/if}
        var _apikey=$("#tokenkey").val();

        {if $setting['smscanuse']==1}
        var _phone=$("#userphone").val();

      	  var _rs=check_phone(_phone);
      	if(!_rs){
      		 alert("手机号码有误");
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

                ajaxloading("提交中...");
             },
            //成功返回之后调用的函数
            success:function(data){

            	data=$.trim(data);
                if(data=='reguser_ok'){





                  window.location.href="{url user/default}";



                }else if(data=='reguser_ok1'){

                	alert("注册成功，系统已发送注册邮件，24小时之内请进行邮箱验证，在您没激活邮件之前你不能发布问题和文章等操作！");
                	setTimeout(function(){
                   	  window.location.href="{url user/login}";
                     },3000)

                }else{
					
                	switch(data){


                	case 'reguser_cant_null':


                		alert("用户名或者密码不能为空");
                		break;
                	case 'regemail_Illegal':

                		alert("注册邮箱不合法");
                		break;
                	case 'regemail_has_exits':

                		alert("邮箱已注册");
                		break;
                	case 'regemail_cant_use':

                		alert("此邮箱不能注册使用");
                		break;
                	case 'reguser_has_exits':

                		alert("注册用户名已经存在");
                		break;
                	case 'Illegal':

                		alert("用户名或者密码包含特殊字符");
                		break;
                	default:
                       
                		alert(data,5000);
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
    }





</script>

