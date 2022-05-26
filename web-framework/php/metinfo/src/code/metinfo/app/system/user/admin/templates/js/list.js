/* 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved. */
;(function() {
  var that = $.extend(true, {}, admin_module)
  renderTable()
  TEMPLOADFUNS[that.hash] = function() {
    that.table && that.table.ajax.reload()
  }
  function renderTable(refresh) {
    metui.use(['table', 'alertify'], function() {
      const table = that.obj.find('#user-table')
      table.attr({ 'data-table-ajaxurl': table.data('ajaxurl') })
      datatable_option['#user-table'] = {
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
                  `${val.username}`,
                  `${val.groupid}`,
                  `${val.register_time}`,
                  `${val.login_time}`,
                  `${val.login_count}`,
                  `${val.valid > 0 ? `${METLANG.memberChecked}` : `${METLANG.memberUnChecked}`}`,
                  `${val.source}`,
                  `<button class="btn btn-default btn-edit" data-id="${val.id}"
                data-toggle="modal"
                data-modal-url="user/user_edit"
                data-modal-size="lg"
                data-modal-fullheight="1"
                data-modal-title="${METLANG.editor}"
                data-target=".user-edit-modal"
                data-modal-tablerefresh="#user-table"
                data-modal-loading="1"
               >${METLANG.editor}</button>
                <button class="btn btn-delete ml-2" data-id="${val.id}">${METLANG.delete}</button>`
                ]
                newData.push(list)
              })

            return newData
          }
        }
      }

      that.obj.metDataTable(function() {
        that.table = datatable['#user-table']
        delAll()
        getUserGroup()
        del()
        add()
        edit()
      })
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
        const $ids = that.obj.find("#user-table [name='id']:checked")
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
      url: that.own_name + 'c=admin_user&a=doDelUser',
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
  function getUserGroup() {
    that.group_options = ''
    $.ajax({
      url: that.own_name + 'c=admin_group&a=doGetUserGroup',
      type: 'GET',
      dataType: 'json',
      success: function(result) {
        if (!result.data) return
        result.data.group_data && result.data.group_data.length && result.data.group_data.map(item => {
          that.group_options = that.group_options + `<option value="${item.id}">${item.name}</option>`
        })
        that.obj.find('.select-groupid').html(`<option value="">${METLANG.cvall}</option>` + that.group_options)
      }
    })
  }
  function add() {
    $(document).on('shown.bs.modal', '.user-add-modal', function(e) {
      const modal = $(e.target)
      that.group_options = ''
      setTimeout(() => {
        renderAddModal(modal)
      }, 230)
    })
    function renderAddModal(modal) {
      $.ajax({
        url: that.own_name + 'c=admin_group&a=doGetUserGroup',
        type: 'GET',
        dataType: 'json',
        success: function(result) {
          if (!result.data) return
          result.data.group_data && result.data.group_data.length && result.data.group_data.map(item => {
            that.group_options = that.group_options + `<option value="${item.id}">${item.name}</option>`
          })
          modal.find('[name="groupid"]').html(that.group_options)
          modal.find('.modal-loader').addClass('hide')
          modal.find('.modal-html').removeClass('hide')
          modal.scrollTop(0)
        }
      })
      const form = modal.find('.user-add-form')
    }
  }
  function edit() {
    let id
    $(document).on('click', '.met-user-list .btn-edit', function(e) {
      const btn = $(e.target)
      id = btn.data('id')
    })
    $(document).on('shown.bs.modal', '.user-edit-modal', function(e) {
      const modal = $(e.target)
      setTimeout(() => {
        renderEditModal(modal)
        modal.find('.modal-loader').addClass('hide')
        modal.find('.modal-html').removeClass('hide')
        modal.scrollTop(0)
      }, 500)
    })
    function renderEditModal(modal) {
      $.ajax({
        url: that.own_name + 'c=admin_user&a=doGetUserInfo',
        data: {
          id: id
        },
        type: 'POST',
        dataType: 'json',
        success: function(result) {
          that.userInfo = result.data
          const para_html = that.userInfo.user_para
            .map(item => {
              return `<dl>
          <dt>
            <label class="form-control-label">${item.name}</label>
          </dt>
          <dd>
            <div class="form-group clearfix">
            ${switchType(item)}
            </div>
          </dd>
        </dl>`
            })
            .join('')
          modal.find('.user-attr').html(para_html)
          modal.find('[name="groupid"]').html(that.group_options)
          modal.find('[name="id"]').val(that.userInfo.id)
          Object.keys(that.userInfo).map(item => {
            modal.find(`[name="${item}"]`).val(that.userInfo[item])
          })
          modal.find('.user-attr').metCommon()
          modal.find('.user-attr').metFormAddField()
        }
      })
    }
  }
  function sortData(data) {
    let arr = []
    data.map(item => {
      arr[item.order] = item
    })
    return arr
  }
  function switchType(item) {
    switch (item.type) {
      case '1':
        return M.component.formWidget(`info_${item.id}`, `${item.value ? item.value : ''}`, `text`, item.wr_ok > 0)
      case '2':
        item.list.unshift({
          id:'',
          value: METLANG.please_choose
        })
        return M.component.formWidget({
          type: 'select',
          name: `info_${item.id}`,
          value: item.value||'',
          data: item.list,
          required: item.wr_ok > 0,
          data_value_key:'id',
          select_option: function(index, val) {
            return val.value
          }
        })
      case '3':
        return M.component.formWidget(`info_${item.id}`, `${item.value ? item.value : ''}`, `textarea`, item.wr_ok > 0)
      case '4':
        return M.component.formWidget({
          type: 'checkbox',
          name: `info_${item.id}`,
          value: item.value,
          data: item.list,
          data_value_key: 'id',
          required: item.wr_ok > 0,
          delimiter: '#@met@#'
        })

      case '6':
        return M.component.formWidget({
          type: 'radio',
          name: `info_${item.id}`,
          value: item.value || item.list[0].id,
          data: item.list,
          data_value_key:'id',
          required: item.wr_ok > 0
        })
      case '8':
        return `<input type="text" name="info_${item.id}" class="form-control"
        data-fv-phone="true" data-fv-phone-message='${METLANG.valid_phone_number}'
        value="${item.value ? item.value : ''}" ${item.wr_ok ? 'required' : ''}/>`
      case '9':
        return `<input type="text" name="info_${item.id}"
        data-fv-emailAddress="true" data-fv-emailAddress-message='${METLANG.valid_email_address}'
        class="form-control" value="${item.value ? item.value : ''}" ${item.wr_ok ? 'required' : ''}/>`
    }
  }
})()
