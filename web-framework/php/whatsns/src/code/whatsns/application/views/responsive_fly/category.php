 <!-- 公共头部--> 
{template header}

<div class="alone-banner layui-bg-black">
  <div class="layui-container">
    <h1 style="padding-top: 40px;">{$category['name']} </h1>
        <p>  收录了{$trownum}篇文章 ·{$category['questions']}个问题 · {$category['followers']}人关注</p>
        
    <p title="{eval echo strip_tags($category['miaosu']);}"> {if $category['miaosu']}{eval echo clearhtml($category['miaosu'],300);}{else}该话题暂未添加描述信息{/if}{if $user['groupid']==1} <a target="_blank" style="color:red;margin-left:10px;font-size:12px;" href="{url admin_category/edit/$category['id']}" title="修改描述">修改</a>{/if}</p>
    <p>
    {if $is_followed}

<button class="layui-btn layui-btn-primary btnattentionhuati layui-btn-sm" id="attenttouser_{$category['id']}" data-id="$category['id']">取消关注</button>
    
{else}

<button class="layui-btn layui-btn-normal btnattentionhuati layui-btn-sm" id="attenttouser_{$category['id']}" data-id="$category['id']">+关注话题</button>
    
{/if}
    
    </p>
  </div>
</div>
<div class="layui-container">

  <div class="layui-row layui-col-space15">
    <div class="layui-col-md8">

      <div class="fly-panel" style="margin-bottom: 0;">
        
        <div class="fly-panel-title fly-filter">
          <a href="{eval echo getcaturl($cid,'category/view/#id#');}" class="{if $status=='all'}layui-this{/if}">全部</a>
          <span class="fly-mid"></span>
          <a href="{eval echo getcaturl($cid,'category/view/#id#/1');}" class="{if $status==1}layui-this{/if}">未结</a>
          <span class="fly-mid"></span>
          <a href="{eval echo getcaturl($cid,'category/view/#id#/2');}" class="{if 2==$status}layui-this{/if}">已结</a>
          <span class="fly-mid"></span>
                    <a href="{eval echo getcaturl($cid,'category/view/#id#/6');}" class="{if $status==6}layui-this{/if}">推荐</a>
       {if $category['isusearticle']}
         <span class="fly-mid"></span>
          <a href="{eval echo getcaturl($cid,'topic/catlist/#id#');}" class="">文章</a>
          
          {/if}
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