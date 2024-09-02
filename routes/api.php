<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AttendanceController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\MemberMembershipController;
use App\Http\Controllers\API\MembershipController;
use App\Http\Controllers\API\TrainerAssignmentController;
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

Route::middleware('auth:sanctum')->get('/attendances',[AttendanceController::class,'index']);
Route::middleware('auth:sanctum')->post('/attendances',[AttendanceController::class,'store']);
Route::middleware('auth:sanctum')->put('/attendances/{id}', [AttendanceController::class, 'update']);
Route::middleware('auth:sanctum')->delete('/attendances/{id}', [AttendanceController::class, 'destroy']);



Route::middleware('auth:sanctum')->get('/memberMemberships',[MemberMembershipController::class,'index']);
Route::middleware('auth:sanctum')->post('/memberMemberships',[MemberMembershipController::class,'store']);
Route::middleware('auth:sanctum')->put('/memberMemberships/{id}',[MemberMembershipController::class,'update']);
Route::middleware('auth:sanctum')->delete('/memberMemberships/{id}',[MemberMembershipController::class,'destroy']);



Route::get('/memberships',[MembershipController::class,'index']);
Route::middleware('auth:sanctum')->post('/memberships',[MembershipController::class,'store']);
Route::middleware('auth:sanctum')->put('/memberships/{id}',[MembershipController::class,'update']);
Route::middleware('auth:sanctum')->delete('/memberships/{id}',[MembershipController::class,'destroy']);


Route::get('/trainerAssignments',[TrainerAssignmentController::class,'index']);
Route::middleware('auth:sanctum')->post('/trainerAssignments',[TrainerAssignmentController::class,'store']);
Route::middleware('auth:sanctum')->put('/trainerAssignments/{id}',[TrainerAssignmentController::class,'update']);
Route::middleware('auth:sanctum')->delete('/trainerAssignments/{id}',[TrainerAssignmentController::class,'destroy']);



Route::get('/workouts',[WorkoutController::class,'index']);
Route::middleware('auth:sanctum')->post('/workouts',[WorkoutController::class,'store']);
Route::middleware('auth:sanctum')->put('/workouts/{id}',[WorkoutController::class,'update']);
Route::middleware('auth:sanctum')->delete('/workouts/{id}',[WorkoutController::class,'destroy']);


Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
