@extends('layouts.app')
@section('title','Add Note')

@section('content')

<div class="nk-block nk-block-lg">
    <div class="row g-gs">
        <div class="col-lg-12">
            <div class="card h-100">
                <div class="card-inner">
                    <div class="card-head">
                        <h5 class="card-title">Add Note</h5>
                    </div>
                    <form action="{{ route('note.store') }}" method="POST" enctype='multipart/form-data' id="note_form">
                    @csrf
                        <input type="hidden" name="hidden_id" class="hidden_id" id="hidden_id" value="0">
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label class="form-label">Board</label>
                                <div class="form-control-wrap">
                                    <select name="board_id" class="form-control board_id" id="board_id">
                                        <option value="">--Select Board--</option>
                                        @foreach($boards as $boards_data)
                                        <option value="{{ $boards_data->id }}" @if(old('board_id') == $boards_data->id) selected="" @endif>{{ $boards_data->name }}</option>
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
                                        <option value="">--Select Medium--</option>
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
                                        <option value="">--Select Standard--</option>
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
                                <label class="form-label">Subject</label>
                                <div class="form-control-wrap">
                                    <select name="subject_id" class="form-control subject_id" id="subject_id">
                                        <option value="">--Select Subject--</option>
                                    </select>
                                    @error('subject_id')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group col-lg-4">
                                <label class="form-label">Semester</label>
                                <div class="form-control-wrap">
                                    <select name="semester_id" class="form-control semester_id" id="semester_id">
                                        <option value="">--Select Semester--</option>
                                    </select>
                                    @error('semester_id')
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
                                        <option value="">--Select Unit--</option>
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
                                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
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
                                    <input type="text" class="form-control" id="sub_title" name="sub_title" value="{{ old('sub_title') }}">
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
                                    <input type="text" class="form-control" id="pages" name="pages" value="{{ old('pages') }}">
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
                                    <input type="hidden" name="url_type" class="url_type" id="url_type" value="Drive">
                                    <div class="col-lg-6"><label class="form-label">Url</label></div>
                                    <div class="col-lg-6 text-right"><div class="g">
                                        <div class="custom-control custom-control-sm custom-checkbox">
                                            <input type="checkbox" class="custom-control-input urlchk" name="instant_result" value="1" id="instant_result">
                                            <label class="custom-control-label" for="instant_result"></label>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="url" name="url" value="">
                                    <input type="hidden" id="hidden_url" name="hidden_url" value="">
                                    <img id="url_preview" src="#" alt="your image" class="thumbnail mt-1" height="100"  />
                                    @error('url')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-lg-4">
                                <div class="row">
                                    <input type="hidden" name="thumbnail_file_type" class="thumbnail_file_type" id="thumbnail_file_type" value="Drive">
                                    <div class="col-lg-6"><label class="form-label">Thumbnail</label></div>
                                    <div class="col-lg-6 text-right"><div class="g">
                                        <div class="custom-control custom-control-sm custom-checkbox">
                                            <input type="checkbox" class="custom-control-input thumbnailchk" name="thumbnail_result" value="1" id="thumbnail_result">
                                            <label class="custom-control-label" for="thumbnail_result"></label>
                                        </div>
                                    </div>
                                    </div>
                                </div>

                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="thumbnail" name="thumbnail" value="">
                                    <input type="hidden" id="hidden_thumbnail" name="hidden_thumbnail" value="">
                                    
                                    @error('thumbnail')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <img id="thumbnail_preview" src="#" alt="your image" class="thumbnail mt-1" height="100" />    
                            </div>


                            <div class="form-group col-lg-4">
                                <label class="form-label">Label</label>
                                <div class="form-control-wrap">
                                    <select class="form-control" id="label" name="label">
                                        <option value="" selected="" disabled="">--Select Label--</option>
                                        <option value="new">New</option>
                                        <option value="commingsoon">CommingSoon</option>
                                        <option value="leatest">Leatest</option>
                                    </select>
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
                                    <input type="text" class="form-control" id="description" name="description" value="{{ old('description') }}">
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
                                        <option value="old">Old</option>
                                        <option value="new">New</option>
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
                                    <input type="date" class="form-control" id="release_date" name="release_date" value="{{ old('release_date') }}">
                                    @error('release_date')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-lg btn-primary submitbtn">Submit</button>
                            <a type="button" href="{{ route('note.index') }}" class="btn btn-lg btn-danger text-light">Cancel</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
            
    </div>
</div><!-- .nk-block -->

<br/>

<div class="dyamictable">
    @include('note.dynamic_table')
</div>
            

@endsection

@section('scripts')

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>

<script type="text/javascript">

    $(document).on('click','.above_order', function() {
        var order_no=$(this).data('order_no');
        $.ajax({
                url: "{{route('above_order.note')}}",
                type: "GET",
                data: {
                    "order_no": order_no,
                    "semester_id":"{{(!empty($semesters_details->id) ? $semesters_details->id : '""')}}"
                },
                success: function(html) {
                    $('.dyamictable').empty();
                    $('.dyamictable').html(html.html);
                    $(".datatable-init").DataTable();                  
                }
            });
    });
    $(document).on('click','.below_order', function() {
        var order_no=$(this).data('order_no');
        $.ajax({
                url: "{{route('below_order.note')}}",
                type: "GET",
                data: {
                    "order_no": order_no,
                    "semester_id":"{{(!empty($semesters_details->id) ? $semesters_details->id : '""')}}"
                },
                success: function(html) {
                    $('.dyamictable').empty();
                    $('.dyamictable').html(html.html);
                    $(".datatable-init").DataTable();                  
                }
        });    
    });

$(document).ready(function(){

    $('#title').autocomplete({
            serviceUrl: '{{route("load_autocomplete.note_title")}}',
            onSelect: function (suggestion) {
                $(this).val(suggestion.data);
            }
        });

    $('#sub_title').autocomplete({
        serviceUrl: '{{route("load_autocomplete.note")}}',
        onSelect: function (suggestion) {
            $(this).val(suggestion.data);
        }
    });

    $('#thumbnail_preview').css('display','none');
    $('#url_preview').css('display','none');
});    

function readThumbnail(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    
    reader.onload = function(e) {
      $('#thumbnail_preview').attr('src', e.target.result);
    }
    
    reader.readAsDataURL(input.files[0]); // convert to base64 string
  }
}

$("#thumbnail").change(function() {
    if($('.thumbnailchk').prop("checked") == true){
        $('#thumbnail_preview').css('display','block');
    }
    else if($('.thumbnailchk').prop("checked") == false){
        $('#thumbnail_preview').css('display','none');
    }
    //$('#thumbnail_preview').css('display','block');
    readThumbnail(this);
});

function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    
    reader.onload = function(e) {
      $('#url_preview').attr('src', e.target.result);
    }
    
    reader.readAsDataURL(input.files[0]); // convert to base64 string
  }
}

$("#url").change(function() {

    var url_type = $('#url_type').val();

    if(url_type == "Server"){
        $('#url_preview').css('display','block');
        readURL(this);
    }
    else{
        $('#url_preview').css('display','none');
    }
});

$("#thumbnail").change(function() {
    if($('.thumbnailchk').prop("checked") == true){
        $('#thumbnail_preview').css('display','block');
    }
    else if($('.thumbnailchk').prop("checked") == false){
        $('#thumbnail_preview').css('display','none');
    }
    readThumbnail(this);
});


$( document ).ready(function() {
    var check_board = <?PHP echo json_encode($isset); ?>;
    if(check_board == 1){

        var boardid = <?PHP echo (!empty($semesters_details->board_id) ? json_encode($semesters_details->board_id) : '""'); ?>;
        var mediumid = <?PHP echo (!empty($semesters_details->medium_id) ? json_encode($semesters_details->medium_id) : '""'); ?>;
        var standardid = <?PHP echo (!empty($semesters_details->standard_id) ? json_encode($semesters_details->standard_id) : '""'); ?>;
        var  subjectid = <?PHP echo (!empty($semesters_details->subject_id) ? json_encode($semesters_details->subject_id) : '""'); ?>;
        var semesterid = <?PHP echo (!empty($semesters_details->id) ? json_encode($semesters_details->id) : '""'); ?>;
            
        $('.board_id').val(boardid);
        var board_id = boardid;
        var medium_id = mediumid;
        var standard_id = standardid;
        var semester_id = semesterid;
        var subject_id = subjectid;
        
        getMediumEdit(board_id,medium_id);
        getStandardEdit(board_id,medium_id,standard_id);
        getSubjectEdit(board_id,medium_id,standard_id,subject_id);
        getSemesterEdit(board_id,medium_id,standard_id,subject_id,semester_id);  
        getUnit(board_id,medium_id,standard_id,semester_id,subject_id);
    }
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


function getSubjectEdit(board_id,medium_id,standard_id,subject_id){
    $.ajax({
        type: "GET",
        url: "{{route('get.subject')}}",
        data: {
            "board_id":board_id,
            "medium_id":medium_id,
            "standard_id":standard_id,
            "subject_id":subject_id,
        },
        success: function(result) {
            $('.subject_id').html('');
            $('.subject_id').html(result.html);
        } 
    });
}

function getSemesterEdit(board_id,medium_id,standard_id,subject_id,semester_id){
    $.ajax({
        type: "GET",
        url: "{{route('get.semester.unit')}}",
        data: {
            "board_id":board_id,
            "medium_id":medium_id,
            "standard_id":standard_id,
            "subject_id":subject_id,
            "semester_id":semester_id,
        },
        success: function(result) {
            $('.semester_id').html('');
            $('.semester_id').html(result.html);
        } 
    });
}

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


$(document).on('change','.board_id',function(){
    var board_id = $('.board_id').val();
    getMedium(board_id);
});

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


function getStandard(board_id,medium_id){
    $.ajax({
        type: "GET",
        url: "{{route('get.standard')}}",
        data: {
            "board_id":board_id,
            "medium_id":medium_id,

        },
        success: function(result) {
            $('#standard_id').html('');
            $('#standard_id').html(result.html);
        } 
    });
}


$(document).on('change','.standard_id',function(){
    var standard_id = $('.standard_id').val();
    var medium_id = $('.medium_id').val();
    var board_id = $('.board_id').val();
    getSubject(standard_id,medium_id,board_id);
    //getSemester(standard_id,medium_id,board_id);
});

function getSubject(standard_id,medium_id,board_id){
    $.ajax({
        type: "GET",
        url: "{{route('get.subject')}}",
        data: {
            "standard_id":standard_id,
            "medium_id":medium_id,
            "board_id":board_id
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
    getSemester(board_id,medium_id,standard_id,subject_id);
    //getUnit(board_id,medium_id,standard_id,semester_id,subject_id);
});

function getSemester(board_id,medium_id,standard_id,subject_id){
    $.ajax({
        type: "GET",
        url: "{{route('get.semester.unit')}}",
        data: {
            "board_id":board_id,
            "medium_id":medium_id,
            "standard_id":standard_id,
            "subject_id":subject_id,
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
    var medium_id = $('.medium_id').val();
    var board_id = $('.board_id').val();
    var subject_id = $('.subject_id').val();
    getUnit(board_id,medium_id,standard_id,semester_id,subject_id);
});

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

$(document).ready(function () {
    
    $('#note_form').validate({
         rules: {
                board_id:"required",
                medium_id:"required",
                standard_id:"required",
                semester_id:"required",
                subject_id:"required",
                unit_id:"required",
                title:"required",
                sub_title:"required",
                //url:"required",
                //thumbnail:"required",
                edition:"required"
            },
        //For custom messages
        messages: {

            board_id:"Please select board.",
            medium_id:"Please select medium.",
            standard_id:"Please select standard.",
            semester_id:"Please select semester.",
            subject_id:"Please select subject.",
            unit_id:"Please select unit.",
            title:"Please enter title.",
            sub_title:"Please enter sub title",
            //url:"Please enter url.",
            //thumbnail:"Please select thumbnail.",
            edition:"Please select edition."
        },
        submitHandler: function(form) {
            var formData = new FormData($("#note_form")[0]);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
                },
                url: form.action,
                type: form.method,
                data: formData,//$(form).serialize(),
                contentType: false,
                processData: false,
                success: function(data) {
                    confirm(data.message);
                    $('#title').val('');
                    $('#sub_title').val('');
                    $('#url').val('');
                    $('#thumbnail').val('');
                    $('#pages').val('');
                    $('#description').val('');
                    $('#label').val('');
                    $('#release_date').val('');
                    $('#edition').val('');

                    $('#hidden_id').val('0');

                    $('#url_preview').css('display','none');
                    $(".urlchk").prop("checked",false);
                    $("#url").attr('type', 'text');
                    $('#url_type').val('Drive');
                    $('#hidden_url').val('');

                    $('#thumbnail_preview').css('display','none');
                    $('.thumbnailchk').prop("checked",false);
                    $("#thumbnail").attr('type', 'text');
                    $('#thumbnail_file_type').val('Drive');
                    $('#thumbnail').val('');
                    
                    $('.dyamictable').empty();
                    $('.dyamictable').html(data.html);
                    $(".datatable-init").DataTable();
                }            
            });
        }
    });
    
});

// $(document).on('change','.urlchk',function(){
//     if($(this).prop("checked") == true){
//         $("#url").attr('type', 'text');
//         $('#url_type').val('text');
//         $('#url').val('');
//         $('#url_preview').css('display','none');
//     }
//     else if($(this).prop("checked") == false){
//         $("#url").attr('type', 'file');
//         $('#url_type').val('file');
//         $('#url').val('');
//     }
// });

$(document).on('change','.urlchk',function(){
    if($(this).prop("checked") == true){
        $("#url").attr('type', 'file');
        $('#url_type').val('Server');
        $('#url').val('');
    }
    else if($(this).prop("checked") == false){
        $("#url").attr('type', 'text');
        $('#url_type').val('Drive');
        $('#url').val('');
        $('#url_preview').css('display','none');
    }
});


$(document).on('click','.edit-btn',function(){
    var id = $(this).attr('data-id');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
        },
        url: "{{ route('note.edit') }}",
        type: 'GET',
        data: {
              'id':id
        },
        success: function(result) {
            $('#board_id').val(result.board_id);
            var board_id = $('#board_id').val();
            var medium_id = result.medium_id;
            var standard_id = result.standard_id;
            var semester_id = result.semester_id;
            var subject_id = result.subject_id;
            var unit_id = result.unit_id;
            getMediumEdit(board_id,medium_id);
            getStandardEdit(board_id,medium_id,standard_id);
            getSubjectEdit(board_id,medium_id,standard_id,subject_id);
            getSemesterEdit(board_id,medium_id,standard_id,subject_id,semester_id);
            getUnitEdit(board_id,medium_id,standard_id,semester_id,subject_id,unit_id);

            $('#title').val(result.title);
            $('#sub_title').val(result.sub_title);
            $('#description').val(result.description);
            $('#pages').val(result.pages);
            $('#label').val(result.label);
            $('#release_date').val(result.release_date);
            $('#edition').val(result.edition);

            if(result.thumbnail_file_type == 'Drive'){

                $('.thumbnailchk').prop("checked",false);
                $('#hidden_thumbnail').val(result.thumbnail);
                $('#thumbnail').val(result.thumbnail);
                $('#thumbnail_preview').css('display','none');
                $("#thumbnail").attr('type', 'text');
                $('#thumbnail_file_type').val('Drive');
        
            }
            else{
                $('.thumbnailchk').prop("checked",true);
                $('#hidden_thumbnail').val(result.thumbnail);
                $('#thumbnail_preview').css('display','block');
                $("#thumbnail").attr('type', 'file');
                $('#thumbnail_file_type').val('Server');      
                var thumbnail_path = "{{ env('APP_URL') }}"+"/upload/note/thumbnail/"+result.thumbnail;
                $('#thumbnail_preview').attr('src', thumbnail_path);          
            }


            if(result.url_type == 'Drive'){

                $('.urlchk').prop("checked",false);
                $('#hidden_url').val(result.url);
                $("#url").val(result.url);
                $('#url_preview').css('display','none');
                $("#url").attr('type', 'text');
                $('#url_type').val('Drive');   
            }
            else{
                $('.urlchk').prop("checked",true);
                $('#hidden_url').val(result.url);
                $('#url_preview').css('display','block');
                $("#url").attr('type', 'file');
                $('#url_type').val('Server'); 
                
                var url_path = "{{ env('APP_URL') }}"+"/upload/note/url/"+result.url;
                $('#url_preview').attr('src', url_path);     
            }

            // if(result.url_type == 'file'){
            //     $('#hidden_url').val(result.url);
            //     $('#url_preview').css('display','block');
            //     var url_path = "{{ env('APP_URL') }}"+"/upload/note/url/"+result.url;
            //     $('#url_preview').attr('src', url_path);    
            // }
            // else{
            //     $('.urlchk').prop("checked",true);
            //     $("#url").attr('type', 'text');
            //     $('#url_type').val('text');
            //     $('#url_preview').css('display','none');   
            //     $('#url').val(result.url);
            // }
            

            
            $('#hidden_id').val(result.id);
            //$('#thumbnail').val('');
        }            
    });
});

$(document).on('click','.distroy', function() {
    var id = $(this).attr('data-id');
    var semester_id = $('#semester_id').val();
    bootbox.confirm({
        message: "Are you sure to delete this note ?",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn-success'
            },
            cancel: {
                label: 'No',
                className: 'btn-danger'
            }
        },
        callback: function(result) {
            if(result){
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
                    },
                    url: "{{ route('note.distroy') }}",
                    type: "GET",
                    data: {
                        'id':id,
                        'semester_id':semester_id,
                    },
                    success: function(data) {
                        confirm("Note Deleted Successfully.");
                            
                        $('#title').val('');
                        $('#sub_title').val('');
                        $('#url').val('');
                        $('#thumbnail').val('');
                        $('#pages').val('');
                        $('#description').val('');
                        $('#label').val('');
                        $('#release_date').val('');
                        $('#edition').val('');

                        $('#thumbnail').val('');
                        $('#thumbnail_preview').css('display','none');

                        $('#url').val('');
                        $('#url_preview').css('display','none');

                        $('#hidden_thumbnail').val('');
                        $('#hidden_url').val('');

                        $('.dyamictable').empty();
                        $('.dyamictable').html(data);
                        $(".datatable-init").DataTable();
                    }            
                });
                //location.replace(del_url);
            }
        }
    });
});

$(document).on('click','.status_change', function() {
    var id = $(this).attr('data-id');
    var status = $(this).attr('data-status');

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
        },
        url: "{{ route('note.distroy') }}",
        type: "GET",
        data: {
            'id':id,
            'status':status,
        },
        success: function(data) {
            confirm("Note Status Change Successfully.");
            
            $('.dyamictable').empty();
            $('.dyamictable').html(data);
            $(".datatable-init").DataTable();
        }            
    });
});

$(document).on('change','.thumbnailchk',function(){
    if($(this).prop("checked") == true){
        $("#thumbnail").attr('type', 'file');
        $('#thumbnail_file_type').val('Server');
        $('#thumbnail').val('');
    }
    else if($(this).prop("checked") == false){
        $("#thumbnail").attr('type', 'text');
        $('#thumbnail_file_type').val('Drive');
        $('#thumbnail').val('');
        $('#thumbnail_preview').css('display','none');
    }
});

</script>

@endsection