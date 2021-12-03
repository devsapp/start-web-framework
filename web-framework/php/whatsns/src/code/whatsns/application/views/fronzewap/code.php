
        
<ul class="ui-row">
 
    
    <li class="ui-col ui-col-75">
     <input type="text"  onkeydown="return keydownlistener(event)"  placeholder="输入验证码" autocomplete="OFF" id="code" name="code" onblur="check_code();"  value="" class="form-control">
    
    </li>
   <li class="ui-col ui-col-25">
    <span class="verifycode"><img class="hand" src="{url user/code}" onclick="javascript:updatecode();" id="verifycode" style="position:relative;top:10px;">
                        </span>
                        
   </li>
     <li class="ui-col ui-col-100">
      <div  id="codetip" class="help-block alert alert-warning hide"></div>
     </li>
</ul>