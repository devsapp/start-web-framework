/* 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved. */
;(function() {
  var that = $.extend(true, {}, admin_module)
  TEMPLOADFUNS[`met_template/other`] = function() {
    const met_template_other = $.extend(true, {}, admin_module)
    renderList(met_template_other)
  }
  TEMPLOADFUNS[`met_template/ui`] = function() {
    const met_template = $.extend(true, {}, admin_module)
    getUserInfo(met_template)
    renderList(met_template)
  }
  function renderList(that) {
    const isOther = that.hash == `met_template/other`
    const list = that.obj.find('.met-template-list')
    list.html(M.component.loader({ height: '300px', class_name: 'w-100' }))
    $.ajax({
      url: that.own_name + '&c=index&a=dolist',
      type: 'POST',
      data: {
        type: isOther ? 'tag' : 'ui'
      },
      dataType: 'json',
      success: function(result) {
        const url = that.obj.find('.met-tips').data('url')

        const noTemplate = `<div class="alert alert-primary tips w-100">
        <p>还没有购买模板或购买的模板绑定域名不是：${url}（注意域名不能带http://、二级目录） </p>
        <a href="https://www.metinfo.cn/product/" target="_blank"><button class="btn btn-primary">${METLANG.met_template_buytemplates}</button></a>
          </div>`
        if (result.status && !result.data) {
          list.html(noTemplate)
          return
        }
        that.data = result.data
        let html = ''
        that.data.map(item => {
          const card = `<div class="col-6 col-xl-4 col-xxl-3" >
          <div class="media ${item.enable ? `active` : ''}" data-skin_name="${item.skin_name}">
            <img class="mr-3" src="${item.view}">
          <div class="media-body">
          <h4 class="mt-0">${item.skin_name}</h4>
          ${
            item.hasOwnProperty('enable')
              ? `<p>状态：
          <input type="checkbox"
          data-plugin="switchery"
          value=" ${item.enable ? '1' : '0'} "
          name="met_enable"
          ${item.enable ? 'checked="checked" disabled="disabled"' : ''}
          class="met_enable" />
          <span class="text-help ml-2">${item.enable ? '已启用' : '未启用'}</span>
          </p>
          `
              : ''
          }
        ${item.hasOwnProperty('enable') ? `<p class="tem-ver ${item.enable ? `active-tem` : ''}">当前版本：${item.version}</p>` : ''}
          ${item.hasOwnProperty('enable') && item.enable && item.skin_name.indexOf('ui') > -1 ? `<p class="install-data">数据：<a  href="javascript:;" class="btn-install-data">${METLANG.met_template_installdemo}</a></p>` : ''}
          </div>
          ${
            item.install
              ? `<div class="overlay">
            <button class="btn btn-primary btn-install px-4">${METLANG.appinstall}</button>
          </div>`
              : ''
          }
          ${
            item.import
              ? `<div class="overlay">
            <button class="btn btn-primary btn-import px-4">${METLANG.setdbImportData}</button>
          </div>`
              : ''
          }
          ${
            item.hasOwnProperty('enable') && !item.enable && item.skin_name.indexOf('ui') > -1
              ? `<div class="delete">
          <i class="fa fa-trash ml-2">
          <span>${METLANG.delete}</span></i>
          </div>`
              : ''
          }
        </div>
      </div>`
          html = html + card
        })
        setTimeout(() => {
          list.html(html)
          installTemplate(that)
          importTemplate(that)
          deleteTemplate(that)
          enableTemplate(that)
          !isOther && checkTemplate(that)
          installData(that)
          that.obj.metCommon()
        }, 300)
      }
    })
  }
  function deleteTemplate(that) {
    that.obj
      .find('.delete')
      .off()
      .click(function() {
        const btn = $(this)
        metui.use('alertify', function() {
          alertify
            .okBtn(METLANG.confirm)
            .cancelBtn(METLANG.cancel)
            .confirm(METLANG.met_template_delettemplatesinfo, function(ev) {
              $.ajax({
                url: that.own_name + 'c=index&a=dodelete',
                data: {
                  skin_name: btn.parents('.media').data('skin_name')
                },
                dataType: 'json',
                success: function(result) {
                  metAjaxFun({
                    result: result,
                    true_fun: function() {
                      renderList(that)
                    },
                    false_fun: function() {}
                  })
                }
              })
            })
        })
      })
  }
  function checkTemplate(that) {
    const enableList = that.data.filter(item => {
      return item.enable
    })
    if (enableList.length === 0) {
      return
    }
    $.ajax({
      url: that.own_name + 'c=index&a=docheck',
      type: 'POST',
      dataType: 'json',
      data: {
        skin_name: enableList[0].skin_name
      },
      success: function(result) {
        if (result.status) {
          that.obj.find('.active-tem').append(`<button  class="ml-2 btn-update btn btn-primary btn-xs"
          data-skin_name="${enableList[0].skin_name}"><i class="fa fa-upload mr-2"></i>${METLANG.appupgrade}</button>`)
          updateTemplate(that)
        }
      }
    })
  }
  function updateTemplate(that) {
    const active = that.obj.find('.met-template-list .active')
    that.obj.find('.btn-update').metClickConfirmAjax({
      confirm_text: '如你自行修改了模板源代码文件，且未按商业模板修改规则设置UI区块版本号，升级模板会覆盖原文件，覆盖之后无法恢复！',
      true_fun: function() {
        active.append(`<div class="overlay"><button class="btn btn-default block" style="width:85%;">${METLANG.upgrade}</button></div>`)
        $.ajax({
          url: that.own_name + 'c=index&a=doupdate',
          type: 'POST',
          dataType: 'json',
          data: {
            skin_name: $(this)[0].el.data('skin_name')
          },
          success: function(result) {
            active.find('.overlay').remove()
            metAjaxFun({
              result: result,
              true_fun: function() {
                location.reload()
              }
            })
          }
        })
      }
    })
  }
  function enableTemplate(that) {
    that.obj.find('.met_enable').on('change', function(e) {
      metui.request(
        {
          url: that.own_name + 'c=index&a=doenable',
          data: {
            skin_name: $(this)
              .parents('.media')
              .data('skin_name'),
            enable: e.target.value ? 1 : 0
          }
        },
        function(result) {
          metAjaxFun({
            result: result,
            true_fun: function() {
              renderList(that)
              $('.met-pageset').length && $('.page-iframe').attr({ 'data-reload': 1 })
            }
          })
        }
      )
    })
  }
  function installTemplate(that) {
    that.obj.find('.btn-install').click(function() {
      const btn = $(this)
      const skin_name = btn.parents('.media').data('skin_name')
      btn.html(`<i class="fa fa-circle-o-notch fa-spin"></i> ${METLANG.installing}`).css({ width: '85%', height: 'auto' })
      btn.unbind('click')
      metui.request(
        {
          url: that.own_name + '&c=index&a=doinstall',
          data: {
            skin_name: skin_name
          }
        },
        function(result) {
          metAjaxFun({
            result: result,
            true_fun: function() {
              btn.unbind('click')
              that.precent = Math.ceil(100 / result.data.length)
              that.now = 0
              that.btn = btn
              that.count = that.precent * result.data.length
              btn.css({ width: '85%', height: 'auto' })
              result.data.map((item, index) => {
                const data = {
                  url: that.own_name + '&c=index&a=dodownloadUI',
                  data: {
                    ui_name: item,
                    skin_name: skin_name
                  }
                }
                setTimeout(() => {
                  installUI(data, that)
                }, index * 100)
              })
            },
            false_fun: function() {
              installTemplate(that)
            }
          })
        }
      )
    })
  }
  function installData(that) {
    that.obj.find('.btn-install-data').click(function() {
      const modal = $('.met-install-modal')
      that.modal = modal
      const btn = $(this)
      const skin_name = btn.parents('.media').data('skin_name')
      modal.modal('show')
      const body = modal.find('.modal-body')
      modal
        .find('.btn-backup')
        .off()
        .click(function() {
          $(this)
            .html(`<i class="fa fa-spinner fa-spin mr-2"></i>${METLANG.databacking}`)
            .attr('disabled', true)
          that.precent = 0
          let params = {
            data: {
              skin_name: skin_name,
              piece: 0
            },
            body: body
          }
          renderProgress(body, { title: METLANG.databacking })
          metui.request(
            {
              url: M.url.admin + '?n=databack&c=index&a=dopackdata'
            },
            function(result) {
              continueBack(result, params)
            }
          )
        })
      modal
        .find('.btn-reset')
        .off()
        .click(function() {
          $(this)
            .html(`<i class="fa fa-spinner fa-spin mr-2"></i>${METLANG.met_template_installnewmetinfo}...`)
            .attr('disabled', true)
          that.precent = 0
          let params = {
            data: {
              skin_name: skin_name,
              piece: 0
            },
            body: body
          }
          renderProgress(body, { title: METLANG.download_prompt })
          downloadData(that, params)
        })
    })
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
      <div class="progress border">
      <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 0%">0%</div>
      </div>
      </div>
    `
      body.html(html)
    }
  }
  function continueBack(result, params) {
    if (result.status === 1) {
      that.precent = 0
      renderProgress(params.body, { title: METLANG.download_prompt })
      downloadData(that, params)
    }
    if (result.status === 2) {
      metui.request(
        {
          url: `${M.url.admin}?${result.call_back}`
        },
        function(result) {
          setTimeout(() => {
            that.precent = that.precent + Math.floor(Math.random() * 10 + 1)
            renderProgress(params.body, { precent: that.precent })
            continueBack(result, params)
          }, 800)
        }
      )
    }
  }
  function downloadData(that, params) {
    metui.request(
      {
        url: that.own_name + '&c=index&a=dodownloadData',
        data: params.data
      },
      function(result) {
        if (result.status) {
          that.precent = that.precent + Math.floor(100 / result.data.total)
          renderProgress(params.body, { precent: that.precent })
          if (params.data.piece < result.data.total - 1) {
            params.data.piece = params.data.piece + 1
            downloadData(that, params)
          } else {
            that.precent = 0
            params.data.piece = 0
            renderProgress(params.body, { title: METLANG.being_imported })
            importData(that, params)
          }
        } else {
          metui.use(['alertify'], function() {
            alertify.error(result.msg)
            setTimeout(() => {
              window.location.reload()
            }, 500)
          })
        }
      }
    )
  }
  function importData(that, params) {
    metui.request(
      {
        url: that.own_name + '&c=index&a=doimportData',
        data: params.data
      },
      function(result) {
        metAjaxFun({
          result: result,
          true_fun: function() {
            that.precent = that.precent + Math.floor(100 / result.data.total)
            renderProgress(params.body, { precent: that.precent })
            if (params.data.piece < result.data.total - 1) {
              params.data.piece = params.data.piece + 1
              importData(that, params)
            } else {
              setTimeout(() => {
                location.reload()
              }, 500)
            }
          },
          false_fun: function() {
            setTimeout(() => {
              location.reload()
            }, 500)
          }
        })
      }
    )
  }
  function importTemplate(that) {
    that.obj.find('.btn-import').click(function() {
      const btn = $(this)
      const skin_name = btn.parents('.media').data('skin_name')
      btn.html(`<i class="fa fa-circle-o-notch fa-spin"></i> ${METLANG.being_imported}`);
      btn.unbind('click')
      // return;
      metui.request(
        {
          url: that.own_name + '&c=index&a=doimport',
          data: {
            skin_name: skin_name
          }
        },
        function(result) {
          metAjaxFun({
            result: result,
            true_fun: function() {
              if (result.data) {
                that.precent = Math.ceil(100 / result.data.length)
                that.now = 0
                that.btn = btn
                that.count = that.precent * result.data.length
                btn.css({ width: '85%', height: 'auto' })
                result.data.map((item, index) => {
                  const data = {
                    url: that.own_name + '&c=index&a=dodownloadUI',
                    data: {
                      ui_name: item,
                      skin_name: skin_name
                    }
                  }
                  setTimeout(() => {
                    installUI(data, that)
                  }, index * 100)
                })
              } else {
                renderList(that)
              }
            },
            false_fun: function() {
              importTemplate(that)
            }
          })
        }
      )
    })
  }
  function installUI(data, that) {
    metui.request(data, function(result) {
      metAjaxFun({
        result: result,
        true_fun: function() {
          that.now = that.now + that.precent
          that.btn.html(
            `<div>
            <p>${result.data.ui_name}下载完成</p>
              <div class="progress border">
              <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"  style="width: ${that.now}%" />
              </div>
            </div>
            `
          )
          if (that.now === that.count) {
            renderList(that)
          }
        }
      })
    })
  }
  function getUserInfo(that) {
    const tips = that.obj.find('.met-tips')
    $.ajax({
      url: M.url.admin + '?n=myapp&c=index&a=doUserInfo',
      type: 'GET',
      dataType: 'json',
      success: function(result) {
        const url = tips.data('url')
        const noLoginTips = `<div class="alert alert-primary tips w-100">
        <p>使用米拓用户中心（u.mituo.cn）账号登录即可同步已购买模板！</p>
        <span>友情提示：此处显示的模板绑定域名必须为 ${url}</span></div>`
        const LoginTips = `<div class="alert alert-primary tips w-100">
        <p>请保持账号登录状态，以便正常获取模板升级状态并正常升级</p>
        <span>友情提示：此处显示的模板绑定域名必须为 ${url}</span></div>`
        if (result.status) {
          const user = that.obj.find('.met-template-right')
          const userHtml = `<div class="d-flex user">
            <div class="user-name">${result.data.username}</div>
            <a href="https://u.mituo.cn/#/user/login" target="_blank">${METLANG.account_Settings}</a>
            <button class="btn btn-logout btn-default">${METLANG.indexloginout}</button>
            </div>`
          user.html(userHtml)
          tips.html(LoginTips)
          that.obj.find('.btn-logout').click(function() {
            $.ajax({
              url: M.url.admin + '?n=myapp&c=index&a=doLogout',
              type: 'GET',
              dataType: 'json',
              success: function(result) {
                metAjaxFun({
                  result: result,
                  true_fun: function() {
                    window.location.reload()
                  }
                })
              }
            })
          })
        } else {
          const user = that.obj.find('.met-template-right')
          const userHtml = `<a href="#/myapp/login" onClick="setCookie('app_href_source','app/met_template/?head_tab_active=0')" class="mr-2">
          <button class="btn btn-default">
          ${METLANG.loginconfirm}
          </button>
          </a>
          <a href="https://u.mituo.cn/#/user/register" target="_blank"><button class="btn btn-primary">${METLANG.registration}</button></a>`
          user.html(userHtml)
          tips.html(noLoginTips)
        }
      }
    })
  }
})()
