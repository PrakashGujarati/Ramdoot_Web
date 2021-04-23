@extends('layouts.app')
@section('title','Edit Board')
@section('css')
@endsection

@section('content')

<div class="nk-block nk-block-lg">
    <div class="row g-gs">
        <div class="col-lg-12">
            <div class="card h-100">
                <div class="card-inner">
                    <div class="card-head">
                        <h5 class="card-title">Edit Board / Organisation</h5>
                    </div>
                    <form action="{{ route('board.update',$boarddata->id) }}" method="POST" enctype='multipart/form-data'>
                    @csrf
                        <div class="form-group">
                            <label class="form-label">Name</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="name" name="name" value="{{ $boarddata->name }}">
                                @error('name')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>                        
                        <div class="form-group">
                            <label class="form-label">Full form of Board/Organisation</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="abbreviation" name="abbreviation" value="{{ $boarddata->abbreviation }}">
                                @error('abbreviation')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                                <div class="form-group col-lg-6">
                                    <label class="form-label">Subtitle</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="sub_title" name="sub_title" value="{{ $boarddata->sub_title }}" readonly>
                                        @error('sub_title')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group col-lg-3">
                                    <label class="form-label">Thumbnail</label>
                                    <div class="form-control-wrap">
                                        <input type="file" class="form-control" id="thumbnail" name="thumbnail" value="">
                                        <input type="hidden" id="hidden_thumbnail" name="hidden_thumbnail" value="{{ $boarddata->thumbnail }}">                                        
                                        @error('thumbnail')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group col-lg-3">
                                    <img id="thumbnail_preview" src="{{ $boarddata->thumbnail }}" alt="thumbnail image" class="thumbnail mt-1" height="100" width="100" />
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

@endsection

@section('scripts')
@endsection