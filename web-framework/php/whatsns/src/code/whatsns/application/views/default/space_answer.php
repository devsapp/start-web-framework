<!--{template header}-->

<div class="container person">
  <div class="row">
    <div class="col-md-17 main">
          <!-- 用户title部分导航 -->
              <!--{template space_title}-->


      <div id="list-container">
        <!-- 回答列表模块 -->

   <!--{if $answerlist}-->

     <div class="stream-list question-stream ">
      <!--{loop $answerlist $question}-->
     
  
      <section class="stream-list__item">
        <div class="qa-rank"><div class="answers answered solved ml10 mr10">
                {$question['comments']}<small>评论</small></div></div> 
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
                        <a {if  !$question['hidden']} href="{url question/answer/$question['qid']/$question['id']}" {/if}>{$question['time']}</a>
                                    </li>
            </ul>
            <h2 class="title"><a {if  !$question['hidden']} href="{url question/answer/$question['qid']/$question['id']}" {/if}>{$question['title']}</a></h2>

              
                                   
                           
                                            </div>
    </section>

  
      
     
    <!--{/loop}-->
     </div>
      <!--{else}-->

            <div class="text">
            真不巧，作者还没回答任何问题~
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