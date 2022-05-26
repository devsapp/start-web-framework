<!--{template header}-->

<!-- 首页导航 --> 
{template index_nav}

{template space_title}

<div class="layui-container">
  <div class="layui-row layui-col-space15">
    <div class="layui-col-md8 fly-home-jie">
             <div class="fly-panel" style="margin-bottom: 0;">
     

 {template space_nav}
      {template tmp_articlelist}
          {template page}
{if  !$topiclist }
        
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