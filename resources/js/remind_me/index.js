$(function () {
    list_to_do_schedule()
})









// ------------------------------ DIV INSERT SCHEDULE ------------------------------ //
// -- OPEN DIV ADD SCHEDULE -- //
$("#btn_add_schedule").on("click", function () {
    $('#div_add_schedule').slideToggle(200, 'swing');

    let span_btn = $(this).find('span').html() == 'Schedule'
        ? `<i class="fas fa-minus"></i> <span>Close</span>`
        : `<i class="fa-solid fa-plus"></i> <span>Schedule</span>`;

    $(this).html(span_btn)
})


// -- LIST TO DOS AVAILABLES -- //
function list_to_do_schedule() {
    $.ajax({
        type: "GET",
        url: "http://localhost:8000/to-do/show-available",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        dataType: "json",
        success: function (res) {
            if (res.status == "null") {
                $("#tbody_to_do_add_schedule").html(`<tr><td class="align-middle text-center" colspan="99">${res.message}</td></tr>`)
                return;
            }

            let tbody = "";

            res.data.forEach(e => {
                tbody += `<tr>
                    <td class="align-middle">${e.description}</td>
                    <td class="align-middle text-center">${e.due_date_format}</td>
                    <td class="align-middle text-center">
                        <input class="checkbox-to-do" type="checkbox" data-to_do_id="${e.to_do_id}">
                    </td>
                </tr>`;
            });

            $("#tbody_to_do_add_schedule").html(tbody);
        },
        error: function (e) {
            console.error("Function: [list_to_do_schedule] File: [index.js] Error: ", e.responseText);

            $("#msg_error_modal_edit_to").show();
            $(".input-modal-edit-to-do").addClass("is-invalid");
            setTimeout(() => {
                $("#msg_error_modal_edit_to").fadeOut();
                $(".input-modal-edit-to-do").removeClass("is-invalid");
            }, 2000);
        },
    });
}


// -- INSERT SCHEDULE -- //
$("#open_modal_confirm_add_schedule").on("click", () => {
    $("#modal_confirm_add_schedule").modal('show');
})

$("#save_modal_confirm_add_schedule").on("click", insert_schedule)
function insert_schedule() {
    $("#save_modal_add_to_do").prop("disabled", true);
    let array_to_do = [];

    $(".checkbox-to-do").each(function () {
        if ($(this).is(":checked")) array_to_do.push($(this).data("to_do_id"));
    })

    $.ajax({
        type: "POST",
        url: "http://localhost:8000/schedule/store",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            notes: $("#notes_add_schedule").val(),
            date: $("#date_add_schedule").val(),
            array_to_do: array_to_do
        },
        dataType: "json",
        success: function (res) {
            $("#save_modal_add_to_do").prop("disabled", false);

            if (res.status == 'error') {
                $(".input-add-schedule").addClass("is-invalid");
                $("#msg_error_modal_confirm_add_schedule").html(res.message).show();

                setTimeout(() => {
                    $(".input-add-schedule").removeClass("is-invalid");
                    $("#msg_error_modal_confirm_add_schedule").fadeOut();
                }, 2000);
                return;
            }

            list_to_do_schedule();

            $("#modal_confirm_add_schedule").modal("hide")
            $(".input-add-schedule").addClass("is-valid").val("");
            setTimeout(() => { $(".input-add-schedule").removeClass("is-valid"); }, 2000);
        },
        error: function (e) {
            console.error("Function: [insert_schedule] File: [index.js] Error: ", e.responseText);
            $("#save_modal_add_to_do").prop("disabled", false);

            $(".input-add-schedule").addClass("is-invalid");
            $("#msg_error_modal_confirm_add_schedule").html(`Error in recording`).show();

            setTimeout(() => {
                $(".input-add-schedule").removeClass("is-invalid");
                $("#msg_error_modal_confirm_add_schedule").fadeOut();
            }, 2000);
        },
    });
}
