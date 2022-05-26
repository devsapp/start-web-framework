<!--{template header}-->
<!--{eval $adlist = $this->fromcache("adlist");}-->

<div class="container index">

              <!--广告位1-->
            <!--{if (isset($adlist['question_view']['inner1']) && trim($adlist['question_view']['inner1']))}-->
           
     <div class="advlong-bottom">
            <div class="advlong-default">
        
            {$adlist['question_view']['inner1']}
          
            </div>
        </div>
          <!--{/if}-->
       <!--站长推荐-->
        <div class="subnav-content-wrap" id="tab_anchor" style="height: 56px;">
            <div class="subnav-wrap" style="left: 0px;">
                <div class="top-hull">
                    <div class="subnav-contentbox">
                        <div class="tab-nav-container">
                            <ul class="subnav-content text-center">
                                <li id="course-li" class="current"><a href="{url topic/hotlist}" class="title" z-st="home_tab_home">站长推荐</a></li>
                           
                            </ul>
                            <div>



                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
          <!--文章列表-->
        <div class="all-work-list">
            <div class="work-list-box">
            
                 <!--{loop $topiclist $nindex $topic}-->
                <div class="card-box">
                    <div class="card-img">
                        <a href="{url topic/getone/$topic['id']}" class="card-img-hover" title="{$topic['title']}" >
                            <img src="{$topic['image']}" title="{$topic['title']}" alt="">
                        </a>
                    </div>
                    <div class="card-info">
                        <p class="card-info-title">
                            <a href="{url topic/getone/$topic['id']}" title="{$topic['title']}" class="title-content"  style="width: 178px;">{$topic['title']}</a>


                        </p>



                        <p class="card-info-type" title="{$topic['describtion']}">{$topic['describtion']}</p>



                        <p class="card-info-item">

                            <span class="statistics-view" title="共{$topic['views']}人气">{$topic['views']}222</span>
                            <span class="statistics-comment" title="共{$topic['articles']}评论">{$topic['articles']}22</span>
                            <span class="statistics-collect" title="共{$topic['likes']}收藏">{$topic['likes']}222</span>
                           
                        </p>
                    </div>
                    <div class="card-item">
        <span class="user-avatar showMemberCard">
            <a href="{url user/space/$topic['authorid']}" title="{$topic['author']}" >
            <img src="{$topic['avatar']}"  width="30" height="30" alt="">
         {$topic['author']}

        </a>


        </span>

                        <span class="time" >{eval echo date('m-d H:s',$topic['sortime']);}</span>
                    </div>
                    {if $user['groupid']==1}
                    <div class="cancelhot">
                     <span><a title="取消热文推荐" href="{url topic/cancelhot/$topic['id']}">取消推荐</a></span>
                    </div>
                    {/if}
                </div>
               
                <!--{/loop}-->
              
                <!--分割-->
            </div>

        </div>
            <div class="pages">
    $departstr
    </div>
    <div class="all-work-list">
	<p class="album-title">最新发布
	<a href="{url topic/default}" class="more">查看全部&nbsp;&nbsp;<i class="specific-symbol"></i></a>
	</p>
	<div class="hot-album">
		   <!--{eval $newtopiclist=$this->fromcache('topiclist');}-->
		 <!--{loop $newtopiclist $nindex $topic}-->
                <div class="card-box">
                    <div class="card-img">
                        <a href="{url topic/getone/$topic['id']}" class="card-img-hover" title="{$topic['title']}" >
                            <img src="{$topic['image']}" title="{$topic['title']}" alt="">
                        </a>
                    </div>
                    <div class="card-info">
                        <p class="card-info-title">
                            <a href="{url topic/getone/$topic['id']}" title="{$topic['title']}" class="title-content"  style="width: 178px;">{$topic['title']}</a>


                        </p>



                        <p class="card-info-type" title="{$topic['describtion']}">{$topic['describtion']}</p>



                        <p class="card-info-item">

                            <span class="statistics-view" title="共{$topic['views']}人气">{$topic['views']}</span>
                            <span class="statistics-comment" title="共{$topic['articles']}评论">{$topic['articles']}</span>
                            <span class="statistics-collect" title="共{$topic['likes']}收藏">{$topic['likes']}</span>

                        </p>
                    </div>
                    <div class="card-item">
        <span class="user-avatar showMemberCard">
            <a href="{url user/space/$topic['authorid']}" title="{$topic['author']}" >
            <img src="{$topic['avatar']}"  width="30" height="30" alt="">
         {$topic['author']}

        </a>


        </span>

                        <span class="time" >{eval echo date('m-d H:s',$topic['sortime']);}</span>
                    </div>
                </div>
               
                <!--{/loop}-->




	</div>
</div>
   


    </div>
<!--{template footer}-->