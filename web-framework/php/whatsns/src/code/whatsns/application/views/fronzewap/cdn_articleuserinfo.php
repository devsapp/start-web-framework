   <ul class="ui-row">

                <li class="ui-col ui-col-75">

    <a href="{url user/space/{$topicone['authorid']}}">
                     <span class="ui-avatar-s">

                         <span style="background-image:url({$member['avatar']})"></span>

                     </span>
  </a>
                    <span class=" u-name">
                    <a class="ui-txt-highlight" href="{url user/space/{$topicone['authorid']}}">
                   {$topicone['author']}
                    {if $topicone['author_has_vertify']!=false}<i style="top:0px;font-size:15px;" class="fa fa-vimeo {if $topicone['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  " data-toggle="tooltip" data-placement="right" title="" {if $topicone['author_has_vertify'][0]=='0'}data-original-title="个人认证" {else}data-original-title="企业认证" {/if} ></i>{/if}
                  </a>
                    </span>

  <!-- 关注用户按钮 -->
                             {if  $is_followedauthor}

  <a class="btn btn-default following button_followed" id="attenttouser_{$member['uid']}" onclick="attentto_user($member['uid'])"><i class="fa fa-check"></i><span>已关注</span></a>

  {else}

         <a class="btn btn-success follow button_attention" id="attenttouser_{$member['uid']}" onclick="attentto_user($member['uid'])"><i class="fa fa-plus"></i><span>关注</span></a>

  {/if}
                </li>


            </ul>