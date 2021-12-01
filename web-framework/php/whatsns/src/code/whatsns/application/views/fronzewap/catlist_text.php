<!--{template meta}-->
<section class="ui-container">
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
     <!--话题介绍-->
 <!--话题介绍-->
                  <!--话题介绍-->
                    <div class="au_category_huati_info">
                           <div class="ui-row-flex">
                               <div class="ui-col">
                                   <div class="au_category_huati_img">
                                    <a href="{url topic/catlist$catmodel['id']}">
                                       <img src="$catmodel['bigimage']">
                                       </a>
                                   </div>
                               </div>
                               <div class="ui-col ui-col-3">
                                   <div class="au_category_huati_name"> <a  href="{url topic/catlist$catmodel['id']}"> {$catmodel['name']}</a></div>
                                   <div class="au_category_info_meta">
                                       <div class="au_category_info_meta_item"><i class="fa fa-question-circle hong"></i>{$catmodel['questions']}个问题</div>
                                       <div class="au_category_info_meta_item"><i class="fa fa-user lan"></i>{$catmodel['followers']}人关注</div>
                                       <div class="au_category_info_meta_item"><i class="fa fa-file-text-o ju "></i>{$trownum}篇文章</div>
                                   </div>
                               </div>
                         
                           </div>

                        <!--子话题-->
                        {if $catlist}
                        <div class="ui-row-flex">
                            <div class="i-col ui-col  au_category_info_childlist">

                                <div class="swiper-container" >
                                    <div class="swiper-wrapper">
                                        <!--{loop $catlist $index $cat}-->
                                        
                                        <div class="swiper-slide" data-swiper-autoplay="2000">
                                         
                                            
                                                    <div class="au_category_info_child">
                                                        <a href="{url topic/catlist/$cat['id']}">
                                                        <div class="au_category_info_child_img">
                                                            <img src="$cat['image']">
                                                        </div>
                                                        <p class="au_category_info_child_text">{$cat['name']}</p>
                                                        </a>
                                                    </div>
                                                

                                           
                                        </div>
                                  <!--{/loop}--> 
                                    </div>

                                </div>
                                <!-- 如果需要导航按钮 -->
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-button-next"></div>



                            </div>

                        </div>
                       {/if}
                    </div>
                  
                     <!--导航提示-->
                    <div class="au_brif wzbrif">
                        <span class="au_bref_item current "> 
                           <a href="{url topic/catlist/$cid}">全部文章</a> </span>
                              {if $catmodel['isuseask']}
                         <span class="au_bref_item">
                         <a href="{url category/view/$catmodel['id']}">相关讨论</a>
  </span>   {/if}
                    </div>
                       <!--列表部分-->
                       <div class="au_resultitems myjiaocheng">
                        <!--{loop $topiclist $index $topic}-->   
                        <div class="au_item"  {if $topic['image']!=null} style="height:auto" {/if}>
                          <div class="au_question_title">    <a   href="{url topic/getone/$topic['id']}"  >{$topic['title']}</a></div>
                          <div class="au_question_user_info">
                               <a class="" href="{url user/space/$topic['authorid']}">
                    <img class="au_question_user_info_avatar" src="{$topic['avatar']}" >
                </a>  <span>      <a class="blue-link" target="_blank" href="{url user/space/$topic['authorid']}">
                {$topic['author']}
                  {if $topic['author_has_vertify']!=false}<i class="fa fa-vimeo {if $topic['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  " data-toggle="tooltip" data-placement="right" title="" {if $topic['author_has_vertify'][0]=='0'}data-original-title="个人认证" {else}data-original-title="企业认证" {/if} ></i>{/if}
                </a></span>
                              <span><i class="fa fa-eye"></i>{$topic['views']}阅读 </span>
                              <span><i class="fa fa-twitch"></i>{$topic['articles']}评论 </span>
                           
                            
                          </div>
                           <div class="au_question_info_content">
                             
   
                                  {if $topic['price']!=0}
                         <div class="box_toukan ">
											
										
											<a  class="thiefbox font-12" ><i class="icon icon-lock font-12"></i> &nbsp;阅读需支付&nbsp;$topic['price']&nbsp;&nbsp;积分……</a>
											
											
										    
										</div>
                   {else}
                    {eval echo strip_tags($topic['description']);}
                    {/if}
                           </div>
                          
                        </div>
                   
    <!--{/loop}-->
                    </div>
                 
              
               <div class="pages">{$departstr}</div>
                    








<script>
    var swiper = new Swiper('.swiper-container', {
        loop:true,
        autoplay:2000,
        slidesPerView: 3,
        paginationClickable: true,
        spaceBetween: 10,
        // 如果需要前进后退按钮
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        }
    });
    var intswper=setInterval("swiper.slideNext()", 2000);
    $(".swiper-container").hover(function(){
        clearInterval(intswper);
    },function(){
        intswper=setInterval("swiper.slideNext()", 2000);
    })
</script>
</section>
<!--{template footer}-->