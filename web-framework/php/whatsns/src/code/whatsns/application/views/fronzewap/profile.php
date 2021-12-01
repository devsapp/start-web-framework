<!--{template header}-->
<section class="ui-container">
<!--{template user_title}-->
    <ul class="ui-tab-nav ui-border-b">
        <li class="current"><a href="{url user/profile}">个人资料</a></li>
        <li><a href="{url user/editemail}">激活账号</a></li>
        <li > <a href="{url user/mycategory}">我的设置</a></li>

    </ul>

    <form class="profileform ui-form"  method="POST" name="upinfoForm"  action="{url user/profile}" >
     
 <div class="ui-row">
          <p class="ui-col ui-col-25 text-left">用户名:</p>
          <div class="ui-col ui-col-75 ui-form-item ui-form-item-pure ui-border-b">
              <input type="text"  value="{$user['username']}" readonly class="ui-input-text">
       
          </div>
        </div>
     
             <div class="ui-row">
          <p class="ui-col ui-col-25 text-left ">真实姓名：</p>
          <div class="ui-col ui-col-75 ui-form-item ui-form-item-pure ui-border-b">
             <input type="text" name="truename" id="truename"  value="{$user['truename']}" placeholder="" class="ui-input-text">
             <a href="#" class="ui-icon-close"></a>
          </div>
        </div>
             <div class="ui-row">
          <p class="ui-col ui-col-25 text-left ">工作单位：</p>
          <div class="ui-col ui-col-75 ui-form-item ui-form-item-pure ui-border-b">
             <input type="text" name="conpanyname" id="conpanyname"  value="{$user['conpanyname']}" placeholder="" class="ui-input-text">
             <a href="#" class="ui-icon-close"></a>
          </div>
        </div>
         <div class="ui-row">
          <p class="ui-col ui-col-25 text-left">消息设置:</p>
          <div class="ui-col ui-col-75">
             <label class="ui-checkbox">
             <input class="normal_checkbox" type="checkbox" <!--{if 1 & $user['isnotify']}-->checked<!--{/if}--> value="1" name="messagenotify" />站内消息&nbsp;&nbsp;
        
        </label>

           
        </label>
           <label class="ui-checkbox">
         <input class="normal_checkbox"  type="checkbox" <!--{if 2 & $user['isnotify']}-->checked<!--{/if}--> value="2" name="mailnotify" />邮件通知
        </label>
          
          </div>
        </div>
        
         <div class="ui-row">
          <p class="ui-col ui-col-25 text-left ">性别:</p>
          <div class="ui-col ui-col-75">
          
           <label class="ui-radio" for="radio">
                    <input type="radio" value="1" class="normal_radio" name="gender" <!--{if (1 == $user['gender'])}--> checked <!--{/if}--> />男&nbsp;&nbsp;
        </label>
        
   <label class="ui-radio" for="radio">
           <input type="radio" value="0" class="normal_radio" name="gender" <!--{if (0 == $user['gender'])}--> checked <!--{/if}-->/>女 &nbsp;&nbsp;
        </label>
         <label class="ui-radio" for="radio">
           <input type="radio" value="2" class="normal_radio" name="gender" <!--{if (2 == $user['gender'])}--> checked <!--{/if}--> />保密
        </label>
          </div>
        </div>
        
         <div class="ui-row">
          <p class="ui-col ui-col-25 text-left ">生日：</p>
          <div class="ui-col ui-col-75">
             <!--{eval $bdate=explode("-",$user['bday']);}-->    
                         <div class="ui-select-group">
            <div class="ui-select">
                <select id="birthyear" name="birthyear" onchange="showbirthday();" >
                            <!--{eval $curyear=date("Y");}-->
                            <!--{eval $yearlist = range(1911,$curyear);}-->
                            <!--{loop $yearlist $year}-->
                            <option value="{$year}" <!--{if $bdate[0]==$year}-->selected<!--{/if}--> >{$year}</option>
                            <!--{/loop}-->
                        </select> 
            </div>
            <div class="ui-select">
                <select id="birthmonth" name="birthmonth" onchange="showbirthday();" class="normal_select">
                            {eval $monthlist = range(1,12);}
                            <!--{loop $monthlist $month}-->
                            <option value="{$month}" <!--{if $bdate[1]==$month}-->selected<!--{/if}-->>{$month}</option>
                            <!--{/loop}-->
                        </select> 
            </div>
            <div class="ui-select">
             <select id="birthday" name="birthday" class="normal_select">
                            {eval $dayhlist = range(1,31);}
                            <!--{loop $dayhlist $day}-->
                            <option  value="{$day}" <!--{if $bdate[2]==$day}-->selected<!--{/if}-->>{$day}</option>
                            <!--{/loop}-->
                        </select>
            </div>
        </div>
          </div>
        </div>
         <div class="ui-row">
          <p class="ui-col ui-col-25 text-left ">QQ：</p>
          <div class="ui-col ui-col-75 ui-form-item ui-form-item-pure ui-border-b">
             <input type="text"  name="qq" id="qq"   value="{$user['qq']}" placeholder="" class="ui-input-text">
           <a href="#" class="ui-icon-close"></a>
          </div>
        </div>
         <div class="ui-row">
          <p class="ui-col ui-col-25 text-left ">MSN：</p>
          <div class="ui-col ui-col-75 ui-form-item ui-form-item-pure ui-border-b">
             <input type="text"  name="msn" id="msn"  value="{$user['msn']}" placeholder="" class="ui-input-text">
             <a href="#" class="ui-icon-close"></a>
          </div>
        </div>
         <div class="ui-row" style="height:200px">
          <p class="ui-col ui-col-25 text-left ">身份介绍</p>
          <div class="ui-col ui-col-75 ui-form-item ui-form-item-pure ui-border-b" style="height:200px;">
            <textarea name="introduction" id="introduction" style="width:100%;height:200px;" class="form-control" >{$user['introduction']}</textarea>
            
    
          </div>
        </div>
         <div class="ui-row">
          <p class="ui-col ui-col-25 text-left ">签名</p>
          <div class="ui-col ui-col-75 ui-form-item ui-form-item-pure ui-border-b">
                                    <textarea name="signature" id="signature" style="width:90%;" class="form-control" maxlength="200">{$user['signature']}</textarea>
       
          </div>
        </div>
        
        
         
        
        <div class="ui-row" style="margin-top:16px;">
          <div class=" ui-col ui-col-100">
             <button type="submit" id="submit" name="submit" class="ui-btn-lg ui-btn-success" data-loading="稍候...">保存</button>
          </div>
        </div>
 </form>
</section>
 
<!--{template footer}-->