 <!-- 公共头部--> 
{template header}
 <!-- 首页导航 --> 
{template index_nav}

<div class="layui-container">
{template search_breadcrumb}
  <div class="layui-row layui-col-space15">
    <div class="layui-col-md8">

      <div class="fly-panel" style="margin-bottom: 0;">
        <!-- 公共搜索导航 -->
        {template search_nav}
    <div class="layui-row layui-col-space-2 hotcategorylist">
  
       <!--{loop $catlist  $category1}-->
    <div class="layui-col-md6">
 <div class="layui-card hotcategory">
  <div class="layui-card-header"><a href="{eval echo getcaturl($category1['id'],'category/view/#id#');}"> <img src="{$category1['image']}" class="catbigimage" title="{$category1['name']}" alt="{$category1['name']}">{$category1['name']}</a></div>
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
         
      <!-- 分页 -->
          {template page}

      </div>
    </div>
    <div class="layui-col-md4">
    
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