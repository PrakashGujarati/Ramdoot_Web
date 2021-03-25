@extends('layouts.app')
@section('title','Edit User')
@section('css')
@endsection

@section('content')

<div class="nk-block nk-block-lg">
    <div class="row g-gs">
        <div class="col-lg-12">
            <div class="card h-100">
                <div class="card-inner">
                    <div class="card-head">
                        <h5 class="card-title">Edit Unit</h5>
                    </div>
                    <form action="{{ route('user.update') }}" method="POST" enctype='multipart/form-data'>
                    @csrf
                        <div class="row">
                            <input type="hidden" name="id" value="{{$user->id}}"> 
                            <div class="form-group col-lg-6">
                                <label class="form-label">Role</label>
                                <div class="form-control-wrap">
                                    <select name="role_id" class="form-control role_id" id="role_id">
                                        <option>--Select Role--</option>
                                        @foreach($roles as $role)
                                        <option value="{{ $role->id }}" @if(in_array($role->name,$user->getRoleNames()->toArray())) selected="" @endif>{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('role_id')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label class="form-label">Name</label>
                                <div class="form-control-wrap">
                                    <input type="text" value="{{$user->name}}" name="name" class="form-control name" id="name">
                                    @error('name')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                        </div>
                        <div class="row">
                        <div class="form-group col-lg-4">
                            <label class="form-label">Email</label>
                            <div class="form-control-wrap">
                                <input type="email" name="email" value="{{$user->email}}" id="email" class="email form-control"> 
                                @error('email')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group col-lg-4">
                            <label class="form-label">Address</label>
                            <div class="form-control-wrap">
                                <input type="text" name="address" value="{{$user->address}}" class="form-control address" id="address">
                                @error('address')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        
                        </div>
                        

                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label class="form-label">City</label>
                                <div class="form-control-wrap">
                                    <input type="text" value="{{$user->city}}" name="city" class="form-control city" id="city">
                                    @error('password')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-lg-4">
                                <label class="form-label">Birth Date</label>
                                <div class="form-control-wrap">
                                    <input type="date" name="birth_date" value="{{$user->birth_date}}" class="form-control birth_date" id="birth_date">
                                    @error('birth_date')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-lg-4">
                                <label class="form-label">Mobile No</label>
                                <div class="form-control-wrap">
                                    <input type="number" name="mobile" value="{{$user->mobile}}" maxlength="10" class="form-control mobile" id="mobile">
                                    @error('mobile')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-primary">Submit</button>
                            <a type="button" href="{{ route('user.index') }}" class="btn btn-lg btn-danger text-light">Cancel</a>
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