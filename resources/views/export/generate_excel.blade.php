@extends('layouts.app')
@section('title','Generate Excel')
@section('css')
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
	                    <h5 class="card-title">Generate Excel</h5>
	                </div>
	            
	            <form action="{{ route('get.generate.excel') }}" method="POST" enctype='multipart/form-data' id="board_form">
	                @csrf
	                <input type="hidden" name="hidden_id" class="hidden_id" id="hidden_id" value="0">

	                <div class="row">
						<div class="form-group col-lg-6">
						    <label class="form-label">Board</label>
						    <div class="form-control-wrap">
						        <select name="board_id" class="form-control board_id" id="board_id">
						            <option value="">--Select Board--</option>
						            @foreach($boards as $boards_data)
						            <option value="{{ $boards_data->id }}" @if(old('board_id') == $boards_data->id) selected="" @endif>{{ $boards_data->name}}</option>
						            @endforeach
						        </select>
						        @error('board_id')
						            <span class="text-danger" role="alert">
						                <strong>{{ $message }}</strong>
						            </span>
						        @enderror
						    </div>
						</div>

						<div class="form-group col-lg-6">
					        <label class="form-label">Medium</label>
					        <div class="form-control-wrap">
					            <select name="medium_id" class="form-control medium_id" id="medium_id">
					                <option>--Select Medium--</option>
					            </select>
					            @error('medium_id')
					                <span class="text-danger" role="alert">
					                    <strong>{{ $message }}</strong>
					                </span>
					            @enderror
					        </div>
					    </div>

					</div>

					<div class="row">

						<div class="form-group col-lg-6">
						    <label class="form-label">Standard</label>
						    <div class="form-control-wrap">
						        <select name="standard_id" class="form-control standard_id" id="standard_id">
						            <option value="">--Select Standard--</option>
						        </select>
						        @error('standard_id')
						            <span class="text-danger" role="alert">
						                <strong>{{ $message }}</strong>
						            </span>
						        @enderror
						    </div>
						</div>

						<div class="form-group col-lg-6">
						    <label class="form-label">Subject</label>
						    <div class="form-control-wrap">
						        <select name="subject_id" class="form-control subject_id" id="subject_id">
						            <option value="">--Select Subject--</option>
						        </select>
						        @error('subject_id')
						            <span class="text-danger" role="alert">
						                <strong>{{ $message }}</strong>
						            </span>
						        @enderror
						    </div>
						</div>

					</div>


					<div class="row">
						<div class="form-group col-lg-6">
						    <label class="form-label">Semester</label>
						    <div class="form-control-wrap">
						        <select name="semester_id" class="form-control semester_id" id="semester_id">
						            <option value="">--Select Semester--</option>
						        </select>
						        @error('semester_id')
						            <span class="text-danger" role="alert">
						                <strong>{{ $message }}</strong>
						            </span>
						        @enderror
						    </div>
						</div>

						<div class="form-group col-lg-6">
							<label class="form-label">Units</label>
							<div class="form-control-wrap">
							    <select name="unit_id" class="form-control unit_id" id="unit_id">
							        <option value="">--Select Unit--</option>
							    </select>
							    @error('unit_id')
							        <span class="text-danger" role="alert">
							            <strong>{{ $message }}</strong>
							        </span>
							    @enderror
							</div>
						</div>
					</div>

	                <div class="row">    
		                <div class="form-group col-lg-4 mt-4">
	                        <button type="submit" class="btn btn-lg btn-primary">Export</button>
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

<script type="text/javascript">

$(document).on('change','.board_id',function(){
    var board_id = $('.board_id').val();
    getMedium(board_id);
});

function getMedium(board_id){
    $.ajax({
        type: "GET",
        url: "{{route('get.medium.excel')}}",
        data: {
            "board_id":board_id,
        },
        success: function(result) {
            $('.medium_id').html('');
            $('.medium_id').html(result.html);
        } 
    });
} 

$(document).on('change','.medium_id',function(){
    var board_id = $('.board_id').val();
    var medium_id = $('.medium_id').val();
    if(medium_id != "All"){
    	getStandard(board_id,medium_id);	
    }
    
});


function getStandard(board_id,medium_id){
    $.ajax({
        type: "GET",
        url: "{{route('get.standard')}}",
        data: {
            "board_id":board_id,
            "medium_id":medium_id,
        },
        success: function(result) {
            $('#standard_id').html('');
            $('#standard_id').html(result.html);
        } 
    });
}


$(document).on('change','.standard_id',function(){
    var standard_id = $('.standard_id').val();
    var medium_id = $('.medium_id').val();
    var board_id = $('.board_id').val();
    getSubject(standard_id,medium_id,board_id);
    //getSemester(standard_id,medium_id,board_id);
});

function getSubject(standard_id,medium_id,board_id){
    $.ajax({
        type: "GET",
        url: "{{route('get.subject')}}",
        data: {
            "standard_id":standard_id,
            "medium_id":medium_id,
            "board_id":board_id
        },
        success: function(result) {
            $('.subject_id').html('');
            $('.subject_id').html(result.html);
        } 
    });
}

$(document).on('change','.subject_id',function(){

    var board_id = $('.board_id').val();
    var medium_id = $('.medium_id').val();
    var standard_id = $('.standard_id').val();
    var semester_id = $('.semester_id').val();
    var subject_id = $('.subject_id').val();
    getSemester(board_id,medium_id,standard_id,subject_id);
    //getUnit(board_id,medium_id,standard_id,semester_id,subject_id);
});

function getSemester(board_id,medium_id,standard_id,subject_id){
    $.ajax({
        type: "GET",
        url: "{{route('get.semester.unit')}}",
        data: {
            "board_id":board_id,
            "medium_id":medium_id,
            "standard_id":standard_id,
            "subject_id":subject_id,
        },
        success: function(result) {
            $('.semester_id').html('');
            $('.semester_id').html(result.html);
        } 
    });
}

$(document).on('change','.semester_id',function(){
    var standard_id = $('.standard_id').val();
    var semester_id = $('.semester_id').val();
    var medium_id = $('.medium_id').val();
    var board_id = $('.board_id').val();
    var subject_id = $('.subject_id').val();
    getUnit(board_id,medium_id,standard_id,semester_id,subject_id);
});


function getUnit(board_id,medium_id,standard_id,semester_id,subject_id){
    $.ajax({
        type: "GET",
        url: "{{route('get.unit')}}",
        data: {
            "board_id":board_id,
            "medium_id":medium_id,
            "standard_id":standard_id,
            "semester_id":semester_id,
            "subject_id":subject_id,
        },
        success: function(result) { 
            $('.unit_id').html('');
            $('.unit_id').html(result.html);
        } 
    });
}

</script>


@endsection