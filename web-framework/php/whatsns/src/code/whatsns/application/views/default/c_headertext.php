	<ul class="znav">
		  <!--{eval $headernavlist = $this->fromcache("headernavlist");}-->
		  <!--{loop $headernavlist $headernav}-->
                    <!--{if $headernav['type']==1 && $headernav['available']}-->
                   
                  
                      <li class="tab-head-item <!--{if strstr($headernav['url'],$regular)}--> current<!--{/if}-->"><a  href="{$headernav['format_url']}" title="{$headernav['title']}">{$headernav['name']}</a></li>
                    <!--{/if}-->
                    <!--{/loop}-->	
		</ul>