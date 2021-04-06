<div class="modal fade" id="bluck_import" tabindex="-1" role="dialog" aria-labelledby="exampleModal2" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title text-dark font-weight-bold text-left" id="example-Modal2" style="display: contents;">Import Questions</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
            </div>
            <form action="{{ route('import.bluck_question') }}" method="post" id="bluck_import_form" enctype='multipart/form-data'>
            @csrf
			<div class="modal-body">
                <div id="row">
                	<div class="col-md-12">
                		<input type="file" name="file" class="form-control" id="file">	
                	</div>
                	
                </div>
                <div class="row pt-3">
                	<div class="col-md-12">
                	<button type="submit" class="btn btn-primary">Submit</button>
                	<button type="button" class="btn btn-danger" data-dismiss="modal" >Cancel</button>
                	</div>
                </div>
            </div>
            </form>
			
		</div>
	</div>
</div>
