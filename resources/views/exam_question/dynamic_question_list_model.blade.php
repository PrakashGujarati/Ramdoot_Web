<div class="question_list mb-0"> 			
	@if(count($getexam) > 0)
		@php $srno = 1; @endphp
		@foreach($getexam as $examdata)
		
		<input type="hidden" name="question_id[]" value="{{ $examdata->id }}">
		<div class="borderbottom">
			<div class="row">
				<div class="col-md-11">
					<div class="row">
						<div class="col-md-12">
							<label class="mb-0">
								<b>{{ $srno }}. {{ isset($examdata->question->question) ? $examdata->question->question:'' }}</b>
							</label>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">A. {{ isset($examdata->question->option_a) ? $examdata->question->option_a:'' }}</div>
						<div class="col-md-6">B. {{ isset($examdata->question->option_b) ? $examdata->question->option_b:'' }}</div>
					</div>
					<div class="row">
						<div class="col-md-6">C. {{ isset($examdata->question->option_c) ? $examdata->question->option_c:'' }}</div>
						<div class="col-md-6">D. {{ isset($examdata->question->option_d) ? $examdata->question->option_d:'' }}</div>
					</div>
				</div>
			</div>

		@if(count($getexam) > $srno)<hr/>@endif
		</div>
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


