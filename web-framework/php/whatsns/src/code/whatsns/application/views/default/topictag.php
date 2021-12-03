<!--{template header}-->
<style>
.relativecontent h2{
font-size:15px;
font-weight:700;
margin:10px auto;
}
.threads p {
    width: 370px;
    float: left;
    padding-right: 10px;
}
.threads {
    height: auto;
    overflow-y: visible;
}
</style>
<link rel="stylesheet" media="all" href="{SITE_URL}static/css/widescreen/css/search.css" />
<div class="container search">
<div class="row">
<div class="aside">
<!--{template tp_search}-->
 </div> <div class="col-xs-16 col-xs-offset-6 main">
 <div class="search-content"><!----> <div class="result">检索到{$rownum} 个结果</div>

  <!--{if $topiclist}-->
    <div class="stream-list blog-stream">
                        <!--{loop $topiclist $nindex $topic}-->
              <section class="stream-list__item">
              <div class="blog-rank stream__item">
              <div data-id="1190000017247505" class="stream__item-zan   btn btn-default mt0">
              <span class="stream__item-zan-icon"></span>
              <span class="stream__item-zan-number">{$topic['articles']}</span>
              </div></div>
              <div class="summary">
              <h2 class="title blog-type-common blog-type-1">
              <a href="{url topic/getone/$topic['id']}">{$topic['title']}</a></h2>
              <ul class="author list-inline">
              <li>
              <a href="{url user/space/$topic['authorid']}">
              <img class="avatar-24 mr10 " src="{$topic['avatar']}" alt=" {$topic['author']}">
              </a>
              <span style="vertical-align:middle;">
              <a href="{url user/space/$topic['authorid']}"> {$topic['author']}</a>
                    
                    发布于
                                            <a href="{url topic/catlist/$topic['articleclassid']}">{$topic['category_name']}</a>
                                            </span>
                                            </li>
      <li class="bookmark " title="{$topic['likes']} 收藏" >
      <span style="vertical-align:middle;">
      <small class="fa fa-bookmark mr5"></small>
      <span class="blog--bookmark__text">{if $topic['likes']}$topic['likes']{/if} 收藏</span>
      </span></li></ul>
      <p class="excerpt wordbreak ">
       {if $topic['price']!=0}
                         <div class="box_toukan ">

  {eval echo clearhtml($topic['freeconent']);}
  {if $topic['readmode']==2}
											<a  class="thiefbox font-12" ><i class="icon icon-lock font-12"></i> &nbsp;更多阅读需支付&nbsp;$topic['price']&nbsp;&nbsp;财富值……</a>
{/if}
  {if $topic['readmode']==3}
											<a  class="thiefbox font-12" ><i class="icon icon-lock font-12"></i> &nbsp;更多阅读需支付&nbsp;$topic['price']&nbsp;&nbsp;元……</a>
{/if}

										</div>
                   {else}
                     {eval echo clearhtml($topic['describtion']);}
                    {/if}

  
  </p>
      </div>
      </section>
        <!--{/loop}-->
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
   {eval  $questionlist=$this->getlistbysql("select id,title,time from ".$this->db->dbprefix."question where title like '%{$word}%'  order by title desc   limit 0,10");}
        {if $questionlist}
        
<div class="relativecontent">
<h2>相关问题</h2>
<div>
<div class="threads">
                                  
                                      <!--{loop $questionlist $index $question}-->
                                                                                                           <p class="news">
                                • <a href="{url question/view/$question['id']}" target="_blank" title="{$question['title']}">{$question['title']}</a>
                            </p>
                            <!--{/loop}-->
                                                           <p class="more_link" style="width:100%;">
                                <a href="{url question/search}?word={$word}" target="_self">查看更多</a>
                            </p>
                        </div>
</div>
</div>
{/if}
         </div>
         </div>
         </div>
         </div>
         <script>
         $(".note-list em").addClass("search-result-highlight");
         </script>
