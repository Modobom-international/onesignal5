$(function () {
    $('#country').select2({
        theme: 'bootstrap'
    });
    $('#platform').select2({
        theme: 'bootstrap'
    });
    $('#app-name').select2({
        theme: 'bootstrap'
    });
    $('#network').select2({
        theme: 'bootstrap'
    });
    $('#install').select2({
        theme: 'bootstrap'
    });
    $('#country-report').select2({
        theme: 'bootstrap'
    });
    $('#platform-report').select2({
        theme: 'bootstrap'
    });
    $('#app-name-report').select2({
        theme: 'bootstrap'
    });
    $('#keyword-report').select2({
        theme: 'bootstrap'
    });
    $('#country-modal').select2({
        dropdownParent: $('#modalListAppCheckInstall'),
        theme: 'bootstrap'
    });
    $('#platform-modal').select2({
        dropdownParent: $('#modalListAppCheckInstall'),
        theme: 'bootstrap'
    });
    $('#app-name-modal').select2({
        dropdownParent: $('#modalListAppCheckInstall'),
        theme: 'bootstrap'
    });
    $('#assigned-modal').select2({
        dropdownParent: $('#modalListAppCheckInstall'),
        theme: 'bootstrap'
    });
    $('#country-search-modal').select2({
        dropdownParent: $('#modalListAppCheckInstall'),
        theme: 'bootstrap'
    });
    $('#platform-search-modal').select2({
        dropdownParent: $('#modalListAppCheckInstall'),
        theme: 'bootstrap'
    });
    $('#app-name-search-modal').select2({
        dropdownParent: $('#modalListAppCheckInstall'),
        theme: 'bootstrap'
    });
    $('#assigned-search-modal').select2({
        dropdownParent: $('#modalListAppCheckInstall'),
        theme: 'bootstrap'
    });
    $('#country-report').select2({
        dropdownParent: $('#modalReport'),
        theme: 'bootstrap'
    });
    $('#platform-report').select2({
        dropdownParent: $('#modalReport'),
        theme: 'bootstrap'
    });
    $('#app-name-report').select2({
        dropdownParent: $('#modalReport'),
        theme: 'bootstrap'
    });
    $('#keyword-report').select2({
        dropdownParent: $('#modalReport'),
        theme: 'bootstrap'
    });
    $("#datepicker").datepicker({
        dateFormat: "yy-m-dd",
        maxDate: 0
    });
    $("#datepicker-from").datepicker({
        dateFormat: "yy-m-dd",
        maxDate: 0
    });
    $("#datepicker-to").datepicker({
        dateFormat: "yy-m-dd",
        maxDate: 0
    });
    $('#datepicker-from').val(prevToday);
    $('#datepicker-to').val(today);
    $("#pre-loader").attr("style", "display: none !important");
    $("#pre-loader-activity").attr("style", "display: none !important");
    $("#empty-result").attr("style", "display: none !important");
    $(".select2").addClass("w-100");
    window.onscroll = function () {
        scrollFunction();
    };
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
    if (app) {
        $("#app-name").val(app);
        $('#app-name').trigger('change');
        if (strInPage == '') {
            strInPage += '?app=' + app;
        } else {
            strInPage += '&app=' + app;
        }
    }
    if (country) {
        $("#country").val(country);
        $('#country').trigger('change');
        if (strInPage == '') {
            strInPage += '?country=' + country;
        } else {
            strInPage += '&country=' + country;
        }
    }
    if (platform) {
        $("#platform").val(platform);
        $('#platform').trigger('change');
        if (strInPage == '') {
            strInPage += '?platform=' + platform;
        } else {
            strInPage += '&platform=' + platform;
        }
    }
    if (network) {
        $("#network").val(network);
        $('#network').trigger('change');
        if (strInPage == '') {
            strInPage += '?network=' + network;
        } else {
            strInPage += '&network=' + network;
        }
    }
    if (date) {
        $("#datepicker").val(date);
        if (strInPage == '') {
            strInPage += '?date=' + date;
        } else {
            strInPage += '&date=' + date;
        }
    }
    $('#show-in-page-100').attr('href', strInPage + '&in_page=100');
    $('#show-in-page-150').attr('href', strInPage + '&in_page=150');
    $('#show-in-page-200').attr('href', strInPage + '&in_page=200');
    $('#show-in-page-250').attr('href', strInPage + '&in_page=250');
    $('#show-in-page-all').attr('href', strInPage + '&in_page=all');
    $("#search-report").on("click", function () {
        let app = $('#app-name').val();
        let country = $('#country').val();
        let platform = $('#platform').val();
        let network = $('#network').val();
        let install = $('#install').val();
        let date = $('#datepicker').datepicker({
            dateFormat: 'yyyy-MM-dd'
        }).val();
        let url = '/admin/log-behavior?country=' + country + '&platform=' + platform + '&date=' + date + '&app=' + app + '&network=' + network + '&install=' + install;
        window.location.href = url;
    });
    $("#tbody-modal").on("click", '.delete-app-in-list-check', function (e) {
        e.preventDefault();
        $(this).prop('disabled', true);
        let id = $(this).attr('data-id');
        let url = '{{ route("log.behavior.delete.app.in.check.list") }}';
        let idLoader = '#loader-' + id;
        $(idLoader).removeClass('hide');
        $.ajax({
            url: url,
            type: 'GET',
            data: {
                id: id
            }
        }).done(function () {
            let idElement = '#' + id;
            $(idElement).remove();
            $('.error-message-modal p').text('Ứng dụng xóa khỏi danh sách thành công!');
            $(this).prop('disabled', false);
            $(idLoader).addClass('hide');
            $('.error-message-modal').show();
            let interval = setInterval(function () {
                $('.error-message-modal').hide();
                clearInterval(interval);
            }, 3000);
        });
    });
    $("#tbody-modal").on("click", '.lock-app-in-list-check', function (e) {
        e.preventDefault();
        let id = $(this).attr('data-id');
        let lock = $(this).attr('data-lock');
        let url = '/lock-app-in-list-for-check';
        let idLoader = '#loader-' + id;
        $(idLoader).removeClass('hide');
        $.ajax({
            url: url,
            type: 'GET',
            data: {
                id: id,
                lock: lock,
            }
        }).done(function (result) {
            let idElement = '#lock-' + id;
            let idElementI = '#lock-' + id + ' i';
            if (lock == '1') {
                $(idElement).removeClass('btn-warning');
                $(idElement).addClass('btn-success');
                $(idElement).attr('data-lock', '0');
                $(idElement).attr('title', 'Unlock');
                $(idElementI).removeClass('fa-bell-slash');
                $(idElementI).addClass('fa-bell');
                $('.error-message-modal p').text('Ứng dụng khóa thành công!');
            } else {
                $(idElement).removeClass('btn-success');
                $(idElement).addClass('btn-warning');
                $(idElement).attr('data-lock', '1');
                $(idElement).attr('title', 'Lock');
                $(idElementI).removeClass('fa-bell');
                $(idElementI).addClass('fa-bell-slash');
                $('.error-message-modal p').text('Ứng dụng mở khóa thành công!');
            }
            $(this).prop('disabled', false);
            $(idLoader).addClass('hide');
            $('.error-message-modal').show();
            let interval = setInterval(function () {
                $('.error-message-modal').hide();
                clearInterval(interval);
            }, 3000);
        });
    });
    $('#save-change-option').on('click', function () {
        let url = '{{ route("log.behavior.store.config.filter") }}';
        let checkedCountry = $('.check-box-country:checkbox:checked');
        let checkedPlatform = $('.check-box-platform:checkbox:checked');
        let checkedApp = $('.check-box-app:checkbox:checked');
        let listCountry = [];
        let listPlatform = [];
        let listApp = [];
        for (let i = 0; i < checkedCountry.length; i++) {
            listCountry.push(checkedCountry[i].getAttribute('data-id'));
        }
        for (let i = 0; i < checkedPlatform.length; i++) {
            listPlatform.push(checkedPlatform[i].getAttribute('data-id'));
        }
        for (let i = 0; i < checkedApp.length; i++) {
            listApp.push(checkedApp[i].getAttribute('data-id'));
        }
        $.ajax({
            url: url,
            type: 'GET',
            data: {
                country: listCountry,
                platform: listPlatform,
                app: listApp,
            }
        }).done(function (result) {
            window.location.reload();
        });
    });
    $('#reset-btn').on('click', function () {
        let url = '{{ route("log.behavior.reset.config.filter") }}';
        window.location.href = url;
    });
    $('#compare-date-btn').on('click', function () {
        var pareDate = new Date(date);
        let pareToday = new Date();
        let now = new Date();
        let text = '';
        if (pareDate.setHours(0, 0, 0, 0) == pareToday.setHours(0, 0, 0, 0)) {
            text = now.getFullYear() + '-' + (now.getMonth() + 1) + '-' + now.getDate() + ' ' + now.getHours() + ':' + now.getMinutes() + ':' + now.getSeconds();
            $("#datepicker-previous").datepicker({
                beforeShowDay: function (customDate) {
                    var disabledDate = new Date(date);
                    if (customDate.getFullYear() === disabledDate.getFullYear() &&
                        customDate.getMonth() === disabledDate.getMonth() &&
                        customDate.getDate() === disabledDate.getDate()) {
                        return [false, "", "Ngày này bị tắt"];
                    }
                    return [true, "", ""];
                },
                dateFormat: "yy-m-dd",
                maxDate: 0
            });
        } else {
            text = date;
            statusNowDate = false;
            $("#datepicker-previous").datepicker({
                beforeShowDay: function (customDate) {
                    var disabledDate = new Date(date);
                    if (customDate.getFullYear() === disabledDate.getFullYear() &&
                        customDate.getMonth() === disabledDate.getMonth() &&
                        customDate.getDate() === disabledDate.getDate()) {
                        return [false, "", "Ngày này bị tắt"];
                    }
                    return [true, "", ""];
                },
                dateFormat: "yy-m-dd",
                maxDate: -1
            });
        }
        $('.compare-date').attr('style', 'display: flex !important');
        $(this).hide();
        $('#real-time').text(text);
    });
    $('#btn-turn-off-compare').on('click', function () {
        $('.compare-date').attr('style', 'display: none !important');
        $('#compare-date-btn').css('display', 'block');
        $('#area-compare-date').css('display', 'none');
        if (!$('#text-date-area-compare-date').hasClass('d-none')) {
            $('#text-date-area-compare-date').addClass('d-none');
        }
        $('#datepicker-previous').val('');
    });
    $('#btn-compare').on('click', function () {
        let datePrevious = $('#datepicker-previous').val();
        if (datePrevious == null || datePrevious == '') {
            $('#datepicker-previous').css('border', '2px solid red');
            setTimeout(function () {
                $('#datepicker-previous').css('border', '1px solid #ced4da');
            }, 3000);
            return;
        }
        let url = '{{ route("log.behavior.compare.date") }}';
        let app = $('#app-name').val();
        let country = $('#country').val();
        let platform = $('#platform').val();
        let network = $('#network').val();
        let install = $('#install').val();
        let dateSelected = date;
        let time = '';
        if (statusNowDate) {
            let real_time = $('#real-time').text();
            let split = real_time.split(" ");
            time = split[1];
        } else {
            time = '23:59:59';
        }
        if ($('#loader-previous-date').hasClass('hide')) {
            $('#loader-previous-date').removeClass('hide');
        }
        $.ajax({
            url: url,
            type: 'GET',
            data: {
                datePrevious: datePrevious,
                dateSelected: dateSelected,
                app: app,
                country: country,
                platform: platform,
                network: network,
                install: install,
                time: time
            }
        }).done(function (result) {
            for (var i in result) {
                $('#' + i).text(result[i]);
            }
            if (!$('#loader-previous-date').hasClass('hide')) {
                $('#loader-previous-date').addClass('hide');
            }
            if ($('#text-date-area-compare-date').hasClass('d-none')) {
                let setTime = '';
                if (statusNowDate) {
                    setTime = datePrevious + ' ' + time;
                } else {
                    setTime = datePrevious;
                }
                $('#text-date-area-compare-date').removeClass('d-none');
                $('#text-date-previous').text(setTime);
            }
            if ($("#area-compare-date").is(':hidden')) {
                $('#area-compare-date').css('display', 'flex');
            }
        });
    });
});

function addAppToList() {
    let country = $('#country-modal').val();
    let platform = $('#platform-modal').val();
    let app = $('#app-name-modal').val();
    let assigned = $('#assigned-modal').val();
    let url = '{{ route("log.behavior.save.app.in.checklist") }}';
    $.ajax({
        url: url,
        type: 'GET',
        data: {
            country: country,
            platform: platform,
            app: app,
            assigned: assigned
        }
    }).done(function (result) {
        if (result.status == true) {
            if (result.last_install == '') {
                result.last_install = 'Chưa có lượt cài mới';
            }
            let content = `<tr id="` + result.id_app_install + `">
                    <th scope="row">` + (result.count + 1) + `</th>
                    <td>` + result.app.replace(/^[a-z]/, function (m) {
                return m.toUpperCase()
            }) + `</td>
                    <td>` + result.country.replace(/^[a-z]/, function (m) {
                return m.toUpperCase()
            }) + `</td>
                    <td>` + result.platform.replace(/^[a-z]/, function (m) {
                return m.toUpperCase()
            }) + `</td>
                    <td>` + result.assigned + `</td>
                    <td>` + result.last_install + `</td>
                    <td class="d-flex align-items-center">
                    <button data-id="` + result.id_app_install + `" class="btn btn-danger delete-app-in-list-check"><i class="fa fa-trash"></i></button>
                    <button id="lock-` + result.id_app_install + `" data-id="` + result.id_app_install + `" title="Lock" data-lock="1" class="btn btn-warning lock-app-in-list-check"><i class="fa fa-bell-slash"></i></button>
                    <div id="loader-` + result.id_app_install + `" class="loader hide"></div>
                    </td>
                    </tr>`;
            $("#tbody-modal").append(content);
            $('.error-message-modal p').text('Ứng dụng thêm vào danh sách thành công!');
        } else {
            $('.error-message-modal p').text('Ứng dụng đã tồn tại trong danh sách!');
        }
        $('.error-message-modal').show();
        let interval = setInterval(function () {
            $('.error-message-modal').hide();
            clearInterval(interval);
        }, 3000);
    });
}

function searchAppInList() {
    let country = $('#country-search-modal').val();
    let platform = $('#platform-search-modal').val();
    let app = $('#app-name-search-modal').val();
    let assigned = $('#assigned-search-modal').val();
    let url = '/search-app-in-list-for-check';
    $.ajax({
        url: url,
        type: 'GET',
        data: {
            country: country,
            platform: platform,
            app: app,
            assigned: assigned
        }
    }).done(function (result) {
        $("#tbody-modal").empty();
        for (let i = 0; i < result.length; i++) {
            let content = `<tr id="` + result[i]._id + `">
                    <th scope="row">` + (i + 1) + `</th>
                    <td>` + result[i].app.replace(/^[a-z]/, function (m) {
                return m.toUpperCase()
            }) + `</td>
                    <td>` + result[i].country.replace(/^[a-z]/, function (m) {
                return m.toUpperCase()
            }) + `</td>
                    <td>` + result[i].platform.replace(/^[a-z]/, function (m) {
                return m.toUpperCase()
            }) + `</td>
                    <td>` + result[i].assigned + `</td>
                    <td>` + result[i].last_install + `</td>
                    <td class="d-flex align-items-center">
                    <button data-id="` + result[i]._id + `" class="btn btn-danger delete-app-in-list-check"><i class="fa fa-trash"></i></button>
                    <button id="lock-` + result[i]._id + `" data-id="` + result[i]._id + `" title="Lock" data-lock="1" class="btn btn-warning lock-app-in-list-check"><i class="fa fa-bell-slash"></i></button>
                    <div id="loader-` + result[i]._id + `" class="loader hide"></div>
                    </td>
                    </tr>`;
            $("#tbody-modal").append(content);
        }
    });
}

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        backToTop.style.display = "block";
    } else {
        backToTop.style.display = "none";
    }
}

function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}

function search() {
    var input, filter, ul, li, a, i, txtValue;
    input = document.getElementById("search-in-filter-modal");
    filter = input.value.toUpperCase();
    li = document.getElementById('ul-list-app-in-modal').getElementsByTagName("li");
    for (i = 0; i < li.length; i++) {
        a = li[i];
        txtValue = a.textContent || a.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
}

function getDataChart() {
    let url = '{{ route("log.behavior.chart") }}';
    let app = $('#app-name-report').val();
    let country = $('#country-report').val();
    let platform = $('#platform-report').val();
    let from = $('#datepicker-from').val();
    let to = $('#datepicker-to').val();
    let keyword = $('#keyword-report').val();
    $('#text-total-modal').css("display", "none");
    $("#pre-loader").attr("style", "display: block !important");
    if (chart != 'chart') {
        chart.destroy();
    }
    $.ajax({
        url: url,
        type: 'GET',
        data: {
            app: app,
            country: country,
            platform: platform,
            from: from,
            to: to,
            keyword: keyword,
        }
    }).done(function (result) {
        $("#pre-loader").attr("style", "display: none !important");
        $('#text-total-modal').css("display", "flex");
        let ctx = document.getElementById('countChart');
        const data = {
            labels: result['labels'],
            datasets: result['datasets']
        };
        chart = new Chart(ctx, {
            type: 'line',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        $('#sum-total').text(result['sum']['total']);
        $('#sum-success').text(result['sum']['send']);
    });
}

function searchActivity() {
    let url = '{{ route("log.behavior.activity.uid") }}';
    let uid = $('#uid-activity').val();
    $("#pre-loader-activity").attr("style", "display: block !important");
    $("#empty-result").attr("style", "display: none !important");
    $.ajax({
        url: url,
        type: 'GET',
        data: {
            uid: uid,
        }
    }).done(function (result) {
        $("#table-activity").empty();
        $("#pre-loader-activity").attr("style", "display: none !important");
        if (result.length == 0) {
            $("#empty-result").attr("style", "display: block !important");
        } else {
            for (let i = 0; i < result.length; i++) {
                let strAppend =
                    `<tr>
                        <td>` + result[i].date + `</td>
                        <td>` + result[i].message + `</td>
                        <td>` + result[i].data + `</td>
                    </tr>`;
                $("#table-activity").append(strAppend);
            }
        }
    });
}