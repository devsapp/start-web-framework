/* 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved. */
;(function() {
  var that = $.extend(true, {}, admin_module)
  renderTable()
  TEMPLOADFUNS[that.hash] = function() {
    that.table && that.table.ajax.reload()
  }
  function renderTable(refresh) {
    metui.use(['table', 'alertify'], function() {
      const table = that.obj.find('#group-table')
      table.attr({ 'data-table-ajaxurl': table.data('ajaxurl') })
      datatable_option['#group-table'] = {
        ajax: {
          dataSrc: function(result) {
            that.data = result.data.group_data
            that.payment_open = result.data.payment_open
            let newData = []
            that.data && that.data.length && $.each(that.data, function(index, val) {
              let list = [
                `<div class="custom-control custom-checkbox">
                  <input class="checkall-item custom-control-input" type="checkbox" name="id" value="${val.id}"/>
                  <label class="custom-control-label"></label>
                </div>`,
                `<input name="name" value="${val.name}" class="form-control" type="text" />`,
                `${
                  that.payment_open&&val.payment
                    ? `
                <div class="status">
                ${METLANG.state}：
                <input type="checkbox"
                value="${val.payment.rechargeok > 0 ? '1' : '0'}"
                data-plugin="switchery" name="rechargeok" ${val.payment.rechargeok > 0 ? 'checked="checked"' : ''} class="status-input">
                </div>
                <div class="price mt-2" ${val.payment.rechargeok > 0 ? `` : `style="display:none;"`} >
                ${METLANG.amount_of}：<input name="recharge_price" class="form-control d-inline-block" style="width:100px;" value="${val.payment.recharge_price}">
                </div>
                `
                    : METLANG.useinfopay
                }`,
                `${
                  that.payment_open&&val.payment
                    ? `
                <div class="status">
                ${METLANG.state}：<input type="checkbox"
                data-plugin="switchery"
                value="${val.payment.buyok > 0 ? '1' : '0'}"
                name="buyok" ${val.payment.buyok > 0 ? 'checked="checked"' : ''} class="status-input">
                </div>
                <div class="price mt-2" ${val.payment.buyok > 0 ? `` : `style="display:none;"`}>
                ${METLANG.amount_of}：<input  name="price"  class="form-control d-inline-block " style="width:75px;" value="${val.payment.price}">
                </div>
                `
                    : METLANG.useinfopay
                }`,
                `<input name="access" value="${val.access}" class="form-control" type="text" />`,
                `<button class="btn btn-delete" data-id="${val.id}">${METLANG.delete}</button>`
              ]

              newData.push(list)
            })

            return newData
          }
        }
      }

      that.obj.metDataTable(function() {
        that.table = datatable['#group-table']
        that.obj.metCommon()
        add(that)
        inputChange(that)
        if (!refresh) {
          del()
        }
        delAll()
        save(that)
      })
    })
  }
  function add(that) {
    const btn_add = that.obj.find('.btn-add')
    btn_add.off().click(function() {
      const textarea = that.obj.find('textarea[table-addlist-data]')
      if (that.payment_open) {
        const newVal = `<tr class="class-add">
        <td class="text-center">
          <div class="custom-control custom-checkbox">
            <input class="checkall-item custom-control-input" type="checkbox" name="id" checked="checked" value="0">
            <label class="custom-control-label"></label>
          </div>
        </td>
        <td class="td-column-name">
            <input type="text" name="name"  class="form-control">
        </td>
        <td class="text-center recharge-add">
        <div class="status">
          ${METLANG.state}：
          <input type="checkbox"
            value="0"
            data-plugin="switchery"
            name="rechargeok"
            class="status-input" />
        </div>
        <div class="price mt-2" style="display:none;" >
            ${METLANG.amount_of}：
            <input name="recharge_price"
            class="form-control d-inline-block"
            style="width:100px;" >
        </div>
        </td>
        <td class="text-center buy-add">
        <div class="status">
        ${METLANG.state}：
        <input type="checkbox"
          value="0"
          data-plugin="switchery"
          name="buyok"
          class="status-input" />
      </div>
      <div class="price mt-2" style="display:none;" >
          ${METLANG.amount_of}：
          <input name="buy_price"
          class="form-control d-inline-block"
          style="width:100px;" >
      </div>
        </td>
        <td class="text-center">
            <input type="text" name="access"  class="form-control text-center">
        </td>
        <td>
        </td>
      </tr>`
        that.obj.find('table tbody').append(newVal)
      } else {
        that.obj.find('table tbody').append(textarea.val())
      }
      that.obj.find('.dataTables_empty').parents('tr').remove();
      var $new_tr = that.obj.find('table tbody tr:last-child')
      $new_tr.find('td:last-child').append(M.component.btn('cancel'))
      $new_tr.metFormAddField()
      $new_tr.metCommon()
    })
  }

  function del() {
    that.obj.find('.btn-delete').metClickConfirmAjax({
      true_fun: function() {
        let ids = [$(this)[0].el.data('id')]
        handleDel(ids)
      }
    })
  }
  function delAll() {
    that.obj
      .find('.btn-delete-all')
      .off()
      .click(function() {
        let ids = []
        const $ids = that.obj.find("#group-table [name='id']:checked")
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
      url: that.own_name + 'c=admin_group&a=doDelGroup',
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
  function save(that) {
    that.obj
      .find('.btn-save')
      .off()
      .click(function() {
        let ids = []
        const $ids = that.obj.find("#group-table [name='id']:checked")
        if ($ids.length === 0) return
        $ids.each(function() {
          let data = {}
          const tr = $(this).parents('tr')
          const input = tr.find(':text')
          const id = $(this).val() === 'on' ? 0 : $(this).val()
          input.each(function() {
            data[$(this).attr('name')] = $(this).val()
            data['id'] = id
          })
          const sw = tr.find(':checkbox')
          sw.each(function() {
            data[$(this).attr('name')] = $(this).val()
          })
          ids.push(data)
        })
        $.ajax({
          url: that.own_name + 'c=admin_group&a=doSaveGroup',
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
  function inputChange(that) {
    setTimeout(() => {
      that.obj.on('change',':text',function(e) {
          $(this)
            .parents('tr')
            .find('[name="id"]')
            .attr('checked', 'checked')
        })
      that.obj.on('change','.status-input',function(e) {
          const price = $(this)
            .parents('td')
            .find('.price')
          $(this)
            .parents('tr')
            .find('[name="id"]')
            .attr('checked', 'checked')
          if (e.target.value > 0) {
            price.hide()
          } else {
            price.show()
          }
        })
    }, 230)
  }
})()
