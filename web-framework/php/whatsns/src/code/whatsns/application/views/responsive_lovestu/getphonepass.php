 <!-- 公共头部--> 
{template header}

<div class="layui-container fly-marginTop">
  <div class="fly-panel fly-panel-user" pad20>
    <div class="layui-tab layui-tab-brief" lay-filter="user">
      <ul class="layui-tab-title">
        <li><a href="{url user/login}">登入</a></li>
        
         <li><a href="{url user/getpass}">邮箱找回</a></li>
          {if $setting['smscanuse']==1} <li class="layui-this">手机号找回</li>{/if}
      </ul>
      <div class="layui-form layui-tab-content" id="LAY_ucm" style="padding: 20px 0;">
        <div class="layui-tab-item layui-show">
        
          <div class="layui-form layui-form-pane">
            <form name="getpassform"  action="{url user/getphonepass}" method="post">
              <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">手机号</label>
                <div class="layui-input-inline">
                  <input type="tel" id="userphone" name="userphone" required lay-verify="required" autocomplete="off" class="layui-input">
                </div>
              </div>
               
              <div class="layui-form-item">
                <label for="L_vercode" class="layui-form-label">手机验证码</label>
                <div class="layui-input-inline">
                  <input type="text" id="seccode_verify" name="seccode_verify"  placeholder="手机验证码" required lay-verify="required"  autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid">
                  <span style="color: #c00;"><div id="testphonebtn" class="layui-btn layui-btn-xs">发送验证码</div></span>
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

<!-- 公共底部 --> 
{template footer}