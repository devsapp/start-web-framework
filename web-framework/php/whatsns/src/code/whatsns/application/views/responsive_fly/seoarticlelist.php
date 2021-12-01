  <!-- 公共头部--> 
{template header}

<!--  导航长度  -->
{eval $navlength=9;}
<div class="fly-panel fly-column">
  <div class="layui-container">
    <ul class="layui-clear gonavlist">
    <li class="layui-hide-xs {if $catid=='all'||!$catid}layui-this{/if}"><a  href="{url seo/index}" title="全部文章">全部</a></li> 
    
                                               {eval  $catlist=$this->getlistbysql("select id,name,displayorder,grade from ".$this->db->dbprefix."category where iscourse=0 and isusearticle=1 and grade=1 and pid=0 order by displayorder desc  limit 0,100");}
        {if $catlist}
                  <!--{loop $catlist $index $cat}-->
                  {if $index<$navlength}
      <li class="layui-hide-xs  {if $pid==$cat['id']||$catid==$cat['id']}layui-this{/if}"><a  href="{eval echo getcaturl($cat['id'],'seo/index/#id#');}" title="{$cat['name']}">{$cat['name']}</a></li> 
{/if}
                    <!--{/loop}-->
                    {if count($catlist)>$navlength}
<li class="layui-hide-xs">
<ul class="layui-nav" lay-filter="">
      <li class="layui-nav-item hand">
    <a href="javascript:;">更多 <i class="layui-icon layui-icon-down"></i></a>
    <dl class="layui-nav-child">
    <!--{loop $catlist $index $cat}-->
     {if $index>=$navlength}
      <dd class=" {if $pid==$cat['id']||$catid==$cat['id']}layui-this{/if}"><a href="{eval echo getcaturl($cat['id'],'seo/index/#id#');}">{$cat['name']}</a></dd>
      {/if}
      <!--{/loop}-->
    </dl>
  </li>
  </ul> 
  </li>
                    {/if}
    {/if}
    </ul> 
    
    <div class="fly-column-right layui-hide-xs"> 
      <span class="fly-search"><i class="layui-icon"></i></span> 
      <a href="{url user/addxinzhi}" class="layui-btn">发表文章</a> 
    </div> 
    <div class="layui-hide-sm layui-show-xs-block" style="margin-top: -10px; padding-bottom: 10px; text-align: center;"> 
      <a href="{url user/addxinzhi}" class="layui-btn">发表文章</a> 
    </div> 
  </div>
</div>

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
    <div class="layui-col-md8">
 
   
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
    <div class="layui-col-md4">
        <!-- 推荐文章 -->
     {template index_tuijianwenzhang}         
 <!-- 热门讨论问题 -->
     {template index_hotquestion}
 <!-- 右侧广告位 -->
    {template question_rightadv}
       <!-- 右侧微信二维码 -->
    {template index_qrweixin}


    </div>
  </div>
</div>
 <!-- 公共底部 --> 
{template footer}