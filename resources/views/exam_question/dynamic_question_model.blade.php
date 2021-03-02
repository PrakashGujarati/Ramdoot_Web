<input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">

<div class="row">
	<div class="form-group col-lg-6">
	    <label class="form-label">Board</label>
	    <div class="form-control-wrap">
	        <select name="board_id" class="form-control board_id" id="board_id">
	            <option value="">--Select Board--</option>
	            @foreach($boards as $boards_data)
	            <option value="{{ $boards_data->id }}" @if(old('board_id') == $boards_data->id) selected="" @endif>{{ $boards_data->name." - ".$boards_data->medium}}</option>
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

<div class="form-group">
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

<div class="form-group">
	<label class="form-label">Select File</label>
	<input type="file" name="file" class="form-control file" id="file">
</div>