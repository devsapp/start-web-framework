/*!
 * 可视化设置
 * 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved.
 */
(function(){
    M.url.own_form=M.url.admin+'?n=ui_set&c=index&';
    // 手机端弹出引导提示
    M.device_type=='m' && $('.pageset-mobile-tips-wrapper').length && metui.use('alertify',function(){
        alertify.error($('.pageset-mobile-tips-wrapper').html());
        setTimeout(function(){
            $('.pageset-mobile-tips').next('.close').click(function(event) {
                setCookie('pageset_mobile_tips_hide',1);
            });
        },100);
    });
    // 引导图
    var $uiset_guide_modal=$('.uiset-guide-modal'),
        $uiset_guide_process=$('.uiset-guide-process'),
        uiset_guide_visible=$uiset_guide_modal.data('visible'),
        uiset_guide_resize=function(){
            var scale=$(window).width()/1920;
            if(scale<1){
                $uiset_guide_modal.find('.modal-content').css({transform:'scale('+scale+')',left:-(1920*(1-scale)/2),top:-(1080*(1-scale)/2)});
            }else{
                $uiset_guide_modal.find('.modal-content').css({transform:'',left:0,top:''});
            }
        };
    $uiset_guide_modal.on('show.bs.modal', function(event) {
        $uiset_guide_process.find('.item').addClass('hide').eq(0).removeClass('hide');
        $('.uiset-guide-content img[data-src]').each(function(){
            $(this).attr('src',$(this).data('src')).removeAttr('data-src');
        });
    });
    uiset_guide_visible && $uiset_guide_modal.modal();
    $uiset_guide_modal.find('[data-dismiss="modal"]').click(function(){
        if(!uiset_guide_visible) return;
        M.load('alertify',function(){
            alertify.alert('点击可视化界面顶部导航栏->支持->操作引导，可重新查看刚才的操作引导');
        });
        metui.ajax({
            url: $uiset_guide_modal.data('url')
        },function(result){
            metAjaxFun({result:result});
        });
    });
    $uiset_guide_process.find('.btn-next').click(function(){
        $(this).parents('.item').addClass('hide').next().removeClass('hide');
    });
    $uiset_guide_process.find('.btn-prev').click(function(){
        $(this).parents('.item').addClass('hide').prev().removeClass('hide');
    });
    var uiset_guide_demo='',
        load_uiset_guide_demo=function(key) {
            $('.uiset-guide-demo-modal .modal-body').html('<div class="d-flex w-100 h-100 justify-content-center align-items-center"><img src="'+uiset_guide_demo[key]+'" class="img-fluid"></img>');
        };
    $uiset_guide_process.find('.btn-look-demo').click(function(){
        var key=$(this).parents('.item').index()-1;
        if(uiset_guide_demo){
            load_uiset_guide_demo(key);
        }else{
            M.ajax({
                url:'n=index&c=index&a=doGetImgList',
                success:function(result) {
                    uiset_guide_demo=result.data;
                    load_uiset_guide_demo(key);
                }
            });
        }
    });
    uiset_guide_resize();
    $(window).resize(function(){
        uiset_guide_resize();
    });
    // 不再提示更改后台目录名称
    $('.no-prompt,.btn-uiset-guide-cancel').click(function(){
        if(!checkLogin()) return;
        metui.ajax({
            url: $(this).data('url')
        },function(result){
            metAjaxFun({result:result});
        });
    });
    // 手机端顶部导航栏下拉展开
    $('.btn-pageset-mobile-menu').click(function(event) {
        $('.pageset-mobile-menu').slideToggle(300);
    });
    // 关闭用户协议框
    $('.met-agreement-modal .modal-footer button').click(function(event) {
        metui.ajax({
            url: M.url.own_form+'a=doagreement&license=1'
        });
    });
    // 页面弹框、iframe
    var $pageset_head_nav=$('.pageset-head-nav'),
        $page_iframe=$('.page-iframe'),
        $btn_common_modal=$('.btn-pageset-common-modal'),
        pageset_modal={
            nav:'.pageset-nav-modal',
            img:'.pageset-img-modal',
            editor:'.pageset-editor-modal',
            block_config:'.pageset-block-config-modal',
            other_config:'.pageset-other-config-modal',
        },
        pageset_url={
            get_text_content:M.url.own_form+'a=doget_text_content&lang='+M.lang,
            set_text_content:M.url.own_form+'a=doset_text_content&lang='+M.lang,
        };
    $(function(){
        // 页面刷新时保存cookie-iframe当前url
        window.onbeforeunload = function(){
            var dynamic=$page_iframe.attr('data-dynamic');
            if(typeof dynamic != 'undefined') setCookie('page_iframe_url',dynamic);
        }
        // 页面弹框设置参数
        metui.use('modal',function(){
            M.component.modal_options[pageset_modal.nav]={
                modalSize:'100',
                modalOktext:'',
                modalNotext:METLANG.close,
                modalFullheight:1,
                modalRefresh:0,
                modalBodyclass:'pl-4',
                modalSubmitNoclose:1
            };
            M.component.modal_options[pageset_modal.img]={
                modalType:'centered',
                modalTitle:METLANG.replaceImg,
                modalBody:'<form action="'+M.url.own_form+'a=dosave_img" data-submit-ajax="1"><input type="hidden" name="met_skin_user"/><input type="hidden" name="table"/><input type="hidden" name="id"/><input type="hidden" name="field"/><input type="hidden" name="old_img"/><div class="form-group mb-0"><input type="file" name="new_img" data-plugin="fileinput" accept="image/*"></div></form>',
                modalRefresh:'one'
            };
            M.component.modal_options[pageset_modal.editor]={
                modalSize:'lg',
                modalTitle:METLANG.contentdetail,
                modalBody:'<form action="'+pageset_url.set_text_content+'" data-submit-ajax="1"><input type="hidden" name="table"/><input type="hidden" name="id"/><input type="hidden" name="field"/><textarea name="text" hidden></textarea></form>',
                modalFullheight:1,
                modalRefresh:'one'
            };
            M.component.modal_options[pageset_modal.block_config]={
                modalSize:'lg',
                modalFullheight:1
            };
            M.component.modal_options[pageset_modal.other_config]={
                modalSize:'lg'
            };
            M.component.modal_options['.uiset-guide-demo-modal']={
                modalSize:'xl',
                modalType:'centered',
                modalFooterok:0,
                modalRefresh:0,
                modalBodyclass:'px-3'
            };
        });
        // 头部导航栏弹窗、导航弹窗中的tab导航切换
        $(document).on('click clicks', '.pageset-head-nav [data-target="'+pageset_modal.nav+'"][data-url],'+pageset_modal.nav+' .modal-body:eq(0) .nav-modal-item .met-headtab:not([data-ajaxchange]) a[href^="#"],.btn-adminfolder-change,.btn-pageset-common-page', function(event) {
            if(!checkLogin()) return;
            if(!$(this).attr('data-url')) event.preventDefault();
            var url=$(this).attr('data-url')?$(this).attr('data-url'):$(this).attr('href').substr(2),
                hash=url.indexOf('/?')>0?url.split('/?')[0]:url,
                data={
                    module:$(this).attr('data-module'),
                    class1:$(this).attr('data-class1'),
                    class2:$(this).attr('data-class2'),
                    class3:$(this).attr('data-class3'),
                    head_tab_active:$(this).attr('data-head_tab_active')
                },
                other_data=getQueryString(['module','class1','class2','class3','head_tab_active'],url),
                title=$(this).attr('title')||$(this).text(),
                $self=$(this),
                $pageset_nav_modal='',
                loadFun=function(){
                    var $modal_title=$pageset_nav_modal.find('.modal-title');
                    if($modal_title.attr('data-title')){
                        title=$modal_title.attr('data-title');
                        $modal_title.attr('data-title','');
                    }
                    $modal_title.html(title);
                    
                    if(data.module||data.class1||data.class2||data.class3||data.head_tab_active){
                        if(hash!='manage') admin_module.obj.find('.met-headtab[data-ajaxchange] a:eq('+(data.head_tab_active)+')').click();
                        setTimeout(function(){
                            $self.removeAttr('data-module data-class1 data-class2 data-class3 data-head_tab_active');
                        },1000);
                    }else{
                        if(hash!='manage') admin_module.obj.find('.met-headtab[data-ajaxchange] a:eq(0)').click();
                    }
                };
            hash=hashHandle(hash);
            hash=url.split('/')[0]=='app'?'app/'+hash:hash;
            $.each(other_data,function(index,val){
                if(val) data[index]=val;
            });
            setTimeout(function(){
                $pageset_nav_modal=$(pageset_modal.nav);
                var $loader=$pageset_nav_modal.find('.modal-loader'),
                    $modal_body=$pageset_nav_modal.find('.modal-body').eq(0);
                if(hash=='ui_set/package' || (hash=='myapp/login' && getCookie('app_href_source').indexOf('ui_set/package')>=0)){
                    $pageset_nav_modal.find('.modal-dialog').removeClass('modal-100 my-0 mx-auto h-100 py-2').addClass('modal-dialog-centered').find('.modal-footer').addClass('hide');
                    $pageset_nav_modal.find('.modal-body').removeClass('pl-4');
                }else{
                    $pageset_nav_modal.find('.modal-dialog').addClass('modal-100 my-0 mx-auto h-100 py-2').removeClass('modal-dialog-centered').find('.modal-footer').removeClass('hide');
                    $pageset_nav_modal.find('.modal-body').addClass('pl-4');
                }
                hash=='ui_set/package' && $modal_body.find('.nav-modal-item[data-path="'+hash+'"]').remove();
                $loader.removeClass('hide');
                $modal_body.find('.nav-modal-item').hide();
                var $nav_modal_item=$modal_body.find('.nav-modal-item[data-path="'+hash+'"]'),
                    beforeLoadFun=function(){
                        if($nav_modal_item.find('.metadmin-content-min').length){
                            $modal_body.removeClass('bg-white');
                        }else{
                            $modal_body.addClass('bg-white');
                        }
                    };
                if($nav_modal_item.length && $nav_modal_item.attr('data-loaded')){
                    beforeLoadFun();
                    setTimeout(function(){
                        $loader.addClass('hide');
                        $nav_modal_item.show();
                        loadedTempReload(hash,'',function(){
                            loadFun();
                        });
                    },300);
                }else{
                    metLoadTemp(url,'',$nav_modal_item,function(html){
                        $loader.addClass('hide');
                        $modal_body.append('<div class="nav-modal-item" data-path="'+hash+'" data-loaded="1"></div>');
                        $nav_modal_item=$modal_body.find('.nav-modal-item[data-path="'+hash+'"]');
                        $nav_modal_item[0].innerHTML=html;
                        beforeLoadFun();
                    },function(){
                        loadFun();
                        typeof TEMPLOADFUNS[hash]=='function'&&TEMPLOADFUNS[hash]();
                    });
                }
            },0);
        });
        // 导航弹框标题
        $(document).on('click', pageset_modal.nav+' .modal-body:eq(0) .nav-modal-item .met-headtab[data-ajaxchange] a[href*="#"]', function(event) {
            var $pageset_nav_modal=$(pageset_modal.nav),
                $modal_title=$pageset_nav_modal.find('.modal-title'),
                title=$modal_title.html();
            if($modal_title.attr('data-title')){
                title=$modal_title.attr('data-title');
                $modal_title.attr('data-title','');
            }
            title=(title.indexOf('-')>0?title.split('-')[0]:title)+(title?'-':'')+$(this).html();
            $modal_title.html(title);
        });
        // 导航弹框内锚点链接兼容
        $(document).on('click', pageset_modal.nav+' .modal-body:eq(0) a[href^="#/"]', function(event) {
            if(!$(this).parents('.met-headtab').length){
                var title=$(this).attr('title')||$(this).text();
                event.preventDefault(),$('.btn-pageset-common-page').attr({'data-url':$(this).attr('href').substr(2),'data-head_tab_active':getQueryString('head_tab_active',$(this).attr('href')),title:title}).trigger('clicks');
                setTimeout(function(){
                    $('.btn-pageset-common-page').attr({title:''});
                },500);
            }
        });
        // 可视化编辑弹窗增加保存后的回调
        $btn_common_modal.click(function(){
            var $self=$(this),
                moal_class=$(this).attr('data-target');
            setTimeout(function(){
                metui.use('form',function(){
                    var $modal_body=$(moal_class).find('.modal-body:eq(0)');
                    // 弹框内锚点链接兼容
                    $modal_body.find('a[href^="#/"]').attr({target:'_blank'}).each(function(index, el) {
                        $(this).attr({href:M.url.admin+$(this).attr('href')});
                    });
                });
                $self.removeAttr('data-modal-url data-modal-title data-modal-load').removeData(['modalTitle','modalSize','modalUrl','modalFullheight','modalOktext','modalNotext']);
            },1000);
        });
        // 导航菜单设置保存后回调
        setTimeout(function(){
            metui.use('form',function(){
                formSaveCallback('#pageset-nav-set', {
                    true_fun: function() {
                        setTimeout(function(){
                            location.reload();
                        },500);
                    }
                });
            });
        },2000);
        // 页面弹窗关闭后操作
        $(document).on('hidden.bs.modal','.modal',function(){
            !$('.modal:visible').length && $page_iframe.attr('data-reload') && pageiframeReload();
            $(this).hasClass('pageset-nav-modal') && $('.modal-body .content-show .content-show-item[data-path^="about"]',this).remove();
            if(($(this).hasClass('pageset-editor-modal')||$(this).hasClass('pageset-block-config-modal')) && $('.modal-body .edui-default[id^="ueditor-"]',this).length){
                $('.modal-body .edui-default[id^="ueditor-"]',this).each(function(index, el) {
                    var editor_id=$(this).attr('id');
                    EDITOR_VAL[editor_id].setContent('');
                });
            }
        });
        // 可视化窗口刷新
        function pageiframeReload(){
            $page_iframe.prop('contentWindow').location.reload();
            $page_iframe.removeAttr('data-reload');
        }
        // 页面头部弹窗-弹窗标题点击回到初始页面
        // $(document).on('click', '.nav-modal .modal-title a', function(event) {
        //     event.preventDefault();
        //     $nav_modal.find('.nav-iframe:visible').prop('contentWindow').location.href=$(this).attr('href');
        // });
        // 系统消息数量
        metui.ajax({
            url: M.url.admin + '?n=system&c=news&a=docurlnews'
        },function(result) {
            metAjaxFun({result:result,true_fun:function(){
                var num=parseInt(result.data.num);
                num && $('.sys-news-count').html(num);
            }});
        });

        // 可视化iframe部分
        $page_iframe.load(function() {
            var $page_iframe_contents=$(this).contents(),
                page_iframe_window=$(this).prop('contentWindow'),
                page_iframe_document=page_iframe_window.document;
            if(!page_iframe_window.M) return;
            // 添加文字编辑按钮和区块设置组件
            var pageset_html='<link rel="stylesheet" type="text/css" href="'+page_iframe_window.M.weburl+'app/system/ui_set/admin/templates/css/page_iframe.css">'
                +'<div class="pageeditor-btn">'
                    +'<span class="pageeditor-remark" hidden data-url="" data-rows="3"></span>'
                    +'<button class="btn btn-floating btn-success btn-xs p-0 pageeditor-editor"><i class="icon wb-pencil" aria-hidden="true"></i></button>'
                +'</div>';
            $page_iframe_contents.find("html").append(pageset_html);
            $page_iframe_contents.pageinfo(page_iframe_window,page_iframe_document);// 页面输出值的标签处理
            if($('meta[name="generator"]',page_iframe_document).length && $('meta[name="generator"]',page_iframe_document).attr('content').indexOf('MetInfo')>=0){
                var new_url=page_iframe_window.location.href;
                // 更新iframe的动态url信息
                $page_iframe.attr({'data-dynamic':new_url});
                // 更新预览按钮链接
                new_url=new_url.replace('&pageset=1','').replace('?pageset=1','');
                $('.pageset-view').attr({href:new_url});
            }
            // 右键菜单
            $('[met-imgmask]',page_iframe_document).contextMenu();
            // 页面中跳转地址兼容
            $(page_iframe_document).on('click','a[href][href!=""]',function(e){
                var url=$(this).attr('href').replace(/\s*/g,""),
                    $self=$(this),
                    href_control=(function(){
                        if(
                            ($self.attr('data-toggle')=='dropdown' && (typeof $self.attr('data-hover')=='undefined' || M.device_type!='d'))
                            || url.substr(0,1)=='#'
                            || url.indexOf('javascript')>=0
                            || url.indexOf('tel:')>=0
                            || url.indexOf('.jpg')>0
                            || url.indexOf('.png')>0
                            || url.indexOf('.gif')>0
                            || url.indexOf('mailto:')>=0
                            || url.substr(0,5)=='skype'
                            || (url.substr(0,4)=='http' && url.indexOf(M.weburl)<0 && url.indexOf('pageset=1')<0 && url.indexOf('lang=')<0)
                        ) return false;
                        return true;
                    })(),
                    href_blank=$(this).attr('target')=='_blank' && href_control,
                    href_nopageset=(function(){
                        var nopageset=(url.indexOf(M.weburl)>=0||url.indexOf('lang=')>0) && url.indexOf('pageset=1')<0;
                        if(nopageset){
                            var url_after='pageset=1';
                            if(url.indexOf('?')>=0){
                                url_after='&'+url_after;
                            }else{
                                url_after='?'+url_after;
                            }
                            url+=url_after;
                        }
                        return nopageset;
                    })();
                if(href_control || href_blank || href_nopageset){
                    e.preventDefault();
                    var new_url=url.indexOf(M.weburl)>=0?url:M.weburl+(url.substr(0,3)=='../'?url.replace('../',''):url);
                    page_iframe_window.location.href=new_url;
                }
            });

            // 样式、所选内容设置
            // 鼠标经过区块显示区块边界
            $(page_iframe_document).on('mouseover','*',function(e){
                var $block=$(e.target).closest("[m-id]"),
                    index=$page_iframe_contents.find('[m-id]').index($block),
                    mid=$block.attr('m-id'),
                    type=$block.attr('m-type'),
                    $pageset_btn=$page_iframe_contents.find('html>.pageset-btns .pageset-btn');
                $page_iframe_contents.find('[m-id]').removeClass('set-active');
                $block.addClass('set-active');
                if($block.attr('m-id') && pageset_btn_hide){
                    $pageset_btn.attr({'data-mid':mid,'data-index':index,'data-type':type||''}).find('.btn').attr({'data-mid':mid,'data-index':index,'data-type':type||''});
                    if(mid=='noset'){
                        $pageset_btn.find('.pageset-block-config').addClass('hide');
                    }else{
                        $pageset_btn.find('.pageset-block-config').removeClass('hide');
                    }
                    if(type=='nocontent'){
                        $pageset_btn.find('.pageset-content').addClass('hide');
                    }else{
                        $pageset_btn.find('.pageset-content').removeClass('hide');
                    }
                    blocksetBtnPosition($block,$pageset_btn,index,page_iframe_window,$page_iframe_contents);
                }
            });
            // 弹出区块设置框
            $page_iframe_contents.pagesetModal('.pageset-btn .pageset-block-config');
            // 弹出区块内容框
            $page_iframe_contents.on('click','.pageset-btn .pageset-content',function(event) {
                if(!checkLogin()) return;
                var mid=$(this).attr('data-mid'),
                    type=$(this).attr('data-type')||null,
                    index=$(this).attr('data-index'),
                    $mid=$page_iframe_contents.find('[m-id='+mid+'][m-type='+type+']:eq('+index+')'),
                    id=$mid.find('[name="id"]').length?$mid.find('[name="id"]').val():(page_iframe_window.M.id?page_iframe_window.M.id:''),
                    classnow=$mid.find('[name="class"]').length?$mid.find('[name="class"]').val():($mid.find('[name="id"]').length?$mid.find('[name="id"]').val():page_iframe_window.M.classnow);
                metui.ajax({
                    url: M.url.own_form+'a=doset_content',
                    data: {
                        mid:mid,
                        type:type,
                        id:id,
                        classnow:classnow,
                        module:page_iframe_window.M.module
                    }
                },function(result){
                    metAjaxFun({result:result,true_fun:function(){
                        var url=result.data.url?result.data.url:result.data;
                        if(result.data.url || result.data.indexOf('&id=')<0){
                            $pageset_head_nav.find('[data-url="'+url+'"]').attr({
                                'data-module':result.data.module,
                                'data-class1':result.data.class1,
                                'data-class2':result.data.class2,
                                'data-class3':result.data.class3,
                                'data-head_tab_active':result.data.head_tab_active
                            }).click();
                        }else{
                            if(result.data.indexOf('http')>=0||result.data.substr(0,3)=='../'){
                                $btn_common_modal.attr({'data-target':'.pageset-iframe-modal','data-modal-url':''}).data({
                                    modalTitle: METLANG.editor,
                                    modalSize: 'xl',
                                    modalUrl: '',
                                    modalFullheight: 1,
                                    modalOktext:0,
                                    modalNotext:METLANG.close
                                }).click();
                                setTimeout(function(){
                                    $('.pageset-iframe-modal .modal-body').html(`<iframe src="${result.data}" width="100%" height="100%" frameborder="0" class="float-left"></iframe>`);
                                },0)
                            }else{
                                var module=result.data.split('/')[0],
                                    target='.' + result.data.split('/')[0] + '-details-modal',
                                    is_listmodule=$.inArray(module, ['news','product','img','download','job'])>=0?1:0,
                                    handle=function(){
                                        $btn_common_modal.attr({'data-target':target,'data-modal-url':url}).data({
                                            modalTitle: METLANG.editor,
                                            modalSize: 'xl',
                                            modalUrl: url,
                                            modalFullheight: 1
                                        }).click();
                                    };
                                /*is_listmodule?*/metui.use('#pub/js/content_list',function(){
                                    handle();
                                })/*:handle();*/
                            }
                        }
                    }});
                });
            });

            // 文字、图片编辑
            var $pageeditor_btn=$page_iframe_contents.find('.pageeditor-btn'),
                $pageeditor_editor=$pageeditor_btn.find('.pageeditor-editor'),
                $pageeditor_remark=$pageeditor_btn.find('.pageeditor-remark');
            // 鼠标经过可编辑文字、图片显示编辑按钮
            $(page_iframe_document).on('mouseover','.editable-click,img[met-id],.met-icon',function(e){
                if($pageeditor_btn.find('.editable-container').length) return false;
                var obj=target='';
                if($(e.target).prop('tagName')=='IMG'){
                    obj=target='img';
                }else if($(e.target).hasClass('met-icon')){
                    obj='.met-icon';
                    target='icon';
                }else{
                    obj='.editable-click';
                }
                var $self=$(e.target).closest(obj);
                if($self.parents('[m-type]').attr('m-type')=='displayimgs') return false;
                if(obj=='img' && typeof $self.attr('met-id')=='undefined') return false;
                if($self.parents('.met-editor').length){
                    $self=$self.parents('[met-id]:eq(0)');
                    obj='.met-editor';
                    target='editor';
                }
                if($self.hasClass('met-editor')){
                    obj='.met-editor';
                    target='editor';
                }
                if($(e.target).parents('[met-id]:eq(0)').attr('met-table')=='column' && $(e.target).parents('[met-id]:eq(0)').attr('met-field')=='content'){
                    $self=$(e.target).parents('[met-id][met-table="column"][met-field="content"]:eq(0)');
                    obj='[met-id][met-table="column"][met-field="content"]';
                    target='editor';
                }
                if($(e.target).attr('met-table')=='column' && $(e.target).attr('met-field')=='content'){
                    $self=$(e.target);
                    obj='[met-id][met-table="column"][met-field="content"]';
                    target='editor';
                }
                var left=$self.offset().left,
                    top=$self.offset().top,
                    position_fixed=$self.css('position')=='fixed'?true:false;
                $self.parents().each(function(index, el) {
                    if($(el).css('position')=='fixed'){
                        position_fixed=true;
                        return false;
                    }
                });
                if(position_fixed){
                    top-=$page_iframe_contents.scrollTop();
                    var position='fixed';
                }else{
                    var position='';
                }
                if(obj=='img') top+=$self.outerHeight()/2-10;
                $pageeditor_btn.css({left:left+$self.outerWidth()/2,top:top,position:position});
                typeof $.fn.editable=='function' && $pageeditor_remark.editable('hide');
                $pageeditor_editor.show().attr({'data-obj':obj,'data-index':$page_iframe_contents.find(obj).index($self)});
                $btn_common_modal.attr({'data-target':(target?(target=='icon'?'.met-icon-modal':'.pageset-'+target+'-modal'):'')});
                $('.editable-click,img,.met-icon',page_iframe_document).removeClass('set');
                $self.addClass('set');
            })
            // 鼠标移出设置元素，隐藏设置元素外边框
            $(page_iframe_document).on('mouseout','.editable-click,img[met-id],.met-icon',function(e){
                if($pageeditor_btn.find('.editable-container').length) return false;
                var obj='';
                if($(e.target).prop('tagName')=='IMG'){
                    obj='img';
                }else if($(e.target).hasClass('met-icon')){
                    obj='.met-icon';
                }else{
                    obj='.editable-click';
                }
                var $self=$(e.target).closest(obj);
                if(!$(e.target).parents('.met-editor').length) $self.removeClass('set');
            })
            // 鼠标移到编辑按钮，显示对应的设置元素的外边框
            $pageeditor_editor.hover(function(event) {
                $($(this).attr('data-obj'),page_iframe_document).eq($(this).attr('data-index')).addClass('set');
            },function(){
                $($(this).attr('data-obj'),page_iframe_document).eq($(this).attr('data-index')).removeClass('set');
            });
            // 编辑按钮点击显示输入框
            $pageeditor_editor.click(function(event) {
                if(!checkLogin()) return;
                // 计算输入框样式尺寸
                var $editable_click=$page_iframe_contents.find($(this).attr('data-obj')).eq($(this).attr('data-index'));
                if($(this).attr('data-obj')=='img'){
                    // 弹出图片上传框
                    $btn_common_modal.click();
                    var $obj_img=$page_iframe_contents.find('img:eq('+$(this).attr('data-index')+')'),
                        img_url=$obj_img.data('original')||$obj_img.data('lazy')||$obj_img.data('src')||$obj_img.attr('src');
                    if(img_url.indexOf('met-id=')>=0) img_url=(img_url.split('met-id=')[0]).slice(0,-1);
                    img_url.substr(0,4)!='http' && img_url.substr(0,3)!='../' && (img_url='../'+img_url);
                    setTimeout(function(){
                        metui.use('fileinput',function(){
                            var $pageset_img_modal=$(pageset_modal.img);
                            $pageset_img_modal.find('[name="met_skin_user"]').val(page_iframe_window.MSTR[3]);
                            $pageset_img_modal.find('[name="table"]').val($obj_img.attr('met-table'));
                            $pageset_img_modal.find('[name="id"]').val($obj_img.attr('met-id'));
                            $pageset_img_modal.find('[name="field"]').val($obj_img.attr('met-field'));
                            $pageset_img_modal.find('[name="old_img"]').val(img_url);
                            $pageset_img_modal.find('[type="file"][name="new_img"]').metFileInputChange(img_url);
                        });
                    },0);
                }else if($(this).attr('data-obj')=='.met-icon'){
                    var index=$(this).attr('data-index');
                    // 弹出图标选择框
                    metui.use('iconset',function(){
                        $btn_common_modal.click();
                        setTimeout(function(){
                            $('.met-icon-modal .modal-footer button[data-ok]').attr({'data-obj':'pageset-iconset-'+index});
                        },100);
                    });
                }else{
                    var table=$editable_click.attr('met-table'),
                        field=$editable_click.attr('met-field'),
                        id=$editable_click.attr('met-id');
                    // 获取输入框的显示内容
                    metui.ajax({
                        url: pageset_url.get_text_content,
                        data: {
                            table: table,
                            field: field,
                            id: id
                        }
                    },function(result){
                        metAjaxFun({result:result,true_fun:function(){
                            if($editable_click.hasClass('met-editor') || ($editable_click.attr('met-table')=='column' && $editable_click.attr('met-field')=='content')){
                                // 显示编辑器
                                $btn_common_modal.click();
                                setTimeout(function(){
                                    var $pageset_editor_modal=$(pageset_modal.editor),
                                        $textarea=$pageset_editor_modal.find('textarea[name="text"]'),
                                        is_editor_init=$textarea.attr('data-plugin');
                                    if(M.met_editor=='ueditor') $textarea.val(result.text);
                                    !is_editor_init && $textarea.attr({'data-plugin':'editor','data-editor-y':$pageset_editor_modal.find('.modal-body').height()-(M.met_editor=='ueditor'?138:79)}).metEditor();
                                    metui.use(M.met_editor_plugin,function(){
                                        setTimeout(function(){
                                            $pageset_editor_modal.find('[name="table"]').val(table);
                                            $pageset_editor_modal.find('[name="field"]').val(field);
                                            $pageset_editor_modal.find('[name="id"]').val(id);
                                            var editor_id=M.met_editor=='ueditor'?$textarea.prev('.edui-default').attr('id'):$textarea.parent().attr('id');
                                            (M.met_editor=='ueditor'?is_editor_init:1) && EDITOR_VAL[editor_id].setContent(result.text);
                                        },0);
                                    });
                                },0);
                            }else{
                                // 显示输入框
                                var width=$editable_click.width(),
                                    height=$editable_click.height(),
                                    lh=parseInt($editable_click.css('line-height')),
                                    type=(result.type==3 || height>2*lh)?'textarea':'text',
                                    text_l=$editable_click.text().length,
                                    text_fz=$editable_click.css('font-size'),
                                    text_ls=$editable_click.css('letter-spacing');
                                // 判断文字长度是否大于文字框宽度，大于则显示多行编辑框
                                if(width>500) type='textarea';
                                width=width>500?500:width;
                                text_fz=text_fz.indexOf('px')>=0?parseInt(text_fz):14;
                                text_ls=text_ls.indexOf('px')>=0?parseInt(text_ls):0;
                                var text_w=(text_fz*0.6+text_ls)*text_l;
                                if(text_w>width) type='textarea';
                                // 弹出显示框
                                metui.use('editable',function(){
                                    $pageeditor_editor.hide();
                                    $pageeditor_remark.editable('destroy').html(result.text).editable({
                                        type: type,
                                        pk: 1,
                                        name: 'tagcontent',
                                        mode:'inline'
                                    });
                                    $pageeditor_remark.editable('show');
                                    $pageeditor_btn.find('.editable-container .editable-input .form-control').width(width).val(result.text);
                                    // 调整显示框位置
                                    var position=$pageeditor_btn.css('position'),
                                        top=$pageeditor_btn.offset().top,
                                        left=$pageeditor_btn.offset().left,
                                        pageeditor_btn_h=$pageeditor_btn.outerHeight(),
                                        pageeditor_btn_w=$pageeditor_btn.outerWidth(),
                                        wscroll=$(page_iframe_window).scrollTop(),
                                        window_h=$(page_iframe_window).height(),
                                        window_w=$(page_iframe_window).width(),
                                        pageeditor_btn_distance=[],
                                        pageeditor_btn_position=[];
                                        pageeditor_btn_distance['left']=left-pageeditor_btn_w/2;
                                        pageeditor_btn_distance['right']=window_w-(left+pageeditor_btn_w/2);
                                        pageeditor_btn_distance['bottom']=window_h-(top+pageeditor_btn_h-wscroll);
                                    if(pageeditor_btn_distance['left']<0){
                                        $pageeditor_btn.css({left:pageeditor_btn_w/2});
                                    }
                                    if(pageeditor_btn_distance['right']<0){
                                        pageeditor_btn_position['left']=window_w-pageeditor_btn_w/2;
                                        $pageeditor_btn.css({left:pageeditor_btn_position['left']});
                                    }
                                    if(pageeditor_btn_distance['bottom']<0){
                                        pageeditor_btn_position['top']=position=='fixed'?(window_h-pageeditor_btn_h):(wscroll+window_h-pageeditor_btn_h);
                                        $pageeditor_btn.css({top:pageeditor_btn_position['top']});
                                    }
                                });
                            }
                        }});
                    });
                }
            });
            // 非可编辑文字区域，隐藏输入框和文字编辑按钮
            $page_iframe_contents.find("body").mouseover(function(e) {
                if(!($(e.target).closest(".editable-click").length || $pageeditor_btn.find('.editable-container').length || $(e.target).closest(".pageeditor-btn").length)){
                    // $pageeditor_remark.editable('hide');
                    $pageeditor_editor.hide();
                }
            });
            // 输入框保存
            $(page_iframe_document).on('click','.editable-submit',function(){
                if(!checkLogin()) return;
                var text=$pageeditor_btn.find('.editable-container .editable-input .form-control').val(),
                    $editable_click=$page_iframe_contents.find($pageeditor_editor.attr('data-obj')).eq($pageeditor_editor.attr('data-index'));
                metui.ajax({
                    url: pageset_url.set_text_content,
                    data: {table: $editable_click.attr('met-table'),field: $editable_click.attr('met-field'),id: $editable_click.attr('met-id'),text:text}
                },function(result){
                    metAjaxFun({result:result,true_fun:function(){
                        $pageeditor_editor.show();
                        pageiframeReload();
                    }});
                });
            });
            // 输入框点击取消按钮后，显示编辑按钮
            $(page_iframe_document).on('click','.editable-cancel',function(){
                setTimeout(function(){
                    if($pageeditor_editor.is(':hidden')) $pageeditor_editor.show();
                },200)
            });
        });
        // 图标保存
        $(document).on('click', '.met-icon-modal .modal-footer button[data-ok][data-obj*="pageset-iconset-"]', function(event) {
            var $icon_modal=$('.met-icon-modal'),
                $icon_active=$icon_modal.find('.icon-detail .icondemo-wrap.active'),
                icon_active=$icon_active.parents('.icon-detail').data('prev')+$icon_active.data('name');
            if(icon_active){
                var index=$(this).attr('data-obj').split('-')[2],
                    $icon=$page_iframe.contents().find('.met-icon:eq('+index+')');
                metui.ajax({
                    url: pageset_url.set_text_content,
                    data: {table: $icon.attr('met-table'),field: $icon.attr('met-field'),id: $icon.attr('met-id'),text:icon_active}
                },function(result){
                    metAjaxFun({result:result,true_fun:function(){
                        pageiframeReload();
                    }});
                });
            }
        });
    });
    // 参数设置框弹出-渲染、保存
    var block_config_type={
            2:'text',
            3:'textarea',
            4:'radio',
            6:'select',
            7:'file',
            8:'editor',
            9:'color',
            14:'socail_link',
            15:'icon',
        };
    function pagesetConfigKey(template_type){
        return template_type=='ui'?{
            type:'uip_type',
            name:'uip_name',
            value:'uip_value',
            default:'uip_default',
            title:'uip_title',
            des:'uip_description',
            select:'uip_select',
        }:{
            type:'type',
            name:'name',
            value:'value',
            default:'defaultvalue',
            title:'valueinfo',
            des:'tips',
            select:'selectd',
        };
    }
    // 参数渲染
    function pagesetConfigHandle(modal_class,result,option){
        var $pageset_config_modal=$(modal_class),
            $modal_body=$pageset_config_modal.find('.modal-body'),
            html=html_hidden='',
            time=new Date().getTime(),
            is_block=modal_class==pageset_modal.block_config?1:0,
            title=is_block?(result.data.desc.valueinfo||(result.data.desc.ui_title+(result.data.desc.ui_description?'<span class="font-size-14">（'+result.data.desc.ui_description+'）</span>':''))):option.title,
            key=pagesetConfigKey(result.data.template_type);
        $.each(result.data[is_block?'data':'config_list'], function(index, val) {
            val[key.type]=parseInt(val[key.type]);
            var type=block_config_type[val[key.type]],
                options={
                    type:type,
                    name:val.id+'_metinfo',
                    value:val[key.value]!=''?val[key.value]:val[key.default],
                    label:val[key.title],
                    dl:1,
                    tips:val[key.des],
                    attr:'data-uip_name="'+val[key.name]+'"'
                };
            if(val[key.type]==4||val[key.type]==6){
                options.data=[];
                val[key.type]==6 && options.data.push({
                    name:METLANG.please_choose,
                    value:''
                });
                val[key.select] && $.each(val[key.select].split('$M$'), function(index1, val1) {
                    if(val1){
                        val1=val1.split('$T$');
                        options.data.push({
                            name:val1[0],
                            value:val1[1]
                        });
                    }
                });
            }
            var this_html=M.component.formWidget(options);
            parseInt(val.uip_hidden)?(html_hidden?html_hidden+=this_html:
                html_hidden='<hr>'+M.component.formWidget({
                    type:'collapse',
                    title:METLANG.moreSettings,
                    dl:1,
                    dt:0,
                    target:'.collapse-'+time
                })+'<div class="collapse collapse-'+time+'">'+this_html
            ):html+=this_html;
        });
        html_hidden && (html_hidden+='</div>');
        html_hidden && (html+=html_hidden);
        if(!is_block){
            $.each(result.data.other_config_list, function(index, val) {
                html+=M.component.formWidget({
                    type:val.type,
                    name:val.name,
                    value:val.value,
                    label:val.label,
                    data:val.data,
                    dl:1,
                });
            });
        }
        var htmlHandle=function(){
                html='<form action="'+M.url.own_form+'a='+(is_block?'doeditor':option.form_action)+'" data-submit-ajax="1">'
                    +M.component.formWidget('met_skin_user',$page_iframe.prop('contentWindow').MSTR[3])
                    +(is_block?M.component.formWidget('mid',option.mid):'')
                +'<div class="metadmin-fmbx">'+html+'</div></form>';
                $modal_body[0].innerHTML=html;
                $modal_body.scrollTop(0).removeAttr('data-load');
                $modal_body.find('input[data-uip_name="met_font"]').attr({placeholder:METLANG.default_values,'data-toggle':'dropdown'}).each(function(index, el) {
                    var list_html=(function(){
                            var list=['宋体','Microsoft YaHei"','Tahoma','Verdana','Simsun','Segoe UI','Lucida Grande','Helvetica','Arial','FreeSans','Arimo','Droid Sans','wenquanyi micro hei','Hiragino Sans GB','Hiragino Sans GB W3','sans-serif'],
                                html='';
                            $.each(list,function(index, el){
                                html+='<a class="dropdown-item px-2 py-1" href="javascript:;" data-value="'+el+'">'+el+'</a>';
                            });
                            html='<div class="dropdown-menu">'
                                +'<a class="dropdown-item px-2 py-1" href="javascript:;">'+METLANG.default_values+'</a>'
                                +html
                            +'</div>';
                            return html;
                        })(),
                        inline_block=$(this).css('display')=='inline-block'?' d-inline-block':' d-block',
                        float=$(this).css('float')!='none'?' float-'+$(this).css('float'):'';
                    $(this).wrap('<div class="navbar p-0'+inline_block+float+'"><div class="dropdown clearfix"></div></div>');
                    $(this).val($(this).val()||'').after(list_html);
                });
                $modal_body.metCommon();
                $pageset_config_modal.find('.modal-title').html(title);
            };
        if(result.data.met_ui_list){
            var blockui_view='';
            $.each(result.data.met_ui_list, function(index, val) {
                (val.ui_name==result.data.desc.ui_name || !val.ui_name) && (blockui_view=val.view);
            });
            html=M.component.formWidget({
                name:'ui_name',
                type:'select',
                class_name:'blockui-select',
                value:result.data.desc.ui_name,
                data:result.data.met_ui_list,
                data_value_key:'ui_name',
                select_option:function(index,val){
                    return val.ui_title;
                },
                select_option_attr:function(index,val){
                    return 'data-view="'+val.view+'"';
                },
                label:METLANG.block_style,
                dl:1,
                other:'<button type="button" class="btn btn-primary ml-1 float-left btn-blockui-change">'+METLANG.change+'</button>',
                other1:'<div class="blockui-view mt-2"><a href="'+blockui_view+'" title="'+METLANG.clickview+'" target="_blank"><img src="'+blockui_view+'" style="max-width: 300px;max-height: 100px;"/></a></div>',
                tips:METLANG.change_blockstyle_tips,
            })+html;
        }
        htmlHandle();
    }
    // 网站字体选择
    $(document).on('click', '.pageset-other-config-modal .modal-body input[data-uip_name="met_font"]+.dropdown-menu a', function(event) {
		$(this).parent().prev('input').val($(this).data('value')||'');
	});
    // 区块参数设置
    $.fn.pagesetModal=function(selector){
        $(this).on('click', selector, function(event) {
            if(!checkLogin()) return;
            var mid=$(this).attr('data-mid');
            metui.ajax({
                url: M.url.own_form+'a=doset_area',
                data: {mid:mid,type:$(this).attr('data-type'),classnow:$page_iframe.prop('contentWindow').M.classnow},
            },function(result){
                metAjaxFun({result:result,true_fun:function(){
                    if(result.data.data){
                        $btn_common_modal.attr({'data-target':pageset_modal.block_config,'data-modal-load':1}).click();
                        setTimeout(function(){
                            pagesetConfigHandle(pageset_modal.block_config,result,{mid:mid});
                        },0);
                    }else{
                        var url=result.data.url?result.data.url:result.data,
                        $nav_obj=$pageset_head_nav.find('[data-url="'+url+'"]');
                        if($nav_obj.length){
                            result.data.url && $nav_obj.attr({
                                'data-module':result.data.module,
                                'data-class1':result.data.class1,
                                'data-class2':result.data.class2,
                                'data-class3':result.data.class3,
                                'data-head_tab_active':result.data.head_tab_active
                            });
                            $nav_obj.click();
                        }else{
                            $btn_common_modal.attr({'data-target':'.met-search-modal','data-modal-url':url,'data-modal-title':result.data.title}).data({
                                modalUrl:url,
                                modalTitle:result.data.title,
                                modalOktext:'',
                                modalNotext:METLANG.close
                            }).click();
                        }
                    }
                }});
            });
        });
    };
    // 区块参数-社交链接值修改
    $(document).on('change', pageset_modal.block_config+' .modal-body form [name$="-socail_type"],'+pageset_modal.block_config+' .modal-body form [name$="-socail_val"]', function(event) {
        var $parents=$(this).parents('.input-group');
        $parents.next('input[name][type="hidden"]').val($parents.find('[name$="-socail_type"]').val()+'$M$'+$parents.find('[name$="-socail_val"]').val());
    });
    // 其他参数设置
    $('.pageset-other-config').click(function(event) {
        if(!checkLogin()) return;
        var title=$(this).attr('title')||$(this).text(),
            form_action=$(this).data('form_action'),
            page_iframe_window=$page_iframe.prop('contentWindow'),
            data={
                module:page_iframe_window.M.module,
                id:page_iframe_window.M.id,
                classnow:page_iframe_window.M.classnow
            };
        if(form_action=='doset_page_config' && page_iframe_window.M.classnow==10001){
            $pageset_head_nav.find('a[data-url="webset"]').click();
        }else{
            $btn_common_modal.attr({'data-target':pageset_modal.other_config,'data-modal-load':1}).click();
            if(form_action=='doset_page_config'){
                metLoadTemp('ui_set/page_config/?c=index&a=doGetClassInfo',data,$(pageset_modal.other_config).find('.modal-body'),function(html){
                    var $pageset_config_modal=$(pageset_modal.other_config);
                    $pageset_config_modal.find('.modal-body')[0].innerHTML=html;
                    $pageset_config_modal.find('.modal-body').scrollTop(0).removeAttr('data-load');
                    $pageset_config_modal.find('.modal-title').html(title);
                });
            }else{
                metui.ajax({
                    url: $(this).data('config-url'),
                    data: data,
                },function(result){
                    metAjaxFun({result: result,true_fun: function() {
                        pagesetConfigHandle(pageset_modal.other_config, result, {
                            title: title,
                            form_action: form_action
                        });
                    }});
                });
            }
        }
    });
    // 集成UI风格切换-保存
    $(document).on('change', pageset_modal.block_config+' .blockui-select', function(event) {
        var view=$('option:checked',this).data('view'),
            $blockui_view=$(this).parents('dd').find('.blockui-view');
        $blockui_view.find('a').attr('href',view).find('img').attr('src', view);
    });
    $(document).on('click', '.btn-blockui-change', function(event) {
        if(!checkLogin()) return;
        metui.ajax({
            url: M.url.own_form+'a=dochangeUi',
            data: {
                mid:$(this).parents('form').find('[name="mid"]').val(),
                ui_name:$(this).parents('form').find('[name="ui_name"]').val(),
            },
        },function(result){
            metAjaxFun({result:result,true_fun:function(){
                $page_iframe.attr('data-reload',1);
                $(pageset_modal.block_config).modal('hide');
            }});
        });
    });
    // 区块设置按钮定位
    function blocksetBtnPosition(obj,btns,index,windows,thisiframe){
        var self_info={};
        if(obj.css('position')=='fixed'){
            self_info.left=obj.position().left,
            self_info.top=obj.position().top,
            self_info.position='fixed';
        }else{
            self_info.left=obj.offset().left,
            self_info.top=obj.offset().top,
            self_info.position='';
        }
        self_info.width=obj.outerWidth();
        self_info.left+=self_info.width/2;
        self_info.height=obj.outerHeight();
        self_info.thiswidth=btns.outerWidth();
        var scroll=$(windows).scrollTop();
        // 区块被其它区块遮挡时设置按钮位置变换
        thisiframe.find('[m-id]').each(function(index1, el1) {
            var this_position=$(this).css('position');
            if(index1!=index && this_position=='fixed'){
                var this_h=$(this).outerHeight(),
                    this_top=$(this).position().top,
                    this_tops=scroll+this_top,
                    other_judge=this_top<15?1:0;
                if(this_tops+this_h>self_info.top && this_tops+this_h<self_info.top+self_info.height && other_judge && $(this).outerWidth()>=self_info.width/2){
                    self_info.top=this_top+this_h;
                    self_info.position=this_position;
                    return false;
                }
            }
        });
        // 是否跟其他区块设置按钮重叠
        $.each(mid_btn_position, function(index2, val2) {
            if(self_info.top>val2.top && self_info.top<val2.top+22 && self_info.left>val2.left-self_info.thiswidth && self_info.left<val2.left+val2.width) self_info.top=val2.top+22;
        });
        if((self_info.position=='absolute' && self_info.top+22>=$(documents).height()) || (self_info.position=='fixed' && self_info.top+22>=$(windows).height())) self_info.top-=22;
        mid_btn_position[index]={
            left:self_info.left,
            top:self_info.top,
            width:self_info.thiswidth
        };
        btns.css({position:self_info.position,left:self_info.left,top:self_info.top});
        obj.is(':visible') && btns.removeClass('hide');
    }
    $.fn.extend({
        // 页面内容转换为可视化信息
        pageinfo:function(windows,documents){
            // 插入各区块设置按钮
            window.mid_btn_position={};
            var $this=$(this),
                blockBtnHandle=function(obj){
                    obj.addClass('set').each(function(index, el) {
                        !$(this).parents('[m-id]').length && $(this).css('position')=='static' && $(this).css({position:'relative'});
                        var index=$this.find('[m-id]').index($(this)),
                            mid=$(this).attr('m-id'),
                            type=$(this).attr('m-type'),
                            html='';
                        if(mid!='noset') html+='<button type="button" class="btn btn-xs btn-primary pageset-block-config" data-mid="'+mid+'" data-index="'+index+'">'+METLANG.seting+'</button>';
                        if(type!='nocontent') html+='<button type="button" class="btn btn-xs btn-warning pageset-content" data-mid="'+mid+'" data-type="'+type+'" data-index="'+index+'">'+METLANG.content+'</button>';
                        html && $this.find('html>.pageset-btns').append('<div class="pageset-btn hide" data-mid="'+mid+'" data-index="'+index+'">'+html+'</div>');
                        var $pageset_btn=$this.find('.pageset-btn[data-mid="'+mid+'"][data-index="'+index+'"]');
                        blocksetBtnPosition($(this),$pageset_btn,index,windows,$this);
                    });
                };
            $this.find('html').append('<div class="pageset-btns"></div>');
            window.pageset_btn_hide=0;
            setTimeout(function(){
                blockBtnHandle($this.find('[m-id][m-id!="online"]'));
                $(documents).on('mouseover','*',function(e){
                    if(pageset_btn_hide) return;
                    var html=`<div class="pageset-btn hide" data-mid="" data-index=""><button type="button" class="btn btn-xs btn-primary pageset-block-config" data-mid="" data-index="">${METLANG.seting}</button><button type="button" class="btn btn-xs btn-warning pageset-content" data-mid="" data-type="" data-index="">${METLANG.content}</button></div>`;
                    $this.find('html>.pageset-btns').html(html);
                    pageset_btn_hide=1;
                });
            },500);
            // 文字内容转换可视化信息
            $('m',this).each(function() {
                var el = $(this).parent();
                if(el.prop('tagName')!='BODY' && el.prop('tagName')!='HTML'){
                    if($(this).attr('met-field') == 'content' && !$(this).parents('.met-editor').attr('met-field')) el = $(this).parents('.met-editor');
                    el.attr({'met-id':$(this).attr('met-id'),'met-table':$(this).attr('met-table'),'met-field':$(this).attr('met-field')}).addClass('editable-click');
                    $(this).remove();
                }
            });
            // 图片内容转换可视化信息
            $('img,[data-original]',this).each(function(index, el) {
                var img_url=$(this).data('original')||$(this).data('lazy')||$(this).data('src')||$(this).attr('src');
                if(img_url && img_url.indexOf('met-id=')>=0) $(this).attr({'met-id':img_url.match(/met-id=(\w+)/)[1],'met-table':img_url.match(/met-table=(\w+)/)[1],'met-field':img_url.match(/met-field=(\w+)/)[1]});
            });
            // 图标内容转换可视化信息
            $('[class*="met-icon|"]',this).each(function(index, el) {
                var self_class=$(this).attr('class').split(' ');
                self_class=$.grep(self_class, function(n) {return $.trim(n).length > 0;});
                $.each(self_class, function(index, val) {
                    if(val.indexOf('met-icon')>=0){
                        var icon_info=val.split('|');
                        $(el).addClass('met-icon').removeClass(val).attr({'met-id':icon_info[1],'met-table':icon_info[2],'met-field':icon_info[3]});
                        return false;
                    }
                });
            })
            // 下拉菜单新窗口打开去除新窗口打开属性
            $('a[data-toggle="dropdown"][data-hover="dropdown"][target="_blank"]',this).removeAttr('target');
            // 自定义链接替换
            $('a[href][href!=""]',this).filter(function(index) {
                var href=$(this).attr('href');
                return href.indexOf('javascript:')<0;
            }).each(function(index, el) {
                var href=$(this).attr('href');
                if(href.indexOf('<m met')>=0) $(this).attr({href:href.split('<m met')[0]});
            });
        },
        contextMenu:function(menu_obj) {
            // 显示右键菜单
            if(!menu_obj) menu_obj='.met-menu';
            var $menu_obj=$(menu_obj),
                $self=$(this),
                menu_obj_width=$menu_obj.outerWidth(),
                menu_obj_height=$menu_obj.outerHeight(),
                onContextMenu=function(e){
                    e.preventDefault();
                    var left=e.clientX,
                        right='auto',
                        top=e.clientY+50,
                        bottom='auto';
                    if(left+menu_obj_width>$(window).width()){
                        left='auto';
                        right=0;
                    }
                    if(top+menu_obj_height>$(window).height()){
                        top='auto';
                        bottom=0;
                    }
                    $menu_obj.addClass('show-menu').css({left:left,right:right,top:top,bottom:bottom});
                    $self.bind('mousedown',onMouseDown);
                    $self.parents('body').bind('mousedown', onMouseDown);
                    $menu_obj.find('.obj-remove').attr({'data-index':$self.index($(e.target).closest($self.selector))});
                },
                onMouseDown=function(){
                    $menu_obj.removeClass('show-menu');
                    $self.unbind('mousedown',onMouseDown);
                    $self.parents('body').unbind('mousedown', onMouseDown);
                };
            $self.bind('contextmenu',onContextMenu);
            // 右键菜单功能
            $menu_obj.find('.obj-remove').click(function(event) {
                $self.eq($(this).attr('data-index')).remove();
                onMouseDown();
            });
        }
    });
})();