<!--{template header}-->
<!--用户中心大背景--->
<div class="row nopadding nomargin">
  <!--{template user_banner}-->

</div>


<!--用户中心大背景结束标记-->

<!--用户中心-->

<div class="user-home bg-white">
    <div class="container">

        <div class="row ">
            <div class="col-sm-9">
            <!-- 用户title部分导航 -->
              <!--{template user_title}-->
             <!-- title结束标记 -->
       <!-- 内容页面 -->  
    <div class="row">
                 <div class="col-sm-12">
                     <div class="dongtai">
                         <p>
                             <strong class="font-18">{$navtitle}</strong>
                         </p>
                        
                         <hr>
                      

                 <form name="favoriteForm" method="post" action="{url favorite/delete}" onsubmit="return check_form();">      
                    
                    <!--{if $favoritelist}-->

   
    <ul class="main_con_qiangda_list clearfix">
  
            <!--{loop $favoritelist $question}-->
                
        <li>
            <a target="_blank" href="{url question/view/$question['qid']}" title="{$question['title']}">
                <div class="left">{$question['answers']}<br>回答</div>
                <div class="uright">
                    <p class="otw text-nowrap ">  <input name="id[]" type='checkbox' value="{$question['id']}" />&nbsp; 
                   
                    {if $question['adopttime']>0}
                     <i class="icon icon-check-sign text-danger mar-r-03"></i>
                    
                    {else}  <i class="icon icon-question-sign text-danger mar-r-03"></i>{/if}
                  
                    
                    {$question['title']}</p>
                    
                  
                    <span>{$question['format_time']}</span>
                </div>
            </a>
        </li>
         <!--{/loop}-->

      

    </ul>
    
    <div class="row">
    
        <div class="col-sm-2">
    <button type="submit"  name="submit" class="btn btn-success">删除</button>
     <input type="checkbox" value="chkall" id="chkall" onclick="checkall('id[]');"/> 全选 
    </div>
    
    
    </div>
 <div class="pagination" id="list-page">
                        <p class="pages">
                           {$departstr}
                        </p>
                    </div>
   <!--{else}-->
   <div class="row">
   
                            <div class="col-sm-12">
                            

                             <p>    暂无收藏问题</p>
                            </div>
                        </div>
    <!--{/if}-->
                              
  </form>
                      
                     </div>
                 </div>


             </div>
            </div>
           
            <!--右侧栏目-->
            <div class="col-sm-3 mar-t-2">


              

                <!--导航列表-->

               <!--{template user_menu}-->

                <!--结束导航标记-->


                <div>

                </div>


            </div>

        </div>

    </div>

</div>


<!--用户中心结束-->
<script type="text/javascript">
                function check_form() {
                    if (confirm("确定删除所选？该操作不可恢复") === true) {
                        return true;
                    }
                    return false;
                }
</script>
<!--{template footer}-->