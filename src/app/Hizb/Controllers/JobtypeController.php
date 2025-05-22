<?php

namespace App\Hizb\Controllers;

use CodeIgniter\RESTful\ResourceController;
use Dorbitt\Helpers\QueryHelper;
use Dorbitt\Helpers\UmmuHelper;
use Dorbitt\Helpers\DateTimeHelper;

use App\Hizb\Builder\JobtypeBuilder;

class JobtypeController extends ResourceController
{
    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->qHelp = new UmmuHelper();
        $this->dtH = new DateTimeHelper();

        $this->qBuilder = new JobtypeBuilder();
    }

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        // 
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $builder = $this->qBuilder->show($id);
        // if ($builder->status == true) {
        //     $rows = $builder->rows;
        //     if ($rows) {
        //         foreach ($rows as $key => $value) {
        //             if (!$value->foto_temuan_url) {
        //                 $rows[$key]->foto_temuan_url = getenv('api-url') . 'uploads/no_image.jpg';
        //             }

        //             if (!$value->foto_perbaikan_url) {
        //                 $rows[$key]->foto_perbaikan_url = getenv('api-url') . 'uploads/no_image.jpg';
        //             }
        //         }
        //     }
        // }

        return $this->respond($builder, 200);
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        // 
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        // 
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        // 
    }

    public function show_from_sap()
    {
        $builder = $this->qBuilder->show_from_sap();

        // $rows = [];
        // foreach ($builder as $key => $value) {
        //     $AUFNR_order = $value['AUFNR'];
        //     $AUART_orderType = $value['AUART'];
        //     $KTEXT_description = $value['KTEXT'];
        //     $WERKS_plant = $value['WERKS'];
        //     $ERDAT_createdDate = $value['ERDAT'];

        //     if (isset($value['EQUNR'])) {
        //         $EQUNR_equipment = $value['EQUNR'];
        //     } else {
        //         $EQUNR_equipment = "";
        //     }

        //     if (isset($value['TIDNR'])) {
        //         $TIDNR_techIdentNo = $value['TIDNR'];
        //     } else {
        //         $TIDNR_techIdentNo = "";
        //     }

        //     if (isset($value['VORNR'])) {
        //         $VORNR_operation = $value['VORNR'];
        //     } else {
        //         $VORNR_operation = "";
        //     }

        //     if (isset($value['LTXA1'])) {
        //         $LTXA1_operationShortText = $value['LTXA1'];
        //     } else {
        //         $LTXA1_operationShortText = "";
        //     }

        //     if (isset($value['QMNUM'])) {
        //         $QMNUM_notification = $value['QMNUM'];
        //     } else {
        //         $QMNUM_notification = "";
        //     }

        //     if (isset($value['OTGRP'])) {
        //         $OTGRP_objectPart = $value['OTGRP'];
        //     } else {
        //         $OTGRP_objectPart = "";
        //     }

        //     if (isset($value['IPHAS'])) {
        //         $IPHAS_systemStatus = $value['IPHAS'];
        //     } else {
        //         $IPHAS_systemStatus = "";
        //     }

        //     if (isset($value['AUSVN'])) {
        //         $AUSVN_MalfunctionStart = $value['AUSVN'];
        //     } else {
        //         $AUSVN_MalfunctionStart = "";
        //     }

        //     if (isset($value['AUSBS'])) {
        //         $AUSBS_MalfunctionEnd = $value['AUSBS'];
        //     } else {
        //         $AUSBS_MalfunctionEnd = "";
        //     }

        //     if (isset($value['AUZTV'])) {
        //         $AUZTV_MalfunctionStartTime = $value['AUZTV'];
        //     } else {
        //         $AUZTV_MalfunctionStartTime = "";
        //     }

        //     if (isset($value['AUZTB'])) {
        //         $AUZTB_MalfunctionEndTime = $value['AUZTB'];
        //     } else {
        //         $AUZTB_MalfunctionEndTime = "";
        //     }

        //     $rows[] = [
        //         "AUFNR_order" => $AUFNR_order,
        //         "AUART_orderType" => $AUART_orderType,
        //         "KTEXT_description" => $KTEXT_description,
        //         "WERKS_plant" => $WERKS_plant,
        //         "EQUNR_equipment" => $EQUNR_equipment,
        //         "TIDNR_techIdentNo" => $TIDNR_techIdentNo,
        //         "VORNR_operation" => $VORNR_operation,
        //         "LTXA1_operationShortText" => $LTXA1_operationShortText,
        //         "QMNUM_notification" => $QMNUM_notification,
        //         "OTGRP_objectPart" => $OTGRP_objectPart,
        //         "IPHAS_systemStatus" => $IPHAS_systemStatus,
        //         "ERDAT_createdDate" => $ERDAT_createdDate,
        //         "AUSVN_MalfunctionStart" => $AUSVN_MalfunctionStart,
        //         "AUSBS_MalfunctionEnd" => $AUSBS_MalfunctionEnd,
        //         "AUZTV_MalfunctionStartTime" => $AUZTV_MalfunctionStartTime,
        //         "AUZTB_MalfunctionEndTime" => $AUZTB_MalfunctionEndTime
        //     ];
        // }


        // // /**
        // //  * Grouping
        // //  * */
        // // $arr = [];
        // // foreach ($rows as $key => $item) {
        // //    $arr[$item['AUFNR_order']][] = $item;
        // //     // $arr["AUFNR_order" => $item['AUFNR_order']][] = $item;
        // // }
        // // ksort($arr, SORT_NUMERIC);


        // /**
        //  * List wo_numbers
        //  * */
        // $AUFNR_orders = [];
        // foreach ($rows as $key => $value) {
        //     $AUFNR_order = $value['AUFNR_order'];
        //     $AUFNR_orders[] = $AUFNR_order;
        // }


        // /**
        //  * AUFNR_orders unique
        //  * */
        // $AUFNR_orders_unique = array_unique($AUFNR_orders);

        // $AUFNR_orders_results = [];
        // foreach ($AUFNR_orders_unique as $key => $value) {
        //     $AUFNR_orders_results[] = array('AUFNR_order' => $value);
        // }


        // /**
        //  * rows unique
        //  * */
        // $rows_unique = [];
        // foreach ($AUFNR_orders_results as $key => $value) {
        //     $AUFNR_order = $value['AUFNR_order'];

        //     $operations = [];
        //     $array = [];
        //     $values = "";
        //     foreach ($rows as $key2 => $value2) {
        //         $wo_number = $value2['AUFNR_order'];

        //         if ($wo_number == $AUFNR_order) {
        //             $values = $value2;
        //         }
        //     }

        //     $rows_unique[] = $values;
        // }

        // $params = [
        //     "AUFNR_order",
        //     "AUART_orderType",
        //     "KTEXT_description",
        //     "WERKS_plant",
        //     "EQUNR_equipment",
        //     "TIDNR_techIdentNo",
        //     "VORNR_operation",
        //     "LTXA1_operationShortText",
        //     "QMNUM_notification"
        // ];
        // $rows_unique = $this->qHelp->array_search_dt($rows_unique, $params);
        // $rows_unique = $this->qHelp->array_paging($rows_unique);

        // $count = $rows_unique['count'];
        // $total = $rows_unique['total'];
        // $rows_unique = $rows_unique['rows'];


        // foreach ($rows_unique as $key => $value) {
        //     $wo_number = $value['AUFNR_order'];

        //     $operations = [];
        //     foreach ($rows as $key2 => $value2) {
        //         $AUFNR_order = $value2['AUFNR_order'];

        //         if ($AUFNR_order == $wo_number) {
        //             $VORNR_operation = $value2['VORNR_operation'];
        //             $operations[] = [
        //                 "operation" => $value2['VORNR_operation'],
        //                 "operationShortText" => $value2['LTXA1_operationShortText']
        //             ];
        //         }
        //     }

        //     $rows_unique[$key]['operations'] = $operations;
        // }

        // $response = [
        //     "status" => true,
        //     "message" => 'Get data success',
        //     "rows" => $rows_unique,
        //     "count" => $count,
        //     "total" => $total,
        //     "recordsTotal" => $total,
        //     "recordsFiltered" => $total
        // ];

        return $this->respond($builder, 200);
    }

    public function retrieve()
    {
        $builder = $this->qBuilder->show_from_sap();

        $rows = [];
        foreach ($builder as $key => $value) {
            $AUFNR_order = $value['AUFNR'];
            $AUART_orderType = $value['AUART'];
            $KTEXT_description = $value['KTEXT'];
            $WERKS_plant = $value['WERKS'];
            $ERDAT_createdDate = $value['ERDAT'];

            if (isset($value['EQUNR'])) {
                $EQUNR_equipment = $value['EQUNR'];
            } else {
                $EQUNR_equipment = "";
            }

            if (isset($value['TIDNR'])) {
                $TIDNR_techIdentNo = $value['TIDNR'];
            } else {
                $TIDNR_techIdentNo = "";
            }

            if (isset($value['VORNR'])) {
                $VORNR_operation = $value['VORNR'];
            } else {
                $VORNR_operation = "";
            }

            if (isset($value['LTXA1'])) {
                $LTXA1_operationShortText = $value['LTXA1'];
            } else {
                $LTXA1_operationShortText = "";
            }

            if (isset($value['QMNUM'])) {
                $QMNUM_notification = $value['QMNUM'];
            } else {
                $QMNUM_notification = "";
            }

            if (isset($value['OTGRP'])) {
                $OTGRP_objectPart = $value['OTGRP'];
            } else {
                $OTGRP_objectPart = "";
            }

            if (isset($value['IPHAS'])) {
                $IPHAS_systemStatus = $value['IPHAS'];
            } else {
                $IPHAS_systemStatus = "";
            }

            if (isset($value['AUSVN'])) {
                $AUSVN_MalfunctionStart = $value['AUSVN'];
            } else {
                $AUSVN_MalfunctionStart = "";
            }

            if (isset($value['AUSBS'])) {
                $AUSBS_MalfunctionEnd = $value['AUSBS'];
            } else {
                $AUSBS_MalfunctionEnd = "";
            }

            if (isset($value['AUZTV'])) {
                $AUZTV_MalfunctionStartTime = $value['AUZTV'];
            } else {
                $AUZTV_MalfunctionStartTime = "";
            }

            if (isset($value['AUZTB'])) {
                $AUZTB_MalfunctionEndTime = $value['AUZTB'];
            } else {
                $AUZTB_MalfunctionEndTime = "";
            }

            $rows[] = [
                "AUFNR_order" => $AUFNR_order,
                "AUART_orderType" => $AUART_orderType,
                "KTEXT_description" => $KTEXT_description,
                "WERKS_plant" => $WERKS_plant,
                "EQUNR_equipment" => $EQUNR_equipment,
                "TIDNR_techIdentNo" => $TIDNR_techIdentNo,
                "VORNR_operation" => $VORNR_operation,
                "LTXA1_operationShortText" => $LTXA1_operationShortText,
                "QMNUM_notification" => $QMNUM_notification,
                "OTGRP_objectPart" => $OTGRP_objectPart,
                "IPHAS_systemStatus" => $IPHAS_systemStatus,
                "ERDAT_createdDate" => $ERDAT_createdDate,
                "AUSVN_MalfunctionStart" => $AUSVN_MalfunctionStart,
                "AUSBS_MalfunctionEnd" => $AUSBS_MalfunctionEnd,
                "AUZTV_MalfunctionStartTime" => $AUZTV_MalfunctionStartTime,
                "AUZTB_MalfunctionEndTime" => $AUZTB_MalfunctionEndTime
            ];
        }


        // /**
        //  * Grouping
        //  * */
        // $arr = [];
        // foreach ($rows as $key => $item) {
        //    $arr[$item['AUFNR_order']][] = $item;
        //     // $arr["AUFNR_order" => $item['AUFNR_order']][] = $item;
        // }
        // ksort($arr, SORT_NUMERIC);


        /**
         * List wo_numbers
         * */
        $AUFNR_orders = [];
        foreach ($rows as $key => $value) {
            $AUFNR_order = $value['AUFNR_order'];
            $AUFNR_orders[] = $AUFNR_order;
        }


        /**
         * AUFNR_orders unique
         * */
        $AUFNR_orders_unique = array_unique($AUFNR_orders);

        $AUFNR_orders_results = [];
        foreach ($AUFNR_orders_unique as $key => $value) {
            $AUFNR_orders_results[] = array('AUFNR_order' => $value);
        }


        /**
         * rows unique
         * */
        $rows_unique = [];
        foreach ($AUFNR_orders_results as $key => $value) {
            $AUFNR_order = $value['AUFNR_order'];

            $operations = [];
            $array = [];
            $values = "";
            foreach ($rows as $key2 => $value2) {
                $wo_number = $value2['AUFNR_order'];

                if ($wo_number == $AUFNR_order) {
                    $values = $value2;
                }
            }

            $rows_unique[] = $values;
        }

        $params = [
            "AUFNR_order",
            "AUART_orderType",
            "KTEXT_description",
            "WERKS_plant",
            "EQUNR_equipment",
            "TIDNR_techIdentNo",
            "VORNR_operation",
            "LTXA1_operationShortText",
            "QMNUM_notification"
        ];
        $rows_unique = $this->qHelp->array_search_dt($rows_unique, $params);
        $rows_unique = $this->qHelp->array_paging($rows_unique);

        $count = $rows_unique['count'];
        $total = $rows_unique['total'];
        $rows_unique = $rows_unique['rows'];


        foreach ($rows_unique as $key => $value) {
            $wo_number = $value['AUFNR_order'];

            $operations = [];
            foreach ($rows as $key2 => $value2) {
                $AUFNR_order = $value2['AUFNR_order'];

                if ($AUFNR_order == $wo_number) {
                    $VORNR_operation = $value2['VORNR_operation'];
                    $operations[] = [
                        "operation" => $value2['VORNR_operation'],
                        "operationShortText" => $value2['LTXA1_operationShortText']
                    ];
                }
            }

            $rows_unique[$key]['operations'] = $operations;
        }

        $response = [
            "status" => true,
            "message" => 'Get data success',
            "rows" => $rows_unique,
            "count" => $count,
            "total" => $total,
            "recordsTotal" => $total,
            "recordsFiltered" => $total
        ];

        return $this->respond($response, 200);
    }

    public function show_from_sap_odata()
    {
        // $sap_client = $this->request->getJsonVar('sap_client');
        // $format = $this->request->getJsonVar('format');
        // $expand = $this->request->getJsonVar('expand');
        $filter = $this->request->getJsonVar('filter');
        $skiptoken = $this->request->getJsonVar('skiptoken');

        if (isset($filter)) {
            $filter = str_replace(" ", "%20", $filter);
            $filter = str_replace("'", "%27", $filter);
            // $filter = "&%24filter=" . str_replace("'", "%27", $filterr);
        } else {
            $filter = "";
        }

        if (isset($skiptoken)) {
            // $skiptokenn = str_replace(" ", "%20", $skiptoken);
            // $skiptokenn = "&%24skiptoken=" . str_replace("'", "%27", $skiptokenn);
            $skiptoken = "&%24skiptoken=" . $skiptoken;
        } else {
            $skiptoken = "";
        }

        $params = "%24format=" . getenv('sap-format') . $filter . "&sap-client=" . getenv('sap-client') . $skiptoken;

        $builder = $this->qBuilder->show_from_sap_odata($params);
        $count = 0;
        $total = 0;
        $recordsTotal = 0;
        $recordsFiltered = 0;

        if (isset($builder->d)) {
            $d = $builder->d;
            if (isset($d->results)) {
                $rows = $d->results;
                $count = count($rows);
                $total = count($rows);
                $recordsTotal = count($rows);
                $recordsFiltered = count($rows);
            }
        }

        $builder->count = $count;
        $builder->total = $total;
        $builder->recordsTotal = $recordsTotal;
        $builder->recordsFiltered = $recordsFiltered;

        return $this->respond($builder, 200);
    }

    public function show_notif()
    {
        $order_number = $this->request->getJsonVar('order_number');
        $operation_number = $this->request->getJsonVar('operation_number');

        $builder = $this->qBuilder->show_notif($order_number, $operation_number);
        $count = 0;
        $total = 0;
        $recordsTotal = 0;
        $recordsFiltered = 0;

        if (isset($builder->d)) {
            $d = $builder->d;
            $row = $d;

            $row->start_time = $this->dtH->xsd_to_time($row->malfunc_start_time);
            $row->end_time = $this->dtH->xsd_to_time($row->malfunc_end_time);
        } else {
            $row = $builder;
        }

        return $this->respond($row, 200);
    }

    public function show_operationItem()
    {
        $order_number = $this->request->getJsonVar('order_number');
        $operation_number = $this->request->getJsonVar('operation_number');

        $builder = $this->qBuilder->show_operationItem($order_number, $operation_number);
        // if ($builder) {
        //     $rows = $builder->d->results;
        // }

        $count = 0;
        $total = 0;
        $recordsTotal = 0;
        $recordsFiltered = 0;

        if (isset($builder->d)) {
            $d = $builder->d;
            if (isset($d->results)) {
                $rows = $d->results;
                $count = count($rows);
                $total = count($rows);
                $recordsTotal = count($rows);
                $recordsFiltered = count($rows);

                if ($count > 0) {
                    foreach ($rows as $key => $value) {
                        $rows[$key]->id = $value->act_number;
                        $rows[$key]->text = $value->opr_short_text;
                    }
                }
            }
        }

        $builder->count = $count;
        $builder->total = $total;
        $builder->recordsTotal = $recordsTotal;
        $builder->recordsFiltered = $recordsFiltered;

        return $this->respond($builder, 200);
    }
}
