<!--{template header}-->

<section class="ui-container">
<!--{template user_title}-->

   
    <section class="user-content-list">
                    <ul class="tab-head">
                                         
                  
                      <li class="tab-head-item "><a href="{url user/attention/question}" title="关注的问题">问题</a></li>
                                                                               
                  
                      <li class="tab-head-item "><a href="{url user/attention/article}" title="关注的文章">文章</a></li>
                                                                               
                  
                      <li class="tab-head-item current"><a href="{url user/attention}" title="关注的用户">用户</a></li>
                                                                                                                       
                  
                      <li class="tab-head-item "><a href="{url user/attention/topic}" title="关注的话题">话题</a></li>
                                                                               
                                             

   
</ul>
                          <ul class="ui-list ui-list-one ui-list-link ui-border-tb">
                 {if $attentionlist==null}
                
               
    <p class="user-p-tip ui-txt-warning">  你还没有关注任何人。</p>

                 {/if}
                    <!--{loop $attentionlist $index $follower}-->
    <li class="ui-border-t" onclick="window.location.href='{url user/space/$follower['uid']}'">
    
        <div class="ui-list-thumb">
            <span style="background-image:url({$follower['avatar']})"></span>
        </div>
        <div class="ui-list-info">
            <h4 class="ui-nowrap">{$follower['username']}</h4>
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