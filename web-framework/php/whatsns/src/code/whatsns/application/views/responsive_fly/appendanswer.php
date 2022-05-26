<!--{template header}-->
<style>
.fly-header{
z-index:4;
}
</style>
<div class="layui-container fly-marginTop">
  <div class="fly-panel" pad20 style="padding-top: 5px;">
    <!--<div class="fly-none">没有权限</div>-->
    <div class="layui-form layui-form-pane">
      <div class="layui-tab layui-tab-brief" lay-filter="user">
        <ul class="layui-tab-title">
          <li class="layui-this">追加内容</li>
        </ul>
        <div class="layui-form layui-tab-content" id="LAY_ucm" style="padding: 20px 0;">
          <div class="layui-tab-item layui-show">
            <form  name="answerform"  action="{url answer/append}" method="post"   enctype="multipart/form-data" >
    
        
              <div class="layui-form-item layui-form-text">
                <div class="layui-input-block">
                    <!--{template editor}-->
                </div>
              </div>
       
                  <!--{if $setting['code_ask']&&$user['credit1']<$setting['jingyan']}-->
      
 {template code}
 
   <!--{/if}-->
   
             
              <div class="layui-form-item">
                 <input type="hidden" value="{$qid}" name="qid"/>
                    <input type="hidden" value="{$aid}" name="aid"/>
                <button id="submit"  class="layui-btn" name="submit" id="asksubmit">确认修改</button>
                        
                            
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
function bytes(str) {
    var len = 0;
    for (var i = 0; i < str.length; i++) {
        if (str.charCodeAt(i) > 127) {
            len++;
        }
        len++;
    }
    return len;
}

layui.use(['jquery', 'layer'], function(){ 
  var $ = layui.$ //重点处
  ,layer = layui.layer;
    var submitfalse=false;
      $("#submit").click(function(){
          if(  $("#submit").hasClass("layui-btn-disabled")){
        	  return false;
          }else{
        	  $("#submit").addClass("layui-btn-disabled");
          }
    
    		      	 if(submitfalse)
    		      	 {
        		      	 return false;
    		      	 }
    		     	 var eidtor_content='';
    		     	 if(typeof testEditor != "undefined"){
    		       	  var tmptxt=$.trim(testEditor.getMarkdown());
    		       	  if(tmptxt==''){
    		       		  $("#submit").removeClass("layui-btn-disabled");
    		       		  layer.msg("回答内容不能为空");
    		       		  return false;
    		       	  }
    		       	  eidtor_content= testEditor.getHTML();
    		         }else{
    		       	  if (typeof UE != "undefined") {
    		       			 eidtor_content= editor.getContent();
    		       		}else{
    		       			 eidtor_content= $.trim($("#editor").val());
    		       		}
    		         }
    		   	
    		          if (bytes(eidtor_content) <= 5) {
    		        	  $("#submit").removeClass("layui-btn-disabled");
    		              layer.msg('内容不能少于5个字！');
    		              return false;
    		          }
    		         
    		          document.answerform.action="{url answer/append}";
    		          document.answerform.submit();
    		          submitfalse=true;
    		          return true;
    	})
    	
})
</script>
<!--{template footer}-->



