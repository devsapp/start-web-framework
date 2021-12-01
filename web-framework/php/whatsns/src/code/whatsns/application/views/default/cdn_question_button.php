			<span class="report"
							{if $user['uid']} onclick="openinform({$question['id']},'{$question['title']}',0)"
							{else} onclick="login()" {/if}  id="report-modal"><a
							href="javascript:;">举报 </a></span> {if $user['uid']} {if
						$is_followed} <input type="button"
							onclick="window.location.href='{url question/attentto/$question['id']}'"
							z-st="favorite"
							class="btn-default-secondary details-collection-btn collection js-not-fav js-project-fav"
							value="已收藏问题" data-on="1"> {else} <input type="button"
							onclick="window.location.href='{url question/attentto/$question['id']}'"
							z-st="favorite"
							class="btn-default-secondary details-collection-btn collection js-not-fav js-project-fav"
							value="收藏问题" data-on="0"> {/if} {else} <input type="button"
							onclick="login()" z-st="favorite"
							class="btn-default-secondary details-collection-btn collection js-not-fav js-project-fav"
							value="收藏问题" data-on="0"> {/if}

{if $question['shangjin']==0||$question['shangjin']>0&&$question['answers']<$setting['xuanshang_question_answers']}
						{if $cananswerthisquestion==true}
						{if $setting['cananswerselfquestion']==0&&$user['uid']!=$question['authorid']||$setting['cananswerselfquestion']==1}
						<button type="button" class="btneditanswer" {if $user['uid']==0}
							onclick="login()" {else} onclick="showeditor()"{/if} >
							<i class="fa fa-pencil"></i>写回答
						</button>
						{/if}

						<button type="button"
							{if $user['uid']} onclick="invateuseranswer({$question['id']})"
							{else} onclick="login()"
							{/if}  class="btn-default-secondary details-share">
							<i class="fa fa-user-plus"></i>邀请回答
						</button>
						{/if}
						{/if}
					
						<script>
						  g_uid=$user['uid'];
						//根据分类读取改分类下有回答的人
						  function showeditor(){
						$(".canwirteanswer").slideDown();
						scrollTo(0,$('#showanswerform').offset().top-200);

						$(".noreplaytext").hide();
						  }
						</script>