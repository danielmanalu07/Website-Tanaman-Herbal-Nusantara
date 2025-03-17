<?php

use App\Http\Controllers\Admin\CrudStaffController;
use App\Http\Controllers\Admin\HabitusController;
use App\Http\Controllers\Admin\LandsController;
use App\Http\Controllers\Admin\PlantController;
use App\Http\Controllers\Admin\PlantLandController;
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

    });
    //CRUD Habitus
    Route::prefix('/habitus')->group(function () {
        Route::get('/', [HabitusController::class, 'getAllHabitus']);
        Route::get('/{id}', [HabitusController::class, 'getDetailHabitus'])->name('habitus.detail');
        Route::middleware('permission:admin')->group(function () {
            Route::post('/create', [HabitusController::class, 'createHabitus']);
            Route::put('/{id}/update', [HabitusController::class, 'updateHabitus']);
            Route::delete('/{id}/delete', [HabitusController::class, 'deleteHabitus']);
        });

    });

    //CRUD Lands
    Route::prefix('/land')->group(function () {
        Route::get('/', [LandsController::class, 'getAllLands']);
        Route::get('/{id}', [LandsController::class, 'getDetailLand']);
        Route::middleware('permission:admin')->group(function () {
            Route::post('/create', [LandsController::class, 'createLand']);
            Route::put('/{id}/edit', [LandsController::class, 'updateLand']);
            Route::delete('{id}/delete', [LandsController::class, 'deleteLand']);
        });
    });

    //CRUD Plants
    Route::prefix('/plant')->group(function () {
        Route::get('/', [PlantController::class, 'getAllPlant']);
        Route::get('/{id}', [PlantController::class, 'getDetailPlant']);
        Route::middleware('permission:admin')->group(function () {
            Route::post('/create', [PlantController::class, 'createPlant']);
            Route::put('/{id}/edit', [PlantController::class, 'updatePlant']);
            Route::delete('/{id}/delete', [PlantController::class, 'deletePlant']);
        });
    });

    //CRUD Plant Land
    Route::prefix('/plant-land')->group(function () {
        Route::get('/', [PlantLandController::class, 'getAllPlantLand']);
        Route::get('/{id}', [PlantLandController::class, 'getDetailPlantLand']);
        Route::middleware('permission:admin')->group(function () {
            Route::post('/create', [PlantLandController::class, 'createPlantLand']);
            Route::put('/{id}/edit', [PlantLandController::class, 'updatePlantLand']);
            Route::delete('/{id}/delete', [PlantLandController::class, 'deletePlantLand']);
        });
    });
});
