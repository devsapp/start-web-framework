<!-- 公共头部--> 
{template header}
 <!-- 移动端搜索框--> 
{template searchbox}

 <!-- 首页导航 --> 
{template index_nav}

<div class="layui-container">
  <div class="layui-row layui-col-space15">
    <div class="layui-col-md8">
     <!-- 首页顶置--> 
     {template index_dingzhi}
      <div class="fly-panel" style="margin-bottom: 0;">
        
        <div class="fly-panel-title fly-filter">
          <a href="{eval echo getcaturl('all','ask/index/#id#');}" class="layui-this">最新</a>
          <span class="fly-mid"></span>
          <a href="{eval echo getcaturl('all','ask/index/#id#/nosolve');}">未结</a>
          <span class="fly-mid"></span>
          <a href="{eval echo getcaturl('all','ask/index/#id#/solve');}">已结</a>
          <span class="fly-mid"></span>
          <a href="{eval echo getcaturl('all','ask/index/#id#/caifu');}">财富</a>
          
        </div>
 <!-- 最新问答列表 --> 
   {eval $maxnew=20;}
         {eval  $questionlist=$this->getlistbysql("select id,title,status,time,answers,author,authorid,description,cid,price  from ".$this->db->dbprefix."question where status not in(0,9)  order by time desc limit 0,$maxnew");}
 
      {template tmp_questionlist}
        <div style="text-align: center">
          <div class="laypage-main">
            <a href="{url ask/index}" class="laypage-next">更多问题</a>
           
          </div>
        </div>

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