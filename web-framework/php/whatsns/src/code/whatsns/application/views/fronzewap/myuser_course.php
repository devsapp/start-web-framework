
<!--{template header}-->

<section class="ui-container">
<!--{template user_title}-->

        <ul class="tab-head">
                                         
                  
                      <li class="tab-head-item {if $ctype=='fabu'}current{/if}"><a href="{url kecheng/usercourse/$user['uid']}">我发布</a></li>
                                                                               
                  
                   
                      <li class="tab-head-item {if $ctype=='join'}current{/if}"><a href="{url kecheng/join}"> 我加入</a></li>
                                                             
                              <li class="tab-head-item  {if $ctype=='goumai'}current{/if}"><a href="{url kecheng/mybuy}" > 我购买</a></li>
                                                                               
                                    
     <li class="tab-head-item  {if $ctype=='guanzhu'}current{/if}"><a href="{url kecheng/follow}" >我关注</a></li>
                             
   
</ul>
<div class="au_resultitems au_searchlist">
                       
  <div class="qlists">
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
</div>
        <div class="pages" >{$departstr}</div>   
</div>

    
      
   
</section>

   <script>
     
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