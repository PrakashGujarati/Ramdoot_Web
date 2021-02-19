@extends('layouts.app')
@section('title','Edit Unit')
@section('css')
@endsection

@section('content')

<div class="nk-block nk-block-lg">
    <div class="row g-gs">
        <div class="col-lg-12">
            <div class="card h-100">
                <div class="card-inner">
                    <div class="card-head">
                        <h5 class="card-title">Edit Unit</h5>
                    </div>
                    <form action="{{ route('unit.update',$unitdata->id) }}" method="POST" enctype='multipart/form-data'>
                    @csrf
                        <div class="form-group">
                            <label class="form-label">Standard</label>
                            <div class="form-control-wrap">
                                <select name="standard_id" class="form-control standard_id" id="standard_id">
                                    <option>--Select Standard--</option>
                                    @foreach($standards as $standards_data)
                                    <option value="{{ $standards_data->id }}" @if($unitdata->standard_id == $standards_data->id) selected="" @endif>{{ $standards_data->standard }}</option>
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
                                <select name="semester_id" class="form-control semester_id" id="semester_id">
                                    <option>--Select Semester--</option>
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
                                <select name="subject_id" class="form-control subject_id" id="subject_id">
                                    <option>--Select Subject--</option>
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
                                <input type="text" class="form-control" id="title" name="title" value="{{ $unitdata->title }}">
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
                                <input type="file" class="form-control" id="url" name="url" value="">
                                <input type="hidden" name="hidden_url" value="{{ $unitdata->url }}">
                                <br/>
                                @if($unitdata->url)
                                    <img src="{{ asset('upload/unit/url/'.$unitdata->url) }}" class="thumbnail" height="100" width="100">
                                @endif
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
                                <input type="hidden" name="hidden_thumbnail" value="{{ $unitdata->thumbnail }}">
                                <br/>
                                @if($unitdata->thumbnail)
                                <img src="{{ asset('upload/unit/thumbnail/'.$unitdata->thumbnail) }}" class="thumbnail" height="100" width="100">
                                @endif
                                @error('thumbnail')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Pages</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="pages" name="pages" value="{{ $unitdata->pages }}">
                                @error('pages')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Description</label>
                            <div class="form-control-wrap">
                                <textarea class="form-control" id="description" name="description" value="{{ $unitdata->description }}">{{ $unitdata->description }}</textarea>
                                @error('description')
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

<script type="text/javascript">


$( document ).ready(function() {
    var standard_id = "{{ $unitdata->standard_id }}";
    var semester_id = "{{ $unitdata->semester_id }}";
    var subject_id = "{{ $unitdata->subject_id }}";
    getSemesterEdit(standard_id,semester_id);
    getSubjectEdit(standard_id,semester_id,subject_id);
});

$(document).on('change','.standard_id',function(){
    var standard_id = $('.standard_id').val();
    getSemester(standard_id);
});

function getSemesterEdit(standard_id,semester_id){
    $.ajax({
        type: "GET",
        url: "{{route('get.semester.unit')}}",
        data: {
            "standard_id":standard_id,
            "semester_id":semester_id,
        },
        success: function(result) {
            $('.semester_id').html('');
            $('.semester_id').html(result.html);
        } 
    });
}

function getSemester(standard_id){
    $.ajax({
        type: "GET",
        url: "{{route('get.semester.unit')}}",
        data: {
            "standard_id":standard_id,
        },
        success: function(result) {
            $('.semester_id').html('');
            $('.semester_id').html(result.html);
        } 
    });
}

$(document).on('change','.semester_id',function(){
    var standard_id = $('.standard_id').val();
    var semester_id = $('.semester_id').val();
    getSubject(standard_id,semester_id);
});

function getSubjectEdit(standard_id,semester_id,subject_id){
    $.ajax({
        type: "GET",
        url: "{{route('get.subject')}}",
        data: {
            "standard_id":standard_id,
            "semester_id":semester_id,
            "subject_id":subject_id,
        },
        success: function(result) {
            $('.subject_id').html('');
            $('.subject_id').html(result.html);
        } 
    });
}


function getSubject(standard_id,semester_id){
    $.ajax({
        type: "GET",
        url: "{{route('get.subject')}}",
        data: {
            "standard_id":standard_id,
            "semester_id":semester_id,
        },
        success: function(result) {
            $('.subject_id').html('');
            $('.subject_id').html(result.html);
        } 
    });
}

</script>

@endsection