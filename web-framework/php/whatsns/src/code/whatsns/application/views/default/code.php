 <div class="form-group">
        
          <div class="col-md-5 input_code_col">
             <input type="text"   placeholder="输入验证码" autocomplete="OFF" id="code" name="code"  value="" class="form-control">

          </div>
          
     
      
          <div class="col-md-8 ">
            <span class="verifycode"><img class="hand" src="{url user/code}" onclick="javascript:updatecode();" id="verifycode">
                        </span>
                         <a class="changecode"  href="javascript:updatecode();">&nbsp;看不清?</a>
          </div>
               <div class="col-md-8">
            
             <div  id="codetip" class="help-block alert alert-warning hide"></div>
          </div>
     
        </div>