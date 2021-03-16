@extends('layouts.app')
@section('title','Questions')
@section('css')
@endsection

@section('content')

@include('question.dynamic_import_form')

<div class="nk-block nk-block-lg">
    <div class="nk-block-head">
        <div class="nk-block-head-content">
        	@if(session()->has('success'))
        		<div class="row mb-3">
        			<div class="col-lg-12">
					    <div class="alert alert-success">
					        {{ session()->get('success') }}
					    </div>
					</div>
				</div>
			@endif
            @if(session()->has('error'))
                <div class="row mb-3">
                    <div class="col-lg-12">
                        <div class="alert alert-error">
                            {{ session()->get('error') }}
                        </div>
                    </div>
                </div>
            @endif
        	<div class="row">
        		<div class="col-lg-8">
            		<h4 class="nk-block-title">Question List</h4>
            	</div>
                <div class="col-lg-4 text-right">
                    <a href="{{ route('question.export') }}" class="btn btn-info text-light">Export</a>

                    <a href="javascript:;" class="btn btn-success text-light importbtn">Import</a>
                
            		<a href="{{ route('question.create') }}" class="btn btn-primary text-light">Add Question</a>
            	</div>
            </div>
        </div>
    </div>
    <div class="card card-preview">
        <div class="card-inner">
            <table class="datatable-init table">
                <thead>
                    <tr>
                        <th>Board</th>
                        <th>Medium</th>
                        <th>Standard</th>
                        <th>Semester</th>
                        <th>Subject</th>
                        <th>Unit</th>
                        <th>Question</th>
                        <th>Option A</th>
                        <th>Option B</th>
                        <th>Option C</th>
                        <th>Option D</th>
                        <th>Answer</th>
                        <th>Note</th>
                        <th>Per Question Marks</th>
                        <th>Level</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                	@if(count($question_details) > 0)
                	@foreach($question_details as $data)
                    <tr>
                        <td>{{ isset($data->board->name) ? $data->board->name:'' }}</td>
                        <td>{{ isset($data->medium->medium_name) ? $data->medium->medium_name:'' }}</td>
                        <td>{{ isset($data->standard->standard) ? $data->standard->standard:'' }}</td>
                        <td>{{ isset($data->semester->semester) ? $data->semester->semester:'' }}</td>
                        <td>{{ isset($data->subject->subject_name) ? $data->subject->subject_name:'' }}</td>
                        <td>{{ isset($data->unit->title) ? $data->unit->title:'' }}</td>
                        <td>{{ $data->question }}</td>
                        <td>{{ $data->option_a }}</td>
                        <td>{{ $data->option_b }}</td>
                        <td>{{ $data->option_c }}</td>
                        <td>{{ $data->option_d }}</td>
                        <td>{{ $data->answer }}</td>
                        <td>{{ $data->note }}</td>
                        <td>{{ $data->per_question_marks }}</td>
                        <td>{{ $data->level }}</td>
                        <td>
                        	<a href="{{ route('question.edit',$data->id) }}" class="mr-1"><span class="nk-menu-icon success"><em class="icon ni ni-edit"></em></span></a>
                        	<a href="javascript:;" data-url="{{ route('question.distroy',$data->id) }}" class="distroy"><span class="nk-menu-icon danger"><em class="icon ni ni-trash"></em></span></a>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                    	<td>No Record Found.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div><!-- .card-preview -->
</div>

@endsection

@section('scripts')
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>

<script type="text/javascript">
	$(document).on('click','.distroy', function() {
	    let del_url = $(this).attr('data-url');
	    bootbox.confirm({
	        message: "Are you sure to delete this question ?",
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
	                location.replace(del_url);
	            }
	        }
	    });
	})

    $(document).on('click','.importbtn',function(){

        // var getsid = $(this).attr('id');
        // var id=$(this).data('id');
        var url = "{{ route('import.question.view')}}";

        $.ajax({
            type: "GET",
            url: url,
            success: function(result) {
                $('#import_view').modal({show:true});
               $('#import_model_data').html(result.html);
            } 
        });

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
    
    $('#import_form').validate({
         rules: {
                board_id:"required",
                standard_id:"required",
                semester_id:"required",
                subject_id:"required",
                unit_id:"required",
                file:{
                    required:true,
                    extension: "csv|xls|xlsx",
                },
            },
        //For custom messages
        messages: {
            board_id:"Please select board.",
            standard_id:"Please select standard.",
            semester_id:"Please select semester.",
            subject_id:"Please select subject.",
            unit_id:"Please select unit.",
            file:{
                required:"Please select excel file.",
                extension: "Please select valid excel file.",
            },
        },
    });
    
});


</script>

@endsection