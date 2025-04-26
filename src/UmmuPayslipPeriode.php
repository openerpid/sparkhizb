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

class UmmuPayslipPeriode
{
    public function __construct()
    {
        $this->curli = new Curl();
    }

    public function show($params)
    {
        $response = $this->curli->request4(
            [
                "path"           => "api/hcm/payroll/payslip_periode/show",
                "method"         => "GET",
                "payload"        => $params['payload'],
                "module_code"    => "payslip_periode",
                "token"          => $params['token']
            ]
        );

        return json_decode($response, false);
    }

    public function insert($params)
    {
        $params = [
            "path"           => "api/hcm/payroll/payslip_periode/create",
            "method"         => "POST",
            "payload"        => $params['payload'],
            "module_code"    => "payslip_periode",
            "token"          => $params['token']
        ];

        $response = $this->curli->request4($params);

        return json_decode($response, false);
    }

    public function update($params)
    {
        $params = [
            "path"           => "api/hcm/payroll/payslip_periode/update/".$params['id'],
            "method"         => "POST",
            "payload"        => $params['payload'],
            "module_code"    => "payslip_periode",
            "token"          => $params['token']
        ];

        $response = $this->curli->request4($params);

        return json_decode($response, false);
    }
}
