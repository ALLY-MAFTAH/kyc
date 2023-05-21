<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::middleware(['auth'])->group(function () {

    Route::get('/', [HomeController::class, 'index']);
    Route::get('/home', [HomeController::class, 'index'])->name('home');


    // MARKETS ROUTES
    Route::get('/markets', [MarketController::class, 'index'])->name('markets.index');
    Route::get('/show-market/{market}', [MarketController::class, 'showMarket'])->name('markets.show');
    Route::post('/add-market', [MarketController::class, 'postMarket'])->name('markets.add');
    Route::put('/edit-market/{market}', [MarketController::class, 'putMarket'])->name('markets.edit');
    Route::delete('/delete-market/{market}', [MarketController::class, 'deleteMarket'])->name('markets.delete');

    // SECTIONS ROUTES
    Route::get('/sections', [SectionController::class, 'index'])->name('sections.index');
    Route::get('/show-section/{section}', [SectionController::class, 'putSection'])->name('sections.show');
    Route::post('/add-section', [SectionController::class, 'postSection'])->name('sections.add');
    Route::put('/edit-section/{section}', [SectionController::class, 'putSection'])->name('sections.edit');
    Route::delete('/delete-section/{section}', [SectionController::class, 'deleteSection'])->name('sections.delete');

    // FRAMES ROUTES
    Route::get('/frames', [FrameController::class, 'index'])->name('frames.index');
    Route::get('/show-frame/{frame}', [FrameController::class, 'showFrame'])->name('frames.show');
    Route::post('/add-frame', [FrameController::class, 'postFrame'])->name('frames.add');
    Route::put('/edit-frame/{frame}', [FrameController::class, 'putFrame'])->name('frames.edit');
    Route::delete('/delete-frame/{frame}', [FrameController::class, 'deleteFrame'])->name('frames.delete');

    // CAGES ROUTES
    Route::get('/cages', [CageController::class, 'index'])->name('cages.index');
    Route::get('/show-cage/{cage}', [CageController::class, 'showCage'])->name('cages.show');
    Route::post('/add-cage', [CageController::class, 'postCage'])->name('cages.add');
    Route::put('/edit-cage/{cage}', [CageController::class, 'putCage'])->name('cages.edit');
    Route::delete('/delete-cage/{cage}', [CageController::class, 'deleteCage'])->name('cages.delete');

    // CUSTOMERS ROUTES
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/show-customer/{customer}/{marketId}', [CustomerController::class, 'showCustomer'])->name('customers.show');
    Route::post('/add-customer', [CustomerController::class, 'postCustomer'])->name('customers.add');
    Route::put('/edit-customer/{customer}', [CustomerController::class, 'putCustomer'])->name('customers.edit');
    Route::delete('/delete-customer/{customer}', [CustomerController::class, 'deleteCustomer'])->name('customers.delete');
    Route::post('/add-customer-to-market/{market}', [CustomerController::class, 'addCustomerToMarket'])->name('customers.add_to_market');
    Route::post('/remove-customer-from-market/{customer}', [CustomerController::class, 'removeCustomerFromMarket'])->name('customers.remove_from_market');
    Route::post('/attach-frame/{customer}', [CustomerController::class, 'attachFrame'])->name('customers.attach_frame');
    Route::get('/detach-frame/{customer}/{frameId}', [CustomerController::class, 'detachFrame'])->name('customers.detach_frame');
    Route::post('/attach-cage/{customer}', [CustomerController::class, 'attachCage'])->name('customers.attach_cage');
    Route::get('/detach-cage/{customer}/{cageId}', [CustomerController::class, 'detachCage'])->name('customers.detach_cage');

    // PAYMENTS ROUTES
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/show-payment/{payment}', [PaymentController::class, 'showPayment'])->name('payments.show');
    Route::post('/add-payment', [PaymentController::class, 'postPayment'])->name('payments.add');
    Route::put('/edit-payment/{payment}', [PaymentController::class, 'putPayment'])->name('payments.edit');
    Route::delete('/delete-payment/{payment}', [PaymentController::class, 'deletePayment'])->name('payments.delete');

    // USERS ROUTES
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/show-user/{user}', [UserController::class, 'showUser'])->name('users.show');
    Route::post('/add-user', [UserController::class, 'postUser'])->name('users.add');
    Route::put('/edit-user/{user}', [UserController::class, 'putUser'])->name('users.edit');
    Route::delete('/delete-user/{user}', [UserController::class, 'deleteUser'])->name('users.delete');

    // REPORTS ROUTES
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/show-report/{report}', [ReportController::class, 'showReport'])->name('reports.show');
    Route::post('/add-report', [ReportController::class, 'postReport'])->name('reports.add');
    Route::put('/edit-report/{report}', [ReportController::class, 'putReport'])->name('reports.edit');
    Route::delete('/delete-report/{report}', [ReportController::class, 'deleteReport'])->name('reports.delete');

    // SETTINGS ROUTES
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::get('/show-setting/{setting}', [SettingController::class, 'showSetting'])->name('settings.show');
    Route::post('/add-setting', [SettingController::class, 'postSetting'])->name('settings.add');
    Route::put('/edit-setting/{setting}', [SettingController::class, 'putSetting'])->name('settings.edit');
    Route::delete('/delete-setting/{setting}', [SettingController::class, 'deleteSetting'])->name('settings.delete');

    // MESSAGES ROUTES
    Route::post('send-message', [MessageController::class, 'sendMessage'])->name('send-message');
});
