<?php

use App\Http\Controllers\pos\CustomerController;
use App\Http\Controllers\pos\HomeController;
use App\Http\Controllers\pos\OrderController;
use App\Http\Controllers\pos\ProductController;
use App\Http\Controllers\pos\ReportController;
use App\Http\Controllers\pos\SalesController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

Route::group(['prefix' => 'pos', 'middleware' => 'auth'], function () {

    Route::group(['middleware' => 'pos.check.tenant'], function () {
        Route::get('/', [HomeController::class, 'index'])->name('pos.home');
        Route::get('sales', [SalesController::class, 'index'])->name('pos.sales');
        Route::post('sales/search-product', [SalesController::class, 'searchProduct'])->name('pos.sales.searchProduct');
        Route::post('sales/addToSession', [SalesController::class, 'addToSession'])->name('pos.sales.addToSession');
        Route::post('sales/removeItemSession', [SalesController::class, 'removeItemSession'])->name('pos.sales.removeItemSession');
        Route::post('sales/updateQuantity', [SalesController::class, 'updateQuantity'])->name('pos.sales.updateQuantity');


        Route::post('order/checkout', [OrderController::class, 'checkout'])->name('pos.sales.checkout');
        Route::get('orders', [OrderController::class, 'index'])->name('pos.orders');
        Route::get('orders/show/{id}', [OrderController::class, 'show'])->name('pos.orders.show');
        Route::get('orders/return/{id}', [OrderController::class, 'get_return'])->name('pos.orders.get_return');
        Route::post('orders/return/{id}', [OrderController::class, 'return'])->name('pos.orders.return');
        Route::post('orders/filter', [OrderController::class, 'filter'])->name('pos.orders.filter');


        Route::post('customer', [CustomerController::class, 'store'])->name('pos.customer.store');
        Route::post('customer/search', [CustomerController::class, 'search'])->name('pos.customer.search');

        Route::get('products/mainCategories', [ProductController::class, 'mainCategories'])->name('pos.products.mainCategories');
        Route::get('products/subcategories/{id}', [ProductController::class, 'subcategories'])->name('pos.products.subcategories');
        Route::get('products/{id}', [ProductController::class, 'products'])->name('pos.products');


        // Reports
        Route::get('reports', [ReportController::class, 'index'])->name('pos.reports');
        Route::post('reports/generate-sales-report', [ReportController::class, 'SalesReport'])->name('pos.reports.sales_reports');
        Route::post('reports/top-selling', [ReportController::class, 'topSellingProducts'])->name('pos.reports.top_selling');
        Route::post('reports/top-customers', [ReportController::class, 'topCustomers'])->name('pos.reports.top_customers');
        
    });
});
