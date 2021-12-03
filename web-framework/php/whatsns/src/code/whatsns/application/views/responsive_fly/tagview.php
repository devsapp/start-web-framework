<!--{template header}-->

<!-- 首页导航 --> 
{template index_nav}

<div class="layui-container collection index " style="margin-bottom: 20px;">
   <div class="nav_breadcrumb">
     <span class="layui-breadcrumb">
  <a href="{SITE_URL}">首页</a>

   <a href="{url tags}">标签</a>
   <a >标签动态</a>

  
</span>
    </div>
    
  <div class="layui-row layui-col-space15"  >
    <div class="layui-col-md8">
    <div class="layui-card">
  <div class="layui-card-header"> {if $tag['tagimage']} <img class="tagimage" src="{$tag['tagimage']}">{/if}{$tag['tagname']} {if $user['groupid']==1}  <a target="_blank" style="color:red;margin-left:20px;font-size:12px;" href="{url admin_tag/edit/$tag['tagalias']}">修改</a>{/if}</div>
  <div class="layui-card-body">
  <p>{if $tag['description']}$tag['description']{else}该标签暂无描述{/if}</p>
  </div>
</div>
     <div class="fly-panel" style="margin-bottom: 0;">
        
        <div class="fly-panel-title fly-filter">
          <a href="{url tags/view/$tagalias}" class="{if strstr('tags/view',$regular)}layui-this{/if}">标签动态</a>
          <span class="fly-mid"></span>
         <a href="{url tags/question/$tagalias}" class="{if strstr('tags/question',$regular)}layui-this{/if}">标签问答</a>
          <span class="fly-mid"></span>
        <a href="{url tags/article/$tagalias}" class="{if strstr('tags/article',$regular)}layui-this{/if}">标签文章</a>
          
         
          
        </div>

 <!-- 列表 -->
  {template tmp_taglist}
           {if !$tagdoinglist}     
        <div class="fly-none">没有相关数据</div>
        {/if}
          {template page}

      </div>
      
       
          
    </div>

    <div class="layui-col-md4">

                    <div class="layui-card">
  <div class="layui-card-header">相关标签</div>
  <div class="layui-card-body">
    <ul class="taglist--inline multi" >
                                   {loop $relativetags $rtag}
                                  {if $rtag['tagname']!=$tag['tagname']}
                                                            <li class="tagPopup">
                                    <a class="tag" href="{url tags/view/$rtag['tagalias']}" >
                                                                          {if $rtag['tagimage']}  <img src="$rtag['tagimage']">{/if}
                                                                        {$rtag['tagname']}</a>
                                </li>{/if}
                                               {/loop}             
                                                    </ul>
  </div>
</div>

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
<!--{template footer}-->