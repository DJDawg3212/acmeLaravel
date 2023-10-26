<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ConductorController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\VehicleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Auth::routes();

Route::get('owners', [OwnerController::class, 'getOwners']);
Route::get('owner/{id}', [OwnerController::class, 'getOwner']);
Route::post('add-owner', [OwnerController::class, 'addOwner']);
Route::post('update-owner', [OwnerController::class, 'updateOwner']);
Route::post('delete-owner', [OwnerController::class, 'deleteOwner']);

Route::get('conductors', [ConductorController::class, 'getConductors']);
Route::get('conductor/{id}', [ConductorController::class, 'getConductor']);
Route::post('add-conductor', [ConductorController::class, 'addConductor']);
Route::post('update-conductor', [ConductorController::class, 'updateConductor']);
Route::post('delete-conductor', [ConductorController::class, 'deleteConductor']);
Route::post('attach-vehicle', [ConductorController::class, 'attachVehicle']);

Route::get('vehicles', [VehicleController::class, 'getVehicles']);
Route::get('vehicle/{id}', [VehicleController::class, 'getVehicle']);
Route::post('add-vehicle', [VehicleController::class, 'addVehicle']);
Route::post('update-vehicle', [VehicleController::class, 'updateVehicle']);
Route::post('delete-vehicle', [VehicleController::class, 'deleteVehicle']);
Route::post('detach-conductor', [VehicleController::class, 'detachConductor']);
