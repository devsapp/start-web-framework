<!--{template header}-->

<div class="container person">
  <div class="row">
    <div class="col-md-17 main">
          <!-- 用户title部分导航 -->
                 <!--{template space_title}-->


      <div id="list-container">
          <!-- 关注话题列表模块 -->
          <!--{if $categorylist==null}-->
                Ta还没关注话题
                 <!--{/if}-->
<ul class="note-list">
      <!--{loop $categorylist $index $cat}-->

    <li id="note-{$cat['id']}" data-note-id="{$cat['id']}" >

        <div class="content">
            <div class="author">





        <a class="avatar" target="_blank" href="{url user/space/$cat['uid']}">
                    <img src="{$cat['avatar']}" alt="96">
                </a>      <div class="name">
                <a class="blue-link" target="_blank" href="{url user/space/$cat['uid']}">Ta关注了话题</a>



                <span class="time" data-shared-at="{$cat['doing_time']}">{$cat['doing_time']}</span>
            </div>
            </div>



            <div class="follow-detail">
      <div class="info">
        <a class="avatar-collection" href="{$cat['url']}">
          <img src="{$cat['bigimage']}" alt="180">
</a>
{if $cat['follow']}
 <a class="btn btn-default following" id="attenttouser_{$cat['id']}" onclick="attentto_cat($cat['id'])"><i class="fa fa-check"></i><span>已关注</span></a>

{else}
 <a class="btn btn-success follow" id="attenttouser_{$cat['id']}" onclick="attentto_cat($cat['id'])"><i class="fa fa-plus"></i><span>关注</span></a>

{/if}
        <a class="title" href="{$cat['url']}">{$cat['name']}</a>
        <p>

          {$cat['questions']} 个问题， {$cat['followers']} 人关注
        </p>
      </div>
        <div class="signature">
        {$cat['miaosu']}
        </div>
    </div>





        </div>
    </li>

    <!--{/loop}-->












</ul>
  <div class="pages" >{$departstr}</div>
      </div>
    </div>

<div class="col-md-7  aside">
     <!--{template space_menu}-->
</div>

  </div>
</div>
<!--{template footer}-->