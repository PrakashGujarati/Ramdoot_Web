<div class="modal fade" id="add_media" tabindex="-1" role="dialog" aria-labelledby="exampleModal2" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title text-dark font-weight-bold text-left" id="example-Modal2" style="display: contents;">Media</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
            </div>
            <form action="{{ route('store.medias') }}" method="post" id="medias_form" enctype='multipart/form-data'>
            @csrf
			<div class="modal-body"  id="dynamic-modal-content" style="max-height: 520px;overflow: auto;">
                <div id="add_media_model_data"></div>
                
            </div>
            </form>
			
		</div>
	</div>
</div>