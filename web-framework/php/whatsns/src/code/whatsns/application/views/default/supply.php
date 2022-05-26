<!--{template header}-->
<!--{template banner}-->
<script type="text/javascript" src="{SITE_URL}static/js/neweditor/ueditor.config.js"></script> 
<script type="text/javascript" src="{SITE_URL}static/js/neweditor/ueditor.all.min.js"></script> 
<div class="container  ">
<div class="row">
  <div class="col-sm-8">
  <div class="nav-line"><a class="first" href="{SITE_URL}">{$setting['site_name']}</a> &gt; <a href="{url question/view/$question['id']}">{$question['title']}</a> &gt; <span>问题补充</span></div>
    <form  class="form-horizontal" name="askform" method="post">
            <div class="askbox">
                 <input type="hidden" value="{$qid}"  id="buchong_qid"  name="qid" />
                
                 <div class="form-group">
          <label class="col-md-2 control-label">编辑</label>
          <div class="col-md-6">
            <div id="introContent">
           <!--{template editor}-->
                    </div>
          </div>
        </div>
            
                  <!--{if $user['grouptype']!=1&&$setting['code_ask']&&$user['credit1']<$setting['jingyan']}-->
                       <div class="form-group">
          <label class="col-md-2 control-label">验证码</label>
          <div class="col-md-4">
             <input type="text" autocomplete="OFF"  id="code" name="code" onblur="check_code();"  value="" class="form-control">
             <div  id="codetip" class="help-block alert alert-warning ">验证码不能为空</div>
          </div>
        </div>
          <div class="form-group">
          <div class="col-md-2 col-md-offset-2">
            <span class="verifycode"><img class="hand" src="{url user/code}" onclick="javascript:updatecode();" id="verifycode">
                        </span>
          </div>
          <div class="col-md-1">
              <a class="changecode" href="javascript:updatecode();">&nbsp;看不清?</a>
          </div>
        </div>
          <!--{/if}-->
          
         <div class="form-group">
          <div class="col-md-offset-2 col-md-10">
        
                    <input type="hidden" value="{$aid}"  id="buchong_aid" name="aid"/>
             <input type="button" id="submit" name="submit" class="btn btn-danger" value="保存" data-loading="稍候..."> 
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
	 var eidtor_content = editor.wang_txt.html();
	var data={
    			content:eidtor_content,
    			qid:$("#buchong_qid").val(),
    			aid:$("#buchong_aid").val(),
    			code:$("#code").val()
    			
    	}
	
	$.ajax({
	    //提交数据的类型 POST GET
	    type:"POST",
	    //提交的网址
	    url:"{url question/ajaxsupply}",
	    //提交的数据
	    data:data,
	    //返回数据的格式
	    datatype: "json",//"xml", "html", "script", "json", "jsonp", "text".
	    //在请求之前调用的函数
	    beforeSend:function(){},
	    //成功返回之后调用的函数             
	    success:function(data){
	    	var data=eval("("+data+")");
	       if(data.message=='ok'){
	    	   new $.zui.Messager('回答成功!', {
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
	       
	    },
	    //调用出错执行的函数
	    error: function(){
	        //请求出错处理
	    }         
	 });
})
</script>
<!--{template footer}-->