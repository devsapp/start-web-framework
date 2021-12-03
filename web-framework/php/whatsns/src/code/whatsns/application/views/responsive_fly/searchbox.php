<div class="layui-show-sm layui-show-xs layui-hide-md " style="background: #fff;padding:10px;margin-bottom:15px;">
<div style="margin:15px 10px;border:solid 1px #e6e6e6;">
  <input value="{if $word}{$word}{/if}" style="width:80%;display:inline-block;border:none;" type="text" id="thesearchword" required  lay-verify="required" placeholder="输入关键词" autocomplete="off" class="layui-input">   
  <span id="searchbox" style="float:right;position:relative;top:4px;margin-right:4px;"><i style="font-size:20px;margin-left:5px;position:relative;top:3px;" class="layui-icon layui-icon-search"></i></span>
</div>
</div>
<script>
layui.use(['jquery', 'layer'], function(){

	  var $ = layui.$ //重点处
	  ,layer = layui.layer;
	   $("#searchbox").click(function(){
		   var _word=$.trim($("#thesearchword").val());
		   if(_word==''){
			   layer.msg("搜索关键词不能为空");
return false;
		   }
		window.location.href="{url question/search}"+"?word="+_word;
		   return false;
	  })
});
</script>