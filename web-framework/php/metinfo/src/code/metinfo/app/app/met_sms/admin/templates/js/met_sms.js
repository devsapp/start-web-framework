/* 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved. */
;(function() {
  var that = $.extend(true, {}, admin_module)

  getUserInfo(that)
  TEMPLOADFUNS[`app/met_sms/mass`] = function() {
    const that = $.extend(true, {}, admin_module)
    getUserInfo(that)
  }
  TEMPLOADFUNS[`app/met_sms`] = function() {
    const that = $.extend(true, {}, admin_module)
    getUserInfo(that)
  }
  TEMPLOADFUNS[`app/met_sms/log`] = function() {
    const that = $.extend(true, {}, admin_module)
    getUserInfo(that)
  }
  function renderPage(that) {
    const tips = $('.met-tips')
    const container = $('.met_sms-container')
    container.removeClass('hide')
    const hash = that.hash
    tips.html(``)

    if (hash.indexOf('mass') > -1) {
      $.ajax({
        url: that.own_name + '&c=index&a=domass',
        type: 'GET',
        dataType: 'json',
        success: function(result) {
          metui.use(['alertify'], function() {
            if (result.status) {
              tips.html(`<div class="alert alert-primary tips w-100">${result.data.sms.tips}</div>`)
              that.obj.find('.avalible').text(`${result.data.sms.avalible} 条`)
              that.obj.find('.first_word').text(`${result.data.word-result.data.count}`)
              that.obj.find('.word').text(`${result.data.word-result.data.count}`)
              that.obj.find('.current').text(`${result.data.current}`)
              that.obj.find('.signature').text(`${result.data.sms.signature}`)
              that.obj.find('[name="sms_content"]').val(result.data.sms.test_content)
              that.obj
                .find('[name="sms_content"]')
                .off()
                .on('input propertychange', function() {
                  count_str($(this), result.data)
                })
              that.obj
                .find('[name="sms_phone"]')
                .off()
                .on('input propertychange', function() {
                  const content = $(this).val()
                  const phones = content.split('\n')
                  $('.phone_count').text(phones.length)
                  if (phones.length > 800) {
                    alertify.error('号码不能超过800个')
                    const con = phones.slice(0, 800)
                    $(this).val(con.join('\n'))
                    $('.phone_count').text(con.length)
                  }
                })
            }
          })
        }
      })
      return
    }
    if (hash.indexOf('log') > -1) {
      metui.use(['table', 'alertify'], function() {
        const table = that.obj.find(`#sms-table`)
        table.attr({ 'data-table-ajaxurl': table.data('ajaxurl') })
        datatable_option[`#sms-table`] = {
          ajax: {
            dataSrc: function(result) {
              that.data = result.data
              let newData = []
              that.data &&
                that.data.map((val, index) => {
                  let list = [`${val.time}`, `${val.type}`, `${val.content}`, `${val.number}`, `${val.result}`]
                  newData.push(list)
                })
              return newData
            }
          }
        }

        that.obj.metDataTable(function() {
          that.table = datatable[`#sms-table`]
        })
      })
      return
    }
  }

  function count_str(e, data) {
    
    const content = e.val()
    const len = content.length
    const count = Math.ceil((len+data.count) / data.word)
    if (len > 500) {
      alertify.error('短信内容不能超过500')
      const newStr = content.substr(0, 500)
      e.val(newStr)
    }
    $('.current').text(len)
    $('.str_count').text(count)
    if(count <= 1)
    {
      $('.word').text(data.word-data.count)
    }else{
      $('.word').text(data.word)
    }
  }

  function getUserInfo(that) {
    const tips = $('.met-tips')
    $.ajax({
      url: M.url.admin + '?n=myapp&c=index&a=doUserInfo',
      type: 'GET',
      dataType: 'json',
      success: function(result) {
        if (result.status) {
          const user = $('.met_sms-right')
          const userHtml = `<div class="flex user">
            <div class="user-name">${result.data.username}</div>
            <a href="https://u.mituo.cn/#/user/login" target="_blank">用户中心</a>
            <button class="btn btn-logout btn-default">退出</button>
            </div>`
          user.html(userHtml)
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
          renderPage(that)
          return
        }
        const url = $('.met-tips').data('url')
        const noLoginTips = `<div class="alert alert-primary tips w-100">
        <p>使用米拓用户中心（u.mituo.cn）账号登录即可同步已购买的短信！</p>
        <span>友情提示：此处显示的短信绑定域名必须为 ${url}</span></div>`
        const user = that.obj.find('.met_sms-right')
        const userHtml = `<a href="#/myapp/login" onClick="setCookie('app_href_source','${that.hash}')" class="mr-2">
          <button class="btn btn-default" >
          ${METLANG.loginconfirm}
          </button>
          </a>
          <a href="https://u.mituo.cn/#/user/register" target="_blank"><button class="btn btn-primary">${METLANG.registration}</button></a>`
        user.html(userHtml)
        tips.html(noLoginTips)
      }
    })
  }
})()
