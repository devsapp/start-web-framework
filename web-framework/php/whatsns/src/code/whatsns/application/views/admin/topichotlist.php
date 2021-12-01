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


[共 <font color="green">{$rownum}</font> 个定制内容]<a class="btn" target="_blank" style="margin-left: 30px;" href="https://www.ask2.cn/article-15501.html">查看文章推荐设置教程</a>
<form name="answerlist"  method="POST">
    <table class="table">
        <tr class="header" align="center">
            <td width="10%"><input class="checkbox" value="chkall" id="chkall" onclick="checkall('tid[]')" type="checkbox" name="chkall"><label for="chkall">选择</label></td>
            <td  width="20%">标题</td>
<td width="10%">浏览次数</td>
<td width="10%">评论数</td>
<td width="10%">收藏数</td>
            <td width="10%">发布时间</td>

        </tr>



</table>
            <table  id="table1" class="table">

                      <!--{loop $topiclist  $topic}-->
                <tr align="center" class="smalltxt">

                    <td width="10%" class="altbg2"><input class="checkbox" type="checkbox" value="{$topic['id']}" name="tid[]"></td>
                                 
                    
                    <td width="20%" class="altbg2">
                    <a href="{url topic/getone/$topic['id']}">
                       {if $topic['state']==0}<label class="label label-warning">等待审核</label>{/if}{$topic['title']}
                   
                    </a>
           
                    </td>

                           <td width="10%" class="altbg2" align="center">
           {$topic['views']}
                            </td>
                               <td width="10%" class="altbg2" align="center">
           {$topic['articles']}
                            </td>
                               <td width="10%" class="altbg2" align="center">
           {$topic['likes']}
                            </td>
                                   <td width="10%" class="altbg2" align="center">
                                   {$topic['format_time']}
                                    </td>
                    
                </tr>
         
      
       
   <!--{/loop}-->
    </table>
   <div class="pages">{$departstr}</div>


             <input name="ctrlcase" class="btn btn-success" type="button" onClick="buttoncontrol(1);" value="取消推荐">&nbsp;&nbsp;&nbsp;

</form>

<br>

<!--{template footer}-->
<script>
function buttoncontrol(num) {

	  if ($("input[name='tid[]']:checked").length == 0) {
          alert('你没有选择内容！');
          return false;
      }else{
    	   switch (num) {
           case 1:

        		 document.answerlist.action = "index.php?admin_topic/cancelhottopic{$setting['seo_suffix']}";
                 
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