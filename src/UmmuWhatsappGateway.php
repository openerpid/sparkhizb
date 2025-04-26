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

class UmmuWhatsappGateway
{
    public function __construct()
    {
        $this->kode = "whatsapp_gateway";

        $this->curli = new CurlHelper();
        $this->gHelp = new GlobalHelper();
        $this->umHelp = new UmmuHelper();
        
        $this->umHelp->autoHelper($this->kode);
        $this->urli = 'api/lib/whatsapp_gateway/';
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

    public function send_message($params)
    {
        // $curl = curl_init();

        // curl_setopt_array($curl, array(
        //   CURLOPT_URL => 'http://localhost:8080/api/lib/whatsapp_gateway/send_message',
        //   CURLOPT_RETURNTRANSFER => true,
        //   CURLOPT_ENCODING => '',
        //   CURLOPT_MAXREDIRS => 10,
        //   CURLOPT_TIMEOUT => 0,
        //   CURLOPT_FOLLOWLOCATION => false,
        //   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //   CURLOPT_CUSTOMREQUEST => 'POST',
        //   CURLOPT_POSTFIELDS =>'{
        //   "number": "085853383750",
        //   "message": "Testing kirim pesan"
        // }',
        //   CURLOPT_HTTPHEADER => array(
        //     'Content-Type: application/json',
        //     'Module-Code: whatsapp_gateway',
        //     'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjExIiwiY29tcGFueV9pZCI6IjQiLCJ1c2VyX2lkIjoiMCIsImlkZW50aXR5X2lkIjoiMCIsIm5hbWUiOiIiLCJ1c2VybmFtZSI6ImRldmVsb3BtZW50QGhpbGxjb25jb250cmFjdG9yLmNvbSIsInJvbGVfaWQiOiIyIiwicm9sZV9uYW1lIjoiQWRtaW4iLCJsZXZlbF9pZCI6bnVsbCwicGhvbmVfbnVtYmVyIjpudWxsLCJlbWFpbCI6bnVsbCwiYXZhdGFyIjoiMTcwMDAzMzkwMV80M2Y4ZDdiNmFhZjkzNmZkMDE4Yi5pY28iLCJjb21wYW55IjoiUFQuIEhJTExDT05KQVlBIFNBS1RJIiwiY29tcGFueV9rb2RlIjoiSElMTCIsImFwcCI6bnVsbCwiY29tcGFueV9yb2xlX2xpc3QiOlt7ImlkIjoiMiIsIm5hbWUiOiJBZG1pbiJ9LHsiaWQiOiI0IiwibmFtZSI6Ikthcnlhd2FuIn0seyJpZCI6IjUiLCJuYW1lIjoiTWFuYWplciJ9LHsiaWQiOiI2IiwibmFtZSI6IkRpcmVrdHVyIn1dLCJpYXQiOjEzNTY5OTk1MjQsIm5iZiI6MTM1NzAwMDAwMCwiZGV2IjoiaHR0cHM6Ly9kb3JiaXR0LmNvbS8ifQ.EngsIreu6cBWVgYjPolElLhHY0w2Nq-uQzuvWzRkfv8'
        //   ),
        // ));

        // $response = curl_exec($curl);

        // curl_close($curl);
        // echo $response;
        
        $response = $this->curli->request4([
            "path"           => $this->urli. "send_message",
            "method"         => "POST",
            "payload"        => $params["payload"],
            "module_code"    => $this->kode,
            "token"          => $params["token"]
        ]);

        return json_decode($response, false);
    }
}
