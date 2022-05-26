<!--{template meta}-->
<div id="body">
<header id="header">
        <div class="content color-999 small clearfix">
            <div class="header-l fl">
             {template c_headertext}    
            </div>
            <div class="header-r fr clearfix">
                <div class="ws_header">
                    <div class="menu">
             
                    </div>
                </div>
            
       
            </div>
        </div>
    </header>
    <nav id="nav">
        <div class="content">
            <div class="logo fl"><img width="130" src="{$setting['site_logo']}" alt="{$setting['site_name']}"></div>
            <div class="menu fl">
                <a href="{SITE_URL}" class="nav-item   {if $regular=='index/index'} active  {/if} fl">首页</a>
                <a href="{url ask/index}" class="nav-item {if $regular=='ask/index'} active  {/if}  fl">问题库</a>
                <a href="{url seo/index}" class="nav-item {if $regular=='seo/index'} active  {/if}  fl">资讯专栏</a>
               
                <a href="{url tags}" class="nav-item {if $regular=='tags/index'} active  {/if}  fl">标签库</a>
                  <a href="{url category/viewtopic/question}" class="nav-item {if $regular=='category/viewtopic'} active  {/if} fl">问答话题</a>
                   <a href="{url expert/default}" class="nav-item {if $regular=='expert/default'} active  {/if}  fl">问答专家<span class="mask">NEW<i class="arrow"></i></span></a>
            </div>
            <div class="search fl clearfix">
               <form name="searchform" action="{url question/search}" method="post" accept-charset="UTF-8">
                <input type="text" placeholder="请输入关键词" name="word" autocomplete="off" value="{$word}"  id="search" class="fl">
                <span class="search-icon ilblk"></span>
                </form>
            </div>
            <div class="send-menu">
            <a href="javascript:void(0);" class="send fl">
                <span>发布</span><i class="down-icon"> </i>
            </a>
            <ul>
                <li><a href="{url question/add}">提问题</a></li>
                <li><a href="{url user/addxinzhi}">发文章</a></li>
            </ul>
            </div>
        </div>
    </nav>
<script type="text/javascript">

$("#nav .search-icon").click(function(){
	var _txt=$.trim($("#search").val());
	if(_txt==''){
		alert("关键词不能为空");
		return ;
	}
	 document.searchform.action = "{url question/search}";
    document.searchform.submit();
});

</script>

