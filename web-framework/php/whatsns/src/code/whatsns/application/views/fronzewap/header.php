<!--{template meta}-->
<section class="ui-container">


<div class="mheader">
<a class="logo" href="{SITE_URL}" title="{$setting['site_name']}" >
<img src="{$setting['site_logo']}" alt="{$setting['site_name']}" style="width:130px;height:26px;">
</a>
<div class="m_operate">
   <div class="iconmore" onclick="window.location.href='{url question/searchkey}'">
   <i class="fa fa-search"></i>
   </div>
    <div class="iconmore togglenav" onclick="togglenav()">
   <i class="fa fa-align-justify"></i>
   </div>
</div>
</div>

  <!--{eval $headernavlist = $this->fromcache("headernavlist");}-->
<!--导航-->
<ul class="tab-head mynavlist" style="display: none">
  <!--{loop $headernavlist $headernav}-->
                    <!--{if $headernav['type']==1 && $headernav['available']}-->
                   
                  
                      <li class="tab-head-item <!--{if strstr($headernav['url'],$regular)}--> current<!--{/if}-->"><a  href="{$headernav['format_url']}" title="{$headernav['title']}">{$headernav['name']}</a></li>
                    <!--{/if}-->
                    <!--{/loop}-->
                    
  
</ul>
<script type="text/javascript">
$(".togglenav").click(function(){
	$(".mynavlist").toggle();
});

</script>