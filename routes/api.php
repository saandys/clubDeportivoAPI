<?php
use Illuminate\Support\Facades\Route;
use Src\Infrastructure\V1\Controllers\User\UserController;
use Src\Infrastructure\V1\Controllers\Court\CourtController;
use Src\Infrastructure\V1\Controllers\Sport\SportController;
use Src\Infrastructure\V1\Controllers\Member\MemberController;
use Src\Infrastructure\V1\Controllers\Reservation\ReservationController;

Route::get('/', function () {
    return response()->json(['message' => 'Welcome to the API']);
});

Route::prefix('v1')->group(function () {
    // User
    Route::post('register', [UserController::class, 'register'])->name('v1.auth.register');
    Route::post('login', [UserController::class, 'login'])->name('v1.auth.login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('user/{user}', [UserController::class, 'show'])->name('v1.user.show');
        Route::post('user/update/{user}', [UserController::class, 'update'])->name('v1.user.update');
        Route::delete('user/delete/{user}', [UserController::class, 'delete'])->name('v1.user.delete');

    });


    Route::middleware(['auth:sanctum'])->resource('user', UserController::class)->names([

        'index' => 'v1.user.index',
        'show' => 'v1.user.show',
        'store' => 'v1.user.store',
        'update' => 'v1.user.update'
    ]);


    // Sport

    Route::middleware(['auth:sanctum'])->resource('sport', SportController::class)->names([
        'show' => 'v1.sport.show',
        'store' => 'v1.sport.store',
        'update' => 'v1.sport.update',
        'destroy' => 'v1.sport.destroy',
    ]);


    // Court
    Route::middleware(['auth:sanctum'])->get('court/free', [CourtController::class, 'getAvailableCourts'])->name('court.getAvailableCourts');

    Route::middleware(['auth:sanctum'])->resource('court', CourtController::class)->names([
        'show' => 'v1.court.show',
        'store' => 'v1.court.store',
        'update' => 'v1.court.update',
        'destroy' => 'v1.court.destroy',
    ]);


    // Member

    Route::middleware(['auth:sanctum'])->resource('member', MemberController::class)->names([
        'show' => 'v1.member.show',
        'store' => 'v1.member.store',
        'update' => 'v1.member.update',
        'destroy' => 'v1.member.destroy',
    ]);

    // Reservation
    Route::middleware(['auth:sanctum'])->get('reservation/day', [ReservationController::class, 'indexDay'])->name('reservation.indexDay');

    Route::middleware(['auth:sanctum'])->resource('reservation', ReservationController::class)->names([
        'show' => 'v1.reservation.show',
        'store' => 'v1.reservation.store',
        'update' => 'v1.reservation.update',
        'destroy' => 'v1.reservation.destroy',
    ]);
});
