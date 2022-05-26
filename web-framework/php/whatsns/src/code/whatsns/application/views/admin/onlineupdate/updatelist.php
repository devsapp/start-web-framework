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

<div class="row" style="margin-bottom:8px;">
<div class="row">
<div class="col-sm-12">

<div class="alert alert-success">
<strong>{$leveltext}</strong>
<p>更新包下载和备份目录:{$dirlocation}</p>
</div>

</div>

</div>

{if $msg!=''}
<div class="row">
<div class="col-sm-12">

<div class="alert alert-warning">
{$msg}
</div>

</div>

</div>
{/if}

<div style="margin: 16px auto;">
 <button class="btn  btn-primary btnupdateall">一键更新全部未更新的包</button>
</div>
<table class="table">

  <thead>
    <tr>
    <th>序号</th>
      <th>更新简介</th>
     
      <th>发布日期</th>
      <th width="120px">对比文件</th>
      <th>可下载</th>
      <th>是否更新</th>
      <th>操作</th>
    </tr> 
  </thead>
  <tbody>
  {loop $filelist $index $file}
    <tr>
    <td>{eval echo ++$index;}</td>
      <td><div id="packinfo{$file['id']}">{$file['name']}
      <span class="label label-primary">V{$file['version']}</span>
      </div>
      </td>
   
      <td>{$file['format_time']}</td>
       <td width="120px" ><span id="duibi{$file['id']}" onclick="duibi({$file['id']})" class="btn btn-danger btn-sm">查看对比</span></td>
       <td>  
        {if $file['status']==1}
            <span class="label label-success">可下载</span>
       {else}
          <span class="label label-danger">不可下载</span>
        {/if}
    </td>
       <td>  
        {if $file['downlog']==1}
            <span class="label label-success showupdatetime" data-toggle="tooltip" data-placement="left" title="最后更新时间：{$file['downtime']}">已更新</span>
       {else}
          <span id="status{$file['id']}" class="noupdatepackage label label-danger">未更新</span>
        {/if}
    </td>
      <td>

      <button  data-scroll-inside="true"   class="btndo btn btn-info btn-sm" data-moveable="true" data-toggle="modal"  data-target="#myModal{$file['id']}">查看更新内容</button>
                      <div class="modal fade" id="myModal{$file['id']}">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
        <h4 class="modal-title">{$file['name']}-V{$file['version']}(安装时间:{$file['format_time']})</h4>
      </div>
         <div class="modal-body updatecontent"  style="max-height: 600px;overflow:scroll;">
  {$file['content']}
 </div>
    </div>
  </div>
</div>
 {if $file['downlog']==1}
         <button data-id="{$file['id']}" id="btnupfile{$file['id']}" onclick="downfile({$file['id']})" class="btndo btn btn-sm">重新下载并更新</button>
         <button data-id="{$file['id']}"  onclick="backupsource({$file['id']})" class="btndo btn btn-primary btn-sm">恢复</button>
       {else}
      
          <button   data-id="{$file['id']}" id="btnupfile{$file['id']}"   onclick="downfile({$file['id']})" class="btndo btn btn-primary btn-sm">下载并更新</button>
        {/if}
        
      </td>
      
    </tr>
{/loop}
  </tbody>
</table>
<div class="pages">{$departstr}</div>
</div>
                 <div class="modal fade" id="showupdatepackge">
  <div class="modal-dialog" style="width: 800px;">
    <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
        <h4 class="modal-title"></h4>
      </div>
         <div class="modal-body"  style="max-height: 800px;overflow:scroll;">
         <div class="alert alert-info">
         <p><strong>提示：</strong></p>
         <p>1. 对比更新前 会将更新后的文件和更新前的文件对比文件内容差异</p>
          <p>2. 对比更新后 会将更新后的文件和更新后的文件对比文件内容差异，如果两个文件不一样则表示此次更新失败</p>
          <p>3. 对应开启站点防篡改和站点文件写入权限不够都会更新失败，导致更新后对比内容不一样，更新文件对应路径不存在</p>
         <p id="packagedir"></p>
         </div>
        <table class="table">
        <thead>
        <th>序号</th>
        <th>文件位置</th>
         <th>操作</th>
        </thead>
        <tbody id="packgetbody">
        </tbody>
        </table>
 </div>
    </div>
  </div>
</div>
<script>
$(".btnupdateall").click(function(){


    $(".btnupdateall").addClass("btn-disabled");
	  $(".btnupdateall").attr("disabled",true);
var updateidarr=new Array();
$(".noupdatepackage").each(function(){
updateidarr.push($(this).attr("id").replace('status',''));


})
updateidarr=updateidarr.reverse()
var _len=updateidarr.length;
for (var i = 0; i < _len; i++) {
(function (t, data) {   // 注意这里是形参
setTimeout(function () {
var _upid=updateidarr[t];

console.log(_upid)
downfile(_upid);



}, 1000 * t);	// 还是每秒执行一次，不是累加的
})(i, updateidarr)   // 注意这里是实参，这里把要用的参数传进去
}


$(".btnupdateall").removeAttr("disabled");
	            $(".btnupdateall").attr("disabled",false);
	            $(".btnupdateall").removeClass("btn-disabled");
});
$(".updatecontent").find("img").each(function(index,item){
    $(this).attr("data-toggle","lightbox")
     $(this).attr("data-group","lightbox"+index)
});
//你需要手动初始化工具提示
$('[data-toggle="tooltip"]').tooltip();
function downfile(_fileid){

	$(".btndo").attr("disabled",true);
	var _url="{url admin_onlineupdate/updatefile}";
	var _data={"fileid":_fileid};
	function success(result){
      console.log(result);
      $(".btndo").removeAttr("disabled");
      $(".btndo").attr("disabled",false);
      if(result.code==200){
      console.log($("#status"+_fileid).html())
          $("#status"+_fileid).html("已更新");
      $("#status"+_fileid).addClass("label label-success showupdatetime");
      $("#btnupfile"+_fileid).removeAttr("disabled");
     $("#btnupfile"+_fileid).attr("disabled",true);
      }
      alert(result.msg);
	}
	ajaxpost(_url,_data,success);
}
function backupsource(_fileid){
	$(".btndo").attr("disabled",true);
	var _url="{url admin_onlineupdate/backupsource}";
	var _data={"fileid":_fileid};
	function success(result){
      console.log(result);
      $(".btndo").removeAttr("disabled");
      $(".btndo").attr("disabled",false);
      alert(result.msg);
	}
	ajaxpost(_url,_data,success);
}
function duibi(_fileid){
	console.log("开始对比")
	 $("#duibi"+_fileid).removeAttr("disabled");
     $("#duibi"+_fileid).attr("disabled",true);
	var _url="{url admin_onlineupdate/duibi}";
	var _data={"fileid":_fileid};
	function success(result){
      console.log(result);
      if(result.code==200){ 
          $("#packagedir").html("<strong>当前更新包路径（路径下backup文件夹为更新前备份文件夹)："+result.packagedir+"</strong>");        
          $("#showupdatepackge .modal-title").html($("#packinfo"+_fileid).html());
          $("#showupdatepackge").modal("show");
    	  console.log(result.data);
    	  var _count=result.data.length;
    	  $("#packgetbody").html("");
    	  for(var i=0;i<_count;i++){
        	  var _index=i+1;
        	  var _strcaozuo=''; //按钮1 -对比前
        	  var _strcaozuo2='';// 按钮2 -对比后
        	  var _tiptext=''; //提示是否是新增文件
        	  if(result.backlist[i]==1){
            	  //跳转对比页面
            	 var _url=result.urllist[i];
            	  //操作按钮
        		 _strcaozuo="<a target='_blank' href='"+_url+"' class='btn btn-sm btn-info'>对比更新前</a>";
        		 var _url2=result.urllist2[i];
         		 _strcaozuo2="<a style='margin-left:4px;' target='_blank' href='"+_url2+"' class='btn btn-sm btn-success'>对比更新后</a>";
           	  }else{
           	
           		if(result.urllist2[i]==1){
           			
            		 _strcaozuo2="<a style='margin-left:4px;' target='_blank' href='"+_url2+"' class='btn btn-sm btn-success'>对比更新后</a>";
           		}else{
           		    var _tiptext="<span class='label label-warning'>新增文件</span>";
           		   	if(result.urllist2[i]==0){
           		   	    
           		   	    		_strcaozuo2="文件覆盖失败，站点对应路径下未找到";
           		   	}
           	
           		}
           	  }
        	 
        	   var _tdstr="<tr><td>"+_index+"</td><td>"+result.data[i]+_tiptext+"</td><td>"+_strcaozuo+_strcaozuo2+"</td></tr>";
             $("#packgetbody").append(_tdstr);
    	  }
      }else{

    	   alert(result.msg);

      }
    
      $("#duibi"+_fileid).removeAttr("disabled");
      $("#duibi"+_fileid).attr("disabled",false);
   
	}
	ajaxpost(_url,_data,success);
}
</script>
<!--{template footer,admin}-->
</div>