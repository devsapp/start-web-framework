<!--{template header}-->

<section class="ui-container">
<!--{template user_title}-->
 <form class="form-horizontal"  action="{url user/uppass}"  method="post" >

        
         <div class="ui-form-item ui-form-item-show ui-border-b">
            <label for="#">当前密码</label>
              <input type="password" id="oldpwd" name="oldpwd"  value="" placeholder="" >
               <a href="#" class="ui-icon-close"></a>
        </div>
        
        <div class="ui-form-item ui-form-item-show ui-border-b">
            <label for="#">新密码</label>
                <input type="password" id="newpwd"  name="newpwd"  value="" placeholder="" >
                 <a href="#" class="ui-icon-close"></a>
        </div>
             <div class="ui-form-item ui-form-item-show ui-border-b">
            <label for="#">确认密码</label>
         <input type="password" id="confirmpwd"  name="confirmpwd"  value="" placeholder="" >
          <a href="#" class="ui-icon-close"></a>
        </div>
        
            <div class="ui-form-item ui-form-item-r ui-border-b">
                <input type="text" id="code" name="code" placeholder="请输入验证码">
              
                <button type="button" class="ui-border-l"><img class="ui-border-l" src="{url user/code}" onclick="javascript:updatecode();" id="verifycode"></button>

                <a href="#" class="ui-icon-close"></a>
            </div>
     
        <div class="ui-btn-wrap">
              <!-- 若按钮不可点击则添加 disabled 类 -->
                <button type="submit" name="submit" id="submit"  class="ui-btn-lg ui-btn-primary">
                    确定
                </button>
            </div>
        
      
      
 </form>

</section>
 
<!--{template footer}-->