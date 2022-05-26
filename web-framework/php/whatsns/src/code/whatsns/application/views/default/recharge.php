<!--{template header}-->
<link rel="stylesheet" media="all" href="{SITE_URL}static/css/bianping/css/space.css" />


<!--用户中心-->


    <div class="container person">

        <div class="row " >
            <div class="col-xs-17 main">
            <!-- 用户title部分导航 -->
              <!--{template user_title}-->
             <!-- title结束标记 -->
       <!-- 内容页面 -->
    <div class="row">
                 <div class="col-sm-22">
                     <div class="dongtai">
                         <p>
                             <strong class="font-18">我要充值【充值成功后刷新此页面】</strong>
                         </p>

                         <hr>

 <p>您当前的账户钱包：<font color="#FC6603">{eval echo $user['jine']/100}元</font></p>

 <form class="form-horizontal" action="{url ebank/aliapytransfer}" method="post" target="_blank">
 <div class="form-group">
          <p class="col-md-24 ">充值金额：</p>
          <div class="col-md-14">
             <input type="text" id="money" name="money"  value="" placeholder="必须为整数" class="form-control">
          </div>
        </div>

  <input type="hidden" name="myseek" id="myseek" value=""/>
        <div class="form-group">
        {if $setting['openwxpay']==1}
          <div class=" col-md-6">
             <input type="button" onclick=" check_form();" id="submit" name="submit" class="btn btn-danger" value="【微信扫一扫充值】" data-loading="稍候...">
          </div>
         {/if}
            <div class=" col-md-6">
            
             <input type="submit" id="alipaysubmit" name="alipaysubmit" class="btn btn-danger {if $setting['openwxpay']==1}mar-ly-1{/if} " value="支付宝充值" data-loading="稍候...">
          </div>
        </div>
        <img src="" class="dasahngqrcode hide" style="width:240px;height:240px;text-align:left;display:none;" />
       
        <h2 class="chongzhitishi hide" style="font-size:14px;color:#FC6603;text-align:left;margin-top:10px;">【微信扫码充值】充值成功后刷新此页面可查看最新钱包金额</h2>
 
 </form>

                     </div>
                 </div>


             </div>
            </div>

            <!--右侧栏目-->
            <div class="col-xs-7  aside ">




                <!--导航列表-->

               <!--{template user_menu}-->

                <!--结束导航标记-->


                <div>

                </div>


            </div>

        </div>

    </div>




<!--用户中心结束-->
<script type="text/javascript">
var _seekpay='';

var _Listen=null;
//监听是否支付
function seekpay(){
	_seekpay=$("#myseek").val();
	if(_seekpay==''){
		//$(".mydd").html("没有检索到");
		   return false;
	}
	
    
	var _cot=0;
	if(_Listen!=null){
		  return false;
	}
	 _Listen=setInterval(function(){
		++_cot;
		if(_cot>1000){
			
			
			window.clearInterval(_Listen);
			return false;
		}
		var _url="{url pay/ajaxrequestpayask}";
		   $.ajax({
		        //提交数据的类型 POST GET
		        type:"POST",
		        //提交的网址
		        url:_url,
		        //提交的数据
		        data:{name:_seekpay},
		        //返回数据的格式
		        datatype: "json",

		        //成功返回之后调用的函数
		        success:function(result){
		        
		       
			        var rs=$.parseJSON( result )
			   
			        if(rs.code==200){
			       
			        	window.clearInterval(_Listen)
			        window.location.reload();
			        }else{
				      
			        	
			        }

		        }   ,

		        //调用出错执行的函数
		        error: function(){
		            //请求出错处理
		        }
		    });
	},1000);
}
    function check_form(){
        var money_reg = /\d{1,4}/;
        var _money = $("#money").val();
        if('' == _money || !money_reg.test(_money) || _money>20000 ||  _money<1){

            new $.zui.Messager('输入充值金额不正确!金额在1-2000元!', {
           	   close: true,
           	    placement: 'center' // 定义显示位置
           	}).show();
            return false;
        }
        var timestamp = Date.parse(new Date());
		   $.ajax({
		        //提交数据的类型 POST GET
		        type:"POST",
		        //提交的网址
		        url:"{url pay/ajaxweixintransfer}",
		        //提交的数据
		        data:{submit:'submit', type:'chongzhi',money:_money,time:timestamp},
		        //返回数据的格式
		        datatype: "text",//"xml", "html", "script", "json", "jsonp", "text".

		        //成功返回之后调用的函数
		        success:function(data){
		        	if(data=='0'){
		        		//财富充值服务已关闭，如有问题，请联系管理员!
		        		 new $.zui.Messager('财富充值服务已关闭，如有问题，请联系管理员!', {
                      	   close: true,
                      	    placement: 'center' // 定义显示位置
                      	}).show();
		        	}else if(data=='1'){
		        		//输入充值金额不正确!充值金额必须为整数，且单次充值不超过20000元!
		        		 new $.zui.Messager('输入充值金额不正确!充值金额必须为整数，且单次充值不超过20000元!', {
                      	   close: true,
                      	    placement: 'center' // 定义显示位置
                      	}).show();
		        	}else{
		        		
		        		 _seekpay="chongzhi_0_"+ "{$user['uid']}"+"_"+_money+"_"+timestamp;
		        		   $("#myseek").val(_seekpay);
		        		 seekpay();
		        		 var url=g_site_url+'lib/getqrcode.php?data='+data;
	                     $(".dasahngqrcode").removeClass("hide").attr("src",url).css({"display":"block"});
	                     $(".chongzhitishi").removeClass("hide");
		        	}



		        }   ,

		        //调用出错执行的函数
		        error: function(){
		            //请求出错处理
		        }
		    });

        return false;
    }
</script>
<!--{template footer}-->