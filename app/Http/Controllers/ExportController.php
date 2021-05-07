<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
use App\Exports\BoardsExport;
use App\Exports\MediumsExport;
use App\Exports\StandardsExport;
use App\Exports\SemestersExport;
use App\Exports\SubjectsExport;
use App\Exports\UnitsExport;
use App\Exports\BooksExport;
use App\Exports\VideosExport;
use App\Exports\NotesExport;
use App\Exports\SolutionsExport;
use App\Exports\MaterialsExport;
use App\Exports\PapersExport;
use App\Exports\WorksheetsExport;


use App\Exports\BoardSampleExport;
use App\Exports\MediumSampleExport;
use App\Exports\StandardSampleExport;
use App\Exports\SubjectSampleExport;
use App\Exports\SemesterSampleExport;
use App\Exports\SolutionSampleExport;



use App\Models\Medium;
use App\Models\Standard;
use App\Models\Semester;
use App\Models\Subject;
use App\Models\Unit;
use App\Models\Book;
use App\Models\Videos;
use App\Models\Board;
use App\Models\Solution;
use App\Models\Note;
use App\Models\Material;
use App\Models\Paper;
use App\Models\Worksheet;



class ExportController extends Controller
{
    public function allDataExcel(){
    	return view('export.all_data_excel');	
    }

    public function getAllDataExcel(Request $request){
    	
    	if($request->module == "Board"){
    		return Excel::download(new BoardsExport, 'Boards.xlsx');
    	}
    	elseif($request->module == "Medium"){

    		$data = Medium::where(['status' => 'Active'])->get();
    		return Excel::download(new MediumsExport($data), 'Mediums.xlsx');
    	}
    	elseif($request->module == "Standard"){
    		$data = Standard::where(['status' => 'Active'])->get();
    		return Excel::download(new StandardsExport($data), 'Standards.xlsx');
    	}
    	elseif($request->module == "Semester"){
    		$data = Semester::where(['status' => 'Active'])->get();
    		return Excel::download(new SemestersExport($data), 'Semesters.xlsx');
    	}
    	elseif($request->module == "Subject"){
    		$data = Subject::where(['status' => 'Active'])->get();
    		return Excel::download(new SubjectsExport($data), 'Subjects.xlsx');
    	}
    	elseif($request->module == "Unit"){
    		$data = Unit::where(['status' => 'Active'])->get();
    		return Excel::download(new UnitsExport($data), 'Units.xlsx');
    	}
    	elseif($request->module == "Book"){
    		$data = Book::where(['status' => 'Active'])->get();
    		return Excel::download(new BooksExport($data), 'Books.xlsx');
    	}
    	elseif($request->module == "Video"){
    		$data = Videos::where(['status' => 'Active'])->get();
    		return Excel::download(new VideosExport($data), 'Videos.xlsx');
    	}
        elseif($request->module == "Note"){
            $data = Note::where(['status' => 'Active'])->get();
            return Excel::download(new NotesExport($data), 'Notes.xlsx');
        }
        elseif($request->module == "Solution"){
            $data = Solution::where(['status' => 'Active'])->get();
            return Excel::download(new SolutionsExport($data), 'Solutions.xlsx');
        }
        elseif($request->module == "Material"){
            $data = Material::where(['status' => 'Active'])->get();
            return Excel::download(new MaterialsExport($data), 'Materials.xlsx');
        }
        elseif($request->module == "Paper"){
            $data = Paper::where(['status' => 'Active'])->get();
            return Excel::download(new PapersExport($data), 'Papers.xlsx');
        }
        elseif($request->module == "Worksheet"){
            $data = Worksheet::where(['status' => 'Active'])->get();
            return Excel::download(new WorksheetsExport($data), 'Worksheets.xlsx');
        }
    }

    public function generateExcel(){
        $boards = Board::where('status','Active')->get();
    	return view('export.generate_excel',compact('boards'));
    }

    public function getGenerateExcel(Request $request){

        if($request->board_id != null && $request->medium_id == null && $request->standard_id == null && 
            $request->subject_id == null && $request->semester_id == null && $request->unit_id == null){
                $data = Board::where(['id' => $request->board_id])->first();
                return Excel::download(new BoardsExport($data), 'Boards.xlsx');
        }

        if($request->board_id != null && $request->medium_id != null && $request->standard_id == null && 
            $request->subject_id == null && $request->semester_id == null && $request->unit_id == null){

            if($request->medium_id != 'All'){
                $data = Medium::where(['board_id' => $request->board_id,'id' => $request->medium_id])->get();
                return Excel::download(new MediumsExport($data), 'Mediums.xlsx');
            }
            else{
                $data = Medium::where(['board_id' => $request->board_id])->get();
                return Excel::download(new MediumsExport($data), 'Mediums.xlsx');
            }
        }

        if($request->board_id != null && $request->medium_id != null && $request->standard_id != null && 
            $request->subject_id == null && $request->semester_id == null && $request->unit_id == null){

            if($request->standard_id != 'All'){
                $data = Standard::where(['board_id' => $request->board_id,'medium_id' => $request->medium_id,
                    'id' => $request->standard_id])->get();
                return Excel::download(new StandardsExport($data), 'Standards.xlsx');
            }
            else{
                $data = Standard::where(['board_id' => $request->board_id,'medium_id' => $request->medium_id])->get();
                return Excel::download(new StandardsExport($data), 'Standards.xlsx');
            }
        }

        if($request->board_id != null && $request->medium_id != null && $request->standard_id != null && 
            $request->subject_id != null && $request->semester_id == null && $request->unit_id == null){

           if($request->subject_id != 'All'){
                $data = Subject::where(['board_id' => $request->board_id,'medium_id' => $request->medium_id
                    ,'standard_id' => $request->standard_id,'id' => $request->subject_id])->get();
                return Excel::download(new SubjectsExport($data), 'Subjects.xlsx');
            }
            else{
                $data = Subject::where(['board_id' => $request->board_id,'medium_id' => $request->medium_id
                    ,'standard_id' => $request->standard_id])->get();
                return Excel::download(new SubjectsExport($data), 'Subjects.xlsx');
            } 
        }

        if($request->board_id != null && $request->medium_id != null && $request->standard_id != null && 
            $request->subject_id != null && $request->semester_id != null && $request->unit_id == null){

           if($request->semester_id != 'All'){
                $data = Semester::where(['board_id' => $request->board_id,'medium_id' => $request->medium_id
                    ,'standard_id' => $request->standard_id,'subject_id' => $request->subject_id,'id' => $request->semester_id])->get();
                return Excel::download(new SemestersExport($data), 'Semesters.xlsx');
            }
            else{
                $data = Semester::where(['board_id' => $request->board_id,'medium_id' => $request->medium_id,
                    'standard_id' => $request->standard_id,'subject_id' => $request->subject_id])->get();
                return Excel::download(new SemestersExport($data), 'Semesters.xlsx');
            } 
        }


        if($request->board_id != null && $request->medium_id != null && $request->standard_id != null && 
            $request->subject_id != null && $request->semester_id != null && $request->unit_id != null && $request->data_content == null){

           if($request->unit_id != 'All'){
                $data = Unit::where(['board_id' => $request->board_id,'medium_id' => $request->medium_id
                    ,'standard_id' => $request->standard_id,'subject_id' => $request->subject_id,
                    'semester_id' => $request->semester_id,'id' => $request->unit_id])->get();
                return Excel::download(new UnitsExport($data), 'Units.xlsx');
            }
            else{                
                $data = Unit::where(['board_id' => $request->board_id,'medium_id' => $request->medium_id
                    ,'standard_id' => $request->standard_id,'subject_id' => $request->subject_id,
                    'semester_id' => $request->semester_id])->get();
                return Excel::download(new UnitsExport($data), 'Units.xlsx');
            } 
        }

        if($request->board_id != null && $request->medium_id != null && $request->standard_id != null && 
            $request->subject_id != null && $request->semester_id != null && $request->unit_id != null 
            && $request->data_content != null){

            if($request->data_content == 'books'){

                if($request->unit_id=='All')
                {
                    $data = Book::where(['board_id' => $request->board_id,'medium_id' => $request->medium_id,
                    'standard_id' => $request->standard_id,'subject_id' => $request->subject_id,
                    'semester_id' => $request->semester_id,'status' => 'Active'])->get();
                }else
                {
                    $data = Book::where(['board_id' => $request->board_id,'medium_id' => $request->medium_id,
                    'standard_id' => $request->standard_id,'subject_id' => $request->subject_id,
                    'semester_id' => $request->semester_id,'unit_id' => $request->unit_id,'status' => 'Active'])->get();
                }

                return Excel::download(new BooksExport($data), 'Books.xlsx');
            }

            if($request->data_content == 'videos'){
                if($request->unit_id=='All')
                {
                    $data = Videos::where(['board_id' => $request->board_id,'medium_id' => $request->medium_id,
                    'standard_id' => $request->standard_id,'subject_id' => $request->subject_id,
                    'semester_id' => $request->semester_id,'status' => 'Active'])->get();
                }else
                {
                    $data = Videos::where(['board_id' => $request->board_id,'medium_id' => $request->medium_id,
                    'standard_id' => $request->standard_id,'subject_id' => $request->subject_id,
                    'semester_id' => $request->semester_id,'unit_id' => $request->unit_id,'status' => 'Active'])->get();
                }
                return Excel::download(new VideosExport($data), 'Videos.xlsx');
            }

            if($request->data_content == 'solutions'){
                if($request->unit_id=='All')
                {
                    $data = Solution::where(['board_id' => $request->board_id,'medium_id' => $request->medium_id,
                    'standard_id' => $request->standard_id,'subject_id' => $request->subject_id,
                    'semester_id' => $request->semester_id,'status' => 'Active'])->get();
                }else
                {
                    $data = Solution::where(['board_id' => $request->board_id,'medium_id' => $request->medium_id,
                    'standard_id' => $request->standard_id,'subject_id' => $request->subject_id,
                    'semester_id' => $request->semester_id,'unit_id' => $request->unit_id,'status' => 'Active'])->get();                    
                }
                return Excel::download(new SolutionSampleExport($data), 'Solutions.xlsx');
            }


        }    	
    }

    public function generateExcelSample(){
        $boards = Board::where('status','Active')->get();
    	return view('export.generate_excel_sample',compact('boards'));
    }

    public function getGenerateExcelSample(Request $request){

        if($request->board_id != null && $request->medium_id == null && $request->standard_id == null && 
            $request->subject_id == null && $request->semester_id == null && $request->unit_id == null){
                $data = Medium::where(['board_id' => $request->board_id])->get();
                return Excel::download(new MediumSampleExport($data), 'Mediums.xlsx');
        }

        if($request->board_id != null && $request->medium_id != null && $request->standard_id == null && 
            $request->subject_id == null && $request->semester_id == null && $request->unit_id == null){

            if($request->medium_id != 'All'){
                $data = Standard::where(['board_id' => $request->board_id,'medium_id' => $request->medium_id])->get();
                return Excel::download(new StandardSampleExport($data), 'Standards.xlsx');
            }
            else{
                $data = Standard::where(['board_id' => $request->board_id])->get();
                return Excel::download(new StandardSampleExport($data), 'Standards.xlsx');
            }
        }

        if($request->board_id != null && $request->medium_id != null && $request->standard_id != null && 
            $request->subject_id == null && $request->semester_id == null && $request->unit_id == null){

            if($request->standard_id != 'All'){
                $data = Subject::where(['board_id' => $request->board_id,'medium_id' => $request->medium_id
                ,'standard_id' => $request->standard_id])->get();
            return Excel::download(new SubjectSampleExport($data), 'Subjects.xlsx');
            }
            else{
                $data = Subject::where(['board_id' => $request->board_id,'medium_id' => $request->medium_id])->get();
                return Excel::download(new SubjectSampleExport($data), 'Subjects.xlsx');
            }
        }

        if($request->board_id != null && $request->medium_id != null && $request->standard_id != null && 
            $request->subject_id != null && $request->semester_id == null && $request->unit_id == null){

           if($request->subject_id != 'All'){
                $data = Semester::where(['board_id' => $request->board_id,'medium_id' => $request->medium_id,
                'standard_id' => $request->standard_id,'subject_id' => $request->subject_id])->get();
                return Excel::download(new SemesterSampleExport($data), 'Semesters.xlsx');
            }
            else{
                $data = Semester::where(['board_id' => $request->board_id,'medium_id' => $request->medium_id,
                    'standard_id' => $request->standard_id])->get();
                return Excel::download(new SemesterSampleExport($data), 'Semesters.xlsx');
            } 
        }

        if($request->board_id != null && $request->medium_id != null && $request->standard_id != null && 
            $request->subject_id != null && $request->semester_id != null && $request->unit_id == null){

           if($request->semester_id != 'All'){
                $data = Unit::where(['board_id' => $request->board_id,'medium_id' => $request->medium_id
                ,'standard_id' => $request->standard_id,'subject_id' => $request->subject_id,
                'semester_id' => $request->semester_id])->get();
                return Excel::download(new UnitsExport($data), 'Units.xlsx');
            }
            else{
                $data = Unit::where(['board_id' => $request->board_id,'medium_id' => $request->medium_id
                    ,'standard_id' => $request->standard_id,'subject_id' => $request->subject_id])->get();
                return Excel::download(new UnitsExport($data), 'Units.xlsx');
            } 
        }


        if($request->board_id != null && $request->medium_id != null && $request->standard_id != null && 
            $request->subject_id != null && $request->semester_id != null && $request->unit_id != null && $request->data_content != null){

                if($request->data_content == 'books'){

                    if($request->unit_id=='All')
                    {
                        $data = Book::where(['board_id' => $request->board_id,'medium_id' => $request->medium_id,
                        'standard_id' => $request->standard_id,'subject_id' => $request->subject_id,
                        'semester_id' => $request->semester_id,'status' => 'Active'])->get();
                    }else
                    {
                        $data = Book::where(['board_id' => $request->board_id,'medium_id' => $request->medium_id,
                        'standard_id' => $request->standard_id,'subject_id' => $request->subject_id,
                        'semester_id' => $request->semester_id,'unit_id' => $request->unit_id,'status' => 'Active'])->get();
                    }
    
                    return Excel::download(new BooksExport($data), 'Books.xlsx');
                }
    
                if($request->data_content == 'videos'){
                    if($request->unit_id=='All')
                    {
                        $data = Videos::where(['board_id' => $request->board_id,'medium_id' => $request->medium_id,
                        'standard_id' => $request->standard_id,'subject_id' => $request->subject_id,
                        'semester_id' => $request->semester_id,'status' => 'Active'])->get();
                    }else
                    {
                        $data = Videos::where(['board_id' => $request->board_id,'medium_id' => $request->medium_id,
                        'standard_id' => $request->standard_id,'subject_id' => $request->subject_id,
                        'semester_id' => $request->semester_id,'unit_id' => $request->unit_id,'status' => 'Active'])->get();
                    }
                    return Excel::download(new VideosExport($data), 'Videos.xlsx');
                }
    
                if($request->data_content == 'solutions'){
                    if($request->unit_id=='All')
                    {
                        $data = Solution::where(['board_id' => $request->board_id,'medium_id' => $request->medium_id,
                        'standard_id' => $request->standard_id,'subject_id' => $request->subject_id,
                        'semester_id' => $request->semester_id,'status' => 'Active'])->get();
                    }else
                    {
                        $data = Solution::where(['board_id' => $request->board_id,'medium_id' => $request->medium_id,
                        'standard_id' => $request->standard_id,'subject_id' => $request->subject_id,
                        'semester_id' => $request->semester_id,'unit_id' => $request->unit_id,'status' => 'Active'])->get();                    
                    }
                    return Excel::download(new SolutionSampleExport($data), 'Solutions.xlsx');
                }
        }
    }
}
