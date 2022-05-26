<!--{template header}-->

<div class="container person">
  <div class="row">
    <div class="col-xs-17 main">
          <!-- 用户title部分导航 -->
              <!--{template user_title}-->

      <ul class="trigger-menu" data-pjax-container="#list-container">

 <li class="active"><a href="{url user/attention/article}"><i class="fa fa-rss"></i> 关注的文章</a></li>
<li class=""><a href="{url user/attention/question}"><i class="fa fa-question"></i> 关注的问题</a></li>
<li class=""><a href="{url user/attention}"><i class="fa fa-user"></i> 关注的用户</a></li>
<li class=""><a href="{url user/attention/topic}"><i class="fa fa-tag"></i> 关注的话题</a></li>
 </ul>
      <div id="list-container">
        <!-- 我关注的文章列表模块 -->
<ul class="note-list">
   <!--{if $topiclist}-->

        <!--{loop $topiclist $index $topic}-->

    <li id="note-{$topic['id']}" data-note-id="{$topic['id']}" {if $topic['image']!=null}  class="have-img" {else}class="" {/if}>
    {if $topic['image']!=null}
      <a class="wrap-img"  href="{url topic/getone/$topic['tid']}"  target="_self">
            <img src="{$topic['image']}">
        </a>
            {/if}
        <div class="content">
            <div class="author">






        <a class="avatar" target="_self" href="{url user/space/$topic['authorid']}">
                    <img src="{$topic['avatar']}" alt="96">
                </a>      <div class="name">
                <a class="blue-link" target="_self" href="{url user/space/$topic['authorid']}">{$topic['author']}</a>




                <span class="time" data-shared-at="{$topic['format_time']}">{$topic['format_time']}</span>
            </div>
            </div>
            <a class="title" target="_self"   href="{url topic/getone/$topic['tid']}"  >{$topic['title']}</a>
            <p class="abstract">

                 {eval echo clearhtml($topic['describtion']);}
            </p>
            <div class="meta">

                <a target="_self"  href="{url topic/getone/$topic['tid']}" >
                    <i class="fa fa-eye"></i> {$topic['views']}
                </a>        <a target="_self"   href="{url topic/getone/$topic['tid']}#comments" >
                <i class="fa fa-comment-o"></i> {$topic['articles']}
            </a>      <span><i class=" fa fa-heart-o"></i>  {$topic['likes']}</span>

    <a style="color:#ffd100;"  href="{url favorite/delfavoratearticle/$topic['tid']}" >
                                               取消收藏
                </a> 

            </div>
        </div>
    </li>

    <!--{/loop}-->
      <!--{else}-->

          <!--{/if}-->


</ul>
  <div class="pages" >{$departstr}</div>
      </div>
    </div>

<div class="col-xs-7  aside">
   <!--{template user_menu}-->
</div>

  </div>
</div>
<!--{template footer}-->