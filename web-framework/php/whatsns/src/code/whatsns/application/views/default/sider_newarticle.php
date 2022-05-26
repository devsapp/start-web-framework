   <!--{eval $newtopiclist=$this->fromcache('topiclist');}-->
    <!--{if $newtopiclist}-->
    <div class="split-line"></div>
       <div class="recommend">
   <div class="title"><span>最新文章</span>
    <span class="morelink">
     <a href="{url topic}"><i class="fa fa-ellipsis-h" ></i></a>
    </span>
   </div>
   <ul class="list">



           <!--{loop $newtopiclist $index $topic}-->
                       <li ><a  class="li-a-title" target="_self" href="{url topic/getone/$topic['id']}" title="{$topic['title']}">{$topic['title']}</a></li>
                       <!--{/loop}-->


      </ul>



    </div>
            <!--{/if}-->