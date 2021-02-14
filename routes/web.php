<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\StandardController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\VideosController;
use App\Http\Controllers\SolutionController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\PaperController;
use App\Http\Controllers\WorksheetController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return redirect('/login');
});

Route::group(['middleware' => 'auth'], function(){
	Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
	/*board*/
	Route::get('/board', [BoardController::class, 'index'])->name('board.index');
	Route::get('board/create', [BoardController::class, 'create'])->name('board.create');
	Route::post('board/store', [BoardController::class, 'store'])->name('board.store');
	Route::get('board/{id}/edit', [BoardController::class, 'edit'])->name('board.edit');
	Route::post('board/{id}/update', [BoardController::class, 'update'])->name('board.update');
	Route::get('board/{id}/delete', [BoardController::class, 'distroy'])->name('board.distroy');

	/*Standard*/
	Route::get('standard', [StandardController::class, 'index'])->name('standard.index');
	Route::get('standard/create', [StandardController::class, 'create'])->name('standard.create');
	Route::post('standard/store', [StandardController::class, 'store'])->name('standard.store');
	Route::get('standard/{id}/edit', [StandardController::class, 'edit'])->name('standard.edit');
	Route::post('standard/{id}/update', [StandardController::class, 'update'])->name('standard.update');
	Route::get('standard/{id}/delete', [StandardController::class, 'distroy'])->name('standard.distroy');

	/*Subjects*/
	Route::get('subject', [SubjectController::class, 'index'])->name('subject.index');
	Route::get('subject/create', [SubjectController::class, 'create'])->name('subject.create');
	Route::post('subject/store', [SubjectController::class, 'store'])->name('subject.store');
	Route::get('subject/{id}/edit', [SubjectController::class, 'edit'])->name('subject.edit');
	Route::post('subject/{id}/update', [SubjectController::class, 'update'])->name('subject.update');
	Route::get('subject/{id}/delete', [SubjectController::class, 'distroy'])->name('subject.distroy');

	/*Book*/
	Route::get('book', [BookController::class, 'index'])->name('book.index');
	Route::get('book/create', [BookController::class, 'create'])->name('book.create');
	Route::post('book/store', [BookController::class, 'store'])->name('book.store');
	Route::get('book/{id}/edit', [BookController::class, 'edit'])->name('book.edit');
	Route::post('book/{id}/update', [BookController::class, 'update'])->name('book.update');
	Route::get('book/{id}/delete', [BookController::class, 'distroy'])->name('book.distroy');

	/*Semester*/
	Route::get('semester', [SemesterController::class, 'index'])->name('semester.index');
	Route::get('semester/create', [SemesterController::class, 'create'])->name('semester.create');
	Route::post('semester/store', [SemesterController::class, 'store'])->name('semester.store');
	Route::get('semester/{id}/edit', [SemesterController::class, 'edit'])->name('semester.edit');
	Route::post('semester/{id}/update', [SemesterController::class, 'update'])->name('semester.update');
	Route::get('semester/{id}/delete', [SemesterController::class, 'distroy'])->name('semester.distroy');

	/*unit*/
	Route::get('unit', [UnitController::class, 'index'])->name('unit.index');
	Route::get('unit/create', [UnitController::class, 'create'])->name('unit.create');
	Route::post('unit/store', [UnitController::class, 'store'])->name('unit.store');
	Route::get('unit/{id}/edit', [UnitController::class, 'edit'])->name('unit.edit');
	Route::post('unit/{id}/update', [UnitController::class, 'update'])->name('unit.update');
	Route::get('unit/{id}/delete', [UnitController::class, 'distroy'])->name('unit.distroy');

	/*slider*/
	Route::get('slider', [SliderController::class, 'index'])->name('slider.index');
	Route::get('slider/create', [SliderController::class, 'create'])->name('slider.create');
	Route::post('slider/store', [SliderController::class, 'store'])->name('slider.store');
	Route::get('slider/{id}/edit', [SliderController::class, 'edit'])->name('slider.edit');
	Route::post('slider/{id}/update', [SliderController::class, 'update'])->name('slider.update');
	Route::get('slider/{id}/delete', [SliderController::class, 'distroy'])->name('slider.distroy');


	/*Videos*/
	Route::get('videos', [VideosController::class, 'index'])->name('videos.index');
	Route::get('videos/create', [VideosController::class, 'create'])->name('videos.create');
	Route::post('videos/store', [VideosController::class, 'store'])->name('videos.store');
	Route::get('videos/{id}/edit', [VideosController::class, 'edit'])->name('videos.edit');
	Route::post('videos/{id}/update', [VideosController::class, 'update'])->name('videos.update');
	Route::get('videos/{id}/delete', [VideosController::class, 'distroy'])->name('videos.distroy');

	/*solutions*/
	Route::get('solution', [SolutionController::class, 'index'])->name('solution.index');
	Route::get('solution/create', [SolutionController::class, 'create'])->name('solution.create');
	Route::post('solution/store', [SolutionController::class, 'store'])->name('solution.store');
	Route::get('solution/{id}/edit', [SolutionController::class, 'edit'])->name('solution.edit');
	Route::post('solution/{id}/update', [SolutionController::class, 'update'])->name('solution.update');
	Route::get('solution/{id}/delete', [SolutionController::class, 'distroy'])->name('solution.distroy');

	/*materials*/
	Route::get('material', [MaterialController::class, 'index'])->name('material.index');
	Route::get('material/create', [MaterialController::class, 'create'])->name('material.create');
	Route::post('material/store', [MaterialController::class, 'store'])->name('material.store');
	Route::get('material/{id}/edit', [MaterialController::class, 'edit'])->name('material.edit');
	Route::post('material/{id}/update', [MaterialController::class, 'update'])->name('material.update');
	Route::get('material/{id}/delete', [MaterialController::class, 'distroy'])->name('material.distroy');

	/*papers*/
	Route::get('paper', [PaperController::class, 'index'])->name('paper.index');
	Route::get('paper/create', [PaperController::class, 'create'])->name('paper.create');
	Route::post('paper/store', [PaperController::class, 'store'])->name('paper.store');
	Route::get('paper/{id}/edit', [PaperController::class, 'edit'])->name('paper.edit');
	Route::post('paper/{id}/update', [PaperController::class, 'update'])->name('paper.update');
	Route::get('paper/{id}/delete', [PaperController::class, 'distroy'])->name('paper.distroy');

	/*worksheet*/
	Route::get('worksheet', [WorksheetController::class, 'index'])->name('worksheet.index');
	Route::get('worksheet/create', [WorksheetController::class, 'create'])->name('worksheet.create');
	Route::post('worksheet/store', [WorksheetController::class, 'store'])->name('worksheet.store');
	Route::get('worksheet/{id}/edit', [WorksheetController::class, 'edit'])->name('worksheet.edit');
	Route::post('worksheet/{id}/update', [WorksheetController::class, 'update'])->name('worksheet.update');
	Route::get('worksheet/{id}/delete', [WorksheetController::class, 'distroy'])->name('worksheet.distroy');


});
