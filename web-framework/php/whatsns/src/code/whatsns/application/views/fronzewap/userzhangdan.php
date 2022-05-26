
<!--{template header}-->

<section class="ui-container">
<!--{template user_title}-->

 
    <div class="ui-btn-wrap">
    <button class="ui-btn ui-btn-danger" onclick="window.location.href='{url user/userbank}'">
       返回我的银行钱包
    </button>
   
 
</div>
        
        

<hr>
    <h2 style="font-size:15px;">我的对账流水</h2>
 <table class="ui-table ui-border-tb">
        <thead>
          <tr>
          
         
            <th width="10%">  金额(元)</th>
                <th>    类型</th>
                <th>    内容</th>
                   <th>    备注</th>
                  <th>    时间</th>
                  
          </tr>
        </thead>
        <tbody>
          <!--{loop $moenylist $index $money}-->
               <tr>
               
             
               <td>
               {$money['money']}
              </td>
              <td>
               {$money['operation']}
              </td>
               <td>
               {$money['content']}
              </td>
                <td>
               {$money['beizhu']}
              </td>
              <td>
               {$money['time']}
              </td>
             
             </tr>
                <!--{/loop}--> 
         
        </tbody>
      </table>
      <div class="pages">$departstr</div>
      <!--{if $moenylist==null}-->
      
                  <div class="alert alert-warning">暂无对账流水记录</div>
                    <!--{/if}-->
                     </div>
</section>
 
<!--{template footer}-->


