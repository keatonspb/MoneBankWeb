/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

require('./components/jquery.form.min.js')
require('./components/datepicker/js/bootstrap-datepicker.js')
require('./components/datepicker/locales/bootstrap-datepicker.ru.min')

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */




$(document).ready(function () {
    $('.input-daterange').datepicker({
        language: "ru",
        orientation: "auto left",
        autoclose: true,
        todayBtn: true
    });


    //Добавление затрат
    $(".add_bill").click(function () {
        if ($(this).data("role") == 'expense') {
            $(".add-bill-dialog .modal-title,.add-bill-dialog .btn-primary").html("Потратить");
            $(".add-bill-dialog .credit_checkbox").show();
        } else {
            $(".add-bill-dialog .modal-title,.add-bill-dialog .btn-primary").html("Пополнить");
            $(".add-bill-dialog .credit_checkbox").hide();
        }
        $(".add-bill-dialog input.bill_type").val($(this).data("role"));
        $(".parent_reason_select option").hide();
        $(".parent_reason_select option." + $(this).data("role")).show();
        $(".parent_reason_select option." + $(this).data("role") + ":first").prop("selected", true);
        $(".add-bill-dialog").modal();
    });
    $(".parent_reason_select").change(function () {
        var sub_select = $(this).siblings("select.sub_reason").first();
        if (sub_select.length) {
            sub_select.html("");
            $.getJSON("/api/reasons", {type: $(this).data("type"), parent_id: $(this).val()}, function (json) {
                if (json.data && json.data.length) {
                    json.data.forEach(function (el) {
                        sub_select.append("<option value='" + el.id + "'>" + el.name + "</option>");
                    });
                    sub_select.show();
                } else {
                    sub_select.hide();
                }
            });
        }
    });

    $(".bill_form").ajaxForm({
            beforeSubmit: function () {
                $(".bill_form .alert").hide();
                $(".bill_form button").attr("disabled", "disabled");
            },
            dataType: "json",
            success: function (json) {
                $(".bill_form button").removeAttr("disabled", "disabled");
                if (json.success) {
                    location.href = location.href;
                } else {
                    $(".bill_form .alert").html(json.message).show();
                }
            }
        }
    );
    /////////////////////////////////////////
    // Платежи по кредиту
    $(".add_credit_pay").click(function () {
        $(".add-credit_pay-dialog").modal();

    });
    //Аjax формы
    $(".ajaxform").ajaxForm({
            beforeSubmit: function () {
                $(".ajaxform .alert").hide();
                $(".ajaxform button").attr("disabled", "disabled");
            },
            dataType: "json",
            error: function () {
                $(".ajaxform button").removeAttr("disabled", "disabled");
                (".ajaxform .alert").html("Ошибка при отправке формы").show();
            },
            success: function (json) {
                $(".ajaxform button").removeAttr("disabled", "disabled");
                if (json.success) {
                    location.href = location.href;
                } else {
                    $(".ajaxform .alert").html(json.message).show();
                }
            }
        }
    );
    //Просмотр счетов
    $(".bill_item").click(function () {
        if($(this).hasClass("loading")) return;
        $(this).addClass("loading");
       $.getJSON($(this).attr("href"), function (json) {
            $(this).remove("loading");
            if(json.success) {
                if(json.data.type == 'expense') {
                    $(".add-bill_view-dialog .modal-title").html("Затрата");
                } else {
                    $(".add-bill_view-dialog .modal-title").html("Пополнение");
                }
                $(".add-bill_view-dialog .bill_value").html(json.data.value);
                $(".add-bill_view-dialog .bill_date").html(json.data.created_at);
                $(".add-bill_view-dialog .bill_reason").html(json.data.reason_name);
                $(".add-bill_view-dialog .bill_description").html(json.data.description);
                $(".add-bill_view-dialog .delete-bill").data("id", json.data.id);
            }
            $(".add-bill_view-dialog").modal();
       });

       return false;
    });
    //Удаление счета
    $(".delete-bill").click(function () {
        var id = $(this).data("id");
        var button = $(this);
       if(id) {
           $(this).attr("disabled","disabled");
           $.getJSON("/api/delete_bill", {id: id}, function (json) {
               button.removeAttr("disabled");
               location.href = location.href;
           });
       }
    });
})


