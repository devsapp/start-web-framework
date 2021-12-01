<!--{template header}-->


<div class="container collection index tagindex" style="margin-bottom: 20px;">
  <div class="row"  style="padding-top:0px;margin:0px">
    <div class="col-xs-24 col-md-17 main tagmain bb">
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
                                                     {if $user['groupid']==1}  <a target="_blank" style="color:red;margin-left:20px;" href="{url admin_tag/edit/$tag['tagalias']}">修改</a>{/if}
                        </a>

                        <div class="tag__info--follow ml10 hide">
                            <button type="button" class="btn btn-success btn-xs tagfollowBtn  " data-id="1040000000089442"><span class="text">关注</span><span class="hr">|</span><span class="num">{$tag['followers']}</span>
                            </button>
                            
                        </div>
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

    <div class="col-xs-24 col-md-7 side ">

                    
                        <div class="standing" style="margin-top:20px;">
  <div class="positions bb" id="rankScroll">
      <h3 class="title" style="float:none;" >相关标签</h3>
       <ul class="taglist--inline multi" style="padding:0px 20px 20px 20px;">
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

</div>
<!--{template footer}-->