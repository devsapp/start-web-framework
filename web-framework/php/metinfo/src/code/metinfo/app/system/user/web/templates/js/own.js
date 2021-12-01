/* 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved. */
$(function(){
    // 账号安全页面
    if($('.member-profile').length){
        // 邮箱修改
        $('.member-profile .btn-emailedit').click(function(){
            var $self = $(this);
            $(this).addClass('loading');
            $.ajax({
                type: 'GET',
                url: $(this).data('mailedit'),
                dataType:'json',
                success: function(result){
                    if(!parseInt(result.status)){
                        result.msg_str=result.msg;
                        result.msg='';
                    }
                    metAjaxFun({
                        result:result,
                        true_fun:function(){
                            $self.removeClass('loading');
                        },
                        false_fun:function(){
                            alertify.alert(result.msg_str);
                            $self.removeClass('loading');
                        }
                    });
                }
            });
        });
        // 手机绑定-获取短信验证码
        $('.safety-modal-teladd .phone-code').click(function(){
            var $self = $(this),
                $tel = $('.safety-modal-teladd input[name="tel"]'),
                $code = $('.safety-modal-teladd input[name="code"]');
            if($tel.val()==''||!/^1[0-9]{10}$/.test($tel.val())){
                $tel.focus();
                $.include(M['plugin']['alertify'],function(){
                    alertify.error($tel.data('fv-integer-message'));
                });
            }else if($code.val()==''){
                $code.focus();
                $.include(M['plugin']['alertify'],function(){
                    alertify.error($code.data('fv-notempty-message'));
                });
            }else{
                $.ajax({
                   url: $(this).data('url'),
                   type: 'POST',
                   data:{tel:$tel.val(),code:$code.val(),random:$('.safety-modal-teladd [name="random"]').val()},
                   dataType:'json',
                   success: function(result){
                        metAjaxFun({
                            result:result,
                            true_fun:function(){
                                $self.attr('disabled',true);
                                $self.html($self.data('retxt') + ' <span class="badge"></span>');
                                identifyTime($self,90);
                            }
                        });
                   }
                });
            }
        });
        // 手机号码修改-获取短信验证码
        $('.safety-modal-teledit .phone-code').click(function(){
            var $self = $(this);
            $.ajax({
               type: 'GET',
               url: $(this).data('url'),
               dataType:'json',
               success: function(result){
                    metAjaxFun({
                        result:result,
                        true_fun:function(){
                            $self.attr('disabled',true);
                            $self.html($self.data('retxt') + ' <span class="badge"></span>');
                            identifyTime($self,90);
                        }
                    });
                }
            });
        });
        // 手机号码修改提交
        if($('.safety-modal-teledit form').length){
            metFormvalidationLoadFun(function(){
                var safety_teledit_form_index=$('.safety-modal-teledit form').index('form');
                validate[safety_teledit_form_index].success(function(result,form){
                    metAjaxFun({
                        result:result,
                        true_fun:function(){
                            alertify.success(METLANG.usercheckok);
                            $('.safety-modal-teledit').modal('hide');
                            $('.safety-modal-teladd').modal('show');
                        }
                    });
                });
            });
        }
        // 微信绑定
        if($('.member-profile .btn-weixinadd').length){
            var user_weixin_bind_code='';
            $('.member-profile .btn-weixinadd').click(function(event) {
                var delay=0;
                $.ajax({
                    url: M.weburl+'member/basic.php?lang=cn&a=doOtherBind&type=weixin',
                    type: 'GET',
                    dataType: 'json',
                    success:function(result){
                        metAjaxFun({
                            result:result,
                            true_fun:function(){
                                $('.safety-modal-weixinadd .modal-body').html('<img src="'+result.data.img+'" width="100%"/>');
                                !user_weixin_bind_code && setTimeout(function(){
                                    var interval=setInterval(function(){
                                        if($('.safety-modal-weixinadd.in').length){
                                            delay++;
                                            delay<300?$.ajax({
                                                url: M.weburl+'member/basic.php?lang=cn&a=docheckBind&type=weixin',
                                                type: 'POST',
                                                dataType: 'json',
                                                data: {code: user_weixin_bind_code},
                                                success:function(result1){
                                                    metAjaxFun({
                                                        result:result1
                                                    });
                                                }
                                            }):$('.safety-modal-weixinadd').modal('hide');
                                        }
                                    },2000);
                                },1000);
                                user_weixin_bind_code=result.data.code;
                            }
                        })
                    }
                });
            });
        }
        // 微信解绑
        if($('.member-profile .btn-weixinunbind').length){
            $('.member-profile .btn-weixinunbind').metClickConfirmAjax({
                confirm_text:METLANG.weixinunbind,
                url:M.weburl+'member/basic.php?lang=cn&a=doUnbind&type=weixin',
            });
        }
    }
    // 注册页面
    if($('.register-index').length){
        // 获取短信验证码
        var $phone = $('.register-index button.phone-code');
        if($phone.length){
            $phone.click(function(){
                var $self = $(this),
                    $phone = $('.register-index input[name="username"]').length?$('.register-index input[name="username"]'):$('.register-index input[name="phone"]'),
                    $code = $('.register-index input[name="code"]'),
                    $phonecode = $('.register-index input[name="phonecode"]');
                if($phone.val()==''){
                    $phone.focus();
                    $.include(M['plugin']['alertify'],function(){
                        alertify.error($phone.data('fv-notempty-message'));
                    });
                }else if($phone.attr('name')=='phone' && !/^1[0-9]{10}$/.test($phone.val())){
                    $phone.focus();
                    $.include(M['plugin']['alertify'],function(){
                        alertify.error($phone.data('fv-phone-message'));
                    });
                }else if($code.val()==''){
                    $code.focus();
                    $.include(M['plugin']['alertify'],function(){
                        alertify.error($code.data('fv-notempty-message'));
                    });
                }else{
                    $.ajax({
                       type: 'POST',
                       url: $(this).data('url'),
                       data:{phone:$phone.val(),code:$code.val(),random:$('.form-register [name="random"]').val()},
                       dataType:'json',
                       success: function(result){
                            metAjaxFun({
                                result:result,
                                true_fun:function(){
                                    $self.attr('disabled',true);
                                    $self.html($self.data('retxt') + ' <span class="badge"></span>');
                                    identifyTime($self,90);
                                }
                            });
                       }
                    });
                }
            });
        }
    }
    // 邮箱验证
    if($('.send-email').length){
        $('.send-email').click(function(e){
            e.preventDefault();
            var $li = $(this).parent('li');
            $li.addClass('loading');
            $.ajax({
                type: 'GET',
                url: $(this).attr('href'),
                dataType:'json',
                success: function(result){
                    metAjaxFun({result:result,true_fun:function(){}});
                    $li.removeClass('loading');
                }
            });
        });
    }
    // 微信登录
    if($('.met-user-login-weixin[data-toggle="modal"]').length){
        var user_login_weixin_code='';
        $('.met-user-login-weixin[data-toggle="modal"]').click(function(event) {
            var delay=0;
            $.ajax({
                url: M.weburl+'member/login.php?a=doLoginQrcode',
                type: 'GET',
                dataType: 'json',
                success:function(result){
                    metAjaxFun({
                        result:result,
                        true_fun:function(){
                            $('.met-user-login-weixin-modal .modal-body').html('<img src="'+result.data.img+'" width="100%"/>');
                            !user_login_weixin_code && setTimeout(function(){
                                var interval=setInterval(function(){
                                    if($('.met-user-login-weixin-modal.in').length){
                                        delay++;
                                        delay<300?$.ajax({
                                            url: M.weburl+'member/login.php?a=docheckwxlogin',
                                            type: 'POST',
                                            dataType: 'json',
                                            data: {code: user_login_weixin_code},
                                            success:function(result1){
                                                metAjaxFun({
                                                    result:result1,
                                                    true_fun:function(){
                                                        setTimeout(function(){
                                                            window.location.href=result1.data.url;
                                                        },result1.msg?1000:0);
                                                    }
                                                });
                                            }
                                        }):$('.met-user-login-weixin-modal').modal('hide');
                                    }
                                },2000);
                            },1000);
                            user_login_weixin_code=result.data.code;
                        }
                    })
                }
            });
        });
    }
})
// 验证码发送倒计时
function identifyTime(o,wait) {
    var $badge=o.find('span.badge'),
        countdown=setInterval(function(){
            if (wait == 0) {
                o.attr('disabled',false);
                $badge.html('');
                wait = 90;
                clearInterval(countdown);
            } else {
                wait--;
                $badge.html(wait);
            }
        },1000);
    $badge.html(wait);
}