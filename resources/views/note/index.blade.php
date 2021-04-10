@extends('layouts.app')
@section('title','Notes')
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
            		<h4 class="nk-block-title">Note List</h4>
            	</div>
            	<div class="col-lg-2 text-right">
            		<a href="{{ route('note.create') }}" class="btn btn-primary text-light">Add Note</a>
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
                        <th>Title</th>
                        <th>Sub Title</th>
                        <th>URL</th>
                        <th>Thumbnail</th>
                        <th>Pages</th>
                        <th>Label</th>
                        <th>Release Date</th> -->
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                	@if(count($note_details) > 0)
                	@foreach($note_details as $data)
                    <tr>
                        <td>{{ isset($data->board->name) ? $data->board->name:'' }}</td>
                        <td>{{ isset($data->medium->medium_name) ? $data->medium->medium_name:'' }}</td>
                        <td>{{ isset($data->standard->standard) ? $data->standard->standard:'' }}</td>
                        <td>{{ isset($data->semester->semester) ? $data->semester->semester:'' }}</td>
                        <td>{{ isset($data->subject->subject_name) ? $data->subject->subject_name:'' }}</td>
                        {{--<td>{{ isset($data->unit->title) ? $data->unit->title:'' }}</td>
                        <td>{{ $data->title }}</td>
                        <td>{{ $data->sub_title }}</td>
                        <td>
                            @if($data->url)
                            @if($data->url_type == "file")
                            <img src="{{ asset('upload/note/url/'.$data->url) }}" class="thumbnail" height="50" width="50">
                            @else
                            {{ $data->url }}
                            @endif
                            @endif
                        </td>
                        <td>
                            @if($data->thumbnail)
                            <img src="{{ asset('upload/note/thumbnail/'.$data->thumbnail) }}" class="thumbnail" height="50" width="50">
                            @endif
                        </td>
                        <td>{{ $data->pages }}</td>
                        <td>{{ $data->label }}</td>
                        <td>{{ $data->release_date }}</td>--}}
                        {{--<td>
                        	<a href="{{ route('note.edit',$data->id) }}"><span class="nk-menu-icon success"><em class="icon ni ni-edit"></em></span></a>
                        	<a href="javascript:;" data-url="{{ route('note.distroy',$data->id) }}" class="distroy"><span class="nk-menu-icon danger"><em class="icon ni ni-trash"></em></span></a> 
                        </td>--}}
                        <td><a href="{{ route('note.create',$data->subject_id) }}" data-url="" class=""><span class="nk-menu-icon text-primary">Manage</span></a></td>
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
	        message: "Are you sure to delete this note ?",
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