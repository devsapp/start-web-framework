<!--{template header}-->
     
      
        <div class="wl-bannerbox">
                <div class="wl-banner">
                        <a href="{url new/default/2}"><img src="{SITE_URL}static/css/fronze/index/img/banner.png" width="100%" height="auto"></a>
                    </div>

                    <div class="imgmenu">
                            <div class="imgmenubox">
                                <a href="{url ask/index}">
                                    <img src="{SITE_URL}static/css/fronze/index/img/wt.png" width="46" height="46">
                                    <span>问题广场</span>
                                </a>
                            </div>
                            <div class="imgmenubox">
                                    <a href="{url seo/index}">
                                        <img src="{SITE_URL}static/css/fronze/index/img/wz.png" width="46" height="46">
                                        <span>文章资讯</span>
                                    </a>
                            </div>
                            <div class="imgmenubox">
                                    <a href="{url expert/default}">
                                        <img src="{SITE_URL}static/css/fronze/index/img/zj.png" width="46" height="46">
                                        <span>行业专家</span>
                                    </a>
                            </div>
                            <div class="imgmenubox">
                                    <a href="{url tags}">
                                        <img src="{SITE_URL}static/css/fronze/index/img/kc.png" width="46" height="46">
                                        <span>标签库</span>
                                    </a>
                            </div>
                        </div>
        </div>

        <div class="pub-container">
            <div class="inner-box">
                <div class="quick-pub-container">
                        <div class="count-container" >
                            <h3 class="count-title">知识库开源内容付费系统</h3>
                            <div class="count-detail">
                                <p class="count-desc">已帮助 <span>{eval echo  returnarraynum ( $this->db->query ( getwheresql ( 'question',"status=2", $this->db->dbprefix ) )->row_array () ) ;}</span> 位网友解决了问题   总悬赏金额 <span>￥{eval echo  returnarraynum ( $this->db->query ( getwheresql ( 'paylog',"type='wtxuanshang'", $this->db->dbprefix ) )->row_array () ) ;}</span></p>
                            </div>
                            <div class="button-box">
                                <a href="{url question/add}" class="button-item">我要立即发布问题</a>
                            </div>
                            <div class="button-box ">
                                    <a href="{url new/default/5}" class="button-item nobk">我要回答问题赚取赏金</a>
                            </div>
                        </div>
                </div>
            </div>
        </div>

 

        <div class="kecheng-container">
                <div class="title" >
                        <p class="title-text" >热门话题</p>
                        <a href="{url category/viewtopic/question}" class="title-more" >更多></a>
                    </div>
                    <div class="description" >
                        <span class="desc-item" >热点动态</span>
                        <span class="desc-item" >全民讨论</span>
                        <span class="desc-item" >精准回答</span>
                    </div>

                    <div class="content">
                            <div class="swiper-container">
                                    <ul class="swiper-wrapper">
                                                          {eval $indexcatnum= isset($setting['list_indextopiccat'])&&$setting['list_indextopiccat']>0 ? intval($setting['list_indextopiccat']):6;}
      {eval  $huatilist=$this->getlistbysql("select id,questions,name,displayorder,grade from ".$this->db->dbprefix."category where iscourse=0 and isuseask=1 and grade=1 and pid=0 order by displayorder asc  limit 0,$indexcatnum");}
        {if $huatilist}
        
           <!--{loop $huatilist $index $huati}-->
                  {if $index<$indexcatnum}
                  
                                        <li class="swiper-huati">
                                            <a href="{eval echo getcaturl($huati['id'],'category/view/#id#');}"><img width="100" height="100" src="{eval echo get_cid_dir($huati['id']);}"></a>
                                            <div class="text-box">
                                                <div class="text-name hide">{$huati['name']}</div>
                                                <div class="text-number">共{$huati['questions']}个问题</div>
                                            </div>
                                        </li>
                                                        
           {/if}
            <!--{/loop}-->
         {/if}
         
                                    </ul>
                                </div>
                    </div>
        </div>

  
        <div class="newlit">
                <div class="title" >
                        <p class="title-text" >最新</p>
                        <a href="{url ask/index}" class="title-more" >更多></a>
                    </div>
                <ul>
                                                         {eval  $indexquestiontilist=$this->getlistbysql("select id,description,status,title,shangjin,answers,cid from ".$this->db->dbprefix."question where status!=0  order by time desc  limit 0,10");}
        {if $indexquestiontilist}
        
           <!--{loop $indexquestiontilist $index $question}-->
                    <li>
                        <a href="{url question/view/$question['id']}">  {if $question['shangjin']>0} <span>￥{$question['shangjin']}</span>{/if}{$question['title']}</a>
                        <p>{eval echo clearhtml(htmlspecialchars_decode($question['description']),50);}</p>
                        <div class="btbox">
                            <div class="flbox">
                                    {eval $qc= $this->category[$question['cid']];}
                               {if $qc}
                                <a href="{eval echo getcaturl($qc['id'],'category/view/#id#');}">{$qc['name']}</a>
                                {/if}
                            </div>
                            <div class="frbox"><span>{$question['answers']}人</span>已参与回答</div>
                        </div>
                    </li>
                             <!--{/loop}-->
         {/if}
                </ul>
        </div>

  <!--{template footer}-->
