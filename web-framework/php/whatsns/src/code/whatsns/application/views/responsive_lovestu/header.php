<!-- 公共头部--> 
{template meta}

<div id="app">
    <header>
        <div class="header-main-plane">
            <div class="header-main container">
                <script>
    function openMenu() {
        $('body').css('overflow', 'hidden');
        $(".drawer-menu-plane").addClass("drawer-menu-plane-show");
        $(".menu-plane").appendTo($(".drawer-menu-list"));
        $(".user-menu-plane").appendTo($(".drawer-menu-list"));
        $(".menu-item-has-children").append('<div class="m-dropdown"><i class="fa fa-angle-down"></i></div>')
        $(".user-menu-main").append('<div class="m-dropdown"><i class="fa fa-angle-down"></i></div>')

    }
    function closeMenu() {
        $('body').css('overflow', 'auto');
        $(".drawer-menu-plane").removeClass("drawer-menu-plane-show");
        $(".user-menu-plane").prependTo($(".header-menu"));
        $(".menu-plane").prependTo($(".header-menu"));

        $(".m-dropdown").remove();
    }

    function openSearch() {
        //$('body').css('overflow', 'hidden');
        $(".dialog-search-plane").addClass("dialog-search-plane-show");
    }
    function closeSearch() {
        //$('body').css('overflow', 'auto');
        $(".dialog-search-plane").removeClass("dialog-search-plane-show");
    }
</script>
<div class="mobile-menu-btn" onclick="openMenu()">
    <i class="fa fa-bars" aria-hidden="true"></i>
</div>
<div class="drawer-menu-plane">
    <div class="drawer-menu-list">
    </div>
    <div class="drawer-menu-write" onclick="closeMenu()">
    </div>
</div>
<div class="header-logo-plane">
    <div class="header-logo">
        <a href="{SITE_URL}"><img src="{$setting['site_logo']}" alt="{$setting['site_name']}" style="width:138px;height:28px;"></a>    </div>
</div>
<div class="mobile-search-btn" onclick="openSearch()">
    <i class="fa fa-search"></i>
</div>
<div class="dialog-search-plane">
    <div class="dialog-mask" onclick="closeSearch()"></div>
    <div class="dialog-plane">
        <h2>搜索内容</h2>
        <form class="search-form" action="{url question/search}" method="post" role="search">
            <div class="search-form-input-plane">
                <input type="text" class="search-keyword" name="word" placeholder="搜索内容" value="{$word}">
            </div>
            <div>
                <button type="submit" class="search-submit" value="">搜索</button>
            </div>
        </form>
    </div>
</div>


<div class="header-menu"><div class="menu-plane">
        <nav class="menu-header-plane"><ul id="menu-%e9%a1%b6%e9%83%a8%e5%af%bc%e8%88%aa%e8%8f%9c%e5%8d%95" class="menu-header-list">

     <!--{eval $headernavlist = $this->fromcache("headernavlist");}-->
		  <!--{loop $headernavlist $index $headernav}-->
                    <!--{if $headernav['type']==1 && $headernav['available']}-->                      
                             
<li id="menu-item-10" class="menu-item menu-item-10 <!--{if strstr($headernav['url'],$regular)}--> layui-this<!--{/if}-->"><a href="{$headernav['format_url']}" title="{$headernav['title']}">{$headernav['name']}</a></li>
        
    <!--{/if}-->
                    <!--{/loop}-->

</ul></nav>
    </div><div class="user-menu-plane">
    {if !$user['uid']}
                    <span class="user-menu-main">
                 <a href="{url user/login}"><button class="login-btn-header">登录</button></a>
            </span>
            {else}
            <ul class="layui-nav" lay-filter="">


  <li class="layui-nav-item">
    <a href="{url user/default}"><img src="{$user['avatar']}" class="layui-nav-img">{$user['username']}</a>
    <dl class="layui-nav-child">
    	   {if $user['groupid']==1} 
     	<dd>
								<a style="color:red;" href="{SITE_URL}index.php?admin_main/stat" class="open-edit-profile edit_profile">
									后台管理							</a>
							</dd>
						   
				{/if}
					         <dd>
								<a href="{url user/default}">
									 个人主页							</a>
							</dd>
							
							<dd>
								<a href="{url user/profile}">
									 基本设置							</a>
							</dd>
						
                            <dd>
								<a href="{url message/system}">
									 我的消息							</a>
							</dd>
							  <dd>
								<a href="{url user/ask}">
								我的问题							</a>
							</dd>
							  <dd>
								<a href="{url user/answer}">
								 我的回答							</a>
							</dd>
							
							  <dd>
								<a href="{url topic/userxinzhi/$user['uid']}">
									 我的文章							</a>
							</dd>
							  <dd>
								<a href="{url attention/question}">
								 我的关注							</a>
							</dd>
							<dd>
								<a href="{url user/logout}">
									<i class="fa fa-power-off"></i> 退 出								</a>
							</dd>
    </dl>
  </li>

</ul>
            {/if}
                </div>
    
    
</div>

            </div>
        </div>
    </header>
 
 <style>
 
     {if !is_mobile()}
    .layui-container{
    margin-top:80px;
    }
    .fly-user-main>.layui-nav {
  
    z-index: 1;
 
}
.fly-user-main>.fly-panel {
    min-height: 575px;
    margin: 0 0 0px 215px;
}
.footer-plane {
 
    margin-bottom:0px;
}
     {/if}
       {if is_mobile()}
    .fly-user-main{
	  margin-top:60px;
}
.layui-container {
    padding: 0px;
    margin-top: 60px;
    margin-left: 10px;
    margin-right: 7px;
}
.header-main-plane {
    padding: 0px;
}
 {/if}
  </style>
    