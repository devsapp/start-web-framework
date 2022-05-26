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
    <div class="col-xs-24 col-md-17 main">
      <!-- 专题头部模块 -->
      <div class="main-top">
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
            <div class="catinfo">
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
      <div id="list-container">
        <!-- 文章列表模块 -->
          <!--{if $topiclist==null}-->
         <div class="no-comment"></div>
            <div class="text">
           还没有相关文章
          </div>
          <!--{/if}-->
          <div class="row note-list article-list">
           <!--{loop $topiclist $index $topic}-->    
             <div class="col-xs-8  card-box">
                   <div class="big-have-img">
                      
						             <div class="big_wrap-img">
						              <a class="" title="{$topic['title']}" href="{url topic/getone/$topic['id']}"  target="_blank">
				            <img src="{$topic['image']}" >
				        </a>
						             </div>
		                         <a class="title" target="_blank" title="{$topic['title']}"  href="{url topic/getone/$topic['id']}"   >{$topic['title']}</a>
				         <div class="meta">
		                  {if $topic['price']!=0}
		                    {if $topic['readmode']==2}
		                          <span class="t_price">{$topic['price']}积分阅读</span>
		                    {/if}
                          {if $topic['readmode']==3}
		                          <span class="t_price">{$topic['price']}元阅读</span>
		                    {/if}
                   {else}
                   <span class="t_free">免费</span>
                    {/if}
		                <a target="_blank"  href="{url topic/getone/$topic['id']}"  >
		                    <i class="fa fa-eye"></i> {$topic['views']}
		                </a>        <a target="_blank"  href="{url topic/getone/$topic['id']}#comments" >
		                <i class="fa fa-comment-o"></i> {$topic['articles']}
		              </a>      <span class="pull-right"><i class=" fa fa-heart-o"></i>  {$topic['attentions']}</span>
		                 </div>
                  </div>
             </div>
              <!--{/loop}-->
          </div>

      </div>
       <div class="pages">{$departstr}</div>
    </div>
    <div class="col-xs-24 col-md-7  aside">
     <!--{template sider_searcharticle}-->
     <div class="widget-box pt0 mt25" style="border:none;">
                    
                        <ul class="taglist--inline multi">
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
             {if $catmodel['followers']>0}
             <div>
             <h2 class="h4 widget-box__title">关注的人({$catmodel['followers']})</h2>
              <ul class="list collection-follower">
             
               <!--{loop $followerlist $fuser}-->
             <li><a href="{url user/space/$fuser['followerid']}" target="_blank" class="avatar">
             <img src="{$fuser['avatar']}" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{$fuser['follower']} · {$fuser['format_time']} 关注"></a>
             </li>
             <!--{/loop}-->
        
             <a class="function-btn"><i class="fa fa-ellipsis-h"></i></a> <!----></ul>
     </div>
     {/if}
       <div class="share">
        <span>分享至</span>
              <span class="share-group">
        <a class="share-circle share-weixin" data-action="weixin-share" data-toggle="tooltip" data-original-title="分享到微信">
          <i class="fa fa-wechat"></i>
        </a>
        <a class="share-circle" data-toggle="tooltip" href="javascript:void((function(s,d,e,r,l,p,t,z,c){var%20f='http://v.t.sina.com.cn/share/share.php?appkey=1515056452',u=z||d.location,p=['&amp;url=',e(u),'&amp;title=',e(t||d.title),'&amp;source=',e(r),'&amp;sourceUrl=',e(l),'&amp;content=',c||'gb2312','&amp;pic=',e(p||'')].join('');function%20a(){if(!window.open([f,p].join(''),'mb',['toolbar=0,status=0,resizable=1,width=440,height=430,left=',(s.width-440)/2,',top=',(s.height-430)/2].join('')))u.href=[f,p].join('');};if(/Firefox/.test(navigator.userAgent))setTimeout(a,0);else%20a();})(screen,document,encodeURIComponent,'','','{$catmodel['bigimage']}', '《{$catmodel['name']}》','{url topic/catlist/$catmodel['id']}','页面编码gb2312|utf-8默认gb2312'));" data-original-title="分享到微博">
          <i class="fa fa-weibo"></i>
        </a>




  <script type="text/javascript">document.write(['<a class="share-circle" data-toggle="tooltip"  target="_self" data-original-title="分享到qq空间" href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=',encodeURIComponent(location.href),'&title=',encodeURIComponent(document.title),'" target="_self"   title="分享到QQ空间"> <i class="fa fa-qq"></i><\/a>'].join(''));</script>

      </span>
      </div>
      <div>
        <!--{template sider_hotarticle}-->
  

     </div>

    </div>
  </div>
</div>
<!-- 微信分享 -->
<div class="modal share-wechat animated" style="display: none;"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" data-dismiss="modal" class="close">×</button></div> <div class="modal-body"><h5>打开微信“扫一扫”，打开网页后点击屏幕右上角分享按钮</h5> <div data-url="{url question/view/$question['id']}" class="qrcode" title="{url question/view/$question['id']}"><canvas width="170" height="170" style="display: none;"></canvas>
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