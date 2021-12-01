/* 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved. */
(function() {
  var that = $.extend(true, {}, admin_module);
  metui.use("form", function() {
    setTimeout(function() {
      formSaveCallback(
        that.obj.find(".database-form").attr("data-validate_order"),
        {
          true_fun: function(result) {
            var $db_type = that.obj.find(
              '.database-form input[name="db_type"]:eq(0)'
            );
            $db_type.attr({
              "data-checked": that.obj
                .find('.database-form input[name="db_type"]:checked')
                .val()
            });
            that.obj
              .find('.database-form input[name="db_type"]:checked')
              .change();
          }
        }
      );
    }, 0);
  });
  // 数据库设置-切换
  $(document).on("change", '.database-form input[name="db_type"]', function(
    event
  ) {
    var $form = that.obj.find(".database-form"),
      checked = that.obj
        .find('.database-form input[name="db_type"]:eq(0)')
        .attr("data-checked");
    // console.log(checked);
    $(".database-form .btn-savegroup .btn").addClass("hide");
    if ($("#db_type-mysql").is(":checked") && checked != "mysql") {
      $form.find(".btn-db_type-mysql").removeClass("hide");
    } else if ($("#db_type-sqlite").is(":checked") && checked != "sqlite") {
      $form.find(".btn-db_type-sqlite").removeClass("hide");
    }
  });
  // 数据库设置-保存
  $(document).on(
    "click",
    '.database-form .btn[class*="btn-db_type-"]',
    function(event) {
      const checked = that.obj.find("#backup").is(":checked");
      const btn = $(event.target);
      const form = $(".database-form");
      if (btn.hasClass("btn-db_type-sqlite")) {
        if (checked) {
          btn
            .append(`<i class="fa fa-spinner fa-spin ml-2"></i>`)
            .attr("disabled", true);
          metui.request(
            {
              url: M.url.admin + "?n=databack&c=index&a=dopackdata"
            },
            function(result) {
              metui.use("alertify", function() {
                if (result.status !== 403) {
                  continueBack(result, btn, form);
                } else {
                  alertify.error(result.msg);
                  btn.find(".fa").remove();
                  btn.removeAttr("disabled");
                }
              });
            }
          );
        } else {
          metui.request(
            {
              url: that.own_name + "&c=index&a=doSaveDatabase",
              data: form.serialize()
            },
            function(result) {
              metAjaxFun({result:result,true_reload:1});
            }
          );
        }
      }
      event.preventDefault();
    }
  );
  // 数据库设置-弹框
  M.component.modal_call_status[".database-form-modal"] = [];
  M.component.modal_options[".database-form-modal"] = {
    modalType: "centered",
    modalSize: "lg",
    modalTitle: "数据库信息",
    modalRefresh: "one",
    modalBody: that.obj.find('textarea[name="database-info-form"]').val(),
    callback: function(key) {
      metui.use("form", function() {
        setTimeout(function() {
          var validate_order = $(key + " form").attr("data-validate_order");
          if (
            !M.component.modal_call_status[".database-form-modal"][
              validate_order
            ]
          ) {
            M.component.modal_call_status[".database-form-modal"][
              validate_order
            ] = 1;
            validate[validate_order].success(function(e, form) {
              const checked = that.obj.find("#backup").is(":checked");
              const btn = $(key).find(".btn-primary");
              btn
                .append(`<i class="fa fa-spinner fa-spin ml-2"></i>`)
                .attr("disabled", true);
              if (checked) {
                metui.request(
                  {
                    url: M.url.admin + "?n=databack&c=index&a=dopackdata"
                  },
                  function(result) {
                    metui.use("alertify", function() {
                      if (result.status !== 403) {
                        continueBack(result, btn, form);
                      } else {
                        alertify.error(result.msg);
                        btn.find(".fa").remove();
                        btn.removeAttr("disabled");
                      }
                    });
                  }
                );
              } else {
                metui.request(
                  {
                    url: that.own_name + "&c=index&a=doSaveDatabase",
                    data: form.serialize()
                  },
                  function(result) {
                    metAjaxFun({result:result,true_reload:1});
                  }
                );
              }
              return false;
            }, false);

            $(document).on(
              "click",
              key + ' .modal-footer button[data-dismiss="modal"]',
              function(event) {
                $(key + ' form button[type="reset"]').click();
              }
            );
          }
        }, 0);
      });
    }
  };

  TEMPLOADFUNS[that.hash] = function() {
    setTimeout(function() {
      var checked = that.obj
        .find('.database-form input[name="db_type"]:eq(0)')
        .attr("data-checked");
      that.obj.find('input[name="db_type"][value="' + checked + '"]').click();
    }, 100);
  };
  function continueBack(result, btn, form) {
    if (result.status === 2) {
      metui.request(
        {
          url: `${M.url.admin}?${result.call_back}`
        },
        function(result) {
          continueBack(result, btn, form);
        }
      );
    }
    if (result.status === 1) {
      btn.find(".fa").remove();
      btn.removeAttr("disabled");
      metui.request(
        {
          url: that.own_name + "&c=index&a=doSaveDatabase",
          data: form.serialize()
        },
        function(result) {
          metAjaxFun({result:result,true_reload:1});
        }
      );
    }
  }
})();
