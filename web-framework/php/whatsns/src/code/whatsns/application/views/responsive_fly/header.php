{template meta}
<div class="fly-header layui-bg-black">
  <div class="layui-container">
    <a class="fly-logo" href="/">
      <img src="{$setting['site_logo']}" alt="{$setting['site_name']}" style="width:130px;height:30px;">
    </a>
    <ul class="layui-nav fly-nav layui-hide-xs">
      <li class="layui-nav-item {if $regular=='ask/index'}layui-this{/if}">
        <a href="{url ask/index}"><i class="iconfont icon-jiaoliu"></i>交流</a>
      </li>
      <li class="layui-nav-item {if $regular=='seo/index'}layui-this{/if}">
        <a href="{url seo/index}"><i class="iconfont icon-iconmingxinganli"></i>专栏</a>
      </li>
      <li class="layui-nav-item {if $regular=='expert/default'}layui-this{/if}">
        <a href="{url expert/default}" ><i class="iconfont icon-ui"></i>专家</a>
      </li>
    </ul>
    
    <ul class="layui-nav fly-nav-user">
      {if !$user['uid']}
   
      <!-- 未登入的状态 -->
      <li class="layui-nav-item">
        <a class="iconfont icon-touxiang layui-hide-xs" href="{url user/login}"></a>
      </li>
      <li class="layui-nav-item">
        <a href="{url user/login}">登入</a>
      </li>
      <li class="layui-nav-item">
        <a href="{url user/register}">注册</a>
      </li>
        <!--{if $setting['qqlogin_open']}-->
      <li class="layui-nav-item layui-hide-xs">
        <a href="{SITE_URL}plugin/qqlogin/index.php" onclick="layer.msg('正在通过QQ登入', {icon:16, shade: 0.1, time:0})" title="QQ登入" class="iconfont icon-qq"></a>
      </li>
          <!--{/if}-->
           <!--{if $setting['sinalogin_open']}-->
      <li class="layui-nav-item layui-hide-xs">
        <a href="{url plugin_weixin/openauth}" onclick="layer.msg('正在通过微信登入', {icon:16, shade: 0.1, time:0})" title="微信登入" class="iconfont icon-weibo"></a>
      </li>
        <!--{/if}-->
      {else}
      <!-- 登入后的状态 -->
     
      <li class="layui-nav-item">
     
        <a class="fly-nav-avatar" href="javascript:;">
          <cite class="layui-hide-xs">{$user['username']}</cite>
          <i class="iconfont icon-renzheng layui-hide-xs" title="{$user['signature']}"></i>
          <i class="layui-badge fly-badge-vip layui-hide-xs" title="{$user['grouptitle']}">Level{$user['level']}</i>
          <img src="{$user['avatar']}">
        </a>
        <dl class="layui-nav-child">
         {if $user['groupid']==1}  <dd><a href="{SITE_URL}index.php?admin_main/stat"><i class="layui-icon layui-icon-console"></i>后台管理</a></dd>{/if}
      
          <dd><a href="{url user/profile}"><i class="layui-icon">&#xe620;</i>基本设置</a></dd>
          <dd><a href="{url message/system}"><i class="iconfont icon-tongzhi" style="top: 4px;"></i>我的消息</a></dd>
          <dd><a href="{url user/default}"><i class="layui-icon" style="margin-left: 2px; font-size: 22px;">&#xe68e;</i>我的主页</a></dd>
      
          <hr style="margin: 5px 0;">
          <dd><a href="{url user/logout}" style="text-align: center;">退出</a></dd>
        </dl>
      </li>
     {/if}
    </ul>
  </div>
</div>

