<!--{template header}-->

<div class="layui-container fly-marginTop fly-user-main">
{template user_menu}

  
  <div class="fly-panel fly-panel-user" pad20>
    <div class="layui-tab layui-tab-brief" lay-filter="user">
     {template myattention_nav}
      <div class="layui-tab-content" style="padding: 20px 0;">
        <div class="layui-tab-item layui-show">
    
  <ul class="mine-view jie-row">
    <!--{loop $questionlist $question}-->
            <li>
              <a class="jie-title" href="{url question/view/$question['id']}" target="_blank">{$question['title']}</a>
              <i>收藏于{$question['attention_time']}</i>  <a style="color:#009688;font-size:12px;" class="fr font12"  href="{url favorite/delfavoratequestion/$question['id']}" >
                                               取消收藏
                </a>  </li>
                 <!--{/loop}-->
          </ul>
            {if  !$questionlist}<div class="fly-none" style="min-height: 50px; padding:30px 0; height:auto;"><i style="font-size:14px;">没有收藏任何问题</i></div> 
          {/if}
           {template page}
          <div id="LAY_page"></div>
        </div>
    
      </div>
    </div>
  </div>
</div>
<!--{template footer}-->

