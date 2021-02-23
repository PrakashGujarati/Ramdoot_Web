<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\unit;
use Auth;
use App\Models\Board;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $book_details = Book::where('status','Active')->get();
        return view('book.index',compact('book_details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $units = unit::where('status','Active')->get();
        $boards = Board::where('status','Active')->get();
        return view('book.add',compact('units','boards'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'board_id' => 'required',
            'standard_id' => 'required',
            'semester_id'  => 'required',
            'subject_id' => 'required',
            'unit_id' => 'required',
            'title' => 'required',
            'url' => 'required',
            'thumbnail'  => 'required',
            'pages' => 'required',
            'label' => 'required',
            'release_date' => 'required',    
        ]);

        $new_name='';
        if($request->has('thumbnail'))
        {
        
            $image = $request->file('thumbnail');

            $new_name = rand() . '.' . $image->getClientOriginalExtension();

            $valid_ext = array('png','jpeg','jpg');

            // Location
            $location = public_path('upload/book/thumbnail/').$new_name;

            $file_extension = pathinfo($location, PATHINFO_EXTENSION);
            $file_extension = strtolower($file_extension);

            if(in_array($file_extension,$valid_ext)){
                $this->compressImage($image->getPathName(),$location,60);
            }
        }

        $url_file='';
        if($request->has('url'))
        {
            $image = $request->file('url');

            $url_file = rand() . '.' . $image->getClientOriginalExtension();

            $valid_ext = array('png','jpeg','jpg');

            // Location
            $location = public_path('upload/book/url/').$url_file;

            $file_extension = pathinfo($location, PATHINFO_EXTENSION);
            $file_extension = strtolower($file_extension);

            if(in_array($file_extension,$valid_ext)){
                $this->compressImage($image->getPathName(),$location,60);
            }
        }

        $add = new Book;
        $add->user_id  = Auth::user()->id;
        $add->board_id = $request->board_id;
        $add->standard_id = $request->standard_id;
        $add->semester_id = $request->semester_id;
        $add->subject_id = $request->subject_id;
        $add->unit_id = $request->unit_id;
        $add->title = $request->title;
        $add->url = $url_file;
        $add->thumbnail = $new_name;
        $add->pages = isset($request->pages) ? $request->pages:'';
        $add->description = isset($request->description) ? $request->description:'';
        $add->label = $request->label;
        $add->release_date = $request->release_date;
        $add->save();

        return redirect()->route('book.index')->with('success', 'Book Added Successfully.');

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
    public function edit(Book $book,$id)
    {
        $units = unit::where('status','Active')->get();
        $boards = Board::where('status','Active')->get();
        $bookdata = Book::where('id',$id)->first();
        return view('book.edit',compact('bookdata','units','boards'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book,$id)
    {
        $this->validate($request, [
            'board_id' => 'required',
            'standard_id' => 'required',
            'semester_id'  => 'required',
            'subject_id' => 'required',
            'unit_id' => 'required',
            'title' => 'required',
            'pages' => 'required',
            'label' => 'required',
            'release_date' => 'required',
        ]);

        $new_name='';
        if($request->has('thumbnail'))
        {
        
            $image = $request->file('thumbnail');

            $new_name = rand() . '.' . $image->getClientOriginalExtension();

            $valid_ext = array('png','jpeg','jpg');

            // Location
            $location = public_path('upload/book/thumbnail/').$new_name;

            $file_extension = pathinfo($location, PATHINFO_EXTENSION);
            $file_extension = strtolower($file_extension);

            if(in_array($file_extension,$valid_ext)){
                $this->compressImage($image->getPathName(),$location,60);
            }
        }
        else{
            $new_name = $request->hidden_thumbnail;
        }

        $url_file='';
        if($request->has('url'))
        {

            $image = $request->file('url');

            $url_file = rand() . '.' . $image->getClientOriginalExtension();

            $valid_ext = array('png','jpeg','jpg');

            // Location
            $location = public_path('upload/book/url/').$url_file;

            $file_extension = pathinfo($location, PATHINFO_EXTENSION);
            $file_extension = strtolower($file_extension);

            if(in_array($file_extension,$valid_ext)){
                $this->compressImage($image->getPathName(),$location,60);
            }
        }
        else{
            $url_file = $request->hidden_url;
        }


        $update = Book::find($id);
        $update->unit_id = $request->unit_id;
        $update->board_id = $request->board_id;
        $update->standard_id = $request->standard_id;
        $update->semester_id = $request->semester_id;
        $update->subject_id = $request->subject_id;
        $update->title = $request->title;
        $update->url = $url_file;
        $update->thumbnail = $new_name;
        $update->pages = isset($request->pages) ? $request->pages:'';
        $update->description = isset($request->description) ? $request->description:'';
        $update->label = $request->label;
        $update->release_date = $request->release_date;
        $update->save();

        return redirect()->route('book.index')->with('success', 'Book Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function distroy(Book $book,$id)
    {
        $delete = Book::find($id);
        $delete->status = "Deleted";
        $delete->save();

        return redirect()->route('book.index')->with('success', 'Book Deleted Successfully.');
    }

    function compressImage($source, $destination, $quality) {
      $info = getimagesize($source);

      if ($info['mime'] == 'image/jpeg') 
        $image = imagecreatefromjpeg($source);

      elseif ($info['mime'] == 'image/gif') 
        $image = imagecreatefromgif($source);

      elseif ($info['mime'] == 'image/png') 
        $image = imagecreatefrompng($source);

      imagejpeg($image, $destination, $quality);

    }
}
