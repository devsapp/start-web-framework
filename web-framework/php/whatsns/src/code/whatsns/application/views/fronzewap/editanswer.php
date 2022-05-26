<!--{template meta}-->

<div class="container  mar-t-1 mar-b-1">
<div class="row">
  <div class="col-sm-24">
 

    <form  class="form-horizontal mar-t-05"  name="answerform" method="post" >
            <div class="askbox">
               
                
                 <div class="form-group">
          <p class="col-md-24 form-title">修改回答</p>
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
           <div class="ui-btn-wrap">
        
                    <input type="hidden" value="{$aid}" id="buchong_aid" name="aid"/>
             <button type="button" id="submit" name="submit" class="ui-btn ui-btn-primary"  data-loading="稍候...">保存</button> 
            <a class="ui-btn" onclick="window.history.go(-1)">返回</a>
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
	// 获取编辑器区域
    var _txt = editor.wang_txt;
 // 获取 html
    var eidtor_content =  _txt.html();
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
	    	 alert(tmpmsg);
	    	   setTimeout(function(){
	               window.location.href=data.url;
	           },1500);
	       }else{
	    	  alert(data.message)
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
