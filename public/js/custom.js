$(document).ready(function () {
    $(document).on('mouseenter', '#dropdown-notification li.background-grey', function () {
        $(this).removeClass('background-grey');

        var url = '/admin/change-status-notification';
        var id = $(this).attr('id');

        $.ajax({
            url: url,
            type: 'GET',
            data: {
                id: id
            }
        }).done(function (result) {
        });
    });
});

function displayNotification() {
    if ($('#dropdown-notification').hasClass('show')) {
        $('#dropdown-notification').removeClass('show');
    } else {
        $('#dropdown-notification').addClass('show');
        $('#dropdown-notification').attr('data-popper-placement', 'bottom-end');
    }
}