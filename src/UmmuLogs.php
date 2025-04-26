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

// use CodeIgniter\HTTP\IncomingRequest;
use Sparkhizb\Helpers\CurlHelper;

class UmmuLogs
{
    public function __construct()
    {
        $this->curli = new CurlHelper();
        $this->request  = \Config\Services::request();
    }

    public function create($text, $label = null)
    {
        $filename = date("Y-m-d") . '.html';

        if (! is_dir("/var/www/html/ummuLogs")) {
            exec("mkdir /var/www/html/ummuLogs");
        }

        exec("chmod -R 777 /var/www/html/ummuLogs");

        if (! is_file("/var/www/html/ummuLogs/" . $filename)) {
            exec("touch /var/www/html/ummuLogs/" . $filename);
        }

        exec("chmod -R 777 /var/www/html/ummuLogs");

        $fp = fopen('/var/www/html/ummuLogs/' . $filename, 'a');
        fwrite($fp, "<p>" . $label . " " . date("Y-m-d H:i:s") . "<br>" . "\n");
        fwrite($fp, json_encode($text) . "<br>" . "\n");
    }

    public function create2($filename, $text, $subject = null)
    {
        $filename = $filename. '_'. date("Y-m-d") . '.html';

        if ($subject) {
            $subject = $subject . ' | ';
        }

        if (! is_dir("/var/www/html/ummuLogs")) {
            exec("mkdir /var/www/html/ummuLogs");
        }

        exec("chmod -R 777 /var/www/html/ummuLogs");

        if (! is_file("/var/www/html/ummuLogs/" . $filename)) {
            exec("touch /var/www/html/ummuLogs/" . $filename);
        }

        exec("chmod -R 777 /var/www/html/ummuLogs");

        $fp = fopen('/var/www/html/ummuLogs/' . $filename, 'a');
        fwrite($fp, "<p>" . $subject . date("Y-m-d H:i:s") . "<br>" . "\n");
        fwrite($fp, json_encode($text) . "<br>" . "\n");
    }

    public function create3($filename, $text = null, $subject = null)
    {
        $filename = $filename. '_'. date("Y-m-d") . '.html';
        $jsonVar = $this->request->getJsonVar();
        $var = $this->request->getVar();
        $ip = $this->request->getIPAddress();
        $headers = $this->request->headers();
        $headers = implode("<br>",$headers);
        $method = $this->request->getMethod();

        if ($text == null) {
            if ($jsonVar) {
                // code...
                $text = $jsonVar;
            }else{
                $text = $var;
            }
        }

        if ($subject) {
            $subject = $subject . ' | ';
        }

        if (! is_dir(WRITEPATH . "ummuLogs")) {
            exec("mkdir " . WRITEPATH . "ummuLogs");
        }

        if (! is_file(WRITEPATH . "ummuLogs/" . $filename)) {
            exec("touch " . WRITEPATH ."ummuLogs/" . $filename);
        }

        $fp = fopen(WRITEPATH . 'ummuLogs/' . $filename, 'a');
        fwrite($fp, "<p><span style='font-weight: bold;'>" . $method . " | " . $subject . date("Y-m-d H:i:s") . "</span><br>" . "\n");
        fwrite($fp, "IP Address: " . $ip . "<br>" . "\n");
        fwrite($fp, $headers . "<br>" . "\n");
        fwrite($fp, "Body: " . json_encode($text) . "<br>" . "\n");
    }

    public function create4($response)
    {
        if (!is_dir(FCPATH . "logs")) {
            exec("sudo mkdir " . FCPATH . "logs");
        }
        if (!is_file(FCPATH . "logs/run_po_new_" . date("Y-m-d") . '.html')) {
            exec("sudo touch " . FCPATH . "logs/run_po_new_" . date("Y-m-d") . '.html');
        }
        exec("sudo chmod -R 777 " . FCPATH . "logs/");
        $fp = fopen('logs/run_po_new_' . date("Y-m-d") . '.html', 'a');
        fwrite($fp, "<p>" . date("Y-m-d H:i:s") . "<br>" . "\n");
        fwrite($fp, json_encode($response) . "<br>" . "\n");
    }
}
