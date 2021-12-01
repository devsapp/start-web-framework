<!--{template header}-->
<link rel="stylesheet" media="all" href="{SITE_URL}static/css/widescreen/css/space.css" />
<div class="container person">
  <div class="row">
    <div class="col-md-17 main">
          <!-- 用户title部分导航 -->
                   <!--{template space_title}-->


      <div id="list-container">
        <!-- 关注用户 -->
<ul class="user-list">
   <!--{loop $followerlist $follower}-->

  <li>
  <a class="avatar" href="{url user/space/$follower['followerid']}">
    <img src="{$follower['avatar']}" alt="180">
</a>  <div class="info">
    <a class="name" href="{url user/space/$follower['followerid']}">{$follower['follower']}</a>
    <div class="meta">
      <span>问题 {$follower['info']['questions']}</span><span>粉丝{$follower['info']['followers']}</span><span>文章 {$follower['info']['articles']}</span><span>回答 {$follower['info']['answers']}</span>
    </div>
    <div class="meta">
     {$follower['info']['signature']}
    </div>
  </div>
  {if  $follower['hasfollower']}
   <a class="btn btn-default following" id="attenttouser_{$follower['followerid']}" onclick="attentto_user($follower['followerid'])"><span>已关注</span></a>
  {else}
   <a class="btn btn-success follow" id="attenttouser_{$follower['followerid']}" onclick="attentto_user($follower['followerid'])"><span>关注</span></a>
  {/if}

</li>

   <!--{/loop}-->
</ul>
  <div class="pages" >{$departstr}</div>
      </div>
    </div>

<div class="col-md-7  aside">
   <!--{template space_menu}-->
</div>

  </div>
</div>
<!--{template footer}-->