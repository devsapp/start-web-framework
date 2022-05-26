  <!--{eval $topdatalist=$this->fromcache('topdata');}-->
                <!--{loop $topdatalist  $topdata}-->
            <div class="banner-head">   
                <div class="title color-666">
                    <div class="red-mark ilblk">●</div>
                    <a href="{$topdata['url']}" class="text ilblk">{$topdata['title']}</a>
                </div>
                <div class="desc color-999 small">
             {eval echo clearhtml(htmlspecialchars_decode(htmlspecialchars_decode($topdata['description'])),100);}  </div>
            </div>
            
     <!--{/loop}-->