@extends('layouts.app')
@section('title','Exam Questions')
@section('css')
<style type="text/css">
    .ni-eye{
        font-size: 16px;
    }
</style>
@endsection

@section('content')

@include('exam_question.dynamic_question_list_form')

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
        	<div class="row">
        		<div class="col-lg-9">
            		<h4 class="nk-block-title">Exam Question List</h4>
            	</div>
            	<div class="col-lg-3 text-right">
            		<a href="{{ route('exam_question.create') }}" class="btn btn-primary text-light">Add Exam Question</a>
            	</div>
            </div>
        </div>
    </div>
    <div class="card card-preview">
        <div class="card-inner">
            <table class="datatable-init table">
                <thead>
                    <tr>
                        <th>Exam</th>
                        <th>Question</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                	@if(count($examquestion_details) > 0)
                	@foreach($examquestion_details as $data)
                    <tr>
                        <td>{{ isset($data->exam->name) ? $data->exam->name:'' }}</td>
                        <td><a href="javascript:;" title="View Questions" data-exam-id="{{ $data->exam_id }}"
                            class="question_view"><i class="icon ni ni-eye"></i>&nbsp;View</a></td>
                        {{-- <td>{{ isset($data->question->question) ? $data->question->question:'' }}</td>  --}}
                        <td>
                            @canany(['ExamQuestion-edit'])
                        	<a href="{{ route('exam_question.edit',$data->exam->id) }}"><span class="nk-menu-icon success"><em class="icon ni ni-edit"></em></span></a>
                            @endcanany
                            @canany(['ExamQuestion-edit'])
                        	<a href="javascript:;" data-url="{{ route('exam_question.distroy',$data->exam->id) }}" class="distroy"><span class="nk-menu-icon danger"><em class="icon ni ni-trash"></em></span></a>
                            @endcanany
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

<script type="text/javascript">
	$('.distroy').on('click', function() {
	    let del_url = $(this).attr('data-url');
	    bootbox.confirm({
	        message: "Are you sure to delete this exam question ?",
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

    $(document).on('click','.question_view', function() {
        var exam_id = $(this).attr('data-exam-id');
        $.ajax({
            type: "GET",
            url: "{{route('view.exam.list')}}",
            data: {
                "exam_id":exam_id
            },
            success: function(result) {
                $('#question_list_model_data').html(result.html);
                $('#question_list_view').modal({show:true});
               // $('#hidden_srno').val(result.srno);
            } 
        });
    });
    
</script>

@endsection