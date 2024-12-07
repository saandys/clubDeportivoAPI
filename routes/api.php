<?php
use Illuminate\Support\Facades\Route;
use Src\Infrastructure\Controllers\User\UserController;
use Src\Infrastructure\Controllers\Court\CourtController;
use Src\Infrastructure\Controllers\Sport\SportController;
use Src\Infrastructure\Controllers\Member\MemberController;


// User

Route::get('/', function () {
    return response()->json(['message' => 'Welcome to the API']);
});

Route::post('register', [UserController::class, 'register'])->name('auth.register');
Route::get('login/{user}', [UserController::class, 'login'])->name('auth.login');
Route::post('user/update/{user}', [UserController::class, 'update'])->name('user.update');

Route::delete('user/delete/{user}', [UserController::class, 'delete'])->name('user.delete');

Route::middleware(['auth:sanctum'])->resource('user', UserController::class)->names([

    'index' => 'masters.user.index',
    'show' => 'masters.user.show',
    'store' => 'masters.user.store',
    'update' => 'masters.user.update'
]);


// Sport

Route::resource('sport', SportController::class)->names([
    'show' => 'masters.sport.show',
    'store' => 'masters.sport.store',
    'update' => 'masters.sport.update',
    'destroy' => 'masters.sport.destroy',
]);


// Court

Route::resource('court', CourtController::class)->names([
    'show' => 'masters.court.show',
    'store' => 'masters.court.store',
    'update' => 'masters.court.update',
    'destroy' => 'masters.court.destroy',
]);


// Member

Route::resource('member', MemberController::class)->names([
    'show' => 'masters.member.show',
    'store' => 'masters.member.store',
    'update' => 'masters.member.update',
    'destroy' => 'masters.member.destroy',
]);
