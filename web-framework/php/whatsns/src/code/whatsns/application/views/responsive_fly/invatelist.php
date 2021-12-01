


<!--{template header}-->

<div class="layui-container fly-marginTop fly-user-main">
{template user_menu}

  
  <div class="fly-panel fly-panel-user" pad20>
  
    <div class="fly-msg" style="margin-top: 15px;">
     <div class="invateaddress">
  <p>复制邀请注册地址分享给好友:<span>{url user/register/$user['invatecode']}</span></p>
  {if $this->setting ['credit1_invate']!=null}<p>邀请注册可获得经验值：{$setting['credit1_invate']}点，财富值：{$setting['credit2_invate']}点{/if}
  </div>
    </div>
    
    <div class="layui-tab layui-tab-brief" lay-filter="user">
   
 <div class="fly-panel-title fly-filter">
          <a href="{url user/invatelist}" class="{if $regular=='user/invatelist'}layui-this{/if}">我邀请的人</a>
         
       
        </div>
      <div class="fly-panel fly-rank fly-rank-reply" id="LAY_replyRank">

      
        <dl>
        
          {loop  $followerlist $follower}
          <dd>
            <a href="{url user/space/$follower['uid']}">
              <img src="{eval echo get_avatar_dir($follower['uid']);}"><cite title="{$follower['username']}">{$follower['username']}</cite><i title="{eval echo tdate($follower['info']['regtime']);}">{eval echo tdate($follower['info']['regtime']);}</i>
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

