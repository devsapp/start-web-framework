   <div class="fly-panel fly-link">
        <h3 class="fly-panel-title">友情链接</h3>
        <dl class="fly-panel-main">
             <!--{eval $links=$this->fromcache('link');}-->

         <!--{if $links }-->
      <!--{loop $links $link}-->   
          <dd><a href="{$link['url']}" target="_blank" title="{$link['description']}">{$link['name']}</a><dd>
             <!--{/loop}-->
   <!--{/if}-->
          <dd><a href="#" class="fly-link">申请友链</a><dd>
        </dl>
      </div>