<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Board;
use App\Models\Medium;
use App\Models\Standard;
use App\Models\Semester;
use App\Models\Subject;
use App\Models\SemesterNew;
use App\Models\Unit;
use App\Models\Videos;
use App\Models\Book;

class HomeController extends Controller
{
    public function index(){
    	return view('dashboard');
    }
    public function get_order_data()
    {
    	$boards=Board::where('status','Active')->get();
    	if(count($boards) > 0)
    	{
    		foreach ($boards as $key => $board) {
    			$upd=Board::find($board->id);
    			$upd->order_no=$key+1;
    			$upd->save();
    		}
    	}

    	$mediums=Medium::where('status','Active')->get();
    	if(count($mediums) > 0)
    	{
    		foreach ($mediums as $key => $medium) {
    			$upd=Medium::find($medium->id);
    			$upd->order_no=$key+1;
    			$upd->save();
    		}
    	}
    	$standards=Standard::where('status','Active')->get();
    	if(count($standards) > 0)
    	{
    		foreach ($standards as $key => $standard) {
    			$upd=Standard::find($standard->id);
    			$upd->order_no=$key+1;
    			$upd->save();
    		}
    	}

    	$semesters=Semester::where('status','Active')->get();
    	if(count($semesters) > 0)
    	{
    		foreach ($semesters as $key => $semester) {
    			$upd=Semester::find($semester->id);
    			$upd->order_no=$key+1;
    			$upd->save();
    		}
    	}
    }
    //convert subject to new semester
    public function getData()
    {
        $groups=Subject::select('*')->groupBy('subject_name')->orderBy('id','asc')->get();   
        if(count($groups) > 0)
        {
            \DB::statement("TRUNCATE `ramdoot_live`.`semesters_new`");
            foreach ($groups as $group) {
                $groupData=Subject::select('*')->where('subject_name',$group->subject_name)->get();
                if(count($groupData) > 0)
                {
                    foreach ($groupData as  $data) {
                        $getSemester=Semester::where('id',$data->semester_id)->first();
                            $addnew=new SemesterNew;
                            $addnew->board_id=$getSemester->board_id;
                            $addnew->medium_id=$getSemester->medium_id;
                            $addnew->standard_id=$getSemester->standard_id;
                            $addnew->subject_id=$group->id;
                            $addnew->semester=$getSemester->semester;
                            $addnew->status=$getSemester->status;
                            $addnew->order_no=$getSemester->order_no;
                            $addnew->save();

                            $unit=Unit::where('subject_id',$data->id)->where('semester_id',$data->semester_id)->get();
                            if(count($unit) > 0)
                            {
                                foreach ($unit as $unitData) {
                                    //echo $unitData->id."/".$addnew->id."/".$group->id."/".$data->semester_id."<br>";
                                    $udpUnit=Unit::find($unitData->id);
                                    $udpUnit->semester_id=$addnew->id;
                                    $udpUnit->subject_id=$group->id;
                                    $udpUnit->save();

                                    $books=Book::where('unit_id',$unitData->id)->get();
                                    if(count($books) > 0)
                                    {
                                        foreach ($books as $book) {
                                            $updBook=Book::find($book->id);
                                            $updBook->subject_id=$group->id;
                                            $updBook->semester_id=$addnew->id;
                                            $updBook->save();
                                        }
                                    }

                                    $videos=Videos::where('unit_id',$unitData->id)->get();
                                    if(count($videos) > 0)
                                    {
                                        foreach ($videos as $video) {
                                            $updVideo=Videos::find($video->id);
                                            $updVideo->subject_id=$group->id;
                                            $updVideo->semester_id=$addnew->id;
                                            $updVideo->save();
                                        }
                                    }
                                }
                                
                            }
                    }
                }
            }
        }
    }
}
