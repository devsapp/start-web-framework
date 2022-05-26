<!--{template header}-->
<script>
var _qtitle="{$member['username']}";

{if $member['expert']==1}
_qtitle=_qtitle+"{if $member['signature']}:{$member['signature']}{/if}-【特邀专家】";
{/if}

	 var _qcontent="{eval echo clearhtml($member['introduction']);}";
var imgurl="{$member['avatar']}";

</script>
{if $member['expert']!=1}
<section class="ui-container">
<!--{template space_title}-->

   
    <section class="user-content-list">
            <div class="titlemiaosu">
            Ta的回答
            </div>
           <ul class="" style="padding:10px;">
   <!--{if $answerlist}-->
   
       <div class="stream-list question-stream ">
      <!--{loop $answerlist $question}-->
     
  
      <section class="stream-list__item">
        <div class="qa-rank"><div class="answers answered solved ml10 mr10">
                {$question['comments']}<small>评论</small></div></div> 
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
                        <a {if  !$question['hidden']} href="{url question/answer/$question['qid']/$question['id']}" {/if}>{$question['time']}</a>
                                    </li>
            </ul>
            <h2 class="title"><a {if  !$question['hidden']} href="{url question/answer/$question['qid']/$question['id']}" {/if}>{$question['title']}</a></h2>
 
                
              
                                   
                           
                                            </div>
    </section>

  
      
     
    <!--{/loop}-->
     </div>
      <!--{else}-->
       
            <div class="text">
            真不巧，作者还没回答任何问题~
          </div>
          <!--{/if}-->
                    
     
   


   
   

   


   
   

</ul>
  <div class="pages" >{$departstr}</div>    
    </section>
</section>
{else}
<section class="ui-container">
<header class="profile menuitem">
		<div class="avatar member">
			<span class=" head-v"> <img src="{$member['avatar']}" width="75" height="75" alt="奋斗">
			</span> 
			<br>{$member['username']} 
					<br><i>{$member['signature']}</i>
							<br><p>{$member['introduction']}</p>
				</div>
				 <!--{if $is_followed}-->

             	<span class="add-focus  button_attention btn-default following" onclick="attentto_user($member['uid'])" id="attenttouser_{$member['uid']}">
             	<i class="fa fa-check"></i><span>已关注</span>
             	</span>
             
          <!--{else}-->
     
            	<span class="add-focus button_attention btn-success follow" onclick="attentto_user($member['uid'])" id="attenttouser_{$member['uid']}">+关注</span>
             
               <!--{/if}-->
               
				
			</header>

</section>
<section class="my-favorite back-f">
		<a href="javascript:;" class="myasnwer">回答<span>{$member['answers']}</span></a>
		<a href="javascript:;" class="caina">采纳率<span>{eval echo $this->user_model->adoptpercent ( $member );}%</span></a>
		<a href="javascript:;" class="zan">获赞<span>{$member['supports']}</span></a>
	</section>
	
	<section class="questions back-f">
		<textarea placeholder="请输入问题" id="quicktitle" maxlength="80"></textarea>
		{if $member['mypay']>0}
	<a {if $user['uid']} id="asksubmit" {else}href="{url user/login}"{/if}>$member['mypay']元咨询</a>
		
		{else}
		
				<a {if $user['uid']} id="asksubmit" {else}href="{url user/login}"{/if}>免费咨询</a>
		
		{/if}
		   <input type="hidden" name="authoryue" id="authoryue" value="{echo $user['jine']/100;}"/>
            <input type="hidden" name="myseek" id="myseek" value=""/>
	</section>
	
		<section class="answerlists back-f">
	<h4 class="pl">
			<span>回答<font color="#ff7900">{$member['answers']}</font>个问题
			</span>{if $member['jine']}&nbsp;&nbsp;&nbsp;<span>共收入<font color="#ff7900">{eval echo $member['jine']/100;}</font>元 {/if}
			</span>&nbsp;&nbsp;&nbsp;<span>获得<font color="#ff7900">$member['credit2']</font>财富值
				</span>
		</h4>
		    <div class="whatsns_list" style="background:#F6F6F6">
		    
                       <!--{loop $answerlist $question}-->
                       
                        <div class="whatsns_listitem">
         <div class="l_title"><h2><a {if  !$question['hidden']} href="{url question/answer/$question['qid']/$question['id']}" {/if}>
      {$question['title']}{if $question['price']}<label class="tit-money">奖励$question['price']财富值</label>{/if}{if $question['shangjin']}
              
                  <span  class="icon_hot"><i class="fa fa-hongbao mar-r-03"></i>悬赏$question['shangjin']元</span>
               
                {/if}</a></h2></div>

       <div class="whatsns_content" style="margin-top: 10px;">
  
 

 
 
        {if  !$question['hidden']} 
 <div class="whatsns_des" >
 {if !$question['reward']}
 <span class="mtext" >{$question['content']}</span>
  <div class="whatsns_readmore" onclick="window.location='{url question/answer/$question['qid']/$question['id']}'" >查看更多<i class="fa fa-angle-down"></i></div>
 
 {else}
  <span class="mtext">
  <a class="thiefbox font-12" target="_self"><i class="fa fa-lock font-12"></i> &nbsp;{$question['reward']}元查看回答</a>
  </span>
  {/if}

 </div>
         {/if}
     <div class="ask-bottom">

          <a    {if  !$question['hidden']}  href="{url question/answer/$question['qid']/$question['id']}"    {/if} class="" ><i class="fa fa-commentingicon"></i>{$question['comments']} 评论</a>
          <a    {if  !$question['hidden']}  href="{url question/answer/$question['qid']/$question['id']}"    {/if}  class=" ">{$question['supports']}个赞</a>
     </div>
       </div>

              </div>
                          <!--{/loop}-->   
		    </div>
		      <div class="pages" >{$departstr}</div>    
	</section>
	<div class="ui-dialog " id="topayask">
    <div class="ui-dialog-cnt">
        <div class="ui-dialog-bd">
            <h3>支付通知</h3>
            <p>您当前可用余额{echo $user['jine']/100;}元，将调用微信支付完成此次付费咨询!</p>
        </div>
        <div class="ui-dialog-ft">
            <button type="button" onclick="cancelpay()" data-role="button">取消</button>
            <button type="button" onclick="askpay()" data-role="button" class="btn-recommand">确认并支付</button>
        </div>
    </div>
</div>
{/if}
{if $user['uid']}
<script type="text/javascript">

$("#asksubmit").tap(function(){
	var _tmpdata=checkdata();
	if(!_tmpdata){
		return false;
	}

       var _yue=parseFloat($.trim($("#authoryue").val()));

    	   _money=parseFloat({$member['mypay']});
       if(_money==0){
         
    	   freeask();
        }else{
            if(_yue>=_money){
            	 
            	freeask();
            	  return false;
            }
            $("#topayask").addClass("show");

        }
          return false;

      
 
})
function cancelpay(){
	$("#topayask").removeClass("show");

}

function checkdata(){

	var _quicktitle=$.trim($("#quicktitle").val());
	var _quickcid="{$member['category'][0]['cid']}";
	if(_quicktitle==''){
		alert("咨询内容不能为空");
		return false;
	}
	if(_quicktitle.length<5){
		alert("咨询内容最少5个字");
		return false;
	}
	var data={
			quicktitle:_quicktitle,
			quickcid:_quickcid,
			askfromuid:"{$member['uid']}"
			}
	return data;
}
var subing=false;
function freeask(){
	if(subing){
return false;
	}
	var _tmpdata=checkdata();
	if(!_tmpdata){
		return false;
	}
	var _url="{url question/ajaxquickadd}";
	function success(result){
		subing=false;
		if(result.message=="ok"){
        window.location.href=result.url;
		}else{
alert(result.message);
		}
  
	}
	subing=true;
	
	ajaxpost(_url,_tmpdata,success);
}
</script>
<script>
var _seekpay='';
seekpay();
var _Listen=null;
//监听是否支付
function seekpay(){
	_seekpay=$("#myseek").val();
	if(_seekpay==''){
		//$(".mydd").html("没有检索到");
		   return false;
	}
	
	  
	var _cot=0;
	if(_Listen!=null){
		  return false;
	}
	 _Listen=setInterval(function(){
		++_cot;
		if(_cot>1000){
			
			
			window.clearInterval(_Listen);
			return false;
		}
		var _url="{url pay/ajaxrequestpayask}";
		   $.ajax({
		        //提交数据的类型 POST GET
		        type:"POST",
		        //提交的网址
		        url:_url,
		        //提交的数据
		        data:{name:_seekpay},
		        //返回数据的格式
		        datatype: "json",

		        //成功返回之后调用的函数
		        success:function(result){
		        
		       
			        var rs=$.parseJSON( result )
			   
			        if(rs.code==200){
			        	window.clearInterval(_Listen)
			        	freeask()
			        }else{
				      
			        	
			        }

		        }   ,

		        //调用出错执行的函数
		        error: function(){
		            //请求出错处理
		        }
		    });
	},1000);
}
function askpay(){
	window.clearInterval(_Listen);
	var _tmpdata=checkdata();
	if(!_tmpdata){
		return false;
	}
	var _quicktitle=$.trim($("#quicktitle").val());
	var _quickcid="{$member['category'][0]['cid']}";
	_tmpdata.title=_quicktitle;
	_tmpdata.cid=_quickcid;
	_tmpdata.description='';
       var _yue=parseFloat($.trim($("#authoryue").val()));
       
  
       var _tomypay={$member['mypay']};
     var  _money=parseFloat(_tomypay);
 
       if(_money==0){
          alert("付费咨询金额不能为0");
          return false;
       }
    
       _tmpdata.jine=_money;
       _tmpdata.payjine=_money;
	var timestamp = Date.parse(new Date());
    var posturl="{url pay/ajaxpayrecharge}";//g_site_url+"index.php?pay/ajaxpayrecharge/"+_money+"/ask/"+timestamp;
     
    _seekpay="chongzhi_0_"+ "{$user['uid']}"+"_"+_money*100+"_"+timestamp;
   $("#myseek").val(_seekpay);
	{if $signPackage==null}

  
	_tmpdata.type="ask";
	_tmpdata.time=timestamp;
    $.ajax({
        //提交数据的类型 POST GET
        type:"POST",
        //提交的网址
        url:posturl,
        //提交的数据
        data:_tmpdata,
        //返回数据的格式
        datatype: "text",//"xml", "html", "script", "json", "jsonp", "text".
        beforeSend: function () {

            ajaxloading("提交中...");
         },
        //成功返回之后调用的函数
        success:function(result){
        	result=$.trim(result);
            if(result.match("http")){
               
            	seekpay()
   	         window.location.href=result;
   	       }else{
   	    	   el2=$.tips({
   	 	            content:result,
   	 	            stayTime:2000,
   	 	            type:"success"
   	 	        });
   	       }
        }   ,
        complete: function () {
            removeajaxloading();
         },
        //调用出错执行的函数
        error: function(){
            //请求出错处理
        }
    });
    
	return false;
	{else}
	var _openid="{$openId}";
	_tmpdata.openid=_openid;
	_tmpdata.time=timestamp;
	var data=_tmpdata;
	function success(result){
		WeixinJSBridge.invoke(
				'getBrandWCPayRequest',
				result,
				function(res){
					$("#dialogdashang").dialog("hide");
					var _tmps=res.err_msg.split(':');

					if(_tmps[1]=='ok'){
						window.clearInterval(_Listen)
			        	
			         freeask()
					}else{
						return false;
					}
				}
			);
	}
    var posturl="{url pay/ajaxpayrecharge/ask}";
	ajaxpost(posturl,data,success);
	{/if}
}

</script>

{/if}


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

        'hideMenuItems'
      ]
  });



wx.ready(function () {


	wx.hideMenuItems({
	    menuList: ['menuItem:copyUrl','menuItem:openWithQQBrowser','menuItem:openWithSafari','menuItem:originPage','menuItem:share:email']
	});

 

    wx.updateAppMessageShareData({
    	 title: _qtitle,
	      desc: _qcontent,
	      link:"{url user/space/$member['uid']}",
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

	      link:"{url user/space/$member['uid']}",
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
	      link:"{url user/space/$member['uid']}",
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
	      link:"{url user/space/$member['uid']}",
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
	      link:"{url user/space/$member['uid']}",
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
	      link:"{url user/space/$member['uid']}",
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
	      link:"{url user/space/$member['uid']}",
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