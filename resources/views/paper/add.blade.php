@extends('layouts.app')
@section('title','Add Paper')
@section('css')
@endsection

@section('content')

<div class="nk-block nk-block-lg">
    <div class="row g-gs">
        <div class="col-lg-12">
            <div class="card h-100">
                <div class="card-inner">
                    <div class="card-head">
                        <h5 class="card-title">Add Paper</h5>
                    </div>
                    <form action="{{ route('paper.store') }}" method="POST" enctype='multipart/form-data'>
                    @csrf
                        
                        <div class="row">

                            <div class="form-group col-lg-6">
                                <label class="form-label">Units</label>
                                <div class="form-control-wrap">
                                    <select name="unit_id" class="form-control" id="unit_id">
                                        <option>--Select Unit--</option>
                                        @foreach($units as $units_data)
                                        <option value="{{ $units_data->id }}" @if(old('unit_id') == $units_data->id) selected="" @endif>{{ $units_data->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('unit_id')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group col-lg-6">
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

                        </div>

                        <div class="row">
                            
                            <div class="form-group col-lg-6">
                                <label class="form-label">Url</label>
                                <div class="form-control-wrap">
                                    <input type="file" class="form-control" id="url" name="url" value="">
                                    @error('url')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>                            


                            <div class="form-group col-lg-6">
                                <label class="form-label">Label</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="label" name="label" value="{{ old('label') }}">
                                    @error('label')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>    

                        </div>

                        <div class="form-group">
                            <label class="form-label">Description</label>
                            <div class="form-control-wrap">
                                <textarea class="form-control" id="description" name="description" value="{{ old('description') }}"></textarea>
                                @error('description')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-primary">Submit</button>
                            <a type="button" href="{{ route('paper.index') }}" class="btn btn-lg btn-danger text-light">Cancel</a>
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