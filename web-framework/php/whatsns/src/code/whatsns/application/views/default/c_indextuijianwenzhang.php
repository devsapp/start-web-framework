<div class="same-content">
            <div id="columnist" class="content">
                <div class="same-list-menu">
                    <div class="menu-title">推荐文章</div>
                </div>
                <ul class="columnist-list bg-fff clearfix">
                            <!--{eval $topiclist=$this->fromcache('hottopiclist');}-->
                 <!--{loop $topiclist $nindex $topic}-->
                    <li class="fl clearfix">
                            <a href="{url topic/getone/$topic['id']}"> <img  width="145" height="104" src="{$topic['image']}" alt="{$topic['title']}" class="fl img"></a>
                        <div class="cons fl">
                            <a href="{url topic/getone/$topic['id']}" class="tit ellipsis">{$topic['title']}</a>
                            <div class="middle medium clearfix">
                                <img  src="{$topic['avatar']}" alt="{$topic['author']}" class="fl head-img">
                                <a href="{url user/space/{$topic['authorid']}}" class="fl name color-666">{$topic['author']}</a>
                                  {eval $tc= $this->category[$topic['articleclassid']];}
                               {if $tc}

                               
                                <span class="fl text color-999">
                                        发布于
                                    </span>
                                <a href="{eval echo getcaturl($tc['id'],'topic/catlist/#id#');}" class="client active-color">
                                       {$tc['name']}
                                </a>
                                 {/if}
                            </div>
                            <div class="desc  color-999 medium">{eval echo clearhtml($topic['describtion'],40);}</div>
                        </div>
                    </li>
                    <!--{/loop}-->
                </ul>
            </div>
        </div>