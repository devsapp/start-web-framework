<!--{template header}-->
<style>
    body{
        background: #f1f5f8;;
    }
</style>
          
                 <!--最新公告-->
    <div class="au_side_box" atyle="margin-top:.1rem">

        <div class="au_box_title " >

            <div>
                <i class="fa fa-file-text-o lv"></i>最新公告

            </div>

        </div>
      
        
        <div class="stream-list blog-stream">
       <!--{loop $notelist $index $note}-->

<section class="stream-list__item"><div class="blog-rank stream__item"><div  class="stream__item-zan   btn btn-default mt0"><span class="stream__item-zan-icon"></span><span class="stream__item-zan-number">{$note['comments']}</span></div></div><div class="summary"><h2 class="title blog-type-common blog-type-1"><a  {if $note['url']} href="{$note['url']}"  {else}  href="{url note/view/$note['id']}" {/if} ">{$note['title']}</a></h2><ul class="authorme list-inline"><li>
<span style="vertical-align:middle;"><a href="{url user/space/$note['authorid']}">  {$note['author']}
               {if $note['author_has_vertify']!=false}<i class="fa fa-vimeo {if $note['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  "  ></i>{/if}</a>
                    
                    发布于
                                          {$note['format_time']}</span></li></ul></div></section>

  <!--{/loop}-->
</div>
        
        
           
             <div class="pages" style="margin-bottom:15px;">{$departstr}</div>
        </div>
        



<!--{template footer}-->