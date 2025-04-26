<div class="modal fade modal-loader" id="modal_loader" data-bs-backdrop="static" data-keyboard="false" tabindex="-2" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="background: transparent; z-index: 2000;">
	<div class="modal-dialog modal-dialog-centered" style="background: transparent;">
		<div class="modal-content border-0 shadow-none" style="background: transparent;">
			<!-- <div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div> -->
			<div class="modal-body" style="background: transparent;">
				<div class="text-center text-light">
					<!-- <div class="spinner-border" role="status">
						<span class="sr-only">Loading...</span>
					</div> -->
					<img src="<?=base_url('Gasset/loading-gif.gif')?>" width="150px">
					<div>
						<label id="text_loader"></label>
					</div>
				</div>
			</div>
			<!-- <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Understood</button>
			</div> -->
		</div>
	</div>
</div>


<div class="modal fade modal-loader2" id="modal_loader2" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content border-0 shadow-none" style="background: transparent;">
			<div class="modal-body" style="background: transparent;">
				<div class="text-center text-light">
					<img src="<?=base_url('Gasset/loading-gif.gif')?>" width="150px">
					<div>
						<label id="text_loader2"></label>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Understood</button>
      </div>
    </div>
  </div>
</div>