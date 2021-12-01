/*!
 * 表单验证功能（需调用formvalidation插件）
 * 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved.
 */
$(function(){
    // 表单提交前处理
    // $(document).on('click', 'form [type="submit"]:not(.fv-hidden-submit)', function() {
    //     $(this).parents('form').formSubmitSet();
    // });
    $(document).on('submit', 'form', function() {
        if(!$('.has-danger',this).length && $(this).formSubmitSet(1)==1) return false;
    });
    // 上传文件
    $(document).on('change keyup','.input-group-file input[type="file"]',function(){
        if(!$(this).parents('.input-group-btn').find('.file-input').length){// 如果没有加载file-input插件
            // 输入框文件路径更新
            var $text=$(this).parents('.input-group-file').find('input[type="text"]'),
                value='';
            if(M['is_lteie9']){
                value=$(this).val();
            }else{
                var $input_group_file=$(this).parents('.input-group-file');
                if($(this)[0].files.length>10){
                    // 显示报错文字
                    if(!$input_group_file.next('small.form-control-label').length) $input_group_file.after('<small class="form-control-label"></small>');
                    $input_group_file.next('small.form-control-label').text('一次只能提交最多10张图片！');
                    $input_group_file.parents('.form-group').removeClass('has-success').addClass('has-danger');
                }else{
                    $.each($(this)[0].files,function(i,file){
                        value +=value?','+file.name:file.name;
                    });
                    $input_group_file.next('small.form-control-label').html('');
                    $input_group_file.parents('.form-group').removeClass('has-danger');
                }
            }
            if(value) $text.val(value).trigger('change');
        }
    });
    // 验证码点击刷新
    $(document).on('click',"#getcode,.met-getcode",function(){
        var src=$(this).attr("src"),
            random=Math.floor(Math.random()*9999+1);
        src=src.indexOf('&random')>0?src.split('&random')[0]:src;
        $(this).attr({src:src+'&random='+random}).parents('form').find('input[type="hidden"][name="random"]').val(random);
    });
    var $form_referer=$('form.met-form input[name="referer"][type="hidden"]');
    $form_referer.length && $form_referer.val(location.search.indexOf('fdtitle=')>0?document.referrer:'');
});
$.fn.extend({
    // 表单验证通用
    validation:function(){
        var $self=$(this),
            self_validation=$(this).formValidation({
                locale:M['validation_locale'],
                framework:'bootstrap4'
            }),
            order=$(this).attr('data-validate_order');
        $('[name][data-fv-notempty],[name][required],[name][data-required]',this).parents('.form-group:not(.required)').addClass('required');
        function success(fun,afterajax_ok){
            validate[order].ajax_submit=1;
            self_validation.on('success.form.fv', function(e) {
                e.preventDefault();
                if($self.find('[name="submit_type"]').length && $self.find('[name="submit_type"]').val()=='delet' && $self.find('[name="all_id"]').val()=='') return false;
                var ajax_ok=typeof afterajax_ok != "undefined" ?afterajax_ok:true;
                if(ajax_ok){
                    formDataAjax(e,fun);
                }else{
                    $self.data('formValidation').resetForm();
                    if (typeof fun==="function") window.form_data_ajax=fun(e,$self);
                    setTimeout(function(){
                        if(typeof form_data_ajax =='undefined') $self.data('formValidation').defaultSubmit();
                    },100)
                }
            })
        }
        function formDataAjax(e,fun){
            window.form_data_ajax=false;
            var $form    = $(e.target),
                type=($form.attr('method')||'POST').toUpperCase(),
                url=$form.attr('action');
            if(type!='POST') url+=(url.indexOf('?')>0?'&':'?')+$form.serialize(e.target);
            if(M.is_ie){
                var formData = $form.serializeArray(e.target),
                    contentType='application/x-www-form-urlencoded',
                    processData=true,
                    new_params={};
                $.each(formData, function(i, val) {
                    new_params[val.name]=val.value;
                });
                formData=new_params;
            }else{
                var formData = new FormData(e.target),
                    params   = $form.serializeArray(e.target),
                    contentType=false,
                    processData=false,
                    new_params={};
                $.each(params, function(i, val) {
                    new_params[val.name]=val.value;
                });
            }
            var handle_name=[],
                this_ajax=function(){
                    $.ajax({
                        url: url,
                        data: formData,
                        cache: false,
                        contentType: contentType,
                        processData: processData,
                        type: type,
                        dataType:'json',
                        success: function(result) {
                            $form.data('formValidation').resetForm();
                            if (typeof fun==="function") return fun(result,$form);
                        }
                    });
                };
            $form.find('[name][data-safety]').each(function(){
                handle_name.push($(this).attr('name'));
            });
            if(handle_name.length){
                $.ajax({
                    url: M.weburl+'app/system/entrance.php?m=include&c=sysinfo&a=doGetinfo',
                    type: 'GET',
                    success: function(result) {
                        $.each(handle_name, function(i, val) {
                            if(M.is_ie){
                                formData[val]=authcode(formData[val],1,'',0,result.data.time,result.data.microtime);
                            }else{
                                formData.set(val, authcode(new_params[val],1,'',5,result.data.time,result.data.microtime));
                            }
                        });
                        this_ajax();
                    }
                });
            }else{
                this_ajax();
            }
        }
        if($(this).data('submit-jump')) success('',false);
        if($(this).data('submit-ajax')) success(function(result,form){metAjaxFun(result)});
        $('[name][data-safety]',this).length && $.include([M.weburl+'public/plugins/blueimp-md5/blueimp-md5.min.js',M.weburl+'public/plugins/string-handle/string-handle.js']);
        return {success:success,formDataAjax:formDataAjax};
    },
    // 表单提交前处理
    formSubmitSet:function(form_submit){
        // 多选值组合
        var checkbox_val={},
            $form=$(this);
        if(typeof validate[$(this).attr('data-validate_order')]!='undefined' && typeof validate[$(this).attr('data-validate_order')].ajax_submit=='undefined'){
            var $safety=$form.find('[name][data-safety]');
            if($safety.length){
                if(!$form.attr('data-getinfoed')){
                    $form.attr('data-getinfoed',1);
                    setTimeout(function(){
                        $form.removeAttr('data-getinfoed');
                    },1000);
                    $.ajax({
                        url: M.weburl+'app/system/entrance.php?m=include&c=sysinfo&a=doGetinfo',
                        type: 'GET',
                        success: function(result) {
                            $safety.each(function(){
                                var val=$(this).val(),
                                    name=$(this).attr('name');
                                if(val!=''){
                                    if(!$form.find('[name="'+name+'"][type="hidden"]').length) $form.append('<input type="hidden" name="'+name+'"/>');
                                    $form.find('[name="' + name + '"][type="hidden"]').val(authcode(val, 1, '', M.is_ie ? 0 : 5, result.data.time, result.data.microtime));
                                }
                            });
                            setTimeout(function(){
                                $form.submit();
                            },10)
                        }
                    });
                    return 1;
                }
                var has_safe=0;
                $safety.each(function(){
                    if($(this).val()!='' && $form.find('[name="'+$(this).attr('name')+'"][type="hidden"]').length){
                        has_safe=1;
                        return false;
                    }
                });
                if(!has_safe) return 1;
            }
        }
        if($form.attr('data-submited')){
            setTimeout(function(){
                $form.removeAttr('data-submited');
            },1000);
            return;
        }
        $form.attr('data-submited',1).find('input[type="checkbox"][name]').each(function(index, el) {
            var name=$(this).attr('name'),
                val=$(this).val(),
                delimiter=$(this).data('delimiter')||'#@met@#';
            if(typeof checkbox_val[name] =='undefined') checkbox_val[name]='';
            if($(this).prop('checked') || $(this).data('plugin')=='switchery') checkbox_val[name]+=checkbox_val[name]!=''?(delimiter+val):val;
        });
        $.each(checkbox_val, function(index, val) {
            if(!$form.find('[name="'+index+'"][type="hidden"]').length) $form.append('<input type="hidden" name="'+index+'"/>');
            $form.find('[name="'+index+'"][type="hidden"]').val(val);
        });
    }
});
// formValidation多语言选择
M['validation_locale']='';
if("undefined" != typeof M){
    M['validation_locale']=M['synchronous']+'_';
    switch(M['synchronous']){
        case 'sq':M['validation_locale']+='AL';break;
        case 'ar':M['validation_locale']+='MA';break;
        // case 'az':M['validation_locale']+='az';break;
        // case 'ga':M['validation_locale']+='ie';break;
        // case 'et':M['validation_locale']+='ee';break;
        case 'be':M['validation_locale']+='BE';break;
        case 'bg':M['validation_locale']+='BG';break;
        case 'pl':M['validation_locale']+='PL';break;
        case 'fa':M['validation_locale']+='IR';break;
        // case 'af':M['validation_locale']+='za';break;
        case 'da':M['validation_locale']+='DK';break;
        case 'de':M['validation_locale']+='DE';break;
        case 'ru':M['validation_locale']+='RU';break;
        case 'fr':M['validation_locale']+='FR';break;
        // case 'tl':M['validation_locale']+='ph';break;
        case 'fi':M['validation_locale']+='FI';break;
        // case 'ht':M['validation_locale']+='ht';break;
        // case 'ko':M['validation_locale']+='kr';break;
        case 'nl':M['validation_locale']+='NL';break;
        // case 'gl':M['validation_locale']+='es';break;
        case 'ca':M['validation_locale']+='ES';break;
        case 'cs':M['validation_locale']+='CZ';break;
        // case 'hr':M['validation_locale']+='hr';break;
        // case 'la':M['validation_locale']+='IT';break;
        // case 'lv':M['validation_locale']+='lv';break;
        // case 'lt':M['validation_locale']+='lt';break;
        case 'ro':M['validation_locale']+='RO';break;
        // case 'mt':M['validation_locale']+='mt';break;
        // case 'ms':M['validation_locale']+='ID';break;
        // case 'mk':M['validation_locale']+='mk';break;
        case 'no':M['validation_locale']+='NO';break;
        case 'pt':M['validation_locale']+='PT';break;
        case 'ja':M['validation_locale']+='JP';break;
        case 'sv':M['validation_locale']+='SE';break;
        case 'sr':M['validation_locale']+='RS';break;
        case 'sk':M['validation_locale']+='SK';break;
        // case 'sl':M['validation_locale']+='si';break;
        // case 'sw':M['validation_locale']+='tz';break;
        case 'th':M['validation_locale']+='TH';break;
        // case 'cy':M['validation_locale']+='wls';break;
        // case 'uk':M['validation_locale']+='ua';break;
        // case 'iw':M['validation_locale']+='';break;
        case 'el':M['validation_locale']+='GR';break;
        case 'eu':M['validation_locale']+='ES';break;
        case 'es':M['validation_locale']+='ES';break;
        case 'hu':M['validation_locale']+='HU';break;
        case 'it':M['validation_locale']+='IT';break;
        // case 'yi':M['validation_locale']+='de';break;
        // case 'ur':M['validation_locale']+='pk';break;
        case 'id':M['validation_locale']+='ID';break;
        case 'en':M['validation_locale']+='US';break;
        case 'vi':M['validation_locale']+='VN';break;
        case 'zh':M['validation_locale']='zh_TW';break;
        case 'cn':M['validation_locale']='zh_CN';break;
    }
}else{
    M['validation_locale']='zh_CN';
}
// 表单验证初始化
$.fn.metValidate=function(){
    var $form=$('form',this).filter(function(){
        return !$(this).parents('ins').length;
    });
    if(typeof validate =='undefined') window.validate=[];
    $form.addClass('met-form-validation');
    $form.each(function(index, el) {
        var order=$(this).index('form');
        $(this).attr({'data-validate_order':order});
        validate[order]=$(this).validation();
    });
}
$(document).metValidate();