    
         <div class="standing">
  <div class="positions bb" id="rankScroll">
      <h3 class="title" style="float: none">热门文章</h3>
      <ul style="padding-top: 10px;">
      



  <!--{eval $weektopiclist = $this->fromcache("weektopiclist");}-->

        <!--{loop $weektopiclist $nindex $topic}-->
              <li class="no-video">
        <a href="{url topic/getone/$topic['id']}" title="{$solve['title']}" >  {$topic['title']}</a>
               <div class="num-ask">
               <a href="{url topic/getone/$topic['id']}" title="{$topic['title']}" class="anum"> {$topic['articles']} 个评论</a>
               </div>
              </li>
                <!--{/loop}-->
               

              </ul>
  </div>
  </div>