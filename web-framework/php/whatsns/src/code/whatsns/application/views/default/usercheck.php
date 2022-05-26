<!--强制qq用户修改用户名-->
    <link href="{SITE_URL}static/css/dist/css/usercheck.css" rel="stylesheet">
<div class="modal fade" id="initdaochu">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">完善个人信息</h4>
            </div>
            <div class="modal-body">
             <p class="text-c-hui font-12">
                    第三方登录，请完善个人信息
                </p>
              
                <div class="formdiv">

                    <div class="row">
                        <div class="col-md-22">
                            <form class="form-hz">
                                <div class="u-form-group">
                                    <label for="qq_oldusername">原用户名 </label>
                                    <input type="text" autocomplete="off" value="{$user['username']}" readonly class="form-control" style="background: transparent" value=""  id="qq_oldusername" >
                        <span class="text-danger errortip">
                            *
                        </span>
                                </div>

                                <div class="u-form-group">
                                    <label for="qq_username">新用户名 </label>
                                    <input type="text"  autocomplete="off"  class="form-control" data-toggle="tooltip" data-placement="top" title="支持英文和中文，禁止输入特殊字符"  id="qq_username" placeholder="请确认输入新用户名">
                <span class="text-danger errortip">
                            *
                        </span>
                                </div>
                                     <div class="u-form-group">
                                    <label for="qq_username">邮箱 </label>
                                    <input type="text"  autocomplete="off"  class="form-control" data-toggle="tooltip" data-placement="top" title="支持qq，163常见邮箱"  id="qq_useremial" placeholder="email地址">
                 
                <span class="text-danger errortip">
                            *
                        </span>
                                </div>


                                <div class="row">
                                    <div class="col-md-24">
                                        <button type="button" onclick="ck_username()" class=" btn-juhuang pull-left btn-juhuang">确定</button>


                                    </div>

                                </div>


                            </form>
                        </div>
                    </div>



                </div>
            </div>

        </div>
    </div>
</div>
<script>
    showinitdaoru();
    //显示首次导出弹窗
    function showinitdaoru(){

        $("#initdaochu").modal({
            show:true,
            backdrop:"static"
        });
    }
    //隐藏首次导出弹窗
    function hideinitdaoru(){
        $("#initdaochu").modal("hide");
    }
   
    function ck_username(){
    	
    	var username=$.trim($("#qq_username").val());
  
    	 var length = bytes(username);
         
         if (length < 3 || length > 15) {
         alert('用户名请使用3到15个字符')
         return false;
         } 
         
         var email = $.trim($('#qq_useremial').val());
         if (!email.match(/^[\w\.\-]+@([\w\-]+\.)+[a-z]{2,4}$/ig)) {
         	
         
             alert('邮件格式不正确');
             return false;
         }else{
             $.post("{SITE_URL}index.php?user/ajaxupdateusername", {username: username,useremail:email}, function(flag) {
                 if (-1 == flag) {
                 	
                 	alert('此用户名已经存在')
                 	return false;
                 } else if (-2 == flag) {
             
                 	 alert('用户名含有禁用字符')
                    
                     return false;
                 } else if (0 == flag) {
             
                 	 alert('游客无权限')
                    
                     return false;
                 }else if (-3 == flag) {
                  	
                     
                	 alert('邮件地址被禁止注册');
                     return false;
                 } else if (-4 == flag) {
                  	
                     
                	 alert('邮件地址已经注册');
                     return false;
                 }else if (1 == flag) {
             
                	 alert('修改成功，系统给您发送了激活邮件')
                    setTimeout(function(){
                    	window.location.reload();
                    },1000);
                     return false;
                 }  
             });
         } 

         
    	
    }
</script>