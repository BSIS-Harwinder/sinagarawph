<?php

use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\Auth\Client\AuthenticationController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EngineersController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OffersController;
use App\Http\Controllers\ReasonsController;
use App\Http\Controllers\SchedulesController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/client', function() {
    return redirect()->route('client.dashboard');
});
Route::get('/admin', function() {
    return redirect()->route('admin.dashboard');
});

Route::prefix('client')->group(function() {
    Auth::routes(['verify' => true]);

    Route::get('login', [AuthenticationController::class, 'showLoginForm'])->name('client.login');
    Route::post('login', [AuthenticationController::class, 'login'])->name('client.login');
    Route::post('logout', [AuthenticationController::class, 'logout'])->name('client.logout');
    Route::get('password/reset', [ClientsController::class, 'show_request_reset_password'])->name('client.password.reset');
    Route::post('password/reset', [ClientsController::class, 'reset_password'])->name('client.reset_password');
    Route::post('password/email', [ClientsController::class, 'send_password_link'])->name('client.send_password_link');

    Route::middleware('auth:client')->group(function() {
        Route::middleware('verified')->group(function() {
            Route::get('dashboard', [ClientsController::class, 'index'])->name('client.dashboard');
            Route::get('profile/{id}', [ClientsController::class, 'show_profile'])->name('client.profile');
            Route::match(['put', 'patch'], 'client/update/{id}', [ClientsController::class, 'update'])->name('client.update');

            Route::post('store', [ClientsController::class, 'schedule_visit'])->name('client.schedule_visit');

            Route::prefix('invoice')->group(function() {
                Route::get('', [ClientsController::class, 'my_orders'])->name('client.orders');
                Route::get('view/{invoice_number}', [ClientsController::class, 'view_order'])->name('client.view_order');

                Route::prefix('tracker')->group(function() {
                    Route::get('{id}', [ClientsController::class, 'invoice_tracker'])->name('client.invoice.tracker');
                    Route::get('datatable/{sale_id}', [ClientsController::class, 'tracker_datatable'])->name('client.invoice.tracker.datatable');
                    Route::get('print/{id}', [ClientsController::class, 'print_invoice'])->name('client.invoice.print');
                });
            });
        });
    });
});

Route::prefix('admin')->group(function() {
    Auth::routes(['register' => false, 'verify' => false, 'reset' => false, 'confirm' => false]);

    Route::middleware('auth')->group(function() {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        Route::prefix('schedules')->group(function() {
            Route::get('', [SchedulesController::class, 'index'])->name('schedules.index');
            Route::get('view/{id}', [SchedulesController::class, 'show'])->name('schedules.show');
            Route::match(['put', 'patch'], 'update/{id}', [SchedulesController::class, 'update'])->name('schedules.update');
            Route::delete('delete/{id}', [SchedulesController::class, 'delete'])->name('schedules.delete');
            Route::get('engineer', [SchedulesController::class, 'engineer_schedule'])->name('engineer_schedule');
            Route::get('view', [SchedulesController::class, 'view_schedule'])->name('view.engineer.schedule');
        });

        Route::prefix('clients')->group(function() {
            Route::get('', [DashboardController::class, 'list_clients'])->name('clients.index');
            Route::get('view/{id}', [DashboardController::class, 'show_client'])->name('clients.show');
            Route::match(['put', 'patch'],'update/{id}', [DashboardController::class, 'update_client'])->name('clients.update');
        });

        Route::prefix('employees')->group(function() {
            Route::get('', [EngineersController::class, 'index'])->name('engineers.index');
            Route::post('store',  [EngineersController::class, 'store'])->name('engineers.store');
            Route::get('view/{id}', [EngineersController::class, 'show'])->name('engineers.show');
            Route::match(['put', 'patch'],'update/{id}', [EngineersController::class, 'update'])->name('engineers.update');
            Route::get('change_password/{id}', [EngineersController::class, 'change_password'])->name('engineers.change_password');
            Route::patch('update_password/{id}', [EngineersController::class, 'update_password'])->name('engineers.update_password');
            Route::post('reset_password', [EngineersController::class, 'send_temporary_password'])->name('engineers.send_temporary_password');
        });

        Route::prefix('offers')->group(function() {
            Route::get('', [OffersController::class, 'index'])->name('offers.index');
            Route::get('view/{id}', [OffersController::class, 'show'])->name('offers.show');
            Route::post('store', [OffersController::class, 'store'])->name('offers.store');
            Route::match(['put', 'patch'], 'update/{id}', [OffersController::class, 'update'])->name('offers.update');
            Route::delete('delete/{id}', [OffersController::class, 'delete'])->name('offers.delete');
        });

        Route::prefix('invoice')->group(function() {
            Route::get('', [InvoiceController::class, 'index'])->name('invoices.index');
            Route::get('view/{id}', [InvoiceController::class, 'show'])->name('invoices.show');
            Route::post('store', [InvoiceController::class, 'store'])->name('invoices.store');
            Route::match(['put', 'patch'], 'update/{id}', [InvoiceController::class, 'update'])->name('invoices.update');
            Route::delete('delete/{id}', [InvoiceController::class, 'delete'])->name('invoices.delete');
            Route::get('tracker/{id}', [InvoiceController::class, 'invoice_tracker'])->name('invoices.tracker');

            Route::prefix('tracker')->group(function() {
                Route::get('{id}', [InvoiceController::class, 'invoice_tracker'])->name('invoices.tracker');
                Route::get('datatable/{sale_id}', [InvoiceController::class, 'tracker_datatable'])->name('invoices.tracker.datatable');
            });

            Route::get('print/{id}', [InvoiceController::class, 'print_invoice'])->name('invoices.print');
        });

        Route::prefix('contracts')->group(function() {
            Route::get('', [DashboardController::class, 'contract'])->name('contracts.index');
            Route::get('view/{id}', [DashboardController::class, 'view_contract'])->name('contracts.view');
        });

        Route::prefix('reasons')->group(function() {
            Route::get('', [ReasonsController::class, 'index'])->name('reasons.index');
        });

        Route::prefix('audit')->group(function() {
            Route::get('', [AuditLogController::class, 'index'])->name('audit.index');
            Route::get('datatable', [AuditLogController::class, 'datatable'])->name('audit.datatable');
        });
    });
});
