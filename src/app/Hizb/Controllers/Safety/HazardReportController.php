<?php

namespace App\Gcontrollers\Safety;

use CodeIgniter\RESTful\ResourceController;
use Sparkhizb\Helpers\IdentityHelper;
use Sparkhizb\Helpers\QueryHelper;
use Sparkhizb\Helpers\UmmuHelper;
use Sparkhizb\UmmuPhotos;
use Sparkhizb\UmmuUpload;

use App\Gbuilder\Safety\HazardReportBuilder;

class HazardReportController extends ResourceController
{
    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->identity = new IdentityHelper();
        $this->qHelp = new UmmuHelper();
        $this->qBuilder = new HazardReportBuilder();
        $this->umUpl = new UmmuUpload();
        $this->umPhot = new UmmuPhotos();
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
        if ($builder->status == true) {
            $rows = $builder->rows;
            if ($rows) {
                foreach ($rows as $key => $value) {
                    if (!$value->foto_temuan_url) {
                        $rows[$key]->foto_temuan_url = getenv('api-url') . 'uploads/no_image.jpg';
                    }

                    if (!$value->foto_perbaikan_url) {
                        $rows[$key]->foto_perbaikan_url = getenv('api-url') . 'uploads/no_image.jpg';
                    }
                }
            }
        }
        return $this->respond($builder, 200);
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        $site = $this->request->getJsonVar('site');
        $nik = $this->request->getJsonVar('nik');

        $payload = [
            "site" => $site,
            "nik" => $nik
        ];

        // $show_number_unused = $this->qBuilder->show_number_unused($nik, $site); /* ambil nomor dokumen berdasarkan nik dan site */
        $show_number_unused = $this->qBuilder->show_number_unused_by_accountid($this->identity->account_id()); /* ambil nomor dokumen berdasarkan account_id */
        if ($show_number_unused) { /* jika ada nomor dokumen yang belum digunakan pada bulan dan tahun yang sama dengan sekarang */
            $row = $show_number_unused;
            $number = $row->number;

            $payload = [
                "site" => $site,
                "nik" => $nik,
                "number" => $number
            ];
            
        } else {

            $getLastRow = $this->qBuilder->getLastRow();
            if ($getLastRow) {
                $seq = $getLastRow->seq;
                $seq = $seq + 1;
            } else {
                $seq = 1;
            }

            $n = sprintf('%06d', $seq);
            $number = $site . 'HZR' . date('Ym') . $n;

            $payload = [
                "seq" => $seq,
                "site" => $site,
                "nik" => $nik,
                "number" => $number,
                "created_by" => $this->identity->account_id()
            ];
            $insert_number = $this->qBuilder->insert_number($payload);
        }

        $response = [$number];

        return $this->respond($payload, 200);
    }

    // public function number_document()
    // {
    //     $site = $this->request->getJsonVar('site');
    //     $nik = $this->request->getJsonVar('nik');

    //     $payload = [
    //         "site" => $site,
    //         "nik" => $nik
    //     ];

    //     $show_number_unused = $this->qBuilder->show_number_unused($nik, $site);
    //     if ($show_number_unused) { /* jika ada nomor dokumen yang belum digunakan pada bulan dan tahun yang sama dengan sekarang */
    //         $row = $show_number_unused;
    //         $number = $row->number;

    //     } else {

    //         $getLastRow = $this->qBuilder->getLastRow();
    //         if ($getLastRow) {
    //             $seq = $getLastRow->seq;
    //             $seq = $seq + 1;
    //         } else {
    //             $seq = 1;
    //         }

    //         $n = sprintf('%06d', $seq);
    //         $number = $site . 'HZR' . date('Ym') . $n;

    //         $payload = [
    //             "seq" => $seq,
    //             "site" => $site,
    //             "nik" => $nik,
    //             "number" => $number
    //         ];
    //         $insert_number = $this->qBuilder->insert_number($payload);
    //     }

    //     $response = [$number];

    //     return $this->respond($response, 200);
    // }

    public function used_number($number)
    {
        $builder = $this->qBuilder->used_number($number);
        return $this->respond($builder, 200);
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $payload = (array) $this->request->getJsonVar();
        $builder = $this->qBuilder->insert($payload);
        return $this->respond($builder, 200);
    }

    public function create2()
    {
        $body = (array) $this->request->getVar();
        $foto_temuan = $this->request->getFile("foto_temuan");
        $foto_perbaikan = $this->request->getFile("foto_perbaikan");
        $foto_temuan_id = null;
        $foto_perbaikan_id = null;

        if (isset($foto_temuan)) {
            $ci_foto_temuan = new \CodeIgniter\Files\File($foto_temuan);
            if ($ci_foto_temuan->getBasename()) {
                $foto_temuan_upload = $this->umUpl->create2($foto_temuan);
                if ($foto_temuan_upload['status'] == true) {
                    $payload = [
                        "filename" => $foto_temuan_upload["name"],
                        "folder" => $foto_temuan_upload["folder"],
                        "paht" => null,
                        "url" => $foto_temuan_upload["url"]
                    ];
                    $params = [
                        "payload" => $payload,
                        "token" => $this->qHelp->token()
                    ];
                    $photos_create = $this->umPhot->create($params);
                    if ($photos_create->status == true) {
                        $foto_temuan_id = $photos_create->data->id;
                    }
                }
            }
        }

        if (isset($foto_perbaikan)) {
            $ci_foto_perbaikan = new \CodeIgniter\Files\File($foto_perbaikan);
            if ($ci_foto_perbaikan->getBasename()) {
                $foto_perbaikan_upload = $this->umUpl->create2($foto_perbaikan);
                if ($foto_perbaikan_upload['status'] == true) {
                    $payload = [
                        "filename" => $foto_perbaikan_upload["name"],
                        "folder" => $foto_perbaikan_upload["folder"],
                        "paht" => null,
                        "url" => $foto_perbaikan_upload["url"]
                    ];
                    $params = [
                        "payload" => $payload,
                        "token" => $this->qHelp->token()
                    ];
                    $photos_create = $this->umPhot->create($params);
                    if ($photos_create->status == true) {
                        $foto_perbaikan_id = $photos_create->data->id;
                    }
                }
            }
        }

        $payload = array_merge(
            $body,
            ["foto_temuan_id" => $foto_temuan_id],
            ["foto_perbaikan_id" => $foto_perbaikan_id]
        );
        $builder = $this->qBuilder->insert($payload);
        return $this->respond($builder, 200);
        // return $this->respond(["OK"], 200);
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


    // public function show_queue_mail($id = null)
    // {
    //     $builder = $this->qBuilder->show_queue_mail();
    //     if ($builder) {
    //         $row = $builder[0];
    //         $document_id = $row['document_id'];

    //         $detail = $this->qBuilder->show_queue_mail_detail($document_id);
    //     }
    //     return $this->respond($detail, 200);
    // }

    // public function create_queue_mail()
    // {
    //     $document_id = $this->request->getJsonVar('document_id');

    //     $builder = $this->qBuilder->create_queue_mail($document_id);
    //     return $this->respond($builder, 200);
    // }

    // public function update_queue_mail($id = null)
    // {
    //     $body = $this->request->getJsonVar();

    //     $builder = $this->qBuilder->update_queue_mail($id, $body);

    //     return $this->respond($builder, 200);
    // }

    // public function update_queue_mail_by_kode($kode)
    // {
    //     $body = $this->request->getJsonVar();

    //     $builder = $this->qBuilder->update_queue_mail_by_kode($kode, $body);
    //     return $this->respond($builder, 200);
    // }
}
