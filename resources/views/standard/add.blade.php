@extends('layouts.app')
@section('title','Add Standard')
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
                        <h5 class="card-title">Add Standard / Class</h5>
                    </div>
                    <form action="{{ route('standard.store') }}" method="POST" enctype='multipart/form-data' id="standard_form">
                    @csrf
                        <input type="hidden" name="hidden_id" class="hidden_id" id="hidden_id" value="0">
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label class="form-label">Board</label>
                                <div class="form-control-wrap">
                                    <select name="board_id" class="form-control board_id" id="board_id">
                                        <option value="">--Select Board--</option>
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
                                <label class="form-label">Medium</label>
                                <div class="form-control-wrap">
                                    <select name="medium_id" class="form-control medium_id" id="medium_id">
                                        <option value="">--Select Medium--</option>
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
                                <input type="text" class="form-control" id="standard" name="standard" value="{{ old('standard') }}">
                                @error('standard')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group col-lg-6">
                            <label class="form-label">Section</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="section" name="section" value="{{ old('section') }}">
                                @error('section')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        </div>
                        <!-- <div class="form-group">
                            <label class="form-label">Semester</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="semester" name="semester" value="{{ old('semester') }}">
                                @error('semester')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> -->
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
                            <a type="button" href="{{ route('standard.index') }}" class="btn btn-lg btn-danger text-light">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
            
    </div>
</div><!-- .nk-block -->
<br/>
<div class="dyamictable">
    @include('standard.dynamic_table')
</div>

@endsection

@section('scripts')

<script type="text/javascript">

    $(document).on('click','.above_order', function() {
        var order_no=$(this).data('order_no');
        $.ajax({
                url: "{{route('above_order.standard')}}",
                type: "GET",
                data: {
                    "order_no": order_no
                },
                success: function(html) {
                    $('.dyamictable').empty();
                    $('.dyamictable').html(html.html);
                    $(".datatable-init").DataTable();                  
                }
            });
    });
    $(document).on('click','.below_order', function() {
        var order_no=$(this).data('order_no');
        $.ajax({
                url: "{{route('below_order.standard')}}",
                type: "GET",
                data: {
                    "order_no": order_no
                },
                success: function(html) {
                    $('.dyamictable').empty();
                    $('.dyamictable').html(html.html);
                    $(".datatable-init").DataTable();                  
                }
        });    
    });

    $( document ).ready(function() {
        var check_board = <?PHP echo json_encode($isset); ?>;
        if(check_board == 1){
            var boardid = <?PHP echo (!empty($medium_details->board_id) ? json_encode($medium_details->board_id) : '""'); ?>;
            var mediumid = <?PHP echo (!empty($medium_details->id) ? json_encode($medium_details->id) : '""'); ?>;
            $('.board_id').val(boardid);
            var board_id = boardid;
            var medium_id = mediumid;
            getMediumEdit(board_id,medium_id);
        }   

    });

    function getMediumEdit(board_id,medium_id){
    
        $.ajax({
            type: "GET",
            url: "{{route('get.medium')}}",
            data: {
                "board_id":board_id,
                "medium_id":medium_id,
            },
            success: function(result) {
                $('.medium_id').html('');
                $('.medium_id').html(result.html);
            } 
        });
    }

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

$(document).on('change','.board_id',function(){
    var board_id = $('.board_id').val();
    getMedium(board_id);
});

function getMedium(board_id){
    $.ajax({
        type: "GET",
        url: "{{route('get.medium')}}",
        data: {
            "board_id":board_id,
        },
        success: function(result) {
            $('.medium_id').html('');
            $('.medium_id').html(result.html);
        } 
    });
} 

$(document).ready(function () {
    
    $('#standard').autocomplete({
        serviceUrl: '{{route("load_autocomplete.standard")}}',
        onSelect: function (suggestion) {

                $(this).val(suggestion.data);

              //loadCustData(suggestion.data);
        }
    });
    $('#section').autocomplete({
        serviceUrl: '{{route("load_autocomplete.section")}}',
        onSelect: function (suggestion) {

                $(this).val(suggestion.data);

              //loadCustData(suggestion.data);
        }
    });

    

    $('#standard_form').validate({
         rules: {
                board_id:"required",
                medium_id:"required",
                standard:"required",
                section:"required",
            },
        //For custom messages
        messages: {
                board_id:"Please selete board.",
                medium_id:"Please selete medium.",
                standard:"Please enter standard.",
                section:"Please enter section.",
        },
        submitHandler: function(form) {
            var formData = new FormData($("#standard_form")[0]);

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
                    $('#standard').val('');
                    $('#section').val('');
                    $('#thumbnail').val('');
                    $('#hidden_thumbnail').val('');
                    $('#thumbnail_preview').css('display','none');
                    $('#hidden_id').val('0');
                    
                    
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
        url: "{{ route('standard.edit') }}",
        type: 'GET',
        data: {
              'id':id
        },
        success: function(result) {
            $('#board_id').val(result.board_id);
            var board_id = $('#board_id').val();
            var medium_id = result.medium_id;
            getMediumEdit(board_id,medium_id);
            $('#standard').val(result.standard);
            $('#section').val(result.section);
            $('#hidden_thumbnail').val(result.thumbnail);
            $('#thumbnail_preview').css('display','block');
            var url_path = "{{ env('APP_URL') }}"+"/upload/standard/thumbnail/"+result.thumbnail;
            $('#thumbnail_preview').attr('src', url_path);
            $('#hidden_id').val(result.id);
            //$('#thumbnail').val('');
            
            
            // $('.dyamictable').empty();
            // $('.dyamictable').html(data);
        }            
    });
});

function getMediumEdit(board_id,medium_id){
    
    $.ajax({
        type: "GET",
        url: "{{route('get.medium')}}",
        data: {
            "board_id":board_id,
            "medium_id":medium_id,
        },
        success: function(result) {
            $('.medium_id').html('');
            $('.medium_id').html(result.html);
        } 
    });
}
    


$(document).on('click','.distroy', function() {
    var id = $(this).attr('data-id');
    bootbox.confirm({
        message: "Are you sure to delete this standard ?",
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
                    url: "{{ route('standard.distroy') }}",
                    type: "GET",
                    data: {
                        'id':id,
                    },
                    success: function(data) {
                        confirm("Standard Deleted Successfully.");
                            
                        $('#standard').val('');
                        $('#section').val('');
                        $('#thumbnail').val('');
                        $('#hidden_thumbnail').val('');
                        $('#thumbnail_preview').css('display','none');

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
        url: "{{ route('standard.distroy') }}",
        type: "GET",
        data: {
            'id':id,
            'status':status,
        },
        success: function(data) {
            confirm("Standard Status Change Successfully.");
            
            $('.dyamictable').empty();
            $('.dyamictable').html(data);
            $(".datatable-init").DataTable();
        }            
    });

});


</script>

@endsection