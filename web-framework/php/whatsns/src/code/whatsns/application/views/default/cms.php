                       <!-- 第三方cms调用 -->  

            
              <!--{eval $articlelist=$this->fromcache('articlelist');}-->
               
    <!--{if $articlelist}-->
    <div class="split-line"></div>
       <div class="recommend">
   <div class="title"><span>资讯浏览</span></div>
   <ul class="list">



          <!--{loop $articlelist $index $article}-->
                       <li > <a class="li-a-title" title="{$article['title']}" target="_blank" href="{$article['href']}"> {$article['title']}</a></li>
                       <!--{/loop}-->


      </ul>
    
    

    </div>
            <!--{/if}-->