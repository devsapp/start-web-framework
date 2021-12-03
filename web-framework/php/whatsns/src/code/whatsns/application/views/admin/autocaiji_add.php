<!--{template header}-->

<style>
body,.wrapper{
	overflow:visible;
}
.automain{
	width:60%;
}
.clearfix, .clear {
    clear: none;
}
.auto_pannel_box{

	width:20%;
    min-height:400px;
position:fixed;
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

<div class="alert alert-warning">
采集规则某项如果不为空就会采集，如果不需要采集就留空
</div>
<a href="{SITE_URL}index.php?admin_autocaiji/{$setting['seo_suffix']}" class="btn btn-success">返回</a>
<form>



<table class="table">
        <tr class="header">
            <td colspan="2">采集设置<span id="tipsurl"></span>&nbsp;&nbsp;<span style="color:red">ask2问答官网采集教程(<a target="_blank" href="http://www.ask2.cn/article-39.html">http://www.ask2.cn</a></span>)</td>
        </tr>
         <tr>
            <td class="altbg1" width="45%"><b>网页编码:</b><br>一般不需要变，如果出现乱码就切换编码格式</td>
            <td class="altbg2">
              <select name="bianma" id="bianma">
               <option value ="utf-8" >utf-8</option>
  <option value ="gb2312" >gb2312</option>


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
            <td class="altbg1" width="45%"><b>采集来源:</b><br>采集目标网站的名称以及详细页面，比如首页还是哪个分类页面，比如搜狗首页，搜狗法律分类页</td>
            <td class="altbg2">
               <input type="text"  id="source" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="采集的来源网站，详细到具体页面标题 " class="form-control short-input"  value="" name="source" style="width:300px" />
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

            <br>直接复制需要采集的网址就行</td>
            <td class="altbg2">
               <input type="text"  data-toggle="tooltip" data-placement="bottom" title="" data-original-title="直接复制需要采集的网址"  id="caiji_url" value="" class="form-control"  name="caiji_url" style="width:300px" />
            </td>
        </tr>

       <tr>
            <td class="altbg1" width="45%"><b>采集列表前面规则:</b><br>可输入html元素的类名或则ID，类名前加"."，ID前面加"#"</td>
            <td class="altbg2">
               <input type="text" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="这里是抓取标题列表项的规则"   value="" class="form-control short-input"   id="caiji_prefix" name="caiji_prefix" style="width:300px"  />
           <br>   <input type="checkbox"  id="ckbox" name="ckbox" >  <label>a标签title中获取标题(如果标题带有省略号请勾选)</label>
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
            <td class="altbg1" width="45%"><b>回答用户名采集规则:</b><br>填写描述用户名所在html标签的类名或者ID即可，记得类名加".",ID加"#"</td>
            <td class="altbg2">
               <input type="text"  id="caiji_hdusername" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="留空就不采集，否则会作为马甲身份自动采集 " class="form-control short-input"  value="" name="caiji_hdusername" style="width:300px" />
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

    </table>
    <button type="button" class="btn btn-success" onclick="addcaiji()">保存</button>
     <button type="button" class="btn btn-success" onclick="testceshi()">测试采集</button>
</form>
  <div><a href="#" target="main"><b id="numtip">采集结果()条</b></a></div>
   <center><div id="msgtip" style="color:red"></div></center>
     <center><div id="msgpagetip" style="color:red"></div></center>
  <table  class="table ">
        <tr class="header">

            <td  width="15%">采集标题</td>
            <td  width="15%">采集url</td>
             <td  width="15%">查看回答</td>
        </tr>
        <tbody id="ajaxtb" class="ajaxtb">
        </tbody>





    </table>

    <div class="modal fade" id="modalresult">
   <form class="form-horizontal" role="form" method="post">
<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
      <h4 class="modal-title">查看回答</h4>
    </div>
    <div class="modal-body">
    <p class="alert alert-info text-center m-tip">已有相同的问题存在!
     <hr>
    </p>
   <div class="example">
      <ul id="myTab" class="nav nav-tabs">
        <li class="active">
          <a href="#tab1" data-toggle="tab">浏览</a>
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




      </div>
    </div>



    </div>
    <div class="modal-footer">


      <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
    </div>
  </div>
</div>
</form>
</div>
    <script type="text/javascript">

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
        $("#selectedcate").html(selectedcatestr);
        $("#changecategory").html("更改分类");
        $('#myLgModal').modal('hide');
    }



</script>
<script>
function addcaiji(){
	 var data={};
	if($("#caiji_url").val()=="")
	{
	alert("网址不能为空!");
	return false;
	}
	 var caiji_url=$("#caiji_url").val();//采集网址
	 data.caiji_url=caiji_url;
	  var tiwentime =$('#tiwenshijian option:selected').val();//提问时间

	  data.tiwentime=tiwentime;
	  var huidatime =$('#huidashijian option:selected').val();//回答时间
	  data.huidatime=huidatime;
	  var caiji_prefix=$("#caiji_prefix").val();//采集列表规则
	  data.caiji_prefix=caiji_prefix;

		 var value =$('#category1 option:selected') .val();// 当前选择的分类id
		 var value1 =$('#category1 option:selected') .val();//一级分类

		 var value2 =$('#category2 option:selected') .val();//2级分类

		 var value3 =$('#category3 option:selected') .val();//3级分类

		 if(value==""){
			 alert("请选择分类");
			 return false;
		 }
		 if (value1 > 0) {
			 value=value1;
	     }
	     if (value2 > 0) {
	    	 value=value2;
	     }else{
	    	 value2=0;
	     }
	     if (value3 > 0) {
	    	 value=value3;
	     }else{
	    	 value3=0;
	     }
	     data.value1=value1;
	     data.value2=value2;
	     data.value3=value3;
	     data.value=value;


		 var uvalue =$('#s_username option:selected').val();
		 var ckabox=document.getElementById("ckabox");//过滤回答超链接

		 data.ckabox=ckabox.checked==false? 0:1;
		 var imgckabox=document.getElementById("imgckabox");//过滤图片
		 data.imgckabox=imgckabox.checked==false? 0:1;
		 var atitle=document.getElementById("ckbox");//过滤图片
		 data.atitle=atitle.checked==false? 0:1;
		// alert('utext'+utext);
		 var bianma =$('#bianma option:selected') .val();//网页编码
		 data.bianma=bianma;
		// alert('bianma'+bianma);
		 var guize=$("#caiji_daan").val();//其它回答
		 data.guize=guize;
		 var source=$("#source").val();//采集来源
		 data.source=source;
		// alert('guize'+guize);
		 var daanyuming=$("#caiji_yuming").val();//域名
		 data.daanyuming=daanyuming;
		// alert('daanyuming'+daanyuming);
		 var daandesc=$("#caiji_desc").val();//描述
		 data.daandesc=daandesc;
		// alert('daandesc'+daandesc);
		 var daanbest=$("#caiji_best").val();//最佳答案
		 data.daanbest=daanbest;
		// alert('daanbest'+daanbest);
		 var caiji_hdusername=$("#caiji_hdusername").val();//采集用户名
		 data.caiji_hdusername=caiji_hdusername;
		 //alert('caiji_hdusername'+caiji_hdusername);
		 var caiji_hdusertx=$("#caiji_hdusertx").val();//采集头像
		 data.caiji_hdusertx=caiji_hdusertx;

		 var posturl='{SITE_URL}index.php?admin_autocaiji/postguize{$setting['seo_suffix']}';
		 function success(result){
			 console.log(result)
			 if(result.msg=='ok'){
				 alert("添加成功");
			 }else{
				 alert("添加失败");
			 }
		 }
		 console.log(data);
		 ajaxpost(posturl,data,success);




}
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
function testceshi(){
	 var caiji_url=$("#caiji_url").val();//采集网址
	 var caiji_prefix=$("#caiji_prefix").val();//采集列表规则
	var bianma =$('#bianma option:selected') .val();
	getquestionlist(caiji_url,bianma,caiji_prefix);
}
//采集列表页面
function getquestionlist(tepurl,bianma,caiji_prefix){




	var autoint=0;
	 var myurl=g_site_url+"index.php?admin_autocaiji/ajaxpostpage{$setting['seo_suffix']}";



	$.ajax({
        type: "post",
         url: myurl,
         data:{'ckbox':ckbox.checked,'caiji_url':tepurl,'bianma':bianma,'caiji_prefix':caiji_prefix},
         dataType: "text",
         success: function (data) {


        	 if(data==null||data=='undefined'||data=='null'){
        		 $("#numtip").html("没有采集到数据，检查[采集列表前面规则]是否正确");
        		 return false;
        	 }

        		var dataObj =eval("("+data+")");
        		 $("#ajaxtb").html("");
    			$.each(dataObj,function(idx,item){
    				   //输出


    			  var tb_tr="<tr class='ajaxtr' id='ck"+autoint+"'>";
    				   var tb_tr=tb_tr+'<td class="altbg2 q_title">'+item.title+"</td>";
    				   var tb_tr=tb_tr+'<td class="altbg2 q_url" id="url'+autoint+'">'+item.href+'</td>';
    				   var tb_tr=tb_tr+'<td class="altbg2 text-info hand editquestion" listindex="'+autoint+'">查看回答'+"</td></tr>";
    				   $("#ajaxtb").append(tb_tr);
    				   var num=autoint+1;
    				 //  alert("当前页采集了 "+num+"条");
    				   $("#numtip").html("当前页采集了 "+num+"条");
    				   $("#msgtip").html("<br>");



    				   autoint++;
    				});
    			$(".editquestion").click(function(){


   					console.log("查看回答...")
   				 var value =$('#category1 option:selected') .val();
   				 var value1 =$('#category1 option:selected') .val();
   				 var value2 =$('#category2 option:selected') .val();
   				 var value3 =$('#category3 option:selected') .val();

   				 if(value==null){
   					alert('请选择分类');
   					 return false;
   				 }
   				 current_target=$(this);
					var _index=$(this).attr("listindex");
					var _title=$(this).parent().find(".q_title").html();
					var _q_url=$(this).parent().find(".q_url").html();


					var _domain=$("#caiji_yuming").val();
					var  _q_last_url=_domain+_q_url;
					 if(_q_last_url.indexOf("http")<0)

					 {
						 alert('请填写域名');
	   					 return false;

					 }
					$("#m_q_title").val(_title);
					$(".m_p_title").html(_title);
					 var msg = '';
			    	 msg =new $.zui.Messager('正在加载', {placement: 'center',close: 'false'});
				         msg.show();
				         console.log(_q_last_url)
					getcurrentquestion(_q_last_url);

				 });


         },
         error: function (XMLHttpRequest, textStatus, errorThrown) {
                //alert(errorThrown);
       }
 });




}
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


  	 var myurl=g_site_url+"index.php?admin_autocaiji/getoncaiji{$setting['seo_suffix']}";
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
  		    	current_target.html("查看回答");
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
  		    	current_target.html("查看回答");
  		    	 $.zui.messager.hide();
  		      },
  		      error: function (XMLHttpRequest, textStatus, errorThrown) {
  		           //  alert(errorThrown);
  		    	 $.zui.messager.hide();
  		     }
  		    });
  	return "";
  }
</script>
 <script src="{SITE_URL}static/css/bianping/js/common.js"></script>
<!--{template footer}-->