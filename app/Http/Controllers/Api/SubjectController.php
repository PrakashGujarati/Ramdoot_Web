<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Semester;
use App\Models\Board;
use App\Models\Book;
use App\Models\Unit;
use App\Models\Standard;
use App\Models\Subject;
use App\Models\pdf_view;
use App\Models\Note;
use App\Models\Paper;
use App\Models\Worksheet;
use DB;
use Validator;
use App\Models\Feature;
use App\Models\Videos;
use App\Models\Material;
use App\Models\Question;
use App\Models\Solution;

class SubjectController extends Controller
{
    
    public function subjectList(Request $request){

    	$rules = array(
            'board_id' => 'required',
            'standard_id' => 'required',
            'semester_id' => 'required',
            'feature_id' => 'required'
        );
        $messages = array(
            'board_id.required' => 'Please enter board id.',
            'standard_id.required' => 'Please enter standard id.',
            'semester_id.required' => 'Please enter semester id.',
            'feature_id.required' => 'Please enter feature id.'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $chkbaord = Board::where(['id' => $request->board_id,'status' => 'Active'])->first();
        $chkstandard = Standard::where(['id' => $request->standard_id,'status' => 'Active'])->first();
        $chksemester = Semester::where(['id' => $request->semester_id,'status' => 'Active'])->first();
        //$chkfeatures = Feature::where(['id' => $request->feature_id,'status' => 'Active'])->first();
        if(empty($chkbaord)){
        	return response()->json([
    			"code" => 400,
			  	"message" => "Board not found.",
			  	"data" => [],
	        ]);
        }
        elseif (empty($chkstandard)) {
        	return response()->json([
    			"code" => 400,
			  	"message" => "Standard not found.",
			  	"data" => [],
	        ]);
        }
        elseif (empty($chksemester)) {
        	return response()->json([
    			"code" => 400,
			  	"message" => "Semester not found.",
			  	"data" => [],
	        ]);
        }
        /*elseif (empty($chkfeatures)) {
            return response()->json([
                "code" => 400,
                "message" => "Feature not found.",
                "data" => [],
            ]);
        }*/
        else{
			$getdata = Subject::where(['board_id' => $request->board_id,'standard_id' => $request->standard_id,'semester_id' => $request->semester_id,'status' => 'Active'])->orderBy('order_no','asc')->get();
			$subjectids = Subject::where(['board_id' => $request->board_id,'standard_id' => $request->standard_id,'semester_id' => $request->semester_id,'status' => 'Active'])->orderBy('order_no','asc')->pluck('id');
			//$unitcount = Unit::whereIn('subject_id',$subjectids)->count();
            //$featurecount = Feature::whereIn('subject_id',$subjectids)->count();
           
	    	if(count($getdata) > 0){
	    		$data=[];
                
                $totalcount=0;
                
	    		foreach ($getdata as $value) {
                    $readcount=0;
                    $url = env('APP_URL')."/upload/subject/url/".$value->url;
	    			$thumbnail = env('APP_URL')."/upload/subject/thumbnail/".$value->thumbnail;
                    if($request->feature_id == 3){
                        $totalcount = Book::where('subject_id',$value->id)->count();
                        $books = Book::where('subject_id',$value->id)->orderBy('order_no','asc')->get();
                        foreach($books as $book)
                        {
                            $c = pdf_view::where(['type' => 'Textbook','type_id' => $book->id])->count();
                            if($c)
                            {
                                $readcount++;
                            }
                        }
                    }
                    elseif ($request->feature_id == 9) {
                        $totalcount = Note::where('subject_id',$value->id)->count();
                        $notes = Note::where('subject_id',$value->id)->orderBy('order_no','asc')->get();
                        foreach($notes as $note)
                        {
                            $c = pdf_view::where(['type' => 'Note','type_id' => $note->id])->count();
                            if($c)
                            {
                                $readcount++;
                            }
                        }
                    }
                    elseif ($request->feature_id == 7) {
                        $totalcount = Worksheet::where('subject_id',$value->id)->count();
                        $worksheets = Worksheet::where('subject_id',$value->id)->orderBy('order_no','asc')->get();
                        foreach($worksheets as $worksheet)
                        {
                            $c = pdf_view::where(['type' => 'Worksheet','type_id' => $worksheet->id])->count();
                            if($c)
                            {
                                $readcount++;
                            }
                        }
                    }
                    elseif ($request->feature_id == 6) {
                        $totalcount = Paper::where('subject_id',$value->id)->count();
                        $papers = Paper::where('subject_id',$value->id)->orderBy('order_no','asc')->get();
                        foreach($papers as $paper)
                        {
                            $c = pdf_view::where(['type' => 'Paper','type_id' => $paper->id])->count();
                            if($c)
                            {
                                $readcount++;
                            }
                        }
                    }
                    elseif ($request->feature_id == 2){
                        $totalcount = Videos::where('subject_id',$value->id)->count();
                        $videos = Videos::where('subject_id',$value->id)->orderBy('order_no','asc')->get();
                        foreach($videos as $video)
                        {
                            $c = pdf_view::where(['type' => 'Video','type_id' => $video->id])->count();
                            if($c)
                            {
                                $readcount++;
                            }
                        }   
                    }
                    elseif ($request->feature_id == 5){
                        
                        $totalcount = Material::where('subject_id',$value->id)->count();
                        $materials = Material::where('subject_id',$value->id)->orderBy('order_no','asc')->get();
                        foreach($materials as $material)
                        {
                            $c = pdf_view::where(['type' => 'Material','type_id' => $material->id])->count();
                            if($c)
                            {
                                $readcount++;
                            }
                        }   
                    }
                    elseif($request->feature_id == 8){
                        $totalcount = Question::where('subject_id',$value->id)->count();
                        $Questions = Question::where('subject_id',$value->id)->get();
                        foreach($Questions as $Question)
                        {
                            $c = pdf_view::where(['type' => 'MCQ','type_id' => $Question->id])->count();
                            if($c)
                            {
                                $readcount++;
                            }
                        }
                    }
                    elseif($request->feature_id == 4){
                        $totalcount = Solution::where('subject_id',$value->id)->count();
                        $solutions = Solution::where('subject_id',$value->id)->orderBy('order_no','asc')->get();
                        foreach($solutions as $solution)
                        {
                            $c = pdf_view::where(['type' => 'Exercise','type_id' => $solution->id])->count();
                            if($c)
                            {
                                $readcount++;
                            }
                        }
                    }
                    

	    			$data[] = ['id' => $value->id,'name' => $value->subject_name,'sub_title' => $value->sub_title,'url' => $url,'thumbnail' => $thumbnail,"total_count"=>$totalcount,"readcount"=>$readcount,'count_label'=>"Total "];
	    		}
                //remove unit counter and add counter of feature whether it is video or image and send message of that for ex total video,etc 

	    		return response()->json([
	    			"code" => 200,
				  	"message" => "success",
				  	"data" => $data,
		        ]);
	    	}
	    	else{
	    		return response()->json([
	    			"code" => 400,
				  	"message" => "Subject details not found.",
	 			  	"data" => [],
		        ]);
	    	}	
        }
    }
}
