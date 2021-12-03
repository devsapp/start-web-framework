<!--{template header}-->

<link rel="stylesheet" media="all" href="{SITE_URL}static/css/common/commtag.css" />
<div class="container  mar-t-1 mar-b-1">
<div class="row">
  <div class="col-sm-24">

    <form  class="form-horizontal mar-t-1" id="askform" name="questionform" method="post" enctype="multipart/form-data">
            <div class="askbox">
                
       
                 
                
                
                       <div class="form-group">
          <p class="col-md-24 "></p>
          <div class="col-md-24">
        
               <input class="title form-control" name="title" id="qtitle" value="{$question['title']}">
          </div>
        </div>
        
                 <div class="form-group">
          <p class="col-md-24 ">编辑问题描述</p>
          <div class="col-md-24">
            <div id="introContent">
           <!--{template editor}-->
                    </div>
          </div>
        </div>
            
              <div class="form-group">
     
     
     <div class="col-md-12 " style="padding:0px;">

            <span id="selectedcate" class="selectedcate label">{$question['category_name']}</span>
                        <span><a class="btn btn-info" data-toggle="modal" data-target="#myLgModal" id="changecategory" href="javascript:void(0)" target="_self">更改</a>
          </span>
          </div>
          
        </div>

        <div class="form-group" >

          <div class="col-md-24 dongtai ">
      <div class="tags">
        <!--{if $taglist}-->
                                       <!--{loop $taglist $tag}-->
          <div class="tag">
          <span tagid="{$tag['id']}">{$tag['tagname']}</span><i class="fa fa-close"></i>
          </div>
               <!--{/loop}--><!--{else}--><!--{/if}-->
          </div>
            <input type="text" autocomplete="off"  data-toggle="tooltip" data-placement="bottom" title="" placeholder="检索标签，最多添加5个,添加标签更容易被回答" data-original-title="检索标签，最多添加5个" name="topic_tag" value=""  class="txt_taginput" >
            <i class="fa fa-search"></i>
             <span class="label hand choosetag" onclick="showcommontag()">选择热门标签</span>
           
           <div class="tagsearch">
        
          
           </div>
            
          </div>
      
</div>

                  <!--{if $user['grouptype']!=1&&$user['credit1']<$setting['jingyan']}-->
                      
     <!--{template code}-->
          <!--{/if}-->
          
         <div class="form-group">
          <div class=" col-md-10">
                       <input type="hidden" name="cid" id="cid" value="{$question['cid']}" />
                    <input type="hidden" name="cid1" id="cid1" value="{$question['cid1']}"/>
                    <input type="hidden" name="cid2" id="cid2" value="{$question['cid2']}"/>
                    <input type="hidden" name="cid3" id="cid3" value="{$question['cid3']}"/>
                          <input type="hidden" value="{$qid}" id="bianji_qid" name="qid" />
             <input type="button" id="submit" name="submit" class="btn btn-success" value="保存" data-loading="稍候..."> 
              <a class="btn btn-default mar-ly-1" onclick="window.history.go(-1)">返回</a>
          </div>
        </div>
            </div>	
        </form>
  </div>
  
   <div class="col-sm-24">
   <!--广告位5-->
        <!--{if (isset($adlist['question_view']['right1']) && trim($adlist['question_view']['right1']))}-->
        <div>{$adlist['question_view']['right1']}</div>
        <!--{/if}-->
  </div>
</div>
</div>
<div class="modal fade" id="myLgModal">
  <div class="modal-dialog modal-md" style="width: 460px; top: 50px;">
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
    


<style>
<!--
.btn.focus, .btn:focus, .btn:hover {
    color: #f5f5f5;
    text-decoration: none;
}
.choosetag {
    display: inline;
    padding: .2em .6em .2em;
    font-size: 75%;
    line-height: 1;
    color: #fff;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    background-color: grey;
    border-radius: .25em;
}
.md_taglist{

min-height:200px;
max-height:300px;
overflow-y:scroll;
}
.md_taglist .md_tagitem{
    display:inline-block;
    text-align: center;
    margin:10px;
}
.md_taglist .md_tagitem .label{
    position: relative;
    display: inline-block;
    height: 30px;
    padding: 0 12px;
    font-size: 14px;
    line-height: 30px;
    color: #0084FF;
    vertical-align: top;
    border-radius: 100px;
    background: rgba(0, 132, 255, 0.1);
cursor:pointer;
}
.md_taglist .md_tagitem .active{
border:dashed 2px #ea644a;
}
-->
</style>
 <div class="modal fade" id="commontag" >
  <div class="modal-dialog modal-md" style="width: 460px; top: 50px;">
    <div class="modal-content">
          <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
        <h4 class="modal-title">选择热门标签</h4>
      </div>
        <div class="modal-body">
            <div class="md_taglist">
                     {eval  $comtaglist=$this->getlistbysql("select * from ".$this->db->dbprefix."tag  order by tagquestions desc,tagarticles desc  limit 0,100");}
        {if $comtaglist}
          <!--{loop $comtaglist $index $comtag}-->
               <div class="md_tagitem">
                                     <label tagid="{$comtag['id']}" class="label " >{$comtag['tagname']}</label> 
               </div>
                <!--{/loop}-->
                    {/if} 
            </div>
            
            <center><button class="btn btn-primary" type="button" style="background:#3280fc;" onclick="hidecommontag()">关闭</button></center>
         </div>
    </div>
  </div>
</div>


<!--用户中心结束-->
<script type="text/javascript">
function showcommontag(){
	$("#commontag").modal("show");
}
function hidecommontag(){
	$("#commontag").modal("hide");
}
$(".md_taglist .md_tagitem .label").click(function(){
	var _tagname=$.trim($(this).html());
	var _tagid=$.trim($(this).attr("tagid"));
	if(gettagsnum()>=5){
		alert("标签最多添加5个");
		return false;
	}
	if(checktag(_tagname)){
		alert("标签已存在");
		return false;
	}
	$(".dongtai .tags").append('<div class="tag"><span tagid="'+_tagid+'">'+_tagname+"</span><i class='fa fa-close'></i></div>");
	$(".dongtai .tags .tag  .fa-close").click(function(){
		$(this).parent().remove();
	});
	$(".tagsearch").html("");
	$(".tagsearch").hide();
	$(".txt_taginput").val("");
	});
$("#submit").click(function(){
   	if(gettagsnum()>5){
        alert("最多添加5个标签");
        return false;
   	}
   	 var _tagstr=gettaglist();
   	
	// var eidtor_content= editor.getContent();
	 var eidtor_content='';
	 if(typeof testEditor != "undefined"){
      	  var tmptxt=$.trim(testEditor.getMarkdown());
      	  if(tmptxt==''){
      		  alert("回答内容不能为空");
      		  return;
      	  }
      	  eidtor_content= testEditor.getHTML();
        }else{
      	  if (typeof UE != "undefined") {
      			 eidtor_content= editor.getContent();
      		}else{
      			 eidtor_content= $.trim($("#editor").val());
      		}
        }
	   <!--{if $user['grouptype']!=1}-->
	  var data={
			  title:$("#qtitle").val(),
			  content:eidtor_content,
			 qid:$("#bianji_qid").val(),
			 submit:$("#submit").val(),
			 cid:$("#cid").val(),
			  cid1:$("#cid1").val(),
			  cid2:$("#cid2").val(),
			  cid3:$("#cid3").val(),
			  tags:_tagstr,
			  askfromuid:$("#askfromuid").val(),
  			
  			code:$("#code").val()
  	}
	    <!--{else}-->
		var data={
				  title:$("#qtitle").val(),
				  qid:$("#bianji_qid").val(),
				  submit:$("#submit").val(),
				  cid:$("#cid").val(),
				  tags:_tagstr,
    			  cid1:$("#cid1").val(),
    			  cid2:$("#cid2").val(),
    			  cid3:$("#cid3").val(),
    			 content:eidtor_content
    			 
    			
      			
      			
    			
    	}
	     <!--{/if}-->
	  

	$.ajax({
        //提交数据的类型 POST GET
        type:"POST",
        //提交的网址
        url:"{url question/ajaxedit}",
        //提交的数据
        data:data,
        //返回数据的格式
        datatype: "json",//"xml", "html", "script", "json", "jsonp", "text".
        //在请求之前调用的函数
        beforeSend:function(){
        	 ajaxloading("提交中...");
        },
        //成功返回之后调用的函数             
        success:function(data){
        	$(".progress").addClass("hide");
        	var data=eval("("+data+")");
           if(data.message=='ok'){
        	   var tmpmsg='问题编辑成功!';
        	  
        	   new $.zui.Messager(tmpmsg, {
        		   type: 'success',
        		   close: true,
           	    placement: 'center' // 定义显示位置
           	}).show();
        	   setTimeout(function(){
        		  
                   window.location.href=data.url;
               },1500);
           }else{
        	   new $.zui.Messager(data.message, {
            	   close: true,
            	    placement: 'center' // 定义显示位置
            	}).show();
           }
          
         
        }   ,
        //调用执行后调用的函数
        complete: function(XMLHttpRequest, textStatus){
        	  removeajaxloading();
        },
        //调用出错执行的函数
        error: function(){
            //请求出错处理
        }         
     });
})


</script>
<script type="text/javascript">
function delHtmlTag(str)
{
    return str.replace(/<[^>]+>/g,"");//去掉所有的html标记
}
function trim(str) {
	  return str.replace(/(^\s+)|(\s+$)/g, "");
	}
$(".txt_taginput").on(" input propertychange",function(){
	 var _txtval=$(this).val();
	 if(_txtval.length>1){
	
		 //检索标签信息
		 var _data={tagname:_txtval};
		 var _url="{url tags/ajaxsearch}";
		 function success(result){
			 console.log(result)
			 if(result.code==200){
				 console.log(_txtval)
				  $(".tagsearch").html("");
				for(var i=0;i<result.taglist.length;i++){
			
					 var _msg=result.taglist[i].tagname
					 
			           $(".tagsearch").append('<div class="tagitem" tagid="'+result.taglist[i].id+'">'+_msg+'</div>');
				}
				$(".tagsearch").show();
				$(".tagsearch .tagitem").click(function(){
					var _tagname=$.trim($(this).html());
					var _tagid=$.trim($(this).attr("tagid"));
					if(gettagsnum()>=5){
						alert("标签最多添加5个");
						return false;
					}
					if(checktag(_tagname)){
						alert("标签已存在");
						return false;
					}
					$(".dongtai .tags").append('<div class="tag"><span tagid="'+_tagid+'">'+_tagname+"</span><i class='fa fa-close'></i></div>");
					$(".dongtai .tags .tag  .fa-close").click(function(){
						$(this).parent().remove();
					});
					$(".tagsearch").html("");
					$(".tagsearch").hide();
					$(".txt_taginput").val("");
					});
		        
			 }
			 
		 }
		 ajaxpost(_url,_data,success);
	 }else{
			$(".tagsearch").html("");
			$(".tagsearch").hide();
	 }
})
	function checktag(_tagname){
		var tagrepeat=false;
		$(".dongtai .tags .tag span").each(function(index,item){
			var _tagnametmp=$.trim($(this).html());
			if(_tagnametmp==_tagname){
				tagrepeat=true;
			}
		})
		return tagrepeat;
	}
	function gettaglist(){
		var taglist='';
		$(".dongtai .tags .tag span").each(function(index,item){
			var _tagnametmp=$.trim($(this).attr("tagid"));
			taglist=taglist+_tagnametmp+",";
			
		})
		taglist=taglist.substring(0,taglist.length-1);
	
		return taglist;
	}
	function gettagsnum(){
      return $(".dongtai .tags .tag").length;
	}
	$(".tagsearch .tagitem").click(function(){
		var _tagname=$.trim($(this).html());
		if(gettagsnum()>=5){
			alert("标签最多添加5个");
			return false;
		}
		if(checktag(_tagname)){
			alert("标签已存在");
			return false;
		}
		$(".dongtai .tags").append('<div class="tag"><span>'+_tagname+"</span><i class='fa fa-close'></i></div>");
		$(".dongtai .tags .tag  .fa-close").click(function(){
			$(this).parent().remove();
		});
		$(".tagsearch").html("");
		$(".tagsearch").hide();
		$(".txt_taginput").val("");
		});
	$(".dongtai .tags .tag  .fa-close").click(function(){
		$(this).parent().remove();
	});
window.onload=function(){
	$("#askform .title ").focus();
	$(".tagchoose").click(function(){
		var _title=$("#qtitle").val();
		 var eidtor_content='';
  		if(isueditor==1){
  			  eidtor_content = editor.getContent();
  		}else{
  			eidtor_content = editor.wang_txt.html();
  		}
  		var mystr1=delHtmlTag(_title);
  		var mystr2=delHtmlTag(eidtor_content);
  		var mystr=trim(mystr2+mystr1);
  		mystr=mystr.replace(" ；","")
  		mystr=mystr.replace("&NBSP；","")
  		mystr=mystr.replace(" ；","")  //等几种 不同大小写情况
  		mystr = mystr.replace(/&nbsp;/ig,'');
  		console.log(mystr);
  		tagchoose(mystr);
	})
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
        $("#changecategory").html("更改");
        $('#myLgModal').modal('hide');
    }



</script>
<!--{template footer}-->