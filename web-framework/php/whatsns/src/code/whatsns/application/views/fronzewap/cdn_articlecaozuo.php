    <!--{if $user['grouptype']==1||$user['uid']==$topicone['authorid']}-->
 <span class="ui-nowrap  " onclick="show_questionoprate()"  style="margin-top:.8rem;margin-left:5px;font-size:12px;"><i class="fa fa-gear " style="font-size:14px;position;relative;top:1px;margin:0 2px;"></i>管理</span>
  <!--{/if}-->
     <!--{if $user['grouptype']==1||$user['uid']==$topicone['authorid']}-->
<!-- 提问操作 -->
<div class="ui-actionsheet wenticaozuo">
  <div class="ui-actionsheet-cnt">
    <h4>问题操作</h4>
 {if $user['grouptype']==1}
 <button onclick="window.location.href='{url topicdata/pushindex/$tid/topic}'">顶置文章</button>
  <button onclick="window.location.href='{url topic/pushhot/$tid}'">推荐文章</button>
   {/if}
           <button onclick="bianjiwenzhang()">编辑文章</button>

          <button class="ui-actionsheet-del" id="delete_wenzhang">删除</button>

    <button class="cancelpop">取消</button>
  </div>
</div>
  <!--{/if}-->
  <script>
  function bianjiwenzhang(){
		window.location.href="{url user/editxinzhi/$topicone['id']}";
	}
  function show_questionoprate(){


		 $('.wenticaozuo').removeClass('hide').addClass('show');
	}
  $("#delete_wenzhang").click(function() {
		if (confirm('确定删除文章？该操作不可返回！') === true) {
		var url="{url user/deletexinzhi/$topicone['id']}";
		document.location.href = url;
		}
		});
  $(".cancelpop").click(function(){
		 $('.ui-actionsheet').removeClass('show').addClass('hide');
	})

		
  </script>