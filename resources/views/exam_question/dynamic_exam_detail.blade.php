<div class="row">
	<div class="col-md-8">
		<h5 class="card-title">Question Details</h5>
	</div>
	<div class="col-md-4 text-right">
		<button type="button" class="btn btn-success clear_btn">Clear</button>
		<button type="button" class="btn btn-primary add_question_btn">Add</button>
	</div>
</div>
<hr/>
<div class="question_list mb-3"> 			
	<input type="hidden" name="hidden_srno" id="hidden_srno" class="hidden_srno" value="0">
	@if(count($getexam) > 0)
		@php $srno = 1; @endphp
		@foreach($getexam as $examdata)
		<input type="hidden" name="question_id[]" class="hidden_question_id" value="{{ $examdata->id }}">
		<div class="borderbottom">
			<div class="row">
				<div class="col-md-12">
					<label class="mb-0">
						<b>{{ $srno }}. {{ $examdata->question }}</b>
						<span class="pl-3"><a href="javascript:;" class="edit_question" data-srno="{{ $srno }}"><i class="icon ni ni-edit"></i></a></span>
					</label>
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

