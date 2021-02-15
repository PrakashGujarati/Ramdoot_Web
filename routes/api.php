<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\BoardController;
use App\Http\Controllers\API\SliderController;
use App\Http\Controllers\API\StandardController;
use App\Http\Controllers\API\SemesterController;
use App\Http\Controllers\API\SubjectController;
use App\Http\Controllers\API\VideosController;
use App\Http\Controllers\API\SolutionController;
use App\Http\Controllers\API\MaterialController;
use App\Http\Controllers\API\PaperController;
use App\Http\Controllers\API\WorksheetController;





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
Route::group(['middleware'=>'auth:api'], function()
{
	Route::get('logout',[RegisterController::class, 'logout']); 
    Route::post('board_medium', [BoardController::class, 'boardMedium']);
    Route::post('slider', [SliderController::class, 'slider']);
    Route::post('standard_list', [StandardController::class, 'standardList']);
    Route::post('semester_list', [SemesterController::class, 'semesterList']);
    Route::post('subject_list', [SubjectController::class, 'subjectList']);
    Route::post('video_list', [VideosController::class, 'videoList']);
    Route::post('solution_list', [SolutionController::class, 'solutionList']);
    Route::post('material_list', [MaterialController::class, 'materialList']);
    Route::post('paper_list', [PaperController::class, 'paperList']);
    Route::post('worksheet_list', [WorksheetController::class, 'worksheetList']);
});

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);

