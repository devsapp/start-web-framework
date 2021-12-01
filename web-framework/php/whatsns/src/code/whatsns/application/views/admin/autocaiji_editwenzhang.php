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
文章采集编辑，如有修改可以测试采集是否成功
</div>
<a href="{SITE_URL}index.php?admin_autocaiji/{$setting['seo_suffix']}" class="btn btn-success">返回</a>
<form>



<table class="table">
        <tr class="header">

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
            <td class="altbg1" width="45%"><b>发布时间设置(单位:分钟):</b><br>默认提问为10分钟内容</td>
            <td class="altbg2">
              <select name="huidashijian" id="huidashijian">

   <option {if $caiji['huidashijian']==20} selected  {/if}  value="20">20</option>
     <option  {if $caiji['huidashijian']==30} selected  {/if} value="30">30</option>
       <option  {if $caiji['huidashijian']==40} selected  {/if} value="40">40</option>
         <option  {if $caiji['huidashijian']==50} selected  {/if} value="50">50</option>
           <option  {if $caiji['huidashijian']==60} selected  {/if} value="60">60</option>


</select>
            </td>
        </tr>
          <tr>
            <td class="altbg1" width="45%"><b>文章来源:</b><br>采集目标网站的名称以及详细页面，比如首页还是哪个分类页面，比如搜狗首页，搜狗法律分类页</td>
            <td class="altbg2">
               <input type="text"  id="source" class="form-control short-input"  value="{$caiji['source']}" name="source" style="width:300px" />
            </td>
        </tr>
         <tr>
            <td class="altbg1" width="45%"><b>文章分类:</b></td>
            <td class="altbg2">
               <div id="dialogcate1">

                    <select  id="category1"  size="8" name="category1" ></select>

                    <select  id="category2"   size="8" name="category2" ></select>

                    <select id="category3"  size="8"  name="category3" ></select>



    </div>

            </td>
        </tr>


        <tr>
            <td class="altbg1" width="45%"><b>输入文章列表网址:</b>

           </td>
            <td class="altbg2">
               <input type="text"  id="caiji_url" value="{$caiji['caiji_url']}" class="form-control"  name="caiji_url" style="width:300px" />
            </td>
        </tr>

       <tr>
            <td class="altbg1" width="45%"><b>文章列表规则:</b><br>可输入html元素的类名或则ID，类名前加"."，ID前面加"#"</td>
            <td class="altbg2">
               <input type="text" value="{$caiji['caiji_prefix']}" class="form-control short-input"   id="caiji_prefix" name="caiji_prefix" style="width:300px"  />
           <br>   <input type="checkbox"  {if $caiji['atitle']==1} checked  {/if} id="ckbox" name="ckbox" >  <label>a标签title中获取标题(如果标题带有省略号请勾选)</label>
            </td>
        </tr>

           <tr>
            <td class="altbg1" width="45%"><b>详情页文章标题规则:</b><br>此项不是必填留空则不采集,可输入html元素的类名或则ID，类名前加"."，分类前面加"#"</td>
            <td class="altbg2">
               <input type="text"  id="caiji_daan" class="form-control short-input"  value="{$caiji['guize']}" name="caiji_daan" style="width:300px" />
            </td>
        </tr>
         <tr>
            <td class="altbg1" width="45%"><b>详情页文章内容规则:</b><br>填写描述html标签的类名或者ID即可，记得类名加".",ID加"#"</td>
            <td class="altbg2">
               <input type="text"  id="caiji_desc" class="form-control short-input"  value="{$caiji['daandesc']}" name="caiji_desc" style="width:300px" />
            </td>
        </tr>


        <tr>
            <td class="altbg1" width="45%"><b>采集网站域名:</b><br>如果文章列表页地址不是绝对路径请填写</td>
            <td class="altbg2">
               <input type="text"  id="caiji_yuming" class="form-control short-input"  value="{$caiji['daanyuming']}" name="caiji_yuming" style="width:300px" />
            </td>
        </tr>
           <tr>
            <td class="altbg1" width="45%"><b>是否过滤文章内容中的a标签:</b><br>如果你不想在采集的文章中包含a标签就勾选</td>
            <td class="altbg2">

            <input type="checkbox"  {if $caiji['ckabox']==1} checked  {/if}  id="ckabox" name="ckabox" >  <label>过滤文章中的a标签请勾选</label>
            </td>
        </tr>
         <tr>
            <td class="altbg1" width="45%"><b>是否过滤文章内容中的img标签:</b><br>如果你不想在文章中包含img标签就勾选</td>
            <td class="altbg2">

            <input type="checkbox"  {if $caiji['imgckabox']==1} checked  {/if}  id="imgckabox" name="imgckabox" >  <label>过滤文章中的img标签请勾选</label>
            </td>
        </tr>

    </table>
      <input type="hidden" name="cid" id="cid" value="{$caiji['cid']}"/>
                    <input type="hidden" name="cid1" id="cid1" value="{$caiji['category1']}"/>
                    <input type="hidden" name="cid2" id="cid2" value="{$caiji['category2']}"/>
                    <input type="hidden" name="cid3" id="cid3" value="{$caiji['category3']}"/>
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
             <td  width="15%">查看文章</td>
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
      <h4 class="modal-title">查看文章</h4>
    </div>
    <div class="modal-body">
    <p class="alert alert-info text-center m-tip">已有相同的文章存在!
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
          <label class="col-md-1 control-label">内容</label>
          <div class="col-md-11">
              <p class="m_p_miaosu text-info" style="position:relative;top:6px;">

              </p>
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
	  data.id={$caiji['id']};

	  data.tiwentime=1;
	  var huidatime =$('#huidashijian option:selected').val();//回答时间
	  data.huidatime=huidatime;
	  var caiji_prefix=$("#caiji_prefix").val();//采集列表规则
	  data.caiji_prefix=caiji_prefix;
	  selectcate();
		 var value =$('#cid') .val();// 当前选择的分类id
		 var value1 =$('#cid1') .val();//一级分类

		 var value2 =$('#cid2') .val();//2级分类

		 var value3 =$('#cid3') .val();//3级分类

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



		 var ckabox=document.getElementById("ckabox");//过滤回答超链接

		 data.ckabox=ckabox.checked==false? 0:1;
		 var imgckabox=document.getElementById("imgckabox");//过滤图片
		 data.imgckabox=imgckabox.checked==false? 0:1;

		 data.atitle=0;
		// alert('utext'+utext);
		 var bianma =$('#bianma option:selected') .val();//网页编码
		 data.bianma=bianma;
		// alert('bianma'+bianma);
		 var guize=$("#caiji_daan").val();//标题
		 data.guize=guize;
		 var source=$("#source").val();//采集来源
		 data.source=source;
		// alert('guize'+guize);
		 var daanyuming=$("#caiji_yuming").val();//域名
		 data.daanyuming=daanyuming;
		// alert('daanyuming'+daanyuming);
		 var daandesc=$("#caiji_desc").val();//内容
		 data.daandesc=daandesc;
		// alert('daandesc'+daandesc);

		 data.daanbest='';
		// alert('daanbest'+daanbest);

		 data.caiji_hdusername='';
		 //alert('caiji_hdusername'+caiji_hdusername);

		 data.caiji_hdusertx='';

		 data.caijitype=1;
		 var posturl='{SITE_URL}index.php?admin_autocaiji/posteditguize{$setting['seo_suffix']}';
		 function success(result){
			 console.log(result)
			 if(result.msg=='ok'){
				 alert("更新成功");
			 }else{
				 alert("更新失败");
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
         data:{'ckbox':false,'caiji_url':tepurl,'bianma':bianma,'caiji_prefix':caiji_prefix},
         dataType: "text",
         success: function (data) {


        	 if(data==null||data=='undefined'||data=='null'){
        		 $("#numtip").html("没有采集到数据，检查[采集列表前面规则]是否正确");
        		 return false;
        	 }

        		var dataObj =eval("("+data+")");
        		   //输出
				  $("#ajaxtb").html("");
    			$.each(dataObj,function(idx,item){


    			  var tb_tr="<tr class='ajaxtr' id='ck"+autoint+"'>";
    				   var tb_tr=tb_tr+'<td class="altbg2 q_title">'+item.title+"</td>";
    				   var tb_tr=tb_tr+'<td class="altbg2 q_url" id="url'+autoint+'">'+item.href+'</td>';
    				   var tb_tr=tb_tr+'<td class="altbg2 text-info hand editquestion" listindex="'+autoint+'">查看文章'+"</td></tr>";
    				   $("#ajaxtb").append(tb_tr);
    				   var num=autoint+1;
    				 //  alert("当前页采集了 "+num+"条");
    				   $("#numtip").html("当前页采集了 "+num+"条");
    				   $("#msgtip").html("<br>");



    				   autoint++;
    				});
    			$(".editquestion").click(function(){


   					console.log("查看文章...")
   				 var value =$('#cid') .val();// 当前选择的分类id
   				 var value1 =$('#cid1') .val();//一级分类

   				 var value2 =$('#cid2') .val();//2级分类

   				 var value3 =$('#cid3') .val();//3级分类

   				 if(value==""){
   					 alert("请选择分类");
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
  	var ckabox=document.getElementById("ckabox");//文章过滤a标签
	var imgckabox=document.getElementById("imgckabox");//文章过滤img标签

  	 var bianma =$('#bianma option:selected') .val();//文章采集编码
  	// alert('bianma'+bianma);
  	 var guize=$("#caiji_daan").val(); //文章标题
  	// alert('guize'+guize);
  	 var daanyuming=$("#caiji_yuming").val();//文章域名
  	// alert('daanyuming'+daanyuming);
  	 var daandesc=$("#caiji_desc").val();//文章内容
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


  	 var myurl=g_site_url+"index.php?admin_autocaiji/getarticle{$setting['seo_suffix']}";
  	  $.ajax({
  		    type: "post",
  		    url: myurl,
  		   async:false,
  		    dataType:"json",
  		     data:{'daanurl':dananurl,'guize':guize,'bianma':bianma,'daandesc':daandesc,'daanyuming':daanyuming,'imgckabox':imgckabox.checked,'ckabox':ckabox.checked},

  		  beforeSend:function(XMLHttpRequest){
  			current_target.html("正在加载...");
  		     },
  		     success: function (data) {
  		    	 console.log(data);
  		    	current_target.html("查看文章");
               if(data.result=='1'){
               	$(".m-tip").show();
               }else{
               	$(".m-tip").hide();
               }

			$(".m_p_title").html(data.title);
               $(".m_p_miaosu").html(data.neirong);

  		   $(".m_otherlist").html("");
  		   $(".m_p_others").html("");

  		  	 $("#modalresult").modal("show");

  		      },
  		      complete:function(XMLHttpRequest, textStatus){
  		    	current_target.html("查看文章");
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