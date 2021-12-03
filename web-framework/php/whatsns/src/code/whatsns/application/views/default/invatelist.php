<!--{template header}-->

<div class="container person">
  <div class="row">
    <div class="col-xs-17 main">
          <!-- 用户title部分导航 -->
              <!--{template user_title}-->

 <ul class="trigger-menu" data-pjax-container="#list-container">
 <li class="active"><a href="{url user/invatelist}"><i class="fa fa-heart-o"></i> 我邀请的人</a></li>
  <li class=""><a href="{url user/invateme}"><i class="fa fa-envelope-open"></i> 邀请我的回答</a></li>
 </ul>
      <div id="list-container">
        <!-- 关注用户 -->
<ul class="user-list">
   <!--{loop $followerlist $follower}-->

  <li>
  <a class="avatar" href="{url user/space/$follower['uid']}">
    <img src="{$follower['avatar']}" alt="180">
</a>  <div class="info">
    <a class="name" href="{url user/space/$follower['uid']}">{$follower['username']}</a>
    <div class="meta">
      <span>问题 {$follower['info']['questions']}</span><span>粉丝{$follower['info']['followers']}</span><span>文章 {$follower['info']['articles']}</span><span>回答 {$follower['info']['answers']}</span>
    </div>
    <div class="meta">
     {$follower['info']['signature']}
    </div>
  </div>
  {if  $follower['hasfollower']}
   <a class="btn btn-default following" id="attenttouser_{$follower['uid']}" onclick="attentto_user($follower['uid'])"><span>已关注</span></a>
  {else}
   <a class="btn btn-success follow" id="attenttouser_{$follower['uid']}" onclick="attentto_user($follower['uid'])"><span>关注</span></a>
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