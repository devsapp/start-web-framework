  <!--{if $user['grouptype']==1||$user['uid']==$question['authorid']}-->
                <!-- 如果是当前作者，加入编辑按钮 -->
                <a href="javascript:void(0)"  data-toggle="dropdown" class=" dropdown-toggle">操作 <i class="fa fa-angle-down mar-lr-05"></i> </a>
                 <ul class="dropdown-menu" role="menu">

  <!--{if $user['grouptype']==1}-->
     <li>

                    <a href="{url topicdata/pushindex/$question['id']/qid}" >
                      <span>顶置问题</span>
                    </a>
                      </li>

                     <li>

                    <a id="changecategory" data-toggle="modal" data-target="#catedialog" >
                    <span>移动分类</span>
                    </a>
                      </li>
                           <!--{/if}-->
                           {if $question['status']!=9&&$question['status']!=0}
                       <li>

                    <a href="{url question/edit/$question[id]}" >
                       <span>编辑问题</span>
                    </a>
                      </li>
                        <li>

                    <a id="close_question">
                       <span>关闭问题</span>
                    </a>
                      </li>
                      {/if}
                       {if $question['shangjin']==0}
                           <li>

                    <a id="delete_question">
                    <span>删除问题</span>
                    </a>
                      </li>
                        {/if}
                     
                        <li>

                    <a onclick="edittag();">
                       <span>编辑标签</span>
                    </a>
                      </li>

                             </ul>
                               <!--{/if}-->
                               <script>
                               var qid=$question[id];
                               //关闭问题
                               $("#close_question").click(function() {
                           if (confirm('确定关闭该问题?') === true) {
                           	var url=g_site_url+"index.php?question/close/"+qid;
                           document.location.href = url;
                           }
                           });
                           	//删除问题
                               $("#delete_question").click(function() {
                           if (confirm('确定删除问题？该操作不可返回！') === true) {
                           	var url=g_site_url+"index.php?question/delete/"+qid;
                           document.location.href = url;
                           }
                           });
                               </script>