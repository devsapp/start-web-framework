<!--{template header}-->
<!--{eval $adlist = $this->fromcache("adlist");}-->
<style>
    body{
        background: #f1f5f8;;
    }
</style>

           <!--广告位1-->
            <!--{if (isset($adlist['doing']['left1']) && trim($adlist['doing']['left1']))}-->
            <div style="margin-top:5px;">{$adlist['doing']['left1']}</div>
            <!--{/if}-->
            
        
                    <!--导航提示-->
                    <div class="au_brif">
                          <!--{if $type=='atentto'}-->
                   <span class="au_bref_item current"><a href="{url doing/default}">关注的动态</a></span>
                        <span class="au_bref_item "><a href="{url doing/default/my}">我的动态</a></span>
                  
                   <span class="au_bref_item "><a href="{url doing/default/all}">全站动态</a></span>
                     
                    <!--{elseif $type=='my'}-->
               <span class="au_bref_item"><a href="{url doing/default}">关注的动态</a></span>
                        <span class="au_bref_item current"><a href="{url doing/default/my}">我的动态</a></span>
                  
                 <span class="au_bref_item "><a href="{url doing/default/all}">全站动态</a></span>
                     
                    <!--{elseif $type=='all'}-->
                    <!--{if $this->user['uid']}-->
                    <span class="au_bref_item"><a href="{url doing/default}">关注的动态</a></span>
                        <span class="au_bref_item"><a href="{url doing/default/my}">我的动态</a></span>
                  
                    <!--{/if}-->
                    <span class="au_bref_item current"><a href="{url doing/default/all}">全站动态</a></span>
                        
                    <!--{/if}-->

                    </div>
                     <!--{if $recommandusers && $page==1}-->
                        <!--列表部分-->
                    <div class="au_resultitems">
                         <div class="au_doing_list">
                           <!--{loop $recommandusers $recommanduser}-->
                             <div class="au_doing_list_item">
                                <div class="ui-row-flex ui-whitespace">
                                    <div class="ui-col">
                                        <div class="au_doing_list_item_avatar">
                                              <img alt="{$recommanduser['username']}" src="{$recommanduser['avatar']}"/>
                                        </div>
                                    </div>
                                    <div class="ui-col ui-col-3">
                                        <div class="au_doingguanzhu_username">
                                             <a  href="{url user/space/$recommanduser['uid']}">{$recommanduser['username']}</a>
                                        </div>
                                        <!--基本情况-->
                                        <div class="au_doingguanzhu_info">
                                           <span><i class="fa fa-user lan"></i>粉丝:{$recommanduser['followers']}个</span>
                                            <span><i class="fa fa-comment-o hong"></i>回答: {$recommanduser['answers']}</span>
                                              <!--{if $recommanduser['is_follow']}-->
                                            <div class="au_doingguanzhu_info_guanzhu button_attention"  onclick="attentto_user($recommanduser['uid'])" id="attenttouser_{$recommanduser['uid']}" >
                                                                                        取消关注
                                            </div>
                                         <!--{else}-->
                                          <div class="au_doingguanzhu_info_guanzhu button_attention" onclick="attentto_user($recommanduser['uid'])" id="attenttouser_{$recommanduser['uid']}" >
                                                 +关注
                                            </div>
                                            <!--{/if}-->
                                        </div>
                                        <!--擅长领域-->
                                        <p class="au_doingguanzhu_info_cat">
                                            <span>擅长领域:</span>
                                               <!--{if $recommanduser['category']}-->擅长: 
                                <!--{loop $recommanduser['category'] $category}-->
                                <span> <a target="_blank" href="{url category/view/$category['cid']}">{$category['categoryname']}</a></span>
                                <!--{/loop}-->
                                <!--{/if}-->
                                
                                          
                                        </p>

                                        <!--推荐人简介-->
                                        <p class="au_doingguanzhu_info_intro">
                                                           <div class="au_expert_listitems_tiem_jianjie_name">
                                               简介：
                                           </div>
                                        <div class="au_expert_listitems_tiem_jianjie_name">
                                           {$recommanduser['signature']}
                                        </div>
                                        </p>

                                    </div>
                                </div>

                             </div>
                         <!--{/loop}-->

                         </div>
                    </div>
                    
                        <!--{/if}-->
                      
                    <!--列表部分-->
                    <div class="au_resultitems">
                         <div class="au_doing_list">
                              <!--{loop $doinglist $doing}-->
                             <div class="au_doing_list_item">
                                <div class="ui-row-flex ui-whitespace">
                                    <div class="ui-col">
                                      <!--{if $doing['hidden'] && in_array($doing['action'],array(1,8))}-->
                                        <img src="{SITE_URL}css/default/avatar.gif" alt="匿名" />
                                        <!--{else}-->
                                         <div class="au_doing_list_item_avatar">
                                               <a class="pic" target="_blank" title="{$doing['author']}" href="{url user/space/$doing['authorid']}"><img src="{$doing['avatar']}"/></a>
                                        </div>
                                         <!--{/if}-->
                                       
                                    </div>
                                    <div class="ui-col ui-col-3">
                                        <div class="au_doing_list_item_action">
                                           <span class="au_doing_list_item_action_username">
                                                          <!--{if $doing['hidden'] && in_array($doing['action'],array(1,8))}-->
                            匿名
                            <!--{else}-->
                            <a title="{$doing['author']}" href="{url user/space/$doing['authorid']}">{$doing['author']}</a> 
                            <!--{/if}-->
                                           </span>
                                            <span class="au_doing_list_item_action_info">{$doing['actiondesc']}</span>
                                          
                                        </div>
                                        <p class="au_doing_list_item_action_desc">
                                            <a>
                                              <a href="{$doing['url']}" target="_blank">{$doing['title']}</a>
                                            </a>
                                        </p>
                                        <div class="au_doing_list_item_action_text">
                                            {if $doing['action']!=10&&$doing['action']!=11&&$doing['action']!=12}
                                             <span><i class="fa fa-clock-o"></i> {$doing['doing_time']}</span>
                                            <span><i class="fa fa-eye"></i>{$doing['views']} </span>
                                            <span><i class="fa fa-comment-o"></i>{$doing['answers']}  </span>
                               
                                            {/if}
                                        </div>

                                        <!--评论列表-->
                                        <ul class="au_doing_list_item_action_commentlist">
                                           <!--{if $doing['referid']}-->
                                           <li class="au_doing_list_item_action_commentlistitem">
                                               <div class="ui-row-flex ui-whitespace">
                                                   <div class="ui-col">
                                                       <div class="au_doing_list_item_action_commentlistitem_user">
                                                             <img src="{$doing['refer_avatar']}">
                                                       </div>

                                                   </div>
                                                   <div class="ui-col ui-col-3">
                                                         <div>
                                                             <span class="au_doing_list_item_action_commentlistitem_username">
                                                                  <a href="{url user/space/$doing['refer_authorid']}">
                                                                  {$doing['author']}
                                                                  </a>
                                                             </span>
                                                              <span class="au_doing_list_item_action_commentlistitem_time">
                                                                  
                                                             </span>
                                                         </div>
                                                       <div class="au_doing_list_item_action_commentlistitem_content">
                                                          {eval echo cutstr($doing['refer_content'],100)}
                                                       </div>
                                                   </div>
                                               </div>
                                           </li>
                                             <!--{/if}-->
                                        </ul>

                                    </div>
                                </div>

                             </div>
                           <!--{/loop}-->

                         </div>
                    </div>
                      <div class="pages">{$departstr}</div>	
            
           
 

         



              

<!--{template footer}-->