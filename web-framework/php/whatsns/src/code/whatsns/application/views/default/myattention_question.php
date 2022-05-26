<!--{template header}-->

<div class="container person">
  <div class="row">
    <div class="col-xs-17 main">
          <!-- 用户title部分导航 -->
              <!--{template user_title}-->
   <ul class="trigger-menu" data-pjax-container="#list-container">
      <li class=""><a href="{url user/attention/article}"><i class="fa fa-rss"></i> 关注的文章</a></li>
<li class="active"><a href="{url user/attention/question}"><i class="fa fa-question"></i> 关注的问题</a></li>
<li class=""><a href="{url user/attention}"><i class="fa fa-user"></i> 关注的用户</a></li>
<li class=""><a href="{url user/attention/topic}"><i class="fa fa-tag"></i> 关注的话题</a></li>
 </ul>

      <div id="list-container">
        <!-- 文章列表模块 -->
<ul class="note-list">
   <!--{if $questionlist}-->

      <!--{loop $questionlist $question}-->

    <li id="note-{$question['id']}" data-note-id="{$question['id']}" {if $question['image']!=null}  class="have-img" {else}class="" {/if}>
    {if $question['image']!=null}
      <a class="wrap-img" {if $question['articleclassid']!=null} href="{url topic/getone/$question['id']}"  {else}  href="{url question/view/$question['id']}" {/if} target="_blank">
            <img src="{$question['image']}">
        </a>
            {/if}
        <div class="content">
            <div class="author">





        {if $question['hidden']==1}

          <a class="avatar"  href="javascript:void(0)">
                    <img src="{$question['avatar']}" alt="96">
                </a>      <div class="name">
                <a class="blue-link"  href="javascript:void(0)">匿名用户</a>


        {else}
        <a class="avatar" target="_blank" href="{url user/space/$question['authorid']}">
                    <img src="{$question['avatar']}" alt="96">
                </a>      <div class="name">
                <a class="blue-link" target="_blank" href="{url user/space/$question['authorid']}">{$question['author']}</a>

        {/if}


               {if isset($question['format_time'])} <span class="time" data-shared-at="{$question['format_time']}">.关注时间：{$question['attention_time']}</span>{/if}
            </div>
            </div>
            <a class="title" target="_blank"   href="{url question/view/$question['id']}"  >{$question['title']}</a>
            <p class="abstract">
                {eval echo strip_tags($question['description']);}

            </p>
            <div class="meta">

                <a target="_blank"  href="{url question/view/$question['id']}" >
                    <i class="fa fa-eye"></i> {$question['views']}
                </a>        <a target="_blank"   href="{url question/view/$question['id']}#comments" >
                <i class="fa fa-comment-o"></i> {$question['answers']}
            </a>      <span><i class=" fa fa-heart-o"></i>  {$question['attentions']}</span>
              <a style="color:#ffd100;"  href="{url favorite/delfavoratequestion/$question['id']}" >
                                               取消收藏
                </a> 
            </div>
        </div>
    </li>

    <!--{/loop}-->
      <!--{else}-->
       <div class="text">
            抱歉，您还没有关注过任何问题~
          </div>
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