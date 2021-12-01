   <ul class="post-list">
    
 {loop $topiclist $article}
            <li class="post-item">
    <div class="post-item-container">
        <div class="post-item-thumbnail">
            <img src="{$article['image']}" alt="">
        </div>
        <div class="post-item-main">
            <h2>
                <a href="{url topic/getone/$article['id']}" target="">{$article['title']}</a>
            </h2>
            <div class="post-item-content">
 {eval echo clearhtml(htmlspecialchars_decode($article['describtion']),130);}         </div>
            <div class="post-item-info">
                <div class="post-item-tags">
                 {eval $categoryname=$this->category[$article['articleclassid']]['name']}
                                            <i class="cat-item-mark"></i><span class="cat-item"><a href="{url category/view/$article['articleclassid']}">{$categoryname}</a></span>
                                        </div>
                <div class="post-item-meta">
                    <div class="post-item-meta-time">
                       {$article['author']}                      <span class="post-item-time">{eval $atime= date('Y-m-d H:i:s',$article['viewtime']);}{if strstr( $atime,'1970')}{$article['viewtime']}{else}{$atime}{/if}</span>
                    </div>
                    <div class="item-post-meta-other">

                        <span><i class="fa fa-eye" aria-hidden="true"></i>{$article['views']}</span>                        <span><i class="fa fa-comments" aria-hidden="true"></i>{$article['articles']}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</li>
{/loop}
        </ul>