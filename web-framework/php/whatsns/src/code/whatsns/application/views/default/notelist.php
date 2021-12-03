<!--{template header}-->

<!--{eval $adlist = $this->fromcache("adlist");}-->
<!--内容部分--->
   {if (isset($adlist['common']['left1'])&& trim($adlist['common']['left1']))}
  
   
     <div class="advlong-bottom">
            <div class="advlong-default">
                   <!--广告位1-->
           
           {$adlist['common']['left1']}
           
            </div>
        </div>
         {/if}
<div class="container index  ">

<div class="row">
<div class="col-xs-17 main bb" style="padding-top: 0px">


     <h3 class="title" style="float: none;padding:0px;">公告列表</h3>



 <div id="list-container" style="margin-top: 10px;">
     <!--{if $notelist==null}-->
     <div class="text"><span>目前还没发布公告</span> </div>
        <!--{/if}-->
    <!-- 文章列表模块 -->
    <ul class="note-list" >


             <!--{loop $notelist $index $note}-->

   <li id="note-{$note['id']}" data-note-id="{$note['id']}" {if $note['image']!=null}  class="have-img" {else}class="" {/if}>
    {if $note['image']!=null}
      <a class="wrap-img"  {if $note['url']} href="{$note['url']}"  {else}  href="{url note/view/$note['id']}" {/if}  target="_blank">
            <img src="{$note['image']}">
        </a>
            {/if}
        <div class="content">
            <div class="author">






        <a class="avatar" target="_blank" href="{url user/space/$note['authorid']}">
                    <img src="{$note['avatar']}" alt="96">
                </a>      <div class="name">
                <a class="blue-link" target="_blank" href="{url user/space/$note['authorid']}">{$note['author']}</a>




                <span class="time" data-shared-at="{$note['format_time']}">{$note['format_time']}</span>
            </div>
            </div>
            <a class="title" target="_blank"   {if $note['url']} href="{$note['url']}"  {else}  href="{url note/view/$note['id']}" {/if} >{$note['title']}</a>
            <p class="abstract">
                {$note['content']}

            </p>
            <div class="meta">

                <a target="_blank"  {if $note['url']} href="{$note['url']}"  {else}  href="{url note/view/$note['id']}" {/if} >
                    <i class="fa fa-eye"></i> {$note['views']}
                </a>        <a target="_blank"   {if $note['url']} href="{$note['url']}"  {else}  href="{url note/view/$note['id']}#comments" {/if} >
                <i class="fa fa-comment-o"></i> {$note['comments']}
            </a>
            </div>
        </div>
    </li>

    <!--{/loop}-->

    </ul>
    <!-- 文章列表模块 -->
    </div>




                     <div class="pages">{$departstr}</div>


           

</div>

<div class="col-xs-7  aside ">
  <!-- 热门文章排行 -->
    <!--{template sider_hotarticle}-->


            <!--广告位2-->
              <div class="mar-t-1">
        <!--{if (isset($adlist['common']['right1']) && trim($adlist['common']['right1']))}-->
        <div style="margin-top:5px;">{$adlist['common']['right1']}</div>
         </div>
        <!--{/if}-->


</div>

</div>

</div>

</div>
<!--内容部分结束--->
<!--{template footer}-->