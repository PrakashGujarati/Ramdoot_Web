<input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">

<input type="hidden" name="semesterid" id="hidden_semesterid" value="{{ $semesterid }}">
<input type="hidden" name="hiddentype" id="hidden_type" value="{{ $type }}">

<div class="row">
	<div class="form-group col-md-8">
		<label class="form-label">Select File</label>
		<input type="file" name="file[]" class="form-control file" id="file" multiple="true">
	</div>
	<div class="form-group col-md-4" style="padding-top: 1.9rem !important;">
		<button type="submit" class="btn btn-primary add_media_btns">Submit</button>
		<button type="button" class="btn btn-danger" data-dismiss="modal" >Cancel</button>
	</div>
</div>


<div class="card card-preview">
	<h4>Media List</h4>
	<hr/>
    <div class="card-inner p-0">
        <table class="datatable-init table">
            <thead>
                <tr>
                	<th>Image</th>
                    <th width="80%">URL</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            	@if(count($media_details) > 0)
            	@foreach($media_details as $data)
                <tr>
                	<td>
                        @if($data->image)
                        <img src="{{ asset('upload/media/solution/'.$data->image) }}" class="thumbnail" height="25" width="25">
                        @endif
                    </td>
                    <td>
                        @if($data->image)
                        <input type="text" value="{{ asset('upload/media/solution/'.$data->image) }}" id="url_path_{{ $data->id }}" style="width: 100%;border:0px!important;outline: none;">
                        <!-- <span id="url_path_{{ $data->id }}">{{ asset('upload/media/solution/'.$data->image) }}</span> -->
                        <!-- <img src="{{ asset('upload/media/solution/'.$data->image) }}" class="thumbnail" height="50" width="50"> -->
                        @endif
                    </td>
                    <td>
                    	<button type="button" class="btn btn-success copybtn" data-media-id="{{ $data->id }}"><i class="fa fa-copy" title="Copy"></i></span></button>
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
</div>

