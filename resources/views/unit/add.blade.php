@extends('layouts.app')
@section('title','Add Unit')
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
                        <h5 class="card-title">Add Unit</h5>
                    </div>
                    <form action="{{ route('unit.store') }}" method="POST" enctype='multipart/form-data' id="unit_form">
                    @csrf
                        <input type="hidden" name="hidden_id" class="hidden_id" id="hidden_id" value="0">
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label class="form-label">Board</label>
                                <div class="form-control-wrap">
                                    <select name="board_id" class="form-control board_id" id="board_id">
                                        <option>--Select Board--</option>
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
                           

                            <div class="form-group col-lg-3">
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

                            <div class="form-group col-lg-3">
                                <div class="row">
                                    <input type="hidden" name="url_type" class="url_type" id="url_type" value="file">
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
                                    <input type="file" class="form-control" id="url" name="url" value="">
                                    <input type="hidden" id="hidden_url" name="hidden_url" value="">
                                    <img id="url_preview" src="{{asset('assets/images/logo-small.png')}}" alt="your image" class="thumbnail mt-1" height="100" />
                                    @error('url')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-lg-3">
                                <label class="form-label">Thumbnail</label>
                                <div class="form-control-wrap">
                                    <input type="file" class="form-control" id="thumbnail" name="thumbnail" value="">
                                    <input type="hidden" id="hidden_thumbnail" name="hidden_thumbnail" value="">
                                    <img id="thumbnail_preview" src="{{asset('assets/images/logo-small.png')}}" alt="your image" class="thumbnail mt-1" height="100" />
                                    @error('thumbnail')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-lg-3">
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
                        
                            

                            <!-- <div class="form-group col-lg-1">
                                <div class="form-control-wrap mt-4">
                                    <button type="button" class="btn btn-success mt-1 add_row"><i class="icon ni ni-plus"></i></button>
                                </div>
                            </div> -->

                        </div>

                        <!-- <div class="newPlus">
                            
                        </div> -->

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-lg btn-primary">Submit</button>
                            <a type="button" href="{{ route('unit.index') }}" class="btn btn-lg btn-danger text-light">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
            
    </div>
</div><!-- .nk-block -->
<br/>
<div class="dyamictable">
    @include('unit.dynamic_table')
</div>

@endsection

@section('scripts')

<script type="text/javascript">
    $("#sub_title").keypress(function (e) {
            var keyCode = e.keyCode || e.which;
 
            $("#lblError").html("");
 
            //Regex for Valid Characters i.e. Alphabets.
            var regex = /^[0-9A-Za-z.\-_]+$/;
 
            //Validate TextBox value against the Regex.
            var isValid = regex.test(String.fromCharCode(keyCode));
            if (!isValid) {
                $("#error_sub_title").html("Only Alphabets allowed.");
            }
 
            return isValid;
    });
    $(document).on('click','.above_order', function() {
        var order_no=$(this).data('order_no');
        $.ajax({
                url: "{{route('above_order.unit')}}",
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
                url: "{{route('below_order.unit')}}",
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
        serviceUrl: '{{route("load_autocomplete.unit")}}',
        onSelect: function (suggestion) {

                $(this).val(suggestion.data);
        }
    });
    $('#description').autocomplete({
        serviceUrl: '{{route("load_autocomplete.unit_sub_title")}}',
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
    $('#thumbnail_preview').css('display','block');
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

    if(url_type == "file"){
        $('#url_preview').css('display','block');
        readURL(this);
    }
});



$( document ).ready(function() {
    var check_board = <?PHP echo json_encode($isset); ?>;
    if(check_board == 1){
        var boardid = <?PHP echo (!empty($semesters_details->board_id) ? json_encode($semesters_details->board_id) : '""'); ?>;
        var mediumid = <?PHP echo (!empty($semesters_details->medium_id) ? json_encode($semesters_details->medium_id) : '""'); ?>;
        var standardid = <?PHP echo (!empty($semesters_details->standard_id) ? json_encode($semesters_details->standard_id) : '""'); ?>;
        var subjectid = <?PHP echo (!empty($semesters_details->subject_id) ? json_encode($semesters_details->subject_id) : '""'); ?>;
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
       // $('.subject_id').val(subject_id);
            
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



/*----------------------------*/

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
            $('.standard_id').html('');
            $('.standard_id').html(result.html);
        } 
    });
}    


$(document).on('change','.standard_id',function(){
    var standard_id = $('.standard_id').val();
    var board_id = $('.board_id').val();
    var medium_id = $('.medium_id').val();
  //  getSemester(standard_id,board_id,medium_id);
    getSubject(standard_id,medium_id,board_id);
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
   var subject_id = $('.subject_id').val();
   getSemester(board_id,medium_id,standard_id,subject_id);
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






$(document).on('change','.urlchk',function(){
    if($(this).prop("checked") == true){
        $("#url").attr('type', 'text');
        $('#url_type').val('text');
        $('#url').val('');
        $('#url_preview').css('display','none');
    }
    else if($(this).prop("checked") == false){
        $("#url").attr('type', 'file');
        $('#url_type').val('file');
        $('#url').val('');
    }
});

$(document).ready(function () {
    
    $('#unit_form').validate({
         rules: {
                board_id:"required",
                medium_id:"required",
                standard_id:"required",
                semester_id:"required",
                title:"required",
                description:"required"

            },
        //For custom messages
        messages: {
                board_id:"Please selete board.",
                medium_id:"Please selete medium.",
                standard_id:"Please selete standard.",
                semester_id:"Please enter semester.",
                title:"Please enter title.",
                description:"Please enter sub title."
        },
        submitHandler: function(form) {
            var formData = new FormData($("#unit_form")[0]);

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
                    $('#description').val('');
                    $('#url').val('');
                    $('#thumbnail').val();
                    $('#hidden_thumbnail').val('');
                    $('#thumbnail_preview').css('display','none');

                    $(".urlchk").prop("checked",false);
                    $("#url").attr('type', 'file');
                    $('#url_type').val('file');
                    $('#hidden_url').val('');
                    $('#url_preview').css('display','none');
                    $('#hidden_id').val('0');
                    
                    $('.dyamictable').empty();
                    $('.dyamictable').html(data.html);
                    $(".datatable-init").DataTable();
                },
                error :function( data ) {
                    var errors = $.parseJSON(data.responseText);
                    
                    $.each(errors, function (key, value) {               
                        if(key=="errors")
                        { 
                           alert(value.sub_title[0]);
                        }

                    });
                }             
            });
        }
    });
    
});


$(document).on('click','.edit-btn',function(){
    var id = $(this).attr('data-id');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
        },
        url: "{{ route('unit.edit') }}",
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
            getMediumEdit(board_id,medium_id);
            getStandardEdit(board_id,medium_id,standard_id);
            getSubjectEdit(board_id,medium_id,standard_id,subject_id);
            getSemesterEdit(board_id,medium_id,standard_id,subject_id,semester_id);

            $('#title').val(result.title);
            $('#description').val(result.description);
            $('#pages').val(result.pages);
            if(result.url_type == 'file'){
                $('#hidden_url').val(result.url);
                $('#url_preview').css('display','block');
                var url_path = "{{ env('APP_URL') }}"+"/upload/unit/url/"+result.url;
                $('#url_preview').attr('src', url_path);    
            }
            else{
                $('.urlchk').prop("checked",true);
                $("#url").attr('type', 'text');
                $('#url_type').val('text');
                $('#url_preview').css('display','none');   
                $('#url').val(result.url);
            }
            $('#hidden_thumbnail').val(result.thumbnail);
            $('#thumbnail_preview').css('display','block');
            var thumbnail_path = "{{ env('APP_URL') }}"+"/upload/unit/thumbnail/"+result.thumbnail;
            $('#thumbnail_preview').attr('src', thumbnail_path);
            $('#sub_title').val(result.sub_title);
            //$('#sub_title').prop("readonly", true);   
            $('#hidden_id').val(result.id);
            //$('#thumbnail').val('');
        }            
    });
});

$(document).on('click','.distroy', function() {
    var id = $(this).attr('data-id');
    var semester_id = $('#semester_id').val();
    bootbox.confirm({
        message: "Are you sure to delete this unit ?",
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
                    url: "{{ route('unit.distroy') }}",
                    type: "GET",
                    data: {
                        'id':id,
                        'semester_id':semester_id,
                    },
                    success: function(data) {
                        confirm("Unit Deleted Successfully.");
                            
                        $('#title').val('');
                        $('#description').val('');
                        $('#pages').val('');
                        $('#url').val('');
                        $('#thumbnail').val('');
                        $('#hidden_thumbnail').val('');
                        $('#thumbnail_preview').css('display','none');
                        $('#hidden_url').val('');
                        $('#url_preview').css('display','none');

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
        url: "{{ route('unit.distroy') }}",
        type: "GET",
        data: {
            'id':id,
            'status':status,
        },
        success: function(data) {
            confirm("Unit Status Change Successfully.");
            
            $('.dyamictable').empty();
            $('.dyamictable').html(data);
            $(".datatable-init").DataTable();
        }            
    });

});
</script>

@endsection
