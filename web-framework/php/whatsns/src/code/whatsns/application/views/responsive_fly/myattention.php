


<!--{template header}-->

<div class="layui-container fly-marginTop fly-user-main">
{template user_menu}

  
  <div class="fly-panel fly-panel-user" pad20>
    <div class="layui-tab layui-tab-brief" lay-filter="user">
     {template myattention_nav}
      <div class="fly-panel fly-rank fly-rank-reply" id="LAY_replyRank">

      
        <dl>
        
          {loop $attentionlist $reguser}
          <dd>
            <a href="{url user/space/$reguser['uid']}">
              <img src="{eval echo get_avatar_dir($reguser['uid']);}"><cite title="{$reguser['username']}">{$reguser['username']}</cite><i title="{eval echo tdate($reguser['regtime']);}">{eval echo tdate($reguser['regtime']);}</i>
            </a>
          </dd>
          {/loop}
        </dl>
            {template page}
      </div>
    </div>
  </div>
</div>
<!--{template footer}-->

