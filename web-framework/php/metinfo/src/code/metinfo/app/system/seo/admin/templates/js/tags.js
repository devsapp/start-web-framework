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
                                    `<div class="custom-control custom-checkbox">
                                      <input class="checkall-item custom-control-input" type="checkbox" name="id" value="${val.id}"/>
                                      <label class="custom-control-label"></label>
                                    </div>`,
                                    val.sort,
                                    val.tag_name,
                                    val.tag_pinyin,
                                    val.tag_size > 0 ? val.tag_size : METLANG.default_values,
                                    val.tag_color ? val.tag_color : METLANG.default_values,
                                    val.source,
                                    val.cid,
                                    `<button
                                    type="button"
                                    class="btn btn-primary btn-sm"
                                    data-toggle="modal"
                                    data-target=".tags-edit-modal"
                                    data-modal-url="tags/edit/?n=tags&c=index&a=doGetTags&id=${val.id}"
                                    data-modal-title="${METLANG.editor}"
                                    >${METLANG.editor}</button>
                                    <a href="${val.url}" target="_blank" class="btn btn-default btn-sm">${METLANG.preview}</a>
                                    ${M.component.btn('del',{del_url:M.url.adminurl+'n=tags&c=index&a=doDelTags&id='+val.id})}`
                                ];
                            data.push(item);
                        });
                    }
                    return data;
                }
            }
        };
    });
    M.component.modal_options['.tags-edit-modal']= {
        modalSize:'lg',
        modalFullheight:1,
        modalTablerefresh:'#tags_table',
    };
})();