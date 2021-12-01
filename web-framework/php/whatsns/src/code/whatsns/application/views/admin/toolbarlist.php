<!--{template header}-->
<script type="text/javascript">
    function upeditor(){
        window.location="index.php?admin_editor/upeditor{$setting['seo_suffix']}";
    }

    $(document).ready(function() {
        $("#list").sortable({
            update : function () {
                var order="";
                var numValue=$("input[name='id[]']");
                for(var i=0;i<numValue.length;i++){
                    order+=$(numValue[i]).val()+",";
                }
                $.post("index.php?admin_editor/order{$setting['seo_suffix']}",{order:order});
            }
        });
    });
</script>
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
  <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;编辑器设置&nbsp;&raquo;&nbsp;编辑器功能</div>
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
	<tr class="header">
	<td>

		<input type="button" value="全局设置" onclick="document.location.href='index.php?admin_editor/setting{$setting['seo_suffix']}'" style="cursor:pointer">&nbsp;&nbsp;&nbsp;
		编辑器功能
	</td>
	</tr>
</table>
	<table class="table">
		<tr class="header" align="center">
			<td width="20%">标签</td>
			<td  width="50%">简介</td>
			<td  width="30%">状态[操作]</td>
		</tr>
	</table>
	<ul id="list" style="cursor: hand; cursor: pointer;" >
		<!--{loop $toolbarlist $toolbar}-->
		<li style="list-style:none;">
			<table  id="table1" class="table">
				<tr align="center" class="smalltxt">
					<td width="20%" class="altbg1">{$toolbar['tag']}    <input type="hidden" name="id[]" value="{$toolbar['id']}" /></td>
					<td width="30%" class="altbg1" align="center">{$toolbar['description']}</td>
					<td width="25%" class="altbg2" align="center">
						 <!--{if $toolbar['available'] }-->已启用
							<a style="color: green" href="index.php?admin_editor/status/{$toolbar['id']}/0{$setting['seo_suffix']}">[禁用]</a>
						 <!--{else}-->已禁用
							<a style="color: red" href="index.php?admin_editor/status/{$toolbar['id']}/1{$setting['seo_suffix']}">[启用]</a>
						 <!--{/if}-->
					</td>
				</tr>
			</table>
		</li>
		<!--{/loop}-->
	</ul>
<br>
<center><input type="button" class="btn btn-success" name="updatebtn" onclick="upeditor();" value="更新编辑器" ></center><br>
<!--{template footer}-->