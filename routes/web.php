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
use App\Http\Controllers\McqController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ExamQuestionController;
use App\Http\Controllers\ExamStudentController;
use App\Http\Controllers\StudentQuestionAnswerController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\MediumController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SpatieRolePermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QuestionTypeController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\UserDataReviewController;
use App\Http\Controllers\ExportController;

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
Route::get('getData',[HomeController::class,'getData']);
Route::get('getDataUnit',[HomeController::class,'getDataUnit']);

Route::get('get_order_data',[HomeController::class,'get_order_data']);
Route::group(['middleware' => 'auth'], function(){
	Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
	/*board*/
	Route::get('/board', [BoardController::class, 'index'])->name('board.index');
	Route::get('board/create', [BoardController::class, 'create'])->name('board.create');
	Route::post('board/store', [BoardController::class, 'store'])->name('board.store');
	Route::get('board/edit', [BoardController::class, 'edit'])->name('board.edit');
	Route::post('board/{id}/update', [BoardController::class, 'update'])->name('board.update');
	Route::get('board/delete', [BoardController::class, 'distroy'])->name('board.distroy');
	Route::get('board_export', [BoardController::class, 'boardExport'])->name('board.export');

	/*Standard*/
	Route::get('standard', [StandardController::class, 'index'])->name('standard.index');
	Route::get('standard/create/{medium_id?}', [StandardController::class, 'create'])->name('standard.create');
	Route::post('standard/store', [StandardController::class, 'store'])->name('standard.store');
	Route::get('standard/edit', [StandardController::class, 'edit'])->name('standard.edit');
	Route::post('standard/{id}/update', [StandardController::class, 'update'])->name('standard.update');
	Route::get('standard/delete', [StandardController::class, 'distroy'])->name('standard.distroy');
	Route::get('standard_export', [StandardController::class, 'standardExport'])->name('standard.export');
	Route::get('get_standard_export', [StandardController::class, 'get_excel_Standard'])->name('get.standard.export');



	Route::get('get_standard', [StandardController::class, 'getStandard'])->name('get.standard');

	/*Subjects*/
	Route::get('subject', [SubjectController::class, 'index'])->name('subject.index');
	Route::get('subject/create/{semester_id?}', [SubjectController::class, 'create'])->name('subject.create');
	Route::post('subject/store', [SubjectController::class, 'store'])->name('subject.store');
	Route::get('subject/edit', [SubjectController::class, 'edit'])->name('subject.edit');
	Route::post('subject/{id}/update', [SubjectController::class, 'update'])->name('subject.update');
	Route::get('subject/delete', [SubjectController::class, 'distroy'])->name('subject.distroy');
	Route::get('subject_export', [SubjectController::class, 'subjectExport'])->name('subject.export');
	Route::get('get_subject_export', [SubjectController::class, 'get_excel_subject'])->name('get.subject.export');

	Route::get('get_subject', [SubjectController::class, 'getSubject'])->name('get.subject');

	/*Book*/
	Route::get('book', [BookController::class, 'index'])->name('book.index');
	Route::get('book/create/{subject_id?}', [BookController::class, 'create'])->name('book.create');
	Route::post('book/store', [BookController::class, 'store'])->name('book.store');
	Route::get('book/edit', [BookController::class, 'edit'])->name('book.edit');
	Route::post('book/{id}/update', [BookController::class, 'update'])->name('book.update');
	Route::get('book/delete', [BookController::class, 'distroy'])->name('book.distroy');
	Route::get('book_export', [BookController::class, 'bookExport'])->name('book.export');

	/*Book*/
	Route::get('medium', [MediumController::class, 'index'])->name('medium.index');
	Route::get('medium/create/{board_id?}', [MediumController::class, 'create'])->name('medium.create');
	Route::post('medium/store', [MediumController::class, 'store'])->name('medium.store');
	Route::get('medium/edit', [MediumController::class, 'edit'])->name('medium.edit');
	Route::post('medium/{id}/update', [MediumController::class, 'update'])->name('medium.update');
	Route::get('medium/delete', [MediumController::class, 'distroy'])->name('medium.distroy');
	Route::get('medium_export', [MediumController::class, 'mediumExport'])->name('medium.export');
	Route::get('get_medium', [MediumController::class, 'getMedium'])->name('get.medium');
	Route::get('get_medium_excel', [MediumController::class, 'get_excel_Medium'])->name('get.medium.excel');
	/* */
	Route::get('note', [NoteController::class, 'index'])->name('note.index');
	Route::get('note/create/{subject_id?}', [NoteController::class, 'create'])->name('note.create');
	Route::post('note/store', [NoteController::class, 'store'])->name('note.store');
	Route::get('note/edit', [NoteController::class, 'edit'])->name('note.edit');
	Route::post('note/{id}/update', [NoteController::class, 'update'])->name('note.update');
	Route::get('note/delete', [NoteController::class, 'distroy'])->name('note.distroy');
	
	/*Semester*/
	Route::get('semester', [SemesterController::class, 'index'])->name('semester.index');
	Route::get('semester/create/{standard_id?}', [SemesterController::class, 'create'])->name('semester.create');
	Route::post('semester/store', [SemesterController::class, 'store'])->name('semester.store');
	Route::get('semester/edit', [SemesterController::class, 'edit'])->name('semester.edit');
	Route::post('semester/{id}/update', [SemesterController::class, 'update'])->name('semester.update');
	Route::get('semester/delete', [SemesterController::class, 'distroy'])->name('semester.distroy');
	Route::get('semester_export', [SemesterController::class, 'semesterExport'])->name('semester.export');
	Route::get('get_semester_export', [SemesterController::class, 'get_excel_semester'])->name('get.semester.export');

	Route::get('load_semester', [SemesterController::class, 'loadSemester'])->name('load.semester');
	

	Route::get('get_semester', [SemesterController::class, 'getSemester'])->name('get.semester');
	Route::get('get_semester_unit', [SemesterController::class, 'getSemesterUnit'])->name('get.semester.unit');

	/*unit*/
	Route::get('unit', [UnitController::class, 'index'])->name('unit.index');
	Route::get('unit/create/{subject_id?}', [UnitController::class, 'create'])->name('unit.create');
	Route::post('unit/store', [UnitController::class, 'store'])->name('unit.store');
	Route::get('unit/edit', [UnitController::class, 'edit'])->name('unit.edit');
	Route::post('unit/{id}/update', [UnitController::class, 'update'])->name('unit.update');
	Route::get('unit/delete', [UnitController::class, 'distroy'])->name('unit.distroy');
	Route::get('unit_export', [UnitController::class, 'unitExport'])->name('unit.export');
	Route::get('get_unit', [UnitController::class, 'getUnit'])->name('get.unit');
	Route::get('get_unit_export', [UnitController::class, 'get_excel_unit'])->name('get.unit.export');
	Route::get('get_datacontent_export', [UnitController::class, 'getDataContentExport'])->name('get.datacontent.export');

	/*slider*/
	Route::get('slider', [SliderController::class, 'index'])->name('slider.index');
	Route::get('slider/create', [SliderController::class, 'create'])->name('slider.create');
	Route::post('slider/store', [SliderController::class, 'store'])->name('slider.store');
	Route::get('slider/{id}/edit', [SliderController::class, 'edit'])->name('slider.edit');
	Route::post('slider/{id}/update', [SliderController::class, 'update'])->name('slider.update');
	Route::get('slider/{id}/delete', [SliderController::class, 'distroy'])->name('slider.distroy');


	/*Videos*/
	Route::get('videos', [VideosController::class, 'index'])->name('videos.index');
	Route::get('videos/create/{subject_id?}', [VideosController::class, 'create'])->name('videos.create');
	Route::post('videos/store', [VideosController::class, 'store'])->name('videos.store');
	Route::get('videos/edit', [VideosController::class, 'edit'])->name('videos.edit');
	Route::post('videos/{id}/update', [VideosController::class, 'update'])->name('videos.update');
	Route::get('videos/delete', [VideosController::class, 'distroy'])->name('videos.distroy');
	Route::get('videos_export', [VideosController::class, 'videosExport'])->name('videos.export');

	/*solutions*/
	Route::get('solution', [SolutionController::class, 'index'])->name('solution.index');
	Route::get('solution/create/{subject_id?}', [SolutionController::class, 'create'])->name('solution.create');
	Route::post('solution/store', [SolutionController::class, 'store'])->name('solution.store');
	Route::get('solution/edit', [SolutionController::class, 'edit'])->name('solution.edit');
	Route::post('solution/{id}/update', [SolutionController::class, 'update'])->name('solution.update');
	Route::get('solution/delete', [SolutionController::class, 'distroy'])->name('solution.distroy');


	/*materials*/
	Route::get('material', [MaterialController::class, 'index'])->name('material.index');
	Route::get('material/create/{subject_id?}', [MaterialController::class, 'create'])->name('material.create');
	Route::post('material/store', [MaterialController::class, 'store'])->name('material.store');
	Route::get('material/edit', [MaterialController::class, 'edit'])->name('material.edit');
	Route::post('material/{id}/update', [MaterialController::class, 'update'])->name('material.update');
	Route::get('material/delete', [MaterialController::class, 'distroy'])->name('material.distroy');

	/*papers*/
	Route::get('paper', [PaperController::class, 'index'])->name('paper.index');
	Route::get('paper/create/{subject_id?}', [PaperController::class, 'create'])->name('paper.create');
	Route::post('paper/store', [PaperController::class, 'store'])->name('paper.store');
	Route::get('paper/edit', [PaperController::class, 'edit'])->name('paper.edit');
	Route::post('paper/{id}/update', [PaperController::class, 'update'])->name('paper.update');
	Route::get('paper/delete', [PaperController::class, 'distroy'])->name('paper.distroy');

	/*worksheet*/
	Route::get('worksheet', [WorksheetController::class, 'index'])->name('worksheet.index');
	Route::get('worksheet/create/{subject_id?}', [WorksheetController::class, 'create'])->name('worksheet.create');
	Route::post('worksheet/store', [WorksheetController::class, 'store'])->name('worksheet.store');
	Route::get('worksheet/edit', [WorksheetController::class, 'edit'])->name('worksheet.edit');
	Route::post('worksheet/{id}/update', [WorksheetController::class, 'update'])->name('worksheet.update');
	Route::get('worksheet/delete', [WorksheetController::class, 'distroy'])->name('worksheet.distroy');

	/*mcqs*/
	Route::get('mcq', [McqController::class, 'index'])->name('mcq.index');
	Route::get('mcq/create', [McqController::class, 'create'])->name('mcq.create');
	Route::post('mcq/store', [McqController::class, 'store'])->name('mcq.store');
	Route::get('mcq/{id}/edit', [McqController::class, 'edit'])->name('mcq.edit');
	Route::post('mcq/{id}/update', [McqController::class, 'update'])->name('mcq.update');
	Route::get('mcq/{id}/delete', [McqController::class, 'distroy'])->name('mcq.distroy');

	/*question*/
	Route::get('question', [QuestionController::class, 'index'])->name('question.index');
	Route::get('question/create', [QuestionController::class, 'create'])->name('question.create');
	Route::post('question/store', [QuestionController::class, 'store'])->name('question.store');
	Route::get('question/{id}/edit', [QuestionController::class, 'edit'])->name('question.edit');
	Route::post('question/{id}/update', [QuestionController::class, 'update'])->name('question.update');
	Route::get('question/{id}/delete', [QuestionController::class, 'distroy'])->name('question.distroy');
	Route::get('import_question_view', [QuestionController::class, 'importQuestionView'])->name('import.question.view');
	Route::post('question_import', [QuestionController::class, 'questionImport'])->name('question.import');
	Route::get('question_export', [QuestionController::class, 'questionExport'])->name('question.export');
	
	/*exam*/
	Route::get('exams', [ExamController::class, 'index'])->name('exam.index');
	Route::get('exams/create', [ExamController::class, 'create'])->name('exam.create');
	Route::post('exams/store', [ExamController::class, 'store'])->name('exam.store');
	Route::get('exams/{id}/edit', [ExamController::class, 'edit'])->name('exam.edit');
	Route::post('exams/{id}/update', [ExamController::class, 'update'])->name('exam.update');
	Route::get('exams/{id}/delete', [ExamController::class, 'distroy'])->name('exam.distroy');

	Route::get('get_exam', [ExamController::class, 'getExam'])->name('get.exam');

	/*exam_question*/
	Route::get('exam_question', [ExamQuestionController::class, 'index'])->name('exam_question.index');
	Route::get('exam_question/create', [ExamQuestionController::class, 'create'])->name('exam_question.create');
	Route::post('exam_question/store', [ExamQuestionController::class, 'store'])->name('exam_question.store');
	Route::get('exam_question/{id}/edit', [ExamQuestionController::class, 'edit'])->name('exam_question.edit');
	Route::post('exam_question/{id}/update', [ExamQuestionController::class, 'update'])->name('exam_question.update');
	Route::get('exam_question/{id}/delete', [ExamQuestionController::class, 'distroy'])->name('exam_question.distroy');

	Route::get('get_exam_detail', [ExamQuestionController::class, 'getExamDetail'])->name('get.exam.detail');

	Route::get('view_exam_list', [ExamQuestionController::class, 'viewExamList'])->name('view.exam.list');

	Route::get('get_question_view', [ExamQuestionController::class, 'getQuestionView'])->name('get.question.view');
	Route::get('get_question_change', [ExamQuestionController::class, 'getQuestionChange'])->name('get.question.change');

	Route::get('question_clear', [ExamQuestionController::class, 'getQuestionClear'])->name('question.clear');
	/*exam_student*/
	Route::get('exam_student', [ExamStudentController::class, 'index'])->name('exam_student.index');
	Route::get('exam_student/create', [ExamStudentController::class, 'create'])->name('exam_student.create');
	Route::post('exam_student/store', [ExamStudentController::class, 'store'])->name('exam_student.store');
	Route::get('exam_student/{id}/edit', [ExamStudentController::class, 'edit'])->name('exam_student.edit');
	Route::post('exam_student/{id}/update', [ExamStudentController::class, 'update'])->name('exam_student.update');
	Route::get('exam_student/{id}/delete', [ExamStudentController::class, 'distroy'])->name('exam_student.distroy');

	Route::get('get_exam_student', [ExamStudentController::class, 'index'])->name('get.examStudent');
	
	
	/*exam_student_question_answer*/
	Route::get('student_question_answer', [StudentQuestionAnswerController::class, 'index'])->name('exam_student_question_answer.index');
	//Route::get('exam_student_question_answer/{id}/delete', [StudentQuestionAnswerController::class, 'distroy'])->name('exam_student_question_answer.distroy');

	/*feature*/
	Route::get('feature', [FeatureController::class, 'index'])->name('feature.index');
	Route::get('feature/create', [FeatureController::class, 'create'])->name('feature.create');
	Route::post('feature/store', [FeatureController::class, 'store'])->name('feature.store');
	Route::get('feature/{id}/edit', [FeatureController::class, 'edit'])->name('feature.edit');
	Route::post('feature/{id}/update', [FeatureController::class, 'update'])->name('feature.update');
	Route::get('feature/{id}/delete', [FeatureController::class, 'distroy'])->name('feature.distroy');

	/*feature*/
	Route::get('question_type', [QuestionTypeController::class, 'index'])->name('question_type.index');
	Route::get('question_type/create', [QuestionTypeController::class, 'create'])->name('question_type.create');
	Route::post('question_type/store', [QuestionTypeController::class, 'store'])->name('question_type.store');
	Route::get('question_type/edit', [QuestionTypeController::class, 'edit'])->name('question_type.edit');
	Route::post('question_type/{id}/update', [QuestionTypeController::class, 'update'])->name('question_type.update');
	Route::get('question_type/delete', [QuestionTypeController::class, 'distroy'])->name('question_type.distroy');



	Route::get('settings',[SettingController::class,'setting'])->name('settings');

	Route::get('permission', [PermissionController::class, 'index'])->name('permission.index');
	Route::get('permission/create', [PermissionController::class, 'create'])->name('permission.create');
	Route::post('permission/store', [PermissionController::class, 'store'])->name('permission.store');
	Route::get('permission/{id}/edit', [PermissionController::class, 'edit'])->name('permission.edit');
	Route::post('permission/{id}/update', [PermissionController::class, 'update'])->name('permission.update');
	Route::get('permission/{id}/delete', [PermissionController::class, 'distroy'])->name('permission.distroy');	

	Route::get('role_permission', [SpatieRolePermissionController::class, 'index_roles'])->name('role_permission.index');
	//Route::get('/roles', [SpatieRolePermissionController::class, 'index_roles'])->name('role.get');
	Route::get('/roles', [SpatieRolePermissionController::class, 'new_roles'])->name('role.get');

	Route::post('/role/{role_id}/assign-permissions',[SpatieRolePermissionController::class, 'assign_permissions'])->name('role.assign_permission');
		
	Route::get('user/index',[UserController::class,'index'])->name('user.index');
	Route::get('user/create',[UserController::class,'create'])->name('user.create');
	Route::post('user/store',[UserController::class,'store'])->name('user.store');
	Route::get('user/edit/{id}',[UserController::class,'edit'])->name('user.edit');
	Route::post('user/update',[UserController::class,'update'])->name('user.update');
	Route::get('user/distroy/{id}',[UserController::class,'distroy'])->name('user.distroy');

	Route::get('user/log',[LogController::class,'index'])->name('user.log');
	Route::get('ajax/user/log',[LogController::class,'getData'])->name('user_ajax.log');
		
	Route::get('load_autocomplete/medium',[MediumController::class,'load_autocomplete'])->name('load_autocomplete.medium');
	Route::get('load_autocomplete/standard',[StandardController::class,'load_autocomplete'])->name('load_autocomplete.standard');
	Route::get('load_autocomplete/section',[StandardController::class,'load_autocomplete_section'])->name('load_autocomplete.section');

	Route::get('load_autocomplete/book',[BookController::class,'load_autocomplete'])->name('load_autocomplete.book');
	Route::get('load_autocomplete/book_title',[BookController::class,'load_autocomplete_title'])->name('load_autocomplete.book_title');



	Route::get('load_autocomplete/worksheet',[WorksheetController::class,'load_autocomplete'])->name('load_autocomplete.worksheet');
	Route::get('load_autocomplete/worksheet_title',[WorksheetController::class,'load_autocomplete_title'])->name('load_autocomplete.worksheet_title');


	Route::get('load_autocomplete/paper',[PaperController::class,'load_autocomplete'])->name('load_autocomplete.paper');
	Route::get('load_autocomplete/paper_title',[PaperController::class,'load_autocomplete_title'])->name('load_autocomplete.paper_title');


	Route::get('load_autocomplete/note',[NoteController::class,'load_autocomplete'])->name('load_autocomplete.note');
	Route::get('load_autocomplete/note_title',[NoteController::class,'load_autocomplete_title'])->name('load_autocomplete.note_title');
	

	Route::get('load_autocomplete/subject',[SubjectController::class,'load_autocomplete'])->name('load_autocomplete.subject');

	Route::get('load_autocomplete/subject_sub_title',[SubjectController::class,'load_autocomplete_sub_title'])->name('load_autocomplete.subject_sub_title');

	Route::get('load_autocomplete/unit',[UnitController::class,'load_autocomplete'])->name('load_autocomplete.unit');

	Route::get('load_autocomplete/unit_sub_title',[UnitController::class,'load_autocomplete_sub_title'])->name('load_autocomplete.unit_sub_title');

	
	Route::get('load_autocomplete/video',[VideosController::class,'load_autocomplete'])->name('load_autocomplete.video');

	Route::get('load_autocomplete/video_sub_title',[VideosController::class,'load_autocomplete_sub_title'])->name('load_autocomplete.video_sub_title');	

	Route::get('user/reviews',[UserDataReviewController::class,'index'])->name('user.reviews');
	Route::get('user_ajax/review',[UserDataReviewController::class,'user_ajax_review'])->name('user_ajax.review');
	Route::get('accept/review/{id}',[UserDataReviewController::class,'accept_review'])->name('accept.review');
	Route::get('reject/review/{id}',[UserDataReviewController::class,'reject_review'])->name('reject.review');

	Route::get('load_autocomplete/semester',[SemesterController::class,'load_autocomplete'])->name('load_autocomplete.semester');

	Route::get('above_order/board',[BoardController::class,'above_order_board'])->name('above_order.board');
	Route::get('below_order/board',[BoardController::class,'below_order_board'])->name('below_order.board');

	Route::get('above_order/medium',[MediumController::class,'above_order'])->name('above_order.medium');
	Route::get('below_order/medium',[MediumController::class,'below_order'])->name('below_order.medium');

	Route::get('above_order/standard',[StandardController::class,'above_order'])->name('above_order.standard');
	Route::get('below_order/standard',[StandardController::class,'below_order'])->name('below_order.standard');

	Route::get('above_order/semester',[SemesterController::class,'above_order'])->name('above_order.semester');
	Route::get('below_order/semester',[SemesterController::class,'below_order'])->name('below_order.semester');

	Route::get('above_order/subject',[SubjectController::class,'above_order'])->name('above_order.subject');
	Route::get('below_order/subject',[SubjectController::class,'below_order'])->name('below_order.subject');	

	Route::get('above_order/unit',[UnitController::class,'above_order'])->name('above_order.unit');
	Route::get('below_order/unit',[UnitController::class,'below_order'])->name('below_order.unit');

	Route::get('above_order/book',[BookController::class,'above_order'])->name('above_order.book');
	Route::get('below_order/book',[BookController::class,'below_order'])->name('below_order.book');

	Route::get('above_order/note',[NoteController::class,'above_order'])->name('above_order.note');
	Route::get('below_order/note',[NoteController::class,'below_order'])->name('below_order.note');

	Route::get('above_order/video',[VideosController::class,'above_order'])->name('above_order.video');
	Route::get('below_order/video',[VideosController::class,'below_order'])->name('below_order.video');

	Route::get('above_order/solution',[SolutionController::class,'above_order'])->name('above_order.solution');
	Route::get('below_order/solution',[SolutionController::class,'below_order'])->name('below_order.solution');	

	Route::get('above_order/material',[MaterialController::class,'above_order'])->name('above_order.material');
	Route::get('below_order/material',[MaterialController::class,'below_order'])->name('below_order.material');

	Route::get('above_order/paper',[PaperController::class,'above_order'])->name('above_order.paper');
	Route::get('below_order/paper',[PaperController::class,'below_order'])->name('below_order.paper');

	Route::get('above_order/worksheet',[WorksheetController::class,'above_order'])->name('above_order.worksheet');
	Route::get('below_order/worksheet',[WorksheetController::class,'below_order'])->name('below_order.worksheet');

	Route::post('question/blank_export',[QuestionController::class,'blank_export'])->name('question.blank_export');
	Route::post('import/bluck_question',[QuestionController::class,'import_bluck_question'])->name('import.bluck_question');

	/*export*/
	Route::get('/all_data_excel',[ExportController::class,'allDataExcel'])->name('all_data_excel.index');
	Route::post('/get_all_data_excel',[ExportController::class,'getAllDataExcel'])->name('get.all_data_excel');

	Route::get('/generate_specific_excel',[ExportController::class,'generateExcel'])->name('generate.specific.excel');
	Route::post('/get_generate_specific_excel',[ExportController::class,'getGenerateExcel'])->name('get.generate.specific.excel');

	Route::get('/generate_excel_sample',[ExportController::class,'generateExcelSample'])->name('generate.excel.sample');
	Route::post('/get_generate_excel_sample',[ExportController::class,'getGenerateExcelSample'])->name('get.generate.excel.sample');

});	
