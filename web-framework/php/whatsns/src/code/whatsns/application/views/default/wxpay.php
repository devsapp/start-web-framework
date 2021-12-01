<style>
.btn-pay{
	width:60px;
    height:30px;
   margin-top:10px;
   padding:0px;
       color: #ea644a;
    font-weight: 600;
}
.modal-dialog .modal-body {
    padding: 20px;
    font-size: 12px;
    overflow: hidden;
}
#inputmoney{

    width: 100%;
    padding: 0 10px 10px 5px;
  margin-top: 10px;
    margin-bottom: 0;
    border: none;
    border-bottom: 1px solid #d9d9d9;
    font-size: 20px;
    font-weight: normal;
    line-height: 30px;
    overflow: hidden;
    text-align: center;
    text-overflow: ellipsis;
    white-space: nowrap;
    border-radius: 0;
    box-shadow: none;

}
.dasahngqrcode{
	width:150px;
    height:150px;
    display:none;
    margin:15px auto;
border:solid 1px #ccc;
}
.btn-dashang,.btn-dashang:hover{
color: #f5f5f5;
	    border-radius: 2px;
      width: 80%;
    margin: 10px auto;
}
.pay_success{
margin-top:15px;
margin-bottom:15px;
text-align:center;
font-size:20px;
color:red;
}
.pay_success .fa{
	margin-right:5px;
}
.btn-zhifubao,.btn-zhifubao:hover{
    color: #f5f5f5;
    background-color: #5495fb;
    border-color: #3280fc;
    }
</style>

<div class="row wxpayblock">
<div class="col-md-8 text-center">
<button data-placement="bottom" title="打赏1元" data-toggle="tooltip" data-original-title="打赏1元" class="btn  btn-pay defaultpay" val="1">1元</button>
</div>
<div class="col-md-8 text-center">
<button data-placement="bottom" title="打赏2元" data-toggle="tooltip" data-original-title="打赏2元"  class="btn btn-pay defaultpay" val="2">2元</button>
</div>
<div class="col-md-8 text-center">
<button data-placement="bottom" title="打赏5元" data-toggle="tooltip" data-original-title="打赏5元"  class="btn btn-pay defaultpay" val="5">5元</button>
</div>
<div class="col-md-8 text-center mar-t-05">
<button data-placement="bottom" title="打赏10元" data-toggle="tooltip" data-original-title="打赏10元"  class="btn btn-pay defaultpay" val="10">10元</button>
</div>
<div class="col-md-8 text-center mar-t-05">
<button data-placement="bottom" title="打赏100元" data-toggle="tooltip" data-original-title="打赏100元"  class="btn btn-pay defaultpay" val="100">100元</button>
</div>
<div class="col-md-8 text-center mar-t-05">
<button data-placement="bottom" title="输入其它金额打赏" data-toggle="tooltip" data-original-title="输入其它金额打赏"  class="btn btn-pay btn-other">其它</button>
</div>
</div>
<div class="row text-center inputmoney wxpayblock">


    <input type="number" oninput="change()" onpropertychange="change()"  id="inputmoney" placeholder="金额在1-200元">


</div>
 <form class="form-horizontal" action="{url ebank/shangaliapytransfer}" method="post"  target="_blank" onsubmit="return checkselect()">
<div class="row text-center">
<input type="hidden" value="" name="money" id="txt_money" />
<input type="hidden" value="{$type}" name="s_type" id="txt_type" />
<input type="hidden" value="{$typevalue}" name="s_typeid" id="txt_typevalue" />
<input type="hidden" value="{$touser}" name='s_uid' id="txt_touser" />
<div class=" btn btn-success btn-dashang btn-block mar-t-1 wxpayblock" onclick="dashang()">微  信<span class="payjine"></span></div>

<button type="submit" name="alipaysubmit" class=" btn btn-success btn-block btn-dashang mar-t-1 wxpayblock btn-zhifubao" onclick="zhifubao()">支付宝<span class="payjine"></span></button>

<img src="" class="dasahngqrcode" />
<div class="pay_success"></div>
</div>
 </form>

<script>
$(".pay_success").html('');
$('[data-toggle="tooltip"]').tooltip('hide');

var _val=0;
var _input=0;
function change(){
	var re=/^\d+(\.\d+)?$/;
	var moy=$("#inputmoney").val();
	if(moy==''){
		return false;
	}
	  if (!re.test(moy))
	    {
			new $.zui.Messager('请输入正确的金额。', {
			    icon: 'heart',
			    placement: 'bottom' // 定义显示位置
			}).show();
			_input=0;
			return false;
	    }else{
	    	if(moy<1||moy>200){
	    		new $.zui.Messager('打赏金额在1-200元之间', {
				    icon: 'heart',
				    placement: 'bottom' // 定义显示位置
				}).show();
	    		_input=0;
				return false;
	    	}else{
	    		_input=moy;
		    	$("#txt_money").val(_input);
		    	$(".payjine").html('('+_input+'元)');
	    	}

	    }

}
function checkselect(){
	if(_val==0&&_input==0){


		new $.zui.Messager('打赏金额在在1-200元之间。', {
		    icon: 'heart',
		    placement: 'center' // 定义显示位置
		}).show();
		return false;
	}
}
$("#inputmoney").hide();
$(".btn-other").click(function(){
	$("#txt_money").val("");
	$("#inputmoney").val("");
	$("#inputmoney").show();
});
$(".defaultpay").click(function(){
	$("#inputmoney").val("");
	$("#inputmoney").hide();
	_val=$(this).attr("val");
	$("#txt_money").val(_val);
	$(".payjine").html('('+_val+'元)');
})
function isInteger(obj) {
    reg = /^[-+]?\d+$/;
    if (!reg.test(obj)) {
        return false;
    } else {

//这里加入
if(obj*1>0)
return true;
else
return false;

        //return true;
    }
}
function dashang(){
	if(_val==0&&_input==0){


		new $.zui.Messager('打赏金额在在1-200元之间', {
		    icon: 'heart',
		    placement: 'bottom' // 定义显示位置
		}).show();
	}else{
		var tmvalue=_input==0? _val:_input;
		$("#txt_money").val(_input);
		 var _type=$("#txt_type").val();
		    var _typevalue=$("#txt_typevalue").val();
		    var _touser=$("#txt_touser").val();


		   $.ajax({
		        //提交数据的类型 POST GET
		        type:"POST",
		        //提交的网址
		        url:"{url user/ajaxgetpaycode}",
		        //提交的数据
		        data:{type:_type,typevalue:_typevalue,touser:_touser,money:tmvalue},
		        //返回数据的格式
		        datatype: "json",//"xml", "html", "script", "json", "jsonp", "text".

		        //成功返回之后调用的函数
		        success:function(result){
			        var rs=$.parseJSON( $.trim(result) )
			        var _attachname=rs.proid;
		        	 var url=g_site_url+'lib/getqrcode.php?data='+rs.data;
                        $(".dasahngqrcode").attr("src",url).css({"display":"block"});
                        $(".dasahngqrcode").show();
                        $(".pay_success").html('');
                        $(".wxpayblock").remove();
                        getresult(_attachname);

		        }   ,

		        //调用出错执行的函数
		        error: function(){
		            //请求出错处理
		        }
		    });
	}
}
</script>