  <!-- 公共头部--> 
{template header}

<!--  导航长度  -->
{eval $navlength=9;}


<div class="layui-container">
   <div class="nav_breadcrumb">
     <span class="layui-breadcrumb">
  <a href="{SITE_URL}">首页</a>
  {if $catid=='all'||!$catid}
  <a href="{url seo/index}">全部</a>
  {else}
   <a href="{url seo/index}">专栏</a>
  <a href="{eval echo getcaturl($catmodel['id'],'seo/index/#id#');}">{$catmodel['name']}</a>
  {/if}
  {if $paixu=='new'}
  <a href="{eval echo getcaturl($catid,'seo/index/#id#/new');}"><cite>最新文章</cite></a>
  {/if}
    {if $paixu=='weeklist'}
  <a href="{eval echo getcaturl($catid,'seo/index/#id#/weeklist');}"><cite>热门文章</cite></a>
  {/if}
    {if $paixu=='hotlist'}
  <a href="{eval echo getcaturl($catid,'seo/index/#id#/hotlist');}"><cite>推荐文章</cite></a>
  {/if}
    {if $paixu=='credit'}
  <a href="{eval echo getcaturl($catid,'seo/index/#id#/credit');}"><cite>{$caifuzhiname}文章</cite></a>
  {/if}
    {if $paixu=='money'&&1==$setting['openwxpay']}
  <a href="{eval echo getcaturl($catid,'seo/index/#id#/money');}"><cite>付费文章</cite></a>
  {/if}
  
</span>
    </div>
  <div class="layui-row layui-col-space15">
    <div class="layui-col-md9">
 
   
      <div class="fly-panel" style="margin-bottom: 0;">
        
        <div class="fly-panel-title fly-filter">
          <a href="{eval echo getcaturl($catid,'seo/index/#id#/new');}" class="{if $paixu=='new'}layui-this{/if}">最新</a>
          <span class="fly-mid"></span>
          <a href="{eval echo getcaturl($catid,'seo/index/#id#/weeklist');}" class="{if $paixu=='weeklist'}layui-this{/if}">热门</a>
          <span class="fly-mid"></span>
          <a href="{eval echo getcaturl($catid,'seo/index/#id#/hotlist');}" class="{if $paixu=='hotlist'}layui-this{/if}">推荐</a>
          <span class="fly-mid"></span>
          
                    {if 1==$setting['openwxpay'] }
          <a href="{eval echo getcaturl($catid,'seo/index/#id#/money');}" class="{if $paixu=='money'}layui-this{/if}">付费</a>
         <span class="fly-mid"></span>
         {/if}
          <a href="{eval echo getcaturl($catid,'seo/index/#id#/credit');}" class="{if $paixu=='credit'}layui-this{/if}">{$caifuzhiname}</a>
        </div>

       {if  !$topiclist }
        
         <div class="fly-none">没有相关数据</div> 
        {/if}
       {template tmp_articlelist}
          {template page}
      </div>
    </div>
    <div class="layui-col-md3">
         {template rightbtn}
               <div class="aside-box"><form class="search-form" action="{url topic/search}" method="post" role="search">
    <div class="search-form-input-plane">
        <input type="text" class="search-keyword" name="word" placeholder="搜索内容" value="">
    </div>
  <div>
      <button type="submit" class="search-submit" value="">搜索</button>
  </div>
</form></div>
        <!-- 推荐文章 -->
     {template index_tuijianwenzhang}         
 <!-- 热门讨论问题 -->
     {template index_hotquestion}
 <!-- 右侧广告位 -->
    {template question_rightadv}
       <!-- 右侧最新文章-->
    {template right_lastwenzhang}
     <!-- 右侧最新评论-->
    {template right_lastpinglun}

    </div>
  </div>
</div>
 <!-- 公共底部 --> 
{template footer}