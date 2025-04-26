<?php

namespace Sparkhizb\Artisan;

/**
* =============================================
* Author: Ummu
* Website: https://ummukhairiyahyusna.com/
* App: DORBITT LIB
* Description: 
* =============================================
*/

use Sparkhizb\Artisan\Curl;

class UmmuPosts
{
    public static function show($params)
    {
        $id = $params['id'];
        $payload = $params['payload'];
        $token = $params['token'];
        
        if ($id) {
            $path = "api/blog/posts/show/" . $id;
        }else{
            $path = "api/blog/posts/show";
        }

        $params = [
            "path"           => $path,
            "method"         => "GET",
            "payload"        => $payload,
            "module_code"    => "posts",
            "token"          => $token
        ];

        $response = Curl::request($params);

        return json_decode($response, false);
        // return $response;
    }

    public static function show_categories($params)
    {
        $payload = $params['payload'];
        $token = $params['token'];
        
        $path = "api/blog/posts/show_categories";

        $params = [
            "path"           => $path,
            "method"         => "GET",
            "payload"        => $payload,
            "module_code"    => "posts",
            "token"          => $token
        ];

        $response = Curl::request($params);

        return json_decode($response, false);
    }

    public static function show_format($params)
    {
        $payload = $params['payload'];
        $token = $params['token'];
        
        $path = "api/blog/posts/show_format";

        $params = [
            "path"           => $path,
            "method"         => "GET",
            "payload"        => $payload,
            "module_code"    => "posts",
            "token"          => $token
        ];

        $response = Curl::request($params);

        return json_decode($response, false);
    }

    public static function show_news($params)
    {
        $slug = $params['slug'];
        $payload = $params['payload'];
        $token = $params['token'];
        
        $path = "api/blog/posts/show_news/" . $slug;

        $params = [
            "path"           => $path,
            "method"         => "GET",
            "payload"        => $payload,
            "module_code"    => "posts",
            "token"          => $token
        ];

        $response = Curl::request($params);

        return json_decode($response, false);
    }

    public static function create($params)
    {
        $params = [
            "path"           => "api/blog/posts/create",
            "method"         => "POST",
            "payload"        => $payload,
            "module_code"    => "posts",
            "token"          => $token
        ];

        $response = Curl::request($params);

        return json_decode($response, false);
    }

    public static function update($params)
    {
        $params = [
            "path"           => "api/blog/posts/create",
            "method"         => "POST",
            "payload"        => $payload,
            "module_code"    => "posts",
            "token"          => $token
        ];

        $response = Curl::request($params);

        return json_decode($response, false);
    }

    public function delete($params)
    {
        $id = $params['id'];
        $payload = $params['payload'];
        $token = $params['token'];
        
        if ($id) {
            $path = "api/blog/posts/delete/" . $id;
        }else{
            $path = "api/blog/posts/delete";
        }

        $params = [
            "path"           => $path,
            "method"         => "DELETE",
            "payload"        => $payload,
            "module_code"    => "posts",
            "token"          => $token
        ];

        $response = Curl::request($params);

        return json_decode($response, false);
    }
}
