<!--{template header}-->

<section class="ui-container">
<!--{template user_title}-->
    <ul class="ui-tab-nav ui-border-b">

        <li class="current"><a href="{url user/editemail}">激活邮箱账号</a></li>
        
   <li class=""><a href="{url user/editphone}">激活手机号</a></li>
    </ul>
    <section class="ui-panel ui-panel-pure ui-border-t">
    
                     <div style="padding:10px;">
                  {if $user['active']==0}


                 
                 <div class="ui-tooltips ui-tooltips-guide">
    <div class="ui-tooltips-cnt  ui-border-b">
        <i class="fa fa-info"></i>      邮箱没有激活
    </div>
</div>

                     {else}
            
                 <div class="ui-tooltips ui-tooltips-guide">
    <div class="ui-tooltips-cnt  ui-border-b">
        <i class="fa fa-info"></i>              邮箱已经激活
    </div>
</div>

    
               {/if}
           </div>
    

<form class=" profileform ui-form"  action="{url user/editemail}" method="post" >
 <input type="hidden" name="formkey" id="formkey" value="{$_SESSION['formkey']}" >

        
      
     
          <div class="ui-row">
          <p class="ui-col ui-col-25 text-left ">邮箱：</p>
          <div class="ui-col ui-col-75 ui-form-item ui-form-item-pure ui-border-b">
             <input type="email"  name="email" id="email"  value="{$user['email']}" placeholder="" class="ui-input-text">
           <a href="#" class="ui-icon-close"></a>
          </div>
        </div>
        <div class="ui-row">
            <div class="ui-form-item ui-form-item-r ui-border-b">
                <input type="text" id="code" name="code" placeholder="请输入验证码">
              
                <button type="button" class="ui-border-l"><img class="ui-border-l" src="{url user/code}" onclick="javascript:updatecode();" id="verifycode"></button>

                <a href="#" class="ui-icon-close"></a>
            </div>
     
      </div>
        
      
      
                       {if $user['active']==0}
    
  <div class="ui-btn-wrap">
            <button type="submit" name="submit" id="submit" value="submit" class="ui-btn-lg ui-btn-primary">
保存并激活
            </button>
        </div>
        
               {else}

 <div class="ui-btn-wrap">
            <button type="submit" name="submit" value="submit" id="submit" class="ui-btn-lg ui-btn-primary">
修改并重新激活
            </button>
        </div>
        
     
               {/if}
 </form>
 
          
 
</section>
              
         
  
           
             
            
</section>
 
 
<!--{template footer}-->