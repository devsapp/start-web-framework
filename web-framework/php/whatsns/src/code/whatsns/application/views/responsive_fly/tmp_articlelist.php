  <ul class="fly-list"> 
   {loop $topiclist $nindex $topic}       
          <li>
            <a href="{url user/space/$topic['authorid']}" class="fly-avatar">
              <img src="{eval echo get_avatar_dir($topic['authorid']);}" alt="{$topic['author']}">
            </a>
            <h2>
            {eval $categoryname=$this->category[$topic['articleclassid']]['name']}
              {if $categoryname}<a href="{url category/view/$topic['articleclassid']}" class="layui-badge">{$categoryname}</a>{/if}
              <a href="{url topic/getone/$topic['id']}">{$topic['title']}</a>
            </h2>
         
            <div class="fly-list-info">
              <a href="{url user/space/$topic['authorid']}" >
                <cite>{$topic['author']}</cite>
                <!--
                <i class="iconfont icon-renzheng" title="认证信息：XXX"></i>
                <i class="layui-badge fly-badge-vip">VIP3</i>
                -->
              </a>
              <span>{$topic['viewtime']}</span>
              
              {if $topic['price']>0}
              
            
               {if $topic['readmode']==3}
                     <span class="fly-list-kiss layui-hide-xs" title="现金"><i class="layui-icon layui-icon-rmb font13"></i> {$topic['price']}</span>
              
                    {/if}
                       {if $topic['readmode']==2}
                       <span class="fly-list-kiss layui-hide-xs" title="{$caifuzhiname}"><i class="layui-icon layui-icon-diamond font13"></i> {$topic['price']}</span>
              
                    {/if}
              {/if}
            
              <span class="fly-list-nums"> 
                <i class="iconfont icon-pinglun1" title="评论"></i> {$topic['articles']}
              </span>
            </div>
            <div class="fly-list-badge">
              {if $topic['ispc']}  <span class="layui-badge layui-bg-red">推荐</span>{/if}
            </div>
          </li>
          {/loop}
        </ul>