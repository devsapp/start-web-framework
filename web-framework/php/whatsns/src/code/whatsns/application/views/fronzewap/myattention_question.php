

<!--{template header}-->

<section class="ui-container">
<!--{template user_title}-->

   
    <section class="user-content-list">
     <ul class="tab-head">
                                         
                  
                      <li class="tab-head-item current"><a href="{url user/attention/question}" title="关注的问题">问题</a></li>
                                                                               
                  
                      <li class="tab-head-item "><a href="{url user/attention/article}" title="关注的文章">文章</a></li>
                                                                               
                  
                      <li class="tab-head-item "><a href="{url user/attention}" title="关注的用户">用户</a></li>
                                                                                                                       
                  
                      <li class="tab-head-item "><a href="{url user/attention/topic}" title="关注的话题">话题</a></li>
                                                                               
                                             

   
</ul>
            
              
      <div class="stream-list question-stream xm-tag tag-nosolve">
     <!--{loop $questionlist $index $question}-->
      <section class="stream-list__item">
       {if $question['status']==2}
                <div class="qa-rank"><div class="answers answered solved ml10 mr10">
                {$question['answers']}<small>解决</small></div></div>     
                {else}
                {if $question['answers']>0}
                <div class="qa-rank"><div class="answers answered ml10 mr10">
                $question['answers']<small>回答</small></div>
                </div>
                   {else}
                   <div class="qa-rank"><div class="answers ml10 mr10">
                0<small>回答</small></div></div>
                {/if}
                
                
                {/if}
                   <div class="summary">
            <ul class="author list-inline">
                                           
                                                <li class="authorinfo">
                                          {if $question['hidden']==1}
                                            匿名用户
                      
                       {else} 
                              <a href="{url user/space/$question['authorid']}">
                          {$question['author']}{if $question['author_has_vertify']!=false}<i class="fa fa-vimeo {if $question['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  " ></i>{/if}
                          </a>
                      
                         {/if} 
                       
                        <span class="split"></span>
                        <a href="{url question/view/$question['id']}">{eval echo tdate($question['time']);}</a>
                                    </li>
            </ul>
            <h2 class="title"><a href="{url question/view/$question['id']}">{$question['title']}</a></h2>
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
  
   
      
      </div>
            
       
          <div class="pages" >{$departstr}</div>   
    </section>
</section>


<!--{template footer}-->