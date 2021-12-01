<!DOCTYPE html>
<html lang="cn">
  <!--{eval global $starttime,$querynum;$mtime = explode(' ', microtime());$runtime=number_format($mtime[1] + $mtime[0] - $starttime,6); $setting=$this->setting;$user=$this->user;$regular=$this->regular;$toolbars="'".str_replace(",", "','", $setting['editor_toolbars'])."'";}-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--{if isset($seo_title)}-->
        <title>{$seo_title}</title>
        <!--{else}-->
        <title><!--{if $navtitle}-->{$navtitle} - <!--{/if}-->{$setting['site_name']}</title>
        <!--{/if}-->
        <!--{if isset($seo_description)}-->
        <meta name="description" content="{$seo_description}" />
        <!--{else}-->
        <meta name="description" content="{$setting['site_name']}" />
        <!--{/if}-->

        <meta name="keywords" content="{$seo_keywords}" />
        <meta name="author" content="whatsns Team" />
        <meta name="copyright" content="2019 www.whatsns.com" />
      <meta name="applicable-device" content="pc"/>
      <meta name="version" content="whatsns问答系统 {ASK2_VERSION}-up{ASK2_RELEASE}"/>
      <link href="{SITE_URL}static/css/common/dev.css" rel="stylesheet">

            {if $topicid&&$topicone['xzsrc']&&$setting['xiongzhang_appid'] }
<script type="application/ld+json">
    {
        "@context": "https://ziyuan.baidu.com/contexts/cambrian.jsonld",
        "@id": "{SITE_URL}{eval echo substr($_SERVER['REQUEST_URI'],1);}",
        "appid": "{eval echo trim($setting['xiongzhang_appid']);}",  //替换成自己的appid值
        "title": "{$navtitle}",
        "images": [
        "{$topicone['xzsrc']}"
        ],
        "pubDate": "{eval echo date('Y-m-d',$topicone['timespan']);}T{eval echo date('H:i:s',$topicone['timespan']);}" 
    }

</script>
{/if}
</head>
<body>
<header>
<!-- 获取顶级分类 -->
{eval $newcid=0;$catmodel=array();}
            {if $catid}
            {eval $newcid=$catid;}
            {/if}
               {if $topicone}
            {eval $newcid=$topicone['articleclassid'];}
            {/if}
            {eval $cat=$this->category_model->get($newcid);}
            {if $cat['pid']==0}
            {eval $catmodel=$cat;}
            
            {else}
            {eval $parentid=$cat['pid'];}
             {eval $cat=$this->category_model->get($parentid);}
                  {if $cat['pid']==0}
            {eval $catmodel=$cat;$newcid=$cat['id'];}
            
            {else}
             {eval $parentid=$cat['pid'];}
             {eval $cat=$this->category_model->get($parentid);}
              {eval $catmodel=$cat;$newcid=$cat['id'];}
              {/if}
            {/if}
            
			<h3>
				<a href="{url topic/catlist/$newcid}"><img src="{eval echo get_cid_dir($newcid);}" width="40" height="40" alt=""></a>
				{$catmodel['name']}
				<button type="button"  class="open-nav" id="open-nav"></button>
			</h3>

			<form action="{url topic/search}" method="get" class="search-input-container">
				<input type="text"  id="search-input" name="txtarticle" placeholder="Search" autofocus="">
				<div class="search-input-icon" onclick="search()"><svg fill="#000000" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path><path d="M0 0h24v24H0z" fill="none"></path></svg></div>

				<input type="submit" value="Search" style="display: none;">
			</form>

<!-- 查找二级分类 -->
{eval $subcatlist=$this->category_model->list_by_pid ( $newcid );}
			<nav class="full-navigation">
	
    {if $subcatlist}
	{loop $subcatlist $subcat}
		<ul>
			<li class="nav-item top-level ">
				
					<a >{$subcat['name']}</a>
					<ul>
						
							<!-- 读取当前分类以及子分类下的文章 -->
							{eval $cidlist=array();array_push($cidlist,$subcat['id']);}
							{eval $tmpsubcatlist=$this->category_model->list_by_pid ( $subcat['id'] );}
							{if  $tmpsubcatlist}
							{loop $tmpsubcatlist $tmpsubcat}
							{eval array_push($cidlist,$tmpsubcat['id']);}
							{/loop}
							{/if}
							{eval $explodecid = implode ( ',', $cidlist );}
						    {eval $subtopiclist=$this->getlistbysql("select title,id,describtion from ".$this->db->dbprefix."topic where articleclassid in($explodecid) order by displayorder desc limit 0,10");}
							{loop $subtopiclist $subt}
							 {if !$topicone}
							 {eval $topicone=$subt;}
							 {/if}
							
							<li class="nav-item "><a href="{url topic/getone/$subt['id']}">{$subt['title']}</a></li>
						     {/loop}
							
					
					</ul>
				
			</li>
		</ul>
	{/loop}
		{/if}
	
</nav>
		</header>
		
		<section class="main">
			<div class="page-header">
				<h2>{$catmodel['name']}</h2>
				<h1>{$topicone['title']}</h1>
			</div>
			<article class="content">
 {eval echo htmlspecialchars_decode( replacewords($topicone['describtion']));}
			</article>
		</section>
		<script src="{SITE_URL}static/js/jquery-1.11.3.min.js"></script>
	   <link rel="stylesheet" type="text/css" href="{SITE_URL}static/js/neweditor/code/styles/tomorrow-night-eighties.css">
    <script type="text/javascript" src="{SITE_URL}static/js/neweditor/code/highlight.pack.js"></script>
    <script>hljs.initHighlightingOnLoad();</script>
   <!--{if $setting['cancopy']==1}-->
              <script src="{SITE_URL}static/js/nocopy.js"></script>
                <!--{/if}-->

<script src="{SITE_URL}static/js/jquery.lazyload.min.js"></script>
<script>

 <!--{if $setting['opensinglewindow']==1}-->
 $("a").attr("target","_self");

                <!--{/if}-->
  

                    $("img.lazy").lazyload({effect: "fadeIn" });

</script>
   	           
		<script>
		function search(){
			var txtart=document.getElementById("search-input").value;
			if(txtart!=''){
		      document.location.href="{url topic/search}?word="+txtart;
			}else{
				alert("请输入关键词");
			}
		}
	
		
			document.getElementById("open-nav").addEventListener("click", function () {
				document.body.classList.toggle("nav-open");
			});
		</script>
		<div class="hide">     <!--{if $setting['site_statcode']}--> {eval echo decode($setting['site_statcode'],'tongji');}<!--{/if}-->
                     </div>
	</body>
</html>