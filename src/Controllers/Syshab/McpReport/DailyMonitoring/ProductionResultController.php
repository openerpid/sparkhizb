<?php

namespace Sparkhizb\Controllers\Syshab\McpReport\DailyMonitoring;

use CodeIgniter\RESTful\ResourceController;
use App\Helpers\GlobalHelper;

class ProductionResultController extends ResourceController
{
    public $dir_view;
    public $dir_view2;
    public $db;
    public $mcp;
    public $gHelp;

    public function __construct()
    {
        $this->dir_view = 'pages/mcp_report/production/daily_monitoring/production_result/';
        $this->dir_view2 = 'pages/mcp_report/production/daily_monitoring/equipment_performance/';
        $this->db = \Config\Database::connect();
        $this->mcp = \Config\Database::connect('mcp');
        $this->request = \Config\Services::request();
        $this->gHelp = new GlobalHelper();
    }

    public function index()
    {
        // $data = [
        //     'navlink' => 'Produciton_DailyMonitoring_ProductionResult',
        //     'group' => ['report_production', 'daily_monitoring'],
        //     'tmp' => $this->gHelp->tmp(),
        //     'dir_views' => $this->dir_view,
        //     'crud' => null,
        //     'breadcrumb' => [
        //         [
        //             "name" => "Production",
        //             "page" => "#",
        //             "active" => ""
        //         ],
        //         [
        //             "name" => "Daily Monitoring",
        //             "page" => "#",
        //             "active" => ""
        //         ],
        //         [
        //             "name" => "Production Result",
        //             "page" => "#",
        //             "active" => "active"
        //         ]
        //     ]
        // ];
        // return view($this->dir_view . 'index', $data);
    }

    public function show_all()
    {
        $date1 = $this->request->getVar('tgl');
        $date2 = $this->request->getVar('tgl2');
        $site = $this->request->getVar('site');

        if ($date1 == null) {
            $date1 = date('Ymd');
        }

        if ($date2 == null) {
            $date2 = date('Ymd');
        }

        if ($site == null) {
            $site = 'HO';
        }

        // exec dbo.uSP_0405_SHB_0030B N'SSA',N'20250901',N'20250930'

        $sp = "uSP_0405_SHB_0030B " . $site . "," . $date1 . "," . $date2;

        $builder_perlocate = $this->mcp->query($sp);
        $builder_perlocate->getResultArray();
        $query1 = $builder_perlocate->resultArray;

        // $hauler = [];
        // $loader = [];

        foreach ($query1 as $key => $value) {
            $ProdDate = $value['proddate'];
            // $day_rit = $value['day_rit'];
            // $night_rit = $value['night_rit'];
            // $day = $value['day'];
            // $night = $value['night'];

            $timestamp = strtotime($ProdDate); // Convert the string to a Unix timestamp            
            $dateOnly = date("Y-m-d", $timestamp); // Format the timestamp to the desired date format
            $query1[$key]['proddateonly'] = $dateOnly;
            // $query2[$key]['total'] = number_format($day + $night, 2);
            // $query2[$key]['total_rit'] = number_format($day_rit + $night_rit, 2);
        }

        $response = [
            "status" => true,
            "rows" => $query1,
        ];

        return $this->respond($response, 200);
    }

    public function show_ob()
    {
        $date1 = $this->request->getVar('tgl');
        $date2 = $this->request->getVar('tgl2');
        $site = $this->request->getVar('site');

        if ($date1 == null) {
            $date1 = date('Ymd');
        }

        if ($date2 == null) {
            $date2 = date('Ymd');
        }

        if ($site == null) {
            $site = 'HO';
        }

        // exec dbo.uSP_0405_SHB_0031B N'SSA',N'20240901',N'20250930'
        // exec dbo.uSP_0405_SHB_0032B N'SSA',N'20240901',N'20250930'

        $sp_perlocation = "uSP_0405_SHB_0031B " . $site . "," . $date1 . "," . $date2;
        $sp_pertgl = "uSP_0405_SHB_0032B " . $site . "," . $date1 . "," . $date2;

        $builder_perlocate = $this->mcp->query($sp_perlocation);
        $builder_perlocate->getResultArray();
        $query1 = $builder_perlocate->resultArray;

        $builder_pertgl = $this->mcp->query($sp_pertgl);
        $builder_pertgl->getResultArray();
        $query2 = $builder_pertgl->resultArray;

        foreach ($query2 as $key => $value) {
            $proddate = $value['proddate'];
            $total = $value['total'];
            $planD = $value['planD'];

            $timestamp = strtotime($proddate); // Convert the string to a Unix timestamp            
            $dateOnly = date("Y-m-d", $timestamp); // Format the timestamp to the desired date format

            $query2[$key]['proddateonly'] = $dateOnly;
            $query2[$key]['persen'] = round(($total / $planD) * 100, 2);
        }

        $rows = [
            "perlocation" => [
                "rows" => $query1,
                "count" => count($query1),
                "total" => count($query1),
                "recordsTotal" => count($query1),
                "recordsFiltered" => count($query1),
                "total_count" => 10,
                "incomplete_results" => false
            ],
            "pertgl" => [
                "rows" => $query2,
                "count" => count($query2),
                "total" => count($query2),
                "recordsTotal" => count($query2),
                "recordsFiltered" => count($query2),
                "total_count" => 10,
                "incomplete_results" => false
            ]
        ];

        $response = [
            "status" => true,
            "rows" => $rows,
        ];

        return $this->respond($response, 200);
    }

    public function show_coalhauling_perlocation()
    {
        $date1 = $this->request->getVar('tgl');
        $date2 = $this->request->getVar('tgl2');
        $site = $this->request->getVar('site');

        // exec dbo.uSP_0405_SHB_0033B N'SSA',N'20250901',N'20250930'
        // fr= fuel /  (day  +  night )
        // wh=24 - ( stb  +  bd )
        // PA=( (24  -  bd ) / 24 ) * 100
        // ua=(( (24 - bd - stb ) / (24 -  bd) ) * 100 )

        $sp_perlocation = "uSP_0405_SHB_0033B " . $site . "," . $date1 . "," . $date2;

        $builder_perlocate = $this->mcp->query($sp_perlocation);
        $builder_perlocate->getResultArray();
        $query1 = $builder_perlocate->resultArray;

        $response = [
            "status" => true,
            "rows" => $query1,
        ];

        return $this->respond($response, 200);
    }

    public function show_hauling()
    {
        $date1 = $this->request->getVar('tgl');
        $date2 = $this->request->getVar('tgl2');
        $site = $this->request->getVar('site');

        // if ($date1 == null) {
        //     $date1 = date('Ymd');
        // }

        // if ($date2 == null) {
        //     $date2 = date('Ymd');
        // }

        // if ($site == null) {
        //     $site = 'HO';
        // }

        // exec dbo.uSP_0405_SHB_0033B N'SSA',N'20250901',N'20250930'
        // exec dbo.uSP_0405_SHB_0034B N'SSA',N'20250901',N'20250930'
        // fr= fuel /  (day  +  night )
        // wh=24 - ( stb  +  bd )
        // PA=( (24  -  bd ) / 24 ) * 100
        // ua=(( (24 - bd - stb ) / (24 -  bd) ) * 100 )

        // $sp_perlocation = "uSP_0405_SHB_0033B " . $site . "," . $date1 . "," . $date2;
        $sp_perunit = "uSP_0405_SHB_0034B " . $site . "," . $date1 . "," . $date2;

        // $builder_perlocate = $this->mcp->query($sp_perlocation);
        // $builder_perlocate->getResultArray();
        // $query1 = $builder_perlocate->resultArray;

        $builder_perunit = $this->mcp->query($sp_perunit);
        $builder_perunit->getResultArray();
        $query2 = $builder_perunit->resultArray;

        // $hauler = [];
        // $loader = [];

        foreach ($query2 as $key => $value) {
            $ProdDate = $value['ProdDate'];
            $day_rit = $value['day_rit'];
            $night_rit = $value['night_rit'];
            $day = $value['day'];
            $night = $value['night'];
            $bd = $value['bd'];
            $stb = $value['stb'];
            $fuel = $value['fuel'];

            $timestamp = strtotime($ProdDate); // Convert the string to a Unix timestamp            
            $dateOnly = date("Y-m-d", $timestamp); // Format the timestamp to the desired date format
            $query2[$key]['proddateonly'] = $dateOnly;
            $query2[$key]['total'] = $day + $night;
            $query2[$key]['total_rit'] = $day_rit + $night_rit;
            $query2[$key]['fr'] = $fuel / ($day + $night);
            $query2[$key]['wh'] = 24 - ($stb  +  $bd);
            $query2[$key]['pa'] = ((24  -  $bd) / 24) * 100;
            $query2[$key]['ua'] = (((24 - $bd - $stb) / (24 -  $bd)) * 100);
        }

        // foreach ($query2 as $key => $value) {
        //     // $proddate = $value['proddate'];
        //     // $total = $value['total'];
        //     // $planD = $value['planD'];
        //     $tipe = $value['tipe'];

        //     if ($tipe == "HAULER") {
        //         $hauler[] = $value;
        //     }elseif ($tipe == "LOADER") {
        //         $loader[] = $value;
        //     }

        //     // $timestamp = strtotime($proddate); // Convert the string to a Unix timestamp            
        //     // $dateOnly = date("Y-m-d", $timestamp); // Format the timestamp to the desired date format

        //     // $query2[$key]['proddateonly'] = $dateOnly;
        //     // $query2[$key]['persen'] = round(($total / $planD) * 100,2);
        // }

        // $query2_ = [
        //     "hauler" => $hauler,
        //     "loader" => $loader,
        // ];

        // $rows = [
        //     "perlocation" => $query1,
        //     "perunit" => $query2_
        // ];

        $response = [
            "status" => true,
            // "perlocation" => $query1,
            "rows" => $query2,
            // "perlocation" => $query1,
            // "perunit" => $query2_
        ];

        return $this->respond($response, 200);
    }

    public function show_getting()
    {
        $date1 = $this->request->getVar('tgl');
        $date2 = $this->request->getVar('tgl2');
        $site = $this->request->getVar('site');

        if ($date1 == null) {
            $date1 = date('Ymd');
        }

        if ($date2 == null) {
            $date2 = date('Ymd');
        }

        if ($site == null) {
            $site = 'HO';
        }

        // exec dbo.uSP_0405_SHB_0053A N'SSA',N'20250901',N'20250930'
        // exec dbo.uSP_0405_SHB_0053B N'SSA',N'20250901',N'20250930'

        $sp_perlocation = "uSP_0405_SHB_0053A " . $site . "," . $date1 . "," . $date2;
        $sp_pertgl = "uSP_0405_SHB_0053B " . $site . "," . $date1 . "," . $date2;

        $builder_perlocate = $this->mcp->query($sp_perlocation);
        $builder_perlocate->getResultArray();
        $query1 = $builder_perlocate->resultArray;

        $builder_perunit = $this->mcp->query($sp_pertgl);
        $builder_perunit->getResultArray();
        $query2 = $builder_perunit->resultArray;

        // $hauler = [];
        // $loader = [];

        foreach ($query2 as $key => $value) {
            $ProdDate = $value['proddate'];
            // $day_rit = $value['day_rit'];
            // $night_rit = $value['night_rit'];
            // $day = $value['day'];
            // $night = $value['night'];
            $total = $value['total'];
            $planD = $value['planD'];

            $timestamp = strtotime($ProdDate); // Convert the string to a Unix timestamp            
            $dateOnly = date("Y-m-d", $timestamp); // Format the timestamp to the desired date format
            $query2[$key]['proddateonly'] = $dateOnly;
            // $query2[$key]['total'] = number_format($day + $night, 2);
            // $query2[$key]['total_rit'] = number_format($day_rit + $night_rit, 2);

            $query2[$key]['persen'] = round(($total / $planD) * 100, 2);
        }

        // foreach ($query2 as $key => $value) {
        //     // $proddate = $value['proddate'];
        //     // $total = $value['total'];
        //     // $planD = $value['planD'];
        //     $tipe = $value['tipe'];

        //     if ($tipe == "HAULER") {
        //         $hauler[] = $value;
        //     }elseif ($tipe == "LOADER") {
        //         $loader[] = $value;
        //     }

        //     // $timestamp = strtotime($proddate); // Convert the string to a Unix timestamp            
        //     // $dateOnly = date("Y-m-d", $timestamp); // Format the timestamp to the desired date format

        //     // $query2[$key]['proddateonly'] = $dateOnly;
        //     // $query2[$key]['persen'] = round(($total / $planD) * 100,2);
        // }

        // $query2_ = [
        //     "hauler" => $hauler,
        //     "loader" => $loader,
        // ];

        // $rows = [
        //     "perlocation" => $query1,
        //     "perunit" => $query2_
        // ];

        $response = [
            "status" => true,
            // "rows" => $rows,
            "perlocation" => $query1,
            "pertgl" => $query2
        ];

        return $this->respond($response, 200);
    }
}
