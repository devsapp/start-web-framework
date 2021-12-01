<!--{template header}-->


<div class="container  mar-t-1 mar-b-1">
<div class="row">
  <div class="col-sm-24">
 

    <form  class="form-horizontal mar-t-05"  name="answerform" method="post" >
            <div class="askbox">
               
          
                 <div class="form-group">
          <p class="col-md-24 ">修改回答</p>
          <div class="col-md-16">
            <div id="introContent">
              <!--{template editor}-->
                    </div>
          </div>
        </div>
            
                <!--{if $user['grouptype']!=1&&$setting['code_ask']&&$user['credit1']<$setting['jingyan']}-->
                  <!--{template code}-->
          <!--{/if}-->
          
         <div class="form-group">
          <div class=" col-md-10">
        
                    <input type="hidden" value="{$aid}" id="buchong_aid" name="aid"/>
             <input type="button" id="submit" name="submit" class="btn btn-success" value="保存" data-loading="稍候..."> 
            <a class="btn btn-default mar-ly-1" onclick="window.history.go(-1)">返回</a>
          </div>
        </div>
            </div>	
        </form>
  </div>
  
   <div class="col-sm-4">
   <!--广告位5-->
        <!--{if (isset($adlist['question_view']['right1']) && trim($adlist['question_view']['right1']))}-->
        <div>{$adlist['question_view']['right1']}</div>
        <!--{/if}-->
  </div>
</div>
</div>
<script>

$("#submit").click(function(){
	//var eidtor_content= editor.getContent();
	 var eidtor_content='';
	 if(typeof testEditor != "undefined"){
     	  var tmptxt=$.trim(testEditor.getMarkdown());
     	  if(tmptxt==''){
     		  alert("回答内容不能为空");
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
	    	$(".progress").removeClass("hide");
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
	    	   new $.zui.Messager(tmpmsg, {
	    		   type: 'success',
	    		   close: true,
	       	    placement: 'center' // 定义显示位置
	       	}).show();
	    	   setTimeout(function(){
	               window.location.href=data.url;
	           },1500);
	       }else{
	    	   new $.zui.Messager(data.message, {
	        	   close: true,
	        	    placement: 'center' // 定义显示位置
	        	}).show();
	       }
	      
	     
	    }   ,
	    //调用执行后调用的函数
	    complete: function(XMLHttpRequest, textStatus){
	    	$(".progress").addClass("hide");
	    },
	    //调用出错执行的函数
	    error: function(){
	        //请求出错处理
	    }         
	 });
})
</script>
<!--{template footer}-->