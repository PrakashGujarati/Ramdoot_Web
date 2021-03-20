@extends('layouts.app')
@section('title','Question Type')
@section('css')
@endsection

@section('content')
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
        		<div class="col-lg-10">
            		<h4 class="nk-block-title">Question Type</h4>
            	</div>
            	<!-- <div class="col-lg-2 text-right">
            		<a href="{{ route('slider.create') }}" class="btn btn-primary text-light">Add Slider</a>
            	</div> -->
            </div>
        </div>
    </div>

    <div class="card card-preview">
        <div class="card-inner">
            <form action="{{ route('question_type.store') }}" method="POST" enctype='multipart/form-data' id="question_type_form">
            <input type="hidden" name="hidden_id" id="hidden_id" value="0"> 
            @csrf
            <div class="row">
                <div class="col-lg-2">
                    <label>Question Type</label>
                </div>
                <div class="col-lg-4">
                    <input type="text" name="question_type" id="question_type" class="form-control question_type">
                </div>
                <div class="col-lg-6 text-right">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
            </form>
        </div>
    </div>
    
    <br/>
    <div class="dyamictable">
        @include('question_type.dynamic_table')
    </div>

</div>

@endsection

@section('scripts')

<script type="text/javascript">
	$(document).on('click','.distroy', function() {
	    let del_url = $(this).attr('data-url');
        var hidden_id = $(this).attr('data-hidden-id');
	    bootbox.confirm({
	        message: "Are you sure to delete this Question type ?",
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
                        url: del_url,
                        type: "GET",
                        data: {
                            'hidden_id':hidden_id,
                        },
                        success: function(data) {
                            confirm("Question Type Deleted Successfully.");
                            
                            $('.dyamictable').empty();
                            $('.dyamictable').html(data);
                        }            
                    });
	            }
	        }
	    });
	});

    $(document).on('click','.edit_question_type', function() {
        var hidden_id = $(this).attr('data-hidden-id');  
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
            },
            url: "{{ route('question_type.edit') }}",
            type: "GET",
            data: {
                'hidden_id':hidden_id,
            },
            success: function(data) {
                $('#question_type').val(data.question_type);
                $('#hidden_id').val(data.id);
            }            
        });

    });

    

    $(document).ready(function () {
    
    $('#question_type_form').validate({
         rules: {
                question_type:"required"
            },
        //For custom messages
        messages: {

            question_type:"Please select question type."
        },
        submitHandler: function(form) {
            var formData = new FormData($("#question_type_form")[0]);

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
                    confirm("Question Type Added Successfully.");
                    $('#question_type').val('');
                    
                    $('.dyamictable').empty();
                    $('.dyamictable').html(data);
                    $('#hidden_id').val(0);
                }            
            });
        }
    });
    
});

</script>

@endsection