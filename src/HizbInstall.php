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

class HizbInstall
{
    public function __construct()
    {
        // $this->request = \Config\Services::request();
    }

    public function run()
    {
        $this->is_symlink();
        $this->create_symlink();
    }

    public function is_symlink()
    {
        $create_pdf = FCPATH. "create_pdf";

        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $public = FCPATH."Hizb";
            if (is_link($public) OR is_dir($public)) {
                unlink($public);
            }elseif (is_file($public)) {
                rmdir($public);
            }

            $app = APPPATH."Hizb";
            if (is_link($app)) {
                rmdir($app);
            }elseif(is_file($app)){
                unlink($app);
            }

            if (is_link($create_pdf)) {
                rmdir($create_pdf);
            }elseif(is_file($create_pdf)){
                unlink($create_pdf);
            }
        }else{
            if (is_link(FCPATH."Hizb")) {
                exec("rm -rf ".FCPATH."Hizb");
            }

            if (is_link(APPPATH."Hizb")) {
                exec("rm -rf ".APPPATH."Hizb");
            }

            if (is_link($create_pdf)) {
                exec("rm -rf ". $create_pdf);
            }
        }
    }

    public function create_symlink()
    {
        $app = [ROOTPATH."vendor/sparkhizb/lib/src/app/Hizb", APPPATH."Hizb"];
        $public = [ROOTPATH."vendor/sparkhizb/lib/src/public/Hizb", FCPATH."Hizb"];
        $create_pdf = [WRITEPATH. "create_pdf", FCPATH. "create_pdf"];

        if (!is_dir(WRITEPATH. "create_pdf")) {
            exec("mkdir ". WRITEPATH. "create_pdf");
        }

        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            symlink($app[0], $app[1]);
            symlink($public[0], $public[1]);
            symlink($create_pdf[0], $create_pdf[1]);
        } else {
            exec("ln -s ".$app[0]." ".$app[1]);
            exec("ln -s ".$public[0]." ".$public[1]);
            exec("ln -s ".$create_pdf[0]." ".$create_pdf[1]);
        }
    }
}
