<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\InspectionController;
use App\Http\Controllers\ComplaintController;

Route::apiResource('facilities', FacilityController::class);
Route::apiResource('inspections', InspectionController::class);
Route::apiResource('complaints', ComplaintController::class);