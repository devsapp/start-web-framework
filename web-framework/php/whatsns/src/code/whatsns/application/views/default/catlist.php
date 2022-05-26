<!--{template header}-->
<link rel="stylesheet" media="all" href="{SITE_URL}static/css/widescreen/css/category.css" />
<!--{eval $adlist = $this->fromcache("adlist");}-->
<style>
.main-wrapper {
    background: #fff;
}
</style>
<div class="container collection index">
  <div class="row" style="padding-top:0px;margin:0px">
    <div class="col-md-17 main bb">
      <!-- 专题头部模块 -->
      <div class="main-top" style="padding-right: 20px;">
        <a class="avatar-collection" href="{url topic/catlist/$catmodel['id']}">
  <img src="$catmodel['bigimage']" alt="240">
</a>
{if  $is_followed}
 <a class="btn btn-default following" id="attenttouser_{$catmodel['id']}" onclick="attentto_cat($catmodel['id'])"><span>已关注</span></a>

{else}
 <a class="btn btn-success follow" id="attenttouser_{$catmodel['id']}" onclick="attentto_cat($catmodel['id'])"><span>关注</span></a>

{/if}


       

        <div class="title">
          <a class="name" href="{url topic/catlist/$catmodel['id']}"> {$catmodel['name']}</a>
        </div>
        <div class="info">
          收录了{$rownum}篇文章 ·{$catmodel['questions']}个问题 · {$catmodel['followers']}人关注
        </div>
      </div>
      <div class="catinfo" style="padding-right: 20px;">
       {if $catmodel['miaosu']}
          <div class="alert alert-success">
        
         {$catmodel['miaosu']}
     

        </div>
            {/if}
      </div>
       <div class="recommend-collection">



          <!--{loop $catlist $index $cat}-->


                   <a class="collection" href="{url topic/catlist/$cat['id']}">
            <img src="$cat['image']" alt="195" style="height:32px;width:32px;">
            <div class="name">{$cat['name']}</div>
        </a>
                <!--{/loop}-->


        {if $catmodel['pid']}
             <a class="more-hot-collection"  href="{url topic/catlist/$catmodel['pid']}">
        返回上级 <i class="fa fa-angle-right mar-ly-1"></i>
    </a>
        {/if}
                </div>
      <ul class="trigger-menu" data-pjax-container="#list-container">
      <li class="active"><a href="{url topic/catlist/$catmodel['id']}">
      <i class="fa fa-sticky-note-o"></i> 全部文章</a>
      </li>
  {if $catmodel['isuseask']}
    <li >
      <a href="{url category/view/$catmodel['id']}"><i class="fa fa-sticky-note-o"></i> 相关问题</a>
      </li>
        {/if}
      </ul>
     <div class="stream-list blog-stream" style="padding-right: 20px;">
                        <!--{loop $topiclist $nindex $topic}-->
              <section class="stream-list__item">
              <div class="blog-rank stream__item">
              <div data-id="1190000017247505" class="stream__item-zan   btn btn-default mt0">
              <span class="stream__item-zan-icon"></span>
              <span class="stream__item-zan-number">{$topic['articles']}</span>
              </div></div>
              <div class="summary">
              <h2 class="title blog-type-common blog-type-1">
              <a href="{url topic/getone/$topic['id']}">{$topic['title']}</a></h2>
              <ul class="author list-inline">
              <li>
              <a href="{url user/space/$topic['authorid']}">
              <img class="avatar-24 mr10 " src="{$topic['avatar']}" alt=" {$topic['author']}">
              </a>
              <span style="vertical-align:middle;">
              <a href="{url user/space/$topic['authorid']}"> {$topic['author']}</a>
                    
                    发布于
                                            <a href="{url topic/catlist/$topic['articleclassid']}">{$catmodel['name']}</a>
                                            </span>
                                            </li>
      <li class="bookmark " title="{$topic['likes']} 收藏" >
      <span style="vertical-align:middle;">
      <small class="fa fa-bookmark mr5"></small>
      <span class="blog--bookmark__text">{if $topic['likes']}$topic['likes']{/if} 收藏</span>
      </span></li></ul>
      <p class="excerpt wordbreak ">
       {if $topic['price']!=0}
                         <div class="box_toukan ">

  {eval echo clearhtml($topic['freeconent']);}
  {if $topic['readmode']==2}
											<a  class="thiefbox font-12" ><i class="icon icon-lock font-12"></i> &nbsp;更多阅读需支付&nbsp;$topic['price']&nbsp;&nbsp;积分……</a>
{/if}
  {if $topic['readmode']==3}
											<a  class="thiefbox font-12" ><i class="icon icon-lock font-12"></i> &nbsp;更多阅读需支付&nbsp;$topic['price']&nbsp;&nbsp;元……</a>
{/if}

										</div>
                   {else}
                     {eval echo clearhtml($topic['describtion']);}
                    {/if}

  
  </p>
      </div>
      </section>
        <!--{/loop}-->
              </div>
       <div class="pages">{$departstr}</div>
    </div>
    <div class="col-md-7   aside">
    <!--{template sider_searcharticle}-->
        <div class="widget-box pt0 mt25" style="border:none;">
                    
                        <ul class="taglist--inline multi" style="padding:0px;">
                                  {loop $relativetags $rtag}
                                  {if $rtag['tagname']!=$tag['tagname']}
                                                            <li class="tagPopup">
                                    <a class="tag" href="{url tags/article/$rtag['tagalias']}" >
                                                                          {if $rtag['tagimage']}  <img src="$rtag['tagimage']">{/if}
                                                                        {$rtag['tagname']}</a>
                                </li>{/if}
                                               {/loop}             
                                                    </ul>
                    </div>

         <!--{template sider_hotarticle}-->
    
      
       <div class="share">
        <span>分享至</span>
  
     
                    <span class="share-group">
        <a class="share-circle share-weixin" data-action="weixin-share" data-toggle="tooltip" data-original-title="分享到微信">
          <i class="fa fa-wechat"></i>
        </a>
        <a class="share-circle" data-toggle="tooltip" href="javascript:void((function(s,d,e,r,l,p,t,z,c){var%20f='http://v.t.sina.com.cn/share/share.php?appkey=1515056452',u=z||d.location,p=['&amp;url=',e(u),'&amp;title=',e(t||d.title),'&amp;source=',e(r),'&amp;sourceUrl=',e(l),'&amp;content=',c||'gb2312','&amp;pic=',e(p||'')].join('');function%20a(){if(!window.open([f,p].join(''),'mb',['toolbar=0,status=0,resizable=1,width=440,height=430,left=',(s.width-440)/2,',top=',(s.height-430)/2].join('')))u.href=[f,p].join('');};if(/Firefox/.test(navigator.userAgent))setTimeout(a,0);else%20a();})(screen,document,encodeURIComponent,'','','{$catmodel['bigimage']}', '《{$catmodel['name']}》','{url topic/catlist/$catmodel['id']}','页面编码gb2312|utf-8默认gb2312'));" data-original-title="分享到微博">
          <i class="fa fa-weibo"></i>
        </a>

<a  class="share-circle" data-toggle="tooltip"  target="_self" data-original-title="分享到qq" href="javascript:shareqq()"   title="分享到QQ"><i class="fa fa-qq"></i></a>



  <script type="text/javascript">
  //document.write(['<a class="share-circle" data-toggle="tooltip"  target="_self" data-original-title="分享到qq空间" href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=',encodeURIComponent(location.href),'&title=',encodeURIComponent(document.title),'" target="_self"   title="分享到QQ空间"> <i class="fa fa-qq"></i><\/a>'].join(''));


  function shareqq()
  {
      var p = {
          url: location.href,/*获取URL，可加上来自分享到QQ标识，方便统计*/
          desc: " {eval    echo  clearhtml(htmlspecialchars_decode(htmlspecialchars_decode(replacewords($catmodel['miaosu']))),50);    }", 
          title : document.title,/*分享标题(可选)*/
          summary : document.title,/*分享描述(可选)*/
          pics : "{$catmodel['bigimage']}",/*分享图片(可选)*/
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
      
      </div>

    </div>
  </div>
</div>
<!-- 微信分享 -->
<div class="modal share-wechat animated" style="display: none;"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" data-dismiss="modal" class="close">×</button></div> <div class="modal-body"><h5>打开微信“扫一扫”，打开网页后点击屏幕右上角分享按钮</h5> <div data-url="{url topic/catlist/$catmodel['id']}" class="qrcode" title="{url topic/catlist/$catmodel['id']}"><canvas width="170" height="170" style="display: none;"></canvas>
<div id="qr_wxcode">
</div></div></div> <div class="modal-footer"></div></div></div></div>
<script>
var qrurl="{url topic/catlist/$catmodel['id']}";
$(function(){
	//微信二维码生成
	$('#qr_wxcode').qrcode(qrurl);
	 //显示微信二维码
	 $(".share-weixin").click(function(){

		 $(".share-wechat").show();
	 });
	 //关闭微信二维码
	 $(".close").click(function(){
		 $(".share-wechat").hide();
		 $(".pay-money").hide();
	 });
});

</script>
<!--{template footer }-->