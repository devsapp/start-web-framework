<!--{template header}-->
<link rel="stylesheet" media="all" href="{SITE_URL}static/css/widescreen/css/activelist.css" />
<style>
@media (min-width: 1601px)
{
.container {
    width: 1360px;
      max-width: 1360px;
}
.mod-b-wrapper .mod-bd .trip-list .index-userwrap {
    margin-top: 70px;
    height: 280px;
    width: 23%;
    border: 1px solid #ececec;
    background: #fff;
    display: inline-block;
    position: relative;
}
}
</style>
<div class="container ">
 <div class="expertcatlist" style="margin-top:30px;">
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
             <li {if $category['id']=='all'}class="active" {/if}><a class="nav-link" href="{url expert/default/all/all}">全部</a></li>


          <!--{loop $sublist $index $cat}-->



           <li {if $category['id']==$cat['id']}class="active" {/if}><a class="nav-link" href="{url expert/default/$cat['id']/all}">{$cat['name']}</a></li>


                <!--{/loop}-->







            </ul>
        </div>



    </div>
 </div>
   <div class="mod-b-wrapper">
            <div class="mod-bd">
                <ul class="trip-list">
               
                <!--{loop $expertlist $expert}-->
                    <li class="index-userwrap">
                        <a href="{url user/space/$expert['uid']}" target="_self" class="avatar">
                            <img src="{$expert['avatar']}" class="avatarPic lazy" alt="{$expert['username']}" title="{$expert['username']}" style="display: inline;">
                            <span class="icons">
    
    </span>
                        </a>
                        <div class="box">
                            <a class="name" href="{url user/space/$expert['uid']}" target="_self"><span>{$expert['username']}</span>{if
$expert['author_has_vertify']!=false}<i class="fa fa-vimeo v_person   " data-toggle="tooltip" data-placement="right" title="" data-original-title="认证用户"></i>{/if}</a>
                            <p class="intro"><span>{$expert['vertify']['jieshao']}</span></p>
                            <div class="achievement">
                                <a class="innerBox" target="_self"><span>{$expert['answers']}</span><i>回答</i></a>
                                <div class="separate"></div>
                                <a class="innerBox" target="_self"><span>{$expert['supports']}</span><i>获赞</i></a>
                                <div class="separate"></div>
                                <a class="innerBox" target="_self"><span>{eval echo $this->user_model->adoptpercent ( $expert );}%</span><i>采纳率</i></a>
                            </div>
                            <div class="btns">
                                <a  {if $user['uid']==0} href="javascript:login()" {else} href="{url question/add/$expert[uid]}" {/if}   {if $expert['mypay']>0} data-placement="bottom" data-toggle="tooltip" data-original-title="付费{$expert['mypay']}元咨询" {/if} class="tiwen-btn" target="_self">向他提问</a>
                            </div>
                        </div>
                    </li>
                      <!--{/loop}-->
                </ul>
            </div>
        </div>
  
    <div class="pages">{$departstr}</div>
</div>


<!--{template footer}-->