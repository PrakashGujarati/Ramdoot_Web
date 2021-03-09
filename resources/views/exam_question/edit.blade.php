@extends('layouts.app')
@section('title','Edit MCQ')
@section('css')
@endsection

@section('content')

@include('exam_question.dynamic_question_form')

<div class="nk-block nk-block-lg">
    <div class="row g-gs">
        <div class="col-lg-12">
            <div class="card h-100">
                <div class="card-inner">
                    <div class="card-head">
                        <h5 class="card-title">Edit Exam Question</h5>
                    </div>
                    <form action="{{ route('exam_question.update',$getexam_detail->id) }}" method="POST" enctype='multipart/form-data'>
                    @csrf
                        
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label class="form-label">Board</label>
                                <div class="form-control-wrap">
                                    <select name="board_id" class="form-control board_id" id="board_id">
                                        <option>--Select Board--</option>
                                        @foreach($boards as $boards_data)
                                        <option value="{{ $boards_data->id }}" @if($getexam_detail->board_id == $boards_data->id) selected="" @endif>{{ $boards_data->name." - ".$boards_data->medium }}</option>
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
                            <div class="form-group col-lg-6">
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
                            

                            <div class="form-group col-lg-6">
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
                        </div>

                        
                        <div class="row">
                            <div class="form-group col-lg-6">
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

                            <div class="form-group col-lg-6">
                                <label class="form-label">Exam</label>
                                <div class="form-control-wrap">
                                    <select name="exam_id" class="form-control exam_id" id="exam_id">
                                        <option>--Select Exam--</option>
                                    </select>
                                    @error('exam_id')
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
                                <input type="text" name="question_id" class="form-control" id="question_id" value="{{ $getexam_detail->total_question }}">
                                @error('question_id')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="dynamic_exam_detail displaynone">
                            @include('exam_question.dynamic_exam_detail')
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-primary">Submit</button>
                            <a type="button" href="{{ route('exam_question.index') }}" class="btn btn-lg btn-danger text-light">Cancel</a>
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
        var standard_id = "{{ $getexam_detail->standard_id }}";
        var semester_id = "{{ $getexam_detail->semester_id }}";
        var subject_id = "{{ $getexam_detail->subject_id }}";
        var unit_id = "{{ $getexam_detail->unit_id }}";
        var exam_id = "{{ $getexam_detail->id }}";

        getStandardEdit(board_id,standard_id);
        getSemesterEdit(board_id,standard_id,semester_id);
        getSubjectEdit(standard_id,semester_id,subject_id);
        getUnitEdit(standard_id,semester_id,subject_id,unit_id);
        getExamEdit(standard_id,semester_id,subject_id,unit_id,exam_id);
    });

    $(document).on('change','.board_id',function(){
        var board_id = $('.board_id').val();
        getStandard(board_id);
    });

    function getStandardEdit(board_id,standard_id){
        
        $.ajax({
            type: "GET",
            url: "{{route('get.standard')}}",
            data: {
                "board_id":board_id,
                "standard_id":standard_id,
            },
            success: function(result) {
                $('.standard_id').html('');
                $('.standard_id').html(result.html);
            } 
        });
    }

    function getStandard(board_id){
        $.ajax({
            type: "GET",
            url: "{{route('get.standard')}}",
            data: {
                "board_id":board_id,
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
        getSemester(standard_id,board_id);
    });

    function getSemesterEdit(board_id,standard_id,semester_id){
        
        $.ajax({
            type: "GET",
            url: "{{route('get.semester')}}",
            data: {
                "board_id":board_id,
                "standard_id":standard_id,
                "semester_id":semester_id,
            },
            success: function(result) {
                $('.semester_id').html('');
                $('.semester_id').html(result.html);
            } 
        });
    }

    function getSemester(standard_id,board_id){
        $.ajax({
            type: "GET",
            url: "{{route('get.semester')}}",
            data: {
                "board_id":board_id,
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
        getSubject(standard_id,semester_id);
    });

    function getSubjectEdit(standard_id,semester_id,subject_id){
        $.ajax({
            type: "GET",
            url: "{{route('get.subject')}}",
            data: {
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


    function getSubject(standard_id,semester_id){
        $.ajax({
            type: "GET",
            url: "{{route('get.subject')}}",
            data: {
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
        var standard_id = $('.standard_id').val();
        var semester_id = $('.semester_id').val();
        var subject_id = $('.subject_id').val();
        getUnit(standard_id,semester_id,subject_id);
    });

    function getUnitEdit(standard_id,semester_id,subject_id,unit_id){
        
        $.ajax({
            type: "GET",
            url: "{{route('get.unit')}}",
            data: {
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


    function getUnit(standard_id,semester_id,subject_id){
        $.ajax({
            type: "GET",
            url: "{{route('get.unit')}}",
            data: {
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

    $(document).on('change','.unit_id',function(){
        var standard_id = $('.standard_id').val();
        var semester_id = $('.semester_id').val();
        var subject_id = $('.subject_id').val();
        var subject_id = $('.subject_id').val();
        var unit_id = $('.unit_id').val();
        getExam(standard_id,semester_id,subject_id,unit_id);
    });

    function getExamEdit(standard_id,semester_id,subject_id,unit_id,exam_id){
        
        $.ajax({
            type: "GET",
            url: "{{route('get.exam')}}",
            data: {
                "standard_id":standard_id,
                "semester_id":semester_id,
                "subject_id":subject_id,
                "unit_id":unit_id,
                "exam_id":exam_id,
            },
            success: function(result) {
                $('.exam_id').html('');
                $('.exam_id').html(result.html);
            } 
        });
    }

    function getExam(standard_id,semester_id,subject_id,unit_id){
        $.ajax({
            type: "GET",
            url: "{{route('get.exam')}}",
            data: {
                "standard_id":standard_id,
                "semester_id":semester_id,
                "subject_id":subject_id,
                "unit_id":unit_id,
            },
            success: function(result) {
                $('.exam_id').html('');
                $('.exam_id').html(result.html);
            } 
        });
    }

    $(document).on('change','.exam_id',function(){
        var exam_id = $('.exam_id').val();
                
        $.ajax({
            type: "GET",
            url: "{{route('get.exam.detail')}}",
            data: {
                "exam_id":exam_id,
            },
            success: function(result) {

                $('.dynamic_exam_detail').removeClass('displaynone').addClass('displayblock');
                $('.dynamic_exam_detail').html(result.html);
                $('#question_id').val(result.getexam_detail.total_question);
                $('.add_question_btn').attr('disabled',true).css('cursor','not-allowed');
                //var exam_id = $('.exam_id').val();
            } 
        });
    });

    $(document).on('click','.edit_question',function(){
        var exam_id = $('.exam_id').val();    
        var sr_no = $(this).data('srno');

        $.ajax({
            type: "GET",
            url: "{{route('get.question.view')}}",
            data: {
                "exam_id":exam_id,
                "sr_no":sr_no,
            },
            success: function(result) {
                $('#question_model_data').html(result.html);
                $('#question_view').modal({show:true});
                $('#hidden_srno').val(result.srno);
            } 
        });
    });

    $(document).on('change','.chk_question',function(){
        var getsid = $(this).attr('id');
        var id=$(this).data('id');
        var checkbox_limit = $('.checkbox_limit').val();

        var numberOfChecked = $('input:checkbox:checked').length;
        

        if ($("#"+getsid).prop('checked') == true)
        {
            if(numberOfChecked <= checkbox_limit){
                $("#"+getsid).prop('checked',true);
            }
            else{
                if(checkbox_limit == 1){
                    $(".chk_question").prop('checked',false);
                    $("#"+getsid).prop('checked',true);
                }
                else{
                    $("#"+getsid).prop('checked',false);
                    //$(".chk_question").prop('checked',false);
                }    
            }
            
        }
    });

    $(document).on('click','.select_question',function(){
        //var hidden_question_id = $('.hidden_question_id').val();
        var hidden_question_id = $('.hidden_question_id').map(function() {
            return $(this).val();
        }).get();

        var select_question_id = $('.chk_question').map(function() {
            if($(this).prop('checked') == true){
                return $(this).data('id');    
            }
        }).get();

        var srno = $('#hidden_srno').val();
        var exam_id = $('.exam_id').val();

        $.ajax({
            type: "GET",
            url: "{{route('get.question.change')}}",
            data: {
                "hidden_question_id":hidden_question_id,
                "select_question_id":select_question_id,
                "srno":srno,
                "exam_id":exam_id,
            },
            success: function(result) {
                $('#question_view').modal('hide');
                $('.dynamic_exam_detail').html('');
                $('.dynamic_exam_detail').removeClass('displaynone').addClass('displayblock');
                $('.dynamic_exam_detail').html(result.html);
                $('#question_id').val(result.getexam_detail.total_question);
                //$('#question_model_data').html(result.html);
               // $('#question_view').modal({show:true});
                //$('#hidden_srno').val(result.srno);
            } 
        });
    });

    $(document).on('click','.clear_btn',function(){

        var exam_id = $('.exam_id').val();

        $.ajax({
            type: "GET",
            url: "{{route('question.clear')}}",
            data: {
                "exam_id":exam_id,
            },
            success: function(result) {
                $('.dynamic_exam_detail').html('');
                $('.dynamic_exam_detail').removeClass('displaynone').addClass('displayblock');
                $('.dynamic_exam_detail').html(result.html);
                $('.add_question_btn').attr('disabled',false).css('cursor','pointer');
                $('#question_id').val(result.getexam_detail.total_question);
                //$('#question_model_data').html(result.html);
               // $('#question_view').modal({show:true});
                //$('#hidden_srno').val(result.srno);
            } 
        });

    });
    
    $(document).on('click','.add_question_btn',function(){

        var exam_id = $('.exam_id').val();    
        var sr_no = 0;

        $.ajax({
            type: "GET",
            url: "{{route('get.question.view')}}",
            data: {
                "exam_id":exam_id,
                "sr_no":sr_no,
            },
            success: function(result) {
                $('#question_model_data').html(result.html);
                $('#question_view').modal({show:true});
               // $('#hidden_srno').val(result.srno);
            } 
        });

        // var checkbox_limit = $('#question_id').val();

        // var select_question_id = $('.chk_question').map(function() {
        //     if($(this).prop('checked') == true){
        //         return $(this).data('id');    
        //     }
        // }).get();
        
        // if(checkbox_limit == 1){
        //     $(".chk_question").prop('checked',false);
        //     $("#"+getsid).prop('checked',true);
        // }else if(checkbox_limit > 1){
        //     $(".chk_question").prop('checked',false);
        // }
        // else{
        //     $(".chk_question").prop('checked',false);
        // }
    });

</script>

@endsection