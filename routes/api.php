<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\BoardController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\Api\StandardController;
use App\Http\Controllers\Api\SemesterController;
use App\Http\Controllers\Api\SubjectController;
use App\Http\Controllers\Api\VideosController;
use App\Http\Controllers\Api\SolutionController;
use App\Http\Controllers\Api\MaterialController;
use App\Http\Controllers\Api\PaperController;
use App\Http\Controllers\Api\WorksheetController;
use App\Http\Controllers\Api\UnitController;
use App\Http\Controllers\Api\FeatureController;
use App\Http\Controllers\Api\TextbookController;
use App\Http\Controllers\Api\McqController;
use App\Http\Controllers\Api\ExamController;
 



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
    Route::post('unit_list', [UnitController::class, 'unitList']);
    Route::post('video_list', [VideosController::class, 'videoList']);
    Route::post('book_list', [TextbookControsller::class, 'textbookList']);
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
    Route::post('list_of_exams', [ExamController::class, 'listOfExams']);

    Route::post('exam_questions', [ExamController::class, 'examQuestions']);
    Route::post('submit_exam', [ExamController::class, 'submitExam']);        
    Route::post('result_exam', [ExamController::class, 'resultExam']);
    
    Route::post('note_list', [TextbookController::class, 'note_list']);
});

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);

