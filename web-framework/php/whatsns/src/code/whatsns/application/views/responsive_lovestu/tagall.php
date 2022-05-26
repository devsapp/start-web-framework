<!--{template header}-->
<!-- 首页导航 --> 
{template index_nav}

<link rel="stylesheet" media="all" href="{SITE_URL}static/css/common/commtag.css" />

<div class="layui-container collection index tagindex" >

<div class="layui-card">
  <div class="layui-card-header">标签</div>
  <div class="layui-card-body">
 <p>标签不仅能组织和归类你的内容，还能关联相似的内容。正确的使用标签将让你的问题被更多人发现和解决。</p>
 <div class="tagsearchbox">

              <div class="form-group">
    
       
           
          <div class=" dongtai ">
          <div class="tags">
      
          </div>
            <input type="text" autocomplete="off"  data-toggle="tooltip" data-placement="bottom" title="" placeholder="可输入拼音或者中文搜索" data-original-title="支持拼音+中文检索" name="topic_tagset" value=""  class="txt_taginput" >
            <i class="layui-icon layui-icon-search"></i>
           <div class="tagsearch">
        
          
           </div>
            
          </div>
        
        </div>
</div>
  </div>
</div>

      <div class="layui-card">
  <div class="layui-card-header">标签列表</div>
  <div class="layui-card-body">
<div class="layui-row tag-list mt20 layui-col-space10">
{loop $taglist $tag}
<section class="tag-list__item layui-col-md4">
                <div class="widget-tag">
                    <h2 class="h4">
                        <a href="{url tags/view/$tag['tagalias']}" class="">{$tag['tagname']}</a>
                    </h2>
                                        <p>{if $tag['description']}$tag['description']{else}暂无相关描述{/if}</p>
                                        <div class="widget-tag__action">

                        <button class="btn btn-default btn-xs mr5 tagfollow hide" >加关注</button>

                        <div class="text-color-hui font13">包含{$tag['tagquestions']}个问题.{$tag['tagarticles']}篇文章</div>
                    </div>
                </div>
            </section>
            {/loop}
            
</div>
<div class="pages">
{$departstr}
</div>
  </div>
</div>


</div>
<script type="text/javascript">
layui.use(['jquery', 'layer'], function(){
	  var $ = layui.$ //重点处
	  ,layer = layui.layer;
	  $(".txt_taginput").on(" input propertychange",function(){
			 var _txtval=$(this).val();
			 if(_txtval.length>1){
			
				 //检索标签信息
				 var _data={tagname:_txtval};
				 var _url="{url tags/ajaxsearch}";
			
				 $.ajax({
				        //提交数据的类型 POST GET
				        type:"POST",
				        //提交的网址
				        url:_url ,
				        //提交的数据
				        data:_data,
				        //返回数据的格式
				        datatype: "json",//"xml", "html", "script", "json", "jsonp", "text".
				        beforeSend: function () {

				        	loading=layer.load(0, {
				                shade: false,
				                time: 2*1000
				            });
				         },
				        //成功返回之后调用的函数
				        success:function(result){
				        	var result=eval("("+result+")");
				   		 console.log(result)
						 if(result.code==200){
							 console.log(_txtval)
							  $(".tagsearch").html("");
							for(var i=0;i<result.taglist.length;i++){
						
								 var _msg=result.taglist[i].tagname
								 
						           $(".tagsearch").append('<div class="tagitem" tagid="'+result.taglist[i].id+'"><a target="_blank" href="'+result.taglist[i].url+'">'+_msg+'</a></div>');
							}
						if(result.taglist.length>0){
							
							$(".tagsearch").show();
						}else{
							$(".tagsearch").hide();
						}
						 }else{
							
							 $(".tagsearch").hide();
						 }
				        }   ,
				        complete: function () {
				        	layer.close(loading);
				         },
				        //调用出错执行的函数
				        error: function(){
				      	 layer.msg("请求异常", {
				 			  time: 1500 
						});
				            //请求出错处理
				        }
				    });
				    
		
			 }else{
					$(".tagsearch").html("");
					$(".tagsearch").hide();
			 }
		})

});




</script>
<!--{template footer}-->