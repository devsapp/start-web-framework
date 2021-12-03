

       <div id="comment-list" class="comment-list"><div>
            {if $user['uid']!=0}
 <form class="new-comment">
  <input type="hidden" id="artitle" value="{$topicone['title']}" />
    <input type="hidden" id="artid" value="{$topicone['id']}" />
 <a class="avatar">
 <img src="{$user['avatar']}">
 </a>
 <textarea onkeydown="return topickeydownlistener(event)"  placeholder="写下你的评论..." class="comment-area"></textarea>
 <div class="write-function-block"> <div class="hint">Ctrl+Enter 发表</div>
 <a class="btn btn-send btn-cm-submit" onclick="postarticle();" name="comments" id="comments">发送</a> </div>
 </form>
   {else}
  <form class="new-comment"><a class="avatar"><img src="{$user['avatar']}"></a> <div class="sign-container"><a href="{url user/login}" class="btn btn-sign">登录</a> <span>后发表评论</span></div></form>

            {/if}

        </div>
        <div id="normal-comment-list" class="normal-comment-list">

        <div class="top">
        <span>{$commentrownum}条评论</span>


           </div>
           </div>
           <!----> <!---->
            <!--{if $commentlist==null}-->
            <div class="no-comment"></div>
  <center>      
           还没有人评论过~
         </center>
           

              <!--{/if}-->
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
 
            
    
             </div>
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
             </script>