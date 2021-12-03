  <ul class="ui-row">

                <li class="ui-col ">

 {if $question['hidden']==1}

                     <span class="ui-avatar-s">

                         <span style="background-image:url({SITE_URL}static/css/default/avatar.gif)"></span>

                     </span>

     {else}
       <a href="{url user/space/{$question['authorid']}}">
                     <span class="ui-avatar-s">

                         <span style="background-image:url({$question['author_avartar']})"></span>

                     </span>
  </a>
    {/if}
                    <span class=" u-name">
                         {if $question['hidden']==1}
                  匿名用户
                       {else}
                         <a class="ui-txt-highlight ui-nowrap" href="{url user/space/$question['authorid']}">

                    {$question['author']}
                      {if $question['author_has_vertify']!=false}<i style="top:0px;font-size:15px;" class="fa fa-vimeo {if $question['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  " data-toggle="tooltip" data-placement="right" title="" {if $question['author_has_vertify'][0]=='0'}data-original-title="个人认证" {else}data-original-title="企业认证" {/if} ></i>{/if}
                    </a>
                    {/if}
                    </span>
                     <!-- 关注用户按钮 -->
                             {if  $is_followedauthor}

  <a class="btn btn-default following button_followed" id="attenttouser_{$question['authorid']}" onclick="attentto_user($question['authorid'])"><i class="fa fa-check"></i><span>已关注</span></a>

  {else}

         <a class="btn btn-success follow button_attention" id="attenttouser_{$question['authorid']}" onclick="attentto_user($question['authorid'])"><i class="fa fa-plus"></i><span>关注</span></a>

  {/if}
  {if $question['askuid']}
<i class="fa fa-yao"></i>
{/if}
                </li>


            </ul>