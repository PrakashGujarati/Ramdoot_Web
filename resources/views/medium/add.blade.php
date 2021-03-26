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
                            <a type="button" href="{{ route('medium.create') }}" class="btn btn-lg btn-danger text-light">Cancel</a>
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

        $('#medium_name').autocomplete({
            serviceUrl: '{{route("load_autocomplete.medium")}}',
            onSelect: function (suggestion) {

                    $(this).val(suggestion.data);

                  //loadCustData(suggestion.data);
            }
        });

        

    
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
                contentType: false,
                processData: false,
                success: function(data) {
                    confirm(data.message);
                    $('#medium_name').val('');
                    $('#board_id').val('');
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
        url: "{{ route('medium.edit') }}",
        type: 'GET',
        data: {
              'id':id
        },
        success: function(result) {
            $('#medium_name').val(result.medium_name);
            $('#board_id').val(result.board_id);
            $('#hidden_id').val(result.id);
            
            
            // $('.dyamictable').empty();
            // $('.dyamictable').html(data);
        }            
    });
});

$(document).on('click','.distroy', function() {
        var id = $(this).attr('data-id');
        bootbox.confirm({
            message: "Are you sure to delete this medium ?",
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
                        url: "{{ route('medium.distroy') }}",
                        type: "GET",
                        data: {
                            'id':id,
                        },
                        success: function(data) {
                            confirm("Medium Deleted Successfully.");
                            
                            $('.dyamictable').empty();
                            $('.dyamictable').html(data);
                            $(".datatable-init").DataTable();
                        }            
                    });
                }
            }
        });
    })

</script>

@endsection