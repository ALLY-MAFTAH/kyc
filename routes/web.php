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

    Route::get('/all-markets', [MarketController::class, 'index'])->name('markets.index');
    Route::get('/show-market/{market}', [MarketController::class, 'showMarket'])->name('markets.show');
    Route::post('/add-market', [MarketController::class, 'postMarket'])->name('markets.add');
    Route::post('/add-manager/{market}', [MarketController::class, 'addManager'])->name('markets.add_manager');
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
    Route::post('/renew_frame', [FrameController::class, 'renewFrame'])->name('frames.renew_frame');
    Route::put('/edit-frame/{frame}', [FrameController::class, 'putFrame'])->name('frames.edit');
    Route::delete('/delete-frame/{frame}', [FrameController::class, 'deleteFrame'])->name('frames.delete');

    // STALLS ROUTES
    Route::get('/stalls', [StallController::class, 'index'])->name('stalls.index');
    Route::get('/show-stall/{stall}', [StallController::class, 'showStall'])->name('stalls.show');
    Route::post('/add-stall', [StallController::class, 'postStall'])->name('stalls.add');
    Route::post('/renew_stall', [StallController::class, 'renewStall'])->name('stalls.renew_stall');
    Route::put('/edit-stall/{stall}', [StallController::class, 'putStall'])->name('stalls.edit');
    Route::delete('/delete-stall/{stall}', [StallController::class, 'deleteStall'])->name('stalls.delete');

    // CUSTOMERS ROUTES
    Route::get('/all-customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/show-customer-admin-view/{customer}', [CustomerController::class, 'showCustomerAdminView'])->name('customers.admin_show');
    Route::get('/show-customer/{customer}/{marketId}', [CustomerController::class, 'showCustomer'])->name('customers.show');
    Route::post('/add-customer', [CustomerController::class, 'postCustomer'])->name('customers.add');
    Route::put('/edit-customer/{customer}', [CustomerController::class, 'putCustomer'])->name('customers.edit');
    Route::delete('/delete-customer/{customer}', [CustomerController::class, 'deleteCustomer'])->name('customers.delete');
    Route::post('/add-customer-to-market/{market}', [CustomerController::class, 'addCustomerToMarket'])->name('customers.add_to_market');
    Route::post('/remove-customer-from-market/{customer}', [CustomerController::class, 'removeCustomerFromMarket'])->name('customers.remove_from_market');
    Route::post('/attach-frame/{customer}', [CustomerController::class, 'attachFrame'])->name('customers.attach_frame');
    Route::get('/detach-frame/{customer}/{frameId}', [CustomerController::class, 'detachFrame'])->name('customers.detach_frame');
    Route::post('/attach-stall/{customer}', [CustomerController::class, 'attachStall'])->name('customers.attach_stall');
    Route::get('/detach-stall/{customer}/{stallId}', [CustomerController::class, 'detachStall'])->name('customers.detach_stall');
    Route::post('send-message/{customer}', [CustomerController::class, 'sendMessage'])->name('send-message');

    // PAYMENTS ROUTES
    Route::get('/all-payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/manager-view-payments', [PaymentController::class, 'managerIndex'])->name('payments.manager_index');
    Route::get('/show-payment/{payment}', [PaymentController::class, 'showPayment'])->name('payments.show');
    Route::post('/add-payment', [PaymentController::class, 'postPayment'])->name('payments.add');
    Route::put('/edit-payment/{payment}', [PaymentController::class, 'putPayment'])->name('payments.edit');
    Route::delete('/delete-payment/{payment}', [PaymentController::class, 'deletePayment'])->name('payments.delete');

    // USERS ROUTES
    Route::get('/all-users', [UserController::class, 'index'])->name('users.index');
    Route::get('/show-user/{user}', [UserController::class, 'showUser'])->name('users.show');
    Route::post('/add-user', [UserController::class, 'addUser'])->name('users.add');
    Route::post('/post-user', [UserController::class, 'postUser'])->name('users.post');
    Route::put('/edit-user/{user}', [UserController::class, 'putUser'])->name('users.edit');
    Route::delete('/delete-user/{user}', [UserController::class, 'deleteUser'])->name('users.delete');
    Route::put('/toggle-status/{user}/status', [UserController::class, 'toggleStatus'])->name('users.toggle_status');
    Route::put('/change-password', [UserController::class, 'changePassword'])->name('users.change_password');

    // REPORTS ROUTES
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/markets-report', [ReportController::class, 'marketsReport'])->name('reports.markets');
    Route::get('/customers-report', [ReportController::class, 'customersReport'])->name('reports.customers');
    Route::get('/payments-report', [ReportController::class, 'paymentsReport'])->name('reports.payments');
    Route::get('/frame-stall-report', [ReportController::class, 'customerPaymentsReport'])->name('reports.frame_stall');

    Route::get('/generate-markets-report', [ReportController::class, 'generateMarketsReport'])->name('reports.generate_markets_report');
    Route::get('/generate-customers-report', [ReportController::class, 'generateCustomersReport'])->name('reports.generate_customers_report');
    Route::get('/generate-payments-report', [ReportController::class, 'generatePaymentsReport'])->name('reports.generate_payments_report');
    Route::get('/generate-frame-stall-report', [ReportController::class, 'generateFrameStallReport'])->name('reports.generate_frame_stall_report');

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
});
