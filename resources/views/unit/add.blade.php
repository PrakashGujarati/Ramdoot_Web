@extends('layouts.app')
@section('title','Add Unit')
@section('css')
@endsection

@section('content')

<div class="nk-block nk-block-lg">
    <div class="row g-gs">
        <div class="col-lg-12">
            <div class="card h-100">
                <div class="card-inner">
                    <div class="card-head">
                        <h5 class="card-title">Add Unit</h5>
                    </div>
                    <form action="{{ route('unit.store') }}" method="POST" enctype='multipart/form-data'>
                    @csrf
                        
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
                            <label class="form-label">Subject</label>
                            <div class="form-control-wrap">
                                <select name="subject_id" class="form-control" id="subject_id">
                                    <option>--Select Subject--</option>
                                    @foreach($subjects as $subjects_data)
                                    <option value="{{ $subjects_data->id }}" @if(old('subject_id') == $subjects_data->id) selected="" @endif>{{ $subjects_data->subject_name }}</option>
                                    @endforeach
                                </select>
                                @error('subject_id')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Title</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
                                @error('title')
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
                            <a type="button" href="{{ route('unit.index') }}" class="btn btn-lg btn-danger text-light">Cancel</a>
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