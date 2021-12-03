  <!-- 公共头部--> 
{template header}
 <!-- 首页导航 --> 
{template index_nav}
<link rel="stylesheet" type="text/css" href="{SITE_URL}static/js/wangeditor/pcwangeditor/css/wangEditor.min.css">
        <link rel="stylesheet" type="text/css" href="{SITE_URL}static/js/poster/poster.css">
  <script type="text/javascript" src="{SITE_URL}static/js/poster/haibao.js"></script>
<div class="layui-container">
  <div class="layui-row layui-col-space15">
    <div class="layui-col-md8 content detail">
      <div class="fly-panel detail-box">
        <h1>{$topicone['title']}</h1>
        <div class="fly-detail-info">
        {if $topicone['state']==0}<span class="layui-badge">审核中</span>{/if}
        <a href="{eval echo getcaturl($cat_model['id'],'topic/catlist/#id#');}"><span class="layui-badge layui-bg-green fly-detail-column">{$cat_model['name']}</span></a>
           
          {eval $tid=$topicone['id']; $topdataarticle=$this->getlistbysql("select id,type,typeid from  ".$this->db->dbprefix."topdata where typeid=$tid and type='topic' limit 0,1");}
          {if count($topdataarticle)}<span class="layui-badge layui-bg-black">置顶</span>{/if}
          {if $topicone['ispc']==1}<span class="layui-badge layui-bg-red">推荐</span>{/if}
           
          <div class="fly-admin-box" data-id="123">
            {if $isfollowarticle}
                 <a href="{url favorite/delfavoratearticle/$topicone['id']}"><span class="layui-badge layui-bg-blue  fly-detail-column">已收藏</span></a>
         
                 {else}
                  <a href="{url favorite/topicadd/$topicone['id']}"><span class="layui-badge layui-bg-blue fly-detail-column">收藏</span></a>
         
                  {/if}
           <!--{if $user['grouptype']==1||$user['uid']==$topicone['authorid']}-->
                {if $topicone['shangjin']==0} <a onclick="if(confirm('确认删除吗?')){window.location='{url user/deletexinzhi/$topicone['id']}';}"> <span class="layui-btn layui-btn-xs jie-admin" type="del">删除</span></a> {/if}
             <!--{if $user['grouptype']==1}-->
                {if !$topdataarticle}  <a href="{url topicdata/pushindex/$topicone['id']/topic}" >
                 
          <span class="layui-btn layui-btn-xs jie-admin" type="set" field="stick" rank="1">置顶</span>   
                    </a>  {/if} 
          {if count($topdataarticle)}   <a href="{url topicdata/cancelindex/$topicone['id']/topic}" > <span class="layui-btn layui-btn-xs jie-admin" type="set" field="stick" rank="0" style="background-color:#ccc;">取消置顶</span>  </a>  {/if} 
           
            {if $topicone['ispc']==0}<a href="{url topic/pushhot/$topicone['id']}" ><span class="layui-btn layui-btn-xs jie-admin" type="set" field="status" rank="1">推荐</span> </a>{/if}
            {if $topicone['ispc']==1}<a href="{url topic/cancelhot/$topicone['id']}" > <span class="layui-btn layui-btn-xs jie-admin" type="set" field="status" rank="0" style="background-color:#ccc;">取消推荐</span></a>{/if} 
           
             <!--{/if}-->
  <!--{/if}-->
          </div>
          <span class="fly-list-nums"> 
            <a href="#comment"><i class="iconfont" title="评论">&#xe60c;</i> {$topicone['articles']}</a>
            <i class="iconfont" title="人气">&#xe60b;</i> {$topicone['views']}
          </span>
        </div>
		  <a  class="layui-btn layui-btn-normal"  target="_self" href="javascript:showposter('{SITE_URL}',$topicone['id'],'article')"   title="生成海报" style="font-size:12px;"><span class=""><i style="margin-right: 5px;font-size:18px;position:relative;top:3px;" class="fa fa-share-alt"></i></span>生成海报</a>
        
        <div class="detail-about">
          <a class="fly-avatar" href="{url user/space/$topicone['authorid']}">
            <img src="{$member['avatar']}" alt="{$topicone['author']}">
          </a>
          <div class="fly-detail-user">
            <a href="{url user/space/$topicone['authorid']}" class="fly-link">
              <cite>{$topicone['author']}</cite>
            {if $topicone['author_has_vertify']!=false}  <i class="iconfont icon-renzheng" title="认证信息：{$member['signature']}"></i>{/if}
             
            </a>
            <span>{$topicone['viewtime']}</span>
          </div>
          <div class="detail-hits" id="LAY_jieAdmin" data-id="123">
            <span style="padding-right: 10px; color: #FF7200" title="{$topicone['price']}{$caifuzhiname}">阅读需：<i class="layui-icon layui-icon-diamond font13"></i>{$topicone['price']}</span>  
              <!--{if $user['grouptype']==1||$user['uid']==$topicone['authorid']}--><span class="layui-btn layui-btn-xs jie-admin" type="edit"><a href="{url user/editxinzhi/$topicone['id']}">编辑此文章</a></span> <!--{/if}-->
          </div>
        </div>
        <div class="detail-body photos">
            <div class="wangEditor-container" style="border:none;">
            	<div class="wangEditor-txt" style="padding:0px;">
            	     {template article_content_header}
      
                     {if $topicone['price']!=0&&$haspayprice==0&&$user['uid']!=$topicone['authorid']}
  {eval echo replacewords($topicone['freeconent']);}
  
                         <div class="box_toukan ">

										{if $user['uid']==0}
											<div onclick="login()" class="thiefbox font12 mar-t10" style="color:#fff;text-decoration:none;padding:5px 10px 5px 10px;margin-top:10px;" ><i class="icon icon-lock font-12"></i> &nbsp;更多阅读需支付&nbsp;$topicone['price']&nbsp;&nbsp;{eval if ($topicone['readmode']==2) echo '财富值'; }{eval if ($topicone['readmode']==3) echo '元'; }……</div>
											{else}
											<div onclick="viewtopic($topicone['id'])"  class="thiefbox font12 mar-t10" style="color:#fff;text-decoration:none;padding:5px 10px 5px 10px;margin-top:10px;" ><i class="icon icon-lock font-12"></i> &nbsp;更多阅读需支付&nbsp;$topicone['price']&nbsp;&nbsp;{eval if ($topicone['readmode']==2) echo '财富值'; }{eval if ($topicone['readmode']==3) echo '元'; }……</div>
											{/if}


										</div>
                   {else}
                   {eval echo  replacewords(clearlinkref(htmlspecialchars_decode($topicone['describtion'])));}
           
              
                    {/if}

         {template article_content_footer}

</div>
</div>
        </div>
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
          <legend>评论</legend>
        </fieldset>

        <ul class="jieda" id="jieda">
           <!--{loop $commentlist $index $comment}-->
          
          <li data-id="111">
            <a name="item-1111111111"></a>
            <div class="detail-about detail-about-reply">
              <a class="fly-avatar" href="{url user/space/$comment['authorid']}">
                <img src="{$comment['avatar']}" alt="{$comment['author']}">
              </a>
              <div class="fly-detail-user">
                <a href="{url user/space/$comment['authorid']}" class="fly-link">
                  <cite>{$comment['author']}</cite>       
                </a>
              </div>
              <div class="detail-hits">
                <span>{$comment['time']}</span>
              </div>
            </div>
            <div class="detail-body jieda-body photos">
            {$comment['content']}
            </div>
            <div class="jieda-reply">
              <span class="jieda-zan button_commentagree" type="zan" id='{$comment['id']}'>
                <i class="iconfont icon-zan"></i>
                <em>{$comment['supports']}</em>
              </span>
              <span class="getcommentlist" dataid='{$comment['id']}' datatid="{$topicone['id']}">
                <i class="iconfont icon-svgmoban53"></i>
                回复{if $comment['comments']}<cite>{$comment['comments']}</cite>{/if}
              </span>
              <div class="jieda-admin">
                <!--{if 1==$user['grouptype'] ||$user['uid']==$comment['authorid']}-->
    <span class="delcomment hand" data-id="$comment['id']"  data-tid="{$tid}">删除</span>
     <!--{/if}-->
                
           
              </div>
            </div>
             <div class="sub-comment-list  hide" dataflag="0" id="articlecommentlist{$comment['id']}">
              <div class="commentlist{$comment['id']}">

              </div>
              <div class="sub-comment more-comment">
              <a class="add-comment-btn" dataid="{$comment['id']}"><i class="fa fa-edit"></i>
               <span class="hand">添加新评论</span></a>
               <!----> <!----> <!---->
               </div>
                <div class="formcomment{$comment['id']} hide">
                <form class="new-comment">
                <!---->
                <textarea placeholder="写下你的评论..." class="commenttext{$comment['id']}"></textarea>
                 <div class="write-function-block">


                  <div class=" mar-t10 btn-sendartcomment layui-btn layui-btn-sm fr" id="btnsendcomment{$comment['id']}"  dataid="{$comment['id']}" datatid="{$topicone['id']}">发送</div>

                  </div>
                  </form>
                   <!---->
                   </div>
                   </div>
          </li>
           <!--{/loop}-->
           {template page}
             <!--{if $commentlist==null}-->
          <!-- 无数据时 -->
         <li class="fly-none">消灭零回复</li>
                <!--{/if}-->
        </ul>
        
        <div class="layui-form layui-form-pane">
          <form action="/jie/reply/" method="post">
            <div class="layui-form-item layui-form-text">
              <a name="comment"></a>
              <div class="layui-input-block">
               <textarea  placeholder="写下你的评论..." class="comment-area layui-textarea"></textarea>
              </div>
            </div>
            <div class="layui-form-item">
               <input type="hidden" id="artitle" value="{$topicone['title']}" />
    <input type="hidden" id="artid" value="{$topicone['id']}" />
    {if !$user['uid']}     <a href="{url user/login}" class="layui-btn btn-cm-submit  {if !$user['uid']} layui-btn-disabled{/if}"  name="comments" id="comments">登录后回复</a>
          {else}
              <div class="layui-btn btn-cm-submit "  name="comments" id="comments">提交回复</div>
          
    {/if}
    
          
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="layui-col-md4">
              <!-- 推荐文章 -->
     {template index_tuijianwenzhang} 
 <!-- 热门讨论问题 -->
     {template index_hotquestion}
 <!-- 右侧广告位 -->
    {template question_rightadv}
       <!-- 右侧微信二维码 -->
    {template index_qrweixin}
      

    </div>
  </div>
</div>

 <!-- 公共底部 --> 
{template footer}