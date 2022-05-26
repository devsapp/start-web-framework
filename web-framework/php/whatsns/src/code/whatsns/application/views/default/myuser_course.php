<!--{template header}-->

<div class="container person">
  <div class="row">
    <div class="col-xs-17 main">
          <!-- 用户title部分导航 -->
              <!--{template user_title}-->
 <ul class="trigger-menu" data-pjax-container="#list-container">
 <li class=""><a href="{url user/default}"><i class="fa fa-clipboard"></i> 动态</a></li>
<li class=""><a href="{url user/ask}"><i class="fa fa-question-circle-o"></i> 提问</a></li>
<li class=""><a href="{url user/answer}"><i class="fa fa-comments"></i>回答</a></li>
<li class=""><a href="{url topic/userxinzhi/$user['uid']}"><i class="fa fa-rss"></i>文章</a></li>
<li class=""><a href="{url user/recommend}"><i class="fa fa-newspaper-o"></i>推荐</a></li>
<li class="active"><a href="{url kecheng/usercourse/$user['uid']}"><i class="fa  fa-file-video-o"></i>课程</a></li>

 </ul>

      <div id="list-container">
<div class="text-muted mb10 payorder" style="margin-bottom: 10px;">刷选：
                                <div class="btn-group btn-group-xs">
                                <a class="btn btn-default  {if $ctype=='fabu'}active{/if}" href="{url kecheng/usercourse/$user['uid']}" role="button" target="_self">我发布</a>
                                <a class="btn btn-default  {if $ctype=='join'}active{/if}" href="{url kecheng/join}" role="button" target="_self">我加入</a>
                                <a class="btn btn-default {if $ctype=='goumai'}active{/if}" href="{url kecheng/mybuy}" role="button" target="_self">我购买</a>
                <a class="btn btn-default {if $ctype=='guanzhu'}active{/if}" href="{url kecheng/follow}" role="button" target="_self">我关注</a>
                                </div>
                                </div>
  <!--{if $courseist}-->
    <div class="stream-list blog-stream">
                        <!--{loop $courseist $nindex $course}-->
              <section class="stream-list__item">
              <div class="blog-rank stream__item">
              <div data-id="1190000017247505" class="stream__item-zan   btn btn-default mt0">
              <span class="stream__item-zan-icon"></span>
              <span onclick="followcourse({$course['id']})" class="stream__item-zan-number followcourse{$course['id']}" title="共{$course['followers']}人关注">{$course['followers']}</span>
              </div></div>
              <div class="summary">
              <h2 class="title blog-type-common blog-type-1">
              <a href="{eval echo config_item('course_url').'course/view/'.$course['id'];}">{$course['name']}</a></h2>
              <ul class="author list-inline">
              <li>
              <a href="{url user/space/$course['authorid']}">
              <img class="avatar-24 mr10 " src="{$course['avatar']}" alt=" {$course['author']}">
              </a>
              <span style="vertical-align:middle;">
              <a href="{url user/space/$course['authorid']}"> {$course['author']}</a>
                    
                     
                                            </span>
                                                <span style="vertical-align:middle;margin-left:5px;">
          {$course['learners']}人学习
                    
                     
                                            </span>
                                            </li>
    </ul>
      <p class="excerpt wordbreak ">

                     {eval echo clearhtml($course['miaosu']);}
                 

  
  </p>
      </div>
      </section>
        <!--{/loop}-->
              </div>
     
      <!--{else}-->
        <div class="text">
            您还没有发布过课程~
          </div>
          <!--{/if}-->

  <div class="pages" >{$departstr}</div>
      </div>
    </div>

<div class="col-xs-7  aside">
   <!--{template user_menu}-->
</div>

  </div>
</div>
   <script>
         $(".note-list em").addClass("search-result-highlight");
         /*关注课程*/
         function followcourse(cid) {
             if (g_uid == 0) {
                 login();
             }
          
             $.post(g_site_url + "index.php?kecheng/followercourse", {cid: cid}, function(msg) {
            
                 if (msg == 'ok1') {
                     
                     var _follownum=$(".followcourse"+cid).html();
                     $(".followcourse"+cid).html(parseInt(_follownum)-1);
                     alert("取消关注");
             
             }else if(msg == 'ok2'){
            	 var _follownum=$(".followcourse"+cid).html();
                 $(".followcourse"+cid).html(parseInt(_follownum)+1);
                   alert("关注成功");
             }
             else{
             	if(msg == '-1'){
             		alert("先登录在关注");
             	}else{
             		alert(msg);
             	}
             }
             });
         }
         </script>
<!--{template footer}-->