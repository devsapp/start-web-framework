<!--{template header,admin}-->
<style>

.clearfix, .clear {
    clear: none;
}
</style>
<div>
<div style="width:100%; color:#000;margin:0px 0px 10px;">
    <div >
    <ol class="breadcrumb">
  <li><a href="{url admin_main/stat}">后台首页</a></li>
  <li><a href="{url admin_fankui/questionlist}">反馈问题列表</a></li>
  <li class="active">{$navtitle}</li>
</ol>

</div>
<div style="padding:8px;background:#f8f8f8;">
<article class="article">
  <header>
    <h1>{$question['subject']}</h1>
    <dl class="dl-inline">
      <dt>日期</dt>
      <dd>{$question['pubtime']}</dd>
    </dl>
    <div class="abstract">
      <p>{$question['content']}</p>
    </div>
  </header>

  <section class="content">
  {if $question['answerlist']}
  <h2>回复列表({eval echo count($question['answerlist']);}个):</h2>
  <hr>
  {loop $question['answerlist'] $answer}
  <div class="panel">
  <div class="panel-heading">
  {if $question['uid']==$answer['answeruid']}
    追问日期:
   {else}
       回复日期:
   {/if}
    {$answer['answertime']}
  </div>
  <div class="panel-body">
   {$answer['answercontent']}
  </div>
</div>

  {/loop}
  {/if}
  </section>

 <form>

  <div class="form-group">
    <label for="exampleInputPassword1">问题追问<span style="color:red;">(追问需描述清楚问题，描述不清楚拒绝回答)</span></label>
    
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
  <input type="hidden" id="onlyid" value="{$question['onlyid']}">
  <button type="button" id="btnappendreplay" class="btn btn-primary">追加问题</button>
</form>
</article>


 </div>



          
<!--{template footer,admin}-->
</div>