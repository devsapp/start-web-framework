  {if $user['uid']}
   {if $user['grouptype']==1||$user['uid']==$topicone['authorid']}
                <!-- 如果是当前作者，加入编辑按钮 -->
                <a href="javascript:void(0)"  data-toggle="dropdown" class="edit dropdown-toggle">操作 <i class="fa fa-angle-down mar-lr-05"></i> </a>
                 <ul class="dropdown-menu" role="menu">
                {if $user['grouptype']==1}
                       <li>


                    <a href="{url topic/pushhot/$tid}" data-toggle="tooltip" data-html="true" data-original-title="被推荐文章将会在首页展示">
                        <span>推荐文章</span>
                    </a>
                      </li>
                        <li>


                    <a href="{url topicdata/pushindex/$tid/topic}" data-toggle="tooltip" data-html="true" data-original-title="被顶置的文章将会在首页列表展示">
                    <span>首页顶置</span>
                    </a>
                      </li>
                      {/if}
                           <li>

                    <a href="{url user/editxinzhi/$tid}">
                      <span>编辑文章</span>
                    </a>
                      </li>
                        <li>

                    <a href="{url user/deletexinzhi/$tid}">
                       <span>删除文章</span>
                    </a>
                      </li>

                             </ul>
                             {/if}
                             {else}
                             <span></span>
   {/if}