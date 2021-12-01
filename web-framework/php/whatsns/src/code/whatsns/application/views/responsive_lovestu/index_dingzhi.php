 <div class="fly-panel">
        <div class="fly-panel-title fly-filter">
          <a>置顶</a>
         
        </div>
        <ul class="fly-list">
          <!--{eval $topdatalist=$this->fromcache('topdata');}-->
                <!--{loop $topdatalist  $topdata}-->
          <li>
            <a href="{url user/space/$topdata['model']['authorid']}" class="fly-avatar">
              <img src="{$topdata['model']['avatar']}" alt="{$topdata['model']['author']}">
            </a>
            <h2>
              {if $topdata['type']=='topic'}<a class="layui-badge">文章</a>{/if}
              {if $topdata['type']=='qid'}<a class="layui-badge">问答</a>{/if}
              {if $topdata['type']=='note'}<a class="layui-badge">公告</a>{/if}
              <a href="{$topdata['url']}">{$topdata['title']}</a>
            </h2>
            <div class="fly-list-info">
              <a href="{$topdata['url']}" link>
                <cite>{$topdata['model']['author']}</cite>
               {if $topdata['author_has_vertify']} <i class="iconfont icon-renzheng" ></i>{/if}
               
              </a>
              <span>{eval echo tdate($topdata['time']);}</span>
              
           
              <span class="fly-list-nums"> 
                <i class="iconfont icon-pinglun1" title="回复"></i> {$topdata['answers']}
              </span>
            </div>
            <div class="fly-list-badge">
            
              <span class="layui-badge layui-bg-black">置顶</span>
              {if $topdata['type']=='topic'&&$topdata['model']['ispc']} <span class="layui-badge layui-bg-red">推荐</span>{/if}
             
            </div>
          </li>
            <!--{/loop}-->
        </ul>
      </div>
