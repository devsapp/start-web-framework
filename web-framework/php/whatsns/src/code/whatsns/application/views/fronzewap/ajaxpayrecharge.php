<!--{template header}-->
<section class="ui-notice">
    <i class="ui-icon-cart"></i>
    <p class="ui-txt-highlight">您的充值金额为{$money}元</p>
    <div class="ui-notice-btn">
    {if $lasturl}
     <a href="{$lasturl}" class="ui-btn-primary ui-btn-lg">确认充值</a>
    {else}
     <button onclick="bestcallpay()" class="ui-btn-primary ui-btn-lg">确认充值</button>
    {/if}
       
    </div>
</section>
 {if !$lasturl}
     <script type="text/javascript">
	//调用微信JS api 支付
	function bestjsApiCall()
	{
		WeixinJSBridge.invoke(
			'getBrandWCPayRequest',
			{$model['JsApi']},
			function(res){

				var _tmps=res.err_msg.split(':');

				if(_tmps[1]=='ok'){
					 el2=$.tips({
		      	            content:'充值成功!',
		      	            stayTime:2000,
		      	            type:"success"
		      	        });
					 window.location.href=g_site_url+"index.php?user/recharge.html";
				}else{
					alert(JSON.stringify(res));return false;
				}

			}
		);
	}

	function bestcallpay()
	{
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', bestjsApiCall, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', bestjsApiCall);
		        document.attachEvent('onWeixinJSBridgeReady', bestjsApiCall);
		    }
		}else{
			bestjsApiCall();
		}
	}
	</script>
 {/if}