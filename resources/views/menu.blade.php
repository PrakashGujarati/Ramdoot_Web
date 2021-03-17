@extends('layouts.app')
@section('title','Settings')
@section('css')

@endsection

@section('content')

<div class="nk-block nk-block-lg">
	<div class="card card-preview">
        <div class="card-inner">
        	<ul style="list-style-type:circle">
        		<li><strong><a href="{{route('permission.index')}}">Permission</a></strong></li>	
        	</ul>
        </div>
    </div>
</div>

@endsection

@section('scripts')
@endsection