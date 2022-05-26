<!--{template header}-->

<div class="layui-container fly-marginTop fly-user-main">
{template user_menu}

  
  <div class="fly-panel fly-panel-user" pad20>
   {if $user['active']==0}
    <div class="fly-msg" style="margin-top: 15px;">
      您的邮箱尚未验证，这比较影响您的帐号安全，<a href="{url user/editemail}">立即去激活？</a>
    </div>
  {/if}
    <div class="layui-tab layui-tab-brief" lay-filter="user">
  {template my_nav}
  <div class="mar-t10"></div>
      <!--{loop $doinglist $doing}-->
              <div class="layui-card">
  <div class="layui-card-header">         
   <!--{if $doing['hidden'] && in_array($doing['action'],array(1,8))}-->                  
   <a class="name">
   <img src="{eval echo get_avatar_dir(0);}" class="expertavatar" >
   <span>匿名用户{$doing['actiondesc']}</span>
   </a>
     <!--{else}-->
                   <a class="name" href="{url user/space/$doing['authorid']}" target="_self">
   <img src="{$doing['avatar']}" class="expertavatar" title="{$doing['author']}" alt="{$doing['author']}">
   <span>{$doing['author']}{$doing['actiondesc']}</span>
   </a>
                        <!--{/if}-->
                        
   </div>
  <div class="layui-card-body">
<a href="{$doing['url']}" target="_blank" class="colorlv">{$doing['content']}</a>
  </div>

   <div class="layui-card-footer">
   <p>
   {if !strstr($doing['actiondesc'],'关注')&&!strstr($doing['actiondesc'],'注册')}
   <span>{$doing['answers']} 个{if $doing['action']==9}评论{else}回复{/if}</span>
   <span>{$doing['attentions']}关注</span> 
    <span> {$doing['views']} 次浏览</span>
    {/if}
      <span> {if strstr($doing['actiondesc'],'注册')}注册于  {/if} {if strstr($doing['actiondesc'],'关注')}关注于  {/if}{$doing['doing_time']}</span>
 </p>
   </div>
</div>
               <!--{/loop}-->
               
          {template page}
                {if  !$doinglist }
        
         <div class="fly-none">没有相关数据</div> 
        {/if}
    </div>
  </div>
</div>
<!--{template footer}-->