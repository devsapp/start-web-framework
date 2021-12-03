<div class="tnvk_user_title">
 <div class="u_info_setting">
      <!--{if isset($is_followed)&&$is_followed}-->
          <button style="top:0px;line-height:0px;" class="ui-btn  btn-edit button_followed" onclick="attentto_user($member['uid'])" id="attenttouser_{$member['uid']}">
               
               已关注
            </button>
          <!--{else}-->
           <button style="top:0px;line-height:0px;" class="ui-btn btn-edit button_attention" onclick="attentto_user($member['uid'])" id="attenttouser_{$member['uid']}">
               +关注
            </button>
               <!--{/if}-->
 </div>
    <div class="u_info_card">
       <img  class="u_avatar" src="{$member['avatar']}?{eval echo rand(1,100);}">
        <div class="u_name_and_tip">
            <p class="u_name"><b>
            {$member['username']}</b>
            {if $member['author_has_vertify']!=false}
                <img class="u_icon_vertify" src="{SITE_URL}static/css/fronze/css/svg/diamond.svg">
              {/if}
              </p>
            <p class="u_tip"><span>关注 {eval echo byte_format($member['attentions']);} </span><span class="split">|</span><span>粉丝 {eval echo byte_format($member['followers']);} </span></p>
        </div>
    </div>
    <div class="u_list_card">
        <div class="u_list_item">
            <p><b>{eval echo byte_format($member['answers']);}</b></p>
            <p class="u_list_item_text">回答</p>
        </div>
        <div class="u_list_item">
            <p><b>{eval echo byte_format($member['questions']);}</b></p>
            <p class="u_list_item_text">问题</p>
        </div>
   
      <div class="u_list_item">
            <p><b>{eval echo byte_format($member['articles']);}</b></p>
            <p class="u_list_item_text">文章</p>
        </div>      
             <div class="u_list_item">
            <p><b>{eval echo byte_format($member['credit2']);}</b></p>
            <p class="u_list_item_text">财富</p>
        </div>
    </div>

    <div class="u_info_intro">
    
         {if $member['vertify']['status']==1}
 <p><b>认证信息:</b><span>{$member['vertify']['jieshao']}</span></p>


    {else}
    <p>{if $member['signature']}$member['signature']{else}该作者还未设置个人签名{/if}
             </p>
   {/if}  
   
        
    </div>
</div>
