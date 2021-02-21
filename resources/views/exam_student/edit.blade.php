@extends('layouts.app')
@section('title','Edit Exam')
@section('css')
@endsection

@section('content')

<div class="nk-block nk-block-lg">
    <div class="row g-gs">
        <div class="col-lg-12">
            <div class="card h-100">
                <div class="card-inner">
                    <div class="card-head">
                        <h5 class="card-title">Edit Exam</h5>
                    </div>
                    <form action="{{ route('exam.update',$examdata->id) }}" method="POST" enctype='multipart/form-data'>
                    @csrf
                        
                        <div class="row">
                            <div class="form-group  col-lg-6">
                                <label class="form-label">Units</label>
                                <div class="form-control-wrap">
                                    <select name="unit_id" class="form-control" id="unit_id">
                                        <option>--Select Unit--</option>
                                        @foreach($units as $units_data)
                                        <option value="{{ $units_data->id }}" @if($examdata->unit_id == $units_data->id) selected="" @endif>{{ $units_data->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('unit_id')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label class="form-label">Name</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $examdata->name }}">
                                    @error('name')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="form-group">
                            <label class="form-label">Note</label>
                            <div class="form-control-wrap">
                                <textarea class="form-control" id="note" name="note" value="{{ $examdata->note }}">{{ $examdata->note }}</textarea>
                                @error('note')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="row">
                            <div class="form-group col-lg-3">
                                <label class="form-label">Time Duration</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="time_duration" name="time_duration" value="{{ $examdata->time_duration }}">
                                    @error('time_duration')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-lg-3">
                                <label class="form-label">Exam Date</label>
                                <div class="form-control-wrap">
                                    <input type="date" class="form-control" id="exam_date" name="exam_date" value="{{ $examdata->exam_date }}">
                                    @error('exam_date')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-lg-3">
                                <label class="form-label">Total Marks</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="total_marks" name="total_marks" value="{{ $examdata->total_marks }}">
                                    @error('total_marks')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-lg-3">
                                <label class="form-label">Total Question</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="total_question" name="total_question" value="{{ $examdata->total_question }}">
                                    @error('total_question')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="form-group col-lg-3">
                                <label class="form-label">Start Time</label>
                                <div class="form-control-wrap">
                                    <input type="time" class="form-control" id="start_time" name="start_time" value="{{ $examdata->start_time }}">
                                    @error('start_time')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-lg-3">
                                <label class="form-label">End Time</label>
                                <div class="form-control-wrap">
                                    <input type="time" class="form-control" id="end_time" name="end_time" value="{{ $examdata->end_time }}">
                                    @error('end_time')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label class="form-label">Negative Marks</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="negative_marks" name="negative_marks" value="{{ $examdata->negative_marks }}">
                                    @error('negative_marks')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                        </div>


                        <div class="row pt-1">
                            <div class="form-group col-lg-3">
                                <div class="form-control-wrap">
                                    <div class="g">
                                        <div class="custom-control custom-control-sm custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="exam_status" @if($examdata->exam_status == "1") checked @endif value="1" id="exam_status">
                                            <label class="custom-control-label" for="exam_status">Exam Status</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-lg-3">
                                <div class="form-control-wrap">
                                    <div class="g">
                                        <div class="custom-control custom-control-sm custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" value="1" name="instant_result" id="instant_result" @if($examdata->instant_result == "1") checked @endif>
                                            <label class="custom-control-label" for="instant_result">Instant Result</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-lg-3">
                                <div class="form-control-wrap">
                                    <div class="g">
                                        <div class="custom-control custom-control-sm custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" value="1" name="is_minus_system" id="is_minus_system" @if($examdata->is_minus_system == "1") checked @endif>
                                            <label class="custom-control-label" for="is_minus_system">Minus System</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>

                        

                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-primary">Submit</button>
                            <a type="button" href="{{ route('mcq.index') }}" class="btn btn-lg btn-danger text-light">Cancel</a>
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