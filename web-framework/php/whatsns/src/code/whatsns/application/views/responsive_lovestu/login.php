 <!-- 公共头部--> 
{template header}

<div class="layui-container fly-marginTop">
  <div class="fly-panel fly-panel-user" pad20>
    <div class="layui-tab layui-tab-brief" lay-filter="user">
      <ul class="layui-tab-title">
        <li class="layui-this">登入</li>
        <li><a href="{url user/register}">注册</a></li>
      </ul>
      <div class="layui-form layui-tab-content" id="LAY_ucm" style="padding: 20px 0;">
        <div class="layui-tab-item layui-show">
          <div class="layui-form layui-form-pane">
            <form method="post">
            <input type="hidden"  id="forward" name="return_url" value="{$forward}">
<input type="hidden"  id="authtype" name="authtype" value="{$_SESSION['authinfo']['type']}">
  <input type="hidden" id="tokenkey" name="tokenkey" value='{$_SESSION["logintokenid"]}'/>
              <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">邮箱</label>
                <div class="layui-input-inline">
                  <input type="text" placeholder="账号" autocomplete="off" id="xm-login-user-name" name="xm-login-user-name" required lay-verify="required"  class="layui-input">
                </div>
              </div>
              <div class="layui-form-item">
                <label for="L_pass" class="layui-form-label">密码</label>
                <div class="layui-input-inline">
                  <input placeholder="密码" type="password"  id="xm-login-user-password" name="xm-login-user-password" required lay-verify="required" autocomplete="off" class="layui-input">
                </div>
              </div>
          
              <div class="layui-form-item">
            
                    {if $_SESSION['authinfo'] }
    
         <div class="layui-btn" id="login_submit">绑定账号</div>
    {else}
        <div class="layui-btn" id="login_submit">立即登录</div>
    {/if}
    
                <span style="padding-left:20px;">
                  <a href="{url user/getpass}">忘记密码？</a>
                </span>
              </div>
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

 <!-- 公共底部 --> 
{template footer}