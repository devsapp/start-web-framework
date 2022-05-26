  
  <div class="recommend" style="padding: 0px;">
  
           <div class="standing">
  <div class="positions bb" id="rankScroll">
      <h3 class="title">热门作者</h3>

        <ul class="list" style="padding: 10px;">

       <!--{loop $userarticle $index $uarticle}-->
        <li>
        <a href="{url user/space/$uarticle['uid']}" target="_self" class="avatar" style="width: 35px;  height: 35px;">
        <img src="{$uarticle['avatar']}">
        </a>

          {if  $uarticle['hasfollower']}
   <a class="following" id="attenttouser_{$uarticle['uid']}" onclick="attentto_user_index($uarticle['uid'])"><i class="fa fa-check"></i><span>已关注</span></a>
  {else}
    <a class="follow" id="attenttouser_{$uarticle['uid']}" onclick="attentto_user_index($uarticle['uid'])"><i class="fa fa-plus"></i>关注
        </a>

  {/if}


        <a href="{url user/space/$uarticle['uid']}" target="_self" class="name">
            {$uarticle['username']}{if $uarticle['author_has_vertify']!=false}<i class="fa fa-vimeo {if $uarticle['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  " data-toggle="tooltip" data-placement="right" title="" {if $uarticle['author_has_vertify'][0]=='0'}data-original-title="认证用户" {else}data-original-title="认证用户" {/if} ></i>{/if}
        </a>
         <p>
             <span class="dotgreen">{$uarticle['followers']}</span>关注·  <span class="dotgreen">{$uarticle['answers']}</span>回答 · 写了 <span class="dotgreen">{$uarticle['num']}</span>文章
        </p></li>
         <!--{/loop}-->
        </ul>
  </div>
  </div>
  
   </div>
   
       

  