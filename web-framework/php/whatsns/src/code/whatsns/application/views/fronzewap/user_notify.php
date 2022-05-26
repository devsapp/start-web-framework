<!--{template header}-->
<style>
<!--
.col-sm-4{
text-align:right;
}
.control-label{
font-weight:700;
margin:10px auto;
}
.checkbox{
line-height:30px;
}
hr {
    margin-top: 10px;
    margin-bottom: 10px;
    border: 0;
    border-top: 1px solid #eee;
}
-->
</style>


    <div class="container person">

   
              <div class="row ">
<!--{template user_title}-->
           <div class="col-md-16">
           <div style="padding:10px;">
                   <label for="" class="control-label col-sm-4">通知和私信</label>
     <hr>
           </div>
        
 <form id="setting" action="{url user/usernotify}" method="post">

 <div class="form-group col-md-20 mt30">
 <label for="" class="control-label col-sm-4">私信权限</label><div class="col-sm-16"><div><label class="radio-inline"><input type="radio" name="inbox_permission" value="0" {if $usernotify['inbox_permission']==0}checked=""{/if}>
                        允许所有人给我发私信
                    </label><label class="radio-inline"><input type="radio" name="inbox_permission" value="1" {if $usernotify['inbox_permission']==1}checked=""{/if}>
                        只允许我关注的人给我发私信
                    </label></div></div></div><div class="form-group col-md-20 mt15"><label for="" class="control-label col-sm-4">邀请回答权限</label><div class="col-sm-16"><div><label class="radio-inline"><input type="radio" name="invite_permission" value="0"  {if $usernotify['invite_permission']==0}checked=""{/if}>
                        允许所有人邀请我回答
                    </label><label class="radio-inline"><input type="radio" name="invite_permission" value="1" {if $usernotify['invite_permission']==1}checked=""{/if}>
                        只允许我关注的人邀请我回答
                    </label></div></div></div><div class="form-group col-md-20 mt15"><label for="" class="control-label col-sm-4">回答后自动关注问题</label><div class="col-sm-16"><div class="checkbox"><label><input name="follow_after_answer" id="follow_after_answer" type="checkbox"  {if $usernotify['follow_after_answer']==1}checked=""{/if}> 开启 (当有新答案或内容更新时将收到提醒)
                        </label></div></div></div><div class="form-group col-md-20 mt15"><label for="" class="control-label col-sm-4">通知提醒</label><div class="col-sm-16"><div class="checkbox"><label><input name="article" id="article" type="checkbox" {if $usernotify['article']==1}checked=""{/if}> 关注的专栏有新文章时
                        </label></div><div class="checkbox"><label><input name="like_object" id="like_object" type="checkbox"  {if $usernotify['like_object']==1}checked=""{/if}> 有人收藏我的文章时
                        </label></div><div class="checkbox"><label><input name="bookmark_object" id="bookmark_object" type="checkbox"  {if $usernotify['bookmark_object']==1}checked=""{/if}> 有人收藏我的问题时
                        </label></div><div class="checkbox"><label><input name="follow_object" id="follow_object" type="checkbox"  {if $usernotify['follow_object']==1}checked=""{/if}> 有人关注我时
                        </label></div></div></div><div class="form-group col-md-20 mt15"><label for="" class="control-label col-sm-4">提醒邮件</label><div class="col-sm-16"><div class="checkbox"><label><input name="answer" id="answer" type="checkbox" {if $usernotify['answer']==1}checked=""{/if}> 当有其他人回答我关注的问题时
                        </label></div><div class="checkbox"><label><input name="comment" id="comment" type="checkbox" {if $usernotify['comment']==1}checked=""{/if}> 当有人对我发布的文章评论时
                        </label></div><div class="checkbox"><label><input name="content_handled" id="content_handled" type="checkbox" {if $usernotify['content_handled']==1}checked=""{/if}> 当我的问题被删除/关闭/采纳时
                        </label></div><div class="checkbox"><label><input name="comment_reply" id="comment_reply" type="checkbox" {if $usernotify['comment_reply']==1}checked=""{/if}> 当有人回复我的评论时
                        </label></div><div class="checkbox"><label><input name="invite" id="invite" type="checkbox" {if $usernotify['invite']==1}checked=""{/if}> 当有人邀请我回答问题时
                        </label></div><div class="checkbox"><label><input name="message" id="message" type="checkbox" {if $usernotify['message']==1}checked=""{/if}> 当有人给我发私信时
                        </label></div></div></div><div class="form-group col-md-20 mt15">
						<button class="ui-btn ui-btn-lg btn-xl btn-primary notify-sub mt20">提交</button></div></div></form>
           </div>
           

            </div>

        </div>





<!--{template footer}-->