/**
 * 表单验证功能（需调用formvalidation插件）
 * 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved.
 */
(function(){
    $(function(){
        $(document).on('submit', 'form', function() {
            $(this).formSubmitSet();
        });
        // 上传文件
        $(document).on('change keyup','.input-group-file input[type="file"]',function(){
            if(!$(this).parents('.input-group-btn').find('.file-input').length){// 如果没有加载file-input插件
                // 输入框文件路径更新
                var $text=$(this).parents('.input-group-file').find('input[type="text"]'),
                    value='';
                if(M.is_ie){
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
                random=Math.ceil(Math.random()*10000);
            src=src.indexOf('&random')>0?src.split('&random')[0]:src;
            $(this).attr({src:src+'&random='+random}).parents('form').find('input[type="hidden"][name="random"]').val(random);
        });
        // 点击单选切换显示不同元素
        $(document).on('change', 'input[type="radio"][data-target]', function(event) {
            var $target=$($(this).data('target'));
            $target.length && ($target.removeClass('hide'),$(this).parents('form').find('input[type="radio"][data-target][name="'+$(this).attr('name')+'"][value!="'+$(this).val()+'"]').each(function(index, el) {
                $($(this).data('target')).addClass('hide');
            }));
        });
    });
    var table_selector='table.table:not(.edui-default)';
    $.fn.extend({
        // 表单验证提交回调
        validation:function(){
            $(this).each(function(index, el) {
                var $self=$(this),
                    order=$(this).attr('data-validate_order')&&$(this).attr('data-validate_order')!=''?$(this).attr('data-validate_order'):($(this).attr('id')?'#'+$(this).attr('id'):(new Date().getTime()+index)),
                    self_validation='',
                    $table=$(table_selector,this);
                $(this).attr({'data-validate_order':order});
                // 主要流程
                function success(fun,afterajax_ok){
                    validate[order].ajax_submit=1;
                    self_validation.on('success.form.fv', function(e) {
                        e.preventDefault();
                        var action=$self.attr('action');
                        if(/*$self.find('[name="submit_type"]').length && */action=='#'||action.indexOf('javascript:;')==0||(
                            $table.length && ($table.find('tbody .checkall-item[name="id"]').length?!$table.find('tbody .checkall-item[name="id"]:checked').length:(!$table.find('tbody tr').length||$table.find('tbody tr .dataTables_empty').length))
                        )) return false;
                        var ajax_ok=typeof afterajax_ok != "undefined" ?afterajax_ok:true;
                        if(ajax_ok){
                            setTimeout(function(){formDataAjax(e,fun)},0);
                        }else{
                            $self.data('formValidation').resetForm();
                            if (typeof fun==="function") M.form_data_ajax=fun(e,$self);
                            setTimeout(function(){
                                if(typeof M.form_data_ajax =='undefined') $self.data('formValidation').defaultSubmit();
                            },100)
                        }
                    })
                }
                // 数据处理提交
                function formDataAjax(e,fun,data){
                    M.form_data_ajax=false;
                    var handle_name=[],
                        $submit_loading=$self.find('button.btn[type="submit"][data-loading]'),
                        submit_loading_html=$submit_loading.length?$submit_loading.html():'';
                    $self.find('[name][data-safety]').each(function(){
                        handle_name.push($(this).attr('name'));
                    });
                    if(M.is_ie||$table.length){
                        var formData = $table.length?M.table_submit_data:$self.serializeArray(e.target),
                            contentType='application/x-www-form-urlencoded',
                            processData=true;
                        if($table.length){
                            M.table_submit_data={};
                        }else{
                            var new_params={};
                            $.each(formData, function(i, val) {
                                new_params[val.name]=val.value;
                            });
                            formData=new_params;
                        }
                        data && $.extend(true, formData, data);
                    }else{
                        var formData = new FormData(e.target),
                            contentType=false,
                            processData=false;
                        data && $.each(data, function(i, val) {
                            formData.append(i, val);
                        });
                        if(handle_name.length){
                            var params=$self.serializeArray(e.target),
                                new_params={};
                            $.each(params, function(i, val) {
                                new_params[val.name]=val.value;
                            });
                        }
                    }
                    var this_ajax=function(){
                            metui.ajax({
                                url: $self.attr('action'),
                                data: formData,
                                cache: false,
                                contentType: contentType,
                                processData: processData,
                                success: function(result) {
                                    $self.data('formValidation').resetForm();
                                    if($submit_loading.length) $submit_loading.html(submit_loading_html);
                                    if (typeof fun==="function") return fun(result,$self);
                                }
                            });
                        };
                    if(handle_name.length){
                        metui.ajax({
                            url: M.url.system+'entrance.php?m=include&c=sysinfo&a=doGetinfo',
                            success: function(result) {
                                $.each(handle_name, function(i, val) {
                                    if(M.is_ie||$table.length){
                                        formData[val]=authcode(formData[val],1,'',5,result.data.time,result.data.microtime);
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
                    if($submit_loading.length) $submit_loading.html('<i class="fa fa-circle-o-notch fa-spin"></i>');
                }
                validate[order]={success:success,formDataAjax:formDataAjax};
                var that=typeof admin_module!='undefined'?$.extend(true,{},admin_module):'';
                (function(that1){
                    metui.use('formvalidation',function(){
                        // 初始化
                        self_validation=$self.formValidation({
                            locale:M.validation_locale,
                            framework:'bootstrap4'
                        });
                        if($self.data('submit-ajax')){
                            // 自动执行流程
                            success(function(result,form){
                                // 回调处理
                                var true_fun=false_fun='';
                                if(typeof validate_fun[order] != 'undefined' && typeof validate_fun[order].success != 'undefined'){
                                    if(typeof validate_fun[order].success.true_fun != 'undefined') true_fun=validate_fun[order].success.true_fun;
                                    if(typeof validate_fun[order].success.false_fun != 'undefined') false_fun=validate_fun[order].success.false_fun;
                                }
                                $self.find('.dataTable').length?$self.find('.dataTable').tabelAjaxFun(result):(function(){
                                    metAjaxFun({
                                        result: result,
                                        true_fun: true_fun,
                                        false_fun: false_fun
                                    });
                                    $('.met-pageset').length && parseInt(result.status) && $('.page-iframe').attr({'data-reload':1});
                                })();
                                $self.find('.file-input .kv-fileinput-error').hide();
                                $self.find('.file-input .kv-upload-progress').html('');
                                $self.find('.file-input').parents('.form-group:eq(0)').find('.form-control-label').text('');
                            });
                            // 添加回调
                            !$self.find('.dataTable').length && setTimeout(()=>{
                                formSaveCallback(order,{
                                    true_fun:function(){
                                        that1 && that1.reload();
                                    },
                                    false_fun:function(){
                                        $self.find('.met-getcode').click();
                                    }
                                });
                            },0);
                        }
                    });
                })(that);
                $self.find('[name][data-safety]').length && metui.use(['blueimp-md5','string-handle']);
            });
        },
        // 表单提交前处理
        formSubmitSet:function(form){
            // 多选值组合
            var checkbox_val={},
                $form=form||$(this);
            $form.find('input[type="checkbox"][name]').each(function(index, el) {
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
    M.validation_locale='';
    if("undefined" != typeof M){
        M.validation_locale=M.synchronous+'_';
        switch(M.synchronous){
            case 'sq':M.validation_locale+='AL';break;
            case 'ar':M.validation_locale+='MA';break;
            // case 'az':M.validation_locale+='az';break;
            // case 'ga':M.validation_locale+='ie';break;
            // case 'et':M.validation_locale+='ee';break;
            case 'be':M.validation_locale+='BE';break;
            case 'bg':M.validation_locale+='BG';break;
            case 'pl':M.validation_locale+='PL';break;
            case 'fa':M.validation_locale+='IR';break;
            // case 'af':M.validation_locale+='za';break;
            case 'da':M.validation_locale+='DK';break;
            case 'de':M.validation_locale+='DE';break;
            case 'ru':M.validation_locale+='RU';break;
            case 'fr':M.validation_locale+='FR';break;
            // case 'tl':M.validation_locale+='ph';break;
            case 'fi':M.validation_locale+='FI';break;
            // case 'ht':M.validation_locale+='ht';break;
            // case 'ko':M.validation_locale+='kr';break;
            case 'nl':M.validation_locale+='NL';break;
            // case 'gl':M.validation_locale+='es';break;
            case 'ca':M.validation_locale+='ES';break;
            case 'cs':M.validation_locale+='CZ';break;
            // case 'hr':M.validation_locale+='hr';break;
            // case 'la':M.validation_locale+='IT';break;
            // case 'lv':M.validation_locale+='lv';break;
            // case 'lt':M.validation_locale+='lt';break;
            case 'ro':M.validation_locale+='RO';break;
            // case 'mt':M.validation_locale+='mt';break;
            // case 'ms':M.validation_locale+='ID';break;
            // case 'mk':M.validation_locale+='mk';break;
            case 'no':M.validation_locale+='NO';break;
            case 'pt':M.validation_locale+='PT';break;
            case 'ja':M.validation_locale+='JP';break;
            case 'sv':M.validation_locale+='SE';break;
            case 'sr':M.validation_locale+='RS';break;
            case 'sk':M.validation_locale+='SK';break;
            // case 'sl':M.validation_locale+='si';break;
            // case 'sw':M.validation_locale+='tz';break;
            case 'th':M.validation_locale+='TH';break;
            // case 'cy':M.validation_locale+='wls';break;
            // case 'uk':M.validation_locale+='ua';break;
            // case 'iw':M.validation_locale+='';break;
            case 'el':M.validation_locale+='GR';break;
            case 'eu':M.validation_locale+='ES';break;
            case 'es':M.validation_locale+='ES';break;
            case 'hu':M.validation_locale+='HU';break;
            case 'it':M.validation_locale+='IT';break;
            // case 'yi':M.validation_locale+='de';break;
            // case 'ur':M.validation_locale+='pk';break;
            case 'id':M.validation_locale+='ID';break;
            case 'en':M.validation_locale+='US';break;
            case 'vi':M.validation_locale+='VN';break;
            case 'zh':M.validation_locale='zh_TW';break;
            default:M.validation_locale='zh_CN';break;
        }
    }else{
        M.validation_locale='zh_CN';
    }
    window.validate=[];
    window.validate_fun=[];
    $('form').validation();

    // 应用表单功能
    $.fn.extend({
        // 表单两种类型提交前的处理（保存、删除）
        metSubmit:function(type){
            // 插入submit_type字段
            var type=typeof type!='undefined'?type:1,
                type_str=type?(type==1?'save':type):'del',
                $table=$(this).find(table_selector);
            if($(this).find(table_selector).length){
                if(type=='recycle'){
                    type_str='del';
                    $(this).append(M.component.formWidget('recycle',1));
                }else{
                    $(this).find('[name="recycle"]').remove();
                }
            }
            if(!$(this).find('[name="submit_type"]').length) $(this).append(M.component.formWidget('submit_type',''));
            $(this).find('[name="submit_type"]').val(type_str);
            // 插入表格的allid字段
            if($table.length){
                var // checked_str=type==1?'':':checked',
                    $checkbox=$table.find('tbody input[type="checkbox"][name="id"]:checked'/*+checked_str*/),
                    allid='';
                if($table.find('tbody input[type="checkbox"][name="id"]').length){
                    $checkbox.each(function(index, el) {
                        allid+=allid?','+$(this).val():$(this).val();
                    });
                }else{
                    $table.find('tbody input[name="id"]').each(function(index, el) {
                        allid+=allid?','+$(this).val():$(this).val();
                    });
                }
                if(!$(this).find('[name="allid"]').length) $(this).append(M.component.formWidget('allid',''));
                $(this).find('[name="allid"]').val(allid);
            }
        },
        // 表单更新验证
        metFormAddField:function(name){
            var $form=$(this)[0].tagName=='FORM'?$(this):$(this).parents('form'),
                $self=$(this);
            if($form.length){
                metui.use('formvalidation',function(){
                    if(name){
                        if(!$.isArray(name)){
                            if(name.indexOf(',')>=0){
                                name=name.split(',');
                            }else name=[name];
                        }
                        $.each(name, function(index, val) {
                            $form.data('formValidation').addField(val);
                        })
                    }else{
                        var name_array=[],
                            $name=$self.find('[name]');
                        $name.each(function(index, el) {
                            var name=$(this).attr('name');
                            if($.inArray(name, name_array)<=0){
                                name_array.push(name);
                                if(typeof $(this).attr('required') !='undefined'){
                                    $form.data('formValidation').addField(name);
                                }else{
                                    $.each($(this).data(), function(index, val) {
                                        var third_str=index.substr(2,1);
                                        if(index.substr(0,2)=='fv' && index.length>2 && third_str >= 'A' && third_str <= 'Z'){
                                            $form.data('formValidation').addField(name);
                                            return false;
                                        }
                                    });
                                }
                            }
                        });
                    }
                });
            }
        },
    });
    // 点击保存按钮
    $(document).on('click', 'form .btn[type="submit"]', function(event) {
        if(($(this).data('plugin')=='alertify' && $(this).data('type')=='confirm')||$(this).data('url')) event.preventDefault();
        var $form=$(this).parents('form');
        $form.attr({'data-submited':1}).metSubmit($(this).data('submit_type'));
        if($(this).data('url')){
            $form.removeAttr('data-submited');
            var $table=$(this).parents('.dataTable');
            metui.ajax({
                url: $(this).data('url'),
                data: $form.serializeArray(),
                success:function(result){
                    if($table.length){
                        $table.tabelAjaxFun(result);
                    }else{
                        metAjaxFun({result:result});
                        $('.met-pageset').length && parseInt(result.status) && $('.page-iframe').attr({'data-reload':1});
                    }
                }
            });
        }
    });
    // 表单输入框回车时，触发提交按钮
    $(document).on('keydown', 'form input[type="text"]', function(event) {
        if(event.keyCode==13 && $(this).parents('form').find('[type="submit"].disabled,[type="submit"].disableds').length){
            event.preventDefault();
            // $(this).parents('form').submit();
        }
    });
    M.table_submit_data={};
    // 表单提交
    $(document).on('submit', 'form', function(event) {
        var action=$(this).attr('action'),
            not_validate_checked=action=='#'||action=='javascript:;';
        if(action.indexOf('http')<0&&action.substr(0,3)!='../') return;
        var $self=$(this),
            $table=$(table_selector,this);
        $(this).attr('data-submited')?setTimeout(function(){$self.removeAttr('data-submited')},500):$(this).metSubmit();
        $('.dataTable',this).attr({'data-scrolltop':0});
        // 表单中含有表格时所有字段数组集合
        if($table.length){
            var array={};
            $('[name]',this).each(function(index, el) {
                if($(this).parents('tbody').length?(not_validate_checked?1:($(this).parents('tr').find('.checkall-item[name="id"]').length?$(this).parents('tr').find('.checkall-item[name="id"]:checked').length:1)):1){
                    array[$(this).attr('name')]=$(this).val();
                }
            });
            M.table_submit_data=array;
        }
        // 提交删除时没有勾选时提示
        if(!not_validate_checked && $table.length && ($table.find('tbody .checkall-item[name="id"]').length?!$table.find('tbody .checkall-item[name="id"]:checked').length:0) && M.table_submit_data.allid==''){
            event.preventDefault();
            metui.use('alertify',function(){alertify.error(METLANG.jslang3||'请选择至少一项')});
            var $submit=$(M.component.submit_selctor,this);
            $submit.removeAttr('disabled').removeClass('disabled');
        }
        $(this).find('.has-danger').length && $(this).find('.has-danger:eq(0)').attr('tabindex',11).focus().removeAttr('tabindex').find('[name]:visible').focus();
    });
})();
// 表单提交后回调添加自定义方法
function formSaveCallback(order,fn){
    if(typeof validate_fun[order]!='undefined'){
        typeof fn.true_fun=='function' && validate_fun[order].success.true_fun.push(fn.true_fun);
        typeof fn.false_fun=='function' && validate_fun[order].success.false_fun.push(fn.false_fun);
        delete fn.true_fun;
        delete fn.false_fun;
        $.extend(true, validate_fun[order].success, fn);
    }else{
        validate_fun[order]={
            success:{
                true_fun:typeof fn.true_fun=='function'?[fn.true_fun]:[],
                false_fun:typeof fn.false_fun=='function'?[fn.false_fun]:[]
            }
        };
    }
}