<!--{template header}-->
{if !is_mobile()}

      <link href="{SITE_URL}static/css/common/download.css" rel="stylesheet">
{else}
<!--{template meta}-->
      <link href="{SITE_URL}static/css/common/download.css" rel="stylesheet">
<script src="{SITE_URL}static/js/jquery-1.11.3.min.js"></script>
<style>
.btns{
display:flex;
padding: 0 10px;
    box-sizing: border-box;
}

.btnflex{
flex:1;
}
.btndownload, .btndownload:hover, .btn:hover, .btn:focus, .btn:active {
    display: inline-block;
    min-width: 28px;
    }
    .btndoc, .btndoc:hover {
    display: inline-block;
    min-width: 68px;
    height: 33px;
    padding: 0 20px 1px;
    }
    .downfixed {
    padding-right:0px;
    }
</style>
{/if}

 <div class="container download">
  <div class="row product-bd">
  <div class="col-md-12 col-xs-24 bt10">
  <h1 class="title" >
        
        <i class="icon-product-nls"></i>
        
        WHATSNS问答系统 </h1>
        
        <div class="intro" >
       whatsns问答系统是一款可以根据自身业务需求快速搭建垂直化领域的php开源问答系统，内置强大的采集功能，支持云存储，图片水印设置，全文检索，站内行为监控，短信注册和通知，伪静态URL自定义，熊掌号功能，百度结构化地图（标签，问题，文章，分类，用户空间），PC和Wap模板分离，内置多套pc和wap模板，站长自由切换，同时后台支持模板管理在线编辑修改模板，强大的防灌水拦截和过滤配置等上百项功能，深入SEO优化，适合对SEO有需求的站长。商业版还支持火车采集，高级微信公众号接口功能，支持支付宝支付、微信扫码支付、微信JSSDK支付、微信H5支付、小程序支付、适合不同场景支付业务需求，如充值，打赏，回答偷看，付费专家咨询。
       如需更加丰富的功能可以根据自身网站需求购买商业版，我们有个人版，基础版，高级版，微信版，小程序版，APP版。
       <div class="alert alert-warning" style="      padding: 15px;  background-color: #fcf8e3;border-color: #faebcc;color: #8a6d3b;">模板文件夹中default和webappwap模板已不再维护，使用者自行决定是否在后台选用</div>
       <p class="qqgroup">
        <span>  官方QQ群一：370431002</span> <span>官方QQ群二：258722465</span> 
       </p>
      </div>
      <div class="btns">
  
    
      <a data-placement="top" data-toggle="tooltip" data-container="body" data-original-title="最后发布日期:2018年12月10日" class="btn btndownload bt10" target="_blank" href="https://gitee.com/huangyouzhi/whatsns">
      码云下载
      </a>
    
        <a class="btn btndoc btl20 btr20 bt10" target="_blank" href="https://pan.baidu.com/s/1V-Yo8Tite4tZmdF133K5Lw">
     网盘下载
      </a>
  
      </div>
  </div>
    <div class="col-md-10 col-xs-24 bt10">
    <img src="{SITE_URL}static/css/common/downindex.png"  class="indeximg"/>
  </div>
  </div>
  <div class="row" id="jieshao">
      <div class="col-md-24 col-xs-24">
      <div class="float-box y-row">
    <div>
      <ul class="menu-box y-clear">
        
        <li class="y-left" onclick="document.getElementById('jieshao').scrollIntoView(true);return false;" >产品概述</li>
        
        <li class="y-left"  onclick="document.getElementById('shengjidownachor').scrollIntoView(true);return false;">升级下载及说明</li>
        
        <li class="y-left" onclick="document.getElementById('anzhuangshuoming').scrollIntoView(true);return false;"  >安装说明</li>
        
        <li class="y-left" onclick="document.getElementById('bangzhuodc').scrollIntoView(true);return false;"  >帮助与文档</li>
        
      </ul>
    
   
    </div>
  </div>
      </div>
  </div>
  <!-- 产品介绍 -->
  <div class="row" >
  <div class="col-md-24 col-xs-24">
    <div class="module-wrap J_tb_lazyload">
      <div class="y-row aliyun-product-title">
      <h4>问答系统V3.8产品简介</h4>
      </div>
     </div>

      <table class="func-table">
      <tbody>
      <tr>
        <td class="func-title bluebk">二开简单</td>
        <td class="func-bd">

          
          <div class="func-module ">
            <h3>基于php的CodeIgniter3.1.6开发</h3>
            <p class="func-desc">
         优雅的CI框架是国内php开发者最喜欢的MVC框架，上手快，轻量级，可以在虚拟主机单核cpu1g内存1m带宽下完美流畅运行，可以参考CI官网了解更多框架信息http://codeigniter.org.cn/
         <i>CI开发群微信扫一扫-><img src="{SITE_URL}static/css/common/wxjpg.jpg" class="wxjpg"></i>
            </p>
            <ul class="func-list">
              
            </ul>
            <p class="func-desc">
              
            </p>
          </div>
          
       
          
        </td>
      </tr>
      </tbody>
    </table>
     <div id="aliyunnls-tts" style="height:30px"></div>
      <table class="func-table">
      <tbody>
      <tr>
        <td class="func-title redbk">内容付费</td>
        <td class="func-bd">

          
          <div class="func-module ">
            <h3>专业的问答内容付费功能</h3>
            <p class="func-desc">
            支持财富值充值、现金充值、回答打赏、文章打赏、付费回答偷看，付费文章阅读，付费专家咨询、付费悬赏咨询、全网独家底层全套支付接口满足内容付费任何场景业务需求，您可以在PC端，app端，微信端，小程序和任何移动wap端对站内支付业务唤起微信支付和支付宝支付，不受终端限制。  
            </p>
            <ul class="func-list">
              
            </ul>
            <p class="func-desc">
              
            </p>
          </div>
          
       
          
        </td>
      </tr>
      </tbody>
    </table>
    <div id="aliyunnls-tts" style="height:30px"></div>
      <table class="func-table">
      <tbody>
      <tr>
        <td class="func-title yellowbk">语音回答</td>
        <td class="func-bd">

          
          <div class="func-module ">
            <h3>独家支持图文和语音回答，跨终端收听语音</h3>
            <p class="func-desc">
           不受微信端限制，采用第三方自动转码插件，自动转码语音，可在任何终端收听语音回答，微信端可以在线录制长达60s的语音回答，pc端可以上传不受时间限制的语音mp3文件，在线播放。
            </p>
            <ul class="func-list">
              
            </ul>
            <p class="func-desc">
              
            </p>
          </div>
          
       
          
        </td>
      </tr>
      </tbody>
    </table>
    
           <div id="aliyunnls-tts" style="height:30px"></div>
     <table class="func-table">
      <tbody>
      <tr>
        <td class="func-title zongse">站内采集</td>
        <td class="func-bd">

          
          <div class="func-module ">
            <h3>自动采集</h3>
            <p class="func-desc">
                                  支持单页问答和文章采集，设置定时采集任务，可以批量采集问答和文章，自动抓取页面问答和文章列表，适合首页，列表页面等数据更新比较频繁的页面。
            </p>
            <ul class="func-list">
              
            </ul>
            <p class="func-desc">
              
            </p>
          </div>
          
          <div class="func-module ">
            <h3>分页采集</h3>
            <p class="func-desc">
              单任务采集支持分页采集，可以采集问答标题，描述，最佳答案，其他回答列表，回答用户名，回答头像，过滤内容图片和超链接，一键多页采集，还可以对采集内容进行二次编辑修改在发布，可以设置定时单页采集，分分钟填充网站内容数据，无需人工干预。
            </p>
            <ul class="func-list">
              
            </ul>
            <p class="func-desc">
              
            </p>
          </div>
          
        </td>
      </tr>
      </tbody>
    </table>
    <div id="aliyunnls-tts" style="height:30px"></div>
      <table class="func-table">
      <tbody>
      <tr>
        <td class="func-title lvse">完美标签</td>
        <td class="func-bd">

          
          <div class="func-module ">
            <h3>标签强化</h3>
            <p class="func-desc">
           3.8版本之前都是鸡肋的标签功能，3.8版本对标签进行优化，合并问答和文章标签表，生成独立标签表维护标签，可以对标签进行TDK的seo优化，支持上传标签图片，封面图，提升标签页面权重，标签详情页面支持标签动态，标签相关问答和文章列表展示，同时根据标签所在分类匹配分类下相关标签。                    
            </p>
            <ul class="func-list">
              
            </ul>
            <p class="func-desc">
              
            </p>
          </div>
          
       
          
        </td>
      </tr>
      </tbody>
    </table>
    <div id="aliyunnls-tts" style="height:30px"></div>
      <table class="func-table">
      <tbody>
      <tr>
        <td class="func-title zise">多套模板</td>
        <td class="func-bd">

          
          <div class="func-module ">
            <h3>模板多样化</h3>
            <p class="func-desc">
          以往模板都是单套，一套pc和一套wap，3.8新增了一套黄色的pc和一套黄色的wap站，站长可以根据自己喜好在后台系统设置--站点设置里随意切换，同时官方qq群可以下载模板视频开发教程，自己新增一套模板不要一分钟即可制作。 
            </p>
            <ul class="func-list">
              
            </ul>
            <p class="func-desc">
              
            </p>
          </div>
          
       
          
        </td>
      </tr>
      </tbody>
    </table>
    <div id="aliyunnls-tts" style="height:30px"></div>
      <table class="func-table">
      <tbody>
      <tr>
        <td class="func-title jiuhong">内容审核</td>
        <td class="func-bd">

          
          <div class="func-module ">
            <h3>问答、文章、认证、提现审核</h3>
            <p class="func-desc">
         后台管理员可以设置对问题发布审核，文章发布审核，用户认证审核，提现申请审核，同时可以在用户组里对不同用户角色设置发布文章和问题权限。
            </p>
            <ul class="func-list">
              
            </ul>
            <p class="func-desc">
              
            </p>
          </div>
          
       
          
        </td>
      </tr>
      </tbody>
    </table>
       <div id="aliyunnls-tts" style="height:30px"></div>
      <table class="func-table">
      <tbody>
      <tr>
        <td class="func-title qianhong">编辑器功能</td>
        <td class="func-bd">

          
          <div class="func-module ">
            <h3>强大的WangEditor和Ueditor</h3>
            <p class="func-desc">
          whatsns问答系统独家支持多套编辑器，可以根据自身业务切换编辑器，如有需要上传语音收听，上传视频观看，上传附件需求的站长可以使用Ueditor,如果仅需要发布图片需求的站长可以使用WangEditor，轻量级，UI美观，不占带宽。    
            </p>
            <ul class="func-list">
              
            </ul>
            <p class="func-desc">
              
            </p>
          </div>
          
       
          
        </td>
      </tr>
      </tbody>
    </table>
     <div id="aliyunnls-tts" style="height:30px"></div>
      <table class="func-table">
      <tbody>
      <tr>
        <td class="func-title heise">云存储</td>
        <td class="func-bd">

          
          <div class="func-module ">
            <h3>附件OSS云存储</h3>
            <p class="func-desc">
           可以将站内视频，图片，音频上传到阿里云OSS，实现静态分离，降低服务器访问压力，适合大站需求。
            </p>
            <ul class="func-list">
              
            </ul>
            <p class="func-desc">
              
            </p>
          </div>
          
       
          
        </td>
      </tr>
      </tbody>
    </table>
         <div id="aliyunnls-tts" style="height:30px"></div>
      <table class="func-table" id="shengjidownachor">
      <tbody>
      <tr>
        <td class="func-title shenhong">单点登录</td>
        <td class="func-bd">

          
          <div class="func-module ">
            <h3>集成ucserver和uclinet</h3>
            <p class="func-desc">
         可以支持多用户统一管理，程序内置UCserver和UClient，站长安装后可以同时支持多个网站直接同时登录和注册，退出。
            </p>
            <ul class="func-list">
              
            </ul>
            <p class="func-desc">
              
            </p>
          </div>
          
       
          
        </td>
      </tr>
      </tbody>
    </table>
  </div>
  </div>
  
  
  
    <!-- 产品介绍 -->
  <div class="row" id="shengjidown">
  <div class="col-md-24 col-xs-24">
    <div class="module-wrap J_tb_lazyload">
      <div class="y-row aliyun-product-title">
     
   <h4>升级下载及说明</h4>
      </div>
     </div>
         <div class="btns">
      <a data-placement="top" data-toggle="tooltip" data-container="body" data-original-title="最后发布日期:2018年12月06日" class="btn btndownload bt10" target="_blank" href="http://www.bixiaoliu.com/download/updateV3.8-2018-12-31.zip">
      下载V3.8升级包
      </a>
         <a class="btn btndoc btl20 btr20 bt10" target="_blank" href="https://pan.baidu.com/s/1DawwBjvNcwKB_I8gXa13WA">
     V3.8升级文档
      </a>
      </div>
      <div style="background: #009a61;color:#fff;padding:10px;border-radius: 5px;">
      V3.7以下用户如需升级可以加入官方qq群下载升级包或者联系技术，后续官方不在维护default和webappwap模板，统一维护widescreen和fronzewap模板
      </div>
          <div class="intro">
          
         <h4><strong>2018-12-06更新日志</strong></h4>
         <p>1 修复文章专栏页面点击热门文章游客不能访问的问题</p>
         </div>
          <div class="intro">
          
         <h4><strong>2018-12-05更新日志</strong></h4>
         <p>1 后台标签管理新增批量插入标签</p>
          <p>2 pc端增加友链功能</p>
            <p>3 移动端fronzewap模板调整成绿色风格并修改UI效果</p>
           <p>4 PC端UI配色和列表展示效果调整</p>
           <P>5 修复ueditor在回答时提示内容为空的问题</P>
             <p>6 文章内容加载统一采用延时加载</p>
          <p></p>
         </div>
         
         <div class="intro">
          
         <h4><strong>2018-11-22更新日志</strong></h4>
         <p>1 修复问题和文章详情页面header标签中keyword显示问题</p>
         <p>2 修复宽屏模板中修改文章提示封面图不存在问题</p>
         <p>3 修复问题页面相关问题地址不对</p>
          <p></p>
         </div>
     <div class="intro">
     <strong>whatsns3.7升级到whatsns问答3.8步骤：</strong>
   <blockquote> <p>升级成功后删掉问答根目录下的updatesql.php和updatetag.php，如若安装用户删掉install文件夹，  注意升级包里如果在 application/config/目录下包含config.php和database.php要删掉，否则会覆盖原来的网站和数据库配置，导致网无法访问。
</p></blockquote>
 <strong>前言：</strong>
 <p>准备工作：超级管理员先登录网站，进入后台。</p>

 <strong>1 上传后覆盖原来的问答目录</strong>
<p>注意执行权限，data文件夹以及子目录全部777，否则无法上传图片写入到文件夹。</p>
 <strong>2 准备升级啦</strong>
 <p>在浏览器里输入：http://你的域名/updatesql.php</p>
 <p>这一步是升级文章相关的表字段，增加了文章审核功能</p>

 <strong>3 在浏览器里输入 http://你的域名/updatetag.php</strong>
 <p>这一步是将原来程序里文章和问答标签合并，新版不在让用户在提问和发布文章输入乱七八糟标签，标签统一在内容管理—标签管理里面管理，前端提问和发文都是输入标签。
</p>
 <strong>4 后台左下角点击更新缓存，更新后手动刷新下后台首页。</strong>
 <p>更新后即可在插件管理看到最新的插件列表，内容管理里面可以维护标签。</p>

 <strong>本次升级主要功能如下：</strong>
 <p id="anzhuangshuoming">1 插件管理里面新增了熊掌号插件</p>
 <p>2 插件管理里面新增了站内多任务自动采集插件</p>
 <p>3 插件管理里面新增了分页采集插件</p>
 <p>4 新增了标签管理功能</p>
 <p>5 修复了若干3.7遗留的问题</p>

     
     </div>
     </div>
     </div>


  <!-- 安装说明-->
  <div class="row" >
  <div class="col-md-24 col-xs-24">
    <div class="module-wrap J_tb_lazyload">
      <div class="y-row aliyun-product-title">
      <h4>安装说明</h4>
      </div>
     </div>
     <div class="intro">
     <blockquote>问答系统V3.8用户可以直接上传文件夹到问答根目录安装，域名访问即可，国内主机需备案后访问安装，IIS用户安装后如出现问答网页地址变成IP情况参考V3.7版本application/config/config.php配置文件里绑定域名。</blockquote>
     <p>问答系统3.7用户请先修改application/config/config.php配置文件</p>
   <code>  {eval echo '$';}config['base_url'] ='http://localhost/'; 
    <p>将localhost修改成你的域名。</p>  
     </code> 
        
          <p>下一步直接域名访问安装即可，如果先安装后修改配置域名的用户会导致模板缓存文件中url地址错误，可以删除根目录下data/view/*.php和data/cache/*.php全部php缓存文件，记住只能删除php文件夹，这些都是缓存文件。<p> 
     </div>
     </div>
     </div>

  <!-- 产品介绍 -->
  <div class="row" id="bangzhuodc">
  <div class="col-md-24 col-xs-24">
    <div class="module-wrap J_tb_lazyload">
      <div class="y-row aliyun-product-title">
      <h4>帮助以及文档</h4>
      </div>
     </div>
     <div class="btns">
          <a class="btn btndoc  bt10" target="_blank" href="https://pan.baidu.com/s/1-o-SqwlHdlKo-QDMe0wEMA">
      开发文档
      </a>
         <a class="btn btndoc bt10 btl20 btr20" target="_blank" href="https://pan.baidu.com/s/1mltRTGcWtj5IdfHTrOEpZw">
    数据表字典
      </a>
           <a class="btn btndoc bt10  btr20" target="_blank" href="https://pan.baidu.com/s/1vA6nBsFNjdvfBHCtFhjJ3Q">
配置文档
      </a>
          <a class="btn btndoc bt10  btr20" target="_blank" href="https://pan.baidu.com/s/1DawwBjvNcwKB_I8gXa13WA">
V3.7升级V3.8帮助文档
      </a>
      
     </div>
     <div class="intro">
     <strong>使用帮助</strong>
     <p>
     邮箱配置教程:https://www.ask2.cn/article-14579.html
     </p>
         <p>
     水印设置教程:https://www.ask2.cn/article-14580.html
     </p>
         <p>
    伪静态教程:https://www.ask2.cn/article-14574.html
     </p>
     </div>
     </div>
     </div>
 </div>
 <div class="downfixed">
      <div class="btns">
      <a  data-placement="bottom" data-toggle="tooltip" data-container="body" data-original-title="最后发布日期:2018年12月10日"  class="btn btndownload bt10 btnflex" target="_blank" href="https://pan.baidu.com/s/1V-Yo8Tite4tZmdF133K5Lw">
      下载
      </a>
        <a class="btn btndoc btl20 btr20 bt10 btnflex" target="_blank" href="https://pan.baidu.com/s/1-o-SqwlHdlKo-QDMe0wEMA">
      开发文档
      </a>
         <a class="btn btndoc bt10 btnflex" target="_blank" href="https://pan.baidu.com/s/1mltRTGcWtj5IdfHTrOEpZw">
    数据表字典
      </a>
      </div>
 </div>
 <script type="text/javascript">
        $(document).ready(function(){
        	$(".func-desc i,.func-desc .wxjpg").click(function(){
        		$(".func-desc .wxjpg").show()
        	});
             $(".func-desc i").hover(function(){
            	 $(".func-desc .wxjpg").show()
                 }
             ,function(){
            	 $(".func-desc .wxjpg").hide()
                 })

            $(document).scroll(function(){

                var winScrollTop = $(window).scrollTop();  //获取窗口滚动的距离
               
                if(winScrollTop > 400){
                   $(".downfixed").show();
                }else{
                	 $(".downfixed").hide();
                }

            });
        });

    </script>
{if !is_mobile()}
<!--{template footer}-->
{else}
<div class="display:none;">
 <!--{if $setting['site_statcode']}--> {eval echo decode($setting['site_statcode'],'tongji');}<!--{/if}-->

</div>
  <div class="side-tool" id="to_top"><ul><li data-placement="left" data-toggle="tooltip" data-container="body" data-original-title="回到顶部" >
    <a href="#" class="function-button"><i class="fa fa-angle-up"></i></a>
    </li>



      </ul></div>
      <script>
window.onload = function(){
  var oTop = document.getElementById("to_top");
  var screenw = document.documentElement.clientWidth || document.body.clientWidth;
  var screenh = document.documentElement.clientHeight || document.body.clientHeight;
  window.onscroll = function(){
    var scrolltop = document.documentElement.scrollTop || document.body.scrollTop;

    if(scrolltop<=screenh){
    	oTop.style.display="none";
    }else{
    	oTop.style.display="block";
    }
  }
  oTop.onclick = function(){
    document.documentElement.scrollTop = document.body.scrollTop =0;
  }
}

</script>
{/if}
