 <!-- 公共头部--> 
{template header}

<div class="layui-container fly-marginTop">
  <div class="fly-panel fly-panel-user" pad20>
    <div class="layui-tab layui-tab-brief" lay-filter="user">
      <ul class="layui-tab-title">
        <li><a href="{url user/login}">登入</a></li>
        <li class="layui-this">邮箱找回</li>
        {if $setting['smscanuse']==1} <li><a href="{url user/getphonepass}">手机号找回</a></li>{/if}
      </ul>
      <div class="layui-form layui-tab-content" id="LAY_ucm" style="padding: 20px 0;">
        <div class="layui-tab-item layui-show">
        
          <div class="layui-form layui-form-pane">
            <form name="getpassform"  action="{url user/getpass}" method="post">
              <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">邮箱</label>
                <div class="layui-input-inline">
                  <input type="email" id="email" name="email" required lay-verify="required" autocomplete="off" class="layui-input">
                </div>
              </div>
                 <div class="layui-form-item">
                <label for="L_vercode" class="layui-form-label">图片验证码</label>
                <div class="layui-input-inline">
                  <input type="text" id="code" name="code" placeholder="验证前请输入图片验证码"  required lay-verify="required"  autocomplete="off" class="layui-input ">
                </div>
                <div class="layui-form-mid">
                  <span style="color: #c00;"><img  src=""  id="verifycode" class="hide hand">
</span>
                </div>
              </div>
              <div class="layui-form-item">
                <label for="L_vercode" class="layui-form-label">邮箱验证码</label>
                <div class="layui-input-inline">
                  <input type="text" id="seccode_verify" name="seccode_verify"  placeholder="邮箱中查看收到的验证码" required lay-verify="required"  autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid">
                  <span style="color: #c00;"><div id="testbtn" class="layui-btn layui-btn-xs">发送验证码</div></span>
                </div>
              </div>
                  <div class="layui-form-item">
                <label for="L_pass" class="layui-form-label">密码</label>
                <div class="layui-input-inline">
                  <input type="password"  id="password" name="password" maxlength="20" required lay-verify="required" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">6到20个字符</div>
              </div>
              <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">确认密码</label>
                <div class="layui-input-inline">
                  <input type="password" id="repassword" name="repassword" maxlength="20" required lay-verify="required" autocomplete="off" class="layui-input">
                </div>
              </div>
              
              <div class="layui-form-item">
                <button class="layui-btn" alert="1" name="submit" id="regsubmit"  lay-submit>提交</button>
              </div>
            </form>
          </div>
          
        </div>
      </div>
    </div>
  </div>

  
</div>
<script>
layui.use(['jquery', 'layer'], function(){
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
	  
})
</script>
<!-- 公共底部 --> 
{template footer}