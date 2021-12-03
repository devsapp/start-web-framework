/* 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved. */
(function() {
  var that = $.extend(true, {}, admin_module),
    obj = that.obj;
  getStaticPageSet();
  FormSubmit();
  TEMPLOADFUNS[that.hash] = function() {
    getStaticPageSet();
  };
  function getStaticPageSet() {
    $.ajax({
      url: M.url.admin + "?n=html&c=html&a=doGetSetup",
      type: "GET",
      dataType: "json",
      success: function(result) {
        let data = (that.data = result.data);
        Object.keys(data).map(item => {
          if (item === "met_webhtm") {
            $('[name="met_webhtm"]').removeAttr("checked");
            $(`#met_webhtm-${data[item]}`)
              .attr("checked", true)
              .prop({ checked: true });
            if (data[item] > 0) {
              $(".met_webhtm").removeClass("hide");
            } else {
              $(".met_webhtm").addClass("hide");
            }
            return;
          }
          if (item === "met_htmlistname") {
            $('[name="met_htmlistname"]').removeAttr("checked");
            $(`#met_htmlistname-${data[item]}`)
              .attr("checked", true)
              .prop({ checked: true });
            return;
          }

          if (item === "met_htmpagename") {
            $('[name="met_htmpagename"]').removeAttr("checked");
            $(`#met_htmpagename-${data[item]}`)
              .attr("checked", true)
              .prop({ checked: true });
            return;
          }
          if (item === "met_htmtype") {
            $('[name="met_htmtype"]').removeAttr("checked");
            $(`#met_htmtype-${data[item]}`)
              .attr("checked", true)
              .prop({ checked: true });
            return;
          }
          if (item === "met_htmway") {
            $('[name="met_htmway"]').removeAttr("checked");
            $(`#met_htmway-${data[item]}`)
              .attr("checked", true)
              .prop({ checked: true });
            return;
          }
          if (item === "met_listhtmltype") {
            $('[name="met_listhtmltype"]').removeAttr("checked");
            $(`#met_listhtmltype-${data[item]}`)
              .attr("checked", true)
              .prop({ checked: true });
            return;
          }
        });
      }
    });
  }
  function FormSubmit() {
    metui.use(["form", "formvalidation", "alertify"], function() {
      const form = that.obj.find(".static-form");
      const order = form.attr("data-validate_order");
      formSaveCallback(order, {
        true_fun: function(result) {
          const met_webhtm = form.find('[name="met_webhtm"]:checked').val();
          let value = {};
          form.serializeArray().map(item => {
            if (item.name !== "submit_type") value[item.name] = item.value;
          });
          const res = compare(value, that.data);
          const isHtmlway = res.length == 1 && res[0] === "met_htmway";
          if (met_webhtm !== "0") {
            !isHtmlway &&
              alertify
                .okBtn(METLANG.confirm)
                .cancelBtn(METLANG.cancel)
                .confirm(METLANG.seotips12, function(e) {
                  that.obj.find(".met_webhtm .btn").click();
                  setTimeout(() => {
                    $(".html-link:first").click();
                  }, 800);
                });
            $(".met_webhtm").removeClass("hide");
          } else {
            $(".met_webhtm").addClass("hide");
            if (that.data.met_webhtm === "0") {
              return;
            }
            alertify
              .okBtn(METLANG.confirm)
              .cancelBtn(METLANG.cancel)
              .confirm(METLANG.seotips11, function(e) {
                $.ajax({
                  url: M.url.admin + "?n=html&c=html&a=doDelHtml",
                  type: "GET",
                  dataType: "json"
                });
              });
          }
          getStaticPageSet();
        }
      });
    });
  }
  function getHtml(modal) {
    metui.request(
      {
        url: M.url.admin + "?n=html&c=html&a=doGetHtml"
      },
      function(result) {
        let data = result.data;
        let html = "";
        data.map((item, index) => {
          html =
            html +
            `<dl>
          <dt>
            <label class="form-control-label">${item.name}</label>
          </dt>
          <dd>
            ${
              item.content
                ? `<a data-url="${item.content.url}" tabindex=${index} class="html-link" data-name="${item.name}">${item.content.name}</a>`
                : ""
            }
            ${
              item.column
                ? `<a data-url="${item.column.url}" tabindex=${index} class="html-link" data-name="${item.name}">${item.column.name}</a>`
                : ""
            }
          </dd>
        </dl>`;
        });
        that.modalHtml = html;
        modal.find(".met-html").append(that.modalHtml);
        createHtml(modal);
      }
    );
  }
  M.component.modal_options[".html-modal"] = {
    callback: function() {
      const modal = $(".html-modal");
      getHtml(modal);
    }
  };
  function createHtml(modal) {
    modal.find(".html-link").click(function() {
      const name = $(this).text();
      const title = $(this).data("name");
      const html_loading = modal.find(".html-loading");
      const html_loading_h = html_loading.height();
      html_loading.html(
        `<p style="font-size:16px;" class="createing">${name}${METLANG.ing}...</p><div class="html-list"></div>`
      );
      const url = $(this).data("url");
      const html_list = html_loading.find('.html-list');
      metui.request(
        {
          url: url
        },
        function(result) {
          const len = result.data.length;
          var createHtmlCallback=function(val,res){
            let order = html_list.find('p').length + 1,
              p =`<p><span style="color:green">(${order}/${len})</span> ${res.suc > 0 ? val.suc:val.fail}</p>`;
            html_list.append(p);
            if (order === len) {
              $(".createing").text(`${title}${METLANG.static_page_success}`);
            }
            var scrolltop=html_list.height()-html_loading_h+40;
            scrolltop && html_loading.scrollTop(scrolltop);
          };
          result.data.map((val, index) => {
            metui.request(
              {
                url: val.url
              },
              function(res) {
                createHtmlCallback(val,res);
              }
            ).fail(function(asdas) {
              createHtmlCallback(val,{suc:0});
            });
          });
        }
      );
    });
  }
  function compare(obj1, obj2) {
    let arr = [];
    for (let key in obj1) {
      if (obj2[key] !== obj1[key]) {
        arr.push(key);
      }
    }
    return arr;
  }
})();
