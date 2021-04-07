@extends('layouts.app')
@section('title','Add Solution')
@section('css')
@endsection

@section('content')

<div class="nk-block nk-block-lg">
    <div class="row g-gs">
        <div class="col-lg-12">
            <div class="card h-100">
                <div class="card-inner">
                    <div class="card-head">
                        <h5 class="card-title">Add Solution</h5>
                    </div>
                    <form action="{{ route('solution.store') }}" method="POST" enctype='multipart/form-data' id="solution_form">
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
                        
                        
                            
                        

                        
                        <div class="form-group">
                            <label class="form-label">Question</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="question" name="question" value="{{ old('question') }}">
                                @error('question')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Answer</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="answer" name="answer" value="{{ old('answer') }}">
                                @error('answer')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        


                        <div class="row">
                            <div class="form-group col-lg-3">
                                <label class="form-label">Marks</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="marks" name="marks" value="{{ old('marks') }}">
                                    @error('marks')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-lg-3">
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

                            <div class="form-group col-lg-3">
                                <label class="form-label">Question Type</label>
                                <div class="form-control-wrap">
                                    <select class="form-control" id="question_type" name="question_type">
                                        <option value="">--Select Question Type--</option>
                                        @foreach($question_type_details as $question_type)
                                            <option value="{{ $question_type->id }}">{{ $question_type->question_type }}</option>
                                        @endforeach
                                    </select>
                                    @error('question_type')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-lg-3">
                                <label class="form-label">Level</label>
                                <div class="form-control-wrap">
                                    <select class="form-control" id="level" name="level">
                                        <option value='' selected="" disabled="">-Select Level-</option>
                                        <option value="Easy">Easy</option>
                                        <option value="Normal">Normal</option>
                                        <option value="Moderate">Moderate</option>
                                        <option value="Hard">Hard</option>
                                        <option value="Expert">Expert</option>
                                    </select>
                                    @error('level')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    
                                </div>
                            </div>    

                        </div>

                        <div class="row mb-4">
                        <div class="form-group col-lg-3">
                            <label class="form-label">Image</label>
                            <div class="form-control-wrap">
                                <input type="file" class="form-control" id="image" name="image" value="">
                                <input type="hidden" id="hidden_image" name="hidden_image" value="">
                                
                                @error('image')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group col-lg-9">
                            <img id="image_preview" src="#" alt="your image" class="thumbnail mt-1" height="100" width="100" />
                        </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-primary">Submit</button>
                            <a type="button" href="{{ route('solution.index') }}" class="btn btn-lg btn-danger text-light">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
            
    </div>
</div><!-- .nk-block -->
<br/>
<div class="dyamictable">
    @include('solution.dynamic_table')
</div>

@endsection

@section('scripts')

<script type="text/javascript">

$(document).on('click','.above_order', function() {
        var order_no=$(this).data('order_no');
        $.ajax({
                url: "{{route('above_order.solution')}}",
                type: "GET",
                data: {
                    "order_no": order_no,
                    "subject_id":"{{(!empty($id) ? $id : '""')}}"
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
                url: "{{route('below_order.solution')}}",
                type: "GET",
                data: {
                    "order_no": order_no,
                    "subject_id":"{{(!empty($id) ? $id : '""')}}"
                },
                success: function(html) {
                    $('.dyamictable').empty();
                    $('.dyamictable').html(html.html);
                    $(".datatable-init").DataTable();                  
                }
        });    
    });

$(document).ready(function(){
    $('#image_preview').css('display','none');
});    

function readThumbnail(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    
    reader.onload = function(e) {
      $('#image_preview').attr('src', e.target.result);
    }
    
    reader.readAsDataURL(input.files[0]); // convert to base64 string
  }
}

$("#image").change(function() {
    $('#image_preview').css('display','block');
  readThumbnail(this);
});

$( document ).ready(function() {
    var check_board = <?PHP echo json_encode($isset); ?>;
    if(check_board == 1){
        var boardid = <?PHP echo (!empty($subjects_details->board_id) ? json_encode($subjects_details->board_id) : '""'); ?>;
        var mediumid = <?PHP echo (!empty($subjects_details->medium_id) ? json_encode($subjects_details->medium_id) : '""'); ?>;
        var standardid = <?PHP echo (!empty($subjects_details->standard_id) ? json_encode($subjects_details->standard_id) : '""'); ?>;
        var semesterid = <?PHP echo (!empty($subjects_details->semester_id) ? json_encode($subjects_details->semester_id) : '""'); ?>;
        var subjectid = <?PHP echo (!empty($subjects_details->id) ? json_encode($subjects_details->id) : '""'); ?>;
            
       $('.board_id').val(boardid);
       var board_id = boardid;
       var medium_id = mediumid;
       var standard_id = standardid;
       var semester_id = semesterid;
       var subject_id = subjectid;
        
        getMediumEdit(board_id,medium_id);
        getStandardEdit(board_id,medium_id,standard_id);
        getSemesterEdit(board_id,medium_id,standard_id,semester_id);
        getSubjectEdit(board_id,medium_id,standard_id,semester_id,subject_id);    
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
    getSemester(standard_id,medium_id,board_id);
});

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
    var standard_id = $('.standard_id').val();
    var semester_id = $('.semester_id').val();
    var medium_id = $('.medium_id').val();
    var board_id = $('.board_id').val();
    getSubject(board_id,medium_id,standard_id,semester_id);
});


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
    
    $('#solution_form').validate({
         rules: {
                board_id:"required",
                medium_id:"required",
                standard_id:"required",
                semester_id:"required",
                subject_id:"required",
                unit_id:"required",
                question:"required",
                answer:"required",
                marks:"required"
            },
        //For custom messages
        messages: {

            board_id:"Please select board.",
            medium_id:"Please select medium.",
            standard_id:"Please select standard.",
            semester_id:"Please select semester.",
            subject_id:"Please select subject.",
            unit_id:"Please select unit.",
            question:"Please enter question.",
            answer:"Please enter answer.",
            marks:"Please enter marks."
        },
        submitHandler: function(form) {
            var formData = new FormData($("#solution_form")[0]);

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
                    $('#image').val('');
                    $('#question').val('');
                    $('#marks').val('');
                    $('#answer').val('');
                    $('#label').val('');
                    $('#question_type').val('');
                    $('#level').val('');

                    $('#image').val('');
                    $('#image_preview').css('display','none');
                    
                    $('.dyamictable').empty();
                    $('.dyamictable').html(data.html);
                    $(".datatable-init").DataTable();

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
        url: "{{ route('solution.edit') }}",
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
            getSemesterEdit(board_id,medium_id,standard_id,semester_id);
            getSubjectEdit(board_id,medium_id,standard_id,semester_id,subject_id);
            getUnitEdit(board_id,medium_id,standard_id,semester_id,subject_id,unit_id);

            $('#question').val(result.question);
            $('#marks').val(result.marks);
            $('#answer').val(result.answer);
            $('#label').val(result.label);
            $('#question_type').val(result.question_type);
            $('#level').val(result.level);

            $('#hidden_image').val(result.image);
            $('#image_preview').css('display','block');
            var image_path = "{{ env('APP_URL') }}"+"/upload/solution/thumbnail/"+result.image;
            $('#image_preview').attr('src', image_path);
            
            $('#hidden_id').val(result.id);
            //$('#thumbnail').val('');
        }            
    });
});

$(document).on('click','.distroy', function() {
    var id = $(this).attr('data-id');
    bootbox.confirm({
        message: "Are you sure to delete this solution ?",
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
                    url: "{{ route('solution.distroy') }}",
                    type: "GET",
                    data: {
                        'id':id,
                    },
                    success: function(data) {
                        confirm("Solution Deleted Successfully.");
                            
                        $('#image').val('');
                        $('#question').val('');
                        $('#marks').val('');
                        $('#answer').val('');
                        $('#label').val('');
                        $('#question_type').val('');
                        $('#level').val('');

                        $('#image').val('');
                        $('#image_preview').css('display','none');

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
        url: "{{ route('solution.distroy') }}",
        type: "GET",
        data: {
            'id':id,
            'status':status,
        },
        success: function(data) {
            confirm("Solution Status Change Successfully.");
            
            $('.dyamictable').empty();
            $('.dyamictable').html(data);
            $(".datatable-init").DataTable();
        }            
    });
});

</script>

@endsection