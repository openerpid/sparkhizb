<?php

namespace App\Hizb\Controllers\Safety;

use CodeIgniter\RESTful\ResourceController;
use Sparkhizb\Helpers\QueryHelper;
use Sparkhizb\Helpers\UmmuHelper;
use Sparkhizb\Helpers\IdentityHelper;
use Sparkhizb\UmmuPhotos;
use Sparkhizb\UmmuUpload;

use App\Hizb\Builder\Safety\LpaBuilder;

class LpaController extends ResourceController
{
    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->qHelp = new QueryHelper();
        $this->identity = new IdentityHelper();
        $this->umUpl = new UmmuUpload();
        $this->umPhot = new UmmuPhotos();

        $this->qBuilder = new LpaBuilder();
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
        $show_detail_orang_terlibat = $this->request->getJsonVar('show_detail_orang_terlibat');
        $show_detail_foto = $this->request->getJsonVar('show_detail_foto');
        $show_detail_kerusakan = $this->request->getJsonVar('show_detail_kerusakan');
        $show_detail_unit = $this->request->getJsonVar('show_detail_unit');

        $builder = $this->qBuilder->show($id);
        $total = $this->qHelp->_total($builder);
        $rows = $this->qHelp->_rowsBui($builder);
        $count = count($rows);
        $rows = $this->qBuilder->joinData($rows);
        if ($rows) {
            foreach ($rows as $key => $value) {
                if ($show_detail_orang_terlibat) {
                    $orang = $this->qBuilder->show_d_orang($value->id);
                    $rows[$key]->orang_terlibat = $orang;
                }

                if ($show_detail_foto) {
                    $foto = $this->qBuilder->show_d_foto($value->id);
                    if ($foto) {
                        foreach ($foto as $key2 => $value2) {
                            $foto[$key2]->file_url = base_url() . $value2->filepath;
                        }
                    }
                    $rows[$key]->foto = $foto;
                }

                if ($show_detail_kerusakan) {
                    $kerusakan = $this->qBuilder->show_d_kerusakan($value->id);
                    $rows[$key]->kerusakan = $kerusakan;
                }

                if ($show_detail_unit) {
                    $unit = $this->qBuilder->show_d_unit($value->id);
                    $rows[$key]->unit = $unit;
                }
            }
        }

        $response = $this->qHelp->respon($rows, $count, $total);
        return $this->respond($response, 200);
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function number_document()
    {
        $site = $this->request->getJsonVar('site');
        $nik = $this->request->getJsonVar('nik');

        $payload = [
            "site" => $site,
            "nik" => $nik
        ];

        $show_number_unused = $this->qBuilder->show_number_unused($nik, $site);
        if ($show_number_unused) { /* jika ada nomor dokumen yang belum digunakan pada bulan dan tahun yang sama dengan sekarang */
            $row = $show_number_unused;
            $number = $row['number'];
        } else {
            // $show_new = $this->qBuilder->show_new($nik, $site); /* ambil row yang belum ada nomor dokumen nya */

            // if ($show_new) { /* jika ada, maka tampilkan seq */
            //     $seq = $show_new['seq'];
            // } else {
            //     // $getLastRow = $this->qBuilder->getLastRow();
            //     // if ($getLastRow) {
            //     // }else{
            //     $create_seq = $this->qBuilder->create_id($payload);
            //     $seq = $create_seq;
            //     // }
            // }
            // $n = sprintf('%08d', $id);
            // $number = $site . 'HZR' . date('Ym') . $n;

            // $payload = [
            //     "number" => $number
            // ];
            // $update_new = $this->qBuilder->update_new($id, $payload);



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
                "number" => $number
            ];
            $insert_number = $this->qBuilder->insert_number($payload);
        }

        $response = [$number];

        return $this->respond($response, 200);
    }

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
