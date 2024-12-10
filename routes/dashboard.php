<?php

use App\Http\Controllers\admin\TenantController;
use App\Http\Controllers\dashboard\UesrController;
use App\Http\Controllers\dashboard\DashboardController;
use App\Http\Controllers\dashboard\inventory\CategoryController;
use App\Http\Controllers\dashboard\inventory\InventoryLogController;
use App\Http\Controllers\dashboard\inventory\LowStockNotificationController;
use App\Http\Controllers\dashboard\inventory\ProductController;
use App\Http\Controllers\dashboard\inventory\SubcategoryController;
use App\Http\Controllers\dashboard\inventory\SupplierController;
use App\Http\Controllers\dashboard\roles_permissions\PermissionController;
use App\Http\Controllers\dashboard\roles_permissions\RoleController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

define('PAGINATE', 10);

Route::middleware('auth')->group(function () {
    Route::fallback(function () {
        return response()->view('errors.404', [], 404);
    });

    // Admin routes
    Route::group(['middleware' => 'check.admin'], function () {
        Route::get('tenants', [TenantController::class, 'index'])->name('admin.tenants.index');
        Route::get('tenants/{id}/show', [TenantController::class, 'show'])->name('admin.tenants.show');
        Route::get('tenants/create', [TenantController::class, 'create'])->name('admin.tenants.create');
        Route::post('tenants/store', [TenantController::class, 'store'])->name('admin.tenants.store');
        Route::delete('tenants/destroy/{id}', [TenantController::class, 'destroy'])->name('admin.tenants.destroy');
        Route::get('tenants/edit/{id}', [TenantController::class, 'edit'])->name('admin.tenants.edit');
        Route::put('tenants/update/{id}', [TenantController::class, 'update'])->name('admin.tenants.update');
    });

    // Profile
    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile/{id}/update', [ProfileController::class, 'update'])->name('profile.update');

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // ./Users & Permissions

    // Users
    Route::resource('users', UesrController::class);

    // Roles
    Route::resource('roles', RoleController::class);

    // Permissions
    Route::put('permissions/update', [PermissionController::class, 'update'])->name('permissions.update');
    Route::resource('permissions', PermissionController::class)->except(['update']);

    // ./Users & Permissions

    // Inventory

    // Suppliers
    Route::resource('inventory/suppliers', SupplierController::class);

    // Categories
    Route::resource('inventory/categories', CategoryController::class);

    // Subcategories
    Route::resource('inventory/subcategories', SubcategoryController::class);

    // Products
    Route::resource('inventory/products', ProductController::class);
    Route::post('inventory/products/search', [ProductController::class, 'search'])->name('products.search');

    // Inventory logs
    Route::get('inventory/logs', [InventoryLogController::class, 'index'])->name('inventory.logs.index');
    Route::get('inventory/logs/{id}/edit', [InventoryLogController::class, 'edit'])->name('inventory.logs.edit');
    Route::put('inventory/logs/{id}/update', [InventoryLogController::class, 'update'])->name('inventory.logs.update');

    // Low stock notification
    Route::get('inventory/low/stock', [LowStockNotificationController::class, 'index'])->name('low.stock.index');
    Route::delete('inventory/low/stock/{id}', [LowStockNotificationController::class, 'destroy'])->name('low.stock.destroy');


    // ./Inventory


    

});
