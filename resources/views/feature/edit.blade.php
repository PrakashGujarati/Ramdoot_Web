@extends('layouts.app')
@section('title','Edit Feature')
@section('css')
@endsection

@section('content')

<div class="nk-block nk-block-lg">
    <div class="row g-gs">
        <div class="col-lg-12">
            <div class="card h-100">
                <div class="card-inner">
                    <div class="card-head">
                        <h5 class="card-title">Edit Feature</h5>
                    </div>
                    <form action="{{ route('feature.update',$featuredata->id) }}" method="POST" enctype='multipart/form-data'>
                    @csrf

                        
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label class="form-label">Title</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="title" name="title" value="{{ $featuredata->title }}">
                                    @error('title')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label class="form-label">Order</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="order" name="order" value="{{ $featuredata->flag }}">
                                    @error('order')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Image</label>
                            <div class="form-control-wrap">
                                <input type="file" class="form-control" id="image" name="image" value="">
                                <input type="hidden" name="hidden_image" value="{{ $featuredata->image }}">
                                <br/>
                                @if($featuredata->image)
                                <img src="{{ asset('upload/feature/'.$featuredata->image) }}" class="thumbnail" height="100" width="100">
                                @endif
                                @error('image')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-primary">Submit</button>
                            <a type="button" href="{{ route('feature.index') }}" class="btn btn-lg btn-danger text-light">Cancel</a>
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
        var medium_id = "{{ $featuredata->medium_id }}";
        var standard_id = "{{ $featuredata->standard_id }}";
        var semester_id = "{{ $featuredata->semester_id }}";
        var subject_id = "{{ $featuredata->subject_id }}";
        var unit_id = "{{ $featuredata->unit_id }}";

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