{loop $applist $app}
<div class="col col-md-3">

<div class="applist" {if $app['istuijian']}style="border:solid 2px #4caf50;min-height:125px;"{else}style="border:solid 2px #bbb;min-height:125px;"{/if}>
<div class="row" style="padding-top:8px;padding-bottom: 8px;padding-right:8px;">
<div class="col-md-4" style="text-align: center;">
<img src="{$app['image']}" style="border-radius:8px;margin: 0 auto;width:50px;height:50px;" />
<p style="margin-top: 4px;font-size:14px;font-weight:900;color:red;">
{if $app['price']==0}
限时免费
{/if}
{if $app['price']>=1}
{if $app['price']>0&&$app['youhuijia']==0}
￥{eval echo  sprintf("%.2f",substr(sprintf("%.3f", $app['price']), 0, -2));}
{/if}
{if $app['price']>0&&$app['youhuijia']>0}
￥{eval echo  sprintf("%.2f",substr(sprintf("%.3f", $app['youhuijia']), 0, -2));}
<span style="font-size: 12px;">(原价:{$app['price']}元)</span>
{/if}
{else}
￥{$app['price']}
{/if}
</p>
</div>

<div class="col-md-8">

<div>
{if $app['istuijian']}
<label style="font-size:10px;margin-right:8px;" class="label label-danger">推荐</label>
{/if}
{if $app['isguanfang']}
<label style="font-size:10px;" class="label label-success">官方</label>
{/if}
<span style="margin-left:4px;font-weight: 900;font-size:13px;">{$app['name']}</span>
</div>
<div style="font-size:12px;color:#bbb;padding-top:8px;padding-bottom:8px;">
{$app['jianjie']}
</div>
<div style="font-size:12px;">
{if $app['buylog']}
<a style="margin-right:6px;" data-toggle="tooltip" data-placement="top" title="购买时间:{$app['buytime']}"  class="btn btn-sm btn-success">已购</a>

{else}
<button style="margin-right:6px;" onclick="downapp(this,$app['id'])" class="btn btn-sm btn-danger">下载</button>

{/if}

<a target="_blank" href="{DEVDOMAIN}market/detail/{$app['id']}.html"  class="btn btn-sm btn-info">查看详情</a>
</div>

</div>

</div>
</div>

</div>
{/loop}
<div class="modal fade" id="buyapppop">
  <div class="modal-dialog" style="width:360px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
        <h4 class="modal-title">应用支付</h4>
      </div>
      <div class="modal-body">
        <div style="text-align: center">
        <h2 id="buyapp_name" style="font-size:18px;font-weight:900;margin-top:8px;"></h2>
        <img src="" id="payappqrcode" style="width:260px;height:260px;margin:16px auto;"/>
        <p style="font-size:18px;font-weight:900;color:red;margin-bottom:8px;">打开[支付宝APP]扫码支付<span id="buyapp_jine" style="margin:0px 4px;font-size:25px;font-weight:900;color:red;"></span>元</p>
        <p style="font-size:13px;margin-top:16px;color:blue;">支付成功后前往 我的已购列表中安装应用，<a  style="font-weight:900;margin-left:4px;" href="{url admin_market/mybuy}">点击去查看</a></p>
        </div>
      </div>
    
    </div>
  </div>
</div>
<div class="modal fade" id="buysuccess">
  <div class="modal-dialog modal-sm">
    <div class="modal-content" >
        <div class="modal-header">
       <h4 class="modal-title">购买成功</h4>
      </div>
        <div class="modal-body" style="text-align:center;">
             <div style="color:blue;font-weight:900;margin:16px auto;text-align:center;"> 购买成功，请前往已购列表中安装!</div> 
             <a class="btn btn-success" style="margin-bottom:8px;" href="{url admin_market/mybuy}">去已购列表查看</a>
     </div>
    </div>
  </div>
</div>
<script>

$('[data-toggle="tooltip"]').tooltip({
    placement: 'top'
});
//点击下载
function downapp(target,_appid){
	var _data={'appid':_appid};
	var _url="{url admin_market/buyapp}";
	function success(result){
      console.log(result);
      if(result.code==2001){
         //如果是弹出支付二维码，就显示支付
        
         $("#buyapp_name").html(result.data.data.name);
         $("#payappqrcode").attr("src","{SITE_URL}lib/getqrcode.php?data="+result.qr_code);
         $("#buyapp_jine").html(result.data.data.price);
          $("#buyapppop").modal("show");
      }else if(result.code==2000){
          //如果是购买成功，就跳转到已购列表页面
         $("#buysuccess").modal({
        	 keyboard : false,
        	 backdrop:false,
        	    show     : true
         });
      }else{
        alert(result.msg);
      }
      
	}
	ajaxpost(_url,_data,success);
}
</script>