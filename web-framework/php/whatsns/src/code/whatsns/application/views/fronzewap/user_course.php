
<!--{template header}-->
{if $member['expert']!=1}
<section class="ui-container">
<!--{template space_title}-->

   
    <section class="user-content-list">
            <div class="titlemiaosu">
            Ta的课程
            </div>
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
</section>
{else}
<section class="ui-container">
<header class="profile menuitem">
		<div class="avatar member">
			<span class=" head-v"> <img src="{$member['avatar']}" width="75" height="75" alt="奋斗">
			</span> 
			<br>{$member['username']} 
					<br><i>{$member['signature']}</i>
							<br><p>{$member['introduction']}</p>
				</div>
				 <!--{if $is_followed}-->

             	<span class="add-focus  button_attention btn-default following" onclick="attentto_user($member['uid'])" id="attenttouser_{$member['uid']}">
             	<i class="fa fa-check"></i><span>已关注</span>
             	</span>
             
          <!--{else}-->
     
            	<span class="add-focus button_attention btn-success follow" onclick="attentto_user($member['uid'])" id="attenttouser_{$member['uid']}">+关注</span>
             
               <!--{/if}-->
               
				
			</header>

</section>
<section class="my-favorite back-f">
		<a href="javascript:;" class="myasnwer">回答<span>{$member['answers']}</span></a>
		<a href="javascript:;" class="caina">采纳率<span>{eval echo $this->user_model->adoptpercent ( $member );}%</span></a>
		<a href="javascript:;" class="zan">获赞<span>{$member['supports']}</span></a>
		<a href="{url kecheng/usercourse/$member['uid']}" class="kc">课程<span>{eval $muid=$member['uid'];echo returnarraynum ( $this->db->query ( getwheresql ( 'category', "  authorid=$muid and grade=3 and iscourse=1 ", $this->db->dbprefix ) )->row_array () );}</span></a>
	
	</section>
	

	
		<section class="answerlists back-f">
	<h4 class="pl">
			<span>回答<font color="#ff7900">{$member['answers']}</font>个问题
			</span>{if $member['jine']}&nbsp;&nbsp;&nbsp;<span>共收入<font color="#ff7900">{eval echo $member['jine']/100;}</font>元 {/if}
			</span>&nbsp;&nbsp;&nbsp;<span>获得<font color="#ff7900">$member['credit2']</font>财富值
				</span>
		</h4>
		     <section class="user-content-list">
            <div class="titlemiaosu">
            Ta的课程
            </div>
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
	</section>
	
{/if}
{if $user['uid']}
<script type="text/javascript">
var subing=false;
function freeask(){
	if(subing){
return false;
	}
	var _quicktitle=$.trim($("#quicktitle").val());
	var _quickcid="{$member['category'][0]['cid']}";
	if(_quicktitle==''){
		alert("咨询内容不能为空");
		return false;
	}
	if(_quicktitle.length<5){
		alert("咨询内容最少5个字");
		return false;
	}
	var data={
			quicktitle:_quicktitle,
			quickcid:_quickcid,
			askfromuid:"{$member['uid']}"
			}
	var _url="{url question/ajaxquickadd}";
	function success(result){
		subing=false;
		if(result.message=="ok"){
        window.location.href=result.url;
		}else{
alert(result.message);
		}
  
	}
	subing=true;
	
	ajaxpost(_url,data,success);
}
</script>
{/if}
<!--{template footer}-->