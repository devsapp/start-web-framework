/* 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved. */
;(function() {
  var that = $.extend(true, {}, admin_module)
  renderTable()
  add()
  delAll()
  edit()
  adminEdit()
  TEMPLOADFUNS[that.hash] = function() {
    that.table && that.table.ajax.reload()
  }
  function renderTable() {
    metui.use(['table', 'alertify'], function() {
      const table = that.obj.find('#admin-table')
      table.attr({ 'data-table-ajaxurl': table.data('ajaxurl') })
      datatable_option['#admin-table'] = {
        ajax: {
          dataSrc: function(result) {
            that.data = result.data
            let newData = []
            $.each(that.data, function(index, val) {
                let no_admin = val.now_admin === '1';
              let list = [
                `<div class="custom-control custom-checkbox">
                  <input class="checkall-item custom-control-input" type="checkbox" name="id" value="${val.id}"/>
                  <label class="custom-control-label"></label>
                </div>`,
                `${val.admin_id}`,
                `${val.admin_group_name}`,
                `${val.admin_name}`,
                `${val.admin_login}`,
                `${val.admin_modify_date}`,
                `${val.admin_modify_ip}`,
                `${
                    no_admin
                    ? `<button class="btn btn-default btn-sys"
                 data-id="${val.id}"
                 data-toggle="modal"
                 data-modal-url="admin/admin_sys"
                 data-modal-dataurl="${val.editor_url}"
                 data-modal-size="lg"
                 data-modal-title="${val.action_name}"
                 data-target=".admin-sys-modal"
                 data-modal-tablerefresh="#admin-table"
                 >${val.action_name}</button>`
                    : `<button class="btn btn-default btn-edit"
                    data-id="${val.id}"
                    data-toggle="modal"
                    data-modal-url="admin/admin_edit"
                    data-modal-dataurl="${val.editor_url}"
                    data-modal-size="lg"
                    data-modal-fullheight="1"
                    data-modal-title="${val.action_name}"
                    data-target=".admin-edit-modal"
                    data-modal-tablerefresh="#admin-table"
                      >${val.action_name}</button>`
                }`
              ]

              newData.push(list)
            })

            return newData
          }
        }
      }

      that.obj.metDataTable(function() {
        that.table = datatable['#admin-table']
        that.obj.find('#admin-table tbody').metCommon()
      })
    })
  }
  function adminEdit() {
    M.component.modal_options['.admin-sys-modal'] = {
      callback:function(key,data){
        that.userInfo = data
        const modal=$('.modal[data-key="'+key+'"]');
        modal.find('[name="id"]').val(that.userInfo.id)
        modal.find(`[name="admin_id"]`).val(that.userInfo['admin_id'])
        modal.find(`[name="admin_name"]`).val(that.userInfo['admin_name'])
        modal.find(`[name="admin_email"]`).val(that.userInfo['admin_email'])
        modal.find(`[name="admin_mobile"]`).val(that.userInfo['admin_mobile'])
        metui.use('form',function(){
          formSaveCallback(modal.find('form').attr('data-validate_order'), {
            true_fun: function(result) {
              if(modal.find(`[name="admin_pass"]`).val()) setTimeout(function(){window.location.href = M.url.admin + '?n=login&c=login&a=dologinout'},1000);
            }
          });
        });
      }
    };
  }
  function edit() {
    M.component.modal_options['.admin-edit-modal'] = {
      callback: function(key, data) {
        that.userInfo = data
        const modal = $('.modal[data-key="' + key + '"]');
        modal.find('[name="id"]').val(that.userInfo.id)
        modal.find(`[name="admin_id"]`).val(that.userInfo['admin_id'])
        modal.find(`[name="admin_name"]`).val(that.userInfo['admin_name'])
        modal.find(`[name="admin_email"]`).val(that.userInfo['admin_email'])
        modal.find(`[name="admin_mobile"]`).val(that.userInfo['admin_mobile'])
        renderColumn(modal, () => {
          modal.find('[name="admin_group"]').attr('checked', null)
          modal
            .find(`#radio-${that.userInfo.admin_login_lang}`)
            .attr('checked', true)
            .prop({
              checked: true
            })
          modal
            .find(`#admin_group-${that.userInfo.admin_group}`)
            .attr('checked', true)
            .prop({
              checked: true
            })
          if (that.userInfo.admin_group === '0') {
            check({
              key: 'pop_check',
              name: 'admin_pop',
              modal: modal
            })
            check({
              key: 'op_check',
              name: 'admin_op',
              modal: modal
            })
            check({
              key: 'lang_check',
              name: 'langok',
              modal: modal
            })
            modal.find("[name='admin_issueok']").attr('disabled', null)
            that.userInfo.admin_issueok > 0 ? modal
              .find("[name='admin_issueok']")
              .attr('checked', true)
              .prop({
                checked: true
              }) : null
            that.userInfo.admin_check > 0 ? modal
              .find("[name='admin_check']")
              .attr('checked', true)
              .prop({
                checked: true
              }) : null
            modal.find("[name='admin_check']").attr('disabled', null)
            modal.find("[name='admin_login_lang']").attr('disabled', null)
          } else {
            modal.find(`#admin_group-${that.userInfo.admin_group}`).change()
          }
        })
      }
    };
  }
  function check(obj) {
    const checkObj = that.userInfo[obj.key].split('|')
    obj.modal.find(`[name = '${obj.name}']`).attr('checked', null)
    obj.modal.find(`[name = '${obj.name}']`).attr('disabled', null)
    if (checkObj.length > 0) {
      checkObj.map(item => {
        obj.modal.find(`[name = '${obj.name}']`).each(function() {
          if (item === $(this).val()) {
            $(this)
              .attr('checked', true)
              .prop({ checked: true })
          }
        })
      })
    }
  }
  function add() {
    $(document).on('shown.bs.modal', '.admin-add-modal', function(e) {
      const modal = $(e.target)
      setTimeout(() => {
        renderColumn(modal)

        modal.find('.modal-loader').addClass('hide')
        modal.find('.modal-html').removeClass('hide')
        modal.scrollTop(0)
      }, 230)
    })
    $(document).on('hidden.bs.modal', '.admin-add-modal', function(e) {
      const modal = $(e.target)
      modal.off()
      modal.remove()
    })
  }
  function adminChange(modal) {
    const langAll = modal.find('.lang-select-all')
    const langItem = modal.find('.lang-select-item')
    const columnLang = modal.find('.column-lang')
    const admin_op_1 = modal.find('.admin_op_1')
    const admin_op = modal.find('.admin_op')
    const s9999 = modal.find('#s9999')
    admin_op_1.off().change(function(e) {
      if (!e.target.checked) {
        admin_op.attr('checked', null)
        s9999.attr('checked', null)
      } else {
        admin_op.attr('checked', true).prop({ checked: true })
        s9999.attr('checked', true).prop({ checked: true })
      }
    })
    admin_op.off().change(function(e) {
      const _this = $(e.target)
      if (!e.target.checked) {
        admin_op_1.attr('checked', null)
        _this.val() === 'add' && s9999.attr('checked', null)
      } else {
        _this.val() === 'add' && s9999.attr('checked', true).prop({ checked: true })
        let all_check = 1
        admin_op.each(function() {
          if (!$(this).prop('checked')) {
            all_check = 0
          }
        })
        if (all_check == 1) {
          admin_op_1.attr('checked', true).prop({ checked: true })
        }
      }
    })
    langAll.off().change(function(e) {
      if (e.target.checked) {
        langItem.attr('checked', true).prop({ checked: true })
      }
    })
    langAll.off().change(function(e) {
      if (e.target.checked) {
        langItem.attr('checked', true).prop({ checked: true })
      }
    })
    langItem.off().change(function(e) {
      if (!e.target.checked) {
        langAll.attr('checked', false)
        $(`.column-lang-${e.target.value}`).attr('checked', null)
      } else {
        let all_check = 1
        langItem.each(function() {
          if (!$(this).prop('checked')) {
            all_check = 0
          }
        })
        if (all_check == 1) {
          langAll.attr('checked', true).prop({ checked: true })
        }
        $(`.column-lang-${e.target.value}`)
          .attr('checked', true)
          .prop({ checked: true })
      }
    })
    columnLang.off().change(function(e) {
      let clang = $(this).data('column-lang')
      langItem.each(function() {
        if ($(this).val() == clang) {
          $(this)
            .attr('checked', true)
            .prop({ checked: true })
        }
      })
    })
    modal
      .find('[name="admin_group"]')
      .off()
      .change(function(e) {
        let roles
        switch (e.target.value) {
          case '1':
            roles = ['s1007', 's1103', 's1201', 's1002', 's1003', 's1301', 's9999', 's1802', 's0', 's1106', 's1604', 's1605', 's1901', 's1902', 's1903', 's1104']
            modal.find("[name = 'langok']")
              .attr('checked', true)
              .prop({ checked: true })
            modal.find("[name = 'langok']").attr('disabled', 'disabled')
            modal.find("[name = 'admin_login_lang']").attr('disabled', 'disabled')
            modal.find("[name = 'admin_issueok']").attr('checked', null)
            modal.find("[name = 'admin_issueok']").attr('disabled', 'disabled')
            modal.find("[name = 'admin_op']")
              .attr('checked', true)
              .prop({ checked: true })
            modal.find("[name = 'admin_op']").attr('disabled', 'disabled')
            modal.find("[name = 'admin_pop']").attr('disabled', 'disabled')
            modal.find("[name = 'admin_pop']").each(function() {
              if (
                $(this)
                  .val()
                  .slice(0, 1) == 'c' ||
                roles.indexOf($(this).val()) > -1
              ) {
                $(this)
                  .attr('checked', true)
                  .prop({ checked: true })
              } else {
                $(this).attr('checked', null)
              }
            })

            break
          case '2':
            roles = ['s1007', 's1103', 's1201', 's1002', 's1003', 's1401', 's1106', 's1404', 's1301', 's9999', 's1802', 's1901', 's1902', 's1903', 's1104']
            modal.find("[name = 'langok']")
              .attr('checked', true)
              .prop({ checked: true })
            modal.find("[name = 'langok']").attr('disabled', 'disabled')
            modal.find("[name = 'admin_login_lang']").attr('disabled', 'disabled')
            modal.find("[name = 'admin_issueok']").attr('checked', null)
            modal.find("[name = 'admin_issueok']").attr('disabled', 'disabled')
            modal.find("[name = 'admin_op']")
              .attr('checked', true)
              .prop({ checked: true })
            modal.find("[name = 'admin_op']").attr('disabled', 'disabled')
            modal.find("[name = 'admin_pop']").attr('disabled', 'disabled')
            modal.find("[name = 'admin_pop']").each(function() {
              if (
                $(this)
                  .val()
                  .slice(0, 1) == 'c' ||
                roles.indexOf($(this).val()) > -1
              ) {
                $(this)
                  .attr('checked', true)
                  .prop({ checked: true })
              } else {
                $(this).attr('checked', null)
              }
            })

            break
          case '3':
            modal.find("[name = 'langok']")
              .attr('checked', true)
              .prop({ checked: true })
            modal.find("[name = 'langok']").attr('disabled', 'disabled')
            modal.find("[name = 'admin_login_lang']").attr('disabled', 'disabled')
            modal.find("[name = 'admin_issueok']").attr('checked', null)
            modal.find("[name = 'admin_issueok']").attr('disabled', 'disabled')
            modal.find("[name = 'admin_op']")
              .attr('checked', true)
              .prop({ checked: true })
            modal.find("[name = 'admin_op']").attr('disabled', 'disabled')
            modal.find("[name = 'admin_pop']")
              .attr('checked', true)
              .prop({ checked: true })
            modal.find("[name = 'admin_pop']").attr('disabled', 'disabled')

            break
          case '0':
            modal.find("[name = 'langok']")
              .attr('checked', true)
              .prop({ checked: true })
            modal.find("[name = 'langok']").attr('disabled', null)
            modal.find("[name = 'admin_issueok']").attr('checked', null)
            modal.find("[name = 'admin_issueok']").attr('disabled', null)
            modal.find("[name='admin_check']").attr('disabled', null)
            modal.find("[name = 'admin_login_lang']").attr('disabled', null)
            modal.find("[name = 'admin_op']")
              .attr('checked', true)
              .prop({ checked: true })
            modal.find("[name = 'admin_op']").attr('disabled', null)
            modal.find("[name = 'admin_pop']")
              .attr('checked', true)
              .prop({ checked: true })
            modal.find("[name = 'admin_pop']").attr('disabled', null)
            modal.find("[name = 'admin_pop']").each(function() {
              if ($(this).val() == 's1801') {
                $(this).attr('checked', null)
              }
            })

            break
        }
      })

    $('.admin_pop_all')
      .off()
      .on('change', function(e) {
        const checked = $(this).attr('checked')
        if (checked) {
          modal.find('.role').attr('checked', null)
        } else {
          $('.role')
            .attr('checked', true)
            .prop({ checked: true })
        }
      })
  }

  function delAll() {
    $(document).on('click', '#admin-table .btn-delete-all', function() {
      let ids = []
      const $ids = that.obj.find("#admin-table [name='id']:checked")
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
      url: that.own_name + 'c=index&a=doDelAdmin',
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

  function renderColumn(modal, callback) {
    metui.request({ url: that.own_name + 'c=index&a=doGetColumn' }, function(res) {
      const data = res.data.metinfocolumn
      let newArr = []
      Object.keys(data).map(item => {
        let next = [],
          next2 = []
        if (data[item].next) {
          const _next = data[item].next
          Object.keys(_next).map(val => {
            next.push({
              name: _next[val].name,
              id: val
            })
          })
        }
        if (data[item].next2) {
          const _next2 = data[item].next2
          Object.keys(_next2).map(val => {
            let children = []
            if (_next2[val].column || val === 'column') {
              const column = _next2[val].column || _next2[val]
              Object.keys(column).map(col => {
                children.push({
                  name: column[col].name ? column[col].name : '',
                  id: col
                })
              })
            }
            next2.push({
              name: _next2[val].info ? _next2[val].info.name : _next2[val].name || '',
              id: val,
              children: children
            })
          })
        }
        newArr.push({
          name: data[item].info ? data[item].info.name : '',
          next: next,
          next2: next2
        })
      })
      let html = ''
      newArr.map(item => {
        let nextHtml = '',
          next2Html = ''
        if (item.next.length > 0) {
          nextHtml = item.next
            .map(val => {
              return `<div class="custom-control custom-checkbox custom-control-inline">
          <input type="checkbox" id="${val.id}" data-delimiter="-" name="admin_pop" class="custom-control-input role" disabled="disabled" checked="checked" value="${val.id}"/>
          <label class="custom-control-label" for="${val.id}">${val.name}</label>
        </div>`
            })
            .join('')
        }
        if (item.next2.length > 0) {
          next2Html = item.next2
            .map(val => {
              return `<div class="alert alert-dark mb-2">
            ${val.name ? `<h6>${val.name}</h6>` : ``}
            <div class="x3">
              ${val.children
                .map(e => {
                  return `<div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" id="${e.id}"
                data-delimiter="-"
                name="admin_pop"
                class="custom-control-input role ${val.id !== 'column' && `column-lang column-lang-${val.id}`}"
                data-column-lang="${val.id}"
                disabled="disabled"
                checked="checked"
                value="${e.id}"/>
                <label class="custom-control-label" for="${e.id}">${e.name}</label>
                </div>`
                })
                .join('')}
            </div>
        </div>`
            })
            .join('')
        }
        html =
          html +
          `<div class="card mb-2 p-2">
      <h5>${item.name}</h5>
      <div class="x2">${nextHtml}</div>
      <div class="x3">${next2Html}</div>
      </div>`
      })
      modal.find('.admin-operate').html(html)
      adminChange(modal)
      if (callback) {
        callback()
      }
    })
  }
})()
