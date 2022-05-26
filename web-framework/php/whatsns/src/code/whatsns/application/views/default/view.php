<!--{template header}-->
<style>

.artice-detail .art-title {
    padding: 10px 0 13px;
    font-size: 26px;
    font-weight: bold;
    line-height: 38px;
    text-align: center;
}
</style>
<div class="container  mar-t-1 mar-b-1 ">

<div class="row">
<div class="col-sm-9 content-left">

        
<ol class="breadcrumb">
  <li><a class="first" href="{url topic/default}">资讯</a></li>

  <li class="active"> <a target="_blank" href="{url cat-$cat_model['id']}">{$cat_model['name']}</a></li>
</ol>


<hr>

<div class="artice-detail">
  <h1 class="art-title   text-center">{$topicone['title']}</h1>
  <div class="author-info">
 <div class="text-right">
   <span class="art-eyes mar-l-05 c-hui">人气指数：{$topicone['views']}</span>  
   <span class="art-time mar-l-05 c-hui" >发布时间:{$topicone['viewtime']}</span>
   
    <!--{if $user['grouptype']==1}-->
    <span><a class="mar-ly-1 btn btn-danger" title="推荐这篇文章到首页" href="{url topic/pushhot/$topicone['id']}"><i class="icon icon-heart text-success"></i>推荐到首页</a></span>
                
      <!--{/if}-->      
   </div>

  </div>

  <div class="art-content clear mar-t-1 font-15">
    {eval    echo replacewords($topicone['describtion']);    }
    
    
  </div>
  <div class="row mar-b-1">
      <div class="col-sm-12">
   
              <!--{if $topicone['tags']}-->  
                       标签：
                        
<!--{loop $topicone['tags'] $tag}-->
<span class="mar-ly-03"><a target="_blank" title="{$tag}" href="{url topic/search/$tag}">{$tag}</a></span>
                
                <!--{/loop}--><!--{else}--><!--{/if}-->
                     
   </div>
   </div>
   
<div class="art-share">
{if $setting['question_share']}
{$setting['question_share']}
{else}

 <div class="bshare-custom"> <p class="mod-tips"><span class="tag" style="display:inline-block">分享</span>
                <span style="display:inline-block"> 

     <a title="分享到" href="http://www.bShare.cn/" id="bshare-shareto" class="  bshare-more"></a>
     <a title="分享到QQ空间" class="bshare-qzone">QQ空间</a>
     <a title="分享到新浪微博" class="bshare-sinaminiblog">新浪微博</a>
     <a title="分享到人人网" class="bshare-renren">人人网</a>
     <a title="分享到腾讯微博" class="bshare-qqmb">腾讯微博</a>
     <a title="分享到网易微博" class="bshare-neteasemb">网易微博</a>
     <a title="更多平台" class="bshare-more bshare-more-icon more-style-addthis">
     </a>
     <span class="BSHARE_COUNT bshare-share-count">0</span>
     

     <script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/buttonLite.js#style=-1&amp;uuid=&amp;pophcol=2&amp;lang=zh"></script><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/bshareC0.js"></script>
 
   
    </span>
         
        </div>
{/if}
</div>

</div>


{if $setting['duoshuoname']!=null}
<div class="art-comments">
<!-- 多说评论框 start -->
	<div class="ds-thread" data-thread-key="{$topicone['id']}" data-title="{$topicone['title']}" data-url="{url article-$topicone['id']}"></div>
<!-- 多说评论框 end -->
<!-- 多说公共JS代码 start (一个网页只需插入一次) -->
<script type="text/javascript">

var duoshuoQuery = {short_name:"{$setting['duoshuoname']}"};



	(function() {
		var ds = document.createElement('script');
		ds.type = 'text/javascript';ds.async = true;
		ds.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') + '//static.duoshuo.com/embed.js';
		ds.charset = 'UTF-8';
		(document.getElementsByTagName('head')[0] 
		 || document.getElementsByTagName('body')[0]).appendChild(ds);
	})();
	</script>
<!-- 多说公共JS代码 end -->
</div>
{else}

<div class="comment-form">
<h2 class="cm-title">用户评论</h2>
<hr>

{if $commentlist==null }
<p>暂无网友评论!</p>
{/if}
    <div class="commentitemlist">
       <div class="ask_detail_comment mt20">
                

                                
                                 
                 <!--{loop $commentlist $index $comment}-->       
                 

                 
      <div class="mod_discuss clearfix jsanswerbox" id="1202">
      
    
            <a cmid="{$comment['id']}"  data-placement="bottom" title="" data-toggle="tooltip" data-original-title="赞同评论" href="javascript:;" data-bn-ipg="8-1-1-8" class="supportcmt jsaskansweruseful useful_left  button_agree" value="3284423">
        <span class="upvote-count">{$comment['supports']}</span>
        </a>

    <div class="mod_discuss_cnt">
        <!-- <div class="mod_discuss_cnt_triangle"></div> -->
        <div class="mod_discuss_box">
      
            <div class="jsanswercontent">
                <div class="mod_discuss_box_name">
                    <div class="mod_discuss_face">
                                                                            
                        <div class="ui_headPort" alt="2145180">
                            <a data-placement="bottom" title="" data-toggle="tooltip" data-original-title="{$comment['author']}" class="avatar ava40" data-bn-ipg="8-1-1-1" href="{url user/space/$comment['authorid']}">
                                <img src="{$comment['avatar']}" width="80" height="80" class="ui_headPort_img" alt="{$comment['author']}">
                                
                            </a>
                        </div>
                    </div>
                    <a data-bn-ipg="8-1-1-2" href="{url user/space/$comment['authorid']}">{$comment['author']}</a>
                                         <span class="ico_point">.</span> <a href="" class="normal_text">{$comment['time']}</a>                </div>
                <div class="mod_discuss_box_text qyer_spam_text_filter"> 
                 <div class="resolved-cnt"><p>{$comment['content']}<br></p></div>                    <div class="appendcontent font-12">
                    
                </div>
                 </div>

          
            </div>

            <div class="stamp"></div>

            
        </div>
        
        <!-- 讨论开始 -->
   
        <!-- 讨论结束 -->
    </div>
</div> 
                         
     <!--{/loop}-->        
           
 <div class="pages" style="padding-left:30px;">{$departstr}</div>                

                                                  


                        </div>
    </div>
    <input type="hidden" id="artitle" value="{$topicone['title']}" />
    <input type="hidden" id="artid" value="{$topicone['id']}" />
    <textarea rows="" cols="" placeholder="说点什么"  class="comment-area form-control"></textarea>
    <button  class=" btn-cm-submit">提交</button>
</div>
{/if}

</div>

<div class="col-sm-3 b-l-line">
<!-- 作者信息 -->


<div class="side-box">

<div class="author-img text-center mar-t-1">
<p class="text-center">
<a target="_blank" href="{url user/space/$member['uid']}">
                        <img width="50" height="50" class="img-rounded" src="{$member['avatar']}" alt="">
                    </a>
</p>

 <p class="name text-center mar-t-05">
                    <a target="_blank" href="{url user/space/$member['uid']}">{$member['username']}</a>
                </p>

             <img class="author-icon" src="http://p4.qhimg.com/t0168d4f53b1d77f678.png" alt="">
</div>
<p class="text-danger text-center">
 <span class="mar-y-1">
 金币:{$member['credit2']}
 </span>
 <span>
经验:{$member['credit1']}
 </span>
 </p>
   
                      <form class="text-center mar-t-05 hide"  action="{url ebank/aliapytransfer}" method="post" >
                         <input type="hidden" name="money" value="1" />
                        
                                <input type="hidden" id="apikey" name="apikey" value='{$_SESSION["apikey"]}'/>
                          <button class="btn btn-danger text-danger" type="submit" name="submit" >
                        <i class="icon icon-yen"></i> 1元打赏
                          </button>
                          
                         
                          </form>
                          
                        
             </div>         
                          <!-- 作者信息结束 -->
                          
                          
   <!-- 作者相关文章 -->

   <div class="side-box">
   <h3>TA的新知</h3>
   
   <div class="side-content">
    <ul class="nav right-ul">
                    <!--{loop $topiclist1 $index $topic}-->
                       <li class="b-b-line"> <i class="quan"></i> <a target="_blank" href="{url topic/getone/$topic['id']}" text="{$topic['title']}">{$topic['title']}</a></li>
                       <!--{/loop}-->
               


            </ul>
   </div>
   </div>

                             
   <!-- 作者相关文章结束 -->
   
                    <!-- 相关问题 -->   
           {if $questionlist}         
       <div class="side-box">
   <h3>相关{$cat_model['name']}问题</h3>
   
   <div class="side-content">
   <ul class="nav right-ul">
                   <!--{loop $questionlist  $question}-->
                       <li class="b-b-line"> <i class="quan"></i> <a target="_blank" href="{url question/view/$question['id']}" text="{$question['title']}">{$question['title']}</a></li>
                       <!--{/loop}-->


            </ul>
   </div>
   </div>
    {/if}
                           <!-- 相关问题 结束-->       
</div>
</div>

</div>
<!--{template footer}-->