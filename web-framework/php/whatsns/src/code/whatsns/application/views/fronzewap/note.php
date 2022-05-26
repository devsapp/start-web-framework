<!--{template header}-->

<section class="ui-container ">
<article class="article">
    <h1 class="title">{$note['title']}</h1>
    <div class="article-info ui-clear">

        <ul class="ui-row">

            <li class="ui-col ui-col-80">

                <span class="ui-txt-highlight">{$note['author']}</span><span class="pad-lr-05"> {$note['format_time']}</span>

            </li>
            <li class="ui-col ui-col-20">
                <span class="f-size-set ui-fr ui-txt-warning">大</span>
                <i class="ui-icon-hall"></i>

            </li>

        </ul>



    </div>
    <div class="article-content">
       
           {eval    echo replacewords($note['content']);    }
       
      
    </div>
</article>
  {if $user['uid']!=0}
     <form  name="commentForm" action="{url note/addcomment}" method="post" onsubmit="return check()">
  <div class="postarticleform">
  <input type="hidden" value="{$note['id']}" name="noteid">
<textarea id="content" name="content"   placeholder="写下你的评论..." class="comment-area"></textarea> 
</div>
 {if $signPackage==null&&$setting['code_ask']&&$setting['jingyan']<=0}
   <div class="ui-col ui-col-2" style="padding-left:10px;margin-bottom:10px;">
    
     <input type="text"  id="code" name="code" onblur="check_code();"  value="" style="width:50px;heigth:40px;position:relatvie;bottom:10px;left:2px;">
     <img class="hand" src="{url user/code}" onclick="javascript:updatecode();" id="verifycode" style="width:50px;height:20px;position:relative;bottom:-5px;">
  
    </div>
      {/if}
<div class="btnpostarticle">
<button class="ui-btn ui-btn-danger "  type="submit" name="submit" id="submit">评论</button>
</div>
   </form>
   {else}
    <div class="ui-btn-wrap">
    <button onclick="window.location.href='{url user/login}'" class="ui-btn-lg ui-btn-danger">
        登录发布评论
    </button>
</div>
    {/if}
 <!--回答-->
   <!--{if $commentlist}-->
    <section class="answerlist" style="margin-top:30px;">
     <div class="ans-title">
         <span>全部评论</span>
     </div>
        <div class="answers">
            <div class="answer-items">
            
             
                 <!--{loop $commentlist $index $comment}-->
                <div class="answer-item">
                          <ul class="ui-row">
                              <li class="ui-col ui-col-80">
                                  <span class="ui-avatar-s">
                         <span style="background-image:url({$comment['avatar']})"></span>
                     </span>

                                  <span class="ui-txt-highlight u-name">{$comment['author']}</span>
                              </li>
                              
                          </ul>
                    <div class="ans-content">
{$comment['content']}
                    </div>
                
                          <div class="ans-footer">
                     
                                            <a class="ans-time" style="color:#ccc;">评论于 {$comment['time']}</a> 
                         
                           
           
                <!--{if 1==$user['grouptype'] }-->
   
    <a data-placement="bottom" title="" data-toggle="tooltip" data-original-title="删除评论"   href="javascript:delete_comment('{$note['id']}', '{$comment['id']}');" onclick="deletewenzhang($comment['id'])"><i class="fa fa-bookmark-o"></i> <span>删除</span></a>
     <!--{/if}-->   

                <!---->
                         
                       
                    </div>
                </div>
                  <!--{/loop}-->    
            </div>
        </div>
        <div class="pages">{$departstr}</div>
    </section>
      <!--{/if}-->
    <section class="article-jingxuan ui-panel">
        <h2 class="ui-txt-warning">最新公告</h2>
        <ul class="ui-list ui-list-link ui-border-tb">
          <!--{eval $notelist=$this->fromcache('notelist');}-->
                <!--{loop $notelist $nindex $note}-->
            <li class="ui-border-t" >
             
                <div class="ui-list-info">
                    <h4 class="ui-nowrap"><a class="ui-txt-default" {if $note['url']}href="{$note['url']}"{else}href="{url note/view/$note['id']}"{/if}>{$note['title']}</a></h4>
                   
                </div>
            </li>
             <!--{/loop}-->
           
        </ul>
    </section>

</section>


<script>
$(function(){
	$(".article img").css("height","auto")
})
function  check(){
	if($.trim($("#content").val())==''){
		 el2=$.tips({
	         content:'评论不能为空',
	         stayTime:2000,
	         type:"info"
	     });
		 return false;
	}
	
}
<!--{if  ($user['grouptype']==1)}-->
function delete_comment(noteid, commentid) {
if (confirm('确定删除改评论？') === true) {
document.location.href = g_site_url + '' + query + 'note/deletecomment/' + noteid + '/' + commentid + g_suffix;
}
}
<!--{/if}-->
    $(".f-size-set").bind("click",function(event){

        $(".article-content").toggleClass("art-font");
        if( $(".article-content").hasClass("art-font")){
            $(this).html("小");
        }else{
            $(this).html("大");
        }
    })

</script>
<!--{template footer}-->