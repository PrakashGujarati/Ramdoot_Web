@extends('layouts.app')
@section('title','Solutions')
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
            		<h4 class="nk-block-title">Solution List</h4>
            	</div>
            	<div class="col-lg-2 text-right">
            		<a href="{{ route('solution.create') }}" class="btn btn-primary text-light">Add Solution</a>
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
                        <!-- <th>Unit</th>
                        <th>Question</th>
                        <th>Answer</th>
                        <th>Marks</th>
                        <th>Label</th>
                        <th>Image</th> -->
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                	@if(count($solution_details) > 0)
                	@foreach($solution_details as $data)
                    <tr>
                        <td>{{ isset($data->board->name) ? $data->board->name:'' }}</td>
                        <td>{{ isset($data->medium->medium_name) ? $data->medium->medium_name:'' }}</td>
                        <td>{{ isset($data->standard->standard) ? $data->standard->standard:'' }}</td>
                        <td>{{ isset($data->semester->semester) ? $data->semester->semester:'' }}</td>
                        <td>{{ isset($data->subject->subject_name) ? $data->subject->subject_name:'' }}</td>
                        {{--<td>{{ isset($data->unit->title) ? $data->unit->title:'' }}</td>
                        <td>{{ $data->question }}</td>
                        <td>{{ $data->answer }}</td>
                        <td>{{ $data->marks }}</td>
                        <td>{{ $data->label }}</td>
                        <td>
                            @if($data->image)
                            <img src="{{ asset('upload/solution/thumbnail/'.$data->image) }}" class="thumbnail" height="50" width="50">
                            @endif
                        </td>
                        <td>
                        	<a href="{{ route('solution.edit',$data->id) }}" class="mr-1"><span class="nk-menu-icon success"><em class="icon ni ni-edit"></em></span></a>
                        	<a href="javascript:;" data-url="{{ route('solution.distroy',$data->id) }}" class="distroy"><span class="nk-menu-icon danger"><em class="icon ni ni-trash"></em></span></a>
                        </td>--}}
                        <td><a href="javascript:;" data-url="" class=""><span class="nk-menu-icon text-primary"><em class="fa fa-plus pr-1"></em>Add</span></a></td>
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
	$(document).on('click','.distroy', function() {
	    let del_url = $(this).attr('data-url');
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
	                location.replace(del_url);
	            }
	        }
	    });
	})
</script>

@endsection