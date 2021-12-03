<!--{template header}-->

<div class="container person">
  <div class="row">
    <div class="col-xs-17 main">
          <!-- 用户title部分导航 -->
              <!--{template user_title}-->
                 <ul class="trigger-menu" data-pjax-container="#list-container">
 <li class=""><a href="{url user/attention/article}"><i class="fa fa-rss"></i> 关注的文章</a></li>
<li class=""><a href="{url user/attention/question}"><i class="fa fa-question"></i> 关注的问题</a></li>
<li class="active"><a href="{url user/attention}"><i class="fa fa-user"></i> 关注的用户</a></li>
<li class=""><a href="{url user/attention/topic}"><i class="fa fa-tag"></i> 关注的话题</a></li>
 </ul>

      <div id="list-container">
        <!-- 关注用户 -->
<ul class="user-list">
   <!--{loop $attentionlist $attention}-->

  <li>
  <a class="avatar" href="{url user/space/$attention['uid']}">
    <img src="{$attention['avatar']}" alt="180">
</a>  <div class="info">
    <a class="name" href="{url user/space/$attention['uid']}">{$attention['username']}</a>
    <div class="meta">
      <span>问题 {$attention['info']['questions']}</span><span>粉丝{$attention['info']['followers']}</span><span>文章 {$attention['info']['articles']}</span><span>回答 {$attention['info']['answers']}</span>
    </div>
    <div class="meta">
     {$attention['info']['signature']}
    </div>
  </div>
  {if  $attention['hasfollower']}
   <a class="btn btn-default following" id="attenttouser_{$attention['uid']}" onclick="attentto_user($attention['uid'])"><i class="fa fa-check"></i><span>已关注</span></a>
  {else}
   <a class="btn btn-success follow" id="attenttouser_{$attention['uid']}" onclick="attentto_user($attention['uid'])"><i class="fa fa-plus"></i><span>关注</span></a>
  {/if}

</li>

   <!--{/loop}-->
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