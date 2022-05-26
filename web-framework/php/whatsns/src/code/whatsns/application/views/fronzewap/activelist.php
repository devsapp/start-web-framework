<!--{template header}-->
    <style>
        body{
            background: #f1f5f8;
        }
    </style>
<!--列表部分-->
                    <div class="au_resultitems au_searchlist">
                    <!--{if $userlist}-->
  <!--列表部分-->
                    <div class="au_resultitems au_act_userlist">
                        <div class="ui-row">
                         <!--{loop $userlist $activeuser}-->
                            <div class="ui-col ui-col-50 au_act_user_item">
                                <div class="au_act_user">
                                     <div class="au_act_user_avatar">
                                         <a  href="{url user/space/$activeuser['uid']}">
      <img src="{$activeuser['avatar']}" alt="{$activeuser['username']}">
</a>
                                     </div>
                                    <!--姓名-->
                                    <p class="au_act_user_info">
                                     <a target="_blank" href="{url user/space/$activeuser['uid']}"> 
                                    <span class="au_act_user_name">
                                    {$activeuser['username']}
                                    </span>
                                     {if $activeuser['author_has_vertify']!=false}<i class="fa fa-vimeo {if $activeuser['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  " data-toggle="tooltip" data-placement="right" title="" {if $activeuser['author_has_vertify'][0]=='0'}data-original-title="个人认证" {else}data-original-title="企业认证" {/if} ></i>{/if}
                                      </a>
                                    
                                    
                                    </p>

                                    <!--介绍-->
                                    <p class="au_act_user_intro c_hui">
                                        {$activeuser['signature']}
                                    </p>
                                    {if $activeuser['hasfollower']==1}
                                    <div  id="attenttouser_{$activeuser['uid']}" onclick="attentto_user($activeuser['uid'])" class="au_act_user_follow following au_act_user_follow following au_act_user_follow following button_followed ">
                                         <i class="fa fa-check"></i><span>已关注</span>
                                    </div>
                                    {else}
                                      <div id="attenttouser_{$activeuser['uid']}" onclick="attentto_user($activeuser['uid'])" class="au_act_user_follow follow button_attention">
                                          +关注
                                    </div>
                                    {/if}
                                  
                                    <!--相关信息-->
                                  
                                    <ul class="ui-tiled">
    <li><div class="c_hui">粉丝</div><i> {$activeuser['followers']}个</i></li>
    <li><div class="c_hui">文章</div><i>{$activeuser['articles']}篇</i></li>
    <li><div class="c_hui">问题</div><i>{$activeuser['questions']}个</i></li>
</ul>

                                       
                               

                                </div>

                            </div>
                              <!--{/loop}-->


                        </div>
                    </div>
     
   <!--{else}-->
                            <div id="no-result">
                <p>暂时没有网站作者。</p>
                
            </div>
    <!--{/if}-->

                    </div>

    <div class="pages">  {$departstr}</div>
 

<!--{template footer}-->