@extends('layouts.app')
@section('title','Add Board')
@section('css')
@endsection
@section('content')

<div class="nk-block nk-block-lg">
    <div class="row g-gs">
        <div class="col-lg-12">
            <div class="card h-100">
                <div class="card-inner">
                    <div class="card-head">
                        <h5 class="card-title">Add Board / Organisation</h5>
                    </div>
                    <form action="{{ route('board.store') }}" method="POST" enctype='multipart/form-data' id="board_form">
                    @csrf
                        <div class="form-group">
                            <label class="form-label">Name</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                                @error('name')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        {{--<div class="form-group">
                            <label class="form-label">Medium</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="medium" name="medium" value="{{ old('medium') }}">
                                @error('medium')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>--}}
                        <div class="form-group">
                            <label class="form-label">Full form of Board/Organisation</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="abbreviation" name="abbreviation" value="{{ old('abbreviation') }}">
                                @error('abbreviation')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        {{--<div class="form-group">
                            <label class="form-label">Url</label>
                            <div class="form-control-wrap">
                                <input type="file" class="form-control" id="url" name="url" value="">
                                @error('url')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>--}}
                        <div class="form-group">
                            <label class="form-label">Thumbnail</label>
                            <div class="form-control-wrap">
                                <input type="file" class="form-control" id="thumbnail" name="thumbnail" value="">
                                <img id="thumbnail_preview" src="#" alt="your image" class="thumbnail mt-1" height="100" width="100" />
                                @error('thumbnail')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-primary">Submit</button>
                            <a type="button" href="{{ route('board.index') }}" class="btn btn-lg btn-danger text-light">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
            
    </div>
</div><!-- .nk-block -->
<br/>
<div class="dyamictable">
    @include('board.dynamic_table')
</div>

@endsection

@section('scripts')

<script type="text/javascript">

    $(document).ready(function(){
        $('#thumbnail_preview').css('display','none');
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

    $("#thumbnail").change(function() {
        $('#thumbnail_preview').css('display','block');
      readThumbnail(this);
    });

    $(document).ready(function () {
    
    $('#board_form').validate({
         rules: {
                name:"required",
                abbreviation:"required",
            },
        //For custom messages
        messages: {

            name:"Please enter name.",
            abbreviation:"Please enter abbreviation.",
        },
        submitHandler: function(form) {
            var formData = new FormData($("#board_form")[0]);

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
                    confirm("Board Added Successfully.");
                    $('#name').val('');
                    $('#abbreviation').val('');
                    $('#thumbnail').val('');
                    
                    
                    $('.dyamictable').empty();
                    $('.dyamictable').html(data);
                    $(".datatable-init").DataTable();
                }            
            });
        }
    });
});


$(document).on('click','.edit-btn',function(){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
        },
        url: "{{ route('board.edit') }}",
        type: GET,
        data: {
        },
        mimeType: "multipart/form-data",
        contentType: false,
        processData: false,
        dataType: 'html',
        success: function(data) {
            $('#name').val(data);
            $('#abbreviation').val('');
            $('#thumbnail').val('');
            
            
            // $('.dyamictable').empty();
            // $('.dyamictable').html(data);
        }            
    });
});
    
</script>

@endsection