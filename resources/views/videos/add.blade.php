@extends('layouts.app')
@section('title','Add Video')
@section('css')
<style>
table {
    table-layout:fixed;
}
td{
    overflow:hidden;    
    text-overflow: ellipsis;
    white-space: normal !important;
}
</style>

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
                    <form action="{{ route('videos.store') }}" method="POST" enctype='multipart/form-data' id="videos_form">
                    @csrf

                        <input type="hidden" name="hidden_id" class="hidden_id" id="hidden_id" value="0">
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label class="form-label">Board</label>
                                <div class="form-control-wrap">
                                    <select name="board_id" class="form-control board_id" id="board_id">
                                        <option value="">--Select Board--</option>
                                        @foreach($boards as $boards_data)
                                        <option value="{{ $boards_data->id }}" @if(old('board_id') == $boards_data->id) selected="" @endif>{{ $boards_data->name}}</option>
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

                            <!-- <div class="form-group col-lg-4">
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
                            </div> -->

                            

                            <!-- <div class="form-group col-lg-4">
                                <label class="form-label">Url</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="url" name="url" value="{{ old('url') }}">
                                    <input type="file" class="form-control url_file" id="url_file" name="url_file" value="">
                                    @error('url')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div> -->
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-2">
                                <label class="form-label">URL Type</label>
                                <div class="form-control-wrap">
                                    <select name="url_type" class="form-control url_type" id="url_type">
                                        <option value="Youtube">Youtube</option>
                                        <option value="Drive">Drive</option>
                                        <option value="Server">Server</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-lg-3">
                                <div class="row">
                                    <div class="col-lg-6"><label class="form-label">Url</label></div>

                                </div>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="url" name="url" value="">
                                    <input type="hidden" id="hidden_url" name="hidden_url" value="">
                                    <img id="url_preview" src="#" alt="your image" class="thumbnail mt-1" height="100" width="100" />
                                    @error('url')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-lg-2">
                                <label class="form-label">Thumbnail Type</label>
                                <div class="form-control-wrap">
                                    <select name="thumbnail_file_type" class="form-control thumbnail_file_type" id="thumbnail_file_type">
                                        <option value="Youtube">Youtube</option>
                                        <option value="Drive">Drive</option>
                                        <option value="Server">Server</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-lg-3">
                                <label class="form-label">Thumbnail</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="thumbnail" name="thumbnail" value="">
                                    <input type="hidden" id="hidden_thumbnail" name="hidden_thumbnail" value="">
                                    <img id="thumbnail_preview" src="#" alt="your image" class="thumbnail mt-1" height="100" width="100" />
                                    @error('thumbnail')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            

                            <div class="form-group col-lg-2">
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

                            <div class="form-group col-lg-3">
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

                            <div class="form-group col-lg-3">
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

                            <div class="form-group col-lg-2">
                                <label class="form-label">Start Time</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="start_time" name="start_time" value="{{ old('start_time') }}">
                                    @error('start_time')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
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
<br/>
<div class="dyamictable">
    @include('videos.dynamic_table')
</div>

@endsection

@section('scripts')

<script type="text/javascript">

    $(document).on('click','.above_order', function() {
        var order_no=$(this).data('order_no');
        $.ajax({
                url: "{{route('above_order.video')}}",
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
                url: "{{route('below_order.video')}}",
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
            serviceUrl: '{{route("load_autocomplete.video")}}',
            onSelect: function (suggestion) {

                    $(this).val(suggestion.data);
            }
        });
        $('#sub_title').autocomplete({
            serviceUrl: '{{route("load_autocomplete.video_sub_title")}}',
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

    // $("#thumbnail").change(function() {
    //     $('#thumbnail_preview').css('display','block');
    //   (this);
    // });

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
        var thumbnail_file_type = $('#thumbnail_file_type').val();

        if(thumbnail_file_type == "Server"){
            $('#thumbnail_preview').css('display','block');
            readThumbnail(this);
        }
        else{
            $('#thumbnail_preview').css('display','none');
        }
    });

    


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
            $('#url').css('display','none');
        }else{
            $('.url_file').css('display','none');
            $('#url').css('display','block');
        }
    }

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
    
    $('#videos_form').validate({
         rules: {
                board_id:"required",
                medium_id:"required",
                standard_id:"required",
                semester_id:"required",
                subject_id:"required",
                unit_id:"required",
                title:"required",
                sub_title:"required",
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
            sub_title:"Please enter sub title"
        },
        submitHandler: function(form) {
            var formData = new FormData($("#videos_form")[0]);

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
                    $('#duration').val('');
                    $('#label').val('');
                    $('#release_date').val('');
                    $('#edition').val('');
                    $('#start_time').val('');
                    $('#description').val('');

                    $('#thumbnail_preview').css('display','none');
                    $("#thumbnail").attr('type', 'text');
                    $('#thumbnail_file_type').val('Youtube');
                    $('#thumbnail').val('');

                    $('#url_preview').css('display','none');
                    $("#url").attr('type', 'text');
                    $('#url_type').val('Youtube');
                    $('#hidden_url').val('');
                    $('#hidden_id').val('0');
                    
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


$(document).on('click','.edit-btn',function(){
    var id = $(this).attr('data-id');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
        },
        url: "{{ route('videos.edit') }}",
        type: 'GET',
        data: {
              'id':id
        },
        success: function(result) {
            $('#board_id').val(result.videodetails.board_id);
            var board_id = $('#board_id').val();
            var medium_id = result.videodetails.medium_id;
            var standard_id = result.videodetails.standard_id;
            var semester_id = result.videodetails.semester_id;
            var subject_id = result.videodetails.subject_id;
            var unit_id = result.videodetails.unit_id;
            getMediumEdit(board_id,medium_id);
            getStandardEdit(board_id,medium_id,standard_id);
            getSubjectEdit(board_id,medium_id,standard_id,subject_id);
            getSemesterEdit(board_id,medium_id,standard_id,subject_id,semester_id);
            getUnitEdit(board_id,medium_id,standard_id,semester_id,subject_id,unit_id);

            $('#title').val(result.videodetails.title);
            $('#sub_title').val(result.videodetails.sub_title);
            $('#description').val(result.videodetails.description);
            $('#duration').val(result.videodetails.duration);
            $('#label').val(result.videodetails.label);
            $('#start_time').val(result.videodetails.start_time);
            $('#release_date').val(result.videodetails.release_date);
            $('#edition').val(result.videodetails.edition);

            if(result.videodetails.thumbnail_file_type == 'Drive' || result.videodetails.thumbnail_file_type == 'Youtube'){

                $('#hidden_thumbnail').val(result.videodetails.thumbnail);
                $('#thumbnail').val(result.videodetails.thumbnail);
                $('#thumbnail_preview').css('display','none');
                $("#thumbnail").attr('type', 'text');
                $('#thumbnail_file_type').val(result.videodetails.thumbnail_file_type);
        
            }
            else{
                $('#hidden_thumbnail').val(result.videodetails.thumbnail);
                $('#thumbnail_preview').css('display','block');
                $("#thumbnail").attr('type', 'file');
                $('#thumbnail_file_type').val('Server'); 
                var thumbnail_path = "{{ env('APP_URL') }}"+"/data/"+board_id+'_'+result.sub_title.board_sub_title.sub_title+"/"+medium_id+'_'+result.sub_title.medium_sub_title.sub_title+"/"+standard_id+'_'+
                result.sub_title.standard_sub_title.sub_title
                +"/"+subject_id+'_'+result.sub_title.subject_sub_title.sub_title+"/"+semester_id+'_'+
                result.sub_title.semester_sub_title.sub_title+"/"+unit_id+'_'+result.sub_title.unit_sub_title.sub_title+"/videos/thumbnail/"+result.videodetails.thumbnail;
                $('#thumbnail_preview').attr('src', thumbnail_path);               
            }

            //alert(result.url_type);
            if(result.videodetails.url_type == 'Drive' || result.videodetails.url_type == 'Youtube'){
                $("#url").attr('type', 'text');
                $('#url_type').val(result.videodetails.url_type);
                $('#url_preview').css('display','none');   
                $('#url').val(result.videodetails.url);
            }
            else{
                $("#url").attr('type', 'file');
                $('#hidden_url').val(result.videodetails.url);
                $('#url_preview').css('display','block');
                $('#url_type').val('Server');
                var url_path = "{{ env('APP_URL') }}"+"/data/"+board_id+'_'+result.sub_title.board_sub_title.sub_title+"/"+medium_id+'_'+result.sub_title.medium_sub_title.sub_title+"/"+standard_id+'_'+
                result.sub_title.standard_sub_title.sub_title
                +"/"+subject_id+'_'+result.sub_title.subject_sub_title.sub_title+"/"+semester_id+'_'+
                result.sub_title.semester_sub_title.sub_title+"/"+unit_id+'_'+result.sub_title.unit_sub_title.sub_title+"/videos/url/"+result.videodetails.url;
                $('#url_preview').attr('src', url_path);  
            }

            // $('#hidden_thumbnail').val(result.thumbnail);
            // $('#thumbnail_preview').css('display','block');
            
            
            $('#hidden_id').val(result.videodetails.id);
            //$('#thumbnail').val('');
        }            
    });
});


$(document).on('click','.distroy', function() {
    var id = $(this).attr('data-id');
    var semester_id = $('#semester_id').val();
    bootbox.confirm({
        message: "Are you sure to delete this video ?",
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
                    url: "{{ route('videos.distroy') }}",
                    type: "GET",
                    data: {
                        'id':id,
                        'semester_id':semester_id,
                    },
                    success: function(data) {
                        confirm("Video Deleted Successfully.");
                            
                        $('#title').val('');
                        $('#sub_title').val('');
                        $('#url').val('');
                        $('#thumbnail').val('');
                        $('#duration').val('');
                        $('#description').val('');
                        $('#label').val('');
                        $('#release_date').val('');
                        $('#edition').val('');
                        $('#start_time').val('');

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
        url: "{{ route('videos.distroy') }}",
        type: "GET",
        data: {
            'id':id,
            'status':status,
        },
        success: function(data) {
            confirm("Video Status Change Successfully.");
            
            $('.dyamictable').empty();
            $('.dyamictable').html(data);
            $(".datatable-init").DataTable();
        }            
    });
});


$(document).on('change','#thumbnail_file_type',function(){
    var getval = $(this).val();
    if(getval == "Server"){
        $("#thumbnail").attr('type', 'file');
        $('#thumbnail_file_type').val('Server');
        $('#thumbnail').val('');
    } 
    else{
        $("#thumbnail").attr('type', 'text');
        $('#thumbnail').val('');
        $('#thumbnail_preview').css('display','none'); 
    }
});

$(document).on('change','#url_type',function(){
    var getval = $(this).val();
    if(getval == "Server"){
        $("#url").attr('type', 'file');
        $('#url_type').val('Server');
        $('#url').val('');
    } 
    else{
        $("#url").attr('type', 'text');
        $('#url').val('');
        $('#url_preview').css('display','none'); 
    }
});


</script>

@endsection