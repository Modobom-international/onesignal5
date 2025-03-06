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
use App\Http\Controllers\HtmlSourceController;
use App\Http\Controllers\UsersTrackingController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\DomainController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LogBehaviorController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\ShareGlobalVariable;

require __DIR__ . '/auth.php';

Route::get('/', [HomeController::class, 'welcome'])->name('welcome');

Route::prefix('config-link')->group(function () {
    Route::post('/save', [PushSystemController::class, 'saveConfigSystemLink'])->name('saveConfigSystemLink');
    Route::post('/update/{id}', [PushSystemController::class, 'updateConfigSystemLinkItem'])->name('updateConfigSystemLink');
    Route::get('/get-current-push-count-ajax', [PushSystemController::class, 'getCurrentPushCountAjax'])->name('getCurrentPushCountAjax');
});

Route::get('/get-push-system-config', [PushSystemController::class, 'getSettings'])->name('pushSystemGetSettings');
Route::post('/add-user-active-push-system', [PushSystemController::class, 'addUserActive'])->name('addUserActivePushSystem');
Route::post('/save-status-link', [PushSystemController::class, 'saveStatusLink'])->name('saveStatusLink');
Route::post('/push-system/save-config-links', [PushSystemController::class, 'saveConfigLinksPush'])->name('PushSystemSaveConfigLinksPush');
Route::post('/push-system', [PushSystemController::class, 'saveData'])->name('saveData');
Route::post('/create-log-behavior', [LogBehaviorController::class, 'logBehavior'])->name('logBehavior');
Route::post('/create-users-tracking', [UsersTrackingController::class, 'store']);
Route::post('/save-html-source', [HtmlSourceController::class, 'saveHtml'])->name('saveHtml');

Route::middleware(Authenticate::class)->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard')->middleware(ShareGlobalVariable::class);
    Route::get('/fetch-horizon-dashboard', [AdminController::class, 'fetchHorizonDashboard'])->name('fetchHorizonDashboard');
    Route::get('/change-status-notification', [AdminController::class, 'changeStatusNotification'])->name('changeStatusNotification');
    Route::get('/lang/{locale}', [AdminController::class, 'setLocale'])->name('lang.switch');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit')->middleware(ShareGlobalVariable::class);
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Route after this comment for permission. Only if route has more prefix. etc prefix push-system ....
    Route::prefix('push-system')->group(function () {
        Route::get('/', [PushSystemController::class, 'listPushSystem'])->name('push.system.list')->middleware(ShareGlobalVariable::class);
        Route::get('/config-link/add', [PushSystemController::class, 'addConfigSystemLink'])->name('push.system.config.link');
        Route::get('/list-user-active', [PushSystemController::class, 'listUserActiveAjax'])->name('push.system.list.user.active.ajax');
        Route::get('/show-config-links', [PushSystemController::class, 'showConfigLinksPush'])->name('push.system.show.config.link');
        Route::get('/config-links', [PushSystemController::class, 'configLinksPush'])->name('push.system.edit.config.link');
    });

    Route::prefix('log-behavior')->group(function () {
        Route::get('/', [LogBehaviorController::class, 'viewLogBehavior'])->name('log.behavior.list')->middleware(ShareGlobalVariable::class);
        Route::get('/get-data-chart', [LogBehaviorController::class, 'getDataChartLogBehavior'])->name('log.behavior.chart');
        Route::get('/store-config-filter', [LogBehaviorController::class, 'storeConfigFilterLogBehavior'])->name('log.behavior.store.config.filter');
        Route::get('/reset-config-filter', [LogBehaviorController::class, 'resetConfigFilterLogBehavior'])->name('log.behavior.reset.config.filter');
        Route::get('/compare-date', [LogBehaviorController::class, 'compareDate'])->name('log.behavior.compare.date');
        Route::get('/save-list-app-for-check', [LogBehaviorController::class, 'saveListAppForCheck'])->name('log.behavior.save.app.in.checklist');
        Route::get('/delete-app-in-list-for-check', [LogBehaviorController::class, 'deleteAppInListForCheck'])->name('log.behavior.delete.app.in.checklist');
        Route::get('/get-activity-uid', [LogBehaviorController::class, 'getActivityUid'])->name('log.behavior.activity.uid');
    });

    Route::prefix('users')->group(function () {
        Route::get('/', [UsersController::class, 'index'])->name('users.list')->middleware(ShareGlobalVariable::class);
        Route::get('/create', [UsersController::class, 'create'])->name('users.create')->middleware(ShareGlobalVariable::class);
        Route::get('/edit/{id}', [UsersController::class, 'edit'])->name('users.edit')->middleware(ShareGlobalVariable::class);
        Route::post('/update/{id}', [UsersController::class, 'update'])->name('users.update');
        Route::post('/store', [UsersController::class, 'store'])->name('users.store');
        Route::get('/delete/{id}', [UsersController::class, 'destroy'])->name('users.delete');
    });

    Route::prefix('domain')->group(function () {
        Route::get('/', [DomainController::class, 'listDomain'])->name('domain.list')->middleware(ShareGlobalVariable::class);
        Route::get('/create', [DomainController::class, 'createDomain'])->name('domain.create')->middleware(ShareGlobalVariable::class);
        Route::get('/check', [DomainController::class, 'checkDomain'])->name('domain.check');
        Route::get('/up', [DomainController::class, 'upDomain'])->name('domain.up');
        Route::get('/search', [DomainController::class, 'searchDomain'])->name('domain.search');
        Route::get('/delete', [DomainController::class, 'deleteDomain'])->name('domain.delete');
    });

    Route::prefix('html-source')->group(function () {
        Route::get('/', [HtmlSourceController::class, 'listHtmlSource'])->name('html.source.list')->middleware(ShareGlobalVariable::class);
        Route::get('/{id}', [HtmlSourceController::class, 'showHtmlSource'])->name('html.source.show');
    });

    Route::prefix('users-tracking')->group(function () {
        Route::get('/', [UsersTrackingController::class, 'viewUsersTracking'])->name('users.tracking.list')->middleware(ShareGlobalVariable::class);
        Route::get('/get-detail-tracking', [UsersTrackingController::class, 'getDetailTracking'])->name('users.tracking.detail');
        Route::get('/get-heat-map', [UsersTrackingController::class, 'getHeatMap'])->name('users.tracking.heat.map');
        Route::get('/get-link-for-heat-map', [UsersTrackingController::class, 'getLinkForHeatMap'])->name('users.tracking.link.heat.map');
    });

    Route::prefix('team')->group(function () {
        Route::get('/', [TeamController::class, 'index'])->name('team.list')->middleware(ShareGlobalVariable::class);
        Route::get('/create', [TeamController::class, 'create'])->name('team.create')->middleware(ShareGlobalVariable::class);
        Route::post('/store', [TeamController::class, 'store'])->name('team.store');
        Route::get('/update/{id}', [TeamController::class, 'update'])->name('team.update');
        Route::get('/edit/{id}', [TeamController::class, 'edit'])->name('team.edit');
        Route::get('/delete/{id}', [TeamController::class, 'destroy'])->name('team.delete');
    });
});
