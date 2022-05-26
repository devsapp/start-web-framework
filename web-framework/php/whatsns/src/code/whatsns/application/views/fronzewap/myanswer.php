
<!--{template header}-->

<section class="ui-container">
<!--{template user_title}-->

        <ul class="tab-head">
                                         
                  
                      <li class="tab-head-item "><a href="{url user/ask}" title="我的提问">我的提问</a></li>
                                                                               
                  
                   
                      <li class="tab-head-item current"><a href="{url user/answer}" title=" 我的回答"> 我的回答</a></li>
                                                             
                              <li class="tab-head-item "><a href="{url topic/userxinzhi/$user['uid']}" title="我的文章"> 我的文章</a></li>
                                                                               
                                    

   
</ul>
   <div class="stream-list question-stream xm-tag tag-nosolve">
    <!--{loop $answerlist $index $question}-->
      <section class="stream-list__item">
     <div class="qa-rank"><div class="answers answered solved ml10 mr10">
                {$question['comments']}<small>评论</small></div></div>    
                   <div class="summary">
            <ul class="author ">
                                           
                                                <li class="authorinfo">
                      
                        <a href="{url question/answer/$question['qid']/$question['id']}">{$question['time']}</a>
                                    </li>
            </ul>
            <h2 class="title"><a href="{url question/answer/$question['qid']/$question['id']}">{$question['title']}</a></h2>
 <!--{if $question['tags']}-->
           <ul class="taglist--inline ib">
<!--{loop $question['tags'] $tag}-->
<li class="tagPopup authorinfo">
                        <a class="tag" href="{url tags/view/$tag['tagalias']}" >
                                                       {$tag['tagname']}
                        </a>
                    </li>
                    

                           
                <!--{/loop}-->
                 </ul>
                <!--{else}--><!--{/if}-->
                
              
                                   
                           
                                            </div>
    </section>
  
  
    <!--{/loop}-->
        <div class="pages" >{$departstr}</div>   
      </div>
      
   
</section>


<!--{template footer}-->