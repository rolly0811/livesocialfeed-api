<?php

use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\PostController as ClientPostController;
use App\Http\Controllers\PublicPostController;
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
    // return redirect('/ui');
    return view('coming-soon');
});

Route::get('/qr-code/{id}/{uid}', function ($id, $uid) {
    return redirect('/ui/#/testimonials/' . $id . '/' . $uid);
});

Route::get('/view-event/{event_code}', [PublicPostController::class, 'getPostPage']);

Route::get('/events/{subscription_key}', [PublicPostController::class, 'get']);

Route::get('/subscriptions/{id}/update-images', [ClientPostController::class, 'updateImages']);

//Event Registration
Route::get('/event-registration/{code}', function($code) {
    return redirect(config('app.ui_baseurl') . '/#/event/register/' . $code);
});

Route::get('/event-attendance/{code}', function ($code) {
    return redirect(config('app.ui_baseurl') . '/#/event/attendance/' . $code);
});