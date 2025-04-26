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

class UmmuTelegram
{
    public function __construct()
    {
        $this->curli = new Curl();
    }

    public function bot($params)
    {
        '{
            "chatId": -4178757472,
            "messageText": [
                "Ini adalah data PO",
                "Hanya data coba-coba",
                "sedang bahagia",
                "Ali dan Ummu selalu"
            ],
            "keyboard": [
                [
                    {
                        "text": "link", 
                        "url": "https://core.telegram.org"
                    },
                    {
                        "text": "DORBITT", 
                        "url": "https://dorbitt.com"
                    }
                ]
            ]
        }'


        $payload = $params['payload'];
        $token = $params['token'];
        
        $path = "api/telegram/bot/send_message";

        $params = [
            "path"           => $path,
            "method"         => "POST",
            "payload"        => $payload,
            "module_code"    => "telegram_bot",
            "token"          => $token
        ];

        $response = $this->curli->request3($params);

        return json_decode($response, false);
    }

    // public function show_gedung($params)
    // {
    //     $payload = $params['payload'];
    //     $token = $params['token'];
        
    //     $path = "api/ruangan/show_gedung";

    //     $params = [
    //         "path"           => $path,
    //         "method"         => "GET",
    //         "payload"        => $payload,
    //         "module_code"    => "ruangan",
    //         "token"          => $token
    //     ];

    //     $response = $this->curli->request3($params);

    //     return json_decode($response, false);
    // }

    // public function show_roomcateg($params)
    // {
    //     $payload = $params['payload'];
    //     $token = $params['token'];
        
    //     $path = "api/ruangan/show_roomcateg";

    //     $params = [
    //         "path"           => $path,
    //         "method"         => "GET",
    //         "payload"        => $payload,
    //         "module_code"    => "ruangan",
    //         "token"          => $token
    //     ];

    //     $response = $this->curli->request3($params);

    //     return json_decode($response, false);
    // }

    // public function show_gallery($params)
    // {
    //     $payload = $params['payload'];
    //     $token = $params['token'];
        
    //     $path = "api/ruangan/show_gallery";

    //     $params = [
    //         "path"           => $path,
    //         "method"         => "GET",
    //         "payload"        => $payload,
    //         "module_code"    => "ruangan",
    //         "token"          => $token
    //     ];

    //     $response = $this->curli->request3($params);

    //     return json_decode($response, false);
    // }

    // public function insert($params)
    // {
    //     $payload = $params['payload'];
    //     $token = $params['token'];
        
    //     $path = "api/ruangan/create";

    //     $params = [
    //         "path"           => $path,
    //         "method"         => "POST",
    //         "payload"        => $payload,
    //         "module_code"    => "ruangan",
    //         "token"          => $token
    //     ];

    //     $response = $this->curli->request3($params);

    //     return json_decode($response, false);
    // }

    // public function update($params)
    // {
    //     $id = $params['id'];
    //     $payload = $params['payload'];
    //     $token = $params['token'];
        
    //     $path = "api/ruangan/update/" . $id;

    //     $params = [
    //         "path"           => $path,
    //         "method"         => "PUT",
    //         "payload"        => $payload,
    //         "module_code"    => "ruangan",
    //         "token"          => $token
    //     ];

    //     $response = $this->curli->request3($params);

    //     return json_decode($response, false);
    // }

    // public function delete($params)
    // {
    //     $id = $params['id'];
    //     $payload = $params['payload'];
    //     $token = $params['token'];
        
    //     if ($id) {
    //         $path = "api/ruangan/delete/" . $id;
    //     }else{
    //         $path = "api/ruangan/delete";
    //     }

    //     $params = [
    //         "path"           => $path,
    //         "method"         => "DELETE",
    //         "payload"        => $payload,
    //         "module_code"    => "ruangan",
    //         "token"          => $token
    //     ];

    //     $response = $this->curli->request3($params);

    //     return json_decode($response, false);
    // }
}
