@extends('layouts.app')
@section('title','User Data Log')
@section('css')
@endsection

@section('content')
<div class="details-modal">

</div>
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
            		<h4 class="nk-block-title">User Data Log</h4>
            	</div>
            </div>
        </div>
    </div>
    <div class="card card-preview">
        <div class="row" style="margin: 10px">
            <div class="col-lg-3">
                <label>Start Date</label>
                <input type="date" name="start_date" value="{{date('Y-m-d')}}" class="form-control start_date">
            </div>
            <div class="col-lg-3">
                <label>End Date</label>
                <input type="date" name="end_date" value="{{date('Y-m-d')}}" class="form-control end_date">
            </div>
            <div class="col-lg-4">
                <label>Select User</label>
                <select name="user_id" class="form-control user-id">
                    @foreach($users as $user)
                        @if($user->name && isset($user_id))
                        <option value="{{$user->id}}">{{$user->name}}</option>
                        @elseif($user->name)
                        <option value="{{$user->id}}">{{$user->name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2 mt-3 pt-4"><a class="btn btn-success export_userlog" href="javascript:;">Export</a></div>
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
    $(document).on('change','.user-id',function(){
        getData();
    });

    $(document).on('click','.export_userlog',function(){
        var start_date=$('.start_date').val();
        var end_date=$('.end_date').val();
        var user_id=$('.user-id').val();

        window.location.href = "{{ url('user_log/export') }}/"+start_date+"/"+end_date+"/"+user_id;

        // $('.dyanamicTable').html('');
        // $.ajax({
        //     type: "GET",
        //     data:{
        //         'end_date':end_date,
        //         'start_date':start_date,
        //         'user_id':user_id
        //     },
        //     url: "{{ route('user.log.export') }}",
        //     beforeSend: function( xhr ) {
        //         // $('.loader').show();
        //     },
        //     success: function(result) {
        //         //$('.dyanamicTable').html(result.html);
        //     }
        // });

    })

    function getDetails(userDataLogId,id){
        var userDataLogId = userDataLogId;
        var logable_id = id;
        $('.details-modal').html();
        $.ajax({
            type: "GET",
            data:{
                'userDataLogId':userDataLogId,
                'logable_id':logable_id,
            },
            url: "{{route('log.details_modal')}}",
            beforeSend: function( xhr ) {
                $('.loader').show();
            },
            success: function(result) {
                $('.details-modal').html(result.html);
                $('.modal').modal('toggle');
            }
        });
    }

    function getData()
    {
        var start_date=$('.start_date').val();
        var end_date=$('.end_date').val();
        var user_id=$('.user-id').val();
        $('.dyanamicTable').html('');
        $.ajax({
            type: "GET",
            data:{
                'end_date':end_date,
                'start_date':start_date,
                'user_id':user_id
            },
            url: "{{route('user_ajax.log')}}",
            beforeSend: function( xhr ) {
                $('.loader').show();
            },
            success: function(result) {
                $('.dyanamicTable').html(result.html);
            }
        });
    }

    $(document).on('click','#submit-btn',function(){
        var logIds = [];
        var minutes = [];
        $('input[name ="log_ids"]').each(function() {
            logIds.push($(this).val());
        });
        $('input[name ="minutes"]').each(function() {
            minutes.push($(this).val());
        });
        $.ajax({
            type: "GET",
            data:{
                'log_ids':logIds,
                'minutes': minutes
            },
            url: "{{route('log_minutes')}}",
            beforeSend: function( xhr ) {
                $('.loader').show();
            },
            success: function(result) {
                getData();
            }
        });
    });

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
