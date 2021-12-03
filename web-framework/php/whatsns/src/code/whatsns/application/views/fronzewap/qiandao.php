<!--{template header}-->
<section class="ui-notice">
    <i></i>
    <h4>活动规则：</h4>
    <ul>
    <li>  <p>一人领取一次，最多参与一次，人人都有奖！</p></li>
     
      
      
    </ul>
  
   
     
    <div class="ui-notice-btn">
   
      <button id="btnqiandao" onclick="qiandao()" class="ui-btn-primary ui-btn-lg">领取红包</button>
      
       
    </div>
    
</section>
<script>
var canqiandao=0;

function qiandao(){
	window.location.href="{url qiandao/gethongbao}";
	
}
</script>

{if $signPackage!=null}

<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"> </script>


<script>

  wx.config({
      debug: false,
      appId: '{$signPackage["appId"]}',
      timestamp: {$signPackage["timestamp"]},
      nonceStr: '{$signPackage["nonceStr"]}',
      signature: '{$signPackage["signature"]}',
      jsApiList: [
                  'checkJsApi',
        'hideAllNonBaseMenuItem',
        'getLocation'
       
        
       
        
      ]
  });

</script>

<script>
wx.ready(function () {
    wx.checkJsApi({
	      jsApiList: [
	       
	        'hideAllNonBaseMenuItem',
	        'getLocation'
	     
	      ],
	      success: function (res) {
	       // alert(JSON.stringify(res));
	      }
	    });
    wx.hideAllNonBaseMenuItem();
    

	    });
	    
	   
</script>
{/if}
<!--{template footer}-->