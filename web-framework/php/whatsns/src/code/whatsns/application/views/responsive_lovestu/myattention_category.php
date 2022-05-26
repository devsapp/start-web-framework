

<!--{template header}-->

<div class="layui-container fly-marginTop fly-user-main">
{template user_menu}

  
  <div class="fly-panel fly-panel-user" pad20>
    <div class="layui-tab layui-tab-brief" lay-filter="user">
     {template myattention_nav}
      <div class="layui-tab-content" style="padding: 20px 0;">
        <div class="layui-tab-item layui-show">
    
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
        </div>
    
      </div>
    </div>
  </div>
</div>
<!--{template footer}-->



