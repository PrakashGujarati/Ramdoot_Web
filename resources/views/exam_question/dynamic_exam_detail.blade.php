<div class="row">
	<div class="col-md-12">
		<h5 class="card-title">Question Details</h5>
	</div>
</div>
<hr/>
<div class="question_list mb-3"> 			
	@if(count($getexam) > 0)
		@php $srno = 1; @endphp
		@foreach($getexam as $examdata)
		<input type="hidden" name="question_id[]" value="{{ $examdata->id }}">
		<div class="borderbottom">
			<div class="row">
				<div class="col-md-12">
					<label class="mb-0"><b>{{ $srno }}. {{ $examdata->question }}</b><span class="pl-3"><i class="icon ni ni-edit"></i></span></label>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">A. {{ $examdata->option_a }}</div>
				<div class="col-md-6">B. {{ $examdata->option_b }}</div>
			</div>
			<div class="row">
				<div class="col-md-6">C. {{ $examdata->option_c }}</div>
				<div class="col-md-6">D. {{ $examdata->option_d }}</div>
			</div>
		@if(count($getexam) > $srno)<hr/>@endif
		</div>
		<br/>
		@php $srno = $srno+1; @endphp
		@endforeach
	@else
		<div class="row">
			<div class="col-md-12">
				<label class="mb-0">No Record Found.</b></label>
			</div>
		</div>
	@endif
</div>

