<!--{template header}-->
<link rel="stylesheet" media="all" href="{SITE_URL}static/css/widescreen/css/search.css" />
<<style>
<!--
.album-card-box, .card-box{
    border: solid 1px #f5f5f5;
}
-->
</style>
<div class="container search">
<div class="row">
<div class="aside">
<!--{template tp_search}-->
 </div> <div class="col-xs-16 col-xs-offset-6 main">
 <div class="search-content"><!----> <div class="result">检索到{$rownum} 个结果</div>

  <!--{if $catlist}-->
  
        <!--话题列表-->
        <div class="all-work-list hotexpertlist">
            <div class="work-list-box">

     <!--{loop $catlist $category1}-->
        
                <div class="card-box">
                    <div class="card-img">
                        <a href="{url category/view/$category1['id']}" class="card-img-hover" title=" {$category1['name']}" >
                            <img src="{$category1['image']}" title="{$category1['name']}" alt="">
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

                            <span class="statistics-view" title="共448人气">448</span>
                            <span class="statistics-comment" title="共{$category1['questions']}讨论">{$category1['questions']}</span>
                            <span class="statistics-collect" title="共{$category1['followers']}关注">{$category1['followers']}</span>

                        </p>
                    </div>

                </div>
                    <!--{/loop}-->

            </div>
        </div>
        
   <!--{else}-->
       <div id="no-result">
                <p>抱歉，未找到和您搜索相关的内容。</p>
                <strong>建议您：</strong>
                <ul class="nav">
                    <li><span>检查输入是否正确</span></li>
                    <li><span>简化查询词或尝试其他相关词</span></li>
                </ul>
            </div>
    <!--{/if}-->

<div class="pages">  {$departstr}</div>

         </div>
         </div>
         </div>
         </div>
         <script>
         $(".note-list em").addClass("search-result-highlight");
         </script>
