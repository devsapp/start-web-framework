<!--{template header}-->
<script>
var _qtitle="{$question['title']}";

var _qcontent="  {eval    echo str_replace('&nbsp;','',replacewords(strip_tags($question['description'])));    }";


//var imgurl="{$question['author_avartar']}";
var imgurl="{SITE_URL}static/css/images/wen.png";
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
   left:38px;
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
    <article class="article">
        <h1 class="title">{$question['title']}</h1>
        <div class="article-info ui-clear">

            <ul class="ui-row">

                <li class="ui-col ui-col-75">

  <a href="{url user/space/{$question['authorid']}}">
                     <span class="ui-avatar-s">
                     
                         <span style="background-image:url({$question['author_avartar']})"></span>
                        
                     </span>
  </a>
                    <span class=" u-name">
                    
                    <a class="ui-txt-highlight ui-nowrap" href="{url user/space/{$question['authorid']}}">
                   
                    {$question['author']}
                    </a>
                    </span>
                   

                </li>
                <li id="attentquestion" class="ui-col ui-col-25    <!--{if $is_followed}-->button_attention  <!--{/if}-->" onclick="attentto_question({$question['id']})">
                  <!--{if $is_followed}-->
                   <div class="q-follower ">
                         <i class="ui-icon-success-block"></i>
                       <span class="q-follower-txt">
                             已关注
                       </span>
                   </div>
                     <!--{else}-->
                    <div class="q-unfollower ">
                        <i class="ui-icon-add"></i>
                       <span class="q-follower-txt">
                             关注
                       </span>
                    </div>
                        <!--{/if}-->
                </li>

            </ul>

 <span class="ui-nowrap  " style="margin-top:1rem"> 发布时间:{$question['format_time']}</span>

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
    </article>

    <!--回答-->
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
            
               <!--{if $bestanswer['id']>0}-->
                <div class="answer-item">
                          <ul class="ui-row">
                              <li class="ui-col ui-col-80">
                                <a href="{url user/space/{$bestanswer['authorid']}}">
                                  <span class="ui-avatar-s">
                                 
                         <span style="background-image:url({$bestanswer['author_avartar']})"></span>
                        
                     </span> </a>

                                  <span class=" u-name">
                                    <a class="ui-txt-highlight" href="{url user/space/{$bestanswer['authorid']}}">
                                  {$bestanswer['author']}
                                  </span>
                                  </a>
                            
                              </li>
                              <li class="ui-col ui-col-20 ui-align-right"  >
                                  <span class="btn-agree" id='{$bestanswer['id']}'>
                                      <i class="ui-icon-like"></i>
                                       <span class="agree-num button_agre">{$bestanswer['supports']}</span>
                                  </span>
                              </li>
                          </ul>
                    <div class="ans-content">
                    {if $bestanswer['serverid']==null}
                         {eval    echo replacewords($bestanswer['content']);    }
                    {else}
                    <div class="yuyinplay" id="{$bestanswer['serverid']}">
                     <i class="ui-icon-voice" ></i><span class="u-voice"><span class="wtip">免费偷听</span>&nbsp;{$bestanswer['voicetime']}秒</span>
                    </div>
                    {/if}
  
         <div class="appendcontent font-12">
                    <!--{loop $bestanswer['appends'] $append}-->       
                    <div class="appendbox">
                        <!--{if $append['authorid']==$bestanswer['authorid']}-->
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
                        <ul class="ui-row">
                            <li class="ui-col ui-nowrap ui-whitespace {if $signPackage!=null} ui-col-33 {else}  ui-col-50{/if} ui-txt-muted ans-time">
                          
                                          {$bestanswer['format_time']}
                            </li>
                            <li onclick="show_comment('{$bestanswer['id']}');" class=" ui-col  {if $signPackage!=null} ui-col-33 {else}  ui-col-50{/if}  ui-txt-muted">
                                <i class="ui-icon-comment"></i>
                                <span class="ans-comment-num ">
                                    {$bestanswer['comments']}条评论
                                </span>
                            </li>
                            
                           
                            </ul>
                        <div class="ans-footer-comment" id="comment_{$bestanswer['id']}" style="display: none;">


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
                                            <button name="submit" onclick="addcomment({$bestanswer['id']});" class="ui-btn f-btn-comment">
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
      
        
        
     
<div class="ui-btn-wrap">
    <button onclick="window.location.href='{url question/view/$qid}'" class="ui-btn-lg ui-btn-danger">
        查看其它回答
    </button>
</div>

    </section>
  




{if $signPackage!=null}
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"> </script>

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
        'startRecord',
        'stopRecord',
        'onVoiceRecordEnd',
        'playVoice',
        'pauseVoice',
        'stopVoice',
        'onVoicePlayEnd',
        'uploadVoice',
        'downloadVoice'
        
      ]
  });
</script>

<script>

wx.ready(function () {
    wx.checkJsApi({
	      jsApiList: [
	        'getNetworkType'
	       
	      ],
	      success: function (res) {
	       // alert(JSON.stringify(res));
	      }
	    });
    
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
    var targetplay=null;
    $(".yuyinplay").click(function(){
    	targetplay=$(this);
    	var _serverid=$(this).attr("id");
    	   if(_serverid == '') {
    			 el2=$.tips({
    		         content:'语音文件丢失',
    		         stayTime:2000,
    		         type:"info"
    		     });
               return;
           }
    	   targetplay.find(".wtip").html("播放中..");
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
    })
    document.querySelector('#btncaozuo').onclick = function () {
    	console.log("ok");
    	if(record.openid==''){
    		 el2=$.tips({
		         content:'无法识别您的身份',
		         stayTime:2000,
		         type:"info"
		     });
    		return;
    	}
    	
    	if( record.recording==1){
    		record.recording=0;
    		  wx.stopRecord({
                  success: function (res) {
                	  if(listenvoice!=null){
                		  clearInterval(listenvoice);
                	  }
                	 
                	  record.voicetime=voicetime;
                	  voicetime=0;
                      record.localId = res.localId;
                      $(".luyin h4").html('录音结束，可以点击试听！');
                      $('#btncaozuo').html("录音");
                      $('#btncaozuo').val("录音");
                  }
              });
    	}else{
    		   $(".luyin h4").html('录音中...');
    		   $('#btncaozuo').html("停止录音");
    	        $('#btncaozuo').val("停止录音");
    	        record.recording=1;
    	        wx.startRecord();
    	        listenvoice=setInterval(function(){
    	        	voicetime++;
    	        	$(".luyin h4").html('录音中...'+voicetime+"秒");
    	        },1000);
    	}
     
    };
    wx.onVoiceRecordEnd({
        complete: function (res) {
        	  if(listenvoice!=null){
        		  clearInterval(listenvoice);
        	  }
        	record.recording=0;
        	  record.voicetime=voicetime;
        	  voicetime=0;
            record.localId = res.localId;
            $(".luyin h4").html('录音结束，可以点击试听！');
            $('#btncaozuo').html("录音");
            $('#btncaozuo').val("录音");
        }
    });
    wx.onVoicePlayEnd({
        success: function (res) {
        	 targetplay.find(".wtip").html("试听结束");
            //record.localId = res.localId; // 返回音频的本地ID
             record.playing=0;
        	 $('#btnbofang').html("试听");
             $('#btnbofang').val("试听");
        	   $(".luyin h4").html('试听结束！');
            record.playing=0;
        	 el2=$.tips({
		         content:'试听结束!',
		         stayTime:2000,
		         type:"success"
		     });
        }
    });
    document.querySelector('#btnbofang').onclick = function() {
        if(record.localId == '') {
        	 el2=$.tips({
		         content:'您还没录音',
		         stayTime:2000,
		         type:"info"
		     });
            return;
        }
        if(record.playing==0){
        	 record.playing=1;
             $(".luyin h4").html('试听中...');
             $('#btnbofang').html("停止试听");
             $('#btnbofang').val("停止试听");
             wx.playVoice({
                 localId: record.localId
             });
        }else{
        	 record.playing=0;
        	 $('#btnbofang').html("试听");
             $('#btnbofang').val("试听");
        	   $(".luyin h4").html('试听结束！');
             wx.stopVoice({
                 localId: record.localId
             });
        }
       
    };
    document.querySelector('#btnfabu').onclick = function() {
        if(record.localId == '') {
        	 el2=$.tips({
		         content:'您还没录音',
		         stayTime:2000,
		         type:"info"
		     });
            return;
        }
       var postvoiceurl='{SITE_URL}?question/postmedia';
       //如果录音大于60秒，就重置为60
       if(record.voicetime>=60){
    	   record.voicetime=60;
       }
        wx.uploadVoice({
            localId: record.localId,
            isShowProgressTips: 1,
            success: function (res) {
                record.serverId = res.serverId;
        
                $.getJSON(postvoiceurl,{voicetime:record.voicetime,qid:record.qid,openid:record.openid, media_id:record.serverId}, function(data) {
                    if(data.message=='ok'){
                    	 el2=$.tips({
            		         content:'发布成功!',
            		         stayTime:2000,
            		         type:"success"
            		     });
                    	 window.location.reload();
                    }else{
                   	 el2=$.tips({
        		         content:data.message,
        		         stayTime:2000,
        		         type:"success"
        		     });
                    }
                        
                });
            }
        });
    };
    wx.onMenuShareAppMessage({
    	 title: _qtitle,
	      desc: _qcontent,
	      link: "{url question/view/$question['id']}",
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
	       // alert(JSON.stringify(res));
	      }
	    });
    wx.onMenuShareTimeline({
    	 title: _qtitle,
	    
	      link:"{url question/view/$question['id']}",
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
    wx.onMenuShareQQ({
    	 title: _qtitle,
	      desc: _qcontent,
	      link:"{url question/view/$question['id']}",
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
	      //  alert('已取消');
	      },
	      fail: function (res) {
	       // alert(JSON.stringify(res));
	      }
	    });
    wx.onMenuShareWeibo({
    	 title: _qtitle,
	      desc: _qcontent,
	      link:"{url question/view/$question['id']}",
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

{if $openId==null}	
var canyuyin=0;
{else}
var canyuyin=1;
{/if}
$(".cancelpop").tap(function(){
	 $('.ui-actionsheet').removeClass('show').addClass('hide');
})
$("#comment-note,#btnanswer").tap(function(){
	if(canyuyin){
		  $('.ui-actionsheet').removeClass('hide').addClass('show');
	}else{
		  var dia2=$(".dialogcomment").dialog("show");
		  
		    $(".dialogcomment .ui-icon-close").tap(function(){
		    	$(".dialogcomment").dialog("hide");
		    })
	}
  
});
$(".voiceanswer").tap(function(){
	  $('.ui-actionsheet').addClass('hide');
	  var luyin=$(".luyin").dialog("show");
	  luyin.on("dialog:action",function(e){
	        console.log(e.index);
	      
	    });
});
$(".textanswer").tap(function(){
	  $('.ui-actionsheet').addClass('hide');
	var dia2=$(".dialogcomment").dialog("show");
	  
    $(".dialogcomment .ui-icon-close").tap(function(){
    	$(".dialogcomment").dialog("hide");
    })
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
                          
                            window.location.href="{url user/login}";
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
                                url: "{url answer/addcomment}",
                                data: "content=" + content + "&answerid=" + answerid+"&replyauthor="+replyauthor,
                                success: function(status) {
                                if (status == '1') {
                                $("#comment_" + answerid + " input[name='content']").val("");
                                        load_comment(answerid);
                                        return false;
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
                                url: "{url answer/deletecomment}",
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