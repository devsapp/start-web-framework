/* 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved. */
;(function() {
  var that = $.extend(true, {}, admin_module)
  renderTable()
  del()
  delAll()
  TEMPLOADFUNS[that.hash] = function() {
    that.table && that.table.ajax.reload()
  }
  function renderTable() {
    metui.use(['table', 'alertify'], function() {
      const table = that.obj.find('#anchor-table')
      table.attr({ 'data-table-ajaxurl': table.data('ajaxurl') })
      datatable_option['#anchor-table'] = {
        ajax: {
          dataSrc: function(result) {
            that.data = result.data
            let newData = []
            that.data &&
              $.each(that.data, function(index, val) {
                let list = [
                  `<div class="custom-control custom-checkbox">
                <input class="checkall-item custom-control-input" type="checkbox" name="id" data-id="${val.id}" value="${val.id}"/>
                <label class="custom-control-label"></label>
                </div>`,
                  `<input name="oldwords" value="${val.oldwords}" class="form-control" type="text" required />`,
                  `<input name="newwords" value="${val.newwords}" class="form-control" type="text"/>`,
                  `<input name="newtitle" value="${val.newtitle}" class="form-control" type="text"/>`,
                  `<input name="url" value="${val.url}" class="form-control" type="text"/>`,
                  `<input name="num" value="${val.num}" class="form-control text-center" type="text"/>`,
                  `<button class="btn btn-delete" data-id="${val.id}">${METLANG.delete}</button>`
                ]

                newData.push(list)
              })

            return newData
          }
        }
      }

      that.obj.metDataTable(function() {
        that.table = datatable['#anchor-table']
        that.obj.metCommon()
        add()
        inputChange()

        save()
      })
    })
  }
  function add() {
    const btn_add = that.obj.find('.btn-add')
    const tr_add = that.obj.find('#anchor-table tbody')
    btn_add.click(function() {
      tr_add.append(that.obj.find('textarea[table-addlist-data]').val())
      var $new_tr = tr_add.find('tr:last-child')
      that.obj.find('#anchor-table tbody .dataTables_empty').hide()
      $new_tr.find('td:last-child').append(M.component.btn('cancel'))
    })
  }
  function del() {
    $(document).on('click', '#anchor-table .btn-delete', function() {
      let ids = [$(this).data('id')]
      alertify
        .okBtn(METLANG.confirm)
        .cancelBtn(METLANG.cancel)
        .confirm(METLANG.delete_information, function(ev) {
          handleDel(ids)
        })
    })
  }
  function delAll() {
    that.obj
      .find('#anchor-table .btn-delete-all')
      .off()
      .click(function() {
        let ids = []
        const $ids = that.obj.find("#anchor-table [name='id']:checked")
        if ($ids.length === 0) {
          alertify.error(`${METLANG.js23}`)
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
  }
  function handleDel(ids) {
    $.ajax({
      url: that.own_name + 'c=anchor&a=doDelAnchor',
      type: 'POST',
      dataType: 'json',
      data: {
        id: ids
      },
      success: function(result) {
        metAjaxFun({
          result: result,
          true_fun: function() {
            that.table.ajax.reload()
          }
        })
      }
    })
  }

  function save() {
    that.obj.find('.btn-save').click(function() {
      let ids = []
      const $ids = that.obj.find("#anchor-table [name='id']:checked")
      if ($ids.length === 0) {
        alertify.error(`${METLANG.js23}`)
        return
      }
      $ids.each(function() {
        let data = {}
        const tr = $(this).parents('tr')
        const input = tr.find(':text')
        const id = $(this).val() === 'on' ? 0 : $(this).val()
        input.each(function() {
          const name = $(this).attr('name')
          data[name] = $(this).val()
          data['id'] = id
        })
        ids.push(data)
      })
      const oldwords = ids.some(item => {
        return item.oldwords === ''
      })
      const newwords = ids.some(item => {
        return item.newwords === ''
      })
      if (oldwords) {
        alertify.error(METLANG.js18)
        return
      }
      if (newwords) {
        alertify.error(METLANG.replacement_text)
        return
      }
      $.ajax({
        url: that.own_name + 'c=anchor&a=doSaveAnchor',
        type: 'POST',
        dataType: 'json',
        data: {
          data: ids
        },
        success: function(result) {
          metAjaxFun({
            result: result,
            true_fun: function() {
              that.table.ajax.reload()
              that.obj.find('.class-add').remove()
            }
          })
        }
      })
    })
  }
  function inputChange() {
    setTimeout(() => {
      $('.met-anchor-list :text').change(function(e) {
        $(this)
          .parents('tr')
          .find(':checkbox')
          .attr('checked', 'checked')
      })
    }, 500)
  }
})()
