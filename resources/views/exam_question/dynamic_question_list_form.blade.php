<div class="modal fade" id="question_list_view" tabindex="-1" role="dialog" aria-labelledby="exampleModal2" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title text-dark font-weight-bold text-left" id="example-Modal2" style="display: contents;">Question List</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
            </div>
            <form action="{{ route('question.import') }}" method="post" id="import_form" enctype='multipart/form-data'>
            @csrf
			<div class="modal-body pt-1 pb-1"  id="dynamic-modal-content" style="max-height:550px;
            height: auto!important;overflow-y: auto;">
                <div id="question_list_model_data"></div>
                <!-- <div class="row pt-3">
                	<div class="col-md-12">
                	<button type="button" class="btn btn-primary select_question">Done</button>
                	<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                	</div>
                </div> -->
            </div>
            </form>
			
		</div>
	</div>
</div>
