<?php

namespace Sparkhizb\Helpers;

/**
* =============================================
* Author: Ummu
* Website: https://ummukhairiyahyusna.com/
* App: DORBITT LIB
* Description: 
* =============================================
*/

use CodeIgniter\HTTP\IncomingRequest;
// use CodeIgniter\HTTP\Files\UploadedFile;
// use CodeIgniter\Files\File;
use JShrink\Minifier;

class GviewsHelper 
{
    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->minifier = new \JShrink\Minifier();
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

    public function modal_filter()
    {
        return "../Gviews/partials/modals/filter";
    } 

    public function nav_tab()
    {
        return "../Gviews/partials/nav_tab";
    }

    public function nav_tab_doc_status()
    {
        return "../Gviews/partials/nav_tab_doc_status";
    }

    public function ummujs()
    {
        return $this->minifier->minify(file_get_contents(base_url("vendor/dorbitt-lib/js/ummu.js")));
        // return "OK";
    }

    public function web_data()
    {
        $name = getenv('web.name');
        $favicon = getenv('web.favicon');
        $tmp = getenv('web.tmp');
        $title = getenv('web.title');
        $logo = getenv('web.logo');

        if(!$name) {
            $name = 'ERPNESIA';
        }

        if(!$favicon) {
            $favicon = 'dorbitt_favicon.ico';
        }

        if(!$logo) {
            $logo = 'dorbitt.png';
        }

        if(!$tmp) { 
            $tmp = 'arsha'; 
        }

        if(!$title) {
            $title = 'ERPNESIA';
        }

        $data = [
            "name"      => $name,
            "logo"      => $logo,
            "favicon"   => $favicon,
            "tmp"       => $tmp,
            "title"     => $title
        ];

        return $data;
    }
}