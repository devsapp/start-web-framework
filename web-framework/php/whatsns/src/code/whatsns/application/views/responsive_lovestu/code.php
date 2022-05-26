
        
         <div class="layui-form-item">
                <label for="L_vercode" class="layui-form-label">验证码</label>
                <div class="layui-input-inline">
                  <input type="text"  id="code" name="code"  onkeydown="if(event.keyCode==13){event.keyCode=0;return false} "   value="" required lay-verify="required" placeholder="图片验证码" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid">
                  <span style="color: #c00;"><img class="hand" src="{url user/code}" onclick="javascript:updatecode();" id="verifycode"><a class="changecode"  href="javascript:updatecode();">&nbsp;看不清?</a></span>
                </div>
              </div>
              