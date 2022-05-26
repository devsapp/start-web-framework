<!--{template header}-->

<div class="container person">
  <div class="row">
    <div class="col-xs-17 main">
          <!-- 用户title部分导航 -->
              <!--{template user_title}-->
 <ul class="trigger-menu" data-pjax-container="#list-container">
 <li class=""><a href="{url user/default}"><i class="fa fa-clipboard"></i> 动态</a></li>
<li class=""><a href="{url user/ask}"><i class="fa fa-question-circle-o"></i> 提问</a></li>
<li class="active"><a href="{url user/answer}"><i class="fa fa-comments"></i>回答</a></li>
<li class=""><a href="{url topic/userxinzhi/$user['uid']}"><i class="fa fa-rss"></i>文章</a></li>
<li class=""><a href="{url user/recommend}"><i class="fa fa-newspaper-o"></i>推荐</a></li>


 </ul>

      <div id="list-container">

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
     </div>
     
      <!--{else}-->
        <div class="text">
            您还没有回答过别人的问题~
          </div>
          <!--{/if}-->

  <div class="pages" >{$departstr}</div>
      </div>
    </div>

<div class="col-xs-7  aside">
   <!--{template user_menu}-->
</div>

  </div>
</div>
<!--{template footer}-->