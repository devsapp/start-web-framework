<!--{template header}-->


<div class="container collection index tagindex" style="padding:15px;">
  <div class="ui-row">
    <div class="ui-col main tagmain">
      <ol class="breadcrumb mb15">
                    <li><a href="{url tags}">标签</a></li>
                    <li><a href="{url tag/$tagalias}">{$tag['tagname']}</a></li>
                    <li class="active">标签动态</li>
                </ol>
                <section class="tag-info tag__info">
                    <div>
                        
                        <a class="tag tag-lg" href="{url tag/$tag['tagalias']}"  style="font-size:14px;height:28px;">
                                                           {if $tag['tagimage']} <img src="{$tag['tagimage']}">{/if}
                                                       {$tag['tagname']}
                        </a>

                        
                    </div>
                                            <p class="tag__info--desc">{if $tag['description']}$tag['description']{else}该标签暂无描述{/if}</p>
                    
                                        <style>
                        #suggest-list ins a {
                            border-radius: 11px;
                            border: 1px solid rgba(0,154,97,1);
                            padding: 2px 10px;
                            margin-right: 10px;
                            font-size: 13px;
                        }
                        #suggest-list ins a:hover {
                            text-decoration: none;
                        }
                    </style>
                 
                    
                </section>
                <div class="subnav-content-wrap" id="tab_anchor" style="height: 56px;">
            <div class="subnav-wrap" style="left: 0px;">
                <div class="top-hull">
                    <div class="subnav-contentbox">
                        <div class="tab-nav-container">
                            <ul class="subnav-content ">
                          
                                                       <li class="<!--{if strstr('tags/view',$regular)}--> current<!--{/if}-->"><a href="{url tags/view/$tagalias}">标签动态</a></li>
                    <li class="<!--{if strstr('tags/question',$regular)}--> current<!--{/if}-->"><a href="{url tags/question/$tagalias}">标签问答</a></li>
                    <li class="<!--{if strstr('tags/article',$regular)}--> current<!--{/if}-->"><a href="{url tags/article/$tagalias}">标签文章</a></li>
                                                </ul>
                            <div>



                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- 列表 -->
        <div class="news-list">
        {loop $tagdoinglist $tagdoing}
        <div class="news-item stream__item clearfix" >
        <div class="news__item-info"><div class="mb6"><h4 class="news__item-title mt0"><a class="mr10" target="_blank" href="{$tagdoing['url']}">{$tagdoing['title']}</a></h4>
        <ul class="taglist--inline ib">
          {loop $tagdoing['taglist'] $tagcat}
        <li class="tagPopup"><a class="tag" href="{url tags/view/$tagcat['tagalias']}" >
                                    {if $tagcat['tagimage']}     <img src="$tagcat['tagimage']"> {/if}          {$tagcat['tagname']}
                        </a>
                        </li>
                        {/loop}
                    
                        </ul></div><p class="news__item-meta"><a href="{url user/space/$tagdoing['authorid']}"><img class="avatars-img" src="{$tagdoing['avatar']}" width="18" height="18"></a><a class="" href="{url user/space/$tagdoing['authorid']}">{$tagdoing['author']}</a><span class="dot">·</span><span>{$tagdoing['addtime']}</span><span class="dot">·</span><span class="text-info"><a href="{$tagdoing['url']}">{if $tagdoing['nums']}{$tagdoing['nums']} {/if} {$tagdoing['typename']}</a></span><span class="dot">·</span><a class="text-qa" href="{$tagdoing['url']}" target="_blank">{$tagdoing['typekey']}</a></p></div>
                        </div>
                        {/loop}
        </div>
            <div class="pages">{$departstr}</div>
    </div>

    <div class="ui-col side " style="float: none">
    
    <div class="widget-box pt0 mt25" style="border:none;">
                        <h2 class="h4 widget-box__title">相关标签</h2>
                        <ul class="taglist--inline multi">
                                  {loop $relativetags $rtag}
                                  {if $rtag['tagname']!=$tag['tagname']}
                                                            <li class="tagPopup">
                                    <a class="tag" href="{url tags/view/$rtag['tagalias']}" >
                                                                          {if $rtag['tagimage']}  <img src="$rtag['tagimage']">{/if}
                                                                        {$rtag['tagname']}</a>
                                </li>{/if}
                                               {/loop}             
                                                    </ul>
                    </div>
                   
    </div>
  </div>

</div>
<!--{template footer}-->