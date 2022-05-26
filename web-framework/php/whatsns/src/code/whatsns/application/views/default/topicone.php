<!--{template header}-->
  <!--{eval $adlist = $this->fromcache("adlist");}-->
<link rel="stylesheet" media="all" href="{SITE_URL}static/css/widescreen/css/greendetail.css?v1.1" />
<link rel="stylesheet" media="all" href="{SITE_URL}static/css/widescreen/css/widescreendetail.css?v1.1" />
   <script type="text/javascript" src="{SITE_URL}static/js/jquery.qrcode.min.js"></script>
     <link rel="stylesheet" type="text/css" href="{SITE_URL}static/js/poster/poster.css">
  <script type="text/javascript" src="{SITE_URL}static/js/poster/haibao.js"></script>
       <style>
.wangEditor-container, .wangEditor-container * {
    margin: inherit;
    padding: inherit;
    box-sizing: border-box;
    line-height: inherit;
    overflow:visible;
}
 .wangEditor-container .box_toukan {
	margin-left: 5px;
}
 </style>
<!-- cdn节点 获取顶部固定效果文章信息 -->
<div class="cdn_ajax_articletop"></div>

  
        <div class="content-wrap">
        <div class="work-details-wrap border-bottom">
                <div class="work-details-box-wrap container">
                    <div class="left-details-head col-md-16">
                                              <div class="works-tag-wrap">
                       
                      
                
                 <!--{if $taglist}-->
                                       <!--{loop $taglist $tag}-->

  <a href="{url tags/view/$tag['tagalias']}" title="{$tag['tagname']}" target="_blank" class="project-tag-14">{$tag['tagname']}</a>
                           
               
                <!--{/loop}--><!--{else}--><!--{/if}-->
                
                           
                        </div>
                        <div class="details-contitle-box">
                            <!--标题-->
                            <h2>{$topicone['title']}</h2>
                           
                            <!--发布时间-->
                            <p  class="title-time">
                                <span>{$topicone['viewtime']}</span>发布
                                     <span class="share-group">
        <a class="share-circle share-weixin" data-action="weixin-share" data-toggle="tooltip" data-original-title="分享到微信">
          <i class="fa fa-wechat"></i>
        </a>
        <a class="share-circle" data-toggle="tooltip" href="javascript:void((function(s,d,e,r,l,p,t,z,c){var%20f='http://v.t.sina.com.cn/share/share.php?appkey=1515056452',u=z||d.location,p=['&amp;url=',e(u),'&amp;title=',e(t||d.title),'&amp;source=',e(r),'&amp;sourceUrl=',e(l),'&amp;content=',c||'gb2312','&amp;pic=',e(p||'')].join('');function%20a(){if(!window.open([f,p].join(''),'mb',['toolbar=0,status=0,resizable=1,width=440,height=430,left=',(s.width-440)/2,',top=',(s.height-430)/2].join('')))u.href=[f,p].join('');};if(/Firefox/.test(navigator.userAgent))setTimeout(a,0);else%20a();})(screen,document,encodeURIComponent,'','','{$topicone['image']}', '推荐 {$topicone['author']} 的文章《{$topicone['title']}》','{url topic/getone/$topicone['id']}','页面编码gb2312|utf-8默认gb2312'));" data-original-title="分享到微博">
          <i class="fa fa-weibo"></i>
        </a>

         <a  class="share-circle" data-toggle="tooltip"  target="_self" data-original-title="分享到qq" href="javascript:shareqq()"   title="分享到QQ"><i class="fa fa-qq"></i></a>

 <a  class="" data-toggle="tooltip"  target="_self" data-original-title="生成海报" href="javascript:showposter('{SITE_URL}',$topicone['id'],'article')"   title="生成海报" style="margin-left: 10px;font-size:12px;"><span class=""><i style="margin-right: 5px;font-size:18px;position:relative;top:3px;" class="fa fa-share-alt"></i></span>生成海报</a>

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

      </span>
                            </p>
                            <!--分类,浏览数,评论数,推荐数-->
                            <div class="work-head-box">
                                <div class="head-left">
                                            <span class="head-index">
                                                <span><a href="{url topic/default}" target="_blank">站内文章</a></span>
                                                <i>/</i>
                                                <span><a href="{eval echo getcaturl($cat_model['id'],'topic/catlist/#id#');}" target="_blank">{$cat_model['name']}</a></span>
                                               
                                            </span>
                              
                                </div>
                                <div class="head-right">
                                            <span class="head-data-show">
                                            <a href="javascript:;" title="共{$topicone['views']}人气" class="see vertical-line">
                                                <i></i>{$topicone['views']}
                                            </a>
                                            <a href="javascript:;" title="共{$topicone['articles']}评论" class="news vertical-line">
                                                <i></i>{$topicone['articles']}
                                            </a>
                                            <a href="javascript:;" title="共{$topicone['likes']}收藏" class="recommend-show">
                                                <i></i>{$topicone['likes']}
                                            </a>
                                            </span>
                                           <!-- ajax节点 判断操作权限 -->
                                           <span class="cdn_ajax_articlecaozuo"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    



                  <!-- cdn节点 获取文章发布者信息 -->
                   <div class="cdn_ajax_userinfo"></div>
                </div>
                
                 <div class="container ">
      
                 <div class="content-wrap">
  
   <div class="details-con-other border-top"  {if !$topicone['describtion']} style="margin-top:0px;"  {/if}>
                <div class="">
                   
             
                         <div class="three-link">
                      
                            <!-- cdn节点-- 获取当前文章可收藏和评论状态 -->
                            <span class="cdn_ajax_articlefavoriteandcommentbtn"></span>
                     
                    </div>
                    
                
                </div>
            </div>
   
   </div>
                </div>
                
            </div>
            <div class="container">
        
            <div class=" row">
                   <div class="col-md-17 bb" style="margin-top:20px;">
                <div class="work-details-content" >
    
<div class=" ">
    <div class="">

        <div class="work-show-box" style="margin-top:0px;  padding:10px">
            
                     {if $topicone['price']!=0&&$haspayprice==0&&$user['uid']!=$topicone['authorid']}
  {eval echo replacewords($topicone['freeconent']);}
  
                         <div class="box_toukan ">

										{if $user['uid']==0}
											<div onclick="login()" class="thiefbox font-12" style="color:#fff;text-decoration:none;" ><i class="icon icon-lock font-12"></i> &nbsp;更多阅读需支付&nbsp;$topicone['price']&nbsp;&nbsp;{eval if ($topicone['readmode']==2) echo '财富值'; }{eval if ($topicone['readmode']==3) echo '元'; }……</div>
											{else}
											<div onclick="viewtopic($topicone['id'])"  class="thiefbox font-12" style="color:#fff;text-decoration:none;" ><i class="icon icon-lock font-12"></i> &nbsp;更多阅读需支付&nbsp;$topicone['price']&nbsp;&nbsp;{eval if ($topicone['readmode']==2) echo '财富值'; }{eval if ($topicone['readmode']==3) echo '元'; }……</div>
											{/if}


										</div>
                   {else}
                   {eval echo  replacewords($topicone['describtion']);}
           
              
                    {/if}





        </div>
                 {if $setting['openwxpay']==1}
<div class="support-author"> <div class="btn-shangta" data-toggle="tooltip" data-placement="top" title="" data-original-title="一共获得了{$totalmoney}元" onclick="wxpay('tid',{$topicone['id']},{$topicone['authorid']} );">赞赏支持</div>
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
    </div>
</div>

                



            </div>
      <hr>
         <div class="index">
<div class="row">
   <div class=" main" style="padding:10px">
   <div class="note">
    <div class="post">
       

       <!-- cdn节点 文章评论 -->
      <div class="cdn_ajax_articlecomment"></div>
 

            
    </div>


</div>



   </div>
   
</div>
</div>
                  </div>
                         <div class="col-md-7 aside">
                         
     <div class="standing" style="margin-top: 20px;">
  <div class="positions bb" id="rankScroll">
      <h3 class="title">Ta的文章  <a target="_blank" href="{url topic/userxinzhi/$member['uid']}" class="more">更多<font> &gt;&gt; </font></a></h3>
       {if  $topiclist1}
      <ul>
      


      <!--{loop $topiclist1 $index $topic}-->
              <li class="no-video">
        <a href="{url topic/getone/$topic['id']}" title="{$topic['title']}" >  {$topic['title']}</a>
               <div class="num-ask">
               <a href="{url topic/getone/$topic['id']}" title="{$topic['title']}" class="anum"> {$topic['articles']} 个评论</a>
               </div>
              </li>
                <!--{/loop}-->
               

              </ul>
                {/if}
  </div>
  </div>

  
  <!--{template sider_hotarticle}-->
  
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
getarticlecaozuo(1,{$topicone['id']});//文章详情页面--操作菜单
getarticlecaozuo(2,{$topicone['id']});//文章详情页面--可收藏和可评论和可举报按钮状态
getarticlecaozuo(3,{$topicone['id']});//文章详情页面--评论+评论框
getarticlecaozuo(4,{$topicone['id']}); //文章详情页面--发布文章作者信息
getarticlecaozuo(5,{$topicone['id']});//文章详情页面--文章详情顶部固定文章信息提示
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

</script>
<!--{template footer}-->