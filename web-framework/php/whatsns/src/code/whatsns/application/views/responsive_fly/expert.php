 <!-- 公共头部--> 
{template header}

<!--  导航长度  -->
{eval $navlength=9;}
<div class="fly-panel fly-column">
  <div class="layui-container">
    <ul class="layui-clear gonavlist">
    <li class="layui-hide-xs {if $category['id']=='all'}layui-this{/if}"><a  href="{url expert/default}" title="全部文章">全部</a></li> 
    
                                               {eval  $catlist=$this->getlistbysql("select id,name,displayorder,grade from ".$this->db->dbprefix."category where iscourse=0 and isuseask=1 and grade=1 and pid=0 order by displayorder desc  limit 0,100");}
        {if $catlist}
                  <!--{loop $catlist $index $cat}-->
                  {if $index<$navlength}
      <li class="layui-hide-xs  {if $category['id']==$cat['id']}layui-this{/if}"><a  href="{url expert/default/$cat['id']/all}" title="{$cat['name']}">{$cat['name']}</a></li> 
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
      <dd class="{if $category['id']==$cat['id']}layui-this{/if}">
      <a href="{url expert/default/$cat['id']/all}">{$cat['name']}</a>
      </dd>
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
      <a href="{url user/vertify}" class="layui-btn">申请专家</a> 
    </div> 
    <div class="layui-hide-sm layui-show-xs-block" style="margin-top: -10px; padding-bottom: 10px; text-align: center;"> 
      <a href="{url user/vertify}" class="layui-btn">申请专家</a> 
    </div> 
  </div>
</div>


<div class="layui-container">
   <div class="nav_breadcrumb">
     <span class="layui-breadcrumb">
  <a href="{SITE_URL}">首页</a>
   <a href="{url expert/default}">专家列表</a>
 {if $category['id']!='all'}

  <a href="{url expert/default/$category['id']}">{$category['name']}</a>
  {/if}
  {if $status=='all'}
  <a href="{url expert/default/$category['id']/all}"><cite>全部专家</cite></a>
  {/if}
     {if $status=='1'}
  <a href="{url expert/default/$category['id']/1}"><cite>付费专家</cite></a>
  {/if}
     {if $status=='2'}
  <a href="{url expert/default/$category['id']/2}"><cite>免费专家</cite></a>
  {/if}
</span>
    </div>
  <div class="layui-row layui-col-space15">
    <div class="layui-col-md8">
 
   
      <div class="fly-panel" style="margin-bottom: 0;">
        
        <div class="fly-panel-title fly-filter">
          <a href="{url expert/default/$category['id']/all}" class="{if $status=='all'}layui-this{/if}">全部</a>
          <span class="fly-mid"></span>
          <a href="{url expert/default/$category['id']/2}" class="{if $status=='2'}layui-this{/if}">免费</a>
          <span class="fly-mid"></span>
          <a href="{url expert/default/$category['id']/1}" class="{if $status=='1'}layui-this{/if}">付费</a>
          <span class="fly-mid"></span>
          
        
        </div>

       {if  !$expertlist }
        
         <div class="fly-none">没有相关数据</div> 
        {/if}
  
           <!--{loop $expertlist $expert}-->
              <div class="layui-card">
  <div class="layui-card-header">                           
   <a class="name" href="{url user/space/$expert['uid']}" target="_self">
   <img src="{$expert['avatar']}" class="expertavatar" title="{$expert['username']}" alt="{$expert['username']}">
   <span>{$expert['username']}</span>
   {if $expert['author_has_vertify']!=false}<i class="iconfont icon-renzheng" title="认证信息：{$expert['signature']}"></i>{/if}</a>{if $expert['signature']}-<span class="text-color-hui">{$expert['signature']}</span>{/if}</div>
  <div class="layui-card-body">
  <p>{$expert['vertify']['jieshao']}</p>
  <p>{$expert['introduction']}  {if $user['groupid']==1}  <a target="_blank" title="修改专家信息" style="color:red;margin-left:10px;font-size:12px;" href="{url admin_user/edit/$expert['uid']}">修改</a>{/if}<p>
  {if !$expert['vertify']['jieshao']&&!$expert['introduction']}
  暂无专家介绍信息 {if $user['groupid']==1}  <a target="_blank" title="修改专家信息" style="color:red;margin-left:10px;font-size:12px;" href="{url admin_user/edit/$expert['uid']}">修改</a>{/if}
  {/if}
 
  </div>
  <div class="expcatbox">
  认证领域:
  {loop $expert['category'] $extcat}
  {if $extcat['categoryname']}<span class="layui-badge layui-bg-blue">{$extcat['categoryname']}</span>{/if}
  {/loop}
  </div>
  
   <div class="layui-card-footer">
   <p><span>{$expert['answers']}回答</span><span>{$expert['supports']}点赞</span><span>{$expert['followers']}关注</span> 
   <a class="fr hand extzixun" href="{url question/add/$expert[uid]}">
   {if $expert['mypay']>0}
   <span class="layui-badge">{$expert['mypay']}元咨询Ta</span>
   {else}
   <span class="layui-badge layui-bg-green   ">免费咨询Ta</span>
   {/if}
   </a></p>
   </div>
</div>
               <!--{/loop}-->
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