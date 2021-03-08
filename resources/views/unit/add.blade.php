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
                    <form action="{{ route('unit.store') }}" method="POST" enctype='multipart/form-data'>
                    @csrf
                        <div class="row">
                        <div class="form-group col-lg-3">
                            <label class="form-label">Board</label>
                            <div class="form-control-wrap">
                                <select name="board_id" class="form-control board_id" id="board_id">
                                    <option>--Select Board--</option>
                                    @foreach($boards as $boards_data)
                                    <option value="{{ $boards_data->id }}" @if(old('board_id') == $boards_data->id) selected="" @endif>{{ $boards_data->name." - ".$boards_data->medium }}</option>
                                    @endforeach
                                </select>
                                @error('board_id')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group col-lg-3">
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
                        <div class="form-group col-lg-3">
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

                        <div class="form-group col-lg-3">
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
                            <div class="form-group col-lg-3">
                                <label class="form-label">Title</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="title" name="title[]" value="{{ old('title') }}">
                                    @error('title')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-lg-2">
                                <label class="form-label">Url</label>
                                <div class="form-control-wrap">
                                    <input type="file" class="form-control" id="url" name="url[]" value="">
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
                                    <input type="file" class="form-control" id="thumbnail" name="thumbnail[]" value="">
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
                                    <input type="text" class="form-control" id="pages" name="pages[]" value="{{ old('pages') }}">
                                    @error('pages')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        
                            <div class="form-group col-lg-3">
                                <label class="form-label">Description</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="description" name="description[]" value="{{ old('description') }}">
                                    @error('description')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-lg-1">
                                <div class="form-control-wrap mt-4">
                                    <button type="button" class="btn btn-success mt-1 add_row"><i class="icon ni ni-plus"></i></button>
                                </div>
                            </div>

                        </div>

                        <div class="newPlus">
                            
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-primary">Submit</button>
                            <a type="button" href="{{ route('unit.index') }}" class="btn btn-lg btn-danger text-light">Cancel</a>
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
            $('.standard_id').html('');
            $('.standard_id').html(result.html);
        } 
    });
}    


$(document).on('change','.standard_id',function(){
    var standard_id = $('.standard_id').val();
    getSemester(standard_id);
});

function getSemester(standard_id){
    $.ajax({
        type: "GET",
        url: "{{route('get.semester.unit')}}",
        data: {
            "standard_id":standard_id,
        },
        success: function(result) {
            $('.semester_id').html('');
            $('.semester_id').html(result.html);
        } 
    });
}

$(document).on('change','.semester_id',function(){
    var standard_id = $('.standard_id').val();
    var semester_id = $('.semester_id').val();
    getSubject(standard_id,semester_id);
});


function getSubject(standard_id,semester_id){
    $.ajax({
        type: "GET",
        url: "{{route('get.subject')}}",
        data: {
            "standard_id":standard_id,
            "semester_id":semester_id,
        },
        success: function(result) {
            $('.subject_id').html('');
            $('.subject_id').html(result.html);
        } 
    });
}

var max_fields      = 50;
var wrapper         = $(".newPlus");
var add_button      = $(".add_row");

var x = 1;
$(add_button).click(function(e){
    e.preventDefault();
    if(x < max_fields){
        x++;
        $(wrapper).append('<div class="row newMinus"><div class="form-group col-lg-3"><label class="form-label">Title</label><div class="form-control-wrap"><input type="text" class="form-control" id="title" name="title[]" value=""></div></div><div class="form-group col-lg-2"><label class="form-label">Url</label><div class="form-control-wrap"><input type="file" class="form-control" id="url" name="url[]" value=""></div></div><div class="form-group col-lg-2"><label class="form-label">Thumbnail</label><div class="form-control-wrap"><input type="file" class="form-control" id="thumbnail" name="thumbnail[]" value=""></div></div><div class="form-group col-lg-1"><label class="form-label">Pages</label><div class="form-control-wrap"><input type="text" class="form-control" id="pages" name="pages[]" value=""></div></div><div class="form-group col-lg-3"><label class="form-label">Description</label><div class="form-control-wrap"><input type="text" class="form-control" id="description" name="description[]" value=""></div></div><div class="form-group col-lg-1"><div class="form-control-wrap mt-4"><button type="button" class="btn btn-danger mt-1 remove_field"><i class="icon ni ni-minus"></i></button></div></div></div>');     
    }
});


$(wrapper).on("click",".remove_field", function(e){
    e.preventDefault();
    $(this).closest(".newMinus").remove();
    x--;
})

$(wrapper).on("click",".remove_field", function(e){
    e.preventDefault(); 
    $(this).closest(".show").remove();
    x--;
})

$(document).on("click",".remove_fields", function(e){
    //alert('fdf');
    e.preventDefault();
    $(this).closest(".slab").remove();
})

$(document).on("click",".remove_fieldedit", function(e){
    //alert('fdf');
    e.preventDefault();
    $(this).closest(".editslab").remove();
})


</script>

@endsection