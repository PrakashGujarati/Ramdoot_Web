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
                        <h5 class="card-title">Edit Board</h5>
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
                            <label class="form-label">Medium</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="medium" name="medium" value="{{ $boarddata->medium }}">
                                @error('medium')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Abbreviation</label>
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
                            <label class="form-label">Url</label>
                            <div class="form-control-wrap">
                                <input type="file" class="form-control" id="url" name="url" value="">
                                <input type="hidden" name="hidden_url" value="{{ $boarddata->url }}">
                                <br/>
                                @if($boarddata->url)
                                    @php $ext = pathinfo($boarddata->url, PATHINFO_EXTENSION); @endphp
                                    @if($ext == "png" || $ext == "jpg" || $ext == "jpeg")
                                    <img src="{{ asset('upload/board/url/'.$boarddata->url) }}" class="thumbnail" height="100" width="100">
                                    @else
                                    <p>{{ $boarddata->url }}</p>
                                    @endif
                                @endif
                                @error('url')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Thumbnail</label>
                            <div class="form-control-wrap">
                                <input type="file" class="form-control" id="thumbnail" name="thumbnail" value="">
                                <input type="hidden" name="hidden_thumbnail" value="{{ $boarddata->thumbnail }}">
                                <br/>
                                @if($boarddata->thumbnail)
                                <img src="{{ asset('upload/board/thumbnail/'.$boarddata->thumbnail) }}" class="thumbnail" height="100" width="100">
                                @endif
                                @error('thumbnail')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
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