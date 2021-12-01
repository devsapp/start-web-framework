/* 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved. */
;(function() {
  var that = $.extend(true, {}, admin_module)

    renderTable()
    delAll()
  TEMPLOADFUNS[that.hash] = function() {
    that.table && that.table.ajax.reload();
  }
  function renderTable() {
    metui.use(['table', 'alertify'], function() {
      const table = that.obj.find('#logs-table')
      table.attr({ 'data-table-ajaxurl': table.data('ajaxurl') })
      datatable_option['#logs-table'] = {
        ajax: {
          dataSrc: function(result) {
            that.data = result.data
            let newData = []
            that.data &&
              $.each(that.data, function(index, val) {
                let list = [
                  `<div class="custom-control custom-checkbox">
                  <input class="checkall-item custom-control-input" type="checkbox" name="id" value="${val.id}"/>
                  <label class="custom-control-label"></label>
                  </div>`,
                  `${val.time}`,
                  `${val.username}`,
                  `${val.ip}`,
                  `${val.current_url}`,
                  `${val.module}`,
                  `${val.name}`,
                  `${val.result}`
                ]
                newData.push(list)
              })

            return newData
          }
        }
      }

      that.obj.metDataTable(function() {
        that.table = datatable['#logs-table']
        that.obj.metCommon()
      })
    })
  }

  function delAll() {
    $(document).on('click', '#logs-table .btn-delete-all', function() {
      let ids = []
      const $ids = that.obj.find("#logs-table [name='id']:checked")
      if ($ids.length === 0) {
        alertify.error(METLANG.js23)
        return
      }
      $ids.each(function() {
        ids.push($(this).val())
      })
      alertify
        .okBtn(METLANG.confirm)
        .cancelBtn(METLANG.cancel)
        .confirm(METLANG.delete_information, function(ev) {
          handleDel(ids)
        })
    })
    $(document).on('click', '#logs-table .btn-clear-all', function() {
      alertify
        .okBtn(METLANG.confirm)
        .cancelBtn(METLANG.cancel)
        .confirm(METLANG.confirm+METLANG.delete+METLANG.operation_log+'？', function(ev) {
          $.ajax({
            url: M.url.admin + '?n=logs&c=index&a=doLogClean',
            type: 'POST',
            dataType: 'json',
            success: function(result) {
              metAjaxFun({
                result: result,
                true_fun: function() {
                  that.obj.find('.checkall-all').removeAttr('checked')
                  that.table.ajax.reload()
                }
              })
            }
          })
        })
    })
  }
  function handleDel(ids) {
    $.ajax({
      url: M.url.admin + '?n=logs&c=index&a=dodel',
      type: 'POST',
      dataType: 'json',
      data: {
        id: ids
      },
      success: function(result) {
        metAjaxFun({
          result: result,
          true_fun: function() {
            that.obj.find('.checkall-all').removeAttr('checked')
            that.table.ajax.reload()
          }
        })
      }
    })
  }
})()
