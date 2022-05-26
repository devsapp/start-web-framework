<div class="fly-home fly-panel" style="background-image: url();">
  <img src="{$member['avatar']}" alt="{$member['username']}">
  {if $member['author_has_vertify']!=false} <i class="iconfont icon-renzheng"></i>{/if}
  <h1>
    {$member['username']}
   {if $member['sex']==0}  <i class="iconfont icon-nan"></i>{else} <i class="iconfont icon-nv"></i>{/if}
 
     {if $member['groupid']>6}  <i class="layui-badge fly-badge-vip" title="等级">{$member['grouptitle']}</i>{/if}
 
  </h1>

  <p style="padding: 10px 0; color: #5FB878;">{$member['signature']}</p>

  <p class="fly-home-info">
    <span style="color: #FF7200;" title="{$caifuzhiname}"><i style="color: #FF7200;" class="layui-icon layui-icon-diamond font13"></i>{$member['credit2']}</span>
    <i class="iconfont icon-shijian"></i><span>{eval echo tdate($member['regtime']);} 加入</span>
   
  </p>

  <p class="fly-home-sign">{$member['introduction']}</p>

  <div class="fly-sns" data-user="">
    <!--{if isset($is_followed)&&$is_followed}-->
     <a href="javascript:void(0);" id="attenttouser_{$member['uid']}" data-uid="{$member['uid']}" class="btnattention layui-btn layui-btn-warm fly-imActive layui-btn-sm" >取消关注</a>
     
     <!--{else}-->
   
      <a href="javascript:void(0);" id="attenttouser_{$member['uid']}" data-uid="{$member['uid']}" class="btnattention layui-btn layui-btn-primary fly-imActive layui-btn-sm" >+关注</a>
     
        <!--{/if}-->
        
    <a href="{url question/add/$member['uid']}" class="layui-btn layui-btn-normal fly-imActive layui-btn-sm" data-type="chat">对Ta咨询</a>
  </div>

</div>