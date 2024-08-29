<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AttendanceController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\MemberMembershipController;
use App\Http\Controllers\API\MembershipController;
use App\Http\Controllers\API\TrainerAssignment;
use App\Http\Controllers\API\WorkoutController;





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

Route::get('/attendances',[AttendanceController::class,'index']);
Route::post('/attendances',[AttendanceController::class,'store']);
Route::put('/attendances/{id}', [AttendanceController::class, 'update']);
Route::delete('/attendances/{id}', [AttendanceController::class, 'destroy']);



Route::get('/memberMemberships',[MemberMembershipController::class,'index']);
Route::post('/memberMemberships',[MemberMembershipController::class,'store']);
Route::put('/memberMemberships/{id}',[MemberMembershipController::class,'update']);
Route::delete('/memberMemberships/{id}',[MemberMembershipController::class,'destroy']);



Route::get('/memberships',[MembershipController::class,'index']);
Route::post('/memberships',[MembershipController::class,'store']);
Route::put('/memberships/{id}',[MembershipController::class,'update']);
Route::delete('/memberships/{id}',[MembershipController::class,'destroy']);








// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
