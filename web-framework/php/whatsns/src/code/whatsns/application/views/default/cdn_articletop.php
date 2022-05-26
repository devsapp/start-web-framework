<div class="scrollshow position-inf" style="display: none;">
   <div class="fix-hnav posd" style="display: block;">
    <p class="title" title="{$topicone['title']}">        {$topicone['title']}  </p>
    <div class="btns">
                        {if $isfollowarticle}
                    <input type="button"  class="btn-default-secondary details-collection-btn collection js-not-fav js-project-fav" value="已收藏" data-on="1" title="已收藏">
                        
                   {else}
                   {if $user['uid']}
                    <input type="button" onclick="window.location.href='{url favorite/topicadd/$topicone['id']}'" z-st="favorite" class="btn-default-secondary details-collection-btn collection js-not-fav js-project-fav" value="收藏文章" data-on="1" title="收藏文章">
                      
                      {else}
                       <input type="button" onclick="login()" z-st="favorite" class="btn-default-secondary details-collection-btn collection js-not-fav js-project-fav" value="收藏" data-on="1" title="收藏文章">
                     
                      {/if}  
                    {/if}
                        
                         <button type="button" class="btneditanswer" {if $user['uid']==0}  onclick="login()" {else} onclick="showeditor()" {/if} ><i class="fa fa-pencil"></i>写评论</button>
                      
            </div>
  </div>
  </div>