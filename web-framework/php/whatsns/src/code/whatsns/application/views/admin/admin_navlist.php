<!--{template header,admin}-->
<script type="text/javascript" src="{SITE_URL}static/js/jquery-ui/jquery-ui.js"></script>
<script src="{SITE_URL}static/js/admin.js" type="text/javascript"></script>
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
  <div style="float:left;"><a href="{SITE_URL}index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;导航管理</div>
</div>
<div style="margin-bottom:16px;margin-top:16px;">
<a href="{SITE_URL}index.php?admin_nav/manageradd{$setting['seo_suffix']}" class="btn btn-primary">添加导航</a>
</div>
<!-- 老版本初次更新导航 -->
<button class="btn btn-warning btngetnav"  style="display:none;" onclick="getnav()" type="button">获取导航</button>
<form name="myform" method="POST">
<table class="table">
  <thead>
    <tr>
    <th><input class="checkbox" value="chkall" id="chkall" onclick="checkall('cid[]')" type="checkbox" name="chkall"><label for="chkall">全选</label></th>
      <th>排序</th>
      <th>菜单名</th>
      <th>子菜单个数</th>
      <th>状态</th>
       <th>操作</th>
    </tr>
  </thead>
  <tbody>
  {loop $navlist $nav}
    <tr>
                      <td ><input class="checkbox" type="checkbox" value="{$nav['id']}" name="cid[]"><b>id：{$nav['id']}</b></td>
                    <td ><input name="corder{$nav['id']}" type="text" value="{$nav['ordernum']}"/></td>
        <td ><input name="cname{$nav['id']}" type="text" value="{$nav['name']}"/></td>
      <td>{$nav['childs']}个<a style="font-size:12px;color:#3280fc;margin-left:8px;" href="{SITE_URL}index.php?admin_nav/managerviewchildnav/{$nav['id']}{$setting['seo_suffix']}">查看</a></td>
      <td ><select name="cstatus{$nav['id']}">
      <option value="1" {if $nav['status']==1}selected{/if}>已激活      </option>
       <option value="0" {if $nav['status']==0}selected{/if}>不可见     </option>
      
      </select></td>
        <td><a class="btn btn-mini btn-primary" href="{SITE_URL}index.php?admin_nav/manageraddchildnav/{$nav['id']}{$setting['seo_suffix']}">添加子菜单</a></td>
    </tr>
    {/loop}
   
  </tbody>
</table>
 <input class="btn btn-info" tabindex="3" type="button" onClick="buttoncontrol(1);" value="批量更新导航" name="updatebtn" />&nbsp;&nbsp;&nbsp;

</form>

<div style="margin-top: 16px;margin-left:16px;background:#fff;">
<p><b>提示</b></p>
<p>1. 如果将导航设置为“不可见”那么此导航不会显示在左侧列表</p>
<p>2. 一级导航不可以删除，仅可设置“不可见”，隐藏后左侧不会出现此导航</p>
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
          
            default:
                alert("非法操作！");
                break;
        }
    }
}





</script>
<!--{template footer,admin}-->