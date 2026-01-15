<?php

namespace Sparkhizb\Controllers\Syshab\McpReport\DailyMonitoring;

use CodeIgniter\RESTful\ResourceController;
use App\Helpers\GlobalHelper;

class EquipmentPerformanceController extends ResourceController
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
        //     'navlink' => 'Produciton_DailyMonitoring_EquipmentPerformance',
        //     'group' => ['report_production', 'daily_monitoring'],
        //     'tmp' => $this->gHelp->tmp(),
        //     'dir_views' => $this->dir_view2,
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
        //             "name" => "Equipment Performance",
        //             "page" => "#",
        //             "active" => "active"
        //         ]
        //     ]
        // ];
        // return view($this->dir_view2 . 'index', $data);
    }

    /* Tab All */
    public function show_equipment_performance_all_daily()
    {
        $date1 = $this->request->getVar('tgl');
        $date2 = $this->request->getVar('tgl2');
        $site = $this->request->getVar('site');

        // exec dbo.uSP_0405_SHB_0063 N'SSA',N'20250901',N'20250930'
        $sp = "uSP_0405_SHB_0063 " . $site . "," . $date1 . "," . $date2;

        $builder = $this->mcp->query($sp);
        $builder->getResultArray();
        $builder = $builder->resultArray;

        foreach ($builder as $key => $value) {
            $tipe = $value['tipe'];
            $unit_code = $value['unit_code'];
            $ProdDate = $value['ProdDate'];

            $day_rit_ob = $value['day_rit_ob'];
            $night_rit_ob = $value['night_rit_ob'];
            $day_ob = $value['day_ob'];
            $night_ob = $value['night_ob'];

            $day_rit_cg = $value['day_rit_cg'];
            $night_rit_cg = $value['night_rit_cg'];
            $day_cg = $value['day_cg'];
            $night_cg = $value['night_cg'];

            $day_rit_cl = $value['day_rit_cl'];
            $night_rit_cl = $value['night_rit_cl'];
            $day_cl = $value['day_cl'];
            $night_cl = $value['night_cl'];

            $fuel = $value['fuel'];
            $stb = $value['stb'];
            $bd = $value['bd'];
            $idle = $value['idle'];
            $mohh = $value['mohh'];

            $timestamp = strtotime($ProdDate); // Convert the string to a Unix timestamp            
            $dateOnly = date("Y-m-d", $timestamp); // Format the timestamp to the desired date format
            $builder[$key]['proddateonly'] = $dateOnly;

            $builder[$key]['total_rit_ob'] = number_format($day_rit_ob + $night_rit_ob, 2);
            $builder[$key]['total_ob'] = number_format($day_ob + $night_ob, 2);

            $builder[$key]['total_rit_cl'] = number_format($day_rit_cl + $night_rit_cl, 2);
            $builder[$key]['total_cl'] = number_format($day_cl + $night_cl, 2);

            $builder[$key]['total_rit_cg'] = number_format($day_rit_cg + $night_rit_cg, 2);
            $builder[$key]['total_cg'] = number_format($day_cg + $night_cg, 2);
        }

        $response = [
            "status" => true,
            "rows" => $builder,
        ];

        return $this->respond($response, 200);
    }

    public function show_equipment_performance_all_summary()
    {
        $date1 = $this->request->getVar('tgl');
        $date2 = $this->request->getVar('tgl2');
        $site = $this->request->getVar('site');

        // exec dbo.uSP_0405_SHB_0063 N'SSA',N'20250901',N'20250930'
        // exec dbo.uSP_0405_SHB_0063B N'SSA',N'20250901',N'20250930'

        // $sp = "uSP_0405_SHB_0063 " . $site . ",". $date1 . "," . $date2;
        $sp = "uSP_0405_SHB_0063B " . $site . "," . $date1 . "," . $date2;

        $builder = $this->mcp->query($sp);
        $builder->getResultArray();
        $builder = $builder->resultArray;

        // $builder_sum = $this->mcp->query($sp_sum);
        // $builder_sum->getResultArray();
        // $builder_sum = $builder_sum->resultArray;

        foreach ($builder as $key => $value) {
            // $ProdDate = $value['proddate'];
            // $day_rit = $value['day_rit'];
            // $night_rit = $value['night_rit'];
            // $day = $value['day'];
            // $night = $value['night'];
            // "tipe": "LOADER",
            // "unit_code": "EXKM21002",
            // "day_rit_ob": "90.000",
            // "night_rit_ob": ".000",
            // "day_ob": "2790.000",
            // "night_ob": ".000",
            // "day_rit_cg": ".000",
            // "night_rit_cg": ".000",
            // "day_cg": ".00",
            // "night_cg": ".00",
            // "day_rit_cl": ".000",
            // "night_rit_cl": ".000",
            // "day_cl": ".00",
            // "night_cl": ".00",
            // "fuel": ".0000",
            // "stb": ".00",
            // "bd": ".00",
            // "idle": ".00",
            // "mohh": 720
            $tipe = $value['tipe'];
            $unit_code = $value['unit_code'];
            // $ProdDate = $value['ProdDate'];

            $day_rit_ob = $value['day_rit_ob'];
            $night_rit_ob = $value['night_rit_ob'];
            $builder[$key]['total_rit_ob'] = number_format($day_rit_ob + $night_rit_ob, 2);

            $day_ob = $value['day_ob'];
            $night_ob = $value['night_ob'];
            $builder[$key]['total_ob'] = number_format($day_ob + $night_ob, 2);

            $day_rit_cg = $value['day_rit_cg'];
            $night_rit_cg = $value['night_rit_cg'];
            $builder[$key]['total_rit_cg'] = number_format($day_rit_cg + $night_rit_cg, 2);

            $day_cg = $value['day_cg'];
            $night_cg = $value['night_cg'];
            $builder[$key]['total_cg'] = number_format($day_cg + $night_cg, 2);

            $day_rit_cl = $value['day_rit_cl'];
            $night_rit_cl = $value['night_rit_cl'];
            $builder[$key]['total_rit_cl'] = number_format($day_rit_cl + $night_rit_cl, 2);

            $day_cl = $value['day_cl'];
            $night_cl = $value['night_cl'];
            $builder[$key]['total_cl'] = number_format($day_cl + $night_cl, 2);

            $fuel = $value['fuel'];
            $stb = $value['stb'];
            $bd = $value['bd'];
            $idle = $value['idle'];
            $mohh = $value['mohh'];

            // $timestamp = strtotime($ProdDate); // Convert the string to a Unix timestamp            
            // $dateOnly = date("Y-m-d", $timestamp); // Format the timestamp to the desired date format
            // $builder[$key]['proddateonly'] = $dateOnly;
            // $query2[$key]['total'] = number_format($day + $night, 2);
            // $query2[$key]['total_rit'] = number_format($day_rit + $night_rit, 2);
        }

        $response = [
            "status" => true,
            "rows" => $builder,
        ];

        return $this->respond($response, 200);
    }

    /* Tab OB */
    public function show_equipment_performance_ob()
    {
        $date1 = $this->request->getVar('tgl');
        $date2 = $this->request->getVar('tgl2');
        $site = $this->request->getVar('site');

        // exec dbo.uSP_0405_SHB_0031B N'SSA',N'20250901',N'20250930'
        // exec dbo.uSP_0405_SHB_0034D N'SSA',N'20250901',N'20250930'
        // exec dbo.uSP_0405_SHB_0034E N'SSA',N'20250901',N'20250930'

        $sp_perLoc = "uSP_0405_SHB_0031B " . $site . "," . $date1 . "," . $date2;

        $builder = $this->mcp->query($sp_perLoc);
        $builder->getResultArray();
        $builder = $builder->resultArray;

        foreach ($builder as $key => $value) {
            // 
        }

        $response = [
            "status" => true,
            "rows" => $builder,
            "rit_count" => array_sum(array_column($builder, 'rit')),
            "ton_count" => array_sum(array_column($builder, 'ton')),
        ];

        return $this->respond($response, 200);
    }

    public function show_equipment_performance_ob_pertgl()
    {
        $date1 = $this->request->getVar('tgl');
        $date2 = $this->request->getVar('tgl2');
        $site = $this->request->getVar('site');

        // exec dbo.uSP_0405_SHB_0031B N'SSA',N'20250901',N'20250930'
        // exec dbo.uSP_0405_SHB_0034D N'SSA',N'20250901',N'20250930'
        // exec dbo.uSP_0405_SHB_0034E N'SSA',N'20250901',N'20250930'

        $sp = "uSP_0405_SHB_0034D " . $site . "," . $date1 . "," . $date2;

        $builder = $this->mcp->query($sp);
        $builder->getResultArray();
        $builder = $builder->resultArray;

        foreach ($builder as $key => $value) {
            // $ProdDate = $value['proddate'];
            // $day_rit = $value['day_rit'];
            // $night_rit = $value['night_rit'];
            $day = $value['day'];
            $night = $value['night'];
            // "tipe": "LOADER",
            // "unit_code": "EXKM21002",
            // "day_rit_ob": "90.000",
            // "night_rit_ob": ".000",
            // "day_ob": "2790.000",
            // "night_ob": ".000",
            // "day_rit_cg": ".000",
            // "night_rit_cg": ".000",
            // "day_cg": ".00",
            // "night_cg": ".00",
            // "day_rit_cl": ".000",
            // "night_rit_cl": ".000",
            // "day_cl": ".00",
            // "night_cl": ".00",
            // "fuel": ".0000",
            // "stb": ".00",
            // "bd": ".00",
            // "idle": ".00",
            // "mohh": 720
            // $tipe = $value['tipe'];
            // $unit_code = $value['unit_code'];
            $ProdDate = $value['proddate'];

            // $day_rit_ob = $value['day_rit_ob'];
            // $night_rit_ob = $value['night_rit_ob'];

            // $day_ob = $value['day_ob'];
            // $night_ob = $value['night_ob'];

            // $day_rit_cg = $value['day_rit_cg'];
            // $night_rit_cg = $value['night_rit_cg'];

            // $day_cg = $value['day_cg'];
            // $night_cg = $value['night_cg'];

            // $day_rit_cl = $value['day_rit_cl'];
            // $night_rit_cl = $value['night_rit_cl'];

            // $day_cl = $value['day_cl'];
            // $night_cl = $value['night_cl'];

            $fuel = (float)$value['fuel'];
            $stb = (float)$value['stb'];
            $bd = (float)$value['bd'];
            // $idle = $value['idle'];
            // $mohh = $value['mohh'];

            $timestamp = strtotime($ProdDate); // Convert the string to a Unix timestamp            
            $dateOnly = date("Y-m-d", $timestamp); // Format the timestamp to the desired date format
            $builder[$key]['proddateonly'] = $dateOnly;

            try {
                $builder[$key]['fr'] = $fuel / ($day + $night);
            } catch (\Throwable $th) {
                $builder[$key]['fr'] = "0";
            }

            // $builder[$key]['wh'] = 24 - ($stb  +  $bd);

            try {
                $builder[$key]['pa'] = ((24  -  $bd) / 24) * 100;
            } catch (\Throwable $th) {
                $builder[$key]['pa'] = "0";
            }

            try {
                $builder[$key]['ua'] = ((24 - $bd - $stb) / (24 - $bd)) * 100;
            } catch (\Throwable $th) {
                $builder[$key]['ua'] = "0";
            }
            // $query2[$key]['total'] = number_format($day + $night, 2);
            // $query2[$key]['total_rit'] = number_format($day_rit + $night_rit, 2);
            /* $builder[$key]['total_rit_ob'] = number_format($day_rit_ob + $night_rit_ob, 2);
            $builder[$key]['total_rit_cl'] = number_format($day_rit_cl + $night_rit_cl, 2);
            $builder[$key]['total_rit_cg'] = number_format($day_rit_cg + $night_rit_cg, 2); */
        }

        $response = [
            "status" => true,
            "rows" => $builder
        ];

        return $this->respond($response, 200);
    }

    public function show_equipment_performance_ob_perunit()
    {
        $date1 = $this->request->getVar('tgl');
        $date2 = $this->request->getVar('tgl2');
        $site = $this->request->getVar('site');

        // exec dbo.uSP_0405_SHB_0031B N'SSA',N'20250901',N'20250930'
        // exec dbo.uSP_0405_SHB_0034D N'SSA',N'20250901',N'20250930'
        // exec dbo.uSP_0405_SHB_0034E N'SSA',N'20250901',N'20250930'

        $sp = "uSP_0405_SHB_0034E " . $site . "," . $date1 . "," . $date2;

        $builder = $this->mcp->query($sp);
        $builder->getResultArray();
        $builder = $builder->resultArray;

        foreach ($builder as $key => $value) {
            $day = $value['day'];
            $night = $value['night'];

            $fuel = $value['fuel'];
            $stb = $value['stb'];
            $bd = $value['bd'];
            // $idle = $value['idle'];
            // $mohh = $value['mohh'];
            $wh = $value['wh'];

            // $timestamp = strtotime($ProdDate); // Convert the string to a Unix timestamp            
            // $dateOnly = date("Y-m-d", $timestamp); // Format the timestamp to the desired date format
            // $builder[$key]['proddateonly'] = $dateOnly;
            try {
                $builder[$key]['fr'] = $fuel / ($day + $night);
            } catch (\Throwable $th) {
                $builder[$key]['fr'] = "0";
            }

            // $builder[$key]['wh'] = 24 - ($stb  +  $bd);

            try {
                $builder[$key]['pa'] = ((24  -  $bd) / 24) * 100;
            } catch (\Throwable $th) {
                $builder[$key]['pa'] = "0";
            }

            try {
                $builder[$key]['ua'] = ((24 - $bd - $stb) / (24 - $bd)) * 100;
            } catch (\Throwable $th) {
                $builder[$key]['ua'] = "0";
            }
        }

        $response = [
            "status" => true,
            "rows" => $builder
        ];

        return $this->respond($response, 200);
    }

    /* Tab HAULING */
    // exec dbo.uSP_0405_SHB_0033B N'SSA',N'20250901',N'20250930'
    // exec dbo.uSP_0405_SHB_0034 N'SSA',N'20250901',N'20250930'
    // exec dbo.uSP_0405_SHB_0034F N'SSA',N'20250901',N'20250930'
    public function show_equipment_performance_hauling()
    {
        $date1 = $this->request->getVar('tgl');
        $date2 = $this->request->getVar('tgl2');
        $site = $this->request->getVar('site');

        $sp_perLoc = "uSP_0405_SHB_0033B " . $site . "," . $date1 . "," . $date2;

        $builder = $this->mcp->query($sp_perLoc);
        $builder->getResultArray();
        $builder = $builder->resultArray;

        foreach ($builder as $key => $value) {
            // 
        }

        $response = [
            "status" => true,
            "rows" => $builder,
            "rit_count" => number_format(array_sum(array_column($builder, 'rit')), 3),
            "ton_count" => number_format(array_sum(array_column($builder, 'ton')), 3),
        ];

        return $this->respond($response, 200);
    }

    public function show_equipment_performance_hauling_pertgl()
    {
        $date1 = $this->request->getVar('tgl');
        $date2 = $this->request->getVar('tgl2');
        $site = $this->request->getVar('site');

        $sp = "uSP_0405_SHB_0034 " . $site . "," . $date1 . "," . $date2;

        $builder = $this->mcp->query($sp);
        $builder->getResultArray();
        $builder = $builder->resultArray;

        foreach ($builder as $key => $value) {
            // $ProdDate = $value['proddate'];
            // $day_rit = $value['day_rit'];
            // $night_rit = $value['night_rit'];
            $day = $value['day'];
            $night = $value['night'];
            // "tipe": "LOADER",
            // "unit_code": "EXKM21002",
            // "day_rit_ob": "90.000",
            // "night_rit_ob": ".000",
            // "day_ob": "2790.000",
            // "night_ob": ".000",
            // "day_rit_cg": ".000",
            // "night_rit_cg": ".000",
            // "day_cg": ".00",
            // "night_cg": ".00",
            // "day_rit_cl": ".000",
            // "night_rit_cl": ".000",
            // "day_cl": ".00",
            // "night_cl": ".00",
            // "fuel": ".0000",
            // "stb": ".00",
            // "bd": ".00",
            // "idle": ".00",
            // "mohh": 720
            // $tipe = $value['tipe'];
            // $unit_code = $value['unit_code'];
            $ProdDate = $value['proddate'];

            // $day_rit_ob = $value['day_rit_ob'];
            // $night_rit_ob = $value['night_rit_ob'];

            // $day_ob = $value['day_ob'];
            // $night_ob = $value['night_ob'];

            // $day_rit_cg = $value['day_rit_cg'];
            // $night_rit_cg = $value['night_rit_cg'];

            // $day_cg = $value['day_cg'];
            // $night_cg = $value['night_cg'];

            // $day_rit_cl = $value['day_rit_cl'];
            // $night_rit_cl = $value['night_rit_cl'];

            // $day_cl = $value['day_cl'];
            // $night_cl = $value['night_cl'];

            $fuel = (float)$value['fuel'];
            $stb = (float)$value['stb'];
            $bd = (float)$value['bd'];
            // $idle = $value['idle'];
            // $mohh = $value['mohh'];

            $timestamp = strtotime($ProdDate); // Convert the string to a Unix timestamp            
            $dateOnly = date("Y-m-d", $timestamp); // Format the timestamp to the desired date format
            $builder[$key]['proddateonly'] = $dateOnly;

            try {
                $builder[$key]['fr'] = $fuel / ($day + $night);
            } catch (\Throwable $th) {
                $builder[$key]['fr'] = "0";
            }

            // $builder[$key]['wh'] = 24 - ($stb  +  $bd);

            try {
                $builder[$key]['pa'] = ((24  -  $bd) / 24) * 100;
            } catch (\Throwable $th) {
                $builder[$key]['pa'] = "0";
            }

            try {
                $builder[$key]['ua'] = ((24 - $bd - $stb) / (24 - $bd)) * 100;
            } catch (\Throwable $th) {
                $builder[$key]['ua'] = "0";
            }
            // $query2[$key]['total'] = number_format($day + $night, 2);
            // $query2[$key]['total_rit'] = number_format($day_rit + $night_rit, 2);
            /* $builder[$key]['total_rit_ob'] = number_format($day_rit_ob + $night_rit_ob, 2);
            $builder[$key]['total_rit_cl'] = number_format($day_rit_cl + $night_rit_cl, 2);
            $builder[$key]['total_rit_cg'] = number_format($day_rit_cg + $night_rit_cg, 2); */
        }

        $response = [
            "status" => true,
            "rows" => $builder
        ];

        return $this->respond($response, 200);
    }

    public function show_equipment_performance_hauling_perunit()
    {
        $date1 = $this->request->getVar('tgl');
        $date2 = $this->request->getVar('tgl2');
        $site = $this->request->getVar('site');

        $sp = "uSP_0405_SHB_0034F " . $site . "," . $date1 . "," . $date2;

        $builder = $this->mcp->query($sp);
        $builder->getResultArray();
        $builder = $builder->resultArray;

        foreach ($builder as $key => $value) {
            $day = $value['day'];
            $night = $value['night'];

            $fuel = $value['fuel'];
            $stb = $value['stb'];
            $bd = $value['bd'];
            // $idle = $value['idle'];
            // $mohh = $value['mohh'];
            $wh = $value['wh'];

            // $timestamp = strtotime($ProdDate); // Convert the string to a Unix timestamp            
            // $dateOnly = date("Y-m-d", $timestamp); // Format the timestamp to the desired date format
            // $builder[$key]['proddateonly'] = $dateOnly;
            try {
                $builder[$key]['fr'] = $fuel / ($day + $night);
            } catch (\Throwable $th) {
                $builder[$key]['fr'] = "0";
            }

            // $builder[$key]['wh'] = 24 - ($stb  +  $bd);

            try {
                $builder[$key]['pa'] = ((24  -  $bd) / 24) * 100;
            } catch (\Throwable $th) {
                $builder[$key]['pa'] = "0";
            }

            try {
                $builder[$key]['ua'] = ((24 - $bd - $stb) / (24 - $bd)) * 100;
            } catch (\Throwable $th) {
                $builder[$key]['ua'] = "0";
            }
        }

        $response = [
            "status" => true,
            "rows" => $builder
        ];

        return $this->respond($response, 200);
    }

    /* Tab GETTING */
    // exec dbo.uSP_0405_SHB_0053A N'SSA',N'20250901',N'20250930'
    // exec dbo.uSP_0405_SHB_0034C N'SSA',N'20250901',N'20250930'
    // exec dbo.uSP_0405_SHB_0034G N'SSA',N'20250901',N'20250930'
    public function show_equipment_performance_getting()
    {
        $date1 = $this->request->getVar('tgl');
        $date2 = $this->request->getVar('tgl2');
        $site = $this->request->getVar('site');

        $sp_perLoc = "uSP_0405_SHB_0053A " . $site . "," . $date1 . "," . $date2;

        $builder = $this->mcp->query($sp_perLoc);
        $builder->getResultArray();
        $builder = $builder->resultArray;

        foreach ($builder as $key => $value) {
            // 
        }

        $response = [
            "status" => true,
            "rows" => $builder,
            "rit_count" => number_format(array_sum(array_column($builder, 'rit')), 3),
            "ton_count" => number_format(array_sum(array_column($builder, 'ton')), 3),
        ];

        return $this->respond($response, 200);
    }

    public function show_equipment_performance_getting_pertgl()
    {
        $date1 = $this->request->getVar('tgl');
        $date2 = $this->request->getVar('tgl2');
        $site = $this->request->getVar('site');

        $sp = "uSP_0405_SHB_0034C " . $site . "," . $date1 . "," . $date2;

        $builder = $this->mcp->query($sp);
        $builder->getResultArray();
        $builder = $builder->resultArray;

        foreach ($builder as $key => $value) {
            // $ProdDate = $value['proddate'];
            // $day_rit = $value['day_rit'];
            // $night_rit = $value['night_rit'];
            $day = $value['day'];
            $night = $value['night'];
            // "tipe": "LOADER",
            // "unit_code": "EXKM21002",
            // "day_rit_ob": "90.000",
            // "night_rit_ob": ".000",
            // "day_ob": "2790.000",
            // "night_ob": ".000",
            // "day_rit_cg": ".000",
            // "night_rit_cg": ".000",
            // "day_cg": ".00",
            // "night_cg": ".00",
            // "day_rit_cl": ".000",
            // "night_rit_cl": ".000",
            // "day_cl": ".00",
            // "night_cl": ".00",
            // "fuel": ".0000",
            // "stb": ".00",
            // "bd": ".00",
            // "idle": ".00",
            // "mohh": 720
            // $tipe = $value['tipe'];
            // $unit_code = $value['unit_code'];
            $ProdDate = $value['proddate'];

            // $day_rit_ob = $value['day_rit_ob'];
            // $night_rit_ob = $value['night_rit_ob'];

            // $day_ob = $value['day_ob'];
            // $night_ob = $value['night_ob'];

            // $day_rit_cg = $value['day_rit_cg'];
            // $night_rit_cg = $value['night_rit_cg'];

            // $day_cg = $value['day_cg'];
            // $night_cg = $value['night_cg'];

            // $day_rit_cl = $value['day_rit_cl'];
            // $night_rit_cl = $value['night_rit_cl'];

            // $day_cl = $value['day_cl'];
            // $night_cl = $value['night_cl'];

            $fuel = (float)$value['fuel'];
            $stb = (float)$value['stb'];
            $bd = (float)$value['bd'];
            // $idle = $value['idle'];
            // $mohh = $value['mohh'];

            $timestamp = strtotime($ProdDate); // Convert the string to a Unix timestamp            
            $dateOnly = date("Y-m-d", $timestamp); // Format the timestamp to the desired date format
            $builder[$key]['proddateonly'] = $dateOnly;

            try {
                $builder[$key]['fr'] = $fuel / ($day + $night);
            } catch (\Throwable $th) {
                $builder[$key]['fr'] = "0";
            }

            // $builder[$key]['wh'] = 24 - ($stb  +  $bd);

            try {
                $builder[$key]['pa'] = ((24  -  $bd) / 24) * 100;
            } catch (\Throwable $th) {
                $builder[$key]['pa'] = "0";
            }

            try {
                $builder[$key]['ua'] = ((24 - $bd - $stb) / (24 - $bd)) * 100;
            } catch (\Throwable $th) {
                $builder[$key]['ua'] = "0";
            }
            // $query2[$key]['total'] = number_format($day + $night, 2);
            // $query2[$key]['total_rit'] = number_format($day_rit + $night_rit, 2);
            /* $builder[$key]['total_rit_ob'] = number_format($day_rit_ob + $night_rit_ob, 2);
            $builder[$key]['total_rit_cl'] = number_format($day_rit_cl + $night_rit_cl, 2);
            $builder[$key]['total_rit_cg'] = number_format($day_rit_cg + $night_rit_cg, 2); */
        }

        $response = [
            "status" => true,
            "rows" => $builder
        ];

        return $this->respond($response, 200);
    }

    public function show_equipment_performance_getting_perunit()
    {
        $date1 = $this->request->getVar('tgl');
        $date2 = $this->request->getVar('tgl2');
        $site = $this->request->getVar('site');

        $sp = "uSP_0405_SHB_0034G " . $site . "," . $date1 . "," . $date2;

        $builder = $this->mcp->query($sp);
        $builder->getResultArray();
        $builder = $builder->resultArray;

        foreach ($builder as $key => $value) {
            $day = $value['day'];
            $night = $value['night'];

            $fuel = $value['fuel'];
            $stb = $value['stb'];
            $bd = $value['bd'];
            // $idle = $value['idle'];
            // $mohh = $value['mohh'];
            $wh = $value['wh'];

            // $timestamp = strtotime($ProdDate); // Convert the string to a Unix timestamp            
            // $dateOnly = date("Y-m-d", $timestamp); // Format the timestamp to the desired date format
            // $builder[$key]['proddateonly'] = $dateOnly;
            try {
                $builder[$key]['fr'] = $fuel / ($day + $night);
            } catch (\Throwable $th) {
                $builder[$key]['fr'] = "0";
            }

            // $builder[$key]['wh'] = 24 - ($stb  +  $bd);

            try {
                $builder[$key]['pa'] = ((24  -  $bd) / 24) * 100;
            } catch (\Throwable $th) {
                $builder[$key]['pa'] = "0";
            }

            try {
                $builder[$key]['ua'] = ((24 - $bd - $stb) / (24 - $bd)) * 100;
            } catch (\Throwable $th) {
                $builder[$key]['ua'] = "0";
            }
        }

        $response = [
            "status" => true,
            "rows" => $builder
        ];

        return $this->respond($response, 200);
    }
}
