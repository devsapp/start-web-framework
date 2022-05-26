<!--{template header}-->

<style>
.table-striped tr{
height:30px;
color:#009a61;
}
.table-hover *, .table-striped * {
    font-size: 13px;
}
.tag {
    display: inline-block;
    padding: 0 6px;
    color: #fff;
    background-color:transparent;
    height: 22px;
    line-height: 22px;
    font-weight: normal;
    font-size: 13px;
    text-align: center;
}
.tag .item{
 background-color:#017E66;
display:inline-block;
margin-right:20px;
padding:2px;
}
.icon-times{
  color: #fff;
}
</style>

    <div class="container person">

                  <div class="row " style="margin-top: 20px;margin-bottom:10px;">
        <div class="col-md-6">
         <!--{template side_useritem}-->
        </div>
           <div class="col-md-16">
               <h4>设置擅长分类</h4>
     <hr>
         {eval if ($setting['cansetcatnum']==null||trim($setting['cansetcatnum'])=='')$setting['cansetcatnum']='1';}
                         <div class=" alert alert-warning">您最多可添加{$setting['cansetcatnum']}个分类</div>
                    <div class="row" style="padding-top:0px;">
                    <div class="col-sm-16">

                    <div>为更好推荐您擅长的问题，请设置您的擅长分类</div>
                    <div>

                                <input type="hidden" value="" name="cids" id="cate_value" />

                            </div>
                              <div><button {if count($user['category'])>=$setting['cansetcatnum']}class="btn disabled  btn-danger"{else} class="btn btn-danger" {/if}  id="changecategory" onclick="checkcategory()" ><span>添加擅长分类+</span></button></div>
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
                <tr valign="top">
                    <td width="125px">
                        <select  id="category1" class="catselect" size="8" name="category1" ></select>
                    </td>
                    <td align="center" valign="middle" width="25px"><div style="display: none;" id="jiantou1">>></div></td>
                    <td width="125px">
                        <select  id="category2"  class="catselect" size="8" name="category2" ></select>
                    </td>
                    <td align="center" valign="middle" width="25px"><div style="display: none;" id="jiantou2">>>&nbsp;</div></td>
                    <td width="125px">
                        <select id="category3"  class="catselect" size="8"  name="category3" ></select>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                    <span>
                    <input  type="button" class="btn btn-success" value="确&nbsp;认" onclick="add_category();"/></span>
                    <span>
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    </span>
                    </td>

                </tr>
                 <tr>
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

                    </div>

                   <div class="col-md-18" style="margin-top:20px;">
                     <span>您的擅长领域：</span>   
                            <ul id="cate_view" class="tag">
                                <!--{loop $user['category'] $category}-->
                                <li class="item" id="{$category['cid']}">{$category['categoryname']}<i class="icon icon-times text-danger hand"></i></li>
                                <!--{/loop}-->
                            </ul>
                   </div>
                    </div>
                   <div class="row" style="margin-top:20px;">
                   <div class="col-sm-22">

                      <h4>第三方账号</h4>

  
                     <table class="table table-striped"  style="margin-top:20px;">
                                <tbody>

                                    <!--{if $qqlogin}-->
                                    <tr>
                                        <td><i class="fa fa-qq mar-ly-1"></i>QQ账号</td>
                                        <td><font color="green">已绑定</font></td>
                                        <td><a href="{url user/unchainauth/qq}">解除绑定</a></td>
                                    </tr>
                                    <!--{else}-->
                                    <tr>
                                        <td><i class="fa fa-qq mar-ly-1"></i>QQ账号</td>
                                        <td>未绑定</td>
                                        <td><a href="{SITE_URL}plugin/qqlogin/index.php">点击绑定</a></td>
                                    </tr>
                                    <!--{/if}-->
                                    <!--{if $sinalogin}-->
                                    <tr>
                                        <td><i class="fa fa-weibo mar-ly-1"></i>sina微博</td>
                                        <td><font color="green">已绑定</font></td>
                                        <td><a href="{url user/unchainauth/sina}">解除绑定</a></td>
                                    </tr>
                                    <!--{else}-->
                                    <tr>
                                        <td><i class="fa fa-weibo mar-ly-1"></i>sina微博</td>
                                        <td>未绑定</td>
                                        <td><a href="{SITE_URL}plugin/sinalogin/index.php">点击绑定</a></td>
                                    </tr>
                                    <!--{/if}-->
                                         <!--{if $wxlogin}-->
                                    <tr>
                                        <td><i class="fa fa-wechat mar-ly-1"></i>微信登录</td>
                                        <td><font color="green">已绑定</font></td>
                                        <td><a href="{url user/unchainauth/wechat}">解除绑定</a></td>
                                    </tr>
                                    <!--{else}-->
                                    <tr>
                                        <td><i class="fa fa-wechat mar-ly-1"></i>微信登录</td>
                                        <td>未绑定</td>
                                        <td><a href="{url plugin_weixin/wxauth}">点击绑定</a></td>
                                    </tr>
                                    <!--{/if}-->
                                </tbody>
                            </table>
                   </div>
                   
                       {if $setting['openwxpay']==1}
                   <div class="col-sm-22">
                       <h4>付费设置</h4>
     <hr>
                     <p class="mar-t-1 font-18">付费对我提问(最高不超过2w人民币)，单位：元</p>
                    
                   <form>
                     <div class="form-group">

    <input  type="number" autocomplete="off" style="border:solid 1px #009A61;padding-left:10px;margin-top:10px;height:30px;line-height:30px;" oninput="change()" onpropertychange="change()" value="{$user['mypay']}"  class=""  id="mypay" placeholder="设置付费提问金额，最高不超过2W">
    元
  </div>
   <button type="button" id="btnsubmit" class="btn btn-success">提交</button>

                    </form>
     </div>
          
           {/if}

        </div>

    </div>

</div>
</div>

<!--用户中心结束-->

<script type="text/javascript">
var catsetnum={$setting['cansetcatnum']};
function change(){
	var _val=$("#mypay").val();
	if(parseInt(_val)<0){
		new $.zui.Messager('金额不能小于0。', {
		    icon: 'heart',
		    placement: 'bottom' // 定义显示位置
		}).show();

		return false;
	}
	if(parseInt(_val)>20000){
		new $.zui.Messager('最大金额不超过2W人民币。', {
		    icon: 'heart',
		    placement: 'bottom' // 定义显示位置
		}).show();

		return false;
	}
}
$("#btnsubmit").click(function(){
	var _val=$("#mypay").val();
	if(parseInt(_val)<0){
		new $.zui.Messager('金额不能小于0。', {
		    icon: 'heart',
		    placement: 'bottom' // 定义显示位置
		}).show();

		return false;
	}
	if(parseInt(_val)>20000){
		new $.zui.Messager('最大金额不超过2W人民币。', {
		    icon: 'heart',
		    placement: 'bottom' // 定义显示位置
		}).show();

		return false;
	}

	   $.ajax({
		        //提交数据的类型 POST GET
		        type:"POST",
		        //提交的网址
		        url:"{url user/ajaxsetmypay}",
		        //提交的数据
		        data:{mypay:_val},
		        //返回数据的格式
		        datatype: "text",//"xml", "html", "script", "json", "jsonp", "text".

		        //成功返回之后调用的函数
		        success:function(data){

		          if(data=='1'){
		        	  new $.zui.Messager('设置成功!', {
			    		    icon: 'heart',
			    		    placement: 'bottom' // 定义显示位置
			    		}).show();
		          }else{
		        	  new $.zui.Messager('设置失败!', {
			    		    icon: 'heart',
			    		    placement: 'bottom' // 定义显示位置
			    		}).show();
		          }


		        }   ,

		        //调用出错执行的函数
		        error: function(){
		            //请求出错处理
		        }
		    });
})
$(".taglist").html($("#cate_view").html());
    var category1 = {$categoryjs[category1]};
            var category2 = {$categoryjs[category2]};
            var category3 = {$categoryjs[category3]};

        initcategory(category1);
        fillcategory(category2, $("#category1 option:selected").val(), "category2");
        fillcategory(category3, $("#category2 option:selected").val(), "category3");
        $("#cate_view .icon-times,.taglist .icon-times").click(function() {
            var cid = $(this).parent().attr("id");

            $.post("{SITE_URL}index.php?user/ajaxdeletecategory", {cid: cid});

            $(this).parent().remove();

            if ($('#cate_view li').size() < catsetnum) {
                $("#changecategory").removeClass("disabled");
            }


        });
    function deletemycat(cid){

    }
    function checkcategory(){
    	  $(".taglist").html($("#cate_view").html());
    	  $('#myLgModal').modal("show");
    }
    function add_category() {

        var selected_category1 = $("#category1 option:selected");
        var selected_category2 = $("#category2 option:selected");
        var selected_category3 = $("#category3 option:selected");
        if ($('#cate_view li').size() >= catsetnum) {
        	$('#myLgModal').modal("hide");
            return false;
        }
        var selected_cid = 0;
        if (selected_category3.val() > 0) {
            selected_cid = selected_category3.val();
            $("#cate_view").append('<li class="item">' + selected_category3.html() + '<i class="icon icon-times text-danger hand"></i></li>');
        } else if (selected_category2.val() > 0) {
            selected_cid = selected_category2.val();
            $("#cate_view").append('<li class="item">' + selected_category2.html() + '<i class="icon icon-times text-danger hand"></i></li>');
        } else if (selected_category1.val() > 0) {
            selected_cid = selected_category1.val();
            $("#cate_view").append('<li class="item">' + selected_category1.html() + '<i class="icon icon-times text-danger hand"></i></li>');
        }
        if (selected_cid > 0) {
            $.post("{SITE_URL}index.php?user/ajaxcategory", {cid: selected_cid});
        }
        $(".taglist").html($("#cate_view").html());
        $("#cate_view .icon-times,.taglist .icon-times").click(function() {
            var cid = $(this).parent().attr("id");

            $.post("{SITE_URL}index.php?user/ajaxdeletecategory", {cid: cid});

            $(this).parent().remove();

            if ($('#cate_view li').size() < catsetnum) {
                $("#changecategory").removeClass("disabled");
            }


        });
        if ($('#cate_view li').size() >= catsetnum) {
            $("#changecategory").addClass("disabled");

        }
        $('#myLgModal').modal("hide");
    }

</script>
<!--{template footer}-->