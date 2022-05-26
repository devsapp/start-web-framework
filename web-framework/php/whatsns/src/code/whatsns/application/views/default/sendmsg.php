<!--{template header}-->
<link rel="stylesheet" media="all" href="{SITE_URL}static/css/bianping/css/space.css" />



<!--用户中心-->

    <div class="container person">

        <div class="row ">
            <div class="col-xs-17 main">
    <!-- 用户title部分导航 -->
              <!--{template user_title}-->
             <!-- title结束标记 -->
       <!-- 内容页面 -->
    <div class="row">
                 <div class="col-sm-24">
                     <div class="dongtai all-private-letter-page bg-box-radius">
                         <p class="pull-left">
                             <strong class="font-18 ">发送消息</strong>
                         </p>
                       <a class="btn btn-success pull-right" href="{url message/personal}">返回消息列表</a>
                         <hr style="clear:both">


                    <form class="form-horizontal"  action="{url message/sendmessage}" method="post">

         <div class="form-group">
          <p class="col-md-24 ">收件人</p>
          <div class="col-md-14">
             <input type="text" id="username" name="username"  value="{if isset($sendto['username'])}$sendto['username']{/if}" placeholder="" class="form-control">
          </div>
        </div>

         <div class="form-group">
          <p class="col-md-24 ">主题</p>
          <div class="col-md-14">
             <input type="text" id="subject" name="subject"  value="" placeholder="" class="form-control">
          </div>
        </div>
           <div class="form-group">
          <p class="col-md-24 ">内容</p>
          <div class="col-md-18">
       <!--{template editor}-->
          </div>
        </div>
            <!--{if $setting['code_message']}-->

               <!--{template code}-->
          <!--{/if}-->



        <div class="form-group">
          <div class=" col-md-10">
             <input type="submit" id="submit" name="submit" class="btn btn-success" value="保存" data-loading="稍候...">
          </div>
        </div>
 </form>
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