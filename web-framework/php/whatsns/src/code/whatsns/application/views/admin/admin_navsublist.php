<!--{template header}-->
<script type="text/javascript" src="{SITE_URL}static/js/jquery-ui/jquery-ui.js"></script>
<script src="{SITE_URL}static/js/admin.js" type="text/javascript"></script>
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
  <div style="float:left;"><a href="{SITE_URL}index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;导航管理</div>
</div>
<div style="margin-bottom:16px;margin-top:16px;">
<a href="{SITE_URL}index.php?admin_nav/manager{$setting['seo_suffix']}" class="btn btn-primary">返回后台导航列表</a>
</div>
{if $parentnav}
<h2 style="margin-top:16px;margin-bottom:16px; font-size:14px;">{$parentnav['name']}---<a class="btn btn-mini btn-danger" href="{SITE_URL}index.php?admin_nav/manageraddchildnav/{$navid}{$setting['seo_suffix']}">添加子导航</a></h2>
{/if}
<form name="myform" method="POST">
<input type="hidden" name="updateseccat" value="1">
<table class="table">
  <thead>
    <tr>
    <th><input class="checkbox" value="chkall" id="chkall" onclick="checkall('cid[]')" type="checkbox" name="chkall"><label for="chkall">全选</label></th>
      <th>排序</th>
      <th>菜单名</th>
      <th width="30%">跳转地址</th>
      <th>状态</th>
     
    </tr>
  </thead>
  <tbody>
  {loop $navlist $nav}
    <tr>
                      <td ><input class="checkbox" type="checkbox" value="{$nav['id']}" name="cid[]"><b>id：{$nav['id']}</b></td>
                    <td ><input name="corder{$nav['id']}" type="text" value="{$nav['ordernum']}"/></td>
        <td ><input name="cname{$nav['id']}" type="text" value="{$nav['name']}"/></td>
  <td width="30%">
  <input  style="width:100%" name="curl{$nav['id']}" type="text" value="{$nav['url']}"/>
     {if !strstr($nav['url'],"http://")&&!strstr($nav['url'],"https://")}
      {eval $nav['suburl']=url($nav['url']);}
      {else}
      {eval $nav['suburl']=$nav['url'];}
      {/if}
  <div>实际地址:<a style="color:#3280fc;margin-left:8px;" href="{$nav['suburl']}">{$nav['suburl']}</a></div>
  </td>
      <td ><select name="cstatus{$nav['id']}">
      <option value="1" {if $nav['status']==1}selected{/if}>已激活      </option>
       <option value="0" {if $nav['status']==0}selected{/if}>不可见     </option>
      
      </select></td>
     
    </tr>
    {/loop}
   
  </tbody>
</table>
 <input class="btn btn-info" tabindex="3" type="button" onClick="buttoncontrol(1);" value="批量更新导航" name="updatebtn" />&nbsp;&nbsp;&nbsp;
 <input class="btn btn-info" tabindex="3" type="button" onClick="buttoncontrol(2);" value="批量删除导航" name="updatebtn" />&nbsp;&nbsp;&nbsp;

</form>
<div style="margin-top: 16px;margin-left:16px;background:#fff;">
<p><b>提示</b></p>
<p>1. 如果将导航设置为“不可见”那么此导航不会显示在左侧列表</p>
<p>2. 二级导航删除后不可恢复，慎重删除，如果没有必要删除可以设置“不可见”</p>
<p>3. 列表排序按照“从小达到”顺序展示，数字越小排名越靠前</p>
</div>

<script>
function getnav(){
	$(".treeview").each(function(){
		var _this=$(this);
        var _navname=_this.find("span").html();
        
        	   $.post("{SITE_URL}index.php?admin_nav/managerpost{$setting['seo_suffix']}",{'name':_navname,'pid':0},function(result){
                   var _pid=result.pid;
                   console.log(result);
                   if(result.code==200){
                	   _this.find(".treeview-menu li a").each(function(i,item){
                         	var _subnavname=$(item).text();
                         	var _subnavurl=$(item).attr("href");
                         	$.post("{SITE_URL}index.php?admin_nav/managerpost{$setting['seo_suffix']}",{'name':_subnavname,'pid':_pid,'url':_subnavurl},function(subresult){
                         		console.log("子目录");
                                console.log(subresult);
                         	},'json');
                         });
                   }
            	
               },'json');

     
     
     
	});
}
function buttoncontrol(num) {
    if ($("input[name='cid[]']:checked").length == 0) {
        alert('你没有选择任何要操作的导航！');
        return false;
    } else {
        switch (num) {
        case 1:
         	var myurl=g_site_url+"index.php?admin_nav/managerdo{$setting['seo_suffix']}";
            myform.action = myurl;
            myform.submit();
            break;
        case 2:
        	 if(confirm('确定删除子导航吗?')==false){
                 return false;
             }
         	var myurl=g_site_url+"index.php?admin_nav/managerdoremove{$setting['seo_suffix']}";
            myform.action = myurl;
            myform.submit();
            break;
            default:
                alert("非法操作！");
                break;
        }
    }
}





</script>
<!--{template footer}-->