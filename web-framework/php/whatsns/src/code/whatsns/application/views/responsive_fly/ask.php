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
          <li class="layui-this">发表新问题</li>
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
                      {eval $categorylist=$this->category_model->get_categrory_tree(1,0);echo $categorylist;}
                   
                    </select>
                  </div>
                </div>
                <div class="layui-col-md9">
                  <label for="L_title" class="layui-form-label">标题</label>
                  <div class="layui-input-block">
                    <input type="text" name="title" id="qtitle" required lay-verify="required" autocomplete="off" class="layui-input">
                  
                  </div>
                </div>
              </div>
        
              <div class="layui-form-item layui-form-text">
                <div class="layui-input-block">
                    <!--{template editor}-->
                </div>
              </div>
              <div class="layui-form-item">
                <div class="layui-inline">
                  <label class="layui-form-label">悬赏财富</label>
                  <div class="layui-input-inline" style="width: 190px;">
                    <select name="givescore" id="scorelist">
                    <option value="0">0</option>
                      <option value="5">5</option>
                       <option value="10">10</option>
                         <option value="20">20</option>
                      <option value="30">30</option>
                      <option value="50">50</option>
                      <option value="60">60</option>
                      <option value="80">80</option>
                      <option value="100">100</option>
                    </select>
                  </div>
                  <div class="layui-form-mid layui-word-aux">发表后无法更改财富值</div>
                </div>
              </div>
                  <!--{if $setting['code_ask']&&$user['credit1']<$setting['jingyan']}-->
      
 {template code}
 
   <!--{/if}-->
   
             
              <div class="layui-form-item">
                          <input type="hidden" name="asksid" id="asksid" value='{$_SESSION["asksid"]}'/>
                     <input type="hidden" name="authoryue" id="authoryue" value="{echo trim($user['jine']/100);}"/>
            <input type="hidden" name="myseek" id="myseek" value=""/>
                    <input type="hidden" name="cid" id="cid"/>
					   <input type="hidden"  name="xianjin" id="qxianjin" value="0" />
                    <input type="hidden" name="cid1" id="cid1" value="0"/>
                    <input type="hidden" name="cid2" id="cid2" value="0"/>
                    <input type="hidden" name="cid3" id="cid3" value="0"/>
                    <input type="hidden" value="{$askfromuid}" id="askfromuid" name="askfromuid" />
                          <input type="hidden" id="tokenkey" name="tokenkey" value='{$_SESSION["addquestiontoken"]}'/>
               
                    <!--{if $touser}-->
                         <!--{if $touser['mypay']>0}-->
                  <div class="layui-btn"  id="asksubmit"><i class="layui-icon layui-icon-rmb"></i>付费{$touser['mypay']}元提问</div>
  
                          <!--{else}-->
                                          <div class="layui-btn"  id="asksubmit">立即发布</div>
                           
                            <!--{/if}-->

               <!--{else}-->
                <div class="layui-btn"  id="asksubmit">立即发布</div>
                         
                            <!--{/if}-->
                            
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
{if $setting['register_on']=='1'}
{if $user['uid']>0&&$user['active']!=1}

<script>
var text='<p>由于网站设置，需要设置邮箱并且激活邮箱才能提问,回答，发布文章等一系列操作.</p>';
layui.use([ 'layer'], function(){
	
	  var layer = layui.layer;
	layer.open({
	    type: 1
	    ,offset:  'auto' 
	    ,content: '<div style="padding: 10px;">'+ text +'</div>'
	    ,btn: '激活邮箱'
	    ,btnAlign: 'c' //按钮居中
	    ,shade: 0 //不显示遮罩
	    ,yes: function(){
	     window.location.href="{url user/editemail}";
	    }
	  });
});

</script>
{/if}
{/if}
  <script>
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
        //layui-btn-disabled和submitfalse同时拦截防止重复提交
	   $("#asksubmit").click(function(){
		   if(  $("#asksubmit").hasClass("layui-btn-disabled")){
			   return ;
		   }else{
			   $("#asksubmit").addClass("layui-btn-disabled");
		   }
		 
		    if(submitfalse){
                return ;
		    }
		    if($("#cid").val()==0){
		    	var obj = $("#qcategory").find("option:selected");
			    var _currentval=obj.val();
			    var _currentgrade=obj.attr("grade");
			    var _currentpid=obj.attr("pid");
			    $("#cid").val(_currentval);
			    $("#cid1").val(_currentval);
			    $("#cid2").val(0);
			    $("#cid3").val(0);
		    }
		 
       	 var _tagstr='';
       	
       	 var qtitle = $("#qtitle").val();

       	    var money_reg = /\d{1,4}/;
               var _money = $("#qxianjin").val();
               if('' == _money){
               	_money=0;
               }


            if (bytes($.trim(qtitle)) < 8 || bytes($.trim(qtitle)) > 100) {
      		  $("#asksubmit").removeClass("layui-btn-disabled");
            	layer.msg("问题标题长度不得少于4个字，不能超过50字！");

                $("#qtitle").focus();
                return false;
            }
       
            {if $user['uid']}
            //检查财富值是否够用
            var offerscore = 0;
            var selectsocre = $("#givescore").val();
            if ($("#hidanswer:selected").val() == 1) {
                offerscore += 10;
            }
            offerscore += parseInt(selectsocre);
            if (offerscore > $user['credit2']) {
      		  $("#asksubmit").removeClass("layui-btn-disabled");
           	 layer.msg("你的财富值不够!")
                    return false;
            }
            
            {/if}

       	 //var eidtor_content= editor.getContent();
           	 var eidtor_content='';
           	 if(typeof testEditor != "undefined"){
              	  var tmptxt=$.trim(testEditor.getMarkdown());
              	  if(tmptxt==''){
              		  $("#asksubmit").removeClass("layui-btn-disabled");
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
       	 var _hidanswer=0;
       	 if ($('#hidanswer').is(':checked')) {
       		 _hidanswer=1;
       	 }else{
       		 _hidanswer=0;
       	 }


       	  <!--{if $setting['code_ask']}-->
       	  var data={
       			  title:$("#qtitle").val(),
       			  description:eidtor_content,
       			  cid:$("#cid").val(),
       			  cid1:$("#cid1").val(),
       			  cid2:$("#cid2").val(),
       			  cid3:$("#cid3").val(),
       			  givescore:$("#scorelist").val(),
       			  hidanswer:_hidanswer,
       			  askfromuid:$("#askfromuid").val(),
       			  tokenkey:$("#tokenkey").val(),
         			  jine:_money,
         			  tags:_tagstr,
         			code:$("#code").val()
         	}
       	    <!--{else}-->
       		var data={
       				  title:$("#qtitle").val(),
           			  description:eidtor_content,
           			  cid:$("#cid").val(),
           			  cid1:$("#cid1").val(),
           			  cid2:$("#cid2").val(),
           			  cid3:$("#cid3").val(),
           			  tokenkey:$("#tokenkey").val(),
           			  jine:_money,
           			  tags:_tagstr,
           			  givescore:$("#scorelist").val(),
           			  hidanswer:_hidanswer,
           			  askfromuid:$("#askfromuid").val()



           	}
       	     <!--{/if}-->


       	$.ajax({
               //提交数据的类型 POST GET
               type:"POST",
               //提交的网址
               url:"{url question/ajaxadd}",
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
            	   $("#asksubmit").removeClass("layui-btn-disabled");
               	var data=eval("("+data+")");
                  if(data.message=='ok'){
                	  submitfalse=true;
               	   var tmpmsg='提问成功!';
               	   if(data.sh=='1'){
               		   tmpmsg='问题发布成功！为了确保问答的质量，我们会对您的提问内容进行审核。请耐心等待......';
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
            	   submitfalse=false;
               },
               //调用出错执行的函数
               error: function(){
            	   $("#asksubmit").removeClass("layui-btn-disabled");
                   //请求出错处理
               }
            });
       })
	});
             


                </script>
<!--{template footer}-->