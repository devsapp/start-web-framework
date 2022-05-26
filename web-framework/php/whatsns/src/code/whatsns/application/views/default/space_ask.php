<!--{template header}-->

<div class="container person">
  <div class="row">
    <div class="col-md-17 main">
          <!-- 用户title部分导航 -->
              <!--{template space_title}-->


      <div id="list-container">
        <!-- 文章列表模块 -->

   <!--{if $questionlist}-->
   <div class="stream-list question-stream ">
      <!--{loop $questionlist $question}-->
     
  
      <section class="stream-list__item">
          <div class="qa-rank">
              {if $question['answers']==0}
                <div class="answers ml10 mr10">
                {$question['answers']}<small>回答</small></div>
                {else}
                {if $question['status']==2}
                <div class="answers answered solved ml10 mr10">
                 {$question['answers']}<small>解决</small></div>
                {else}
                
                <div class="answers answered ml10 mr10">
                {$question['answers']}<small>回答</small></div>
                {/if}
                {/if}
                <div class="views  viewsword0to99"><span> {$question['views']}</span><small>浏览</small></div>
                </div> 
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
                        <a href="{url question/view/$question['id']}">{$question['format_time']}</a>
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
      <!--{else}-->
       <div class="text">
            真不巧，作者还没有提问~
          </div>
          <!--{/if}-->














  <div class="pages" >{$departstr}</div>
      </div>
    </div>

<div class="col-md-7  aside">
   <!--{template space_menu}-->
</div>

  </div>
</div>
<!--{template footer}-->