  
    
     <!--{eval $attentionlist = $this->fromcache("attentionlist");}-->
                               
    <div class="standing" style="margin-top:20px;">
  <div class="positions bb" id="rankScroll">
      <h3 class="title" style="float:none;" >一周热门问题</h3>
      <ul>
      
           <!--{loop $attentionlist $index $solve}-->

              <li class="no-video">
        <a href="{url question/view/$solve['id']}" title="{$solve['title']}" >   {$solve['title']} </a>
               <div class="num-ask">
               <a href="{url question/view/$solve['id']}"  class="anum"> {$solve['answers']} 个回答</a>
               </div>
              </li>
           
                 
  <!--{/loop}-->
              </ul>
  </div>
  </div>
    