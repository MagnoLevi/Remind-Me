$("#btn_add_schedule").on("click", function () {
    $('#div_add_schedule').slideToggle(200, 'swing');

    let span_btn = $(this).find('span').html() == 'Schedule'
        ? `<i class="fas fa-minus"></i> <span>Close</span>`
        : `<i class="fa-solid fa-plus"></i> <span>Schedule</span>`;

    $(this).html(span_btn)
})
