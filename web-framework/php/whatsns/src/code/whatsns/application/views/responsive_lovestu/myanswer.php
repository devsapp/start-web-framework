<!--{template header}-->

<div class="layui-container fly-marginTop fly-user-main">
{template user_menu}

  
  <div class="fly-panel fly-panel-user" pad20>
   {if $user['active']==0}
    <div class="fly-msg" style="margin-top: 15px;">
      您的邮箱尚未验证，这比较影响您的帐号安全，<a href="{url user/editemail}">立即去激活？</a>
    </div>
  {/if}
    <div class="layui-tab layui-tab-brief" lay-filter="user">
  {template my_nav}
     
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
</div>
<!--{template footer}-->