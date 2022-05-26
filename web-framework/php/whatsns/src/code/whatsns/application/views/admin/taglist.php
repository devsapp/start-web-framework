<!--{template header}-->

<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div style="float:left;"><a href="{SITE_URL}index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;标签管理</div>
</div>



    <!--{if $departstr}-->

          <div class="pages">{$departstr}</div>

        <!--{/if}-->
       <a class="btn" href="{url admin_tag/muttadd}">批量添加标签</a> <a class="btn" href="{url admin_tag/add}">添加标签</a>       <button class="btn" id="updatetag">标签问题和文章数量同步</button>
        <button class="btn" id="updatedatatag">一键内容同步</button>
<form  method="post" action="{url admin_tag/index}">
    <table class="table">
        <tbody>
           
            <tr class="altbg1"><td colspan="4">可以通过如下搜索条件，检索标签</td></tr>
            <tr>
                <td   class="altbg2">标签名称/标签别名:<input class="txt form-control" style="width: 30%" name="srchtitle" {if isset($srchtitle)}value="{$srchtitle}" {/if}></td>
           
             
            </tr>

            <tr>
              <td  rowspan="2" class="altbg2"><input class="btn btn-info" name="submit" type="submit" value="查询"></td>
              </tr>
        </tbody>
    </table>
</form>
[共 <font color="green">{$rownum}</font> 个标签]
<form onsubmit="return confirm('该操作不可恢复，您确认要删除选中的标签吗？');"  action="index.php?admin_tag/delete{$setting['seo_suffix']}"  method=post>
    <table class="table" >
        <tr class="header"><td colspan="3">标签列表</td></tr>
        <tr class="header" align="center">
            <td ><input class="checkbox" value="chkall" id="chkall" onclick="checkall('delete[]')" type="checkbox" name="chkall"><label for="chkall">&nbsp;操作</label></td>
              <td  >标签图片</td>
            <td  >标签名称</td>
            <td  >标签别名(英文名称或者拼音)</td>
                  <td>标签首字母</td>
             <td  >标签问题数</td>
             <td  >标签文章数</td>
               <td  >操作</td>
        </tr>
        <!--{loop $taglist $tag}-->
        <tr align="center" class="smalltxt">
            <td class="altbg2">&nbsp;
            <input class="checkbox" type="checkbox" id="{$tag['id']}" value="{$tag['id']}" name="delete[]"></td>
           <td  class="">
            {if $tag['tagimage']==""||$tag['tagimage']==null}
                         <img src="{SITE_URL}static/images/defaulticon.jpg" style="width:35px;height:35px;">
                         {else}
                             <img src="{$tag['tagimage']}" style="width:35px;height:35px;">
                         {/if}
           </td>
             <td  class=""><a href="{url tags/view/$tag['tagalias']}" target="_blank">{$tag['tagname']}</a></td>
         
            <td  class=""><a href="{url tags/view/$tag['tagalias']}" target="_blank">{$tag['tagalias']}</a></td>
             <td  class="">{$tag['tagfisrtchar']}</td>
            <td  class="">{$tag['tagquestions']}</td>
             <td  class="">{$tag['tagarticles']}</td>
              <td  class=""><a class="btn" href="{url admin_tag/edit/$tag['tagalias']}">编辑</a></td>
              
                <td  class=""><a class="btn" onclick="updatedata(this,'{$tag['tagalias']}')">同步相关问题和文章</a></td>
        </tr>
        <!--{/loop}-->
      <!--{if $departstr}-->
        <tr class="smalltxt">
            <td class="altbg1" colspan="3" align="right"><div class="pages">{$departstr}</div></td>
        </tr>
        <!--{/if}-->
        <tr><td colspan="3" class="altbg1"><input type="submit" class="btn btn-success" value="删除" /></td></tr>
    </table>
</form>
<script>
var _count={$pagestag};
var _pageindex=0;
var _pagetagnumindex=0;
$("#updatetag").click(function(){
	$("#updatetag").attr("disabled",true); //按钮不可以点击
	   $("#updatetag").val("同步"+(_pagetagnumindex+1)+"页中...");
	   $("#updatetag").html("同步"+(_pagetagnumindex+1)+"页中...");
	updatetag();
})
$("#updatedatatag").click(function(){
	if(confirm("该设置会将标签去检索问答和文章标题和内容，然后同步匹配到的内容，是否确认执行？")){
		$("#updatedatatag").attr("disabled",true); //按钮不可以点击
		   $("#updatedatatag").val("同步"+(_pageindex+1)+"/"+_count+"页中...");
		   $("#updatedatatag").html("同步"+(_pageindex+1)+"/"+_count+"页中...");
		updatedatatag();
	}
	
})
function updatedatatag(){




	var datajson={pageindex:_pageindex};
	var url="{url admin_tag/tongbudatatag}";

	 $.ajax({
         type: "POST",
         url: url,
         data:datajson,
        　             datatype :'json',  
         success:function(data) {
	var data=eval("("+data+")");
     console.log(data.msg)
     if(_pageindex==_count){
     	$("#updatedatatag").removeAttr("disabled");
             $("#updatedatatag").val("更新完成");
             $("#updatedatatag").html("更新完成");
             _pageindex=1;
             return false;
     }else{
     		   $("#updatedatatag").val("同步"+(_pageindex+1)+"/"+_count+"页中...");
		   $("#updatedatatag").html("同步"+(_pageindex+1)+"/"+_count+"页中...");
     	++_pageindex;
     	updatedatatag();
     }
        	 
         }
     });
}
function updatetag(){




	var datajson={pages:_count,pageindex:_pagetagnumindex};
	var url="{url admin_tag/tongbutag}";

	 $.ajax({
         type: "POST",
         url: url,
         data:datajson,
        　  datatype :'json',  
         success:function(data) {
         	var data=eval("("+data+")");
     console.log(data.msg)
      if(_pagetagnumindex==_count){
     	$("#updatetag").removeAttr("disabled");
             $("#updatetag").val("更新完成");
             $("#updatetag").html("更新完成");
             _pageindex=1;
             return false;
     }else{
     		   $("#updatetag").val("同步"+(_pagetagnumindex+1)+"/"+_count+"页中...");
		   $("#updatetag").html("同步"+(_pagetagnumindex+1)+"/"+_count+"页中...");
     	++_pagetagnumindex;
     	updatetag();
     }
     
        
         }
     });
}
function updatedata(_target,_tagalias){
	var datajson={tagalias:_tagalias};
	var url="{url admin_tag/updatedata}";
	$(_target).attr("disabled",true); //按钮不可以点击
	  $(_target).val("同步中...");
	 $.ajax({
         type: "POST",
         url: url,
         data:datajson,
         success:function(data) {
             console.log(data)
               alert(data)
        	 $(_target).removeAttr("disabled");
             $(_target).val("更新完成");
             $(_target).html("更新完成");
        	
         }
     });
}
</script>
<!--{template footer}-->
