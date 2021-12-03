<div class="fly-home fly-panel" style="background-image: url();">
  <img src="{$user['avatar']}" alt="{$user['username']}">
  {if $user['author_has_vertify']!=false} <i class="iconfont icon-renzheng"></i>{/if}
  <h1>
    {$user['username']}
   {if $user['sex']==0}  <i class="iconfont icon-nan"></i>{else} <i class="iconfont icon-nv"></i>{/if}
 
     {if $user['groupid']>6}  <i class="layui-badge fly-badge-vip" title="等级">{$user['grouptitle']}</i>{/if}
 
  </h1>

  <p style="padding: 10px 0; color: #5FB878;">{$user['signature']}</p>

  <p class="fly-home-info">
    <span style="color: #FF7200;" title="{$caifuzhiname}"><i style="color: #FF7200;" class="layui-icon layui-icon-diamond font13"></i>{$user['credit2']}</span>
    <i class="iconfont icon-shijian"></i><span>{eval echo tdate($user['regtime']);} 加入</span>
   
  </p>

  <p class="fly-home-sign">{$user['introduction']}</p>

  <div class="fly-sns" data-user="">
    <!--{if isset($is_followed)&&$is_followed}-->
     <a href="javascript:void(0);" id="attenttouser_{$user['uid']}" data-uid="{$user['uid']}" class="btnattention layui-btn layui-btn-warm fly-imActive layui-btn-sm" >取消关注</a>
     
     <!--{else}-->
   
      <a href="javascript:void(0);" id="attenttouser_{$user['uid']}" data-uid="{$user['uid']}" class="btnattention layui-btn layui-btn-primary fly-imActive layui-btn-sm" >+关注</a>
     
        <!--{/if}-->
        
    <a href="{url question/add/$user['uid']}" class="layui-btn layui-btn-normal fly-imActive layui-btn-sm" data-type="chat">对Ta咨询</a>
  </div>

</div>