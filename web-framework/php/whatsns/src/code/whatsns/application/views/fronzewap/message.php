<!--{template header}-->
<section class="ui-container">
<!--{template user_title}-->
 <div class="messagepoerate">
                         <p>
                          
                          <button type="button" class="ui-btn ui-btn-primary mar-l-1 " onclick="javascript:document.location = '{url message/updateunread}'">清空未读消息</button>
                         <button type="button" class="ui-btn ui-btn-danger  mar-ly-1" onclick="javascript:document.location = '{url message/sendmessage}'">写消息</button>
                         </p>
         
                       
                        
                     </div>


     <ul class="tab-head">
                                         
                  
                      <li class="tab-head-item <!--{if $regular=="message/personal"}--> current<!--{/if}-->"><a href="{url message/personal}" title="私人消息">私人消息<span class="p-msg-count msgspan"></span></a></li>
                                                                               
                  
                      <li class="tab-head-item <!--{if $regular=="message/system"}--> current <!--{/if}-->"><a href="{url message/system}" title="系统消息">系统消息<span class="s-msg-count msgspan"></span></a></li>
                                                                               
                              

   
</ul>

  <form  class="form-horizontal message-form"  name="msgform" {if $type=='system'}action="{url message/remove}"{else}action="{url message/removedialog}"{/if} method="POST" onsubmit="javascript:if (!confirm('确定删除所选消息全部内容?')) return false;">
                              
                    <div class="tnvk_msglist">
       <!--{loop $messagelist $message}-->
    <div class="tnvk_msg_item" >
        <div class="t_msg_avatar">
        {if $message['fromuid']==0}
            <img src="{SITE_URL}static/images/xttz.jpeg"/>
            {else}
              <img src="{$message['from_avatar']}"/>
            {/if}
            {if $message['fromuid']==0}
       
         <input type='checkbox' class="msg_checkbox" value="{$message['id']}" name="messageid[inbox][]"/>
      
        
                           
                                <!--{else}-->
                                 
                                <input class="msg_checkbox" type='checkbox' value="{$message['fromuid']}" name="message_author[]"/>
                            
                                {/if}
        </div>
        <div class="tnvk_msg_content">
            <p>
                <span class="tnvk_msg_author">{$message['from']}</span>{if $message['new']==1}<span class="text"></span>{/if}<span class="msg_time">{eval echo date('m-d',strtotime($message['format_time']));}</span>
            </p>
            <p class="msg_content" onclick="javascript:document.location = '{url message/view/$type/$message[fromuid]/$message['id']}';">
              {$message['subject']}：
              {if $type!='system'}
              {eval echo clearhtml($message['content'],40);}
              {else}
              {$message['content']}
              {/if}
            </p>
        </div>
    </div>
<!--{/loop}-->
</div>

                    
               
                {if $messagelist!=null}
                        
                          <div class="msg_caozuo">
                         
                       <label class="ui-checkbox msg_checkbox">
           <input type="checkbox" value="chkall" id="chkall" onclick="checkall('message');"/>
                           
        </label>
           <span class="t_s_all">全选</span>   <button type="submit"  name="submit" class="ui-btn ui-btn-danger mar-ly-1" >删除</button>
        
                          </div>                 
                   
                   
                {/if}
                          </form>
                            <div class="pages">{$departstr}</div>
</section>



<!--{template footer}-->