@extends('layouts.app')
@section('title','Add Medium')
@section('css')
@endsection

@section('content')

<div class="nk-block nk-block-lg">
    <div class="row g-gs">
        <div class="col-lg-12">
            <div class="card h-100">
                <div class="card-inner">
                    <div class="card-head">
                        <h5 class="card-title">Add Medium</h5>
                    </div>
                    <form action="{{ route('medium.store') }}" method="POST" enctype='multipart/form-data' id="medium_form">
                    @csrf

                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label class="form-label">Board</label>
                                <div class="form-control-wrap">
                                    <select name="board_id" class="form-control board_id" id="board_id">
                                        <option>--Select Board--</option>
                                        @foreach($boards as $boards_data)
                                        <option value="{{ $boards_data->id }}" @if(old('board_id') == $boards_data->id) selected="" @endif>{{ $boards_data->name }}</option>
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
                                <label class="form-label">Medium Name</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="medium_name" name="medium_name" value="{{ old('medium_name') }}">
                                    @error('medium_name')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                                 
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-primary">Submit</button>
                            <a type="button" href="{{ route('medium.index') }}" class="btn btn-lg btn-danger text-light">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
            
    </div>
</div><!-- .nk-block -->
<br/>
<div class="dyamictable">
    @include('medium.dynamic_table')
</div>

@endsection

@section('scripts')

<script type="text/javascript">
    $(document).ready(function () {
    
    $('#medium_form').validate({
         rules: {
                board_id:"required",
                medium_name:"required",
            },
        //For custom messages
        messages: {

            board_id:"Please select board.",
            medium_name:"Please select medium.",
        },
        submitHandler: function(form) {
            var formData = new FormData($("#medium_form")[0]);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
                },
                url: form.action,
                type: form.method,
                data: formData,//$(form).serialize(),
                mimeType: "multipart/form-data",
                contentType: false,
                processData: false,
                dataType: 'html',
                success: function(data) {
                    confirm("Medium Added Successfully.");
                    $('#medium_name').val('');
                    
                    
                    $('.dyamictable').empty();
                    $('.dyamictable').html(data);
                }            
            });
        }
    });
    
});


</script>

@endsection