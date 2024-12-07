<?php
use Illuminate\Support\Facades\Route;
use Src\Infrastructure\Controllers\User\UserController;
use Src\Infrastructure\Controllers\Court\CourtController;
use Src\Infrastructure\Controllers\Sport\SportController;
use Src\Infrastructure\Controllers\Member\MemberController;
use Src\Infrastructure\Controllers\Reservation\ReservationController;

Route::get('/', function () {
    return response()->json(['message' => 'Welcome to the API']);
});

// User
Route::post('register', [UserController::class, 'register'])->name('auth.register');
Route::post('login', [UserController::class, 'login'])->name('auth.login');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user/{user}', [UserController::class, 'show'])->name('user.show');
    Route::post('user/update/{user}', [UserController::class, 'update'])->name('user.update');
    Route::delete('user/delete/{user}', [UserController::class, 'delete'])->name('user.delete');

});


Route::middleware(['auth:sanctum'])->resource('user', UserController::class)->names([

    'index' => 'user.index',
    'show' => 'user.show',
    'store' => 'user.store',
    'update' => 'user.update'
]);


// Sport

Route::middleware(['auth:sanctum'])->resource('sport', SportController::class)->names([
    'show' => 'sport.show',
    'store' => 'sport.store',
    'update' => 'sport.update',
    'destroy' => 'sport.destroy',
]);


// Court
Route::middleware(['auth:sanctum'])->get('court/free', [CourtController::class, 'getAvailableCourts'])->name('court.getAvailableCourts');

Route::middleware(['auth:sanctum'])->resource('court', CourtController::class)->names([
    'show' => 'court.show',
    'store' => 'court.store',
    'update' => 'court.update',
    'destroy' => 'court.destroy',
]);


// Member

Route::middleware(['auth:sanctum'])->resource('member', MemberController::class)->names([
    'show' => 'member.show',
    'store' => 'member.store',
    'update' => 'member.update',
    'destroy' => 'member.destroy',
]);

// Reservation
Route::middleware(['auth:sanctum'])->get('reservation/day', [ReservationController::class, 'indexDay'])->name('reservation.indexDay');

Route::middleware(['auth:sanctum'])->resource('reservation', ReservationController::class)->names([
    'show' => 'reservation.show',
    'store' => 'reservation.store',
    'update' => 'reservation.update',
    'destroy' => 'reservation.destroy',
]);
