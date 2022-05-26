<!--{template header}-->
  <!--{eval $adlist = $this->fromcache("adlist");}-->
<link rel="stylesheet" media="all" href="{SITE_URL}static/css/widescreen/css/greendetail.css?v1.1" />
<link rel="stylesheet" media="all" href="{SITE_URL}static/css/widescreen/css/widescreendetail.css" />
   <script type="text/javascript" src="{SITE_URL}static/js/jquery.qrcode.min.js"></script>
   
   {if (isset($adlist['common']['left1'])&& trim($adlist['common']['left1']))}
  
   
     <div class="advlong-bottom">
            <div class="advlong-default">
                   <!--广告位1-->
           
           {$adlist['common']['left1']}
           
            </div>
        </div>
         {/if}
        <div class="content-wrap">
         <div class="work-details-wrap border-bottom">
                  <div class="work-details-box-wrap container">
                    <div class="left-details-head col-md-16">
                        
                        <div class="details-contitle-box ">
                            <!--标题-->
                            <h2>{$note['title']}</h2>
                           
                            <!--发布时间-->
                            <p  class="title-time">
                                <span>{$note['format_time']}</span>发布
                <span class="share-group">
        <a class="share-circle share-weixin" data-action="weixin-share" data-toggle="tooltip" data-original-title="分享到微信">
          <i class="fa fa-wechat"></i>
        </a>
        <a class="share-circle" data-toggle="tooltip" href="javascript:void((function(s,d,e,r,l,p,t,z,c){var%20f='http://v.t.sina.com.cn/share/share.php?appkey=1881139527',u=z||d.location,p=['&amp;url=',e(u),'&amp;title=',e(t||d.title),'&amp;source=',e(r),'&amp;sourceUrl=',e(l),'&amp;content=',c||'gb2312','&amp;pic=',e(p||'')].join('');function%20a(){if(!window.open([f,p].join(''),'mb',['toolbar=0,status=0,resizable=1,width=440,height=430,left=',(s.width-440)/2,',top=',(s.height-430)/2].join('')))u.href=[f,p].join('');};if(/Firefox/.test(navigator.userAgent))setTimeout(a,0);else%20a();})(screen,document,encodeURIComponent,'','','', '推荐 {$note['author']} 的文章《{$note['title']}》','{url note/view/$note['id']}','页面编码gb2312|utf-8默认gb2312'));" data-original-title="分享到微博">
          <i class="fa fa-weibo"></i>
        </a>




  <script type="text/javascript">document.write(['<a class="share-circle" data-toggle="tooltip"  target="_self" data-original-title="分享到qq空间" href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=',encodeURIComponent(location.href),'&title=',encodeURIComponent(document.title),'" target="_self"   title="分享到QQ空间"> <i class="fa fa-qq"></i><\/a>'].join(''));</script>

      </span>
                            </p>
                            <!--分类,浏览数,评论数,推荐数-->
                            <div class="work-head-box">
                                <div class="head-left">
                                            <span class="head-index">
                                                <span><a href="{url note/list}" target="_blank">站内公告</a></span>
                                                
                                            </span>
                              
                                </div>
                                <div class="head-right">
                                            <span class="head-data-show">
                                            <a href="javascript:;" title="共{$note['views']}人气" class="see vertical-line">
                                                <i></i>{$note['views']}
                                            </a>
                                            <a href="javascript:;" title="共{$note['comments']}评论" class="news vertical-line">
                                                <i></i>{$note['comments']}
                                            </a>
                                         
                                            </span>
                                              <!--{if $user['grouptype']==1}-->
                <!-- 如果是当前作者，加入编辑按钮 -->
                <a href="javascript:void(0)"  data-toggle="dropdown" class="edit dropdown-toggle">操作 <i class="fa fa-angle-down mar-lr-05"></i> </a>
                 <ul class="dropdown-menu" role="menu">
             
                  
                        <li>


                    <a href="{url topicdata/pushindex/$note['id']/note}" data-toggle="tooltip" data-html="true" data-original-title="被顶置的公告将会在首页列表展示">
                    <span>首页顶置</span>
                    </a>
                      </li>
                
                           <li>

                    <a href="{url admin_note/edit/$note['id']}">
                      <span>编辑公告</span>
                    </a>
                      </li>
                      

                             </ul>
                               <!--{/if}-->
                                </div>
                            </div>
                        </div>
                    </div>
                    




<div class="top-author-card follow-box col-md-8">
    <div class="card-designer-list-details details-right-author-wrap card-media">

        <input type="hidden" name="creator" value="14876008">
        <div class="avatar-container-80">
            <a href="{url user/space/$note['authorid']}" title="{$note['author']}" class="avatar" >
                <img src="{$note['avatar']}" width="80" height="80" alt="">
            </a>
            
        </div>
        <div class="author-info">
            <p class="author-info-title">
           
             
                <a href="{url user/space/$member['uid']}" title="{$topicone['author']}" class="title-content">
               {$note['author']}
                  {if $note['author_has_vertify']!=false}<i class="fa fa-vimeo {if $note['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  " data-toggle="tooltip" data-placement="right" title="" {if $note['author_has_vertify'][0]=='0'}data-original-title="个人认证" {else}data-original-title="企业认证" {/if} ></i>{/if}
                </a>





            </p>
           <div class="position-info">
                <span>{if $note['user']['gender']==0}女{/if}{if $note['user']['gender']==1}男{/if}&nbsp;|&nbsp;{$note['user']['groupname']}</span>
            </div>
            <div class="btn-area">
                
      
                
                        <div class="js-project-focus-btn">
                                   <!-- 关注用户按钮 -->
                 {if  $is_followedauthor}
                                <input type="button" title="已关注" id="attenttouser_{$note['authorid']}" onclick="attentto_user($note['authorid'])" class="btn-current attention btn-default-secondary following" value="已关注" >
                              {else}
                               <input type="button" title="添加关注" id="attenttouser_{$note['authorid']}" onclick="attentto_user($note['authorid'])" class="btn-current attention btn-default-main notfollow" value="关注">
                                {/if}
                        </div>
                        <a href="{url message/sendmessage/$note['authorid']}" title="发私信" class="btn-default-secondary btn-current private-letter">私信</a>
                    
            </div>
               
        </div>
    </div>
</div>

                </div>
            </div>
            <div class="container">
               <div class="row">
                  <div class="col-md-17 bb" style="margin-top:20px;">
                  <div class="work-content-wrap ">
    <div class="work-center-con">

        <div class="work-show-box">
              {$note['content']}




        </div>
    </div>
</div>
 <div class=" index">
<div class="row">
   <div class=" main" style="padding:10px">
   <div class="note">
    <div class="post">
        

        <div>
        <div id="comment-list" class="comment-list">
        <div>
 <form class="new-comment" name="commentForm" action="{url note/addcomment}" method="post">
       <input type="hidden" value="{$note['id']}" name="noteid">
 <a class="avatar">
 <img src="{$user['avatar']}">
 </a>
 <textarea placeholder="写下你的评论..." oninput="listertext()" onpropertychange="listertext()" class="comment-area" id="content" name="content"></textarea>

<div class="write-function-block">
<div class="hint">请勿在公告评论里发布广告，否则拉黑账号</div>
 <input type="submit" name="submit" id="submit" class="btn btn-send btn-cm-submit" value="发送" data-loading="稍候...">


  </div>
   <div class="write-function-block code_hint">
 {template code}
 </div>
 </form>



          </div>
        <div id="normal-comment-list" class="normal-comment-list clearfix">
        <div>
        <div>
        <div class="top">
        <span>{$note['comments']}条评论</span>

       
           </div>
           </div>
           <!----> <!---->
            <!--{if $commentlist==null}-->
            <div class="no-comment"></div>
            <div class="text">
        <center>    还没有人评论过~</center>
          </div>
              <!--{/if}-->
          <!--{loop $commentlist $index $comment}-->
            <div id="comment-{$comment['id']}" class="comment">
            <div>
            <div class="author">
            <a href="{url user/space/$comment['authorid']}" target="_self" class="avatar">
            <img src="{$comment['avatar']}">
            </a>
            <div class="info">
            <a href="{url user/space/$comment['authorid']}" target="_self" class="name">{$comment['author']}</a>
            <!---->
             <div class="meta">
             <span>{eval echo ++$index}楼 · {$comment['format_time']}</span>
             </div>
             </div>
             </div>
             <div class="comment-wrap">
             <p>
              {$comment['content']}
             </p>

                </div>
                </div>
                <div class="sub-comment-list hide"><!----> <!----></div>
                </div>
 <!--{/loop}-->
  <div class="pages" >{$departstr}</div>
         
             </div>
             </div>
              <!----> <!---->
              </div>
              </div>

    </div>


</div>
  </div>

</div>
</div>

                  </div>
                       <div class="col-md-7 aside">
                    <!--{template sider_note}-->
                  </div>
               </div>
            </div>
            
        </div>
         
   

<div class="modal share-wechat animated" style="display: none;"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" data-dismiss="modal" class="close">×</button></div> <div class="modal-body"><h5>打开微信“扫一扫”，打开网页后点击屏幕右上角分享按钮</h5> <div data-url="{url note/view/$note['id']}" class="qrcode" title="{url note/view/$note['id']}"><canvas width="170" height="170" style="display: none;"></canvas>
<div id="qr_wxcode">
</div></div></div> <div class="modal-footer"></div></div></div></div>
<script type="text/javascript" src="{SITE_URL}static/ckplayer/ckplayer.js" charset="utf-8"></script>
<script type="text/javascript" src="{SITE_URL}static/ckplayer/video.js" charset="utf-8"></script>
<script>
var g_id = {$user['groupid']};
function listertext(){
	 var _content=$("#content").val();
	 if(_content.length>0&&g_id!=1){

		 $(".code_hint").show();
	 }else{
		 $(".code_hint").hide();
	 }
}
if(typeof($(".work-show-box").find("img").attr("data-original"))!="undefined"){
	var imgurl=$(".work-show-box").find("img").attr("data-original");
	$(".work-show-box").find("img").attr("src",imgurl);
}
$(".work-show-box").find("img").attr("data-toggle","lightbox");
$(".work-show-box").find("img").attr("class","img-thumbnail").css({"display":"block","margin-top":"3px"});
$(function(){

		//微信二维码生成
		$('#qr_wxcode').qrcode("{url note/view/$note['id']}");
	     //显示微信二维码
	     $(".share-weixin").click(function(){
	    	 $(".share-wechat").show();
	     });
	     //关闭微信二维码
	     $(".close").click(function(){
	    	 $(".share-wechat").hide();
	     })

})
</script>
<!--{template footer}-->