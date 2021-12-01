<!--{template header}-->

<div class="wrapper clearfix">

 <div class="l-content">
    <style>
.article .text a.check-text{}
.article .text a.check-text:hover{color:#666;text-decoration:none}
</style>
<div class="Card Topstory-noMarginCard Topstory-tabCard">
<ul role="tablist" class="Tabs">
<li role="tab" class="Tabs-item Tabs-item--noMeta" aria-controls="Topstory-recommend">
<a class="Tabs-link {if !$_valname}is-active{/if}" href="{SITE_URL}">最新</a></li>
<li role="tab" class="Tabs-item Tabs-item--noMeta" aria-controls="Topstory-hot">
<a class="Tabs-link {if $_valname=='xuanshang'}is-active{/if}" href="{url content/xuanshang}">悬赏</a></li>
<li role="tab" class="Tabs-item Tabs-item--noMeta" aria-controls="Topstory-follow">
<a class="Tabs-link {if $_valname=='tuijian'}is-active{/if}" href="{url content/tuijian}">推荐</a></li>
<li role="tab" class="Tabs-item Tabs-item--noMeta" aria-controls="Topstory-follow">
<a class="Tabs-link  {if $_valname=='solve'}is-active{/if}" href="{url content/solve}">热门</a></li>
<li role="tab" class="Tabs-item Tabs-item--noMeta" aria-controls="Topstory-follow">
<a class="Tabs-link {if $_valname=='nosolve'}is-active{/if}" href="{url content/nosolve}">等待解答</a></li>
</ul><div><div><div class="Sticky" style=""></div></div></div></div>
<div class="l-list">
{if !$_valname}
  <ul class="problemlist" id="loadul">
                       <!--{eval $doinglist=$this->fromcache('doinglist');}-->
                                    <!--{loop $doinglist $doing}-->
                          <li class="pl-item bb p-question-answers bf bb">
        <!-- 如果是普通问答 -->
                <h3><a target="_blank" href="{$doing['url']}">{$doing['content']}{if $doing['question']['price']}<label class="tit-money">奖励$doing['question']['price']财富值</label>{/if}{if $doing['question']['shangjin']}<label class="tit-money">悬赏$doing['question']['shangjin']元</label>{/if}</a></h3>
        <div class="person">
          <div class="figure"><a target="_blank" href="{url user/space/$doing['authorid']}"><img src="{$doing['avatar']}" alt=""></a></div>
          <div class="other" style="margin-top:9px;">
             <p class="name"><a target="_blank" href="{url user/space/$doing['authorid']}">{$doing['author']}</a> </p>
             <p></p>
          </div>
        </div>
        
        <div class="article  {if $doing['image']} apic {/if}">
                     {if $doing['image']}
                      <div class="figure"><a href="{$doing['url']}" target="_blank"><img src="$doing['image']"  alt=""></a></div>
                      {/if}
                      {if $doing['description']}
                      <div class="text">
              <a href="{$doing['url']}" class="check-text">{$doing['description']}</a>
              <a target="_blank" href="{$doing['url']}" class="check-all">查看全文</a>
           </div>
             {/if}
        </div>
        <div class="ask-bottom">
          <a href="javascript:;" class="thumbs-up active posWeizhi" >&nbsp;</a>
          <a href="javascript:;" class="" ><i class="fa fa-commentingicon"></i>{$doing['answers']} 个{if $doing['action']==9}评论{else}回复{/if}</a>
          <a href="javascript:;"  class=" "><i class="fa fa-qshoucang"></i>{$doing['attentions']}个收藏</a>
         <span class="from"><a target="_blank" href="{url category/view/$doing['cid']}">来自话题:{$doing['categoryname']}</a></span>        </div>
     </li>
                  <!--{/loop}-->         
     </ul>
     {else}
      <ul class="problemlist" id="loadul">
                     
                                    <!--{loop $questionlist $question}-->
                          <li class="pl-item bb p-question-answers bf bb">
        <!-- 如果是普通问答 -->
                <h3><a target="_blank" href="{url question/view/$question['id']}">{$question['title']}{if $question['price']}<label class="tit-money">奖励$question['price']财富值</label>{/if}{if $question['shangjin']}<label class="tit-money">悬赏$question['shangjin']元</label>{/if}</a></h3>
        <div class="person">
          <div class="figure"><a target="_blank" href="{url user/space/$question['authorid']}"><img src="{$question['avatar']}" alt=""></a></div>
          <div class="other" style="margin-top:9px;">
             <p class="name"><a target="_blank" href="{url user/space/$question['authorid']}">{$question['author']}</a> </p>
             <p></p>
          </div>
        </div>
        
        <div class="article  {if $question['image']} apic {/if}">
   
                     {if $question['image']}
                      <div class="figure"><a href="{url question/view/$question['id']}" target="_blank"><img src="$question['image']"  alt=""></a></div>
                      {/if}
                      {if $question['description']}
                      <div class="text">
              <a href="{url question/view/$question['id']}" class="check-text">{$question['description']}</a>
              <a target="_blank" href="{url question/view/$question['id']}" class="check-all">查看全文</a>
           </div>
             {/if}
        </div>
        <div class="ask-bottom">
          <a href="javascript:;" class="thumbs-up active posWeizhi" >&nbsp;</a>
          <a href="javascript:;" class="" ><i class="fa fa-commentingicon"></i>{$question['answers']} 个回复</a>
          <a href="javascript:;"  class=" "><i class="fa fa-qshoucang"></i>{$question['attentions']}个收藏</a>
         <span class="from"><a target="_blank" href="{url category/view/$question['cid']}">来自话题:{$question['category_name']}</a></span>        </div>
     </li>
                  <!--{/loop}-->         
     </ul>
     {/if}
     <div class="pages">{$departstr}</div>
 </div>
     <div class="morebox bb" id="loadPrompt" style="display: none;">
      <p class="check-more"><img src="https://icon.zol-img.com.cn/ask/2017/loadingring.gif"></p>
    </div>
    <div class="morebox bb" id="loadPrompttypetwo" style="display:none">
      <p class="check-more">加载更多<i></i></p>
    </div>

 
      </div><!-- l-content end -->
  <div class="r-aside">
  {if $user['uid']==0} 
  <div class="no-login bb">
         <div class="title">
           <h5>{$setting['site_name']}</h5>
           <p>欢迎加入我们成为社区一员</p>
         </div>
         <p class="inst">您还没有登录，点击 <a href="javascript:login()">登录</a></p>
     </div>
      {/if}
            <div class="user-info bb">
         <div class="user">
             <div class="figure"><a href="http://ask.zol.com.cn/me/e4bj5i" target="_blank"><img src="https://icon.zol-img.com.cn/ask/header/127.jpg" alt=""></a></div>
             <p class="f-title">欢迎您，{$user['username']}</p>
         </div>
          <p class="inst">您已获得&nbsp;<span class="s1">{$user['supports']}</span>赞</p>
          
          <p class="inst">采纳率&nbsp;<span class="s1">{eval echo $this->user_model->adoptpercent ( $this->user );}</span>%</p>
          
          <p class="inst">拥有现金&nbsp;<span class="s1">{eval echo doubleval($user['jine']/100);}</span>元</p>
           <p class="inst">拥有&nbsp;<span class="s1">{$user['credit2']}财富值</span></p>
       
        <div class="show">
             <a href="{url user/ask}" target="_blank"><span class="mypro">我的提问<br><font>{$user['questions']}</font></span></a>
             <a href="{url user/answer}" target="_blank"><span>我的回答<br><font>{$user['answers']}</font></span></a>
        </div>
      </div>
      <div class="no-login bb">
         <div class="btns">
            <a target="_blank" href="{url question/add}"><span class="my-ask">&nbsp;我要提问</span></a>
            <a target="_blank" href="{url newpage/index/5}"><span class="my-answer">&nbsp;我要回答</span></a>
         </div>
     </div>
      <div class="problems bb">
        <p class="iconshoucang"><i class="fa"></i>我收藏的问题&nbsp;:<a target="_blank" href="{url attention/question}"><font>{$user['attentions']}</font></a></p>
        <p class="iconinvateme"><i class="fa"></i>邀请我回答的问题&nbsp;:<a href="{url user/invateme}" target="_blank"><font>{eval echo returnarraynum ( $this->db->query ( getwheresql ( 'question', " askuid=" . $user['uid'], $this->db->dbprefix ) )->row_array () );}</font></a></p>
       <p class="iconwenzhang"><i class="fa"></i><a target="_blank" href="{url topic/userxinzhi/$user['uid']}">我的文章</a></p>
        <p class="iconcaifu"><i class="fa"></i><a target="_blank" href="{url gift}">财富值兑换</a></p>
        <p class="iconjiaoyi"><i class="fa"></i><a target="_blank" href="{url user/userzhangdan}">交易明细</a></p>
      </div>
           <!--  未登录 end -->
     <!--  20171123 -->
           <!--  20171123 -->
          <div style="margin-top:10px;" class="recommend bb">
         <h3 class="title">为你推荐</h3>
         <ul class="r-list">
                      <!--{eval $topiclist=$this->fromcache('hottopiclist');}-->
                 <!--{loop $topiclist $nindex $topic}-->
                                          
           <li>
              <i></i><a target="_blank" href="{url topic/getone/$topic['id']}" class="tit" title="{$topic['title']}">{$topic['title']}</a>
                         </li>
                    <!--{/loop}-->
           
                    
         </ul>
     </div> <!-- recommend end -->
               <div class="experts bb">
        <h3 class="title">问答专家 <a target="_blank" href="{url expert/default}" class="more">更多<font> &gt;&gt; </font></a></h3>
        <ul class="exp-list">
             <!--{eval $expertlist=$this->fromcache('expertlist');}-->
                <!--{loop $expertlist $index $expert}-->
                {if $index<3}
                      <li>
              <div class="e-info clearfix">
                 <div class="figure"><a target="_blank" href="{url user/space/$expert['uid']}"><img src="{$expert['avatar']}" alt=""></a></div>
                 <div class="other">
                   <p class="name"><a target="_blank" href="{url user/space/$expert['uid']}">{$expert['username']}{if
$expert['author_has_vertify']!=false}<i class="fa fa-vimeo v_person   " ></i><span>认证专家</span>{/if}</a></p>
                   <p class="inst">回答数量 : {$expert['answers']}个</p>
                   <p class="inst">获赞数 : {$expert['supports']}个</p>
                 </div>
              </div>
              <p class="article"></p>
           </li>
           {/if}
          <!--{/loop}-->             
                {if !$user['author_has_vertify']}    
           <a target="_blank" {if $user['uid']==0} href="javascript:login()" {else} href="{url user/vertify}" {/if} ><li><span class="renz">申请认证</span></li></a>
       {/if}
        </ul>
     </div>
             <div class="recommend bb hot-pro">
         <h3 class="title">等待帮助</h3>
         <ul class="r-list">
             <!--{eval $nosolvelist=$this->fromcache('nosolvelist');}-->
  <!--{loop $nosolvelist $index $question}-->
                       <li>
              <i></i><a target="_blank"  href="{url question/view/$question['id']}"  title=" {$question['title']}" class="tit">{$question['title']}</a>
                         </li>
                       <!--{/loop}-->
                      </ul>
     </div>
          <div class="topic bb"><a target="_blank" href="/topic">话题</a></div>

  </div><!-- r-aside end -->
</div>
    <!--{template footer}-->