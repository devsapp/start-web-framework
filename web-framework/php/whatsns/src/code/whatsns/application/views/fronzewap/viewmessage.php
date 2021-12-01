<!--{template header}-->
<section class="ui-container">
<!--{template user_title}-->

 <div class="messagepoerate">
 <p>
 <button type="button" class="ui-btn ui-btn-primary mar-l-1 " onclick="javascript:document.location = '{url message/updateunread}'">清空未读消息</button>
 <button type="button" class="ui-btn ui-btn-danger  mar-ly-1" onclick="javascript:document.location = '{url message/sendmessage}'">写消息</button>
 </p>
</div>
<ul class="ui-tab-nav ui-border-b message-tab" >
        <li <!--{if $regular=="message/personal"}--> class="current"<!--{/if}-->>
        <a href="{url message/personal}">私人消息<span class="p-msg-count icon_hot"></span></a>
        </li>
                    <li <!--{if $regular=="message/system"}--> class="current"<!--{/if}-->>
                 
                   <a href="{url message/system}">系统消息<span class="s-msg-count icon_hot"></span></a>
                    </li>
                   
</ul>                    
   <form class="form-horizontal message-form"   name="msgform" action="{url message/remove}" method="POST" onsubmit="javascript:if (!confirm('确定删除所选消息?')) return false;">
                        
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
          
              {$message['content']}
            
            </p>
        </div>
    </div>
<!--{/loop}-->
</div>

                
                           <div class="msg_caozuo">
                         
                       <label class="ui-checkbox msg_checkbox">
           <input type="checkbox" value="chkall" id="chkall" onclick="checkall('message');"/>
                           
        </label>
           <span class="t_s_all">全选</span>   <button type="submit"  name="submit" class="ui-btn ui-btn-danger mar-ly-1" >删除</button>
        
                          </div>   
                          </form>
                          
                             <!--{if 'personal'==$type}-->
                             
                               <div class="row mar-t-1">
                               <div class="col-sm-24">
                               
                                     <ul class="nav message-items">
                <form class="form-horizontal message-form"   name="commentform" action="{url message/sendmessage}" method="POST" onsubmit="return check_form();">
                    <li>
                    <div class="row">
                    
                     <div class="col-sm-22">
                       
                        <div class="msgcontent">
                           
                  <!--{template editor}-->
                  
                  
                            <div class="row mar-t-1 messagebtnblock">
                            
                              <!--{if $setting['code_message']=='1'}-->
                                  <!--{template code}-->
        
                      <!--{/if}-->
                           
            
                               <button type="submit"  class="ui-btn ui-btn-danger " name="submit">回复Ta</button>
                              
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



<script type="text/javascript">
function check_form() {
    if ($.trim(UE.getEditor('content').getPlainTxt()) == '') {
        alert("消息内容不能为空!");
        return false;
    }
    return true;
}
</script>
</section>
<!--{template footer}-->