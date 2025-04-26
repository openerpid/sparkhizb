<div class="modal fade" id="modal_gallery" tabindex="-1" style="z-index: 2000;">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <div id="response_message_modal_modal">Gallery</div>
                <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-2">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Select File</h5>
                                <div class="alert text-light collapse" id="modal_alert_submit_file"></div>
                                <img src="<?=base_url();?>uploads/no_image.jpg" class="img-thumbnail" id="upload_img_thumbnail" alt="...">
                                <div class="input-group input-group-sm" id="group_input_upload">
                                    <form class="input-group input-group-sm" enctype="multipart/form-data" id="form_upload_file">
                                        <div class="col-md-12 input-group-sm">
                                            <input class="form-control forBtnClear" type="file" id="file_upload" name="file_upload">
                                        </div>
                                        <div class="input-group input-group-sm mb-3">
                                            <span class="input-group-text">Note</span>
                                            <input class="form-control forBtnClear" type="text" id="file_description" name="file_description" placeholder="description">
                                        </div>
                                    </form>
                                </div>                               
                                <div class="collapse mb-2" id="modal_loader_submit_file">
                                    <div class="d-flex justify-content-center mt-2">
                                        <div class="spinner-border text-danger" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-grid gap-2">
                                    <button class="btn btn-sm btn-outline-primary" type="button" id="btn_submit_file_upload">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-10">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Gallery</h5>
                                <div class="collapse mb-2" id="modal_loader_gallery">
                                    <div class="d-flex justify-content-center mt-2">
                                        <div class="spinner-border text-danger" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="album bg-body-tertiary">
                                    <div class="container">
                                        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 row-cols-xl-6 g-3" id="album_gallery"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <!-- <button type="button" class="btn btn-sm btn-danger">Delete</button> -->
                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-sm btn-primary" id="btn_select_file">Select File</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>