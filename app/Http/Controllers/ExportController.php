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

use App\Exports\BoardSampleExport;
use App\Exports\MediumSampleExport;

use App\Models\Medium;
use App\Models\Standard;
use App\Models\Semester;
use App\Models\Subject;
use App\Models\Unit;
use App\Models\Book;
use App\Models\Videos;
use App\Models\Board;

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
    }

    public function generateExcel(){
        $boards = Board::where('status','Active')->get();
    	return view('export.generate_excel',compact('boards'));
    }

    public function getGenerateExcel(Request $request){

        //dd($request->all());
        if($request->board_id != null && $request->medium_id == null && $request->standard_id == null && 
            $request->subject_id == null && $request->semester_id == null && $request->unit_id == null){
                $data = Board::where(['id' => $request->board_id])->first();
                return Excel::download(new BoardSampleExport($data), 'Boards.xlsx');
        }

        if($request->board_id != null && $request->medium_id != null && $request->standard_id == null && 
            $request->subject_id == null && $request->semester_id == null && $request->unit_id == null){

            if($request->medium_id != 'All'){
                $data = Medium::where(['board_id' => $request->board_id,'id' => $request->medium_id])->get();
                return Excel::download(new MediumSampleExport($data), 'Mediums.xlsx');
            }
            else{
                $data = Medium::where(['board_id' => $request->board_id])->get();
                return Excel::download(new MediumSampleExport($data), 'Mediums.xlsx');
            }
             
        }

  //       board_id" => "5"
  // "medium_id" => null
  // "standard_id" => null
  // "subject_id" => null
  // "semester_id" => null
  // "unit_id" => null
    	
    }





}
