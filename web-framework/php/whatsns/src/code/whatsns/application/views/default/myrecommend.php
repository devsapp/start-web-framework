<!--{template header}-->

<link rel="stylesheet" media="all" href="{SITE_URL}static/css/bianping/css/space.css" />





<!--用户中心-->


    <div class="container person">

        <div class="row " style="">
            <div class="col-xs-17 main">
            <!-- 用户title部分导航 -->
              <!--{template user_title}-->
             <!-- title结束标记 -->
       <!-- 内容页面 -->
    <div class="row" style="padding-top:0px">
                 <div class="col-sm-24">
                     <div class="dongtai">
                        <ul class="trigger-menu" data-pjax-container="#list-container">
 <li class=""><a href="{url user/default}"><i class="fa fa-clipboard"></i> 动态</a></li>
<li class=""><a href="{url user/ask}"><i class="fa fa-question-circle-o"></i> 提问</a></li>
<li class=""><a href="{url user/answer}"><i class="fa fa-comments"></i>回答</a></li>
<li class=""><a href="{url topic/userxinzhi/$user['uid']}"><i class="fa fa-rss"></i>文章</a></li>
<li class="active"><a href="{url user/recommend}"><i class="fa fa-newspaper-o"></i>推荐</a></li>

 
 </ul>

<div id="list-container">

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
          <p>   <span>亲，快设置下擅长领域吧，设置后可根据您的兴趣爱好为您推荐合适的问题!</span><a class="btn " href="{url user/mycategory}">点击设置擅长领域</a></p>
          </div>
          <!--{/if}-->

  <div class="pages" >{$departstr}</div>
      </div>




                     </div>
                 </div>


             </div>
            </div>

            <!--右侧栏目-->
            <div class="col-xs-7  aside">




                <!--导航列表-->

               <!--{template user_menu}-->

                <!--结束导航标记-->


                <div>

                </div>


            </div>

        </div>

    </div>



<!--用户中心结束-->

<!--{template footer}-->