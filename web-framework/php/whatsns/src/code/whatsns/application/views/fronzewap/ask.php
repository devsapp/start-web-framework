<!--{template meta}-->
<link rel="stylesheet" media="all" href="{SITE_URL}static/css/common/commtag.css" />
<style>
.userspaceheader {
    background: #fff;
    color: #333;
    box-shadow: 1px 1px 1px 1px #ebebeb;
}


.moreinfo{
	color:#0085ee;
padding-left:.16rem;
    cursor: pointer;
text-align: left;
margin-top:.1rem;
}
.moreinfoitem{
	display:none;
}
.mycny{
    color: #ff8f00;
    font-size: 17px;
    position: absolute;
    top: .13rem;
    left: .16rem;
}
#qxianjin{
	padding-left:.16rem;
}
#login_form{
margin-top:.03rem;
}
.askxuanshang .ui-label{
border: 1px solid #ff7f0d;
color: #ff7f0d;
}
.askxuanshang .ui-label.active{
border: 1px solid #ea6f5a;
    color: #fff;
    background: #ea6f5a;
}

</style>
<section class="ui-container mar-t-01" >



<div class="ui-form ui-border-t">
        <form id="login_form" onsubmit="return false;">
        <input type="hidden"  id="forward" name="return_url" value="{$forward}">

            <div class="ui-form-item ui-form-item-pure ui-border-b">
                <input  {if $this->setting['openwxpay']!=1&&isset($touser)&&$touser['mypay']>0} readonly{/if} name="title" id="qtitle" value="{$word}" maxlength="50" type="text" placeholder="标题简短，言简意赅，问号结尾">
                <a href="#" class="ui-icon-close"></a>
            </div>
            <div class=" ui-form-item-pure ui-border-b">
           <!--{template editor}-->
 <style>
.editor_container {
    box-shadow:none;
}
            </style>
            </div>



             <div class="ui-form-item ui-form-item-r ui-border-b">
            <label>分类</label>
            <div class="ui-select">
                              <select  name="srchcategory" id="srchcategory">

                              {$catetree}
                              </select>
            </div>
        </div>



            <!--{if $iswxbrower==null&&$setting['code_ask']&&$user['credit1']<$setting['jingyan']}-->
  <div class="ui-form-item ui-form-item-pure ui-border-b">

 {template code}
  </div>
   <!--{/if}-->
   <div class="moreinfo hide">增加更多信息<i class="fa fa-angle-down"></i></div>
   <div class="ui-form-item ui-form-item-r ui-border-b moreinfoitem hide">
            <label>财富悬赏</label>
            <div class="ui-select">
                <select name="givescore" id="scorelist">
                   <option selected="selected" value="0">0</option><option value="3">3</option><option value="5">5</option><option value="10">10</option><option value="15">15</option><option value="30">30</option><option value="50">50</option><option value="80">80</option><option value="100">100</option>
                </select>
            </div>
        </div>

        
         <!--{if $user['uid']}-->
            <div class="ui-form-item ui-form-item-switch ui-border-b moreinfoitem hide">
                <p>
                    匿名提问
                </p>
                <label class="ui-switch">
                   <input type="checkbox" name="hidanswer" id="hidanswer" value="1" />
                </label>
            </div>
             <!--{/if}-->
       
             <div class=" moreinfoitem hide" style="height: auto;line-height:auto;">
                   <div class="form-group" style="padding:0 15px;">

          <div class=" dongtai ">
          <div class="tags">
      
          </div>
            <input type="text" style="border: solid 1px #0085ee;" autocomplete="off"  data-toggle="tooltip" data-placement="bottom" title="" placeholder="检索标签，最多添加5个,添加标签更容易被回答" data-original-title="检索标签，最多添加5个" name="topic_tag" value=""  class="txt_taginput" >
            <i class="fa fa-search" style="color:#0085ee"></i>
           <div class="tagsearch">
        
          
           </div>
            
          </div>
      
</div>
            </div>
            <div class="ui-btn-wrap">
            
               <input type="hidden" name="authoryue" id="authoryue" value="{echo $user['jine']/100;}"/>
            <input type="hidden" name="myseek" id="myseek" value=""/>
             <input type="hidden" name="cid" id="cid"/>
                    <input type="hidden" name="cid1" id="cid1" value="0"/>
                    <input type="hidden" name="cid2" id="cid2" value="0"/>
                    <input type="hidden" name="cid3" id="cid3" value="0"/>
                    <input type="hidden" value="{$askfromuid}" id="askfromuid" name="askfromuid" />
 <input type="hidden" name="xianjin" id="qxianjin" value="0" placeholder="设置悬赏，若余额不足自动唤起支付">
                <input type="hidden" id="tokenkey" name="tokenkey" value='{$_SESSION["addquestiontoken"]}'/>
                  <button id="asksubmit"  class="ui-btn-lg ui-btn-primary">
                                            提交问题
                </button>

            </div>
             <div class="ui-btn-wrap mydd">
            
             </div>
        </form>
    </div>

</section>

<script>
$(".askxuanshang .ui-label").click(function(){
	$(".askxuanshang .ui-label").removeClass('active');
	$(this).addClass("active");
	$('#qxianjin').val($(this).attr("val"));
	
});
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
$(".close").click(function(){
	$('#agreemodel').hide();
});
$("#showadreeitem").click(function(){
	$('#agreemodel').show();
}
);
$(".moreinfo").click(function(){
	$(".moreinfoitem").show();
	$(".moreinfo").hide();
})
	getcat();

function getcat(){

	var sv=$("#srchcategory").val();

	 $.ajax({
	        //提交数据的类型 POST GET
	        type:"POST",
	        //提交的网址
	        url:"{url question/ajaxgetcat}",
	        //提交的数据
	        data:{category:sv},
	        //返回数据的格式
	        datatype: "json",//"xml", "html", "script", "json", "jsonp", "text".
	      //在请求之前调用的函数
	        beforeSend:function(){

	        },
	        //成功返回之后调用的函数
	        success:function(data){

	        	var data=eval("("+data+")");

	        	  if(data.message=='ok'){
	        		  $("#cid").val(data.cid);
	        		  $("#cid1").val(data.cid1);
	        		  $("#cid2").val(data.cid2);
	        		  $("#cid3").val(data.cid3);

	        	  }else{
	        		  el2=$.tips({
          	            content:'分类不存在，估计是缓存引起',
          	            stayTime:1000,
          	            type:"info"
          	        });
	        	  }
	        }   ,

	        //调用执行后调用的函数
	        complete: function(XMLHttpRequest, textStatus){

	        },

	        //调用出错执行的函数
	        error: function(){

	            //请求出错处理
	        }
	    });
}
$("#srchcategory").change(function(){
	getcat();

})
function bytes(str) {
    var len = 0;
    for (var i = 0; i < str.length; i++) {
        if (str.charCodeAt(i) > 127) {
            len++;
        }
        len++;
    }
    return len;
}

$("#asksubmit").tap(function(){
	var _tmpdata=checkdata();
	if(!_tmpdata){
		return false;
	}
	   var money_reg = /\d{1,4}/;
       var _money =  parseFloat($.trim($("#qxianjin").val()));
       var _yue=parseFloat($.trim($("#authoryue").val()));
       if('' == _money){
       	_money=0;
       }
 
    	   _money=parseFloat(_money);
    	   console.log(_money)
       if(_money==0){
         
     		tijiao();
        }else{
            if(_yue>=_money){
            	 
            	tijiao();
            	  return false;
            }
            $("#topayask").addClass("show");

        }
          return false;

      
 
})
function cancelpay(){
	$("#topayask").removeClass("show");

}
var submit=false;
function checkdata(){
	if(gettagsnum()>5){
        alert("最多添加5个标签");
        return false;
   	}
   	 var _tagstr=gettaglist();
	 var qtitle = $("#qtitle").val();
    if (bytes($.trim(qtitle)) < 8 || bytes($.trim(qtitle)) > 100) {


        el2=$.tips({
	            content:'问题标题长度不得少于4个字，不能超过50字！',
	            stayTime:1500,
	            type:"info"
	        });
        $("#qtitle").focus();
        return false;
    }

    {if $user['uid']}
    //检查财富值是否够用
    var offerscore = 0;
    var selectsocre = $("#givescore").val();
	 if ($('#hidanswer').attr('checked')) {
        offerscore += 10;
    }
    offerscore += parseInt(selectsocre);
    if (offerscore > $user['credit2']) {

      el2=$.tips({
          content:'你的财富值不够!',
          stayTime:1000,
          type:"info"
      });
            return false;
    }
    {/if}

 
    	// var eidtor_content= editor.getContent();
	 // 获取编辑器区域
        var _txt = editor.wang_txt;
     // 获取 html
        var eidtor_content =  _txt.html();
	 var _hidanswer=0;
	 if ($('#hidanswer').attr('checked')) {
		 _hidanswer=1;
	 }

	   var money_reg = /\d{1,4}/;
       var _money =  parseFloat($("#qxianjin").val());
       if('' == _money){
       	_money=0;
       }
	  <!--{if $setting['code_ask']}-->
	  var data={
			  title:$("#qtitle").val(),
			  description:eidtor_content,
			  cid:$("#cid").val(),
			  cid1:$("#cid1").val(),
			  cid2:$("#cid2").val(),
			  cid3:$("#cid3").val(),
			  givescore:$("#scorelist").val(),
			  hidanswer:_hidanswer,
			  askfromuid:$("#askfromuid").val(),
			  tokenkey:$("#tokenkey").val(),
			  jine:_money,
			  tags:_tagstr,
 			code:$("#code").val()
 	}
	    <!--{else}-->
		var data={
				  title:$("#qtitle").val(),
   			  description:eidtor_content,
   			  cid:$("#cid").val(),
   			  cid1:$("#cid1").val(),
   			  cid2:$("#cid2").val(),
   			  cid3:$("#cid3").val(),
   			  givescore:$("#scorelist").val(),
   			tokenkey:$("#tokenkey").val(),
   			  hidanswer:_hidanswer,
   			jine:_money,
   		 tags:_tagstr,
   			  askfromuid:$("#askfromuid").val()



   	}
	     <!--{/if}-->
		     return data;
}
function tijiao(){
	
 	
		     
if(submit==true){
	
	return false;
}
var _tmpdata=checkdata();
if(!_tmpdata){
	return false;
}
submit=true;
	    	   var el='';
	$.ajax({
       //提交数据的类型 POST GET
       type:"POST",
       //提交的网址
       url:"{url question/ajaxadd}",
       //提交的数据
       data:_tmpdata,
       async: false,
       //返回数据的格式
       datatype: "json",//"xml", "html", "script", "json", "jsonp", "text".
       //在请求之前调用的函数
       beforeSend:function(){
    	  
    	   el=$.loading({
    	        content:'加载中...',
    	    })
       },
       //成功返回之后调用的函数
       success:function(data){
    	   el.loading("hide");

       	var data=eval("("+data+")");
          if(data.message=='ok'){
              $("#asksubmit").attr("disabled",true);
        	  submit=true;
       	   var tmpmsg='提问成功!';
       	   if(data.sh=='1'){
       		   tmpmsg='问题发布成功！为了确保问答的质量，我们会对您的提问内容进行审核。请耐心等待......';
       	   }

           el2=$.tips({
               content:tmpmsg,
               stayTime:1500,
               type:"info"
           });
       	   setTimeout(function(){

                window.location.href=data.url;
              },1500);
          }else{
        	  submit=false;
       	   el2=$.tips({
               content:data.message,
               stayTime:1500,
               type:"info"
           });
          }


       }   ,
       //调用执行后调用的函数
       complete: function(XMLHttpRequest, textStatus){
    	   
    	   el.loading("hide");
    	   return false;
       },
       //调用出错执行的函数
       error: function(){
           //请求出错处理
       }
    });
	return false;
}
</script>
<script>
var _seekpay='';
seekpay();
var _Listen=null;
</script>
<!--{template footer}-->