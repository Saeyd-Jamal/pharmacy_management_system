<?php


// dashboard routes


use App\Http\Controllers\Dashboard\ActivityLogController;
use App\Http\Controllers\Dashboard\CategoryConrtoller;
use App\Http\Controllers\Dashboard\ConstantController;
use App\Http\Controllers\Dashboard\CurrencyController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\MedicineConrtoller;
use App\Http\Controllers\Dashboard\PurchaseInvoiceConrtoller;
use App\Http\Controllers\Dashboard\PurchaseInvoiceItemConrtoller;
use App\Http\Controllers\Dashboard\ReportController;
use App\Http\Controllers\Dashboard\SaleInvoiceConrtoller;
use App\Http\Controllers\Dashboard\SupplierConrtoller;
use App\Http\Controllers\Dashboard\UserController;
use App\Models\SaleInvoiceItem;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => '',
    'middleware' => ['auth'],
    'as' => 'dashboard.'
], function () {
    /* ********************************************************** */ 

    // Dashboard ************************
    Route::get('/', [HomeController::class,'index'])->name('home');

    // Logs ************************
    Route::get('logs',[ActivityLogController::class,'index'])->name('logs.index');
    Route::get('getLogs',[ActivityLogController::class,'getLogs'])->name('logs.getLogs');

    // users ************************
    Route::get('profile/settings',[UserController::class,'settings'])->name('profile.settings');

    // reports ************************
    Route::get('report', [ReportController::class,'index'])->name('report.index');
    Route::post('report/export', [ReportController::class,'export'])->name('report.export');

    /* ********************************************************** */ 
    Route::get('medicines/search', [MedicineConrtoller::class,'search'])->name('medicines.search');

    Route::post('purchaseInvoices/print', [PurchaseInvoiceConrtoller::class,'show'])->name('purchaseInvoices.print');


    /* ********************************************************** */

    // Resources

    Route::resource('constants', ConstantController::class)->only(['index','store','destroy']);
    Route::resource('currencies', CurrencyController::class)->except(['show','edit','create']);

    Route::resources([
        'users' => UserController::class,
        'suppliers' => SupplierConrtoller::class,
        'categories' => CategoryConrtoller::class,
        'medicines' => MedicineConrtoller::class,
        'purchaseInvoices' => PurchaseInvoiceConrtoller::class,
        'salesInvoices' => SaleInvoiceConrtoller::class,
    ]);
    /* ********************************************************** */ 
});