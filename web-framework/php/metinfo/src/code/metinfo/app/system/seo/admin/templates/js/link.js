/* 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved. */
;(function() {
    var that = $.extend(true, {}, admin_module);
    M.component.commonList(function(thats) {
        return {
            ajax: {
                dataSrc: function(result) {
                    var data = [];
                    if (result.data) {
                        $.each(result.data, function(index, val) {
                            M.list.push(val);
                            let item = [
                                M.component.checkall('item',val.id),
                                val.orderno,
                                val.link_type > 0 ? METLANG.linkType5 : METLANG.linkType4,
                                val.webname,
                                val.weburl,
                                val.show_ok > 0 ? METLANG.yes : METLANG.no,
                                val.com_ok > 0 ? METLANG.yes : METLANG.no,
                                `<button
                                type="button"
                                class="btn btn-primary btn-sm"
                                data-modal-dataurl="M.list[${M.list.length-1}]"
                                data-toggle="modal"
                                data-target=".link-edit-modal"
                                data-modal-url="link/add/?n=link&c=link_admin&a=doGetColumnList"
                                data-modal-title="${METLANG.editor}"
                                >${METLANG.editor}</button>
                                ${M.component.btn('del',{del_url:M.url.adminurl+'n=link&c=link_admin&a=doDelLinks&id='+val.id})}`
                            ];
                            data.push(item);
                        });
                    }
                    return data;
                }
            }
        };
    });
    M.component.modal_options['.link-edit-modal']= {
        modalSize:'lg',
        modalFullheight:1,
        modalTablerefresh:'#seo-link-table',
    }
})();