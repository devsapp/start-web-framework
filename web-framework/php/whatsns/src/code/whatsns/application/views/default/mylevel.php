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
                 <div class=""  style="padding:10px">
                     <div class="dongtai">
                 <ul class="trigger-menu" data-pjax-container="#list-container">
 <li class="active"><a href="{url user/level}"><i class="fa fa-sort-amount-desc"></i> 我的等级</a></li>
 <li class=""><a href="{url user/myjifen}"><i class="fa fa-registered"></i> 我的财富值</a></li>
 </ul>

<table class="table table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>等级</th>
            <th>头衔</th>
            <th>经验值</th>
          </tr>
        </thead>
        <tbody>
        <!--{loop $usergroup $index $group}-->
                        <!--{if $group['grouptype']==2}-->
          <tr>
            <td>$index</td>
            <td><span class="user-level">LV{$group['level']}--{$group['groupid']}--{$user['groupid']}{if $group['groupid']==$user['groupid']}（我在这里）{/if}</span></td>
                            <td>{$group['grouptitle']}</td>
                            <td>{$group['creditslower']} - {$group['creditshigher']}</td>
          </tr>
          <!--{/if}-->
                        <!--{/loop}-->
        </tbody>
      </table>

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