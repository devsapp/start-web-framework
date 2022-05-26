<!--{template header}-->

<script src="{SITE_URL}static/js/common.js" type="text/javascript"></script>
<div
	style="width: 100%; height: 15px; color: #000; margin: 0px 0px 10px;">
<div style="float: left;"><a
	href="{SITE_URL}index.php?admin_main/stat{$setting['seo_suffix']}"
	target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;专家管理</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<table class="table">
	<tr>
		<td class="{$type}">{$message}</td>
	</tr>
</table>
<!--{/if}-->
<form action="index.php?admin_expert/add{$setting['seo_suffix']}"
	method="post" onsubmit="return checkform(this);">
<table class="table">
	<tbody>
		<tr class="header">
			<td colspan="3">专家管理</td>
		</tr>
		<tr class="altbg1">
			<td colspan="3" class="text-danger ">1、用户名必须是系统已注册用户。2、分类为系统已添加分类，多个分类用,隔开,最多不超过3个</td>
		</tr>
		<tr>
			<td width="30%">用户名:<input
				class="form-control shortinput inline" type="text" name="username" /></td>
			<td width="40%">擅长分类ID:<input
				class="form-control shortinput inline" type="text"
				name="goodatcategory" id="categorys" size="50"
				onfocus="showselect()" /></td>
			<td width="30%"><input class="button" type="submit" value="提 交"></td>
		</tr>
	</tbody>
</table>
</form>
<form action="index.php?admin_expert/remove{$setting['seo_suffix']}"
	method="post">
<table class="table">
	<tr class="header">
		<td><input class="checkbox" value="chkall" id="chkall"
			onclick="checkall('delete[]')" type="checkbox" name="chkall"><label
			for="chkall">删除</label></td>
		<td>用户名</td>
		<td>对Ta提问金额</td>
		<td>擅长分类</td>
		<td>编辑</td>
	</tr>
	<!--{loop $expertlist $expert}-->
	<tr>
		<td class="altbg2"><input class="checkbox" type="checkbox"
			value="{$expert['uid']}" name="delete[]"></td>
		<td class="altbg2"><strong>{$expert['username']}</strong></td>
		<td class="altbg2"><strong>{$expert['mypay']}元</strong></td>
		<td class="altbg2"><!--{loop $expert['category'] $category}-->
		{if $category['categoryname']!=''}<span><a
			href="{url category/view/$category['cid']}" class="label"
			target="_blank">{$category['categoryname']}</a>&nbsp;&nbsp;<i
			onclick="delcat({$category['cid']},{$expert['uid']},this)"
			class="fa fa-times hand delcat"></i></span>{/if}<!--{/loop}--></td>
		<td class="altbg2" onclick="showeditbox({$expert['uid']})"><a
			class="btn btn-primary">编辑</a></td>
	</tr>
	<!--{/loop}-->
	<!--{if $departstr}-->
	<tr class="smalltxt">
		<td class="altbg2" colspan="3">
		<div class="scott">{$departstr}</div>
		</td>
	</tr>
	<!--{/if}-->
	<tr class="altbg1">
		<td colspan="3" class="altbg1" align="left"><input type="submit"
			name="submit" class="btn btn-info" value="提&nbsp;交" /></td>
	</tr>
</table>
</form>

<div class="modal fade" id="catedialog" style="z-index: 999999999;">
<div class="modal-dialog modal-md">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal"><span
	aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
<h4 class="modal-title">选择分类</h4>
</div>
<div class="modal-content">
<div id="dialogcate">


<table class="table table-striped">
	<tr valign="top">
		<td width="125px"><select id="category1" class="catselect"
			size="8" name="category1"></select></td>
		<td align="center" valign="middle" width="25px">
		<div style="display: none;" id="jiantou1">>></div>
		</td>
		<td width="125px"><select id="category2" class="catselect"
			size="8" name="category2"></select></td>
		<td align="center" valign="middle" width="25px">
		<div style="display: none;" id="jiantou2">>>&nbsp;</div>
		</td>
		<td width="125px"><select id="category3" class="catselect"
			size="8" name="category3"></select></td>
	</tr>
	<tr>
		<td colspan="5"><span> <input type="button"
			class="btn btn-info" value="确&nbsp;认" onclick="add_category();" /></span></td>

	</tr>
	<tr>
		<td colspan="5">
		<div>
		<p>已选分类</p>
		<ul id="select_category"></ul>
		<input type="button" class="btn btn-info" value="确认添加"
			onclick="save_change();" /></div>
		</td>

	</tr>
</table>

</div>
</div>
</div>
</div>
<div class="modal fade" id="catseclect">
<div class="modal-dialog modal-md">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal"><span
	aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
<h4 class="modal-title">编辑行家</h4>
</div>
<div class="modal-content">
<form action="index.php?admin_expert/update{$setting['seo_suffix']}"
	method="post"><input type="hidden" value="" readonly id="myuid"
	name="myuid"> <input type="hidden" value="" readonly id="mycid"
	name="mycid">
<table class="table">
	<tr class="header">
		<td colspan="2">参数设置</td>
	</tr>
	<tr>
		<td class="altbg1" width="45%"><b>用户名:</b><br>
		<span class="smalltxt">专家用户名</span></td>
		<td class="altbg2"><input type="text" value="" readonly
			id="username"></td>
	</tr>

	<tr>
		<td class="altbg1" width="45%"><b>行家分类:</b><br>
		<span class="smalltxt">行家擅长分类</span></td>
		<td class="altbg2"><input class="form-control shortinput inline"
			type="text" id="selctcat" size="50" onfocus="showeditselect()" /></td>
	</tr>

</table>
<center>
<button class="btn btn-success">更新</button>
</center>
<br>



</form>
</div>
</div>
</div>
<br>
<div id="ulid" style="display: none"></div>
<script type="text/javascript">
function showeditbox(_uid) {
	var data={uid:_uid}
	var _url='{url admin_expert/selectexpert}';
	function success(result){
		editmode='edit';
		var catstr='';
		var catcid='';
		 for(var i=0;i<result.category.length;i++){
			 if(result.category[i]['categoryname']!=null){
				 catstr+=result.category[i]['categoryname']+",";
			 }
			if(result.category[i]['cid']!=null){
				catcid+=result.category[i]['cid']+",";
			}

		 }
		 catstr=catstr.substring(0,catstr.length-1);
		 if(catstr!='')
		 $("#selctcat").val(catstr);
		 catcid=catcid.substring(0,catcid.length-1);
		 if(catcid!='')
		 $("#mycid").val(catcid);
		$("#myuid").val(result.uid);
		$("#username").val(result.username);
		$("#catseclect").modal("show");
	}
	ajaxpost(_url,data,success);

}
function delcat(_cid,_uid,_this){
	if(confirm('是否真的删除该专家分类')){
		var data={cid:_cid,uid:_uid};
		var _url='{url admin_expert/delcid}';
		function success(result){

			if(result.code==200){
				alert('删除成功');
				$(_this).parent().remove();
			}
		}
		ajaxpost(_url,data,success);
	}

}
    var category1 = {$categoryjs[category1]};
    var category2 = {$categoryjs[category2]};
    var category3 = {$categoryjs[category3]};
    $(document).ready(function() {
        init_category1(category1);
        fill_sub_category(category2, $("#category1 option:selected").val(), "category2");
        //分类选择
        $("#category1").change(function() {
            fillcategory(category2, $("#category1 option:selected").val(), "category2");
            $("#jiantou1").show();
            $("#category2").show();
        });
        $("#category2").change(function() {
            fillcategory(category3, $("#category2 option:selected").val(), "category3");
            $("#jiantou2").show();
            $("#category3").show();
        });
    });
    function init_category1(category1) {
        var selectedcid1 = $("#selectcid1").val();
        $("#category1").append("<option value='0'>根分类</option>");
        for (var i = 0; i < category1.length; i++) {
            var selected = '';
            if (selectedcid1 === category1[i][0]) {
                selected = ' selected';
            }
            $("#category1").append("<option value='" + category1[i][0] + "' " + selected + ">" + category1[i][1] + "</option>");
        }
    }
    function fill_sub_category(category2, value1, cateid) {
        var optionhtml = '<option value="0">父分类</option>';
        var selectedcid = 0;
        if (cateid === "category2") {
            selectedcid = $("#selectcid2").val();
        } else if (cateid === "category3") {
            selectedcid = $("#selectcid3").val();
        }
        for (var i = 0; i < category2.length; i++) {
            if (value1 === category2[i][0]) {
                var selected = '';
                if (selectedcid === category2[i][1]) {
                    selected = ' selected';
                    $("#" + cateid).show();
                }
                optionhtml += "<option value='" + category2[i][1] + "' " + selected + ">" + category2[i][2] + "</option>";
            }
        }
        $("#" + cateid).html(optionhtml);
    }
    function checkform(form) {
        var username = form.username.value;
        var goodatcate = form.goodatcategory.value;
        if (username == '' || goodatcate == '') {
            alert("用户名或分类不能为空");
            return false;
        }
        return true;
    }
    var editmode='add';
    function showselect() {
    	editmode='add';
        $("#catedialog").modal("show");
    }
    function showeditselect() {
    	editmode='edit';
        $("#catedialog").modal("show");
    }
    function add_category() {
        var current = null;
        var select_category1 = $("#category1 option:selected");
        var select_category2 = $("#category2 option:selected");
        var select_category3 = $("#category3 option:selected");
        if(select_category3.val()){
            current = select_category3
        }else if(select_category2.val()){
            current = select_category2
        }else if(select_category1.val()){
            current = select_category1;
        }
        if(!current){
            alert("您还未选择任何分类!");
            return false;
        }
        $("#select_category").append('<li id="'+current.val()+'" cname="'+current.html()+'" style="list-style-type: none;">'+current.html()+'   <a href="javascript:void(0)" onclick="remove_category('+current.val()+')">删除</a></li>');
    }
    function remove_category(cid) {
        $("#"+cid).remove();
    }

    function save_change(){
        var categoryids = "";
        var qcategoryids = "";
        var qcategorynames = "";
        $("#select_category li").each(function(){
            categoryids+=" "+$(this).attr("id");
            qcategorynames+=$(this).attr("cname")+",";
            qcategoryids+=$(this).attr("id")+",";
        });
        if(editmode=='add'){
        	$("#categorys").val(categoryids);
        }

        if(editmode=='edit'){
        	qcategorynames=qcategorynames.substring(0,qcategorynames.length-1);
        	if($("#selctcat").val().length>0){
        		 $("#selctcat").val($("#selctcat").val()+","+qcategorynames);
        	}else{
        		 $("#selctcat").val($("#selctcat").val()+qcategorynames);
        	}
       	 qcategoryids=qcategoryids.substring(0,qcategoryids.length-1);
    		if($("#mycid").val().length>0){
    			$("#mycid").val( $("#mycid").val()+","+qcategoryids);
    		}else{
    			 $("#mycid").val( $("#mycid").val()+qcategoryids);
    		}



        }
        $("#catedialog").modal("hide");
    }
</script>
<!--{template footer}-->


