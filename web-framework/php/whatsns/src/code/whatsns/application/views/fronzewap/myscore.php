<!--{template header}-->
<style>
.mymenulist{
background:#ebebeb;
}
</style>
<section class="ui-container mymenulist">
<!--{template user_title}-->
{if $this->uri->segments[3]=='set'}
   <div class="usertoolist">
 <div class="weui-flex toolitem">
   
     <div class="weui-flex__item text">
            <a href="{url user/usernotify}"> 私信和通知设置</a>
     </div>
      <div><i class="icon_jinru"></i></div>
 </div>
  <div class="weui-flex toolitem">
   
     <div class="weui-flex__item text">
            <a href="{url user/editimg}"> 修改头像</a>
     </div>
      <div><i class="icon_jinru"></i></div>
 </div>
   <div class="weui-flex toolitem">
   
     <div class="weui-flex__item text">
            <a href="{url user/profile}"> 修改个人信息</a>
     </div>
      <div><i class="icon_jinru"></i></div>
 </div>
     <div class="weui-flex toolitem">
   
     <div class="weui-flex__item text">
            <a href="{url user/uppass}">修改密码</a>
     </div>
      <div><i class="icon_jinru"></i></div>
 </div>
      <div class="weui-flex toolitem">
   
     <div class="weui-flex__item text">
            <a href="{url user/editemail}">激活邮箱</a>
     </div>
      <div><i class="icon_jinru"></i></div>
 </div>
       <div class="weui-flex toolitem">
   
     <div class="weui-flex__item text">
            <a href="{url user/logout}">退出</a>
     </div>
    
 </div>
 </div>
 
{else}

 


<div class="u_common_fun_list" style="padding-top: 0px;">
    <h2 class="u_fun_text">
        <b>常用功能</b>
    </h2>
    <div class="common_fun_items">
	
     

        <div class="common_fun_item" onclick="window.location.href='{url user/myjifen}'">
            <div>
                <img class="u_common_icon" src="{SITE_URL}static/css/fronze/css/svg/ze-points.svg" />
            </div>
            <div class="common_fun_item_text">
                我的财富
            </div>
        </div>
 

        <div class="common_fun_item" onclick="window.location.href='{url message/personal}'">
            <div>
                <img class="u_common_icon" src="{SITE_URL}static/css/fronze/css/svg/ze-bell.svg" />
            </div>
            <div class="common_fun_item_text">
                私信
            </div>
        </div>

        <div class="common_fun_item" onclick="window.location.href='{url user/ask}'">
            <div>
                <img class="u_common_icon" src="{SITE_URL}static/css/fronze/css/svg/question.svg" />
            </div>
            <div class="common_fun_item_text">
                问题
            </div>
        </div>

        <div class="common_fun_item" onclick="window.location.href='{url user/answer}'">
            <div>
                <img class="u_common_icon" src="{SITE_URL}static/css/fronze/css/svg/myanswer.svg" />
            </div>
            <div class="common_fun_item_text">
                回答
            </div>
        </div>

        <div class="common_fun_item" onclick="window.location.href='{url topic/userxinzhi/$user['uid']}'">
            <div>
                <img class="u_common_icon" src="{SITE_URL}static/css/fronze/css/svg/wenzhang.svg" />
            </div>
            <div class="common_fun_item_text">
                文章
            </div>
        </div>


        <div class="common_fun_item" onclick="window.location.href='{url user/attention/question}'">
            <div>
                <img class="u_common_icon" src="{SITE_URL}static/css/fronze/css/svg/shouchang.svg" />
            </div>
            <div class="common_fun_item_text">
                收藏
            </div>
        </div>

    </div>

    <div class="common_fun_items"  style="margin-top: 8px;">





        <div class="common_fun_item" onclick="window.location.href='{url user/invateme}'">
            <div>
                <img class="u_common_icon" src="{SITE_URL}static/css/fronze/css/svg/yao.svg" />
            </div>
            <div class="common_fun_item_text">
                邀请回答
            </div>
        </div>

        <div class="common_fun_item" onclick="window.location.href='{url user/invatelist}'">
            <div>
                <img class="u_common_icon" src="{SITE_URL}static/css/fronze/css/svg/reg.svg" />
            </div>
            <div class="common_fun_item_text">
                邀请注册
            </div>
        </div>
        <div class="common_fun_item" onclick="window.location.href='{url user/vertify}'">
            <div>
                <img class="u_common_icon" src="{SITE_URL}static/css/fronze/css/svg/diamond.svg" />
            </div>
            <div class="common_fun_item_text">
                认证
            </div>
        </div>
 
        <div class="common_fun_item">

        </div>


    </div>

</div>
{/if}
</section>

<!--{template footer}-->