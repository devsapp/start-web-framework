<!--{template header}-->

<section class="ui-container">
<!--{template space_title}-->
      <section class="user-content-list">
         <div class="titlemiaosu">
          Ta的个人动态
            </div>
      <div id="list-container">
        <!-- 文章列表模块 -->
<ul class="note-list">
      <!--{loop $doinglist $index $question}-->
                
    <li id="note-{$question['id']}" data-note-id="{$question['id']}" {if $question['image']!=null}  class="have-img" {else}class="" {/if}>
    {if $question['image']!=null}  
      <a class="wrap-img" href="{$question['url']}" target="_self">
            <img src="{$question['image']}">
        </a>
            {/if}
        <div class="content">
            <div class="author">
            
            
               
                
   
        <a class="avatar" target="_self" href="{url user/space/$question['authorid']}">
                    <img src="{$question['avatar']}" alt="96">
                </a>      <div class="name">
                <a class="blue-link" target="_self" href="{url user/space/$question['authorid']}">{$question['author']}{$question['actiondesc']}</a>
                
     
                
                <span class="time" data-shared-at="{$question['doing_time']}">{$question['doing_time']}</span>
            </div>
            </div>
          
            
            {if $question['action']==10}
            <div class="follow-detail">
      <div class="info">
        <a class="avatar-collection" href="{$question['url']}">
          <img src="{$question['category']['bigimage']}" alt="180">
</a>       
{if $question['category']['follow']}
 <a class="btn btn-default following" id="attenttouser_{$question['category']['id']}" onclick="attentto_cat($question['category']['id'])"><i class="fa fa-check"></i><span>已关注</span></a>
    
{else}
 <a class="btn btn-success follow" id="attenttouser_{$question['category']['id']}" onclick="attentto_cat($question['category']['id'])"><i class="fa fa-plus"></i><span>关注</span></a>
    
{/if}  
        <a class="title" href="{$question['url']}">{$question['category']['name']}</a>
        <p>
          
          {$question['category']['questions']} 个问题， {$question['category']['followers']} 人关注
        </p>
      </div>
        <div class="signature">
        
        {eval echo clearhtml(htmlspecialchars_decode($question['category']['miaosu']));}
        </div>
    </div>
           
            {/if}  
                  {if $question['action']==11}
            <div class="follow-detail">
      <div class="info">
        <a class="avatar" href="$question['url']">
          <img src="{$question['spaceuser']['avatar']}" alt="180">
</a>  

   <!--{if $question['spaceuser']['hasfollower']}-->
<a class="btn btn-default following" id="attenttouser_{$question['spaceuser']['uid']}" onclick="attentto_user($question['spaceuser']['uid'])"><i class="fa fa-check"></i><span >已关注</span></a>
 <!--{else}-->
    <a class="btn btn-success follow" id="attenttouser_{$question['spaceuser']['uid']}" onclick="attentto_user($question['spaceuser']['uid'])"><i class="fa fa-plus"></i><span>关注</span></a>
      <!--{/if}-->
           
  
   
        <a class="title" href="{$question['url']}">{$question['spaceuser']['username']}</a>
        <p>写了 {$question['spaceuser']['articles']} 篇文章，被{$question['spaceuser']['followers']} 人关注，获得了 {$question['spaceuser']['supports']} 个赞</p>
      </div>
        <div class="signature">
         {$question['spaceuser']['signature']} 
        </div>
    </div>   
    {/if}       
         {if $question['action']==15||$question['action']==9||$question['action']==13||$question['action']==14}
          <a class="title" target="_self"  href="{$question['url']}"  >{$question['content']}</a>
             {if $user['uid']!=$question['topic']['authorid']&&$question['topic']['price']>0}
                
                                                                 <div class="box_toukan ">
  {eval echo clearhtml(htmlspecialchars_decode($question['topic']['freeconent']),50);}
  {if $question['topic']['readmode']==2}
  
											<a  class="thiefbox font-12" ><i class="icon icon-lock font-12"></i> &nbsp;更多阅读需支付&nbsp;$question['topic']['price']&nbsp;&nbsp;财富值……</a>

   {/if}
        {if $question['topic']['readmode']==3}		                      
											<a  class="thiefbox font-12" ><i class="icon icon-lock font-12"></i> &nbsp;更多阅读需支付&nbsp;$question['topic']['price']&nbsp;&nbsp;元……</a>

		                    {/if}
										</div>
                   {else}
                   
             <p class="abstract">
            
                {eval echo clearhtml(htmlspecialchars_decode($question['description']));}
                
                
            </p>
                    {/if}
      {/if}
             {if $question['action']!=10&&$question['action']!=11&&$question['action']!=15&&$question['action']!=9&&$question['action']!=13&&$question['action']!=14}
              <a class="title" target="_self"  href="{$question['url']}"  >{$question['content']}</a>
             <p class="abstract">
            
                {eval echo clearhtml(htmlspecialchars_decode($question['description']));}
                
            </p>
             {/if}  
           
        </div>
    </li>

    <!--{/loop}-->

</ul>
  <div class="pages" >{$departstr}</div>   
      </div>
    </section>
</section>


<!--{template footer}-->