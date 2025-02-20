$(document).ready(function () {

});

function displayNotification() {
    if ($('#dropdown-notification').hasClass('show')) {
        $('#dropdown-notification').removeClass('show');
    } else {
        $('#dropdown-notification').addClass('show');
    }
}