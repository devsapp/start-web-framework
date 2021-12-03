<!--{template meta}-->
<div id="body">
<link rel="stylesheet" media="all" href="{SITE_URL}static/theme/flat/index.css" />
<div class="nav-headerbox">
  <div class="nav-header clearfix">
    <div class="ask-logo"><a href="{SITE_URL}" target="_blank"><img src="{$setting['site_logo']}" alt=""></a></div>
    <ul class="hnav clearfix">
        		  <li class="<!--{if strstr('index/index',$regular)}--> current<!--{/if}-->"><a href="{SITE_URL}" target="_blank">首页</a></li>
				  <li class="<!--{if strstr('new/default',$regular)}--> current<!--{/if}-->"><a href="{url newpage/index}" target="_blank">问题库</a></li>
				  <li class="<!--{if strstr('expert/index',$regular)}--> current<!--{/if}-->"><a href="{url expert}" target="_blank">专家</a></li>
				  <li class="<!--{if strstr('topic/index',$regular)}--> current<!--{/if}-->"><a href="{url topic}" target="_blank">专栏</a></li>
		    </ul>
    <div class="searchbox">
       <div class="search">
          <input type="text" id="keywords" autocomplete="off" value="" data-url="" class="key-words" name="kword" placeholder="请输入关键词">
          <a class="sear-btn"></a>
       </div>
              <!--{if 0==$user['uid']}-->
       <a href="javascript:;" onclick="login()" class="ask">提问</a>
          
          <!--{else}-->
              <a href="{url question/add}"  class="ask">提问</a>
         
           <!--{/if}-->
           
 <header>
    <nav class="ws_header">
       
            <div class="menu">
   
             

              
            <div class="user-center">
         
                  <!--{if 0!=$user['uid']}-->
                <ul class="login">
                    <li class="message">
                        <a class="message-list"><i class="fa fa-bell"></i>
                        <sup class="subnav-dot-sup hide"></sup>
                        </a>
                        <div class="menu-list message-box hide">
                            <section>消息盒 </section>
                            <div id="contetn-2" class="message-box-list-wrapper">
                                <ul class="message-box-list mCustomScrollbar _mCS_1 mCS-autoHide mCS_no_scrollbar"><div id="mCSB_1" class="mCustomScrollBox mCS-dark mCSB_vertical mCSB_inside" style="max-height: 225px;" ><div id="mCSB_1_container" class="mCSB_container mCS_y_hidden mCS_no_scrollbar_y" style="position:relative; top:0; left:0;" dir="ltr">
                                    <li class="news-circle personmsgbox"> </li>
                                <li class="news-circle systemmsgbox"> </li>
                                    </div>
                                    <div id="mCSB_1_scrollbar_vertical" class="mCSB_scrollTools mCSB_1_scrollbar mCS-dark mCSB_scrollTools_vertical" style="display: none;"><a href="#" class="mCSB_buttonUp"></a><div class="mCSB_draggerContainer"><div id="mCSB_1_dragger_vertical" class="mCSB_dragger" style="position: absolute; min-height: 30px; top: 0px;"><div class="mCSB_dragger_bar" style="line-height: 30px;"></div></div><div class="mCSB_draggerRail"></div></div><a href="#" class="mCSB_buttonDown"></a></div></div></ul>
          
                            </div>
                                              <div id="empty_message_box" class="msg-box-null">
		<div class="msg-box-inner">
			<span class="null-images"></span>
			<span class="msg-null-tips">没有新消息</span>
		</div>
	</div>
                            <a  class="check-all" href="{url message/personal}">查看全部 </a>
                        </div>
                    </li>
                    <li class="user"><div class="avatar-container-30">
                        <a href="{url user/default}" class="user-list" ><img src="{$user['avatar']}" title="{$user['username']}" alt="{$user['username']}"></a>

                    </div>
                        <div class="menu-list user-box hide">
                            <section><a href="{url user/default}" z-st="nav_userbox_name">{$user['username']}</a></section>
                            <div class="user-box-list">
                                <div class="user-box-list-area">
                                  <!--{if $user['groupid']<=3}-->
                                  <p class="works-manange"><a href="{SITE_URL}index.php?admin_main" >后台管理</a></p>
                                  
                                    <!--{/if}-->
                                    <p class="works-manange"><a href="{url user/recommend}" >为我推荐</a></p>
                                    <p class="works-manange"><a href="{url user/ask}" >我的提问</a></p>
                                    <p class="works-manange"><a href="{url user/answer}" >我的回答</a></p>
                                    <p class="works-manange"><a href="{url topic/userxinzhi/$user['uid']}">我的文章</a></p>
                                    <p class="works-manange"><a href="{url user/attention/question}" >我的关注</a></p>
       
                                </div>
                                <div class="user-box-list-area">
                                    <p class="works-manange"><a href="{url user/creditrecharge}" >财富充值</a></p>

                                    <p class="works-manange"><a href="{url user/userbank}" >我的钱包</a></p>

                                    <p class="works-manange"><a href="{url user/profile}" >资料与帐号</a></p>
                                </div>
                                <div class="user-box-list-area">
                                    <p class="works-manange"><a href="{url user/logout}" >退出</a></p>
                                </div>
                            </div>
                        </div></li>
                   
                </ul>
                   <!--{else}-->
                <ul class="unlogin ">
                    <li><a href="javascript:login();"  class="nav-unlogin">登录<i></i></a><a href="{url user/register}">注册</a></li>
                </ul>
                <!--{/if}-->
            </div>
        </nav></header>
    </div>

          </div>
    <!-- fix-hnav end -->
</div>
<script type="text/javascript">
$(".search-ipt").click(function(){
	var _txt=$.trim($("#search-kw").val());
	if(_txt==''){
		alert("关键词不能为空");
		return ;
	}
	 document.searchform.action = "{url question/search}";
    document.searchform.submit();
});
$(".ws_header .search,.ws_header .search-cancel").click(function(){
	$(".ws_header .search").toggle();
	$(".ws_header .menu-list-content").toggle();
	$(".ws_header .search-input-hull").toggle();
})
$(".message .message-list,.message .message-box").hover(function(){
	$(".message .message-box").show();
},function(){	$(".message .message-box").hide();});
$(".upload-link,.postlist").hover(function(){
	$(".postlist").show();
},function(){
	$(".postlist").hide();
})
</script>

    <div class="main-wrapper index">