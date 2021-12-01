 <!--{if $setting['sinalogin_open']||$setting['qqlogin_open']||$setting['wechat_open']}-->
  <!-- 更多登录方式 -->
  <div class="more-sign">

    <h6>社交帐号登录</h6>
    <ul>
        <!--{if $setting['sinalogin_open']}-->
  <li><a class="weibo" href="{SITE_URL}plugin/sinalogin/index.php"><i class="fa fa-weibo"></i></a></li>
    <!--{/if}-->
      <!--{if $setting['wechat_open']}-->
  <li><a class="weixin" href="{url plugin_weixin/openauth}"><i class="fa fa-wechat"></i></a></li>
   <!--{/if}-->
  <!--{if $setting['qqlogin_open']}-->
  <li><a class="qq" href="{SITE_URL}plugin/qqlogin/index.php"><i class="fa fa-qq"></i></a></li>
     <!--{/if}-->
        <!--{if $setting['other_open']}-->
    <li class="js-more-method"><a href="javascript:void(0);"><i class="fa fa-more">其它</i></a></li>
    <li class="js-hide-method hide"><a class="douban" href="javascript:void(0)"><i class="iconfont ic-douban"></i></a></li>
  <!--{/if}-->
</ul>

  </div>
   <!--{/if}-->