var totalShareConfig = 0;
var maxTotalShareConfig = 100;

$(document).ready(function () {
    $(".loading").hide();

    $(document).ajaxStart(function () {
        $(".loading").show();
    });

    $(document).ajaxStop(function () {
        $(".loading").hide();
    });

    $(document).ajaxError(function () {
        $(".loading").hide();
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let template = null;
    $('.modal').on('show.bs.modal', function (event) {
        template = $(this).html();
    });

    $('.modal').on('hidden.bs.modal', function (e) {
        $(this).html(template);

        totalShareConfig = 0;
    });

    $('body').on('click', '#show-modal-push-link', function () {
        $('#addPushConfig').modal('show');
    });
});


$('#addPushConfig').on('show.bs.modal', function (e) {
    resetFormPush();
});

function validateShareWeb() {
    var invalid = false;
    var needAddLink = false;
    var links_push_config = $('#list_link_push .link-push');
    var remainPercent = 100;
    var totalPercent = 0;

    links_push_config.each(function (index, item) {
        var share = $(item).find('input[name=share]').val();

        if (share == '') {
            share = 0;
        }
        share = parseInt(share);
        totalPercent += share;

        remainPercent = remainPercent - share;

        if (remainPercent < 0) {
            $(item).find('input[name=share]').parent().find('.error').text("Share web không hợp lê. Tổng share web 100%. Xin nhập lại");

            invalid = true;
        }
    });

    if (totalPercent < 100) {
        needAddLink = confirm('Tổng share web đang nhỏ hơn 100%, hiện tại: ' + totalPercent + '%, bạn có muốn nhập thêm không?');
    }

    if (remainPercent == 0) {
        invalid = false;
    }

    return {
        invalid: invalid,
        needAddLink: needAddLink,
    }

}

$(".validate-form-link").each(function () {
    $(this).validate({
        rules: {
            share: {
                required: true,
                number: true,
                min: 0,
                max: 100
            },
            links: {
                required: true
            }
        },
        messages: {
            share: {
                required: "Share web is required",
                number: "Please enter a valid number",
                min: "Share web is not less than 0",
                max: "Share web is not greater than 100"
            },
            links: {
                required: "Links is required",
            }
        },
    });
});

function validateForm(id) {
    var valid = $(id).validate().checkForm();

    if (valid) {
        $('#btn_save_config_links').prop('disabled', false);
    } else {
        $('#btn_save_config_links').prop('disabled', true);
    }
}

function validateForms() {
    var valid = true;
    $('.link-push form').each(function () {
        if (!$(this).valid()) {
            valid = false;
            return false;
        }
    });

    if (valid) {
        $('#btn_save_config_links').prop('disabled', false);
    } else {
        $('#btn_save_config_links').prop('disabled', true);
    }
    return valid;
}

$(document).on('blur keyup change', '#addPushConfig form input, #addPushConfig form textarea', function (e) {
    var input = $(this),
        form = input.closest('form');
    validateForm(form);
    validateForms();
});

$('.link-push form').each(function () {
    $(this).validate();
});

$('#btn_save_config_links').on('click', function () {
    var valid = false;

    var share = $('#addPushConfig input[name=share]').val();
    if (share === '') {
        valid = false;
        alert('Please enter share web value.');
        $('#addPushConfig input[name=share]').focus();

        return false;
    }

    $('.link-push form').each(function () {
        if ($(this).valid()) {
            valid = true;
        } else {
            valid = false;
            return false;
        }
    });
});

$('body').on('click', '#btn_save_config_links', function (e) {
    var pushIndex = parseInt(getCurrentPushIndex()) + 1;
    var dataPost = {};
    dataPost['data'] = {};

    var share = $('#addPushConfig input[name=share]').val();
    dataPost['share'] = share;
    dataPost['push_index'] = pushIndex;

    $(".validate-form-link").each(function (index, item) {
        if ($(this).valid()) {
            e.preventDefault();
            var dataConfig = {};
            var id = 'link_push_' + (index + 1);
            dataConfig[id] = {};
            var links = $(item).find('textarea[name=links]').val().split('\n');
            dataPost['data'][id] = links;
        }
    });

    if (dataPost) {
        $.ajax({
            url: "{{ route('saveConfigSystemLink') }}",
            data: dataPost,
            dataType: 'json',
            method: 'POST',
            async: false,
            success: function (response) {
                if (response.success) {
                    toastr.success("Created success!!!");
                    $("#addPushConfig").modal('hide');
                    location.reload();
                }
            }
        });
    }
});

function resetFormPush() {
    var dataConfig = {};
    var links_push_config = $('#list_link_push .link-push');

    links_push_config.each(function (index, item) {
        $(item).find('textarea[name=links]').val("");
    });
}

function getCurrentPushIndex() {
    var pushCount = 0;

    $.ajax({
        url: "{{ route('getCurrentPushCountAjax') }}",
        dataType: 'json',
        method: 'GET',
        async: false,
        success: function (response) {
            if (response.success) {
                pushCount = response.pushCount;
            }
        }
    });
    return pushCount;
}

$("body").on('click', '#add-card-push-link', function () {
    var countLinkDiv = $('#list_link_push .link-push').length;
    var title = 'Link Push ' + (countLinkDiv + 1);

    $("#list_link_push").append(`<div class="link-push" data-index="">
                               <div class="card">
                                <div class="card-header"><h5><span class="title-link">` + title + `</span></h5>
                                <button class="btn btn-danger btn-sm remove-card-push-link" ><i class="fa fa-trash-o" aria-hidden="true"></i></button>

                                </div>
                                <div class="card-body">
                                    <form class="validate-form-link">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Share web(%)</label>
                                            <input type="text" name="share" class="form-control" required>
                                            <div class="error" style="color: red;"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">Links</label>
                                            <textarea class="form-control" name="links" rows="3" required></textarea>
                                            <div class="error" style="color: red;"></div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>`);
    refreshIndex();
});

$('body').on('click', '.remove-card-push-link', function () {
    var parent = $(this).parent().parent().parent();
    parent.remove();
    refreshIndex();
});

function refreshIndex() {
    var dataConfig = {};
    var links_push_config = $('#list_link_push .link-push');
    links_push_config.each(function (index, item) {
        var title = 'Link Push ' + (index + 1);
        $(item).find('.title-link').text(title);
        $(item).attr('data-index', (index));
    });
}

$('.edit-link-config-push-item').on('click', function (e) {
    e.preventDefault();
    var itemId = $(this).data('item-id');
    var parent = $(this).parent();
    var cards = $(parent).find('.card');
    var share = $('#accordion-body-' + itemId + ' input[name=share]').val();

    dataUpdate = {
        share: share,
        data: {}
    };

    $.each(cards, function (i, linksItem) {
        var label = $(linksItem).find('.title-link').text().toLowerCase();
        var links = $(linksItem).find('textarea').val().split("\n");

        dataUpdate['data'][label] = links;
    });

    var url = "{{ route('updateConfigSystemLink', ':id') }}";
    url = url.replace(':id', itemId);

    $.ajax({
        url: url,
        data: dataUpdate,
        dataType: 'json',
        method: 'POST',
        async: false,
        success: function (response) {
            if (response.success) {
                toastr.success("Updated success!!!");
            }
        }
    });
});

$('.save-status-link').on('click', function (e) {
    e.preventDefault();

    var status = $('#status').val();
    var type = $('input[name=type]').val();
    var url = "{{ route('saveStatusLink') }}";
    var dataPost = {
        status: status,
        type: type
    };

    $.ajax({
        url: url,
        data: dataPost,
        dataType: 'json',
        method: 'POST',
        async: false,
        success: function (response) {
            if (response.success) {
                toastr.success("Updated success!!!");
            }
        }
    });
});

function onlyNumberKey() {
    let share = document.querySelectorAll('[name="share"]');

    share.forEach(function (item, idx) {
        item.addEventListener('input', function () {
            const n = item.value.replace('%', '');
            if (n >= 0 && n <= 100) {
                item.value = item.value.replace('%', '');
            } else {
                item.value = n.slice(0, -1);
            }
        });
    })
}