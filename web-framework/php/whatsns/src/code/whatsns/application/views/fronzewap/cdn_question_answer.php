     <div class="operationlist">
        {if $question['status']!=9&&$question['status']!=0}
                      <span onclick="show_comment('{$answer['id']}');">
                     <i class="ui-icon-comment"></i>
                                <span class="ans-comment-num">
                                    {$answer['comments']}条评论
                                </span>
                    </span>
                                <!--{if 1==$user['grouptype'] ||$user['uid']==$question['authorid'] || $user['uid']==$answer['authorid']}-->
                      <span onclick="show_oprateanswer('{$answer['id']}');">
                      <i class="fa fa-gear"></i>
                               <span class="">操作 </span>
                    </span>
                       <!--{/if}-->
                                     <!--{if  1==$user['grouptype'] ||$user['uid']==$answer['authorid']}-->

                       <a href="{url answer/append/$question['id']/$answer['id']}"  ><i class="fa fa-edit"></i> <span>继续回答</span></a>

               <a href="{url question/editanswer/$answer['id']}"  ><i class="fa fa-edit"></i> <span>编辑</span></a>
                 <!--{/if}-->
                {/if}
             
                              
          
                    </div>
                    
<div class="ui-dialog" id="dialogadopt">
    <div class="ui-dialog-cnt">
      <header class="ui-dialog-hd ui-border-b">
                  <h3>采纳回答</h3>
                  <i class="ui-dialog-close" data-role="button"></i>
              </header>

        <div class="ui-dialog-bd">


        <input type="hidden"  value="{$qid}" id="adopt_qid" name="qid"/>
        <input type="hidden" id="adopt_answer" value="0" name="aid"/>
        <table  class="table ">
            <tr valign="top">
                <td class="small_text">向帮助了您的网友说句感谢的话吧!</td>
            </tr>
            <tr>
                <td>
                    <div class="inputbox mt15">
                        <textarea class="adopt_textarea" id="adopt_txtcontent"  name="content">非常感谢!</textarea>
                    </div>
                </td>
            </tr>

        </table>

            <button  id="adoptbtn"  class="ui-btn ui-btn-primary">
       采纳
    </button>


        </div>


    </div>
</div>
                    									<!-- 回答操作 -->
<div class="ui-actionsheet pingluncaozuoanswer">
  <div class="ui-actionsheet-cnt">
    <h4>回答操作</h4>
             <!--{if $question['status']!=2}-->
         <!--{if 1==$user['grouptype'] ||$user['uid']==$question['authorid']}-->
    <button onclick="adoptanswer()">采纳</button>
       <!--{/if}-->
                             <!--{/if}-->
                    
           <!--{if 1==$user['grouptype'] || $user['uid']==$question['authorid']}-->
             <button onclick="jixuzhuiwen()">继续追问</button>
             <!--{/if}-->

                <!--{if 1==$user['grouptype'] ||$user['uid']==$answer['authorid']}-->
    <button class="ui-actionsheet-del" onclick="deleteanswer()">删除</button>
     <!--{/if}-->
    <button class="cancelpop">取消</button>
  </div>
</div>
                 <script type="text/javascript">
									var current_aid={$answer['id']};
									var adoptsubmit=false;

									$("#adoptbtn").click(function(){
										var _adopt_txtcontent=$.trim($("#adopt_txtcontent").val());
										if(_adopt_txtcontent==''){
											alert("采纳回复不能为空!");
											return false;
										}
										  var data={
									    			content:_adopt_txtcontent,
									    			qid:$("#adopt_qid").val(),
									    			aid:$("#adopt_answer").val()

									    	}
											if(adoptsubmit==true){
												
												return false;
											}

										  adoptsubmit=true;
										$.ajax({
										    //提交数据的类型 POST GET
										    type:"POST",
										    //提交的网址
										    url:"{SITE_URL}index.php?question/ajaxadopt",
										    //提交的数据
										    data:data,
										    //返回数据的格式
										    datatype: "json",//"xml", "html", "script", "json", "jsonp", "text".
										    //在请求之前调用的函数
										    beforeSend:function(){},
										    //成功返回之后调用的函数
										    success:function(data){
										    	var data=eval("("+data+")");
										       if(data.message=='ok'){
										    	   $("#adoptbtn").attr("disabled",true);
										    	   adoptsubmit=true;
										    	   alert("采纳成功!");

										    	   setTimeout(function(){
										               window.location.reload();
										           },1500);
										       }else{
										    	   adoptsubmit=false;
										    	   alert(data.message);

										       }


										    }   ,
										    //调用执行后调用的函数
										    complete: function(XMLHttpRequest, textStatus){

										    },
										    //调用出错执行的函数
										    error: function(){
										    	 adoptsubmit=false;
										        //请求出错处理
										    }
										 });
									})
									function adoptanswer() {

									    $("#adopt_answer").val(current_aid);
									    $('.ui-actionsheet').removeClass('show').addClass('hide');
									    $('#dialogadopt').dialog('show');
									}
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

									
									function show_oprateanswer(aid){
										current_aid=aid;

										 $('.pingluncaozuoanswer').removeClass('hide').addClass('show');
									}
</script>					