<!--{template header}-->
<!--{eval $adlist = $this->fromcache("adlist");}-->
<style>
.doingfollow .follow, .doingfollow .follow-cancel, .doingfollow .follow-each, .doingfollow .following, .doingfollow .following:hover {
  padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857;
    font-weight: 400;
    line-height: normal;
}
.btn-success.focus, .btn-success:focus, .btn-success:hover {
    color: 0;
    background-color: #009A61;
    border-color: #009A61;
}
.doinglist li{
	padding-bottom:5px;
	
	margin-right:10px;
}
.suggest-header{
font-size:13px;
}
.subnav-wrap .subnav-contentbox .subnav-content>li.current>a, .subnav-wrap .subnav-contentbox .subnav-content>li>a:hover {
    color: #009A61;
    border-bottom: 2px solid #009A61;
}
.doinglist li .quote {
    background: #f0f0f0;
    width: 100%;
    padding: 5px;
    border-radius: 5px;
    color: #ea644a;
}
.doinglist li .related,.doinglist li .source{
	color: #999;
}
.doinglist li .title{
	color: #333;
	font-size:13px;
}
.subnav-wrap .subnav-contentbox .subnav-content>li{
padding-left:0px;
padding-right:30px;
}
</style>

<div class="container    index">

<div class="row">
   <div class="col-xs-17 side-box main" style="margin-top:10px;">
  <!--首页推荐-->
        <div class="subnav-content-wrap" id="tab_anchor" style="height: 56px;">
            <div class="subnav-wrap" style="left: 0px;">
                <div class="top-hull">
                    <div class="subnav-contentbox">
                        <div class="tab-nav-container">
                            <ul class="subnav-content ">
                          
                                   <!--{if $type=='atentto'}-->
                    <li class="current"><a href="{url doing/default}">关注的动态</a></li>
                    <li><a href="{url doing/default/my}">我的动态</a></li>
                    <li><a href="{url doing/default/all}">全站动态</a></li>
                    <!--{elseif $type=='my'}-->
                    <li><a href="{url doing/default}">关注的动态</a></li>
                    <li class="current"><a href="{url doing/default/my}">我的动态</a></li>
                    <li><a href="{url doing/default/all}">全站动态</a></li>
                    <!--{elseif $type=='all'}-->
                    <!--{if $this->user['uid']}-->
                    <li><a href="{url doing/default}">关注的动态</a></li>
                    <li><a href="{url doing/default/my}">我的动态</a></li>
                    <!--{/if}-->
                    <li class="current"><a href="{url doing/default/all}">全站动态</a></li>
                    <!--{/if}-->
                            </ul>
                            <div>



                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

  


                  

                             <!--广告位1-->
            <!--{if (isset($adlist['doing']['left1']) && trim($adlist['doing']['left1']))}-->
            <div style="margin-top:5px;">{$adlist['doing']['left1']}</div>
            <!--{/if}-->

             <ul class="nav  mar-t-1 doinglist">
                <!--{if $recommandusers && $page==1}-->
                <li><p class='suggest-header'>您可能感兴趣的人</p></li>
                <!--{loop $recommandusers $recommanduser}-->
                <li class="b-b-line mar-t-1 ">
                    <div class="row">

                    <div class="col-sm-20">
                      <div class="row">
                        <div class="col-md-3">
                         <a class="image-link" href="{url user/space/$recommanduser['uid']}" target="_blank"><img width="35" height="35" class="img-rounded" alt="{$recommanduser['username']}" src="{$recommanduser['avatar']}" /></a>

                        </div>

                        <div class="col-sm-16">
                         <div class="item-main">
                            <a class="item-link" href="{url user/space/$recommanduser['uid']}">{$recommanduser['username']}</a>
                            <p class="item-info-minor">
                                <!--{if $recommanduser['category']}-->擅长:
                                <!--{loop $recommanduser['category'] $category}-->
                                <i class="expert-field"><a target="_blank" href="{url category/view/$category['cid']}">{$category['categoryname']}</a></i>
                                <!--{/loop}-->
                                <!--{/if}-->
                            </p>
                            <p class="item-info-major">{$recommanduser['followers']}人关注 , {$recommanduser['answers']}回答</p>
                        </div>

                        </div>
                      </div>
                    </div>

                     <div class="col-sm-1 doingfollow">

                    <!--{if $recommanduser['is_follow']}-->
                        <a class="btn btn-success button_attention " onclick="attentto_user($recommanduser['uid'])" id="attenttouser_{$recommanduser['uid']}">取消关注</a>
                          <!--{else}-->
                           <a class="btn btn-success button_attention " onclick="attentto_user($recommanduser['uid'])" id="attenttouser_{$recommanduser['uid']}" >关注</a>
                            <!--{/if}-->
                    </div>



                    </div>
                </li>
                <!--{/loop}-->
                   <!--{/if}-->
                <!--{loop $doinglist $doing}-->
                <li class="b-b-line mar-t-1">
                    <div class="row">
                       <div class="col-sm-1">
                            <div class="avatar">
                        <!--{if $doing['hidden'] && in_array($doing['action'],array(1,8))}-->
                        <img src="{SITE_URL}static/css/default/avatar.gif" alt="匿名" />
                        <!--{else}-->
                        <a class="pic" target="_blank" title="{$doing['author']}" href="{url user/space/$doing['authorid']}"><img width="40" height="40" class="img-rounded" src="{$doing['avatar']}" alt="{$doing['author']}" onmouseover="pop_user_on(this, '{$doing[authorid]}', 'img');"  onmouseout="pop_user_out();" /></a>
                        <!--{/if}-->
                    </div>

                       </div>

                         <div class="col-sm-21">
                        <div class="msgcontent">
                        <div class="source">
                            <!--{if $doing['hidden'] && in_array($doing['action'],array(1,8))}-->
                            匿名
                            <!--{else}-->
                            <a title="{$doing['author']}"  target="_blank" href="{url user/space/$doing['authorid']}">{$doing['author']}</a>
                            <!--{/if}-->
                            {$doing['actiondesc']}<span class="time pull-right c-hui">{$doing['doing_time']}</span>
                        </div>
                        <div class="title clear"><a href="{$doing['url']}" target="_blank">{$doing['content']}</a></div>

                        <div class="related">
                         {if $doing['action']!=10&&$doing['action']!=11&&$doing['action']!=12}
                            <div class="pv c-hui">{$doing['attentions']} 人关注 <span class="dot">•</span> {$doing['answers']} 个{if $doing['action']==9}评论{else}回复{/if} <span class="dot">•</span> {$doing['views']} 次浏览 </div>
                         {/if}
                        </div>
                        <!--{if $doing['referid']}-->
                        <div class="quote bg-silver">
                          <div class="row mar-t-05">
                            <div class="col-sm-4">
                            <div class="avatar ">
                                <a href="{url user/space/$doing['refer_authorid']}"  target="_blank" class="pic"><img width="40" height="40" class="img-rounded" alt="{$doing['author']}" src="{$doing['refer_avatar']}" onmouseover="pop_user_on(this, '{$doing['refer_authorid']}', 'img');"  onmouseout="pop_user_out();" /></a>
                            </div>
                            </div>
                            <div class="col-sm-20">
                             <div class="detail "><p>{eval echo cutstr($doing['refer_content'],100)}</p></div>

                            </div>
                          </div>


                        </div>
                        <!--{/if}-->
                    </div>


                       </div>

                    </div>


                </li>
                <!--{/loop}-->

                <!--{if !$doinglist && $type=='my'}-->
                <li><p>帮助他人，快乐自己！拿出你的热心，帮忙大家解决问题吧。 <a href='{url category/view/all/1}'>这些问题需要您的帮助</a></p></li>
                <!--{/if}-->
            </ul>

         <div class="pages">{$departstr}</div>

   </div>

     <div class="col-xs-7 aside">
          <div class="recommend" >
   <div class="title">
   <i class="fa fa-hotuser"></i>
   <span class="title_text">热门用户</span>
   </div>
       <ul class="list ">
                <!--{eval $activeuserlist=$this->fromcache('activeuser');}-->
                <!--{loop $activeuserlist $index $activeuser}-->
                <!--{eval $index++;}-->
                <li class="b-b-line">
                <div class="row">
                <div class="col-xs-2">
                 <div class="pic mar-t-05"><a title="{$activeuser['username']}" target="_blank" href="{url user/space/$activeuser['uid']}"><img style="width:35px;hegiht:35px;" class="img-rounded" alt="{$activeuser['username']}" src="{$activeuser['avatar']}" /></a></div>
                </div>
                <div class="col-xs-16">
                <a title="{$activeuser['username']}" target="_blank" href="{url user/space/$activeuser['uid']}" >{$activeuser['username']}</a>
                  <a href="{url question/add/$activeuser['uid']}" class="text-danger">向TA求助</a>
                   <p class="clear mar-t-05" >
                    <span>{$activeuser['answers']}回答</span>
                    <span>{$activeuser['supports']}赞同</span>
                  </p>

                </div>

                </div>



                </li>
                <!--{/loop}-->
            </ul>
   </div>


       <!--热门问题一周热点-->



  <!--{eval $attentionlist=$this->fromcache('attentionlist');}-->
            {if $attentionlist}
       <div class="recommend">

  <div class="title">
   <i class="fa fa-wenti"></i>
   <span class="title_text">热门问题问题</span>
   </div>
   <div class="side-content">
    <ul class="list">

                    <!--{loop $attentionlist $index $question}-->

                    <li class="b-b-line">

                        <a  title="{$question['title']}" target="_blank" href="{url question/view/$question['id']}">{eval echo cutstr($question['title'],40,'');}</a>
                    </li>
                    <!--{/loop}-->


            </ul>
   </div>
   </div>
    {/if}
    <!--一周热点结束-->
         <!--广告位2-->
        <!--{if (isset($adlist['doing']['right1']) && trim($adlist['doing']['right1']))}-->
        <div style="margin-top: 5px;">{$adlist['doing']['right1']}</div>
        <!--{/if}-->


       <!--广告位3-->
        <!--{if (isset($adlist['doing']['right2']) && trim($adlist['doing']['right2']))}-->
        <div style="margin-top: 5px;">{$adlist['doing']['right1']}</div>
        <!--{/if}-->

   </div>


</div>


</div>


<!--{template footer}-->