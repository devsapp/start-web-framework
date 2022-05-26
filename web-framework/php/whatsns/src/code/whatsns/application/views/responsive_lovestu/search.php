 <!-- 公共头部--> 
{template header}
 <!-- 首页导航 --> 
{template index_nav}

<div class="layui-container">
{template search_breadcrumb}
  <div class="layui-row layui-col-space15">
    <div class="layui-col-md9">

      <div class="fly-panel" style="margin-bottom: 0;">
        <!-- 公共搜索导航 -->
        {template search_nav}
        <!-- 搜索问题列表 -->
      {template tmp_questionlist}
      <!-- 分页 -->
          {template page}

      </div>
    </div>
    <div class="layui-col-md3">
    
   <!-- 热门讨论问题 -->
     {template index_hotquestion}

   

    
   <!-- 最新文章-->
            {template right_lastwenzhang}
             <!-- 右侧广告位 -->
    {template index_rightadv}
    
   <!-- 站长推荐文章 -->
             {template index_tuijianwenzhang}
            

    </div>
  </div>
</div>
 <!-- 公共底部 --> 
{template footer}