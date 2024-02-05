$(function () {
    if ($("#type_modal_add_task").val() == 'DAILY') {
        $("#div_daily_add_task").show();
        $("#div_weekly_add_task").hide();
        $("#div_monthly_add_task").hide();
    }

    if ($("#type_modal_add_task").val() == 'WEEKLY') {
        $("#div_daily_add_task").hide();
        $("#div_weekly_add_task").show();
        $("#div_monthly_add_task").hide();
    }

    if ($("#type_modal_add_task").val() == 'MONTHLY') {
        $("#div_daily_add_task").hide();
        $("#div_weekly_add_task").hide();
        $("#div_monthly_add_task").show();
    }

    list_to_do();
    list_recurring_task();
})








// ------------------------------------ TO DO ------------------------------------ //
// -- MODAL ADD TO DO -- //
$("#btn_open_modal_add_to_do").on("click", function (params) {
    $("#modal_add_to_do").modal("show");
})


$("#save_modal_add_to_do").on("click", insert_to_do);
function insert_to_do() {
    $("#save_modal_add_to_do").prop("disabled", true);

    $.ajax({
        type: "POST",
        url: "http://localhost:8000/to-do/store",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            description: $("#description_modal_add_to_do").val(),
            due_date: $("#date_modal_add_to_do").val()
        },
        dataType: "json",
        success: function (res) {
            $("#save_modal_add_to_do").prop("disabled", false);

            if (res.status == 'error') {
                $(".input-modal-add-to-do").addClass("is-invalid");
                $("#msg_error_modal_add_to").html(res.message).show();

                setTimeout(() => {
                    $(".input-modal-add-to-do").removeClass("is-invalid");
                    $("#msg_error_modal_add_to").fadeOut();
                }, 2000);
                return;
            }

            list_to_do();
            $(".input-modal-add-to-do").addClass("is-valid").val("");
            setTimeout(() => { $(".input-modal-add-to-do").removeClass("is-valid"); }, 2000);
        },
        error: function (e) {
            console.error("Function: [insert_to_do] File: [to_do.js] Error: ", e.responseText);
            $("#save_modal_add_to_do").prop("disabled", false);

            $(".input-modal-add-to-do").addClass("is-invalid");
            $("#msg_error_modal_add_to").html(`Error in recording`).show();

            setTimeout(() => {
                $(".input-modal-add-to-do").removeClass("is-invalid");
                $("#msg_error_modal_add_to").fadeOut();
            }, 2000);
        },
    });
}


// -- SHOW TO DO LIST -- //
function list_to_do() {
    $.ajax({
        type: "GET",
        url: "http://localhost:8000/to-do/show",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        dataType: "json",

        beforeSend: function () {
            $("#tbody_to_do").html(`
                <tr><td class="text-center" colspan="99">
                    <i class="spinner-border spinner-border-sm"></i> Loading...
                </td></tr>
            `);
        },
        success: function (res) {
            if (res.status != "ok") {
                $("#tbody_to_do").html(`
                    <tr><td class="text-center" colspan="99">
                        ${res.message}
                    </td></tr>
                `);
                return;
            }


            let tbody = "";

            res.data.forEach(e => {
                tbody += `<tr data-to_do_id="${e.to_do_id}">
                    <td class="to-do-line align-middle">${e.description}</td>
                    <td class="to-do-line align-middle text-center">${e.due_date_format}</td>
                    <td class="align-middle text-center trash-to-do" style='cursor: pointer;'>
                        <i class="fa-solid fa-trash-can text-danger"></i>
                    </td>
                </tr>`;
            });

            $("#tbody_to_do").html(tbody);


            // Click delete to do
            $(".trash-to-do").on("click", function () {
                delete_to_do($(this).closest('tr'), $(this), $(this).closest('tr').data('to_do_id'))
            });

            // Click to do line
            $(".to-do-line").on("click", function () {
                edito_to_do($(this).closest('tr').data('to_do_id'))
            });
        },
        error: function (e) {
            console.error("Function: [list_to_do] File: [to_do.js] Error: ", e.responseText);

            $("#tbody_to_do").html(`
                <tr><td class="text-center text-danger" colspan="99">
                    ${res.message}
                </td></tr>
            `);
        },
    });
}


// -- DELETE TO DO -- //
function delete_to_do(tr, btn, to_do_id) {
    $.ajax({
        type: "POST",
        url: "http://localhost:8000/to-do/destroy",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            to_do_id: to_do_id
        },
        dataType: "json",
        beforeSend: function () {
            $(btn).html(`<i class="spinner-border spinner-border-sm"></i>`);
        },
        success: function (res) {
            if (res.status == "ok") {
                $(tr).remove();
            }

            $(btn).html(`<i class="fa-solid fa-trash-can text-danger"></i>`);
        },
        error: function (e) {
            console.error("Function: [delete_to_do] File: [to_do.js] Error: ", e.responseText);

            $(btn).html(`<i class="fa-solid fa-trash-can text-danger"></i>`);
        },
    });
}


// -- MODAL EDIT TO DO -- //
$("#modal_edit_to_do").on('hidden.bs.modal', function () {
    $(".input-modal-edit-to-do").val('');
})

function edito_to_do(to_do_id) {
    $("#modal_edit_to_do").modal("show");

    $.ajax({
        type: "GET",
        url: `http://localhost:8000/to-do/edit/${to_do_id}`,
        dataType: "json",
        beforeSend: function () {

        },
        success: function (res) {
            if (res.status == "ok") {
                $("#title_modal_edit_to_do").html(res.data.description.length > 50 ? res.data.description.substr(0, 50) : res.data.description);

                $("#id_modal_edit_to_do").val(res.data.id);
                $("#description_modal_edit_to_do").val(res.data.description);
                $("#date_modal_edit_to_do").val(res.data.due_date);
            }

        },
        error: function (e) {
            console.error("Function: [edito_to_do] File: [to_do.js] Error: ", e.responseText);
        },
    });
}


// -- UPDATE TO DO -- //
$("#save_modal_edit_to_do").on("click", update_to_do);
function update_to_do() {
    $.ajax({
        type: "POST",
        url: "http://localhost:8000/to-do/update",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            to_do_id: $("#id_modal_edit_to_do").val(),
            description: $("#description_modal_edit_to_do").val(),
            due_date: $("#date_modal_edit_to_do").val()
        },
        dataType: "json",
        success: function (res) {
            if (res.status != "ok") {
                $("#msg_error_modal_edit_to").show().html(res.message);
                $(".input-modal-edit-to-do").addClass("is-invalid");
                setTimeout(() => {
                    $("#msg_error_modal_edit_to").fadeOut();
                    $(".input-modal-edit-to-do").removeClass("is-invalid");
                }, 2000);
                return;
            }

            list_to_do();
            $(".input-modal-edit-to-do").addClass('is-valid');
            setTimeout(() => { $(".input-modal-edit-to-do").removeClass('is-valid'); }, 2000);
        },
        error: function (e) {
            console.error("Function: [update_to_do] File: [to_do.js] Error: ", e.responseText);

            $("#msg_error_modal_edit_to").show();
            $(".input-modal-edit-to-do").addClass("is-invalid");
            setTimeout(() => {
                $("#msg_error_modal_edit_to").fadeOut();
                $(".input-modal-edit-to-do").removeClass("is-invalid");
            }, 2000);
        },
    });
}





// ------------------------------------ TASKS ------------------------------------ //
// -- MODAL ADD TASK -- //
$("#btn_open_modal_add_task").on("click", function (params) {
    $("#modal_add_task").modal("show")
})

$("#type_modal_add_task").on("change", function () {
    if ($(this).val() == 'DAILY') {
        $("#div_daily_add_task").fadeIn(200);
        $("#div_weekly_add_task").hide();
        $("#div_monthly_add_task").hide();
    }

    if ($(this).val() == 'WEEKLY') {
        $("#div_daily_add_task").hide();
        $("#div_weekly_add_task").fadeIn(200);
        $("#div_monthly_add_task").hide();
    }

    if ($(this).val() == 'MONTHLY') {
        $("#div_daily_add_task").hide();
        $("#div_weekly_add_task").hide();
        $("#div_monthly_add_task").fadeIn(200);
    }
})


$(".btn-weekly-add-task").on("click", function () {
    let div = $(this).closest("div");

    if ($(div).find("input").prop("disabled")) {
        $(div).find("input").prop("disabled", false)
    } else {
        $(div).find("input").prop("disabled", true).val("");
    }
})


$("#save_modal_add_task").on("click", insert_recurring_task);
function insert_recurring_task() {
    $("#save_modal_add_task").prop("disabled", true);

    let weekly_array = [];
    $('.input-weekly-modal-add-task:not(:disabled)').each(function () {
        if ($(this).val() != "") {
            weekly_array.push({
                "weekday": $(this).data("weekday"),
                "time": $(this).val()
            });
        }
    })

    $.ajax({
        type: "POST",
        url: "http://localhost:8000/task/store",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            description: $("#description_modal_add_task").val(),
            type: $("#type_modal_add_task").val(),

            daily_time: $("#daily_time_modal_add_task").val(),

            weekly_array: weekly_array,

            monthly_time: $("#monthly_time_modal_add_task").val(),
            monthly_day: $("#monthly_day_modal_add_task").val()
        },
        dataType: "json",
        success: function (res) {
            if (res.status == 'error') {
                $(".input-modal-add-task").addClass("is-invalid");
                $("#msg_error_modal_add_task").html(res.message).show();

                setTimeout(() => {
                    $(".input-modal-add-task").removeClass("is-invalid");
                    $("#msg_error_modal_add_task").fadeOut();
                }, 2000);
                return;
            }

            list_recurring_task();
            $(".input-weekly-modal-add-task").prop("disabled", true);
            $(".input-modal-add-task").addClass("is-valid").val("");
            setTimeout(() => { $(".input-modal-add-task").removeClass("is-valid"); }, 2000);
        },
        error: function (e) {
            console.error("Function: [insert_recurring_task] File: [to_do.js] Error: ", e.responseText);

            $(".input-modal-add-task").addClass("is-invalid");
            $("#msg_error_modal_add_task").html(`Error in recording`).show();

            setTimeout(() => {
                $(".input-modal-add-task").removeClass("is-invalid");
                $("#msg_error_modal_add_task").fadeOut();
            }, 2000);
        },
    });

    $("#save_modal_add_task").prop("disabled", false);
}


// -- SHOW TASK LIST -- //
function list_recurring_task() {
    $.ajax({
        type: "GET",
        url: "http://localhost:8000/task/show",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        dataType: "json",

        beforeSend: function () {
            $("#tbody_recurring_task").html(`
                <tr><td class="text-center" colspan="99">
                    <i class="spinner-border spinner-border-sm"></i> Loading...
                </td></tr>
            `);
        },
        success: function (res) {
            if (res.status != "ok") {
                $("#tbody_recurring_task").html(`
                    <tr><td class="text-center" colspan="99">
                        ${res.message}
                    </td></tr>
                `);
                return;
            }


            let tbody = "";

            res.data.forEach(e => {
                tbody += `<tr class='task-line'
                        data-to_do_id="${e.to_do_id}" data-task_id="${e.task_id}" data-type="${e.type}">
                    <td class="align-middle">${e.description}</td>
                    <td class="align-middle text-center">${e.type}</td>
                    <td class="align-middle text-center">${e.time}</td>
                    <td class="align-middle text-center">${e.recurring_date}</td>
                    <td class="align-middle text-center trash-task" style='cursor: pointer;'>
                        <i class="fa-solid fa-trash-can text-danger"></i>
                    </td>
                </tr>`;
            });

            $("#tbody_recurring_task").html(tbody);


            // Btn delete to do
            $(".trash-task").on("click", function () {
                if ($(this).closest('tr').data('type') == 'WEEKLY') {
                    delete_task_weekly($(this).closest('tr'), $(this), $(this).closest('tr').data('task_id'))
                } else {
                    delete_to_do($(this).closest('tr'), $(this), $(this).closest('tr').data('to_do_id'))
                }
            });

            // Click task line
            $(".task-line").on("click", function () {
                edit_task($(this).closest('tr').data('to_do_id'))
            });
        },
        error: function (e) {
            console.error("Function: [list_recurring_task] File: [to_do.js] Error: ", e.responseText);

            $("#tbody_recurring_task").html(`
                <tr><td class="text-center text-danger" colspan="99">
                    ${res.message}
                </td></tr>
            `);
        },
    });
}


// -- DELETE WEEKLY TASK -- //
function delete_task_weekly(tr, btn, task_id) {
    $.ajax({
        type: "POST",
        url: "http://localhost:8000/task/weekly/destroy",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            task_id: task_id
        },
        dataType: "json",
        beforeSend: function () {
            $(btn).html(`<i class="spinner-border spinner-border-sm"></i>`);
        },
        success: function (res) {
            if (res.status == "ok") {
                $(tr).remove();
            }

            $(btn).html(`<i class="fa-solid fa-trash-can text-danger"></i>`);
        },
        error: function (e) {
            console.error("Function: [delete_task_weekly] File: [to_do.js] Error: ", e.responseText);

            $(btn).html(`<i class="fa-solid fa-trash-can text-danger"></i>`);
        },
    });
}


// -- MODAL EDIT TO DO -- //
$("#modal_edit_task").on('hidden.bs.modal', function () {
    $(".input-modal-edit-task").val('');
    $('#div_daily_edit_task').hide();
    $('#div_weekly_edit_task').hide();
    $('#div_monthly_edit_task').hide();
    $(`.input-weekly-modal-edit-task`).val('').prop('disabled', true);
})

$(".btn-weekly-edit-task").on("click", function () {
    let div = $(this).closest("div");

    if ($(div).find("input").prop("disabled")) {
        $(div).find("input").prop("disabled", false)
    } else {
        $(div).find("input").prop("disabled", true).val("");
    }
})

function edit_task(to_do_id) {
    $("#modal_edit_task").modal("show");

    $.ajax({
        type: "GET",
        url: `http://localhost:8000/task/edit/${to_do_id}`,
        dataType: "json",
        beforeSend: function () {

        },
        success: function (res) {
            if (res.status != "ok") {
                $("#title_modal_edit_task").html(`<span class='text-danger'>${res.message}</span>`);
            }

            $("#title_modal_edit_task").html(res.data.description.length > 50 ? res.data.description.substr(0, 50) : res.data.description);

            $("#id_modal_edit_task").val(res.data.id);
            $("#description_modal_edit_task").val(res.data.description);
            $("#type_modal_edit_task").val(res.data.type);


            if (res.data.type == 'DAILY') {
                $('#div_daily_edit_task').show();
                $('#daily_time_modal_edit_task').val(res.data.task.time.substr(0, 5));

            } else if (res.data.type == 'WEEKLY') {
                $('#div_weekly_edit_task').show();

                res.data.task.forEach(r => {
                    $(`.input-weekly-modal-edit-task[data-weekday=${r.weekday}]`).val(r.time.substr(0, 5)).prop('disabled', false).data('task_id', r.id);
                });

            } else {
                $('#div_monthly_edit_task').show();
                $('#monthly_day_modal_edit_task').val(res.data.task.day_of_month);
                $('#monthly_time_modal_edit_task').val(res.data.task.time.substr(0, 5));
            }

        },
        error: function (e) {
            console.error("Function: [edito_to_do] File: [to_do.js] Error: ", e.responseText);
        },
    });
}


// -- UPDATE TASK -- //
$("#save_modal_edit_task").on("click", update_task);
function update_task() {
    $("#save_modal_edit_task").prop("disabled", true);

    let weekly_array = [];
    $('.input-weekly-modal-edit-task').each(function () {
        weekly_array.push({
            "id": $(this).data("task_id"),
            "weekday": $(this).data("weekday"),
            "time": $(this).val()
        });
    })

    $.ajax({
        type: "POST",
        url: "http://localhost:8000/task/update",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            to_do_id: $("#id_modal_edit_task").val(),
            description: $("#description_modal_edit_task").val(),
            type: $("#type_modal_edit_task").val(),

            daily_time: $("#daily_time_modal_edit_task").val(),

            weekly_array: weekly_array,

            monthly_time: $("#monthly_time_modal_edit_task").val(),
            monthly_day: $("#monthly_day_modal_edit_task").val()
        },
        dataType: "json",
        success: function (res) {
            if (res.status != "ok") {
                $("#msg_error_modal_edit_task").show().html(res.message);
                $(".input-modal-edit-task").addClass("is-invalid");
                setTimeout(() => {
                    $("#msg_error_modal_edit_task").fadeOut();
                    $(".input-modal-edit-task").removeClass("is-invalid");
                }, 2000);
                return;
            }

            list_recurring_task();
            $(".input-modal-edit-to-do").addClass('is-valid');
            setTimeout(() => { $(".input-modal-edit-to-do").removeClass('is-valid'); }, 2000);
        },
        error: function (e) {
            console.error("Function: [update_task] File: [to_do.js] Error: ", e.responseText);

            $("#msg_error_modal_edit_task").show().html("Error");
            $(".input-modal-edit-task").addClass("is-invalid");
            setTimeout(() => {
                $("#msg_error_modal_edit_task").fadeOut();
                $(".input-modal-edit-task").removeClass("is-invalid");
            }, 2000);
        },
    });

    $("#save_modal_edit_task").prop("disabled", false);
}
