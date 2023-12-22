<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LabController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SampleController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\StockController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::post('/admin/login', [AdminController::class, 'login']);


Route::post('/login', [AuthController::class, 'login']);
Route::post('/user-login', [AuthController::class, 'loginUser']);


Route::middleware(['auth:sanctum'])->group( function () {
        Route::prefix('labs')->group(function () {
            Route::post('/create', [LabController::class, 'store'])->name('main');
            Route::get('/main', [LabController::class, 'mainLabs'])->name('main');
            Route::get('/main/{id}', [LabController::class, 'mainLabsDeatils'])->name('mainId');
            Route::get('/{id}', [LabController::class, 'mainLabsById']);
            Route::post('/{id}', [LabController::class, 'updateLabs']);
            Route::delete('/{id}', [LabController::class, 'delete']);
            Route::get('/change-status/{id}', [LabController::class, 'lab_status'])->name('lab_status');
            Route::get('/users/{id}', [LabController::class, 'lab_user']);

        });

        Route::prefix('users')->group(function () {
            Route::post('/', [UserController::class, 'store']);
            Route::post('/{id}', [UserController::class, 'update']);
            Route::post('/profile/{id}', [UserController::class, 'profile_upload']);
            Route::get('/{id}', [UserController::class, 'getUserId']);
            Route::delete('/{id}', [UserController::class, 'delete']);
        });

        Route::prefix('department')->group(function () {
            Route::post('/', [LabController::class, 'department_create'])->name('department_create');
            Route::post('/{id}', [LabController::class, 'department_update'])->name('department_update');
        });

        Route::prefix('stocks')->group(function () {
            Route::get('/', [StockController::class, 'index']);
            Route::get('/{id}', [StockController::class, 'edit']);
            Route::post('/', [StockController::class, 'store']);
            Route::post('/{id}', [StockController::class, 'update']);
            Route::delete('/{id}', [StockController::class, 'delete']);
        });

        Route::prefix('sample')->group(function () {
           Route::post('/send', [SampleController::class, 'send_sample']);
           Route::get('/lab/{id}', [SampleController::class, 'sample_by_lab']);
           Route::get('/user/{id}', [SampleController::class, 'sample_by_user']);

        });
        Route::prefix('report')->group(function () {
           Route::post('/lab', [SampleController::class, 'report_Send']);
        });

            Route::get('/notification/user/{id}', [SampleController::class, 'user_notification']);

});
