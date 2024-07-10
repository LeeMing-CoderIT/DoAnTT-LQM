<?php

use App\Http\Controllers\HelpperController;
use App\Http\Controllers\User\AppController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ManagerCategoriesController;
use App\Http\Controllers\Admin\ManagerStoriesController;
use App\Http\Controllers\Admin\ManagerUsersController;
use App\Http\Controllers\Admin\ManagerChaptersController;
use App\Http\Controllers\Admin\ManagerRequestController;
use App\Http\Controllers\Admin\RealTimeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\CrawlDataController;

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
Route::get('test', function () {
    $image = explode('storage','/storage/photos/1/images/tu-la-ma-de.jpg');
    $image = '/storage'.$image[1];
    dd($image);
});
//****************user*************
    Route::get('/crawler', [CrawlDataController::class, "crawler"])->name("crawler");

    Route::get('/', [AppController::class, "home"])->name("home");
    Route::get('/filter-stories', [AppController::class, "filter"])->name("filter");
    Route::get('/category/{category}', [AppController::class, "category"])->name("category");
    Route::get('/story/{story}', [AppController::class, "story"])->name("story");
    Route::get('/searchStories', [AppController::class, "searchStories"])->name("searchStories");
    Route::get('/loadChap/{story?}', [AppController::class, "loadChap"])->name("loadChap");
    Route::get('/loadCategories', [AppController::class, "loadCategories"])->name("loadCategories");
    Route::get('/show-chapter', [AppController::class, "showChapter"])->name("showChapter");
    Route::get('/listen/{story}/{chap}', [AppController::class, "listen"])->name("listen");
    Route::get('/tranlateToMP3', [HelpperController::class, "tranlateToMP3_2"])->name("tranlateToMP3");
    Route::get('/infoUser', [AppController::class, "infoUser"])->name('infoUser');
    Route::post('/infoUser', [AppController::class, "postInfoUser"])->name('postInfoUser');
    Route::post('/infoUser-settings', [AppController::class, "postInfoUserSetting"])->name('postInfoUserSetting');
    Route::get('/change-speech', [AppController::class, "changeSpeech"])->name('changeSpeech');
    Route::get('/infoUser-all-request-story', [AppController::class, "infoUserAllRequest"])->name('infoUserAllRequest');
    Route::get('/infoUser-all-manager', [AppController::class, "infoUserAllManager"])->name('infoUserAllManager');
    Route::post('/change-pass', [AppController::class, "postChangePass"])->name('postChangePass');
    Route::post('/request-story', [AppController::class, "postRequestStory"])->name('postRequestStory');
    Route::get('/show-history', [AppController::class, "showHistory"])->name('showHistory');
    Route::get('/save-history-paragraph', [AppController::class, "saveHistory_paragraph"])->name('saveHistory_paragraph');

    Route::get('/login', [UserController::class, "login"])->name('login');
    Route::post('/login', [UserController::class, "postLogin"])->name('postLogin');
    Route::get('/register', [UserController::class, "register"])->name('register');
    Route::post('/register', [UserController::class, "postRegister"])->name('postRegister');
    Route::get('/forget-password', [UserController::class, "forgetPassword"])->name('forgetPassword');
    Route::post('/forget-password', [UserController::class, "postForgetPassword"])->name('postForgetPassword');
    Route::get('/logout', [UserController::class, "logout"])->name('logout');
    Route::get('/resetAccuracyEmail/{user}', [UserController::class, "resetAccuracyEmail"])->name('resetAccuracyEmail');
    Route::get('/accuracyEmail/{user}/{token}', [UserController::class, "accuracyEmail"])->name('accuracyEmail');
    Route::get('/email-change-pass/{user}/{token}', [UserController::class, "emailChangePass"])->name('emailChangePass');
    Route::post('/email-change-pass/{user}/{token}', [UserController::class, "postEmailChangePass"])->name('postEmailChangePass');
    Route::get('/change-background/{user}/{background}', [UserController::class, "changBackground"])->name('changBackground');

Route::middleware('realtimeLogin')->group(function(){
    //**************checkurl**************
    Route::get('/checkout/checkUrl', [HelpperController::class, "checkUrl"])->name("checkUrl");
    //**************checkdata**************
    Route::get('/checkout/story/slugExist', [ManagerStoriesController::class, "slugExist"])->name("slugStoriesExist");
    Route::get('/checkout/category/slugExist', [ManagerCategoriesController::class, "slugExist"])->name("slugCategoriesExist");
    //**************admin**************
    Route::prefix('/admin')->name('admin.')->group(function (){
        Route::get('/login', [AdminController::class, "login"])->name("login");
        Route::post('/login', [AdminController::class, "postLogin"])->name("postLogin");
        Route::get('/logout', [AdminController::class, "logout"])->name("logout");

        Route::middleware('adminActive')->group(function (){
            Route::group(['prefix' => 'laravel-filemanager'], function () {
                \UniSharp\LaravelFilemanager\Lfm::routes();
            });
            Route::get('/', [AdminController::class, "home"])->name("home");
            Route::get('/info', [AdminController::class, "info"])->name("info");
            Route::prefix('/system')->name('system.')->group(function (){
                Route::get('/', [AdminController::class, "system"])->name("index");
            });
            Route::prefix('/realtime')->name('realtime.')->group(function (){
                Route::get('/logoutUser', [RealTimeController::class, "logoutUser"])->name("logoutUser");
            });
            Route::prefix('/categories')->name('categories.')->group(function (){
                Route::get('/', [ManagerCategoriesController::class, "index"])->name("index");
                Route::get('/all', [ManagerCategoriesController::class, "all"])->name("all");
                Route::post('/add', [ManagerCategoriesController::class, "add"])->name("add");
                Route::get('/show/{category}', [ManagerCategoriesController::class, "show"])->name("show");
                Route::patch('/edit/{category}', [ManagerCategoriesController::class, "edit"])->name("edit");
                Route::delete('/delete/{category}', [ManagerCategoriesController::class, "delete"])->name("delete");
            });
            Route::prefix('/stories')->name('stories.')->group(function (){
                Route::get('/', [ManagerStoriesController::class, "index"])->name("index");
                Route::get('/all', [ManagerStoriesController::class, "all"])->name("all");
                Route::post('/add', [ManagerStoriesController::class, "add"])->name("add");
                Route::get('/show/{story}', [ManagerStoriesController::class, "show"])->name("show");
                Route::patch('/edit/{story}', [ManagerStoriesController::class, "edit"])->name("edit");
                Route::delete('/delete/{story}', [ManagerStoriesController::class, "delete"])->name("delete");
                // Route::get('/crawler-data', [ManagerStoriesController::class, "crawler"])->name("crawler");

                Route::prefix('/{story}/chapters')->name('chapters.')->group(function (){
                    Route::get('/all', [ManagerChaptersController::class, "all"])->name("all");
                    Route::post('/add', [ManagerChaptersController::class, "add"])->name("add");
                    Route::get('/show/{chapter?}', [ManagerChaptersController::class, "show"])->name("show");
                    Route::patch('/edit/{chapter}', [ManagerChaptersController::class, "edit"])->name("edit");
                    Route::delete('/delete/{chapter}', [ManagerChaptersController::class, "delete"])->name("delete");
                });
            });
            Route::prefix('/requests')->name('requests.')->group(function (){
                Route::get('/addStory', [ManagerRequestController::class, "index"])->name("index");
                Route::get('/allAddStory', [ManagerRequestController::class, "allAddStory"])->name("allAddStory");
                Route::get('/showAddStory/{requestAddStory}', [ManagerRequestController::class, "showAddStory"])->name("showAddStory");
                Route::patch('/editAddStory/{requestAddStory}', [ManagerRequestController::class, "editAddStory"])->name("editAddStory");
                Route::delete('/deleteAddStory/{requestAddStory}', [ManagerRequestController::class, "deleteAddStory"])->name("deleteAddStory");
            });
            Route::prefix('/users')->middleware('root_1')->name('users.')->group(function (){
                Route::get('/', [ManagerUsersController::class, "index"])->name("index");
                Route::get('/all', [ManagerUsersController::class, "all"])->name("all");
                Route::post('/add', [ManagerUsersController::class, "add"])->name("add");
                Route::get('/show/{user}', [ManagerUsersController::class, "show"])->name("show");
                Route::patch('/edit/{user}', [ManagerUsersController::class, "edit"])->name("edit");
                Route::delete('/delete/{user}', [ManagerUsersController::class, "delete"])->name("delete");
            });
        });
    });
});