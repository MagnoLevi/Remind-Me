$(function () {
    list_to_do_schedule()
})

$("#btn_add_schedule").on("click", function () {
    $('#div_add_schedule').slideToggle(200, 'swing');

    let span_btn = $(this).find('span').html() == 'Schedule'
        ? `<i class="fas fa-minus"></i> <span>Close</span>`
        : `<i class="fa-solid fa-plus"></i> <span>Schedule</span>`;

    $(this).html(span_btn)
})


function list_to_do_schedule() {
    $.ajax({
        type: "GET",
        url: "http://localhost:8000/to-do/show",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        dataType: "json",
        success: function (res) {
            if (res.status == "null") {
                $("#tbody_to_do_add_schedule").html(`<tr><td class="align-middle text-center">${res.message}</td></tr>`)
                return;
            }

            let tbody = "";

            res.data.forEach(e => {
                tbody += `<tr>
                    <td class="align-middle">${e.description}</td>
                    <td class="align-middle text-center">${e.due_date_format}</td>
                    <td class="align-middle text-center">
                        <input class="checkbox-to-do " type="checkbox" data-id="${e.to_do_id}">
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



$("#save_add_schedule").on("click", insert_schedule)
function insert_schedule() {
    $("#save_modal_add_to_do").prop("disabled", true);

    $.ajax({
        type: "POST",
        url: "http://localhost:8000/schedule/store",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            notes: $("#notes_add_schedule").val(),
            date: $("#date_add_schedule").val(),
            array_to_do:  []
        },
        dataType: "json",
        success: function (res) {
            $("#save_modal_add_to_do").prop("disabled", false);

            if (res.status == 'error') {
                $(".input-add-schedule").addClass("is-invalid");
                $("#msg_error_add_schedule").html(res.message).show();

                setTimeout(() => {
                    $(".input-add-schedule").removeClass("is-invalid");
                    $("#msg_error_add_schedule").fadeOut();
                }, 2000);
                return;
            }

            $(".input-add-schedule").addClass("is-valid").val("");
            setTimeout(() => { $(".input-add-schedule").removeClass("is-valid"); }, 2000);
        },
        error: function (e) {
            console.error("Function: [insert_schedule] File: [index.js] Error: ", e.responseText);
            $("#save_modal_add_to_do").prop("disabled", false);

            $(".input-modal-add-to-do").addClass("is-invalid");
            $("#msg_error_add_schedule").html(`Error in recording`).show();

            setTimeout(() => {
                $(".input-modal-add-to-do").removeClass("is-invalid");
                $("#msg_error_add_schedule").fadeOut();
            }, 2000);
        },
    });
}
