 <!-- 公共头部--> 
{template header}
 <!-- 首页导航 --> 
{template index_nav}

<div class="layui-container">

  <div class="layui-row layui-col-space15">
    <div class="layui-col-md8">
 
   
      <div class="fly-panel" style="margin-bottom: 0;">
        
        <div class="fly-panel-title fly-filter">
   
                                   <!--{if $type=='atentto'}-->
         
                     <a href="{url doing/default}" class="layui-this">关注的动态</a>
          <span class="fly-mid"></span>
           <a href="{url doing/default/my}" class="">我的动态</a>
          <span class="fly-mid"></span>
          <a href="{url doing/default/all}" class="">全站动态</a>
          <span class="fly-mid"></span>
          
                
                    <!--{elseif $type=='my'}-->
                    <a href="{url doing/default}" class="">关注的动态</a>
          <span class="fly-mid"></span>
           <a href="{url doing/default/my}" class="layui-this">我的动态</a>
          <span class="fly-mid"></span>
          <a href="{url doing/default/all}" class="">全站动态</a>
          <span class="fly-mid"></span>
          
                    <!--{elseif $type=='all'}-->
                    <!--{if $this->user['uid']}-->
                   <a href="{url doing/default}" class="">关注的动态</a>
          <span class="fly-mid"></span>
           <a href="{url doing/default/my}" class="">我的动态</a>
          <span class="fly-mid"></span>
                    <!--{/if}-->
                    
          <a href="{url doing/default/all}" class="layui-this">全站动态</a>
          <span class="fly-mid"></span>
          
                    <!--{/if}-->
                    
        
        </div>

 
  
          <!--{loop $doinglist $doing}-->
              <div class="layui-card">
  <div class="layui-card-header">         
   <!--{if $doing['hidden'] && in_array($doing['action'],array(1,8))}-->                  
   <a class="name">
   <img src="{eval echo get_avatar_dir(0);}" class="expertavatar" >
   <span>匿名用户{$doing['actiondesc']}</span>
   </a>
     <!--{else}-->
                   <a class="name" href="{url user/space/$doing['authorid']}" target="_self">
   <img src="{$doing['avatar']}" class="expertavatar" title="{$doing['author']}" alt="{$doing['author']}">
   <span>{$doing['author']}{$doing['actiondesc']}</span>
   </a>
                        <!--{/if}-->
                        
   </div>
  <div class="layui-card-body">
<a href="{$doing['url']}" target="_blank" class="colorlv">{$doing['content']}</a>
  </div>

   <div class="layui-card-footer">
   <p>
   {if !strstr($doing['actiondesc'],'关注')}
   <span>{$doing['answers']} 个{if $doing['action']==9}评论{else}回复{/if}</span>
   <span>{$doing['attentions']}关注</span> 
    <span> {$doing['views']} 次浏览</span>
    {/if}
      <span> {if strstr($doing['actiondesc'],'关注')}关注于  {/if}{$doing['doing_time']}</span>
 </p>
   </div>
</div>
               <!--{/loop}-->
               
          {template page}
                {if  !$doinglist }
        
         <div class="fly-none">没有相关数据</div> 
        {/if}
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