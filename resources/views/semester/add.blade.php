@extends('layouts.app')
@section('title','Add Semester')
@section('css')
@endsection

@section('content')

<div class="nk-block nk-block-lg">
    <div class="row g-gs">
        <div class="col-lg-12">
            <div class="card h-100">
                <div class="card-inner">
                    <div class="card-head">
                        <h5 class="card-title">Add Semester</h5>
                    </div>
                    <form action="{{ route('semester.store') }}" method="POST" enctype='multipart/form-data'>
                    @csrf
                        <div class="form-group">
                            <label class="form-label">Board</label>
                            <div class="form-control-wrap">
                                <select name="board_id" class="form-control board_id" id="board_id">
                                    <option>--Select Board--</option>
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
                        <div class="form-group">
                            <label class="form-label">Standard</label>
                            <div class="form-control-wrap">
                                <select name="standard_id" class="form-control standard_id" id="standard_id">
                                    <option>--Select Standard--</option>
                                    {{--@foreach($standards as $standards_data)
                                    <option value="{{ $standards_data->id }}" @if(old('standard_id') == $standards_data->id) selected="" @endif>{{ $standards_data->standard }}</option>
                                    @endforeach--}}
                                </select>
                                @error('standard_id')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Semester</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="semester" name="semester" value="{{ old('semester') }}">
                                @error('semester')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-primary">Submit</button>
                            <a type="button" href="{{ route('semester.index') }}" class="btn btn-lg btn-danger text-light">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
            
    </div>
</div><!-- .nk-block -->

@endsection

@section('scripts')

<script type="text/javascript">

$(document).on('change','.board_id',function(){
    var board_id = $('.board_id').val();
    getStandard(board_id);
});

function getStandard(board_id){
    $.ajax({
        type: "GET",
        url: "{{route('get.standard')}}",
        data: {
            "board_id":board_id,
        },
        success: function(result) {
            $('#standard_id').html('');
            $('#standard_id').html(result.html);
        } 
    });
}

</script>


@endsection