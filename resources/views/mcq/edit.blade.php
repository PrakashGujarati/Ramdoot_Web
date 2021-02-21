@extends('layouts.app')
@section('title','Edit MCQ')
@section('css')
@endsection

@section('content')

<div class="nk-block nk-block-lg">
    <div class="row g-gs">
        <div class="col-lg-12">
            <div class="card h-100">
                <div class="card-inner">
                    <div class="card-head">
                        <h5 class="card-title">Edit MCQ</h5>
                    </div>
                    <form action="{{ route('mcq.update',$mcqdata->id) }}" method="POST" enctype='multipart/form-data'>
                    @csrf
                        
                        
                        <div class="form-group">
                            <label class="form-label">Units</label>
                            <div class="form-control-wrap">
                                <select name="unit_id" class="form-control" id="unit_id">
                                    <option>--Select Unit--</option>
                                    @foreach($units as $units_data)
                                    <option value="{{ $units_data->id }}" @if($mcqdata->unit_id == $units_data->id) selected="" @endif>{{ $units_data->title }}</option>
                                    @endforeach
                                </select>
                                @error('unit_id')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        
                        <div class="form-group">
                            <label class="form-label">Question</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="question" name="question" value="{{ $mcqdata->question }}">
                                @error('question')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        

                        <div class="row">
                            <div class="form-group col-lg-3">
                                <label class="form-label">Option-1</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="opt1" name="opt1" value="{{ $mcqdata->opt1 }}">
                                    @error('opt1')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-lg-3">
                                <label class="form-label">Option-2</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="opt2" name="opt2" value="{{ $mcqdata->opt2 }}">
                                    @error('opt2')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-lg-3">
                                <label class="form-label">Option-3</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="opt3" name="opt3" value="{{ $mcqdata->opt3 }}">
                                    @error('opt3')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-lg-3">
                                <label class="form-label">Option-4</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="opt4" name="opt4" value="{{ $mcqdata->opt4 }}">
                                    @error('opt4')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Answer</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="answer" name="answer" value="{{ $mcqdata->answer }}">
                                @error('answer')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Level</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="level" name="level" value="{{ $mcqdata->level }}">
                                @error('level')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
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