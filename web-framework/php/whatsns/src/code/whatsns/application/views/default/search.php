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

  <!--{if $questionlist}-->
   <div class="stream-list question-stream">
      
          <!--{loop $questionlist $index $question}-->
      <section class="stream-list__item">
                <div class="qa-rank">
              {if $question['answers']==0}
                <div class="answers ml10 mr10">
                {$question['answers']}<small>回答</small></div>
                {else}
                {if $question['status']==2}
                <div class="answers answered solved ml10 mr10">
                 {$question['answers']}<small>解决</small></div>
                {else}
                
                <div class="answers answered ml10 mr10">
                {$question['answers']}<small>回答</small></div>
                {/if}
                {/if}
                <div class="views  viewsword0to99"><span> {$question['views']}</span><small>浏览</small></div>
                </div>        <div class="summary">
            <ul class="author list-inline">
                                                <li>
                                                
        {if $question['hidden']!=1}
                                            <a href="{url user/space/$question['authorid']}">    {$question['author']}
                 {if $question['author_has_vertify']!=false}<i class="fa fa-vimeo {if $question['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  " data-toggle="tooltip" data-placement="right" title="" {if $question['author_has_vertify'][0]=='0'}data-original-title="个人认证" {else}data-original-title="企业认证" {/if} ></i>{/if}</a>
                      {else}
                      匿名用户
                      {/if}
                        <span class="split"></span>
                        <a href="{url question/view/$question['id']}" class="askDate" >{$question['format_time']}</a>
                                    {if $question['shangjin']!=0}
                      <span data-toggle="tooltip" data-placement="bottom" title="" data-original-title="如果回答被采纳将获得 {$question['shangjin']}元，可提现" class="icon_hot" style="color:#fff;"><i class="fa fa-cny mar-r-03"></i>悬赏$question['shangjin']元</span>
                    {/if}
                                    </li>
            </ul>
            <h2 class="title"><a href="{url question/view/$question['id']}">{$question['title']}</a></h2>

                     <!--{if $question['tags']}-->
           <ul class="taglist--inline ib">
<!--{loop $question['tags'] $tag}-->
<li class="tagPopup authorinfo">
                        <a class="tag" href="{url tags/view/$tag['tagalias']}" >
                                                       {$tag['tagname']}
                        </a>
                    </li>
                    

                           
                <!--{/loop}-->
                 </ul>
                <!--{else}--><!--{/if}-->
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
{eval $articlelist=$this->db->like('title',$word, 'both')->from('topic')->limit(10,0)->get()->result_array();}
        {if $articlelist}
        
<div class="relativecontent">
<h2>相关文章</h2>
<div>
<div class="threads">
                                  
                                      <!--{loop $articlelist $index $article}-->
                                                                                                           <p class="news">
                                • <a href="{url topic/getone/$article['id']}" target="_blank" title="{$article['title']}">{$article['title']}</a>
                            </p>
                            <!--{/loop}-->
                                                           <p class="more_link" style="width:100%;">
                                <a href="{url topic/search}?word={$word}" target="_self">查看更多</a>
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
