<!--{template header,admin}-->
<div>
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div >
    <ol class="breadcrumb">
  <li><a href="{url admin_main/stat}">后台首页</a></li>
  <li><a href="{url admin_myplugin/clist}">插件列表</a></li>
  <li class="active">{$navtitle}</li>
</ol>

</div>
<div style="padding:8px;">
<div class="alert alert-warning">
<p><strong>提示:</strong></p>
<p><b>插件安装文件:</b>本次安装插件的下载地址</p>
<p><b>原文件备份目录:</b>每次安装插件会先检测是否会覆盖原有网站目录，如果存在覆盖会先将覆盖文件提前备份到此目录,您可以打开此目录查找原来覆盖的文件当作备份使用</p>
<p><b>备份zip文件:</b>为了防止安装插件导致覆盖原来文件后网站出现问题，可以下载这个原来文件备份包覆盖站点根目录</p>
</div>
<form class="form-inline" action="{url admin_myplugin/pluginlog}" method="POST" style="margin-bottom: 8px;">
  <div class="form-group">
    <label for="exampleInputEmail3">插件名称关键词:</label>
    <input type="text" value="{$pluginname}" name="pgname" class="form-control" id="pgname" placeholder="输入关键词搜索">
  </div>
  <button type="submit" class="btn btn-primary">搜索</button>
</form>
<div class="row">
<div class="col-sm-12"><p>共发现<span style="margin:0px 4px;"><b>{$rownum}</b></span>条记录</p></div>

</div>
<table class="table" >
  <thead>
    <tr>
   
      <th>插件名称</th>
      <th>插件版本号</th>
       <th>插件安装时间</th>
         <th>插件安装文件</th>
          <th>原文件备份目录</th>
           <th>备份zip文件</th>
           <th>更新文件列表</th>
    </tr>
  </thead>
  <tbody>
  {loop $pluginlist $plugin}
    <tr>
 
      <td><a href="{$plugin['pluginurl']}">{$plugin['name']}</a></td>
       <td>V{$plugin['version']}</td>
        <td>{$plugin['plugintime']}</td>
         <td>{if $plugin['pluginfile']=='0'}安装文件已被删除{else}<a class="btn btn-primary btn-sm" href="{$plugin['pluginfile']}">下载插件安装包到本地</a>{/if}</td>
          <td>{if $plugin['backupdir']=='0'}备份目录不存在{else}<p><button type="button" class="btn btn-info btn-sm" data-custom="{$plugin['backupdir']}" data-toggle="modal">查看备份目录</button>{/if}</td>
           <td>{if $plugin['backupzipfile']=='0'}备份文件不存在{else}<a class="btn btn-primary btn-sm" href="{$plugin['backupzipfile']}">下载备份文件</a>{/if}</td>
           <td>
           {if $plugin['pluginfile']=='0'}
           
           {else}
             <button type="button" data-scroll-inside="true"   class="btn btn-info btn-sm" data-moveable="true" data-toggle="modal"  data-target="#myModal{$plugin['id']}">浏览</button>
                    <div class="modal fade" id="myModal{$plugin['id']}">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
        <h4 class="modal-title">{$plugin['name']}-V{$plugin['version']}(安装时间:{$plugin['plugintime']})</h4>
      </div>
         <div class="modal-body"  style="max-height: 400px;overflow:scroll;">
           <table class="table">
  <thead>
    <tr>
      <th>更新文件列表</th>
    </tr>
  </thead>
    <tbody>
      {loop $plugin['pluginfilelist'] $file}
    
{if $file!="install.json"&&$plugin['basename']!=$file}
    <tr>
      <td>{$file}</td>
    </tr>
  {/if}


           {/loop}
       </tbody>      
</table>
 </div>
    </div>
  </div>
</div>
          
           {/if}

           
           
           </td>
    </tr>
 {/loop}
  </tbody>

</table>
<div class="pages">{$departstr}</div>
</div>

<!--{template footer,admin}-->
</div>