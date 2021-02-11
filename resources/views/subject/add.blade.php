@extends('layouts.app')
@section('title','Add Subject')
@section('css')
@endsection

@section('content')

<div class="nk-block nk-block-lg">
    <div class="row g-gs">
        <div class="col-lg-12">
            <div class="card h-100">
                <div class="card-inner">
                    <div class="card-head">
                        <h5 class="card-title">Add Subject</h5>
                    </div>
                    <form action="{{ route('subject.store') }}" method="POST" enctype='multipart/form-data'>
                    @csrf
                        <div class="form-group">
                            <label class="form-label">Board</label>
                            <div class="form-control-wrap">
                                <select name="board_id" class="form-control" id="board_id">
                                    <option>--Select Board--</option>
                                    @foreach($boards as $boards_data)
                                    <option value="{{ $boards_data->id }}" @if(old('board_id') == $boards_data->id) selected="" @endif>{{ $boards_data->name }}</option>
                                    @endforeach
                                </select>
                                @error('board_id')
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
                                    <option value="{{ $standards_data->id }}" @if(old('standard_id') == $standards_data->id) selected="" @endif>{{ $standards_data->standard }}</option>
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
                                    <option value="{{ $semesters_data->id }}" @if(old('semester_id') == $semesters_data->id) selected="" @endif>{{ $semesters_data->semester }}</option>
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
                                <input type="text" class="form-control" id="subject_name" name="subject_name" value="{{ old('subject_name') }}">
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
                                <input type="text" class="form-control" id="url" name="url" value="{{ old('url') }}">
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