 <!-- 公共头部--> 
{template header}


<div class="layui-container">
 
  <div class="nav_breadcrumb">
     <span class="layui-breadcrumb">
  <a href="{SITE_URL}">首页</a>

   <a href="{url ask/index}">问题库</a> 
</span>
    </div>
  <div class="layui-row layui-col-space15">
    <div class="layui-col-md9">

      <div class="fly-panel" style="margin-bottom: 0;">
        
        <div class="fly-panel-title fly-filter">
          <a href="{eval echo getcaturl($cid,'ask/index/#id#');}" class="{if $paixuname=='all'}layui-this{/if}">全部</a>
          <span class="fly-mid"></span>
          <a href="{eval echo getcaturl($cid,'ask/index/#id#/nosolve');}" class="{if $paixuname=='nosolve'}layui-this{/if}">未结</a>
          <span class="fly-mid"></span>
          <a href="{eval echo getcaturl($cid,'ask/index/#id#/solve');}" class="{if $paixuname=='solve'}layui-this{/if}">已结</a>
          <span class="fly-mid"></span>
                    <a href="{eval echo getcaturl($cid,'ask/index/#id#/caifu');}" class="{if $paixuname=='caifu'}layui-this{/if}">财富</a>
      
          
        </div>
 <!-- 最新问答列表 --> 
 
      {template tmp_questionlist}
          {template page}

      </div>
    </div>
    <div class="layui-col-md3">
         {template rightbtn}
               <div class="aside-box"><form class="search-form" action="{url question/search}" method="post" role="search">
    <div class="search-form-input-plane">
        <input type="text" class="search-keyword" name="word" placeholder="搜索内容" value="">
    </div>
  <div>
      <button type="submit" class="search-submit" value="">搜索</button>
  </div>
</form></div>
 <!-- 热门讨论问题 -->
     {template index_hotquestion}
 <!-- 右侧广告位 -->
    {template question_rightadv}
     <!-- 推荐文章 -->
     {template index_tuijianwenzhang}  

    </div>
  </div>
</div>
 <!-- 公共底部 --> 
{template footer}