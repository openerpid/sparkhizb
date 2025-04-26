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

use Sparkhizb\Helpers\Curl;
use Sparkhizb\Helpers\GlobalHelper;

class UmmuEmployeeSalary
{
    public function __construct()
    {
        $this->curli = new Curl();
        $this->gHelp = new GlobalHelper();
        $this->request = \Config\Services::request();
        $this->urli = 'api/hcm/payroll/employee_salary/';
    }

    public function show($params)
    {
        $id = $params['id'];

        if ($id) {
            $show = 'show/' . $id;
        }else{
            $show = 'show';
        }

        $response = $this->curli->request4(
            [
                // "path"           => $this->urli . "show" . $id,
                "path"           => $this->urli . $show,
                "method"         => "GET",
                "payload"        => $params['payload'],
                "module_code"    => "employee_salary",
                "token"          => $params['token']
            ]
        );

        return json_decode($response, false);
    }

    public function import($params)
    {
        $periode_id = $this->request->getVar('periode_id');
        $filepath = $this->gHelp->upload();

        $payload = [
            "path"           => $this->urli . "import",
            "method"         => "POST",
            "payload"        => array(
                'periode_id'    => $periode_id,
                'file'          => new \CURLFILE($filepath)
            ),
            "module_code"    => "employee_salary",
            "token"          => $params['token']
        ];

        $response = $this->curli->form($payload);

        unlink($filepath);

        return json_decode($response, false);
        // return $payload;
    }

    public function show_payslip_periode($params)
    {
        $response = $this->curli->request4(
            [
                "path"           => $this->urli . "show_payslip_periode",
                "method"         => "GET",
                "payload"        => $params['payload'],
                "module_code"    => "employee_salary",
                "token"          => $params['token']
            ]
        );

        return json_decode($response, false);
    }

    public function delete($params)
    {
        $response = $this->curli->request4(
            [
                "path"           => $this->urli . "delete",
                "method"         => "DELETE",
                "payload"        => $params['payload'],
                "module_code"    => "employee_salary",
                "token"          => $params['token']
            ]
        );

        return json_decode($response, false);
    }
}
