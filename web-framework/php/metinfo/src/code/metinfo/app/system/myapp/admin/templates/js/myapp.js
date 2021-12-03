/* 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved. */
;(function() {
  var that = $.extend(true, {}, admin_module)
  TEMPLOADFUNS[that.hash] = function() {
    renderList(that)
    getUserInfo(that)
  }
  function renderList(that) {
    const loginTips = `<div class="tips">
    <h3>${METLANG.please_login}</h3>
    <div class="mt-2"><a href="#/myapp/login" onClick="setCookie('app_href_source','myapp/?head_tab_active=0')" class="btn btn-primary">${METLANG.loginconfirm}</a></div>
    </div>`
    const list = $('.met-myapp-list')
    const detail = that.obj.find('.app-detail')
    that.obj.find('.tab-pane').removeClass('p-4')
    list.html(M.component.loader({ height: '300px', class_name: 'w-100' }))
    $.ajax({
      url: that.own_name + '&c=index&a=doindex',
      type: 'GET',
      dataType: 'json',
      success: function(result) {
        if (!result.data) {
          list.html(loginTips)
          return
        }
        let data = result.data
        let html = ''
        data.map(item => {
          const card = `<div class="col col-6 col-xl-4 col-xxl-3 mb-3 px-2" >
            <div class="media bg-white h-100 flex-column transition500 ${item.url ? 'install' : ''}" data-no="${item.no}" data-m_name="${item.m_name}" data-new_ver="${item.new_ver ? item.new_ver : ''}">
              <div class="body media-body w-100">
                <a href="${item.url ? item.url : 'javascript:;'}" ${parseInt(item.target) ? 'target="_blank"' : ''} class="link w-100 d-flex"  title="${METLANG.fliptext1}" data-newapp="${item.newapp ? item.newapp : ''}">
                <img class="mr-3" width="70" height="70" src="${item.icon}">
                  <div class="media-body cover">
                    <h5 class="h6 mt-1">
                      <span class='mr-2'>${item.appname}</span>${item.ver?`<span class='text-grey font-size-14 version'>v${item.ver}</span>`:''}
                    </h5>
                    <div class="card-text text-truncate">${item.info}</div>
                    ${item.install?'':`<div class="card-text">运行环境：PHP ${item.php_version} 及以上版本</div>`}
                  </div>
                </a>
              </div>
              <ul class="actions w-100 d-flex ${!item.install&&!item.enabled?'bg-grey':''}">
              ${
                !item.install
                  ? `<li class="${item.enabled?'btn-install':'text-help'}">${item.enabled?`<a href="javascript:;" class='d-block'><i class="fa fa-cloud-download"></i>`:''}<span class="${item.enabled?`ml-2`:'font-size-12'}">${item.enabled?METLANG.appinstall:item.btn_text}</span>${item.enabled?'</a>':''}</li>`
                  : `
                  ${item.new_ver ? `<li><a href="javascript:;" class='d-block update'><i class="fa fa-arrow-up"></i><span class="ml-2">${METLANG.appupgrade}</span></a></li>` : ``}
                  ${item.system ? `<li class="text-black-50">${METLANG.system_plugin_uninstall}</li>` : `<li class="uninstall"><a href="javascript:;" class="text-black-50 d-block"><i class="fa fa-trash"></i><span class="ml-2">${METLANG.dlapptips6}</span></a></li>`}
                `
              }
              </ul>
            </div>
          </div>`
          html+=card;
        })
        list.html(html)
        list.show()
        detail.hide()
        list.off().on('click','.link:not([target])',function() {
          const url = $(this).attr('href')
          const new_app = $(this).data('newapp')
          if (url && url !== 'javascript:;') {
            if (new_app) {
              M.is_admin?(window.location.href =url):$('.btn-pageset-common-page').attr({'data-url':url.replace(M.url.admin.replace(M.weburl,'../')+'#/',''),title:$('h5',this).text()}).trigger('clicks');
            } else {
              detail.html(`<iframe src="${url}" ></iframe>`)
            }
            list.hide()
            detail.show()
          } else {
            metui.use(['alertify'], function() {
              alertify.error(METLANG.install_first)
            })
          }
          return false
        })
        installApp(that)
        deleteApp(that)
        updateApp(that)
      }
    })
  }
  function installApp(that) {
    that.obj.find('.btn-install').click(function() {
      $(this)
        .html(`<i class="fa fa-circle-o-notch fa-spin"></i> ${METLANG.updateinstallnow}`)
        .attr('disabled', true)

      $.ajax({
        url: that.own_name + '&c=index&a=doAction',
        type: 'POST',
        dataType: 'json',
        data: {
          m_name: $(this)
            .parents('.media')
            .data('m_name'),
          no: $(this)
            .parents('.media')
            .data('no'),
          handle: 'install'
        },
        success: function(result) {
          metAjaxFun({
            result: result,
            true_fun: function() {
              renderList(that)
            },
            false_fun: function() {
              renderList(that)
            }
          })
        }
      })
    })
  }
  function updateApp(that) {
    that.obj.find('.update').click(function() {
      $(this).parents('.media').append(`<div class="overlay">
      <div class="text-white">${METLANG.upgrade}</div>
    </div>`)
      $.ajax({
        url: that.own_name + '&c=index&a=doAction',
        type: 'POST',
        dataType: 'json',
        data: {
          m_name: $(this)
            .parents('.media')
            .data('m_name'),
          no: $(this)
            .parents('.media')
            .data('no'),
          handle: 'install'
        },
        success: function(result) {
          metAjaxFun({
            result: result,
            true_fun: function() {
              renderList(that)
            },
            false_fun: function() {
              renderList(that)
            }
          })
        }
      })
    })
  }
  function deleteApp(that) {
    that.obj.find('.uninstall').click(function() {
      const btn = $(this)
      metui.use('alertify', function() {
        alertify
          .okBtn(METLANG.confirm)
          .cancelBtn(METLANG.cancel)
          .confirm(METLANG.delete_information, function(ev) {
            $.ajax({
              url: that.own_name + 'c=index&a=doAction',
              data: {
                no: btn.parents('.media').data('no'),
                handle: 'uninstall'
              },
              dataType: 'json',
              success: function(result) {
                metAjaxFun({
                  result: result,
                  true_fun: function() {
                    renderList(that)
                  },
                  false_fun: function() {
                    renderList(that)
                  }
                })
              },
              error: function(result) {
                renderList(that)
              }
            })
          })
      })
    })
  }
  function getUserInfo(that) {
    $.ajax({
      url: that.own_name + '&c=index&a=doUserInfo',
      type: 'GET',
      dataType: 'json',
      success: function(result) {
        if (result.status) {
          const user = $('.met-myapp-right')
          const userHtml = `<div class="d-flex user">
            <div class="user-name">${result.data.username}</div>
            <a href="https://u.mituo.cn/#/user/login" target="_blank">${METLANG.account_Settings}</a>
            <button class="btn btn-logout btn-default">${METLANG.indexloginout}</button>
            </div>`
          user.html(userHtml)
          that.obj.find('.btn-logout').click(function() {
            $.ajax({
              url: that.own_name + '&c=index&a=doLogout',
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
          const user = that.obj.find('.met-myapp-right')
          const userHtml = `<a href="#/myapp/login" onClick="setCookie('app_href_source','myapp/?head_tab_active=0')" class="mr-2">
          <button class="btn btn-default" >
          ${METLANG.loginconfirm}
          </button>
          </a>
          <a href="https://u.mituo.cn/#/user/register" target="_blank"><button class="btn btn-primary">${METLANG.registration}</button></a>`
          user.html(userHtml)
        }
      }
    })
  }
})()
