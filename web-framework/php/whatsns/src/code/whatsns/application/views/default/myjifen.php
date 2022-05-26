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
                 <div class="" style="padding:10px;">
                     <div class="dongtai">
                                    <ul class="trigger-menu" data-pjax-container="#list-container">
 <li class=""><a href="{url user/level}"><i class="fa fa-sort-amount-desc"></i> 我的等级</a></li>
 <li class="active"><a href="{url user/myjifen}"><i class="fa fa-registered"></i> 我的财富值</a></li>
 </ul>

<table class="table table-hover">
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
        <td>$jifen['content']</td>
        </tr>
        {/if}
                        <!--{/loop}-->
        </tbody>
      </table>
                     <div class="pages" >{$departstr}</div>
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