<!--{template header}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;用户管理</div>
</div>
<div id="append"></div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<table class="table">
    <tr>
        <td class="{$type}">{$message}</td>
    </tr>
</table>
<!--{/if}-->

<form action="index.php?admin_user/search{$setting['seo_suffix']}" method="post">
<table class="table">
 <tr class="header" ><td colspan="7">用户列表</td></tr>
            <tr class="altbg1"><td colspan="7">可以通过如下搜索条件，检索用户</td></tr>
</table>
<div class="row">

      <div class="col-md-3">


        </div>



                   <div class="col-md-3">


        </div>
</div>
    <table class="table">
        <tbody>
           <tr>
             <td width="20%" ><label >
 注册日期:</label>
             <div class="input-group date form-date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
            <input class="form-control" size="16" id="timestart" name="srchregdatestart" value="{if isset($search['srchregdatestart'])}$search['srchregdatestart']{/if}"  readonly="">
            <span class="input-group-addon"><span class="icon-remove"></span></span>
            <span class="input-group-addon"><span class="icon-calendar"></span></span>
          </div>
             </td>
              <td width="20%" >
               <label>
  到</label>
               <div class="input-group date form-date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
            <input class="form-control" size="16"  id="timeend" name="srchregdateend" value="{if isset($search['srchregdateend'])}$search['srchregdateend']{/if}" readonly="">
            <span class="input-group-addon"><span class="icon-remove"></span></span>
            <span class="input-group-addon"><span class="icon-calendar"></span></span>
          </div>
              </td>
           </tr>
            <tr>
                <td width="20%" >用户名:<input class="txt form-control" name="srchname" value="{if isset($search['srchname'])}$search['srchname']{/if}" /></td>
                <td  width="20%">UID:<input class="txt form-control" name="srchuid" value="{if isset($search['srchuid'])}$search['srchuid']{/if}" /></td>
                <td  width="20%">Email:<input class="txt form-control" name="srchemail" value="{if isset($search['srchemail'])}$search['srchemail']{/if}" /></td>

            </tr>
            <tr>

                <td  width="20%">用户组：
                    <select name="srchgroupid" class="form-control">
                        <option value="0">--不限--</option>
                        <optgroup label="会员用户组">
                            <!--{loop $usergrouplist $group}-->
                            <option {if $search['srchgroupid'] == $group['groupid']}selected{/if} value="{$group['groupid']}">{$group['grouptitle']}</option>
                            <!--{/loop}-->
                        </optgroup>
                        <optgroup label="系统用户组">
                            <!--{loop $sysgrouplist $group}-->
                            <option {if $search['srchgroupid'] == $group['groupid']}selected{/if} value="{$group['groupid']}">{$group['grouptitle']}</option>
                            <!--{/loop}-->
                        </optgroup>
                    </select>
                </td>
                 <td  width="20%">条件刷选：
                    <select name="ischeck" class="form-control">
                        <option value="0">--不限--</option>
                       <option value="1" {if isset($search['isecheck'])&&$search['ischeck'] == 1}selected{/if}>--邮箱验证--</option>
                       <option value="2" {if isset($search['isecheck'])&&$search['ischeck'] == 2}selected{/if}>--微信验证--</option>
                  
              
                    </select>
                </td>
                <td  width="20%">注册IP:<input class="txt form-control" name="srchregip" value="{if isset($search['srchregip'])}$search['srchregip']{/if}" /></td>
            </tr>
            <tr>
            <td rowspan="2" >
                    <button class="btn btn-success" type="submit" >提 交</button>


                </td>
            </tr>
        </tbody>
    </table>
</form>
<form name="userForm" action="index.php?admin_user/remove{$setting['seo_suffix']}" method="post">
    <table class="table table-striped">
        <thead>
        <tr class="header" >
            <td ><input class="checkbox" value="chkall" id="chkall" onclick="checkall('uid[]')" type="checkbox" name="chkall"><label for="chkall">全选</label></td>

            <td  >用户ID</td>
              <td >用户名</td>
       
            <td  >Email</td>
            
            <td  >Email是否验证</td>
             <td  >手机号码</td>
            <td  >注册时间</td>
            <td  >注册IP</td>
            <td >上次登录时间</td>
            <td >来源采集</td>
            <td >专家</td>
  
            <td  >编辑</td>
        </tr>
        </thead>
        <!--{loop $userlist $member}-->
        <tr>
            <td class="altbg2"><input class="checkbox" type="checkbox" value="{$member['uid']}" name="uid[]"></td>
            <td class="altbg2"><strong>{$member['uid']}</strong></td>
            <td class="altbg2"><strong>{$member['username']}</strong>
            <div>
            <img data-toggle="lightbox" data-group="image-group-{$member['uid']}" style="width:30px;height:30px;" src="{eval echo get_avatar_dir($member['uid'])."?rand=".rand(1,100);}" data-image="{eval echo get_avatar_dir($member['uid'])."?rand=".rand(1,100);}" data-caption="{$member['username']}" class="img-thumbnail" alt="{$member['username']}">
<div style="position: relative;">
<input type="file" data-uid="{$member['uid']}" style="position:absolute;top:5px;width:60px;opacity:0;" class="changeavatar" accept="image/jpeg,image/png,image/jpg">
                          
            <span style="font-size:12px;color:blue;cursor:pointer;">修改头像</span>
            </div>
            </div></td>
        
            <td class="altbg2">{$member['email']}</td>
              <td class="altbg2">
              {if $member['active']==1}
                                        <span class="text-danger" > 已验证</span>
                                           {else}
                                           未验证
              {/if}

              </td>
                          <td class="altbg2">{$member['phone']}</td>
            <td class="altbg2">{$member['regtime']}</td>
            <td class="altbg2">{$member['regip']}</td>
            <td class="altbg2">{$member['lastlogintime']}</td>
             <td class="altbg2">{if $member['fromsite']}<font color="Red">是</font>{else}否{/if}</td>
            <td class="altbg2">{if $member['expert']}<font color="Red">是</font>{else}否{/if}</td>

            <td class="altbg2"><a href="index.php?admin_user/edit/$member['uid']{$setting['seo_suffix']}">编辑</a></td>
        </tr>
        <!--{/loop}-->
        <!--{if $departstr}-->
        <tr class="smalltxt">
            <td class="altbg2" colspan="8" align="left"><div class="pages">{$departstr}</div></td>
        </tr>
        <!--{/if}-->
        <tr><td colspan="8" class="altbg1" align="left"><input class="btn btn-success" type="button" name="elect" onclick="change_expert(1);" value="设置为专家" />&nbsp;&nbsp;<input class="btn btn-success" type="button" name="elect" onclick="change_expert(0);" value="取消专家" />&nbsp;&nbsp;<input class="btn btn-success" type="button" name="elect" onclick="change_caijiuser(1);" value="设置为采集用户" />&nbsp;&nbsp;<input class="btn btn-success" type="button" name="elect" onclick="change_caijiuser(0);" value="取消设置为采集用户" />&nbsp;&nbsp;<input class="btn btn-success" type="button" name="delete" onclick="remove_user();" value="删除" /></td></tr>
    </table>
</form>
<br>
    <link href="{SITE_URL}static/css/dist/lib/datetimepicker/datetimepicker.min.css" rel="stylesheet">
  <script src="{SITE_URL}static/css/dist/lib/datetimepicker/datetimepicker.min.js"></script>

<script type="text/javascript">
$(".changeavatar").change(function () {
	var _target=$(this);
    var formData = new FormData();
    formData.append('file', _target[0].files[0]);
    formData.append('uid', _target.attr("data-uid"));
    console.log(_target.attr("data-uid"))
    $.ajax({
        url: "{url admin_autocaiji/updateuseravatar}",
        type: "post",
        data: formData,
        dataType: "json",
        contentType: false,//用于对data参数进行序列化处理 这里必须false
        processData: false,//必须*/
        success: function (data) {
            console.log(data);
            if (data.code == 200) {
            	_target.parent().parent().find("img").attr("src", data.src);
            	_target.parent().parent().find("img").attr("data-image", data.src);
            	
            } else {
                alert(data.msg);
            }
        },
        error: function (data) {
            alert("上传失败")
        }
    });


})
    function change_expert(type) {
        if ($("input[name='uid[]']:checked").length == 0) {
            alert('你没有选择任何用户');
            return false;
        }
        document.userForm.action = "index.php?admin_user/expert/" + type;
        document.userForm.submit();

    }
    function thankTa(uid){
    	if(confirm("是否确认感谢Ta,确认后会打赏一块钱给Ta")){
    		window.location.href="{SITE_URL}index.php?admin_tixian/ganxie/"+uid+"{$setting['seo_suffix']}";
    	}

    }
       function change_caijiuser(type) {
        if ($("input[name='uid[]']:checked").length == 0) {
            alert('你没有选择任何用户');
            return false;
        }
        document.userForm.action = "index.php?admin_user/caijiuser/" + type;
        document.userForm.submit();

    }

    function remove_user() {
        if ($("input[name='uid[]']:checked").length == 0) {
            alert('你没有选择任何用户');
            return false;
        }
        if (confirm('是否同时删除用户的所有问答？') == true) {
            document.userForm.action = "index.php?admin_user/remove/all{$setting['seo_suffix']}";
            document.userForm.submit();
        } else {
            document.userForm.action = "index.php?admin_user/remove{$setting['seo_suffix']}";
            document.userForm.submit();
        }
    }
 // 仅选择日期
    $(".form-date").datetimepicker(
    {
        language:  "zh-CN",
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0,
        format: "yyyy-mm-dd"
    });
</script>
<!--{template footer}-->


