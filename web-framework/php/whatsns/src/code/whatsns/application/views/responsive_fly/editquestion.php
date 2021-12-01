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
          <li class="layui-this">编辑问题</li>
        </ul>
        <div class="layui-form layui-tab-content" id="LAY_ucm" style="padding: 20px 0;">
          <div class="layui-tab-item layui-show">
            <form action=""   enctype="multipart/form-data" method="POST"  name="askform" id="askform" >
              <div class="layui-row layui-col-space15 layui-form-item">
                <div class="layui-col-md3">
                  <label class="layui-form-label">所在话题</label>
                  <div class="layui-input-block" style="z-index:3">
                    <select lay-verify="required" name="qcategory" id="qcategory" lay-filter="qcategory"> 
                      {eval $this->load->model ( "category_model" );}
                      {eval $categorylist1=$this->category_model->get_categrory_tree(1,0);echo $categorylist1;}
                   
                    </select>
                  </div>
                </div>
                <div class="layui-col-md9">
                  <label for="L_title" class="layui-form-label">标题</label>
                  <div class="layui-input-block">
                    <input type="text" name="title" id="qtitle" value="{$question['title']}" required lay-verify="required" autocomplete="off" class="layui-input">
                  
                  </div>
                </div>
              </div>
        
              <div class="layui-form-item layui-form-text">
                <div class="layui-input-block">
                    <!--{template editor}-->
                </div>
              </div>
       
                  <!--{if $setting['code_ask']&&$user['credit1']<$setting['jingyan']}-->
      
 {template code}
 
   <!--{/if}-->
   
             
              <div class="layui-form-item">
                             <input type="hidden" name="cid" id="cid" value="{$question['cid']}" />
                    <input type="hidden" name="cid1" id="cid1" value="{$question['cid1']}"/>
                    <input type="hidden" name="cid2" id="cid2" value="{$question['cid2']}"/>
                    <input type="hidden" name="cid3" id="cid3" value="{$question['cid3']}"/>
                          <input type="hidden" value="{$qid}" id="bianji_qid" name="qid" />
                <div id="submit" name="submit"  class="layui-btn"  id="asksubmit">立即发布</div>
                        
                            
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

layui.use(['jquery', 'layer','form'], function(){ 
  var $ = layui.$ //重点处
  ,layer = layui.layer;

    form=layui.form;
    $("#qcategory option[value='"+$("#cid").val()+"']").prop("selected", true);
    $(".layui-unselect").val("{$question['category_name']}");
    form.on('select(qcategory)', function(data){   
	      var val=data.value;
	    var obj = $("#qcategory").find("option:selected");
	    var _currentval=obj.val();
	    var _currentgrade=obj.attr("grade");
	    var _currentpid=obj.attr("pid");
	  
	    var cid=_currentval;
	    var cid1=0;
	    var cid2=0;
	    var cid3=0;
	    switch(_currentgrade){
	    case '1':
	    	cid1=cid;
	    	cid2=0;
	    	cid3=0;
		    break;
	    case '2':
	    	cid1=$('#qcategory option[value='+_currentpid+']').val();
	    	cid2=cid;
	    	cid3=0;
		    break;
	    case '3':
	    	
	    	cid2=$('#qcategory option[value='+_currentpid+']').val();
	    	cid1=$('#qcategory option[value='+cid2+']').attr('pid');
	    	cid3=cid;
		    break;
	    }
	    $("#cid").val(cid);
	    $("#cid1").val(cid1);
	    $("#cid2").val(cid2);
	    $("#cid3").val(cid3);
	
         });
      var submitfalse=false;
      $("#submit").click(function(){
              if(submitfalse){
return;
              }
              var _tagstr='';
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
    		   <!--{if $user['grouptype']!=1}-->
    		  var data={
    				  title:$("#qtitle").val(),
    				  content:eidtor_content,
    				 qid:$("#bianji_qid").val(),
    				 submit:$("#submit").val(),
    				 cid:$("#cid").val(),
    				  cid1:$("#cid1").val(),
    				  cid2:$("#cid2").val(),
    				  cid3:$("#cid3").val(),
    				  tags:_tagstr,
    				  askfromuid:$("#askfromuid").val(),
    	  			
    	  			code:$("#code").val()
    	  	}
    		    <!--{else}-->
    			var data={
    					  title:$("#qtitle").val(),
    					  qid:$("#bianji_qid").val(),
    					  submit:$("#submit").val(),
    					  cid:$("#cid").val(),
    					  tags:_tagstr,
    	    			  cid1:$("#cid1").val(),
    	    			  cid2:$("#cid2").val(),
    	    			  cid3:$("#cid3").val(),
    	    			 content:eidtor_content
    	    			 
    	    			
    	      			
    	      			
    	    			
    	    	}
    		     <!--{/if}-->
    		  

    		$.ajax({
    	        //提交数据的类型 POST GET
    	        type:"POST",
    	        //提交的网址
    	        url:"{url question/ajaxedit}",
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
    	        	
    	        	var data=eval("("+data+")");
    	           if(data.message=='ok'){
    	        	   submitfalse=true;
    	        	   var tmpmsg='问题编辑成功!';
    	        	  
    	        	  layer.msg(tmpmsg);
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
