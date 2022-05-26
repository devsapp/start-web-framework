<!--{template header}-->
<link rel="stylesheet" media="all" href="{SITE_URL}static/css/widescreen/css/search.css" />
<link rel="stylesheet" media="all" href="{SITE_URL}static/css/widescreen/css/activelist.css" />
<div class="container search">
<div class="row">
<div class="aside">
<!--{template tp_search}-->
 </div>
  <div class="col-xs-16 col-xs-offset-6 main">
 <div class="search-content recommend"><!----> <div class="result">检索到{$rownum} 个结果</div>

  <!--{if $userlist}-->
 <div class="row authorlist">





    <!--{loop $userlist $activeuser}-->


                <div class="col-xs-7">
  <div class="wrap">
    <a class="avatar" target="_blank" href="{url user/space/$activeuser['uid']}">
      <img src="{$activeuser['avatar']}" alt="180">
</a>    <h4>
      <a target="_blank" href="{url user/space/$activeuser['uid']}">
      {$activeuser['username']}
       {if $activeuser['author_has_vertify']!=false}<i class="fa fa-vimeo v_person   " data-toggle="tooltip" data-placement="right" title="" data-original-title="认证用户"  ></i>{/if}
      </a>

    </h4>
    <p class="description" title="$activeuser['signature']">{eval echo clearhtml($activeuser['signature'],20);}</p>

{if $activeuser['hasfollower']==1}
      <a class="btn btn-default following" id="attenttouser_{$activeuser['uid']}" onclick="attentto_user($activeuser['uid'])">已关注</a>
{else}
      <a class="btn btn-success follow" id="attenttouser_{$activeuser['uid']}" onclick="attentto_user($activeuser['uid'])">关注</a>
{/if}
    <hr>
    <div class="meta ">战绩</div>
    <div class="recent-update ">

        <div class="news"><span>粉丝  {$activeuser['followers']}个</span>.<span>文章  {$activeuser['articles']}篇</span>.<span>问题  {$activeuser['questions']}个</span></div>


    </div>
  </div>
</div>
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

         </div>
         </div>
         </div>
         </div>
         <script>
         $(".note-list em").addClass("search-result-highlight");
         </script>
