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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['middleware' => 'auth'], function(){
	Route::get('/', [HomeController::class, 'index'])->name('dashboard');


	/*board*/
	Route::get('board', [BoardController::class, 'index'])->name('board.index');
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
	

});

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');
