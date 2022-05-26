<style>
<!--
.person{
    background: #fff;
    margin:20px auto;
    padding-left:20px;
}
-->
</style>
<div class="list-group">
<a href="{url user/default}" class="router-link-active list-group-item">主页</a>
</div>

<div class="list-group">
<a href="{url user/profile}" class="list-group-item {if $regular=='user/profile'}active{/if}">
      个人资料
    </a>
    <a href="{url user/usernotify}" class="list-group-item {if $regular=='user/usernotify'}active{/if}">通知和私信</a>
<a href="{url user/mycategory}" class="list-group-item {if $regular=='user/mycategory'}active{/if}">我的设置</a>
     <a href="{url user/vertify}" class="list-group-item {if $regular=='user/vertify'}active{/if}">申请认证</a>
<a href="{url user/uppass}" class="list-group-item {if $regular=='user/uppass'}active{/if}">修改密码</a>
<a href="{url user/editemail}" class="list-group-item {if $regular=='user/editemail'}active{/if}">修改邮箱</a>
<a href="{url user/editphone}" class="list-group-item {if $regular=='user/editphone'}active{/if}">修改手机号</a>
<a href="{url user/editimg}" class="list-group-item {if $regular=='user/editimg'}active{/if}">修改头像</a>

    </div>
