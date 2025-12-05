<?php

use App\Http\Controllers\ApprovalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PurchaseRequestController;
use App\Http\Controllers\PurchasingProcessController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\RequestItemController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Auth
Route::post('/register', RegisterController::class);
Route::post('/login', LoginController::class);


// Routes
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/logout', LogoutController::class)->middleware('auth:sanctum');

    // Role: PEMOHON
    Route::middleware('role:pemohon')->group(function () {

        // Purchase Request CRUD
        Route::post('/requests', [RequestController::class, 'store']);
        Route::put('/requests/{id}', [RequestController::class, 'update']);
        Route::delete('/requests/{id}', [RequestController::class, 'destroy']);

        // Items inside request
        Route::post('/requests/{id}/items', [RequestItemController::class, 'store']);
        Route::delete('/items/{id}', [RequestItemController::class, 'destroy']);
    });

    // Role: APPROVER
    Route::middleware('role:approver')->group(function () {
        Route::get('/approvals/pending', [ApprovalController::class, 'listPending']);
        Route::post('/requests/{id}/approve', [ApprovalController::class, 'approve']);
    });

    // Role: PURCHASING
    Route::middleware('role:purchasing')->group(function () {
        Route::put('/requests/{id}/purchasing', [PurchasingProcessController::class, 'update']);
        Route::get('/requests/{id}/purchasing', [PurchasingProcessController::class, 'show']);

        // Reports
        Route::get('/reports/summary', [ReportController::class, 'summary']);
        Route::get('/reports/top-categories', [ReportController::class, 'topCategories']);
    });

    // Role visibility for ALL authorized statuses
    Route::middleware('role:pemohon,purchasing,approver,warehouse')->group(function () {
        Route::get('/requests', [PurchaseRequestController::class, 'index']);
        Route::get('/requests/{id}', [PurchaseRequestController::class, 'show']);
    });
});
