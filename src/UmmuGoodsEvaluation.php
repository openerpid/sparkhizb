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

class UmmuGoodsEvaluation
{
    public function __construct()
    {
        $this->curli = new CurlHelper();
        $this->gHelp = new GlobalHelper();

        $this->kode = "goods_evaluation";

        $this->path = 'api/inventory/goods_evaluation/';
    }

    public function show($params)
    {
        $id = $params['id'];

        if ($id) {
            $show = "show/".$id;
        }else{
            $show = "show";
        }

        $response = $this->curli->request4(
            [
                "path"           => $this->path . $show,
                "method"         => "GET",
                "payload"        => $params['payload'],
                "module_code"    => $this->kode,
                "token"          => $params['token']
            ]
        );

        // return json_decode($response, false);
    }

    public function insert($params)
    {
        $response = $this->curli->request4([
            "path"           => $this->path. "create",
            "method"         => "POST",
            "payload"        => $params["payload"],
            "module_code"    => $this->kode,
            "token"          => $params["token"]
        ]);

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

    public function update($params)
    {
        $response = $this->curli->request4(
            [
                "path"           => $this->path. "update/". $params['id'],
                "method"         => "PUT",
                "payload"        => $params['payload'],
                "module_code"    => $this->kode,
                "token"          => $params['token']
            ]
        );

        return json_decode($response, false);
    }

    public function release($params)
    {
        $response = $this->curli->request4(
            [
                "path"           => $this->path. "release",
                "method"         => "POST",
                "payload"        => $params['payload'],
                "module_code"    => $this->kode,
                "token"          => $params['token']
            ]
        );

        return json_decode($response, false);
    }

    public function approve($params)
    {
        $response = $this->curli->request4(
            [
                "path"           => $this->path. "approve",
                "method"         => "POST",
                "payload"        => $params['payload'],
                "module_code"    => $this->kode,
                "token"          => $params['token']
            ]
        );

        return json_decode($response, false);
    }

    public function update_release($params)
    {
        $response = $this->curli->request4(
            [
                "path"           => $this->path. "update_release",
                "method"         => "PUT",
                "payload"        => $params['payload'],
                "module_code"    => $this->kode,
                "token"          => $params['token']
            ]
        );

        return json_decode($response, false);
    }



    
    /**
     * Create Zone*/
    public function zoneCreate_show($params)
    {
        $response = $this->curli->request4([
            "path"           => $this->path. "zoneCreate_show",
            "method"         => "GET",
            "payload"        => $params["payload"],
            "module_code"    => $this->kode,
            "token"          => $params["token"]
        ]);

        return json_decode($response, false);
    }

    public function zoneCreate_insert($params)
    {
        $response = $this->curli->request4([
            "path"           => $this->path. "zoneCreate_insert",
            "method"         => "POST",
            "payload"        => $params["payload"],
            "module_code"    => $this->kode,
            "token"          => $params["token"]
        ]);

        return json_decode($response, false);
    }

    public function zoneCreate_update($params)
    {
        $response = $this->curli->request4([
            "path"           => $this->path. "zoneCreate_update/". $params['id'],
            "method"         => "PUT",
            "payload"        => $params["payload"],
            "module_code"    => $this->kode,
            "token"          => $params["token"]
        ]);

        return json_decode($response, false);
    }


    /**
     * Process Zone*/
    public function zoneProcess_show($params)
    {
        $response = $this->curli->request4([
            "path"           => $this->path. "zoneProcess_show",
            "method"         => "GET",
            "payload"        => $params["payload"],
            "module_code"    => $this->kode,
            "token"          => $params["token"]
        ]);

        return json_decode($response, false);
    }

    public function zoneProcess_update($params)
    {
        $response = $this->curli->request4([
            "path"           => $this->path. "zoneProcess_update/". $params['id'],
            "method"         => "PUT",
            "payload"        => $params["payload"],
            "module_code"    => $this->kode,
            "token"          => $params["token"]
        ]);

        return json_decode($response, false);
    }


    /**
     * Monitoring Zone*/
    public function zoneMonitoring_show($params)
    {
        $response = $this->curli->request4([
            "path"           => $this->path. "zoneMonitoring_show",
            "method"         => "GET",
            "payload"        => $params["payload"],
            "module_code"    => $this->kode,
            "token"          => $params["token"]
        ]);

        return json_decode($response, false);
    }
}
