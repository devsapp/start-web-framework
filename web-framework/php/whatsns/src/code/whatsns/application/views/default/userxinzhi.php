<!--{template header}-->
<link rel="stylesheet" media="all" href="{SITE_URL}static/css/widescreen/css/space.css" />
<div class="container person">
  <div class="row">
    <div class="col-xs-17 main">
          <!-- 用户title部分导航 -->

           <!--{if $uid==$user['uid']}-->
              <!--{template user_title}-->
             <!--{else}-->
                <!--{template space_title}-->
               <!--{/if}-->



      <div id="list-container">

   <!--{if $topiclist}-->
 
<div class="stream-list blog-stream">
                        <!--{loop $topiclist $nindex $topic}-->
              <section class="stream-list__item">
              <div class="blog-rank stream__item">
              <div data-id="1190000017247505" class="stream__item-zan   btn btn-default mt0">
              <span class="stream__item-zan-icon"></span>
              <span class="stream__item-zan-number">{$topic['articles']}</span>
              </div></div>
              <div class="summary">
              <h2 class="title blog-type-common blog-type-1">
              <a href="{url topic/getone/$topic['id']}">{$topic['title']}</a></h2>
              <ul class="author list-inline">
              <li>
              <a href="{url user/space/$topic['authorid']}">
              <img class="avatar-24 mr10 " src="{$topic['avatar']}" alt=" {$topic['author']}">
              </a>
              <span style="vertical-align:middle;">
              <a href="{url user/space/$topic['authorid']}"> {$topic['author']}</a>
                    
                    发布于
                                            <a href="{url topic/catlist/$topic['articleclassid']}">{$topic['category_name']}</a>
                                            </span>
                                            </li>
      <li class="bookmark " title="{$topic['likes']} 收藏" >
      <span style="vertical-align:middle;">
      <small class="fa fa-bookmark mr5"></small>
      <span class="blog--bookmark__text">{if $topic['likes']}$topic['likes']{/if} 收藏</span>
      </span></li></ul>
      <p class="excerpt wordbreak ">
       {if $topic['price']!=0}
                         <div class="box_toukan ">

  {eval echo clearhtml($topic['freeconent']);}
  {if $topic['readmode']==2}
											<a  class="thiefbox font-12" ><i class="icon icon-lock font-12"></i> &nbsp;更多阅读需支付&nbsp;$topic['price']&nbsp;&nbsp;财富值……</a>
{/if}
  {if $topic['readmode']==3}
											<a  class="thiefbox font-12" ><i class="icon icon-lock font-12"></i> &nbsp;更多阅读需支付&nbsp;$topic['price']&nbsp;&nbsp;元……</a>
{/if}

										</div>
                   {else}
                     {eval echo clearhtml($topic['describtion']);}
                    {/if}

  
  </p>
      </div>
      </section>
        <!--{/loop}-->
              </div>
  
      <!--{else}-->

          <!--{/if}-->















  <div class="pages" >{$departstr}</div>
      </div>
    </div>

<div class="col-xs-7  aside">
  <!--{if $uid==$user['uid']}-->
              <!--{template user_menu}-->
             <!--{else}-->
                 <!--{template space_menu}-->
               <!--{/if}-->
</div>

  </div>
</div>
<!--{template footer}-->