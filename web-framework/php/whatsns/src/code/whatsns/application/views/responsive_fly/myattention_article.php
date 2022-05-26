<!--{template header}-->

<div class="layui-container fly-marginTop fly-user-main">
{template user_menu}

  
  <div class="fly-panel fly-panel-user" pad20>
    <div class="layui-tab layui-tab-brief" lay-filter="user">
    {template myattention_nav}
     
      <div class="layui-tab-content" style="padding: 20px 0;">
        <div class="layui-tab-item layui-show">
    
  <ul class="mine-view jie-row">
  <!--{loop $topiclist $index $topic}-->
            <li>
              <a class="jie-title" href="{url topic/getone/$topic['tid']}" target="_blank">{$topic['title']}</a>
              <i>收藏于{$topic['format_time']}</i>  <a style="color:#009688;font-size:12px;" class="fr font12"  href="{url favorite/delfavoratearticle/$topic['tid']}" >
                                               取消收藏
                </a>  </li>
                 <!--{/loop}-->
          </ul>
              {template page}
            {if  !$topiclist}<div class="fly-none" style="min-height: 50px; padding:30px 0; height:auto;"><i style="font-size:14px;">没有收藏任何文章</i></div> 
          {/if}
          <div id="LAY_page"></div>
        </div>
    
      </div>
    </div>
  </div>
</div>
<!--{template footer}-->

