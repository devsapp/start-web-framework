<div class="c_btns">
              <!--{if $is_followed}-->
              <a href="{url question/attentto/$qid}">     <div class="btnhassoucang">
               已收藏问题
               </div></a>
              
          
                  <!--{else}-->
                    <a href="{url question/attentto/$qid}">      <div class="btnsoucang">
               收藏问题
               </div></a>
                   
                   <!--{/if}-->
                
                  {if $question['shangjin']==0||$question['shangjin']>0&&$question['answers']<$setting['xuanshang_question_answers']}
                  	{if $cananswerthisquestion==true}
                  	{if $setting['cananswerselfquestion']==0&&$user['uid']!=$question['authorid']||$setting['cananswerselfquestion']==1}
                   {if $user['uid']==0}
                  <div class="btnwirteans" onclick="window.location.href='{url user/login}'">
                                                                写回答
               </div>
               {else}
                   <div class="btnwirteans" >
               写回答
               </div>
                  {/if}
               {/if}
                   {/if}
                   
                 {/if}
            </div>
            
            <div class="show-foot">
            {if $question['cid']}
            <p>本问题来自话题:<a href="{eval echo getcaturl($question['cid'],'category/view/#id#');}" >{$question['category_name']}</a>
             <a class="reportques" onclick="openinform({$qid},'{$question['title']}',0)"  id="report-modal">举报</a></p>
              <span style="clear:both;">
    </span>
             {/if}
                       
             
            </div>
   <script>
   g_uid=$user['uid'];
 //判断是否是微信浏览器的函数
   function isWeiXin(){
     //window.navigator.userAgent属性包含了浏览器类型、版本、操作系统类型、浏览器引擎类型等信息，这个属性可以用来判断浏览器类型
     var ua = window.navigator.userAgent.toLowerCase();
     //通过正则表达式匹配ua中是否含有MicroMessenger字符串
     if(ua.match(/MicroMessenger/i) == 'micromessenger'){
     return true;
     }else{
     return false;
     }
   }
        $(".btnwirteans").click(function(){

        if(isWeiXin()){
        	canyuyin=1;
        }


        	
        
        		if(canyuyin){
        			  $('.huidacaozuo').removeClass('hide').addClass('show');
        		}else{
        	    	
        			  var dia2=$(".answerbox").show();

        		}

        });
   </script>
