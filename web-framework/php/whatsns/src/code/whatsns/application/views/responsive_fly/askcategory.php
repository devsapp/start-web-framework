 <!-- 公共头部--> 
{template header}
 <!-- 移动端搜索框--> 
{template searchbox}
 <!-- 首页导航 --> 
{template index_nav}

<div class="layui-container">
  <div class="nav_breadcrumb">
     <span class="layui-breadcrumb">
  <a href="{SITE_URL}">首页</a>

   <a href="{url ask/index}">问题库</a> 
</span>
    </div>
  <div class="layui-row layui-col-space15">
    <div class="layui-col-md8">

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