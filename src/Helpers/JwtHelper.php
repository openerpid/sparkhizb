<?php

namespace Sparkhizb\Helpers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtHelper 
{
    public function __construct()
    {
        $this->key = getenv('TOKEN_SECRET');
        $this->request = \Config\Services::request();
    }

    public function encode($params)
    {
        $data = array(
            'iat' => 1356999524,
            'nbf' => 1357000000,
            'dev'   => 'https://openapi2.com/',
            'lib' => 'https://sparkhizb.my.id/',
            'frmwk' => 'https://codeigniter.com/'
        );
        $payload = array_merge($params,$data);

        $token = JWT::encode($payload, $this->key, 'HS256');

        return $token;
    }

    public function decode($token=null)
    {
        if ($token==null) {
            $header = $this->request->getServer('HTTP_AUTHORIZATION');
            if(!$header) return $this->failUnauthorized('Token Required');
            $token = explode(' ', $header)[1];
        }else{
            $token = $token;
        }

        $decoded = JWT::decode($token, new Key($this->key, 'HS256'));
        
        return $decoded;
    }
    
}