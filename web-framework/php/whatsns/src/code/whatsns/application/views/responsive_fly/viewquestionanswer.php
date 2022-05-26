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
          {eval $qid=$question['id']; $topdataquestion=$this->getlistbysql("select id,type,typeid from  ".$this->db->dbprefix."topdata where typeid=$qid and type='qid' limit 0,1");}
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
            <span>{eval echo tdate($question['time']);}</span>
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
            <span>{eval echo tdate($question['time']);}</span>
          </div>
          {/if}
          <div class="detail-hits" data-id="123">
          {if $question['price']>0}  <span style="padding-right: 10px; color: #FF7200" title="{$question['price']}{$caifuzhiname}">悬赏：<i class="layui-icon layui-icon-diamond font13"></i>{$question['price']}</span>  {/if}
             <!--{if $user['grouptype']==1||$user['uid']==$question['authorid']}-->
            <span class="layui-btn layui-btn-xs jie-admin" type="edit"><a href="{url question/edit/$question['id']}">编辑此问题</a></span>
         <!--{/if}-->
          </div>
        </div>
        <div class="detail-body photos">
         {template question_content_header}
         {eval echo $question['description'];}
         {template question_content_footer}
        </div>
      </div>
      
      <div class="fly-panel detail-box" id="flyReply">
        <fieldset class="layui-elem-field layui-field-title" style="text-align: center;">
         {if $question['answers']} <legend>{$question['answers']}条回答</legend>{else} <legend>回答</legend> {/if}
        </fieldset>

        <ul class="jieda" id="jieda">
          <!--{if $useranswer['id']>0}-->
          <li data-id="111" class="jieda-daan">
            <a name="item-1111111111"></a>
            <div class="detail-about detail-about-reply">
                  {if $question['authorid']==$useranswer['authorid']&&$question['hidden']==1}
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
                <img src="{$useranswer['author_avartar']}" alt=" {$useranswer['author']} ">
              </a>
              <div class="fly-detail-user">
                <a href="" class="fly-link">
                  <cite> {$useranswer['author']}</cite>
                {if $useranswer['author_has_vertify']!=false}  <i class="iconfont icon-renzheng" title="认证信息：XXX"></i>{/if}
                             
                </a>
                
                <span>(楼主)</span>
            
              </div>
{/if}
              <div class="detail-hits">
                <span>{$useranswer['format_time']}</span>
              </div>

            </div>
            <div class="detail-body jieda-body photos">
              <p>          {eval    echo replacewords($useranswer['content']);    }</p>
             <div class="appendcontent">
                                <!--{loop $useranswer['appends'] $append}-->
                                <div class="appendbox">
                                    <!--{if $append['authorid']==$useranswer['authorid']}-->
                                    <h4 class="appendanswer font12">回答:<span class="time">
                                    {$useranswer['format_time']}</span></h4>
                                    <!--{else}-->
                                    <h4 class="appendask font12">作者追问:<span class='time'>{$useranswer['format_time']}</span></h4>
                                    <!--{/if}-->
                                       <div class="zhuiwentext">   {eval    echo replacewords($append['content']);    }
                                       </div>
                                <div class="clr"></div>
                                </div>
                                <!--{/loop}-->
                        </div>
            </div>
            <div class="jieda-reply">
              <span class="jieda-zan button_agree" type="zan" data-id='{$useranswer['id']}'>
                <i class="iconfont icon-zan"></i>
                <em>{$useranswer['supports']}</em>
              </span>
                   <span type="reply" class="showpinglun" data-id="{$useranswer['id']}">
                <i class="iconfont icon-svgmoban53"></i>
               讨论({$useranswer['comments']})
              </span>
                  <!--{if  1==$user['grouptype'] ||$user['uid']==$useranswer['authorid']}-->

                     
         <a  href="{url answer/append/$question['id']/$useranswer['id']}">       <span type="reply">
                <i class="iconfont icon-svgmoban53"></i>
                继续回答
              </span></a>
                 <!--{/if}-->
                 <!--{if $user['uid']==$question['authorid']}-->

          
<a  href="{url answer/append/$question['id']/$useranswer['id']}">       <span type="reply">
                <i class="iconfont icon-svgmoban53"></i>
                继续追问
              </span></a>
               <!--{/if}-->
               
              
              <div class="jieda-admin">
           <!--{if  1==$user['grouptype'] ||$user['uid']==$useranswer['authorid']}-->

                      
   <a  href="{url question/editanswer/$useranswer['id']}"><span type="edit">编辑</span></a>
   
     <a  onclick="if(confirm('确认删除回答吗?')){window.location='{url question/deleteanswer/$useranswer['id']/$qid}';}"><span type="del">删除</span></a>
               <!--{/if}-->
               
             
       
          
              </div>
                        {if $question['answers']>1}
               <div class="noreplaytext bb">
<center><div>   <a href="{url question/view/$qid}">  查看其它{$question['answers']}个回答
</a>
</div></center>
</div>
{/if}
            </div>
                         <div class="comments-mod "  style="display: none; float:none;padding-top:10px;" id="comment_{$useranswer['id']}">
                    <div class="areabox clearfix">

<form class="layui-form" action="">
               
            <div class="layui-form-item">
    <label class="layui-form-label" style="padding-left:0px;width:60px;">发布评论:</label>
    <div class="layui-input-block" style="margin-left:90px;">
         <input type="text" placeholder="不少于5个字" AUTOCOMPLETE="off" class="comment-input layui-input" name="content" />
                        <input type='hidden' value='0' name='replyauthor' />
    </div>
    <div class="mar-t10"><span class="fr layui-btn layui-btn-sm addhuidapinglun" data-id="{$useranswer['id']}">提交评论 </span></div>
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
<script type="text/javascript">
<!--{if $setting['code_ask']}-->
var needcode=1;
<!--{else}-->
var needcode=0;
  <!--{/if}-->
	 
</script>
 <!-- 公共底部 --> 
{template footer}


