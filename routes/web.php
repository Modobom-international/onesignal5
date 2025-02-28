<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PushSystemController;
use App\Http\Controllers\PushSystemGlobalController;
use App\Http\Controllers\HtmlSourceController;
use App\Http\Controllers\UsersTrackingController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\DomainController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LogBehaviorController;

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\ShareGlobalVariable;

require __DIR__ . '/auth.php';

Route::get('/', [HomeController::class, 'welcome'])->name('welcome');

Route::prefix('push-system-global')->group(function () {
    Route::get('/get-push-system-config-global', [PushSystemGlobalController::class, 'getSettingsGlobal'])->name('pushSystemGlobalGetSettings');
    Route::post('/save', [PushSystemGlobalController::class, 'saveSystemGlobal'])->name('saveSystemGlobal');
    Route::get('/list-data-global', [PushSystemGlobalController::class, 'listPushSystemGlobal'])->name('listPushSystemGlobal');
    Route::get('/list-user-active-global', [PushSystemGlobalController::class, 'listUserActiveGlobalAjax'])->name('listUserActiveGlobalAjax');
    Route::get('/show-config-push-system-global', [PushSystemGlobalController::class, 'showConfigGlobal'])->name('showConfigGlobal');
    Route::post('/save-system-config', [PushSystemGlobalController::class, 'saveSystemConfigGlobal'])->name('saveSystemConfigGlobal');
    Route::get('/add-link-system-global', [PushSystemGlobalController::class, 'addLinkSystemGlobal'])->name('addLinkSystemGlobal');
    Route::post('/add-user-active-push-system-global', [PushSystemGlobalController::class, 'addUserActiveGlobal'])->name('addUserActivePushSystemGlobal');
});

Route::prefix('config-link')->group(function () {
    Route::post('/save', [PushSystemController::class, 'saveConfigSystemLink'])->name('saveConfigSystemLink');
    Route::post('/update/{id}', [PushSystemController::class, 'updateConfigSystemLinkItem'])->name('updateConfigSystemLink');
    Route::get('/get-current-push-count-ajax', [PushSystemController::class, 'getCurrentPushCountAjax'])->name('getCurrentPushCountAjax');
});

Route::post('/push-system', [PushSystemController::class, 'saveData'])->name('saveData');
Route::get('/get-push-system-config', [PushSystemController::class, 'getSettings'])->name('pushSystemGetSettings');
Route::get('/list-user-active', [PushSystemController::class, 'listUserActiveAjax'])->name('listUserActiveAjax');
Route::get('/push-system/show-config-links', [PushSystemController::class, 'showConfigLinksPush'])->name('PushSystemShowConfigLinksPush');
Route::get('/push-system/config-links', [PushSystemController::class, 'configLinksPush'])->name('PushSystemConfigLinksPush');
Route::post('/push-system/save-config-links', [PushSystemController::class, 'saveConfigLinksPush'])->name('PushSystemSaveConfigLinksPush');
Route::post('/add-user-active-push-system', [PushSystemController::class, 'addUserActive'])->name('addUserActivePushSystem');
Route::post('/save-status-link', [PushSystemController::class, 'saveStatusLink'])->name('saveStatusLink');

Route::get('/apk/load-web', [HomeController::class, 'apkLoadWeb'])->name('apkLoadWeb');
Route::get('/apk/load-web-count', [HomeController::class, 'apkLoadWebCount'])->name('apkLoadWebCount');
Route::get('/apk/load-web-count-diff', [HomeController::class, 'apkLoadWebCountDiff'])->name('apkLoadWebCountDiff');

Route::post('/create-log-behavior', [LogBehaviorController::class, 'logBehavior'])->name('logBehavior');
Route::post('/create-users-tracking', [UsersTrackingController::class, 'store']);
Route::post('/save-html-source', [HtmlSourceController::class, 'saveHtml'])->name('saveHtml');

Route::middleware(Authenticate::class, IsAdmin::class)->prefix('admin')->group(function () {
    Route::group(['middleware' => ['auth', 'role_or_permission:super-admin|check-log-count-data|manager-file']], function () {
        Route::get('/', [AdminController::class, 'index'])->name('dashboard')->middleware(ShareGlobalVariable::class);

        Route::get('/log-behavior', [LogBehaviorController::class, 'viewLogBehavior'])->name('viewLogBehavior')->middleware(ShareGlobalVariable::class);
        Route::get('/get-data-chart-log-behavior', [LogBehaviorController::class, 'getDataChartLogBehavior'])->name('getDataChartLogBehavior');
        Route::get('/store-config-filter-log-behavior', [LogBehaviorController::class, 'storeConfigFilterLogBehavior'])->name('storeConfigFilterLogBehavior');
        Route::get('/reset-config-filter-log-behavior', [LogBehaviorController::class, 'resetConfigFilterLogBehavior'])->name('resetConfigFilterLogBehavior');
        Route::get('/compare-date', [LogBehaviorController::class, 'compareDate'])->name('compareDate');
        Route::get('/save-list-app-for-check', [LogBehaviorController::class, 'saveListAppForCheck'])->name('saveListAppForCheck');
        Route::get('/delete-app-in-list-for-check', [LogBehaviorController::class, 'deleteAppInListForCheck'])->name('deleteAppInListForCheck');
        Route::get('/get-activity-uid', [LogBehaviorController::class, 'getActivityUid'])->name('getActivityUid');

        Route::get('/push-system', [PushSystemController::class, 'listPushSystem'])->name('listPushSystem')->middleware(ShareGlobalVariable::class);
        Route::get('/config-link/add', [PushSystemController::class, 'addConfigSystemLink'])->name('addConfigSystemLink');
    });

    Route::group(['middleware' => ['role:super-admin']], function () {
        Route::resource('users', UsersController::class)->name('index', 'list.users')->middleware(ShareGlobalVariable::class);
        Route::get('/change-password-user/{id}', [UsersController::class, 'changePasswordUser'])->name('changePasswordUser')->middleware(ShareGlobalVariable::class);
        Route::post('/update-password-user/{id}', [UsersController::class, 'updatePasswordUser'])->name('updatePasswordUser');
        Route::get('/change-password', [UsersController::class, 'changePassword'])->name('changePassword')->middleware(ShareGlobalVariable::class);
        Route::post('/update-password', [UsersController::class, 'updatePassword'])->name('updatePassword');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit')->middleware(ShareGlobalVariable::class);
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/fetch-horizon-dashboard', [AdminController::class, 'fetchHorizonDashboard'])->name('fetchHorizonDashboard');
    Route::resource('roles', RolesController::class);
    Route::resource('permissions', PermissionsController::class);

    Route::get('/html-source', [HtmlSourceController::class, 'listHtmlSource'])->name('listHtmlSource')->middleware(ShareGlobalVariable::class);
    Route::get('/html-source/{id}', [HtmlSourceController::class, 'showHtmlSource'])->name('showHtmlSource');

    Route::get('/users-tracking', [UsersTrackingController::class, 'viewUsersTracking'])->name('viewUsersTracking')->middleware(ShareGlobalVariable::class);
    Route::get('/get-detail-tracking', [UsersTrackingController::class, 'getDetailTracking'])->name('getDetailTracking');
    Route::get('/get-heat-map', [UsersTrackingController::class, 'getHeatMap'])->name('getHeatMap');
    Route::get('/get-link-for-heat-map', [UsersTrackingController::class, 'getLinkForHeatMap'])->name('getLinkForHeatMap');

    Route::get('/list-domain', [DomainController::class, 'listDomain'])->name('listDomain')->middleware(ShareGlobalVariable::class);
    Route::get('/create-domain', [DomainController::class, 'createDomain'])->name('domain.create')->middleware(ShareGlobalVariable::class);
    Route::get('/check-domain', [DomainController::class, 'checkDomain'])->name('domain.check');
    Route::get('/up-domain', [DomainController::class, 'upDomain'])->name('domain.up');
    Route::get('/search-domain', [DomainController::class, 'searchDomain'])->name('domain.search');
    Route::get('/delete-domain', [DomainController::class, 'deleteDomain'])->name('domain.delete');

    Route::get('/change-status-notification', [AdminController::class, 'changeStatusNotification'])->name('changeStatusNotification');
});
