 <!-- 公共头部--> 
{template header}
 <!-- 首页导航 --> 
{template index_nav}

<div class="layui-container">
  <div class="layui-row layui-col-space15">
    <div class="layui-col-md8">
     <!-- 最新注册--> 
 <div class="fly-panel fly-rank fly-rank-reply" id="LAY_replyRank">
        <h3 class="fly-panel-title">最新注册</h3>
       <!-- 最多显示最新注册的32人-->
        {eval $maxregusernums=32;}
        <dl>
         {eval $newreguserlist=$this->getlistbysql("select uid,username,regtime,isblack  from ".$this->db->dbprefix."user where isblack=0 order by regtime desc limit 0,$maxregusernums");}
          {loop $newreguserlist $reguser}
          <dd>
            <a href="{url user/space/$reguser['uid']}">
              <img src="{eval echo get_avatar_dir($reguser['uid']);}"><cite title="{$reguser['username']}">{$reguser['username']}</cite><i title="{eval echo tdate($reguser['regtime']);}">{eval echo tdate($reguser['regtime']);}</i>
            </a>
          </dd>
          {/loop}
        </dl>
      </div>
      
           <!-- 最新注册--> 
 <div class="fly-panel fly-rank fly-rank-reply" id="LAY_replyRank">
        <h3 class="fly-panel-title">活跃</h3>
       <!-- 最多显示活跃用户的32人-->
        {eval $maxhotusernums=32;}
        <dl>
         {eval $newreguserlist=$this->getlistbysql("select uid,username,regtime,isblack  from ".$this->db->dbprefix."user where isblack=0 order by answers desc limit 0,$maxhotusernums");}
          {loop $newreguserlist $reguser}
          <dd>
            <a href="{url user/space/$reguser['uid']}">
              <img src="{eval echo get_avatar_dir($reguser['uid']);}"><cite title="{$reguser['username']}">{$reguser['username']}</cite><i title="{eval echo tdate($reguser['regtime']);}">{eval echo tdate($reguser['regtime']);}</i>
            </a>
          </dd>
          {/loop}
        </dl>
      </div>
      
    </div>
    <div class="layui-col-md4">
 <!-- 推荐文章 -->
   {template index_tuijianwenzhang}
 

     
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