   <div class="operationlist">
   {if $question['status']!=9&&$question['status']!=0}
                      <span  onclick="show_comment('{$bestanswer['id']}');">
                     <i class="ui-icon-comment"></i>
                                <span class="ans-comment-num ">
                                    {$bestanswer['comments']}条评论
                                </span>
                    </span>
                       
                                <!--{if  1==$user['grouptype'] ||$user['uid']==$bestanswer['authorid']}-->

                       <a href="{url answer/append/$question['id']/$bestanswer['id']}" ><i class="fa fa-edit"></i> <span>继续回答</span></a>

               <a href="{url question/editanswer/$bestanswer['id']}" ><i class="fa fa-edit"></i> <span>编辑</span></a>
                 <!--{/if}-->
                 
                     <!--{if 1==$user['grouptype'] ||$user['uid']==$authoruid }-->
                                <span onclick="show_oprate('{$bestanswer['id']}');">
                                <i class="fa fa-gear"></i>
                               <span class="">操作 </span>
                            </span>
                       
                              <!--{/if}-->
                   {/if}
                 


                 
               
                     </div>
									<!-- 回答操作 -->
<div class="ui-actionsheet pingluncaozuo">
  <div class="ui-actionsheet-cnt">
    <h4>回答操作</h4>
             <!--{if $bestanswer['id']<=0}-->
         <!--{if 1==$user['grouptype'] ||$user['uid']==$authoruid}-->
    <button onclick="adoptanswer()">采纳</button>
       <!--{/if}-->
                             <!--{/if}-->
                    
           <!--{if 1==$user['grouptype'] || $user['uid']==$authoruid}-->
             <button onclick="jixuzhuiwen()">继续追问</button>
             <!--{/if}-->

                <!--{if 1==$user['grouptype'] ||$user['uid']==$answer['authorid']}-->
    <button class="ui-actionsheet-del" onclick="deleteanswer()">删除</button>
     <!--{/if}-->
    <button class="cancelpop">取消</button>
  </div>
</div>
									<script type="text/javascript">
									var current_aid={$bestanswer['id']};
									$(".cancelpop").click(function(){
										 $('.ui-actionsheet').removeClass('show').addClass('hide');
									})
									function bianjihuida(){

										window.location.href=g_site_url + "index.php" + query + "question/editanswer/"+current_aid;

									}
									function jixuzhuiwen(){
										 window.location.href=g_site_url + "index.php" + query + "answer/append/$qid/"+current_aid;

									}

									function deleteanswer(){
										if(confirm("确定删除回答吗?")){
											window.location.href=g_site_url + "index.php" + query + "question/deleteanswer/"+current_aid+"/$qid";

										}
										
									}

									
									function show_oprate(aid){
										current_aid=aid;

										 $('.pingluncaozuo').removeClass('hide').addClass('show');
									}
</script>					