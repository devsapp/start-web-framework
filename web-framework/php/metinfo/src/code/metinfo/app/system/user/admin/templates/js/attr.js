/* 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved. */
;(function() {
  var that = $.extend(true, {}, admin_module)
  renderTable()
  TEMPLOADFUNS[that.hash] = function() {
    that.table && that.table.ajax.reload()
  }
  function renderTable(refresh) {
    metui.use(['table', 'alertify', 'dragsort'], function() {
      const table = that.obj.find('#user-attr-table')
      table.attr({ 'data-table-ajaxurl': table.data('ajaxurl') })
      datatable_option['#user-attr-table'] = {
        ajax: {
          dataSrc: function(result) {
            that.data = result.data
            let newData = []
            const arr = ['2', '4', '6']
            that.data && that.data.length && $.each(that.data, function(index, val) {
              let list = [
                M.component.checkall('item', val.id) + M.component.formWidget('no_order', val.no_order),
                M.component.formWidget('name', val.name, 'text', 1),
                M.component.formWidget({
                  name: 'type',
                  type: 'select',
                  value: val.type,
                  data: val.type_options,
                  data_value_key: 'val'
                }),
/*                 M.component.formWidget({
                  name: 'class',
                  type: 'select',
                  value: val.class,
                  data: val.class_options,
                  data_value_key: 'val'
                }), */
                M.component.formWidget({
                  name: 'access',
                  type: 'select',
                  value: val.access,
                  data: val.access_options,
                  data_value_key: 'val'
                }),
                M.component.formWidget({
                  name: 'edit_ok',
                  type: 'select',
                  value: val.edit_ok,
                  data: [{ name: METLANG.editable, value: 1 }, { name: METLANG.non_editable, value: 0 }]
                }),
                M.component.formWidget({
                  name: 'wr_ok',
                  type: 'select',
                  value: val.wr_ok,
                  data: [{ name: METLANG.yes, value: 1 }, { name: METLANG.no, value: 0 }]
                }),
                `<button class="btn btn-default btn-delete" data-id="${val.id}">${METLANG.delete}</button>
                <button class="btn btn-primary ml-2 btn-set" ${arr.indexOf(val.type) > -1 ? `` : `style="display:none;`}"
                data-index="${index}"
                data-toggle="modal"
                data-target=".attr-add-modal"
                data-modal-url="user/attr_add"
                data-modal-title="${METLANG.listTitle}<font class='text-danger ml-2 font-size-14'>${METLANG.admin_content_list1}</font>"
                >${METLANG.listTitle}</button>
                <textarea hidden class="para-list-${index}">${val.options ? JSON.stringify(val.options) : ``}</textarea>
                `
              ]

              newData.push(list)
            })

            return newData
          }
        }
      }
      dragsortFun['#user-attr-table'] = dragsortFun['#user-para-options-list'] = function(wrapper) {
        wrapper.find('tr [name="no_order"],tr [name="order"]').each(function(index, el) {
          $(this).val(
            $(this)
              .parents('tr')
              .index()
          )
        })
      }
      that.obj.metDataTable(function() {
        that.table = datatable['#user-attr-table']
        if (!refresh) {
          del()
          delAll()
          addPara()
        }
        add()
        inputChange()
        that.obj
          .find('.btn-save')
          .off()
          .click(function() {
            save()
          })
      })
    })
  }
  function add() {
    const btn_add = that.obj.find('.btn-add')
    const table = that.obj.find('#user-attr-table tbody')
    metui.request(
      {
        url: that.own_name + 'c=parameter&a=doGetOptions'
      },
      function(result) {
        that.options = result.data
      }
    )
    btn_add.click(function() {
      that.obj.find('.dataTables_empty').hide()
      const html = `  <tr class="class-add">
      <td class="text-center">
        <div class="custom-control custom-checkbox">
          <input class="checkall-item custom-control-input" type="checkbox" name="id" checked="checked">
          <label class="custom-control-label"></label>
        </div>
        <input type="hidden" name="no_order" value="${table.find('tr').length}">
      </td>
      <td class="td-column-name">
          <input type="text" name="name"  class="form-control" placeholder="${METLANG.user_must_v6}" required>
      </td>
      <td class="text-center">
      <select class="form-control w-auto d-inline-block" name="type" >
      ${that.options.type_options.map(item => {
        return `<option value=${item.val}>${item.name}</option>`
      })}
      </select>
      </td>
      <td class="text-center">
      <select class="form-control w-auto d-inline-block" name="access" >
      ${that.options.access_options.map(item => {
        return `<option value=${item.val}>${item.name}</option>`
      })}
      </select>
      </td>
      <td class="text-center">
      <select class="form-control w-auto d-inline-block" name="edit_ok" >
      <option value="1">${METLANG.editable}</option>
      <option value="0">${METLANG.non_editable}</option>
       </select>
      </td>
      <td class="text-center">
      <select class="form-control w-auto d-inline-block" name="wr_ok" >
      <option value="0">${METLANG.no}</option>
      <option value="1">${METLANG.yes}</option>
       </select>
      </td>
      <td>
      <button class="btn btn-primary ml-2 btn-set" style="display:none;"
      data-toggle="modal"
      data-target=".attr-add-modal"
      data-modal-url="user/attr_add"
      data-modal-size="lg"
      data-modal-title="${METLANG.listTitle}"
      >${METLANG.listTitle}</button>
      <textarea hidden class="para-list"></textarea>
      </td>
    </tr>`
      table.append(html)
      var $new_tr = table.find('tr:last-child')
      $new_tr.find('td:last-child').append(M.component.btn('cancel'))
      $new_tr.metFormAddField()
    })
  }

  function del() {
    $('#user-attr-table tbody .btn-delete').metClickConfirmAjax({
      true_fun: function() {
        const id = $(this)[0].el.data('id')
        let ids = [id]
        handleDel(ids)
      }
    })
  }
  function delAll() {
    $(document).on('click', '#user-attr-table .btn-delete-all', function(e) {
      let ids = []
      const $ids = $("#user-attr-table [name='id']:checked")
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
      url: that.own_name + 'c=parameter&a=doDelParas',
      type: 'POST',
      dataType: 'json',
      data: {
        id: ids
      },
      success: function(result) {
        metAjaxFun({
          result: result,
          true_fun: function() {
            that.obj.find('.checkall-all').prop('checked', false)
            that.table.ajax.reload()
          }
        })
      }
    })
  }
  function save() {
    let ids = []
    const $ids = $("#user-attr-table [name='id']:checked")
    if ($ids.length === 0) {
      alertify.error(`${METLANG.js23}`)
      return
    }
    $ids.each(function() {
      let data = {}
      const tr = $(this).parents('tr')
      const $name = tr.find('[name]')
      $name.each(function() {
        data[$(this).attr('name')] = $(this).val()
      })
      if (tr.find('textarea').val()) {
        const options = JSON.parse(tr.find('textarea').val())
        data['options'] = options
      }
      ids.push(data)
    })
    $.ajax({
      url: that.own_name + 'c=parameter&a=doSaveParas',
      type: 'POST',
      dataType: 'json',
      data: {
        data: ids
      },
      success: function(result) {
        that.obj.find('#user-attr-table').tabelAjaxFun(result, function() {
          that.obj.find('.class-add').remove()
        })
      }
    })
  }
  function inputChange() {
    that.obj.find('#user-attr-table').on('change', '[name][name!="id"]', function(e) {
      const tr = $(this).parents('tr')
      tr.find('[name="id"]').prop('checked', true)
      if ($(this).attr('name') == 'type') {
        const arr = ['2', '4', '6']
        const btn_set = tr.find('td:last-child').find('.btn-set')
        if (arr.indexOf(e.target.value) > -1) {
          btn_set.show()
        } else {
          btn_set.hide()
        }
      }
    })
  }
  function addPara() {
    $(document).on('click', '#user-attr-table .btn-set', function(e) {
      const btn = $(e.target)
      let id = btn
        .parents('tr')
        .find('[name="id"]')
        .val()
      if (id === 'on') {
        btn
          .parents('tr')
          .find('[name="id"]')
          .val(`on-${Date.parse(new Date())}`)
        id = `on-${Date.parse(new Date())}`
      }

      that.textarea = btn.parents('tr').find('textarea')
      that.index = btn.data('index')
      btn
        .parents('tr')
        .find('[name="id"]')
        .prop('checked', true)
      that.activeData = that.data[that.index] || { options: [] }
      setTimeout(function() {
        $('.attr-add-modal')
          .find('[name="para_id"]')
          .val(id)
      }, 1000)
    })

    M.component.modal_options['.attr-add-modal'] = {
      callback: function() {
        const modal = $('.attr-add-modal')
        const textarea = $('#user-attr-table tbody [name="id"][value="' + modal.find('[name="para_id"]').val() + '"]')
          .parents('tr')
          .find('textarea')
        let options = []
        if (that.activeData.options && that.activeData.options instanceof Array) {
          options = that.activeData.options
        }
        let html = ''
        options.map(item => {
          html += `<tr>
            <td class="text-center">${M.component.checkall('item', item.id)}${M.component.formWidget('order', item.order)}</td>
            <td>${M.component.formWidget('value', item.value, 'text', 1)}</td>
            <td><button type="button" class="btn btn-sm btn-default btn-para-delete">${METLANG.delete}</button></td></tr>`
        })
        !html && (html = '<tr><th colspan="3" class="text-center dataTables_empty">' + METLANG.csvnodata + '</th></tr>')
        modal.find('tbody').html(html)
        modal.find('form').attr('data-validate_order') && modal.find('form').metFormAddField()
        modal.find('.checkall-all').prop('checked', false)
      }
    }
    $(document).on('click', '.attr-add-modal .btn-para-delete', function(e) {
      const element = $(e.target)
      element.parents('tr').remove()
    })
    $(document).on('click', '.attr-add-modal .btn-para-delete-all', function() {
      const modal = $('.attr-add-modal')
      const $ids = modal.find('tbody [name="id"]:checked')
      if ($ids.length === 0) {
        alertify.error(`${METLANG.js23}`)
        return
      }
      alertify
        .okBtn(METLANG.confirm)
        .cancelBtn(METLANG.cancel)
        .confirm(METLANG.delete_information, function(ev) {
          modal
            .find('tbody [name="id"]:checked')
            .parents('tr')
            .remove()
        })
    })
    // 参数属性框-添加
    $(document).on('click', '#user-para-options-list [table-addlist]', function(event) {
      setTimeout(function() {
        var $new_tr = $('#user-para-options-list').find('tbody tr:last-child')
        $new_tr.find('[name="order"]').val($new_tr.index())
      }, 0)
    })
    $(document).on('click', '.attr-add-modal [data-ok]', function() {
      const modal = $('.attr-add-modal')
      modal.find('form').submit()
      setTimeout(function() {
        if (!modal.find('form .has-danger').length) {
          let ids = []
          const $ids = $(".attr-add-modal tbody [name='id']").parents('tr')
          $ids.each(function() {
            let data = {}
            const $name = $(this).find('[name]')
            $name.each(function() {
              data[$(this).attr('name')] = $(this).val()
            })
            ids.push(data)
          })
          const textarea = $('#user-attr-table tbody [name="id"][value="' + modal.find('[name="para_id"]').val() + '"]')
            .parents('tr')
            .find('textarea')

          textarea.val(JSON.stringify(ids))
          save()
          modal.modal('hide')
        }
      }, 100)
    })
  }
})()
