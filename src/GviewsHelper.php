<?php

namespace Sparkhizb;

/**
* =============================================
* Author: Ummu
* Website: https://ummukhairiyahyusna.com/
* App: Sparkhizb LIB
* Description: 
* =============================================
*/

use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\Files\UploadedFile;
use CodeIgniter\Files\File;

class GviewsHelper 
{
    public function __construct()
    {
        $this->request = \Config\Services::request();
    }

    public function modal_gallery($themes = null)
    {
        if ($themes == 'niceadmin') {
            return "../Gviews/partials/modals/gallery_niceAdmin";
        }
        elseif ($themes == 'sbadmin2') {
            return "../Gviews/partials/modals/gallery_sbadmin2";
        }
        else{
            // 
        }
    }

    public function modal_loader()
    {
        return "../Gviews/partials/modals/loader";
    }

    public function conten_photos()
    {
        return "../Gviews/contents/mygallery/photos";
    }

    public function modal_confirm()
    {
        return "../Gviews/partials/modals/confirm";
    }

    public function modal_info()
    {
        return "../Gviews/partials/modals/information";
    }

    public function modal_list_data($themes = null)
    {
        return "../Gviews/partials/modals/list_data";
    }
}