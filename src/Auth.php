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

class Auth
{
    public function __construct()
    {
        $this->curli = new Curl();
    }

    public function login($payload)
    {
        $params = [
            "path" => "auth/login/create",
            "method" => "POST",
            "payload" => $payload,
            "module_code" => null,
            "token" => null
        ];

        $response = $this->curli->request3($params);

        return json_decode($response, false);
        // return $response;
    }

    public function login2($payload)
    {
        $params = [
            "path" => "auth/login/create",
            "method" => "POST",
            "payload" => $payload['payload'],
            "headers" => $payload['headers']
        ];

        $response = $this->curli->ummu2($params);

        return $response;
    }

    public function register($payload)
    {
        // 
    }

    public function get_otp_sms($payload)
    {
        $params = [
            "path" => "auth/otp/sms/create",
            "method" => "POST",
            "payload" => $payload,
            "headers" => array(
                'Content-Type: application/json',
                'Company-Token: ' . getenv('company_token')
            )
        ];

        $response = $this->curli->ummu2($params);

        return $response;
    }

    public function login_with_phone($payload)
    {
        $params = [
            "path" => "auth/login/create_with_phone",
            "method" => "POST",
            "payload" => $payload,
            "headers" => array(
                'Content-Type: application/json',
                // 'Company-Token: '.getenv('company_token'),
                'App-Id: ' . getenv('app_id')
            )
        ];

        $response = $this->curli->ummu2($params);

        return $response;
    }

    public function find_phone_number($payload)
    {
        $params = [
            "path" => "auth/login/find_phone_number",
            "method" => "POST",
            "payload" => $payload,
            "headers" => array(
                'Content-Type: application/json',
                'App-Id: ' . getenv('app_id')
            )
        ];

        $response = $this->curli->ummu2($params);

        return $response;
    }

    public function username($payload)
    {
        $params = [
            "path" => "auth/login/username",
            "method" => "POST",
            "payload" => $payload,
            "module_code" => null,
            "token" => null
        ];

        $response = $this->curli->request3($params);

        return json_decode($response, false);
        // return $response;
    }

    public function create_next($payload)
    {
        $params = [
            "path" => "auth/login/create_next",
            "method" => "POST",
            "payload" => $payload,
            "module_code" => null,
            "token" => null
        ];

        $response = $this->curli->request3($params);

        return json_decode($response, false);
        // return $response;
    }

    public function partisipan($payload)
    {
        $params = [
            "path" => "auth/login/partisipan",
            "method" => "POST",
            "payload" => $payload,
            "module_code" => null,
            "token" => null
        ];

        $response = $this->curli->request3($params);

        return json_decode($response, false);
        // return $response;
    }

    public function is_token($params)
    {
        $response = $this->curli->request4([
            "path" => "auth/is_token",
            "method" => "POST",
            "payload" => null,
            "module_code" => null,
            "token" => $params["token"]
        ]);

        return json_decode($response, false);
    }
}
