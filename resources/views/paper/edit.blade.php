@extends('layouts.app')
@section('title','Edit Paper')
@section('css')
@endsection

@section('content')

<div class="nk-block nk-block-lg">
    <div class="row g-gs">
        <div class="col-lg-12">
            <div class="card h-100">
                <div class="card-inner">
                    <div class="card-head">
                        <h5 class="card-title">Edit Paper</h5>
                    </div>
                    <form action="{{ route('paper.update',$paperdata->id) }}" method="POST" enctype='multipart/form-data'>
                    @csrf
                    
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label class="form-label">Board</label>
                                <div class="form-control-wrap">
                                    <select name="board_id" class="form-control board_id" id="board_id">
                                        <option>--Select Board--</option>
                                        @foreach($boards as $boards_data)
                                        <option value="{{ $boards_data->id }}" @if($paperdata->board_id == $boards_data->id) selected="" @endif>{{ $boards_data->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('board_id')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-lg-4">
                                <label class="form-label">Medium</label>
                                <div class="form-control-wrap">
                                    <select name="medium_id" class="form-control medium_id" id="medium_id">
                                        <option>--Select Medium--</option>
                                    </select>
                                    @error('medium_id')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-lg-4">
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
                            <div class="form-group col-lg-4">
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
                            

                            <div class="form-group col-lg-4">
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

                            <div class="form-group col-lg-4">
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

                        </div>

                        <div class="row">
                            
                            <div class="form-group col-lg-4">
                                <label class="form-label">Title</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="title" name="title" value="{{ $paperdata->title }}">
                                    @error('title')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-lg-4">
                                <label class="form-label">Url</label>
                                <div class="form-control-wrap">
                                    <input type="file" class="form-control" id="url" name="url" value="">
                                    <input type="hidden" name="hidden_url" value="{{ $paperdata->url }}">
                                    <br/>
                                    @if($paperdata->url)
                                        @php $ext = pathinfo($paperdata->url, PATHINFO_EXTENSION); @endphp
                                        @if($ext == "png" || $ext == "jpg" || $ext == "jpeg")
                                        <img src="{{ asset('upload/paper/url/'.$paperdata->url) }}" class="thumbnail" height="100" width="100">
                                        @else
                                        <p>{{ $paperdata->url }}</p>
                                        @endif
                                    @endif
                                    @error('url')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>                            


                            <div class="form-group col-lg-4">
                                <label class="form-label">Label</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="label" name="label" value="{{ $paperdata->label }}">
                                    @error('label')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>    

                        </div>

                        <div class="form-group">
                            <label class="form-label">Description</label>
                            <div class="form-control-wrap">
                                <textarea class="form-control" id="description" name="description" value="{{ $paperdata->description }}">{{ $paperdata->description }}</textarea>
                                @error('description')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>               

                        
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-primary">Submit</button>
                            <a type="button" href="{{ route('paper.index') }}" class="btn btn-lg btn-danger text-light">Cancel</a>
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
        var medium_id = "{{ $paperdata->medium_id }}";
        var standard_id = "{{ $paperdata->standard_id }}";
        var semester_id = "{{ $paperdata->semester_id }}";
        var subject_id = "{{ $paperdata->subject_id }}";
        var unit_id = "{{ $paperdata->unit_id }}";

        getMediumEdit(board_id,medium_id);
        getStandardEdit(board_id,medium_id,standard_id);
        getSemesterEdit(board_id,medium_id,standard_id,semester_id);
        getSubjectEdit(board_id,medium_id,standard_id,semester_id,subject_id);
        getUnitEdit(board_id,medium_id,standard_id,semester_id,subject_id,unit_id);

    });

    $(document).on('change','.board_id',function(){
        var board_id = $('.board_id').val();
        getMedium(board_id);
    });

    function getMediumEdit(board_id,medium_id){
    
        $.ajax({
            type: "GET",
            url: "{{route('get.medium')}}",
            data: {
                "board_id":board_id,
                "medium_id":medium_id,
            },
            success: function(result) {
                $('.medium_id').html('');
                $('.medium_id').html(result.html);
            } 
        });
    }

    function getMedium(board_id){
        $.ajax({
            type: "GET",
            url: "{{route('get.medium')}}",
            data: {
                "board_id":board_id,
            },
            success: function(result) {
                $('.medium_id').html('');
                $('.medium_id').html(result.html);
            } 
        });
    }

    $(document).on('change','.medium_id',function(){
        var board_id = $('.board_id').val();
        var medium_id = $('.medium_id').val();
        getStandard(board_id,medium_id);
    });

    function getStandardEdit(board_id,medium_id,standard_id){
        
        $.ajax({
            type: "GET",
            url: "{{route('get.standard')}}",
            data: {
                "board_id":board_id,
                "medium_id":medium_id,
                "standard_id":standard_id,
            },
            success: function(result) {
                $('.standard_id').html('');
                $('.standard_id').html(result.html);
            } 
        });
    }

    function getStandard(board_id,medium_id){
        $.ajax({
            type: "GET",
            url: "{{route('get.standard')}}",
            data: {
                "board_id":board_id,
                "medium_id":medium_id,
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
        var medium_id = $('.medium_id').val();
        getSemester(standard_id,medium_id,board_id);
    });

    function getSemesterEdit(board_id,medium_id,standard_id,semester_id){
        
        $.ajax({
            type: "GET",
            url: "{{route('get.semester')}}",
            data: {
                "board_id":board_id,
                "medium_id":medium_id,
                "standard_id":standard_id,
                "semester_id":semester_id,
            },
            success: function(result) {
                $('.semester_id').html('');
                $('.semester_id').html(result.html);
            } 
        });
    }

    function getSemester(standard_id,medium_id,board_id){
        $.ajax({
            type: "GET",
            url: "{{route('get.semester')}}",
            data: {
                "board_id":board_id,
                "medium_id":medium_id,
                "standard_id":standard_id,
            },
            success: function(result) {
                $('.semester_id').html('');
                $('.semester_id').html(result.html);
            } 
        });
    }

    $(document).on('change','.semester_id',function(){
        var board_id = $('.board_id').val();
        var medium_id = $('.medium_id').val();
        var standard_id = $('.standard_id').val();
        var semester_id = $('.semester_id').val();
        getSubject(board_id,medium_id,standard_id,semester_id);
    });

    function getSubjectEdit(board_id,medium_id,standard_id,semester_id,subject_id){
        $.ajax({
            type: "GET",
            url: "{{route('get.subject')}}",
            data: {
                "board_id":board_id,
                "medium_id":medium_id,
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


    function getSubject(board_id,medium_id,standard_id,semester_id){
        $.ajax({
            type: "GET",
            url: "{{route('get.subject')}}",
            data: {
                "board_id":board_id,
                "medium_id":medium_id,
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
        var board_id = $('.board_id').val();
        var medium_id = $('.medium_id').val();
        var standard_id = $('.standard_id').val();
        var semester_id = $('.semester_id').val();
        var subject_id = $('.subject_id').val();
        getUnit(board_id,medium_id,standard_id,semester_id,subject_id);
    });

    function getUnitEdit(board_id,medium_id,standard_id,semester_id,subject_id,unit_id){
        
        $.ajax({
            type: "GET",
            url: "{{route('get.unit')}}",
            data: {
                "board_id":board_id,
                "medium_id":medium_id,
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


function getUnit(board_id,medium_id,standard_id,semester_id,subject_id){
    $.ajax({
        type: "GET",
        url: "{{route('get.unit')}}",
        data: {
            "board_id":board_id,
            "medium_id":medium_id,
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