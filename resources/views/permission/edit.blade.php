@extends('layouts.app')
@section('title','Edit Permission')
@section('css')
@endsection

@section('content')

<div class="nk-block nk-block-lg">
    <div class="row g-gs">
        <div class="col-lg-12">
            <div class="card h-100">
                <div class="card-inner">
                    <div class="card-head">
                        <h5 class="card-title">Edit Permission</h5>
                    </div>
                    <form action="{{ route('permission.update',$permission->id) }}" method="POST" enctype='multipart/form-data'>
                    @csrf

                        <div class="row mb-3">
                            

                            <div class="form-group col-lg-6">
                                <label class="form-label">Name</label>
                                <div class="form-control-wrap">
                                    <input type="hidden" name="id" value="{{$permission->id}}">
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $permission->name }}">
                                    @error('name')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                                 
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-primary">Submit</button>
                            <a type="button" href="{{ route('permission.index') }}" class="btn btn-lg btn-danger text-light">Cancel</a>
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



</script>

@endsection