  <ul class="fly-list"> 
 {loop $questionlist $question}       
          <li>
            <a href="{url user/space/$question['authorid']}" class="fly-avatar">
              <img src="{eval echo get_avatar_dir($question['authorid']);}" alt="{$question['author']}">
            </a>
            <h2>
            {eval $categoryname=$this->category[$question['cid']]['name']}
              {if $categoryname}<a href="{url category/view/$question['cid']}" class="layui-badge">{$categoryname}</a>{/if}
              <a href="{url question/view/$question['id']}">{$question['title']}</a>
            </h2>
            <div class="fly-list-info">
              <a href="{url user/space/$question['authorid']}" >
                <cite>{$question['author']}</cite>
                <!--
                <i class="iconfont icon-renzheng" title="认证信息：XXX"></i>
                <i class="layui-badge fly-badge-vip">VIP3</i>
                -->
              </a>
              <span>{eval echo tdate($question['time']);}</span>
              
              {if $question['price']>0}<span class="fly-list-kiss layui-hide-xs" title="{$caifuzhiname}"><i class="layui-icon layui-icon-diamond font13"></i> {$question['price']}</span>{/if}
             {if $question['status']==2} <span class="layui-badge fly-badge-accept layui-hide-xs">已结</span>{/if}
              <span class="fly-list-nums"> 
                <i class="iconfont icon-pinglun1" title="回答"></i> {$question['answers']}
              </span>
            </div>
            <div class="fly-list-badge">
              {if $question['status']==6}  <span class="layui-badge layui-bg-red">推荐</span>{/if}
            </div>
          </li>
          {/loop}
        </ul>