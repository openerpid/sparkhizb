<?php

namespace Sparkhizb\Helpers;

/**
 * =============================================
 * Author: Ummu
 * Website: https://ummukhairiyahyusna.com/
 * App: Sparkhizb LIB
 * Description: 
 * =============================================
 */

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class RequestHelper
{
    public function __construct()
    {
        $this->request = \Config\Services::request();
    }

    public function page_header($data_page, $page)
    {
        $page_header = "404 Error";

        // $data_page = [
        //     "contact" => "Contact",
        //     "gallery" => "Gallery",
        //     "certificate" => "Certificate"
        // ];

        if ($data_page) {
            foreach ($data_page as $key => $value) {
                if ($key == $page) {
                    $page_header = $value;
                }
            }
        }

        return $page_header;
    }

    public function is_jsonVar()
    {
        $getJsonVar = $this->request->getJsonVar();
        $getVar = $this->request->getVar();

        if ($getJsonVar == null) {
            return false;
        }else{
            return true;
        }
    }

    public function ssl_options()
    {
        $ssl_option = $this->request->header("Ssl-Option");
        if ($ssl_option) {
            $ssl_option = $ssl_option->getValue();
        }else{
            $ssl_option = null;
        }

        return $ssl_option;
    }

    public function myToken()
    {
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header) {
            $token = null;
        }else{
            $token = explode(' ', $header)[1];
        }

        return $token;
    }
}
