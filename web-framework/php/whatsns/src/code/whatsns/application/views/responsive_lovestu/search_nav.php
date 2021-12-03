<style>
.fly-list em{
color:red !important;
font-style: normal;
}
</style>
 <div class="fly-panel-title fly-filter">
          <a href="{url question/search}?word={$word}" class="{if ROUTE_A=='question'}layui-this{/if}">问题</a>
          <span class="fly-mid"></span>
          <a href="{url topic/search}?word={$word}" class="{if ROUTE_A=='topic'}layui-this{/if}">文章</a>
          <span class="fly-mid"></span>
          <a href="{url category/search}?word={$word}" class="{if ROUTE_A=='category'}layui-this{/if}">话题</a>
          <span class="fly-mid"></span>
                    <a href="{url user/search}?word={$word}" class="{if ROUTE_A=='user'}layui-this{/if}">用户</a>
      
          
        </div>