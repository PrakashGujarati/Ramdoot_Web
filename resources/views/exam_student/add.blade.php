@extends('layouts.app')
@section('title','Add Student')
@section('css')
@endsection

@section('content')

<div class="nk-block nk-block-lg">
    <div class="row g-gs">
        <div class="col-lg-12">
            <div class="card h-100">
                <div class="card-inner">
                    <div class="card-head">
                        <h5 class="card-title">Add Student</h5>
                    </div>
                    <form action="{{ route('exam_student.store') }}" method="POST" enctype='multipart/form-data'>
                    @csrf
                        
                        <div class="row">    
                            <div class="form-group col-lg-6">
                                <label class="form-label">Exam</label>
                                <div class="form-control-wrap">
                                    <select name="exam_id" class="form-control" id="exam_id">
                                        <option value="" selected="" disabled="">--Select Exam--</option>
                                        @foreach($exams as $exams_data)
                                        <option value="{{ $exams_data->id }}" @if(old('exam_id') == $exams_data->id) selected="" @endif>{{ $exams_data->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('exam_id')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group col-lg-6">
                                <label class="form-label">Student</label>
                                <div class="form-control-wrap">
                                    <select name="student_id" class="form-control" id="student_id">
                                        <option value="" selected="" disabled="">--Select Student--</option>
                                        @foreach($users as $users_data)
                                        <option value="{{ $users_data->id }}" @if(old('student_id') == $users_data->id) selected="" @endif>{{ $users_data->name }}</option>
                                        @endforeach
                                    </select>
                                    <!-- <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"> -->
                                    @error('student_id')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label class="form-label">Start Time</label>
                                <div class="form-control-wrap">
                                    <input type="time" class="form-control" id="start_time" name="start_time" value="{{ old('start_time') }}">
                                    @error('start_time')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="form-label">End Time</label>
                                <div class="form-control-wrap">
                                    <input type="time" class="form-control" id="end_time" name="end_time" value="{{ old('end_time') }}">
                                    @error('end_time')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row pt-1 pb-2">
                            <div class="form-group col-lg-3">
                                <div class="form-control-wrap">
                                    <div class="g">
                                        <div class="custom-control custom-control-sm custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="is_attend" value="1" id="is_attend">
                                            <label class="custom-control-label" for="is_attend">Attend</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-3">
                                <label class="form-label">Remaining Time</label>
                                <div class="form-control-wrap">
                                    <input type="time" class="form-control" id="remaining_time" name="remaining_time" value="{{ old('remaining_time') }}">
                                    @error('remaining_time')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-lg-3">
                                <label class="form-label">Result</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="result" name="result" value="{{ old('result') }}">
                                    @error('result')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label class="form-label">Node Number</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="node_number" name="node_number" value="{{ old('node_number') }}">
                                    @error('node_number')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        

                        

                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-primary">Submit</button>
                            <a type="button" href="{{ route('exam_student.index') }}" class="btn btn-lg btn-danger text-light">Cancel</a>
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