<div class="modal fade" id="modal_delete_confirm" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog" id="modal_dialog">
        <div class="modal-content bg-light">
            <div class="modal-header bg-info py-2 text-light">
                <h6 class="modal-title"><i class="fas fa-exclamation-circle"></i> Confirmation</h6>
                <div class="">
                    <button type="button" class="btn btn-sm btn-outline-light" data-bs-dismiss="modal">
                        <i class="fa-light fa-rectangle-xmark"></i>
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-2">
                        <i class="fas fa-trash-alt fa-3x text-danger"></i>
                    </div>
                    <div class="col">
                        <h5>Are you sure you want to delete seletced items ?</h5>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="modal_btn_delete">Delete</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_release_confirm" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog" id="modal_dialog">
        <div class="modal-content bg-light">
            <div class="modal-header bg-info py-2 text-light">
                <h6 class="modal-title"><i class="fas fa-exclamation-circle"></i> Confirmation</h6>
                <div class="">
                    <button type="button" class="btn btn-sm btn-outline-light" data-bs-dismiss="modal">
                        <i class="fa-light fa-rectangle-xmark"></i>
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-2">
                        <!-- <i class="far fa-check-circle fa-3x text-success"></i> -->
                        <i class="fas fa-share fa-3x text-primary"></i>
                    </div>
                    <div class="col-10">
                        <h5>Are you sure you want to release seletced items ?</h5>
                    </div>
                </div>                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn_do_release">Release</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_approve_confirm" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog" id="modal_dialog">
        <div class="modal-content bg-light">
            <div class="modal-header bg-info py-2 text-light">
                <h6 class="modal-title"><i class="fas fa-exclamation-circle"></i> Confirmation</h6>
                <div class="">
                    <button type="button" class="btn btn-sm btn-outline-light" data-bs-dismiss="modal">
                        <i class="fa-light fa-rectangle-xmark"></i>
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-2">
                        <i class="far fa-check-circle fa-3x text-success"></i>
                    </div>
                    <div class="col-10">
                        <h5>Are you sure you want to approve seletced items ?</h5>
                    </div>
                </div>                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn_do_approve">Approve</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_reject_confirm" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog" id="modal_dialog">
        <div class="modal-content bg-light">
            <div class="modal-header bg-info py-2 text-light">
                <h6 class="modal-title"><i class="fas fa-exclamation-circle"></i> Confirmation</h6>
                <div class="">
                    <button type="button" class="btn btn-sm btn-outline-light" data-bs-dismiss="modal">
                        <i class="fa-light fa-rectangle-xmark"></i>
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-2">
                        <i class="far fa-times-circle fa-3x text-danger"></i>
                    </div>
                    <div class="col-10">
                        <h5>Are you sure you want to reject seletced items ?</h5>
                    </div>
                </div> 
                <div class="form-group mt-2">
                    <label for="remark">Remark :</label>
                    <textarea class="form-control" id="remark" rows="2"></textarea>
                </div>              
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn_do_reject">Reject</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_open_recruitment_confirm" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog" id="modal_dialog">
        <div class="modal-content bg-light">
            <div class="modal-header bg-info py-2 text-light">
                <h6 class="modal-title"><i class="fas fa-exclamation-circle"></i> Confirmation</h6>
                <div class="">
                    <button type="button" class="btn btn-sm btn-outline-light" data-bs-dismiss="modal">
                        <i class="fa-light fa-rectangle-xmark"></i>
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-2">
                        <i class="fas fa-bullhorn fa-3x text-primary"></i>
                    </div>
                    <div class="col-10">
                        <h5>Are you sure you want to open this recruitment ?</h5>
                    </div>
                </div>                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="modal_btn_open_recruitment">Open Recruitment</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_close_recruitment_confirm" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog" id="modal_dialog">
        <div class="modal-content bg-light">
            <div class="modal-header bg-info py-2 text-light">
                <h6 class="modal-title"><i class="fas fa-exclamation-circle"></i> Confirmation</h6>
                <div class="">
                    <button type="button" class="btn btn-sm btn-outline-light" data-bs-dismiss="modal">
                        <i class="fa-light fa-rectangle-xmark"></i>
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-2">
                        <i class="fas fa-bullhorn fa-3x text-danger"></i>
                    </div>
                    <div class="col-10">
                        <h5>Are you sure you want to close recruitment ?</h5>
                    </div>
                </div>                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="modal_btn_close_recruitment">Close Recruitment</button>
            </div>
        </div>
    </div>
</div>