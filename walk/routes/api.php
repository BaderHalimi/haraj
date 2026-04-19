<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\RedemptionController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\StepsController;
use Illuminate\Support\Facades\Route;

Route::middleware('check.api.key')->group(function () {
    Route::post('register-step-one', [AuthController::class, 'registerStepOne']);
    Route::post('login', [AuthController::class, 'login']);
});


Route::middleware('auth:api', 'auth:sanctum', 'check.api.key')->group(function () {
    Route::post('register-step-two', [AuthController::class, 'registerStepTwo']);

    Route::post('log-steps', [StepsController::class, 'logSteps']);

    Route::get('/referral-code', [ReferralController::class, 'getReferralCode']);
    Route::get('/referrals', [ReferralController::class, 'getReferrals']);

    Route::post('/redeem', [RedemptionController::class, 'redeem']);

    Route::middleware('admin')->group(function () {
        Route::get('/packages', [PackageController::class, 'index']);
        Route::post('/packages', [PackageController::class, 'store']);
        Route::post('/packages/{package}', [PackageController::class, 'update']);
        Route::delete('/packages/{package}', [PackageController::class, 'destroy']);

        Route::get('/rewards', [RewardController::class, 'index']);
        Route::post('/rewards', [RewardController::class, 'store']);
        Route::post('/rewards/{reward}', [RewardController::class, 'update']);
        Route::delete('/rewards/{reward}', [RewardController::class, 'destroy']);
    });
});
