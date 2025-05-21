<?php

namespace App\Hizb\Builder;

use Sparkhizb\Helpers\Curl;
use Sparkhizb\Helpers\CurlHelper;
use Sparkhizb\Helpers\RequestHelper;
use SaintSystems\OData\ODataClient;
use Sparkhizb\UmmuWorkorder;

class WorkorderBuilder
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->request = \Config\Services::request();
        $this->curl = new Curl();
        $this->curlH = new CurlHelper();
        $this->reqH = new RequestHelper();
        $this->ummu = new UmmuWorkorder();
    }

    public function show($id = null)
    {
        $payload = [
            "limit" => 10,
            "offset" => 0,
            "sort" => "id",
            "order" => "desc",
            "search" => "",
            "selects" => "*"
        ];

        $params = [
            "id" => $id,
            "payload" => $payload,
            "token" => $this->reqH->myToken()
        ];

        $builder = $this->ummu->show($params);
        return $builder;
    }

    public function insert($body)
    {
        // 
    }

    public function show_operation_maintenance()
    {
        // 
    }

    public function show_reason()
    {
        // 
    }

    public function show_from_sap()
    {
        // $curl = curl_init();

        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => 'https://192.168.7.32:44300/sap/dorbitt/workorder?sap-client=110',
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => '',
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 0,
        //     CURLOPT_FOLLOWLOCATION => true,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => 'GET',
        //     CURLOPT_POSTFIELDS => '{ 
        //         "STARTDATE": "01.09.2023",
        //         "ENDDATE": "27.09.2023" 
        //     }',
        //     CURLOPT_HTTPHEADER => array(
        //         'Content-Type: application/json',
        //         'Authorization: Basic SENfQUxJOmQzdkhpbGxjb24hISFAIyQ='
        //     ),
        // ));

        // $response = curl_exec($curl);

        // curl_close($curl);

        // if ($response == false) {
        //     $jsondata = file_get_contents(base_url('sample_resdata_wosap.json'));
        //     $response = json_decode($jsondata, true);
        // } else {
        //     $response = json_decode($response, true);
        // }

        // return $response;

        $client = 240;
        $url = 'https://192.168.7.32:44300/sap/dorbitt/workorder?sap-client=' . $client;

        $params = [
            "url" => $url,
            "method" => 'GET',
            "payload" => [],
            "headers" => [
                "auth" => 'SENfQUxJOmQzdkhpbGxjb24hISFAIyQl'
            ]
        ];
        $builder = $this->curlH->ummu3($params);

        return $builder;
    }

    public function do_paging($array)
    {
        $limit = $this->request->getJsonVar('limit');
        $offset = $this->request->getJsonVar('offset');
        $short = $this->request->getJsonVar('short');
        $order = $this->request->getJsonVar('order');
        $search = $this->request->getJsonVar('search');

        if ($limit == 0 or $limit == 'undefined') {
            $rows = $array;
        } else {
            $rows = array_slice($array, $offset, $limit, true);
        }

        $response = [
            "rows" => $rows,
            "count" => count($rows),
            "total" => count($array)
        ];

        return $response;
    }

    public function do_searching($array)
    {
        $limit = $this->request->getJsonVar('limit');
        $offset = $this->request->getJsonVar('offset');
        $short = $this->request->getJsonVar('short');
        $order = $this->request->getJsonVar('order');
        $search = $this->request->getJsonVar('search');

        if ($search) {
            $rows = [];
            foreach ($array as $key => $value) {
                $AUFNR_order = str_contains($value['AUFNR_order'], $search);
                $AUART_orderType = str_contains($value['AUART_orderType'], $search);
                $WERKS_plant = str_contains($value['WERKS_plant'], $search);
                $KTEXT_description = str_contains($value['KTEXT_description'], $search);
                $TIDNR_techIdentNo = str_contains($value['TIDNR_techIdentNo'], $search);
                $VORNR_operation = str_contains($value['VORNR_operation'], $search);
                $LTXA1_operationShortText = str_contains($value['LTXA1_operationShortText'], $search);

                if ($AUFNR_order or $AUART_orderType or $WERKS_plant or $KTEXT_description or $TIDNR_techIdentNo or $VORNR_operation or $LTXA1_operationShortText) {
                    $rows[] = $value;
                }
            }
        } else {
            $rows = $array;
        }

        return $rows;
    }

    public function show_from_sap_odata($params)
    {
        $url = 'https://192.168.7.32:44300/sap/opu/odata/sap/ZI_WO/ZI_ALI_WO?' . $params;

        $params = [
            "url" => $url,
            "method" => 'GET',
            "payload" => [],
            "headers" => [
                "auth" => 'SENfQUxJOmQzdkhpbGxjb24hISFAIyQl'
            ]
        ];
        $builder = $this->curlH->ummu3($params);

        return $builder;
    }

    public function show_notif($order_number, $operation_order)
    {
        // https://192.168.7.32:44300/sap/opu/odata/sap/ZI_WO/ZI_ALI_WO(order_number='710000000025',operation_order='1000000184')/to_notif

        // $url = "https://192.168.7.32:44300/sap/opu/odata/sap/ZI_WO/ZI_ALI_WO(order_number=\'" . $order_number . "\',operation_order=\'" . $operation_order . "\')/to_notif" . "?%24format=json";
        $url = "https://192.168.7.32:44300/sap/opu/odata/sap/ZI_WO/ZI_ALI_WO(order_number='" . $order_number . "',operation_order='" . $operation_order . "')/to_notif?%24format=json";

        $params = [
            "url" => $url,
            "method" => 'GET',
            "payload" => [],
            "headers" => [
                "auth" => 'SENfQUxJOmQzdkhpbGxjb24hISFAIyQl'
            ]
        ];
        $builder = $this->curlH->ummu3($params);

        return $builder;
    }

    public function show_operationItem($order_number, $operation_order)
    {
        // $url = 'https://192.168.7.32:44300/sap/opu/odata/sap/ZI_WO/ZI_ALI_WO(order_number=\'710000000025\',operation_order=\'1000000184\')/to_operationItem?%24format=json';
        $url = 'https://192.168.7.32:44300/sap/opu/odata/sap/ZI_WO/ZI_ALI_WO%28order_number%3D%27' . $order_number . '%27%2Coperation_order%3D%27' . $operation_order . '%27%29/to_operationItem?%24format=json';

        /* $curl = curl_init();

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
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic SENfQUxJOmQzdkhpbGxjb24hISFAIyQl',
                'Cookie: SAP_SESSIONID_DS4_240=dHhdUh2tXdEt2TNuixRRozsRELMJKBHwrvMAUFaTR3Q%3d; sap-usercontext=sap-client=240'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response); */

        $params = [
            "url" => $url,
            "method" => 'GET',
            "payload" => [],
            "headers" => [
                'Authorization: Basic SENfQUxJOmQzdkhpbGxjb24hISFAIyQl',
                'Cookie: sap-usercontext=sap-client=240'
            ]
        ];
        $builder = $this->curlH->ummu4($params);

        return $builder;
    }

    public function show_from_jsonfile()
    {

    }
}