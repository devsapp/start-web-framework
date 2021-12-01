<!--{template header}-->
  <!--{eval $adlist = $this->fromcache("adlist");}-->
<link rel="stylesheet" media="all" href="{SITE_URL}static/css/widescreen/css/topic.css" />
<style>
<!--
.main-wrapper {
    margin-bottom: 40px;
    background: #fff;
}
.recommend{
padding-top:10px;
}
.recommend .trigger-menu {
    margin: 0px;
    text-align: left;
}
-->
</style>
<div class="container recommend" >
<div style="background: #fff;padding:10px;">

            <!--广告位1-->
            <!--{if (isset($adlist['category']['left1']) && trim($adlist['category']['left1']))}-->
           
     <div class="advlong-bottom" style="margin-top:0px;">
            <div class="advlong-default">
        
            {$adlist['category']['left1']}
          
            </div>
        </div>
          <!--{/if}-->
          
  <ul class="trigger-menu" data-pjax-container="#list-container">
  <li {if $status=='hot'} class="active"{/if} >
  <a data-order-by="recommend" href="{url category/viewtopic/hot}">
  <i class="fa fa-book"></i> 推荐</a>
  </li>
  <li {if $status=='new'} class="active"{/if} ><a data-order-by="hot" href="{url category/viewtopic/new}">
  <i class="fa fa-hacker-news"></i> 最新</a>
  </li>
  <li {if $status=='question'} class="active"{/if} ><a data-order-by="hot" href="{url category/viewtopic/question}">
  <i class="fa fa-question-circle-o"></i> 问答话题</a>
  </li>

  </li>
  </ul>

<!--话题列表-->
        <div class="all-work-list hotexpertlist">
            <div class="work-list-box">

       <!--{loop $catlist  $category1}-->
                <div class="card-box">
                    <div class="card-img">
                        <a href="{url category/view/$category1['id']}" class="card-img-hover" title=" {$category1['name']}" >
                            <img src="{$category1['bigimage']}" title="{$category1['name']}" alt="">
                        </a>
                    </div>
                    <div class="card-info">
                        <p class="card-info-title">
                            <a href="{url category/view/$category1['id']}" title="{$category1['name']}" class="title-content"  style="width: 178px;"> {$category1['name']}</a>


                        </p>


                        {if $category1['miaosu']}
                        <p class="card-info-type" title="{eval echo clearhtml($category1['miaosu']);}">{eval echo clearhtml($category1['miaosu']);}</p>
                         
                         {else}
                          <p class="card-info-type" title="">该话题暂无描述</p>
                         
                         {/if}


                        <p class="card-info-item">

                      
                            <span class="statistics-comment" title="共{$category1['questions']}讨论">{$category1['questions']}</span>
                            <span class="statistics-collect" title="共{$category1['followers']}关注">{$category1['followers']}</span>

                        </p>
                    </div>

                </div>
                    <!--{/loop}-->

            </div>
        </div>
        
  

    <div class="pages">$departstr</div>
    </div>
                <!--广告位1-->
            <!--{if (isset($adlist['category']['right1']) && trim($adlist['category']['right1']))}-->
           
     <div class="advlong-bottom">
            <div class="advlong-default">
        
            {$adlist['category']['right1']}
          
            </div>
        </div>
          <!--{/if}-->
</div>
<!--{template footer}-->