 {if $user['uid']!=0}
  <div class="postarticleform">
  <input type="hidden" id="artitle" value="{$topicone['title']}" />
    <input type="hidden" id="artid" value="{$topicone['id']}" />
<textarea  placeholder="写下你的评论..." class="comment-area"></textarea>
</div>
<div class="btnpostarticle">
<button class="ui-btn ui-btn-danger btn-cm-submit" onclick="postarticle();" >评论</button>
</div>

   {else}
    <div class="ui-btn-wrap">
    <button onclick="window.location.href='{url user/login}'" class="ui-btn-lg ui-btn-danger">
        登录发布评论
    </button>
</div>
    {/if}
    
    
<!-- 发布评论 -->

   <!--{if $commentlist}-->
    <section class="answerlist comment-list">
     <div class="ans-title">
         <span>全部评论</span>
     </div>
        <!--{loop $commentlist $index $comment}-->
            <div id="comment-{$comment['id']}" class="comment">
            <div>
            <div class="author">
            <a href="{url user/space/$comment['authorid']}" target="_self" class="avatar">
            <img src="{$comment['avatar']}">
            </a>
            <div class="info">
            <a href="{url user/space/$comment['authorid']}" target="_self" class="name">
            {$comment['author']}
              {if $comment['author_has_vertify']!=false}<i class="fa fa-vimeo {if $comment['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  " data-toggle="tooltip" data-placement="right" title="" {if $comment['author_has_vertify'][0]=='0'}data-original-title="个人认证" {else}data-original-title="企业认证" {/if} ></i>{/if}
            </a>
            <!---->
             <div class="meta">
             <span>{eval echo ++$index;}楼 · {$comment['time']}</span>
             </div>
             </div>
             </div>
             <div class="comment-wrap">
             <p>
              {$comment['content']}
             </p>

                </div>
                </div>
                 <div class="tool-group">
             <a class="button_agree" id='{$comment['id']}'><i class="fa fa-thumbs-o-up"></i> <span>{$comment['supports']}人赞</span></a>

<a class="getcommentlist" dataid='{$comment['id']}' datatid="{$topicone['id']}"><i class="fa fa-comment"></i> <span>回复{$comment['comments']}</span></a>

                <!--{if 1==$user['grouptype'] ||$user['uid']==$comment['authorid']}-->

    <a data-placement="bottom" title="" data-toggle="tooltip" data-original-title="删除评论"   href="javascript:void(0);" onclick="deletewenzhang($comment['id'])"><i class="fa fa-bookmark-o"></i> <span>删除</span></a>
     <!--{/if}-->

                <!---->
                </div>
               <div class="sub-comment-list  hide" dataflag="0" id="articlecommentlist{$comment['id']}">
              <div class="commentlist{$comment['id']}">

              </div>
              <div class="sub-comment more-comment">
              <a class="add-comment-btn" dataid="{$comment['id']}"><i class="fa fa-edit"></i>
               <span>添加新评论</span></a>
               <!----> <!----> <!---->
               </div>
                <div class="formcomment{$comment['id']} hide">
                <form class="new-comment">
                <!---->
                <textarea placeholder="写下你的评论..." class="commenttext{$comment['id']}"></textarea>
                 <div class="write-function-block">


                  <a class="btn btn-send  btn-sendartcomment" id="btnsendcomment{$comment['id']}"  dataid="{$comment['id']}" datatid="{$topicone['id']}">发送</a>

                  </div>
                  </form>
                   <!---->
                   </div>
                   </div>
                </div>
 <!--{/loop}-->
  <div class="pages" >{$departstr}</div>
  
    </section>
      <!--{/if}-->
        <script>
         	$(".getcommentlist").click(function(){
        		var _id=$(this).attr("dataid");
        		var _tid=$(this).attr("datatid");
        		$("#articlecommentlist"+_id).toggleClass("hide");
        		var flag=$("#articlecommentlist"+_id).attr("dataflag");
        		if(flag==1){
        			flag=0;
        		}else{
        			flag=1;
        			//加载评论
        			loadarticlecommentlist(_id,_tid);
        		}
        		$("#articlecommentlist"+_id).attr("dataflag",flag);
        		
        	})
        	$(".add-comment-btn").click(function(){
        		var _id=$(this).attr("dataid");
        		$(".formcomment"+_id).toggleClass("hide");
        	})
        	$(".btn-sendartcomment").click(function(){
        		var _aid=$(this).attr("dataid");
        		var _tid=$(this).attr("datatid");
        		var _content=$.trim($(".commenttext"+_aid).val());
        		if(_content==''){
        			alert("评论内容不能为空");
        			return false;
        		}
        		var touid=$("#btnsendcomment"+_aid).attr("touid");
        		if(touid==null){
        			touid=0;
        		}
        		addarticlecomment(_tid,_aid,_content,touid);
        	})
        	 $(".button_agree").click(function(){
             var supportobj = $(this);
                     var tid = $(this).attr("id");
                     $.ajax({
                     type: "GET",
                             url:"{SITE_URL}index.php?topic/ajaxhassupport/" + tid,
                             cache: false,
                             success: function(hassupport){
                             if (hassupport != '1'){






                                     $.ajax({
                                     type: "GET",
                                             cache:false,
                                             url: "{SITE_URL}index.php?topic/ajaxaddsupport/" + tid,
                                             success: function(comments) {

                                             supportobj.find("span").html(comments+"人赞");
                                             }
                                     });
                             }else{
                            	 alert("您已经赞过");
                             }
                             }
                     });
             });
         	function addarticlecomment(_tid,_aid,_comment,_touid){
         		var data={
         				tid:_tid,
         				aid:_aid,
         				content:_comment,
         				touid:_touid
         		}
         		var url=g_site_url+"index.php?topic/ajaxaddarticlecomment.html";
         		function success(result){
         			alert(result.msg)
         			if(result.code==200){
         				$(".commenttext"+_aid).val("");
         				loadarticlecommentlist(_aid,_tid);
         			}
         		}
         		ajaxpost(url,data,success);
         	}
         	function loadarticlecommentlist(_id,_tid){
         		var data={
         				tid:_tid,
         				aid:_id
         				
         		}
         		var url=g_site_url+"index.php?topic/ajaxgetcommentlist.html";
         		function success(result){
         			if(result.code=200){
         				$(".commentlist"+_id).html("");
         				var json=JSON.parse(result.msg);
         				console.log(json.length)

         				 for(var i=0,l=json.length;i<l;i++){
         					 
         					    console.log(json[i]['content'])
         				       
         					    var conli = '<div id="comment-'+json[i]['id']+'" class="sub-comment">'+
         			             '<p>'+
         			              '<div data-v-f3bf5228="" class="v-tooltip-container" style="z-index: 0;">'+
         			              '<div class="v-tooltip-content">'+
         			              '<a href="'+json[i]['userhomelink']+'" target="_blank">'+json[i]['author']+'</a>：'+
         			           '</div></div> <span>' 
         			        
         			           + json[i]['content']+
         			            
         			             '</span> </p><div class="sub-tool-group"><span>'+ json[i]['time']+ 
         			            
         			             '</span> <a class=""><i class="fa fa-comment"></i> <span author="'+ json[i]['author']+'"authorid="'+ json[i]['authorid']+'" class="huifu">回复</span></a><a class="subcomment-delete">'
         			             
         			             +json[i]['deltag']+
         			             ' </a> </div></div>';

         					    $(".commentlist"+_id).append(conli);
         				    
         				 }
         				//回复
         				$(".commentlist"+_id).find(".huifu").click(function(){
         					var _authorid=$(this).attr("authorid");
         					var _author=$(this).attr("author");
         					$(".commenttext"+_id).val("");
         					$(".commenttext"+_id).attr("placeholder","@"+_author+" ");
         					$(".formcomment"+_id).toggleClass("hide");
         					$(".commenttext"+_id).focus();
         					$("#btnsendcomment"+_id).attr("touid",_authorid);
         				});
         				$(".commentlist"+_id).find(".deltag").click(function(){
         					var _cid=$(this).attr("dataid");
         					var data={
         							id:_cid
         					}
         					function mysuccess(result){
         						if(result.code==200){
         							$(".commentlist"+_id).find("#comment-"+_cid).remove();
         						}else{
         							alert(result.msg)
         						}
         					}
         					var _url=g_site_url+"index.php?topic/ajaxdelartcomment.html";
         					   ajaxpost(_url,data,mysuccess);
         				})
         				 
         			}else{
         				alert(result.msg)
         			}
         		}
         		ajaxpost(url,data,success);
         	}
         	  function deletewenzhang(current_aid){
         			window.location.href=g_site_url + "index.php" + query + "topic/deletearticlecomment/"+current_aid+"/$topicone['id']";

         		}
             </script>