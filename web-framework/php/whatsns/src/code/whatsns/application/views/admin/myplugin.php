<!--{template header,admin}-->
<div>
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div >
    <ol class="breadcrumb">
  <li><a href="{url admin_main/stat}">后台首页</a></li>
  <li class="active">{$navtitle}</li>
</ol>

</div>

<div style="padding:8px;margin:8px auto;">
<div class="alert alert-info"><b>插件安装需保证网站根目录下data目录中tmp目录权限可读可写可删除，且整站允许覆盖文件和新增文件和文件夹,否则无法将插件zip文件自动解压覆盖</b></div>
<!-- 插件安装 -->
<button class="btn btn-primary" data-moveable="true"  data-toggle="modal" data-target="#myModal">插件安装</button>
<a class="btn btn-info" href="{url admin_myplugin/pluginlog}">插件安装日志管理</a>

</div>

<div style="padding:8px; background:#f5f5f5;">
<div class="row">
{loop $pluginlist $plugin}
      {if !strstr($plugin['url'],"http://")&&!strstr($plugin['url'],"https://")}
      {eval $plugin['suburl']=url($plugin['url']);}
      {else}
      {eval $plugin['suburl']=$plugin['url'];}
      {/if}
   <div class="col col-md-3">
   <div style="margin-bottom:8px;min-width:100px;text-align:center;border:solid 1px #ebebeb;padding:8px 16px;display:inline-block;">
   <a href="{$plugin['suburl']}"><b>{$plugin['name']}</b></a>
   </div>
   </div>
   {/loop}
</div>
<div class="pages">{$departstr}</div>
</div>
<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
        <h4 class="modal-title">插件安装</h4>
      </div>
      <div class="modal-body">
        <ul class="nav nav-tabs">
  <li class="active"><a data-tab href="#tabContent1">本地上传(zip文件)</a></li>
  <li><a data-tab href="#tabContent2">远程下载</a></li>
</ul>
<div class="tab-content">
  <div class="tab-pane active" id="tabContent1">
  <form name="formlocal" action="{url admin_myplugin/localuploadplugin}" method="POST" enctype="multipart/form-data">
     <div style="padding:8px;">
     <div class="alert alert-warning">当前php.ini配置文件设置最大上传大小：<b style="color:#3280fc;">{eval echo ini_get('upload_max_filesize');}</b>(这是您服务器php默认设置，超过这个大小将上传失败。)</div>
     <input type="file" name="uplocalfile" accept=".zip" id="uplocalfile">
     
     <button type="button" id="btnuplocal" class="btn btn-primary" style="margin-top:8px;">上传本地zip文件</button>
     </div>
     <script type="text/javascript">
     $("#btnuplocal").click(function(){
         var _file=$("#uplocalfile").val();
         if(_file==''){
             alert("请添加zip格式插件安装包");
             return false;
         }
        document.formlocal.submit();
     });
     </script>
     </form>
  </div>
  <div class="tab-pane" id="tabContent2" style="padding:8px;">
    <form name="webformplugin" class="form-inline" action="{url admin_myplugin/webuploadplugin}" method="POST">
  <div class="form-group">
    <label for="exampleInputEmail3">远程下载地址：</label>
    <input style="width:400px;" type="text" class="form-control" name="downpluginurl" id="downpluginurl" placeholder="填写插件zip下载地址">
  </div>
  <button type="button" id="btnwebupload" class="btn btn-primary">安装</button>
      <script type="text/javascript">
     $("#btnwebupload").click(function(){
         var _file=$.trim($("#downpluginurl").val());
         if(_file==''){
             alert("请填写下载插件地址");
             return false;
         }
        document.webformplugin.submit();
     });
     </script>
</form>
  </div>

</div>
      </div>
 
    </div>
  </div>
</div>

<!--{template footer,admin}-->
</div>