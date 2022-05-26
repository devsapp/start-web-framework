{template meta}
<div class="row">
  {if $topic['readmode']==2}
										<div class="col-md-24 text-center" style="font-size:13px;color:#41C074;margin-bottom:30px;text-align:center;">
阅读需要支付{$topic['price']}{$caifuzhiname}查看
</div>

{/if}
  {if $topic['readmode']==3}
									<div class="col-md-24 text-center" style="font-size:13px;color:#41C074;margin-bottom:30px;text-align:center;">
阅读需要支付{$topic['price']}元查看
</div>

{/if}

</div>

<center>
<input type="hidden" value="{$topic['id']}" id="txt_tid" />

<button class="layui-btn layui-btn-sm" id="payit">支付并查看</button>
<img src="" class="dasahngqrcode" />
</center>
<script>
layui.use(['jquery', 'layer','form'], function(){ 
	  var $ = layui.$ //重点处
	  ,layer = layui.layer;
	  $("#payit").click(function(){
			

			
			
			
		    var _tid=$("#txt_tid").val();
		  
		   
		    
		   $.ajax({
		        //提交数据的类型 POST GET
		        type:"POST",
		        //提交的网址
		        url:"{url topic/posttopicreward}",
		        //提交的数据
		        data:{tid:_tid},
		        //返回数据的格式
		        datatype: "text",//"xml", "html", "script", "json", "jsonp", "text".

		        //成功返回之后调用的函数
		        success:function(data){
		          
		        	data=$.trim(data);
		        	if(data==-2){
		        		layer.msg('游客先登录!');
		        	}
		        	if(data==-3){
		        		layer.msg('本人无需支付费用偷看!');
		        	}
		        	if(data==-4){
		        		layer.msg('付费阅读文章失败!');
		        	}
		        	if(data==-1){
		        		layer.msg('此文章不需要支付费用阅读!');
		        	}
		        	if(data==2){
		        		layer.msg('此文章您已经付费过了!');
		        	}
		        	if(data==0){
		        		layer.msg('{$caifuzhiname}不足!');
		        	
		        	}
		        	if(data==7){
		        		layer.msg('账户余额不足!');
		        	
		        	}
		        	if(data==1){
		        		//window.location.reload();
		        		window.parent.location.reload();
		        	}
		        }   ,
		       
		        //调用出错执行的函数
		        error: function(){
		            //请求出错处理
		        	layer.msg("请求异常")
		        }
		    });
	
})
});

</script>