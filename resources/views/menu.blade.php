@extends('layouts.app')
@section('title','Settings')
@section('css')

@endsection

@section('content')

<div class="nk-block nk-block-lg">
	<div class="row">
		<div class="col-md-6">
			<div class="card card-preview">
				<div class="card-header">
					<h3>Permission</h3>
				</div>
		        <div class="card-inner">
		        	<ul style="list-style-type:circle">
		        		@canany(['User-view'])
		        			<li><strong><a href="{{route('user.index')}}">User</a></strong></li>
		        		@endcanany
		        		@canany(['Permission-view'])
		        			<li><strong><a href="{{route('permission.index')}}">Permission</a></strong></li>
		        		@endcanany
		        		@canany(['Permission-view'])
		        			<li><strong><a href="{{route('role_permission.index')}}">Role Permission</a></strong></li>
		        		@endcanany
		        	</ul>
		        </div>
		    </div>	
		</div>
		<div class="col-md-6">
			<div class="card card-preview">
				<div class="card-header">
					<h3>Logs</h3>
				</div>
		        <div class="card-inner">
		        	<ul style="list-style-type:circle">
		        		@canany(['Log-view'])
		        			<li><strong><a href="{{route('user.log')}}">Log</a></strong></li>
		        		@endcanany
		        		@canany(['Review-view'])
		        			<li><strong><a href="{{route('user.reviews')}}">Review</a></strong></li>	
		        		@endcanany
		        	</ul>
		        </div>
		    </div>	
		</div>
	</div>
	

	<div class="row mt-4">
		<div class="col-md-6">
			<div class="card card-preview">
				<div class="card-header">
					<h3>Notification</h3>
				</div>
		        <div class="card-inner">
		        	<ul style="list-style-type:circle">
		        			<li><strong><a href="{{route('notification.index')}}">Notification</a></strong></li>
		        	</ul>
		        </div>
		    </div>	
		</div>
	</div>
    

</div>

@endsection

@section('scripts')
@endsection