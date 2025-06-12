<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
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


Route::get('/', [UserController::class, 'showWelcome'])->name('welcome.form');
Route::get('/register', [UserController::class, 'showForm'])->name('register.form');
Route::post('/register', [UserController::class, 'store'])->name('users.store');

Route::get('/lang/{locale}', function ($locale) {
    if (!in_array($locale, ['en', 'ar'])) {
        abort(400);
    }
    App::setLocale($locale);
    Session::put('locale', $locale);
    return redirect()->back();
})->name('lang.switch');