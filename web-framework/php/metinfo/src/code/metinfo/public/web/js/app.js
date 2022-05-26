/*!
 * 应用通用功能
 * 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved.
 */
// 判断地址栏是否有lang参数，没有则跳转到带lang参数的地址
if(typeof MET !='undefined' && MET['url']['basepath'] !='undefined'){
    var str=window.parent.document.URL,
        s=str.indexOf("lang="+M['lang']),
        z=str.indexOf("lang");
    if (s=='-1' && z!='-1') {
        var s1=str.indexOf('#');
        if (s1=='-1') {
            str=str.replace(/(lang=[^#]*)/g, "lang="+M['lang']+"#");
        }
        str=str.replace(/(lang=[^#]*#)/g, "lang="+lang+"#");
        parent.location.href=str;
    }
}
// 获取地址栏参数
function getQueryString(name) {
    var reg=new RegExp("(^|&)"+name+"=([^&]*)(&|$)", "i");
    var r=window.location.search.substr(1).match(reg);
    if (r!=null) return unescape(decodeURIComponent(r[2]));
    return null;
}
// 修改、添加、删除地址栏参数
function replaceParamVal(param,value) {
    var url=location.href,
        match_url=window.location.search.substr(1) || window.location.hash.split('?')[1]||'',
        param=$.isArray(param)?param:[param],
        value=$.isArray(value)?value:[value];
    $.each(param, function(index, val) {
        var param1='&' + val + '=',
        param2='?' + val + '=',
        re = match_url.match(new RegExp("(^|&)"+val+"=([^&]*)(&|$)", "i"));
        if(!re && (url.indexOf(param1)>0 || url.indexOf(param2)>0)) re=[val + '='];
        re && (re[0]=re[0].replace(/&/g,''));
        value[index]=String(value[index]);
        if(value[index]){
            if(re){
                if(url.indexOf(param1)>0){
                    url = url.replace('&'+re[0], param1 + value[index]);
                }else if(url.indexOf(param2)>0){
                    url = url.replace('?'+re[0], param2 + value[index]);
                }
            }else{
                if(url.indexOf('?')>0){
                    var laststr=url.substr(-1),
                        urls=url.split('?');
                    if(urls[urls.length-1].indexOf('#')>0 && laststr!='/'){
                        url+='/?';
                        laststr=url.substr(-1);
                    }
                    url = url+((laststr=='?'||laststr=='&')?(val + '='):param1) + value[index];
                }else{
                    if((url+'/')==M.weburl) url+='/';
                    var laststr=url.substr(url.lastIndexOf('/')+1);
                    if(laststr.length?laststr.indexOf('.')>0:1){
                        url=url+param2 + value[index];
                    }else{
                        url=url+'/'+param2 + value[index];
                    }
                }
            }
        }else if(re){
            url = url.replace('&'+re[0], '').replace(re[0], '');
        }
    })
    history.pushState('','',url);
}
// 可视化弹框中页面隐藏头部
if (parent.window.location.search.indexOf('pageset=1') >= 0) $('.metadmin-head').hide();
// 操作成功、失败提示信息
if(top.location!=location) $("html",parent.document).find('.turnovertext').remove();
// 弹出提示信息
function metAlert(text,delay,bg_ok,type){
    delay=typeof delay != 'undefined'?delay:2000;
    bg_ok=bg_ok?'bgshow':'';
    if(bg_ok){
        $('.metalert-text').remove();
    }else{
        $('.metalert-wrapper').remove();
    }
    if(text!=' '){
        text=text||METLANG.jsok;
        text='<div>'+text+'</div>';
        if(parseInt(type)==0) text+='<button type="button" class="close white" data-dismiss="alert"><span aria-hidden="true">×</span></button>';
        if(!$('.metalert-text').length){
            var html='<div class="metalert-text p-x-40 p-y-10 bg-purple-600 white font-size-16">'+text+'</div>';
            if(bg_ok) html='<div class="metalert-wrapper w-full alert '+bg_ok+'">'+html+'</div>';
            $('body').append(html);
        }
        var $met_alert=$('.metalert-text'),
            $obj=bg_ok?$('.metalert-wrapper'):$met_alert;
        $met_alert.html(text);
        $obj.show();
        if($met_alert.outerHeight()%2) $met_alert.height($met_alert.height()+1);
    }
    if(delay){
        setTimeout(function(){
            var $obj=bg_ok?$('.metalert-wrapper'):$('.metalert-text');
            $obj.fadeOut();
        },delay);
    }
}
// 弹出页面返回的提示信息
var turnover=[];
turnover['text']=getQueryString('turnovertext');
turnover['type']=parseInt(getQueryString('turnovertype'));
turnover['delay']=turnover['type']?undefined:0;
if(turnover['text']) metAlert(turnover['text'],turnover['delay'],!turnover['type'],turnover['type']);
// 系统参数
var lang=M['lang'],
    siteurl=M['weburl'],
    basepath=(typeof MET!='undefined' && MET['url']['basepath'])?MET['url']['basepath']:'';
if(typeof MET != 'undefined'){
    for(var name in MET){
        if(!M[name]) M[name]=MET[name];
    }
}
M['n']=getQueryString('n');
M['c']=getQueryString('c');
M['a']=getQueryString('a');
if(!M['url']) M['url']=[];
M['url']['admin']=M['url']['basepath'];
M['url']['system']=M['weburl']+'app/system/';
M['url']['app']=M['weburl']+'app/app/';
M['url']['public']=M['weburl']+'public/';
M['url']['public_plugins']=M['url']['public']+'plugins/';
M['url']['public_fonts']=M['url']['public']+'fonts/';
M['url']['public_images']=M['url']['public']+'images/';
M['url']['public_web']=M['url']['public']+'web/';
M['url']['public_web_plugins']=M['url']['public_web']+'plugins/';
M['url']['public_web_register']=M['url']['public_web_plugins']+'register/';
M['url']['public_web_css']=M['url']['public_web']+'css/';
M['url']['public_web_js']=M['url']['public_web']+'js/';

M['url']['static_modules']=M['url']['public_plugins'];
M['url']['static_vendor']=M['url']['public_plugins'];
M['url']['static2']=M['url']['public'];
M['url']['static2_vendor']=M['url']['public_plugins'];
M['url']['static2_plugin']=M['url']['public_web_register'];
M['url']['uiv2']=M['url']['public_web'];
M['url']['uiv2_css']=M['url']['public_web_css'];
M['url']['uiv2_js']=M['url']['public_web_js'];
M['url']['uiv2_plugin']=M['url']['public_plugins'];
// 插件路径
M['plugin']=[];
M['plugin']['formvalidation']=[
    M['url']['public_web_plugins']+'formvalidation/formValidation.min.css',
    M['url']['public_web_plugins']+'formvalidation/formValidation.min.js',
    M['url']['public_web_js']+'form.js'
];
M['plugin']['datatables']=[
    M['url']['public_web_plugins']+'datatables/dataTables.bootstrap.min.css',
    M['url']['public_web_plugins']+'datatables/jquery.dataTables.min.js',
    M['url']['public_web_js']+'datatable.js'
];
M['plugin']['ueditor']=M['url']['public_plugins']+'ueditor/ueditor.all.min.js';
M['plugin']['minicolors']=[
    M['url']['public_plugins']+'minicolors/jquery.minicolors.css',
    M['url']['public_plugins']+'minicolors/jquery.minicolors.min.js'
];
M['plugin']['tokenfield']=[
    M['url']['public_plugins']+'bootstrap-tokenfield/bootstrap-tokenfield.min.css',
    M['url']['public_plugins']+'bootstrap-tokenfield/bootstrap-tokenfield.min.js',
    M['url']['public_web_register']+'bootstrap-tokenfield.min.js'
];
M['plugin']['ionrangeslider']=[
    M['url']['public_plugins']+'ionrangeslider/ion.rangeslider.min.css',
    M['url']['public_plugins']+'ionrangeslider/ion.rangeSlider.min.js'
];
M['plugin']['datetimepicker']=[
    M['url']['public_plugins']+'time/jquery.datetimepicker.css',
    M['url']['public_plugins']+'time/jquery.datetimepicker.js'
];
M['plugin']['select-linkage']=M['url']['public_plugins']+'select-linkage/jquery.cityselect.js';
M['plugin']['alertify']=[
    M['url']['public_web_plugins']+'alertify/alertify.min.css',
    M['url']['public_web_plugins']+'alertify/alertify.js',
    M['url']['public_web_register']+'alertify.min.js'
];
M['plugin']['selectable']=[
    M['url']['public_web_register']+'asselectable.min.js',
    M['url']['public_web_register']+'selectable.min.js'
];
M['plugin']['fileinput']=[
    M['url']['public_fonts']+'glyphicons/glyphicons.min.css',
    M['url']['public']+'admin_old/plugins/fileinput/css/fileinput.min.css',
    M['url']['public_web_plugins']+'fileinput/fileinput.min.js'
];
M['plugin']['lazyload']=M['url']['public_plugins']+'jquery.lazyload.min.js';
M['plugin']['hover-dropdown']=M['url']['public_plugins']+'bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js';
M['plugin']['asscrollable']=[
    M['url']['public_plugins']+'asscrollable/asScrollable.min.css',
    M['url']['public_plugins']+'asscrollbar/jquery-asScrollbar.min.js',
    M['url']['public_plugins']+'asscrollable/jquery-asScrollable.min.js',
    M['url']['public_web_register']+'asscrollable.min.js'
]
M['plugin']['touchspin']=[
    M['url']['public_plugins']+'bootstrap-touchspin/bootstrap-touchspin.min.css',
    M['url']['public_plugins']+'bootstrap-touchspin/bootstrap-touchspin.min.js'
]
M['plugin']['masonry']=M['url']['public_plugins']+'masonry/masonry.pkgd.min.js';
M['plugin']['appear']=[
    M['url']['public_plugins']+'jquery-appear/jquery.appear.min.js',
    M['url']['public_web_register']+'jquery-appear.min.js'
];
M['plugin']['ladda']=[
    M['url']['public_plugins']+'ladda/ladda.min.css',
    M['url']['public_plugins']+'ladda/spin.min.js',
    M['url']['public_plugins']+'ladda/ladda.min.js',
    M['url']['public_web_register']+'ladda.min.js'
];
M['plugin']['webui-popover']=[
    M['url']['public_plugins']+'webui-popover/webui-popover.min.css',
    M['url']['public_plugins']+'webui-popover/jquery.webui-popover.min.js'
];
// 系统功能
$.fn.extend({
    // 编辑器
    metEditor:function(){
        if(!$(this).length) return;
        var $self=$(this);
        if(typeof UE_VAL =='undefined' || typeof textarea_editor_val =='undefined') window.UE_VAL=window.textarea_editor_val=[];
        $.include(M['plugin'][M.met_editor],function(){
            $self.each(function(index, val) {
                var editor_y=parseInt($(this).data('editor-y'))||400;
                    index1=$(this).index('textarea[data-plugin="editor"]');
                    $(this).attr({id:'met-editor'+index1});
                if(M.met_editor=='ueditor'){// 百度编辑器
                    if(UE_VAL[index1]) UE_VAL[index1].destroy();
                    UE_VAL[index1]=UE.getEditor(val.id,{
                        scaleEnabled:true, // 是否可以拉伸长高,默认false(当开启时，自动长高失效)
                        autoFloatEnabled:false, // 是否保持toolbar的位置不动，默认true
                        initialFrameWidth : parseInt($(this).data('editor-x'))||'100%',
                        initialFrameHeight : editor_y,
                    });
                }else if(M.met_editor=='editormd'){// markdown编辑器
                    $(this).text(toMarkdown($(this).text(), {gfm: true}));
                    var id='editormd-'+new Date().getTime();
                    if($('#'+id).length) id+=index;
                    $(this).wrap('<div id="'+id+'" class="mb-0"></div>');
                    UE_VAL[index1] = editormd(id, {
                        name:$(this).attr('name'),
                        height: editor_y,
                        htmlDecode: true,
                        saveHTMLToTextarea: true,
                        path: M.url.app+'editorswith/editormd/lib/',
                        // emoji:1,
                        imageUpload: true,
                        // imageFormats: ["jpg", "jpeg", "gif", "png", "bmp", "webp"]
                    });
                    UE_VAL[index1].setContent=function(value){
                        UE_VAL[index1].setValue(toMarkdown(value, {gfm: true}));
                    };
                }
            });
        });
    },
    // 日期时间选择器
    metDatetimepicker:function(){
        if(!$(this).length) return;
        $(this).each(function(index, el) {
            var $self=$(this);
            $(this).datetimepicker({
                lang:M.synchronous=='cn'?'ch':'en',
                timepicker:$self.attr("data-day-type")==2?true:false,
                format:$self.attr("data-day-type")==2?'Y-m-d H:i:s':'Y-m-d',
                onSelectDate:function(ct,$i){
                    $self.trigger('change');
                },
                onSelectTime:function(ct,$i){
                    $self.trigger('change');
                }
            });
        });
    },
    // 联动菜单
    metCitySelect:function(){
        if(!$(this).length) return;
        if(typeof citySelect =='undefined') window.citySelect=[];
        $(this).each(function(index){
            var option = {
                    url: $(this).attr('data-select-url')?$(this).attr('data-select-url'):M['url']['public_plugins']+'select-linkage/citydata.min.json',
                    prov: $(this).find(".prov").attr("data-checked"),
                    city: $(this).find(".city").attr("data-checked"),
                    dist: $(this).find(".dist").attr("data-checked"),
                    value_key: 'id',
                    nodata: 'none',
                    required:false
                };
            if($(this).hasClass('shop-address-select')){
                $.extend(option,{
                    country:$(this).find(".country").attr("data-checked"),
                    country_name_key:'name',
                    p_name_key:'name',
                    n_name_key:'name',
                    s_name_key:'name',
                    p_children_key:'children',
                    n_children_key:'children',
                    getCityjson:function(json,key){
                        key=key||0;
                        return json[key]['children'];
                    }
                });
            }
            citySelect[index]=$(this).citySelect(option);
        });
    },
    // 上传文件
    metFileInput:function(){
        if(!$(this).length) return;
        var errorFun=function(obj,data){
                obj.parents('.file-input').find('.file-preview-thumbnails .file-preview-frame.disabled').remove();
                // 显示报错文字
                // obj.removeClass('has-success').addClass('has-danger');
                // if(!obj.find('small.form-control-label').length) obj.append('<small class="form-control-label"></small>');
                // obj.find('small.form-control-label').text(data.response.error);
            },
            successFun=function(obj1,data,multiple){
                var $obj1=obj1.parents('.input-group').find('input[type="hidden"][name="'+obj1.attr('name')+'"]'),
                    $obj2=obj1.parents('.file-input'),
                    path='';
                if(multiple){
                    path=$obj1.val()?$obj1.val()+','+data.response.path:data.response.path;
                }else{
                    path=data.response.path;
                    $obj2.find('.file-preview-thumbnails .file-preview-frame:last-child').prev().remove();
                }
                $obj1.val(path).trigger('change'); // input值更新
                // 显示上传成功文字
                $obj2.find('.input-group .file-caption-name').html('<span class="glyphicon glyphicon-file kv-caption-icon"></span>'+path).attr({title:path});
                $obj2.parents('.form-group').removeClass('has-danger').addClass('has-success');
                if(!$obj2.parents('.form-group').find('small.form-control-label').length) $obj2.parents('.form-group').append('<small class="form-control-label"></small>');
                var tips=M['langtxt'].jsx17||M['langtxt'].fileOK;
                $obj2.parents('.form-group').find('small.form-control-label').text(tips);
                $('.img-library-modal').attr({'data-update':1});
            };
        $(this).each(function(index, el) {
            if(!(typeof MET['url']['basepath']!='undefined' || (typeof $(this).data('url')!='undefined' && $(this).data('url').indexOf('c=uploadify&m=include&a=dohead')>=0))) return;
            var $self=$(this),
                $form_group=$(this).parents('.form-group:eq(0)'),
                name=$(this).attr('name'),
                url=$(this).data('url')||M['url']['system']+'entrance.php?lang='+M['lang']+'&c=uploadify&m=include&a=doupfile&type=1',
                multiple=typeof $(this).attr('multiple') !='undefined'?true:false,
                minFileCount=$(this).data('fileinput-minfilecount')||1,
                maxFileCount=$(this).data('fileinput-maxfilecount')||20,
                maxFileSize=$(this).data('fileinput-maxfilesize')||0,
                accept=$(this).attr('accept')||'',
                format='',
                initialPreview=[],
                dropZoneEnabled=$(this).data('drop-zone-enabled')=='false'?false:true,
                value=$(this).attr('value');
            if(typeof value !='undefined' && value!='' && (value.indexOf('.png')>=0||value.indexOf('.jpeg')>=0||value.indexOf('.jpg')>=0||value.indexOf('.bmp')>=0||value.indexOf('.gif')>=0||value.indexOf('.ico')>=0)){
                if(value.indexOf(',')>=0){
                    value=value.split(',');
                }else{
                    value=[value];
                }
                $.each(value, function(index, val) {
                    var html='<a href="'+val+'" target="_blank"><img src="'+val+'" class="file-preview-image"></a>'
                            +'<div class="file-thumbnail-footer">'
                                +'<div class="file-caption-name" title="'+val+'">'+val+'</div>'
                                    +'<div class="file-actions">'
                                    +'<div class="file-footer-buttons">'
                                        +'<button type="button" class="kv-file-remove btn btn-xs btn-default" title="Remove file"><i class="glyphicon glyphicon-trash text-danger"></i></button>'
                                    +'</div>'
                                    +'<div class="clearfix"></div>'
                                +'</div>'
                            +'</div>';
                    initialPreview.push(html);
                });
            }
            if(accept){
                if(accept.indexOf(',')>=0){
                    accept=accept.split(',');
                }else{
                    accept=[accept];
                }
                $.each(accept, function(index, val) {
                    val=val.indexOf('/')>=0?val.split('/')[1]:'';
                    if(val.indexOf('x-')>=0) val=val.replace('x-','');
                    switch(val){
                        case 'icon':
                            val='ico';
                            break;
                        case 'jpeg':
                            val='jpg';
                            break;
                        case '*':
                            val='';
                            break;
                    }
                    if(val){
                        if(format) format+='|';
                        format+=val;
                    }
                });
                if(accept=='image/*') format='jpg|jpeg|png|bmp|gif|webp|ico';
            }
            if(format) url+='&format='+format;
            var allowedFileExtensions=format?(format.indexOf('|')?format.split('|'):[format]):'';
            $(this).removeAttr('hidden').fileinput({// fileinput插件
                uploadUrl: url,            // 处理上传
                uploadAsync:multiple,      // 异步批量上传
                allowedFileExtensions:allowedFileExtensions,// 接收的文件后缀
                minFileCount:minFileCount,
                maxFileCount:maxFileCount,
                maxFileSize:maxFileSize,
                language:typeof M.synchronous!='undefined'?(M.synchronous=='cn'?'zh':'en'):'zh',// 语言文字
                initialPreview:initialPreview,
                initialCaption:value,         // 初始化输入框值
                // showCaption:false,         // 输入框
                // showRemove:false,          // 删除按钮
                // browseLabel:'',            // 按钮文字
                showUpload:false,             // 上传按钮
                dropZoneEnabled:dropZoneEnabled,// 是否显示拖拽区域
                // browseClass:"btn btn-primary", //按钮样式
            }).on("filebatchselected", function(event, files) {
                $(this).fileinput("upload");
            }).on('filebatchuploadsuccess', function(event, data, previewId, index) {// 同步上传成功结果处理
                successFun($(this),data,multiple);
            }).on('fileuploaded', function(event, data, previewId, index) {// 异步上传成功结果处理
                successFun($(this),data,multiple);
            }).on('filebatchuploaderror', function(event, data, previewId, index) {// 同步上传错误结果处理
                errorFun($(this),data);
            }).on('fileuploaderror', function(event, data, previewId, index) {// 异步上传错误结果处理
                errorFun($(this),data);
            });
            if(!$(this).parents('form').find('input[type="hidden"][name="'+name+'"]').length) $(this).after('<input type="hidden" name="'+name+'" value="'+value+'">');
            // $(this).siblings('i').attr({class:'icon wb-upload'}).parents('.btn-file').insertAfter($(this).parents('.file-input'));
        });
        // 删除图片后图片路径数据更新
        if(typeof fileinput_remove=='undefined'){
            window.fileinput_remove=1;
            // 删除图片后图片路径数据更新
            $(document).on('click', '.file-input .file-preview-thumbnails .file-preview-frame .kv-file-remove,.fileinput-remove', function(event) {
                event.preventDefault();
                var $file_input=$(this).parents('.file-input'),
                    $file=$file_input.find('input[type="file"]'),
                    name=$file.attr('name'),
                    multiple=typeof $file.attr('multiple') !='undefined'?true:false,
                    $input_name=$file_input.find('input[type="hidden"][name="'+name+'"]'),
                    input_value=$input_name.val(),
                    $caption_name=$file_input.find('.input-group .file-caption-name');
                if(input_value){
                    if($(this).hasClass('kv-file-remove')){
                        var $parents=$(this).parents('.file-preview-frame'),
                            active=$parents.index(),
                            path='';
                        setTimeout(function(){
                            var input_value=$input_name.val();
                            if($parents.length) $parents.remove();
                            if(multiple){
                                if(input_value){
                                    if(input_value.indexOf(',')>=0){
                                        input_value=input_value.split(',');
                                    }else{
                                        input_value=[input_value];
                                    }
                                    $.each(input_value, function(index, val) {
                                        if(index!=active) path=path?path+','+val:val;
                                    });
                                }
                            }else{
                                var $file_preview_frame=$file_input.find('.file-preview-thumbnails .file-preview-frame');
                                path=$file_preview_frame.length?$file_preview_frame.find('img').attr('src'):'';
                            }
                            if(path){
                                if($input_name.val()) $input_name.val(path).trigger('change'); // input值更新
                            }else if(multiple && !$file_input.find('.file-drop-zone-title').length){
                                $file_input.find('.fileinput-remove').click();
                            }
                            $caption_name.html('<span class="glyphicon glyphicon-file kv-caption-icon"></span>'+path).attr({title:path});
                        },1000)
                        if(!multiple) $file_input.find('.fileinput-remove').click();
                    }else{
                        $input_name.val('').trigger('change'); // input值更新
                        $caption_name.html('<span class="glyphicon glyphicon-file kv-caption-icon"></span>').removeAttr('title');
                    }
                    $(this).parents('form-group').removeClass('has-success').find('small.form-control-label').remove();
                }
            });
            // 图片库-点击按钮
            $(document).on('click', '.file-input .fileinput-file-choose', function(event) {
                if(!$('.img-library-modal').length){
                    var html='<div class="modal fade modal-info img-library-modal" data-keyboard="false" data-backdrop="false" data-update="1">'
                                +'<div class="modal-dialog modal-lg h-100p m-y-0 m-x-auto">'
                                    +'<div class="modal-content h-100p">'
                                        +'<div class="modal-header">'
                                            +'<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>'
                                            +'<h4 class="modal-title inline-block">选择图片</h4>'
                                            +'<span class="yellow-600 font-size-16 inline-block m-l-10">单击图片即可选中</span>'
                                        +'</div>'
                                        +'<div class="modal-body p-r-20 oya met-scrollbar img-library-body">'
                                            +'<ul class="img-library-list blocks-2 blocks-sm-3 blocks-md-4 blocks-xl-5 blocks-xxl-6"></ul>'
                                            +'<div class="vertical-align h-100p w-full text-xs-center img-library-loader"><div class="loader loader-round-circle vertical-align-middle"></div></div>'
                                        +'</div>'
                                        +'<div class="modal-footer bg-blue-grey-100">'
                                            +'<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>'
                                            +'<button type="submit" class="btn btn-info">保存</button>'
                                        +'</div>'
                                    +'</div>'
                                +'</div>'
                            +'</div>';
                    $('body').append(html);
                    $('.img-library-modal').modal();
                }
                $('.img-library-modal button[type="submit"]').attr({'data-id':$(this).parents('.file-input').find('input[type="file"]').attr('id')});
            });
            // 图片库-弹框
            $(document).on('show.bs.modal', '.img-library-modal', function(event) {
                if($(this).attr('data-update')){
                    var $loader=$('.img-library-loader',this),
                        $list=$('.img-library-list',this);
                    $loader.show();
                    $list.html('');
                    $.ajax({
                        url: '/api/upload/getFileList',
                        type: 'POST',
                        dataType: 'json',
                        success:function(result){
                            if(parseInt(result.status)){
                                var html='';
                                $.each(result.data, function(index, val) {
                                    val.fsize=parseInt(val.fsize/1024)+'kb';
                                    html+='<li class="text-xs-center m-b-10">'
                                        +'<a href="javascript:;" title="'+val.fname+'，大小：'+val.fsize+'" class="block p-5 vertical-align h-100">'
                                            +'<img '+(index>5?'data-original':'src')+'="'+val.fpath+'" class="vertical-align-middle"/>'
                                            +'<i class="icon fa-check font-size-14 white"></i>'
                                        +'</a>'
                                    +'</li>';
                                });
                                if(!html) html='<div class="text-xs-center h-300 vertical-align"><div class="vertical-align-middle font-size-20">暂无可选择图片，请上传图片</div>';
                                $loader.hide();
                                $list.html(html).find('[data-original]').metLazyLoad({container:'.img-library-body'});
                                $('.img-library-modal').removeAttr('data-update');
                            }
                        }
                    });
                }else{
                    $('.img-library-modal .img-library-list li a').removeClass('active');
                }
            });
            // 图片库-选择图片
            $(document).on('click', '.img-library-modal .img-library-list li a', function(event) {
                var multiple=$('.file-input #'+$('.img-library-modal button[type="submit"]').attr('data-id')).attr('multiple')?true:false;
                $(this).toggleClass('active');
                if(!multiple) $(this).parents('li').siblings('li').find('a').removeClass('active');
            })
            // 图片库-提交
            $(document).on('click', '.img-library-modal button[type="submit"]', function(event) {
                var $self=$(this),
                    $img_library_modal=$('.img-library-modal'),
                    img_url='';
                $img_library_modal.find('.img-library-list li a.active img').each(function(index, el) {
                    img_url+=(index?',':'')+$(this).attr('src');
                });
                metAlertifyLoadFun(function(){
                    if(img_url){
                        $('.file-input #'+$self.attr('data-id')).metFileInputChange(img_url);
                        $img_library_modal.modal('hide');
                        alertify.success('图片选择成功');
                    }else{
                        alertify.error('请选择图片');
                    }
                });
            });
            // 外部图片-弹框
            $(document).on('click', '.file-input .fileinput-file-other', function(event) {
                if(!$('.img-other-modal').length){
                    var html='<div class="modal fade modal-warning img-other-modal" data-keyboard="false" data-backdrop="false" data-update="1">'
                                +'<div class="modal-dialog modal-center">'
                                    +'<div class="modal-content">'
                                        +'<div class="modal-header">'
                                            +'<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>'
                                            +'<h4 class="modal-title">添加外部图片</h4>'
                                        +'</div>'
                                        +'<div class="modal-body">'
                                            +'<div class="form-group m-b-0"><input type="text" name="img_url" placeholder="请输入外部图片链接" class="form-control"/></div>'
                                        +'</div>'
                                        +'<div class="modal-footer bg-blue-grey-100">'
                                            +'<button type="button" class="btn btn-default m-r-5" data-dismiss="modal">取消</button>'
                                            +'<button type="submit" class="btn btn-warning">保存</button>'
                                        +'</div>'
                                    +'</div>'
                                +'</div>'
                            +'</div>';
                    $('body').append(html);
                    $('.img-other-modal').modal();
                }
                $('.img-other-modal [name="img_url"]').val('');
                $('.img-other-modal button[type="submit"]').attr({'data-id':$(this).parents('.file-input').find('input[type="file"]').attr('id')});
            });
            // 外部图片-提交
            $(document).on('click', '.img-other-modal button[type="submit"]', function(event) {
                var $self=$(this),
                    $img_other_modal=$('.img-other-modal'),
                    img_url=$img_other_modal.find('[name="img_url"]').val();
                metAlertifyLoadFun(function(){
                    if(img_url){
                        $('.file-input #'+$self.attr('data-id')).metFileInputChange(img_url);
                        $img_other_modal.modal('hide');
                        alertify.success('图片添加成功');
                    }else{
                        alertify.error('请输入外部图片链接');
                        $img_other_modal.find('[name="img_url"]').focus();
                    }
                });
            });
        }
    },
    // 上传图片组件改变值
    metFileInputChange:function(img_url){
        var $file_input=$(this).parents('.file-input'),
            name=$(this).attr('name'),
            html='',
            img_urls=img_url.indexOf(',')>=0?img_url.split(','):[img_url];
        if($(this).attr('multiple')){
            var old_val=$file_input.find('input[type="hidden"][name="'+name+'"]').val();
            if(old_val){
                old_val=old_val.indexOf(',')>=0?old_val.split(','):[old_val];
                img_url=old_val+','+img_url;
            }else{
                old_val=[];
            }
            if(old_val!=img_urls) img_urls=old_val.concat(img_urls);
        }
        $.each(img_urls, function(index, val) {
            html+='<div class="file-preview-frame file-preview-initial">'
                    +'<a href="'+val+'" target="_blank"><img src="'+val+'" class="file-preview-image"></a>'
                        +'<div class="file-thumbnail-footer">'
                            +'<div class="file-caption-name" title="'+val+'">'+val+'</div>'
                                +'<div class="file-actions">'
                                +'<div class="file-footer-buttons">'
                                    +'<button type="button" class="kv-file-remove btn btn-xs btn-default" title="Remove file"><i class="glyphicon glyphicon-trash text-danger"></i></button>'
                                +'</div>'
                                +'<div class="clearfix"></div>'
                            +'</div>'
                        +'</div>'
                    +'</div>';
        });
        if(html && $file_input.hasClass('file-input-new')) $file_input.removeClass('file-input-new');
        $file_input.find('.file-drop-zone .file-drop-zone-title').remove();
        $file_input.find('.file-preview-thumbnails').html(html);
        $file_input.find('.input-group .file-caption-name').html('<span class="glyphicon glyphicon-file kv-caption-icon"></span>'+img_url).attr({title:img_url});
        $file_input.find('input[type="hidden"][name="'+name+'"]').val(img_url).trigger('change');
    },
    // 单选、多选默认选中
    metRadioCheckboxChecked:function(){
        if(!$(this).length) return;
        $(this).each(function(index, el) {
            var checked=String($(this).attr('data-checked')),
                delimiter=$(this).data('delimiter')||'#@met@#';
            if(checked !='undefined'){
               checked=checked.indexOf(delimiter)>=0?checked.split(delimiter):[checked];
                var name=$(this).attr('name');
                $(this).parents('form').find('input[name="'+name+'"]').removeAttr('checked');
                for (var i=0; i < checked.length; i++) {
                    $(this).parents('form').find('input[name="'+name+'"][value="'+checked[i]+'"]').attr('checked', true).prop({checked:true});
                }
            }
        });
    },
    // 下拉菜单默认选中
    metSelectChecked:function(){
        if(!$(this).length) return;
        $(this).each(function(index, el) {
            $('option[value="'+$(this).attr('data-checked')+'"]',this).attr({selected:true});
        });
    },
    // 图片延迟加载
    metLazyLoad:function(options){
        if(!$(this).length) return;
        var $self=$(this);
        metFileLoadFun(M['plugin']['lazyload'],function(){
            return typeof $.fn.lazyload=='function';
        },function(){
            $self.lazyload(options);
        });
    },
    // 表单删除按钮ajax提交
    metFormAjaxDel:function(url){
        var $form=$(this).parents('form'),
            del_id=$form.find('[name="all_id"]')?$form.find('[name="all_id"]').val():'';
        if(del_id!=''){
            $.ajax({
                url: $(this).data('url')||$form.attr('action'),
                type: "POST",
                dataType:'json',
                data:{del_id:del_id},
                success: function(result){
                    metAjaxFun({result:result});
                }
            });
        }else{
            metAlert(METLANG.jslang3,'','bgshow',0);
        }
    },
    // 表单两种类型提交前的处理（保存、删除）
    metSubmit:function(type){
        // 插入submit_type字段
        var type=typeof type!='undefined'?type:1,
            type_str=type?'save':'delet';
        if($(this).find('[name="submit_type"]').length){
            $(this).find('[name="submit_type"]').val(type_str);
        }else $(this).append('<input type="hidden" name="submit_type" value="'+type_str+'"/>');
        // 插入表格的all_id字段
        if($(this).find('table').length){
            var $table=$(this).find('table'),
                checked_str=type?'':':checked',
                $checkbox=$table.find('tbody input[type="checkbox"][name="id"]'+checked_str),
                all_id='';
            $checkbox.each(function(index, el) {
                all_id+=all_id?','+$(this).val():$(this).val();
            })
            if(!$(this).find('[name="all_id"]').length) $(this).append('<input type="hidden" name="all_id"/>');
            $(this).find('[name="all_id"]').val(all_id);
        }
    },
    // 表单更新验证
    metFormAddField:function(name){
        var $form=$(this)[0].tagName=='FORM'?$(this):$(this).parents('form');
        if($form.length){
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
                var name_array=[];
                $('[name]',this).each(function(index, el) {
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
        }
    },
    // 点击ajax请求弹出确认框后以及返回结果通用处理
    metClickConfirmAjax:function(default_options){
        var default_options = $.extend({
                ajax_data:'',
                true_text:METLANG.confirm,
                false_text:METLANG.cancel,
                confirm_text:METLANG.delete_information,
                true_fun:function(){
                    var url=typeof this.url=='function'?this.url():this.url,
                        ajax_data=typeof this.ajax_data=='function'?this.ajax_data():this.ajax_data,
                        options_this=this;
                    $.ajax({
                        url: url,
                        type: ajax_data?'POST':'GET',
                        dataType: 'json',
                        data:ajax_data,
                        success:function(result){
                            options_this.ajax_fun(result);
                        }
                    });
                },
                false_fun:'',
                ajax_fun:function(result){
                    metAjaxFun({result:result});
                }
            },default_options);
        $(document).on('click', this.selector, function(event) {
            var options = $.extend({
                    el:$(this),
                    url:$(this).data('url')
                },default_options);
            metAlertifyLoadFun(function(){
                var confirm_text=typeof options.confirm_text=='function'?options.confirm_text():options.confirm_text;
                alertify.okBtn(options.true_text).cancelBtn(options.false_text).confirm(confirm_text, function (ev) {
                    options.true_fun();
                },function(){
                    if(typeof options.false_fun=='function') options.false_fun();
                });
            })
        });
    },
    // 通用功能开启
    metCommon:function(){
        var dom=this;
        // 表单验证
        if($('form',dom).length){
            if(typeof validate =='undefined'){
                $.include(M['plugin']['formvalidation']);
            }else{
                $(dom).metValidate();
            }
        }
        // ajax表格
        if($('.dataTable',dom).length){
            if(typeof datatable =='undefined'){
                $.include(M['plugin']['datatables']);
            }else{
                $(dom).metDataTable();
            }
        }
        // 编辑器
        if($('textarea[data-plugin="editor"]',dom).length && typeof MET['url']['basepath']!='undefined') $('textarea[data-plugin="editor"]',dom).metEditor();
        // 颜色选择器
        if($('input[data-plugin="minicolors"]',dom).length) $.include(M['plugin']['minicolors'],function(){
            $('input[data-plugin="minicolors"]',dom).minicolors();
        });
        // 标签
        if($('input[data-plugin="tokenfield"]',dom).length) $.include(M['plugin']['tokenfield'],'','siterun');
        // 滑块
        if($('input[type="text"][data-plugin="ionRangeSlider"]',dom).length) $.include(M['plugin']['ionrangeslider'],'','siterun');
        // 日期选择器
        if($('input[data-plugin="datetimepicker"]',dom).length) $.include(M['plugin']['datetimepicker'],function(){
            $('input[data-plugin="datetimepicker"]',dom).metDatetimepicker();
        });
        // 联动菜单
        if($('[data-plugin="select-linkage"]',dom).length) $.include(M['plugin']['select-linkage'],function(){
            $('[data-plugin="select-linkage"]',dom).metCitySelect();
        });
        // 模态对话框
        if($('[data-plugin="alertify"]',dom).length) $.include(M['plugin']['alertify'],'','siterun');
        // 全选、全不选
        if($('[data-plugin="selectable"]',dom).length) $.include(M['plugin']['selectable'],'','siterun');
        // 上传文件
        if($('input[type="file"][data-plugin="fileinput"]',dom).length) $.include(M['plugin']['fileinput'],function(){
            $('input[type="file"][data-plugin="fileinput"]',dom).metFileInput();
        })
        // 滚动条
        if($('[data-plugin="scrollable"]',dom).length) $.include(M['plugin']['asscrollable'],'','siterun');
        // 单选、多选默认选中
        if($('input[data-checked]',dom).length) $('input[data-checked]',dom).metRadioCheckboxChecked();
        // 下拉菜单默认选中
        if($('select[data-checked]',dom).length) $('select[data-checked]',dom).metSelectChecked();
        // 数量改变
        if($('[data-plugin="touchSpin"]',dom).length && typeof $.fn.TouchSpin =='undefined') $.include(M['plugin']['touchspin'],function(){
            $('[data-plugin="touchSpin"]',dom).TouchSpin();
        });
        // 图片延迟加载
        if($('[data-original]',dom).length && dom!=document) $('[data-original]',dom).metLazyLoad();
    }
});
// 通用功能开启
$(document).metCommon();
// 勾选开关
$(document).on('change', 'input[type="checkbox"][data-plugin="switchery"]', function(event) {
    var val=$(this).is(':checked')?1:0;
    $(this).val(val);
});
// tokenfield插件输入框值更新后
$(document).on('change', '.tokenfield .token-input', function(event) {
    $(this).parents('.tokenfield').find('[name][data-fv-field]').trigger('change');
});
$(function(){
    // 非前台模板页面-兼容老模板
    if(M['url']['basepath'] || $('script[src*="js/basic_web.js"]').length){
        // 返回顶部
        $(".met-scroll-top").click(function(){
            $('html,body').animate({scrollTop:0},300);
        });
        // 返回顶部按钮显示/隐藏
        var wh=$(window).height();
        $(window).scroll(function(){
            if($(this).scrollTop()>wh){
                $(".met-scroll-top").removeAttr('hidden').addClass("animation-slide-bottom");
            }else{
                $(".met-scroll-top").attr({hidden:''}).removeClass('animation-slide-bottom');
            }
        });
    }
    // 会员侧栏手机端当前页面标题显示在导航徒步
    Breakpoints.on('xs sm',{
        enter:function(){
            if($('.met-sidebar-nav-active-name').length) $('.met-sidebar-nav-active-name').html($('.met-sidebar-nav-mobile .dropdown-menu .dropdown-item.active').text());
        }
    })
    // 在&pageset=1弹窗中时，页面的表单提交地址添加参数pageset=1
    if(getQueryString('pageset')) $('form').each(function(index, el) {
        if($(this).attr('action')) $(this).attr({action:$(this).attr('action')+'&pageset=1'});
    });
    // 下拉展开时下拉图标旋转
    $(document).on('click', '[data-toggle="collapse"]', function(event) {
        var $icon=$('.icon[class*="fa-angle-"]',this);
        if($icon.length){
            if(!$icon.hasClass('transition500')) $icon.addClass('transition500');
            if($($(this).data('target')).height()){
                $icon.removeClass('fa-rotate-90');
            }else{
                $icon.addClass('fa-rotate-90');
            }
        }
    });
    // 表单功能
    // 添加项
    $(document).on('click', '[table-addlist]', function(event) {
        var $self=$(this),
            $table=$(this).parents('table').length?$(this).parents('table'):$($(this).data('table-id')),
            addlist=function(data){
                $table.find('tbody').append(data);
                var $new_tr=$table.find('tbody tr:last-child');
                if(!$new_tr.find('[table-cancel]').length && typeof $self.data('nocancel')=='undefined') $new_tr.find('td:last-child').append('<button type="button" class="btn btn-default btn-outline m-l-5" table-cancel>'+METLANG.js49+'</button>');
                // 添加表单验证
                $new_tr.metFormAddField();
            };
        if($table.find('[table-addlist-data]').length){
            var html=$table.find('[table-addlist-data]').val();
            addlist(html);
        }else{
            if(typeof datatable_option=='undefined') window.datatable_option=[];
            var datatable_index=$table.index('.dataTable');
            if(typeof datatable_option[datatable_index]=='undefined') datatable_option[datatable_index]=[];
            if(typeof datatable_option[datatable_index]['new_id']=='undefined'){
                datatable_option[datatable_index]['new_id']=0;
            }else{
                datatable_option[datatable_index]['new_id']++;
            }
            $.ajax({
                url: $(this).data('url'),
                type: 'POST',
                data:{new_id:datatable_option[datatable_index]['new_id']},
                success:function(result){
                    addlist(result);
                }
            });
        }
    });
    // 撤销项
    $(document).on('click', '[table-cancel]', function(event) {
        $(this).parents('tr').remove();
    })
    // 删除项-不提交
    $(document).on('click', '[table-del]', function(event) {
        var $self=$(this),
            remove=function(){
                alertify.theme('bootstrap').okBtn(METLANG.confirm).cancelBtn(METLANG.cancel).confirm(METLANG.delete_information, function (ev) {
                    $self.parents('tr').remove();
                })
            };
        metAlertifyLoadFun(function(){
            remove();
        });
    })
    // 点击保存按钮
    $(document).on('click', 'form .btn[type="submit"]', function(event) {
        if($(this).data('plugin')=='alertify' && $(this).data('type')=='confirm') event.preventDefault();
        $(this).parents('form').metSubmit();
    })
    // 删除多项提交
    $(document).on('click', '[table-delet]', function(event) {
        event.preventDefault();
        var $form=$(this).parents('form');
        $form.metSubmit(0);
        if($(this).data('plugin')!='alertify'){
            if($(this).data('url')){
                $(this).metFormAjaxDel();
            }else $form.submit();
        }
    })
    // 表单输入框回车时，触发提交按钮
    $(document).on('keydown', 'form input[type="text"]', function(event) {
        if(event.keyCode==13){
            event.preventDefault();
            $(this).parents('form').find('[type="submit"]:not(.fv-hidden-submit)').click();
        }
    });
    // 表单提交
    $(document).on('submit', 'form', function(event) {
        // 提交删除时没有勾选时提示
        if($(this).find('[name="submit_type"]').length && $(this).find('[name="submit_type"]').val()=='delet' && $(this).find('[name="all_id"]').val()==''){
            event.preventDefault();
            metAlert(METLANG.jslang3,'','bgshow',0);
        }
    });
});
// 判断是否加载了formvalidation后回调
function metFormvalidationLoadFun(fun){
    metFileLoadFun(M['plugin']['formvalidation'],function(){
        return typeof $.fn.metValidate=='function';
    },function(){
        if(typeof fun=='function') fun();
    });
}
// 判断是否加载了alertify后回调
function metAlertifyLoadFun(fun){
    metFileLoadFun(M['plugin']['alertify'],function(){
        return typeof alertify!='undefined';
    },function(){
        if(typeof fun=='function') fun();
    });
}
// ajax请求返回后通用处理
function metAjaxFun(options){
    options = $.extend({
        result:'',
        false_fun:'',
        true_fun:'',
        status_key:'status',
        msg_key:'msg',
        true_val:function(){
            return parseInt(options.result[options.status_key]);
        }
    },options);
    metAlertifyLoadFun(function(){
        if(options.true_val()){
            if(typeof options.result[options.msg_key]!='undefined' && options.result[options.msg_key]!='') alertify.success(options.result[options.msg_key]);
            if(typeof options.true_fun=='function'){
                options.true_fun();
            }else{
                setTimeout(function(){
                    location.reload();
                },1000);
            }
        }else{
            if(typeof options.result[options.msg_key]!='undefined' && options.result[options.msg_key]!='') alertify.error(options.result[options.msg_key]);
            if(typeof options.false_fun=='function') options.false_fun();
        }
    });
}
// 设置cookie
function setCookie(name,value,path,term){
    var exp = new Date(),
        terms =term||30,
        paths =path||'/';
    exp.setTime(exp.getTime() + terms*24*60*60*1000);
    document.cookie = name + "="+ value + ";path="+paths+";expires=" + exp.toGMTString();
}
// 获取指定名称的cookie的值
function getCookie(name) {
    var cookie_str = document.cookie.split(";");
    for (var i = 0; i < cookie_str.length; i++) {
        cookie_str[i]=$.trim(cookie_str[i]);
        var index = cookie_str[i].indexOf("="),
            cookie_name = cookie_str[i].substring(0, index);
        if (cookie_name == name) {
            var temp = cookie_str[i].substring(index + 1);
            return decodeURIComponent(temp);
        }
    }
}