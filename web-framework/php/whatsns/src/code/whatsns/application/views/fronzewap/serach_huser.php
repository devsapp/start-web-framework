<!--{template meta}-->
    <style>
        body{
            background: #f1f5f8;
        }
    </style>

    <div class="ws_header">
        <i class="fa fa-home" onclick="window.location.href='{url index}'"></i>
        <div class="ws_h_title">{$setting['site_name']}</div>
        <i class="fa fa-search"  onclick="window.location.href='{url question/searchkey}'"></i>
    </div>

    <!--导航提示-->
    <div class="ws_s_au_brif">
        <span class="ws_s_au_bref_item "><a href="{url question/search/$word}">问题</a></span>

        <span class="ws_s_au_bref_item "><a href="{url topic/search}?word={$word}">文章</a></span>
        <span class="ws_s_au_bref_item current"><a  href="{url user/search}?word={$word}">用户</a></span>
        <span class="ws_s_au_bref_item"><a href="{url category/search}?word={$word}">话题</a></span>
<span class="ws_s_au_bref_item "><a href="{url kecheng/search}?word={$word}">课程</a></span>
<span class="ws_s_au_bref_item "><a href="{url kecheng/searchcomment}?word={$word}">课程评论</a></span>

    </div>
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
                                    <div  id="attenttouser_{$activeuser['uid']}" onclick="attentto_user($activeuser['uid'])" class="au_act_user_follow following">
                                         <i class="fa fa-check"></i><span>已关注</span>
                                    </div>
                                    {else}
                                      <div id="attenttouser_{$activeuser['uid']}" onclick="attentto_user($activeuser['uid'])" class="au_act_user_follow follow">
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
        <div class="pages">  {$departstr}</div>
   <!--{else}-->
                            <div id="no-result">
                <p>抱歉，未找到和您搜索相关的内容。</p>
                <strong>建议您：</strong>
                <ul class="nav">
                    <li><span>检查输入是否正确</span></li>
                    <li><span>简化查询词或尝试其他相关词</span></li>
                </ul>
            </div>
    <!--{/if}-->

                    </div>
   <script>

   el2=$.tips({
        content:' 为您找到相关结果约{$rownum}个',
        stayTime:3000,
        type:"info"
    });
   </script>

<!--{template footer}-->