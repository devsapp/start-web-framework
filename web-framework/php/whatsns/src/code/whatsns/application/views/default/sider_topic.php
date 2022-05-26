  <div class="lfrecommend" ><div class="title">

    <h2 class="h4 widget-box__title">推荐话题</h2>
  
   </div>
        <ul class="list">

        <!--{eval $categorylist=$this->fromcache('categorylist');}-->
                <!--{loop $categorylist $index $category1}-->
                {if $index<8 }
        <li >
        <a href="{url category/view/$category1['id']}" target="_self" class="avatar">
        <img src="$category1['bigimage']" alt="{$category1['name']}" class="topicavatar" >
        </a>



        <a href="{url category/view/$category1['id']}" target="_self" class="name">
           {$category1['name']} <span class="followernum">{$category1['followers']}人关注</span>
        </a>
         <p class="desclipe">
            {eval echo clearhtml($category1['miaosu']);}
        </p></li>
        {/if}
         <!--{/loop}-->
        </ul>
             <a href="{url category/viewtopic/hot}" target="_self" class="find-more">
    查看全部<i class="fa fa-angle-right mar-ly-1"></i></a>
    </div>

