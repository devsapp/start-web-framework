<style>
<!--
.search .aside {
    border-right: none;
}
-->
</style>
<ul class="menu">
<li class="{if ROUTE_A=='question'}active{/if}">
<a href="{url question/search}?word={$word}"><div class="setting-icon">
<i class="fa fa-question-circle-o"></i></div>
 <span>问题</span>
 </a>
 </li>
 <li class="{if ROUTE_A=='topic'}active{/if}">
 <a href="{url topic/search}?word={$word}">
 <div class="setting-icon">
 <i class="fa fa-rss-square"></i>
 </div> <span>文章</span>
 </a></li>
 <li class="{if ROUTE_A=='user'}active{/if}">
 <a href="{url user/search}?word={$word}">
 <div class="setting-icon"><i class="fa fa-user"></i></div> <span>用户</span>
 </a>
 </li>
 <li class="{if ROUTE_A=='category'}active{/if}">
 <a href="{url category/search}?word={$word}">
 <div class="setting-icon"><i class="fa fa-tag"></i></div> <span>专题</span>
 </a>
 </li>

 </ul>