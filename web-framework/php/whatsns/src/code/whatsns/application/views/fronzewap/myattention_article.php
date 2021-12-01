
<!--{template header}-->

<section class="ui-container">
<!--{template user_title}-->

   
    <section class="user-content-list">
     <ul class="tab-head">
                                         
                  
                      <li class="tab-head-item "><a href="{url user/attention/question}" title="关注的问题">问题</a></li>
                                                                               
                  
                      <li class="tab-head-item current"><a href="{url user/attention/article}" title="关注的文章">文章</a></li>
                                                                               
                  
                      <li class="tab-head-item "><a href="{url user/attention}" title="关注的用户">用户</a></li>
                                                                                                                       
                  
                      <li class="tab-head-item "><a href="{url user/attention/topic}" title="关注的话题">话题</a></li>
                                                                               
                                             

   
</ul>
      
         
      <div id="list-container">
        <!-- 回答列表模块 -->

   <!--{if $topiclist}-->
   
      
                
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
<a href="{url topic/getone/$topic['tid']}">{$topic['title']}</a>
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


      
          <!--{/if}-->
                    
     
   


   
   

   


   
   

  <div class="pages" >{$departstr}</div>   
      </div>
    </section>
</section>


<!--{template footer}-->