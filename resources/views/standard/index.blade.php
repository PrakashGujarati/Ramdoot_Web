@extends('layouts.app')
@section('title','Standards')
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
        		<div class="col-lg-9">
            		<h4 class="nk-block-title">Standard / Class List</h4>
            	</div>
            	<div class="col-lg-3 text-right">
            		<a href="{{ route('standard.create') }}" class="btn btn-primary text-light">Add Standard / Class</a>
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
                        <!-- <th>Standard</th>
                        <th>Section</th>
                        <th>Thumbnail</th> -->
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                	@if(count($standard_details) > 0)
                	@foreach($standard_details as $data)
                    <tr>
                        <td>{{ isset($data->board->name) ? $data->board->name:'' }}</td>
                        <td>{{ isset($data->medium->medium_name) ? $data->medium->medium_name:'' }}</td>
                        {{--<td>{{ $data->standard }}</td>
                        <td>{{ $data->section }}</td>
                        <td>
                            @if($data->thumbnail)
                            <img src="{{ asset('upload/standard/thumbnail/'.$data->thumbnail) }}" class="thumbnail" height="50" width="50">
                            @endif
                        </td>

                        <td>
                        	<a href="{{ route('standard.edit',$data->id) }}" class="mr-1"><span class="nk-menu-icon success"><em class="icon ni ni-edit"></em></span></a>
                        	<a href="javascript:;" data-url="{{ route('standard.distroy',$data->id) }}" class="distroy"><span class="nk-menu-icon danger"><em class="icon ni ni-trash"></em></span></a>
                        </td>--}}
                        <td><a href="{{ route('standard.create',$data->medium_id) }}" data-url="" class=""><span class="nk-menu-icon text-primary">Manage</span></a></td>
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
	        message: "Are you sure to delete this standard ?",
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