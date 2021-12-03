<a class="button_agree dianzan" aid="{$answer['id']}"  id="button_agree{$answer['id']}"><i
														class="fa fa-eject"></i> <span>{$answer['supports']}人赞</span></a>
	 {if $question['status']!=9&&$question['status']!=0}	
													<a class="icon_discuss jsslideshowcomment showcommentid"
														data-id="{$answer['id']}"
														onclick="show_comment('{$answer['id']}');"><i
														class="fa fa-cloud"></i> <span>
															添加讨论({$answer['comments']})</span></a>


													<!--{if  1==$user['grouptype'] ||$user['uid']==$answer['authorid']}-->

													<a href="{url answer/append/$question['id']/$answer['id']}"
														data-original-title="继续回答问题" data-placement="bottom"
														title="" data-toggle="tooltip"><i class="fa fa-edit"></i>
														<span>继续回答</span></a> <a
														href="{url question/editanswer/$answer['id']}"
														data-original-title="修改自己答案" data-placement="bottom"
														title="" data-toggle="tooltip"><i class="fa fa-edit"></i>
														<span>编辑</span></a>
													<!--{/if}-->
													<!--{if $user['uid']==$question['authorid']}-->

													<a data-placement="bottom" title="" data-toggle="tooltip"
														data-original-title="追问回答者"
														href="{url answer/append/$question['id']/$answer['id']}"><i
														class="fa fa-file-powerpoint-o"></i> <span>追问</span></a>


													<!--{/if}-->

													<!--{if $bestanswer['id']<=0}-->
													<!--{if 1==$user['grouptype'] ||$user['uid']==$question['authorid']}-->

													<a data-placement="bottom" title="" data-toggle="tooltip"
														data-original-title="采纳满意回答" href="javascript:void(0);"
														onclick="adoptanswer({$answer['id']});"><i
														class="fa fa-bookmark-o"></i> <span>采纳</span></a>
													<!--{/if}-->
													<!--{/if}-->
																					<!--{if 1==$user['grouptype'] ||$user['uid']==$answer['authorid']}-->

													<a data-placement="bottom" title="" data-toggle="tooltip"
														data-original-title="删除回答" href="javascript:void(0);"
														onclick="deleteanswer($answer['id'])"><i
														class="fa fa-trash-o"></i> <span>删除</span></a>
													<!--{/if}-->	
													{/if}
											
				
													<a class="report" style="position: relative;top: 4px"
														onclick="openinform({$question['id']},'{$question['title']}',{$answer['id']})"><span>举报</span></a>
													<!---->
													<script>
												     $("#button_agree{$answer['id']}").click(function(){
											             var supportobj = $(this);
											                     var answerid = $(this).attr("aid");
											                     $.ajax({
											                     type: "GET",
											                             url:"{SITE_URL}index.php?answer/ajaxhassupport/" + answerid,
											                             cache: false,
											                             success: function(hassupport){
											                             if (hassupport != '1'){






											                                     $.ajax({
											                                     type: "GET",
											                                             cache:false,
											                                             url: "{SITE_URL}index.php?answer/ajaxaddsupport/" + answerid,
											                                             success: function(comments) {

											                                             supportobj.find("span").html(comments+"人赞");
											                                             }
											                                     });
											                             }else{
											                            	 alert("您已经赞过");
											                            	 return false;
											                             }
											                             }
											                     });
											             });
													</script>