<!--{template header,admin}-->

<div style="width:100%; color:#000;">
    <div >
    <ol class="breadcrumb" style="margin-bottom:0px;">
  <li><a href="{url admin_main/stat}">后台首页</a></li>
  <li class="active">{$navtitle}</li>
</ol>
</div>
<div style="padding:8px;">
<div class="row" style="background:#ebebeb;padding:8px;margin-left:4px;margin-right:4px;">
 <div class="col col-md-12" >
 <div class="catselect" style="margin: 16px auto;">
  <label class="label label-info cat hand" onclick="setcat(this,-1)">分类不限</label>  
    <label class="label cat hand"  onclick="setcat(this,0)">插件</label>
      <label class="label cat hand"  onclick="setcat(this,1)">模板</label>
       <label class="label cat hand"  onclick="setcat(this,2)">模块</label>
    </div>
     <div class="priceselect" style="margin: 16px auto;">
  <label class="label label-info lprice hand" onclick="setprice(this,0)">价格不限</label>  
    <label class="label lprice hand" onclick="setprice(this,1)">免费</label>
      <label class="label lprice hand" onclick="setprice(this,2)">付费</label>
    </div>
    
<div class="row">
    <div class="col-md-6">
      <div class="input-group">
        <div class="input-control search-box has-icon-left has-icon-right search-example" id="searchboxExample">
          <input id="namekeywordword" type="search" class="form-control search-input empty" placeholder="搜索">
        </div>
        <span class="input-group-btn">
          <button class="btn btn-primary" type="button" onclick="selectresult()"><i class="icon icon-search"></i>搜索</button>
        </span>
      </div>
    </div>
    <div class="col-md-6">
      <a class="btn btn-warning" href="{url admin_market/mybuy}" target="_blank">查看已购列表</a>
    </div>
  </div>


 <div>
 
 </div>
 
 </div>
</div>

<div class="row" id="appshowlist" style="margin-top:16px;">
{template market_applist}
</div>
</div>
<script type="text/javascript">
var _curcat=-1;
var _curpriceid=0;
//选中分类选项
function setcat(_tar,_id){
	$(".catselect .label").removeClass("label-info");
	$(_tar).addClass("label-info");
	_curcat=_id;
	selectresult();
}
//选中当前价格选项
function setprice(_tar,_priceid){
	
	$(".priceselect .label").removeClass("label-info");
	$(_tar).addClass("label-info");
	_curpriceid=_priceid;
	selectresult();
}
//查询结果
function selectresult(){
	var _txt=$.trim($("#namekeywordword").val());
	var _data={'catid':_curcat,'priceid':_curpriceid,'word':_txt};
	var url="{url admin_market/selectapp}";
	function success(result){
       console.log(result);
       $("#appshowlist").html(result);
	}
	ajaxpost(url,_data,success,"text");
}

</script>
<!--{template footer,admin}-->
</div>