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
                                <select name="board_id" class="form-control board_id" id="board_id">
                                    <option>--Select Board--</option>
                                    @foreach($boards as $boards_data)
                                    <option value="{{ $boards_data->id }}" @if($subjectdata->board_id == $boards_data->id) selected="" @endif>{{ $boards_data->name." - ".$boards_data->medium }}</option>
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
                                <select name="standard_id" class="form-control standard_id" id="standard_id">
                                    <option>--Select Standard--</option>
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
                                <input type="file" class="form-control" id="url" name="url" value="">
                                <input type="hidden" name="hidden_url" value="{{ $subjectdata->url }}">
                                <br/>
                                @if($subjectdata->url)
                                    <img src="{{ asset('upload/subject/url/'.$subjectdata->url) }}" class="thumbnail" height="100" width="100">
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
                                <input type="hidden" name="hidden_thumbnail" value="{{ $subjectdata->thumbnail }}">
                                <br/>
                                @if($subjectdata->thumbnail)
                                <img src="{{ asset('upload/subject/thumbnail/'.$subjectdata->thumbnail) }}" class="thumbnail" height="100" width="100">
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

<script type="text/javascript">

$( document ).ready(function() {
    var board_id = $('.board_id').val();
    var standard_id = "{{ $subjectdata->standard_id }}";
    var semester_id = "{{ $subjectdata->semester_id }}";
    getStandardEdit(board_id,standard_id);
    getSemesterEdit(board_id,standard_id,semester_id);
});

$(document).on('change','.board_id',function(){
    var board_id = $('.board_id').val();
    getStandard(board_id);
});

function getStandardEdit(board_id,standard_id){
    
    $.ajax({
        type: "GET",
        url: "{{route('get.standard')}}",
        data: {
            "board_id":board_id,
            "standard_id":standard_id,
        },
        success: function(result) {
            $('.standard_id').html('');
            $('.standard_id').html(result.html);
        } 
    });
}

function getStandard(board_id){
    $.ajax({
        type: "GET",
        url: "{{route('get.standard')}}",
        data: {
            "board_id":board_id,
        },
        success: function(result) {
            $('.standard_id').html('');
            $('.standard_id').html(result.html);
        } 
    });
}



$(document).on('change','.standard_id',function(){
    var standard_id = $('.standard_id').val();
    var board_id = $('.board_id').val();
    getSemester(standard_id,board_id);
});

function getSemesterEdit(board_id,standard_id,semester_id){
    
    $.ajax({
        type: "GET",
        url: "{{route('get.semester')}}",
        data: {
            "board_id":board_id,
            "standard_id":standard_id,
            "semester_id":semester_id,
        },
        success: function(result) {
            $('.semester_id').html('');
            $('.semester_id').html(result.html);
        } 
    });
}

function getSemester(standard_id,board_id){
    $.ajax({
        type: "GET",
        url: "{{route('get.semester')}}",
        data: {
            "board_id":board_id,
            "standard_id":standard_id,
        },
        success: function(result) {
            $('.semester_id').html('');
            $('.semester_id').html(result.html);
        } 
    });
}    

</script>

@endsection