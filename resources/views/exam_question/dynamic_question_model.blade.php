<div class="question_list mb-3"> 			
	<input type="hidden" name="checkbox_limit" id="checkbox_limit" class="checkbox_limit" value="{{ $chk_limit }}">
	@if(count($getexam) > 0)
		@php $srno = 1; @endphp
		@foreach($getexam as $examdata)
		<input type="hidden" name="question_id[]" value="{{ $examdata->id }}">
		<div class="borderbottom">
			<div class="row">
				<div class="col-md-1 pr-0 pt2">
					<div class="form-control-wrap">
                        <div class="g">
                            <div class="custom-control custom-control-sm custom-checkbox">
                                <input type="checkbox" class="custom-control-input chk_question" name="chk_question" value="1" id="chk_question_{{ $examdata->id }}" data-id="{{ $examdata->id }}">
                                <label class="custom-control-label" for="chk_question_{{ $examdata->id }}"></label>
                            </div>
                        </div>
                    </div>
				</div>
				<div class="col-md-11 pl-0">
					<div class="row">
						<div class="col-md-12">
							<label class="mb-0">
								<b>{{ $srno }}. {{ $examdata->question }}</b>
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
				</div>
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


