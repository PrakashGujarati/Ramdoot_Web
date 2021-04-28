@extends('layouts.app')
@section('title','Import Excel')
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
	                    <h5 class="card-title">Import Data Excel</h5>
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
	            <form action="{{ route('import.data_excel') }}" method="POST" enctype='multipart/form-data' 
	            id="import_form">
	                @csrf
	                <input type="hidden" name="hidden_id" class="hidden_id" id="hidden_id" value="0">
	                <div class="row">
		                <div class="form-group col-lg-4">
		                    <label class="form-label">Select Module</label>
		                    <select class="form-control" id="module" name="module">
		                    	<option>Board</option>
		                    	<option>Medium</option>
		                    	<option>Standard</option>
		                    	<option>Subject</option>
		                    	<option>Semester</option>
		                    	<option>Unit</option>
		                    	<option>Book</option>
		                    	<option>Video</option>
		                    </select>
		                    <div class="form-control-wrap">
		                        @error('module')
		                            <span class="text-danger" role="alert">
		                                <strong>{{ $message }}</strong>
		                            </span>
		                        @enderror
		                    </div>
		                </div>
		                <div class="form-group col-lg-4">
		                	<label class="form-label">Select File <span class="text-danger">(.csv, .xls, .xlsx)</span></label>
		                	<input type="file" name="file" value="" id="file" class="form-control">
		                	@error('file')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
		                </div>
		                <div class="form-group col-lg-4 mt-4">
	                        <button type="submit" class="btn btn-lg btn-primary">Import</button>
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
	
$(document).ready(function () {
    
    // $('#import_form').validate({
    //      rules: {
    //         file : {
	   //          required : true,
	   //          extension: "xls|csv"
    //     	},	
    //     },
    //     messages: {
    //     	file:{
    //     		required : "A csv file is required.",
    //         	extension: "The file type must be 'CSV'."	
    //     	},
        	
    //     },
    // });
});

</script>

@endsection