<!--{template header}-->

<!-- 首页导航 --> 
{template index_nav}

{template space_title}

<div class="layui-container">
  <div class="layui-row layui-col-space15">
    <div class="layui-col-md8 fly-home-jie">
             <div class="fly-panel" style="margin-bottom: 0;">
 {template space_nav}
      <div class="layui-row layui-col-space-2 hotcategorylist">
  
       <!--{loop $categorylist  $category1}-->
    <div class="layui-col-md6">
 <div class="layui-card hotcategory">
  <div class="layui-card-header"><a href="{eval echo getcaturl($category1['id'],'category/view/#id#');}"> <img src="{$category1['bigimage']}" class="catbigimage" title="{$category1['name']}" alt="{$category1['name']}">{$category1['name']}</a></div>
  <div class="layui-card-body">
  <p class="layui-text	">
  {if $category1['miaosu']}
{eval echo clearhtml($category1['miaosu']);}
   {else}
该话题暂无描述
{/if}
</p>
  </div>
  <div class="layui-card-footer">
  <p><span>{$category1['questions']}个问题</span><span>{$category1['followers']}个关注</span></p>
  </div>
</div>
    </div>
  <!--{/loop}-->
  </div>
          {template page}
{if  !$categorylist }
        
         <div class="fly-none">没有相关数据</div> 
        {/if}
      </div>
    </div>
    
    <div class="layui-col-md4 fly-home-da">
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