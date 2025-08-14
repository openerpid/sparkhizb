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

class UmmuKunjunganKlinik
{
    public function __construct()
    {
        $this->kode = "she_kunjungan_klinik";

        $this->curli = new CurlHelper();
        $this->gHelp = new GlobalHelper();
        $this->umHelp = new UmmuHelper();
        
        $this->umHelp->autoHelper($this->kode);
        $this->urli = 'api/she/kunjungan_klinik/';
    }

    public function show($params)
    {
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

    public function insert($params)
    {
        $response = $this->curli->request4([
            "path"           => $this->urli. "create",
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
                "path"           => $this->urli. "delete",
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
        $id = $params['id'];

        $response = $this->curli->request4(
            [
                "path"           => $this->urli. "update/". $id,
                "method"         => "PUT",
                "payload"        => $params['payload'],
                "module_code"    => $this->kode,
                "token"          => $params['token']
            ]
        );

        return json_decode($response, false);
    }

    // public function release($params)
    // {
    //     $response = $this->curli->request4(
    //         [
    //             "path"           => $this->urli. "release",
    //             "method"         => "POST",
    //             "payload"        => $params['payload'],
    //             "module_code"    => $this->kode,
    //             "token"          => $params['token']
    //         ]
    //     );

    //     return json_decode($response, false);
    // }

    // public function approve($params)
    // {
    //     $response = $this->curli->request4(
    //         [
    //             "path"           => $this->urli. "approve",
    //             "method"         => "POST",
    //             "payload"        => $params['payload'],
    //             "module_code"    => $this->kode,
    //             "token"          => $params['token']
    //         ]
    //     );

    //     return json_decode($response, false);
    // }

    // public function update_release($params)
    // {
    //     $response = $this->curli->request4(
    //         [
    //             "path"           => $this->urli. "update_release",
    //             "method"         => "PUT",
    //             "payload"        => $params['payload'],
    //             "module_code"    => $this->kode,
    //             "token"          => $params['token']
    //         ]
    //     );

    //     return json_decode($response, false);
    // }

    public function show_icd($params)
    {
        $response = $this->curli->request4(
            [
                "path"           => $this->urli . "show_icd",
                "method"         => "GET",
                "payload"        => $params['payload'],
                "module_code"    => $this->kode,
                "token"          => $params['token']
            ]
        );

        return json_decode($response, false);
    }

    public function show_obat($params)
    {
        $response = $this->curli->request4(
            [
                "path"           => $this->urli . "show_obat",
                "method"         => "GET",
                "payload"        => $params['payload'],
                "module_code"    => $this->kode,
                "token"          => $params['token']
            ]
        );

        return json_decode($response, false);
    }
}
