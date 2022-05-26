           <div class="c_btns">
              <!--{if $isfollowarticle}-->
              <a href="{url favorite/delfavoratearticle/$topicone['id']}">     <div class="btnhassoucang">
               已收藏文章
               </div></a>
              
          
                  <!--{else}-->
                    <a href="{url favorite/topicadd/$topicone['id']}">      <div class="btnsoucang">
               收藏文章
               </div></a>
                   
                   <!--{/if}-->
           
                   {if $user['uid']==0}
                  <div class="btnwirteans" onclick="window.location.href='{url user/login}'">
                                                                写评论
               </div>
               {else}
                   <div class="btnwirteans" >
               写评论
               </div>
               {/if}
                
            </div>
            <script>

            $(".btnwirteans").click(function(){
            	 $(".comment-area").focus();
            })

            </script>