<!--{template header}-->
<style>
.block_border{
	border:solid 1px #ccc;
}
.content-wrapper, .right-side {
    min-height: 100%;
    background-color: #fff;
    z-index: 800;
}
.clearfix, .clear {
    clear: none;
}
</style>
<div class="row">
  <div class="col-md-6">
  <div class="alert alert-primary">
    <h4>提示</h4>
    <hr>
    <p>如果不配置开发者参数信息(appid和appsecret)将无法在线反馈问题，在线更新程序，在线安装插件，以及使用商业和免费的whatsns生态接口。</p>
    <p>参考配置教程：<a style="color:#F44336;" href="https://www.whatsns.com/doc/69.html" target="_blank">https://www.whatsns.com/doc/69.html</a></p>
  </div>
  <div class="ws_pannel">
     <div class="ws_pannel_header">
     开发者参数配置
     </div>
     <div class="ws_pannel_content">
       <form>
  <div class="form-group">
    <label for="exampleInputAccount1">APPID</label>
    <input type="text" class="form-control" value="{$setting['dev_appid']}" id="dev_appid" placeholder="whatsns开发者中心appid">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">APPSECRET</label>
    <input type="text" class="form-control" value="{$setting['dev_appsecret']}" id="dev_appsecret" placeholder="whatsns开发者中心appsecret">
  </div>
  <button type="button" id="btndevset" class="btn btn-primary">配置</button>
</form>
     </div>
  </div>

  </div>
  
    <div class="col-md-6">
      <div class="ws_pannel">
   <div class="ws_pannel_header">
     在线反馈问题给官方(whatsns)
     <span class="hasnewmessage" style="float:right;margin-left:4px;display:none;"><label class="label label-success"><a target="_blank" style="color:#fff;" href="{url admin_fankui/questionlist}">新回复</a></label></span><span style="float:right;font-size:12px;color:red;"><a target="_blank" class="btn btn-primary btn-mini" href="{url admin_fankui/questionlist}">查看反馈历史</a></span>
     </div>
     <div class="ws_pannel_content">
      <form>
  <div class="form-group">
    <label for="questiontitle">问题标题</label>
    <input type="text" class="form-control" id="questiontitle" placeholder="咨询问题标题">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">问题描述详情<span style="color:red;">(问题描述不清拒绝回复)</span></label>
    
<!--引入wangEditor.css-->
<link rel="stylesheet" type="text/css" href="{SITE_URL}static/js/wangeditor/pcwangeditor/css/wangEditor.min.css">



<!--引入jquery和wangEditor.js-->   <!--注意：javascript必须放在body最后，否则可能会出现问题-->

<script type="text/javascript" src="{SITE_URL}static/js/wangeditor/pcwangeditor/js/wangEditor.js"></script>

  <textarea  id="replaycontenteditor" name="content"   style="width:100%;height:200px;"></textarea>
<script type="text/javascript">
	// 初始化编辑器的内容
	  var myreplaycontenteditor = new wangEditor('replaycontenteditor');
	// 自定义配置
		myreplaycontenteditor.config.uploadImgUrl = g_site_url+"index.php?attach/upimg" ;
		myreplaycontenteditor.config.uploadImgFileName = 'wangEditorMobileFile';
		// 阻止输出log
	    wangEditor.config.printLog = false;
		  // 普通的自定义菜单
	    myreplaycontenteditor.config.menus = [
 'bold', '|', 'link', 'unlink', 'table',  '|', 'img',  'insertcode', '|', 'undo', 'redo', 'fullscreen'
	     ];
    myreplaycontenteditor.create();
	var _strhtml='<div><p>一、该问题的重现步骤是什么？</p><p>1.&nbsp;</p><p>2.&nbsp;</p><p>3.</p><p>二、你期待的结果是什么？实际看到的又是什么？</p><p><br></p><p>三、你正在使用的是whatsns什么版本？在什么操作系统上？</p><p><br></p><p>四、请提供详细的错误信息截图，这很重要。</p><p><br></p><p>五、若有更多详细信息，请在下面提供。</p></div>';
	myreplaycontenteditor.wang_txt.html(_strhtml) // 重新设置编辑器内容
$(".wangEditor-container").css("z-index","1");


</script>
  </div>
  <button type="button" id="btnreplay" class="btn btn-primary">反馈问题</button>
</form>
     </div>
     
     </div>
 
  </div>
 
</div>
 <div class="row">
  <div class="col-md-12 totaltoday">
  <div class="panel">
<div class="panel-heading">今日统计</div>
<div class="panel-body">
<div class="row">
<div class="col-md-3">
<div class="today-bg-hui">
<h3>今日注册用户数</h3>
<p>
<cite> {$today_reg_user}人 </cite>
</p>
</div>
</div>
<div class="col-md-3">
<div class="today-bg-hui">
<h3>今日咨询问题数</h3>
<p>
<cite> {$today_submit_question}个 </cite>
</p>
</div>
</div>
<div class="col-md-3">
<div class="today-bg-hui">
<h3>今日回答数</h3>
<p>
<cite> {$today_submit_answer}个 </cite>
</p>
</div>
</div>
<div class="col-md-3">
<div class="today-bg-hui">
<h3>今日发布文章数</h3>
<p>
<cite> {$today_submit_article}个 </cite>
</p>
</div>
</div>
</div>
</div>
</div>
  <div class=" totaltoday">
  <div class="panel">
<div class="panel-heading">网站环境信息</div>
<div class="panel-body">
<table class="table table-hover">
    <tbody>
      <tr>
        <td>操作系统</td>
        <td>{$serverinfo}</td>
      </tr>
         <tr>
        <td>php应用的web服务器</td>
        <td>{$webserver}</td>
      </tr>
    <tr>
        <td>最大上传大小</td>
        <td>{$fileupload}</td>
      </tr>
       <tr>
        <td>数据库版本</td>
        <td>mysql{$dbversion}</td>
      </tr>
       <tr>
        <td>allow_url_fopen开始</td>
        <td>{$allow_url_fopen}</td>
      </tr>
    
         <tr>
        <td>GD图形库版本</td>
        <td>{$gdinfo}</td>
      </tr>
        <tr>
        <td>最大执行时间</td>
        <td>{$max_ex_time}</td>
      </tr>
         <tr>
        <td>当前服务器时间</td>
        <td>{$systemtime}</td>
      </tr>
    </tbody>
  </table>
</div>
</div>
</div>
  </div>
  </div>
<!--{template footer}-->