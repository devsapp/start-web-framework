{template header}
    <main class="container" {if is_mobile()}style="margin-top:60px;"{/if}>
        <div class="html-main">
                            <div class="post-main">
                          {template index_lunbo}
        <div class="post-list-page-plane">
        <div class="list-plane-title">
                    {eval $indexarticlelist=15;}
          {eval $topiclist=$this->getlistbysql("select id,image,author,title,views,describtion,state,ispc,viewtime,articles,articleclassid  from ".$this->db->dbprefix."topic where state!=0 order by viewtime desc limit 0,$indexarticlelist");}
 
             <p>最新文章</p>        </div>
           {template tmp_articlelist}  
     
        <div class="pages">
            <div class="fenye"><a href="{url seo/index}" class="extend" >阅读更多</a></div>
        </div>
    </div>
                </div>
                <div class="sidebar">
         {template rightbtn}
     
                    <div class="aside-box"><form class="search-form" action="{url topic/search}" method="post" role="search">
    <div class="search-form-input-plane">
        <input type="text" class="search-keyword" name="word" placeholder="搜索内容" value="">
    </div>
  <div>
      <button type="submit" class="search-submit" value="">搜索</button>
  </div>
</form></div>

   <!-- 热门讨论问题 -->
     {template index_hotquestion}
      <!-- 最新注册用户 -->
   {template index_newregisteruser}
   
   <!-- 最近评论 -->
    {template right_lastpinglun}
    
   <!-- 最新文章-->
            {template right_lastwenzhang}
             <!-- 右侧广告位 -->
    {template index_rightadv}
    
   <!-- 站长推荐文章 -->
             {template index_tuijianwenzhang}
               <!-- 友情链接 --> 
   {template friend_link}
                          </div>
                        </div>
    </main>
  {template footer}