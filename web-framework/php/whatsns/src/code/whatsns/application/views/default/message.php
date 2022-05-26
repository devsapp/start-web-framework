<!--{template header}-->

<style>
.detail a{
	color: #ea644a;
    font-size: 12px;
}
.related .pv,.tooltip{
	font-size: 12px;
}
</style>
<!--用户中心-->


    <div class="container person">

        <div class="row ">
            <div class="col-xs-17 main">
    <!--{template user_title}-->
            <!-- 内容页面 -->
    <div class="row">
                 <div class="col-sm-24">

                     <div class="dongtai all-private-letter-page bg-box-radius">

                             <div> <strong class="mar-b-1 font-18 ">我的消息</strong></div>

                        <hr>
                         <p>

                          <button type="button" class="btn btn-success mar-l-1 pull-right" onclick="javascript:document.location = '{url message/updateunread}'">清空未读消息</button>
                         <button type="button" class="btn btn-default pull-right mar-ly-1" onclick="javascript:document.location = '{url message/sendmessage}'">写消息</button>
                         </p>
                                       <ul class="nav nav-secondary clear mar-t-05" >
        <li <!--{if $regular=="message/personal"}--> class="active"<!--{/if}-->>
        <a href="{url message/personal}">私人消息<span class="p-msg-count icon_hot"></span></a>
        </li>
                    <li <!--{if $regular=="message/system"}--> class="active"<!--{/if}-->>

                   <a href="{url message/system}">系统消息<span class="s-msg-count icon_hot"></span></a>
                    </li>

             </ul>
                         <hr >
                         <div class="all-message-list">
                         <ul>
                          <!--{loop $messagelist $message}-->
                            <li>
                            
                              <!--{if $type!='system'}-->
		<div class="avatar-container-48">
			<a class="author-avatar">
				
					
						<img src="{$message['from_avatar']}" width="60" height="60" alt="">
					
					
				

			</a>
			
			
		</div>
		
			      <!--{/if}-->
				<div class="message-content" <!--{if $type=='system'}-->  style="margin-left:0px;"   <!--{/if}-->>
					<p class="author-name"><a class="message-sender disabled">{$message['text']}</a><span class="message-time">{$message['format_time']}</span>   <!--{if $message['new']==1}-->
                                       <span class="icon_hot">新</span>
                                                <!--{/if}--></p>
				
					    <!--{if $type!='system'}-->
                 
                           	<p class="message-content-show" style="width: 672px;cursor:pointer"  data-toggle="tooltip" data-placement="bottom" title="" data-original-title="查看并回复消息"  onclick="javascript:document.location = '{url message/view/$type/$message[fromuid]/$message['id']}';">
					{$message['content']}
					</p>
                            <!--{else}-->
                            	<p class="message-content-show" style="width: 672px;">
					{$message['content']}	
					</p>
                            <!--{/if}-->
                            
				</div>
			
			
		
	</li>
	  <!--{/loop}-->
                         </ul>
                         </div>
                         
                         
                     </div>
                 </div>


             </div>
               <div class="pages">{$departstr}</div>
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

<!--{template footer}-->