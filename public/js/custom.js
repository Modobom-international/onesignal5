$(document).ready(function () {

    setTimeout(function () {
        $(".alert").remove();
    }, 5000); // 5 secs


    //disable edit link_active in page edit landing page
    var path = window.location.pathname;

    if (path.indexOf('landing-pages/edit') !== -1) {
        $('select[id="link_active"]').attr('disabled', 'disabled');
    }


    //update remote link active
    $('button[class*="active_link"]').on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();

        var isApk = $(this).attr('lp-link-active') == 'link_apk' ? 1 : 0;

        var lpId = $(this).attr('lp-id');
        var linkActive = $(this).attr('lp-link-active');

        //@todo: call api to update link active for current apk
        var apiUpdateLinkRemote = $('#api_update_link_remote').attr('link');

        $.ajax({
            method: 'GET',
            async: false,
            url: apiUpdateLinkRemote.replace('xxx', lpId).replace('yyy', linkActive).replace('zzz', isApk),

        }).done(function (response) {
            console.log(response);

            console.log(response.status);
            if (response.status === true) {
                $('button[lp-id="' + lpId + '"]').removeAttr('disabled').removeClass('btn-success').addClass('btn-secondary');
                $('button[class*="active_' + linkActive + '_' + lpId + '"]').attr('disabled', 'disabled')
                    .removeClass('btn-secondary').addClass('btn-success');

            } else {
                alert('Error while update link active!');
                return;
            }
        });

    });

    //update view page remote
    $('button[class*="active_page"]').on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();

        var lpId = $(this).attr('lp-id');
        var pageView = $(this).attr('lp-view-page');

        var id = $(this).attr('id');

        //@todo: call api to update view page for current apk
        var apiUpdateViewPageRemote = $('#api_update_viewpage_remote').attr('link');

        console.log('lp id: ' + lpId);
        console.log('page view: ' + pageView);
        console.log('api update: ' + apiUpdateViewPageRemote);
        console.log('api update final: ' + apiUpdateViewPageRemote.replace('_id', lpId).replace('_page', pageView));

        $.ajax({
            method: 'GET',
            async: false,
            url: apiUpdateViewPageRemote.replace('_id', lpId).replace('_page', pageView),

        }).done(function (response) {
            console.log(response);

            console.log(response.status);
            if (response.status === true) {
                $('button[class*="view_page_' + lpId + '"]').removeAttr('disabled').removeClass('btn-success').addClass('btn-secondary');
                $('button[id="' + id + '"]').attr('disabled', 'disabled').removeClass('btn-secondary').addClass('btn-success');

            } else {
                alert('Error while update view page!');
                return;
            }
        });

    });


    if ($.fn.fastselect) { //check function fastselect exist and execute
        $('.multipleSelect').fastselect();
    }

    //select_country
    $('#select_country').on('change', function (e) {
        var country = $(this).val();
        var searchValue = $('#search').val().trim();

        window.location.href = '?country=' + country + '&search=' + searchValue;

    });


    //page show log ip
    $('#mark_time').on('click', function (e) {
        //e.preventDefault();

        // alert(currentDatetime());

        $('#datetimepicker4').val(currentDatetime());

        //current domain
        var currentLP = $('#from').val();
        createCookie(currentLP, currentDatetime());


    });

    if ($('#from').length > 0) {
        if (readCookie($('#from').val())) {
            changeTextboxDatetimeValue();
        }

        $('#from').on('change', function () {
            changeTextboxDatetimeValue();
        });

    }


    if ($('#table_pool_apk').length > 0) {
        $('.replace_file').on('click', function (e) {
            e.preventDefault();

            var apkId = $(this).data('apk_id');
            var apkName = $(this).data('table_name');

            var urlUpdateFile = $('#url_overwrite_pool_file').val().replace('@@@', apkId);
            var parentTr = $(this).parent('td').parent('tr');

            $.get(urlUpdateFile, function (response) {
                console.log(response);

                if (response.status == true) {
                    //todo: send ajax request to replace file, if success run command below
                    parentTr.remove();

                    //check empty row
                    var rowCount = $('table[data-children_table_name="' + apkName + '"] tr').length;
                    if (rowCount == 0) {
                        $('table[data-parent_table_name="' + apkName + '"]').remove();
                        $('tr[data-parent_tr_name="' + apkName + '"]').remove();
                    }

                }


            }).done(function (response) {
                console.log('from done');
                console.log(response);


            }); //end ajax done


        });


    }


});

function changeTextboxDatetimeValue() {
    $('#datetimepicker4').val(readCookie($('#from').val()));
}

function currentDatetime() {
    var date = new Date();
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var seconds = date.getSeconds();
    var ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    hours = hours < 10 ? '0' + hours : hours;
    minutes = minutes < 10 ? '0' + minutes : minutes;

    var month = date.getMonth() + 1;
    month = month < 10 ? '0' + month : month;
    var day = date.getDate();
    day = day < 10 ? '0' + day : day;


    return date.getFullYear() + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds + " " + ampm;
}

function createCookie(name, value, days = 7) {
    var expires;

    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    } else {
        expires = "";
    }
    document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + expires + "; path=/";
}

function readCookie(name) {
    var nameEQ = encodeURIComponent(name) + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) === ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0) return decodeURIComponent(c.substring(nameEQ.length, c.length));
    }
    return null;
}

function eraseCookie(name) {
    createCookie(name, "", -1);
}

/* this is function ajax get ads code field show modal */
function showCodeModal(uId, urlAjax) {
    var ajaxRequest = urlAjax.replace('_id', uId);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: 'GET',
        async: false,
        url: ajaxRequest,
    }).done(function (response) {
        if (response.status === true) {
            var dataResult = response.raw_result;
            $('#update-code').modal('show');
            $('input[name=ads_id]').val(dataResult.ads_id);
            $('input[name=ads_analytic]').val(dataResult.ads_analytic);
            $('input[name=ads_conversion]').val(dataResult.ads_conversion);
            $('input[name=ads_tag_mng]').val(dataResult.ads_tag_mng);
            $('input[name=uid]').val(dataResult.id);
        } else {
            alert('Error while show code view ');
            return;
        }
    });
}

/* this is function ajax update code show modal */
function updateCodeModal(urlAjax) {
    var formData = $('#modalFormCode').serialize();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: 'POST',
        async: false,
        url: urlAjax,
        data: formData
    }).done(function (response) {
        if (response.status === true) {
            $('#update-code').modal('hide');
        } else {
            alert('Error while update code view ');
            return;
        }
    });
}
