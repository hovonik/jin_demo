<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\MasterAuthController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfessionController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ShoppingCartController;
use App\Http\Controllers\WishlistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('user', function (Request $request) {
    return $request->user();
});

Route::post('register', [AuthController::class, 'register']);
Route::post('webhook', [CheckoutController::class, 'index']);
Route::post('reset-password',[AuthController::class,'resetPasswordSendSms']);
Route::post('reset-password-verify',[AuthController::class,'resetPasswordVerify']);
Route::post('users/{user}/verify', [AuthController::class, 'verify']);
Route::get('users/{user}/resend-sms', [AuthController::class, 'resendSms']);
Route::post('login', [AuthController::class, 'login']);
Route::get('professions', [ProfessionController::class, 'index']);
Route::get('notifications',[AuthController::class,'getNotifications']);


Route::group(['middleware' => 'auth:api-user'], function () {
    //img upload
    Route::post('img-upload',[ImageUploadController::class,'imgUpload']);

    Route::post('update-password',[AuthController::class,'updatePassword']);
    Route::get('log-out', [AuthController::class, 'logout']);
    Route::get('account', [AuthController::class, 'account']);
    Route::post('account',[AuthController::class,'editAccount']);
    Route::delete('delete-account/{user}',[AuthController::class,'destroy']);
    Route::post('accept-bonus', [ShoppingCartController::class, 'acceptBonus']);
    Route::get('bonuses', [AuthController::class, 'getUserBonuses']);
    Route::post('rate-order', [ShoppingCartController::class, 'rateOrder']);


    /* Wishlist */
    Route::group(['prefix' => 'wishlist'],function (){
        Route::get('',[WishlistController::class,'index']);
        Route::post('add', [WishlistController::class, 'add']);
        Route::post('remove',[WishlistController::class,'removeItem']);
        Route::get('empty',[WishlistController::class,'emptyWishlist']);
    });

    /*  --Categories--  */
    Route::group(['prefix' => 'categories'], function (){
        Route::get('',[CategoryController::class, 'index']);
        Route::group(['prefix' => '{category}'], function (){
            Route::get('products', [ProductController::class, 'index']);
            Route::group(['prefix' => 'products/{product}'], function (){
                Route::get('', [ProductController::class, 'show']);
            });
        });
    });

    /*  --Professions and Services--  */
    Route::prefix('professions')->group(function () {
        Route::prefix('{profession}')->group(function () {
            Route::get('services', [ServiceController::class, 'index']);
        });
    });

    Route::post('checkout', [CheckoutController::class, 'addInfo']);
    Route::post('add-to-cart-service', [ShoppingCartController::class, 'addToCartService']);
    Route::get('orders', [ShoppingCartController::class, 'getOrders']);
    Route::post('add-shipping-km', [ShoppingCartController::class, 'addShippingKm']);

    Route::resource('cart', ShoppingCartController::class);
    Route::post('cart/has', [ShoppingCartController::class, 'itemHasInCart']);
    Route::post('cart/delete-product', [ShoppingCartController::class, 'deleteProduct']);
//    /*  --Professions and Services--  */
//    Route::prefix('cart')->group(function () {
//        Route::get('/', [ShoppingCartController::class, 'index']);
//        Route::post('add', [ShoppingCartController::class, 'store']);
//
//        Route::get('{product_id}', [ShoppingCartController::class, 'test']);
//    });

    Route::post('create-delivery-order',[CheckoutController::class,'createDeliveryOrder']);
    Route::get('search', [SearchController::class, 'index']);
});

Route::group(['prefix' => 'masters'],function (){
    //img upload
    Route::post('img-upload',[ImageUploadController::class,'imgUpload']);

    Route::post('register', [MasterAuthController::class, 'register']);
    Route::post('login', [MasterAuthController::class, 'login']);
    Route::post('{master}/verify', [MasterAuthController::class, 'verify']);
    Route::get('{master}/resend-sms', [MasterAuthController::class, 'resendSms']);
    Route::post('reset-password',[MasterAuthController::class,'resetPasswordSendSms']);
    Route::post('reset-password-verify',[MasterAuthController::class,'resetPasswordVerify']);

    Route::group(['middleware' => 'auth:masters'],function (){
        Route::post('become-free',[MasterAuthController::class,'becomeFree']);
        Route::post('send-verification-request', [MasterAuthController::class, 'sendVerifyRequest']);
        Route::get('account', [MasterAuthController::class, 'account']);
        Route::post('account',[MasterAuthController::class,'editAccount']);
        Route::post('update-password',[MasterAuthController::class,'updatePassword']);
        Route::get('log-out', [MasterAuthController::class, 'logout']);
        Route::post('location-update',[MasterAuthController::class,'locationUpdate']);
        Route::get('orders/{order_id}/accept',[ShoppingCartController::class,'acceptOrder']);
        Route::get('orders/{order_id}/reject',[ShoppingCartController::class,'rejectOrder']);
        Route::get('is-verified',[MasterAuthController::class,'isVerified']);
        Route::get('notifications',[MasterAuthController::class,'getNotifications']);
        Route::get('orders',[ShoppingCartController::class,'getMasterOrders']);
        Route::post('place-in',[ShoppingCartController::class,'placeIn']);
        Route::post('end',[ShoppingCartController::class,'end']);
        Route::post('place-in-coords',[ShoppingCartController::class,'placeInCoords']);
        Route::post('end-coords',[ShoppingCartController::class,'endCoords']);
        Route::post('pay-out',[ShoppingCartController::class,'payOut']);
        Route::get('get-payment-history',[ShoppingCartController::class,'getPaymentHistory']);
        Route::delete('delete-account/{master}',[MasterAuthController::class, 'destroy']);
    });
});
Route::prefix('pages')->group(function () {
    Route::get('privacy-policy', [PagesController::class, 'privacyPolicy']);
});
Route::get('get-professions',[ProfessionController::class, 'getProfessions']);

