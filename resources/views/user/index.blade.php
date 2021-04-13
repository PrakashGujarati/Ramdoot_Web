@extends('layouts.app')
@section('title','Users')
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
            		<h4 class="nk-block-title">User List</h4>
            	</div>
            	<div class="col-lg-2 text-right">
            		<a href="{{ route('user.create') }}" class="btn btn-primary text-light">Add User</a>
            	</div>
            </div>
        </div>
    </div>
    <div class="card card-preview">
        <div class="card-inner">
            <table class="datatable-init table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile No</th>
                        <th>Address</th>
                        <th>Birth Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                	@if(count($users) > 0)
                	@foreach($users as $user)
                    <tr>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->mobile}}</td>
                        <td>{{$user->address}}</td>
                        <td>{{$user->birth_date}}</td>
                        <td>
                            @canany(['User-edit'])
                        	<a href="{{ route('user.edit',$user->id) }}" class="mr-1"><span class="nk-menu-icon success"><em class="icon ni ni-edit"></em></span></a>
                            @endcanany
                            @canany(['User-edit'])
                        	<a href="javascript:;" data-url="{{ route('user.distroy',$user->id) }}" class="distroy"><span class="nk-menu-icon danger"><em class="icon ni ni-trash"></em></span></a>
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
	$(document).on('click','.distroy', function() {
	    let del_url = $(this).attr('data-url');
	    bootbox.confirm({
	        message: "Are you sure to delete this user ?",
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