@extends('layouts.app')
@section('title','Students')
@section('css')
<style type="text/css">
    #exam_student_table{
        border:1px solid #dbdfea!important;
    }
    #exam_student_table tr th{
        border:1px solid #dbdfea!important;
    }
    #exam_student_table tr td{
        border:1px solid #dbdfea;
    }

</style>
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
        		<div class="col-lg-9">
            		<h4 class="nk-block-title">Exam Student List</h4>
            	</div>
            	<div class="col-lg-3 text-right">
            		{{--<a href="#" class="btn btn-primary text-light">Add Student</a>--}}
            	</div>
            </div>
        </div>
    </div>
    <div class="card card-preview">
        <div class="card-inner">
            <div class="row">
                <label class="form-label col-lg-1">Exam : </label>
                <div class="form-group col-lg-4">
                    <div class="form-control-wrap">
                        <select name="exam_id" class="form-control exam_id" id="exam_id">
                            <option value="">--Select Exam--</option>
                            @foreach($exams as $exam_data)
                            <option value="{{ $exam_data->id }}">{{ $exam_data->name }}</option>
                            @endforeach
                        </select>
                        @error('exam_id')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <br/>
            <div class="dynamic_table">
                @include('exam_student.dynamic_table')
            </div>
        </div>
    </div><!-- .card-preview -->
</div>

@endsection

@section('scripts')


<script type="text/javascript">

    // $(document).ready(function() {
    //      $('#exam_student_table').DataTable();
    // });

	// $('.distroy').on('click', function() {
	//     let del_url = $(this).attr('data-url');
	//     bootbox.confirm({
	//         message: "Are you sure to delete this exam student ?",
	//         buttons: {
	//             confirm: {
	//                 label: 'Yes',
	//                 className: 'btn-success'
	//             },
	//             cancel: {
	//                 label: 'No',
	//                 className: 'btn-danger'
	//             }
	//         },
	//         callback: function(result) {
	//             if(result){
	//                 location.replace(del_url);
	//             }
	//         }
	//     });
	// })

    $(document).on('change','.exam_id',function(){
        var exam_id = $(this).val();
        $.ajax({
            type: "GET",
            url: "{{route('get.examStudent')}}",
            data: {
                "exam_id":exam_id,
            },
            success: function(result) {
                //$('.dynamic_table').html('');
                $('.dynamic_table').html(result.html);
                //$('.datatable-init').DataTable();

            } 
        });

    });

    
</script>

@endsection