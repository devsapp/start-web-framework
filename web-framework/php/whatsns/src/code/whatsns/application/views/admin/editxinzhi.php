<!--{template header}-->
    <link rel="stylesheet" media="all" href="{SITE_URL}static/css/widescreen/css/greencommon.css" />
<link rel="stylesheet" media="all" href="{SITE_URL}static/css/common/commtag.css" />
<!--用户中心-->
<style>
.header {
    position: fixed;
    background: #fff;
    width: 100%;
    left: 0px;
    top: 0px;
    z-index: 8;
    -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.05);
    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.05);
}
body {
   padding-top: 0px;
}
.has-error .form-control {
    border-color: #00a65a;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
}
</style>
<div class="user-home bg-white" style="margin-bottom: 40px">
    <div class=" index" style="margin:10px 20px 20px 50px;padding-right:30px;">
 <form name="articleform"  class="form-horizontal mar-t-1" action="{url admin_topic/edit}"  method="post" enctype="multipart/form-data">
    <div class="row main">
                 <div class="col-md-20">
                     <div class="dongtai">
                         <p>
                             <strong class="font-18">编辑文章</strong>
                         </p>
                         <hr>

                       <input type="hidden" name="topicclass" value="{$topic['articleclassid']}" id="topicclass"/>
       <input type="hidden" name="upimg" id="upimg" value="{$topic['image']}"/>
             <input type="hidden" name="views" value="{$topic['views']}"/>
     {if isset($topic['id'])}
    <input type="hidden" value="{$topic['id']}" name="id" />
     <input type="hidden" value="{$topic['isphone']}" name="isphone" />
    <input type="hidden" value="{$topic['image']}" name="image" />
    {/if}

         <div class="form-group">

          <div class="col-md-24 has-error">
            <input type="text" name="title" value="{echo trim($topic['title']);}" class="form-control mytitle" placeholder="文章标题不能为空">
           
            <div class="help-block alert alert-primary ">


     <div class="bar_l">

                        <span><a  class="btn btn-success"  id="changecategory" href="javascript:showcategory()">选择文章分类</a>
                     <span id="selectedcate" class="selectedcate mar-lr-1">$catmodel['name']</span>
 </span>
   </div>
            </div>
          </div>
        </div>
         <div class="form-group">
             <div class="form-group">
          <p class="col-md-24  text-left fl"> 文章标签设置，最多5个:</p>
          <div class="col-md-24 has-error">
           
          <div class=" dongtai ">
          <div class="tags">
          {loop $topic['tags'] $tag}
             <div class="tag"><span tagid="{$tag['id']}">{$tag['tagname']}</span><i class="fa fa-close"></i></div>
             {/loop}
          </div>
            <input type="text" autocomplete="off"  data-toggle="tooltip" data-placement="bottom" title="" placeholder="检索标签，最多添加5个,添加标签更容易被回答" data-original-title="检索标签，最多添加5个" name="topic_tagset" value=""  class="txt_taginput" >
            <i class="fa fa-search"></i>
           <div class="tagsearch">
        
          
           </div>
            
          </div>
          </div>
        </div>
                       <div class="form-group">
          <p class="col-md-24  text-left fl">文章描述:</p>
          <div class="col-md-24 has-error">
<script type="text/javascript" src="{SITE_URL}static/js/neweditor/ueditor.config.js"></script>
<script type="text/javascript" src="{SITE_URL}static/js/neweditor/ueditor.all.js"></script>
         <script type="text/plain" id="editor"  name="content"  style="width:100%;height:200px;">

 {$topic['describtion']}

</script>
                                 <script type="text/javascript">
                                 var isueditor=1;
            var editor = UE.getEditor('editor',{
                //这里可以选择自己需要的工具按钮名称,此处仅选择如下五个
                toolbars:[[{$setting['editor_toolbars']}]],
            
                initialContent:'',
            

                //关闭字数统计
                wordCount:false,
                //关闭elementPath
                elementPathEnabled:false,
                //默认的编辑区域高度
                initialFrameHeight:150
                //更多其他参数，请参考ueditor.config.js中的配置项
                //更多其他参数，请参考ueditor.config.js中的配置项
            });

        </script>

          </div>
        </div>






                     </div>


                 </div>
 <div class="col-md-12">

  <div >

<p>封面图:</p>
  <div class="form-group">

        <div class="col-md-24">
         <div id="preview" style="overflow:visible">
  <!--{if isset($topic['image'])}-->
   {eval $index=strpos($topic['image'],'http');}
                     {if $index==0 }

                           <img class="img-thumbnail" data-toggle="lightbox"  data-image="{$topic['image']}" data-caption="{$topic['title']}"  id="imghead" src="{$topic['image']}" width="300" height="240"/>&nbsp;&nbsp;&nbsp;
                            {else}
                        <img class="img-thumbnail" data-toggle="lightbox"  data-image="{SITE_URL}{$topic['image']}" data-caption="{$topic['title']}"  id="imghead" src="{SITE_URL}{$topic['image']}" width="300" height="240"/>&nbsp;&nbsp;&nbsp;

                            {/if}


  <!--{else}-->

    <img class="img-thumbnail" style="width:300px;height:240px;" data-caption="{$topic['title']}" id="imghead" style="max-height: 300px;"  border=0 src='{SITE_URL}static/css/dist/css/images/default.jpg'>
    <!--{/if}-->

</div>
  <div class="add-img-box row">
  <div class="col-sm-12">
    <span class="add-img" >
  <a id="layerUploadButton"></a></span>
  <div class="add-img-html5" style=""><span>
  </span><a class="text-danger" href="###"  data-toggle="tooltip" data-placement="bottom" title="点击这选择封面图片，大小建议300px*240px,或者填封面图外部链接" style="font-size:12px;cursor:pointer;margin-top:3px;"><i class="fa fa-image" ></i>上传封面图
  </a>
  <input type="file" id="layer_upload" onchange="previewImage(this)" name="image" title="点击这选择封面图片，大小建议300px*240px,或者填封面图外部链接" style="opacity: 0;height: 40px;position:relative;top:-2rem;">

  </div>
  </div>

  </div>
 <div class="col-sm-12" style="margin-bottom: 20px;">
  <span>文章访问量</span>
     <input type="number" name="views" value="{$topic['views']}" class="form-control views" style="width:150px;display:inline-block;" placeholder="文章访问量设置">
           次
 </div>
  <div class="add-img-box row" style="margin-bottom: 20px">
  <div class="col-sm-5">
  <span> &nbsp;&nbsp;付费模式:</span>
    <select class="form-control" name="readmode" id="readmode" style="width:150px;display:inline-block;">
    <option value="1" {if $topic['readmode']==1}selected{/if}>免费阅读</option>
    <option value="2" {if $topic['readmode']==2}selected{/if}>财富值阅读</option>
   
    </select>
     </div>
  </div>
 <div class="add-img-box row">

        <div class="col-sm-12 paymodeltype {if $topic['price']==0}hide{/if}">
     <div class="price_set" data-toggle="tooltip" data-placement="bottom" title=""  data-original-title="默认不需要付费可以阅读">
     <span>阅读需要</span>
      <input type="number" AUTOCOMPLETE="OFF" id="topic_price" name="topic_price" value="{$topic['price']}" size="100" class="txt_price" placeholder="可以留空">
           <span  class="unittext">{eval if ($topic['readmode']==2) echo '积分'; }{eval if ($topic['readmode']==3) echo '元'; }</span>
     </div>

     </div>
    
        <div class="col-sm-12 freecontent {if $topic['price']==0}hide{/if}" style="margin-bottom: 20px;">
        <p><b>试读内容:</b></p>

   <script type="text/plain" id="freeconent"  name="freeconent"  style="width:100%;height:200px;">{$topic['freeconent']}</script>                                 
<script type="text/javascript">
                                 var isueditor=1;
            var freedtior= UE.getEditor('freeconent',{
                //这里可以选择自己需要的工具按钮名称,此处仅选择如下五个
                toolbars:[[{$setting['editor_toolbars']}]],
            
                initialContent:'',
            
            
                //关闭字数统计
                wordCount:false,
                //关闭elementPath
                elementPathEnabled:false,
                //默认的编辑区域高度
                initialFrameHeight:250
                //更多其他参数，请参考ueditor.config.js中的配置项
                //更多其他参数，请参考ueditor.config.js中的配置项
            });

        </script>
   </div>

     <div class="col-sm-12" style="padding-top: 8px;margin-bottom: 20px;border:solid 1px #ebebeb;">
      <p>文章发布作者:<b>(当前作者:{$topic['author']})</b></p>
       {template box_majia,admin}  
 </div>
     <div class="col-sm-12">
     外部封面图地址:(<a class="text-danger" href="javascript:getimg()">点击内容提取</a>)
     <input type="text" AUTOCOMPLETE="OFF" id="outimgurl" name="outimgurl" value="{$topic['image']}" size="350" class="form-control" placeholder="如果不上传可以选择外部封面图片地址">

   </div>
   </div>
        </div>
        </div>
        <!-- -待续 -->

          <div class="form-group">
        <div class=" col-md-20">
 <input type="hidden" id="topic_tag" name="topic_tag" value="{$topic['topic_tag']}"/>
          <input type="hidden" name="usersid" value='{$_SESSION["userid"]}'/>
          <input type="hidden" id="articlecontent" name="articlecontent" value=''/>
                  <input type="hidden" name="pubauthor" id="pubauthor" value="{$topic['author']}" />
          <input type="hidden" id="articlefreecontent" name="articlefreecontent" value=''/>
  <input type="button" id='article_btn' class="btn btn-success width-120" onclick="checkform()" value="提 交">
   <input type="button" onclick="getimg()" style="background-color: #999;border-color: #ccc;" class="  width-120 mar-ly-1" name="tiquimage"  value="内容提取封面图">

        </div>
        </div>

 <div class="modal fade" id="myLgModal">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
         <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
        <h4 class="modal-title">选择分类</h4>
      </div>
         <div class="modal-body">
      <div id="dialogcate">
        <form name="editcategoryForm" action="{url question/movecategory}" method="post">
            <input type="hidden" name="qid" value="{$question['id']}" />
          
            <input type="hidden" name="category" id="categoryid" />
            <input type="hidden" name="selectcid1" id="selectcid1" value="{$question['cid1']}" />
            <input type="hidden" name="selectcid2" id="selectcid2" value="{$question['cid2']}" />
            <input type="hidden" name="selectcid3" id="selectcid3" value="{$question['cid3']}" />
            <table class="table table-striped">
                <tr valign="top">
                    <td width="125px">
                        <select  id="category1" class="catselect" size="8" name="category1" ></select>
                    </td>
                    <td align="center" valign="middle" width="25px"><div style="display: none;" id="jiantou1">>></div></td>
                    <td width="125px">
                        <select  id="category2"  class="catselect" size="8" name="category2" ></select>
                    </td>
                    <td align="center" valign="middle" width="25px"><div style="display: none;" id="jiantou2">>>&nbsp;</div></td>
                    <td width="125px">
                        <select id="category3"  class="catselect" size="8"  name="category3" ></select>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                    <span>
                    <input  type="button" id="layer-submit" class="btn btn-success" value="确&nbsp;认" onclick="selectcate();"/></span>
                    <span>
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    </span>
                    </td>

                </tr>
            </table>
        </form>
    </div>
      </div>
    </div>
  </div>
</div>
 </div>
 </div>

             </div>
               </form>

            </div>


        </div>


 <script src="{SITE_URL}static/css/widescreen/js/common.js"></script>
<!--用户中心结束-->
<script type="text/javascript">
$("#readmode").change(function(){
	   var readymodelval=$.trim($(this).val());
	   switch(readymodelval){
	   case '1':
		   $(".paymodeltype,.freecontent").addClass("hide");
		   $(".unittext").html("财富值");
		   break;
	   case '2':
		   $(".paymodeltype,.freecontent").removeClass("hide");
		   $(".unittext").html("财富值");
		   break;
	   case '3':
		   $(".paymodeltype,.freecontent").removeClass("hide");
		   $(".unittext").html("元");
		   break;
	   }
	    
	 });
$(".txt_taginput").on(" input propertychange",function(){
	 var _txtval=$(this).val();
	 if(_txtval.length>1){
	
		 //检索标签信息
		 var _data={tagname:_txtval};
		 var _url="{url tags/ajaxsearch}";
		 function success(result){
			 console.log(result)
			 if(result.code==200){
				 console.log(_txtval)
				  $(".tagsearch").html("");
				for(var i=0;i<result.taglist.length;i++){
			
					 var _msg=result.taglist[i].tagname
					 
			           $(".tagsearch").append('<div class="tagitem" tagid="'+result.taglist[i].id+'">'+_msg+'</div>');
				}
				$(".tagsearch").show();
				$(".tagsearch .tagitem").click(function(){
					var _tagname=$.trim($(this).html());
					var _tagid=$.trim($(this).attr("tagid"));
					if(gettagsnum()>=5){
						alert("标签最多添加5个");
						return false;
					}
					if(checktag(_tagname)){
						alert("标签已存在");
						return false;
					}
					$(".dongtai .tags").append('<div class="tag"><span tagid="'+_tagid+'">'+_tagname+"</span><i class='fa fa-close'></i></div>");
					$(".dongtai .tags .tag  .fa-close").click(function(){
						$(this).parent().remove();
					});
					$(".tagsearch").html("");
					$(".tagsearch").hide();
					$(".txt_taginput").val("");
					});
		        
			 }
			 
		 }
		 ajaxpost(_url,_data,success);
	 }else{
			$(".tagsearch").html("");
			$(".tagsearch").hide();
	 }
})
	function checktag(_tagname){
		var tagrepeat=false;
		$(".dongtai .tags .tag span").each(function(index,item){
			var _tagnametmp=$.trim($(this).html());
			if(_tagnametmp==_tagname){
				tagrepeat=true;
			}
		})
		return tagrepeat;
	}
	function gettaglist(){
		var taglist='';
		$(".dongtai .tags .tag span").each(function(index,item){
			var _tagnametmp=$.trim($(this).attr("tagid"));
			taglist=taglist+_tagnametmp+",";
			
		})
		taglist=taglist.substring(0,taglist.length-1);
	
		return taglist;
	}
	function gettagsnum(){
   return $(".dongtai .tags .tag").length;
	}
	$(".tagsearch .tagitem").click(function(){
		var _tagname=$.trim($(this).html());
		if(gettagsnum()>=5){
			alert("标签最多添加5个");
			return false;
		}
		if(checktag(_tagname)){
			alert("标签已存在");
			return false;
		}
		$(".dongtai .tags").append('<div class="tag"><span>'+_tagname+"</span><i class='fa fa-close'></i></div>");
		$(".dongtai .tags .tag  .fa-close").click(function(){
			$(this).parent().remove();
		});
		$(".tagsearch").html("");
		$(".tagsearch").hide();
		$(".txt_taginput").val("");
		});
	$(".dongtai .tags .tag  .fa-close").click(function(){
		$(this).parent().remove();
	});
$("#myLgModal .modal-dialog").css("width","460px");
window.onload=function(){
	$(".dongtai .title").focus();
}
function getimg(){
	 var _html='';
		if(isueditor==1){
			_html = editor.getContent();
		}else{
			_html = editor.wang_txt.html();
		}


	var firstimg=$(_html).find("img");

	if(firstimg!=null&&firstimg!='undefined'){
		if(!firstimg[0]){
			alert("内容无图片可提取");
			return false;
		}
		$("#imghead").attr("src",firstimg[0].src);
		$("#imghead").attr("data-image",firstimg[0].src);
		$("#outimgurl").val(firstimg[0].src);
	}else{
     alert("内容无图片可提取");
	}

}
    var category1 = {$categoryjs[category1]};
    var category2 = {$categoryjs[category2]};
    var category3 = {$categoryjs[category3]};
        $(document).ready(function() {
        initcategory(category1);




        });
        function selectcate() {
            var selectedcatestr = '';
            var category1 = $("#category1 option:selected").val();
            var category2 = $("#category2 option:selected").val();
            var category3 = $("#category3 option:selected").val();
            if (category1 > 0) {
                selectedcatestr = $("#category1 option:selected").html();
                $("#topicclass").val(category1);

            }
            if (category2 > 0) {
                selectedcatestr += " > " + $("#category2 option:selected").html();
                $("#topicclass").val(category2);

            }
            if (category3 > 0) {
                selectedcatestr += " > " + $("#category3 option:selected").html();
                $("#topicclass").val(category3);

            }
            $("#selectedcate").html(selectedcatestr);
            $("#changecategory").html("更改");
            $("#myLgModal").modal("hide");
        }
</script>



<script type="text/javascript">
function showcategory(){
	 $('#myLgModal').modal({
		 position    :100,
		    moveable : true,
		    show     : true
		})
}
function checkform(){
	var titleart=$.trim($(".mytitle").val());
	if(titleart==''){
		alert("标题不能为空");
return false;
	}
	 eidtor_content= editor.getContent();
		if(eidtor_content==''){
		alert("文章内容不能为空");
			 return false;
			
		}
		
	if(gettagsnum()>5){
        alert("最多添加5个标签");
        return false;
   	}
   	 var _tagstr=gettaglist();
   	 $("#topic_tag").val(_tagstr);

	 var v=$("#topicclass").val();
	var fv=$("#layer_upload").val();
	var upfv=$("#upimg").val();
	 var readymodelval=$.trim($("#readmode").val()); //阅读模式
	 var freeconentval=$.trim( freedtior.getContent());//试看内容
	//积分
	var _topic_price=$("#topic_price").val();
   
    	eidtor_content=eidtor_content.replace('<p><br></p>','');
    	
		if(eidtor_content==""){
			   alert("文章内容不能为空");
		  		 return false;
		}
	 if(readymodelval!='1'){
		  if(parseInt(_topic_price)==0){
	    	   alert("付费阅读值不能为0");
	    		 return false;
	       }
       if(freeconentval==''){
    	   alert("付费阅读试看内容不能为空");
  		 return false;
       }
     
	 }

        if(parseInt(_topic_price)<0){
       	 alert("财富值设置不能为负数");
		 return false;
        }
	 if(v==''){
		 alert("请选择文章分类");
		 showcategory();
		 return false;
	 }
	 if(slid==0){
			alert("请选择发布作者");
	return false;
		}
		switch(slid){
		case "1":
			currentansweruid="{$user['username']}";
		
			break;
			
		case "2":
			currentansweruid=$("#expertusername").find("option:selected").text();
		
			break;
		case "3":
			currentansweruid=$("#majiausername").find("option:selected").text();
			
			break;
		case "4":
			currentansweruid=$.trim($("#answerusername").val());
			
			break;
		}
		if(currentansweruid==''){
alert("请选择发布作者");
return false;
		}
	
		var haspost=false;
		//检查用户是否存在
		$.post('{url admin_chajian/getuser}',{'username':currentansweruid},function(result){
console.log(result)
         if(result.code==201){
               alert("用户不存在，请重新输入");
               haspost=false;
               return false;
           }
if(result.code==200){
 haspost=true;
 $("#pubauthor").val(currentansweruid);
 
 $("#articlecontent").val(eidtor_content);
 $("#articlefreecontent").val(freeconentval);
 document.articleform.action = "{url admin_topic/edit}";
 document.articleform.submit();
 return true;
}
			},'json');
	
}


 function checkarticle(){
	 if($("#topicclass")==''){
		 alert("请选择文章分类");
		 return false;
	 }
 }
                //图片上传预览    IE是用了滤镜。
        function previewImage(file)
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
//                 img.style.marginLeft = rect.left+'px';
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
        function clacImgZoomParam( maxWidth, maxHeight, width, height ){
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
</script>

<!--{template footer}-->
