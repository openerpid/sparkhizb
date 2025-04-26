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

use Sparkhizb\Helpers\CurlHelper;
use Sparkhizb\Helpers\UmmuHelper;
use Sparkhizb\Helpers\GlobalHelper;

class UmmuMechanicActivity
{
    public function __construct()
    {
        $this->kode = "pm_mechanic_activity";

        $this->curli = new CurlHelper();
        $this->gHelp = new GlobalHelper();
        $this->umHelp = new UmmuHelper();
        
        $this->umHelp->autoHelper($this->kode);
        $this->urli = 'api/pm/mechanic_activity/';
    }

    public function show($params)
    {
        // $id = $params['id'];
        // $payload = $params['payload'];
        // $token = $params['token'];
        
        // if ($id) {
        //     $path = "api/pm/mechanic_activity/show/" . $id;
        // }else{
        //     $path = "api/pm/mechanic_activity/show";
        // }

        // $params = [
        //     "path"           => $path,
        //     "method"         => "GET",
        //     "payload"        => $payload,
        //     "module_code"    => "pm_mechanic_activity",
        //     "token"          => $token
        // ];

        // $response = $this->curli->request3($params);

        // return json_decode($response, false);

        $response = $this->curli->request4(
            [
                "path"           => $this->urli . "show",
                "method"         => "GET",
                "payload"        => $params['payload'],
                "module_code"    => $this->kode,
                "token"          => $params['token']
            ]
        );

        return json_decode($response, false);
    }

    public function show_from_integration($params)
    {
        $id = $params['id'];
        $payload = $params['payload'];
        $token = $params['token'];
        
        if ($id) {
            $path = "api/pm/mechanic_activity/show_from_integration/" . $id;
        }else{
            $path = "api/pm/mechanic_activity/show_from_integration";
        }

        $params = [
            "path"           => $path,
            "method"         => "GET",
            "payload"        => $payload,
            "module_code"    => "pm_mechanic_activity",
            "token"          => $token
        ];

        $response = $this->curli->request3($params);

        return json_decode($response, false);
    }

    public function insert($params)
    {
        $payload = $params['payload'];
        $token = $params['token'];
        
        $path = "api/pm/mechanic_activity/create";

        $params = [
            "path"           => $path,
            "method"         => "POST",
            "payload"        => $payload,
            "module_code"    => "pm_mechanic_activity",
            "token"          => $token
        ];

        $response = $this->curli->request3($params);

        return json_decode($response, false);
    }

    public function create($params)
    {
        $payload = $params['payload'];
        $token = $params['token'];
        
        $path = "api/pm/mechanic_activity/create";

        $params = [
            "path"           => $path,
            "method"         => "POST",
            "payload"        => $payload,
            "module_code"    => "pm_mechanic_activity",
            "token"          => $token
        ];

        $response = $this->curli->request3($params);

        return json_decode($response, false);
    }

    public function create_with_integration($params)
    {
        $payload = $params['payload'];
        $token = $params['token'];
        
        $path = "api/pm/mechanic_activity/create_with_integration";

        $params = [
            "path"           => $path,
            "method"         => "POST",
            "payload"        => $payload,
            "module_code"    => "pm_mechanic_activity",
            "token"          => $token
        ];

        $response = $this->curli->request3($params);

        return json_decode($response, false);
    }

    public function show_reason($params)
    {
        $response = $this->curli->request4(
            [
                "path"           => $this->urli . "show_reason",
                "method"         => "GET",
                "payload"        => $params['payload'],
                "module_code"    => $this->kode,
                "token"          => $params['token']
            ]
        );

        return json_decode($response, false);
    }
}
