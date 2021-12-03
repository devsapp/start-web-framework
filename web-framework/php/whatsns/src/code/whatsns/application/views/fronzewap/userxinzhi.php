<!--{template header}-->

<section class="ui-container">

  <!--{if $uid==$user['uid']}-->
             <!--{template user_title}-->
             <!--{else}-->
               <!--{template space_title}-->
               <!--{/if}-->
   
    <section class="user-content-list">
            <div class="titlemiaosu">
			<!--{if $uid==$user['uid']}-->
             我的文章
             <!--{else}-->
               Ta的文章
               <!--{/if}-->
           
            </div>
      
         
      <div id="list-container">

<div class="stream-list blog-stream" >
     <!--{loop $topiclist $index $topic}-->   

<section class="stream-list__item">
<div class="blog-rank stream__item">
<div  class="stream__item-zan   btn btn-default mt0">
<span class="stream__item-zan-icon"></span>
<span class="stream__item-zan-number">{$topic['articles']}</span>
</div>
</div>
<div class="summary">
<h2 class="title blog-type-common blog-type-1">
<a href="{url topic/getone/$topic['id']}">{$topic['title']}</a>
</h2>
<ul class="authorme list-inline">
<li>
<span style="vertical-align:middle;">
<a href="{url user/space/$topic['authorid']}">{$topic['author']} 
 {if $topic['author_has_vertify']!=false}
        <i class="fa fa-vimeo {if $topic['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  "  ></i>
        {/if}
        </a>
                    
                    发布于
                                           {$topic['format_time']}
                                           </span>
                                           </li>
                                          
                                           </ul>
                                           </div>
                                           </section>

  <!--{/loop}-->
</div>

  <div class="pages" >{$departstr}</div>   
      </div>
    </section>
</section>


<!--{template footer}-->