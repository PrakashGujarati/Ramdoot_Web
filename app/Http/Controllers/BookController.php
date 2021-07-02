<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\Unit;
use Auth;
use App\Models\Board;
use App\Models\Medium;
use App\Models\Standard;
use App\Models\Subject;
use App\Models\Semester;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:Book-view', ['only' => ['index']]);
        $this->middleware('permission:Book-add', ['only' => ['create','store']]);
        $this->middleware('permission:Book-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:Book-delete', ['only' => ['distroy']]);
    }
    public function index()
    {
        $book_details = Book::where('status', '!=', 'Deleted')->groupBy('semester_id')->get();
        return view('book.index', compact('book_details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id=null)
    {
        if ($id != null) {
            $units = Unit::where('status', '!=', 'Deleted')->get();
            $boards = Board::where('status', '!=', 'Deleted')->get();
            $book_details = Book::where(['semester_id' => $id])->where('status', '!=', 'Deleted')->orderBy('order_no', 'asc')->get();
            $semesters_details = Semester::where('id', $id)->first();
            //$subjects_details = Subject::where('id',$id)->first();
            $isset = 1;
            return view('book.add', compact('units', 'boards', 'book_details', 'semesters_details', 'isset'));
        } else {
            $boards = Board::where('status', '!=', 'Deleted')->get();
            $units = [];
            $book_details = Book::where('status', '!=', 'Deleted')->orderBy('order_no', 'asc')->get();
            //$subjects_details=[];
            $semesters_details = Semester::where('id', $id)->first();
            $isset = 0;
            return view('book.add', compact('units', 'boards', 'book_details', 'semesters_details', 'isset'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'board_id' => 'required',
            'medium_id'  => 'required',
            'standard_id' => 'required',
            'semester_id'  => 'required',
            'subject_id' => 'required',
            'unit_id' => 'required',
            'title' => 'required',
            //'url' => 'required',
            'sub_title' => 'required'
        ]);

        /*
        $board_sub_title = board::where(['id' => $request->board_id])->first();
        $medium_sub_title = Medium::where(['id' => $request->medium_id])->first();
        $standard_sub_title = Standard::where(['id' => $request->standard_id])->first();
        $semester_sub_title = Semester::where(['id' => $request->semester_id])->first();
        $subject_sub_title = Subject::where(['id' => $request->subject_id])->first();
        $unit_sub_title = Unit::where(['id' => $request->unit_id])->first();

        get_subtitle($request->unit_id);*/

        if ($request->hidden_id != "0") {
            $new_name='';

            if ($request->thumbnail_file_type == 'Server') {
                if ($request->has('thumbnail')) {
                    $image = $request->file('thumbnail');
                    $url = get_subtitle($request->unit_id).'/book/thumbnail/';
                    $originalPath = imagePathCreate($url);
                    $name = time() . mt_rand(10000, 99999);
                    $new_name = $name . '.' . $image->getClientOriginalExtension();
                    $image->move($originalPath, $new_name);
                } else {
                    $new_name = $request->hidden_thumbnail;
                }
            } else {
                $new_name = $request->thumbnail;
            }

            $url_file='';
            if ($request->url_type == 'Server') {
                if ($request->file('url')) {
                    $image = $request->file('url');
                    //$url = 'upload/'.$request->board_id.'/'.$request->medium_id.'/'.$request->standard_id.'/'.$request->subject_id.'/'.$request->semester_id.'/'.$request->unit_id.'/book/url/';
                    $url = get_subtitle($request->unit_id).'/book/url/';
                    $originalPath = imagePathCreate($url);
                    $name = time() . mt_rand(10000, 99999);
                    $url_file = $name . '.' . $image->getClientOriginalExtension();
                    $image->move($originalPath, $url_file);
                } else {
                    $url_file = $request->hidden_url;
                }
            } else {
                $url_file = $request->url;
            }

            $add = Book::find($request->hidden_id);
            $add->user_id  = Auth::user()->id;
            $add->board_id = $request->board_id;
            $add->medium_id = $request->medium_id;
            $add->standard_id = $request->standard_id;
            $add->semester_id = $request->semester_id;
            $add->subject_id = $request->subject_id;
            $add->unit_id = $request->unit_id;
            $add->title = $request->title;
            $add->sub_title = $request->sub_title;
            $add->url_type = $request->url_type;
            $add->url = $url_file;
            $add->thumbnail = $new_name;
            $add->thumbnail_file_type = $request->thumbnail_file_type;
            $add->pages = isset($request->pages) ? $request->pages:'';
            $add->description = isset($request->description) ? $request->description:'';
            $add->label = $request->label;
            $add->release_date = $request->release_date;
            $add->edition = $request->edition;
            $add->save();

            $msg = "Book Updated Successfully.";
        } else {
            $new_name='';
            if ($request->thumbnail_file_type == 'Server') {
                if ($request->has('thumbnail')) {
                    $image = $request->file('thumbnail');
                    //$url = 'upload/'.$request->board_id.'/'.$request->medium_id.'/'.$request->standard_id.'/'.$request->subject_id.'/'.$request->semester_id.'/'.$request->unit_id.'/book/thumbnail/';
                    $url = get_subtitle($request->unit_id).'/book/thumbnail/';

                    $originalPath = imagePathCreate($url);
                    $name = time() . mt_rand(10000, 99999);
                    $new_name = $name . '.' . $image->getClientOriginalExtension();
                    $image->move($originalPath, $new_name);
                }
            } else {
                $new_name = $request->thumbnail;
            }

            $url_file='';
            if ($request->url_type == 'Server') {
                if ($request->file('url')) {
                    $image = $request->file('url');
                    //$url = 'upload/'.$request->board_id.'/'.$request->medium_id.'/'.$request->standard_id.'/'.$request->subject_id.'/'.$request->semester_id.'/'.$request->unit_id.'/book/url/';
                    $url = get_subtitle($request->unit_id).'/book/url/';
                    $originalPath = imagePathCreate($url);
                    $name = time() . mt_rand(10000, 99999);
                    $url_file = $name . '.' . $image->getClientOriginalExtension();
                    //$destinationPath = public_path('upload/book/url/');
                    $image->move($originalPath, $url_file);
                }
            } else {
                $url_file = $request->url;
            }

            $last_data=Book::select('*')->where('semester_id', $request->semester_id)->orderBy('order_no', 'desc')->first();
            if ($last_data) {
                $last_no=intval($last_data->order_no)+1;
            } else {
                $last_no=1;
            }

            $add = new Book;
            $add->user_id  = Auth::user()->id;
            $add->board_id = $request->board_id;
            $add->medium_id = $request->medium_id;
            $add->standard_id = $request->standard_id;
            $add->semester_id = $request->semester_id;
            $add->subject_id = $request->subject_id;
            $add->unit_id = $request->unit_id;
            $add->title = $request->title;
            $add->sub_title = $request->sub_title;
            $add->url_type = $request->url_type;
            $add->url = $url_file;
            $add->thumbnail = $new_name;
            $add->thumbnail_file_type = $request->thumbnail_file_type;
            $add->pages = isset($request->pages) ? $request->pages:'';
            $add->description = isset($request->description) ? $request->description:'';
            $add->label = $request->label;
            $add->release_date = $request->release_date;
            $add->edition = $request->edition;
            $add->order_no=$last_no;
            $add->save();

            $msg = "Book Added Successfully.";

            storeLog('book', $add->id, date('Y-m-d H:i:s'), 'create');
            storeReview('book', $add->id, date('Y-m-d H:i:s'));
        }


        $book_details = Book::where(['semester_id' => $request->semester_id])->where('status', '!=', 'Deleted')->orderBy('order_no', 'asc')->get();

        $html = view('book.dynamic_table', compact('book_details'))->render();
        $data = ['html' => $html,'message' => $msg];
        return response()->json($data);


        //return view('book.dynamic_table',compact('book_details'));
        //return redirect()->route('book.index')->with('success', 'Book Added Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //$units = Unit::where('status','Active')->get();
        //$boards = Board::where('status','Active')->get();
        $bookdata = Book::where('id', $request->id)->first();
        $board_sub_title = board::where(['id' => $bookdata->board_id])->first();
        $medium_sub_title = Medium::where(['id' => $bookdata->medium_id])->first();
        $standard_sub_title = Standard::where(['id' => $bookdata->standard_id])->first();
        $semester_sub_title = Semester::where(['id' => $bookdata->semester_id])->first();
        $subject_sub_title = Subject::where(['id' => $bookdata->subject_id])->first();
        $unit_sub_title = Unit::where(['id' => $bookdata->unit_id])->first();
        $sub_title = ['board_sub_title' => $board_sub_title,'medium_sub_title' => $medium_sub_title,
        'standard_sub_title' => $standard_sub_title,'semester_sub_title' => $semester_sub_title,
        'subject_sub_title' => $subject_sub_title,'unit_sub_title' => $unit_sub_title];
        $data = ['bookdetails' => $bookdata,'sub_title' => $sub_title];
        return $data;
        //return view('book.edit',compact('bookdata','units','boards'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book, $id)
    {
        $this->validate($request, [
            'board_id' => 'required',
            'medium_id'  => 'required',
            'standard_id' => 'required',
            'semester_id'  => 'required',
            'subject_id' => 'required',
            'unit_id' => 'required',
            'title' => 'required',
            'sub_title' => 'required'
        ]);

        $new_name='';
        if ($request->has('thumbnail')) {
            $image = $request->file('thumbnail');

            $new_name = rand() . '.' . $image->getClientOriginalExtension();

            $valid_ext = array('png','jpeg','jpg');

            // Location
            $location = public_path('upload/book/thumbnail/').$new_name;

            $file_extension = pathinfo($location, PATHINFO_EXTENSION);
            $file_extension = strtolower($file_extension);

            if (in_array($file_extension, $valid_ext)) {
                $this->compressImage($image->getPathName(), $location, 60);
            }
        } else {
            $new_name = $request->hidden_thumbnail;
        }

        $url_file='';
        if ($request->url_type == 'file') {
            if ($request->file('url')) {
                $image = $request->file('url');
                $url_file = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('upload/book/url/');
                $image->move($destinationPath, $url_file);
            } else {
                $url_file = $request->hidden_url;
            }
        } else {
            $url_file = $request->url;
        }


        $update = Book::find($id);
        $update->unit_id = $request->unit_id;
        $update->board_id = $request->board_id;
        $update->medium_id = $request->medium_id;
        $update->standard_id = $request->standard_id;
        $update->semester_id = $request->semester_id;
        $update->subject_id = $request->subject_id;
        $update->title = $request->title;
        $update->sub_title = $request->sub_title;
        $update->url_type = $request->url_type;
        $update->url = $url_file;
        $update->thumbnail = $new_name;
        $update->pages = isset($request->pages) ? $request->pages:'';
        $update->description = isset($request->description) ? $request->description:'';
        $update->label = $request->label;
        $update->release_date = $request->release_date;
        $update->edition = $request->edition;
        $update->save();

        return redirect()->route('book.index')->with('success', 'Book Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function distroy(Request $request)
    {
        if ($request->has('status')) {
            if ($request->status == "Active") {
                $delete = Book::find($request->id);
                $delete->status = "Inactive";
                $delete->save();
            } else {
                $delete = Book::find($request->id);
                $delete->status = "Active";
                $delete->save();
            }
        } else {
            $delete = Book::find($request->id);
            $delete->status = "Deleted";
            $delete->save();
            delete_order('books', $request->id, 1);
        }

        $book_details = Book::where(['semester_id' => $request->semester_id])->where('status', '!=', 'Deleted')->orderBy('order_no', 'asc')->get();
        return view('book.dynamic_table', compact('book_details'));
        //return redirect()->route('book.index')->with('success', 'Book Deleted Successfully.');
    }

    public function compressImage($source, $destination, $quality)
    {
        $info = getimagesize($source);

        if ($info['mime'] == 'image/jpeg') {
            $image = imagecreatefromjpeg($source);
        } elseif ($info['mime'] == 'image/gif') {
            $image = imagecreatefromgif($source);
        } elseif ($info['mime'] == 'image/png') {
            $image = imagecreatefrompng($source);
        }

        imagejpeg($image, $destination, $quality);
    }
    public function load_autocomplete(request $request)
    {
        $response=[];

        // $lead_detail=Medicine::where('instruction_english', 'like', '%' . $request['query'] . '%')->where('instruction_english','!=',' ')->where('instruction_english','!=',null)->get();

        $lead_detail=Book::where('sub_title', 'like', '%' . $request['query'] . '%')->get();


        if (count($lead_detail) > 0) {
            foreach ($lead_detail as $value) {
                $response[] = array("value"=>$value->sub_title,"data"=>$value->sub_title);
            }
        }
        return json_encode(array("suggestions" => $response));
    }
    public function load_autocomplete_title(request $request)
    {
        $response=[];

        // $lead_detail=Medicine::where('instruction_english', 'like', '%' . $request['query'] . '%')->where('instruction_english','!=',' ')->where('instruction_english','!=',null)->get();

        $lead_detail=Book::where('title', 'like', '%' . $request['query'] . '%')->get();


        if (count($lead_detail) > 0) {
            foreach ($lead_detail as $value) {
                $response[] = array("value"=>$value->title,"data"=>$value->title);
            }
        }
        return json_encode(array("suggestions" => $response));
    }
    public function above_order(request $request)
    {
        above_order('books', $request->order_no, 'semester_id', $request->semester_id);

        $book_details = Book::where(['semester_id' => $request->semester_id])->where('status', '!=', 'Deleted')->orderBy('order_no', 'asc')->get();
        $html = view('book.dynamic_table', compact('book_details'))->render();
        $data = ['html' => $html,'message' => $msg];
        return response()->json($data);
    }
    public function below_order(request $request)
    {
        //dd($request->subject_id);
        below_order('books', $request->order_no, 'semester_id', $request->semester_id);

        $book_details = Book::where(['semester_id' => $request->semester_id])->where('status', '!=', 'Deleted')->orderBy('order_no', 'asc')->get();
        $html = view('book.dynamic_table', compact('book_details'))->render();
        $data = ['html' => $html];
        return response()->json($data);
    }
}
