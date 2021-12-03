 <div
    class="card-designer-list-details details-right-author-wrap card-media">

    <input type="hidden" name="creator" value="601779">
    <div class="avatar-container-80">
      {if $question['hidden']!=1} <a
      href="{url user/space/$question['authorid']}"
      title="{$question['author']}" class="avatar" target="_blank"> <img
      src="{$question['author_avartar']}" width="80" height="80" alt="">
    </a> {else} <a href="javascript:void(0);" title="匿名用户"
                   class="avatar"> <img src="{SITE_URL}static/css/default/avatar.gif"
                                        width="80" height="80" alt="">
    </a> {/if}
    </div>
    <div class="author-info">
      <p class="author-info-title">
        {if $question['hidden']!=1} <a
        href="{url user/space/$question['authorid']}"
        title="{$question['author']}" class="title-content"
        target="_blank"> {$question['author']} {if
        $question['author_has_vertify']!=false}<i
          class="fa fa-vimeo {if $question['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  "
          data-toggle="tooltip" data-placement="right" title=""
          {if $question['author_has_vertify'][0]==
        '0'}data-original-title="个人认证" {else}data-original-title="企业认证"{/if} ></i>{/if}
      </a> {else} <a href="javascript:void(0);" title="匿名用户"
                     class="title-content"> 匿名用户 </a> {/if}


      </p>
      {if $question['hidden']==0}
      <div class="position-info">
						<span>{if $question['user']['gender']==0}女{/if}{if
							$question['user']['gender']==1}男{/if}&nbsp;|&nbsp;{$question['user']['signature']}</span>
      </div>
      {else}
      <div class="position-info">
        <span>保密&nbsp;|&nbsp;保密</span>
      </div>
      {/if} {if $question['hidden']==0}
      <div class="btn-area">

        <div class="js-project-focus-btn">
          <!-- 关注用户按钮 -->
          {if $is_followedauthor} <input type="button" title="已关注"
                                         id="attenttouser_{$question['authorid']}"
                                         onclick="attentto_user($question['authorid'])"
                                         class="btn-current attention btn-default-secondary following"
                                         value="已关注"> {else} <input type="button" title="添加关注"
                                                                    id="attenttouser_{$question['authorid']}"
                                                                    onclick="attentto_user($question['authorid'])"
                                                                    class="btn-current attention btn-default-main notfollow"
                                                                    value="关注"> {/if}
        </div>
        {if $user['uid']} <a
        href="{url message/sendmessage/$question['authorid']}"
        title="发私信"
        class="btn-default-secondary btn-current private-letter">私信</a>
        {else} <a href="javascript:login()" title="发私信"
                  class="btn-default-secondary btn-current private-letter">私信</a>

        {/if}
      </div>
      {/if}
    </div>
  </div>