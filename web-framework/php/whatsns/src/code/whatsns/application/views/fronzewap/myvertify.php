<!--{template header}-->
<style>
.myverform{
padding:15px;
}
.myline{
min-height:30px;
    clear: both;
}
.form-group{
clear:both;
}
.text-left {
text-align:left;
}
.jieshaoinfo{
margin:20px auto;
}
#jieshao{
width:100%:
height:50px;
}
.fujianfule {
    position: relative;
    top: -62px;
    opacity: 0;
}
.m_search h3{
 margin:15px 15px 5px 15px;
 padding-bottom:10px;
 font-weight:600;
 border-bottom:solid 1px #ebebeb;
}
.vertify_img {
max-width:100% !important;
}
</style>
 <div class="m_search userspaceheader">

<h3>我的认证</h3>
</div>
<section class="ui-container">

<div class="myverform">

                    <form class="ui-form"  method="POST" id="vertify_form"  >

 <div class="ui-row myline">
          <p class="ui-col ui-col-25 ">当前状态:</p>
          <div class="ui-col ui-col-75">
                  {if !isset($vertify['msg'])}
                    未认证
          {else}
          {$vertify['msg']}
          {/if}
          {if $vertify['status']==2}
          <div style="color:#777"> 驳回原因:{$vertify['shibaiyuanyin']}</div>
          {/if}
          </div>
        </div>
      
         <div class="ui-row myline">
          <p class="ui-col ui-col-25 ">认证类型:</p>
          <div class="ui-col ui-col-75">
          {eval if ($setting['vertify_gerentip']==null||trim($setting['vertify_gerentip'])=='')$setting['vertify_gerentip']='个人';}
                        <span><input type="radio" value="0" {if $vertify['status']==0}disabled{/if}  class="normal_radio vertify_type" name="type" <!--{if isset($vertify['type'])&&(0 == $vertify['type'])}--> checked <!--{/if}-->/>{$setting['vertify_gerentip']} &nbsp;&nbsp;</span>
           {eval if ($setting['vertify_qiyetip']==null||trim($setting['vertify_qiyetip'])=='')$setting['vertify_qiyetip']='企业';}
                        <span><input type="radio" value="1" {if $vertify['status']==0}disabled{/if}  class="normal_radio vertify_type" name="type" <!--{if isset($vertify['type'])&&(1 == $vertify['type'])}--> checked <!--{/if}--> />{$setting['vertify_qiyetip']}</span>
          
          </div>
        </div>
 
   
        <div class="ui-row myline">
          <p class="ui-col ui-col-25 text-left ">真实姓名：</p>
          <div class="ui-col ui-col-75 ui-form-item ui-form-item-pure ui-border-b">

                <input type="text" name="name" id="name" {if $vertify['status']==0}disabled{/if} value="{if isset($vertify['name'])}$vertify['name']{/if}" placeholder="" class="form-control">
          
             <a href="#" class="ui-icon-close"></a>
          </div>
        </div>
 
       <div class="ui-row myline">
          <p class="ui-col ui-col-25 text-left ">身份证号码：</p>
          <div class="ui-col ui-col-75 ui-form-item ui-form-item-pure ui-border-b">

                <input type="text"  name="id_code" id="id_code"  {if $vertify['status']==0}disabled{/if} value="{if isset($vertify['id_code'])}$vertify['id_code']{/if}" placeholder="" class="form-control">
          
             <a href="#" class="ui-icon-close"></a>
          </div>
        </div>



      <div class="ui-row myline jieshaoinfo">
          <p class="text-left ">认证介绍:</p>
          <div class="">
            <textarea name="jieshao" id="jieshao" style="width:100%;height:50px;    border: solid 1px #ebebeb;" {if $vertify['status']==0}disabled{/if}  class="" >{if isset($vertify['jieshao'])}$vertify['jieshao']{/if}</textarea>

    
          </div>
        </div>


         <div class="form-group ">
          <p class="col-md-6 text-left ">附件一(必传,<span style="color:red;">最大3M,jpg,png格式</span>):</p>
          <div class="col-md-12 uploadver">

							<a class="btn btn-mini btn-default" style="margin-top:10px;margin-bottom:10px;">上传附件</a>

							<p class="text-hui" style="font-size: 12px;">请提交对应的身份证图片或者营业执照证件扫描电子版图片</p>
							<input  {if $vertify['status']==0}disabled{/if} name="attach1"  id="upimgfile" accept="image/*" type="file" class="fujianfule  collapse" onchange="uploadvertify(this)">
					  <p class="upimgtip"></p>
					  <img src='{if isset($vertify['zhaopian1'])}{$vertify['zhaopian1']}{eval echo "?rand=".rand(1,1000);}{/if}' id="vertify_img1" class="vertify_img {if isset($vertify['zhaopian1'])&&$vertify['zhaopian1']==''}hide{/if}"/>
          </div>
        </div>
               <div class="form-group">
          <p class="col-md-6 text-left ">附件二(可选,<span style="color:red;">最大3M,jpg,png格式</span>):</p>
          <div class="col-md-12 uploadver">

							<a class="btn btn-mini btn-default"  style="margin-top:10px;margin-bottom:10px;">上传附件</a>

							<p class="text-hui" style="font-size: 12px;">其它证明材料(图片格式)</p>
							<input  {if $vertify['status']==0}disabled{/if} name="attach2" id="upimgfile2" accept="image/*" type="file" class="fujianfule  collapse" onchange="uploadvertify2(this)">
					 <p class="upimgtip2"></p>
					  <img src='{if isset($vertify['zhaopian2'])}{$vertify['zhaopian2']}{eval echo "?rand=".rand(1,1000);}{/if}' id="vertify_img2"  class="vertify_img {if isset($vertify['zhaopian2'])&&$vertify['zhaopian2']==''}hide{/if}"/>
          </div>
        </div>


         {if $vertify['status']!=0}
         <div class="form-group btnuploadver">
          <div class=" col-md-10">
       
      {if $vertify['status']==2}
          <button type="button" id="submit" name="submit" onclick="submitvertify()" class="ui-btn-lg ui-btn-danger" data-loading="稍候...">
          重新提交
          </button>
          {else}
          <button type="button" id="submit" name="submit" onclick="submitvertify()" class="ui-btn-lg ui-btn-danger" data-loading="稍候...">
保存{eval $needpay=intval($setting['vertifyjine']); if ($needpay>0&&$vertify['status']!=1) echo "[付费".$needpay."元]";}
          </button>
          {/if}
          
          </div>
        </div>
        {/if}

 </form>
 </div>
</section>
{if $vertify['status']!=0}
<script>
window.alert=function(msg){
	$.tips({
        content:msg,
        stayTime:2000,
        type:"info"
    });
}
//图片大小验证
function verificationPicFile(file) {
    var fileSize = 0;
    var fileMaxSize = 1024*3;//3M
    var filePath = file.value;
    if(filePath){
        fileSize =file.files[0].size;
        var size = fileSize / 1024;
        if (size > fileMaxSize) {
            alert("文件大小不能大于3M！");
            file.value = "";
            return false;
        }else if (size <= 0) {
            alert("文件大小不能为0M！");
            file.value = "";
            return false;
        }
    }else{
        return false;
    }
    return true;
}
//类型切换
$("#vertify_form .vertify_type").click(function(){
	var _val=$(this).val();
	switch(_val){
	case '0':
		$("#vertify_form .change_name").html("真实姓名：");
		$("#vertify_form .change_idcode").html("身份证号码：");
		break;
	case '1':
		$("#vertify_form .change_name").html("企业名称:");
		$("#vertify_form .change_idcode").html("组织机构代码:");
		break;
	}
})

//提交资料
function submitvertify(){
	//认证类型
	var _type=$.trim($("input[name='type']:checked").val());
	//用户名
	var _name=$.trim($("#vertify_form #name").val());
	//身份证号码
	var _idcode=$.trim($("#vertify_form #id_code").val());
	//认证介绍
	var _jieshao=$.trim($("#vertify_form #jieshao").val());
	//认证附件图片
	var _vertifyimgfile=$.trim($("#vertify_img1").attr("src"));
	switch(_type){
	case '0':
		if(_name==''){
			alert("真实姓名不能为空");
			return false;
		}
		if(_idcode==''){
			alert("身份证号码不能为空");
			return false;
		}
		break;
	case '1':
		if(_name==''){
			alert("企业名称不能为空");
			return false;
		}
		if(_idcode==''){
			alert("组织机构代码证不能为空");
			return false;
		}
		break;
	}
	if(_jieshao==''){
		alert("认证介绍不能为空");
		return false;
	}

	if(_vertifyimgfile==''){
		alert("附件一认证材料不能为空");
		return false;
	}
	//认证附件图片2
	var _vertifyimgfile2=$.trim($("#vertify_img2").attr("src"));

	var data={
			type:_type,
			name:_name,
			idcode:_idcode,
			jieshao:_jieshao,
			zhaopian1:_vertifyimgfile,
			zhaopian2:_vertifyimgfile2
	}
	function success(data){
		alert(data.result);
		if(data.code=='200'){
			setTimeout(function(){
				window.location.reload();
			},1000);

		}
	}
	var _posturl="{url user/ajaxvertify}";
	ajaxpost(_posturl,data,success);
}
function uploadvertify(file){
	
  	 if (file.files && file.files[0])
       {
  		if(!verificationPicFile(file)){
          return false;
  		}
  	     $(".upimgtip").html("图片上传中....");
  		 $("#upimgfile").attr("disabled","disabled");
  		  var type = "wangEditorMobileFile";
  		  var ischeck=0;
  		
  		    var formData = new FormData();
  		    formData.append(type, $("#upimgfile")[0].files[0]);
  		 formData.append("addimg",0);
	
  	  
  		    $.ajax({
  		        type: "POST",
  		        url: '{url attach/upimg}',
  		        data: formData,
  		        processData: false,
  		        contentType: false,
  		        //返回数据的格式
  	            datatype: "text",//"xml", "html", "script", "json", "jsonp", "text".
  	            beforeSend: function () {

  	                ajaxloading("提交中...");
  	             },
  		        success: function (data) {
  		         $("#upimgfile").removeAttr("disabled");
  		     if(data.indexOf('error')==0){
  		    	
              alert(data.replace('error|',''));
              return false;
  		     }else{
  		    	$("#vertify_img1").attr("src",data).removeClass("hide");
  		     }
  		         
  		        
  		          
  		        },
  	             complete: function () {
  	            	 $(".upimgtip").html("");
  	            	 $("#upimgfile").removeAttr("disabled");
  	                 removeajaxloading();
  	              },
  	             //调用出错执行的函数
  	             error: function(){
  	              removeajaxloading();
  	            	 $("#upimgfile").removeAttr("disabled");
  	                 //请求出错处理
  	            	 alert("上传出错");
  	             }
  		    });
       }
  }
function uploadvertify2(file){

	 if (file.files && file.files[0])
  {
			if(!verificationPicFile(file)){
		          return false;
		  		}
	     $(".upimgtip2").html("图片上传中....");
		 $("#upimgfile2").attr("disabled","disabled");
		  var type = "wangEditorMobileFile";
		  var ischeck=0;
		
		    var formData = new FormData();
		    formData.append(type, $("#upimgfile2")[0].files[0]);
		 formData.append("addimg",0);

	  
		    $.ajax({
		        type: "POST",
		        url: '{url attach/upimg}',
		        data: formData,
		        processData: false,
		        contentType: false,
		        //返回数据的格式
	            datatype: "text",//"xml", "html", "script", "json", "jsonp", "text".
	            beforeSend: function () {

	                ajaxloading("提交中...");
	             },
		        success: function (data) {
		         $("#upimgfile2").removeAttr("disabled");
		     if(data.indexOf('error')==0){
		    	
         alert(data.replace('error|',''));
         return false;
		     }else{
		    	$("#vertify_img2").attr("src",data).removeClass("hide");
		     }
		         
		        
		          
		        },
	             complete: function () {
	            	 $(".upimgtip2").html("");
	            	 $("#upimgfile2").removeAttr("disabled");
	                 removeajaxloading();
	              },
	             //调用出错执行的函数
	             error: function(){
	              removeajaxloading();
	            	 $("#upimgfile2").removeAttr("disabled");
	                 //请求出错处理
	            	 alert("上传出错");
	             }
		    });
  }
}

</script>
{/if}
<div class="modal fade" id="myLgModal">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div id="dialogcate">
        <form name="editcategoryForm" action="{url question/movecategory}" method="post">
            <input type="hidden" name="qid" value="{if isset($question['id'])}$question['id']{/if}" />
            <input type="hidden" name="category" id="categoryid" />
            <input type="hidden" name="selectcid1" id="selectcid1" value="{if isset($question['cid1'])}$question['cid1']{/if}" />
            <input type="hidden" name="selectcid2" id="selectcid2" value="{if isset($question['cid2'])}$question['cid2']{/if}" />
            <input type="hidden" name="selectcid3" id="selectcid3" value="{if isset($question['cid3'])}$question['cid3']{/if}" />
            <table class="table table-striped">
                <tr valign="top">
                    <td width="125px">
                        <select  id="category1" class="catselect" size="8" name="category1" ></select>
                    </td>
                    <td align="center" valign="middle" width="25px"><div style="display: none;" id="jiantou1">>></div></td>
                    <td width="125px">
                        <select  id="category2"  class="catselect" size="8" name="category2" ></select>
                    </td>
                    <td align="center" valign="middle" width="25px"><div style="display: none;" id="jiantou2">>>&nbsp;</div></td>
                    <td width="125px">
                        <select id="category3"  class="catselect" size="8"  name="category3" ></select>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                    <span>
                    <input  type="button" class="btn btn-success" value="确&nbsp;认" onclick="add_category();"/></span>
                    <span>
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    </span>
                    </td>

                </tr>
                 <tr>
                    <td colspan="5">
                     <ul class="taglist tag">

                     </ul>
                    </td>

                </tr>
            </table>
        </form>
    </div>
    </div>
  </div>
</div>
<!--用户中心结束-->
{if $vertify['status']!=1}
<script type="text/javascript">
var catsetnum={$setting['cansetcatnum']};

$(".taglist").html($("#cate_view").html());


</script>
{/if}
<!--{template footer}-->