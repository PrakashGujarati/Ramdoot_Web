@extends('layouts.app')
@section('title','Add Unit')
@section('css')
@endsection

@section('content')

<div class="nk-block nk-block-lg">
    <div class="row g-gs">
        <div class="col-lg-12">
            <div class="card h-100">
                <div class="card-inner">
                    <div class="card-head">
                        <h5 class="card-title">Add Unit</h5>
                    </div>
                    <form action="{{ route('unit.store') }}" method="POST" enctype='multipart/form-data' id="unit_form">
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
                        <div class="form-group col-lg-4">
                            <label class="form-label">Standard</label>
                            <div class="form-control-wrap">
                                <select name="standard_id" class="form-control standard_id" id="standard_id">
                                    <option>--Select Standard--</option>
                                </select>
                                @error('standard_id')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group col-lg-4">
                            <label class="form-label">Semester</label>
                            <div class="form-control-wrap">
                                <select name="semester_id" class="form-control semester_id" id="semester_id">
                                    <option>--Select Semester--</option>
                                </select>
                                @error('semester_id')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group col-lg-4">
                            <label class="form-label">Subject</label>
                            <div class="form-control-wrap">
                                <select name="subject_id" class="form-control subject_id" id="subject_id">
                                    <option>--Select Subject--</option>
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
                            <div class="form-group col-lg-4">
                                <label class="form-label">Title</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
                                    @error('title')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-lg-3">
                                <label class="form-label">Sub Title</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="description" name="description" value="{{ old('description') }}">
                                    @error('description')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-lg-2">
                                <div class="row">
                                    <input type="hidden" name="url_type" class="url_type" id="url_type" value="file">
                                    <div class="col-lg-6"><label class="form-label">Url</label></div>
                                    <div class="col-lg-6 text-right"><div class="g">
                                        <div class="custom-control custom-control-sm custom-checkbox">
                                            <input type="checkbox" class="custom-control-input urlchk" name="instant_result" value="1" id="instant_result">
                                            <label class="custom-control-label" for="instant_result"></label>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="form-control-wrap">
                                    <input type="file" class="form-control" id="url" name="url" value="">
                                    <img id="url_preview" src="#" alt="your image" class="thumbnail mt-1" height="100" width="100" />
                                    @error('url')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-lg-2">
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

                            <div class="form-group col-lg-1">
                                <label class="form-label">Pages</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="pages" name="pages" value="{{ old('pages') }}">
                                    @error('pages')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        
                            

                            <!-- <div class="form-group col-lg-1">
                                <div class="form-control-wrap mt-4">
                                    <button type="button" class="btn btn-success mt-1 add_row"><i class="icon ni ni-plus"></i></button>
                                </div>
                            </div> -->

                        </div>

                        <!-- <div class="newPlus">
                            
                        </div> -->

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-lg btn-primary">Submit</button>
                            <a type="button" href="{{ route('unit.index') }}" class="btn btn-lg btn-danger text-light">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
            
    </div>
</div><!-- .nk-block -->
<br/>
<div class="dyamictable">
    @include('unit.dynamic_table')
</div>

@endsection

@section('scripts')

<script type="text/javascript">

$(document).ready(function(){
    $('#thumbnail_preview').css('display','none');
    $('#url_preview').css('display','none');
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


function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    
    reader.onload = function(e) {
      $('#url_preview').attr('src', e.target.result);
    }
    
    reader.readAsDataURL(input.files[0]); // convert to base64 string
  }
}

$("#url").change(function() {
    $('#url_preview').css('display','block');
  readURL(this);
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

$(document).on('change','.medium_id',function(){
    var board_id = $('.board_id').val();
    var medium_id = $('.medium_id').val();
    getStandard(board_id,medium_id);
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
            $('.standard_id').html('');
            $('.standard_id').html(result.html);
        } 
    });
}    


$(document).on('change','.standard_id',function(){
    var standard_id = $('.standard_id').val();
    var board_id = $('.board_id').val();
    var medium_id = $('.medium_id').val();
    getSemester(standard_id,board_id,medium_id);
});

function getSemester(standard_id,board_id,medium_id){
    $.ajax({
        type: "GET",
        url: "{{route('get.semester.unit')}}",
        data: {
            "standard_id":standard_id,
            "board_id":board_id,
            "medium_id":medium_id,
        },
        success: function(result) {
            $('.semester_id').html('');
            $('.semester_id').html(result.html);
        } 
    });
}

$(document).on('change','.semester_id',function(){
    var board_id = $('.board_id').val();
    var medium_id = $('.medium_id').val();
    var standard_id = $('.standard_id').val();
    var semester_id = $('.semester_id').val();
    getSubject(board_id,medium_id,standard_id,semester_id);
});


function getSubject(board_id,medium_id,standard_id,semester_id){
    $.ajax({
        type: "GET",
        url: "{{route('get.subject')}}",
        data: {
            "standard_id":standard_id,
            "semester_id":semester_id,
            "board_id":board_id,
            "medium_id":medium_id,
        },
        success: function(result) {
            $('.subject_id').html('');
            $('.subject_id').html(result.html);
        } 
    });
}

$(document).on('change','.urlchk',function(){
    if($(this).prop("checked") == true){
        $("#url").attr('type', 'text');
        $('#url_type').val('text');
        $('#url').val('');
        $('#url_preview').css('display','none');
    }
    else if($(this).prop("checked") == false){
        $("#url").attr('type', 'file');
        $('#url_type').val('file');
        $('#url').val('');
    }
});

$(document).ready(function () {
    
    $('#unit_form').validate({
         rules: {
                board_id:"required",
                medium_id:"required",
                standard_id:"required",
                semester_id:"required",
                title:"required",
                description:"required"

            },
        //For custom messages
        messages: {
                board_id:"Please selete board.",
                medium_id:"Please selete medium.",
                standard_id:"Please selete standard.",
                semester_id:"Please enter semester.",
                title:"Please enter title.",
                description:"Please enter sub title."
        },
        submitHandler: function(form) {
            var formData = new FormData($("#unit_form")[0]);

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
                    confirm("Unit Added Successfully.");
                    $('#title').val('');
                    $('#description').val('');
                    $('#url').val('');
                    $('#thumbnail').val();

                    $(".urlchk").prop("checked",false);
                    $("#url").attr('type', 'file');
                    $('#url_type').val('file');
                    
                    $('.dyamictable').empty();
                    $('.dyamictable').html(data);
                }            
            });
        }
    });
    
});


// var max_fields      = 50;
// var wrapper         = $(".newPlus");
// var add_button      = $(".add_row");

// var x = 1;
// $(add_button).click(function(e){
//     e.preventDefault();
//     if(x < max_fields){
//         x++;
//         $(wrapper).append('<div class="row newMinus"><div class="form-group col-lg-3"><label class="form-label">Title</label><div class="form-control-wrap"><input type="text" class="form-control" id="title" name="title[]" value=""></div></div><div class="form-group col-lg-2"><label class="form-label">Url</label><div class="form-control-wrap"><input type="file" class="form-control" id="url" name="url[]" value=""></div></div><div class="form-group col-lg-2"><label class="form-label">Thumbnail</label><div class="form-control-wrap"><input type="file" class="form-control" id="thumbnail" name="thumbnail[]" value=""></div></div><div class="form-group col-lg-1"><label class="form-label">Pages</label><div class="form-control-wrap"><input type="text" class="form-control" id="pages" name="pages[]" value=""></div></div><div class="form-group col-lg-3"><label class="form-label">Description</label><div class="form-control-wrap"><input type="text" class="form-control" id="description" name="description[]" value=""></div></div><div class="form-group col-lg-1"><div class="form-control-wrap mt-4"><button type="button" class="btn btn-danger mt-1 remove_field"><i class="icon ni ni-minus"></i></button></div></div></div>');     
//     }
// });


// $(wrapper).on("click",".remove_field", function(e){
//     e.preventDefault();
//     $(this).closest(".newMinus").remove();
//     x--;
// })

// $(wrapper).on("click",".remove_field", function(e){
//     e.preventDefault(); 
//     $(this).closest(".show").remove();
//     x--;
// })

// $(document).on("click",".remove_fields", function(e){
//     //alert('fdf');
//     e.preventDefault();
//     $(this).closest(".slab").remove();
// })

// $(document).on("click",".remove_fieldedit", function(e){
//     //alert('fdf');
//     e.preventDefault();
//     $(this).closest(".editslab").remove();
// })


</script>

@endsection