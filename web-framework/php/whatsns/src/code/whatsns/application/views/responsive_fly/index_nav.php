<div class="fly-panel fly-column">
  <div class="layui-container">
    <ul class="layui-clear">
      <!--{eval $headernavlist = $this->fromcache("headernavlist");}-->
		  <!--{loop $headernavlist $headernav}-->
                    <!--{if $headernav['type']==1 && $headernav['available']}-->
                   
      <li class="layui-hide-xs <!--{if strstr($headernav['url'],$regular)}--> layui-this<!--{/if}-->"><a  href="{$headernav['format_url']}" title="{$headernav['title']}">{$headernav['name']}</a></li> 
    <!--{/if}-->
                    <!--{/loop}-->
      <li class="layui-hide-xs layui-hide-sm layui-show-md-inline-block"><span class="fly-mid"></span></li> 
      {if $user['uid']}
      <!-- 用户登入后显示 -->
      <li class="layui-hide-xs layui-hide-sm layui-show-md-inline-block"><a href="{url user/ask}">我的发表</a></li> 
      <li class="layui-hide-xs layui-hide-sm layui-show-md-inline-block"><a href="{url attention/question}">我的关注</a></li> 
    {/if}
    </ul> 
    
    <div class="fly-column-right layui-hide-xs"> 
      <span class="fly-search"><i class="layui-icon"></i></span> 
      <a href="{url question/add}" class="layui-btn">发表新帖</a> 
    </div> 
    <div class="layui-hide-sm layui-show-xs-block" style="margin-top: -10px; padding-bottom: 10px; text-align: center;"> 
      <a href="{url question/add}" class="layui-btn">发表新帖</a> 
    </div> 
  </div>
</div>