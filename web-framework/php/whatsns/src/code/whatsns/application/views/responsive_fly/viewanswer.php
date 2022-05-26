
<div class="row">
<div class="col-md-24 text-center" style="font-size:13px;color:#41C074;margin-bottom:30px;">
此回答需要付费{$answer['reward']}元查看
</div>


</div>
{if $isvip}
<style>
.msg-tip{
 background:#fcf8e3;
 padding:10px;
 text-align:center;
 margin-bottom:10px;
 font-size:15px;
}
</style>
<div class="msg-tip">您当前剩余{$lastviewnum}张偷看卡</div>
{/if}
<div class="row text-center">
<input type="hidden" value="{$answer['id']}" id="txt_answerid" />

{if $this->user['viewanswertimes']>0}
<button class="btn-dashang btn btn-success">使用搜题包(剩余{eval echo $this->user['viewanswertimes'];}次)</button>
{else}
{if $lastviewnum}
<button class="btn-dashang btn btn-success">使用偷看卡</button>
{else}
<button class="btn-dashang btn btn-success">付费偷看</button>
{/if}
{/if}
<img src="" class="dasahngqrcode" />
</div>
<script>
$('[data-toggle="tooltip"]').tooltip('hide');


$(".btn-dashang").click(function(){
	

	
		
	
		    var _answerid=$("#txt_answerid").val();
		  
		   
		    
		   $.ajax({
		        //提交数据的类型 POST GET
		        type:"POST",
		        //提交的网址
		        url:"{url answerpay/ajaxpostanswerreward}",
		        //提交的数据
		        data:{answerid:_answerid},
		        //返回数据的格式
		        datatype: "text",//"xml", "html", "script", "json", "jsonp", "text".

		        //成功返回之后调用的函数
		        success:function(data){
		          
		        	data=$.trim(data);
		        	if(data==-2){
		        		alert('游客先登录!');
		        	}
		        	if(data==-1){
		        		alert('此问题不需要付费!');
		        	}
		        	if(data==2){
		        		alert('此问题您已经付费过了!');
		        	}
		        	if(data==0){
		        		alert('账户余额不足，先充值!');
		        	}
		        	if(data==1){
		        		//window.location.reload();
		        		window.parent.location.reload();
		        	}else{
			        	
		        		alert(data);
		        	}
		        }   ,
		       
		        //调用出错执行的函数
		        error: function(){
		            //请求出错处理
		        }
		    });
	
})
</script>