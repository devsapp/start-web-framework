 <link rel="stylesheet" media="all" href="{SITE_URL}static/css/widescreen/css/space.css" />
  <div class="main-top">
  <a class="avatar" href="{url user/space/$member['uid']}">
    <img src="{$member['avatar']}" alt="240">
</a>
   <!--{if isset($is_followed)&&$is_followed}-->
<a class="btn btn-default following" id="attenttouser_{$member['uid']}" onclick="attentto_user($member['uid'])"><span >已关注</span></a>
 <!--{else}-->
    <a class="btn btn-success follow" id="attenttouser_{$member['uid']}" onclick="attentto_user($member['uid'])"><span>关注</span></a>
      <!--{/if}-->
    {if $user['uid']}
    <a class="btn btnsixin" href="{url message/sendmessage/$member['uid']}">私信</a>
{else}
  <a class="btn btnsixin" href="javascript:login()">私信</a>
{/if}
  <div class="title">
    <a class="name" href="{url user/space/$member['uid']}">
    {$member['username']}
     {if $member['author_has_vertify']!=false}<i class="fa fa-vimeo v_person   " data-toggle="tooltip" data-placement="right" title=""data-original-title="认证用户" ></i>{/if}
    </a>
  </div>
   <div class="mysignnature">{if $member['signature']}$member['signature']{else}这个人很懒，暂无签名信息{/if}</div>
 
  <div class="info">
    <ul>
      <li>
        <div class="meta-block">
          <a href="{url user/space_answer/$member['uid']}">
            <p>{$member['answers']}</p>
            回答 <i class="fa fa-angle-right"></i>
</a>        </div>
      </li>
      <li>
        <div class="meta-block">
          <a href="{url user/space_ask/$member['uid']}">
            <p>{$member['questions']}</p>
            提问 <i class="fa fa-angle-right"></i>
</a>        </div>
      </li>
        <li>
        <div class="meta-block">
         <a href="{url topic/userxinzhi/$member['uid']}">
            <p>{$member['articles']}</p>
            文章 <i class="fa fa-angle-right"></i>
</a>        </div>
      </li>

           <li>
        <div class="meta-block">
         <a href="{url user/spacefollower/$member['uid']}">
            <p>{$member['followers']}</p>
             粉丝 <i class="fa fa-angle-right"></i>
</a>        </div>
      </li>


      <li>
        <div class="meta-block">
          <p>{$member['supports']}</p>
          <div>赞同</div>
        </div>
      </li>

      <li>
        <div class="meta-block">
          <p>{$member['credit1']}</p>
          <div>经验</div>
        </div>
      </li>
          <li>
        <div class="meta-block">
          <p>{$member['credit2']}</p>
          <div>财富</div>
        </div>
      </li>

    </ul>
  </div>
</div>
 <ul class="trigger-menu" data-pjax-container="#list-container">
 <li <!--{if $regular=="user/space"}--> class="active" <!--{/if}-->><a href="{url user/space/$member['uid']}">
 <i class="fa fa-clipboard"></i> 动态</a>
 </li>
 <li <!--{if $regular=="user/space_answer"}--> class="active" <!--{/if}-->><a href="{url user/space_answer/$member['uid']}"><i class="fa fa-commenting-o"></i> 回答</a></li>
 <li <!--{if $regular=="user/space_ask"}--> class="active" <!--{/if}-->><a href="{url user/space_ask/$member['uid']/1}">
 <i class="fa fa-question-circle-o"></i> 提问</a>
 </li>
 <li <!--{if $regular=="topic/userxinzhi"}--> class="active" <!--{/if}-->><a href="{url topic/userxinzhi/$member['uid']}"><i class="fa fa-rss-square"></i> 文章</a></li>
 <li <!--{if $regular=="user/space_attention"}--> class="active" <!--{/if}-->><a href="{url user/space_attention/topic/$member['uid']}"><i class="fa fa-sticky-note"></i>关注话题</a></li>
 </ul>
