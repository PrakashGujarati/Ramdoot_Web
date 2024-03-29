@extends('layouts.app')
@section('title','Add Subject')
@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
                        <h5 class="card-title">Add Subject</h5>
                    </div>
                    <form action="{{ route('subject.store') }}" method="POST" enctype='multipart/form-data' id="subject_form">
                    @csrf
                        <input type="hidden" name="hidden_id" class="hidden_id" id="hidden_id" value="0">
                        <div class="row">

                            <div class="form-group col-lg-6">
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

                            <div class="form-group col-lg-6">
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

                        </div>

                        <div class="row">
                        <div class="form-group col-lg-6">
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
                        <div class="form-group col-lg-6">
                                <label class="form-label">Subject Name</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="subject_name" name="subject_name" value="{{ old('subject_name') }}">
                                    @error('subject_name')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-6">
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
                            </div>
                            
                            <div class="form-group col-lg-3">
                                <img id="thumbnail_preview" src="#" alt="your image" class="thumbnail mt-1" height="100" width="100" />
                            </div>
                        </div>

                        <div class="row">
                        

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
<br/>
<div class="dyamictable">
    @include('subject.dynamic_table')
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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
                url: "{{route('above_order.subject')}}",
                type: "GET",
                data: {
                    "order_no": order_no,
                    "standard_id":"{{$standard_id}}"
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
                url: "{{route('below_order.subject')}}",
                type: "GET",
                data: {
                    "order_no": order_no,
                    "standard_id":"{{$standard_id}}"
                },
                success: function(html) {
                    $('.dyamictable').empty();
                    $('.dyamictable').html(html.html);
                    $(".datatable-init").DataTable();                  
                }
        });    
    });

    $( document ).ready(function() {
        var check_board = <?PHP echo json_encode($isset); ?>;
        if(check_board == 1){
            var boardid = <?PHP echo (!empty($subject_details->board_id) ? json_encode($subject_details->board_id) : '""'); ?>;
            var mediumid = <?PHP echo (!empty($subject_details->medium_id) ? json_encode($subject_details->medium_id) : '""'); ?>;
            var standardid = <?PHP echo (!empty($subject_details->standard_id) ? json_encode($subject_details->standard_id) : '""'); ?>;            
            $('.board_id').val(boardid);
            var board_id = boardid;
            var medium_id = mediumid;
            var standard_id = standardid;            
            getMediumEdit(board_id,medium_id);
            getStandardEdit(board_id,medium_id,standard_id);            
        }   

    });
    

$(document).ready(function(){
    $('#thumbnail_preview').css('display','none');

    $('#subject_name').autocomplete({
        serviceUrl: '{{route("load_autocomplete.subject")}}',
        onSelect: function (suggestion) {

                $(this).val(suggestion.data);
        }
    });
    $('#sub_title').autocomplete({
        serviceUrl: '{{route("load_autocomplete.subject_sub_title")}}',
        onSelect: function (suggestion) {
            $(this).val(suggestion.data);
        }
    });

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

$(document).ready(function () {
    
    $('#subject_form').validate({
         rules: {
                board_id:"required",
                medium_id:"required",
                standard_id:"required",
                subject_name:"required",
                sub_title:"required"

            },
        //For custom messages
        messages: {
                board_id:"Please selete board.",
                medium_id:"Please selete medium.",
                standard_id:"Please selete standard.",                
                subject_name:"Please enter subject name.",
                sub_title:"Please enter sub title."
        },
        submitHandler: function(form) {
            var formData = new FormData($("#subject_form")[0]);

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
                    $('#semester_id').val([]);                    
                    $('#subject_name').val('');
                    $('#sub_title').val('');
                    $('#thumbnail').val();
                    $('#hidden_thumbnail').val('');
                    $('#hidden_id').val('0');
                    $('#thumbnail_preview').css('display','none');
                    $('.thumbnailchk').prop("checked",false);
                    $("#thumbnail").attr('type', 'text');
                    $('#thumbnail_file_type').val('Drive');
                    $('#thumbnail').val('');
                    
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
        url: "{{ route('subject.edit') }}",
        type: 'GET',
        data: {
              'id':id
        },
        success: function(result) {
            $('#board_id').val(result.subject_details.board_id);
            var board_id = $('#board_id').val();
            var medium_id = result.subject_details.medium_id;
            var standard_id = result.subject_details.standard_id;            
            getMediumEdit(board_id,medium_id);
            getStandardEdit(board_id,medium_id,standard_id);
            $('#subject_name').val(result.subject_details.subject_name);
            $('#sub_title').val(result.subject_details.sub_title);
            //alert(result.subject_details.thumbnail_file_type);
            if(result.subject_details.thumbnail_file_type == 'Drive'){

                $('.thumbnailchk').prop("checked",false);
                $('#hidden_thumbnail').val(result.subject_details.thumbnail);
                $('#thumbnail').val(result.subject_details.thumbnail);
                $('#thumbnail_preview').css('display','none');
                $("#thumbnail").attr('type', 'text');
                $('#thumbnail_file_type').val('Drive');
        
            }
            else{
                $('.thumbnailchk').prop("checked",true);
                $('#hidden_thumbnail').val(result.subject_details.thumbnail);
                $('#thumbnail_preview').css('display','block');
                $("#thumbnail").attr('type', 'file');
                $('#thumbnail_file_type').val('Server');                
            }
            //$('#hidden_thumbnail').val(result.subject_details.thumbnail);
            //$('#thumbnail_preview').css('display','block');
            var url_path = "{{ env('APP_URL') }}"+"/upload/subject/thumbnail/"+result.subject_details.thumbnail;
            $('#thumbnail_preview').attr('src', url_path);
            $('#hidden_id').val(result.subject_details.id);            
        }            
    });
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



$(document).on('click','.distroy', function() {
    var id = $(this).attr('data-id');
    var standard_id = $('#standard_id').val();
    bootbox.confirm({
        message: "Are you sure to delete this subject ?",
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
                    url: "{{ route('subject.distroy') }}",
                    type: "GET",
                    data: {
                        'id':id,
                        'standard_id':standard_id,
                    },
                    success: function(data) {
                        confirm("Subject Deleted Successfully.");
                            
                        $('#subject_name').val('');
                        $('#sub_title').val('');     
                        $('#thumbnail').val('');
                        $('#hidden_thumbnail').val('');
                        $('#thumbnail_preview').css('display','none');

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
        url: "{{ route('subject.distroy') }}",
        type: "GET",
        data: {
            'id':id,
            'status':status,
        },
        success: function(data) {
            confirm("Subject Status Change Successfully.");
            
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