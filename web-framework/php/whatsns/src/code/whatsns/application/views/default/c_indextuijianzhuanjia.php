 <div class="same-content bg-fff">
            <div id="industryExperts" class="content">
                <div class="same-list-left">
                    <div class="same-list-menu  clearfix">
                        <div class="menu-title fl clearfix">行业专家</div>
                    </div>
                </div>
                <ul class="clearfix">
                  <!--{eval $expertlist=$this->fromcache('expertlist');}-->
                <!--{loop $expertlist $index $expert}-->
                
                    <li class="fl clearfix color-666">
                        <div class="character clearfix">
                            <a href="javascript:;"><img class="character-img fl" src="{$expert['avatar']}" alt="{$expert['username']}"></a>
                            <div class="character-main fl">
                                <a href="{url user/space/$expert['uid']}" class="color-333">{$expert['username']}</a>
                                <p class="medium color-999" title="{eval echo clearhtml($expert['signature'],100);}">{eval echo clearhtml($expert['signature'],10);}</p>
                            </div>
                        </div>
                        {if $expert['introduction']}
                        <div class="desc medium color-666">{eval echo clearhtml($expert['introduction'],50);}</div>
                      
                        {else}
                           <div class="desc medium color-666">该专家暂未填写任何介绍信息</div>
                      
                        {/if}
                        <div class="bottom clearfix">
                        {if $expert['mypay']>0}
                            <a href="{url question/add/$expert['uid']}" class="ask-btn tc fl active-color bg-fff medium second-theme">¥ {$expert['mypay']} 提问</a>
                         
                          {else}
                            <a href="{url question/add/$expert['uid']}" class="ask-btn tc fl active-color bg-fff medium second-theme">免费咨询</a>
                         
                          {/if}  
                            <p class="fr help color-999 small">已帮助<span class="help-counts ilblk">{$expert['answers']}</span>位网友</p>
                        </div>
                    </li>
                     <!--{/loop}-->     
                </ul>
            </div>
        </div>