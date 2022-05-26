<!--{template header}-->
<script type="text/javascript" src="{SITE_URL}static/js/jquery-ui/jquery-ui.js"></script>
<script src="{SITE_URL}static/js/admin.js" type="text/javascript"></script>

<style>
em{
	color:red;
}
</style>
<div style="width:100%;">
    <div >
    <ol class="breadcrumb" style="    margin-bottom: 0px;">
  <li><a href="{url admin_main/stat}">后台首页</a></li>
  <li class="active">文章管理</li>
</ol>

</div>

</div>
<div style="padding: 8px 15px;">

<!--{if isset($message)}-->
<table class="table">
    <tr>
        <td class="{if isset($type)}$type{/if}">{$message}</td>
    </tr>
</table>
<!--{/if}-->
   <a class="btn write-btn btn-success" target="_blank" href="{url admin_chajian/addarticle}">
            <i class="fa fa-pencil"></i>写文章
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
    <table class="table">
        <tr class="header" align="center">
            <td width="10%"><input class="checkbox" value="chkall" id="chkall" onclick="checkall('tid[]')" type="checkbox" name="chkall"><label for="chkall">选择</label></td>
            <td  width="10%">文章作者</td>

            <td width="20%">文章标题</td>

             <td  width="10%">阅读量</td>
                <td  width="10%">评论数</td>
            <td  width="10%">编辑</td>
        </tr>



</table>
            <table  id="table1" class="table">
                    <!--{loop $topiclist $topic}-->
                <tr align="center" class="smalltxt">

                    <td width="10%" class="altbg2"><input class="checkbox" type="checkbox" value="{$topic['id']}" name="tid[]"></td>
                                      <td width="10%" class="altbg2">
                                      <strong>{$topic['author']}</strong></td>

                    <td width="20%" class="altbg2"><input name="order[]" type="hidden" value="{$topic['id']}"/><strong><a target="_blank" href="{url topic/getone/$topic['id']}">
                 	{eval $topdata = $this->db->get_where ( 'topdata', array ('typeid' => $topic['id'],'type'=>'topic') )->row_array ();}
						
						
				
                 {if $topdata}<label class="label label-info">置顶</label>{/if}  {if $topic['ispc']==1}<label class="label label-danger">推荐</label>{/if} {if $topic['price']>0}<label class="label label-primary">{$topic['price']}{eval if ($topic['readmode']==2) echo '财富值'; }{eval if ($topic['readmode']==3) echo '元'; }阅读</label>{/if}{if $topic['state']==0}<label class="label label-warning">等待审核</label>{/if}{$topic['title']}
                    </a></strong></td>

                           <td width="10%" class="altbg2" align="center">{$topic['views']}</td>
                                  <td width="10%" class="altbg2" align="center">{$topic['articles']}</td>
                    <td width="10%" class="altbg2" align="center"><a target="_blank" href="{url admin_topic/edit/$topic['id']}">编辑</a></td>
                </tr>
         
      
       
   <!--{/loop}-->
    </table>
   <div class="pages">{$departstr}</div>


             <input name="ctrlcase" class="btn btn-success" type="button" onClick="buttoncontrol(1);" value="推送到百度">&nbsp;&nbsp;&nbsp;
 <input name="ctrlcase" class="btn btn-success" type="button" onClick="buttoncontrol(3);" value="设置推荐/取消推荐">&nbsp;&nbsp;&nbsp;
 <input name="ctrlcase" class="btn btn-success" type="button" onClick="buttoncontrol(4);" value="顶置文章/取消顶置">&nbsp;&nbsp;&nbsp;

    <input class="button" tabindex="3" onClick="buttoncontrol(2)" type="submit" value=" 删除" name="ctrlcase">
</form>
<div class="modal fade" id="baidutui">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
      <h4 class="modal-title">百度推送提醒</h4>
    </div>
    <div class="modal-body">
      <p>确定推送？此项操作只有配置了百度推送api地址有效！</p>
    </div>
    <div class="modal-footer">
     <button type="button" id="btntui" class="btn btn-primary">确定推送</button>
     <button type="button"  class="btn btn-primary" onclick="window.location.href='index.php?admin_setting/seo{$setting['seo_suffix']}'">去配置百度推送api地址</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>

    </div>
  </div>
</div>
</div>
<br>

</div>
<!--{template footer}-->
<script>
function buttoncontrol(num) {

	  if ($("input[name='tid[]']:checked").length == 0) {
          alert('你没有选择任何要操作的文章！');
          return false;
      }else{
    	   switch (num) {
           case 1:
           	$("#baidutui").modal("show");

           	$("#btntui").click(function(){
           		 document.answerlist.action = "index.php?admin_topic/baidutui{$setting['seo_suffix']}";
                   console.log( document.answerlist);
           		 document.answerlist.submit();
           	})

               break;
           case 2:
        	   if (confirm('确定删除问题？该操作不可返回！') == false) {
                   return false;
               } else {
               document.answerlist.action = "index.php?admin_topic/remove{$setting['seo_suffix']}";
               document.answerlist.submit();
               }
               break;
           case 3:
        	   if (confirm('设置推荐将在推荐列表中展示，确定吗？') == false) {
                   return false;
               } else {
               document.answerlist.action = "index.php?admin_topic/recommend{$setting['seo_suffix']}";
               document.answerlist.submit();
               }
               break;
           case 4:
        	   if (confirm('置顶成功后，可在内容管理-顶置内容管理中批量操作。') == false) {
                   return false;
               } else {
               document.answerlist.action = "index.php?admin_topic/settop{$setting['seo_suffix']}";
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