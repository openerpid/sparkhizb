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

class UmmuSaham
{
    public function __construct()
    {
        $this->curli = new Curl();
        $this->urli = 'api/saham/';
    }

    public function show($params)
    {
        // $response = $this->curli->request4(
        //     [
        //         "path"           => $this->urli . "show",
        //         "method"         => "GET",
        //         "payload"        => $params['payload'],
        //         "module_code"    => "saham_endofday",
        //         "token"          => $params['token']
        //     ]
        // );

        // return json_decode($response, false);
    }

    public function show_endofday($params)
    {
        $response = $this->curli->request4(
            [
                "path"           => $this->urli. "endofday/show",
                "method"         => "GET",
                "payload"        => $params['payload'],
                "module_code"    => "saham_endofday",
                "token"          => $params['token']
            ]
        );

        return json_decode($response, false);
    }

    public function insert_endofday($params)
    {
        $response = $this->curli->request4([
            "path"           => $this->urli. "endofday/create",
            "method"         => "POST",
            "payload"        => $params["payload"],
            "module_code"    => "saham_endofday",
            "token"          => $params["token"]
        ]);

        return $response;
    }

    public function insert($params)
    {
        // $response = $this->curli->request4([
        //     "path"           => $this->urli. "create",
        //     "method"         => "POST",
        //     "payload"        => $params["payload"],
        //     "module_code"    => "she_hazard_report",
        //     "token"          => $params["token"]
        // ]);

        // return json_decode($response, false);
    }

    public function delete($params)
    {
        // $response = $this->curli->request4(
        //     [
        //         "path"           => $this->urli. "delete",
        //         "method"         => "DELETE",
        //         "payload"        => $params['payload'],
        //         "module_code"    => "she_hazard_report",
        //         "token"          => $params['token']
        //     ]
        // );

        // return json_decode($response, false);
    }

    public function update($params)
    {
        // $response = $this->curli->request4(
        //     [
        //         "path"           => $this->urli. "update",
        //         "method"         => "PUT",
        //         "payload"        => $params['payload'],
        //         "module_code"    => "she_hazard_report",
        //         "token"          => $params['token']
        //     ]
        // );

        // return json_decode($response, false);
    }

    public function release($params)
    {
        // $response = $this->curli->request4(
        //     [
        //         "path"           => $this->urli. "release",
        //         "method"         => "POST",
        //         "payload"        => $params['payload'],
        //         "module_code"    => "she_hazard_report",
        //         "token"          => $params['token']
        //     ]
        // );

        // return json_decode($response, false);
    }
}
