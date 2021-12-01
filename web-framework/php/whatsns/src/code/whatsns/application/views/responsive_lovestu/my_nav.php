 <ul class="layui-tab-title" id="LAY_mine">
        <li data-type="mine-jie" lay-id="index" class="{if $regular=='user/default'||$regular=='user/score'}layui-this{/if}"><a href="{url user/default}">动态</a></li>
        <li data-type="collection"  lay-id="collection" class="{if $regular=='user/ask'}layui-this{/if}"><a href="{url user/ask}">问题</a></li>
       <li data-type="collection"  lay-id="collection" class="{if $regular=='user/answer'}layui-this{/if}"><a href="{url user/answer}">回答</a></li>
     <li data-type="collection"  lay-id="collection" class="{if $regular=='topic/userxinzhi'}layui-this{/if}"><a href="{url topic/userxinzhi/$user['uid']}">文章</a></li>
      <li data-type="collection"  lay-id="collection" class="{if $regular=='user/recommend'}layui-this{/if}"><a href="{url user/recommend}">推荐问题</a></li>
     
      </ul>