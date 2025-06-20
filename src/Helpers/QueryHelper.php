<?php

namespace Sparkhizb\Helpers;

/**
* =============================================
* Author: Ummu
* Website: https://ummukhairiyahyusna.com/
* App: Sparkhizb LIB
* Description: 
* =============================================
*/

// use Sparkhizb\Helpers\DateTimeHelper;
use Sparkhizb\Auth as Openapi2Auth;

class QueryHelper
{
    public function __construct()
    {
        $this->request = \Config\Services::request();
        // $this->dtH = new DateTimeHelper(); /
        // $this->identity = new IdentityHelper(); /
        // $this->ummuMsdb = new UmmuMsdb; /
        $this->oa2auth = new Openapi2Auth;
    }

    public function limit()
    {
        $limit      = $this->request->getVar('limit');
        
        if (!$limit OR $limit=='undefined') {
            $limit = 0;
        }else{
            $limit = $limit;
        }

        return $limit;
    }

    public function offset()
    {
        $offset     = $this->request->getVar('offset');
        
        if (!$offset OR $offset=='undefined' OR $this->search()) {
            $offset = 0;
        }else{
            $offset = $offset;
        }

        return $offset;
    }

    public function sort()
    {
        $sort = $this->request->getVar('sort');
        $order = $this->request->getVar('order');
        
        if (isset($order['name'])) {
            $sort = $order['name'];
        }else{
            if (!$sort OR $sort=='undefined') {
                $sort = 0;
            }else{
                $sort = $sort;
            }
        }

        return $sort;
    }

    public function order()
    {
        $order = $this->request->getVar('order');

        if (isset($order['dir'])) {
            $order = $order['dir'];
        }else{
            if (!$order OR $order=='undefined') {
                $order = 0;
            }else{
                $order = $order;
            }
        }

        return $order;
    }

    public function search()
    {
        $search     = $this->request->getVar('search');

        if (isset($search['value'])) {
            $search = $search['value'];
        }

        return $search;
    }

    public function payload()
    {
        $length = $this->request->getVar('length');
        $start = $this->request->getVar('start');
        $order = $this->request->getVar('order');
        $search = $this->request->getVar('search');

        $payload = [
            "limit"     => $length,
            "offset"    => $start,
            "sort"      => $order['name'],
            "order"     => $order['dir'],
            "search"    => $search['value']
        ];

        return $payload;
    }

    public function totalcount($query)
    {
        $total = $query->countAllResults(false);
        $builder = $query->findAll($this->limit(), $this->offset());
        $count = count($builder);

        $response = [
            "rows"          => $builder,
            "total"         => $total,
            "count"         => $count,
        ];

        return $response;
    }

    public function _total($builder)
    {
        $total = $builder->countAllResults(false);        
        return $total;
    }

    public function _limit($builder)
    {
        $limit = $builder->limit($this->limit(), $this->offset());
        return $limit;
    }

    public function _rows($builder)
    {
        $rows = $builder->findAll($this->limit(), $this->offset());
        return $rows;
    }

    public function _rowsBui($builder)
    {
        $rows = $builder->limit($this->limit(), $this->offset())
        ->get()->getResult();
        return $rows;
    }

    public function _getLastRow($builder)
    {
        $rows = $builder->limit($this->limit(), $this->offset())
        ->get()->getLastRow();
        return $rows;
    }

    // untuk menjumlahkan rows data
    public function _count($rows)
    {
        $count = count($rows);
        return $count;
    }

    public function orderBy($builder, $allowedFields = null)
    {
        $sort = $this->request->getJsonVar('sort');

        if (strpos($sort, ".")) {
            $sort = explode(".",$sort);
            $sortCount = count($sort);
            $sort = $sort[$sortCount-1];
        }
        $order      = $this->request->getJsonVar('order');

        if ($sort && $order) {
            if ($allowedFields) {
                if (in_array($sort, $allowedFields)) {
                    $builder = $builder->orderBy($sort, $order);
                }
            }
        }else{
            if ($allowedFields) {
                if (in_array("id", $allowedFields)) {
                    $builder = $builder->orderBy('id', 'desc');
                }
            }
        }

        return $builder;
    }

    public function orderBy_j($builder, $allowedFields = null)
    {
        $sort = $this->request->getJsonVar('sort');

        if (strpos($sort, ".")) {
            $sort = explode(".",$sort);
            $sortCount = count($sort);
            $sort = $sort[$sortCount-1];
        }
        $order      = $this->request->getJsonVar('order');

        if ($sort && $order) {
            if ($allowedFields) {
                if (in_array($sort, $allowedFields)) {
                    $builder = $builder->orderBy('a.'.$sort, $order);
                }
            }
        }else{
            if ($allowedFields) {
                if (in_array("id", $allowedFields)) {
                    $builder = $builder->orderBy('a.id', 'desc');
                }
            }
        }

        return $builder;
    }

    // untuk membuat list select otomatis saat join table
    public function select_j($fields, $alias)
    {
        $fsl = [];
        foreach ($fields as $key => $value) {
            $fsl[] = $alias.'.'.$value;
        }

        return implode(", ",$fsl);
    }

    public function array_where($array, $field, $val)
    {
        $rows = [];
        foreach ($array as $key => $value) {

            if ($value[$field] == $val) {
                $rows[] = $value;
            }
        }

        return $rows;
    }

    public function array_search($array, $params)
    {
        $search = $this->request->getJsonVar('search');

        if ($search) {

            $rows = [];
            foreach ($array as $key => $value) {

                foreach ($params as $key2 => $value2) {
                    // $contain = str_contains($value[$value2], $search);
                    $contain = strpos(strtoupper($value[$value2]), strtoupper($search));
                    if ($contain !== false) {
                        $rows[] = $value;
                    }
                }
            }

        }else{

            $rows = $array;

        }

        return $rows;
    }

    public function array_paging($array)
    {
        $limit = $this->request->getJsonVar('limit');
        $offset = $this->request->getJsonVar('offset');
        $search = $this->request->getJsonVar('search');

        if ($search) {
            $offset = 0;
        }

        if ($limit == 0 OR $limit == 'undefined') {
            $rows = $array;
        }else{
            $rows = array_slice($array, $offset, $limit);
        }

        $response = [
            "rows"      => $rows, 
            "count"     => count($rows),
            "total"     => count($array)
        ];

        return $response;
    }

    public function response_true($rows,$count,$total)
    {
        $response = [
            "status"    => true,
            "message"   => 'Get data success',
            "rows"      => $rows,
            "count"     => $count,
            "total"     => $total
        ];

        return $response;
    }

    public function response_false()
    {
        $response = [
            "status"    => false,
            "message"   => 'Data not found.',
            "rows"      => [],
        ];

        return $response;
    }

    public function restrue($rows,$count,$total)
    {
        if ($count == 0) {
            $msg = 'Data not found';
        }else{
            $msg = 'Get data success';
        }

        $response = [
            "status"            => true,
            "message"           => $msg,
            "rows"              => $rows,
            "count"             => $count,
            "total"             => $total,
            "recordsTotal"      => $total,
            "recordsFiltered"   => $total,
        ];

        return $response;
    }

    public function resfalse($builder)
    {
        $response = [
            "status"    => false,
            "message"   => $builder,
        ];

        return $response;
    }

    public function respon($rows,$count,$total)
    {
        if ($count > 0) {
            $sts = true;
            $msg = 'Get data success';
            $code = 200;
        }else{
            $sts = false;
            $msg = 'Data not found';
            $code = 404;
        }

        $response = [
            "status"                => $sts,
            "message"               => $msg,
            "rows"                  => $rows,
            "count"                 => $count,
            "total"                 => $total,
            "recordsTotal"          => $total,
            "recordsFiltered"       => $total,
            "scode"                 => $code,
            "total_count"           => $count,
            "incomplete_results"    => false,
            // "filter"            => [
            //     "search" => $this->request->getJsonVar("search"),
            //     "datetime_detail" => [
            //         "from" => $this->dtH->dt
            //     ]
            // ]
        ];

        return $response;
    }

    public function rescr($builder)
    {
        if($builder) {
            $response = [
                "status" => true,
                "message" => 'Insert data success.',
                "response" => $builder,
            ];
        } else {
            $response = [
                "status" => false,
                "message" => 'Insert data failed!',
                "response" => $builder,
            ];
        }

        return $response;
    }

    public function resupd($builder)
    {
        if($builder) {
            $response = [
                "status" => true,
                "message" => 'Update data success.',
                "response" => $builder,
            ];
        } else {
            $response = [
                "status" => false,
                "message" => 'Update data failed!',
                "response" => $builder,
            ];
        }

        return $response;
    }

    public function resapv($builder)
    {
        if($builder) {
            $response = [
                "status" => true,
                "message" => 'Approve success.',
                "response" => $builder,
            ];
        } else {
            $response = [
                "status" => false,
                "message" => 'Approve failed!',
                "response" => $builder,
            ];
        }

        return $response;
    }

    public function allowedFields()
    {
        return [
            "id",
            "company_id",

            "site_project_id",
            "site_project_kode",

            "plant_id",
            "plant_kode",

            "departement_id",
            "departement_kode",

            "created_at","created_by",
            "updated_at","updated_by",
            "deleted_at","deleted_by"
        ];
    }

    public function withMsdb($tokenmsdb = null)
    {
        $msdb_token = $this->request->header("Msdb-Token");

        if ($msdb_token) {
            $tokenmsdb = $msdb_token->getValue();
        }

        if (getenv('msdb') === 'true') {
            $payload = [
                "limit" => 0,
                "offset" => 0,
                "sort" => "id",
                "order" => "desc",
                "search" => "",
                "token" => $tokenmsdb
            ];

            $params = [
                "id" => null,
                "payload" => $payload,
                "token" => getenv('company_token')
            ];

            $builder = $this->oa2auth->show_msdb($params);
            if ($builder->status == true) {
                $row = $builder->rows[0];

                if (getenv('dbconn') == 'local') {
                    $host = $row->localhost;
                } else {
                    $host = $row->host;
                }

                $custom = [
                    'DSN' => '',
                    'hostname' => base64_decode($host),
                    'username' => base64_decode($row->username),
                    'password' => base64_decode($row->password),
                    'database' => base64_decode($row->dbname),
                    'DBDriver' => base64_decode($row->dbdriver),
                    'DBPrefix' => '',
                    'pConnect' => false,
                    'DBDebug' => true,
                    'charset' => 'utf8',
                    'DBCollat' => 'utf8_general_ci',
                    'swapPre' => '',
                    'encrypt' => false,
                    'compress' => false,
                    'strictOn' => false,
                    'failover' => [],
                    'port' => base64_decode($row->port),
                ];

                return $custom;
            }
        } else {
            $custom = [
                'DSN' => '',
                'hostname' => getenv('database.msdb.hostname'),
                'username' => getenv('database.msdb.username'),
                'password' => getenv('database.msdb.password'),
                'database' => getenv('database.msdb.database'),
                'DBDriver' => getenv('database.msdb.DBDriver'),
                'DBPrefix' => '',
                'pConnect' => false,
                'DBDebug' => true,
                'charset' => 'utf8',
                'DBCollat' => 'utf8_general_ci',
                'swapPre' => '',
                'encrypt' => false,
                'compress' => false,
                'strictOn' => false,
                'failover' => [],
                'port' => getenv('database.msdb.port'),
            ];

            return $custom;
        }
    }

    public function withoutMsdb($dbdriver = null, $port = null)
    {
        $hostname = $this->request->getVar("hostname");
        $username = $this->request->getVar("username");
        $password = $this->request->getVar("password");
        $database = $this->request->getVar("database");
        $dbdriver = $this->request->getVar("dbdriver");
        $port = $this->request->getVar("port");
        $encrypter = $this->request->getVar("encrypter");

        if ($encrypter == "base64") {
            $h = base64_decode($hostname);
            $u = base64_decode($username);
            $p = base64_decode($password);
            $d = base64_decode($database);
            $dd = base64_decode($dbdriver);
            $port = base64_decode($port);
        }

        $custom = [
            'DSN' => '',
            'hostname' => $h,
            'username' => $u,
            'password' => $p,
            'database' => $d,
            'DBDriver' => ($dbdriver) ? $dbdriver : $dd,
            'DBPrefix' => '',
            'pConnect' => false,
            'DBDebug' => true,
            'charset' => 'utf8',
            'DBCollat' => 'utf8_general_ci',
            'swapPre' => '',
            'encrypt' => false,
            'compress' => false,
            'strictOn' => false,
            'failover' => [],
            'port' => 1433,
        ];

        return $custom;
    }
}
