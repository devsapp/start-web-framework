/* 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved. */
(function () {
  var that = $.extend(true, {}, admin_module);
  TEMPLOADFUNS[that.hash] = function () {
    init();
    getUserInfo();
  };
  function init() {
    const row = that.obj.find(".met-myapp-list");
    that.obj.find(".tab-pane").removeClass("p-4");
    row.html(M.component.loader({ height: "300px", class_name: "w-100" }));
    $.ajax({
      url: that.own_name + "&c=index&a=doAppList&type=business",
      type: "GET",
      dataType: "json",
      success: function (result) {
        let data = (that.data = result.data);
        renderList(data);
        installApp();
        search();
      },
    });
  }
  function renderList(data) {
    const row = that.obj.find(".met-myapp-list");
    let html = "";
    data.length > 0
      ? data.map((item) => {
          const card = `<div class="col col-6 col-xl-4 col-xxl-3 mb-3 px-2" >
            <div class="media bg-white h-100  flex-column transition500" data-no="${item.product_code}" data-m_name="${item.m_name}">
              <div class="body media-body w-100">
                <a href="${item.show_url}" class="link w-100 d-flex"  title="${METLANG.fliptext1}" target="_blank">
                  <img class="mr-3" width="70" height="70" src="${item.product_image}">
                  <div class="media-body cover">
                    <h5 class="h6 mt-1">
                      ${item.product_name}
                    </h5>
                    <div class="card-text text-truncate">${item.product_desc}</div>
                    <div class="card-text">运行环境：PHP ${item.php_version} 及以上版本</div>
                  </div>
                </a>
              </div>
              <ul class="actions w-100 d-flex ${item.enabled?'':'bg-grey'}">
                <li class="${item.enabled?'btn-install':'text-help'}">${item.enabled?`<a href="javascript:;" class='d-block'><i class="fa fa-cloud-download"></i>`:''}<span class="${item.enabled?`ml-2`:'font-size-12'}">${item.btn_text}</span>${item.enabled?'</a>':''}</li>
              </ul>
            </div>
          </div>`;
          html+=card;
        })
      : (html = `<div class="text-center w-100">${METLANG.no_data}</div>`);

    row.html(html);
  }
  function installApp() {
    const btn_install = that.obj.find(".btn-install");
    btn_install.off().click(function () {
      const btn = $(this);
      const beforeHTML = btn.html();
      btn
        .html(
          `<i class="fa fa-circle-o-notch fa-spin"></i> ${METLANG.updateinstallnow}`
        )
        .attr("disabled", true);
      $.ajax({
        url: that.own_name + "&c=index&a=doAction",
        type: "POST",
        dataType: "json",
        data: {
          m_name: btn.parents(".media").data("m_name"),
          no: btn.parents(".media").data("no"),
          handle: "install",
        },
        success: function (result) {
          var msg = "",
            is_mituo_login = that.obj.find(".met-myapp-right .user-name").length;
          if (!result.status && result.msg && is_mituo_login) {
            msg = result.msg;
            result.msg = "";
          }
          metAjaxFun({
            result: result,
            true_fun: function () {
              if (M.is_admin) {
                window.location.href = M.url.admin + "#/myapp/?head_tab_active=0";
                return;
              } else
                $(
                  '.pageset-nav-modal .nav-modal-item[data-path="myapp"] .met-headtab a[data-url="myapp/myapp"]'
                ).click();
            },
            false_fun: function () {
              btn.html(beforeHTML).attr("disabled", false);
              if (is_mituo_login) {
                var btn_id = "dismiss-" + new Date().getTime(),
                  url = btn.parents(".media").find(".link").attr("href");
                $("body").append(`
                  <div class="modal fade show met-modal alert p-0" data-keyboard="false" data-backdrop="false" style="display: block;">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-body text-center h6 mb-0"><p class="text-danger">${msg}</p>是否前往购买页面？</div>
                        <div class="modal-footer justify-content-center">
                          <button type="button" data-dismiss="alert" id="${btn_id}" class="btn btn-default mr-5">${METLANG.cancel}</button>
                          <a href="${url}" target="_blank" onClick="$('#${btn_id}').click();" class="btn btn-primary">${METLANG.sys_purchase}</a>
                        </div>
                      </div>
                    </div>
                  </div>
                  `);
              }
            },
          });
        },
      });
    });
  }
  function search() {
    const btn_search = that.obj.find(".input-group-text");
    const input = that.obj.find(".form-control");
    btn_search.off().click(function () {
      const value = input.val();
      const newData = that.data.filter((item) => {
        return item.product_name.indexOf(value) > -1;
      });
      renderList(newData);
    });
    input.off().keypress(function (e) {
      let keycode = e.keyCode ? e.keyCode : e.which;
      if (keycode == "13") {
        const value = input.val();
        const newData = that.data.filter((item) => {
          return item.product_name.indexOf(value) > -1;
        });
        renderList(newData);
      }
    });
  }
  function getUserInfo() {
    $.ajax({
      url: that.own_name + "&c=index&a=doUserInfo",
      type: "GET",
      dataType: "json",
      success: function (result) {
        if (result.status) {
          const user = $(".met-myapp-right");
          const userHtml = `<div class="d-flex user">
            <div class="user-name">${result.data.username}</div>
            <a href="https://u.mituo.cn/#/user/login" target="_blank">${METLANG.account_Settings}</a>
            <button class="btn btn-logout">${METLANG.indexloginout}</button>
            </div>`;
          user.html(userHtml);
          that.obj.find(".btn-logout").click(function () {
            $.ajax({
              url: that.own_name + "&c=index&a=doLogout",
              type: "GET",
              dataType: "json",
              success: function (result) {
                metAjaxFun({
                  result: result,
                  true_fun: function () {
                    getUserInfo(that);
                  },
                });
              },
            });
          });
        } else {
          const user = that.obj.find(".met-myapp-right");
          const userHtml = `<a href="#/myapp/login" onClick="setCookie('app_href_source','myapp/?head_tab_active=2')" class="mr-2">
          <button class="btn btn-default" >
          ${METLANG.loginconfirm}
          </button>
          </a>
          <a href="https://u.mituo.cn/#/user/register" target="_blank"><button class="btn btn-primary">${METLANG.registration}</button></a>`;
          user.html(userHtml);
        }
      },
    });
  }
})();
