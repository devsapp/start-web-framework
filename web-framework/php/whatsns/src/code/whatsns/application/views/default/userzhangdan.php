<!--{template header}-->

<link rel="stylesheet" media="all" href="{SITE_URL}static/css/bianping/css/space.css" />



<!--用户中心-->


    <div class="container person">

        <div class="row " >
            <div class="col-xs-17 main">
            <!-- 用户title部分导航 -->
              <!--{template user_title}-->
             <!-- title结束标记 -->
       <!-- 内容页面 -->
    <div class="row" style="padding-top:0px">
                 <div class="col-sm-24">
                     <div class="dongtai">
                         <p>
                             <strong class="font-18">我的对账流水</strong>
                         </p>

                         <hr>

 <table class="table table-striped">
        <thead>
          <tr>
            <th>#</th>

            <th width="10%">  金额(元)</th>
                <th>    类型</th>
                <th>    内容</th>

                  <th>    时间</th>

          </tr>
        </thead>
        <tbody>
          <!--{loop $moenylist $index $money}-->
               <tr>
                <td>
              {$index}
              </td>

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
                 </div>


             </div>
            </div>

            <!--右侧栏目-->
            <div class="col-xs-7  aside">




                <!--导航列表-->

               <!--{template user_menu}-->

                <!--结束导航标记-->


                <div>

                </div>


            </div>

        </div>

    </div>




<!--用户中心结束-->

<!--{template footer}-->