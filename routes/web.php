<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\CustomFieldsController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\MasterRequestsController;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\Admin\PagesController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfessionsController;
use App\Http\Controllers\Admin\ServicesController;
use App\Http\Controllers\Admin\ShopController;
use App\Http\Controllers\Admin\UsersController;
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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/privacy-policy', [PagesController::class, 'privacyPolicy'])->name('privacyPolicy');
Auth::routes();
Route::group(['middleware' => 'auth:web'], function () {
    Route::get('/logout',[LoginController::class,'logout'])->name('logout');
    Route::resource('products',ProductController::class);
    Route::resource('shops',ShopController::class);
    Route::resource('master-verification-requests',MasterRequestsController::class);
    Route::resource('professions',ProfessionsController::class);
    Route::resource('categories',CategoriesController::class);
    Route::resource('orders',OrdersController::class);
    Route::resource('users', UsersController::class);
    Route::resource('services', ServicesController::class);
    Route::resource('custom-fields', CustomFieldsController::class);
    Route::delete('image/{image}', [ProductController::class, 'deleteImage']);
    Route::group(['prefix' => 'products/{product}'], function (){
        Route::post('/visible', [ProductController::class, 'visible']);
    });
    Route::group(['prefix' => 'professions/{profession}'], function (){
        Route::post('/visible', [ProfessionsController::class, 'visible']);
    });
    Route::resource('pages',PagesController::class);

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});


