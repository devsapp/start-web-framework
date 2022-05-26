<!--{template header}-->

<!-- 首页导航 --> 
{template index_nav}

{template space_title}

<div class="layui-container">
  <div class="layui-row layui-col-space15">
    <div class="layui-col-md8 fly-home-jie">
             <div class="fly-panel" style="margin-bottom: 0;">
     

 {template space_nav}
      <ul class="fly-list"> 
 {loop $answerlist $question}     
          <li>
            <a href="{url user/space/$question['authorid']}" class="fly-avatar">
              <img src="{eval echo get_avatar_dir($question['authorid']);}" alt="{$question['author']}">
            </a>
            <h2>
            {eval $categoryname=$this->category[$question['cid']]['name']}
              {if $categoryname}<a href="{url category/view/$question['cid']}" class="layui-badge">{$categoryname}</a>{/if}
              <a href="{url question/answer/$question['qid']/$question['id']}">{$question['title']}</a>
            </h2>
            <div class="fly-list-info">
              <a href="{url user/space/$question['authorid']}" >
                <cite>{$question['author']}</cite>
             
              </a>
              <span>{$question['time']}</span>
              
              {if $question['price']>0}<span class="fly-list-kiss layui-hide-xs" title="{$caifuzhiname}"><i class="layui-icon layui-icon-diamond font13"></i> {$question['price']}</span>{/if}
             {if $question['status']==2} <span class="layui-badge fly-badge-accept layui-hide-xs">已结</span>{/if}
              <span class="fly-list-nums"> 
                <i class="iconfont icon-pinglun1" title="评论数"></i> {$question['comments']}
              </span>
            </div>
            <div class="fly-list-badge">
              {if $question['status']==6}  <span class="layui-badge layui-bg-red">推荐</span>{/if}
            </div>
          </li>
          {/loop}
        </ul>
          {template page}
{if  !$answerlist }
        
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