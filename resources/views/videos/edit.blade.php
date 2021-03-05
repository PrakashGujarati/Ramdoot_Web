@extends('layouts.app')
@section('title','Edit Video')
@section('css')
@endsection

@section('content')

<div class="nk-block nk-block-lg">
    <div class="row g-gs">
        <div class="col-lg-12">
            <div class="card h-100">
                <div class="card-inner">
                    <div class="card-head">
                        <h5 class="card-title">Edit Video</h5>
                    </div>
                    <form action="{{ route('videos.update',$videodata->id) }}" method="POST" enctype='multipart/form-data'>
                    @csrf
                        
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label class="form-label">Board</label>
                                <div class="form-control-wrap">
                                    <select name="board_id" class="form-control board_id" id="board_id">
                                        <option>--Select Board--</option>
                                        @foreach($boards as $boards_data)
                                        <option value="{{ $boards_data->id }}" @if($videodata->board_id == $boards_data->id) selected="" @endif>{{ $boards_data->name." - ".$boards_data->medium }}</option>
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
                                    <input type="text" class="form-control" id="title" name="title" value="{{ $videodata->title }}">
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
                                        <option  value="URL" @if($videodata->type == "URL") selected="" @endif>URL</option>
                                        <option value="File" @if($videodata->type == "File") selected="" @endif>File</option>
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
                                    <input type="text" class="form-control url" id="url" name="url" value="{{ $videodata->url }}">
                                    <input type="file" class="form-control url_file" id="url_file" name="url_file" value="">
                                    <input type="hidden" name="hidden_url" value="{{ $videodata->url }}">
                                    <br/>
                                    @if($videodata->url)
                                        @php $ext = pathinfo($videodata->url, PATHINFO_EXTENSION); @endphp
                                        @if($ext == "png" || $ext == "jpg" || $ext == "jpeg")
                                        <img src="{{ asset('upload/videos/url/'.$videodata->url) }}" class="thumbnail" height="100" width="100">
                                        @else
                                        <p>{{ $videodata->url }}</p>
                                        @endif
                                    @endif
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
                                    <input type="text" class="form-control" id="duration" name="duration" value="{{ $videodata->duration }}">
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
                                    <input type="text" class="form-control" id="label" name="label" value="{{ $videodata->label }}">
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
                                    <input type="date" class="form-control" id="release_date" name="release_date" value="{{ $videodata->release_date }}">
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
                                <input type="hidden" name="hidden_thumbnail" value="{{ $videodata->thumbnail }}">
                                <br/>
                                @if($videodata->thumbnail)
                                <img src="{{ asset('upload/videos/thumbnail/'.$videodata->thumbnail) }}" class="thumbnail" height="100" width="100">
                                @endif
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
                                <textarea class="form-control" id="description" name="description" value="{{ $videodata->description }}">{{ $videodata->description }}</textarea>
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
        if(type == "File"){
            $('.url_file').css('display','block');
            $('.url_file_image').css('display','none');  
            var blank="";
            $('.url').val(blank);
            $('.url').css('display','none');
        }else{
            $('.url_file').css('display','none');
            $('.url_file_image').css('display','none');
            var blank="";
            $('.url').val(blank);
            $('.url').css('display','block');
        }
    });

    function getType(type){
        if(type == "File"){
            $('.url_file').css('display','block'); 
            var blank="";
            $('.url').val(blank);
            $('.url').css('display','none');
        }else{
            $('.url_file').css('display','none');
            $('.url_file_image').css('display','none');
            var geturl="{{ $videodata->url }}";
            $('.url').val(geturl);
            $('.url').css('display','block');
        }
    }


    $( document ).ready(function() {
        var board_id = $('.board_id').val();
        var standard_id = "{{ $videodata->standard_id }}";
        var semester_id = "{{ $videodata->semester_id }}";
        var subject_id = "{{ $videodata->subject_id }}";
        var unit_id = "{{ $videodata->unit_id }}";

        getStandardEdit(board_id,standard_id);
        getSemesterEdit(board_id,standard_id,semester_id);
        getSubjectEdit(standard_id,semester_id,subject_id);
        getUnitEdit(standard_id,semester_id,subject_id,unit_id);

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


    $(document).on('change','.subject_id',function(){
        var standard_id = $('.standard_id').val();
        var semester_id = $('.semester_id').val();
        var subject_id = $('.subject_id').val();
        getUnit(standard_id,semester_id,subject_id);
    });

    function getUnitEdit(standard_id,semester_id,subject_id,unit_id){
        
        $.ajax({
            type: "GET",
            url: "{{route('get.unit')}}",
            data: {
                "standard_id":standard_id,
                "semester_id":semester_id,
                "subject_id":subject_id,
                "unit_id":unit_id,
            },
            success: function(result) {
                $('.unit_id').html('');
                $('.unit_id').html(result.html);
            } 
        });
    }


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