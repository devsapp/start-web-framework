<!--{template header}-->
<style>
.container{
    width: 1000px;
    padding: 0px;
}
<!--
.main-wrapper {
    margin-bottom: 40px;
    background: #fafafa;
    margin-top: 0px;
}
.signature{
color:#999;
}
.imgjiesu{
position: absolute;
    right: 10px;
    top: 13px;
    width: 45px;
    height: 35px;
}
.jinxingzhong{
position: absolute;
    right: 15px;
    top: 13px;
    width: 35px;
    height: 35px;
}
.details-contitle-box{
position:relative;
}

-->
</style>
<!-- cdn 问题详情顶部固定 -->
<div class="cdn_question_fixedtitle"></div>
<link rel="stylesheet" media="all" href="{SITE_URL}static/css/common/commtag.css" />
  <!--{eval $adlist = $this->fromcache("adlist");}-->
<link rel="stylesheet" media="all" href="{SITE_URL}static/css/widescreen/css/greendetail.css?v1.1" />
<link rel="stylesheet" media="all" href="{SITE_URL}static/css/widescreen/css/widescreendetail.css?v1.1" />
               <!--广告位1-->
            <!--{if (isset($adlist['question_view']['inner1']) && trim($adlist['question_view']['inner1']))}-->
            
     <div class="advlong-bottom">
            <div class="advlong-default">
         
            {$adlist['question_view']['inner1']}
          
            </div>
        </div>
          <!--{/if}-->
  <!--{eval $adlist = $this->fromcache("adlist");}-->
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
                            <h2>
                            {$question['title']}    
                                   {if $question['shangjin']&&$question['status']==1}<img class="jinxingzhong" src="{SITE_URL}static/images/jinxingzhong.png"/> {/if}
                                     
                                    {if $question['shangjin']&&$question['status']==2}<img class="imgjiesu" src="{SITE_URL}static/images/yijiesu.png"/> {/if}
          
                                      {if $question['price']>0}    
                      <span data-toggle="tooltip" data-placement="bottom" title="" data-original-title="悬赏 {$question['price']}财富值，采纳后可获得"  class="icon_jifen"><i class="fa fa-database mar-r-03"></i>财富值{$question['price']}</span>
  {/if}
                
                             {if $question['shangjin']!=0}
                      <span data-toggle="tooltip" data-placement="bottom" title="" data-original-title="如果回答被采纳将获得 {$question['shangjin']}元，可提现" class="icon_hot"><i class="fa fa-hongbao mar-r-03"></i>悬赏$question['shangjin']元</span>

                    {/if}
                                 
                                  {if $question['hasvoice']!=0}
                      <span data-toggle="tooltip" data-placement="bottom" title=""  class="icon_green"><i class="fa fa-volume-up mar-r-03"></i>语音偷听</span>
                    {/if}
                                    
                                
                                      {if $question['askuid']>0}
                      <span data-toggle="tooltip" data-placement="bottom" title="" data-original-title="邀请{$question['askuser']['username']}回答"  class="icon_zise"><i class="fa fa-twitch mar-r-03"></i>邀请回答</span>
                  {/if}
                  {if $question['status']!=9}
                    {if $showtime}
                    <span data-toggle="tooltip" data-placement="bottom" title="" data-original-title="超过时间没有采纳，系统将自动分配最佳答案，没有回答赏金自动返回给作者"  class="time-item hide">
                    【<span id="day_show">0天</span>

	<strong id="hour_show">0时</strong>

	<strong id="minute_show">0分</strong>

	<strong id="second_show">0秒</strong>】
	</span>
	<script>

		setoutTime({$outtime});
		$(".time-item").removeClass("hide").css("color","#ea644a").show()

	</script>
                    {/if}
                        {/if}
                                





                            </h2>
                           
                            <!--发布时间-->
                            <p  class="title-time">
                              
                                <span>{$question['format_time']}</span>发布
                                    <span class="share-group">
        <a class="share-circle share-weixin" data-action="weixin-share" data-toggle="tooltip" data-original-title="分享到微信">
          <i class="fa fa-wechat"></i>
        </a>
        <a class="share-circle" data-toggle="tooltip" href="javascript:void((function(s,d,e,r,l,p,t,z,c){var%20f='http://v.t.sina.com.cn/share/share.php?appkey=1515056452',u=z||d.location,p=['&amp;url=',e(u),'&amp;title=',e(t||d.title),'&amp;source=',e(r),'&amp;sourceUrl=',e(l),'&amp;content=',c||'gb2312','&amp;pic=',e(p||'')].join('');function%20a(){if(!window.open([f,p].join(''),'mb',['toolbar=0,status=0,resizable=1,width=440,height=430,left=',(s.width-440)/2,',top=',(s.height-430)/2].join('')))u.href=[f,p].join('');};if(/Firefox/.test(navigator.userAgent))setTimeout(a,0);else%20a();})(screen,document,encodeURIComponent,'','','{$setting['site_logo']}', '推荐 {$question['author']} 的问题《{$question['title']}》','{url question/answer/$qid/$aid}','页面编码gb2312|utf-8默认gb2312'));" data-original-title="分享到微博">
          <i class="fa fa-weibo"></i>
        </a>

  <a  class="share-circle" data-toggle="tooltip"  target="_self" data-original-title="分享到qq" href="javascript:shareqq()"   title="分享到QQ"><i class="fa fa-qq"></i></a>



  <script type="text/javascript">
  //document.write(['<a class="share-circle" data-toggle="tooltip"  target="_self" data-original-title="分享到qq空间" href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=',encodeURIComponent(location.href),'&title=',encodeURIComponent(document.title),'" target="_self"   title="分享到QQ空间"> <i class="fa fa-qq"></i><\/a>'].join(''));


  function shareqq()
  {
      var p = {
          url: location.href,/*获取URL，可加上来自分享到QQ标识，方便统计*/
          desc: " {eval    echo  clearhtml(htmlspecialchars_decode(htmlspecialchars_decode(replacewords($question['description']))),50);    }", 
          title : document.title,/*分享标题(可选)*/
          summary : document.title,/*分享描述(可选)*/
          pics : "{$question['author_avartar']}",/*分享图片(可选)*/
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
                            <!--分类,版权,浏览数,评论数,推荐数-->
                            <div class="work-head-box">
                                <div class="head-left">
                                            <span class="head-index">
                                                <span><a href="{url new/default}" target="_blank">站内问答</a></span>
                                                <i>/</i>
                                                <span>
                                                   <a class="notebook" href="{url category/view/$question['cid']}" data-toggle="tooltip" data-html="true" data-original-title="问题归属分类">
 <span>{$question['category_name']}</span>
                </a>  
                                                </span>
                                              

                                            </span>
                                 
                                </div>
                                <div class="head-right">
                                            <span class="head-data-show">

                                            <a href="javascript:;" title="共{$question['views']}人气" class="see vertical-line">
                                                <i></i>{$question['views']}
                                            </a>
                                            <a href="javascript:;" title="共{$question['answers']}回答" class="news vertical-line">
                                                <i></i>{$question['answers']}
                                            </a>
                                            <a href="javascript:;" title="共 {$question['attentions']}收藏" class="recommend-show">
                                                <i></i> {$question['attentions']}
                                            </a>
                                            </span>
                                            
                                        	<!-- cdn节点 问题操作 -->
						<span class="cdn_question_caozuo"></span>

                                </div>
                            </div>
                        </div>
                    </div>
                    




<div class="top-author-card follow-box col-md-8">
  	 <!-- cdn节点  提问者信息 -->
			 <div class="cdn_question_userinfo"></div>
</div>

                </div>
                <div class="container ">
      
                 <div class="content-wrap">
          <div class="left-details-head" style="border:none">
                      <!-- 问题描述 -->
      {if $question['description']}
            <div class="show-content shortquestioncontent">

                <p>
                {$question['shortdescription']}
                {if $question['artlen']>=100}
                <button type="button" class="btnshowall">显示全部<i class="fa fa-angle-down"></i></button>
                {/if}
                </p>
            </div>
            
            <div class="show-content hide hidequestioncontent">
                  {eval    echo replacewords($question['description']);    }
            </div>
            
            {/if}
                </div>
   <div class="details-con-other border-top"  {if !$question['description']} style="margin-top:0px;"  {/if}>
                <div class="">
                   
             
                    
                    <div class="three-link">
                       <!-- cdn节点 问题操作按钮 -->
                        <div class="cdn_question_button"></div>
                    </div>
                </div>
            </div>
   
   </div>
                </div>
            </div>
<div class="container index" id="showanswerform">
<div class="row">
   <div class="col-md-17 main " style="padding:0px;">
   <div class="note ">
      <div class="post">
      <div class="comment-list">
    <div class="new-comment canwirteanswer" style="margin:0px 10px 10px 10px;">
       <div style="" class="answer-txtbox bb top-answer" id="answer-txtbox">
               <!--{if 9!=$question['status']  }-->
        {if $user['uid']!=0}
 <form class="new-comment" id="huidaform"  name="answerForm"  method="post" style="margin:10px;">
  <input type="hidden" value="{$question['id']}" id="ans_qid" name="qid">
   <input type="hidden" id="tokenkey" name="tokenkey" value='{$_SESSION["answertoken"]}'/>
                <input type="hidden" value="{$question['title']}" id="ans_title" name="title">


    <!--{template editor}-->
  <div class="write-function-block">
  <div class="hint">付费偷看设置</div>

  <div class="emoji-modal-wrap">
 <a class="emoji "  data-toggle="tooltip" data-placement="right" title="" data-original-title="设置付费查看回答金额">
 <i class="fa fa-paypal text-red mar-ly-1"></i>
 </a>
</div>
  <a class="btn btn-send" id="ajaxsubmitasnwer">发送</a>
  </div>
  
      <!--{if $setting['code_ask']&&$user['credit1']<$setting['jingyan']}-->
     <div class="write-function-block ">

 {template code}

 </div>
    <!--{/if}-->
  </form>
      {else}

            {/if}

              <!--{else}-->
               <div class="c-text alert alert-success-inverse"><i class="fa fa-info-circle mar-ly-1"></i>该问题目前已经被作者或者管理员关闭, 无法添加新回复</div>
                     <!--{/if}-->
    </div>
    
  
         </div>
   

  
 
  


<div id="comment-list" class="comment-list bb" style="margin:0px;margin-bottom:20px;{if $question['answers']==0}display:none;{/if}">

        <div id="normal-comment-list" class="normal-comment-list">
        <div>
        <div>
        <div class="top" id="comments">
        <span>{$question['answers']}条回答</span>

           <div class="pull-right">
       
           </div>
           </div>
           </div>
            <!--{if $useranswer['id']>0}-->

               <div id="comment-{$useranswer['id']}" class="comment">

            <div>
              {if $question['authorid']==$useranswer['authorid']&&$question['hidden']==1}
            <div class="author">
            <a href="javascript:"  class="avatar">
            <img src="{SITE_URL}static/css/default/avatar.gif">
            </a>
            <div class="info">
            <a href="javascript:" class="name">
            匿名用户
            </a>
            <!---->
             <div class="meta">
             <span>1楼 · {$useranswer['format_time']}
             {if $useranswer['adopttime']>0}
             .<span class="text-danger"><i class="fa fa-check"></i>采纳回答</span>
             {/if}
             {$useranswer['format_time']}
             </span>
             </div>
             </div>
             </div>
                {else}
                           <div class="author">
            <a href="{url user/space/$useranswer['authorid']}" target="_self" class="avatar">
            <img src="{$useranswer['author_avartar']}">
            </a>
            <div class="info">
            <a href="{url user/space/$useranswer['authorid']}" target="_self" class="name">
            {$useranswer['author']}
             {if $useranswer['author_has_vertify']!=false}<i class="fa fa-vimeo {if $useranswer['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  " data-toggle="tooltip" data-placement="right" title="" {if $useranswer['author_has_vertify'][0]=='0'}data-original-title="个人认证" {else}data-original-title="企业认证" {/if} ></i>{/if}
           {if $useranswer['signature']} <span class="signature">- $useranswer['signature']</span> {/if}
            </a>
            <!---->
             <div class="meta">
             <span> {$useranswer['format_time']}
             {if $useranswer['adopttime']>0}
             .<span class="text-danger"><i class="fa fa-check"></i>采纳回答</span>
             {/if}
             
             </span>
             </div>
             </div>
             </div>

             {/if}
             <div class="comment-wrap art-content">
             <div class="answercontent" style="max-height:2000px;">
                {if $useranswer['serverid']==null}
                             {if $useranswer['reward']==0||$useranswer['authorid']==$user['uid']}
                             {eval    echo replacewords($useranswer['content']);    }
                               {else}
                                    {eval if($question['authorid']==$user['uid']) $useranswer['canview']=1;}
                               {if $useranswer['canview']==0}
                                 <div class="box_toukan ">

											{if $user['uid']==0}
											<div onclick="login()" data-placement="bottom" title="" data-toggle="tooltip" data-original-title="我也付费偷偷看" class="thiefbox font-12" onclick=""><i class="icon icon-lock font-12"></i> &nbsp;精彩回答&nbsp;$useranswer['reward']&nbsp;&nbsp;元偷偷看…… <span class="kanguoperson">$useranswer['viewnum']人看过</span></div>
											{else}
											<div onclick="viewanswer($useranswer['id'])" data-placement="bottom" title="" data-toggle="tooltip" data-original-title="我也付费偷偷看" class="thiefbox font-12" onclick=""><i class="icon icon-lock font-12"></i> &nbsp;精彩回答&nbsp;$useranswer['reward']&nbsp;&nbsp;元偷偷看……<span class="kanguoperson">$useranswer['viewnum']人看过</span></div>
											{/if}


										</div>
                               {else}
                                 {eval    echo replacewords($useranswer['content']);    }
                               {/if}

                               {/if}



                    {else}

									<div class="htmlview">
					  <div class="yuyinplay" id="{$useranswer['serverid']}">
                     <i class="fa fa-volume-up " ></i><span class="u-voice">
                     <span class="wtip">免费偷听</span>

                     &nbsp;{$useranswer['voicetime']}秒</span>
                     <audio id="voiceaudio" width="420" style="display:none">
    <source src="{SITE_URL}data/weixinrecord/{$useranswer['mediafile']}" type="audio/mpeg" />

</audio>
                    </div>
					</div>
                    {/if}

                 <div class="appendcontent">
                                <!--{loop $useranswer['appends'] $append}-->
                                <div class="appendbox">
                                    <!--{if $append['authorid']==$useranswer['authorid']}-->
                                    <h4 class="appendanswer font-12">回答:<span class="time">
                                    {$useranswer['format_time']}</span></h4>
                                    <!--{else}-->
                                    <h4 class="appendask font-12">作者追问:<span class='time'>{$useranswer['format_time']}</span></h4>
                                    <!--{/if}-->
                                       <div class="zhuiwentext">   {eval    echo replacewords($append['content']);    }
                                       </div>
                                <div class="clr"></div>
                                </div>
                                <!--{/loop}-->
                        </div>
            </div>
           
            <div class="tool-group">
             <!-- cdn节点 回答操作 -->
													<div class="cdn_question_answer{$useranswer['id']}"></div>
													<script type="text/javascript">
													  getquestioncaozuo(5,{$useranswer['qid']},{$useranswer['id']});
													</script>

                </div>
                </div>
             
                </div>
                <div class="comments-mod "  style="display: none; float:none;padding-top:10px;" id="comment_{$useranswer['id']}">
                    <div class="areabox clearfix">


                  <div class="input-group">
             <input type="text" placeholder="请输入评论内容，不少于5个字" AUTOCOMPLETE="off" class="comment-input form-control" name="content" />
                        <input type='hidden' value='0' name='replyauthor' />
              <span class="input-group-btn"><input type="button" value="评论"  class="btn btn-green" name="submit" onclick="addcomment({$useranswer['id']});"/> </span>
            </div>

                    </div>
                    <ul class="my-comments-list nav">
                        <li class="loading">
                        <img src='{SITE_URL}static/css/default/loading.gif' align='absmiddle' />
                        &nbsp;加载中...
                        </li>
                    </ul>
                </div>
                </div>

                <!--{/if}-->
         
   
               </div>
               </div>
     <div>
        
                 
        </div>
               </div>
               {if $question['answers']>1}
               <div class="noreplaytext bb">
<center><div>   <a href="{url question/view/$qid}">  查看其它{$question['answers']}个回答
</a>
</div></center>
</div>
{/if}
             <!-- cdn 问答邀请 -->
<div class="cdn_question_invate"></div>		
<script type="text/javascript">
getquestioncaozuo(7,{$question['id']});
</script>
                      <!--{eval $attentionlist = $this->fromcache("attentionlist");}-->
               <div class="new-answer bb">
       <h3 class="title">一周热门 <a href="content/solve" target="_blank" class="more">更多<font>&gt; </font></a></h3>
       <div class="inf-list">
          <ul class="clearfix">
                   
                      <!--{loop $attentionlist $index $solve}-->
   <li><a href="{url question/view/$solve['id']}" title="{$solve['title']}">{eval echo clearhtml($solve['title'],22);}</a></li>
              
     
           
                 
  <!--{/loop}-->
  
                      </ul>
       </div>
    </div>
    
               </div>
    </div>


</div>

   </div>

   <div class="col-md-7  aside ">
   <div class="standing">
  <div class="positions bb" id="rankScroll">
      <h3 class="title">相关问答</h3>
      <ul>
      
  <!--{loop $solvelist $solve}-->
  {if $question['id']!=$solve['questionid']}
              <li class="no-video">
        <a href="{url question/view/$solve['questionid']}" title="{$solve['title']}" >   {$solve['title']} </a>
               <div class="num-ask">
               <a href="{url question/view/$solve['questionid']}"  class="anum"> {$solve['answers']} 个回答</a>
               </div>
              </li>
                 {/if}
                 
  <!--{/loop}-->
              </ul>
  </div>
  </div>
  {if  $topiclist}
     <div class="standing">
  <div class="positions bb" id="rankScroll">
      <h3 class="title">相关文章</h3>
      <ul>
      


    <!--{loop $topiclist $topic}-->
              <li class="no-video">
        <a href="{url topic/getone/$topic['articleid']}" title="{$solve['title']}" >  {$topic['title']}</a>
               <div class="num-ask">
               <a href="{url topic/getone/$topic['articleid']}" title="{$topic['title']}" class="anum"> {$topic['articles']} 个评论</a>
               </div>
              </li>
                <!--{/loop}-->
               

              </ul>
  </div>
  </div>
  {/if}

                               


            <!--广告位5-->
        <!--{if (isset($adlist['question_view']['right1']) && trim($adlist['question_view']['right1']))}-->

        <div class="right_ad">{$adlist['question_view']['right1']}</div>


        <!--{/if}-->
   </div>
</div>
</div>

<div class="modal fade" id="dialogadopt">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
      <h4 class="modal-title">采纳回答</h4>
    </div>
    <div class="modal-body">

     <form class="form-horizontal"  name="editanswerForm"  method="post" >
        <input type="hidden"  value="{$question['id']}" id="adopt_qid" name="qid"/>
        <input type="hidden" id="adopt_answer" value="0" name="aid"/>
        <table  class="table ">
            <tr valign="top">
                <td>向帮助了您的知道网友说句感谢的话吧!</td>
            </tr>
            <tr>
                <td>
                    <div class="inputbox mt15">
                        <textarea class="form-control" id="adopt_txtcontent"  name="content">非常感谢!</textarea>
                    </div>
                </td>
            </tr>
            <tr>
                <td><button type="button" id="adoptbtn" class="btn btn-success" >确&nbsp;认</button></td>
            </tr>
        </table>
    </form>

    </div>

  </div>
</div>
</div>
<script>
if(typeof($(".work-show-box").find("img").attr("data-original"))!="undefined"){
	var imgurl=$(".work-show-box").find("img").attr("data-original");
	$(".work-show-box").find("img").attr("src",imgurl);
}
$(".work-show-box").find("img").attr("data-toggle","lightbox");

$("#adoptbtn").click(function(){
	  var data={
    			content:$("#adopt_txtcontent").val(),
    			qid:$("#adopt_qid").val(),
    			aid:$("#adopt_answer").val()

    	}

	$.ajax({
	    //提交数据的类型 POST GET
	    type:"POST",
	    //提交的网址
	    url:"{url question/ajaxadopt}",
	    //提交的数据
	    data:data,
	    //返回数据的格式
	    datatype: "json",//"xml", "html", "script", "json", "jsonp", "text".
	    //在请求之前调用的函数
	    beforeSend:function(){},
	    //成功返回之后调用的函数
	    success:function(data){
	    	var data=eval("("+data+")");
	       if(data.message=='ok'){
	    	   new $.zui.Messager('采纳成功!', {
	    		   type: 'success',
	    		   close: true,
	       	    placement: 'center' // 定义显示位置
	       	}).show();
	    	   setTimeout(function(){
	               window.location.reload();
	           },1500);
	       }else{
	    	   new $.zui.Messager(data.message, {
	        	   close: true,
	        	    placement: 'center' // 定义显示位置
	        	}).show();
	       }


	    }   ,
	    //调用执行后调用的函数
	    complete: function(XMLHttpRequest, textStatus){

	    },
	    //调用出错执行的函数
	    error: function(){
	        //请求出错处理
	    }
	 });
})

</script>
</div>
<!-- 编辑标签 -->

<div class="modal fade" id="dialog_tag">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
      <h4 class="modal-title">编辑标签</h4>
    </div>
    <div class="modal-body">

    <form onsubmit=" return checktagsubmit()" class="form-horizontal"  name="edittagForm"  action="{url question/edittag}" method="post" >
        <input type="hidden"  value="{$question['id']}" name="qid"/>

                <p>最多设置5个标签!</p>

                    <div class="inputbox mar-t-1">
                      <div class=" dongtai ">
          <div class="tags">
          {loop $taglist $tag}
             <div class="tag"><span tagid="{$tag['id']}">{$tag['tagname']}</span><i class="fa fa-close"></i></div>
             {/loop}
          </div>
            <input type="text" autocomplete="off"  data-toggle="tooltip" data-placement="bottom" title="" placeholder="检索标签，最多添加5个,添加标签更容易被回答" data-original-title="检索标签，最多添加5个" name="topic_tagset" value=""  class="txt_taginput" >
            <i class="fa fa-search"></i>
           <div class="tagsearch">
        
          
           </div>
            
          </div>
          
                        <input type="hidden"  class="form-control" id="qtags" name="qtags" value=""/>
                    </div>

            <div class="mar-t-1">

                <button type="submit" class="btn btn-success">保存</button>
                 <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      </div>
    </form>

    </div>

  </div>
</div>
</div>
 <!--{if 1==$user['grouptype'] && $user['uid']}-->
<div class="modal fade" id="catedialog">
<div class="modal-dialog modal-md" style="width: 460px; top: 50px;">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
      <h4 class="modal-title">修改分类</h4>
    </div>
    <div class="modal-body">

      <div id="dialogcate">
        <form class="form-horizontal"  name="editcategoryForm" action="{url question/movecategory}" method="post">
            <input type="hidden" name="qid" value="{$question['id']}" />
            <input type="hidden" name="category" id="categoryid" />
            <input type="hidden" name="selectcid1" id="selectcid1" value="{$question['cid1']}" />
            <input type="hidden" name="selectcid2" id="selectcid2" value="{$question['cid2']}" />
            <input type="hidden" name="selectcid3" id="selectcid3" value="{$question['cid3']}" />
            <table class="table ">
                <tr valign="top">
                    <td >
                        <select  id="category1" class="catselect" size="8" name="category1" ></select>
                    </td>
                    <td align="center" valign="middle" ><div style="display: none;" id="jiantou1">>></div></td>
                    <td >
                        <select  id="category2"  class="catselect" size="8" name="category2" style="display:none"></select>
                    </td>
                    <td align="center" valign="middle" ><div style="display: none;" id="jiantou2">>>&nbsp;</div></td>
                    <td >
                        <select id="category3"  class="catselect" size="8"  name="category3" style="display:none"></select>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">


                <span>
                    <input  type="submit" class="btn btn-success" value="确&nbsp;认" onclick="change_category();"/></span>
                    <span>
                    <button type="button" class="btn btn-default mar-lr-1" data-dismiss="modal">关闭</button>
                    </span>


                    </td>
                </tr>
            </table>
        </form>
    </div>

    </div>

  </div>
</div>
</div>
  <!--{/if}-->
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

<!-- 微信分享 -->
<div class="modal share-wechat animated" style="display: none;"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" data-dismiss="modal" class="close">×</button></div> <div class="modal-body"><h5>打开微信“扫一扫”，打开网页后点击屏幕右上角分享按钮</h5> <div data-url="{url question/answer/$qid/$aid}" class="qrcode" title="{url question/answer/$qid/$aid}"><canvas width="170" height="170" style="display: none;"></canvas>
<div id="qr_wxcode">
</div></div></div> <div class="modal-footer"></div></div></div></div>

<!-- 设置付费金额 -->
<div class="modal pay-money animated" style="display: none;">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">

<button type="button" data-dismiss="modal" class="close">×</button>
</div>
<div class="modal-body">
<h5>付费偷看金额在0.1-10元之间</h5>
<div class="mar-t-1">

<input type="number" value="0" id="chakanjine" class="form-control" />

</div>
 <button id="comfirm_pay" class="btn btn-success mar-t-1">确定</button>
</div>
 <div class="modal-footer">

 </div>
 </div>
 </div>
 </div>

 <!-- 邀请回答 -->

<div class="modal fade" id="dialog_invate" >
<div class="modal-dialog" style="width:700px;top:-30px;">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
      <h4 class="modal-title"></h4>
       <div class="m_invateinfo">
              <span class="m_i_text""> 您已邀请<span class="m_i_persionnum">0</span>人回答</span>
       <span  data-toggle="popover" data-tip-class="popover-info" data-html="ture" data-placement="bottom" data-content="" title="我的邀请列表" class="m_i_view">查看邀请</span>

       <div class="m_i_warrper">
        <input data-qid="{$question['id']}" type="text" id="m_i_searchusertxt" class="m_i_search" placeholder="搜索你想邀请的人">
        <i class="fa fa-search"></i>
       </div>

       </div>
    </div>
    <div class="modal-body" >
     <!-- 邀请回答 -->
    <ul class="trigger-menu m_invate_tab" data-pjax-container="#list-container">
 <li class="active" data-qid="{$question['id']}" data-item="1"><a href="javascript:">擅长该话题的人</a></li>
<li class="" data-qid="{$question['id']}" data-item="2"><a href="javascript:"> 回答过该话题的人</a></li>
<li class="" data-qid="{$question['id']}" data-item="3"><a href="javascript:">我关注的人</a></li>

 </ul>
     <!-- 邀请回答列表 -->
       <div class="m_invatelist">
       </div>

    </div>

  </div>
</div>
</div>
  <script>
  getquestioncaozuo(1,{$question['id']});
  getquestioncaozuo(2,{$question['id']});
  getquestioncaozuo(3,{$question['id']});
  getquestioncaozuo(4,{$question['id']});
  $(".btnshowall").click(function(){
    $(".shortquestioncontent").toggle();
    $(".hidequestioncontent").toggle();
  });

//根据分类读取改分类下有回答的人
  function showeditor(){
$(".canwirteanswer").slideDown();
scrollTo(0,$('#showanswerform').offset().top-200);


  }


  <!--{if $setting['code_ask']}-->
  var needcode=1;
  <!--{else}-->
  var needcode=0;
    <!--{/if}-->
  var g_id = {$user['groupid']};
  var qid = {$question['id']};
  function listertext(){
  	 var _content=$("#anscontent").val();
  	 if(_content.length>0&&g_id!=1){

  		 $(".code_hint").show();
  	 }else{
  		 $(".code_hint").hide();
  	 }
  }
  {if $setting['mobile_localyuyin']==0}
  var mobile_localyuyin=0;
  {else}
  var mobile_localyuyin=1;
  {/if}
	//  var userAgent = window.navigator.userAgent.toLowerCase();
	//  $.browser.msie8 = $.browser.msie && /msie 8\.0/i.test(userAgent);
	 // if($.browser.msie8==true){
		//  var mobile_localyuyin=0;
	 // }
  var targetplay=null;
  function checktagsubmit(){
if(gettagsnum()<=0){
	alert("请设置标签");
	return false;
}
if(gettagsnum()>5){
    alert("最多添加5个标签");
    return false;
	}
	 var _tagstr=gettaglist();
	 $("#qtags").val(_tagstr);
	 
  }
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
  $(".yuyinplay").click(function(){
  	targetplay=$(this);
  	var _serverid=targetplay.attr("id");
  	   if(_serverid == '') {
  			alert('语音文件丢失');
             return;
         }
  	   $(".wtip").html("免费偷听");
  	   targetplay.find(".wtip").html("播放中..");
  	   if(mobile_localyuyin==1){
  		 $(".htmlview").removeClass("hide");
		   $(".ieview").addClass("hide");

  		   var myAudio =targetplay.find("#voiceaudio")[0];
  	  	  // myAudio.pause();
  	  	   //myAudio.play();
  	  	   if(myAudio.paused){
  	  		   targetplay.find(".wtip").html("播放中..");
  	             myAudio.play();
  	         }else{
  	      	   targetplay.find(".wtip").html("暂停..");
  	             myAudio.pause();
  	         }
  	  	   function endfun(){ targetplay.find(".wtip").html("播放结束");alert("播放结束!")}
  	  	   var   is_playFinish = setInterval(function(){
  	             if( myAudio.ended){

  	          	   endfun();
  	  	                    window.clearInterval(is_playFinish);
  	             }
  	     }, 10);
  	   }else{

  		 $(".ieview").removeClass("hide");
  		   $(".htmlview").addClass("hide");
  	   }




  })
function deleteanswer(current_aid){
	  if(confirm("是否删除此回答?")){
			window.location.href=g_site_url + "index.php" + query + "question/deleteanswer/"+current_aid+"/$question['id']";
			  
	  }

}
  function adoptanswer(aid) {

      $("#adopt_answer").val(aid);

      $('#dialogadopt').modal('show');
}
  //编辑标签
  function edittag() {
 	 $('#dialog_tag').modal('show');

 }
  if(typeof($(".show-content").find("img").attr("data-original"))!="undefined"){
		var imgurl=$(".show-content").find("img").attr("data-original");
		$(".show-content").find("img").attr("src",imgurl);
	}
	$(".show-content").find("img").attr("data-toggle","lightbox");

  var category1 = {$categoryjs[category1]};
  var category2 = {$categoryjs[category2]};
  var category3 = {$categoryjs[category3]};
  var selectedcid = "{$question['cid1']},{$question['cid2']},{$question['cid2']}";
  //修改分类
  function change_category() {
      var category1 = $("#category1 option:selected").val();
              var category2 = $("#category2 option:selected").val();
              var category3 = $("#category3 option:selected").val();
              if (category1 > 0) {
      $("#categoryid").val(category1);
      }
      if (category2 > 0) {
      $("#categoryid").val(category2);
      }
      if (category3 > 0) {
      $("#categoryid").val(category3);
      }
      $("#catedialog").model("hide");
              $("form[name='editcategoryForm']").submit();
      }
  //投诉
  function openinform(qid ,qtitle,aid) {
	  $("#myqid").val(qid);
	  $("#myqtitle").val(qtitle);
	  $("#myaid").val(aid);
 	 $('#dialog_inform').modal('show');

 }
  $(".showcommentid").each(function(){
       var dataid=$(this).attr("data-id");
       show_comment(dataid);
  });
  function show_comment(answerid) {
      if ($("#comment_" + answerid).css("display") === "none") {
      load_comment(answerid);
              $("#comment_" + answerid).slideDown();
      } else {
      $("#comment_" + answerid).slideUp();
      }
      }
  //添加评论
  function addcomment(answerid) {
  var content = $("#comment_" + answerid + " input[name='content']").val();
  var replyauthor = $("#comment_" + answerid + " input[name='replyauthor']").val();
  if (g_uid == 0){
      login();
      return false;
  }
  if (bytes($.trim(content)) < 5){
  alert("评论内容不能少于5字");
          return false;
  }
  $.ajax({
  type: "POST",
          url: "{url answer/addcomment}",
          data: "content=" + content + "&answerid=" + answerid+"&replyauthor="+replyauthor,
          success: function(status) {
          if (status == '1') {
          $("#comment_" + answerid + " input[name='content']").val("");
                  load_comment(answerid);
          }else{
          	if(status == '-2'){
          		alert("问题已经关闭，无法评论");
          	}
          }
          }
  });
  }
  
  //删除评论
  function deletecomment(commentid, answerid) {
  if (!confirm("确认删除该评论?")) {
  return false;
  }
  $.ajax({
  type: "POST",
          url: "{url answer/deletecomment}",
          data: "commentid=" + commentid + "&answerid=" + answerid,
          success: function(status) {
          if (status == '1') {
          load_comment(answerid);
          }
          }
  });
  }
  //加载评论
  function load_comment(answerid){
  $.ajax({
  type: "GET",
          cache:false,
          url: "{SITE_URL}index.php?answer/ajaxviewcomment/" + answerid,
          success: function(comments) {
          $("#comment_" + answerid + " .my-comments-list").html(comments);
          }
  });
  }

  function replycomment(commentauthorid,answerid){
      var comment_author = $("#comment_author_"+commentauthorid).attr("title");
      $("#comment_"+answerid+" .comment-input").focus();
      $("#comment_"+answerid+" .comment-input").val("回复 "+comment_author+" :");
      $("#comment_" + answerid + " input[name='replyauthor']").val(commentauthorid);
  }
	$(function(){
		  initcategory(category1);
          fillcategory(category2, $("#category1 option:selected").val(), "category2");
          fillcategory(category3, $("#category2 option:selected").val(), "category3");
        	var qrurl="{url question/answer/$qid/$aid}";
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
	  
	     $(".button_agree").click(function(){
             var supportobj = $(this);
                     var answerid = $(this).attr("id");
                     $.ajax({
                     type: "GET",
                             url:"{SITE_URL}index.php?answer/ajaxhassupport/" + answerid,
                             cache: false,
                             success: function(hassupport){
                             if (hassupport != '1'){






                                     $.ajax({
                                     type: "GET",
                                             cache:false,
                                             url: "{SITE_URL}index.php?answer/ajaxaddsupport/" + answerid,
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

	})


                </script>
<!--{template footer}-->