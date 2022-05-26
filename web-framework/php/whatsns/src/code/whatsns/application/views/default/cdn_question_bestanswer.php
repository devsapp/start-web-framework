<a class="button_agree dianzan"  aid="{$bestanswer['id']}"  id="button_agree{$bestanswer['id']}"><i
														class="fa fa-eject"></i> <span>{$bestanswer['supports']}人赞</span></a>
											 {if $question['status']!=9&&$question['status']!=0}		
													<a class="icon_discuss jsslideshowcomment showcommentid"
														data-id="{$bestanswer['id']}"
														onclick="show_comment('{$bestanswer['id']}');"><i
														class="fa fa-cloud"></i> <span>
															添加讨论({$bestanswer['comments']})</span></a>

													<!--{if  1==$user['grouptype'] ||$user['uid']==$bestanswer['authorid']}-->

													<a
														href="{url answer/append/$question['id']/$bestanswer['id']}"
														data-original-title="继续回答问题" data-placement="bottom"
														title="" data-toggle="tooltip"><i class="fa fa-edit"></i>
														<span>继续回答</span></a> <a
														href="{url question/editanswer/$bestanswer['id']}"
														data-original-title="修改自己答案" data-placement="bottom"
														title="" data-toggle="tooltip"><i class="fa fa-edit"></i>
														<span>编辑</span></a>
													<!--{/if}-->
													<!--{if $user['uid']==$question['authorid']}-->

													<a data-placement="bottom" title="" data-toggle="tooltip"
														data-original-title="继续回答问题"
														href="{url answer/append/$question['id']/$bestanswer['id']}"><i
														class="fa fa-file-powerpoint-o"></i> <span>追问</span></a>


													<!--{/if}-->
													
													{/if}
												<a style="position: relative;top: 4px" 
														class="report"
														onclick="openinform({$question['id']},'{$question['title']}',{$bestanswer['id']})"><span>举报</span></a>
													<!---->
														<script>
												     $("#button_agree{$bestanswer['id']}").click(function(){
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