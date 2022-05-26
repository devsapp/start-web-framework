 <ul class="layui-tab-title" id="LAY_mine">
        <li data-type="mine-jie" lay-id="index" class="{if $attentiontype=='question'}layui-this{/if}"><a href="{url user/attention/question}">问题</a></li>
        <li data-type="collection"  lay-id="collection" class="{if $attentiontype=='article'}layui-this{/if}"><a href="{url user/attention/article}">文章</a></li>
       <li data-type="collection"  lay-id="collection" class="{if $attentiontype!='topic'&&$attentiontype!='article'&&$attentiontype!='question'}layui-this{/if}"><a href="{url user/attention}">用户</a></li>
     <li data-type="collection"  lay-id="collection" class="{if $attentiontype=='topic'}layui-this{/if}"><a href="{url user/attention/topic}">话题</a></li>
      </ul>
      
