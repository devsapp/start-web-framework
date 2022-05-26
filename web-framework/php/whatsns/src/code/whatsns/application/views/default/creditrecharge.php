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
                 <div class="col-sm-24">
                     <div class="dongtai">
                         <p>
                             <strong class="font-18">积分充值【积分充值成功后刷新此页面】</strong>
                         </p>
                        
                         <hr>
                      
 <p>您当前的财富值：<font color="#FC6603">{$user['credit2']}</font>,<strong>1元={$setting['recharge_rate']}财富值</strong></p>
 
 <form class="form-horizontal" action="{url ebank/creditaliapytransfer}" method="post">
 <div class="form-group">
          <p class="col-md-24 ">充值金额：</p>
          <div class="col-md-6">
             <input type="text" id="money" name="money"  autocomplete="off"  value="" placeholder="必须为整数" class="form-control">
          </div>
        </div>
     
        
        <div class="form-group">
        {if $setting['openwxpay']==1}
          <div class=" col-md-6">
             <input type="button" onclick=" check_form();" id="submit" name="submit" class="btn btn-success" value="【微信扫一扫充值】" data-loading="稍候..."> 
          </div>
         {/if}
            <div class=" {if $setting['openwxpay']==1} col-md-offset-2  {/if} col-md-6">
             <input type="submit" id="alipaysubmit" name="alipaysubmit" class="btn btn-success {if $setting['openwxpay']==1}mar-ly-1{/if} " value="支付宝充值" data-loading="稍候..."> 
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
    function check_form(){
        var money_reg = /\d{1,4}/;
        var _money = $("#money").val();
        if('' == _money || !money_reg.test(_money) || _money>20000 ||  _money<=0){
         
            new $.zui.Messager('输入充值金额不正确!充值金额必须为整数，且单次充值不超过20000元!', {
           	   close: true,
           	    placement: 'center' // 定义显示位置
           	}).show();
            return false;
        }
        
		   $.ajax({
		        //提交数据的类型 POST GET
		        type:"POST",
		        //提交的网址
		        url:"{SITE_URL}/?ebank/weixintransfer",
		        //提交的数据
		        data:{submit:'submit', type:'creditchongzhi',money:_money},
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