   <style>
   .ui-actionsheet-cnt {
   left:0px;
   }
   </style>
   {if $question['status']!=9&&$question['status']!=0}
   {if $user['grouptype']==1||$user['uid']==$question['authorid']}
 <span class="ui-nowrap  " onclick="show_questionoprate()"  style="margin-top:.8rem;margin-left:5px;font-size:12px;"><i class="fa fa-gear " style="font-size:14px;position;relative;top:1px;margin:0 2px;"></i>管理</span>
 {/if}
   {/if}
   <!--{if $user['grouptype']==1||$user['uid']==$question['authorid']}-->
<!-- 提问操作 -->
<div class="ui-actionsheet wenticaozuo">
  <div class="ui-actionsheet-cnt">
    <h4>问题操作</h4>


           <button onclick="bianjiwenti()">编辑问题</button>
             <button id="close_question">关闭问题</button>
               {if $question['shangjin']==0}
          <button class="ui-actionsheet-del" id="delete_question">删除</button>
           {/if}
    <button class="cancelpop" onclick="hide()">取消</button>
  </div>
</div>
  <!--{/if}-->
  <script>
  var qid={$question['id']}
//关闭问题
  $("#close_question").click(function() {
  if (confirm('确定关闭该问题?') === true) {
  var url=g_site_url+g_prefix+"question/close/"+qid+g_suffix;
  document.location.href = url;
  }
  });
  //删除问题
  $("#delete_question").click(function() {
  if (confirm('确定删除问题？该操作不可返回！') === true) {
  var url=g_site_url+g_prefix+"question/delete/"+qid+g_suffix;
  document.location.href = url;
  }
  });
  function hide(){

		 $('.wenticaozuo').addClass('hide').removeClass('show');
  }
  function show_questionoprate(){


		 $('.wenticaozuo').removeClass('hide').addClass('show');
	}
  function bianjiwenti(){
		window.location.href=g_site_url  + g_prefix + "question/edit/"+qid+g_suffix ;
	}
		
  </script>