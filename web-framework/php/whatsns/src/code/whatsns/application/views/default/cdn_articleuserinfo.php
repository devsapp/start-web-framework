
<div class="top-author-card follow-box col-md-8">
    <div class="card-designer-list-details details-right-author-wrap card-media">

        <input type="hidden" name="creator" value="14876008">
        <div class="avatar-container-80">
            <a href="{url user/space/$member['uid']}" title="{$topicone['author']}" class="avatar" >
                <img src="{$member['avatar']}" width="80" height="80" alt="">
            </a>
            
        </div>
        <div class="author-info">
            <p class="author-info-title">
           
             
                <a href="{url user/space/$member['uid']}" title="{$topicone['author']}" class="title-content">
               {$topicone['author']}
                  {if $topicone['author_has_vertify']!=false}<i class="fa fa-vimeo {if $topicone['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  " data-toggle="tooltip" data-placement="right" title="" {if $topicone['author_has_vertify'][0]=='0'}data-original-title="个人认证" {else}data-original-title="企业认证" {/if} ></i>{/if}
                </a>





            </p>
        <div class="position-info">
                <span>{if $member['gender']==0}女{/if}{if $member['gender']==1}男{/if}&nbsp;|&nbsp;{$member['signature']}</span>
            </div>
            <div class="btn-area">
                
      
                
                        <div class="js-project-focus-btn">
                                   <!-- 关注用户按钮 -->
                 {if  $is_followedauthor}
                                <input type="button" title="已关注" id="attenttouser_{$topicone['authorid']}" onclick="attentto_user($topicone['authorid'])" class="btn-current attention btn-default-secondary following" value="已关注" >
                              {else}
                               <input type="button" title="添加关注" id="attenttouser_{$topicone['authorid']}" onclick="attentto_user($topicone['authorid'])" class="btn-current attention btn-default-main notfollow" value="关注">
                                {/if}
                        </div>
                            {if $user['uid']}
                        <a href="{url message/sendmessage/$topicone['authorid']}" title="发私信" class="btn-default-secondary btn-current private-letter">私信</a>
                     
                     {else}
                       <a href="javascript:login()" title="发私信" class="btn-default-secondary btn-current private-letter">私信</a>
                     
                      {/if}
            </div>
               
        </div>
    </div>
</div>