<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\HabitusController;
use App\Http\Controllers\LandController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\OurGardenController;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\PlantValidationController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VisitorCategoryController;
use App\Http\Controllers\VisitorController;
use App\Http\Middleware\Authorization;
use App\Http\Middleware\SetAcceptLanguage;
use App\Http\Middleware\SetLocale;
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
        Route::put('/{id}/update-status', [PlantController::class, 'update_status'])->name('plant.update.status');
        Route::post('/upload', [PlantController::class, 'upload'])->name('plant.upload');
        Route::get('/excel-plant', [PlantController::class, 'excel'])->name('plant.excel');
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

    //CRUD News
    Route::prefix('/news')->group(function () {
        Route::get('/', [NewsController::class, 'index'])->name('news.index');
        Route::post('/create', [NewsController::class, 'create'])->name('news.create');
        Route::post('/upload', [NewsController::class, 'upload'])->name('news.upload');
        Route::put('/{id}/edit', [NewsController::class, 'edit'])->name('new.edit');
        Route::delete('/{id}/delete', [NewsController::class, 'delete'])->name('news.delete');
        Route::put('/{id}/update-status', [NewsController::class, 'update_status'])->name('news.update.status');
        Route::post('/language', [LanguageController::class, 'SetLanguage'])->name('news.language');
    });

    //CRUD Content
    Route::prefix('/content')->group(function () {
        Route::get('/', [ContentController::class, 'index'])->name('content.index');
        Route::post('/upload', [ContentController::class, 'upload'])->name('content.upload');
        Route::post('/create', [ContentController::class, 'create'])->name('content.create');
        Route::put('/{id}/edit', [ContentController::class, 'edit'])->name('content.edit');
        Route::delete('/{id}/delete', [ContentController::class, 'delete'])->name('content.delete');
        Route::put('/{id}/update-status', [ContentController::class, 'update_status'])->name('content.update.status');
    });

    //CRUD Language
    Route::prefix('/languages')->group(function () {
        Route::get('/', [LanguageController::class, 'index'])->name('language.index');
        Route::post('/create', [LanguageController::class, 'create_language'])->name('language.create');
        Route::put('/{id}/edit', [LanguageController::class, 'update_language'])->name('language.edit');
        Route::delete('/{id}/delete', [LanguageController::class, 'delete_language'])->name('language.delete');
    });

    //CRUD Contact Us
    Route::prefix('/contact-us')->group(function () {
        Route::get('/', [ContactUsController::class, 'index'])->name('contact.index');
        Route::post('/create', [ContactUsController::class, 'create'])->name('contact.create');
        Route::post('/upload', [ContactUsController::class, 'upload'])->name('contact.updload');
        Route::put('/{id}/edit', [ContactUsController::class, 'edit'])->name('contact.edit');
        Route::delete('/{id}/delete', [ContactUsController::class, 'delete'])->name('contact.delete');
    });

    //View Plant Validation
    Route::prefix('/validation')->group(function () {
        Route::get('/', [PlantValidationController::class, 'index'])->name('validation.index');
        Route::get('/excel-plant-validation', [PlantValidationController::class, 'excel'])->name('validation.excel');
    });
});

//ROUTE USER
Route::middleware([SetAcceptLanguage::class, SetLocale::class])->group(function () {
    Route::get('/', [UserController::class, 'home'])->name('home');
    Route::get('/news', [UserController::class, 'news'])->name('news');
    Route::get('/news/search', [UserController::class, 'search'])->name('user.news.search');
    Route::post('/lang', [LanguageController::class, 'SetLanguageUser'])->name('user.language');
    Route::get('/our-garden', [OurGardenController::class, 'index'])->name('user.ourgarden');
    Route::get('/our-garden/{id}', [OurGardenController::class, 'detail'])->name('user.ourgarden.detail');
    Route::get('/our-garden/plant/{id}', [OurGardenController::class, 'detail_plant'])->name('user.ourgarden.plant.detail');
    Route::get('/news/{id}', [UserController::class, 'news_detail'])->name('user.news.detail');

    Route::get('/profile/{id}', [UserController::class, 'profile_detail'])->name('user.profile.detail');
    Route::get('/contact-us-user', [UserController::class, 'contact_us'])->name('user.contact');

});
