 <!-- 公共头部--> 
{template header}
 <!-- 首页导航 --> 
{template index_nav}

<div class="layui-container">
  <div class="layui-row layui-col-space15">
    <div class="layui-col-md8 content detail">
      <div class="fly-panel detail-box">
 
      <h1>{$question['title']}</h1>
        <div class="fly-detail-info">
          {if $question['status']==0}<span class="layui-badge">审核中</span>{/if}
          <a href="{eval echo getcaturl($question['cid'],'category/view/#id#');}"><span class="layui-badge layui-bg-green fly-detail-column">$question['category_name']</span></a>
          
            
                  
          {if $question['status']==1}<span class="layui-badge" style="background-color: #999;">未结</span>{/if}
          {if $question['status']==2}<span class="layui-badge" style="background-color: #5FB878;">已结</span> {/if}
          {eval $qid=$question['id']; $topdataquestion=$this->getlistbysql("select id,type,typeid  from ".$this->db->dbprefix."topdata where typeid=$qid and type='qid' limit 0,1");}
          {if count($topdataquestion)}<span class="layui-badge layui-bg-black">置顶</span>{/if}
          {if $question['status']==6}<span class="layui-badge layui-bg-red">推荐</span>{/if}
          
          <div class="fly-admin-box" data-id="123">
             {if $is_followed}
                 <a href="{url question/attentto/$question['id']}"><span class="layui-badge layui-bg-blue  fly-detail-column">已关注</span></a>
         
                 {else}
                  <a href="{url question/attentto/$question['id']}"><span class="layui-badge layui-bg-blue fly-detail-column">关注</span></a>
         
                  {/if}
           <!--{if $user['grouptype']==1||$user['uid']==$question['authorid']}-->
                {if $question['shangjin']==0} <a onclick="if(confirm('确认删除吗?')){window.location='{url question/delete/$question['id']}';}"> <span class="layui-btn layui-btn-xs jie-admin" type="del">删除</span></a> {/if}
             <!--{if $user['grouptype']==1}-->
                {if !$topdataquestion}  <a href="{url topicdata/pushindex/$question['id']/qid}" >
                 
          <span class="layui-btn layui-btn-xs jie-admin" type="set" field="stick" rank="1">置顶</span>   
                    </a>  {/if} 
          {if count($topdataquestion)}   <a href="{url topicdata/cancelindex/$question['id']/qid}" > <span class="layui-btn layui-btn-xs jie-admin" type="set" field="stick" rank="0" style="background-color:#ccc;">取消置顶</span>  </a>  {/if} 
             <!--{/if}-->
  <!--{/if}-->
          </div>
          <span class="fly-list-nums"> 
            <a href="#comment"><i class="iconfont" title="回答">&#xe60c;</i> {$question['answers']}</a>
            <i class="iconfont" title="人气">&#xe60b;</i> {$question['views']}
          </span>
        </div>
        <div class="detail-about">
        {if $question['hidden']==1}
          <a class="fly-avatar" {if $user['grouptype']!=1&&$user['uid']!=$question['authorid']&&$question['price']==0}style="top:3px;"{/if}>
            <img src="{eval echo get_avatar_dir(0);}" alt="匿名用户" >
          </a>
          <div class="fly-detail-user">
            <a class="fly-link">
              <cite>匿名用户</cite>
           
            </a>
            <span class="hide">{eval echo tdate($question['time']);}</span>
          </div>
          {else}
               <a class="fly-avatar" href="{url user/space/$question['authorid']}" {if $user['grouptype']!=1&&$user['uid']!=$question['authorid']&&$question['price']==0}style="top:3px;"{/if}>
            <img src="{$question['author_avartar']}" alt="{$question['author']}" >
          </a>
          <div class="fly-detail-user">
            <a href="{url user/space/$question['authorid']}" class="fly-link">
              <cite>{$question['author']}</cite>
             {if $question['author_has_vertify']} <i class="iconfont icon-renzheng" title="认证信息：{$question['user']['signature']}"></i>{/if}
             
            </a>
            <span class="hide">{eval echo tdate($question['time']);}</span>
          </div>
          {/if}
          <div class="detail-hits" data-id="123">
          {if $question['price']>0}  <span style="padding-right: 10px; color: #FF7200" title="{$question['price']}{$caifuzhiname}">悬赏：<i class="layui-icon layui-icon-diamond font13"></i>{$question['price']}</span>  {/if}
             <!--{if $user['grouptype']==1||$user['uid']==$question['authorid']}-->
            <span class="layui-btn layui-btn-xs jie-admin" type="edit"><a href="{url question/edit/$question['id']}">编辑此问题</a></span>
         <!--{/if}-->
          </div>
        </div>
              {if $question['description']}
        <div class="detail-body photos">
         {template question_content_header}
         {eval echo $question['description'];}
         {template question_content_footer}
        </div>
        {/if}
              <div class="relativetags">
              相关标签:
     	<!--{if $taglist}-->
				<!--{loop $taglist $tag}-->

				<a href="{url tags/view/$tag['tagalias']}" title="{$tag['tagname']}"
					target="_blank" class="project-tag-14">

					  <button type="button" class="layui-btn layui-btn-xs layui-btn-warm "><i class="layui-icon layui-icon-note"></i> {$tag['tagname']}</button>
					</a>
				<!--{/loop}-->
				<!--{/if}-->
  </div>
      </div>
      
      <div class="fly-panel detail-box" id="flyReply">
        <fieldset class="layui-elem-field layui-field-title" style="text-align: center;">
         {if $question['answers']} <legend>{$question['answers']}条回答</legend>{else} <legend>回答</legend> {/if}
        </fieldset>

        <ul class="jieda" id="jieda">
          <!--{if $bestanswer['id']>0}-->
          <li data-id="111" class="jieda-daan">
            <a name="item-1111111111"></a>
            <div class="detail-about detail-about-reply">
                  {if $question['authorid']==$bestanswer['authorid']&&$question['hidden']==1}
              <a class="fly-avatar" href="">
                <img src="{eval echo get_avatar_dir(0);}" alt=" 匿名用户">
              </a>
              <div class="fly-detail-user">
                <a href="" class="fly-link">
                  <cite>匿名用户</cite>
                         
                </a>
                
                <span>(楼主)</span>
             
              </div>
{else}
       <a class="fly-avatar" href="">
                <img src="{$bestanswer['author_avartar']}" alt=" {$bestanswer['author']} ">
              </a>
              <div class="fly-detail-user">
                <a href="" class="fly-link">
                  <cite> {$bestanswer['author']}</cite>
                {if $bestanswer['author_has_vertify']!=false}  <i class="iconfont icon-renzheng" title="认证信息：XXX"></i>{/if}
                             
                </a>
                
                <span>(最佳回答者)</span>
            
              </div>
{/if}
              <div class="detail-hits">
                <span>{$bestanswer['format_time']}</span>
              </div>

              <i class="iconfont icon-caina" title="最佳答案"></i>
            </div>
            <div class="detail-body jieda-body photos">
              <p>          {eval    echo replacewords($bestanswer['content']);    }</p>
             <div class="appendcontent">
                                <!--{loop $bestanswer['appends'] $append}-->
                                <div class="appendbox">
                                    <!--{if $append['authorid']==$bestanswer['authorid']}-->
                                    <h4 class="appendanswer font12">回答:<span class="time">
                                    {$bestanswer['format_time']}</span></h4>
                                    <!--{else}-->
                                    <h4 class="appendask font12">作者追问:<span class='time'>{$bestanswer['format_time']}</span></h4>
                                    <!--{/if}-->
                                       <div class="zhuiwentext">   {eval    echo replacewords($append['content']);    }
                                       </div>
                                <div class="clr"></div>
                                </div>
                                <!--{/loop}-->
                        </div>
            </div>
            <div class="jieda-reply">
              <span class="jieda-zan button_agree" type="zan" data-id='{$bestanswer['id']}'>
                <i class="iconfont icon-zan"></i>
                <em>{$bestanswer['supports']}</em>
              </span>
                   <span type="reply" class="showpinglun" data-id="{$bestanswer['id']}">
                <i class="iconfont icon-svgmoban53"></i>
               讨论({$bestanswer['comments']})
              </span>
                  <!--{if  1==$user['grouptype'] ||$user['uid']==$bestanswer['authorid']}-->

                     
         <a  href="{url answer/append/$question['id']/$bestanswer['id']}">       <span type="reply">
                <i class="iconfont icon-svgmoban53"></i>
                继续回答
              </span></a>
                 <!--{/if}-->
                 <!--{if $user['uid']==$question['authorid']}-->

          
<a  href="{url answer/append/$question['id']/$bestanswer['id']}">       <span type="reply">
                <i class="iconfont icon-svgmoban53"></i>
                继续追问
              </span></a>
               <!--{/if}-->
               
              
              <div class="jieda-admin">
           <!--{if  1==$user['grouptype'] ||$user['uid']==$bestanswer['authorid']}-->

                      
   <a  href="{url question/editanswer/$bestanswer['id']}"><span type="edit">编辑</span></a>
   
     <a  onclick="if(confirm('确认删除回答吗?')){window.location='{url question/deleteanswer/$bestanswer['id']/$qid}';}"><span type="del">删除</span></a>
               <!--{/if}-->
               
             
       
          
              </div>
            </div>
                         <div class="comments-mod "  style="display: none; float:none;padding-top:10px;" id="comment_{$bestanswer['id']}">
                    <div class="areabox clearfix">

<form class="layui-form" action="">
               
            <div class="layui-form-item">
    <label class="layui-form-label" style="padding-left:0px;width:60px;">发布评论:</label>
    <div class="layui-input-block" style="margin-left:90px;">
         <input type="text" placeholder="不少于5个字" AUTOCOMPLETE="off" class="comment-input layui-input" name="content" />
                        <input type='hidden' value='0' name='replyauthor' />
    </div>
    <div class="mar-t10"><span class="fr layui-btn layui-btn-sm addhuidapinglun" data-id="{$bestanswer['id']}">提交评论 </span></div>
  </div>
  
</form>
                    </div>
                    <hr>
                    <ul class="my-comments-list nav">
                        <li class="loading">
                        <img src='{SITE_URL}static/css/default/loading.gif' align='absmiddle' />
                        &nbsp;加载中...
                        </li>
                    </ul>
                </div>
          </li>
               <!--{/if}-->
               				  <!--{loop $answerlist $nindex $answer}-->
          <li data-id="111">
            <a name="item-1111111111"></a>
           
            <div class="detail-about detail-about-reply">
              {if $question['authorid']==$answer['authorid']&&$question['hidden']==1}
              <a class="fly-avatar" ref="nofllow">
                <img src="{eval echo get_avatar_dir(0);}" alt=" ">
              </a>
              <div class="fly-detail-user">
                <a ref="nofllow" class="fly-link">
                  <cite> 匿名用户</cite>       
                </a>
              </div>
              {else}
                <a class="fly-avatar" href="{url user/space/$answer['authorid']}">
                <img src="{$answer['author_avartar']}" alt=" ">
              </a>
              <div class="fly-detail-user">
                <a href="{url user/space/$answer['authorid']}" class="fly-link">
                  <cite>{$answer['author']} {if $answer['signature']} <span class="signature">- $answer['signature']</span> {/if}</cite>       
                </a>
              </div>
              {/if}
              <div class="detail-hits">
                <span>{$answer['time']}</span>
              </div>
            </div>
            <div class="detail-body jieda-body photos">
             {if $answer['serverid']==null}
                             {if $answer['reward']==0||$answer['authorid']==$user['uid']}
                             {eval    echo replacewords($answer['content']);    }
                               {else}
                               {eval if($question['authorid']==$user['uid']) $answer['canview']=1;}
                               {if $answer['canview']==0}
                                 <div class="box_toukan ">

									<div onclick="checkpay($question['id'],$answer['id'])" data-placement="bottom" title="" data-toggle="tooltip" data-original-title="我也付费偷偷看" class="thiefbox font-12" onclick=""><i class="icon icon-lock font-12"></i> &nbsp;精彩回答&nbsp;$answer['reward']&nbsp;&nbsp;元偷偷看……{if $answer['viewnum']>0}<span class="kanguoperson">$answer['viewnum']人看过{/if}</span></div>
											

										</div>
                               {else}
                                 {eval    echo replacewords($answer['content']);    }
                               {/if}

                               {/if}



                    {else}
                    <!-- ie8浏览器用微信扫一扫，不支持html5标签 -->
                    <div class="ieview hide">

                                         此回答为语音回复，请在微信中扫一扫下面偷听回答
                 <div id="output{$answer['id']}" style="width:135px;height:135px;"></div>
				  <script>

					$(function(){

						$('#output{$answer['id']}').qrcode("{url question/voice/$qid/$answer['id']}");

					})

					</script>
					  </div>
					<div class="htmlview">
					  <div class="yuyinplay" id="{$answer['serverid']}">
                     <i class="fa fa-volume-up " ></i><span class="u-voice">
                     <span class="wtip">免费偷听</span>

                     &nbsp;{$answer['voicetime']}秒</span>
                     <audio id="voiceaudio" width="420" style="display:none">
    <source src="{SITE_URL}data/weixinrecord/{$answer['mediafile']}" type="audio/mpeg" />

</audio>
                    </div>
					</div>
                    {/if}

                 <div class="appendcontent">
                                <!--{loop $answer['appends'] $append}-->
                                <div class="appendbox">
                                    <!--{if $append['authorid']==$answer['authorid']}-->
                                    <h4 class="appendanswer font12 mar-t10">回答:<span class="time">
                                    {$append['format_time']}</span></h4>
                                    <!--{else}-->
                                    <h4 class="appendask font12 mar-t10">作者追问:<span class='time'>{$append['format_time']}</span></h4>
                                    <!--{/if}-->
                                    <blockquote class="layui-elem-quote">   {eval    echo replacewords(clearlinkref($append['content']));    }
                                       </blockquote>
                                   
                                <div class="clr"></div>
                                </div>
                                <!--{/loop}-->
                        </div>
            </div>
            <div class="jieda-reply">
              <span class="jieda-zan button_agree" type="zan" data-id='{$answer['id']}'>
                <i class="iconfont icon-zan"></i>
                <em>{$answer['supports']}</em>
              </span>
                 <span type="reply" class="showpinglun" data-id="{$answer['id']}">
                <i class="iconfont icon-svgmoban53"></i>
               讨论({$answer['comments']})
              </span>
              
                   <!--{if  1==$user['grouptype'] ||$user['uid']==$answer['authorid']}-->

                     
         <a  href="{url answer/append/$question['id']/$answer['id']}">       <span type="reply">
                <i class="iconfont icon-svgmoban53"></i>
                继续回答
              </span></a>
                 <!--{/if}-->
                 <!--{if $user['uid']==$question['authorid']}-->

          
<a  href="{url answer/append/$question['id']/$answer['id']}">       <span type="reply">
                <i class="iconfont icon-svgmoban53"></i>
                继续追问
              </span></a>
               <!--{/if}-->
               
              <div class="jieda-admin">
              							<!--{if  1==$user['grouptype'] ||$user['uid']==$answer['authorid']}-->
              
                <a href="{url question/editanswer/$answer['id']}"><span type="edit">编辑</span></a>
                <!--{/if}-->
                				<!--{if 1==$user['grouptype'] ||$user['uid']==$answer['authorid']}-->
                
              
     <a  onclick="if(confirm('确认删除回答吗?')){window.location='{url question/deleteanswer/$answer['id']/$qid}';}">  <span type="del">删除</span></a>
                	<!--{/if}-->
                						<!--{if $bestanswer['id']<=0}-->
													<!--{if 1==$user['grouptype'] ||$user['uid']==$question['authorid']}-->
                
                <span class="jieda-accept" id="adoptbtn" data-aid="$answer['id']" >采纳</span>
                	<!--{/if}-->
													<!--{/if}-->
              </div>
            </div>
                      <div class="comments-mod "  style="display: none; float:none;padding-top:10px;" id="comment_{$answer['id']}">
                    <div class="areabox clearfix">

<form class="layui-form" action="">
               
            <div class="layui-form-item">
    <label class="layui-form-label" style="padding-left:0px;width:60px;">发布评论:</label>
    <div class="layui-input-block" style="margin-left:90px;">
         <input type="text" placeholder="不少于5个字" AUTOCOMPLETE="off" class="comment-input layui-input" name="content" />
                        <input type='hidden' value='0' name='replyauthor' />
    </div>
    <div class="mar-t10"><span class="fr layui-btn layui-btn-sm addhuidapinglun" data-id="{$answer['id']}">提交评论 </span></div>
  </div>
  
</form>
                    </div>
                    <hr>
                    <ul class="my-comments-list nav">
                        <li class="loading">
                        <img src='{SITE_URL}static/css/default/loading.gif' align='absmiddle' />
                        &nbsp;加载中...
                        </li>
                    </ul>
                </div>
          </li>
          	<!--{/loop}-->
          {template page}
          	{if !$question['answers']}
          <!-- 无数据时 -->
         <li class="fly-none">消灭零回复</li> 
         {/if}
        </ul>
        
        <div class="layui-form layui-form-pane">
          <form id="huidaform"  name="answerForm"  method="post">
            
            <div class="layui-form-item layui-form-text">
              <a name="comment"></a>
              <div class="layui-input-block">
            
    <!--{template editor}-->
              </div>
            </div>
          <!--{if $setting['code_ask']&&$user['credit1']<$setting['jingyan']}-->                
    <!--{template code}-->
        <!--{/if}-->
            <div class="layui-form-item">
                    <input type="hidden" value="{$question['id']}" id="ans_qid" name="qid">
   <input type="hidden" id="tokenkey" name="tokenkey" value='{$_SESSION["answertoken"]}'/>
                <input type="hidden" value="{$question['title']}" id="ans_title" name="title"> 
             
              <div class="layui-btn   {if !$user['uid']} layui-btn-disabled{/if}"  id="ajaxsubmitasnwer" >提交回复</div>
            </div>
          </form>
        </div>
      </div>
      <input type="hidden" value="{$question['id']}" id="adopt_qid"	name="qid" /> 
      <input type="hidden" id="adopt_answer" value="0"	name="aid" />
    </div>
    <div class="layui-col-md4">
          
 <!-- 热门讨论问题 -->
     {template index_hotquestion}
 <!-- 右侧广告位 -->
    {template question_rightadv}
       <!-- 右侧微信二维码 -->
    {template index_qrweixin}

    </div>
  </div>
</div>
	<div id="bdtts_div_id">
		
		</div>
<script type="text/javascript">
<!--{if $setting['code_ask']}-->
var needcode=1;
<!--{else}-->
var needcode=0;
  <!--{/if}-->
	 
</script>
	
 <!-- 公共底部 --> 
{template footer}