<!--{template meta}-->
    <style>
        body{
            background: #f1f5f8;
        }
    </style>

    <div class="ws_header">
        <i class="fa fa-home" onclick="window.location.href='{url index}'"></i>
        <div class="ws_h_title">{$setting['site_name']}</div>
        <i class="fa fa-search"  onclick="window.location.href='{url question/searchkey}'"></i>
    </div>

    <!--导航提示-->
    <div class="ws_s_au_brif">
        <span class="ws_s_au_bref_item "><a href="{url question/search/$word}">问题</a></span>

        <span class="ws_s_au_bref_item "><a href="{url topic/search}?word={$word}">文章</a></span>
        <span class="ws_s_au_bref_item "><a  href="{url user/search}?word={$word}">用户</a></span>
        <span class="ws_s_au_bref_item current"><a href="{url category/search}?word={$word}">话题</a></span>
<span class="ws_s_au_bref_item "><a href="{url kecheng/search}?word={$word}">课程</a></span>
<span class="ws_s_au_bref_item "><a href="{url kecheng/searchcomment}?word={$word}">课程评论</a></span>

    </div>
     <!--列表部分-->
                    <div class="au_resultitems au_searchlist">
                    <!--{if $catlist}-->


                        <!--{loop $catlist  $category1}-->
                       <div class="au_item">
                           <div class="au_huati_img">
                                <a  target="_self" href="{url category/view/$category1['id']}">
       <img src="{$category1['image']}" alt="{$category1['name']}">
</a>
                           </div>
                           <div class="au_huati_info">
                               <div class="au_huati_info_name">
                                   {if $category1['follow']}
                                   <div class="au_btn_guanzhu following" id="attenttouser_{$category1['id']}" onclick="attentto_cat($category1['id'])"><i class="fa fa-check"></i><span>已关注</span></div>
                                   {else}
                                    <div class="au_btn_guanzhu follow" id="attenttouser_{$category1['id']}" onclick="attentto_cat($category1['id'])">+关注</div>
                                   {/if}
                               <a target="_self" href="{url category/view/$category1['id']}">{$category1['name']}</a>
                               </div>
                               <div class="au_huati_info_desc">




                                  {$category1['miaosu']}

                               </div>
                               <div class="au_huati_info_meta">
                                   <div class="au_huati_info_meta_item"><i class="fa fa-question-circle red"></i>{$category1['questions']}个问题</div>
                                   <div class="au_huati_info_meta_item"><i class="fa fa-user lan"></i>{$category1['followers']}人关注</div>
                               </div>
                           </div>
                       </div>
                  <!--{/loop}-->






        <div class="pages">  {$departstr}</div>
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

                    </div>
  <script>

   el2=$.tips({
        content:' 为您找到相关结果约{$rownum}个',
        stayTime:3000,
        type:"info"
    });
   </script>
<!--{template footer}-->