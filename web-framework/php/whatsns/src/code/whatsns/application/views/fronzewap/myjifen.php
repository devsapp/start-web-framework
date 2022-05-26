
<!--{template header}-->

<section class="ui-container">
<!--{template user_title}-->

   <div class="titlemiaosu">
            我的财富
            </div>
 
      <table class="ui-table ui-border-tb">
        <thead>
          <tr>
            <th>时间</th>
            <th>经验值</th>
            <th>财富值</th>
            <th>相关信息</th>
          </tr>
        </thead>
        <tbody>
        <!--{loop $jifenlist  $jifen}-->
        {if $jifen['credit1']!=0||$jifen['credit2']!=0}
        <tr>
        <td>$jifen['time']</td>
        <td>$jifen['credit1']</td>
        <td>$jifen['credit2']</td>
        <td>$jifen['content'] {if $jifen['content']=='其它操作'}<span style="display:none;">$jifen['operation']</span>{/if}</td>
        </tr>
        {/if}
                        <!--{/loop}-->
        </tbody>
      </table>
      <div class="pages">$departstr</div>

                     </div>
</section>
 
<!--{template footer}-->


