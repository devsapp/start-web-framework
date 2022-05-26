<!--{template meta}-->
<link rel="stylesheet" media="all" href="{SITE_URL}static/css/common/commtag.css" />
<div class="container  mar-t-1 mar-b-1">
<div class="row">
  <div class="col-sm-24">

    <form  class="form-horizontal mar-t-1" id="askform" name="questionform" method="post" enctype="multipart/form-data">
            <div class="askbox">
                
       
                 
                
                
                       <div class="form-group">
          <p class="col-md-24 "></p>
          <div class="col-md-16">
        
               <input class="qtitle form-control" name="title" id="qtitle" value="{$question['title']}">
          </div>
        </div>
        
                 <div class="ui-form-item ui-form-item-r ui-border-b">
            <label>分类</label>
            <div class="ui-select">
                              <select  name="srchcategory" id="srchcategory">

                              {$catetree}
                              </select>
            </div>
        </div>
        
                 <div class="form-group mar-t-05">
          <p class="col-md-24 form-title ">编辑描述</p>
          <div class="col-md-16">
            <div id="introContent">
                       <!--{template editor}-->
                    </div>
          </div>
        </div>
                 <div class=" moreinfoitem" style="height: auto;line-height:auto;">
                   <div class="form-group" style="padding:0 15px;">

          <div class=" dongtai ">
          <div class="tags">
        <!--{if $taglist}-->
                                       <!--{loop $taglist $tag}-->
          <div class="tag">
          <span tagid="{$tag['id']}">{$tag['tagname']}</span><i class="fa fa-close"></i>
          </div>
               <!--{/loop}--><!--{else}--><!--{/if}-->
          </div>
            <input type="text" style="border: solid 1px #0085ee;width:80%;" autocomplete="off"  data-toggle="tooltip" data-placement="bottom" title="" placeholder="检索标签，最多添加5个,添加标签更容易被回答" data-original-title="检索标签，最多添加5个" name="topic_tag" value=""  class="txt_taginput" >
            <i class="fa fa-search" style="color:#0085ee"></i>
           <div class="tagsearch">
        
          
           </div>
            
          </div>
      
</div>
            </div>
                  <!--{if $user['grouptype']!=1&&$user['credit1']<$setting['jingyan']}-->
                      <style>
                      #code{
                             position: relative;
    top: 15px;
    border: solid 1px #333;
    outline: none;
    margin-left: 15px;
                      }
                      .mybtnup{
                         margin-top: 25px;
    clear: both;
                      </style>
              <!--{template code}-->
          <!--{/if}-->
          
         <div class="form-group mybtnup">
          <div class=" ui-btn-wrap">
                       <input type="hidden" name="cid" id="cid" value="{$question['cid']}" />
                    <input type="hidden" name="cid1" id="cid1" value="{$question['cid1']}"/>
                    <input type="hidden" name="cid2" id="cid2" value="{$question['cid2']}"/>
                    <input type="hidden" name="cid3" id="cid3" value="{$question['cid3']}"/>
                          <input type="hidden" value="{$qid}" id="bianji_qid" name="qid" />
            <button type="button" id="submit" name="submit" class="ui-btn ui-btn-primary"  data-loading="稍候...">保存</button> 
            <a class="ui-btn" onclick="window.history.go(-1)">返回</a>
          </div>
        </div>
            </div>	
        </form>
  </div>
  

</div>
</div>
<script>
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
$(".close").click(function(){
	$('#agreemodel').hide();
});
$("#showadreeitem").click(function(){
	$('#agreemodel').show();
}
);
$(".moreinfo").click(function(){
	$(".moreinfoitem").show();
	$(".moreinfo").hide();
})

$("#srchcategory").val( $("#cid").val());
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
	        		  $("#cid").val(data.cid);
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
$("#submit").click(function(){
  	if(gettagsnum()>5){
        alert("最多添加5个标签");
        return false;
   	}
   	 var _tagstr=gettaglist();
   	
	 var eidtor_content='';
	
			eidtor_content = editor.wang_txt.html();
		
	   <!--{if $user['grouptype']!=1}-->
	  var data={
			  title:$("#qtitle").val(),
			  content:eidtor_content,
			 qid:$("#bianji_qid").val(),
			 submit:$("#submit").val(),
			  askfromuid:$("#askfromuid").val(),
				 cid:$("#cid").val(),
				  cid1:$("#cid1").val(),
				  cid2:$("#cid2").val(),
				  cid3:$("#cid3").val(),
				  tags:_tagstr,
  			code:$("#code").val()
  	}
	    <!--{else}-->
		var data={
				  title:$("#qtitle").val(),
				  qid:$("#bianji_qid").val(),
				  submit:$("#submit").val(),
					 cid:$("#cid").val(),
					  cid1:$("#cid1").val(),
					  cid2:$("#cid2").val(),
					  cid3:$("#cid3").val(),
					  tags:_tagstr,
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
        	
        },
        //成功返回之后调用的函数             
        success:function(data){
        	$(".progress").addClass("hide");
        	var data=eval("("+data+")");
           if(data.message=='ok'){
        	   var tmpmsg='问题编辑成功!';
        	  
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
        	
        },
        //调用出错执行的函数
        error: function(){
            //请求出错处理
        }         
     });
})




</script>
<!--{template footer}-->