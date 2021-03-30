@extends('layouts.app')
@section('title','Add Board')
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
                        <h5 class="card-title">Add Board / Organisation</h5>
                    </div>
                    <form action="{{ route('board.store') }}" method="POST" enctype='multipart/form-data' id="board_form">
                    @csrf
                        <input type="hidden" name="hidden_id" class="hidden_id" id="hidden_id" value="0">
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
                        <div class="row">
                        <div class="form-group col-lg-6">
                            <label class="form-label">Thumbnail</label>
                            <div class="form-control-wrap">
                                <input type="file" class="form-control" id="thumbnail" name="thumbnail" value="">
                                <input type="hidden" id="hidden_thumbnail" name="hidden_thumbnail" value="">
                                
                                @error('thumbnail')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group col-lg-6">
                            <img id="thumbnail_preview" src="#" alt="your image" class="thumbnail mt-1" height="100" width="100" />
                        </div>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-primary">Submit</button>
                            <a type="button" href="{{ route('board.create') }}" class="btn btn-lg btn-danger text-light">Cancel</a>
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
        //$('#example').DataTable();
        $(".datatable-init").DataTable();
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
                contentType: false,
                processData: false,
                success: function(data) {
                    
                    confirm(data.message);
                    
                    
                    $('#name').val('');
                    $('#abbreviation').val('');
                    $('#thumbnail').val('');
                    $('#hidden_thumbnail').val('');
                    $('#hidden_id').val('0');
                    $('#thumbnail_preview').css('display','none');
                    
                    
                    $('.dyamictable').empty();
                    $('.dyamictable').html(data.html);
                    $(".datatable-init").DataTable();
                }            
            });
        }
    });
});


$(document).on('click','.edit-btn',function(){
    var id = $(this).attr('data-id');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
        },
        url: "{{ route('board.edit') }}",
        type: 'GET',
        data: {
              'id':id
        },
        success: function(result) {
            $('#name').val(result.name);
            $('#abbreviation').val(result.abbreviation);
            $('#hidden_thumbnail').val(result.thumbnail);
            $('#thumbnail_preview').css('display','block');
            var url_path = "{{ env('APP_URL') }}"+"/upload/board/thumbnail/"+result.thumbnail;
            $('#thumbnail_preview').attr('src', url_path);
            $('#hidden_id').val(result.id);
            //$('#thumbnail').val('');
            // $('.dyamictable').empty();
            // $('.dyamictable').html(data);
        }            
    });
});

$(document).on('click','.distroy', function() {
    var id = $(this).attr('data-id');
    bootbox.confirm({
        message: "Are you sure to delete this board ?",
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
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
                    },
                    url: "{{ route('board.distroy') }}",
                    type: "GET",
                    data: {
                        'id':id,
                    },
                    success: function(data) {
                        confirm("Board Deleted Successfully.");
                        
                        $('.dyamictable').empty();
                        $('.dyamictable').html(data);
                        $(".datatable-init").DataTable();
                    }            
                });
                //location.replace(del_url);
            }
        }
    });
});


$(document).on('click','.status_change', function() {
    var id = $(this).attr('data-id');
    var status = $(this).attr('data-status');

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
        },
        url: "{{ route('board.distroy') }}",
        type: "GET",
        data: {
            'id':id,
            'status':status,
        },
        success: function(data) {
            confirm("Board Status Change Successfully.");
            
            $('.dyamictable').empty();
            $('.dyamictable').html(data);
            $(".datatable-init").DataTable();
        }            
    });

});
  
</script>

@endsection