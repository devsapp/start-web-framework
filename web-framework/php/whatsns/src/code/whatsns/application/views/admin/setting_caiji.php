<!--{template header}-->

<style>

.functionclass{
	width:100%;
	list-style:none;
padding:0px;
}
.functionclass>li{
	padding:0px;
    margin-top:3px;
    cursor:pointer;
}
html,body{
	overflow:scroll;
}
</style>
<script type="text/javascript" src="{SITE_URL}static/js/jquery-ui/jquery-ui.js"></script>
  <script src='{SITE_URL}static/js/common.js' language='javascript'></script>
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;数据采集设置</div>
</div>

<form >
<table>
<tr>
<td valign="top">
<span style="color:red">常见问答列表(点击列表项采集)</span>

<nav class="menu" data-toggle="menu" style="width: 200px">
<ul class="nav nav-primary" id="xmllist">

       {$ul_li}
        </ul>
</nav>
</td>
<td>

<table class="table">
        <tr class="header">
            <td colspan="2">采集设置<span id="tipsurl"></span>&nbsp;&nbsp;<span style="color:red">ask2问答官网采集教程(<a target="_blank" href="http://www.ask2.cn/article-39.html">http://www.ask2.cn</a></span>)</td>
        </tr>
         <tr>
            <td class="altbg1" width="45%"><b>网页编码:</b><br>一般不需要变，如果出现乱码就切换编码格式</td>
            <td class="altbg2">
              <select name="bianma" id="bianma">
               <option value ="utf-8" >utf-8</option>
  <option value ="gb2312">gb2312</option>


</select>
            </td>
        </tr>
         <tr>
            <td class="altbg1" width="45%"><b>提问时间设置(单位:时):</b><br>默认提问为9小时内</td>
            <td class="altbg2">
              <select name="tiwenshijian" id="tiwenshijian">
              <option value="1">1</option>
   <option value="2">2</option>
     <option value="3">3</option>
       <option value="4">4</option>
         <option value="5">5</option>
           <option value="6">6</option>
             <option value="7">7</option>
               <option value="8">8</option>
                 <option value="9">9</option>
                   <option value="10">10</option>
                     <option value="11">11</option>
                       <option value="12">12</option>

</select>
            </td>
        </tr>
             <tr>
            <td class="altbg1" width="45%"><b>回答时间设置(单位:分钟):</b><br>默认提问为10分钟内容</td>
            <td class="altbg2">
              <select name="huidashijian" id="huidashijian">

   <option value="20">20</option>
     <option value="30">30</option>
       <option value="40">40</option>
         <option value="50">50</option>
           <option value="60">60</option>


</select>
            </td>
        </tr>
         <tr>
            <td class="altbg1" width="45%"><b>随机分类:</b><br>随机采集到系统分类里，这个适合不需要精准分类的网站,<span style="color:red;font-weight:bold;">分类id用英文逗号隔开</span></td>
            <td class="altbg2">
              <input type="text"  id="caiji_randclass" class="form-control short-input" value="" name="caiji_randclass" style="width:300px" />填写此项后单个分类采集将会失效
            </td>
        </tr>
         <tr>
            <td class="altbg1" width="45%"><b>采集分类:</b></td>
            <td class="altbg2">
               <div id="dialogcate1">

                    <select  id="category1"  size="8" name="category1" ></select>

                    <select  id="category2"   size="8" name="category2" style="display:none"></select>

                    <select id="category3"  size="8"  name="category3" style="display:none"></select>



    </div>

            </td>
        </tr>


        <tr>
            <td class="altbg1" width="45%"><b>输入采集网址:</b>

            <br>如采集的分页是：http://wenda.so.com/c/35?pn=2，后边分页的2则你将“2”页码换成{#num},最后显示
            http://wenda.so.com/c/35?pn={#num}</td>
            <td class="altbg2">
               <input type="text"  id="caiji_url" value="" class="form-control"  name="caiji_url" style="width:300px" />
            </td>
        </tr>
        <tr>
            <td class="altbg1" width="45%"><b>输入采集网址分页开始和结束数值:</b></td>
            <td class="altbg2">
           <p><span>开始页码:</span>  <input type="text"  id="caiji_beginnum" value="" name="caiji_beginnum" style="width:50px" />
           <span>结束页码</span><input type="text"  id="caiji_endnum" value="" name="caiji_endnum" style="width:50px" />
           </p>
            </td>
        </tr>
       <tr>
            <td class="altbg1" width="45%"><b>采集列表前面规则:</b><br>可输入html元素的类名或则ID，类名前加"."，ID前面加"#"</td>
            <td class="altbg2">
               <input type="text" value="" class="form-control short-input"   id="caiji_prefix" name="caiji_prefix" style="width:300px"  />
           <br>   <input type="checkbox"  id="ckbox" name="ckbox" >  <label>a标签title中获取标题(如果标题带有省略号请勾选)</label>
            </td>
        </tr>
         <tr style="display:none;">
            <td class="altbg1" width="45%"><b>用户名:</b><br>如果用户名不填则录入数据默认为管理员</td>
            <td class="altbg2">
               <select id="s_username" name="s_username">


   <!--{loop $userlist $activeuser}-->


  <option value ="{$activeuser['uid']}" {if $s_username==$activeuser['uid']} selected  {/if}> {$activeuser['username']}</option>
		  <!--{/loop}-->
</select>
            </td>
         </tr>
           <tr>
            <td class="altbg1" width="45%"><b>答案采集:</b><br>此项不是必填留空则不采集,可输入html元素的类名或则ID，类名前加"."，分类前面加"#"</td>
            <td class="altbg2">
               <input type="text"  id="caiji_daan" class="form-control short-input"  value="" name="caiji_daan" style="width:300px" />
            </td>
        </tr>
         <tr>
            <td class="altbg1" width="45%"><b>问题描述:</b><br>填写描述html标签的类名或者ID即可，记得类名加".",ID加"#"</td>
            <td class="altbg2">
               <input type="text"  id="caiji_desc" class="form-control short-input"  value="" name="caiji_desc" style="width:300px" />
            </td>
        </tr>
         <tr>
            <td class="altbg1" width="45%"><b>最佳答案规则:</b><br>填写描述html标签的类名或者ID即可，记得类名加".",ID加"#"</td>
            <td class="altbg2">
               <input type="text"  id="caiji_best" class="form-control short-input"  value="" name="caiji_best" style="width:300px" />
            </td>
        </tr>
         <tr>
            <td class="altbg1" width="45%"><b>回答用户名采集规则:</b><br>填写描述用户名所在html标签的类名或者ID即可，记得类名加".",ID加"#"</td>
            <td class="altbg2">
               <input type="text"  id="caiji_hdusername" class="form-control short-input"  value="" name="caiji_hdusername" style="width:300px" />
            </td>
        </tr>
         <tr>
            <td class="altbg1" width="45%"><b>回答用户头像采集规则:</b><br>填写用户头像html标签的类名或者ID即可，记得类名加".",ID加"#"</td>
            <td class="altbg2">
               <input type="text"  id="caiji_hdusertx"  class="form-control short-input"  value="" name="caiji_hdusertx" style="width:300px" />
            </td>
        </tr>
        <tr>
            <td class="altbg1" width="45%"><b>答案采集网站域名:</b><br>如果问题网址不是绝对路径请填写</td>
            <td class="altbg2">
               <input type="text"  id="caiji_yuming" class="form-control short-input"  value="" name="caiji_yuming" style="width:300px" />
            </td>
        </tr>
           <tr>
            <td class="altbg1" width="45%"><b>是否过滤回答内容中的a标签:</b><br>如果你不想在采集的回答中包含a标签就勾选</td>
            <td class="altbg2">

            <input type="checkbox"  id="ckabox" name="ckabox" >  <label>过滤回答中的a标签请勾选</label>
            </td>
        </tr>
         <tr>
            <td class="altbg1" width="45%"><b>是否过滤回答内容中的img标签:</b><br>如果你不想在采集的回答中包含img标签就勾选</td>
            <td class="altbg2">

            <input type="checkbox"  id="imgckabox" name="imgckabox" >  <label>过滤回答中的img标签请勾选</label>
            </td>
        </tr>
           <tr>
            <td class="altbg1" width="45%"><b>是否自动采集:</b><br>自动采集前提点击提交按钮有数据正常显示</td>
            <td class="altbg2">
             <input type="text" value="300000" id="txtspeed" name="txtspeed"/>单位毫秒，1秒=1000毫秒。&nbsp;
            <input type="checkbox"  id="autock" name="autock" >  <label>勾选后将自动</label>
            </td>
        </tr>
    </table>
</td>


</tr>


</table>

    <input type="hidden" name="cid" id="cid"/>
                    <input type="hidden" name="cid1" id="cid1" value="0"/>
                    <input type="hidden" name="cid2" id="cid2" value="0"/>
                    <input type="hidden" name="cid3" id="cid3" value="0"/>
     <center><input type="button" id="subme" class="btn btn-success" name="submit" value="提 交"></center><br>
     <center><div id="msgtip" style="color:red"></div></center>
     <center><div id="msgpagetip" style="color:red"></div></center>
</form>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<table class="table alert alert-info">
    <tr>
        <td class="{$type}">{$message}</td>
    </tr>
</table>
<!--{/if}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div style="float:left;"><a href="#" target="main"><b id="numtip">采集结果()条</b></a></div>
     <input type="button" id="stopdata" class="btn btn-success" name="stopdata" onclick="stoplisten();" value="停止自动采集" style="float:right;margin:0 5px">
     <input type="button" id="autodata" class="btn btn-success" name="autodata" onclick="autolisten();" value="自动采集" style="float:right;margin:0 5px">
  <input type="button" id="geiindata" class="btn btn-success" name="geiindata" onclick="ckdata();" value="入库" style="float:right">
</div>
  <table id="ajaxtb" class="table ajaxtb">
        <tr class="header">
          <td width="6%"><input class="checkbox" value="chkall" id="chkall" onclick="checkall('tid[]')" type="checkbox" name="chkall"><label for="chkall">全选</label></td>
            <td  width="15%">采集标题</td>
            <td  width="15%">采集url</td>
             <td  width="15%">编辑内容</td>
        </tr>




    </table>

    <div class="modal fade" id="modalresult">
   <form class="form-horizontal" role="form" method="post">
<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
      <h4 class="modal-title">问题内容编辑</h4>
    </div>
    <div class="modal-body">
    <p class="alert alert-info text-center m-tip">已有相同的问题存在!
     <hr>
    </p>
   <div class="example">
      <ul id="myTab" class="nav nav-tabs">
        <li class="active">
          <a href="#tab1" data-toggle="tab">浏览模式</a>
        </li>
        <li class="">
          <a href="#tab2" data-toggle="tab">编辑模式</a>
        </li>

      </ul>
      <div class="tab-content">
        <div class="tab-pane in active" id="tab1">
          <div class="form-group">
          <label class="col-md-1 control-label">标题</label>
          <div class="col-md-11">
              <p class="m_p_title text-info" style="position:relative;top:6px;">

              </p>
          </div>
        </div>
            <div class="form-group">
          <label class="col-md-1 control-label">描述</label>
          <div class="col-md-11">
              <p class="m_p_miaosu text-info" style="position:relative;top:6px;">

              </p>
          </div>
        </div>
            <div class="form-group">
          <label class="col-md-1 control-label">最佳答案</label>
          <div class="col-md-11">
              <p class="m_p_best text-danger" style="position:relative;top:6px;">

              </p>
          </div>
        </div>
            <div class="form-group">
          <label class="col-md-1 control-label">其它回答</label>
          <div class="col-md-11">
              <div class="m_p_others text-info">

              </div>
          </div>
        </div>
        </div>
        <div class="tab-pane" id="tab2">
           <div class="mode_edit" style="margin-top:10px;">
        <div class="form-group">
          <label class="col-md-1 control-label">标题</label>
          <div class="col-md-11">
             <input type="text" name="m_q_title" id="m_q_title" value="" class="form-control">
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-1 control-label">描述</label>
          <div class="col-md-11">
          <textarea  name="m_q_desc" id="m_q_desc"  rows="2" class="form-control"></textarea>

          </div>
        </div>
          <div class="form-group">
          <label class="col-md-1 control-label">最佳答案</label>
          <div class="col-md-11">
          <textarea  name="m_q_best" id="m_q_best"  rows="2" class="form-control"></textarea>


          </div>
        </div>
           <div class="form-group">
          <label class="col-md-1 control-label">其它回答</label>
          <div class="col-md-11 m_otherlist">



          </div>
        </div>
    </div>
        </div>



      </div>
    </div>



    </div>
    <div class="modal-footer">

      <button type="button" id="btn_q_submit" class="btn btn-primary">提交</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
    </div>
  </div>
</div>
</form>
</div>
<style>
.m_p_miaosu .content{
	height:auto;
  min-height:auto;
}
</style>
    <script>
    var current_target;
    $(".m_p_miaosu .content").css({"height":"auto","min-height":"auto"});
 // 参数：prop = 属性，val = 值
    function createJson(prop, val) {
        // 如果 val 被忽略
        if(typeof val === "undefined") {
            // 删除属性
            delete str1[prop];
        }
        else {
            // 添加 或 修改
            str1[prop] = val;
        }
    }
    $("#btn_q_submit").bind("click",function(event){
		 var randclass=$("#caiji_randclass").val();


			 var value =$('#category1 option:selected') .val();
			 var value1 =$('#category1 option:selected') .val();
			 var value2 =$('#category2 option:selected') .val();
			 var value3 =$('#category3 option:selected') .val();
			 if(randclass==""&&value==null){
				 var msg = '';
		    	 msg =new $.zui.Messager('请选择分类', {placement: 'center',close: 'false'});
			         msg.show();
				 return false;
			 }
			 if (value1 > 0) {
				 value=value1;
		     }
		     if (value2 > 0) {
		    	 value=value2;
		     }
		     if (value3 > 0) {
		    	 value=3;
		     }

			 var uvalue =$('#s_username option:selected').val();// obj1.options[index].value;

    	var jsonarr_question={
    			'm_title':$("#m_q_title").val(),
    			'm_miaosu':$("#m_q_desc").val(),
    			'm_q_best':$("#m_q_best").val(),
    			'randclass':randclass,
    			'cid':value,
    			'cid1':value1,
    			'cid2':value2,
    			'cid3':value3,
    			'm_tiwentime':$('#tiwenshijian option:selected').val(),
    			'm_huidatime':$('#huidashijian option:selected').val(),
    			'm_q_other':[]
    	};


    	$(".m_otherlist .otheranswer").each(function(){


    		var _result  =
    	     {
    	         "content" : $(this).val()

    	     }
    		if($.trim($(this).val())!=''){
    			jsonarr_question.m_q_other.push(_result);
    		}

    	});

         console.log(jsonarr_question.m_title)
    	//console.log(window.JSON.stringify(jsonarr_question));
    	var jsonstring=window.JSON.stringify(jsonarr_question);//json字符串
    	 var msg = '';
    	 msg =new $.zui.Messager('正在加载', {placement: 'center',close: 'false'});
	         msg.show();
       	 var myurl=g_site_url+"index.php?admin_setting/putcaiji{$setting['seo_suffix']}";
       	  $.ajax({
       		    type: "post",
       		    url: myurl,
       		   async:false,
       		    dataType:"json",
       		     data:{'jsonstring':jsonstring},

       		  beforeSend:function(XMLHttpRequest){
       		   // 使用jQuery对象

       		     },
       		     success: function (data) {

       		    	 msg.hide();
       		    	 $.zui.messager.hide();
                  switch(data.result){
                  case '-1':
                	  alert("标题为空");
                	  break;
                  case '0':
                	  alert("问题已经存在");
                	  break;
                  case '1':
                	  current_target.parent().remove();
                		 $("#modalresult").modal("hide");
                	  alert("入库成功");
                	  break;
                  }

       		      },
       		      complete:function(XMLHttpRequest, textStatus){
       		    	 msg.hide();
       		    	 $.zui.messager.hide();
       		      },
       		      error: function (XMLHttpRequest, textStatus, errorThrown) {
       		           //  alert(errorThrown);
       		    	 $.zui.messager.hide();
       		     }
       		    });

    });
    function getcurrentquestion(q_url){
   	 var uvalue =$('#s_username option:selected').val();
   	var ckabox=document.getElementById("ckabox");
	var imgckabox=document.getElementById("imgckabox");
   	// alert('uvalue'+uvalue);
   	 var utext =$('#s_username option:selected').text();
   	// alert('utext'+utext);
   	 var bianma =$('#bianma option:selected') .val();
   	// alert('bianma'+bianma);
   	 var guize=$("#caiji_daan").val();
   	// alert('guize'+guize);
   	 var daanyuming=$("#caiji_yuming").val();
   	// alert('daanyuming'+daanyuming);
   	 var daandesc=$("#caiji_desc").val();
   	// alert('daandesc'+daandesc);
   	 var daanbest=$("#caiji_best").val();
   	// alert('daanbest'+daanbest);
   	 var caiji_hdusername=$("#caiji_hdusername").val();
   	 //alert('caiji_hdusername'+caiji_hdusername);
   	 var caiji_hdusertx=$("#caiji_hdusertx").val();
   	// alert('caiji_hdusertx'+caiji_hdusertx);
   	 var caiji_beginnum=$("#caiji_beginnum").val();
   	// alert('caiji_beginnum'+caiji_beginnum);
   	 var caiji_endnum=$("#caiji_endnum").val();
   	 //alert('caiji_endnum'+caiji_endnum);

   	 var dananurl=q_url;


   	 var myurl=g_site_url+"index.php?admin_setting/getoncaiji{$setting['seo_suffix']}";
   	  $.ajax({
   		    type: "post",
   		    url: myurl,
   		   async:false,
   		    dataType:"json",
   		     data:{'caiji_hdusertx':caiji_hdusertx,'caiji_hdusername':caiji_hdusername,'uid':uvalue,'username':utext,'daanurl':dananurl,'guize':guize,'bianma':bianma,'daandesc':daandesc,'daanbest':daanbest,'caiji_beginnum':caiji_beginnum,'caiji_endnum':caiji_endnum,'daanyuming':daanyuming,'imgckabox':imgckabox.checked,'ckabox':ckabox.checked},

   		  beforeSend:function(XMLHttpRequest){
   			current_target.html("正在加载...");
   		     },
   		     success: function (data) {
   		    	 console.log(data);
   		    	current_target.html("编辑内容");
                if(data.result=='1'){
                	$(".m-tip").show();
                }else{
                	$(".m-tip").hide();
                }
                $(".m_p_miaosu").html(data.miaosu);
                $(".m_p_best").html(data.bestanswer);
   		      $("#m_q_desc").val(data.miaosu);
   		      $("#m_q_best").val(data.bestanswer);
   		   $(".m_otherlist").html("");
   		   $(".m_p_others").html("");
   		   for (var i = 0; i < data.otherlist.length; i++) {
   			  var html_answer=' <textarea  name="m_q_other[]"   rows="2" class="form-control otheranswer">'+data.otherlist[i]+'</textarea>';
   		      $(".m_otherlist").append(html_answer);
   		      var ci=i+1;
   		   $(".m_p_others").append("<p class='text-info' style='position:relative;top:1px;color: #03b8cf;'><span>回答"+ci+":</span>"+data.otherlist[i]+"<hr></p>");
           };
   		  	 $("#modalresult").modal("show");

   		      },
   		      complete:function(XMLHttpRequest, textStatus){
   		    	current_target.html("编辑内容");
   		    	 $.zui.messager.hide();
   		      },
   		      error: function (XMLHttpRequest, textStatus, errorThrown) {
   		           //  alert(errorThrown);
   		    	 $.zui.messager.hide();
   		     }
   		    });
   	return "";
   }
    var category1 = {$categoryjs[category1]};
    var category2 = {$categoryjs[category2]};
    var category3 = {$categoryjs[category3]};

      //  $(document).ready(function() {

        	initcategory(category1);

  //  });

    function selectcate() {
        var selectedcatestr = '';
        var category1 = $("#category1 option:selected").val();
        var category2 = $("#category2 option:selected").val();
        var category3 = $("#category3 option:selected").val();
        if (category1 > 0) {
            selectedcatestr = $("#category1 option:selected").html();
            $("#cid").val(category1);
            $("#cid1").val(category1);
        }
        if (category2 > 0) {
            selectedcatestr += " > " + $("#category2 option:selected").html();
            $("#cid").val(category2);
            $("#cid2").val(category2);
        }
        if (category3 > 0) {
            selectedcatestr += " > " + $("#category3 option:selected").html();
            $("#cid").val(category3);
            $("#cid3").val(category3);
        }

        $("#catedialog").dialog("close");
    }
    </script>
    <script type = "text/javascript">
    var first=0;
    var arrindexs=new Array();
    var speed = 1800000;//定义采集皮频率，默认30分钟采集一次
    var listener = null;//定义个监听器
    var openauto = false;//设置自动采集
function ckdata(){
	//checkall('tid[]');
	first=0;
	check('tid[]');
}

//定时采集入口-----

function stoplisten(){
	 $("#autodata").removeAttr("disabled");//将按钮可用
	openauto=false;
	 clearInterval(listener);
}

function autolisten() {

	 var ckbox=document.getElementById("autock");



		 if(ckbox.checked){
			 openauto=true;
		 }else{
				alert("勾选自动采集才可以!");
				return false;
		 }





	 var txtspeed_v=$("#txtspeed").val();

	// checkRate(txtspeed_v);

	 speed=parseInt(txtspeed_v);

	 if(speed<300000){
		 $("#txtspeed").focus();
		 alert("不能低于5分钟一次，否则太频繁!");
			return false;
	 }
//采集监听实现
first=0;
getquestionlist();

    listener = setInterval(function () {


    	$("#autodata").attr({"disabled":"disabled"});//禁用自动采集按钮
       if(openauto==false){
            clearInterval(listener);
        }

       first=0;
       arrindexs=[];
       getquestionlist();

    }, speed);

}





//结束定时采集------

function ajaxlist(){
	console.log("arrindexs长度:"+arrindexs.length);
	  if(first<arrindexs.length)
			{
				  var i=arrindexs[first];

				  var title=document.all('tid[]')[i].value;
				  var tiwentime =$('#tiwenshijian option:selected').val();
				  var huidatime =$('#huidashijian option:selected').val();
					 var randclass=$("#caiji_randclass").val();


					//alert(title);
					//alert(title);
					//return;
					//alert($('#s_fenlei option:selected') .val());//选中的值
					//var obj1 = document.getElementByIdx("s_fenlei"); //定位id
					 var value =$('#category1 option:selected') .val();// obj.options[index].value;
					 var value1 =$('#category1 option:selected') .val();
					 var value2 =$('#category2 option:selected') .val();
					 var value3 =$('#category3 option:selected') .val();
					 if(randclass==""&&value==""){
						 alert("请选择分类");
						 return false;
					 }
					 if (value1 > 0) {
						 value=value1;
				     }
				     if (value2 > 0) {
				    	 value=value2;
				     }
				     if (value3 > 0) {
				    	 value=3;
				     }

					// var ckbool=document.getElementById('ckbox').checked;
					// alert(ckbox);
					//alert(value1);
					//alert(value2);
//					alert(value3);
					// var obj1 = document.getElementByIdx("s_username"); //定位id
					 var uvalue =$('#s_username option:selected').val();// obj1.options[index].value;
					 var ckabox=document.getElementById("ckabox");
					 var imgckabox=document.getElementById("imgckabox");
					// alert('uvalue'+uvalue);
					 var utext =$('#s_username option:selected').text();
					// alert('utext'+utext);
					 var bianma =$('#bianma option:selected') .val();
					// alert('bianma'+bianma);
					 var guize=$("#caiji_daan").val();
					// alert('guize'+guize);
					 var daanyuming=$("#caiji_yuming").val();
					// alert('daanyuming'+daanyuming);
					 var daandesc=$("#caiji_desc").val();
					// alert('daandesc'+daandesc);
					 var daanbest=$("#caiji_best").val();
					// alert('daanbest'+daanbest);
					 var caiji_hdusername=$("#caiji_hdusername").val();
					 //alert('caiji_hdusername'+caiji_hdusername);
					 var caiji_hdusertx=$("#caiji_hdusertx").val();
					// alert('caiji_hdusertx'+caiji_hdusertx);
					 var caiji_beginnum=$("#caiji_beginnum").val();
					// alert('caiji_beginnum'+caiji_beginnum);
					 var caiji_endnum=$("#caiji_endnum").val();
					 //alert('caiji_endnum'+caiji_endnum);

					 var dananurl=$("#url"+i).html();

					 if(dananurl.indexOf("http:")<0)

					 {
						 dananurl=daanyuming+dananurl;
					//
					 }

				  var myurl=g_site_url+"index.php?admin_setting/ajaxcaiji{$setting['seo_suffix']}";

				  $.ajax({
				    type: "post",
				    url: myurl,
				   async:false,
				    dataType:"text",
				     data:{'randclass':randclass,'huidatime':huidatime,'tiwentime':tiwentime,'caiji_hdusertx':caiji_hdusertx,'caiji_hdusername':caiji_hdusername,'title':title,'cid3':value3,'cid2':value2,'cid1':value1,'cid':value,'uid':uvalue,'username':utext,'daanurl':dananurl,'guize':guize,'bianma':bianma,'daandesc':daandesc,'daanbest':daanbest,'caiji_beginnum':caiji_beginnum,'caiji_endnum':caiji_endnum,'daanyuming':daanyuming,'imgckabox':imgckabox.checked,'ckabox':ckabox.checked},

				     success: function (data) {
				  	 console.log("已采集:"+first);

				  //alert(data);
				  var num=parseInt(first)+1;
				  	   $("#msgtip").html("已采集入库"+num+"条"+"<br>");
				  	  first++;

				  	  setTimeout(ajaxlist,200);

				      },
				      error: function (XMLHttpRequest, textStatus, errorThrown) {
				           //  alert(errorThrown);

				     }
				    });


			  }

}

function check(obj)
{
	console.log("采集执行选择....");
     var ic=0;

for(i=0;i<document.all(obj).length;i++)
{
if(document.all(obj)[i].checked){
	arrindexs.push(i);
	ic++;


  //createRequest(myurl,title,value3,value2,value1,value,uvalue,utext,dananurl,guize,bianma,i);
  //ajaxFunction(urlajax,i);

  }
  }
ajaxlist();
  }
var is_uccess=false;
$("#subme").click(function(){
	getquestionlist();

	return false;
});
function getquestionlist(){
	if($("#caiji_url").val()=="")
	{
	alert("网址不能为空!");
	return false;
	}
if($("#caiji_url").val()=="")
{
alert("规则不能为空!");
return false;
}
 var bianma =$('#bianma option:selected') .val();
 var caiji_beginnum=$("#caiji_beginnum").val();
 var caiji_endnum=$("#caiji_endnum").val();
 if(!(/^(\+|-)?\d+$/.test( caiji_beginnum )) || caiji_beginnum < 0){


	 alert("页码起始号只能是数字!");
		return false;


	}
 if(!(/^(\+|-)?\d+$/.test( caiji_endnum )) || caiji_endnum < 0){


	 alert("页码结束号只能是数字!");
		return false;


	}
//alert(caiji_beginnum);
//alert(caiji_endnum);
 if(parseInt(caiji_beginnum)>parseInt(caiji_endnum)){
	 alert("页码起始号不能大于页码结束号!");
		return false;
 }
 var caiji_url=$("#caiji_url").val();
 var caiji_prefix=$("#caiji_prefix").val();
 var tepurl;
 var ckbox=document.getElementById("ckbox");
// alert(ckbox.checked);
var autoint=0;
first=0;
arrindexs=new Array();
 for(i=caiji_beginnum;i<=caiji_endnum;i++){
	 tepurl=caiji_url;
	 tepurl=tepurl.replace("{#num}",i);
	 var myurl=g_site_url+"index.php?admin_setting/ajaxpostpage{$setting['seo_suffix']}";
	// var dataval="{'caiji_url':tepurl,'bianma':bianma,'ckbox':ckbox.checked,'caiji_prefix':caiji_prefix}";
	$(".ajaxtr").remove();
	$.ajax({
        type: "post",
         url: myurl,
         data:{'caiji_url':tepurl,'bianma':bianma,'ckbox':ckbox.checked,'caiji_prefix':caiji_prefix},
         dataType: "text",
         success: function (data) {

        		var dataObj =eval("("+data+")");

    			$.each(dataObj,function(idx,item){
    				   //输出



    				   var tb_tr="<tr class='ajaxtr' id='ck"+autoint+"'>"+'<td class="altbg2"><input class="ckboxme" checked="checked" type="checkbox" value="'+item.title+'"name="tid[]"></td>';
    				   var tb_tr=tb_tr+'<td class="altbg2 q_title">'+item.title+"</td>";
    				   var tb_tr=tb_tr+'<td class="altbg2 q_url" id="url'+autoint+'">'+item.href+'</td>';
    				   var tb_tr=tb_tr+'<td class="altbg2 text-info hand editquestion" listindex="'+autoint+'">编辑内容'+"</td></tr>";
    				   $("#ajaxtb").append(tb_tr);
    				   var num=autoint+1;
    				 //  alert("当前页采集了 "+num+"条");
    				   $("#numtip").html("当前页采集了 "+num+"条");
    				   $("#msgtip").html("<br>");


    				   autoint++;
    				});
    			 $(".editquestion").click(function(){

    				 var randclass=$("#caiji_randclass").val();


    				 var value =$('#category1 option:selected') .val();
    				 var value1 =$('#category1 option:selected') .val();
    				 var value2 =$('#category2 option:selected') .val();
    				 var value3 =$('#category3 option:selected') .val();

    				 if(randclass==""&&value==null){
    					 var msg = '';
     			    	 msg =new $.zui.Messager('请选择分类', {placement: 'center',close: 'false'});
     				         msg.show();
    					 return false;
    				 }
    				 current_target=$(this);
 					var _index=$(this).attr("listindex");
 					var _title=$(this).parent().find(".q_title").html();
 					var _q_url=$(this).parent().find(".q_url").html();
 					var _domain=$("#caiji_yuming").val();
 					var  _q_last_url=_domain+_q_url;
 					$("#m_q_title").val(_title);
 					$(".m_p_title").html(_title);
 					 var msg = '';
 			    	 msg =new $.zui.Messager('正在加载', {placement: 'center',close: 'false'});
 				         msg.show();


 					getcurrentquestion(_q_last_url);

 				 });
    			if(openauto==true){
    				check('tid[]');
    			}
    			is_uccess=true;
         },
         error: function (XMLHttpRequest, textStatus, errorThrown) {
                //alert(errorThrown);
       }
 });



 }
}

</script>
<script>
$("#xmllist .liset").click(function() {

	var filename=$(this).attr("path");

    $.ajax({
        url: "{SITE_URL}static/caiji/"+filename,
        dataType: 'text',
        success: function(data1) {

        	$("#category1 option[value='1']").attr("selected", "selected");

            var datalist=data1.split('|');
            $("#tipsurl").html("<b>"+datalist[8]+"</b>");

            $("#caiji_url").val(datalist[0]);
            $("#caiji_beginnum").val("0");
            $("#caiji_endnum").val("0");

            if(datalist[9]==1){
            	document.getElementById("ckbox").checked=true;
            }else{
            	document.getElementById("ckbox").checked=false;
            }
            $("#caiji_prefix").val(datalist[1]);
            $("#caiji_daan").val(datalist[2]);

            $("#caiji_desc").val(datalist[3]);

            $("#caiji_best").val(datalist[4]);

            $("#caiji_hdusername").val(datalist[5]);

            $("#caiji_hdusertx").val(datalist[6]);

            	  $("#caiji_yuming").val(datalist[7]);



        }
    });
});
</script>
<style>
body{
	overflow:visible;
}
</style>
<!--{template footer}-->