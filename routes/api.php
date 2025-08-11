<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\BuildingController;
use App\Models\User;


Route::post('/tokens/create', function (Request $request, User $user) {
    
    $user = $user->first();

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'token' => $token,
    ]);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::controller(ActivityController::class)->group(function () {
        Route::get('/activities/get-organizations-by-activity','getOrganizationsByActivity');
        
        Route::post('/activities/get-organizations-by-activity-type','getOrganizationsByActivityType');
    });
    Route::controller(OrganizationController::class)->group(function () {
        Route::post('/organizations/get-organization-by-name', 'getOrganizationByName');
        
        Route::get('/organizations/get-organization-info-by-id/{organizationId}', 'getOrganizationInfoById')->where('organizationId', '[0-9]+');;
    });
    Route::controller(BuildingController::class)->group(function () {
       Route::get('/buildings/get-organization-by-building', 'getOrganizationByBuilding');
       Route::get('/buildings/get-buildings-by-coords', 'getBuildingsByCoords');
    });
});