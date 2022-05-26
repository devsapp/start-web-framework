  <ul class="fly-list"> 
  {loop $tagdoinglist $tagdoing}      
          <li>
            <a href="{url user/space/$tagdoing['authorid']}" class="fly-avatar">
              <img src="{$tagdoing['avatar']}" alt="{$tagdoing['author']}">
            </a>
            <h2>
    <a href="{$tagdoing['url']}" class="layui-badge"> {$tagdoing['typekey']}</a>
              <a href="{$tagdoing['url']}">{$tagdoing['title']}</a>
            </h2>
            <div class="fly-list-info">
              <a href="{url user/space/$tagdoing['authorid']}" >
                <cite>{$tagdoing['author']}</cite>

              </a>
              <span>{$tagdoing['addtime']}</span>
              

              <span class="fly-list-nums"> 
                <i class="iconfont icon-pinglun1" title="{$tagdoing['typename']}"></i>{$tagdoing['nums']} 
              </span>
            </div>
         
          </li>
          {/loop}
        </ul>
       