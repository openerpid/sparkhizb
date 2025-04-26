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

class UmmuEventRecruitment
{
    public function __construct()
    {
        $this->kode = "event_recruitment";
        $this->path = "api/hcm/event_recruitment/";
        $this->curli = new Curl();
    }

    public function show($params)
    {
        $id = $params['id'];
                
        if ($id) {
            $id = "/" . $id;
        }else{
            $id = "";
        }

        $params = [
            "path"           => $this->path. "show" . $id,
            "method"         => "GET",
            "payload"        => $params['payload'],
            "module_code"    => $this->kode,
            "token"          => $params['token']
        ];

        $response = $this->curli->request4($params);

        return json_decode($response, false);
    }

    public function create($params)
    {
        $params = [
            "path"           => $this->path. "create",
            "method"         => "POST",
            "payload"        => $params['payload'],
            "module_code"    => $this->kode,
            "token"          => $params['token']
        ];

        $response = $this->curli->request4($params);

        return json_decode($response, false);
    }

    public function insert($params)
    {
        $params = [
            "path"           => $this->path. "create",
            "method"         => "POST",
            "payload"        => $params['payload'],
            "module_code"    => $this->kode,
            "token"          => $params['token']
        ];

        $response = $this->curli->request4($params);

        // return json_decode($response, false);
        return $response;
    }

    public function update($params)
    {
        $id = $params['id'];

        $response = $this->curli->request4(
            [
                "path"           => $this->path. "update/". $id,
                "method"         => "PUT",
                "payload"        => $params['payload'],
                "module_code"    => $this->kode,
                "token"          => $params['token']
            ]
        );

        // return json_decode($response, false);
        return $response;
    }

    public function posting($params)
    {
        $id = $params['id'];

        $response = $this->curli->request4(
            [
                "path"           => $this->path. "posting/". $id,
                "method"         => "POST",
                "payload"        => $params['payload'],
                "module_code"    => $this->kode,
                "token"          => $params['token']
            ]
        );

        return json_decode($response, false);
    }

    public function unposting($params)
    {
        $response = $this->curli->request4(
            [
                "path"           => $this->path. "unposting",
                "method"         => "POST",
                "payload"        => $params['payload'],
                "module_code"    => $this->kode,
                "token"          => $params['token']
            ]
        );

        return json_decode($response, false);
    }

    public function delete($params)
    {
        $response = $this->curli->request4(
            [
                "path"           => $this->path. "delete",
                "method"         => "DELETE",
                "payload"        => $params['payload'],
                "module_code"    => $this->kode,
                "token"          => $params['token']
            ]
        );

        return json_decode($response, false);
    }

    public function create_applicants($params)
    {
        $params = [
            "path"           => $this->path. "create_applicants",
            "method"         => "POST",
            "payload"        => $params['payload'],
            "module_code"    => $this->kode,
            "token"          => $params['token']
        ];

        $response = $this->curli->request4($params);

        return json_decode($response, false);
    }
}
