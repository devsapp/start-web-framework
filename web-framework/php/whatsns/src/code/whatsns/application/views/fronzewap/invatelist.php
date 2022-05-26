<!--{template header}-->

<section class="ui-container">
<!--{template user_title}-->
     <ul class="tab-head">
                                         
                  
                      <li class="tab-head-item current"><a href="{url user/invatelist}" title="邀请的人">邀请的人</a></li>
                                                                               
                  
                      <li class="tab-head-item "><a href="{url user/invateme}" title="邀请回答">邀请回答</a></li>
                                                                               
                  
                            

   
</ul>
   
    <section class="user-content-list">
    
                          <ul class="ui-list ui-list-one ui-list-link ui-border-tb">
                 {if $followerlist==null}
                
               
    <p class="user-p-tip ui-txt-warning">  你还没有邀请任何人注册。</p>

                 {/if}
                    <div class="invateaddress" style="padding:10px;">
  <p>复制邀请注册地址分享给好友:</p>
  <p style="word-break: break-all;">{url user/register/$user['invatecode']}</p>
  {if $this->setting ['credit1_invate']!=null}<p>邀请注册可获得经验值：{$setting['credit1_invate']}点，财富值：{$setting['credit2_invate']}点</p>{/if}
  
  <button class="ui-btn copyinvateurl" style="margin-top:10px;margin-bottom:10px" data-clipboard-text="{$user['username']}邀请您加入【{$setting['site_name']}】，点击：{url user/register/$user['invatecode']}" >点击复制分享</button>
  {if $signPackage!=null}
  <div class="ui-tooltips ui-tooltips-guide">
    <div class="ui-tooltips-cnt  ui-border-b">
        <i class="ui-icon ui-icon-talk"></i>微信顶部右上角点击"...",可转发给好友。
    </div>
</div>
{/if}
  </div>
                    <!--{loop $followerlist $index $follower}-->
    <li class="ui-border-t" onclick="window.location.href='{url user/space/$follower['uid']}'">
    
        <div class="ui-list-thumb">
            <span style="background-image:url({$follower['avatar']})"></span>
        </div>
        <div class="ui-list-info">
            <h4 class="ui-nowrap">{$follower['username']}</h4>
            <div class="ui-txt-info">
             <!--{if (1 == $follower['gender'])}--> 男 
            
             <!--{else}-->
             女
            <!--{/if}-->
            </div>
        </div>
    </li>
  <!--{/loop}-->    
</ul>
          <div class="pages" >{$departstr}</div>   
    </section>
</section>
<input type="hidden" id="invatemebtn" value="{url user/register/$user['invatecode']}" />
<script src="https://cdn.bootcss.com/clipboard.js/2.0.6/clipboard.js"></script>
<script type="text/javascript">
var clipboard = new ClipboardJS('.copyinvateurl');

clipboard.on('success', function(e) {


    e.clearSelection();
    alert("复制成功，去粘贴给好友吧")
});

clipboard.on('error', function(e) {
    alert("复制失败")
});
  </script>
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
        'onMenuShareTimeline',
        'onMenuShareAppMessage',
        'onMenuShareQQ',
        'onMenuShareWeibo',
        'hideMenuItems'
        
      ]
  });

</script>

<script>


var _topictitle="{$user['username']}邀请您加入【{$setting['site_name']}】";
var imgurl="{$user['avatar']}"; 	
var topicdescription="{$setting['seo_index_description']}";
var topiclink="{url user/register/$user['invatecode']}";
wx.ready(function () {
    wx.checkJsApi({
	      jsApiList: [
	    	  'updateAppMessageShareData',
	          'updateTimelineShareData',
	        'onMenuShareTimeline',
	        'onMenuShareAppMessage',
	        'onMenuShareQQ',
	        'onMenuShareWeibo'
	      ],
	      success: function (res) {
	       // alert(JSON.stringify(res));
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
	       // alert('分享成功');
	      },
	      cancel: function (res) {
	    	  //alert('分享取消');
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
   
    wx.onMenuShareAppMessage({
	      title:_topictitle ,
	      desc:topicdescription ,
	      link:topiclink,
	      imgUrl: imgurl,
	      trigger: function (res) {
	      //  alert('用户点击发送给朋友');
	      },
	      success: function (res) {
	    
	
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
    wx.onMenuShareTimeline({
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
<!--{template footer}-->