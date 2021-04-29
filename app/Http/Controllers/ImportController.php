<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Excel;
use Session;

use App\Imports\BoardImport;
use App\Imports\MediumImport;
use App\Imports\StandardImport;
use App\Imports\SubjectImport;
use App\Imports\SemsterImport;
use App\Imports\UnitImport;
use App\Imports\BookImport;
use App\Imports\VideoImport;

class ImportController extends Controller
{
    public function importExcel(Request $request){
    	return view('import.index');
    }

    public function importExcelData(Request $request){

    	$request->validate([
    		'file' => 'required|mimes:xls,csv,xlsx'
    	]);

    	$msg = "File imported successfully.";

    	if($request->module == "Board"){
    		Excel::import(new BoardImport($request), request()->file('file'));
 	    	return redirect()->route('import_excel.index')->with('success',$msg);
    	}
    	elseif($request->module == "Medium"){
    		Excel::import(new MediumImport($request), request()->file('file'));
 	    	return redirect()->route('import_excel.index')->with('success',$msg);
    	}
    	elseif($request->module == "Standard"){
    		Excel::import(new StandardImport($request), request()->file('file'));
 	    	return redirect()->route('import_excel.index')->with('success',$msg);
    	}
    	elseif($request->module == "Semester"){
    		Excel::import(new SemsterImport($request), request()->file('file'));
 	    	return redirect()->route('import_excel.index')->with('success',$msg);
    	}
    	elseif($request->module == "Subject"){
    		Excel::import(new SubjectImport($request), request()->file('file'));
 	    	return redirect()->route('import_excel.index')->with('success',$msg);
    	}
    	elseif($request->module == "Unit"){
    		Excel::import(new UnitImport($request), request()->file('file'));
 	    	return redirect()->route('import_excel.index')->with('success',$msg);
    	}
    	elseif($request->module == "Book"){
    		Excel::import(new BookImport($request), request()->file('file'));
 	    	return redirect()->route('import_excel.index')->with('success',$msg);
    	}
    	elseif($request->module == "Video"){
    		Excel::import(new VideoImport($request), request()->file('file'));
 	    	return redirect()->route('import_excel.index')->with('success',$msg);
    	}
    }

}
