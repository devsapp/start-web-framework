 <!-- 公共头部--> 
{template header}
 <!-- 首页导航 --> 
{template index_nav}

<div class="layui-container">
  <div class="layui-row layui-col-space15">
    <div class="layui-col-md8">
        {eval $this->load->model('topdata_model');}
          <!--{eval $topdatalist=$this->topdata_model->get_list(0,20," where type='note' ");}-->
          {if  $topdatalist}
     <!-- 首页顶置--> 
     <div class="fly-panel">
        <div class="fly-panel-title fly-filter">
          <a>置顶</a>
          <a href="#signin" class="layui-hide-sm layui-show-xs-block fly-right" id="LAY_goSignin" style="color: #FF5722;">去签到</a>
        </div>
       
        <ul class="fly-list">
     
                <!--{loop $topdatalist  $topdata}-->
          <li>
            <a href="{$topdata['url']}" class="fly-avatar">
              <img src="{$topdata['model']['avatar']}" alt="{$topdata['model']['author']}">
            </a>
            <h2>
            
            <a class="layui-badge">公告</a>
              <a href="{$topdata['url']}">{$topdata['title']}</a>
            </h2>
            <div class="fly-list-info">
              <a href="user/home.html" link>
                <cite>{$topdata['model']['author']}</cite>
               {if $topdata['author_has_vertify']} <i class="iconfont icon-renzheng" ></i>{/if}
               
              </a>
              <span>{eval echo tdate($topdata['time']);}</span>
              
           
              <span class="fly-list-nums"> 
                <i class="iconfont icon-pinglun1" title="回复"></i> {$topdata['answers']}
              </span>
            </div>
            <div class="fly-list-badge">
            
              <span class="layui-badge layui-bg-black">置顶</span>
              {if $topdata['type']=='topic'&&$topdata['model']['ispc']} <span class="layui-badge layui-bg-red">推荐</span>{/if}
             
            </div>
          </li>
            <!--{/loop}-->
        </ul>
      </div>
{/if}

      <div class="fly-panel" style="margin-bottom: 0;">
        <h3 class="fly-panel-title">公告</h3>
       
    <div class="layui-row layui-col-space-2 hotcategorylist">
  
    
             <!--{loop $notelist $index $note}-->
    <div class="layui-col-md12">
 <div class="layui-card hotcategory">
  <div class="layui-card-header"><a  {if $note['url']} href="{$note['url']}"  {else}  href="{url note/view/$note['id']}" {/if} class="font16">{$note['title']}</a></div>
  <div class="layui-card-body">
    <a  {if $note['url']} href="{$note['url']}"  {else}  href="{url note/view/$note['id']}" {/if}> {$note['content']}</a>
  </div>
  <div class="layui-card-footer">
  <p><span>{$note['views']}阅读</span><span>{$note['comments']}评论</span><span>{$note['format_time']}</span></p>
  </div>
</div>
    </div>
  <!--{/loop}-->
  </div>
         
          {template page}

      </div>
    </div>
    <div class="layui-col-md4">
 <!-- 推荐文章 -->
   {template index_tuijianwenzhang}
 
 <!-- 最新注册用户 -->
   {template index_newregisteruser}

     
 <!-- 热门讨论问题 -->
     {template index_hotquestion}
 <!-- 右侧广告位 -->
    {template index_rightadv}
        <!-- 微信二维码 --> 
   {template index_qrweixin}
    <!-- 友情链接 --> 
   {template friend_link}

    </div>
  </div>
</div>
 <!-- 公共底部 --> 
{template footer}