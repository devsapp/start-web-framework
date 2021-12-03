<!--{template header}-->

<div class="layui-container fly-marginTop fly-user-main">
{template user_menu}
 <div class="fly-panel fly-panel-user" pad20>
{template message_nav}
	  <div class="layui-tab layui-tab-brief" lay-filter="user" id="LAY_msg" style="margin-top: 15px;">
	 
	  <form class="layui-form mar-t10"  name="commentform" action="{url message/sendmessage}" method="POST" > 
	    <div class="layui-form-item">
    <label class="layui-form-label">收件人</label>
    <div class="layui-input-block">
      <input type="text"  id="username" name="username" value="{if isset($sendto['username'])}$sendto['username']{/if}" required  lay-verify="required" placeholder="请输入收件人用户名" autocomplete="off" class="layui-input">
    </div>
  </div>
    <div class="layui-form-item">
    <label class="layui-form-label">主题</label>
    <div class="layui-input-block">
      <input type="text"id="subject" name="subject" required  lay-verify="required" placeholder="私信主题" autocomplete="off" class="layui-input">
    </div>
  </div>
  <div class="layui-form-item layui-form-text">
    <label class="layui-form-label">主题内容</label>
    <div class="layui-input-block">
      <!--{template editor}-->
    </div>
  </div>
       <!--{if $setting['code_message']=='1'}-->
                                  <!--{template code}-->

                      <!--{/if}-->
  <div class="layui-form-item">
    <div class="layui-input-block">
      <button name="submit" type="submit" lay-submit value="submit" class="layui-btn" id="sendsms">发送私信</div>
   
    </div>
  </div>
 
</form>
</div>
	</div>


</div>
<!--用户中心结束-->
<script type="text/javascript">
layui.use(['jquery', 'layer'], function(){
	  var $ = layui.$ //重点处
	  ,layer = layui.layer;
	  $("#sendsms").click(function(){
		  
		   	 var eidtor_content='';
           	 if(typeof testEditor != "undefined"){
              	  var tmptxt=$.trim(testEditor.getMarkdown());
              	  if(tmptxt==''){
              		 layer.msg("消息内容不能为空!");
              		  return;
              	  }
              	  eidtor_content= testEditor.getHTML();
                }else{
              	  if (typeof UE != "undefined") {
              			 eidtor_content= editor.getContent();
              		}else{
              			 eidtor_content= $.trim($("#editor").val());
              		}
                }
             
		    if (eidtor_content == '') {
		        layer.msg("消息内容不能为空!");
		        return false;
		    }
		   
			
		});
});


</script>
<!--{template footer}-->
