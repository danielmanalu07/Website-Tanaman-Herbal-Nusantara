<?php

use App\Http\Controllers\Admin\CrudStaffController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
Route::post('/validation-user', [AuthController::class, 'validationUsername']);
Route::post('/verification-code', [AuthController::class, 'verificationCode']);
Route::middleware(['auth:sanctum', 'auth.token_expiry'])->group(function () {
    Route::get('/profile', [AuthController::class, 'Profile']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::middleware('admin')->group(function () {
        //CRUD Staff
        Route::get("/get-staff", [CrudStaffController::class, 'getAllStaff']);
        Route::post("/create-staff", [CrudStaffController::class, 'CreateStaff']);
        Route::get("/get-staff/{id}", [CrudStaffController::class, 'getDetailStaff']);
        Route::put("/update-staff/{id}", [CrudStaffController::class, 'updateStaff']);
        Route::delete("/delete-staff/{id}", [CrudStaffController::class, 'deleteStaff']);
    });
});
