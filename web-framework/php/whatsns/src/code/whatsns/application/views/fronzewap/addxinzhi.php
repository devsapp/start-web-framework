<!--{template meta}-->
<link rel="stylesheet" media="all" href="{SITE_URL}static/css/common/commtag.css" />
<style>
.moreinfoitem{
	display:none;
}
.moreinfo{
color: #31b7ae;
    padding-left: .02rem;
    cursor: pointer;
    text-align: left;
    margin-top: .1rem;
    margin-bottom: .05rem;
}
.txt_tag{
	margin-bottom:.1rem;
}
.f-addarticle #topic_price{
	font-size:20px;
}
.f-addarticle .img-thumbnail {
    width: 1.5rem;
    max-height: 1.2rem;
}
.text-danger,.f-addarticle a {
	color:red;
}
</style>

<!--用户中心-->

<div class="user-home bg-white"  style="margin-bottom:80px;">
    <div class="container">
 <form class="form-horizontal mar-t-1 f-addarticle" action="{url user/addxinzhi}"  method="post" enctype="multipart/form-data">
    <div class="row">
                 <div class="col-md-16">
                     <div class="dongtai">
                         <p>
                             <strong class="font-18">发表文章</strong>
                         </p>


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
            <input type="text" name="title" value="{$topic['title']}" size="50" class="title" placeholder="文章标题不能为空">
            <div class="help-block alert alert-primary ">


           <div class="ui-form-item ui-form-item-r ui-border-b" style="padding-left:0px;">
            <label class="ui-txt-muted">选择分类</label>
            <div class="ui-select" style="display:inline-block;    margin-left: 15px;">
                              <select style="position: relative;top:2px;" name="topicclass" id="srchcategory">

                              {$catetree}
                              </select>
            </div>
        </div>
            </div>
          </div>
        </div>

                       <div class="form-group">
          <p class="col-md-24  text-left fl "><b>文章内容:</b></p>
          <div class="col-md-24 has-error">

<!--{template editor}-->




          </div>
        </div>






                     </div>


                 </div>
 <div class="col-md-8">

 <div class="fixedright">


  <div class="form-group" style="margin-top: 20px">

        <div class="col-md-24">

 <div class="add-img-box row" style="margin-bottom: 20px">
  <div class="col-sm-6" style="display:inline-block;">
    付费模式:
     </div>
  <div class="col-sm-10" style="display:inline-block;">
    <select class="form-control" name="readmode" id="readmode">
    <option value="1">免费阅读</option>
    <option value="2">财富值阅读</option>
         
    </select>
     </div>
  </div>

    <div class="add-img-box row">
     <div class="col-sm-24  paymodeltype hide">
     <div class="price_set" data-toggle="tooltip" data-placement="bottom" title=""  data-original-title="默认不需要财富值可以阅读">
     <span>阅读需要</span>
      <input type="number" AUTOCOMPLETE="OFF" id="topic_price" name="topic_price" value="0" size="100" class="txt_price" placeholder="可以留空">
         <span class="unittext">财富值</span>
     </div>

     </div>
        <div class="col-sm-24 freecontent hide" style="margin-bottom: 20px;">
<!--{template freeditor}-->
   </div>
     <div class="col-sm-24">
     外部封面图地址:(<a class="text-danger" href="javascript:getimg()">点击内容提取</a>)
     <input type="text" AUTOCOMPLETE="OFF" id="outimgurl" name="outimgurl" value="{SITE_URL}static/css/dist/css/images/default.jpg" size="350" class="form-control" placeholder="如果不上传可以粘贴外部封面图片地址">

   </div>
   </div>
        </div>
        </div>
        <!-- -待续 -->
         <div class="moreinfo">增加更多信息<i class="fa fa-angle-down"></i></div>
        <div class="moreinfoitem">
         <div class="form-group">
          <p class="col-md-24  text-left fl"> 文章标签设置，最多5个:</p>
          <div class="col-md-24 has-error">
           
          <div class=" dongtai ">
          <div class="tags">
      
          </div>
            <input type="text" autocomplete="off" style="border: solid 1px #31b7ae;"  data-toggle="tooltip" data-placement="bottom" title="" placeholder="检索标签，最多添加5个,添加标签更容易被回答" data-original-title="检索标签，最多添加5个" name="topic_tagset" value=""  class="txt_taginput" >
            <i class="fa fa-search" style="color:#31b7ae"></i>
           <div class="tagsearch">
        
          
           </div>
            
          </div>
          </div>
        </div>
                 <div id="preview" style="overflow:visible;margin-top:10px;">
  <!--{if isset($topic['image'])}-->
   {eval $index=strpos($topic['image'],'http');}
                     {if $index==0 }

                           <img class="img-thumbnail"  id="imghead" src="{$topic['image']}" width="489" height="240"/>&nbsp;&nbsp;&nbsp;
                            {else}
                        <img class="img-thumbnail" id="imghead" src="{SITE_URL}{$topic['image']}" width="489" height="240"/>&nbsp;&nbsp;&nbsp;

                            {/if}


  <!--{else}-->

    <img class="img-thumbnail" id="imghead" style="max-height: 300px;" border=0 src='{SITE_URL}static/css/dist/css/images/default.jpg'>
    <!--{/if}-->

</div>
  <div class="add-img-box row">
  <div class="col-sm-24">
    <span class="add-img" >
  <a id="layerUploadButton"></a></span>
  <div class="add-img-html5" style=""><span>
  </span><a class="text-danger" href="###" text="网页提问浮层添加图片点击">
  <i class="ui-icon-thumb"></i>选择封面图
  <input type="file" id="layer_upload" onchange="previewImage(this)" name="image" title="请选择图片" accept="image/*" style="opacity: 0;height: 40px;position:absolute;top:.1rem;left:0px;">
  </a>
  </div>
  </div>

  </div>
        </div>
          <div class="form-group">
        <div class=" col-md-20">
         <input type="hidden" id="topic_tag" name="topic_tag" value=''/>
                    <input type="hidden" name="cid1" id="cid1" value="0"/>
                    <input type="hidden" name="cid2" id="cid2" value="0"/>
                    <input type="hidden" name="cid3" id="cid3" value="0"/>
          <input type="hidden" name="usersid" value='{$_SESSION["userid"]}'/>

  <button type="submit" id='article_btn' class="ui-btn ui-btn-primary width-120" name="submit" >提 交</button>
   <button type="button" onclick="getimg()" class="ui-btn ui-btn-danger width-120 mar-ly-1" name="tiquimg" >内容提取封面图</button>

        </div>
        </div>


 </div>
 </div>

             </div>
               </form>

            </div>


        </div>



<!--用户中心结束-->
<script type="text/javascript">
$(".moreinfo").click(function(){
	$(".moreinfoitem").show();
	$(".moreinfo").hide();
})
window.onload=function(){
	$(".dongtai .title").focus();
	$(".wangEditor-txt").css("height","200px");
	getcat();

	function getcat(){

		var sv=$("#srchcategory").val();

		 $.ajax({
		        //提交数据的类型 POST GET
		        type:"POST",
		        //提交的网址
		        url:"{url question/ajaxgetcat}",
		        //提交的数据
		        data:{category:sv},
		        //返回数据的格式
		        datatype: "json",//"xml", "html", "script", "json", "jsonp", "text".
		      //在请求之前调用的函数
		        beforeSend:function(){

		        },
		        //成功返回之后调用的函数
		        success:function(data){

		        	var data=eval("("+data+")");

		        	  if(data.message=='ok'){

		        		  $("#topicclass").val(data.cid);
		        		  $("#cid1").val(data.cid1);
		        		  $("#cid2").val(data.cid2);
		        		  $("#cid3").val(data.cid3);

		        	  }else{
		        		  el2=$.tips({
	          	            content:'分类不存在，估计是缓存引起',
	          	            stayTime:1000,
	          	            type:"info"
	          	        });
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
	}
	$("#srchcategory").change(function(){
		getcat();

	})
}
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
function getimg(){

	// var eidtor_content= editor.getContent();
	 // 获取编辑器区域
       var _txt = editor.wang_txt;
    // 获取 html
       var _html =  _txt.html();

	var firstimg=$(_html).find("img");

	if(firstimg!=null){
		$("#imghead").attr("src",firstimg[0].src);


		$("#outimgurl").val(firstimg[0].src);
	}

}

</script>



<script type="text/javascript">

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
$("#article_btn").click(function(){
	if(gettagsnum()>5){
        alert("最多添加5个标签");
        return false;
   	}
   	 var _tagstr=gettaglist();
   	 $("#topic_tag").val(_tagstr);
	 var v=$("#topicclass").val();
	var fv=$("#layer_upload").val();
	var upfv=$("#outimgurl").val();
	//积分
	var _topic_price=$("#topic_price").val();
        if(parseInt(_topic_price)<0){
       	 alert("积分设置不能为负数");
		 return false;
        }
	 if(v==''){
		 alert("请选择文章分类");
		 showcategory();
		 return false;
	 }
	if(fv==''&&upfv==''){


		 alert("请选择文章封面图");
		 return false;
	 }
})

 function checkarticle(){
	 if($("#topicclass")==''){
		 alert("请选择文章分类");
		 return false;
	 }
 }
//图片上传预览    IE是用了滤镜。
function previewImage(file)
{
  var MAXWIDTH  = 260;
  var MAXHEIGHT = 180;
  var div = document.getElementById('preview');
  if (file.files && file.files[0])
  {


      var reader = new FileReader();
      reader.onload = function(evt){

    	  var canvas=document.createElement("canvas");
          var ctx=canvas.getContext("2d");
          var image=new Image();
          image.src=evt.target.result;
          image.onload=function(){
              var cw=image.width;
              var ch=image.height;
              var w=image.width;
              var h=image.height;
              canvas.width=w;
              canvas.height=h;
              if(cw>800&&cw>ch){
                  w=800;
                  h=(800*ch)/cw;
                  canvas.width=w;
                  canvas.height=h;
              }
              if(ch>800&&ch>cw){
                  h=800;
                  w=(800*cw)/ch;
                  canvas.width=w;
                  canvas.height=h;

              }

              ctx.drawImage(image,0,0,w,h);
              var _src=canvas.toDataURL("image/jpeg",0.7);


    	 $("#imghead").attr("src",_src);


      }
      }
      reader.readAsDataURL(file.files[0]);
  }


}


</script>

<!--{template footer}-->
