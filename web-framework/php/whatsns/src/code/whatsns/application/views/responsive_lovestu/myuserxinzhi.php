
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
     
                    {template tmp_articlelist}
               
          {template page}
                {if  !$topiclist }
        
         <div class="fly-none">没有相关数据</div> 
        {/if}
    </div>
  </div>
</div>
<!--{template footer}-->

