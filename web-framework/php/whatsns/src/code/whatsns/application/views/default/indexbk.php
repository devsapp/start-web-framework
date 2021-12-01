<!--{template header}-->
<!--{eval $adlist = $this->fromcache("adlist");}-->

   <!--{if 0!=$user['uid']}-->
     <!--{if $setting['register_on']==1&&$user['active']!=1}-->
<div class="alert alert-success-inverse text-center" style="padding-top:22px;margin-top:10px;margin-bottom:0px;">
 <button type="button" class="close text-whtie" data-dismiss="alert" aria-hidden="true">×</button>
<p>
应互联网新规，用户必须实名登记，您的邮箱还没有激活<a href="{url user/editemail}" class="mar-ly-1 " >点击激活邮件</a>
</p>
</div>
   <!--{/if}-->
   <!--{/if}-->
<div class="container index  " >

        <!--{if (isset($adlist['index']['middle1']) && trim($adlist['index']['middle1']))}-->
        <div>{$adlist['index']['middle1']}</div>
        <!--{/if}-->

  <!--{template sider_duizhang}-->

    <div class="row greenbox">
    <div class="col-xs-17  ">


    <div id="list-container">
    <!-- 文章列表模块 -->
    <ul class="note-list" >



      <!--{eval $topdatalist=$this->fromcache('topdata');}-->
                <!--{loop $topdatalist  $topdata}-->


     <li id="note-{$topdata['id']}" data-note-id="{$topdata['id']}" class="whiteblock">

        <div class="content">
            <div class="author">






        <a class="avatar" target="_self" href="{url user/space/$topdata['model']['authorid']}">
                    <img src="{$topdata['model']['avatar']}" alt="96">
                </a>      <div class="name">
                <a class="blue-link" target="_self" href="{url user/space/$topdata['model']['authorid']}">{$topdata['model']['author']}{if $topdata['author_has_vertify']!=false}<i class="fa fa-vimeo {if $topdata['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  " data-toggle="tooltip" data-placement="right" title="" {if $topdata['author_has_vertify'][0]=='0'}data-original-title="认证用户" {else}data-original-title="认证用户" {/if} ></i>{/if}</a>



        {if $topdata['type']=='topic'}
                发布了一篇文章

            {/if}
              {if $topdata['type']=='note'}
                发布了公告

            {/if}
            {if $topdata['type']=='qid'}
                提了一个问题

            {/if}
                <span class="ico_point">.</span>
                <span class="time" data-shared-at="{$topdata['format_time']}">{$topdata['format_time']}</span>

                     <img src="{SITE_URL}static/css/common/dingzhi.png" class="topcontent">

            </div>
            </div>
            <a class="title" target="_self"  href="{$topdata['url']}">{$topdata['title']}</a>
            <p class="abstract">
         {eval echo clearhtml($topdata['description']);}



            </p>
            <div class="meta">

                <a target="_self" href="{$topdata['url']}"  >
                    <i class="fa fa-eye"></i> {$topdata['views']}
                </a>        <a target="_self"  href="{$topdata['url']}#comments"  >
                <i class="fa fa-comment-o"></i> {$topdata['answers']}
            </a>      <span><i class=" fa fa-heart-o"></i>  {$topdata['attentions']}</span>
                <!--{if $user['grouptype']==1}-->
              <a href="{url topicdata/cancelindex/$topdata['typeid']/$topdata['type']}" >
                        <span>取消顶置</span>
                    </a>
                        <!--{/if}-->
            </div>
        </div>
    </li>




     <!--{/loop}-->


<!--{eval $expertlist=$this->fromcache('expertlist');}-->
<!--{if $expertlist}--> <!--专家列表-->
  <li class="ws_li_expertlist">
            <div class="recommend-talents">
            <div class="title">
            <span class="text">
            专家推荐
        </span>
         <a href="{url expert/default}" target="_blank" data-log="Visit_TalentsPage|From_" class="check">
         <span>查看全部专家</span>
          <i class="iconfont icon-ask_arrow_right arrow"></i>
          </a>
          </div>
          <div class="talent-wrapper">
          <div onclick="moveleft()" class="circle-bg talents-btn-back" style="">
          <i class="fa fa-angle-left arrow" style="margin-left: -1px;"></i>
          </div>
          <div onclick="moveright()" class="circle-bg talents-btn-forward">
          <i class="fa fa-angle-right arrow" style="margin-left: 1px;"></i>
          </div>
          <div class="talent-box first" style="left: 0px;">
<!--{loop $expertlist $expert}-->
          <div class="talent-card">
          <a href="{url user/space/$expert['uid']}" target="_blank" data-log="Visit_Profile|From_talent">
          <div class="head">
          <img src="{$expert['avatar']}" alt="">
          </div>
          <div class="name-wrapper"><span class="name">{$expert['username']} {if
$expert['author_has_vertify']!=false}<i class="fa fa-vimeo v_person   " data-toggle="tooltip" data-placement="right" title="" data-original-title="认证用户"></i>{/if} </span>
           <i class="iconfont icon-all_newv newv"></i>
           </div>
           <div class="tag">{eval echo clearhtml($expert['signature'],20);}</div>
           </a>
           {if $expert['hasfollower']==1}

 <a data-log="Follow_User|From_" id="attenttouser_{$expert['uid']}" class="w-follow-btn following" onclick="attentto_user($expert['uid'])">
            <i class="iconfont icon-details_add_icon"></i>
             <i class="iconfont icon-details_attention_icon">
             </i>
             <i class="fa fa-check"></i>
             <span>
        已关注
    </span></a>

{else}

 <a data-log="Follow_User|From_" id="attenttouser_{$expert['uid']}" class="w-follow-btn follow" onclick="attentto_user($expert['uid'])">
            <i class="iconfont icon-details_add_icon"></i>
             <i class="iconfont icon-details_attention_icon">
             </i>
             <span>
        +关注
    </span></a>
{/if}

    </div>
    <!--{/loop}-->

   </div>
   </div>
   </div>

        </li>
<!--{/if}-->






                <!--{loop $nosolvelist $index $question}-->

    <li id="note-{$question['id']}" data-note-id="{$question['id']}" {if $question['image']!=null}  class="have-img whiteblock" {else}class="whiteblock" {/if}>
    {if $question['image']!=null}
      <a class="wrap-img" {if $question['articleclassid']!=null} href="{url topic/getone/$question['id']}"  {else}  href="{url question/view/$question['id']}" {/if} target="_self">
            <img src="{$question['image']}">
        </a>
            {/if}
        <div class="content">
            <div class="author">





        {if $question['hidden']==1}

          <a class="avatar"  href="javascript:void(0)">
                    <img src="{SITE_URL}static/css/default/avatar.gif" alt="96">
                </a>      <div class="name">
                <a class="blue-link"  href="javascript:void(0)">匿名用户</a>


        {else}
        <a class="avatar" target="_self" href="{url user/space/$question['authorid']}">
                    <img src="{$question['avatar']}" alt="96">
                </a>      <div class="name">
                <a class="blue-link" target="_self" href="{url user/space/$question['authorid']}">{$question['author']} {if $question['author_has_vertify']!=false}<i class="fa fa-vimeo {if $question['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  " data-toggle="tooltip" data-placement="right" title="" {if $question['author_has_vertify'][0]==0}data-original-title="认证用户" {else}data-original-title="认证用户" {/if} ></i>{/if}</a>

        {/if}

                {if $question['askuid']>0}
                      对<span class="text-danger">{$question['askuser']['username']}</span>
                  {/if}
        {if $question['articleclassid']!=null}
                发布了一篇文章
          {else}
          提了一个问题
            {/if}
                <span class="ico_point">.</span>
                <span class="time" data-shared-at="{$question['format_time']}">{$question['format_time']}</span>
                {if $question['shangjin']!=0}
                      <span data-toggle="tooltip" data-placement="bottom" title="" data-original-title="如果回答被采纳将获得 {$question['shangjin']}元，可提现" class="icon_hot"><i class="fa fa-cny mar-r-03"></i>悬赏$question['shangjin']元</span>
                    {/if}
                 {if $question['hasvoice']!=0}
                      <span data-toggle="tooltip" data-placement="bottom" title="" data-original-title="微信扫一扫可偷听回答者回复" class="icon_green"><i class="fa fa-volume-up mar-r-03"></i>语音偷听</span>
                    {/if}
                        {if $question['askuid']>0}
                      <span data-toggle="tooltip" data-placement="bottom" title="" data-original-title="邀请{$question['askuser']['username']}回答"  class="icon_zise"><i class="fa fa-twitch mar-r-03"></i>邀请回答</span>
                  {/if}
                    {if $question['articleclassid']!=null&&$question['price']!=0}
                      <span data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{$question['price']} 积分阅读" class="icon_green"><i class="fa fa-gg mar-r-03"></i>付费阅读</span>
                    {/if}
            </div>
            </div>
            <a class="title" target="_self"  {if $question['articleclassid']!=null} href="{url topic/getone/$question['id']}"  {else}  href="{url question/view/$question['id']}" {/if} >{$question['title']}</a>
            <p class="abstract">
              {if $question['articleclassid']!=null&&$question['price']!=0}
                            <div class="box_toukan ">

  {eval echo clearhtml($question['freeconent']);}
  {if $question['readmode']==2}
											<a  class="thiefbox font-12" ><i class="icon icon-lock font-12"></i> &nbsp;更多阅读需支付&nbsp;$question['price']&nbsp;&nbsp;积分……</a>
{/if}
  {if $question['readmode']==3}
											<a  class="thiefbox font-12" ><i class="icon icon-lock font-12"></i> &nbsp;更多阅读需支付&nbsp;$question['price']&nbsp;&nbsp;元……</a>
{/if}

										</div>
                   {else}
                    {eval echo clearhtml($question['description']);}
                    {/if}



            </p>
            <div class="meta">
                <a class="collection-tag" target="_self" {if $question['articleclassid']!=null} href="{url topic/catlist/$question['articleclassid']} {else}  href="{url category/view/$question['cid']} {/if} ">$question['category_name']</a>
                <a target="_self" {if $question['articleclassid']!=null} href="{url topic/getone/$question['id']}"  {else}  href="{url question/view/$question['id']}" {/if}>
                    <i class="fa fa-eye"></i> {$question['views']}
                </a>        <a target="_self" {if $question['articleclassid']!=null} href="{url topic/getone/$question['id']}#comments"  {else}  href="{url question/view/$question['id']}#comments" {/if}>
                <i class="fa fa-comment-o"></i> {$question['answers']}
            </a>      <span><i class=" fa fa-heart-o"></i>  {$question['attentions']}</span>
            </div>
        </div>
    </li>

    <!--{/loop}-->

    </ul>
    <!-- 文章列表模块 -->
    </div>
    </div>

    <!--右边栏目-->
    <div class="col-xs-7    aside ">

<!--{template sider_login}-->
 <!--{template sider_topic}-->
         <!--{template sider_author}-->

            <!--{template sider_hotarticle}-->

                  <!--{template cms}-->
                    <!--{if (isset($adlist['index']['right1']) && trim($adlist['index']['right1']))}-->
        <div>{$adlist['index']['right1']}</div>
        <!--{/if}-->
    </div>





        </div>


    </div>
    <!--{if (isset($adlist['index']['middle2']) && trim($adlist['index']['middle2']))}-->
        <div>{$adlist['index']['middle2']}</div>
        <!--{/if}-->

<script>
var currentindex=0;
var _indexwidth=210;
var _movelen=$(".talent-card").length;
$(".talents-btn-back").hide();
if(_movelen<=3){
	$(".talents-btn-forward").hide();
}
function moveleft(){
    currentindex=currentindex+_indexwidth*3;

    if(currentindex==0){
        $(".talents-btn-forward").show();
        $(".talents-btn-back").hide();
        $(".talent-wrapper .first").css("left",currentindex+"px");
        return false;
    }else{
        $(".talents-btn-forward").show();
    }

    $(".talent-wrapper .first").css("left",currentindex+"px");
    //currentindex=currentindex-_indexwidth*3;
}
function moveright(){

    currentindex=currentindex-_indexwidth*3;
    $(".talents-btn-back").show();
    if(Math.abs(currentindex)>=(_movelen-3)*_indexwidth){
        $(".talents-btn-forward").hide();
        $(".talent-wrapper .first").css("left",currentindex+"px");
        return false;
    }else{

    }

    $(".talent-wrapper .first").css("left",currentindex+"px");
}

</script>

<!--{template footer}-->