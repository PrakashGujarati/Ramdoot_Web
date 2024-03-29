@extends('layouts.app')
@section('title','Add Question')
@section('css')
@endsection

@section('content')

<div class="nk-block nk-block-lg">
    <div class="row g-gs">
        <div class="col-lg-12">
            <div class="card h-100">
                <div class="card-inner">
                    <div class="card-head">
                        <h5 class="card-title">Add Question</h5>
                    </div>
                    <form action="{{ route('question.store') }}" method="POST" enctype='multipart/form-data' id="question_form">
                    @csrf
                        
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
                        
                        
                        <div class="row mb-3">
                            <div class="form-group col-lg-12">
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
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label class="form-label"><input type="radio" value="A" name="answer" class="answer"> Option-A</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="option_a" name="option_a" value="{{ old('option_a') }}">
                                    @error('option_a')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="form-label"><input type="radio" value="B" name="answer" class="answer"> Option-B</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="option_b" name="option_b" value="{{ old('option_b') }}">
                                    @error('option_b')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="form-label"><input type="radio" value="C" name="answer" class="answer"> Option-C</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="option_c" name="option_c" value="{{ old('option_c') }}">
                                    @error('option_c')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="form-label"><input type="radio" value="D" name="answer" class="answer"> Option-D</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="option_d" name="option_d" value="{{ old('option_d') }}">
                                    @error('option_d')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        
                        <div class="row">                           
                            <div class="form-group col-lg-4">
                                <label class="form-label">Per Question Marks</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="per_question_marks" name="per_question_marks" value="{{ old('per_question_marks') }}">
                                    @error('per_question_marks')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-lg-4">
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

                            <div class="form-group col-lg-4">
                                <label class="form-label">Note</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="note" name="note" value="{{ old('note') }}">
                                    @error('note')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            

                            

                        </div>

                        <!-- <div class="newPlus">
                            
                        </div>

                        <div class="row">
                        <div class="col-lg-12 text-right">
                            <button type="button" class="btn btn-success mt-1 add_row"><i class="icon ni ni-plus"></i></button>
                        </div></div> -->

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-lg btn-primary">Submit</button>
                            <a type="button" href="{{ route('question.index') }}" class="btn btn-lg btn-danger text-light">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
            
    </div>
</div><!-- .nk-block -->
<br/>
<div class="dyamictable">
    @include('question.dynamic_table')
</div>

@endsection

@section('scripts')

<script type="text/javascript">


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
    
    $('#question_form').validate({
         rules: {
                board_id:"required",
                medium_id:"required",
                standard_id:"required",
                semester_id:"required",
                subject_id:"required",
                unit_id:"required",
                question:"required",
                answer:"required",
                option_a:"required",
                option_b:"required",
                option_c:"required",
                option_d:"required",
                answer:"required",
                per_question_marks:"required",
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
            option_a:"Please enter option A.",
            option_b:"Please enter option B.",
            option_c:"Please enter option C.",
            option_d:"Please enter option D.",
            answer:"Please enter Answer",
            per_question_marks:"Please enter per question mark.",
        },
        submitHandler: function(form) {
            var formData = new FormData($("#question_form")[0]);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
                },
                url: form.action,
                type: form.method,
                data: formData,//$(form).serialize(),
                mimeType: "multipart/form-data",
                contentType: false,
                processData: false,
                dataType: 'html',
                success: function(data) {
                    confirm("Question Added Successfully.");
                    $('#question').val('');
                    $('#answer').val('');
                    $('#option_a').val('');
                    $('#option_b').val('');
                    $('#option_c').val('');
                    $('#option_d').val('');
                    $('#answer').val('');
                    $('#per_question_marks').val('');
                    $('#note').val('');
                    $('#level').val('');
                    
                    
                    $('.dyamictable').empty();
                    $('.dyamictable').html(data);
                }            
            });
        }
    });
    
});
    
    

// var max_fields      = 50;
// var wrapper         = $(".newPlus");
// var add_button      = $(".add_row");

// var x = 1;
// $(add_button).click(function(e){
//     e.preventDefault();
//     if(x < max_fields){
//         x++;
// $(wrapper).append('<div class="newMinus"><div class="row mb-3"><div class="col-lg-12 text-right"><button type="button" class="btn btn-danger mt-1 remove_field"><i class="icon ni ni-minus"></i></button></div><div class="form-group col-lg-12"><label class="form-label">Question</label><div class="form-control-wrap"><input type="text" class="form-control" id="question" name="question[]" value=""></div></div></div><div class="row"> <div class="form-group col-lg-3"><label class="form-label">Option-A</label><div class="form-control-wrap"><input type="text" class="form-control" id="option_a" name="option_a[]" value=""></div></div><div class="form-group col-lg-3"><label class="form-label">Option-B</label><div class="form-control-wrap"><input type="text" class="form-control" id="option_b" name="option_b[]" value=""></div></div><div class="form-group col-lg-3"><label class="form-label">Option-C</label><div class="form-control-wrap"><input type="text" class="form-control" id="option_c" name="option_c[]" value=""></div></div><div class="form-group col-lg-3"><label class="form-label">Option-D</label><div class="form-control-wrap"><input type="text" class="form-control" id="option_d" name="option_d[]" value=""></div></div></div><div class="row mb-3"><div class="form-group col-lg-12"><label class="form-label">Answer</label><div class="form-control-wrap"><input type="text" class="form-control" id="answer" name="answer[]" value=""></div></div></div><div class="row"><div class="form-group col-lg-7"><label class="form-label">Note</label><div class="form-control-wrap"><input type="text" class="form-control" id="note" name="note[]" value=""></div></div><div class="form-group col-lg-2"><label class="form-label">Per Question Marks</label><div class="form-control-wrap"><input type="text" class="form-control" id="per_question_marks" name="per_question_marks[]" value=""></div></div><div class="form-group col-lg-3"><label class="form-label">Level</label><div class="form-control-wrap"><select class="form-control" id="level" name="level[]"><option value="" selected="" disabled="">-Select Level-</option><option value="Easy">Easy</option><option value="Normal">Normal</option><option value="Moderate">Moderate</option><option value="Hard">Hard</option><option value="Expert">Expert</option></select></div></div></div></div>');     
//     }
// });


// $(wrapper).on("click",".remove_field", function(e){
//     e.preventDefault();
//     $(this).closest(".newMinus").remove();
//     x--;
// })

// $(wrapper).on("click",".remove_field", function(e){
//     e.preventDefault(); 
//     $(this).closest(".show").remove();
//     x--;
// })

// $(document).on("click",".remove_fields", function(e){
//     //alert('fdf');
//     e.preventDefault();
//     $(this).closest(".slab").remove();
// })

// $(document).on("click",".remove_fieldedit", function(e){
//     //alert('fdf');
//     e.preventDefault();
//     $(this).closest(".editslab").remove();
// })

</script>

@endsection