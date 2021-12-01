<!--{template header}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;添加分类</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<div class="alert  alert-warning">{$message}</div>
<!--{/if}-->
<form name="askform" action="index.php?admin_category/add{$setting['seo_suffix']}" method="post">
    <input type="hidden" name="selectcid1" id="selectcid1" value="{if isset($category1)}$category1{/if}" />
    <input type="hidden" name="selectcid2" id="selectcid2" value="{if isset($category2)}$category2{/if}" />
    <table  class="table table-striped">
        <tr class="header">
            <td colspan="2">根分类设置</td>
        </tr>
        <tr>
        <td class="altbg1" width="45%"><b>上一级分类:</b><br><span class="smalltxt">选择上级分类</span></td>
        <td class="altbg1">
            <table cellspacing="0" cellpadding="0" border="0" width="300px">
                <tr valign="top">
                    <td width="125px">
                        <select  id="category1" class="catselect" size="8" name="category1" ></select>
                    </td>
                    <td align="center" valign="middle" width="25px"><div style="display: none;" id="jiantou1">>></div></td>
                    <td width="125px">
                        <select  id="category2"  class="catselect" size="8" name="category2" style="display:none"></select>
                    </td>
                </tr>
            </table>
        </td>
        </tr>
        <tr>
            <td class="altbg1"><b>分类名:</b><br><span class="smalltxt">可以输入多个分类名，每个分类名独占一行。
            <br />例如： <br>生活<br>电脑<br>社会民生<br></span></td>
            <td class="altbg2" colspan="2"><textarea class="area" name="categorys" id="categorys" style="height:250px;width:220px;" ></textarea></td>
        </tr>
    </table>
    <input type="hidden" value="0" name="cid">

    <center><input type="button" class="button" id="tijiao" name="submit" value="提 交"></center><br>
</form>
<br />

  <script src='{SITE_URL}static/js/common.js' language='javascript'></script>
<script type="text/javascript">
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
	$("#tijiao").click(function(){

		 var myurl=g_site_url+"index.php?admin_category/postadd{$setting['seo_suffix']}";
		var _v=$("#categorys").val();
		if(_v==''){
			alert("分类不能为空!");
			return false;
		}
		$.ajax({
		       type: "post",
		        url: myurl,
		        data:{'submit':'1' ,'categorys':_v,'category1': $("#category1 option:selected").val(),'category2': $("#category2 option:selected").val()},
		        dataType: "text",
        success: function (data) {

       if(data==1){
    	   window.location.href="index.php?admin_category/default{$setting['seo_suffix']}"
       }else{
    	   alert("创建分类失败!");
       }



        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
               alert(errorThrown);
      }
});
	});

</script>
<!--{template footer}-->