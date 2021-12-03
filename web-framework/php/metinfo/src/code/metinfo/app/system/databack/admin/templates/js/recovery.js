/* 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved. */
;(function() {
  var that = $.extend(true, {}, admin_module)
  renderTable()
  unzipData()
  importData()
  deleteData()

  function renderTable() {
    M.component.commonList(function(thats, table_order) {
      return {
        ajax: {
          dataSrc: function(result) {
            if (result.status === 403) {
              return []
            }
            that.data = result
            let newData = []
            that.data &&
              $.each(that.data, function(index, val) {
                let list = [
                  index,
                  `<a style="width:350px;overflow:hidden;white-space: nowrap;text-overflow: ellipsis;display:block;" title="${val.filename}">${val.filename}</a>`,
                  val.typename,
                  val.ver,
                  `${val.filesize}MB`,
                  val.maketime,
                  val.number,
                  `
                ${val.unzip_url ? `<button class="btn btn-primary ml-2 btn-unzip" data-api="${val.unzip_url}">${METLANG.webupate7}</a>` : ''}
                ${
                  val.import_url
                    ? `<button class="btn btn-primary ml-2 btn-import"
                data-index="${index}"
                >${METLANG.setdbImportData}</button>`
                    : val.error_info||''
                }
                <button class="btn ml-2 btn-recovery-delete" data-index="${index}">${METLANG.delete}</button>
                <a class="btn btn-default ml-2" href="${val.download_url}">${METLANG.databackup3}</a>
                `
                ]

                newData.push(list)
              })

            return newData
          }
        }
      }
    })
    that.obj.find('#recovery-table').on('init.dt', function(event) {
      that.table = datatable['#recovery-table']
    })
  }
  function unzipData() {
    that.obj.find('.btn-unzip').metClickConfirmAjax({
      confirm_text: METLANG.unzip_tips,
      true_fun: function() {
        const api = $(this)[0].el.data('api')
        metui.request(
          {
            url: api
          },
          function(result) {
            metAjaxFun({
              result: result,
              true_fun: function() {
                that.table.ajax.reload()
              }
            })
          }
        )
      }
    })
  }
  function addPrecent(precent, modal) {
    if (precent < 90) {
      precent = precent + 1
      modal
        .find('.progress-bar')
        .text(precent + '%')
        .css('width', `${precent}%`)
      that.timer = setTimeout(() => {
        addPrecent(precent, modal)
      }, 800)
    }
  }
  function importData() {
    $(document).on('click', '#recovery-table .btn-import', function(e) {
      const btn = $(e.target)
      that.import_url = that.data[btn.data('index')].import_url
      metui.request(
        {
          url: that.import_url
        },
        function(result) {
          metAjaxFun({
            result: result,
            true_fun: function() {
              that.import1 = result.import_1
              that.import2 = result.import_2
              let modal = $('.import-modal')
              if (modal.length === 0) {
                $('body').append(
                  M.component.modalFun({
                    modalTitle: METLANG.setdbImportData,
                    modal_class: '.import-modal',
                    modalUrl: 'databack/import',
                    modalOktext: METLANG.confirm,
                    modalFooterok: 0
                  })
                )
                modal = $('.import-modal')
                modal.modal()
              } else {
                modal.modal()
              }
            },
            false_fun: function() {}
          })
        }
      )
    })
    M.component.modal_options['.import-modal'] = {
      callback: function() {
        const modal = $('.import-modal')
        setTimeout(() => {
          renderImportModal(modal)
        }, 230)
      }
    }
    function renderImportModal(modal) {
      let precent = 0
      let html =
        `
      <div class="p-2">
      <h4>` +
        METLANG.being_imported +
        `</h4>
      <div class="progress">
      <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 0%"></div>
      </div>
      </div>
    `
      modal.find('.import1').click(function() {
        metui.request(
          {
            url: that.import1
          },
          function(result) {
            continueBack(result)
          }
        )
        modal.find('.met-import').html(html)
        addPrecent(precent, modal)
      })
      modal.find('.import2').click(function() {
        metui.request(
          {
            url: that.import2
          },
          function(result) {
            continueBack(result)
          }
        )
        modal.find('.met-import').html(html)
        addPrecent(precent, modal)
      })
    }
  }
  function continueBack(result) {
    if (result.status === 2) {
      metui.request(
        {
            url: `${result.call_url}`
        },
        function(result) {
          continueBack(result)
        }
      )
    }
    if (result.status === 1) {
      window.location.reload()
    }
  }
  function deleteData() {
    that.obj.find('.btn-recovery-delete').metClickConfirmAjax({
      true_fun: function() {
        const index = $(this)[0].el.data('index')
        metui.request(
          {
            url: that.data[index].del_url
          },
          function(result) {
            metAjaxFun({
              result: result,
              true_fun: function() {
                that.table.ajax.reload()
              }
            })
          }
        )
      }
    })
  }
  window.recoveryFileFun = function(obj) {
    TEMPLOADFUNS[that.hash]()
  }
})()
