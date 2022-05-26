<!--{template header}-->
<style>
    body{
        background: #f1f5f8;;
    }
</style>
                     <!--精选文章-->
    <div class="au_side_box" atyle="margin-top:.1rem">

        <div class="au_box_title " >

            <div>
                <i class="fa fa-file-text-o lv"></i>精选文章

            </div>

        </div>
        <div class="au_side_box_content">
            <!--列表部分-->
                       <div class="stream-list blog-stream">
     <!--{loop $topiclist $index $topic}-->   

<section class="stream-list__item"><div class="blog-rank stream__item"><div  class="stream__item-zan   btn btn-default mt0"><span class="stream__item-zan-icon"></span><span class="stream__item-zan-number">{$topic['articles']}</span></div></div><div class="summary"><h2 class="title blog-type-common blog-type-1"><a href="{url topic/getone/$topic['id']}">{$topic['title']}</a></h2><ul class="authorme list-inline"><li>
<span style="vertical-align:middle;"><a href="{url user/space/$topic['authorid']}">{$topic['author']}   {if $topic['author_has_vertify']!=false}
        <i class="fa fa-vimeo {if $topic['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  "  ></i>{/if}</a>
                    
                    发布于
                                           {$topic['format_time']}</span></li><li class="bookmark " title="{$topic['articles']} 收藏" ></li></ul></div></section>

  <!--{/loop}-->
</div>
            </div>
             <div class="pages" style="margin-bottom:15px;">{$departstr}</div>
        </div>
  

<!--{template footer}-->