  <ul class="layui-nav layui-nav-tree layui-inline" lay-filter="user">
    <li class="layui-nav-item {if $regular=='user/default'||$regular=='user/ask'||$regular=='user/answer'||$regular=='topic/userxinzhi'||$regular=='user/recommend'}layui-this{/if}">
      <a href="{url user/default}">
        <i class="layui-icon">&#xe612;</i>
        用户中心
      </a>
    </li>
    <li class="layui-nav-item {if $regular=='user/profile'}layui-this{/if}">
      <a href="{url user/profile}">
        <i class="layui-icon">&#xe620;</i>
        基本设置
      </a>
    </li>
        <li class="layui-nav-item {if $regular=='user/attention'}layui-this{/if}">
      <a href="{url user/attention/question}">
        <i class="layui-icon layui-icon-heart-fill"></i>
       我的关注
      </a>
    </li>
    <li class="layui-nav-item {if ROUTE_A=='message'}layui-this{/if}">
      <a href="{url message/system}">
        <i class="layui-icon">&#xe611;</i>
        我的消息
      </a>
    </li>
      <li class="layui-nav-item {if $regular=='user/invatelist'}layui-this{/if}">
      <a href="{url user/invatelist}">
        <i class="layui-icon layui-icon-friends"></i>
        邀请推广
      </a>
    </li>
  </ul>
    <div class="site-tree-mobile layui-hide">
    <i class="layui-icon">&#xe602;</i>
  </div>
  <div class="site-mobile-shade"></div>
  
  <div class="site-tree-mobile layui-hide">
    <i class="layui-icon">&#xe602;</i>
  </div>
  <div class="site-mobile-shade"></div>
  
<ul class="layui-nav layui-nav-tree layui-inline hide" lay-filter="user">
  <li class="layui-nav-item"><a href="{url user/default}"><i class="layui-icon">&#xe609;</i>我的首页</a></li>
  <li class="layui-nav-item"><a href="{url user/attention/question}">我的关注</a></li>
  <li class="layui-nav-item"><a href="{url user/invatelist}">我的邀请</a></li>
  <li class="layui-nav-item"><a href="{url user/recommend}">为我推荐</a></li>
   <li class="layui-nav-item"><a href="{url user/ask}">我的提问</a></li>
    <li class="layui-nav-item"><a href="{url user/answer}">我的回答</a></li>
    <li class="layui-nav-item"><a href="{url topic/userxinzhi/$user['uid']}">我的文章</a></li>
     <li class="layui-nav-item"><a href="{url user/follower}">我的粉丝</a></li>

  <li class="layui-nav-item layui-nav-itemed">
    <a href="javascript:;">我的{$caifuzhiname}</a>
    <dl class="layui-nav-child">
      <dd><a href="{url user/level}">我的等级</a></dd>
      <dd><a href="{url user/myjifen}">{$caifuzhiname}等级</a></dd>
     {if $setting['recharge_open']==1}   <dd><a href="{url user/creditrecharge}">{$caifuzhiname}充值</a></dd>  {/if}
    </dl>
  </li>
   {if $setting['openwxpay']==1}
    <li class="layui-nav-item layui-nav-itemed">
    <a href="javascript:;">财务管理</a>
    <dl class="layui-nav-child">
      <dd><a href="{url user/recharge}">充值现金</a></dd>
      <dd><a href="{url user/userbank}">我的钱包</a></dd>
    <dd><a href="{url user/userzhangdan}">对账流水</a></dd>
    </dl>
  </li>
  
{/if}
</ul>
