<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DataQualityAuditController;
use App\Http\Controllers\ProgramReportController;
use App\Http\Controllers\PatientDiseaseController;
use App\Http\Controllers\WorkLoadAnalysisController;
use App\Http\Controllers\NutritionController;
use App\Http\Controllers\PediatricsController;
use App\Http\Controllers\ProgrammaticIndicatorController;
use App\Http\Controllers\PerformanceIndicatorController;
use App\Http\Controllers\PmtctReportController;
use App\Http\Controllers\ScragReportController;
use App\Http\Controllers\VlReportController;
use App\Http\Controllers\TptAnalysisController;
use App\Http\Controllers\ReportGroupController;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/v1/login',[UserController::class,'login']);
Route::post('/v1/register',[UserController::class,'store']);
Route::get('/v1/roles',[UserController::class,'roles']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/v1/logout',[UserController::class,'logout']);
    Route::get('v1/patients',[PatientController::class,'index']);
    Route::get('/v1/reports-data',[ReportGroupController::class,'reportsdata']);
    Route::get('/v1/reports',[ReportGroupController::class,'report']);
    Route::get('/v1/surge-report',[ReportGroupController::class,'surgereport']);
    Route::get('/v1/dsdm-report',[ReportGroupController::class,'dsdmreport']);
    Route::get('/v1/hybrid-report',[ReportGroupController::class,'hybridreport']);
    Route::get('/v1/hmisv2-report',[ReportGroupController::class,'hmisv2report']);
    Route::get('/v1/hmis-report',[ReportGroupController::class,'hmisreport']);
    Route::get('/v1/cot-report',[ReportGroupController::class,'cotreport']);
    Route::get('/v1/summary-report',[ReportGroupController::class,'cotsummaryreport']);
    Route::get('/v1/hts-report',[ReportGroupController::class,'htsreport']);
    Route::get('/v1/testing',[ReportGroupController::class,'testing']);

    Route::get('/v1/missed-arv-pickup',[ReportGroupController::class,'missedarvpickup']);
    Route::get('/v1/missed-appoitments',[ReportGroupController::class,'missedappointments']);
    Route::get('/v1/appointments-scheduled',[ReportGroupController::class,'appointments']);
    Route::get('/v1/viral-load-patients',[ReportGroupController::class,'viralloadpatients']);
    Route::get('/v1/detectable-viral-load',[ReportGroupController::class,'detectableviralload']);

});
    


