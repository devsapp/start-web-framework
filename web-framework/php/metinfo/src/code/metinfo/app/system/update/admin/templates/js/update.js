/* 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved. */
;(function() {
  var that = $.extend(true, {}, admin_module)
  getSystemInfo()
  renderPage()
  TEMPLOADFUNS[that.hash] = function() {
    renderPage()
    getSystemInfo()
  }
  function getSystemInfo() {
    $.ajax({
      url: that.own_name + 'c=about&a=doInfo',
      type: 'GET',
      dataType: 'json',
      success: function(result) {
        if (!result.data) return
        const data = result.data
        Object.keys(data).map(item => {
          if (item === 'log_url') {
            $(`.${item}`).attr('href', data[item])
            return
          }
          if (item === 'template_type') {
            if(data[item]=='ui'){
              $(`.update-met_template`).removeClass('hide');
            }
            return
          }
          $(`.${item}`)
            .children()
            .text(data[item])
        })
      }
    })
  }
  function renderPage() {
    $.ajax({
      url: that.own_name + 'c=about&a=doCheckUpdate',
      type: 'GET',
      dataType: 'json',
      success: function(result) {
        metAjaxFun({
          result: result,
          true_fun: function() {
            checkUpdate(result)
          },
          false_fun: function() {
            const div = that.obj.find('.update')
            let html = `${METLANG.latest_version}`
            div.children().html(html)
          }
        })
      }
    })
  }
  function checkUpdate(result) {
    const div = that.obj.find('.update')
    const version = (that.version = result.data.version)
    const install = (that.install = result.data.install)
    if (result.data) {
      let html = `${install ? METLANG.already_update_package : METLANG.be_updated + version}
      <button class="btn btn-update btn-primary ml-2" >${install ? METLANG.appinstall : METLANG.langexplain5}</button>`
      div.children().html(html)
      let btn = $('.btn-update')
      let modalHTML = ''
      $.ajax({
        url: that.own_name + 'c=about&a=doDownloadWarning',
        data: {
          type: install ? 'install' : 'update'
        },
        type: 'POST',
        dataType: 'json',
        success: function(result) {
          modalHTML = result.data
          btn.off().click(function() {
            let modal = $('.update-warning-modal')
            if (modal.length === 0) {
              $('body').append(
                M.component.modalFun({
                  modalTitle: METLANG.metinfoappinstallinfo4,
                  modalSize:'lg',
                  modalFullheight:1,
                  modal_class: '.update-warning-modal',
                  modalBody: `<div class="update-warning-modal-body font-weight-bold" style="color:red;">${modalHTML}</div>`,
                  modalNotext:'',
                  modalOktext:install?METLANG.appinstall:METLANG.databackup3,
                  modalFooterclass:'text-right',
                  modalFooter: `<div class='text-danger tips'>请先仔细阅读安装提示，<span class="tips-scroll">将滚动条滚至底部，</span><span class="tips-other">并等待<span class="update-warning-modal-countdown"></span>秒后</span>方可点击${METLANG.databackup3}、${METLANG.databackup4}或${METLANG.appinstall}</div><button type="button" class="btn btn-default mr-2" data-dismiss="modal">${METLANG.cancel}</button>
                  ${install ? `<button type="button" class="btn btn-primary mr-2 btn-backup">${METLANG.databackup4}</button>` : ''}`,
                })
              )
              modal = $('.update-warning-modal')
              modal.modal()
              var body_h=modal.find('.modal-body').height(),
                content_h=$('.update-warning-modal-body').height();
              modal.find('.modal-body').scroll(function(){
                if($(this).scrollTop()+body_h>=content_h){
                  !parseInt(modal.find('.modal-footer .update-warning-modal-countdown').html()) && modal.find('.modal-footer [data-ok],.btn-backup').removeAttr('disabled');
                }
              })
            } else {
              modal.modal()
            }
            const btn_ok = modal.find('[data-ok]')
            const btn_backup = modal.find('.btn-backup')
            btn_ok.off().on('click', function(event) {
              btn_ok.attr('disabled', true)
              if (install) {
                installSystem(modal)
                return
              }
              that.piece = 0
              that.precent = 0
              let body = modal.find('.modal-body')
              modal.find('.modal-footer').addClass('hide')
              renderProgress(body, { title: '下载中，请不要操作。' })
              downloadUpdate(modal)
            })
            btn_backup.off().on('click', function(event) {
              btn_ok.attr('disabled', true)
              btn_backup.attr('disabled', true)
              backup(modal)
            })
          })
        }
      })
      return
    }
    setTimeout(() => {
      let html = `${result.msg}`
      div.children().html(html)
    }, 500)
  }
  function downloadUpdate(modal) {
    const body = modal.find('.modal-body')
    $.ajax({
      url: that.own_name + 'c=about&a=doDownloadUpdate',
      type: 'POST',
      data: {
        version: that.version,
        piece: that.piece
      },
      dataType: 'json',
      success: function(result) {
        metAjaxFun({
          result: result,
          true_fun: function() {
            that.precent = that.precent + Math.floor(100 / result.data.total)
            renderProgress(body, { precent: that.precent })
            if (that.piece < result.data.total - 1) {
              that.piece++
              downloadUpdate(modal)
            } else {
              setTimeout(() => {
                modal.remove()
                renderPage()
              }, 300)
            }
          },
          false_fun: function() {
            setTimeout(() => {
              modal.remove()
            }, 300)
          }
        })
      }
    })
  }
  function installSystem(modal) {
    const body = modal.find('.modal-body')
    let html = `
    <div class="p-2">
    <h4>${METLANG.installing}</h4>
    </div>
    ${M.component.loader({ class_name: 'w-100' })}
  `
    body.html(html)
    $.ajax({
      url: that.own_name + 'c=about&a=doInstall',
      type: 'POST',
      dataType: 'json',
      data: {
        version: that.version
      },
      success: function(result) {
        metAjaxFun({
          result: result,
          true_fun: function() {
            setTimeout(() => {
              window.location.href=M.url.admin+`?lang=${M.lang}&n=ui_set`;
            }, 500)
          },
          false_fun: function() {
            setTimeout(() => {
              window.location.reload()
            }, 500)
          }
        })
      }
    })
  }
  function backup(modal) {
    const body = modal.find('.modal-body')
    let html = `
    <div class="p-2">
    <h4>${METLANG.databacking}</h4>
    </div>
    ${M.component.loader({ class_name: 'w-100' })}
  `
    body.html(html)
    metui.request(
      {
        url: M.url.admin + '?n=databack&c=index&a=dopackdata'
      },
      function(result) {
        continueBack(result, modal)
      }
    )
  }
  function continueBack(result, modal) {
    if (result.status === 1) {
      metAjaxFun({result:result,true_fun:function(){
        modal.find('.modal-body').html(`<div class="p-2">
        <h4>请继续点击【确定】按钮安装</h4>
        </div>`);
        modal.find('.modal-footer .btn').removeAttr('disabled');
      }})
    }
    if (result.status === 2) {
      metui.request(
        {
          url: `${M.url.admin}?${result.call_back}`
        },
        function(result) {
          continueBack(result, modal)
        }
      )
    }
  }
  function renderProgress(body, params) {
    if (params.precent) {
      body
        .find('.progress-bar')
        .text(params.precent + '%')
        .css('width', `${params.precent}%`)
    } else {
      let html = `
      <div class="p-2">
      <h4>${params.title}</h4>
      <div class="progress">
      <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 0%">0%</div>
      </div>
      </div>
    `
      body.html(html)
    }
  }
  M.component.modal_options['.update-warning-modal']={
		callback:function(key){
      var $tips_scroll=$(key+' .modal-footer .tips-scroll'),
        $tips_other=$(key+' .modal-footer .tips-other'),
        $countdown=$(key+' .modal-footer .update-warning-modal-countdown'),
        $ok=$(key+' .modal-footer').find('[data-ok],.btn-backup'),
        countdown=15,
        interval=setInterval(() => {
          countdown--;
          $countdown.html(countdown);
          if(countdown==0){
            $tips_other.hide();
            if($(key+' .modal-body').scrollTop()+$(key+' .modal-body').height()>=$('.update-warning-modal-body').height()) $ok.removeAttr('disabled');
            clearInterval(interval);
          }
        }, 1000);
      if($(key+' .modal-body').height()>=$('.update-warning-modal-body').height()) $tips_scroll.addClass('hide');
      $tips_other.show();
      $countdown.html(countdown);
      $ok.attr({disabled:''});
    }
  }
})()
