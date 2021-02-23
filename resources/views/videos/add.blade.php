@extends('layouts.app')
@section('title','Add Video')
@section('css')
@endsection

@section('content')

<div class="nk-block nk-block-lg">
    <div class="row g-gs">
        <div class="col-lg-12">
            <div class="card h-100">
                <div class="card-inner">
                    <div class="card-head">
                        <h5 class="card-title">Add Video</h5>
                    </div>
                    <form action="{{ route('videos.store') }}" method="POST" enctype='multipart/form-data'>
                    @csrf


                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label class="form-label">Board</label>
                                <div class="form-control-wrap">
                                    <select name="board_id" class="form-control board_id" id="board_id">
                                        <option>--Select Board--</option>
                                        @foreach($boards as $boards_data)
                                        <option value="{{ $boards_data->id }}" @if(old('board_id') == $boards_data->id) selected="" @endif>{{ $boards_data->name." - ".$boards_data->medium}}</option>
                                        @endforeach
                                    </select>
                                    @error('board_id')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-lg-6">
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
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-6">
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
                            

                            <div class="form-group col-lg-6">
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
                        </div>


                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label class="form-label">Units</label>
                                <div class="form-control-wrap">
                                    <select name="unit_id" class="form-control unit_id" id="unit_id">
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
                            <div class="form-group col-lg-6">
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
                        </div>

                        <div class="row">

                            <div class="form-group col-lg-6">
                                <label class="form-label">Type</label>
                                <div class="form-control-wrap">
                                    <select class="form-control" id="type" name="type">
                                        <option selected="" value="URL">URL</option>
                                        <option value="File">File</option>
                                    </select>
                                    @error('type')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label class="form-label">Url</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control url" id="url" name="url" value="{{ old('url') }}">
                                    <input type="file" class="form-control url_file" id="url_file" name="url_file" value="">
                                    @error('url')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="form-group col-lg-4">
                                <label class="form-label">Duration</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="duration" name="duration" value="{{ old('duration') }}">
                                    @error('duration')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-lg-4">
                                <label class="form-label">Label</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="label" name="label" value="{{ old('label') }}">
                                    @error('label')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-lg-4">
                                <label class="form-label">Release Date</label>
                                <div class="form-control-wrap">
                                    <input type="date" class="form-control" id="release_date" name="release_date" value="{{ old('release_date') }}">
                                    @error('release_date')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
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
                            <label class="form-label">Description</label>
                            <div class="form-control-wrap">
                                <textarea class="form-control" id="description" name="description" value="{{ old('description') }}"></textarea>
                                @error('description')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-primary">Submit</button>
                            <a type="button" href="{{ route('videos.index') }}" class="btn btn-lg btn-danger text-light">Cancel</a>
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
        var type = $('#type').val();
        getType(type);
    });

    $(document).on('change','#type',function(){
        var type = $('#type').val();
        getType(type);
    });

    function getType(type){
        if(type == "File"){
            $('.url_file').css('display','block');
            $('.url').css('display','none');
        }else{
            $('.url_file').css('display','none');
            $('.url').css('display','block');
        }
    }


    $(document).on('change','.board_id',function(){
        var board_id = $('.board_id').val();
        getStandard(board_id);
    });

    function getStandard(board_id){
        $.ajax({
            type: "GET",
            url: "{{route('get.standard')}}",
            data: {
                "board_id":board_id,
            },
            success: function(result) {
                $('#standard_id').html('');
                $('#standard_id').html(result.html);
            } 
        });
    }


    $(document).on('change','.standard_id',function(){
        var standard_id = $('.standard_id').val();
        var board_id = $('.board_id').val();
        getSemester(standard_id,board_id);
    });

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


    $(document).on('change','.semester_id',function(){
        var standard_id = $('.standard_id').val();
        var semester_id = $('.semester_id').val();
        getSubject(standard_id,semester_id);
    });


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


    $(document).on('change','.subject_id',function(){
        var standard_id = $('.standard_id').val();
        var semester_id = $('.semester_id').val();
        var subject_id = $('.subject_id').val();
        getUnit(standard_id,semester_id,subject_id);
    });


    function getUnit(standard_id,semester_id,subject_id){
        $.ajax({
            type: "GET",
            url: "{{route('get.unit')}}",
            data: {
                "standard_id":standard_id,
                "semester_id":semester_id,
                "subject_id":subject_id,
            },
            success: function(result) {
                $('.unit_id').html('');
                $('.unit_id').html(result.html);
            } 
        });
    }



</script>

@endsection