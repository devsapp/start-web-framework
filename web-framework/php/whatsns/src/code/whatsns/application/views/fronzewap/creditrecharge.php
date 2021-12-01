<!--{template header}-->

<section class="ui-container">
<!--{template user_title}-->

  <!-- 内容页面 -->  
    <div class="row">
                 <div class="col-sm-12">
                     <div class="dongtai">
                         <p>
                             <strong class="font-18 ui-txt-warning">
                            <p>您当前的财富值：<font color="#FC6603">{$user['credit2']}</font>,<strong>1元={$setting['recharge_rate']}财富值</strong></p>
 
                             </strong>
                         </p>
                        
                         <hr>
                      

 <form class="form-horizontal"  action="{url ebank/creditaliapytransfer}" method="post" >

        
      <div class="ui-form-item ui-form-item-show  ui-border-b">
            <label for="#">充值金额：</label>
            <input type="text" id="money" name="money"  value="" placeholder="必须为整数" >
        </div>
        
          {if $setting['openwxpay']==1}
      <div class="ui-btn-wrap">
    <button class="ui-btn-lg ui-btn-danger" type="button" onclick="check_form()" id="submit" name="submit" >
       微信充值
    </button>
</div>
{else}
  <button class="ui-btn-lg ui-btn-danger" type="button" disabled >
     网站还没设置微信支付
    </button>
   {/if}
  <div class="ui-btn-wrap">
    <button class="ui-btn-lg ui-btn-primary"  type="submit" id="alipaysubmit" name="alipaysubmit" >
       支付宝充值
    </button>
</div>
 </form>
                   
                     </div>
                 </div>


             </div>
  
</section>
<script type="text/javascript">
var _canchonzhi="{$setting['recharge_open']}";
function check(c)
{
    var r= /^[+-]?[1-9]?[0-9]*\.[0-9]*$/;
    return r.test(c);
}
    function check_form(){
        if(_canchonzhi==0){
       	 el2=$.tips({
	            content:'财富充值已关闭!',
	            stayTime:1500,
	            type:"info"
	        });
       	 
            return false;
        }
        var money_reg = /\d{1,4}/;
        var _money = $("#money").val();
        if('' == _money || !money_reg.test(_money) || _money>20000 ||  _money<=0){
         
        
            
       	 el2=$.tips({
	            content:'输入充值金额不正确!',
	            stayTime:1500,
	            type:"info"
	        });
       	 
            return false;
        }
        
        if(check(_money)){
        	   
          	 el2=$.tips({
   	            content:'金额不能为小数!',
   	            stayTime:1500,
   	            type:"info"
   	        });
          	 
               return false;
        }

        
        var posturl=g_site_url+"?user/ajaxpaycreditrecharge/"+_money+".html";


    	{if $signPackage==null}
      
        $.get(posturl, function(result){
           if(result.match("http")){
             window.location.href=result;
           }else{
        	   el2=$.tips({
     	            content:result,
     	            stayTime:2000,
     	            type:"success"
     	        });
           }
          });
    	return false;
    	{else}
    	var _openid="{$openId}";

    	var data={jine:_money,openid:_openid};
    	function success(result){
    		WeixinJSBridge.invoke(
    				'getBrandWCPayRequest',
    				result,
    				function(res){
    					$("#dialogdashang").dialog("hide");
    					var _tmps=res.err_msg.split(':');

    					if(_tmps[1]=='ok'){
    						 el2=$.tips({
    			      	            content:'积分充值成功!',
    			      	            stayTime:2000,
    			      	            type:"success"
    			      	        });
    					}else{
    						  el2=$.tips({
    			     	            content:res.err_desc,
    			     	            stayTime:2000,
    			     	            type:"success"
    			     	        });
    						return false;
    					}
    				}
    			);
    	}
        var posturl="{url user/ajaxpaycreditrecharge}";
    	ajaxpost(posturl,data,success);
    	{/if}
        
      
       
    }
</script>
<!--{template footer}-->