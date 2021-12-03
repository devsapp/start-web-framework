<!--{template header}-->

<div class="layui-container fly-marginTop fly-user-main">
{template user_menu}
 <div class="fly-panel fly-panel-user" pad20>
{template message_nav}
	  <div class="layui-tab layui-tab-brief" lay-filter="user" id="LAY_msg" style="margin-top: 15px;">
	    <a onclick="if(confirm('是否清空？') window.location.href='{url message/updateunread}';" class="layui-btn layui-btn-danger" id="LAY_delallmsg">清空全部消息</a>
	    <a href="{url message/sendmessage}" class="layui-btn">写信息</a>
	    <div  id="LAY_minemsg" style="margin-top: 10px;">
        <!--<div class="fly-none">您暂时没有最新消息</div>-->
        <ul class="mine-msg">
              <!--{loop $messagelist $message}-->
          <li data-id="{$message['id']}">
          <div class="mar-b10">
           <!--{if $message['fromuid']==$user['uid']}-->
                               
                                <a href="{url user/score}">您</a> 对 <a href="{url user/space/$message['fromuid']}">{$message['touser']['username']}</a> 说：
                                <!--{else}-->
                         
                                <a href="{url user/space/$message['fromuid']}">{$message['from']}</a> 对 <a href="{url user/score}">您</a> 说：
                                <!--{/if}-->
                                       
					
                                                </div>
            <blockquote class="layui-elem-quote">
   
				
      {$message['content']}
            </blockquote>
            <p><span>{$message['format_time']}</span> <div href="javascript:;" class="" style="height:20px;"></div></p>
          </li>
      	  <!--{/loop}-->
        </ul>
        {template page}
      </div>
	  </div>
	  <!--{if 'personal'==$type}-->
	  <form class="layui-form"  name="commentform" action="{url message/sendmessage}" method="POST" > 
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
      <button name="submit" type="submit" value="submit" class="layui-btn" id="sendsms">回复私信</div>
   
    </div>
  </div>
 
   <input type="hidden" name="username" value="{$fromuser['username']}" />
</form>
  <!--{/if}-->
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
