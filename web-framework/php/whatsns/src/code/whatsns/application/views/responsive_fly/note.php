  <!-- 公共头部--> 
{template header}
 <!-- 首页导航 --> 
{template index_nav}
<link rel="stylesheet" type="text/css" href="{SITE_URL}static/js/wangeditor/pcwangeditor/css/wangEditor.min.css">
<div class="layui-container">
  <div class="layui-row layui-col-space15">
    <div class="layui-col-md8 content detail">
      <div class="fly-panel detail-box">
        <h1>{$note['title']}</h1>
        <div class="fly-detail-info">
     
          <div class="fly-admin-box" data-id="123">
            <span class="layui-btn layui-btn-xs jie-admin" type="del">删除</span>
            
       
          </div>
          <span class="fly-list-nums"> 
            <a href="#comment"><i class="iconfont" title="评论">&#xe60c;</i> {$note['comments']}</a>
            <i class="iconfont" title="人气">&#xe60b;</i>{$note['views']}
          </span>
        </div>
        <div class="detail-about">
          <a class="fly-avatar" href="{url user/space/$note['authorid']}">
            <img src="{$note['avatar']}" alt="{$topicone['author']}">
          </a>
          <div class="fly-detail-user">
            <a href="{url user/space/$note['authorid']}" class="fly-link">
              <cite> {$note['author']}</cite>
            {if $note['author_has_vertify']!=false}  <i class="iconfont icon-renzheng" title="认证信息：{$note['signature']}"></i>{/if}
             
            </a>
            <span>{$note['format_time']}</span>
          </div>
          <div class="detail-hits" id="LAY_jieAdmin" data-id="123">
  {if $user['grouptype']==1}
            <span class="layui-btn layui-btn-xs jie-admin" type="edit"><a href="{url admin_note/edit/$note['id']}">编辑公告</a></span>
          {/if}
          </div>
        </div>
        <div class="detail-body photos">
            <div class="wangEditor-container" style="border:none;">
            	<div class="wangEditor-txt" style="padding:0px;">
         {$note['content']}


</div>
</div>
        </div>
      </div>

     
    </div>
    <div class="layui-col-md4">
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

 <!-- 公共底部 --> 
{template footer}