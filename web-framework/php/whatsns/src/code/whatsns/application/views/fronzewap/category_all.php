<!--{template header}-->
  <!--导航提示-->
                    <div class="au_brif ">
                        <span class="au_bref_itemblock {if $status=='hot'} current{/if} ">   <a data-order-by="recommend" href="{url category/viewtopic/hot}">
  <i class="fa fa-book"></i> 推荐</a> </span>
                         <span class="au_bref_itemblock {if $status=='new'} current{/if}"><a data-order-by="hot" href="{url category/viewtopic/new}">
  <i class="fa fa-hacker-news"></i> 最新</a></span>
     <span class="au_bref_itemblock {if $status=='question'} current{/if}"><a data-order-by="hot" href="{url category/viewtopic/question}">
  <i class="fa fa-hacker-news"></i> 问答话题</a></span>
                    </div>
    
                    <!--列表部分-->
                    <div class="au_resultitems huatilist">
                        <!--{loop $catlist  $category1}-->
                       <div class="au_item">
                           <div class="au_huati_img">
                                <a  target="_self" href="{url category/view/$category1['id']}">
      <img src="{$category1['bigimage']}" alt="{$category1['name']}">
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
                   


                    </div>
                    <div class="pages">$departstr</div>

<style>
    body{
        background: #f1f5f8;;
    }
</style>

 

<!--{template footer}-->