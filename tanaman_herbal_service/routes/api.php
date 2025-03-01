<?php

use App\Http\Controllers\Admin\CrudStaffController;
use App\Http\Controllers\Admin\HabitusController;
use App\Http\Controllers\Admin\VisitorCategoryController;
use App\Http\Controllers\Admin\VisitorController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::middleware(['auth:sanctum', 'auth.token_expiry'])->group(function () {
    Route::get('/profile', [AuthController::class, 'Profile']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::middleware('permission:admin')->group(function () {
        //CRUD Staff
        Route::get("/get-staff", [CrudStaffController::class, 'getAllStaff']);
        Route::post("/create-staff", [CrudStaffController::class, 'CreateStaff']);
        Route::get("/get-staff/{id}", [CrudStaffController::class, 'getDetailStaff']);
        Route::put("/update-staff/{id}", [CrudStaffController::class, 'updateStaff']);
        Route::delete("/delete-staff/{id}", [CrudStaffController::class, 'deleteStaff']);

        Route::get("/visitor-categories", [VisitorCategoryController::class, 'getVisitorCategories']);
        Route::post("/visitor-category", [VisitorCategoryController::class, 'createVisitorCategory']);
        Route::get("/visitor-category/{id}", [VisitorCategoryController::class, 'getDetailVisitorCategory']);
        Route::put("/visitor-category/{id}", [VisitorCategoryController::class, 'updateVisitorCategory']);
        Route::delete("/visitor-category/{id}", [VisitorCategoryController::class, 'deleteVisitorCategory']);

        //CRUD Visitors
        Route::prefix('/visitors')->group(function () {
            Route::get('/', [VisitorController::class, 'getVisitors']);
            Route::post('/create', [VisitorController::class, 'createVisitor']);
            Route::get('/{id}', [VisitorController::class, 'getDetailVisitor']);
            Route::put('/{id}/update', [VisitorController::class, 'updateVisitor']);
            Route::delete('/{id}/delete', [VisitorController::class, 'deleteVisitor']);
        });

        //CRUD Habitus
        Route::prefix('/habitus')->group(function () {
            Route::post('/create', [HabitusController::class, 'createHabitus']);
            Route::get('/', [HabitusController::class, 'getAllHabitus']);
            Route::get('/{id}', [HabitusController::class, 'getDetailHabitus']);
        });
    });

});
