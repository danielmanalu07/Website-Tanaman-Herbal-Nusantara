<?php

use App\Http\Controllers\Admin\AboutUsController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\CrudStaffController;
use App\Http\Controllers\Admin\HabitusController;
use App\Http\Controllers\Admin\LandsController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\PlantController;
use App\Http\Controllers\Admin\PlantLandController;
use App\Http\Controllers\Admin\VisitorCategoryController;
use App\Http\Controllers\Admin\VisitorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Staff\PlantValidationController;
use App\Http\Middleware\SetLanguage;
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
        Route::put('/edit-status/{id}', [CrudStaffController::class, 'update_status']);

        //CRUD Visitor Category
        Route::middleware(SetLanguage::class)->group(function () {
            Route::get("/visitor-categories", [VisitorCategoryController::class, 'getVisitorCategories']);
            Route::post("/visitor-category", [VisitorCategoryController::class, 'createVisitorCategory']);
            Route::get("/visitor-category/{id}", [VisitorCategoryController::class, 'getDetailVisitorCategory']);
            Route::put("/visitor-category/{id}", [VisitorCategoryController::class, 'updateVisitorCategory']);
            Route::delete("/visitor-category/{id}", [VisitorCategoryController::class, 'deleteVisitorCategory']);
        });

        //CRUD Visitors
        Route::prefix('/visitors')->middleware(SetLanguage::class)->group(function () {
            Route::get('/', [VisitorController::class, 'getVisitors']);
            Route::post('/create', [VisitorController::class, 'createVisitor']);
            Route::get('/{id}', [VisitorController::class, 'getDetailVisitor']);
            Route::put('/{id}/update', [VisitorController::class, 'updateVisitor']);
            Route::delete('/{id}/delete', [VisitorController::class, 'deleteVisitor']);
        });

    });
    //CRUD Habitus
    Route::prefix('/habitus')->middleware(SetLanguage::class)->group(function () {
        Route::get('/', [HabitusController::class, 'getAllHabitus']);
        Route::get('/{id}', [HabitusController::class, 'getDetailHabitus'])->name('habitus.detail');
        Route::middleware('permission:admin')->group(function () {
            Route::post('/create', [HabitusController::class, 'createHabitus']);
            Route::put('/{id}/update', [HabitusController::class, 'updateHabitus']);
            Route::delete('/{id}/delete', [HabitusController::class, 'deleteHabitus']);
        });

    });

    //CRUD Lands
    Route::prefix('/land')->middleware(SetLanguage::class)->group(function () {
        Route::get('/', [LandsController::class, 'getAllLands']);
        Route::get('/{id}', [LandsController::class, 'getDetailLand']);
        Route::middleware('permission:admin')->group(function () {
            Route::post('/create', [LandsController::class, 'createLand']);
            Route::put('/{id}/edit', [LandsController::class, 'updateLand']);
            Route::delete('{id}/delete', [LandsController::class, 'deleteLand']);
        });
    });

    //CRUD Plants
    Route::prefix('/plant')->middleware(SetLanguage::class)->group(function () {
        Route::get('/', [PlantController::class, 'getAllPlant']);
        Route::get('/{id}', [PlantController::class, 'getDetailPlant'])->name('plant.detail');
        Route::middleware('permission:admin')->group(function () {
            Route::post('/create', [PlantController::class, 'createPlant']);
            Route::put('/{id}/edit', [PlantController::class, 'updatePlant']);
            Route::delete('/{id}/delete', [PlantController::class, 'deletePlant']);
            Route::put('/{id}/update-status', [PlantController::class, 'updateStatus']);
            Route::post('/upload', [PlantController::class, 'uploadCkeditor']);
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

    //CRUD News
    Route::prefix('/news')->middleware(SetLanguage::class)->group(function () {
        Route::get('/', [NewsController::class, 'get_all_news']);
        Route::get('/{id}', [NewsController::class, 'get_detail_news']);
        Route::middleware('permission:admin')->group(function () {
            Route::post('/create', [NewsController::class, 'create_news']);
            Route::put('/{id}/edit', [NewsController::class, 'update_news']);
            Route::delete('/{id}/delete', [NewsController::class, 'delete_news']);
            Route::post('/upload', [NewsController::class, 'uploadCkeditor']);
            Route::put('/{id}/update-status', [NewsController::class, 'updateStatus']);
        });
    });

    //CRUD Content
    Route::prefix('/content')->middleware(SetLanguage::class)->group(function () {
        Route::get('/', [ContentController::class, 'get_all']);
        Route::get('/{id}', [ContentController::class, 'get_detail']);
        Route::middleware('permission:admin')->group(function () {
            Route::post('/create', [ContentController::class, 'create']);
            Route::put('/{id}/edit', [ContentController::class, 'update']);
            Route::delete('/{id}/delete', [ContentController::class, 'delete']);
            Route::post('/upload', [ContentController::class, 'uploadCkeditor']);
            Route::put('/{id}/update-status', [ContentController::class, 'updateStatus']);
        });
    });

    //CRUD LANGUAGE
    Route::prefix('/languages')->group(function () {
        Route::get('/', [LanguageController::class, 'get_all_lang']);
        Route::middleware('permission:admin')->group(function () {
            Route::get('/{id}', [LanguageController::class, 'get_detail_lang']);
            Route::post('/create', [LanguageController::class, 'create_lang']);
            Route::put('/{id}/edit', [LanguageController::class, 'update_lang']);
            Route::delete('/{id}/delete', [LanguageController::class, 'delete_lang']);
        });
    });

    //CRUD ABOUT US
    Route::prefix('/contact-us')->middleware(SetLanguage::class)->group(function () {
        Route::get('/', [AboutUsController::class, 'get_all_about_us']);
        Route::get('/{id}', [AboutUsController::class, 'get_detail_about_us']);
        Route::middleware('permission:admin')->group(function () {
            Route::post('/create', [AboutUsController::class, 'create_aboutUs']);
            Route::put('/{id}/edit', [AboutUsController::class, 'update_about_us']);
            Route::delete('/{id}/delete', [AboutUsController::class, 'delete_about_us']);
            Route::post('/upload', [AboutUsController::class, 'uploadCkeditor']);
        });
    });

    //VALIDATION
    Route::middleware('permission:koordinator,agronom')->group(function () {
        Route::get('/validated', [PlantValidationController::class, 'get']);
        Route::get('/validated/{id}', [PlantValidationController::class, 'get_detail']);
        Route::prefix('/scanner')->group(function () {
            Route::post('/validate', [PlantValidationController::class, 'store']);
        });
    });
});

Route::middleware(SetLanguage::class)->group(function () {
    Route::get('/news-user', [NewsController::class, 'get_all_news']);
    Route::get('/news-user/{id}', [NewsController::class, 'get_detail_news']);
    Route::get('/habitus-user', [HabitusController::class, 'getAllHabitus']);
    Route::get('/habitus-user/{id}', [HabitusController::class, 'getDetailHabitus']);
    Route::get('/plants-user', [PlantController::class, 'getAllPlant']);
    Route::get('/plants-user/{id}', [PlantController::class, 'getDetailPlant']);
    Route::get('/content-user', [ContentController::class, 'get_all']);
    Route::get('/content-user/{id}', [ContentController::class, 'get_detail']);
    Route::get('/visitor-user', [VisitorController::class, 'getVisitors']);
    Route::get('/contact-us-user', [AboutUsController::class, 'get_all_about_us']);

});

Route::get('/lang-user', [LanguageController::class, 'get_all_lang']);
Route::get('/land-user', [LandsController::class, 'getAllLands']);
