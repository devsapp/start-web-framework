<!--{template header}-->
<link rel="stylesheet" media="all" href="{SITE_URL}static/css/widescreen/css/category.css" />
<link rel="stylesheet" media="all" href="{SITE_URL}static/css/common/commtag.css" />
<!--{eval $adlist = $this->fromcache("adlist");}-->
<div class="container collection index">
  <div class="row" style="padding-top:0px;margin:0px">
    <div class="col-md-17  main bb">
      <!-- 专题头部模块 -->
      <div class="main-top"  style="padding-right: 20px;">
        <a class="avatar-collection" href="{url category/view/$category['id']}">
          <img src="$category['bigimage']" alt="240">
</a>
{if $is_followed}
 <a class="btn btn-default following" id="attenttouser_{$category['id']}" onclick="attentto_cat($category['id'])"><span>已关注</span></a>

{else}
 <a class="btn btn-success follow" id="attenttouser_{$category['id']}" onclick="attentto_cat($category['id'])"><span>关注</span></a>

{/if}

            <div class="btn btn-hollow js-contribute-button" onclick="askquestionfromcid()">
                                           提问
            </div>

        <div class="title">
          <a class="name" href="{url category/view/$category['id']}"> {$category['name']}</a>
        </div>
        <div class="info">
                  收录了{$trownum}篇文章 ·{$category['questions']}个问题 · {$category['followers']}人关注
        </div>
      </div>
          <div class="catinfo"  style="padding-right: 20px;">
       {if $category['miaosu']}
          <div class="alert alert-success">
        
         {$category['miaosu']}
     

        </div>
            {/if}
      </div>
       <div class="recommend-collection">



          <!--{loop $sublist $index $cat}-->


                   <a class="collection"  href="{url category/view/$cat['id']}">
            <img src="$cat['image']" alt="195" style="height:32px;width:32px;">
            <div class="name">{$cat['name']}</div>
        </a>
                <!--{/loop}-->


        {if $category['pid']}
             <a class="more-hot-collection" href="{url category/view/$category['pid']}">
        返回上级 <i class="fa fa-angle-right mar-ly-1"></i>
    </a>
        {/if}
                </div>
      <ul class="trigger-menu" data-pjax-container="#list-container">
      <li <!--{if all==$status}-->class="active"<!--{/if}-->><a href="{url category/view/$cid/all}">
      <i class="fa fa-sticky-note-o"></i> 全部问题</a>
      </li>
      <li <!--{if 1==$status}-->class="active"<!--{/if}-->><a href="{url category/view/$cid/1}">
      <i class="fa fa-times">
      </i> 未解决</a>
      </li>
      <li <!--{if 2==$status}-->class="active"<!--{/if}-->>
      <a  href="{url category/view/$cid/2}"><i class="fa fa-check"></i> 已解决</a>
      </li>
      <li <!--{if 6==$status}-->class="active"<!--{/if}-->>
      <a href="{url category/view/$cid/6}"><i class="fa fa-shield"></i> 推荐问题</a>
      </li>
      {if $category['isusearticle']}
        <li >
      <a href="{url topic/catlist/$cid}"><i class="fa fa-sticky-note-o"></i> 相关文章</a>
      </li>
      {/if}
      </ul>
      
      <div class="stream-list question-stream"  style="padding-right: 20px;">
      
          <!--{loop $questionlist $index $question}-->
      <section class="stream-list__item">
                <div class="qa-rank">
              {if $question['answers']==0}
                <div class="answers ml10 mr10">
                {$question['answers']}<small>回答</small></div>
                {else}
                {if $question['status']==2}
                <div class="answers answered solved ml10 mr10">
                 {$question['answers']}<small>解决</small></div>
                {else}
                
                <div class="answers answered ml10 mr10">
                {$question['answers']}<small>回答</small></div>
                {/if}
                {/if}
                <div class="views  viewsword0to99"><span> {$question['views']}</span><small>浏览</small></div>
                </div>        <div class="summary">
            <ul class="author list-inline">
                                                <li>
                                                
        {if $question['hidden']!=1}
                                            <a href="{url user/space/$question['authorid']}">    {$question['author']}
                 {if $question['author_has_vertify']!=false}<i class="fa fa-vimeo {if $question['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  " data-toggle="tooltip" data-placement="right" title="" {if $question['author_has_vertify'][0]=='0'}data-original-title="个人认证" {else}data-original-title="企业认证" {/if} ></i>{/if}</a>
                      {else}
                      匿名用户
                      {/if}
                        <span class="split"></span>
                        <a href="{url question/view/$question['id']}" class="askDate" >{$question['format_time']}</a>
                                    </li>
            </ul>
            <h2 class="title"><a href="{url question/view/$question['id']}">{$question['title']}</a></h2>

                     <!--{if $question['tags']}-->
           <ul class="taglist--inline ib">
<!--{loop $question['tags'] $tag}-->
<li class="tagPopup authorinfo">
                        <a class="tag" href="{url tags/view/$tag['tagalias']}" >
                                                       {$tag['tagname']}
                        </a>
                    </li>
                    

                           
                <!--{/loop}-->
                 </ul>
                <!--{else}--><!--{/if}-->
                                            </div>
    </section>
        <!--{/loop}-->
      </div>
     
         <div class="pages">{$departstr}</div>
    </div>
    <div class="col-md-7  aside">



 <!--{template sider_searchquestion}-->

  <div class="widget-box pt0 mt25" style="border:none;">
                
                        <ul class="taglist--inline multi" style="padding:0px;">
                                  {loop $relativetags $rtag}
                                  {if $rtag['tagname']!=$tag['tagname']}
                                                            <li class="tagPopup">
                                    <a class="tag" href="{url tags/view/$rtag['tagalias']}" >
                                                                          {if $rtag['tagimage']}  <img src="$rtag['tagimage']">{/if}
                                                                        {$rtag['tagname']}</a>
                                </li>{/if}
                                               {/loop}             
                                                    </ul>
                    </div>

      <!--{template sider_hotquestion}-->
  
     
      <div class="share">
        <span>分享至</span>
        
  
                       <span class="share-group">
        <a class="share-circle share-weixin" data-action="weixin-share" data-toggle="tooltip" data-original-title="分享到微信">
          <i class="fa fa-wechat"></i>
        </a>
        <a class="share-circle" data-toggle="tooltip" href="javascript:void((function(s,d,e,r,l,p,t,z,c){var%20f='http://v.t.sina.com.cn/share/share.php?appkey=1515056452',u=z||d.location,p=['&amp;url=',e(u),'&amp;title=',e(t||d.title),'&amp;source=',e(r),'&amp;sourceUrl=',e(l),'&amp;content=',c||'gb2312','&amp;pic=',e(p||'')].join('');function%20a(){if(!window.open([f,p].join(''),'mb',['toolbar=0,status=0,resizable=1,width=440,height=430,left=',(s.width-440)/2,',top=',(s.height-430)/2].join('')))u.href=[f,p].join('');};if(/Firefox/.test(navigator.userAgent))setTimeout(a,0);else%20a();})(screen,document,encodeURIComponent,'','','{$category['bigimage']}', '《{$category['name']}》','{url category/view/$category['id']}','页面编码gb2312|utf-8默认gb2312'));" data-original-title="分享到微博">
          <i class="fa fa-weibo"></i>
        </a>

  <a  class="share-circle" data-toggle="tooltip"  target="_self" data-original-title="分享到qq" href="javascript:shareqq()"   title="分享到QQ"><i class="fa fa-qq"></i></a>



  <script type="text/javascript">
  //document.write(['<a class="share-circle" data-toggle="tooltip"  target="_self" data-original-title="分享到qq空间" href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=',encodeURIComponent(location.href),'&title=',encodeURIComponent(document.title),'" target="_self"   title="分享到QQ空间"> <i class="fa fa-qq"></i><\/a>'].join(''));


  function shareqq()
  {
      var p = {
          url: location.href,/*获取URL，可加上来自分享到QQ标识，方便统计*/
          desc: " {eval    echo  clearhtml(htmlspecialchars_decode(htmlspecialchars_decode(replacewords($category['miaosu']))),50);    }", 
          title : document.title,/*分享标题(可选)*/
          summary : document.title,/*分享描述(可选)*/
          pics : "{$category['bigimage']}",/*分享图片(可选)*/
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

<div class="modal fade" id="dialogquestion">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
      <h4 class="modal-title">快速提问[ {$category['name']}]</h4>
    </div>
    <div class="modal-body">

        <input type="hidden"  value="{$category['id']}" id="quickcid" name="quickcid"/>
        <table  class="table ">
        
                <tr>
                <td>
                    <div class="inputbox mt15">
                          <div class="form-group">
          <p class="  text-left fl"> 问题标签设置，最多5个:</p>
          <div class=" has-error">
           
          <div class=" dongtai ">
          <div class="tags">
      
          </div>
            <input type="text" autocomplete="off"  data-toggle="tooltip" data-placement="bottom" title="" placeholder="添加标签更容易被回答" data-original-title="检索标签，最多添加5个，添加标签更容易被回答" name="topic_tagset" value=""  class="txt_taginput" >
            <i class="fa fa-search"></i>
           <div class="tagsearch">
        
          
           </div>
            
          </div>
          </div>
        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="inputbox mt15">
                        <input  id="quicktitle" placeholder="请描述您的问题"  name="quicktitle" class="form-control">
                    </div>
                </td>
            </tr>
            <tr>
                <td><button type="button" onclick="postquickquestion()" id="postquickquestion" class="btn btn-success" >发布</button></td>
            </tr>
        </table>


    </div>

  </div>
</div>
</div>
<!-- 微信分享 -->
<div class="modal share-wechat animated" style="display: none;"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" data-dismiss="modal" class="close">×</button></div> <div class="modal-body"><h5>打开微信“扫一扫”，打开网页后点击屏幕右上角分享按钮</h5> <div data-url="{url category/view/$category['id']}" class="qrcode" title="{url category/view/$category['id']}"><canvas width="170" height="170" style="display: none;"></canvas>
<div id="qr_wxcode">
</div></div></div> <div class="modal-footer"></div></div></div></div>
<script>
var qrurl="{url category/view/$category['id']}";
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
$(".txt_taginput").on(" input propertychange",function(){
	 var _txtval=$(this).val();
	 if(_txtval.length>1){
	
		 //检索标签信息
		 var _data={tagname:_txtval};
		 var _url="{url tags/ajaxsearch}";
		 function success(result){
			 console.log(result)
			 if(result.code==200){
				 console.log(_txtval)
				  $(".tagsearch").html("");
				for(var i=0;i<result.taglist.length;i++){
			
					 var _msg=result.taglist[i].tagname
					 
			           $(".tagsearch").append('<div class="tagitem" tagid="'+result.taglist[i].id+'">'+_msg+'</div>');
				}
				$(".tagsearch").show();
				$(".tagsearch .tagitem").click(function(){
					var _tagname=$.trim($(this).html());
					var _tagid=$.trim($(this).attr("tagid"));
					if(gettagsnum()>=5){
						alert("标签最多添加5个");
						return false;
					}
					if(checktag(_tagname)){
						alert("标签已存在");
						return false;
					}
					$(".dongtai .tags").append('<div class="tag"><span tagid="'+_tagid+'">'+_tagname+"</span><i class='fa fa-close'></i></div>");
					$(".dongtai .tags .tag  .fa-close").click(function(){
						$(this).parent().remove();
					});
					$(".tagsearch").html("");
					$(".tagsearch").hide();
					$(".txt_taginput").val("");
					});
		        
			 }
			 
		 }
		 ajaxpost(_url,_data,success);
	 }else{
			$(".tagsearch").html("");
			$(".tagsearch").hide();
	 }
})
	function checktag(_tagname){
		var tagrepeat=false;
		$(".dongtai .tags .tag span").each(function(index,item){
			var _tagnametmp=$.trim($(this).html());
			if(_tagnametmp==_tagname){
				tagrepeat=true;
			}
		})
		return tagrepeat;
	}
	function gettaglist(){
		var taglist='';
		$(".dongtai .tags .tag span").each(function(index,item){
			var _tagnametmp=$.trim($(this).attr("tagid"));
			taglist=taglist+_tagnametmp+",";
			
		})
		taglist=taglist.substring(0,taglist.length-1);
	
		return taglist;
	}
	function gettagsnum(){
    return $(".dongtai .tags .tag").length;
	}
	$(".tagsearch .tagitem").click(function(){
		var _tagname=$.trim($(this).html());
		if(gettagsnum()>=5){
			alert("标签最多添加5个");
			return false;
		}
		if(checktag(_tagname)){
			alert("标签已存在");
			return false;
		}
		$(".dongtai .tags").append('<div class="tag"><span>'+_tagname+"</span><i class='fa fa-close'></i></div>");
		$(".dongtai .tags .tag  .fa-close").click(function(){
			$(this).parent().remove();
		});
		$(".tagsearch").html("");
		$(".tagsearch").hide();
		$(".txt_taginput").val("");
		});
	$(".dongtai .tags .tag  .fa-close").click(function(){
		$(this).parent().remove();
	});
function askquestionfromcid(){
	if(g_uid==0)
{
	login();
	return ;
}
$('#dialogquestion').modal('show');
}
function postquickquestion(){
	var _title=$.trim($("#quicktitle").val());
var _cid=$("#quickcid").val();
if(_title==''){
	alert("提问标题不能为空");
	return false;
}
var _quicktags=gettaglist();
$("#postquickquestion").attr("disabled",true);
	var _data={quicktitle:_title,quickcid:_cid,quicktags:_quicktags};
	var url="{url question/ajaxquickadd}";
	function success(message){
		
      if(message.message=='ok'){
          alert("发布成功");
          setTimeout(function(){   window.location.reload();},1000);
       
      }else{
   alert(message.message);
      }
	}
	ajaxpost(url,_data,success);
}
</script>
<!--{template footer }-->