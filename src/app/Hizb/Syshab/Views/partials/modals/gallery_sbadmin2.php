<style>
    #album_berangkas, #album_gallery {
        * {
            /*font-family: Lato;
            margin: 0;
            padding: 0;*/
            --transition: 0.15s;
            --border-radius: 0.5rem;
            --background: #ffc107;
            --box-shadow: #ffc107;
        }

        .cont-bg {
            min-height: 150vh;
            background-image: radial-gradient(
                circle farthest-corner at 7.2% 13.6%,
                rgba(37, 249, 245, 1) 0%,
                rgba(8, 70, 218, 1) 90%
            );
            padding: 1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .cont-title {
            color: white;
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .cont-main {
            display: flex;
            flex-wrap: wrap;
            align-content: center;
            justify-content: center;
        }

        .cont-checkbox {
            width: 150px;
            height: 150px;
            /*border-radius: var(--border-radius);
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            background: white;
            transition: transform var(--transition);*/
        }

        /*.cont-checkbox:first-of-type {
            margin-bottom: 0.75rem;
            margin-right: 0.75rem;
        }*/

        .cont-checkbox:active {
            transform: scale(0.9);
        }

        input {
            display: none;
        }

        input:checked + label {
            opacity: 1;
            box-shadow: 0 0 0 3px var(--background);
        }

        input:checked + label img {
            -webkit-filter: none; /* Safari 6.0 - 9.0 */
            filter: none;
        }

        input:checked + label .cover-checkbox {
            opacity: 1;
            transform: scale(1);
        }

        input:checked + label .cover-checkbox svg {
            stroke-dashoffset: 0;
        }

        label {
            display: inline-block;
            cursor: pointer;
            border-radius: var(--border-radius);
            overflow: hidden;
            width: 100%;
            height: 100%;
            position: relative;
            opacity: 0.6;
        }

        label img {
            width: 100%;
            height: 70%;
            object-fit: cover;
            clip-path: polygon(0% 0%, 100% 0, 100% 81%, 50% 100%, 0 81%);
            -webkit-filter: grayscale(100%); /* Safari 6.0 - 9.0 */
            filter: grayscale(100%);
        }

        label .cover-checkbox {
            position: absolute;
            right: 5px;
            top: 3px;
            z-index: 1;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: var(--box-shadow);
            border: 2px solid #fff;
            transition: transform var(--transition),
            opacity calc(var(--transition) * 1.2) linear;
            opacity: 0;
            transform: scale(0);
        }

        label .cover-checkbox svg {
            width: 13px;
            height: 11px;
            display: inline-block;
            vertical-align: top;
            fill: none;
            margin: 5px 0 0 3px;
            stroke: #fff;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
            stroke-dasharray: 16px;
            transition: stroke-dashoffset 0.4s ease var(--transition);
            stroke-dashoffset: 16px;
        }

        label .info {
            text-align: center;
            margin-top: 0.2rem;
            font-weight: 600;
            font-size: 0.8rem;
        }
    }

    .circular--square { 
        border-top-left-radius: 50% 50%; 
        border-top-right-radius: 50% 50%; 
        border-bottom-right-radius: 50% 50%; 
        border-bottom-left-radius: 50% 50%; 
    }

    .circular--portrait { 
        position: relative; 
        width: 120px; 
        height: 120px; 
        overflow: hidden; 
        border-radius: 50%; 
    } 

    .circular--portrait img { 
        width: 100%; 
        height: auto; 
    }

    .circular--landscape { 
        display: inline-block; 
        position: relative; 
        width: 120px; 
        height: 120px; 
        overflow: hidden; 
        border-radius: 50%; 
    } 

    .circular--landscape img { 
        width: auto; 
        height: 100%; 
        margin-left: -50px; 
    }

    .circular--portrait-35 { 
        position: relative; 
        width: 35px; 
        height: 35px; 
        overflow: hidden; 
        border-radius: 50%; 
    } 

    .circular--portrait-35 img { 
        width: 100%; 
        height: auto; 
    }

    .circular--landscape-35 { 
        display: inline-block; 
        position: relative; 
        width: 35px; 
        height: 35px; 
        overflow: hidden; 
        border-radius: 50%; 
    } 

    .circular--landscape-35 img { 
        width: auto; 
        height: 100%; 
    /* margin-left: -50px;  */
    }
</style>

<div class="modal fade" id="modal_mygallery" tabindex="-1" stylez="z-index: 2000;">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <div id="response_message_modal_modal">My Gallery</div>
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
                                        <!-- <div class="col-md-12 input-group-sm">
                                            <input class="form-control forBtnClear" type="file" id="file_upload" name="file_upload">
                                        </div> -->
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="file_upload" aria-describedby="inputGroupFileAddon01">
                                                <label class="custom-file-label" for="file_upload">Choose file</label>
                                            </div>
                                        </div>
                                        <input class="form-control forBtnClear" type="text" id="file_description" name="file_description" placeholder="Description">
                                    </form>
                                </div>                               
                                <div class="collapse mb-2" id="modal_loader_submit_file">
                                    <div class="d-flex justify-content-center mt-2">
                                        <div class="spinner-border text-danger" role="status">
                                            <!-- <span class="visually-hidden">Loading...</span> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="d-grid gap-2 mt-3">
                                    <button class="btn btn-sm btn-outline-primary btn-lg btn-block" type="button" id="btn_submit_file_upload">
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
                                <h5 class="card-title">My Gallery</h5>
                                <div class="collapse mb-2" id="modal_loader_gallery">
                                    <div class="d-flex justify-content-center mt-2">
                                        <div class="spinner-border text-danger" role="status">
                                            <!-- <span class="visually-hidden">Loading...</span> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-sm btn-primary" id="mygallery_btn_select_file">Select File</button>
                                </div>
                                <!-- <div class="album bg-body-tertiary"> -->
                                    <!-- <div class="container"> -->
                                    <div class="p-3">
                                        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 row-cols-xl-6 g-3" id="album_gallery"></div>
                                    </div>
                                <!-- </div> -->
                            </div>
                            <!-- <div class="card-footer text-end"> -->
                                <!-- <button type="button" class="btn btn-sm btn-danger">Delete</button> -->
                                <!-- <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-sm btn-primary" id="mygallery_btn_select_file">Select File</button> -->
                            <!-- </div> -->
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>