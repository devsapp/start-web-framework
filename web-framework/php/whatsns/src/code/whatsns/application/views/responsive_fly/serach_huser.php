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
       <div class="fly-panel fly-rank fly-rank-reply" id="LAY_replyRank">
      
        <dl>
      
          {loop $userlist $reguser}
          <dd>
            <a href="{url user/space/$reguser['uid']}">
              <img src="{eval echo get_avatar_dir($reguser['uid']);}"><cite title="{$reguser['username']}">{$reguser['username']}</cite><i title="{eval echo tdate($reguser['regtime']);}">{eval echo tdate($reguser['regtime']);}</i>
            </a>
          </dd>
          {/loop}
        </dl>
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