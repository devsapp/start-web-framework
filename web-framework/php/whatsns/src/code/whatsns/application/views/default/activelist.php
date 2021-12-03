<!--{template header}-->
<link rel="stylesheet" media="all" href="{SITE_URL}static/css/widescreen/css/activelist.css" />
<div class="container recommend">
  <div class="expertcatlist"  style="margin-top:30px;">
<div class="tabs-wrapper">
        <div class="tabs-mark-group plm ptm">
            <div class="title">所有分类：</div>

            <ul class="content list-unstyled list-inline" style="text-align:left;">
                <li class="classify">
                  <label class="label">{$category['name']}</label>
                </li>

                <li class="classify">
                </li>

                <li class="classify">
                </li>

            </ul>

        </div>

        <div class="tabs-group">
            <div class="title">分类:</div>
            <ul class="content clearfix">
             <li {if $category['id']=='all'}class="active" {/if}><a class="nav-link" href="{url user/activelist/all/all}">全部</a></li>


          <!--{loop $sublist $index $cat}-->



           <li {if $category['id']==$cat['id']}class="active" {/if}><a class="nav-link" href="{url user/activelist/$cat['id']/all}">{$cat['name']}</a></li>


                <!--{/loop}-->







            </ul>
        </div>





        <div class="tabs-group">
            <div class="title">条件:</div>
            <ul class="content clearfix">
                <li {if $status=='all'}class="active" {/if}><a class="nav-link tag" href="{url user/activelist/$category['id']/all}">全部</a></li>
                <li {if $status=='1'}class="active" {/if}><a class="nav-link tag" href="{url user/activelist/$category['id']/1}">付费</a></li>
                <li {if $status=='2'}class="active" {/if}><a class="nav-link tag" href="{url user/activelist/$category['id']/2}">免费</a></li>

            </ul>
        </div>
    </div>
 </div>
  <div class="row authorlist">





    <!--{loop $userlist $activeuser}-->


                <div class="col-md-6">
  <div class="wrap">
    <a class="avatar" target="_blank" href="{url user/space/$activeuser['uid']}">
      <img src="{$activeuser['avatar']}" alt="180">
</a>    <h4>
      <a target="_blank" href="{url user/space/$activeuser['uid']}">
      {$activeuser['username']}
       {if $activeuser['author_has_vertify']!=false}<i class="fa fa-vimeo v_person   " data-toggle="tooltip" data-placement="right" title="" data-original-title="认证用户"  ></i>{/if}
      </a>

    </h4>
    <p class="description">{$activeuser['signature']}</p>

{if $activeuser['hasfollower']==1}
      <a class="btn btn-default following" id="attenttouser_{$activeuser['uid']}" onclick="attentto_user($activeuser['uid'])">已关注</a>
{else}
      <a class="btn btn-success follow" id="attenttouser_{$activeuser['uid']}" onclick="attentto_user($activeuser['uid'])">关注</a>
{/if}
    <hr>
    <div class="meta ">战绩</div>
    <div class="recent-update ">

        <div class="news"><span>回答 {$activeuser['answers']}个</span><span>问题  {$activeuser['questions']}个</span></div>


    </div>
  </div>
</div>
                <!--{/loop}-->



  </div>

    <div class="pages">{$departstr}</div>
</div>
<!--{template footer}-->