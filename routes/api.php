<?php

use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Event\EventRegistrationController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register', [AuthController::class, 'register']);

Route::get('/posts/{code}', [PostController::class, 'getPostsByCode']);
Route::get('/subscriptions/{key}/posts', [PostController::class, 'getPostsByKey']);
Route::get('/posts/{id}/{uid}', [PostController::class, 'getDetails']);
Route::post('/posts', [PostController::class, 'create']);


Route::post('/admin/login', [AuthController::class, 'login']);
Route::get('/admin/login', function() {
    return bcrypt('password');
});
Route::get('/event-details/{code}', [SubscriptionController::class, 'getDetailsByCode']);
Route::get('/proxy-image', [SubscriptionController::class, 'getImageData']);

Route::middleware('auth:sanctum')->group( function () {
    //Admin
    Route::get('/admin/clients', [ClientController::class, 'get']);
    Route::get('/admin/posts', [AdminPostController::class, 'get']);
    Route::put('/admin/posts/{post}/approve', [AdminPostController::class, 'approve']);
    Route::put('/admin/posts/{post}/revert', [AdminPostController::class, 'revert']);
    Route::put('/admin/posts/{post}/deny', [AdminPostController::class, 'deny']);

    Route::get('/subscriptions', [SubscriptionController::class, 'index']);
    Route::get('/subscriptions/{key}', [SubscriptionController::class, 'getSubscriptionByKey']);
    Route::post('/subscriptions', [SubscriptionController::class, 'store']);
    Route::post('/subscriptions/{id}', [SubscriptionController::class, 'update']);
    Route::post('/subscriptions/{id}/transfer', [SubscriptionController::class, 'transferToClient']);

    Route::get('/subscriptions/{id}/details', [SubscriptionController::class, 'getSubscriptionDetails']);
    Route::get('/subscriptions/{id}/frames', [SubscriptionController::class, 'getFrames']);
    Route::post('/subscriptions/{id}/frames', [SubscriptionController::class, 'uploadFrame']);
    Route::delete('/subscriptions/{subscription_id}/frames/{id}', [SubscriptionController::class, 'deleteFrame']);

    Route::get('/events', [EventController::class, 'get']);
    Route::post('/events', [EventController::class, 'store']);
    Route::put('/events/{event}', [EventController::class, 'update']);
    Route::delete('/events/{event}', [EventController::class, 'destroy']);
});

Route::post('/event-registration', [EventRegistrationController::class, 'register']);
Route::get('/event-registration/details/{code}', [EventRegistrationController::class, 'details']);
Route::get('/event-registration/qr', [EventRegistrationController::class, 'generateQRCode']);
Route::get('/event-attendance/{code}', [EventRegistrationController::class, 'attendanceDetails']);
Route::post('/event-attendance/{code}', [EventRegistrationController::class, 'attendanceConfirm']);