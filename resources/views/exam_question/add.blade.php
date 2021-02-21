@extends('layouts.app')
@section('title','Add Exam Question')
@section('css')
@endsection

@section('content')

<div class="nk-block nk-block-lg">
    <div class="row g-gs">
        <div class="col-lg-12">
            <div class="card h-100">
                <div class="card-inner">
                    <div class="card-head">
                        <h5 class="card-title">Add Exam Question</h5>
                    </div>
                    <form action="{{ route('exam_question.store') }}" method="POST" enctype='multipart/form-data'>
                    @csrf
                        
                        
                        <div class="form-group">
                            <label class="form-label">Exam</label>
                            <div class="form-control-wrap">
                                <select name="exam_id" class="form-control" id="exam_id">
                                    <option>--Select Exam--</option>
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

                        <div class="form-group">
                            <label class="form-label">Question</label>
                            <div class="form-control-wrap">
                                <select name="question_id" class="form-control" id="question_id">
                                    <option>--Select Question--</option>
                                    @foreach($questions as $questions_data)
                                    <option value="{{ $questions_data->id }}" @if(old('question_id') == $questions_data->id) selected="" @endif>{{ $questions_data->question }}</option>
                                    @endforeach
                                </select>
                                @error('question_id')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-primary">Submit</button>
                            <a type="button" href="{{ route('exam_question.index') }}" class="btn btn-lg btn-danger text-light">Cancel</a>
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