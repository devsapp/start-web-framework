<!--{template header}-->
<section class="ui-container">
<!--{template user_title}-->
 <div class="messagepoerate" >
                         <p>
                          
                          <button type="button" class="ui-btn ui-btn-primary mar-l-1 " onclick="javascript:document.location = '{url message/personal}'">返回消息列表</button>
                        
                         </p>
         
                       
                        
                     </div>
 <form class="profileform ui-form"  action="{url message/sendmessage}" method="post" style="padding-bottom:50px;">

     
           <div class="ui-row">
          <p class="ui-col ui-col-25 text-left ">收件人：</p>
          <div class="ui-col ui-col-75 ui-form-item ui-form-item-pure ui-border-b">
             <input type="text" id="username" name="username"   value="{$user['username']}" placeholder="" class="form-control">
             <a href="#" class="ui-icon-close"></a>
          </div>
        </div>
        
           <div class="ui-row">
          <p class="ui-col ui-col-25 text-left ">主题：</p>
          <div class="ui-col ui-col-75 ui-form-item ui-form-item-pure ui-border-b">
             <input type="text" id="subject" name="subject"    placeholder="" class="form-control">
             <a href="#" class="ui-icon-close"></a>
          </div>
        </div>
      
           <div class="ui-row">
          <p class="">内容</p>
          <div class="col-md-18">
       <!--{template editor}-->
          </div>
        </div>
            <div class="ui-row">
            <!--{if $setting['code_message']}-->
     
               <!--{template code}-->
          <!--{/if}-->
        </div>
          
        
             <div class="ui-row">
         <button type="submit" id="submit" name="submit" class="ui-btn ui-btn-danger"  data-loading="稍候...">保存</button>
        </div>
        
      
 </form>
</section>


<!--{template footer}-->