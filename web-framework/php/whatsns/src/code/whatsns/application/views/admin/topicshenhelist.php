<!--{template header}-->
<script type="text/javascript" src="{SITE_URL}static/js/jquery-ui/jquery-ui.js"></script>
<script src="{SITE_URL}static/js/admin.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#list").sortable({
            update: function(){
                var reorderid="";
                var numValue=$("input[name='order[]']");
                for(var i=0;i<numValue.length;i++){
                    reorderid+=$(numValue[i]).val()+",";
                }
                var hiddentid=$("input[name='hiddentid']").val();
                $.post("index.php?admin_topic/reorder{$setting['seo_suffix']}",{order:reorderid});
            }
        });
    });
</script>
<style>
em{
	color:red;
}
</style>
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" ><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;专题管理</div>
</div>
<!--{if isset($message)}-->

<div class="alert alert-warning">{$message}</div>
<!--{/if}-->
   <a class="btn write-btn btn-success" href="{url admin_topic}">
            返回文章列表
        </a>
                <a class="btn write-btn btn-success"  href="{url admin_topic/shenhe}">
            <i class="fa fa-check"></i>文章审核
        </a>
            <a class="btn write-btn btn-success"  href="{url admin_topic/vertifycomments}">
            <i class="fa fa-check"></i>文章评论审核
        </a>
<form  method="post">
    <table class="table">
        <tbody>
            <tr class="header" ><td colspan="4">文章列表</td></tr>
            <tr class="altbg1"><td colspan="4">可以通过如下搜索条件，检索文章</td></tr>
            <tr>
                <td width="200"  class="altbg2">标题:<input class="txt form-control" name="srchtitle" {if isset($srchtitle)}value="{$srchtitle}" {/if}></td>
                <td  width="200" class="altbg2">作者:<input class="txt form-control" name="srchauthor" {if isset($srchauthor)}value="{$srchauthor}" {/if}></td>

                 <td  width="200" class="altbg2">分类:
                    <select class="form-control shortinput" name="srchcategory" id="srchcategory"><option value="0">--不限--</option>{$catetree}</select>
                </td>
            </tr>

            <tr>
              <td  rowspan="2" class="altbg2"><input class="btn btn-info" name="submit" type="submit" value="查询"></td>
              </tr>
        </tbody>
    </table>
</form>
[共 <font color="green">{$rownum}</font> 个文章]
<form name="answerlist"  method="POST">
<input type="hidden" name="viewtid" value="1">
    <table class="table">
        <tr class="header" align="center">
            <td width="10%"><input class="checkbox" value="chkall" id="chkall" onclick="checkall('tid[]')" type="checkbox" name="chkall"><label for="chkall">选择</label></td>
            <td  width="10%">博客作者</td>

            <td width="20%">博客名称</td>

      
            <td  width="10%">浏览</td>
        </tr>
 
    
        <!--{loop $topiclist $topic}-->
 
    
                <tr align="center" class="smalltxt">

                    <td width="10%" class="altbg2"><input class="checkbox" type="checkbox" value="{$topic['id']}" name="tid[]"></td>
                                      <td width="10%" class="altbg2">
                                      <strong>{$topic['author']}</strong></td>

                    <td width="20%" class="altbg2"><input name="order[]" type="hidden" value="{$topic['id']}"/><strong><a target="_blank" href="{url topic/getone/$topic['id']}">{$topic['title']}</a></strong></td>


                    <td width="10%" class="altbg2" align="center"><img src="{SITE_URL}static/css/admin/edit.png" style="cursor:pointer" onclick="document.location.href='{SITE_URL}index.php?admin_topic/view/$topic['id']{$setting['seo_suffix']}'"></td>
                </tr>
    
     
        <!--{/loop}-->
   </table>

   <div class="pages">{$departstr}</div>


    <input class="button" tabindex="3" onClick="buttoncontrol(2)" type="submit" value=" 删除 " name="ctrlcase">

    <input class="button" tabindex="4" onClick="buttoncontrol(4)" type="submit" value="审核通过 " name="ctrlcase">

</form>

<br>

<!--{template footer}-->
<script>
function buttoncontrol(num) {

	  if ($("input[name='tid[]']:checked").length == 0) {
          alert('你没有选择任何要操作的文章！');
          return false;
      }else{
    	   switch (num) {
    
           case 2:
        	   if (confirm('确定删除问题？该操作不可返回！') == false) {
                   return false;
               } else {
               document.answerlist.action = "index.php?admin_topic/remove{$setting['seo_suffix']}";
               document.answerlist.submit();
               }
               break;

           case 4:
        	   if (confirm('确认审核通过吗！') == false) {
                   return false;
               } else {
               document.answerlist.action = "index.php?admin_topic/vertify{$setting['seo_suffix']}";
               document.answerlist.submit();
               }
               break;
    	   }
      }
}
{if $srchcategory}
$(document).ready(function(){
    $("#srchcategory option").each(function(){
        if($(this).val()==$srchcategory){
            $(this).prop("selected","true");
        }
    });
});
{/if}
</script>