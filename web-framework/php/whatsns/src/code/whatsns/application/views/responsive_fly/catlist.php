 <!-- 公共头部--> 
{template header}

<div class="alone-banner layui-bg-black">
  <div class="layui-container">
    <h1 style="padding-top: 40px;">{$catmodel['name']}</h1>
        <p>收录了{$rownum}篇文章 ·{$catmodel['questions']}个问题 · {$catmodel['followers']}人关注</p>
        
    <p title="{eval echo strip_tags($catmodel['miaosu']);}"> {if $catmodel['miaosu']}{eval echo clearhtml($catmodel['miaosu'],300);}{else}该话题暂未添加描述信息{/if}</p>
    <p>
    {if $is_followed}

<button class="layui-btn layui-btn-primary btnattentionhuati layui-btn-sm" id="attenttouser_{$catmodel['id']}" data-id="$catmodel['id']">取消关注</button>
    
{else}

<button class="layui-btn layui-btn-normal btnattentionhuati layui-btn-sm" id="attenttouser_{$catmodel['id']}" data-id="$catmodel['id']">+关注话题</button>
    
{/if}
    
    </p>
  </div>
</div>
<div class="layui-container">

  <div class="layui-row layui-col-space15">
    <div class="layui-col-md8">

      <div class="fly-panel" style="margin-bottom: 0;">
        
        <div class="fly-panel-title fly-filter">
           
          <a href="{eval echo getcaturl($cid,'topic/catlist/#id#');}" class="layui-this">文章</a>
          
             <span class="fly-mid"></span>
              <a href="{eval echo getcaturl($catmodel['id'],'category/view/#id#');}" class="">相关问题</a>
      
        </div>
 <!-- 最新问答列表 --> 
 
      {template tmp_articlelist}
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