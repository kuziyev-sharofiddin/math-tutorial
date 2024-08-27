<?php
/**
 * @author sharofiddin <qoziyevsharofiddin199805@gmail.com>
 * @link https://t.me/sharofiddin_komilovich
 * @date 27/08/2024, 17:12
 */


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\HomeController;


Route::post('login/authenticate', [AuthController::class, 'authenticate']);
Route::get('login', [AuthController::class, 'login'])->name('admin.login');
Route::get('logout', [AuthController::class, 'logout']);

Route::get('dashboard', [HomeController::class, 'index']);
