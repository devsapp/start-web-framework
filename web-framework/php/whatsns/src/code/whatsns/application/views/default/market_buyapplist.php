{loop $applist $app}
<div class="col col-md-6">

<div class="applist" {if $app['data']['istuijian']}style="border:solid 2px #4caf50;min-height:125px;margin-bottom:8px;"{else}style="margin-bottom:8px;border:solid 2px #bbb;min-height:125px;"{/if}>
<div class="row" style="padding-top:8px;padding-bottom: 8px;padding-right:8px;">
<div class="col-md-2" style="text-align: center;">
<img src="{$app['data']['image']}" style="border-radius:8px;margin: 0 auto;width:50px;height:50px;" />
<p style="margin-top: 4px;font-size:14px;font-weight:900;color:red;">
    {if $app['appprice']>=1}
￥{eval echo  sprintf("%.2f",substr(sprintf("%.3f", $app['appprice']), 0, -2));}
{else}
￥{$app['appprice']}
{/if}
</p>
</div>

<div class="col-md-10">

<div>
{if $app['data']['istuijian']}
<label style="font-size:10px;margin-right:8px;" class="label label-danger">推荐</label>
{/if}
{if $app['data']['isguanfang']}
<label style="font-size:10px;" class="label label-success">官方</label>
{/if}
<span style="margin-left:4px;font-weight: 900;font-size:13px;" id="packinfo{$app['appid']}">{$app['appname']}</span>
</div>
<div style="font-size:12px;color:#bbb;padding-top:8px;padding-bottom:8px;">
{$app['data']['jianjie']}

<div style="padding-top:8px;padding-bottom:8px;">
购买时间:{$app['format_time']}
</div>
</div>
<div style="font-size:12px;">
{if $app['isdown']}
<button data-id="{$app['appid']}" id="btnupfile{$app['appid']}" onclick="downfile({$app['appid']})"  style="margin-right:6px;" class="btn btn-sm btn-danger btndo">重新安装</button>
<button data-id="{$app['appid']}"  onclick="backupsource({$app['appid']})" style="margin-right:6px;" class="btn btn-sm btn-warning btndo">恢复安装前</button>
<button id="duibi{$app['appid']}" onclick="duibi({$app['appid']})" style="margin-right:6px;" class="btn btn-sm btn-info btndo">查看安装文件</button>
{if $app['data']['appurl']}
<a style="margin-right:6px;" target="_blank" href="{SITE_URL}{$app['data']['appurl']}" class="btn btn-sm btn-info btndo">管理应用</a>
{/if}
{else}
<button data-id="{$app['appid']}" id="btnupfile{$app['appid']}" onclick="downfile({$app['appid']})"  style="margin-right:6px;" class="btn btn-sm btn-danger btndo">安装应用</button>
{/if}

<a target="_blank" href="{DEVDOMAIN}market/detail/{$app['appid']}.html" class="btn btn-sm btn-info">查看详情</a>
</div>

</div>

</div>
</div>

</div>
{/loop}
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
//下载应用
function downfile(_fileid){

	$(".btndo").attr("disabled",true);
	var _url="{url admin_market/downbuyappfile}";
	var _data={"appid":_fileid};
	function success(result){
      console.log(result);
      $(".btndo").removeAttr("disabled");
      $(".btndo").attr("disabled",false);
      if(result.code==200){
        window.location.reload();
      }
      alert(result.msg);
	}
	ajaxpost(_url,_data,success);
}
//恢复之前
function backupsource(_fileid){
	$(".btndo").attr("disabled",true);
	var _url="{url admin_market/backupsource}";
	var _data={"appid":_fileid};
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
	var _url="{url admin_market/duibi}";
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