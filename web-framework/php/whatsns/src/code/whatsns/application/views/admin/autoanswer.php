<!--{template header}-->

<style>
body,.wrapper{
	overflow:visible;
}
.automain{
{if !is_mobile()}
	width:60%;
 {else}
	width:100%;
{/if}
}
.clearfix, .clear {
    clear: none;
}
.auto_pannel_box{
  {if !is_mobile()}
	width:20%;
	position:fixed;
  {else}
	width:100%;
	{/if}
    min-height:400px;

right:0px;
top:120px;
background:#fff;
	padding:20px;
}

.form-group,.col-md-12 {
	padding:0px;
margin:0px;
}
.btn-category{
	width:100%;
hegiht:70px;
line-hegiht:70px;
text-align:center;
    background:#777;
    color:#fff;
    border-radius: 3px;
    -webkit-box-shadow: none;
    box-shadow: none;
    border: 1px solid transparent;
display:block;
margin:10px auto;
}
.auto-item{
	margin:10px auto;
}
</style>

<!--引入wangEditor.css-->
<link rel="stylesheet" type="text/css" href="{SITE_URL}static/js/wangeditor/pcwangeditor/css/wangEditor.min.css">



<!--引入jquery和wangEditor.js-->   <!--注意：javascript必须放在body最后，否则可能会出现问题-->

<script type="text/javascript" src="{SITE_URL}static/js/wangeditor/pcwangeditor/js/wangEditor.js"></script>
<div class="alert alert-warning">
自问自答，官网特别奉献，提问和回答用户来自马甲，请先去用户管理设置马甲用户或者添加马甲用户
</div>
{if 1==$setting['recharge_open'] }
<div class="alert alert-success">马甲用户自问自答插件里不参与资金结算,所以不要问设置最佳答案的马甲为什么看不到对账流水记录</div>
{/if}
<div class="automain">
<form>
<div class="form-group has-success">
  <label for="inputSuccess1">问题标题</label>
  <textarea placeholder="最长1000字" id="q_title"  class="form-control"></textarea>

  <div class="help-block"></div>
</div>
<div class="form-group has-success">
  <label for="inputSuccess1">问题描述</label>
  <textarea  id="q_describtion" name="q_describtion"  style="width:100%;height:300px;">

            </textarea>
<script type="text/javascript">


var isueditor=0;
	// 初始化编辑器的内容
	  var miaosueditor = new wangEditor('q_describtion');
	// 自定义配置
		miaosueditor.config.uploadImgUrl = g_site_url+"index.php?attach/upimg" ;
		miaosueditor.config.uploadImgFileName = 'wangEditorMobileFile';
		// 阻止输出log
	    miaosueditor.config.printLog = false;
		  // 普通的自定义菜单
	  miaosueditor.config.menus = [

{$setting['editor_wtoolbars']}
	     ];
	    // 将全屏时z-index修改为20000
	   // editor.config.zindex =-1;
   miaosueditor.create();


</script>
  <div class="help-block"></div>
</div>
<div class="form-group has-success">
  <label for="inputSuccess1">最佳答案</label>
  <textarea  id="q_best_answer" name="q_best_answer"  style="width:100%;height:300px;">

            </textarea>
<script type="text/javascript">


var isueditor=0;
	// 初始化编辑器的内容
	  var besteditor = new wangEditor('q_best_answer');
	// 自定义配置
		besteditor.config.uploadImgUrl = g_site_url+"index.php?attach/upimg" ;
		besteditor.config.uploadImgFileName = 'wangEditorMobileFile';
		// 阻止输出log
	    besteditor.config.printLog = false;
		  // 普通的自定义菜单
	   besteditor.config.menus = [

{$setting['editor_wtoolbars']}
	     ];
	    // 将全屏时z-index修改为20000
	   // editor.config.zindex =-1;
    besteditor.create();


</script>
  <div class="help-block"></div>
</div>


</form>

</div>
 <div class="auto_pannel_box">
    <div class="form-group">
            <div class="col-md-12 ">

            <span id="selectedcate" class="selectedcate label"></span>
                        <span><div class="btn-category" data-toggle="modal" data-target="#myLgModal" id="changecategory" href="javascript:void(0)">选择分类</div>
          </div>

        </div>
<div class="auto-item">
<p>提问时间：</p>
  <input type="text" class="form-control date form-date" id="q_asnwertime" placeholder="请选择" readonly data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
</div>
 <div class="auto-item">
<p>回答时间：</p>
  <input type="text" class="form-control date form-date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd" id="q_bestasnwertime" placeholder="请选择" readonly>
</div>
 <div class="auto-item">
<p>浏览数：</p>
  <input type="number" class="form-control" id="q_views" value="20">
</div>

 <div class="auto-item" {if 0==$setting['recharge_open'] }style="display:none"{/if}  >
<p>问题悬赏金额：<br><b>0表示不设置赏金</b></p>
  <input type="number" class="form-control" id="shangjin" value="0">
</div>

 <div class="auto-item" {if 0==$setting['recharge_open'] }style="display:none"{/if}  >
<p>付费查看回答金额：<br><b>0表示免费查看答案</b></p>
  <input type="number" class="form-control" id="price" value="0">
</div>

 <input type="button" id="submit" name="submit" onclick="submitcaiji()" class="btn btn-success btn-block" value="保存" data-loading="稍候...">
  <input type="hidden" name="cid" id="cid"/>
                    <input type="hidden" name="cid1" id="cid1" value="0"/>
                    <input type="hidden" name="cid2" id="cid2" value="0"/>
                    <input type="hidden" name="cid3" id="cid3" value="0"/>
</div>
 <div class="modal fade" id="myLgModal">
  <div class="modal-dialog modal-md">
    <div class="modal-content">

     <div id="dialogcate">
        <table class="table ">
            <tr valign="top">
                <td width="125px">
                    <select  id="category1" class="catselect" size="8" name="category1" ></select>
                </td>
                <td align="center" valign="middle" width="25px"><div style="display: none;" id="jiantou1">>></div></td>
                <td width="125px">
                    <select  id="category2"  class="catselect" size="8" name="category2" style="display:none"></select>
                </td>
                <td align="center" valign="middle" width="25px"><div style="display: none;" id="jiantou2">>>&nbsp;</div></td>
                <td width="125px">
                    <select id="category3"  class="catselect" size="8"  name="category3" style="display:none"></select>
                </td>
            </tr>
            <tr>
                <td colspan="5">
                <span>
                    <input  type="button" class="btn btn-success" value="确&nbsp;认" onclick="selectcate();"/></span>
                    <span>
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    </span>

                </td>
            </tr>
        </table>
    </div>

    </div>

    </div>

    </div>
        <link href="{SITE_URL}static/css/dist/lib/datetimepicker/datetimepicker.min.css" rel="stylesheet">
  <script src="{SITE_URL}static/css/dist/lib/datetimepicker/datetimepicker.min.js"></script>
<script>
$(".wangEditor-txt").css("height","200px");
function submitcaiji(){
	var _title=$.trim($("#q_title").val());
	var _views=$.trim($("#q_views").val());
	var _price=$.trim($("#price").val());
	if(_price<0){
		alert("付费查看价格不能小于0!");
		$("#price").val("0")
		return false;
	}
	var _shangjin=$.trim($("#shangjin").val());
	if(_shangjin<0){
		alert("悬赏金额不能小于0!");
		$("#shangjin").val("0")
		return false;
	}
var best_eidtor_content =  besteditor.wang_txt.html();

var miaosu_eidtor_content = $.trim( miaosueditor.wang_txt.html());

if(_title==''){
	alert("标题不能为空!");

	return false;
}

if(_title.length>1000){

	alert("标题最长不能超过1000字");
	return false;
}
if(_views==''){
	alert("浏览数不能为空!");
	return false;
}
if ($("#selectedcate").html() == '') {

    $('#myLgModal').modal('show');
            return false;
    }
    var _qtime=$("#q_asnwertime").val();
    var _qbesttime=$("#q_bestasnwertime").val();
    if(_qtime==''){
    	alert("提问时间不能为空!");
    	return false;
    }
    if($.trim($("#q_best_answer").val())!=''){
    	 if(_qbesttime==''){
    	    	alert("回答时间不能为空!");
    	    	return false;
    	    }

    }
	var data={
			  submit:'ok',
			  title:_title,
			  qtime:_qtime,
			  qbesttime:_qbesttime,
			  views:_views,
			  price:_price,
			  shangjin:_shangjin,
			  q_best_eidtor_content:best_eidtor_content,
			  q_miaosu_eidtor_content:miaosu_eidtor_content,
			  cid:$("#cid").val(),
			  cid1:$("#cid1").val(),
			  cid2:$("#cid2").val(),
			  cid3:$("#cid3").val()
		}

	var posturl="{SITE_URL}index.php?admin_chajian/postanswer{$setting['seo_suffix']}";
	function success(result){
		console.log(result)
		if(result.msg='ok'){
			$("#q_title").val("")
			besteditor.wang_txt.html("")
			miaosueditor.wang_txt.html("")
			alert("提交成功");
		}else{
			alert(result.msg);
		}
		console.log(result)
	}
	ajaxpost(posturl,data,success);

}
$(".form-date").datetimepicker(
	    {
	    	weekStart: 1,
	        todayBtn:  1,
	        autoclose: 1,
	        todayHighlight: 1,
	        startView: 2,
	        forceParse: 0,
	        showMeridian: 1,
	        format: "yyyy-mm-dd hh:ii"
	    });
</script>
<script type="text/javascript">
window.onload=function(){
	$("#askform .title ").focus();
}
	var category1 = {$categoryjs[category1]};
    var category2 = {$categoryjs[category2]};
    var category3 = {$categoryjs[category3]};
        $(document).ready(function() {

      //  initcategory(category1);
            initcategory(category1);
            fillcategory(category2, $("#category1 option:selected").val(), "category2");
            fillcategory(category3, $("#category2 option:selected").val(), "category3");
    });




    function selectcate() {
        var selectedcatestr = '';
        var category1 = $("#category1 option:selected").val();
        var category2 = $("#category2 option:selected").val();
        var category3 = $("#category3 option:selected").val();
        if (category1 > 0) {
            selectedcatestr = $("#category1 option:selected").html();
            $("#cid").val(category1);
            $("#cid1").val(category1);
            $("#cid2").val("0");
        }
        if (category2 > 0) {
            selectedcatestr += " > " + $("#category2 option:selected").html();
            $("#cid").val(category2);
            $("#cid2").val(category2);
            $("#cid3").val("0");
        }
        if (category3 > 0) {
            selectedcatestr += " > " + $("#category3 option:selected").html();
            $("#cid").val(category3);
            $("#cid3").val(category3);
        }
        console.log("cid="+$("#cid").val()+"--cid1="+ $("#cid1").val()+"--cid2="+ $("#cid2").val()+"--cid3="+ $("#cid3").val())
        $("#selectedcate").html(selectedcatestr);
        $("#changecategory").html("更改分类");
        $('#myLgModal').modal('hide');
    }



</script>
 <script src="{SITE_URL}static/css/bianping/js/common.js"></script>
<!--{template footer}-->