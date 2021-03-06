@extends('layouts.app')
@section('title','Add Semester')
@section('css')
@endsection

@section('content')

<div class="nk-block nk-block-lg">
    <div class="row g-gs">
        <div class="col-lg-12">
            <div class="card h-100">
                <div class="card-inner">
                    <div class="card-head">
                        <h5 class="card-title">Add Semester</h5>
                    </div>
                    <form action="{{ route('semester.store') }}" method="POST" enctype='multipart/form-data' id="semester_form">
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
                                        {{--@foreach($standards as $standards_data)
                                        <option value="{{ $standards_data->id }}" @if(old('standard_id') == $standards_data->id) selected="" @endif>{{ $standards_data->standard }}</option>
                                        @endforeach--}}
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
                                        {{--@foreach($subjects as $subjects_data)
                                        <option value="{{ $subjects_data->id }}" @if(old('subject_id') == $subjects_data->id) selected="" @endif>{{ $subjects_data->subject }}</option>
                                        @endforeach--}}
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
                                <input type="text" class="form-control" id="semester" name="semester" value="{{ old('semester') }}">
                                @error('semester')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group col-lg-4">
                                <label class="form-label">Subtitle</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="sub_title" name="sub_title" value="">
                                    @error('sub_title')
                                        <span class="text-danger" id="error_sub_title" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-primary">Submit</button>
                            <a type="button" href="{{ route('semester.index') }}" class="btn btn-lg btn-danger text-light">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
            
    </div>
</div><!-- .nk-block -->

<br/>
<div class="dyamictable">
    @include('semester.dynamic_table')
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
                url: "{{route('above_order.semester')}}",
                type: "GET",
                data: {
                    "order_no": order_no,
                    "standard_id":"{{(!empty($subject_details->id) ? $subject_details->id : '""')}}"
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
                url: "{{route('below_order.semester')}}",
                type: "GET",
                data: {
                    "order_no": order_no,
                    "standard_id":"{{(!empty($subject_details->id) ? $subject_details->id : '""')}}"
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
            var subjectdid = <?PHP echo (!empty($subject_details->id) ? json_encode($subject_details->id) : '""'); ?>;
            var subjectdid = <?PHP echo (!empty($subject_details->id) ? json_encode($subject_details->id) : '""'); ?>;

            $('.board_id').val(boardid);
            var board_id = boardid;
            var medium_id = mediumid;
            var standard_id = standardid;
            var subjectd_id = subjectdid;
            getMediumEdit(board_id,medium_id);            
            getStandardEdit(board_id,medium_id,standard_id);
            getSubjectEdit(board_id,medium_id,standard_id,subjectd_id);
        }   

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
            $('#standard_id').html('');
            $('#standard_id').html(result.html);
        } 
    });
}

$(document).on('change','.standard_id',function(){
    var board_id = $('.board_id').val();
    var medium_id = $('.medium_id').val();
    var standard_id = $('.standard_id').val();
    getSubject(board_id,medium_id,standard_id);
});

function getSubject(board_id,medium_id,standard_id){
    $.ajax({
        type: "GET",
        url: "{{route('get.subject')}}",
        data: {
            "board_id":board_id,
            "medium_id":medium_id,
            "standard_id":standard_id,
        },
        success: function(result) {
            $('#subject_id').html('');
            $('#subject_id').html(result.html);
        } 
    });
}

$(document).ready(function () {

    $('#semester').autocomplete({
            serviceUrl: '{{route("load_autocomplete.semester")}}',
            onSelect: function (suggestion) {

                    $(this).val(suggestion.data);

                  //loadCustData(suggestion.data);
            }
        });
    
    $('#semester_form').validate({
         rules: {
                board_id:"required",
                medium_id:"required",
                standard_id:"required",
                semester:"required",
            },
        //For custom messages
        messages: {
                board_id:"Please selete board.",
                medium_id:"Please selete medium.",
                standard_id:"Please selete standard.",
                semester:"Please enter semester.",
        },
        submitHandler: function(form) {
            var formData = new FormData($("#semester_form")[0]);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
                },
                url: form.action,
                type: form.method,
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    confirm(data.message);
                    $('#semester').val('');
                    $('#hidden_id').val('0');
                    $('#sub_title').val('');
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
        url: "{{ route('semester.edit') }}",
        type: 'GET',
        data: {
              'id':id
        },
        success: function(result) {
            console.log(result);
            $('#board_id').val(result.board_id);
            $('#medium_id').val(result.medium_id);
            $('#standard_id').val(result.standard_id);
            $('#subject_id').val(result.subject_id);
            $('#semester').val(result.semester);
            $('#sub_title').val(result.sub_title);
            $('#hidden_id').val(result.id);           
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


$(document).on('click','.distroy', function() {
    var id = $(this).attr('data-id');
    var standard_id = $('#standard_id').val();
    bootbox.confirm({
        message: "Are you sure to delete this semester ?",
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
                    url: "{{ route('semester.distroy') }}",
                    type: "GET",
                    data: {
                        'id':id,
                        'standard_id':standard_id,
                    },
                    success: function(data) {
                        confirm("Semester Deleted Successfully.");
                        
                        $('.dyamictable').empty();
                        $('.dyamictable').html(data);
                        $(".datatable-init").DataTable();
                    }            
                });
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
        url: "{{ route('semester.distroy') }}",
        type: "GET",
        data: {
            'id':id,
            'status':status,
        },
        success: function(data) {
            confirm("Semester Status Change Successfully.");
            
            $('.dyamictable').empty();
            $('.dyamictable').html(data);
            $(".datatable-init").DataTable();
        }            
    });

});

</script>


@endsection