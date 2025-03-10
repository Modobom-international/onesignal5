$(function () {
    // Remove custom modal implementation since we're using Flowbite

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
    // Smooth scroll to top
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
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

// Date comparison functionality
$(function () {
    // Initialize variables
    const comparisonModal = document.getElementById('modalDateComparison');
    const comparisonDate = $('#comparison-date');
    const comparisonLoader = $('#comparison-loader');
    const currentDateDisplay = $('#current-date-display');
    const compareBtn = $('#compare-date-btn');
    const closeModalBtn = $('[data-modal-hide="modalDateComparison"]');

    // Initialize Flowbite modal
    const modal = new Modal(comparisonModal, {
        placement: 'center',
        backdrop: 'dynamic',
        onHide: () => {
            resetComparisonData();
            // Ensure compare button is visible when modal is closed
            compareBtn.show();
        }
    });

    // Initialize datepicker for comparison with proper formatting
    comparisonDate.datepicker({
        dateFormat: "yy-mm-dd",
        maxDate: 0,
        beforeShowDay: function (date) {
            const currentDate = $('#datepicker').val();
            const dateString = $.datepicker.formatDate('yy-mm-dd', date);
            return [dateString !== currentDate, '', 'Không thể chọn ngày này'];
        }
    });

    // Show modal when clicking compare button
    compareBtn.on('click', function (e) {
        e.preventDefault();
        const currentDate = $('#datepicker').val();
        if (!currentDate) {
            showError('{{ __("Vui lòng chọn ngày để so sánh") }}');
            return;
        }

        // Format and display current date
        const formattedDate = formatDate(currentDate);
        currentDateDisplay.text(formattedDate);

        // Show modal
        modal.show();
    });

    // Close modal handler
    closeModalBtn.on('click', function () {
        modal.hide();
    });

    // Handle date comparison
    $('#compare-dates').on('click', function () {
        const selectedDate = comparisonDate.val();
        const currentDate = $('#datepicker').val();

        // Validate dates
        if (!selectedDate) {
            comparisonDate.addClass('border-red-500');
            showError('{{ __("Vui lòng chọn ngày để so sánh") }}');
            setTimeout(() => {
                comparisonDate.removeClass('border-red-500');
            }, 3000);
            return;
        }

        if (selectedDate === currentDate) {
            showError('{{ __("Không thể so sánh cùng một ngày") }}');
            return;
        }

        // Show loader and make AJAX request
        comparisonLoader.removeClass('hidden');

        $.ajax({
            url: '/admin/log-behavior/compare-date',
            type: 'GET',
            data: {
                datePrevious: selectedDate,
                dateSelected: currentDate,
                app: $('#app-name').val() || 'all',
                country: $('#country').val() || 'all',
                platform: $('#platform').val() || 'all',
                network: $('#network').val() || 'all',
                install: $('#install').val() || 'all',
                time: getCurrentTime()
            },
            success: function (response) {
                updateComparisonData(response);
            },
            error: function (error) {
                console.error('Comparison failed:', error);
                showError('{{ __("Có lỗi xảy ra khi so sánh dữ liệu") }}');
            },
            complete: function () {
                comparisonLoader.addClass('hidden');
            }
        });
    });

    // Helper function to format date
    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('vi-VN', {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit'
        });
    }

    // Helper function to get current time
    function getCurrentTime() {
        const now = new Date();
        return now.getHours() + ':' +
            String(now.getMinutes()).padStart(2, '0') + ':' +
            String(now.getSeconds()).padStart(2, '0');
    }

    // Update comparison data in the UI
    function updateComparisonData(data) {
        if (!data) return;

        // Update current date stats
        $('#current-total-installs').text(data.current?.total || '0');
        $('#current-success-installs').text(data.current?.success || '0');
        $('#current-wrong-country').text(data.current?.wrong_country || '0');
        $('#current-wrong-network').text(data.current?.wrong_network || '0');

        // Update comparison date stats
        $('#comparison-total-installs').text(data.comparison?.total || '0');
        $('#comparison-success-installs').text(data.comparison?.success || '0');
        $('#comparison-wrong-country').text(data.comparison?.wrong_country || '0');
        $('#comparison-wrong-network').text(data.comparison?.wrong_network || '0');
    }

    // Reset comparison data
    function resetComparisonData() {
        comparisonDate.val('');
        const elements = [
            'current-total-installs', 'current-success-installs', 'current-wrong-country', 'current-wrong-network',
            'comparison-total-installs', 'comparison-success-installs', 'comparison-wrong-country', 'comparison-wrong-network'
        ];
        elements.forEach(id => $(`#${id}`).text('-'));
    }

    // Show error message
    function showError(message) {
        // Remove any existing error messages first
        $('.error-message-floating').remove();

        const errorDiv = $('<div>')
            .addClass('error-message-floating fixed bottom-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-lg z-50')
            .text(message);

        $('body').append(errorDiv);
        setTimeout(() => errorDiv.remove(), 3000);
    }
});
