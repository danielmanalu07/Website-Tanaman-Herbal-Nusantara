<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HabitusController;
use App\Http\Controllers\LandController;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\VisitorCategoryController;
use App\Http\Controllers\VisitorController;
use App\Http\Middleware\Authorization;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('admin.login');
});

Route::match(['get', 'post'], '/login', [AuthController::class, 'login'])->name('admin.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
Route::prefix('/admin')->middleware(Authorization::class)->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('admin.dashboard');

    //CRUD HABITUS
    Route::prefix('/habitus')->group(function () {
        Route::get('/', [HabitusController::class, 'index'])->name('habitus.index');
        Route::post('/create', [HabitusController::class, 'create'])->name('habitus.create');
        // Route::get('/{id}', [HabitusController::class, 'get_detail_habitus'])->name('habitus.detail');
        Route::put('/{id}/update', [HabitusController::class, 'update_habitus'])->name('habitus.update');
        Route::delete('/{id}/delete', [HabitusController::class, 'delete_habitus'])->name('habitus.delete');
    });

    //CRUD STAFF
    Route::prefix('/staff')->group(function () {
        Route::get('/', [StaffController::class, 'index'])->name('staff.index');
        Route::post('/create', [StaffController::class, 'create'])->name('staff.create');
        Route::put('/{id}/update', [StaffController::class, 'update'])->name('staff.update');
        Route::delete('/{id}/delete', [StaffController::class, 'delete'])->name('staff.delete');
        Route::put('/{id}/update-status', [StaffController::class, 'update_status'])->name('staff.update.status');
    });

    //CRUD PLANT
    Route::prefix('/plant')->group(function () {
        Route::get('/', [PlantController::class, 'index'])->name('plant.index');
        Route::post('/create', [PlantController::class, 'create'])->name('plant.create');
        Route::put('/{id}/update', [PlantController::class, 'update'])->name('plant.update');
        Route::delete('/{id}/delete', [PlantController::class, 'delete'])->name('plant.delete');
    });

    // CRUD Land
    Route::prefix('/land')->group(function () {
        Route::get('/', [LandController::class, 'index'])->name('land.index');
        Route::post('/create', [LandController::class, 'create'])->name('land.create');
        Route::put('/{id}/edit', [LandController::class, 'update'])->name('land.update');
        Route::delete('/{id}/delete', [LandController::class, 'delete'])->name('land.delete');
    });

    //CRUD Visitor Category
    Route::prefix('/visitor-category')->group(function () {
        Route::get('/', [VisitorCategoryController::class, 'index'])->name('visitor.category.index');
        Route::post('/create', [VisitorCategoryController::class, 'create'])->name('visitor.category.create');
        Route::put('/{id}/edit', [VisitorCategoryController::class, 'update'])->name('visitor.category.update');
        Route::delete('/{id}/delete', [VisitorCategoryController::class, 'delete'])->name('visitor.category.delete');
    });

    //CRUD Visitor
    Route::prefix('/visitor')->group(function () {
        Route::get('/', [VisitorController::class, 'index'])->name('visitor.index');
        Route::post('/create', [VisitorController::class, 'create'])->name('visitor.create');
        Route::put('/{id}/edit', [VisitorController::class, 'update'])->name('visitor.update');
        Route::delete('/{id}/delete', [VisitorController::class, 'delete'])->name('visitor.delete');
    });
});
