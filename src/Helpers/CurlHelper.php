<?php

namespace Sparkhizb\Helpers;

/**
* =============================================
* Author: Ummu
* Website: https://ummukhairiyahyusna.com/
* App: DORBITT LIB
* Description: 
* =============================================
*/

class CurlHelper
{
    public function __construct()
    {
        if (getenv("CI_DORBITT")=="development") {
            $this->url = "http://localhost:8080/v1/";
        }elseif (getenv("CI_DORBITT")=="testing") {
            $this->url = "http://testing-api.dorbitt.com/v1/";
        }else{
            $this->url = "https://api.dorbitt.com/v1/";
        }

        if (getenv("DORBITT_TOKEN")) {
            $this->token = getenv("DORBITT_TOKEN");
        }else{
            $this->token = "";
        }
    }

    public function valcurl()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        $curlresult=curl_exec ($ch);
        curl_close ($ch);
        
        if (!preg_match("/OK/i", $curlresult))
        return "The curl action has FAILED! (OUTPUT of curl is: ".$curlresult."), please check your internet connection";
    }

    public function request($url,$method,$payload,$module_code,$token = null)
    {
        if ($token == null) {
            $tokenz = $this->token;
        }else{
            $tokenz = $token;
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->url . $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Module-Code: '. $module_code,
                'Authorization: Bearer ' . $tokenz
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }

    public function request2($params)
    {
        $url            = $params['url'];
        $method         = $params['method'];
        $payload        = $params['payload'];
        $module_code    = $params['module_code'];
        $token          = $params['token'];

        if ($token == null) {
            $token = $this->token;
        }elseif ($token == 'session') {
            $token = session()->get('token');
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->url . $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Module-Code: '. $module_code,
                'Authorization: Bearer ' . $token
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }

    public function request3($params)
    {
        $path           = $params['path'];
        $method         = $params['method'];
        $payload        = $params['payload'];
        $module_code    = $params['module_code'];
        $token          = $params['token'];

        if ($token == null) {
            $token = $this->token;
        }elseif ($token == 'session') {
            $token = session()->get('token');
        }

        $url_ = $this->url . $path;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url_,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Module-Code: '. $module_code,
                'Authorization: Bearer ' . $token
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }

    public function request4($params)
    {
        $path           = $params['path'];
        $method         = $params['method'];
        $payload        = $params['payload'];
        $module_code    = $params['module_code'];
        $token          = $params['token'];

        if ($token == null) {
            $token = $this->token;
        }

        if ($token == 'session') {
            $token = session()->get('token');
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->url . $path,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Module-Code: '. $module_code,
                'Authorization: Bearer ' . $token
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }

    /**
     * Full url dari params
     * */
    public function ummu($params)
    {
        $url            = $params['url'];
        $method         = $params['method'];
        $payload        = $params['payload'];
        $headers        = $params['headers'];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => $headers,
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response, false);
    }

    /**
     * url hanya path saja*/
    public function ummu2($params)
    {
        $path           = $params['path'];
        $method         = $params['method'];
        $payload        = $params['payload'];
        $headers        = $params['headers'];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->url . $path,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => $headers,
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response, false);
    }

    /**
     * Full url dari params
     * Tanpa SSL
     * auth basic
     * */
    public function ummu3($params)
    {
        $url            = $params['url'];
        $method         = $params['method'];
        $payload        = $params['payload'];
        $headers        = $params['headers'];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => false,

            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            // CURLOPT_HTTPHEADER => array(
            //     "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36",
            //     "Accept-Language:en-US,en;q=0.5"
            // ),
            // CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,

            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => json_encode($payload),
            // CURLOPT_HTTPHEADER => $headers,
            // CURLOPT_HTTPHEADER => array(
            //     'Content-Type: application/json',
            //     'dataType: json',
            //     'Authorization: Basic SENfQUxJOmQzdkhpbGxjb24hISFAIyQl'
            // ),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'dataType: json',
                'Authorization: Basic '.$headers['auth'],
                'Cookie: SAP_SESSIONID_DS4_240=dHhdUh2tXdEt2TNuixRRozsRELMJKBHwrvMAUFaTR3Q%3d; sap-usercontext=sap-client=240'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response, false);
    }


    /**
     * Full url from params
     * Tanpa SSL
     * auth basic
     * headers from params
     * */
    public function ummu4($params)
    {
        $url            = $params['url'];
        $method         = $params['method'];
        $payload        = $params['payload'];
        $headers        = $params['headers'];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => false,

            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,

            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => $headers,
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response, false);
    }

    public function efaktur($url)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // return $response;

        $newArr = (array)simplexml_load_string($response);

        return $newArr;
    }

    public function efaktur2($url)
    {
        // $url = $this->request->getJsonVar('efaktur_url');
        // $xmlfile = file_get_contents($response); 
        // $data = simplexml_load_string($xmlfile); 
        // $con = json_encode($data); 
        // $newArr = json_decode($con, true);
        
        $xmlfile = file_get_contents($url); 
        $new = simplexml_load_string($xmlfile); 
        $con = json_encode($new); 
        $newArr = json_decode($con, true);

        return $newArr;
    }

    public function form($params)
    {
        $path           = $params['path'];
        $method         = $params['method'];
        $payload        = $params['payload'];
        $module_code    = $params['module_code'];
        $token          = $params['token'];

        if ($token == null) {
            $token = $this->token;
        }elseif ($token == 'session') {
            $token = session()->get('token');
        }

        $url_ = $this->url . $path;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url_,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: multipart/form-data',
                'Module-Code: '. $module_code,
                'Authorization: Bearer ' . $token
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }
}
