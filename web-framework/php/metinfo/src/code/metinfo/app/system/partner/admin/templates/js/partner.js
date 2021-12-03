/* 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved. */
;(function() {
    var that = $.extend(true, {}, admin_module);
    // 分类列表初始化
    function renderNavlist() {
        metui.ajax({
            url: that.own_name + 'c=index&a=doCategory'
        }, function(result) {
            if (parseInt(result.status)) {
                var nav_html = '',
                    content_html='';
                $.each(result.data, function(index, val) {
                    nav_html+=`<a class="nav-link ${index?'':'active'}" href="#met-partner-tab-pane-${val.pid}" data-toggle="tab" data-pid="${val.pid}">${val.name}</a>`
                    content_html+=`<div class="tab-pane fade ${index?'':'show active'}" id="met-partner-tab-pane-${val.pid}"></div>`
                });
                that.obj.find('.nav').prepend(nav_html);
                that.obj.find('.tab-content').html(content_html);
                that.obj.find('.nav a:first-child').click();
            }
        })
    }
    // 切换分类
    that.obj.on('click', '.nav a', function(event) {
        var $tab_pane=that.obj.find(`.tab-content ${$(this).attr('href')}`);
        if(!$tab_pane.html()){
            metui.ajax({
                url: that.own_name + 'c=index&a=doindex',
                data:{pid:$(this).data('pid')}
            }, function(result) {
                if (parseInt(result.status)) {
                    let html = '';
                    if(result.msg) html+=`<div class="alert alert-primary">${result.msg}</div>${html}`;
                    html+='<div class="row list px-2">';
                    result.data.data.map(item => {
                        const card = `<div class="col-12 col-md-6 col-lg-4 col-xxl-3 px-2 mb-3">
                            <div class="media rounded-xs bg-white h-100 p-3 transition500">
                                <a href="${item.homepage ? item.homepage : ''}" class="d-flex cover" target="_blank">
                                    <img class="mr-2 rounded-xs" src="${item.logo}" width="50" height="50">
                                    <div class="media-body cover">
                                        <h5 class="mt-1 h6">${item.user_name}</h5>
                                        <div class="card-text text-truncate">${item.service}</div>
                                    </div> 
                                </a>
                            </div>
                        </div>`;
                        html += card
                    });
                    html+='</div>';
                    $tab_pane.html(html);
                }
            })
        }
    })
    renderNavlist();
    TEMPLOADFUNS[that.hash] = function() {
        that.obj.find('.nav a:first-child').click();
    }
})();