<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\DocumentController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/admin',[AdminController::class,'admin_create']);
Route::post('/accountManager/register',[AdminController::class,'accountManager_create']);
Route::post('/register',[UserController::class,'register']);

Route::get('/verify/{token}',[UserController::class,'checkVerified']);
Route::post('/login',[UserController::class,'Login']);

Route::post('/forgotpassword',[UserController::class,'generateToken']);
Route::get('/reset-password/{token}',[UserController::class,'getUser']);
Route::post('/reset-password/{token}',[UserController::class,'updatePassword']);


Route::get('/permissions',[AdminController::class,'index']);

Route::post('/permissions',[AdminController::class,'store']);
Route::post('/logout',[LoginController::class,'logout']);
