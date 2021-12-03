<div class="tnvk_user_title">
 <div class="u_info_setting">

     <img class="u_icon_setting" src="{SITE_URL}static/css/fronze/css/svg/setting.svg">
 </div>
    <div class="u_info_card">
       <img onclick="window.location.href='{url user/editimg}'" class="u_avatar" src="{$user['avatar']}?{eval echo rand(1,100);}">
        <div class="u_name_and_tip">
            <p class="u_name"><b>
            {$user['username']}</b>
            {if $user['author_has_vertify']!=false}
                <img class="u_icon_vertify" src="{SITE_URL}static/css/fronze/css/svg/diamond.svg">
              {/if}
              </p>
            <p class="u_tip"><span>关注 {eval echo byte_format($user['attentions']);} </span><span class="split">|</span><span>粉丝 {eval echo byte_format($user['followers']);} </span></p>
        </div>
    </div>
    <div class="u_list_card">
        <div class="u_list_item">
            <p><b>{eval echo byte_format($user['answers']);}</b></p>
            <p class="u_list_item_text">回答</p>
        </div>
        <div class="u_list_item">
            <p><b>{eval echo byte_format($user['questions']);}</b></p>
            <p class="u_list_item_text">问题</p>
        </div>
        <div class="u_list_item">
            <p><b>{eval echo byte_format($user['credit2']);}</b></p>
            <p class="u_list_item_text">财富</p>
        </div>
     
    </div>

    <div class="u_info_intro">
        <p>{if $user['signature']}$user['signature']{else}设置签名让别人了解你{/if}
               <img onclick="window.location.href='{url user/profile}'" class="u_icon_edit"  src="{SITE_URL}static/css/fronze/css/svg/edit.svg">
             </p>
    </div>
</div>

 
<script type="text/javascript">
$(".u_icon_setting").click(function(){
	 window.location.href="{url user/default/set}";
	
})
function hidemenu(){
	 $('.ui-actionsheet').removeClass('show');
}
//编辑用户名和权限
function editmodle(){
	$("#mypay").val("{$user['mypay']}")
	 $('#dialogeditusername').dialog('show');
	
}


</script>
    

