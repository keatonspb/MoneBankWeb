/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

require('./components/jquery.form.min.js')

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */




$(document).ready(function () {
    $(".add_bill").click(function () {
        if($(this).data("role") == 'expense') {
            $(".add-bill-dialog .modal-title,.add-bill-dialog .btn-primary").html("Потратить");
        } else {
            $(".add-bill-dialog .modal-title,.add-bill-dialog .btn-primary").html("Пополнить");
        }
        $(".add-bill-dialog input.bill_type").val($(this).data("role"));
        $(".parent_reason_select option").hide();
        $(".parent_reason_select option."+$(this).data("role")).show();
        $(".parent_reason_select option."+$(this).data("role")+":first").prop("selected", true);
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
                $(".bill_form button").attr("disabled", "disabled");
            },
            dataType: "json",
            success: function (json) {
                $(".bill_form button").removeAttr("disabled", "disabled");
                if(json.success == true) {
                    location.href = location.href;
                }
            }
        }
    );
})


