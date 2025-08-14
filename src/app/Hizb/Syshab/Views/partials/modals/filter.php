<div class="modal fade" id="modal_filter" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog" id="modal_dialog">
        <div class="modal-content bg-light">
            <div class="modal-header bg-secondary py-2 text-light">
                <h6 class="modal-title"><i class="fas fa-filter"></i> Fillter</h6>
                <div class="">
                    <button type="button" class="btn btn-sm btn-outline-light" data-bs-dismiss="modal">
                        <i class="fa-light fa-rectangle-xmark"></i>
                    </button>
                </div>
            </div>

            <div class="modal-body">
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="form-row">
                            <label class="text-info mb-0">Created Start</label>
                            <div class="input-group input-group-sm mb-2">
                                <input type="text" class="form-control ummu-datepicker" id="date_from"
                                name="date_from" readonly disabled>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary dis-able endis btn-show-date" type="button"
                                    id="btn_show_date" data-inputid="date_from"><i
                                    class="fa-solid fa-calendar-days"></i></button>
                                </div>

                                <input type="text" class="form-control ummu-clockpicker" id="time_from"
                                name="time_from" readonly disabled>
                                <div class="input-group-addon input-group-append">
                                    <button class="btn btn-outline-secondary dis-able endis btn-show-time" type="button"
                                    id="btn_show_time" data-inputid="time_from"><i class="fas fa-clock"></i></button>
                                </div>
                            </div>

                            <label class="text-info mb-0">Created End</label>
                            <div class="input-group input-group-sm mb-2">
                                <input type="text" class="form-control ummu-datepicker" id="date_to"
                                name="date_to" readonly disabled>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary dis-able endis btn-show-date" type="button"
                                    id="btn_show_date" data-inputid="date_to"><i
                                    class="fa-solid fa-calendar-days"></i></button>
                                </div>

                                <input type="text" class="form-control ummu-clockpicker" id="time_to"
                                name="time_to" readonly disabled>
                                <div class="input-group-addon input-group-append">
                                    <button class="btn btn-outline-secondary dis-able endis btn-show-time" type="button"
                                    id="btn_show_time" data-inputid="time_to"><i class="fas fa-clock"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-2">
                    <div class="card-body">
                        <label class="text-info mb-0">Site</label>
                        <select class="custom-select custom-select-sm" id="site_project_kode">
                          <option value="" selected>Choose...</option>
                      </select>
                  </div>
              </div>
          </div>

          <div class="modal-footer py-1">
            <button type="button" class="btn btn-sm btn-primary" id="btn_save_filter">Save Filter</button>
        </div>
    </div>
</div>
</div>
