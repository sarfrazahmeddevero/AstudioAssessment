<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AttributeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TimesheetController;


Route::middleware('auth:api')->prefix('api')->group(function () {
    Route::apiResource('attributes', AttributeController::class);
    Route::apiResource('projects', ProjectController::class);
});