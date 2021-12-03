<!--{template header}-->
<script src="{SITE_URL}static/js/admin.js" type="text/javascript"></script>
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;公告管理</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<div class="alert  alert-warning">{$message}</div>
<!--{/if}-->

    <table class="table" >
        <tr class="header"><td colspan="5">公告列表</td></tr>
        <tr class="header" align="center">
           <td  >认证类型</td>
            <td  >用户名/企业名称</td>
            <td  >身份证/组织机构代码</td>
            <td  >认证介绍</td>
              <td  >附件一</td>
                <td  >附件二</td>
            <td  >编辑</td>
        </tr>
        <!--{loop $vertifylist $vertify}-->
        <tr align="center" class="smalltxt">

            <td  class="altbg2">
            {if $vertify['type']==0}
                         个人认证
            {/if}
            {if $vertify['type']==1}
                         企业认证
            {/if}
            </td>
            <td  class="altbg2">{$vertify['name']}</td>
            <td class="altbg2">{$vertify['id_code']}</td>
             <td class="altbg2">{$vertify['jieshao']}</td>
               <td class="altbg2">
               {if $vertify['zhaopian1']==''}

               {else}
                <a href="{$vertify['zhaopian1']}" data-toggle="lightbox" class="btn btn-primary">查看图片</a>
               {/if}

               </td>
                 <td class="altbg2">

                 {if $vertify['zhaopian2']!=''}
                 <a href="{$vertify['zhaopian2']}" data-toggle="lightbox" class="btn btn-primary">查看图片</a>
                 {/if}
                   </td>
            <td class="altbg2">
            <input type="hidden" value="{$vertify['id']}" id="vid">
             <input type="hidden" value="{$vertify['uid']}" id="vuid">
             <input type="hidden" value="{$vertify['type']}" id="type">
             <input type="hidden" value="{$vertify['name']}" id="name">
              <input type="hidden" value="{$vertify['id_code']}" id="idcode">
               <input type="hidden" value="{$vertify['jieshao']}" id="jieshao">
                <input type="hidden" value="{$vertify['status']}" id="status">
                <input type="hidden" value="{$vertify['time']}" id="time">
                <input type="hidden" value="{$vertify['zhaopian1']}" id="h_zhaopian1">
                <input type="hidden" value="{$vertify['zhaopian2']}" id="h_zhaopian2">
                   <input type="hidden" value="{eval echo trim($vertify['vcategory'],',');}" id="vcategory">
        <button style="background:#3280fc;" class="btn btn-primary btnshenhe" >查看详情</button>
            </td>
        </tr>
        <!--{/loop}-->
        <!--{if $departstr}-->
        <tr class="smalltxt">
            <td class="altbg2" colspan="5" align="right"><div class="pages">{$departstr}</div></td>
        </tr>
        <!--{/if}-->

    </table>

<!-- 设置付费金额 -->
<div class="modal model_vertify " >
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">

<button type="button" data-dismiss="modal" class="close">×</button>
</div>
<div class="modal-body">
<p style="display:none"><span id="m_id"></span></p>
<p style="display:none"><span id="m_uid"></span></p>
<p>认证类型:<span id="m_type"></span></p>
<p>认证分类:<span id="m_vcategory"></span></p>
<p><span id="m_typeid" style="display:none;"></span></p>
<p><span id="m_pname"></span><span id="m_name"></span></p>
<p><span id="m_idname"></span><span id="m_idcode"></span></p>
<p>认证介绍:<span id="m_jieshao"></span></p>
<p>附件一:<span id="m_zhaopian1"></span></p>
<p>附件二:<span id="m_zhaopian2"></span></p>
<p>提交时间:<span id="m_time"></span></p>
  <textarea style="width:488px;height:89px;margin-top:10px;display:none;" id="m_bohui"></textarea>
</div>
 <div class="modal-footer">

 </div>
 </div>
 </div>
 </div>
 <script>
$(".btnshenhe").click(function(){
	$(".model_vertify").modal("show");
	var _id=$(this).parent().find("#vid").val();
	var _uid=$(this).parent().find("#vuid").val();
	var _type=$(this).parent().find("#type").val();
	var _name=$(this).parent().find("#name").val();
	var _idcode=$(this).parent().find("#idcode").val();
	var _jieshao=$(this).parent().find("#jieshao").val();
	var _status=$(this).parent().find("#status").val();
	var _vcategory=$(this).parent().find("#vcategory").val();
	var _time=$(this).parent().find("#time").val();
	var _zhaopian1=$(this).parent().find("#h_zhaopian1").val();
	var _zhaopian2=$(this).parent().find("#h_zhaopian2").val();
	 $("#m_id").html(_id);
	 $("#m_uid").html(_uid);
	 $("#m_typeid").html(_type);
	switch(_type){
	case '0':
		 $("#m_type").html("个人认证");
	     $("#m_pname").html("用户名：");
	     $("#m_name").html(_name);
	     $("#m_idname").html("身份证号码：");
	     $("#m_idcode").html(_idcode);
		break;
	case '1':
		 $("#m_type").html("企业认证");
		 $("#m_pname").html("企业名称：");
	     $("#m_name").html(_name);
	     $("#m_idname").html("组织机构代码证号：");
	     $("#m_idcode").html(_idcode);
		break;
	}
	 $("#m_jieshao").html(_jieshao);

	 console.log(_vcategory)
	$("#m_vcategory").html(_vcategory);
	 $("#m_time").html(_time);
	 $("#m_zhaopian1").html('<img src="'+_zhaopian1+'"/>');
	 _zhaopian2!=''? $("#m_zhaopian2").html('<img src="'+_zhaopian2+'"/>'):'';

});

 </script>
<!--{template footer}-->
