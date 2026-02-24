<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JournalEntryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Inventory Management System routes.
| All routes are public (no auth) for simplicity.
|
*/

// ── Dashboard ─────────────────────────────────────────────────────────
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// ── Products ──────────────────────────────────────────────────────────
Route::get('/products',        [ProductController::class, 'index'])->name('products.index');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products',       [ProductController::class, 'store'])->name('products.store');

// ── Sales ─────────────────────────────────────────────────────────────
Route::get('/sales',        [SaleController::class, 'index'])->name('sales.index');
Route::get('/sales/create', [SaleController::class, 'create'])->name('sales.create');
Route::post('/sales',       [SaleController::class, 'store'])->name('sales.store');

// ── Journal Entries ───────────────────────────────────────────────────
Route::get('/journal', [JournalEntryController::class, 'index'])->name('journal.index');

// ── Financial Reports ─────────────────────────────────────────────────
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
