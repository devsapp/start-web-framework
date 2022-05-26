<!--{template header}-->
<style>
.fly-header {
	z-index: 4;
}
</style>
<div class="layui-container fly-marginTop">
	<div class="fly-panel" pad20 style="padding-top: 5px;">
		<div class="layui-form layui-form-pane">
			<div class="layui-tab layui-tab-brief" lay-filter="user">
				<ul class="layui-tab-title">
					<li class="layui-this">发表文章</li>
				</ul>
				<div class="layui-form layui-tab-content" id="LAY_ucm"
					style="padding: 20px 0;">
					<div class="layui-tab-item layui-show">
						<form action="{url user/addxinzhi}" method="post"
							enctype="multipart/form-data" method="POST" name="askform"
							id="askform">
							<div class="layui-row layui-col-space15 layui-form-item">
								<div class="layui-col-md3">
									<label class="layui-form-label">所在话题</label>
									<div class="layui-input-block" style="z-index: 3">
										<select lay-verify="required" name="qcategory" id="qcategory"
											lay-filter="qcategory"> {eval $this->load->model ("category_model" );} 
											{eval	$categorylist=$this->category_model->get_categrory_tree(2,0);echo $categorylist;}

										</select>
									</div>
								</div>
								<div class="layui-col-md9">
									<label for="L_title" class="layui-form-label">文章标题</label>
									<div class="layui-input-block">
										<input type="text" name="title" id="qtitle" required
											lay-verify="required" autocomplete="off" class="layui-input">

									</div>
								</div>
							</div>

							<div class="layui-form-item layui-form-text">
								<label for="L_title" class="layui-form-label">文章内容</label>
								<div class="layui-input-block">
									<!--{template editor}-->
								</div>
							</div>
							<div class="layui-form-item">
								
								<div class="layui-input-block" style="margin-left:0px;">
									<div id="preview" style="overflow: visible">
										<!--{if isset($topic['image'])}-->
										{eval $index=strpos($topic['image'],'http');} {if $index==0 }

										<img class="img-thumbnail" data-toggle="lightbox"
											data-image="{$topic['image']}"
											data-caption="{$topic['title']}" id="imghead"
											src="{$topic['image']}" width="489" height="240" />&nbsp;&nbsp;&nbsp;
										{else} <img class="img-thumbnail" data-toggle="lightbox"
											data-image="{SITE_URL}{$topic['image']}"
											data-caption="{$topic['title']}" id="imghead"
											src="{SITE_URL}{$topic['image']}" width="489" height="240" />&nbsp;&nbsp;&nbsp;

										{/if}


										<!--{else}-->

										<img class="img-thumbnail"
											style="width: 288px; height: 192px;"
											data-caption="{$topic['title']}" id="imghead"
											style="max-height: 300px;" border=0
											src='{SITE_URL}static/css/dist/css/images/default.jpg'>
										<!--{/if}-->

									</div>
								</div>
								<div class="layui-form-mid layui-word-aux">
									<div class="layui-btn layui-btn-sm" style="pisition:relative;"><input type="file" id="layer_upload"
										onchange="previewImage(this)" name="image"
										title="点击这选择封面图片，大小建议288px*192px,或者填封面图外部链接"
										style="opacity: 1; height: 40px; position: relative; "></div>
								
										<div onclick="getimg()" class="layui-btn layui-btn-primary layui-btn-sm">提取内容封面图</div>
										
								</div>
							</div>
							<div class="layui-form-item">
								<label class="layui-form-label">文章权限</label>
								<div class="layui-input-inline">
									<select name="readmode" id="readmode" lay-verify="required"
										lay-filter="readmode">
										<option value="1">免费阅读</option>
										<option value="2">{$caifuzhiname}阅读</option> {if $setting['openwxpay']==1}
										<option value="3">现金阅读</option> {/if}

									</select>
								</div>
							</div>

							<div class="layui-form-item paymodeltype hide">
								<label class="layui-form-label">阅读付费</label>
								<div class="layui-input-inline">
									<input type="number" AUTOCOMPLETE="OFF" id="topic_price"
										name="topic_price" value="0" size="100" required
										lay-verify="required" placeholder="阅读值" autocomplete="off"
										class="layui-input txt_price">
								</div>
								<div class="layui-form-mid layui-word-aux unittext"></div>
							</div>
							<div class="layui-form-item layui-form-text paymodeltype hide">
								<label class="layui-form-label">免费内容</label>
								<div class="layui-input-block">
									<textarea name="freeconent" id="freeconent" placeholder="请输入内容"
										class="layui-textarea"></textarea>
								</div>
							</div>
							<div class="layui-form-item">
								<label class="layui-form-label">封面图地址:</label>
								<div class="layui-input-block">
									<input type="text" AUTOCOMPLETE="OFF" id="outimgurl"
										name="outimgurl"
										value="{SITE_URL}static/css/dist/css/images/default.jpg"
										required lay-verify="required" placeholder="封面图地址"
										autocomplete="off" class="layui-input">
								</div>
							</div>
							<div class="layui-form-item">
								<input type="hidden" name="topicclass"
									value="{$topic['articleclassid']}" id="topicclass" /> <input
									type="hidden" name="upimg" id="upimg" value="{$topic['image']}" />
								<input type="hidden" name="views" value="{$topic['views']}" />
								{if isset($topic['id'])} <input type="hidden"
									value="{$topic['id']}" name="id" /> <input type="hidden"
									value="{$topic['isphone']}" name="isphone" /> <input
									type="hidden" value="{$topic['image']}" name="image" /> {/if} <input
									type="hidden" name="usersid" value='{$_SESSION["userid"]}' /> <input
									type="hidden" id="topic_tag" name="topic_tag" value='' />
								<button class="layui-btn" type="submit" id='article_btn'
									name="submit">立即发布</button>
								
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
{if $setting['register_on']=='1'} {if
$user['uid']>0&&$user['active']!=1}

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
{/if} {/if}
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
	    form.on('select(readmode)', function(data){   
		      var val=data.value;
		    var obj = $("#readmode").find("option:selected");
		    var _currentval=obj.val();
		
		    switch(_currentval){
		    case '1':
		 	   $(".paymodeltype,.freecontent").addClass("hide");
		 	   $(".unittext").html("{$caifuzhiname}");
		 	   break;
		    case '2':
		 	   $(".paymodeltype,.freecontent").removeClass("hide");
		 	   $(".unittext").html("{$caifuzhiname}");
		 	   break;
		    case '3':
		 	   $(".paymodeltype,.freecontent").removeClass("hide");
		 	   $(".unittext").html("元");
		 	   break;
		    }

	    });
	    form.on('select(qcategory)', function(data){   
	      var val=data.value;
	    var obj = $("#qcategory").find("option:selected");
	    var _currentval=obj.val();
	    var _currentgrade=obj.attr("grade");
	    var _currentpid=obj.attr("pid");
	    $("#topicclass").val(_currentval);
	   
           });
	    window.getimg=function (){

	   	 var _html='';
	   		if(isueditor==1){
	   			_html = editor.getContent();
	   		}else{
	   			_html = editor.wang_txt.html();
	   		}

	   	var firstimg=$(_html).find("img");
	   	if(firstimg.length>0){
	   		
	   		$("#imghead").attr("src",firstimg[0].src);

	   		$("#imghead").attr("data-image",firstimg[0].src);
	   		$("#outimgurl").val(firstimg[0].src);
	   	}else{
layer.msg("文章内容中没有图片")
	   	}

	   }

        //图片上传预览    IE是用了滤镜。
window.previewImage=function (file)
{
  var MAXWIDTH  = 300;
  var MAXHEIGHT = 240;
  var div = document.getElementById('preview');
  if (file.files && file.files[0])
  {
      div.innerHTML =' <a target="_blank" id="imgshowlink" href="" data-toggle="lightbox" data-group="image-group-1"><img class="img-thumbnail" id=imghead></a>';
      var img = document.getElementById('imghead');
      img.onload = function(){
        var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
        img.width  =  rect.width;
        img.height =  rect.height;
//         img.style.marginLeft = rect.left+'px';
        img.style.marginTop = rect.top+'px';
      }
      var reader = new FileReader();
      reader.onload = function(evt){
    	  img.src = evt.target.result;
    	  $("#imghead").attr("data-img",evt.target.result);
    	  $("#imgshowlink").attr("href",evt.target.result);

      }
      reader.readAsDataURL(file.files[0]);
  }
  else //兼容IE
  {
    var sFilter='filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src="';
    file.select();
    var src = document.selection.createRange().text;
    div.innerHTML = '<img class="img-thumbnail" data-caption="" data-toggle="lightbox" id=imghead>';
    var img = document.getElementById('imghead');
    img.filters.item('DXImageTransform.Microsoft.AlphaImageLoader').src = src;
    var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
    status =('rect:'+rect.top+','+rect.left+','+rect.width+','+rect.height);
    div.innerHTML = "<div id=divhead style='width:"+rect.width+"px;height:"+rect.height+"px;margin-top:"+rect.top+"px;"+sFilter+src+"\"'></div>";
  }
}
window.clacImgZoomParam=function ( maxWidth, maxHeight, width, height ){
    var param = {top:0, left:0, width:width, height:height};
    if( width>maxWidth || height>maxHeight )
    {
        rateWidth = width / maxWidth;
        rateHeight = height / maxHeight;

        if( rateWidth > rateHeight )
        {
            param.width =  maxWidth;
            param.height = Math.round(height / rateWidth);
        }else
        {
            param.width = Math.round(width / rateHeight);
            param.height = maxHeight;
        }
    }

    param.left = Math.round((maxWidth - param.width) / 2);
    param.top = Math.round((maxHeight - param.height) / 2);
    return param;
}
        var submitfalse=false;
        //layui-btn-disabled和submitfalse同时拦截防止重复提交
	   $("#article_btn").click(function(){
		   if(  $("#article_btn").hasClass("layui-btn-disabled")){
			   return false;
		   }
		 
		    if(submitfalse){
                return false;
		    }
		    submitfalse=true;
		    if($("#topicclass").val()==0){
		    	var obj = $("#qcategory").find("option:selected");
			    var _currentval=obj.val();
			    var _currentgrade=obj.attr("grade");
			    var _currentpid=obj.attr("pid");
			    $("#topicclass").val(_currentval)
		    }
		 

       	 var qtitle = $("#qtitle").val();



            if (bytes($.trim(qtitle)) < 8 || bytes($.trim(qtitle)) > 100) {
            	submitfalse=false;
           	 $("#article_btn").removeClass("layui-btn-disabled");
            	layer.msg("问题标题长度不得少于4个字，不能超过50字！");

                $("#qtitle").focus();
                return false;
            }
       

       	 //var eidtor_content= editor.getContent();
           	 var eidtor_content='';
           	 if(typeof testEditor != "undefined"){
              	  var tmptxt=$.trim(testEditor.getMarkdown());
              	  if(tmptxt==''){
              		 $("#article_btn").removeClass("layui-btn-disabled");
              		submitfalse=false;
              		  layer.msg("文章内容不能为空");
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
             if(eidtor_content==''){
            	 $("#article_btn").removeClass("layui-btn-disabled");
            	 submitfalse=false;
         		  layer.msg("文章内容不能为空");
         		  return false;
         	  }
           
  		   
       })
	});
             


                </script>
<!--{template footer}-->

