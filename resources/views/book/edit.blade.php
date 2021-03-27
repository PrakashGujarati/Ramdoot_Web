@extends('layouts.app')
@section('title','Edit Book')
@section('css')
@endsection

@section('content')

<div class="nk-block nk-block-lg">
    <div class="row g-gs">
        <div class="col-lg-12">
            <div class="card h-100">
                <div class="card-inner">
                    <div class="card-head">
                        <h5 class="card-title">Edit Book</h5>
                    </div>
                    <form action="{{ route('book.update',$bookdata->id) }}" method="POST" enctype='multipart/form-data'>
                    @csrf

                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label class="form-label">Board</label>
                                <div class="form-control-wrap">
                                    <select name="board_id" class="form-control board_id" id="board_id">
                                        <option>--Select Board--</option>
                                        @foreach($boards as $boards_data)
                                        <option value="{{ $boards_data->id }}" @if($bookdata->board_id == $boards_data->id) selected="" @endif>{{ $boards_data->name }}</option>
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
                                    <input type="text" class="form-control" id="title" name="title" value="{{ $bookdata->title }}">
                                    @error('title')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-lg-4">
                                <label class="form-label">Sub Title</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="sub_title" name="sub_title" value="{{ $bookdata->sub_title }}">
                                    @error('sub_title')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-lg-4">
                                <label class="form-label">Pages</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="pages" name="pages" value="{{ $bookdata->pages }}">
                                    @error('pages')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                        <div class="form-group col-lg-4">
                            <div class="row">
                                <input type="hidden" name="url_type" class="url_type" id="url_type" value="file">
                                <div class="col-lg-6"><label class="form-label">Url</label></div>
                                <div class="col-lg-6 text-right"><div class="g">
                                    <div class="custom-control custom-control-sm custom-checkbox">
                                        <input type="checkbox" class="custom-control-input urlchk" name="instant_result" value="{{ $bookdata->url_type }}" id="instant_result">
                                        <label class="custom-control-label" for="instant_result"></label>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="form-control-wrap">
                                <input type="file" class="form-control" id="url" name="url" value="">
                                <input type="hidden" name="hidden_url" value="{{ $bookdata->url }}">
                                <br/>
                                @if($bookdata->url_type == "file")
                                @if($bookdata->url)
                                    @php $ext = pathinfo($bookdata->url, PATHINFO_EXTENSION); @endphp
                                    @if($ext == "png" || $ext == "jpg" || $ext == "jpeg")
                                    <img src="{{ asset('upload/book/url/'.$bookdata->url) }}" class="thumbnail" height="100" width="100">
                                    @else
                                    <p>{{ $bookdata->url }}</p>
                                    @endif
                                @endif
                                @endif
                            </div>
                        </div>
                        <div class="form-group col-lg-4">
                            <label class="form-label">Thumbnail</label>
                            <div class="form-control-wrap">
                                <input type="file" class="form-control" id="thumbnail" name="thumbnail" value="">
                                <input type="hidden" name="hidden_thumbnail" value="{{ $bookdata->thumbnail }}">
                                <br/>
                                @if($bookdata->thumbnail)
                                <img src="{{ asset('upload/book/thumbnail/'.$bookdata->thumbnail) }}" class="thumbnail" height="100" width="100">
                                @endif
                                @error('thumbnail')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group col-lg-4">
                            <label class="form-label">Label</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="label" name="label" value="{{ $bookdata->label }}">
                                @error('label')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        </div>

                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label class="form-label">Description</label>
                                <div class="form-control-wrap">
                                    <input class="form-control" id="description" name="description" value="{{ $bookdata->description }}">
                                    @error('description')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-lg-4">
                                <label class="form-label">Edition</label>
                                <div class="form-control-wrap">
                                    <select class="form-control edition" name="edition" id="edition">
                                        <option value="" selected="" disabled="">--Select Edition--</option>
                                        <option value="old" @if($bookdata->description == 'old') selected @endif>Old</option>
                                        <option value="new" @if($bookdata->description == 'new') selected @endif>New</option>
                                    </select>
                                    @error('edition')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-lg-4">
                                <label class="form-label">Release Date</label>
                                <div class="form-control-wrap">
                                    <input type="date" class="form-control" id="release_date" name="release_date" value="{{ $bookdata->release_date }}">
                                    @error('release_date')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>                        

                        
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-primary">Submit</button>
                            <a type="button" href="{{ route('book.index') }}" class="btn btn-lg btn-danger text-light">Cancel</a>
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

        $('#title').autocomplete({
            serviceUrl: '{{route("load_autocomplete.book_title")}}',
            onSelect: function (suggestion) {
                $(this).val(suggestion.data);
            }
        });

        $('#sub_title').autocomplete({
            serviceUrl: '{{route("load_autocomplete.book")}}',
            onSelect: function (suggestion) {
                $(this).val(suggestion.data);
            }
        });

        var board_id = $('.board_id').val();
        var medium_id = "{{ $bookdata->medium_id }}";
        var standard_id = "{{ $bookdata->standard_id }}";
        var semester_id = "{{ $bookdata->semester_id }}";
        var subject_id = "{{ $bookdata->subject_id }}";
        var unit_id = "{{ $bookdata->unit_id }}";
        getMediumEdit(board_id,medium_id);
        getStandardEdit(board_id,medium_id,standard_id);
        getSemesterEdit(board_id,medium_id,standard_id,semester_id);
        getSubjectEdit(board_id,medium_id,standard_id,semester_id,subject_id);
        getUnitEdit(board_id,medium_id,standard_id,semester_id,subject_id,unit_id);

        var chkval = $('.urlchk').val();
        if(chkval == "text"){
            $('.urlchk').prop('checked',true);
            $("#url").attr('type', 'text');
            var urlval = "{{ $bookdata->url }}";
            $("#url").val(urlval);
            $('#url_type').val('text');
        }
        else if(chkval == "file"){
            $("#url").attr('type', 'file');
            $('#url_type').val('file');
        }

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

    $(document).on('change','.urlchk',function(){
        if($(this).prop("checked") == true){
            $("#url").attr('type', 'text');
            $('#url_type').val('text');
        }
        else if($(this).prop("checked") == false){
            $("#url").attr('type', 'file');
            $('#url_type').val('file');
        }
    });

</script>

@endsection