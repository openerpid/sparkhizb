<?php

namespace App\Hizb\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\Files\File;
use CodeIgniter\HTTP\Files\UploadedFile;
use Sparkhizb\Helpers\QueryHelper;
use Sparkhizb\Helpers\UmmuHelper;
use Sparkhizb\Helpers\IdentityHelper;
// use App\Hizb\Validations\LpaValidation;
use App\Hizb\Builder\MechanicActivityBuilder;

class MechanicActivityController extends ResourceController
{
    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->qHelp = new QueryHelper();
        $this->identity = new IdentityHelper();
        $this->qBuilder = new MechanicActivityBuilder();
        // $this->qVal = new LpaValidation();
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
        // $show_detail_orang_terlibat = $this->request->getJsonVar('show_detail_orang_terlibat');
        // $show_detail_foto = $this->request->getJsonVar('show_detail_foto');
        // $show_detail_kerusakan = $this->request->getJsonVar('show_detail_kerusakan');
        // $show_detail_unit = $this->request->getJsonVar('show_detail_unit');
        // $show_detail_divisiTerkait = $this->request->getJsonVar('show_detail_divisiTerkait');
        // $join_syshab = $this->request->getJsonVar('join_syshab');

        $builder = $this->qBuilder->show($id);
        $total = $this->qHelp->_total($builder);
        $rows = $this->qHelp->_rowsBui($builder);
        $count = count($rows);
        // $rows = $this->qBuilder->joinData($rows);

        // if ($rows) {
        //     foreach ($rows as $key => $value) {
        //         if ($show_detail_orang_terlibat) {
        //             $orang = $this->qBuilder->show_d_orang($value->id);
        //             $orang = $this->qBuilder->joinEmployee($orang);
        //             $rows[$key]->orang_terlibat = $orang;
        //         }

        //         if ($show_detail_foto) {
        //             $foto = $this->qBuilder->show_d_foto($value->id);
        //             if ($foto) {
        //                 foreach ($foto as $key2 => $value2) {
        //                     $foto[$key2]->file_url = base_url() . $value2->filepath;
        //                 }
        //             }
        //             $rows[$key]->foto = $foto;
        //         }

        //         if ($show_detail_kerusakan) {
        //             $kerusakan = $this->qBuilder->show_d_kerusakan($value->id);
        //             $rows[$key]->kerusakan = $kerusakan;
        //         }

        //         if ($show_detail_unit) {
        //             $unit = $this->qBuilder->show_d_unit($value->id);
        //             $rows[$key]->unit = $unit;
        //         }

        //         if ($show_detail_divisiTerkait) {

        //             $divisi = $this->qBuilder->show_d_divisi($value->id);

        //             $divisi_name = '';
        //             $depar_name = '';
        //             foreach ($divisi as $key2 => $value2) {
        //                 if (in_array("divisi", $join_syshab)) {
        //                     $qbDivisi = new \App\Hizb\Syshab\Builder\DivisiBuilder;

        //                     $herp_divisi = $qbDivisi->show_by_kode($value2->divisi_kode)->get()->getRow();
        //                     if ($herp_divisi) {
        //                         $divisi_name = $herp_divisi->NmDivisi;
        //                     }

        //                     $divisi[$key2]->divisi_name = $divisi_name;
        //                 }

        //                 if (in_array("departemen", $join_syshab)) {
        //                     $qbDepar = new \App\Hizb\Syshab\Builder\DepartementBuilder;

        //                     $show_depar = $qbDepar->show_by_kode($value2->departemen_kode)->get()->getRow();
        //                     if ($show_depar) {
        //                         $depar_name = $show_depar->NmDepar;
        //                     }

        //                     $divisi[$key2]->depar_name = $depar_name;

        //                 }
                        
        //             }
        //             $rows[$key]->divisi_terkait = $divisi;
        //         }
        //     }
        // }

        $response = $this->qHelp->respon($rows, $count, $total);
        // $anydate      = $this->request->getJsonVar('anydate');
        // if ($anydate) {
        //     $response = $anydate;
        // }else{
        //     $response = null;
        // }
        return $this->respond($response, 200);
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
        $activity_type = $this->request->getJsonVar('activity_type');
        $workorder = $this->request->getJsonVar('workorder');
        $jobtype = $this->request->getJsonVar('jobtype');
        $operation = $this->request->getJsonVar('operation');
        $workstart = $this->request->getJsonVar('workstart');
        $workend = $this->request->getJsonVar('workend');
        $duration = $this->request->getJsonVar('duration');
        $remark = $this->request->getJsonVar('remark');
        $jobdesc = $this->request->getJsonVar('jobdesc');

        $payload = [
            "user" => $this->identity->username(),
            "site" => $this->identity->c04_project_area_kode(),
            "activity_type" => $activity_type,
            "workorder" => $workorder,
            "jobtype" => $jobtype,
            "operation" => $operation,
            "workstart" => $workstart,
            "workend" => $workend,
            "duration" => $duration,
            "remark" => $remark,
            "jobdesc" => $jobdesc
        ];

        $builder = $this->qBuilder->insert($payload);

        return $this->respond($this->qHelp->rescr($builder), 200);
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
        $validation = $this->qVal->update($id);
        if($validation) return $this->respond($validation, 200);

        $payload = [];

        $insident_classification = $this->request->getVar('insident_classification');
        $site = $this->request->getVar('site');
        // $divisi = $this->request->getVar('divisi');
        // $departemen = $this->request->getVar('departemen');
        // $section = $this->request->getVar('section');

        $hari_kejadian = $this->request->getVar('hari_kejadian');
        $tanggal_kejadian = $this->request->getVar('tanggal_kejadian');
        $waktu_kejadian = $this->request->getVar('waktu_kejadian');
        $tanggal_pelaporan = $this->request->getVar('tanggal_pelaporan');
        $waktu_pelaporan = $this->request->getVar('waktu_pelaporan');

        $shift_kerja = $this->request->getVar('shift_kerja');
        $mulai_shift = $this->request->getVar('mulai_shift');
        $selesai_shift = $this->request->getVar('selesai_shift');
        $hari_kerja_ke = $this->request->getVar('hari_kerja_ke');

        $lokasi_insiden_id = $this->request->getVar('lokasi_insiden_id');
        $lokasi_insiden = $this->request->getVar('lokasi_insiden');
        $detail_lokasi_insiden = $this->request->getVar('detail_lokasi_insiden');

        $cidera_id = $this->request->getVar('cidera_id');
        $cidera = $this->request->getVar('cidera');
        $detail_cidera_lainnya = $this->request->getVar('detail_cidera_lainnya');
        $kronologi = $this->request->getVar('kronologi');

        $instansi_pemerintah = $this->request->getVar('instansi_pemerintah');
        $nama_pejabat = $this->request->getVar('nama_pejabat');
        $pemerintah_disampaikan_oleh = $this->request->getVar('pemerintah_disampaikan_oleh');
        $pemerintah_tanggal = $this->request->getVar('pemerintah_tanggal');

        $asuransi = $this->request->getVar('asuransi');
        $nama_perusahaan = $this->request->getVar('nama_perusahaan');
        $asuransi_disampaikan_oleh = $this->request->getVar('asuransi_disampaikan_oleh');
        $asuransi_tanggal = $this->request->getVar('asuransi_tanggal');

        $pihak_tiga = $this->request->getVar('pihak_tiga');
        $nama_pihak_ketiga = $this->request->getVar('nama_pihak_ketiga');
        $pihak_tiga_disampaikan_oleh = $this->request->getVar('pihak_tiga_disampaikan_oleh');
        $pihak_tiga_tanggal = $this->request->getVar('pihak_tiga_tanggal');

        $tipe_insiden_id = $this->request->getVar('tipe_insiden_id');
        $tipe_insiden = $this->request->getVar('tipe_insiden');
        $penjelasan_insiden = $this->request->getVar('penjelasan_insiden');

        /*set to payload*/
        if(isset($insident_classification)) $payload["insident_classification"] = $insident_classification;
        if(isset($site)) $payload["site"] = $site;
        // if(isset($divisi)) $payload["divisi"] = $divisi;
        // if(isset($departemen)) $payload["departemen"] = $departemen;
        // if(isset($section)) $payload["section"] = $section;

        if(isset($hari_kejadian)) $payload["hari_kejadian"] = $hari_kejadian;
        if(isset($tanggal_kejadian)) $payload["tanggal_kejadian"] = $tanggal_kejadian;
        if(isset($waktu_kejadian)) $payload["waktu_kejadian"] = $waktu_kejadian;
        if(isset($tanggal_pelaporan)) $payload["tanggal_pelaporan"] = $tanggal_pelaporan;
        if(isset($waktu_pelaporan)) $payload["waktu_pelaporan"] = $waktu_pelaporan;

        if(isset($shift_kerja)) $payload["shift_kerja"] = $shift_kerja;
        if(isset($mulai_shift)) $payload["mulai_shift"] = $mulai_shift;
        if(isset($selesai_shift)) $payload["selesai_shift"] = $selesai_shift;
        if(isset($hari_kerja_ke)) $payload["hari_kerja_ke"] = $hari_kerja_ke;

        if(isset($lokasi_insiden_id)) $payload["lokasi_insiden_id"] = (isset($lokasi_insiden_id) and $lokasi_insiden_id != "") ? $lokasi_insiden_id : null;
        if(isset($lokasi_insiden)) $payload["lokasi_insiden"] = $lokasi_insiden;
        if(isset($detail_lokasi_insiden)) $payload["detail_lokasi_insiden"] = $detail_lokasi_insiden;

        if(isset($cidera_id)) $payload["cidera_id"] = (isset($cidera_id) and $cidera_id != "") ? $cidera_id : null;
        if(isset($cidera)) $payload["cidera"] = $cidera;
        if(isset($detail_cidera_lainnya)) $payload["detail_cidera_lainnya"] = $detail_cidera_lainnya;
        if(isset($kronologi)) $payload["kronologi"] = $kronologi;

        if(isset($instansi_pemerintah)) $payload["instansi_pemerintah"] = (isset($instansi_pemerintah) and $instansi_pemerintah != "") ? $instansi_pemerintah : null;
        if(isset($nama_pejabat)) $payload["nama_pejabat"] = (isset($nama_pejabat) and $nama_pejabat != "" and $instansi_pemerintah != "") ? $nama_pejabat : null;
        if(isset($pemerintah_disampaikan_oleh)) $payload["pemerintah_disampaikan_oleh"] = (isset($pemerintah_disampaikan_oleh) and $pemerintah_disampaikan_oleh != "" and $instansi_pemerintah != "") ? $pemerintah_disampaikan_oleh : null;;
        if(isset($pemerintah_tanggal)) $payload["pemerintah_tanggal"] = (isset($pemerintah_tanggal) and $pemerintah_tanggal != "" and $instansi_pemerintah != "") ? $pemerintah_tanggal : null;;

        if(isset($asuransi)) $payload["asuransi"] = (isset($asuransi) and $asuransi != "") ? $asuransi : null;
        if(isset($nama_perusahaan)) $payload["nama_perusahaan"] = (isset($nama_perusahaan) and $nama_perusahaan != "" and $asuransi != "") ? $nama_perusahaan : null;
        if(isset($asuransi_disampaikan_oleh)) $payload["asuransi_disampaikan_oleh"] = (isset($asuransi_disampaikan_oleh) and $asuransi_disampaikan_oleh != "" and $asuransi != "") ? $asuransi_disampaikan_oleh : null;
        if(isset($asuransi_tanggal)) $payload["asuransi_tanggal"] = (isset($asuransi_tanggal) and $asuransi_tanggal != "" and $asuransi != "") ? $asuransi_tanggal : null;

        if(isset($pihak_tiga)) $payload["pihak_tiga"] = (isset($pihak_tiga) and $pihak_tiga != "") ? $pihak_tiga : null;
        if(isset($nama_pihak_ketiga)) $payload["nama_pihak_ketiga"] = (isset($nama_pihak_ketiga) and $nama_pihak_ketiga != "" and $pihak_tiga != "") ? $nama_pihak_ketiga : null;
        if(isset($pihak_tiga_disampaikan_oleh)) $payload["pihak_tiga_disampaikan_oleh"] = (isset($pihak_tiga_disampaikan_oleh) and $pihak_tiga_disampaikan_oleh != "" and $pihak_tiga != "") ? $pihak_tiga_disampaikan_oleh : null;
        if(isset($pihak_tiga_tanggal)) $payload["pihak_tiga_tanggal"] = (isset($pihak_tiga_tanggal) and $pihak_tiga_tanggal != "" and $pihak_tiga != "") ? $pihak_tiga_tanggal : null;

        if(isset($tipe_insiden_id)) $payload["tipe_insiden_id"] = (isset($tipe_insiden_id) and $tipe_insiden_id != "") ? $tipe_insiden_id : null;
        if(isset($tipe_insiden)) $payload["tipe_insiden"] = (isset($tipe_insiden) and $tipe_insiden != "") ? $tipe_insiden : null;
        if(isset($penjelasan_insiden)) $payload["penjelasan_insiden"] = (isset($penjelasan_insiden) and $penjelasan_insiden != "") ? $penjelasan_insiden : null;
        
        $builder = $this->qBuilder->update($id, $payload);

        $payload['orang_terlibat'] = $this->update_orangTerlibat($id);        
        $payload['kerusakan_payload'] = $this->update_kerusakan($id);

        /*if(isset($item_category_id)) $payload["item_category_id"] = $item_category_id;
        if(isset($received_at)) $payload["received_at"] = $received_at;
        if(isset($installed_at)) $payload["installed_at"] = $installed_at;
        if(isset($problem_category_id)) $payload["problem_category_id"] = $problem_category_id;
        if(isset($fekb_number)) $payload["fekb_number"] = $fekb_number;
        if(isset($description)) $payload["description"] = $description;
        if(isset($report_by_name)) $payload["report_by_name"] = $report_by_name;
        if(isset($remark)) $payload["remark"] = $remark;
        if(isset($action)) $payload["action"] = $action;
        if(isset($status_id)) $payload["status_id"] = $status_id;*/

        // $payload2["goodseval_id"] = $id;
        // if(isset($remark)) $payload2["remark"] = $remark;
        // if(isset($action)) $payload2["action"] = $action;
        // if(isset($status_id)) $payload2["status_id"] = $status_id;


        /*$validation = $this->qVal->update($id);
        if ($validation)
            return $this->respond([
                "status"    => false,
                "message"   => 'Validation error!',
                "errors"    => $validation,
                "rows"      => [],
            ],200);*/


        if ($builder) {
            $response = array(
                "status"    => true,
                "message"   => "Updaate data success.",
                "response"  => $builder,
                "errors"    => null
            );
        }else{
            $response = array(
                "status"    => false,
                "message"   => "Updaate data failed.",
                "response"  => $builder,
                "errors"    => null
            );
        }

        return $this->respond($response, 200);
    }

    public function approve($id)
    {
        $actual_duration = $this->request->getJsonVar('actual_duration');
        $remark = $this->request->getJsonVar('remark');
        $user = $this->identity->username();

        $payload = [
            "actual_duration" => $actual_duration,
            "remark" => $remark,
            "approved_by_text" => $user,
            "approved_at" => date('Y-m-d H:i:s'),
            "appr_status_id" => 1
        ];

        $builder = $this->qBuilder->update($id, $payload);

        return $this->respond($this->qHelp->resapv($builder), 200);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $builder = $this->qBuilder->delete($id);
        if ($builder) {
            $response = [
                "status" => true,
                "message" => "Delete success.",
            ];
            $rescod = 200;
        } else {
            $response = [
                "status" => false,
                "message" => "Delete error.",
            ];
            $rescod = 200;
        }

        return $this->respond($response, $rescod);
    }
}
