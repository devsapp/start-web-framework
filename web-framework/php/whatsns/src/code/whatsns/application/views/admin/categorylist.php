<!--{template header}-->
<script src="{SITE_URL}static/js/admin.js" type="text/javascript"></script>

<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;分类管理</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<table class="table">
    <tr>
        <td class="{$type}">{$message}</td>
    </tr>
</table>
<!--{/if}-->
<table class="table">
    <tr class="header"><td>分类列表
     {if isset($category['name'])&&$category['grade']!=2&&$category['pid']==0}
<a class="btn btn-success" href="{url admin_category}">返回上一级</a>
{/if}&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-danger" style="cursor:pointer" onclick="document.location.href = '{url admin_category/add/new}'" >添加新分类</button>
  
    <tr class="altbg2"><td>
            <a href="index.php?admin_category/default{$setting['seo_suffix']}">根目录</a>
            {if isset($navlist)}
            <!--{loop $navlist $nav}-->
            &gt;&gt; <a href="{url admin_category/myview/$nav['id']}">{$nav['name']}</a>
            <!--{/loop}-->
            {/if}
            {if isset($category['name'])}&gt;&gt; {$category['name']}{/if}</td></tr>
</table>


<form name="myform" method="POST">
     <input type="hidden" name="hiddencid" value="{$pid}" />
    <table class="table">
        <tr class="header" align="center" style="font-weight:bold;">
            <td class="" width="5%"><input class="checkbox" value="chkall" id="chkall" onclick="checkall('cid[]')" type="checkbox" name="chkall"><label for="chkall">全选</label></td>
            <td class="" width="10%">排序</td>
            <td class="" width="10%">专栏名称</td>
             <td class="" width="10%">首页显示(一级分类有效)</td>
              <td class="" width="10%">应用问答发布</td>
               <td class="" width="10%">应用文章发布</td>
               <td class="" width="10%">只在后台发布</td>
            <td  class="" width="5%">查看子分类</td>
            <td  class="" width="5%">添加子分类</td>

            <td  class="" width="5%">编辑</td>
        </tr>

 </table>
       <ul id="list" style="width:100%;float: right;" >
        <!--{loop $categorylist $cate}-->

              <li style="list-style:none;">
                  <table class="table">

                <tr align="center" class="smalltxt">
                    <td width="2%" class="altbg2 text-left"><input class="checkbox" type="checkbox" value="{$cate['id']}" name="cid[]"></td>
                    <td class="" width="10%"><input name="corder{$cate['id']}" type="text" value="{$cate['displayorder']}"/></td>
                    <td width="10%" class="altbg2"><a href="index.php?admin_category/myview/{$cate['id']}{$setting['seo_suffix']}"><input name="order[]" type="hidden" value="{$cate['id']}"/><strong>{$cate['name']}</strong></a></td>
                         <td width="10%" class="altbg2" align="center">
                       <span class="label">
                      {$cate['isshowindex']}
                       </span>
                       </td>
                        <td width="10%" class="altbg2" align="center" style="padding-left:60px;">
                       <span class="label">
                      {$cate['isuseask']}
                       </span>
                       </td>
                        <td width="10%" class="altbg2" align="center">
                       <span class="label">
                      {$cate['isusearticle']}
                       </span>
                       </td>
    <td width="10%" class="altbg2" align="center">
                       <span class="label">
                      {$cate['onlybackground']}
                       </span>
                       </td>


                    <td width="5%" class="altbg2" align="center"><a href="{url admin_category/myview/$cate['id']}"><img src="{SITE_URL}static/css/admin/view.png" style="cursor:pointer" ></a></td>
                    <td width="5%" class="altbg2" align="center"><a href="{url admin_category/add/$cate['id']/$cate['pid']}"><img src="{SITE_URL}static/css/admin/add.png" style="cursor:pointer" ></a></td>
                    <td width="5%" class="altbg2" align="center"><a href="{url admin_category/edit/{$cate['id']}}"><img src="{SITE_URL}static/css/admin/edit.png" style="cursor:pointer" ></a></td>
                </tr>
                </table>
           </li>

        <!--{/loop}-->


   <input class="btn btn-success" tabindex="3" type="button" onClick="buttoncontrol(1);" value=" 删除分类 " name="delete" />&nbsp;&nbsp;&nbsp;
      <input class="btn btn-success" tabindex="3" type="button" onClick="buttoncontrol(5);" value=" 更新排序 " name="delete" />&nbsp;&nbsp;&nbsp;
    <input class="btn btn-success" tabindex="3" type="button"  onClick="buttoncontrol(2);" value=" 首页显示/不显示 " name="indexbtn" />&nbsp;&nbsp;&nbsp;
       <input class="btn btn-success" tabindex="3" type="button"  onClick="buttoncontrol(3);" value="应用/不应用到问答发布" name="wendabtn" />&nbsp;&nbsp;&nbsp;
         <input class="btn btn-success" tabindex="3" type="button"  onClick="buttoncontrol(4);" value="应用/不应用到文章发布" name="wenzhangbtn" />&nbsp;&nbsp;&nbsp;
         <input class="btn btn-success" tabindex="3" type="button"  onClick="buttoncontrol(6);" value="应用/不应用到前端发布" name="wenzhangbtn" />&nbsp;&nbsp;&nbsp;
</form>

<br>




<script>
var catid=0;
function buttoncontrol(num) {
    if ($("input[name='cid[]']:checked").length == 0) {
        alert('你没有选择任何要操作的分类！');
        return false;
    } else {
        switch (num) {
        case 1:
            if (confirm('删除该分类会同时删除该分类下的子分类及其分类下的所有问题，确定继续?') == false) {
                return false;
            } else {
            	var myurl=g_site_url+"index.php?admin_category/remove{$setting['seo_suffix']}";
                myform.action = myurl;
                myform.submit();
            }
            break;
            case 2:
                if (confirm('确定执行此操作吗？此项操作只对默认default模板有效！') == false) {
                    return false;
                } else {
                	var myurl=g_site_url+"index.php?admin_category/updatecatbyindex{$setting['seo_suffix']}";
                    myform.action = myurl;
                    myform.submit();
                }
                break;
            case 3:
         	   if (confirm('确定执行此操作吗？此项操作在发布问题页面将动态显示和隐藏分类！') == false) {
                   return false;
               } else {
               	var myurl=g_site_url+"index.php?admin_category/updatecatbywenda{$setting['seo_suffix']}";
                   document.myform.action = myurl;
                   document.myform.submit();
               }
                break;
            case 4:
                if (confirm('确定执行此操作吗？此项操作对发布文章页面将动态显示和隐藏分类！') == false) {
                    return false;
                } else {
                	var myurl=g_site_url+"index.php?admin_category/updatecatbywenzhang{$setting['seo_suffix']}";
                    document.myform.action = myurl;
                    document.myform.submit();
                }
                break;
            case 5:

                	var myurl=g_site_url+"index.php?admin_category/updatecatbyorder{$setting['seo_suffix']}";
                    document.myform.action = myurl;
                    document.myform.submit();

                break;
            case 6:
                if (confirm('确定执行此操作吗？此项操作执行后前端发布页面无法选择此分类！') == false) {
                    return false;
                } else {
                	var myurl=g_site_url+"index.php?admin_category/updatecatbybackground{$setting['seo_suffix']}";
                    document.myform.action = myurl;
                    document.myform.submit();
                }
                break;
            default:
                alert("非法操作！");
                break;
        }
    }
}





</script>
<!--{template footer}-->
