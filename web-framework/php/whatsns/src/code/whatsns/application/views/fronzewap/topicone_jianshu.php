<!--{template header}-->
{eval $hidefooter=true;}

<script>

var _topictitle="{$topicone['title']}";

{eval $indexx=strstr($topicone['image'],'http');}

{if $indexx }
     var imgurl="{$topicone['image']}";

     {else}
     var imgurl="{SITE_URL}{$topicone['image']}";


     {/if}
    	 {eval $miaosu=strip_tags(replacewords(html_entity_decode($topicone['describtion'])));}
    	 {eval $miaosu=cutstr(str_replace('&nbsp;','',$miaosu),200,'...');}
    	 {eval $miaosu=str_replace('"', '', $miaosu);}
    	 {eval $miaosu=str_replace('“', '', $miaosu);}
    	 {eval $miaosu=str_replace('”', '', $miaosu);}
    	 {eval   $qian=array(" ","　","\t","\n","\r");$miaosu=str_replace($qian, '', $miaosu);}

var topicdescription="{$miaosu}";
var topiclink="{url topic/getone/$topicone['id']}";

</script>
<section class="ui-container " style="background:#fff;">
        <div class="works-tag-wrap">
                       


                              
                       <!--{if $topicone['tags']}-->
                                       <!--{loop $topicone['tags'] $tag}-->

  <a href="{url tags/view/$tag['tagalias']}" title="{$tag['tagname']}" class="project-tag-14">{$tag['tagname']}</a>
                           
               
                <!--{/loop}--><!--{else}--><!--{/if}-->
                
                           
                        </div>
<article class="article">
    <h1 class="title">{$topicone['title']}</h1>

    <div class="article-info ui-clear">

            <ul class="ui-row">

                <li class="ui-col ui-col-75">

    <a href="{url user/space/{$topicone['authorid']}}">
                     <span class="ui-avatar-s">

                         <span style="background-image:url({$member['avatar']})"></span>

                     </span>
  </a>
                    <span class=" u-name">
                    <a class="ui-txt-highlight" href="{url user/space/{$topicone['authorid']}}">
                   {$topicone['author']}
                    {if $topicone['author_has_vertify']!=false}<i style="top:0px;font-size:15px;" class="fa fa-vimeo {if $topicone['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  " data-toggle="tooltip" data-placement="right" title="" {if $topicone['author_has_vertify'][0]=='0'}data-original-title="个人认证" {else}data-original-title="企业认证" {/if} ></i>{/if}
                  </a>
                    </span>

  <!-- 关注用户按钮 -->
                             {if  $is_followedauthor}

  <a class="btn btn-default following button_followed" id="attenttouser_{$member['uid']}" onclick="attentto_user($member['uid'])"><i class="fa fa-check"></i><span>已关注</span></a>

  {else}

         <a class="btn btn-success follow button_attention" id="attenttouser_{$member['uid']}" onclick="attentto_user($member['uid'])"><i class="fa fa-plus"></i><span>关注</span></a>

  {/if}
                </li>


            </ul>

 <span class="ui-nowrap  " style="margin-top:1rem"> 发布时间:{$topicone['viewtime']}</span>

    <!--{if $user['grouptype']==1||$user['uid']==$topicone['authorid']}-->
 <span class="ui-nowrap  " onclick="show_questionoprate()"  style="margin-top:.8rem;margin-left:5px;font-size:12px;"><i class="fa fa-gear " style="font-size:14px;position;relative;top:1px;margin:0 2px;"></i>管理</span>
  <!--{/if}-->
        </div>
    <div class="article-content art-content">




                {if $topicone['price']!=0&&$haspayprice==0&&$user['uid']!=$topicone['authorid']}

                     {eval echo replacewords($topicone['freeconent']);}
  
                         <div class="box_toukan ">

										{if $user['uid']==0}
											<a onclick="login()" class="thiefbox font-12" style="color:#fff;text-decoration:none;" ><i class="icon icon-lock font-12"></i> &nbsp;更多阅读需支付&nbsp;$topicone['price']&nbsp;&nbsp;{eval if ($topicone['readmode']==2) echo '财富值'; }{eval if ($topicone['readmode']==3) echo '元'; }……</a>
											{else}
											<a onclick="viewtopic($topicone['price'],$topicone['id'])"  class="thiefbox font-12" style="color:#fff;text-decoration:none;" ><i class="icon icon-lock font-12"></i> &nbsp;更多阅读需支付&nbsp;$topicone['price']&nbsp;&nbsp;{eval if ($topicone['readmode']==2) echo '财富值'; }{eval if ($topicone['readmode']==3) echo '元'; }……</a>
											{/if}


										</div>
                   {else}
                    <p>
                 {eval echo  replacewords(html_entity_decode($topicone['describtion']));}
                </p>
                    {/if}

            <div class="c_btns">
              <!--{if $isfollowarticle}-->
              <a href="{url favorite/delfavoratearticle/$topicone['id']}">     <div class="btnhassoucang">
               已收藏文章
               </div></a>
              
          
                  <!--{else}-->
                    <a href="{url favorite/topicadd/$topicone['id']}">      <div class="btnsoucang">
               收藏文章
               </div></a>
                   
                   <!--{/if}-->
                   {if 9!=$question['status']}
                   {if $user['uid']==0}
                  <div class="btnwirteans" onclick="window.location.href='{url user/login}'">
                                                                写评论
               </div>
               {else}
                   <div class="btnwirteans" >
               写评论
               </div>
               {/if}
                 {/if}
            </div>
  <div class="show-foot">
            {if $topicone['articleclassid']}<p>本文章来自话题:<a href="{url cat-$cat_model['id']}" >{$cat_model['name']}</a>

             <a class="reportques" onclick="openinform(0,'{$topicone['title']}',{$topicone['id']})"  id="report-modal">举报文章</a>
             </p>{/if}
                       
             
            </div>
       
    </div>

      {if $setting['openwxpay']==1}
    <footer><center>

     <label onclick="mobilebestcallpay({$topicone['id']},$topicone['authorid'],{$setting['mobile_shang']})" class="ui-label-s" style="background:#ff7f0d;color:#ffffff;font-size:15px;height:25px;line-height:25px; padding:4px;margin-bottom:10px;margin-top:15px;width:80px;font-wight:700;">赏TA</label>
     <!--打赏列表-->
     {if  $shanglist}
   <div class="supporter">
   <ul class="support-list">
       <!--{loop $shanglist  $shang}-->
   <li>
   <a  href="{$shang['url']}" class="avatar"  data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{$shang['operation']}">
   <img src="{$shang['avatar']}" style="width:25px;height:25px;border:solid 1px #fff">
   </a>
   </li>
    <!--{/loop}-->
   </ul> </div>
   {/if}
    </center>

    </footer>
       {/if}
 
</article>
 <section class="article-jingxuan ui-panel" style="overflow: visible;clear: both;">
        <h2 class="ui-txt-warning"  style="overflow: visible;">相关推荐</h2>
       <div class="split-line"></div>
<div id="list-container" style="padding:0px;margin:0px;">
    <!-- 文章列表模块 -->

  <div class="whatsns_list" style="background:#F6F6F6">
     <!--{loop $ctopiclist $index $topic}-->   

{if $topic['id']!=$tid && $index<4}
                       
                        <div class="whatsns_listitem">
         <div class="l_title"><h2 style="padding-left: 0px;"><a href="{url topic/getone/$topic['id']}">
      {$topic['title']}</a></h2></div>

       <div class="whatsns_content">
  
 
   {if $topic['image']}
<div class="weui-flex">



   <div class="weui-flex__item"><div class="imgthumbbig"><a href="{url topic/getone/$topic['id']}"><img class="lazy" src="{SITE_URL}static/images/lazy.jpg" data-original="$topic['image']"></a></div></div>



</div>
 {/if}
 
 
         {if $topic['describtion']}
 <div class="whatsns_des">
 <span class="mtext" >{$topic['describtion']}</span>
 <div class="whatsns_readmore" onclick="window.location='{url topic/getone/$topic['id']}'">查看更多<i class="fa fa-angle-down"></i></div>
 </div>
  {/if}
       </div>
<div class="ask-bottom">
   
          <a href="{url topic/getone/$topic['id']}" class="" ><i class="fa fa-commentingicon"></i>{$topic['articles']} 个评论</a>
          <a href="{url topic/getone/$topic['id']}"  class=" "><i class="fa fa-qshoucang"></i>{$topic['likes']}个收藏</a>
               </div>
              </div>
              {/if}
                          <!--{/loop}-->    
  
</div>




 
    </div>
    </section>
  {if $user['uid']!=0}
  <div class="postarticleform">
  <input type="hidden" id="artitle" value="{$topicone['title']}" />
    <input type="hidden" id="artid" value="{$topicone['id']}" />
<textarea  placeholder="写下你的评论..." class="comment-area"></textarea>
</div>
<div class="btnpostarticle">
<button class="ui-btn ui-btn-danger btn-cm-submit">评论</button>
</div>

   {else}
    <div class="ui-btn-wrap">
    <button onclick="window.location.href='{url user/login}'" class="ui-btn-lg ui-btn-danger">
        登录发布评论
    </button>
</div>
    {/if}
    
    
<!-- 发布评论 -->

   <!--{if $commentlist}-->
    <section class="answerlist comment-list">
     <div class="ans-title">
         <span>全部评论</span>
     </div>
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
  
    </section>
      <!--{/if}-->
   
    <div class="ui-dialog" id="dialogdashang">
    <div class="ui-dialog-cnt">
      <header class="ui-dialog-hd ui-border-b">
                  <h3 style="color: #ff7f0d;">打赏</h3>
                  <i style="color: #ff7f0d;" class="ui-dialog-close" data-role="button"></i>
              </header>

        <div class="ui-dialog-bd">
      <div class="ui-label-list">
    <label class="ui-label" val="1" style="border: 1px solid #ff7f0d;color: #ff7f0d;">1元</label>
    <label class="ui-label" val="5" style="border: 1px solid #ff7f0d;color: #ff7f0d;">5元</label>
    <label class="ui-label" val="10" style="border: 1px solid #ff7f0d;color: #ff7f0d;">10元</label>


</div>
          <input type="number" id="text_shangjin" value="{$setting['mobile_shang']}" style="text-align:center;border:none;outline:none;background:transparent;border-bottom:solid 1px #ff7f0d;width:100px;font-size:28px;margin:0 auto;color:#ff7f0d;">
                         <span style="font-size:28px;color:#ff7f0d;position:relative;top:2px;">元</span>


 <div style="display:block;margin:5px auto;">
 </div>
    <button  id="btndashang"  class="ui-btn ui-btn-danger ">
                               打&nbsp;赏
    </button>


        </div>


    </div>
</div>
<!-- 举报 -->
<div class="modal fade panel-report" id="dialog_inform">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" onclick="hidemodel()" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
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

                <button type="submit" id="btninform" class="btn btn-success ">提交</button>
                 <button type="button" class="btn btn-default mar-lr-1" data-dismiss="modal" onclick="hidemodel()">关闭</button>
      </div>
</form>


    </div>

  </div>
</div>
</div>
   <!--{if $user['grouptype']==1||$user['uid']==$topicone['authorid']}-->
<!-- 提问操作 -->
<div class="ui-actionsheet wenticaozuo">
  <div class="ui-actionsheet-cnt">
    <h4>问题操作</h4>


           <button onclick="bianjiwenzhang()">编辑文章</button>

          <button class="ui-actionsheet-del" id="delete_wenzhang">删除</button>

    <button class="cancelpop">取消</button>
  </div>
</div>
  <!--{/if}-->


{if $signPackage!=null}

<script src="https://res.wx.qq.com/open/js/jweixin-1.4.0.js"> </script>

<script>

  wx.config({
      debug: false,
      appId: '{$signPackage["appId"]}',
      timestamp: {$signPackage["timestamp"]},
      nonceStr: '{$signPackage["nonceStr"]}',
      signature: '{$signPackage["signature"]}',
      jsApiList: [
                  'checkJsApi',
                  'onMenuShareWeibo',
                  'onMenuShareTimeline',
                  'onMenuShareAppMessage',
                  'onMenuShareQQ',
                  'onMenuShareQZone',
                  'updateAppMessageShareData',
                  'updateTimelineShareData',
        'hideMenuItems'

      ]
  });

</script>

<script>



wx.ready(function () {
    wx.checkJsApi({
	      jsApiList: [

	          'onMenuShareWeibo',
              'onMenuShareTimeline',
              'onMenuShareAppMessage',
              'onMenuShareQQ',
              'onMenuShareQZone',
              'updateAppMessageShareData',
              'updateTimelineShareData'
	      ],
	      success: function (res) {
		   
	        //alert(JSON.stringify(res));
	      }
	    });
    wx.hideMenuItems({
	    menuList: ['menuItem:copyUrl','menuItem:openWithQQBrowser','menuItem:openWithSafari','menuItem:originPage','menuItem:share:email']
	});
    wx.updateAppMessageShareData({
	      title:_topictitle ,
	      desc:topicdescription ,
	      link:topiclink,
	      imgUrl: imgurl,
	      trigger: function (res) {
	      //  alert('用户点击发送给朋友');
	      },
	      success: function (res) {
	 
	       // alert('已分享');
	      },
	      cancel: function (res) {
	   
	      // alert('已取消');
	      },
	      fail: function (res) {
	       //alert(JSON.stringify(res));
	      }
	    });
    wx.onMenuShareAppMessage({
	      title:_topictitle ,
	      desc:topicdescription ,
	      link:topiclink,
	      imgUrl: imgurl,
	      trigger: function (res) {
	      //  alert('用户点击发送给朋友');
	      },
	      success: function (res) {
	    	  el2=$.tips({
   	            content:'已分享',
   	            stayTime:1000,
   	            type:"info"
   	        });
	       // alert('已分享');
	      },
	      cancel: function (res) {
	    	  el2=$.tips({
	   	            content:'取消分享',
	   	            stayTime:1000,
	   	            type:"info"
	   	        });
	       // alert('已取消');
	      },
	      fail: function (res) {
	       // alert(JSON.stringify(res));
	      }
	    });
    wx.updateTimelineShareData({
	      title:_topictitle,
	      link:topiclink,
	      imgUrl: imgurl,
	      trigger: function (res) {
	       // alert('用户点击分享到朋友圈');
	      },
	      success: function (res) {
	    
	      //  alert('已分享');
	      },
	      cancel: function (res) {
	   
	      //  alert('已取消');
	      },
	      fail: function (res) {
	       // alert(JSON.stringify(res));
	      }
	    });
    wx.onMenuShareTimeline({
	      title:_topictitle,
	      link:topiclink,
	      imgUrl: imgurl,
	      trigger: function (res) {
	       // alert('用户点击分享到朋友圈');
	      },
	      success: function (res) {
	    	  el2=$.tips({
	   	            content:'已分享',
	   	            stayTime:1000,
	   	            type:"success"
	   	        });
	      //  alert('已分享');
	      },
	      cancel: function (res) {
	    	  el2=$.tips({
	   	            content:'取消分享',
	   	            stayTime:1000,
	   	            type:"info"
	   	        });
	      //  alert('已取消');
	      },
	      fail: function (res) {
	       // alert(JSON.stringify(res));
	      }
	    });
    wx.onMenuShareQZone({
   	      title: _topictitle,
	      desc:'来自微信分享' ,
	      link:topiclink,
	      imgUrl: imgurl,
	      trigger: function (res) {
		       // alert('用户点击分享到朋友圈');
		      },
		      success: function (res) {
		    	  el2=$.tips({
		   	            content:'已分享',
		   	            stayTime:1000,
		   	            type:"success"
		   	        });
		      //  alert('已分享');
		      },
		      cancel: function (res) {
		    	  el2=$.tips({
		   	            content:'取消分享',
		   	            stayTime:1000,
		   	            type:"info"
		   	        });
		      //  alert('已取消');
		      },
		      fail: function (res) {
		       // alert(JSON.stringify(res));
		      }
   });
    wx.onMenuShareQQ({
	      title: _topictitle,
	      desc:'来自微信分享' ,
	      link:topiclink,
	      imgUrl: imgurl,
	      trigger: function (res) {
	       // alert('用户点击分享到QQ');
	      },
	      complete: function (res) {
	      //  alert(JSON.stringify(res));
	      },
	      success: function (res) {
	       // alert('已分享');
	      },
	      cancel: function (res) {
	    	   el2=$.tips({
	  	            content:'取消分享',
	  	            stayTime:1000,
	  	            type:"info"
	  	        });
	      //  alert('已取消');
	      },
	      fail: function (res) {
	       // alert(JSON.stringify(res));
	      }
	    });

    wx.onMenuShareWeibo({
    	 title:_topictitle,
    	 desc:'来自微信分享' ,
	      link:topiclink,
	      imgUrl: imgurl,
	      trigger: function (res) {
	       // alert('用户点击分享到微博');
	      },
	      complete: function (res) {
	       // alert(JSON.stringify(res));
	      },
	      success: function (res) {
	       // alert('已分享');
	      },
	      cancel: function (res) {
	       // alert('已取消');
	      },
	      fail: function (res) {
	      //  alert(JSON.stringify(res));
	      }
	    });
});
</script>
{/if}

<script>
function addarticlecomment(_tid,_aid,_comment,_touid){
	var data={
			tid:_tid,
			aid:_aid,
			content:_comment,
			touid:_touid
	}
	var url=g_site_url+"index.php?topic/ajaxaddarticlecomment.html";
	function success(result){
		alert(result.msg)
		if(result.code==200){
			$(".commenttext"+_aid).val("");
			loadarticlecommentlist(_aid,_tid);
		}
	}
	ajaxpost(url,data,success);
}
function loadarticlecommentlist(_id,_tid){
	var data={
			tid:_tid,
			aid:_id
			
	}
	var url=g_site_url+"index.php?topic/ajaxgetcommentlist.html";
	function success(result){
		if(result.code=200){
			$(".commentlist"+_id).html("");
			var json=JSON.parse(result.msg);
			console.log(json.length)

			 for(var i=0,l=json.length;i<l;i++){
				 
				    console.log(json[i]['content'])
			       
				    var conli = '<div id="comment-'+json[i]['id']+'" class="sub-comment">'+
		             '<p>'+
		              '<div data-v-f3bf5228="" class="v-tooltip-container" style="z-index: 0;">'+
		              '<div class="v-tooltip-content">'+
		              '<a href="'+json[i]['userhomelink']+'" target="_blank">'+json[i]['author']+'</a>：'+
		           '</div></div> <span>' 
		        
		           + json[i]['content']+
		            
		             '</span> </p><div class="sub-tool-group"><span>'+ json[i]['time']+ 
		            
		             '</span> <a class=""><i class="fa fa-comment"></i> <span author="'+ json[i]['author']+'"authorid="'+ json[i]['authorid']+'" class="huifu">回复</span></a><a class="subcomment-delete">'
		             
		             +json[i]['deltag']+
		             ' </a> </div></div>';

				    $(".commentlist"+_id).append(conli);
			    
			 }
			//回复
			$(".commentlist"+_id).find(".huifu").click(function(){
				var _authorid=$(this).attr("authorid");
				var _author=$(this).attr("author");
				$(".commenttext"+_id).val("");
				$(".commenttext"+_id).attr("placeholder","@"+_author+" ");
				$(".formcomment"+_id).toggleClass("hide");
				$(".commenttext"+_id).focus();
				$("#btnsendcomment"+_id).attr("touid",_authorid);
			});
			$(".commentlist"+_id).find(".deltag").click(function(){
				var _cid=$(this).attr("dataid");
				var data={
						id:_cid
				}
				function mysuccess(result){
					if(result.code==200){
						$(".commentlist"+_id).find("#comment-"+_cid).remove();
					}else{
						alert(result.msg)
					}
				}
				var _url=g_site_url+"index.php?topic/ajaxdelartcomment.html";
				   ajaxpost(_url,data,mysuccess);
			})
			 
		}else{
			alert(result.msg)
		}
	}
	ajaxpost(url,data,success);
}
$(".btn-sendartcomment").click(function(){
	var _aid=$(this).attr("dataid");
	var _tid=$(this).attr("datatid");
	var _content=$.trim($(".commenttext"+_aid).val());
	if(_content==''){
		alert("评论内容不能为空");
		return false;
	}
	var touid=$("#btnsendcomment"+_aid).attr("touid");
	if(touid==null){
		touid=0;
	}
	addarticlecomment(_tid,_aid,_content,touid);
})
$(".getcommentlist").click(function(){
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
$(".add-comment-btn").click(function(){
	var _id=$(this).attr("dataid");
	$(".formcomment"+_id).toggleClass("hide");
})
$(function(){
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
});

$(".btnwirteans").click(function(){
	 $(".comment-area").focus();
})
$(".cancelpop").click(function(){
	 $('.ui-actionsheet').removeClass('show').addClass('hide');
})


function deletewenzhang(current_aid){
	window.location.href=g_site_url + "index.php" + query + "topic/deletearticlecomment/"+current_aid+"/$topicone['id']";

}
$("#delete_wenzhang").click(function() {
	if (confirm('确定删除文章？该操作不可返回！') === true) {
	var url="{url user/deletexinzhi/$topicone['id']}";
	document.location.href = url;
	}
	});

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
function bianjiwenzhang(){
	window.location.href="{url user/editxinzhi/$topicone['id']}";
}
function show_questionoprate(){


	 $('.wenticaozuo').removeClass('hide').addClass('show');
}
$(function(){
	$(".article img").css("height","auto")
})
//投诉
function openinform(qid ,qtitle,aid) {
	  $("#myqid").val(qid);
	  $("#myqtitle").val(qtitle);
	  $("#myaid").val(aid);
	 $('#dialog_inform').show();

}
function hidemodel(){
	$('#dialog_inform').hide();
}
function dashangta(_aid,_authorid,_jine){
	{if $signPackage==null}
    var _url="{SITE_URL}index.php?topic/wappayarticle.html&tid="+_aid+"&authorid="+_authorid+"&jine="+_jine;
    $.get(_url, function(result){
       if(result.match("http")){
         window.location.href=result;
       }else{
    	   el2=$.tips({
 	            content:result,
 	            stayTime:2000,
 	            type:"success"
 	        });
       }
      });
	return false;
	{/if}
	var posturl='{url topic/ajaxdashangjine}';

	var _openid="{$openId}";

	var data={jine:_jine,openid:_openid,tid:_aid,authorid:_authorid};
	function success(result){
		WeixinJSBridge.invoke(
				'getBrandWCPayRequest',
				result,
				function(res){
					$("#dialogdashang").dialog("hide");
					var _tmps=res.err_msg.split(':');

					if(_tmps[1]=='ok'){
						 el2=$.tips({
			      	            content:'作者已收到您的打赏，非常感谢!',
			      	            stayTime:2000,
			      	            type:"success"
			      	        });
					}else{
						$("#dialogdashang").dialog("hide");
						 el2=$.tips({
			      	            content:'您已放弃打赏!',
			      	            stayTime:2000,
			      	            type:"success"
			      	        });

						return false;
					}
				}
			);
	}

	ajaxpost(posturl,data,success);
}

var currend_tid=0;
var currend_authorid=0;
$("#dialogdashang .ui-label").click(function(){

	var _shangjin=$(this).attr("val");
	$("#text_shangjin").val(_shangjin);



})
	$("#btndashang").click(function(){
		if(currend_tid==0){
			alert("请选择需要打赏的文章")
			return false;
		}

		var _shangjin=$.trim($("#text_shangjin").val());
		if(_shangjin==''||_shangjin<0.1||_shangjin>100){
			alert("打赏金额必须在0.1-100元之间");
			return false;
		}
		dashangta(currend_tid,currend_authorid,_shangjin);

	})
//调用微信JS api 支付

function mobilebestcallpay(aid,authorid,jine)
{
	currend_tid=aid;
	currend_authorid=authorid;
	$("#dialogdashang").dialog("show");

}
$('.article .article-content').find('br').remove();
    $(".f-size-set").bind("click",function(event){

        $(".article-content").toggleClass("art-font");
        if( $(".article-content").hasClass("art-font")){
            $(this).html("小");
        }else{
            $(this).html("大");
        }
    })
  
    function viewtopic(paymoney,_answerid){


        var viewmodel="{$topicone['readmode']}";
        var _textval="财富值";
        if(viewmodel=='3'){
     	   _textval="元";
        }
 	   var dia=$.dialog({
 	        title:'<center>温馨提示</center>',
 	        select:0,
 	        content:'<center><p style="color:red;margin-top:5px;">此文章需要支付'+paymoney+_textval+'</p></center>',
 	        button:["确认支付","取消"]
 	    });

	    dia.on("dialog:action",function(e){
	    	if(e.index==1){
	    		return false;
	    	}
	    	 var _tid=_answerid;



			   $.ajax({
			        //提交数据的类型 POST GET
			        type:"POST",
			        //提交的网址
			        url:"{url topic/posttopicreward}",
			        //提交的数据
			        data:{tid:_tid},
			        //返回数据的格式
			        datatype: "text",//"xml", "html", "script", "json", "jsonp", "text".

			        //成功返回之后调用的函数
			        success:function(data){

			        	data=$.trim(data);
			        	if(data==-2){
			        		alert('游客先登录!');
			        	}
			        	if(data==-3){
			        		alert('本人无需支付财富值偷看!');
			        	}
			        	if(data==-4){
			        		alert('付费阅读文章失败!');
			        	}
			        	if(data==-1){
			        		alert('此文章不需要支付财富值阅读!');
			        	}
			        	if(data==2){
			        		alert('此文章您已经付费过了!');
			        	}
			        	if(data==0){
			        		alert('财富值不足，先充值或者去赚财富值!');
			        		window.location.href="{url user/creditrecharge}";
			        	}
			        	if(data==7){
			        		alert('账户余额不足，先充值!');
			        		window.location.href="{url user/recharge}";
			        	}
			        	if(data==1){
			        		window.location.reload();
			        	}
			        }   ,

			        //调用出错执行的函数
			        error: function(){
			            //请求出错处理
			        }
			    });
	       // console.log(e.index)
	    });
	    dia.on("dialog:hide",function(e){
	       // console.log("dialog hide")
	    });




}
</script>

</section>
<!--{template footer}-->