
<!--{template header}-->


<div class="container bg-white mar-t-1 mar-b-1">
<div class="row">
<div class="col-sm-6">
<h3 class="font-15 mar-t-03">
站长推荐</h3>
<hr>
  <!--{eval $topiclist=$this->fromcache('hottopiclist');}-->
 <!--{if $topiclist}-->
<div id="myNiceCarousel" class="carousel slide" data-ride="carousel">
  
  <!-- 圆点指示器 -->
  <ol class="carousel-indicators">
  
              <!--{loop $topiclist $nindex $topic}-->
                <!--{if $nindex<=6}-->
    <li data-target="#myNiceCarousel" data-slide-to="{$nindex}"  <!--{if $index==1}-->class="active" <!--{/if}-->></li>
  
    
       <!--{/if}-->
               <!--{/loop}-->
             
  </ol>

  <!-- 轮播项目 -->
  <div class="carousel-inner">
   
  
 
            <!--{if $topiclist}-->
              <!--{loop $topiclist $index $topic}-->
                <!--{if $index<=6}-->
               <div onclick="window.location.href='{url topic/getone/$topic['id']}'" class="hand item  <!--{if $index==1}-->active  <!--{/if}-->">
      

                     {eval $indexx=strstr($topic['image'],'http');}
                       {if $indexx>=0 }
                            
                             <img width="100%" height="300px" src="{$topic['image']}" alt="">
                            {else}
                            <img width="100%" height="300px" src="{SITE_URL}{$topic['image']}" alt="">
                            
                            {/if}
                       
                      
                            
      <div class="carousel-caption">
        <h3>{$topic['title']}</h3>
        <p>{eval echo cutstr(strip_tags($topic['describtion']),120,'');}</p>
      </div>
    </div>
                           <!--{/if}-->
               <!--{/loop}-->
              <!--{/if}-->
              
  </div>

  <!-- 项目切换按钮 -->
  <a class="left carousel-control" href="#myNiceCarousel" data-slide="prev">
    <span class="icon icon-chevron-left"></span>
  </a>
  <a class="right carousel-control" href="#myNiceCarousel" data-slide="next">
    <span class="icon icon-chevron-right"></span>
  </a>
</div>
 <!--{/if}-->
</div>

<div class="col-sm-6 b-l-line">
<h3 class="font-15 mar-t-03">
最新问题</h3>
<hr>
<div class="row">
                <!--{eval $nosolvelist=$this->fromcache('nosolvelist');}-->
                <!--{loop $nosolvelist $index $question}-->
                
  <div class="col-sm-6 mar-t-1">
            <a target="_blank" href="{url question/view/$question['id']}" title="{$question['title']}">
              {eval echo cutstr({$question['title']},40,'');}
                  
                   
            </a>
   </div>
         <!--{/loop}-->

        </div>

</div>

</div>
<div class="new-articles">

<h3 class="font-18 mar-t-1">热门新知</h3>
<hr>
<div class="row">

<div class="col-sm-4">
  <ul class="nav">
          <!--{loop $topiclist1 $index $topic}-->
          <!--{if 0==$index}-->
           <li class="first b-b-line">
        <a target="_blank" class="pic" href="{url topic/getone/$topic['id']}">
    {eval $indexx=strstr($topic['image'],'http');}
                       {if $indexx>=0 }
                             <img  width="100%" height="192" src="{$topic['image']}" alt="">
                            {else}
                            <img  width="100%" height="192" src="{SITE_URL}{$topic['image']}" alt="">
                            
                            {/if}
                       
                           
        </a>
        <a target="_blank" href="{url topic/getone/$topic['id']}" class="desc">{$topic['title']}</a>
        </li>
        
         <!--{else}-->
          <li class="b-b-line"><a target="_blank" href="{url topic/getone/$topic['id']}">{$topic['title']}</a></li>
         
           <!--{/if}-->
           
            <!--{/loop}-->
       
       
        </ul>
</div>

<div class="col-sm-4">
 <ul class="nav ">
         <!--{loop $topiclist2 $index $topic}-->
          <!--{if 0==$index}-->
           <li class="first b-b-line">
        <a target="_blank" class="pic" href="{url topic/getone/$topic['id']}">
        {eval $indexx=strstr($topic['image'],'http');}
                       {if $indexx>=0 }
                            
                             <img width="100%" height="192"  src="{$topic['image']}" alt="">
                            {else}
                            <img width="100%" height="192" src="{SITE_URL}{$topic['image']}" alt="">
                            
                            {/if}
        </a>
        <a target="_blank" href="{url topic/getone/$topic['id']}" class="desc">{$topic['title']}</a>
        </li>
        
         <!--{else}-->
          <li class="b-b-line"><a target="_blank" href="{url topic/getone/$topic['id']}">{$topic['title']}</a></li>
         
           <!--{/if}-->
           
            <!--{/loop}-->
        </ul>
</div>


<div class="col-sm-4">
 <ul class="nav ">
        <!--{loop $topiclist3 $index $topic}-->
          <!--{if 0==$index}-->
           <li class="first b-b-line">
        <a target="_blank" class="pic" href="{url topic/getone/$topic['id']}">
      {eval $indexx=strstr($topic['image'],'http');}
                       {if $indexx>=0 }
                            
                             <img  width="100%" height="192" src="{$topic['image']}" alt="">
                            {else}
                            <img  width="100%" height="192" src="{SITE_URL}{$topic['image']}" alt="">
                            
                            {/if}
        </a>
        <a target="_blank" href="{url topic/getone/$topic['id']}" class="desc">{$topic['title']}</a>
        </li>
        
         <!--{else}-->
          <li class="b-b-line"><a target="_blank" href="{url topic/getone/$topic['id']}">{$topic['title']}</a></li>
         
           <!--{/if}-->
           
            <!--{/loop}-->
        </ul>
</div>

</div>


<div class="cat-article">
<h3 class="font-18 mar-t-1">更多资讯</h3>
     <ul class="nav navbar-nav">
         
        <!--{eval $categorylist=$this->fromcache('categorylist');}-->
                <!--{loop $categorylist  $category1}-->
                {eval $num=rand(0,$cout);$vpic=$arr[$num];}
         
               
                 
                  <li><a target="_blank" href="{url cat-$category1['id']}"><i class="$vpic"></i>{$category1['name']}</a></li>
                 
                
                   <!--{/loop}-->
      
       </ul>

</div>
</div>


</div>

<div id="bottom_ask" class="bottom-fixed" style="">
        <a class="bottom-close" href="javascript:void(0)"></a>
        <div class="bd">
            <i class="left"></i>
            <span class="center ">
           
               
                
                             <span class="text-danger font-18 bold">  来一篇原创,上千网友给你打赏，也许下一个作家就是你 </span>
                             
                  <a class="btn btn-danger" href="{url user/addxinzhi}">我要发表</a>
              
             
            </span>
        </div>
    </div>
<script>
$("#bottom_ask .bottom-close").click(function(){
	document.getElementById('bottom_ask').style.display='none';
})

</script>
<!--{template footer}-->