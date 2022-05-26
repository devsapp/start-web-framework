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
          <li class="layui-this">修改回答</li>
        </ul>
        <div class="layui-form layui-tab-content" id="LAY_ucm" style="padding: 20px 0;">
          <div class="layui-tab-item layui-show">
            <form action=""   enctype="multipart/form-data" method="POST"  name="askform" id="askform" >
    
        
              <div class="layui-form-item layui-form-text">
                <div class="layui-input-block">
                    <!--{template editor}-->
                </div>
              </div>
       
                  <!--{if $setting['code_ask']&&$user['credit1']<$setting['jingyan']}-->
      
 {template code}
 
   <!--{/if}-->
   
             
              <div class="layui-form-item">
                    <input type="hidden" value="{$aid}" id="buchong_aid" name="aid"/>
                <div id="submit" name="submit"  class="layui-btn"  id="asksubmit">确认修改</div>
                        
                            
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
    		if(submitfalse){
        		return;
    		}
    		 var eidtor_content='';
    		 if(typeof testEditor != "undefined"){
    	     	  var tmptxt=$.trim(testEditor.getMarkdown());
    	     	  if(tmptxt==''){
    	     		  layer.msg("回答内容不能为空");
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
    		  if(eidtor_content==''){
	     		  layer.msg("回答内容不能为空");
	     		  return;
	     	  }
    		var data={
    	    			content:eidtor_content,
    	    			submit:$("#submit").val(),
    	    			aid:$("#buchong_aid").val(),
    	    			code:$("#code").val()
    	    			
    	    	}
    		
    		$.ajax({
    		    //提交数据的类型 POST GET
    		    type:"POST",
    		    //提交的网址
    		    url:"{url question/ajaxeditanswer}",
    		    //提交的数据
    		    data:data,
    		    //返回数据的格式
    		    datatype: "json",//"xml", "html", "script", "json", "jsonp", "text".
    		    //在请求之前调用的函数
    		    beforeSend:function(){
    		    	submitfalse=true;
    		    },
    		    //成功返回之后调用的函数             
    		    success:function(data){
    		    	$(".progress").addClass("hide");
    		    	var data=eval("("+data+")");
    		       if(data.message=='ok'){
    		    	   var tmpmsg='修改回答成功!';
    	        	   if(data.sh=='1'){
    	        		   tmpmsg='修改回答成功！为了确保回答的质量，我们会对您的回答内容进行审核。请耐心等待......';
    	        	   }
    		    	 layer.msg(tmpmsg)
    		    	   setTimeout(function(){
    		               window.location.href=data.url;
    		           },1500);
    		       }else{
    		    	 layer.msg(data.message)
    		       }
    		      
    		     
    		    }   ,
    		    //调用执行后调用的函数
    		    complete: function(XMLHttpRequest, textStatus){
    		    	
    		    },
    		    //调用出错执行的函数
    		    error: function(){
    		    	submitfalse=false;
    		        //请求出错处理
    		    }         
    		 });
    	})
})
</script>
<!--{template footer}-->

