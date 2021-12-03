<!--{template header}-->
<link rel="stylesheet" media="all" href="{SITE_URL}static/css/bianping/css/space.css" />



<!--用户中心大背景结束标记-->

<!--用户中心-->


    <div class="container person">

        <div class="row ">
            <div class="col-xs-17 main">
              <!-- 用户title部分导航 -->
              <!--{template user_title}-->
             <!-- title结束标记 -->
            <!-- 内容页面 -->
    <div class="row">
                 <div class="col-sm-24">
                     <div class="dongtai all-private-letter-page bg-box-radius">
                         <p class="pull-left">
                             <strong class="mar-l-1 font-18 ">我的消息</strong>
                        </p>
                         <button type="button" class="btn btn-success pull-right" onclick="javascript:document.location = '{url message/sendmessage}'">写消息</button>
                       <hr style="clear:both">
                                       <ul class="nav nav-secondary clear mar-t-05" >
        <li  class="active">
        <a href="{url message/personal}">私人消息<span class="p-msg-count icon_hot"></span></a>
        </li>
                    <li>

                   <a href="{url message/system}">系统消息<span class="s-msg-count icon_hot"></span></a>
                    </li>

             </ul>
                         <hr >
                         
                          <div class="all-message-list">
                         <ul>
                          <!--{loop $messagelist $message}-->
                            <li>
		<div class="avatar-container-48">
			<a class="author-avatar">
				
					
						<img src="{$message['from_avatar']}" width="60" height="60" alt="">
					
					
				

			</a>
			
			
		</div>
		
			
				<div class="message-content">
				           <!--{if $message['fromuid']==$user['uid']}-->
                               
                                <a href="{url user/score}">您</a> 对 <a href="{url user/space/$message['fromuid']}">{$message['touser']['username']}</a> 说：
                                <!--{else}-->
                         
                                <a href="{url user/space/$message['fromuid']}">{$message['from']}</a> 对 <a href="{url user/score}">您</a> 说：
                                <!--{/if}-->
					<p class="author-name" style="margin-top:10px;"><a class="message-sender disabled">{$message['subject']}</a><span class="message-time">{$message['format_time']}</span>  </p>
				
				      	<p class="message-content-show" style="width: 672px;">
					     <blockquote style="font-size: 13.5px">{$message['content']}</blockquote>
					</p>
                            
				</div>
			
			
		
	</li>
	  <!--{/loop}-->
                         </ul>
                         </div>
                         
                        

                             <!--{if 'personal'==$type}-->

                               <div class="row mar-t-1">
                               <div class="col-sm-24">

                                     <ul class="nav">
                <form class="form-horizontal"   name="commentform" action="{url message/sendmessage}" method="POST" onsubmit="return check_form();">
                    <li>
                    <div class="row">
                    <div class="col-sm-2">
                  
                    </div>
                     <div class="col-sm-22">

                        <div class="msgcontent">

                  <!--{template editor}-->
                            <div class="row mar-t-1">


                                 <!--{if $setting['code_message']=='1'}-->
                                  <!--{template code}-->

                      <!--{/if}-->




                               <button type="submit"  class="btn btn-success " name="submit">提&nbsp;交</button>

                                <input type="hidden" name="username" value="{$fromuser['username']}" />

                            </div>
                        </div>
                    </div>
                    </div>

                        <div class="clr clear"></div>
                    </li>
                </form>
            </ul>
                               </div>

                               </div>
                               <!--{/if}-->

                            <div class="pages">{$departstr}</div>

                     </div>
                 </div>


             </div>
            </div>

            <!--右侧栏目-->
            <div class="col-xs-7  aside">




                <!--导航列表-->

               <!--{template user_menu}-->

                <!--结束导航标记-->


                <div>

                </div>


            </div>

        </div>

    </div>



<!--用户中心结束-->
<script type="text/javascript">
function check_form() {
    if ($.trim(UE.getEditor('content').getPlainTxt()) == '') {
        alert("消息内容不能为空!");
        return false;
    }
    return true;
}
</script>
<!--{template footer}-->