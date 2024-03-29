@extends('layouts.app')
@section('title','Notification')
@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
table {
    table-layout:fixed;
}
td{
    overflow:hidden;    
    text-overflow: ellipsis;
    white-space: normal !important;
}
</style>

@endsection
@section('content')

<div class="nk-block nk-block-lg">
    <div class="row g-gs">
    	<div class="col-lg-12">
	    	<div class="card h-100">
	            <div class="card-inner">
	                <div class="card-head">
	                    <h5 class="card-title">Send Notification</h5>
	                </div>
	            @if(session()->has('success'))
	        		<div class="row mb-3">
	        			<div class="col-lg-12">
						    <div class="alert alert-success">
						        {{ session()->get('success') }}
						    </div>
						</div>
					</div>
				@endif
	            <form action="{{ route('notification.store') }}" method="POST" enctype='multipart/form-data' 
	            id="notification_form">
	                @csrf
	                <div class="row">
	                	<div class="form-group col-lg-12">
                            <label class="form-label">Device Id</label>
                            <div class="form-control-wrap">
                                <select name="user_id[]" class="form-control" id="user_id" multiple="multiple" value="">
								<option value="0">-- Select All Users --</option>
		                            @foreach($userdata as $user)
		                            	@if($user->name)
		                                <option value="{{ $user->id }}">{{ $user->name }}</option>
		                                @endif
		                            @endforeach
                                </select>
                                @error('device_id')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
		            </div>
		            <div class="row mt-2">
		            	<div class="form-group col-lg-4">
		                    <label class="form-label">Title</label>
		                    <input type="text" name="title" id="title" class="form-control" value=""> 
		                    <div class="form-control-wrap">
		                        @error('title')
		                            <span class="text-danger" role="alert">
		                                <strong>{{ $message }}</strong>
		                            </span>
		                        @enderror
		                    </div>
		                </div>
		                <div class="form-group col-lg-8">
		                    <label class="form-label">Message</label>
		                    <input type="text" name="message" id="message" class="form-control" value=""> 
		                    <div class="form-control-wrap">
		                        @error('message')
		                            <span class="text-danger" role="alert">
		                                <strong>{{ $message }}</strong>
		                            </span>
		                        @enderror
		                    </div>
		                </div>
		            </div>
		            <div class="row">
		            	<div class="form-group col-lg-4">
			                <label class="form-label">Select Image</label>
		                    <input type="file" name="file" id="file" class="form-control" value=""> 
		                    <div class="form-control-wrap">
		                        @error('file')
		                            <span class="text-danger" role="alert">
		                                <strong>{{ $message }}</strong>
		                            </span>
		                        @enderror
		                    </div>
		                </div>
		                <div class="form-group col-lg-4">
		                	<img id="thumbnail_preview" src="#" alt="your image" class="thumbnail mt-1" height="100" />
		                </div>
		            </div>
		            <div class="row">
		                <div class="form-group col-lg-4 mt-4">
	                        <button type="submit" class="btn btn-lg btn-primary">Send Notification</button>
	                    </div>
		            </div>

	            </form>  
	            </div>     
	        </div>
	    </div>
    </div>
</div>

@endsection

@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript">

	$(document).ready(function() {
       $("#user_id").select2({
            tags: true,
            tokenSeparators: [',', ' ']
        })
       $('#thumbnail_preview').css('display','none');
    });	

$(document).ready(function () {
    
    $('#notification_form').validate({
         rules: {
            device_id : "required",
            user_name : "required",
            title : "required",
            message : "required",	

        },
        messages: {
        	device_id : "Please select device id.",
        	user_name : "Please select User Name.",
        	title : "Please enter title.",
            message : "Please enter message.",
        },
    });
});

$("#file").change(function() {
    $('#thumbnail_preview').css('display','block');
  	readThumbnail(this);
});

function readThumbnail(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    
    reader.onload = function(e) {
      $('#thumbnail_preview').attr('src', e.target.result);
    }
    
    reader.readAsDataURL(input.files[0]); // convert to base64 string
  }
}

</script>

@endsection