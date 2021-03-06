<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\RegisterController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\BoardController;
use App\Http\Controllers\api\SliderController;
use App\Http\Controllers\api\StandardController;
use App\Http\Controllers\api\SemesterController;
use App\Http\Controllers\api\SubjectController;
use App\Http\Controllers\api\VideosController;
use App\Http\Controllers\api\SolutionController;
use App\Http\Controllers\api\MaterialController;
use App\Http\Controllers\api\PaperController;
use App\Http\Controllers\api\WorksheetController;
use App\Http\Controllers\api\UnitController;
use App\Http\Controllers\api\FeatureController;
use App\Http\Controllers\api\TextbookController;
use App\Http\Controllers\api\McqController;




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
Route::group(['middleware'=>'api'], function()
{
	Route::get('logout',[RegisterController::class, 'logout']); 
    Route::post('board_medium', [BoardController::class, 'boardMedium']);
    Route::post('slider', [SliderController::class, 'slider']);
    Route::post('standard_list', [StandardController::class, 'standardList']);
    Route::post('semester_list', [SemesterController::class, 'semesterList']);
    Route::post('subject_list', [SubjectController::class, 'subjectList']);
    Route::post('unit_list', [UnitController::class, 'unitList']);
    Route::post('video_list', [VideosController::class, 'videoList']);
    Route::post('book_list', [TextbookController::class, 'textbookList']);
    Route::post('solution_list', [SolutionController::class, 'solutionList']);
    Route::post('material_list', [MaterialController::class, 'materialList']);
    Route::post('paper_list', [PaperController::class, 'paperList']);
    Route::post('worksheet_list', [WorksheetController::class, 'worksheetList']);
    Route::post('features_list', [FeatureController::class, 'features_list']);
    Route::post('profile_update', [RegisterController::class, 'profile_update']);
    Route::post('all_in_one', [FeatureController::class, 'all_in_one']);
    Route::post('mcq_practice', [McqController::class, 'mcqPractice']);

    Route::post('mcq_practice', [McqController::class, 'mcqPractice']);

    Route::post('add_bookmark', [TextbookController::class, 'addBookmark']);
    Route::post('view_bookmark', [TextbookController::class, 'viewBookmark']);

    Route::post('add_pdf_counter', [TextbookController::class, 'addPdfCount']);

    Route::post('add_video_bookmark', [VideosController::class, 'addVideoBookmark']);
    Route::post('view_video_bookmark', [VideosController::class, 'viewVideoBookmark']);

    Route::post('add_solution_material_count', [VideosController::class, 'addSolutionMaterialCount']);
    

});

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);

