<!--{template header}-->

<section class="ui-container">
<!--{template user_title}-->

   
    <section class="user-content-list">
            <div class="titlemiaosu">
          关注我的粉丝
            </div>
                          <ul class="ui-list ui-list-one ui-list-link ui-border-tb">
                 {if $followerlist==null}
                
               
    <p class="user-p-tip ui-txt-warning">  还没有粉丝关注你，多写文章，多回答问题增加关注度。</p>

                 {/if}
                    <!--{loop $followerlist $follower}-->
    <li class="ui-border-t" onclick="window.location.href='{url user/space/$follower['followerid']}'">
    
        <div class="ui-list-thumb">
            <span style="background-image:url({$follower['avatar']})"></span>
        </div>
        <div class="ui-list-info">
            <h4 class="ui-nowrap">{$follower['follower']}</h4>
            <div class="ui-txt-info">
             <!--{if (1 == $follower['gender'])}--> 男 
            
             <!--{else}-->
             女
            <!--{/if}-->
            </div>
        </div>
    </li>
  <!--{/loop}-->    
</ul>
          <div class="pages" >{$departstr}</div>   
    </section>
</section>


<!--{template footer}-->