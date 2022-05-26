/* 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved. */
;(function() {
  var that = $.extend(true, {}, admin_module),
    obj = that.obj
  renderTable()

  TEMPLOADFUNS[that.hash] = function() {
    renderTable(1)
  }
  function renderTable(refresh) {
    metui.use(['table', 'alertify'], function() {
      const table = that.obj.find('#lang-admin-table')
      table.attr({ 'data-table-ajaxurl': table.data('ajaxurl') })
      datatable_option['#lang-admin-table'] = {
        ajax: {
          dataSrc: function(result) {
            that.met_index_type = result.data.met_index_type
            that.langData = result.data
            let newData = [],
              select = ``,
              sysMark = ['cn', 'en']
            $.each(that.langData, function(index, val) {
              let list = [
                val.no_order,
                val.name,
                `<i class="fa fa-${parseInt(val.useok) ? 'check-circle text-success' : 'close-circle text-danger'}"></i>`,
                `${val.met_admin_type === val.mark ? `<i class="fa fa-flag" />` : ''}`,
                `<button class="btn btn-default mb-2 btn-edit"
                type="button"
                data-index="${index}"
                data-toggle="modal"
                data-target=".lang-admin-edit"
                data-modal-url="language/admin_edit"
                data-modal-size="lg"
                data-modal-loading="1"
                data-modal-title="${METLANG.editor}"
                data-modal-tablerefresh="#lang-admin-table"
                data-refresh="1"
                >${METLANG.editor}</button>
                <button type="button" class="btn btn-default mb-2 btn-langadmin-delete" data-id="${val.id}">${METLANG.delete}</button>
                <a class="btn btn-default mb-2"
                href="${that.own_name}c=language_general&a=doExportPack&site=admin&editor=${val.mark}">
                ${METLANG.language_outputlang_v6}</a>
              <button class="btn btn-default mb-2 btn-replace"
              type="button"
              data-index="${index}"
              data-toggle="modal"
              data-target=".langadmin-replace-modal"
              data-modal-url="language/replace"
              data-modal-size="lg"
              data-modal-title="${METLANG.language_batchreplace_v6}"
              data-modal-tablerefresh="#lang-admin-table">${METLANG.language_batchreplace_v6}</button>
              <button class="btn btn-default mb-2 btn-search-edit"
              type="button"
              data-index="${index}"
              data-toggle="modal"
              data-target=".langadmin-search-modal"
              data-modal-url="language/admin_search"
              data-modal-size="lg"
              data-modal-tablerefresh="#lang-admin-table"
              data-modal-title="${METLANG.langwebeditor}">${METLANG.langwebeditor}</button>
            ${
              sysMark.indexOf(val.mark) > -1
                ? `<button
            type="button"
            class="btn btn-default mb-2 btn-sync"
            data-index="${index}"
            data-toggle="modal"
            data-target=".langadmin-sync-modal"
            data-modal-url="language/sync"
            data-modal-footerok="0"
            data-modal-title="${METLANG.unitytxt_9}"
            >${METLANG.unitytxt_9}</button>`
                : ''
            }`,
                `<button class="btn btn-default btn-edit-app"
                type="button"
                data-index="${index}"
                data-toggle="modal"
                data-target=".langadmin-app-modal"
                data-modal-size="lg"
                data-modal-footerok="0"
                data-modal-title="${METLANG.edit_app_lang}"
                > ${METLANG.edit_app_lang}</button>`
              ]
              select = select + `<option value="${val.mark}">${val.name}</option>`
              newData.push(list)
            })
            that.selectHtml = select
            return newData
          }
        }
      }

      that.obj.metDataTable(function() {
        that.table = datatable['#lang-admin-table']
        if (!refresh) {
          deleteLang()
          renderAdd()
          renderEditForm()
          renderSearchForm()
          renderEditAppForm()
          renderReplaceForm()
          renderSyncForm()
        }
      })
    })
  }
  function deleteLang() {
    that.obj.find('.btn-langadmin-delete').metClickConfirmAjax({
      true_fun: function() {
        $.ajax({
          url: that.own_name + 'c=language_admin&a=doDeleteLanguage',
          type: 'POST',
          dataType: 'json',
          data: {
            id: $(this)[0].el.data('id')
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
    })
  }
  function renderAdd() {
    M.component.modal_options['.lang-adminAdd-modal'] = {
      callback: function() {
        const modal = $('.lang-adminAdd-modal')
        setTimeout(() => {
          rednerAddModal(modal)
          modal.find('.modal-loader').addClass('hide')
          modal.find('.modal-html').removeClass('hide')
          modal.scrollTop(0)
        }, 230)
      }
    }
    function rednerAddModal(modal) {
      const form = modal.find('form')
      const order = form.attr('data-validate_order')
      const btn = modal.find('[data-ok]')
      validate[order].success(function(e, form) {
        btn.attr('disabled', 'disabled')
        btn.append(`<i class="fa fa-spinner fa-spin ml-2"></i>`)
        alertify.success(METLANG.saving)
        return false
      }, false)
      formSaveCallback(order, {
        true_fun: function() {
          btn.removeAttr('disabled')
          btn.find('.fa').remove()
        },
        fasle_fun: function() {
          btn.removeAttr('disabled')
          btn.find('.fa').remove()
        }
      })

      modal.find('[name="order"]').val((that.langData ? parseInt(that.langData[that.langData.length - 1].no_order) : 0) + 1)
      modal.find('[name="file"]').html(that.selectHtml)
      modal.find('[name="autor"]').change(function(e) {
        const text = modal.find('[name="autor"] option:selected').text()
        const value = e.target.value
        modal.find('[name="mark"]').val(value)
        if (value === '') {
          modal.find('.lang-mark').show()
          modal.find('[name="mark"]').attr('data-fv-field', 'mark')
          modal.find('[name="mark"]').attr('required', '')
        } else {
          modal.find('.lang-mark').hide()
          modal.find('[name="mark"]').attr('data-fv-field', false)
          modal.find('[name="mark"]').attr('required', false)
          modal.find('[name="name"]').val(text)
        }
      })
    }
  }
  function renderEditForm() {
    $(document).on('click', '.met-lang-admin .btn-edit', function(event) {
      const index = $(this).data('index')
      that.activeData = that.langData[index]
    })
    M.component.modal_options['.lang-admin-edit'] = {
      callback: function() {
        const modal = $('.lang-admin-edit')
        setTimeout(() => {
          rednerEditModal(modal)
          modal.find('.modal-loader').addClass('hide')
          modal.find('.modal-html').removeClass('hide')
          modal.scrollTop(0)
        }, 230)
      }
    }
    function rednerEditModal(modal) {
      modal.find('[name="order"]').val(that.activeData.no_order)
      modal.find('[name="name"]').val(that.activeData.name)
      modal.find('[name="mark"]').val(that.activeData.mark)
      if (that.activeData.useok > 0) {
        modal.find('[name="useok"]').click()
      }
      if (that.activeData.newwindows > 0) {
        modal.find('[name="newwindows"]').click()
      }
      modal.find('[name="met_index_type"]').attr('name', 'met_admin_type')
      if (that.activeData.met_admin_type === that.activeData.mark) {
        modal.find('[name="met_admin_type"]').click()
      }
    }
  }
  function search(val, modal) {
    if (!val) {
      alertify.error(`${METLANG.js41}`)
      return
    }
    let params = {
      word: val,
      editor: that.activeData.mark,
      site: 'admin',
    }
    if (modal.find('[name="appno"]').val()) {
      params.appno = modal.find('[name="appno"]').val()
    }
    metui.request(
      {
        url: that.own_name + 'c=language_general&a=doSearchParameter',
        data: params
      },
      function(result) {
        metAjaxFun({
          result: result,
          true_fun: function() {
            let html
            if (result.data) {
              submitParameter(modal)
              html = result.data
                .map(item => {
                  return `<dl><dt><label class="form-control-label">{$${item.name}}</label></dt><dd>
                  <div class="form-group clearfix">
                    <input name="${item.name}" class="form-control" value="${item.value}"/>
                  </div>
                </dd>
                </dl>`
                })
                .join('')
            } else {
              html = `<h3 class="example-title">${METLANG.no_data}</h3>`
            }
            modal
              .find('.metadmin-fmbx')
              .show()
              .find('.tips')
              .html(html)
          }
        })
      }
    )
  }
  function renderSearchForm() {
    $(document).on('click', '.met-lang-admin .btn-search-edit', function(event) {
      const index = $(this).data('index')
      that.activeData = that.langData[index]
    })
    M.component.modal_options['.langadmin-search-modal'] = {
      callback: function() {
        const modal = $('.langadmin-search-modal')
        setTimeout(() => {
          renderSearchModal(modal)
        }, 230)
      }
    }
    function renderSearchModal(modal) {
      const submit = modal.find('[data-ok]')
      const btn_search = modal.find('.btn-search')
      const input = modal.find('.input')
      submit.attr('disabled', true)
      modal.find('[name="editor"]').val(that.activeData.mark)
      modal.find('[name="site"]').val('admin')
      btn_search.click(function() {
        search(modal.find('.input').val(), modal)
      })
      input.keypress(function(e) {
        let keycode = e.keyCode ? e.keyCode : e.which
        if (keycode == '13') {
          const val = modal.find('.input').val()
          search(val, modal)
        }
      })
    }
  }
  function submitParameter(modal) {
    const form = modal.find('form')
    const submit = modal.find('[data-ok]')
    submit.removeAttr('disabled')
    submit.off().click(function() {
      const formData = form.serializeArray()
      let values = {
        data: {}
      }
      formData.map(item => {
        if (item.name === 'editor' || item.name === 'site' || item.name === 'appno') {
          values[item.name] = item.value
          return
        }
        values['data'][item.name] = item.value
      })
      metui.request(
        {
          url: form.attr('action'),
          data: values
        },
        function(result) {
          metAjaxFun({
            result: result,
            true_fun: function() {
              setTimeout(() => {
                M.is_admin ? window.location.reload() : null
              }, 200)
            }
          })
        }
      )
    })
  }
  function renderEditAppForm() {
    $(document).on('click', '.met-lang-admin .btn-edit-app', function(e) {
      const btn = $(e.target)
      const index = btn.data('index')
      that.activeData = that.langData[index]
      metui.request(
        {
          url: that.own_name + 'c=language_general&a=doGetAppList',
          data: {
            site: 0,
            editor: that.activeData.mark
          }
        },
        function(result) {
          that.appData = result.data
          const html = result.data
            .map((item, index) => {
              return `<div class="card col-6" >
            <div class="card-body">
              <h5 class="card-title">${item.appname}</h5>
              <p class="card-text">${METLANG.numbering}${METLANG.marks}${item.no}</p>
              <a href="${that.own_name}c=language_general&a=doExportPack&site=admin&editor=${that.activeData.mark}&appno=${item.no}" >${METLANG.language_outputlang_v6}</a>
              <a
              href="javascript:;"
              data-index="${index}"
              data-toggle="modal"
              data-target=".langadmin-replaceApp-modal"
              data-modal-url="language/replace"
              data-modal-size="lg"
              data-modal-title="${METLANG.language_batchreplace_v6}"
              class="ml-2 btn-app-replace">${METLANG.language_batchreplace_v6}</a>
              <a
              href="javascript:;"
              data-index="${index}"
              data-toggle="modal"
              data-target=".langadmin-searchApp-modal"
              data-modal-url="language/admin_search"
              data-modal-size="lg"
              data-modal-title="${METLANG.langwebeditor}"
              class="ml-2 btn-app-search">${METLANG.langwebeditor}</a>
            </div>
          </div>`
            })
            .join('')
          $('.langadmin-app-modal .modal-body').html(html)
        }
      )
    })

    $(document).on('click', '.btn-app-search', function(e) {
      const btn = $(e.target)
      const index = btn.data('index')
      that.appActiveData = that.appData[index]
    })
    M.component.modal_options['.langadmin-searchApp-modal'] = {
      callback: function() {
        const modal = $('.langadmin-searchApp-modal')
        modal.find('[name="editor"]').val(that.activeData.mark)
        modal.find('[name="editor"]').after(`<input name="appno" hidden value="${that.appActiveData.no}"/>`)
        modal.find('[name="site"]').val('admin')
        modal
          .find('.btn-search')
          .off()
          .click(function() {
            const val = modal.find('.input').val()
            search(val,modal)
          })
        modal
        .find('.input')
        .off()
        .keypress(function(e) {
            let keycode = e.keyCode ? e.keyCode : e.which
            if (keycode == '13') {
                const val = modal.find('.input').val()
                search(val, modal)
            }
        })
      }
    }
    $(document).on('click', '.btn-app-replace', function(e) {
      const btn = $(e.target)
      const index = btn.data('index')
      that.appActiveData = that.appData[index]
    })
    M.component.modal_options['.langadmin-replaceApp-modal'] = {
      callback: function() {
        const modal = $('.langadmin-replaceApp-modal')
        modal.find('[name="editor"]').after(`<input name="appno" hidden value="${that.appActiveData.no}"/>`)
        modal.find('[name="editor"]').val(that.activeData.mark)
        modal.find('[name="site"]').val('admin')
      }
    }
  }
  function renderSyncForm() {
    $(document).on('click', '.met-lang-admin .btn-sync', function(e) {
      const btn = $(e.target)
      const index = btn.data('index')
      that.activeData = that.langData[index]
      metui.request(
        {
          url: that.own_name + 'c=language_general&a=doSynLanguage',
          data: {
            site: 'admin',
            editor: that.activeData.mark
          }
        },
        function(result) {
          metAjaxFun({
            result: result,
            true_fun: function() {
              let html = `<h4>${METLANG.successful_syn}</h4>`
              $('.langadmin-sync-modal .modal-body').html(html)
              setTimeout(() => {
                $('.langadmin-sync-modal').modal('hide')
              }, 500)
            },
            false_fun: function() {
              let html = `<h4>${METLANG.failed_syn}</h4>`
              $('.langadmin-sync-modal .modal-body').html(html)
              setTimeout(() => {
                $('.langadmin-sync-modal').modal('hide')
              }, 500)
            }
          })
        }
      )
    })
    $(document).on('shown.bs.modal', '.langadmin-sync-modal', function(e) {
      let html = `
      <div class="p-2">
      <h4>${METLANG.being_synced}</h4>
      </div>
      ${M.component.loader({ class_name: 'w-100' })}
    `
      $('.langadmin-sync-modal .modal-body').html(html)
    })
  }
  function renderReplaceForm() {
    $(document).on('click', '.met-lang-admin .btn-replace', function(e) {
      const btn = $(e.target)
      const index = btn.data('index')
      that.activeData = that.langData[index]
    })
    M.component.modal_options['.langadmin-replace-modal'] = {
      callback: function() {
        const modal = $('.langadmin-replace-modal')
        setTimeout(() => {
          modal.find('[name="editor"]').val(that.activeData.mark)
          modal.find('[name="site"]').val('admin')
          const form = modal.find('form')
          const order = form.attr('data-validate_order')
          const btn = modal.find('[data-ok]')
          validate[order].success(function(e, form) {
            btn.attr('disabled', 'disabled')
            btn.append(`<i class="fa fa-spinner fa-spin ml-2"></i>`)
            alertify.success(METLANG.saving)
            return false
          }, false)
          formSaveCallback(order, {
            true_fun: function() {
              btn.removeAttr('disabled')
              btn.find('.fa').remove()
            },
            fasle_fun: function() {
              btn.removeAttr('disabled')
              btn.find('.fa').remove()
            }
          })
        }, 230)
      }
    }
  }
})()
