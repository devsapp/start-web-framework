



<!--用户中心结束-->


<!--{template header}-->
<link rel="stylesheet" media="all" href="{SITE_URL}static/css/bianping/css/space.css" />
<style>
.ui-form-item {

     line-height: auto; 

}
.taglist .ui-icon-close,#cate_view .ui-icon-close{
	display:inline-block;
font-size:20px;
}
#cate_view .ui-border-t{
	padding-top:0px;
padding-bottom:0px;
}
.ui-tips {
    padding: 5px 15px;
    text-align: center;
    font-size: 16px;
    color: #000;
}
.ui-table tr.list-td{
	font-size:13px;
 height:30px;
}
.ui-table td,.ui-table th{
	text-align:left;
padding-left:17px;
}
#dialogcate {
	padding:10px;
}
#dialogcate table{
	margin:20px auto;
}
.mytr{
	line-height:40px;
}
</style>
<section class="ui-container person">
<!--{template user_title}-->
 <div class="dongtai main">
                
  
             <div class="ui-tab" id="tab2">
    <ul class="ui-tab-nav ui-border-b">
        <li ><a href="{url user/profile}">个人资料</a></li>
        <li><a href="{url user/editemail}">激活账号</a></li>
        <li class="current"> <a href="{url user/mycategory}">我的设置</a></li>

    </ul>

</div>
   
 
    
<section class="ui-panel ui-panel-pure ui-border-t">
    <h3>我的擅长分类：</h3>
        {eval if ($setting['cansetcatnum']==null||trim($setting['cansetcatnum'])=='')$setting['cansetcatnum']='1';}
                        
                         <div class="ui-tips ui-tips-info">
    <i></i><span>您最多可添加{$setting['cansetcatnum']}个分类</span>
</div>
 <input type="hidden" value="" name="cids" id="cate_value" />

<div class="ui-btn-wrap">
    <button onclick="checkcategory()" class="ui-btn-lg ui-btn-primary" {if count($user['category'])>=$setting['cansetcatnum']}disabled {/if} >
       添加擅长分类+
    </button>
</div>
 <div class="modal fade" id="myLgModal">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div id="dialogcate">
        <form name="editcategoryForm" action="{url question/movecategory}" method="post">
            <input type="hidden" name="qid" value="{$question['id']}" />
            <input type="hidden" name="category" id="categoryid" />
            <input type="hidden" name="selectcid1" id="selectcid1" value="{$question['cid1']}" />
            <input type="hidden" name="selectcid2" id="selectcid2" value="{$question['cid2']}" />
            <input type="hidden" name="selectcid3" id="selectcid3" value="{$question['cid3']}" />
            <table class="table table-striped">
                <tr valign="top" class="mytr">
                    <td width="125px">
                        <select  id="category1" class="catselect"  name="category1" ></select>
                    </td>
                    <td align="center" valign="middle" width="25px"><div style="display: none;" id="jiantou1">>></div></td>
                    <td width="125px">                                        
                        <select  id="category2"  class="catselect"  name="category2" ></select>                                        
                    </td>
                    <td align="center" valign="middle" width="25px"><div style="display: none;" id="jiantou2">>>&nbsp;</div></td>
                    <td width="125px">
                        <select id="category3"  class="catselect"   name="category3" ></select>
                    </td>
                </tr>
                <tr class="mytr">
                    <td colspan="5">
                    <span>
                    <input  type="button" class="btn btn-success" value="确&nbsp;认" onclick="add_category();"/></span>
                    <span>
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="hidemodel()">关闭</button>
                    </span>
                    </td>
                   
                </tr>
                 <tr class="mytr">
                    <td colspan="5">
                     <ul class="taglist tag">
                     
                     </ul>
                    </td>
                   
                </tr>
            </table>
        </form>
    </div>
    </div>
  </div>
</div>
       <section class="ui-panel ui-panel-pure ui-border-t">
    <h3>您的擅长领域：</h3>

     <ul id="cate_view" class="ui-list ui-list-pure ui-border-tb">
                                <!--{loop $user['category'] $category}-->
                                <li class="ui-border-t" id="{$category['cid']}">{$category['categoryname']}
                              
                                  <a href="#" class="ui-icon-close  icon-times text-danger hand">
            </a>
                                </li>
                                <!--{/loop}-->
                            </ul>
</section>
</section>
<section class="ui-panel ui-panel-pure ui-border-t">
    <h3>外部账号绑定：</h3>
      <table class="ui-table ui-border-tb">
                                <tbody>
                                    <tr><th class="s0">登录方式</th><th class="s2">状态</th><th class="s3">管理</th></tr>
                                    <!--{if $qqlogin}-->
                                    <tr class="list-td">
                                        <td><i class="fa fa-qq mar-ly-1"></i>QQ账号</td>
                                        <td><font color="green">已绑定</font></td>
                                        <td><a href="{url user/unchainauth/qq}">解除绑定</a></td>
                                    </tr> 
                                    <!--{else}-->
                                    <tr class="list-td">
                                        <td><i class="fa fa-qq mar-ly-1"></i>QQ账号</td>
                                        <td>未绑定</td>
                                        <td><a href="{SITE_URL}plugin/qqlogin/index.php">点击绑定</a></td>
                                    </tr> 
                                    <!--{/if}-->
                                    <!--{if $sinalogin}-->
                                    <tr class="list-td">
                                        <td><i class="fa fa-weibo mar-ly-1"></i>sina微博</td>
                                        <td><font color="green">已绑定</font></td>
                                        <td><a href="{url user/unchainauth/sina}">解除绑定</a></td>
                                    </tr> 
                                    <!--{else}-->
                                    <tr class="list-td">
                                        <td><i class="fa fa-weibo mar-ly-1"></i>sina微博</td>
                                        <td>未绑定</td>
                                        <td><a href="{SITE_URL}plugin/sinalogin/index.php">点击绑定</a></td>
                                    </tr> 
                                    <!--{/if}-->
                                           <!--{if $wxlogin}-->
                                    <tr class="list-td">
                                        <td><i class="fa fa-wechat mar-ly-1"></i>微信登录</td>
                                        <td><font color="green">已绑定</font></td>
                                        <td><a href="{url user/unchainauth/wechat}">解除绑定</a></td>
                                    </tr> 
                                    <!--{else}-->
                                    <tr class="list-td">
                                        <td><i class="fa fa-wechat mar-ly-1"></i>微信登录</td>
                                        <td>未绑定</td>
                                        <td><a href="{url plugin_weixin/wxauth}">点击绑定</a></td>
                                    </tr> 
                                    <!--{/if}-->
                                </tbody>
                            </table>
</section>
                     
  
            
</section>
<script src="{SITE_URL}static/js/jquery-1.11.3.min.js"></script>
<script>$.noConflict();</script>
<script type="text/javascript">
var catsetnum={$setting['cansetcatnum']};

function hidemodel(){
	jQuery('#myLgModal').hide();
}

jQuery(".taglist").html(jQuery("#cate_view").html());

    var category1 = {$categoryjs[category1]};
            var category2 = {$categoryjs[category2]};
            var category3 = {$categoryjs[category3]};
          
        initcategory(category1);
        fillcategory(category2, jQuery("#category1 option:selected").val(), "category2");
        fillcategory(category3, jQuery("#category2 option:selected").val(), "category3");
        jQuery("#cate_view .icon-times,.taglist .icon-times").click(function() {
        	alert("ok")
            var cid = jQuery(this).parent().attr("id");
           
            jQuery.post("{SITE_URL}index.php?user/ajaxdeletecategory", {cid: cid});
           
            jQuery(this).parent().remove();
           
            if (jQuery('#cate_view li').size() < catsetnum) {
            	jQuery("#changecategory").removeClass("disabled");
            }
            
           
        });
    function deletemycat(cid){
    	
    }
    function checkcategory(){
    	jQuery(".taglist").html($("#cate_view").html());
    	  jQuery('#myLgModal').show();
    }
    function add_category() {
  
        var selected_category1 = jQuery("#category1 option:selected");
        var selected_category2 = jQuery("#category2 option:selected");
        var selected_category3 = jQuery("#category3 option:selected");
        if (jQuery('#cate_view li').size() >= catsetnum) {
        	jQuery('#myLgModal').hide();
            return false;
        }
        var selected_cid = 0;
        if (selected_category3.val() > 0) {
            selected_cid = selected_category3.val();
            jQuery("#cate_view").append('<li class="item">' + selected_category3.html() + '<a href="#" class="ui-icon-close  icon-times text-danger hand"> </a></li>');
        } else if (selected_category2.val() > 0) {
            selected_cid = selected_category2.val();
            jQuery("#cate_view").append('<li class="item">' + selected_category2.html() + '<a href="#" class="ui-icon-close  icon-times text-danger hand"> </a></li>');
        } else if (selected_category1.val() > 0) {
            selected_cid = selected_category1.val();
            jQuery("#cate_view").append('<li class="item">' + selected_category1.html() + '  <a href="#" class="ui-icon-close  icon-times text-danger hand"> </a></li>');
        }
        if (selected_cid > 0) {
        	jQuery.post("{SITE_URL}index.php?user/ajaxcategory", {cid: selected_cid});
        }
        jQuery(".taglist").html($("#cate_view").html());
        jQuery("#cate_view .icon-times,.taglist .icon-times").click(function() {
            var cid = jQuery(this).parent().attr("id");
           
            jQuery.post("{SITE_URL}index.php?user/ajaxdeletecategory", {cid: cid});
           
            jQuery(this).parent().remove();
           
            if (jQuery('#cate_view li').size() < catsetnum) {
            	jQuery("#changecategory").removeClass("disabled");
            }
            
           
        });
        if (jQuery('#cate_view li').size() >= catsetnum) {
        	jQuery("#changecategory").addClass("disabled");
           
        }
        jQuery('#myLgModal').hide();
    }
  //问题分类选择函数
    function initcategory(category1) {
        var selectedcid1 = jQuery("#selectcid1").val();
        jQuery("#category1").html('');
        for (var i = 0; i < category1.length; i++) {
            var selected = '';
            if (selectedcid1 === category1[i][0]) {
                selected = ' selected';
            }
            jQuery("#category1").append("<option value='" + category1[i][0] + "' " + selected + ">" + category1[i][1] + "</option>");
        }

    }
    function fillcategory(category2, value1, cateid) {
        var optionhtml = '<option value="0">不选择</option>';
        var selectedcid = 0;
        if (cateid === "category2") {
            selectedcid = jQuery("#selectcid2").val();
        } else if (cateid === "category3") {
            selectedcid = jQuery("#selectcid3").val();
        }
        jQuery("#" + cateid).html("");
        for (var i = 0; i < category2.length; i++) {
            if (value1 === category2[i][0]) {
                var selected = '';
                if (selectedcid === category2[i][1]) {
                    selected = ' selected';
                    jQuery("#" + cateid).show();
                }
                optionhtml += "<option value='" + category2[i][1] + "' " + selected + ">" + category2[i][2] + "</option>";
            }
        }
        jQuery("#" + cateid).html(optionhtml);
    }
    //分类选择
    jQuery("#category1").change(function() {
        fillcategory(category2, jQuery("#category1 option:selected").val(), "category2");
        jQuery("#jiantou1").show();
        jQuery("#category2").show();
    });
    jQuery("#category2").change(function() {
        fillcategory(category3, jQuery("#category2 option:selected").val(), "category3");
        jQuery("#jiantou2").show();
        jQuery("#category3").show();
    });
</script>
<!--{template footer}-->