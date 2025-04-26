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
// use Sparkhizb\GlobalHelper;

class UmmuPayslip
{
    public function __construct()
    {
        $this->curli = new Curl();
        // $this->gHelp = new GlobalHelper();
    }

    public function show($params)
    {
        $response = $this->curli->request4(
            [
                "path"           => "api/hcm/payroll/payslip/show",
                "method"         => "GET",
                "payload"        => $params['payload'],
                "module_code"    => "payslip",
                "token"          => $params['token']
            ]
        );

        return json_decode($response, false);
    }

    public function print_pdf($params)
    {
        $id = $params['id'];

        if ($id) {
            $id = "/" . $id;
        }else{
            $id = "";
        }

        $response = $this->curli->request4(
            [
                "path"           => "api/hcm/payroll/payslip/print_pdf" . $id,
                "method"         => "GET",
                "payload"        => $params['payload'],
                "module_code"    => "payslip",
                "token"          => $params['token']
            ]
        );

        return json_decode($response, false);
    }

    public function delete_pdf($params)
    {
        $id = $params['id'];

        if ($id) {
            $id = "/" . $id;
        }else{
            $id = "";
        }

        $response = $this->curli->request4(
            [
                "path"           => "api/hcm/payroll/payslip/delete_pdf" . $id,
                "method"         => "DELETE",
                "payload"        => $params['payload'],
                "module_code"    => "payslip",
                "token"          => $params['token']
            ]
        );

        return json_decode($response, false);
    }
}
