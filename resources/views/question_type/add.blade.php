@extends('layouts.app')
@section('title','Add Slider')
@section('css')
@endsection

@section('content')

<div class="nk-block nk-block-lg">
    <div class="row g-gs">
        <div class="col-lg-12">
            <div class="card h-100">
                <div class="card-inner">
                    <div class="card-head">
                        <h5 class="card-title">Add Slider</h5>
                    </div>
                    <form action="{{ route('slider.store') }}" method="POST" enctype='multipart/form-data'>
                    @csrf
                            
                        <div class="form-group">
                            <label class="form-label">Area</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="area" name="area" value="{{ old('area') }}">
                                @error('area')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Image</label>
                            <div class="form-control-wrap">
                                <input type="file" class="form-control" id="image" name="image" value="">
                                @error('image')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        
                        <div class="form-group">
                            <label class="form-label">Url</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="url" name="url" value="{{ old('url') }}">
                                @error('url')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Text</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="text" name="text" value="{{ old('text') }}">
                                @error('text')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Order</label>
                            <div class="form-control-wrap">
                                <input type="number" class="form-control" id="order" name="order" min="0" value="{{ old('order') }}">
                                @error('order')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-primary">Submit</button>
                            <a type="button" href="{{ route('slider.index') }}" class="btn btn-lg btn-danger text-light">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
            
    </div>
</div><!-- .nk-block -->

@endsection

@section('scripts')
@endsection