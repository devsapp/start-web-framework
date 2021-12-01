<!--{template header}-->
 {eval $hidefooter=true;}


<script>
var _qtitle="{$seo_title}";
{if 0!=$question['shangjin']}
_qtitle=_qtitle+"-【现金悬赏{$question['shangjin']}元】";
{/if}
	{eval $miaosu=$seo_description;}
	 {eval $miaosu=cutstr(str_replace('&nbsp;','',$miaosu),200,'...');}
	 {eval $miaosu=str_replace('"', '', $miaosu);}
	 {eval $miaosu=str_replace('“', '', $miaosu);}
	 {eval $miaosu=str_replace('”', '', $miaosu);}
	 var _qcontent="{eval echo trim($miaosu);}";
//var imgurl="{$question['author_avartar']}";
var imgurl="{$useranswer['author_avartar']}";

</script>

<style>
.yuyinplay{
	background:#41c074;
    width:180px;
    height:30px;
line-height:30px;
    border-radius:50px;
    text-align:center;
color:#fff;
  position:relative;

}
.ui-icon-voice{
	color:#fff;
    font-size:22px;
    position:relative;
    float:left;
     margin-left:10px;
     top:-8px;
}
.u-voice{
	color:#fff;

   font-size:13px;
    float:right;
     margin-right:10px;

}
.wtip{
	font-size:13px;
}
</style>

<section class="ui-container ">
           <div class="works-tag-wrap">
                       
                            
                              
                             <!--{if $taglist}-->
                                       <!--{loop $taglist $tag}-->

  <a href="{url tags/view/$tag['tagalias']}" title="{$tag['tagname']}" class="project-tag-14">{$tag['tagname']}</a>
                           
               
                <!--{/loop}--><!--{else}--><!--{/if}-->
                
                           
                        </div>
    <article class="article">
        <h1 class="title">{$question['title']}</h1>
        <div class="article-info ui-clear">

                         <!-- cdn节点  提问者信息 -->
			 <div class="cdn_question_userinfo"></div>
			  <script type="text/javascript">
getquestioncaozuo(3,{$question['id']});
</script>

 <span class="ui-nowrap  " style="margin-top:1rem"> 发布时间:{$question['format_time']}</span>
   {if $question['price']>0}    
                      <span   class="ui-nowrap mydatabase"><i class="fa fa-database mar-r-03"></i>财富值{$question['price']}</span>
  {/if}
 	<!-- cdn节点 问题操作 -->
						<span class="cdn_question_caozuo"></span>
  
  <script type="text/javascript">
getquestioncaozuo(2,{$question['id']});
</script>
        </div>
        <div class="article-content">
         <div class="ask_detail_content_text qyer_spam_text_filter">
                   {eval    echo replacewords($question['description']);    }
                   <!--{if $supplylist}-->
                       <ul class="nav">
                    <!--{loop $supplylist $supply}-->
                    <li><span class="time buchongtime">问题补充 : {$supply['format_time']}</span>
                      {eval    echo replacewords($supply['content']);    }

                    </li>
                    <!--{/loop}-->
                </ul>
                <!--{/if}-->

                    </div>
        </div>
                       <script type="text/javascript">
            {if $openId==null || PHP_OS=='WINNT'}
            var canyuyin=0;
            {else}
            var canyuyin=1;
            {/if}
            </script>
        	   <!-- cdn节点 问题操作按钮 -->
                        <div class="cdn_question_button"></div>
                        
            
                   <script type="text/javascript">
getquestioncaozuo(4,{$question['id']});
</script>
    </article>
       <!--{if 0!=$question['shangjin']}-->
      <div style="background-color: #867775;    border-radius: .15em;color:#fff;font-size:15px;padding:.05rem .85em;margin:0 .85em;margin-top:20px;">此问题作者打赏 <span style="font-size:15px;">$question['shangjin']</span> 元，如果回答被采纳将会将赏金放入您平台账户钱包，您可以提现到微信零钱里。</div>
          <!--{/if}-->
 
    <!--回答-->
     <div class="answerbox" style="margin-top: 40px;display:none;">

     {if $iswxbrower==null&&$setting['code_ask']&&$user['credit1']<$setting['jingyan']}
    <div  id="codetip" class=" " style="color:#777;font-size:12px;position:relative;bottom:35px;left:10px;">验证码不能为空</div>
      {/if}
      <div class="commentboard" style="background:#fff;position:relative;bottom:0px;left:0px;z-index:99999999;height:auto;width:100%;">

        <form id="huidaform"  name="answerForm"  method="post" >
       <input type="hidden" value="{$qid}" id="ans_qid" name="qid">
                <input type="hidden" value="{$question['title']}" id="ans_title" name="title">

     <div  style="border-radius:5px;width:100%;hegiht:300px;position:relative;bottom:50px;left:0px;border:none;padding-top:10px;">
      <!--{template editor}-->
     </div>

    <div class="" style="position:relative;top:-22px;margin-right:12px;">

             {if 1==$setting['openwxpay'] }
     <div class="showpaybox" style="text-align:right;display:none;">
      <input type="text"  id="chakanjine" placeholder="偷看支付金额0.1-10元" style="font-size:12px;width:160px;height:20px;position:relative;bottom:10px;left:0px;"/>
       </div>
          {/if}
               {if $iswxbrower==null&&$setting['code_ask']&&$user['credit1']<$setting['jingyan']}
             <div class="" style="position:relative;top:-10px;text-align:right;margin-top:20px;">

     <input type="text"  id="code" name="code" onblur="check_code();" placeholder="输入验证码"  style="font-size:15px;border:none;width:100px;hegiht:30px;position:relative;border: solid 1px #ccc;    outline: none;">
     <img class="hand" src="{url user/code}" onclick="javascript:updatecode();" id="verifycode" style="width:50px;position:relative;top:5px;">

    </div>
       {/if}
    <div class="" style="margin-top:20px;text-align: right;padding:0px;">
    <span style="color:#fb785e;" onclick="$('.showpaybox').toggle()">￥设置偷看金额</span>
       <input type="hidden" id="tokenkey" name="tokenkey" value='{$_SESSION["answertoken"]}'/>
     <button  type="button" id="answsubmit" class="ui-btn ui-btn-primary" style="position:relative;bottom:10px;">
        确定
    </button>
    </div>
</div>
    </form>
     </div>
    </div>
    <section class="answerlist">
     <div class="ans-title">
       {if $question['answers']==0}
         <span>还没有小伙伴回答Ta的问题哟</span>
       {else}
         <span>{$question['answers']}个回答</span>
       {/if}

     </div>
        <div class="answers">
            <div class="answer-items">

               <!--{if $useranswer['id']>0}-->
                <div class="answer-item">
                          <ul class="ui-row">
                           {if $question['authorid']==$useranswer['authorid']&&$question['hidden']==1}
                              <li class="ui-col ui-col-80">
                                <a href="javascript:">
                                  <span class="ui-avatar-s">

                         <span style="background-image:url({SITE_URL}static/css/default/avatar.gif)"></span>

                     </span> </a>

                                  <span class=" u-name">
                                    <a class="ui-txt-highlight" href="javascript:">
                                   匿名用户  </a>
                                </span>

                           {if $useranswer['adopttime']>0}   <i class="ui-icon-collected"></i>{/if}
                              </li>
                              {else}
                                             <li class="ui-col ui-col-80">
                                <a href="{url user/space/{$useranswer['authorid']}}">
                                  <span class="ui-avatar-s">

                         <span style="background-image:url({$useranswer['author_avartar']})"></span>

                     </span> </a>

                                  <span class=" u-name">
                                    <a class="ui-txt-highlight" href="{url user/space/{$useranswer['authorid']}}">
                                  {$useranswer['authorname']}
                                   {if $useranswer['author_has_vertify']!=false}<i class="fa fa-vimeo {if $useranswer['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  " data-toggle="tooltip" data-placement="right" title=""  ></i>{/if}
                                  </span>
                                  </a>
                                 {if $useranswer['adopttime']>0}   <i class="ui-icon-collected"></i>{/if}
                              </li>
                              {/if}

                              <li class="ui-col ui-col-20 ui-align-right"  >
                                  <span class="btn-agree" id='{$useranswer['id']}'>
                                      <i class="ui-icon-like"></i>
                                       <span class="agree-num button_agre">{$useranswer['supports']}</span>
                                  </span>
                              </li>
                          </ul>
                    <div class="ans-content" style="max-height: 5000px">
                  
                 
                    {if $useranswer['serverid']==null}
                         {if $useranswer['reward']==0||$useranswer['authorid']==$user['uid']}
                             {eval    echo replacewords($useranswer['content']);    }
                               {else}
                                 {eval if($question['authorid']==$user['uid']) $useranswer['canview']=1;}
                               {if $useranswer['canview']==0}
                                 <div class="box_toukan ">

											{if $user['uid']==0}
											<a href="{url user/login}" data-placement="top" title="" data-toggle="tooltip" data-original-title="我也付费偷偷看" class="thiefbox" onclick=""><i class="ui-icon-cart"></i> &nbsp;精彩回答&nbsp;$useranswer['reward']&nbsp;&nbsp;元偷偷看……</a>
											{else}
											<a onclick="viewanswer($useranswer['reward'],$useranswer['id'])" data-placement="top" title="" data-toggle="tooltip" data-original-title="我也付费偷偷看" class="thiefbox" onclick=""><i class=" ui-icon-cart"></i> &nbsp;精彩回答&nbsp;$useranswer['reward']&nbsp;&nbsp;元偷偷看……</a>
											{/if}


										</div>
                               {else}
                              
                                 {eval    echo replacewords($useranswer['content']);    }
                               {/if}

                               {/if}
                    {else}
                    <div class="yuyinplay" id="{$useranswer['serverid']}">
                     <i class="ui-icon-voice" ></i><span class="u-voice">
                   <span class="wtip">免费偷听</span>

                     &nbsp;{$useranswer['voicetime']}秒</span>
                     <audio id="voiceaudio" width="420" style="display:none">
    <source src="{SITE_URL}data/weixinrecord/{$useranswer['mediafile']}" type="audio/mpeg" />

</audio>
                    </div>
                    {/if}

         <div class="appendcontent font-12">
                    <!--{loop $useranswer['appends'] $append}-->
                    <div class="appendbox">
                        <!--{if $append['authorid']==$useranswer['authorid']}-->
                        <h4 class="appendanswer font-12">回答:<span class="time">{$append['format_time']}</span></h4>
                        <!--{else}-->
                        <h4 class="appendask font-12">作者追问:<span class='time'>{$append['format_time']}</span></h4>
                        <!--{/if}-->
                          <div class="zhuiwentext">

                         {eval    echo replacewords($append['content']);    }
                                      </div>
                    <div class="clr"></div>
                    </div>
                    <!--{/loop}-->
                </div>
                    </div>
                     
                    <div class="ans-footer">
                     <!-- cdn节点 回答操作 -->
													<div class="cdn_question_answer{$useranswer['id']}"></div>
													<script type="text/javascript">
													  getquestioncaozuo(5,{$useranswer['qid']},{$useranswer['id']});
													</script>
                        <div class="ans-footer-comment" id="comment_{$useranswer['id']}" style="display: none;">


                            <ul class="comments-list nav">
                                <li class="loading">

    <i class="ui-loading"></i>
                        </li>
                            </ul>
                            <div class="ui-form ui-border-t">

                                    <ul class="ui-row">
                                        <li class="ui-col ui-col-80">
                                            <div class="ui-form-item ui-form-item-pure ui-border-b f-txt-comment">
                                             <input  type='hidden' value='0' name='replyauthor' />
                                                <input name="content" class="comment-input" type="text" placeholder="请输入评论内容，不少于2个字">
                                                <a href="#" class="ui-icon-close"></a>

                                            </div>
                                        </li>
                                        <li class="ui-col ui-col-20">
                                            <button name="submit" onclick="addcomment({$useranswer['id']});" class="ui-btn f-btn-comment">
                                                评论
                                            </button>
                                        </li>


                                    </ul>


                            </div>
                        </div>
                    </div>
                </div>


                  <!--{/if}-->
              
            </div>
        </div>


         <!--{if 9!=$question['status']  }-->
 {if $question['answers']>1}
 <div class="ui-btn-wrap">
    <button onclick="window.location.href='{url question/view/$qid}'" class="ui-btn-lg ui-btn-danger">
     查看其它{$question['answers']}个回答
    </button>
</div>
{/if}
   <!--{else}-->
<div class="ui-tooltips ui-tooltips-guide">
    <div class="ui-tooltips-cnt  ui-border-b">
        <i class="ui-icon-talk"></i>该问题目前已经被关闭, 无法添加新回复
    </div>
</div>
      
       <!--{/if}-->
    </section>
    <section class="article-jingxuan ui-panel">
        <h2 class="ui-txt-warning">相关问题</h2>
<div class="split-line"></div>
 
      <div class="stream-list question-stream xm-tag tag-nosolve">

  <!--{loop $solvelist $question}-->
   {if $qid!=$question['questionid']}
      <section class="stream-list__item">
       {if $question['status']==2}
                <div class="qa-rank"><div class="answers answered solved ml10 mr10">
                {$question['answers']}<small>解决</small></div></div>     
                {else}
                {if $question['answers']>0}
                <div class="qa-rank"><div class="answers answered ml10 mr10">
                $question['answers']<small>回答</small></div>
                </div>
                   {else}
                   <div class="qa-rank"><div class="answers ml10 mr10">
                0<small>回答</small></div></div>
                {/if}
                
                
                {/if}
                   <div class="summary">
            <ul class="author list-inline">
                                           
                                                <li class="authorinfo">
                                          {if $question['hidden']==1}
                                            匿名用户
                      
                       {else} 
                              <a href="{url user/space/$question['authorid']}">
                          {$question['author']}{if $question['author_has_vertify']!=false}<i class="fa fa-vimeo {if $question['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  " ></i>{/if}
                          </a>
                      
                         {/if} 
                       
                        <span class="split"></span>
                        <a href="{url question/view/$question['questionid']}">{$question['format_time']}</a>
                                    </li>
            </ul>
            <h2 class="title"><a href="{url question/view/$question['questionid']}">{$question['title']}</a></h2>
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
    {/if}
    <!--{/loop}-->
  
    
      
      </div>
  
    </section>


     
</section>

<div class="ui-dialog" id="dialogadopt">
    <div class="ui-dialog-cnt">
      <header class="ui-dialog-hd ui-border-b">
                  <h3>采纳回答</h3>
                  <i class="ui-dialog-close" data-role="button"></i>
              </header>

        <div class="ui-dialog-bd">


        <input type="hidden"  value="{$qid}" id="adopt_qid" name="qid"/>
        <input type="hidden" id="adopt_answer" value="0" name="aid"/>
        <table  class="table ">
            <tr valign="top">
                <td class="small_text">向帮助了您的知道网友说句感谢的话吧!</td>
            </tr>
            <tr>
                <td>
                    <div class="inputbox mt15">
                        <textarea class="adopt_textarea" id="adopt_txtcontent"  name="content">非常感谢!</textarea>
                    </div>
                </td>
            </tr>

        </table>

            <button  id="adoptbtn"  class="ui-btn ui-btn-primary">
       采纳
    </button>


        </div>


    </div>
</div>
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

<script>


var adoptsubmit=false;
$("#adoptbtn").click(function(){
	var _adopt_txtcontent=$.trim($("#adopt_txtcontent").val());
	if(_adopt_txtcontent==''){
		alert("采纳回复不能为空!");
		return false;
	}
	  var data={
    			content:_adopt_txtcontent,
    			qid:$("#adopt_qid").val(),
    			aid:$("#adopt_answer").val()

    	}
		if(adoptsubmit==true){
			
			return false;
		}

	  adoptsubmit=true;
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
	    	   $("#adoptbtn").attr("disabled",true);
	    	   adoptsubmit=true;
	    	   alert("采纳成功!");

	    	   setTimeout(function(){
	               window.location.reload();
	           },1500);
	       }else{
	    	   adoptsubmit=false;
	    	   alert(data.message);

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


<script src="https://res.wx.qq.com/open/js/jweixin-1.4.0.js"> </script>
{if $signPackage!=null}


<script type="text/javascript">

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
        'startRecord',
        'stopRecord',
        'onVoiceRecordEnd',
        'playVoice',
        'pauseVoice',
        'stopVoice',
        'onVoicePlayEnd',
        'uploadVoice',
        'hideMenuItems',
        'downloadVoice'
      ]
  });



wx.ready(function () {
	var record = {
	        localId: '',
	        serverId: '',
	        recording:0,
	        playing:0,
	        voicetime:0,
	        qid:'{$qid}',
	        openid:'{$openId}'
	    };
	var voicetime=0,listenvoice=null;

	wx.hideMenuItems({
	    menuList: ['menuItem:copyUrl','menuItem:openWithQQBrowser','menuItem:openWithSafari','menuItem:originPage','menuItem:share:email']
	});

    //alert("ok")


    wx.updateAppMessageShareData({
    	 title: _qtitle,
	      desc: _qcontent,
	      link:"{url question/answer/$qid/$aid}",
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
    	 title: _qtitle,

    	 link:"{url question/answer/$qid/$aid}",
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
   	 title: _qtitle,
	      desc: _qcontent,
	      link:"{url question/answer/$qid/$aid}",
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
    wx.onMenuShareTimeline({
      	 title: _qtitle,
   	      desc: _qcontent,
   	      link:"{url question/answer/$qid/$aid}",
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
    wx.onMenuShareQQ({
     	 title: _qtitle,
  	      desc: _qcontent,
  	      link:"{url question/answer/$qid/$aid}",
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
    wx.onMenuShareQZone({
    	 title: _qtitle,
 	      desc: _qcontent,
 	      link:"{url question/answer/$qid/$aid}",
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
    wx.onMenuShareWeibo({
    	 title: _qtitle,
	      desc: _qcontent,
	      link:"{url question/answer/$qid/$aid}",
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
//questioncaozuo
var current_aid=0;
var qid={$qid};
function adoptanswer() {

    $("#adopt_answer").val(current_aid);
    $('.ui-actionsheet').removeClass('show').addClass('hide');
    $('#dialogadopt').dialog('show');
}
function dashangta(_aid,_authorid,_jine){
	var posturl='{url question/ajaxdashangjine}';

	var _openid="{$openId}";
	var data={jine:_jine,openid:_openid,aid:_aid,authorid:_authorid};
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
						alert(res.err_desc);return false;
					}

				}
			);

	}

	ajaxpost(posturl,data,success);
}

var currend_aid=0;
var currend_authorid=0;
$("#dialogdashang .ui-label").click(function(){

	var _shangjin=$(this).attr("val");
	$("#text_shangjin").val(_shangjin);



})
	$("#btndashang").click(function(){
		if(currend_aid==0){
			alert("请选择需要打赏的回答")
			return false;
		}

		var _shangjin=$.trim($("#text_shangjin").val());
		if(_shangjin==''||_shangjin<0.1||_shangjin>100){
			alert("打赏金额必须在0.1-100元之间");
			return false;
		}
		dashangta(currend_aid,currend_authorid,_shangjin);

	})
//调用微信JS api 支付

function mobilebestcallpay(aid,authorid,jine)
{
	currend_aid=aid;
	currend_authorid=authorid;
	$("#dialogdashang").dialog("show");

}
function jixuhuida(){
	 window.location.href=g_site_url + "index.php" + query + "answer/append/$qid/"+current_aid;

}
function bianjiwenti(){
	window.location.href=g_site_url + "index.php" + query + "question/edit/"+qid;
}
function bianjihuida(){

	window.location.href=g_site_url + "index.php" + query + "question/editanswer/"+current_aid;

}
function jixuzhuiwen(){
	 window.location.href=g_site_url + "index.php" + query + "answer/append/$qid/"+current_aid;

}

function deleteanswer(){
	window.location.href=g_site_url + "index.php" + query + "question/deleteanswer/"+current_aid+"/$qid";

}
function show_oprate(aid){
	current_aid=aid;

	 $('.pingluncaozuo').removeClass('hide').addClass('show');
}
function show_questionoprate(){


	 $('.wenticaozuo').removeClass('hide').addClass('show');
}

function viewanswer(paymoney,_answerid){


	   var dia=$.dialog({
	        title:'<center>温馨提示</center>',
	        select:0,
	        content:'<center><p style="color:red;margin-top:5px;">此回答需要付费'+paymoney+'元</p></center>',
	        button:["确认支付","取消"]
	    });

	    dia.on("dialog:action",function(e){
	    	if(e.index==1){
	    		return false;
	    	}
	    	 $.ajax({
		 	        //提交数据的类型 POST GET
		 	        type:"POST",
		 	        //提交的网址
		 	        url:"{url question/postanswerreward}",
		 	        //提交的数据
		 	        data:{answerid:_answerid},
		 	        //返回数据的格式
		 	        datatype: "text",//"xml", "html", "script", "json", "jsonp", "text".

		 	        //成功返回之后调用的函数
		 	        success:function(data){

		 	        	data=$.trim(data);
		 	        	console.log(data)
		 	        	if(data==-2){
		 	        		alert('游客先登录!');
		 	        	}
		 	        	if(data==-1){
		 	        		alert('此问题不需要付费!');
		 	        	}
		 	        	if(data==2){
		 	        		alert('此问题您已经付费过了!');
		 	        	}
		 	        	if(data==0){
		 	        		alert('账户余额不足，先充值!');
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
{if $setting['mobile_localyuyin']==0}
var mobile_localyuyin=0;
{else}
var mobile_localyuyin=1;
{/if}
var targetplay=null;
$(".yuyinplay").click(function(){
	targetplay=$(this);
	var _serverid=targetplay.attr("id");
	   if(_serverid == '') {
			 el2=$.tips({
		         content:'语音文件丢失',
		         stayTime:2000,
		         type:"info"
		     });
           return;
       }
	   $(".wtip").html("免费偷听");
	   targetplay.find(".wtip").html("播放中..");
	   if(mobile_localyuyin==1){
		   var myAudio =targetplay.find("#voiceaudio")[0];

		   if(myAudio.paused){
			   targetplay.find(".wtip").html("播放中..");
	           myAudio.play();
	       }else{
	    	   targetplay.find(".wtip").html("暂停..");
	           myAudio.pause();
	       }
		   function endfun(){ targetplay.find(".wtip").html("播放结束");}
		   var   is_playFinish = setInterval(function(){
	           if( myAudio.ended){

	        	   endfun();
		                    window.clearInterval(is_playFinish);
	           }
	   }, 10);
	   }else{
		    wx.downloadVoice({
	           serverId: _serverid,
	           isShowProgressTips: 1,
	           success: function (res) {
	              var _localId = res.localId;

	               wx.playVoice({
	                   localId: _localId
	               });
	           }
	       });
	   }


})

</script>
<script>

{if $openId==null || PHP_OS=='WINNT'}
var canyuyin=0;
{else}
var canyuyin=1;
{/if}
$(".cancelpop").click(function(){
	 $('.ui-actionsheet').removeClass('show').addClass('hide');
})
$("#comment-note,#btnanswer,.btnwirteans").click(function(){
	if(g_uid==0){
return false;
	}
	if(canyuyin){
		  $('.huidacaozuo').removeClass('hide').addClass('show');
	}else{
		  var dia2=$(".answerbox").show();

	}

});
$(".voiceanswer").click(function(){
	  $('.ui-actionsheet').addClass('hide');
	  var luyin=$(".luyin").dialog("show");
	  luyin.on("dialog:action",function(e){
	        console.log(e.index);

	    });
});
$(".textanswer").click(function(){
	  $('.ui-actionsheet').addClass('hide');
	var dia2=$(".answerbox").show();

})
var submit=false;
$("#answsubmit").click(function(){
	 var _chakanjine=$.trim($("#chakanjine").val());
	 if(_chakanjine==''){
		 _chakanjine=0;
	 }
	  if(!isNaN(_chakanjine)){

	    }else{
	    	 _chakanjine=0;
	    }
	// var eidtor_content= $.trim($("#anscontent").val());
	 // 获取编辑器区域
        var _txt = editor.wang_txt;
     // 获取 html
        var eidtor_content =  _txt.html();
		if(eidtor_content==''){
			 el2=$.tips({
		         content:'回答不能为空',
		         stayTime:2000,
		         type:"info"
		     });
			 return false;
		}
	  <!--{if $setting['code_ask']}-->
	  var data={
			  tokenkey:$("#tokenkey").val(),
			  chakanjine:_chakanjine,
 			content:eidtor_content,
 			qid:$("#ans_qid").val(),
 			title:$("#ans_title").val(),
 			code:$("#code").val()
 	}
	    <!--{else}-->
		var data={
				 tokenkey:$("#tokenkey").val(),
				chakanjine:_chakanjine,
   			content:eidtor_content,
   			qid:$("#ans_qid").val(),
     			title:$("#ans_title").val()

   	}
	     <!--{/if}-->
		if(submit==true){
				
				return false;
			}

			submit=true;
	    	 var el='';
	$.ajax({
       //提交数据的类型 POST GET
       type:"POST",
       //提交的网址

       url:"{SITE_URL}index.php?question/ajaxanswer",
       //提交的数据
       data:data,
       //返回数据的格式
       datatype: "json",//"xml", "html", "script", "json", "jsonp", "text".
       //在请求之前调用的函数
       beforeSend:function(){
    	    el=$.loading({
    	        content:'加载中...',
    	    })
       },
       //成功返回之后调用的函数
       success:function(data){
    	    el.loading("hide");
       	var data=eval("("+data+")");
          if(data.message=='ok'||data.message.indexOf('成功')>=0){
        	  $("#answsubmit").attr("disabled",true);
        	  submit=true;
       	 el2=$.tips({
	            content:data.message,
	            stayTime:1000,
	            type:"info"
	        });
       	   setTimeout(function(){
                  window.location.reload();
              },1500);
          }else{
        	  submit=false;
       	el2=$.tips({
            content:data.message,
            stayTime:1000,
            type:"info"
        });
          }


       }   ,
       //调用执行后调用的函数
       complete: function(XMLHttpRequest, textStatus){
    	    el.loading("hide");
       },
       //调用出错执行的函数
       error: function(){
           //请求出错处理
       }
    });
	return false;
})
	 $(".btn-agree").click(function(){
                        var supportobj = $(this);
                                var answerid = $(this).attr("id");
                                var el='';
                                $.ajax({
                                type: "GET",
                                        url:"{SITE_URL}index.php?answer/ajaxhassupport/" + answerid,
                                        cache: false,
                                        beforeSend:function(){
                                    	    el=$.loading({
                                    	        content:'加载中...',
                                    	    })
                                       },
                                        success: function(hassupport){
                                        	 el.loading("hide");
                                        if (hassupport != '1'){






                                                $.ajax({
                                                type: "GET",
                                                        cache:false,
                                                        url: "{SITE_URL}index.php?answer/ajaxaddsupport/" + answerid,
                                                        success: function(comments) {

                                                        supportobj.find(".agree-num").html(comments);
                                                   	 el2=$.tips({
                                          	            content:'感谢支持',
                                          	            stayTime:1000,
                                          	            type:"success"
                                          	        });
                                                        }
                                                });
                                        }else{
                                        	 el2=$.tips({
                                 	            content:'您已赞过',
                                 	            stayTime:1000,
                                 	            type:"info"
                                 	        });
                                        }
                                        },
                                        //调用执行后调用的函数
                                        complete: function(XMLHttpRequest, textStatus){
                                     	    el.loading("hide");
                                        },
                                });
                        });
                        //添加评论
                        function addcomment(answerid) {

                        var content = $("#comment_" + answerid + " input[name='content']").val();

                        var replyauthor = $("#comment_" + answerid + " input[name='replyauthor']").val();

                        if (g_uid == 0){

                            window.location.href="{SITE_URL}index.php?user/login";
                           return false;
                        }
                        if (bytes($.trim(content)) < 5){

                        el2=$.tips({
            	            content:'评论内容不能少于5字',
            	            stayTime:1000,
            	            type:"info"
            	        });
                                return false;
                        }

                        $.ajax({
                        type: "POST",
                                url: "{SITE_URL}index.php?answer/addcomment",
                                data: "content=" + content + "&answerid=" + answerid+"&replyauthor="+replyauthor,
                                success: function(status) {
                                if (status == '1') {
                                $("#comment_" + answerid + " input[name='content']").val("");
                                        load_comment(answerid);
                                        return false;
                                }else{
                                	if(status == '-2'){

                                		 el2=$.tips({
                             	            content:"问题已经关闭，无法评论",
                             	            stayTime:1000,
                             	            type:"info"
                             	        });
                                	}
                                }
                                }
                        });
                        return false;
                        }

                        //删除评论
                        function deletecomment(commentid, answerid) {
                        if (!confirm("确认删除该评论?")) {
                        return false;
                        }
                        $.ajax({
                        type: "POST",
                                url: "{SITE_URL}index.php?answer/deletecomment",
                                data: "commentid=" + commentid + "&answerid=" + answerid,
                                success: function(status) {
                                if (status == '1') {
                                load_comment(answerid);
                                }
                                }
                        });
                        }
                        function load_comment(answerid){
                        $.ajax({
                        type: "GET",
                                cache:false,
                                url: "{SITE_URL}index.php?answer/ajaxviewcomment/" + answerid,
                                success: function(comments) {
                                $("#comment_" + answerid + " .comments-list").html(comments);
                                }
                        });
                        }
                        function show_comment(answerid) {

                            if ($("#comment_" + answerid).css("display") === "none") {
                            load_comment(answerid);
                                    $("#comment_" + answerid).css({"display":"block"});
                            } else {
                            $("#comment_" + answerid).css({"display":"none"});
                            }
                            }
                        function replycomment(commentauthorid,answerid){

                            var comment_author = $("#comment_author_"+commentauthorid).attr("title");

                            $("#comment_"+answerid+" .comment-input").focus();
                            $("#comment_"+answerid+" .comment-input").val("回复 "+comment_author+" :");
                            $("#comment_" + answerid + " input[name='replyauthor']").val(commentauthorid);
                        }


</script>

<!--{template footer}-->