<!--{template header}-->
<script type="text/javascript" src="{SITE_URL}static/js/jquery-ui/jquery-ui.js"></script>
<script src="{SITE_URL}static/js/admin.js" type="text/javascript"></script>

<style>
em{
	color:red;
}
</style>
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;专题管理</div>
</div>
<!--{if isset($message)}-->
<table class="table">
    <tr>
        <td class="{if isset($type)}$type{/if}">{$message}</td>
    </tr>
</table>
<!--{/if}-->



[共 <font color="green">{$rownum}</font> 个定制内容]<a class="btn" target="_blank" style="margin-left: 30px;" href="https://www.ask2.cn/article-15500.html">查看内容顶置教程</a>
<form name="answerlist"  method="POST">
    <table class="table">
        <tr class="header" align="center">
            <td width="10%"><input class="checkbox" value="chkall" id="chkall" onclick="checkall('tid[]')" type="checkbox" name="chkall"><label for="chkall">选择</label></td>
             <td  width="10%">排序</td>
            <td  width="20%">顶置标题</td>
<td width="10%">顶置类型</td>
            <td width="10%">顶置时间</td>

        </tr>



</table>
            <table  id="table1" class="table">

                      <!--{loop $topicdatalist  $topdata}-->
                <tr align="center" class="smalltxt">

                    <td width="10%" class="altbg2"><input class="checkbox" type="checkbox" value="{$topdata['id']}" name="tid[]"></td>
                                      <td width="10%" class="altbg2">
                                      <strong></strong></td>
                    <td class="" width="10%"><input name="corder{$topdata['id']}" type="text" value="{$topdata['order']}"/></td>
                    <td width="20%" class="altbg2">
                    <a class="title" target="_self"  href="{$topdata['url']}">{$topdata['title']}</a>
                    </td>

                           <td width="10%" class="altbg2" align="center">
                               {if $topdata['type']=='topic'}
               文章

            {/if}
              {if $topdata['type']=='note'}
                公告

            {/if}
            {if $topdata['type']=='qid'}
                问题

            {/if}
                            </td>
                                   <td width="10%" class="altbg2" align="center">
                                   {$topdata['format_time']}
                                    </td>
                    
                </tr>
         
      
       
   <!--{/loop}-->
    </table>
   <div class="pages">{$departstr}</div>


             <input name="ctrlcase" class="btn btn-success" type="button" onClick="buttoncontrol(1);" value="取消顶置">&nbsp;&nbsp;&nbsp;
 <input name="ctrlcase" class="btn btn-success" type="button" onClick="buttoncontrol(2);" value="更新排序">&nbsp;&nbsp;&nbsp;

</form>

<br>

<!--{template footer}-->
<script>
function buttoncontrol(num) {

	  if ($("input[name='tid[]']:checked").length == 0) {
          alert('你没有选择顶置内容！');
          return false;
      }else{
    	   switch (num) {
           case 1:

        		 document.answerlist.action = "index.php?admin_topic/canceltopdata{$setting['seo_suffix']}";
                 
           		 document.answerlist.submit();
               break;
           case 2:
        
               document.answerlist.action = "index.php?admin_topic/reordertopdata{$setting['seo_suffix']}";
               document.answerlist.submit();
             
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