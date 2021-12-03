<!--{template header}-->
 


<script>
var _qtitle="{$question['title']}";
{if 0!=$question['shangjin']}
_qtitle=_qtitle+"-【现金悬赏{$question['shangjin']}元】";
{/if}
	{eval $miaosu=strip_tags($question['description']);}
	 {eval $miaosu=cutstr(str_replace('&nbsp;','',$miaosu),200,'...');}
	 {eval $miaosu=str_replace('"', '', $miaosu);}
	 {eval $miaosu=str_replace('“', '', $miaosu);} 	
	 {eval $miaosu=str_replace('”', '', $miaosu);} 
	 var _qcontent="{eval echo trim($miaosu);}";
//var imgurl="{$question['author_avartar']}";
var imgurl="{$question['author_avartar']}";
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
    <article class="article">
        <h1 class="title">{$question['title']}</h1>
        <div class="article-info ui-clear">

            <ul class="ui-row">

                <li class="ui-col ui-col-75">

 {if $question['hidden']==1}

                     <span class="ui-avatar-s">
                      
                         <span style="background-image:url({$question['author_avartar']})"></span>
                      
                     </span>

     {else}
       <a href="{url user/space/{$question['authorid']}}">
                     <span class="ui-avatar-s">
                      
                         <span style="background-image:url({$question['author_avartar']})"></span>
                      
                     </span>
  </a>
    {/if}
                    <span class=" u-name">
                         {if $question['hidden']==1}
                  匿名用户
                       {else}
                         <a class="ui-txt-highlight ui-nowrap" href="{url user/space/{$question['authorid']}}">
                   
                    {$question['author']}
                      {if $question['author_has_vertify']!=false}<i style="top:0px;font-size:15px;" class="fa fa-vimeo {if $question['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  " data-toggle="tooltip" data-placement="right" title="" {if $question['author_has_vertify'][0]=='0'}data-original-title="个人认证" {else}data-original-title="企业认证" {/if} ></i>{/if}
                    </a>
                    {/if}
                    </span>
                   

                </li>
                <li id="attentquestion" class="ui-col ui-col-25    <!--{if $is_followed}-->button_attention  <!--{/if}-->" onclick="window.location.href='{url question/attentto/$question['id']}'">
                  <!--{if $is_followed}-->
                   <div class="q-follower ">
                         <i class="ui-icon-success-block"></i>
                       <span class="q-follower-txt">
                             已收藏
                       </span>
                   </div>
                     <!--{else}-->
                    <div class="q-unfollower ">
                        <i class="ui-icon-add"></i>
                       <span class="q-follower-txt">
                             收藏
                       </span>
                    </div>
                        <!--{/if}-->
                </li>

            </ul>

 <span class="ui-nowrap  " style="margin-top:1rem"> 发布时间:{$question['format_time']}</span>
    <!--{if $user['grouptype']==1||$user['uid']==$question['authorid']}-->
 <span class="ui-nowrap  " onclick="show_questionoprate()"  style="margin-top:.8rem;margin-left:5px;font-size:12px;"><i class="fa fa-gear " style="font-size:14px;position;relative;top:1px;margin:0 2px;"></i>管理</span>
  <!--{/if}-->
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
       <!--{if 0!=$question['shangjin']}-->
      <div style="background-color: #867775;    border-radius: .15em;color:#fff;font-size:12px;padding:.05rem .85em;margin:0 .85em;">此问题作者打赏 <span style="font-size:15px;">$question['shangjin']</span> 元，如果回答被采纳将会将赏金放入您平台账户钱包，您可以提现到微信零钱里。</div>      
          <!--{/if}-->
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
                                   {if $bestanswer['author_has_vertify']!=false}<i class="fa fa-vimeo {if $bestanswer['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  " data-toggle="tooltip" data-placement="right" title="" {if $bestanswer['author_has_vertify'][0]=='0'}data-original-title="个人认证" {else}data-original-title="企业认证" {/if} ></i>{/if}
                                  </span>
                                  </a>
                              <i class="ui-icon-collected"></i>
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
                         {if $bestanswer['reward']==0||$bestanswer['authorid']==$user['uid']}
                             {eval    echo replacewords($bestanswer['content']);    }
                               {else}
                               {if $bestanswer['canview']==0}
                                 <div class="box_toukan ">
											
											{if $user['uid']==0}
											<a href="{url user/login}" data-placement="top" title="" data-toggle="tooltip" data-original-title="我也付费偷偷看" class="thiefbox" onclick=""><i class="ui-icon-cart"></i> &nbsp;精彩回答&nbsp;$bestanswer['reward']&nbsp;&nbsp;元偷偷看……</a>
											{else}
											<a onclick="viewanswer($bestanswer['reward'],$bestanswer['id'])" data-placement="top" title="" data-toggle="tooltip" data-original-title="我也付费偷偷看" class="thiefbox" onclick=""><i class=" ui-icon-cart"></i> &nbsp;精彩回答&nbsp;$bestanswer['reward']&nbsp;&nbsp;元偷偷看……</a>
											{/if}
											
										    
										</div>
                               {else}
                                 {eval    echo replacewords($bestanswer['content']);    }
                               {/if}
                            
                               {/if}
                    {else}
                    <div class="yuyinplay" id="{$bestanswer['serverid']}">
                     <i class="ui-icon-voice" ></i><span class="u-voice">
                   <span class="wtip">免费偷听</span>
                    
                     &nbsp;{$bestanswer['voicetime']}秒</span>
                     <audio id="voiceaudio" width="420" style="display:none">
    <source src="{SITE_URL}data/weixinrecord/{$bestanswer['mediafile']}" type="audio/mpeg" />
  
</audio>
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
                    <div class="operationlist">
                   
                      <span  onclick="show_comment('{$bestanswer['id']}');">
                     <i class="ui-icon-comment"></i>
                                <span class="ans-comment-num ">
                                    {$bestanswer['comments']}条评论
                                </span>
                    </span>
                      {if $signPackage!=null}
                            <span onclick="bestcallpay()" >
                            
                             <script type="text/javascript">
	//调用微信JS api 支付
	function bestjsApiCall()
	{
		WeixinJSBridge.invoke(
			'getBrandWCPayRequest',
			{$bestanswer['JsApi']},
			function(res){
				var _tmps=res.err_msg.split(':');
				
				if(_tmps[1]=='ok'){
					 el2=$.tips({
		      	            content:'作者已收到您的打赏，非常感谢!',
		      	            stayTime:2000,
		      	            type:"success"
		      	        });
				}else{
					 el2=$.tips({
		      	            content:'您取消了本次打赏',
		      	            stayTime:2000,
		      	            type:"info"
		      	        });
				}
				 
			}
		);
	}

	function bestcallpay()
	{
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', bestjsApiCall, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', bestjsApiCall); 
		        document.attachEvent('onWeixinJSBridgeReady', bestjsApiCall);
		    }
		}else{
			bestjsApiCall();
		}
	}
	</script>
	  
                                <span class="shangta ui-label-s" style="color:#ff7f0d;padding:1px;">
                                                                                        赏{$setting['mobile_shang']}元
                                </span>
                            </span>
                            {/if}
                          
                          
                        <!--{if 1==$user['grouptype'] ||$user['uid']==$question['authorid'] || $user['uid']==$bestanswer['authorid']}-->
                                <span onclick="show_oprate('{$bestanswer['id']}');">
                                <i class="fa fa-gear"></i>
                               <span class="">操作 </span>
                            </span>
                              <!--{/if}-->  
                     <span>
                      {$bestanswer['format_time']}
                    </span>
                     </div>
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
                 <!--{loop $answerlist $index $answer}-->    
                <div class="answer-item">
                          <ul class="ui-row">
                              <li class="ui-col ui-col-50">
                              <a class="ui-txt-highlight" href="{url user/space/{$answer['authorid']}}">
                                  <span class="ui-avatar-s">
                        
                          
                                     <span style="background-image:url({$answer['author_avartar']})"></span>
                                   
                     </span></a>

                                  <span class="ui-txt-highlight u-name">
                                 
                                   <a class="ui-txt-highlight" href="{url user/space/{$answer['authorid']}}">
                                    {$answer['author']}
                                     {if $answer['author_has_vertify']!=false}<i class="fa fa-vimeo {if $answer['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  " data-toggle="tooltip" data-placement="right" title="" {if $answer['author_has_vertify'][0]=='0'}data-original-title="个人认证" {else}data-original-title="企业认证" {/if} ></i>{/if}
                                   </a>
                                  </span>
                              </li>
                              <li class="ui-col ui-col-50 ui-align-right"  >
                                  <span class="btn-agree" id='{$answer['id']}'>
                                      <i class="ui-icon-like"></i>
                                       <span class="agree-num">{$answer['supports']}</span>
                                  </span>
                              </li>
                          </ul>
                    <div class="ans-content">
                       {if $answer['serverid']==null}
                            {if $answer['reward']==0||$answer['authorid']==$user['uid']}
                             {eval    echo replacewords($answer['content']);    }
                               {else}
                               {if $answer['canview']==0}
                                 <div class="box_toukan ">
											
											{if $user['uid']==0}
											<a href="{url user/login}" data-placement="top" title="" data-toggle="tooltip" data-original-title="我也付费偷偷看" class="thiefbox" ><i class="ui-icon-cart"></i> &nbsp;精彩回答&nbsp;$answer['reward']&nbsp;&nbsp;元偷偷看……</a>
											{else}
											<a onclick="viewanswer($answer['reward'],$answer['id'])" data-placement="top" title="" data-toggle="tooltip" data-original-title="我也付费偷偷看" class="thiefbox" onclick=""><i class="ui-icon-cart"></i> &nbsp;精彩回答&nbsp;$answer['reward']&nbsp;&nbsp;元偷偷看……</a>
											{/if}
											
										    
										</div>
                               {else}
                                 {eval    echo replacewords($answer['content']);    }
                               {/if}
                            
                               {/if}
                    {else}
                    <div class="yuyinplay" id="{$answer['serverid']}">
                     <i class="ui-icon-voice" ></i><span  class="u-voice">
                     <span class="wtip">免费偷听</span>

                     &nbsp;{$answer['voicetime']}秒</span>
                                 <audio id="voiceaudio" width="420" style="display:none">
    <source src="{SITE_URL}data/weixinrecord/{$answer['mediafile']}" type="audio/mpeg" />
  
</audio>
                    </div>
                    {/if}
        
   <div class="appendcontent">
                                <!--{loop $answer['appends'] $append}-->       
                                <div class="appendbox">
                                    <!--{if $append['authorid']==$answer['authorid']}-->
                                    <h4 class="appendanswer font-12">回答:<span class="time">
                                    {$append['format_time']}
                                    </span></h4>
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
                      <div class="operationlist">
                      <span onclick="show_comment('{$answer['id']}');">
                     <i class="ui-icon-comment"></i>
                                <span class="ans-comment-num">
                                    {$answer['comments']}条评论
                                </span>
                    </span>
                      <!--{if 1==$user['grouptype'] ||$user['uid']==$question['authorid'] || $user['uid']==$answer['authorid']}-->
                      <span onclick="show_oprate('{$answer['id']}');">
                      <i class="fa fa-gear"></i>
                               <span class="">操作 </span>
                    </span>
                       <!--{/if}-->   
                 <span>
                     {$answer['time']}
                    </span>
                    </div>
                        <div class="ans-footer-comment" id="comment_{$answer['id']}" style="display: none;">


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
                                            <button name="submit" onclick="addcomment({$answer['id']});" class="ui-btn f-btn-comment">
                                                评论
                                            </button>
                                        </li>
                                    </ul>

                               
                            </div>
                        </div>
                    </div>
                </div>
                  <!--{/loop}-->    
            </div>
        </div>
        <div class="pages">{$departstr}</div>
        
         <!--{if 9!=$question['status']  }-->     
       {if $user['uid']!=0}
<div class="ui-btn-wrap">
    <button id="btnanswer" class="ui-btn-lg ui-btn-danger">
        我来回答
    </button>
</div>
 {if $user['uid']==1}
  <button  class="ui-btn-lg ui-btn-danger" onclick="mobilebestcallpay(7)">
        测试付费打赏
    </button>
 {/if}
 {else}
 <div class="ui-btn-wrap">
    <button onclick="window.location.href='{url user/login}'" class="ui-btn-lg ui-btn-danger">
        登录回答
    </button>
</div>
 {/if}
   <!--{else}-->      
      
       <p class="text-center " style="font-size:12px;text-align:center;color:#777;"> 该问题目前已经被关闭, 无法添加新回复
       <!--{/if}-->  
    </section>
    <section class="article-jingxuan ui-panel">
        <h2 class="ui-txt-warning">相关问题</h2>
        <ul class="ui-list ui-list-text ui-border-tb">
         <!--{loop $solvelist $solve}-->
            <li class="ui-border-t">
                <div class="ui-list-info">
                    <h4 class="ui-nowrap">
                    
                    <a title=" {$solve['title']}" href="{SITE_URL}/?question/view/{$solve['id']}" >
   {$solve['title']}
   </a>
   </h4>
                </div>
                <div class="ui-arrowlink "></div>
            </li>
              <!--{/loop}-->
            

        </ul>
    </section>


       <div class="ui-dialog dialogcomment">
    <i class="ui-icon-close" style="font-size:75px;position:fixed;top:10px;right:-10px;color:red"></i>
     {if $iswxbrower==null&&$setting['code_ask']&&$user['credit1']<$setting['jingyan']}
    <div  id="codetip" class=" " style="color:#777;font-size:12px;position:fixed;bottom:35px;left:10px;">验证码不能为空</div>
      {/if}
      <div class="commentboard" style="background:#fff;position:fixed;bottom:0px;left:0px;z-index:-1;height:270px;width:100%;">
     
        <form id="huidaform"  name="answerForm"  method="post" >
       <input type="hidden" value="{$question['id']}" id="ans_qid" name="qid">
                <input type="hidden" value="{$question['title']}" id="ans_title" name="title">

     <div  style="border-radius:5px;width:100%;hegiht:300px;position:fixed;bottom:50px;left:0px;border:none;padding-top:10px;padding-bottom:40px;">
      <!--{template editor}-->
     </div>
     
    <div class="ui-row-flex ui-whitespace">
    <div class="ui-col ui-col-2">
      {if $iswxbrower==null&&$setting['code_ask']&&$user['credit1']<$setting['jingyan']}
     <input type="text"  id="code" name="code" onblur="check_code();" placeholder="输入验证码"  style="font-size:12px;border:none;width:100px;hegiht:20px;position:fixed;bottom:56px;left:10px;border: solid 1px #ccc;    outline: none;">
     <img class="hand" src="{url user/code}" onclick="javascript:updatecode();" id="verifycode" style="width:50px;position:fixed;bottom:60px;left:130px;">
   {/if}
    </div>
     <div class="ui-col ui-col-5">
      <input type="text"  id="chakanjine" placeholder="偷看支付金额0.1-10元" style="font-size:12px;width:160px;height:20px;position:fixed;bottom:10px;left:10px;"/>
       </div>
    <div class="ui-col">
     <button  type="button" id="answsubmit" class="ui-btn ui-btn-primary" style="position:fixed;bottom:10px;right:10px;">
        确定
    </button>
    </div>
</div>
    </form>
     </div>
   
        
</div>
</section>

<div class="ui-dialog" id="dialogadopt">
    <div class="ui-dialog-cnt">
      <header class="ui-dialog-hd ui-border-b">
                  <h3>采纳回答</h3>
                  <i class="ui-dialog-close" data-role="button"></i>
              </header>
              
        <div class="ui-dialog-bd">
               
    
        <input type="hidden"  value="{$question['id']}" id="adopt_qid" name="qid"/>
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
          <input type="text" value="{$setting['mobile_shang']}" style="text-align:center;border:none;outline:none;background:transparent;border-bottom:solid 1px #ff7f0d;width:100px;font-size:28px;margin:0 auto;color:#ff7f0d;">
                         <span style="font-size:28px;color:#ff7f0d;position:relative;top:2px;">元</span>
    
    
 <div style="display:block;margin:5px auto;">
 </div>
    <button  id="btndashang"  class="ui-btn ui-btn-danger hide">
                               打&nbsp;赏
    </button>
          
      
        </div>
       
         
    </div>        
</div>


<script>

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
	
	$.ajax({
	    //提交数据的类型 POST GET
	    type:"POST",
	    //提交的网址
	    url:"{SITE_URL}index.php?question/ajaxadopt",
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
	    	   alert("采纳成功!");
	    
	    	   setTimeout(function(){
	               window.location.reload();
	           },1500);
	       }else{
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

<section>
<!-- 回答操作 -->
<div class="ui-actionsheet pingluncaozuo">  
  <div class="ui-actionsheet-cnt">
    <h4>回答操作</h4> 
             <!--{if $bestanswer['id']<=0}-->
         <!--{if 1==$user['grouptype'] ||$user['uid']==$question['authorid']}-->
    <button onclick="adoptanswer()">采纳</button>  
       <!--{/if}-->
                             <!--{/if}-->   
                                <!--{if 1==$user['grouptype'] || $user['uid']==$answer['authorid']}-->
      <button onclick="jixuhuida()">继续回答</button>  
         <button onclick="bianjihuida()">编辑回答</button>  
        <!--{/if}-->   
           <!--{if 1==$user['grouptype'] || $user['uid']==$question['authorid']}-->
             <button onclick="jixuzhuiwen()">继续追问</button>  
             <!--{/if}-->   
             
                <!--{if 1==$user['grouptype'] ||$user['uid']==$answer['authorid']}-->
    <button class="ui-actionsheet-del" onclick="deleteanswer()">删除</button>
     <!--{/if}-->   
    <button class="cancelpop">取消</button> 
  </div>         
</div>
   <!--{if $user['grouptype']==1||$user['uid']==$question['authorid']}-->
<!-- 提问操作 -->
<div class="ui-actionsheet wenticaozuo">  
  <div class="ui-actionsheet-cnt">
    <h4>问题操作</h4> 

    
           <button onclick="bianjiwenti()">编辑问题</button>  
             <button id="close_question">关闭问题</button>  
          <button class="ui-actionsheet-del" id="delete_question">删除</button>
        
    <button class="cancelpop">取消</button> 
  </div>         
</div>
  <!--{/if}-->   
<div class="ui-actionsheet huidacaozuo">  
  <div class="ui-actionsheet-cnt">
    <h4>支持语音或者文本回复</h4> 
    <button class="voiceanswer">语音</button>  
    <button class="textanswer">文本</button>
    <button class="cancelpop">取消</button> 
  </div>         
</div>
<div class="ui-dialog luyin">
    <div class="ui-dialog-cnt">
      <header class="ui-dialog-hd ui-border-b">
                  <h3>语音最长一分钟</h3>
                  <i class="ui-dialog-close" data-role="button"></i>
              </header>
        <div class="ui-dialog-bd">
            <h4>点击录音开始，最短不低于3秒</h4>
           
           <div class="u-footer" style="margin-top:10px;">
            <button type="button" id="btncaozuo" class="ui-btn-lg ui-btn-success" style="margin-top:5px;">录音</button>
            <button type="button" id="btnbofang" class="ui-btn-lg ui-btn-success" style="margin-top:5px;" >试听</button>
             <button type="button"  id="btnfabu" class="ui-btn-lg ui-btn-primary" style="margin-top:5px;">发布</button>
        </div>
        </div>
        
    </div>        
</div>
</section>

<script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"> </script>
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



    //alert("ok")
    
 $("#btnbofang").click(function(){
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
           
              wx.playVoice({
                  localId: record.localId
              });
         }else{
         	 record.playing=0;
         	 $('#btnbofang').html("试听");
           
         	   $(".luyin h4").html('试听结束！');
              wx.stopVoice({
                  localId: record.localId
              });
         }
    })

    $("#btnfabu").click(function(){
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
    })
	$("#btncaozuo").click(function(){
		
		if(record.openid==''){
		alert('无法识别您的身份');
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
	                  
	              }
	          });
			 
		}else{
			   $(".luyin h4").html('录音中...');
			   $('#btncaozuo').html("停止录音");
		     
		        record.recording=1;
		        wx.startRecord({
		            cancel: function () {
		              alert('用户拒绝授权录音');
		            }
		          });
		        listenvoice=setInterval(function(){
		        	voicetime++;
		        	$(".luyin h4").html('录音中...'+voicetime+"秒");
		        },1000);
		       
		}
	})
   
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
         
        }
    });
    wx.onVoicePlayEnd({
        success: function (res) {
        	 record.playing=0;
         	 $('#btnbofang').html("试听");
           
         	   $(".luyin h4").html('试听结束！');
        	 targetplay.find(".wtip").html("试听结束");
            //record.localId = res.localId; // 返回音频的本地ID
             record.playing=0;
        	 $('#btnbofang').html("试听");
          
        	   $(".luyin h4").html('试听结束！');
            record.playing=0;
        	 el2=$.tips({
		         content:'试听结束!',
		         stayTime:2000,
		         type:"success"
		     });
        }
    });
   
    wx.onMenuShareAppMessage({
    	 title: _qtitle,
	      desc: _qcontent,
	      link: "{SITE_URL}index.php?question/view/{$question['id']}",
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
	    
    	  link: "{SITE_URL}index.php?question/view/{$question['id']}",
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

//questioncaozuo
var current_aid=0;
var qid={$question['id']};
function adoptanswer() {
    
    $("#adopt_answer").val(current_aid);
    $('.ui-actionsheet').removeClass('show').addClass('hide');
    $('#dialogadopt').dialog('show');
}
function dashangceshi(_jine){
	var posturl='{url question/ajaxdashangjine}';
	
	var _openid="{$openId}";

	var data={jine:_jine,openid:_openid};
	function success(result){
	
		WeixinJSBridge.invoke(
				'getBrandWCPayRequest',
				result,
				function(res){
					var _tmps=res.err_msg.split(':');
					
					if(_tmps[1]=='ok'){
						 el2=$.tips({
			      	            content:'作者已收到您的打赏，非常感谢!',
			      	            stayTime:2000,
			      	            type:"success"
			      	        });
					}else{
						 el2=$.tips({
			      	            content:'您取消了本次打赏',
			      	            stayTime:2000,
			      	            type:"info"
			      	        });
					}
					 
				}
			);
	
	}
	
	ajaxpost(posturl,data,success);
}
$("#dialogdashang .ui-label").click(function(){
	var _shangjin=$(this).attr("val");

	$("#btndashang").removeClass("hide");
	$("#btndashang").click(function(){
		dashangceshi(_shangjin);
	})
})
//调用微信JS api 支付


function mobilebestcallpay(jine)
{
	$("#dialogdashang").dialog("show");
	
}
function jixuhuida(){
	 window.location.href=g_site_url + "index.php" + query + "answer/append/$question['id']/"+current_aid;
	
}
function bianjiwenti(){
	window.location.href=g_site_url + "index.php" + query + "question/edit/"+qid;
}
function bianjihuida(){

	window.location.href=g_site_url + "index.php" + query + "question/editanswer/"+current_aid;
	
}
function jixuzhuiwen(){
	 window.location.href=g_site_url + "index.php" + query + "answer/append/$question['id']/"+current_aid;
	
}

function deleteanswer(){
	window.location.href=g_site_url + "index.php" + query + "question/deleteanswer/"+current_aid+"/$question['id']";
	
}
function show_oprate(aid){
	current_aid=aid;

	 $('.pingluncaozuo').removeClass('hide').addClass('show');
}
function show_questionoprate(){
	

	 $('.wenticaozuo').removeClass('hide').addClass('show');
}

//关闭问题
$("#close_question").click(function() {
if (confirm('确定关闭该问题?') === true) {
var url=g_site_url+"/?question/close/"+qid;
document.location.href = url;
}
});
//删除问题
$("#delete_question").click(function() {
if (confirm('确定删除问题？该操作不可返回！') === true) {
var url=g_site_url+"/?question/delete/"+qid;
document.location.href = url;
}
});
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
		 	        url:"{SITE_URL}?question/postanswerreward",
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
		   function endfun(){ targetplay.find(".wtip").html("播放结束");alert("播放结束!")}
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

{if $openId==null}	
var canyuyin=0;
{else}
var canyuyin=1;
{/if}
$(".cancelpop").click(function(){
	 $('.ui-actionsheet').removeClass('show').addClass('hide');
})
$("#comment-note,#btnanswer").click(function(){
	if(canyuyin){
		  $('.huidacaozuo').removeClass('hide').addClass('show');
	}else{
		  var dia2=$(".dialogcomment").dialog("show");
		  
		    $(".dialogcomment .ui-icon-close").click(function(){
		    	$(".dialogcomment").dialog("hide");
		    })
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
	var dia2=$(".dialogcomment").dialog("show");
	  
    $(".dialogcomment .ui-icon-close").click(function(){
    	$(".dialogcomment").dialog("hide");
    })
})
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
			  chakanjine:_chakanjine,
 			content:eidtor_content,
 			qid:$("#ans_qid").val(),
 			title:$("#ans_title").val(),
 			code:$("#code").val()
 	}
	    <!--{else}-->
		var data={
				chakanjine:_chakanjine,
   			content:eidtor_content,
   			qid:$("#ans_qid").val(),
     			title:$("#ans_title").val()
   			
   	}
	     <!--{/if}-->
	  
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
       	 
       	 el2=$.tips({
	            content:'回答成功!',
	            stayTime:1000,
	            type:"info"
	        });
       	   setTimeout(function(){
                  window.location.reload();
              },1500);
          }else{
       	 
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