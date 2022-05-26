/**
 * 弹框组件
 * 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved.
 */
(function(){
    // 自定义弹框参数
    M.component.modal_options=[];
    M.component.modal_call_status=[];
    M.component.modal_call_status.this=[];
    // 弹框dom
    M.component.modalFun=function(options){
        var options=$.extend({
                id:'',
                modalOtherclass:'',
                modal_class:'',
                modalType:'',
                modalSize:'',
                modalTitle:'',
                modalFooterok:1,
                modalFooter:'',
                modalFooterclass:'',
                modalOktext:METLANG.save||'保存',
                modalNotext:METLANG.cancel||'取消',
                modalBody:M.component.loader({class_name:'modal-loader h-100',wrapper_class:'d-flex align-items-center justify-content-center h-100'})+'<div class="modal-html hide"></div>',
                modalBodyclass:'',
                modalKeyboard:false,
                modalBackdrop:false,
                modalUrl:'',
                modalDataurl:'',
                modalFullheight:0,
                modalRefresh:1,
                modalClose:1,
                modalHeaderclass:'',
                modalTitleclass:'',
                modalHeadercenter:'',
                modalHeaderappend:'',
                modalStyle:'',
                modalLoad:''
            },options);
        if(typeof M.component.modal_options[options.modal_class]!='undefined') options=$.extend(options,M.component.modal_options[options.modal_class]);
        var is_id=options.modal_class.substr(0,1)=='#'?1:0;
        options.id=is_id?options.modal_class.substr(1):'';
        options.modal_class_name=is_id?'':options.modal_class.substr(1);
        var html='<div class="modal fade met-scrollbar met-modal '+options.modalOtherclass+' '+options.modal_class_name+'" id="'+options.id+'" data-key="'+options.modal_class+'" data-keyboard="'+options.modalKeyboard+'" data-backdrop="'+options.modalBackdrop+'" '+(options.modalSubmitNoclose?'data-submit-noclose="1"':'')+' style="'+options.modalStyle+'">'
                +'<div class="modal-dialog modal-dialog-'+options.modalType+' modal-'+options.modalSize+' '+(options.modalFullheight?'my-0 mx-auto h-100 py-2':'')+'">'
                    +'<div class="modal-content '+(options.modalFullheight?'h-100':'')+'">'
                        +'<div class="modal-header d-block clearfix bg-dark text-white '+options.modalHeaderclass+'">'
                            +'<h6 class="modal-title float-left '+options.modalTitleclass+'">'+options.modalTitle+'</h6>'
                            +options.modalHeadercenter
                            +(options.modalClose?'<button type="button" class="close text-white h2" data-dismiss="modal" aria-label="Close"><span>×</span></button>':'')
                            +options.modalHeaderappend
                        +'</div>'
                        +'<div class="modal-body '+options.modalBodyclass+' '+(options.modalFullheight?'oya met-scrollbar':'')+'" data-url="'+options.modalUrl+'" data-dataurl="'+options.modalDataurl+'" data-refresh="'+options.modalRefresh+'" data-tablerefresh="'+options.modalTablerefresh+'" data-tablerefresh-type="'+options.modalTablerefreshType+'" data-loading="'+options.modalLoading+'" data-load="'+options.modalLoad+'">'+(typeof options.modalBody=='function'?options.modalBody():options.modalBody)+'</div>'
                        +(options.modalFooterok?('<div class="modal-footer clearfix d-block'+options.modalFooterclass+'">'
                            +(options.modalFooter?options.modalFooter:'')
                            +'<div class="float-right">'
                          +(options.modalNotext?('<button type="button" class="btn btn-default" data-dismiss="modal">'+options.modalNotext+'</button>'):'')
                          +(options.modalOktext?('<button type="button" class="btn btn-primary ml-1" data-ok>'+options.modalOktext+'</button>'):'')
                        +'</div></div>'):'')
                    +'</div>'
                +'</div>'
            +'</div>';
        return html;
    };
    // 弹框初始化
    $(document).on('click clicks', '[data-toggle="modal"]', function(event) {
        var modal_class=$(this).attr('data-target');
        if(!modal_class){
            modal_class='.modal-'+new Date().getTime();
            $(this).attr({'data-target':modal_class});
        }
        if(modal_class){
            var $modal_class=$(modal_class);
            if($modal_class.length){
                $modal_class.find('.modal-body').attr({'data-url':$(this).attr('data-modal-url'),'data-loading':$(this).attr('data-modal-loading'),'data-load':$(this).attr('data-modal-load'),'data-dataurl':$(this).attr('data-modal-dataurl')||'','data-tablerefresh':$(this).attr('data-modal-tablerefresh'),'data-tablerefresh-type':$(this).attr('data-modal-tablerefresh-type'),'data-title':$(this).attr('data-modal-title'),'data-body':$(this).attr('data-modal-body')||''});
                if(event.type=='clicks') $modal_class.trigger('shows');
            }else{
                var options=$(this).data();
                options.modal_class=modal_class;
                $('body').append(M.component.modalFun(options));
                $modal_class=$(modal_class);
                $modal_class.modal();
            }
        }
    });
    // 弹框弹出回调
    $(document).on('show.bs.modal shows', '.modal', function(event) {
        if(!$(this).hasClass('met-scrollbar')) $(this).addClass('met-scrollbar');
        // 弹框加载模板
        var $btn_ok=$('[data-ok]',this),
            key=$(this).data('key'),
            $modal=$('.modal[data-key="'+key+'"]'),
            $modal_body=$modal.find('.modal-body');
        setTimeout(function(){
            var url=$modal_body.attr('data-url'),
                refresh=$modal_body.attr('data-refresh'),
                tablerefresh=$modal_body.attr('data-tablerefresh'),
                loading=$modal_body.attr('data-loading'),
                title=$modal_body.attr('data-title'),
                tablerefresh_type=parseInt($modal_body.attr('data-tablerefresh-type')),
                body=$modal_body.attr('data-body'),
                callback=function(data){
                    // 弹框内容保存回调
                    setTimeout(function(){
                        var loadFun=function(){
                                $modal_body.find('form').length && metui.use('form',function(){
                                    $modal_body.find('form').each(function(index, el) {
                                        var validate_order=$(this).attr('data-validate_order');
                                        if(!M.component.modal_call_status.this[validate_order]){
                                            M.component.modal_call_status.this[validate_order]=1;
                                            var $form=$(this);
                                            formSaveCallback($(this).attr('data-validate_order'), {
                                                true_fun: function() {
                                                    if(!$form.find('.dataTable').length && !$modal.attr('data-submit-noclose')) $modal.modal('hide');
                                                    var $table = $('.dataTable[data-datatable_order="' + tablerefresh + '"]');
                                                    if (tablerefresh && $table.length) datatable[tablerefresh].row().draw(false);
                                                }
                                            });
                                        }
                                    });
                                });
                                $modal_body.removeAttr('data-loading');
                                M.component.modal_options[key] && typeof M.component.modal_options[key].callback=='function'&&M.component.modal_options[key].callback(key,data);
                            };
                        if(!parseInt($modal_body.attr('data-load'))){
                            loadFun();
                        }else{
                            var interval=setInterval(function(){
                                    !parseInt($modal_body.attr('data-load')) && (loadFun(),clearInterval(interval));
                                },50);
                        }
                    },100);
                }
                loadTemp=function(data){
                    var data=typeof data!='undefined'?data:'';
                    if(url && refresh!='0'){
                        $modal_body.find('.modal-html').addClass('hide').html('');
                        $modal_body.find('.modal-loader').removeClass('hide');
                        metLoadTemp(url,data,$modal_body.find('.modal-html'),function(html){
                            $modal_body.find('.modal-html')[0].innerHTML=html;
                            if(loading!=='1'){
                                $modal_body.find('.modal-loader').addClass('hide');
                                $modal_body.find('.modal-html').removeClass('hide');
                                $modal_body.scrollTop(0);
                            }
                        },function(){
                            key && admin_module.obj.parents(key).length && typeof TEMPLOADFUNS[admin_module.hash]=='function'&&TEMPLOADFUNS[admin_module.hash]();
                            if(tablerefresh_type) datatable[tablerefresh].row().draw(false);
                            callback(data);
                        });
                    }else{
                        body && $modal_body.html(body);
                        if(refresh!='0') $modal_body.metCommon();
                        key && key!='.pageset-nav-modal' && typeof admin_module!='undefined' && admin_module.obj.parents(key).length && typeof TEMPLOADFUNS[admin_module.hash]=='function'&&TEMPLOADFUNS[admin_module.hash]();
                        $modal_body.scrollTop(0);
                        callback(data);
                    }
                    if(refresh=='one') $modal_body.attr({'data-refresh':0});
                    title && $('.modal[data-key="'+key+'"] .modal-title').html(title);
                };
            if(key!='.pageset-nav-modal'&&$('.pageset-nav-modal').is(':visible')){
                $('.modal-dialog',key).addClass('pt');
            }else{
                $('.modal-dialog',key).removeClass('pt');	
            }
            M.component.modal_options[key] && typeof M.component.modal_options[key].before=='function'&&M.component.modal_options[key].before(key);
            if(url && $modal_body.attr('data-dataurl')){
                var dataurl=$modal_body.attr('data-dataurl');
                if(dataurl.indexOf('M.list')>=0){
                    var result=eval(dataurl);
                    loadTemp(result);
                }else{
                    $.ajax({
                        url: dataurl,
                        type: 'GET',
                        dataType: 'json',
                        success:function(result){
                            if(parseInt(result.status)){
                                loadTemp(result.data);
                            }else{
                                $modal_body.find('.modal-loader').addClass('hide');
                                $modal_body.find('.modal-html').html(`<div class="text-center h5 mb-0 py-5">${result.msg}</div>`).removeClass('hide');
                            }
                        }
                    });
                }
            }else loadTemp();
        },0);
    });
    // 弹框保存触发
    $(document).on('click', '.met-modal .modal-footer [data-ok]', function(event) {
        var modal_commit=$(this).parents('.modal').find('form').data('modal-commit');
        if(!$(this).parents('form').length && $(this).parents('.modal').find('form').length&&modal_commit!==0) $(this).parents('.modal').find('form:eq(0)').submit();
    });
})();