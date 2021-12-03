<div class="scrollshow position-inf" style="display: none;">
   <div class="fix-hnav posd" style="display: block;">
    <p class="title" title="{$question['title']}">          {$question['title']}  </p>
    <div class="btns">
                                        <button type="button" class="btneditanswer" {if $user['uid']==0}  onclick="login()" {else} onclick="showeditor()" {/if} ><i class="fa fa-pencil"></i>写回答</button>
                              
                         <button type="button" {if $user['uid']} onclick="invateuseranswer({$question['id']})"  {else} onclick="login()" {/if}  class="btn-default-secondary details-share" >
                     <i class="fa fa-user-plus"></i>邀请回答</button>
                         {if $user['uid']}
                             {if $is_followed}
                        <input type="button" onclick="window.location.href='{url question/attentto/$question['id']}'" z-st="favorite" class="btn-default-secondary details-collection-btn collection js-not-fav js-project-fav" value="已收藏问题" data-on="1">
                        
                        {else}
                          <input type="button" onclick="window.location.href='{url question/attentto/$question['id']}'" z-st="favorite" class="btn-default-secondary details-collection-btn collection js-not-fav js-project-fav" value="收藏问题" data-on="0">
                        
                        {/if}
                           {else}
                           <input type="button" onclick="login()" z-st="favorite" class="btn-default-secondary details-collection-btn collection js-not-fav js-project-fav" value="收藏问题" data-on="0">
                        
                           {/if}
            </div>
  </div>
  </div>