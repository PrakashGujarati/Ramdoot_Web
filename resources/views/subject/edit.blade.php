@extends('layouts.app')
@section('title','Edit Subjects')
@section('css')
@endsection

@section('content')

<div class="nk-block nk-block-lg">
    <div class="row g-gs">
        <div class="col-lg-12">
            <div class="card h-100">
                <div class="card-inner">
                    <div class="card-head">
                        <h5 class="card-title">Edit Board</h5>
                    </div>
                    <form action="{{ route('subject.update',$subjectdata->id) }}" method="POST" enctype='multipart/form-data'>
                    @csrf
                        <div class="form-group">
                            <label class="form-label">Board</label>
                            <div class="form-control-wrap">
                                <select name="board_id" class="form-control" id="board_id">
                                    <option>--Select Board--</option>
                                    @foreach($boards as $boards_data)
                                    <option value="{{ $boards_data->id }}" @if($subjectdata->board_id == $boards_data->id) selected="" @endif>{{ $boards_data->name }}</option>
                                    @endforeach
                                </select>
                                @error('name')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Standard</label>
                            <div class="form-control-wrap">
                                <select name="standard_id" class="form-control" id="standard_id">
                                    <option>--Select Standard--</option>
                                    @foreach($standards as $standards_data)
                                    <option value="{{ $standards_data->id }}" @if($subjectdata->standard_id == $standards_data->id) selected="" @endif>{{ $standards_data->standard }}</option>
                                    @endforeach
                                </select>
                                @error('standard_id')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Semester</label>
                            <div class="form-control-wrap">
                                <select name="semester_id" class="form-control" id="semester_id">
                                    <option>--Select Semester--</option>
                                    @foreach($semesters as $semesters_data)
                                    <option value="{{ $semesters_data->id }}" @if($subjectdata->semester_id == $semesters_data->id) selected="" @endif>{{ $semesters_data->semester }}</option>
                                    @endforeach
                                </select>
                                @error('semester_id')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Subject Name</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="subject_name" name="subject_name" value="{{ $subjectdata->subject_name }}">
                                @error('subject_name')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Url</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="url" name="url" value="{{ $subjectdata->url }}">
                                @error('url')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Thumbnail</label>
                            <div class="form-control-wrap">
                                <input type="file" class="form-control" id="thumbnail" name="thumbnail" value="">
                                <input type="hidden" name="hidden_thumbnail" value="{{ $subjectdata->thumbnail }}">
                                <br/>
                                @if($subjectdata->thumbnail)
                                <img src="{{ asset('upload/subject/'.$subjectdata->thumbnail) }}" class="thumbnail" height="100" width="100">
                                @endif
                                @error('thumbnail')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-primary">Submit</button>
                            <a type="button" href="{{ route('subject.index') }}" class="btn btn-lg btn-danger text-light">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
            
    </div>
</div><!-- .nk-block -->

@endsection

@section('scripts')
@endsection