@extends('layouts.app')
@section('title','Add Question')
@section('css')
@endsection

@section('content')

<div class="nk-block nk-block-lg">
    <div class="row g-gs">
        <div class="col-lg-12">
            <div class="card h-100">
                <div class="card-inner">
                    <div class="card-head">
                        <h5 class="card-title">Add Question</h5>
                    </div>
                    <form action="{{ route('question.store') }}" method="POST" enctype='multipart/form-data'>
                    @csrf
                        
                        
                        <div class="form-group">
                            <label class="form-label">Units</label>
                            <div class="form-control-wrap">
                                <select name="unit_id" class="form-control" id="unit_id">
                                    <option>--Select Unit--</option>
                                    @foreach($units as $units_data)
                                    <option value="{{ $units_data->id }}" @if(old('unit_id') == $units_data->id) selected="" @endif>{{ $units_data->title }}</option>
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
                                <input type="text" class="form-control" id="question" name="question" value="{{ old('question') }}">
                                @error('question')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Note</label>
                            <div class="form-control-wrap">
                                <textarea class="form-control" id="note" name="note" value="{{ old('note') }}">{{ old('note') }}</textarea>
                                @error('note')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        

                        <div class="row">
                            <div class="form-group col-lg-3">
                                <label class="form-label">Option-A</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="option_a" name="option_a" value="{{ old('option_a') }}">
                                    @error('option_a')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-lg-3">
                                <label class="form-label">Option-B</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="option_b" name="option_b" value="{{ old('option_b') }}">
                                    @error('option_b')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-lg-3">
                                <label class="form-label">Option-C</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="option_c" name="option_c" value="{{ old('option_c') }}">
                                    @error('option_c')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-lg-3">
                                <label class="form-label">Option-D</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="option_d" name="option_d" value="{{ old('option_d') }}">
                                    @error('option_d')
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
                                <input type="text" class="form-control" id="answer" name="answer" value="{{ old('answer') }}">
                                @error('answer')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Per Question Marks</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="per_question_marks" name="per_question_marks" value="{{ old('per_question_marks') }}">
                                @error('per_question_marks')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        

                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-primary">Submit</button>
                            <a type="button" href="{{ route('question.index') }}" class="btn btn-lg btn-danger text-light">Cancel</a>
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