<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIController\APIAuthControllers;
use App\Http\Controllers\APIController\APIFileController;
use App\Http\Controllers\APIController\APIReportController;
use App\Http\Controllers\APIController\APIFileLocationController;
use App\Http\Controllers\APIController\APIFileAdminController;
use App\Http\Middleware\OwnerMiddleware;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\StaffMiddleware;



Route::post('/login',[APIAuthControllers::class,'login']);

Route::post('/register',[APIAuthControllers::class,'registerManager']);
Route::post('/logout',[APIAuthControllers::class,'logout']);


Route::middleware(['auth:sanctum', AdminMiddleware::class])->group(function () {

    Route::post('/register-employee', [APIAuthControllers::class, 'registerEmployee']);
    Route::delete('/admin/delete-file/{id}', [APIFileController::class, 'deleteFile']);
    Route::delete('/admin/delete-user/{id}', [APIReportController::class, 'deleteUser']);
    Route::get('/report-count-file', [APIReportController::class, 'countFile']);
    Route::get('/report-count-user', [APIReportController::class, 'countUser']);
    Route::get('/report-user', [APIReportController::class, 'reportUser']);
    Route::put('/admin/update-file/{id}', [APIFileController::class, 'updateFile']);
    
    Route::post('/admin/import-file',[APIFileAdminController::class,'import']);
    Route::get('/admin/export-file/{id}', [APIFileAdminController::class, 'exportFile']);
    Route::get('/admin/report-imported-file', [APIFileAdminController::class, 'getFileImported']);
    Route::get('/admin/report-file', [APIFileAdminController::class, 'reportFileUserAdmin']);

    // get file location 
    Route::get('/admin/get-file-location', [APIFileLocationController::class, 'getFileLocation']);
    Route::post('/admin/store-file-location',[APIFileLocationController::class,'store']);
    Route::put('/admin/update-file-location/{id}', [APIFileLocationController::class, 'updateFileLocation']);



    
});

Route::middleware(['auth:sanctum', StaffMiddleware::class])->group(function () {
    Route::get('/report-file/{manager_id}', [APIReportController::class, 'reportFileUser']);
    Route::get('/get-file/{manager_id}', [APIFileController::class, 'getFile']);
    Route::post('/import-file',[APIFileController::class,'import']);
    Route::put('/update-file/{id}', [APIFileController::class, 'updateFile']);
    Route::get('/export-file/{id}/{manager_id}', [APIFileController::class, 'exportFile']);


});


