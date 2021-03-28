@extends('layouts.app')
@section('title','User Data Review')
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
            		<h4 class="nk-block-title">User Data Review</h4>
            	</div>
            </div>
        </div>
    </div>
    <div class="card card-preview">
        <div class="row" style="margin: 10px">
            <div class="col-lg-4">    
                <label>Start Date</label>
                <input type="date" name="start_date" value="{{date('Y-m-d')}}" class="form-control start_date">
            </div>
            <div class="col-lg-4">
                <label>End Date</label>
                <input type="date" name="end_date" value="{{date('Y-m-d')}}" class="form-control end_date">
            </div>    
        </div>
        <div class="row dyanamicTable">
            
        </div>
            
    </div><!-- .card-preview -->
</div>

@endsection

@section('scripts')

<script type="text/javascript">

    $(document).ready(function(){
        getData();
    });
    $(document).on('change','.end_date',function(){
        getData();
    });
    $(document).on('change','.start_date',function(){
        getData();
    });
    function getData()
    {
        var start_date=$('.start_date').val();
        var end_date=$('.end_date').val();
        $.ajax({
            type: "GET",
            data:{
                'end_date':end_date,
                'start_date':start_date
            },
            url: "{{route('user_ajax.review')}}",
            beforeSend: function( xhr ) {
                $('.loader').show();
            },
            success: function(result) {
                $('.dyanamicTable').html(result.html);
            }
        });
    }

	$(document).on('click','.distroy', function() {
	    let del_url = $(this).attr('data-url');
	    bootbox.confirm({
	        message: "Are you sure to delete this material ?",
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