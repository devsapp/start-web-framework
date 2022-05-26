 {if $user['uid']==0}
             <div class="recommend">
            <div class="title">
                <i class="fa fa-zuji"></i><span class="title_text">登录</span>
            </div>
            <div class="sideform">
                <input type="text" class="sideform_text" autocomplete="OFF" placeholder="输入账号、邮箱或手机号登录" id="side_username">
                <input type="password" class="sideform_text" readonly="" onfocus="this.removeAttribute('readonly');" autocomplete="OFF" placeholder="输入注册时填写的密码" id="side_password">
                <input type="hidden" id="side_tokenkey" name="side_tokenkey" value='{$_SESSION["logintokenid"]}'/>
                <button class="btn side-btn-login">登录</button>
                <p class="ws_gotoreg">
                    <span>还没有账号？<a href="{url user/register}">去注册></a></span>
                </p>
            </div>
        </div>  {/if}