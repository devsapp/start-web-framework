
<div class="row">
  {if $topic['readmode']==2}
										<div class="col-md-24 text-center" style="font-size:13px;color:#41C074;margin-bottom:30px;">
阅读需要支付{$topic['price']}积分查看
</div>

{/if}
  {if $topic['readmode']==3}
									<div class="col-md-24 text-center" style="font-size:13px;color:#41C074;margin-bottom:30px;">
阅读需要支付{$topic['price']}元查看
</div>

{/if}

</div>

<div class="row text-center">
<input type="hidden" value="{$topic['id']}" id="txt_tid" />

<button class="btn-dashang btn btn-success">支付并查看</button>
<img src="" class="dasahngqrcode" />
</div>
<script>
$('[data-toggle="tooltip"]').tooltip('hide');


$(".btn-dashang").click(function(){
	

	
		
	
		    var _tid=$("#txt_tid").val();
		  
		   
		    
		   $.ajax({
		        //提交数据的类型 POST GET
		        type:"POST",
		        //提交的网址
		        url:"{SITE_URL}/index.php?topic/posttopicreward",
		        //提交的数据
		        data:{tid:_tid},
		        //返回数据的格式
		        datatype: "text",//"xml", "html", "script", "json", "jsonp", "text".

		        //成功返回之后调用的函数
		        success:function(data){
		          
		        	data=$.trim(data);
		        	if(data==-2){
		        		alert('游客先登录!');
		        	}
		        	if(data==-3){
		        		alert('本人无需支付费用偷看!');
		        	}
		        	if(data==-4){
		        		alert('付费阅读文章失败!');
		        	}
		        	if(data==-1){
		        		alert('此文章不需要支付费用阅读!');
		        	}
		        	if(data==2){
		        		alert('此文章您已经付费过了!');
		        	}
		        	if(data==0){
		        		alert('财富值不足，先充值或者去赚财富值!');
		        		window.location.href="{url user/creditrecharge}";
		        	}
		        	if(data==7){
		        		alert('账户余额不足，请先充值!');
		        		window.location.href="{url user/recharge}";
		        	}
		        	if(data==1){
		        		window.location.reload();
		        	}
		        }   ,
		       
		        //调用出错执行的函数
		        error: function(){
		            //请求出错处理
		        }
		    });
	
})
</script>