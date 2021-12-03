<!--{template header}-->
<link rel="stylesheet" media="all" href="{SITE_URL}static/css/widescreen/css/greendetail.css?v1.1" />
<link rel="stylesheet" media="all" href="{SITE_URL}static/css/widescreen/css/widescreendetail.css?v1.1" />
   <script type="text/javascript" src="{SITE_URL}static/js/jquery.qrcode.min.js"></script>
<style>
#header {
    height: 34px;
    line-height: 34px;
    border-bottom: 1px solid #eee;
    position: fixed;
    width: 100%;
    background: #fff;
    z-index: 999999;
        top: 0px;
}
#nav {
    height: 80px;
    background-color: #ffffff;
    padding-top: 20px;
    box-sizing: border-box;
    border-bottom: solid 1px #ebebeb;
    position: fixed;
    width: 100%;
    background: #fff;
        top: 30px;
            z-index: 999999;
}
.note {
    padding-top: 0px;
       background: #fff;
    margin-top: 30px;
}
<!--
.note .post {
    margin: 0 auto;
    padding-top: 20px;
    padding-bottom: 40px;
    width: 720px;
}
.note .post .article .author .avatar {
    width: 48px;
    height: 48px;
    vertical-align: middle;
    display: inline-block;
}
.note .post .article .author .avatar {
    width: 48px;
    height: 48px;
    vertical-align: middle;
    display: inline-block;
}
.note .post .support-author p {
    padding: 0 30px;
    margin-bottom: 20px;
    min-height: 24px;
    font-size: 17px;
    font-weight: 700;
    color: #969696;
}
.note .post .support-author .btn-pay {
    margin-bottom: 20px;
    padding: 8px 25px;
    font-size: 16px;
    color: #fff;
    background-color: #ea6f5a;
    border-radius: 20px;
}
.note .post .support-author .supporter {
    height: 50px;
}
.note .post .show-foot {
    margin-bottom: 30px;
}
.note .post .show-foot .notebook {
    font-size: 12px;
    color: #c8c8c8;
}
a {
    cursor: pointer;
}
.note .post .show-foot .copyright {
    float: right;
    margin-top: 5px;
    font-size: 12px;
    line-height: 1.7;
    color: #c8c8c8;
}
.note .post .show-foot .modal-wrap {
    float: right;
    margin-top: 5px;
    margin-right: 20px;
    font-size: 12px;
    line-height: 1.7;
}
.note .post .show-foot .modal-wrap>a {
    color: #c8c8c8;
}
.note .post .meta-bottom .share-group {
    float: right;
    margin-top: 6px;
}
.note .post .meta-bottom .share-group .share-circle .fa-wechat {
    color: #00bb29;
}
.note .post .meta-bottom .share-group .share-circle i {
    font-size: 24px;
    line-height: 2;
}
.note .post .meta-bottom .share-group .share-circle {
    width: 50px;
    height: 50px;
    margin-left: 5px;
    text-align: center;
    border: 1px solid #dcdcdc;
    border-radius: 50%;
    vertical-align: middle;
    display: inline-block;
}
.btn-default-main {
    color: #fff;
    background: #ea644a;
    border: 1px solid #ea644a;
    border-radius: 4px;
    cursor: pointer;
    text-align: center;
}
.following, .following:hover {
    color: #ea644a;
    border: 1px solid #ea644a;
}
.btn-success:active:focus, .btn-success:active:hover{
    background-color: #ea644a;
    border-color: #ea644a;
}

.btn-success, .btn-success:hover {
    color: #ea644a;
    background-color: transparent;
    border-color: #ea644a;
}
.note .post .follow-detail .btn {
    float: right;
    margin-top: 4px;
    padding: 5px 0;
    width: 100px;
    font-size: 16px;
}
.btn-dashang, .btn-dashang:hover {
    color: #ea644a;
    border-radius: 2px;
    width: 80%;
    margin: 10px auto;
}
-->
</style>
  <div class="note">
  <div id="note-fixed-ad-container">
    <div id="fixed-ad-container">
      <div id="write-notes-ad"></div>
      <div id="youdao-fixed-ad"></div>
      <div id="yuxi-fixed-ad"></div>
       <div id="zhangxin-fixed-ad"></div>
      <div id="_so_pdsBy_0"></div>
    </div>
  </div>
  <div class="post">
    <div class="article">
        <h1 class="title">{$topicone['title']}</h1>

        <!-- 作者区域 -->
        <div class="author">
          <a class="avatar" href="{url user/space/$member['uid']}">
            <img src="{$member['avatar']}" alt="96">
</a>          <div class="info">
            <span class="name">   <a href="{url user/space/$member['uid']}" title="{$topicone['author']}" class="title-content">
               {$topicone['author']}
                  {if $topicone['author_has_vertify']!=false}<i class="fa fa-vimeo {if $topicone['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  " data-toggle="tooltip" data-placement="right" title="" {if $topicone['author_has_vertify'][0]=='0'}data-original-title="个人认证" {else}data-original-title="企业认证" {/if} ></i>{/if}
                
                </a></span>
            <!-- 关注用户按钮 -->
                {if  $is_followedauthor}
     
                                        <a class="btn btn-success follow following" title="已关注" id="attenttouser_{$topicone['authorid']}" onclick="attentto_user($topicone['authorid'])"><span>已关注</span></a>
                              {else}
                          
            <a class="btn btn-success follow notfollow" title="添加关注" id="attenttouser_{$topicone['authorid']}" onclick="attentto_user($topicone['authorid'])"><span>关注</span></a>
           
                                {/if}
          
           
            <!-- 文章数据信息 -->
            <div class="meta" style="    position: relative;">
      
            
                <span class="publish-time" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="最后编辑于 {$topicone['viewtime']}">{$topicone['viewtime']}</span>
              <span class="wordage">字数 {$topicone['artlen']}</span>
            <span class="views-count">阅读 {$topicone['views']}</span><span class="comments-count">评论 {$topicone['articles']}</span><span class="likes-count">喜欢 {$topicone['likes']}</span>
             <!--{if $user['grouptype']==1||$user['uid']==$member['uid']}-->
                <!-- 如果是当前作者，加入编辑按钮 -->
                <a href="javascript:void(0)"  data-toggle="dropdown" class="text-danger dropdown-toggle">操作 <i class="fa fa-angle-down mar-lr-05"></i> </a>
                 <ul class="dropdown-menu" role="menu" >
                {if $user['grouptype']==1}
                       <li>


                    <a href="{url topic/pushhot/$topicone['id']}" data-toggle="tooltip" data-html="true" data-original-title="被推荐文章将会在首页展示">
                        <span>推荐文章</span>
                    </a>
                      </li>
                        <li>


                    <a href="{url topicdata/pushindex/$topicone['id']/topic}" data-toggle="tooltip" data-html="true" data-original-title="被顶置的文章将会在首页列表展示">
                    <span>首页顶置</span>
                    </a>
                      </li>
                      {/if}
                           <li>

                    <a href="{url user/editxinzhi/$topicone['id']}">
                      <span>编辑文章</span>
                    </a>
                      </li>
                        <li>

                    <a href="{url user/deletexinzhi/$topicone['id']}">
                       <span>删除文章</span>
                    </a>
                      </li>

                             </ul>
                               <!--{/if}-->
            
            </div>
           
          </div>
          <!-- 如果是当前作者，加入编辑按钮 -->
        </div>


        <!-- 文章内容 -->
        <div data-note-content="" class="show-content">
          <div class="show-content-free">
                   
                     {if $topicone['price']!=0&&$haspayprice==0&&$user['uid']!=$topicone['authorid']}
  {eval echo replacewords(html_entity_decode($topicone['freeconent']));}
  
                         <div class="box_toukan ">

										{if $user['uid']==0}
											<div onclick="login()" class="thiefbox font-12" style="color:#fff;text-decoration:none;" ><i class="icon icon-lock font-12"></i> &nbsp;更多阅读需支付&nbsp;$topicone['price']&nbsp;&nbsp;{eval if ($topicone['readmode']==2) echo '财富值'; }{eval if ($topicone['readmode']==3) echo '元'; }……</div>
											{else}
											<div onclick="viewtopic($topicone['id'])"  class="thiefbox font-12" style="color:#fff;text-decoration:none;" ><i class="icon icon-lock font-12"></i> &nbsp;更多阅读需支付&nbsp;$topicone['price']&nbsp;&nbsp;{eval if ($topicone['readmode']==2) echo '财富值'; }{eval if ($topicone['readmode']==3) echo '元'; }……</div>
											{/if}


										</div>
                   {else}
                   {eval echo  replacewords(html_entity_decode($topicone['describtion']));}
           
              
                    {/if}
         
          </div>
        </div>
    </div>

  {if $setting['openwxpay']==1}
        <div id="free-reward-panel" class="support-author">
        <p>赞赏我，让我继续有写作的动力</p> 
        <div class="btn btn-pay" data-toggle="tooltip" data-placement="top" title="" data-original-title="一共获得了{$totalmoney}元" onclick="wxpay('tid',{$topicone['id']},{$topicone['authorid']} );">赞赏支持</div>
    {if $shanglist}
 <!--打赏列表-->
   <div class="supporter">
   <ul class="support-list">
       <!--{loop $shanglist  $shang}-->
   <li>
   <a  href="{$shang['url']}" class="avatar"  data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{$shang['operation']}">
   <img src="{$shang['avatar']}">
   </a>
   </li>
    <!--{/loop}-->
   </ul> </div>

{/if}
         </div>
 {/if}


      <div class="show-foot">
        <a class="notebook" href="{url topic/catlist/$cat_model['id']}">
          <i class=" fa fa-rss-square"></i>
          <span>{$cat_model['name']}</span>
</a>        <div class="copyright" data-toggle="tooltip" data-html="true" data-original-title="转载请联系作者获得授权，并标注“{$setting['site_name']}作者”。">
          © 著作权归作者所有
        </div>
        <div class="modal-wrap" data-report-note="">
          <a id="report-modal" onclick="openinform(0,'{$topicone['title']}',{$topicone['id']})">举报文章</a>
        </div>
      </div>

      <!-- 文章底部作者信息 -->
        <div class="follow-detail">
          <div class="info">
            <a class="avatar" href="{url user/space/$topicone['authorid']}">
              <img src="{$member['avatar']}" alt="96">
</a>          
                {if  $is_followedauthor}
     
                                        <a class="btn btn-success follow following" title="已关注" id="attenttouser_{$topicone['authorid']}" onclick="attentto_user($topicone['authorid'])"><span>已关注</span></a>
                              {else}
                          
            <a class="btn btn-success follow notfollow" title="添加关注" id="attenttouser_{$topicone['authorid']}" onclick="attentto_user($topicone['authorid'])"><span>关注</span></a>
           
                                {/if}
            <a class="title" href="{url user/space/$member['uid']}">{$member['username']}</a>
          <p>写了 {$member['articles']} 文章，被 {$member['followers']} 人关注，获得了 {$member['supports']} 个赞</p></div>
            <div class="signature">{$member['introduction']}</div>
        </div>

    <div class="meta-bottom">
      <div class="like"><div class="btn like-group"><div class="btn-like">
      
          {if $isfollowarticle}
                
                          <a href="{url favorite/delfavoratearticle/$topicone['id']}"><i class="fa fa-heart-o"></i>已收藏</a>
          
                   {else}
                   {if $user['uid']}
                 
                           <a href="{url favorite/topicadd/$topicone['id']}"><i class="fa fa-heart-o"></i>收藏</a>
          
                      {else}
                           <a href="javascript:login()"><i class="fa fa-heart-o"></i>收藏</a>
          
                      {/if}  
                    {/if}
                        
                        

      
      </div> <div class="modal-wrap"><a> {$topicone['likes']}</a></div></div> <!----></div>
      <div class="share-group">
        <a class="share-circle share-weixin" data-action="weixin-share" data-toggle="tooltip" data-original-title="分享到微信">
          <i class="fa fa-wechat"></i>
        </a>
        <a class="share-circle" data-toggle="tooltip" href="javascript:void((function(s,d,e,r,l,p,t,z,c){var%20f='http://v.t.sina.com.cn/share/share.php?appkey=1515056452',u=z||d.location,p=['&amp;url=',e(u),'&amp;title=',e(t||d.title),'&amp;source=',e(r),'&amp;sourceUrl=',e(l),'&amp;content=',c||'gb2312','&amp;pic=',e(p||'')].join('');function%20a(){if(!window.open([f,p].join(''),'mb',['toolbar=0,status=0,resizable=1,width=440,height=430,left=',(s.width-440)/2,',top=',(s.height-430)/2].join('')))u.href=[f,p].join('');};if(/Firefox/.test(navigator.userAgent))setTimeout(a,0);else%20a();})(screen,document,encodeURIComponent,'','','{$topicone['image']}', '推荐 {$topicone['author']} 的文章《{$topicone['title']}》','{url topic/getone/$topicone['id']}','页面编码gb2312|utf-8默认gb2312'));" data-original-title="分享到微博">
          <i class="fa fa-weibo"></i>
        </a>

         <a  class="share-circle" data-toggle="tooltip"  target="_self" data-original-title="分享到qq" href="javascript:shareqq()"   title="分享到QQ"><i class="fa fa-qq"></i></a>


  <script type="text/javascript">

//  document.write(['<a class="share-circle" data-toggle="tooltip"  target="_self" data-original-title="分享到qq空间" href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=',encodeURIComponent(location.href),'&title=',encodeURIComponent(document.title),'" target="_self"   title="分享到QQ空间"> <i class="fa fa-qq"></i><\/a>'].join(''));

  function shareqq()
  {
      var p = {
          url: location.href,/*获取URL，可加上来自分享到QQ标识，方便统计*/
          desc: "{eval echo clearhtml(htmlspecialchars_decode( replacewords($topicone['describtion'])),50);}", 
          title : document.title,/*分享标题(可选)*/
          summary : document.title,/*分享描述(可选)*/
          pics : "{$topicone['image']}",/*分享图片(可选)*/
          flash : '', /*视频地址(可选)*/
          //commonClient : true, /*客户端嵌入标志*/
          site: "{$setting['site_name']}"/*分享来源 (可选) ，如：QQ分享*/
      };


      var s = [];
      for (var i in p) {
          s.push(i + '=' + encodeURIComponent(p[i] || ''));
      }
      var target_url = "http://connect.qq.com/widget/shareqq/iframe_index.html?" + s.join('&') ;
      window.open(target_url, 'qq',
              'height=520, width=720');
  }
  
  </script>
      </div>
    </div>

    <div id="note-ad" class=""></div>
   <div class="index">
<div class="row">
   <div class=" main" style="padding:10px">
   <div class="note">
    <div class="post">
       


 


       <div id="comment-list" class="comment-list"><div>
            {if $user['uid']!=0}
 <form class="new-comment">
  <input type="hidden" id="artitle" value="{$topicone['title']}" />
    <input type="hidden" id="artid" value="{$topicone['id']}" />
 <a class="avatar">
 <img src="{$user['avatar']}">
 </a>
 <textarea onkeydown="return topickeydownlistener(event)"  placeholder="写下你的评论..." class="comment-area"></textarea>
 <div class="write-function-block"> <div class="hint">Ctrl+Enter 发表</div>
 <a class="btn btn-send btn-cm-submit" name="comments" id="comments">发送</a> </div>
 </form>
   {else}
  <form class="new-comment"><a class="avatar"><img src="{$user['avatar']}"></a> <div class="sign-container"><a href="{url user/login}" class="btn btn-sign">登录</a> <span>后发表评论</span></div></form>

            {/if}

        </div>
        <div id="normal-comment-list" class="normal-comment-list">

        <div class="top">
        <span>{$commentrownum}条评论</span>


           </div>
           </div>
           <!----> <!---->
            <!--{if $commentlist==null}-->
            <div class="no-comment"></div>
  <center>      
           还没有人评论过~
         </center>
           

              <!--{/if}-->
          <!--{loop $commentlist $index $comment}-->
            <div id="comment-{$comment['id']}" class="comment">
            <div>
            <div class="author">
            <a href="{url user/space/$comment['authorid']}" target="_self" class="avatar">
            <img src="{$comment['avatar']}">
            </a>
            <div class="info">
            <a href="{url user/space/$comment['authorid']}" target="_self" class="name">
            {$comment['author']}
              {if $comment['author_has_vertify']!=false}<i class="fa fa-vimeo {if $comment['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  " data-toggle="tooltip" data-placement="right" title="" {if $comment['author_has_vertify'][0]=='0'}data-original-title="个人认证" {else}data-original-title="企业认证" {/if} ></i>{/if}
            </a>
            <!---->
             <div class="meta">
             <span>{eval echo ++$index;}楼 · {$comment['time']}</span>
             </div>
             </div>
             </div>
             <div class="comment-wrap">
             <p>
              {$comment['content']}
             </p>

                </div>
                </div>
                 <div class="tool-group">
             <a class="button_agree" id='{$comment['id']}'><i class="fa fa-thumbs-o-up"></i> <span>{$comment['supports']}人赞</span></a>

<a class="getcommentlist" dataid='{$comment['id']}' datatid="{$topicone['id']}"><i class="fa fa-comment"></i> <span>回复{$comment['comments']}</span></a>

                <!--{if 1==$user['grouptype'] ||$user['uid']==$comment['authorid']}-->

    <a data-placement="bottom" title="" data-toggle="tooltip" data-original-title="删除评论"   href="javascript:void(0);" onclick="deletewenzhang($comment['id'])"><i class="fa fa-bookmark-o"></i> <span>删除</span></a>
     <!--{/if}-->

                <!---->
                </div>
               <div class="sub-comment-list  hide" dataflag="0" id="articlecommentlist{$comment['id']}">
              <div class="commentlist{$comment['id']}">

              </div>
              <div class="sub-comment more-comment">
              <a class="add-comment-btn" dataid="{$comment['id']}"><i class="fa fa-edit"></i>
               <span>添加新评论</span></a>
               <!----> <!----> <!---->
               </div>
                <div class="formcomment{$comment['id']} hide">
                <form class="new-comment">
                <!---->
                <textarea placeholder="写下你的评论..." class="commenttext{$comment['id']}"></textarea>
                 <div class="write-function-block">


                  <a class="btn btn-send  btn-sendartcomment" id="btnsendcomment{$comment['id']}"  dataid="{$comment['id']}" datatid="{$topicone['id']}">发送</a>

                  </div>
                  </form>
                   <!---->
                   </div>
                   </div>
                </div>
 <!--{/loop}-->
  <div class="pages" >{$departstr}</div>
            
    
             </div>
            
    </div>


</div>



   </div>
   
</div>
</div>
  </div>

  
</div>
    
<!-- 举报 -->
<div class="modal fade panel-report" id="dialog_inform">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
      <h4 class="modal-title">举报内容</h4>
    </div>
    <div class="modal-body">

<form id="rp_form" class="rp_form"  action="{url inform/add}" method="post">
<input value="" type="hidden" name="qid" id="myqid">
<input value="" type="hidden" name="aid" id="myaid">
<input value="" type="hidden" name="qtitle" id="myqtitle">
<div class="js-group-type group group-2">
<h4>检举类型</h4><ul>
<li class="js-report-con">
<label><input type="radio" name="group-type" value="1"><span>检举内容</span></label>
</li>
<li class="js-report-user">
<label><input type="radio" name="group-type" value="2"><span>检举用户</span></label>
</li>
</ul>
</div>
<div class="group group-2">
<h4>检举原因</h4><div class="list">
<ul>
<li>
<label class="reason-btn"><input type="radio" name="type" value="4"><span>广告推广</span></label>
</li>
<li>
<label class="reason-btn"><input type="radio" name="type" value="5"><span>恶意灌水</span></label>
</li>
<li>
<label class="reason-btn"><input type="radio" name="type" value="6"><span>回答内容与提问无关</span>
</label>
</li>
<li>
<label class="copy-ans-btn"><input type="radio" name="type" value="7"><span>抄袭答案</span></label>
</li>
<li>
<label class="reason-btn"><input type="radio" name="type" value="8"><span>其他</span></label>
</li>
</ul>
</div>
</div>
<div class="group group-3">
<h4>检举说明(必填)</h4>
<div class="textarea">
<ul class="anslist" style="display:none;line-height:20px;overflow:auto;height:171px;">
</ul>
<textarea name="content" maxlength="200" placeholder="请输入描述200个字以内">
</textarea>
</div>
</div>
    <div class="mar-t-1">

                <button type="submit" id="btninform" class="btn btn-success">提交</button>
                 <button type="button" class="btn btn-default mar-ly-1" data-dismiss="modal">关闭</button>
      </div>
</form>


    </div>

  </div>
</div>
</div>
<div class="modal share-wechat animated" style="display: none;"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" data-dismiss="modal" class="close">×</button></div> <div class="modal-body"><h5>打开微信“扫一扫”，打开网页后点击屏幕右上角分享按钮</h5> <div data-url="{url topic/getone/$topicone['id']}" class="qrcode" title="{url topic/getone/$topicone['id']}"><canvas width="170" height="170" style="display: none;"></canvas>
<div id="qr_wxcode">
</div></div></div> <div class="modal-footer"></div></div></div></div>
<script type="text/javascript" src="{SITE_URL}static/ckplayer/ckplayer.js" charset="utf-8"></script>
<script type="text/javascript" src="{SITE_URL}static/ckplayer/video.js" charset="utf-8"></script>
<script>

$(".work-show-box").find("img").each(function(){
	var imgurl=$(this).attr("data-original");
	$(this).attr("src",imgurl);
})
$(".work-show-box").find("img").attr("data-toggle","lightbox");

$(".getcommentlist").each(function(){
	var _id=$(this).attr("dataid");
	var _tid=$(this).attr("datatid");
	$("#articlecommentlist"+_id).toggleClass("hide");
	var flag=$("#articlecommentlist"+_id).attr("dataflag");
	if(flag==1){
		flag=0;
	}else{
		flag=1;
		//加载评论
		loadarticlecommentlist(_id,_tid);
	}
	$("#articlecommentlist"+_id).attr("dataflag",flag);
	
})

function showeditor(){
	
	scrollTo(0,$('#comment-list').offset().top-100);
	$(".comment-area").focus();
	  }
//投诉
function openinform(qid ,qtitle,aid) {
	  $("#myqid").val(qid);
	  $("#myqtitle").val(qtitle);
	  $("#myaid").val(aid);
	 $('#dialog_inform').modal('show');

}






function deletewenzhang(current_aid){
	window.location.href=g_site_url + "index.php" + query + "topic/deletearticlecomment/"+current_aid+"/$topicone['id']";

}

$(function(){
    $(".edui-upload-video").attr("preload","");
		//微信二维码生成
		$('#qr_wxcode').qrcode("{url topic/getone/$topicone['id']}");
	     //显示微信二维码
	     $(".share-weixin").click(function(){
	    	 $(".share-wechat").show();
	     });
	     //关闭微信二维码
	     $(".close").click(function(){
	    	 $(".share-wechat").hide();
	     })
})
 $(".button_agree").click(function(){
             var supportobj = $(this);
                     var tid = $(this).attr("id");
                     $.ajax({
                     type: "GET",
                             url:"{SITE_URL}index.php?topic/ajaxhassupport/" + tid,
                             cache: false,
                             success: function(hassupport){
                             if (hassupport != '1'){






                                     $.ajax({
                                     type: "GET",
                                             cache:false,
                                             url: "{SITE_URL}index.php?topic/ajaxaddsupport/" + tid,
                                             success: function(comments) {

                                             supportobj.find("span").html(comments+"人赞");
                                             }
                                     });
                             }else{
                            	 alert("您已经赞过");
                             }
                             }
                     });
             });
</script>
<!--{template footer}-->