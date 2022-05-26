   
        <div class="fly-panel-title fly-filter">
          <a href="{url user/space/$member['uid']}" class="{if $regular=='user/space'}layui-this{/if}">主页</a>
          <span class="fly-mid"></span>
          <a href="{url user/space_answer/$member['uid']}" class="{if $regular=='user/space_answer'}layui-this{/if}">回答</a>
          <span class="fly-mid"></span>
          <a href="{url user/space_ask/$member['uid']}" class="{if $regular=='user/space_ask'}layui-this{/if}">提问</a>
          <span class="fly-mid"></span>
                    <a href="{url topic/userxinzhi/$member['uid']}" class="{if $regular=='topic/userxinzhi'}layui-this{/if}">文章</a>
      
          <span class="fly-mid"></span>
                    <a href="{url user/space_attention/topic/$member['uid']}" title="关注话题" class="{if $regular=='user/space_attention'}layui-this{/if}">话题</a>
      
        </div>